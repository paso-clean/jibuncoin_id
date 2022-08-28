<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';
$networkIns = new Network();


$networks = $networkIns->get_active_networks();




foreach($networks as $network){
    $icon = '';
    echo '<div class="content-block" style="padding:0;">';
    echo '<table class="pointer btn-ajax"';
    echo 'data-url="' . XSYSTEM_APP_URL . 'ajax/network/component/"';
    echo 'data-server_code="' . $network['network_code'] . '" ';
    echo 'style="width:100%;border:1px solid #fff;background:#fff;">';
    echo '<tr>';
    echo '<td style="width:80px;height:80px;"><div style="font-size:40px;text-align:center;"><img src="' . $icon . '?p=' . xsystem_random_num(10) . '" style="width:60px;height:60px;"></div></td>';
    echo '<td style="padding-left:20px;">';
    echo '<div style="font-size:24px;font-weight:bold;color:#357ebd;">' . $network['network_name'] . '</div>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}



// $servers = $networkIns->get_servers();

// foreach($servers as $server){
//     $url = $server['domain']. 'api/network/info/';
//     $json = file_get_contents($url);
//     $data = json_decode($json,true);
//     echo '<div class="content-block" style="padding:0;">';
//     echo '<table class="pointer btn-ajax"';
//     echo 'data-url="' . XSYSTEM_APP_URL . 'ajax/network/component/"';
//     echo 'data-server_code="' . $server['server_code'] . '" ';
//     echo 'style="width:100%;border:1px solid #fff;background:#fff;">';
//     echo '<tr>';
//     echo '<td style="width:80px;height:80px;"><div style="font-size:40px;text-align:center;"><img src="' . $data['icon'] . '?p=' . xsystem_random_num(10) . '" style="width:60px;height:60px;"></div></td>';
//     echo '<td style="padding-left:20px;">';
//     echo '<div style="font-size:24px;font-weight:bold;color:#357ebd;">' . $data['server_name'] . '</div>';
//     echo '</td>';
//     echo '</tr>';
//     echo '</table>';
//     echo '</div>';
// }

?>