<?php
session_start();
if(isset($_SESSION['id']))
{
?>
<?php
//Database connection
require_once("dbcon\db.php");

//Insert data into the borrow_details table
if(!empty($_POST["save"])) {
	require_once("db.php");
	$sql = "INSERT INTO `borrow_details`(`BorrowID`, `BorrowDate`, `ReturnDate`, `BookID`, `MemberID`) 
	VALUES ( :id, :bDate, :rDate, :bid, :mid )"; //Insert data query
	$pdo_statement = $pdo_conn->prepare( $sql );
		
	$result = $pdo_statement->execute( array( ':id'=>$_POST['id'],
	'bDate'=>$_POST['bDate'], ':rDate'=>$_POST['rDate'],
	':bid'=>$_POST['bid'], ':mid'=>$_POST['mid'] ) );
	if (!empty($result) ){
	  header('location:view.php');//Redirect to the relevant page
	}
}

//Insert data into the borrow_details table 
if(!empty($_POST["save6"])) {
	require_once("db.php");
	$sql = "INSERT INTO `borrow_details`(`BorrowID`, `BorrowDate`, `ReturnDate`, `BookID`, `MemberID`)
	VALUES ( :id, :bDate, :rDate, :bid, :mid )";
	$pdo_statement = $pdo_conn->prepare( $sql );
		
	$result = $pdo_statement->execute( array( ':id'=>$_POST['id'],
	'bDate'=>$_POST['bDate'], ':rDate'=>$_POST['rDate'],
	':bid'=>$_POST['bid'], ':mid'=>$_POST['mid'] ) );
	if (!empty($result) ){
	  header('location:view.php');//Redirect to the relevant page
	}
}

//Insert data into the return_details table
if(!empty($_POST["save1"])) {
	require_once("db.php");
	$sql = "INSERT INTO `return_details`(`ReturnID`, `ReturnDate`, `ReturnStatus`, `BookID`, `MemberID`)
	VALUES ( :id, :rDate, :rStat, :bid, :mid )";
	$pdo_statement = $pdo_conn->prepare( $sql );
		
	$result = $pdo_statement->execute( array( ':id'=>$_POST['id'],
	'rDate'=>$_POST['rDate'], ':rStat'=>$_POST['rStat'],
	':bid'=>$_POST['bid'], ':mid'=>$_POST['mid'] ) );
	
	if(!empty($result)){
		
		//update BookStatus and Date of the book_details table
		$pdo_statement=$pdo_conn->prepare("update book_details set 
		BookStatus='Available',
		Date='" . $_POST[ 'rDate' ]. "' where BookID=" . $_POST["bid"]);
		$result = $pdo_statement->execute();
		if (!empty($result)){
			header('location:returnsAdmin.php');//redirect to the relevant page
		}
	}
}

if(!empty($_POST["save2"])) {
	require_once("db.php");	
	$date=Date('yy/mm/dd');
	$sql = "INSERT INTO `book_details`(`BookID`, `Title`, `Description`, `Author`, `Category`, `Img_link`)
	VALUES ( :id, :title, :descrip, :author, :category, :link )";
	$pdo_statement = $pdo_conn->prepare( $sql );
		
	$result = $pdo_statement->execute( array( ':id'=>$_POST['id'],
	'title'=>$_POST['title'], ':descrip'=>$_POST['descrip'],
	':author'=>$_POST['author'], ':category'=>$_POST['category'], ':link'=>$_POST['link'] ) );
	if (!empty($result) ){
	  header('location:bookDetails.php');
	}
}

if(!empty($_POST["save4"])) {
	require_once("db.php");	
	$sql = "INSERT INTO `payment_details`(`PaymentID`, `pType`, `Amount`, `Date`, `MemberID`)
	VALUES ( :id, :type, :amount, :pDate, :mid )";
	$pdo_statement = $pdo_conn->prepare( $sql );
		
	$result = $pdo_statement->execute( array( ':id'=>$_POST['id'],
	'type'=>$_POST['type'], ':amount'=>$_POST['amount'],
	':pDate'=>$_POST['pDate'], ':mid'=>$_POST['mid']) );
	if (!empty($result) ){
	  header('location:payments.php');
	}
}

if(!empty($_POST["save5"])) {
	require_once("db.php");
	$sql = "INSERT INTO `reserve_details`(`ReserveID`, `Date`, `MemberID`, `BookID`)
	VALUES ( :id, :bDate, :mid, :bid )";
	$pdo_statement = $pdo_conn->prepare( $sql );
		
	$result = $pdo_statement->execute( array( ':id'=>$_POST['id'],
	'bDate'=>$_POST['bDate'], ':mid'=>$_POST['mid'], ':bid'=>$_POST['bid'] ) );
	if (!empty($result) ){
		
		$pdo_statement=$pdo_conn->prepare("update book_details set 
		BookStatus='Reserved',
		Date='" . $_POST[ 'bDate' ]. "' where BookID=" . $_GET["bid"]);
		$result = $pdo_statement->execute();
		if($result) {
			header('location:reserved.php');
		}
	}
}

if(!empty($_POST["save6"])) {
	$pdo_statement=$pdo_conn->prepare("update book_details set 
	BookStatus='Borrowed',
	Date='" . $_POST[ 'bDate' ]. "' where BookID=" . $_GET["id1"]);
	$result = $pdo_statement->execute();
	if($result) {
		header('location:view.php');
	}
}

if(!empty($_POST["save5"])) {
	
}

//selecting all records from book_details table
if(isset($_GET['id1'])){
$pdo_statement = $pdo_conn->prepare("SELECT * FROM book_details where BookID=" . $_GET["id1"]);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
}
//selecting all records from book_details table
if(isset($_GET['bid'])){
$pdo_statement = $pdo_conn->prepare("SELECT * FROM book_details where BookID=" . $_GET["bid"]);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
}

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
	<script src="js/sortSearch.js"></script>
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

		<!--Edit Book Borrow Details-->
		<div class="container form my-5 py-5" style="<?php if(isset($_GET['id1'])){ echo'display:block;';}?>">
			<div class="container-fluid p-5 border border-dark rounded table-dark">
				<div style="margin:20px 0;text-align:right;"><a href="booksAdmin.php" class="btn btn-orange round text-light">Back to List</a></div>
				<form name="editForm" method="POST">
				  <div class="form-group row">
					<div class="col">
					<label for="bDate">Borrowing Date</label>
					<input type="date" class="form-control" id="bDate" name="bDate" placeholder="Enter borrowing date" required>
					</div>
					<div class="col">
					<label for="rDate">Return Date</label>
					<input type="date" class="form-control" id="rDate" name="rDate" placeholder="Enter return date" required>
					</div>
				  </div>
				  <div class="form-group row">
					<label for="bid">Book ID</label>
					<input type="text" class="form-control" id="bid" name="bid" placeholder="Enter book ID" value="<?php echo $result[0]['BookID']; ?>" required>
				  </div>
				  <div class="form-group row">
					<label for="mid">Member ID</label>
					<input type="text" class="form-control" id="mid" name="mid" placeholder="Enter member ID" required>
				  </div>
				  <div class="form-group row">
					<button type="submit" name="save6" value="Save" class="btn btn-success round btn-block">Save</button>
				  </div>
				</form>
			</div> 
		</div>

		<!--Reserve Books-->
		<div class="container form my-5 py-5" style="<?php if(isset($_GET['bid'])){ echo'display:block;';}?>">
			<div class="container-fluid p-5 border border-dark rounded table-dark">
				<div style="margin:20px 0;text-align:right;"><a href="artMusic.php" class="btn btn-orange round text-light">Back to List</a></div>
				<form name="editForm" method="POST">
				  <div class="form-group row">
					<label for="bDate">Reserve Date</label>
					<input type="date" class="form-control" id="bDate" name="bDate" placeholder="Enter borrowing date" required>
				  </div>
				  <div class="form-group row">
					<label for="bid">Book ID</label>
					<input type="text" class="form-control" id="bid" name="bid" placeholder="Enter book ID" value="<?php echo $result[0]['BookID']; ?>" required>
				  </div>
				  <div class="form-group row">
					<label for="mid">Member ID</label>
					<input type="text" class="form-control" id="mid" name="mid" placeholder="Enter member ID" required>
				  </div>
				  <div class="form-group row">
					<button type="submit" name="save5" value="Save" class="btn btn-success round btn-block">Reserve</button>
				  </div>
				</form>
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