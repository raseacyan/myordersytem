<?php

session_start();
include('../inc/functions.php');
include('../inc/connect.php');

display($_SESSION['order']);

$date = $conn->real_escape_string(trim($_SESSION['order']['date']));
$total = $conn->real_escape_string(trim($_SESSION['order']['total']));
$status = "new";
$customer_id = $conn->real_escape_string(trim($_SESSION['order']['customer_id']));


//save to database
$table = "orders";
$data = array(
	"date" => $date,
	"total" => $total,
	"status" => $status,
	"customer_id" => $customer_id
);

$last_id = createRecord($table, $data, $conn);

$success = true;

if($last_id){	
	$table = "order_items";
	foreach($_SESSION['order']['items'] as $item){
		$data = array(
			"order_id" => $last_id,
			"product_id" => $item['id'],
			"qty" => $item['qty'],
			"price" => $item['price'],
			"item_total" => $item['item_total'],
		);

		$save = createRecord($table, $data, $conn);
		if(!$save){
			$success = false;
			die("error saving");
		}

	}

}

if($success){
	clearOrder();
	redirectTo('order_list.php');
}

