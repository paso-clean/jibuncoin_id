<?php

$user_profiles = array('free_text','job','license','skill','hobby','family','residence','belong');
$group_profiles = array('purpose','activity','member','base','belong');

$app['name'] = 'admin';
$app['app'] = XSYSTEM_PRODUCT . '_admin';
$app['title'] = '機能';
$app['content'] = 'ajax/ajax-main-menu.php';
$app['uri'] = 'ajax/main/menu/';
$app['order'] = 1;
$apps['admin'][] = $app;

$app['name'] = 'admin';
$app['app'] = XSYSTEM_PRODUCT . '_admin';
$app['title'] = '機能2';
$app['content'] = 'ajax/ajax-main-menu.php';
$app['uri'] = 'ajax/main/menu/';
$app['order'] = 1;
$apps['admin'][] = $app;

?>

