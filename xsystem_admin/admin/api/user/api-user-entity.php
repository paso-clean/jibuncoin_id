<?php
require_once XSYSTEM_ADMIN_APP_DIR . 'class/class-admin.php';
$adminIns = new Admin();

if(isset($_POST['method'])){
    $method = strtoupper( $_POST['method'] );
    if($method == 'GET'){

    }elseif($method == 'POST'){

    }elseif($method == 'PUT'){

    }elseif($method == 'DELETE'){
        $app = $_POST['app'];
        $user_code = $_POST['user_code'];
//         $user_code = $url_param[4];
        $status = $adminIns->delete_user($app,$user_code);
//         $data['status'] = 1;
        $data['msg'] = $user_code . 'ユーザーを削除しました。';
    }else{
        $data['status'] = 0;
        $data['msg'] = 'ERROR.';
    }
}else{
    $data['status'] = 0;
    $data['msg'] = 'ERROR.';
}


echo json_encode($data);

?>