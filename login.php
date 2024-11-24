<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
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

    <?php  
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
        $messageClass = ($_SESSION['status'] == "200") ? 'success' : 'error';
        echo "<div class='message $messageClass'>{$_SESSION['message']}</div>";
    }
    unset($_SESSION['message']);
    unset($_SESSION['status']);
    ?>
    <h1 style="text-align: center;">Welcome to Game Developer Job Application System!</h1>
    <h1 style="text-align: center;">Login Now</h1>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" required>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </p>
        <p>
            <input type="submit" name="loginUserBtn" value="Login">
        </p>
    </form>

    <p style="text-align: center;">Don't have an account? You can register <a href="register.php">here</a>.</p>

</body>
</html>
