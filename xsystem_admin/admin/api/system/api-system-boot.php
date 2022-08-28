<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-htaccess.php';
require_once XSYSTEM_ADMIN_APP_DIR . 'class/class-admin.php';
$htaccess = new Htaccess();
$adminIns = new Admin();
if(isset($_POST['apps'])){
    $apps = $_POST['apps'];
}else{
    $apps = array();
}

$htaccess->update_app_htaccess($apps);

$sql = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_common/sql/xsystem_app.sql';
if(file_exists($sql)){
    $sql = file_get_contents($sql);
    $adminIns->create_table($sql);
}

foreach($apps as $app){
    $sql = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_app/' . $app . '/sql/xsystem_app.sql';
    if(file_exists($sql)){
        $sql = str_replace('xsystem_app', $app, file_get_contents($sql)) ;
        $adminIns->create_table($sql);
    }
}

$data['msg'] = '設定しました。';

$data['status'] = 1;

echo json_encode($data);

?>