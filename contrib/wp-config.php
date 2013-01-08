<?php
/*
 * Imba theme for WordPress
 * Copyright (c) Kim Blomqvist
 * All rights reserved.
 *
 * GPL license
 */

/* Preparing for large memory usage
 * [1] (http://wordpress.org/support/topic/fatal-error-on-upgrade-allowed-memory-size-exhausted) */
define('WP_MEMORY_LIMIT', '64M');

//define('WP_HOME', '');
//define('WP_SITEURL', '/');

/* Disable cron jobs by default */
define('DISABLE_WP_CRON', true);

/* Paths */
define('APPLICATION_PATH', realpath(dirname(__FILE__)));

/* Debugging */
define('WP_DEBUG', false);
ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 0);

/* MySQL settings */
define('DB_NAME', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_swedish_ci');

$table_prefix  = 'wpfi_';

/* Authentication Unique Keys and Salts.
 * Visit at: https://api.wordpress.org/secret-key/1.1/salt/ */
define('AUTH_KEY',         '');
define('SECURE_AUTH_KEY',  '');
define('LOGGED_IN_KEY',    '');
define('NONCE_KEY',        '');
define('AUTH_SALT',        '');
define('SECURE_AUTH_SALT', '');
define('LOGGED_IN_SALT',   '');
define('NONCE_SALT',       '');

/* Language */
define('WPLANG', 'fi');

/* Absolute path to the Wordpress directiry. */
if (!defined('ABSPATH')) {
        define('ABSPATH', APPLICATION_PATH . '/');
}

/* Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

