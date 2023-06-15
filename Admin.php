<?php
session_start();
if(isset($_SESSION['id']))
{
	?>
	<html>
 <head>
	<title>Lowa State University|Library</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="fontawesome-free-5.3.1-web/css/all.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/user.css">

 </head>
 <body>
  <div class="content">
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
	  <div class="container">
		<a class="navbar-brand" href="#">Lowa State University|Library</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
		  <ul class="navbar-nav ml-auto">
			<li class="nav-item active">
			  <a class="nav-link" href="newUser.php">Home
					<span class="sr-only">(current)</span>
				  </a>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a" href="javascript:void(0)">Book Details</a>
				<div class="dropdwn-content">
					<a href="view.php">Book Lending</a>
					<a href="returnsAdmin.php">Book Returns</a>
					<a href="booksAdmin.php">Book Availability</a>
					<a href="reserveAdmin.php">Book Reservations</a>
					<a href="bookDetails.php">Book Catalogues</a>
				</div>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a" href="javascript:void(0)">Member Status</a>
				<div class="dropdwn-content">
					<a href="members.php">Member Details</a>
					<a href="payments.php">Fine Payments</a>
				</div>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a" href="accountAdmin.php">Account</a>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a"href="logout.php">Sign out</a>
			</li>
		  </ul>
		  <form class="form-inline my-2 my-lg-0" action="searchAdmin.php" method="GET">
			<input class="form-control form-control-sm mr-sm-2" type="text" name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" placeholder="Search Books" aria-label="Search">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		  </form>
		</div>
	  </div>
	</nav>
	<!--Header-->
	<header>
	  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
		  <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		</ol>
		<div class="carousel-inner" role="listbox">
		  <!-- Slide One - Set the background image for this slide in the line below -->
		  <div class="carousel-item active" style="background-image: url('assets/img/admin.jpg')">
			<div class="carousel-caption d-none d-md-block">
			  <h3 class="display-4">Welcome Back!</h3>
			</div>
		  </div>
		</div>
	  </div>
	</header>

	<!-- Page Content -->
	<section class="py-5">
	  <div class="container">
		<h1 class="font-weight-light">Lowa State University|Library</h1>
		<p class="lead">Online Library Management System</p>
	  </div>
	</section>
	</div>
	<footer id="sticky-footer" class="py-4 bg-dark text-white-50">
		<div class="container text-center">
		  <small>Copyright &copy; Lowa State University|Library</small>
		</div>
	</footer>
 </body> 
</html>
	<?php
}
else
{
	$redirectUrl='Login.php';
	echo'<script type="application/javascript">
	alert("Login to view this page");
	window.location.href="'.$redirectUrl.'";</script>';
}
?>



