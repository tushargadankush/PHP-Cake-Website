<?php include('partials-front/menu.php');?>
<?php
    if(isset($_SESSION['payment-method']))
    {
        echo $_SESSION['payment-method'];
        unset($_SESSION['payment-method']);
    }
?>
<?php
    //check whether cake id is set or not
    if(isset($_GET['cake_id']))
    {
        //get the cake id and details the selected cake
        $cake_id= $_GET['cake_id'];

        //get the detals of selected cake
        $sql= "SELECT * FROM tbl_cake WHERE id=$cake_id";

        //execute the query
        $res=mysqli_query($conn, $sql);
        //count the rows
        $count=mysqli_num_rows($res);
        //check whether data is avilable or not
        if($count==1)
        {
            //we have data
            //get the data from databse
            $row= mysqli_fetch_assoc($res);
            $title= $row['title'];
            $price= $row['price'];
            $image_name= $row['image_name'];
            $delivery_charge=50;
        }
        else
        {
            //cake not available and redirect to home page
            header('location:'.SITEURL);
        }
    }
    else
    {
        //redirect to home page
        // header('location:'.SITEURL);
    }
?>
<!-- cake sEARCH Section Starts Here -->
<section class="cake-search">
<div class="container">
        <form action="" method="POST" class="order">
            <h2 class="text-center">Fill this form to confirm your order.</h2>
            <fieldset>
                <legend>Selected cake</legend>
                <div class="cake-menu-img">
                    <?php
                        //check whether the imag eis available or not
                        if($image_name=="")
                        {
                            //image not available
                            echo "<div class='error'>Image Not Available.</div>";
                        }
                        else
                        {
                            //image available
                            ?>
                            <img src="<?php echo SITEURL;?>images/cake/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                        }
                    ?>
                </div>

                <div class="cake-menu-desc">
                    <h3 style="text-align: left"><?php echo $title;?></h3>
                    <p class="cake-price"><?php echo $price;?> Rs/-</p>
                       
                    <!-- <div class="order-label">Quantity:</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required> -->
                    <div class="order-label">Quantity:</div>
                    <!-- <input type="number" name="qty" class="input-responsive" value="1" required> -->
                    <select name="qty" class="input-responsive">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                        
                

                </div>

            </fieldset>
                
            <fieldset>

                <legend>Delivery Details</legend>
                <div class="order-label">Full Name:</div>
                <input type="text" name="full-name" placeholder="E.g. Sahil Kakade" class="input-responsive" required>

                <div class="order-label">Phone Number:</div>
                <input type="contact" name="contact" placeholder="E.g. 877xxxxxxx" class="input-responsive" pattern="[0-9]{10}"required>

                <div class="order-label">Email:</div>
                <input type="email" name="email" placeholder="E.g. sahil@gmail.com" class="input-responsive" required>

                <div class="order-label">Address:</div>
                <textarea name="address" rows="6" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
                    
                <div> Select Payment Method: <br>
                <!-- <input type="radio" name="payment_method" value="Cash on Delivery">Cash on Delivery <br>
                <input type="radio" name="payment_method" value="Online Payment">Online Payment <br> -->
                <select name="payment_method" class="input-responsive" required>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                </div>
                    
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
                
        </form>
    <?php
        //check whether submit button  click or not
        if(isset($_POST['submit']))
        {
            //get all details from the form
            //$user_id= $_POST['id'];
            $cake= $row['title'];
            // $price= $_POST['price'];
            // $weight= $_POST['weight'];
            $qty= $_POST['qty'];
            // $delivery_date= $_POST['delivery_date'];
                

            $semi_total= $price * $qty; // total= price X quantity
            $total= $semi_total+$delivery_charge;
            $order_date= date("Y-m-d H:i:s"); //oreder date

            $status= "Ordered"; //ordered, on delivery and deliver and cencle

               
            $customer_name= $_POST['full-name'];
            $customer_contact= $_POST['contact'];
            $customer_email= $_POST['email'];
            $customer_address= $_POST['address'];
                
            $sql3="SELECT * FROM tbl_user_register WHERE email='$_POST[email]'";
            $res3= mysqli_query($conn, $sql3);
            $count3=mysqli_num_rows($res3);
            if($count3==1)
            {
                //we have data
                //get the data from databse
                $row3= mysqli_fetch_assoc($res3);
                $customer_id= $row3['id'];
            }
            else
            {
                //cake not available and redirect to home page
                header('location:'.SITEURL);
            }

            //$payment_method= $_POST['payment_method'];
            if(isset($_POST['payment_method']))
            {
                $payment_method= $_POST['payment_method'];
            }
            else
            {
                $payment_method= "Cash on Delivery";
            }

            //save the order in databse
            //create a sql to save a data
            $sql2="INSERT INTO tbl_order SET
                customer_id= $customer_id,
                cake= '$cake',
                price= $price,
                qty= $qty,
                total= $total,
                order_date= '$order_date',
                status= '$status',
                customer_name= '$customer_name',
                customer_contact= '$customer_contact',
                customer_email= '$customer_email',
                customer_address= '$customer_address',
                bill_status= 0,
                payment_method= '$payment_method',
                payment_status= 'Not Done Yet'
            ";

            //execute the query
            $res2= mysqli_query($conn,$sql2);

            //check whether query execute successfully or not
            if($res2==true)
            {
                if($_POST['payment_method']=='Cash on Delivery')
                {
                    //$payment_method= $_POST['payment_method'];
                    $_SESSION['payment-method']="<div class='success text-center'>Thanks for ordering cake!!</div>";
                    // header('location:'.SITEURL.'bill.php');
                    ?>
                    <script>
                        window.location.href='bill.php';
                    </script>
                    <?php
                }
                elseif ($_POST['payment_method']=='Online Payment')
                {
                    # code...
                    //echo"okay";
                    //$payment_method= $_POST['payment_method'];
                    $_SESSION['payment-method']="<div class='success text-center'>Proceed to online payment</div>";
                    // header('location:'.SITEURL.'order.php');   
                    ?>
                    <script>
                        window.location.href='razorpay-api/pay.php';
                    </script>
                    <?php
                }
                else
                {
                    $_SESSION['payment-method']="<div class='error text-center'>Please select Payment Method !!!</div>";
                    // header('location:'.SITEURL.'order.php');   
                    ?>
                    <script>
                        window.location.href='';
                    </script>
                    <?php
                }
                    
            }
            else
            {
                //failed to save order
                $_SESSION['order']="<div class='error text-center'>Failed to Oreder cake.</div>";
                header('location:'.SITEURL);   
            }
        }
    ?>
</div>
</section>
<!-- cake sEARCH Section Ends Here -->