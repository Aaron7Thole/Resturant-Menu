<!DOCTYPE html>
<html>

<head>
	<title>FoodOrderSystem</title>
	<link rel="stylesheet" href="SalesStyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<?php $conn = new mysqli('localhost', 'root', '', 'FoodMenu');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}  ?>
	<div class="container">
		<h1 class="page-header text">SALES</h1>
		<table class="table table-striped table-bordered">
			<thead>
				<th>Date</th>
				<th>Customer</th>
				<th>Total Sales</th>
				<th>Details</th>
			</thead>
			<tbody>
				<?php
				$sql = "select * from purchase order by purchaseid desc";
				$query = $conn->query($sql);
				while ($row = $query->fetch_array()) {
				?>
					<tr>
						<td><?php echo date('M d, Y h:i A', strtotime($row['date_purchase'])) ?></td>
						<td><?php echo $row['customer']; ?></td>
						<td class="text-right"><?php echo "$", number_format($row['total'], 2); ?></td>
						<td><a href="#details<?php echo $row['purchaseid']; ?>" data-toggle="modal" class="btn btn-primary btn-sm">View </a>
							<div class="modal fade" id="details<?php echo $row['purchaseid']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h4 class="modal-title" id="myModalLabel">Sales Full Details</h4>
										</div>
										<div class="modal-body">
											<div class="container-fluid">
												<h5>Customer: <b><?php echo $row['customer']; ?></b>
													<h5>Email: <b><?php echo $row['Email']; ?></b>
														<h5>Phone Number: <b><?php echo $row['PhoneNum']; ?></b>
															<h5>Address: <b><?php echo $row['Address']; ?></b>
																<h5>Zip Code: <b><?php echo $row['Zip']; ?></b>
																	<span class="pull-right">
																		<br><br><?php echo date('M d, Y h:i A', strtotime($row['date_purchase'])) ?>
																	</span>
																</h5>
																<table class="table table-bordered table-striped">
																	<thead>
																		<th>Product Name</th>
																		<th>Price</th>
																		<th>Purchase Quantity</th>
																		<th>Subtotal</th>
																	</thead>
																	<tbody>
																		<?php
																		$sql = "select * from purchase_detail left join product on product.productid=purchase_detail.productid where purchaseid='" . $row['purchaseid'] . "'";
																		$dquery = $conn->query($sql);
																		while ($drow = $dquery->fetch_array()) {
																		?>
																			<tr>
																				<td><?php echo $drow['productname']; ?></td>
																				<td class="text-right"><?php echo "$", number_format($drow['price'], 2); ?></td>
																				<td><?php echo $drow['quantity']; ?></td>
																				<td class="text-right">
																					<?php
																					$subt = $drow['price'] * $drow['quantity'];
																					echo "$", number_format($subt, 2);
																					?>
																				</td>
																			</tr>
																		<?php

																		}
																		?>
																		<tr>
																			<td colspan="3" class="text-right"><b>TOTAL</b></td>
																			<td class="text-right"><?php echo "$", number_format($row['total'], 2); ?></td>
																		</tr>
																	</tbody>
																</table>

											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
	</div>
</body>

</html>