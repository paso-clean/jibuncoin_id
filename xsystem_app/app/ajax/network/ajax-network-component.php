<?php
require_once XSYSTEM_APP_DIR . 'class/class-user.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-network.php';

if(!isset($_COOKIE['xsystem_' . XSYSTEM_APP . '_session'])){
//     $redirect = XSYSTEM_APP_URL . 'login/';
//     header("Location: $redirect");
    echo 'error.';
    exit;
}
$userIns = new User();
$networkIns = new Network();

$user = $userIns->get_user_by_session($_COOKIE['xsystem_' . XSYSTEM_APP . '_session']);

if(isset($_POST['server_code'])){
    $server = $networkIns->get_server($_POST['server_code']);
}else{
    exit;
}



// $connections_num = $_POST['connections_num'];
// $target_type = $_POST['target_type'];

// $url = $connections[$target_type][$connections_num] . 'api/server/info/';

$url = $server['domain'] . 'api/network/info/';


$json = file_get_contents($url);
$data = json_decode($json,true);

// // $session_name = xsystem_random_num(16);
// // $session_code = xsystem_random_code(16);
// // $security_code = xsystem_random_code(16);

$url = $data['component_unit'] . $user['user_code'] . '/';


$component_unit = file_get_contents($url);

echo $component_unit;

?>
<div id="url-<?php echo $user['user_code']; ?>" data-url="<?php echo XSYSTEM_APP_URL; ?>ajax/network/request/" data-entry="<?php echo $data['entry']; ?>" class="content-block" style="text-align:center;padding:20px;display:none;"></div>