<!DOCTYPE html>
<html>
<head>

	<title>Lowa State University|Library</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../fontawesome-free-5.3.1-web/css/all.min.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/user.css">

 </head>
 
<body>

<!--Sci-Fi & Fantasy Section-->
	<section id="scifiFa" class="container mb-3 pb-3">
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
					<a href="#"><img class="card-img-top" style="height:250px;" src="../<?php echo $row['Img_link'];?>" alt=""></a>
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
						target="_parent" href="../resAdd.php?bid=<?php echo $row['BookID'];} ?>">Reserve</a>
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
</body>
</html>