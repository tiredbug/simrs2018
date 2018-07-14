 <?php
 
 
  function get_nomr_baru(){
	include("koneksi.php");
	$val = "";
	$query = "select simrs2012.getNewNOMR() as nomr";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['nomr'];
	}else{
		$val = "";
	}
	return $val; 
}



 function getProfesiDoktor($kddokter){
	include("koneksi.php");
	$val = "";
	$query = "select * from m_dokter where KDDOKTER = ".$kddokter." ";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['KDPROFESI'];
	}else{
		$val = "";
	}
	return $val; 
}




 function getKodePendaftaran($jenispoly,$kdprofesi){
	include("koneksi.php");
	$val = "";
	$query = 'select * from m_tarif2012 where kode_unit = "'.$jenispoly.'" and kode_profesi = "'.$kdprofesi.'"';
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['kode_tindakan'];
	}else{
		$val = "";
	}
	return $val; 
}




 function getTarif($kode){
	include("koneksi.php");
	$val = "";
	$query = 'select jasa_sarana, jasa_pelayanan, tarif from m_tarif2012 where kode_tindakan ="'.$kode.'"';
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val['jasa_sarana'] = $data['jasa_sarana'];
		$val['jasa_pelayanan'] = $data['jasa_pelayanan'];
		$val['tarif'] = $data['tarif'];
	}else{
		$val = "";
	}
	return $val; 
}



 function getTarifPendaftaran($kodetarif){
	include("koneksi.php");
	//$val = "";
	$query = 'select * from m_tarif2012 where kode_tindakan = "'.$kodetarif.'"';
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		//$val = $data['kode_tindakan'];
		$val['jasa_sarana'] = $data['jasa_sarana'];
		$val['jasa_pelayanan'] = $data['jasa_pelayanan'];
		$val['tarif'] = $data['tarif'];
		
	}else{
		$val = "";
	}
	return $val; 
}



 function getLastNoBILL($p=0){
	include("koneksi.php");
	//$val = "";
	$query = 'SELECT nomor FROM M_MAXNOBILL';
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		//$val = $data['kode_tindakan'];
		$no	= $data['nomor'] + $p;
		
	}else{
		$no = 1;
	}
	return $no; 
}


 function getLastIDXDAFTAR($p=0){
	include("koneksi.php");
	//$val = "";
	$query = 'select IDXDAFTAR from t_pendaftaran order by IDXDAFTAR desc limit 1';
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		//$val = $data['kode_tindakan'];
		$no	= $data['IDXDAFTAR'] + $p;
		
	}else{
		$no = 1;
	}
	return $no; 
}


function getRealIpAddr() {
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip=$_SERVER['HTTP_CLIENT_IP']; // share internet
    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; // pass from proxy
    } else {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
  return $ip;
}




 function konfigurasi_ws(){
	include("koneksi.php");
	$query = "SELECT * FROM simrs2012.l_konfigurasi_ws LIMIT 1 ";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val['status'] = '200';
		$val['message'] = 'Data Kosong';
		$val['id'] = $data['id'];
		$val['consid_sep'] = $data['consid_sep'];
		$val['secretkey_sep'] = $data['secretkey_sep'];
		$val['kodeppk_rs'] = $data['kodeppk_rs'];
		$val['encryptionkey_inacbg'] = $data['encryptionkey_inacbg'];
		$val['ws_inacbg_endpoint'] = $data['ws_inacbg_endpoint'];
		$val['ws_inacbg_endpoint_debug'] = $data['ws_inacbg_endpoint_debug'];
		$val['jenistarif_eklaim'] = $data['jenistarif_eklaim'];
		$val['consid_vclaim_tester'] = $data['consid_vclaim_tester'];
		$val['secretkey_vclaim_tester'] = $data['secretkey_vclaim_tester'];
		$val['port_tester'] = $data['port_tester'];
		$val['url_vclaim_tester'] = $data['url_vclaim_tester'];
		$val['port'] = $data['port'];
		$val['consid_vclaim'] = $data['consid_vclaim'];
		$val['secretkey_vclaim'] = $data['secretkey_vclaim'];
		$val['url_vclaim'] = $data['url_vclaim'];
	}else{
		$val['status'] = '201';
		$val['message'] = 'Data Kosong';
	}
	return $val; 
}
 
 
 function getdetail_rujukan_faskes($nomerRujukan,$v_nomr){
	 
			include("koneksi.php");
			$var_error;
			$var_detail_sep;
			$var_result;
			$var_data_peserta;
			$metaData;
			$response = null;
			$result;
			
			$printarr=false;
			$extraparam="";
			
			$printarr=true;
			
			$detail_pasien  = getDataPasienbyNomr($v_nomr);
			
			$var_error["status"]  = "sukses";
		
			$cat = "/Rujukan/".$nomerRujukan." ";
			
			$config = konfigurasi_ws();

		
			/*$dataid    = $config['consid_vclaim_tester'];
			$secretKey = $config['secretkey_vclaim_tester'];
			$localIP   = $config['url_vclaim_tester'];
			$port      = $config['port_tester'];
			$url       = "http://".$localIP.":".$port."/VClaim-rest".$cat; */
			
			$dataid    = $config['consid_vclaim'];//"7910"; 
			$secretKey = $config['secretkey_vclaim'];//"8dY0BD285F"; 
			$localIP   = $config['url_vclaim'];//"dvlp.bpjs-kesehatan.go.id";
			$port      = $config['port'];//8081; 
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
			if ($result === false) 
			{ 
			  
				$var_error["status"] = "Tidak dapat menyambung ke server";
			 
			} else {

			 if($printarr==true){
				$resultarr = json_decode($result, true);

						$metaData["code"] = $resultarr['metaData']['code'];
						$metaData["message"] = $resultarr['metaData']['message'];
						
						
						
						
						$diagnosa['kode'] = $resultarr['response']['rujukan']['diagnosa']['kode'];
						$diagnosa['nama'] = $resultarr['response']['rujukan']['diagnosa']['nama'];
						
						
						
						$pelayanan['kode'] = $resultarr['response']['rujukan']['pelayanan']['kode'];
						$pelayanan['nama'] = $resultarr['response']['rujukan']['pelayanan']['nama'];
						
						
						
						$poliRujukan['kode'] = $resultarr['response']['rujukan']['poliRujukan']['kode'];
						$poliRujukan['nama'] = $resultarr['response']['rujukan']['poliRujukan']['nama'];
						
						
						$provPerujuk['kode'] = $resultarr['response']['rujukan']['provPerujuk']['kode'];
						$provPerujuk['nama'] = $resultarr['response']['rujukan']['provPerujuk']['nama'];
						
						$hakKelas['keterangan'] = $resultarr['response']['rujukan']['peserta']['hakKelas']['keterangan'];
						$hakKelas['kode'] = $resultarr['response']['rujukan']['peserta']['hakKelas']['kode'];
						
						$jenisPeserta['keterangan'] = $resultarr['response']['rujukan']['peserta']['jenisPeserta']['keterangan'];
						$jenisPeserta['kode'] = $resultarr['response']['rujukan']['peserta']['jenisPeserta']['kode'];
						
						$mr['noMR'] = $resultarr['response']['rujukan']['peserta']['mr']['noMR'];
						$mr['noTelepon'] = $resultarr['response']['rujukan']['peserta']['mr']['noTelepon'];
						
						
						
						$cob['nmAsuransi'] = $resultarr['response']['rujukan']['peserta']['cob']['nmAsuransi'];
						$cob['noAsuransi'] = $resultarr['response']['rujukan']['peserta']['cob']['noAsuransi'];
						$cob['tglTAT'] = $resultarr['response']['rujukan']['peserta']['cob']['tglTAT'];
						$cob['tglTMT'] = $resultarr['response']['rujukan']['peserta']['cob']['tglTMT'];
						
						
						$informasi['dinsos'] = $resultarr['response']['rujukan']['peserta']['informasi']['dinsos'];
						$informasi['noSKTM'] = $resultarr['response']['rujukan']['peserta']['informasi']['noSKTM'];
						$informasi['prolanisPRB'] = $resultarr['response']['rujukan']['peserta']['informasi']['prolanisPRB'];
						
						
						$provUmum['kdProvider'] = $resultarr['response']['rujukan']['peserta']['provUmum']['kdProvider'];
						$provUmum['nmProvider'] = $resultarr['response']['rujukan']['peserta']['provUmum']['nmProvider'];
						
						
						
						$statusPeserta['keterangan'] = $resultarr['response']['rujukan']['peserta']['statusPeserta']['keterangan'];
						$statusPeserta['kode'] = $resultarr['response']['rujukan']['peserta']['statusPeserta']['kode'];
						
						$umur['umurSaatPelayanan'] = $resultarr['response']['rujukan']['peserta']['umur']['umurSaatPelayanan'];
						$umur['umurSekarang'] = $resultarr['response']['rujukan']['peserta']['umur']['umurSekarang'];
						
						
						$rujukan['noKunjungan'] = $resultarr['response']['rujukan']['noKunjungan'];	
						$rujukan['keluhan'] = $resultarr['response']['rujukan']['keluhan'];	
						$rujukan['tglKunjungan'] = $resultarr['response']['rujukan']['tglKunjungan'];
						$rujukan['diagnosa'] = $diagnosa;
						$rujukan['pelayanan'] = $pelayanan;
						$rujukan['poliRujukan'] = $poliRujukan;
						$rujukan['provPerujuk'] = $provPerujuk;
						
						
						
						$peserta['nama'] = $resultarr['response']['rujukan']['peserta']['nama'];
						$peserta['nik'] = $resultarr['response']['rujukan']['peserta']['nik'];
						$peserta['noKartu'] = $resultarr['response']['rujukan']['peserta']['noKartu'];
						$peserta['pisa'] = $resultarr['response']['rujukan']['peserta']['pisa'];
						$peserta['sex'] = $resultarr['response']['rujukan']['peserta']['sex'];
						$peserta['tglCetakKartu'] = $resultarr['response']['rujukan']['peserta']['tglCetakKartu'];
						$peserta['tglLahir'] = $resultarr['response']['rujukan']['peserta']['tglLahir'];
						$peserta['tglTAT'] = $resultarr['response']['rujukan']['peserta']['tglTAT'];
						$peserta['tglTMT'] = $resultarr['response']['rujukan']['peserta']['tglTMT'];
						$peserta['alamat'] = $detail_pasien[8];
						$peserta['telepon_pasien'] = $detail_pasien[13];
						if($mr['noMR']!=$v_nomr)
						{
							$peserta['status nomr']  = "norm bpjs dan simr tidak sama";
						}else{
							
							$peserta['status nomr']  =  "norm bpjs dan simr sama";
						}
						
						
						
						
						
						$peserta['hakKelas'] = $hakKelas;
						$peserta['mr'] = $mr;
						$peserta['jenisPeserta'] = $jenisPeserta;
						$peserta['cob'] = $cob;
						$peserta['informasi'] = $informasi;
						$peserta['provUmum'] = $provUmum;
						
						$peserta['statusPeserta'] = $statusPeserta;
						$peserta['umur'] = $umur;
						
						
						
						$rujukan['peserta'] = $peserta;
						$response['rujukan']  =  $rujukan;
						
	
						$var_detail_sep["metaData"] = $metaData;
						$var_detail_sep["response"] = $response;

						$var_result["pesan_error"] =  $var_error;
						$var_result["hasil"]  = $var_detail_sep;
						
						$result = $var_result;
				 
				}

			 }
	
	return $result;
}


  
 function getdetail_rujukan_faskes2($nomerRujukan,$v_nomr){
	 
			include("koneksi.php");
			$var_error;
			$var_detail_sep;
			$var_result;
			$var_data_peserta;
			$metaData;
			$response = null;
			$result;
			
			$printarr=false;
			$extraparam="";
			
			$printarr=true;
			
			$detail_pasien  = getDataPasienbyNomr($v_nomr);
			
			$var_error["status"]  = "sukses";
		
			$cat = "/Rujukan/RS/".$nomerRujukan." ";
			
			$config = konfigurasi_ws();

		
			/*$dataid    = $config['consid_vclaim_tester'];
			$secretKey = $config['secretkey_vclaim_tester'];
			$localIP   = $config['url_vclaim_tester'];
			$port      = $config['port_tester'];
			$url       = "http://".$localIP.":".$port."/VClaim-rest".$cat; */
			
			$dataid    = $config['consid_vclaim'];//"7910"; 
			$secretKey = $config['secretkey_vclaim'];//"8dY0BD285F"; 
			$localIP   = $config['url_vclaim'];//"dvlp.bpjs-kesehatan.go.id";
			$port      = $config['port'];//8081; 
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
			if ($result === false) 
			{ 
			  
				$var_error["status"] = "Tidak dapat menyambung ke server";
			 
			} else {

			 if($printarr==true){
				$resultarr = json_decode($result, true);

						$metaData["code"] = $resultarr['metaData']['code'];
						$metaData["message"] = $resultarr['metaData']['message'];
						
						
						
						
						$diagnosa['kode'] = $resultarr['response']['rujukan']['diagnosa']['kode'];
						$diagnosa['nama'] = $resultarr['response']['rujukan']['diagnosa']['nama'];
						
						
						
						$pelayanan['kode'] = $resultarr['response']['rujukan']['pelayanan']['kode'];
						$pelayanan['nama'] = $resultarr['response']['rujukan']['pelayanan']['nama'];
						
						
						
						$poliRujukan['kode'] = $resultarr['response']['rujukan']['poliRujukan']['kode'];
						$poliRujukan['nama'] = $resultarr['response']['rujukan']['poliRujukan']['nama'];
						
						
						$provPerujuk['kode'] = $resultarr['response']['rujukan']['provPerujuk']['kode'];
						$provPerujuk['nama'] = $resultarr['response']['rujukan']['provPerujuk']['nama'];
						
						$hakKelas['keterangan'] = $resultarr['response']['rujukan']['peserta']['hakKelas']['keterangan'];
						$hakKelas['kode'] = $resultarr['response']['rujukan']['peserta']['hakKelas']['kode'];
						
						$jenisPeserta['keterangan'] = $resultarr['response']['rujukan']['peserta']['jenisPeserta']['keterangan'];
						$jenisPeserta['kode'] = $resultarr['response']['rujukan']['peserta']['jenisPeserta']['kode'];
						
						$mr['noMR'] = $resultarr['response']['rujukan']['peserta']['mr']['noMR'];
						$mr['noTelepon'] = $resultarr['response']['rujukan']['peserta']['mr']['noTelepon'];
						
						
						
						$cob['nmAsuransi'] = $resultarr['response']['rujukan']['peserta']['cob']['nmAsuransi'];
						$cob['noAsuransi'] = $resultarr['response']['rujukan']['peserta']['cob']['noAsuransi'];
						$cob['tglTAT'] = $resultarr['response']['rujukan']['peserta']['cob']['tglTAT'];
						$cob['tglTMT'] = $resultarr['response']['rujukan']['peserta']['cob']['tglTMT'];
						
						
						$informasi['dinsos'] = $resultarr['response']['rujukan']['peserta']['informasi']['dinsos'];
						$informasi['noSKTM'] = $resultarr['response']['rujukan']['peserta']['informasi']['noSKTM'];
						$informasi['prolanisPRB'] = $resultarr['response']['rujukan']['peserta']['informasi']['prolanisPRB'];
						
						
						$provUmum['kdProvider'] = $resultarr['response']['rujukan']['peserta']['provUmum']['kdProvider'];
						$provUmum['nmProvider'] = $resultarr['response']['rujukan']['peserta']['provUmum']['nmProvider'];
						
						
						
						$statusPeserta['keterangan'] = $resultarr['response']['rujukan']['peserta']['statusPeserta']['keterangan'];
						$statusPeserta['kode'] = $resultarr['response']['rujukan']['peserta']['statusPeserta']['kode'];
						
						$umur['umurSaatPelayanan'] = $resultarr['response']['rujukan']['peserta']['umur']['umurSaatPelayanan'];
						$umur['umurSekarang'] = $resultarr['response']['rujukan']['peserta']['umur']['umurSekarang'];
						
						
						$rujukan['noKunjungan'] = $resultarr['response']['rujukan']['noKunjungan'];	
						$rujukan['keluhan'] = $resultarr['response']['rujukan']['keluhan'];	
						$rujukan['tglKunjungan'] = $resultarr['response']['rujukan']['tglKunjungan'];
						$rujukan['diagnosa'] = $diagnosa;
						$rujukan['pelayanan'] = $pelayanan;
						$rujukan['poliRujukan'] = $poliRujukan;
						$rujukan['provPerujuk'] = $provPerujuk;
						
						
						
						$peserta['nama'] = $resultarr['response']['rujukan']['peserta']['nama'];
						$peserta['nik'] = $resultarr['response']['rujukan']['peserta']['nik'];
						$peserta['noKartu'] = $resultarr['response']['rujukan']['peserta']['noKartu'];
						$peserta['pisa'] = $resultarr['response']['rujukan']['peserta']['pisa'];
						$peserta['sex'] = $resultarr['response']['rujukan']['peserta']['sex'];
						$peserta['tglCetakKartu'] = $resultarr['response']['rujukan']['peserta']['tglCetakKartu'];
						$peserta['tglLahir'] = $resultarr['response']['rujukan']['peserta']['tglLahir'];
						$peserta['tglTAT'] = $resultarr['response']['rujukan']['peserta']['tglTAT'];
						$peserta['tglTMT'] = $resultarr['response']['rujukan']['peserta']['tglTMT'];
						$peserta['alamat'] = $detail_pasien[8];
						$peserta['telepon_pasien'] = $detail_pasien[13];
						if($mr['noMR']!=$v_nomr)
						{
							$peserta['status nomr']  = "norm bpjs dan simr tidak sama";
						}else{
							
							$peserta['status nomr']  =  "norm bpjs dan simr sama";
						}
						
						
						
						
						
						$peserta['hakKelas'] = $hakKelas;
						$peserta['mr'] = $mr;
						$peserta['jenisPeserta'] = $jenisPeserta;
						$peserta['cob'] = $cob;
						$peserta['informasi'] = $informasi;
						$peserta['provUmum'] = $provUmum;
						
						$peserta['statusPeserta'] = $statusPeserta;
						$peserta['umur'] = $umur;
						
						
						
						$rujukan['peserta'] = $peserta;
						$response['rujukan']  =  $rujukan;
						
	
						$var_detail_sep["metaData"] = $metaData;
						$var_detail_sep["response"] = $response;

						$var_result["pesan_error"] =  $var_error;
						$var_result["hasil"]  = $var_detail_sep;
						
						$result = $var_result;
				 
				}

			 }
	
	return $result;
}


 
 function getdetailSEP($nomerSEP){
	 
			$var_error;
			$var_detail_sep;
			$var_result;
			$var_data_peserta;
			$metaData;
			$response;
			$result;
			
			$var_error["status"]  = "sukses";
			$sep = $nomerSEP;
			$printarr=false;
			$extraparam="";


			$printarr=true;
			$cat = "/SEP/".$sep." ";
			
			
			$config = konfigurasi_ws();

			$dataid    = $config['consid_vclaim'];//"7910"; 
			$secretKey = $config['secretkey_vclaim'];//"8dY0BD285F"; 
			$localIP   = $config['url_vclaim'];//"dvlp.bpjs-kesehatan.go.id";
			$port      = $config['port'];//8081; 
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
			if ($result === false) 
			{ 
			 //echo "Tidak dapat menyambung ke server"; 
			 $var_error["status"] = "Tidak dapat menyambung ke server";
			 
			} else {

			 if($printarr==true){
				$resultarr = json_decode($result, true);
				 
						$var_data_peserta["asuransi"] = $resultarr['response']['peserta']['asuransi'];
						$var_data_peserta["hakKelas"] = $resultarr['response']['peserta']['hakKelas'];
						$var_data_peserta["jnsPeserta"] = $resultarr['response']['peserta']['jnsPeserta'];
						$var_data_peserta["kelamin"] = $resultarr['response']['peserta']['kelamin'];
						$var_data_peserta["nama"] = $resultarr['response']['peserta']['nama'];
						$var_data_peserta["noKartu"] = $resultarr['response']['peserta']['noKartu'];
						$var_data_peserta["tglLahir"] = $resultarr['response']['peserta']['tglLahir'];
						$var_data_peserta["noMr"] = $resultarr['response']['peserta']['noMr'];
						
					
						$metaData["code"] = $resultarr['metaData']['code'];
						$metaData["message"] = $resultarr['metaData']['message'];
						
						
						 $response["catatan"] = $resultarr['response']['catatan'];
						 $response["diagnosa"] = $resultarr['response']['diagnosa'];
						 $response["jnsPelayanan"] = $resultarr['response']['jnsPelayanan'];
						 $response["kelasRawat"] = $resultarr['response']['kelasRawat'];
						 $response["noSep"] = $resultarr['response']['noSep'];
						 $response["penjamin"] = $resultarr['response']['penjamin'];
						 $response["peserta"]  = $var_data_peserta ;
						 $response["poli"] = $resultarr['response']['poli'];
						 $response["poliEksekutif"] = $resultarr['response']['poliEksekutif'];
						 $response["tglSep"] = $resultarr['response']['tglSep'];
						 
						 
						 
						 
						$var_detail_sep["metaData"] = $metaData;
						$var_detail_sep["response"] = $response;
						 

						$var_result["pesan_error"] =  $var_error;
						$var_result["hasil"]  = $var_detail_sep;
						
						$result = $var_result;
				 
				}

			 }
	
	return $result;
}



function insert_SEP($v_noKartu,$v_tglSep,$v_ppkPelayanan,$v_jnsPelayanan,$v_klsRawat,
					$v_noMR,$v_asalRujukan,$v_tglRujukan,$v_noRujukan,$v_ppkRujukan,
					$v_catatan,$v_diagAwal,$v_tujuan,$v_eksekutif,$v_cob,
					$v_lakaLantas,$v_penjamin,$v_lokasiLaka,$v_noTelp,$v_user,$v_idx,$v_nik,$v_status_kartu,
					$v_nama_ppk){
						
			include("koneksi.php");
						
		
			$result_array;
			$var_detail_sep;
			
			$printarr=false;
			$extraparam="";
			$printarr=true;
			
			$noKartu = $v_noKartu;
			$tglSep = $v_tglSep ;
			$ppkPelayanan = $v_ppkPelayanan;
			$jnsPelayanan = $v_jnsPelayanan ;
			$klsRawat = $v_klsRawat;
			
			$noMR = $v_noMR;
			$asalRujukan = $v_asalRujukan;
			$tglRujukan = $v_tglRujukan ;
			$noRujukan = $v_noRujukan;
			$ppkRujukan = $v_ppkRujukan;
			
			$catatan = $v_catatan;
			$diagAwal = $v_diagAwal;
			$tujuan =  $v_tujuan;
			$eksekutif =  $v_eksekutif;
			$cob = $v_cob;
			$nama_ppk = $v_nama_ppk;

			
			if ($v_lakaLantas == 1)
			{
				$lakaLantas = 1;
				
			}elseif($v_lakaLantas == 2){
				$lakaLantas = 0;
			}
			
			
			$penjamin = $v_penjamin;
			$lokasiLaka =  $v_lokasiLaka;
			$noTelp = $v_noTelp;
			$user = $v_user;
			$idx = $v_idx;
			$nik = $v_nik;
			$status_kartu = $v_status_kartu;
			
			
			//$data_pasien = getDataPasienbyNomr($noMR);

			
	$databpjs = '{
		   "request": {
			  "t_sep": {
				 "noKartu": "'.$noKartu.'",
				 "tglSep": "'.$tglSep.'",
				 "ppkPelayanan": "'.$ppkPelayanan .'",
				 "jnsPelayanan": "'.$jnsPelayanan .'",
				 "klsRawat": "'.$klsRawat.'",
				 "noMR": "'.$noMR.'",
				 "rujukan": {
					"asalRujukan": "'.$asalRujukan.'",
					"tglRujukan": "'.$tglRujukan.'",
					"noRujukan": "'.$noRujukan.'",
					"ppkRujukan": "'.$ppkRujukan.'"
				 },
				 "catatan": "'.$catatan.'",
				 "diagAwal": "'.$diagAwal.'",
				 "poli": {
					"tujuan": "'.$tujuan.'",
					"eksekutif": "'.$eksekutif .'"
				 },
				 "cob": {
					"cob": "'.$cob.'"
				 },
				 "jaminan": {
					"lakaLantas": "'.$lakaLantas.'",
					"penjamin": "'.$penjamin.'",
					"lokasiLaka": "'.$lokasiLaka.'"
				 },
				 "noTelp": "'.$noTelp.'",
				 "user":"'.$user.'"
			  }
		   }
		} ';
		
	/*$dataid    = "7910";
	$secretKey = "8dY0BD285F";

	$localIP   = "dvlp.bpjs-kesehatan.go.id";
	$port      = 8081;
	$cat = "/SEP/insert ";
	$url       = "http://".$localIP.":".$port."/VClaim-rest".$cat; */
	
			$config = konfigurasi_ws();
			$cat = "/SEP/insert ";
			$dataid    = $config['consid_vclaim'];
			$secretKey = $config['secretkey_vclaim'];
			$localIP   = $config['url_vclaim'];
			$port      = $config['port'];
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
				 //$result_array  = $objJson;
				//$objJson = $result_array;
			 
				$peserta["asuransi"] =  $objJson['response']['sep']['peserta']['asuransi'];
				$peserta["hakKelas"] =  $objJson['response']['sep']['peserta']['hakKelas'];
				$peserta["jnsPeserta"] =  $objJson['response']['sep']['peserta']['jnsPeserta'];
				$peserta["nama"] =  $objJson['response']['sep']['peserta']['nama'];
				$peserta["noKartu"] =  $objJson['response']['sep']['peserta']['noKartu'];
				$peserta["noMr"] =  $objJson['response']['sep']['peserta']['noMr'];
				$peserta["tglLahir"] =  $objJson['response']['sep']['peserta']['tglLahir'];
				//$peserta["alamat_pasien"] = $data_pasien[8];
				

			
				$metaData["code"] = $objJson['metaData']['code'];
				$metaData["message"] = $objJson['metaData']['message'];
			
				$sep["catatan"] =  $objJson['response']['sep']['catatan'];
				$sep["diagnosa"] =  $objJson['response']['sep']['diagnosa'];
				$sep["jnsPelayanan"] =  $objJson['response']['sep']['jnsPelayanan'];
				$sep["kelasRawat"] =  $objJson['response']['sep']['kelasRawat'];
				$sep["noSep"] =  $objJson['response']['sep']['noSep'];
				$sep["penjamin"] =  $objJson['response']['sep']['penjamin'];
				$sep["peserta"] =  $peserta;
				$sep["poli"] =  $objJson['response']['sep']['poli'];
				//$sep["eksekutif"] =  $objJson['response']['sep']['eksekutif'];
				$sep["tglSep"] =  $objJson['response']['sep']['tglSep'];
				
				
				
				
	
				$response["sep"] = $sep;
				$var_detail_sep["metaData"] = $metaData;
				$var_detail_sep["response"] = $response;
				
				
				
				
				if($metaData["code"]==200)
				{
					
					$data_pendaftaran_rajal =  getDataPendaftaranRajalbyIdx($idx);
					
					$sql = 'INSERT INTO t_sep(nomer_sep,nomr,no_kartubpjs,nama_layanan,tgl_sep ,
				tgl_rujukan,nama_kelas,no_rujukan,faskes_id,ppk_pelayanan,
                catatan,kode_diagnosaawal,laka_lantas,lokasi_laka,user,
                nik,kode_politujuan,idx,poli_eksekutif,cob,
                penjamin_laka,no_telp,status_kepesertaan_bpjs,last_update,ppk_asal,table_source,
				nama_diagnosaawal,jenis_layanan,kelas_rawat,nama_ppk,nama_politujuan,
				pasien_baru,cara_bayar,dpjp)
								VALUES("'.$sep["noSep"].'","'.$peserta["noMr"].'","'.$peserta["noKartu"].'","'.$sep["jnsPelayanan"].'","'.$sep["tglSep"].'",
									"'.$tglRujukan.'","'.$peserta["hakKelas"].'","'.$noRujukan.'","'.$asalRujukan.'","'.$ppkPelayanan.'",
									"'.$sep["catatan"] .'","'.$diagAwal.'","'.$lakaLantas.'","'.$lokasiLaka.'","'.$user.'",
									"'.$nik.'","'.$tujuan.'","'.$idx.'","'.$eksekutif.'","'.$cob.'",
									"'.$penjamin.'","'.$noTelp.'","'.$status_kartu.'",CURRENT_TIMESTAMP,"'.$ppkRujukan.'","t_pendaftaran",
									"'.$sep['diagnosa'].'","'.$jnsPelayanan.'","'.$klsRawat.'","'.$nama_ppk.'","'.$data_pendaftaran_rajal["NAMAPOLITUJUAN_SEP"].'",
									"'.$data_pendaftaran_rajal["PASIENBARU"].'","'.$data_pendaftaran_rajal["KDCARABAYAR"].'","'.$data_pendaftaran_rajal["KDDOKTER"].'" )'; 
									
						$var_detail_sep["sql"] = $sql;
						$conn->query($sql);
						
						
					$sql_update_notelp  = "UPDATE m_pasien SET NOTELP =  '".$noTelp." ' WHERE NOMR = ' ".$peserta["noMr"]." ' ";
					
					$conn->query($sql_update_notelp);
								
				}
				
				
		 
	}
	$conn->close();
	
	return $var_detail_sep;
}


function get_detail_keanggotaanBPJS_by_kartu($v_noka,$v_nomr){
			include("koneksi.php");
			$var_error;
			$var_detail_sep;
			$var_result;
			$var_data_peserta;
			$metaData;
			$response;
			$result;
			
			$printarr=false;
			$extraparam="";
			
			$printarr=true;
			
			$detail_pasien  = getDataPasienbyNomr($v_nomr);
			
			$var_error["status"]  = "sukses";
			
			//PARAM
			$nomor_kartu = $v_noka;
			$tglSEP = date("Y-m-d");
			
			
			$config = konfigurasi_ws();
			$cat = "/Peserta/nokartu/".$nomor_kartu."/tglSEP/".$tglSEP." ";

			/*$dataid    = "7910"; 
			$secretKey = "8dY0BD285F"; 
			$localIP   = "dvlp.bpjs-kesehatan.go.id";
			$port      = 8081; 
			$url       = "http://".$localIP.":".$port."/VClaim-rest".$cat; */

			$dataid    = $config['consid_vclaim'];//"7910"; 
			$secretKey = $config['secretkey_vclaim'];//"8dY0BD285F"; 
			$localIP   = $config['url_vclaim'];//"dvlp.bpjs-kesehatan.go.id";
			$port      = $config['port'];//8081; 
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
			if ($result === false) 
			{ 
			  
				$var_error["status"] = "Tidak dapat menyambung ke server";
			 
			} else {

			 if($printarr==true){
				$resultarr = json_decode($result, true);

						$metaData["code"] = $resultarr['metaData']['code'];
						$metaData["message"] = $resultarr['metaData']['message'];
						
						$cob;
						$cob['nmAsuransi'] = $resultarr['response']['peserta']['cob']['nmAsuransi'];
						$cob['noAsuransi'] = $resultarr['response']['peserta']['cob']['noAsuransi'];
						$cob['tglTAT'] = $resultarr['response']['peserta']['cob']['tglTAT'];
						$cob['tglTMT'] = $resultarr['response']['peserta']['cob']['tglTMT'];
						
						$hakKelas;
						$hakKelas['keterangan'] = $resultarr['response']['peserta']['hakKelas']['keterangan'];
						$hakKelas['kode'] = $resultarr['response']['peserta']['hakKelas']['kode'];

						$informasi;
						$informasi['dinsos'] = $resultarr['response']['peserta']['informasi']['dinsos'];
						$informasi['noSKTM'] = $resultarr['response']['peserta']['informasi']['noSKTM'];
						$informasi['prolanisPRB'] = $resultarr['response']['peserta']['informasi']['prolanisPRB'];
						
						
						$jenisPeserta;
						$jenisPeserta['keterangan'] = $resultarr['response']['peserta']['jenisPeserta']['keterangan'];
						$jenisPeserta['kode'] = $resultarr['response']['peserta']['jenisPeserta']['kode'];
						
						
						$mr;
						$mr['noMR'] = $resultarr['response']['peserta']['mr']['noMR'];
						$mr['noTelepon'] = $resultarr['response']['peserta']['mr']['noTelepon'];
						
						
						$provUmum;
						$provUmum['kdProvider'] = $resultarr['response']['peserta']['provUmum']['kdProvider'];
						$provUmum['nmProvider'] = $resultarr['response']['peserta']['provUmum']['nmProvider'];
						
						
						$statusPeserta;
						$statusPeserta['keterangan'] = $resultarr['response']['peserta']['statusPeserta']['keterangan'];
						$statusPeserta['kode'] = $resultarr['response']['peserta']['statusPeserta']['kode'];
						
						$umur;
						$umur['umurSaatPelayanan'] = $resultarr['response']['peserta']['umur']['umurSaatPelayanan'];
						$umur['umurSekarang'] = $resultarr['response']['peserta']['umur']['umurSekarang'];
						
						
						
						$peserta ;
						$peserta['nama'] = $resultarr['response']['peserta']['nama'];
						$peserta['nik'] = $resultarr['response']['peserta']['nik'];
						$peserta['noKartu'] = $resultarr['response']['peserta']['noKartu'];
						$peserta['pisa'] = $resultarr['response']['peserta']['pisa'];
						$peserta['sex'] = $resultarr['response']['peserta']['sex'];
						
						$peserta['tglCetakKartu'] = $resultarr['response']['peserta']['tglCetakKartu'];
						$peserta['tglLahir'] = $resultarr['response']['peserta']['tglLahir'];
						$peserta['tglTAT'] = $resultarr['response']['peserta']['tglTAT'];
						$peserta['tglTMT'] = $resultarr['response']['peserta']['tglTMT'];
						$peserta['alamat_pasien'] = $detail_pasien[8];
						$peserta['telepon_pasien'] = $detail_pasien[13];
						
						
						
						$peserta['cob'] = $cob;
						$peserta['hakKelas'] = $hakKelas;
						$peserta['informasi'] = $informasi;
						$peserta['jenisPeserta'] = $jenisPeserta;
						$peserta['mr'] = $mr;
						$peserta['provUmum'] = $provUmum;
						$peserta['statusPeserta'] = $statusPeserta;
						$peserta['umur'] = $umur;
						

						$response["peserta"] = $peserta;
						
						 
						$var_detail_sep["metaData"] = $metaData;
						$var_detail_sep["response"] = $response;
						 

						$var_result["pesan_error"] =  $var_error;
						$var_result["hasil"]  = $var_detail_sep;
						
						$result = $var_result;
				 
				}

			 }
	
	return $result;
	
	
	
}
 

 
 
 
 
 
function getNamaRuangInap($kodeRuang){
	include("koneksi.php");
	$sql = mysqli_query($conn,'select * from m_ruang where no ='.$kodeRuang);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['no'];
		$val[] = $data['nama'];
	}else{
		$val[] = '';
	}
	return $val;
}


function getNamaKategoriTindakanTMNO($kode){
	include("koneksi.php");
	$sql = mysqli_query($conn,'SELECT * FROM simrs2012.l_tarif_sub_kelompok_2 where id = '.$kode);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['subkelompok2'];
	}else{
		$val = '';
	}
	return $val;
}


function getNamaJaminan($kode){
	include("koneksi.php");
	$sql = mysqli_query($conn,'SELECT * FROM simrs2012.m_carabayar where KODE ='.$kode);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['KODE'];
		$val[] = $data['NAMA'];
	}else{
		$val[] = '';
	}
	return $val;
}

function getInfoBedPasien($kode){
	include("koneksi.php");
	$sql = mysqli_query($conn,'SELECT * FROM simrs2012.m_detail_tempat_tidur where id = '.$kode);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['id'];
		$val[] = $data['idxruang'];
		$val[] = $data['no_tt'];
		$val[] = $data['NOMR'];
		$val[] = $data['KETERANGAN'];
	}else{
		$val[] = '';
	}
	return $val;
}

function getInfoKecamatan($kode){
	include("koneksi.php");
	$sql = mysqli_query($conn,'select * from m_kecamatan where idkecamatan = '.$kode);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['namakecamatan'];
	}else{
		$val = '';
	}
	return $val;
}

function getInfoKota($kode){
	include("koneksi.php");
	$sql = mysqli_query($conn,'SELECT * FROM simrs2012.m_kota where idkota = '.$kode);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['namakota'];
	}else{
		$val = '';
	}
	return $val;
}


function getNamaCaraPulang($kode){
	include("koneksi.php");
	$sql = mysqli_query($conn,'SELECT keterangan FROM simrs2012.m_statuskeluar where status = '.$kode);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['keterangan'];
	}else{
		$val = '-';
	}
	return $val;
}

function getNamaDokterByID($kode){
	include("koneksi.php");
	$sql = mysqli_query($conn,'SELECT NAMADOKTER FROM simrs2012.m_dokter where KDDOKTER =  '.$kode);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['NAMADOKTER'];
	}else{
		$val = '-';
	}
	return $val;
}

function getbiayaRawatInap($id_admisi,$nomr,$status_bayar,$kelas_perawatan){
	include("koneksi.php");
	$query = "SELECT SUM(x.total) as 'total_pembayaran' FROM ( Select a.tanggal,a.kode_tindakan, a.nama_tindakan,a.tarif,a.bhp,a.qty,(a.tarif*a.qty) as 'qty_tarif', (a.bhp*a.qty) as 'qty_bhp',((a.tarif*a.qty)+(a.bhp*a.qty)) as 'total' from t_admission_detail a where nomr = ".$nomr." and id_admission = ".$id_admisi." and statusbayar = ".$status_bayar." and kelas = ".$kelas_perawatan.") x";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['total_pembayaran'];
		$val[] = $query;
	}else{
		$val[] = '';
	}
	return $val; 
}


function getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas_perawatan,$kode_tindakan){
	include("koneksi.php");
	$query = "SELECT ifnull(SUM(x.qty_tarif),0)  as 'tarif', ifnull(SUM(x.total),0)  as 'total',ifnull(SUM(x.jumlah),0) as 'jumlah' FROM (SELECT a.*,a.qty as 'jumlah' , (a.qty*a.tarif) as 'qty_tarif', (a.qty*a.bhp) as 'qty_bhp', ((a.qty*a.tarif)+(a.qty*a.bhp)) as 'total' FROM simrs2012.t_admission_detail a where a.kode_tindakan = ".$kode_tindakan." and a.nomr = ".$nomr." and a.id_admission = ".$id_admisi." and a.statusbayar = ".$status_bayar." and a.kelas = ".$kelas_perawatan.") as x LIMIT 1";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['tarif'];
		$val[] = $data['total'];
		$val[] = $data['jumlah'];
		$val[] = $query;
	}else{
		$val[] = '';
	}
	return $val; 
}

function getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas_perawatan,$kode_kelompok){
	include("koneksi.php");
	$query = "SELECT ifnull(SUM(qty_tarif),0) as 'tarif' , ifnull(SUM(qty_bhp),0) as 'bhp', ifnull(SUM(total_kelompok_tindakan),0) as 'total' FROM (SELECT a.tarif,a.bhp,a.qty, (a.qty*a.tarif) as 'qty_tarif', (a.qty*a.bhp) as 'qty_bhp', ((a.qty*a.tarif)+(a.qty*a.bhp)) as 'total_kelompok_tindakan' FROM simrs2012.t_admission_detail a where a.kelompok_tindakan = ".$kode_kelompok." and a.nomr = ".$nomr." and a.id_admission = ".$id_admisi." and a.statusbayar = ".$status_bayar." and a.kelas = ".$kelas_perawatan." ) as x LIMIT 1";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['tarif'];
		$val[] = $data['bhp'];
		$val[] = $data['total'];
		$val[] = $query;
	}else{
		$val[] = '';
	}
	return $val; 
}


function getDetailTarif($kode_tarif){
	include("koneksi.php");
	$query = "SELECT * FROM simrs2012.m_data_tarif where kode = ".$kode_tarif;
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['id'];
		$val[] = $data['kode'];
		$val[] = $data['nama_tindakan'];
		$val[] = $data['kelompok_tindakan'];
		$val[] = $data['sub_kelompok1'];
		$val[] = $data['sub_kelompok2'];
		$val[] = $data['kelas'];
		$val[] = $data['tarif'];
		$val[] = $data['bhp'];
		$val[] = $query;
	}else{
		$val[] = '';
	}
	return $val; 
}


function getDataPendaftaranRajalbyIdx($idx){
	include("koneksi.php");
	$query = "select * from t_pendaftaran where IDXDAFTAR = ".$idx." LIMIT 1";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val['IDXDAFTAR'] = $data['IDXDAFTAR'];
		$val['PASIENBARU'] = $data['PASIENBARU'];
		$val['NOMR'] = $data['NOMR'];
		$val['TGLREG'] = $data['TGLREG'];
		$val['KDDOKTER'] = $data['KDDOKTER'];
		$val['KDPOLY'] = $data['KDPOLY'];
		$val['KDRUJUK'] = $data['KDRUJUK'];
		$val['KDCARABAYAR'] = $data['KDCARABAYAR'];
		$val['NAMAPOLITUJUAN_SEP'] = $data['NAMAPOLITUJUAN_SEP'];
		$val['sql'] = $query;
	}else{
		$val[] = '';
	}
	return $val; 
}



function getDataPasienbyNomr($nomr){
	include("koneksi.php");
	$query = "SELECT * FROM simrs2012.m_pasien where nomr = ".$nomr ." limit 1 ";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['id'];
		$val[] = $data['NOMR'];
		$val[] = $data['TITLE'];
		$val[] = $data['NAMA'];
		$val[] = $data['IBUKANDUNG'];
		$val[] = $data['TEMPAT'];
		$val[] = $data['TGLLAHIR'];
		$val[] = $data['JENISKELAMIN'];
		$val[] = $data['ALAMAT'];
		
		$val[] = $data['KELURAHAN'];
		$val[] = $data['KDKECAMATAN'];
		$val[] = $data['KOTA'];
		$val[] = $data['KDPROVINSI'];
		$val[] = $data['NOTELP'];
		$val[] = $query;
	}else{
		$val[] = '';
	}
	return $val; 
}


function getDataPasienPendaftaranbyNomr($nomr){
	include("koneksi.php");
	$query = "select 
id,
NOMR,
NO_KARTU,
JNS_PASIEN,
TITLE,
NAMA,
TEMPAT,
TGLLAHIR,
ALAMAT,
ALAMAT_KTP,
KDPROVINSI,
KOTA,
KDKECAMATAN,
KELURAHAN,
nama_ayah,
nama_ibu,
NOTELP,
NOKTP,
SUAMI_ORTU as 'NAMA_SUAMI',
nama_istri,
PEKERJAAN,
PENANGGUNGJAWAB_NAMA,
PENANGGUNGJAWAB_HUBUNGAN,
PENANGGUNGJAWAB_ALAMAT,
PENANGGUNGJAWAB_PHONE,
KD_ETNIS,
KD_BHS_HARIAN,
JENISKELAMIN,
STATUS as 'STATUS_PERKAWINAN',
PENDIDIKAN,
AGAMA
from m_pasien where NOMR =  ".$nomr ." limit 1 ";

	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val['code'] = "200";
		$val['message'] = "OK";
		$val['id'] = $data['id'];
		$val['NOMR'] = $data['NOMR'];
		$val['NO_KARTU'] = $data['NO_KARTU'];
		$val['JNS_PASIEN'] = $data['JNS_PASIEN'];
		
		$nama	= explode(',',str_replace('.',' ',$data['NAMA']));
		$val['NAMA'] = $nama[0];
		
		
		$a = datediff($data['TGLLAHIR'],date("Y-m-d"));
		$val['UMUR'] = $a[0]." tahun ".$a[1]." bulan ".$a[2]." hari";
		
		$val['TITLE'] = $data['TITLE'];
		$val['TEMPAT'] = $data['TEMPAT'];
		$val['TGLLAHIR'] = $data['TGLLAHIR'];
		$val['ALAMAT'] = $data['ALAMAT'];
		$val['ALAMAT_KTP'] = $data['ALAMAT_KTP'];
		$val['KDPROVINSI'] = $data['KDPROVINSI'];
		$val['KOTA'] = $data['KOTA'];
		$val['KDKECAMATAN'] = $data['KDKECAMATAN'];
		$val['KELURAHAN'] = $data['KELURAHAN'];
		$val['nama_ayah'] = $data['nama_ayah'];
		$val['nama_ibu'] = $data['nama_ibu'];
		$val['NOTELP'] = $data['NOTELP'];
		$val['NOKTP'] = $data['NOKTP'];
		$val['NAMA_SUAMI'] = $data['NAMA_SUAMI'];
		$val['nama_istri'] = $data['nama_istri'];
		$val['PEKERJAAN'] = $data['PEKERJAAN'];
		$val['PENANGGUNGJAWAB_NAMA'] = $data['PENANGGUNGJAWAB_NAMA'];
		$val['PENANGGUNGJAWAB_HUBUNGAN'] = $data['PENANGGUNGJAWAB_HUBUNGAN'];
		$val['PENANGGUNGJAWAB_HUBUNGAN'] = $data['PENANGGUNGJAWAB_HUBUNGAN'];
		$val['PENANGGUNGJAWAB_ALAMAT'] = $data['PENANGGUNGJAWAB_ALAMAT'];
		$val['PENANGGUNGJAWAB_PHONE'] = $data['PENANGGUNGJAWAB_PHONE'];
		$val['KD_ETNIS'] = $data['KD_ETNIS'];
		$val['KD_BHS_HARIAN'] = $data['KD_BHS_HARIAN'];
		$val['JENISKELAMIN'] = $data['JENISKELAMIN'];
		$val['STATUS_PERKAWINAN'] = $data['STATUS_PERKAWINAN'];
		$val['PENDIDIKAN'] = $data['PENDIDIKAN'];
		$val['AGAMA'] = $data['AGAMA'];
		//$val['query'] = $query;
	}else{
		
		$val['code'] = "401";
		$val['message'] = "Tidak ditemukan Data";
		//$val['query'] = $query;
	}
	return $val; 
}

function getNamaPasien_byNomr($nomr){
	include("koneksi.php");
	$query = "SELECT NAMA FROM simrs2012.m_pasien where nomr = ".$nomr ." limit 1 ";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['NAMA'];
	}else{
		$val = '';
	}
	return $val; 
}


function getNamaAkun5($kdAkun){
	include("koneksi.php");
	$query = "SELECT nama_akun FROM simrs2012.keu_akun5 where kd_akun = '".$kdAkun ."' LIMIT 1";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['nama_akun'];
	}else{
		$val = '';
	}
	return $val; 
}


function getNamaKegiatan($kdKegiatan){
	include("koneksi.php");
	$query = "SELECT nama_kegiatan FROM simrs2012.m_kegiatan where kode_kegiatan = '".$kdKegiatan ."' LIMIT 1";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['nama_kegiatan'];
	}else{
		$val = '';
	}
	return $val; 
}


function getNamaSubKegiatan($kdSubKegiatan){
	include("koneksi.php");
	$query = "SELECT nama_sub_kegiatan FROM simrs2012.m_sub_kegiatan where kode_sub_kegiatan = '".$kdSubKegiatan ."' LIMIT 1";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['nama_sub_kegiatan'];
	}else{
		$val = '';
	}
	return $val; 
}



function getTotalRekeningSPP($kode_detail_jenis,$tahun_anggaran){
	include("koneksi.php");
	$query = "select SUM(jumlah_belanja) as 'JUMLAH' from t_spp where detail_jenis_spp = '".$kode_detail_jenis."' and tahun_anggaran=  '".$tahun_anggaran ."' ";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val = $data['JUMLAH'];
	}else{
		$val = '';
	}
	return $val; 
}



function getDataAdmisibyId($idAdmisi){
	include("koneksi.php");
	$query = "SELECT * FROM simrs2012.t_admission where id_admission = ".$idAdmisi ." limit 1 ";
	$sql = mysqli_query($conn,$query);
	if(mysqli_num_rows($sql) > 0){
		$data = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		$val[] = $data['id_admission'];
		$val[] = $data['nomr'];
		$val[] = $data['parent_nomr'];
		$val[] = $data['dokterpengirim'];
		$val[] = $data['statusbayar'];
		$val[] = $data['kirimdari'];
		$val[] = $data['keluargadekat'];
		$val[] = $data['panggungjawab'];
		$val[] = $data['masukrs'];
		
		$val[] = $data['noruang'];
		$val[] = $data['tempat_tidur_id'];
		$val[] = $data['keluarrs'];
		$val[] = $data['KELASPERAWATAN_ID'];
		$val[] = $data['NO_SKP'];
		$val[] = $query;
	}else{
		$val[] = '';
	}
	return $val; 
}


function datediff($d1, $d2){
	$diff 	= abs(strtotime($d2) - strtotime($d1));
	$a	= array();
	$a[] 	= floor($diff / (365*60*60*24));
	$a[] = floor(($diff - $a[0] * 365*60*60*24) / (30*60*60*24));
	$a[] 	= floor(($diff - $a[0] * 365*60*60*24 - $a[1]*30*60*60*24)/ (60*60*24));
	return $a;
}

function Terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
	
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
	
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
	
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
	
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
	
  elseif ($x < 1000000000000)
    return Terbilang($x / 1000000000) . " milyar" . Terbilang(fmod($x,1000000000));
	
 elseif ($x < 1000000000000000)
    return Terbilang($x / 1000000000000) . " trilyun" . Terbilang(fmod($x,1000000000000));

}


function terbilang_style($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(Terbilang($x));
    } else {
        $hasil = trim(Terbilang($x)." RUPIAH");
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}



?> 