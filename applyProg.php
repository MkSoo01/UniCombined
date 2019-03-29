<?php
	session_start();
	if (!isset($_SESSION["loggedin"])){
		$_SESSION['applyProg'] = $_GET["progID"];
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
	if (isset($checkEntryReq->num_rows) && $checkEntryReq->num_rows == 0){
		$status = "REJECTED";
	}
	$insertApplication->execute();
	$insertApplication->close();
	$_SESSION["successApply"] = true;
	$getProgName = "SELECT programmeName from programme WHERE programmeID = '".$_GET["progID"]."';";
	$progName = $conn->query($getProgName);
	$row = $progName->fetch_assoc();
	header("location: programme-detail.php?prog=".$row["programmeName"]);
	}

?>