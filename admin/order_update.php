<?php
session_start();
include('../inc/connect.php');
include('../inc/functions.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}


if(isset($_REQUEST['id'])){
	$order = getOrderById($_REQUEST['id'], $conn);
	if(!$order){
		redirectTo("order_list.php");
	}
}




if(isset($_POST['update-order'])){
	//senitize incoming data	
	$status = $conn->real_escape_string(trim($_POST['status']));	

	$id = $conn->real_escape_string(trim($_POST['id']));
	
	//save to database
	$table = "orders";
	$data = array(
		"status" => $status
	);
	
	$order_updated = updateRecord($table, $data, $id, $conn);

	$inventory_updated = true;

	if($order_updated){


		if($status == 'completed'){

			$order_items = getOrderItemsByOrderId($_REQUEST['id'], $conn);

		
			
			foreach($order_items as $item){
				$order_item_qty = $item['qty'];
				$old_qty = getProductQtyById($item['product_id'], $conn);
				$new_qty = $old_qty - $order_item_qty;	

				
				
				$table = "products";
				$id = $item['product_id'];
				$data = array(
				"qty" => $new_qty,
				);	
				$update_item_qty = updateRecord($table, $data, $id, $conn);
				if(!$update_item_qty){
					$inventory_updated = false;
					break;
				}	
			}					
			
		}
		

		if($inventory_updated){
			redirectTo("order_list.php");
		}
		
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
	
	<form action="order_update.php" method="post">

	<h1>Update Order</h1>

	<label for="status">Status</label><br>
	<select name="status">
		<option value="new" <?php echo ($order['status'] == 'new')?"selected":""; ?>>new</option>
		<option value="paid" <?php echo ($order['status'] == 'paid')?"selected":""; ?>>paid</option>
		<option value="shipped" <?php echo ($order['status'] == 'shipped')?"selected":""; ?>>shipped</option>
		<option value="completed" <?php echo ($order['status'] == 'completed')?"selected":""; ?>>completed</option>
	</select>		   



	<input type="hidden" name="id" value="<?php echo $order['id']; ?>"/>

	<br><input type="submit" name="update-order" value="submit" />

	</form> 
</body>
</html>



