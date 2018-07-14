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
		$sql= "SELECT * FROM simrs2012.t_advis_spm where id = ".$kdspp." limit 1";
		$result = $conn->query($sql);
    	$userdata = $result->fetch_assoc();

		
		
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
<title>ADVIS SPM</title>
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
		ADVIS SURAT PERINTAH MEMBAYAR (SPM) <br />
		Nomor :&nbsp;<?php print $userdata["kode_advis"]; ?>&nbsp;</strong></div></td>
  </tr>
</table>
    <br />
		<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <th scope="col">No</th>
            <th scope="col">NO SP2D </th>
            <th width="16%" scope="col">REKANAN</th>
            <th width="19%" scope="col">NAMA BANK </th>
            <th width="12%" scope="col">NOMER REKENING </th>
            <th width="10%" scope="col">BRUTO</th>
            <th width="10%" scope="col">PAJAK</th>
            <th width="11%" scope="col">NETTO</th>
          </tr>
		  <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.t_advis_spm_detail where id_advis = ".$userdata["id"]."";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
          <tr>
            <td width="4%" align="center"><span class="style2">&nbsp;<?php print $no_urut; ?></span></td>
            <td width="18%" align="center"><span class="style2">&nbsp;<?php print $data["no_spm"]; ?></span></td>
            <th width="16%" scope="col"><span class="style2">&nbsp;<?php print $data["nama_rekanan"]; ?></span></th>
            <th width="19%" scope="col"><span class="style2">&nbsp;<?php print $data["nama_bank"]; ?></span></th>
            <th width="12%" scope="col"><span class="style2">&nbsp;<?php print $data["nomer_rekening"]; ?></span></th>
            <th width="10%" scope="col"><span class="style2">&nbsp;<?php print $data["bruto"]; ?></span></th>
            <th width="10%" scope="col"><span class="style2">&nbsp;<?php print $data["pajak"]; ?></span></th>
            <th width="11%" scope="col"><span class="style2">&nbsp;<?php print $data["netto"]; ?></span></th>
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
