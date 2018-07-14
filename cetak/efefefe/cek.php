<?php
ob_start();
include "../connect.php";
$QUERY = "SELECT * FROM vw_laporan_inadrg WHERE id_admission = " . htmlspecialchars($_GET["id_admission"]);
$data = mysql_query($QUERY);
$DATA_PENDAFTARAN = mysql_fetch_array($data);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CETAK INADRG</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
<!--
.style17 {font-size: medium}
-->
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
    <td>Jl. Raya Pancasan, Ajibarang, Telp. (0281) 6570002 6570004. Email: rsud_ajb08@yahoo.co.id </td>
  </tr>
</table>
<hr />
<table width="100%" border="1"  cellpadding="0" cellspacing="0">
  <tr align="center">
    <td width="5%" align="center" valign="top"><strong>NO</strong></td>
    <td width="29%" align="left" valign="top"><strong>ITEM</strong></td>
    <td width="38%" align="center" valign="top"><strong>KODE</strong></td>
    <td width="28%" align="left" valign="top"><strong>KET</strong></td>
  </tr>
  <tr>
    <td align="center" valign="top">1</td>
    <td align="left" valign="top">KODE RS </td>
    <td align="center" valign="top"><strong>3302191</strong></td>
    <td align="left" valign="top"><strong>RSUD AJIBARANG </strong></td>
  </tr>
  <tr>
    <td align="center" valign="top">2</td>
    <td align="left" valign="top">KELAS</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">3</td>
    <td align="left" valign="top">NO. REKAM MEDIS </td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['nomr']; ?></span></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">4</td>
    <td align="left" valign="top">NO.SKP</td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['NO_SKP']; ?></span></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">5</td>
    <td align="left" valign="top">SURAT RUJUKAN </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">1) Ada - 2) Tidak</td>
  </tr>
  <tr>
    <td align="center" valign="top">6</td>
    <td align="left" valign="top">NAMA PASIEN </td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['NAMA']; ?></span></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2" align="center" valign="top">7</td>
    <td rowspan="2" align="left" valign="top">KELAS PERAWATAN </td>
    <td rowspan="2" align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['kelasperawatan']; ?></span></td>
    <td align="left" valign="top">1). Kelas I - 3).Kelas II </td>
  </tr>
  <tr>
    <td>2.) Kelas III - 4)HCU/ICU </td>
  </tr>
  <tr>
    <td rowspan="2" align="center" valign="top">8</td>
    <td rowspan="2" align="left" valign="top">CARA BAYAR </td>
    <td rowspan="2" align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['cara_bayar']; ?></span></td>
    <td align="left" valign="top">1)BPJS PBI - 2)BPJS NON PBI </td>
  </tr>
  <tr>
    <td>3)Umum - 4)Jamsostek </td>
  </tr>
  <tr>
    <td align="center" valign="top">9</td>
    <td align="left" valign="top">JENIS PERAWATAN </td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['jeniskeperawatan_namar']; ?></span></td>
    <td align="left" valign="top">1) Rawat Inap - 2) Rawat Jalan </td>
  </tr>
  <tr>
    <td align="center" valign="top">10</td>
    <td align="left" valign="top"><span class="style17">TANGGAL MASUK/JAM </span></td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['masukrs']; ?></span></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">11</td>
    <td align="left" valign="top"><span class="style17">TANGGAL KELUAR/JAM </span></td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['keluarrs']; ?></span></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">12</td>
    <td align="left" valign="top"><span class="style17">TANGGAL LAHIR/JAM </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">13</td>
    <td align="left" valign="top"><span class="style17">JUMLAH LAMA DIRAWAT </span></td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['LOS']; ?></span></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">14</td>
    <td align="left" valign="top"><span class="style17">JENIS KELAMIN </span></td>
    <td align="center" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['JENISKELAMIN']; ?></span></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">15</td>
    <td align="left" valign="top"><span class="style17">CARA PULANG </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">16</td>
    <td align="left" valign="top"><span class="style17">BERAT LAHIR (gram) </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">17</td>
    <td align="left" valign="top"><span class="style17">DIAGNOSA PRIMER </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3" align="center" valign="top">18</td>
    <td rowspan="3" align="left" valign="top"><span class="style17">DIAGNOSA SEKUNDER </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3" align="center" valign="top">19</td>
    <td rowspan="3" align="left" valign="top"><span class="style17">TINDAKAN</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3" align="center" valign="top">20</td>
    <td rowspan="3" align="left" valign="top"><span class="style17">SEBAB CEDERA </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">21</td>
    <td align="left" valign="top"><span class="style17">TOTAL BIAYA RIL </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">22</td>
    <td align="left" valign="top"><span class="style17">KODE NBINA-DRG </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">23</td>
    <td align="left" valign="top"><span class="style17">TARIF INA-DRG </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">24</td>
    <td align="left" valign="top"><span class="style17">DPJP</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top"><span class="style17"><?php print $DATA_PENDAFTARAN['NAMADOKTER']; ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="top">25</td>
    <td align="left" valign="top"><span class="style17">PENGESAHAN SEV.LEVEL</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="left" valign="top"><span class="style17">1). Ada - 2). Tidak </span></td>
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
$html = ob_get_clean();
 
require_once("../../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("F4", 'portrait');
$dompdf->render();
$dompdf->stream('inadrg.pdf',array('Attachment' => 0)); 
?>

















