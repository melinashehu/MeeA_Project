<?php
session_start();
require_once "../Backend/Regjistrimi/db_connection.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $connection->prepare($delete_query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "Përdoruesi u fshi me sukses!";
        header("Location: listofusers.php");
        exit;
    } else {
        echo "Gabim gjatë fshirjes: " . $connection->error;
    }
} else {
    echo "ID e përdoruesit nuk u specifikua!";
    exit;
}
?>
