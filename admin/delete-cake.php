<?php
    //include constant page
    include("../config/constants.php");
    //echo "delete";
    if(isset($_GET['id']) && isset($_GET['image_name'])) // either use && or AND
    {
        //process to delete
        //echo "Process To Delete";

        //1.get id and image name
        $id= $_GET['id'];
        $image_name= $_GET['image_name'];
        
        //2. remove th eimage if avaialble
        //check wheter the image is available or not and delete only if avaailable
        if($image_name!="")
        {
            //it has image and need to remove 
            //get a image path
            $path= "../images/cake/".$image_name;

            //remove a image file from folder
            $remove= unlink($path);

            //check whether image is remove or not
            if($remove==false)
            {
                //failed to remove image
                $_SESSION['upload']="<div class='error'>Failed To Remove Image File.</div>";
                //redirect to manage cake page
                header("location:".SITEURL.'admin/manage-cake.php');
                //stop the proces of deleting cake
                die();
            }
        }
        //3. delete cake from database
        $sql= "DELETE FROM tbl_cake WHERE id=$id";
        //execute the query
        $res= mysqli_query($conn, $sql);

        //check whether the query is executed or not and send session message respectively
        //4. redirect to mange cake with session message
        if($res== true)
        {
            //cake deleted
            $_SESSION['delete']="<div class='success'>Cake Deleted Successfully. </div>";
            header("location:".SITEURL.'admin/manage-cake.php');
        }
        else
        {
            //failed to delete message
            $_SESSION['delete']="<div class='error'>Failed To Delete Cake. </div>";
            header("location:".SITEURL.'admin/manage-cake.php');
        }

    }
    else
    {
        //redirect manage cake page
        //echo "Redirect";
        $_SESSION['unauthorize']="<div class='error'>Unauthorized Access</div>";
        header("location:".SITEURL.'admin/manage-cake.php');
    }

?>