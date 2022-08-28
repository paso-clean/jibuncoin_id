<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

$session_name = $url_param[4];
$session_code = $url_param[5];
$security_code = $url_param[6];
// $userIns->create_request_security_session($user,$session_name,$session_code);
$userIns->create_request_security_session('id_linkage',$user,$session_name,$session_code);
// $userIns->create_response_security_session('id_linkage',$session_name,$session_code);

$url = XSYSTEM_APP_URL . 'api/id/jibun_id_security_request/' . $session_name . '/' . $security_code . '/';
$img = APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $_COOKIE['app_name'] . '/asset/img/loading_img.png';

?>
<div class="content-block" style="text-align:center;padding:20px;">
<div><img class="loading-img" src="<?php echo $img; ?>"></div>
<div><div class="tag active"><?php echo $session_name; ?></div></div>
<div style="padding:10px;">
<div class="btn btn-primary btn-lg btn-api" data-done="alert" data-url="<?php echo $url; ?>">ジブンIDと連携</div>
</div>
</div>