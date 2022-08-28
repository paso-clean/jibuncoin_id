<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';
$networkIns = new Network();

$network_code = $url_param[4];
$server_code = $url_param[5];

if(!isset($url_param[4]) || !isset($url_param[5])){
    $data['status'] = 0;
    $data['msg'] = 'error';
    echo json_encode($data);
    exsit;
}

$cmd = $_POST['cmd'];

if($cmd == 'add'){
    
    $networkIns->set_network_server($network_code, $server_code);
    $server = $networkIns->get_server($server_code);
    
    $session_name = xsystem_random_num(16);
    $session_code = xsystem_random_code(16);
    $session_type = 'connection';
    $target_type = 'network';
    $target_code = $network_code;
    $domain = $server['domain'];
    
    $networkIns->create_network_session($session_name,$session_code,$session_type,$target_type,$target_code,$domain,1);
    $param['connection'] = XSYSTEM_COMMON_URL . 'api/network/connection/';
    $base64 = xsystem_base64_encode($param);
    
    $servers = $networkIns->get_network_servers($network_code);
    foreach($servers as $server){
        $domain = $server['domain'];
        $url = $domain . 'api/network/connection/call_back/network/' . $session_name . '/' . $session_code . '/' . $base64 . '/';
        xsystem_curl($url);
    }
}elseif($cmd == 'delete'){
    $server = $networkIns->get_server($server_code);
    $session_name = xsystem_random_num(16);
    $session_code = xsystem_random_code(16);
    $session_type = 'connection';
    $target_type = 'network';
    $target_code = $network_code;
    $domain = $server['domain'];
    $networkIns->create_network_session($session_name,$session_code,$session_type,$target_type,$target_code,$domain,1);
    $param['connection'] = XSYSTEM_COMMON_URL . 'api/network/connection/';
    $base64 = xsystem_base64_encode($param);
    
    $servers = $networkIns->get_network_servers($network_code);
    
    $networkIns->delete_network_server($network_code, $server_code);
    
    foreach($servers as $server){
        $domain = $server['domain'];
        $url = $domain . 'api/network/connection/call_back/network/' . $session_name . '/' . $session_code . '/' . $base64 . '/';
        xsystem_curl($url);
    }
}

$msg = 'サーバーを追加しました。';

$data['status'] = 1;
$data['msg'] = $msg;

echo json_encode($data);

?>