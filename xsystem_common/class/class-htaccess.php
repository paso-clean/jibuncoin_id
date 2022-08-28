<?php

const HTACCESS_PERMISSION = 0604;
const BEGIN_XSYSTEM_ADMIN_APP_HTACCESS = '# BEGIN_XSYSTEM_ADMIN_APP_HTACCESS';
const END_XSYSTEM_ADMIN_APP_HTACCESS   = '# END_XSYSTEM_ADMIN_APP_HTACCESS';
const BEGIN_XSYSTEM_APP_HTACCESS = '# BEGIN_XSYSTEM_APP_HTACCESS';
const END_XSYSTEM_APP_HTACCESS   = '# END_XSYSTEM_APP_HTACCESS';
const HTACCESS = '.htaccess';

const TMP_HTDOCCESS_DIR = XSYSTEM_ADMIN_DIR . 'tmp/';


class Htaccess{

	function active_admin_apps(){
		$htaccess_file = ABSPATH . HTACCESS;
		
		$htaccess = fopen ( $htaccess_file, "r" );
		$apps = array();
		while ( $line = fgets ( $htaccess, 4096 ) ) {
			if(strncasecmp($line, "# XSYSTEM_ADMIN_APP_", 20) === 0){
				$apps[] = rtrim(strtolower(str_replace("# XSYSTEM_ADMIN_APP_","",$line)));
			}

		}

		return $apps;
	}

	function active_apps(){
		$htaccess_file = ABSPATH . HTACCESS;
		
		$htaccess = fopen ( $htaccess_file, "r" );
		$apps = array();
		while ( $line = fgets ( $htaccess, 4096 ) ) {
			if(strncasecmp($line, "# XSYSTEM_APP_", 14) === 0){
				$apps[] = rtrim(strtolower(str_replace("# XSYSTEM_APP_","",$line)));
			}

		}

		return $apps;
	}

	function update_app_htaccess($apps){
		$htaccess_file = ABSPATH . HTACCESS;
		$default_htaccess_flg = true;
		$default_htaccess = '';
		//$xsystem_htaccess = '';

		$htaccess = fopen ( $htaccess_file, "r" );
		while ( $line = fgets ( $htaccess, 4096 ) ) {

			if (false !== strpos ( $line, BEGIN_XSYSTEM_APP_HTACCESS )) {
				$default_htaccess_flg = false;
			}

			if ($default_htaccess_flg) {
				$default_htaccess .= $line;
			}else{
				//$xsystem_htaccess .= $line;
			}

			if (false !== strpos ( $line, END_XSYSTEM_APP_HTACCESS )) {
				$default_htaccess_flg = true;
			}

		}
		fclose ( $htaccess );



		$htaccess_content = '';
		$htaccess_content = $this->set_app_htaccess($apps);
		$htaccess_content .= $default_htaccess;

		file_put_contents ( $htaccess_file, $htaccess_content );

	}

	function set_app_htaccess($apps ) {
		$htaccess_content = '';
		$htaccess_content = BEGIN_XSYSTEM_APP_HTACCESS . "\n";
		$htaccess_content .= "<IfModule mod_rewrite.c>\n";
		$htaccess_content .= "RewriteEngine on\n";
		$htaccess_content .= "RewriteBase " . APP_URI  . "/\n";
		$htaccess_content .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
		$htaccess_content .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
		$htaccess_content .= "# XSYSTEM_COMMON\n";
		$htaccess_content .= "RewriteRule ^common" . "/ " . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . "_common/index.php [L]\n";
		foreach($apps as $app){
			$htaccess_content .= "# XSYSTEM_APP_" . strtoupper($app) . "\n";
			$htaccess_content .= "RewriteRule ^" . $app . "/ " . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_app/' . $app . "/index.php [L]\n";
		}
		$htaccess_content .= "</IfModule>\n";
		$htaccess_content .= END_XSYSTEM_APP_HTACCESS . "\n";

		return $htaccess_content;
	}
}

?>