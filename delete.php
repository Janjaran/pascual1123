<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Delete User</title>
</head>
<body>
    <?php 
    if (isset($_GET['id'])) {
        $getUserResponse = getUserByID($pdo, $_GET['id']);
        
        if ($getUserResponse['statusCode'] == 200) {
            $user = $getUserResponse['querySet'];
            ?>
            <h1>Are you sure you want to delete this user?</h1>
            <div class="container" style="border: 1px solid black; padding: 20px; max-width: 600px;">
                <h2>First Name: <?php echo htmlspecialchars($user['first_name']); ?></h2>
                <h2>Last Name: <?php echo htmlspecialchars($user['last_name']); ?></h2>
                <h2>Email: <?php echo htmlspecialchars($user['email']); ?></h2>

                <div class="deleteBtn" style="float: right; margin-top: 20px;">
                    <form action="core/handleForms.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
                        <input type="submit" name="deleteApplicantBtn" value="Delete" style="background-color: red; color: white; padding: 10px; border: none;">
                    </form>          
                </div>
                <a href="index.php" style="display: block; margin-top: 20px;">Cancel</a>
            </div>
            <?php
        } else {
            echo "<h2>" . htmlspecialchars($getUserResponse['message']) . "</h2>";
        }
    } else {
        echo "<h2>No user ID specified.</h2>";
    }
    ?>
</body>
</html>
