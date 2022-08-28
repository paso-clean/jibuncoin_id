<html>
<head>
<title>XSYSTEM app</title>
<meta name=”description“ content=“ジブンコイン・アプリケーション“>
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $_COOKIE['app_name']; ?>/asset/img/apple-icon.png">
<link rel="icon" type="image/png" href="<?php echo APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $_COOKIE['app_name']; ?>/asset/img/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>css/swiper-bundle.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/css/all.min.css">
<link href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>cropper/css/cropper.css" rel="stylesheet" />
<link href="<?php echo XSYSTEM_ASSET_URL; ?>css/content.css" rel="stylesheet" />

<style>
<?php //require_once XSYSTEM_APP_DIR  . '/include/include-css-login.php'; ?>
.register_form{
  text-align:center;
  padding:30px 0 10px 0;
}
  
.repassword{
  text-align:center;
  padding:10px 0 30px 0;
}
</style>

</head>
<body>
<div class="wrapper">


<div id="main-content">
<div class="swiper-container">
<div class="swiper-wrapper">

<div id="init-content" class="btn-ajax" data-fixed=1 data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/user/login/"></div>


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
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/common.js"></script>

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

  $(document).on('keypress','#form-login',function(e){
    if (e.keyCode == 13) {
        const btn_login = $('#btn-login');
        apiAction['user_login'](btn_login);
    }
  });
});

apiAction.user_login = function(obj){
  formData = new FormData();
  formData.append('url', $(obj).data('url'));
  formData.append('done', $(obj).data('done'));
  formData.append('email', $('#email').val());
  formData.append('password', $('#password').val());
  apiAction['form'](formData);
}
apiAction.user_login_done = function(data){
  if(data.status === 1){
    window.location.href = data.redirect;
} else{
    $('#error-message').text(data.error);
  }
}

apiAction.id_transition_done = function(data){
    window.location.href = data.transition_url;
}


</script>

</body>
</html>