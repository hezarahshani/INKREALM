<?php

include 'config.php';

$message = "";

if(isset($_POST['login'])){

    $email =
    mysqli_real_escape_string(
    $conn,
    $_POST['email']
    );

    $password =
    $_POST['password'];

    $query = mysqli_query(

        $conn,

        "SELECT * FROM users
        WHERE email='$email'"
    );

    if(mysqli_num_rows($query) > 0){

        $user =
        mysqli_fetch_assoc($query);

        if(password_verify(
            $password,
            $user['password']
        )){

            $_SESSION['user_id'] =
            $user['id'];

            header("Location: stories.php");
            exit();

        }else{

            $message =
            "Invalid password.";
        }

    }else{

        $message =
        "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login</title>

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

    background:#dc2626;

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
Login
</h1>

<?php if($message != ""){ ?>

<div class="message">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

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
name="login">

Login

</button>

</form>

<p style="margin-top:20px;">

No account?

<a href="register.php">

Register

</a>

</p>

</div>

</body>

</html>