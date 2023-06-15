<?php
session_start();
if(isset($_SESSION['id']))
{
	
?>
<!DOCTYPE html>
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
			  <a class="nav-link dropbtn a" href="javascript:void(0)">My Books</a>
				<div class="dropdwn-content">
					<a href="reserved.php">Reserved Books</a>
					<a href="borrowed.php">Borrowed Books</a>
					<a href="returned.php">Returned Books</a>
				</div>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a" href="javascript:void(0)">Book Categories</a>
				<div class="dropdwn-content">
					<a href="#scieMath">Science & Maths</a>
					<a href="#medical">Medical</a>
					<a href="#artMusic">Art & Music</a>
					<a href="#history">History</a>
					<a href="#biograph">Biographies</a>
					<a href="#scifiFa">Sci-Fi & Fantasy</a>
				</div>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="about.php">About</a>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a" href="account.php">Account</a>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a"href="logout.php">Sign out</a>
			</li>
		  </ul>
		  <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
			<input class="form-control form-control-sm mr-sm-2" type="text" name="k" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" placeholder="Search Books" aria-label="Search">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		  </form>
		</div>
	  </div>
	</nav>
	<!--Header-->
	<header class="pt-3 mt-3">
		<div class="header-image" style="background-image: url('assets/img/book1.jpg')">
			<div>
			  <h1 class="heading display-4 pt-3 mt-3 text-center">Book Categories</h1>
			</div>
		</div>
	</header>
	
	
			  <!-- Science Section -->
			  <div class="container-fluid" id="scieMath">
			   <iframe src="Categories/scieMath.php"style="border:none;width:100%;height:800px;" onload="resizeIframe(this)"></iframe> 
			  </div>
			  <!-- Art Section -->
			  <div class="container-fluid" id="artMusic">
			   <iframe src="Categories/artMusic.php"style="border:none;width:100%;height:800px;" onload="resizeIframe(this);"></iframe> 
			  </div>
			   <!-- Medical Section -->
			  <div class="container-fluid" id="medical">
			   <iframe src="Categories/medical.php"style="border:none;width:100%;height:800px;" onload="resizeIframe(this);"></iframe> 
			  </div>
			  <!-- History Section -->
			  <div class="container-fluid" id="history">
			   <iframe src="Categories/history.php"style="border:none;width:100%;height:800px;" onload="resizeIframe(this);"></iframe> 
			  </div>
			  <!-- Biographies Section -->
			  <div class="container-fluid" id="biograph">
			   <iframe src="Categories/biograph.php"style="border:none;width:100%;height:800px;" onload="resizeIframe(this);"></iframe> 
			  </div>
			  <!-- Sci-Fi Fantasy Section -->
			  <div class="container-fluid" id="scifiFa">
			   <iframe src="Categories/scifiFa.php"style="border:none;width:100%;height:900px;" onload="resizeIframe(this);"></iframe> 
			  </div>
			  <script>
				  function resizeIframe(obj) {
					obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
				  }
			  </script>
			
	
	
	
	
	
	
	
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-sm-4 modal-dialog-centered " role="document">
		<div class="modal-content myModal">
		  <div class="modal-body modal-text text-center">
			Oops! Already reserved or borrowed ...
		  </div>
		</div>
	  </div>
	</div>
	</div>
	
	<!-- Site footer -->
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