<?php
session_start();
include('../inc/functions.php');
include('../inc/connect.php');

if(!isLoggedIn()){
	redirectTo("login.php");
}

display($_SESSION);

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
	
	<h1>Admin Dashboard</h1>

	
</body>
</html>