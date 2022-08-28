<?php
require_once XSYSTEM_APP_DIR . 'class/class-register.php';
$register = new Register();

$code = $url_param[4];

if(isset($code)){
	$register_data = $register->onetime($code);
	if(is_array($register_data)){
		$register_code = $register_data['register_code'];
	}else{
		echo 'Not Found.';
		exit;
	}
}

?>
<div id="passwordPanel">
<form id="form-password" class="form-register" >
<div class="row">
<div class="form-group col-sm-12">
<div class="text-center"><?php echo $register_data['email'];  ?></div>
<div id="form-comment" class="text-center">パスワードを設定してください。</div>
</div>
</div>
<div class="row">
<div class="form-group col-sm-12">
<label id="label-password" for="password">パスワード</label>
<input type="password" class="form-control" id="password" name="password" value="gfggkvgg47" placeholder="">
</div>
</div>
<div class="row">
<div class="form-group col-sm-12">
<label id="label-password2" for="password2">パスワード(確認)</label>
<input type="password" class="form-control" id="password2" name="password2" value="gfggkvgg47" placeholder="">
</div>
</div>
<hr>
<div style="text-align:center;"><button type="button" class="btn btn-primary btn-ajax" data-action="user_img" data-target="#fixedModal .panelContent" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/register/profile_img/<?php echo $code; ?>/">設定</button></div>
</form>
</div>