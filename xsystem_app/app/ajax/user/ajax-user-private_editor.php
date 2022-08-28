<?php
require_once XSYSTEM_COMMON_DIR . '/class/class-user.php';
if(!isset($_COOKIE['xsystem_app_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);
?>

<div style="background:#fff;padding:5px;margin:5px;border-radius:5px;">

<form id="form-user" class="form-user">

<div class="row">
<div class="form-group col-sm-4">
<label id="label-name1" for="name1">姓</label>
<input type="text" class="form-control" id="name1" name="name1" value="" placeholder="山田">
</div>
<div class="form-group col-sm-4">
<label id="label-name2" for="name2">名</label>
<input type="text" class="form-control" id="name2" name="name2" value="<?php echo $user['name2']; ?>" placeholder="太郎">
</div>
</div>

<div class="row">
<div class="form-group col-sm-4">
<label id="label-name1-kana" for="text4a">セイ</label>
<input type="text" class="form-control" id="name1-kana" name="name1_kana" value="<?php echo $user['name1_kana']; ?>" placeholder="ヤマダ">
</div>
<div class="form-group col-sm-4">
<label id="label-name2-kana" for="name2-kana">メイ</label>
<input type="text" class="form-control" id="name2-kana" name="name2_kana" value="<?php echo $user['name2_kana']; ?>" placeholder="タロウ">
</div>
</div>

<hr>

<div class="row">
<div class="form-group col-sm-4">
<label id="label-zipcode" for="text4a">〒</label>
<input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo $user['zipcode']; ?>" placeholder="000-0000">
</div>
</div>


<div class="row">
<div class="form-group col-sm-12">
<label id="label-address" for="address">住所</label>
<input type="text" class="form-control"  id="address" name="address" value="<?php echo $user['address']; ?>" placeholder="">
</div>
</div>

<input type="hidden" class="form-control"  id="address1" name="address1" value="<?php echo $user['address1']; ?>">
<input type="hidden" class="form-control"  id="address2" name="address2" value="<?php echo $user['address2']; ?>">
<input type="hidden" class="form-control"  id="address3" name="address3" value="<?php echo $user['address3']; ?>">


<div class="row">
<div class="form-group col-sm-4">
<label id="label-tel"  for="tel">TEL</label>
<input type="text" class="form-control" id="tel" name="tel" value="<?php echo $tel; ?>" placeholder="000-0000-0000">
</div>
</div>

<div class="row" style="padding:20px;">
<div class="birth-select">
<label for="label-birth-year">生年月日</label>
<select class="form-control" id="birth_year" name="birth_year">
<?php
for($i=2021;$i>=1930;$i--){
	$selected = '';
	if(isset($birth_year) && $birth_year == $i){
		$selected = 'selected';
	}
	echo '<option value="' . $i  . '" ' . $selected . '>' . $i . '年</option>' . PHP_EOL;
}
?>
</select>
</div>
<div class="birth-select">
<select class="form-control" id="birth_month" name="birth_month">
<?php
for($i=1;$i<=12;$i++){
	$selected = '';
	if(isset($birth_month) && $birth_month == $i){
		$selected = 'selected';
	}
	echo '<option value="' . $i  . '" ' . $selected . '>' . $i . '月</option> ' . PHP_EOL;
}
?>
</select>
</div>
<div class="birth-select">
<select class="form-control" id="birth_day" name="birth_day">
<?php
for($i=1;$i<=31;$i++){
	$selected = '';
	if(isset($birth_day) && $birth_day == $i){
		$selected = 'selected';
	}
	echo '<option value="' . $i  . '" ' . $selected . '>' . $i . '日</option>' . PHP_EOL;
}
?>
</select>
</div>
</div>

<!--
<?php
echo '<div class="form-check form-check-inline">';
$checked = ($sex == 'man') ? 'checked' : '';
echo '<input class="form-check-input" type="radio" name="sex" id="man" value="man" ' . $checked . '>';
echo '<label class="form-check-label" for="man"> 男性</label>&nbsp;&nbsp;&nbsp;&nbsp;';

$checked = ($sex == 'woman') ? 'checked' : '';
echo '<input class="form-check-input" type="radio" name="sex" id="woman" value="woman" ' . $checked . '>';
echo '<label class="form-check-label" for="woman"> 女性</label>&nbsp;&nbsp;&nbsp;&nbsp;';

$checked = ($sex == 'gender_free') ? 'checked' : '';
echo '<input class="form-check-input" type="radio" name="sex" id="gender_free" value="gender_free" ' . $checked . '>';
echo '<label class="form-check-label" for="gender_free"> ジェンダーフリー</label>';
echo '</div>';
echo '<hr>';
?>
-->


<div class="row">
<div class="form-group col-sm-6">
<label id="label-email" for="email">email</label>
<input type="text" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" placeholder="">
</div>
</div>

<div class="row">
<div class="form-group col-sm-6">
<label id="label-email2" for="email2">email(確認)</label>
<input type="text" class="form-control" id="email2" name="email2" value="<?php echo $user['email']; ?>" placeholder="">
</div>
</div>

<div class="row">
<div class="form-group col-sm-6">
<label id="label-password" for="passwordl">パスワード</label>
<input type="password" class="form-control" id="password" name="password" value="" placeholder="">
</div>
</div>

<div class="row">
<div class="form-group col-sm-6">
<label id="label-password2" for="email2">パスワード(確認)</label>
<input type="password" class="form-control" id="password2" name="password2" value="" placeholder="">
</div>
</div>


<hr>

<div style="text-align:center;"><button type="button" class="btn btn-primary btn-user-private" data-api="">設定</button></div>

</form>


</div>

