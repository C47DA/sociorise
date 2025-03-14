<?php
function controller($controllerName) {
    $controllerName = $controllerName;
   
    return PATH . '/app/controller/' . $controllerName . '.php';
}
function view($viewName) {
    $viewName = $viewName;
    return PATH . '/app/views/' . $viewName;
}
function route($index) {
    global $route;
    if (isset($route[$index])) {
        return $route[$index];
    } else {
     return false;
    }
}
function site_url($url = false) {
    // Ensure URL constant ends with a slash
    $base_url = rtrim(URL, '/') . '/';
    
    // If no URL is provided, return the base URL
    if ($url === false) {
        return $base_url;
    }
    
    // Remove leading slash from the URL if present
    $url = ltrim($url, '/');
    
    // Return the complete URL
    return $base_url . $url;
}
function GetIP() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) $ip = $_SERVER['REMOTE_ADDR'];
    else $ip = "unknown";
    return ($ip);
}

function themeExtras($which) {
    global $conn;
    $theme = $conn->prepare("SELECT * FROM themes WHERE theme_dirname=:dir ");
    $theme->execute(array('dir' => THEME));
    $theme = $theme->fetch(PDO::FETCH_ASSOC);
    return json_decode($theme["theme_extras"], true);
}
$stylesheet = themeExtras('stylesheets');
