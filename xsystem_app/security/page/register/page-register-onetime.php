<?php
require_once XSYSTEM_APP_DIR . 'class/class-register.php';


$register_code = '';
$register = new Register();

$code = $url_param[3];

if(isset($code)){
	$register_data = $register->onetime($code);
	if(is_array($register_data)){
		$register_code = $register_data['register_code'];
	}else{
		header("HTTP/1.0 404 Not Found");
		$register_code = null;
	}
}

?>
<html>
<head>
<title>XSYSTEM app</title>
<meta name=”description“ content=“ジブンコイン・アプリケーション“>
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo XSYSTEM_ASSET_URL; ?>img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?php echo XSYSTEM_ASSET_URL; ?>img/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/css/all.min.css">
  <link href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>cropper/css/cropper.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo XSYSTEM_ASSET_URL; ?>css/content.css">


</head>
<body>
<div class="wrapper">


<div id="main-content">
<div class="swiper-container">
<div class="swiper-wrapper">

<div id="init-content" class="btn-ajax" data-fixed=1 data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/register/password_setting/<?php echo $code; ?>/"></div>


</div><!-- /swiper-wrapper -->
</div><!-- /swiper-container -->
</div><!-- /main-content -->


</div><!-- /wrapper -->



<?php require_once XSYSTEM_COMMON_DIR  . 'include/include-modal.php'; ?>

<div id="loader-bg">
  <div id="loader">
    <img src="<?php echo XSYSTEM_ASSET_URL; ?>img/loading_img.png" class="loading-img" width="80" height="80" alt="Now Loading..." />
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
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/common-cropper.js?p=<?php echo xsystem_random_num(16); ?>"></script>

<script>
$(function(){
  
	$(document).ready(function(){
		start_loading();
        $.when(
            $('#init-content').click(),
        ).done(function(){ 
            setTimeout(function(){
                end_loading();},1000
            );
        });
	});
});


ajaxAction.user_img = function(obj){
  const target = $(obj).data('target');
  formData = new FormData();
  formData.append('url', $(obj).data('url'));
  formData.append('password', $('#password').val());


	$.ajax({
		  url:formData.get('url'),
			type:'POST',
			data:formData,
		  contentType: false,
		  processData: false,
	})
	.done( (data) => {
    $(target).html(data);
	})
	.fail( (data) => {
		alert($(obj).data('url') + ' error.');
	});
}

apiAction.register_complete = function(obj){	
  const form_id = $(obj).data('form_id');
  const target = $(obj).data('target');
  canvas = $('#croppedCanvas-' + form_id)[0].toDataURL();
	let base64Data = canvas.split(',')[1];
	let data = window.atob(base64Data);
	let buff = new ArrayBuffer(data.length);
	let arr = new Uint8Array(buff);
	let blob;
	let i;
	let dataLen;
	let formData;
  for( i = 0, dataLen = data.length; i < dataLen; i++){
    arr[i] = data.charCodeAt(i);
  }
  blob = new Blob([arr], {type: 'image/png'});
	formData = new FormData();
	formData.append('url', $(obj).data('url'));
	formData.append('target', target);
	formData.append('upfile', blob);
	apiAction['form'](formData);

}
</script>

</body>
</html>