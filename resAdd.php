<?php
session_start();
if(isset($_SESSION['id']))
{
	//Database connection
	require_once("dbcon\db.php");
	
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
	<link rel="stylesheet" type="text/css" href="css/user.css">

 </head>
 <body>
 <div class="content">
	<!-- Page Content -->
	<section>
	  <div class="container">
		<p class="lead text-center">Reserve your favourite book for 24 hours now!</p>
		<hr class="my-3">
	  </div>
	</section>
	<!--Reserve Books-->
		<div class="container modal form my-3 py-5" style="<?php if(isset($_GET['bid'])){ echo'display:block;';}?>">
			<div class="container-fluid p-5 modal-sm border border-dark rounded table-dark">
				<div style="margin:20px 0;text-align:right;"><a onClick="parent()" class="btn btn-orange round text-light">Go back</a></div>
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
		<script>
		function parent(){

		top.location.href = "bookCategories.php";

		}
		</script>
		

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