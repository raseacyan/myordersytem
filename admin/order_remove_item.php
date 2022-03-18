<?php
session_start();
include('../inc/functions.php');

$index  = isExistInOrder($_GET['id']);

if($index === false){
	redirectTo("order_create.php");	
}else{
	unset($_SESSION['order']['items'][$index]);
	redirectTo("order_create.php");	
}	
