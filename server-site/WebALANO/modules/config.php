<?php
	$server = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'alano';
	
	$connection = new mysqli($server, $username, $password, $database);
	
	if ($connection->connect_error)
	{
		die ("Connection failed: " . $connection->connect_error);
		break;
	}
	
	mysqli_query($connection,"SET NAMES utf8"); 
?>
