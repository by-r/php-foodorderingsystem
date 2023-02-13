<?php include('partials-user/menu.php'); ?>

    <!--search box for food-->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="search" class="btn btn-primary">
            </form>

        </div>
    </section>


    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset ($_SESSION['order']);
        }
    ?>


    <!-- show food categories in the website  -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>


            <?php 
                //create SQL query to diplay categories from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values like id, title , img name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                            <a href="<?php echo SITEURL?>categories-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">

                                <?php
                                    //check whether imge is available or not
                                    if ($image_name=="") 
                                    {
                                        //display message
                                        echo "Image not available.";
                                    }
                                    else
                                    {
                                        //image available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Rice" class="img-responsive img-curve">
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
                    //categories not available
                    echo "Category not added";
                }
            ?>



            <div class="clearfix"></div>
        </div>
    </section>

    <!-- show food menu in the website -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

                //geting food from database that are active and featured
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

                $res2 = mysqli_query($conn, $sql2);

                //count rows
                $count2 = mysqli_num_rows($res2);

                //check wheter food is available or not
                if($count2>0)
                {
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $id=$row2['id'];
                        $title=$row2['title'];
                        $price=$row2['price'];
                        $description=$row2['description'];
                        $image_name=$row2['image_name'];
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

            ?>

            

            <div class="clearfix"></div>
        </div>
    </section>

<?php include('partials-user/footer.php'); ?>