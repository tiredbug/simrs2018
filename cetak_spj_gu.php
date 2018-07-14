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


		//MASTER SPJ
		$kdspp = htmlspecialchars($_GET["kdspp"]);
		$sql= "SELECT * FROM simrs2012.t_spj where id = ".$kdspp." limit 1";
		$result = $conn->query($sql);
    	$userdata = $result->fetch_assoc();
		
	
		
		// DETAIL SPJ
		//$kdspp = htmlspecialchars($_GET["kdspp"]);
		$sql2= "SELECT * FROM simrs2012.detail_spj WHERE id_spj = ".$userdata["id"];
		$result2 = $conn->query($sql2);
    	$userdata2 = $result2->fetch_assoc();

	/*	print '<pre>';
		print_r($userdata2);
		print '</pre>';
		*/
				//data SPP
		$sql3= "SELECT * FROM m_blud_rs where id = 1";
		$result3 = $conn->query($sql3);
    	$userdata3 = $result3->fetch_assoc();
		
		
		
			/*
		// jumlah komulatif Pajak
		$sql4= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja LIKE '7%'";
		$result4 = $conn->query($sql4);
    	$userdata4 = $result4->fetch_assoc();*/
		
		
		$conn->close();
	}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SPJ GU</title>
<style type="text/css">
@page {
  size:  33.0cm 21cm ;
  margin: 0;
}

body {  
    font-family: 'Courier';
	font-size: 12px;
}
.style2 {font-size: 10}
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
		DAFTAR BUKTI PENGELUARAN UNTUK PENGAJUAN SPP-GU <br />
		Tahun Anggaran:&nbsp;<?php print $userdata["tahun_anggaran"]; ?>&nbsp;</strong></div></td>
  </tr>
</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>
        <td width="11%">Kode Sub Kegiatan </td>
        <td width="1%">:</td>
        <td width="32%">&nbsp;<?php print $userdata["sub_kegiatan"]; ?></td>
        <td width="27%">&nbsp;</td>
        <td width="7%">Nomor</td>
        <td width="1%">:</td>
        <td width="21%">&nbsp;<?php print $userdata["no_spj"]; ?></td>
      </tr>
      <tr>
        <td>Sub Kegiatan </td>
        <td>:</td>
        <td><?php print getNamaSubKegiatan($userdata["sub_kegiatan"]); ?></td>
        <td>&nbsp;</td>
        <td>Tanggal</td>
        <td>&nbsp;</td>
        <td>&nbsp;<?php print date("d-m-Y", strtotime($userdata["tgl_spj"])); ?></td>
      </tr>
      <tr>
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
      </tr>
    </table>
    <br />
		<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <th scope="col">No</th>
            <th scope="col">Tanggal</th>
            <th width="22%" scope="col">Nomer</th>
            <th width="13%" scope="col">Kode Rekening </th>
            <th width="29%" scope="col">Uraian </th>
            <th width="12%" scope="col">Jumlah</th>
            <th width="12%" scope="col">PAJAK</th>
          </tr>
		  <?php		
		  			$a ;
		  			if (isset($userdata2["id_sbp"]))//(isset(!$userdata2["id_sbp"])
					{
						$a = $userdata2["id_sbp"];
					}else
					{
						$a = 0;
					}
					
					
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.detail_spj where id_sbp = ".$a."";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
          <tr>
            <td width="2%" align="center"><span class="style2">&nbsp;<?php print $no_urut; ?></span></td>
            <td width="10%" align="center"><span class="style2">
			<?php print date("d-m-Y", strtotime($data["tgl_spj"]));?></span></td>
            <th width="22%" scope="col"><span class="style2">&nbsp;<?php print $data["no_sbp"]; ?></span></th>
            <th width="13%" scope="col"><span class="style2">
			
			 <?php
					$sql2= "SELECT * FROM simrs2012.t_sbp_detail where id_sbp = ".$userdata2["id_sbp"]." and kd_rekening_belanja LIKE '5%'";
					$no_urut2=1;
					$result2 = $conn->query($sql2);
					if ($result2->num_rows > 0) {
					while($data2 = $result2->fetch_assoc()) {
					print $data2["kd_rekening_belanja"]."</br>";
					$no_urut2++; }
					}  
			?>			</th>
            <th width="29%" scope="col"><span class="style2">
			 <?php
					$sql2= "SELECT * FROM simrs2012.t_sbp_detail where id_sbp = ".$userdata2["id_sbp"]." and kd_rekening_belanja LIKE '5%'";
					$no_urut2=1;
					$result2 = $conn->query($sql2);
					if ($result2->num_rows > 0) {
					while($data2 = $result2->fetch_assoc()) {
					print getNamaAkun5($data2["kd_rekening_belanja"])."</br>";
					$no_urut2++; }
					}  
			?>
			</span></th>
            <th width="12%" scope="col"><span class="style2">&nbsp;<?php print $data["jumlah_belanja"]; ?></span></th>
            <th width="12%" scope="col"><span class="style2">&nbsp;<?php print $data["pajak"]; ?></span></th>
          </tr>
		  <?php 
  			$no_urut++; }$conn->close();}  
		?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		<br />

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="68%">&nbsp;</td>
    <td width="27%" align="center" valign="middle"><strong>Ajibarang, </strong></td>
    <td width="5%" align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><strong>Pemimpin BLUD </strong></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="27">&nbsp;</td>
    <td align="center" valign="middle"><strong>&nbsp;<br />
        <br />
        <br />
    </strong></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><strong><?php print $userdata3["direktur"]; ?></strong></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP. 
        <?php   print  $userdata3["nip"]; ?>    </td>
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
/*	$conn->close();
	}*/
?>
