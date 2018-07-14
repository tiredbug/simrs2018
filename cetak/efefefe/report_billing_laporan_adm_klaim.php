<?php
ob_start();
include "../connect.php";


$noruang = $_GET["noruang"];


$id_tahun = $_GET["tahun_masuk"];


$id_bulan = $_GET["bulan_masuk"];


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
    <td align="center"><strong>LAPORAN AD KLAIM  <?php print ' BULAN '.$databulan['bulan_nama'].' '.$datatahun['tahun_nama'].' '.$datakamar['nama'] ;?></strong> </td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>No</td>
    <td>Nomr/Nama/Alamat</td>
    <td>Tanggal Masuk </td>
    <td>Tanggal Keluar </td>
    <td>Tgl Pengiriman Ad klaim </td>
    <td>Hari</td>
    <td>Jenis Bayar </td>
  </tr>
  <?php 
		$sql_dokter = "SELECT a.*,b.NAMA,b.ALAMAT,c.NAMA as 'jenisbayar' FROM simrs2012.vw_adm_klaim a left outer join m_pasien b on (a.nomr = b.NOMR) left outer join m_carabayar c ON (a.statusbayar = c.KODE)  WHERE noruang = ".htmlspecialchars($noruang)." and bulan_masuk = ".htmlspecialchars($id_bulan)." and tahun_masuk = ". htmlspecialchars($id_tahun) ;
		$no=1;
		$query_dokter = mysql_query($sql_dokter);
		while($data_tmno_dokter= mysql_fetch_array($query_dokter))
		{
  ?>
  <tr>
    <td><?php  print $no;?></td>
    <td><?php print $data_tmno_dokter['nomr']; ?>/ <?php print ucwords(strtolower($data_tmno_dokter['NAMA'])); ?>/ <?php print ucwords(strtolower($data_tmno_dokter['ALAMAT'])); ?></td>
    <td><?php  print date("d-m-Y", strtotime($data_tmno_dokter['masukrs'])); ?></td>
    <td><?php  print date("d-m-Y", strtotime($data_tmno_dokter['keluarrs'])); ?></td>
    <td><?php print $data_tmno_dokter['tgl_pengiriman_ad_klaim']; ?></td>
    <td><?php print $data_tmno_dokter['hari']; ?></td>
    <td><?php print $data_tmno_dokter['jenisbayar']; ?></td>
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
















