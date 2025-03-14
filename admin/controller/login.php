<?php
use PragmaRX\Google2FA\Google2FA;

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure we have access to required functions and variables
if (!function_exists('site_url') || !isset($conn) || !isset($settings)) {
    require_once dirname(__FILE__) . '/../../app/init.php';
}

if (!defined('BASEPATH')) {
    define('BASEPATH', true);
}

// Initialize variables
$viewData = [
    'error' => false,
    'errorText' => "",
    'success' => false,
    'successText' => ""
];

// If already logged in, redirect to admin dashboard
if (isset($_SESSION["msmbilisim_adminlogin"]) && $_SESSION["msmbilisim_adminlogin"] == 1) {
    header("Location: " . site_url('admin'));
    exit();
}

if ($_POST) {
    $username = htmlspecialchars($_POST["username"]);
    $pass = $_POST["password"];
    $captcha = isset($_POST['g-recaptcha-response']) ? htmlspecialchars($_POST['g-recaptcha-response']) : '';
    $remember = isset($_POST["remember"]) ? htmlspecialchars($_POST["remember"]) : '';
    $two_factor_code = isset($_POST["two_factor_code"]) ? htmlspecialchars($_POST["two_factor_code"]) : '';

    // Verify captcha if enabled
    if ($settings["recaptcha"] == 2) {
        $googlesecret = $settings["recaptcha_secret"];
        $captcha_verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$googlesecret&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
        $captcha_verify = json_decode($captcha_verify);

        if ($captcha_verify->success == false) {
            $viewData['error'] = true;
            $viewData['errorText'] = "Please verify that you are not a robot.";
            $_SESSION["recaptcha"] = true;
        }
    }

    if (!$viewData['error']) {
        // Check if account is suspended
        if (countRow(["table" => "admins", "where" => ["username" => $username, "client_type" => 1]])) {
            $viewData['error'] = true;
            $viewData['errorText'] = "Your account is Suspended.";
        } else {
            // Verify credentials
            $admin = $conn->prepare("SELECT * FROM admins WHERE username=:username && password=:password");
            $admin->execute(array(
                "username" => $username,
                "password" => md5(sha1(md5($pass)))
            ));
            $admin = $admin->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $access = json_decode($admin["access"], true);

                if ($access["admin_access"]) {
                    // Check 2FA if enabled
                    if ($admin["two_factor"] == 1) {
                        $google2fa = new Google2FA();
                        $is_valid = $google2fa->verifyKey($admin["two_factor_secret_key"], $two_factor_code);

                        if (!$is_valid) {
                            $viewData['error'] = true;
                            $viewData['errorText'] = "Invalid 2FA Code.";
                        }
                    }

                    if (!$viewData['error']) {
                        // Set session and cookies
                        $_SESSION["msmbilisim_adminlogin"] = 1;
                        $_SESSION["msmbilisim_adminid"] = $admin["admin_id"];
                        $_SESSION["msmbilisim_adminpass"] = $pass;
                        $_SESSION["recaptcha"] = false;

                        if ($remember) {
                            setcookie("a_login", 'ok', time()+(60*60*24*7), '/', null, null, true);
                            setcookie("a_id", $admin["admin_id"], time()+(60*60*24*7), '/', null, null, true);
                            setcookie("a_password", $admin["password"], time()+(60*60*24*7), '/', null, null, true);
                        }

                        // Update last login
                        $update = $conn->prepare("UPDATE admins SET login_date=:date, login_ip=:ip WHERE admin_id=:id");
                        $update->execute(array(
                            "id" => $admin["admin_id"],
                            "date" => date("Y.m.d H:i:s"),
                            "ip" => GetIP()
                        ));

                        // Redirect based on 2FA status
                        if ($admin["two_factor"] == 1) {
                            // Force session write before redirect
                            session_write_close();
                            header("Location: " . site_url('admin'));
                            exit();
                        } else {
                            // Force session write before redirect
                            session_write_close();
                            header("Location: " . site_url('admin/activate-google-2fa'));
                            exit();
                        }
                    }
                } else {
                    $viewData['error'] = true;
                    $viewData['errorText'] = "You do not have admin access.";
                }
            } else {
                $viewData['error'] = true;
                $viewData['errorText'] = "Invalid username or password.";
            }
        }
    }
}

// Extract variables for the view
extract($viewData);

// Load login view
require admin_view('login');