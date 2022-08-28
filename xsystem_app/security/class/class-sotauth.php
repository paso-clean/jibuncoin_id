<?php
include_once XSYSTEM_COMMON_DIR . 'class/class-db.php';
include_once XSYSTEM_APP_DIR . 'class/class-user.php';

class Sotauth extends User {

	function get_session_data($session_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_code = '" . $session_code . "'";
		$results = Db::$db->query($query);
		$session_data = $results->fetch_assoc();
		return $session_data;
	}

	function is_secure_lock($security_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE target_type = 'session' AND target_code = '" . $security_code . "'";
		$results = Db::$db->query($query);
		$is_lock = false;
		while($session_data = $results->fetch_assoc()){
			if($session_data['active'] == 0){
				$is_lock = true;
			}
		}
		return $is_lock;

	}

	function get_security_sessions($session_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE target_code = '" . $session_code . "'";
		$results = Db::$db->query($query);
		while($data = $results->fetch_assoc()){
			$sessions[] = $data;
		}
		return $sessions;
	}

	function unlock_session($session_code){
		$query = "UPDATE " . XSYSTEM_APP . "_sessions SET active = 1 WHERE session_code = '" . $session_code . "'";
		Db::$db->query($query);
		return 1;
	}

	function set_linkage_session($session_name,$session_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_name = '" . $session_name . "'";
		$results = Db::$db->query($query);
		$num = $results->num_rows;
		if($num == 0){
			$query = "INSERT INTO " . XSYSTEM_APP . "_sessions SET 
			session_code = '" . $session_code . "',
			session_name = '" . $session_name . "',
			session_type = 'id_linkage',
			target_type = 'security',
			target_code = ''
			";
			Db::$db->query($query);
		}else{
			// $query = "UPDATE xsystem_sessions SET 
			// session_code = '" . $session_code . "'
			// WHERE session_name = '" . $session_name . "'
			// ";
			// Db::$db->query($query);
		}
		return 1;
	}

	function set_linkage_session_security($session_name,$security_code,$data){
		$entry = $data['entry'];


		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions WHERE session_name = '" . $session_name . "'";
		$results = Db::$db->query($query);
		$num = $results->num_rows;
		if($num == 0){
			return false;
		}else{
			$query = "UPDATE " . XSYSTEM_APP . "_sessions SET 
			target_code = '" . $security_code . "',
			domain = '" . $entry . "'
			WHERE session_name = '" . $session_name . "'
			";
			Db::$db->query($query);
		}
		return 1;

	}

	function delete_linkage_session($session_name){
		$query = "DELETE FROM " . XSYSTEM_APP . "_sessions WHERE session_name = '" . $session_name . "' 
		AND (session_type = 'id_linkage' OR target_type = 'id_linkage')
		";
		Db::$db->query($query);
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

	function get_session_by_target($target_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_sessions 
		WHERE target_code = '" . $target_code . "'
		";
		$results = Db::$db->query($query);
		$session = $results->fetch_assoc();

		return $session['session_code'];

	}
}

?>