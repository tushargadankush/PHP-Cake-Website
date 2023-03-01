<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE CATEGORY</h1>
        <br>
        <br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }    
            if(isset($_SESSION['remove'])){
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }    
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }    
            if(isset($_SESSION['no-category-found'])){
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }    
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }    
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }    
            if(isset($_SESSION['failed-remove'])){
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }    
        
        ?>
        <br><br>
        <!-- button to add admin -->
        <a href="<?php echo SITEURL;?>admin/add-category.php" class="btn-primary" > Add Category</a>
        <br>
        <br>
        <br>

            <table class="tbl-full">
                        <tr>
                            <th>Sr No.</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Featured</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>

                        <?php
                            //query to get all category from database
                            $sql= "SELECT * FROM tbl_category";

                            //execute query 
                            $res= mysqli_query($conn, $sql);

                            //count rows
                            $count= mysqli_num_rows($res);

                            $srno=1;// create a vairiable and assigned a value


                            // check we have data in database or not
                            if($count>0){
                                // we hava adata in database
                                // get a data and dispaly
                                while($rows= mysqli_fetch_assoc($res)){
                                    $id=$rows['id'];
                                    $title=$rows['title'];
                                    $image_name=$rows['image_name'];
                                    $featured=$rows['featured'];
                                    $active=$rows['active'];

                                    ?>
                                        

                                        <tr>
                                            <td><?php echo $srno++;?>.</td>
                                            <td><?php echo $title;?></td>
                                            <td>
                                                <?php
                                                    //check whether image is available or not
                                                    if($image_name!=""){
                                                        //display the iamge
                                                    ?>
                                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" width="100px">
                                                        
                                                    <?php


                                                    }
                                                    else{
                                                        //dispaly the message
                                                        echo "<div class='error'>Image Not Added</div>";
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $featured;?></td>
                                            <td><?php echo $active;?></td>
                                            <td>
                                                <a href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id ?>" class="btn-secondary"> Update Category </a>
                                                <a href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name ;?>" class="btn-danger"> Delete Category</a>
                                            </td>
                                        </tr>

                                        
                        

                                    <?php
                                }


                            }
                            else{
                                // we dont hove data
                                // we will dispaly a mmasage inside table
                                ?>
                                <tr>
                                    <td colspan="6"><div class="error"></div></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </table>
                
               
    </div>
</div>

<?php include('partials/footer.php');?>
                    


                    
                    
                    
            
                    
                    
                    