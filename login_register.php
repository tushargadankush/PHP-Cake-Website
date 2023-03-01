<?php include("config/constants.php");?>
<!-- Link our CSS file -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="../css/admin.css">

<?php
    if(isset($_SESSION['login']))
    {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
    if(isset($_SESSION['no-login-message'])){
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
    }

?>

<?php
    if(isset($_SESSION['register']))
    {
        echo $_SESSION['register'];
        unset($_SESSION['register']);
    }
?>
<br><br>

<?php
    if(isset($_SESSION['send-reset-link']))
    {
        echo $_SESSION['send-reset-link'];
        unset($_SESSION['send-reset-link']);
    }

?>
<br><br>

<?php
    // email send code
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email,$v_code)
    {
        require('PHPMailer/PHPMailer.php');
        require('PHPMailer/SMTP.php');
        require('PHPMailer/Exception.php');

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = '';                     //SMTP username
            $mail->Password   = '';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('', '');

            $mail->addAddress($email);     //Add a recipient

            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email Verification From Tushar';
            $mail->Body    = "Thanks for Registeration!!!<br>
                Click the link below to Verify the Email Address: <br>
                <a href='http://localhost/cake-order/verify.php?email=$email&v_code=$v_code'>
                Verify
                </a>";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            //echo 'Message has been sent';
            return true;
        }
        catch (Exception $e)
        {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            //return false;
        }
    }


?>
<?php

//this is for login
if(isset($_POST['login']))
{
    
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            
    $sql3="SELECT * FROM tbl_user_register WHERE username='$_POST[email_username]' OR email='$_POST[email_username]'"; 
    $res3= mysqli_query($conn, $sql3);
    if($res3)
    {
        $count3= mysqli_num_rows($res3);
        if($count3 == 1)
        {
            $rows3= mysqli_fetch_assoc($res3);
            if($rows3['verified_code']==1)
            {
                if(password_verify($_POST['password'],$rows3['password']))
                {
                    //if password match
                    //echo "right";
                    $_SESSION['login']= "<div class='success text-center'>$rows3[username]-Login Successfully </div>";
                    $_SESSION['username']= $rows3['username']; // to check whether the user is lohin or not and logout will unset it
                    //redirect to home page / dashboard
                    header("location:".SITEURL.'index.php');
                }
                else
                {
                    //if password do not match
                    //echo"
                        //<script>
                        //alert('Incorrect Password');
                        //window.location.href='User-Login&Register.php';
                        //</script>
                    //";

                    //create a sessiom variable to dispaly massage
                    $_SESSION['login']= "<div class='error text-center'>Incorrect Password";
                    //redirect page TO  userloginreguisterpage
                    header("location:".SITEURL.'User-Login&Register.php');
                }
            }
            else
            {
                $_SESSION['verification_code']= "<div class='error text-center'>Email Not Verified !! <small>(check your emails for verify)</small></div>";
                //redirect page userloginreguisterpage
                header("location:".SITEURL.'User-Login&Register.php');
            }
        }
        else
        {
            //echo"
            //<script>
                //alert(' Username or Email Not Rrgistred!!');
                //window.location.href='User-Login&Register.php';
            //</script>
            //";
            
            //create a sessiom variable to dispaly massage
            $_SESSION['login']= "<div class='error text-center'>Username or Email Not Rrgistred!!</div>";
            //redirect page TO  userloginreguisterpage
            header("location:".SITEURL.'User-Login&Register.php');
        }
    }
    else
    {
        //echo"
        //<script>
            //alert('Can not run query');
            //window.location.href='User-Login&Register.php';
        //</script>
        //";

        //create a sessiom variable to dispaly massage
        $_SESSION['login']= "<div class='error text-center'>Cannot Run Query </div>";
        //redirect page TO  userloginreguisterpage
        header("location:".SITEURL.'User-Login&Register.php');
    }

}



//this is for registration
if(isset($_POST['register']))
{
    //process register
    //1. get the data from login register

    // old:  $username= $_POST['username'];
    // old:  $password=md5($_POST['email']);
            
    //1.get a data from form
    $full_name = $_POST['full_name'];
    $username= $_POST['username'];
    $email= $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $v_code= bin2hex(random_bytes(16));

    //create a sql query to check whether a username and email exists or not
    $sql="SELECT * FROM tbl_user_register WHERE username='$username' OR email='$email'";
            
    //exwcutw a query
    $res= mysqli_query($conn, $sql);

    if($res==TRUE)
    {
        $count= mysqli_num_rows($res);
        if($count > 0 ) //execute when username & email already exists
        {
            //if any user has already taken username or email
            $rows=mysqli_fetch_assoc($res);
                    
            if($rows['username'] == $_POST['username'])
            {
                //error for username already already taken
                //echo"
                //<script>
                    //alert('$rows[username] - Usename Already Exists!!!');
                    //window.location.href='User-Login&Register.php';
                //</script>
                //";

                // username available  & register unsuccessful
                $_SESSION['register']= "<div class='error text-center'> $rows[username]-Username already exists!! </div>";
                //redirect to home page / dashboard
                header("location:".SITEURL.'User-Login&Register.php');
            }
            else
            {
                //error for email already already taken
                //echo"
                //<script>
                    //alert('$rows[email] - Email Already Exists!!!');
                    //window.location.href='User-Login&Register.php';
                //</script>
                //";

                // email available  & register unsuccessful
                $_SESSION['register']= "<div class='error text-center'> $rows[email]-Email already exists!! </div>";
                //redirect to home page / dashboard
                header("location:".SITEURL.'User-Login&Register.php');
            }

                    
        }
        else //execute when username & email not already exists
        {
            //when username & email not already exists
            //2.sql querry to save a data to datbase
            $sql2="INSERT INTO tbl_user_register SET
            full_name='$full_name',
            username='$username',
            email='$email',
            password='$password',
            verification_code='$v_code',
            verified_code='0'
            ";

            //3. execute querry and save data in datbase
            $res2= mysqli_query($conn, $sql2) && sendMail($_POST['email'], $v_code);

            //4. check the querry is executed or data insert or not and display approriate massage
            if($res2==TRUE)
            {
                //if DATA INSERTED
                //echo"
                //<script>
                    //alert('User Registered Succesfully!!!');
                    //window.location.href='User-Login&Register.php';
                //</script>
                //";

                //DATA INSERTED
                //echo "insert a data";
                //create a sessiom variable to dispaly massage
                $_SESSION['register']= "<div class='success text-center'>User Registered Successfully </div>";
                //redirect page TO  userloginreguisterpage
                header("location:".SITEURL.'User-Login&Register.php');

            }
            else
            {
                //failed to insert a data
                //echo"
                //<script>
                    //alert('User Registered Unsuccesfully!!!');
                    //window.location.href='User-Login&Register.php';
                //</script>
                //";

                //failed to insert a data
                //echo "failed to insert a data";
                //create a sessiom variable to dispaly massage
                $_SESSION['register']= "<div class='error'>failed to User Register </div>";
                //redirect page userloginreguisterpage
                header("location:".SITEURL.'User-Login&Register.php');

            }

                
        }
    }
    else
    {
        //echo"
        //<script>
            //alert('Can not run query');
            //window.location.href='User-Login&Register.php';
        //</script>
        //";

        //DATA INSERTED
        //echo "insert a data";
        //create a sessiom variable to dispaly massage
        $_SESSION['register']= "<div class='error'>Cannot Run Query </div>";
        //redirect page TO  userloginreguisterpage
        header("location:".SITEURL.'User-Login&Register.php');


    }

}
?>