<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
// Define site root path if not already defined
defined('SITE_ROOT') ? null : define('SITE_ROOT', dirname(__DIR__) . DS);

// Define paths for includes and core folders
defined('INC_PATH') ? null : define('INC_PATH', SITE_ROOT . 'includes' . DS);
defined('CORE_PATH') ? null : define('CORE_PATH', SITE_ROOT . 'core' . DS);

// Load configuration file
require_once INC_PATH . "config.php";

// Load core classes
require_once CORE_PATH . "post.php";
