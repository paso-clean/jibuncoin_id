<?php
include_once XSYSTEM_COMMON_DIR . 'class/class-db.php';
include_once XSYSTEM_COMMON_DIR . 'class/class-entity.php';
require_once XSYSTEM_COMMON_DIR . 'class/class-phpass.php';

class Group extends Entity {
	function __construct(){

	}

	function set_group($user_code,$post,$update=false){

		if($update){
			if(!isset($post['group_code']) || $post['group_code'] == ''){
				return 1;
				return false;
			}
			$group_code = $post['group_code'];
		}else{
			$group_code = xsystem_random_num(16);
		}
		
		if(!isset($post['group_name']) || $post['group_name'] == ''){
			return false;
		}
		

		Db::$db->begin_transaction();
		$status = true;
		try {
			if($update){
				$query ="UPDATE " . XSYSTEM_APP . "_groups SET
				group_name = '" . $post['group_name'] . "',
				updated_at = NOW()
				WHERE group_code = '" . $group_code . "'
				";
				Db::$db->query($query);
			}else{
				$query ="INSERT INTO " . XSYSTEM_APP . "_groups SET
				group_code = '" . $group_code . "',
				group_name = '" . $post['group_name'] . "'
				";
				Db::$db->query($query);

				$query = "INSERT INTO " . XSYSTEM_APP . "_entity_objects SET
				entity_code = '" . $group_code . "',
				entity_type = '" . 'group' . "',
				object_entity = 'user',
				object_code = '" . $user_code . "'
				";
				Db::$db->query($query);
			}

		} catch( Exception $e ){
			Db::$db->rollback();
			$status = false;
		}
		Db::$db->commit();
		return $group_code;

	}

	function get_group($group_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_groups WHERE group_code = '" . $group_code . "'";
		$results = Db::$db->query($query);
		$group = $results->fetch_assoc();
		$objects = $this->get_entity_objects('group',$group['group_code']);
		$group['objects'] = $objects;
		return $group;
	}

	function get_user_groups($user_code){
		$query = "SELECT * FROM " . XSYSTEM_APP . "_entity_objects AS eo
		LEFT JOIN " . XSYSTEM_APP . "_groups AS grp
		ON eo.entity_code = grp.group_code
		WHERE
		eo.entity_type = 'group'
		AND eo.object_entity = 'user'
		AND eo.object_code = '" . $user_code . "'";
		$results = Db::$db->query($query);
		$groups = array();
		while($group = $results->fetch_assoc()){
			$objects = $this->get_entity_objects('group',$group['group_code']);
			$group['objects'] = $objects;
			$groups[] = $group;
		}
		return $groups;
	}

	function delete_group($user_code,$group_code){
		$group = $this->get_group($group_code);

		Db::$db->begin_transaction();
		$status = true;
		try {
			$query = "DELETE FROM " . XSYSTEM_APP . "_groups WHERE group_code = '" . $group_code . "'";
			Db::$db->query($query);

			$query = "SELECT * FROM " . XSYSTEM_APP . "_entity_objects WHERE entity_code = '" . $group_code . "'";
			$results = Db::$db->query($query);
			while($object = $results->fetch_assoc()){
				$query = "DELETE FROM " . XSYSTEM_APP . "_objects WHERE object_code = '" . $object['object_code'] . "'";
				Db::$db->query($query);
			}
			
			$query = "DELETE FROM " . XSYSTEM_APP . "_entity_objects
			 WHERE entity_code = '" . $group_code . "'";
			Db::$db->query($query);

		} catch( Exception $e ){
			Db::$db->rollback();
			$status = false;
		}
		Db::$db->commit();

		if($status){
			if(isset($group['objects']['group_img'][0]['object'])){
				$img_file = $group['objects']['group_img'][0]['object'];
				$origin = XSYSTEM_IMG_DIR . 'group/origin/' . $img_file;
				$thum = XSYSTEM_IMG_DIR . 'group/thum/' . $img_file;
				if(file_exists($origin)){
					unlink($origin);
				}
				if(file_exists($thum)){
					unlink($thum);
				}
			}
		}

		return $status;
	}
}

?>