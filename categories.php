<?php include ('partials-user/menu.php'); ?>

    <!-- Categories-->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>


            <?php 

                //display all the categories that are active
                //sql query
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check whether categories available or not
                if($count>0)
                {
                    //categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get all the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?> 
                            <a href="<?php echo SITEURL?>categories-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">

                                <?php
                                    if($image_name=="")
                                    {
                                        //image not availavle
                                         echo "Image not found.";
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
                    echo "Category not found.";
                }

            ?>



            <div class="clearfix"></div>
        </div>
    </section>


<?php include ('partials-user/footer.php'); ?>