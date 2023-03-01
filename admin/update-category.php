<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            //check whether the id is set or not
            if(isset($_GET['id']))
            {
                //get the id and all other details 
                //echo "get a data";
                $id=$_GET['id'];

                //create a sql query to get other details
                $sql= "SELECT * FROM tbl_category WHERE id=$id";

                //execute the query
                $res=mysqli_query($conn, $sql) or die(mysqli_error());

                //count the rows to check whether id is valid or not
                $count= mysqli_num_rows($res);

                if($count==1)
                {
                    //get all data
                    $rows= mysqli_fetch_assoc($res);
                    $title=$rows['title'];
                    $current_image=$rows['image_name'];
                    $featured= $rows['featured'];
                    $active= $rows['active'];

                }
                else{
                    //redirect to manage category with session massage
                    $_SESSION['no-category-found']="<div class='error'>Category Not Found </div>";
                    header("location:".SITEURL.'admin/manage-category.php'); 
                }

            
            }
            else
            {
                //redirect to manage category
                header("location:".SITEURL.'admin/manage-category.php');
            }
        
        ?>
        <form action=""  method="POST"  enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title;?>" >
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image!="")
                            {
                                // display a image
                                ?>
                                <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="150px">
                                <?php
                                
                                
                            }
                            else
                            {
                                //display message
                                echo "<div class='error'> Image Not Added. </div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "Checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "Checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "Checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "Checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
                //echo " clicked";
                //get all the values from our form
                $id= $_POST['id'];
                $title= $_POST['title'];
                $current_image= $_POST['current_image'];
                $featured= $_POST['featured'];
                $active= $_POST['active'];

                // updating new image if selected
                //check whether image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get a image details
                    $image_name= $_FILES['image']['name'];

                    //check image is available or not
                    if($image_name!="")
                    {
                        //image available
                        //upload a new image

                        //auto rename our image
                        // get extension of our image is (jpg,png,gif,etc) e.g: cake1.jpg
                        $ext= end(explode('.', $image_name));
                        
                        // rename the image
                        $image_name="Cake_Category_".rand(000, 999).'.'.$ext; //e.g: cake_category_034.jpg
                        
                        
                        $source_path= $_FILES['image']['tmp_name'];
                        $destination_path="../images/category/".$image_name;
                        
                        //finally upload a image
                        $upload= move_uploaded_file($source_path, $destination_path);
                        
                        //check whether a image is uploaded or not
                        // if the image is not uploaded then we will stop project and redirect a error msg
                        if($upload==false){
                            //set msg
                            $_SESSION['upload']= "<div class='error'> Failed To Upload Image </div>";
                            // redirect to add category page
                            header("location:".SITEURL.'admin/manage-category.php');
                            //stop the process
                            die();
                        }

                        //remove a current image if available
                        if($current_image!="")
                        {
                            $remove_path= "../images/category/".$current_image;
                            $remove= unlink($remove_path);

                            //check whetherthe image is remove or not
                            //if felt to remove dispaly a message and stop the process
                            if($remove=false)
                            {
                                //failed to remove mesage
                                $_SESSION['failed-remove']="<div class='error'>Failed To Remove Current Image </div>";
                                header("loacation:".SITEURL.'admin/manage-category.php');
                                die(); // stop the process
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name= $current_image;
                    }
                }
                else
                {
                    $image_name= $current_image;
                }

                //update the database
                $sql2="UPDATE tbl_category SET
                title='$title',
                image_name= '$image_name',
                featured='$featured',
                active='$active'
                WHERE id='$id'               
                ";

                //execute the query
                $res2= mysqli_query($conn, $sql2);


                //redirect to manage category page with message
                //check whether query executed or not
                if($res2==true)
                {
                    // category update
                    $_SESSION['update']="<div class='success'> Category Update Successfully. </div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }
                else
                {
                    // failed to update category
                    $_SESSION['update']="<div class='error'> Failed To Update Category. </div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                }

                
            }
        
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>