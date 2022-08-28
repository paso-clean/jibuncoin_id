<?php
require_once XSYSTEM_APP_DIR . '/class/class-user.php';
require_once XSYSTEM_COMMON_DIR . 'lib/phpqrcode/qrlib.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

$ql_url = XSYSTEM_IMG_URL .  'user/qr/qr_' . $user['user_code'] . '.png';
$ql_file = XSYSTEM_IMG_DIR . 'user/qr/qr_' . $user['user_code'] . '.png';
if(!file_exists($ql_file)){
    $content = XSYSTEM_APP_URL . 'user/content/' . $user['user_code'] . '/';
    // echo $content;
    // exit;
    QRcode::png($content, $ql_file, QR_ECLEVEL_M, 6);
}

?>
<div style="text-align:center;">

<div class="content-block">
<table>
<tr>
<td style="width:120px"><img style="width:100px;height:100px;" src="<?php echo XSYSTEM_IMG_URL; ?>/user/origin/<?php echo $user['objects']['user_img'][0]['object']; ?>"></td>
<td>
<div class="text-left"><?php echo $user['user_code']; ?></div>
<div><?php echo $user['name1_kana']; ?> <?php echo $user['name2_kana']; ?></div>
<div><?php echo $user['name1']; ?> <?php echo $user['name2']; ?></div>
</td>
</tr>
</table>
</div>

<div class="content-block">
<img src="<?php echo $ql_url; ?>">
</div>

<div class="content-block">
<div class="btn-link-clip pointer"><?php echo XSYSTEM_APP_URL . 'user/content/' . $user['user_code'] . '/'; ?></div>
</div>


</div>