<?php
	session_start();
	$_SESSION['servername'] = "localhost";
	$_SESSION['username'] = "root";
	$_SESSION['password'] = "";
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$findUser = $conn->prepare("SELECT * FROM User WHERE username = ? and password = ?;");
	$findUser->bind_param("ss",$_POST["username"],$_POST["password"]);
	$findUser->execute();
	$findUser->store_result();
	if($findUser->num_rows == 1){
		$findUser->close();
		$_SESSION['UserName'] = $_POST["username"];
		echo "<script>alert('Sign in successfully! ".$_SESSION['UserName']."');</script>";
	}
	else{
		$_SESSION['loggedin'] = false;
		echo "<script>window.open('loginUniAdmin.php','_self')</script>";
	}
	$conn->close();
?>