<?php include("partials/menu.php");?>

<?php
    //check whether id is set or not 
    if(isset($_GET['id']))
    {
        //get all details
        $id= $_GET['id'];

        //sql query to get the selected cake
        $sql2=" SELECT * FROM tbl_cake WHERE id=$id";
        //execute the query
        $res2= mysqli_query($conn, $sql2);

        //get a value based on query executed
        $row2= mysqli_fetch_assoc($res2);

        //get a individual value of selected cake
        $title= $row2['title'];
        $description= $row2['description'];
        $price= $row2['price'];
        $current_image= $row2['image_name'];
        $current_category= $row2['category_id'];
        $featured= $row2['featured'];
        $active= $row2['active'];

    }
    else
    {
        //redirect to manage cake
        $_SESSION['no-cake-found']="<div class='error'>Cake Not Found </div>";
        header("location:".SITEURL.'admin/manage-cake.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Cake</h1>
        <br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5" ><?php echo $description;?>"</textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price;?>">
                </td>
            </tr>

            <tr>
                <td>Current Image:</td>
                <td>
                   <?php
                    if($current_image == "")
                    {
                        //image not available
                        echo "<div class='error'>Image Not Available.</div>";
                    }
                    else
                    {
                        //image available
                        ?>
                        <img src="<?php echo SITEURL;?>images/cake/<?php echo $current_image;?>" width="100px">
                        <?php
                    }
                   ?>
                </td>
            </tr>

            <tr>
                <td>Select New Image:</td>
                <td>
                    <input type="file" name="image" value="<?php echo $current_image; ?>">
                </td>
            </tr>

            <tr>
                <td>Category:</td>
                <td>
                    <select name="category" value="<?php echo $category_id; ?>">
                        
                        <?php
                        //query foe active categories
                            $sql= "SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute a query
                            $res= mysqli_query($conn, $sql);
                            //count a rows 
                            $count= mysqli_num_rows($res);

                            //check whether category available or not 
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title= $row['title'];
                                    $category_id= $row['id'];

                                    //echo "<option value='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){ echo "selected";}?> value="<?php echo $category_id; ?>"><?php echo $category_title?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //category not vailable
                                echo "<option value='0'>Category Not Available.</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes"){echo "Checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No"){echo "Checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes"){echo "Checked";} ?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No"){echo "Checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="current_image" value="<?php echo $current_image;?>">     
                    
                    <input type="submit" name="submit" value="Update Cake" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>

        <?php
            
            if(isset($_POST['submit']))
            {
                //echo "fkjfkjfv";

                //1. get all detals from form 
                //$id= $_POST['id'];
                $title= $_POST['title'];
                $description= $_POST['description'];
                $price= $_POST['price'];
                $current_image= $_POST['current_image'];
                $category= $_POST['category'];
                
                $featured= $_POST['featured'];
                $active= $_POST['active'];

                //2. upload a image if selected

                //check whether upload btn click or not
                if(isset($_FILES['image']['name']))
                {
                    //upload btn clicked
                    $image_name= $_FILES['image']['name']; // new image name

                    //check whether file is available or not
                    if($image_name!="")
                    {
                        //image is available
                        //A. UPLOADING NEW IMAGE

                        //rename the image
                        $ext = end(explode('.', $image_name)); //get a extension of image

                        $image_name= "Cake-Name-".rand(0000,9999).'.'.$ext; // this  will rename a image

                        //get a source path and destination path
                        $src_path= $_FILES['image']['tmp_name'];
                        $dst_path= "../images/cake/".$image_name;

                        //upload a image
                        $upload= move_uploaded_file($src_path, $dst_path);

                        //check whether image is uploaded or not
                        if($upload==false)
                        {
                            //failed to upload
                            $_SESSION['upload']= "<div class='error'>Failed To Upload Image.</div>";
                            //redirect to manage cake page
                            header("location:".SITEURL.'admin/manage-cake.php');
                            //stop the process
                            die();
                        }

                         //3. remove the image if new image is uploded and current image exists
                        //B. REMOVE CURRENT IMAGE IF AVAILABLE
                        if($current_image!="")
                        {
                            //current image is available
                            //remove the image
                            $remove_path= "../images/cake/".$current_image;

                            $remove= unlink($remove_path);

                            //check whether image is remove or not
                            if($remove==false)
                            {
                                //failed to remove current image
                                $_SESSION['failed-remove']= "<div class='error'>Failed To Remove Image.</div>";
                                //redirect to manage cake page
                                header("locatiom:".SITEURL.'admin/manage-cake.php');
                                //stop process
                                die();
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
               
                //4. update a cake in database
                $sql3= "UPDATE tbl_cake SET
                    title='$title',
                    description= '$description',
                    price= $price,
                    image_name= '$image_name',
                    category_id= '$category',
                    featured= '$featured',
                    active= '$active'
                    WHERE id=$id
                ";

                //execute a sql query
                $res3= mysqli_query($conn, $sql3);

                //chwck whether query executed or not
                if($res3== true)
                {
                    //query executed and cake update
                    $_SESSION['update']="<div class='success'> Update Successfully.</div>";
                    //redirect to manage cake page
                    header("location:".SITEURL.'admin/manage-cake.php');
                }
                else
                {
                    //query not executed and failed to update cake
                    $_SESSION['update']="<div class='error'>Failed To Update.</div>";
                    //redirect to manage cake page
                    header("location:".SITEURL.'admin/manage-cake.php');
                }
                
                
                //redirect to manage cake with session message


            }
        ?>
    </div>
</div>
<?php include("partials/footer.php");?>