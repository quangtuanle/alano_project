<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Show Topic</title>
</head>

<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "alano";

$connection = new mysqli($servername, $username, $password, $database);

// Sau khi nhận được mã bài viết bên ngoài truyền vào sẽ gọi
$MaBaiViet = "TP01";

if ($connection->connect_error) 
{
	// Không kết nối được, thoát ra và báo lỗi
	die ("Connection failed: " . $connection->connect_error);		
}
else
{
	mysqli_query($connection, "SET NAMES utf8");	
		
	$query = "SELECT MaBaiViet, TieuDe, TomTat, TaiKhoanTacGia, NgayDang, NoiDung, HinhAnhMinhHoa, Nhan, SoLuotLike, SoLuotView FROM BaiViet";
	
	$result = mysqli_query($connection, $query);	
	
	while ($row_topic = mysqli_fetch_array($result))
	{
		if ($row_topic["MaBaiViet"] == $MaBaiViet)
		{
			echo $row_topic["TieuDe"];
			echo $row_topic["TomTat"];
			echo $row_topic["NgayDang"];
			echo $row_topic["NoiDung"];
			echo $row_topic["HinhAnhMinhHoa"];
			echo $row_topic["Nhan"];
			break;
		}
	}
	
	// Free result set
	mysqli_free_result($result);	
		
	// Đóng kết nối
	mysqli_close($connection);
}


?>
</body>
</html>
