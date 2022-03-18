<?php
session_start();
include('inc/functions.php');
include('inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

$product = getProductById($_GET['id'], $conn);

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


	<?php if($product): ?>

	<h1><?php echo $product["name"]; ?></h1>	
	<h3><?php echo "{$product["price"]} per day"; ?></h3>
	<p><img src="<?php echo "uploads/{$product['image']}"; ?>" width="400"/></p>
	<p><strong>Description:</strong><br><?php echo nl2br($product["description"]); ?></p>

	<?php else: ?>
		<p>No records.</p>
	<?php endif; ?>
</body>
</html>