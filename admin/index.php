<?php
if(!defined('BASEPATH')) {
    define('BASEPATH', TRUE);
    require_once __DIR__ . '/../app/init.php';
}

// Check if user is logged in as admin
if (!isset($_SESSION["msmbilisim_adminslogin"]) || $_SESSION["msmbilisim_adminslogin"] != 1) {
    // Not logged in, redirect to login
    $route[1] = "login";
} else {
    // Get the requested admin page from URL
    $admin_page = isset($route[1]) ? $route[1] : "index";
}

// Load the appropriate controller
$controller_file = __DIR__ . '/controller/' . $admin_page . '.php';
if (file_exists($controller_file)) {
    require_once $controller_file;
} else {
    // If controller doesn't exist, show 404
    header("HTTP/1.0 404 Not Found");
    require admin_view('404');
} 