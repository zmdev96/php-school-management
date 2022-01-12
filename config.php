<?php
require_once('app-admin/db_connect.php');

// Constants
if (!defined('DS')) {
  define('DS', DIRECTORY_SEPARATOR);
}
// Define The App Paths
define('APP_PATH', realpath(dirname(__FILE__)) . DS);
// Define The Admin Root
define('APP_ADMIN','app-admin');

// Web Paths
define('TEMPLATE_PATH', APP_PATH . 'includes' . DS . 'templates' . DS );
define('FUNCTIONS_PATH', APP_PATH . 'includes' . DS . 'functions' . DS );
define('LANGUAGES_PATH', APP_PATH .  'includes' . DS . 'languages' . DS );
// Admin Paths
define('ADMIN_TEMPLATE_PATH', APP_PATH . APP_ADMIN . DS . 'includes' . DS . 'templates' . DS );
define('ADMIN_FUNCTIONS_PATH', APP_PATH . APP_ADMIN . DS . 'includes' . DS . 'functions' . DS );
define('ADMIN_LANGUAGES_PATH', APP_PATH .  APP_ADMIN . DS . 'includes' . DS . 'languages' . DS );
// Degault App Language
define('APP_LANGUAGE', 'en');

// Resources Paths
$ADMIN_CSS      = 'assets/css/';
$ADMIN_VENDOR   = 'assets/vendor/';
$ADMIN_JS       = 'assets/js/';

// Require The Important Files
require_once(ADMIN_FUNCTIONS_PATH . 'all_functions.php');

// App Languages Handler
if (!isset($_SESSION['app_lang'])) {
  $_SESSION['app_lang']= APP_LANGUAGE;
}
if ($app === 'app-admin') {
  include ADMIN_LANGUAGES_PATH . 'lang_'. $_SESSION['app_lang'] . '.php';
}else {
  include LANGUAGES_PATH . 'lang_'. $_SESSION['app_lang'] . '.php';
}
