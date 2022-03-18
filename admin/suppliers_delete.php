<?php
include('../inc/connect.php');

if(isset($_GET['id'])){
	
	$id = $_GET['id'];

	$sql = "DELETE FROM suppliers WHERE id={$id}";	

	$result = $conn->query($sql);

	if ($result) {	  
		header("Location: suppliers_list.php");	
	} else {
	  	echo "Error deleting record: " . $conn->error;
	}
}else{
	header("Location: product_list.php");
}

$conn->close();
?>