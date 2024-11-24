<?php
require_once 'dbConfig.php';

function checkIfUserExists($pdo, $username) {
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {
        $userInfoArray = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            return [
                "result" => true,
                "status" => 200,
                "userInfoArray" => $userInfoArray
            ];
        } else {
            return [
                "result" => false,
                "status" => 400,
                "message" => "User doesn't exist in the database."
            ];
        }
    } else {

        return [
            "result" => false,
            "status" => 500,
            "message" => "Database query error."
        ];
    }
}

function insertNewUser($pdo, $username, $password, $email) {
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username, $password, $email]);

    if ($executeQuery) {
        return [
            'result' => true,
            'message' => 'User inserted successfully.'
        ];
    } else {
        return [
            'result' => false,
            'message' => 'Failed to insert user into the database.'
        ];
    }
}


function getAllUsers($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users");
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            return [
                'statusCode' => 200,
                'querySet' => $users
            ];
        } else {
            return [
                'statusCode' => 404,
                'message' => 'No users found in the database.'
            ];
        }

    } catch (PDOException $e) {
        return [
            'statusCode' => 500,
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }
}



function getAllGameDevelopers($pdo) {
    $sql = "SELECT * FROM game_developer_applicants ORDER BY first_name ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return [
            'message' => 'Game Developer Applicants retrieved successfully.',
            'statusCode' => 200,
            'querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC) 
        ];
    }
    
    return [
        'message' => 'Failed to retrieve game developer applicants.',
        'statusCode' => 400
    ];
}

function getAllGameDevelopersBySearch($pdo, $search_query) {
    $sql = "SELECT * FROM game_developer_applicants WHERE 
            CONCAT(first_name, last_name, email, phone_number) LIKE ?";
    
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%".$search_query."%"]);

    if ($executeQuery) {
        return [
            'message' => 'Search results retrieved successfully.',
            'statusCode' => 200,
            'querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }
    
    return [
        'message' => 'No matching records found.',
        'statusCode' => 400
    ];
}



function getUserByID($pdo, $id) {
    $sql = "SELECT * FROM game_developer_applicants WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$id]);

    if ($executeQuery) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return [
                'message' => 'User found successfully.',
                'statusCode' => 200,
                'querySet' => $user
            ];
        } else {
            return [
                'message' => 'User not found.',
                'statusCode' => 400
            ];
        }
    }
    
    return [
        'message' => 'Error retrieving user.',
        'statusCode' => 400
    ];
}

function insertAnActivityLog($pdo, $user_id, $action, $details) {
    $sql = "INSERT INTO activity_logs (user_id, action, details) 
            VALUES (?, ?, ?)";  

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$user_id, $action, $details]);

    if ($executeQuery) {
        return true;  // Log inserted successfully
    }

    return false;  // Failed to insert log
}

function getAllActivityLogs($pdo) {
    $sql = "
        SELECT al.log_id, al.action, al.details, u.username, al.log_time
        FROM activity_logs al
        JOIN users u ON al.user_id = u.user_id
        ORDER BY al.log_time DESC
    ";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute()) {
        return [
            'message' => 'Activity logs retrieved successfully.',
            'statusCode' => 200,
            'querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC) 
        ];
    }
    
    return [
        'message' => 'Failed to retrieve activity logs.',
        'statusCode' => 400
    ];
}

function insertNewApplicant($pdo, $first_name, $last_name, $email, $gender, $address, 
                            $state, $nationality, $years_of_experience, $programming_languages, 
                            $favorite_game_engine, $date_added) {
    try {
        $sql = "INSERT INTO game_developer_applicants (first_name, last_name, email, gender, address, state, 
                                                      nationality, years_of_experience, programming_languages, 
                                                      favorite_game_engine, date_added) 
                VALUES (:first_name, :last_name, :email, :gender, :address, :state, 
                        :nationality, :years_of_experience, :programming_languages, 
                        :favorite_game_engine, :date_added)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':email' => $email,
            ':gender' => $gender,
            ':address' => $address,
            ':state' => $state,
            ':nationality' => $nationality,
            ':years_of_experience' => $years_of_experience,
            ':programming_languages' => $programming_languages,
            ':favorite_game_engine' => $favorite_game_engine,
            ':date_added' => $date_added
        ]);

        $user_id = $_SESSION['user_id']; 
        $action = "INSERT";
        $details = "Added new applicant: $first_name $last_name, Email: $email";

        $logSuccess = insertAnActivityLog($pdo, $user_id, $action, $details);

        if ($logSuccess) {
            return [
                'status' => '200',
                'message' => 'Applicant inserted successfully, and activity log recorded!'
            ];
        } else {
            return [
                'status' => '500',
                'message' => 'Applicant inserted, but failed to record activity log.'
            ];
        }

    } catch (PDOException $e) {
        return [
            'status' => '500',
            'message' => 'Error inserting applicant: ' . $e->getMessage()
        ];
    }
}



function editApplicant($pdo, $first_name, $last_name, $email, $gender, $address, $state, $nationality, $years_of_experience, $programming_languages, $favorite_game_engine, $id, $updated_by) {
    $sql = "UPDATE game_developer_applicants 
            SET first_name = ?, last_name = ?, email = ?, gender = ?, address = ?, state = ?, nationality = ?, 
                years_of_experience = ?, programming_languages = ?, favorite_game_engine = ? 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $email, $gender, $address, $state, $nationality, 
                                    $years_of_experience, $programming_languages, $favorite_game_engine, $id]);

    if ($executeQuery) {
        $findUpdatedItemSQL = "SELECT * FROM game_developer_applicants WHERE id = ?";
        $stmtFindUpdatedItemSQL = $pdo->prepare($findUpdatedItemSQL);
        $stmtFindUpdatedItemSQL->execute([$id]);
        $updatedApplicantData = $stmtFindUpdatedItemSQL->fetch();

        $action = "UPDATE";
        $details = "Updated applicant: $first_name $last_name, Email: $email, Gender: $gender, Address: $address";
        $logSuccess = insertAnActivityLog($pdo, $updated_by, $action, $details);

        if ($logSuccess) {
            return [
                'message' => 'Applicant updated successfully, and activity log recorded.',
                'statusCode' => 200
            ];
        } else {
            return [
                'message' => 'Applicant updated, but failed to record activity log.',
                'statusCode' => 400
            ];
        }
    }

    return [
        'message' => 'Failed to update applicant.',
        'statusCode' => 400
    ];
}

function deleteApplicant($pdo, $applicantId, $deleted_by) {
    $query = "SELECT * FROM game_developer_applicants WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$applicantId]);

    if ($stmt->rowCount() == 0) {
        return [
            'statusCode' => 404,
            'message' => 'Applicant not found.'
        ];
    }

    $applicant = $stmt->fetch();

    $action = "DELETE";
    $details = "Deleted applicant: $applicant[first_name] $applicant[last_name], Email: $applicant[email], Address: $applicant[address]";
    $logSuccess = insertAnActivityLog($pdo, $deleted_by, $action, $details);

    if ($logSuccess) {
        $query = "DELETE FROM game_developer_applicants WHERE id = ?";
        $stmt = $pdo->prepare($query);

        if ($stmt->execute([$applicantId])) {
            return [
                'statusCode' => 200,
                'message' => 'Applicant deleted successfully.'
            ];
        } else {
            return [
                'statusCode' => 400,
                'message' => 'Failed to delete applicant.'
            ];
        }
    } else {
        return [
            'statusCode' => 400,
            'message' => 'Failed to insert activity log.'
        ];
    }
}



function searchForAUser($pdo, $searchQuery) {
    $sql = "SELECT * FROM game_developer_applicants WHERE 
            CONCAT(first_name, ' ', last_name, ' ', email, ' ', gender, ' ', address, ' ', state, ' ', nationality, ' ', years_of_experience, ' ', programming_languages, ' ', favorite_game_engine, ' ', date_added) 
            LIKE ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%" . $searchQuery . "%"]);
    
    if ($executeQuery) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            return [
                'message' => 'Search results retrieved successfully.',
                'statusCode' => 200,
                'querySet' => $results
            ];
        } else {
            return [
                'message' => 'No matching records found.',
                'statusCode' => 400
            ];
        }
    }

    return [
        'message' => 'Error occurred during search.',
        'statusCode' => 400
    ];
}
?>
