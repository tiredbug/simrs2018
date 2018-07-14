<?php
ob_start();
include "../connect.php";


$noruang = $_GET["noruang"];
///echo $noruang;

$id_tahun = $_GET["tahun"];
//echo $id_tahun;

$id_bulan = $_GET["bulan"];
//echo $id_bulan;

$id_carabayar = $_GET["statusbayar"];
//echo 'cra bayar '.$id_carabayar;

$KELASPERAWATAN_ID = $_GET["KELASPERAWATAN_ID"];
//echo 'kelas '.$KELASPERAWATAN_ID;

$sqlkelaskeperawatan = "select * from l_kelas_perawatan where kelasperawatan_id =  " . htmlspecialchars($KELASPERAWATAN_ID);
$querykelaskeperawatan = mysql_query($sqlkelaskeperawatan);
$datakelaskeperawatan = mysql_fetch_array($querykelaskeperawatan);


$sqlcarabayar = "select * from m_carabayar WHERE KODE = " . htmlspecialchars($id_carabayar);
$querycarabayar = mysql_query($sqlcarabayar);
$datacarabayar = mysql_fetch_array($querycarabayar);


$sqlbulan = "SELECT * FROM l_bulan where bulan_id = " . htmlspecialchars($id_bulan);
$querybulan = mysql_query($sqlbulan);
$databulan = mysql_fetch_array($querybulan);


$sqltahun = "SELECT * FROM l_tahun where tahun_id  =  " . htmlspecialchars($id_tahun);
$querytahun = mysql_query($sqltahun);
$datatahun = mysql_fetch_array($querytahun);

$sqlkamar = "SELECT * FROM m_ruang where no = " . htmlspecialchars($noruang);
$querykamar = mysql_query($sqlkamar);
$datakamar = mysql_fetch_array($querykamar);

?>

<html>
<head>
<title>CETAK BUKU RINCIAN ADMINISTRASI</title>
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
<!--
.style1 {font-size: xx-small}

@page { margin: 3px; }
body { margin: 3px; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><strong>RINCIAN ADMINISTRASI <?php print $datacarabayar['NAMA'].' '.$datakelaskeperawatan['kelasperawatan'].' BULAN '.$databulan['bulan_nama'].' '.$datatahun['tahun_nama'].' '.$datakamar['nama'] ;?></strong> </td>
  </tr>
</table>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="1%" rowspan="2"><span class="style1">No</span></td>
    <td width="8%" align="center"><span class="style1">Nama Pasien </span></td>
    <td colspan="2" align="center"><span class="style1">Tanggal</span></td>
    <td width="5%" align="center"><span class="style1">Diagnosa</span></td>
    <td width="12%" rowspan="2" align="center"><span class="style1">Nama Dokter </span></td>
    <td width="4%" rowspan="2"><span class="style1">Akomodasi</span></td>
    <td width="3%" rowspan="2" align="center"><span class="style1">Visit Dokter </span></td>
    <td colspan="2" rowspan="2" align="center"><span class="style1">Askep</span></td>
    <td colspan="2" align="center"><span class="style1">IDG</span></td>
    <td colspan="3" align="center"><span class="style1">Penunjang</span></td>
    <td colspan="2" align="center"><span class="style1">Tindakan Medik </span></td>
    <td width="3%" align="center"><span class="style1">BHP</span></td>
    <td width="5%" align="center"><span class="style1">02</span></td>
    <td width="4%" align="center" class="style1">PNonmds </td>
    <td width="8%" rowspan="2" align="center" class="style1"><span class="style1">Jumlah Total </span></td>
  </tr>
  <tr>
    <td align="center" class="style1">No Register </td>
    <td width="4%" align="center" class="style1">Masuk</td>
    <td width="4%" align="center" class="style1">Keluar</td>
    <td align="center" class="style1">Harga Obat </td>
    <td width="6%" align="center" class="style1">Karcis/TindIGD</td>
    <td width="4%" align="center" class="style1">Tind/Poli</td>
    <td width="3%" align="center" class="style1">RAD</td>
    <td width="3%" align="center" class="style1">LAB</td>
    <td width="3%" align="center" class="style1">K.Gizi </td>
    <td width="5%" align="center" class="style1">dokter</td>
    <td width="5%" align="center" class="style1">perawat</td>
    <td align="center" class="style1">Amblnc</td>
    <td align="center" class="style1">Fisioterapi</td>
    <td width="4%" align="center" class="style1">simrs</td>
  </tr>

<?php 
		$sql_dokter = "SELECT b.nama_diagnosa as 'NAMADIAGNOSA' ,a.* FROM vw_laporan_buku_rinc_adm a LEFT OUTER JOIN m_diagnosakeluar_ranap b ON (a.diagnosa_keluar=b.id) WHERE noruang =". htmlspecialchars($noruang)." AND bulan = ". htmlspecialchars($id_bulan)." AND tahun = ". htmlspecialchars($id_tahun)." AND statusbayar = ". htmlspecialchars($id_carabayar)." AND KELASPERAWATAN_ID = ". htmlspecialchars($KELASPERAWATAN_ID);
		//echo $sql_dokter;
		$no=1;
		$query_dokter = mysql_query($sql_dokter);
		while($data_tmno_dokter= mysql_fetch_array($query_dokter))
		{
  ?>

  <tr>
    <td class="style1"><?php print $no; ?></td>
    <td class="style1"><?php  print ucwords(strtolower($data_tmno_dokter['NAMA'])); ?></td>
    <td class="style1"><?php  print date("d-m-Y", strtotime($data_tmno_dokter['masukrs'])); ?></td>
    <td class="style1"><?php  print date("d-m-Y", strtotime($data_tmno_dokter['keluarrs'])); ?></td>
    <td><span class="style1">
      <?php  print ucwords(strtolower($data_tmno_dokter['NAMADIAGNOSA'])); ?>
    </span></td>
    <td><span class="style1">
      <?php  print ucwords(strtolower($data_tmno_dokter['dokter'])); ?>
    </span></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_BIAYA_AKOMODASI']; ?>
    </span></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_TRF_DOKTER']; ?>
    </span></td>
    <td width="4%"><span class="style1">
      <?php  print $data_tmno_dokter['TOTAL_BIAYA_ASKEP']; ?>
    </span></td>
    <td width="2%" align="center"><span class="style1">
      <?php  print $data_tmno_dokter['LOS']; ?>
    </span></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_TIND_IGD']; ?>
    </span></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_BIAYA_CDRPOLI']; ?>
    </span></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_BIAYA_RAD']; ?>
    </span></td>
    <td>&nbsp;</td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_BIAYA_GIZI']; ?>
    </span></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_TRF_TIND_DOKTER']; ?>
    </span></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_TRF_PERAWAT']; ?>
    </span></td>
    <td class="style1"><?php  print $data_tmno_dokter['TOT_BHP_PERAWAT'] + $data_tmno_dokter['TOT_BHP_DOKTER']; ?></td>
    <td class="style1"><?php  print $data_tmno_dokter['TOT_BIAYA_OKSIGEN']; ?></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOT_PENJ_NMEDIS']; ?>
    </span></td>
    <td><span class="style1">
      <?php echo number_format($data_tmno_dokter['BIAYA_TOTAL'],2,",","."); ?>
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="style1"><?php print ucwords($data_tmno_dokter['nomr']); ?></td>
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
    <td><table>
      <tr>
        <td> <span class="style1">
          <?php  print $data_tmno_dokter['TOT_BIAYA_AMBULAN']; ?>
        </span> </td>
      </tr>
    </table></td>
    <td class="style1"><?php  print $data_tmno_dokter['TOT_BIAYA_FISIO']; ?></td>
    <td><span class="style1">
      <?php  print $data_tmno_dokter['TOTAL_BIAYA_SIMRS']; ?>
    </span></td>
    <td>&nbsp;</td>
  </tr>
<?php $no++; }  ?>
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

















