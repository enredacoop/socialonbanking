<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'socialon_socialonbanking.com');

/** MySQL database username */
define('DB_USER', 'socialon_34421');

/** MySQL database password */
define('DB_PASSWORD', 'IVisLB3h3h');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         ':0rY)|))Lh3+ 02pJ)o-h-W%iJFAz cEUK)Znpc.eqT{>f-l,sJK[{(J9d7Vm@Q_');
define('SECURE_AUTH_KEY',  '8Q$,7V}a*PT_;UhZsAk6RQwj#$&o;m`|BIWSN-#-a7R{Jcd#Cz1*^;SH UQ`dFMr');
define('LOGGED_IN_KEY',    '{I-!Ut/FV{CT)[a5[E1$%N&=h3bp:4;=r$-F?]C;YEX2xK)<ZVv6P<c/kTOjVm2[');
define('NONCE_KEY',        'aRn}AkV<K% hWgYDNwMP.zqse.*j@8a)x/[(;&;sTD/Y+BG51@j^L8pWr7*tN]eW');
define('AUTH_SALT',        '*RvWVmByWs4z+R_*.(&2Ou6|n`Xl[7J-,@+cZ2Pu`@;daL8iJG5c;tY=Y@$+XG#i');
define('SECURE_AUTH_SALT', 'CKY1-A)@kV:D|+#pxa+o= Q%%tKdPV-jqfS!EyzAv ukmmnLpfHt[~C|++7Nr7[R');
define('LOGGED_IN_SALT',   '-o]}^iB}R@UC*s ?zla|SIp-T7!zB.Yn]IG!`VnpWx+td0:i.^MP*62c](8@s-s7');
define('NONCE_SALT',       'PBybKkF#Eg!9.ToONZ=O;+Dw#Gio?o}^wr{jdM?Tljo~lH.sN7ENoR6B->n-b>=l');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pw_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'es_ES');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
