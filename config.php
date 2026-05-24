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
    // Replace these placeholder values with your actual Render External Database URL details!
    $host     = "dpg-d896qamgvqtc73bmjikg-a"; 
    $user     = "inkrealm_user";
    $password = "Z6qURzQfsxbUvW0uRQWOEQplmlPv9y5S";
    $database = "inkrealm";
}

/* CONNECT DATABASE VIA PDO (Works natively on Render & XAMPP) */
try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
    // Set error mode to exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

/* START SESSION */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* =======================================
   SECURITY
======================================= */

/* PREVENT SQL INJECTION */
function clean($data) {
    return trim($data);
}

/* ESCAPE HTML */
function safe($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/* =======================================
   SITE SETTINGS
======================================= */
$site_name = "INKREALM";
$site_url  = $is_localhost ? "http://localhost/INKREALM" : "https://inkrealm-i9yk.onrender.com";

/* =======================================
   ADMIN SETTINGS
======================================= */
$admin_username = "YOUR_USERNAME";

/* =======================================
   AUTH CHECK
======================================= */
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

/* =======================================
   ADMIN CHECK
======================================= */
function check_admin() {
    global $admin_username;
    if (!isset($_SESSION['username']) || $_SESSION['username'] != $admin_username) {
        die("Access Denied");
    }
}

/* =======================================
   COINS SYSTEM
======================================= */
function add_coins($user_id, $amount) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET coins = coins + :amount WHERE id = :user_id");
    $stmt->execute(['amount' => $amount, 'user_id' => $user_id]);
}

/* =======================================
   NOTIFICATIONS
======================================= */
function notify($user_id, $message) {
    global $conn;
    
    /* CREATE TABLE IF NOT EXISTS */
    $conn->exec("CREATE TABLE IF NOT EXISTS notifications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        message LONGTEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $message = clean($message);
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)");
    $stmt->execute(['user_id' => $user_id, 'message' => $message]);
}

/* =======================================
   FOLLOW SYSTEM
======================================= */
function follow_author($follower, $following) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM followers WHERE follower_id = :follower AND following_id = :following");
    $stmt->execute(['follower' => $follower, 'following' => $following]);
    
    if ($stmt->rowCount() == 0) {
        $ins = $conn->prepare("INSERT INTO followers (follower_id, following_id) VALUES (:follower, :following)");
        $ins->execute(['follower' => $follower, 'following' => $following]);
    }
}

/* =======================================
   PREMIUM CHAPTER SYSTEM
======================================= */
function unlock_chapter($user_id, $chapter_id, $coin_price) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['coins'] >= $coin_price) {
        $upd = $conn->prepare("UPDATE users SET coins = coins - :coin_price WHERE id = :user_id");
        $upd->execute(['coin_price' => $coin_price, 'user_id' => $user_id]);

        $ins = $conn->prepare("INSERT INTO unlocked_chapters (user_id, chapter_id) VALUES (:user_id, :chapter_id)");
        $ins->execute(['user_id' => $user_id, 'chapter_id' => $chapter_id]);

        return true;
    } else {
        return false;
    }
}

/* =======================================
   ADS REWARD
======================================= */
function reward_ad($user_id) {
    add_coins($user_id, 10);
    notify($user_id, "You earned 10 coins from ad rewards!");
}

/* =======================================
   COMMENTS SYSTEM
======================================= */
function add_comment($user_id, $story_id, $comment) {
    global $conn;
    $comment = clean($comment);
    
    $stmt = $conn->prepare("INSERT INTO comments (user_id, story_id, comment) VALUES (:user_id, :story_id, :comment)");
    $stmt->execute(['user_id' => $user_id, 'story_id' => $story_id, 'comment' => $comment]);
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

function revise_contract($contract_id, $note) {
    global $conn;
    $note = clean($note);
    $stmt = $conn->prepare("UPDATE contracts SET status = 'Needs Revision', revision_note = :note WHERE id = :contract_id");
    $stmt->execute(['note' => $note, 'contract_id' => $contract_id]);
}
?>