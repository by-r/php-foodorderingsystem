<?php

	//include constants.php file here
	include('../config/constants.php');

	//1. get the id of admin to be deleted
	echo $id = $_GET['id'];

	//2. create sql query to delete admin
	$sql = "DELETE FROM tbl_admin WHERE id=$id";

	//execute the query
	$res = mysqli_query($conn, $sql);

	//check whether the query executed succesfully or not
	if($res==TRUE)
	{
		//query executed successfully and admin deleted
		//echo "Admin deleted";

		//create session variabe to display message 
		$_SESSION['delete'] = "Admin Deleted Successfully.";
		//redirect to manage admin page
		header('location:'.SITEURL.'admin/manage-admin.php');
	}
	else
	{
		//echo "Failed to delete admin";
		$_SESSION['delete'] = "Failed to delete admin. Try again later.";

		header('location:'.SITEURL.'admin/manage-admin.php');
	}

	//3. redirect to manage admin page with message (success/error)

?>