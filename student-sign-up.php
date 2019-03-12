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
	$useDb = "USE unicombined";
	$conn->query($createDb);
	$conn->query($useDb);
	$createUserTb = "CREATE TABLE user (username VARCHAR(50) PRIMARY KEY, 
	password VARCHAR(25), name VARCHAR(50), contactNo VARCHAR(20), email VARCHAR(40));";
	$conn->query($createUserTb);
	$createApplicantTb = "CREATE TABLE applicant (applicantID VARCHAR(50) PRIMARY KEY, IDtype VARCHAR(15), 
	IDnum VARCHAR(50), dateOfBirth DATE, nationality VARCHAR(25), address VARCHAR (150), 
	Foreign key(applicantID) references user(username));";
	$conn->query($createApplicantTb);
?>
<!DOCTYPE html>
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
              <p class="bcrumb"><a href="index.php">Home</a> <span class="sep ion-android-arrow-dropright px-2"></span>  <span class="current">Register</span></p>
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
              <h2 class="mb-4">Create your UniCombined account</h2>
              <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST" onsubmit="return signUp()">
                <div class="row">
                  <div class="col-md-12 form-group">
                    <input type="text" id="username" name="username" placeholder="Username*" class="form-control">
					<p class="msg errorMsg">&#10007;<small> Please enter username</small></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 form-group">
                    <input type="password" id="psw" name="psw" placeholder="Password*" class="form-control">
					<p class="msg"><small>Use 6 or more characters with a mix of letters and numbers</small></p>
                  </div>
				  
				  <div class="col-lg-6 form-group confirmPsw">
                    <input type="password" id="confirmPsw" name="confirmPsw" placeholder="Confirm Password*" class="form-control">
					<p class="msg errorMsg">&#10007;<small> Please enter confirm password</small></p>
                  </div>
                </div>
				<div class="row">
					<div class="col-lg-6 form-group">
                      <select id="idType" name="idType" class="form-control minimal" onchange="idTypeSelect()">
                        <option value="">ID Type*</option>
                        <option value="Identity Card">Identity Card</option>
                        <option value="Passport">Passport</option>
                      </select>
					  <p class="msg errorMsg">&#10007;<small> Please enter ID type</small></p>
					</div>
					<div class="col-lg-6 form-group">
						<input type=="text" id="idNo" name="idNo" placeholder="ID Number*" class = "form-control">
						<p class="msg errorMsg">&#10007;<small> Please enter ID number</small></p>
					</div>
                </div>
				<div class="row">
					<div class="col-md-12 form-group">
						<input type="text" id="name" name = "name" placeholder="Full name as ID*" class = "form-control">
						<p class="msg errorMsg">&#10007;<small> Please enter full name</small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 form-group">
						<input type="text" id="nationality" name="nationality" placeholder="Nationality*" class = "form-control">
						<p class="msg errorMsg">&#10007;<small> Please enter nationality</small></p>
					</div>
					<div class="col-lg-6 form-group">
						<input type="date" id="date" name="date" placeholder="DOB*" class = "form-control" onchange="dateSelect()">
						<p class="msg errorMsg">&#10007;<small> Please enter date of birth</small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 form-group">
						<input type="text" id="email" name="email" placeholder="Email Address*" class = "form-control">
						<p class="msg"><small>Use the format example@email.com</small></p>
					</div>
					<div class="col-lg-6 form-group">
						<input type="text" id="mobileNo" name="mobileNo" placeholder="Mobile Number*" class = "form-control">
						<p class="msg"><small>Use the format XXX-XXXXXXX</small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<textarea type="text" id="address" name="address" placeholder="Address*" class = "form-control" rows="2"></textarea>
						<p class="msg errorMsg">&#10007;<small> Please enter Address</small></p>
					</div>
				</div>
				<p><small>* required</small></p>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="submit" value="Next" class="btn btn-primary px-5 py-2">
                  </div>
				  <div class="col-md-6" style="text-align:right">
					<a href="loginStudent.php"><b>Sign in instead</b></a>
				  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


    </section>
<?php
	$findUsername = $conn->prepare("SELECT username FROM User WHERE username = ?;");
	$findUsername->bind_param("s", $_POST["username"]);
	$findUsername->execute();
	$findUsername->store_result();
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if($findUsername->num_rows > 0){
			$inputBox = array("username", "psw", "confirmPsw", "idType", "idNo", 
			"name", "nationality", "date", "email", "mobileNo", "address");
			$echoStr = "";
			foreach ($inputBox as $value){
				$echoStr = $echoStr."document.getElementById(\"".$value."\").value = \"".$_POST[$value]."\";";
			}
			$echoStr = "<script>".$echoStr."
			var username = document.getElementById(\"username\");
			var errorMsg = document.getElementsByTagName(\"p\");
			errorMsg[1].innerHTML = \"&#10007<small> That username is taken. Try another</small>\"; 
			errorMsg[1].style.display = \"block\";
			username.style.border = \"1px solid red\";
			username.focus();
			</script>";
			echo $echoStr;
		}else{
			$_SESSION['UserName'] = $_POST["username"];
			$insertUser = $conn->prepare("INSERT INTO User(username, password, name, contactNo, email) VALUES(?,?,?,?,?);");
			$insertUser->bind_param("sssss",$_POST["username"],$_POST["psw"],$_POST["name"],$_POST["mobileNo"],$_POST["email"]);
			$insertUser->execute();
			$insertUser->close();
			$insertApplicant = $conn->prepare("INSERT INTO applicant(applicantID, IDtype, IDnum, dateOfBirth, nationality, address) VALUES(?,?,?,?,?,?);");
			$insertApplicant->bind_param("ssssss",$_POST["username"],$_POST["idType"],$_POST["idNo"],$_POST["date"],$_POST["nationality"],$_POST["address"]);
			$insertApplicant->execute();
			$insertApplicant->close();
			echo "<script>window.open(\"student-qualification.php\",\"_parent\");</script>";
			exit;
		}
	}
	$conn->close();
?>
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
    
    <!-- loader -->
    <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#f4b214"/></svg></div>
	<script src="js/student-sign-up.js"></script> 
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