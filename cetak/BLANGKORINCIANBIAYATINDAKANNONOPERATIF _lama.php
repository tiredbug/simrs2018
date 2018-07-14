<?php
ob_start();
error_reporting(0);
session_start();

date_default_timezone_set('Asia/Jakarta');

//include '../../phpcon/koneksi.php';
include '../../phpcon/fungsi_col.php';

$id_admisi = htmlspecialchars($_GET["home"]);
$nomr = htmlspecialchars($_GET["p1"]);
$status_bayar = htmlspecialchars($_GET["p2"]);
$kelas = htmlspecialchars($_GET["p3"]);
$r = getDataPasienbyNomr($nomr);
$adms = getDataAdmisibyId($id_admisi);


/*
echo '<pre>';
echo print_r($r);
echo '</pre>';


echo '<pre>';
echo print_r($adms);
echo '</pre>';*/



?>

<html>
<head>
<title></title>
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
<!--
.style2 {font-size: small}
@page { margin: 1px; }
body {
	margin: 1px;
	font-size: small;
}
.style9 {font-weight: bold}
.style11 {font-size: 12px}
.style12 {
	font-size: xx-small
}
.style14 {font-size: xx-small; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td width="49%" align="center" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" valign="middle">
    <td><strong>PEMERINTAH DAERAH KABUPATEN BANYUMAS</br>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></br><span class="style12">Jl. Raya Pancasan &ndash; Ajibarang, Kab. Banyumas, Telp. (0281) 6570004</span></td>
  </tr>
  <tr align="center" valign="middle">
    <td><hr></td>
  </tr>
  <tr align="center" valign="middle">
    <td>
      <span class="style14">BLANGKO RINCIAN BIAYA TINDAKAN NON OPERATIF</span></td>
  </tr>
  <tr>
    <td class="style2"></td>
  </tr>
  </table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr align="left" valign="top" style="font-size: small">
    <td width="11%"><span class="style11" >Nama</span></td>
    <td width="1%"><span class="style11" >:</span></td>
    <td width="56%"><?php  print $r[3];?></td>
    <td width="2%"><span class="style11"></span></td>
    <td width="14%"><span class="style11" >No.RM</span></td>
    <td width="1%" class="style2"><span class="style11" >:</span></td>
    <td width="15%"><?php  print $r[1];?></td>
    </tr>
  <tr align="left" valign="top" style="font-size: small">
    <td><span class="style11" >Umur</span></td>
    <td><span class="style11" >:</span></td>
    <td><?php
		$a = datediff($data_get_pasien[8], date("Y/m/d"));	
		print $a[0].' Th - '.$a[1].' Bl - '.$a[2].' Hr'?>
    </td>
    <td><span class="style11"></span></td>
    <td><span class="style11" >L/P</span></td>
    <td class="style2"><span class="style11" >:</span></td>
    <td><?php  print $r[7];?></td>
    </tr>
  <tr align="left" valign="top" style="font-size: xx-small">
    <td><span class="style11" >Alamat</span></td>
    <td><span class="style11" >:</span></td>
    <td><?php  print $r[8].', '.getInfoKecamatan($r[10]).' '.getInfoKota($r[11]);?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td class="style11">&nbsp;</td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top" style="font-size: small">
    <td><span class="style11" >Status</span></td>
    <td><span class="style11" >:</span></td>
    <td><?php $a = getNamaJaminan($adms[4]); print $a[1]; ?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td class="style11">&nbsp;</td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top" style="font-size: small">
    <td><span class="style11" >Ruang</span></td>
    <td><span class="style11" >:</span></td>
    <td><?php $a = getNamaRuangInap($adms[9]); print $a[1]; ?><?php  $b = getNamaRuangInap($adms[10]); print ' / '.$b[2]; ?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td class="style11">&nbsp;</td>
    <td><span class="style11"></span></td>
    </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr align="center" valign="top">
    <td width="5%" align="center"><strong><span class="style2">No</span></strong></td>
    <td width="15%"><strong><span class="style2" >Tanggal</span></strong></td>
    <td width="29%"><strong><span class="style2">Tindakan</span></strong></td>
    <td width="26%"><strong><span class="style2" >Biaya</span></strong></td>
    <td width="30%"><strong><span class="style2" >Bhp</span></strong></td>
  </tr>

<?php

		include '../../phpcon/koneksi.php';
		$sql= "call simrs2012.blanko_tmno_tindakan_ranap(".$id_admisi.", ".$nomr.", ".$status_bayar.", ".$kelas.");";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>

  <tr align="left" valign="top">
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
    
    
  <tr align="left" valign="top">
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr align="left" valign="top">
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="bottom">
    <td width="6%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="26%"><span class="style64 style16"><strong>Jumlah</strong></span></td>
    <td width="31%"><span class="style64 style16"><strong>Rp.
      
    </strong></span></td>
    <td width="30%"><strong>Rp.  </strong></td>
  </tr>
</table></td>
    <td width="1%" align="center" valign="top"></td>
    <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr align="center" valign="middle">
        <td><strong>PEMERINTAH DAERAH KABUPATEN BANYUMAS</br>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></br><span class="style12">Jl. Raya Pancasan &ndash; Ajibarang, Kab. Banyumas, Telp. (0281) 6570004</span></strong>
        </td>
      </tr>
      <tr align="center" valign="middle">
        <td><hr></td>
      </tr>
      <tr align="center" valign="middle">
        <td><span class="style14">BLANGKO RINCIAN BIAYA TINDAKAN NON OPERATIF</span></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr align="left" valign="top" style="font-size: small">
    <td width="11%"><span class="style11">Nama</span></td>
    <td width="1%"><span class="style11">:</span></td>
    <td width="56%"><?php  print $r[3];?></td>
    <td width="2%"><span class="style11"></span></td>
    <td width="14%"><span class="style11">No.RM</span></td>
    <td width="1%"><span class="style11">:</span></td>
    <td width="15%"><?php  print $r[1];?></td>
    </tr>
  <tr align="left" valign="top" style="font-size: small">
    <td><span class="style11">Umur</span></td>
    <td><span class="style11">:</span></td>
    <td><?php
		$a = datediff($data_get_pasien[8], date("Y/m/d"));	
		print $a[0].' Th - '.$a[1].' Bl - '.$a[2].' Hr'?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11">L/P</span></td>
    <td><span class="style11">:</span></td>
    <td><?php  print $r[7];?></td>
    </tr>
  <tr align="left" valign="top" style="font-size: xx-small">
    <td><span class="style11">Alamat</span></td>
    <td><span class="style11">:</span></td>
    <td><?php  print $r[8].', '.getInfoKecamatan($r[10]).' '.getInfoKota($r[11]);?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top" style="font-size: small">
    <td><span class="style11">Status</span></td>
    <td><span class="style11">:</span></td>
    <td><?php $a = getNamaJaminan($adms[4]); print $a[1]; ?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top" style="font-size: small">
    <td><span class="style11">Ruang</span></td>
    <td><span class="style11">:</span></td>
    <td><?php $a = getNamaRuangInap($adms[9]); print $a[1]; ?>
      <?php  $b = getNamaRuangInap($adms[10]); print ' / '.$b[2]; ?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr align="center" valign="top">
          <td width="4%" align="center"><strong><span class="style9 style63 style2">No</span></strong></td>
          <td width="14%"><strong><span class="style2">Tanggal</span></strong></td>
          <td width="31%"><strong><span class="style2">Tindakan</span></strong></td>
          <td width="25%"><strong><span class="style2">Biaya</span></strong></td>
          <td width="22%"><strong><span class="style2">Bhp</span></strong></td>
        </tr>
        <tr align="left" valign="top">
          <td align="center" valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
		  
		 
		  
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr align="left" valign="top">
          <td align="center" valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr align="left" valign="top">
          <td align="center" valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr align="left" valign="top">
          <td align="center" valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr align="left" valign="top">
          <td align="center" valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
      </table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="bottom">
          <td width="6%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="29%"><strong>Jumlah</strong></td>
          <td width="27%"><span class="style66"><strong>Rp. 
            
          </strong></span></td>
          <td width="28%"><span class="style66"><strong>Rp. 
            
          </strong></span></td>
        </tr>
  </table>  </tr>
</table>
</body>
</html>



<?php
//$conn->close();
$html = ob_get_clean();
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$options = new Options();
$options->set('defaultFont', 'Courier');
$options->set('isJavascriptEnabled', TRUE);
$dompdf = new Dompdf($options);
$dompdf->set_option('chroot', __DIR__);
$dompdf->set_option('enable_font_subsetting', true);
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isJavascriptEnabled', true);
$dompdf->set_option('enable_remote', TRUE);
$dompdf->set_option('enable_css_float', TRUE);
$dompdf->load_html($html);
$dompdf->setPaper('F4', 'landscape');
$dompdf->render();
$dompdf->stream('LaporanAdministrasiPasienRawatInap.pdf',array('Attachment' => 0));
?>

















