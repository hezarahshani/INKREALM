<?php

session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

$library = mysqli_query(

    $conn,

    "SELECT stories.*

    FROM library

    JOIN stories

    ON library.story_id = stories.id

    WHERE library.user_id='$user_id'"

);

?>

<!DOCTYPE html>
<html>

<head>

<title>My Library</title>

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

<h1 style="margin-bottom:40px;">
📚 My Library
</h1>

<?php while($story = mysqli_fetch_assoc($library)){ ?>

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

Continue Reading

</a>

</div>

<?php } ?>

</div>

</body>

</html>