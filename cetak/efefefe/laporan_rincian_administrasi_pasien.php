<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$counter_cetak;
include '../../include/koneksi.php';
include '../../include/function.php';



$QUERY = "SELECT * FROM vw_adm_rawat_inap WHERE id_admission = " . htmlspecialchars($_GET["id_admission"]);
//echo $QUERY;
$result = $conn->query($QUERY);
$DATA_PENDAFTARAN = $result->fetch_assoc();


$q1 = "SELECT * FROM vw_identitas_pasien_by_id_admission WHERE id_admission = "  . htmlspecialchars($_GET["id_admission"]);
$q2 = $conn->query($q1);
$q3 = $q2->fetch_assoc();


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
    <td width="35%" align="left" valign="top"><?php print $q3['NAMA']; ?></td>
    <td width="2%" align="left" valign="top">&nbsp;</td>
    <td width="1%" align="left" valign="top">&nbsp;</td>
    <td width="25%" align="left" valign="top">NO RM</td>
    <td width="1%" align="left" valign="top">:</td>
    <td width="14%" align="left" valign="top"><?php print $q3['nomr']; ?></td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">UMUR</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><?php print $q3['UMUR']; ?> Tahun </td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">JK</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><?php print $q3['JENISKELAMIN']; ?></td>
  </tr>
  <tr align="center">
    <td width="21%" align="left" valign="top">ALAMAT</td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">	  <?php print ucwords(strtolower($q3['ALAMAT'].', kec.'.$q3['namakecamatan'])); ?>
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
    <td align="left" valign="top"><?php echo ucwords(strtolower($q3['NAMARUANGRAWAT']));  ?>/ <strong><?php print $q3['kelasperawatan']; ?></strong></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr align="center" valign="middle">
    <td align="left" valign="top">TANGGAL MASUK </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">      <?php  print date("d-m-Y", strtotime($q3['masukrs'])); ?>    </td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">TANGGAL KELUAR </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top">      <?php  print date("d-m-Y", strtotime($q3['keluarrs'])); ?>     </td>
  </tr>
  <tr align="center" valign="middle">
    <td align="left" valign="top">STATUS PASIEN </td>
    <td align="left" valign="top">:</td>
    <td align="left" valign="top"><strong><?php echo $q3['JENISPEMBAYARAN'];  ?></strong></td>
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
    <td align="left" valign="middle">a.</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_TIND_IGD'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">b. Tindakan Poli </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_TIND_RAJAL'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">2.</td>
    <td align="left" valign="middle">Akomodasi</td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['LOS']; ?></td>
    <td align="center">x</td>
    <td align="center"><?php print number_format($DATA_PENDAFTARAN['HARGA_AKOMODASI'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_AKOMODASI'],0,",","."); ?></td>
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
 
 //$QUERY = "SELECT * FROM vw_adm_rawat_inap WHERE id_admission = " . htmlspecialchars($_GET["id_admission"]);
		$ss = "SELECT a.dokterid_on_visit,b.NAMADOKTER,a.harga_on_visit,
COUNT(a.tindakandetailvisitdokter_id) as 'VISIT',
COUNT(a.tindakandetailvisitdokter_id) * a.harga_on_visit as 'subtotal'
FROM t_tindakan_detail_visit_dokter a
LEFT OUTER JOIN m_dokter b ON (a.dokterid_on_visit=b.KDDOKTER)
WHERE admission_id_on_visit =" . htmlspecialchars($_GET["id_admission"])." group by dokterid_on_visit";
//echo $ss ;
		$n=1;
		$q  = $conn->query($ss);
		if ($q ->num_rows > 0) {
    	while($d= $result->fetch_assoc()) {
  ?>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><?php echo ucwords(strtolower($d['NAMADOKTER']));  ?></td>
    <td align="center" valign="top"><?php print $d['VISIT'];  ?></td>
    <td align="center">x</td>
    <td align="center"><?php print number_format($d['harga_on_visit'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format($d['subtotal'],0,",","."); ?></td>
  </tr>
<?php $n++; }} else {} ?>
  
  <tr align="center">
    <td align="center">4</td>
    <td align="left" valign="middle">Asuhan Keperawatan </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['LOS']; ?></td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle"><?php print number_format($DATA_PENDAFTARAN['HARGAASKEP'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOTAL_BIAYA_ASKEP'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">5</td>
    <td align="left" valign="middle">Pelayanan RM &amp; SIMRS </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['LOS']; ?></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOTAL_BIAYA_SIMRS'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">6</td>
    <td align="left" valign="middle">Pelayanan Penunjang Non-Medis </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['LOS']; ?></td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle"><?php print number_format($DATA_PENDAFTARAN['HARGA_PENUNJANG_NONMEDIS'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_PENJ_NMEDIS'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">7</td>
    <td align="left" valign="middle">Konsultasi Gizi </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_GIZI'],0,",","."); ?></td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_GIZI'],0,",","."); ?></td>
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
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_RAD'],0,",","."); ?></td>
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
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_LAB_IGD'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">b.POLI &amp; CDR </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_CDRPOLI'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td width="3%" align="center">10.</td>
    <td width="35%" align="left" valign="middle">Tindakan Keperawatan </td>
    <td width="14%" align="center" valign="top">&nbsp;</td>
    <td width="6%" align="center">&nbsp;</td>
    <td width="20%" align="center">&nbsp;</td>
    <td width="22%" align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_TRF_PERAWAT'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sederhana</td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_SEDERHANA_PERAWAT']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Kecil</td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_KECIL_PERAWAT']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sedang</td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_SEDANG_PERAWAT']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Besar</td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_BESAR_PERAWAT']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Khusus</td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_KHUSUS_PERAWAT']; ?></td>
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
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_TRF_TIND_DOKTER'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sederhana </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_SEDERHANA_DOKTER']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Kecil </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_KECIL_DOKTER']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Sedang </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_SEDANG_DOKTER']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Besar </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_BESAR_DOKTER']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">- Khusus </td>
    <td align="center" valign="top"><?php print $DATA_PENDAFTARAN['TIN_KHUSUS_DOKTER']; ?></td>
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
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_TMO'],0,",","."); ?></td>
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
    <td align="center">
	<?php print number_format($DATA_PENDAFTARAN['TOT_BHP_DOKTER'],0,",",".").' + '.number_format($DATA_PENDAFTARAN['TOT_BHP_PERAWAT'],0,",",".") .'  = ' ;?></td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BHP_DOKTER'] + $DATA_PENDAFTARAN['TOT_BHP_PERAWAT'] ,0,",","."); ?></td>
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
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_FISIO'],0,",","."); ?></td>
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
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOTAL_BIAYA_OBAT'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">19.</td>
    <td align="left" valign="middle">Oksigen</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_OKSIGEN'],0,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">20.</td>
    <td align="left" valign="middle">Ambulance</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top"><?php print number_format($DATA_PENDAFTARAN['TOT_BIAYA_AMBULAN'],0,",","."); ?></td>
	
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
	<?php print number_format($DATA_TINDAKAN_LAIN_LAIN['harga_on_lainlain'],0,",","."); ?>-->
	</td>
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
    <td align="right" valign="top">Rp. <?php print number_format($DATA_PENDAFTARAN['BIAYA_TOTAL'],2,",","."); ?></td>
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
    <td align="center">Petugas,</td>
    <td align="right" valign="top">&nbsp;</td>
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

















