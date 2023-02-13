
<?php include('partials/menu.php'); 
?>

		<!-- Main content -->
		<div class="main-content">
			<div class="wrapper">
				<h1>Manage Food</h1><br/><br/>
				<!-- button to add admin -->
				<a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
				<br/><br/><br/>


				<?php 

					if(isset($_SESSION['add']))
					{
						echo $_SESSION['add'];
						unset($_SESSION['add']);
					}

					if(isset($_SESSION['delete']))
					{
						echo $_SESSION['delete'];
						unset($_SESSION['delete']);
					}

					if(isset($_SESSION['upload']))
					{
						echo $_SESSION['upload'];
						unset($_SESSION['upload']);
					}


					if(isset($_SESSION['unauthorized']))
					{
						echo $_SESSION['unauthorized'];
						unset($_SESSION['unauthorized']);
					}


					if(isset($_SESSION['update']))
					{
						echo $_SESSION['update'];
						unset($_SESSION['update']);
					}

					if(isset($_SESSION['remove-failed']))
					{
						echo $_SESSION['remove-failed'];
						unset($_SESSION['remove-failed']);
					}

				?>


				<table class="tbl-full">
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Price</th>
						<th>Image</th>
						<th>Featured</th>
						<th>Active</th>
						<th>Action</th>
					</tr>


					<?php 

						//create a sql query to get all the food
						$sql = "SELECT * FROM tbl_food";

						//execute the query
						$res = mysqli_query($conn, $sql);

						//$count rows to check whether wwe have food or not
						$count = mysqli_num_rows($res);

						//CREATE ID and set value as 1
						$sn=1;

						if($count>0)
						{
							//have food in database
							//get the food from databse and display
							while($row=mysqli_fetch_assoc($res))
							{
								//get the value from individual column
								$id = $row['id'];
								$title = $row['title'];
								$price = $row['price'];
								$image_name = $row['image_name'];
								$featured = $row['featured'];
								$active = $row['active'];
								?>

									<tr>
										<td><?php echo $sn++; ?></td>
										<td><?php echo $title; ?></td>
										<td>RM<?php echo $price; ?></td>
										<td>
											<?php 
												//check whether we have image or not
												if($image_name=="")
												{
													//we do not have immage
													echo "Image not added.";
												}
												else
												{
													//we have image
													?>
													<img src="<?php echo SITEURL ;?>images/food/<?php echo $image_name;?>" width="100px">
													<?php
												}
											?>	
										</td>
										<td><?php echo $featured; ?></td>
										<td><?php echo $active; ?></td>
										<td>
											<a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a>
											<a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id;?>&image_name=<?php echo $image_name; ?>" class="btn-delete">Delete Food</a>
										</td>
									</tr>

								<?php
							}
						}
						else
						{
							//food not added in database
							echo "<tr> <td colspan='7'>Food not added yet. </td></tr>";
						}

					?>


				</table>



				<div class="clearfix"></div>

			</div>
		</div>
		<!-- Main content end -->

<?php include('partials/footer.php'); 
?>