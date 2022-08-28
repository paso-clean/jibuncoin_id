<?php
require_once XSYSTEM_APP_DIR . 'class/class-register.php';
$register = new Register();

if($register->is_duplicate_user_by_email($_POST['email'])){
    $is_dup = true;
}else{
    $is_dup = false;
}

if($_POST['name1'] != ''){
    $_SESSION['name1'] = $_POST['name1'];
}

if($_POST['name2'] != ''){
    $_SESSION['name2'] = $_POST['name2'];
}

if($_POST['name1_kana'] != ''){
    $_SESSION['name1_kana'] = $_POST['name1_kana'];
}

if($_POST['name2_kana'] != ''){
    $_SESSION['name2_kana'] = $_POST['name2_kana'];
}

if($_POST['zipcode'] != ''){
    $_SESSION['zipcode'] = $_POST['zipcode'];
}

if($_POST['address'] != ''){
    $_SESSION['address'] = $_POST['address'];
}

if($_POST['address1'] != ''){
    $_SESSION['address1'] = $_POST['address1'];
}

if($_POST['address2'] != ''){
    $_SESSION['address2'] = $_POST['address2'];
}

if($_POST['address3'] != ''){
    $_SESSION['address3'] = $_POST['address3'];
}

if($_POST['tel'] != ''){
    $_SESSION['tel'] = $_POST['tel'];
}

if($_POST['birth_year'] != ''){
    $_SESSION['birth_year'] = $_POST['birth_year'];
}

if($_POST['birth_month'] != ''){
    $_SESSION['birth_month'] = $_POST['birth_month'];
}

if($_POST['birth_day'] != ''){
    $_SESSION['birth_day'] = $_POST['birth_day'];
}

if($_POST['tel'] != ''){
    $_SESSION['tel'] = $_POST['tel'];
}

if($_POST['sex'] != ''){
    $_SESSION['sex'] = $_POST['sex'];
}

if($_POST['email'] != ''){
    $_SESSION['email'] = $_POST['email'];
}

if($_POST['email2'] != ''){
    $_SESSION['email2'] = $_POST['email2'];
}

if($_SESSION['sex'] == 'man'){
	$sex = '男性';
}elseif($_SESSION['sex'] == 'woman'){
	$sex = '女性';
}elseif($_SESSION['sex'] == 'gender_free'){
	$sex = 'ジェンダーフリー';
}else{
	$sex = '-';
}

?>
<form id="form-user" class="form-register">
<table class="table">
<tr><td class="td-name">名前  </td><td><?php echo $_SESSION['name1'] . $_SESSION['name2']; ?></td></tr>
<tr><td class="td-name">フリガナ  </td><td><?php echo $_SESSION['name1_kana'] . $_SESSION['name2_kana']; ?></td></tr>
<?php if($is_dup){  ?>
<tr style="color:#ff0000;"><td class="td-name">Eメール  </td><td><?php echo $_SESSION['email']; ?> (登録済メールアドレス)</td></tr>
<?php }else{  ?>
<tr><td class="td-name">Eメール  </td><td><?php echo $_SESSION['email']; ?></td></tr>
<?php } ?>
<tr><td class="td-name">〒  </td><td><?php echo $_SESSION['zipcode']; ?></td></tr>
<tr><td class="td-name">住所  </td><td><?php echo $_SESSION['address']; ?></td></tr>
<tr><td class="td-name">TEL  </td><td><?php echo $_SESSION['tel']; ?></td></tr>
<tr><td class="td-name">生年月日  </td><td><?php echo $_SESSION['birth_year'] . '年' . $_SESSION['birth_month'] . '月' . $_SESSION['birth_day'] . '日'; ?></td></tr>
<tr><td class="td-name">性別  </td><td><?php echo $sex; ?></td></tr>
</table>


<div style="text-align:center;">
<div style="text-align:center;display:inline-block"><button type="button" class="btn btn-default btn-back-form">戻る</button></div>
<?php if(!$is_dup){  ?>
<div style="text-align:center;display:inline-block"><button type="button" class="btn btn-primary btn-api" data-target="#fixedModal .panelContent" data-url="<?php echo XSYSTEM_APP_URL;  ?>api/register/sendmail/">登録</button></div>
<?php }  ?>
</div>


</form>