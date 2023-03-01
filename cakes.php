<?php include('partials-front/menu.php');?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="cake-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL;?>cake-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Cake.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="cake-menu">
        <div class="container">
            <h2 class="text-center">Cake Menu</h2>

            <?php
                //dispaly cake that are avtive
                $sql="SELECT * FROM tbl_cake WHERE active='Yes'";

                //execute the query
                $res= mysqli_query($conn, $sql);

                //count rows 
                $count= mysqli_num_rows($res);

                //check whether cake are avaialable ornot
                if($count>0)
                {
                    //cake is available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values
                        $id= $row['id'];
                        $title= $row['title'];
                        $price= $row['price'];
                        $description= $row['description'];
                        $image_name= $row['image_name'];
                        ?>
                        
                        <div class="cake-menu-box">
                            <div class="cake-menu-img">
                                <?php
                                    //check whether image is avaialable or not
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
                                <h4><?php echo $title;?></h4>
                                <p class="cake-price">Rs.<?php echo $price; ?></p>
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
                    echo "<div class='error'>Cake Not Found.</div>";
                }
            ?>

            
            


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>
