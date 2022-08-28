<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
require_once XSYSTEM_COMMON_DIR . 'lib/phpqrcode/qrlib.php';

if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
  $redirect = XSYSTEM_APP_URL . 'login/';
  header("Location: $redirect");
  exit;
}else{
  $userIns = new User();
  if($user = $userIns->get_user_by_session($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
    $session_code = $_COOKIE['xsystem_' . XSYSTEM_APP . '_session'];
    if($userIns->is_secure_lock($session_code)){
        setcookie('xsystem_' . XSYSTEM_APP . '_session',$session_code,time()+60*60*24*30,APP_URI);
        $redirect = XSYSTEM_APP_URL . 'secure/onetime/' . $session_code;
        header("Location: $redirect");
        exit;
    }
  }else{
    setcookie('xsystem_' . XSYSTEM_APP . '_session', "", time() - 30,APP_URI);
    $redirect = XSYSTEM_APP_URL . 'login/';
    header("Location: $redirect");
    exit;
    
  }
}


// $qr_url = XSYSTEM_IMG_URL .  'user/qr/' . $user['user_code'] . '.png';
$qr_dir = XSYSTEM_IMG_DIR . 'user/qr/';
if(!file_exists($qr_dir)){
  mkdir($qr_dir, 0755);
}
$qr = $qr_dir . 'qr_' . $user['user_code'] . '.png';
if(!file_exists($qr)){
    $content = XSYSTEM_APP_URL . 'user/content/' . $user['user_code'] . '/';
    QRcode::png($content, $qr, QR_ECLEVEL_M, 6);
}


// if(isset($apps[XSYSTEM_APP]) && count($apps[XSYSTEM_APP]) != 0){
//     $apps = $apps[XSYSTEM_APP];
// }else{
//   $apps = array();
// }


$apps_num = count($apps[XSYSTEM_APP]);
if($apps_num == 1){
  $init_num = 0;
}elseif (($apps_num % 2) == 1){
    $init_num = (floor($apps_num / 2));
}else {
    $init_num = (floor($apps_num / 2) - 1);
}


// $init_num = 1;

?>
<html>
<head>
<title>XSYSTEM app</title>
<meta name=”description“ content=“ジブンコイン・アプリケーション“>
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo XSYSTEM_ASSET_URL; ?>img/apple-icon.png">
<link rel="icon" type="image/png" href="<?php echo XSYSTEM_ASSET_URL; ?>img/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>css/swiper-bundle.min.css">


<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>css/swiper-bundle.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/css/all.min.css">
<link href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>cropper/css/cropper.css" rel="stylesheet" />
<link href="<?php echo XSYSTEM_ASSET_URL; ?>css/app.css?p=<?php echo xsystem_random_num(16); ?>" rel="stylesheet" />

</head>
<body>
<div class="wrapper">

<div id="pc-sidebar">
<div class="logo-div">
<img class="logo btn-app" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/app/menu/" src="<?php echo XSYSTEM_ASSET_URL; ?>img/logo.png">
</div>
<div>
<div class="btn-profile user_img btn-ajax" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/user/profile/">
<img class="reload_class_<?php echo $user['objects']['user_img'][0]['object_code']; ?>" style="width:40px;height:40px" src="<?php echo XSYSTEM_IMG_URL; ?>user/thum/<?php echo $user['objects']['user_img'][0]['object']; ?>">
<?php echo $user['name1'] . ' ' . $user['name2']; ?>
</div>
</div>
<div class="menu">
<div>

<?php for($i=0;$i<count($apps[XSYSTEM_APP]);$i++){ ?>
<?php if($i == $init_num){ ?>
    <div id="position-<?php echo $i; ?>-btn" class="position-btn pointer btn-slide active" data-panel=<?php echo $i; ?>><?php echo $apps[XSYSTEM_APP][$i]['title']; ?></div>
<?php }else{ ?>
    <div id="position-<?php echo $i; ?>-btn" class="position-btn pointer btn-slide"  data-panel=<?php echo $i; ?>><?php echo $apps[XSYSTEM_APP][$i]['title']; ?></div>
<?php } ?>
<?php } ?>
</div>
</div>
</div><!-- /pc-sidebar -->


<div id="sp-headerbar">
<div class="login-community btn-community-app btn-app" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/server/menu/"><img src="<?php echo XSYSTEM_ASSET_URL; ?>img/logo.png" ></div>
<div class="header-title"></div>
<div class="login-user btn-ajax" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/user/profile/"><img id="header-user-icon" class="pointer reload_class_<?php echo $user['objects']['user_img'][0]['object_code']; ?>" src="<?php echo XSYSTEM_IMG_URL; ?>user/thum/<?php echo $user['objects']['user_img'][0]['object']; ?>" ></div>
</div>


<div id="main-content">
<div id="swiper-container" class="swiper-container" data-num=<?php echo count($apps[XSYSTEM_APP]); ?> data-init_num=<?php echo $init_num; ?>>
<div class="swiper-wrapper">

<?php for($i=0;$i<count($apps[XSYSTEM_APP]);$i++){ ?>
<div class="swiper-slide slide-panel" data-module="">
<div id="panel<?php echo $i; ?>-slide-content" class="slide-content" data-title="<?php echo $apps[XSYSTEM_APP][$i]['title']; ?>" data-target="#panel<?php echo $i; ?>-slide-content" data-url="<?php echo APP_URL . $apps[XSYSTEM_APP][$i]['app'] . '/' . $apps[XSYSTEM_APP][$i]['uri']; ?>"></div>
</div>
<?php } ?>


<!--
<div class="swiper-slide slide-panel" data-module="">
<div id="panel0-slide-content" class="slide-content" data-title="タイトル１" data-target="#panel0-slide-content" data-url="<?php echo XSYSTEM_APP_URL . 'ajax/app/menu/'; ?>"></div>
</div>

<div class="swiper-slide slide-panel" data-module="">
<div id="panel1-slide-content" class="slide-content" data-title="タイトル１" data-target="#panel1-slide-content" data-url="<?php echo XSYSTEM_APP_URL . 'ajax/user/menu/'; ?>"></div>
</div>

<div class="swiper-slide slide-panel" data-module="">
<div id="panel2-slide-content" class="slide-content" data-title="タイトル１" data-target="#panel2-slide-content" data-url="<?php echo XSYSTEM_APP_URL . 'ajax/app/menu/'; ?>"></div>
</div>
-->


</div><!-- /swiper-wrapper -->
</div><!-- /swiper-container -->
</div><!-- /main-content -->


<div id="sp-footerbar">
<div>
<?php for($i=0;$i<count($apps[XSYSTEM_APP]);$i++){ ?>
<?php if($i == $init_num){ ?>
<span id="position-<?php echo $i; ?>-dot" class="position-dot pointer btn-app" style="color:#3498db;">●</span> 
<?php }else{ ?>
  <span id="position-<?php echo $i; ?>-dot" class="position-dot pointer btn-app">●</span> 
<?php } ?>
<?php } ?>
</div>
</div>


</div><!-- /wrapper -->

<div id="infomation-content" class="infomation-content" data-num=0 data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/infomation/content/">

<?php require_once XSYSTEM_APP_DIR  . '/include/include-modal.php'; ?>


<div id="loader-bg">
  <div id="loader">
    <img src="<?php echo XSYSTEM_ASSET_URL; ?>img/loading_img.png?p=<?php echo xsystem_random_num(5) ?>" class="loading-img" width="80" height="80" alt="Now Loading..." />
    <p id="loading-msg"></p>
  </div>
</div>

<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery-ui.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.ui.touch-punch.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>cropper/js/cropper.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/js/all.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/common.js?p=<?php echo xsystem_random_num(16); ?>"></script>
<script src="<?php echo XSYSTEM_ASSET_URL; ?>js/app.js?p=<?php echo xsystem_random_num(16); ?>"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/common-cropper.js"></script>

<script>

$(function(){
	$(document).ready(function(){
		start_loading();
        $.when(
          reload_slide_panel()
        ).done(function(){ 
            setTimeout(function(){
                end_loading();},1000
            );
        });
	});
});


const appSwiper = new Swiper('.swiper-container', {
	loop: false,
	initialSlide: $('#swiper-container').data('init_num'),
});

appSwiper.on('slideChange', function () {
    $('.position-dot').css('color','#333');
	$('.position-btn').removeClass('active');
	const index = appSwiper.realIndex;
	const obj = $('#panel' + index + '-slide-content');
	$('.header-title').text($(obj).data('title'));
	$('#position-' + index + '-dot').css('color','#3498db');
	$('#position-' + index + '-btn').addClass('active');
});

appAction.slide_panel = function(obj){
	const panel = $(obj).data('panel');
	appSwiper.slideTo(panel);
}

apiAction.secure_done = function(data){
	if(data.status == 0){
		alert('error.');
	}else{
		const tmp = data.secure;
		let secure;
		if(tmp == 0){
			secure = 1;
			$('#btn-secure').removeClass('btn-primary');
		}else{
			secure = 0;
			$('#btn-secure').addClass('btn-primary');
		}
		$('#btn-secure').data('secure',secure);
		
	}
}


</script>

</body>
</html>