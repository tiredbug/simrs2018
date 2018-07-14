<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}

function getLastNoM($p) {
	$sNextKode = "";
	$value = ew_ExecuteScalar("select NOMR as nomor from m_pasien order by NOMR desc limit 1");
	if ($value != "") {
		$v = $value + $p;
		$vl=strlen($v);
		if($v < 10){
			$value = '00000'.$v;
		}else if(
			$v < 100){ $value = '0000'.$v;
		}else if($v < 1000){
			$value = '000'.$v;
		}else if($v < 10000){
			$value = '00'.$v;
		}else if($v < 100000){
			$value = '0'.$v;
		}else{
			$value = $v;
		}
		$sNextKode = $value;
	} else { 
		$sNextKode = "000001";
	}
	return $sNextKode;
}

function getCount_order_admission() {
	$sNextKode = "";
	$value = ew_ExecuteScalar("SELECT COUNT(IDXORDER) FROM simrs2012.t_orderadmission WHERE STATUS  = '0'");
	if ($value != "") {
		$sNextKode = $value;
	} else { 
		$sNextKode = 0;
	}
	return $sNextKode;
}

function getCount_pasienbaru() {
	$sNextKode = "";
	$value = ew_ExecuteScalar("select COUNT(*) FROM t_pendaftaran where TGLREG = curdate() AND PASIENBARU = 1");
	if ($value != "") {
		$sNextKode = $value;
	} else { 
		$sNextKode = 0;
	}
	return $sNextKode;
}

function getCount_pasien_rawat_jalan() {
	$sNextKode = "";
	$value = ew_ExecuteScalar("select COUNT(*) FROM t_pendaftaran where TGLREG = curdate()");
	if ($value != "") {
		$sNextKode = $value;
	} else { 
		$sNextKode = 0;
	}
	return $sNextKode;
}

function getCount_sep_rawat_jalan() {
	$sNextKode = "";
	$value = ew_ExecuteScalar("SELECT COUNT(*) FROM t_pendaftaran WHERE TGLREG = curdate() AND JENISPERAWATAN_SEP = 2");
	if ($value != "") {
		$sNextKode = $value;
	} else { 
		$sNextKode = 0;
	}
	return $sNextKode;
}

function getNamaPasienByNOMR($nomr) {
	$sNextKode = "";
	$v_nomr = $nomr;
	$sql = "SELECT NAMA FROM m_pasien WHERE NOMR = ".$v_nomr." LIMIT 1 ";
	$new_nomr = ew_ExecuteScalar($sql);
	if ($new_nomr != "") {
		$sNextKode = $new_nomr;
	} else { 
		$sNextKode = '-';
	}
	return $sNextKode;
}

function getNamaPasienByID($id) {
	$sNextKode = "";
	$v_id = $id;
	$sql = "select NAMA from m_pasien WHERE id =  ".$v_id." LIMIT 1 ";
	$new_nomr = ew_ExecuteScalar($sql);
	if ($new_nomr != "") {
		$sNextKode = $new_nomr;
	} else { 
		$sNextKode = '-';
	}
	return $sNextKode;
}

function getNOMRPasienByID($id) {
	$sNextKode = "";
	$v_id = $id;
	$sql = "select NOMR from m_pasien WHERE id =  ".$v_id." LIMIT 1 ";
	$new_nomr = ew_ExecuteScalar($sql);
	if ($new_nomr != "") {
		$sNextKode = $new_nomr;
	} else { 
		$sNextKode = '-';
	}
	return $sNextKode;
}

function GetStatusPasienBAruLama($nomr) {
   $sNextKode = "";
	$v_nomr = $nomr;

	//$value = ew_ExecuteScalar("SELECT NAMA FROM simrs2012.m_pasien WHERE NOMR = ".$v_nomr." LIMIT 1");
	$value = ew_ExecuteScalar("select simrs2012.pasien_baru_lama(".$v_nomr.")");
	if ($value != "") {
		$sNextKode = $value;
	} else { 
		$sNextKode = '0';
	}
	return $sNextKode;
}

function GetNextNomerSBP() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_sbp FROM t_sbp ORDER BY no_sbp DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SBP";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPP_UP() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_spp FROM t_spp ORDER BY no_spp DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPP-UP";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPP_LS() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_spp FROM t_spp ORDER BY no_spp DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPP-LS";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPP_PP() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_spp FROM t_spp ORDER BY no_spp DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPP-PP";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPM() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_spm FROM t_spp ORDER BY no_spm DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPM";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPJ() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_spj FROM t_spj ORDER BY no_spj DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPJ";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPTB() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_sptb FROM t_spp ORDER BY no_sptb DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPTB";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerAdvis() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT kode_advis FROM t_advis_spm ORDER BY kode_advis DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "ADVIS";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPP_GU() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_spp FROM t_spp ORDER BY no_spp DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPP-GU";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}

function GetNextNomerSPP_GU_NIHIL() {
 $sNextKode = "";
	$sLastKode = "";
	$value = ew_ExecuteScalar("SELECT no_spp FROM t_spp ORDER BY no_spp DESC");
	$sufik = ew_ExecuteScalar("SELECT MAX(tahun) FROM m_kegiatan_tahunan_rs");
	$tipe = "SPP-GU-NIHIL";
	$instasi = "RSUDAJB";
	if ($value != "") { // jika sudah ada, langsung ambil dan proses...
		$sLastKode = intval(substr($value, 1, 4)); // ambil 3 digit terakhir
		$sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
		$sNextKode = "" . sprintf('%04s', $sLastKode); // format hasilnya dan tambahkan prefix
		if (strlen($sNextKode) > 6) {
			$sNextKode = "999999";
		}
	} else { // jika belum ada, gunakan kode yang pertama
		$sNextKode = "0001";
	}
	$sNextKode = $sNextKode."/".$tipe."/".$instasi."/".$sufik;
	return $sNextKode;
}
include_once("epi/epi_template_functions.php");
?>
