<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEEA | Settings</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
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
            background-color: var(--white);
        }
        .container {
            display: flex;
        }
        .navigation {
            position: fixed;
            width: 300px;
            height: 100%;
            background: var(--blue);
            transition: 0.5s;
            
        }
        .navigation ul {
            list-style: none;
            padding: 20px 0;
        }
        .navigation ul li {
            padding: 15px 20px;
            border-radius: 10px;
            margin: 5px 0;
        }
        .navigation ul li a {
            display: flex;
            align-items: center;
            color: var(--white);
            text-decoration: none;
        }
        .navigation ul li:hover {
            background: var(--white);
        }
        .navigation ul li:hover a {
            color: var(--blue);
        }
        .navigation ul li .icon {
            margin-right: 10px;
            font-size: 1.5em;
        }
        .main {
            margin-left: 320px;
            padding: 20px;
            width: calc(100% - 320px);
        }
        .section {
            margin-bottom: 20px;
            padding: 20px;
            background: var(--gray);
            border-radius: 10px;
            display: none; 
        }
        .section h2 {
            margin-bottom: 10px;
        }
        button {
            margin: 5px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background: var(--blue);
            color: var(--white);
        }
        button:hover {
            background: var(--black1);
        }
        select, input {
            margin: 5px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid var(--black2);
            border-radius: 5px;
        }
        form button {
            margin-top: 10px;
            width: 100%;
            background: var(--blue);
        }
        .content {
            display: block;
        }
    </style>
</head>
<body>
<div class="container">
    
    <nav class="navigation">
        <ul>
            <li><a href="#" onclick="showSection('appearance')"><div class="icon"></div><div class="tittle">Appearance</div></a></li>
            <li><a href="#" onclick="showSection('language')"><div class="icon"></div><div class="tittle">App Language</div></a></li>
            <li><a href="#" onclick="showSection('tos')"><div class="icon"></div><div class="tittle">Terms of Service</div></a></li>
            <li><a href="#" onclick="showSection('privacy')"><div class="icon"></div><div class="tittle">Privacy Policy</div></a></li>
            <li><a href="#" onclick="showSection('analytics')"><div class="icon"></div><div class="tittle">Analytics</div></a></li>
            <li><a href="#" onclick="showSection('change-password')"><div class="icon"></div><div class="tittle">Change Password</div></a></li>
        </ul>
    </nav>

    <div class="main">
        <div id="appearance" class="section content">
            <h2>Appearance</h2>
            <p>Select a theme:</p>
            <button onclick="setTheme('light')">Light</button>
            <button onclick="setTheme('dark')">Dark</button>
        </div>

        <div id="language" class="section content">
            <h2>App Language</h2>
            <p>Select your preferred language:</p>
            <select id="language-select" onchange="changeLanguage()">
                <option value="en">English</option>
                <option value="sq">Shqip</option>
            </select>
        </div>

        <div id="tos" class="section content">
            <h2>Terms of Service</h2>
            <p>By using this application, you agree to our terms of service. Please read the following carefully:</p>
            <ul>
                <li>You must be at least 13 years old to use this service.</li>
                <li>Your data will be used to provide the best possible experience.</li>
                <li>You may not use the service for illegal activities.</li>
                <li>We reserve the right to change these terms at any time.</li>
                <li>By accepting, you acknowledge that you understand these terms.</li>
            </ul>
            <button onclick="acceptTerms()">I Accept</button>
        </div>

        <div id="privacy" class="section content">
            <h2>Privacy Policy</h2>
            <p>Your privacy is important to us. This policy outlines how we collect, use, and protect your data:</p>
            <ul>
                <li>We collect your personal information such as email, username, and browsing behavior.</li>
                <li>We may use cookies to enhance your experience and track usage patterns.</li>
                <li>Your data is stored securely and will not be shared with third parties without your consent.</li>
                <li>You can request to view, modify, or delete your personal data at any time.</li>
                <li>We may update this policy periodically. You will be notified of any changes.</li>
            </ul>
            <button onclick="acceptPrivacyPolicy()">I Accept</button>
        </div>

        <div id="analytics" class="section content">
            <h2>Analytics</h2>
            <p>View the usage statistics of the app:</p>
            <ul>
                <li>Active Users: 1234</li>
                <li>Total Sessions: 5000</li>
                <li>App Usage Time: 2 hours per session (avg.)</li>
                <li>Most Popular Feature: Analytics</li>
            </ul>
            <button onclick="viewAnalytics()">View Detailed Analytics</button>
        </div>

        <div id="change-password" class="section content">
            <h2>Change Password</h2>
            <form id="password-form" onsubmit="changePassword(event)">
                <label for="current-password">Current Password:</label>
                <input type="password" id="current-password" required>
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" required>
                <button type="submit">Change Password</button>
            </form>
        </div>
    </div>
</div>

<script>
    function showSection(section) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(sec => {
            sec.classList.remove('content');
        });

        const activeSection = document.getElementById(section);
        activeSection.classList.add('content');
    }

    function setTheme(theme) {
        if (theme === 'dark') {
            document.body.style.backgroundColor = '#333';
            document.body.style.color = '#050505';
            document.documentElement.style.setProperty('--blue', '#a0c4d7');
            document.documentElement.style.setProperty('--white', '#1c1c1c');
        } else {
            document.body.style.backgroundColor = '#c6e7df';
            document.body.style.color = '#333';
            document.documentElement.style.setProperty('--blue', '#58a390');
            document.documentElement.style.setProperty('--white', '#c6e7df');
        }
    }

    function changeLanguage() {
        const lang = document.getElementById("language-select").value;
        if (lang === 'sq') {
            alert('Shqip language selected.');
        } else {
            alert('English language selected.');
        }
    }

    function changePassword(event) {
        event.preventDefault();  
        const currentPassword = document.getElementById('current-password').value;
        const newPassword = document.getElementById('new-password').value;

        if (currentPassword && newPassword) {
            alert('Password changed successfully.');
        } else {
            alert('Please fill in both fields.');
        }
    }

    function acceptTerms() {
        alert('You have accepted the Terms of Service.');
    }

    function acceptPrivacyPolicy() {
        alert('You have accepted the Privacy Policy.');
    }

    function viewAnalytics() {
        alert('Viewing detailed analytics...');
    }
</script>
</body>
</html>
