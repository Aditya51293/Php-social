<?php

session_start();

$conn=mysqli_connect("localhost:3309","root","","social");



if(mysqli_connect_errno()){
    echo "connection to db failed".mysqli_connect_errno();
}

//declaring variables to print error
$fname="";//first name
$lname="";//last name
$em="";//email
$em2="";//confirm email
$password="";//password
$password2="";//password
$date="";//signup date
$error_array=array();//containing error message

if(isset($_POST['register_button'])){
    //register form values

    $fname=strip_tags($_POST['reg_fname']);//removes html tags
    $fname=str_replace(' ','',$fname);//removes spaces
    $fname=ucfirst(strtolower($fname));//upper case first letter only
    $_SESSION['reg_fname']=$fname;

    $lname=strip_tags($_POST['reg_lname']);//removes html tags
    $lname=str_replace(' ','',$lname);//removes spaces
    $lname=ucfirst(strtolower($lname));//upper case first letter only
    $_SESSION['reg_lname']=$lname;

    $em=strip_tags($_POST['reg_email']);//removes html tags
    $em=str_replace(' ','',$em);//removes spaces
    $em=ucfirst(strtolower($em));//upper case first letter only
    $_SESSION['reg_email']=$em;

    $em2=strip_tags($_POST['reg_email2']);//removes html tags
    $em2=str_replace(' ','',$em2);//removes spaces
    $em2=ucfirst(strtolower($em2));//upper case first letter only
    $_SESSION['reg_email2']=$em2;

    $password=strip_tags($_POST['reg_password']);//removes html tags

    $password2=strip_tags($_POST['reg_password2']);


    $date=date("Y-m-d");

    


    if($em==$em2){
        //check for valid email
        if(filter_var($em,FILTER_VALIDATE_EMAIL)){
            $em=filter_var($em,FILTER_VALIDATE_EMAIL);

            $e_check=mysqli_query($conn,"SELECT email FROM users WHERE email='$em'");

            //count the number of rows returned

            $num_rows=mysqli_num_rows($e_check);

            if($num_rows>0){
                array_push($error_array,"email already in use<br>");
            }

        }
        else{
            array_push($error_array,"invalid format<br>");
        }

    }

    else{
        array_push($error_array,"the emails don't match<br>");
    }



    if(strlen($fname)<8 || strlen($fname)>25){
        array_push($error_array,"the name should be between 8 and 25 characters<br>");
    }
    if(strlen($lname)<8 || strlen($lname)>25){
        array_push($error_array,"the name should be between 8 and 25 characters<br>");
    }

    if($password != $password2){
        array_push($error_array,"the password don't match<br>");
    }
    else{
        if(preg_match("/^(?=.*\d).{4,8}$/",$password)){
            array_push($error_array,"Password expression. Password must be between 4 and 8 digits long and include at least one numeric digit.<br>");
        }
    }


    
    
    
    if(empty($error_array)){


        $password=md5($password); //encrypt password
        

        

        //generate username by concatenating first name and last name

        $username=strtolower($fname ."_". $lname);
        $check_username=mysqli_query($conn,"SELECT username FROM users WHERE username='$username'");

        $i=0;
        //if user exists add number to username

        while(mysqli_num_rows($check_username)!=0){
            $i++;
            $username=$username ."_". $i;
            $check_username=mysqli_query($conn,"SELECT username FROM users WHERE username='$username'");
        }

        


        //profile pic assignment
        $rand=rand(1,2); //random between 1 and 2
        if($rand==1){
            $profile_pics="assets/images/profile pics/defaults.download.png";
        }
        else if($rand==2){
            $profile_pics="assets/images/profile pics/defaults.download2.png";
        }
 

        $query=mysqli_query($conn,"INSERT INTO users VALUES ('','$fname','$lname','$username','$em','$password','$date','$profile_pics','0','0','no',',')");

        array_push($error_array,"<span style='color:green'>Your registration is validated! Please login..");
        
    }

session_unset();
    
}

?>


<html>
<head>
    <title>Welcome to Swirlfeed!</title>
</head>


<body>
    <form action="register.php" method="post">
        <input type="text" name="reg_fname" placeholder="first name"
        value="<?php
        if(isset($_SESSION['reg_fname'])){
            echo $_SESSION["reg_fname"];
        }
        
        ?>"
         required><br>
        <?php if(in_array("the name should be between 8 and 25 characters<br>",$error_array)) echo "the name should be between  and 25 characters<br>"; ?>

        <input type="text" name="reg_lname" placeholder="Last name"
        value="<?php
        if(isset($_SESSION['reg_lname'])){
            echo $_SESSION["reg_lname"];
        }
        
        ?>"
         required><br>
         <?php if(in_array("the last name should be between 8 and 25 characters<br>",$error_array)) echo "the name should be between  and 25 characters<br>"; ?>
        <input type="email" name="reg_email" placeholder="Email" 
        value="<?php
        if(isset($_SESSION['reg_email'])){
            echo $_SESSION["reg_email"];
        }
        
        ?>"
        required> <br>
        <input type="email" name="reg_email2" placeholder="Confirm Email" 
        value="<?php
        if(isset($_SESSION['reg_email2'])){
            echo $_SESSION["reg_email2"];
        }
        
        ?>"
        required>  <br>
        <?php if(in_array("email already in use<br>",$error_array)) echo "the email is already in use<br>"; 
        else if(in_array("the emails don't match<br>",$error_array)) echo "the emails don't match<br>";
        else if(in_array("invalid format<br>",$error_array)) echo "invalid format<br>";?>

        <input type="password" name="reg_password" placeholder="Password" required> <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" required><br>

        <?php if(in_array("the password don't match<br>",$error_array)) echo "the password don't match<br>";
        else if(in_array("Password expression. Password must be between 4 and 8 digits long and include at least one numeric digit.<br>",$error_array)) echo "Password expression. Password must be between 4 and 8 digits long and include at least one numeric digit.<br>";
        
        ?>

        <input type="submit" name="register_button" value="Register"> 
    </form>


</body>


</html>