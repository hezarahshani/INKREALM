<?php

session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$message = "";

if(isset($_POST['reward'])){

    /* GIVE COINS */

    mysqli_query(

        $conn,

        "UPDATE users

        SET coins = coins + 5

        WHERE id='$user_id'"
    );

    /* SAVE REWARD */

    mysqli_query(

        $conn,

        "INSERT INTO ad_rewards
        (user_id)

        VALUES

        ('$user_id')"
    );

    $message = "You earned 5 coins!";
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Watch Ads</title>

<style>

body{

    background:#050816;

    color:white;

    font-family:Poppins,sans-serif;
}

.container{

    width:700px;

    margin:auto;

    padding:50px 0;
}

.box{

    background:#111827;

    padding:40px;

    border-radius:20px;

    text-align:center;
}

.video{

    width:100%;

    height:350px;

    background:black;

    border-radius:20px;

    margin-bottom:30px;

    display:flex;

    justify-content:center;

    align-items:center;

    color:#9ca3af;

    font-size:22px;
}

button{

    padding:15px 25px;

    border:none;

    border-radius:10px;

    background:#ff7b29;

    color:white;

    font-size:18px;

    cursor:pointer;
}

.message{

    background:#16a34a;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="container">

<div class="box">

<h1>
📺 Watch Ad & Earn Coins
</h1>

<?php if($message != ""){ ?>

<div class="message">

<?php echo $message; ?>

</div>

<?php } ?>

<div class="video">

Ad Video Placeholder

</div>

<form method="POST">

<button
type="submit"
name="reward">

Claim 5 Coins

</button>

</form>

</div>

</div>

</body>

</html>