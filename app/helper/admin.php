<?php

function admin_controller($controllerName){
  $controllerName = $controllerName;
  return PATH.'/admin/controller/'.$controllerName.'.php';
}

function admin_view($viewName){
  $viewName = $viewName;
  if (!file_exists(PATH.'/admin/views/'.$viewName.'.php')) {
    die("View not found: " . $viewName);
  }
  return PATH.'/admin/views/'.$viewName.'.php';
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