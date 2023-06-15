<html>
<body>
<?php

//create_connection
//servername_Username_Password_Databasename
$conn = new mysqli('localhost','root','','LowaStateLibrary');
//check connection
if($conn->connect_error)
{
	die("Connection failed:".$conn->connect_error);
}

//validation of data and insert of details to login and member_details tables 
if (isset($_POST['submit'])) {
  	$username = $_POST['uname'];
  	$email = $_POST['email'];

  	$sql_u = "SELECT * FROM login WHERE Username='$username'";
  	$sql_e = "SELECT * FROM member_details WHERE Email='$email'";
  	$res_u = mysqli_query($conn, $sql_u);
  	$res_e = mysqli_query($conn, $sql_e);

  	if (mysqli_num_rows($res_u) > 0) {
		$name_error = "This username isn't available please try another."; 	//error message
  	}else if(mysqli_num_rows($res_e) > 0){
		$email_error = "Another account is using $email."; 	//error message
  	}
	else{
	$sql="INSERT INTO `member_details`(`FirstName`, `LastName`, `Email`) VALUES ('$_POST[fname]','$_POST[lname]','$_POST[email]')";
	$sql1="INSERT INTO `login`(`Username`, `Password`, `Role`) VALUES ('$_POST[uname]','$_POST[pass]','$_POST[account]')";

	if($conn->query($sql)===TRUE && $conn->query($sql1)===TRUE)
	{
	print("New Account Created Successfully");
    header("location:Login.php");
	}
	else
	{
		print("Error:".$sql."<br>".$conn->error);
		print("Error:".$sql1."<br>".$conn->error);
	}

	$conn->close();
	}
}
?>
</body>
</html>