<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);
$user_session = $userIns->get_session($_COOKIE['xsystem_app_session']);
$form_id = xsystem_random_num(10);

// $userIns->delete_linkage_session($user_session['session_name']);

$session_name = $user_session['session_name'];
$session_code = xsystem_random_code(16);
$security_code = xsystem_random_code(16);

$userIns->delete_session_by_name($session_name,'id_linkage');

$id_node = $jibun_id_node[0] . 'ajax/jibun_id/terms/' . $session_name . '/' . $session_code . '/';

$ajax = @file_get_contents($id_node);
echo $ajax;
?>
<div id="url-<?php echo $session_name; ?>" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/id/security_request/<?php echo $session_name; ?>/<?php echo $session_code; ?>/<?php echo $security_code; ?>/" class="content-block" style="text-align:center;padding:20px;display:none;"></div>

