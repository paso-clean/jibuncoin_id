<?php 

$data['server_name'] = 'ジブンセキュリティ';
$data['server_type'] = 'security';
$data['domain'] = XSYSTEM_APP_URL;
$data['icon'] = APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/asset/img/logo.png';
$data['email'] = 'info@sotauth.com';
$data['entry'] = XSYSTEM_APP_URL . 'api/network/entry/';
$data['security'] = XSYSTEM_APP_URL . 'ajax/network/security/';

echo json_encode($data);



?>