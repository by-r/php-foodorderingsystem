<?php include('partials/menu.php'); ?>
	<div class="main-content">
		<div class="wrapper">
			<h1>Update Category</h1>

			<br><br>

		<?php 

			//check whether the id is set or not
			if(isset($_GET['id']))
			{
				//get the id and all other details
				//echo "Test";
				$id = $_GET['id'];

				//create sql query to get all other details
				$sql = "SELECT * FROM tbl_category WHERE id=$id";

				//execute the query
				$res = mysqli_query($conn, $sql);

				//count the rows to check whether the id is valid or not
				$count = mysqli_num_rows($res);
				if($count==1)
				{
					//get all the data
					$row = mysqli_fetch_assoc($res);
					$title = $row['title'];
					$current_image = $row['image_name'];
					$featured = $row['featured'];
					$active = $row['active'];
				}
				else
				{
					//redirect to manage category with session message
					$_SESSION['no-category-found'] = "Category not found.";
					header("location:".SITEURL.'admin/manage-category.php');
				}
			}
			else
			{
				//redirect to anage category
				header("location:".SITEURL.'admin/manage-category.php');
			}

		?>

		<form action="" method="POST" enctype="multipart/form-data">
			<table class="tbl-30">
				<tr>
					<td>Title: </td>
					<td>
						<input type="text" name="title" value="<?php echo $title; ?>">
					</td>
				</tr>

				<tr>
					<td>Current Image: </td>
					<td>
						<?php 
							if($current_image != "")
							{
								//display the image
								?>
								<img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>" width="150px">
								<?php
							}
							else
							{
								//display message
								echo "Image not added.";
							}
						?>
					</td>
				</tr>

				<tr>
					<td>New Image: </td>
					<td>
						<input type="file" name="image">
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
					<td colspan="2">
						<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" value="Update Category" class="btn-secondary">
					</td>
				</tr>
			</table>
		</form>

		<?php 

			if(isset($_POST['submit']))
			{
				//1. GET ALL THE VALUes from our form
				$id = $_POST['id'];
				$title = $_POST['title'];
				$current_image = $_POST['current_image'];
				$featured = $_POST['featured'];
				$active = $_POST['active'];

				//2. update new image if selected
				//check whether the image is selected or not
				if(isset($_FILES['image']['name']))
				{
					//get the image details
					$image_name = $_FILES['image']['name'];

					//check whether the image is avialble or not
					if($image_name != "")
					{
						//image available
						//upload the new image

						//auto rename image
						//get extension of our image (jpg. png, gif, etc) e.g. food.jpg
						$ext = end(explode('.',$image_name));

						//rename the image
						$image_name = "Food_Category_".rand(000,999).'.'.$ext;


						$source_path = $_FILES['image']['tmp_name'];
						$destination_path = "../images/category/".$image_name;

						//finally upload the image
						$upload = move_uploaded_file($source_path, $destination_path);

						//check whether the image is uploaded or not
						//and if the image is not uploaded then we will stop the process and redirect with error message
						if($upload==false)
						{
							//set message
							$_SESSION['upload']="Failed to upload image.";
							//redirect to add category page
							header("location:".SITEURL.'admin/manage-category.php');
							//stop the process
							die();
						}

						//remove the current image if available
						if($current_image != "")
						{
							$remove_path = "../images/category/".$current_image;

							$remove = unlink($remove_path);

							//check whether the image is removed or not
							//if failed to remove then display message and stop the process
							if($remove==false)
							{
								//failed to removeimage
								$_SESSION['failed-remove'] = "Failed to remove current image.";
								header("location:".SITEURL.'admin/manage-category.php');

								die();//stop the process
							}
						}
						
					}
					else
					{
						$image_name = $current_image;
					}
				}
				else
				{
					$image_name = $current_image;
				}

				//3. update the database
				$sql2 = "UPDATE tbl_category SET
				title = '$title',

				image_name = '$image_name',

				featured = '$featured',
				active = '$active'
				WHERE id = $id
				";

				//execute query
				$res2 = mysqli_query($conn, $sql2);

				//4. redirect to manage category
				//check whether executed or not
				if($res==true)
				{
					//categiry updated
					$_SESSION['update']="Category updated successfully.";
					header("location:".SITEURL.'admin/manage-category.php');
				}
				else
				{
					//failed to update category
					$_SESSION['update']="Failed to update category.";
					header("location:".SITEURL.'admin/manage-category.php');
				}
			}

		?>

		</div>
	</div>
<?php include('partials/footer.php'); ?>