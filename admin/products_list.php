<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

$products = getProducts($conn);


?>
<!DOCTYPE html>
<html>
<head>
	<title>Demo</title>
</head>
<body>
	<?php if(isLoggedIn()){showLoggedInUser();}?>
	<?php include("inc/nav.php"); ?>
	
	<h1>Inventory</h1>

	<?php if($products): ?>

	<table border="1" cellspacing="1" cellpadding="5">
		<tr>
			<th>Name</th>
			<th>Code</th>
			<th>Price</th>
			<th>Supplier</th>
			<th>Quantity</th>
			<th>Ordered Quantity</th>
			<th>Balance Qty</th>
			<th>Action</th>
		</tr>
		<?php foreach($products as $product): ?>
		<?php
		$ordered_qty = getOrderQtyByProductId($product['id'], $conn);

		?>
		<tr>
			<td><?php echo $product['name']; ?></td>
			<td><?php echo $product['code']; ?></td>
			<td><?php echo $product['price']; ?></td>
			<td><?php echo $product['supplier_name']; ?></td>
			<td><?php echo $product['qty']; ?></td>
			<td><?php echo $ordered_qty;?></td>
			<td><?php echo $product['qty'] - $ordered_qty; ?></td>
			<td>
				<a href="products_update.php?id=<?php echo $product['id']; ?>">Edit</a> |
				<a href="products_delete.php?id=<?php echo $product['id']; ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>

	<?php else: ?>
		<p>You do not have any product. Add products <a href="products_create.php">here</a>.</p>
	<?php endif; ?>
	<?php $conn->close(); ?>
</body>
</html>