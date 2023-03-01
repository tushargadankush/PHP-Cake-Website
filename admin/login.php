<?php include("../config/constants.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin_Login- Cake Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
    
    
</head>
<body>
    
    <div class="login">
        <h1 class="text-center">Login</h1>  <br>

        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        

        <!-- login form starts here -->
        <form action="" method="POST" class="text-center">
        
        <input type="text" name="username" placeholder="Enter Your Username"> <br>
        <input type="password" name=" password" placeholder="Enter Your Password"> <br>
        <button type="submit" name="submit" value="Login" class="login-btn">LOGIN</button> <br><br>
        </form>
        <!-- login form ends here -->

        <p  class="text-center created">Created by <a href="www.@iam_tushargadankush.com">@iam_tushargadankush</a></p>
    </div>
    
</html>


<?php
    // check wheather submit button is click or not
    if(isset($_POST['submit'])){
        //process login
        //1. get the data from login form

        // old:  $username= $_POST['username'];
         // old:  $password=md5($_POST['password']);

        $username= mysqli_real_escape_string($conn, $_POST['username']);
        $password= mysqli_real_escape_string($conn, md5($_POST['password']));

        //create a sql query to check whether a username and password exists or not
        $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //exwcutw a query
        $res= mysqli_query($conn, $sql);

        // count a rows t check whether user exists or not
        $count= mysqli_num_rows($res);

        if($count==1){
           // user available & login successful
           $_SESSION['login']= "<div class='success'>Login Successfully </div>";
           $_SESSION['user']= $username; // to check whether the user is lohin or not and logout will unset it
           //redirect to home page / dashboard
           header("location:".SITEURL.'admin/');
        }
        else{
            // user not available  & login unsuccessful
            $_SESSION['login']= "<div class='error text-center'>Username or Password Do Not Match</div>";
            //redirect to home page / dashboard
           header("location:".SITEURL.'admin/login.php');
        }
    }

?>
