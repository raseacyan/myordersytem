<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

if(isset($_REQUEST['id'])){
	$product = getproductById($_REQUEST['id'], $conn);
	if(!$product){
		redirectTo("products_list.php");
	}
}

$suppliers  = getSuppliers($conn);
$products = getProducts($conn);

if(isset($_POST['update-product'])){

	//senitize incoming data
	$name = $conn->real_escape_string(trim($_POST['name']));
	$code = $conn->real_escape_string(trim($_POST['code']));
	$price = $conn->real_escape_string(trim($_POST['price']));	
	$qty = $conn->real_escape_string(trim($_POST['qty']));	
	$supplier_id = $conn->real_escape_string(trim($_POST['supplier_id']));

	$id = $conn->real_escape_string(trim($_POST['id']));

	//save to database
	$table = "products";
	$data = array(
		"name" => $name,
		"code" => $code,
		"price" => $price,
		"qty" => $qty,
		"supplier_id" => $supplier_id
	);
	
	$save = updateRecord($table, $data, $id, $conn);

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
	
	<form action="products_update.php" method="post" enctype="multipart/form-data">

	<label for="name">Product Name</label><br>
	<input type="text" class="form-control" name="name" value="<?php echo $product['name']; ?>"><br>	

	<label for="code">Code</label><br>
	<input type="text" class="form-control" name="code" value="<?php echo $product['code']; ?>"><br>		   
						  					  

	<label for="price">Price</label><br>
	<input type="number" class="form-control" name="price" value="<?php echo $product['price']; ?>">	<br>	

	<label for="qty">Quantity</label><br>
	<input type="number" class="form-control" name="qty" value="<?php echo $product['qty']; ?>">	<br>		   


	<label for="suppliers">Supplier</label><br>
	<select name="supplier_id">
	<?php foreach($suppliers as $supplier): ?>
	<option value="<?php echo $supplier['id'] ?>" <?php echo ($supplier['id'] == $product['supplier_id'] )?"selected":"" ?>><?php echo $supplier['name'] ?></option>		
	<?php endforeach; ?>    			
	</select><br>


	<input type="hidden" name="id" value="<?php echo $product['id']; ?>"/>

	<br><input type="submit" name="update-product" value="submit" />

	</form> 
</body>
</html>
