<!DOCTYPE html>
<html>

<head>
	<title>FoodOrderSystem</title>
	<link rel="stylesheet" href="Prod.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<?php $conn = new mysqli('localhost', 'root', '', 'FoodMenu');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}  ?>
	<div class="container">
		<h1 class="page-header text">Menu Change</h1>
			<table class="table table-striped table-bordered">
				<thead>
					<th>Photo</th>
					<th>Product Name</th>
					<th>Price</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php
					$where = "";
					if (isset($_GET['category'])) {
						$catid = $_GET['category'];
						$where = " WHERE product.categoryid = $catid";
					}
					$sql = "select * from product left join category on category.categoryid=product.categoryid $where order by product.categoryid asc, productname asc";
					$query = $conn->query($sql);
					while ($row = $query->fetch_array()) {
					?>
						<tr>
							<td><a href="<?php if (empty($row['photo'])) {
								echo "upload/noimage.jpg";} 
								else {
									echo $row['photo'];
								}
								?>"><img src="<?php if (empty($row['photo'])) {
									echo "upload/noimage.jpg";
									} 
									else {
										echo $row['photo'];
									} 
									?>" height="30px" width="40px"></a></td>
								<td><?php echo $row['productname']; ?></td>
								<td><?php echo "$", number_format($row['price'], 2); ?></td>
								<td>
								<a href="#editproduct<?php echo $row['productid']; ?>" data-toggle="modal" class="btn btn-success btn-sm">Edit</a>
								<?php echo " " ?>
								<a href="#deleteproduct<?php echo $row['productid']; ?>" data-toggle="modal" class="btn btn-danger btn-sm">Delete</a>
								<!-- Edit Product -->
								<div class="modal fade" id="editproduct<?php echo $row['productid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Edit Product</h4>
											</div>
											<div class="modal-body">
												<div class="container-fluid">
													<form method="POST" action="editproduct.php?product=<?php echo $row['productid']; ?>" enctype="multipart/form-data">
														<div class="form-group" style="margin-top:10px;">
															<div class="row">
																<div class="col-md-3" style="margin-top:7px;">
																	<label class="control-label">Product Name:</label>
																</div>
																<div class="col-md-9">
																	<input type="text" class="form-control" value="<?php echo $row['productname']; ?>" name="pname">
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="row">
																<!-- category -->
																<div class="col-md-3" style="margin-top:7px;">
																	<label class="control-label">Category:</label>
																</div>
																<div class="col-md-9">
																	<select class="form-control" name="category">
																		<option value="<?php echo $row['categoryid']; ?>"><?php echo $row['catname']; ?></option>
																		<?php
																		$sql = "select * from category where categoryid != '" . $row['categoryid'] . "'";
																		$cquery = $conn->query($sql);

																		while ($crow = $cquery->fetch_array()) {
																		?>
																			<option value="<?php echo $crow['categoryid']; ?>"><?php echo $crow['catname']; ?></option>
																		<?php
																		}
																		?>
																	</select>
																</div>
															</div>
														</div>
														<!-- Description -->
														<div class="form-group" style="margin-top:10px;">
															<div class="row">
																<div class="col-md-3" style="margin-top:7px;">
																	<label class="control-label">Description:</label>
																</div>
																<div class="col-md-9">
																	<input type="text" class="form-control" value="<?php echo $row['description']; ?>" name="description">
																</div>
															</div>
														</div>
														<!-- price -->
														<div class="form-group">
															<div class="row">
																<div class="col-md-3" style="margin-top:7px;">
																	<label class="control-label">Price:</label>
																</div>
																<div class="col-md-9">
																	<input type="text" class="form-control" value="<?php echo $row['price']; ?>" name="price">
																</div>
															</div>
														</div>
														<!-- Photo -->
														<div class="form-group">
															<div class="row">
																<div class="col-md-3" style="margin-top:7px;">
																	<label class="control-label">Photo:</label>
																</div>
																<div class="col-md-9">
																	<input type="file" name="photo">
																</div>
															</div>
														</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-success">Update</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="deleteproduct<?php echo $row['productid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">Delete Product</h4>
											</div>
											<div class="modal-body">
												<h3 class="text"><?php echo $row['productname']; ?></h3>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<a href="delete_product.php?product=<?php echo $row['productid']; ?>" class="btn btn-danger">Yes</a>
												</form>
											</div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		<form method="get" action="index.php">
			<button type="submit" class="btn btn-top">Menu Page</button>
		</form>
	</div>
	<script>
		$(document).ready(function() {
			$("#catList").on('change', function() {
				if ($(this).val() == 0) {
					window.location = 'product.php';
				} else {
					window.location = 'product.php?category=' + $(this).val();
				}
			});
		});
	</script>
</body>

</html>