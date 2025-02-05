<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();
header('Content-Type: application/json');


$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['id'];  
    $userAbout = trim($_POST['about_text'] ?? '');

    
    if (strlen($userAbout) < 10 || strlen($userAbout) > 500) {
        echo json_encode(['success' => false, 'message' => 'Teksti duhet të ketë 10 deri në 500 karaktere!']);
        exit;
    }


    $stmt = mysqli_prepare($connection, "INSERT INTO user_about_information (user_id, about_text) 
                                         VALUES (?, ?) 
                                         ON DUPLICATE KEY UPDATE about_text = ?");
    
   
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($connection)]);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'iss', $userId, $userAbout,$userAbout);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Informacioni u ruajt me sukses!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gabim gjatë ruajtjes së informacionit. Error: ' . mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Metoda e kërkesës nuk është e saktë.']);
}

mysqli_close($connection);
?>
