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
					if($element->getAttribute("class") =="title")
					
					$Name = $element->nodeValue;
					//echo "<br>";
				}

			$dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($p->url);
				$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("class") == "block art-tag pkg")
					{
						$TagTT ="$TagTT , $element->nodeValue  ";

					}
				}

		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('a');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "btn_quantam")
					{
						echo $element->getAttribute("total-like");
	
					}
				}

		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("id") == "main-detail")
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

		$sql = "INSERT INTO tintuc (DuongLinkGoc,TieuDe,TheLoai,Tag,NoiDungChinh)
		VALUES ('.$Link.', '.$Name.', '.$theloai.','.$TagTT.','.$Description.')";
		
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
$conn->close();

	}
	
}	

	function handleHeaderInfo(PHPCrawlerResponseHeader $header)
	{

	}
 }


$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL("http://www.nguoiduatin.vn");
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