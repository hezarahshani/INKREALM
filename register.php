<?php

include 'config.php';

$message = "";

if(isset($_POST['register'])){

    $username =
    mysqli_real_escape_string(
    $conn,
    $_POST['username']
    );

    $email =
    mysqli_real_escape_string(
    $conn,
    $_POST['email']
    );

    $password =
    password_hash(
    $_POST['password'],
    PASSWORD_DEFAULT
    );

    $check = mysqli_query(

        $conn,

        "SELECT * FROM users
        WHERE email='$email'"
    );

    if(mysqli_num_rows($check) > 0){

        $message =
        "Email already exists.";

    }else{

        mysqli_query(

            $conn,

            "INSERT INTO users

            (username,email,password)

            VALUES

            ('$username','$email','$password')"
        );

        $message =
        "Registration successful.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Register</title>

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

    width:400px;

    background:#111827;

    padding:40px;

    border-radius:20px;
}

input{

    width:100%;

    padding:15px;

    margin-top:15px;

    border:none;

    border-radius:10px;

    background:#1f2937;

    color:white;
}

button{

    width:100%;

    padding:15px;

    margin-top:20px;

    border:none;

    border-radius:10px;

    background:#ff7b29;

    color:white;

    cursor:pointer;
}

.message{

    background:#16a34a;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;
}

a{

    color:#ff7b29;

    text-decoration:none;
}

</style>

</head>

<body>

<div class="box">

<h1>
Register
</h1>

<?php if($message != ""){ ?>

<div class="message">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="email"
name="email"
placeholder="Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button
type="submit"
name="register">

Register

</button>

</form>

<p style="margin-top:20px;">

Already have account?

<a href="login.php">

Login

</a>

</p>

</div>

</body>

</html>