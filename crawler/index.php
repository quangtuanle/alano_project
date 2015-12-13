<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<?php
 set_time_limit(300000); 
 //$payload = file_get_contents('http://localhost:8080/vnexpress.php');
// $lines = file('http://localhost:8080/vnexpress.php');
 // create both cURL resources
 $n =1;
 while(1)
{
$ch1 = curl_init();
$ch2 = curl_init();
$ch3 = curl_init();
$ch4 = curl_init();
$ch5 = curl_init();


// set URL and other appropriate options
curl_setopt($ch1, CURLOPT_URL, 'http://localhost:8080/vnexpress.php');
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_setopt($ch2, CURLOPT_URL, "http://localhost:8080/24h.php");
curl_setopt($ch2, CURLOPT_HEADER, 0);
curl_setopt($ch3, CURLOPT_URL, "http://localhost:8080/Youtube.php");
curl_setopt($ch3, CURLOPT_HEADER, 0);
curl_setopt($ch4, CURLOPT_URL, "http://localhost:8080/Doisongphapluat.php");
curl_setopt($ch4, CURLOPT_HEADER, 0);
curl_setopt($ch5, CURLOPT_URL, "http://localhost:8080/Nguoiduatin.php");
curl_setopt($ch5, CURLOPT_HEADER, 0);


//create the multiple cURL handle
$mh = curl_multi_init();

//add the two handles
curl_multi_add_handle($mh,$ch1);
curl_multi_add_handle($mh,$ch2);
curl_multi_add_handle($mh,$ch3);
curl_multi_add_handle($mh,$ch4);
curl_multi_add_handle($mh,$ch5);


	echo "crawler lan $n <br>";
	$running=null;
//execute the handles
	do {
		curl_multi_exec($mh,$running);
		//echo "dang chay $n <br>";
	} while($running > 0);
	sleep(300);
	$n++;
}
//close all the handles
//curl_multi_remove_handle($mh, $ch1);
//curl_multi_remove_handle($mh, $ch2);
//curl_multi_remove_handle($mh, $ch2);
//curl_multi_remove_handle($mh, $ch2);
//curl_multi_close($mh);

 
?>