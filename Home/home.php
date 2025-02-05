<?php
require_once __DIR__ . "/../Backend/Regjistrimi/db_connection.php";

session_start();

if (!isset($_SESSION['name'])) {
    header("Location: \codding-community-platform\Log-In\login.php");  
    exit();
}

$name = $_SESSION['name']; 
$userId = $_SESSION['id'];
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MEEA | Faqja Kryesore</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="Profili/postsStyling.css">

    <style>
        .search{
            position: relative;
            width: 400px;
            margin: 0 auto;
        }
        .search label{
            position: relative;
            width: 100%;
            right:150px;
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

        .paragrafi {
            font-family:'Times New Roman', Times, serif;
            text-shadow: none;
            color:rgb(23, 22, 22);
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: left;
            padding-left: 400px;
            margin-top: 50px;
            text-align: center;  
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
    </style>
    </head>
    <body>
        <div class="container">
            <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <div class="logo">
                            <img src="Profili/logo.meea.png" alt="Logo">
                        </div>
                        <span class="tittle1">MEEA</span>
                    </a>
                </li>
                <li>
                    <a href="#">
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
                <a href="../stripe_initialization.php">
                    <div class="premium">
                        <span class="premiumIkon"><ion-icon name="card-outline"></ion-icon></span>
                    </div>
                </a>
            </div>
            <div class="paragrafi">
                <h1>Përshëndetje, <?php echo htmlspecialchars($name); ?>!</h1><br><br><br>
                <p class="additional-text">Një ide e madhe bëhet më e fuqishme kur ndahet.</p>
            </div>

<?php
         
function displayComments($connection, $postId, $parentId = null) {
    
    $commentQuery = "
        SELECT c.id AS comment_id, c.content, u.name AS commenter, c.created_at
        FROM comments c
        INNER JOIN users u ON c.user_id = u.id
        WHERE c.post_id = $postId " . ($parentId ? "AND c.parent_id = $parentId" : "AND c.parent_id IS NULL") . "
        ORDER BY c.created_at ASC
    ";
    $commentResult = mysqli_query($connection, $commentQuery);

    if ($commentResult) {
        while ($comment = mysqli_fetch_assoc($commentResult)) {
            $commentId = $comment['comment_id'];

          
            $likeQuery = "SELECT COUNT(*) AS like_count FROM comments_likes WHERE comment_id = ?";
            $stmt = mysqli_prepare($connection, $likeQuery);
            mysqli_stmt_bind_param($stmt, 'i', $commentId);
            mysqli_stmt_execute($stmt);
            $likeResult = mysqli_stmt_get_result($stmt);
            $likeCount = mysqli_fetch_assoc($likeResult)['like_count'];

           
            $userId = $_SESSION['id'];
            $checkLikeQuery = "SELECT * FROM comments_likes WHERE user_id = ? AND comment_id = ?";
            $checkStmt = mysqli_prepare($connection, $checkLikeQuery);
            mysqli_stmt_bind_param($checkStmt, 'ii', $userId, $commentId);
            mysqli_stmt_execute($checkStmt);
            $checkLikeResult = mysqli_stmt_get_result($checkStmt);
            $hasLikedComment = mysqli_num_rows($checkLikeResult) > 0;

          
            echo "<div class='comment'>";
            echo "<p>{$comment['content']}</p>";
            echo "<p>Komentuar nga: {$comment['commenter']} në {$comment['created_at']}</p>";
            echo "<p>Likes: $likeCount</p>";

            if ($hasLikedComment) {
                echo "<form action='Profili/unlike_comment.php' method='POST'>
                        <input type='hidden' name='comment_id' value='$commentId'>
                        <button type='submit'>Unlike</button>
                      </form>";
            } else {
                echo "<form action='Profili/like_comment.php' method='POST'>
                        <input type='hidden' name='comment_id' value='$commentId'>
                        <button type='submit'>Like</button>
                      </form>";
            }

            echo "<form action='Profili/save_comment.php' method='POST'>
                    <textarea name='content' placeholder='Shtoni një koment...'></textarea>
                    <input type='hidden' name='post_id' value='$postId'>
                    <input type='hidden' name='parent_id' value='$commentId'>
                    <button type='submit'>Komento</button>
                  </form>";

        
            displayComments($connection, $postId, $commentId);

            echo "</div>";
        }
    }
}
?>

            
<section class="posts-container">
<?php
if (isset($_SESSION['success'])) {
    echo "<p>{$_SESSION['success']}</p>";
    unset($_SESSION['success']);
}

$query = "
    SELECT p.id AS post_id, p.title, p.content, p.type, p.media_path, u.name AS author, p.created_at
    FROM posts p
    INNER JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
";
$result = mysqli_query($connection, $query);

if ($result) {
    while ($post = mysqli_fetch_assoc($result)) {
        $postId = $post['post_id'];
        echo "<div class='post'>";
        echo "<h2>{$post['title']}</h2>";
        echo "<p>{$post['content']}</p>";

        if ($post['type'] === 'image' || $post['type'] === 'video') {
            echo "<img src='../uploads/posts/{$post['media_path']}' alt='Post media'>";
        }

        echo "<p>Postuar nga: {$post['author']} në {$post['created_at']}</p>";
     
        $likeQuery = "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = ?";
        $stmt = mysqli_prepare($connection, $likeQuery);
        mysqli_stmt_bind_param($stmt, 'i', $postId);
        mysqli_stmt_execute($stmt);
        $likeResult = mysqli_stmt_get_result($stmt);
        $likeCount = mysqli_fetch_assoc($likeResult)['like_count'];

        $userId = $_SESSION['id'];
        $checkLikeQuery = "SELECT * FROM post_likes WHERE user_id = ? AND post_id = ?";
        $checkStmt = mysqli_prepare($connection, $checkLikeQuery);
        mysqli_stmt_bind_param($checkStmt, 'ii', $userId, $postId);
        mysqli_stmt_execute($checkStmt);
        $checkLikeResult = mysqli_stmt_get_result($checkStmt);
        $hasLikedPost = mysqli_num_rows($checkLikeResult) > 0;

        echo "<p>Likes: $likeCount</p>";

        if ($hasLikedPost) {
            echo "<form action='Profili/unlike_post.php' method='POST'>
                    <input type='hidden' name='post_id' value='$postId'>
                    <button type='submit'>Unlike</button>
                  </form>";
        } else {
            echo "<form action='Profili/like_post.php' method='POST'>
                    <input type='hidden' name='post_id' value='$postId'>
                    <button type='submit'>Like</button>
                  </form>";
        }

        echo "<form action='Profili/save_comment.php' method='POST' enctype='multipart/form-data'>
                <textarea name='content' placeholder='Shtoni një koment...'></textarea>
                <input type='hidden' name='post_id' value='$postId'>
                <button type='submit'>Komento</button>
              </form>";

    
        echo "<div class='comments'>";
        displayComments($connection, $postId); 
        echo "</div>";

        echo "</div>";
    }
} else {
    echo "Nuk është bërë asnjë postim.";
}

mysqli_close($connection);
?>
</section>
        </div>

         <a href="KrijimGrupi/krijimGrupi.php">
            <div class="add-group-container">
                <div class="circle-btn">+</div>
                <span class="btn-text">Krijo grup</span>
            </div>
         </a>


         </div>

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
         <script src="home.js"></script>
         <script src="post-handler.js"></script>
         <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
         <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    </body>
</html>