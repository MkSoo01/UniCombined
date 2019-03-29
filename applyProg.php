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
	$insertApplication = $conn->prepare("INSERT INTO application(date, status, applicantID, programmeID) VALUES(?,?,?,?);");
	$insertApplication->bind_param("ssss",$date,$status,$_SESSION["UserName"],$_GET["progID"]);
	$date = date("Y-m-d");
	$status = "PENDING";
	$checkEntryReq = "select * from qualificationObtained, entryRequirement WHERE qualificationObtained.applicantID = application.applicantID AND
entryRequirement.programmeID = application.programmeID AND entryScore >= overallScore AND applicantion.applicantID = '".$_SESSION["UserName"]."';";
	$checkEntryReq = $conn->query($checkEntryReq);
	if ($checkEntryReq->num_rows == 0){
		$status = "REJECTED";
	}
	$insertApplication->execute();
	$insertApplication->close();
	}

?>