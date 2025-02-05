<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
require_once 'uploadFile.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $type = $_POST['type'] ?? '';

    if (!$userId || empty($type) || empty($title)) {
        $_SESSION['error'] = 'Ju lutem plotësojini të gjitha fushat e kërkuara!';
        header('Location: home.php');
        exit();
    }

    try {
       
        if ($type === 'text') {
            if (empty($content)) {
                throw new Exception('Teksti nuk mund të lihet bosh.');
            }

            $stmt = mysqli_prepare($connection, "INSERT INTO posts (user_id, type, title, content) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception('Unable to prepare statement.');
            }
            mysqli_stmt_bind_param($stmt, 'isss', $userId, $type, $title, $content);
        } 
      
        elseif ($type === 'image' || $type === 'video') {
            if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('File upload failed.');
            }

            $mediaPath = uploadFile($_FILES['file']); 

            $stmt = mysqli_prepare($connection, "INSERT INTO posts (user_id, type, title, media_path) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception('Unable to prepare statement.');
            }
            mysqli_stmt_bind_param($stmt, 'isss', $userId, $type, $title, $mediaPath);
        } 
        
        elseif ($type === 'link') {
            if (empty($content)) {
                throw new Exception('Link-u nuk mund të lihet bosh.');
            }

            $stmt = mysqli_prepare($connection, "INSERT INTO posts (user_id, type, title, content) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception('Unable to prepare statement.');
            }
            mysqli_stmt_bind_param($stmt, 'isss', $userId, $type, $title, $content);
        } else {
            throw new Exception('Tipi i postimit është i panjohur.');
        }

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Postimi nuk u ruajt.');
        }

        $_SESSION['success'] = 'Postimi u ruajt me sukses!';
        header('Location: home.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: home.php');
        exit();
    } finally {
        if (isset($stmt)) {
            mysqli_stmt_close($stmt);
        }
        mysqli_close($connection);
    }
} else {
    $_SESSION['error'] = 'Kërkesa nuk është e saktë.';
    header('Location: home.php');
    exit();
}
?>
