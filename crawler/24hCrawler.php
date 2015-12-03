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
					$Name = $element->nodeValue;
					echo "<br>";
				}
		
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
					//	echo "có.<br>";
					//	echo $element->nodeValue;
						//echo  $element->getAttribute('href');
						//$s1 = CopyPartString($element->getAttribute('href'),"/","/");
					//	echo "<br>";
					}
				}
		
	//	echo "<br>";
		
	//	echo "Noi dung bsi viet:.<br>";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("itemprop") == "articleBody")
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
		//$conn->query($sql);
			$conn->query("set names 'utf8'");  
			if ($conn->query($sql) === TRUE) 
			{
				echo "New record created successfully";
			}
			else 
			{
			//	echo "Error: " . $sql . "<br>" . $conn->error;
			}
$conn->close();
	}
	}	


 }


$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL("http://www.24h.com.vn");
$crawler->setCrawlingDepthLimit(1);

$crawler->enableCookieHandling(true);


$crawler->go();


$report = $crawler->getProcessReport();

if (PHP_SAPI == "img") $lb = "\n";
else $lb = "<br />";
    
echo "Summary:".$lb;
echo "Links followed: ".$report->links_followed.$lb;
echo "Documents received: ".$report->files_received.$lb;
echo "Bytes received: ".$report->bytes_received." bytes".$lb;
echo "Process runtime: ".$report->process_runtime." sec".$lb; 

?>
