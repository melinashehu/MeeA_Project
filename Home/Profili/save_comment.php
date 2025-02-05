<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_id']) && !empty($_POST['content'])) {
        $userId = $_SESSION['id'] ?? null;
        $postId = intval($_POST['post_id']);
        $content = trim($_POST['content']);
        $parentId = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : null;

        if (!$userId || empty($content)) {
            $_SESSION['error'] = 'Përmbajtja e komentit është e detyrueshme!';
        } else {
            try {
                if ($parentId) {
                    $stmt = mysqli_prepare($connection, "INSERT INTO comments (post_id, user_id, content, parent_id) VALUES (?, ?, ?, ?)");
                    if (!$stmt) {
                        throw new Exception('Unable to prepare statement.');
                    }
                    mysqli_stmt_bind_param($stmt, 'iisi', $postId, $userId, $content, $parentId);
                } else {
                    $stmt = mysqli_prepare($connection, "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
                    if (!$stmt) {
                        throw new Exception('Unable to prepare statement.');
                    }
                    mysqli_stmt_bind_param($stmt, 'iis', $postId, $userId, $content);
                }

                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['success'] = 'Komenti u shtua me sukses!';
                } else {
                    $_SESSION['error'] = 'Ndodhi një problem gjatë ruajtjes së komentit.';
                }

                mysqli_stmt_close($stmt);
                mysqli_close($connection);
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                mysqli_close($connection);
            }
        }

        header('Location: ../home.php');  
        exit();  
    }
} else {
    $_SESSION['error'] = 'Kërkesa nuk është e saktë.';
    header('Location: ../home.php');  
    exit();  
}
