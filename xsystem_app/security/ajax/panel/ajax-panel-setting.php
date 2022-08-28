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
<table class="pointer btn-ajax"  data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/coin/list/" style="width:100%;border:1px solid #ddd;background:#fff;">
<tr>
<td style="width:80px;height:80px;"><div style="text-align:center;"><img src="<?php echo APP_URL  . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $app_name; ?>/asset/img/logo.png" style="width:60px;height:60px;"></div></td>
<td style="padding-left:20px;">
<div style="font-size:13px;color:#357ebd;">ジブンコインドットコム</div>
<div style="font-size:20px;font-weight:bold;color:#357ebd;">JIBUNCOIN.COM</div>
</td>
</tr>
</table>
<div>&nbsp;</div>
<?php
include XSYSTEM_APP_DIR . 'part/coin/part-coin-menu_button.php';
include XSYSTEM_APP_DIR . 'part/group/part-group-menu_button.php';
?>