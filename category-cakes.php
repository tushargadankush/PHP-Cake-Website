<?php include('partials-front/menu.php');?>

<?php
    //check whether id pass or not
    if(isset($_GET['category_id']))
    {
        //category id is set and get id
        $category_id= $_GET['category_id'];
        // get the category title based on category id
        $sql="SELECT title FROM tbl_category WHERE id=$category_id";

        //execute the query
        $res=mysqli_query($conn, $sql);

        //get values from databse
        $row= mysqli_fetch_assoc($res);

        //get tittle
        $category_title= $row['title'];
    }
    else
    {
        //category not passed
        //redirect to home page
        header('location:'.SITEURL);
    }
?>

    <!-- cake sEARCH Section Starts Here -->
    <section class="cake-search text-center">
        <div class="container">
            
            <h2>Cakes on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- cake sEARCH Section Ends Here -->



    <!-- cake MEnu Section Starts Here -->
    <section class="cake-menu">
        <div class="container">
            <h2 class="text-center">Cake Menu</h2>

            <?php
                //create a sql query to get a cakes based on selected category
                $sql2= "SELECT * FROM tbl_cake WHERE category_id=$category_id";

                //execute the query
                $res2= mysqli_query($conn, $sql2);

                //counts the rows
                $count2= mysqli_num_rows($res2);

                //check whether cake is available or not
                if($count2>0)
                {
                    //cake is available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        //get values
                        $id= $row2['id'];
                        $title= $row2['title'];
                        $price= $row2['price'];
                        $description= $row2['description'];
                        $image_name= $row2['image_name'];
                        ?>
                        <div class="cake-menu-box">
                            <div class="cake-menu-img">
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
                                    <img src="<?php echo SITEURL;?>images/cake/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                                ?>
                                
                            </div>

                            <div class="cake-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="cake-price">$<?php echo $price; ?></p>
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
                    echo "<div class='error'>Cake Not Avaialable.</div>";
                }
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- cake Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>