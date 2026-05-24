<?php

session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Buy Coins</title>

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

.pack{

    background:#111827;

    padding:30px;

    border-radius:20px;

    margin-bottom:25px;
}

.buy-btn{

    display:inline-block;

    margin-top:20px;

    padding:12px 20px;

    background:#ff7b29;

    color:white;

    text-decoration:none;

    border-radius:10px;
}

</style>

</head>

<body>

<div class="container">

<h1 style="margin-bottom:40px;">
💎 Buy Coins
</h1>

<div class="pack">

<h2>100 Coins</h2>

<p>$1.99</p>

<a
class="buy-btn"
href="#">

Buy Now

</a>

</div>

<div class="pack">

<h2>500 Coins</h2>

<p>$6.99</p>

<a
class="buy-btn"
href="#">

Buy Now

</a>

</div>

<div class="pack">

<h2>1000 Coins</h2>

<p>$12.99</p>

<a
class="buy-btn"
href="#">

Buy Now

</a>

</div>

</div>

</body>

</html>