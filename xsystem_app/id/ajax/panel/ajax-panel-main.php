<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_' . XSYSTEM_APP . '_session']);
$is_secure = $user['secure'];

$qr = XSYSTEM_IMG_URL . 'user/qr/qr_' . $user['user_code'] . '.png';

include XSYSTEM_APP_DIR . 'part/user/part-user-my_id_button.php';
echo '<div>&nbsp;</div>';
include XSYSTEM_APP_DIR . 'part/coin/part-coin-my_coin_button.php';
include XSYSTEM_APP_DIR . 'part/user/part-user-qr_button.php';
include XSYSTEM_APP_DIR . 'part/id/part-id-jibun_id_button.php';
include XSYSTEM_APP_DIR . 'part/security/part-security-sotauth_button.php';
echo '<div style="height:500px;"></div>';
?>

