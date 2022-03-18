<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

$customers  = getcustomers($conn);

//display($_SESSION['order']);


if(isset($_POST['create-order'])){

	//senitize incoming data
	$date = htmlentities(trim($_POST['date']));
	$customer_id = htmlentities(trim($_POST['customer_id']));

	$_SESSION['order']['date'] = $date;
	$_SESSION['order']['customer_id'] = $customer_id;
	$_SESSION['order']['items'] = array();
	redirectTo('order_create.php');
	
}


if(isset($_POST['add-items'])){

	//senitize incoming data
	$product_id = htmlentities(trim($_POST['product_id']));
	$qty = htmlentities(trim($_POST['qty']));
	$price = getProductPriceById($product_id, $conn);


	$item = array(
		"id" => $product_id,
		"qty"=> $qty,
		"price"=> $price,
		"item_total" => $price * $qty
	);
	
	$index  = isExistInOrder($product_id);

	if($index === false){

		array_push($_SESSION['order']['items'], $item);
		
	}else{
		$_SESSION['order']['items'][$index] = $item;	
		
	}	

	redirectTo('order_create.php');
	
}

$order_total = 0;
if(isset($_SESSION['order']['items'])){
	foreach($_SESSION['order']['items'] as $item){
	$order_total += $item['item_total'];
	}
	$_SESSION['order']['total'] = $order_total;
}





?>
<!DOCTYPE html>
<html>
<head>
	<title>Demo</title>
</head>
<body>
	<?php if(isLoggedIn()){showLoggedInUser();}?>
	<?php include("inc/nav.php"); ?>
	
	<form action="order_create.php" method="post">

	<h1>Create Order</h1>

	<label for="date">Date</label><br>
	<input type="date" class="form-control" name="date" value="<?php echo (isset($_SESSION['order']['date']))?$_SESSION['order']['date']:''; ?>"><br>			   
						  					  

	<label for="customer_id">Customer</label><br>
	<select name="customer_id">
	<?php foreach($customers as $customer): ?>	

	<option value="<?php echo $customer['id']; ?>"><?php echo $customer['name']; ?></option>		
	<?php endforeach; ?>    			
	</select><br>

	<br><input type="submit" name="create-order" value="submit" />

	</form> 

	<?php if(isset($_SESSION['order'])):?>
	<?php
		$products = getProducts($conn);

	?>	
	<h1>Add Items</h1>

	<form action="order_create.php" method="post">

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

	<br><input type="submit" name="add-items" value="submit" />

	</form> 


	<?php endif; ?>	

	<?php if(isset($_SESSION['order'])):?>
		<?php 
			$customer = getCustomerById( $_SESSION['order']['customer_id'], $conn);
		?>
		<h1>Order Summary</h1>
		<p>
			<strong>Date:</strong> <?php echo $_SESSION['order']['date']; ?><br>
			<strong>Customer Name:</strong> <?php echo $customer['name']; ?><br>
		</p>

		<?php if(isset($_SESSION['order']['items'])): ?>
		<table border="1">
			<tr>
				<th>Item Name</th>
				<th>Item Qty</th>
				<th>Item Price</th>
				<th>Item Total</th>
				<th>Action</th>
			</tr>
			<?php foreach($_SESSION["order"]["items"] as $item): ?>
			<tr>
				<td><?php echo getProductNameById($item['id'], $conn); ?></td>
				<td><?php echo $item['qty']; ?></td>
				<td><?php echo $item['price']; ?></td>
				<td><?php echo $item['item_total']; ?></td>
				<td>
					<a href="order_remove_item.php?id=<?php echo $item['id'];?>">Remove</a>

				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		<p>Order Total: <?php echo $_SESSION['order']['total']; ?></p>
		<?php endif; ?>

	<?php endif; ?>
	<p><a href="order_confirm.php">Confirm  Order</a></p>
	<p><a href="order_clear.php">Clear Order</a></p>
	<?php  $conn->close(); ?>
</body>
</html>
