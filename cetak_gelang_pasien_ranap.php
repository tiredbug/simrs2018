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
	$nomr = $_GET["nomr"];
	$idx = $_GET["idx"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cetak Gelang Pasien</title>
<style>
@page { margin: 1px; }
body { margin: 1px; }

table {
  color: #000;
        font-size: 10px;
        margin: 1px;
        font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
        font-size: 11px;
  }

.tanggal {

}


</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>


<?php
$query= "SELECT NOMR, NAMA,TGLLAHIR FROM simrs2012.m_pasien WHERE NOMR = ".$nomr." LIMIT 1";	
$hasil = $conn->query($query);
$baris = $hasil->fetch_assoc();



?>


<body>
<table width="100%" border="0">
  <tr>
    <td colspan="2" style="
  font-family: calibri;
  color: #000;
  margin: 0;
  padding: 0px 0px 3px 0px;
  font-size: 18px;
  line-height: 13px;
  letter-spacing: 0px;
  font-weight: bold;
    ">
  </td>
  </tr>
  <tr>
    <td colspan="2" style="
  font-family: calibri;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 18px;
  line-height: 10px;
  letter-spacing: 2px;
  font-weight: bold;
    "> NOMR : <?php echo $baris['NOMR']; ?> | TGLLAHIR : <?php echo $baris['TGLLAHIR']; ?>
  </tr>
  <tr>
    <td colspan="2" style="
  font-family: calibri;
  color: #000;
  margin: 0;
  padding: 0px 0px 6px 0px;
  font-size: 18px;
  line-height: 10px;
  letter-spacing: 2px;
  font-weight: bold;
    "> NAMA : <?php echo $baris['NAMA']; ?> 
  </tr>
 
</table>


</body>
</html>

<?php
}

/*
$html = ob_get_clean();
require_once("dompdf_baru/dompdf_config.inc.php");

$customPaper = array(0,0,822.047244094,60.592913386);
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper($customPaper);
$dompdf->render();
$dompdf->stream('gelang_pasien_ranap_'.'_.pdf',array('Attachment' => 0));  */

?>
