<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';

$userIns = new User();
$networkIns = new Network();

$server = $networkIns->get_server_by_type('security');

$session_code = $url_param[4];
$sessions = $userIns->get_security_sessions($session_code);
$session_name = $sessions[0]['session_name'];
$security_code = $sessions[0]['session_code'];
$param['entry'] = XSYSTEM_APP_URL . 'api/id/entry/';
$json = json_encode($param);
$base64 = base64_encode($json);
$sotauth_url = $server['domain'] . 'security/authorization/' . $session_name . '/' . $security_code . '/' . $base64 . '/';
?>
<div class="text-center">
<iframe id="iframe" frameborder="0"  style="width:90%;height:400px;border-radius:10px;"  src="<?php echo $sotauth_url; ?>">
</iframe>
<div style="padding:30px;word-break: break-all;text-align:center;"><a href="<?php echo $sotauth_url; ?>" target="_blank"><?php echo $sotauth_url; ?></a></div>
<div>
