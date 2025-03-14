<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the root path
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));

// Set include path
set_include_path(get_include_path() . PATH_SEPARATOR . ROOT_PATH);

// Check if init.php exists
$init_file = ROOT_PATH . '/app/init.php';
if (!file_exists($init_file)) {
    die("Error: Required file $init_file not found. Current directory: " . getcwd());
}

try {
    // First load init.php which sets up the database and basic configuration
    require_once $init_file;
    
    // Then load session.php for session management
    require_once ROOT_PATH . '/app/session.php';
    
    // Define BASEPATH after loading init
    if (!defined('BASEPATH')) {
        define('BASEPATH', true);
    }
    
    // Debug session data
    if (isset($_GET['debug']) && $_GET['debug'] == 1) {
        echo "<pre>SESSION: ";
        print_r($_SESSION);
        echo "</pre>";
    }
    
    // Parse the URL to get the requested page
    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
    $base_path = rtrim(dirname($script_name), '/');
    $path = substr(parse_url($request_uri, PHP_URL_PATH), strlen($base_path));
    $path = trim($path, '/');
    $parts = explode('/', $path);
    
    // Set up route array
    $route = [];
    if (count($parts) > 1) {
        // Remove 'admin' from the beginning if present
        if ($parts[0] === 'admin') {
            array_shift($parts);
        }
        
        // Add remaining parts to route array
        foreach ($parts as $i => $part) {
            $route[$i] = $part;
        }
    }
    
    // Get the requested admin page from URL or route
    $admin_page = isset($_GET['route']) ? $_GET['route'] : (isset($route[0]) ? $route[0] : "index");
    
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
    if (!isset($_SESSION["msmbilisim_adminlogin"]) || $_SESSION["msmbilisim_adminlogin"] != 1) {
        // Not logged in, redirect to login
        header("Location: " . site_url('admin/login'));
        exit();
    }
    
    // Get admin info
    $admin = $conn->prepare("SELECT * FROM admins WHERE admin_id=:id");
    $admin->execute(array("id" => $_SESSION["msmbilisim_adminid"]));
    $admin = $admin->fetch(PDO::FETCH_ASSOC);
    
    if (!$admin) {
        session_destroy();
        header("Location: " . site_url('admin/login'));
        exit();
    }
    
    // Parse access JSON
    $access = json_decode($admin["access"], true);
    
    // Check admin access
    if (!isset($access["admin_access"]) || $access["admin_access"] != 1) {
        session_destroy();
        header("Location: " . site_url('admin/login'));
        exit();
    }
    
    // Default to index if no page specified
    if (empty($admin_page)) {
        $admin_page = "index";
    }
    
    // Load the appropriate controller
    $controller_file = __DIR__ . '/controller/' . $admin_page . '.php';
    if (file_exists($controller_file)) {
        try {
            require_once $controller_file;
        } catch (Exception $e) {
            die("Error loading controller: " . $e->getMessage() . " in file: " . $controller_file);
        }
    } else {
        // If controller doesn't exist, show 404
        header("HTTP/1.0 404 Not Found");
        echo "Controller not found: " . $controller_file;
        if (function_exists('admin_view')) {
            require admin_view('404');
        } else {
            die("404 Page Not Found - Controller: " . $admin_page);
        }
    }
} catch (Exception $e) {
    die("Error in admin/index.php: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
} 