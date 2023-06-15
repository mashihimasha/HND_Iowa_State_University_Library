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
			  <a class="nav-link dropbtn a" href="bookCategories.php">Book Categories</a>
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
			  <a class="nav-link" href="#z">About</a>
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
	
	<!--Science & Maths Section-->
	<section id="scieMath">
	<div class="container justify-content-center" style="display:flex;">
	  <div class="row">
		<section class="books py-5">
		  <?php
			if(isset($_GET['pageno'])){
				$pageno=$_GET['pageno'];
			}
			else{
				$pageno=1;
			}

			$no_of_records_per_page=6;
			$offset = ($pageno-1)*$no_of_records_per_page;

			$conn=mysqli_connect("localhost","root","","lowastatelibrary");

			if(mysqli_connect_errno())
			{
				echo"Failed to connect to Mysql:".mysqli_connect_error();
				die();
			}

			$total_pages_sql="select count(*) From Book_Details WHERE Category='Science & Maths'";
			$result = mysqli_query($conn,$total_pages_sql);
			$total_rows=mysqli_fetch_array($result)[0];
			$total_pages=ceil($total_rows/$no_of_records_per_page);

			$sql="select * from Book_Details WHERE Category='Science & Maths' LIMIT $offset,$no_of_records_per_page";
			$res_data=mysqli_query($conn,$sql);

		  ?>	
		   <div class="container justify-content-center">
		    <!-- Section Heading -->
			<h1 class="my-3 text-center">Science & Maths</h1>
			 <hr class="divider my-4" />
			  <div class="row">
				<?php
					while($row=mysqli_fetch_array($res_data)):
				?>
				<form>
				<div class="col-lg-4 pt-3 book-card">
				   <div class="card h-100" style="width:200px;">
					<a href="#"><img class="card-img-top" style="height:250px;" src="<?php echo $row['Img_link'];?>" alt=""></a>
					<div class="card-body" style="height:200px;">
					  <h4 class="card-title">
						<a href="#"><?php echo $row['Title'];?></a>
					  </h4>
					  <p class="card-title"><?php echo $row['Author'];?></p>
					  <a class="btn btn-block btn-primary" 
					  <?php 
						$bStat=$row['BookStatus'];
						if (in_array($bStat, array("Borrowed", "Reserved")))
						{
						  echo 'data-toggle="modal" data-target="#myModal" href="#"';
						}
						elseif($bStat=="Available")
						{ 
					  
					  ?>	
						href="resAdd.php?bid=<?php echo $row['BookID'];} ?>">Reserve</a>
					</div>
				   </div>
				</div>
				</form>
		       <?php endwhile;?>
			  </div>
		   </div>
		  </section>
	  </div>
	</div>
	<br>
	<div style="text-align:right;">
		<div style="display:flex" class="justify-content-center">
			<ul class="pagination">
				<li class="btn btn-orange round"><a href="?pageno=1"><i class="fas fa-angle-double-left"></i>First</a></li>
				<li class="btn btn-orange round" class="<?php
				if($pageno<=1){echo'disbaled';}?>">
					<a href="<?php
						if($pageno<=1)
						{
						  echo'#';
						}
						else
						{
						   echo"?pageno=".($pageno-1);
						}
						?>">
						<i class="fas fa-angle-left"></i>Prev</a>
				</li>
				<li class="btn btn-orange round"
				class="<?php
				if($pageno>=$total_pages)
				{
				echo'disabled';}?>">
					<a href="<?php
					if($pageno>=$total_pages)
					{
						echo'#';
					}
					else
					{
						echo"?pageno=".($pageno+1);
					}?>">
					Next<i class="fas fa-angle-right"></i>
					</a>
				</li>
				<li class="btn btn-orange round">
					<a href="?pageno=<?php echo $total_pages;?>">
					Last<i class="fas fa-angle-double-right"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	</section>
	
	<!--Medical Section-->
	<section id="medical">
	<div class="container justify-content-center" style="display:flex;">
	  <div class="row">
		<section class="books py-5">
		  <?php
			if(isset($_GET['pageno'])){
				$pageno=$_GET['pageno'];
			}
			else{
				$pageno=1;
			}

			$no_of_records_per_page=4;
			$offset = ($pageno-1)*$no_of_records_per_page;

			$conn=mysqli_connect("localhost","root","","lowastatelibrary");

			if(mysqli_connect_errno())
			{
				echo"Failed to connect to Mysql:".mysqli_connect_error();
				die();
			}

			$total_pages_sql="select count(*) From Book_Details WHERE Category='Medical'";
			$result = mysqli_query($conn,$total_pages_sql);
			$total_rows=mysqli_fetch_array($result)[0];
			$total_pages=ceil($total_rows/$no_of_records_per_page);

			$sql="select * from Book_Details WHERE Category='Medical' LIMIT $offset,$no_of_records_per_page";
			$res_data=mysqli_query($conn,$sql);

		  ?>	
		   <div class="container justify-content-center">

		    <!-- Section Heading -->
			<h1 class="my-3 text-center">Medical</h1>
			 <hr class="divider my-4" />
			  <div class="row">
				<?php
					while($row=mysqli_fetch_array($res_data)):
				?>
				<form>
				<div class="col-lg-4 pt-3 book-card">
				   <div class="card h-100" style="width:200px;">
					<a href="#"><img class="card-img-top" style="height:250px;" src="<?php echo $row['Img_link'];?>" alt=""></a>
					<div class="card-body" style="height:200px;">
					  <h4 class="card-title">
						<a href="#"><?php echo $row['Title'];?></a>
					  </h4>
					  <p class="card-title"><?php echo $row['Author'];?></p>
					  <a class="btn btn-block btn-primary"
					  <?php 
						$bStat=$row['BookStatus'];
						if (in_array($bStat, array("Borrowed", "Reserved")))
						{
						  echo 'data-toggle="modal" data-target="#myModal" href="#"';
						}
						elseif($bStat=="Available")
						{ 
					  
					  ?>	
					  href="resAdd.php?bid=<?php echo $row['BookID'];} ?>">Reserve</a>
					</div>
				   </div>
				</div>
				</form>
		       <?php endwhile;?>
			  </div>
		   </div>
		  </section>
	  </div>
	</div>
	<br>
	<div style="text-align:right;">
		<div style="display:flex" class="justify-content-center">
			<ul class="pagination">
				<li class="btn btn-orange round"><a href="?pageno=1"><i class="fas fa-angle-double-left"></i>First</a></li>
				<li class="btn btn-orange round" class="<?php
				if($pageno<=1){echo'disbaled';}?>">
					<a href="<?php
						if($pageno<=1)
						{
						  echo'#';
						}
						else
						{
						   echo"?pageno=".($pageno-1);
						}
						?>">
						<i class="fas fa-angle-left"></i>Prev</a>
				</li>
				<li class="btn btn-orange round"
				class="<?php
				if($pageno>=$total_pages)
				{
				echo'disabled';}?>">
					<a href="<?php
					if($pageno>=$total_pages)
					{
						echo'#';
					}
					else
					{
						echo"?pageno=".($pageno+1);
					}?>">
					Next<i class="fas fa-angle-right"></i>
					</a>
				</li>
				<li class="btn btn-orange round">
					<a href="?pageno=<?php echo $total_pages;?>">
					Last<i class="fas fa-angle-double-right"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	</section>
	
	<!--Art & Music Section-->
	<section id="artMusic">
	<div class="container justify-content-center" style="display:flex;">
	  <div class="row">
		<section class="books py-5">
		  <?php
			if(isset($_GET['pagenoa'])){
				$pageno=$_GET['pagenoa'];
			}
			else{
				$pageno=1;
			}

			$no_of_records_per_page=4;
			$offset = ($pageno-1)*$no_of_records_per_page;

			$conn=mysqli_connect("localhost","root","","lowastatelibrary");

			if(mysqli_connect_errno())
			{
				echo"Failed to connect to Mysql:".mysqli_connect_error();
				die();
			}

			$total_pages_sql="select count(*) From Book_Details WHERE Category='Art & Music'";
			$result = mysqli_query($conn,$total_pages_sql);
			$total_rows=mysqli_fetch_array($result)[0];
			$total_pages=ceil($total_rows/$no_of_records_per_page);

			$sql="select * from Book_Details WHERE Category='Art & Music' LIMIT $offset,$no_of_records_per_page";
			$res_data=mysqli_query($conn,$sql);

		  ?>	
		   <div class="container">

		    <!-- Section Heading -->
			<h1 class="my-3 text-center">Art & Music</h1>
			 <hr class="divider my-2" />
			  <div class="row">
				<?php
					while($row=mysqli_fetch_array($res_data)):
				?>
				<form>
				<div class="col-lg-4 pt-3 book-card">
				   <div class="card h-100" style="width:200px;">
					<a href="#"><img class="card-img-top" style="height:250px;" src="<?php echo $row['Img_link'];?>" alt=""></a>
					<div class="card-body" style="height:200px;">
					  <h4 class="card-title">
						<a href="#"><?php echo $row['Title'];?></a>
					  </h4>
					  <p class="card-title"><?php echo $row['Author'];?></p>
					  <a type="submit" class="btn btn-block btn-primary" name="reserve" id="reserve" 
					  <?php 
						$bStat=$row['BookStatus'];
						if (in_array($bStat, array("Borrowed", "Reserved")))
						{
						  echo 'data-toggle="modal" data-target="#myModal" href="#"';
						}
						elseif($bStat=="Available")
						{ 
					  
					  ?>		  
					   href="resAdd.php?bid=<?php echo $row['BookID']; } ?>">
					  Reserve
					  </a>
					</div>
				   </div>
				</div>
				</form>
		       <?php endwhile;?>
			  </div>
		   </div>		   
		  </section>
	  </div>
	</div>
	<br>
	<div style="text-align:right;">
		<div style="display:flex" class="justify-content-center">
			<ul class="pagination">
				<li class="btn btn-orange round"><a href="?pagenoa=1"><i class="fas fa-angle-double-left"></i>First</a></li>
				<li class="btn btn-orange round" class="<?php
				if($pagenoa<=1){echo'disbaled';}?>">
					<a href="<?php
						if($pagenoa<=1)
						{
						  echo'#';
						}
						else
						{
						   echo"?pagenoa=".($pagenoa-1);
						}
						?>">
						<i class="fas fa-angle-left"></i>Prev</a>
				</li>
				<li class="btn btn-orange round"
				class="<?php
				if($pagenoa>=$total_pages)
				{
				echo'disabled';}?>">
					<a href="<?php
					if($pagenoa>=$total_pages)
					{
						echo'#';
					}
					else
					{
						echo"?pageno=".($pagenoa+1);
					}?>">
					Next<i class="fas fa-angle-right"></i>
					</a>
				</li>
				<li class="btn btn-orange round">
					<a href="#artMusic?pagenoa=<?php echo $total_pages;?>">
					Last<i class="fas fa-angle-double-right"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	</section>
	<!--History Section-->
	<section id="history">
	<div class="container justify-content-center" style="display:flex;">
	  <div class="row">
		<section class="books py-5">
		  <?php
			if(isset($_GET['pageno'])){
				$pageno=$_GET['pageno'];
			}
			else{
				$pageno=1;
			}

			$no_of_records_per_page=4;
			$offset = ($pageno-1)*$no_of_records_per_page;

			$conn=mysqli_connect("localhost","root","","lowastatelibrary");

			if(mysqli_connect_errno())
			{
				echo"Failed to connect to Mysql:".mysqli_connect_error();
				die();
			}

			$total_pages_sql="select count(*) From Book_Details WHERE Category='History'";
			$result = mysqli_query($conn,$total_pages_sql);
			$total_rows=mysqli_fetch_array($result)[0];
			$total_pages=ceil($total_rows/$no_of_records_per_page);

			$sql="select * from Book_Details WHERE Category='History' LIMIT $offset,$no_of_records_per_page";
			$res_data=mysqli_query($conn,$sql);

		  ?>	
		   <div class="container justify-content-center">

		    <!-- Section Heading -->
			<h1 class="my-3 text-center">History</h1>
			 <hr class="divider my-4" />
			  <div class="row">
				<?php
					while($row=mysqli_fetch_array($res_data)):
				?>
				<form>
				<div class="col-lg-4 pt-3 book-card">
				   <div class="card h-100" style="width:200px;">
					<a href="#"><img class="card-img-top" style="height:250px;" src="<?php echo $row['Img_link'];?>" alt=""></a>
					<div class="card-body" style="height:200px;">
					  <h4 class="card-title">
						<a href="#"><?php echo $row['Title'];?></a>
					  </h4>
					  <p class="card-title"><?php echo $row['Author'];?></p>
					  <a class="btn btn-block btn-primary" 
					  <?php 
						$bStat=$row['BookStatus'];
						if (in_array($bStat, array("Borrowed", "Reserved")))
						{
						  echo 'data-toggle="modal" data-target="#myModal" href="#"';
						}
						elseif($bStat=="Available")
						{ 
					  
					  ?>	
					  href="resAdd.php?bid=<?php echo $row['BookID'];} ?>">Reserve</a>
					</div>
				   </div>
				</div>
				</form>
		       <?php endwhile;?>
			  </div>
		   </div>
		  </section>
	  </div>
	</div>
	<br>
	<div style="text-align:right;">
		<div style="display:flex" class="justify-content-center">
			<ul class="pagination">
				<li class="btn btn-orange round"><a href="?pageno=1"><i class="fas fa-angle-double-left"></i>First</a></li>
				<li class="btn btn-orange round" class="<?php
				if($pageno<=1){echo'disbaled';}?>">
					<a href="<?php
						if($pageno<=1)
						{
						  echo'#';
						}
						else
						{
						   echo"?pageno=".($pageno-1);
						}
						?>">
						<i class="fas fa-angle-left"></i>Prev</a>
				</li>
				<li class="btn btn-orange round"
				class="<?php
				if($pageno>=$total_pages)
				{
				echo'disabled';}?>">
					<a href="<?php
					if($pageno>=$total_pages)
					{
						echo'#';
					}
					else
					{
						echo"?pageno=".($pageno+1);
					}?>">
					Next<i class="fas fa-angle-right"></i>
					</a>
				</li>
				<li class="btn btn-orange round">
					<a href="?pageno=<?php echo $total_pages;?>">
					Last<i class="fas fa-angle-double-right"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	</section>
	
	<!--Biographies Section-->
	<section id="biograph">
	<div class="container justify-content-center" style="display:flex;">
	  <div class="row">
		<section class="books py-5">
		  <?php
			if(isset($_GET['pageno'])){
				$pageno=$_GET['pageno'];
			}
			else{
				$pageno=1;
			}

			$no_of_records_per_page=4;
			$offset = ($pageno-1)*$no_of_records_per_page;

			$conn=mysqli_connect("localhost","root","","lowastatelibrary");

			if(mysqli_connect_errno())
			{
				echo"Failed to connect to Mysql:".mysqli_connect_error();
				die();
			}

			$total_pages_sql="select count(*) From Book_Details WHERE Category='Biographies'";
			$result = mysqli_query($conn,$total_pages_sql);
			$total_rows=mysqli_fetch_array($result)[0];
			$total_pages=ceil($total_rows/$no_of_records_per_page);

			$sql="select * from Book_Details WHERE Category='Biographies' LIMIT $offset,$no_of_records_per_page";
			$res_data=mysqli_query($conn,$sql);

		  ?>	
		   <div class="container justify-content-center">

		    <!-- Section Heading -->
			<h1 class="my-3 text-center">Biographies</h1>
			 <hr class="divider my-4" />
			  <div class="row">
				<?php
					while($row=mysqli_fetch_array($res_data)):
				?>
				<form>
				<div class="col-lg-4 pt-3 book-card">
				   <div class="card h-100" style="width:200px;">
					<a href="#"><img class="card-img-top" style="height:250px;" src="<?php echo $row['Img_link'];?>" alt=""></a>
					<div class="card-body" style="height:200px;">
					  <h4 class="card-title">
						<a href="#"><?php echo $row['Title'];?></a>
					  </h4>
					  <p class="card-title"><?php echo $row['Author'];?></p>
					  <a class="btn btn-block btn-primary" 
					  
					  <?php 
						$bStat=$row['BookStatus'];
						if (in_array($bStat, array("Borrowed", "Reserved")))
						{
						  echo 'data-toggle="modal" data-target="#myModal" href="#"';
						}
						elseif($bStat=="Available")
						{ 
					  
					  ?>	
						href="resAdd.php?bid=<?php echo $row['BookID'];} ?>">Reserve</a>
					</div>
				   </div>
				</div>
				</form>
		       <?php endwhile;?>
			  </div>
		   </div>
		  </section>
	  </div>
	</div>
	<br>
	<div style="text-align:right;">
		<div style="display:flex" class="justify-content-center">
			<ul class="pagination">
				<li class="btn btn-orange round"><a href="?pageno=1"><i class="fas fa-angle-double-left"></i>First</a></li>
				<li class="btn btn-orange round" class="<?php
				if($pageno<=1){echo'disbaled';}?>">
					<a href="<?php
						if($pageno<=1)
						{
						  echo'#';
						}
						else
						{
						   echo"?pageno=".($pageno-1);
						}
						?>">
						<i class="fas fa-angle-left"></i>Prev</a>
				</li>
				<li class="btn btn-orange round"
				class="<?php
				if($pageno>=$total_pages)
				{
				echo'disabled';}?>">
					<a href="<?php
					if($pageno>=$total_pages)
					{
						echo'#';
					}
					else
					{
						echo"?pageno=".($pageno+1);
					}?>">
					Next<i class="fas fa-angle-right"></i>
					</a>
				</li>
				<li class="btn btn-orange round">
					<a href="?pageno=<?php echo $total_pages;?>">
					Last<i class="fas fa-angle-double-right"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	</section>
	<!--Sci-Fi & Fantasy Section-->
	<section id="scifiFa" class="mb-3 pb-3">
	<div class="container justify-content-center" style="display:flex;">
	  <div class="row">
		<section class="books py-5">
		  <?php
			if(isset($_GET['pageno'])){
				$pageno=$_GET['pageno'];
			}
			else{
				$pageno=1;
			}

			$no_of_records_per_page=4;
			$offset = ($pageno-1)*$no_of_records_per_page;

			$conn=mysqli_connect("localhost","root","","lowastatelibrary");

			if(mysqli_connect_errno())
			{
				echo"Failed to connect to Mysql:".mysqli_connect_error();
				die();
			}

			$total_pages_sql="select count(*) From Book_Details WHERE Category='Sci-Fi & Fantasy'";
			$result = mysqli_query($conn,$total_pages_sql);
			$total_rows=mysqli_fetch_array($result)[0];
			$total_pages=ceil($total_rows/$no_of_records_per_page);

			$sql="select * from Book_Details WHERE Category='Sci-Fi & Fantasy' LIMIT $offset,$no_of_records_per_page";
			$res_data=mysqli_query($conn,$sql);

		  ?>	
		   <div class="container justify-content-center">

		    <!-- Section Heading -->
			<h1 class="my-3 text-center">Science Fictions & Fantasy</h1>
			 <hr class="divider my-4" />
			  <div class="row">
				<?php
					while($row=mysqli_fetch_array($res_data)):
				?>
				<form>
				<div class="col-lg-4 pt-3 book-card">
				   <div class="card h-100" style="width:200px;">
					<a href="#"><img class="card-img-top" style="height:250px;" src="<?php echo $row['Img_link'];?>" alt=""></a>
					<div class="card-body" style="height:200px;">
					  <h4 class="card-title">
						<a href="#"><?php echo $row['Title'];?></a>
					  </h4>
					  <p class="card-title"><?php echo $row['Author'];?></p>
					  <a class="btn btn-block btn-primary" 
					  
					  <?php 
						$bStat=$row['BookStatus'];
						if (in_array($bStat, array("Borrowed", "Reserved")))
						{
						  echo 'data-toggle="modal" data-target="#myModal" href="#"';
						}
						elseif($bStat=="Available")
						{ 
					  
					  ?>						  
						href="resAdd.php?bid=<?php echo $row['BookID'];} ?>">Reserve</a>
					</div>
				   </div>
				</div>
				</form>
		       <?php endwhile;?>
			  </div>
		   </div>
		  </section>
	  </div>
	</div>
	<br>
	<div style="text-align:right;">
		<div style="display:flex" class="justify-content-center">
			<ul class="pagination">
				<li class="btn btn-orange round"><a href="?pageno=1"><i class="fas fa-angle-double-left"></i>First</a></li>
				<li class="btn btn-orange round" class="<?php
				if($pageno<=1){echo'disbaled';}?>">
					<a href="<?php
						if($pageno<=1)
						{
						  echo'#';
						}
						else
						{
						   echo"?pageno=".($pageno-1);
						}
						?>">
						<i class="fas fa-angle-left"></i>Prev</a>
				</li>
				<li class="btn btn-orange round"
				class="<?php
				if($pageno>=$total_pages)
				{
				echo'disabled';}?>">
					<a href="<?php
					if($pageno>=$total_pages)
					{
						echo'#';
					}
					else
					{
						echo"?pageno=".($pageno+1);
					}?>">
					Next<i class="fas fa-angle-right"></i>
					</a>
				</li>
				<li class="btn btn-orange round">
					<a href="?pageno=<?php echo $total_pages;?>">
					Last<i class="fas fa-angle-double-right"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	</section>
	
	
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