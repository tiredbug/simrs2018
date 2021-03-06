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
		
		/*
		$kode_spd = $userdata["id_spd"];
		$sql2= "SELECT * FROM simrs2012.t_spd where id = ".$kode_spd." limit 1";
		$result2 = $conn->query($sql2);
    	$userdata2 = $result2->fetch_assoc();*/
		
		$sql3= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja NOT LIKE '7%'";
		$result3 = $conn->query($sql3);
    	$userdata3 = $result3->fetch_assoc();
		
		/*echo '<pre>';
		print_r($userdata3);
		echo '</pre>';*/
		$conn->close();
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SPM</title>
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
		SURAT PERMINTAAN PEMBAYARAN - PENGEMBALIAN PENERIMAAN KAS BLUD <br />(SPP-PP)<br />
		TAHUN ANGGARAN :     <?php  print $userdata["tahun_anggaran"];?></strong></div></td>
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
    <td><div align="justify">Dengan memperhatikan Peraturan Bupati Banyumas Nomor: Tahun 2017 tentang Penjabaran Perubahan APBD Kabupaten Banyumas Tahun Anggaran 2018, bersama ini kami mengajukan Surat Permintaan Pembayaran Uang Persediaan (SPP-UP) sebagai berikut:</div></td>
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
    <td valign="top"><?php  print $userdata["urusan_pemerintahan"];?>&nbsp;Kesehatan</td>
  </tr>
  <tr>
    <td valign="top">b)</td>
    <td valign="top">.</td>
    <td valign="top">OPD</td>
    <td valign="top">:</td>
    <td valign="top"><?php  print $userdata["opd"];?>&nbsp;Rumah Sakit Umum Daerah Ajibarang</td>
  </tr>
  <tr>
    <td valign="top">c)</td>
    <td valign="top">.</td>
    <td valign="top">Tahun Anggaran</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;<?php  print $userdata["tahun_anggaran"];?></td>
  </tr>
  <tr>
    <td valign="top">d)</td>
    <td valign="top">.</td>
    <td valign="top">Dasar SPD Nomer &amp; Tanggal </td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;
      <?php  print $userdata["nomer_dasar_spd"];?>
      , Tanggal :	   <?php print date("d-m-Y", strtotime($userdata["tanggal_spd"]));?></td>
  </tr>
  <tr>
    <td valign="top">e)</td>
    <td valign="top">.</td>
    <td valign="top">Jumlah SPD</td>
    <td valign="top">:</td>
    <td valign="top"><?php print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").''; ?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">(
  
	  <?php print terbilang_style($userdata["jumlah_spd"], $style=2); ?>      )</td>
  </tr>
  <tr>
    <td valign="top">f)</td>
    <td valign="top">.</td>
    <td valign="top">Nama Bendahara Pengeluaran</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;<?php  print $userdata["nama_bendahara"];?></td>
  </tr>
  <tr>
    <td valign="top">g)</td>
    <td valign="top">.</td>
    <td valign="top">Jumlah Pembayaran yang Diminta</td>
    <td valign="top">:</td>
    <td valign="top">&nbsp;<?php print 'Rp.'.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;(<?php print terbilang_style($userdata3["JUMLAH_BELANJA"], $style=2); ?>)</td>
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
    <td><div align="justify">
      <p>Berdasarkan Keputusan Direktur Selaku Pemimpin BLUD Nomor 
        <?php  print $userdata["nomer_dasar_spd"];?> 
        TAHUN 
        <?php  print $userdata["tanggal_spd"];?>  
        tanggal   tentang SURAT PERMINTAAN PEMBAYARAN - PENGEMBALIAN PENERIMAAN KAS BLUD   sejumlah <?php print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").''; ?> (<?php print terbilang_style($userdata["jumlah_spd"], $style=2); ?>)
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
   <tr>
     <td align="center"><br /><br /> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php
				include 'phpcon/koneksi.php';
				$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
				$no_urut=1;
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				while($data = $result->fetch_assoc()) {
		?>
		 <tr>
           <td>&nbsp;<?php print $no_urut; ?></td>
         </tr>
		   <?php 
  		$no_urut++; }$conn->close();}   
  		?>
       </table><br /><br /></td>
     <td align="center"><br /><br /><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php
				include 'phpcon/koneksi.php';
				$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
				$no_urut=1;
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				while($data = $result->fetch_assoc()) {
		?>
		 <tr>
           <td>&nbsp;<?php print $data["kd_rekening_belanja"]; ?></td>
         </tr>
		   <?php 
  		$no_urut++; }$conn->close();}   
  		?>
       </table><br /><br /></td>
     <td><br /><br /><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php
				include 'phpcon/koneksi.php';
				$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
				$no_urut=1;
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				while($data = $result->fetch_assoc()) {
		?>
		 <tr>
           <td>&nbsp;<?php print getNamaAkun5($data["kd_rekening_belanja"]); ?></td>
         </tr>
		   <?php 
  		$no_urut++; }$conn->close();}   
  		?>
       </table><br /><br /></td>
     <td align="center"><br /><br /><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <?php
				include 'phpcon/koneksi.php';
				$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." ";
				$no_urut=1;
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				while($data = $result->fetch_assoc()) {
		?>
		 <tr>
           <td>&nbsp;<?php print ''.number_format($data["jumlah_belanja"] ,0,",",".").''; ?></td>
         </tr>
		   <?php 
  		$no_urut++; }$conn->close();}   
  		?>
       </table><br /><br /></td>
   </tr>
  <tr>
    <td colspan="3" align="right" valign="middle">JUMLAH&nbsp;</td>
    <td align="center"><?php print ''.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle"><strong>&nbsp;Terbilang : <?php print terbilang_style($userdata3["JUMLAH_BELANJA"], $style=2); ?></strong></td>
  </tr>
</table>
<br />

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="62%">&nbsp;</td>
    <td width="35%" align="center" valign="middle">Ajibarang,   <?php echo $today; ?></td>
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
    <td align="center" valign="middle">&nbsp;<?php  print $userdata["nama_bendahara"];?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP.<?php  print $userdata["nip_bendahara"];?></td>
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
