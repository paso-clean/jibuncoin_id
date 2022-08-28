<?php
// require_once XSYSTEM_COMMON_DIR . 'class/class-user.php';
// if(!isset($_COOKIE['xsystem_app_session'])){
//   $redirect = XSYSTEM_APP_URL . 'login/';
//   header("Location: $redirect");
//   exit;
// }
// $userIns = new User();
// $user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

?>

<div class="ajax-wrapper text-center">
<div class="content-block">

<div class="form-cropper">
<div id="origin-img-area">
<img id="user-profile-img" width=100 height=100 src="<?php echo $_POST['src']; ?>">
</div>
<div id="cropperPanel">
<input type="file" id="uploader" data-form_id="<?php echo $_POST['form_id']; ?>" accept="image/*" style="display:none;">
<div id="edit-cropper-area" style="display:none"><canvas id="sourceCanvas" width="1" height="1"></canvas></div>
</div>
</div><!-- form-cropper -->

<div id="edit-img-area" style="padding:10px;display:none">
<canvas id="croppedCanvas" width="1"></canvas>
</div>

<div style="padding:20px;">

<button type="button" id="btn-cropper" data-form_id="<?php echo $_POST['form_id']; ?>" class="btn btn-lg btn-primary">画像選択</div>

<div class="setting-img-area" style="display:none;">
<div class="btn btn-lg btn-primary btn-cropper-close" data-form_id="<?php echo $_POST['form_id']; ?>">設定</div>
<div style="padding:20px;"></div>
</div><!-- setting-img-area -->

</div>

</div><!-- content-block -->
</div><!-- ajax-wrapper -->