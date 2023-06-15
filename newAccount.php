<?php include('insert.php') ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Create new account</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/all.css">
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/validation.js"></script>
	<link rel="stylesheet" type="text/css" href="css/newAccount.css">

<style>
p{
font-family:Calibri;
font-size:12px;
color:white;
text-align:left;
}

.standard{
	width:500px;
	height:auto;
}

.closebtn {
  margin-left: 15px;
  color: gray;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}

.form_error div {
  padding: 20px;
  background-color: #f44336;
  color: white;
  opacity: 1;
  transition: opacity 0.6s;
  margin-bottom: 15px;
}

.form_error input {
  border: 1px solid #D83D5A;
}
</style>

</head>
<body>
<div class="content">

<script>
	$(document).ready(function(){
		$('.alert').hide();
	});

	function msgAlert(msg){
		$('.alert').show();
		document.getElementById("alert").innerHTML = msg;
	}
</script>
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
		
  <div class="container mt-3 pt-3">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
             <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body">
            <h5 class="card-title text-center">Create New Account</h5>
            <form class="form-signin" name="registration" action="newAccount.php" method="post" onSubmit="return formValidation();">
              <div class="form-label-group">
                <select id="account" name="account" required class="form-control browser-default custom-select" autofocus>
					<option value="" disabled selected>Choose your option</option>
					<option value="Administrator">Administrator</option>
					<option value="Professor">Professor</option>
					<option value="Student">Student</option>
				</select>
              </div>
			  <div class="form-label-group">
                <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required autofocus>
                <label for="fname">First Name</label>
              </div>
			  <div class="form-label-group">
                <input type="text" name="lname" id="lname"class="form-control" placeholder="Last Name" required autofocus>
                <label for="lname">Last Name</label>
              </div>
              <div class="form-label-group" <?php if (isset($email_error)): ?> class="form_error" <?php endif ?>>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required>
                <label for="email">Email address</label>
				<?php if (isset($email_error)): ?>
				<div>
					<span class="closebtn">&times;</span>  
					<strong class="d-block text-center mt-2 small"><?php echo $email_error; ?></strong>
				</div>
				<?php endif ?>
              </div>
              
              <hr>

              <div class="form-label-group" <?php if (isset($name_error)): ?> class="form_error" <?php endif ?> >
                <input type="text" id="uname" name="uname" class="form-control" placeholder="Username" required>
                <label for="uname">Username</label>
				<?php if (isset($name_error)): ?>
				<div>
					<span class="closebtn">&times;</span>  
					<strong class="d-block text-center mt-2 small"><?php echo $name_error; ?></strong>
				</div>
				<?php endif ?>
              </div>
			  
              <div class="form-label-group">
                <input type="password" id="pass" name="pass" class="form-control" placeholder="" required>
                <label for="pass">Password</label>
              </div>
				
			  <div class="alert">
				<span class="closebtn">&times;</span>  
				<strong id="alert" class="d-block text-center mt-2 small"></strong>
			  </div>
			  
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="submit" value="Create Account">Create Account</button>
              <a class="d-block text-center mt-2 small" href="login.php">Sign In</a>
              <hr class="my-4">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  
  <script>
	var close = document.getElementsByClassName("closebtn");
	var i;

	for (i = 0; i < close.length; i++) {
		close[i].onclick = function(){
			var div = this.parentElement;
			div.style.opacity = "0";
			setTimeout(function(){ div.style.display = "none"; }, 600);
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