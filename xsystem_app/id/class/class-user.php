<?php
include_once XSYSTEM_COMMON_DIR . 'class/class-db.php';
include_once XSYSTEM_COMMON_DIR . 'class/class-entity.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-phpass.php';

class User extends Entity {
	function __construct(){

	}


	function login($email,$password){
		$is_login = false;
		if($email == '' || $password == ''){
			return null;
		}
		$hasher = new PasswordHash(8, false);
		$query = "SELECT * FROM " . XSYSTEM_APP . "_users WHERE email = '" . $email . "'";
		$results = Db::$db->query($query);
		$user = $results->fetch_assoc();
		$count = $results->num_rows;
		
		if($count != 0){
			$is_login = $hasher->CheckPassword( $password, $user['password'] );
		}

		if($is_login){
		    if($user['secure'] != 0){
		        $session_data = $this->create_session('login','user',$user['user_code'],1);
// 				$this->_create_secure_session($session_data['session_code'],$user['secure']);
		    }else{
		        $session_data = $this->create_session('login','user',$user['user_code'],1);
			}
			$user['session'] = $session_data;
			return $user;
		}else{
			return NULL;
		}
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
	
	function user_id_linkage($user){
	    if($db_user = $this->get_user($user['user_code'])){
	        $update = true;
	    }else{
	        $update = false;
	    }
	    
	    $status = true;
	    Db::$db->begin_transaction();
	    try {
	        if($update){
	            $query = "UPDATE " . XSYSTEM_APP . "_users SET
							name1 = '" . $user['name1'] . "',
							name2 = '" . $user['name2'] . "',
							name1_kana = '" . $user['name1_kana'] . "',
							name2_kana = '" . $user['name2_kana'] . "',
							email = '" . $user['email'] . "',
							password = '" . $user['password'] . "',
							zipcode = '" . $user['zipcode'] . "',
							address = '" . $user['address'] . "',
							tel = '" . $user['tel'] . "',
							birth = '" . $user['birth'] . "',
							sex = '" . $user['sex'] . "'
						WHERE user_code = '" . $user['user_code'] . "'
				";
	            Db::$db->query($query);
	            
	        }else{
	            $query = "INSERT INTO " . XSYSTEM_APP . "_users SET
							user_code = '" . $user['user_code'] . "',
							name1 = '" . $user['name1'] . "',
							name2 = '" . $user['name2'] . "',
							name1_kana = '" . $user['name1_kana'] . "',
							name2_kana = '" . $user['name2_kana'] . "',
							email = '" . $user['email'] . "',
							password = '" . $user['password'] . "',
							zipcode = '" . $user['zipcode'] . "',
							address = '" . $user['address'] . "',
							tel = '" . $user['tel'] . "',
							birth = '" . $user['birth'] . "',
							sex = '" . $user['sex'] . "'
				";
	            Db::$db->query($query);
	            
	        }
	        
	    } catch( Exception $e ){
	        Db::$db->rollback();
	        $status = false;
	    }
	    Db::$db->commit();
	    
	    if($status){
	        if($update){
	            $old_img = $db_user['objects']['user_img'][0]['object'];
	            $origin_img = XSYSTEM_IMG_DIR . 'user/origin/' . $old_img;
	            $thum_img = XSYSTEM_IMG_DIR . 'user/thum/' . $old_img;
	            if(file_exists($origin_img)){
	                unlink($origin_img);
	            }
	            if(file_exists($thum_img)){
	                unlink($thum_img);
	            }
	        }
	        
	        $this->user_object_linkage($user['user_code'],$user['objects'],$update);
	        
	        return $user['user_code'];
	    }else{
	        return false;
	    }
	}
	
	function user_object_linkage($user_code,$objects,$update = false){
	    $object = $objects['user_img'][0];
	    if(!isset($object)){
	        return false;
	    }
	    
	    
	    $status = true;
	    Db::$db->begin_transaction();
	    try {
	        if($update){
	            $query = "UPDATE " . XSYSTEM_APP . "_objects SET
				object_code = '" . $object['object_code'] . "',
				object_name = '" . $object['object_name'] . "',
				object_type = '" . $object['object_type'] . "',
				object = '" . $object['object'] . "',
				active = '" . $object['active'] . "',
				object_num = '" . $object['object_num'] . "'
				WHERE object_code = '" . $object['object_code'] . "'
				";
	            Db::$db->query($query);
	        }else{
	            $query = "INSERT INTO " . XSYSTEM_APP . "_objects SET
				object_code = '" . $object['object_code'] . "',
				object_name = '" . $object['object_name'] . "',
				object_type = '" . $object['object_type'] . "',
				object = '" . $object['object'] . "',
				active = '" . $object['active'] . "',
				object_num = '" . $object['object_num'] . "'
				";
	            Db::$db->query($query);
	            
	            $query = "INSERT INTO " . XSYSTEM_APP . "_entity_objects SET
				entity_code = '" . $user_code . "',
				entity_type = 'user',
				object_entity = 'object',
				object_code = '" . $object['object_code'] . "'
				";
	            Db::$db->query($query);
	        }
	    } catch( Exception $e ){
	        Db::$db->rollback();
	        $status = false;
	    }
	    Db::$db->commit();
	    
	}
	
	function get_user($user_code){
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_users WHERE user_code = '" . $user_code . "'";
	    $results = Db::$db->query($query);
	    if($user = $results->fetch_assoc()){
	        $objects = $this->get_entity_objects('user',$user['user_code']);
	        $user['objects'] = $objects;
	        return $user;
	    }else{
	        return false;
	    }
	}
	
	function update_user_secure($user_code,$secure){
	    $query = "UPDATE " . XSYSTEM_APP . "_users SET secure = " . $secure . " WHERE user_code = '" . $user_code . "'";
	    Db::$db->query($query);
	    return 1;
	}
	
	function get_security_sessions($session_code){
	    $query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE target_code = '" . $session_code . "'";
	    $results = Db::$db->query($query);
	    $sessions = array();
	    while($data = $results->fetch_assoc()){
	        $sessions[] = $data;
	    }
	    return $sessions;
	}
	    
	    

}

?>