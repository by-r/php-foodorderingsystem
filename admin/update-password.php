<?php include('partials/menu.php'); 
?>

<div class="main-content">
	<div class="wrapper">
		<h1>Change Password</h1>
		<br><br>


		<?php 
			if(isset($_GET['id']))
			{
				$id=$_GET['id'];
			}
		?>


		<form action="" method="POST">
			
			<table class="tbl-30">
				<tr>
					<td>Current Password: </td>
					<td>
						<input type="password" name="current_password" placeholder="Current Password">
					</td>
				</tr>

				<tr>
					<td>New Password: </td>
					<td>
						<input type="password" name="new_password" placeholder="New Password">
					</td>
				</tr>

				<tr>
					<td>Confirm Password: </td>
					<td>
						<input type="password" name="confirm_password" placeholder="Confirm Password">
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" value="Change Password" class="btn-secondary">
					</td>
				</tr>
			</table>

		</form>
	</div>
</div>

<?php 

	//check whether the submit button is clicked or not
	if(isset($_POST['submit']))
	{
		//echo "Clicked";

		//1. get the data from form
		$id=$_POST['id'];
		$current_password = md5($_POST['current_password']);
		$new_password = md5($_POST['new_password']);
		$confirm_password = md5($_POST['confirm_password']);

		//2. check whether the user with current id and current password exists or not
		$sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

		//execute the query
		$res = mysqli_query($conn, $sql);

		if($res==TRUE)
		{
			//check whether data is available or not
			$count=mysqli_num_rows($res);

			if($count==1)
			{
				//user exist and pass can be changed
				//echo "User found";
				//check new and confirm passworm match or not

				if($new_password==$confirm_password)
				{
					//update password
					$sql2 = "UPDATE tbl_admin SET 
					password='$new_password' 
					WHERE id=$id
					";

					//executte query
					$res2 = mysqli_query($conn, $sql2);

					//check whether the query executed or not
					if($res2==TRUE)
					{
						//display success message
						$_SESSION['change-pwd']= "Password changed Succesfully.";
						header('location:'.SITEURL.'admin/manage-admin.php');
					}
					else
					{
						$_SESSION['change-pwd']= "Failed to change password.";
						header('location:'.SITEURL.'admin/manage-admin.php');
					}
				}
				else
				{
				//user does not exist set message and redirect
				$_SESSION['pwd-not-match']= "Password not match.";
				header('location:'.SITEURL.'admin/manage-admin.php');
				}
			}
			else
			{
				//user does not exist set message and redirect
				$_SESSION['user-not-found']= "User not found.";
				header('location:'.SITEURL.'admin/manage-admin.php');
			}
		}

		//3. check whether the new password and confirm password mathch or not

		//4. change password if all above is true
	}

?>

<?php include('partials/footer.php'); 
?>