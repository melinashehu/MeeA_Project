<!--Do NOT modify this class-->

<?php
$host = "localhost";
$username="root";
$password="";
$database = "programimweb";
$connection = mysqli_connect($host, $username, $password, $database);
if(!$connection){
    die("Connection failed: " . mysqli_connect_error());
}else{
    //echo "Connected successfully!";
}
?>