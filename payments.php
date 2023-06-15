<?php
session_start();
if(isset($_SESSION['id']))
{
?>
<?php
require_once("dbcon\db.php");
?>
<html>
 <head>
	<title>Lowa State University|Library</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="fontawesome-free-5.3.1-web/css/all.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/sortSearch.js"></script>
	<link rel="stylesheet" type="text/css" href="css/user.css">

	<script type ="text/javascript">
	function delete_data(id){
		if(confirm('Are you sure to remove this record?')){
			window.location.href='delete.php?id2='+id;
		}
	}
	</script>
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
		<h3 class="display-4 pt-5 text-center">Fine Payments</h3>
		</div>
	</header>

	<?php	
		$pdo_statement = $pdo_conn->prepare("SELECT * FROM payment_details ORDER BY PaymentID DESC");
		$pdo_statement->execute();
		$result = $pdo_statement->fetchAll();
	?>

	<div class="container py-3 my-3">
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
							<li class="nav-item p-2">
							  <button class="btn btn-orange round" data-toggle="modal" data-target="#myModal">
									<i class="fa fa-plus-circle"></i>
									Add new record
							  </button>
							</li>
					  </ul>
					  <form autocomplete="off" class="form-inline my-2 p-2 my-lg-0" role="search" name="search">
							<input class="form-control form-control-sm mr-sm-2" name="search" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search">
					  </form>
					  </div>
					  </div>
				  </nav>
				</div>
			</div>
		<!--Add New Record-->
		<div class="adminForm modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="myModal">
		  <div class="modal-dialog modal-sm-5" role="document">
			<div class="modal-content">
				<div class="container-fluid p-5 border border-dark rounded table-dark">
					<div style="margin:20px 0;text-align:right;"><a href="payments.php" class="btn btn-orange round text-light">Back to List</a></div>
					<form name="editForm" action="add.php" method="POST">
						  <div class="form-group row">
							<label for="id">Payment ID</label>
							<input type="text" class="form-control" id="id" name="id" placeholder="Enter payment ID" required>
						  </div>
						  <div class="row">
							  <div class="form-group col">
								<label for="amount">Amount</label>
								<input type="text" class="form-control" id="amount" name="amount" placeholder="Enter amount" required>
							  </div>
							  <div class="form-label-group col">
								<label for="type">Payment Type</label>
								<select type="text" id="type" name="type" class="form-control browser-default custom-select" autofocus required>
									<option value="" disabled selected>Choose your option</option>
									<option>Credit Card</option>
									<option>Debit Card</option>
									<option>Cash</option>
								</select>
							  </div>
						  </div>
						  <div class="form-group row">
							<label for="pDate">Payment Date</label>
							<input type="date" class="form-control" id="pDate" name="pDate" placeholder="Enter payment date" required>
						  </div>
						  <div class="form-group row">
							<label for="mid">Member ID</label>
							<input type="text" class="form-control" id="mid" name="mid" placeholder="Enter member ID" required>
						  </div>
						  <div class="form-group row">
							<button type="submit" name="save4" value="Save" class="btn btn-success round btn-block">Save</button>
						  </div>
					</form>
				</div> 
			</div>
		  </div>
		</div>

		<div class="container pb-5 mb-5">
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
				  <th>Actions</th>
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
					<td><!--
					<a class="ajax-action-links" href='edit.php?id=<?php // echo $row['id']; ?>'>
					<img src="crud-icon/edit.png" title="Edit" /></a> -->
					<a class="ajax-action-links" href='edit.php?id3=<?php echo $row['PaymentID']; ?>'>
					<i class="far fa-edit btn btn-success round text-light" title="Edit" style="color:white"></i></a> 
					<a class="ajax-action-links" href="javascript:delete_data(<?php echo $row['PaymentID']; ?>)">
					<i class="fas fa-trash btn btn-success round text-light" title="Delete"></i></a>
					</td>
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