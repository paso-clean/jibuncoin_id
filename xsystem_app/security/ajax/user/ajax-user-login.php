<?php 
$form_id = xsystem_random_num(10);

?>
<div id="passwordPanel">
<div class="text-center"><img class="user_img" src="<?php echo APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $_COOKIE['app_name']; ?>/asset/img/logo.png" style="width:100px;height:100px;"></div>

<div id="error-message" class="text-center" style="color:#f00;padding:10px;"></div>

<form method="post" action="" id="form-login" class="form-register" >
<div class="row">
<div class="form-group col-sm-12">
<label id="label-password" for="password">メールアドレス</label>
<input type="text" class="form-control form-id-<?php echo $form_id; ?>" id="email" name="email" value="" placeholder="">
</div>
</div>
<div class="row">
<div class="form-group col-sm-12">
<label id="label-password2" for="password2">パスワード</label>
<input type="password" class="form-control form-id-<?php echo $form_id; ?>" id="password" name="password" value="" placeholder="">
</div>
</div>
<div style="text-align:center;padding:20px;"><button type="button" id="btn-login" class="btn btn-lg btn-primary btn-api" data-form_id="<?php echo $form_id; ?>" data-done="user_login_done" data-url="<?php echo XSYSTEM_APP_URL; ?>api/user/login/">ログイン</button></div>
</form>
<hr>
<div class="text-center" style="color:#428bca;">ジブンIDでログイン</div>
<div class="text-center">
<img class="pointer btn-api" 
data-url="<?php echo XSYSTEM_COMMON_URL; ?>api/id/transition/" 
data-transition_url="<?php echo $jibun_id_node[0]; ?>login/linkage/" 
data-entry="<?php echo XSYSTEM_COMMON_URL; ?>api/id/entry/"
data-redirect="<?php echo XSYSTEM_COMMON_URL; ?>jibun_id/secure_login/"
data-app_url="<?php echo APP_URL . $_COOKIE['app_name']; ?>/"
data-done="id_transition_done"
src="<?php echo XSYSTEM_ASSET_URL . 'img/jibun_id.png' ?>" 
style="width:60px;height:60px;">
</div>
<div class="register_form"><a href="<?php echo XSYSTEM_APP_URL; ?>register/form/">会員登録</a></div>
<div class="repassword"><a href="<?php echo XSYSTEM_APP_URL; ?>register/repassword/">パスワードの再設定</a></div>
</div>