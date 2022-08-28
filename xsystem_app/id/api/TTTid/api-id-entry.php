<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
$userIns = new User();


$cmd = $url_param[4];

if($cmd == 'set_security'){
    $session_name = $url_param[5];
    $security_code = $url_param[6];
    $json = base64_decode($url_param[7]);
    $data = json_decode($json,true);
    $entry = $data['entry'];
    $redirect = $data['redirect'];
    $app_url = $data['app_url'];
    $userIns->set_security($session_name,$security_code,$entry);
    
    $param['entry'] = XSYSTEM_APP_URL . 'api/id/entry/';
    $param['redirect'] = $redirect;
    $param['app_url'] = $app_url;
    $json = json_encode($param);
    $base64 = base64_encode($json);
    
    $url = $entry . 'security/' .  $session_name . '/' . $security_code . '/' . $base64 . '/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res =  curl_exec($ch);
    $json = json_decode($res, true);
    curl_close($ch);

}elseif($cmd == 'set_sotauth_security'){
    $session_name = $url_param[5];
    $security_code = $url_param[6];
    $json = base64_decode($url_param[7]);
    $data = json_decode($json,true);
    $entry = $data['entry'];
    $userIns->set_security($session_name,$security_code,$entry);
    
    $entry = XSYSTEM_COMMON_URL . 'api/id/entry/';
    $url = $entry . 'sotauth_security/' .  $session_name . '/' . $security_code . '/';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res =  curl_exec($ch);
    $json = json_decode($res, true);
    curl_close($ch);

}elseif($cmd == 'sotauth_security'){
    $session_name = $url_param[5];
    $security_code = $url_param[6];
    $userIns->linkage_open($session_name,$security_code,'TTT');
}elseif($cmd == 'security'){
    $session_name = $url_param[5];
    $security_code = $url_param[6];
    $json = base64_decode($url_param[7]);
    $data = json_decode($json,true);
    $entry = $data['entry'];
    $redirect = $data['entry'];
    $userIns->linkage_open($session_name,$security_code,$entry);
}elseif($cmd == 'id_linkage'){
    $session_name = $url_param[5];
    $session_code = $url_param[6];
    $user = $userIns->get_user_by_entry($session_name,$session_code);
    $user['img_url'] = APP_URL . XSYSTEM_PRODUCT . '/img/';
    $json = json_encode($user);
    $userIns->delete_session_by_name($session_name,$cmd);
    echo $json;
}elseif($cmd == 'login_linkage'){
    $session_name = $url_param[5];
    $session_code = $url_param[6];
    $user = $userIns->get_user_by_entry($session_name,$session_code);
    $user['img_url'] = APP_URL . XSYSTEM_PRODUCT . '/img/';
    $json = json_encode($user);
//     $userIns->delete_session_by_name($session_name,$cmd);
    echo $json;
}elseif($cmd == 'security_info'){
    $session_name = $url_param[5];
    $session_code = $url_param[6];
    $session = $userIns->get_session_by_name($session_name,$session_code);
    $userIns->active_session($session_name,$security_code,1);
    $json = json_encode($session);
    $userIns->active_session($session_name,$security_code,1);
    
    echo $json;
}elseif($cmd == 'entity'){
    $session_name = $url_param[5];
    $session_code = $url_param[6];
    $entity['status'] = 'TTT';
    $entity['target_code'] = $session_code;
    echo json_encode($entity);
}

?>