<?php
/* =======================================
   INKREALM FINAL CONFIG (PDO COMPATIBLE)
======================================= */

/* DETECT ENVIRONMENT */
$is_localhost = ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1' || $_SERVER['SERVER_NAME'] === 'localhost');

if ($is_localhost) {
    /* LOCAL XAMPP SETTINGS */
    $host     = "localhost";
    $user     = "root";
    $password = "";
    $database = "inkrealm";
} else {
    /* LIVE RENDER SETTINGS */
    $host     = "dpg-d896qamgvqtc73bmjikg-a"; 
    $user     = "inkrealm_user";
    $password = "Z6qURzQfsxbUvW0uRQWOEQplmlPv9y5S";
    $database = "inkrealm_user";
    $driver   = "pgsql" ; 
}

/* CONNECT DATABASE VIA PDO */
try {
    // If using PostgreSQL on Render, change "mysql" to "pgsql" below
    $conn = new PDO("pgsqlsql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

/* START SESSION */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* =======================================
   SECURITY & SANITIZATION
======================================= */
function clean($data) {
    return trim($data);
}

function safe($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/* =======================================
   EDITORIAL ROLE CHECKS
======================================= */
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function is_acquisition_editor() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'acquisition_editor');
}

function is_senior_editor() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'senior_editor');
}

function check_ae() {
    if (!is_acquisition_editor()) {
        die("Access Denied: Acquisition Editors Only.");
    }
}

function check_se() {
    if (!is_senior_editor()) {
        die("Access Denied: Senior Editors Only.");
    }
}

/* =======================================
   SITE SETTINGS
======================================= */
$site_name = "INKREALM";
$site_url  = $is_localhost ? "http://localhost/INKREALM" : "https://inkrealm-i9yk.onrender.com";

/* =======================================
   NOTIFICATIONS SYSTEM
======================================= */
function notify($user_id, $message) {
    global $conn;
    $message = clean($message);
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)");
    $stmt->execute(['user_id' => $user_id, 'message' => $message]);
}

/* =======================================
   CONTRACT SYSTEM
======================================= */
function approve_contract($contract_id, $type, $send_to) {
    global $conn;
    $stmt = $conn->prepare("UPDATE contracts SET status = 'Approved', contract_type = :type, send_to = :send_to WHERE id = :contract_id");
    $stmt->execute(['type' => $type, 'send_to' => $send_to, 'contract_id' => $contract_id]);
}

function reject_contract($contract_id, $reason) {
    global $conn;
    $reason = clean($reason);
    $stmt = $conn->prepare("UPDATE contracts SET status = 'Rejected', reason = :reason WHERE id = :contract_id");
    $stmt->execute(['reason' => $reason, 'contract_id' => $contract_id]);
}
?>