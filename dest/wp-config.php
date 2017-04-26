<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'beezup');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9tbm.<&;`N9;618Z)(%9%*?uZBO>ct]0y7^]di7ByV<O2T;-WP,K|>dRBVC1X`Pw');
define('SECURE_AUTH_KEY',  'U3DUG|Mp;/) $2XJ3~s< Dw$wMykU@hc8Bw~8I8tVpyXzu}Ye+tjfRUE#ivq<2=T');
define('LOGGED_IN_KEY',    'Q).t-6U@hr!tv;HotzX0xbw?RN;IY&2S9v/p}BRHsNrvor%tm^EcQ& ?{<TUu?{(');
define('NONCE_KEY',        'V`>IZZDZBXgG7sW=ras<1:#4CGa-zX};A]!*wYo=c@>N{ORe_F.^HE.9aSq.D)IV');
define('AUTH_SALT',        '-SF_80,8VsE0MC-N~}cq&Vc,^6E{9LPD{c>{^KJldPV@cdca& RspJ&`5a489/sK');
define('SECURE_AUTH_SALT', '{4tl{S]CJc-;JB7:L#u^mq57u}cQg.aZLuW_siBws0s0:hk^tHom#LE4.vR2l3NV');
define('LOGGED_IN_SALT',   '5PW+5WVz}2]AOJZHxo4cI<j ZI4|BKb+>g-J&/Xu/gM5wI%A%U3#4pZ~AYJpt4x&');
define('NONCE_SALT',       'ltIFF$iZ1B5ore}UYkdrtjdKnwK#mZF$1]_($X&GPC@Z(yUKO|]/ZI8QYb _@,oZ');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'beez_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

define('WP_POST_REVISIONS', 5);
define('EMPTY_TRASH_DAYS', 10);
define('WP_AUTO_UPDATE_CORE', true);
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_UNFILTERED_HTML', true);

define('WP_ALLOW_MULTISITE', TRUE);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
