<?php
require_once XSYSTEM_COMMON_DIR . 'class/class-entity.php';
$entity = new Entity();
if(isset($_POST['object_code']) && $_POST['object_code'] != ''){
    //更新
    if(isset($_FILES['upfile']['tmp_name']) && $_FILES['upfile']['tmp_name'] != ''){
        $data['reload_class'] = 'reload_class_' . $_POST['object_code'];
        $entity_type = $_POST['entity_type'];
        $filename = $entity->update_img($_POST['object_code'],$_FILES);
        $data['filename'] = $filename;
		$origin_img_path = XSYSTEM_IMG_URL . "/" . $entity_type . '/origin/' . $filename;
        $data['origin_img_path'] = $origin_img_path;
		$thum_img_path = XSYSTEM_IMG_URL . "/" . $entity_type . '/thum/' . $filename;
        $data['thum_img_path'] = $thum_img_path;
        $data['status'] = 1;
    }else{
        $data['status'] = 0;
    }
}else{
    $data['status'] = 0;
}





// $data = $_POST;

echo json_encode($data);

?>