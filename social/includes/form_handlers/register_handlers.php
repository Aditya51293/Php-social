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