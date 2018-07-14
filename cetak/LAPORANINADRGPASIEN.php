<?php
ob_start();
error_reporting(0);
session_start();

date_default_timezone_set('Asia/Jakarta');

include '../../phpcon/koneksi.php';
include '../../phpcon/fungsi_col.php';

$id_admisi = htmlspecialchars($_GET["home"]);
$nomr = htmlspecialchars($_GET["p1"]);
$status_bayar = htmlspecialchars($_GET["p2"]);
$kelas = htmlspecialchars($_GET["p3"]);

/*print '$id_admisi  '.$id_admisi.'</br>';
print '$nomr  '.$nomr.'</br>';
print '$status_bayar  '.$status_bayar.'</br>';
print '$kelas  '.$kelas.'</br>';*/

$r = getDataPasienbyNomr($nomr);
/*echo '<pre>';
echo print_r($r);
echo '</pre>';*/

$adms = getDataAdmisibyId($id_admisi);
/*echo '<pre>';
echo print_r($adms);
echo '</pre>';*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CETAK INADRG</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
@page {
  size:  21cm 33.0cm;
  margin: 5;
}

body {  
    font-family: 'Courier';
	font-size:small;
}
.NO {
}
.ket {
	width: 3cm;
}
.item {
	height: auto;
	width: 4cm;
	clear: left;
	float: left;
}
.kode {
	clear: left;
	float: left;
	width: 5cm;
}
</style>
</head>

<body>

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
<table width="100%" border="1"  cellpadding="0" cellspacing="0">
  <tr align="center">
    <td width="16" align="left" valign="top" class="NO"><span class="style18">NO</span></td>
    <td width="453" align="left" valign="top" class="item"><span class="style18">ITEM</span></td>
    <td width="528" align="center" valign="top" class="kode"><span class="style18">KODE</span></td>
    <td width="319" align="left" valign="top" class="ket"><span class="style18">KET</span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">1</span></td>
    <td align="left" valign="top" class="item"><span class="style20">KODE RS </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"><strong>3302191</strong></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"><strong>RSUD AJIBARANG </strong></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">2</span></td>
    <td align="left" valign="top" class="item"><span class="style20">KELAS</span></td>
    <td align="center" valign="top" class="kode"><span class="style20"><strong>C</strong></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">3</span></td>
    <td align="left" valign="top" class="item"><span class="style20">NO. REKAM MEDIS </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">4</span></td>
    <td align="left" valign="top" class="item"><span class="style20">NO.SKP</span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">5</span></td>
    <td align="left" valign="top" class="item"><span class="style20">SURAT RUJUKAN </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket">1)Ada<br/>2)Tidak</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">6</span></td>
    <td align="left" valign="top" class="item"><span class="style20">NAMA PASIEN </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">7</span></td>
    <td align="left" valign="top" class="item"><span class="style20">KELAS PERAWATAN </span></td>
    <td align="center" valign="middle" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket">1)Kelas I<br/>
        2)Kelas II <br/>
    3)Kelas III <br/>
    4)HCU/ICU</td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">8</span></td>
    <td align="left" valign="top" class="item"><span class="style20">CARA BAYAR </span></td>
    <td align="center" valign="middle" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket">1)BPJS PBI<br/>2)BPJS NON PBI <br/>3)Umum <br/>4)Jamsostek</td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">9</span></td>
    <td align="left" valign="top" class="item"><span class="style20">JENIS PERAWATAN </span></td>
    <td align="center" valign="middle" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20">1)Rawat Inap<br/>
    2)Rawat Jalan </span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">10</span></td>
    <td align="left" valign="top" class="item"><span class="style20">TANGGAL MASUK/JAM </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">11</span></td>
    <td align="left" valign="top" class="item"><span class="style20">TANGGAL KELUAR/JAM </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">12</span></td>
    <td align="left" valign="top" class="item"><span class="style20">TANGGAL LAHIR/JAM </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">13</span></td>
    <td align="left" valign="top" class="item"><span class="style20">JUMLAH LAMA DIRAWAT </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">14</span></td>
    <td align="left" valign="top" class="item"><span class="style20">JENIS KELAMIN </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">15</span></td>
    <td align="left" valign="top" class="item"><span class="style20">CARA PULANG </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">16</span></td>
    <td align="left" valign="top" class="item"><span class="style20">BERAT LAHIR (gram) </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">17</span></td>
    <td align="left" valign="top" class="item"><span class="style20">DIAGNOSA PRIMER </span></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">18</span></td>
    <td align="left" valign="top" class="item"><span class="style20">DIAGNOSA SEKUNDER </span></td>
    <td align="center" valign="top" class="kode"><p></p>
    <p>&nbsp;</p></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span><span class="style20"></span><span class="style20"></span></td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">19</span></td>
    <td align="left" valign="top" class="item"><p class="style20">TINDAKAN</p>
    <p class="style20">&nbsp;</p>
    <p class="style20">&nbsp;</p></td>
    <td align="center" valign="top" class="kode">&nbsp;</td>
    <td align="left" valign="top" class="ket"><span class="style20"></span><span class="style20"></span></td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">20</span></td>
    <td align="left" valign="top" class="item"><span class="style20">SEBAB CEDERA </span></td>
    <td align="center" valign="top" class="kode"><p>&nbsp;</p>    </td>
    <td align="left" valign="top" class="ket"><span class="style20"></span><span class="style20"></span><span class="style20"></span></td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">21</span></td>
    <td align="left" valign="top" class="item"><span class="style20">TOTAL BIAYA RIL </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">22</span></td>
    <td align="left" valign="top" class="item"><span class="style20">KODE NBINA-DRG </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">23</span></td>
    <td align="left" valign="top" class="item"><span class="style20">TARIF INA-DRG </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">24</span></td>
    <td align="left" valign="top" class="item"><span class="style20">DPJP</span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">25</span></td>
    <td align="left" valign="top" class="item"><span class="style20">PENGESAHAN SEV.LEVEL</span></td>
    <td align="center" valign="top" class="kode"><span class="style20"></span></td>
    <td align="left" valign="top" class="ket"><span class="style20">1)Ada <br/>2)Tidak </span></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="76%">&nbsp;</td>
    <td width="24%" align="left" valign="top">Form Pengumpulan Data INA-DRG</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left" valign="top">Versi 1.6</td>
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
$dompdf->stream('LaporanInadrgPasien.pdf',array('Attachment' => 0));
?>

















