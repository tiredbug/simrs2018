<?php
if (session_id() == "") 
	session_start(); 
	ob_start();
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once "phpfn13.php" ?>
<?php
if (!IsLoggedIn()) {
    echo "Akses ditolak. Silahkan <a href='login.php'>login</a> terlebih dulu!<br>";
} else {
		include 'phpcon/koneksi.php'; 
		include 'phpcon/fungsi_col.php';
		date_default_timezone_set('Asia/Jakarta');
		$today = date("d/m/Y H:i:s"); 

		$kdspp = htmlspecialchars($_GET["kdspp"]);
		$sql= "SELECT * FROM simrs2012.t_sbp where id = ".$kdspp." limit 1";
		$result = $conn->query($sql);
    	$userdata = $result->fetch_assoc();
		
		//jumlah belanja
		$sql3= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_sbp_detail where id_sbp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
		$result3 = $conn->query($sql3);
    	$userdata3 = $result3->fetch_assoc();
		
		//jumlah Pajak
		$sql4= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_sbp_detail where id_sbp = ".$kdspp." and kd_rekening_belanja LIKE '7%'";
		$result4 = $conn->query($sql4);
    	$userdata4 = $result4->fetch_assoc();
		
		
		//jumlah PPH 22
		$sql5= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_PAJAK'FROM simrs2012.t_sbp_detail where id_sbp = ".$kdspp." and kd_rekening_belanja = '7.1.1.04.02'";
		$result5 = $conn->query($sql5);
    	$userdata5 = $result5->fetch_assoc();
		
		
		//jumlah PPN
		$sql6= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_PAJAK' FROM simrs2012.t_sbp_detail where id_sbp = ".$kdspp." and kd_rekening_belanja = '7.1.1.05.01'";
		$result6 = $conn->query($sql6);
    	$userdata6 = $result6->fetch_assoc();
		
		
		$conn->close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SURAT BUKTI PENGELUARAN</title>
<style type="text/css">
@page {
   size: 21cm 33.0cm ;
  margin: 0;
}

body {  
    font-family: 'Courier';
	font-size: 11px;
}

</style>
</head>

<body onload="window.print();">
<?php 
$x = 1; 
while($x <= 2) {
?>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td colspan="3"><br />
		<div align="center"><strong>SURAT BUKTI PENGELUARAN 
		</strong><br />
	NOMER : <?php print $userdata["no_sbp"];?> &nbsp;&nbsp;&nbsp;Tanggal: <?php print date("d-m-Y", strtotime($userdata['tgl_sbp']));?></div><br /></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="17%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="82%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;Kode SKPD </td>
        <td>:</td>
        <td>&nbsp;<?php print $userdata["kode_opd"];?></td>
      </tr>
      <tr>
        <td>&nbsp;Satuan Kerja </td>
        <td>:</td>
        <td>&nbsp;Rumah Sakit Umum Daerah Ajibarang</td>
      </tr>
      <tr>
        <td>&nbsp;Tahun Anggaran </td>
        <td>:</td>
        <td>&nbsp;<?php print $userdata["tahun_anggaran"];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="3" valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="27%">&nbsp;</td>
        <td width="1%" align="center" valign="top">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Telah diterima dari</td>
        <td align="center" valign="top">:</td>
        <td colspan="2" valign="top">Rumah Sakit Umum Daerah Ajibarang</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Uang sejumlah</td>
        <td align="center" valign="top">:</td>
        <td width="17%" valign="top">&nbsp; Rp. </td>
        <td width="53%" align="right" valign="top"><strong><?php print ''.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?>&nbsp;&nbsp;</strong>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Terbilang</td>
        <td align="center" valign="top">:</td>
        <td colspan="2" valign="top"><?php print terbilang_style($userdata3["JUMLAH_BELANJA"], $style=2); ?></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Yaitu untuk Pembayaran </td>
        <td align="center" valign="top">:</td>
        <td colspan="2" valign="top"><div align="justify"><?php 
			include 'phpcon/koneksi.php';
			$sql= "SELECT * FROM simrs2012.t_sbp_detail where id_sbp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
    		while($data = $result->fetch_assoc()) {
					print getNamaAkun5($data["kd_rekening_belanja"])."<br/>";
					$no_urut++; 
				}
			$conn->close();} 
		?></div></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Kode Sub Kegiatan </td>
        <td align="center" valign="top">:</td>
        <td colspan="2" valign="top"><?php 
			include 'phpcon/koneksi.php';
			$sql= "SELECT * FROM simrs2012.t_sbp_detail where id_sbp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
    		while($data = $result->fetch_assoc()) {
					print $data["sub_kegiatan"]." ".$data["kd_rekening_belanja"]."<br/>";
					$no_urut++; 
				}
			$conn->close();} 
		?></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Nama Sub Kegiatan </td>
        <td align="center" valign="top">:</td>
        <td colspan="2" valign="top"><?php 
			include 'phpcon/koneksi.php';
			$sql= "SELECT * FROM simrs2012.t_sbp_detail where id_sbp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
    		while($data = $result->fetch_assoc()) {
					print getNamaSubKegiatan($data["sub_kegiatan"])."<br/>";
					$no_urut++; 
				}
			$conn->close();} 
		?></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td colspan="2" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Berguna untuk Keperluan </td>
        <td align="center" valign="top">:</td>
        <td colspan="2" valign="top"><?php print $userdata["uraian"];?></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td colspan="2" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td colspan="2" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top">&nbsp;</td>
        <td colspan="2" valign="top">&nbsp;</td>
      </tr>
    </table>
	<br /></td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="4%">&nbsp;</td>
        <td width="62%">&nbsp;</td>
        <td width="34%">&nbsp;</td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Keterangan</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Barang-barang termaksud telah masuk buku persediaan</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="36%">&nbsp;</td>
        <td width="17%" align="left">&nbsp;</td>
        <td width="44%">&nbsp;</td>
        <td width="3%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;Jumlah Kotor </td>
        <td align="left">: Rp. </td>
        <td align="right"><?php print ''.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;Potongan</td>
        <td align="left">: Rp. </td>
        <td align="right"><?php print ''.number_format($userdata4["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;Dibayar</td>
        <td align="left">: Rp. </td>
        <td align="right">
		<?php print ''.number_format($userdata3["JUMLAH_BELANJA"]-$userdata4["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="36%">&nbsp;</td>
        <td width="17%">&nbsp;</td>
        <td width="44%">&nbsp;</td>
        <td width="3%">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;Perincian Potongan:</td>
        </tr>
      <tr>
        <td>&nbsp;PPN</td>
        <td>: Rp. </td>
        <td align="right"><?php print ''.number_format($userdata6["JUMLAH_PAJAK"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;PPh Pasal 22</td>
        <td>: Rp. </td>
        <td align="right"><?php print ''.number_format($userdata5["JUMLAH_PAJAK"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;Yang berhak menerima pembayaran :</td>
        </tr>
      <tr>
        <td width="7%">&nbsp;Nama</td>
        <td width="1%">:</td>
        <td width="58%">&nbsp;<?php print $userdata["nama_penerima"];?></td>
        <td width="34%"><div align="center">Tanda Tangan dan atau cap</div></td>
      </tr>
      <tr>
        <td>&nbsp;Alamat</td>
        <td>:</td>
        <td>&nbsp;<?php print $userdata["alamat_penerima"];?></td>
        <td><div align="center">(terlampir)</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="35%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Diajukan Oleh </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Pejabat Pelaksana Teknis Kegiatan  </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;<br />
      <br /><br /></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><?php print $userdata["nama_pptk"];?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP. <?php print $userdata["nip_pptk"];?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
</table>	</td>
    <td width="27%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Setuju dibayar </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Pengguna Anggaran </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;<br />
      <br /><br /></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><?php print $userdata["nama_pengguna"];?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP. <?php print $userdata["nip_pengguna_anggaran"];?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
</table></td>
    <td width="38%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Yang Membayarkan </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Bendahara Pengeluaran </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;<br />
      <br /><br /></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><?php print $userdata["nama_bendahara_pengeluaran"];?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP. <?php print $userdata["nip_bendahara_pengeluaran"];?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td colspan="3">SIM RSUD AJIBARANG - Modul Keuangan - <?php print $today ; ?></td>
  </tr>
</table>
<br />
</body>
</html>

<?php
$x++;
}

}

//$conn->close();
/*$html = ob_get_clean();
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
//$dompdf->setPaper('F4', 'portrait');
$dompdf->render();
$canvas = $dompdf->get_canvas();
//$dompdf->getCanvas()->page_text(15, 10, "Halaman: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$canvas->page_text(480, 450, "Halaman {PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
$canvas->page_text(12, 450, "SIM RSUD AJIBARANG - Modul Keuangan", $font, 10, array(0,0,0));
$canvas->page_text(43, 770, $date, $font, 10, array(0,0,0));
$dompdf->stream('LaporanAdministrasiPasienRawatInap.pdf',array('Attachment' => 0));*/
?>
