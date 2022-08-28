<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';
$networkIns = new Network();


if (isset($_POST['delete'])) {
    $data['status'] = $_POST['delete'];
    $data['status'] = $networkIns->delete_server($_POST['server_code']);
    if ($data['status']) {
//         $data['msg'] = 'サーバーの登録が削除されました。';
        $data['msg'] = $_POST['server_code'];
    }
    echo json_encode($data);
    exit;
}


$domain = xsystem_domain($_POST['domain']);

$url = $domain . 'api/network/info/';

$server = xsystem_curl($url);


if(isset($server['entry']) && $server['entry'] != ''){
    
    if(isset($_POST['server_code']) && $_POST['server_code'] != ''){
        $server_code = $_POST['server_code'];
        $networkIns->edit_server($server_code,$server);
        $msg = '更新しました。';
        
    }else{
        $networkIns->add_server($server);
        $msg = '登録しました。';
    }
}else{
    $msg = '登録できませんでした。';
}



$data['status'] = 1;
$data['msg'] = $msg;

echo json_encode($data);

?>