<?php

session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* GIFTS */

$gifts = mysqli_query(

    $conn,

    "SELECT gifts.*,
    users.username

    FROM gifts

    JOIN users
    ON gifts.sender_id = users.id

    WHERE gifts.receiver_id='$user_id'

    ORDER BY gifts.id DESC"
);

/* CONTRACTS */

$contracts = mysqli_query(

    $conn,

    "SELECT *

    FROM contracts

    WHERE user_id='$user_id'

    ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

<title>Notifications</title>

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

.section{

    background:#111827;

    padding:30px;

    border-radius:20px;

    margin-bottom:30px;
}

.item{

    background:#1f2937;

    padding:20px;

    border-radius:15px;

    margin-top:20px;
}

h1{

    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="container">

<div class="section">

<h1>
🔔 Gift Notifications
</h1>

<?php

if(mysqli_num_rows($gifts) > 0){

while($gift = mysqli_fetch_assoc($gifts)){

?>

<div class="item">

<p>

🎁

<b>
<?php echo $gift['username']; ?>
</b>

sent you

<b>
<?php echo $gift['gift_name']; ?>
</b>

worth

<b>
<?php echo $gift['coins']; ?>
coins
</b>

</p>

</div>

<?php

}

}else{

echo "<p>No gift notifications yet.</p>";
}

?>

</div>

<div class="section">

<h1>
📄 Contract Notifications
</h1>

<?php

if(mysqli_num_rows($contracts) > 0){

while($contract = mysqli_fetch_assoc($contracts)){

?>

<div class="item">

<p>

Your contract request for story ID

<b>
<?php echo $contract['story_id']; ?>
</b>

is currently:

<b>
<?php echo $contract['status']; ?>
</b>

</p>

</div>

<?php

}

}else{

echo "<p>No contract notifications yet.</p>";
}

?>

</div>

</div>

</body>

</html>