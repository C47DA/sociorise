<?php
// Set session parameters
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_samesite', 'Strict');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check admin login status
function is_admin_logged_in() {
    return isset($_SESSION["msmbilisim_adminslogin"]) && $_SESSION["msmbilisim_adminslogin"] == 1;
}

// Function to check user login status
function is_user_logged_in() {
    return isset($_SESSION["msmbilisim_userlogin"]) && $_SESSION["msmbilisim_userlogin"] == 1;
}

// Function to require admin login
function require_admin_login() {
    if (!is_admin_logged_in()) {
        header("Location: /admin/login");
        exit();
    }
} 