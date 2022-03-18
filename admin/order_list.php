<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

$orders  = getOrders($conn);



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
	
	<h1>Order List</h1>

	<?php if($orders): ?>

	<table border="1" cellspacing="1" cellpadding="5">
		<tr>
			<th>Order Number</th>
			<th>Date</th>
			<th>Customer Name</th>
			<th>Total</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
		<?php foreach($orders as $order): ?>
		<tr>
			<td><?php echo $order['id']; ?></td>
			<td><?php echo $order['date']; ?></td>
			<td><?php echo $order['customer_name']; ?></td>
			<td><?php echo $order['total']; ?></td>
			<td><?php echo $order['status']; ?></td>
			<td>
				<a href="order_single.php?id=<?php echo $order['id']; ?>">View</a> |
				<a href="order_update.php?id=<?php echo $order['id']; ?>">Edit</a> |
				<a href="order_delete.php?id=<?php echo $order['id']; ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>

	<?php else: ?>
		<p>No records. Add orders <a href="orders_create.php">here</a>.</p>
	<?php endif; ?>
</body>
</html>