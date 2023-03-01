<?php include("../config/constants.php");?>
<!-- Link our CSS file -->
<link rel="stylesheet" href="../css/style.css">
<!-- <link rel="stylesheet" href="../css/admin.css"> -->

<div class="cake-search">
    <div class="container order">
    <h2 class="text-center">Bill of your Ordered Laptop</h2>
<?php
            //check whether id is set or not
            if(isset($_GET['id']))
            {
                //get the order details
                $id= $_GET['id'];

                //get all other details based on this id
                //sql querry to get order details
                $sql= "SELECT * FROM tbl_order WHERE id=$id";
                //execute the query
                $res= mysqli_query($conn, $sql);
                //count he rows
                $count= mysqli_num_rows($res);
                
                if($count==1)
                {
                    //detail avaialble
                    $row= mysqli_fetch_assoc($res);
                    $id= $row['id'];
                    $customer_id= $row['customer_id'];
                    $cake= $row['cake'];
                    // $weight=$row['weight'];
                    $price= $row['price'];
                    $qty= $row['qty'];
                    $total= $row['total'];
                    $order_date= $row['order_date'];
                    $status= $row['status'];
                    $customer_name= $row['customer_name'];
                    $customer_contact= $row['customer_contact'];
                    $customer_email= $row['customer_email'];
                    $customer_address= $row['customer_address'];
                    $payment_method= $row['payment_method'];
                    $payment_status= $row['payment_status'];
                }
                else
                {
                    //detail not avaialble 
                    //redirect to manage order
                    header("location:".SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //redirect to manage order page
                header("location:".SITEURL.'admin/manage-order.php');
            }
        ?>
        <small>
                <fieldset>
                <div class="cake-menu-desc">
                    <small><?php echo $order_date;?></small>
                    <!-- <p>Sr. NO:<?php echo $sn++;?>.</p> -->
                    <p class="cake-price">Customer ID: <?php echo $customer_id;?>
                    <h1><p class="cake-price">Bill_No: <?php echo $id;?></p></h1>
                    <br>
                    <small><p >Payment Method:  <?php echo $payment_method;?></p></small>
                    <p >Customer Name:  <?php echo $customer_name;?></p>
                    <p>Customer Contact:  <?php echo $customer_contact;?></p>
                    <p>Customer Email:  <?php echo $customer_email;?></p>
                    <p>Customer Address:  <?php echo $customer_address;?></p>
                    <p>Laptop Name:  <?php echo $cake;?></p>
                    <p>Price:   <?php echo $price;?> Rs/-</p>
                    <!-- <p>Weight:  <?php echo $weight;?> kg</p> -->
                    <p>Quantity:  <?php echo $qty;?></p>
                    <p>Date Of Delivery: within 24 hours.</p>
                    <h1><p>Total Price:   <?php echo $total;?> Rs/-</p></h1><small>(Delivery Charge 50rs/-)</small>

                    
                </div>       
                </fieldset>
                </small>
                <!-- <a href="<?php echo SITEURL;?>update-bill-order.php?id=<?php echo $id;?>" class="btn btn-primary" > Ok </a> -->
                <!-- <a href="<?php echo SITEURL;?>delete-bill-order.php?id=<?php echo $id;?>" class="btn btn-primary" > Cencle Order </a> -->
                <!-- <a href="<?php echo SITEURL;?>bill.php?id=<?php echo $id;?>" name='print' class="btn btn-primary">Print </a> -->
                <!-- <input type="submit" name="print" value="print" class="btn btn-primary"> -->
                <button class="btn btn-primary" onclick=window.print()>PRINT</button>