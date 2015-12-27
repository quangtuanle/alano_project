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
		$depth = 3;
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "alano";
		$Link = $p->url;
		$theloai =  "tin tuc";
	//	echo "Ten cua bai viet:";
		$Name = "";
		$Like = "";
		$TagTT ="";
		$Description = "";
		$date = null;
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{
					//echo "<br>asdaasd";
					if($element->getAttribute("class") == "watch-title ")
					{
						$Name =  $element->getAttribute("title");
						
					}
				}
		if($Name == "")
			return;

		// "Ngày Đăng:";
		
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('strong');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "watch-time-text")
					{
						$charDT = $element->nodeValue;
						//echo $charDT;
						//$charDT = rtrim($charDT,"GMT+7 ");
						 //$n = strcspn($charDT,",");
						// echo $n;
						//echo substr('abcdef', 1, 3);  // bcd
						//echo strlen($charDT);
						$charDT = substr($charDT,19,14);
						$charDT = str_replace("thg","",$charDT);
						$charDT = str_replace("  ","-",$charDT);
						$charDT = str_replace(" ","-",$charDT);
						$charDT = str_replace(",","",$charDT);
						// echo $charDT;
						 $format = 'd-m-Y';
						
						 $date = DateTime::createFromFormat($format, $charDT);
						// echo $date.Tostring();
						//if($date == null)
						//	echo "null";
						 $charDT =  $date->format('Y-m-d H:i:s');
						 
						break;
					}
				}
		$n = 0;
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{
					
					$namesd = $element->nodeValue;
					$namesd = rtrim($namesd," ");
					if (is_numeric($namesd))
					{
						$n++;
						if($n == 2 )
						{
							$namesd = str_replace(".","",$namesd);
							$Like = $namesd ;
							break;
						}
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
			$sql = "INSERT INTO tintuc (DuongLinkGoc,TieuDe,TheLoai,Tag,NoiDungChinh,NgayDang,SoLuotLike)
				VALUES ('$Link', '$Name', '$theloai','$TagTT','$Description','$charDT','$Like')";
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
    // If the content-type of the document isn't "text/html" -> don't receive it.
		//if ($header->content_type != "text/html")
		//{
		//  return -1;
		//}   
		//echo "$header->header_raw.<br>";
		
		
	}
 }
// Extend the class and override the handleDocumentInfo()-method 


// Now, create a instance of your class, define the behaviour
// of the crawler (see class-reference for more options and details)
// and start the crawling-process.

$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL("https://www.youtube.com");
$crawler->setCrawlingDepthLimit(0);
// Only receive content of files with content-type "text/html"
//$crawler->addContentTypeReceiveRule("#text/html#");

// Ignore links to pictures, dont even request pictures
//$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");

// Store and send cookie-data like a browser does
$crawler->enableCookieHandling(true);

// Set the traffic-limit to 1 MB (in bytes,
// for testing we dont want to "suck" the whole site)
//     $crawler->setTrafficLimit(1000000 * 1024);
//
// echo "URL: ".$PageInfo->url."<br />";
 //$PageInfo = new PHPCrawlerDocumentInfo();

//$crawler->handleDocumentInfo($PageInfo);
//$crawler->handleDocumentInfo($PageInfo);
// Thats enough, now here we go
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
//echo $crawler->url;
	//echo $pageurl;
$PageInfo = new PHPCrawlerDocumentInfo();


?>