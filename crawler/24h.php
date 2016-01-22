<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<?php

// It may take a whils to crawl a site ...
set_time_limit(10000);
$myfile = fopen("testfile.txt", "w");
$depth =2;
// Inculde the phpcrawl-mainclass
include("PHPCrawl_083/libs/PHPCrawler.class.php");
//$arryTitle = array('title_news','relative_new','txt_tag');

class MyCrawler extends PHPCrawler 
{
	
	function handleDocumentInfo(PHPCrawlerDocumentInfo $p)
	{ 
		$date = null;
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "alano_website";
		$Link = $p->url;
		$theloai =  "tin tuc";
	//	echo "Ten cua bai viet:";
		$Name = "";
		$TagTT ="";
		$nLike= null;
		$nShare = null;
		$LinkLike="";
		$LinkShare="";
		$Description = "";
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
				if($element->getAttribute("class") == "baiviet-title")	
					 $Name = $element->nodeValue;
				// echo $Name;
				//	echo "<br>";
					
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
				$anchors = $dom->getElementsByTagName('span');
				foreach ($anchors as $element) 
				{
					
					if($element->getAttribute("itemprop") == "keywords")
					{
						
						$TagTT ="$TagTT , $element->nodeValue  ";
					}
				}
				//echo $TagTT;
		//echo "Ngay đang:";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);
		$anchors2 = $dom->getElementsByTagName('div');
				foreach ($anchors2 as $element) 
				{					
					if($element->getAttribute("class") == "baiviet-ngay")
					{
						$charDT = $element->nodeValue;
						//echo $charDT;
						//$charDT = rtrim($charDT,"ngày");
						//echo $charDT;
						//$charDT = ltrim($charDT," AM");
						 $n = strcspn($charDT,",");
						// echo $n;
						//echo substr('abcdef', 1, 3);  // bcd
						$charDT = substr($charDT,$n+8,16);
						//$charDT = str_replace("|"," ",$charDT);
						$charDT = str_replace("/","-",$charDT);
						// echo $charDT;
						 $format = 'd-m-Y H:i';
						
						 $date = DateTime::createFromFormat($format, $charDT);
						// echo $date.Tostring();
						//if($date == null)
						//	echo "null";
						//echo $date;
						//echo $p->url;
						if($date != null)
							$charDT =  $date->format('Y-m-d H:i:s');
						//echo $charDT;
						break;
					}
				}
		
	//	echo "<br>";
		
	//	echo "Noi dung bsi viet:.<br>";
		$dom = new DOMDocument('1.0');
		@$dom->loadHTMLFile($p->url);	
		$anchors = $dom->getElementsByTagName('div');
				foreach ($anchors as $element) 
				{		
					if($element->getAttribute("class") == "text-conent")
					{				
					
						$Description = $element->nodeValue;	
					$n = strcspn($charDT,';	');
						// echo $n;
						$Description = substr($Description,$n + 110);
						//echo $Description;
					}
				}	
				$Description = trim($Description);				
	// like share		
		$HSource = "SourceWeb\source"  ."$IName" .".html";
		//echo $HSource;
		$cmd ="cd " .__DIR__ ."|phantomjs conten.js \"$Link\" > $HSource";
		 exec( $cmd , $output,$s);
		 $n = 0;
		$dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($HSource);	
				$anchors = $dom->getElementsByTagName('iframe');
						foreach ($anchors as $element) 
						{		
							if($element->getAttribute("title") == "fb:share_button Facebook Social Plugin")
							{				
								$LinkShare = $element->getAttribute('src');				
								//echo "<br>" .$LinkShare;	
								
								//sleep(10);
							}
							if($element->getAttribute("title") == "fb:like Facebook Social Plugin")
							{			
								$n++;
								if($n == 3)
								{
								$LinkLike = $element->getAttribute('src');				
								//echo "<br>" .$LinkLike;	
								
								}
								
								//sleep(10);
							}
						}
		if($LinkShare != null)
		{
			$HSource = "source"  ."$IName" .".html";
		//$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
		$cmd =__DIR__ ."\Driver\Debug\Crawler.exe \"$LinkShare\" $HSource";
		$HSource = "SourceWeb\source"  ."$IName" .".html";
			 exec( $cmd , $output,$s);
			 $dom = new DOMDocument('1.0');
				@$dom->loadHTMLFile($HSource);	
				$anchors = $dom->getElementsByTagName('span');
						foreach ($anchors as $element) 
						{		
							if($element->getAttribute("class") == "pluginCountTextConnected")
							{				
											
								$nShare = $element->nodeValue;				
								//echo "<br>" .$nShare;	
								//sleep(10);
							}
						}
			if (strpos($nShare,'k') == true) {
				$nShare =  str_replace("k","",$nShare);
				$nLike =  str_replace(",",".",$nLike);
				 $nShare =  $nShare * 1000;
				//echo $nShare;
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
								//echo "<br>" .$nLike;	
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
				
			$Description = mysqli_real_escape_string($conn,$Description);
			$Name = mysqli_real_escape_string($conn,$Name);
			$TagTT = mysqli_real_escape_string($conn,$TagTT);
			$sql = "INSERT INTO news (link_source,title,category,tag,content,published_at,num_like,num_share,linklike,linkshare)
				VALUES ('$Link', '$Name', '$theloai','$TagTT','$Description','$charDT','$nLike','$nShare','$LinkLike','$LinkShare')";
			
			//echo $sql;
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
				$LinkShare = $aValue[]=$myrow["linkshare"];
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

				if($LinkShare != null)
				{
					$HSource = "source"  ."$IName" .".html";
				//$cmd =__DIR__ ."\Debug\Crawler.exe \"$LinkLike\"" ;
				$cmd =__DIR__ ."\Driver\Debug\Crawler.exe \"$LinkShare\" $HSource";
				$HSource = "SourceWeb\source"  ."$IName" .".html";
					 exec( $cmd , $output,$s);
					 $dom = new DOMDocument('1.0');
						@$dom->loadHTMLFile($HSource);	
						$anchors = $dom->getElementsByTagName('span');
								foreach ($anchors as $element) 
								{		
									if($element->getAttribute("class") == "pluginCountTextConnected")
									{				
													
										$nShare = $element->nodeValue;				
										//echo "<br>" .$nShare;	
										//sleep(10);
									}
								}
					if (strpos($nShare,'k') == true) 
					{
						$nShare =  str_replace("k","",$nShare);
						$nLike =  str_replace(",",".",$nLike);
						 $nShare =  $nShare * 1000;
						//echo $nShare;
					}
				}

				unlink($HSource);
			}
			
			$sql = "UPDATE news SET num_like = '$nLike' , num_share = '$nShare' WHERE id='$id'";

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
$crawler->setURL("http://www.24h.com.vn/am-thuc/cach-muoi-dua-cai-ngon-gion-vang-uom-c460a765028.html");
$crawler->setCrawlingDepthLimit(0);

$crawler->enableCookieHandling(true);


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



?>