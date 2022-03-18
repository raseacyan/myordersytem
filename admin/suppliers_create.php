<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

if(isset($_POST['add-supplier'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));
	$phone = $conn->real_escape_string(trim($_POST['phone']));
	$email = $conn->real_escape_string(trim($_POST['email']));
	$address = $conn->real_escape_string(trim($_POST['address']));	

	//save to database
	
	$sql = "INSERT INTO suppliers (`name`, `phone`, `email`, `address`) VALUES ('{$name}', '{$phone}', '{$email}', '{$address}')";

	if ($conn->query($sql) === TRUE) {
	  header('Location:suppliers_list.php');
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;
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
	
	<form action="suppliers_create.php" method="post">

	<h1>Add Supplier</h1>

	<label for="name">Name</label><br>
	<input type="text" class="form-control" name="name"><br>			   
						  					  

	<label for="name">Phone</label><br>
	<input type="number" class="form-control" name="phone">	<br>

	<label for="name">Email</label><br>
	<input type="text" class="form-control" name="email"><br>		   


	<label for="address">Address</label><br>
	<textarea class="form-control"  rows="3" name="address"></textarea>	<br>

	<br><input type="submit" name="add-supplier" value="submit" />

	</form> 
</body>
</html>

