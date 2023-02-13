
<?php include('partials-user/menu.php'); ?>


    <?php 

        //check whether food id is set or not
        if(isset($_GET['food_id']))
        {
            //get the food id and details of the selected food
            $food_id = $_GET['food_id'];

            //get the details of the selected food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

            //execute the query
            $res=mysqli_query($conn, $sql);

            //count rows
            $count = mysqli_num_rows($res);

            //check whether the data is available or not
            if($count==1)
            {
                //data available
                //get the data from databsaee
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];

            }
            else
            {
                //redirect to homepage
                header("location:".SITEURL);
            }
        }
        else
        {
            //redirect to homepage
            header("location:".SITEURL);
        }

    ?>


    <!-- Order details -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

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
                        <h3><?php echo $title; ?></h3>

                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">RM<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. P. Ramlee" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 014-667XXXX" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. ramleep@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php

                //check whether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //get the data
                    $food=$_POST['food'];
                    $price=$_POST['price'];
                    $qty=$_POST['qty'];

                    $total = $price * $qty;
                    
                    $order_date= date("Y-m-d H:i:s"); //order date

                    $status="Ordered"; //orderd on delivery, deliverd , canceled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //save the order in database
                    //create sql to save data
                    $sql2 = "INSERT INTO tbl_order SET
                        food='$food',
                        price=$price,
                        qty=$qty,
                        total=$total,
                        order_date='$order_date',
                        status='$status',
                        customer_name='$customer_name',
                        customer_contact='$customer_contact',
                        customer_email='$customer_email',
                        customer_address='$customer_address'
                    ";

                    //echo $sql2; die();

                    //execute query
                    $res2 = mysqli_query($conn, $sql2);

                    //check whether query executed or not
                    if($res2==true)
                    {
                        //query executed and oder saved
                        $_SESSION['order']="<div class='success text-center'>Food Ordered Successfully.</div>";
                        header("location:".SITEURL);
                    }
                    else
                    {
                        $_SESSION['order']="<div class='error text-center'>Failed to order food.</div>";
                        header("location:".SITEURL);
                    }
                }
            ?>

        </div>
    </section>

<?php include('partials-user/footer.php'); ?>