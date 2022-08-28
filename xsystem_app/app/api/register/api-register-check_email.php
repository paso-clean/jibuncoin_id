<?php
require_once XSYSTEM_APP_DIR . 'class/class-register.php';

$register = new Register();


if(isset($_POST['email'])){
	$email = $_POST['email'];
}else{
	$data['content'] = 'none.';
	$data['error'] = 1;
	echo json_encode($data);
	exit;
}


if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\?\*\[|\]%'=~^\{\}\/\+!#&\$\._-])*@([a-zA-Z0-9_-])+\.([a-zA-Z0-9\._-]+)+$/", $email)) {
	$is_member_email = $register->is_duplicate_user_by_email($email);
	if($is_member_email){
		$content = '登録済みのメールアドレスです。';
		$data['error'] = 1;
	}else{
		$content = '';
		$data['error'] = 0;
	}
}else{
	if($email == ''){
		$content = 'メールアドレスが空白です。';
	}else{
		$content = 'メールアドレスではありません。';
	}
	$data['error'] = 1;
}

$data['content'] = $content;

echo json_encode($data);



?>