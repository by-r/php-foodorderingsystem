<?php
	
	//include constants page
	include('../config/constants.php');

	//echo "delete test";
	
	if(isset($_GET['id']) && isset($_GET['image_name'])) //can use && or AND
	{
		//process to delete
		//echo "process to delete";
		
		//1. get id and image name
		$id = $_GET['id'];
		$image_name = $_GET['image_name'];


		//2. remove the image if available
		//check whether the image is available or not and delete only if availavble
		if($image_name != "")
		{
			//if has imgae and need to remove from folder
			//get the image path
			$path = "../images/food/".$image_name;

			//remove image file from folder
			$remove = unlink($path);

			//check whether the image is remove or not
			if($remove==false)
			{
				//failed to remvoe image
				$_SESSION['upload'] = "Failed to remove image file.";
				//redirect to manage food page
				header("location:".SITEURL.'admin/manage-food.php');
				//stop the process
				die();
			}
		}


		//3. delete food from database
		$sql = "DELETE FROM tbl_food WHERE id=$id";

		//execute the query
		$res = mysqli_query($conn, $sql);

		//check whether query executed or not and set the session message respectively
		//4. redirect to manage food with session message
		if($res==true)
		{
			//food deleted
			$_SESSION['delete'] = "Food deleted successfully";
			header("location:".SITEURL.'admin/manage-food.php');
		}
		else
		{
			$_SESSION['delete'] = "Failed to delete food.";
			header("location:".SITEURL.'admin/manage-food.php');
		}

	}
	else
	{
		//redirect to manage food page
		$_SESSION['unauthorized']="Unauthorized access.";
		header("location:".SITEURL.'admin/manage-food.php');
	}
?>