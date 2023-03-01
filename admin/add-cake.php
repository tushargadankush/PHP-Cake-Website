<?php include("partials/menu.php");?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Cake</h1>
        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        
        ?>


    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" placeholder="Title of Cake:">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of Cake:"></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price"  placeholder="Your Cake Price:">
                </td>
            </tr>

            <tr>
                <td> Select Image:</td>
                <td>
                    <input type="file" name="image" >
                </td>
            </tr>

            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">

                        <?php
                            // create a php code to display category from database
                            // 1.create sql query to get all active category
                            $sql= "SELECT * FROM tbl_category WHERE active='Yes' ";

                            //execute a query
                            $res= mysqli_query($conn, $sql);

                            //count rows to check whether we have categories or not
                            $count= mysqli_num_rows($res);

                            // id count is greater than zero then we have categories esle we dont have categories

                            if($count>0)
                            {
                                //we have categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get a details of categories
                                    $id= $row['id'];
                                    $title= $row['title'];
                                        
                                    ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        
                                    <?php
                                }

                            }
                            else
                            {
                                //we do not have categories
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }


                            //2.display on dropdown
                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured</td>
                <td>
                    <input type="radio" name="featured" value="Yes">Yes
                    <input type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active</td>
                <td>
                    <input type="radio" name="active" value="Yes">Yes
                    <input type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Cake" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>

    <?Php
        //check whether button click or not
        if(isset($_POST['submit']))
        {
            //add the cake to database
            //echo "clicked";
            //1. get data from form 
            $title= $_POST['title'];
            $description= $_POST['description'];
            $price= $_POST['price'];
            $category= $_POST['category'];

            // check whether radio button for festured and active are check or not
            if(isset($_POST['featured']))
            {
                $featured=$_POST['featured'];
            }
            else
            {
                $featured= "No";
            }

            if(isset($_POST['active']))
            {
                $active= $_POST['active'];
            }
            else
            {
                $active= "No";
            }

            //2.upload a image if selected
            //check whether the select image is clicked or not and upload a image only if image is selected
            if(isset($_FILES['image']['name']))
            {
                //get a details of selected image
                $image_name= $_FILES['image']['name'];

                //check whether image is selected or not and upload a image only if selected
                if($image_name!="")
                {
                    // image is selected
                    //a. rename the image
                    // get the selection of selectcted image (jpg, ong, gif,etc)
                    $ext= end(explode('.', $image_name));

                    // create a new name for image
                    $image_name= "Cake-Name".rand(0000,9999).".".$ext;  //new image name like be "Fodd-Nmae-657.jpg"

                    //b. upload a image
                    // create a source path and destination path

                    // source path is current location of image
                    $src= $_FILES['image']['tmp_name'];

                    // destination path for image to be upload
                    $dst= "../images/cake/".$image_name;

                    //finally upload a cake image
                    $upload= move_uploaded_file($src, $dst);

                    //whether the image uploaded or not
                    if($upload==false)
                    {
                        //failed to uplolad
                        //redirect to add cake page with error message
                        $_SESSION['upload']= "<div class='error'> Failed To Upload Image.</div>";
                        header("location:".SITEURL.'admin/add-cake.php');
                        //stop the proces
                        die();
                    }

                }


            }
            else
            {
                //set a defalut value of image as blank
                $image_name= "";

                
            }
            //3. isert into database
            //create a sql query to add cake
            //for numerical value not need to pass value inside single qotes ' ' but it is compulsory for string value
            $sql2= " INSERT INTO tbl_cake SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name= '$image_name',
                category_id= $category,
                featured= '$featured',
                active= '$active'
            ";

            //execute the query
            $res2= mysqli_query($conn , $sql2);
            
            //4.redirect with manage cake page
            //check whether data is inserted or not

            if($res2== true)
            {
                // data inserted successfully
                $_SESSION['add']= "<div class='success'> Cake Added Successfully.</div>";
                header("location:".SITEURL.'admin/manage-cake.php');
            }
            else
            {
                //failed to insert data
                $_SESSION['add']= "<div class='error'> Failed to Add Cake.</div>";
                header("location:".SITEURL.'admin/manage-cake.php');
            }
        }
    ?>
    </div>
</div>
<?php include("partials/footer.php");?>


