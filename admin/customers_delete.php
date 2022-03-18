<?php
include('../inc/connect.php');
include('../inc/functions.php');

if(isset($_GET['id'])){
	
	$id = $_GET['id'];
	$table = "customers";
	$delete = deleteRecord($table, $id, $conn);	
	$conn->close();

	if ($delete) {	  
		redirectTo('customers_list.php');		
	} 
}else{
	redirectTo('customers_list.php');
}

?>