<?php
error_reporting(0);
include 'phpcon/koneksi.php';
//ob_start();
$nomor_kartu = $_GET['nomor_kartu']; 
//$nomor_kartu = "0000526551884";  //ganti dengan NIK (nomor KTP)
// ktp 3302147112400241



//include "../../include/connect.php";
//$sql_ws="SELECT * FROM l_konfigurasi_ws where id = 1";
//$query_sql_ws = mysql_query($sql_ws);
//$sata_query_sql_ws = mysql_fetch_array($query_sql_ws);


$sql= "SELECT * FROM l_konfigurasi_ws where id = 1";
$result = $conn->query($sql);
$sata_query_sql_ws = $result->fetch_assoc();




$consumer_id = $sata_query_sql_ws['consid_sep']; 
$secretKey = $sata_query_sql_ws['secretkey_sep'];


/*$consumer_id = "1457"; //Ganti dengan consumerID dari BPJS
$secretKey = "5uR5F9F782"; //Ganti dengan consumerSecret dari BPJS*/


//$sql="SELECT ALAMAT FROM simrs2012.m_pasien WHERE  NO_KARTU =". $nomor_kartu;
//$QUERY_PENDAFTARAN = mysql_query($sql);
//$DATA_PENDAFTARAN = mysql_fetch_array($QUERY_PENDAFTARAN);


$sql= "SELECT ALAMAT FROM simrs2012.m_pasien WHERE  NO_KARTU =". $nomor_kartu;
$QUERY_PENDAFTARAN = $conn->query($sql);
$DATA_PENDAFTARAN = $QUERY_PENDAFTARAN->fetch_assoc();

//http://dvlp.bpjs-kesehatan.go.id:8081/devwslokalrest/Peserta/Peserta/0000526842988
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

//print "opts= " . $opts ;

$context = stream_context_create($opts);
//print "context=" . $context ;

$result = file_get_contents($url.$nomor_kartu, false, $context);

 if ($result === false) 
{ 
 echo "Tidak dapat menyambung ke server"; 
} else { 
 $resultarr=json_decode($result, true);
 
 /*echo '<pre>';
	print_r ($resultarr);
	echo '<pre>'; */
}


 echo '{"code":"' . $resultarr['metadata']['code'] .'", 
 		"message":"' . $resultarr['metadata']['message'] .'", 
		
		"dinsos":"' . $resultarr['response']['peserta']['informasi']['dinsos'] .'", 
		"iuran":"' . $resultarr['response']['peserta']['informasi']['iuran'] .'", 
		"prolanisPRB":"' . $resultarr['response']['peserta']['informasi']['prolanisPRB'] .'",
		
		"kdJenisPeserta":"' . $resultarr['response']['peserta']['jenisPeserta']['kdJenisPeserta'] .'",
		"nmJenisPeserta":"' . $resultarr['response']['peserta']['jenisPeserta']['nmJenisPeserta'] .'",
		
		"kdKelas":"' . $resultarr['response']['peserta']['kelasTanggungan']['kdKelas'] .'",
		"nmKelas":"' . $resultarr['response']['peserta']['kelasTanggungan']['nmKelas'] .'",
		
		"nama":"' . $resultarr['response']['peserta']['nama'].'",
		"nik":"' . $resultarr['response']['peserta']['nik'].'",
		"noKartu":"' . $resultarr['response']['peserta']['noKartu'].'",
		"noMr":"' . $resultarr['response']['peserta']['noMr'].'",
		"pisa":"' . $resultarr['response']['peserta']['pisa'].'",
		
		"kdCabang":"' . $resultarr['response']['peserta']['provUmum']['kdCabang'] .'",
		"kdProvider":"' . $resultarr['response']['peserta']['provUmum']['kdProvider'] .'",	
		"nmCabang":"' . $resultarr['response']['peserta']['provUmum']['nmCabang'] .'",
		"nmProvider":"' . $resultarr['response']['peserta']['provUmum']['nmProvider'] .'",
		
		"sex":"' . $resultarr['response']['peserta']['sex'].'", 
		
		"keterangan":"' . $resultarr['response']['peserta']['statusPeserta']['keterangan'] .'",	
		"kode":"' . $resultarr['response']['peserta']['statusPeserta']['kode'] .'",	
		
		"tglCetakKartu":"' . $resultarr['response']['peserta']['tglCetakKartu'].'", 
		"tglLahir":"' . $resultarr['response']['peserta']['tglLahir'].'",	
		"tglTAT":"' . $resultarr['response']['peserta']['tglTAT'].'",
		"tglTMT":"' . $resultarr['response']['peserta']['tglTMT'].'",
		"umurSaatPelayanan":"' . $resultarr['response']['peserta']['umur'] ['umurSaatPelayanan']. '",
		"ALAMAT":"' . $DATA_PENDAFTARAN['ALAMAT'].'",
		"umurSekarang":"' . $resultarr['response']['peserta']['umur'] ['umurSekarang']. '"}' ;
 
$conn->close();
?>

