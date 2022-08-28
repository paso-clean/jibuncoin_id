<?php

$address_str = '';
$address1 = '';
$address2 = '';
$address3 = '';
$content  = '';

$zipcode = $url_param[4];

if(isset($zipcode) && $zipcode != ''){

	$url = "https://zip-cloud.appspot.com/api/search?zipcode=" . $zipcode;
	$json = json_decode(file_get_contents($url),true);
	$address = $json["results"];

	foreach( $address as $key0=>$value1 ){
		foreach($value1 as $key=>$value2){
			if($key == 'address1' || $key == 'address2' || $key == 'address3'){
				$address_str .= $value2;
				if($key == 'address1'){
					$address1 = $value2;
				}elseif($key == 'address2'){
					$address2 = $value2;
				}elseif($key == 'address3'){
					$address3 = $value2;
				}
				//$content .= '<div class="collection-tag  tag-active" data-tag_name="' . $value2 . '"><div class="collection-tag-icon"><i class=" fas fa-tag"></i></div> <div class="collection-tag-name">' . $value2 . '</div></div>';
			}
		}
	}
}


$data['text'] =$address_str;
$data['address1'] =$address1;
$data['address2'] =$address2;
$data['address3'] =$address3;
echo json_encode($data);


?>