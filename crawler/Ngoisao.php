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
		$theloai =  "Giải trí";
	//	echo "Ten cua bai viet:";
		$Name = "";
		$TagTT ="";
		$Description = "";
		$nCommand=null;
		$nLike = null;
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('h1');
				foreach ($anchors as $element) 
				{			
					if($element->getAttribute("class") == "title")
					{
						 $Name = $element->nodeValue;
							echo $Name;
					}
					
				//	echo "<br>";
				}

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
		$anchors2 = $dom->getElementsByTagName('span');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "spanDateTime fl")
					{
						$charDT = $element->nodeValue;
						//echo $charDT;
						//$charDT = rtrim($charDT,"ngày");
						//echo $charDT;
						//$charDT = ltrim($charDT," AM");
						 $n = strcspn($charDT,",");
						// echo $n;
						//echo substr('abcdef', 1, 3);  // bcd
						$charDT = substr($charDT,$n+2,16);
						////echo $charDT;
						//$charDT = str_replace("|"," ",$charDT);
						$charDT = str_replace("/","-",$charDT);
						// echo $charDT;
						 $format = 'd-m-Y H:i';
						
						 $date = DateTime::createFromFormat($format, $charDT);
						// echo $date;
						if($date != null)
							$charDT =  $date->format('Y-m-d H:i:s');
						echo $charDT;
						break;
					}
				}

		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('p');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("class") == "Normal")
					{				
									
						$Description = $element->nodeValue;				
						echo $Description;
					}
				}		

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
						echo $nLike;	
						//sleep(10);
					}
				}
//$target = $p->url; // target URL

		//return implode("", $output);				
//echo $Link;
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
			$Name = mysqli_real_escape_string($conn,$Name);
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

	}
 }


$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL("http://ngoisao.net/tin-tuc/cuoi-hoi/co-dau/diem-trang-dien-vay-cuoi-70-trieu-do-chong-mua-tang-3334052.html");
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