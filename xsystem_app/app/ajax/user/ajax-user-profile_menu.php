<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

$url = XSYSTEM_APP_URL . 'ajax/user/profile_editor/';


echo '<div class="content-block text-center">';
echo '<div style="margin-top:20px;font-size:24px;font-weight:bold;color:#357ebd;">プロフィール</div>';
echo '<hr>';
foreach($user_profiles as $index=>$profile_item){
    $is_edit = false;
    $object_code = '';
    if(isset($user['objects']['user_profile'])){
        foreach($user['objects']['user_profile'] as $object){ 
            if($object['object_name'] == $index){
                $is_edit = true;
                $object_code = $object['object_code'];
            }
        }
    }
    if($is_edit){
        echo '<div class="tag active-green btn-ajax" data-reload=1 data-object_code="' . $object_code . '" data-url="' . $url . '" data-object_type="user_profile" data-object_name="' . $index . '" data-object_num=' . $profile_item['order'] . '>' . $profile_item['name'] . '</div>';
    }else{
        echo '<div class="tag active-white btn-ajax" data-reload=1 data-url="' . $url . '" data-object_type="user_profile" data-object_name="' . $index . '" data-object_num=' . $profile_item['order'] . '>' . $profile_item['name'] . '</div>';
    }
    echo '';
    echo '';
    echo '';
}
echo '<hr>';
echo '</div>';
?>
</div>