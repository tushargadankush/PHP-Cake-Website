<?php include("config/constants.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paasword Update</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    

<?php
    if(isset($_GET['email']) && isset($_GET['reset_tocken']))
    {
        date_default_timezone_set('Asia/kolkata');
        $date2=date("Y-m-d");
        $sql2= "SELECT * FROM tbl_user_register WHERE email= '$_GET[email]' AND resettocken= '$_GET[reset_tocken]' AND resettockenexpired='$date2'";
        $res2=mysqli_query($conn, $sql2);
        
        if($res2)
        {
            $rows2= mysqli_num_rows($res2);
            if($rows2==1)
            {
                echo "
                <div class='UPcontainer '>
                    <div class='popup container '>
                        <form method='POST'>
                            <h2>
                            <span>Create New Password</span>
                            </h2>
                            <input type='password' placeholder='New Password' name='password'>
                            <button type='submit' class='login-btn' name='updatepassword' >UPDATE PASSWORD</button>
                            <input type='hidden' name='email' value='$_GET[email]'>
                        </form>
                    </div>
                </div>
                ";
            }
            else
            {
                //create a sessiom variable to dispaly massage
                $_SESSION['send-reset-link']= "<div class='error text-center'>Invalid or Expired Link !!</div>";
                //redirect page TO  userloginreguisterpage
                header("location:".SITEURL.'User-Login&Register.php');
            }
        }
        else
        {
            //create a sessiom variable to dispaly massage
            $_SESSION['send-reset-link']= "<div class='error text-center'>Server Down Try Again Later !!</div>";
            //redirect page TO  userloginreguisterpage
            header("location:".SITEURL.'User-Login&Register.php');
        }
    }
    else
    {
        //create a sessiom variable to dispaly massage
        $_SESSION['send-reset-link']= "<div class='error text-center'>something Wrong !!</div>";
        //redirect page TO  userloginreguisterpage
        header("location:".SITEURL.'User-Login&Register.php');
    }
?>

<?php

    if(isset($_POST['updatepassword']))
    {
        //echo "clicked";
        $password= password_hash($_POST['password'],PASSWORD_BCRYPT);
        $sql3= "UPDATE tbl_user_register SET `password`='$password', `resettocken`=NULL, `resettockenexpired`=NULL WHERE email='$_POST[email]'";

        if(mysqli_query($conn,$sql3))
        {
            //create a sessiom variable to dispaly massage
            $_SESSION['send-reset-link']= "<div class='success text-center'>Password Updated Successfully</div>";
            //redirect page TO  userloginreguisterpage
            header("location:".SITEURL.'User-Login&Register.php');
        }
        else
        {
            //create a sessiom variable to dispaly massage
            $_SESSION['send-reset-link']= "<div class='error text-center'>Server Down Try Again Later !!</div>";
            //redirect page TO  userloginreguisterpage
            header("location:".SITEURL.'User-Login&Register.php');
        }
    }
    else
    {}
?>
</body>
</html>