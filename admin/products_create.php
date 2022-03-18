<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

$suppliers  = getSuppliers($conn);


if(isset($_POST['add-product'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));
	$code = $conn->real_escape_string(trim($_POST['code']));
	$price = $conn->real_escape_string(trim($_POST['price']));	
	$qty = $conn->real_escape_string(trim($_POST['qty']));	
	$supplier_id = $conn->real_escape_string(trim($_POST['supplier_id']));

	//save to database
	$table = "products";
	$data = array(
		"name" => $name,
		"code" => $code,
		"price" => $price,
		"qty" => $qty,
		"supplier_id" => $supplier_id
	);
	
	$save = createRecord($table, $data, $conn);

	if($save){
		redirectTo("products_list.php");
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

	<h1>Add Product</h1>
	
	<form action="products_create.php" method="post" enctype="multipart/form-data">

	<label for="name">Product Name</label><br>
	<input type="text" class="form-control" name="name"><br>	

	<label for="code">Code</label><br>
	<input type="text" class="form-control" name="code"><br>		   
						  					  

	<label for="name">Price</label><br>
	<input type="number" class="form-control" name="price">	<br>	

	<label for="name">Quantity</label><br>
	<input type="number" class="form-control" name="qty">	<br>		   


	<label for="suppliers">Supplier</label><br>
	<select name="supplier_id">
	<?php foreach($suppliers as $supplier): ?>
	<option value="<?php echo $supplier['id'] ?>"><?php echo $supplier['name'] ?></option>		
	<?php endforeach; ?>    			
	</select><br>



	<br><input type="submit" name="add-product" value="submit" />

	</form> 
</body>
</html>

