<?php include('partials-front/menu.php');?>

    <!-- cake sEARCH Section Starts Here -->
    <section class="cake-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>cake-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Cake.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- cake sEARCH Section Ends Here -->
    <?php
    if(isset($_SESSION['login']))
    {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
    ?>
    <br>
    
    <?php
        if(isset($_SESSION['verification_code']))
        {
            echo $_SESSION['verification_code'];
            unset($_SESSION['verification_code']);
        }
        ?>
        <br>
    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
        ?>
        <br>
    <?php
        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        ?>
    <?php
        if(isset($_SESSION['B-update']))
        {
            echo $_SESSION['B-update'];
            unset($_SESSION['B-update']);
        }
        ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Cakes</h2>

            <?php
                //ceate a sql query to dispaly categories from database
                $sql= "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 4";
                //execute the querry
                $res= mysqli_query($conn, $sql);
                // count rows to check whether the category is available
                $count= mysqli_num_rows($res);

                if($count>0)
                {
                    //categories are available
                    while($row= mysqli_fetch_assoc($res))
                    {
                        //get vaules like titles,image_name,id
                        $id= $row['id'];
                        $title= $row['title'];
                        $image_name= $row['image_name'];
                        ?>
                        <a href="<?php echo SITEURL;?>category-cakes.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    //check wheter image is available or not
                                    if($image_name=="")
                                    {
                                        //display msg
                                        echo "<div class='error'>Image Not Available.</div>";
                                    }
                                    else
                                    {
                                        //iamge available
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive">
                                        <?php
                                    }
                                ?>
                            
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    //categories are not available
                    echo"<div class='error'>Category Not Added.</div>";
                }
            ?>


            
            <div class="clearfix"></div>
            <br>
            <p class="text-center">
                <a href="categories.php">See All Categories</a>
            </p>
            <br>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <!-- cake MEnu Section Starts Here -->
    <section class="cake-menu">
        <div class="container">
            <h2 class="text-center">Cake Menu</h2>

            <?php
            //getting a cake from database that are active and featured

            //sql querry
            $sql2="SELECT * FROM tbl_cake WHERE active='Yes' AND featured='Yes' LIMIT 6";
            
            //execute the query
            $res2= mysqli_query($conn, $sql2);

            //count rows 
            $count2= mysqli_num_rows($res2);

            //check whether the cake is availabl or not
            if ($count2>0)
            {
                //cake available
                while($row=mysqli_fetch_assoc($res2))
                {
                    //get all the values
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
                        <p class="cake-price"><?php echo $price;?> Rs/-</p>
                        <p class="cake-detail"><?php echo $description;?></p>
                        <br>

                        <a href="<?php echo SITEURL;?>order.php?cake_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        
                    </div>
                </div>
                    <?php
                }
            }
            else
            {
                //cake not available
                echo "<div class='error'>Cake Not Available.</div>";
            }
            ?>

            
            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="cakes.php">See All Cakes</a>
        </p>
    </section>
    <!-- cake Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>