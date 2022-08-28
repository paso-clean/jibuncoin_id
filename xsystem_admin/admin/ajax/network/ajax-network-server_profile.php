<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';

if(isset($_POST['server_code'])){
    $server_code = $_POST['server_code'];
    $networkIns = new Network();
    $server = $networkIns->get_server($server_code);
    $domain = $server['domain'];
}else{
    $server_code = '';
    $domain = '';
}

// $url = XSYSTEM_APP_URL . 'ajax/group/profile_editor/';
?>

<div style="background:#fff;padding:20px;border-radius:5px;">

<div id="form-user" class="form-user">

<div class="row text-center">

<?php $form_id = xsystem_random_num(10); ?>

<div class="row" style="padding:10px 20px 10px 20px">
<label id="label-domain" for="domain">サーバードメイン</label>
<input type="text" class="form-control form-id-<?php echo $form_id; ?>" name="domain" value="<?php echo $domain; ?>" placeholder="">
</div>

<input type="hidden" class="form-id-<?php echo $form_id; ?>" name="server_code" value="<?php echo $server_code; ?>">
<div style="text-align:center;"><button type="button" class="btn btn-primary btn-lg btn-api" data-form_id="<?php echo $form_id; ?>"  data-done="form_done" data-url="<?php echo XSYSTEM_ADMIN_URL; ?>api/network/server_setting/">設定</button></div>

<?php if(isset($server_code) && $server_code != ''){ ?>
<hr>
<div class="btn btn-sm btn-danger btn-api" data-server_code="<?php echo $server['server_code']; ?>" data-delete=1 data-url="<?php echo XSYSTEM_ADMIN_URL; ?>api/network/server_setting/" data-done="form_done">グループ消去</div>
<?php } ?>
</div>


</div>
</div>

