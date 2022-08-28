<?php
require_once XSYSTEM_ADMIN_APP_DIR . 'class/class-admin.php';
$adminIns = new Admin();


$app = $_POST['app'];

$users = $adminIns->get_app_users($app);





foreach($users as $user){
    $form_id = xsystem_random_code(6);
    echo '<div id="user-block-' . $form_id . '" class="content-block text-center">';
    echo '<div class="btn btn-danger btn-api" data-method="delete" data-app="' . $app . '" data-user_code="' . $user['user_code'] . '" data-confirm="ユーザーを削除してよろしいですか？" data-target="#user-block-' . $form_id . '" data-done="alert" data-url="' . XSYSTEM_ADMIN_URL . 'api/user/entity/' . $user['user_code'] . '/">' . $user['email'] . '</div>';
    echo '</div>';
}

?>