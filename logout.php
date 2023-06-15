<?php
session_start();
unset($_SESSION['id']);//removing session id
session_destroy();//destroying the session

header("Location:index.html");//redirecting to the start page
exit;
?>
