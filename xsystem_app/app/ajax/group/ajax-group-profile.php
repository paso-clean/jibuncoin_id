<?php
require_once XSYSTEM_APP_DIR . '/class/class-user.php';
require_once XSYSTEM_APP_DIR . '/class/class-group.php';
if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$groupIns = new Group();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);

if(isset($_POST['group_code'])){
  $group_code = $_POST['group_code'];
}elseif(isset($url_param[4]) && $url_param[4] != ''){
  $group_code = $url_param[4];
}

$img = XSYSTEM_ASSET_URL . 'img/no_image_sm.png';
if(isset($group_code) && $group_code != ''){
  $group = $groupIns->get_group($group_code);
  $group_code = $group['group_code'];
  if(isset($group['objects']['group_img'][0]['object'])){
    $img = XSYSTEM_IMG_URL . 'group/thum/' . $group['objects']['group_img'][0]['object'];
  }
  $group_name = $group['group_name'];
  $data_group_code = 'data-group_code="' . $group_code . '"';
}else{
  $group_name = '';
  $data_group_code = '';
}

$url = XSYSTEM_APP_URL . 'ajax/group/profile_editor/';
?>

<div style="background:#fff;padding:20px;border-radius:5px;">

<div id="form-user" class="form-user">

<div class="row text-center">

<?php $form_id = xsystem_random_num(10); ?>
<div id="profile-img-area" class="text-center">
<div id="edit-img-area-<?php echo $form_id; ?>" style="padding:10px;display:none">
<canvas id="croppedCanvas-<?php echo $form_id; ?>" class="croppedCanvas btn-click" data-target="#reload_id_<?php echo $form_id; ?>" width="1"></canvas>
</div>
<img id="reload_id_<?php echo $form_id; ?>" class="pointer reload_class_<?php echo $form_id; ?> btn-ajax"
 data-action="cropper_editor"
 data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/cropper/form_img/" 
 data-action = "set_register_img"
 data-form_id="<?php echo $form_id; ?>"
 src="<?php echo $img; ?>"
 width=100 height=100
 >
</div>

<div class="row" style="padding:10px 20px 10px 20px">
<label id="label-group_name" for="group_name">グループ名</label>
<input type="text" class="form-control form-id-<?php echo $form_id; ?>" name="group_name" value="<?php echo $group_name; ?>" placeholder="">
</div>


<div class="row" style="padding:10px 20px 10px 20px">
<div id="label-group_type" class="form-group">
    <label for="group_type">一般参加</label>
    <select class="form-control form-id-<?php echo $form_id; ?>" name="group_type">
      <option value="open">オープン</option>
      <option value="close">クローズド</option>
    </select>
  </div>
</div>


<div class="row" style="padding:10px 20px 10px 20px">
<div id="label-group_type" class="form-group">
    <label for="group_type">メンバー表示</label>
    <select class="form-control">
      <option>表示</option>
      <option>非表示</option>
      <option>イニシャル</option>
    </select>
  </div>
</div>


<div class="row" style="padding:10px 20px 10px 20px">
<div id="label-group_type" class="form-group">
    <label for="group_type">ニックネームでの参加</label>
    <select class="form-control">
      <option>あり</option>
      <option>なし</option>
    </select>
  </div>
</div>

<div style="text-align:center;"><button type="button" class="btn btn-primary btn-lg btn-api" data-entity_type="group"  data-form_id="<?php echo $form_id; ?>" <?php echo $data_group_code; ?> data-done="form_done" data-url="<?php echo XSYSTEM_APP_URL ; ?>api/group/setting/">設定</button></div>

<?php if(isset($group_code) && $group_code != ''){ ?>
<hr>
<div class="btn btn-sm btn-danger btn-api" data-group_code="<?php echo $group['group_code']; ?>" data-delete=1 data-url="<?php echo XSYSTEM_APP_URL; ?>api/group/setting/" data-done="form_done">グループ消去</div>
<?php } ?>
</div>


</div>
</div>

<div>&nbsp;</div>
<?php 
if(isset($group['objects']['group_profile'])){
  foreach($group['objects']['group_profile'] as $object){ 
    foreach($group_profiles as $index=>$profile_item){
      if($object['object_name'] == $profile_item){
        echo '<div class="content-block">';
        echo '<div style="color:#428bca;font-weight:bold;">' . convert_jp($object['object_name']) . ':</div>';
        echo $object['object'];
        echo '<div style="text-align:right">';
        echo '<div class="tag active-green btn-ajax" data-group_code="' . $group_code . '" data-url="' . $url . '" data-object_code="' . $object['object_code'] . '" data-object_num=' . $index . '>編集</div>';
        echo '</div>';
        echo '</div>';
      }
    }
  }
}
?>

<?php if(isset($group_code) && $group_code != ''){ ?>
<div class="content-block text-center">
<div id="btn-add" class="btn btn-primary btn-lg btn-ajax" <?php echo $data_group_code; ?> data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/group/profile_menu/">プロフィール追加</div>
</div>
<?php } ?>
