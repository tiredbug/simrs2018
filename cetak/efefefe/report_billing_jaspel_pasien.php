
<?php
ob_start();
include("../connect.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN JASA PELAYANAN PASIEN</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="72%">LAPORAN JASA PELAYANAN PASIEN [...] KELAS [..] RUANG [...] </td>
    <td width="3%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td>BULAN [...] </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr align="center" valign="top">
        <td width="3%" rowspan="2">No</td>
        <td width="24%" rowspan="2">Dokter Umum </td>
        <td width="5%" rowspan="2">VISIT</td>
        <td colspan="5">TMNO DELEGASI </td>
        <td colspan="4">TMNO MANDIRI DOKTER </td>
        <td width="6%">Baca EKG </td>
      </tr>
      <tr>
        <td width="6%" align="center" valign="top">SDHN</td>
        <td width="4%" align="center" valign="top">KCL</td>
        <td width="6%" align="center" valign="top">SDG</td>
        <td width="7%" align="center" valign="top">BSR</td>
        <td width="9%" align="center" valign="top">KHS</td>
        <td width="8%" align="center" valign="top">KCL</td>
        <td width="8%" align="center" valign="top">SDG</td>
        <td width="7%" align="center" valign="top">BSR</td>
        <td width="7%" align="center" valign="top">KHS</td>
        <td align="center" valign="top">&nbsp;</td>
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
      </tr>
    </table></td>
    <td>&nbsp;</td>
    <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td colspan="5">TINDAKAN KEPERAWATAN </td>
        </tr>
      <tr>
        <td>SDHN</td>
        <td>KCL</td>
        <td>SDG</td>
        <td>BSR</td>
        <td>KHS</td>
      </tr>
      <tr>
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
      </tr>
      <tr>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>

<?php
$html = ob_get_clean();
require_once("../../dompdf_baru/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$dompdf->set_paper("A4", 'landscape');
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream('LAPORAN JASA PELAYANAN PASIEN.pdf',array('Attachment' => 0));
?>
