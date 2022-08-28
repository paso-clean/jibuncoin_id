<?php
require_once XSYSTEM_APP_DIR . '/class/class-user.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}

if(isset($_POST['object_code'])){
  $object_code = $_POST['object_code'];
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);
;
$text = '';

$objects = array();
if(isset($user['objects']['user_profile'])){
  $objects = $user['objects']['user_profile'];
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
<div style="margin-top:20px;font-size:18px;font-weight:bold;color:#357ebd;">プロフィール</div>
<div style="font-size:24px;font-weight:bold;color:#357ebd;"><?php echo $user_profiles[$object_name]['name']; ?></div>
<hr>

<div class="form-group">
<textarea id="object-<?php echo $form_id; ?>" class="form-control form-id-<?php echo $form_id; ?>" name="object" rows="10"><?php echo $text; ?></textarea>
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
data-done="form_done" 
data-entity_code="<?php echo $user['user_code']; ?>"
data-entity_type="user"
data-url="<?php echo XSYSTEM_APP_URL ?>api/entity/object/"
data-reload_url="<?php echo XSYSTEM_APP_URL ?>ajax/user/profile/"
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
data-done="form_done" 
data-entity_code="<?php echo $user['user_code']; ?>"
data-entity_type="user"
data-url="<?php echo XSYSTEM_APP_URL ?>api/entity/object/"
data-reload_url="<?php echo XSYSTEM_APP_URL ?>ajax/user/profile/"
data-reload_last="<?php echo $reload_last; ?>"
data-method='delete';
>削除</button>
</div>
<hr>
<?php } ?>



</div>