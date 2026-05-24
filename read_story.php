<?php

include 'config.php';

if(session_status() == PHP_SESSION_NONE){

    session_start();
}

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$story_id = $_GET['id'];

/* STORY */

$story = mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT * FROM stories

WHERE id='$story_id'"
)
);

/* CHAPTERS */

$chapters = mysqli_query(

$conn,

"SELECT * FROM chapters

WHERE story_id='$story_id'

ORDER BY id ASC"
);

/* UNLOCK SYSTEM */

if(isset($_POST['unlock'])){

$chapter_id =
$_POST['chapter_id'];

$coin_price =
$_POST['coin_price'];

$user = mysqli_fetch_assoc(

mysqli_query(

$conn,

"SELECT * FROM users

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

header("Location: read_story.php?id=".$story_id);

exit();

}else{

echo "

<script>

alert('Not enough coins');

</script>

";
}
}

?>

<!DOCTYPE html>
<html>

<head>

<title>

<?php echo $story['title']; ?>

</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
}

/* HEADER */

.header{

padding:60px;

text-align:center;

background:#111827;
}

.header h1{

font-size:50px;

margin-bottom:20px;

color:#ff7b29;
}

.header p{

max-width:800px;

margin:auto;

line-height:1.8;

color:#d1d5db;
}

/* CHAPTERS */

.container{

padding:60px;

max-width:1100px;

margin:auto;
}

.chapter{

background:#111827;

padding:40px;

border-radius:30px;

margin-bottom:40px;

border:
1px solid rgba(255,255,255,0.05);
}

.chapter h2{

font-size:34px;

margin-bottom:25px;

color:#ff7b29;
}

.chapter p{

line-height:2;

font-size:17px;

color:#e5e7eb;
}

/* PREMIUM */

.premium-lock{

text-align:center;

padding:50px;

background:
linear-gradient(
135deg,
#ff7b29,
#ff9b5c
);

border-radius:25px;
}

.premium-lock h3{

font-size:34px;

margin-bottom:20px;
}

.premium-lock p{

margin-bottom:30px;

font-size:20px;
}

.premium-lock button{

padding:16px 40px;

border:none;

background:#111827;

color:white;

font-size:18px;

border-radius:14px;

cursor:pointer;

transition:0.3s;
}

.premium-lock button:hover{

transform:scale(1.05);
}

/* BACK BUTTON */

.back{

display:inline-block;

margin-top:20px;

color:#ff7b29;

text-decoration:none;

font-weight:600;
}

</style>

</head>

<body>

<div class="header">

<h1>

<?php echo $story['title']; ?>

</h1>

<p>

<?php echo $story['description']; ?>

</p>

<a
href="stories.php"
class="back">

← Back to Stories

</a>

</div>

<div class="container">

<?php

while($chapter =
mysqli_fetch_assoc($chapters)){

$chapter_id =
$chapter['id'];

$unlocked = mysqli_query(

$conn,

"SELECT * FROM unlocked_chapters

WHERE user_id='$user_id'

AND chapter_id='$chapter_id'"
);

$is_unlocked =
mysqli_num_rows($unlocked) > 0;

?>

<div class="chapter">

<h2>

<?php echo $chapter['title']; ?>

</h2>

<?php if(
$chapter['is_premium'] == 1
&& !$is_unlocked
){ ?>

<div class="premium-lock">

<h3>

🔒 Premium Chapter

</h3>

<p>

Unlock for
<?php echo $chapter['coin_price']; ?>
coins

</p>

<form method="POST">

<input
type="hidden"
name="chapter_id"
value="<?php echo $chapter_id; ?>">

<input
type="hidden"
name="coin_price"
value="<?php echo $chapter['coin_price']; ?>">

<button
type="submit"
name="unlock">

Unlock Chapter

</button>

</form>

</div>

<?php } else { ?>

<p>

<?php echo nl2br($chapter['content']); ?>

</p>

<?php } ?>

</div>

<?php } ?>

</div>

</body>

</html>
