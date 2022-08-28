<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_' . XSYSTEM_APP . '_session']);

$url = XSYSTEM_APP_URL . 'ajax/user/profile_editor/';
?>

<div class="col-md-6" style="padding:2px;">


<div class="content-block">
<table>
<tr>
<td style="width:120px">
<img style="width:100px;height:100px;border-radius:5px;" 
class="reload_class_<?php echo $user['objects']['user_img'][0]['object_code']; ?> pointer btn-ajax"
 data-form_id="<?php echo xsystem_random_num(10); ?>"
 data-action="cropper_editor" 
 data-entity_type="user"
 data-object_type="user_img"
 data-entity_code="<?php echo $user['user_code']; ?>"
 data-object_code= "<?php echo $user['objects']['user_img'][0]['object_code']; ?>"
 data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/cropper/user_img/" 
src="<?php echo XSYSTEM_IMG_URL; ?>user/thum/<?php echo $user['objects']['user_img'][0]['object']; ?>">
</td>
<td>

<div class="text-left"><?php echo $user['user_code']; ?></div>
<div><?php echo $user['name1_kana']; ?> <?php echo $user['name2_kana']; ?></div>
<div><?php echo $user['name1']; ?> <?php echo $user['name2']; ?></div>
</td>
</tr>
</table>
</div>

<?php 
if(isset($user['objects']['user_profile'])){
  foreach($user_profiles as $key=>$user_profile){
    foreach($user['objects']['user_profile'] as $object){ 
      if($object['object_name'] == $key){
        echo '<div class="content-block">';
        echo '<div style="color:#428bca;font-weight:bold;">' . $user_profiles[$object['object_name']]['name'] . ':</div>';
        echo $object['object'];
        echo '<div style="text-align:right">';
        echo '<div class="tag active-green btn-ajax" data-url="' . $url . '" data-object_code="' . $object['object_code'] . '" data-object_num=' . $user_profile['order'] . '>編集</div>';
        echo '</div>';
        echo '</div>';
      }
    }
  }
}
?>






<div class="content-block text-center">
<div id="btn-add" class="btn btn-primary btn-lg btn-ajax" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/user/profile_menu/">プロフィール追加</div>
<div id="btn-reload" style="display:none" class="btn btn-danger btn-lg btn-ajax" data-action="reload" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/user/profile/"><i class="fa-solid fa-rotate"></i> データ更新</div>
</div>

</div><!-- col-md-6" -->


<div class="col-md-6" style="padding:2px;">
<!--
<div class="content-block text-center"></div>
-->
</div><!-- col-md-6" -->