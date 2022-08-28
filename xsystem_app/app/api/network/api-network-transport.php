<?php 

$session_name = $_POST['session_name'];
$session_code = $_POST['session_code'];
$entity_type = $_POST['entity_type'];
$entry = $_POST['entry'];


// $session_name = $url_param[4];
// $security_code = $url_param[5];

$data['entry'] = XSYSTEM_APP_URL . 'api/network/entry/';
$json = json_encode($data);
$base64 = base64_encode($json);



$url = $entry . 'request/data/' . $session_name . '/' . $session_code . '/' . $base64 . '/';
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// $res =  curl_exec($ch);
// $data = json_decode($res, true);
// curl_close($ch);
xsystem_log($url);
$json = @file_get_contents($url);
$res = json_decode($json,true);




$data['status'] = 1;


$content = '';
$content .= '<div class="content-block">';
$content .= $url;
$content .= '';
$content .= '';
$content .= '';
$content .= '';
$content .= '</div>';



$data['content'] = $content;

echo json_encode($data);


?>