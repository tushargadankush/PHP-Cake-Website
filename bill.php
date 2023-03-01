<?php include('partials-front/menu.php');?>
<!-- Link our CSS file -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="../css/admin.css">

<?php
    if(isset($_SESSION['order']))
    {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>
<?php
    if(isset($_SESSION['Nupdate']))
    {
        echo $_SESSION['Nupdate'];
        unset($_SESSION['Nupdate']);
    }
?>

<div class="cake-search">
    <div class="container order">
    <h2 class="text-center">Bill of your Ordered Cake</h2>
    <p class='text-center'>(You Can See Bill Only Once)</p>
    <?php
        //$customer_email= $_POST['email'];
        //get all oreders from datbse
        $sql="SELECT * FROM tbl_order WHERE bill_status='0'"; //display  latest order at top
        //execute the query
        $res=mysqli_query($conn, $sql);
        //count rows
        $count=mysqli_num_rows($res);
        //check whether order available or not
        if($count>0)
        {
            //order avaialable
            while($row=mysqli_fetch_assoc($res))
            {
                //get all the orders
                $id= $row['id'];
                $cake= $row['cake'];
                $price= $row['price'];
                $weight=$row['weight'];
                $qty= $row['qty'];
                $total= $row['total'];
                $order_date= $row['order_date'];
                $status= $row['status'];
                $customer_name= $row['customer_name'];
                $customer_contact= $row['customer_contact'];
                $customer_email= $row['customer_email'];
                $customer_address= $row['customer_address'];

                                
                ?>
                <small>
                <fieldset>
                <div class="cake-menu-desc">
                    <small><?php echo $order_date;?></small>
                    <!-- <p>Sr. NO:<?php echo $sn++;?>.</p> -->
                    <!-- <p class="cake-price">User Code: <?php echo $user_id;?> -->
                    <h1><p class="cake-price">Bill_No: <?php echo $id;?></p></h1>
                    <br>
                    <p >Customer Name:  <?php echo $customer_name;?></p>
                    <p>Customer Contact:  <?php echo $customer_contact;?></p>
                    <p>Customer Email:  <?php echo $customer_email;?></p>
                    <p>Customer Address:  <?php echo $customer_address;?></p>
                    <p>Cake Name:  <?php echo $cake;?></p>
                    <p>Price:   <?php echo $price;?> Rs/-</p>
                    <p>Weight:  <?php echo $weight;?> kg</p>
                    <p>Quantity:  <?php echo $qty;?></p>
                    <p>Date Of Delivery: within 24 hours.</p>
                    <h1><p>Total Price:   <?php echo $total;?> Rs/-</p></h1><small>(Delivery Charge 50rs/-)</small>

                    
                </div>       
                </fieldset>
                </small>
                <a href="<?php echo SITEURL;?>update-bill-order.php?id=<?php echo $id;?>" class="btn btn-primary" > Ok </a>
                <a href="<?php echo SITEURL;?>delete-bill-order.php?id=<?php echo $id;?>" class="btn btn-primary" > Cencle Order </a>
                <?php
            }
        }
        else
        {
            // //order not available
            // echo "<tr><td colspan='12' class='error'></td></tr>";
            //failed to save order
            $_SESSION['order']="<div class='error text-center'>Order Not Available.</div>";
            header('location:'.SITEURL); 
        }
    
        ?>
        <!-- <a class=" btn-secondary" href="<?php echo SITEURL;?>contact.php?id=<?php echo $id;?>"> okay </a> -->
        <!-- <a class="btn-danger" href="<?php echo SITEURL;?>contact.php?id=<?php echo $id;?>"> Cencel Order </a> -->
        <!-- <input type="submit" name="bill_view" value="Bill Viewed" class="login-btn"> -->
        <!-- <input type="hidden" name="id" value="<?php echo $id;?>"> -->
        <!-- <input type="submit" name="submit" value="Cencel Order" class="login-btn"> -->
        <p class='text-center'>(You Can See Bill Only Once)</p>
        <p class='text-center'><small>Take screenshot of this bill and show at time of Delivery</small></p>
    </div>
</div>

<?php include('partials-front/footer.php');?>