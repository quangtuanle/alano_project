<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
set_time_limit(0);

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
	
	if (count($word1) != 0)
		return $count/count($word1);
	return 0;
}

//Kiểm tra từ viết hoa
function isUpper($a)
{
	return ($a[0] >= 'A' && $a[0] <= 'Z');
}

//Hàm so sánh 2 tin tức
function compare(array $News1, array $News2)
{
	//So sánh tiêu đề 2 bài viết (Đếm số từ giống nhau)
	$title = sameRatio($News1["title"],$News2["title"]);
	
	//So sánh phần tóm tắt
	$summary = sameRatio($News1["summary"],$News2["summary"]);
	
	//Đếm số tag giống nhau
	$tag = sameRatio($News1["tag"],$News2["tag"]);
	
	//So sánh nội dung chính, chỉ so sánh các danh từ riêng
	$content1 = preg_split("/[ \n\t,.:']/", $News1["content"], -1, PREG_SPLIT_NO_EMPTY);
	$content2 = preg_split("/[ \n\t,.:']/", $News2["content"], -1, PREG_SPLIT_NO_EMPTY);

	$countupper = 0;
	$sameword = 0;
	for ($i = 1; $i < count($content1) - 1; $i++)
	{
		if (isUpper($content1[$i]) && (isUpper($content1[$i-1]) || isUpper($content1[$i+1])))
		{
			$countupper++;
			
			for ($j = 0; $j < count($content2); $j++)
				if ($content1[$i] == $content2[$j])
				{
					$sameword++;
					break;
				}
		}
	}
	
	if ($countupper == 0)
		$content = 0;
	else
		$content = $sameword/$countupper;
	
	$avg = 0.35*$title + 0.25*$content + 0.2*$summary + 0.2*$tag;
	
	if ($avg >= 0.5)
	{
		
		return true;
	}
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "alano_website";

// Tạo kết nối đến CSDL
$connection = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($connection->connect_error) {
    die("connectionection failed: " . $connection->connect_error);
}
else
{
	mysqli_query($connection,"SET NAMES utf8"); 

	//Đọc dữ liệu từ bảng News
	$sql = "SELECT * FROM News";
	$result = mysqli_query($connection,$sql);
	
	$NewsInfo = array();
	
	while($row_News = mysqli_fetch_assoc($result))
		$NewsInfo[] = $row_News;
	
	//So sánh 2 tin tức
	for ($i = 0; $i < count($NewsInfo); $i++)
	{
		if ($NewsInfo[$i]["reviewed"] == 0)	//Chỉ so sánh những tin chưa duyệt
		{
			for ($j = $i + 1; $j < count($NewsInfo); $j++)
			{
				//Nếu 2 tin được cho là có nội dung giống nhau
				if (compare($NewsInfo[$i],$NewsInfo[$j]))
				{						
					//Tăng số bài trùng của mỗi tin lên 1
					$NewsInfo[$i]["num_same"] += 1;
					$NewsInfo[$j]["num_same"] += 1;
					
					//Nếu là tin đã duyệt, cập nhật lại độ hot
					if ($NewsInfo[$j]["original"] == 1)
						$NewsInfo[$j]["hot"] += 1;	
				
					//Gán bài gốc cho bài đăng sớm hơn
					$d1 = date_parse_from_format('Y-m-d H:i:s',$NewsInfo[$i]["published_at"]);
					$d2 = date_parse_from_format('Y-m-d H:i:s',$NewsInfo[$j]["published_at"]);
					
					if ($NewsInfo[$i]["same_news"] == null && $NewsInfo[$j]["same_news"] == null)
					{
						if ($d1 < $d2)
							$NewsInfo[$i]["original"] = 1;
						else
							$NewsInfo[$j]["original"] = 1;
					}
					else
					{
						if ($d1 < $d2 && $NewsInfo[$i]["original"] == 0)
						{
							$temp = $NewsInfo[$i]["original"];
							$NewsInfo[$i]["original"] = $NewsInfo[$j]["original"];
							$NewsInfo[$j]["original"] = $temp;
						}
						else if ($d1 > $d2 && $NewsInfo[$j]["original"] == 0)
						{
							$temp = $NewsInfo[$j]["original"];
							$NewsInfo[$j]["original"] = $NewsInfo[$i]["original"];
							$NewsInfo[$i]["original"] = $temp;
						}
					}
					
					//Đưa vào danh sách các bài tương tự
					$NewsInfo[$i]["same_news"] = $NewsInfo[$i]["same_news"] . $NewsInfo[$j]["id"] . " ";
					$NewsInfo[$j]["same_news"] = $NewsInfo[$j]["same_news"] . $NewsInfo[$i]["id"] . " ";
				}
			}
			//Tính độ hot
			$NewsInfo[$i]["hot"] = $NewsInfo[$i]["num_like"] + $NewsInfo[$i]["num_share"]*2 + $NewsInfo[$i]["num_comment"]/3 + $NewsInfo[$i]["num_same"]*2;
			
			//Đã duyệt
			$NewsInfo[$i]["reviewed"] = 1;
		}
		
		//Nếu là bài duy nhất, không có bài tương tự thì đó là bài gốc
		if ($NewsInfo[$i]["same_news"] == null)
			$NewsInfo[$i]["original"] = 1;
	
	
		//Cập nhật lại dữ liệu
		$sqlud = "update News set num_same = " . $NewsInfo[$i]["num_same"] . ", same_news = '" . $NewsInfo[$i]["same_news"] . "', original = " . $NewsInfo[$i]["original"] . ", reviewed = " . $NewsInfo[$i]["reviewed"] . ", hot = " . $NewsInfo[$i]["hot"] . " where id = " . $NewsInfo[$i]["id"];
		
		$result = mysqli_query($connection,$sqlud);
	
	}
	$connection->close();
}
?>