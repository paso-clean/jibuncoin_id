<?php

$form_data = $_POST['form_data'];
$name1 = $form_data['name1'];

$str = '';
foreach($form_data as $key=>$val){
    $str .= $key . ':' . $val . ', ';
}

$data['content'] = $str;

echo json_encode($data);


?>