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
	{ $servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "alano";
		$Link = $p->url;
		$theloai =  "tin tuc";
		$NgayDang = "";
	//	echo "Ten cua bai viet:";
		$Name = "";
		$TagTT ="";
		$Description = "";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('h1');
				foreach ($anchors as $element) 
				{	
				
						$Name= $element->nodeValue;
						//echo "<br>";
				
				}
		
		//echo "<br>";
		//echo "Tag của bài viết.<br>";
			$dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($p->url);
				$anchors = $dom->getElementsByTagName('meta');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("property") == "article:tag")
					{
						
						$TagTT ="$TagTT ,  $element->getAttribute('content')";
						
						//echo "<br>";
					}
				}
		//echo "Ngay dang:";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('p');
				foreach ($anchors2 as $element) 
				{				
					
					if($element->getAttribute("class") == "fl-right dt")
					{
						//echo "có.<br>";
						$NgayDang = $element->nodeValue;
						//echo  $element->getAttribute('href');
						//$s1 = CopyPartString($element->getAttribute('href'),"/","/");
						//echo "<br>";
					}
				}
		
	//	echo "<br>";
		
	//	echo "Noi dung bsi viet:.<br>";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('p');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("itemprop") == "description")
					{				
									
						$Description = $element->nodeValue;				
						//echo $element->getAttribute("p");
						//echo "<br>";
					}
				}		
			
			
		//$myfile = fopen("testfile.txt", "w");
		//fwrite($myfile, $p->source );
			//echo $p->source;
	//	echo "1: $p->header.<br>.$p->url.<br>";
	//$arrayTitle = $p->meta_attributes;
	//echo $arrayTitle[1];
	
	//	foreach ($arrayTitle as $tags)
	//	{
	//		echo "$tags.<br>";
			
	//	}
	//	echo "=------------------------------------------------------s.<br>";
	//fclose($myfile);
	
	if($Name !="")
	{
		$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
		if ($conn->connect_error) 
		{
		die("Connection failed: " . $conn->connect_error);
		}

		$sql = "INSERT INTO tintuc (DuongLinkGoc,TieuDe,TheLoai,Tag,NoiDungChinh,)
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
$crawler->setURL("http://www.doisongphapluat.com");
$crawler->setCrawlingDepthLimit(1);
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