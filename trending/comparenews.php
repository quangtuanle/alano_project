<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alano";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
	mysqli_query($conn,"SET NAMES utf8"); 

	//Read from MySql Database
	$sql = "select MaTinTuc, TieuDe, TomTat, NoidungChinh, TacGia, NgayDang, DuongLinkGoc, TinhTrangLink, CacTrangDanNguon, SoLuotShare, SoLuotComment, BaiTuongTu, SoBaiTrung from TinTuc";
	$result = mysqli_query($conn,$sql);
	
	$TinTucInfo = array();
	
	while($row_TinTuc = mysqli_fetch_assoc($result))
		$TinTucInfo[] = $row_TinTuc;

	
	//Compare TieuDe. If 2 TinTuc have the same TieuDe then increase SoBaiTrung of both 2 TinTuc
	for ($i = 0; $i < count($TinTucInfo) - 1; $i++)
		for ($j = $i + 1; $j < count($TinTucInfo); $j++)
		{
			if ($TinTucInfo[$i]["TieuDe"] == $TinTucInfo[$j]["TieuDe"])
			{
				$TinTucInfo[$i]["SoBaiTrung"] += 1;
				$TinTucInfo[$j]["SoBaiTrung"] += 1;
			}
		}
	
	//Update Database
	foreach($TinTucInfo as $tintuc)
	{
		$sqlud = "update TinTuc set SoBaiTrung = " . $tintuc["SoBaiTrung"] . " where MaTinTuc = " . $tintuc["MaTinTuc"];
		$result = mysqli_query($conn,$sqlud);
	}
	
	echo "Complete!";
}
?>
