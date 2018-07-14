<?php
error_reporting(0);
include 'phpcon/koneksi.php';
$sql = "SELECT * FROM  l_konfigurasi_ws  where id = 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();


$dataid = $data['consid_sep']; 
$secretKey = $data['secretkey_sep'];
$noSep = $_GET["noSep"] ;
$noTrans = $_GET["noTrans"] ;
$ppkPelayanan = $_GET["ppkPelayanan"] ;


$databpjs = '{
			"request":
			 {
			"t_map_sep":
				{
					"noSep":"'.$noSep.'",
					"noTrans":"'.$noTrans.'",
					"ppkPelayanan":"'.$ppkPelayanan.'"
				}
			 }
		}';


$url       = "http://192.168.1.104:8080/WsLokalRest/SEP/map/trans"; 
$port      = 8080; 

date_default_timezone_set('UTC');
$tStamp              = strval(time() - strtotime('1970-01-01 00:00:00'));
$signature           = hash_hmac('sha256', $dataid . "&" . $tStamp, $secretKey, true);
$encodedSignature    = base64_encode($signature);
$urlencodedSignature = urlencode($encodedSignature);


function post_request($url, $port, $dataid, $tStamp, $encodedSignature, $data, $referer = '')
{
  
	$url = parse_url($url);
	
	if ($url['scheme'] != 'http') {
		die('Error: Only HTTP request are supported !');
	}
	
	$host = $url['host'];
	$path = $url['path'];
	
	$fp = fsockopen($host, $port, $errno, $errstr, 50);
	if ($fp) {
		
		fputs($fp, "POST $path HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");
		
		if ($referer != '')
			fputs($fp, "Referer: $referer\r\n");
		
		fputs($fp, "x-cons-id: " . $dataid . "\r\n");
		fputs($fp, "x-timestamp: " . $tStamp . "\r\n");
		fputs($fp, "x-signature: " . $encodedSignature . "\r\n");
		fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: " . strlen($data) . "\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $data);
		
		$result = '';
		while (!feof($fp)) {
			$result .= fgets($fp, 128);
		}
	} else {
		return array(
			'status' => 'err',
			'error' => "$errstr ($errno)"
		);
	}
	
	fclose($fp);
	
	$result = explode("\r\n\r\n", $result, 2);
	$header  = isset($result[0]) ? $result[0] : '';
	$content = isset($result[1]) ? $result[1] : '';
	return array(
		'status' => 'ok',
		'header' => $header,
		'content' => $content
	);
	
}

$data = array(
	'Data' => $databpjs
);


$result = post_request($url, $port, $dataid, $tStamp, $encodedSignature, $databpjs, $referer = '');
if ($result['status'] == 'ok') {
	$resultstr = str_replace("re d sponse", "response", trim(preg_replace('/\s\s+/', ' ', $result['content'])));
	$r = $resultstr;
	$rr = substr_replace($r," ",-2); 
	$tt = str_replace('b5 ','', $rr); 
	$tt = substr($tt,2,strlen($tt));
	echo $tt;
} else {
	echo  'gagal bridging, hub. IT';
}

$conn->close();
?>

