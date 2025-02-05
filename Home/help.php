<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEEA | Help</title>
    <link rel="stylesheet" href="home.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #ffffff;
        }

        .navigation {
            width: 300px;
            background-color: #58a390;
            color: white;
            padding: 1rem 0;
            position: fixed;
            height: 100vh;
        }

        .navigation ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .navigation ul li {
            padding: 1rem;
            text-align: left;
        }

        .navigation ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .navigation ul li a .tittle {
            margin-left: 10px;
        }

        .navigation ul li.hovered {
            background-color: #4a8674;
        }

        .main {
            margin-left: 100px;
            padding: 2rem;
            flex-grow: 1;
        }
        .main h2{
            margin-top: 50px;
        }
        .main ul li{
            margin-top: 10px;
        }
        h2 {
            color: #58a390;
        }

        ul {
            padding-left: 1.5rem;
        }

        footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #58a390;
    color: white;
    text-align: center;
    padding: 0.5rem 0;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    font-size: 0.9rem;
}


        a {
            color: #58a390;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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
                            <img src="../Home/Profili/Logo.meea.png" alt="Logo">
                        </div>
                        <span class="tittle1">MEEA</span>
                    </a>
                </li>
                <li>
                    <a href="../Home/home.php">
                        <span class="icon"> <ion-icon name="home-outline"></ion-icon></span>
                        <span class="tittle">Faqja Kryesore</span>
                    </a>
                </li>
                <li>
                    <a href="Profili/profili.php?user_id=<?php echo $_SESSION['id']; ?>">
                        <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <span class="tittle">Profili</span>
                    </a>
                </li>
                <li>
                    <a href="\codding-community-platform\Home\grupetEMia\grupet-e-mia.php">
                        <span class="icon"> <ion-icon name="people-outline"></ion-icon></span>
                        <span class="tittle">Grupet e mia</span>
                    </a>
                </li>
                <li>
                    <a href="help.php">
                        <span class="icon"> <ion-icon name="help-outline"></ion-icon></span>
                        <span class="tittle">Help</span>
                    </a>
                </li>
                <li>
                    <a href="settings.php">
                        <span class="icon"> <ion-icon name="settings-outline"></ion-icon></span>
                        <span class="tittle"> Settings</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <span class="icon"> <ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="tittle">Sign out</span>
                    </a>
                </li>
            </ul>
            </div>
    </div>

    <div class="main">
        <h2>Manual përdorimi për platformën!</h2>
        <p>Mirë se erdhët në platformë! Ndiqni hapat e mëposhtme për të përdorur platformën:</p>
        <ul>
            <li><strong>Hyrja:</strong> Krijoni një profil në register form dhe përdorni kredencialet tuaja për të hyrë.</li>
            <li><strong>Krijimi grupeve:</strong> Krijoni grupe ose bashkohuni me grupet e interesit tuaj.</li>
            <li><strong>Postime:</strong> Shpërndani idetë tuaja ose bëni pyetje nëpërmjet postimeve.</li>
        </ul>
        
        <h2>Pyetje të shpeshta</h2>
        <p>Këtu gjeni disa përgjigje për pyetje më të shpeshta:</p>
        <ul>
            <li><strong>Si ta ndryshoj fjalëkalimin?</strong> Shkoni në formën e hyrje, klikoni "Keni harruar fjalëkalimin?" dhe ndiqni instruksionet.</li>
            <li><strong>Si mund të ndryshoj të dhënat e mia?</strong> Shkoni në hapësirën "Settings" për të parë dhe ndryshuar të dhënat ose preferencat tuaja.</li>
            <li><strong>Si mund t'ju kontaktoj?</strong> Për çdo pyetje apo mesazh mund të kontaktoni në e-mailin <a href="mailto:meeanoreply@gmail.com">meeanoreply@gmail.com</a></li>
        </ul>
    </div>
    <footer>
        <p>&copy; 2025 MEEA Codding Community Platform. Të gjitha të drejtat e rezervuara.</p>
    </footer>
</body>
</html>
