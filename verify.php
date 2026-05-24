<?php

include 'config.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    mysqli_query(

        $conn,

        "UPDATE users

        SET verified = 1

        WHERE id='$id'"

    );

    echo "

    <h1>
    Account Verified Successfully
    </h1>

    <a href='login.php'>
    Login Now
    </a>

    ";
}
?>