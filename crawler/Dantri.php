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
		$nCommand = null;
		$LinkLike = "";
		$nLike = null;
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('h1');
				foreach ($anchors as $element) 
				{			
					 $Name = $element->nodeValue;
					//echo "<br>";
				}
				
	$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('span');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "fr fon7 mr2 tt-capitalize")
					{
						$charDT = $element->nodeValue;
						//echo $charDT;
						//$charDT = rtrim($charDT,"ngày");
						//echo $charDT;
						//$charDT = ltrim($charDT," AM");
						 $n = strcspn($charDT,",");
						// echo $n;
						//echo substr('abcdef', 1, 3);  // bcd
						$charDT = substr($charDT,$n+2,18);
						////echo $charDT;
						//$charDT = str_replace("|"," ",$charDT);
						$charDT = str_replace("-","",$charDT);
						$charDT = str_replace("/","-",$charDT);
						// echo $charDT;
						 $format = 'd-m-Y H:i';
						
						 $date = DateTime::createFromFormat($format, $charDT);
						// echo $date;
						if($date != null)
							$charDT =  $date->format('Y-m-d H:i:s');
						//echo $charDT;
						break;
					}
				}
		
			$dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($p->url);
				$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("class") == "news-tag-list")
					{
						 $TagTT = $element->nodeValue;

					}
				}

		

		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("id") == "divNewsContent")
					{				
									
						$Description = $element->nodeValue;				
					//echo $Description;
					}
				}	

$cmd ="cd " .__DIR__ ."|phantomjs conten.js \"$Link\" >source.html";
 exec( $cmd , $output,$s);

 $dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile("source.html");	
		$anchors = $dom->getElementsByTagName('iframe');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("title") == "fb:like Facebook Social Plugin")
					{				
									
						$LinkLike = $element->getAttribute('src');				
						//echo $LinkLike;	
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
					
						//sleep(10);
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
			$sql = "INSERT INTO news (link_source,title,category,tag,content,published_at,num_like)
				VALUES ('$Link', '$Name', '$theloai','$TagTT','$Description','$charDT','$nLike')";
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
$crawler->setURL("http://dantri.com.vn/giao-duc-khuyen-hoc/be-trai-bi-co-giao-bao-hanh-vi-te-dam-chu-co-so-mam-non-cong-khai-xin-loi-20151226101855042.htm");
$crawler->setCrawlingDepthLimit(0);

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