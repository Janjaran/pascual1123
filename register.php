<?php  
session_start(); 
require_once 'core/models.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        input {
            font-size: 1.2em;
            height: 40px;
            width: 250px;
            margin-bottom: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            font-size: 1.1em;
            margin-bottom: 5px;
        }
        .message {
            text-align: center;
            font-size: 1.2em;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Register Here!</h1>

    <?php  
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
        $messageClass = ($_SESSION['status'] == "200") ? 'success' : 'error';
        echo "<div class='message $messageClass'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']); 
        unset($_SESSION['status']);  
    }
    ?>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" required>
        </p>
        <p>
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" required>
        </p>
        <p>
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </p>
        <p>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required>
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </p>
        <p>
            <input type="submit" name="insertUserBtn" value="Register">
        </p>
    </form>

    <p style="text-align: center;">Already have an account? You can login <a href="login.php">here</a>.</p>

</body>
</html>
