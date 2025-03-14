<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the root path
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

// Set include path
set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_PATH);

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

// Check if init.php exists
$init_file = ROOT_PATH . '/app/init.php';
if (!file_exists($init_file)) {
    die("Error: Required file $init_file not found. Current directory: " . getcwd());
}

try {
    require_once $init_file;
    require_once ROOT_PATH . '/app/session.php';
} catch (Exception $e) {
    die("Error loading required files: " . $e->getMessage());
}

// Get the requested admin page from URL
$admin_page = $_GET['route'] ?? ($route[1] ?? "index");

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
if (!function_exists('is_admin_logged_in') || !is_admin_logged_in()) {
    // Not logged in, redirect to login
    header("Location: " . site_url('admin/login'));
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