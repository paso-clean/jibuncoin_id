<?php
require_once XSYSTEM_APP_DIR . '/class/class-user.php';
$userIns = new User();
if($session_code = $url_param[4]){
    $user = $userIns->get_user_by_session($session_code);
    $userIns->update_user_secure($user['user_code'],$_POST['secure']);
    $data['status'] = 1;
    $data['secure'] = $_POST['secure'];
}else{
    $data['status'] = 0;
}





echo json_encode($data);

?>