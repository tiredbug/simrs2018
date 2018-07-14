<?php
//ob_start();
//include '../../include/connect.php';

if (session_id() == "") 
	session_start(); 
	ob_start();
	include_once "ewcfg13.php";
	include_once "phpfn13.php";
	
	
	if (!IsLoggedIn()) {
    echo "Akses ditolak. Silahkan <a href='login.php'>login</a> terlebih dulu!<br>";
} else {


	
	$nomr = $_GET["nomr"];
	$idx = $_GET["idx"];
?>

<html>
<head>
<title>LABEL PASIEN RAWAT INAP</title>

<script src="../JsBarcode-master/dist/JsBarcode.all.js"></script>
	<script>
		Number.prototype.zeroPadding = function(){
			var ret = "" + this.valueOf();
			return ret.length == 1 ? "0" + ret : ret;
		};
	</script>
	
	
	
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
<!-- //../dist/JsBarcode.all.js
@page { margin: 2px; }
body { margin: 2px; }
.style12 {font-size: medium}
</style>

<script>
$(document).ready(function() {
   document.onkeydown = function(e) {
    if(e.keyCode == 123) {
     return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
     return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
     return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
     return false;
    }

    if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
     return false;
    }      
 }
});
</script>
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
      <td align="left" valign="top"><span class="style12"><strong><?php print $data['NAMA'].', '.$data['TITLE']; ?></strong></span></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top" nowrap><span class="style12">Tgl.Lahir </span></td>
      <td align="center" valign="top"  nowrap><span class="style12">:</span></td>
      <td align="left" valign="top"><span class="style12"><strong><?php echo ' '.date("d-m-Y", strtotime($data['TGLLAHIR']));  ?> </strong></span></td>
    </tr>
  
  	<?php 
  $no_urut++; }$conn->close();} else {} //   
  ?>
</table>


</body>
</html>

<?php

}
/*$html = ob_get_clean();


require_once("../../dompdf_baru/dompdf_config.inc.php");
$customPaper = array(0,0,170.078740157,68.031496063);
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper($customPaper);
$dompdf->render();
$dompdf->stream('LABELRAWATINAP_'.
$d['TGLREG'].'_'.
$d['nama'].'_'.'_.pdf',array('Attachment' => 0)); */
?>

















