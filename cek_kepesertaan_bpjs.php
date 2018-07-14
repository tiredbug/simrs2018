<?php
error_reporting(0);
//require("koneksi.php");
//include 'phpcon/koneksi.php';
require("phpcon/koneksi.php");

$sql = "SELECT * FROM  l_konfigurasi_ws  where id = 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

$id_admission = $_GET["id_admission"] ;
$nomor_kartu = $_GET["nomor_kartu"] ; 
$consumer_id = $data['consid_sep']; 
$secretKey = $data['secretkey_sep'];

$url = "http://192.168.1.104:8080/WsLokalRest/Peserta/Peserta/"; 
date_default_timezone_set('UTC');
$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
$signature = hash_hmac('sha256', $consumer_id."&".$tStamp, $secretKey, true);
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
 "X-cons-id: ".$consumer_id."\r\n".
 "Accept: application/json\r\n"
 )
);

$context = stream_context_create($opts);
$result = file_get_contents($url.$nomor_kartu, false, $context);

 if ($result === false) 
{ 
	echo "Tidak dapat menyambung ke server"; 
}else
{ 
	echo $result;

}

$conn->close();
?>

