<?php include('config/constants.php'); ?>


<html>
<head>
	<meta charset="utf-8">
	<!--To make the website responsive-->
	<meta name="viewport" content="witdh-device-width, initial-scale=1.0">
	<title>Food Order System</title>

	<!--css-->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Navigation bar of the website-->
    <section class="navbar">
        <div class="container">
            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>foods.php">Foods</a>
                    </li>
                    <li>
                    	<a href="admin/login.php">Login</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>