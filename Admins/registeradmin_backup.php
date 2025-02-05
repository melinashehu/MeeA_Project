<?php
include "../Backend/Regjistrimi/db_connection.php";

$name = 'Amina';
$email = 'amina@example.com';
$password = 'Adminpassword123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO users (name, email, password, role) 
          VALUES ('$name', '$email', '$hashedPassword', 'admin')";

if (mysqli_query($connection, $query)) {
    echo "Admin user u krijua me sukses!";
} else {
    echo "Gabim: " . mysqli_error($connection);
}
?>
