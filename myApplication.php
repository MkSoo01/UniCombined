<?php
	session_start();
	$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password']);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$useDb = "use unicombined";
		$conn->query($useDb);
		$getAllApplication = "SELECT application.programmeID, programmeName, date, status FROM application, programme WHERE application.programmeID = programme.programmeID AND 
	applicantID = '".$_SESSION["UserName"]."' ORDER BY date DESC";
		$allApplication = $conn->query($getAllApplication);
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
			  <li class="nav-item">
                <a class="nav-link active" href="myApplication.php">My Application</a>
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

    <section class="site-section">
      <div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="mb-3 p-5">
					<?php
						if ($allApplication->num_rows == 0){
							echo "<h2 class=\"heading mb-5\">You currently do not have any application yet</h2>"."
							<p><a href=\"programme-university.php\" class=\"btn btn-primary py-2 px-4\">View programme</a></p>";
						}else{
							$str="";
							while($row = $allApplication->fetch_assoc()){
								$str = $str."<tr class='clickable-row' data-href='programme-detail.php?prog=".$row["programmeID"]."'>
										<td>".$row["programmeName"]."</td>
										<td>".$row["date"]."</td>
										<td>".$row["status"]."</td>
									</tr></a>";
							}
							if (isset($_SESSION["successApply"]) && $_SESSION["successApply"] === true){
								$_SESSION["successApply"] = false;
								echo "<div class=\"alert alert-success alert-dismissible pb-0\"><button type = \"button\" class=\"close\" data-dismiss=\"alert\">&times;</button><p style=\"text-transform: uppercase;\">New Application is added</p></div>";
							}
							echo "<h2 class=\"mb-4\">My Applications</h2>"."
							<div class=\"row\">
							<div class=\"table-responsive\">
							<table class=\"table table-hover\">
								<thead>
									<tr style=\"font-weight:500\">
										<td>Programme</td>
										<td>Application date</td>
										<td>Status</td>
									</tr>
								</thead>
								<tbody>".$str."</tbody>
							</table>
						</div>
					</div>";
						}
					?>
				</div>
			</div>
		</div>
    </section>
    <footer class="site-footer border-top bg-light">
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

    <script src="js/main.js"></script>
	<script>
		 $(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
	</script>
  </body>
</html>