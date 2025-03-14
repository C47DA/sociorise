<?php
if (!defined('BASEPATH')) {
  die('Direct access to the script is not allowed');
}

// Check if user is logged in as admin
if (!isset($_SESSION["msmbilisim_adminslogin"]) || $_SESSION["msmbilisim_adminslogin"] != 1) {
  $route[1] = "login";
  require admin_controller($route[1]);
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

$access = json_decode($admin["access"], true);

// Check admin access
if (!$access["admin_access"]) {
  session_destroy();
  header("Location: " . site_url('admin/login'));
  exit();
}

// Set default route
if (!route(1)) {
  $route[1] = "index";
}

// Check if controller exists
if (!file_exists(admin_controller(route(1)))) {
  $route[1] = "index";
}

// Load common data
$currencies_array = get_currencies_array("all");
$categories = $conn->prepare("SELECT category_id,category_name FROM categories WHERE category_deleted=:deleted ORDER BY category_line ASC");
$categories->execute(["deleted" => 0]);
$categories = $categories->fetchAll(PDO::FETCH_ASSOC);
$categories = json_encode($categories, true);

$panel_settings = $conn->prepare("SELECT site_base_currency as site_currency FROM settings WHERE id=1");
$panel_settings->execute();
$panel_settings = $panel_settings->fetch(PDO::FETCH_ASSOC);
$panel_settings["site_currency_symbol"] = get_currency_symbol_by_code($panel_settings["site_currency"]);
$panel_settings = json_encode($panel_settings, true);

$users = $conn->prepare("SELECT client_id,name,username FROM clients ORDER BY client_id DESC");
$users->execute();
$users = $users->fetchAll(PDO::FETCH_ASSOC);
$users = json_encode($users, true);

$services = $conn->prepare("SELECT service_id,service_name,category_id as cid,service_price as price,api_detail FROM services WHERE service_deleted=:deleted ORDER BY service_line ASC");
$services->execute(["deleted" => 0]);
$services = $services->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($services); $i++) {
  $api_detail = json_decode($services[$i]["api_detail"], true);
  $services[$i]["cost"] = from_to($currencies_array, $api_detail["currency"], $settings["site_base_currency"], $api_detail["rate"]);
  if ($api_detail["currency"] != $settings["site_base_currency"]) {
    $services[$i]["price"] = ROUND_AMOUNT($services[$i]["price"], 4);
    $services[$i]["cost"] = ROUND_AMOUNT($services[$i]["cost"], 4);
  }
  $services[$i]["price"] = floatval($services[$i]["price"]);
  unset($services[$i]["api_detail"]);
}
$services = json_encode($services, true);

$ADMIN_CONSTANTS = $conn->prepare("SELECT * FROM admin_constants WHERE id=1");
$ADMIN_CONSTANTS->execute();
$ADMIN_CONSTANTS = $ADMIN_CONSTANTS->fetch(PDO::FETCH_ASSOC);

// Load the requested controller
require admin_controller(route(1));