<?php
	session_start();
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$useDb = "use unicombined";
		$conn->query($useDb);
?>
<!doctype html>
<html lang="en">
  <head>
    <title>UniCombined</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<link rel="stylesheet" href="css/add-qualification-popup.css">

	<link rel="icon" href="icons/icon.png"/>
    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
    <header role="banner">
     
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand absolute" href="index.php">UniCombined</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link" href="about-us.php">About Us</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link" href="programme-university.php">Programme &amp; University</a>
              </li>
			 <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="courses.html" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">What You Can Do</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item" href="uniAdminPage.php">View Programmes</a>
                  <a class="dropdown-item" href="recordProgramme.php">Add Programme</a>
                  <a class="dropdown-item" href="review-application.php">View Application</a>
                </div>

              </li>
            </ul>     
			<ul class="navbar-nav absolute-right">
			  <?php
					if (isset($_SESSION["loggedin"])){
						echo "<li class = \"dropdown\"><a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"dropdown05\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"icon ion-person mr-1\"></span>".$_SESSION['UserName']."</a>
						<div class=\"dropdown-menu\" aria-labelledby=\"dropdown05\"> 
						<a class=\"dropdown-item\" href=\"logout.php\">Logout</a></div></li>";
					}
			  ?>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <!-- END header -->

    <section class="site-hero site-sm-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_2.jpg);">
      <div class="container">
        <div class="row align-items-center justify-content-center site-hero-sm-inner">
          <div class="col-md-7 text-center">
  
            <div class="mb-5 element-animate">
              <p class="bcrumb"><a href="uniAdminPage.php">Admin home</a> <span class="sep ion-android-arrow-dropright px-2"></span> <span class="current">Add Programme</span></p>
            </div>
            
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->
    
    <section class="site-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7">
            <div class="form-wrap">
              <h2 class="mb-4">Add Programme</h2>
					<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" onsubmit="return submitProgramme()">
						<div class="row">
							<div class="col-md-12 form-group">
								<input type="text" id="progName" name="progName" placeholder="Programme Name*" class="form-control">
								<p class = "msg errorMsg">&#10007;<small> Please enter Programme Name</small></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<textarea type="text" id="progDesc" name="progDesc" placeholder="Description*" class = "form-control" rows="2"></textarea>
								<p class = "msg errorMsg">&#10007;<small> Please enter Programme Description</small></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<input type="date" id="closingDate" name="closingDate" placeholder="Closing Date*" class="form-control" onchange="selectDate()">
								<p class = "msg errorMsg">&#10007;<small> Please enter Programme Closing Date</small></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label>Select a programme image to upload*:</label>
								<input type="file" name="progImg" id="progImg" class="form-control minimal" onchange="imgValidation()">
								<p class="msg errorMsg">&#10007;<small> Please upload a programme image</small></p>
							</div>
						</div>
						<label>Entry Requirement</label>
						<div class="row">
							<div class="col-lg-6 form-group">
								<select name="qualification[]" class="form-control minimal" onchange="qSelect()">
									<option value="">Qualification*</option>
						<?php 
							$getQualification = "SELECT qualificationName FROM qualification;";
							$result = $conn->query($getQualification);
							if (isset($result->num_rows) &&  $result->num_rows>0){
								while($row = $result->fetch_assoc()){
									echo "<option value = \"".$row['qualificationName']."\">".$row['qualificationName']."</option>";
								}
							}
						?>
								</select>
								<p class="msg errorMsg">&#10007;<small> Please enter Qualification</small></p>
							</div>
							<div class="col-lg-6 form-group">
								<input type="text" name="entryScore[]" placeholder="Entry Score*" class = "entryScore form-control">
								<p class="msg errorMsg">&#10007;<small> Please enter Entry Score</small></p>
							</div>
						</div>
						<input type="button" value="&#43; Add entry requirement" class="btn px-2 py-2 mb-4" onclick="addEntryReq()">
						<p><small>* required</small></p>
						<div class="row">
							<div class="col-md-6 form-group">
								<input type="submit" value="Submit" class="btn btn-primary px-5 py-2">
							</div>
						</div>
					</form>
            </div>
          </div>
        </div>
      </div>
	
    </section>
    
    <footer class="site-footer border-top">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <h3>UniCombined</h3>
            <p>A website where you can find various top and trusted universities in just one search.</p>
          </div>
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <h3 class="heading">Quick Link</h3>
            <div class="row">
              <div class="col-md-6">
                <ul class="list-unstyled">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="about-us.php">About Us</a></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="list-unstyled">
                  <li><a href="programme-university.php">Programme &amp; University</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <h3 class="heading">Permission Sign In</h3>
            <div class="block-21 d-flex mb-4">
			<div class="text">
                <h3 class="heading mb-0">System Admin Login</h3>
                <div class="meta">
				    <a href="login-sys-admin.php"><small>Click here to login</small></a>
                </div>
            </div>  
			</div>
            <div class="block-21 d-flex mb-4">
              <div class="text">
                <h3 class="heading mb-0">University Admin Login</h3>
                <div class="meta">
					<a href="loginUniAdmin.php"><small>Click here to login</small></a>	
                </div>
              </div>
            </div>  
            <div class="block-21 d-flex mb-4">
              <div class="text">
                <h3 class="heading mb-0">University Admin Register</h3>
                <div class="meta">
					<small>Please contact our admin via email</small>
                </div>
              </div>
            </div>  
          </div>
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <h3 class="heading">Contact Information</h3>
            <div class="block-23">
              <ul>
                <li><span class="icon ion-android-pin"></span><span class="text">15, Jalan Sri Semantan 1, Damansara Heights, 50490 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</span></li>
                <li><span class="icon ion-ios-telephone"></span><span class="text">+60 14-338 7456 &nbsp; +60 16-3072716</span></li>
                <li><span class="icon ion-android-mail"></span><a href="mailto:kingdom_325@hotmail.com"><span class="text">kingdom_325@hotmail.com</span></a>
				<a href="mailto:khimsoo01@gmail.com"><span class="text">khimsoo01@gmail.com</span></a></li>
                <li><span class="icon ion-android-time"></span><span class="text">Monday &mdash; Friday 8:00am - 5:00pm</span></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row pt-5">
          <div class="col-md-12 text-center copyright">
            
            <p class="float-md-left"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" class="text-primary">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
				<div>Icons made by <a href="https://www.flaticon.com/authors/eucalyp" title="Eucalyp">Eucalyp</a> from <a href="https://www.flaticon.com/" 			    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 			    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
          </div>
        </div>
      </div>
    </footer>
    <!-- END footer -->
    <?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$uploadedImg = "images/".$_FILES["progImg"]["name"];
		move_uploaded_file($_FILES["progImg"]['tmp_name'],$uploadedImg);
		$getUniID = $conn->prepare("SELECT University.universityID FROM University, UniversityAdmin WHERE 
		University.universityID = UniversityAdmin.universityID AND adminID = ?");
		$getUniID->bind_param("s",$_SESSION["UserName"]);
		$getUniID->execute();
		$getUniID->bind_result($uniID);
		$getUniID->fetch();
		$getUniID->close();
		$insertProg = $conn->prepare("INSERT INTO programme(programmeName, description, closingDate, pictureURL, universityID) VALUES(?,?,?,?,?);");
		$insertProg->bind_param("sssss",$_POST["progName"],$_POST["progDesc"],$_POST["closingDate"], $uploadedImg,$uniID);
		$insertProg->execute();
		$progID = $insertProg->insert_id;
		$insertProg->close();
		$insertEntry = $conn->prepare("INSERT INTO entryRequirement(programmeID, qualificationType, entryScore) VALUES(?,?,?);");
		$insertEntry->bind_param("sss",$progID,$q,$score);
		for ($k = 0; $k < count($_POST["qualification"]); $k++){
			$q = $_POST["qualification"][$k];
			$score = (double)$_POST["entryScore"][$k];
			$insertEntry->execute();
		}
		$insertEntry->close();
		echo "<script>var btn = document.getElementsByClassName(\"btn\")[1]; btn.value = \"Success Added\";
			btn.focus();
			window.onclick = function(event) { btn.value = \"Submit\";}</script>";
	}
	$conn->close();
	?>
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>
	<script src="js/record-Programme.js"></script> 
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>