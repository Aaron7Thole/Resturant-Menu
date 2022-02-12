<?php
	$conn = new mysqli('localhost', 'root', '', 'FoodMenu');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$id = $_GET['product'];

	$sql="delete from product where productid='$id'";
	$conn->query($sql);
?>