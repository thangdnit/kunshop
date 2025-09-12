<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kunshopsql' );
/** Database username */
define( 'DB_USER', 'root' );
/** Database password */
define( 'DB_PASSWORD', 'root' );
/** Database hostname */
define( 'DB_HOST', 'localhost' );
/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('API_SECRET_KEY', 's7z!=Co0GET~Gi~,aT+_b;zkwJD!Nk$)0>Y/.qije0b]%;nzO4~3N');
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
define( 'AUTH_KEY',         'SQ46@2mi/0ONa*:0-RRU~bAU@nZd]fmG0/n0yuvY:!KtInqN`j7kn[=)rko67Ect' );
define( 'SECURE_AUTH_KEY',  '7t@ylHj5Tac)Ncwf1#q6X^qblgi]y^O~`R;1psKcQlmwa#1<#YH<P_`@Nbo_(KQ4' );
define( 'LOGGED_IN_KEY',    'K.L{+KTxCd!mdr)rYKN~Z>g6Mp}~^HKA=FE2]ACW)2a0`VFML[%TOZx,-CeefzKx' );
define( 'NONCE_KEY',        's7cS*UVX@(k|,jzN-VvOKq(ePK#xpS.hhgGET~Gi~,aTX[gv.L?6Sb]%;nzO4~3N' );
define( 'AUTH_SALT',        'w7Ef5|!_PDBi2+ _b;zkwJD!Nk$)0>Y/.qije0-GvhwS:;C;fd?CxyP5Gl|@q&gP' );
define( 'SECURE_AUTH_SALT', 'oX$(:^E623-&%]PH9dq?0WeVvla[&Vd2%5Eui6KPnYJz#94(Mx]^-zrHeqD/BFku' );
define( 'LOGGED_IN_SALT',   '4Hi7~g)kvziIaU&mv:fYn+FWLv8hw<+$%9McyIRx0pb>Quz!=Col/{UoioM)q;?3' );
define( 'NONCE_SALT',       '_U]8)D&6Z^[-24:WXs3UX>;/UW]P(kTX$q)>M9|8tM$QK27vAA3UkrTLLwwV&p*]' );
/**#@-*/
/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'tcwyz_';
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
/* Add any custom values between this line and the "stop editing" line. */
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';