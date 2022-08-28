<?php
require_once XSYSTEM_APP_DIR . '/class/class-user.php';
require_once XSYSTEM_APP_DIR . '/class/class-group.php';
$userIns = new User();
$groupIns = new Group();

$status = 1000;

if (!isset($_COOKIE['xsystem_app_session'])) {
	$redirect = XSYSTEM_APP_URL . 'login/';
	header("Location: $redirect");
	exit;
}
$userIns = new User();
$user = $userIns->get_user_by_session($_COOKIE['xsystem_' . XSYSTEM_APP . '_session']);


if (isset($_POST['delete'])) {
	$data['status'] = $_POST['delete'];
	$data['status'] = $groupIns->delete_group($user['user_code'], $_POST['group_code']);
	if ($data['status']) {
		$data['msg'] = 'グループが削除されました。';
	}
	echo json_encode($data);
	exit;
}


$update = false;
if (isset($_POST['group_code']) && $_POST['group_code'] != '') {
	$update = true;
}
$group_code = $groupIns->set_group($user['user_code'], $_POST, $update);

if (isset($_FILES['upfile']['tmp_name'])) {
	$group_objects = $groupIns->get_entity_objects('group', $group_code, 'group_img');
	if (count($group_objects) != 0) {
		$groupIns->update_img($group_objects['group_img'][0]['object_code'], $_FILES);
	} else {
		$groupIns->create_img('group',$group_code, 'group_img','group_img', $_FILES);
	}
}

$data['status'] = 1;
if (isset($group_code) && $group_code != '') {
	$content = 'グループ情報が登録されました。';
} else {
	$content = '登録内容に誤りがあります。';
}


$data['msg'] = $content;


echo json_encode($data);