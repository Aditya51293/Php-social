<?php

require "db/dbconfig.php";

if(isset($_POST['log_button'])){
    $email=filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL);

    $_SESSION['log_email']=$email;

    $password=md5($_POST['log_password']);

    $check_query=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");

    $check_num_rows=mysqli_num_rows($check_query);

    if($check_num_rows == 1){
        $rows=mysqli_fetch_array($check_query);
        $username=$rows['username'];
        

        $user_closed_query=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' and user_closed='yes'");

        if(mysqli_num_rows($user_closed_query)==1){
            $user_open=mysqli_query($conn,"UPDATE users SET user_closed='no' WHERE email='$email'");
        }
        

        $_SESSION['username']=$username;
        header("Location: index.php");
        
        exit();
    }
    else{
        array_push($error,"Email or password was incorrect! Please try again<br>");
    }
}



?>