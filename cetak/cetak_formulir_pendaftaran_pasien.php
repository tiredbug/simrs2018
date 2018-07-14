<?php include_once "../ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "../adodb5/adodb.inc.php" : "../ewmysql13.php") ?>
<?php include_once "../phpfn13.php" ?>
<?php include_once "../m_logininfo.php" ?>
<?php include_once "../userfn13.php" ?>
<?php 

include '../phpcon/koneksi.php';
include '../phpcon/fungsi_col.php';


function datetimes($tgl,$Jam=true){
/*Contoh Format : 2007-08-15 01:27:45*/
		$tanggal = strtotime($tgl);
		$bln_array = array (
			  '01'=>'Januari',
			  '02'=>'Februari',
			  '03'=>'Maret',
			  '04'=>'April',
			  '05'=>'Mei',
			  '06'=>'Juni',
			  '07'=>'Juli',
			  '08'=>'Agustus',
			  '09'=>'September',
			  '10'=>'Oktober',
			  '11'=>'November',
			  '12'=>'Desember'
			  );
		$hari_arr = Array ('0'=>'Minggu',
				   '1'=>'Senin',
				   '2'=>'Selasa',
				  '3'=>'Rabu',
				  '4'=>'Kamis',
				  '5'=>'Jum`at',
				  '6'=>'Sabtu'
				   );
		$hari = @$hari_arr[date('w',$tanggal)];
		$tggl = date('j',$tanggal);
		$bln = @$bln_array[date('m',$tanggal)];
		$thn = date('Y',$tanggal);
		$jam = $Jam ? date ('H:i:s',$tanggal) : '';
		return "$hari, $tggl $bln $thn";      
		}


		$kdpoly = htmlspecialchars($_GET["KDPOLY"]);
		$idadmisi = htmlspecialchars($_GET["IDXDAFTAR"]);
		$tanggal = htmlspecialchars($_GET["TGLREG"]);



		$sql= "call simrs2012.cetak_formulir_pendaftaran_pasien(".$kdpoly.", ".$idadmisi.", '".$tanggal."')";
		$result = $conn->query($sql);

    	$userdata = $result->fetch_assoc();
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cetak Formulir Pendaftaran</title>
<style>
table {
  font: 9px/19px Tahoma, Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  }

th {
  padding: 0 0.5em;
  text-align: left;
  }

tr.yellow td {
  border-top: 0px solid #000000;
  border-bottom: 0px solid #000000;
  background: #FFC;
  }

td {
  border-bottom: 0px solid #000000;
  padding: 0 0.5em;
  }

td:first-child {
  width: 190px;
  }

td+td {
  border-left: 0px solid #000000;
  text-align: center;
  }
  </style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table border="0">
  <tr>
    <td colspan="4"><div align="center">PEMERINTAH KABUPATEN BANYUMAS<br>
    RUMAH SAKIT UMUM DAERAH AJIBARANG<br>
    Jl. Raya Pancasan - Ajibarang Kode Pos 53163 Telp. 0281-6570004 Fax. 0281-6570005<br>
    E-mail : rsudajibarang@banyumaskab.go.id </div><hr></td>
  </tr>
  <tr>
    <td colspan="4"><div align="center">FORMULIR PENDAFTARAN PASIEN BARU RSUD AJIBARANG </div></td>
  </tr>
  <tr>
    <td width="221">Cara Pembayaran </td>
    <td width="188"><div align="left">: &nbsp; <?php echo $userdata['carabayar']; ?> </div></td>
    <td width="147"><div align="left">No. Rekam Medis</div> </td>
    <td width="216"><div align="left">: &nbsp; <?php echo $userdata['NOMR']; ?></div></td>
  </tr>
  <tr>
    <td>Nama Pasien (sesuai KTP) </td>
    <td><div align="left">: &nbsp;<?php echo $userdata['pasien']; ?></div></td>
    <td><div align="left">Jenis Kelamin</div> </td>
    <td><div align="left">: &nbsp;<?php echo $userdata['JENISKELAMIN']; ?></div></td>
  </tr>
  <tr>
    <td>Nama Ibu Kandung</td>
    <td><div align="left">: &nbsp; <?php echo $userdata['nama_ibu']; ?></div></td>
    <td><div align="left">Nama Ayah </div></td>
    <td><div align="left">: &nbsp; <?php echo $userdata['nama_ayah']; ?></div></td>
  </tr>
  <tr>
    <td>No. BPJS</td>
    <td><div align="left">: &nbsp; <?php echo $userdata['NO_KARTU']; ?></div></td>
    <td><div align="left">Umur</div></td>
    <td><div align="left">: &nbsp; 
	<?php

	// Tanggal Lahir
	$birthday = $userdata['TGLLAHIR'];
	
	// Convert Ke Date Time
	$biday = new DateTime($birthday);
	$today = new DateTime();
	
	$diff = $today->diff($biday);
	
	echo "".$diff->y." thn - ".$diff->m." bln - ".$diff->d." hari";

	?>
	
	</div></td>
  </tr>
  
  <tr>
    <td>Tempat/tanggal lahir</td>
    <td><div align="left">: &nbsp; <?php echo $userdata['TEMPAT']; ?>, <?php echo $userdata['TGLLAHIR']; ?></div></td>
    <td><div align="left">Etnis</div></td>
    <td align="left"><div align="left">: &nbsp;<?php echo $userdata['KD_ETNIS']; ?></div></td>
  </tr>
  <tr>
    <td>Alamat Sekarang </td>
    <td><div align="left">: &nbsp;<?php echo $userdata['ALAMAT']; ?></div></td>
    <td><div align="left">Bahasa Sehari-Hari </div></td>
    <td><div align="left">: &nbsp;<?php echo $userdata['KD_BHS_HARIAN']; ?></div></td>
  </tr>
  <tr>
    <td>Pendidikan Terakhir </td>
    <td><div align="left">: &nbsp;
          <?php

      if ($userdata['PENDIDIKAN']=="1") {
        echo 'SD';
      } elseif ($userdata['PENDIDIKAN']=="2"){
        echo 'SLTP';
      } elseif ($userdata['PENDIDIKAN']=="3"){
        echo 'SLTA';
      } elseif ($userdata['PENDIDIKAN']=="4"){
        echo 'D3/Akademik';
      } elseif ($userdata['PENDIDIKAN']=="5"){
        echo 'Universitas';
      } elseif ($userdata['PENDIDIKAN']=="0"){
        echo 'Belum Bersekolah';
      }

      ?>
    </div></td>
    <td><div align="left">Asal Faskes </div></td>
    <td><div align="left">: &nbsp;<?php echo $userdata['KDPPKRUJUKAN_SEP'].'-'.$userdata['NMPPKRUJUKAN_SEP']; ?></div></td>
  </tr>
  <tr>
    <td>Status Perkawinan </td>
    <td><div align="left">: &nbsp;
          <?php

      if ($userdata['STATUS']=="1") {
        echo 'BELUM KAWIN';
      } elseif ($userdata['STATUS']=="2"){
        echo 'KAWIN';
      } elseif ($userdata['STATUS']=="3"){
        echo 'JANDA/DUDA';
      }

      ?>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Agama</td>
    <td><div align="left">: &nbsp;
          <?php

      if ($userdata['AGAMA']=="1") {
        echo 'ISLAM';
      } elseif ($userdata['AGAMA']=="2"){
        echo 'KRISTEN';
      } elseif ($userdata['AGAMA']=="3"){
        echo 'KATHOLIK';
      } elseif ($userdata['AGAMA']=="4"){
        echo 'HINDU';
      } elseif ($userdata['AGAMA']=="5"){
        echo 'BUDHA';
      } elseif ($userdata['AGAMA']=="6"){
        echo 'LAIN-lAIN';
      }

      ?>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>No Telepon/HP</td>
    <td><div align="left">: &nbsp;<?php echo $userdata['NOTELP']; ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Suami </td>
    <td><div align="left">: &nbsp;<?php echo $userdata['SUAMI_ORTU']; ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Istri </td>
    <td><div align="left">: &nbsp;<?php echo $userdata['nama_istri']; ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Penanggungjawab </td>
    <td><div align="left">: &nbsp;<?php echo $userdata['PENANGGUNGJAWAB_NAMA']; ?></div></td>
    <td>No Telp/HP </td>
    <td><div align="left">: &nbsp;<?php echo $userdata['PENANGGUNGJAWAB_PHONE']; ?></div></td>
  </tr>
  <tr>
    <td>Hubungan Dengan Pasien </td>
    <td colspan="3"><div align="left">: &nbsp;<?php echo $userdata['PENANGGUNGJAWAB_HUBUNGAN']; ?></div></td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">TTD dan Nama Pasien /<br> 
      Penanggungjawab<br><br>
      
      (<?php echo $userdata['PENANGGUNGJAWAB_NAMA']; ?>)<br> 
    </div></td>
    <td colspan="2"><div align="center">TTD dan Nama Petugas <br>
      TPPRJ/TPPGD/TPPRI<br><br>
      
    (<?php echo CurrentUserName(); ?>)</div></td>
  </tr>
</table>
</body>
</html>
<?php
	$conn->close();
?>
