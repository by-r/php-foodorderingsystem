
<?php include('partials/menu.php'); 
?>

		<!-- Main content -->
		<div class="main-content">
			<div class="wrapper">
				<h1>Manage Admin</h1> <br/>
				<?php
					if(isset($_SESSION['add']))
					{
						echo $_SESSION['add']; //displaying session message
						unset ($_SESSION['add']); //removing session message
					}

					if(isset($_SESSION['delete']))
					{
						echo $_SESSION['delete'];
						unset ($_SESSION['delete']);
					}

					if(isset($_SESSION['update']))
					{
						echo $_SESSION['update'];
						unset ($_SESSION['update']);
					}

					if(isset($_SESSION['user-not-found']))
					{
						echo $_SESSION['user-not-found'];
						unset ($_SESSION['user-not-found']);
					}

					if(isset($_SESSION['pwd-not-match']))
					{
						echo $_SESSION['pwd-not-match'];
						unset ($_SESSION['pwd-not-match']);
					}

					if(isset($_SESSION['change-pwd']))
					{
						echo $_SESSION['change-pwd'];
						unset ($_SESSION['change-pwd']);
					}


				?>
				<br/><br/>

				<!-- button to add admin -->
				<a href="add-admin.php" class="btn-primary">Add Admin</a>
				<br/><br/><br/>
				<table class="tbl-full">
					<tr>
						<th>ID</th>
						<th>Full Name</th>
						<th>User Name</th>
						<th>Actions</th>
					</tr>


					<?php 
						//query to set all admin
						$sql = "SELECT * FROM tbl_admin";

						//execute the query
						$res = mysqli_query($conn,$sql);

						//check whether the query is executed or not
						if ($res==TRUE)
						{
							//count rows to check whether we have data in database or not
							$count = mysqli_num_rows($res);//function to get all the rows in database

							$sn=1; //create a variable and assign the value


							//check the num of rows
							if($count>0)
							{
								//we have data in database
								while($rows=mysqli_fetch_assoc($res))
								{
									//using while loop to get all the data from database
									//and while loop run as long as we have data in database

									//get individual data
									$id=$rows['id'];
									$full_name=$rows['full_name'];
									$username=$rows['username'];

									//display the values in the table
									?>
										<tr>
											<td><?php echo $sn++; ?></td>
											<td><?php echo $full_name; ?></td>
											<td><?php echo $username; ?></td>
											<td>
												<a href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a>
												<a href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
												<a href= "<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-delete">Delete Admin</a>
											</td>
										</tr>
									<?php

								}
							}
							else
							{
								//dont have data in database
							}
						}
					?>


				</table>

				<div class="clearfix"></div>

			</div>
		</div>
		<!-- Main content end -->

<?php include('partials/footer.php'); 
?>