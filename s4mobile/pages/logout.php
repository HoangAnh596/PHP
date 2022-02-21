<?php
if (isset($_SESSION['admin'])) {
	unset($_SESSION['admin']);
	header("Location:index.php");
} elseif (isset($_SESSION['user'])) {
	unset($_SESSION['user']);
	header("Location:index.php");
}  
?>