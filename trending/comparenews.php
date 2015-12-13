<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
//Tỉ lệ giống nhau giữa 2 đoạn text
function sameRatio ($string1, $string2)
{
	$word1 = preg_split("/[ \n\t,.:']/", $string1, -1, PREG_SPLIT_NO_EMPTY);
	$word2 = preg_split("/[ \n\t,.:']/", $string2, -1, PREG_SPLIT_NO_EMPTY);
	
	$count = 0;
	for ($i = 0; $i < count($word1); $i++)
		for ($j = 0; $j < count($word2); $j++)
			if ($word1[$i] == $word2[$j])
				$count++;
	
	return $count/count($word1);
}

//Hàm so sánh 2 tin tức
function compare(array $TinTuc1, array $TinTuc2)
{
	//So sánh tiêu đề 2 bài viết (Đếm số từ giống nhau)
	$tieude = sameRatio($TinTuc1["TieuDe"],$TinTuc2["TieuDe"]);
	
	//So sánh phần tóm tắt
	$tomtat = 0;//sameRatio($TinTuc1["TomTat"],$TinTuc2["TomTat"]);
	
	//Đếm số tag giống nhau
	$tag = sameRatio($TinTuc1["Tag"],$TinTuc2["Tag"]);
	
	//So sánh nội dung chính, chỉ so sánh các danh từ riêng	
	$noidung1 = preg_split("/[ \n\t,.:']/", $TinTuc1["NoidungChinh"], -1, PREG_SPLIT_NO_EMPTY);
	$noidung2 = preg_split("/[ \n\t,.:']/", $TinTuc2["NoidungChinh"], -1, PREG_SPLIT_NO_EMPTY);
		
	$countupper = 0;
	$sameword = 0;
	for ($i = 0; $i < count($noidung1); $i++)
	{
		if ($noidung1[$i] >= 'A' && $noidung1[$i] <= 'Z')
		{
			$countupper++;
			
			for ($j = 0; $j < count($noidung2); $j++)
				if ($noidung1[$i] == $noidung2[$j])
				{
					$sameword++;
					break;
				}
		}
	}
		
	$noidung = $sameword/$countupper;
	
	$avg = 0.4*$tieude + 0.25*$noidung + 0.15*$tomtat + 0.2*$tag;

	if ($avg >= 0.65)
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
		
		//Nếu là bài duy nhất, không có bài tương tự thì đó là bài gốc
		if ($TinTucInfo[$i]["BaiTuongTu"] == null)
			$TinTucInfo[$i]["BaiGoc"] = 1;
	}
	
	//Cập nhật lại dữ liệu
	foreach($TinTucInfo as $tintuc)
	{
		$sqlud = "update TinTuc set SoBaiTrung = " . $tintuc["SoBaiTrung"] . ", BaiTuongTu = '" . $tintuc["BaiTuongTu"] . "', BaiGoc = " . $tintuc["BaiGoc"] . ", DaDuyet = " . $tintuc["DaDuyet"] . " where MaTinTuc = " . $tintuc["MaTinTuc"];
		$result = mysqli_query($connection,$sqlud);
	}
	
	$connection->close();
}
?>
