<?php 

	//include constants.php
	include('../config/constants.php');


	//echo "Delete";
	//check whether the id and image name value is set or not

	if(isset($_GET['id']) AND isset($_GET['image_name']))
	{
		//get the value and delete
		//echo "get value and delete";
		$id = $_GET['id'];
		$image_name = $_GET['image_name'];

		//remove the physical image file if availble
		if($image_name != "")
		{
			//image is avaible. so remove
			$path = "../images/category/".$image_name;

			//remove the image
			$remove = unlink($path);

			//if failde to remove image then add an erro message and stop the proces
			if($remove==false)
			{
				//set the session message
				$_SESSION['remove']="Failed to remove image.";
				//redirect to manage category page
				header("location:".SITEURL.'admin/manage-category.php');
				// stop the process
				die();	
			}

		}

		//delete data from database
		//sql query delete data from database
		$sql = "DELETE FROM tbl_category WHERE id=$id";

		//execute the query
		$res = mysqli_query($conn, $sql);

		//check whether the data is delete from database or not
		if($res==TRUE)
		{
			//set success message and redirect
			$_SESSION['delete']="Category deleted successfully.";

			header("location:".SITEURL.'admin/manage-category.php');
		}
		else
		{
			//set fail mesage and redirect
			$_SESSION['delete']="Failed to delete category.";

			header("location:".SITEURL.'admin/manage-category.php');
		}

	}
	else
	{
		//redirect to manage category page
		header("location:".SITEURL.'admin/manage-category.php');
	}
?>