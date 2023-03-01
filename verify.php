<?php include("config/constants.php");?>

<?php

if(isset($_GET['email']) && isset($_GET['v_code']))
{
    $sql="SELECT * FROM tbl_user_register WHERE email='$_GET[email]' AND verification_code='$_GET[v_code]'";
    $res= mysqli_query($conn, $sql);
        
    if($res)
    {
        if(mysqli_num_rows($res)==1)
        {
            $rows= mysqli_fetch_assoc($res);
            if($rows['verified_code']==0)
            {
                $sql2="UPDATE tbl_user_register SET verified_code='1' WHERE email='$rows[email]'"; 

                if(mysqli_query($conn, $sql2))
                {
                    $_SESSION['verification_code']= "<div class='success text-center'>User Verified Successfully !!</div>";
                    //redirect page userloginreguisterpage
                    header("location:".SITEURL.'User-Login&Register.php');
                }
                else
                {
                    $_SESSION['verification_code']= "<div class='error text-center'>User Fail to Verified !!</div>";
                    //redirect page userloginreguisterpage
                    header("location:".SITEURL.'User-Login&Register.php');
                }
            }
            else
            {
                $_SESSION['verification_code']= "<div class='error text-center'>User Already Verified !!</div>";
                //redirect page userloginreguisterpage
                header("location:".SITEURL.'User-Login&Register.php');
            }
        }
        else
        {}
    }
    else
    {
        $_SESSION['verification_code']= "<div class='error text-center'>failed to User Register</div>";
        //redirect page userloginreguisterpage
        header("location:".SITEURL.'User-Login&Register.php');
    }
    }
else
{
        $_SESSION['verification_code']= "<div class='error text-center'>Something Went Wrong !!</div>";
        //redirect page userloginreguisterpage
        header("location:".SITEURL.'User-Login&Register.php');
}

?>