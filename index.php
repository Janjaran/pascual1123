<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Game Developer Management</title>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="searchForm">
        <form action="index.php" method="GET">
            <p>
                <input type="text" name="searchInput" placeholder="Search here" required>
                <input type="submit" name="searchBtn" value="Search">
            </p>
        </form>
    </div>

    <?php  
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
        if ($_SESSION['status'] == "200") {
            echo "<h1 style='color: green; text-align: center;'>{$_SESSION['message']}</h1>";
        } else {
            echo "<h1 style='color: red; text-align: center;'>{$_SESSION['message']}</h1>";    
        }
    }
    unset($_SESSION['message']);
    unset($_SESSION['status']);
    ?>

    <div class="tableClass">
        <table style="width: 100%;" cellpadding="20"> 
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Address</th>
                <th>State</th>
                <th>Nationality</th>
                <th>Years of Experience</th>
                <th>Programming Languages</th>
                <th>Favorite Game Engine</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>

            <?php 
            if (!isset($_GET['searchBtn'])) {
                $getAllGameDevelopersResponse = getAllGameDevelopers($pdo);
                
                if (isset($getAllGameDevelopersResponse['statusCode']) && $getAllGameDevelopersResponse['statusCode'] == 200) {
                    $getAllGameDevelopers = $getAllGameDevelopersResponse['querySet'];
                    
                    foreach ($getAllGameDevelopers as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['state']); ?></td>
                            <td><?php echo htmlspecialchars($row['nationality']); ?></td>
                            <td><?php echo htmlspecialchars($row['years_of_experience']); ?></td>
                            <td><?php echo htmlspecialchars($row['programming_languages']); ?></td>
                            <td><?php echo htmlspecialchars($row['favorite_game_engine']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } 
                } else {
                    $message = isset($getAllGameDevelopersResponse['message']) ? $getAllGameDevelopersResponse['message'] : "An error occurred.";
                    echo "<tr><td colspan='12'>{$message}</td></tr>";
                }
            } else {
                $searchForAGameDeveloperResponse = searchForAUser($pdo, $_GET['searchInput']);
                
                if (isset($searchForAGameDeveloperResponse['statusCode']) && $searchForAGameDeveloperResponse['statusCode'] == 200) {
                    $searchForAGameDeveloper = $searchForAGameDeveloperResponse['querySet'];
                    
                    if (!empty($searchForAGameDeveloper)) {
                        foreach ($searchForAGameDeveloper as $row) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><?php echo htmlspecialchars($row['state']); ?></td>
                                <td><?php echo htmlspecialchars($row['nationality']); ?></td>
                                <td><?php echo htmlspecialchars($row['years_of_experience']); ?></td>
                                <td><?php echo htmlspecialchars($row['programming_languages']); ?></td>
                                <td><?php echo htmlspecialchars($row['favorite_game_engine']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php } 
                    } else {
                        echo "<tr><td colspan='12'>No game developers found matching your search criteria.</td></tr>";
                    }
                } else {
                    $message = isset($searchForAGameDeveloperResponse['message']) ? $searchForAGameDeveloperResponse['message'] : "Search failed.";
                    echo "<tr><td colspan='12'>{$message}</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</body>
</html>
