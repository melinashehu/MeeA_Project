<?php
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(["success" => false, "message" => "Përdoruesi nuk është autentifikuar."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    $emri_grupit = $_POST['emri_grupit'] ?? '';
    $anetaret = $_POST['anetaret'] ?? '';
    $lloji = $_POST['lloji'] ?? '';
    $privatesia = $_POST['privatesia'] ?? '';

    if (empty($emri_grupit) || empty($anetaret) || empty($lloji) || empty($privatesia)) {
        echo json_encode(["success" => false, "message" => "Të dhënat janë të paplota."]);
        exit();
    }

    $mysqli = new mysqli("localhost", "root", "", "programimweb");

    if ($mysqli->connect_error) {
        echo json_encode(["success" => false, "message" => "Lidhja me bazën e të dhënave dështoi."]);
        exit();
    }

    $stmt = $mysqli->prepare("INSERT INTO groups (user_id, emri_grupit, anetaret, lloji, privatesia) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $emri_grupit, $anetaret, $lloji, $privatesia);

    if ($stmt->execute()) {
        $group_id = $stmt->insert_id; 
        echo json_encode(["success" => true, "group_id" => $group_id, "message" => "Grupi u krijua me sukses."]);
    } else {
        echo json_encode(["success" => false, "message" => "Nuk mund të ruhej grupi.", "error" => $stmt->error]);
    }

    $stmt->close();
    $mysqli->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEEA | Krijimi i Grupit</title>
    <link rel="stylesheet" href="krijimGrupi.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap");

* {
  font-family: "Ubuntu", sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
:root {
  --blue: #58a390;
  --white: #c6e7df;
  --gray: #f5f5f5;
  --black1: #222;
  --black2: #999;
}
body {
  min-height: 100vh;
  overflow-x: hidden;
  background-color: #ffffff;
}
.container {
  position: relative;
  width: 100%;
}

.logo {
  display: flex;
  align-items: center;
  margin-bottom: 0px;
  padding: 0 0px;
}
.tittle1 {
  margin-left: 0px;
  margin-top: 10px;
  font-size: 20px;
  font-weight: bold;
  color: #ecf0f1;
}
.logo img {
  width: 45px;
  height: 40px;
  margin-left: 8px;
}

.navigation {
  position: fixed;
  width: 300px;
  height: 100%;
  background: var(--blue);
  border-left: 10px solid var(--blue);
  transition: 0.5s;
  overflow: hidden;
}
.navigation.active {
  width: 60px;
}
.navigation ul {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
}
.navigation ul li {
  position: relative;
  width: 100%;
  list-style: none;
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
}
.navigation ul li:hover,
.navigation ul li.hovered {
  background-color: var(--white);
}
.navigation ul li:nth-child(1) {
  margin-bottom: 40px;
  pointer-events: none;
}
.navigation ul li a {
  position: relative;
  display: block;
  width: 100%;
  display: flex;
  text-decoration: none;
  color: var(--white);
}
.navigation ul li:hover a,
.navigation ul li.hovered a {
  color: var(--blue);
}

.navigation ul li a .icon {
  position: relative;
  display: block;
  min-width: 50px;
  height: 50px;
  line-height: 65px;
  text-align: center;
}
.navigation ul li a .icon ion-icon {
  font-size: 1.65em;
}
.navigation ul li a .tittle {
  position: relative;
  display: block;
  padding: 0 10px;
  height: 50px;
  line-height: 50px;
  text-align: start;
  white-space: nowrap;
}

.navigation ul li:hover a::before,
.navigation ul li.hovered a::before {
  content: '';
  position: absolute;
  right: 0;
  top: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px 35px 0 10px var(--white);
  pointer-events: none;
}
.navigation ul li:hover a::after,
.navigation ul li.hovered a::after {
  content: '';
  position: absolute;
  right: 0;
  bottom: -50px;
  width: 50px;
  height: 50px;
  background-color: transparent;
  border-radius: 50%;
  box-shadow: 35px -35px 0 10px var(--white);
  pointer-events: none;
}

.main {
  position: absolute;
  width: calc(100% - 300px);
  left: 300px;
  min-height: 100vh;
  background: #ffffff;
  transition: 0.5s;
}
.main.active {
  width: calc(100% - 80px);
  left: 80px;
}
.topbar {
  width: 100%;
  height: 60px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 10px;
}
.toggle {
  position: relative;
  width: 60px;
  height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 2.5em;
  cursor: pointer;
}

.project-form {
  max-width: 600px;
  max-height: 1000px;
  margin: 50px auto;
  padding: 20px;
  background-color: var(--gray);
  border-radius: 10px;
}
.project-form h2 {
  text-align: center;
  margin-bottom: 20px;
}
.project-form label {
  display: block;
  margin-bottom: 5px;
}
.project-form input,
.project-form select {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 5px;
  border: 1px solid var(--blue);
}
.project-form .buttons {
  display: flex;
  justify-content: space-between;
}
.project-form button {
  padding: 10px 20px;
  background-color: var(--blue);
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.project-form button:hover {
  background-color: var(--black1);
}
.close-btn {
  position: absolute;
  top: 120px; 
  right: 380px;
  background-color: rgb(202, 112, 112);
  color: white;
  font-size: 20px;
  font-weight: bold;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none; 
  text-align: center;
  cursor: pointer;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
  transition: all 0.3s ease; 
  border: 2px solid red; 
}

.close-btn:hover {
  background-color: darkred;
  transform: scale(1.1); 
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); 
}

.close-btn:active {
  transform: scale(1); 
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
}
    </style>
</head>
<body data-user-id="<?php echo $_SESSION['id']; ?>"> 
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <div class="logo">
                            <img src="Logo.png" alt="Logo">
                        </div>
                        <span class="tittle1">MEEA</span>
                    </a>
                </li>
                <li><a href="\codding-community-platform\Home\home.php"><ion-icon name="home-outline"></ion-icon></span><span class="tittle">Faqja Kryesore</span></a></li>
                <li><a href="\codding-community-platform\Home\Profili\profili.php"><span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span><span class="tittle">Profili</span></a></li>
                <li><a href="\codding-community-platform\Home\grupetEMia\grupet-e-mia.php"><span class="icon"><ion-icon name="people-outline"></ion-icon></span><span class="tittle">Grupet e mia</span></a></li>
                <li><a href="#"><span class="icon"><ion-icon name="help-outline"></ion-icon></span><span class="tittle">Help</span></a></li>
                <li><a href="#"><span class="icon"><ion-icon name="settings-outline"></ion-icon></span><span class="tittle">Settings</span></a></li>
                <li><a href="\codding-community-platform\Home\logout.php"><span class="icon"><ion-icon name="log-out-outline"></ion-icon></span><span class="tittle">Sign out</span></a></li>
            </ul>
        </div>

        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>

            <div class="project-form">
                <a href="/codding-community-platform/Home/home.php" class="close-btn">X</a>

                <h2>Krijoni Grupin</h2>

                <label for="projectName">Emri i Grupit:</label>
                <input type="text" id="projectName" placeholder="Shkruani emrin e grupit">

                <label for="projectType">Tipi i Grupit:</label>
                <select id="projectType">
                    <option value="software">Software</option>
                    <option value="design">Design</option>
                    <option value="marketing">Marketing</option>
                    <option value="research">Research</option>
                </select>

                <label for="projectMembers">Shtoni Anëtarët:</label>
                <input type="text" id="projectMembers" placeholder="Emrat e anëtarëve (presi me presje)">

                <label for="privacy">Privatësia:</label>
                <select id="privacy">
                    <option value="public">Publik</option>
                    <option value="private">Privat</option>
                </select>

                <div class="buttons">
                    <button id="createBtn">Krijo</button>
                    <button id="deleteBtn">Fshi</button>
                </div>
            </div>

            <div id="error-message" style="color: red; display: none;">
                Ju lutem plotësoni të gjitha fushat!
            </div>
        </div>
    </div>
    <script src="krijimGrupi.js"></script>
  
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>