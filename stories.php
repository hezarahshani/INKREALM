<?php

include 'config.php';

if(session_status() == PHP_SESSION_NONE){

session_start();
}

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}

$user_id =
$_SESSION['user_id'];

$user =
mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT * FROM users

WHERE id='$user_id'"
)
);

/* STORIES */

$stories = mysqli_query(

$conn,

"SELECT * FROM stories

ORDER BY rank_score DESC,
views DESC"
);

/* COMMENTS */

if(isset($_POST['comment_submit'])){

$story_id =
$_POST['story_id'];

$comment =
mysqli_real_escape_string(
$conn,
$_POST['comment']
);

mysqli_query(

$conn,

"INSERT INTO comments

(user_id,story_id,comment)

VALUES

('$user_id','$story_id','$comment')"
);
}

/* DAILY ADS REWARD */

if(isset($_POST['watch_ad'])){

mysqli_query(

$conn,

"UPDATE users

SET coins = coins + 10

WHERE id='$user_id'"
);

header("Location: stories.php");

exit();
}

?>

<!DOCTYPE html>
<html>

<head>

<title>

INKREALM

</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<style>

*{

margin:0;
padding:0;
box-sizing:border-box;
}

body{

background:#050816;

color:white;

font-family:Poppins,sans-serif;

padding-bottom:120px;
}

/* TOPBAR */

.topbar{

height:85px;

background:#111827;

display:flex;

justify-content:space-between;

align-items:center;

padding:0 25px;

position:sticky;

top:0;

z-index:999;
}

.logo{

font-size:34px;

font-weight:800;

color:#ff7b29;
}

.coins{

background:#ff7b29;

padding:12px 20px;

border-radius:14px;

font-weight:700;
}

/* HERO */

.hero{

padding:30px;
}

.hero-box{

background:
linear-gradient(
135deg,
#ff7b29,
#ff9b5c
);

padding:40px;

border-radius:30px;
}

.hero-box h1{

font-size:45px;

margin-bottom:15px;
}

.hero-box p{

line-height:1.8;
}

/* BUTTONS */

.actions{

display:flex;

gap:15px;

flex-wrap:wrap;

margin-top:25px;
}

.actions form,
.actions a{

flex:1;
}

.actions button,
.actions a{

display:block;

width:100%;

padding:16px;

border:none;

border-radius:14px;

text-align:center;

text-decoration:none;

font-weight:700;

cursor:pointer;
}

.ad-btn{

background:#111827;

color:white;
}

.buy-btn{

background:white;

color:#ff7b29;
}

/* STORIES */

.section{

padding:30px;
}

.section h2{

font-size:36px;

margin-bottom:30px;

color:#ff7b29;
}

.story-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(280px,1fr));

gap:30px;
}

.story-card{

background:#111827;

border-radius:25px;

overflow:hidden;

transition:0.4s;
}

.story-card:hover{

transform:
translateY(-10px);

box-shadow:
0 20px 40px
rgba(255,123,41,0.25);
}

.story-card img{

width:100%;

height:350px;

object-fit:cover;
}

.story-content{

padding:25px;
}

.story-content h3{

font-size:28px;

margin-bottom:10px;
}

.story-content p{

color:#9ca3af;

line-height:1.8;

margin-bottom:20px;
}

.story-content a{

display:block;

padding:14px;

text-align:center;

background:#ff7b29;

border-radius:14px;

color:white;

text-decoration:none;

font-weight:700;
}

/* COMMENTS */

.comment-box{

margin-top:25px;
}

.comment-box textarea{

width:100%;

padding:14px;

border:none;

border-radius:12px;

background:#1f2937;

color:white;

margin-bottom:15px;
}

.comment-box button{

width:100%;

padding:14px;

border:none;

border-radius:12px;

background:#ff7b29;

color:white;

font-weight:700;

cursor:pointer;
}

/* PAYMENT */

.payment{

background:#111827;

padding:30px;

border-radius:25px;

margin-top:40px;
}

.payment h2{

margin-bottom:20px;

color:#ff7b29;
}

.pay-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(220px,1fr));

gap:20px;
}

.pay-card{

background:#1f2937;

padding:25px;

border-radius:18px;

text-align:center;
}

.pay-card h3{

margin-bottom:12px;
}

.pay-card button{

margin-top:15px;

padding:12px 24px;

border:none;

background:#ff7b29;

color:white;

border-radius:12px;

cursor:pointer;
}

/* NOTIFICATIONS */

.notice{

background:#111827;

padding:25px;

border-radius:20px;

margin-top:40px;
}

.notice h2{

color:#ff7b29;

margin-bottom:20px;
}

.notice p{

margin-bottom:12px;

color:#d1d5db;
}

/* BOTTOM NAV */

.bottom-nav{

position:fixed;

bottom:0;

left:0;

width:100%;

height:80px;

background:#111827;

display:flex;

justify-content:space-around;

align-items:center;

border-top:
1px solid rgba(255,255,255,0.05);
}

.bottom-nav a{

color:white;

text-decoration:none;

font-size:14px;

text-align:center;
}

.bottom-nav a span{

display:block;

font-size:24px;

margin-bottom:5px;
}

</style>

</head>

<body>

<div class="topbar">

<div class="logo">

INKREALM

</div>

<div class="coins">

💰 <?php echo $user['coins']; ?>

</div>

</div>

<div class="hero">

<div class="hero-box">

<h1>

Welcome Back,
<?php echo $user['username']; ?> 🔥

</h1>

<p>

Read premium novels,
support authors,
unlock chapters,
and grow your fandom.

</p>

<div class="actions">

<form method="POST">

<button
type="submit"
name="watch_ad"
class="ad-btn">

🎥 Watch Ad +10 Coins

</button>

</form>

<a
href="#payment"
class="buy-btn">

💳 Buy Coins

</a>

</div>

</div>

</div>

<div class="section">

<h2>

🔥 Trending Stories

</h2>

<div class="story-grid">

<?php while($story =
mysqli_fetch_assoc($stories)){ ?>

<div class="story-card">

<img
src="uploads/<?php echo $story['cover']; ?>">

<div class="story-content">

<h3>

<?php echo $story['title']; ?>

</h3>

<p>

<?php echo substr(
$story['description'],
0,
120
); ?>...

</p>

<a
href="read_story.php?id=<?php echo $story['id']; ?>">

Read Story

</a>

<div class="comment-box">

<form method="POST">

<input
type="hidden"
name="story_id"
value="<?php echo $story['id']; ?>">

<textarea
name="comment"
placeholder="Write comment..."></textarea>

<button
type="submit"
name="comment_submit">

Post Comment

</button>

</form>

</div>

</div>

</div>

<?php } ?>

</div>

<div
class="payment"
id="payment">

<h2>

💳 Coin Recharge

</h2>

<div class="pay-grid">

<div class="pay-card">

<h3>

PayPal

</h3>

<p>

Recharge coins using PayPal.

</p>

<button>

Connect

</button>

</div>

<div class="pay-card">

<h3>

Payoneer

</h3>

<p>

Withdraw author earnings.

</p>

<button>

Connect

</button>

</div>

<div class="pay-card">

<h3>

Bank Transfer

</h3>

<p>

Cash out directly to bank.

</p>

<button>

Setup

</button>

</div>

</div>

</div>

<div class="notice">

<h2>

🔔 Notifications

</h2>

<p>

🎉 Welcome to INKREALM.

</p>

<p>

🔥 Premium system activated.

</p>

<p>

📚 Authors can now apply for contracts.

</p>

</div>

</div>

<div class="bottom-nav">

<a href="stories.php">

<span>

🏠

</span>

Home

</a>

<a href="upload.php">

<span>

✍️

</span>

Upload

</a>

<a href="notifications.php">

<span>

🔔

</span>

Alerts

</a>

<a href="author_dashboard.php">

<span>

📊

</span>

Dashboard

</a>

<a href="author_profile.php?id=<?php echo $user_id; ?>">

<span>

👤

</span>

Profile

</a>

</div>

</body>

</html>