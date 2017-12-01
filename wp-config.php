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
define('DB_NAME', 'offtracktravel');

/** MySQL database username */
define('DB_USER', 'offtracktravel');

/** MySQL database password */
define('DB_PASSWORD', 'pvfhbpZDyz');

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
define('AUTH_KEY',         'sd,|<7*_0.pp$<^85!{U#[V7d^|znijGgW#V(iL72|trw!Dp}ogUnMZc3m9A3xXt');
define('SECURE_AUTH_KEY',  'c}oWC}1)jnpyn@Ih(UeN(COUwbkJ;r$` :D>O3M>P;cw[0m>f0vx8$v:fkCIT4zR');
define('LOGGED_IN_KEY',    '3H&^me_<wWEAaNznaE4$G&DljR;s:$s>gaMXQ-MiBjY[l,XRUGW%6!Y=/hDcf!Do');
define('NONCE_KEY',        'IyQ:WCLG68Z!6;1%ql`fCwnSQ6U82SM%4m<rs@C`HxiZ{fSB><nc1+q/RHkD,Mz[');
define('AUTH_SALT',        'BDM*GHx8E&eA%z?tK^fd~w7q?0|es-[5.yL&{P/jR:p4t#B`o:Dm ASM$[_ dmj<');
define('SECURE_AUTH_SALT', 'ywkl5m[y^_C[Uk3.LY_fEgYm7`f)_M?u9<3q]<?hp5Q[/inPXB5:6F+tF}ucqRc$');
define('LOGGED_IN_SALT',   'NKfT8kgz{I0Os,1mWLZEWf?pl|RtaAKwm]6AV~/ob*^E.Js@^8nrS=+A^JS`}G&?');
define('NONCE_SALT',       'b]5x(0tXTV?Tpd3Q@Q1SX~2&*ui.g;u6Zc{e31<>T|TG]WUDXs~JCVkn qJMq1vR');

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

 // Enable WP_DEBUG mode
define( 'WP_DEBUG', true );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', true );

define('WP_MEMORY_LIMIT', '128M');
error_log( 'unzipfile returned: '. print_r( $unzipfile, true ) );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
