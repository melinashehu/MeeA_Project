<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "db_connection.php";
    if (!isset($_SESSION['email'])) {
        echo "Gabim, emaili nuk është në sesion.";
        exit();
    }
    
    $inputCode = mysqli_real_escape_string($connection, $_POST['verification_code']);
    $email = $_SESSION['email'];  

    $query = "SELECT * FROM users WHERE email = '$email' AND verification_code = '$inputCode'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $updateQuery = "UPDATE users SET verified_email = 1 WHERE email = '$email'";
        if (mysqli_query($connection, $updateQuery)) {
            session_start();
            $_SESSION['verified_email'] = 1;

            header("Location: /codding-community-platform/Home/home.php");
            exit();
        } else {
            echo "Gabim gjatë përditësimit të statusit të verifikimit.";
        }
    } else {
        echo "Kodi i verifikimit është i gabuar!";
    }
}
?>


<form method="POST" action="verification.php">
    <label for="verification_code">Futni Kodin e Verifikimit:</label>
    <input type="text" name="verification_code" required>
    <button type="submit">Verifiko</button>

</form>

<style>
  
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

form {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}


form h2 {
    color: #c6e7df;
    font-size: 24px;
    margin-bottom: 20px;
}


input[type="text"] {
    width: 100%;
    padding: 12px 20px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
}


input[type="text"]:focus {
    border-color: #4CAF50;
    outline: none;
}


button {
    background-color:rgb(132, 196, 180);
    color: white;
    border: none;
    padding: 14px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    margin-top: 10px;
}

button:hover {
    background-color: #45a049;
}


.error-message {
    color: red;
    font-size: 14px;
    margin-top: 10px;
}

</style>
