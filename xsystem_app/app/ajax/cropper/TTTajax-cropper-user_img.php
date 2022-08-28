<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

?>

<div class="ajax-wrapper">
<div class="content-block">

<div class="form-cropper">
<div id="origin-img-area">
<img id="user-profile-img" src="<?php echo $_POST['src']; ?>">
</div>
<div id="cropperPanel">
<input type="file" id="uploader" data-form_id="<?php echo $_POST['form_id']; ?>" accept="image/*" style="display:none;">
<div id="edit-cropper-area" style="display:none"><canvas id="sourceCanvas" width="1" height="1"></canvas></div>
</div>
</div><!-- form-cropper -->

<div id="edit-img-area" style="padding:10px;display:none"><canvas id="croppedCanvas" width="1"></canvas></div>

<div id="edit-img-area2" style="padding:10px;display:none">
<canvas id="croppedCanvas-<?php echo $_POST['form_id']; ?>" width="1"></canvas>
</div>

<div style="padding:20px;">

<button type="button" id="btn-cropper" data-form_id="<?php echo $_POST['form_id']; ?>" class="btn btn-lg btn-primary">画像選択</div>

<div class="setting-img-area" style="display:none;">
<div class="btn btn-lg btn-primary btn-api" 
data-form_id="<?php echo $_POST['form_id']; ?>"
data-action="setting_img"
data-url="<?php echo XSYSTEM_COMMON_URL; ?>api/user/user_img/"
data-done="setting_img_done"
data-entity_type="<?php echo $_POST['entity_type']; ?>"
data-entity_code="<?php echo $_POST['entity_code']; ?>"
data-object_type="<?php echo $_POST['object_type']; ?>"
data-object_code="<?php echo $_POST['object_code']; ?>"
>設定</div>
<div style="padding:20px;"></div>
</div><!-- setting-img-area -->

</div>

</div><!-- content-block -->
</div><!-- ajax-wrapper -->