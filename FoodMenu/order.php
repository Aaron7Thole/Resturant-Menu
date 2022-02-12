
<!DOCTYPE html>
<html>
<head>
	<title>FoodOrderSystem</title>
	<link rel="stylesheet" href="OrderStyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php $conn = new mysqli('localhost', 'root', '', 'FoodMenu');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  ?>
<div class="container">
	<h1 class="page-header">ORDER</h1>
	<form method="get" action="index.php">
    <button type="submit" class="btn btn-top">Menu Page</button>
	</form>
	<form method="POST" action="purchase.php">
		<table class="table table-striped table-bordered">
			<thead>
				<th class="text-center"><input type="checkbox" id="checkAll"></th>
				<th>Product Name</th>
				<th>Price</th>
				<th>Quantity</th>
			</thead>
			<tbody>
				<?php 
					$sql="select * from product left join category on category.categoryid=product.categoryid order by product.categoryid asc, productname asc";
					$query=$conn->query($sql);
					$iterate=0;
					while($row=$query->fetch_array()){
						?>
						<tr>
							<td class="text-center"><input type="checkbox" value="<?php echo $row['productid']; ?>||<?php echo $iterate; ?>" name="productid[]" style=""></td>
							<td><?php echo $row['productname']; ?></td>
							<td class="text-right"><?php echo "$",number_format($row['price'], 2); ?></td>
							<td><input type="text" class="form-control" name="quantity_<?php echo $iterate; ?>"></td>
						</tr>
						<?php
						$iterate++;
					}
				?>
			</tbody>
		</table>
		
		<div class="row">
			<div class="col-md-3">
				<input type="text" name="customer" class="form-control" placeholder="Customer Name" required><br>
				<input type="email" name="email" class="form-control" placeholder="Email" required><br>
				<input type="number" name="PhoneNum" class="form-control" placeholder="Phone Number" required><br>
				<input type="text" name="Address" class="form-control" placeholder="Address" required><br>
				<input type="number" name="Zip" class="form-control" placeholder="Zip Code" required><br>
				<br>
				<button type="submit" class="btn btn-primary">Complete Order</button>
			</div>
			<br>
			<div class="col-md-2" style="margin-left:-20px;">
				
			</div>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$("#checkAll").click(function(){
	    	$('input:checkbox').not(this).prop('checked', this.checked);
		});
	});
</script>
</body>
</html>