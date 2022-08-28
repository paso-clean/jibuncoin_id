<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
$userIns = new User();

$data['status'] = 1;
if($session_code = $url_param[4]){
    if($user = $userIns->get_user_by_session($session_code)){
        if(!$userIns->is_secure_lock($session_code)){
            setcookie("xsystem_app_session",$session_code,time()+60*60*24*30,APP_URI);
            // $redirect = APP_URL . $_COOKIE['app_name'] . '/';
            // $data['redirect'] = $redirect;
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }

    }
}

// $data['redirect'] = APP_URL . $_COOKIE['app_name'] . '/';

echo json_encode($data);

?>