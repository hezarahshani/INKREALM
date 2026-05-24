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

$message = "";

if(isset($_POST['submit'])){

    $story_title =
    mysqli_real_escape_string(
        $conn,
        $_POST['story_title']
    );

    $email =
    mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $synopsis =
    mysqli_real_escape_string(
        $conn,
        $_POST['synopsis']
    );

    $contract_text =
    mysqli_real_escape_string(
        $conn,
        $_POST['contract_text']
    );

    mysqli_query(

        $conn,

        "INSERT INTO contracts

        (

        user_id,
        story_title,
        email,
        synopsis,
        contract_text,
        status

        )

        VALUES

        (

        '$user_id',

        '$story_title',

        '$email',

        '$synopsis',

        '$contract_text',

        'Pending Review'

        )"
    );

    $message =
    "Contract submitted successfully!";
}

?>

<!DOCTYPE html>
<html>

<head>

<title>

Submit Contract

</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

body{

    background:#050816;

    color:white;

    font-family:Poppins,sans-serif;

    padding:50px;
}

.box{

    background:#111827;

    max-width:800px;

    margin:auto;

    padding:40px;

    border-radius:25px;
}

h1{

    color:#ff7b29;

    margin-bottom:30px;

    font-size:42px;
}

input,
textarea{

    width:100%;

    padding:16px;

    margin-bottom:20px;

    border:none;

    border-radius:14px;

    background:#1f2937;

    color:white;

    font-size:15px;
}

textarea{

    min-height:160px;

    resize:none;
}

button{

    width:100%;

    padding:16px;

    border:none;

    border-radius:14px;

    background:#ff7b29;

    color:white;

    font-size:17px;

    font-weight:700;

    cursor:pointer;
}

.message{

    background:#16a34a;

    padding:14px;

    border-radius:12px;

    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="box">

<h1>

📄 Submit Contract

</h1>

<?php if($message != ""){ ?>

<div class="message">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="story_title"
placeholder="Story Title"
required>

<input
type="email"
name="email"
placeholder="Your Email"
required>

<textarea
name="synopsis"
placeholder="Write your story synopsis..."
required></textarea>

<textarea
name="contract_text"
placeholder="Write your full contract request here..."
required></textarea>

<button
type="submit"
name="submit">

Submit to Senior Editor

</button>

</form>

</div>

</body>

</html>