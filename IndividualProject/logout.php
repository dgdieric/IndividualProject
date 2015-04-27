<!-- Logout Page -->

<?php	
	session_start();
	
	//logout admin
	$_SESSION["admin"] = "";
	//logout user
	$_SESSION["user"] = "";
	
	header('Location: index.php');
?>

