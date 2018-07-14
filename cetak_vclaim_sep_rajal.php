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

		include 'phpcon/koneksi.php'; 
		include 'phpcon/fungsi_col.php';
		
		error_reporting(0);
		date_default_timezone_set('Asia/Jakarta');
		$jam_cetak = date("d/m/Y H:i:s A"); 
		
		//print $today;
		$counter_cetak;

		//$sep = "1111R0100318V000009";
		$sep = $_GET["no"];
		$idx = $_GET["id"];
		
		
		$detail_sep = getdetailSEP($sep);
		$noka = $detail_sep['hasil']['response']['peserta']['noKartu']; //"0000527697022";
		$detail_kepesertaan_bpjs = get_detail_keanggotaanBPJS_by_kartu($noka);
		
		//echo '<pre>';
		//print_r($detail_kepesertaan_bpjs );
		//echo '</pre>';
		
		
		$sql2 = "select counter_cetak_kartu + 1 as 'counter_cetak_kartu',USER  from t_pendaftaran where IDXDAFTAR =".htmlspecialchars($idx)." limit 1";
		$result2 = $conn->query($sql2);
		$data2 = $result2->fetch_assoc();
		$today = date("d/m/Y H:i:s A"); 
		
		 // update 
		$update_sql= "UPDATE t_pendaftaran SET counter_cetak_kartu = counter_cetak_kartu + 1 WHERE IDXDAFTAR = ". htmlspecialchars($idx);
		$eeeeee = $conn->query($update_sql);

		/*echo '<pre>';
		print_r($detail_kepesertaan_bpjs);
		echo '</pre>';*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CETAK SEP</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
@page { margin: 1px; }
body {
	margin: 1px;
	font-family: 'Courier';
font-size: 13px;	}
.style11 {font-size: 9px;}
.style12 {font-size: 12px;}
.style14 {
	font-size: 27px;
	font-weight: bold;
}
.style15 {font-size: large}
</style>
</head>

<body  onload="window.print();">


<?php

$code = $detail_sep['hasil']['metaData']['code'];
$status = $detail_sep['pesan_error']['status'] ;
if($code == 200 && $status == 'sukses')
{
?>
<table width="100%" border="0">
  <tr>
    <td width="11%" rowspan="3"><img src="logo bpjs.png" alt="bpjs" width="94" height="30" /></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="center" ><strong>SURAT ELEGIBILITAS PESERTA </strong></div></td>
    <td colspan="3" rowspan="2"><strong>SIMRS 2018 </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center" valign="middle"><strong>RSUD AJIBARANG </strong></td>
  </tr>
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="47%"></td>
    <td width="9%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span >No.SEP</span></td>
    <td><span  >:</span></td>
    <td><span class="style14"><?php echo $detail_sep['hasil']['response']['noSep'] ?></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span >Tgl.SEP</span></td>
    <td><span  >:</span></td>
    <td>
      <span ><?php echo $detail_sep['hasil']['response']['tglSep']; ?>   </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span >No.Kartu</span></td>
    <td><span  >:</span></td>
    <td><span  ><?php echo $detail_sep['hasil']['response']['peserta']['noKartu']; ?> &nbsp;&nbsp;&nbsp;&nbsp; No MR: <?php echo $detail_sep['hasil']['response']['peserta']['noMr']; ?></span></td>
    <td><span >Peserta</span></td>
    <td><span  >:</span></td>
    <td colspan="2"><?php echo $detail_sep['hasil']['response']['peserta']['jnsPeserta']; ?></td>
  </tr>
  <tr align="left" valign="top">
    <td><span >Nama Peserta </span></td>
    <td><span  >:</span></td>
    <td><?php echo $detail_sep['hasil']['response']['peserta']['nama']; ?></td>
    <td><span ><span class="style12">COB</span></span></td>
    <td>&nbsp;</td>
    <td colspan="2"><span >
	<?php 
	$status = $detail_kepesertaan_bpjs['hasil']['metaData']['code']; 
	if($status != 200)
	{
		echo $detail_kepesertaan_bpjs['hasil']['metaData']['message'];
	}else
	{
		echo  $detail_kepesertaan_bpjs['hasil']['response']['peserta']['cob']['nmAsuransi']." - ".$detail_kepesertaan_bpjs['hasil']['response']['peserta']['cob']['noAsuransi'];
	}
	
	 ?>
	
	</span></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Tgl.Lahir</span></td>
    <td><span class="style12"  >:</span></td>
    <td><?php echo $detail_sep['hasil']['response']['peserta']['tglLahir']; ?>&nbsp;&nbsp; Jenis Kelamin : <?php echo $detail_sep['hasil']['response']['peserta']['kelamin']; ?></td>
    <td><span class="style12">Jns.Rawat</span></td>
    <td><span class="style12"  >:</span></td>
    <td colspan="2"><?php echo $detail_sep['hasil']['response']['jnsPelayanan']; ?></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >No. Telepon </span></td>
    <td><span class="style12"  >:</span></td>
    <td>
	<?php 
	$status = $detail_kepesertaan_bpjs['hasil']['metaData']['code']; 
	if($status != 200)
	{
		//echo $detail_kepesertaan_bpjs['hasil']['metaData']['message'];
	}else
	{
		echo  $detail_kepesertaan_bpjs['hasil']['response']['peserta']['mr']['noTelepon'];
	}
	
	 ?>	</td>
    <td><span class="style12">Kelas Rawat </span></td>
    <td><span class="style12"  >:</span></td>
    <td colspan="2"><?php echo $detail_sep['hasil']['response']['kelasRawat']; ?></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Poli Tujuan </span></td>
    <td><span class="style12"  >:</span></td>
    <td><?php echo $detail_sep['hasil']['response']['poli']; ?></td>
    <td>Penjamin</td>
    <td><span class="style12"  >:</span></td>
    <td colspan="2"><?php echo $detail_sep['hasil']['response']['penjamin']; ?></td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Faskes Perujuk </span></td>
    <td><span class="style12"  >:</span></td>
    <td>
	<?php 
	$status = $detail_kepesertaan_bpjs['hasil']['metaData']['code']; 
	if($status != 200)
	{
		echo $detail_kepesertaan_bpjs['hasil']['metaData']['message'];
	}else
	{
		echo $detail_kepesertaan_bpjs['hasil']['response']['peserta']['provUmum']['kdProvider']." - ".$detail_kepesertaan_bpjs['hasil']['response']['peserta']['provUmum']['nmProvider'];
	}
	
	 ?>	</td>
    <td>&nbsp;</td>
    <td><span class="style12"></span></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Diagnosa Awal </span></td>
    <td><span class="style12"  >:</span></td>
    <td><?php echo $detail_sep['hasil']['response']['diagnosa']; ?></td>
    <td><p class="style12" >&nbsp;</p>    </td>
    <td><span class="style12"></span></td>
    <td width="26%"><p class="style12" >&nbsp;</p>    </td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td><span class="style12" >Catatan</span></td>
    <td><span class="style12"  >:</span></td>
    <td><?php echo $detail_sep['hasil']['response']['catatan']; ?></td>
    <td>&nbsp;</td>
    <td><span class="style12"></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td colspan="3" align="left" valign="top"><span class="style11" >*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan. </span></td>
    <td colspan="3"><span class="style12">Pasien/Keluarga Pasien </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="style11" >*SEP bukan sebagai bukti penjamin peserta </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="left" valign="top"><span class="style11" >Cetakan ke <?php print $data2['counter_cetak_kartu']; ?> -  <?php print $jam_cetak; ?> </span></td>
    <td>_______________</td>
    <td>&nbsp;</td>
    <td></td>
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
	 echo $detail_sep['hasil']['metaData']['message']."<br/>";
	 //echo 'Hubungi BPJS';
}
?>


</body>
</html>

<?php

}

?>
