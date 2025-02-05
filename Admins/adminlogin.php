<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Admins/login.css">
    <script src="https://kit.fontawesome.com/1270dba9e7.js" crossorigin="anonymous"></script>
    <title>Admin Log-In</title>
</head>
<body>
<div class="container" id="container">
    <!-- Form për hyrje -->
    <div class="form-container sign-in-container">
        <form action="adminlogin_info.php" method="POST" id="loginForm">
            <h1>Hyr</h1>
            <div class="social-container">
                <div class="google-login">
                    <a href="#" class="google-login">
                        <i class="fab fa-google-plus-g"></i>
                        <span>Hyr përmes Google</span>
                    </a>
                </div>
            </div>
            <h2>ose me kredencialet e tua</h2>
            <input type="hidden" name="action" value="login">
            <input type="email" name="email" placeholder="E-mail" required><br>
            <input type="password" name="password" placeholder="Fjalëkalimi" required><br>
            <div class="login-options">
                <div class="rememberme">
                    <label class="remember-me">
                        <input type="checkbox"> <small>Mbaj mend</small>
                    </label>
                </div>
                <div class="forgotpassword">
                    <a href="#" class="forgot-password"><small>Keni harruar fjalëkalimin?</small></a>
                </div>
            </div>
            <button type="submit" id = "loginButton">Hyr</button>
        </form>
    </div>
    <div class="overlay-panel overlay-right">
        <h1>Mirë se erdhët, Admin!</h1>
        <p>Hyni me kredencialet tuaja në të majtë për të administruar platformën.</p>
    </div>
</div>

</body>
</html>
