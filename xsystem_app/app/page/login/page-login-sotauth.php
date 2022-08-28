<html>
<head>
<title>XSYSTEM app</title>
<meta name=”description“ content=“ジブンコイン・アプリケーション“>
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo XSYSTEM_ASSET_URL; ?>img/apple-icon.png">
<link rel="icon" type="image/png" href="<?php echo XSYSTEM_ASSET_URL; ?>img/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/css/all.min.css">
<link rel="stylesheet" href="<?php echo XSYSTEM_ASSET_URL; ?>css/content.css">
<style>
  
  .loading-img{
      width:100px;
      height:100px;
      animation:3s linear infinite rotation1;
  }
  @keyframes rotation1{
    0%{ transform:rotate(0);}
    100%{ transform:rotate(360deg); }
  }
  
  #loader-bg {
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    background-color: #000;
    opacity: 0.7;
    z-index: 3000;
  }
  #loader {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 200px;
    margin-top: -100px;
    margin-left: -100px;
    text-align: center;
    color: #fff;
    z-index: 3000;
  }

</style>

</head>
<body>
<div class="wrapper">

<div id="onetime-content" class="onetime-content" 
data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/security/login/<?php echo $url_param[3]; ?>"
data-api="<?php echo XSYSTEM_APP_URL; ?>api/security/ping/<?php echo $url_param[3]; ?>"
data-redirect="<?php echo APP_URL . $_COOKIE['app_name']; ?>/"
>

</div><!-- /wrapper -->

<?php require_once XSYSTEM_COMMON_DIR  . 'include/include-modal.php'; ?>



<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery-ui.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.ui.touch-punch.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/js/all.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/common.js"></script>

<script>
$(function(){
	$(document).ready(function(){
		ajaxAction['onetime_content']();
    	const api = $('#onetime-content').data('api');
      //ping(api);
		setInterval(() => {
			//ping(api);
  		}, 500);
	});
});



ajaxAction.onetime_content = function(){
    const url = $('#onetime-content').data('url');
    const target = $('#onetime-content').data('target');

	$.ajax({
		url:url,
		type:'POST',
	})
	.done( (data) => {
        appModal.set_modal(url,data,true);
	})
	.fail( (data) => {
		alert(url + ' error.');
	});
}

function ping(url){
	$.ajax({
		url:url,
		type:'POST',
		dataType:"json",
	})
	.done( (data) => {
		if(data.status === 1){
      const redirect = $('#onetime-content').data('redirect');
      window.location.href = redirect;
    }
	})
	.fail( (data) => {
		alert(url + ' error.');
	});
}


// apiAction.sotauth_login = function(obj){
// 	formData = new FormData();
// 	formData.append('url', $(obj).data('url'));
// 	formData.append('done', $(obj).data('done'));
//     apiAction['form'](formData);
// }
// apiAction.sotauth_login_done = function(data){
// 	if(data.status === 1){
// 		modal_close();
// 	}
// }
</script>

</body>
</html>