<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';


if(isset($url_param[4]) && $url_param[4] != ''){
    $network_code = $url_param[4];
    $networkIns = new Network();
    $network = $networkIns->get_network($network_code);
    $network_name = $network['network_name'];
    $network_active = $network['active'];
    $is_edit = true;
    $servers = $networkIns->get_network_servers($network_code);
    
    if($network['network_type'] == 'id'){
        $icon = XSYSTEM_COMMON_ASSET_URL . 'img/jibun_id.png';
    }elseif($network['network_type'] == 'security'){
        $icon = XSYSTEM_COMMON_ASSET_URL . 'img/security.png';
    }else{
        $icon = XSYSTEM_COMMON_ASSET_URL . 'img/no_image.png';
    }
    
}else{
    $is_edit = false;
    $network_name = strtoupper(xsystem_random_char(3)) . '-'  . xsystem_random_num(4);
    $network_active = 0;
}

$form_id = xsystem_random_num(10);

?>

<?php if($is_edit){ ?>
<table class="" style="width:100%;height:80px;border:1px solid #ddd;background:#5cb85c;text-align:center;">
<tr>
<td><div style="font-size:40px;color:#fff;"><img src="<?php echo $icon; ?>" style="width:60px;height:60px;border-radius:5px;"> <span style="font-size:24px;font-weight:bold;"><?php echo $network_name; ?></span></div></td>
</tr>
</table>
<input type="hidden" class="form-id-<?php echo $form_id; ?>" name="network_code" value="<?php echo $network_code; ?>">
<?php }else{ ?>
<table class="" style="width:100%;height:80px;border:1px solid #ddd;background:#5cb85c;text-align:center;">
<tr>
<td><div style="font-size:40px;color:#fff;"><i class="fa-solid fa-diagram-project"></i> <span style="font-size:24px;font-weight:bold;">新規ネットワーク</span></div></td>
</tr>
</table>
<?php } ?>

<div>&nbsp;</div>

<div style="background:#fff;padding:20px;border-radius:5px;">

<div id="form-user" class="form-user">

<div class="row text-center">


<div class="row" style="padding:10px 20px 10px 20px">
<label id="label-network" for="network_name">ネットワーク名</label>
<input type="text" class="form-control form-id-<?php echo $form_id; ?>" name="network_name" value="<?php echo $network_name; ?>" placeholder="">
</div>

<?php if($is_edit){ ?>
<div class="row" style="padding:10px 20px 10px 20px">
<label for="network_type">ネットワークタイプ</label>
<div style="font-weight:bold;font-size:20px;"><?php echo strtoupper($network['network_type']); ?></div>
</div>
<input type="hidden" class="form-id-<?php echo $form_id; ?>" name="network_type" value="<?php echo $network['network_type']; ?>">
<?php }else{ ?>
<div class="row" style="padding:10px 20px 10px 20px">
<div id="label-network_type" class="form-group">
    <label for="network_type">ネットワークタイプ</label>
    <select class="form-control form-id-<?php echo $form_id; ?>" name="network_type">
      <option value="id">ID</option>
      <option value="security">SECURITY</option>
      <option value="coin">COIN</option>
      <option value="token">TOKEN</option>
    </select>
  </div>
</div>
<?php } ?>

<div class="row" style="padding:10px 20px 10px 20px">
<div id="label-network_active" class="form-group">
    <label for="network_active">状態</label>
    <select class="form-control form-id-<?php echo $form_id; ?>" name="network_active">
      <option value="0" <?php if($network_active == 0){ echo 'selected'; } ?>>非アクティブ</option>
      <option value="1" <?php if($network_active == 1){ echo 'selected'; } ?>>アクティブ</option>
    </select>
  </div>
</div>

<div style="text-align:center;"><button type="button" class="btn btn-primary btn-lg btn-api" data-form_id="<?php echo $form_id; ?>"  data-done="form_done" data-url="<?php echo XSYSTEM_ADMIN_URL; ?>api/network/setting/">設定</button></div>

<?php if(isset($network_code) && $network_code != ''){ ?>
<hr>
<div class="btn btn-sm btn-danger btn-api" data-server_code="<?php echo $network['network_code']; ?>" data-delete=1 data-url="<?php echo XSYSTEM_ADMIN_URL; ?>api/network/setting/" data-done="form_done">ネットワーク消去</div>
<?php } ?>
</div>


</div>
</div>


<div>&nbsp;</div>

<?php 
if($is_edit){
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
        echo '<div style="font-size:13px;">' . $server['domain'] . '</div>';
        echo '</td>';
        echo '<td style="width:110px;text-align:center;">';
        echo '<div>';
        echo '<div class="btn btn-sm btn-danger btn-api" data-cmd="delete" data-done="reload" data-url="' . XSYSTEM_ADMIN_URL . 'api/network/network_server/' . $network_code . '/' . $server['server_code'] . '/">削除</div> ';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
    }
    echo '<div class="content-block text-center">';
    echo '<div id="btn-add" class="btn btn-primary btn-lg btn-ajax" data-network_code="' . $network_code . '" data-url="' . XSYSTEM_ADMIN_URL . 'ajax/network/network_server/">サーバー追加</div>';
    echo '</div>';
}

?>





