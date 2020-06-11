<?php
require "db/dbconfig.php";



if(isset($_SESSION['username'])){
    $userLoggedIn=$_SESSION['username'];
    $userquery=mysqli_query($conn,"SELECT * FROM users WHERE username='$userLoggedIn'");
    
    $users=mysqli_fetch_array($userquery);
}
else{
    header("Location: register.php");
}
?>

<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>



    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

</head>

<body>

    <div class="top_bar">
        <div class="logo">

            <a href="index.php">Random Chat</a>

        </div>
        <nav>

            <a href="#">
                
                <i class="fa fa-home fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-home fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-envelope fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-bell-o fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-users fa-lg"></i>
            </a>
            <a href="#">
                <i class="fa fa-cog fa-lg"></i>
            </a>
        </nav>
    </div>
