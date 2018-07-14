<?php

$databpjs = '{
		   "request": {
			  "t_sep": {
				 "noKartu": "0001015765964",
				 "tglSep": "2018-03-19",
				 "ppkPelayanan": "1111R010",
				 "jnsPelayanan": "2",
				 "klsRawat": "3",
				 "noMR": "12345",
				 "rujukan": {
					"asalRujukan": "1",
					"tglRujukan": "2018-03-18",
					"noRujukan": "1234567",
					"ppkRujukan": "11110201"
				 },
				 "catatan": "test",
				 "diagAwal": "S52.50",
				 "poli": {
					"tujuan": "IGD",
					"eksekutif": "0"
				 },
				 "cob": {
					"cob": "0"
				 },
				 "jaminan": {
					"lakaLantas": "1",
					"penjamin": "1",
					"lokasiLaka": "Jakarta"
				 },
				 "noTelp": "081919999",
				 "user": "Coba Ws"
			  }
		   }
		}   ';



$dataid    = "7910";
$secretKey = "8dY0BD285F";

$localIP   = "dvlp.bpjs-kesehatan.go.id";
$port      = 8081;
$cat = "/SEP/insert ";
$url       = "http://".$localIP.":".$port."/VClaim-rest".$cat; 

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
	$objJson = json_decode($r,true);
	echo "<pre>";
	print_r($objJson); 
	echo "</pre>";	
} else {
	
}

?>

