<?php include('partials/menu.php'); ?>


<?php 

	//check whteher id is set or not
	if(isset($_GET['id']))
	{
		//get all the details
		$id = $_GET['id'];

		//sql query to get the selected food
		$sql2 = "SELECT * FROM tbl_food WHERE id=$id";

		//execute the query
		$res2 = mysqli_query($conn, $sql2);

		//get the value based on query executed
		$row2 = mysqli_fetch_assoc($res2);

		//get the individual values of selected food
		$title = $row2['title'];
		$description = $row2['description'];
		$price = $row2['price'];
		$current_image = $row2['image_name'];
		$current_category = $row2['category_id'];
		$featured = $row2['featured'];
		$active = $row2['active'];
	}
	else
	{
		//redirect to manage food
		header("location:".SITEURL.'admin/manage-food.php');
	}
?>

	
<div class="main-content">
		<div class="wrapper">
			<h1>Update Food</h1>
			<br><br>

			<form action="" method="POST" enctype="multipart/form-data">
				<table class="tbl-30">
					
					<tr>
						<td>Title: </td>
						<td>
							<input type="text" name="title" value="<?php echo $title;?>">
						</td>
					</tr>

					<tr>
						<td>Description: </td>
						<td>
							<textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
						</td>
					</tr>

					<tr>
						<td>Price: </td>
						<td>
							<input type="number" name="price" value="<?php echo $price;?>">
						</td>
					</tr>

					<tr>
						<td>Current Image: </td>
						<td>
							<?php

								if($current_image == "")
								{
									//image not available
									echo "Image not available.";
								}
								else
								{
									//image is there
									?>

									<img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" width="100px">

									<?php
								}

							?>
						</td>
					</tr>

					<tr>
						<td>Select New Image: </td>
						<td>
							<input type="file" name="image">
						</td>
					</tr>

					<tr>
						<td>Category: </td>
						<td>
							<select name="category">
								<?php
									//query to get active categories
									$sql = "SELECT * FROM tbl_category WHERE active='Yes'";
									//execute the query
									$res = mysqli_query($conn, $sql);

									//count rows
									$count = mysqli_num_rows($res);

									//check whether category avaialble or not
									if($count>0)
									{
										//category available
										while ($row=mysqli_fetch_assoc($res)) 
										{
											$category_title = $row['title'];
											$category_id = $row['id'];

											//echo "<option value='$category_id'>$category_title</option>";

											?>

												<option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id;?>"><?php echo $category_title; ?></option>

											<?php
										}
									}
									else
									{
										//category not available
										echo "<option value='0'>Category not available</option>";
									}

								?> 

							</select>
						</td>
					</tr>

					<tr>
						<td>Featured: </td>
						<td>
							<input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
							<input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
						</td>
					</tr>

					<tr>
						<td>Active: </td>
						<td>
							<input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
							<input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
						</td>
					</tr>

					<tr>
						<td>
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
							<input type="submit" name="submit" value="Update Food" class="btn-secondary">
						</td>
					</tr>


				</table>
			</form>

			<?php 

				if(isset($_POST['submit']))
				{
					//echo "button clicked";

					//1. get all the details from the form 
					$id = $_POST['id'];
					$title = $_POST['title'];
					$description = $_POST['description'];
					$price = $_POST['price'];
					$current_image = $_POST['current_image'];
					$category = $_POST['category'];

					$featured = $_POST['featured'];
					$active = $_POST['active'];

					//check whether upload button is clicked or not
					if(isset($_FILES['image']['name']))
					{
						//upload button clicked
						$image_name = $_FILES['image']['name']; //new image name

						//check whether the file is available or not
						if($image_name!="")
						{
							//image is available
							//upload new image
							//rename the image
							$ext = end(explode('.', $image_name)); //get the extension of the image

							$image_name = "Food-Name-".rand(000,999).'.'.$ext; //rename image

							//get the src path and destination path
							$src_path = $_FILES['image']['tmp_name']; //src path

							$dst_path = "../images/food/".$image_name; //dest path

							//upload imge
							$upload = move_uploaded_file($src_path, $dst_path);

							//check whether the image is uploaded or not
							if($upload==false)
							{
								//failed to upload
								$_SESSION['upload'] = "Failed to upload new image.";
								header("location:".SITEURL.'admin/manage-food.php');
								//stop the procees
								die();
							}
							//2. upload the image if selected
							//3. remove the image if new image is upload and current image exists
							//remove current image if available
							if($current_image != "")
							{
								//removeimage
								$remove_path = "../images/food/".$current_image;

								$remove = unlink($remove_path);

								//check whether the image is removed or not
								if($remove==false)
								{
									//failed to remove current image
									$_SESSION['remove-failed']="Failed to remove current image.";

									//redirect to manage food
									header("location:".SITEURL.'admin/manage-food.php');
									//stop the process
									die();
								}
							}

						}
						else
						{
							$image_name = $current_image; //default image when image is not selected
						}
					}
					else
					{
						$image_name = $current_image; //default image when button is no clicked
					}

					//4. update the food in database
					$sql3 = "UPDATE tbl_food SET 
					 title='$title',
					 description='$description',
					 price=$price,
					 image_name='$image_name',
					 category_id='$category',
					 featured='$featured',
					 active='$active'
					 WHERE id=$id
					 ";

					 //execute the sql query
					 $res3 = mysqli_query($conn,$sql3);

					 //check whether the query is executed or not
					 if($res3==true)
					 {
					 	//query executed and food updated
					 	$_SESSION['update'] = "Food updated successfully.";
					 	header("location:".SITEURL.'admin/manage-food.php');
					 }
					 else
					 {
					 	$_SESSION['update'] = "Failed to update food.";
					 	header("location:".SITEURL.'admin/manage-food.php');
					 }


				}

			?>



		</div>
	</div>

<?php include('partials/footer.php'); ?>