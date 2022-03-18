<?php
include('../inc/connect.php');
include('../inc/functions.php');

if(isset($_GET['id'])){
	
	$id = $_GET['id'];
	$table = "products";
	$delete = deleteRecord($table, $id, $conn);	
	$conn->close();

	if ($delete) {	  
		redirectTo('products_list.php');		
	} 
}else{
	redirectTo('products_list.php');
}

?>