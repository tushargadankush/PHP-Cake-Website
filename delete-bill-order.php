<?php include("config/constants.php");?>

<?php

if(isset($_GET['id']))
{
    $id= $_GET['id'];

    $sql= "DELETE FROM tbl_order WHERE id=$id";
    $res= mysqli_query($conn, $sql);
    if($res== true)
    {
        $_SESSION['delete']="<div class='success text-center'>Order Cencel Successfully. </div>";
        header("location:".SITEURL);
    }
    else
    {
        $_SESSION['delete']="<div class='error text-center'>Failes to Cencel Order </div>";
        header("location:".SITEURL.'bill.php');
    }

}

?>