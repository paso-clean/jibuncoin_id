<?php

$name1 = (isset($_SESSION['name1'])) ? $_SESSION['name1'] : '';
$name2 = (isset($_SESSION['name2'])) ? $_SESSION['name2'] : '';
$name1_kana = (isset($_SESSION['name1_kana'])) ? $_SESSION['name1_kana'] : '';
$name2_kana = (isset($_SESSION['name2_kana'])) ? $_SESSION['name2_kana'] : '';

$nickname = (isset($_SESSION['nickname'])) ? $_SESSION['nickname'] : '';

$zipcode = (isset($_SESSION['zipcode'])) ? $_SESSION['zipcode'] : '';
$address = (isset($_SESSION['address'])) ? $_SESSION['address'] : '';
$address1 = (isset($_SESSION['address1'])) ? $_SESSION['address1'] : '';
$address2 = (isset($_SESSION['address2'])) ? $_SESSION['address2'] : '';
$address3 = (isset($_SESSION['address3'])) ? $_SESSION['address3'] : '';


$tel = (isset($_SESSION['tel'])) ? $_SESSION['tel'] : '';

$birth_year = (isset($_SESSION['birth_year'])) ? $_SESSION['birth_year'] : '';
$birth_month = (isset($_SESSION['birth_month'])) ? $_SESSION['birth_month'] : '';
$birth_day = (isset($_SESSION['birth_day'])) ? $_SESSION['birth_day'] : '';

$sex = (isset($_SESSION['sex'])) ? $_SESSION['sex'] : '';

$email = (isset($_SESSION['email'])) ? $_SESSION['email'] : '';
$email2 = (isset($_SESSION['email2'])) ? $_SESSION['email2'] : '';


$password = (isset($_SESSION['password'])) ? $_SESSION['password'] : '';
$password2 = (isset($_SESSION['password2'])) ? $_SESSION['password2'] : '';


?>

<form id="form-user" class="form-register">
<div class="row">
<div class="form-group col-sm-12">
<div id="form-comment">会員情報を入力してください。</div>
</div>
</div>

<div class="row">
<div class="form-group col-sm-4">
<label id="label-name1" for="name1">姓</label>
<input type="text" class="form-control" id="name1" name="name1" value="<?php echo $name1; ?>川村" placeholder="山田">
</div>
<div class="form-group col-sm-4">
<label id="label-name2" for="name2">名</label>
<input type="text" class="form-control" id="name2" name="name2" value="<?php echo $name2; ?>宜浩" placeholder="太郎">
</div>
</div>

<div class="row">
<div class="form-group col-sm-4">
<label id="label-name1-kana" for="text4a">セイ</label>
<input type="text" class="form-control" id="name1-kana" name="name1_kana" value="<?php echo $name1_kana; ?>カワムラ" placeholder="ヤマダ">
</div>
<div class="form-group col-sm-4">
<label id="label-name2-kana" for="name2-kana">メイ</label>
<input type="text" class="form-control" id="name2-kana" name="name2_kana" value="<?php echo $name2_kana; ?>ヨシヒロ" placeholder="タロウ">
</div>
</div>

<hr>

<div class="row">
<div class="form-group col-sm-4">
<label id="label-zipcode" for="text4a">〒</label>
<input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo $zipcode; ?>4091502" data-api="<?php echo XSYSTEM_APP_URL; ?>api/register/zipcode/" placeholder="000-0000">
</div>
</div>


<div class="row">
<div class="form-group col-sm-12">
<label id="label-address" for="text4a">住所</label>
<input type="text" class="form-control"  id="address" name="address" value="<?php echo $address; ?>山梨県北杜市大泉町谷戸4327-1" placeholder="">
</div>
</div>

<input type="hidden" class="form-control"  id="address1" name="address1" value="<?php echo $address1; ?>山梨県">
<input type="hidden" class="form-control"  id="address2" name="address2" value="<?php echo $address2; ?>北杜市">
<input type="hidden" class="form-control"  id="address3" name="address3" value="<?php echo $address3; ?>大泉町谷戸">


<div class="row">
<div class="form-group col-sm-4">
<label id="label-tel"  for="tel">TEL</label>
<input type="text" class="form-control" id="tel" name="tel" value="<?php echo $tel; ?>09039992399" placeholder="000-0000-0000">
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
	echo '<option value="' . $i  . '" ' . $selected . '>' . $i . '年</option>' .PHP_EOL;
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
	echo '<option value="' . $i  . '" ' . $selected . '>' . $i . '月</option>';
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
	echo '<option value="' . $i  . '" ' . $selected . '>' . $i . '日</option>';
}
?>
</select>
</div>
</div>


<div class="form-check form-check-inline">
<input class="form-check-input" type="radio" name="sex" id="man" value="man" <?php if($sex == 'man' || $sex == ''){ echo 'checked';} ?>>
<label class="form-check-label" for="man"> 男性</label>&nbsp;&nbsp;&nbsp;&nbsp;

<input class="form-check-input" type="radio" name="sex" id="woman" value="woman" <?php if($sex == 'woman'){ echo 'checked';} ?>>
<label class="form-check-label" for="woman"> 女性</label>&nbsp;&nbsp;&nbsp;&nbsp;

<input class="form-check-input" type="radio" name="sex" id="gender_free" value="gender_free" <?php if($sex == 'gender_free'){ echo 'checked';} ?>>
<label class="form-check-label" for="gender_free"> ジェンダーフリー</label>
</div>

<hr>

<div class="row">
<div class="form-group col-sm-6">
<label id="label-email" for="email">email</label>
<input type="text" class="form-control" id="email" name="email" data-api="<?php echo XSYSTEM_APP_URL;  ?>api/register/check_email/" value="<?php echo $email; ?>info@sotauth.com" placeholder="yamada@example.com">
</div>
</div>

<div class="row">
<div class="form-group col-sm-6">
<label id="label-email2" for="email2">email(確認)</label>
<input type="text" class="form-control" id="email2" name="email2" value="<?php echo $email2; ?>info@sotauth.com" placeholder="yamada@example.com">
</div>
</div>


<hr>

<div style="text-align:center;"><button type="button" class="btn btn-primary btn-ajax" data-action="register_confirm" data-url="<?php echo XSYSTEM_APP_URL;  ?>ajax/register/confirm/">登録</button></div>

</form>
