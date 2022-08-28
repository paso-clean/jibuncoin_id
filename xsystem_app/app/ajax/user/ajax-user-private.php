<?php
require_once XSYSTEM_COMMON_DIR . '/class/class-user.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);
?>

<div style="background:#fff;padding:10px;margin:5px;border-radius:5px;">


<hr>
<div id="form-user" class="form-user">
<table class="table">
<tr><td class="td-name">名前  </td><td><?php echo $user['name1'] . $user['name2']; ?></td></tr>
<tr><td class="td-name">フリガナ  </td><td><?php echo $user['name1_kana'] . $user['name2_kana']; ?></td></tr>
<tr><td class="td-name">〒  </td><td><?php echo $user['zipcode']; ?></td></tr>
<tr><td class="td-name">住所  </td><td><?php echo $user['address']; ?></td></tr>
<tr><td class="td-name">TEL  </td><td><?php echo $user['tel']; ?></td></tr>
<tr><td class="td-name">生年月日  </td><td><?php echo $user['birth']; ?></td></tr>
<tr><td class="td-name">Eメール  </td><td><?php echo $user['email']; ?></td></tr>
<tr><td class="td-name">パスワード  </td><td>●●●●●</td></tr>
</table>
</div>
<hr>
<div class="text-center">
	<button type="button" class="btn btn-primary btn-app" data-url="<?php echo XSYSTEM_APP_URL . 'ajax/user/private_editor/' ?>">編集</button>
</div>

</div>

