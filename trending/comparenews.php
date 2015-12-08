<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php

//Hàm so sánh 2 tin tức
function compare(array $TinTuc1, array $TinTuc2)
{
	//So sánh tiêu đề 2 bài viết (Đếm số từ giống nhau)
	$tieude1 = explode(" ", $TinTuc1["TieuDe"]);
	$tieude2 = explode(" ", $TinTuc2["TieuDe"]);
	
	$count1 = 0;
	for ($i = 0; $i < count($tieude1); $i++)
		for ($j = 0; $j < count($tieude2); $j++)
			if ($tieude1[$i] == $tieude2[$j])
				$count1++;
	
	//So sánh phần tóm tắt
	$tomtat1 = explode(" ", $TinTuc1["TomTat"]);
	$tomtat2 = explode(" ", $TinTuc2["TomTat"]);
	
	$count2 = 0;
	for ($i = 0; $i < count($tomtat1); $i++)
		for ($j = 0; $j < count($tomtat2); $j++)
			if ($tomtat1[$i] == $tomtat2[$j])
				$count2++;
			
	//Đếm số tag giống nhau
	$tag1 = explode(" ", $TinTuc1["Tag"]);
	$tag2 = explode(" ", $TinTuc2["Tag"]);
	
	$count3 = 0;
	for ($i = 0; $i < count($tag1); $i++)
		for ($j = 0; $j < count($tag2); $j++)
			if ($tag1[$i] == $tag2[$j])
				$count3++;
			
	$avg = 0.4*$count1/count($tieude1) + 0.25*$count2/count($tomtat1) + 0.35*$count3/count($tag1);
	//$avg = $count1/count($tieude1);
	
	if ($avg >= 0.75)
		return true;
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "alano";

// Tạo kết nối đến CSDL
$connection = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($connection->connect_error) {
    die("connectionection failed: " . $connection->connect_error);
}
else
{
	mysqli_query($connection,"SET NAMES utf8"); 

	//Đọc dữ liệu từ bảng Tin Tức
	$sql = "SELECT MaTinTuc, TieuDe, TomTat, NoidungChinh, NgayDang, DuongLinkGoc, TinhTrangLink, CacTrangDanNguon, SoLuotShare, SoLuotComment, BaiTuongTu, SoBaiTrung, Tag, BaiGoc, DaDuyet FROM TinTuc";
	$result = mysqli_query($connection,$sql);
	
	$TinTucInfo = array();
	
	while($row_TinTuc = mysqli_fetch_assoc($result))
		$TinTucInfo[] = $row_TinTuc;

	
	//So sánh 2 tin tức
	for ($i = 0; $i < count($TinTucInfo); $i++)
	{
		if ($TinTucInfo[$i]["DaDuyet"] == 0)	//Chỉ so sánh những tin chưa duyệt
		{
			for ($j = $i + 1; $j < count($TinTucInfo); $j++)
			{
				//Nếu 2 tin được cho là có nội dung giống nhau
				if (compare($TinTucInfo[$i],$TinTucInfo[$j]))
				{					
					//Tăng số bài trùng của mỗi tin lên 1
					$TinTucInfo[$i]["SoBaiTrung"] += 1;
					$TinTucInfo[$j]["SoBaiTrung"] += 1;
				
					//Gán bài gốc cho bài đăng sớm hơn
					$d1 = date_parse_from_format('Y-m-d H:i:s',$TinTucInfo[$i]["NgayDang"]);
					$d2 = date_parse_from_format('Y-m-d H:i:s',$TinTucInfo[$j]["NgayDang"]);
					
					if ($TinTucInfo[$i]["BaiTuongTu"] == null && $TinTucInfo[$j]["BaiTuongTu"] == null)
					{
						if ($d1 < $d2)
							$TinTucInfo[$i]["BaiGoc"] = 1;
						else
							$TinTucInfo[$j]["BaiGoc"] = 1;
					}
					else
					{
						if ($d1 < $d2 && $TinTucInfo[$i]["BaiGoc"] == 0)
						{
							$temp = $TinTucInfo[$i]["BaiGoc"];
							$TinTucInfo[$i]["BaiGoc"] = $TinTucInfo[$j]["BaiGoc"];
							$TinTucInfo[$j]["BaiGoc"] = $temp;
						}
						
					}
					
					//Đưa vào danh sách các bài tương tự
					$TinTucInfo[$i]["BaiTuongTu"] = $TinTucInfo[$i]["BaiTuongTu"] . $TinTucInfo[$j]["MaTinTuc"] . " ";
					$TinTucInfo[$j]["BaiTuongTu"] = $TinTucInfo[$j]["BaiTuongTu"] . $TinTucInfo[$i]["MaTinTuc"] . " ";
				}
			}
			
			//Đã duyệt
			$TinTucInfo[$i]["DaDuyet"] = 1;
		}
	}
	
	//Cập nhật lại dữ liệu
	foreach($TinTucInfo as $tintuc)
	{
		$sqlud = "update TinTuc set SoBaiTrung = " . $tintuc["SoBaiTrung"] . ", BaiTuongTu = '" . $tintuc["BaiTuongTu"] . "', BaiGoc = " . $tintuc["BaiGoc"] . ", DaDuyet = " . $tintuc["DaDuyet"] . " where MaTinTuc = " . $tintuc["MaTinTuc"];
		$result = mysqli_query($connection,$sqlud);
	}
	
	$connection->close();
	
	echo "Complete!";
}
?>
