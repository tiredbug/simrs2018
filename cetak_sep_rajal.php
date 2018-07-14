<?php
if (session_id() == "") 
	session_start(); 
	ob_start();
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once "phpfn13.php" ?>
<?php
if (!IsLoggedIn()) {
    echo "Akses ditolak. Silahkan <a href='login.php'>login</a> terlebih dulu!<br>";
} else {

?>
<?php

error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$counter_cetak;
include 'phpcon/koneksi.php';
//$sep = "1111R01004170001764";


$sep = $_GET["no"];
$idx = $_GET["id"];


$sql = "SELECT * FROM  l_konfigurasi_ws  where id = 1";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

// select+1
$sql2 = "select counter_cetak_kartu + 1 as 'counter_cetak_kartu',USER  from t_pendaftaran where IDXDAFTAR =".htmlspecialchars($idx)." limit 1";
$result2 = $conn->query($sql2);
$data2 = $result2->fetch_assoc();
$today = date("d/m/Y H:i:s A"); 

 // update 
$update_sql= "UPDATE t_pendaftaran SET counter_cetak_kartu = counter_cetak_kartu + 1 WHERE IDXDAFTAR = ". htmlspecialchars($idx);
$eeeeee = $conn->query($update_sql);
//$dataaaa = $eeeeee->fetch_assoc();





$consumer_id = $data['consid_sep']; 
$secretKey = $data['secretkey_sep'];
$url = "http://192.168.1.104:8080/WsLokalRest/SEP/".$sep;
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
$result = file_get_contents($url, false, $context);

if ($result === false) 
{ 
	echo "Tidak dapat menyambung ke server"; 
}
else 
{ 
 	$resultarr = json_decode($result, true);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CETAK SEP</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
@page { margin: 1px; }
body { margin: 1px; }
.style11 {font-size: x-small}
.style12 {font-size: small}
.style13 {font-size: medium}
.style14 {
	font-size: x-large;
	font-weight: bold;
}
.style15 {font-size: large}
</style>
</head>

<body>

<?php
if($resultarr['metadata']['code']== 200  )
{
?>
<table width="100%" border="0">
  <tr>
    <td width="13%" rowspan="3"><img src="logo bpjs.png" alt="bpjs" width="131" height="46" /></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="center" ><strong>SURAT ELEGIBILITAS PESERTA </strong></div></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center" valign="middle"><strong>RSUD AJIBARANG </strong></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="66%"></td>
    <td width="9%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span >No.SEP</span></td>
    <td><span  >:</span></td>
    <td><span class="style14"><?php echo $resultarr['response']['noSep']; ?></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span >Tgl.SEP</span></td>
    <td><span  >:</span></td>
    <td>
      <span >
      <?php echo $resultarr['response']['tglSep']; ?>      </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span >No.Kartu</span></td>
    <td><span  >:</span></td>
    <td><span ><?php echo $resultarr['response']['peserta']['noKartu']; ?>  No MR: <?php echo $resultarr['response']['peserta']['noMr']; ?></span></td>
    <td><span >Peserta</span></td>
    <td><span  >:</span></td>
    <td colspan="2"><span ><?php echo $resultarr['response']['peserta']['jenisPeserta']['nmJenisPeserta']; ?> </span></td>
  </tr>
  <tr align="left" valign="top">
    <td><span >Nama Peserta </span></td>
    <td><span  >:</span></td>
    <td><span ><?php  echo $resultarr['response']['peserta']['nama']; ?></span></td>
    <td><span ></span></td>
    <td>&nbsp;</td>
    <td colspan="2"><span ></span></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Tgl.Lahir</span></td>
    <td><span class="style12"  >:</span></td>
    <td><span class="style12" ><?php  echo $resultarr['response']['peserta']['tglLahir']; ?></span></td>
    <td><span class="style12" >COB</span></td>
    <td><span class="style12"  >:</span></td>
    <td colspan="2"><span class="style12" ><?php echo $resultarr['response']['statusCOB']['namaCOB']; ?></span></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Jns.Kelamin</span></td>
    <td><span class="style12"  >:</span></td>
    <td><span class="style12" ><?php echo $resultarr['response']['peserta']['sex']; ?></span></td>
    <td><span class="style12" >Jns.Rawat</span></td>
    <td><span class="style12"  >:</span></td>
    <td colspan="2"><span class="style12" ><?php echo $resultarr['response']['jnsPelayanan']; ?></span></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Poli Tujuan </span></td>
    <td><span class="style12"  >:</span></td>
    <td><span class="style12" ><?php echo $resultarr['response']['poliTujuan']['kdPoli']; ?> - <?php echo $resultarr['response']['poliTujuan']['nmPoli']; ?></span></td>
    <td><span class="style12" >Kelas Rawat </span></td>
    <td><span class="style12"  >:</span></td>
    <td colspan="2"><span class="style12" ><?php /*echo $resultarr['response']['klsRawat']['nmKelas']; */  echo $resultarr['response']['peserta']['kelasTanggungan']['nmKelas'];?></span></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Asal Faskes Tingkat I </span></td>
    <td><span class="style12"  >:</span></td>
    <td><span class="style12" ><?php echo $resultarr['response']['provRujukan']['kdProvider']; ?>, <?php echo $resultarr['response']['provRujukan']['nmProvider']; ?></span></td>
    <td>&nbsp;</td>
    <td><span class="style12"></span></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Diagnosa Awal </span></td>
    <td><span class="style12"  >:</span></td>
    <td><span class="style12" ><?php echo $resultarr['response']['diagAwal']['kdDiag']; ?> - <?php echo $resultarr['response']['diagAwal']['nmDiag']; ?></span></td>
    <td><p class="style12" >Pasien/</p>    </td>
    <td><span class="style12"></span></td>
    <td width="9%"><p class="style12" >Petugas</p>    </td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Catatan</span></td>
    <td><span class="style12"  >:</span></td>
    <td><span class="style12" ><?php echo $resultarr['response']['catatan']; ?></span></td>
    <td><span class="style12" >Keluarga Pasien </span></td>
    <td><span class="style12"></span></td>
    <td><span class="style12" >BPJS Kesehatan</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td colspan="3" align="left" valign="top"><span class="style7 style11" >*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan. </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="style7 style11" >*SEP bukan sebagai bukti penjamin peserta </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="style13" >Cetakan ke <?php print $data2['counter_cetak_kartu']; ?> -  <?php echo $today ?> </span></td>
    <td>_______________</td>
    <td>&nbsp;</td>
    <td>_______________</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="style11">Petugas RS </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="style11"></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="style6 style15"><?php echo  CurrentUserName();//$data2['USER']; ?></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
}else
{
	echo $resultarr['metadata']['message'];
}
?>


</body>
</html>
<?php

}
$conn->close();
/*$html = ob_get_clean();
require_once("../../dompdf_baru/dompdf_config.inc.php");
$customPaper = array(0,0,625,440);
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper($customPaper);
$dompdf->render();
$dompdf->stream('SEP'.'_.pdf',array('Attachment' => 0)); 
*/
?>