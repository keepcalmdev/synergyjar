<?php
// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', true );
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'synergyjar' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('FS_METHOD', 'direct' );
define('FS_CHMOD_DIR', 0770);
define('FS_CHMOD_FILE', 0660);

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Gt8P1KXJ9Ds/YkqRa03D8vTmW7Jtkgbd2CpRBsNzWd/M0GPTMcXryqtS4Lxq7xovujCHk/ZAaenUdfND+fTkoA==');
define('SECURE_AUTH_KEY',  '0OVZjrqMis0a3TkYdv8Kr1Bc99Gi7WgjXGMUJXbKanrJwtWimD5S0nIOk45ZqSneRmAdslDvnMyFsp2weCSVsw==');
define('LOGGED_IN_KEY',    'cW8z5wPgxnMFxgE4Mteee6UUsbKsqzmwOf8yvK75wSGtQUpMfqzRWKOjS9NhWtcf9SuyDjdBQPfbcAok0bYIhA==');
define('NONCE_KEY',        'G1buA2TFAw7Ok0SALvECBOTtPrzjUIM/WsbAZ/VS0zmvUUOMyKBskdGwMaUq1OwCM6q7ozj/f80B5QIgKhKAxQ==');
define('AUTH_SALT',        'V0nEYKEv9z+awVEun4SOc8F/c3cNy4hHripCweGFcVhYJ6q/jHe8C2e/tNrwTmr4to3aYDMzLQ4tKZeUYRCgwg==');
define('SECURE_AUTH_SALT', 'V4CANKKzqFmqhyfO/INP45Ott0rOWRvrbhR83ycnM5DD2RDi9KUYRN4TlqDn4V79f9h9kFgNii4hUhAKHnpuzg==');
define('LOGGED_IN_SALT',   'w1nD0v9zXD/AAw8ps1R4O0Wr7/pHvkbhA+Sf4nIsvh/ctBp0hlw+zomfIaxYuiFKI8I414nJQsT8RjJAvnn8cA==');
define('NONCE_SALT',       'oIPj2bgSpIKccymAwEfNHE3PwKZOAxTlC7UgecCQv+Vv+NboHdVGifMImJ1k3iYQ2R8vyYRPj1Zsk3unOA09TQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'sr_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
