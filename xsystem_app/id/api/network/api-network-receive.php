<?php






$app_name = basename(dirname(dirname(dirname(__FILE__))));
if (!defined('XSYSTEM_ASSET_URL')) {
	define('XSYSTEM_ASSET_URL', APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $app_name . '/asset/');
}
if (!defined('XSYSTEM_APP_URL')) {
	define('XSYSTEM_APP_URL', APP_URL . $app_name . '/');
}
if (!defined('XSYSTEM_APP_DIR')) {
	define('XSYSTEM_APP_DIR', XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/' . $app_name . '/');
}
require_once XSYSTEM_APP_DIR . 'class/class-sotauth.php';
$sotauthIns = new Sotauth();

$session_name = $url_param[4];
$security_code = $url_param[5];
$json = base64_decode($url_param[6]);
$data = json_decode($json,true);
$entry = $data['entry'];

$sotauthIns->set_linkage_session_security($session_name,$security_code,$data);

$tmp['entry'] = APP_URL . 'api/jibun_id/entry/';
//$data['url'] = APP_URL . $session_name . '/' . $security_code . '/';
$json = json_encode($tmp);
$base64 = base64_encode($json);

$url = $entry . 'security/' . $session_name . '/' . $security_code . '/' . $base64 . '/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$res =  curl_exec($ch);
$json = json_decode($res, true);
curl_close($ch);

// ID_linkage---------------------
$cmd = 'id_linkage';
$session_code = $sotauthIns->get_session_by_target($security_code);

$url = $entry . $cmd . '/' . $session_name . '/' . $session_code . '/';


$json = file_get_contents($url);
$user = json_decode($json,true);

$target_img_url = $user['img_url'];

$user_code = $sotauthIns->user_id_linkage($user);


$objects = $user['objects'];
$user_img_dir = XSYSTEM_DIR . 'img/user/';
$origin_dir = $user_img_dir . 'origin/';
$thum_dir = $user_img_dir . 'thum/';

if(!file_exists($user_img_dir)){
    mkdir($user_img_dir, 0755);
}

if(!file_exists($origin_dir)){
    mkdir($origin_dir, 0755);
}

if(!file_exists($thum_dir)){
    mkdir($thum_dir, 0755);
}

$target_origin_img = $target_img_url . 'user/origin/' . $objects['user_img'][0]['object'];
$origin_img = @file_get_contents( $target_origin_img );
if($origin_img){
    @file_put_contents( $origin_dir . $objects['user_img'][0]['object'], $origin_img );
}


$target_thum_img = $target_img_url . 'user/thum/' . $objects['user_img'][0]['object'];
$thum_img = @file_get_contents( $target_thum_img );
if($thum_img){
    @file_put_contents( $thum_dir . $objects['user_img'][0]['object'], $thum_img );
}

$sotauthIns->delete_session_by_name($session_name,$cmd);

//--------------------------------

$data['status'] = true;
echo json_encode($data);

?>