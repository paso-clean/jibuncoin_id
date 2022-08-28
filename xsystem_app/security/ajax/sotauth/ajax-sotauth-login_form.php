<?php
$session_code = $url_param[4];
?>
<div style="padding:15px;">
<div class="text-center">
<img src="<?php echo XSYSTEM_ASSET_URL; ?>img/logo.png?p=<?php echo xsystem_random_num(10); ?>" style="width:60px;height:60px;">
</div>

<div id="error-message" class="text-center" style="color:#f00;padding:10px;"></div>

<form method="post" action="" id="form-login" class="form-register" >

<div class="row" style="margin-bottom:20px;">
<div>
<div><label id="label-email" for="email">メールアドレス</label></div>
<div><input type="text" id="email" name="email" value="" placeholder=""></div>
</div>
</div>

<div class="row">
<div><label id="label-password" for="password">パスワード</label></div>
<idv style="color:#000;"><input type="password" id="password" name="password" value="" placeholder=""></div>
</div>

<div style="text-align:center;"><button type="button" id="btn-login" class="btn btn-primary btn-api" data-action="login_simple" data-done="login_simple_done" data-url="<?php echo XSYSTEM_APP_URL; ?>api/login/simple/">ログイン</button></div>
</form>
</div>