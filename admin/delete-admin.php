<?php

// include constant.php file here
    include('../config/constants.php');
    //1. get a id of admin to delete
    $id= $_GET['id'];
    //2. create a SQL query to delete admin
    $sql= "DELETE FROM tbl_admin WHERE id=$id";
    //execute a query
    $res= mysqli_query($conn, $sql);
    //check whether the query executed successfully or not
    if($res== true){
        // querry excuted successfully and delete a admin
        //echo "Admin Deleted";
        //create sessiom variable to dispaly message
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully </div>";
        //redirect to manage admin page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        // failrd to  deletw  admin
        //echo "Admin Not Deleted";
        $_SESSION['delete']= "<div class='error'>Failed To Delete Admin, Try Again Later </div>";
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    
        
    //3.direct the manage admin page with massage (success/error)



?>