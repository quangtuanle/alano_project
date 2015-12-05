<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
function compare(array $TinTuc1, array $TinTuc2)
{
	//Compare TieuDe
	$tieude1 = explode(" ", $TinTuc1["TieuDe"]);
	$tieude2 = explode(" ", $TinTuc2["TieuDe"]);
	
	$count1 = 0;
	for ($i = 0; $i < count($tieude1); $i++)
		for ($j = 0; $j < count($tieude2); $j++)
			if ($tieude1[$i] == $tieude2[$j])
				$count1++;
	
	//Compare TomTat
	$tomtat1 = explode(" ", $TinTuc1["TomTat"]);
	$tomtat2 = explode(" ", $TinTuc2["TomTat"]);
	
	$count2 = 0;
	for ($i = 0; $i < count($tomtat1); $i++)
		for ($j = 0; $j < count($tomtat2); $j++)
			if ($tomtat1[$i] == $tomtat2[$j])
				$count2++;
			
	//Compare Tag
	$tag1 = explode(" ", $TinTuc1["Tag"]);
	$tag2 = explode(" ", $TinTuc2["Tag"]);
	
	$count3 = 0;
	for ($i = 0; $i < count($tag1); $i++)
		for ($j = 0; $j < count($tag2); $j++)
			if ($tag1[$i] == $tag2[$j])
				$count3++;
			
	$avg = 0.4*$count1/count($tieude1) + 0.25*$count2/count($tomtat1) + 0.35*$count3/count($tag1);
	
	if ($avg >= 0.75)
		return true;
	else
		return false;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "alano";

// Create connectionection
$connection = new mysqli($servername, $username, $password, $database);

// Check connectionection
if ($connection->connect_error) {
    die("connectionection failed: " . $connection->connect_error);
}
else
{
	mysqli_query($connection,"SET NAMES utf8"); 

	//Read from MySql Database
	$sql = "SELECT MaTinTuc, TieuDe, TomTat, NoidungChinh, NgayDang, DuongLinkGoc, TinhTrangLink, CacTrangDanNguon, SoLuotShare, SoLuotComment, BaiTuongTu, SoBaiTrung, Tag FROM TinTuc";
	$result = mysqli_query($connection,$sql);
	
	$TinTucInfo = array();
	
	while($row_TinTuc = mysqli_fetch_assoc($result))
		$TinTucInfo[] = $row_TinTuc;

	
	//Compare TieuDe. If 2 TinTuc have the same TieuDe then increase SoBaiTrung of both 2 TinTuc
	for ($i = 0; $i < count($TinTucInfo) - 1; $i++)
		for ($j = $i + 1; $j < count($TinTucInfo); $j++)
		{
			if (compare($TinTucInfo[$i],$TinTucInfo[$j]))
			{
				$TinTucInfo[$i]["SoBaiTrung"] += 1;
				$TinTucInfo[$j]["SoBaiTrung"] += 1;
			}
		}
	
	//Update Database
	foreach($TinTucInfo as $tintuc)
	{
		$sqlud = "update TinTuc set SoBaiTrung = " . $tintuc["SoBaiTrung"] . " where MaTinTuc = " . $tintuc["MaTinTuc"];
		$result = mysqli_query($connection,$sqlud);
	}
	
	$connection->close();
	
	echo "Complete!";
}
?>
