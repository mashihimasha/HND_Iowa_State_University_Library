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
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="position:relative;top:-35px;padding-top:35px;">
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
	<header class="pb-3 mb-3">
		<div class="container input-group">
			<form class="form-inline form-control-lg my-2 my-lg-0" action="search.php" method="GET">
				<input class="form-control input-lg mr-sm-2" style="width:300px;" type="text" name="k" 
				value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" 
				placeholder="Search Books" aria-label="Search">
				<button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</header>
	
	<?php
	// get the search terms from the url
	$k = isset($_GET['k']) ? $_GET['k'] : '';
	 
	// create the base variables for building the search query
	$search_string = "SELECT * FROM book_details WHERE ";
	$display_words = "";
						
	// format each of search keywords into the db query to be run
	$keywords = explode(' ', $k);            
	foreach ($keywords as $word){
		$search_string .= "Category LIKE '%".$word."%' OR ";
		$display_words .= $word.' ';
	}
	$search_string = substr($search_string, 0, strlen($search_string)-4);
	$display_words = substr($display_words, 0, strlen($display_words)-1);
	
	// connect to the database
	$conn=mysqli_connect("localhost","root","","lowastatelibrary");
	 
	//check connection
		if(mysqli_connect_errno())
		{
			echo"Failed to connect to Mysql:".mysqli_connect_error();//response for connection errors
			die();
		}
	// run the query in the db and search through each of the records returned
	$query = mysqli_query($conn, $search_string);
	$result_count = mysqli_num_rows($query);
	
	// display a message to the user to display the keywords
	echo '<div class="container" >
			<p class="lead">Your search results for <i>"'.$display_words.'"</i> - <small><b><u>'.number_format($result_count).'</u></b> 
			results found</small></p>
			<hr class="mb-3 pb-3">
		  </div>';
	
	// check if the search query returned any results
	if ($result_count > 0){
 
    // display the header for the display table
    echo '<div class="container mb-3 pb-3 books justify-content-center" >
	<div class="row">
	<table class="search table table-light table-hover" style="width:800px;">';
    
    // loop though each of the results from the database and display them to the user
    while ($row = mysqli_fetch_assoc($query)){
        echo 
		'<tr>
            <td>
				<form>
					<div class="col-lg-4 pt-3 book-card">
						<div class="card h-100" style="width:200px;">
							<a href="#"><img class="card-img-top" style="height:250px;" src="'.$row['Img_link'].'"></a>
							<div class="card-body" style="height:150px;">
								<h5 class="card-title"><a href="'.$row['Title'].'">'.$row['Title'].'</a></h5>
								<p class="card-title">'.$row['Author'].'</p>
							</div>
						</div>
					</div>
				</form>
			</td>
			<td>
				<h5 class="card-title"><a href="'.$row['Title'].'">'.$row['Title'].'</a></h5>
				<p class="card-title">'.$row['Author'].'</p>
				<hr>
				<p class="card-title pt-3 mt-3">'.$row['Description'].'</p>
			</td>
			<td>
				 <a class="btn btn-block btn-primary" 
					  ';
						$bStat=$row['BookStatus'];
						if (in_array($bStat, array("Borrowed", "Reserved")))
						{
						  echo 'data-toggle="modal" data-target="#myModal" href="#"';
						}
						elseif($bStat=="Available")
						{
							echo 'target="_parent" href="resAdd.php?bid='.$row['BookID'].'"'; 
						} 
						echo '> Reserve</a>
		   </td>
        </tr>';
    }
    
    // end the display of the table
    echo '</table></div></div>';
	}
	else
		echo '<div class="container text-center mt-3 mt-3"><p class="text-muted">There were no results for your search. Try searching for something else.<p></div>';

	?>
	</div>
	
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
	<footer id="sticky-footer" class="py-4 bg-dark text-white-50" style="margin-bottom:-15px;">
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