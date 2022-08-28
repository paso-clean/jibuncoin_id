
<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
$userIns = new User();
$session_code = $url_param[4];
$session = $userIns->get_session_data($session_code);
$session_name = $session['session_name'];

?>
<div id="passwordPanel">
<div class="text-center"><img src="<?php echo XSYSTEM_ASSET_URL; ?>img/loading_img.png" class="loading-img" width="80" height="80" /></div>

<div id="error-message" class="text-center" style="color:#f00;padding:10px;"></div>

<form method="post" action="" id="form-login" class="form-register" >
<div class="row">
<div class="form-group col-sm-12">

<div class="text-center">
<div>
<div class="tag active-blue"><?php echo $session_name; ?></div>
</div>
<div style="color:blue;margin:20px;">認証待ち...</div>
<button type="button" class="btn btn-primary btn-lg btn-ajax" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/security/iframe/<?php echo $url_param[4]; ?>/">セキュアワンタイム認証</div>
</div>

</div>
</div>
</form>
</div>
