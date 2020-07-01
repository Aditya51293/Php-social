<?php

require "db/dbconfig.php";
require "includes/form_handlers/register_handlers.php";
require "includes/form_handlers/login_handlers.php";


ob_start();
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
        
    }
    
    else{
        array_push($error,"Email or password was incorrect! Please try again<br>");
    }
header("Location:index.php");
        
    //echo "<script>window.location.href='index.php';</script>";
exit();
    
}

?>
<?php

$fname=""; //first name
$lname=""; //last name
$em=""; //email
$em=""; //confirm email
$password=""; //password
$password2=""; //password confirm
$date=""; //sign up date
$error=array(); //for having list of error

if(isset($_POST["register_button"])){

    //for storing values

    $fname=strip_tags($_POST['reg_fname']); //any tags will be avoided
    $fname=str_replace(" ","",$fname);  //space will be neglected
    $fname=ucfirst(strtolower($fname)); //lower the name and make the first letter as Capital letter
    $_SESSION['reg_fname']=$fname;

    $lname=strip_tags($_POST['reg_lname']); //tags removal
    $lname=str_replace(" ","",$lname);
    $lname=ucfirst(strtolower($lname));
    $_SESSION['reg_lname']=$lname;

    $em=strip_tags($_POST['reg_email']);
    $em=str_replace(" ","",$em);
    $_SESSION['reg_email']=$em;

    $em2=strip_tags($_POST['reg_email2']);
    $em2=str_replace(" ","",$em2);
    $_SESSION['reg_email2']=$em2;

    

    $password=strip_tags($_POST['reg_password']);
    $_SESSION['reg_fname']=$fname;
    $password2=strip_tags($_POST['reg_password2']);

    $date=date("Y-m-d"); //date storage


    //checking if the theemail matches

    if($em==$em2){
        if(filter_var($em,FILTER_VALIDATE_EMAIL)){
            //filter with specified variable
            $em=filter_var($em,FILTER_VALIDATE_EMAIL);

            $e_check=mysqli_query($conn,"SELECT email FROM users WHERE email='$em'");

            //count the number of rows returned

            $num_row=mysqli_num_rows($e_check);

            if($num_row>0){
                array_push($error,"email already in use<br>");
            }

        }
        else{
            array_push($error,"invalid format<br>");
        }
    }

    else{
        array_push($error,"emails don't match<br>");
    }

    if(strlen($fname)>25 || strlen($fname)<5){
        array_push($error,"your firstname should be greater than 5 and less than 25 characters<br>");
    }
    if(strlen($lname)>25 || strlen($lname)<5){
        array_push($error,"your lastname should be greater than 5 and less than 25 characters<br>");
    }

    if($password!=$password2){
        array_push($error,"your password don't match<br>");
    }

    /*else{
        if(preg_match("/^(?=.*\d).{4,8}$/",$password)){
            array_push($error,"Password expression. Password must be between 4 and 8 digits long and include at least one numeric digit.<br>");
        }
    }*/

    /*if(strlen($password)<30 || strlen($password)>5){
        array_push($error,"password should be between 5 and 30 charatcer<br>");
    }*/

    

    if(empty($error)){
        $password=md5($password);

        $username=strtolower($fname."_".$lname);

        $check_username_query=mysqli_query($conn,"SELECT username FROM users where username='$username'");

        $i=0;

        if(mysqli_num_rows($check_username_query)!=0){
            $i++;
            $username=$username . "_" . $i;
            $check_username_query=mysqli_query($conn,"SELECT username FROM users where username='$username'");
        }
    
        $profile_pic="assets/images/profile_pics/default/download.png";
    
        $query=mysqli_query($conn,"INSERT INTO users VALUES ('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");

        array_push($error,"<span style=color:green>You can login</span><br>");
    }       
}



?>



<html>
<head>
    <title>Social Media Registration</title>
    <link rel="stylesheet" type="text/css" href="assets/css/register_styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>

<body>
<?php
if(isset($_POST['register_button'])){
    echo '
    <script>
    $(document).ready(function()(
        $("#first").hide();
        $("#second").show();
    )};
    </script>
    ';
}
?>

<div class="wrapper">

    <div class="login-box">
        <div class="login_header">
            <h1>Swirlfeed!</h1>
            Login or sign up below
        </div><br>

        <div id="first">
        
            <form action="register.php" method="post">
                <input type="email" name="log_email" placeholder="Email address" <?php 
                if(isset($_SESSION['log_email'])){
                    echo $_SESSION['log_email'];
                } 
                ?> 
                required><br>

                <input type="password" name="log_password" placeholder="Password"><br>
                <input type="submit" name="log_button" value="Login">

                <?php
                if(in_array("Email or password was incorrect! Please try again<br>",$error)){
                    echo "Email or password was incorrect! Please try again<br>";
                }
                ?><br>
                <a href="#" id="signup" class="signup">Need an account! Please register</a>


            </form>
        </div>

        <div id="second">
            <form action="register.php" method="post">
                <input type="text"  name="reg_fname" placeholder="first name" <?php 
                if(isset($_SESSION['reg_fname'])){
                    echo $_SESSION['reg_fname'];
                } 
                ?> required><br>
                <?php
                if(in_array("your firstname should be greater than 5 and less than 25 characters<br>",$error)){
                    echo "your firstname should be greater than 5 and less than 25 characters<br>";
                }
                ?>
                <input type="text"  name="reg_lname" placeholder="last name" <?php 
                if(isset($_SESSION['reg_lname'])){
                    echo $_SESSION['reg_lname'];
                } 
                ?> 
                required><br>
                <?php
                if(in_array("your lastname should be greater than 5 and less than 25 characters<br>",$error)){
                    echo "your lastname should be greater than 5 and less than 25 characters<br>";
                }
                ?>
                <input type="email"  name="reg_email" placeholder="email" <?php 
                if(isset($_SESSION['reg_email'])){
                    echo $_SESSION['reg_email'];
                } 
                ?> 
                required><br>
                <input type="email"  name="reg_email2" placeholder="confirm email" <?php 
                if(isset($_SESSION['reg_email2'])){
                    echo $_SESSION['reg_email2'];
                } 
                ?>
                required><br>
                <?php if(in_array("email already in use<br>",$error)) echo "email already in use<br>"; ?>
                <?php if(in_array("invalid format<br>",$error)) echo "invalid format<br>"; ?>
                <?php if(in_array("emails dont match<br>",$error)) echo "emails dont match,br>"; ?>
                
                <input type="password"  name="reg_password" placeholder="password" <?php 
                if(isset($_SESSION['reg_password'])){
                    echo $_SESSION['reg_password'];
                } 
                ?>
                required><br>
                <input type="password"  name="reg_password2" placeholder="confirm password" <?php 
                if(isset($_SESSION['reg_password2'])){
                    echo $_SESSION['reg_password2'];
                } 
                ?>
                required><br>
                <?php if(in_array("your password don't match<br>",$error)) echo "your password don't match<br>"; ?>
                <?php if(in_array("password should be between 5 and 30 charatcer<br>",$error)) echo "password should be between 5 and 30 charatcer<br>"; ?>
                <?php // if(in_array("Password expression. Password must be between 4 and 8 digits long and include at least one numeric digit.<br>",$error)) echo "Password expression. Password must be between 4 and 8 digits long and include at least one numeric digit.<br>"; ?>
                
                <input type="submit" name="register_button" value="register">
                <?php  if(in_array("<span style=color:green>You can login</span><br>",$error)) echo "<span style=color:green>You can login</span><br>"; ?>
                <br>
                <a href="#" id="signin" class="signin">Already an account! Please sign in</a>
            </form>
        </div>
    </div>

</div>
</body>
</html>