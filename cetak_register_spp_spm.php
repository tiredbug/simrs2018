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

		/*$kdspp = htmlspecialchars($_GET["kdspp"]);
		$sql= "SELECT * FROM simrs2012.t_spp where id = ".$kdspp." limit 1";
		$result = $conn->query($sql);
    	$userdata = $result->fetch_assoc();
		
		
		$kode_spd = $userdata["id_spd"];
		$sql2= "SELECT * FROM simrs2012.t_spd where id = ".$kode_spd." limit 1";
		$result2 = $conn->query($sql2);
    	$userdata2 = $result2->fetch_assoc();*/

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
	font-size: 14px;
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
		REGISTER SPP - SPM <br />
		TAHUN ANGGARAN : <?php print $userdata["no_spp"]; ?>    </strong></div></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="78%" align="right">Bulan : </td>
    <td width="22%">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
	
	
		<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th colspan="4" align="center" valign="middle" scope="col">SPP </th>
    <th colspan="2" align="center" valign="middle" scope="col">SPM</th>
    </tr>
   <tr align="center" valign="middle">
    <th width="3%"  scope="col">No</th>
    <th width="18%"  scope="col">Tanggal</th>
    <th width="47%"  scope="col">Nomer</th>
    <th width="32%" scope="col">Jumlah</th>
    <th width="32%" scope="col">Tanggal</th>
    <th width="32%" scope="col">Nomer</th>
   </tr>
   <tr>
     <td align="center"><br /><br />&nbsp;<br /><br /><br /><br /><br /><br /></td>
     <td align="center"><br /><br />&nbsp;<br /><br /><br /><br /><br /><br /></td>
     <td><br /><br />&nbsp;<br /><br /><br /><br /><br /><br /></td>
     <td align="center"><br /><br />&nbsp;<br /><br /><br /><br /><br /><br /></td>
     <td align="center">&nbsp;</td>
     <td align="center">&nbsp;</td>
   </tr>
  <tr>
    <td colspan="3" align="right" valign="middle"><strong>JUMLAH</strong>&nbsp;</td>
    <td colspan="3" align="center">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="6" align="left" valign="middle"><strong>&nbsp;Terbilang : </strong></td>
  </tr>
</table>
<br />

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="69%">&nbsp;</td>
    <td width="26%" align="center" valign="middle">Ajibarang, <?php echo $today; ?>  </td>
    <td width="5%" align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Pimpinan BLUD  </td>
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
	$conn->close();
	}
?>
