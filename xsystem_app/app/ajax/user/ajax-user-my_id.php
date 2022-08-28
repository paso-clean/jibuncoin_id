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
<div class="row">

<div class="col-md-6">


<div class="content-block">
<table>
<tr>
<td style="width:120px"><img style="width:100px;height:100px;border-radius:5px;" src="<?php echo XSYSTEM_IMG_URL; ?>/user/origin/<?php echo $user['objects']['user_img'][0]['object']; ?>"></td>
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
        if($object['object_name'] != 'free_text'){
            echo '<div style="color:#428bca;font-weight:bold;">' . $user_profiles[$object['object_name']]['name'] . ':</div>';
        }
        echo $object['object'];
        echo '</div>';
      }
    }
  }
}
?>


</div><!-- col-md-6" -->


<div class="col-md-6">
