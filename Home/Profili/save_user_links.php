<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();

function validateUsername($username) {
    return preg_match('/^[a-zA-Z0-9._-]{3,30}$/', $username);
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $linkedin = trim($_POST['linkedin'] ?? '');
    $github = trim($_POST['github'] ?? '');
    $mail = trim($_POST['mail'] ?? '');

    if (empty($linkedin) && empty($github) && empty($mail)) {
        echo 'Njëri prej link-eve duhet plotësuar.';
        exit;
    }

    if ((!empty($linkedin) && !validateUsername($linkedin)) || 
        (!empty($github) && !validateUsername($github)) || 
        (!empty($mail) && !validateEmail($mail))) {
        echo 'Invalid input detected.';
        exit;
    }

    $userId = $_SESSION['id'];

    $stmt = mysqli_prepare(
        $connection,
        "INSERT INTO user_contact_links (user_id, linkedin_username, github_username, mail_username) 
         VALUES (?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE linkedin_username = VALUES(linkedin_username), 
                                 github_username = VALUES(github_username), 
                                 mail_username = VALUES(mail_username)"
    );

    if (!$stmt) {
        echo 'Database error: Unable to prepare statement.';
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'isss', $userId, $linkedin, $github, $mail);

    if (mysqli_stmt_execute($stmt)) {
        echo 'Link-et u update-uan me sukses.';
    } else {
        echo 'Database error: Unable to execute statement.';
    }

    mysqli_stmt_close($stmt);
} else {
    echo 'Invalid request method.';
}

mysqli_close($connection);
?>
