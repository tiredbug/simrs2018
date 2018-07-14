
<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$counter_cetak;
include '../../include/koneksi.php';
include '../../include/function.php';

$bulan = $_GET["b"];
$tahun = $_GET["t"];

//$bulan = 5;
//$tahun = 2017;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CETAK SEP</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
@page {
  size: 21cm 29.7cm;
  margin: 5;
}

body {  
    font-family: 'Courier';
	font-size:small;
}

</style>


</head>
<body>

<table width="100%" border="0">
  <tr>
    <td width="5%"><img src="logo.jpg" alt="bakti husada" width="70" height="76" /></td>
    <td width="95%"><strong>FORMULIR RL 3.6 <br/> 
    KEGIATAN PEMBEDAHAN </strong></td>
  </tr>
</table>
<hr />
<table width="100%" border="0">
  <tr>
    <td width="10%">
	Kode RS<br/>
	Nama RS<br/>
	Tahun </td>
    <td width="31%" align="left" valign="middle">
			: 3302191<br/>
			: RSUD AJIBARANG<br/>
	: <?php echo getNamaBulan($bulan).' - '.$tahun ;?></td>
	<td width="59%"><br/>
    <br/></td>
  </tr>
</table>
<table width="79%" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr align="center">
    <td width="4%"><strong>NO</strong></td>
    <td width="72%"><strong>SPESIALISASI</strong></td>
    <td width="5%"><strong>TOTAL</strong></td>
    <td width="5%"><strong>KHUSUS</strong></td>
    <td width="5%"><strong>BESAR</strong></td>
    <td width="5%"><strong>SEDANG</strong></td>
    <td width="4%"><strong>KECIL</strong></td>
  </tr>
  <tr align="center" bgcolor="#CCCCCC">
    <td>1</td>
    <td>2</td>
    <td>3</td>
    <td>4</td>
    <td>5</td>
    <td>6</td>
    <td>7</td>
  </tr>
<?php
$sql = "select a.* ,
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun.") as 'JUMLAH',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 1) as 'KECIL_A',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 2) as 'KECIL_B',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 3) as 'SEDANG_A',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 4) as 'SEDANG_B',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 5) as 'BESAR_A',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 6) as 'BESAR_B',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 7) as 'KHUSUS_A',
(SELECT COUNT(ID_TINDAKAN) FROM vw_kategori_tmo_ibs WHERE ID_KATEGORI_SPESIALISASI = a.ID AND BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO = 8) as 'KHUSUS_B'
from m_spesialisasitindakan a";
$no=1;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>
  
		  <tr>
			<td align="left" valign="top"><?php echo $no;  ?></td>
			<td align="left" valign="top"><?php echo $row['NAMA_SPESIALISASI']; ?></td>
			<td align="center" valign="top"><?php echo $row['JUMLAH']; ?></td>
			<td align="center" valign="top" ><?php
				$khususa = $row['KHUSUS_A'];
				$khususb = $row['KHUSUS_B'];
			 print $khususa + $khususb ;  ?></td>
			<td align="center" valign="top"><?php echo $row['BESAR_A']+$row['BESAR_B'];  ?></td>
			<td align="center" valign="top"><?php echo $row['SEDANG_A']+$row['SEDANG_B']; ?></td>
			<td align="center" valign="top"><?php echo $row['KECIL_A']+$row['KECIL_B']; ?></td>
		  </tr>
		  
		  <?php $no++; }
} else {
   ?>
    <tr>
    <td colspan="2" align="center">Data Kosong</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
   <?php
} ?>

  <tr>
    <td colspan="2" align="center">TOTAL</td>
    <td align="center">
	<?php 
	$sql = "SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun."";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		print $row["JUMLAH"];
	}
	} else {print '-';}
	?>	</td>
    <td align="center"><?php 
	$sql = "SELECT (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 7) + (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 8) as 'KHUSUS'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		print $row["KHUSUS"];
	}
	} else {print '-';}
	?></td>
    <td align="center"><?php 
	$sql = "SELECT (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 5) + (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 6) as 'KHUSUS'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		print $row["KHUSUS"];
	}
	} else {print '-';}
	?></td>
    <td align="center"><?php 
	$sql = "SELECT (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 3) + (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 4) as 'KHUSUS'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		print $row["KHUSUS"];
	}
	} else {print '-';}
	?></td>
    <td align="center"><?php 
	$sql = "SELECT (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 1) + (SELECT COUNT(ID_TINDAKAN) as 'JUMLAH' FROM vw_kategori_tmo_ibs WHERE BULAN = ".$bulan." AND TAHUN =  ".$tahun." AND ID_KATEGORI_TMO  = 2) as 'KHUSUS'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		print $row["KHUSUS"];
	}
	} else {print '-';}
	?></td>
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
$customPaper = array(0,0, 609,935);
//$dompdf = new Dompdf();
$dompdf->set_option('chroot', __DIR__);
$dompdf->set_option('enable_font_subsetting', true);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isJavascriptEnabled', true);
$dompdf->set_option('enable_remote', TRUE);
$dompdf->set_option('enable_css_float', TRUE);

$dompdf->load_html($html);
//$dompdf->setPaper('F4', 'landscape');
$dompdf->set_paper($customPaper);
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream('inadrg.pdf',array('Attachment' => 0));
?>