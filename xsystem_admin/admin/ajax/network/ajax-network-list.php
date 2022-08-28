<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';
$networkIns = new Network();

$networks = $networkIns->get_networks();


?>
<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_ADMIN_URL; ?>ajax/network/profile/" style="width:100%;border:1px solid #ddd;color:#357ebd;background:#fff;">
<tr data-user_code="">
<td style="width:120px"><div style="margin:20px 30px 20px 30px;font-size:40px;"><i class="fa-solid fa-diagram-project"></i></div></td>
<td>
<div style="font-size:13px;color:#357ebd;"></div>
<div style="font-size:24px;font-weight:bold;">ネットワーク登録</div>
</td>
</tr>
</table>

<div>&nbsp;</div>

<?php 
foreach($networks as $network){
    if($network['network_type'] == 'id'){
        $icon = XSYSTEM_COMMON_ASSET_URL . 'img/jibun_id.png';
    }elseif($network['network_type'] == 'security'){
        $icon = XSYSTEM_COMMON_ASSET_URL . 'img/security.png';
    }else{
        $icon = XSYSTEM_COMMON_ASSET_URL . 'img/coin.png';
    }
    if($network['active'] == 0){
        $inactive = 'inactive';
    }else{
        $inactive = '';
    }
    echo '<div class="content-block ' . $inactive . '" style="padding:0;">';
    echo '<table style="width:100%;">';
    echo '<tr>';
    echo '<td style="width:80px;height:80px"><div style="text-align:center;"><img src="' . $icon . '" style="width:60px;height:60px;border-radius:5px;"></div></td>';
    echo '<td style="padding-left:20px;">';
    echo '<div style="font-size:20px;margin-top:5px;font-weight:bold;color:#5cb85c;">';
    echo '<span  class="pointer btn-ajax" data-url="' . XSYSTEM_ADMIN_URL . 'ajax/network/profile/' . $network['network_code'] . '/">' . $network['network_name'] . '</span>';
    echo '<div>';
    echo '<div class="tag active-green">' . strtoupper($network['network_type']) . '</div>';
    echo '</td>';
    echo '<td style="width:110px;text-align:center;">';
    echo '<div>';
//     echo '<div class="btn btn-sm btn-success btn-ajax" data-url="' . XSYSTEM_ADMIN_URL . 'ajax/server/network_profile/' . $network['network_code'] . '/">編集</div> ';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}

?>