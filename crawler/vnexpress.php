<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<?php
// It may take a whils to crawl a site ...
set_time_limit(10000);
$myfile = fopen("testfile.txt", "w");
$depth =2;
// Inculde the phpcrawl-mainclass
include("PHPCrawl_083/libs/PHPCrawler.class.php");
$arryTitle = array('title_news','relative_new','txt_tag');


	
// Create connection
		
class MyCrawler extends PHPCrawler 
{
	
	function handleDocumentInfo(PHPCrawlerDocumentInfo $p)
	{ 
		$depth = 3;
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
		$date = null;
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('h1');
				foreach ($anchors as $element) 
				{	if($element->getAttribute("class") == "title_detail_video width_common")	
						return;
					$Name = $element->nodeValue;
					echo "<br>";
				}
		if($Name =="")
			return;
			$dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($p->url);
				$anchors = $dom->getElementsByTagName('a');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("class") == "tag_item")
					{
						$TagTT ="$TagTT , $element->nodeValue  ";

					}
				}

		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('div');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "block_timer left txt_666")
					{
						$charDT = $element->nodeValue;
						//echo $charDT;
						$charDT = rtrim($charDT,"GMT+7 ");
						 $n = strcspn($charDT,",");
						// echo $n;
						//echo substr('abcdef', 1, 3);  // bcd
						$charDT = substr($charDT,$n+2,18);
						$charDT = str_replace("|"," ",$charDT);
						$charDT = str_replace("/","-",$charDT);
						// echo $charDT;
						 $format = 'd-m-Y H:i';
						
						 $date = DateTime::createFromFormat($format, $charDT);
						// echo $date.Tostring();
						//if($date == null)
						//	echo "null";
					//echo $date;
					echo $p->url;
					if($date != null)
						$charDT =  $date->format('Y-m-d H:i:s');
						 
						break;
					}
				}

		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("class") == "fck_detail width_common")
					{				
									
						$Description = $element->nodeValue;				
					
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
$crawler->setURL("http://vnexpress.net");
$crawler->setCrawlingDepthLimit(1);

$crawler->enableCookieHandling(true);

$crawler->go();

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