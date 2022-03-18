<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

if(isset($_GET['id'])){
	$supplier = getSupplierById($_REQUEST['id'], $conn);

	if(!$supplier){
		redirectTo("suppliers_list.php");
	}
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
	
	<h1><?php echo $supplier['name']; ?></h1>
	<p>
		<strong>Phone:</strong> <br>
		<?php echo $supplier['phone']; ?> <br>
		<strong>Email:</strong> <br>
		<?php echo $supplier['email']; ?> <br>
		<strong>Address:</strong><br>
		<?php echo $supplier['address']; ?>
	</p>	
</body>
</html>