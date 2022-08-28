<?php
include_once XSYSTEM_COMMON_DIR . 'class/class-db.php';
require_once XSYSTEM_COMMON_DIR .'class/class-phpass.php';
include_once XSYSTEM_COMMON_DIR .'class/class-entity.php';

class Register extends Entity {
	function __construct(){

	}

	function is_duplicate_user_by_email($email){
		$results = Db::$db->query("SELECT * FROM xsystem_users WHERE email = '" . $email . "'");
		$is_user_email = false;
		if(isset($data)){
			while($data = $results->fetch_assoc()){
				if($data['email'] = $email){
					$is_user_email = true;
				}
			}
			return $is_user_email;
		}
		return false;
	}

	function is_register($register_code){
		$results = Db::$db->query("SELECT * FROM " . XSYSTEM_APP . "_registers WHERE register_code = '" . $register_code . "'");
		$is_register = false;
		while($data = $results->fetch_assoc()){
			if($data['register_code'] = $register_code){
				$is_register = true;
			}
		}
		return $is_register;

	}


	function post($post){
		$code = xsystem_random_num($length = 16);
		$real_file = '';
		$content = '...';


		$birth = $post['birth_year'] . '-' . $post['birth_month'] . '-' . $post['birth_day'];
		$birth = date("Y-m-d" ,strtotime($birth));


		$data['user'] = $post;

		$log['user'] = '本人';
		$log['date'] = date("m/d H:i");
		$log['content'] = '受付手続き';
		$logs[] = $log;
		$data['logs'] = $logs;


		$json = Db::$db->real_escape_string(json_encode($data));

		$query = "INSERT INTO " . XSYSTEM_APP . "_registers SET
					register_code = '" . $code . "',
					name = '" . $post['name1'] . $post['name2'] . "',
					email = '" . $post['email'] . "',
					status = 'pending',
					param = '" . $json ."'
					";
		Db::$db->query($query);



		return $code;

	}

	function onetime($register_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_registers WHERE register_code = '" . $register_code . "'";
		$results = Db::$db->query($query);
		
		$data = $results->fetch_assoc();
		return $data;
	}

	function post_password($register_code,$password){
		$data = $this->onetime($register_code);

		$hash = '';

		$pwdHasher = new PasswordHash(8, false);
		$hash = $pwdHasher->HashPassword($password);

		$json = $data['param'];
		$add['user']['password'] = $hash;

		$escape_json = Db::$db->real_escape_string(merge_json($json,$add));


		$query = '';
		$query = "UPDATE " . XSYSTEM_APP . "_registers SET password = '$hash', status='password', param = '" . $escape_json . "' WHERE register_code = '" . $register_code . "'";
		$results = Db::$db->query($query);

		return 1;

	}

	function register_user($code,$real_file){
		$register_data = $this->onetime($code);
		if(!isset($register_data['register_code'])){
			return false;
		}
		$hash = $register_data['password'];
		$param =  json_decode($register_data['param'],true);
		$user = $param['user'];

		$escape_json = '';
		$add['registered_at'] =  $register_data['created_at'];
		$escape_json = Db::$db->real_escape_string(merge_json($register_data['param'],$add));

		Db::$db->begin_transaction();
		try {
			$query = "insert into " . XSYSTEM_APP . "_users set
						user_code = '" . $code . "',
						name1 = '" . $user['name1'] . "',
						name2 = '" . $user['name2'] . "',
						name1_kana = '" . $user['name1_kana'] . "',
						name2_kana = '" . $user['name2_kana'] . "',
						email = '" . $user['email'] . "',
						password = '" . $hash . "',
						zipcode = '" . $user['zipcode'] . "',
						address = '" . $user['address'] . "',
						tel = '" . $user['tel'] . "',
						birth = '" . $user['birth_year'] . '-' . $user['birth_month'] . '-' . $user['birth_day'] . "',
						sex = '" . $user['sex'] . "',
						active = '1'
			";
			Db::$db->query($query);

			$this->create_object($code,'user','user_img','user_img',$real_file);


			
			$query = "DELETE FROM " . XSYSTEM_APP . "_registers WHERE register_code = '" . $code . "' OR email = '" . $user['email'] . "'";
			Db::$db->query($query);
			
		} catch( Exception $e ){
			Db::$db->rollback();
		}
		Db::$db->commit();

		return $register_data['email'];
	}



}

?>