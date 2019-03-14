<?php
	session_start();
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$createQfTb = "CREATE TABLE Qualification (qualificationName VARCHAR(50) PRIMARY KEY NOT NULL, 
	minScore INT NOT NULL, maxScore INT NOT NULL, resultCalcDesc VARCHAR(50) NOT NULL, resultCalcFormula varchar(50) NOT NULL);";
	$conn->query($createQfTb);
	$createGradeTb = "CREATE TABLE GradingSystem (qualification VARCHAR(50) NOT NULL, 
	grade VARCHAR(5)  NOT NULL, gradePoint DOUBLE NOT NULL, PRIMARY KEY(qualification, grade), 
	FOREIGN KEY(qualification) REFERENCES qualification(qualificationName));";
	$conn->query($createGradeTb);
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
                <a class="nav-link" href="programme-university.php">Programme &amp; University</a>
              </li>
			  <li class="nav-item">
                <a class="nav-link" href="show-qualification.php">Qualification</a>
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

    <section class="site-hero site-sm-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_2.jpg);">
      <div class="container">
        <div class="row align-items-center justify-content-center site-hero-sm-inner">
          <div class="col-md-7 text-center">
  
            <div class="mb-5 element-animate">
              <p class="bcrumb"><a href="systemAdminPage.php">Admin home</a> <span class="sep ion-android-arrow-dropright px-2"></span> <span class="current">Add Qualification</span></p>
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
              <h2 class="mb-4">New Qualification</h2>
              <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return addQuali()">

				<div class="row">
					<div class="col-md-12 form-group">
						<textarea type="text" id="qualiName" name="qfName" placeholder="Qualification Name*" class="form-control" rows="2"></textarea>
						<p class="msg errorMsg">&#10007;<small> Please enter a qualification name</small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 form-group">
						<input type="number" id="minScore" name="minScore" placeholder="Minimum Score*" class = "form-control" onchange="minScoreSelect()">
						<p class="msg errorMsg">&#10007;<small> Please enter minimum score</small></p>
					</div>
					<div class="col-lg-6 form-group">
						<input type="number" id="maxScore" name="maxScore" placeholder="Maximum Score*" class = "form-control" onchange="maxScoreSelect()">
						<p class="msg errorMsg">&#10007;<small> Please enter a maximum score</small></p>
					</div>
				</div>
               <div class="row">
					<div class="col-md-6 form-group">
                      <select id="calculationType" name="calcDesc" class="form-control minimal" onchange="calculationTypeSelect()">
                        <option value="">Type of Calculation*</option>
                        <option value="Average of best subjects">Average of best subjects</option>
                        <option value="Average of subjects">Average of subjects</option>
						<option value="Total of best subjects">Total of best subjects</option>
                        <option value="Total of subjects">Total of subjects</option>
                      </select>
					  <p class="msg errorMsg">&#10007;<small> Please select a type of calculation</small></p>
					</div>
					<div class="col-md-6 form-group">
                      <select id="numOfSubject" name="subjectNum" class="form-control minimal" onchange="numOfSubjectSelect()">
                        <option value="">Number of Subjects</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
						<option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                      </select>
					  <p class="msg errorMsg">&#10007;<small> Please select number of subjects</small></p>
					</div>
                </div>
				<font size="5"><b>Grading System</b></font>
				<p>Click on the button below to add grade. (eg: A = (4.00))</p>
				<p class="msg errorMsg mb-2 p-1" style="text-transform: uppercase;"></p>
				<input type="button" value="&#43; Add grade" class="btn px-4 py-2 mb-4" onclick="addGrade()">
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
                  <li><a href="show-qualification.php">Qualification</a></li>
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
                <h3 class="heading mb-0">University Admin Login</a></h3>
                <div class="meta">
					<a href="loginUniAdmin.php"><small>Click here to login</small></a>	
                </div>
              </div>
            </div>  
            <div class="block-21 d-flex mb-4">
              <div class="text">
                <h3 class="heading mb-0">University Admin Register</a></h3>
                <div class="meta">
					<small>Please contact our admin via email</small></a>
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
			$insertQf = $conn->prepare("INSERT INTO Qualification(qualificationName, minScore, maxScore, resultCalcDesc, resultCalcFormula) VALUES(?,?,?,?,?);");
			$insertQf->bind_param("sssss",$_POST["qfName"],$_POST["minScore"],$_POST["maxScore"],$_POST["calcDesc"], $formula);
			$formula = "";
			for ($k = 0; $k < (integer)$_POST["subjectNum"]; $k++){
				$formula = $formula."Subj".($k+1)."+";
			}
			$formula = substr($formula, 0, strlen($formula)-1);
			if (stripos($_POST["calcDesc"], 'Average') !== false) {
				$formula = "(".$formula.")/".$_POST["subjectNum"];
			}
			$insertQf->execute();
			$insertQf->close();
			if (isset($_POST["grade"]) && count($_POST["grade"]) > 0){
				$insertGrade = $conn->prepare("INSERT INTO GradingSystem(qualification, grade, gradePoint) VALUES(?,?,?);");
				$insertGrade->bind_param("sss",$_POST["qfName"],$grade,$gradePoint);
				for ($i = 0; $i<count($_POST["grade"]); $i++){
					$grade = $_POST["grade"][$i];
					$gradePoint = $_POST["gradePoint"][$i];
					if ($grade != "")
						$insertGrade->execute();
				}
				$insertGrade->close();
			}
			echo "<script>var btn = document.getElementsByClassName(\"btn\")[1]; btn.value = \"Success Added\";
			btn.focus();
			window.onclick = function(event) { btn.value = \"Submit\";}</script>";
		}
		$conn->close();
	?>
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>
	<script src="js/add-qualification.js"></script> 
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