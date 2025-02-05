<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['id'];
    $commentId = $_POST['comment_id'];
    $query = "INSERT INTO comments_likes (user_id, comment_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $userId, $commentId);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>
