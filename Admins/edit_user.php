<?php
session_start();
require_once "../Backend/Regjistrimi/db_connection.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $query = "SELECT name, email, role FROM users WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "Përdoruesi nuk u gjet!";
        exit;
    }
} else {
    echo "ID e përdoruesit nuk u specifikua!";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $update_query = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("sssi", $name, $email, $role, $user_id);

    if ($update_stmt->execute()) {
        echo "Të dhënat u përditësuan me sukses!";
        header("Location: listofusers.php");
        exit;
    } else {
        echo "Gabim gjatë përditësimit: " . $connection->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_user.css">
    <title>Modifiko Përdoruesin</title>
</head>
<body>
    <h2>Modifiko të Dhënat e Përdoruesit</h2>
    <form method="POST" action="">
        <label>Emri:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label>Roli:</label>
        <select name="role" required>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
        </select><br><br>

        <button type="submit">Përditëso</button>
    </form>

    <a href="listofusers.php">Kthehu te Lista e Përdoruesve</a>
</body>
</html>
