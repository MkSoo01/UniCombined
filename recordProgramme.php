<?php
	session_start();
	$_SESSION['servername'] = "localhost";
	$_SESSION['username'] = "root";
	$_SESSION['password'] = "";
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$useDb = "use unicombined";
		$conn->query($useDb);
	$createProgTb = "CREATE TABLE programme (programmeID INT AUTO_INCREMENT PRIMARY KEY, programmeName VARCHAR(50), description VARCHAR(100),
closingDate DATE, universityID INT, FOREIGN KEY(universityID) REFERENCES University(universityID));";
	$conn->query($createProgTb);
	$createEntryTb = "CREATE TABLE entryRequirement (programmeID INT, qualificationType varchar(40), entryScore DOUBLE,
		PRIMARY KEY(programmeID, qualificationType), FOREIGN KEY(programmeID) REFERENCES Programme(programmeID),
		FOREIGN KEY(qualificationType) REFERENCES Qualification(qualificationName));";
		$conn->query($createEntryTb);
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Free Education Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    
    <header role="banner">
     
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand absolute" href="index.html">UniCombined</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse navbar-light" id="navbarsExample05">
			<ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.html">Home</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="uniAdminPage.php">All Programme</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link" href="blog.html">All Application</a>
              </li>
            </ul>
            <ul class="navbar-nav absolute-right">
			  <?php
					if (isset($_SESSION["loggedin"])){
						echo "<li class = \"dropdown\"><a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"dropdown05\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">".$_SESSION['UserName']."</a>
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

    <section class="site-section">
      <div class="container">
        <!--<div class="row">
          <!--
          <div class="wrapper">
            <div class="block-24 mb-5">
				
				<nav id="sidebar">
					<h3 class="navbar-brand absolute mt-3 ml-4 mb-5">UniCombined</h3>
					<button class="btn btn-primary px-5 py-2 ml-3 mb-3">Add Programme</button>
					<ul>
						<li><a href="#" class="pt-1 pb-1 active">All Programme </a></li>
						<li><a href="#" class="pt-1 pb-1">All Application </a></li>
					</ul>
				</nav>
            </div>
          </div>
          <!-- END Sidebar -->
        <!--</div>-->
		<div class="row justify-content-center">
			<div class="col-md-7">
				<div class="mb-3 p-5">
					<h2 class="mb-4">Add Programme</h2>
					<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return submitProgramme()">
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
            <h3>University</h3>
            <p>Perferendis eum illum voluptatibus dolore tempora consequatur minus asperiores temporibus.</p>
          </div>
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <h3 class="heading">Quick Link</h3>
            <div class="row">
              <div class="col-md-6">
                <ul class="list-unstyled">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">About Us</a></li>
                  <li><a href="#">Courses</a></li>
                  <li><a href="#">Pages</a></li>
                </ul>
              </div>
              <div class="col-md-6">
                <ul class="list-unstyled">
                  <li><a href="#">News</a></li>
                  <li><a href="#">Support</a></li>
                  <li><a href="#">Contact</a></li>
                  <li><a href="#">Privacy</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <h3 class="heading">Blog</h3>
            <div class="block-21 d-flex mb-4">
              <div class="text">
                <h3 class="heading mb-0"><a href="#">Consectetur Adipisicing Elit</a></h3>
                <div class="meta">
                  <div><a href="#"><span class="ion-android-calendar"></span> May 29, 2018</a></div>
                  <div><a href="#"><span class="ion-android-person"></span> Admin</a></div>
                  <div><a href="#"><span class="ion-chatbubble"></span> 19</a></div>
                </div>
              </div>
            </div>  
            <div class="block-21 d-flex mb-4">
              <div class="text">
                <h3 class="heading mb-0"><a href="#">Dolore Tempora Consequatur</a></h3>
                <div class="meta">
                  <div><a href="#"><span class="ion-android-calendar"></span> May 29, 2018</a></div>
                  <div><a href="#"><span class="ion-android-person"></span> Admin</a></div>
                  <div><a href="#"><span class="ion-chatbubble"></span> 19</a></div>
                </div>
              </div>
            </div>  
            <div class="block-21 d-flex mb-4">
              <div class="text">
                <h3 class="heading mb-0"><a href="#">Perferendis eum illum</a></h3>
                <div class="meta">
                  <div><a href="#"><span class="ion-android-calendar"></span> May 29, 2018</a></div>
                  <div><a href="#"><span class="ion-android-person"></span> Admin</a></div>
                  <div><a href="#"><span class="ion-chatbubble"></span> 19</a></div>
                </div>
              </div>
            </div>  
          </div>
          <div class="col-md-6 col-lg-3 mb-5 mb-lg-0">
            <h3 class="heading">Contact Information</h3>
            <div class="block-23">
              <ul>
                <li><span class="icon ion-android-pin"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                <li><a href="#"><span class="icon ion-ios-telephone"></span><span class="text">+2 392 3929 210</span></a></li>
                <li><a href="#"><span class="icon ion-android-mail"></span><span class="text">info@yourdomain.com</span></a></li>
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
            <p class="float-md-right">
              <a href="#" class="fa fa-facebook p-2"></a>
              <a href="#" class="fa fa-twitter p-2"></a>
              <a href="#" class="fa fa-linkedin p-2"></a>
              <a href="#" class="fa fa-instagram p-2"></a>

            </p>
          </div>
        </div>
      </div>
    </footer>
    <!-- END footer -->
    <?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$getUniID = $conn->prepare("SELECT University.universityID FROM University, UniversityAdmin WHERE 
		University.universityID = UniversityAdmin.universityID AND adminID = ?");
		$getUniID->bind_param("s",$_SESSION["UserName"]);
		$getUniID->execute();
		$getUniID->bind_result($uniID);
		$getUniID->fetch();
		$getUniID->close();
		$insertProg = $conn->prepare("INSERT INTO programme(programmeName, description, closingDate, universityID) VALUES(?,?,?,?);");
		$insertProg->bind_param("ssss",$_POST["progName"],$_POST["progDesc"],$_POST["closingDate"],$uniID);
		$insertProg->execute();
		$insertProg->close();
		$getProgID = $conn->prepare("SELECT programmeID FROM programme WHERE programmeName = ? AND description = ?");
		$getProgID->bind_param("ss",$_POST["progName"],$_POST["progDesc"]);
		$getProgID->execute();
		$getProgID->bind_result($progID);
		$getProgID->fetch();
		$getProgID->close();
		$insertEntry = $conn->prepare("INSERT INTO entryRequirement(programmeID, qualificationType, entryScore) VALUES(?,?,?);");
		$insertEntry->bind_param("sss",$progID,$q,$score);
		for ($k = 0; $k < count($_POST["qualification"]); $k++){
			$q = $_POST["qualification"][$k];
			$score = (double)$_POST["entryScore"][$k];
			$insertEntry->execute();
		}
		$insertEntry->close();
	}
	$conn->close();
	?>
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>
	<script src="js/recordProgramme.js"></script>
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