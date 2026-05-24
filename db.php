<?php

$host = getenv("dpg-d896qamgvqtc73bmjikg-a");
$dbname = getenv("inkrealm");
$username = getenv("inkrealm_user");
$password = getenv("Z6qURzQfsxbUvW0uRQWOEQplmlPv9y5S");

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

    die("Database Connection Failed: " . $e->getMessage());

}
?>