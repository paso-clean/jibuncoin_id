<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
$userIns = new User();

$app_name = $url_param[4];

$email = $_POST['email'];
$password = $_POST['password'];


// $userIns->delete_expired_session();

if($user = $userIns->login($email,$password)){
    $session = $user['session'];
}


if(isset($session['session_code'])){
    if($user['secure'] == 0){
        setcookie("xsystem_" . XSYSTEM_APP . "_session",$session['session_code'],time()+60*60*24*30,APP_URI . '/' . XSYSTEM_APP);
        $redirect = APP_URL . $_COOKIE['app_name'] . '/';
        $data['redirect'] = $redirect;
        $data['status'] = 1;
    }else{
        $redirect = XSYSTEM_APP_URL . 'login/sotauth/' . $session['session_code'] . '/';
        $data['redirect'] = $redirect;
        $data['status'] = 1;
    }
}else{
    $data['error'] = 'IDもしくはパスワードに誤りがあります。';
    $data['status'] = 0;
}



echo json_encode($data);

?>