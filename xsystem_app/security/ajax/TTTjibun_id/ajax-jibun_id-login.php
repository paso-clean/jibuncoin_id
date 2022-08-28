<?php
$session_name = $url_param[4];
$session_code = $url_param[5];
$param = $url_param[6];
?>
<div id="passwordPanel">
<div class="text-center"><img class="user_img" src="<?php echo APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $_COOKIE['app_name']; ?>/asset/img/logo.png" style="width:100px;height:100px;"></div>

<div id="error-message" class="text-center" style="color:#f00;padding:10px;"></div>

<form method="post" action="" id="form-login" class="form-register" >
<div class="row">
<div class="form-group col-sm-12">
<label id="label-password" for="password">メールアドレス</label>
<input type="text" class="form-control" id="email" name="email" value="" placeholder="">
</div>
</div>
<div class="row">
<div class="form-group col-sm-12">
<label id="label-password2" for="password2">パスワード</label>
<input type="password" class="form-control" id="password" name="password" value="" placeholder="">
</div>
</div>
<div style="text-align:center;">
<button type="button" id="btn-login" class="btn btn-lg btn-primary btn-api" 
data-action="jibun_id_login"
data-done="jibun_id_login_done" 
data-url="<?php echo XSYSTEM_APP_URL; ?>api/jibun_id/login/<?php echo $session_name . '/' . $session_code . '/' . $param ; ?>/"
>ログイン</button>
</div>
</form>
<hr>
<div>
<?php
echo '<div>' . $session_name . '</div>';
echo '<div>' . $session_code . '</div>';
echo '<div>' . $param . '</div>';
?>
</div>
</div>