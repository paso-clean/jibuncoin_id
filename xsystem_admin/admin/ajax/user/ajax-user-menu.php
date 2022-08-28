<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-htaccess.php';
require_once XSYSTEM_ADMIN_APP_DIR . 'class/class-admin.php';
$adminIns = new Admin();
$htaccess = new Htaccess();
$active_apps = $htaccess->active_apps();
$dirs = scandir(XSYSTEM_DIR . '/' . XSYSTEM_PRODUCT . '_app/');
$excludes = array(
    '.',
    '..',
    '.htaccess',
);

$apps = array();
foreach ($dirs AS $dir) {
    if (in_array($dir, $excludes)) {
        continue;
    }
    
    $dir_path = XSYSTEM_DIR . '/' . XSYSTEM_PRODUCT . '_app/' . $dir;
    if (is_dir($dir_path)) {
        $table_name = $dir . '_users';
        if($adminIns->is_db_table($table_name)){
            $apps[] = $dir;
        }
    }
}



foreach($apps as $app){
    $logo = APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $app . '/asset/img/logo.png';
    echo '<div class="content-block" style="padding:0;">';
    echo '<table class="pointer btn-ajax"';
    echo 'data-url="' . XSYSTEM_ADMIN_URL . 'ajax/user/list/"';
    echo 'data-app="' . $app . '"';
    echo 'style="width:100%;border:1px solid #fff;background:#fff;">';
    echo '<tr>';
    echo '<td style="width:80px;height:80px;"><div style="font-size:40px;text-align:center;"><img src="' . $logo . '?p=' . xsystem_random_num(10) . '" style="width:60px;height:60px;"></div></td>';
    echo '<td style="padding-left:20px;">';
    echo '<div style="font-size:24px;font-weight:bold;color:#357ebd;">' . $app . '</div>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}





// foreach($users as $user){
//     $form_id = xsystem_random_code(6);
//     echo '<div id="user-block-' . $form_id . '" class="content-block text-center">';
//     echo '<div class="btn btn-danger btn-api" data-method="delete" data-confirm="ユーザーを削除してよろしいですか？" data-target="#user-block-' . $form_id . '" data-done="simple_done" data-url="' . XSYSTEM_ADMIN_URL . 'api/user/entity/' . $user['user_code'] . '/">' . $user['email'] . '</div>';
//     echo '</div>';
// }

?>