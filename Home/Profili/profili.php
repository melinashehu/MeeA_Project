<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();


    if(!isset($_SESSION['id'])){
        header("Location: /codding-community-platform/Log-In/login.php");
        exit;
    }

    $userId = $_SESSION['id'];  
    $name = $_SESSION['name'];  
    $allowed = array('jpg', 'jpeg', 'png');

    $imagePath = "../../uploads/profile-pictures/user-profile.png"; 

    $stmt = mysqli_prepare($connection, "SELECT image_path, picture_status FROM profile_pictures WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    $resultImg = mysqli_stmt_get_result($stmt);

    
    if ($resultImg && mysqli_num_rows($resultImg) > 0) {
        $rowImg = mysqli_fetch_assoc($resultImg);
    
        if ($rowImg['picture_status'] == 0 && !empty($rowImg['image_path'])) {
            $fileExtension = pathinfo($rowImg['image_path'], PATHINFO_EXTENSION);
    
            if (in_array(strtolower($fileExtension), $allowed)) {
                $imagePath = "../../uploads/profile-pictures/profile".$userId.".".$fileExtension;
            }
        }
    }
     $linkedinUsername = '';
     $githubUsername = '';
     $mailUsername = '';
     
     $query = "SELECT linkedin_username, github_username, mail_username FROM user_contact_links WHERE user_id = ?";
     $stmt = mysqli_prepare($connection, $query);
     
     if ($stmt) {
         mysqli_stmt_bind_param($stmt, 'i', $userId);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         
         if ($result && $row = mysqli_fetch_assoc($result)) {
             $linkedinUsername = $row['linkedin_username'] ?? '';
             $githubUsername = $row['github_username'] ?? '';
             $mailUsername = $row['mail_username'] ?? '';
         }
         
         mysqli_stmt_close($stmt);
     } else {
         error_log("Failed to prepare statement: " . mysqli_error($connection));
     }

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MEEA | Profili</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="modal.css">
    <style>

        .search{
            position: relative;
            width: 400px;
            margin: 0 auto;
        }
        .search label{
            position: relative;
            width: 100%;
            right:50px;
        }
        .search label input{
            width: 100%;
            height: 40px;
            border-radius: 40px;
            padding: 5px 20px;
            padding-left: 35px;
            font-size:18px ;
            outline: none;
            border: 1px solid var(--black2);
        }
        .search label ion-icon{
            position: absolute;
            top: 20px;
            left: 10px;
            font-size: 1.2em;
        }
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
    background-color: #fff;
    transition: 0.5s;
}
.main.active{
    width: calc(100%-80px);
    left: 80px;
}
.premium {
    top: 10px;
    width: 40px; 
    height: 40px; 
    border-radius: 50%; 
    overflow: hidden;
    background-color: #ecf0f1;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    position: fixed;
    bottom: 550px; 
    right: 100px; 
    display: flex;
    flex-direction: column;
    align-items: right;
    text-align: center;
    gap: 5px;
    cursor: pointer;
    z-index: 1000;
}
.premiumIkon ion-icon {
    position: relative;
    font-size: 30px; 
}
    .view-profile {
    
    position: fixed; 
    cursor: pointer;
    top: 12px;
    right: 20px; 
    width: 40px;
    height: 40px;
    display: inline-block;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    z-index: 1000;
}

#view-profile-img {
    width: 40px; 
    height: 40px;
    border-radius: 50%; 
    object-fit: cover; 
    margin-right:50px;
}

.view-profile-menu{
    position:absolute;
    top:100%;
    right:8%;
    width:250px;
    background:#fff;
    padding:20px;
    margin:10px;
    display:none;
    border-radius: 5px;
}

.view-profile-menu .view-profile-menu-icon{
  display:flex;
  align-items: center;
}

.view-profile-menu-icon h3{
   font-weight:500;
   color:black;
   text-decoration: none;
   border:none;
  }


.view-profile .view-profile-menu-icon a {
    text-decoration: none; 
}

.view-profile-menu-icon a:hover {
    text-decoration: none; 
}

.view-profile-menu .view-profile-menu-icon img{
    width:35px;
    border-radius:50%;
    object-fit: cover;
    margin-right:8px;
}

.view-profile-menu hr{
    border:0;
    height:1px;
    width:100%;
    background-color:#58a390;
    margin:8px 2px 15px;
 }

.profile-menu-list{
    display:flex;
    align-items:center;
    text-decoration: none;
    color:black;
    margin:18px 0;
}

.profile-menu-list p{
    width:100%;
}

.profile-menu-list ion-icon{
    width:50px;
    border-radius:50px;
    background: #c6e7df;
    padding:8px;
    margin-right:8px;
}

.profile-menu-list span{
    font-size:20px;
    transition:transform(0.5s);
}

.profile-menu-list:hover span{
    font-size:20px;
    transform:translateX(5px);
}

.profile-menu-list:hover p{
    font-weight:500;
}

.main-content {
    padding: 20px;
    width:100%;
}

.user-profile {
    display:flex;
    flex-direction:column;
    align-items: left;
    gap:16px;
}

.profile-header{
    display:flex;
    align-items: center;
    gap:16px;
}

.user-picture img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 2px solid #ddd;
    transition: all 0.3s ease-in-out;
}

.user-picture label{
    display:block;
    align-items:center;
    gap:5px;
    padding:6px 8px;
    background-color: #64b19e;
    color:white;
    border:none;
    border-radius:4px;
    font-size:14px;
    cursor:pointer;
    font-weight: bold;
    transition: background-color 0.3s;
    margin-top:5px;
}

.user-picture:hover label{
    background-color: #539786;
}

.user-picture label ion-icon{
    margin-left:2px;
    font-size:15px;
    margin-top:2px;
}

.user-details {
    text-align: left; 
}

.user-about {
    width: 100%; 
    text-align: left; 
}

.user-about-container h3 {
    margin-bottom: 8px; 
}

#user-info {
    width: 90%; 
    min-height:100px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    outline: none;
    resize:vertical;
}

#user-info:focus {
    border-color: #6c9c68; 
    box-shadow: 0 0 4px rgba(69, 154, 66, 0.5);
}

.edit-profile-btn {
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:5px 8px;
    background-color: #64b19e;
    color:white;
    border:none;
    border-radius:4px;
    font-size:14px;
    cursor:pointer;
    font-weight: bold;
    transition: background-color 0.3s;
 
}

#save-about-btn {
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:5px 8px;
    margin-top:20px;
    background-color: #64b19e;
    color:white;
    border:none;
    border-radius:4px;
    font-size:14px;
    cursor:pointer;
    font-weight: bold;
    transition: background-color 0.3s;
 
}
#save-about-btn:hover {
    background-color: #539786;
}

.add-icon {
    font-size: 18px; 
}

.user-contact-links{
    margin-top: 8px;
    padding:10px 0;
}

.contact-list{
    margin:0;
    padding:0;
    display:flex;
    list-style-type:none;
}

.contact-link{
    display:flex;
    align-items:center;
    text-decoration: none;
    color: #4ab17f;
    font-size: 30px;
    margin-right:30px; 
}

.contact-link:last-child{
    margin-right:0;
}

.contact-link:hover{
    text-decoration:underline;
    color:#539786;
}

.contact-link ion-icon{
    margin-right:15px;
    font-size:30px;
}

.user-contact-links h3{
    font-size:18px;
    font-weight: bold;
    margin-bottom:10px;
}

.contact-list span{
    font-size:15px;
    text-decoration: none;
    padding:5px;
    margin-right:50px;
}
.comment-section{
    padding:20px 0;
    margin-top:20px;
}

.create-post{
    display:flex;
    align-items: center;
}

.create-post-btn{
    display:inline-flex;
    align-items:center;
    margin:1px;
    gap:5px;
    padding:5px 8px;
    background-color: #64b19e;
    color:white;
    border:none;
    border-radius:4px;
    font-size:14px;
    cursor:pointer;
    font-weight: bold;
    transition: background-color 0.3s;
    border-radius: 10px;
}

.create-post-btn:hover {
    background-color: #539786;
}

.create-post-btn ion-icon{
    margin-left: 5px;
    font-size:22px;
}

.comment-section .underline {
    width: 100%;
    height: 2px;
    background-color:#5aa793; 
    margin-top: 10px; 
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
                                <img src="logo.meea.png" alt="Logo">
                            </div>
                        </span>
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
                    <a href="#">
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
                    <a href="../help.php">
                        <span class="icon"> <ion-icon name="help-outline"></ion-icon></span>
                        <span class="tittle">Help</span>
                    </a>
                </li>
                <li>
                    <a href="../../Home/settings.php">
                        <span class="icon"> <ion-icon name="settings-outline"></ion-icon></span>
                        <span class="tittle"> Settings</span>
                    </a>
                </li>
                
                
                <li>
                    <a href="\codding-community-platform\Home\logout.php">
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
                <div class="search">
                    <label >
                        <form action="https://www.google.com/search" method="GET">
                        <input type="text" name="q" placeholder="Search through Google..." required>
                        <ion-icon name="search-outline"></ion-icon>
                        </form>
                     </label>
                </div>
                <div class="right-icons">
                <a href="../../stripe_initialization.php">
                    <div class="premium">
                        <span class="premiumIkon"><ion-icon name="card-outline"></ion-icon></span>
                    </div>
                </a>
                 <a href="#">
                   <div class="view-profile">
                        <span class="view-profile-icon">
                            <img src="<?php echo $imagePath?>" id="view-profile-img" alt="Klikoni për të parë profilin tuaj." title="Hapni menu-në e profilit.">
                        </span>
                    <div class="view-profile-menu" id="profile-menu">
                        <div class="view-profile-menu-icon">
                            <img src="<?php echo $imagePath?>" alt="Kjo është fotoja e profilit.">
                            <h3><?php echo htmlspecialchars($name); ?></h3>
                        </div>
                        <hr>

                        <form action="save_display_mode.php" method="POST" id="theme-form">
                            <input type="hidden" name="theme" id="theme-input">
                            <a href="#" class="profile-menu-list" id="select-theme">
                                <ion-icon name="moon-outline"></ion-icon>
                                <p>Modaliteti i errët</p>
                                <span>></span>
                            </a>
                        </form>

                        <a href="#" class="profile-menu-list">
                            <ion-icon name="pricetags-outline"></ion-icon>
                            <p>Reklamoni llogarinë tuaj</p>
                            <span>></span>
                        </a>

                        <a href="#" class="profile-menu-list" id="add-link">
                            <ion-icon name="link-outline"></ion-icon>
                            <p>Shtoni një link</p>
                            <span>></span>
                        </a>

                        <a href="../../Home/settings.php" class="profile-menu-list">
                            <ion-icon name="settings-outline"></ion-icon>
                            <p>Settings</p>
                            <span>></span>
                        </a>

                        <a href="\codding-community-platform\Home\logout.php" class="profile-menu-list">
                            <ion-icon name="log-out-outline"></ion-icon>
                            <p>Dilni jashtë faqes</p>
                            <span>></span>
                        </a>
                    </div>
                        
                </div>
                </a>
            </div>
        </div>
            <div class="main-content">
                <div class="user-profile">
                    <div class="profile-header">
                    <div class="user-picture">
                        <img src="<?php echo $imagePath?>" alt="User Profile Picture" id="profile-picture">

                        <form id="upload_form" action="upload_picture.php" method="POST" enctype="multipart/form-data">
                        <label for="input-file">
                            <ion-icon name="camera-outline"></ion-icon>
                            Ndryshoni foton
                        </label>
                        <input type="file" name="profile_picture" id="input-file" style="display:none" onchange="this.form.submit();" />
                        </form>
                    </div>
                    
                    <div class="user-details">
                        <h3 id="username"><?php echo htmlspecialchars($name); ?></h3>
                        <div class="edit-profile-container">
                            <button class="edit-profile-btn" id="edit-profile-btn">
                            <ion-icon name="add-outline" class="add-icon"></ion-icon>
                            Editoni profilin</button>
                        </div>
                    </div>
                </div>
                    <div class="user-about">
                        <div class="user-about-container">
                        <h3 id="about">Informacione mbi ju</h3>
                        <form id="about-form" action="save_user_about.php" method="POST">
                        <textarea id="user-info" name="about_text" placeholder="Ndani informacion për veten tuaj..."><?php 
                            
                            $aboutQuery = "SELECT about_text FROM user_about_information WHERE user_id = ?";
                            $stmtAbout = mysqli_prepare($connection, $aboutQuery);
                            mysqli_stmt_bind_param($stmtAbout, 'i', $userId);
                            mysqli_stmt_execute($stmtAbout);
                            $resultAbout = mysqli_stmt_get_result($stmtAbout);
                    
                            if ($resultAbout && $rowAbout = mysqli_fetch_assoc($resultAbout)) {
                                echo htmlspecialchars($rowAbout['about_text']);
                            }
                    
                            mysqli_stmt_close($stmtAbout);
                        ?></textarea>
                        
                        <button type="submit" class="edit-profile-btn" id="save-about-btn" name="save-about-info">Ruaj ndryshimet</button>
                    </form>

                        </div>
                    </div>
                    <div class="user-contact-links">
                        <h3 id="user-contact">Më kontaktoni në:</h3>
                        <ul class="contact-list">
                            <li>
                                <a href="https://www.linkedin.com/in/<?php echo htmlspecialchars($linkedinUsername); ?>" target="_blank" class="contact-link">
                                    <ion-icon name="logo-linkedin"></ion-icon>
                                    <span><?php echo $linkedinUsername ? '@'.$linkedinUsername : ''; ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/in/<?php echo htmlspecialchars($githubUsername); ?>" target="_blank" class="contact-link">
                                    <ion-icon name="logo-github"></ion-icon>
                                   <span><?php echo $githubUsername ? '@' . $githubUsername : ''; ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:<?php echo htmlspecialchars($mailUsername); ?>" class="contact-link">
                                    <ion-icon name="mail-outline"></ion-icon>
                                   <span><?php echo $mailUsername ? $mailUsername : ''; ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="comment-section">
                    <div class="create-post">
                        <a href="krijoPostim.php">
                        <button class="create-post-btn" id="create-post-btn">Krijoni një postim
                            <ion-icon name="add-outline"></ion-icon>
                        </button>
                        </a>
                    </div>
                    <div class="underline"></div>
                    
                </div>
            </div>
                  </div>

                   </div>

                <div id="link-modal" class="modal">
                    <div class="modal-content">
                        <h4>Shtoni një link:</h4>
                        <form id="link-form">
                            <label for="linkedin">LinkedIn Username:</label>
                            <input type="text" id="linkedin" name="linkedin">
                
                            <label for="github">GitHub Username:</label>
                            <input type="text" id="github" name="github">
                
                            <label for="mail">Email Username:</label>
                            <input type="text" id="mail" name="mail">
                
                            <button type="submit" id="save-links-btn">Ruaj</button>
                        </form>
                        <button id="close-modal">X</button>
                    </div>
                </div>

                    <script>
                     
                   function getThemeFromLocalStorage() {
                   return localStorage.getItem('theme');
               }
            
               
               const savedTheme = getThemeFromLocalStorage();
            
               
               const body = document.body;
               const icon = document.getElementById("select-theme").querySelector("ion-icon");
            
               if (savedTheme === 'dark') {
                   body.classList.add("dark-mode");
                   icon.setAttribute("name", "sunny-outline");
               } else {
                   body.classList.remove("dark-mode");
                   icon.setAttribute("name", "moon-outline");
               }
            
               document.getElementById('select-theme').addEventListener('click', function () {
                   const themeForm = document.getElementById('theme-form');
                   const themeInput = document.getElementById('theme-input');
            
                   const isDarkMode = body.classList.toggle("dark-mode");
                   const newTheme = isDarkMode ? "dark" : "light";
                   themeInput.value = newTheme;
            
                   icon.setAttribute("name", isDarkMode ? "sunny-outline" : "moon-outline");
            
                   
                   localStorage.setItem('theme', newTheme);
            
                   themeForm.submit();
               });
                               
                    </script>

                <script>
                    const maxInactivityTime = 900 * 1000;
                    let inactivityTimeout;
                
                    function resetInactivityTimeout() {
                        clearTimeout(inactivityTimeout);
                        inactivityTimeout = setTimeout(() => {
                            window.location.href = "/codding-community-platform/Log-In/login.php";
                        }, maxInactivityTime);
                    }
                
                    window.onload = resetInactivityTimeout;
                    window.onmousemove = resetInactivityTimeout;
                    window.onkeydown = resetInactivityTimeout;
                    window.onclick = resetInactivityTimeout;
                    window.onscroll = resetInactivityTimeout;
                
                    resetInactivityTimeout();
                </script>

                <script>
                
                    document.getElementById('edit-profile-btn').addEventListener('click', function() {
                        
                        window.location.href = '../../Home/settings.php';
                    });
                </script>

                   <script src="userprofile.js"></script>
                   <script src="home.js"></script>
                   <script src="user-links.js"></script>
                   <script src="about-form.js"></script>

    
          <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
          <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    

    </body>
</html>