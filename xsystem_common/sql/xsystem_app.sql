
CREATE TABLE IF NOT EXISTS xsystem_coins (
    `coin_code` varchar(100) NOT NULL PRIMARY KEY,
    `real_coin_name` varchar(100) NOT NULL,
    `coin_name` varchar(30) NOT NULL,
    `coin_version` varchar(30) NOT NULL,
    `coin_limit` bigint(20) NOT NULL DEFAULT '0',
    `owner_code` varchar(20) NOT NULL,
    `owner_type` varchar(30) NOT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT '0',
    `expires_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_servers (
    `server_code` varchar(20) NOT NULL PRIMARY KEY,
    `server_name` varchar(255) NOT NULL,
    `domain` varchar(255) NOT NULL UNIQUE,
    `email` varchar(100) ,
    `server_type` varchar(30) NOT NULL,
    `active` tinyint(1) NOT NULL DEFAULT '1',
    `server_num` int UNSIGNED NOT NULL DEFAULT '0',
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_networks (
    `network_code` varchar(20) NOT NULL PRIMARY KEY,
    `network_name` varchar(255) NOT NULL,
    `network_type` varchar(30) NOT NULL,
    `network_key` text,
    `active` tinyint(1) NOT NULL DEFAULT '1',
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_sessions (
    `session_code` varchar(20) NOT NULL PRIMARY KEY,
    `session_name` varchar(20) NOT NULL,
    `session_type` varchar(20) NOT NULL,
    `target_code` varchar(20) NOT NULL,
    `target_type` varchar(20) NOT NULL,
    `active` tinyint(1) NOT NULL,
    `domain` text,
    `expires_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_tokens (
    `token_code` varchar(100) NOT NULL PRIMARY KEY,
    `real_token_name` varchar(100) NOT NULL,
    `token_name` varchar(30) NOT NULL,
    `owner_code` varchar(20) NOT NULL,
    `owner_type` varchar(30) NOT NULL,
    `is_active` tinyint(1) NOT NULL DEFAULT '0',
    `expires_at` datetime NOT NULL,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_entity_objects (
    `entity_code` varchar(20) NOT NULL,
    `entity_type` varchar(30) NOT NULL,
    `object_entity` varchar(30) NOT NULL DEFAULT 'object',
    `object_code` varchar(20) NOT NULL
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_objects (
    `object_code` varchar(20) NOT NULL PRIMARY KEY,
    `object_name` varchar(30) NOT NULL DEFAULT 'object',
    `object_type` varchar(30) NOT NULL DEFAULT 'object',
    `object` text,
    `active` tinyint(1) NOT NULL DEFAULT '1',
    `object_num` int UNSIGNED NOT NULL DEFAULT '0',
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;







