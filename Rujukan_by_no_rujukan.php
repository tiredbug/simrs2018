<?php

include 'phpcon/koneksi.php'; 
//ob_start();

//$NO_RUJUKAN = $_GET['NO_RUJUKAN'];  //ganti param	
//$keyword = "head"; 

$NO_RUJUKAN = $_GET['nr'];
$NOMR = $_GET['m'];
//$NOMR = "";
$consumer_id = "1457"; 
$secretKey = "5uR5F9F782"; 

//$NO_RUJUKAN = "111114011116Y000874"; 



$sql= "SELECT ALAMAT FROM simrs2012.m_pasien WHERE  NOMR =". $NOMR;
$QUERY_PENDAFTARAN = $conn->query($sql);
$DATA_PENDAFTARAN = $QUERY_PENDAFTARAN->fetch_assoc();



$url = "http://192.168.1.104:8080/WsLokalRest/Rujukan/".$NO_RUJUKAN;

date_default_timezone_set('UTC');
$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
$signature = hash_hmac('sha256', $consumer_id."&".$tStamp, $secretKey, true);
$encodedSignature = base64_encode($signature);
$urlencodedSignature = urlencode($encodedSignature);


//HEADER 
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

$result = file_get_contents($url, false, $context);

if ($result === false) 
{ 
	echo "Tidak dapat menyambung ke server"; 
}
else 
{ 
 	$resultarr = json_decode($result, true);
}

	echo'{"code":"' . $resultarr['metadata']['code'] .'", 
 		"response":"' . $resultarr['metadata']['message'] .'",
		"catatan":"' . $resultarr['response']['item']['catatan'] .'",
		"kdDiag":"' . $resultarr['response']['item']['diagnosa']['kdDiag'] .'",
		"nmDiag":"' . $resultarr['response']['item']['diagnosa']['nmDiag'] .'",
		"keluhan":"' . $resultarr['response']['item']['keluhan'] .'",
		"noKunjungan":"' . $resultarr['response']['item']['noKunjungan'].'",
		"pemFisikLain":"' . $resultarr['response']['item']['pemFisikLain'].'",
		"dinsos":"' . $resultarr['response']['item']['peserta'] ['informasi'] ['dinsos'].'", 
		"iuran":"' . $resultarr['response']['item']['peserta'] ['informasi'] ['iuran'].'", 
		"noSKTM":"' . $resultarr['response']['item']['peserta'] ['informasi'] ['noSKTM'].'",
		"prolanisPRB":"' . $resultarr['response']['item']['peserta'] ['informasi'] ['prolanisPRB'].'",
		"kdJenisPeserta":"' . $resultarr['response']['item']['peserta'] ['jenisPeserta'] ['kdJenisPeserta'].'",
		"nmJenisPeserta":"' . $resultarr['response']['item']['peserta'] ['jenisPeserta'] ['nmJenisPeserta'].'",
		"kdKelas":"' . $resultarr['response']['item']['peserta'] ['kelasTanggungan'] ['kdKelas'].'",
		"nmKelas":"' . $resultarr['response']['item']['peserta'] ['kelasTanggungan'] ['nmKelas'].'",
		"nama":"' . $resultarr['response']['item']['peserta'] ['nama'].'",
		"nik":"' . $resultarr['response']['item']['peserta'] ['nik'].'",
		"noKartu":"' . $resultarr['response']['item']['peserta'] ['noKartu'].'",
		"noMr":"' . $resultarr['response']['item']['peserta'] ['noMr'].'",
		"pisa":"' . $resultarr['response']['item']['peserta'] ['pisa'].'",
		"kdCabang":"' . $resultarr['response']['item']['peserta'] ['provUmum'] ['kdCabang'].'",
		"kdProvider":"' . $resultarr['response']['item']['peserta'] ['provUmum'] ['kdProvider'].'",
		"nmCabang":"' . $resultarr['response']['item']['peserta'] ['provUmum'] ['nmCabang'].'",
		"nmProvider":"' . $resultarr['response']['item']['peserta'] ['provUmum'] ['nmProvider'].'",
		"sex":"' . $resultarr['response']['item']['peserta'] ['sex'].'",
		"keterangan":"' . $resultarr['response']['item']['peserta'] ['statusPeserta'] ['keterangan'].'",
		"kode":"' . $resultarr['response']['item']['peserta'] ['statusPeserta'] ['kode'].'",
		"tglCetakKartu":"' . $resultarr['response']['item']['peserta'] ['tglCetakKartu'].'",
		"tglLahir":"' . $resultarr['response']['item']['peserta'] ['tglLahir'].'",
		"tglTAT":"' . $resultarr['response']['item']['peserta'] ['tglTAT'].'",
		"tglTMT":"' . $resultarr['response']['item']['peserta'] ['tglTMT'].'",
		"umur":"' . $resultarr['response']['item']['peserta'] ['umur'].'",
		"kdPoli":"' . $resultarr['response']['item'] ['poliRujukan'] ['kdPoli'].'",
		"nmPoli":"' . $resultarr['response']['item']['poliRujukan'] ['nmPoli'].'",
		
		"provKunjungan_kdCabang":"' . $resultarr['response']['item'] ['provKunjungan'] ['kdCabang'].'",
		"provKunjungan_kdProvider":"' . $resultarr['response']['item'] ['provKunjungan'] ['kdProvider'].'",
		"provKunjungan_nmCabang":"' . $resultarr['response']['item'] ['provKunjungan'] ['nmCabang'].'",
		"provKunjungan_nmProvider":"' . $resultarr['response']['item'] ['provKunjungan'] ['nmProvider'].'",
		
		"provRujukan_kdCabang":"' . $resultarr['response']['item']['provRujukan'] ['kdCabang'].'",
		"provRujukan_kdProvider":"' . $resultarr['response']['item'] ['provRujukan'] ['kdProvider'].'",
		"provRujukan_nmCabang":"' . $resultarr['response']['item']['provRujukan'] ['nmCabang'].'",
		"provRujukan_nmProvider":"' . $resultarr['response']['item'] ['provRujukan'] ['nmProvider'].'",
		
		
		"tglKunjungan":"' . $resultarr['response']['item']['tglKunjungan'] .'",
		"nmPelayanan":"' . $resultarr['response']['item']['tktPelayanan'] ['nmPelayanan'].'",
		"ALAMAT":"' . $DATA_PENDAFTARAN['ALAMAT'].'",
		"tktPelayanan":"' .  $resultarr['response']['item'] ['tktPelayanan'] ['tktPelayanan']. '"}' ;
//ob_end_clean();
?>



