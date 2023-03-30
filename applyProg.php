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
	$getEntryReq = "select entryScore from entryRequirement WHERE programmeID = '".$_GET["progID"]."'; ";
	$checkEntryReq = $conn->query($getEntryReq);
	$getOverallScore = "select overallScore from qualificationObtained WHERE applicantID = '".$_SESSION["UserName"]."';";
	$checkOverallScore = $conn->query($getOverallScore);
	$entryScore = $checkEntryReq->fetch_assoc()["entryScore"];
	$overallScore = $checkOverallScore->fetch_assoc()["overallScore"];
	if ($entryScore > $overallScore){
		$status = "REJECTED";
	}
	$insertApplication->execute();
	$insertApplication->close();
	$_SESSION["successApply"] = true;
	$getProgName = "SELECT programmeName from programme WHERE programmeID = '".$_GET["progID"]."';";
	$progName = $conn->query($getProgName);
	$row = $progName->fetch_assoc();
	header('Location: myApplication.php');
	}

?>