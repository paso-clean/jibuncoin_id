<?php
require_once XSYSTEM_COMMON_DIR . '/class/class-entity.php';
$entityIns = new Entity();
$data = $_POST;

if(isset($_POST['method']) &&isset($_POST['entity_code']) && isset($_POST['entity_type']) && isset($_POST['object_code'])){
    if($_POST['method'] == 'delete'){
        $data['status'] = $entityIns->delete_object($_POST['entity_code'],$_POST['entity_type'],$_POST['object_code']);
    }
    $data['msg'] = '削除しました。';
    echo json_encode($data);
    exit;
}


$data['status'] = $entityIns->set_object($_POST);
if($data['status']){
    $data['msg'] = '登録しました。';
}else{
    $data['msg'] = '失敗しました。';
}


echo json_encode($data);

?>