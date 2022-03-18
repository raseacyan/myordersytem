<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}


$products = getProducts($conn);

if(isset($_POST['add-stock'])){

	//senitize incoming data

	$qty = $conn->real_escape_string(trim($_POST['qty']));
	$id = $conn->real_escape_string(trim($_POST['product_id']));

	$product = getProductById($id, $conn);
	if($product){
		$old_qty = $product['qty'];
	}
	$qty += $old_qty;
	

	//save to database
	$table = "products";
	$data = array(
		"qty" => $qty,
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

	
	<h1>Find Product</h1>
	<form action="stock_add.php" method="get">
	
		Product Code: <input type="text" name="code" /><input type="submit" value="search" name="search"/>
	</form>



	<?php if(!isset($_GET['code'])): ?>
	<h1>Add Stock</h1>
	<form action="stock_add.php" method="post">

	<label for="product_id">Products</label><br>
	<select name="product_id">
	<?php foreach($products as $product): ?>
	<option value="<?php echo $product['id'] ?>"><?php echo "(code: {$product['code']}) {$product['name']}"; ?></option>		
	<?php endforeach; ?>    			
	</select><br>

	<label for="qty">Quantity</label><br>
	<input type="number" class="form-control" name="qty">	<br>		   

	<br><input type="submit" name="add-stock" value="submit" />

	</form> 
	<?php endif; ?>


	<?php if(isset($_GET['code'])): ?>
	<h1>Add Stock</h1>
	<form action="stock_add.php" method="post">

	<label for="product_id">Products</label><br>
	<select name="product_id">
	<?php foreach($products as $product): ?>
	<?php
		$selected = ($product['code']== $_GET['code'])?"selected":"";
	?>
	<option value="<?php echo $product['id']; ?>" <?php echo $selected;  ?>><?php echo "(code: {$product['code']}) {$product['name']}"; ?></option>		
	<?php endforeach; ?>    			
	</select><br>

	<label for="qty">Quantity</label><br>
	<input type="number" class="form-control" name="qty">	<br>		   

	<br><input type="submit" name="add-stock" value="submit" />

	</form> 
	<?php endif; ?>
</body>
</html>
