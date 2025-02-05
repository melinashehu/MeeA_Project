<?php
require_once __DIR__ . "/../../Backend/Regjistrimi/db_connection.php";
session_start();
$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    
    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                
                $fileNameNew = "profile".$id.".".$fileActualExt;
                $fileDestination = '../../uploads/profile-pictures/'.$fileNameNew;

            
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    
                    $imagePath = '../../uploads/profile-pictures/'.$fileNameNew;

                    $sql = "SELECT * FROM profile_pictures WHERE user_id = '$id'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        
                        $row = mysqli_fetch_assoc($result);
                        
                        if ($row['image_path'] != $imagePath) { 
                            $sql = "UPDATE profile_pictures SET image_path = '$imagePath', picture_status = 0  WHERE user_id = '$id';";
                        } else {
                            $sql = "UPDATE profile_pictures SET picture_status = 0 WHERE user_id = '$id';";
                        }
                    } else {
                        $sql = "INSERT INTO profile_pictures (user_id,image_path,picture_status) VALUES ('$id','$imagePath',0)";
                    }

                    if (mysqli_query($connection, $sql)) {
                        echo "Fotoja e profilit u shtua me sukses!";
                        header("Location: profili.php?upload=success");
                    } else {
                        echo "Error gjatë update-imit të databazës!";
                    }
                } else {
                    echo "File-i nuk u bë dot upload!";
                }
            } else {
                echo "Madhësia e file-it tuaj është shumë e madhe! Limiti është 10 MB.";
            }
        } else {
            echo "Ndodhi një gabim gjatë upload-imit të imazhit!";
        }
    } else {
        echo "Ky tip i file-it nuk lejohet!";
    }
} else {
    echo "Asnjë file nuk është bërë upload.";
}
?>

