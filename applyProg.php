<?php
	session_start();
	if (!isset($_SESSION["loggedin"])){
		header("location: loginStudent.php");
		exit;
	}else{
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$createApplyTb = "CREATE TABLE application (applicationID INT AUTO_INCREMENT PRIMARY KEY, date DATE NOT NULL,
	status VARCHAR(25) NOT NULL, applicantID VARCHAR(50) NOT NULL, programmeID INT NOT NULL,
	FOREIGN KEY(applicantID) REFERENCES applicant(applicantID), FOREIGN KEY(programmeID) REFERENCES programme(programmeID));";
	$conn->query($createApplyTb);
	$insertApplication = $conn->prepare("INSERT INTO application(date, status, applicantID, programmeID) VALUES(?,?,?,?);");
	$insertApplication->bind_param("ssss",$date,$status,$_SESSION["UserName"],$_GET["progID"]);
	$date = date("Y-m-d");
	$status = "PENDING";
	$insertApplication->execute();
	$insertApplication->close();
	}

?>