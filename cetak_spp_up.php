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
		$sql= "SELECT * FROM simrs2012.t_spp where id = ".$kdspp." limit 1";
		$result = $conn->query($sql);
    	$userdata = $result->fetch_assoc();
		
		
		$kode_spd = $userdata["id_spd"];
		$sql2= "SELECT * FROM simrs2012.t_spd where id = ".$kode_spd." limit 1";
		$result2 = $conn->query($sql2);
    	$userdata2 = $result2->fetch_assoc();
		
		
		//$kode_spd = $userdata["id_spd"];
		$sql3= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$userdata["id"]."  limit 1";
		//print $sql3;
		$result3 = $conn->query($sql3);
    	$userdata3 = $result3->fetch_assoc();
		
		// TOTAL UP
		$sql4= "SELECT ifnull(SUM(jumlah_belanja),0) as 'totalUP' FROM simrs2012.t_spp_detail   where id_spp = ".$userdata["id"]." ";
		$result4 = $conn->query($sql4);
    	$userdata4 = $result4->fetch_assoc();
		
		
		
		/*print '<pre>';
		print_r($userdata3);
		print '</pre>';*/
		$conn->close();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SPP UP</title>
<style type="text/css">
@page {
  size: 21cm 33.0cm ;
  margin: 0;
}

body {  
    font-family: 'Courier';
	font-size: 12px;
}

</style>
</head>
<body onload="window.print();">
<!--<body onload="window.print();">
<body>-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1%">&nbsp;</td>
    <td width="98%">&nbsp;</td>
    <td width="1%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>

	<table width="100%" border="0">
  <tr>
    <td>
		<div align="center"><strong>PEMERINTAH KABUPATEN BANYUMAS
		    <br/>
		    RUMAH SAKIT UMUM DAERAH AJIBARANG<br/>
		SURAT PERMINTAAN PEMBAYARAN UANG PERSEDIAAN 
		<br />
		(SPP-UP)<br />
		NOMER : <?php print $userdata["no_spp"]; ?>    </strong></div></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td>Kepada Yth. <br />Pemimpin BLUD<br />Rumah Sakit Umum Daerah Ajibarang<br />di Tempat</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
	
	
		<table width="100%" border="0">
  <tr>
    <td><div align="justify">Dengan memperhatikan Peraturan Bupati Banyumas Nomor 68 Tahun 2017 tentang Penjabaran Perubahan APBD Kabupaten Banyumas Tahun Anggaran 2017, bersama ini kami mengajukan Surat Permintaan Pembayaran Uang Persediaan (SPP-UP) sebagai berikut:</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="2%"></td>
    <td width="1%"></td>
    <td width="30%"></td>
    <td width="1%"></td>
    <td width="66%"></td>
  </tr>
  <tr>
    <td valign="top">a)</td>
    <td valign="top">.</td>
    <td valign="top">Urusan Pemerintahan</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;1.02&nbsp;Kesehatan</td>
  </tr>
  <tr>
    <td valign="top">b)</td>
    <td valign="top">.</td>
    <td valign="top">OPD</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;1.02.03.001&nbsp;Rumah Sakit Umum Daerah Ajibarang</td>
  </tr>
  <tr>
    <td valign="top">c)</td>
    <td valign="top">.</td>
    <td valign="top">Tahun Anggaran</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;<?php print $userdata["tahun_anggaran"]; ?></td>
  </tr>
  <tr>
    <td valign="top">d)</td>
    <td valign="top">.</td>
    <td valign="top">Dasar SPD Nomer &amp; Tanggal </td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;<?php print $userdata["nomer_dasar_spd"]; ?>, Tanggal : 
	<?php print date("d-m-Y", strtotime($userdata["tanggal_spd"])); ?>  </td>
  </tr>
  <tr>
    <td valign="top">e)</td>
    <td valign="top">.</td>
    <td valign="top">Jumlah SPD</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;<?php print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").'' ?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">(<?php print terbilang_style($userdata["jumlah_spd"],$style=1).' ' ?>)</td>
  </tr>
  <tr>
    <td valign="top">f)</td>
    <td valign="top">.</td>
    <td valign="top">Nama Bendahara Pengeluaran</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;RISTANTI</td>
  </tr>
  <tr>
    <td valign="top">g)</td>
    <td valign="top">.</td>
    <td valign="top">Jumlah Pembayaran yang Diminta</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;<?php print 'Rp.'.number_format($userdata3["jumlah_belanja"] ,0,",",".").'' ?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;(<?php print terbilang_style($userdata3["jumlah_belanja"],$style=1).' ' ?>)</td>
  </tr>
</table>

<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><strong>RINGKASAN</strong></td>
  </tr>
  <tr>
    <td><div >
      <p>Berdasarkan Keputusan Direktur Selaku Pemimpin BLUD Nomor <?php print $userdata2["no_sk_dir"]; ?> TAHUN <?php print $userdata["tahun_anggaran"]; ?>  tanggal <?php print date("d-m-Y", strtotime($userdata2["tgl_sk_dir"])); ?>  tentang <?php print $userdata2["tentang"]; ?>  sejumlah <?php print 'Rp.'.number_format($userdata3["jumlah_belanja"] ,0,",",".").'' ?> (<?php print terbilang_style($userdata3["jumlah_belanja"],$style=1).' ' ?>)
        :</p>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th colspan="4" align="center" valign="middle" scope="col">RINCIAN RENCANA PENGGUNAAN </th>
  </tr>
   <tr align="center" valign="middle">
    <th width="3%"  scope="col">No</th>
    <th width="18%"  scope="col">Kode Rekening </th>
    <th width="47%"  scope="col">Uraian</th>
    <th width="32%" scope="col">Nilai (Rp) </th>
  </tr>
   <!-- <tr>
     <td align="center"><br /><br />&nbsp;<?php print 1; ?><br /><br /><br /><br /><br /><br /></td>
     <td align="center"><br /><br />&nbsp;<?php print $userdata3["kd_rekening_belanja"]; ?><br /><br /><br /><br /><br /><br /></td>
     <td><br /><br />&nbsp;<?php print getNamaAkun5($userdata3["kd_rekening_belanja"]); ?><br /><br /><br /><br /><br /><br /></td>
     <td align="center"><br /><br />&nbsp;<?php print ''.number_format($userdata3["jumlah_belanja"] ,0,",",".").'' ?><br /><br /><br /><br /><br /><br /></td>
   </tr> -->
   <tr>
     <td align="center">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td>&nbsp;</td>
         </tr>
        	  <?php
			include 'phpcon/koneksi.php';
			$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			while($data = $result->fetch_assoc()) {
	?>
		  <tr>
			<td align="center"><?php print $no_urut; ?></td>
		  </tr>
		  
		   <?php 
			$no_urut++; }$conn->close();}   
			?>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
     <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td>&nbsp;</td>
         </tr>
         <?php
			include 'phpcon/koneksi.php';
			$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			while($data = $result->fetch_assoc()) {
	?>
		  <tr>
			<td align="center"><?php print $data["kd_rekening_belanja"]; ?></td>
		  </tr>
		  
		   <?php 
			$no_urut++; }$conn->close();}   
			?>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
     <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td>&nbsp;</td>
         </tr>
        <?php
			include 'phpcon/koneksi.php';
			$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			while($data = $result->fetch_assoc()) {
	?>
		  <tr>
			<td align="center"><?php print getNamaAkun5($data["kd_rekening_belanja"]); ?></td>
		  </tr>
		  
		   <?php 
			$no_urut++; }$conn->close();}   
			?>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
     <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td>&nbsp;</td>
         </tr>
         <?php
			include 'phpcon/koneksi.php';
			$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			while($data = $result->fetch_assoc()) {
	?>
		  <tr>
			<td align="center"><?php print ''.number_format($data["jumlah_belanja"] ,0,",",".").'' ?></td>
		  </tr>
		  
		   <?php 
			$no_urut++; }$conn->close();}   
			?>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td>&nbsp;</td>
         </tr>
       </table></td>
   </tr>
  <tr>
    <td colspan="3" align="right" valign="middle">JUMLAH&nbsp;</td>
    <td align="center">&nbsp;<?php print 'Rp.'.number_format($userdata4["totalUP"] ,0,",",".").'' ?></td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle"><strong>&nbsp;Terbilang : <?php print terbilang_style($userdata4["totalUP"],$style=1).' ' ?></strong></td>
  </tr>
</table>
<br />

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="55%">&nbsp;</td>
    <td width="42%" align="center" valign="middle">Ajibarang, <?php echo $today; ?>  </td>
    <td width="3%" align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Bendahara Pengeluaran </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="27">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;<br />
      <br /><br /></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><?php print $userdata["nama_bendahara"]; ?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP. <?php   print $userdata["nip_bendahara"]; ?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
</table>
	
	
	
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<br />








</body>
</html>

<?php
	
	}
?>

<?php
//$conn->close();
//$html = ob_get_clean();
//require_once 'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//use Dompdf\Options;
//$options = new Options();
//$options->set('defaultFont', 'Courier');
//$options->set('isJavascriptEnabled', TRUE);
//$dompdf = new Dompdf($options);
//$dompdf->set_option('chroot', __DIR__);
//$dompdf->set_option('enable_font_subsetting', true);
//$dompdf->set_option('isHtml5ParserEnabled', true);
//$dompdf->set_option('isJavascriptEnabled', true);
//$dompdf->set_option('enable_remote', TRUE);
//$dompdf->set_option('enable_css_float', TRUE);
//$dompdf->load_html($html);
//$dompdf->setPaper('F4', 'portrait');
//$dompdf->render();
//$canvas = $dompdf->get_canvas();
//$dompdf->getCanvas()->page_text(15, 10, "Halaman: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

//$canvas->page_text(480, 900, "Halaman {PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
//$canvas->page_text(12, 900, "SIM RSUD AJIBARANG - Modul Keuangan", $font, 10, array(0,0,0));
//$canvas->page_text(43, 770, $date, $font, 10, array(0,0,0));
//$dompdf->stream('LaporanAdministrasiPasienRawatInap.pdf',array('Attachment' => 0)); 
?>
