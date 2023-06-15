<?php
session_start();
if(isset($_SESSION['id']))
{
?>
<?php
//Database connection
require_once("dbcon\db.php");

//updating borrow_details table
if(!empty($_POST["save"])) {
	$pdo_statement=$pdo_conn->prepare("update borrow_details set 
	BorrowDate='" . $_POST[ 'bDate' ]. "',
	ReturnDate='" . $_POST[ 'rDate' ]. "',
	BookID='" . $_POST[ 'bid' ]. "',
	MemberID='" . $_POST[ 'mid' ]. "' where BorrowID=" . $_GET["id"]);
	$result = $pdo_statement->execute();
	if($result) {
		header('location:view.php');//redirecting to relevant page
	}
}
//update return_details table
if(!empty($_POST["save1"])) {
	$pdo_statement=$pdo_conn->prepare("update return_details set 
	ReturnDate='" . $_POST[ 'rDate' ]. "',
	ReturnStatus='" . $_POST[ 'rStat' ]. "',
	BookID='" . $_POST[ 'bid' ]. "',
	MemberID='" . $_POST[ 'mid' ]. "'	where ReturnID=" . $_GET["id1"]);
	$result = $pdo_statement->execute();
	if($result) {
		header('location:returnsAdmin.php');//redirecting to relevant page
	}
}

//update book_details table
if(!empty($_POST["save2"])) {
	$pdo_statement=$pdo_conn->prepare("update book_details set 
	Title='" . $_POST[ 'title' ]. "',
	Description='" . $_POST[ 'descrip' ]. "',
	Author='" . $_POST[ 'author' ]. "',
	Category='" . $_POST[ 'category' ]. "',
	Img_link='" . $_POST[ 'link' ]. "'	where BookID=" . $_GET["id2"]);
	$result = $pdo_statement->execute();
	if($result) {
		header('location:bookDetails.php');//redirecting to relevant page
	}
}

if(!empty($_POST["save3"])) {
	$pdo_statement=$pdo_conn->prepare("update payment_details set 
	pType='" . $_POST[ 'type' ]. "',
	Amount='" . $_POST[ 'amount' ]. "',
	Date='" . $_POST[ 'pDate' ]. "',
	MemberID='" . $_POST[ 'mid' ]. "'	where PaymentID=" . $_GET["id3"]);
	$result = $pdo_statement->execute();
	if($result) {
		header('location:payments.php');
	}
}

if(isset($_GET['id'])){
$pdo_statement = $pdo_conn->prepare("SELECT * FROM borrow_details where BorrowID=" . $_GET["id"]);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
}
if(isset($_GET['id1'])){
$pdo_statement = $pdo_conn->prepare("SELECT * FROM return_details where ReturnID=" . $_GET["id1"]);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
}
if(isset($_GET['id2'])){
$pdo_statement = $pdo_conn->prepare("SELECT * FROM book_details where BookID=" . $_GET["id2"]);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
}

if(isset($_GET['id3'])){
$pdo_statement = $pdo_conn->prepare("SELECT * FROM payment_details where PaymentID=" . $_GET["id3"]);
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
		<!--Edit Book Borrow Details-->
		<div class="container form my-5 py-5" style="<?php if(isset($_GET['id'])){ echo'display:block;';}?>">
			<div class="container-fluid p-5 border border-dark rounded table-dark">
				<div style="margin:20px 0;text-align:right;"><a href="view.php" class="btn btn-orange round text-light">Back to List</a></div>
				<form name="editForm" method="POST">
				  <div class="form-group row">
					<label for="id">Borrowing ID</label>
					<input type="text" class="form-control" id="id" name="id" placeholder="Enter borrow ID" value="<?php echo $result[0]['BorrowID']; ?>" required autofocus>
				  </div>
				  <div class="form-group row">
					<div class="col">
					<label for="bDate">Borrowing Date</label>
					<input type="date" class="form-control" id="bDate" name="bDate" placeholder="Enter borrowing date" value="<?php echo $result[0]['BorrowDate']; ?>" required>
					</div>
					<div class="col">
					<label for="rDate">Return Date</label>
					<input type="date" class="form-control" id="rDate" name="rDate" placeholder="Enter return date" value="<?php echo $result[0]['ReturnDate']; ?>" required>
					</div>
				  </div>
				  <div class="form-group row">
					<label for="bid">Book ID</label>
					<input type="text" class="form-control" id="bid" name="bid" placeholder="Enter book ID" value="<?php echo $result[0]['BookID']; ?>" required>
				  </div>
				  <div class="form-group row">
					<label for="mid">Member ID</label>
					<input type="text" class="form-control" id="mid" name="mid" placeholder="Enter member ID" value="<?php echo $result[0]['MemberID']; ?>" required>
				  </div>
				  <div class="form-group row">
					<button type="submit" name="save" value="Save" class="btn btn-success round btn-block">Save</button>
				  </div>
				</form>
			</div> 
		</div>
 
		<!--Edit Book Return Details-->
		<div class="container form my-5 py-5" style="<?php if(isset($_GET['id1'])){ echo'display:block;';}?>">
			<div class="container-fluid p-5 border border-dark rounded table-dark">
			<div style="margin:20px 0;text-align:right;"><a href="returnsAdmin.php" class="btn btn-orange round text-light">Back to List</a></div>
				<form name="editForm" method="POST">
				  <div class="form-group row">
					<label for="id">Return ID</label>
					<input type="text" class="form-control" id="id" name="id" placeholder="Enter borrow ID" value="<?php echo $result[0]['ReturnID']; ?>" required autofocus>
				  </div>
				  <div class="form-group row">
					<label for="rDate">Return Date</label>
					<input type="date" class="form-control" id="rDate" name="rDate" placeholder="Enter borrowing date" value="<?php echo $result[0]['ReturnDate']; ?>" required>
				  </div>
				  <div class="form-group row">
					<label for="rStat">Return Status</label>
					<select class="form-control" id="rStat" name="rStat" required>
					<option <?php 
					$options=$result[0]['ReturnStatus'];
					if($options=="Late") echo 'selected="selected"'; ?> value="Late">Late</option>
					<option <?php 
					if($options=="On time") echo 'selected="selected"'; ?>>On time</option>
					</select>
				  </div>
				  <div class="form-group row">
					<label for="bid">Book ID</label>
					<input type="text" class="form-control" id="bid" name="bid" placeholder="Enter book ID" value="<?php echo $result[0]['BookID']; ?>" required>
				  </div>
				  <div class="form-group row">
					<label for="mid">Member ID</label>
					<input type="text" class="form-control" id="mid" name="mid" placeholder="Enter member ID" value="<?php echo $result[0]['MemberID']; ?>" required>
				  </div>
				  <div class="form-group row">
					<button type="submit" name="save1" value="Save" class="btn btn-success btn-block">Save</button>
				  </div>
				</form>
			</div> 
		</div>

		<!--Edit Book Details-->
		<div class="container form my-5 py-5" style="<?php if(isset($_GET['id2'])){ echo'display:block;';}?>">
			<div class="container-fluid p-5 border border-dark rounded table-dark">
				<div style="margin:20px 0;text-align:right;"><a href="bookDetails.php" class="btn btn-orange round text-light">Back to List</a></div>
				<form name="editForm" method="POST">
				  <div class="form-group row">
					<label for="id">Book ID</label>
					<input type="text" class="form-control" id="bookid" name="bookid" placeholder="Enter book ID" value="<?php echo $result[0]['BookID']; ?>" required autofocus>
				  </div>
				  <div class="form-row">
				  <div class="form-group col-md-6">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Enter book title" value="<?php echo $result[0]['Title']; ?>" required>
				  </div>
				  <div class="form-group col-md-6">
					<label for="author">Author</label>
					<input type="text" class="form-control" id="author" name="author" placeholder="Enter book author" value="<?php echo $result[0]['Author']; ?>" required>
				  </div>
				  </div>
				  <div class="form-group row">
					<label for="category">Category</label>
					<select class="form-control" id="category" name="category" required>
						<option 
						<?php 
						$options=$result[0]['Category'];
						if($options=="Art & Music") echo 'selected="selected"'; ?>	value="Art & Music">Art & Music</option>
						<option 
						<?php 
						if($options=="History") echo 'selected="selected"'; ?>	value="History">History</option>
						<option 
						<?php 
						if($options=="Science & Maths") echo 'selected="selected"'; ?>	value="Science & Maths">Science & Maths</option>
						<option 
						<?php 
						if($options=="Medical") echo 'selected="selected"'; ?>	value="Medical">Medical</option>
						<option 
						<?php 
						if($options=="Biographies") echo 'selected="selected"'; ?>	value="Biographies">Biographies</option>
						<option 
						<?php 
						if($options=="Sci-Fi & Fantasy") echo 'selected="selected"'; ?> value="Sci-Fi & Fantasy">Sci-Fi & Fantasy</option>
					</select>
				  </div>
				  <div class="form-group row">
					<label for="link">Cover Path</label>
					<input type="text" class="form-control" id="link" name="link" placeholder="Enter cover image path" value="<?php echo $result[0]['Img_link']; ?>" required>
				  </div>
				  <div class="form-group row">
					<label for="descrip">Description</label>
					<textarea type="text" class="form-control" id="descrip" name="descrip" rows="2" placeholder="Enter book description" required><?php echo $result[0]['Description']; ?></textarea>
				  </div>
				  <div class="form-group row">
					<button type="submit" name="save2" value="Save" class="btn btn-success btn-block">Save</button>
				  </div>
				</form>
			</div> 
		</div>
		
		<!--Edit Fine Payment Details-->
		<div class="container form my-5 py-5" style="<?php if(isset($_GET['id3'])){ echo'display:block;';}?>">
			<div class="container-fluid p-5 border border-dark rounded table-dark">
					<div style="margin:20px 0;text-align:right;"><a href="payments.php" class="btn btn-orange round text-light">Back to List</a></div>
					<form name="editForm" method="POST">
						  <div class="form-group row">
							<label for="id">Payment ID</label>
							<input type="text" class="form-control" id="id" name="id" value="<?php echo $result[0]['PaymentID']; ?>" placeholder="Enter payment ID" required>
						  </div>
						  <div class="row">
							  <div class="form-group col">
								<label for="amount">Amount</label>
								<input type="text" class="form-control" id="amount" name="amount" value="<?php echo $result[0]['Amount']; ?>" placeholder="Enter amount" required>
							  </div>
							  <div class="form-label-group col">
								<label for="type">Payment Type</label>
								<select type="text" id="type" name="type" class="form-control browser-default custom-select" autofocus required>
									<option value="" disabled selected>Choose your option</option>
									<option
									<?php 
									$options=$result[0]['pType'];
									if($options=="Credit Card") echo 'selected="selected"'; ?>>
									Credit Card</option>
									<option
									<?php 
									$options=$result[0]['pType'];
									if($options=="Debit Card") echo 'selected="selected"'; ?>>
									Debit Card</option>
									<option<?php 
									$options=$result[0]['pType'];
									if($options=="Cash") echo 'selected="selected"'; ?>>
									Cash</option>
								</select>
							  </div>
						  </div>
						  <div class="form-group row">
							<label for="pDate">Payment Date</label>
							<input type="date" class="form-control" id="pDate" name="pDate"  value="<?php echo $result[0]['Date']; ?>" placeholder="Enter payment date" required>
						  </div>
						  <div class="form-group row">
							<label for="mid">Member ID</label>
							<input type="text" class="form-control" id="mid" name="mid" value="<?php echo $result[0]['MemberID']; ?>" placeholder="Enter member ID" required>
						  </div>
						  <div class="form-group row">
							<button type="submit" name="save3" value="Save" class="btn btn-success round btn-block">Save</button>
						  </div>
					</form>
			</div> 
		</div>
		</div>

 
	<!-- Site footer -->
	<footer class="py-4 bg-dark text-white-50">
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