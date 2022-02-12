<?php
	$conn = new mysqli('localhost', 'root', '', 'FoodMenu');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$id=$_GET['product'];

	$pname=$_POST['pname'];
	$category=$_POST['category'];
	$price=$_POST['price'];
	$description=$_POST['description'];


	$sql="select * from product where productid='$id'";
	$query=$conn->query($sql);
	$row=$query->fetch_array();

	$fileinfo=PATHINFO($_FILES["photo"]["name"]);

	if (empty($fileinfo['filename'])){
		$location = $row['photo'];
	}

	$sql="update product set productname='$pname', categoryid='$category', price='$price',photo='$location',description='$description' where productid='$id'";
	$conn->query($sql);
?>