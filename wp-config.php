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

 * * MySQL settings

 * * Secret keys

 * * Database table prefix

 * * ABSPATH

 *

 * @link https://wordpress.org/support/article/editing-wp-config-php/

 *

 * @package WordPress

 */


// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define( 'DB_NAME', 'bitnami_wordpress' );


/** MySQL database username */

define( 'DB_USER', 'bn_wordpress' );


/** MySQL database password */

define( 'DB_PASSWORD', '9469092c29436de26be329e8606d99492b65ec50cd619bf26897846529a4a236' );


/** MySQL hostname */

define( 'DB_HOST', 'localhost:3306' );


/** Database charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );


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

define( 'AUTH_KEY',         'K^O$POmgyk^)OzX&A17VdNl}YQ9kKkUs{~,G[]MnImU&$Dhmt%WTX*E~b|lkrhBS' );

define( 'SECURE_AUTH_KEY',  'i3%D=kRBdBkL#,}rLN`n#}zmD}Hu:odco3(E<9]dk=G`,)xW;1$]P34>UN(1WmK;' );

define( 'LOGGED_IN_KEY',    '`&+)~.U3weCFP4Li2<9FooymJJW6!vHK&|Cb~VyB-g{GORYwQ&;U11m*00^BT<KJ' );

define( 'NONCE_KEY',        'QWSRwyCNJ.s<S/L`Gc4S.,m6l~&o]jyqg>9G(E$0Iy@ZsIxyUr-/md]qgGe4+pkf' );

define( 'AUTH_SALT',        'eB,pban@&jL|s`$N$FdfJhC#u*NzA=.d(:^k}S/XNN]*CXwr6%Uj ba8uhOn7pX9' );

define( 'SECURE_AUTH_SALT', '0-}n8xI>(sE<qJ]kdUCBxMY4kq9]H;={+|V1:uxx^,wJ^u|?R@ cmmYDdB(v .fE' );

define( 'LOGGED_IN_SALT',   'N-: R]7jb{oJ*fR#JdI~et,U2`NJ~~XLY174!e#[GwCQe(3c6JR`Ay@c4Z@.D$nB' );

define( 'NONCE_SALT',       'S0&>r3Q3e&=!Yy2O do)Sm!3#,jL]HBc.!k{).z^83w_6GAdIgCw 7HmB[g83MSi' );


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

 * @link https://wordpress.org/support/article/debugging-in-wordpress/

 */

define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */




define( 'FS_METHOD', 'direct' );
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
 */
if ( defined( 'WP_CLI' ) ) {
	$_SERVER['HTTP_HOST'] = '127.0.0.1';
}

define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] . '/' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

/**
 * Disable pingback.ping xmlrpc method to prevent WordPress from participating in DDoS attacks
 * More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/
 */
if ( !defined( 'WP_CLI' ) ) {
	// remove x-pingback HTTP header
	add_filter("wp_headers", function($headers) {
		unset($headers["X-Pingback"]);
		return $headers;
	});
	// disable pingbacks
	add_filter( "xmlrpc_methods", function( $methods ) {
		unset( $methods["pingback.ping"] );
		return $methods;
	});
}
