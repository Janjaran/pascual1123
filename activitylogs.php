<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$getAllActivityLogs = getAllActivityLogs($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="tableClass">
        <table style="width: 100%;" cellpadding="20">
            <tr>
                <th>Activity Log ID</th>
                <th>Action</th>
                <th>Details</th>
                <th>Username</th>
                <th>Log Time</th>
            </tr>
            <?php 
            if ($getAllActivityLogs['statusCode'] == 200) {
                foreach ($getAllActivityLogs['querySet'] as $row) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['log_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['action']); ?></td>
                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['log_time']); ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5'>No activity logs found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
