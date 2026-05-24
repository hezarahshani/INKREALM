<?php

include 'config.php';

if(session_status() == PHP_SESSION_NONE){

    session_start();
}

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

$current_user =
$_SESSION['user_id'];

$author_id =
$_GET['id'];

/* AUTHOR */

$author = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "SELECT * FROM users

        WHERE id='$author_id'"
    )
);

/* FOLLOW */

if(isset($_POST['follow'])){

    $check = mysqli_query(

        $conn,

        "SELECT *

        FROM followers

        WHERE follower_id='$current_user'

        AND following_id='$author_id'"
    );

    if(mysqli_num_rows($check) == 0){

        mysqli_query(

            $conn,

            "INSERT INTO followers

            (follower_id,following_id)

            VALUES

            ('$current_user','$author_id')"
        );
    }

    header("Location: author_profile.php?id=".$author_id);

    exit();
}

/* UNFOLLOW */

if(isset($_POST['unfollow'])){

    mysqli_query(

        $conn,

        "DELETE FROM followers

        WHERE follower_id='$current_user'

        AND following_id='$author_id'"
    );

    header("Location: author_profile.php?id=".$author_id);

    exit();
}

/* CHECK FOLLOW */

$check_follow = mysqli_query(

    $conn,

    "SELECT *

    FROM followers

    WHERE follower_id='$current_user'

    AND following_id='$author_id'"
);

$is_following =
mysqli_num_rows($check_follow) > 0;

/* FOLLOWERS */

$followers = mysqli_query(

    $conn,

    "SELECT *

    FROM followers

    WHERE following_id='$author_id'"
);

$total_followers =
mysqli_num_rows($followers);

/* STORIES */

$stories = mysqli_query(

    $conn,

    "SELECT *

    FROM stories

    WHERE user_id='$author_id'

    ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

<title>

<?php echo $author['username']; ?>

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

/* PROFILE */

.profile{

    padding:70px;

    background:#111827;

    display:flex;

    gap:50px;

    align-items:center;

    flex-wrap:wrap;
}

.profile img{

    width:180px;

    height:180px;

    border-radius:50%;

    object-fit:cover;

    border:5px solid #ff7b29;
}

.profile-info{

    flex:1;
}

.profile-info h1{

    font-size:55px;

    margin-bottom:15px;

    color:#ff7b29;
}

.bio{

    color:#d1d5db;

    line-height:1.9;

    margin-bottom:25px;

    max-width:800px;
}

.followers{

    font-size:20px;

    margin-bottom:25px;

    color:#ffb37a;
}

.follow-btn{

    padding:15px 35px;

    border:none;

    border-radius:14px;

    font-size:16px;

    cursor:pointer;

    transition:0.3s;

    font-weight:600;
}

.follow{

    background:#ff7b29;

    color:white;
}

.follow:hover{

    transform:scale(1.05);
}

.following{

    background:#16a34a;

    color:white;
}

/* SOCIALS */

.socials{

    display:flex;

    gap:20px;

    margin-top:30px;

    flex-wrap:wrap;
}

.socials a{

    text-decoration:none;

    color:white;

    background:#ff7b29;

    padding:12px 24px;

    border-radius:12px;

    transition:0.3s;
}

.socials a:hover{

    transform:translateY(-3px);
}

/* STORIES */

.section{

    padding:60px;
}

.section h2{

    font-size:42px;

    margin-bottom:40px;

    color:#ff7b29;
}

.story-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(280px,1fr));

    gap:35px;
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

    margin-bottom:15px;
}

.story-content p{

    color:#9ca3af;

    line-height:1.8;

    margin-bottom:25px;
}

.story-content a{

    display:block;

    text-align:center;

    padding:14px;

    background:#ff7b29;

    color:white;

    text-decoration:none;

    border-radius:14px;

    font-weight:600;
}

/* MOBILE */

@media(max-width:900px){

.profile{

    padding:40px 20px;
}

.section{

    padding:30px 20px;
}

.profile-info h1{

    font-size:42px;
}
}

</style>

</head>

<body>

<div class="profile">

<img
src="uploads/<?php echo $author['profile_pic']; ?>">

<div class="profile-info">

<h1>

<?php echo $author['username']; ?>

</h1>

<p class="bio">

<?php

if($author['bio']){

    echo $author['bio'];

}else{

    echo "This author has not added a bio yet.";
}

?>

</p>

<div class="followers">

👥 Followers:
<b>

<?php echo $total_followers; ?>

</b>

</div>

<?php if($current_user != $author_id){ ?>

<?php if(!$is_following){ ?>

<form method="POST">

<button
type="submit"
name="follow"
class="follow-btn follow">

➕ Follow Author

</button>

</form>

<?php } else { ?>

<form method="POST">

<button
type="submit"
name="unfollow"
class="follow-btn following">

✓ Following

</button>

</form>

<?php } ?>

<?php } ?>

<div class="socials">

<?php if($author['facebook']){ ?>

<a
href="<?php echo $author['facebook']; ?>"
target="_blank">

Facebook

</a>

<?php } ?>

<?php if($author['instagram']){ ?>

<a
href="<?php echo $author['instagram']; ?>"
target="_blank">

Instagram

</a>

<?php } ?>

</div>

</div>

</div>

<div class="section">

<h2>

📚 Stories by
<?php echo $author['username']; ?>

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

</div>

</div>

<?php } ?>

</div>

</div>

</body>

</html>