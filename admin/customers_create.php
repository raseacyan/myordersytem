<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

if(isset($_POST['add-customer'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));
	$phone = $conn->real_escape_string(trim($_POST['phone']));
	$email = $conn->real_escape_string(trim($_POST['email']));
	$address = $conn->real_escape_string(trim($_POST['address']));	

	//save to database
	$table = "customers";
	$data = array(
		"name" => $name,
		"phone" => $phone,
		"email" => $email,
		"address" => $address
	);
	
	$save = createRecord($table, $data, $conn);

	if($save){
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
	
	<form action="customers_create.php" method="post">

	<h1>Add customer</h1>

	<label for="name">Name</label><br>
	<input type="text" class="form-control" name="name"><br>			   
						  					  

	<label for="name">Phone</label><br>
	<input type="number" class="form-control" name="phone">	<br>

	<label for="name">Email</label><br>
	<input type="text" class="form-control" name="email"><br>		   


	<label for="address">Address</label><br>
	<textarea class="form-control"  rows="3" name="address"></textarea>	<br>

	<br><input type="submit" name="add-customer" value="submit" />

	</form> 
</body>
</html>

