<?php include('partials-user/menu.php'); ?>


    <?php
        //check whether id is passed or not
        if(isset($_GET['category_id']))
        {
            //catg id is set and get the id
            $category_id = $_GET['category_id'];
            //GET THE CATEG title based on catg_id
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //get the value from database
            $row=mysqli_fetch_assoc($res);

            //get the title
            $category_title=$row['title'];
        }
        else
        {
            //category not passed
            //redirect to home page
            header("location:".SITEURL);
        }
    ?>



    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>


            <?php
                //create sql query to get the foods based on selected category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //count rows to check whether the food is available or not
                $count2 = mysqli_num_rows($res2);

                //check whether food is available or not
                if($count2>0)
                {
                    //food availabel
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
                else
                {
                    //food not available
                    echo "Food not available.";
                }

            ?>



            <div class="clearfix"></div>
        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-user/footer.php'); ?>