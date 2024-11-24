<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

if (isset($_GET['id'])) {
    $getUserResponse = getUserByID($pdo, $_GET['id']);
    if ($getUserResponse['statusCode'] == 200) {
        $user = $getUserResponse['querySet'];
    } else {
        echo "<p>Error: " . htmlspecialchars($getUserResponse['message']) . "</p>";
        exit(); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Applicant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Applicant</h1>

    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required><br>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($user['state']); ?>" required><br>

        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($user['nationality']); ?>" required><br>

        <label for="years_of_experience">Years of Experience:</label>
        <input type="text" id="years_of_experience" name="years_of_experience" value="<?php echo htmlspecialchars($user['years_of_experience']); ?>" required><br>

        <label for="programming_languages">Programming Languages:</label>
        <input type="text" id="programming_languages" name="programming_languages" value="<?php echo htmlspecialchars($user['programming_languages']); ?>" required><br>

        <label for="favorite_game_engine">Favorite Game Engine:</label>
        <input type="text" id="favorite_game_engine" name="favorite_game_engine" value="<?php echo htmlspecialchars($user['favorite_game_engine']); ?>" required><br>

        <input type="submit" name="editUserBtn" value="Update">
    </form>
</body>
</html>
