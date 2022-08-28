<?php
require_once XSYSTEM_COMMON_DIR . '/class/class-user.php';
require_once XSYSTEM_COMMON_DIR . '/class/class-group.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}

if(isset($_POST['object_code'])){
  $object_code = $_POST['object_code'];
}
$userIns = new User();
$groupIns = new Group();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

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

$text = '';

$objects = array();
if(isset($group['objects']['group_profile'])){
  $objects = $group['objects']['group_profile'];
}

if(isset($object_code)){
  foreach($objects as $object){
    if($object['object_code'] == $_POST['object_code']){
      $object_name = $object['object_name'];
      $object_type = $object['object_type'];
      $text = $object['object'];
      $reload_last = 1;
    }
  }
}else{
  $object_name = $_POST['object_name'];
  $object_type = $_POST['object_type'];
  $reload_last = 2;
}

$object_num = $_POST['object_num'];

?>

<?php $form_id = xsystem_random_num(10); ?>
<div class="content-block text-center">
<div style="margin-top:20px;font-size:18px;font-weight:bold;color:#357ebd;">グループ・プロフィール</div>
<div style="font-size:24px;font-weight:bold;color:#357ebd;"><?php echo convert_jp($object_name); ?></div>
<hr>

<div class="form-group">
<textarea class="form-control" id="profile-text-<?php echo $form_id; ?>" rows="10"><?php echo $text; ?></textarea>
</div>
<div>
<button type="button" 
class="btn btn-primary btn-lg btn-api" 
data-form_id="<?php echo $form_id; ?>"
<?php if(isset($object_code)){ ?>
data-object_code="<?php echo $object_code; ?>"
<?php } ?>
data-object_name="<?php echo $object_name; ?>"
data-object_type="<?php echo $object_type; ?>"
data-object_num="<?php echo $object_num; ?>"
data-api_done="form_done" 
data-entity_code="<?php echo $group_code; ?>"
data-object_code="<?php echo $object_code; ?>"
data-entity_type="group"
data-api="<?php echo XSYSTEM_APP_URL ?>api/entity/object/"
data-reload_url="<?php echo XSYSTEM_APP_URL ?>ajax/group/profile/<?php echo $group_code; ?>/"
data-reload_last="<?php echo $reload_last; ?>"
>登録</button>
</div>
<hr>

<?php if(isset($object_code) && $object_code != ''){ ?>
<div>
<?php $form_id = xsystem_random_num(10); ?>
<button type="button" class="btn btn-danger btn-api"
data-form_id="<?php echo $form_id; ?>"
data-object_code="<?php echo $object_code; ?>"
data-object_name="<?php echo $object_name; ?>"
data-object_type="<?php echo $object_type; ?>"
data-object_num="<?php echo $object_num; ?>"
data-api_done="form_done" 
data-entity_code="<?php echo $group_code; ?>"
data-entity_type="group"
data-api="<?php echo XSYSTEM_APP_URL ?>api/entity/object/"
data-reload_url="<?php echo XSYSTEM_APP_URL ?>ajax/group/profile/<?php echo $group_code; ?>/"
data-reload_last="<?php echo $reload_last; ?>"
data-delete=1;
>削除</button>
</div>
<hr>
<?php } ?>



</div>