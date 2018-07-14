<?php
error_reporting(E_ALL);
ob_start();
include '../../include/koneksi.php';
include '../../include/function.php';


$id_admission = htmlspecialchars($_GET["idx"]);
$QUERY = "SELECT * FROM t_admission WHERE id_admission = ".$id_admission ." limit 1";
$result = $conn->query($QUERY);
$DATA_PENDAFTARAN = $result->fetch_assoc();
$yy = $DATA_PENDAFTARAN['keluarrs'];


$sql_data_pasien_ranap = "SELECT * FROM simrs2012.t_admission where id_admission = ". htmlspecialchars($_GET["idx"])."  LIMIT 1";
$result_data_pasien_ranap = $conn->query($sql_data_pasien_ranap);
$data_sql_data_pasien_ranap = $result_data_pasien_ranap->fetch_assoc();
$data_identitas = getDataIdentitasPasienRawatInap($data_sql_data_pasien_ranap['id_admission']);


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
    <td align="center" valign="top" class="kode"><span class="style20"><?php print $DATA_PENDAFTARAN['nomr']; ?></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">4</span></td>
    <td align="left" valign="top" class="item"><span class="style20">NO.SKP</span></td>
    <td align="center" valign="top" class="kode"><span class="style20"><?php print $DATA_PENDAFTARAN['NO_SKP']; ?></span></td>
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
    <td align="center" valign="top" class="kode"><span class="style20"><?php print getNamaPasienByNOMR($DATA_PENDAFTARAN['nomr']); ?></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">7</span></td>
    <td align="left" valign="top" class="item"><span class="style20">KELAS PERAWATAN </span></td>
    <td align="center" valign="middle" class="kode"><span class="style20"><?php print $DATA_PENDAFTARAN['KELASPERAWATAN_ID']; ?></span></td>
    <td align="left" valign="top" class="ket">1)Kelas I<br/>
        2)Kelas II <br/>
    3)Kelas III <br/>
    4)HCU/ICU</td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">8</span></td>
    <td align="left" valign="top" class="item"><span class="style20">CARA BAYAR </span></td>
    <td align="center" valign="middle" class="kode"><span class="style20"><?php print getNamaJaminan($DATA_PENDAFTARAN['statusbayar']); ?></span></td>
    <td align="left" valign="top" class="ket">1)BPJS PBI<br/>2)BPJS NON PBI <br/>3)Umum <br/>4)Jamsostek</td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">9</span></td>
    <td align="left" valign="top" class="item"><span class="style20">JENIS PERAWATAN </span></td>
    <td align="center" valign="middle" class="kode"><span class="style20"><?php print '1'; ?></span></td>
    <td align="left" valign="top" class="ket"><span class="style20">1)Rawat Inap<br/>
    2)Rawat Jalan </span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">10</span></td>
    <td align="left" valign="top" class="item"><span class="style20">TANGGAL MASUK/JAM </span></td>
    <td align="center" valign="top" class="kode"><?php  //print date("d-m-Y", strtotime($q3['masukrs'])); 
	//print $data_identitas[16];
	print date("d-m-Y", strtotime($data_identitas[15]));
	?></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">11</span></td>
    <td align="left" valign="top" class="item"><span class="style20">TANGGAL KELUAR/JAM </span></td>
    <td align="center" valign="top" class="kode"><?php  //print date("d-m-Y", strtotime($q3['keluarrs']));
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print 'belum dipulangkan';
		}else
		{
			
			print date("d-m-Y", strtotime($data_identitas[12]));
		}
	 ?></td>
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
    <td align="center" valign="top" class="kode"><?php 

		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
			$r = $data_identitas[19]; 
			print $r;
		}
	
	 ?></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">14</span></td>
    <td align="left" valign="top" class="item"><span class="style20">JENIS KELAMIN </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"><?php 
	$p = caridataPasien($DATA_PENDAFTARAN['nomr']);
	 echo $p[4];
	
	?></span></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">15</span></td>
    <td align="left" valign="top" class="item"><span class="style20">CARA PULANG </span></td>
    <td align="center" valign="top" class="kode"><span class="style20"><?php print getNamaStatusKeluarRanap($DATA_PENDAFTARAN['statuskeluarranap_id']); ?></span></td>
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
    <td align="center" valign="top" class="kode"><?php 
	$sql = "SELECT * FROM simrs2012.t_admission_detail_diagnosa where id_admission = ".$id_admission." order by id  LIMIT 1";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo  $row["diagnosa_dokter"]. "<br>";
			}
		} else {
			echo "-";
		}
			
	 ?></td>
    <td align="left" valign="top" class="ket"><span class="style20"><span class="kode">
      <?php 
	$sql = "SELECT * FROM simrs2012.t_admission_detail_diagnosa where id_admission = ".$id_admission." order by id  LIMIT 1";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo  $row["diagnosa_icd"]. "<br>";
			}
		} else {
			echo "-";
		}
			
	 ?>
    </span></span></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">18</span></td>
    <td align="left" valign="top" class="item"><span class="style20">DIAGNOSA SEKUNDER </span></td>
    <td align="center" valign="top" class="kode"><?php 
	$sql = "SELECT * FROM simrs2012.t_admission_detail_diagnosa where id_admission = ".$id_admission." order by id  LIMIT 1,18446744073709551615";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo  $row["diagnosa_dokter"]. "<br>";
			}
		} else {
			echo "-";
		}
			
	 ?><p></p>
    <p>&nbsp;</p></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span><span class="style20"></span><span class="style20"></span><span class="kode">
      <?php 
	$sql = "SELECT * FROM simrs2012.t_admission_detail_diagnosa where id_admission = ".$id_admission." order by id  LIMIT 1,18446744073709551615";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo  $row["diagnosa_icd"]. "<br>";
			}
		} else {
			echo "-";
		}
			
	 ?>
    </span></td>
  </tr>
  
  <tr>
    <td align="left" valign="top" class="NO"><span class="style20">19</span></td>
    <td align="left" valign="top" class="item"><p class="style20">TINDAKAN</p>
    <p class="style20">&nbsp;</p>
    <p class="style20">&nbsp;</p></td>
    <td align="center" valign="top" class="kode"><?php 
	$sql = "SELECT * FROM simrs2012.t_admission_detail_tindakan where id_admission_t_admission_detail_tindakan = ".$id_admission." order by id_t_admission_detail_tindakan  ";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo  $row["tindakan_dokter"]. "<br>";
			}
		} else {
			echo "-";
		}
			
	 ?></td>
    <td align="left" valign="top" class="ket"><span class="style20"></span><span class="style20"></span><span class="style20"><?php 
	$sql = "SELECT * FROM simrs2012.t_admission_detail_tindakan where id_admission = ".$id_admission." order by id  LIMIT 1";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo  $row["tindakan_icd"]. "<br>";
			}
		} else {
			echo "icd -  ";
		}
			
	 ?></span></td>
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
    <td align="left" valign="top" class="ket"><span class="style20">
      <?php 
		$r = $data_identitas[12];  
		if ((is_null($r)) || ($r == NULL) || ($r =='') )
		{
			print '-';
		}else
		{
		
			//LOS 		
			$LOS = $data_identitas[19]; 
			//KOEFISIEN AKOMODASI
			$koef_akomodasi = $data_identitas[16];
			// KOEFIEEN ASKEP
			$koef_askep = $data_identitas[17];
			// KOEF PELAYANAN NON MEDIS
			$koef_pelayanan_nonmedis = $data_identitas[18];
			
			
			//BIAYA SIMRS
			$total_simrs = $data_identitas[20]; 
			//BIAYA AKOMODASI
			$total = $koef_akomodasi*$LOS;
			// BIAYA ASKEP
			$total_askep = $LOS*$koef_askep;
			//BIAYA PEL NONMEDIS
			$total_pel_nonmedis = $LOS*$koef_pelayanan_nonmedis;
			//BIAYA PERAWATAN LAIN
			$perawatan = getBiayaPerawatanRawatInap($id_admission);
			$perawatan_pelayanan = $perawatan[18];
			
			$total_biaya = $total_simrs+$total+$total_askep+$total_pel_nonmedis +$perawatan_pelayanan;
			
			print number_format($total_biaya ,0,",","."). "<br>";
		
		}
	
	 ?>
    </span></td>
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
    <td align="left" valign="top" class="ket"><span class="style20"><?php print $DATA_PENDAFTARAN['dokter_penanggungjawab']; ?></span></td>
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

















