<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set session parameters
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.gc_maxlifetime', 3600); // 1 hour
ini_set('session.cookie_lifetime', 3600); // 1 hour

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check admin login status
function is_admin_logged_in() {
    if (!isset($_SESSION["msmbilisim_adminslogin"]) || $_SESSION["msmbilisim_adminslogin"] != 1) {
        return false;
    }
    
    // Additional security check - verify session data
    if (!isset($_SESSION["msmbilisim_adminid"]) || !isset($_SESSION["msmbilisim_adminpass"])) {
        session_destroy();
        return false;
    }
    
    return true;
}

// Function to check user login status
function is_user_logged_in() {
    if (!isset($_SESSION["msmbilisim_userlogin"]) || $_SESSION["msmbilisim_userlogin"] != 1) {
        return false;
    }
    
    // Additional security check - verify session data
    if (!isset($_SESSION["msmbilisim_userid"]) || !isset($_SESSION["msmbilisim_userpass"])) {
        session_destroy();
        return false;
    }
    
    return true;
}

// Function to require admin login
function require_admin_login() {
    if (!is_admin_logged_in()) {
        // Clear any existing session data
        session_unset();
        session_destroy();
        header("Location: /admin/login");
        exit();
    }
}

// Function to log out admin
function admin_logout() {
    session_unset();
    session_destroy();
    
    // Clear admin cookies
    setcookie("a_login", '', time() - 3600, '/', null, null, true);
    setcookie("a_id", '', time() - 3600, '/', null, null, true);
    setcookie("a_password", '', time() - 3600, '/', null, null, true);
    
    header("Location: /admin/login");
    exit();
} 