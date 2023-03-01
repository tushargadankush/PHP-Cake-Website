<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin </h1>
        <br> <br>
        
        <?php
             if(isset($_SESSION['add'])){
                echo $_SESSION['add']; //displaying session massage
                unset($_SESSION['add']); // removing session massage
             }
        ?>
        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter Your Username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php');?>

<?php 
    // process the vale from form and save it in database
    // check whether thge submit button click or not
    if(isset($_POST['submit'])){
        
        //button click 
        //echo "Button Clicked";    
        
        //1.get a data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encryption with md5
        
        //2.sql querry to save a data to datbase
        $sql="INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
    ";

        //3. execute querry and save data in datbase
        $res= mysqli_query($conn, $sql) or die(mysqli_error());

        //4. check the querry is executed or data insert or not and display approriate massage
        if($res==TRUE)
        {
            //DATA INSERTED
            //echo "insert a data";
            //create a sessiom variable to dispaly massage
            $_SESSION['add']= "<div class='success'>Admin Added Successfully </div>";
            //redirect page TO MANAGE ADMIN APGE
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to insert a data
            //echo "failed to insert a data";
            //create a sessiom variable to dispaly massage
            $_SESSION['add']= "<div class='error'>failed to add Admin </div>";
            //redirect page TO add ADMIN APGE
            header("location:".SETURL.'admin/manage-admin.php');
        }
       
    }



?>
