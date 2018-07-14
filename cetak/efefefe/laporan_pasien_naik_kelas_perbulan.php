<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$counter_cetak;
include '../../include/koneksi.php';
include '../../include/function.php';



$noruang = $_GET["noruang"];
$id_tahun = $_GET["tahun_keluar"];
$id_bulan = $_GET["bulan_keluar"];





?>

<html>
<head>
<title>CETAK RINCIAN IURAN NAIK KELAS</title>
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
    <td align="center"><strong>RINCIAN ADMINISTRASI IURAN NAIK KELAS  <?php print getNamaBulan($id_bulan).' '.$id_tahun; ?></strong> </td>
  </tr>
    <tr>
    <td align="center"><strong><?php print getNamaKamar($noruang);  ?></strong> </td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="2%" rowspan="2" align="center"><span class="style3">No</span></td>
    <td width="16%" align="center"><span class="style3">Nama Pasien </span></td>
    <td colspan="2" align="center"><span class="style3">Tanggal</span></td>
    <td width="17%" rowspan="2" align="center"><span class="style3">Iuran Naik Kelas </span></td>
    <td width="20%" rowspan="2" align="center"><span class="style3">Prosedur Tindakan </span></td>
    <td width="16%" rowspan="2" align="center"><span class="style3">Diagnosa</span></td>
    <td width="13%" rowspan="2" align="center"><span class="style3">Harga Total </span></td>
  </tr>
  <tr>
    <td align="center"><span class="style3">No Register </span></td>
    <td width="8%" align="center"><span class="style3">Masuk</span></td>
    <td width="8%" align="center"><span class="style3">Keluar</span></td>
  </tr>
  
  <?php 
  
  
	$QUERY = "SELECT * FROM vw_laporan_naik_kelas_perbulan 
	WHERE noruang =".htmlspecialchars($noruang)." AND bulan_keluar = ". htmlspecialchars($id_bulan)." AND tahun_keluar =". htmlspecialchars($id_tahun);
	//echo $QUERY;
	$no=1;
		$result = $conn->query($QUERY);
		if ($result->num_rows > 0) {
    	while($data_naik_kelas = $result->fetch_assoc()) {
  ?>
  <tr>
    <td rowspan="2" align="center"><span class="style1">
      <?php  print $no;?>
    </span><span class="style1"></span></td>
    <td><span class="style1">
      <?php  print $data_naik_kelas['NAMA'];?>
    </span></td>
    <td rowspan="2" align="left"><span class="style1">
      <?php  print date("d-m-Y", strtotime($data_naik_kelas['masukrs']));?>
    </span><span class="style1"></span></td>
    <td rowspan="2" align="left"><span class="style1">
       <?php  print date("d-m-Y", strtotime($data_naik_kelas['keluarrs']));?>
    </span><span class="style1"></span></td>
    <td rowspan="2" align="center"><span class="style1">
      <?php  print 'iuran naik '.$data_naik_kelas['kelas_lama'].' - '.$data_naik_kelas['kelas_baru'];?>
    </span><span class="style1"></span></td>
    <td rowspan="2" align="center"><span class="style1">
      <?php  print $data_naik_kelas['ketrangan_naik_kelas'];?>
    </span><span class="style1"></span></td>
    <td rowspan="2" align="center"><span class="style1">
      <?php  print $data_naik_kelas['diagnosa_keluar'];?>
    </span><span class="style1"></span></td>
    <td rowspan="2" align="center"><span class="style1">
      <?php  print $data_naik_kelas['jumlah_iuran'];?>
    </span><span class="style1"></span></td>
  </tr>
  <tr>
    <td><span class="style1">
      <?php  print $data_naik_kelas['nomr'];?>
    </span></td>
  </tr>
  <?php $no++; }} else {} ?>
</table>
<p>&nbsp;</p>
</body>
</html>

<?php

$tgl=date('d-m-Y');

/*$html = ob_get_clean();
require_once("../../dompdf_baru/dompdf_config.inc.php");
//require_once("../dompdf/autoload.inc.php");
$dompdf = new DOMPDF();
//$html = "<B> tes </B>" ;
$dompdf->load_html($html);
$dompdf->set_paper("F4", 'landscape');
$dompdf->render();
//$dompdf->stream('tmno.pdf',array('Attachment' => 0)); 
$dompdf->stream('LAPORAN_PASIEN_NAIK_KELAS_'.
$datakamar['nama'].'_'.
$databulan['bulan_nama'].'_'.
$datatahun['tahun_nama'].'_ dicetak tanggal '.
$tgl .'_.pdf',array('Attachment' => 0)); */


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

















