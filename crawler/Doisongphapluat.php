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
		$Like = 0;
		$Comments = 0;
		$date = null;
		$nCommand=null;
		$nLike = null;
	//	echo "Ten cua bai viet:";
		$Name = "";
		$TagTT ="";
		$Description = "";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('p');
				foreach ($anchors as $element) 
				{	
				if($element->getAttribute("class") == "fl-right dt"){
						echo "asdsada";
						//$element2 = $element->childNodes;
						$Name = $element->nodeValue;
						echo $Name;
				}
						
				}
		if($Name =="")
			return;
		//echo "<br>";
		//echo "Tag của bài viết.<br>";
			$dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($p->url);
				$anchors = $dom->getElementsByTagName('meta');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("property") == "article:tag")
					{
						
						echo $TagTT ="$TagTT ,  $element->getAttribute('content')";
						
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
						
						$charDT = $element->nodeValue;
						//echo $charDT."<br>";
						//$gio =  rtrim($charDT,"AM,");
						//$ngay =  ltrim($charDT,"AM,");
						$gios = substr($charDT,0,5);
						$ngays = substr($charDT,10,10);
						
						$charDT = $ngays ." " . $gios;
						 $format = 'd-m-Y H:i';
						//echo $charDT."<br>";
						 $charDT = DateTime::createFromFormat($format, $charDT);
						// echo $date.Tostring();
						//if($date == null)
						//	echo "null";
						 $date =  $charDT->format('Y-m-d H:i:s');
						 echo $date;
					}
				}
		
	//	echo "<br>";
		
	//	echo "Noi dung bsi viet:.<br>";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('p');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("style") == "text-align: justify;")
					{				
									
						$Description ="$Description , $element->nodeValue";				
						//echo $element->getAttribute("p");
						//echo "<br>";
					
					}
				}		
				echo $Description;
$cmd ="cd " .__DIR__ ."|phantomjs conten.js \"$Link\" >source.html";
 exec( $cmd , $output,$s);
 $dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile("source.html");	
		$anchors = $dom->getElementsByTagName('label');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("id") == "total_comment")
					{				
					
						$nCommand = $element->nodeValue;				
						echo $nCommand ."<br>";	
						//sleep(10);
					}
				}
 $dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile("source.html");	
		$anchors = $dom->getElementsByTagName('iframe');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("title") == "fb:share_button Facebook Social Plugin")
					{				
									
						$LinkLike = $element->getAttribute('src');				
						echo $LinkLike;	
						//sleep(10);
					}
				}
			

$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
	 exec( $cmd , $output,$s);
	 $dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile("source.html");	
		$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("class") == "pluginCountTextConnected")
					{				
									
						$nLike = $element->nodeValue;				
						echo $nLike;	
						//sleep(10);
					}
				}
//$target = $p->url; // target URL

		//return implode("", $output);				
echo $Link;
	if($Name !="")
	{
		$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
		if ($conn->connect_error) 
		{
		die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT * FROM `news` WHERE `link_source` = '$Link'";
		$result = $conn->query($sql);
		//echo "$Link";
		//echo $result->num_rows;
		if ($result->num_rows == 0) 
		{
    // output data of each row
			//while($row = $result->fetch_assoc()) {
			//echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
			$Link = mysqli_real_escape_string($conn,$Link);
			$sql = "INSERT INTO news (link_source,title,category,tag,content,published_at,num_comment,num_like)
				VALUES ('$Link', '$Name', '$theloai','$TagTT','$Description','$charDT','$nCommand','$nLike')";
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