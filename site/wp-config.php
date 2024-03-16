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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/var/www/clients/client0/web56/web/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'c0mreviews' );

/** MySQL database username */
define( 'DB_USER', 'c0mrev' );

/** MySQL database password */
define( 'DB_PASSWORD', 'gLdYfjcBD#W9' );

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
define( 'AUTH_KEY',         '-oNhQ=RweYp}YPFw#kBbX&4%2,/2IZ.qDHofg(2=nzEqnx71/xCqV:gL,chw Vx*' );
define( 'SECURE_AUTH_KEY',  'd?L{%`RB]w0t)9?PK?t|UPH.4}AK*):<e9^nYE#hgLjM6OMxP$HJU3#aa6WS.WT$' );
define( 'LOGGED_IN_KEY',    ':?tDT,T^Yp7n0uBvCrym81K@DM0J[Z|1_jPM3>YUEzK$6iYBlQn| {F,bDEXl-=7' );
define( 'NONCE_KEY',        'LmN#OcK(306luc@ry!YF<6mu?0K#g<Vv%DIz2PCF/4SsA+_p)kWB2$H?qIar]}8>' );
define( 'AUTH_SALT',        '_j(Z~c;wxtBRU6 L*U.Roq0TZ$e%O!He0T%Un{hfK%oY^K5x#di>OJ&XYOUZ60v:' );
define( 'SECURE_AUTH_SALT', 'F!O&qkD<K.mnMAbVED[#y#qA$~1UGbJmu#CG8G@i^<}1r#b#u>H3c,PqZ+ava!wl' );
define( 'LOGGED_IN_SALT',   's(=m~mG`k8Ljt,Ajm&@gqP=(KB ~Hg+#5c4#^c&<)K={8`R8Ma%wtUglfuO$U!_M' );
define( 'NONCE_SALT',       'r]H}(s]B!=S&}Cy6b:s&vn;$1/$5N;${%^J@-!7^.rgHT%oIHshXr.;FbwB9= 1(' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'mrev_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
