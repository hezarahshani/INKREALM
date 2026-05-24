<?php

require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validation
    if (empty($username) || empty($email) || empty($password)) {

        $message = "All fields are required.";

    } else {

        try {

            // Check if email already exists
            $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $check->execute([$email]);

            if ($check->rowCount() > 0) {

                $message = "Email already exists.";

            } else {

                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert user
                $sql = "INSERT INTO users (username, email, password)
                        VALUES (?, ?, ?)";

                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([$username, $email, $hashedPassword])) {

                    $message = "Registration successful!";

                } else {

                    $message = "Registration failed.";

                }
            }

        } catch (PDOException $e) {

            $message = "Error: " . $e->getMessage();

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - InkRealm</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #6a0dad;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            color: red;
        }

        .success {
            color: green;
        }

    </style>

</head>
<body>

<div class="register-box">

    <h2>Create Account</h2>

    <?php if (!empty($message)) : ?>

        <div class="message <?php echo ($message == 'Registration successful!') ? 'success' : ''; ?>">

            <?php echo $message; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <input 
            type="text" 
            name="username" 
            placeholder="Enter username"
            required
        >

        <input 
            type="email" 
            name="email" 
            placeholder="Enter email"
            required
        >

        <input 
            type="password" 
            name="password" 
            placeholder="Enter password"
            required
        >

        <button type="submit">
            Register
        </button>

    </form>

</div>

</body>
</html>