<?php

/* =======================================
   INKREALM FINAL CONFIG
======================================= */

/* DATABASE */

$host = "localhost";

$user = "root";

$password = "";

$database = "inkrealm";

/* CONNECT DATABASE */

$conn = mysqli_connect(

    $host,
    $user,
    $password,
    $database
);

/* CHECK CONNECTION */

if(!$conn){

    die(

        "Database Connection Failed: "

        . mysqli_connect_error()
    );
}

/* START SESSION */

if(session_status() == PHP_SESSION_NONE){

    session_start();
}

/* =======================================
   SECURITY
======================================= */

/* PREVENT SQL INJECTION */

function clean($data){

global $conn;

return mysqli_real_escape_string(
$conn,
trim($data)
);
}

/* ESCAPE HTML */

function safe($text){

return htmlspecialchars(
$text,
ENT_QUOTES,
'UTF-8'
);
}

/* =======================================
   SITE SETTINGS
======================================= */

$site_name =
"INKREALM";

$site_url =
"http://localhost/INKREALM";

/* =======================================
   ADMIN SETTINGS
======================================= */

$admin_username =
"YOUR_USERNAME";

/* =======================================
   AUTH CHECK
======================================= */

function check_login(){

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}
}

/* =======================================
   ADMIN CHECK
======================================= */

function check_admin(){

global $admin_username;

if(
!isset($_SESSION['username'])
||

$_SESSION['username']
!=
$admin_username
){

die("Access Denied");
}
}

/* =======================================
   COINS SYSTEM
======================================= */

function add_coins($user_id,$amount){

global $conn;

mysqli_query(

$conn,

"UPDATE users

SET coins = coins + $amount

WHERE id='$user_id'"
);
}

/* =======================================
   NOTIFICATIONS
======================================= */

function notify(
$user_id,
$message
){

global $conn;

/* CREATE TABLE IF NOT EXISTS */

mysqli_query(

$conn,

"CREATE TABLE IF NOT EXISTS notifications (

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT NOT NULL,

message LONGTEXT,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)"
);

$message =
clean($message);

mysqli_query(

$conn,

"INSERT INTO notifications

(user_id,message)

VALUES

('$user_id','$message')"
);
}

/* =======================================
   FOLLOW SYSTEM
======================================= */

function follow_author(
$follower,
$following
){

global $conn;

$check = mysqli_query(

$conn,

"SELECT *

FROM followers

WHERE follower_id='$follower'

AND following_id='$following'"
);

if(mysqli_num_rows($check) == 0){

mysqli_query(

$conn,

"INSERT INTO followers

(follower_id,following_id)

VALUES

('$follower','$following')"
);
}
}

/* =======================================
   PREMIUM CHAPTER SYSTEM
======================================= */

function unlock_chapter(
$user_id,
$chapter_id,
$coin_price
){

global $conn;

$user = mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT *

FROM users

WHERE id='$user_id'"
)
);

if($user['coins'] >= $coin_price){

mysqli_query(

$conn,

"UPDATE users

SET coins = coins - $coin_price

WHERE id='$user_id'"
);

mysqli_query(

$conn,

"INSERT INTO unlocked_chapters

(user_id,chapter_id)

VALUES

('$user_id','$chapter_id')"
);

return true;

}else{

return false;
}
}

/* =======================================
   ADS REWARD
======================================= */

function reward_ad($user_id){

add_coins($user_id,10);

notify(
$user_id,
"You earned 10 coins from ad rewards!"
);
}

/* =======================================
   COMMENTS SYSTEM
======================================= */

function add_comment(
$user_id,
$story_id,
$comment
){

global $conn;

$comment =
clean($comment);

mysqli_query(

$conn,

"INSERT INTO comments

(user_id,story_id,comment)

VALUES

('$user_id','$story_id','$comment')"
);
}

/* =======================================
   CONTRACT SYSTEM
======================================= */

function approve_contract(
$contract_id,
$type,
$send_to
){

global $conn;

mysqli_query(

$conn,

"UPDATE contracts

SET

status='Approved',

contract_type='$type',

send_to='$send_to'

WHERE id='$contract_id'"
);
}

function reject_contract(
$contract_id,
$reason
){

global $conn;

$reason =
clean($reason);

mysqli_query(

$conn,

"UPDATE contracts

SET

status='Rejected',

reason='$reason'

WHERE id='$contract_id'"
);
}

function revise_contract(
$contract_id,
$note
){

global $conn;

$note =
clean($note);

mysqli_query(

$conn,

"UPDATE contracts

SET

status='Needs Revision',

revision_note='$note'

WHERE id='$contract_id'"
);
}

?>