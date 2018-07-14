<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$counter_cetak;
include '../../include/koneksi.php';
include '../../include/function.php';
/*
$id = $_GET["idx"];
$QUERY = "SELECT * FROM vw_identitas_pasien_by_id_admission WHERE id_admission = " . htmlspecialchars($id);
$result = $conn->query($QUERY);
$data_sql_data_pasien = $result->fetch_assoc();*/
$id = $_GET["idx"];

$sql_data_pasien_ranap = "SELECT * FROM simrs2012.t_admission where id_admission = ". htmlspecialchars($_GET["idx"])."  LIMIT 1";
$result_data_pasien_ranap = $conn->query($sql_data_pasien_ranap);
$data_sql_data_pasien_ranap = $result_data_pasien_ranap->fetch_assoc();
$data_identitas = getDataIdentitasPasienRawatInap($data_sql_data_pasien_ranap['id_admission']);



/*
$data = mysql_query($QUERY);
$data_sql_data_pasien = mysql_fetch_array($data);*/
?>

<html>
<head>
<title>CETAK TMNO</title>
<link rel="shortcut icon" href="../../favicon.ico"/>

<style type="text/css">
<!--
.style2 {font-size: xx-small}

@page { margin: 1px; }
body { margin: 1px; }
.style9 {font-weight: bold}
.style11 {font-size: 12px}
.style12 {font-size: x-small}
.style14 {font-size: x-small; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td width="49%" align="center" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" valign="middle">
    <td><strong>PEMERINTAH DAERAH KABUPATEN BANYUMAS</strong></td>
  </tr>
  <tr align="center" valign="middle">
    <td><strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
  </tr>
  <tr align="center" valign="middle">
    <td><span class="style12">Jl. Raya Pancasan &ndash; Ajibarang, Kab. Banyumas, Telp. (0281) 6570004</span></td>
  </tr>
  <tr>
    <td class="style2"><hr /></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style14">BLANGKO RINCIAN BIAYA TINDAKAN MEDIS/NON OPERATIK DOKTER </span></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr align="left" valign="top">
    <td width="11%"><span class="style11" >Nama</span></td>
    <td width="1%"><span class="style11" >:</span></td>
    <td width="56%"><?php print $data_identitas[1]; ?></td>
    <td width="2%"><span class="style11"></span></td>
    <td width="14%"><span class="style11" >No.RM</span></td>
    <td width="1%" class="style2"><span class="style11" >:</span></td>
    <td width="15%"><?php print $data_identitas[9]; ?></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11" >Umur</span></td>
    <td><span class="style11" >:</span></td>
    <td><?php 

	$p =  $data_identitas[2];
	$a = datediff($p, date("Y/m/d"));
	echo $a[years].' tahun '.$a[months].' bulan';
	
	?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11" >L/P</span></td>
    <td class="style2"><span class="style11" >:</span></td>
    <td><?php print $data_identitas[8]; ?></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11" >Alamat</span></td>
    <td><span class="style11" >:</span></td>
    <td><?php //print ucwords(strtolower($q3['ALAMAT'].', kec.'.$q3['namakecamatan'])); 
	print $data_identitas[3].'-'.$data_identitas[5];
	
	?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td class="style11">&nbsp;</td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11" >Status</span></td>
    <td><span class="style11" >:</span></td>
    <td><strong><?php print $data_identitas[13];  ?></strong></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td class="style11">&nbsp;</td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11" >Ruang</span></td>
    <td><span class="style11" >:</span></td>
    <td><?php //echo ucwords(strtolower($q3['NAMARUANGRAWAT']));
		print $data_identitas[10].' / '.$data_identitas[14];
	  ?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td class="style11">&nbsp;</td>
    <td><span class="style11"></span></td>
    </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr align="center" valign="top">
    <td width="5%" align="center"><span class="style2">No</span></td>
    <td width="15%"><span class="style2" >Tanggal</span></td>
    <td width="29%"><span class="style2">Tindakan</span></td>
    <td width="26%"><span class="style2" >Biaya</span></td>
    <td width="30%"><span class="style2" >Bhp</span></td>
  </tr>
<?php 
		$sql_dokter = "SELECT a.*,b.namatindakan FROM t_tindakan_detail_dokter a LEFT OUTER JOIN m_tindakan_tarif b ON (a.KODETINDAKAN = b.tindakantarif_id)
 WHERE admission_id_tind_dokter = ". htmlspecialchars($id)." order by TANGGAL_tind_dokter ";
// echo $sql_dokter;
		$no=1;
		$result = $conn->query($sql_dokter);
		if ($result->num_rows > 0) {
    	while($data_tmno_dokter = $result->fetch_assoc()) {
  ?>
  <tr align="left" valign="top">
    <td align="center"><span class="style2"><?php echo $no;  ?></span></td>
    <td><span class="style2"><?php echo ' '.date("d-m-Y", strtotime($data_tmno_dokter['TANGGAL_tind_dokter']));  ?></span></td>
    <td><span class="style2"><?php echo ucwords(strtolower($data_tmno_dokter['namatindakan']));  ?></span></td>
	

	
    <td align="left">
	  <span class="style2"><?php echo $data_tmno_dokter['QTY'].' x '.number_format($data_tmno_dokter['BIAYA'],0,",",".").' = '.number_format($data_tmno_dokter['sub_biaya'],0,",",".")  ;  ?></span></td>
    <td align="left">
	  <span class="style2"><?php echo $data_tmno_dokter['QTY'].' x '.number_format($data_tmno_dokter['BHP'],0,",",".").' = '.number_format($data_tmno_dokter['sub_bhp'],0,",",".")  ;  ?></span></td>
  </tr>
 <?php $no++; }} else {} ?>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="bottom">
    <td width="6%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="26%"><span class="style64 style16"><strong>Jumlah</strong></span></td>
    <td width="31%"><span class="style64 style16"><strong>Rp.
      <?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["idx"]));
			print number_format($rr[3],0,",",".");
	 ?>
    </strong></span></td>
    <td width="30%"><strong>Rp.  <?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["idx"]));
			print number_format($rr[4],0,",",".");
	 ?></strong></td>
  </tr>
</table></td>
    <td width="1%" align="center" valign="top"></td>
    <td width="50%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr align="center" valign="middle">
        <td><strong>PEMERINTAH DAERAH KABUPATEN BANYUMAS</strong></td>
      </tr>
      <tr align="center" valign="middle">
        <td><strong>RUMAH SAKIT UMUM DAERAH AJIBARANG</strong></td>
      </tr>
      <tr align="center" valign="middle">
        <td><span class="style12">Jl. Raya Pancasan &ndash; Ajibarang, Kab. Banyumas, Telp. (0281) 6570004</span></td>
      </tr>
      <tr>
        <td><hr /></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><span class="style14">BLANGKO RINCIAN BIAYA TINDAKAN MEDIS/NON OPERATIK PERAWAT </span></td>
      </tr>
    </table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr align="left" valign="top">
    <td width="11%"><span class="style11">Nama</span></td>
    <td width="1%"><span class="style11">:</span></td>
    <td width="56%"><?php print $data_identitas[1]; ?></td>
    <td width="2%"><span class="style11"></span></td>
    <td width="14%"><span class="style11">No.RM</span></td>
    <td width="1%"><span class="style11">:</span></td>
    <td width="15%"><?php print $data_identitas[9]; ?></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11">Umur</span></td>
    <td><span class="style11">:</span></td>
    <td><?php 

	$p =  $data_identitas[2];
	$a = datediff($p, date("Y/m/d"));
	echo $a[years].' tahun '.$a[months].' bulan';
	
	?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11">L/P</span></td>
    <td><span class="style11">:</span></td>
    <td><?php print $data_identitas[8]; ?></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11">Alamat</span></td>
    <td><span class="style11">:</span></td>
    <td><?php //print ucwords(strtolower($q3['ALAMAT'].', kec.'.$q3['namakecamatan'])); 
	print $data_identitas[3].'-'.$data_identitas[5];
	
	?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11">Status</span></td>
    <td><span class="style11">:</span></td>
    <td><strong><?php print $data_identitas[13];  ?></strong></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    </tr>
  <tr align="left" valign="top">
    <td><span class="style11">Ruang</span></td>
    <td><span class="style11">:</span></td>
    <td><?php //echo ucwords(strtolower($q3['NAMARUANGRAWAT']));
		print $data_identitas[10].' / '.$data_identitas[14];
	  ?></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    <td><span class="style11"></span></td>
    </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
        <tr align="center" valign="top">
          <td width="4%" align="center"><span class="style9 style63 style2">No</span></td>
          <td width="14%"><span class="style2">Tanggal</span></td>
          <td width="31%"><span class="style2">Tindakan</span></td>
          <td width="25%"><span class="style2">Biaya</span></td>
          <td width="22%"><span class="style2">Bhp</span></td>
        </tr>
<?php 
		$sql_perawat = "SELECT a.*,b.namatindakan FROM simrs2012.t_tindakan_detail_perawat a LEFT OUTER JOIN m_tindakan_tarif b ON (a.KODETINDAKAN_tp = b.tindakantarif_id)
 WHERE a.admission_id_tp =". htmlspecialchars($id)." order by TANGGAL";
 //echo $sql_perawat;
		$noq=1;
		$result = $conn->query($sql_perawat);
		if ($result->num_rows > 0) {
    	while($data_tmno_perawat = $result->fetch_assoc()) {
  ?>
        <tr align="left" valign="top">
          <td align="center" valign="top">            <span class="style2"  >
            <?php  echo $noq; ?>
          </span> </td>
          <td>
		    <span class="style2"  ><?php echo date("d-m-Y", strtotime($data_tmno_perawat['TANGGAL']));  ?></span> </td>
          <td>            <span class="style2"  >
            <?php  echo ucwords(strtolower($data_tmno_perawat['namatindakan'])); ?>
          </span> </td>
		  
		 
		  
          <td align="center"><span class="style2"  ><?php echo $data_tmno_perawat['QTY_tp'].' x '.number_format($data_tmno_perawat['BIAYA_tp'],0,",",".").' = '.number_format($data_tmno_perawat['sub_biaya_tp'],0,",",".")  ;  ?></span></td>
          <td align="center"><span class="style2"  ><?php echo $data_tmno_perawat['QTY_tp'].' x '.number_format($data_tmno_perawat['BHP_tp'],0,",",".").' = '.number_format($data_tmno_perawat['sub_bhp_tp'],0,",",".")  ;  ?></span></td>
        </tr>
		<?php $noq++; }} else {} ?>
      </table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="bottom">
          <td width="6%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="29%"><strong>Jumlah</strong></td>
          <td width="27%"><span class="style66"><strong>Rp. 
            <?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["idx"]));
			print number_format($rr[5],0,",",".");
	 ?>
          </strong></span></td>
          <td width="28%"><span class="style66"><strong>Rp. 
            <?php 
			$rr = getBiayaPerawatanRawatInap(htmlspecialchars($_GET["idx"]));
			print number_format($rr[6],0,",",".");
	 ?>
          </strong></span></td>
        </tr>
  </table>  </tr>
</table>
</body>
</html>



<?php
/*$html = ob_get_clean();


require_once("../../dompdf_baru/dompdf_config.inc.php");

$customPaper = array(0,0,935,609);

//require_once("../dompdf/autoload.inc.php");
$dompdf = new DOMPDF();
//$html = "<B> tes </B>" ;
$dompdf->load_html($html);
//$dompdf->set_paper("A4", 'landscape');
$dompdf->set_paper($customPaper);
$dompdf->render();
//$dompdf->stream('tmno.pdf',array('Attachment' => 0)); 
$dompdf->stream('LAPORAN_TMNO_'.
$data_sql_data_pasien['nomr'].'_'.
$data_sql_data_pasien['NAMA'].'_'.
$data_sql_data_pasien['NAMARUANGRAWAT'].'_'.
$data_sql_data_pasien['JENISPEMBAYARAN'].'_'.
$data_sql_data_pasien['kelasperawatan'].'_'.
date("d-m-Y", strtotime($data_sql_data_pasien['keluarrs'])).'_.pdf',array('Attachment' => 0)); */

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

















