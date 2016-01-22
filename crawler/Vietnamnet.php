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
		$dbname = "alano_website";
		$Link = $p->url;
		$theloai =  "Thể thao";
	//	echo "Ten cua bai viet:";
		$Name = "";
		$TagTT ="";
		$Description = "";
		$nLike = 0;
		$nCommand = 0;
		$charDT = DateTime::createFromFormat('Y-m-d H:i:s', "00-00-0000 00-00");
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
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors = $dom->getElementsByTagName('h1');
				foreach ($anchors as $element) 
				{			
				if($element->getAttribute("class") == "title")
					  $Name = $element->nodeValue;
					//echo "<br>";
					//echo "<br>";
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
				$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("class") == "tags-list")
					{
						 $TagTT = $element->nodeValue;
						//echo "<br>";
					}
				}

			$dom = new DOMDocument('1.0');
			@$dom->loadHTMLFile($p->url);
			$anchors2 = $dom->getElementsByTagName('span');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "ArticleDate")
					{
						$charDT = $element->nodeValue;
						//echo $charDT;
						//$charDT = rtrim($charDT,"ngày");
						//echo $charDT;
						//$charDT = ltrim($charDT," AM");
						// $n = strcspn($charDT,",");
						// echo $n;
						//echo substr('abcdef', 1, 3);  // bcd
						$charDT2 = substr($charDT,14,5);
						
						$charDT = substr($charDT,0,10);
						$charDT= $charDT ." " .$charDT2;
						////echo $charDT;
						//$charDT = str_replace("|"," ",$charDT);
						$charDT = str_replace("/","-",$charDT);
						
						 //echo $charDT;
						 $format = 'd-m-Y H:i';
						
						 $date = DateTime::createFromFormat($format, $charDT);
						// echo $date;
						if($date != null)
							$charDT =  $date->format('Y-m-d H:i:s');
						else
							$charDT = DateTime::createFromFormat($format, "00-00-0000 00-00");
						//echo $charDT;
						//echo "<br>";
						break;
					}
				}

		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("class") == "ArticleContent")
					{				
									
					 	$Description = $element->nodeValue;				
					
					}
				}
				$Description = trim($Description);
$HSource = "source"  ."$IName" .".html";
//$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
$cmd =__DIR__ ."\Driver\Debug\Crawler.exe \"$Link\" $HSource";
$HSource = "SourceWeb\source"  ."$IName" .".html";
 exec( $cmd , $output,$s);
 
 
 $dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($HSource);	
		$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("class") == "fmsidWidgetCommentListCount")
					{				
							
						$nCommand = $element->nodeValue;			
												
						echo $nCommand;	
						//sleep(10);
					}
				}
	$LinkLike = null;
	
 $dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($HSource);	
		$anchors = $dom->getElementsByTagName('iframe');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("title") == "fb:like Facebook Social Plugin")
					{				
							
						$LinkLike = $element->getAttribute('src');			
						break;						
						//echo $LinkLike;	
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
						
						echo $nLike ."<br>";	
						//sleep(10);
					}
				}
	if (strpos($nLike,'k') == true) {
		$nLike =  str_replace("k","",$nLike);
		 $nLike =  $nLike * 1000;
		//echo $nLike;
	}
}	

	unlink($HSource);
			$Description = str_replace("'","",$Description);
			$Description = str_replace("\"","",$Description);
			$Name = str_replace("\"","",$Name);
			$Name = str_replace("\"","",$Name);

			$Description = mysqli_real_escape_string($conn,$Description);
			$Name = mysqli_real_escape_string($conn,$Name);
			$TagTT = mysqli_real_escape_string($conn,$TagTT);
			$sql = "INSERT INTO news (link_source,title,category,tag,content,published_at,num_comment,num_like,linklike)
				VALUES ('$Link', '$Name', '$theloai','$TagTT','$Description','$charDT','$nCommand','$nLike','$LinkLike')";
			
			//echo $sql;
			$conn->query("set names 'utf8'");  
			$conn->query("set names 'utf8'");  
			if ($conn->query($sql) === TRUE) 
			{
				echo "New record created successfully: url = " .$Link ."<br>";
			}
			else 
			{
				echo "error: url = " .$Link .$conn->error ."<br>";
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
				$HSource = "source"  ."$IName" .".html";
			//$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
			$cmd =__DIR__ ."\Driver\Debug\Crawler.exe \"$Link\" $HSource";
			$HSource = "SourceWeb\source"  ."$IName" .".html";
			 exec( $cmd , $output,$s);
			 
			 
			 $dom = new DOMDocument('1.0');
					@$dom->loadHTMLFile($HSource);	
					$anchors = $dom->getElementsByTagName('span');
							foreach ($anchors as $element) 
							{		
								if($element->getAttribute("class") == "fmsidWidgetCommentListCount")
								{				
										
									$nCommand = $element->nodeValue;			
															
									echo $nCommand;	
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
			
			$sql = "UPDATE news SET num_like = '$nLike' , num_comment = '$nCommand' WHERE id='$id'";

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
$crawler->setURL("http://vietnamnet.vn/vn/chinh-tri/285748/nhan-su-duoc-rut-hay-khong-do-dai-hoi-quyet-dinh.html");
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