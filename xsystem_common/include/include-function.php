<?php
function url_param($request_uri,$app_uri){
	if($app_uri != ''){
		$del_uri =  ltrim($app_uri,'/') ;
	}else{
		$del_uri = '';
	}

	$del_uri = str_replace('/\//', '', $del_uri);
	$uri = preg_replace('/^\/' . $del_uri . '/', '', $request_uri);
	$uri = ltrim($uri, '/');
	$x_param = explode('/',$uri);

	return $x_param;

}


function xsystem_random_code($length = 16){
	$str = array_merge ( range ( 'a', 'z' ), range ( '0', '9' ), range ( 'A', 'Z' ) );
	$r_str = null;
	for($i = 0; $i < $length; $i ++) {
		$r_str .= $str [rand ( 0, count ( $str ) - 1 )];
	}
	return $r_str;
}

function xsystem_random_num($length = 16){
	$code = '';
	for ($i = 0; $i < $length; $i++) {
		$code .= mt_rand(0, 9);
	}

	return $code;
}


function xsystem_random_char($length = 16){
	$str = array_merge ( range ( 'a', 'z' ), range ( 'A', 'Z' ) );
	$r_str = null;
	for($i = 0; $i < $length; $i ++) {
		$r_str .= $str [rand ( 0, count ( $str ) - 1 )];
	}
	return $r_str;
}

function get_app_name($crr_dir,$app_dir){
	$path =  str_replace("\\",'/',$crr_dir);
	$app_dir =  str_replace("\\",'/',$app_dir);
	$path = str_replace($app_dir,'',$path);
	$tmp = explode('/',$path);
	$app_name = $tmp[0];
	return $app_name;
}

function xsystem_log($query,$log_dir = XSYSTEM_DIR . 'log/'){
	$log = $query;
	if($log_dir == ''){
		$log_dir = './';
	}
	// 	$date = date("YmdH");
	// 	$log_file = $log_dir . $date . '.log';

	$log_file = $log_dir .  'xsystem.log';

	if (!file_exists($log_file)) {
		touch($log_file);
		chmod($log_file, 0644);
	}

	$datetime = date("Y-m-d H:i:s");

	$output = '[' . $datetime . ']' .PHP_EOL. $log . PHP_EOL;

	$file = fopen($log_file, "a");
	fwrite($file, $output);
	fclose($file);

}

function xsystem_sort($list,$order='order'){
	foreach($list as $key => $part){
	  $sort_keys[$key] = $part[$order];
	}
	array_multisort($sort_keys, SORT_ASC, $list);
	return $list;
}

function merge_json($json,$add){
    $origin = json_decode($json,true);
    $f_merge = false;
    if(count($origin) && count($add)){
        $f_merge = false;
    }
    
    if(!$f_merge){
        $merge_array = array_merge_recursive($origin, $add);
    }
    return json_encode($merge_array);
}

function xsystem_curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $res =  curl_exec($ch);
    $data = json_decode($res, true);
    curl_close($ch);
    
    return $data;
}

function xsystem_base64_encode($param){
    $json = json_encode($param);
    $base64 = base64_encode($json);
    return $base64;
}

function xsystem_base64_decode($base64){
    $json = base64_decode($base64);
    $param = json_decode($json,true);
    return $param;
}

function xsystem_domain($domain){
    $domain = rtrim($domain,'/') . '/';
    return $domain;
}







?>