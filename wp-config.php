<?php
define('WP_CACHE', true); // WP-Optimize Cache
// define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
 // WP-Optimize Cache
 // WP-Optimize Cache
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
define('FS_METHOD','direct');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'shoeenginedb_plesk');
/** MySQL database username */
// define('DB_USER', 'sammy');
define('DB_USER', 'root');
/** MySQL database password */
// define('DB_PASSWORD', 'Test@123321');
define('DB_PASSWORD', 'TestDB@123321');
/** MySQL hostname */
// define('DB_HOST', 'localhost');
define('DB_HOST', '167.99.123.157');
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
define('AUTH_KEY',         '!c,%6nZ+7[`Xn?R1CV=!x{()`P:9R6>e}!K{ArF<2Q`.kak9lFlFSIqu<>^,cMY7');
define('SECURE_AUTH_KEY',  '(q^X~@|w+seD9kS3O>S4V xUHGfyR5jH1gnEr74?iJo{ae.jOU=2yFra-Btn6<:V');
define('LOGGED_IN_KEY',    ',)[pP[UhYH_[|MefC,vf WJK2e.-IC,Wx9[FyD]UTVd,bi{ 32>t&EH+(6N2-%NC');
define('NONCE_KEY',        'UJIfb8e.0tpl$6>$r8Tf6VTc;$,j6h?@7j=uWz^xo/y) (NQJ(!H5k4hTgO1_+b^');
define('AUTH_SALT',        ';,qE:Ak[l[ dKA#gAE!=p0<rk&SP&j]b?RTcfvuh809+=_cwqI4^b[5MH~.gDn{}');
define('SECURE_AUTH_SALT', 'On3xq[*0@#4duY%<{t~X6ST+Kc*{&>ko!tJK HEx&cvs|XtDkBx>%CU>J%>U%NfX');
define('LOGGED_IN_SALT',   'AR,e8R{l$]SX[T$9{RK.uBJ9`1uj6B`Ds3pp-8q!/W2I}/p:]i!Yh#oJd?RRR3p]');
define('NONCE_SALT',       '1a6Dvg+(J^wp(iVP9=|DAG3isF4l?;(5w&Sn-&rKMTn_:!}&De9.BLA4,yv0&*AM');
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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors',true);
ini_set('error_reporting', E_ALL);
// ini_set('error_reporting', E_ALL & ~E_NOTICE);// Report all errors except E_NOTICE
ini_set('error_log', dirname(__FILE__) . '/logss/error_log.txt');
define('WP_DEBUG', true);
define('SAVEQUERIES', true);
define( 'WP_MEMORY_LIMIT', '6144M' );
define( 'WP_MAX_MEMORY_LIMIT ', '8192M' ); //for admin area
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
// //define('DISALLOW_FILE_EDIT',true);
// define('DISALLOW_UNFILTERED_HTML',true);
// //ini_set('memory_limit', '-1');