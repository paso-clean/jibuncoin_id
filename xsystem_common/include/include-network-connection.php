<?php
require_once XSYSTEM_COMMON_DIR .'class/class-network.php';
$networkIns = new Network();

$networkIns->delete_expired_session(XSYSTEM_PRODUCT);

$cmd = $url_param[4];


if($cmd == 'call_back'){
    $data_type = $url_param[5];
    $session_name = $url_param[6];
    $session_code = $url_param[7];
    $base64 = $url_param[8];
    
    $param = xsystem_base64_decode($base64);
    
    $connection = $param['connection'];
    $url = $connection . 'data/' . $data_type . '/' . $session_name . '/' . $session_code . '/';
    
    $data = xsystem_curl($url);
    
    $networkIns->connection_network($data);

    $res['status'] = 1;
    
    echo json_encode($res);
    
}elseif($cmd == 'data'){
    $data_type = $url_param[5];
    $session_name = $url_param[6];
    $session_code = $url_param[7];
    if($session = $networkIns->get_common_session($session_code)){

        $network = $networkIns->get_network($session['target_code']);
        $network['servers'] = $networkIns->get_network_servers($network['network_code']);
        
        echo json_encode($network);
    }
    
}


?>