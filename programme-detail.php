<?php
	session_start();
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$getProg = "SELECT programmeID, programme.pictureURL, programmeName, programme.description, closingDate, universityName FROM programme,university WHERE 
	programme.universityID=university.universityID AND programmeID = '".$_GET["prog"]."';";
	$allProg = $conn->query($getProg);
	$row = $allProg->fetch_assoc();
	if (isset($_SESSION["UserName"])){
	$getApplication = "SELECT * FROM application WHERE programmeID = '".$_GET["prog"]."' AND 
	applicantID = '".$_SESSION["UserName"]."';";
	$applicantApply = $conn->query($getApplication);
	}
	$haveApplied = 0;
	if (isset($applicantApply->num_rows) && $applicantApply->num_rows > 0)
		$haveApplied = 1;
	
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
			  <?php
				if(isset($_SESSION["uniAdmin"]) && $_SESSION["uniAdmin"] === true){
					echo "<li class=\"nav-item dropdown\">
                <a class=\"nav-link dropdown-toggle\" href=\"uniAdminPage.php\" id=\"dropdown04\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">What You Can Do</a>
                <div class=\"dropdown-menu\" aria-labelledby=\"dropdown04\">
                  <a class=\"dropdown-item\" href=\"uniAdminPage.php\">View Programmes</a>
                  <a class=\"dropdown-item\" href=\"recordProgramme.php\">Add Programme</a>
                  <a class=\"dropdown-item\" href=\"review-application.php\">View Application</a>
                </div>

              </li>";
				}else if (isset($_SESSION['sysAdmin']) && $_SESSION["sysAdmin"] === true){
					echo "<li class=\"nav-item\">
                <a class=\"nav-link\" href=\"systemAdminPage.php\">Admin</a>
              </li>";
				}else if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
					echo "<li class=\"nav-item\">
                <a class=\"nav-link\" href=\"myApplication.php\">My Application</a>
              </li>";
				}
			  ?>
            </ul>
            <ul class="navbar-nav absolute-right">
              <?php
					if (isset($_SESSION["loggedin"])){
						echo "<li class = \"dropdown\"><a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"dropdown05\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"icon ion-person mr-1\"></span>".$_SESSION['UserName']."</a>
						<div class=\"dropdown-menu\" aria-labelledby=\"dropdown05\"> 
						<a class=\"dropdown-item\" href=\"logout.php\">Logout</a></div></li>";
					}else{
						echo "<li>
						<a href=\"loginStudent.php\">Login</a> / <a href=\"student-sign-up.php\">Register</a>
						</li>";
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
            
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->
	
    <section class="site-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-9">
            <div class="form-wrap">
              <h2 class="mb-4"><?php echo $row["programmeName"]; ?></h2>
                <div class="row">
                  <div class="col-md-12">
					<figure><img src="<?php echo $row["pictureURL"]; ?>" alt="programme picture" class="img-fluid"></figure>
					<p class="mb-2"><span class="ion-android-calendar"></span> Closing at <?php echo $row["closingDate"]; ?></p>
					<p class="mb-3"><span class="ion-android-pin"></span> <?php echo $row["universityName"]; ?></p>
					<p class="mb-4 ml-5 mr-5"><?php echo $row["description"]; ?></p>
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col-md-12">
                    <font size="5">Entry Requirement</font>
					<?php
						$getEntryReq = "SELECT * FROM entryRequirement WHERE programmeID = '".$row["programmeID"]."';";
						$entryReq = $conn->query($getEntryReq);
						while ($entryRow = $entryReq->fetch_assoc()){
							echo "<p>".$entryRow["qualificationType"]." &nbsp; &nbsp; &nbsp; ".$entryRow["entryScore"]."</p>";
						}
					?>
                  </div>
                </div>
                
                <div class="row">
				  <div class="col-md-8 bg-light p-4 <?php if(isset($haveApplied) && $haveApplied == 0) echo "d-none";?> ">
					<p>You have applied this programme on <?php if (isset($haveApplied) && $haveApplied > 0) echo $applicantApply->fetch_assoc()["date"];?></p>
				  </div>
                  <div class="col-md-12 <?php if ((isset($_SESSION['uniAdmin']) && $_SESSION['uniAdmin'] === true) || $haveApplied > 0) echo "d-none"; ?>" >
                    <p><a href="applyProg.php?progID=<?php echo $row["programmeID"]; ?>" class="btn btn-primary px-5 py-2" style="float: right;">
					Apply Now</a></p>
                  </div>
                </div>
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
    
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>
	<?php
		if(isset($_SESSION["successApply"]) && $_SESSION["successApply"] === true)
			echo "<script> var btn = document.getElementsByClassName('btn')[0];btn.focus();btn.disabled = true;</script>";
	?>
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