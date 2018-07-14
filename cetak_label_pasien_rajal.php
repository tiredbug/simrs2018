<?php
if (session_id() == "") 
	session_start(); 
	ob_start();
	include_once "ewcfg13.php";
	include_once "phpfn13.php";
	
	
if (!IsLoggedIn()) {
    echo "Akses ditolak. Silahkan <a href='login.php'>login</a> terlebih dulu!<br>";
} else {
	include 'phpcon/fungsi_col.php';
	$nomr = $_GET["nomr"];
	$idx = $_GET["idx"];
	?>

<html>
<head>
<title>LABEL PASIEN RAWAT INAP</title>
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
@page { margin: 2px; }
body { margin: 2px; }
.style12 {font-size: medium}
</style>
</head>

<body>
<table width="327"  border="0"  cellpadding="0" cellspacing="0" bordercolor="#000000">
<?php

		
		include 'phpcon/koneksi.php';
		$sql= "SELECT NOMR, NAMA,TGLLAHIR FROM simrs2012.m_pasien WHERE NOMR = ".$nomr." LIMIT 1";
		//print $sql;
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
   ?>
    <tr>
      <td align="left" valign="bottom"></td>

      <td align="left" valign="bottom" nowrap></td>
      <td align="center" valign="bottom" nowrap>&nbsp;</td>
      <td align="left" valign="bottom"></td>
    </tr>
    <tr>
      <td width="3%" align="left" valign="bottom">&nbsp;</td>
      <td width="22%" align="left" valign="top"  nowrap><span class="style12">NO. MR</span></td>
      <td width="3%" align="center" valign="top"  nowrap><span class="style12" >:</span></td>
      <td width="72%" align="left" valign="top"><span class="style12"><strong><?php print $data['NOMR']; ?></strong></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle">&nbsp;</td>
      <td align="left" valign="top" nowrap><span class="style12">Nama</span></td>
      <td align="center" valign="top"  nowrap><span class="style12">:</span></td>
      <td align="left" valign="top"><span class="style12"><strong><?php print $data['NAMA'].'  '; ?></strong></span></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" nowrap><span class="style12">Tgl.Lahir </span></td>
      <td align="center" valign="top"  nowrap><span class="style12">:</span></td>
      <td align="left" valign="top"><span class="style12"><strong><?php echo ' '.date("d-m-Y", strtotime($data['TGLLAHIR']));  ?> </strong></span></td>
    </tr>
  
  	<?php 
  $no_urut++; }$conn->close();} else {} 
  ?>
</table>


</body>
</html>

<?php } ?>

















