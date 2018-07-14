<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$counter_cetak;
include '../../include/koneksi.php';
include '../../include/function.php';


$noruang = $_GET["noruang"];
$id_tahun = $_GET["TAHUN"];
$id_bulan = $_GET["BLN"];

?>

<html>
<head>
<title>LAPORAN PASIEN RAWAT INAP PERKAMAR</title>
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
@page {
  size: 33.0cm 21cm;
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
  <tr>
    <td align="center"><strong>LAPORAN PASIEN RAWAT INAP  <?php print ' BULAN '.getNamaBulan($id_bulan).' '.$id_tahun.' '.getNamaKamar($noruang) ;?></strong> </td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><strong>No</strong></td>
    <td><strong>Nomr</strong></td>
    <td><strong>Nama</strong></td>
    <td><strong>Alamat</strong></td>
    <td><strong>Tanggal Masuk </strong></td>
    <td><strong>Tanggal Keluar </strong></td>
    <td><strong>No Bed </strong></td>
    <td><strong>Jenis Pembayaran </strong></td>
    <td><strong>Kelas</strong></td>
  </tr>
  <?php 
		$sql_dokter = "select *  from vw_laporan_daftar_pasien_per_kamar a  where noruang =". htmlspecialchars($noruang) ." and BLN = ". htmlspecialchars($id_bulan) ." AND TAHUN = ". htmlspecialchars($id_tahun)  ;
		$no=1;
		$result = $conn->query($sql_dokter);
		if ($result->num_rows > 0) {
    	while($data_tmno_dokter = $result->fetch_assoc()) {
  ?>
  <tr align="left" valign="top">
    <td><?php  print $no;?></td>
    <td><?php print $data_tmno_dokter['nomr']; ?></td>
    <td>
	<?php
	 $p = caridataPasien($data_tmno_dokter["nomr"]);
	 $a = $p[1];
	 echo $a;
	
	?>	</td>
    <td><?php
	 $p = caridataPasien($data_tmno_dokter["nomr"]);
	 $a = $p[3];
	 echo $a;
	
	?></td>
    <td align="center"><?php  print date("d-m-Y", strtotime($data_tmno_dokter['masukrs'])); ?></td>
    <td align="center"><?php  print date("d-m-Y", strtotime($data_tmno_dokter['keluarrs'])); ?></td>
    <td align="center"><?php print $data_tmno_dokter['nott']; ?></td>
    <td align="center"><?php print getNamaJaminan($data_tmno_dokter['statusbayar']); ?></td>
    <td align="center" valign="top"><?php print $data_tmno_dokter['KELASPERAWATAN_ID']; ?></td>
  </tr>
  		  <?php $no++; }} else {} ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
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
$dompdf->setPaper('F4', 'landscape');
//$dompdf->set_paper($customPaper);
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream('LaporanPasienRawatInapPerBulan.pdf',array('Attachment' => 0));
?>

















