<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';

if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
    //     $redirect = XSYSTEM_APP_URL . 'login/';
    //     header("Location: $redirect");
    echo 'error.';
    exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_' . XSYSTEM_APP . '_session']);

// $session_name = xsystem_random_num(16);
// $session_code = xsystem_random_code(16);
// $security_code = xsystem_random_code(16);

$linkage_entry = $_POST['entry'];

$networkIns = new Network();

$server = $networkIns->get_server_by_type('security');



$security_entry = $server['domain'] . 'api/network/entry/';




$linkage_session = $userIns->create_session('linkage','user',$user['user_code'],0);
$security_session = $userIns->create_security_session($linkage_session['session_name'],'linkage',$linkage_session['session_code'],0);

$param['entry'] =  XSYSTEM_APP_URL . 'api/network/entry/';
$json = json_encode($param);
$base64 = base64_encode($json);

$res_entry = $linkage_entry;

$linkage_entry = $linkage_entry . 'request/linkage/' . $linkage_session['session_name'] . '/' . $linkage_session['session_code'] . '/' . $base64 . '/';
xsystem_curl($linkage_entry);


$param['entry'] =  XSYSTEM_APP_URL . 'api/network/entry/';
$param['linkage_entry'] =  $res_entry;
$json = json_encode($param);
$base64 = base64_encode($json);

$security_entry = $security_entry . 'request/agent/' . $security_session['session_name'] . '/' . $security_session['session_code'] . '/' . $base64 . '/';
xsystem_curl($security_entry);


echo '<div class="content-block" style="text-align:center;padding:20px;">';
echo '<div class="btn btn-primary btn-lg btn-api"';
echo 'data-url="' . XSYSTEM_APP_URL . 'api/network/transport/"';
echo 'data-done="refresh_done"';
echo 'data-session_name="' . $linkage_session['session_name'] . '"';
echo 'data-session_code="' . $linkage_session['session_code'] . '"';
echo 'data-entity_type="user"';
echo 'data-entry="' . $res_entry . '"';
echo '>';
echo 'データ連携';
echo '</div>';
echo '</div>';







?>