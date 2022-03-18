<?php


include('inc/connect.php');
include('inc/functions.php');

echo getOrderQtyByProductId(1, $conn);
echo "<br>";
echo getOrderQtyByProductId(2, $conn);
echo "<br>";

echo getOrderQtyByProductId(5, $conn);