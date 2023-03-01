<?php
    //autherization- access control
    // check whether the user is login or not
    if(!isset($_SESSION['user'])){  //if user session is not set

        // user is not logged in
        //redirect to login page with massage
        $_SESSION['no-login-message']= "<div class='error text-center'>Please Login TO Access Panel </div>";
        //redirect to login page
        header("location:".SITEURL.'admin/login.php');
    }
?>