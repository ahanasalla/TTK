<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'TTK');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'y&Mq=u1%nHHx@V5O|rma)mjpz<VKs.9h6Nifk$azH&C,^]?-YH10MU[)YocR`/<=');
define('SECURE_AUTH_KEY',  'OWaXSJ*+X@h6GZSP<jnyU?](RX[iVPNrq%2amP<Oat.Pch2J$RR&nX9Ij[&<g1F?');
define('LOGGED_IN_KEY',    '|FS_YTU{%Vg6K|v+TQg^]xm@:O6a@)|S,s;oYz1C>poG@,w4D>PNM2Sb>#s@aN>4');
define('NONCE_KEY',        'J#N}?!__7@1p=AE(8B<`nn!N2YV+3;W]WfN#AKy$ic>1:)KIuUNjM&C)>,GV,0+D');
define('AUTH_SALT',        '%fnaQO2[84t%pH4NT >OisR1Wm]qbOCK X(A%2(_n~[[^R-WmS$,KkP58sdFcv+m');
define('SECURE_AUTH_SALT', 'ja3r+^EMJhD.)*!FP,bZ5ck..^{U.=sN-g1|Fbu[5D0OZw;6,B*uNsgvPZI^W>eZ');
define('LOGGED_IN_SALT',   '2g^1`40v/ncV{e;_3?a6jgTgBsUh:H-[qbc,r4+KyNhZXK?3/c!$uZy7bR~;/KCO');
define('NONCE_SALT',       'D&,>wL/U>R$]O}*IU8-kSNcx%]eo/oC e~P1!RY9}!M w)Hm/K1*6DZUW [+lWB|');

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
