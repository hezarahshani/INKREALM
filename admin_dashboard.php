<?php

include 'config.php';

if(session_status() == PHP_SESSION_NONE){

    session_start();
}

/* CHANGE THIS TO YOUR ADMIN USERNAME */

$senior_editor =
"Audrey Liu";

/* CONTRACT ACTIONS */

if(isset($_POST['approve'])){

    $contract_id =
    $_POST['contract_id'];

    $contract_type =
    $_POST['contract_type'];

    $send_to =
    $_POST['send_to'];

    mysqli_query(

        $conn,

        "UPDATE contracts

        SET

        status='Approved',

        contract_type='$contract_type',

        send_to='$send_to'

        WHERE id='$contract_id'"
    );
}

if(isset($_POST['reject'])){

    $contract_id =
    $_POST['contract_id'];

    $reason =
    mysqli_real_escape_string(
        $conn,
        $_POST['reason']
    );

    mysqli_query(

        $conn,

        "UPDATE contracts

        SET

        status='Rejected',

        reason='$reason'

        WHERE id='$contract_id'"
    );
}

if(isset($_POST['revise'])){

    $contract_id =
    $_POST['contract_id'];

    $revision =
    mysqli_real_escape_string(
        $conn,
        $_POST['revision']
    );

    mysqli_query(

        $conn,

        "UPDATE contracts

        SET

        status='Needs Revision',

        revision_note='$revision'

        WHERE id='$contract_id'"
    );
}

/* CONTRACTS */

$contracts = mysqli_query(

    $conn,

    "SELECT contracts.*,
    users.username

    FROM contracts

    JOIN users

    ON contracts.user_id = users.id

    ORDER BY contracts.id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

<title>

Senior Editor Dashboard

</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{

    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:#050816;

    color:white;

    font-family:Poppins,sans-serif;

    padding:50px;
}

.header{

    margin-bottom:50px;
}

.header h1{

    font-size:52px;

    color:#ff7b29;

    margin-bottom:10px;
}

.header p{

    color:#d1d5db;

    font-size:18px;
}

/* CONTRACT CARD */

.contract{

    background:#111827;

    padding:35px;

    border-radius:28px;

    margin-bottom:40px;

    border:
    1px solid rgba(255,255,255,0.05);
}

.contract h2{

    font-size:32px;

    margin-bottom:20px;

    color:#ff7b29;
}

.contract p{

    margin-bottom:14px;

    color:#d1d5db;

    line-height:1.8;
}

.status{

    display:inline-block;

    padding:10px 18px;

    border-radius:12px;

    background:#1f2937;

    margin-bottom:25px;

    font-weight:600;
}

/* FORM */

label{

    display:block;

    margin-bottom:10px;

    margin-top:20px;

    color:#ffb37a;
}

select,
textarea,
input{

    width:100%;

    padding:16px;

    border:none;

    border-radius:14px;

    background:#1f2937;

    color:white;

    font-size:15px;
}

textarea{

    min-height:120px;

    resize:none;
}

/* BUTTONS */

.buttons{

    display:flex;

    gap:15px;

    flex-wrap:wrap;

    margin-top:30px;
}

button{

    padding:14px 28px;

    border:none;

    border-radius:14px;

    cursor:pointer;

    font-size:15px;

    font-weight:600;

    transition:0.3s;
}

.approve{

    background:#16a34a;

    color:white;
}

.reject{

    background:#dc2626;

    color:white;
}

.revise{

    background:#f59e0b;

    color:white;
}

button:hover{

    transform:translateY(-3px);
}

/* MOBILE */

@media(max-width:900px){

body{

    padding:20px;
}

.header h1{

    font-size:40px;
}
}

</style>

</head>

<body>

<div class="header">

<h1>

🖋️ Senior Editor Dashboard

</h1>

<p>

Senior Editor:
<b>

<?php echo $senior_editor; ?>

</b>

</p>

</div>

<?php while($contract =
mysqli_fetch_assoc($contracts)){ ?>

<div class="contract">

<h2>

📚 <?php echo $contract['story_title']; ?>

</h2>

<p>

👤 Author:
<b>

<?php echo $contract['username']; ?>

</b>

</p>

<p>

📩 Email:
<b>

<?php echo $contract['email']; ?>

</b>

</p>

<p>

📝 Synopsis:
<br><br>

<?php echo $contract['synopsis']; ?>

</p>

<div class="status">

Current Status:
<b>

<?php

if($contract['status']){

    echo $contract['status'];

}else{

    echo "Pending Review";
}

?>

</b>

</div>

<form method="POST">

<input
type="hidden"
name="contract_id"
value="<?php echo $contract['id']; ?>">

<label>

📄 Contract Type

</label>

<select name="contract_type">

<option value="Non-Exclusive">

Non-Exclusive Contract

</option>

<option value="Exclusive">

Exclusive Contract

</option>

</select>

<label>

📨 Send Contract To

</label>

<input
type="text"
name="send_to"
placeholder="Enter email, Telegram, Discord, etc.">

<label>

❌ Reason for Rejection

</label>

<textarea
name="reason"
placeholder="Write rejection reason here..."></textarea>

<label>

✏️ Revision Notes

</label>

<textarea
name="revision"
placeholder="Tell the author what needs revision..."></textarea>

<div class="buttons">

<button
type="submit"
name="approve"
class="approve">

✅ Approve Contract

</button>

<button
type="submit"
name="reject"
class="reject">

❌ Reject

</button>

<button
type="submit"
name="revise"
class="revise">

✏️ Request Revision

</button>

</div>

</form>

</div>

<?php } ?>

</body>

</html>