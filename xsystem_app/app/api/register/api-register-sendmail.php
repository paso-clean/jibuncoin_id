<?php
require_once XSYSTEM_APP_DIR . 'class/class-register.php';
$register = new Register();
$code = $register->post($_SESSION);

$onetime_url = APP_URL . $_COOKIE['app_name'] . '/register/onetime/' . $code . '/';

$data['target'] = $_POST['target'];
$data['content'] = $onetime_url;



echo json_encode($data);
exit;

?>