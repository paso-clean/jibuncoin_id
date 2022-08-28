<?php
set_time_limit(12000);
@session_start();
require_once '../../xsystem-config.php';
require_once XSYSTEM_COMMON_DIR . 'include/include-function.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-htaccess.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-db.php';


$app_name = get_app_name(dirname(__FILE__),XSYSTEM_DIR . XSYSTEM_PRODUCT . '_admin/');
$url_param = url_param($_SERVER['REQUEST_URI'],APP_URI);
$url_param[0] = str_replace(XSYSTEM_PRODUCT . '_','',$url_param[0]);
// for($i=0;$i<count($url_param);$i++){
// 	echo $url_param[$i] . '<br>';
// }
// exit;

$logged_in_key = 'wordpress_logged_in_' . md5(rtrim(APP_URL,'/'));

// unset($_SESSION['xsystem_admin_user']);
// unset($_SESSION['xsystem_admin_session']);


if(isset($_SESSION['xsystem_admin_session']) && $_SESSION['xsystem_admin_session'] != ""){
	$user_login = $_SESSION['xsystem_admin_user'];
}elseif(isset($_COOKIE[$logged_in_key] ) && $_COOKIE[$logged_in_key] != ''){
	$user_login = $url_param[3];
	$wp_hash = $url_param[4];
	$hash = $hash = hash_hmac('sha256', $_COOKIE[$logged_in_key], $user_login); 
	if($hash == $wp_hash){
		$_SESSION['xsystem_admin_user'] = $user_login;
		$_SESSION['xsystem_admin_session'] = $hash;
	}else{
		unset($_SESSION['xsystem_admin_user']);
		unset($_SESSION['xsystem_admin_session']);
		echo 'error.';
		exit;
	}
}else{
	unset($_SESSION['xsystem_admin_user']);
	unset($_SESSION['xsystem_admin_session']);
	echo 'error.';
	exit;
}

define('XSYSTEM_APP', XSYSTEM_PRODUCT);
define('XSYSTEM_ADMIN_APP_URL', APP_URL  . XSYSTEM_PRODUCT . '_admin/'. $url_param[0] . '/');
define('XSYSTEM_ADMIN_ASSET_URL', APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_admin/' . $url_param[0] . '/asset/');
define('XSYSTEM_ADMIN_APP_DIR', ABSPATH  . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_admin/' . $url_param[0] . '/' );

$htaccess = new Htaccess();
$active_apps = $htaccess->active_apps();
$dirs = scandir(XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/');
$excludes = array(
    '.',
    '..',
    '.htaccess',
);

$apps = array();
$boot_apps = array();
foreach ($dirs AS $dir) {
    if (in_array($dir, $excludes)) {
        continue;
    }

    $dir_path = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/' . $dir;
    if (is_dir($dir_path)) {
      foreach($active_apps as $active_app){
        if($dir == $active_app){
          $require_file = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/' . $dir . '/xsystem-admin-app-config.php';
          if(file_exists($require_file)){
            require_once $require_file;
          }
        }

      }
    }
}
// require_once XSYSTEM_COMMON_DIR . 'include/include-admin-init.php';

Db::init();

if($url_param[1] == 'ajax' || $url_param[1] == 'api'){
    if(isset($url_param[2]) || isset($url_param[3])){
        if($url_param[2] == 'common'){
            $require_file = XSYSTEM_COMMON_DIR . $url_param[1] .'/' . $url_param[1] .'-' . $url_param[2] . '-' . $url_param[3] . '.php';
        }else{
            $require_file = XSYSTEM_ADMIN_APP_DIR . $url_param[1] . '/' . $url_param[2] . '/' . $url_param[1] . '-' . $url_param[2] . '-' . $url_param[3] . '.php';
        }
    }else{
        $require_file = XSYSTEM_ADMIN_APP_DIR . 'page/page-error-404.php';
    }
}elseif(!isset($url_param[1]) || $url_param[1] == ''){
    $require_file = XSYSTEM_ADMIN_APP_DIR . 'page/page-index.php';
}else{
    if(!isset($url_param[2]) || $url_param[2] == ''){
        $require_file = XSYSTEM_ADMIN_APP_DIR . 'page/' . $url_param[1] . '/' . 'page-' . $url_param[1] . '-index.php';
    }else{
        $require_file = XSYSTEM_ADMIN_APP_DIR . 'page/' . $url_param[1] . '/' . 'page-' . $url_param[1] . '-' . $url_param[2] . '.php';
    }
}

// echo $require_file;
// exit;


// if (!file_exists($require_file)) {
//     header("HTTP/1.1 404 Not Found");
//     $redirect = XSYSTEM_APP_URL . 'error/404/';
//     header("Location: $redirect");
// 	exit;
// }

require_once $require_file;



?>