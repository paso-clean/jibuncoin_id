<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';
$networkIns = new Network();

$servers = $networkIns->get_servers();


?>
<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_ADMIN_URL; ?>ajax/network/server_profile/" style="width:100%;border:1px solid #ddd;color:#357ebd;background:#fff;">
<tr data-user_code="">
<td style="width:120px"><div style="margin:20px 30px 20px 30px;font-size:40px;"><i class="fa-solid fa-server"></i></div></td>
<td>
<div style="font-size:13px;color:#357ebd;"></div>
<div style="font-size:24px;font-weight:bold;">サーバー登録</div>
</td>
</tr>
</table>

<div>&nbsp;</div>

<?php 
foreach($servers as $server){
    $url = $server['domain'] . 'api/network/info/';
    $info = xsystem_curl($url);
    echo '<div class="content-block" style="padding:0;">';
    echo '<table style="width:100%;">';
    echo '<tr>';
    echo '<td style="width:80px;height:80px"><div style="text-align:center;"><img src="' . $info['icon'] . '" style="width:60px;height:60px;border-radius:5px;"></div></td>';
    echo '<td style="padding-left:20px;">';
    echo '<div style="font-size:20px;margin-top:5px;font-weight:bold;color:#357ebd;">';
    echo $server['server_name'];
    echo '<div>';
    echo '</td>';
    echo '<td style="width:110px;text-align:center;">';
    echo '<div>';
    echo '<div class="btn btn-sm btn-success btn-ajax" data-server_code="' . $server['server_code'] . '" data-url="' . XSYSTEM_ADMIN_URL . 'ajax/network/server_profile/' . $server['server_code'] . '/">編集</div> ';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}

?>