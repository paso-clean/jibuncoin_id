<?php 

$data['server_name'] = 'ジブンID';
$data['server_type'] = 'id';
$data['domain'] = XSYSTEM_APP_URL;
$data['icon'] = APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/asset/img/logo.png';
$data['email'] = 'info@sotauth.com';
$data['connection'] = XSYSTEM_APP_URL . 'api/network/connection/';
$data['entry'] = XSYSTEM_APP_URL . 'api/network/entry/';
$data['component_unit'] = XSYSTEM_APP_URL . 'ajax/network/component_unit/';

echo json_encode($data);



?>