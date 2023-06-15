<?php

//Database connection
require_once("dbcon\db.php");

//delete records from borrow_details table
if(isset($_GET['id'])){
$pdo_statement=$pdo_conn->prepare("delete from borrow_details where BorrowID=" . $_GET['id']);
$pdo_statement->execute();
header('location:view.php');
}

//delete records from return_details table
if(isset($_GET['id1'])){
$pdo_statement=$pdo_conn->prepare("delete from return_details where ReturnID=" . $_GET['id1']);
$pdo_statement->execute();
header('location:returnsAdmin.php');//redirect to relevant page
}

//delete records from payment_details table
if(isset($_GET['id2'])){
$pdo_statement=$pdo_conn->prepare("delete from payment_details where PaymentID=" . $_GET['id2']);
$pdo_statement->execute();
header('location:payments.php');//redirect to relevant page
}

//delete records from book_details table
if(isset($_GET['id3'])){
$pdo_statement=$pdo_conn->prepare("delete from book_details where BookID=" . $_GET['id3']);
$pdo_statement->execute();
header('location:bookDetails.php');//redirect to relevant page
}

?>
