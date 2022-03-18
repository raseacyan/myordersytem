<?php

/****************
@Helpers
*****************/
function display($pram){
	echo "<pre>";
	print_r($pram);
	echo "</pre>";
}

function createRecord($table, $data, $conn){

	$values = "";
	$columns = "";
	foreach($data as $k=>$v){
		$columns .= "`".$k."`,";
		$values .= "'".$v."',";
	}
	$columns = substr($columns, 0,-1);
	$values = substr($values, 0,-1);


	$sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
	$result = $conn->query($sql);

	if ($result) {
	  $last_id = $conn->insert_id;
	  return $last_id;
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;die();
	  return false;
	}
}


function updateRecord($table, $data, $id, $conn){

	$set = "";
	foreach($data as $k=>$v){
		$set .= "`".$k."`='".$v."',";
	}
	$set = substr($set, 0,-1);


	$sql = "UPDATE {$table} set {$set} WHERE id={$id}";
	$result = $conn->query($sql);

	if ($result) {
	  return true;
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;die();
	  return false;
	}
}

function deleteRecord($table, $id, $conn){
	$sql = "DELETE FROM {$table} WHERE id={$id}";	
	$result = $conn->query($sql);

	if ($result) {
	  return true;
	} else {
	  echo "Error: " . $sql . "<br>" . $conn->error;die();
	  return false;
	}	
}


function isExistInOrder($product_id){
	foreach($_SESSION['order']['items'] as $key => $val){			
		if($val['id'] == $product_id ){	
			return $key;
		}
	}
	return false;
}


/****************
@Login
*****************/

function checkUserExist($email, $password, $conn){
	$sql = "SELECT id,name,role FROM users WHERE email = '{$email}' AND password='{$password}'";
    $result = $conn->query($sql);

    if($result){
    	if ($result->num_rows > 0) {
	      $data = array();
	      $row = $result->fetch_assoc();
	      $data = $row;
	      return $data;	      
	    } else {
	        echo "login failed";
	        return false;
	    }
    }else{
    	echo $conn->error;
    	return false;
    }
}

function showLoggedInUser(){	
	$username = $_SESSION['user_name'];
	echo "<p>Logged in as: {$username}</p>";
}

function isLoggedIn(){
	if(isset($_SESSION['user_id'])){
		return true;
	}else{
		return false;
	}
}

function redirectTo($url){
	header("location:{$url}");
}

/****************
@Suppliers
*****************/

function getSuppliers($conn){
	$sql = "SELECT * from suppliers";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			While($row = $result->fetch_assoc()){
				 array_push($data, $row);
			}
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}

function getSupplierById($supplier_id, $conn){
	$sql = "SELECT * from suppliers WHERE id={$supplier_id}";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row;		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


/****************
@Products
*****************/

function getProductsByUserId($user_id, $conn){
	$sql = "SELECT * from products WHERE user_id = $user_id";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			While($row = $result->fetch_assoc()){
				 array_push($data, $row);
			}
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}

function getProducts($conn){
	$sql = "SELECT p.id, p.name, p.code, p.price, p.qty, s.id as supplier_id, s.name as supplier_name from products as p, suppliers as s WHERE p.supplier_id = s.id";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			While($row = $result->fetch_assoc()){
				 array_push($data, $row);
			}
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}

function getProductById($product_id, $conn){
	$sql = "SELECT * from products WHERE id={$product_id}";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row;		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


function getProductByCode($code, $conn){
	$sql = "SELECT * from products WHERE id={$code}";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row;		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}

function getProductPriceById($product_id, $conn){
	$sql = "SELECT * from products WHERE id={$product_id}";		
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row['price'];		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}

function getProductNameById($product_id, $conn){
	$sql = "SELECT * from products WHERE id={$product_id}";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row['name'];		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


function getProductQtyById($product_id, $conn){
	$sql = "SELECT * from products WHERE id={$product_id}";		
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row['qty'];		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


/****************
@Customers
*****************/

function getCustomers($conn){
	$sql = "SELECT * from customers";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			While($row = $result->fetch_assoc()){
				 array_push($data, $row);
			}
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}

function getCustomerById($customer_id, $conn){
	$sql = "SELECT * from customers WHERE id={$customer_id}";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row;		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


function getCustomerNameById($customer_id, $conn){
	$sql = "SELECT * from customers WHERE id={$customer_id}";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row['name'];		
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


/****************
@Order
*****************/

function clearOrder(){
	unset($_SESSION['order']);
}


function getOrders($conn){
	$sql = "SELECT o.id, o.date, o.total, o.status,c.name as customer_name from orders as o, customers as c WHERE o.customer_id = c.id";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			While($row = $result->fetch_assoc()){
				 array_push($data, $row);
			}
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


function getOrderById($id, $conn){
	$sql = "SELECT o.id, o.date, o.total, o.status,c.name as customer_name, c.phone, c.email, c.address from orders as o, customers as c WHERE o.id = {$id} AND o.customer_id = c.id";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
			$data = $row;			
			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


function getOrderItemsByOrderId($id, $conn){
	$sql = "SELECT o.product_id, o.qty, o.price, o.item_total, p.name as product_name from order_items as o, products as p WHERE o.order_id = {$id} AND o.product_id = p.id";	

	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			While($row = $result->fetch_assoc()){
				 array_push($data, $row);
			}

			return $data;            		
		}else{			
			return false;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}

function getOrderQtyByProductId($id, $conn){
	$sql = "SELECT sum(`qty`) as total FROM `order_items`, `orders` WHERE product_id={$id} AND orders.status = 'new' AND order_items.order_id = orders.id ";	
	$result = $conn->query($sql);
	if($result){
		$data = array();
		if($result->num_rows > 0){			
			$row = $result->fetch_assoc();
				$data = $row['total'];
			return $data;            		
		}else{			
			return 0;
		}
	}else{
		echo $conn->error;		
		return false;
	}
}


