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
