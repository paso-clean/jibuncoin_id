<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-user.php';
$userIns = new User();

$session_name = $url_param[4];
$session_code = $url_param[5];
$base64 = $url_param[6];
$json = base64_decode($base64);
$param = json_decode($json,true);
$entry = $param['entry'];

// $session_code = xsystem_random_code(16);


if(!$userIns->is_session_by_name($session_name)){
    $user = $userIns->get_user_by_session($_COOKIE['xsystem_app_session']);
//     $userIns->create_response_security_session('login_sotauth',$session_name,$session_code,$entry);
    $userIns->create_response_user_security_session('login_sotauth',$user['user_code'],$session_name,$session_code,$entry);
}

$sotauth_api = XSYSTEM_APP_URL . 'api/sotauth/login/' . $session_name . '/' . $session_code . '/';
$domain = $_SERVER['HTTP_HOST'];


$name = $user['name1'] . ' ' . $user['name2'];


?>
<div style="padding:20px 0 20px 0;">
<div style="padding:5px;"><?php echo $domain; ?></div>
<div>
<div class="text-center" style="font-size:80px;"><i class="fa-solid fa-shield-halved"></i></div>
<div style="padding:5px;">SecureOneTime Authentication</div>
</div>
<div style="padding:10px;margin:10px 0 5px 0;"><span class="license"><?php echo $name; ?></span></div>
<div>
<form style="padding:20px" >
<div style="text-align:center;"><button type="button" id="btn-login" class="btn btn-primary btn-lg btn-api" data-url="<?php echo $sotauth_api; ?>">ログイン許可</button></div>
</form>