<?php
ob_start();
include "../connect.php";
// http://192.168.1.100/simrs/cetak/billing/rinc_adm_naik_kelas.php
$QUERY = "SELECT * FROM vw_laporan_naik_kelas_perbulan WHERE id_admission = " . htmlspecialchars($_GET["id_admission"]);
$data = mysql_query($QUERY);
$DATA_PENDAFTARAN = mysql_fetch_array($data);

$q1 = "SELECT * FROM vw_identitas_pasien_by_id_admission WHERE id_admission = "  . htmlspecialchars($_GET["id_admission"]);
$q2 = mysql_query($q1);
$q3 = mysql_fetch_array($q2);
?>
<html>
<head>
<title>CETAK RINCIAN ADMINISTRASI</title>
<link rel="shortcut icon" href="../favicon.ico"/>
<style type="text/css">
<!--
.style1 {font-size: x-small}

@page { margin: 5px; }
body { margin: 5px; }
-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center">
    <td width="13%" rowspan="4"><img src="logo rs black.png" alt="ws" width="77" height="66" /></td>
    <td width="66%" align="center"><span class="style1" >PEMERINTAH DAERAH KABUPATEN </span></td>
    <td width="21%" align="center">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span class="style1" >RUMAH SAKIT UMUM DAERAH AJIBARANG</span></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span class="style1" >Jl. Raya Pancasan &ndash; Ajibarang, Kab. Banyumas, </span></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span class="style1" >Email: rsudajibarang@banyumaskab.go.id</span></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<hr />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr align="center" class="style1">
    <td colspan="8"><span >DAFTAR RINCIAN ADMINISTRASI RAWAT INAP </span></td>
  </tr>
  <tr align="center" class="style1">
    <td width="17%" align="left" valign="top"><span >NAMA</span></td>
    <td width="1%" align="left" valign="top"><span >:</span></td>
    <td width="45%" align="left" valign="top"><span ><?php print $q3['NAMA']; ?></span></td>
    <td width="1%" align="left" valign="top"><span ></span></td>
    <td width="1%" align="left" valign="top"><span ></span></td>
    <td width="20%" align="left" valign="top"><span >NO RM</span></td>
    <td width="1%" align="left" valign="top"><span >:</span></td>
    <td width="14%" align="left" valign="top"><span ><?php print $q3['nomr']; ?></span></td>
  </tr>
  <tr align="center" class="style1">
    <td width="17%" align="left" valign="top"><span >UMUR</span></td>
    <td align="left" valign="top"><span >:</span></td>
    <td align="left" valign="top"><span ><?php print $q3['UMUR']; ?> Tahun </span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span >JK</span></td>
    <td align="left" valign="top"><span >:</span></td>
    <td align="left" valign="top"><span ><?php print $q3['JENISKELAMIN']; ?></span></td>
  </tr>
  <tr align="center" class="style1">
    <td width="17%" align="left" valign="top"><span >ALAMAT</span></td>
    <td align="left" valign="top"><span >:</span></td>
    <td align="left" valign="top"><span >
	<?php print $q3['ALAMAT'].', kec.'.$q3['namakecamatan']; ?><span class="style17"></span></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
  </tr>
  <tr class="style1">
    <td width="17%" align="left" valign="top"><span >RUANG/KELAS</span></td>
    <td align="left" valign="top"><span >:</span></td>
    <td align="left" valign="top"><span > <?php print $q3['NAMARUANGRAWAT']; ?>/ <?php print $q3['kelasperawatan']; ?></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
  </tr>
  <tr align="center" valign="middle" class="style1">
    <td align="left" valign="top"><span >TANGGAL MASUK </span></td>
    <td align="left" valign="top"><span >:</span></td>
    <td align="left" valign="top"><span ><?php  print date("d-m-Y", strtotime($q3['masukrs'])); ?></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span >TANGGAL KELUAR </span></td>
    <td align="left" valign="top"><span >:</span></td>
    <td align="left" valign="top"><span >
      <?php  print date("d-m-Y", strtotime($q3['keluarrs'])); ?>
    </span></td>
  </tr>
  <tr align="center" valign="middle" class="style1">
    <td align="left" valign="top"><span >STATUS PASIEN </span></td>
    <td align="left" valign="top"><span >:</span></td>
    <td align="left" valign="top"><?php print 'iuran naik '.$DATA_PENDAFTARAN['kelas_lama'].' - '.$DATA_PENDAFTARAN['kelas_baru']; ?></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr align="center" valign="middle" bordercolor="#000000">
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
    <td align="left" valign="top"><span ></span></td>
  </tr>
</table>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="style1">
  <tr align="center">
    <td align="center"><span >NO</span></td>
    <td align="center" valign="middle"><strong>KETERANGAN BIAYA </strong></td>
    <td colspan="3" align="center" valign="top"><strong>KETERANGAN TAMBAHAN </strong></td>
    <td align="right" valign="top"><strong>JUMLAH</strong></td>
  </tr>
  <tr align="center">
    <td width="3%" align="center"><span >1.</span></td>
    <td width="35%" align="left" valign="middle"><span >Karcis, Tindakan IGD </span></td>
    <td width="14%" align="center" valign="top"><span ></span></td>
    <td width="6%" align="center"><span ></span></td>
    <td width="20%" align="center"><span ></span></td>
    <td width="22%" align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td width="3%" align="center"><span ></span></td>
    <td align="left" valign="middle"><span >a.</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >b.</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span >2.</span></td>
    <td align="left" valign="middle"><span >Akomodasi</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span >x</span></td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span >3.</span></td>
    <td align="left" valign="middle"><span >Visit Dokter </span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
 <?php 
 
 //$QUERY = "SELECT * FROM vw_adm_rawat_inap WHERE id_admission = " . htmlspecialchars($_GET["id_admission"]);
		$ss = "SELECT a.dokterid_on_visit,b.NAMADOKTER,a.harga_on_visit,
COUNT(a.tindakandetailvisitdokter_id) as 'VISIT',
COUNT(a.tindakandetailvisitdokter_id) * a.harga_on_visit as 'subtotal'
FROM t_tindakan_detail_visit_dokter a
LEFT OUTER JOIN m_dokter b ON (a.dokterid_on_visit=b.KDDOKTER)
WHERE admission_id_on_visit =" . htmlspecialchars($_GET["id_admission"])." group by dokterid_on_visit";
		$n=1;
		$q = mysql_query($ss);
		while($d= mysql_fetch_array($q))
		{
  ?>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">x</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
<?php $no++; }  ?>
  
  <tr align="center">
    <td align="center">4</td>
    <td align="left" valign="middle"><span >Asuhan Keperawatan </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">5</td>
    <td align="left" valign="middle"><span >Pelayanan RM &amp; SIMRS </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">6</td>
    <td align="left" valign="middle"><span >Pelayanan Penunjang Non-Medis </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">x</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">7</td>
    <td align="left" valign="middle"><span >Konsultasi Gizi </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">8</td>
    <td align="left" valign="middle"><span >Penunjang</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><span >Radiologi</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">a</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">b</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">9</td>
    <td align="left" valign="middle"><span >Laboratorium</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><span >a.IGD</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><span >b.POLI &amp; CDR </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td width="3%" align="center"><span >10.</span></td>
    <td width="35%" align="left" valign="middle"><span >Tindakan Keperawatan </span></td>
    <td width="14%" align="center" valign="top">&nbsp;</td>
    <td width="6%" align="center"><span ></span></td>
    <td width="20%" align="center"><span ></span></td>
    <td width="22%" align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Sederhana</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Kecil</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Sedang</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Besar</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Khusus</span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span >11.</span></td>
    <td align="left" valign="middle"><span >TMNO</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Sederhana </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Kecil </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Sedang </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle"><span >- Besar </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >- Khusus </span></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span >12.</span></td>
    <td align="left" valign="middle"><span >TMO</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >a.</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span ></span></td>
    <td align="left" valign="middle"><span >b.</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span >13.</span></td>
    <td align="left" valign="middle"><span >BHP Tindakan </span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span >14</span></td>
    <td align="left" valign="middle"><span >BHP Laboratorium </span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span >15</span></td>
    <td align="left" valign="middle"><span >BHP Radiologi </span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span >16</span></td>
    <td align="left" valign="middle"><span >Fisioterapi</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span >17</span></td>
    <td align="left" valign="middle"><span >IPJ</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top"><span ></span></td>
  </tr>
  <tr align="center">
    <td align="center"><span >18</span></td>
    <td align="left" valign="middle"><span >Obat</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span >19.</span></td>
    <td align="left" valign="middle"><span >Oksigen</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center"><span >20.</span></td>
    <td align="left" valign="middle"><span >Ambulance</span></td>
    <td align="center" valign="top"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="center"><span ></span></td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">JUMLAH TOTAL </td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right" valign="top">Rp. <?php print number_format($DATA_PENDAFTARAN['jumlah_iuran'],2,",","."); ?></td>
  </tr>
  <tr align="center">
    <td align="center">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">Petugas,</td>
    <td align="right" valign="top">&nbsp;</td>
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

















