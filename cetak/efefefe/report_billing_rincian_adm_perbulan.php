<?php
ob_start();
include "../connect.php";
$id = $_GET["id_admission"];
$QUERY = "SELECT * FROM vw_identitas_pasien_by_id_admission WHERE id_admission = " . htmlspecialchars($id);
$data = mysql_query($QUERY);
$data_sql_data_pasien = mysql_fetch_array($data);
?>

<html>
<head>
<title>CETAK RINCIAN IURAN NAIK KELAS</title>
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
<!--
.style1 {font-size: xx-small}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong>RINCIAN ADMINISTRASI BPJS NON PBI KELAS 1 BULAN SEPTEMBER 2016 KAMAR CENDRAWASIH ATAS</strong> </td>
  </tr>
</table>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="1%" rowspan="2"><span class="style1">No</span></td>
    <td width="15%" align="center"><span class="style1">Nama Pasien </span></td>
    <td colspan="2" align="center"><span class="style1">Tanggal</span></td>
    <td width="6%" align="center"><span class="style1">Diagnosa</span></td>
    <td width="15%" rowspan="2" align="center"><span class="style1">Nama Dokter </span></td>
    <td width="4%" rowspan="2"><span class="style1">Akomodasi</span></td>
    <td width="4%" rowspan="2" align="center"><span class="style1">Visit Dokter </span></td>
    <td width="5%" rowspan="2" align="center"><span class="style1">Askep</span></td>
    <td colspan="2" align="center"><span class="style1">IDG</span></td>
    <td colspan="4" align="center"><span class="style1">Penunjang</span></td>
    <td colspan="2" align="center"><span class="style1">Tindakan Medik </span></td>
    <td width="4%" align="center"><span class="style1">BHP</span></td>
    <td width="4%" align="center"><span class="style1">02</span></td>
    <td width="4%" rowspan="2" align="center" class="style1"><span class="style1">Lain Lain </span></td>
    <td width="5%" rowspan="2" align="center" class="style1"><span class="style1">Jumlah Total </span></td>
  </tr>
  <tr>
    <td align="center" class="style1">No Register </td>
    <td width="3%" align="center" class="style1">Masuk</td>
    <td width="4%" align="center" class="style1">Keluar</td>
    <td align="center" class="style1">Harga Obat </td>
    <td width="3%" align="center" class="style1">Karcis</td>
    <td width="3%" align="center" class="style1">Tind/Poli</td>
    <td width="3%" align="center" class="style1">RO</td>
    <td width="2%" align="center" class="style1">LAB</td>
    <td width="2%" align="center" class="style1">EKG IGD</td>
    <td width="4%" align="center" class="style1">K.Gizi </td>
    <td width="5%" align="center" class="style1">Oprtk/Ctscan</td>
    <td width="4%" align="center" class="style1">Non Oprtk  </td>
    <td align="center" class="style1">Amblnc</td>
    <td align="center" class="style1">Fisioterapi</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
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
$dompdf->stream('LAPORAN_TMNO_'.
$data_sql_data_pasien['nomr'].'_'.
$data_sql_data_pasien['NAMA'].'_'.
$data_sql_data_pasien['NAMARUANGRAWAT'].'_'.
$data_sql_data_pasien['JENISPEMBAYARAN'].'_'.
$data_sql_data_pasien['kelasperawatan'].'_'.
date("d-m-Y", strtotime($data_sql_data_pasien['keluarrs'])).'_.pdf',array('Attachment' => 0)); 



?>

















