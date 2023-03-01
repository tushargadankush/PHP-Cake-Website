<?php include('partials/menu.php')?> 
        
<!-- main content section start -->
        <div class="main-content">
            <div class="wrapper">
               <h1>MANAGE ADMIN</h1>
                <br>
                <br>
                <?php
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add']; //displaying session massage
                        unset($_SESSION['add']); // removing session massage
                    }
                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete']; //displaying session massage
                        unset($_SESSION['delete']); // removing session massage
                    }
                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update']; //displaying session massage
                        unset($_SESSION['update']); // removing session massage
                    }
                    if(isset($_SESSION['user-not-found'])){
                        echo $_SESSION['user-not-found']; //displaying session massage
                        unset($_SESSION['user-not-found']); // removing session massage
                    }
                    if(isset($_SESSION['pwd-not-match'])){
                        echo $_SESSION['pwd-not-match']; //displaying session massage
                        unset($_SESSION['pwd-not-match']); // removing session massage
                    }
                    if(isset($_SESSION['change-pwd'])){
                        echo $_SESSION['change-pwd']; //displaying session massage
                        unset($_SESSION['change-pwd']); // removing session massage
                    }
                ?>
                <br>
                <br>
                <!-- button to add admin -->
                <a class="btn-primary" href="add-admin.php"> Add Admin</a>
                <br>
                <br>
                <br>
               <table class="tbl-full">
                    
                    <tr>
                        <th>Sr No.</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        // query to get all admin 
                        $sql= "SELECT * FROM tbl_admin";
                        //execute the query
                        $res= mysqli_query($conn, $sql);

                        //check whether query is execute or not
                        if($res==TRUE){
                            //COUNT THE ROWS TO CHECK WHETHER HAVE DATA IN DATABASE OR NOT
                            $count= mysqli_num_rows($res); // function to get rfows in database
                            
                            $srno=1;// create a vairiable and assigned a value

                            // check a num of rows
                            if($count > 0){
                                // we have a data in database
                                while($rows= mysqli_fetch_assoc($res))
                                {
                                    // using while loop to get all data in database
                                    //add while loop will run as long as we have a data in databae

                                    //get individual data
                                    $id=$rows['id'];
                                    $full_name= $rows['full_name'];
                                    $username= $rows['username'];

                                    // display the views in our table
                                    ?>

                                    <tr>
                                        <td> <?php echo $srno++;?>.</td>
                                        <td> <?php echo $full_name; ?></td>
                                        <td> <?php echo $username;?></td>
                                        <td>
                                            <a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary"> Update Admin </a>
                                            <a href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger"> Delete Admin</a>
                                        </td>
                                    </tr>
                        
                                    <?php
                                }
                            }
                            else{
                                // we do not have a data in database
                            }
                        }

                    ?>
                    
                </table>
                <div class="clearfix"></div>
            </div>  
        </div>
<!-- main content section is end -->

<?php include('partials/footer.php')?> 
                   
                    
                    
                    
            
                    
                
                
                   
                   
                   
                