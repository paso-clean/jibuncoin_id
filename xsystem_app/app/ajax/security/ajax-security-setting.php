<?php
require_once XSYSTEM_APP_DIR . '/class/class-user.php';
if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

$app_name = $url_param[3];

$is_secure = $user['secure'];
if($is_secure == 0){
  $btn = '<button type="button" id="btn-secure"  class="btn btn-lg btn-api" data-done="secure_done" data-secure="1" data-url="' . XSYSTEM_APP_URL . 'api/security/secure/' . $_COOKIE["xsystem_app_session"] . '">二段階認証</button>';
}else{
  $btn = '<button type="button" id="btn-secure"   class="btn btn-primary btn-lg btn-api" data-done="secure_done" data-secure="0" data-url="' . XSYSTEM_APP_URL . 'api/security/secure/' . $_COOKIE["xsystem_app_session"] . '">二段階認証</button>';
}

?>

<div class="content-block" style="background:#1e3799;border-color:#1e3799;">
<div class="text-center" style="padding:10px 0 10px 0;">
<div></div>
<div style="font-size:60px;margin-bottom:10px;color:#fff;"><i class="fa-solid fa-shield-halved"></i></div>
<div style="color:#fff;">SecureOneTime Authentication</div>
<div class="text-center" style="padding:30px 0 30px 0;"><?php echo $btn; ?></div>
</div>
</div>

<div class="content-block">
<div class="text-center" style="padding:30px 0 30px 0;">
<button type="button" class="btn btn-danger btn-lg btn-api" data-done="app_redirect" data-url="<?php echo XSYSTEM_APP_URL; ?>api/user/logout/">ログアウト</button>
</div>
</div>


