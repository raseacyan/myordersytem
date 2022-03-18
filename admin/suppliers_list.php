<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

$suppliers  = getSuppliers($conn);

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
	
	<h1>Supplier List</h1>

	<?php if($suppliers): ?>

	<table border="1" cellspacing="1" cellpadding="5">
		<tr>
			<th>Name</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Address</th>
			<th>Action</th>
		</tr>
		<?php foreach($suppliers as $supplier): ?>
		<tr>
			<td><?php echo $supplier['name']; ?></td>
			<td><?php echo $supplier['phone']; ?></td>
			<td><?php echo $supplier['email']; ?></td>
			<td><?php echo $supplier['address']; ?></td>
			<td>
				<a href="suppliers_single.php?id=<?php echo $supplier['id']; ?>">View</a> |
				<a href="suppliers_update.php?id=<?php echo $supplier['id']; ?>">Edit</a> |
				<a href="suppliers_delete.php?id=<?php echo $supplier['id']; ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>

	<?php else: ?>
		<p>No records. Add suppliers <a href="suppliers_create.php">here</a>.</p>
	<?php endif; ?>
</body>
</html>