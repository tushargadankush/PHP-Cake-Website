<?php include("config/constants.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> UserLogin: Cake Order System</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/logo.jpg" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="cake-Menu.php">Cake</a>
                    </li>
                    <li>
                        <a href="#">Blog</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>

                <button type="button" class="btn btn-primary" onclick="popup('login-popup')">LOGIN</button>
                <button type="button"class="btn btn-primary" onclick="popup('register-popup')">REGISTER </button>

            </div>


            <div class="popup-container" id="login-popup">
                <div class="popup">
                    <form method="POST" action="login_register.php">
                        <h2>
                        <span>USER LOGIN</span>
                        <button type="reset" onclick="popup('login-popup')">X</button>
                        </h2>
                        <input type="text" placeholder="Email or Username" name="email_username">
                        <input type="password" placeholder="Password" name="password">
                        <button type="submit" class="login-btn" name="login" value="login">LOGIN</button>

                    </form>
                    
                    <div class="forgot-btn">
                        <button type="button" onclick="forgotpopup()">Forgot Password ?</button>
                    </div>
                </div>
            </div>

            <div class="popup-container" id="register-popup">
                <div class="popup">
                    <form method="POST" action="login_register.php">
                        <h2>
                        <span>USER REGISTER</span>
                        <button type="reset" onclick="popup('register-popup')">X</button>
                        </h2>
                        <input type="text" placeholder="Fullname" name="full_name">
                        <input type="text" placeholder="Username" name="username">
                        <input type="email" placeholder="Email" name="email">
                        <input type="password" placeholder="Password" name="password">
                        <button type="submit" class="login-btn" name="register" value="register" >REGISTER</button>

                    </form>
                </div>
            </div>

            <!-- forgot button popup -->
            <div class="popup-container" id="forgot-popup">
                <div class="forgot popup">
                    <form method="POST" action="forgot_password.php">
                        <h2>
                        <span>RESET PASSWORD</span>
                        <button type="reset" onclick="popup('forgot-popup')">X</button>
                        </h2>
                        <input type="text" placeholder="Email" name="email">
                        <button type="submit" class="reset-btn" name="send-reset-link" value="send-reset-link" > SEND LINK</button>

                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

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
        if(isset($_SESSION['verification_code']))
        {
            echo $_SESSION['verification_code'];
            unset($_SESSION['verification_code']);
        }
        ?>
        <br><br>

        <?php
        if(isset($_SESSION['bill']))
        {
            echo $_SESSION['bill'];
            unset($_SESSION['bill']);
        }
        ?>
        <br><br>
        
    </section>
    <?php include('partials-front/footer.php')?>

    <script>
        function popup(popup_name)
        {
            get_popup= document.getElementById(popup_name);
            if(get_popup.style.display=="flex")
            {
                get_popup.style.display="none";
            }
            else{
                get_popup.style.display="flex";
            }
        }

        function forgotpopup(){
            document.getElementById('login-popup').style.display="none";
            document.getElementById('forgot-popup').style.display="flex";

        }
    </script>

    
   

    