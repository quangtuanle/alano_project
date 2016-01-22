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
		$dbname = "alano_website";
		$Link = $p->url;
		$theloai =  "tin tuc";
	//	echo "Ten cua bai viet:";
		$Name = "";
		$TagTT ="";
		$Description = "";
		$nCommand = null;
		$LinkLike = "";
		$nLike = null;
// check connection database
		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) 
		{
		die("Connection failed: " . $conn->connect_error);
		return;
		}
//check link is exist in "Link not Crawler"
		$Link = mysqli_real_escape_string($conn,$Link);
		$sql = "SELECT * FROM `linknotcrawler` WHERE `Link` = '$Link'";
		$result = $conn->query($sql);
// process is not exist		
		if ($result->num_rows > 0) 
		{
			return;
		}
//load name	
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('h1');
				foreach ($anchors as $element) 
				{			
				if($element-> getAttribute("class") == "fon31 mgb15")
					 $Name = $element->nodeValue;
					//echo "<br>";
					$Name = trim($Name);
				}
		if($Name =="")
			return;
		$IName = 0;
		$LName = strlen($Name);
		for($i = 0; $i<$LName; $i++)
		{
			$IName += ord($Name[$i]);
		}

		//check is exist
		$Link = mysqli_real_escape_string($conn,$Link);
		$sql = "SELECT * FROM `news` WHERE `link_source` = '$Link'";
		$result = $conn->query($sql);
		//echo "$Link";
		//echo $result->num_rows;
		
		if ($result->num_rows == 0) 
		{		
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
						//	$Description = substr($Description,13);
							}
						}	
						$Description = trim($Description);

		$HSource = "source"  ."$IName" .".html";
		//$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
		$cmd =__DIR__ ."\Driver\Debug\Crawler.exe \"$Link\" $HSource";
		$HSource = "SourceWeb\source"  ."$IName" .".html";
		 exec( $cmd , $output,$s);
			
		$LinkLike = null;
		 $dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($HSource);	
				$anchors = $dom->getElementsByTagName('iframe');
						foreach ($anchors as $element) 
						{		
							if($element->getAttribute("title") == "fb:like Facebook Social Plugin")
							{				
											
								$LinkLike = $element->getAttribute('src');				
								 $LinkLike;	
								break;
								//sleep(10);
							}
						}	
						
			
		if($LinkLike != null)
		{
			$HSource = "source"  ."$IName" .".html";
		//$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
		$cmd =__DIR__ ."\Driver\Debug\Crawler.exe \"$LinkLike\" $HSource";
		$HSource = "SourceWeb\source"  ."$IName" .".html";
			 exec( $cmd , $output,$s);
			 $dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($HSource);	
				$anchors = $dom->getElementsByTagName('span');
						foreach ($anchors as $element) 
						{		
							if($element->getAttribute("class") == "pluginCountTextConnected")
							{				
											
								 $nLike = $element->nodeValue;				
							
								//sleep(10);
							}
						}					
		if (strpos($nLike,'k') == true) {
				$nLike =  str_replace("k","",$nLike);
				$nLike =  str_replace(",",".",$nLike);
				 $nLike =  $nLike * 1000;
				//echo $nLike;
			}
		}	

			unlink($HSource);
			
			$Description = mysqli_real_escape_string($conn,$Description);
			$Name = mysqli_real_escape_string($conn,$Name);
			$TagTT = mysqli_real_escape_string($conn,$TagTT);
			
			$sql = "INSERT INTO news (link_source,title,category,tag,content,published_at,num_like,linklike)
			VALUES ('$Link', '$Name', '$theloai','$TagTT','$Description','$charDT','$nLike','$LinkLike')";
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
		$result->close();
		$conn->close();
		}
				
		
		else
		{
			$id = null;
			while ($myrow = $result->fetch_array(MYSQLI_ASSOC))
			{
				$id =  $aValue[]=$myrow["id"];
				$LinkLike = $aValue[]=$myrow["linklike"];
			}
			$result->close();
			if($id != null)
			{
				if($LinkLike != null)
				{
					$HSource = "source"  ."$IName" .".html";
					//$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
					$cmd =__DIR__ ."\Driver\Debug\Crawler.exe \"$LinkLike\" $HSource";
					$HSource = "SourceWeb\source"  ."$IName" .".html";
					exec( $cmd , $output,$s);

					$dom = new DOMDocument('1.0');
					@$dom->loadHTMLFile($HSource);	
					$anchors = $dom->getElementsByTagName('span');
						foreach ($anchors as $element) 
						{		
						
							if($element->getAttribute("class") == "pluginCountTextConnected")
							{				
								 $nLike = $element->nodeValue;
								
								//echo $nLike ."<br>";	
								//sleep(10);
							}
						}
					if (strpos($nLike,'k') == true) 
					{
					$nLike =  str_replace("k","",$nLike);
					$nLike =  $nLike * 1000;
					//echo $nLike;
					}
				}	

				unlink($HSource);
			}
			
			$sql = "UPDATE news SET num_like = '$nLike'  WHERE id='$id'";

			if ($conn->query($sql) === TRUE) 
			{
				echo "Record updated successfully: id = " .$id ."<br>";
			} 
			else 
			{
			echo "Error updating record: id = " .$id ." " .$conn->error ."<br>";
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
$crawler->setURL("http://dantri.com.vn/the-gioi/my-phan-no-vi-video-thuy-thu-quy-goi-truoc-binh-sy-iran-20160119082404452.htm");
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