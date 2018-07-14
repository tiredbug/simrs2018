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
		
		$kode_spd = $userdata["kontrak_id"];
		$sql2= "SELECT * FROM simrs2012.data_kontrak where id = ".$kode_spd." limit 1";
		$result2 = $conn->query($sql2);
    	$userdata2 = $result2->fetch_assoc();
		
		
		//jumlah belanja
		$sql3= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja LIKE '5%'";
		$result3 = $conn->query($sql3);
    	$userdata3 = $result3->fetch_assoc();
		
		
		// jumlah komulatif Pajak
		$sql4= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja LIKE '7%'";
		$result4 = $conn->query($sql4);
    	$userdata4 = $result4->fetch_assoc();
		
		// jumlah komulatif Pajak PPN PUSAT
		$sql5= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.05.01'";
		$result5 = $conn->query($sql5);
    	$userdata5 = $result5->fetch_assoc();
		
		
		// jumlah komulatif Pajak PPh 21
		$sql6= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.01'";
		$result6 = $conn->query($sql6);
    	$userdata6 = $result6->fetch_assoc();
		
		// jumlah komulatif Pajak PPh 22
		$sql7= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.02'";
		$result7 = $conn->query($sql7);
    	$userdata7 = $result7->fetch_assoc();
		
		// jumlah komulatif Pajak PPh 23
		$sql8= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.03'";
		$result8 = $conn->query($sql8);
    	$userdata8 = $result8->fetch_assoc();
		
			// jumlah komulatif Pajak PPh 4(2)
		$sql9= "SELECT ifnull(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_spp_detail where id_spp = ".$kdspp." and  kd_rekening_belanja = '7.1.1.04.05'";
		$result9 = $conn->query($sql9);
    	$userdata9 = $result9->fetch_assoc();
		
		
		//RINGKASAN BELANJA GU
		$sql10= "select ifnull(SUM(jumlah_belanja),0) as 'JUMLAH' from t_spp_detail where id_jenis_spp = 2  and tahun_anggaran=  '".$userdata["tahun_anggaran"] ."' ";
		$result10 = $conn->query($sql10);
    	$userdata10 = $result10->fetch_assoc();
		
		
		//RINGKASAN BELANJA TU
		$sql11= "select ifnull(SUM(jumlah_belanja),0) as 'JUMLAH' from t_spp_detail where id_jenis_spp = 3  and tahun_anggaran=  '".$userdata["tahun_anggaran"] ."' ";
		$result11 = $conn->query($sql11);
    	$userdata11 = $result11->fetch_assoc();
		
		
		//RINGKASAN BELANJA BARANG JASA
		$sql12= "select ifnull(SUM(jumlah_belanja),0) as 'JUMLAH' from t_spp_detail where  tahun_anggaran=  '".$userdata["tahun_anggaran"] ."' and   kd_rekening_belanja  LIKE '5.1.2%'";
		$result12 = $conn->query($sql12);
    	$userdata12 = $result12->fetch_assoc();
		
		
		//RINGKASAN BELANJA MODAL
		$sql13= "select ifnull(SUM(jumlah_belanja),0) as 'JUMLAH' from t_spp_detail where id_jenis_spp = 3  and tahun_anggaran=  '".$userdata["tahun_anggaran"] ."' and   kd_rekening_belanja  LIKE '5.1.3%'  ";
		$result13 = $conn->query($sql13);
    	$userdata13 = $result13->fetch_assoc();
		
		
			//RINGKASAN BELANJA NIHIL
		$sql14= "select ifnull(SUM(jumlah_belanja),0) as 'JUMLAH' from t_spp_detail where (detail_jenis_spp = 4 OR detail_jenis_spp =  4 )  and tahun_anggaran=  '".$userdata["tahun_anggaran"] ."' ";
		$result14 = $conn->query($sql14);
    	$userdata14 = $result11->fetch_assoc();
		

		$conn->close();
		
		?>

				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<title>SPP LS GAJI DAN TUNJANGAN</title>
				<style type="text/css">
				/*@page {
				  size: 21cm 33.0cm ;
				  margin: 10;
				}
				
				body {  
					font-family: 'Courier';
					font-size:small;
				}
				.pagebreak { 
					page-break-before: always; 
				}
				.header,
				.footer {
					width: 100%;
					text-align: center;
					position: fixed;
				}
				.header {
					top: 0px;
				}
				.footer {
					bottom: 0px;
				}
				.pagenum:before {
					content: counter(page);
				}*/
				</style>
				
				<style type="text/css">
					@page {
					  size: 21cm 33.0cm ;
					  margin: 0;
					}
					
					body {  
						font-family: 'Courier';
						font-size: 12px;
					}
					
					.pagebreak { 
						page-break-before: always; 
					}
					
					</style>
				</head>
				
				<body onload="window.print();">
				<!--<div class="header">
					Halaman <span class="pagenum"></span>
				</div>
				<div class="footer">
					Modul Keuangan SIM RSUD AJIBARANG (Halaman <span class="pagenum"></span> )
				</div>-->
				<br />
				<table width="100%" border="0">
				  <tr>
					<td>
					  <div align="center">PEMERINTAH KABUPATEN BANYUMAS
						  <br/>
						SURAT PERMINTAAN PEMBAYARAN LANGSUNG(SPP-LS)<br />
						GAJI DAN TUNJANGAN
						<br />
					  NOMER :<strong><?php print $userdata["no_spp"]; ?></strong></div></td>
				  </tr>
				</table>
				
				
				
				<table width="100%" border="0">
				  <tr>
					<td>Kepada Yth. <br />Pemimpin BUD<br />Rumah Sakit Umum Daerah Ajibarang<br />Di Tempat</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td><div align="justify">Dengan memperhatikan Peraturan Bupati Banyumas Nomor : xx  Tahun  2xxxx, tentang xxx, bersama ini kami mengajukan Surat Permintaan Pembayaran Langsung Barang dan Jasa sebagai berikut:</div></td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
				  </tr>
				</table>
				<table width="100%" border="0">
				  <tr>
					<td width="2%"></td>
					<td width="1%"></td>
					<td width="44%"></td>
					<td width="1%"></td>
					<td width="52%"></td>
				  </tr>
				  <tr>
					<td>a)</td>
					<td>.</td>
					<td>Urusan Pemerintahan</td>
					<td>:</td>
					<td><?php print $userdata["urusan_pemerintahan"]; ?> &nbsp;&nbsp;&nbsp;Kesehatan</td>
				  </tr>
				  <tr>
					<td>b)</td>
					<td>.</td>
					<td>OPD</td>
					<td>:</td>
					<td><?php print $userdata["opd"]; ?>&nbsp;&nbsp;&nbsp;Rumah Sakit Umum Daerah Ajibarang</td>
				  </tr>
				  <tr>
					<td>c)</td>
					<td>.</td>
					<td>Tahun Anggaran</td>
					<td>:</td>
					<td><?php print $userdata["tahun_anggaran"]; ?></td>
				  </tr>
				  <tr>
					<td>d)</td>
					<td>.</td>
					<td>Dasar Pengeluaran SPD Nomor</td>
					<td>:</td>
					<td>&nbsp;<?php print $userdata["nomer_dasar_spd"]; ?></td>
				  </tr>
				  <tr>
					<td>e)</td>
					<td>.</td>
					<td>Jumlah Sisa Dana SPD</td>
					<td>:</td>
					<td>&nbsp;<?php print $userdata["jumlah_spd"]; ?></td>
				  </tr>
				  <tr>
					<td>f)</td>
					<td>.</td>
					<td>Untuk Keperluan</td>
					<td>:</td>
					<td>&nbsp;<?php print $userdata["keterangan"]; ?></td>
				  </tr>
				  <tr>
					<td>g)</td>
					<td>.</td>
					<td>Nama Bendahara Pengeluaran</td>
					<td>:</td>
					<td>&nbsp;<?php print $userdata["nama_bendahara"]; ?></td>
				  </tr>
				  <tr>
					<td>h)</td>
					<td>.</td>
					<td>Jumlah Pembayaran yang Diminta</td>
					<td>:</td>
					<td><?php print ''.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>(<?php print terbilang_style($userdata3["JUMLAH_BELANJA"], $style=2); ?>)</td>
			      </tr>
				</table>
				
				<p>&nbsp;</p>
				<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th width="100%" align="center" valign="middle" scope="col">RINGKASAN KEGIATAN </th>
  </tr>
   <tr>
     <td align="center">
	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="2%" valign="top">1</td>
         <td width="2%" valign="top">:</td>
         <td width="28%" valign="top">Program</td>
         <td width="2%" valign="top">:</td>
         <td width="66%" valign="top"><?php print $userdata["kode_program"] ;?></td>
       </tr>
       <tr>
         <td valign="top">2</td>
         <td valign="top">:</td>
         <td valign="top">Kegiatan</td>
         <td valign="top">:</td>
         <td valign="top"><?php print $userdata["kode_kegiatan"] ;?></td>
       </tr>
       <tr>
         <td valign="top">3</td>
         <td valign="top">:</td>
         <td valign="top">Sub Kegiatan </td>
         <td valign="top">:</td>
         <td valign="top"><?php print $userdata["kode_sub_kegiatan"] ;?></td>
       </tr>
       <tr>
         <td valign="top">4</td>
         <td valign="top">:</td>
         <td valign="top">Nomer dan Tanggal DPA/DPPA/DPAL-SKPD </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp; Tgl:		 <?php print date("d-m-Y", strtotime($userdata["tgl_spp"]));?></td>
       </tr>
       <tr>
         <td valign="top">5</td>
         <td valign="top">:</td>
         <td valign="top">Nama Perusahaan </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp;<?php print $userdata2["nama_perusahaan"] ;?></td>
       </tr>
       <tr>
         <td valign="top">6</td>
         <td valign="top">:</td>
         <td valign="top">Bentuk Perusahaan </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp; - </td>
       </tr>
       <tr>
         <td valign="top">7</td>
         <td valign="top">:</td>
         <td valign="top">Alamat Perusahaan </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp;<?php print $userdata2["alamat_perusahaan"] ;?></td>
       </tr>
       <tr>
         <td valign="top">8</td>
         <td valign="top">:</td>
         <td valign="top">Nama Pimpinan Perusahaan </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp; - </td>
       </tr>
       <tr>
         <td valign="top">9</td>
         <td valign="top">:</td>
         <td valign="top">Nama dan Nomer Rekening Bank</td>
         <td valign="top">:</td>
         <td valign="top"> ,<br />
          &nbsp; - <br /></td>
       </tr>
       <tr>
         <td valign="top">10</td>
         <td valign="top">:</td>
         <td valign="top">Nomer Kontrak </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">11</td>
         <td valign="top">:</td>
         <td valign="top">Kegiatan Lanjutan </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp;</td>
       </tr>
       <tr>
         <td valign="top">12</td>
         <td valign="top">:</td>
         <td valign="top">Waktu dan Pelaksanaan Kegiatan </td>
         <td valign="top">:</td>
         <td valign="top">, - 
		 
		 s/d -		 </td>
       </tr>
       <tr>
         <td valign="top">13</td>
         <td valign="top">:</td>
         <td valign="top">Deskripsi Pekerjaan </td>
         <td valign="top">:</td>
         <td valign="top">&nbsp;<?php print $userdata["keterangan"]; ?></td>
       </tr>
       <tr>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
         <td valign="top">&nbsp;</td>
         <td valign="top">(<?php print terbilang_style($userdata3["JUMLAH_BELANJA"], $style=2); ?>)</td>
       </tr>
     </table>
	 </td>
     </tr>
</table>
				<p><br />
				</p>
				<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td colspan="5" align="center"><strong>RINGKASAN DPA-/DPPA-/DPAL-SKPD</strong> </td>
                  </tr>
                  <tr>
                    <td colspan="3">Jumlah Dana DPA-/DPPA-/DPAL-SKPD </td>
                    <td width="3%" align="center">Rp</td>
                    <td width="32%" align="center">&nbsp;<?php print ''.number_format($userdata["jumlah_spd"] ,0,",",".").''; ?></td>
                  </tr>
                  <tr>
                    <td colspan="5" align="center"><strong>Ringkasam SPD</strong> </td>
                  </tr>
                  <tr align="center">
                    <td width="2%"><strong>No</strong></td>
                    <td width="33%"><strong>Nomor SPD </strong></td>
                    <td width="30%"><strong>Tanggal SPD </strong></td>
                    <td colspan="2"><strong>Jumlah Dana </strong></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;<?php print $userdata["nomer_dasar_spd"]; ?></td>
                    <td>&nbsp; <?php print date("d-m-Y", strtotime($userdata['tanggal_spd']));?></td>
                    <td align="center">Rp</td>
                    <td align="center"><?php print ''.number_format($userdata["jumlah_spd"] ,0,",",".").''; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right"><strong>Jumlah</strong></td>
                    <td align="center"><strong>Rp</strong></td>
                    <td align="center"><?php print ''.number_format($userdata["jumlah_spd"] ,0,",",".").''; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right"><strong>Sisa dana yang belum di SPD-kan (I-II) </strong></td>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="5">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="5" align="center"><strong>RINGKASAN BELANJA </strong></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">Belanja UP/GU </td>
                    <td align="center">Rp</td>
                    <td align="center"><?php
	 print ''.number_format($userdata10["JUMLAH"],0,",",".").''; 
	 
	 
	 ?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">Belanja TU </td>
                    <td align="center">Rp</td>
                    <td align="center"><?php print ''.number_format(getTotalRekeningSPP(3,$userdata["tahun_anggaran"]) ,0,",",".").''; ?></td>
                  </tr>
                  <!-- -->
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">Belanja LS Barang/Jasa </td>
                    <td align="center">Rp</td>
                    <td align="center"><?php print ''.number_format($userdata12["JUMLAH"],0,",",".");?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">Belanja LS Modal BLUD </td>
                    <td align="center">Rp</td>
                    <td align="center"><?php
	 print ''.number_format($userdata13["JUMLAH"],0,",",".").''; 
	 
	 
	 ?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">Belanja Nihil </td>
                    <td align="center">Rp</td>
                    <td align="center"><?php print ''.number_format($userdata14["JUMLAH"],0,",",".").''; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right">Jumlah</td>
                    <td align="center">Rp</td>
                    <td align="center"><?php
		$total = $userdata10["JUMLAH"]+$userdata11["JUMLAH"]+$userdata12["JUMLAH"]+$userdata13["JUMLAH"]+$userdata14["JUMLAH"];
	
	 print ''.number_format($total,0,",",".").''; ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right">Sisa SPD yang diterbitkan, Belum dibelanjakan(II-III) </td>
                    <td align="center">Rp</td>
                    <td align="center"><?php
		$total2 = $userdata["jumlah_spd"]- $total;
	
	 print ''.number_format($total2 ,0,",",".").''; ?></td>
                  </tr>
                </table>
				<p>&nbsp;				  </p>
				<div class="pagebreak"></div>
				<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <th colspan="4" scope="col">RINCIAN SPP </th>
                  </tr>
                  <tr align="center">
                    <td width="2%"><strong>No</strong></td>
                    <td width="30%"><strong>Kode Rekening </strong></td>
                    <td width="39%"><strong>Uraian</strong></td>
                    <td width="29%"><strong>Nilai (Rp) </strong></td>
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
                      </table></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="right">JUMLAH</td>
                    <td align="center"><?php print ''.number_format($userdata3["JUMLAH_BELANJA"] ,0,",",".").''; ?></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="left" valign="middle"><p>Terbilang : <?php print terbilang_style($userdata3["JUMLAH_BELANJA"], $style=2); ?></p></td>
                  </tr>
                </table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="42%"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <th scope="col">Potongan Oleh Bendahara Pengeluaran </th>
                        </tr>
                        <tr>
                          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="10%">&nbsp;</td>
                                <td width="6%">1.</td>
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
                    <td width="3%" valign="top"></td>
                    <td width="55%" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                          <th scope="col">Informasi</th>
                        </tr>
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
                  </tr>
                </table>
				<p>&nbsp;</p>
				<p><br />
			    </p>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="48%" align="center">Mengetahui,</td>
                    <td width="11%">&nbsp;</td>
                    <td width="39%" align="center" valign="middle">Ajibarang, <?php echo $today; ?></td>
                    <td width="2%" align="right" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center">Pejabat Pelaksana Teknis Kegiatan </td>
                    <td>&nbsp;</td>
                    <td align="center" valign="middle">Bendahara Pengeluaran </td>
                    <td align="right" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="27" align="center">&nbsp;</td>
                    <td height="27">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;<br />
                        <br />
                      <br /></td>
                    <td align="right" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center"><?php print $userdata["nama_pptk"]; ?></td>
                    <td>&nbsp;</td>
                    <td align="center" valign="middle"><?php print $userdata["nama_bendahara"]; ?></td>
                    <td align="right" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center">NIP.<?php print $userdata["nip_pptk"]; ?></td>
                    <td>&nbsp;</td>
                    <td align="center" valign="middle">NIP.<?php print $userdata["nip_bendahara"]; ?> </td>
                    <td align="right" valign="middle">&nbsp;</td>
                  </tr>
                </table>
				</body>
				</html>
				
				<?php
				//$conn->close();
				/*$html = ob_get_clean();
				require_once 'dompdf/autoload.inc.php';
				use Dompdf\Dompdf;
				use Dompdf\Options;
				$options = new Options();
				$options->set('defaultFont', 'Courier');
				$options->set('isJavascriptEnabled', TRUE);
				$dompdf = new Dompdf($options);
				$dompdf->set_option('chroot', __DIR__);
				$dompdf->set_option('enable_font_subsetting', true);
				$dompdf->set_option('isHtml5ParserEnabled', true);
				$dompdf->set_option('isJavascriptEnabled', true);
				$dompdf->set_option('enable_remote', TRUE);
				$dompdf->set_option('enable_css_float', TRUE);
				$dompdf->load_html($html);
				$dompdf->setPaper('F4', 'portrait');
				$dompdf->render();
				$canvas = $dompdf->get_canvas();
				//$dompdf->getCanvas()->page_text(15, 10, "Halaman: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
				
				$canvas->page_text(480, 900, "Halaman {PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0,0,0));
				$canvas->page_text(12, 900, "SIM RSUD AJIBARANG - Modul Keuangan", $font, 10, array(0,0,0));
				$canvas->page_text(43, 770, $date, $font, 10, array(0,0,0));
				$dompdf->stream('LaporanAdministrasiPasienRawatInap.pdf',array('Attachment' => 0));*/
				?>

<?php
		
		
		
		
	}

?>

