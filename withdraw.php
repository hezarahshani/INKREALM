<?php

session_start();

include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['withdraw'])){

    $method = $_POST['method'];

    $account = mysqli_real_escape_string(
        $conn,
        $_POST['account']
    );

    $amount = $_POST['amount'];

    mysqli_query(

        $conn,

        "INSERT INTO withdrawals
        (user_id, method, account_details, amount)

        VALUES

        ('$user_id','$method','$account','$amount')"

    );

    $success = "Withdrawal request submitted.";
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Withdraw Earnings</title>

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
}

input, select{

    width:100%;

    padding:15px;

    margin-bottom:20px;

    border:none;

    border-radius:10px;

    background:#1f2937;

    color:white;
}

button{

    padding:15px 20px;

    background:#ff7b29;

    border:none;

    border-radius:10px;

    color:white;

    cursor:pointer;
}

.success{

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

<h1 style="margin-bottom:30px;">
💸 Withdraw Earnings
</h1>

<?php if(isset($success)){ ?>

<div class="success">

<?php echo $success; ?>

</div>

<?php } ?>

<form method="POST">

<select name="method" required>

<option value="">
Select Withdrawal Method
</option>

<option>
PayPal
</option>

<option>
Bank Transfer
</option>

<option>
Payoneer
</option>

</select>

<input
type="text"
name="account"
placeholder="Enter PayPal email / Bank Details / Payoneer email"
required>

<input
type="number"
step="0.01"
name="amount"
placeholder="Amount"
required>

<button
type="submit"
name="withdraw">

Request Withdrawal

</button>

</form>

</div>

</div>

</body>

</html>