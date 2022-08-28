
<?php
$session_name = $url_param[3];
$security_code = $url_param[4];
$base64 = $url_param[5];

if(isset($_COOKIE['xsystem_app_session']) && $_COOKIE['xsystem_app_session']){
    $ajax = XSYSTEM_APP_URL . 'ajax/sotauth/authorization/' . $session_name . '/' . $security_code . '/' . $base64 . '/';
}else{
    $ajax = XSYSTEM_APP_URL . 'ajax/sotauth/login_form/' . $session_name . '/' . $security_code . '/' . $base64 . '/';
}


?>
<html>
<head>
<title>SOTAUTH</title>
<meta name=”description“ content=“SOTAUTH“>
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo XSYSTEM_ASSET_URL; ?>img/apple-icon.png">
<link rel="icon" type="image/png" href="<?php echo XSYSTEM_ASSET_URL; ?>img/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/css/all.min.css">

<style>
body{
    background:#1e3799;
    color:#fff;
    text-align:center;
}
.license{
    padding:5px 20px 5px 20px;
    background:#fff;
    color:#1e3799;
    border-radius: 15px;

}
</style>

</head>
<body>

<div id="target-content" data-target="target-content" data-ajax="<?php echo $ajax; ?>"></div>





<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery-ui.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/jquery.ui.touch-punch.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>fontawesome/js/all.js"></script>
<script src="<?php echo XSYSTEM_COMMON_ASSET_URL; ?>js/common.js"></script>

<script>
<?php //require_once XSYSTEM_APP_DIR  . '/include/include-js-sotauth.php'; ?>
$(function(){
	$(document).ready(function(){
		init('target-content');
	});	
});

apiAction.sotauth_login = function(obj){
	formData = new FormData();
	formData.append('api', $(obj).data('api'));
	formData.append('api_done', $(obj).data('api_done'));
    apiAction['api'](formData);
}

function init(id){
	const obj = $('#' + id);
	$.ajax({
		url:$(obj).data('ajax'),
			type:'POST',
			data:obj.data(),
	})
	.done( (data) => {
        if( typeof $(obj).data('target') !== 'undefined' ) {
            $('#' + $(obj).data('target')).fadeOut(500, function() {
                $.when(
                    $('#' + $(obj).data('target')).html(data)
                ).done(function(){ 
                    $('#' + $(obj).data('target')).fadeIn(1000);
                });
            });
        }else{
		    appModal.set_modal(data);
        }

        if( typeof $(obj).data('ajax_done') !== 'undefined' ) {
            ajaxAction[obj.param.ajax_done](obj);
        }
	})
	.fail( (data) => {
		alert($(obj).data('action') + ' error.');
	});
}

apiAction.sotauth_login = function(obj){
	formData = new FormData();
	formData.append('url', $(obj).data('url'));
	formData.append('done', $(obj).data('done'));
    apiAction['api'](formData);
}
apiAction.sotauth_login_done = function(data){
	if(data.status === 1){
		appModal.unset_modal();
	}
}

apiAction.login_simple = function(obj){
	const email = $('#email').val();
	const password = $('#password').val();
	formData = new FormData();
	formData.append('url', $(obj).data('url'));
	formData.append('done', $(obj).data('done'));
	formData.append('email', email);
	formData.append('password', password);
	apiAction['form'](formData);
}

apiAction.login_simple_done = function(data){
	if(data.status == 1){
		window.location.href = data.redirect;
	}else{
		alert(data.error);
	}
}


</script>




</body>
</html>