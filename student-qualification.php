<?php
	session_start();
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$createQfObtainedTb = "CREATE TABLE qualificationObtained (applicantID VARCHAR(50), 
	qualification VARCHAR(50), overallScore DOUBLE, PRIMARY KEY(applicantID, qualification),
	FOREIGN KEY(applicantID) REFERENCES Applicant(applicantID), FOREIGN KEY(qualification) REFERENCES 
	Qualification(qualificationName));";
	$conn->query($createQfObtainedTb);
	$createResultTb = "CREATE TABLE result (applicantID VARCHAR(50), subjectName VARCHAR(50), 
	score DOUBLE, PRIMARY KEY(applicantID, subjectName), FOREIGN KEY(applicantID) REFERENCES Applicant(applicantID));";
	$conn->query($createResultTb);
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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header role="banner">
     
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand absolute" href="index.php">University</a>
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
                <a class="nav-link" href="show-qualification.html">Qualification</a>
              </li>
            </ul>
            <ul class="navbar-nav absolute-right">
              <li>
                <a href="loginStudent.php">Login</a> / <a href="student-sign-up.php">Register</a>
              </li>
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
              <p class="bcrumb"><a href="index.php">Home</a> <span class="sep ion-android-arrow-dropright px-2"></span>  <span class="current">Student qualification</span></p>
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
              <h5><?php echo $_SESSION['UserName']; ?>, welcome to UniCombined</h5>
			  <h2 class="mb-4">Academic Qualification</h2>
              <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return signUp()">
				<div class="row">
					<div class="col-md-12 form-group">
                      <select name="qualificationType" id="qualificationType" class="form-control minimal" onchange="qSelect()">
                        <option value="">Qualification Obtained*</option>
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
					  <p class="msg errorMsg">&#10007;<small> Please select Qualification Obtained</small></p>
					</div>
                </div>
				<label>Enter all the subjects and the respective grade/score below</label>
				<div class="row">
					<div class="col-lg-6 form-group">
						<input type="text" name="subject[]" placeholder="Subject*" class = "subject form-control">
						<p class="msg errorMsg">&#10007;<small> Please enter subject</small></p>
					</div>
					<div class="col-lg-6 form-group">
						<input type="text" name="grade[]" placeholder="Grade/Score*" class = "grade form-control">
						<p class="msg errorMsg">&#10007;<small> Please enter grade/score</small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 form-group">
						<input type="text" name="subject[]" placeholder="Subject*" class = "form-control subject">
						<p class="msg errorMsg">&#10007;<small> Please enter subject</small></p>
					</div>
					<div class="col-lg-6 form-group">
						<input type="text" name="grade[]" placeholder="Grade/Score*" class = "form-control grade">
						<p class="msg errorMsg">&#10007;<small> Please enter grade/score</small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 form-group">
						<input type="text" name="subject[]" placeholder="Subject*" class = "form-control subject">
						<p class="msg errorMsg">&#10007;<small> Please enter subject</small></p>
					</div>
					<div class="col-lg-6 form-group">
						<input type="text" name="grade[]" placeholder="Grade/Score*" class = "form-control grade">
						<p class="msg errorMsg">&#10007;<small> Please enter grade/score</small></p>
					</div>
				</div>
				<p class="msg errorMsg col-md-12 mb-2 p-1" style="text-transform: uppercase;"></p>
				<input type="button" value="&#43; Add subject" class="btn px-2 py-2 mb-4" onclick="addSubject()">
				<p><small>* required</small></p>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="submit" value="Create Account" class="btn btn-primary px-3 py-2">
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
                  <li><a href="show-qualification.html">Qualification</a></li>
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
		$findCalcFormula = $conn->prepare("SELECT resultCalcFormula FROM qualification WHERE qualificationName = ?;");
		$findCalcFormula->bind_param("s", $_POST["qualificationType"]);
		$findCalcFormula->execute();
		$findCalcFormula->bind_result($formula);
		$findCalcFormula->fetch();
		$findCalcFormula->close();
		$findScore = $conn->prepare("SELECT gradePoint FROM qualification, gradingSystem WHERE qualification.qualificationName = 
		gradingsystem.qualification and qualificationName = ? and grade = ?;");
		$findScore->bind_param("ss", $_POST["qualificationType"], $grade);
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$numOfSubject = substr_count($formula,"+")+1;
			$str = "<script>var subject = document.getElementsByClassName(\"subject\");
						var grade = document.getElementsByClassName(\"grade\");
						var errorMsg = document.getElementsByClassName(\"errorMsg\");
						var selectBox = document.getElementsByTagName(\"select\")
						var inputBox = document.getElementsByTagName(\"input\");"; 
			for ($count=0; $count < $numOfSubject; $count++)
			{
				if (empty($_POST["subject"][$count]))
					$lessSubject = true;
			}
			if ($lessSubject){
				$str2 = "";
				$num = 0;
				for ($k = 0; $k < 3; $k++){
					$str2 = $str2."inputBox[".$num."].value = \"".$_POST['subject'][$k]."\";inputBox[".
					($num+1)."].value = \"".$_POST['grade'][$k]."\";";
					$num = $num + 2;
				}
				echo $str."errorMsg[7].innerHTML = \"&#10007;<small>Please enter at least "
				.$numOfSubject." subjects for your qualification</small>\"; 
				errorMsg[7].style.background = \"red\";errorMsg[7].style.color = \"white\";
				errorMsg[7].style.display = \"block\";
				selectBox[0].value = \"".$_POST['qualificationType']."\";".$str2."</script>";
			}else{
				$overallScore = 0;
				$scoreList = array();
				$j = 0;
				foreach($_POST["grade"] as $value){
					if (!is_numeric($value)){
						$grade = $value;
						$findScore->execute();
						$findScore->store_result();
						if($findScore->num_rows == 1){
							$findScore->bind_result($score);
							$findScore->fetch();
							$scoreList[$_POST["subject"][$j]] = $score;
						}
					}else
						$scoreList[$_POST["subject"][$j]] = (double)$value;
					$j++;
				}
				$findScore->close();
				if (isset($scoreList)){
					arsort($scoreList);
					$scoreArray = array_values($scoreList);
					if (isset($scoreArray) && isset($overallScore)){
						for ($i = 0 ; $i <= $numOfSubject; $i++){
							$overallScore = $overallScore + $scoreArray[$i];
						}
					}
					if (substr_count($formula,"/") == 1)
						$overallScore = $overallScore / $numOfSubject;
					$insertQfObtained = $conn->prepare("INSERT INTO QualificationObtained(applicantID,qualification,overallScore) VALUES(?,?,?);");
					$insertQfObtained->bind_param("sss",$_SESSION["UserName"],$_POST["qualificationType"], $overallScore);
					$insertQfObtained->execute();
					$insertQfObtained->close();
					$insertResult = $conn->prepare("INSERT INTO Result(applicantID, subjectName, score) VALUES (?,?,?);");
					$insertResult->bind_param("sss",$_SESSION["UserName"],$subjectName, $subjectScore);
					foreach ($scoreList as $key => $value){
						$subjectName = $key;
						$subjectScore = $value;
						$insertResult->execute();
					}
					$insertResult->close();
				}
				echo "<script>window.open('programme-university.php','_self')</script>";
			}
		}
		$conn->close();
	?>
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>
	<script src="js/student-qualification.js"></script>
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