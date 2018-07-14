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
	$tgl = $_GET["tgl"];
	$poli = $_GET["poli"];
		?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CETAK SENSUS HARIAN RAWAT JALAN</title>
		<title>CETAK SENSUS HARIAN RAWAT JALAN</title>
		<style type="text/css">
		@page {
		  size: 33.0cm 21cm ;
		  margin: 0;
		}
		
		body {  
			font-family: 'Courier';
			font-size: 10px;
		}
		
		</style>
</head>
<body onload="window.print();">
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th scope="col">No &nbsp;</th>
    <th scope="col">Tanggal&nbsp;</th>
    <th scope="col">NO SEP </th>
    <th scope="col">NOMR</th>
    <th scope="col">NAMA</th>
    <th scope="col">CARA BAYAR </th>
    <th scope="col">JK</th>
    <th scope="col">POLI</th>
    <th scope="col">DOKTER</th>
    <th scope="col">RANAP</th>
    <th scope="col">PULANG</th>
  </tr>
   <?php 
			include 'phpcon/koneksi.php'; // onload="window.print();"
			$sql= "SELECT a.NOMR,
a.TGLREG,
b.NAMADOKTER,
c.nama,
d.NAMA as 'rujukan',
e.NAMA as 'CARABAYAR',
a.SHIFT,
f.pasienbaru,
g.NAMA,
g.ALAMAT,
g.JENISKELAMIN,
a.KETRUJUK,
a.NO_SJP
FROM vw_sensus_harian_rawat_jalan a 
LEFT OUTER JOIN m_dokter b ON (a.KDDOKTER = b.KDDOKTER)
LEFT OUTER JOIN m_poly c ON (a.KDPOLY = c.kode)
LEFT OUTER JOIN m_rujukan d ON (a.KDRUJUK= d.KODE)
LEFT OUTER JOIN m_carabayar e ON (a.KDCARABAYAR = e.KODE)
LEFT OUTER JOIN l_pasienbaru f ON (a.PASIENBARU=f.id)
LEFT OUTER JOIN m_pasien g ON (a.NOMR = g.NOMR)
where a.TGLREG = '$tgl' AND a.KDPOLY = $poli
group by NOMR ORDER BY g.NAMA ASC";
			//print $sql;
			$no_urut=1;
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
			while($data = $result->fetch_assoc()) {
		  ?>
  <tr>
    <td><?php print $no_urut; ?></td>
    <td><?php print $data['TGLREG']; ?></td>
    <td><?php print $data['NO_SJP']; ?></td>
    <td><?php print $data['NOMR']; ?></td>
    <td><?php print $data['NAMA']; ?></td>
    <td><?php print $data['CARABAYAR']; ?></td>
    <td><?php print $data['JENISKELAMIN']; ?></td>
    <td><?php print $data['nama']; ?></td>
    <td><?php print $data['NAMADOKTER']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <?php 
  $no_urut++; }$conn->close();} else {} 
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td bordercolor="#000000">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</body>
</html>

<?php
	}
?>
