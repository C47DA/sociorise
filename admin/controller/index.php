<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is logged in and has proper access
if (!isset($_SESSION["msmbilisim_adminlogin"]) || $_SESSION["msmbilisim_adminlogin"] != 1) {
    header("Location:" . site_url("admin/login"));
    exit();
}

// Get admin info
$admin = $conn->prepare("SELECT * FROM admins WHERE admin_id=:id");
$admin->execute(array("id" => $_SESSION["msmbilisim_adminid"]));
$admin = $admin->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    session_destroy();
    header("Location:" . site_url("admin/login"));
    exit();
}

// Parse access JSON if it's a string
if (is_string($admin["access"])) {
    $admin["access"] = json_decode($admin["access"], true);
}

// Check admin access
if (!isset($admin["access"]["admin_access"]) || $admin["access"]["admin_access"] != 1) {
    session_destroy();
    header("Location:" . site_url("admin/login"));
    exit();
}

try {
    // Get recent clients
    $clients = $conn->prepare("SELECT * FROM clients ORDER BY client_id DESC LIMIT 500");
    $clients->execute(array());
    $clients = $clients->fetchAll(PDO::FETCH_ASSOC);

    // Get failed orders count
    $failCount = $conn->prepare("SELECT COUNT(*) as count FROM orders WHERE dripfeed='1' AND subscriptions_type='1' AND order_error!=:error");
    $failCount->execute(array("error" => "-"));
    $failCount = $failCount->fetch(PDO::FETCH_ASSOC);
    $failCount = $failCount["count"];

    // Get today's orders count
    $todayCount = $conn->prepare("SELECT COUNT(*) as count FROM orders WHERE DATE(order_create)=:today");
    $todayCount->execute(array("today" => date("Y-m-d")));
    $todayCount = $todayCount->fetch(PDO::FETCH_ASSOC);
    $todayCount = $todayCount["count"];

    // Check if the view file exists
    $view_file = admin_view('index');
    if (!file_exists($view_file)) {
        // Try to find the view file directly
        $direct_view_file = PATH . '/admin/views/index.php';
        if (file_exists($direct_view_file)) {
            $view_file = $direct_view_file;
        } else {
            throw new Exception("Admin dashboard view file not found: " . $view_file);
        }
    }

    // Load admin dashboard view
    require $view_file;
} catch (Exception $e) {
    echo "Error loading admin dashboard: " . $e->getMessage();
    error_log("Error in admin/controller/index.php: " . $e->getMessage());
}