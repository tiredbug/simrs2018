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


.style1 {font-weight: bold}
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
		PEMERINTAH KABUPATEN BANYUMAS
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
    <td width="42%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        <td colspan="3"><div align="justify">Hendaklah mencairkan / memindahbukukan dari bank rekening nomer <?php print $userdata["nomer_rekening_bank"];?>, Uang sebesar Rp 
          <?php 
		$jenis_spp = $userdata["id_jenis_spp"];
		if($jenis_spp == 1)
		{
			
			print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").'';
			
		}else
		{
			print 'Rp.'.number_format($userdata["jumlah_belanja"] ,0,",",".").'';
		}
		
		?> 
        </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">(
		<?php 
		$jenis_spp = $userdata["id_jenis_spp"];
		if($jenis_spp==1)
		{
			print terbilang_style($userdata["jumlah_spd"], $style=2);
		}else
		{
			print terbilang_style($userdata["jumlah_belanja"], $style=2);
		}
		
		?> )</td>
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
    <td width="36%" align="center">Uraian</td>
    <td align="center">Nilai (Rp) </td>
  </tr>
  <tr>
    <td>&nbsp;1. <br /><br /><br /><br /><br /><br /><br /></td>
    <td align="center" valign="middle">&nbsp;<?php print $userdata["kode_rekening"]; ?><br />
    <br /><br /><br /><br /><br /><br /></td>
    <td align="center"><?php print getNamaAkun5($userdata["kode_rekening"]);?><br />
    <br /><br /><br /><br /><br /><br /></td>
    <td align="center">&nbsp;<?php 
		$jenis_spp = $userdata["id_jenis_spp"];
		if($jenis_spp == 1)
		{
			print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").'';
			
		}else
		{
			print 'Rp.'.number_format($userdata["jumlah_belanja"] ,0,",",".").'';
		}
		
		?> <br />
    <br /><br /><br /><br /><br /><br /></td>
  </tr>
  <tr>
    <td colspan="3" align="right">JUMLAH &nbsp;</td>
    <td align="center"><span class="style1">
      <?php 
		$jenis_spp = $userdata["id_jenis_spp"];
		if($jenis_spp == 1)
		{
			print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").'';
			
		}else
		{
			print 'Rp.'.number_format($userdata["jumlah_belanja"] ,0,",",".").'';
		}
		
		?>
    </span></td>
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
                <th colspan="4" scope="col">Potongan Bendahara Pengeluaran </th>
                </tr>
              <tr>
                <td width="6%">&nbsp;1</td>
                <td width="50%">&nbsp;</td>
                <td width="22%">&nbsp;Rp.</td>
                <td width="22%">&nbsp;</td>
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
              <tr>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right">Jumlah&nbsp;Rp.</td>
                <td>&nbsp;</td>
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
                <th colspan="4" scope="col">Informasi</th>
                </tr>
              <tr>
                <td width="3%">&nbsp;</td>
                <td colspan="3">Pajak yang di pungut Bendahara Pengeluaran dan telah lunaas dibayar/disetor ke kas Negara: </td>
                </tr>
              <tr>
                <td>&nbsp;1</td>
                <td width="59%" align="right">&nbsp;Rp.</td>
                <td width="30%" align="right">0,00</td>
                <td width="8%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right">&nbsp;Jumlah&nbsp;&nbsp;Rp.</td>
                <td align="right">0,00</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3">Panajk yang dipungut Bendahara Pengeluaran dan akan diseot ke Kas negara melalui Bank persepsi bersama SPM: </td>
                </tr>
              <tr>
                <td>&nbsp;1</td>
                <td align="right">Rp.</td>
                <td align="right">0,00</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right">&nbsp;Jumlah&nbsp;&nbsp;Rp.</td>
                <td align="right">0,00</td>
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
        <td width="61%">Jumlah Pembayaran Bruto </td>
        <td width="2%">&nbsp;</td>
        <td width="6%">&nbsp;</td>
        <td width="3%">&nbsp;</td>
        <td width="3%">Rp.</td>
        <td width="8%">&nbsp;</td>
        <td width="13%"><?php 
		$jenis_spp = $userdata["id_jenis_spp"];
		if($jenis_spp == 1)
		{
			print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").'';
			
		}else
		{
			print 'Rp.'.number_format($userdata["jumlah_belanja"] ,0,",",".").'';
		}
		
		?></td>
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
        <td>0,00</td>
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
        <td>&nbsp;</td>
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
        <td><?php 
		$jenis_spp = $userdata["id_jenis_spp"];
		if($jenis_spp == 1)
		{
			print 'Rp.'.number_format($userdata["jumlah_spd"] ,0,",",".").'';
			
		}else
		{
			print 'Rp.'.number_format($userdata["jumlah_belanja"] ,0,",",".").'';
		}
		
		
		?></td>
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
	$conn->close();
	}
?>
