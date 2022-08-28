<?php 

$data['app_name'] = 'ジブンID';
$data['icon'] = APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/asset/img/logo.png';
$data['entry'] = XSYSTEM_APP_URL . 'api/connection/entry/';
$data['id'] = XSYSTEM_APP_URL . 'ajax/connection/id/';

echo json_encode($data);



?>