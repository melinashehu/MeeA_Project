<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginstyle.css">
    <script src="https://kit.fontawesome.com/1270dba9e7.js" crossorigin="anonymous"></script>
    <title>Regjistrohu</title>
</head>
<body>
<div id="toast"></div>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="../Backend/Regjistrimi/register.php" method="POST" id="registerForm">
            <h1>Krijo llogari</h1>
            <div class="social-container">
                <div class="google-login">
                    <a href="#" class="google-login">
                        <i class="fab fa-google-plus-g"></i>
                        <span>Hyr përmes Google</span>
                    </a>
                </div>
            </div>
            <span>ose me kredencialet e tua</span>
            <input type="text" name="name" id="name" placeholder="Emri" required>
            <input type="email" name="email" id="email" placeholder="E-mail" required>
            <input type="password" name="password" id="password" placeholder="Fjalëkalim" required>
            <button type="submit" id="register">Regjistrohu</button>
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form action="../Backend/Hyrja/login_info.php" method="POST" id="loginForm">
            <h1>Hyr</h1>
            <div class="social-container">
                <div class="google-login">
                    <a href="#" class="google-login">
                        <i class="fab fa-google-plus-g"></i>
                        <span>Hyr përmes Google</span>
                    </a>
                </div>
            </div>
            <span>ose me kredencialet e tua</span>
            <input type="hidden" name="action" value="login">
            <input type="email" placeholder="E-mail" id="email" name="email" required><br>
            <input type="password" placeholder="Fjalëkalimi" id="password" name="password" required><br>
            <div class="login-options">
                <div class="rememberme">
                    <label class="remember-me">
                        <input type="checkbox" method="POST" id="remember"> <small>Mbaj mend</small>
                    </label>
                </div>
                <div class="forgotpassword">
                    <a href="#" class="forgot-password"><small>Keni harruar fjalëkalimin?</small></a>
                </div>
            </div>
            <button type="submit" id="login">Hyr</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <div class="logo">
                    <img src="logo.meea.png" alt="Logo">
                </div>

                <h1>Përshëndetje!</h1>
                <p>Nëse keni një llogari ekzistuese ju lutem hyni me kredencialet tuaja.</p>
                <button class="ghost" id="signIn">Hyr</button>
            </div>
            <div class="overlay-panel overlay-right">
                <div class="logo">
                    <img src="logo.meea.png" alt="Logo">
                </div>
                <h1>Mirë se erdhët!</h1>
                <p>Krijo një llogari dhe njihu me miqtë e tu të teknologjisë.</p>
                <button class="ghost" id="signUp">Regjistrohu</button>
            </div>
        </div>
    </div>
</div>

<script src="loginscript.js"></script>

</body>
</html>