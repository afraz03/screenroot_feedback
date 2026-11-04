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
define( 'DB_NAME', 'new_screenroot' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'jYM:>-uI4h/7%spw)b?}0:B((cK_Xv|1KK5psrNkEMC*OogjL_PoZ;2oX~.j=NO!' );
define( 'SECURE_AUTH_KEY',  '$~)DK|B`5q@/ GKV`%p5T#`!w1sY$AK:Wotn]Ng`DZ0Gaek&3w9YHB~^nA7[[;cc' );
define( 'LOGGED_IN_KEY',    'PbQSc-g;znDV4ag.BrWUSrT:j/X:5i34xo?>c)%m!IP`x*i<g=N<xC|m}H>Py8Fb' );
define( 'NONCE_KEY',        'T!&a.[$1%/[^5#7O%8viy]`,)FwJzc7ZS+q+2%dus&}$Fn^{^|@M8tHcY98RmU9E' );
define( 'AUTH_SALT',        'gOL9ZYbP$J{^AIa;Fi@1zxavPC!>==zl(/.(%TPquEf)BKZ1-ekXjiAA#U.4g_%-' );
define( 'SECURE_AUTH_SALT', 'XEl+=kvD_i}vM^@VeiZW55-{&X+$9,{#SLH|> csVc>nE.-g^Pi,M1vm%Hjjh_&5' );
define( 'LOGGED_IN_SALT',   'Tg%u1M9PN:i[UVxPH1`c*;sT(m%aq*#`OE1|00g0/zoMRHz=iv9;fMr5Rl5[~3fX' );
define( 'NONCE_SALT',       'DUucuzmmnPw)dXGcc$1H$S[tvI]77{%->B0CQ)7S*4m)I-G3l3AE@h~{uo8V_oUn' );

/**#@-*/

/**
 * WordPress database table prefix.
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
