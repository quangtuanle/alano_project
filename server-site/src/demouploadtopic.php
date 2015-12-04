<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "alano";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) 
{
	// Không kết nối được, thoát ra và báo lỗi
	die ("Connection failed: " . $connection->connect_error);		
}
else
{
	mysqli_query($connection, "SET NAMES utf8");	
		
	$query = "SELECT TieuDe, TomTat, TaiKhoanTacGia, NgayDang, NoiDung, HinhAnhMinhHoa, Nhan, SoLuotLike, SoLuotView FROM BaiViet";
	
	$result = mysqli_query($connection, $query);	
	
	while ($row_topic = mysqli_fetch_array($result))
	{
		echo $row_topic["TieuDe"];
		echo $row_topic["TomTat"];
		echo $row_topic["NgayDang"];
		echo $row_topic["HinhAnhMinhHoa"];
	}
	
	// Free result set
	mysqli_free_result($result);	
		
	// Đóng kết nối
	mysqli_close($connection);
}
?>
