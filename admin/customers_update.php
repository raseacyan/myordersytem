<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}


if(isset($_REQUEST['id'])){
	$customer = getcustomerById($_REQUEST['id'], $conn);
	if(!$customer){
		redirectTo("customers_list.php");
	}
}




if(isset($_POST['update-customer'])){

	//senitize incoming data	
	$name = $conn->real_escape_string(trim($_POST['name']));
	$phone = $conn->real_escape_string(trim($_POST['phone']));
	$email = $conn->real_escape_string(trim($_POST['email']));
	$address = $conn->real_escape_string(trim($_POST['address']));	

	$id = $conn->real_escape_string(trim($_POST['id']));
	
	//save to database
	$table = "customers";
	$data = array(
		"name" => $name,
		"phone" => $phone,
		"email" => $email,
		"address" => $address
	);
	
	$save = updateRecord($table, $data, $id, $conn);

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
	
	<form action="customers_update.php" method="post">

	<h1>Update customer</h1>

	<label for="name">Name</label><br>
	<input type="text" class="form-control" name="name" value="<?php echo $customer['name']; ?>"><br>			   
						  					  

	<label for="name">Phone</label><br>
	<input type="number" class="form-control" name="phone" value="<?php echo $customer['phone']; ?>">	<br>

	<label for="name">Email</label><br>
	<input type="text" class="form-control" name="email" value="<?php echo $customer['email']; ?>"><br>		   


	<label for="address">Address</label><br>
	<textarea class="form-control"  rows="3" name="address"><?php echo $customer['address']; ?></textarea><br>


	<input type="hidden" name="id" value="<?php echo $customer['id']; ?>"/>

	<br><input type="submit" name="update-customer" value="submit" />

	</form> 
</body>
</html>



