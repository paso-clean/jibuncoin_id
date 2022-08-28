<?php
require_once XSYSTEM_APP_DIR . 'class/class-register.php';
$register = new Register();

$code = $url_param[4];

if(isset($code) && $_POST['password'] != ''){
	$register_data = $register->onetime($code);
	if(is_array($register_data)){
		$register_code = $register_data['register_code'];
		$register->post_password($register_code,$_POST['password']);
	}else{
		header("HTTP/1.0 404 Not Found");
		$register_code = null;
	}
}
?>

<?php $form_id = xsystem_random_num(10); ?>
<div id="profile-img-area" class="text-center">
<div style="text-align:center;">本人とわかる画像をご登録してください。</div>
<div id="edit-img-area-<?php echo $form_id; ?>" style="padding:10px;display:none">
<canvas id="croppedCanvas-<?php echo $form_id; ?>" class="croppedCanvas btn-click" data-target="#reload_id_<?php echo $form_id; ?>" width="1"></canvas>
</div>
<img id="reload_id_<?php echo $form_id; ?>" class="pointer reload_class_<?php echo $form_id; ?> btn-ajax"
 data-action="cropper_editor"
 data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/cropper/form_img/" 
 data-action = "set_register_img"
 data-form_id="<?php echo $form_id; ?>"
 src="<?php echo APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $_COOKIE['app_name']; ?>/asset/img/no_image_sm.png"
 width=100 height=100
 >
<button type="button" class="btn btn-primary btn-lg form_id_<?php echo $form_id; ?> btn-api" data-action="register_complete" data-form_id="<?php echo $form_id; ?>" data-target="#fixedModal .panelContent" data-url="<?php echo XSYSTEM_APP_URL  ?>api/register/complete/<?php echo $code; ?>/" style="display:none">登録</button>

</div>
