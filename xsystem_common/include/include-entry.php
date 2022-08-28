<?php 
require_once XSYSTEM_COMMON_DIR .'class/class-entity.php';
require_once XSYSTEM_APP_DIR .'class/class-user.php';
$entityIns = new Entity();
$userIns = new User();

$cmd = $url_param[4];
$target_type = $url_param[5];
// $session_name = $url_param[6];
// $target_code = $url_param[7];
// $base64 = $url_param[8];



if($cmd == 'request'){
    if($target_type == 'linkage'){
        $session_name = $url_param[6];
        $target_code = $url_param[7];
        $base64 = $url_param[8];
        $param = xsystem_base64_decode($base64);
        $entry = $param['entry'];
        $session_code = xsystem_random_code(16);
        $session = $entityIns->create_linkage_session($session_name,$session_code,'connection',$target_type,$target_code,$entry,1);
        $data['status'] = 1;
        echo json_encode($data);
        exit;
    }elseif($target_type == 'agent'){
        $session_name = $url_param[6];
        $target_code = $url_param[7];
        $base64 = $url_param[8];
        $param = xsystem_base64_decode($base64);
        $entry = $param['entry'];
        $linkage_entry = $param['linkage_entry'];
        
        $session_code = xsystem_random_code(16);
        $session = $entityIns->create_linkage_session($session_name,$session_code,'agent','security',$target_code,$entry,0);
        $session_code = xsystem_random_code(16);
        $session = $entityIns->create_linkage_session($session_name,$session_code,'security','agent',$session['session_code'],'',0);
        
        
        $param['entry'] =  XSYSTEM_APP_URL . 'api/connection/entry/';
        $json = json_encode($param);
        $base64 = base64_encode($json);
        
        $url = $linkage_entry . 'request/security/' . $session_name . '/' . $session['session_code'] . '/' . $base64 . '/';
        $res = xsystem_curl($url);
        
        $data['status'] = 1;
        echo json_encode($data);
        exit;
    }elseif($target_type == 'security'){
        $session_name = $url_param[6];
        $target_code = $url_param[7];
        $base64 = $url_param[8];
        $param = xsystem_base64_decode($base64);
        $entry = $param['entry'];
        
        $session_code = xsystem_random_code(16);
        $session = $entityIns->create_linkage_session($session_name,$session_code,'security','security',$target_code,$entry,1);
        $sessions = $entityIns->get_session_by_name($session_name);
        if(count($sessions) > 0){
            $param['entry'] =  XSYSTEM_APP_URL . 'api/connection/entry/';
            $base64 = xsystem_base64_encode($param);
            $url = $entry . 'response/security/' . $session_name . '/' . $target_code . '/' . $base64 . '/';
            $res = xsystem_curl($url);
        }
        
    }elseif($target_type == 'data'){
        $session_name = $url_param[6];
        $target_code = $url_param[7];
        $base64 = $url_param[8];
        $param = xsystem_base64_decode($base64);
        $entry = $param['entry'];
        $param['entry'] =  XSYSTEM_APP_URL . 'api/connection/entry/';
        $base64 = xsystem_base64_encode($param);
        $url = $entry . 'response/data/' . $session_name . '/' . $target_code . '/' . $base64 . '/';
        xsystem_log($url);
        $json = @file_get_contents($url);
        $user = json_decode($json,true);
        
        $userIns->user_id_linkage($user);
        
        $target_img_url = $user['img_url'];
        
        $objects = $user['objects'];
        $user_img_dir = XSYSTEM_IMG_DIR . 'user/';
        $origin_dir = $user_img_dir . 'origin/';
        $thum_dir = $user_img_dir . 'thum/';

        if(!file_exists($user_img_dir)){
            mkdir($user_img_dir, 0755);
        }
        
        if(!file_exists($origin_dir)){
            mkdir($origin_dir, 0755);
        }
        
        if(!file_exists($thum_dir)){
            mkdir($thum_dir, 0755);
        }
        
        $target_origin_img = $target_img_url . 'user/origin/' . $objects['user_img'][0]['object'];
        xsystem_log($target_origin_img);
        $origin_img = @file_get_contents( $target_origin_img );
        if($origin_img){
            @file_put_contents( $origin_dir . $objects['user_img'][0]['object'], $origin_img );
        }
        
        
        $target_thum_img = $target_img_url . 'user/thum/' . $objects['user_img'][0]['object'];
        $thum_img = @file_get_contents( $target_thum_img );
        if($thum_img){
            @file_put_contents( $thum_dir . $objects['user_img'][0]['object'], $thum_img );
        }
        
        echo json_encode($data);
        exit;
        
    }
    
}elseif($cmd == 'response'){
    if($target_type == 'security'){
        $session_name = $url_param[6];
        $target_code = $url_param[7];
        $base64 = $url_param[8];
        
        $entityIns->active_session($target_code,1);
        
        $target_session = $entityIns->get_target_session($target_code);
        
        if($target_session['active'] == 1 && $target_session['domain'] != ''){
            $param['entry'] =  XSYSTEM_APP_URL . 'api/connection/entry/';
            $base64 = xsystem_base64_encode($param);
            $url = $target_session['domain'] . 'response/security/' . $target_session['session_name'] . '/' . $target_session['target_code'] . '/' . $base64 . '/';
            $res = xsystem_curl($url);
        }
        
        $data['status'] = 1;
        echo json_encode($data);
        exit;
    }elseif($target_type == 'data'){
        $session_name = $url_param[6];
        $target_code = $url_param[7];
        $base64 = $url_param[8];
        $user = $entityIns->get_entity_by_session('user', $target_code);
        $data = $entityIns->get_entity('user', $user['user_code']);
//         $data['objects'] = $entityIns->get_entity_objects('user', $target_code);
        $data['img_url'] = APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . XSYSTEM_APP . '/img/';
        echo json_encode($data);
    }
}


?>