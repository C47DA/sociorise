<?php

function admin_controller($controllerName){
  $controllerName = $controllerName;
  // Remove .php extension if already present
  $controllerName = preg_replace('/\.php$/', '', $controllerName);
  $file_path = PATH.'/admin/controller/'.$controllerName.'.php';
  
  // Check if file exists
  if (!file_exists($file_path)) {
    error_log("Admin controller not found: " . $file_path);
  }
  
  return $file_path;
}

function admin_view($viewName){
  $viewName = $viewName;
  // Remove .php extension if already present
  $viewName = preg_replace('/\.php$/', '', $viewName);
  $file_path = PATH.'/admin/views/'.$viewName.'.php';
  
  // Check if file exists
  if (!file_exists($file_path)) {
    error_log("Admin view not found: " . $file_path);
    // Return a fallback view if the requested one doesn't exist
    if ($viewName !== '404' && file_exists(PATH.'/admin/views/404.php')) {
      return PATH.'/admin/views/404.php';
    }
  }
  
  return $file_path;
}

function servicePackageType($type){
  switch ($type) {
    case '1':
      return "Default";
      break;
    case '2':
      return "Package";
      break;
    case '3':
      return "Special comments";
      break;
    case '4':
      return "Package comments";
      break;
    default:
      return "Subscriptions";
      break;
  }
}