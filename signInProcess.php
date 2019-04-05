<?php
	session_start();
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$_SESSION['loggedin'] = false;
	if ($_GET["loginType"] == "systemAdmin"){
		if ($_POST["username"] == "SystemAdmin" && $_POST["password"] == "SystemAdmin"){
			$_SESSION['loggedin'] = true;
			$_SESSION['UserName'] = $_POST["username"];
			$_SESSION['sysAdmin'] = true;
			$directPage = "systemAdminPage.php";
		}else{
			$directPage = "login-sys-admin.php";
		}
	}else if ($_GET["loginType"] == "universityAdmin"){
		$findUniAdmin = $conn->prepare("SELECT * FROM UniversityAdmin WHERE adminID = ? and password = ?;");
		$findUniAdmin->bind_param("ss",$_POST["username"],$_POST["password"]);
		$findUniAdmin->execute();
		$findUniAdmin->store_result();
		if ($findUniAdmin->num_rows == 1){
			$findUniAdmin->close();
			$_SESSION['loggedin'] = true;
			$_SESSION['uniAdmin'] = true;
			$_SESSION['UserName'] = $_POST["username"];
			$directPage = "uniAdminPage.php";
		}else{
			$directPage = "loginUniAdmin.php";
		}
	}else{
		$findUser = $conn->prepare("SELECT * FROM User,applicant WHERE user.username = applicant.applicantID
		AND username = ? and password = ?;");
		$findUser->bind_param("ss",$_POST["username"],$_POST["password"]);
		$findUser->execute();
		$findUser->store_result();
		if($findUser->num_rows == 1){
			$findUser->close();
			$_SESSION['loggedin'] = true;
			$_SESSION['UserName'] = $_POST["username"];
			$directPage = 'myApplication.php';
			if (isset($_SESSION['applyProg']))
				$directPage = "applyProg.php?progID=".$_SESSION["applyProg"];
		}else{
			$directPage = "loginStudent.php";
		}
	}
	echo "<script>window.open('".$directPage."','_self')</script>";
	$conn->close();
?>