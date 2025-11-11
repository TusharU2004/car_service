<?php
session_start();
$_SESSION = array();
session_destroy();

header("Location: adminlogin.php"); // change to your login page
exit();
?>