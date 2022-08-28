<?php
require_once XSYSTEM_COMMON_DIR . '/class/class-user.php';
require_once XSYSTEM_COMMON_DIR . '/class/class-group.php';
$userIns = new User();
$groupIns = new Group();

if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

$groups = $groupIns->get_user_groups($user['user_code']);

?>

<table class="pointer btn-ajax" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/group/profile/" style="width:100%;border:1px solid #ddd;background:#fff;;">
<tr data-user_code="">
<td style="width:80px;height:80px;"><div style="font-size:40px;color:#357ebd;text-align:center;"><i class="fa-solid fa-users"></i></div></td>
<td style="padding-left:20px;">
<div style="font-size:13px;color:#357ebd;"></div>
<div style="font-size:24px;font-weight:bold;color:#357ebd;">グループ作成</div>
</td>
</tr>
</table>

<div>&nbsp;</div>

<?php 
$img_dir = XSYSTEM_IMG_URL . 'group/thum/';
foreach($groups as $group){
  if(isset($group['objects']['group_img'][0]['object'])){
    $img = $img_dir . $group['objects']['group_img'][0]['object'];
  }else{
    $img = XSYSTEM_ASSET_URL . 'img/no_image_sm.png';
  }
    echo '<div class="content-block" style="padding:0;">';
    echo '<table style="width:100%;">';
    echo '<tr>';
    echo '<td style="width:80px;height:80px"><div style="text-align:center;"><img src="' . $img . '" style="width:60px;height:60px;border-radius:5px;"></div></td>';
    echo '<td style="padding-left:20px;">';
    echo '<div style="font-size:20px;margin-top:5px;font-weight:bold;color:#357ebd;">';
    echo $group['group_name'];
    echo '<div>';
    echo '</td>';
    echo '<td style="width:110px;text-align:center;">';
    echo '<div>';
    echo '<div class="btn btn-sm btn-success btn-ajax" data-group_code="' . $group['group_code'] . '" data-url="' . XSYSTEM_APP_URL . 'ajax/group/profile/' . $group['group_code'] . '/">編集</div> ';
    echo '</div>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}

?>