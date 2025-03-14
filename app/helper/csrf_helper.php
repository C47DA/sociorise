<?php
if (!defined('BASEPATH')) {
    die('Direct access to the script is not allowed');
}

/**
 * Generate a CSRF token and store it in the session
 * 
 * @return string The generated CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token']) || empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate a CSRF token against the one stored in session
 * 
 * @param string $token The token to validate
 * @return bool True if token is valid, false otherwise
 */
function validate_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Generate a CSRF token input field for forms
 * 
 * @return string HTML input field with CSRF token
 */
function csrf_token_input() {
    $token = generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Check if the current request has a valid CSRF token
 * Exits with error if token is invalid
 */
function check_csrf_token() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || !validate_csrf_token($_POST['csrf_token'])) {
            http_response_code(403);
            die('Invalid CSRF token. Please try again.');
        }
    }
}
?> 