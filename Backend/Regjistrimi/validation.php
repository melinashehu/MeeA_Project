<?php
include('db_connection.php');

function validate_name($name){
    if (empty($name)) {
        $status = false;
        $message = "Ju lutem vendosni emrin!!!";
    }else if (!preg_match ("/^[a-zA-z]*$/", $name) ) {
        $status = false;
        $message = "Emri duhet te kete vetem shkronja!!!";
    }else if (strlen($name) < 3) {
        $status = false;
        $message = "Emri duhet te kete te pakten 3 shkronja!!!";
    }else {
        $status = true;
        $message = "";
    };
    return [
        'status' => $status,
        'message' => $message,
    ];
}

function validate_email($email, $connection){
    $pattern_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        if(empty($email)){
            $status = false;
            $message = "Ju lutem vendosni emailin!!!";
        }else if (!preg_match($pattern_email,$email)){
            $status = false;
            $message = "Emaili i vendosur nuk eshte ne formatin e duhur!!! Formati i kerkuar: username@domainname.com";
        }else if(!empty($email)){
            $unique_email_query = "SELECT * FROM `users` WHERE email = '$email';" ;
            $result = mysqli_query($connection,$unique_email_query);
            if(mysqli_num_rows($result) > 0){
                $status = false;
                $message = "Ekziston perdorues me kete email!!!";
            }else{
                $status = true;
                $message = "";
            }
        }else {
            $status = true;
            $message = "";
        }
        return [
            'status' => $status,
            'message' => $message,
        ];
}

function validate_password($password){
    $pattern_password = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';
    if(empty($password)){
        $status = false;
        $message = "Ju lutem vendosni fjalekalimin!!!";
    }
    else if(!preg_match($pattern_password,$password)){
        $message = "Fjalakalimi duhet te permbaje te pakten nje shkronje te madhe, nje shkronje te vogel, 
        nje karakter special, nje numer dhe nje minimum prej 8 karakteresh!!!";
        $status = false;
    }
    else{
        $status = true;
        $message = "";
    }
    return [
        'status' => $status,
        'message' => $message,
    ];
}
?>