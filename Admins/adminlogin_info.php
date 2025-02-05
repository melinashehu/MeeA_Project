<?php
require_once "../Backend/Regjistrimi/db_connection.php";

if ($_POST['action'] == "login") {
    $email = mysqli_real_escape_string($connection, trim($_POST['email']));
    $password = mysqli_real_escape_string($connection, trim($_POST['password']));

    if (empty($password) || strlen($password) < 8) {
        http_response_code(203);
        echo json_encode([
            "message" => "Passwordi duhet te kete te pakten 8 karaktere!",
            "tagError" => "passwordError",
            "tagElement" => "password"
        ]);
        exit;
    }

    $query_check = "SELECT * FROM users WHERE email = '$email' AND role = 'admin'";
    $result_check = mysqli_query($connection, $query_check);

    if (!$result_check) {
        http_response_code(500);
        echo json_encode([
            "message" => "Internal server error",
            "error" => mysqli_error($connection)
        ]);
        exit;
    }

    if (mysqli_num_rows($result_check) == 0) {
        http_response_code(203);
        echo json_encode([
            "message" => "Ky email nuk ekziston ose nuk është admin!"
        ]);
        exit;
    }

    $row = mysqli_fetch_assoc($result_check);
    $passwordHashed = $row['password'];

    if (!password_verify($password, $passwordHashed)) {
        http_response_code(203);
        echo json_encode([
            "message" => "Passwordi i dhënë është gabim!"
        ]);
        exit;
    }

    session_start();
    $_SESSION['id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $row['email'];

    header("Location: \codding-community-platform\Admins\listofusers.php");
    exit();
}
?>
