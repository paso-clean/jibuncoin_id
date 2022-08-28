<?php
include_once 'class-db.php';
require_once 'class-phpass.php';
require_once 'class-entity.php';

class Network extends Entity {
	function __construct(){

	}
	
	function add_server($server){
	    $server_code = xsystem_random_num(16);
	    $query = "INSERT INTO xsystem_servers SET 
                server_code = '" . $server_code . "',
                server_name = '" . $server['server_name'] . "',
                domain = '" . $server['domain'] . "',
                email = '" . $server['email'] . "',
                server_type = '" . $server['server_type'] . "'
            ";
	    Db::$db->query($query);
	    return true;
	    
	}
	
	function edit_server($server_code,$server){
	    $server_code = xsystem_random_num(16);
	    $query = "UPDATE xsystem_servers SET
                server_name = '" . $server['server_name'] . "',
                domain = '" . $server['domain'] . "',
                email = '" . $server['email'] . "',
                server_type = '" . $server['server_type'] . "'
                WHERE server_code = '" .  $server_code . "'
            ";
	    Db::$db->query($query);
	    return true;
	    
	}
	
	function delete_server($server_code){
	    $query = "DELETE FROM xsystem_servers 
                WHERE server_code = '" .  $server_code . "'
            ";
	    Db::$db->query($query);
	    return true;
	    
	}
	
	function get_servers(){
	    $query = "SELECT * FROM xsystem_servers ORDER BY updated_at";
	    $results = Db::$db->query($query);
	    $servers = array();
	    while($data = $results->fetch_assoc()){
	        $servers[] = $data;
	    }
	    return $servers;
	    
	}
	
	function get_server($server_code){
	    $query = "SELECT * FROM xsystem_servers WHERE server_code = '" . $server_code . "'";
	    $results = Db::$db->query($query);
	    $server = $results->fetch_assoc();
	    return $server;
	    
	}
	
	function get_server_by_type($server_type){
	    $query = "SELECT * FROM xsystem_servers WHERE server_type = '" . $server_type . "' AND active = 1";
	    $results = Db::$db->query($query);
	    $server = $results->fetch_assoc();
	    return $server;
	    
	}
	
	function get_networks(){
	    $query = "SELECT * FROM xsystem_networks ORDER BY updated_at";
	    $results = Db::$db->query($query);
	    $networks = array();
	    while($data = $results->fetch_assoc()){
	        $networks[] = $data;
	    }
	    return $networks;
	    
	}
	
	function get_active_networks(){
	    $query = "SELECT * FROM xsystem_networks WHERE active = 1 ORDER BY updated_at";
	    $results = Db::$db->query($query);
	    $networks = array();
	    while($data = $results->fetch_assoc()){
	        $networks[] = $data;
	    }
	    return $networks;
	    
	}
	
	function get_network($network_code){
	    $query = "SELECT * FROM xsystem_networks WHERE network_code = '" . $network_code . "'";
	    $results = Db::$db->query($query);
	    $network = $results->fetch_assoc();
	    return $network;
	}
	
	function add_network($post){
	    $network_name = $post['network_name'];
	    $network_code = xsystem_random_num(16);
	    $network_type = $post['network_type'];
	    $active = $post['network_active'];
	    
	    if($active == 1){
	        $this->clear_network_active($network_type);
	    }
	    
	    $query = "INSERT INTO xsystem_networks SET
                network_code = '" . $network_code . "',
                network_name = '" . $network_name . "',
                network_type = '" . $network_type . "',
                active = ". $active . "
            ";
	    Db::$db->query($query);
	    return $network_code;
	    
	}
	
	function edit_network($post){
	    $network_code = $post['network_code'];
	    $network_name = $post['network_name'];
	    $network_type = $post['network_type'];
	    $active = $post['network_active'];
	    
	    if($active == 1){
	        $this->clear_network_active($network_type);
	    }
	    
	    $query = "UPDATE xsystem_networks SET
                network_name = '" . $network_name . "',
                network_type = '" . $network_type . "',
                active = ". $active . ",
                updated_at = NOW()
                WHERE network_code = '" . $network_code . "'
            ";
	    Db::$db->query($query);
	    return $network_code;
	    
	}
	
	function clear_network_active($network_type){
	    $query = "UPDATE xsystem_networks SET
                active = 0
                WHERE network_type = '" . $network_type . "'
            ";
	    Db::$db->query($query);
	    return true;
	    
	}
	
	function delete_network($network_code){
	    $query = "DELETE FROM xsystem_networks
                WHERE network_code = '" .  $network_code . "'
            ";
	    Db::$db->query($query);
	    return true;
	    
	}
	
	function set_network_server($network_code,$server_code){
	    $query = "INSERT INTO xsystem_entity_objects SET 
                  entity_code = '" . $network_code . "',
                  entity_type = 'network',
                  object_code = '" . $server_code . "',
                  object_entity = 'server'
                ";
	    Db::$db->query($query);
	    return true;
	    
	}
	
	function delete_network_server($network_code,$server_code){
	    $query = "DELETE FROM xsystem_entity_objects 
                  WHERE entity_code = '" . $network_code . "'
                  AND object_code = '" . $server_code . "'
                ";
	    Db::$db->query($query);
	    return true;
	    
	}
	
	function get_network_servers($network_code){
	    $query = "SELECT * FROM xsystem_networks AS nw
                LEFT JOIN xsystem_entity_objects AS eo
                ON nw.network_code = eo.entity_code
                LEFT JOIN xsystem_servers AS sv
                ON eo.object_code = sv.server_code
                WHERE eo.entity_code = '" . $network_code . "'";
	    $results = Db::$db->query($query);
	    $servers = array();
	    while($data = $results->fetch_assoc()){
	        $servers[] = $data;
	    }
	    return $servers;
	    
	}
	
	
	function create_network_session($session_name,$session_code,$session_type,$target_type,$target_code,$entry,$active = 0){
	    $session['session_code'] = $session_code;
	    $session['session_name'] = $session_name;
	    $session['session_type'] = $session_type;
	    $session['target_type'] = $target_type;
	    $session['target_code'] = $target_code;
	    $session['active'] = $active;
	    $date = new DateTime();
	    $session['created_at'] = $date->format('Y-m-d H:i:s');
	    $date->modify('+5 minute');
	    $session['expires_at'] = $date->format('Y-m-d H:i:s');
	    $query = "INSERT INTO " . XSYSTEM_PRODUCT . "_sessions SET
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
	
	function connection_network($network){
	    if($this->get_network($network['network_code'])){
	        $query = "UPDATE " . XSYSTEM_PRODUCT . "_networks SET
                network_name = '" . $network['network_name'] . "',
                network_type = '" . $network['network_type'] . "',
                network_key = '" . $network['network_key'] . "',
                updated_at = NOW()
                WHERE network_code = '" . $network['network_code'] . "'
                ";
	        Db::$db->query($query);
	        
	    }else{
	        $query = "INSERT INTO " . XSYSTEM_PRODUCT . "_networks SET
                network_code = '" . $network['network_code'] . "',
                network_name = '" . $network['network_name'] . "',
                network_type = '" . $network['network_type'] . "',
                network_key = '" . $network['network_key'] . "'
                ";
	        Db::$db->query($query);
	    }
	    $this->connection_network_servers($network);
	    
	}
	
	function clear_network_servers($network){
	    $servers = $network['servers'];
	    $db_servers = $this->get_network_servers($network['network_code']);
	    foreach($db_servers as $db_server){
	        $safe_flg = false;
	        foreach($servers as $server){
	            if($db_server['server_code'] == $server['server_code']){
	                $safe_flg = true;
	            }
	        }
	        if(!$safe_flg){
	            $query = "DELETE FROM " . XSYSTEM_PRODUCT . "_entity_objects
                          WHERE entity_code = '" . $network['network_code'] . "'
                          AND object_code = '" . $db_server['server_code'] . "'
                        ";
	            Db::$db->query($query);
	        }
	        
	    }
	    
	}
	
	function connection_network_servers($network){
	    $this->clear_network_servers($network);
	    $servers = $network['servers'];
	    
	    foreach($servers as $server){
	        $db_server = $this->get_server($server['server_code']);
	        if($db_server){
	            $query = "UPDATE " . XSYSTEM_PRODUCT . "_servers SET 
                          server_name = '" . $server['server_name'] . "',
                          domain = '" . $server['domain'] . "',
                          email = '" . $server['email'] . "',
                          server_type = '" . $server['server_type'] . "',
                          active = '" . $server['active'] . "',
                          server_num = '" . $server['server_num'] . "',
                          updated_at = NOW()
                          WHERE server_code = '" . $server['server_code'] . "'
                ";
	            Db::$db->query($query);
	            
	            $query = "SELECT * FROM " . XSYSTEM_PRODUCT . "_entity_objects
                          WHERE entity_code = '" . $network['network_code'] . "'
                          AND object_code = '" . $server['server_code'] . "'
                        ";
	            $results = Db::$db->query($query);
	            if($results->num_rows == 0){
	                
	                $query = "INSERT INTO " . XSYSTEM_PRODUCT . "_entity_objects SET
                          entity_code = '" . $network['network_code'] . "',
                          entity_type = 'network',
                          object_entity = 'server',
                          object_code = '" . $server['server_code'] . "'
                        ";
	                Db::$db->query($query);
	            }	            
	        }else{
	            $query = "INSERT INTO " . XSYSTEM_PRODUCT . "_servers SET
                          server_code = '" . $server['server_code'] . "',
                          server_name = '" . $server['server_name'] . "',
                          domain = '" . $server['domain'] . "',
                          email = '" . $server['email'] . "',
                          server_type = '" . $server['server_type'] . "',
                          active = '" . $server['active'] . "',
                          server_num = '" . $server['server_num'] . "'
                ";
	            Db::$db->query($query);
	            
	            $query = "INSERT INTO " . XSYSTEM_PRODUCT . "_entity_objects SET
                          entity_code = '" . $network['network_code'] . "',
                          entity_type = 'network',
                          object_entity = 'server',
                          object_code = '" . $server['server_code'] . "'
                ";
	            Db::$db->query($query);
	            
	        }
	        
	    }
	    
	}
	
	
	
}

?>