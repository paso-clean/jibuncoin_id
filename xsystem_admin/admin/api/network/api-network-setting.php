<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';
$networkIns = new Network();


if (isset($_POST['delete'])) {
    $data['status'] = $_POST['delete'];
    $data['status'] = $networkIns->delete_network($_POST['server_code']);
    if ($data['status']) {
        $data['msg'] = 'サーバーの登録が削除されました。';
//         $data['msg'] = $_POST['server_code'];
    }
    echo json_encode($data);
    exit;
}

if(isset($_POST['network_code']) && $_POST['network_code'] != ''){
    $network_code = $networkIns->edit_network($_POST);
}else{
    $network_code = $networkIns->add_network($_POST);
}


$servers = $networkIns->get_network_servers($network_code);
$session_name = xsystem_random_num(16);
$session_code = xsystem_random_code(16);
$session = $networkIns->create_network_session($session_name,$session_code,'connection','network',$network_code,'',1);

$param['connection'] = XSYSTEM_COMMON_URL . 'api/network/connection/';
$base64 = xsystem_base64_encode($param);
foreach($servers as $server){
    $domain = $server['domain'];
    $url = $domain . 'api/network/connection/call_back/network/' . $session_name . '/' . $session_code . '/' . $base64 . '/';
    xsystem_curl($url);
}

$msg = 'ネットワークを作成しました。';

$data['status'] = 1;
$data['msg'] = $msg;

echo json_encode($data);

?>