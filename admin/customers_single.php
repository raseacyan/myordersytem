<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

if(isset($_GET['id'])){
	$customer = getcustomerById($_REQUEST['id'], $conn);

	if(!$customer){
		redirectTo("customers_list.php");
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
	
	<h1><?php echo $customer['name']; ?></h1>
	<p>
		<strong>Phone:</strong> <br>
		<?php echo $customer['phone']; ?> <br>
		<strong>Email:</strong> <br>
		<?php echo $customer['email']; ?> <br>
		<strong>Address:</strong><br>
		<?php echo $customer['address']; ?>
	</p>	
</body>
</html>