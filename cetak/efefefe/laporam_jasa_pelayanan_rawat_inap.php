<?php

ob_start();
include '../../include/koneksi.php';
include '../../include/function.php';


$carabayar_id = $_GET['carabayar_nama'];
$ruang_id = $_GET['ruang_nama'];
$bulan_id = $_GET['bulan'];
$tahun_id = $_GET['tahun'];
$kelas_id = $_GET['kelas'];




$a = "SELECT a.LOS as 'j_askep'  FROM t_admission a WHERE a.noruang = ".$ruang_id." AND a.statusbayar = ".$carabayar_id." AND a.KELASPERAWATAN_ID =".$kelas_id." AND MONTH(a.keluarrs) = ".$bulan_id." AND YEAR(a.keluarrs)=".$tahun_id."";
$b = $conn->query($a);
$c = $b->fetch_assoc();


$bulan_sql = "SELECT bulan_nama from l_bulan WHERE bulan_id = ".$bulan_id." ";
$bulan_sql_proses = $conn->query($bulan_sql);
$bulan_sql_data = $bulan_sql_proses->fetch_assoc();

$kelas_sql = "SELECT * FROM simrs2012.l_kelas_perawatan WHERE kelasperawatan_id = ".$kelas_id." ";
$kelas_sql_proses = $conn->query($kelas_sql);
$kelas_sql_data = $kelas_sql_proses->fetch_assoc();


$carabayar_sql = "SELECT * from m_carabayar WHERE KODE = ".$carabayar_id." ";
$carabayar_sql_proses = $conn->query($carabayar_sql);
$carabayar_sql_data = $carabayar_sql_proses->fetch_assoc();

$ruang_sql = "SELECT * from m_ruang WHERE no = ".$ruang_id." ";
$ruang_sql_proses = $conn->query($ruang_sql);
$ruang_sql_data = $ruang_sql_proses->fetch_assoc();



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN JASA PELAYANAN PASIEN</title>
<style type="text/css">
<!--
.style1 {font-size: x-small}
-->
</style>
</head>

<body>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="72%"><span class="style1">LAPORAN JASA PELAYANAN PASIEN 
	<?php print $carabayar_sql_data['NAMA'].' '.$kelas_sql_data['kelasperawatan'].' RUANG '.$ruang_sql_data['nama']; ?>  </span></td>
    <td width="3%">&nbsp;</td>
    <td width="25%" align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td><span class="style1">BULAN <?php print $bulan_sql_data['bulan_nama'].' '.$tahun_id; ?></span></td>
    <td>&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">
	<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr align="center" valign="top">
        <td width="2%" rowspan="2" valign="middle" class="style1">No</td>
        <td rowspan="2" align="center" valign="middle" class="style1">Dokter</td>
        <td width="5%" rowspan="2" valign="middle" class="style1">VISIT</td>
        <td colspan="5" valign="middle" class="style1">TMNO DELEGASI </td>
        <td colspan="4" valign="middle" class="style1">TMNO MANDIRI DOKTER </td>
        <td width="3%" class="style1">Baca EKG </td>
      </tr>
      <tr>
        <td width="6%" align="center" valign="top" class="style1">SDHN</td>
        <td width="5%" align="center" valign="top" class="style1">KCL</td>
        <td width="5%" align="center" valign="top" class="style1">SDG</td>
        <td width="5%" align="center" valign="top" class="style1">BSR</td>
        <td width="6%" align="center" valign="top" class="style1">KHS</td>
        <td width="4%" align="center" valign="top" class="style1">KCL</td>
        <td width="4%" align="center" valign="top" class="style1">SDG</td>
        <td width="5%" align="center" valign="top" class="style1">BSR</td>
        <td width="6%" align="center" valign="top" class="style1">KHS</td>
        <td align="center" valign="top" class="style1">&nbsp;</td>
      </tr>
	  
		<?php 
				$QUERYJASPELDOKTER = "SELECT a.kd_dokter, a.NAMADOKTER, 
 (SELECT COUNT(b.tindakandetailvisitdokter_id) 
			FROM t_tindakan_detail_visit_dokter b 
					LEFT OUTER JOIN t_admission bb ON (b.admission_id_on_visit = bb.id_admission) 
						WHERE (MONTH(b.tanggal_on_visit)=".$bulan_id.") 
								AND (YEAR(b.tanggal_on_visit)=2016) 
                                AND (b.dokterid_on_visit = a.kd_dokter) 
                                AND (bb.KELASPERAWATAN_ID= ".$kelas_id.") 
                                AND (bb.statusbayar = ".$carabayar_id.") 
                                AND (bb.noruang = ".$ruang_id.") ) as 'JML_VISIT',
                                
 ( SELECT COUNT(c1.tindakandetaildokter_id) 
			FROM t_tindakan_detail_dokter c1 
					LEFT OUTER JOIN t_admission cc1 ON (c1.admission_id_tind_dokter = cc1.id_admission) 
						WHERE (c1.grup_tindakan=1) 
								AND (c1.KDDOKTER = a.kd_dokter) 
								AND(cc1.KELASPERAWATAN_ID= ".$kelas_id.") 
                                AND (cc1.statusbayar = ".$carabayar_id.") 
                                AND (cc1.noruang = ".$ruang_id.") 
                                AND (MONTH(c1.TANGGAL_tind_dokter)=".$bulan_id.") 
                                AND (YEAR(c1.TANGGAL_tind_dokter)=".$tahun_id.") ) as 'T_SEDERHANA', 
                                
 ( SELECT COUNT(c2.tindakandetaildokter_id) 
			FROM t_tindakan_detail_dokter c2 
					LEFT OUTER JOIN t_admission cc2 ON (c2.admission_id_tind_dokter = cc2.id_admission) 
						WHERE (c2.grup_tindakan=2) 
								AND (c2.KDDOKTER = a.kd_dokter) 
                                AND(cc2.KELASPERAWATAN_ID= ".$kelas_id.") 
                                AND (cc2.statusbayar =".$carabayar_id.") 
                                AND (cc2.noruang = ".$ruang_id.") 
                                AND (MONTH(c2.TANGGAL_tind_dokter)=".$bulan_id.") 
                                AND (YEAR(c2.TANGGAL_tind_dokter)=".$tahun_id.") ) as 'T_KECIL', 
                                
 ( SELECT COUNT(c3.tindakandetaildokter_id) 
			FROM t_tindakan_detail_dokter c3 
					LEFT OUTER JOIN t_admission cc3 ON (c3.admission_id_tind_dokter = cc3.id_admission) 
						WHERE (c3.grup_tindakan=3) 
								AND (c3.KDDOKTER = a.kd_dokter) 
                                AND(cc3.KELASPERAWATAN_ID= ".$kelas_id.") 
                                AND (cc3.statusbayar = ".$carabayar_id.") 
                                AND (cc3.noruang = ".$ruang_id.") 
                                AND (MONTH(c3.TANGGAL_tind_dokter)=".$bulan_id.") 
                                AND (YEAR(c3.TANGGAL_tind_dokter)=".$tahun_id.") ) as 'T_SEDANG',
                                
 ( SELECT COUNT(c4.tindakandetaildokter_id) 
			FROM t_tindakan_detail_dokter c4 
					LEFT OUTER JOIN t_admission cc4 ON (c4.admission_id_tind_dokter = cc4.id_admission) 
						WHERE (c4.grup_tindakan=4) 
								AND (c4.KDDOKTER = a.kd_dokter) 
                                AND(cc4.KELASPERAWATAN_ID= ".$kelas_id.") 
                                AND (cc4.statusbayar = ".$carabayar_id.") 
                                AND (cc4.noruang = ".$ruang_id.") 
                                AND (MONTH(c4.TANGGAL_tind_dokter)=".$bulan_id.") 
                                AND (YEAR(c4.TANGGAL_tind_dokter)=".$tahun_id.") ) as 'T_BESAR',
                                
                                
 ( SELECT COUNT(c5.tindakandetaildokter_id) 
			FROM t_tindakan_detail_dokter c5 
					LEFT OUTER JOIN t_admission cc5 ON (c5.admission_id_tind_dokter = cc5.id_admission) 
						WHERE (c5.grup_tindakan=5) 
								AND (c5.KDDOKTER = a.kd_dokter) 
                                AND(cc5.KELASPERAWATAN_ID= ".$kelas_id.") 
								AND (cc5.statusbayar = ".$carabayar_id.") 
                                AND (cc5.noruang = ".$ruang_id.") 
                                AND (MONTH(c5.TANGGAL_tind_dokter)=".$bulan_id.") 
                                AND (YEAR(c5.TANGGAL_tind_dokter)=".$tahun_id.") ) as 'T_KHUSUS'
                                
 FROM vw_dokter_jaga_ranap a ";
						$nod=1;
						$result = $conn->query($QUERYJASPELDOKTER);
						while($DATAJASPEL = $result->fetch_assoc())
						{	
						
				  ?>
  
      <tr align="center" valign="top">
        <td align="left" class="style1"><?php  print $nod; ?></td>
        <td width="32%" align="left" class="style1"><?php echo ucwords(strtolower($DATAJASPEL['NAMADOKTER'])); ?></td>
        <td class="style1"><?php print $DATAJASPEL['JML_VISIT'];?></td>
        <td class="style1"><?php print $DATAJASPEL['T_SEDERHANA'];?></td>
        <td class="style1"><?php print $DATAJASPEL['T_KECIL'];?></td>
        <td class="style1"><?php print $DATAJASPEL['T_SEDANG'];?></td>
        <td class="style1"><?php print $DATAJASPEL['T_BESAR'];?></td>
        <td class="style1"><?php print $DATAJASPEL['T_KHUSUS'];?></td>
        <td class="style1">&nbsp;</td>
        <td class="style1">&nbsp;</td>
        <td class="style1">&nbsp;</td>
        <td class="style1">&nbsp;</td>
        <td class="style1">&nbsp;</td>
      </tr>
	  
	   <?php $nod++; }  ?>
    </table>
    
    
	
	
	
	
	
	
	
	
	
    </td>
    <td>&nbsp;</td>
    <td align="center" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td colspan="5" align="center" class="style1">TINDAKAN KEPERAWATAN </td>
      </tr>
      <tr align="center" valign="middle">
        <td class="style1">SDHN</td>
        <td class="style1">KCL</td>
        <td class="style1">SDG</td>
        <td class="style1">BSR</td>
        <td class="style1">KHS</td>
      </tr>
	  <?php 
$sql_jp = "SELECT (SELECT count(b1.tindakandetailperawat_id) FROM t_tindakan_detail_perawat b1
		LEFT OUTER JOIN t_admission a1 ON (a1.id_admission= b1.admission_id_tp)
		WHERE (b1.grup_tindakan_tp=1) 
		AND(b1.kelas_perawatan_tp= $kelas_id) 
		AND (a1.statusbayar = $carabayar_id) 
		AND (a1.noruang = $ruang_id) 
		AND (MONTH(b1.TANGGAL)= $bulan_id) 
		AND (YEAR(b1.TANGGAL) = $tahun_id)) as 'TP_SDR',
		
		
		(SELECT count(b2.tindakandetailperawat_id) FROM t_tindakan_detail_perawat b2
		LEFT OUTER JOIN t_admission a2 ON (a2.id_admission= b2.admission_id_tp)
		WHERE (b2.grup_tindakan_tp=2) 
		AND(b2.kelas_perawatan_tp= $kelas_id) 
		AND (a2.statusbayar = $carabayar_id) 
		AND (a2.noruang = $ruang_id) 
		AND (MONTH(b2.TANGGAL)= $bulan_id) 
		AND (YEAR(b2.TANGGAL) = $tahun_id))as 'TP_KCL',
		
		
		(SELECT count(b3.tindakandetailperawat_id) FROM t_tindakan_detail_perawat b3
		LEFT OUTER JOIN t_admission a3 ON (a3.id_admission= b3.admission_id_tp)
		WHERE (b3.grup_tindakan_tp=3) 
		AND(b3.kelas_perawatan_tp= $kelas_id) 
		AND (a3.statusbayar = $carabayar_id) 
		AND (a3.noruang = $ruang_id) 
		AND (MONTH(b3.TANGGAL)= $bulan_id) 
		AND (YEAR(b3.TANGGAL) = $tahun_id)) as 'T_SEDANG',
		
		(SELECT count(b4.tindakandetailperawat_id) FROM t_tindakan_detail_perawat b4
		LEFT OUTER JOIN t_admission a4 ON (a4.id_admission= b4.admission_id_tp)
		WHERE (b4.grup_tindakan_tp=4) 
		AND(b4.kelas_perawatan_tp= $kelas_id) 
		AND (a4.statusbayar = $carabayar_id) 
		AND (a4.noruang = $ruang_id) 
		AND (MONTH(b4.TANGGAL)= $bulan_id) 
		AND (YEAR(b4.TANGGAL) = $tahun_id)) as 'T_BESAR',
		
		
		(SELECT count(b5.tindakandetailperawat_id) FROM t_tindakan_detail_perawat b5
		LEFT OUTER JOIN t_admission a5 ON (a5.id_admission= b5.admission_id_tp)
		WHERE (b5.grup_tindakan_tp=5) 
		AND(b5.kelas_perawatan_tp= $kelas_id) 
		AND (a5.statusbayar =  $carabayar_id) 
		AND (a5.noruang = $ruang_id) 
		AND (MONTH(b5.TANGGAL)= $bulan_id) 
		AND (YEAR(b5.TANGGAL) = $tahun_id)) as 'T_KHS'"; 
		

		$www=1;
		$result = $conn->query($sql_jp);
		while($data = $result->fetch_assoc())
		
		
		{
  ?>
		
      <tr align="center" valign="middle">
        <td class="style1"><?php print $data['TP_SDR'];  ?></td>
        <td class="style1"><?php print $data['TP_KCL']; ?></td>
        <td class="style1"><?php print $data['T_SEDANG']; ?></td>
        <td class="style1"><?php print $data['T_BESAR']; ?></td>
        <td class="style1"><?php print $data['T_KHS']; ?></td>
      </tr>
	   <?php $www++; }  ?>
    </table>
    <br />
      <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
          <td colspan="2" align="center" class="style1">ASKEP</td>
        </tr>
        <tr>
          <td width="51%" align="center" class="style1">ASKEP UMUM </td>
          <td width="49%" align="center" class="style1">&nbsp;</td>
        </tr>
		
		<?php
		$sql_DD = "(SELECT count(b4.tindakandetailperawat_id) as 'T_BESAR' FROM t_tindakan_detail_perawat b4
		LEFT OUTER JOIN t_admission a4 ON (a4.id_admission= b4.admission_id_tp)
		WHERE (b4.grup_tindakan_tp =4) 
		AND(b4.kelas_perawatan_tp= $kelas_id) 
		AND (a4.statusbayar = $carabayar_id) 
		AND (a4.noruang = $ruang_id) 
		AND (MONTH(b4.TANGGAL)= $bulan_id) 
		AND (YEAR(b4.TANGGAL) = $tahun_id))  "; 

	$wqq=1;
		$result = $conn->query($sql_DD);
		while($datasss = $result->fetch_assoc())
		{
		
		 ?>
        <tr>
          <td align="center" class="style1">ASKEP SPESIALIS </td>
          <td align="center" class="style1"><?php  print $datasss['T_BESAR']; ?></td>
        </tr>
		<?php $wqq++; } ?>
      </table>
          <br />
              <br />
      <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">

        <tr>
          <td width="100%" align="center" class="style1">Mengetahui</td>
        </tr>
        <tr>
          <td align="center" class="style1">Kepala Instansi Rawat Inap </td>
        </tr>
        <tr>
          <td align="center" class="style1">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="style1">
          		<br />
              	<br />
                <br />
              	<br />
              </td>
        </tr>
		<?php
		$sql_penandatangan = "select * from vw_penandatangan_ruangan where no =".htmlspecialchars($ruang_id);; 	
		$aa=1;
		$result = $conn->query($sql_penandatangan);
		while($data_penanda = $result->fetch_assoc())

		{
		
		 ?>
        <tr>
          <td align="center" class="style1"><?php print $data_penanda['kepala_ruangan'];  ?></td>
        </tr>
        <tr>
          <td align="center" class="style1">NIP. <?php print  $data_penanda['nip_kepala_ruangan']; ?></td>
        </tr>
		
		<?php  $$aa++; }  ?>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
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
$dompdf->setPaper('F4', 'landscape');

$dompdf->render();

$dompdf->stream('LaporanJaspelRawatInap.pdf',array('Attachment' => 0)); 
?>