<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$default = NULL; // Initialize page object first

class cdefault {

	// Page ID
	var $PageID = 'default';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Page object name
	var $PageObjName = 'default';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'default', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// User table object (m_login)
		if (!isset($UserTable)) {
			$UserTable = new cm_login();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	//
	// Page main
	//
	function Page_Main() {
		global $Security, $Language;

		// If session expired, show session expired message
		if (@$_GET["expired"] == "1")
			$this->setFailureMessage($Language->Phrase("SessionExpired"));
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadUserLevel(); // Load User Level
		if ($Security->AllowList(CurrentProjectID() . 'home.php'))
		$this->Page_Terminate("home.php"); // Exit and go to default page
		if ($Security->AllowList(CurrentProjectID() . 'audittrail'))
			$this->Page_Terminate("audittraillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'bentuk_perusahaan'))
			$this->Page_Terminate("bentuk_perusahaanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'buat_sep.php'))
			$this->Page_Terminate("buat_sep.php");
		if ($Security->AllowList(CurrentProjectID() . 'cek_kepesertaan_bpjs.php'))
			$this->Page_Terminate("cek_kepesertaan_bpjs.php");
		if ($Security->AllowList(CurrentProjectID() . 'chart1.php'))
			$this->Page_Terminate("chart1.php");
		if ($Security->AllowList(CurrentProjectID() . 'Dasboard2.php'))
			$this->Page_Terminate("Dasboard2.php");
		if ($Security->AllowList(CurrentProjectID() . 'data_kontrak'))
			$this->Page_Terminate("data_kontraklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'data_kontrak_detail_termin'))
			$this->Page_Terminate("data_kontrak_detail_terminlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'detail_spj'))
			$this->Page_Terminate("detail_spjlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'insert_sep_ranap.php'))
			$this->Page_Terminate("insert_sep_ranap.php");
		if ($Security->AllowList(CurrentProjectID() . 'keu_akun1'))
			$this->Page_Terminate("keu_akun1list.php");
		if ($Security->AllowList(CurrentProjectID() . 'keu_akun2'))
			$this->Page_Terminate("keu_akun2list.php");
		if ($Security->AllowList(CurrentProjectID() . 'keu_akun3'))
			$this->Page_Terminate("keu_akun3list.php");
		if ($Security->AllowList(CurrentProjectID() . 'keu_akun4'))
			$this->Page_Terminate("keu_akun4list.php");
		if ($Security->AllowList(CurrentProjectID() . 'keu_akun5'))
			$this->Page_Terminate("keu_akun5list.php");
		if ($Security->AllowList(CurrentProjectID() . 'l_jenis_detail_spp'))
			$this->Page_Terminate("l_jenis_detail_spplist.php");
		if ($Security->AllowList(CurrentProjectID() . 'l_jenis_mutasi'))
			$this->Page_Terminate("l_jenis_mutasilist.php");
		if ($Security->AllowList(CurrentProjectID() . 'l_jenis_spp'))
			$this->Page_Terminate("l_jenis_spplist.php");
		if ($Security->AllowList(CurrentProjectID() . 'l_tarif_kelompok_tindakan'))
			$this->Page_Terminate("l_tarif_kelompok_tindakanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'l_tarif_sub_kelompok_1'))
			$this->Page_Terminate("l_tarif_sub_kelompok_1list.php");
		if ($Security->AllowList(CurrentProjectID() . 'l_tarif_sub_kelompok_2'))
			$this->Page_Terminate("l_tarif_sub_kelompok_2list.php");
		if ($Security->AllowList(CurrentProjectID() . 'l_trainingkode'))
			$this->Page_Terminate("l_trainingkodelist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_blud_rs'))
			$this->Page_Terminate("m_blud_rslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_carabayar'))
			$this->Page_Terminate("m_carabayarlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_data_tarif'))
			$this->Page_Terminate("m_data_tariflist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_dokter_jaga_ranap'))
			$this->Page_Terminate("m_dokter_jaga_ranaplist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_farmasi'))
			$this->Page_Terminate("m_farmasilist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_kegiatan'))
			$this->Page_Terminate("m_kegiatanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_kegiatan_tahunan_rs'))
			$this->Page_Terminate("m_kegiatan_tahunan_rslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_kegiatan_tahunan_rs_detail'))
			$this->Page_Terminate("m_kegiatan_tahunan_rs_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_login'))
			$this->Page_Terminate("m_loginlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_pasien'))
			$this->Page_Terminate("m_pasienlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_pejabat_keuangan'))
			$this->Page_Terminate("m_pejabat_keuanganlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_program'))
			$this->Page_Terminate("m_programlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_ruang'))
			$this->Page_Terminate("m_ruanglist.php");
		if ($Security->AllowList(CurrentProjectID() . 'm_sub_kegiatan'))
			$this->Page_Terminate("m_sub_kegiatanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'maping_sep_ranap.php'))
			$this->Page_Terminate("maping_sep_ranap.php");
		if ($Security->AllowList(CurrentProjectID() . 'mapping_trans_sep.php'))
			$this->Page_Terminate("mapping_trans_sep.php");
		if ($Security->AllowList(CurrentProjectID() . 'pd_analytics'))
			$this->Page_Terminate("pd_analyticslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pd_notifications'))
			$this->Page_Terminate("pd_notificationslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pd_tasks'))
			$this->Page_Terminate("pd_taskslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'pendaftaran_ranap_sukses.php'))
			$this->Page_Terminate("pendaftaran_ranap_sukses.php");
		if ($Security->AllowList(CurrentProjectID() . 'pendaftaran_sukses.php'))
			$this->Page_Terminate("pendaftaran_sukses.php");
		if ($Security->AllowList(CurrentProjectID() . 'peserta_by_noKa.php'))
			$this->Page_Terminate("peserta_by_noKa.php");
		if ($Security->AllowList(CurrentProjectID() . 'Rujukan_by_no_rujukan.php'))
			$this->Page_Terminate("Rujukan_by_no_rujukan.php");
		if ($Security->AllowList(CurrentProjectID() . 'spp'))
			$this->Page_Terminate("spplist.php");
		if ($Security->AllowList(CurrentProjectID() . 'sukses_simpan_pasien.php'))
			$this->Page_Terminate("sukses_simpan_pasien.php");
		if ($Security->AllowList(CurrentProjectID() . 't_admission'))
			$this->Page_Terminate("t_admissionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_admission_detail'))
			$this->Page_Terminate("t_admission_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_advis_spm'))
			$this->Page_Terminate("t_advis_spmlist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_advis_spm_detail'))
			$this->Page_Terminate("t_advis_spm_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_orderadmission'))
			$this->Page_Terminate("t_orderadmissionlist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_pendaftaran'))
			$this->Page_Terminate("t_pendaftaranlist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_sbp'))
			$this->Page_Terminate("t_sbplist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_sbp_detail'))
			$this->Page_Terminate("t_sbp_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_sep'))
			$this->Page_Terminate("t_seplist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_setoran_pajak_gu'))
			$this->Page_Terminate("t_setoran_pajak_gulist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_spd'))
			$this->Page_Terminate("t_spdlist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_spj'))
			$this->Page_Terminate("t_spjlist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_spp'))
			$this->Page_Terminate("t_spplist.php");
		if ($Security->AllowList(CurrentProjectID() . 't_spp_detail'))
			$this->Page_Terminate("t_spp_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tbantrianpoli'))
			$this->Page_Terminate("tbantrianpolilist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tbnoantri'))
			$this->Page_Terminate("tbnoantrilist.php");
		if ($Security->AllowList(CurrentProjectID() . 'tbpanggil'))
			$this->Page_Terminate("tbpanggillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'training'))
			$this->Page_Terminate("traininglist.php");
		if ($Security->AllowList(CurrentProjectID() . 'userlevelpermissions'))
			$this->Page_Terminate("userlevelpermissionslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'userlevels'))
			$this->Page_Terminate("userlevelslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap'))
			$this->Page_Terminate("vw_bill_ranaplist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_data_tarif_tindakan'))
			$this->Page_Terminate("vw_bill_ranap_data_tarif_tindakanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_dokter'))
			$this->Page_Terminate("vw_bill_ranap_detail_konsul_dokterlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_vct'))
			$this->Page_Terminate("vw_bill_ranap_detail_konsul_vctlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_pelayanan_los'))
			$this->Page_Terminate("vw_bill_ranap_detail_pelayanan_loslist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_kebidanan'))
			$this->Page_Terminate("vw_bill_ranap_detail_tindakan_kebidananlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_lain'))
			$this->Page_Terminate("vw_bill_ranap_detail_tindakan_lainlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_penunjang'))
			$this->Page_Terminate("vw_bill_ranap_detail_tindakan_penunjanglist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_perawat'))
			$this->Page_Terminate("vw_bill_ranap_detail_tindakan_perawatlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tmno'))
			$this->Page_Terminate("vw_bill_ranap_detail_tmnolist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visite_farmasi'))
			$this->Page_Terminate("vw_bill_ranap_detail_visite_farmasilist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visite_gizi'))
			$this->Page_Terminate("vw_bill_ranap_detail_visite_gizilist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visitekonsul_dokter'))
			$this->Page_Terminate("vw_bill_ranap_detail_visitekonsul_dokterlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bridging_sep_by_no_kartu'))
			$this->Page_Terminate("vw_bridging_sep_by_no_kartulist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_bridging_sep_by_no_rujukan'))
			$this->Page_Terminate("vw_bridging_sep_by_no_rujukanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_list_pasien_rawat_jalan'))
			$this->Page_Terminate("vw_list_pasien_rawat_jalanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_list_spj'))
			$this->Page_Terminate("vw_list_spjlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_lookup_dokter_poli'))
			$this->Page_Terminate("vw_lookup_dokter_polilist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_mutasi_bank_tunai'))
			$this->Page_Terminate("vw_mutasi_bank_tunailist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_mutasi_tunai_bank'))
			$this->Page_Terminate("vw_mutasi_tunai_banklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_pajak_sbp_detail'))
			$this->Page_Terminate("vw_pajak_sbp_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_sensus_harian_rawat_jalan'))
			$this->Page_Terminate("vw_sensus_harian_rawat_jalanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_sep_rawat_inap_by_noka'))
			$this->Page_Terminate("vw_sep_rawat_inap_by_nokalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_set_tanggal_pulang'))
			$this->Page_Terminate("vw_set_tanggal_pulanglist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spm'))
			$this->Page_Terminate("vw_spmlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_detail_pajak'))
			$this->Page_Terminate("vw_spp_detail_pajaklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_gu_list'))
			$this->Page_Terminate("vw_spp_gu_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_gu_nihil_list'))
			$this->Page_Terminate("vw_spp_gu_nihil_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_ls_barang_jasa_detail'))
			$this->Page_Terminate("vw_spp_ls_barang_jasa_detaillist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_ls_gaji_list'))
			$this->Page_Terminate("vw_spp_ls_gaji_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_ls_gaji_list_detail_belanja'))
			$this->Page_Terminate("vw_spp_ls_gaji_list_detail_belanjalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_ls_gaji_list_detail_pajak'))
			$this->Page_Terminate("vw_spp_ls_gaji_list_detail_pajaklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_ls_kontrak_list'))
			$this->Page_Terminate("vw_spp_ls_kontrak_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_ls_non_kontrak_list'))
			$this->Page_Terminate("vw_spp_ls_non_kontrak_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_pengembalian_penerimaan'))
			$this->Page_Terminate("vw_spp_pengembalian_penerimaanlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_pengembalian_penerimaan_detail_belanja'))
			$this->Page_Terminate("vw_spp_pengembalian_penerimaan_detail_belanjalist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_pengembalian_penerimaan_detail_pajak'))
			$this->Page_Terminate("vw_spp_pengembalian_penerimaan_detail_pajaklist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_tu_list'))
			$this->Page_Terminate("vw_spp_tu_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_tu_nihil_list'))
			$this->Page_Terminate("vw_spp_tu_nihil_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_up_list'))
			$this->Page_Terminate("vw_spp_up_listlist.php");
		if ($Security->AllowList(CurrentProjectID() . 'ws_rujukan_by_no_rujukan.php'))
			$this->Page_Terminate("ws_rujukan_by_no_rujukan.php");
		if ($Security->AllowList(CurrentProjectID() . 'vclaim_peserta_nobpjs.php'))
			$this->Page_Terminate("vclaim_peserta_nobpjs.php");
		if ($Security->AllowList(CurrentProjectID() . 'vclaim_peserta_nik.php'))
			$this->Page_Terminate("vclaim_peserta_nik.php");
		if ($Security->AllowList(CurrentProjectID() . 'vclaim_sep_carisep.php'))
			$this->Page_Terminate("vclaim_sep_carisep.php");
		if ($Security->AllowList(CurrentProjectID() . 'vclaim_sep_insert.php'))
			$this->Page_Terminate("vclaim_sep_insert.php");
		if ($Security->AllowList(CurrentProjectID() . 'vclaim_rujukan_cari_pcarenobpjs.php'))
			$this->Page_Terminate("vclaim_rujukan_cari_pcarenobpjs.php");
		if ($Security->AllowList(CurrentProjectID() . 'vclaim_rujukan_cari_pcarenik.php'))
			$this->Page_Terminate("vclaim_rujukan_cari_pcarenik.php");
		if ($Security->AllowList(CurrentProjectID() . 'vclaim_rujukan_insert_rujukan.php'))
			$this->Page_Terminate("vclaim_rujukan_insert_rujukan.php");
		if ($Security->AllowList(CurrentProjectID() . 'pendaftaran_pasien.php'))
			$this->Page_Terminate("pendaftaran_pasien.php");
		if ($Security->AllowList(CurrentProjectID() . 'pendaftaran_pasien_proses.php'))
			$this->Page_Terminate("pendaftaran_pasien_proses.php");
		if ($Security->IsLoggedIn()) {
			$this->setFailureMessage(ew_DeniedMsg() . "<br><br><a href=\"logout.php\">" . $Language->Phrase("BackToLogin") . "</a>");
		} else {
			$this->Page_Terminate("login.php"); // Exit and go to login page
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'
	function Message_Showing(&$msg, $type) {

		// Example:
		//if ($type == 'success') $msg = "your success message";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($default)) $default = new cdefault();

// Page init
$default->Page_Init();

// Page main
$default->Page_Main();
?>
<?php include_once "header.php" ?>
<?php
$default->ShowMessage();
?>
<?php include_once "footer.php" ?>
<?php
$default->Page_Terminate();
?>
