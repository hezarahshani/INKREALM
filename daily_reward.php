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

$message = "";

/* CHECK USER REWARD */

$check = mysqli_query(

    $conn,

    "SELECT * FROM daily_rewards

    WHERE user_id='$user_id'"
);

if(mysqli_num_rows($check) == 0){

    mysqli_query(

        $conn,

        "INSERT INTO daily_rewards

        (user_id,last_claim,streak)

        VALUES

        ('$user_id',NULL,0)"
    );
}

$data = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "SELECT * FROM daily_rewards

        WHERE user_id='$user_id'"
    )
);

$today = date("Y-m-d");

/* CLAIM */

if(isset($_POST['claim'])){

    if($data['last_claim'] != $today){

        $streak = $data['streak'] + 1;

        $reward = 10;

        /* BONUS */

        if($streak % 7 == 0){

            $reward = 50;
        }

        mysqli_query(

            $conn,

            "UPDATE users

            SET coins = coins + $reward

            WHERE id='$user_id'"
        );

        mysqli_query(

            $conn,

            "UPDATE daily_rewards

            SET

            last_claim='$today',

            streak='$streak'

            WHERE user_id='$user_id'"
        );

        $message =
        "You claimed $reward coins!";
    }

    else{

        $message =
        "You already claimed today.";
    }
}

/* USER COINS */

$user = mysqli_fetch_assoc(

    mysqli_query(

        $conn,

        "SELECT * FROM users

        WHERE id='$user_id'"
    )
);

?>

<!DOCTYPE html>
<html>

<head>

<title>Daily Reward</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{

    background:#050816;

    color:white;

    font-family:Poppins,sans-serif;

    display:flex;

    justify-content:center;

    align-items:center;

    height:100vh;
}

.box{

    width:420px;

    background:#111827;

    padding:40px;

    border-radius:30px;

    text-align:center;
}

h1{

    color:#ff7b29;

    margin-bottom:20px;
}

.coins{

    font-size:22px;

    margin-bottom:25px;
}

.streak{

    font-size:18px;

    color:#d1d5db;

    margin-bottom:30px;
}

button{

    width:100%;

    padding:18px;

    border:none;

    border-radius:15px;

    background:#ff7b29;

    color:white;

    font-size:18px;

    cursor:pointer;

    transition:0.3s;
}

button:hover{

    transform:translateY(-3px);
}

.message{

    background:#1f2937;

    padding:15px;

    border-radius:12px;

    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="box">

<h1>

🎁 Daily Reward

</h1>

<div class="coins">

💰 Coins:
<b>

<?php echo $user['coins']; ?>

</b>

</div>

<div class="streak">

🔥 Streak:
<b>

<?php echo $data['streak']; ?>

days

</b>

</div>

<?php if($message != ""){ ?>

<div class="message">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<button
type="submit"
name="claim">

Claim Daily Coins

</button>

</form>

</div>

</body>

</html>