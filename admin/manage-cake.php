<?php include('partials/menu.php');?>
<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE CAKE</h1>
        <br>
        <br>
        <br>
        <br>
            <!-- button to add admin -->
        <a href="<?php echo SITEURL; ?>admin/add-cake.php" class="btn-primary" > Add Cake</a>
        <br>
        <br>
        <br>

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                    
                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }
                    
                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }
                    
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }  
                ?>
                <br>
                <br>

            

                <table class="tbl-full">
                    <tr>
                        <th>Sr No.</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    
                    <?php
                        //create sql query to get all cake
                        $sql="SELECT * FROM tbl_cake";

                        //execute a query
                        $res= mysqli_query($conn, $sql);

                        // count rows to check whether we have cake or not
                        $count= mysqli_num_rows($res);

                        // create a serial number variable and set default value as 1
                        $srno=1;


                        if($count>0)
                        {
                            // we have cake in databse
                            //get a cake from database and dispaly
                            while($rows= mysqli_fetch_assoc($res))
                            {
                                //get values from indivusual column
                                $id= $rows['id'];
                                $title= $rows['title'];
                                $price= $rows['price'];
                                $image_name= $rows['image_name'];
                                $featured= $rows['featured'];
                                $active= $rows['active'];
                                ?>

                            <tr>
                                <td><?php echo $srno++ ;?>.</td>
                                <td><?php echo $title;?></td>
                                <td>$<?php echo $price;?></td>
                                <td>
                                    <?php
                                        // check  whether we have a image or not
                                        if($image_name=="")
                                        {
                                            // we do not have a image display error maessage
                                            echo "<div class='error'> Image Not Added.</div>";

                                        }
                                        else
                                        {
                                            // we have image ,display image
                                            ?>
                                            <img src="<?php echo SITEURL;?>images/cake/<?php echo $image_name; ?>" width="100px">
                                            <?php
                                        }
                                        ?>
                                </td>
                                <td><?php echo $featured;?></td>
                                <td><?php echo $active;?></td>
                                <td>
                                    <a href="<?php echo SITEURL;?>admin/update-cake.php?id=<?php echo $id;?>" class="btn-secondary" > Update Cake </a>
                                    <a href="<?php echo SITEURL;?>admin/delete-cake.php?id=<?php echo $id;?>&image_name=<?php echo $image_name; ?>" class="btn-danger" > Delete Cake </a>
                                </td>   
                            </tr>
                                
                            

                                <?php
                            }

                        }
                        else
                        {
                            // we dont have cake in databse
                            echo "<tr> <td colspan='7' class='error'>Cake Not Added Yet </td></tr>";
                        }
                    
                    ?>
                </table>
        </div>
    </div>
        
<?php include('partials/footer.php');?>

                        
                    
                    

                
                    
                    
                    
                    
                    