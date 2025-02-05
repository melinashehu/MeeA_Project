<?php
include "validation.php";
include "db_connection.php";
include "sendemail.php";

if ($_POST["action"] = "register") { 

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    $verificationCode = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);

    $validationErrors = [];

    $validName = validate_name($name);
    if (!$validName['status']) {
        $validationErrors['name'] = $validName['message'];
    }

    $validEmail = validate_email($email, $connection);
    if (!$validEmail['status']) {
        $validationErrors['email'] = $validEmail['message'];
    }

    $validPass = validate_password($password);
    if (!$validPass['status']) {
        $validationErrors['password'] = $validPass['message'];
    }

    if (count($validationErrors)) {
        header("Content-Type: application/json", "", 400);
        echo json_encode([
            'message' => 'Invalid data',
            'errors' => $validationErrors,
        ]);
        exit();
    } else {
        $result = sendVerificationEmail($email, $verificationCode);

        $queryShtoUser = "INSERT INTO users (name, email, password, verified_email, verification_code) 
                          VALUES ('$name', '$email', '$passwordHashed', 0, '$verificationCode')";

        if (mysqli_query($connection, $queryShtoUser)) {
            $userId = mysqli_insert_id($connection);

            $defaultImagePath = '../../uploads/user-profile.png'; 
            $sqlProfilePicture = "INSERT INTO profile_pictures (user_id, image_path, picture_status) 
                                  VALUES ('$userId', '$defaultImagePath', 1)";

            if (!mysqli_query($connection, $sqlProfilePicture)) {
                http_response_code(500);
                echo json_encode([
                    'message' => 'Gabim gjatë ruajtjes së fotos së profilit.',
                    'error' => mysqli_error($connection),
                ]);
                exit();
            }

            session_start();
            $_SESSION['id'] = $userId;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['verification_code'] = $verificationCode;


            header("Location: verification.php"); 

        } else {
            http_response_code(500);
            echo json_encode([
                'message' => 'Gabim gjatë ruajtjes së të dhënave.',
                'error' => mysqli_error($connection),
            ]);
        }
        exit();
    }
}
?>
