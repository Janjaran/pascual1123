<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Insert New User</title>
</head>
<body>
<?php include 'navbar.php'; ?>
<?php
if (isset($_SESSION['message'])) { ?>
    <h1 style="color: green; text-align: center; background-color: ghostwhite; border-style: solid;">
        <?php echo $_SESSION['message']; ?>
    </h1>
<?php unset($_SESSION['message']); }
?>

<h2 style="text-align: center;">Insert New User</h2>

<form action="core/handleForms.php" method="POST" style="max-width: 500px; margin: auto;">
    <label for="first_name">First Name</label>
    <input type="text" name="first_name" id="first_name" required>

    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>

    <label for="gender">Gender</label>
    <select name="gender" id="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select>

    <label for="address">Address</label>
    <input type="text" name="address" id="address" required>

    <label for="state">State</label>
    <input type="text" name="state" id="state" required>

    <label for="nationality">Nationality</label>
    <input type="text" name="nationality" id="nationality" required>

    <label for="years_of_experience">Years of Experience</label>
    <input type="number" name="years_of_experience" id="years_of_experience" required>

    <label for="programming_languages">Programming Languages</label>
    <input type="text" name="programming_languages" id="programming_languages" required>

    <label for="favorite_game_engine">Favorite Game Engine</label>
    <input type="text" name="favorite_game_engine" id="favorite_game_engine" required>

    <input type="submit" name="insertNewApplicantBtn" value="Insert User">

</form>

</body>
</html>
