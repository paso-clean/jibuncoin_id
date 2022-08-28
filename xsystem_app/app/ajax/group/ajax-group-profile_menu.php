<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-user.php';
require_once XSYSTEM_COMMON_DIR . '/class/class-group.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$groupIns = new Group();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

$url = XSYSTEM_APP_URL . 'ajax/group/profile_editor/';
if(isset($_POST['group_code'])){
  $group = $groupIns->get_group($_POST['group_code']);
  $group_code = $group['group_code'];
  if(isset($group['objects']['group_img'][0]['object'])){
    $img = XSYSTEM_IMG_URL . 'group/thum/' . $group['objects']['group_img'][0]['object'];
  }
  $group_name = $group['group_name'];
  $data_group_code = 'data-group_code="' . $_POST['group_code'] . '"';
}else{
  $group_name = '';
  $data_group_code = '';
}


echo '<div class="content-block text-center">';
echo '<div style="margin-top:20px;font-size:24px;font-weight:bold;color:#357ebd;">グループ・プロフィール</div>';
echo '<hr>';
foreach($group_profiles as $key=>$group_profile){
    $is_edit = false;
    $object_code = '';
    if(isset($user['objects']['user_profile'])){
        foreach($user['objects']['user_profile'] as $object){ 
            if($object['object_name'] == $key){
                $is_edit = true;
                $object_code = $object['object_code'];
            }
        }
    }
    if($is_edit){
        echo '<div class="tag active-green btn-app" ' . $data_group_code . ' data-reload=1 data-object_code="' . $object_code . '" data-url="' . $url . '" data-object_type="group_profile" data-object_name="' . $key . '" data-object_num=' . $group_profile['order'] . '>' . $group_profile['name'] . '</div>';
    }else{
        echo '<div class="tag active-white btn-app" ' . $data_group_code . ' data-reload=1 data-url="' . $url . '" data-object_type="group_profile" data-object_name="' . $key . '" data-object_num=' . $group_profile['order'] . '>' . $group_profile['name'] . '</div>';
    }
    echo '';
    echo '';
    echo '';
}
echo '<hr>';
echo '</div>';
?>
</div>