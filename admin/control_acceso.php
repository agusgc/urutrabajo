<?php
session_start();

if(!isset($_SESSION['admin'])){
	if(file_exists("index.php")){
		header("Location:index.php");
	}
	else{
		header("Location:../admin/index.php");
	}
}

?>