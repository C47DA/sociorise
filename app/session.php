<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set error handler
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    error_log("Error [$errno]: $errstr in $errfile on line $errline");
    return true;
}
set_error_handler('customErrorHandler');

// Set exception handler
function customExceptionHandler($exception) {
    error_log("Uncaught Exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine());
}
set_exception_handler('customExceptionHandler');

// Set session parameters before starting the session
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', 3600); // 1 hour
ini_set('session.cookie_lifetime', 3600); // 1 hour
ini_set('session.save_handler', 'files');

// Ensure session directory exists and is writable
$session_path = sys_get_temp_dir();
if (!is_dir($session_path) || !is_writable($session_path)) {
    $session_path = '/tmp';
}
ini_set('session.save_path', $session_path);

// Now start the session
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

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
        
        // Verify session hasn't expired
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
            session_destroy();
            return false;
        }
        
        // Update last activity time
        $_SESSION['last_activity'] = time();
        
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
        
        // Verify session hasn't expired
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
            session_destroy();
            return false;
        }
        
        // Update last activity time
        $_SESSION['last_activity'] = time();
        
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
            
            // Clear admin cookies
            setcookie("a_login", '', time() - 3600, '/', null, null, true);
            setcookie("a_id", '', time() - 3600, '/', null, null, true);
            setcookie("a_password", '', time() - 3600, '/', null, null, true);
            
            header("Location: " . site_url('admin/login'));
            exit();
        }
    } catch (Exception $e) {
        error_log("Error in require_admin_login: " . $e->getMessage());
        header("Location: " . site_url('admin/login'));
        exit();
    }
}

// Function to log out admin
function admin_logout() {
    try {
        // Clear session data
        session_unset();
        session_destroy();
        
        // Clear admin cookies
        setcookie("a_login", '', time() - 3600, '/', null, null, true);
        setcookie("a_id", '', time() - 3600, '/', null, null, true);
        setcookie("a_password", '', time() - 3600, '/', null, null, true);
        
        // Clear session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/', null, null, true);
        }
        
        header("Location: " . site_url('admin/login'));
        exit();
    } catch (Exception $e) {
        error_log("Error in admin_logout: " . $e->getMessage());
        header("Location: " . site_url('admin/login'));
        exit();
    }
} 