<?php
require_once "../Backend/Regjistrimi/db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connection, trim($_POST['name']));
    $email = mysqli_real_escape_string($connection, trim($_POST['email']));
    $role = mysqli_real_escape_string($connection, trim($_POST['role']));

    if (empty($name) || empty($email) || empty($role)) {
        echo "Të gjitha fushat janë të detyrueshme.";
        exit;
    }

    $email_check_query = "SELECT id FROM users WHERE email = '$email'";
    $result_email_check = mysqli_query($connection, $email_check_query);

    if (!$result_email_check) {
        echo "Gabim gjatë kontrollimit të email-it: " . mysqli_error($connection);
        exit;
    }

    if (mysqli_num_rows($result_email_check) > 0) {
        echo "Ky email është tashmë i regjistruar.";
        exit;
    }

    $insert_query = "INSERT INTO users (name, email, role) VALUES ('$name', '$email', '$role')";
    $result_insert = mysqli_query($connection, $insert_query);

    if ($result_insert) {
        header("Location: listofusers.php");
        exit;
    } else {
        echo "Gabim gjatë shtimit të përdoruesit: " . mysqli_error($connection);
        exit;
    }
} else {
    echo "Kërkesa është e pavlefshme.";
    exit;
}
?>
