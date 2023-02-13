<?php include('../config/constants.php'); ?>

<html>
<head>
	<title>Login - Food Ordering System</title>
	<link rel="stylesheet" href="../css/admin.css">
</head>
<body>
	<div class="login">
		<h1 class="text-center">Login</h1>

		<br><br>

		<?php 
			if(isset($_SESSION['login']))
			{
				echo $_SESSION['login'];
				unset($_SESSION['login']);
			}

			if(isset($_SESSION['no-login-message']))
			{
				echo $_SESSION['no-login-message'];
				unset($_SESSION['no-login-message']);
			}
		?>
		<br><br>
		<!-- login start here -->
		<form action="" method="POST" class="text-center">
			Username: <br>
			<input type="text" name="username" placeholder="Enter Username"><br>

			<br>

			Password: <br>
			<input type="password" name="password" placeholder="Enter Password"><br>

			<br>

			<input type="submit" name="submit" value="Login" class="btn-primary">
			<br><br>
			<a href="../index.php">Back to homepage</a>

		</form>
		<!-- login end here-->


		<p class="text-center">Admin - Food Ordering System</p>
	</div>
</body>
</html>

<?php 

	//check whether the submit button is submit or not
	if(isset($_POST['submit']))
	{
		//process for login
		//1. get the data from login form
		$username = $_POST['username'];
		$password = md5($_POST['password']);

		//2. sql to check whether the user with username and password exist or not
		$sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' ";

		//3. execute the query
		$res = mysqli_query($conn, $sql);

		//4. count rows to check whether the user exist or not
		$count = mysqli_num_rows($res);

		if($count==1)
		{
			//user available
			$_SESSION['login']="Login successful.";
			$_SESSION['user']=$username; //to check whether the user is logged in or not and logout will unset it
			//redirect to the homepage
			header("location:".SITEURL.'admin/');
		}
		else
		{
			//user not available
			$_SESSION['login']= "<div class='text-center'>Failed to login.</div>";
			//redirect to the homepage
			header("location:".SITEURL.'admin/login.php');
		}
	}

?>