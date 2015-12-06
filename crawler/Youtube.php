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
		echo "$p->url.<br>";
		//echo "The loai: Tin tuc<br>";	
		echo "Ten cua bai viet:";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{
					//echo "<br>asdaasd";
					if($element->getAttribute("class") == "watch-title ")
					{
						echo $element->getAttribute("title");
						echo "<br>";
					}
				}
		

		echo "Ngày Đăng:";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('strong');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "watch-time-text")
					{
						
						echo $element->nodeValue;
						//echo  $element->getAttribute('href');
						//$s1 = CopyPartString($element->getAttribute('href'),"/","/");
						echo "<br>";
					}
				}
		
		echo "<br>";

			
			
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
$crawler->setURL("https://www.youtube.com/watch?v=BbPAR18CeB8");
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
