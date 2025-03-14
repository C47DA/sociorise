<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "Error [$errno]: $errstr in $errfile on line $errline";
    return true;
}
set_error_handler('customErrorHandler');

// Set exception handler
function customExceptionHandler($exception) {
    echo "Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine();
}
set_exception_handler('customExceptionHandler');

if(!defined('BASEPATH')) {
    define('BASEPATH', TRUE);
    try {
        require_once __DIR__ . '/../app/init.php';
        require_once __DIR__ . '/../app/session.php';
    } catch (Exception $e) {
        die("Error loading required files: " . $e->getMessage());
    }
}

// Get the requested admin page from URL
$admin_page = isset($_GET['route']) ? $_GET['route'] : (isset($route[1]) ? $route[1] : "index");

// Special handling for login page
if ($admin_page === 'login') {
    try {
        require_once __DIR__ . '/controller/login.php';
    } catch (Exception $e) {
        die("Error loading login controller: " . $e->getMessage());
    }
    exit();
}

// Check if user is logged in as admin
if (!is_admin_logged_in()) {
    // Not logged in, redirect to login
    header("Location: /admin/login");
    exit();
}

// Load the appropriate controller
$controller_file = __DIR__ . '/controller/' . $admin_page . '.php';
if (file_exists($controller_file)) {
    try {
        require_once $controller_file;
    } catch (Exception $e) {
        die("Error loading controller: " . $e->getMessage());
    }
} else {
    // If controller doesn't exist, show 404
    header("HTTP/1.0 404 Not Found");
    require admin_view('404');
} 