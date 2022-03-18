<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

if(isset($_GET['id'])){
	$order = getOrderById($_REQUEST['id'], $conn);
	if(!$order){
		redirectTo("order_list.php");
	}
	$order_items = getOrderItemsByOrderId($_REQUEST['id'], $conn);

}



$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Demo</title>
</head>
<body>
	<?php if(isLoggedIn()){showLoggedInUser();}?>
	<?php include("inc/nav.php"); ?>
	
	<h1>Order: <?php echo $order['id']; ?></h1>

	<h3>Order Details</h3>
	<p>
		<strong>Order Number:</strong> <br>
		<?php echo $order['id']; ?> <br>
		<strong>Date:</strong> <br>
		<?php echo $order['date']; ?> <br>
		<strong>Total:</strong><br>
		<?php echo $order['total']; ?><br>
		<strong>Status:</strong><br>
		<?php echo $order['status']; ?>		
	</p>

	<h3>Customer Details</h3>
	<p>
		<strong>Customer Name:</strong> <br>
		<?php echo $order['customer_name']; ?> <br>
		<strong>Customer Phone:</strong> <br>
		<?php echo $order['phone']; ?> <br>
		<strong>Customer Email:</strong> <br>
		<?php echo $order['email']; ?> <br>
		<strong>Customer Address:</strong> <br>
		<?php echo $order['address']; ?> <br>
	</p>




	<h3>Order Items</h3>

	<table border="1">
		<tr>
			<th>Product Name</th>
			<th>Qty</th>
			<th>Price</th>
			<th>Total</th>
		</tr>
		<?php foreach($order_items as $item): ?>
		<tr>
			<td><?php echo $item['product_name'] ?></td>
			<td><?php echo $item['qty'] ?></td>
			<td><?php echo $item['price'] ?></td>
			<td><?php echo $item['item_total'] ?></td>
		</tr>
		<?php endforeach; ?>

	</table>


</body>
</html>