<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1> Change Password</h1>
        <br><br>
        <?php
            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td><input type="password" name="current_password" placeholder="Enter Your Current Password"></td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td><input type="password" name="new_password" placeholder="Enter Your New Password"></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="confirm_password" placeholder="Enter Your Confirm Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
        </form>
    </div>
</div>


<?php
//check submit button click or not
    if(isset($_POST['submit'])){
        echo 'click';
    //1. get a data from form
    $id=$_POST['id'];
    $current_password=md5($_POST['current_password']);
    $new_password=md5($_POST['new_password']);
    $confirm_password=md5($_POST['confirm_password']);

    //2. check whether user with current id and current password are exi\sts or not
    $sql="SELECT* FROM tbl_admin WHERE id=$id AND password='$current_password'";

    // execute the query
    $res= mysqli_query($conn, $sql) or die(mysqli_error());

        if($res==true){
        // check whether data available or not
            $count=mysqli_num_rows($res);

            if($count==1){
            // user exist and password can be change
            echo "user found";

            //check whether new password and confirm password is same or not
                if($new_password=$confirm_password){
                    //update a apssword
                    $sql2="UPDATE tbl_admin SET
                    password='$new_password'
                    WHERE id='$id'
                    ";

                    //execute the query
                    $res2=mysqli_query($conn, $sql2);

                    // check query execute or not
                    if($res2==true){
                        // dispaly the message
                         //redirect to manage admin page with error
                        $_SESSION['change-pwd']= "<div class='success'>Change Password Succesfully</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');

                    }
                    else{
                        $_SESSION['change-pwd']= "<div class='error'>Failed To Change Password </div>";
                        header("location:".SITEURL.'admin/manage-admin.php');

                    }

            }
            else{
                //redirect to manage admin page with error
                $_SESSION['pwd-not-match']= "<div class='error'>Password Not Match </div>";
                header("location:".SITEURL.'admin/manage-admin.php');

            }

        }
        else{
            //user does not exist set message and redirect
            $_SESSION['user-not-found']= "<div class='error'>User Not Found </div>";
            header("location:".SITEURL.'admin/manage-admin.php');


        }
    }
    //3. check whether new password and confirm password is same or not
    //4. change password if allabove is donenew
}
?>
<?php include('partials/footer.php')?> 
    
    