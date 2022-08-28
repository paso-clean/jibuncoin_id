<?php
set_time_limit(12000);
@session_start();
require_once '../../xsystem-config.php';
require_once XSYSTEM_COMMON_DIR . 'include/include-function.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-htaccess.php';
require_once  XSYSTEM_COMMON_DIR . 'class/class-db.php';
$app_name = get_app_name(dirname(__FILE__),XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/');
$url_param = url_param($_SERVER['REQUEST_URI'],APP_URI);
define('XSYSTEM_APP', $url_param[0]);
define('XSYSTEM_APP_URL', APP_URL . $url_param[0] . '/');
define('XSYSTEM_ASSET_URL', APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/asset/');
define('XSYSTEM_APP_DIR', ABSPATH  . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/' );
define('XSYSTEM_IMG_URL', APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/img/');
define('XSYSTEM_IMG_DIR', ABSPATH  . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/img/' );

Db::init();


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
$parts = array();

foreach ($dirs AS $dir) {
    if (in_array($dir, $excludes)) {
        continue;
    }

    $dir_path = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/' . $dir;
    if (is_dir($dir_path)) {
      foreach($active_apps as $active_app){
        if($dir == $active_app){
          $require_file = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/' . $dir . '/xsystem-app-config.php';
          if(file_exists($require_file)){
            require_once $require_file;
          }
        }

      }
    }
}

$user_profiles = xsystem_sort($user_profiles);





//require_once XSYSTEM_COMMON_DIR . 'include/include-init.php';


if($url_param[1] == 'ajax' || $url_param[1] == 'api'){
	if(isset($url_param[2]) || isset($url_param[3])){
		if($url_param[2] == 'common'){
			$require_file = XSYSTEM_COMMON_DIR . $url_param[1] .'/' . $url_param[1] .'-' . $url_param[2] . '-' . $url_param[3] . '.php';
		}else{
			$require_file = XSYSTEM_APP_DIR . $url_param[1] . '/' . $url_param[2] . '/' . $url_param[1] . '-' . $url_param[2] . '-' . $url_param[3] . '.php';
		}
	}else{
		$require_file = XSYSTEM_APP_DIR . 'page/page-error-404.php';
	}
}elseif(!isset($url_param[1]) || $url_param[1] == ''){
    setcookie("app_name",$url_param[0],time()+60*60*24*30,APP_URI);
    $require_file = XSYSTEM_APP_DIR . 'page/page-index.php';
}else{
    setcookie("app_name",$url_param[0],time()+60*60*24*30,APP_URI);

	if(!isset($url_param[2]) || $url_param[2] == ''){
		$require_file = XSYSTEM_APP_DIR . 'page/' . $url_param[1] . '/' . 'page-' . $url_param[1] . '-index.php';

	}else{
		$require_file = XSYSTEM_APP_DIR . 'page/' . $url_param[1] . '/' . 'page-' . $url_param[1] . '-' . $url_param[2] . '.php';
	}
}


require_once $require_file;
?>