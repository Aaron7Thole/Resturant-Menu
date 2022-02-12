
<!DOCTYPE html>
<html>

<head>
	<title>FoodOrderSystem</title>
	<link rel="stylesheet" href="indexStyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<?php $conn = new mysqli('localhost', 'root', '', 'FoodMenu');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} ?>
	<div class="container">
		<h1 class="text">MENU</h1>
		<ul class="nav nav-tabs">
			<?php
			$sql = "select * from category order by categoryid asc limit 1";
			$fquery = $conn->query($sql);
			$frow = $fquery->fetch_array();
			?>
			<li class="active"><a data-toggle="tab" href="#<?php echo $frow['catname'] ?>"><?php echo $frow['catname'] ?></a></li>
			<?php

			$sql = "select * from category order by categoryid asc";
			$nquery = $conn->query($sql);
			$num = $nquery->num_rows - 1;

			$sql = "select * from category order by categoryid asc limit 1, $num";
			$query = $conn->query($sql);
			while ($row = $query->fetch_array()) {
			?>
				<li><a data-toggle="tab" href="#<?php echo $row['catname'] ?>"><?php echo $row['catname'] ?></a></li>
			<?php
			}
			?>
		</ul>
		<hr>
		<div class="tab-content">
			<?php
			$sql = "select * from category order by categoryid asc limit 1";
			$fquery = $conn->query($sql);
			$ftrow = $fquery->fetch_array();
			?>
			<div id="<?php echo $ftrow['catname']; ?>" class="tab-pane fade in active" style="margin-top:20px;">
				<?php

				$sql = "select * from product where categoryid='" . $ftrow['categoryid'] . "'";
				$pfquery = $conn->query($sql);
				$row = 4;
				while ($pfrow = $pfquery->fetch_array()) {
					$row = ($row == 4) ? 1 : $row + 1;
					if ($row == 1) echo "<div class='row'>";
				?>
					<div class="col-md-3">
						<div class="panel panel-default">
							<div class="panel-heading text">
								<b><?php echo $pfrow['productname']; ?></b>
							</div>
							<div class="panel-body">
								<img src="<?php if (empty($pfrow['photo'])) {;
											} else {
												echo $pfrow['photo'];
											} ?>" height="225px;" width="100%">
							</div>
							<div class="panel-footer text">
								<?php echo ($pfrow['description']); ?>
								<br>
								<br>
								<?php echo "$", number_format($pfrow['price'], 2); ?>
							</div>
						</div>
					</div>
				<?php
					if ($row == 4) echo "</div>";
				}
				if ($row == 1) echo "<div class='col-md-3'></div><div class='col-md-3'></div><div class='col-md-3'></div></div>";
				if ($row == 2) echo "<div class='col-md-3'></div><div class='col-md-3'></div></div>";
				if ($row == 3) echo "<div class='col-md-3'></div></div>";
				?>
			</div>
			<?php

			$sql = "select * from category order by categoryid asc";
			$tquery = $conn->query($sql);
			$tnum = $tquery->num_rows - 1;

			$sql = "select * from category order by categoryid asc limit 1, $tnum";
			$cquery = $conn->query($sql);
			while ($trow = $cquery->fetch_array()) {
			?>
				<div id="<?php echo $trow['catname']; ?>" class="tab-pane fade" style="margin-top:20px;">
					<?php

					$sql = "select * from product where categoryid='" . $trow['categoryid'] . "'";
					$pquery = $conn->query($sql);
					$row = 4;
					while ($prow = $pquery->fetch_array()) {
						$row = ($row == 4) ? 1 : $row + 1;
						if ($row == 1) echo "<div class='row'>";
					?>
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-heading text">
									<b><?php echo $prow['productname']; ?></b>
								</div>
								<div class="panel-body">
									<img src="<?php if ($prow['photo'] == '') {
													echo "upload/noimage.jpg";
												} else {
													echo $prow['photo'];
												} ?>" height="225px;" width="100%">
								</div>
								<div class="panel-footer text">
									<?php echo ($prow['description']); ?>
									<br>
									<?php echo "$", number_format($prow['price'], 2); ?>
								</div>
							</div>
						</div>
					<?php
						if ($row == 4) echo "</div>";
					}
					if ($row == 1) echo "<div class='col-md-3'></div><div class='col-md-3'></div><div class='col-md-3'></div></div>";
					if ($row == 2) echo "<div class='col-md-3'></div><div class='col-md-3'></div></div>";
					if ($row == 3) echo "<div class='col-md-3'></div></div>";
					?>
				</div>
			<?php
			}
			?>
			<hr>
			<form method="get" action="order.php">
 			<button type="submit" class="btn btn-primary"> Order Food</button>
		</form>
		</div>
		<form method="get" action="product.php">
 			<button type="submit" class="btn btn-top">Change Menu</button>
		</form>
	</div>
</body>

</html>