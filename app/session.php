<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    echo "Error [$errno]: $errstr in $errfile on line $errline";
    return true;
}
set_error_handler('customErrorHandler');

// Set exception handler
function customExceptionHandler($exception) {
    echo "Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine();
}
set_exception_handler('customExceptionHandler');

// Function to check admin login status
function is_admin_logged_in() {
    try {
        if (!isset($_SESSION["msmbilisim_adminlogin"]) || $_SESSION["msmbilisim_adminlogin"] !== 1) {
            return false;
        }
        
        // Additional security check - verify session data
        if (!isset($_SESSION["msmbilisim_adminid"]) || !isset($_SESSION["msmbilisim_adminpass"])) {
            session_destroy();
            return false;
        }
        
        return true;
    } catch (Exception $e) {
        error_log("Error in is_admin_logged_in: " . $e->getMessage());
        return false;
    }
}

// Function to check user login status
function is_user_logged_in() {
    try {
        if (!isset($_SESSION["msmbilisim_userlogin"]) || $_SESSION["msmbilisim_userlogin"] != 1) {
            return false;
        }
        
        // Additional security check - verify session data
        if (!isset($_SESSION["msmbilisim_userid"]) || !isset($_SESSION["msmbilisim_userpass"])) {
            session_destroy();
            return false;
        }
        
        return true;
    } catch (Exception $e) {
        error_log("Error in is_user_logged_in: " . $e->getMessage());
        return false;
    }
}

// Function to require admin login
function require_admin_login() {
    try {
        if (!is_admin_logged_in()) {
            // Clear any existing session data
            session_unset();
            session_destroy();
            header("Location: /admin/login");
            exit();
        }
    } catch (Exception $e) {
        error_log("Error in require_admin_login: " . $e->getMessage());
        header("Location: /admin/login");
        exit();
    }
}

// Function to log out admin
function admin_logout() {
    try {
        session_unset();
        session_destroy();
        
        // Clear admin cookies
        setcookie("a_login", '', time() - 3600, '/', null, null, true);
        setcookie("a_id", '', time() - 3600, '/', null, null, true);
        setcookie("a_password", '', time() - 3600, '/', null, null, true);
        
        header("Location: /admin/login");
        exit();
    } catch (Exception $e) {
        error_log("Error in admin_logout: " . $e->getMessage());
        header("Location: /admin/login");
        exit();
    }
} 