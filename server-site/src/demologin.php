<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
$servername = "localhost";
$username = "root";
$password = "annamdra";
$database = "alano";

$userid = $_POST['username'];
$password = $_POST['password'];

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) 
{
	// Không kết nối được, thoát ra và báo lỗi
	die ("Connection failed: " . $connection->connect_error);		
}
else
{
	mysqli_query($connection, "SET NAMES utf8");	
		
	$query = "SELECT TenDN, MatKhau FROM TaiKhoan";
	
	$result = mysqli_query($connection, $query);
	
	$row_user = mysqli_fetch_assoc($result);	
	if (mysqli_num_rows($result) > 0)
	{
		echo "LOGIN SUCCESS";
	}
	
	// Free result set
	mysqli_free_result($result);	
		
	// Đóng kết nối
	mysqli_close($connection);
}
?>