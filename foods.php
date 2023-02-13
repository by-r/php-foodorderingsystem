<?php include('partials-user/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="search" class="btn btn-primary">
            </form>

        </div>
    </section>

     <!-- show food menu in the website -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
                //display food that are active
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                //execute the query
                $res=mysqli_query($conn, $sql);

                //count row
                $count = mysqli_num_rows($res);

                //check whether the foods are available or not
                if($count>0)
                {
                    //foods available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values
                        $id=$row['id'];
                        $title=$row['title'];
                        $price=$row['price'];
                        $description=$row['description'];
                        $image_name=$row['image_name'];
                        ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">


                                    <?php
                                        if($image_name=="")
                                        {
                                            //image not available
                                            echo "Image not available.";
                                        }
                                        else
                                        {
                                            //imag available
                                            ?>
                                            <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name; ?>" alt="Nasi Lemak" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>


                                    
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">RM<?php echo $price; ?></p>
                                    <p class="food-detail">
                                    <?php echo $description; ?> 
                                    </p>
                                    <br>

                                    <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                        <?php
                    }
                }
                else
                {
                    //food not
                    echo "Food not found.";
                }

            ?>          

            <div class="clearfix"></div>

            

        </div>
    </section>

 <?php include('partials-user/footer.php'); ?>