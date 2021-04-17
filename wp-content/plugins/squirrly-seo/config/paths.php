<?php
defined('ABSPATH') || die('Cheatin\' uh?');

$currentDir = dirname(__FILE__);

define('_SQ_NAME_', 'squirrly');
define('_SQ_MENU_NAME_', 'Squirrly SEO');
define('_SQ_NAMESPACE_', 'SQ');
define('_SQ_PLUGIN_NAME_', 'squirrly-seo'); //THIS LINE WILL BE CHANGED WITH THE USER SETTINGS

defined('SQ_SSL') || define('SQ_SSL', (((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") || (defined('FORCE_SSL_ADMIN') && FORCE_SSL_ADMIN) || (function_exists('is_ssl') && is_ssl())) ? 'https:' : 'http:')); //CHECK SSL
defined('SQ_CHECK_SSL') || define('SQ_CHECK_SSL', SQ_SSL);
defined('SQ_URI') || define('SQ_URI', 'wp530');
defined('_SQ_DASH_URL_') || define('_SQ_DASH_URL_', 'https://cloud.squirrly.co/');
defined('_SQ_APIV2_URL_') || define('_SQ_APIV2_URL_', SQ_SSL . '//api.squirrly.co/v2/');
define('_SQ_SITE_HOST_', parse_url(home_url(), PHP_URL_HOST));

define('_SQ_SUPPORT_EMAIL_', 'support@squirrly.co');
defined('_SQ_STATIC_API_URL_') || define('_SQ_STATIC_API_URL_', '//storage.googleapis.com/squirrly/');
defined('_SQ_SUPPORT_EMAIL_URL_') || define('_SQ_SUPPORT_EMAIL_URL_', 'http://plugin.squirrly.co/contact/');
defined('_SQ_SUPPORT_FACEBOOK_URL_') || define('_SQ_SUPPORT_FACEBOOK_URL_', 'https://www.facebook.com/Squirrly.co');
defined('_SQ_HOWTO_URL_') || define('_SQ_HOWTO_URL_', 'https://howto.squirrly.co/wordpress-seo/');
defined('_SQ_SUPPORT_URL_') || define('_SQ_SUPPORT_URL_', 'https://www.dmsuperstars.com/squirrly-support/');

/* Directories */
define('_SQ_ROOT_DIR_', realpath(dirname($currentDir)) . '/');
define('_SQ_CLASSES_DIR_', _SQ_ROOT_DIR_ . 'classes/');
define('_SQ_CONTROLLER_DIR_', _SQ_ROOT_DIR_ . 'controllers/');
define('_SQ_MODEL_DIR_', _SQ_ROOT_DIR_ . 'models/');
define('_SQ_SERVICE_DIR_', _SQ_MODEL_DIR_ . 'services/');
define('_SQ_TRANSLATIONS_DIR_', _SQ_ROOT_DIR_ . 'translations/');
define('_SQ_CORE_DIR_', _SQ_ROOT_DIR_ . 'core/');
define('_SQ_THEME_DIR_', _SQ_ROOT_DIR_ . 'view/');
define('_SQ_ASSETS_DIR_', _SQ_THEME_DIR_ . 'assets/');

/* URLS */
define('_SQ_URL_', rtrim(plugins_url('', $currentDir), '/') . '/');
define('_SQ_THEME_URL_', _SQ_URL_ . 'view/');
define('_SQ_ASSETS_URL_', _SQ_THEME_URL_ . 'assets/');
define('_SQ_ASSETS_RELATIVE_URL_', ltrim(parse_url(_SQ_ASSETS_URL_, PHP_URL_PATH), '/'));


$upload_dir = array();
$upload_dir['baseurl'] = WP_CONTENT_URL . '/uploads';
$upload_dir['basedir'] = WP_CONTENT_DIR . '/uploads';

if (!defined('UPLOADS')) {
    $basedir = WP_CONTENT_DIR . '/uploads/' . _SQ_NAME_;
    $baseurl = rtrim(content_url(), '/') . '/uploads/' . _SQ_NAME_;
} else {
    $basedir = rtrim(ABSPATH, '/') . '/' . trim(UPLOADS, '/') . '/' . _SQ_NAME_;
    $baseurl = home_url() . '/' . trim(UPLOADS, '/') . '/' . _SQ_NAME_;
}

if (!is_dir($basedir)) {
    @wp_mkdir_p($basedir);
}

if (!is_dir($basedir) || !function_exists('wp_is_writable') || !wp_is_writable($basedir)) {
    $basedir = _SQ_ROOT_DIR_ . 'cache';
    $baseurl = _SQ_URL_ . 'cache';
}

defined('_SQ_CACHE_DIR_') || define('_SQ_CACHE_DIR_', $basedir . '/');
defined('_SQ_CACHE_URL_') || define('_SQ_CACHE_URL_', $baseurl . '/');

