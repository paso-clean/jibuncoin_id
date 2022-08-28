<?php
include_once 'class-db.php';
require_once 'class-phpass.php';

class Entity {
	function __construct(){

	}
	
	
	function create_session($session_type,$target_type,$target_code,$active = 1){
	    $session['session_code'] = xsystem_random_code(16);
	    $session['session_name'] = xsystem_random_num(16);
	    $session['session_type'] = $session_type;
	    $session['target_type'] = $target_type;
	    $session['target_code'] = $target_code;
	    $session['active'] = $active;
	    $date = new DateTime();
	    $session['created_at'] = $date->format('Y-m-d H:i:s');
	    $date->modify('+30 day');
	    $session['expires_at'] = $date->format('Y-m-d H:i:s');
	    $query = "INSERT INTO " . XSYSTEM_APP . "_sessions SET
			session_code = '" . $session['session_code'] . "',
			session_name = '" . $session['session_name'] . "',
			session_type = '" . $session['session_type'] . "',
			target_code = '" . $session['target_code'] . "',
			target_type = '" . $session['target_type'] . "',
			active = " . $session['active'] . ",
			domain = '',
			expires_at = '" . $session['expires_at'] . "',
			created_at = '" . $session['created_at'] . "'
			";
	    Db::$db->query($query);
	    return $session;
	}
	
	
	function create_linkage_session($session_name,$session_code,$session_type,$target_type,$target_code,$entry,$active = 0){
	    $session['session_code'] = $session_code;
	    $session['session_name'] = $session_name;
	    $session['session_type'] = $session_type;
	    $session['target_type'] = $target_type;
	    $session['target_code'] = $target_code;
	    $session['active'] = $active;
	    $date = new DateTime();
	    $session['created_at'] = $date->format('Y-m-d H:i:s');
	    $date->modify('+30 day');
	    $session['expires_at'] = $date->format('Y-m-d H:i:s');
	    $query = "INSERT INTO " . XSYSTEM_APP . "_sessions SET
			session_code = '" . $session['session_code'] . "',
			session_name = '" . $session['session_name'] . "',
			session_type = '" . $session['session_type'] . "',
			target_code = '" . $session['target_code'] . "',
			target_type = '" . $session['target_type'] . "',
			active = " . $session['active'] . ",
			domain = '" . $entry . "',
			expires_at = '" . $session['expires_at'] . "',
			created_at = '" . $session['created_at'] . "'
			";
	    Db::$db->query($query);
	    return $session;
	}
	
	
	function create_security_session($session_name,$target_type,$target_code,$active = 0){
	    $session['session_code'] = xsystem_random_code(16);
	    $session['session_name'] = $session_name;
	    $session['session_type'] = 'security';
	    $session['target_type'] = $target_type;
	    $session['target_code'] = $target_code;
	    $session['active'] = $active;
	    $date = new DateTime();
	    $session['created_at'] = $date->format('Y-m-d H:i:s');
	    $date->modify('+30 day');
	    $session['expires_at'] = $date->format('Y-m-d H:i:s');
	    $query = "INSERT INTO " . XSYSTEM_APP . "_sessions SET
			session_code = '" . $session['session_code'] . "',
			session_name = '" . $session['session_name'] . "',
			session_type = '" . $session['session_type'] . "',
			target_code = '" . $session['target_code'] . "',
			target_type = '" . $session['target_type'] . "',
			active = " . $session['active'] . ",
			domain = '',
			expires_at = '" . $session['expires_at'] . "',
			created_at = '" . $session['created_at'] . "'
			";
	    Db::$db->query($query);
	    return $session;
	}


	function get_session_data($session_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_code = '" . $session_code . "'";
		$results = Db::$db->query($query);
		$session_data = $results->fetch_assoc();
		return $session_data;
	}

	function get_entity_by_session($entity_type,$session_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_code = '" . $session_code . "'";
		$results = Db::$db->query($query);
		if($session_data = $results->fetch_assoc()){
			$entity_data = array();
			if(isset($session_data) && $session_data['target_type'] == $entity_type){
				if($entity_type == 'user'){
					$query = "SELECT * FROM " . XSYSTEM_APP . "_users WHERE user_code = '" . $session_data['target_code'] . "'";
				}
				$results = Db::$db->query($query);
				$entity_data = $results->fetch_assoc();
			}
			return $entity_data;
		}else{
			return false;
		}
	}

	function create_object($entity_code,$entity_type,$object_name,$object_type,$object,$object_num = 0){
		$object_code = xsystem_random_num($length = 16);
		$query = "INSERT INTO " . XSYSTEM_APP . "_entity_objects set
					entity_code = '" . $entity_code . "',
					entity_type = '" . $entity_type . "',
					object_code = '" . $object_code . "'
		";
		Db::$db->query($query);

		$query = "INSERT INTO " . XSYSTEM_APP . "_objects set
					object_code = '" . $object_code . "',
					object_name = '" . $object_name . "',
					object_type = '" . $object_type . "',
					object = '" . $object . "',
					object_num = " . $object_num . "
		";
		Db::$db->query($query);

		return $object_code;

	}

	function get_entity_objects($entity_type,$entity_code,$object_type =''){
		$where = '';
		if($object_type == ''){
			$where = '';
		}else{
			$where = "AND obj.object_type = '" . $object_type . "' ";
		}
		$query = "SELECT * FROM " . XSYSTEM_APP . "_entity_objects AS eo
		LEFT JOIN " . XSYSTEM_APP . "_objects AS obj
		ON eo.object_code = obj.object_code
		WHERE eo.entity_code = '" . $entity_code . "'
		AND eo.entity_type = '" . $entity_type . "'
		" . $where . "
		ORDER BY obj.object_num
		";
		$results = Db::$db->query($query);
		$objects = array();
		while($data = $results->fetch_assoc()){
			$objects[$data['object_type']][] = $data;
		}
		return $objects;
	}

	function get_entity($entity_type,$entity_code){

		if($entity_type == 'user'){
			$table_name = XSYSTEM_APP . '_users';
			$code_name = 'user_code';
		}elseif($entity_type == 'group'){
		    $table_name = XSYSTEM_APP . '_groups';
			$code_name = 'group_code';
		}elseif($entity_type == 'coin'){
		    $table_name = XSYSTEM_APP . '_coins';
			$code_name = 'coin_code';
		}elseif($entity_type == 'token'){
		    $table_name = XSYSTEM_APP . '_tokens';
			$code_name = 'token_code';
		}else{
		    $table_name = XSYSTEM_APP . '_objects';
			$code_name = 'object_code';
		}

		$query = "SELECT * FROM " . $table_name . " WHERE " . $code_name . " = '" . $entity_code . "'";
		$results = Db::$db->query($query);
		$entity_data = $results->fetch_assoc();
		if(!isset($entity_data)){
			return false;
		}

		$objects = $this->get_entity_objects($entity_type,$entity_code);
		$entity_data['objects'] = $objects;

		return $entity_data;
	}

	function create_img($entity_type,$entity_code,$object_name,$object_type,$file){
		$entity = $this->get_entity($entity_type,$entity_code);
		if(!isset($entity)){
			return false;
		}
		$solt = xsystem_random_num(4);
		$filename = $entity_code . '_' . $solt . '.png';

		$object_code = xsystem_random_num(16);
		$query = "INSERT INTO " . XSYSTEM_APP . "_objects SET
					object_code = '" . $object_code . "',
					object_name = '" . $object_name . "',
					object_type = '" . $object_type . "',
					object = '" . $filename . "'
				";
		Db::$db->query($query);

		$query = "INSERT INTO " . XSYSTEM_APP . "_entity_objects SET
					entity_code = '" . $entity_code . "',
					entity_type = '" . $entity_type . "',
					object_entity = 'object',
					object_code = '" . $object_code . "'
		";
		Db::$db->query($query);


		$this->post_img($filename,$entity_type,$file);
		return true;
	}

	function update_img($object_code,$file){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_entity_objects AS eo
		LEFT JOIN " . XSYSTEM_APP . "_objects AS obj
		ON eo.object_code = obj.object_code
		WHERE obj.object_code = '" . $object_code . "'";
		$results = Db::$db->query($query);
		$data = $results->fetch_assoc();
		$entity_type = $data['entity_type'];
		$entity_code = $data['entity_code'];
		$object = $data['object'];

		$solt = xsystem_random_num(4);
	
		$filename = $entity_code . '_' . $solt . '.png';
		$query = "UPDATE " . XSYSTEM_APP . "_objects SET object = '" . $filename . "' WHERE object_code = '" . $object_code . "'";
		Db::$db->query($query);

		$this->post_img($filename,$entity_type,$file);

		$this->remove_img($object,$entity_type);

		return $filename;
	}

	function post_img($filename,$entity_type,$file){
		if(!isset($file)){
			return false;
		}

		//$file_path = XSYSTEM_IMG_DIR . "/" . $entity_type . '/origin/' . $filename;
		$entity_img_dir = XSYSTEM_IMG_DIR . "/" . $entity_type;
		$entity_origin_dir = $entity_img_dir . "/origin";
		$entity_thum_dir = $entity_img_dir . "/thum";

		if(!file_exists($entity_img_dir)){
			mkdir($entity_img_dir, 0755);
		}

		if(!file_exists($entity_origin_dir)){
			mkdir($entity_origin_dir, 0755);
		}

		if(!file_exists($entity_thum_dir)){
			mkdir($entity_thum_dir, 0755);
		}

		$file_path = $entity_origin_dir . '/' . $filename;

		$tempfile = $file['upfile']['tmp_name'];
		$imginfo = getimagesize($file['upfile']['tmp_name']);
		if($imginfo['mime'] == 'image/jpeg'){ $extension = ".jpg"; }
		if($imginfo['mime'] == 'image/png'){ $extension = ".png"; }
		if($imginfo['mime'] == 'image/gif'){ $extension = ".gif"; }
		if ( move_uploaded_file($tempfile , $file_path )) {
			list($w, $h) = getimagesize($file_path);
			$thumbW = 100;
			$thumbH = 100;
			$thumbnail = imagecreatetruecolor($thumbW, $thumbH);


			if($extension == '.jpg'){
				$baseImage = imagecreatefromjpeg($file_path);
				imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $w, $h);
				$thum_file_path = XSYSTEM_IMG_DIR . "/" . $entity_type . '/thum/' . $filename;
				imagejpeg($thumbnail, $thum_file_path);
			}elseif($extension == '.png'){
				$baseImage = imagecreatefrompng($file_path);
				imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $w, $h);
				$thum_file_path = XSYSTEM_IMG_DIR . "/" . $entity_type . '/thum/' . $filename;
				imagepng($thumbnail, $thum_file_path);
			}elseif($extension == '.gif'){
				$baseImage = imagecreatefromgif($file_path);
				imagecopyresampled($thumbnail, $baseImage, 0, 0, 0, 0, $thumbW, $thumbH, $w, $h);
				$thum_file_path = XSYSTEM_IMG_DIR . "/" . $entity_type . '/thum/' . $filename;
				imagegif($thumbnail, $thum_file_path);
			}

			return true;
	
		}
		return false;
	}

	function remove_img($filename,$entity_type){
		$origin_path = XSYSTEM_IMG_DIR . "/" . $entity_type . '/origin/' . $filename;
		$thum_path = XSYSTEM_IMG_DIR . "/" . $entity_type . '/thum/' . $filename;
		unlink($origin_path);
		unlink($thum_path);

	}

	function set_object($object){
		$entity_type = $object['entity_type'];

		if(!isset($object['entity_code']) || $object['entity_code'] == ''){
			return false;
		}

		$entity_data = $this->get_entity($object['entity_type'],$object['entity_code']);

		if(!isset($entity_data)){
			return false;
		}

		
		if(isset($object['object_code']) && $object['object_code'] != ''){
			$object_code = $object['object_code'];
			$update = true;
		}else{
			$object_code = xsystem_random_num(16);
			$update = false;
		}
		
		
		if(!isset($object['object_name']) || $object['object_name'] == ''){
			return false;
		}
		
		if(!isset($object['object_type']) || $object['object_type'] == ''){
			return false;
		}
		
		if(!isset($object['object']) || $object['object'] == ''){
			return false;
		}
		
		if(!isset($object['object_num']) || $object['object_num'] == ''){
			$object_num = 0;
		}else{
			$object_num = $object['object_num'];
		}

		
		Db::$db->begin_transaction();
		$status = true;
		try {
			if($update){
				$query ="UPDATE " . XSYSTEM_APP . "_objects SET
				object_name = '" . $object['object_name'] . "',
				object_type = '" . $object['object_type'] . "',
				object = '" . $object['object'] . "',
				object_num = '" . $object_num . "',
				updated_at = NOW()
				WHERE object_code = '" . $object_code . "'
				";
				Db::$db->query($query);
			}else{
				$query ="INSERT INTO " . XSYSTEM_APP . "_objects SET
				object_code = '" . $object_code . "',
				object_name = '" . $object['object_name'] . "',
				object_type = '" . $object['object_type'] . "',
				object = '" . $object['object'] . "',
				object_num = '" . $object_num . "'
				";
				Db::$db->query($query);

				$query = "INSERT INTO " . XSYSTEM_APP . "_entity_objects SET
				entity_code = '" . $object['entity_code'] . "',
				entity_type = '" . $entity_type . "',
				object_code = '" . $object_code . "'
				";
				Db::$db->query($query);
			}

		} catch( Exception $e ){
			Db::$db->rollback();
			$status = false;
		}
		Db::$db->commit();
		return $status;

	}

	function delete_object($entity_code,$entity_type,$object_code){
		
		Db::$db->begin_transaction();
		$status = true;
		try {
			$query = "DELETE FROM " . XSYSTEM_APP . "_entity_objects WHERE 
			entity_code = '" . $entity_code . "'
			AND entity_type = '" . $entity_type . "'
			AND object_code = '" . $object_code . "'
			";
			Db::$db->query($query);

			$query = "DELETE FROM " . XSYSTEM_APP . "_objects WHERE 
			object_code = '" . $object_code . "'
			";
			Db::$db->query($query);

		} catch( Exception $e ){
			Db::$db->rollback();
			$status = false;
		}
		Db::$db->commit();
		return $status;
	}
	
	function get_user_by_session($session_code){
	    $user = $this->get_entity_by_session('user',$session_code);
	    if($user){
	        $objects = $this->get_entity_objects('user',$user['user_code']);
	        $user['objects'] = $objects;
	        return $user;
	    }else{
	        return false;
	    }
	}
	
	function is_secure_lock($security_code){
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE target_type = 'login' AND target_code = '" . $security_code . "'";
	    $results = Db::$db->query($query);
	    $is_lock = false;
	    while($session_data = $results->fetch_assoc()){
	        if($session_data['active'] == 0){
	            $is_lock = true;
	        }
	    }
	    return $is_lock;
	    
	}
	
	function get_session($session_code){
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE target_type = 'user' AND session_code = '" . $session_code . "'";
	    $results = Db::$db->query($query);
	    $session = $results->fetch_assoc();
	    return $session;
	}
	
	function get_common_session($session_code){
	    $query = "SELECT * FROM " . XSYSTEM_PRODUCT . "_sessions WHERE session_code = '" . $session_code . "'";
	    $results = Db::$db->query($query);

	    if($results->num_rows == 0){
	        return false;
	    }else{
	        $session = $results->fetch_assoc();
	        return $session;
	    }
	}
	
	function get_session_by_name($session_name){
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_name = '" . $session_name . "' ";
	    $results = Db::$db->query($query);
	    $sessions = array();
	    while($data = $results->fetch_assoc()){
	        $sessions[] = $data;
	    }
	    return $sessions;
	}
	
	function delete_session_by_name($session_name,$session_type = ''){
	    if($session_type == ''){
	        $query = "DELETE FROM " . XSYSTEM_APP . "_sessions WHERE session_name = '" . $session_name . "'";
	    }else{
	        $query = "DELETE FROM " . XSYSTEM_APP . "_sessions
			WHERE session_name = '" . $session_name . "'
			AND (session_type = '" . $session_type . "' OR target_type = '" . $session_type . "')
			";
	    }
	    Db::$db->query($query);
	    return true;
	}
	
	function create_request_security_session($session_type,$user,$session_name,$session_code,$entry = ''){
	    $session['session_code'] = $session_code;
	    $session['session_name'] = $session_name;
	    $session['active'] = 1;
	    $session['domain'] = $entry;
	    $date = new DateTime();
	    $session['created_at'] = $date->format('Y-m-d H:i:s');
	    $date->modify('+30 minute');
	    $session['expires_at'] = $date->format('Y-m-d H:i:s');
	    $query = "INSERT INTO " . XSYSTEM_APP . "_sessions SET
			session_code = '" . $session['session_code'] . "',
			session_name = '" . $session['session_name'] . "',
			session_type = '" . $session_type . "',
			target_code = '" . $user['user_code'] . "',
			target_type = 'user',
			active = 0,
			domain = '" . $session['domain'] . "',
			expires_at = '" . $session['expires_at'] . "',
			created_at = '" . $session['created_at'] . "'
			";
	    Db::$db->query($query);
	    
	    $session['security_code'] = xsystem_random_code(16);
	    
	    $query = "INSERT INTO " . XSYSTEM_APP . "_sessions SET
			session_code = '" . $session['security_code'] . "',
			session_name = '" . $session['session_name'] . "',
			session_type = 'security',
			target_code = '" . $session['session_code'] . "',
			target_type = '" . $session_type . "',
			active = 0,
			domain = '" . $session['domain'] . "',
			expires_at = '" . $session['expires_at'] . "',
			created_at = '" . $session['created_at'] . "'
			";
	    Db::$db->query($query);
	    
	    return $session;
	    
	}
	
	function active_session($session_code,$active = 1){
	    $query = "UPDATE " . XSYSTEM_APP . "_sessions SET 
                active = " . $active . "
                WHERE session_code = '" . $session_code . "'
         ";
	    Db::$db->query($query);
	    
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE 
                   session_code 
                   IN (
                   SELECT target_code FROM security_sessions 
                   WHERE session_code = '" . $session_code . "' 
                   AND active = 0
                   )";
	    $results = Db::$db->query($query);
	    
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_code = '" . $session_code . "'";
	    $results = Db::$db->query($query);
	    $session = $results->fetch_assoc();
	    
	    $target_code = $session['target_code'];
	    
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE target_code = '" . $target_code . "' AND active = 0";
	    $results = Db::$db->query($query);	    
	    
	    if($results->num_rows == 0){
	        $query = "UPDATE " . XSYSTEM_APP . "_sessions SET 
                    active = 1
                    WHERE session_code = '" . $target_code . "'
                    ";
	        Db::$db->query($query);
	    }
	    	    
	    return true;
	}
	
	function get_target_session($session_code){
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_code = '" . $session_code . "' ";
	    $results = Db::$db->query($query);	
	    $session = $results->fetch_assoc();
	    
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_code = '" . $session['target_code'] . "' ";
	    $results = Db::$db->query($query);
	    $target_session = $results->fetch_assoc();
	    return $target_session;
	}
	
	function delete_expired_session($app){
	    $query = "DELETE FROM " . $app . "_sessions WHERE expires_at <= NOW()";
	    Db::$db->query($query);
	}
	
}

?>