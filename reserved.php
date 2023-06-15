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
	<header class="pt-3 mt-3">
		<div class="header-image" style="background-image: url('assets/img/book1.jpg')">
			<div>
			  <h1 class="heading display-4 pt-3 mt-3 text-center">Reserved Books</h1>
			</div>
		</div>
	</header>
	<!--Page Content-->
	<div class="container mt-3 pt-3">
	  <div class="row">

		<?php

			if(isset($_GET['pageno'])){
				$pageno=$_GET['pageno'];
			}
			else{
				$pageno=1;
			}

		$no_of_records_per_page=5;
		$offset = ($pageno-1)*$no_of_records_per_page;
		
		require_once("dbcon\db.php");

		//fetch memberID using login table
		$username=$_SESSION['id'];
		$pdo_statement = $pdo_conn->prepare("SELECT * FROM login WHERE Username='$username'");
		$pdo_statement->execute();
		$res = $pdo_statement->fetchAll();
		$mid=$res[0]['MemberID'];	

		$pdo_stat = $pdo_conn->prepare("SELECT * FROM reserve_details WHERE MemberID='$mid'");
		$pdo_stat->execute();
		$res1 = $pdo_stat->fetchAll();
		$bid=$res1[0]['BookID'];						
	
		$conn=mysqli_connect("localhost","root","","lowastatelibrary");
		
		if(mysqli_connect_errno())
		{
			echo"Failed to connect to Mysql:".mysqli_connect_error();
			die();
		}
		
		$total_pages_sql="select count(*) From reserve_details,book_details WHERE reserve_details.memberID='$mid' AND reserve_details.BookID = book_details.BookID";
		$result = mysqli_query($conn,$total_pages_sql);
		$total_rows=mysqli_fetch_array($result)[0];
		$total_pages=ceil($total_rows/$no_of_records_per_page);

		$sql="select * from reserve_details,book_details WHERE reserve_details.memberID='$mid' AND reserve_details.BookID = book_details.BookID LIMIT $offset,$no_of_records_per_page";
		$res_data=mysqli_query($conn,$sql);
		
		?>

			<div id="reserved" class="table-responsive" style="margin-left:15%;margin-right:15%;">
				<div style="text-align:right;">
					<div style="display:inline-block">
						<ul class="pagination">
							<li class="btn btn-orange">
								<a href="?pageno=1">First</a>
							</li>
							<li class="btn btn-orange" class="<?php if($pageno<=1){echo'disbaled';}?>">
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
								Prev</a>
							</li>
							<li class="btn btn-orange" class="<?php if($pageno>=$total_pages){echo'disabled';}?>">
								<a href="<?php
									if($pageno>=$total_pages)
									{
										echo'#';
									}
								else
								{
									echo"?pageno=".($pageno+1);
								}?>">
								Next</a>
							</li>
							<li class="btn btn-orange">
								<a href="?pageno=<?php echo $total_pages;?>">Last</a>
							</li>
						</ul>
					</div>
				</div>
			  <table class="table table-hover">
				<thead class="table-warning">
					<tr>
						<td scope="col">ID</td>
						<td scope="col">Cover</td>
						<td scope="col">Title</td>
						<td scope="col">Author</td>
						<td scope="col">Reserved Date</td>
					</tr>
				</thead>

				<?php
				while($row=mysqli_fetch_array($res_data)):
				?>

					<tr>
						<td><?php echo $row['BookID']; ?></td>
						<td><?php echo '<img class="img" src="'.$row['Img_link'].'">';?></td>
						<td><?php echo $row['Title']; ?></td>
						<td><?php echo $row['Author']; ?></td>
						<td><?php echo $row['Date']; 
							$ans = date("Y-m-d");
							$d1 = new DateTime($row['Date']);
							$d1->add(new DateInterval('P1D'));

							if($d1->format('Y-m-d')<$ans){
								echo '<p class="danger">Reservation Expired !</p>';
							}
							else if($d1->format('Y-m-d')>$ans){

								echo ('<p class="success">Reserved</p>'); 
							}?>
						</td>
					</tr>
				<?php endwhile;?>
			  </table>
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