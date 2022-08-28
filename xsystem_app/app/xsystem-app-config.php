<?php
$app_name = basename(dirname(__FILE__));

$app['app'] = $app_name;
$app['title'] = '設定';
$app['uri'] = 'ajax/panel/setting/';
$app['order'] = 1;
$apps[$app_name][] = $app;

$app['app'] = $app_name;
$app['title'] = 'マイメニュー';
$app['uri'] = 'ajax/panel/main/';
$app['order'] = 1;
$apps[$app_name][] = $app;

$app['app'] = $app_name;
$app['title'] = '探す';
$app['uri'] = 'ajax/panel/search/';
$app['order'] = 1;
$apps[$app_name][] = $app;



$user_profiles['free_text'] = array('name'=>'フリーテキスト','order'=>10);
$user_profiles['job'] = array('name'=>'職業','order'=>20);
$user_profiles['license'] = array('name'=>'資格','order'=>30);
$user_profiles['skill'] = array('name'=>'特技','order'=>40);
$user_profiles['hobby'] = array('name'=>'趣味','order'=>50);
$user_profiles['family'] = array('name'=>'家族','order'=>60);
$user_profiles['residence'] = array('name'=>'居住地','order'=>70);
$user_profiles['belong'] = array('name'=>'所属','order'=>80);

$group_profiles['free_text'] = array('name'=>'フリーテキスト','order'=>10);


// $jibun_id_node[] = APP_URL . 'id/';
// $sotauth_node[] = APP_URL . 'sotauth/';


$connections['id'][] = APP_URL . 'id/';
$connections['security'][] = APP_URL . 'security/';


?>