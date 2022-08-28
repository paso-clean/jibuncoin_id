<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-htaccess.php';

$htaccess = new Htaccess();
$active_apps = $htaccess->active_admin_apps();
$dirs = scandir(XSYSTEM_DIR . XSYSTEM_PRODUCT . '_admin/');

$excludes = array(
    '.',
    '..',
    '.htaccess',
);
$apps = array();
$boot_apps = array();
foreach ($dirs AS $dir) {
    if (in_array($dir, $excludes)) {
        continue;
    }

    $dir_path = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_admin/' . $dir;
    if (is_dir($dir_path)) {
      foreach($active_apps as $active_app){
        if($dir == $active_app){
          $require_file = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_admin/' . $dir . '/xsystem-admin-app-config.php';
          if(file_exists($require_file)){
            require_once $require_file;
          }
        }

      }
    }
}

if(isset($apps[$app_name]) && count($apps[$app_name]) != 0){
  $apps = $apps[$app_name];
}else{
  $apps = array();
}


$apps_num = count($apps);
if($apps_num == 1){
  $init_num = 0;
}elseif (($apps_num % 2) == 1){
    $init_num = (floor($apps_num / 2));
}else {
    $init_num = (floor($apps_num / 2) - 1);
}


$init_num = 1;

?>

<html>
<head>
<title>XSYSTEM app</title>
<meta name=”description“ content=“ジブンコイン・アプリケーション“>
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo XSYSTEM_ADMIN_ASSET_URL; ?>img/apple-icon.png">
<link rel="icon" type="image/png" href="<?php echo XSYSTEM_ADMIN_ASSET_URL; ?>img/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>css/swiper-bundle.min.css">


<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>css/swiper-bundle.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/css/all.min.css">
<link href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>cropper/css/cropper.css" rel="stylesheet" />
<link href="<?php echo XSYSTEM_ADMIN_ASSET_URL; ?>css/app.css?p=<?php echo xsystem_random_num(16); ?>" rel="stylesheet" />

</head>
<body>
<div class="wrapper">

<div id="pc-sidebar">
<div class="logo-div">
<img class="logo btn-app" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/app/menu/" src="<?php echo XSYSTEM_ADMIN_ASSET_URL; ?>img/logo.png">
</div>
<div>
<div class="btn-profile profile_img btn-app"><?php echo $user_login; ?></div>
</div>
<div class="menu">
<div>
<?php for($i=0;$i<count($apps);$i++){ ?>
<?php if($i == $init_num){ ?>
    <div id="position-<?php echo $i; ?>-btn" class="position-btn pointer btn-app active" data-action="slide_panel" data-panel=<?php echo $i; ?>><?php echo $apps[$i]['title']; ?></div>
<?php }else{ ?>
    <div id="position-<?php echo $i; ?>-btn" class="position-btn pointer btn-app" data-action="slide_panel" data-panel=<?php echo $i; ?>><?php echo $apps[$i]['title']; ?></div>
<?php } ?>
<?php } ?>
</div>
</div>
</div><!-- /pc-sidebar -->


<div id="sp-headerbar">
<div class="login-community btn-community-app btn-app" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/server/menu/"><img src="<?php echo XSYSTEM_ADMIN_ASSET_URL; ?>img/logo.png" ></div>
<div class="header-title"></div>
</div>


<div id="main-content">
<div id="swiper-container" class="swiper-container" data-num=<?php echo count($apps); ?> data-init_num=<?php echo $init_num; ?>>
<div class="swiper-wrapper">


<?php for($i=0;$i<count($apps);$i++){ ?>
<div class="swiper-slide slide-panel" data-module="">
<div id="panel<?php echo $i; ?>-slide-content" class="slide-content" data-title="<?php echo $apps[$i]['title']; ?>" data-target="#panel<?php echo $i; ?>-slide-content" data-url="<?php echo APP_URL . $apps[$i]['app'] . '/' . $apps[$i]['uri']; ?>"></div>
</div>
<?php } ?>


</div><!-- /swiper-wrapper -->
</div><!-- /swiper-container -->
</div><!-- /main-content -->


<div id="sp-footerbar">
<div>
<?php for($i=0;$i<count($apps);$i++){ ?>
<?php if($i == $init_num){ ?>
<span id="position-<?php echo $i; ?>-dot" class="position-dot pointer btn-app" style="color:#3498db;">●</span> 
<?php }else{ ?>
  <span id="position-<?php echo $i; ?>-dot" class="position-dot pointer btn-app">●</span> 
<?php } ?>
<?php } ?>
</div>
</div>


</div><!-- /wrapper -->


<?php require_once XSYSTEM_COMMON_DIR  . '/include/include-modal.php'; ?>


<div id="loader-bg">
  <div id="loader">
    <img src="<?php echo XSYSTEM_ADMIN_ASSET_URL; ?>img/loading_img.png" class="loading-img" width="80" height="80" alt="Now Loading..." />
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
<script src="<?php echo XSYSTEM_ADMIN_ASSET_URL; ?>js/admin.js?p=<?php echo xsystem_random_num(16); ?>"></script>
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
</script>

</body>
</html>