<?php

session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

if(isset($_POST['publish'])){

    $title = $_POST['title'];

    $description = $_POST['description'];

    $genre = $_POST['genre'];

    $user_id = $_SESSION['user_id'];

    // IMAGE

    $cover_name = $_FILES['cover']['name'];

    $tmp_name = $_FILES['cover']['tmp_name'];

    move_uploaded_file(
        $tmp_name,
        "uploads/".$cover_name
    );

   INSERT INTO stories
(title, description, category, cover, user_id)

VALUES

('$title','$description','$category','$cover','$user_id')

    mysqli_query($conn, $sql);

    echo "<h3 style='color:lime;'>Story Published Successfully!</h3>";
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Publish Story</title>

<style>

body{
    background:#050816;
    color:white;
    font-family:Poppins,sans-serif;
}

.container{
    width:500px;
    margin:auto;
    margin-top:50px;
}

form{
    background:#111827;
    padding:30px;
    border-radius:20px;
}

input, textarea, select{

    width:100%;

    padding:14px;

    margin:12px 0;

    background:#1f2937;

    border:none;

    border-radius:10px;

    color:white;
}

textarea{
    height:180px;
}

button{

    width:100%;

    padding:15px;

    background:#ff7b29;

    border:none;

    color:white;

    border-radius:10px;

    font-size:17px;
}

h1{
    text-align:center;
}

</style>

</head>

<body>

<div class="container">

<h1>Publish Story</h1>

<form method="POST" enctype="multipart/form-data">

<input
type="text"
name="title"
placeholder="Story Title"
required>

<textarea
name="description"
placeholder="Story Description"
required></textarea>

<select name="genre">

<option>Romance</option>

<option>Fantasy</option>

<option>Werewolf</option>

<option>Billionaire</option>

<option>Dark Romance</option>

</select>

<input
type="file"
name="cover"
required>

<button
type="submit"
name="publish">

Publish Story

</button>

</form>

</div>

</body>

</html>