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
	    
	    

}

?>