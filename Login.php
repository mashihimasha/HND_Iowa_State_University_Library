<?php
session_start();
include("db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/newLogin.css">
</head>
<body>
<content>
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
			  <a class="nav-link" href="index.html#about">About
			  </a>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a" href="index.html#contact">Contact</a>
			</li>
			<li class="nav-item dropdwn">
			  <a class="nav-link dropbtn a"href="login.php">Login</a>
			</li>
		  </ul>
		</div>
	  </div>
	</nav>
	<!--Page Content-->
	<div class="container-fluid">
	  <div class="row no-gutter">
		<div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
		<div class="col-md-8 col-lg-6">
		  <div class="login d-flex align-items-center py-5">
			<div class="container">
			  <div class="row">
				<div class="col-md-9 col-lg-8 mx-auto">
				  <h3 class="login-heading mb-4">Welcome back!</h3>
				  <form action="Login.php" method="POST">
					<div class="form-label-group">
					  <input type="text" id="uname" name="uname" class="form-control" placeholder="Username" required>
					  <label for="uname">Username</label>
					</div>

					<div class="form-label-group">
					  <input type="password" id="pass" name="pass" class="form-control" placeholder="Password" required>
					  <label for="pass">Password</label>
					</div>

					<div class="custom-control custom-checkbox mb-3">
					  <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="myFunction();">
					  <label class="custom-control-label" for="customCheck1">Show password</label>
					</div>
					
					<button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" 
					type="submit" name="submit" value="Login" title="Login" class="button">Sign in</button>
					<div class="text-center">
					  <a class="small" href="#">Forgot password?</a></div>
				  </form>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	</div>
	<script>
	function myFunction() {
	  var x = document.getElementById("pass");
	  if (x.type === "password") {
		x.type = "text";
	  } else {
		x.type = "password";
	  }
	} 
	</script>

	<!-- Site footer -->
	<footer class="py-4 bg-dark text-white-50">
		<div class="container text-center">
		  <small>Copyright &copy; Lowa State University|Library</small>
		</div>
	</footer>

 </body>
</html>
<?php

//User authentication
if(isset($_POST['submit']))
{
	$username=$_POST['uname'];
	$password=$_POST['pass'];
	$sql="SELECT*FROM login WHERE UserName='$username' and Password='$password'";//select query
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	$count=mysqli_num_rows($result);
	if($count==1)
	{
		//access control
		$_SESSION['id']=$username;
		if($row['Role']=="Administrator")
		{
			header("location:Admin.php");//direct to admin page
		}
		else if($row['Role']=="Student")
		{
			header("location:newUser.php");//direct to user page
		}
		else if($row['Role']=="Professor")
		{
			header("location:newUser.php");//direct to user page
		}
	}
	else
	{
		echo "<script type='text/javascript'>
		alert('Incorrect username or password!')</script>";//error message
	}
}
?> 