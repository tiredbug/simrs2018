<?php

if(!isset($_GET["nomor_kartu"])) exit(0);
if(!isset($_GET["tglSEP"])) exit(0);

$printarr=false;
$extraparam="";
$nomor_kartu = $_GET['nomor_kartu']; //"0000082005118";
$tglSEP = $_GET['tglSEP']; //"2018-03-08";

$printarr=true;
$cat = "/Peserta/nokartu/".$nomor_kartu."/tglSEP/".$tglSEP." ";

$dataid    = "7910"; 
$secretKey = "8dY0BD285F"; 
$localIP   = "dvlp.bpjs-kesehatan.go.id";
$port      = 8081; 
$url       = "http://".$localIP.":".$port."/VClaim-rest".$cat; 

date_default_timezone_set('UTC');
$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
$signature = hash_hmac('sha256', $dataid."&".$tStamp, $secretKey, true);
$encodedSignature = base64_encode($signature);
$urlencodedSignature = urlencode($encodedSignature);



$opts = array(
 'http'=>array(
 'method'=>"GET",
 'header'=>"Host: api.asterix.co.id\r\n".
 "Connection: close\r\n".
 "X-timestamp: ".$tStamp."\r\n".
 "X-signature: ".$encodedSignature."\r\n".
 "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64)\r\n".
 "X-cons-id: ".$dataid."\r\n".
 "Accept: application/json\r\n"
 )
);

$context = stream_context_create($opts);
$url=$url;
$result = file_get_contents($url, false, $context);
//echo "<br>Respon:";
if ($result === false) 
{ 
 echo "Tidak dapat menyambung ke server"; 
 
} else {
 
 //echo $result;
 if($printarr==true){
	//echo "<pre>";
	//print_r(json_decode($result, true)); 
	//echo "</pre>";
	//$hasil = json_decode($result, true);
	//$row_set[] = $hasil;
	//echo json_encode($row_set);
	echo $result;
 }

 }

?>

