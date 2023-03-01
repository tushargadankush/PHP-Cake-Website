<?php
    // include consyants file
    include('../config/constants.php');

    //echo "Delete Page"
    // check whether id and image_name is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get a value and delete
        //echo "delete a value";
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //remove physical image file if available 
        if($image_name!="")
        {
            // image is available so remove it
            $path= "../images/category/".$image_name;
            //remove image
            $remove= unlink($path);

            // if failed to remove image then add am error massege and stop process
            if($remove== false)
            {
                //set session massage
                $_SESSION['remove']="<div class='error'>Failed to Remove Category Image </div>";
                //redirect to manage category page
                header("location:".SITEURL.'admin/manage-category.php');
                //stop the process
                die();
            }
        }

        // delete a data in database
        //sql query delete data from database
        $sql= "DELETE FROM tbl_category WHERE id=$id";

        //execute the query
        $res= mysqli_query($conn, $sql);

        //check whether data is deleted or not
        if($res== true)
        {
            // set a success message and redirect 
            $_SESSION['delete']= "<div class='success'>Category Deleted Successfully</div>";
            // redirect to manage category
            header("location:".SITEURL.'admin/manage-category.php');
        }
        else
        {
            // set a fail message and redirect
            $_SESSION['delete']= "<div class='error'>Failed to Delete Category</div>";
            // redirect to manage category
            header("location:".SITEURL.'admin/manage-category.php'); 

        }
    }
    else{
        //redirect to manage category page 
        header("location:".SITEURL.'admin/manage-category.php');
    }
?>