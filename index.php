<?php
	session_start();
	$_SESSION['servername'] = "localhost";
	$_SESSION['username'] = "root";
	$_SESSION['password'] = "";
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$createDb = "CREATE DATABASE unicombined";
	$conn->query($createDb);
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$createUserTb = "CREATE TABLE user (username VARCHAR(50) PRIMARY KEY, 
	password VARCHAR(25) NOT NULL, name VARCHAR(50) NOT NULL, contactNo VARCHAR(20) NOT NULL, email VARCHAR(40) NOT NULL);";
	$conn->query($createUserTb);
	$createApplicantTb = "CREATE TABLE applicant (applicantID VARCHAR(50) PRIMARY KEY, IDtype VARCHAR(15) NOT NULL, 
	IDnum VARCHAR(50) NOT NULL, dateOfBirth DATE NOT NULL, nationality VARCHAR(25) NOT NULL, address VARCHAR (150) NOT NULL, 
	Foreign key(applicantID) references user(username));";
	$conn->query($createApplicantTb);
	$createQfObtainedTb = "CREATE TABLE qualificationObtained (applicantID VARCHAR(50) NOT NULL, 
	qualification VARCHAR(50) NOT NULL, overallScore DOUBLE NOT NULL, PRIMARY KEY(applicantID, qualification),
	FOREIGN KEY(applicantID) REFERENCES Applicant(applicantID), FOREIGN KEY(qualification) REFERENCES 
	Qualification(qualificationName));";
	$conn->query($createQfObtainedTb);
	$createResultTb = "CREATE TABLE result (applicantID VARCHAR(50) NOT NULL, subjectName VARCHAR(50) NOT NULL, 
	score DOUBLE NOT NULL, PRIMARY KEY(applicantID, subjectName), FOREIGN KEY(applicantID) REFERENCES Applicant(applicantID));";
	$conn->query($createResultTb);
	$createQfTb = "CREATE TABLE Qualification (qualificationName VARCHAR(50) PRIMARY KEY NOT NULL, 
	minScore INT NOT NULL, maxScore INT NOT NULL, resultCalcDesc VARCHAR(50) NOT NULL, resultCalcFormula varchar(50) NOT NULL);";
	$conn->query($createQfTb);
	$createGradeTb = "CREATE TABLE GradingSystem (qualification VARCHAR(50) NOT NULL, 
	grade VARCHAR(5)  NOT NULL, gradePoint DOUBLE NOT NULL, PRIMARY KEY(qualification, grade), 
	FOREIGN KEY(qualification) REFERENCES qualification(qualificationName));";
	$conn->query($createGradeTb);
	$createUniTb = "CREATE TABLE university (universityID INT PRIMARY KEY AUTO_INCREMENT, 
	universityName VARCHAR(50) NOT NULL, description VARCHAR(300) NOT NULL, pictureURL VARCHAR(50) NOT NULL);";
	$conn->query($createUniTb);
	$createUniAdminTb = "CREATE TABLE universityAdmin (adminID VARCHAR(50) PRIMARY KEY, password VARCHAR(50), universityID INT, 
	FOREIGN KEY(universityID) REFERENCES University(universityID));";
	$conn->query($createUniAdminTb);
	$createProgTb = "CREATE TABLE programme (programmeID INT AUTO_INCREMENT PRIMARY KEY, programmeName VARCHAR(150) NOT NULL, description VARCHAR(300) NOT NULL,
closingDate DATE NOT NULL, pictureURL VARCHAR(70) NOT NULL, universityID INT NOT NULL, FOREIGN KEY(universityID) REFERENCES University(universityID));";
	$conn->query($createProgTb);
	$createEntryTb = "CREATE TABLE entryRequirement (programmeID INT NOT NULL, qualificationType varchar(50) NOT NULL, entryScore DOUBLE NOT NULL,
		PRIMARY KEY(programmeID, qualificationType), FOREIGN KEY(programmeID) REFERENCES Programme(programmeID),
		FOREIGN KEY(qualificationType) REFERENCES Qualification(qualificationName));";
	$conn->query($createEntryTb);
	$createApplyTb = "CREATE TABLE application (applicationID INT AUTO_INCREMENT PRIMARY KEY, date DATE NOT NULL,
	status VARCHAR(25) NOT NULL, applicantID VARCHAR(50) NOT NULL, programmeID INT NOT NULL,
	FOREIGN KEY(applicantID) REFERENCES applicant(applicantID), FOREIGN KEY(programmeID) REFERENCES programme(programmeID));";
	$conn->query($createApplyTb);
	$getAllUni = "SELECT universityName, description, pictureURL from university;";
	$allUni = $conn->query($getAllUni);
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
    <link rel="stylesheet" href="css/magnific-popup.css">

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
                <a class="nav-link active" href="index.php">Home</a>
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

    <section class="site-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_2.jpg);">
      <div class="container">
        <div class="row align-items-center justify-content-center site-hero-inner">
          <div class="col-md-10">
  
            <div class="mb-5 element-animate">
              <div class="block-17">
                <h2 class="heading text-center mb-4">Find Top University That Suits You</h2><!--
                <form action="" method="post" class="d-block d-lg-flex mb-4">
                  <div class="fields d-block d-lg-flex">
                    <div class="textfield-search one-third"><input type="text" class="form-control" placeholder="Keyword search..."></div>
                    <div class="select-wrap one-third">
                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                      <select name="" id="" class="form-control">
                        <option value="">Category Course</option>
                        <option value="">Laravel</option>
                        <option value="">PHP</option>
                        <option value="">JavaScript</option>
                        <option value="">Python</option>
                      </select>
                    </div>
                    <div class="select-wrap one-third">
                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                      <select name="" id="" class="form-control">
                        <option value="">Difficulty</option>
                        <option value="">Beginner</option>
                        <option value="">Intermediate</option>
                        <option value="">Advance</option>
                      </select>
                    </div>
                  </div>
                  <input type="submit" class="search-submit btn btn-primary" value="Search">  
                </form>-->
                <p class="text-center mb-5">We combine various top universities to help you get ahead</p>
                <p class="text-center"><a href="student-sign-up.php" class="btn py-3 px-5">Register Now</a></p>
              </div>
            </div>
            
          </div>
        </div>
		<div id="scrollDown" class="text-center">
					<a href="#content" style="color:white;"><span></span>View More</a>
			</div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section element-animate" id="content">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 order-md-2">
            <div class="block-16">
              <figure>
                <img src="images/img_1.jpg" alt="Image placeholder" class="img-fluid">

                <!-- <a href="https://vimeo.com/45830194" class="button popup-vimeo" data-aos="fade-right" data-aos-delay="700"><span class="ion-ios-play"></span></a> -->

              </figure>
            </div>
          </div>
          <div class="col-md-6 order-md-1">

            <div class="block-15">
              <div class="heading">
                <h2>Welcome to UniCombined</h2>
              </div>
              <div class="text mb-5">
              <p>We combine various top universities in just one website to help you identify the university that most suits you.
			  We put your convenient as our top priority to help you save as much precious time as possible.</p>
              </div>              
            </div>

          </div>
          
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section pt-3 element-animate">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3">
            <div class="media block-6 d-block">
              <div class="icon mb-3"><span></span><img src="icons/card.png" alt="Image placeholder" class="img-fluid"></div>
              <div class="media-body">
                <h3 class="heading">#1 Sign Up for a Personal Account</h3>
                <p>Fill in your personal information on the sign up page before you explore more.</p>
              </div>
            </div> 
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="media block-6 d-block">
              <div class="icon mb-3"><span></span><img src="icons/exam.png" alt="Image placeholder" class="img-fluid"></span></div>
              <div class="media-body">
                <h3 class="heading">#2 Inspect Qualification &amp; Entry Score</h3>
                <p>Take a look at the two most important criteria before you send an application.</p>
              </div>
            </div> 
          </div>
          
          <div class="col-md-6 col-lg-3">
            <div class="media block-6 d-block">
              <div class="icon mb-3"><span></span><img src="icons/book.png" alt="Image placeholder" class="img-fluid"></span></div>
              <div class="media-body">
                <h3 class="heading">#3 Select a Programme &amp; University</h3>
                <p>Pick a programme to find out which universities offer it, or vice versa.</p>
              </div>
            </div> 
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="media block-6 d-block">
              <div class="icon mb-3"><span></span><img src="icons/application.png" alt="Image placeholder" class="img-fluid"></span></div>
              <div class="media-body">
                <h3 class="heading">#4 Apply for Desired University</h3>
                <p>Send us an application once you have selected a university and a programme.</p>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section bg-light element-animate" id="section-counter">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <figure><img src="images/img_2_b.jpg" alt="Image placeholder" class="img-fluid"></figure>
          </div>
          <div class="col-lg-5 ml-auto">
            <div class="block-15">
              <div class="heading">
                <h2>Education is Life</h2>
              </div>
              <div class="text mb-5">
                <p>Education is a lifetime process with no true beginning or ending. Education consists of experience, environment, socialization and communication.</p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="block-18 d-flex align-items-center">
                  <div class="icon mr-4">
                    <span class="flaticon-student"></span>
                  </div>
                  <div class="text">
                    <strong class="number" data-number="10921">0</strong>
                    <span>Users</span>
                  </div>
                </div>

                <div class="block-18 d-flex align-items-center">
                  <div class="icon mr-4">
                    <span class="flaticon-university"></span>
                  </div>
                  <div class="text">
                    <strong class="number" data-number="26">0</strong>
                    <span>Universities</span>
                  </div>
                </div>

              </div>
              <div class="col-md-6">
                <div class="block-18 d-flex align-items-center">
                  <div class="icon mr-4">
                    <span class="flaticon-books"></span>
                  </div>
                  <div class="text">
                    <strong class="number" data-number="7365">0</strong>
                    <span>Applications</span>
                  </div>
                </div>

                <div class="block-18 d-flex align-items-center">
                  <div class="icon mr-4">
                    <span class="flaticon-mortarboard"></span>
                  </div>
                  <div class="text">
                    <strong class="number" data-number="5832">0</strong>
                    <span>Graduates</span>
                  </div>
                </div>
                
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5 element-animate">
          <div class="col-md-7 text-center section-heading">
            <h2 class="text-primary heading">Popular Universities</h2>
			<p>Here we have few of the most popular, and highly demanded universities in Malaysia waiting for you to enroll.</p>
            <p><a href="programme-university.php" class="btn btn-primary py-2 px-4"><span class="ion-ios-book mr-2"></span>Enroll Now</a></p>
          </div>
        </div>
      </div>
      <div class="container-fluid block-11 element-animate">
        <div class="nonloop-block-11 owl-carousel">
			<?php
				if(isset($allUni->num_rows) && $allUni->num_rows > 0){
				while($row = $allUni->fetch_assoc()){
					echo "<div class=\"item\">
					<div class=\"block-19\">
					<figure>
					<img src=".$row["pictureURL"]." alt=\"uniImage\" class=\"img-fluid\">
					</figure>
					<div class = \"text\">
					<h2 class=\"heading\"><a href=\"show-programme.php?university=".$row["universityName"]."\">".$row["universityName"]."</a></h2>
					<p class=\"mb-4\">".$row["description"]."</p>
					</div>
					</div>
					</div>";
				}
				}
				$conn->close();
			?>
        </div>
      </div>

      
    </div>
    <!-- END section -->
  
    <footer class="site-footer">
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

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    
    <script src="js/jquery.magnific-popup.min.js"></script>

    <script src="js/main.js"></script>
  </body>
</html>