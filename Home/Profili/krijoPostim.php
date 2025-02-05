<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();

$userId = $_SESSION['id'];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MEEA | Faqja Kryesore</title>
    <link rel="stylesheet" href="home.css">
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
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
    right: 50px; 
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
        .post-header h3{
      display:inline-flex;
      width:100%;
      margin:30px 50px;
    } 

   
    .post-options-list {
        list-style: none; 
        display: flex; 
        padding: 0; 
        margin:35px 50px; 
        border-bottom: 2px solid #ddd; 
        text-decoration: none;
        text-emphasis: none;
    }
    
    .post-options-list li {
        margin-right: 50px; 
        font-size: 16px; 
        position: relative; 
        text-decoration: none;
    }
    
    .post-options-list li a {
        text-decoration: none; 
        color: #000; 
        font-weight: bold; 
        transition: background-color 0.3s, color 0.3s;
        
    }
    
    .post-options-list li.active a {
        background-color: #007BFF; 
        color:#fff;
    }
    
    .post-options-list a:hover {
        background-color: #f0f0f0; 
    }
    

    #post-title{
       margin: 20px 50px; 
       max-width: 800px;
       padding:10px;
       border-radius: 10px;
       font-size: 15px;
    }
    
    
    .post-box {
        margin: 20px;
        max-width: 800px;
        margin: auto;
        font-family: Arial, sans-serif;
        position: relative;
        padding-bottom:50px;
    }

    
    .ql-dropdown {
        z-index: 1002; 
    }

    #formatting-toolbar{
        margin:5px;
        padding:10px;
        position: relative;
        box-sizing: border-box;
        border: 1px solid #807878;
        border-radius: 8px;
        background-color: white;
        bottom:-40px;
        left:50px;
        width:795px;
        z-index:1001;
    }

    .text-container{
        height:300px;
        z-index: 1000; 
        
    }

    .image-container{
        height:300px;
        z-index: 1000; 
        
    }

    .link-container{
        height:200px;
        z-index: 1000; 
        
    }
    #text-editor-container{
        height:150px;
        border: 1px solid #807878;
        border-radius: 8px;
        margin: 45px 50px;
        background-color: #fff;
        white-space: pre-wrap;
        overflow-wrap: break-word; 
        box-sizing: border-box;
        overflow-y: auto;
        resize:none;
        line-height:1.5;
        max-width: 800px;
    }

    #text-editor-container .ql-editor.ql-blank::before{
        font-family: "Ubuntu", sans-serif;
        font-size:16px;
        font-style:normal;
    }

    #image-editor-container{
        height:150px;
        border: 1px solid #807878;
        border-radius: 8px;
        margin: 45px 50px;
        background-color: #fff;
        box-sizing: border-box;
        resize:none; 
        max-width: 800px;
    }

    #image-videos-upload{
        position:relative;
        bottom:145px;
        left:350px;
    }

    #url-input{
        max-width:800px;
        width:800px;
        height:50px;
        margin: 20px 50px;
        border: 1px solid #807878;
        border-radius: 8px;
        box-sizing: border-box;
        resize:none;
    }

    #postTextBtn,#postImageBtn,#postLinkBtn{
        position: relative;
        border: 3px solid #7f7878;
        border-radius: 10px;
        padding:8px;
        background-color: #fff;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        color:black;
    }

    #postTextBtn{
        bottom:25px;
        left:800px;
    }

    #postImageBtn{
        bottom:25px;
        left:535px;
    }

    #postLinkBtn{
        top:60px;
        right:105px;
    }
    
    #postTextBtn:hover,#postImageBtn:hover,#postLinkBtn:hover{
        background-color: #a4a3a3;
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
                    <a href="profili.php">
                        <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                        <span class="tittle">Profili</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"> <ion-icon name="people-outline"></ion-icon></span>
                        <span class="tittle">Grupet e mia</span>
                    </a>
                </li>
   
                <li>
                    <a href="#">
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
                    <a href="../../Home/logout.php">
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
                    <div class="reklame">
                        <span class="reklameIkon">
                        <ion-icon name="card-outline"></ion-icon>
                    </span>
                    </div>
                </a>
                 <a href="#">
                   <div class="view-profile">
                        <span class="view-profile-icon">
                            <img src="user-profile.png" id="view-profile-img" alt="Klikoni për të parë profilin tuaj." title="Hapni menu-në e profilit.">
                        </span>
                    <div class="view-profile-menu" id="profile-menu">
                        <div class="view-profile-menu-icon">
                            <img src="user-profile.png" alt="Kjo është fotoja e profilit.">
                            <h3>Username</h3>
                        </div>
                        <hr>

                        <a href="#" class="profile-menu-list" id="select-theme">
                            <ion-icon name="moon-outline"></ion-icon>
                            <p>Modaliteti i errët</p>
                            <span>></span>
                        </a>

                        <a href="#" class="profile-menu-list">
                            <ion-icon name="pricetags-outline"></ion-icon>
                            <p>Reklamoni llogarinë tuaj</p>
                            <span>></span>
                        </a>

                        <a href="../../Home/settings.php" class="profile-menu-list">
                            <ion-icon name="settings-outline"></ion-icon>
                            <p>Settings</p>
                            <span>></span>
                        </a>

                        <a href="../../Home/logout.php" class="profile-menu-list">
                            <ion-icon name="log-out-outline"></ion-icon>
                            <p>Dilni jashtë faqes</p>
                            <span>></span>
                        </a>
                    </div>
                        
                </div>
                </a>
            </div>
            
           </div>
        <div class="create-post-container">
            <span class="post-header">
                <h3>Krijoni një postim</h3>
            </span>
            

            <div class="post-options">
                <ul class="post-options-list">
                    <li> <a href="#" onclick="showContainer('text-container')">Tekst</a> </li>
                    <li> <a href="#" onclick="showContainer('image-container')">Imazhe & Vidjo</a> </li>
                    <li> <a href="#" onclick="showContainer('link-container')" >Link</a> </li>
                </ul>
            </div>

                <div class="post-title-box">
                    <textarea id="post-title" name="title" rows="2" cols="200" maxlength="500" placeholder="Shkruani titullin:" required></textarea>
                </div>
            
                <div class="text-container">
                    <div id="formatting-toolbar">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                        <select class="ql-header">
                            <option selected></option>
                            <option value="1">Heading 1</option>
                            <option value="2">Heading 2</option>
                        </select>
                        <button class="ql-link"></button>
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                    </div>
            
                    <div id="text-editor-container" placeholder="Shkruani tekstin:"></div>
                    <button type="submit" id="postTextBtn" class="postBtn">Posto</button>
                </div>
            
                <div class="image-container" style="display:none">
                    <div id="image-editor-container" placeholder="Hidhni imazhe ose vidjo:"></div>
                    <input type="file" id="image-videos-upload" accept="image/*, video/*" name="file">
                    <button type="submit" id="postImageBtn" class="postBtn">Posto</button>
                </div>
            
                <div class="link-container" style="display:none">
                    <div id="link-editor-container"></div>
                    <input type="url" id="url-input" name="content" placeholder="Jepni URL-në e linkut:" required>
                    <button type="submit" id="postLinkBtn" class="postBtn">Posto</button>
                </div>
            
            </div>
        </div>
    
        
     </div>
         <script src="home.js"></script>
         <script src="userprofile.js"></script>
         <script src="post-handler.js"></script>
         <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
          <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
          <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    
        
        <script>
          const quill = new Quill('#text-editor-container', {
        theme: 'snow',
        modules: {
            toolbar: '#formatting-toolbar'
        },
        placeholder: 'Shkruani tekstin:'
        });
        </script>

         <script>
            function showContainer(containerName) {
                const containers = ['text-container', 'image-container', 'link-container'];
                containers.forEach(container => {
                    const element = document.querySelector(`.${container}`);
                    element.style.display = container === containerName ? 'block' : 'none';
                });
                localStorage.setItem('selectedSection', containerName);
            }
        
            window.onload = function() {
                const savedSection = localStorage.getItem('selectedSection');
        
            
                if (savedSection) {
                    showContainer(savedSection);
            
                } else {
                    showContainer('text-container');
                }
            }

          </script>
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
    </body>
</html>