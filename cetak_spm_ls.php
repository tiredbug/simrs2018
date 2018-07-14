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
		$sql= "SELECT * FROM t_spp where id = ".$kdspp." limit 1";
		$result = $conn->query($sql);
    	$userdata = $result->fetch_assoc();
		
		/*print '<pre>';
		print_r($userdata);
		print '</pre>';*/
		
		
		$kode_spd = $userdata["kontrak_id"];
		$sql2= "SELECT * FROM simrs2012.data_kontrak where id = ".$kode_spd." limit 1";
		$result2 = $conn->query($sql2);
    	$userdata2 = $result2->fetch_assoc();
		
		
		
			//jumlah belanja
		$sql3= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja LIKE '5%'";
		$result3 = $conn->query($sql3);
    	$userdata3 = $result3->fetch_assoc();
		
		
		
			
		// jumlah komulatif Pajak
		$sql4= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja LIKE '7%'";
		$result4 = $conn->query($sql4);
    	$userdata4 = $result4->fetch_assoc();
		
		// jumlah komulatif Pajak PPN PUSAT
		$sql5= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.05.01'";
		$result5 = $conn->query($sql5);
    	$userdata5 = $result5->fetch_assoc();
		
		
		// jumlah komulatif Pajak PPh 21
		$sql6= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.01'";
		$result6 = $conn->query($sql6);
    	$userdata6 = $result6->fetch_assoc();
		
		// jumlah komulatif Pajak PPh 22
		$sql7= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.02'";
		$result7 = $conn->query($sql7);
    	$userdata7 = $result7->fetch_assoc();
		
		// jumlah komulatif Pajak PPh 23
		$sql8= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.03'";
		$result8 = $conn->query($sql8);
    	$userdata8 = $result8->fetch_assoc();
		
			// jumlah komulatif Pajak PPh 4(2)
		$sql9= "SELECT SUM(jumlah_belanja) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.05'";
		$result9 = $conn->query($sql9);
    	$userdata9 = $result9->fetch_assoc();
		
		
		
		$conn->close();
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SPM </title>
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
<br/>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td colspan="4">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="20%" height="104" scope="col"><img src="logo banyumas.png" width="110" height="90" /></th>
          <th width="55%" scope="col"><br /> 
		pPEMERINTAH KABUPATEN BANYUMAS
		  <br/>
		    RUMAH SAKIT UMUM DAERAH AJIBARANG<br/>
		SURAT PERINTAH MEMBAYAR (SPM)
		<br />
	TAHUN ANGGARAN : <?php print $userdata["tahun_anggaran"];?> <br /> 
	<br />  </th>
          <th width="25%" scope="col"></th>
        </tr>
      </table>	</td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3%">&nbsp;</td>
        <td width="23%">&nbsp;</td>
        <td width="6%">&nbsp;</td>
        <td width="68%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>No SPP </td>
        <td>:</td>
        <td><?php print $userdata["no_spp"];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php print date("d-m-Y", strtotime($userdata["tgl_spp"])); ?></td>
      </tr>
      <tr>
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
      </tr>
    </table></td>
    <td width="51%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Dari</td>
        <td>:</td>
        <td>Pejabat Pelaksana Teknis Kegiatan </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Nomer SPM </td>
        <td>:</td>
        <td><?php print $userdata["no_spm"];?> </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Tanggal SPM </td>
        <td>:</td>
        <td><?php print date("d-m-Y", strtotime($userdata["tgl_spm"])); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tiga">
      <tr>
        <td width="1%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="84%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Bank/Pos</td>
        <td>:</td>
        <td>&nbsp;<?php print $userdata["nama_bank"];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3"><div align="justify">Hendaklah mencairkan / memindahbukukan dari bank rekening nomer <?php print $userdata["nomer_rekening_bank"];?>, Uang sebesar 
            <?php print 'Rp.'.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?>        </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">(
		  <?php print terbilang_style($userdata3["JUMLAH_BELANJA"], $style=2); ?> )</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" valign="top">&nbsp;</td>
        <td width="28%" valign="top">&nbsp;</td>
        <td width="1%" valign="top">&nbsp;</td>
        <td width="60%" valign="top">&nbsp;</td>
        <td width="10%">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Kepada</td>
        <td valign="top">:</td>
        <td valign="top"><?php print $userdata2["nama_perusahaan"];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">NPWP</td>
        <td valign="top">:</td>
        <td valign="top"><?php print $userdata2["npwp"];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">No. &amp; nama Rekening Bank </td>
        <td valign="top">:</td>
        <td valign="top"><?php print $userdata2["nomer_rekening"];?>a.n <?php print $userdata2["nama_rekening"];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Bank / Pos </td>
        <td valign="top">:</td>
        <td valign="top"><?php print $userdata2["nama_bank"];?> </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Keperluan Untuk </td>
        <td valign="top">:</td>
        <td rowspan="2" valign="top"><?php print $userdata["keterangan"]; ?> </td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Program</td>
        <td valign="top">:</td>
        <td valign="top"><?php print $userdata["kode_program"]; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Kegiatan</td>
        <td valign="top">:</td>
        <td valign="top"><?php print $userdata["kode_kegiatan"]; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Sub Kegiatan </td>
        <td valign="top">:</td>
        <td valign="top"><?php print $userdata["kode_sub_kegiatan"]; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="3%" align="center">No</td>
    <td width="19%" align="center">Kode Rekening </td>
    <td width="27%" align="center">Uraian</td>
    <td align="center">Nilai (Rp) </td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php
		include 'phpcon/koneksi.php';
		$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
		$no_urut=1;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
    	while($data = $result->fetch_assoc()) {
?>
      <tr>
        <td align="center"><?php print $no_urut; ?></td>
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
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td align="center" valign="middle">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php
		include 'phpcon/koneksi.php';
		$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
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
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php
		include 'phpcon/koneksi.php';
		$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
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
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td align="center">&nbsp;
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <?php
		include 'phpcon/koneksi.php';
		$sql= "SELECT * FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and kd_rekening_belanja LIKE '5%'";
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
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table> </td>
  </tr>
  <tr>
    <td colspan="3" align="right">JUMLAH &nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="38%">&nbsp;</td>
        <td width="3%">&nbsp;</td>
        <td width="54%">&nbsp;</td>
        <td width="3%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td colspan="7"><strong>Potongan Oleh bendahara Pengeluaran </strong></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="3%">&nbsp;</td>
                <td width="13%">1.</td>
                <td width="6%">&nbsp;</td>
                <td width="14%">&nbsp;</td>
                <td width="23%">&nbsp;</td>
                <td width="7%">&nbsp;</td>
                <td width="11%">Rp.</td>
                <td width="18%">0,00</td>
                <td width="5%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>JUMLAH</td>
                <td>&nbsp;</td>
                <td>Rp</td>
                <td>0,00</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>&nbsp;</td>
                <td colspan="7"><strong>Informasi</strong></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="2%">&nbsp;</td>
                <td colspan="7">Pajak yang dipungut Bendahara dan telah kunas dibayar/disetor ke kas Negara : </td>
                <td width="3%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td width="3%">1.</td>
                <td width="4%">&nbsp;</td>
                <td width="26%">&nbsp;</td>
                <td width="16%">&nbsp;</td>
                <td width="4%">Rp.</td>
                <td width="6%">&nbsp;</td>
                <td width="36%" align="right"> 0,00 </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong>Jumlah</strong></td>
                <td><strong>Rp.</strong></td>
                <td>&nbsp;</td>
                <td align="right"><strong>0,00</strong></td>
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
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="7">Pajak yang dipungut Bendahara Pengeluaran akan disetor ke Kas negara melalui Bank presepsi bersama SP2D </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>1.</td>
                <td>&nbsp;</td>
                <td colspan="2">PPN Pusat </td>
                <td>Rp.</td>
                <td>&nbsp;</td>
                <td align="right"><?php print ''.number_format($userdata5["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>2.</td>
                <td>&nbsp;</td>
                <td colspan="2">PPh Pasal 21 </td>
                <td>Rp.</td>
                <td>&nbsp;</td>
                <td align="right"><?php print ''.number_format($userdata6["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>3.</td>
                <td>&nbsp;</td>
                <td colspan="2">PPh Pasal 22 </td>
                <td>Rp.</td>
                <td>&nbsp;</td>
                <td align="right"><?php print ''.number_format($userdata7["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>4.</td>
                <td>&nbsp;</td>
                <td colspan="2">PPh Pasal 23 </td>
                <td>Rp.</td>
                <td>&nbsp;</td>
                <td align="right"><?php print ''.number_format($userdata8["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>5.</td>
                <td>&nbsp;</td>
                <td colspan="2">PPh pasal 4 (2) </td>
                <td>Rp.</td>
                <td>&nbsp;</td>
                <td align="right"><?php print ''.number_format($userdata9["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><strong>Jumlah</strong></td>
                <td><strong>Rp.</strong></td>
                <td>&nbsp;</td>
                <td align="right"><?php print ''.number_format($userdata4["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	
	<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th align="left" scope="col">&nbsp;</th>
        <th colspan="2" align="left" scope="col">Jumlah yang dibayarkan </th>
        <th align="left" scope="col">&nbsp;</th>
        <th align="left" scope="col">&nbsp;</th>
        <th align="left" scope="col">&nbsp;</th>
        <th align="left" scope="col">&nbsp;</th>
        <th align="left" scope="col">&nbsp;</th>
        <th align="left" scope="col">&nbsp;</th>
        <th width="1%" align="left" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td width="2%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="56%">Jumlah Pembayaran Bruto </td>
        <td width="2%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td width="2%">Rp.</td>
        <td width="9%">&nbsp;</td>
        <td width="13%"><?php print ''.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><strong>Jumlah Potongan</strong></td>
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
        <td>Pajak yang dipungut dan disetor bersama SPM </td>
        <td>Rp.</td>
        <td>&nbsp;</td>
        <td><?php print ''.number_format($userdata4["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Perhitungan Fihak Ktiga (PFK ) yang dipotong Bendahara </td>
        <td>Rp.</td>
        <td>&nbsp;</td>
        <td>0,00</td>
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
        <td>Rp.</td>
        <td>&nbsp;</td>
        <td><?php print ''.number_format($userdata4["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>jumlah yang di transfer ke rekkening penerima, stelah dikurangi potongan dan setoran pajak </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Rp.</td>
        <td>&nbsp;</td>
        <td><?php print ''.number_format($userdata3["JUMLAH_BELANJA"]- $userdata4["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><strong>Jumlah yang dicairkan dari rekening KAS BLUD RSUD Ajibarang atas ppajak terutang dan selanjutnya disetor ke Bank Jateng sebagai bank persepsi pajak sebesar Rp. , 00 </strong></td>
        <td>&nbsp;</td>
      </tr>
    </table>
	<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="63%">&nbsp;</td>
    <td width="33%" align="center" valign="middle">Ajibarang, <?php echo $today; ?> </td>
    <td width="4%" align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">Pimpinan BLUD  </td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;<br /><br /><br /></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle"><?php 
	
			print $userdata["pimpinan_blud"];
		
		?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">NIP. 
      <?php 
		
			print $userdata["nip_pimpinan"];
		
		?></td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
</table>
	
	</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="middle">SPM ini sah apabila telah ditandatangani dan distampel </td>
  </tr>
</table>



</body>
</html>
<?php
	/*$conn->close();
	}*/
?>
