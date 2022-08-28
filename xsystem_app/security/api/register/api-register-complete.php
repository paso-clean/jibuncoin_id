<?php
require_once XSYSTEM_APP_DIR . 'class/class-register.php';
$register = new Register();
$code = $url_param[4];

if($register->is_register($code)){
	$content = '登録あり';
}else{
	$content = 'ERROR.';
	echo json_encode($data);
	exit;
}

$solt = xsystem_random_num(4);
$file_name = $code . '_' . $solt;
$real_file = $file_name . '.png';
$content = $register->register_user($code,$real_file);

$url = APP_URL . $_COOKIE['app_name'] . '/';



if(isset($_FILES['upfile']['tmp_name'])){
	$real_file = '';
	$is_file = true;
	$tempfile = $_FILES['upfile']['tmp_name'];
	$imginfo = getimagesize($_FILES['upfile']['tmp_name']);
	if($imginfo['mime'] == 'image/jpeg'){ $extension = ".jpg"; }
	if($imginfo['mime'] == 'image/png'){ $extension = ".png"; }
	if($imginfo['mime'] == 'image/gif'){ $extension = ".gif"; }
	$real_file = $file_name . $extension;
	$user_dir = XSYSTEM_IMG_DIR . '/user';
	$origin_dir = XSYSTEM_IMG_DIR . '/user/origin';
	$thum_dir = XSYSTEM_IMG_DIR . '/user/thum';
	$qr_dir = XSYSTEM_IMG_DIR . '/user/qr';


	if(!file_exists($user_dir)){
		mkdir($user_dir, 0755);
	}

	if(!file_exists($origin_dir)){
		mkdir($origin_dir, 0755);
	}

	if(!file_exists($thum_dir)){
		mkdir($thum_dir, 0755);
	}

	if(!file_exists($qr_dir)){
		mkdir($qr_dir, 0755);
	}

	$file_path = $origin_dir . '/' . $real_file;
    
	if ( move_uploaded_file($tempfile , $file_path )) {
		list($w, $h) = getimagesize($file_path);
		$thumbW = 100;
		$thumbH = 100;
		$thumbnail = imagecreatetruecolor($thumbW, $thumbH);

		if($extension == '.jpg'){
			$baseImage = imagecreatefromjpeg($file_path);
			imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $w, $h);
			$thum_file_path = $thum_dir . '/' . $real_file;
			imagejpeg($thumbnail, $thum_file_path);
		}elseif($extension == '.png'){
			$baseImage = imagecreatefrompng($file_path);
			imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $w, $h);
			$thum_file_path = $thum_dir . '/' . $real_file;
			imagepng($thumbnail, $thum_file_path);
		}elseif($extension == '.gif'){
			$baseImage = imagecreatefromgif($file_path);
			imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $w, $h);
			$thum_file_path = $thum_dir . '/' . $real_file;
			imagegif($thumbnail, $thum_file_path);
		}
		
		// $register->tagged($code,$real_file);
		// $register->register_user($code,$real_file);
        
		$content  = '<div class="text-center">登録完了</div><br><br>';
		$content .= '<div class="text-center"><a href="' . $url . '"><button class="btn btn-primary">ログインする</button></a></div>';


    } else {
		$is_file = false;
		$content = 'ファイルアップロード失敗';
	}
}else{
	$content  = '<div class="text-center">登録完了</div><br><br>';
	$content .= '<div class="text-center"><a href="' . $url . '"><button class="btn btn-primary">ログインする</button></a></div>';
}

$data['content'] = $content;

echo json_encode($data);

?>