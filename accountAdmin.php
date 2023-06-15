<?php
session_start();
if(isset($_SESSION['id']))
{
	require_once("dbcon\db.php");
	
	$username=$_SESSION['id'];
	$pdo_statement = $pdo_conn->prepare("SELECT * FROM login WHERE Username='$username'");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
	$password=$result[0]['Password'];	
	$uname=$result[0]['Username'];	
	
	$memberID=$result[0]['MemberID'];	
	$stmt = $pdo_conn->prepare("SELECT * FROM member_details WHERE MemberID='$memberID'");
	$stmt->execute(); 
	$user = $stmt->fetchAll();
	
	if(!empty($_POST["submit1"])) {
		$pdo_statement=$pdo_conn->prepare("update member_details set 
		FirstName='" . $_POST[ 'fname' ]. "',
		LastName='" . $_POST[ 'lname' ]. "',
		Email='" . $_POST[ 'email' ]. "' where MemberID=" . $memberID);
		$result = $pdo_statement->execute();
		if($result) {
			header('location:account.php');
		}
	}
	
	if(!empty($_POST["submit2"])) {
		$pdo_statement=$pdo_conn->prepare("update login set 
		Password='" . $_POST[ 'pass' ]. "',
		Username='" . $_POST[ 'uname' ]. "' where MemberID=" . $memberID);
		$result = $pdo_statement->execute();
		if($result) {
			header('location:login.php');
		}
	}
		
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
	<script src="js/sortSearch.js"></script>
	<link rel="stylesheet" type="text/css" href="css/user.css">

 </head>
 <body class="account">
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
			  <a class="nav-link" href="admin.php">Home
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
			<div class="header-image" style="background-image: url('assets/img/book1.jpg')">
			</div>
		</header>
		
		<div class="d-flex" id="wrapper">
			<!-- Page Content -->
			<div id="page-content-wrapper">
			  <!--nav-tab-->
			  <nav class="navbar navbar-expand-lg navbar-light justify-content-center">
				  <ul class="nav nav-tabs tab mr-auto mt-2 mt-lg-0">
					<li class="nav-item active" >
					  <a class="nav-link text-success" data-toggle="tab" href="#profile">Profile <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
					  <a class="nav-link text-success" data-toggle="tab" href="#settings">Settings</a>
					</li>
				   </ul>
			  </nav>
			  
			  
			 <div class="tab-content py-3 mb-5">
			  <!-- Profile Section -->
			  <div class="container-fluid tab-pane active" id="profile">
				<div class="container-fluid">
					<div class="container">
					  <div class="row">
						<div class="col-md-9 col-lg-8 mx-auto pt-3">
						  <form method="POST">
							<div class="form-label-group mt-3">
							  <label for="fname">First Name</label>
							  <input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" 
							  value="<?php echo $user[0]['FirstName'];?>" required>
							</div>
							
				            <div class="form-label-group mt-3">
							  <label for="lname">Last Name</label>
							  <input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name" 
							  value="<?php echo $user[0]['LastName'];?>" required>
							</div>

							<div class="form-label-group mt-3">
							  <label for="email">Email Address</label>
							  <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" 
							  value="<?php echo $user[0]['Email'];?>"required>
							</div>							
							<button class="btn btn-orange round font-weight-bold my-3" type="submit" name="submit1" value="submit" class="button">Update</button>
						  </form>
						</div>
					  </div>
					</div>
			    </div>
			  </div>
			  
	          <!-- Settings Section -->
			  <div class="container-fluid tab-pane fade" id="settings">
				<div class="container-fluid">
					<div class="container">
					  <div class="row">
						<div class="col-md-9 col-lg-8 mx-auto pt-3">
						  <form action="account.php" method="POST">
							<div class="form-label-group mt-3">
							  <label for="uname">Username</label>
							  <input type="text" id="uname" name="uname" class="form-control" placeholder="Username" 
							  value="<?php echo $username;?>" required>
							</div>
							<div class="form-label-group mt-3">
							  <label for="pass">Password</label>
							  <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" 
							  value="<?php echo $password;?>" required>
							</div>
							<div class="form-check custom-checkbox my-3">
							  <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="Function();">
							  <label class="custom-control-label" for="customCheck1">Show password</label>
							</div>							
							<button class="btn btn-orange round font-weight-bold my-3" type="submit" name="submit2" value="submit" title="submit" class="button">Update</button>
						  </form>
						</div>
					  </div>
					</div>
			    </div>
			  </div>	 
			 </div>
			</div>
			<!-- /#page-content-wrapper -->

		</div>
		</div>
		<!-- /#wrapper -->
  
	  <!-- Menu Toggle Script -->
    <script>
		$("#menu-toggle").click(function(e) {
		  e.preventDefault();
		  $("#wrapper").toggleClass("toggled");
		});
    </script>
	
	<script>
	function Function() {
	  var x = document.getElementById("pass");
	  if (x.type === "password") {
		x.type = "text";
	  } else {
		x.type = "password";
	  }
	} 
	</script>
	
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