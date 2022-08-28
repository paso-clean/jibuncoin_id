
CREATE TABLE IF NOT EXISTS xsystem_app_users (
    `user_code` varchar(20) NOT NULL PRIMARY KEY,
    `name1` varchar(20) NOT NULL,
    `name2` varchar(20) NOT NULL,
    `name1_kana` varchar(20),
    `name2_kana` varchar(20),
    `email` varchar(100) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `zipcode` varchar(10) NOT NULL,
    `address` varchar(100) NOT NULL,
    `tel` varchar(20) NOT NULL,
    `birth` varchar(20) NOT NULL,
    `sex` varchar(20) NOT NULL,
    `active` tinyint(1) NOT NULL DEFAULT '1',
    `secure` tinyint(1) NOT NULL DEFAULT '0',
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_app_sessions (
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

CREATE TABLE IF NOT EXISTS xsystem_app_entity_objects (
    `entity_code` varchar(20) NOT NULL,
    `entity_type` varchar(30) NOT NULL,
    `object_entity` varchar(30) NOT NULL DEFAULT 'object',
    `object_code` varchar(20) NOT NULL
) DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS xsystem_app_objects (
    `object_code` varchar(20) NOT NULL PRIMARY KEY,
    `object_name` varchar(30) NOT NULL DEFAULT 'object',
    `object_type` varchar(30) NOT NULL DEFAULT 'object',
    `object` text,
    `active` tinyint(1) NOT NULL DEFAULT '1',
    `object_num` int UNSIGNED NOT NULL DEFAULT '0',
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8;







