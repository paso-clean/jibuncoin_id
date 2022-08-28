<?php

class Db {

	static $db;

	static function init(){

		if(!is_object(self::$db)){
			self::$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		}
		if (self::$db->connect_error) {
			echo self::$db->connect_error;
			exit();
		} else {
			self::$db->set_charset("utf8");
		}


	}
	static function get_instance(){
		return self::$db;
	}

}

?>