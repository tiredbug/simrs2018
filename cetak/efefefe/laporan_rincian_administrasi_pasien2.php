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
include '../../include/koneksi.php';
include '../../include/function.php';



$sql_data_pasien_ranap = "SELECT * FROM simrs2012.t_admission where id_admission = ". htmlspecialchars($_GET["id_admission"])."  LIMIT 1";
$result_data_pasien_ranap = $conn->query($sql_data_pasien_ranap);
$data_sql_data_pasien_ranap = $result_data_pasien_ranap->fetch_assoc();
$data_identitas = getDataIdentitasPasienRawatInap($data_sql_data_pasien_ranap['id_admission']);

?>
<html>
<head>
<title>CETAK RINCIAN ADMINISTRASI</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
@page {
  size: 21cm 33.0cm ;
  margin: 5;
}

body {  
    font-family: 'Courier';
	font-size:small;
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
    <td colspan="8"><strong>D A F T A R &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R I N C I A N&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A D M I N I S T R A S I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R A W A T&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I N A P </strong></td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">NAMA</td>
    <td width="1%" align="left" valign="top">:</td>
    <td width="35%" align="left" valign="top"><?php print $data_identitas[1]; ?></td>
    <td width="2%" align="left" valign="top">&nbsp;</td>
    <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="19%" align="left" valign="top">NO RM</td>
    <td width="1%" align="left" valign="top">:</td>
    <td width="20%" align="left" valign="top"><?php print $data_identitas[9]; ?></td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">UMUR</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><?php 

	$p =  $data_identitas[2];
	$a = datediff($p, date("Y/m/d"));
	echo $a[years].' tahun '.$a[months].' bulan';
	
	?></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">JK</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><?php print $data_identitas[8]; ?></td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">ALAMAT</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">	  <?php //print ucwords(strtolower($q3['ALAMAT'].', kec.'.$q3['namakecamatan'])); 
	print $data_identitas[3].'-'.$data_identitas[5];
	
	?>
	</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="21%" align="left" valign="top">RUANG/KELAS</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><?php //echo ucwords(strtolower($q3['NAMARUANGRAWAT']));
		print $data_identitas[10].' / '.$data_identitas[14];
	  ?>
    </td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr align="center" valign="middle">
    <td align="left" valign="top">TANGGAL MASUK </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">      <?php  //print date("d-m-Y", strtotime($q3['masukrs'])); 
	//print $data_identitas[16];
	print date("d-m-Y", strtotime($data_identitas[15]));
	?>    </td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">TANGGAL KELUAR </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"> <?php  //print date("d-m-Y", strtotime($q3['keluarrs']));
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print 'belum dipulangkan';
		}else
		{
			
			print date("d-m-Y", strtotime($data_identitas[12]));
		}
	 ?> </td>
  </tr>
  <tr align="center" valign="middle">
    <td align="left" valign="top">STATUS PASIEN </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><strong><?php print $data_identitas[13];  ?></strong></td>
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
    <td width="35%" align="left" valign="middle">Karcis, Tindakan IGD </td>
    <td width="14%" align="center" valign="top">&nbsp;</td>
    <td width="6%" align="center">&nbsp;</td>
    <td width="20%" align="center">&nbsp;</td>
    <td width="22%" align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td width="3%" align="center">&nbsp;</td>
    <td align="left" valign="middle">a. Tindakan IGD </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php //print number_format($DATA_PENDAFTARAN['TOT_TIND_IGD'],0,",",".");
	//$rrrrr = 194842;
	$rr = getTotalBillRanap_tindakan_igd(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr,0,",",".");
	
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">b. Tindakan Poli </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php // print number_format($DATA_PENDAFTARAN['TOT_TIND_RAJAL'],0,",",".");
		$rr = getTotalBillRanap_tindakan_poli(htmlspecialchars($_GET["id_admission"]));
		print number_format($rr,0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">2.</td>
    <td align="left" valign="middle">Akomodasi</td>
    <td align="center" valign="top"><?php 
	
		//print $DATA_PENDAFTARAN['LOS'];
		
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			print $r;
		}
	
	 ?></td>
    <td align="center">x</td>
    <td align="center">
	<?php 

		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			$koef = $data_identitas[16];
			$total = $koef*$r;
			print number_format($koef ,0,",",".");
		}
	
	 ?>	</td>
    <td align="right" valign="top"><?php 
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			$koef = $data_identitas[16];
			$total = $koef*$r;
			print number_format($total ,0,",",".");
		}
	
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">3.</td>
    <td align="left" valign="middle">Visit Dokter </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
 <?php 
 	
	$sql = "SELECT 
				a.dokterid_on_visit,
				b.NAMADOKTER,a.harga_on_visit,
				COUNT(a.tindakandetailvisitdokter_id) as 'VISIT', 
				COUNT(a.tindakandetailvisitdokter_id) *
				a.harga_on_visit as 'subtotal' 
			FROM t_tindakan_detail_visit_dokter a 
			LEFT OUTER JOIN m_dokter b ON (a.dokterid_on_visit=b.KDDOKTER) 
			WHERE admission_id_on_visit = 187302 
			group by dokterid_on_visit  LIMIT 1";
	$result = $conn->query($sql);
	$n=1;
	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		?>
  <tr align="center">
	<td align="center">&nbsp;- </td>
			<td align="left" valign="middle"><?php echo ucwords(strtolower($row['NAMADOKTER'])); ?></td>
			<td align="center" valign="top"><?php print $row['VISIT'];  ?></td>
	<td align="center">x</td>
			<td align="center"><?php print number_format($row['harga_on_visit'],0,",","."); ?></td>
			<td align="right" valign="top"><?php print number_format($row['subtotal'],0,",","."); ?></td>
		  </tr>
		<?php
		}
	} else {
		echo "0 results";
	}
  ?>
  <tr align="center">
    <td align="center">4</td>
    <td align="left" valign="middle">Asuhan Keperawatan </td>
    <td align="center" valign="top"><?php 
	
		//print $DATA_PENDAFTARAN['LOS'];
		
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			print $r;
		}
	
	 ?></td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle"><?php 

		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			$koef = $data_identitas[17];
			$total = $koef*$r;
			print number_format($koef ,0,",",".");
		}
	
	 ?></td>
    <td align="right" valign="top"><?php 
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19];  
			$koef = $data_identitas[17];
			$total = $koef*$r;
			print number_format($total ,0,",",".");
		}
	
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">5</td>
    <td align="left" valign="middle">Pelayanan RM &amp; SIMRS </td>
    <td align="center" valign="top"><?php 
	
		//print $DATA_PENDAFTARAN['LOS'];
		
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			print $r;
		}
	
	 ?></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php 
	
		//print $DATA_PENDAFTARAN['LOS'];
		
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[20]; 
			print number_format($r ,0,",",".");
		}
	
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">6</td>
    <td align="left" valign="middle">Pelayanan Penunjang Non-Medis </td>
    <td align="center" valign="top"><?php 
	
		//print $DATA_PENDAFTARAN['LOS'];
		
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			print $r;
		}
	
	 ?></td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle"><?php 

		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			$koef = $data_identitas[18];
			$total = $koef*$r;
			print number_format($koef ,0,",",".");
		}
	
	 ?></td>
    <td align="right" valign="top"><?php 
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19];  
			$koef = $data_identitas[18];
			$total = $koef*$r;
			print number_format($total ,0,",",".");
		}
	
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">7</td>
    <td align="left" valign="middle">Konsultasi Gizi </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle"><?php 
		$rr = getTotalBillRanap_gizi(htmlspecialchars($_GET["id_admission"]));
		print number_format($rr,0,",",".");
	 ?></td>
    <td align="right" valign="top"><?php
		$rr = getTotalBillRanap_gizi(htmlspecialchars($_GET["id_admission"]));
		print number_format($rr,0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">8</td>
    <td align="left" valign="middle">Penunjang</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">Radiologi</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">a</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php $rr = getTotalBillRanap_radiologi(htmlspecialchars($_GET["id_admission"])); print number_format($rr,0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">b</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">9</td>
    <td align="left" valign="middle">Laboratorium</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">a.IGD</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php $rr = getTotalBillRanap_lab_igd(htmlspecialchars($_GET["id_admission"])); print number_format($rr,0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">b.POLI &amp; CDR </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php //getTotalBillRanap_lab_poli_kamar_inap print number_format($DATA_PENDAFTARAN['TOT_BIAYA_CDRPOLI'],0,",","."); 
	$rr = getTotalBillRanap_lab_poli_kamar_inap(htmlspecialchars($_GET["id_admission"])); print number_format($rr,0,",",".");?></td>
  </tr>
  <tr align="center">
    <td width="3%" align="center">10.</td>
    <td width="35%" align="left" valign="middle">Tindakan Keperawatan </td>
    <td width="14%" align="center" valign="top">&nbsp;</td>
    <td width="6%" align="center">&nbsp;</td>
    <td width="20%" align="center">&nbsp;</td>
    <td width="22%" align="right" valign="top"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[1],0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sederhana</td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	print $rr[3];
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Kecil</td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[4],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sedang</td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[5],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Besar</td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[6],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Khusus</td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[7],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">11.</td>
    <td align="left" valign="middle">TMNO</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php
	$rr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[1],0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sederhana </td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[3],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Kecil </td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[4],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sedang </td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[5],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Besar </td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[6],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Khusus </td>
    <td align="center" valign="top"><?php
	$rr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[7],0,",",".");
	 ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">12.</td>
    <td align="left" valign="middle">TMO</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["id_admission"]));
			print number_format($rr[15],0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">a.</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">b.</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">13.</td>
    <td align="left" valign="middle">BHP Tindakan </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[2],0,",",".");
	 ?>+<?php
	$rr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	print number_format($rr[2],0,",",".");
	 ?></td>
    <td align="right" valign="top"><?php
	$rr = getBiaya_bhp_perawatan_ranap(htmlspecialchars($_GET["id_admission"]));
	$bhp_perawat = $rr[2];
	
	$rrr = getBiaya_bhp_tindakan_dokter_ranap(htmlspecialchars($_GET["id_admission"]));
	$bhp_dokter = $rrr[2];
	 
	$total = $bhp_perawat+$bhp_dokter;
	print number_format($total,0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">14</td>
    <td align="left" valign="middle">BHP Laboratorium </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">15</td>
    <td align="left" valign="middle">BHP Radiologi </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">16</td>
    <td align="left" valign="middle">Fisioterapi</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["id_admission"]));
			print number_format($rr[7],0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">17</td>
    <td align="left" valign="middle">IPJ</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">18</td>
    <td align="left" valign="middle">Obat</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"></td>
  </tr>
  <tr align="center">
    <td align="center">19.</td>
    <td align="left" valign="middle">Oksigen</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["id_admission"]));
			print number_format($rr[11],0,",",".");
	 ?></td>
  </tr>
  <tr align="center">
    <td align="center">20.</td>
    <td align="left" valign="middle">Ambulance</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["id_admission"]));
			print number_format($rr[17],0,",",".");
	 ?></td>
	
	<?php
		$SQL_TINDAKAN_LAIN_LAIN = "select a.kode_tindakan_on_lainlain,b.namatindakan,count(a.kode_tindakan_on_lainlain) as 'JUMLAH',
		a.harga_on_lainlain,a.qty_on_lainlain,a.subtotal_on_lainlain from t_tindakan_detail_lainlain a 
		LEFT OUTER JOIN m_tindakan_tarif b ON (a.kode_tindakan_on_lainlain=b.tindakantarif_id)
		WHERE admision_id_on_lainlain =" . htmlspecialchars($_GET["id_admission"])." GROUP BY kode_tindakan_on_lainlain " ;
		//echo $SQL_TINDAKAN_LAIN_LAIN;
		$NORECORD=21;
		$QUERY_TINDAKAN_LAIN_LAIN = $conn->query($SQL_TINDAKAN_LAIN_LAIN);
		if ($QUERY_TINDAKAN_LAIN_LAIN->num_rows > 0) {
    	while($DATA_TINDAKAN_LAIN_LAIN = $QUERY_TINDAKAN_LAIN_LAIN->fetch_assoc()) {
	?>
  </tr>
  <tr align="center">
    <td align="center"><?php print $NORECORD; ?></td>
    <td align="left" valign="middle"><?php print $DATA_TINDAKAN_LAIN_LAIN['namatindakan']; ?></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">
	<!--<?php print $DATA_TINDAKAN_LAIN_LAIN['JUMLAH'].' x '; ?> 
	<?php print number_format($DATA_TINDAKAN_LAIN_LAIN['harga_on_lainlain'],0,",","."); ?>-->	</td>
    <td align="right" valign="top">
	<?php print number_format($DATA_TINDAKAN_LAIN_LAIN['subtotal_on_lainlain'],0,",","."); ?></td>
  </tr>
	 <?php $NORECORD++; }} else {} ?>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">JUMLAH TOTAL </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">Rp. 
    <?php 
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{//LOS 		
			$LOS = $data_identitas[19]; 
			//KOEFISIEN AKOMODASI
			$koef_akomodasi = $data_identitas[16];
			// KOEFIEEN ASKEP
			$koef_askep = $data_identitas[17];
			// KOEF PELAYANAN NON MEDIS
			$koef_pelayanan_nonmedis = $data_identitas[18];
			
			
			//BIAYA SIMRS
			$total_simrs = $data_identitas[20]; 
			//BIAYA AKOMODASI
			$total = $koef_akomodasi*$LOS;
			// BIAYA ASKEP
			$total_askep = $LOS*$koef_askep;
			//BIAYA PEL NONMEDIS
			$total_pel_nonmedis = $LOS*$koef_pelayanan_nonmedis;
			//BIAYA PERAWATAN LAIN
			$perawatan = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["id_admission"]));
			$perawatan_pelayanan = $perawatan[18];
			
			$total_biaya = $total_simrs+$total+$total_askep+$total_pel_nonmedis +$perawatan_pelayanan;
			
			print number_format($total_biaya ,0,",","."). "<br>";
			/*print number_format($total ,0,",","."). "<br>";
			print number_format($total_askep ,0,",","."). "<br>";
			print number_format($total_pel_nonmedis ,0,",","."). "<br>";
			print number_format($perawatan_pelayanan ,0,",","."). "<br>";*/
		}
	
	 ?></td>
  </tr>
  <!--<tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><span class="style11">TERBILANG</span></td>
    <td colspan="4" align="left" valign="top"><span class="style11"><?php /*print ucwords(Terbilang($DATA_PENDAFTARAN['BIAYA_TOTAL'])). ' '.'Rupiah'; */?></span></td>
  </tr>-->
  
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2" align="left">Petugas,
    <?php  print $pl;?></td>
  </tr>
</table>

</body>
</html>
<?php
$conn->close();
$html = ob_get_clean();
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isJavascriptEnabled', TRUE);
$dompdf = new Dompdf($options);
//$customPaper = array(0,0, 609,935);
//$dompdf = new Dompdf();
$dompdf->set_option('chroot', __DIR__);
$dompdf->set_option('enable_font_subsetting', true);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isJavascriptEnabled', true);
$dompdf->set_option('enable_remote', TRUE);
$dompdf->set_option('enable_css_float', TRUE);

$dompdf->load_html($html);
$dompdf->setPaper('F4', 'portrait');
//$dompdf->set_paper($customPaper);
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream('LaporanAdministrasiPasienRawatInap.pdf',array('Attachment' => 0));
?>
?>

















