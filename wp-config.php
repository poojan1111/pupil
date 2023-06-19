<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pupil_wp297' );

/** Database username */
define( 'DB_USER', 'pupil_wp297' );

/** Database password */
define( 'DB_PASSWORD', '6m-SV4-p0X' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'dfe0utn4ftsnejoau95rhykj8agqbf5cegmahwfqm7agkk9tqqrsc5vhls7oi63i' );
define( 'SECURE_AUTH_KEY',  '3yopeonoa2yoc4dfahhjyewlufe4jwi1vtnu0mft1tsw3xtr2yvqn1lvgfdxqegr' );
define( 'LOGGED_IN_KEY',    'izmoua0udse4qlrd4hp3wcmrn2asad0qjcfiokw0dovsspwqgomfx6nnfdyuwkwd' );
define( 'NONCE_KEY',        'hmbn0na9xlmnzqy8v9yaxe4vjom5pkimoktykyisxcsluwg1ywa4xmesbu9ojvhq' );
define( 'AUTH_SALT',        'trcnz78gzqzihrnsacl9nnoxvschd19hq5uaywu5iyj7k1fm02i7j4v1xqbzcz2u' );
define( 'SECURE_AUTH_SALT', 'vg99oxufcgftidxmeffjib86zgv2f5fuo57nc3gk9tgzc4fpmlfjwojbyrxadtj1' );
define( 'LOGGED_IN_SALT',   'qepfomtmytxudjq3hxl5xsnvdawm6vicxh80bpvrnagg3g7ttxfede8ypqy7gehv' );
define( 'NONCE_SALT',       'renstkplbzawy3zlqcndoiir5x2boykmae8l5fnnoyuo5ho4hfbmcog3iehp3ljj' );


define( 'WP_CONTENT_FOLDERNAME', 'pupil' );

define( 'WP_CONTENT_DIR', ABSPATH . WP_CONTENT_FOLDERNAME );

define( 'WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST'] . '/' );

define( 'WP_CONTENT_URL', WP_SITEURL . WP_CONTENT_FOLDERNAME );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp97_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
