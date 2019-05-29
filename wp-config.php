<?php
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
define('DB_NAME', 'thetrekguy');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'I:2+i5&02Js)PwH|>TkE9@>e=C07rb$t4?@_^Q9ZHVoC^K,KrbOl1Y1kh**t+M--');
define('SECURE_AUTH_KEY',  'i1x*:<JN!I&M:,4VVg@!{0W.>s_>MY;W1M!unb1oi[fO^+C302ow(qZ84f|3(,*F');
define('LOGGED_IN_KEY',    '6%wHiW=bmV$f1,c?hTQ7SG?;bz!T|e#a4V$>Id^fCZE];eU)PQlQDL|N7J3^;hE ');
define('NONCE_KEY',        '=#L:m/i@`veCQ)rhP9tzuHWyb7Z6=g2-:7`2duZGUU:}O;Gh~n7!$zQW[<snyFgf');
define('AUTH_SALT',        'X7n93(P)~>US=LG36V!,lo*I6tD 3KX`td9=!f~d~ZF=_jxJ9E}bi:.bJ)_ 0+6N');
define('SECURE_AUTH_SALT', 'h<43G=Us% SSwgbRJGd:PUgK&}c3<Y5,6N5xH,!JvQdH{C-NGrmg#?XkL(:<F#3/');
define('LOGGED_IN_SALT',   'pg 7:`7aHbL*6)E:4 =8pf`,2HR!NSMP+Rf{P67URURYGn6%axig*]k=RE&W8Gr8');
define('NONCE_SALT',       ' B~: h8)L|0L9{R/M6!HY2PdXntOkUel}u+4r.K09ANu[i?yO1(ck+.`,L m7j~^');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
