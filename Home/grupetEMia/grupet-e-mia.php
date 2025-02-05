<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];

$mysqli = new mysqli("localhost", "root", "", "programimweb");

if ($mysqli->connect_error) {
    die("Lidhja me bazën e të dhënave dështoi: " . $mysqli->connect_error);
}


$stmt = $mysqli->prepare("SELECT emri_grupit, anetaret, lloji, privatesia, created_at FROM groups WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$groups = [];
while ($row = $result->fetch_assoc()) {
    $groups[] = $row;
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEEA | Grupet e Mia</title>
    <link rel="stylesheet" href="grupet-e-mia.css">
    <style>
        body{
            min-height: 100vh;
            overflow-x: hidden;
            background-color: #ffffff;
        }
        .main{
            position: absolute;
            width: calc(100%-300px);
            left: 300px;
            min-height: 100vh;
            background: #ffffff;
            transition: 0.5s;
        }
        .main.active{
            width: calc(100%-80px);
            left: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <div class="logo">
                            <img src="../Profili/logo.meea.png" alt="Logo">
                        </div>
                        <span class="tittle1">MEEA</span>
                    </a>
                </li>
                <li>
                    <a href="../home.php">
                        <span class="icon"> <ion-icon name="home-outline"></ion-icon></span>
                        <span class="tittle">Faqja Kryesore</span>
                    </a>
                </li>
                <li>
                    <a href="../Profili/profili.php?user_id=<?php echo $user_id; ?>">
                        <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <span class="tittle">Profili</span>
                    </a>
                </li>
                <li class="hovered">
                    <a href="#">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
                        <span class="tittle">Grupet e Mia</span>
                    </a>
                </li>
                <li>
                    <a href="../help.php">
                        <span class="icon"> <ion-icon name="help-outline"></ion-icon></span>
                        <span class="tittle">Help</span>
                    </a>
                </li>
                <li>
                    <a href="../settings.php">
                        <span class="icon"> <ion-icon name="settings-outline"></ion-icon></span>
                        <span class="tittle">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="../logout.php">
                        <span class="icon"> <ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="tittle">Sign out</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>
            <div class="table-container">
                <h2>Grupet e Mia</h2>
                <?php if (count($groups) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Emri i Grupit</th>
                                <th>Lloji</th>
                                <th>Privatësia</th>
                                <th>Data e Krijimit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($groups as $group): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($group['emri_grupit']); ?></td>
                                    <td><?php echo htmlspecialchars($group['lloji']); ?></td>
                                    <td><?php echo htmlspecialchars($group['privatesia']); ?></td>
                                    <td><?php echo htmlspecialchars($group['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Nuk ka grupe për t'u shfaqur.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="grupet-e-mia.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>