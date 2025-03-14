<?php
if(!defined('BASEPATH')) {
   die('Direct access to the script is not allowed');
}

// Check if admin is logged in
if (!isset($_SESSION["msmbilisim_adminlogin"]) || $_SESSION["msmbilisim_adminlogin"] != 1) {
    header("Location:" . site_url("admin/login"));
    exit();
}

// Check admin access
if (!isset($admin["access"]["admin_access"]) || $admin["access"]["admin_access"] != 1) {
    header("Location:" . site_url("admin/login"));
    exit();
}

// Get recent clients
$clients = $conn->prepare("SELECT * FROM clients ORDER BY client_id DESC LIMIT 500");
$clients->execute(array());
$clients = $clients->fetchAll(PDO::FETCH_ASSOC);

// Get failed orders count
$failCount = $conn->prepare("SELECT * FROM orders WHERE orders.dripfeed='1' && orders.subscriptions_type='1' && order_error!=:error ");
$failCount->execute(array("error" => "-"));
$failCount = $failCount->rowCount();

// Get today's orders count
$todayCount = $conn->prepare("SELECT * FROM orders WHERE last_check=:error ");
$todayCount->execute(array("error" => date("Y-m-d")));
$todayCount = $todayCount->rowCount();

// Load admin dashboard view
require admin_view('index');