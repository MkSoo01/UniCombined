<?php
	session_start();
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$useDb = "USE unicombined";
	$conn->query($useDb);
	$getAllUni = "SELECT universityName from university;";
	$allUni = $conn->query($getAllUni);
	$getAllProg = "SELECT programmeID, programme.pictureURL, programmeName, closingDate,universityName from programme,university WHERE 
	programme.universityID=university.universityID AND closingDate > now();";
	$allProg = $conn->query($getAllProg);
	$getSearchedProg = $conn->prepare("SELECT programmeID, programme.pictureURL, programmeName, closingDate,universityName from programme, university where 
	programme.universityID = university.universityID AND programmeName LIKE ? AND closingDate > now();");
	$getSearchedProg->bind_param("s",$searchedName);
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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <a class="nav-link active" href="programme-university.php">Programme &amp; University</a>
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

    <section class="site-hero sm-hero overlay" data-stellar-background-ratio="0.5" style="background-image: url(images/big_image_2.jpg);">
      <div class="container">
        <div class="row align-items-center justify-content-center sm-inner">
          <div class="col-md-7 text-center">
  
            <div class="mb-5 element-animate">
              <h1 class="mb-2">Programme &amp; University</h1>
            </div>
            
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

	
    <div class="site-section bg-light" id="content">
      <div class="container">
	  
        <div class="row"> 
          <div class="col-md-6 col-lg-8 order-md-2">
			<div class="row mb-5">
				<div class="col-md-12">
		  	<form class="search" action="<?php echo $_SERVER['PHP_SELF']."#content";?>" method="POST">
				<input type="text" placeholder="Search Programme..." name="searchProgramme" id="searchProgramme">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
			</div>
			</div>
            <div class="row">
				<?php
					$count = 0;
					$progA = array();
					$progGroup = array();
					$currentPage = 1;
					$hasProg = true;
					if (isset($_GET["page"]))
						$currentPage = $_GET["page"];
					$showProg = (int)$currentPage*6;
					if ($_SERVER["REQUEST_METHOD"] == "POST") {
						$searchedName = "%".$_POST["searchProgramme"]."%";
						$getSearchedProg->execute();
						$getSearchedProg->store_result();
						$progNum = $getSearchedProg->num_rows;
						$getSearchedProg->bind_result($progID, $img, $progName, $closingDate, $uniName);
						if ($progNum > 0){
						while($getSearchedProg->fetch()){
							$progA["progID"] = $progID;
							$progA["progImg"] = $img;
							$progA["progName"] = $progName;
							$progA["closingDate"] = $closingDate;
							$progA["uniName"] = $uniName;
							array_push($progGroup, $progA);
							$progA = array();
							$count++;
						}
						$count = 0;
						}else{
							$hasProg = false;
							echo "<p class=\"ml-4\">Result related to\"".$_POST["searchProgramme"]."\" is not found</p>";
						}
						$getSearchedProg->close();
					}else{
						$progNum = $allProg->num_rows;
					while($row = $allProg->fetch_assoc()){
						$progA["progID"] = $row["programmeID"];
						$progA["progImg"] = $row["pictureURL"];
						$progA["progName"] = $row["programmeName"];
						$progA["closingDate"] = $row["closingDate"];
						$progA["uniName"] = $row["universityName"];
						array_push($progGroup, $progA);
						$progA = array();
						$count++;
					}
					$count = 0;
					}
					$showProg = (int)$currentPage * 6;
					$progIndex = $showProg - 6;
					if($progNum < $showProg)
						$showProg = $progNum;
					if ($hasProg){
						for ($i = $progIndex; $i<$showProg; $i++){
							echo "<div class=\"col-md-12 col-lg-6 mb-5\">
							<div class=\"block-20 \">
							<figure><a href=\"programme-detail.php?prog=".$progGroup[$i]["progID"]."\"><img src=\"".$progGroup[$i]["progImg"]."\" alt=\"programme image\" class=\"img-fluid\"></a>
							</figure>
							<div class=\"text\">
							<h3 class=\"heading\"><a href=\"programme-detail.php?prog=".$progGroup[$i]["progID"]."\">".$progGroup[$i]["progName"].
							"</a></h3>
							<div class=\"meta\">
							<div><span class=\"ion-android-calendar\"></span> Closing at ".$progGroup[$i]["closingDate"].
							"<br><span class=\"ion-android-pin\"></span> ".$progGroup[$i]["uniName"]."</a></div>
							</div>
							</div>
							</div>
							</div>";
						}
					}
					
				?>
              
            </div>
          </div>
          <!-- END content -->
          <div class="col-md-6 col-lg-4 order-md-1">

            <div class="block-24 mb-5">
              <h3 class="heading">List of University</h3>
              <ul>
				<?php
					if(isset($allUni->num_rows) && $allUni->num_rows > 0){
					while($row = $allUni->fetch_assoc()){
						echo "<li>
							<a href=\"show-programme.php?university=".$row["universityName"]."\">".$row["universityName"]."</a>
							</li>";
					}
					}
				?>
              </ul>
            </div>
          </div>
		  </div>
          <div class="row mb-5">
              <div class="col-md-12 text-center">
                <div class="block-27">
                  <ul>
					<?php
						if ($_SERVER["REQUEST_METHOD"] != "POST") {
							$progNum = $allProg->num_rows;
						}
						$pageNum = (int)($progNum / 6);
						if ($progNum / 6 > 1.0){
							if ($progNum % 6 > 0)
								$pageNum++;
						}
						$str = "";
						for ($k = 0; $k < $pageNum; $k++){
							if ($currentPage == $k+1)
								$str = " class = \"active\"";
							echo "<li".$str."><a href=\"programme-university.php?page=".($k+1)."#content\">".($k+1)."</a></li>";
							$str = "";
						}
					?>
                  </ul>
                </div>
              </div>
            </div>
        
      </div>
    </div>
  
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
	<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			echo "<script>document.getElementById(\"searchProgramme\").focus();</script>";
		}		
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