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
		$sql= "SELECT * FROM simrs2012.t_sep where idx = ".$kdspp." limit 1";
		$result = $conn->query($sql);
    	$userdata = $result->fetch_assoc();
		
		
		
		if($userdata["jenis_layanan"]==1)
		{	
		
			print '<h1>RAWAT INAP</h1>';
		
		}elseif($userdata["jenis_layanan"]==2)
		{
		
			print '<h1>RAWAT JALAN</h1>';
			
			if($userdata!=null)
			{
							
				$sql2= "SELECT * FROM simrs2012.t_pendaftaran where IDXDAFTAR =".$kdspp." LIMIT 1";
				$result2 = $conn->query($sql2);
				$userdata2 = $result2->fetch_assoc();
				
				$sql3= "SELECT * FROM m_pasien WHERE NOMR = ".$userdata2["NOMR"]."  LIMIT 1";
				$result3 = $conn->query($sql3);
				$userdata3 = $result3->fetch_assoc();
			}
			
		}
		
		
		$conn->close();
		
		?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>FORM KLAIM 5.2</title>
<style type="text/css">
@page {
  size: 33.0cm 21cm  ;
  margin: 0;
}

body {  
    font-family: 'Courier';
	font-size: 14px;
}

.pagebreak { 
	page-break-before: always; 
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
		<div align="center"><strong>RINCIAN RIIL COST (TARIF RS) INA-CBGs</strong></div></td>
  </tr>
</table>
    <table width="100%" border="0">
  <tr>
    <td width="4%"></td>
    <td width="15%"></td>
    <td width="34%"></td>
    <td width="15%"></td>
    <td width="32%"></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">NAMA</td>
    <td valign="top">:&nbsp;<?php print $userdata3["NAMA"] ?></td>
    <td valign="top">NORM</td>
    <td valign="top">:&nbsp;<?php print $userdata3["NOMR"] ?></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">TGL LAHIR </td>
    <td valign="top">:&nbsp;<?php print $userdata3["TGLLAHIR"] ?></td>
    <td valign="top">JK</td>
    <td valign="top">:&nbsp;<?php print $userdata3["JENISKELAMIN"] ?></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">ALAMAT</td>
    <td valign="top">:&nbsp;<?php print $userdata3["ALAMAT"] ?></td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">RUANG/KELAS</td>
    <td valign="top">:&nbsp;<?php print $userdata3["NAMA"] ?></td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">TANGGAL MASUK </td>
    <td valign="top">:&nbsp;<?php print $userdata3["NAMA"] ?></td>
    <td valign="top">TANGGAL KELUAR </td>
    <td valign="top">:&nbsp;<?php print $userdata3["NAMA"] ?></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">STATUS PASIEN </td>
    <td valign="top">:&nbsp;<?php print $userdata3["NAMA"] ?></td>
    <td valign="top">CARA KELUAR </td>
    <td valign="top">:&nbsp;<?php print $userdata3["NAMA"] ?></td>
    </tr>
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
   <tr>
     <td>&nbsp;</td>
     <td>RINCIAN RIIL COST INA-CBGs</td>
     <td>IGD</td>
     <td>POLIKLINIK</td>
     <td>RANAP 1</td>
     <td>RANAP 2</td>
     <td>RANAP 3</td>
     <td>ICU 1</td>
     <td>ICU 2</td>
     <td>RINCIAN TARIF RS</td>
     </tr>
   <tr>
     <td width="2%">1</td>
     <td width="28%">Prosedur Non Bedah </td>
     <td width="9%">&nbsp;</td>
     <td width="10%">&nbsp;</td>
     <td width="9%">&nbsp;</td>
     <td width="8%">&nbsp;</td>
     <td width="9%">&nbsp;</td>
     <td width="8%">&nbsp;</td>
     <td width="6%">&nbsp;</td>
     <td width="11%">&nbsp;</td>
     </tr>
   <tr>
     <td>2</td>
     <td>Tenaga Ahili </td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>3</td>
     <td>Radiologi</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>4</td>
     <td>Rehabilitasi</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>5</td>
     <td>Obat</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>6</td>
     <td>Sewa Alat </td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>7</td>
     <td>Keperawatan</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>8</td>
     <td>Labpratorium</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>9</td>
     <td>Kamar</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>10</td>
     <td>Akomodasi</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>11</td>
     <td>Alkes</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>12</td>
     <td>Konsultasi</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>13</td>
     <td>Penunjang</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>14</td>
     <td>Pelayanan Darah</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>16</td>
     <td>Rawat Intensif </td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     </tr>
   <tr>
     <td>16</td>
     <td>BMHP</td>
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
<p><br />
</p>
<p>&nbsp; </p>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="48%" align="center">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="39%" align="center" valign="middle">&nbsp;</td>
    <td width="2%" align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" align="center">&nbsp;</td>
    <td height="27">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;<br />
      <br /><br /></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
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
