<?php include('partials-front/menu.php');?>

    <!-- cake sEARCH Section Starts Here -->
    <section class="cake-search text-center">
        <div class="container">
            <?php
                //get the search keyword
                // old query $search= $_POST['search'];
                $search= mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            <h2>Cakes on Your Search <a href="#" class="text-white">"<?php echo $search;?>"</a></h2>

        </div>
    </section>
    <!-- cake sEARCH Section Ends Here -->



    <!-- cake MEnu Section Starts Here -->
    <section class="cake-menu">
        <div class="container">
            <h2 class="text-center">Cake Menu</h2>

            <?php

                //sql query to get cake based on search keyword
                // $search = burger' drop databse name
                //"SELECT * FROM tbl_cake WHERE title LIKE '% burger%' OR description LIKE '% burger%'"; 
                $sql= "SELECT * FROM tbl_cake WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //execute the query
                $res=mysqli_query($conn,$sql);

                //count the row
                $count= mysqli_num_rows($res);

                //check whether cake avaialable or not
                if($count>0)
                {
                    //cake avaialable
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get all values from databse
                        $id= $row['id'];
                        $title= $row['title'];
                        $price= $row['price'];
                        $description= $row['description'];
                        $image_name= $row['image_name'];
                        ?>
                        <div class="cake-menu-box">
                            <div class="cake-menu-img">
                            <?php
                                //check whether imag eis avaialable or not
                                if($image_name=="")
                                {
                                    //image not available
                                    echo "<div class='error'>Image Not Available.</div>";
                                }
                                else
                                {
                                    //image is available
                                    ?>
                                        <img src="<?php echo SITEURL;?>images/cake/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            </div>

                            <div class="cake-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="cake-price"><?php echo $price; ?> Rs/-</p>
                                <p class="cake-detail"><?php echo $description; ?></p>
                                <br>
                                <a href="<?php echo SITEURL;?>order.php?cake_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    //cake not avaialable
                    echo "<div class='error text-center'> Cake Not Found. </div>";
                }
            ?>



            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- cake Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>