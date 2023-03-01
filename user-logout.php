<?php
//include constants.php
include('config/constants.php');

    //1. distroy the session
    session_destroy(); // unsets $_SESSION['username];

    //2. redirect to login page
    header("location:".SITEURL.'User-Login&Register.php');
?>