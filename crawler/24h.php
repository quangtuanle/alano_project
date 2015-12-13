<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<?php

// It may take a whils to crawl a site ...
set_time_limit(10000);
$myfile = fopen("testfile.txt", "w");
$depth =2;
// Inculde the phpcrawl-mainclass
include("PHPCrawl_083/libs/PHPCrawler.class.php");
$arryTitle = array('title_news','relative_new','txt_tag');

class MyCrawler extends PHPCrawler 
{
	
	function handleDocumentInfo(PHPCrawlerDocumentInfo $p)
	{ 
		$date = null;
		$Like = "";
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "alano";
		$Link = $p->url;
		$theloai =  "tin tuc";
	//	echo "Ten cua bai viet:";
		$Name = "";
		$TagTT ="";
		$Description = "";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('h1');
				foreach ($anchors as $element) 
				{		
				if($element->getAttribute("class") == "baiviet-title")	
					$Name = $element->nodeValue;
					echo "<br>";
				}
		if($Name == "")
			return;
		//echo "<br>";
		//echo "Tag của bài viết.<br>";
			$dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($p->url);
				$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("itemprop") == "keywords")
					{
						
						$TagTT ="$TagTT , $element->nodeValue  ";
					}
				}
		//echo "Ngay đang:";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('div');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "baiviet-ngay")
					{
						$charDT = $element->nodeValue;
						//echo $charDT;
						//$charDT = rtrim($charDT,"ngày");
						//echo $charDT;
						//$charDT = ltrim($charDT," AM");
						 $n = strcspn($charDT,",");
						// echo $n;
						//echo substr('abcdef', 1, 3);  // bcd
						$charDT = substr($charDT,$n+8,16);
						//$charDT = str_replace("|"," ",$charDT);
						$charDT = str_replace("/","-",$charDT);
						// echo $charDT;
						 $format = 'd-m-Y H:i';
						
						 $date = DateTime::createFromFormat($format, $charDT);
						// echo $date.Tostring();
						//if($date == null)
						//	echo "null";
						//echo $date;
						//echo $p->url;
						if($date != null)
							$charDT =  $date->format('Y-m-d H:i:s');
						// echo $charDT;
						break;
					}
				}
		
	//	echo "<br>";
		
	//	echo "Noi dung bsi viet:.<br>";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("class") == "text-conent")
					{				
					
						$Description = $element->nodeValue;	
					$n = strcspn($charDT,';	');
						// echo $n;
						$Description = substr($Description,$n + 107);
						//echo $Description;
					}
				}		
			
			
		
	if($Name !="")
	{
		$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
		if ($conn->connect_error) 
		{
		die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT * FROM `tintuc` WHERE `DuongLinkGoc` = '$Link'";
		$result = $conn->query($sql);
		//echo "$Link";
		//echo $result->num_rows;
		if ($result->num_rows == 0) 
		{
    // output data of each row
			//while($row = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
			$Link = mysqli_real_escape_string($conn,$Link);
			$sql = "INSERT INTO tintuc (DuongLinkGoc,TieuDe,TheLoai,Tag,NoiDungChinh,NgayDang)
				VALUES ('$Link', '$Name', '$theloai','$TagTT','$Description','$charDT')";
			echo "<br>";
			//echo $sql;
			$conn->query("set names 'utf8'");  
			if ($conn->query($sql) === TRUE) 
			{
				echo "New record created successfully";
			}
			else 
			{
				echo "error:" .$conn->error;
			//	echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		
		$conn->close();

	}
	}	

	function handleHeaderInfo(PHPCrawlerResponseHeader $header)
	{
  
		
	}
 }


$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL("http://www.24h.com.vn");
$crawler->setCrawlingDepthLimit(3);

$crawler->enableCookieHandling(true);


$crawler->go();

// At the end, after the process is finished, we print a short
// report (see method getProcessReport() for more information)
$report = $crawler->getProcessReport();
//echo $report->;
if (PHP_SAPI == "img") $lb = "\n";
else $lb = "<br />";
    
echo "Summary:".$lb;
echo "Links followed: ".$report->links_followed.$lb;
echo "Documents received: ".$report->files_received.$lb;
echo "Bytes received: ".$report->bytes_received." bytes".$lb;
echo "Process runtime: ".$report->process_runtime." sec".$lb; 



?>