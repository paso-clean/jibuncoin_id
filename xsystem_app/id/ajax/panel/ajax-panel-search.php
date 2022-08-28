<?php
require_once XSYSTEM_APP_DIR . '/class/class-user.php';
if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_' . XSYSTEM_APP . '_session']);

?>

<table style="width:100%;border:1px solid #ddd;background:#fff;text-align:center;">
<tr>
<td style="height:80px;">
<div class="form-group" style="margin-top:15px;">
<input type="text"  class="form-control"  style="width:200px;display:inline-block;">
<button type="button" class="btn btn-primary">検索</button>
</div>
</td>
</tr>
</table>

<div>&nbsp;</div>
<?php
include XSYSTEM_APP_DIR . 'part/coin/part-coin-search_button.php';
include XSYSTEM_APP_DIR . 'part/group/part-group-menu_button.php';
?>

<div style="height:500px"></div>

