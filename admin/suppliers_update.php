<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}


if(isset($_REQUEST['id'])){
	$supplier = getSupplierById($_REQUEST['id'], $conn);
	if(!$supplier){
		redirectTo("suppliers_list.php");
	}
}




if(isset($_POST['update-supplier'])){

	//senitize incoming data	
	$name = $conn->real_escape_string(trim($_POST['name']));
	$phone = $conn->real_escape_string(trim($_POST['phone']));
	$email = $conn->real_escape_string(trim($_POST['email']));
	$address = $conn->real_escape_string(trim($_POST['address']));	

	$id = $conn->real_escape_string(trim($_POST['id']));

	//save to database
	
	$sql = "UPDATE suppliers set name='{$name}', phone='{$phone}', email='{$email}', address='{$address}' WHERE id={$id}";

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
	
	<form action="suppliers_update.php" method="post">

	<h1>Update Supplier</h1>

	<label for="name">Name</label><br>
	<input type="text" class="form-control" name="name" value="<?php echo $supplier['name']; ?>"><br>			   
						  					  

	<label for="name">Phone</label><br>
	<input type="number" class="form-control" name="phone" value="<?php echo $supplier['phone']; ?>">	<br>

	<label for="name">Email</label><br>
	<input type="text" class="form-control" name="email" value="<?php echo $supplier['email']; ?>"><br>		   


	<label for="address">Address</label><br>
	<textarea class="form-control"  rows="3" name="address"><?php echo $supplier['address']; ?></textarea><br>


	<input type="hidden" name="id" value="<?php echo $supplier['id']; ?>"/>

	<br><input type="submit" name="update-supplier" value="submit" />

	</form> 
</body>
</html>



