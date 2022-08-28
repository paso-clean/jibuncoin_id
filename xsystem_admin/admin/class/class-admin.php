<?php
include_once XSYSTEM_COMMON_DIR . 'class/class-db.php';

class Admin {
	function __construct(){

	}

	function is_admin($admin_user){
		// Db::$db->query("INSERT INTO xsystem_modules SET module_id = '123456789'");
		$results = Db::$db->query("SELECT * FROM wp_users WHERE user_login = '" . $admin_user . "'");
		$is_admin = false;
		while($data = $results->fetch_assoc()){
			if($data['user_login'] = $admin_user){
				$is_admin = true;
			}
		}
		return $is_admin;
	}
	
	function create_table($sql){
	    $querys = explode(';', $sql);
	    foreach($querys as $query){
	        Db::$db->query($query);
	    }
	}
	
	function is_db_table($table_name){
	    $query = "SHOW TABLES LIKE '" . $table_name . "'";
	    $results = Db::$db->query($query);
	    $num = $results->num_rows;
	    if($num != 0){
	        return true;
	    }else{
	        return false;
	    }
	}
	
	function get_app_users($app){
	    $query = "SELECT * FROM " . $app . "_users";
	    $results = Db::$db->query($query);
	    $users = array();
	    while($data = $results->fetch_assoc()){
	        $users[] = $data;
	    }
	    return $users;
	}
	
	function get_user($app,$user_code){
	    $query = "SELECT * FROM " . $app . "_users WHERE user_code = '" . $user_code . "'";
	    $results = Db::$db->query($query);
	    $user = $results->fetch_assoc();
	    return $user;
	}
	
	function delete_user($app,$user_code){
	    $user = $this->get_user($app,$user_code);
	    
	    Db::$db->begin_transaction();
	    $status = true;
	    try {
	        $query = "DELETE FROM " . $app . "_users WHERE user_code = '" . $user_code . "'";
	        Db::$db->query($query);
	        
	        $query = "SELECT * FROM " . $app . "_entity_objects WHERE entity_code = '" . $user_code . "'";
	        $results = Db::$db->query($query);
	        while($data = $results->fetch_assoc()){
	            $query = "DELETE FROM " . $app . "_objects WHERE
				object_code = '" . $data['object_code'] . "'
				";
	            Db::$db->query($query);
	        }
	        
	        $query = "DELETE FROM " . $app . "_entity_objects
			 WHERE entity_code = '" . $user_code . "'";
	        Db::$db->query($query);
	        
	        $query = "SELECT * FROM " . $app . "_sessions
			WHERE target_code = '" . $user_code . "'
			";
	        $results = Db::$db->query($query);
	        while($data = $results->fetch_assoc()){
	            $query = "DELETE FROM " . $app . "_sessions WHERE
				session_code = '" . $data['session_code'] . "'
				";
	            Db::$db->query($query);
	        }
	        $query = "DELETE FROM " . $app . "_sessions WHERE target_code = '" . $user_code . "'";
	        Db::$db->query($query);
	        
	    } catch( Exception $e ){
	        Db::$db->rollback();
	        $status = false;
	    }
	    Db::$db->commit();
	    
	    if($status){
	        if(isset($user['objects']['user_img'][0]['object'])){
	            $img_file = $user['objects']['user_img'][0]['object'];
	            $origin = XSYSTEM_DIR . XSYSTEM_PRODUCT . '_' . $app . '/asset/img/user/origin/' . $img_file;
	            $thum = XSYSTEM_DIR .  XSYSTEM_PRODUCT . '_' . $app . '/asset/img/user/thum/' . $img_file;

	            if(file_exists($origin)){
	                unlink($origin);
	            }
	            if(file_exists($origin)){
	                unlink($thum);
	            }
	        }
	    }
	    
	    return $status;
	}

}





?>