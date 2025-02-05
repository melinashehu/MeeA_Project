<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();

$userId = $_SESSION['id'];
$theme = $_POST['theme'] ?? '';

if (!in_array($theme, ['light', 'dark'])) {
    echo 'Invalid theme mode.';
    exit;
}


$stmt = mysqli_prepare(
    $connection,
    "INSERT INTO user_preferences (user_id, theme_mode) 
     VALUES (?, ?)
     ON DUPLICATE KEY UPDATE theme_mode = VALUES(theme_mode)"
);
mysqli_stmt_bind_param($stmt, 'is', $userId, $theme);

if (mysqli_stmt_execute($stmt)) {
    
    header('Location: profili.php');  
    exit;
} else {
    echo 'Gabim gjatë ruajtjes së preferencës.';
}

mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
