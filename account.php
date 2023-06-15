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
	<link rel="stylesheet" type="text/css" href="css/user.css">

 </head>
 <body class="account">
 <div class="content">
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
					<a href="bookCategories.php">Science & Maths</a>
					<a href="bookCategories.php#medical">Medical</a>
					<a href="bookCategories.php#artMusic">Art & Music</a>
					<a href="bookCategories.php#history">History</a>
					<a href="bookCategories.php#biograph">Biographies</a>
					<a href="bookCategories.php#scifiFa">Sci-Fi & Fantasy</a>
				</div>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="about.php">About</a>
			</li>
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
		<header>
			<div class="header-image" style="background-image: url('assets/img/book3.jpg')">
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
					<li class="nav-item">
					  <a class="nav-link text-success" data-toggle="tab" href="#payments">Payments</a>
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
							<?php if (!empty($_POST["submit1"])):?>
							<div class="message-box text-right my-2">
								<strong class="d-block text-center small text-success">Successfully Updated!</strong>
							</div>
							<?php endif ?>
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
							<div class="form-label-control custom-checkbox mb-3">
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
			  
			  <!-- Payments Section -->
			  
			  <?php	
					$username= $_SESSION['id'];
					$stat = $pdo_conn->prepare("SELECT * FROM login WHERE Username='$username'");
					$stat->execute();
					$login = $stat->fetchAll();
					
					$memID=$login[0]['MemberID'];
					$pdo_statement = $pdo_conn->prepare("SELECT * FROM payment_details WHERE MemberID='$memID' ORDER BY PaymentID DESC");
					$pdo_statement->execute();
					$result = $pdo_statement->fetchAll();
			   ?>

			  <div class="container-fluid tab-pane fade" id="payments">
				<div class="container pb-5 mb-5">
				
				<!--table controls-->
				<div class="container">
					<div class="row">
						<nav class="navbar navbar-expand-lg navbar-light">
							<div class="container">
							  <button class="navbar-toggler navbar-light text-success" type="button" data-toggle="collapse" data-target="#controlResponsive" aria-controls="controlResponsive" aria-expanded="false" aria-label="Toggle navigation">
								<i class="fa fa-angle-right"></i>
							  </button>
							<div class="collapse navbar-collapse" id="controlResponsive">
							<ul class="navbar-nav ml-auto">
								<li class="nav-item p-2">
									<div class="dropdown dropright">
										<button type="button" class="btn btn-orange round dropdown-toggle" data-toggle="dropdown">
										<i class="fas fa-sort"></i>  Sort by
										</button>
										  <div class="dropdown-menu">
												<a class="dropdown-item" href="#" onclick="sortTable(0)"> <i class="fas fa-sort-numeric-up"></i>  Payment ID</a>
												<a class="dropdown-item" href="#" onclick="sortTable(4)"><i class="fas fa-sort-numeric-up"></i>  Member ID</a>
												<a class="dropdown-item" href="#" onclick="sortTable2(3)"><i class="fas fa-calendar-check"></i>  Date</a>
										  </div>
									</div>
								</li>
						  </ul>
						  <form autocomplete="off" class="form-inline my-2 p-2 my-lg-0" role="search" name="search">
								<input class="form-control form-control-sm mr-sm-2" name="search" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by ID">
						  </form>
						  </div>
						  </div>
					  </nav>
					</div>
				</div>
				
				<!--Payments Table-->
				 <div class="row">
				   <div class="table-responsive">	
					<table class="table table-hover" id="myTable">
					  <thead class="table-warning">
						<tr>
						  <th>Payment ID</th>
						  <th>Payment Type</th>
						  <th>Amount</th>
						  <th>Date</th>
						  <th>Member ID</th>
						</tr>
					  </thead>
					  <tbody id="table-body">
						<?php
						if(!empty($result)) { 
							foreach($result as $row) {
						?>
						  <tr class="tbl-row">
							<td><?php echo $row["PaymentID"]; ?></td>
							<td><?php echo $row["pType"]; ?></td>
							<td><?php echo $row["Amount"]; ?></td>
							<td><?php echo $row["Date"]; ?></td>
							<td><?php echo $row["MemberID"]; ?></td>
						  </tr>
						<?php
							}
						}
						?>
					  </tbody>
					</table>
				   </div>
				  </div>
				</div>
			  </div>
			  </div>
			  
			</div>
			<!-- /#page-content-wrapper -->

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
	
	var i;

	for (i = 0; i < close.length; i++) {
		close[i].onclick = function(){
			var div = this.parentElement;
			div.style.opacity = "0";
			setTimeout(function(){ div.style.display = "none"; }, 600);
		}
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