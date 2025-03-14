<?php
if (!defined('PATH')) {
    define('PATH', realpath(dirname(__FILE__) . '/../'));
}

// Site configuration
define('SUBFOLDER', true);
define('URL', 'https://sociorise.com/admin');
define('STYLESHEETS_URL', '//sociorise.com');
define('BASE_URL', rtrim(URL, '/'));

// Security settings
define('ADMIN_EMAIL', 'admin@sociorise.com');
define('SITE_NAME', 'Sociorise');
define('SITE_DESCRIPTION', 'Social Media Services');

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Error reporting based on environment
if (defined('DEVELOPMENT_MODE') && DEVELOPMENT_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Database configuration
return [
    'db' => [
        'name'    => 'socioris_try1',
        'host'    => 'localhost',
        'user'    => 'socioris_try1',
        'pass'    => 'socioris_try1',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ]
    ]
];

?>