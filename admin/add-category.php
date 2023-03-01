<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br> <br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }    
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }    
        
        
        ?>
        <br><br>
        <!-- add category is starts here -->
        <form action="" method="POST" enctype="multipart/form-data"> 
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No 
                    </td>
                </tr>
                
                
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
         <!-- add category is ends here --> 


         <?php
            // check whether a submit button is click or not
            if(isset(($_POST['submit']))){
                //echo 'button clicked';

                //1. get a value from category form
                $title=$_POST['title'];
                
                // for radion input we need to check whether the button is selected or not
                if(isset($_POST['featured'])){
                    // get a value from form
                    $featured= $_POST['featured'];
                }
                else{
                    // get dfault value
                    $featured= 'No';
                }

                if(isset($_POST['active'])){
                    // get a value from form
                    $active= $_POST['active'];
                }
                else{
                    // get default value
                    $active= 'No';
                }

                // check whether the image is selected or not and set the value for image name accordingly
                //print_r($_FILES['image']);
                //die(); // break the code here

                if(isset($_FILES['image']['name'])){
                    //upload a image
                    //to upload image we need image name, source path and destination path
                    $image_name= $_FILES['image']['name'];

                    //upload a image only if image is slected
                    if($image_name !="")
                    {

                        
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
                            header("location:".SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }
                    }

                }
                else{
                    //do not upload a image and set a image name value blank
                    $image_name="";
                }


                //3. create a sql query to insert a category in database
                $sql= " INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";

                    //3. execute the query and save in database
                    $res= mysqli_query($conn, $sql);

                    // check whether the query is executed or not
                    if ($res==TRUE){
                        // query executed and category added
                        $_SESSION['add']="<div class='success'> Category Added Successfully </div>";
                        //redirect to manage category page
                        header("location:".SITEURL.'admin/manage-category.php');
                    }
                    else{
                        // failed to add category
                        $_SESSION['add']="<div class='error'>Failed to Add Category</div>";
                        //redirect to manage category page
                        header("location:".SITEURL.'admin/add-category.php');
                    }
            }
            ?>
            </div>
            </div>
            <?php include('partials/footer.php');?>

                

