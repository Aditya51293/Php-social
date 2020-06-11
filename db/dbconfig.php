<?php


if(!isset($_SESSION)) { 
        session_start(); 
}
else{
        session_destroy();
        session_start(); 
}

$timezone=date_default_timezone_set("Asia/Kolkata");

$host="localhost:3360";
$username="root";
$pass="root";
$database="social";
$conn=mysqli_connect($host,$username,$pass,$database);

if(mysqli_connect_error()){
    echo "could not connect db".mysqli_connect_error();
}


?>