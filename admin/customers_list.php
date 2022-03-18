<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

$customers  = getcustomers($conn);

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
	
	<h1>Customer List</h1>

	<?php if($customers): ?>

	<table border="1" cellspacing="1" cellpadding="5">
		<tr>
			<th>Name</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Address</th>
			<th>Action</th>
		</tr>
		<?php foreach($customers as $customer): ?>
		<tr>
			<td><?php echo $customer['name']; ?></td>
			<td><?php echo $customer['phone']; ?></td>
			<td><?php echo $customer['email']; ?></td>
			<td><?php echo $customer['address']; ?></td>
			<td>
				<a href="customers_single.php?id=<?php echo $customer['id']; ?>">View</a> |
				<a href="customers_update.php?id=<?php echo $customer['id']; ?>">Edit</a> |
				<a href="customers_delete.php?id=<?php echo $customer['id']; ?>">Delete</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>

	<?php else: ?>
		<p>No records. Add customers <a href="customers_create.php">here</a>.</p>
	<?php endif; ?>
</body>
</html>