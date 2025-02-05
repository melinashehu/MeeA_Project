<!--Be careful when modifying this class! Any inappropriate changes may result in a website failure-->

<?php

require_once "../Regjistrimi/db_connection.php";


if($_POST['action'] == "login"){
    $email = mysqli_real_escape_string($connection, trim($_POST['email']));
    $password = mysqli_real_escape_string($connection, trim($_POST['password']));

    if(empty($password) || strlen($password)<8){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Passwordi duhet te kete te pakten 8 karaktere!",
                "tagError" => "passwordError",
                "tagElement" => "password"
            ));
        exit;    
    }

    $query_check= "SELECT * FROM users WHERE email = '$email'";
    $result_check = mysqli_query($connection, $query_check);

    if(!$result_check){
        http_response_code(500);
        echo json_encode(
            array(
                "message" => "Internal server error",
                "error" => mysqli_error($connection)
            ));
        exit;    
    }

    if(mysqli_num_rows($result_check) == 0){
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Ky email nuk ekziston!"
            ));
        exit;    
    }

    $row = mysqli_fetch_assoc($result_check);


    $userId = $row['id'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

   
    $query_failed_logins = "SELECT * FROM failed_logins WHERE user_id = '$userId' AND lockout_time > NOW()";
    $result_failed_logins = mysqli_query($connection, $query_failed_logins);

    if(mysqli_num_rows($result_failed_logins) > 0){
       
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Llogaria juaj është bllokuar. Provoni më vonë!"
            ));
        exit;
    }

   
    $passwordHashed = $row['password'];
    if(!password_verify($password, $passwordHashed)){
        log_failed_attempt($connection, $userId, $ip_address);
        http_response_code(203);
        echo json_encode(
            array(
                "message" => "Passwordi i dhene eshte gabim!"
            ));
        exit;    
    }

    if(!empty($_POST['remember'])){
        setcookie("email", $email, time() + (86400 * 30), "/");
        setcookie("password", $password, time()+(86400 * 30), "/");
        echo "Cookies Set";
    }else{
        setcookie("email", "", time() - 3600, "/");
        setcookie("password", "", time() - 3600, "/");
        echo "Cookies Not Set";
    }
    session_start();
    $_SESSION['id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $row['email'];

    header("Location: \codding-community-platform\Home\Profili\profili.php"); 
    mysqli_close($connection);
}

function log_failed_attempt($connection, $userId, $ip_address) {
    $query = "SELECT * FROM failed_logins WHERE user_id = '$userId'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        $record = mysqli_fetch_assoc($result);
        $failed_attempts = $record['failed_attempts'] + 1;

        if ($failed_attempts >= 7) {
            
            $lockout_time = date("Y-m-d H:i:s", strtotime("+30 minutes"));
            $update_query = "UPDATE failed_logins 
                             SET failed_attempts = 0, lockout_time = '$lockout_time', attempted_at = NOW(), ip_address = '$ip_address' 
                             WHERE user_id = '$userId'";
            mysqli_query($connection, $update_query);
        } else {
            
            $update_query = "UPDATE failed_logins 
                             SET failed_attempts = '$failed_attempts', attempted_at = NOW(), ip_address = '$ip_address' 
                             WHERE user_id = '$userId'";
            mysqli_query($connection, $update_query);
        }
    } else {
      
        $insert_query = "INSERT INTO failed_logins (user_id, attempted_at, ip_address, failed_attempts) 
                         VALUES ('$userId', NOW(), '$ip_address', 1)";
        mysqli_query($connection, $insert_query);
    }
}

?>