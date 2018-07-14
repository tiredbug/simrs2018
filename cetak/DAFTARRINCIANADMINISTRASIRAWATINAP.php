<?php
ob_start();
error_reporting(0);
session_start();

$pl = $_SESSION['PETUGASLOGIN'];
if (!isset($pl)) {
  $pl = '-';
} else {
  $pl;
}
date_default_timezone_set('Asia/Jakarta');
$counter_cetak;
include '../phpcon/koneksi.php';
include '../phpcon/fungsi_col.php';

$id_admisi = htmlspecialchars($_GET["home"]);
$nomr = htmlspecialchars($_GET["p1"]);
$status_bayar = htmlspecialchars($_GET["p2"]);
$kelas = htmlspecialchars($_GET["p3"]);

/*print '$id_admisi  '.$id_admisi.'</br>';
print '$nomr  '.$nomr.'</br>';
print '$status_bayar  '.$status_bayar.'</br>';
print '$kelas  '.$kelas.'</br>';*/



$sql_data_pasien_ranap = "SELECT * FROM simrs2012.t_admission where id_admission = ".$id_admisi."  LIMIT 1";
$result_data_pasien_ranap = $conn->query($sql_data_pasien_ranap);
$data_sql_data_pasien_ranap = $result_data_pasien_ranap->fetch_assoc();
/*echo "<pre>";
   	print_r($data_sql_data_pasien_ranap);
echo "</pre>";*/


if($data_sql_data_pasien_ranap['nomr']!= null)
{
	$sql_get_pasien = "SELECT * FROM simrs2012.m_pasien where NOMR = ".$data_sql_data_pasien_ranap['nomr']."  LIMIT 1";
	$result_get_pasien = $conn->query($sql_get_pasien);
	$data_get_pasien = $result_get_pasien->fetch_assoc();

	$total_pembayaran = getbiayaRawatInap($id_admisi,$nomr,$status_bayar,$kelas);
	
	
	$total_usg = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30313);
	$total_fisioterapi = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30325);
	$total_bimbingan_rohani = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30326);
	$total_perawatan_jenazah = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30327);
	$total_oksigen = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30328);
	$total_ambulan = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30329);
	$total_rontgen = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30314);
	$total_stscan = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30315);
	
	
	$total_visite_dokter_umum = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30316);
	$total_visite_dokter_spesialis = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30317);
	
	$total_konsul_dokter_umum = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30318);
	$total_konsul_dokter_spesialis = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30318);
	
	$total_konsul_vct = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30316);
	$total_konsul_vct = getBiayaPerKategoriBiaya($id_admisi,$nomr,$status_bayar,$kelas,30317);
	
	
	
	
	
	
	$total_tmno = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,1);
	$total_tindakan_keperawatan = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,2);
	$total_tindakan_kebidanan = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,3);
	$total_penunjang = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,4);
	$total_lain_lain = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,5);
	$total_visite_konsul_dokter = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,6);
	$total_visite_farmasi = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,7);
	$total_pelayanan = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,8);
	$total_konsul_dokter = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,9);
	$total_konsul_VCT = getBiayaPerKelompokBiaya($id_admisi,$nomr,$status_bayar,$kelas,10);
	
	$PelayananRMSIMRS = 0;
	$kode_pelayananRMSIMRS= 30320;
	$los;
	
	$keluar_rs = $data_sql_data_pasien_ranap['keluarrs'];  
	if ((is_null($keluar_rs)) || ($keluar_rs == NULL) || ($keluar_rs =='') )
	{
		//$PelayananRMSIMRS = 0;
		
		}else
		{
			//$PelayananRMSIMRS = 
			
			}

	
/*	
	print '<pre>';
	print_r($total_konsul_dokter);
	print '</pre>';
	*/
}
else{
	
}


$var_akomodasi_tanpa_makan;
$var_pelayanan_makan_perhari;
$var_visit_dokter;
$var_visit_farmasi;
$var_konsul_dokter;
$var_konsul_vct;
$var_asuhan_keperawatan;
$var_pelayanan_rm_simrs;
$var_pelayanan_non_medis;
$var_visit_farmasi;
$var_konsultasi_gizi;
$var_penunjang_rawat_inap;
$var_laboratorium_rawat_inap;

$var_tindakan_keperawatan;
$var_TMNO;
$var_TMNO_RANAP;
$var_TMNO_IBS_RANAP;

$var_tindakan_persalinan;
$var_bhp_tindakan;
$var_fisioterapi;
$var_bimbingan_rohani;
$var_perawatan_jenazah;
$var_oksigen;
$var_ambulan;    





?>
<html>
<head>
<title>CETAK RINCIAN ADMINISTRASI</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
@page {
  size: 21cm 33.0cm ;
  margin: 10;
}

body {  
    font-family: 'Courier';
	font-size:small;
}
.pagebreak { 
	page-break-before: always; 
}
	
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center">
    <td width="13%" rowspan="4"><img src="logo rs black.png" alt="ws" width="77" height="66" /></td>
    <td width="73%" align="center"><strong>PEMERINTAH DAERAH KABUPATEN </strong></td>
    <td width="14%" align="center">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">Jl. Raya Pancasan &ndash; Ajibarang, Kab. Banyumas, </td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">Email: rsudajibarang@banyumaskab.go.id</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<hr />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center">
    <td colspan="8">
    <?php 
		$r = $data_sql_data_pasien_ranap['keluarrs'];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
		print '<strong>&nbsp;&nbsp;R I N C I A N&nbsp;&nbsp;A D M I N I S T R A S I&nbsp;&nbsp;R A W A T&nbsp;&nbsp;I N A P &nbsp;&nbsp; S E M E N T A R A </strong>';
		}else
		{
			print '<strong>D A F T A R &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R I N C I A N&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A D M I N I S T R A S I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R A W A T&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I N A P </strong>';
			
		}?> 
    </td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">NAMA</td>
    <td width="1%" align="left" valign="top">:</td>
    <td width="35%" align="left" valign="top">&nbsp;<?php print $data_get_pasien['NAMA']; ?></td>
    <td width="2%" align="left" valign="top">&nbsp;</td>
    <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="19%" align="left" valign="top">NO RM</td>
    <td width="1%" align="left" valign="top">:</td>
    <td width="20%" align="left" valign="top">&nbsp;<?php print $data_get_pasien['NOMR']; ?></td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">UMUR</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">&nbsp;<?php
		$a = datediff($data_get_pasien['TGLLAHIR'], date("Y/m/d"));	
		print $a[0].' Th - '.$a[1].' Bl - '.$a[2].' Hr';
	?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">JK</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">&nbsp;<?php print $data_get_pasien['JENISKELAMIN'];?></td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">ALAMAT</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">&nbsp;<?php print $data_get_pasien['ALAMAT']; ?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="21%" align="left" valign="top">RUANG/KELAS</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">&nbsp;<?php $hh = getNamaRuangInap($data_sql_data_pasien_ranap['noruang']); print $hh[1];?>&nbsp;/&nbsp;<?php print $data_sql_data_pasien_ranap['KELASPERAWATAN_ID'];?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr align="center" valign="middle">
    <td align="left" valign="top">TANGGAL MASUK </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">&nbsp;<?php print date("d-m-Y", strtotime($data_sql_data_pasien_ranap['masukrs']));?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">TANGGAL KELUAR </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><?php 
		$r = $data_sql_data_pasien_ranap['keluarrs'];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
		print '<strong>Belum Dipulangkan</strong>';
		}else
		{
			print date("d-m-Y", strtotime($data_sql_data_pasien_ranap['keluarrs']));
		}?> </td>
  </tr>
  <tr align="center" valign="middle">
    <td align="left" valign="top">STATUS PASIEN </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">&nbsp;<?php  
	$a = getNamaJaminan($data_sql_data_pasien_ranap['statusbayar']);
	print $a[1];?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" >
  <tr align="center">
    <td align="center"><span class="style9">NO</span></td>
    <td align="center" valign="middle" class="style1"><span class="style9"><strong>KETERANGAN BIAYA </strong></span></td>
    <td colspan="3" align="center" valign="top" class="style1"><span class="style9"><strong>KETERANGAN TAMBAHAN </strong></span></td>
    <td align="right" valign="top"><span class="style9"><strong>JUMLAH</strong></span></td>
  </tr>
  <tr align="center">
    <td width="3%" align="center">1.</td>
    <td width="38%" align="left" valign="middle"><strong>Akomodasi</strong></td>
    <td width="6%" align="center" valign="top">&nbsp;</td>
    <td width="4%" align="center">&nbsp;</td>
    <td width="19%" align="center">&nbsp;</td>
    <td width="30%" align="right" valign="top">&nbsp;</td>
  </tr>
  <?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.getDetail_Akomodasi_pasien_rawat_inap(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
  
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php print '-'.$data['nama_tindakan']; ?></td>
    <td align="center" valign="top"><?php print $data['qty']; ?></td>
    <td align="center"><?php print ' x '; ?></td>
    <td align="center"><?php print number_format($data['tarif'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format(($data['tarif'] * $data['qty']),0,",","."); ?></td>
  </tr>
  
	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  
  
  <tr align="center">
    <td width="3%" align="center">&nbsp;</td>
    <td align="left" valign="middle"><strong>Pelayanan Makan</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.getDetail_pelayan_makan_pasien_rawat_inap(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
   <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php print ' - '.$data['nama_tindakan']; ?></td>
    <td align="center" valign="top"><?php print $data['qty']; ?></td>
    <td align="center"><?php print ' x '; ?></td>
    <td align="center"><?php print number_format($data['tarif'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format(($data['tarif'] * $data['qty']),0,",","."); ?></td>
  </tr>
  	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  
  
  <tr align="center">
    <td align="center">2.</td>
    <td align="left" valign="middle"><strong>Visit Dokter </strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print  number_format(($total_visite_dokter_umum[1]+$total_visite_dokter_spesialis[1]) ,0,",","."); ?></td>
  </tr>


<?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.tampil_list_palayanan_visite_dokter(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
  <tr align="center">
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top"><?php  print '-';?><?php  print ucwords(strtolower($data['NAMADOKTER']));?></td>
    <td align="center" valign="top"><?php  print $data['jumlah_visit'];?></td>
    <td align="center" valign="middle"><?php  print 'X';?></td>
    <td align="center" valign="middle"><?php  print number_format($data['tarif'],0,",",".");?></td>
    <td align="left" valign="top"><?php  print number_format($data['total'],0,",",".");?></td>
  </tr>
  <?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><strong>Konsultasi Dokter</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($total_konsul_dokter[0] ,0,",","."); ?></td>
  </tr>
  <?php
include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.tampil_list_palayanan_konsul_dokter(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		
		//print $sql;
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
  <tr align="center">
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top"><?php  print '-';?><?php  print ucwords(strtolower($data['NAMADOKTER']));?></td>
    <td align="center" valign="top"><?php  print $data['jumlah_visit'];?></td>
    <td align="center" valign="middle"><?php  print 'X';?></td>
    <td align="center" valign="middle"><?php  print number_format($data['tarif'],0,",",".");?></td>
    <td align="left" valign="top"><?php  print number_format($data['total'],0,",",".");?></td>
  </tr>
   <?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><strong>Konsultasi VCT</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($total_konsul_VCT[0],0,",","."); ?></td>
  </tr>
  
  
  
  <?php
include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.tampil_list_palayanan_konsul_VCT(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
  <tr align="center">
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top"><?php  print '-';?><?php  print ucwords(strtolower($data['NAMADOKTER']));?></td>
    <td align="center" valign="top"><?php  print $data['jumlah_visit'];?></td>
    <td align="center" valign="middle"><?php  print 'X';?></td>
    <td align="center" valign="middle"><?php  print $data['tarif'];?></td>
    <td align="left" valign="top"><?php  print $data['total'];?></td>
  </tr>
   <?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  
  
  
  <tr align="center">
    <td align="center">3.</td>
    <td align="left" valign="middle"><strong>Visit Farmasi</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;<?php print number_format($total_visite_farmasi[0],0,",","."); ?></td>
  </tr>
  <?php 
  		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.tampil_list_palayanan_visite_farmasi(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
  ?>
      <tr align="center">
        <td align="center">&nbsp;</td>
        <td align="left" valign="middle"><?php  print '-';?><?php  print $data['nama'];?></td>
        <td align="center" valign="top">&nbsp;<?php  print $data["jumlah_visit"];?></td>
        <td align="center" valign="middle">&nbsp;<?php  print 'x';?></td>
        <td align="center" valign="middle">&nbsp;<?php  print number_format($data['tarif'],0,",",".");?></td>
        <td align="left" valign="top">&nbsp;<?php  print number_format($data['total'],0,",",".");?></td>
      </tr>
  
  <?php
  	$no_urut++; }$conn->close();} else {}
   ?>
  
  <tr align="center">
    <td align="center">4.</td>
    <td align="left" valign="middle"><strong>Asuhan Keperawatan</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  
  
   <?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.getDetail_askep_pasien_rawat_inap(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
   <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php print ' - '.$data['nama_tindakan']; ?></td>
    <td align="center" valign="top"><?php print $data['qty']; ?></td>
    <td align="center"><?php print ' x '; ?></td>
    <td align="center"><?php print number_format($data['tarif'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format(($data['tarif'] * $data['qty']),0,",","."); ?></td>
  </tr>
  	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  
  
  <tr align="center">
    <td align="center">5.</td>
    <td align="left" valign="middle"><strong>Pelayanan RM &amp; SIMRS </strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.getDetail_pelayan_simrs_rawat_inap(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
   <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php print ' - '.$data['nama_tindakan']; ?></td>
    <td align="center" valign="top"><?php print $data['qty']; ?></td>
    <td align="center"><?php print ' x '; ?></td>
    <td align="center"><?php print number_format($data['tarif'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format(($data['tarif'] * $data['qty']),0,",","."); ?></td>
  </tr>
  	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  <tr align="center">
    <td align="center">6.</td>
    <td align="left" valign="middle"><strong>Pelayanan Penunjang Non-Medis</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.getDetail_pelayanan_nonmedis_pasien_rawat_inap(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
   <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="top"><?php print ' - '.$data['nama_tindakan']; ?></td>
    <td align="center" valign="top"><?php print $data['qty']; ?></td>
    <td align="center" valign="top"><?php print ' x '; ?></td>
    <td align="center" valign="top"><?php print number_format($data['tarif'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format(($data['tarif'] * $data['qty']),0,",","."); ?></td>
  </tr>
  	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  <tr align="center">
    <td align="center">7.</td>
    <td align="left" valign="middle"><strong>Konsultasi Gizi</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.getDetail_konsul_gizi_rawat_inap(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
   <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="top"><?php print ' - '.$data['nama_tindakan']; ?></td>
    <td align="center" valign="top"><?php print $data['qty']; ?></td>
    <td align="center" valign="top"><?php print ' x '; ?></td>
    <td align="center" valign="top"><?php print number_format($data['tarif'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format(($data['tarif'] * $data['qty']),0,",","."); ?></td>
  </tr>
  	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
  <tr align="center">
    <td align="center">8.</td>
    <td align="left" valign="middle"><strong>Penunjang Rawat Inap</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;<?php print  number_format($total_penunjang[0],0,",","."); ?></td>
  </tr>
  <?php 
  		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.tampil_list_pelayanan_penunjang(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
  ?>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php  print '-';?><?php  print $data['nama_tindakan'];?></td>
    <td align="center" valign="top">&nbsp;<?php  print $data["jumlah"];?></td>
    <td align="center" valign="middle">&nbsp;<?php  print 'x';?></td>
    <td align="center" valign="middle">&nbsp;<?php  print number_format($data["tarif"],0,",",".");?></td>
    <td align="left" valign="top">&nbsp;<?php  print number_format($data["total_tarif"],0,",",".");?></td>
  </tr>
   <?php
  	$no_urut++; }
	$conn->close();
	} else {}
   ?>
  <tr align="center">
    <td align="center">9.</td>
    <td align="left" valign="middle"><strong>Laboratorium Rawat Inap</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">10.</td>
    <td align="left" valign="middle"> <strong>Tindakan Keperawatan</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;<?php print number_format($total_tindakan_keperawatan[0],0,",","."); ?></td>
  </tr>
  <?php 
  		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.tampil_list_palayanan_keperawatan(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
  ?>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php  print '-';?><?php  print $data['nama'];?></td>
    <td align="center" valign="top">&nbsp;<?php  print $data['jumlah'];?></td>
    <td align="center">&nbsp;<?php  print 'x';?></td>
    <td align="center">&nbsp;<?php  print number_format($data['tarif'],0,",",".");?></td>
    <td align="left" valign="top">&nbsp;<?php  print number_format($data['total'],0,",",".");?></td>
  </tr>
   <?php
  	$no_urut++; }
	$conn->close();
	} else {}
   ?>
  <tr align="center">
    <td align="center">11.</td>
    <td align="left" valign="middle"><strong>TMNO</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;<?php print number_format($total_tmno[0],0,",","."); ?></td>
  </tr>
  
  <?php 
  		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.tampil_list_palayanan_tmno(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
  ?>
 <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php  print '-';?><?php  print $data['nama'];?></td>
    <td align="center" valign="top">&nbsp;<?php  print $data['jumlah'];?></td>
    <td align="center">&nbsp;<?php  print 'x';?></td>
    <td align="center">&nbsp;<?php  print number_format($data['tarif'],0,",",".");?></td>
    <td align="left" valign="top">&nbsp;<?php  print number_format($data['total'],0,",",".");?></td>
  </tr>
     <?php
  	$no_urut++; }
	$conn->close();
	} else {}
   ?>
  <tr align="center">
    <td align="center">12.</td>
    <td align="left" valign="middle"> <strong>TMNO Ranap</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">13.</td>
    <td align="left" valign="middle"><strong>TMNO IBS Ranap</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">14.</td>
    <td align="left" valign="middle"><strong>TMNO IBS (Terakhir)</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">15.</td>
    <td align="left" valign="middle"><strong>Tindakan Persalinan (Total+Bhp)</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($total_tindakan_kebidanan[2],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">16.</td>
    <td align="left" valign="middle"><strong>BHP Tindakan</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;<?php print number_format($total_tindakan_keperawatan[1],0,",","."); ?> + <?php print number_format($total_tmno[1],0,",","."); ?></td>
    <td align="right" valign="top">&nbsp;<?php print number_format(($total_tindakan_keperawatan[1]+$total_tmno[1]),0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">17.</td>
    <td align="left" valign="middle"><strong>Fisioterapi</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;<?php print number_format($total_fisioterapi[1],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">18.</td>
    <td align="left" valign="middle"><strong>Bimbingan Rohani</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($total_bimbingan_rohani[1],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">19.</td>
    <td align="left" valign="middle"><strong>Perawatan Jenazah</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($total_perawatan_jenazah[1],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">20.</td>
    <td align="left" valign="middle"><strong>Oksigen</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($total_oksigen[1],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">21.</td>
    <td align="left" valign="middle"><strong>Ambulance (Rujuk/Ct-Scan)</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($total_ambulan[1],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td colspan="2" align="center"><strong>JUMLAH TOTAL TAGIHAN RAWAT INAP</strong></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2" align="center"><strong style="font-size: x-large">&nbsp; <?php print 'Rp.'.number_format($total_pembayaran[0] ,0,",",".").';-' ?></strong></td>
  </tr>
</table>
</br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="6%">&nbsp;</td>
      <td width="35%">Petugas Kasir</td>
      <td width="33%">&nbsp;</td>
      <td width="26%">Petugas Ruang</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<div class="pagebreak"> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong>DATA COLLECTION FORM INA-DRG VERSI (1.6)</strong></td>
  </tr>
  <tr>
    <td><strong>RSUD AJIBARANG, JAWA TENGAH</strong></td>
  </tr>
  <tr>
    <td>Jl. Raya Pancasan, Ajibarang,Telp.(0281)6570002 6570004.<br/>Email: rsudajibarang@banyumaskab.go.id </td>
  </tr>
</table>
<hr />
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <th width="3%" align="center" valign="top" scope="col">NO</th>
      <th width="28%" align="center" valign="top" scope="col">ITEM</th>
      <th width="41%" align="center" valign="top" scope="col">KODE</th>
      <th width="28%" scope="col">KETERANGAN</th>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">1</th>
      <td align="left" valign="top">KODE RS</td>
      <td align="center" valign="top"><strong>3302191</strong></td>
      <td><strong>RSUD AJIBARANG </strong></td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">2</th>
      <td align="left" valign="top">KELAS</td>
      <td align="center" valign="top">C</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">3</th>
      <td align="left" valign="top">NO. REKAM MEDIS</td>
      <td align="center" valign="top">&nbsp;<?php print $data_get_pasien['NOMR']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">4</th>
      <td align="left" valign="top">NO. SKP</td>
      <td align="center" valign="top"><?php  print $data_sql_data_pasien_ranap['NO_SKP'];?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">5</th>
      <td align="left" valign="top">SURAT RUJUKAN</td>
      <td align="center" valign="top">&nbsp;</td>
      <td><span class="ket">1)Ada<br/>
      2)Tidak</span></td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">6</th>
      <td align="left" valign="top">NAMA PASIEN</td>
      <td align="center" valign="top">&nbsp;<?php print $data_get_pasien['NAMA']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">7</th>
      <td align="left" valign="top">KELAS PERAWATAN</td>
      <td align="center" valign="top">&nbsp;<?php print 'Kelas'.' '.$data_sql_data_pasien_ranap['KELASPERAWATAN_ID'];?></td>
      <td><span class="ket">1)Kelas I<br/>
2)Kelas II <br/>
3)Kelas III </span></td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">8</th>
      <td align="left" valign="top">CARA BAYAR</td>
      <td align="center" valign="top">&nbsp;<?php  $a = getNamaJaminan($data_sql_data_pasien_ranap['statusbayar']);print $a[1];?></td>
      <td><span class="ket">1)BPJS PBI<br/>
        2)BPJS NON PBI <br/>
        3)Umum <br/>
      4)Jamsostek</span></td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">9</th>
      <td align="left" valign="top">JENIS PERAWATAN</td>
      <td align="center" valign="top">&nbsp;<?php print 'Rawat Inap'; ?></td>
      <td><span class="style20">1)Rawat Inap<br/>
2)Rawat Jalan </span></td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">10</th>
      <td align="left" valign="top"><span class="style20">TANGGAL MASUK/JAM</span></td>
      <td align="center" valign="top">&nbsp;<?php print date("d-m-Y", strtotime($data_sql_data_pasien_ranap['masukrs']));?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">11</th>
      <td align="left" valign="top"><span class="style20">TANGGAL KELUAR/JAM</span></td>
      <td align="center" valign="top">&nbsp;<?php 
		$r = $data_sql_data_pasien_ranap['keluarrs'];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
		print '<strong>Belum Dipulangkan</strong>';
		}else
		{
			print date("d-m-Y", strtotime($data_sql_data_pasien_ranap['keluarrs']));
		}?> </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">12</th>
      <td align="left" valign="top"><span class="style20">JUMLAH LAMA DIRAWAT</span></td>
      <td align="center" valign="top">&nbsp;<?php print $data_sql_data_pasien_ranap['LOS'];?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">13</th>
      <td align="left" valign="top"><span class="style20">JENIS KELAMIN</span></td>
      <td align="center" valign="top">&nbsp;<?php print $data_get_pasien['JENISKELAMIN']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">14</th>
      <td align="left" valign="top"><span class="style20">CARA PULANG</span></td>
      <td align="center" valign="top">&nbsp;<?php print getNamaCaraPulang($data_sql_data_pasien_ranap['statuskeluarranap_id']);?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">15</th>
      <td align="left" valign="top"><span class="style20">BERAT LAHIR (gram)</span></td>
      <td align="center" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">16</th>
      <td align="left" valign="top"><span class="style20">DIAGNOSA PRIMER</span></td>
      <td align="center" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">17</th>
      <td align="left" valign="top"><span class="style20">DIAGNOSA SEKUNDER</span></td>
      <td align="center" valign="top">&nbsp;</br></br></br></br></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">18</th>
      <td align="left" valign="top"><span class="style20">TINDAKAN</span></td>
      <td align="center" valign="top">&nbsp;</br></br></br></br></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">19</th>
      <td align="left" valign="top"><span class="style20">SEBAB CEDERA</span></td>
      <td align="center" valign="top">&nbsp;</br></br></br></br></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">20</th>
      <td align="left" valign="top"><span class="style20">TOTAL BIAYA RIL </span></td>
      <td align="center" valign="top">&nbsp;</td>
      <td>&nbsp; <?php print 'Rp.'.number_format($total_pembayaran[0] ,0,",",".").';-' ?></strong></td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">21</th>
      <td align="left" valign="top"><span class="style20">KODE INA-DRG </span></td>
      <td align="center" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">22</th>
      <td align="left" valign="top"><span class="style20">DPJP</span></td>
      <td align="center" valign="top">&nbsp;
	  <?php  print ucwords(strtolower(getNamaDokterByID($data_sql_data_pasien_ranap['dokter_penanggungjawab'])));?>
	  <?php //print getNamaDokterByID($data_sql_data_pasien_ranap['dokter_penanggungjawab']);?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th align="center" valign="top" scope="row">23</th>
      <td align="left" valign="top"><span class="style20">PENGESAHAN SEV.LEVEL</span></td>
      <td align="center" valign="top">&nbsp;</td>
      <td><span class="style20">1)Ada <br/>
      2)Tidak </span></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="4%">&nbsp;</td>
      <td width="62%">&nbsp;</td>
      <td width="34%">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Form Pengumpulan Data INA-DRG</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Versi 1.6</td>
    </tr>
  </tbody>
</table>
</body>
</html>
<?php
//$conn->close();
$html = ob_get_clean();
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isJavascriptEnabled', TRUE);
$dompdf = new Dompdf($options);
$dompdf->set_option('chroot', __DIR__);
$dompdf->set_option('enable_font_subsetting', true);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isJavascriptEnabled', true);
$dompdf->set_option('enable_remote', TRUE);
$dompdf->set_option('enable_css_float', TRUE);
$dompdf->load_html($html);
$dompdf->setPaper('F4', 'portrait');
$dompdf->render();
$dompdf->stream('LaporanAdministrasiPasienRawatInap.pdf',array('Attachment' => 0));
?>

















