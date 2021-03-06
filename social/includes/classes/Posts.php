<?php
class Posts{
    private $user_obj;
    private $conn;

    public function __construct($conn,$user){
        $this->conn=$conn;
        $this->user_obj=new User($conn,$user);
    }

    public function submitPosts($body,$user_to){
        $body=strip_tags($body); //removes html tags
        $body=mysqli_real_escape_string($this->conn,$body);
        $check_empty=preg_replace("/\s+/",'',$body);

        if($check_empty!=""){
            //current date and time
            $date_added=date("Y-m-d H:i:s");

            //get the username

            $added_by=$this->user_obj->getUsername();
        }

        //if the user is submit post not from his profile
        if($user_to==$added_by){
            $user_to="none";
        }

        //insert post
        $query=mysqli_query($this->conn,"INSERT INTO posts VALUES('','$body','$added_by','$user_to','$date_added','no','no','0')");
        $returned_id=mysqli_insert_id($this->conn);

        //insert notifcation

        //update post count for the user
        $num_posts=$this->user_obj->getNumPosts();
        $num_posts++;
        $update_query=mysqli_query($this->conn,"UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
    }

}


?>