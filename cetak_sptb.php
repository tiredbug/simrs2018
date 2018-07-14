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
		
		
				//jumlah belanja
		$sql3= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja LIKE '5%'";
		$result3 = $conn->query($sql3);
    	$userdata3 = $result3->fetch_assoc();
		
		
		
			
		// jumlah komulatif Pajak
		$sql4= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja LIKE '7%'";
		$result4 = $conn->query($sql4);
    	$userdata4 = $result4->fetch_assoc();
		
		
		$conn->close();
	}

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
	font-size: 9px;
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
		SURAT PERNYATAAN PERTANGGUNG JAWABAN <br />
		Nomor :&nbsp;<?php print $userdata["no_sptb"]; ?>&nbsp;&nbsp;&nbsp; Tanggal :&nbsp;
		<?php print date("d-m-Y", strtotime($userdata["tgl_sptb"])); ?> </strong></div></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="18%" align="right">&nbsp;</td>
    <td width="1%" align="right">&nbsp;</td>
    <td width="77%" align="right">&nbsp;</td>
    <td width="4%">&nbsp;</td>
  </tr>
  
  <tr>
    <td>Kode Kegiatan </td>
    <td>:</td>
    <td><?php print $userdata["kode_kegiatan"]; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Kegiatan </td>
    <td>:</td>
    <td><?php print getNamaKegiatan($userdata["kode_kegiatan"]); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kode Sub Kegiatan </td>
    <td>:</td>
    <td><?php print $userdata["kode_sub_kegiatan"]; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Sub Kegiatan </td>
    <td>:</td>
    <td><?php print getNamaSubKegiatan($userdata["kode_sub_kegiatan"]); ?></td>
    <td>&nbsp;</td>
  </tr>
</table>
	
	
		<br />
		<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <th colspan="2" scope="col">Bukti</th>
            <th width="14%" rowspan="2" scope="col">Kode Rekening </th>
            <th width="23%" rowspan="2" scope="col">Uraian</th>
            <th width="15%" rowspan="2" scope="col">Jumlah</th>
            <th width="13%" rowspan="2" scope="col">Potongan Pajak </th>
          </tr>
          <tr>
            <td width="12%" align="center"><strong>Tanggal</strong></td>
            <td width="23%" align="center"><strong>Nomor</strong></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">&nbsp;</th>
              </tr>
               <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT b.no_spm,b.tgl_spm ,a.* FROM t_spp_detail a 
LEFT OUTER JOIN t_spp b ON (b.id = a.id_spp)
where a.id_spp = ".$kdspp." and a.kd_rekening_belanja LIKE '5%'";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
				  <tr>
					<td align="center"><?php print date("d-m-Y", strtotime($data["tgl_spm"])); ?> </td>
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
              <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT b.no_spm,b.tgl_spm ,a.* FROM t_spp_detail a 
LEFT OUTER JOIN t_spp b ON (b.id = a.id_spp)
where a.id_spp = ".$kdspp." and a.kd_rekening_belanja LIKE '7%'";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
				  <tr>
					<td align="center"><?php print date("d-m-Y", strtotime($data["tgl_spm"])); ?></td>
				  </tr>
				  <?php 
					$no_urut++; }$conn->close();}   
					?>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">&nbsp;</th>
              </tr>
               <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT b.no_spm,b.tgl_spm ,a.* FROM t_spp_detail a 
LEFT OUTER JOIN t_spp b ON (b.id = a.id_spp)
where a.id_spp = ".$kdspp." and a.kd_rekening_belanja LIKE '5%'";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
				  <tr>
					<td align="center"><?php print $data["no_spm"]; ?></td>
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
               <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT b.no_spm,b.tgl_spm ,a.* FROM t_spp_detail a 
LEFT OUTER JOIN t_spp b ON (b.id = a.id_spp)
where a.id_spp = ".$kdspp." and a.kd_rekening_belanja LIKE '7%'";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
				  <tr>
					<td align="center"><?php print $data["no_spm"]; ?></td>
				  </tr>
				  <?php 
					$no_urut++; }$conn->close();}   
					?>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">&nbsp;</th>
              </tr>
            
               <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '5%' ORDER BY kd_rekening_belanja ASC";
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
			  <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '7%' ORDER BY kd_rekening_belanja ASC";
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
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">&nbsp;</th>
              </tr>
              <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '5%' ORDER BY kd_rekening_belanja ASC";
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
             <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '7%' ORDER BY kd_rekening_belanja ASC";
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
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">&nbsp;</th>
              </tr>
               <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '5%' ORDER BY kd_rekening_belanja ASC";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
				  <tr>
					<td align="center">
					<?php print ''.number_format($data["jumlah_belanja"] ,0,",",".").''; ?></td>
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
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <th scope="col">&nbsp;</th>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <?php
					include 'phpcon/koneksi.php';
					$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '7%' ORDER BY kd_rekening_belanja ASC";
					$no_urut=1;
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
					while($data = $result->fetch_assoc()) {
			?>
				  <tr>
					<td align="center"><?php print ''.number_format($data["jumlah_belanja"] ,0,",",".").''; ?></td>
				  </tr>
				  <?php 
					$no_urut++; }$conn->close();}   
					?>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>

          <tr>
            <td colspan="4" align="right">Jumlah Bukti Pengeluaran&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td align="center"><?php print ''.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
            <td align="center"><?php print ''.number_format($userdata4["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
          </tr>
        </table>
		<br />

<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="68%">&nbsp;</td>
    <td width="27%" align="center" valign="middle">&nbsp;</td>
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
    <td align="center" valign="middle"><strong><?php print $userdata["pimpinan_blud"]; ?></strong></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP. 
        <?php   print $userdata["nip_pimpinan"]; ?>    </td>
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
