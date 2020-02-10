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
define( 'DB_NAME', 'ishyoboy' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'g!&W1be9~%$HM?65Q~,pss7AcW0%RA{(#[s `Mer<^%bvt}aZR)WGC]1x(`g,B#F' );
define( 'SECURE_AUTH_KEY',  '`R!j #p^$t_ONsQ.K_.p}I,EGP{gX;.r[soz2?2RV-t5n,K|.@@g1E?W;x=g$T 4' );
define( 'LOGGED_IN_KEY',    'tY&P)c8D7k0+le~xO)!KAjOd<p;+x{=gqY|2l`([ZjiEga{6cS6xW^%VS`T0)bJY' );
define( 'NONCE_KEY',        'K?3;px>9<@=(xSRi%M!U~>GY@$CR@9^rcY@~l;z*;&S9ksz*V>6f7DMe~xVQb?nT' );
define( 'AUTH_SALT',        'a9g36eU T?a7rXnF7$<b)h!)}>HpaWcW  Z4/43)/J<p`KLslD*2n&%6.nNOmiNw' );
define( 'SECURE_AUTH_SALT', '+T[/A?gkaV4Ac gav+f26J_K/$X3frl}/}TE_@sMPuAp!JLm%2KYp2q$3q6aO=vy' );
define( 'LOGGED_IN_SALT',   'JCr4`h>Df&AJ;|jJrv2)(9^0eP*+,7la|YIT!tI:{R>vGwV[64Xl?<vC#M;kv$p,' );
define( 'NONCE_SALT',       'N^TTi{~ZG[IxzJ7*k&IxwBOI^={(<Zm7_BO|ff  Z^L8;7I>X<aCZGXMxgjm:06V' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
