<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>

<head>
<title>Dashboard</title>
</head>

<body style="background:#070b14;color:white;font-family:Arial;text-align:center;">

<h1>Welcome to INKREALM</h1>

<h2>
Hello, <?php echo $_SESSION['username']; ?>
</h2>

<p>
You are now logged in.
</p>

</body>

</html>