<?php include('partials/menu.php')?> 
<!-- include it takes your another file on this file -->


<!-- main content section start -->
        <div class="main-content">
            <div class="wrapper">
               <h1>Dashboard</h1>
               <br><br>
               <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                ?>
                <br><br>

                <div class="col-4 text-center">
                    <?php
                        //sql querry
                        $sql="SELECT * FROM tbl_category";
                        //execute the querry
                        $res= mysqli_query($conn,$sql);
                        //count rows
                        $count= mysqli_num_rows($res);
                    ?>

                    <h1><?php echo $count; ?></h1>
                    <br>
                    <h4>Categories</h4>
                </div>
                
                
                <div class="col-4 text-center">
                    <?php
                        //sql querry
                        $sql2="SELECT * FROM tbl_cake";
                        //execute the querry
                        $res2= mysqli_query($conn,$sql2);
                        //count rows
                        $count2= mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1>
                    <br>
                    <h4>Cakes</h4>
                </div>
                
                
                <div class="col-4 text-center">
                    <?php
                        //sql querry
                        $sql3="SELECT * FROM tbl_order";
                        //execute the querry
                        $res3= mysqli_query($conn,$sql3);
                        //count rows
                        $count3= mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $count3; ?></h1>
                    <br>
                    <h4>Total Orders</h4>
                </div>
                
                
                <div class="col-4 text-center">
                    <?php
                        //create sql query to get total revenue
                        //aggragate function in sql
                        $sql4="SELECT sum(total) AS Total FROM tbl_order WHERE status='Delivered'";
                        //execute the querry
                        $res4= mysqli_query($conn,$sql4);

                        //get the value 
                        $row4= mysqli_fetch_assoc($res4);

                        //get a total revenue
                        $null_total=00;
                        $total_revenue= $row4['Total']+$null_total;

                    ?>
                    <h1><?php echo $total_revenue; ?>.Rs/-</h1>
                    <br>
                    <h4>Revenue Generated</h4>
                </div>
                
                <div class="clearfix"></div>
            </div>  
        </div>
        <!-- main content section is end -->
        
<?php include('partials/footer.php')?> 
        
        
       