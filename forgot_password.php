<?php include("config/constants.php");?>

<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function sendMail($email, $reset_tocken)
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
            $mail->Subject = 'Password Resend Link From Tushar';
            $mail->Body    = "We got a request from you to reset your password!<br>
                Click the link below: <br>
                <a href='http://localhost/cake-order/updatepassword.php?email=$email&reset_tocken=$reset_tocken'>
                Reset Password
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

    if(isset($_POST['send-reset-link']))
    {
        $sql= "SELECT * FROM tbl_user_register WHERE email='$_POST[email]'";
        $res= mysqli_query($conn, $sql);
        
        if($res)
        {
            //echo "runnnnnnn";
            if(mysqli_num_rows($res)==1)
            {
                //email found
                $reset_tocken= bin2hex(random_bytes(16));        //binaryToHexadecimal
                date_default_timezone_set('Asia/kolkata');
                $date= date("Y-m-d");
                
                $sql2="UPDATE tbl_user_register SET resettocken='$reset_tocken', resettockenexpired='$date' WHERE email='$_POST[email]'";
                
                if(mysqli_query($conn, $sql2) && sendMail($_POST['email'], $reset_tocken))
                {
                    //create a sessiom variable to dispaly massage
                    $_SESSION['send-reset-link']= "<div class='success text-center'>Password Reset Link Sent to Mail</div>";
                    //redirect page TO  userloginreguisterpage
                    header("location:".SITEURL.'User-Login&Register.php');
                }
                else
                {
                    //create a sessiom variable to dispaly massage
                    $_SESSION['send-reset-link']= "<div class='error text-center'>Server Down Try Again Later 112 !!</div>";
                    //redirect page TO  userloginreguisterpage
                    header("location:".SITEURL.'User-Login&Register.php');
                }
            }
            else
            {
                //email not found/ 
                //create a sessiom variable to dispaly massage
                $_SESSION['send-reset-link']= "<div class='error text-center'>Invalid Email Entered !!</div>";
                //redirect page TO  userloginreguisterpage
                header("location:".SITEURL.'User-Login&Register.php');
            }
        }
        else
        {
            //create a sessiom variable to dispaly massage
            $_SESSION['send-reset-link']= "<div class='error text-center'>Cannot Run Query </div>";
            //redirect page TO  userloginreguisterpage
            header("location:".SITEURL.'User-Login&Register.php');
        }
    }
?>