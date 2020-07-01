<?php

include("includes/headers.php");
include("includes/classes/User.php");
include("includes/classes/Posts.php");
//session_destroy();

if(isset($_POST['post'])){
    $post=new Posts($conn,$userLoggedIn);
    $post->submitPosts($_POST['post_text'],'none');
}


?>
    <div class="users_details column">
        <a href="<?php echo $userLoggedIn; ?>"><img  src="<?php echo $users['profile_pic']; ?>"></a>
        <div class="user_details_left_right">
            <a href="<?php echo $userLoggedIn; ?>">
                <?php 
                echo $users["first_name"]." ".$users["last_name"];
                ?>
            </a><br>
            <?php
                echo "Posts".$users["num_posts"]."<br>";
                echo "likes".$users["num_likes"];
            ?>
        </div>
    </div>

    <div class="main_column column">
        <form class="post_form" method="POST" action="index.php">
            <textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
            <input type="submit" name="post" id="post_button" value="Post">
            <hr>
        </form>

        <?php
            $user_obj=new User($conn,$userLoggedIn);
            echo $user_obj->getFirstAndLastname();

        ?>



    </div>
    </div>

    

        

</body>
</html>