<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
$userIns = new User();

$userIns->logout($_COOKIE['xsystem_' . XSYSTEM_APP . '_session']);


setcookie("xsystem_app_session", "", time() - 30,APP_URI);


// $data['redirect'] = XSYSTEM_APP_URL . 'login/';
$data['redirect'] = APP_URL . $_COOKIE['app_name'] . '/login/';

echo json_encode($data);

?>