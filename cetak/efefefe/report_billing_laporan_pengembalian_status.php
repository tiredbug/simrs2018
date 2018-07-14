<?php
ob_start();
include "../connect.php";


$noruang = $_GET["noruang"];
///echo $noruang;

$id_tahun = $_GET["tahun_masuk"];
//echo $id_tahun;

$id_bulan = $_GET["bulan_masuk"];/*
//echo $id_bulan;

$id_carabayar = $_GET["statusbayar"];
//echo 'cra bayar '.$id_carabayar;

$KELASPERAWATAN_ID = $_GET["KELASPERAWATAN_ID"];
//echo 'kelas '.$KELASPERAWATAN_ID;

$sqlkelaskeperawatan = "select * from l_kelas_perawatan where kelasperawatan_id =  " . htmlspecialchars($KELASPERAWATAN_ID);
$querykelaskeperawatan = mysql_query($sqlkelaskeperawatan);
$datakelaskeperawatan = mysql_fetch_array($querykelaskeperawatan);


$sqlcarabayar = "select * from m_carabayar WHERE KODE = " . htmlspecialchars($id_carabayar);
$querycarabayar = mysql_query($sqlcarabayar);
$datacarabayar = mysql_fetch_array($querycarabayar);*/


$sqlbulan = "SELECT * FROM l_bulan where bulan_id = " . htmlspecialchars($id_bulan);
$querybulan = mysql_query($sqlbulan);
$databulan = mysql_fetch_array($querybulan);


$sqltahun = "SELECT * FROM l_tahun where tahun_id  =  " . htmlspecialchars($id_tahun);
$querytahun = mysql_query($sqltahun);
$datatahun = mysql_fetch_array($querytahun);

$sqlkamar = "SELECT * FROM m_ruang where no = " . htmlspecialchars($noruang);
$querykamar = mysql_query($sqlkamar);
$datakamar = mysql_fetch_array($querykamar);

?>

<html>
<head>
<title>CETAK BUKU RINCIAN ADMINISTRASI</title>
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
<!--
.style1 {font-size: xx-small}

@page { margin: 3px; }
body { margin: 3px; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong>LAPORAN BUKU PENGEMBALIAN STATUS  <?php print ' BULAN '.$databulan['bulan_nama'].' '.$datatahun['tahun_nama'].' '.$datakamar['nama'] ;?></strong> </td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>No</td>
    <td>Nomr/Nama/Alamat</td>
    <td>Tanggal Masuk </td>
    <td>Tanggal Pengembalian status </td>
    <td>Hari Pengembalian </td>
    <td>Status</td>
  </tr>
  <?php 
		$sql_dokter = "SELECT  a.id_admission, a.nomr,b.NAMA,b.ALAMAT, a.masukrs, a.tanggal_pengembalian_status, a.hari, a.status_pengembalian  FROM simrs2012.vw_pengambalian_status_pasien a LEFT OUTER JOIN m_pasien b ON (a.nomr= b.NOMR) 
 where a.noruang =". htmlspecialchars($noruang) ." and a.bulan_masuk = ". htmlspecialchars($id_bulan) ." AND a.tahun_masuk = ". htmlspecialchars($id_tahun)  ;
		$no=1;
		$query_dokter = mysql_query($sql_dokter);
		while($data_tmno_dokter= mysql_fetch_array($query_dokter))
		{
  ?>
  <tr>
    <td><?php  print $no;?></td>
    <td><?php print $data_tmno_dokter['nomr']; ?>/ <?php print ucwords(strtolower($data_tmno_dokter['NAMA'])); ?>/ <?php print ucwords(strtolower($data_tmno_dokter['ALAMAT'])); ?></td>
    <td><?php  print date("d-m-Y", strtotime($data_tmno_dokter['masukrs'])); ?></td>
    <td><?php  print $data_tmno_dokter['tanggal_pengembalian_status'] ; ?></td>
    <td><?php print $data_tmno_dokter['hari']; ?></td>
    <td><?php print $data_tmno_dokter['status_pengembalian']; ?></td>
  </tr>
  <?php $no++; }  ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>

<?php
$html = ob_get_clean();
require_once("../../dompdf_baru/dompdf_config.inc.php");
//require_once("../dompdf/autoload.inc.php");
$dompdf = new DOMPDF();
//$html = "<B> tes </B>" ;
$dompdf->load_html($html);
$dompdf->set_paper("F4", 'landscape');
$dompdf->render();
//$dompdf->stream('tmno.pdf',array('Attachment' => 0)); 
$dompdf->stream('LAPORAN KUNJUNGAN PASIEN RAWAT INAP_'.$databulan['bulan_nama'].' '.$datatahun['tahun_nama'].' '.$datakamar['nama'].'_.pdf',array('Attachment' => 0)); 



?>
<?php print ' BULAN '.$databulan['bulan_nama'].' '.$datatahun['tahun_nama'].' '.$datakamar['nama'] ;?>
















