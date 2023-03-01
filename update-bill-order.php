<?php include("config/constants.php");?>

<?php

if(isset($_GET['id']))
{
    $id= $_GET['id'];

    $sql= "UPDATE tbl_order SET  bill_status='1' WHERE id=$id";
    $res= mysqli_query($conn, $sql);
    if($res== true)
    {
        $_SESSION['B-update']="<div class='success text-center'>Bill Viwed</div>";
        header("location:".SITEURL);
    }
    else
    {
        $_SESSION['B-update']="<div class='error text-center'>Bill Problem </div>";
        header("location:".SITEURL.'bill.php');
    }
}


?>