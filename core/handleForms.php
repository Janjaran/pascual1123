<?php  

require_once 'dbConfig.php';
require_once 'models.php';

session_start(); 

if (isset($_POST['insertUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);

    if (!empty($username) && !empty($password) && !empty($confirm_password) && !empty($email)) {
        if ($password === $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
            $insertUser = insertNewUser($pdo, $username, $hashed_password, $email);

            if ($insertUser['result']) {
                $_SESSION['message'] = "Registration Complete!"; 
                $_SESSION['status'] = "200";
                header("Location: ../login.php"); 
                exit();
            } else {
                $_SESSION['message'] = "Error: " . $insertUser['message'];
                $_SESSION['status'] = "400";
                header("Location: ../register.php");
                exit();
            }

        } else {
            $_SESSION['message'] = "Passwords do not match.";
            $_SESSION['status'] = '400';
            header("Location: ../register.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Please fill in all fields.";
        $_SESSION['status'] = '400';
        header("Location: ../register.php");
        exit();
    }
}

if (isset($_POST['loginUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $loginQuery = checkIfUserExists($pdo, $username);

        if ($loginQuery['result']) {
            $userIDFromDB = $loginQuery['userInfoArray']['user_id'];
            $usernameFromDB = $loginQuery['userInfoArray']['username'];
            $passwordFromDB = $loginQuery['userInfoArray']['password'];

            if (password_verify($password, $passwordFromDB)) {
                $_SESSION['user_id'] = $userIDFromDB;
                $_SESSION['username'] = $usernameFromDB;
                header("Location: ../index.php"); 
                exit();
            } else {
                $_SESSION['message'] = "Invalid username or password.";
                $_SESSION['status'] = "400";
                header("Location: ../login.php"); 
                exit();
            }
        } else {
            $_SESSION['message'] = $loginQuery['message'];
            $_SESSION['status'] = "400";
            header("Location: ../login.php");
            exit();
        }

    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields.";
        $_SESSION['status'] = '400';
        header("Location: ../login.php"); 
        exit();
    }
}

if (isset($_POST['insertNewApplicantBtn'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $state = trim($_POST['state']);
    $nationality = trim($_POST['nationality']);
    $years_of_experience = trim($_POST['years_of_experience']);
    $programming_languages = trim($_POST['programming_languages']);
    $favorite_game_engine = trim($_POST['favorite_game_engine']);

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($gender) &&
        !empty($address) && !empty($state) && !empty($nationality) && !empty($years_of_experience) && 
        !empty($programming_languages) && !empty($favorite_game_engine)) {

        $insertApplicant = insertNewApplicant($pdo, $first_name, $last_name, $email, $gender, $address, 
            $state, $nationality, $years_of_experience, $programming_languages, $favorite_game_engine, date('Y-m-d H:i:s'));

        if ($insertApplicant['status'] == 'success') {
            
            $user_id = $_SESSION['user_id']; 
            $action = "Added New Applicant";
            $details = "First Name: $first_name, Last Name: $last_name, Email: $email";

            $logResult = insertAnActivityLog($pdo, $user_id, $action, $details);

            if ($logResult === true) {
                $_SESSION['status'] = 'success';
                $_SESSION['message'] = 'Applicant added and activity logged successfully.';
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['message'] = 'Applicant added, but failed to log the activity.';
            }
            
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = $insertApplicant['message'];
        }

        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['message'] = "Please make sure all fields are filled.";
        $_SESSION['status'] = '400';
        header("Location: ../index.php");
        exit();
    }
}



if (isset($_POST['editUserBtn'])) {
    $id = $_POST['id']; 
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $address = trim($_POST['address']);
    $state = trim($_POST['state']);
    $nationality = trim($_POST['nationality']);
    $years_of_experience = trim($_POST['years_of_experience']);
    $programming_languages = trim($_POST['programming_languages']);
    $favorite_game_engine = trim($_POST['favorite_game_engine']);

    if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($gender) && 
        !empty($address) && !empty($state) && !empty($nationality) && !empty($years_of_experience) &&
        !empty($programming_languages) && !empty($favorite_game_engine)) {

        $updatedBy = $_SESSION['user_id'];
        $editApplicant = editApplicant($pdo, $first_name, $last_name, $email, $gender, $address, 
            $state, $nationality, $years_of_experience, $programming_languages, $favorite_game_engine, $id, $updatedBy);

        if ($editApplicant['statusCode'] == 200) {
            $_SESSION['message'] = "Applicant updated successfully!";
            $_SESSION['status'] = "200";
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['message'] = "Error: " . $editApplicant['message'];
            $_SESSION['status'] = "400";
            header("Location: ../edit.php?id=" . $id); 
            exit();
        }

    } else {
        $_SESSION['message'] = "Please make sure all fields are filled.";
        $_SESSION['status'] = '400';
        header("Location: ../edit.php?id=" . $id);
        exit();
    }
}


if (isset($_POST['deleteApplicantBtn'])) {
    $applicantId = $_POST['user_id'];

    if (!empty($applicantId)) {
        $username = $_SESSION['username'];
        
        $query = "SELECT user_id FROM users WHERE username = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            $userId = $user['user_id'];

            $deleteApplicantResponse = deleteApplicant($pdo, $applicantId, $userId); 

            $_SESSION['message'] = $deleteApplicantResponse['message'];
            $_SESSION['status'] = $deleteApplicantResponse['statusCode'];

            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['message'] = "User not found!";
            $_SESSION['status'] = 404;
            header("Location: ../index.php");
            exit();
        }
    }
}

if (isset($_GET['searchBtn'])) {
    $searchQuery = $_GET['searchInput'];
    $searchForAUserResponse = searchForAUser($pdo, $searchQuery);

    if ($searchForAUserResponse['statusCode'] == 200) {
        foreach ($searchForAUserResponse['querySet'] as $row) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['state']}</td>
                    <td>{$row['nationality']}</td>
                    <td>{$row['years_of_experience']}</td>
                    <td>{$row['programming_languages']}</td>
                    <td>{$row['favorite_game_engine']}</td>
                    <td>{$row['date_added']}</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='12'>No matching records found.</td></tr>";
    }
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
}


?>
