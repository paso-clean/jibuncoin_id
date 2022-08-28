<?php
if (!defined('XSYSTEM_PRODUCT')) {
	define('XSYSTEM_PRODUCT', 'xsystem');
}

if (!defined('APP_NAME')) {
	define('APP_NAME', '');
}

if (!defined('APP_URL')) {
	define('APP_URL', 'http://localhost/node2/');
}

if (!defined('APP_URI')) {
	define('APP_URI', '/node2');
}

if (!defined('LANG')) {
	define('LANG', 'ja');
}

if (!defined('ABSPATH')) {
	define('ABSPATH', 'C:\xampp\htdocs\node2/');
}

if (!defined('COOKIEHASH')) {
	define('COOKIEHASH', '46d2afefc9829c56dc6f1d31492ac127');
}

if (!defined('XSYSTEM_DIR')) {
	define('XSYSTEM_DIR', 'C:\xampp\htdocs\node2/xsystem/');
}

if (!defined('XSYSTEM_ADMIN_DIR')) {
	define('XSYSTEM_ADMIN_DIR', XSYSTEM_DIR  .  XSYSTEM_PRODUCT . '_admin/' );
}

if (!defined('XSYSTEM_ADMIN_URL')) {
	define('XSYSTEM_ADMIN_URL', APP_URL  .  XSYSTEM_PRODUCT . '_admin/' );
}

if (!defined('XSYSTEM_COMMON_URL')) {
	define('XSYSTEM_COMMON_URL', APP_URL  . 'common/' );
}

if (!defined('XSYSTEM_COMMON_ASSET_URL')) {
	define('XSYSTEM_COMMON_ASSET_URL', APP_URL . XSYSTEM_PRODUCT . '/' . XSYSTEM_PRODUCT . '_common/asset/' );
}

if (!defined('XSYSTEM_COMMON_DIR')) {
	define('XSYSTEM_COMMON_DIR', ABSPATH  .  XSYSTEM_PRODUCT . '/xsystem_common/' );
}

if (!defined('DB_NAME')) {
	define('DB_NAME', 'node2');
}

if (!defined('DB_USER')) {
	define('DB_USER', 'root');
}

if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD', '');
}

if (!defined('DB_HOST')) {
	define('DB_HOST', 'localhost');
}

if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8mb4');
}

if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}

if (!defined('WP_TABLE_PREFIX')) {
	define('WP_TABLE_PREFIX', 'wp_');
}

?>