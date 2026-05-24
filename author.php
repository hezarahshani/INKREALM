<?php

session_start();

include 'config.php';
/* FOLLOW SYSTEM */

if(isset($_GET['follow'])){

    if(isset($_SESSION['user_id'])){

        $follower_id = $_SESSION['user_id'];

        $following_id = $_GET['follow'];

        if($follower_id != $following_id){

            $check_follow = mysqli_query(

                $conn,

                "SELECT * FROM followers

                WHERE follower_id='$follower_id'

                AND following_id='$following_id'"

            );

            if(mysqli_num_rows($check_follow) == 0){

                mysqli_query(

                    $conn,

                    "INSERT INTO followers
                    mysqli_query(

    $conn,

    "INSERT INTO notifications
    (user_id, message)

    VALUES

    ('$following_id',
    'You gained a new follower.')"

);
                    (follower_id, following_id)

                    VALUES

                    ('$follower_id','$following_id')"

                );
            }
        }

        header("Location: author.php?id=".$following_id);
        exit();
    }
}

$author_id = $_GET['id'];

$user = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$author_id'"
);

$user_data = mysqli_fetch_assoc($user);
/* FOLLOW COUNT */

$followers = mysqli_num_rows(

    mysqli_query(

        $conn,

        "SELECT * FROM followers
        WHERE following_id='$author_id'"

    )

);
$stories = mysqli_query(
    $conn,
    "SELECT * FROM stories
    WHERE user_id='$author_id'"
);

?>

<!DOCTYPE html>
<html>

<head>

<title>

<?php echo $user_data['username']; ?>

</title>

<style>

body{
    background:#050816;
    color:white;
    font-family:Poppins,sans-serif;
}

.container{
    width:900px;
    margin:auto;
    padding:50px 0;
}

.profile{

    background:#111827;

    padding:40px;

    border-radius:20px;

    margin-bottom:40px;
}

.profile h1{
    margin-bottom:15px;
}

.story{

    background:#111827;

    padding:25px;

    border-radius:20px;

    margin-bottom:25px;
}

.cover{

    width:100%;

    height:250px;

    object-fit:cover;

    border-radius:15px;

    margin-bottom:15px;
}

a{
    color:#ff7b29;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="container">

<div class="profile">

<h1>

<?php echo $user_data['username']; ?>

</h1>

<p>

<?php echo $user_data['bio']; ?>
<br>

<p style="margin-bottom:20px;">

👥 Followers:
<?php echo $followers; ?>

</p>

<?php if(isset($_SESSION['user_id'])){ ?>

<a

href="author.php?id=<?php echo $author_id; ?>&follow=<?php echo $author_id; ?>"

style="
display:inline-block;
padding:12px 20px;
background:#ff7b29;
color:white;
text-decoration:none;
border-radius:10px;
">

Follow Author

</a>

<?php } ?>
</p>

</div>

<h2 style="margin-bottom:30px;">
Published Stories
</h2>

<?php while($story = mysqli_fetch_assoc($stories)){ ?>

<div class="story">

<?php if(!empty($story['cover'])){ ?>

<img
class="cover"
src="uploads/<?php echo $story['cover']; ?>">

<?php } ?>

<h2>

<?php echo $story['title']; ?>

</h2>

<p>

<?php echo $story['description']; ?>

</p>

<br>

<a href="read_story.php?id=<?php echo $story['id']; ?>">

Read Story

</a>

</div>

<?php } ?>

</div>

</body>

</html>