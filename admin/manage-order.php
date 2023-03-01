<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE ORDERS</h1>
            <br>
            <br>
            <br>
            <br>
                <!-- button to add admin -->
            <!-- <a class="btn-primary" href="#"> Add Orders</a> -->
            <br>
            <br>
            <br>
            <?php
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete']; //displaying session massage
                    unset($_SESSION['delete']); // removing session massage
                }
            ?>

               <table class="tbl-full">
                    
                    <tr>
                        <th>Sr.</th>
                        <th>Cake Name</th>
                        <th>Price</th>
                        <th>Qty.</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Bill View</th>
                        <th>Status</th>
                        <th>Cust_Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                    
                    <?php
                        //get all oreders from datbse
                        $sql="SELECT * FROM tbl_order ORDER BY id DESC "; //display  latest order at top
                        //execute the query
                        $res=mysqli_query($conn, $sql);
                        //count rows
                        $count=mysqli_num_rows($res);
                        //check whether order available or not

                        $sn= 1; //create a serial number and set its initial value as 1
                        if($count>0)
                        {
                            //order avaialable
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //get all the orders
                                $id= $row['id'];
                                $cake= $row['cake'];
                                $price= $row['price'];
                                $qty= $row['qty'];
                                $total= $row['total'];
                                $order_date= $row['order_date'];
                                $status= $row['status'];
                                $customer_name= $row['customer_name'];
                                $customer_contact= $row['customer_contact'];
                                $customer_email= $row['customer_email'];
                                $customer_address= $row['customer_address'];
                                $bill_status=$row['bill_status'];
                                
                                ?>
                                    <tr>
                                        <td><?php echo $sn++;?>.</td>
                                        <td><?php echo $cake;?></td>
                                        <td><?php echo $price;?></td>
                                        <td><?php echo $qty;?></td>
                                        <td><?php echo $total;?></td>
                                        <td><?php echo $order_date;?></td>
                                        <td><?php echo $bill_status;?></td>

                                        <td>
                                            <?php
                                            //Ordered, On Delivery, Delivered, Cancelled
                                                if($status=="Ordered")
                                                {
                                                    echo "<label>$status</label>";
                                                }
                                                elseif($status=="Delivered")
                                                {
                                                    echo "<label style='color:green;'>$status</label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color:red;'>$status</label>";
                                                }
                                            ?>
                                        </td>

                                        <td><?php echo $customer_name;?></td>
                                        <td><?php echo $customer_contact;?></td>
                                        <td><?php echo $customer_email;?></td>
                                        <td><?php echo $customer_address;?></td>
                                        <td>
                                            <a class="btn-secondary" href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id;?>"> Update Order </a>
                                            <a class="btn-danger" href="<?php echo SITEURL;?>admin/delete-order.php?id=<?php echo $id;?>"> Delete Order </a>
                                            <a class="btn-primary" href="<?php echo SITEURL;?>admin/print.php?id=<?php echo $id;?>"> PRINT </a>
                                            <!-- <button class="btn btn-primary" onclick=window.print()>PRINT</button> -->
                     
                                        </td>
                                    </tr>
                                
                                <?php
                            }
                        }
                        else
                        {
                            //order not available
                            echo "<tr><td colspan='12' class='error'>Order Not Available.</td></tr>";
                        }
                    ?>
                    
                    
                    
                    
                    
                </table>
                
    </div>
</div>

<?php include('partials/footer.php');?>