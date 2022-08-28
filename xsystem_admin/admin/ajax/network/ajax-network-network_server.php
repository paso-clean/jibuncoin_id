<?php 
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';
$networkIns = new Network();

$network_code = $_POST['network_code'];
$network = $networkIns->get_network($network_code);
$network_type = $network['network_type'];

$servers = $networkIns->get_servers();


foreach($servers as $server){
    if($server['server_type'] == $network_type){
        $url = $server['domain'] . 'api/network/info/';
        $info = xsystem_curl($url);
        echo '<div class="content-block" style="padding:0;">';
        echo '<table style="width:100%;">';
        echo '<tr>';
        echo '<td style="width:80px;height:80px"><div style="text-align:center;"><img src="' . $info['icon'] . '" style="width:60px;height:60px;border-radius:5px;"></div></td>';
        echo '<td style="padding-left:20px;">';
        echo '<div style="font-size:20px;margin-top:5px;font-weight:bold;color:#357ebd;">';
        echo $server['server_name'];
        echo '</div>';
        echo '<div>' . $server['domain'] . '</div>';
        echo '</td>';
        echo '<td style="width:110px;text-align:center;">';
        echo '<div>';
        echo '<div class="btn btn-sm btn-primary btn-api" data-cmd="add" data-done="form_done" data-url="' . XSYSTEM_ADMIN_URL . 'api/network/network_server/' . $network_code . '/' . $server['server_code'] . '/">追加</div> ';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
    }
}

?>