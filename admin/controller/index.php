<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}

// Check if admin is logged in and has proper access
if (!isset($_SESSION["msmbilisim_adminlogin"]) || $_SESSION["msmbilisim_adminlogin"] != 1) {
    header("Location:" . site_url("admin/login"));
    exit();
}

// Get admin info
$admin = $conn->prepare("SELECT * FROM admins WHERE admin_id=:id");
$admin->execute(array("id" => $_SESSION["msmbilisim_adminid"]));
$admin = $admin->fetch(PDO::FETCH_ASSOC);

if (!$admin || !isset($admin["access"]["admin_access"]) || $admin["access"]["admin_access"] != 1) {
    session_destroy();
    header("Location:" . site_url("admin/login"));
    exit();
}

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

// Load admin dashboard view
require admin_view('index');