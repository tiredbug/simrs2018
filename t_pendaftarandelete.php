<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_pendaftaraninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_pendaftaran_delete = NULL; // Initialize page object first

class ct_pendaftaran_delete extends ct_pendaftaran {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_pendaftaran';

	// Page object name
	var $PageObjName = 't_pendaftaran_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
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
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
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

		// Parent constuctor
		parent::__construct();

		// Table object (t_pendaftaran)
		if (!isset($GLOBALS["t_pendaftaran"]) || get_class($GLOBALS["t_pendaftaran"]) == "ct_pendaftaran") {
			$GLOBALS["t_pendaftaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_pendaftaran"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_pendaftaran', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

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
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t_pendaftaranlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->PASIENBARU->SetVisibility();
		$this->NOMR->SetVisibility();
		$this->TGLREG->SetVisibility();
		$this->KDDOKTER->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->KDRUJUK->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->SHIFT->SetVisibility();
		$this->NIP->SetVisibility();
		$this->MASUKPOLY->SetVisibility();
		$this->KELUARPOLY->SetVisibility();
		$this->pasien_NAMA->SetVisibility();
		$this->pasien_TEMPAT->SetVisibility();
		$this->peserta_cob->SetVisibility();
		$this->poli_eksekutif->SetVisibility();

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
		global $EW_EXPORT, $t_pendaftaran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_pendaftaran);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t_pendaftaranlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_pendaftaran class, t_pendaftaraninfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t_pendaftaranlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NOJAMINAN->setDbValue($rs->fields('NOJAMINAN'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->KETERANGAN_STATUS->setDbValue($rs->fields('KETERANGAN_STATUS'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->MASUKPOLY->setDbValue($rs->fields('MASUKPOLY'));
		$this->KELUARPOLY->setDbValue($rs->fields('KELUARPOLY'));
		$this->KETRUJUK->setDbValue($rs->fields('KETRUJUK'));
		$this->KETBAYAR->setDbValue($rs->fields('KETBAYAR'));
		$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields('PENANGGUNGJAWAB_NAMA'));
		$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields('PENANGGUNGJAWAB_HUBUNGAN'));
		$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields('PENANGGUNGJAWAB_ALAMAT'));
		$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields('PENANGGUNGJAWAB_PHONE'));
		$this->JAMREG->setDbValue($rs->fields('JAMREG'));
		$this->BATAL->setDbValue($rs->fields('BATAL'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
		$this->NO_PESERTA->setDbValue($rs->fields('NO_PESERTA'));
		$this->NOKARTU->setDbValue($rs->fields('NOKARTU'));
		$this->TOTAL_BIAYA_OBAT->setDbValue($rs->fields('TOTAL_BIAYA_OBAT'));
		$this->biaya_obat->setDbValue($rs->fields('biaya_obat'));
		$this->biaya_retur_obat->setDbValue($rs->fields('biaya_retur_obat'));
		$this->TOTAL_BIAYA_OBAT_RAJAL->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_RAJAL'));
		$this->biaya_obat_rajal->setDbValue($rs->fields('biaya_obat_rajal'));
		$this->biaya_retur_obat_rajal->setDbValue($rs->fields('biaya_retur_obat_rajal'));
		$this->TOTAL_BIAYA_OBAT_IGD->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_IGD'));
		$this->biaya_obat_igd->setDbValue($rs->fields('biaya_obat_igd'));
		$this->biaya_retur_obat_igd->setDbValue($rs->fields('biaya_retur_obat_igd'));
		$this->TOTAL_BIAYA_OBAT_IBS->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_IBS'));
		$this->biaya_obat_ibs->setDbValue($rs->fields('biaya_obat_ibs'));
		$this->biaya_retur_obat_ibs->setDbValue($rs->fields('biaya_retur_obat_ibs'));
		$this->TANGGAL_SEP->setDbValue($rs->fields('TANGGAL_SEP'));
		$this->TANGGALRUJUK_SEP->setDbValue($rs->fields('TANGGALRUJUK_SEP'));
		$this->KELASRAWAT_SEP->setDbValue($rs->fields('KELASRAWAT_SEP'));
		$this->MINTA_RUJUKAN->setDbValue($rs->fields('MINTA_RUJUKAN'));
		$this->NORUJUKAN_SEP->setDbValue($rs->fields('NORUJUKAN_SEP'));
		$this->PPKRUJUKANASAL_SEP->setDbValue($rs->fields('PPKRUJUKANASAL_SEP'));
		$this->NAMAPPKRUJUKANASAL_SEP->setDbValue($rs->fields('NAMAPPKRUJUKANASAL_SEP'));
		$this->PPKPELAYANAN_SEP->setDbValue($rs->fields('PPKPELAYANAN_SEP'));
		$this->JENISPERAWATAN_SEP->setDbValue($rs->fields('JENISPERAWATAN_SEP'));
		$this->CATATAN_SEP->setDbValue($rs->fields('CATATAN_SEP'));
		$this->DIAGNOSAAWAL_SEP->setDbValue($rs->fields('DIAGNOSAAWAL_SEP'));
		$this->NAMADIAGNOSA_SEP->setDbValue($rs->fields('NAMADIAGNOSA_SEP'));
		$this->LAKALANTAS_SEP->setDbValue($rs->fields('LAKALANTAS_SEP'));
		$this->LOKASILAKALANTAS->setDbValue($rs->fields('LOKASILAKALANTAS'));
		$this->USER->setDbValue($rs->fields('USER'));
		$this->cek_data_kepesertaan->setDbValue($rs->fields('cek_data_kepesertaan'));
		$this->generate_sep->setDbValue($rs->fields('generate_sep'));
		$this->PESERTANIK_SEP->setDbValue($rs->fields('PESERTANIK_SEP'));
		$this->PESERTANAMA_SEP->setDbValue($rs->fields('PESERTANAMA_SEP'));
		$this->PESERTAJENISKELAMIN_SEP->setDbValue($rs->fields('PESERTAJENISKELAMIN_SEP'));
		$this->PESERTANAMAKELAS_SEP->setDbValue($rs->fields('PESERTANAMAKELAS_SEP'));
		$this->PESERTAPISAT->setDbValue($rs->fields('PESERTAPISAT'));
		$this->PESERTATGLLAHIR->setDbValue($rs->fields('PESERTATGLLAHIR'));
		$this->PESERTAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTAJENISPESERTA_SEP'));
		$this->PESERTANAMAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTANAMAJENISPESERTA_SEP'));
		$this->PESERTATGLCETAKKARTU_SEP->setDbValue($rs->fields('PESERTATGLCETAKKARTU_SEP'));
		$this->POLITUJUAN_SEP->setDbValue($rs->fields('POLITUJUAN_SEP'));
		$this->NAMAPOLITUJUAN_SEP->setDbValue($rs->fields('NAMAPOLITUJUAN_SEP'));
		$this->KDPPKRUJUKAN_SEP->setDbValue($rs->fields('KDPPKRUJUKAN_SEP'));
		$this->NMPPKRUJUKAN_SEP->setDbValue($rs->fields('NMPPKRUJUKAN_SEP'));
		$this->UPDATETGLPLNG_SEP->setDbValue($rs->fields('UPDATETGLPLNG_SEP'));
		$this->bridging_upt_tglplng->setDbValue($rs->fields('bridging_upt_tglplng'));
		$this->mapingtransaksi->setDbValue($rs->fields('mapingtransaksi'));
		$this->bridging_no_rujukan->setDbValue($rs->fields('bridging_no_rujukan'));
		$this->bridging_hapus_sep->setDbValue($rs->fields('bridging_hapus_sep'));
		$this->bridging_kepesertaan_by_no_ka->setDbValue($rs->fields('bridging_kepesertaan_by_no_ka'));
		$this->NOKARTU_BPJS->setDbValue($rs->fields('NOKARTU_BPJS'));
		$this->counter_cetak_kartu->setDbValue($rs->fields('counter_cetak_kartu'));
		$this->bridging_kepesertaan_by_nik->setDbValue($rs->fields('bridging_kepesertaan_by_nik'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->bridging_by_no_rujukan->setDbValue($rs->fields('bridging_by_no_rujukan'));
		$this->maping_hapus_sep->setDbValue($rs->fields('maping_hapus_sep'));
		$this->counter_cetak_kartu_ranap->setDbValue($rs->fields('counter_cetak_kartu_ranap'));
		$this->BIAYA_PENDAFTARAN->setDbValue($rs->fields('BIAYA_PENDAFTARAN'));
		$this->BIAYA_TINDAKAN_POLI->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI'));
		$this->BIAYA_TINDAKAN_RADIOLOGI->setDbValue($rs->fields('BIAYA_TINDAKAN_RADIOLOGI'));
		$this->BIAYA_TINDAKAN_LABORAT->setDbValue($rs->fields('BIAYA_TINDAKAN_LABORAT'));
		$this->BIAYA_TINDAKAN_KONSULTASI->setDbValue($rs->fields('BIAYA_TINDAKAN_KONSULTASI'));
		$this->BIAYA_TARIF_DOKTER->setDbValue($rs->fields('BIAYA_TARIF_DOKTER'));
		$this->BIAYA_TARIF_DOKTER_KONSUL->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_KONSUL'));
		$this->INCLUDE->setDbValue($rs->fields('INCLUDE'));
		$this->eklaim_kelas_rawat_rajal->setDbValue($rs->fields('eklaim_kelas_rawat_rajal'));
		$this->eklaim_adl_score->setDbValue($rs->fields('eklaim_adl_score'));
		$this->eklaim_adl_sub_acute->setDbValue($rs->fields('eklaim_adl_sub_acute'));
		$this->eklaim_adl_chronic->setDbValue($rs->fields('eklaim_adl_chronic'));
		$this->eklaim_icu_indikator->setDbValue($rs->fields('eklaim_icu_indikator'));
		$this->eklaim_icu_los->setDbValue($rs->fields('eklaim_icu_los'));
		$this->eklaim_ventilator_hour->setDbValue($rs->fields('eklaim_ventilator_hour'));
		$this->eklaim_upgrade_class_ind->setDbValue($rs->fields('eklaim_upgrade_class_ind'));
		$this->eklaim_upgrade_class_class->setDbValue($rs->fields('eklaim_upgrade_class_class'));
		$this->eklaim_upgrade_class_los->setDbValue($rs->fields('eklaim_upgrade_class_los'));
		$this->eklaim_birth_weight->setDbValue($rs->fields('eklaim_birth_weight'));
		$this->eklaim_discharge_status->setDbValue($rs->fields('eklaim_discharge_status'));
		$this->eklaim_diagnosa->setDbValue($rs->fields('eklaim_diagnosa'));
		$this->eklaim_procedure->setDbValue($rs->fields('eklaim_procedure'));
		$this->eklaim_tarif_rs->setDbValue($rs->fields('eklaim_tarif_rs'));
		$this->eklaim_tarif_poli_eks->setDbValue($rs->fields('eklaim_tarif_poli_eks'));
		$this->eklaim_id_dokter->setDbValue($rs->fields('eklaim_id_dokter'));
		$this->eklaim_nama_dokter->setDbValue($rs->fields('eklaim_nama_dokter'));
		$this->eklaim_kode_tarif->setDbValue($rs->fields('eklaim_kode_tarif'));
		$this->eklaim_payor_id->setDbValue($rs->fields('eklaim_payor_id'));
		$this->eklaim_payor_cd->setDbValue($rs->fields('eklaim_payor_cd'));
		$this->eklaim_coder_nik->setDbValue($rs->fields('eklaim_coder_nik'));
		$this->eklaim_los->setDbValue($rs->fields('eklaim_los'));
		$this->eklaim_patient_id->setDbValue($rs->fields('eklaim_patient_id'));
		$this->eklaim_admission_id->setDbValue($rs->fields('eklaim_admission_id'));
		$this->eklaim_hospital_admission_id->setDbValue($rs->fields('eklaim_hospital_admission_id'));
		$this->bridging_hapussep->setDbValue($rs->fields('bridging_hapussep'));
		$this->user_penghapus_sep->setDbValue($rs->fields('user_penghapus_sep'));
		$this->BIAYA_BILLING_RAJAL->setDbValue($rs->fields('BIAYA_BILLING_RAJAL'));
		$this->STATUS_PEMBAYARAN->setDbValue($rs->fields('STATUS_PEMBAYARAN'));
		$this->BIAYA_TINDAKAN_FISIOTERAPI->setDbValue($rs->fields('BIAYA_TINDAKAN_FISIOTERAPI'));
		$this->eklaim_reg_pasien->setDbValue($rs->fields('eklaim_reg_pasien'));
		$this->eklaim_reg_klaim_baru->setDbValue($rs->fields('eklaim_reg_klaim_baru'));
		$this->eklaim_gruper1->setDbValue($rs->fields('eklaim_gruper1'));
		$this->eklaim_gruper2->setDbValue($rs->fields('eklaim_gruper2'));
		$this->eklaim_finalklaim->setDbValue($rs->fields('eklaim_finalklaim'));
		$this->eklaim_sendklaim->setDbValue($rs->fields('eklaim_sendklaim'));
		$this->eklaim_flag_hapus_pasien->setDbValue($rs->fields('eklaim_flag_hapus_pasien'));
		$this->eklaim_flag_hapus_klaim->setDbValue($rs->fields('eklaim_flag_hapus_klaim'));
		$this->eklaim_kemkes_dc_Status->setDbValue($rs->fields('eklaim_kemkes_dc_Status'));
		$this->eklaim_bpjs_dc_Status->setDbValue($rs->fields('eklaim_bpjs_dc_Status'));
		$this->eklaim_cbg_code->setDbValue($rs->fields('eklaim_cbg_code'));
		$this->eklaim_cbg_descprition->setDbValue($rs->fields('eklaim_cbg_descprition'));
		$this->eklaim_cbg_tariff->setDbValue($rs->fields('eklaim_cbg_tariff'));
		$this->eklaim_sub_acute_code->setDbValue($rs->fields('eklaim_sub_acute_code'));
		$this->eklaim_sub_acute_deskripsi->setDbValue($rs->fields('eklaim_sub_acute_deskripsi'));
		$this->eklaim_sub_acute_tariff->setDbValue($rs->fields('eklaim_sub_acute_tariff'));
		$this->eklaim_chronic_code->setDbValue($rs->fields('eklaim_chronic_code'));
		$this->eklaim_chronic_deskripsi->setDbValue($rs->fields('eklaim_chronic_deskripsi'));
		$this->eklaim_chronic_tariff->setDbValue($rs->fields('eklaim_chronic_tariff'));
		$this->eklaim_inacbg_version->setDbValue($rs->fields('eklaim_inacbg_version'));
		$this->BIAYA_TINDAKAN_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_IBS_RAJAL'));
		$this->VERIFY_ICD->setDbValue($rs->fields('VERIFY_ICD'));
		$this->bridging_rujukan_faskes_2->setDbValue($rs->fields('bridging_rujukan_faskes_2'));
		$this->eklaim_reedit_claim->setDbValue($rs->fields('eklaim_reedit_claim'));
		$this->KETERANGAN->setDbValue($rs->fields('KETERANGAN'));
		$this->TGLLAHIR->setDbValue($rs->fields('TGLLAHIR'));
		$this->USER_KASIR->setDbValue($rs->fields('USER_KASIR'));
		$this->eklaim_tgl_gruping->setDbValue($rs->fields('eklaim_tgl_gruping'));
		$this->eklaim_tgl_finalklaim->setDbValue($rs->fields('eklaim_tgl_finalklaim'));
		$this->eklaim_tgl_kirim_klaim->setDbValue($rs->fields('eklaim_tgl_kirim_klaim'));
		$this->BIAYA_OBAT_RS->setDbValue($rs->fields('BIAYA_OBAT_RS'));
		$this->EKG_RAJAL->setDbValue($rs->fields('EKG_RAJAL'));
		$this->USG_RAJAL->setDbValue($rs->fields('USG_RAJAL'));
		$this->FISIOTERAPI_RAJAL->setDbValue($rs->fields('FISIOTERAPI_RAJAL'));
		$this->BHP_RAJAL->setDbValue($rs->fields('BHP_RAJAL'));
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_ASKEP_IBS_RAJAL'));
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_TMNO_IBS_RAJAL'));
		$this->TOTAL_BIAYA_IBS_RAJAL->setDbValue($rs->fields('TOTAL_BIAYA_IBS_RAJAL'));
		$this->ORDER_LAB->setDbValue($rs->fields('ORDER_LAB'));
		$this->BILL_RAJAL_SELESAI->setDbValue($rs->fields('BILL_RAJAL_SELESAI'));
		$this->INCLUDE_IDXDAFTAR->setDbValue($rs->fields('INCLUDE_IDXDAFTAR'));
		$this->INCLUDE_HARGA->setDbValue($rs->fields('INCLUDE_HARGA'));
		$this->TARIF_JASA_SARANA->setDbValue($rs->fields('TARIF_JASA_SARANA'));
		$this->TARIF_PENUNJANG_NON_MEDIS->setDbValue($rs->fields('TARIF_PENUNJANG_NON_MEDIS'));
		$this->TARIF_ASUHAN_KEPERAWATAN->setDbValue($rs->fields('TARIF_ASUHAN_KEPERAWATAN'));
		$this->KDDOKTER_RAJAL->setDbValue($rs->fields('KDDOKTER_RAJAL'));
		$this->KDDOKTER_KONSUL_RAJAL->setDbValue($rs->fields('KDDOKTER_KONSUL_RAJAL'));
		$this->BIAYA_BILLING_RS->setDbValue($rs->fields('BIAYA_BILLING_RS'));
		$this->BIAYA_TINDAKAN_POLI_TMO->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_TMO'));
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_KEPERAWATAN'));
		$this->BHP_RAJAL_TMO->setDbValue($rs->fields('BHP_RAJAL_TMO'));
		$this->BHP_RAJAL_KEPERAWATAN->setDbValue($rs->fields('BHP_RAJAL_KEPERAWATAN'));
		$this->TARIF_AKOMODASI->setDbValue($rs->fields('TARIF_AKOMODASI'));
		$this->TARIF_AMBULAN->setDbValue($rs->fields('TARIF_AMBULAN'));
		$this->TARIF_OKSIGEN->setDbValue($rs->fields('TARIF_OKSIGEN'));
		$this->BIAYA_TINDAKAN_JENAZAH->setDbValue($rs->fields('BIAYA_TINDAKAN_JENAZAH'));
		$this->BIAYA_BILLING_IGD->setDbValue($rs->fields('BIAYA_BILLING_IGD'));
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_PERSALINAN'));
		$this->BHP_RAJAL_PERSALINAN->setDbValue($rs->fields('BHP_RAJAL_PERSALINAN'));
		$this->TARIF_BIMBINGAN_ROHANI->setDbValue($rs->fields('TARIF_BIMBINGAN_ROHANI'));
		$this->BIAYA_BILLING_RS2->setDbValue($rs->fields('BIAYA_BILLING_RS2'));
		$this->BIAYA_TARIF_DOKTER_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_IGD'));
		$this->BIAYA_PENDAFTARAN_IGD->setDbValue($rs->fields('BIAYA_PENDAFTARAN_IGD'));
		$this->BIAYA_BILLING_IBS->setDbValue($rs->fields('BIAYA_BILLING_IBS'));
		$this->TARIF_JASA_SARANA_IGD->setDbValue($rs->fields('TARIF_JASA_SARANA_IGD'));
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_SPESIALIS_IGD'));
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_KONSUL_IGD'));
		$this->TARIF_MAKAN_IGD->setDbValue($rs->fields('TARIF_MAKAN_IGD'));
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->setDbValue($rs->fields('TARIF_ASUHAN_KEPERAWATAN_IGD'));
		$this->pasien_TITLE->setDbValue($rs->fields('pasien_TITLE'));
		$this->pasien_NAMA->setDbValue($rs->fields('pasien_NAMA'));
		$this->pasien_TEMPAT->setDbValue($rs->fields('pasien_TEMPAT'));
		$this->pasien_TGLLAHIR->setDbValue($rs->fields('pasien_TGLLAHIR'));
		$this->pasien_JENISKELAMIN->setDbValue($rs->fields('pasien_JENISKELAMIN'));
		$this->pasien_ALAMAT->setDbValue($rs->fields('pasien_ALAMAT'));
		$this->pasien_KELURAHAN->setDbValue($rs->fields('pasien_KELURAHAN'));
		$this->pasien_KDKECAMATAN->setDbValue($rs->fields('pasien_KDKECAMATAN'));
		$this->pasien_KOTA->setDbValue($rs->fields('pasien_KOTA'));
		$this->pasien_KDPROVINSI->setDbValue($rs->fields('pasien_KDPROVINSI'));
		$this->pasien_NOTELP->setDbValue($rs->fields('pasien_NOTELP'));
		$this->pasien_NOKTP->setDbValue($rs->fields('pasien_NOKTP'));
		$this->pasien_SUAMI_ORTU->setDbValue($rs->fields('pasien_SUAMI_ORTU'));
		$this->pasien_PEKERJAAN->setDbValue($rs->fields('pasien_PEKERJAAN'));
		$this->pasien_AGAMA->setDbValue($rs->fields('pasien_AGAMA'));
		$this->pasien_PENDIDIKAN->setDbValue($rs->fields('pasien_PENDIDIKAN'));
		$this->pasien_ALAMAT_KTP->setDbValue($rs->fields('pasien_ALAMAT_KTP'));
		$this->pasien_NO_KARTU->setDbValue($rs->fields('pasien_NO_KARTU'));
		$this->pasien_JNS_PASIEN->setDbValue($rs->fields('pasien_JNS_PASIEN'));
		$this->pasien_nama_ayah->setDbValue($rs->fields('pasien_nama_ayah'));
		$this->pasien_nama_ibu->setDbValue($rs->fields('pasien_nama_ibu'));
		$this->pasien_nama_suami->setDbValue($rs->fields('pasien_nama_suami'));
		$this->pasien_nama_istri->setDbValue($rs->fields('pasien_nama_istri'));
		$this->pasien_KD_ETNIS->setDbValue($rs->fields('pasien_KD_ETNIS'));
		$this->pasien_KD_BHS_HARIAN->setDbValue($rs->fields('pasien_KD_BHS_HARIAN'));
		$this->BILL_FARMASI_SELESAI->setDbValue($rs->fields('BILL_FARMASI_SELESAI'));
		$this->TARIF_PELAYANAN_SIMRS->setDbValue($rs->fields('TARIF_PELAYANAN_SIMRS'));
		$this->USER_ADM->setDbValue($rs->fields('USER_ADM'));
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->setDbValue($rs->fields('TARIF_PENUNJANG_NON_MEDIS_IGD'));
		$this->TARIF_PELAYANAN_DARAH->setDbValue($rs->fields('TARIF_PELAYANAN_DARAH'));
		$this->penjamin_kkl_id->setDbValue($rs->fields('penjamin_kkl_id'));
		$this->asalfaskesrujukan_id->setDbValue($rs->fields('asalfaskesrujukan_id'));
		$this->peserta_cob->setDbValue($rs->fields('peserta_cob'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->status_kepesertaan_BPJS->setDbValue($rs->fields('status_kepesertaan_BPJS'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->PASIENBARU->DbValue = $row['PASIENBARU'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->KDDOKTER->DbValue = $row['KDDOKTER'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NOJAMINAN->DbValue = $row['NOJAMINAN'];
		$this->SHIFT->DbValue = $row['SHIFT'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->KETERANGAN_STATUS->DbValue = $row['KETERANGAN_STATUS'];
		$this->NIP->DbValue = $row['NIP'];
		$this->MASUKPOLY->DbValue = $row['MASUKPOLY'];
		$this->KELUARPOLY->DbValue = $row['KELUARPOLY'];
		$this->KETRUJUK->DbValue = $row['KETRUJUK'];
		$this->KETBAYAR->DbValue = $row['KETBAYAR'];
		$this->PENANGGUNGJAWAB_NAMA->DbValue = $row['PENANGGUNGJAWAB_NAMA'];
		$this->PENANGGUNGJAWAB_HUBUNGAN->DbValue = $row['PENANGGUNGJAWAB_HUBUNGAN'];
		$this->PENANGGUNGJAWAB_ALAMAT->DbValue = $row['PENANGGUNGJAWAB_ALAMAT'];
		$this->PENANGGUNGJAWAB_PHONE->DbValue = $row['PENANGGUNGJAWAB_PHONE'];
		$this->JAMREG->DbValue = $row['JAMREG'];
		$this->BATAL->DbValue = $row['BATAL'];
		$this->NO_SJP->DbValue = $row['NO_SJP'];
		$this->NO_PESERTA->DbValue = $row['NO_PESERTA'];
		$this->NOKARTU->DbValue = $row['NOKARTU'];
		$this->TOTAL_BIAYA_OBAT->DbValue = $row['TOTAL_BIAYA_OBAT'];
		$this->biaya_obat->DbValue = $row['biaya_obat'];
		$this->biaya_retur_obat->DbValue = $row['biaya_retur_obat'];
		$this->TOTAL_BIAYA_OBAT_RAJAL->DbValue = $row['TOTAL_BIAYA_OBAT_RAJAL'];
		$this->biaya_obat_rajal->DbValue = $row['biaya_obat_rajal'];
		$this->biaya_retur_obat_rajal->DbValue = $row['biaya_retur_obat_rajal'];
		$this->TOTAL_BIAYA_OBAT_IGD->DbValue = $row['TOTAL_BIAYA_OBAT_IGD'];
		$this->biaya_obat_igd->DbValue = $row['biaya_obat_igd'];
		$this->biaya_retur_obat_igd->DbValue = $row['biaya_retur_obat_igd'];
		$this->TOTAL_BIAYA_OBAT_IBS->DbValue = $row['TOTAL_BIAYA_OBAT_IBS'];
		$this->biaya_obat_ibs->DbValue = $row['biaya_obat_ibs'];
		$this->biaya_retur_obat_ibs->DbValue = $row['biaya_retur_obat_ibs'];
		$this->TANGGAL_SEP->DbValue = $row['TANGGAL_SEP'];
		$this->TANGGALRUJUK_SEP->DbValue = $row['TANGGALRUJUK_SEP'];
		$this->KELASRAWAT_SEP->DbValue = $row['KELASRAWAT_SEP'];
		$this->MINTA_RUJUKAN->DbValue = $row['MINTA_RUJUKAN'];
		$this->NORUJUKAN_SEP->DbValue = $row['NORUJUKAN_SEP'];
		$this->PPKRUJUKANASAL_SEP->DbValue = $row['PPKRUJUKANASAL_SEP'];
		$this->NAMAPPKRUJUKANASAL_SEP->DbValue = $row['NAMAPPKRUJUKANASAL_SEP'];
		$this->PPKPELAYANAN_SEP->DbValue = $row['PPKPELAYANAN_SEP'];
		$this->JENISPERAWATAN_SEP->DbValue = $row['JENISPERAWATAN_SEP'];
		$this->CATATAN_SEP->DbValue = $row['CATATAN_SEP'];
		$this->DIAGNOSAAWAL_SEP->DbValue = $row['DIAGNOSAAWAL_SEP'];
		$this->NAMADIAGNOSA_SEP->DbValue = $row['NAMADIAGNOSA_SEP'];
		$this->LAKALANTAS_SEP->DbValue = $row['LAKALANTAS_SEP'];
		$this->LOKASILAKALANTAS->DbValue = $row['LOKASILAKALANTAS'];
		$this->USER->DbValue = $row['USER'];
		$this->cek_data_kepesertaan->DbValue = $row['cek_data_kepesertaan'];
		$this->generate_sep->DbValue = $row['generate_sep'];
		$this->PESERTANIK_SEP->DbValue = $row['PESERTANIK_SEP'];
		$this->PESERTANAMA_SEP->DbValue = $row['PESERTANAMA_SEP'];
		$this->PESERTAJENISKELAMIN_SEP->DbValue = $row['PESERTAJENISKELAMIN_SEP'];
		$this->PESERTANAMAKELAS_SEP->DbValue = $row['PESERTANAMAKELAS_SEP'];
		$this->PESERTAPISAT->DbValue = $row['PESERTAPISAT'];
		$this->PESERTATGLLAHIR->DbValue = $row['PESERTATGLLAHIR'];
		$this->PESERTAJENISPESERTA_SEP->DbValue = $row['PESERTAJENISPESERTA_SEP'];
		$this->PESERTANAMAJENISPESERTA_SEP->DbValue = $row['PESERTANAMAJENISPESERTA_SEP'];
		$this->PESERTATGLCETAKKARTU_SEP->DbValue = $row['PESERTATGLCETAKKARTU_SEP'];
		$this->POLITUJUAN_SEP->DbValue = $row['POLITUJUAN_SEP'];
		$this->NAMAPOLITUJUAN_SEP->DbValue = $row['NAMAPOLITUJUAN_SEP'];
		$this->KDPPKRUJUKAN_SEP->DbValue = $row['KDPPKRUJUKAN_SEP'];
		$this->NMPPKRUJUKAN_SEP->DbValue = $row['NMPPKRUJUKAN_SEP'];
		$this->UPDATETGLPLNG_SEP->DbValue = $row['UPDATETGLPLNG_SEP'];
		$this->bridging_upt_tglplng->DbValue = $row['bridging_upt_tglplng'];
		$this->mapingtransaksi->DbValue = $row['mapingtransaksi'];
		$this->bridging_no_rujukan->DbValue = $row['bridging_no_rujukan'];
		$this->bridging_hapus_sep->DbValue = $row['bridging_hapus_sep'];
		$this->bridging_kepesertaan_by_no_ka->DbValue = $row['bridging_kepesertaan_by_no_ka'];
		$this->NOKARTU_BPJS->DbValue = $row['NOKARTU_BPJS'];
		$this->counter_cetak_kartu->DbValue = $row['counter_cetak_kartu'];
		$this->bridging_kepesertaan_by_nik->DbValue = $row['bridging_kepesertaan_by_nik'];
		$this->NOKTP->DbValue = $row['NOKTP'];
		$this->bridging_by_no_rujukan->DbValue = $row['bridging_by_no_rujukan'];
		$this->maping_hapus_sep->DbValue = $row['maping_hapus_sep'];
		$this->counter_cetak_kartu_ranap->DbValue = $row['counter_cetak_kartu_ranap'];
		$this->BIAYA_PENDAFTARAN->DbValue = $row['BIAYA_PENDAFTARAN'];
		$this->BIAYA_TINDAKAN_POLI->DbValue = $row['BIAYA_TINDAKAN_POLI'];
		$this->BIAYA_TINDAKAN_RADIOLOGI->DbValue = $row['BIAYA_TINDAKAN_RADIOLOGI'];
		$this->BIAYA_TINDAKAN_LABORAT->DbValue = $row['BIAYA_TINDAKAN_LABORAT'];
		$this->BIAYA_TINDAKAN_KONSULTASI->DbValue = $row['BIAYA_TINDAKAN_KONSULTASI'];
		$this->BIAYA_TARIF_DOKTER->DbValue = $row['BIAYA_TARIF_DOKTER'];
		$this->BIAYA_TARIF_DOKTER_KONSUL->DbValue = $row['BIAYA_TARIF_DOKTER_KONSUL'];
		$this->INCLUDE->DbValue = $row['INCLUDE'];
		$this->eklaim_kelas_rawat_rajal->DbValue = $row['eklaim_kelas_rawat_rajal'];
		$this->eklaim_adl_score->DbValue = $row['eklaim_adl_score'];
		$this->eklaim_adl_sub_acute->DbValue = $row['eklaim_adl_sub_acute'];
		$this->eklaim_adl_chronic->DbValue = $row['eklaim_adl_chronic'];
		$this->eklaim_icu_indikator->DbValue = $row['eklaim_icu_indikator'];
		$this->eklaim_icu_los->DbValue = $row['eklaim_icu_los'];
		$this->eklaim_ventilator_hour->DbValue = $row['eklaim_ventilator_hour'];
		$this->eklaim_upgrade_class_ind->DbValue = $row['eklaim_upgrade_class_ind'];
		$this->eklaim_upgrade_class_class->DbValue = $row['eklaim_upgrade_class_class'];
		$this->eklaim_upgrade_class_los->DbValue = $row['eklaim_upgrade_class_los'];
		$this->eklaim_birth_weight->DbValue = $row['eklaim_birth_weight'];
		$this->eklaim_discharge_status->DbValue = $row['eklaim_discharge_status'];
		$this->eklaim_diagnosa->DbValue = $row['eklaim_diagnosa'];
		$this->eklaim_procedure->DbValue = $row['eklaim_procedure'];
		$this->eklaim_tarif_rs->DbValue = $row['eklaim_tarif_rs'];
		$this->eklaim_tarif_poli_eks->DbValue = $row['eklaim_tarif_poli_eks'];
		$this->eklaim_id_dokter->DbValue = $row['eklaim_id_dokter'];
		$this->eklaim_nama_dokter->DbValue = $row['eklaim_nama_dokter'];
		$this->eklaim_kode_tarif->DbValue = $row['eklaim_kode_tarif'];
		$this->eklaim_payor_id->DbValue = $row['eklaim_payor_id'];
		$this->eklaim_payor_cd->DbValue = $row['eklaim_payor_cd'];
		$this->eklaim_coder_nik->DbValue = $row['eklaim_coder_nik'];
		$this->eklaim_los->DbValue = $row['eklaim_los'];
		$this->eklaim_patient_id->DbValue = $row['eklaim_patient_id'];
		$this->eklaim_admission_id->DbValue = $row['eklaim_admission_id'];
		$this->eklaim_hospital_admission_id->DbValue = $row['eklaim_hospital_admission_id'];
		$this->bridging_hapussep->DbValue = $row['bridging_hapussep'];
		$this->user_penghapus_sep->DbValue = $row['user_penghapus_sep'];
		$this->BIAYA_BILLING_RAJAL->DbValue = $row['BIAYA_BILLING_RAJAL'];
		$this->STATUS_PEMBAYARAN->DbValue = $row['STATUS_PEMBAYARAN'];
		$this->BIAYA_TINDAKAN_FISIOTERAPI->DbValue = $row['BIAYA_TINDAKAN_FISIOTERAPI'];
		$this->eklaim_reg_pasien->DbValue = $row['eklaim_reg_pasien'];
		$this->eklaim_reg_klaim_baru->DbValue = $row['eklaim_reg_klaim_baru'];
		$this->eklaim_gruper1->DbValue = $row['eklaim_gruper1'];
		$this->eklaim_gruper2->DbValue = $row['eklaim_gruper2'];
		$this->eklaim_finalklaim->DbValue = $row['eklaim_finalklaim'];
		$this->eklaim_sendklaim->DbValue = $row['eklaim_sendklaim'];
		$this->eklaim_flag_hapus_pasien->DbValue = $row['eklaim_flag_hapus_pasien'];
		$this->eklaim_flag_hapus_klaim->DbValue = $row['eklaim_flag_hapus_klaim'];
		$this->eklaim_kemkes_dc_Status->DbValue = $row['eklaim_kemkes_dc_Status'];
		$this->eklaim_bpjs_dc_Status->DbValue = $row['eklaim_bpjs_dc_Status'];
		$this->eklaim_cbg_code->DbValue = $row['eklaim_cbg_code'];
		$this->eklaim_cbg_descprition->DbValue = $row['eklaim_cbg_descprition'];
		$this->eklaim_cbg_tariff->DbValue = $row['eklaim_cbg_tariff'];
		$this->eklaim_sub_acute_code->DbValue = $row['eklaim_sub_acute_code'];
		$this->eklaim_sub_acute_deskripsi->DbValue = $row['eklaim_sub_acute_deskripsi'];
		$this->eklaim_sub_acute_tariff->DbValue = $row['eklaim_sub_acute_tariff'];
		$this->eklaim_chronic_code->DbValue = $row['eklaim_chronic_code'];
		$this->eklaim_chronic_deskripsi->DbValue = $row['eklaim_chronic_deskripsi'];
		$this->eklaim_chronic_tariff->DbValue = $row['eklaim_chronic_tariff'];
		$this->eklaim_inacbg_version->DbValue = $row['eklaim_inacbg_version'];
		$this->BIAYA_TINDAKAN_IBS_RAJAL->DbValue = $row['BIAYA_TINDAKAN_IBS_RAJAL'];
		$this->VERIFY_ICD->DbValue = $row['VERIFY_ICD'];
		$this->bridging_rujukan_faskes_2->DbValue = $row['bridging_rujukan_faskes_2'];
		$this->eklaim_reedit_claim->DbValue = $row['eklaim_reedit_claim'];
		$this->KETERANGAN->DbValue = $row['KETERANGAN'];
		$this->TGLLAHIR->DbValue = $row['TGLLAHIR'];
		$this->USER_KASIR->DbValue = $row['USER_KASIR'];
		$this->eklaim_tgl_gruping->DbValue = $row['eklaim_tgl_gruping'];
		$this->eklaim_tgl_finalklaim->DbValue = $row['eklaim_tgl_finalklaim'];
		$this->eklaim_tgl_kirim_klaim->DbValue = $row['eklaim_tgl_kirim_klaim'];
		$this->BIAYA_OBAT_RS->DbValue = $row['BIAYA_OBAT_RS'];
		$this->EKG_RAJAL->DbValue = $row['EKG_RAJAL'];
		$this->USG_RAJAL->DbValue = $row['USG_RAJAL'];
		$this->FISIOTERAPI_RAJAL->DbValue = $row['FISIOTERAPI_RAJAL'];
		$this->BHP_RAJAL->DbValue = $row['BHP_RAJAL'];
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->DbValue = $row['BIAYA_TINDAKAN_ASKEP_IBS_RAJAL'];
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->DbValue = $row['BIAYA_TINDAKAN_TMNO_IBS_RAJAL'];
		$this->TOTAL_BIAYA_IBS_RAJAL->DbValue = $row['TOTAL_BIAYA_IBS_RAJAL'];
		$this->ORDER_LAB->DbValue = $row['ORDER_LAB'];
		$this->BILL_RAJAL_SELESAI->DbValue = $row['BILL_RAJAL_SELESAI'];
		$this->INCLUDE_IDXDAFTAR->DbValue = $row['INCLUDE_IDXDAFTAR'];
		$this->INCLUDE_HARGA->DbValue = $row['INCLUDE_HARGA'];
		$this->TARIF_JASA_SARANA->DbValue = $row['TARIF_JASA_SARANA'];
		$this->TARIF_PENUNJANG_NON_MEDIS->DbValue = $row['TARIF_PENUNJANG_NON_MEDIS'];
		$this->TARIF_ASUHAN_KEPERAWATAN->DbValue = $row['TARIF_ASUHAN_KEPERAWATAN'];
		$this->KDDOKTER_RAJAL->DbValue = $row['KDDOKTER_RAJAL'];
		$this->KDDOKTER_KONSUL_RAJAL->DbValue = $row['KDDOKTER_KONSUL_RAJAL'];
		$this->BIAYA_BILLING_RS->DbValue = $row['BIAYA_BILLING_RS'];
		$this->BIAYA_TINDAKAN_POLI_TMO->DbValue = $row['BIAYA_TINDAKAN_POLI_TMO'];
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->DbValue = $row['BIAYA_TINDAKAN_POLI_KEPERAWATAN'];
		$this->BHP_RAJAL_TMO->DbValue = $row['BHP_RAJAL_TMO'];
		$this->BHP_RAJAL_KEPERAWATAN->DbValue = $row['BHP_RAJAL_KEPERAWATAN'];
		$this->TARIF_AKOMODASI->DbValue = $row['TARIF_AKOMODASI'];
		$this->TARIF_AMBULAN->DbValue = $row['TARIF_AMBULAN'];
		$this->TARIF_OKSIGEN->DbValue = $row['TARIF_OKSIGEN'];
		$this->BIAYA_TINDAKAN_JENAZAH->DbValue = $row['BIAYA_TINDAKAN_JENAZAH'];
		$this->BIAYA_BILLING_IGD->DbValue = $row['BIAYA_BILLING_IGD'];
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->DbValue = $row['BIAYA_TINDAKAN_POLI_PERSALINAN'];
		$this->BHP_RAJAL_PERSALINAN->DbValue = $row['BHP_RAJAL_PERSALINAN'];
		$this->TARIF_BIMBINGAN_ROHANI->DbValue = $row['TARIF_BIMBINGAN_ROHANI'];
		$this->BIAYA_BILLING_RS2->DbValue = $row['BIAYA_BILLING_RS2'];
		$this->BIAYA_TARIF_DOKTER_IGD->DbValue = $row['BIAYA_TARIF_DOKTER_IGD'];
		$this->BIAYA_PENDAFTARAN_IGD->DbValue = $row['BIAYA_PENDAFTARAN_IGD'];
		$this->BIAYA_BILLING_IBS->DbValue = $row['BIAYA_BILLING_IBS'];
		$this->TARIF_JASA_SARANA_IGD->DbValue = $row['TARIF_JASA_SARANA_IGD'];
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->DbValue = $row['BIAYA_TARIF_DOKTER_SPESIALIS_IGD'];
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->DbValue = $row['BIAYA_TARIF_DOKTER_KONSUL_IGD'];
		$this->TARIF_MAKAN_IGD->DbValue = $row['TARIF_MAKAN_IGD'];
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->DbValue = $row['TARIF_ASUHAN_KEPERAWATAN_IGD'];
		$this->pasien_TITLE->DbValue = $row['pasien_TITLE'];
		$this->pasien_NAMA->DbValue = $row['pasien_NAMA'];
		$this->pasien_TEMPAT->DbValue = $row['pasien_TEMPAT'];
		$this->pasien_TGLLAHIR->DbValue = $row['pasien_TGLLAHIR'];
		$this->pasien_JENISKELAMIN->DbValue = $row['pasien_JENISKELAMIN'];
		$this->pasien_ALAMAT->DbValue = $row['pasien_ALAMAT'];
		$this->pasien_KELURAHAN->DbValue = $row['pasien_KELURAHAN'];
		$this->pasien_KDKECAMATAN->DbValue = $row['pasien_KDKECAMATAN'];
		$this->pasien_KOTA->DbValue = $row['pasien_KOTA'];
		$this->pasien_KDPROVINSI->DbValue = $row['pasien_KDPROVINSI'];
		$this->pasien_NOTELP->DbValue = $row['pasien_NOTELP'];
		$this->pasien_NOKTP->DbValue = $row['pasien_NOKTP'];
		$this->pasien_SUAMI_ORTU->DbValue = $row['pasien_SUAMI_ORTU'];
		$this->pasien_PEKERJAAN->DbValue = $row['pasien_PEKERJAAN'];
		$this->pasien_AGAMA->DbValue = $row['pasien_AGAMA'];
		$this->pasien_PENDIDIKAN->DbValue = $row['pasien_PENDIDIKAN'];
		$this->pasien_ALAMAT_KTP->DbValue = $row['pasien_ALAMAT_KTP'];
		$this->pasien_NO_KARTU->DbValue = $row['pasien_NO_KARTU'];
		$this->pasien_JNS_PASIEN->DbValue = $row['pasien_JNS_PASIEN'];
		$this->pasien_nama_ayah->DbValue = $row['pasien_nama_ayah'];
		$this->pasien_nama_ibu->DbValue = $row['pasien_nama_ibu'];
		$this->pasien_nama_suami->DbValue = $row['pasien_nama_suami'];
		$this->pasien_nama_istri->DbValue = $row['pasien_nama_istri'];
		$this->pasien_KD_ETNIS->DbValue = $row['pasien_KD_ETNIS'];
		$this->pasien_KD_BHS_HARIAN->DbValue = $row['pasien_KD_BHS_HARIAN'];
		$this->BILL_FARMASI_SELESAI->DbValue = $row['BILL_FARMASI_SELESAI'];
		$this->TARIF_PELAYANAN_SIMRS->DbValue = $row['TARIF_PELAYANAN_SIMRS'];
		$this->USER_ADM->DbValue = $row['USER_ADM'];
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->DbValue = $row['TARIF_PENUNJANG_NON_MEDIS_IGD'];
		$this->TARIF_PELAYANAN_DARAH->DbValue = $row['TARIF_PELAYANAN_DARAH'];
		$this->penjamin_kkl_id->DbValue = $row['penjamin_kkl_id'];
		$this->asalfaskesrujukan_id->DbValue = $row['asalfaskesrujukan_id'];
		$this->peserta_cob->DbValue = $row['peserta_cob'];
		$this->poli_eksekutif->DbValue = $row['poli_eksekutif'];
		$this->status_kepesertaan_BPJS->DbValue = $row['status_kepesertaan_BPJS'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXDAFTAR

		$this->IDXDAFTAR->CellCssStyle = "white-space: nowrap;";

		// PASIENBARU
		$this->PASIENBARU->CellCssStyle = "white-space: nowrap;";

		// NOMR
		$this->NOMR->CellCssStyle = "white-space: nowrap;";

		// TGLREG
		$this->TGLREG->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER
		$this->KDDOKTER->CellCssStyle = "white-space: nowrap;";

		// KDPOLY
		$this->KDPOLY->CellCssStyle = "white-space: nowrap;";

		// KDRUJUK
		$this->KDRUJUK->CellCssStyle = "white-space: nowrap;";

		// KDCARABAYAR
		$this->KDCARABAYAR->CellCssStyle = "white-space: nowrap;";

		// NOJAMINAN
		$this->NOJAMINAN->CellCssStyle = "white-space: nowrap;";

		// SHIFT
		$this->SHIFT->CellCssStyle = "white-space: nowrap;";

		// STATUS
		$this->STATUS->CellCssStyle = "white-space: nowrap;";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->CellCssStyle = "white-space: nowrap;";

		// NIP
		$this->NIP->CellCssStyle = "white-space: nowrap;";

		// MASUKPOLY
		$this->MASUKPOLY->CellCssStyle = "white-space: nowrap;";

		// KELUARPOLY
		$this->KELUARPOLY->CellCssStyle = "white-space: nowrap;";

		// KETRUJUK
		$this->KETRUJUK->CellCssStyle = "white-space: nowrap;";

		// KETBAYAR
		$this->KETBAYAR->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->CellCssStyle = "white-space: nowrap;";

		// JAMREG
		$this->JAMREG->CellCssStyle = "white-space: nowrap;";

		// BATAL
		$this->BATAL->CellCssStyle = "white-space: nowrap;";

		// NO_SJP
		$this->NO_SJP->CellCssStyle = "white-space: nowrap;";

		// NO_PESERTA
		$this->NO_PESERTA->CellCssStyle = "white-space: nowrap;";

		// NOKARTU
		$this->NOKARTU->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->CellCssStyle = "white-space: nowrap;";

		// biaya_obat
		$this->biaya_obat->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat
		$this->biaya_retur_obat->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_rajal
		$this->biaya_obat_rajal->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_igd
		$this->biaya_obat_igd->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_ibs
		$this->biaya_obat_ibs->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->CellCssStyle = "white-space: nowrap;";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->CellCssStyle = "white-space: nowrap;";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->CellCssStyle = "white-space: nowrap;";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->CellCssStyle = "white-space: nowrap;";

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->CellCssStyle = "white-space: nowrap;";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->CellCssStyle = "white-space: nowrap;";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->CellCssStyle = "white-space: nowrap;";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->CellCssStyle = "white-space: nowrap;";

		// CATATAN_SEP
		$this->CATATAN_SEP->CellCssStyle = "white-space: nowrap;";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->CellCssStyle = "white-space: nowrap;";

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->CellCssStyle = "white-space: nowrap;";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->CellCssStyle = "white-space: nowrap;";

		// USER
		$this->USER->CellCssStyle = "white-space: nowrap;";

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->CellCssStyle = "white-space: nowrap;";

		// generate_sep
		$this->generate_sep->CellCssStyle = "white-space: nowrap;";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTAPISAT
		$this->PESERTAPISAT->CellCssStyle = "white-space: nowrap;";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->CellCssStyle = "white-space: nowrap;";

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->CellCssStyle = "white-space: nowrap;";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->CellCssStyle = "white-space: nowrap;";

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->CellCssStyle = "white-space: nowrap;";

		// mapingtransaksi
		$this->mapingtransaksi->CellCssStyle = "white-space: nowrap;";

		// bridging_no_rujukan
		$this->bridging_no_rujukan->CellCssStyle = "white-space: nowrap;";

		// bridging_hapus_sep
		$this->bridging_hapus_sep->CellCssStyle = "white-space: nowrap;";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->CellCssStyle = "white-space: nowrap;";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->CellCssStyle = "white-space: nowrap;";

		// counter_cetak_kartu
		$this->counter_cetak_kartu->CellCssStyle = "white-space: nowrap;";

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->CellCssStyle = "white-space: nowrap;";

		// NOKTP
		$this->NOKTP->CellCssStyle = "white-space: nowrap;";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->CellCssStyle = "white-space: nowrap;";

		// maping_hapus_sep
		$this->maping_hapus_sep->CellCssStyle = "white-space: nowrap;";

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->CellCssStyle = "white-space: nowrap;";

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->CellCssStyle = "white-space: nowrap;";

		// INCLUDE
		$this->INCLUDE->CellCssStyle = "white-space: nowrap;";

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_score
		$this->eklaim_adl_score->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->CellCssStyle = "white-space: nowrap;";

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->CellCssStyle = "white-space: nowrap;";

		// eklaim_icu_los
		$this->eklaim_icu_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_birth_weight
		$this->eklaim_birth_weight->CellCssStyle = "white-space: nowrap;";

		// eklaim_discharge_status
		$this->eklaim_discharge_status->CellCssStyle = "white-space: nowrap;";

		// eklaim_diagnosa
		$this->eklaim_diagnosa->CellCssStyle = "white-space: nowrap;";

		// eklaim_procedure
		$this->eklaim_procedure->CellCssStyle = "white-space: nowrap;";

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->CellCssStyle = "white-space: nowrap;";

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->CellCssStyle = "white-space: nowrap;";

		// eklaim_id_dokter
		$this->eklaim_id_dokter->CellCssStyle = "white-space: nowrap;";

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->CellCssStyle = "white-space: nowrap;";

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->CellCssStyle = "white-space: nowrap;";

		// eklaim_payor_id
		$this->eklaim_payor_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_payor_cd
		$this->eklaim_payor_cd->CellCssStyle = "white-space: nowrap;";

		// eklaim_coder_nik
		$this->eklaim_coder_nik->CellCssStyle = "white-space: nowrap;";

		// eklaim_los
		$this->eklaim_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_patient_id
		$this->eklaim_patient_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_admission_id
		$this->eklaim_admission_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->CellCssStyle = "white-space: nowrap;";

		// bridging_hapussep
		$this->bridging_hapussep->CellCssStyle = "white-space: nowrap;";

		// user_penghapus_sep
		$this->user_penghapus_sep->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->CellCssStyle = "white-space: nowrap;";

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->CellCssStyle = "white-space: nowrap;";

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->CellCssStyle = "white-space: nowrap;";

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->CellCssStyle = "white-space: nowrap;";

		// eklaim_gruper1
		$this->eklaim_gruper1->CellCssStyle = "white-space: nowrap;";

		// eklaim_gruper2
		$this->eklaim_gruper2->CellCssStyle = "white-space: nowrap;";

		// eklaim_finalklaim
		$this->eklaim_finalklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_sendklaim
		$this->eklaim_sendklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->CellCssStyle = "white-space: nowrap;";

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->CellCssStyle = "white-space: nowrap;";

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_code
		$this->eklaim_cbg_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_code
		$this->eklaim_chronic_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// VERIFY_ICD
		$this->VERIFY_ICD->CellCssStyle = "white-space: nowrap;";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->CellCssStyle = "white-space: nowrap;";

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->CellCssStyle = "white-space: nowrap;";

		// KETERANGAN
		$this->KETERANGAN->CellCssStyle = "white-space: nowrap;";

		// TGLLAHIR
		$this->TGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// USER_KASIR
		$this->USER_KASIR->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->CellCssStyle = "white-space: nowrap;";

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->CellCssStyle = "white-space: nowrap;";

		// EKG_RAJAL
		$this->EKG_RAJAL->CellCssStyle = "white-space: nowrap;";

		// USG_RAJAL
		$this->USG_RAJAL->CellCssStyle = "white-space: nowrap;";

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL
		$this->BHP_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// ORDER_LAB
		$this->ORDER_LAB->CellCssStyle = "white-space: nowrap;";

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->CellCssStyle = "white-space: nowrap;";

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->CellCssStyle = "white-space: nowrap;";

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->CellCssStyle = "white-space: nowrap;";

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->CellCssStyle = "white-space: nowrap;";

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->CellCssStyle = "white-space: nowrap;";

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->CellCssStyle = "white-space: nowrap;";

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->CellCssStyle = "white-space: nowrap;";

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->CellCssStyle = "white-space: nowrap;";

		// pasien_TITLE
		$this->pasien_TITLE->CellCssStyle = "white-space: nowrap;";

		// pasien_NAMA
		$this->pasien_NAMA->CellCssStyle = "white-space: nowrap;";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->CellCssStyle = "white-space: nowrap;";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// pasien_JENISKELAMIN
		$this->pasien_JENISKELAMIN->CellCssStyle = "white-space: nowrap;";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->CellCssStyle = "white-space: nowrap;";

		// pasien_KELURAHAN
		$this->pasien_KELURAHAN->CellCssStyle = "white-space: nowrap;";

		// pasien_KDKECAMATAN
		$this->pasien_KDKECAMATAN->CellCssStyle = "white-space: nowrap;";

		// pasien_KOTA
		$this->pasien_KOTA->CellCssStyle = "white-space: nowrap;";

		// pasien_KDPROVINSI
		$this->pasien_KDPROVINSI->CellCssStyle = "white-space: nowrap;";

		// pasien_NOTELP
		$this->pasien_NOTELP->CellCssStyle = "white-space: nowrap;";

		// pasien_NOKTP
		$this->pasien_NOKTP->CellCssStyle = "white-space: nowrap;";

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->CellCssStyle = "white-space: nowrap;";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->CellCssStyle = "white-space: nowrap;";

		// pasien_AGAMA
		$this->pasien_AGAMA->CellCssStyle = "white-space: nowrap;";

		// pasien_PENDIDIKAN
		$this->pasien_PENDIDIKAN->CellCssStyle = "white-space: nowrap;";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->CellCssStyle = "white-space: nowrap;";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->CellCssStyle = "white-space: nowrap;";

		// pasien_JNS_PASIEN
		$this->pasien_JNS_PASIEN->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_suami
		$this->pasien_nama_suami->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_istri
		$this->pasien_nama_istri->CellCssStyle = "white-space: nowrap;";

		// pasien_KD_ETNIS
		$this->pasien_KD_ETNIS->CellCssStyle = "white-space: nowrap;";

		// pasien_KD_BHS_HARIAN
		$this->pasien_KD_BHS_HARIAN->CellCssStyle = "white-space: nowrap;";

		// BILL_FARMASI_SELESAI
		$this->BILL_FARMASI_SELESAI->CellCssStyle = "white-space: nowrap;";

		// TARIF_PELAYANAN_SIMRS
		$this->TARIF_PELAYANAN_SIMRS->CellCssStyle = "white-space: nowrap;";

		// USER_ADM
		$this->USER_ADM->CellCssStyle = "white-space: nowrap;";

		// TARIF_PENUNJANG_NON_MEDIS_IGD
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_PELAYANAN_DARAH
		$this->TARIF_PELAYANAN_DARAH->CellCssStyle = "white-space: nowrap;";

		// penjamin_kkl_id
		$this->penjamin_kkl_id->CellCssStyle = "white-space: nowrap;";

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->CellCssStyle = "white-space: nowrap;";

		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		$this->status_kepesertaan_BPJS->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// PASIENBARU
		if (strval($this->PASIENBARU->CurrentValue) <> "") {
			$this->PASIENBARU->ViewValue = $this->PASIENBARU->OptionCaption($this->PASIENBARU->CurrentValue);
		} else {
			$this->PASIENBARU->ViewValue = NULL;
		}
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 7);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDDOKTER
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`kddokter`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kddokter`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_lookup_dokter_poli`";
		$sWhereWrk = "";
		$this->KDDOKTER->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDDOKTER, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
			}
		} else {
			$this->KDDOKTER->ViewValue = NULL;
		}
		$this->KDDOKTER->ViewCustomAttributes = "";

		// KDPOLY
		if (strval($this->KDPOLY->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->KDPOLY->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDPOLY->ViewValue = $this->KDPOLY->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDPOLY->ViewValue = $this->KDPOLY->CurrentValue;
			}
		} else {
			$this->KDPOLY->ViewValue = NULL;
		}
		$this->KDPOLY->ViewCustomAttributes = "";

		// KDRUJUK
		if (strval($this->KDRUJUK->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDRUJUK->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->KDRUJUK->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
			}
		} else {
			$this->KDRUJUK->ViewValue = NULL;
		}
		$this->KDRUJUK->ViewCustomAttributes = "";

		// KDCARABAYAR
		if (strval($this->KDCARABAYAR->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->KDCARABAYAR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
			}
		} else {
			$this->KDCARABAYAR->ViewValue = NULL;
		}
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// SHIFT
		if (strval($this->SHIFT->CurrentValue) <> "") {
			$sFilterWrk = "`id_shift`" . ew_SearchString("=", $this->SHIFT->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_shift`, `shift` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_shift`";
		$sWhereWrk = "";
		$this->SHIFT->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->SHIFT, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->SHIFT->ViewValue = $this->SHIFT->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
			}
		} else {
			$this->SHIFT->ViewValue = NULL;
		}
		$this->SHIFT->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// MASUKPOLY
		$this->MASUKPOLY->ViewValue = $this->MASUKPOLY->CurrentValue;
		$this->MASUKPOLY->ViewValue = ew_FormatDateTime($this->MASUKPOLY->ViewValue, 4);
		$this->MASUKPOLY->ViewCustomAttributes = "";

		// KELUARPOLY
		$this->KELUARPOLY->ViewValue = $this->KELUARPOLY->CurrentValue;
		$this->KELUARPOLY->ViewValue = ew_FormatDateTime($this->KELUARPOLY->ViewValue, 4);
		$this->KELUARPOLY->ViewCustomAttributes = "";

		// pasien_NAMA
		$this->pasien_NAMA->ViewValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_NAMA->ViewCustomAttributes = "";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->ViewValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TEMPAT->ViewCustomAttributes = "";

		// peserta_cob
		$this->peserta_cob->ViewValue = $this->peserta_cob->CurrentValue;
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

			// PASIENBARU
			$this->PASIENBARU->LinkCustomAttributes = "";
			$this->PASIENBARU->HrefValue = "";
			$this->PASIENBARU->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// KDDOKTER
			$this->KDDOKTER->LinkCustomAttributes = "";
			$this->KDDOKTER->HrefValue = "";
			$this->KDDOKTER->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// KDRUJUK
			$this->KDRUJUK->LinkCustomAttributes = "";
			$this->KDRUJUK->HrefValue = "";
			$this->KDRUJUK->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// SHIFT
			$this->SHIFT->LinkCustomAttributes = "";
			$this->SHIFT->HrefValue = "";
			$this->SHIFT->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// MASUKPOLY
			$this->MASUKPOLY->LinkCustomAttributes = "";
			$this->MASUKPOLY->HrefValue = "";
			$this->MASUKPOLY->TooltipValue = "";

			// KELUARPOLY
			$this->KELUARPOLY->LinkCustomAttributes = "";
			$this->KELUARPOLY->HrefValue = "";
			$this->KELUARPOLY->TooltipValue = "";

			// pasien_NAMA
			$this->pasien_NAMA->LinkCustomAttributes = "";
			$this->pasien_NAMA->HrefValue = "";
			$this->pasien_NAMA->TooltipValue = "";

			// pasien_TEMPAT
			$this->pasien_TEMPAT->LinkCustomAttributes = "";
			$this->pasien_TEMPAT->HrefValue = "";
			$this->pasien_TEMPAT->TooltipValue = "";

			// peserta_cob
			$this->peserta_cob->LinkCustomAttributes = "";
			$this->peserta_cob->HrefValue = "";
			$this->peserta_cob->TooltipValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";
			$this->poli_eksekutif->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['IDXDAFTAR'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_pendaftaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_pendaftaran_delete)) $t_pendaftaran_delete = new ct_pendaftaran_delete();

// Page init
$t_pendaftaran_delete->Page_Init();

// Page main
$t_pendaftaran_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_pendaftaran_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_pendaftarandelete = new ew_Form("ft_pendaftarandelete", "delete");

// Form_CustomValidate event
ft_pendaftarandelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_pendaftarandelete.ValidateRequired = true;
<?php } else { ?>
ft_pendaftarandelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_pendaftarandelete.Lists["x_PASIENBARU"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_pendaftarandelete.Lists["x_PASIENBARU"].Options = <?php echo json_encode($t_pendaftaran->PASIENBARU->Options()) ?>;
ft_pendaftarandelete.Lists["x_KDDOKTER"] = {"LinkField":"x_kddokter","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_lookup_dokter_poli"};
ft_pendaftarandelete.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_KDDOKTER"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_pendaftarandelete.Lists["x_KDRUJUK"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
ft_pendaftarandelete.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_pendaftarandelete.Lists["x_SHIFT"] = {"LinkField":"x_id_shift","Ajax":true,"AutoFill":false,"DisplayFields":["x_shift","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_shift"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t_pendaftaran_delete->ShowPageHeader(); ?>
<?php
$t_pendaftaran_delete->ShowMessage();
?>
<form name="ft_pendaftarandelete" id="ft_pendaftarandelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_pendaftaran_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_pendaftaran_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_pendaftaran">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_pendaftaran_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_pendaftaran->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_pendaftaran->PASIENBARU->Visible) { // PASIENBARU ?>
		<th><span id="elh_t_pendaftaran_PASIENBARU" class="t_pendaftaran_PASIENBARU"><?php echo $t_pendaftaran->PASIENBARU->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->NOMR->Visible) { // NOMR ?>
		<th><span id="elh_t_pendaftaran_NOMR" class="t_pendaftaran_NOMR"><?php echo $t_pendaftaran->NOMR->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->TGLREG->Visible) { // TGLREG ?>
		<th><span id="elh_t_pendaftaran_TGLREG" class="t_pendaftaran_TGLREG"><?php echo $t_pendaftaran->TGLREG->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->KDDOKTER->Visible) { // KDDOKTER ?>
		<th><span id="elh_t_pendaftaran_KDDOKTER" class="t_pendaftaran_KDDOKTER"><?php echo $t_pendaftaran->KDDOKTER->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->KDPOLY->Visible) { // KDPOLY ?>
		<th><span id="elh_t_pendaftaran_KDPOLY" class="t_pendaftaran_KDPOLY"><?php echo $t_pendaftaran->KDPOLY->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->KDRUJUK->Visible) { // KDRUJUK ?>
		<th><span id="elh_t_pendaftaran_KDRUJUK" class="t_pendaftaran_KDRUJUK"><?php echo $t_pendaftaran->KDRUJUK->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<th><span id="elh_t_pendaftaran_KDCARABAYAR" class="t_pendaftaran_KDCARABAYAR"><?php echo $t_pendaftaran->KDCARABAYAR->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->SHIFT->Visible) { // SHIFT ?>
		<th><span id="elh_t_pendaftaran_SHIFT" class="t_pendaftaran_SHIFT"><?php echo $t_pendaftaran->SHIFT->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->NIP->Visible) { // NIP ?>
		<th><span id="elh_t_pendaftaran_NIP" class="t_pendaftaran_NIP"><?php echo $t_pendaftaran->NIP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->MASUKPOLY->Visible) { // MASUKPOLY ?>
		<th><span id="elh_t_pendaftaran_MASUKPOLY" class="t_pendaftaran_MASUKPOLY"><?php echo $t_pendaftaran->MASUKPOLY->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->KELUARPOLY->Visible) { // KELUARPOLY ?>
		<th><span id="elh_t_pendaftaran_KELUARPOLY" class="t_pendaftaran_KELUARPOLY"><?php echo $t_pendaftaran->KELUARPOLY->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->pasien_NAMA->Visible) { // pasien_NAMA ?>
		<th><span id="elh_t_pendaftaran_pasien_NAMA" class="t_pendaftaran_pasien_NAMA"><?php echo $t_pendaftaran->pasien_NAMA->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->pasien_TEMPAT->Visible) { // pasien_TEMPAT ?>
		<th><span id="elh_t_pendaftaran_pasien_TEMPAT" class="t_pendaftaran_pasien_TEMPAT"><?php echo $t_pendaftaran->pasien_TEMPAT->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->peserta_cob->Visible) { // peserta_cob ?>
		<th><span id="elh_t_pendaftaran_peserta_cob" class="t_pendaftaran_peserta_cob"><?php echo $t_pendaftaran->peserta_cob->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_pendaftaran->poli_eksekutif->Visible) { // poli_eksekutif ?>
		<th><span id="elh_t_pendaftaran_poli_eksekutif" class="t_pendaftaran_poli_eksekutif"><?php echo $t_pendaftaran->poli_eksekutif->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_pendaftaran_delete->RecCnt = 0;
$i = 0;
while (!$t_pendaftaran_delete->Recordset->EOF) {
	$t_pendaftaran_delete->RecCnt++;
	$t_pendaftaran_delete->RowCnt++;

	// Set row properties
	$t_pendaftaran->ResetAttrs();
	$t_pendaftaran->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_pendaftaran_delete->LoadRowValues($t_pendaftaran_delete->Recordset);

	// Render row
	$t_pendaftaran_delete->RenderRow();
?>
	<tr<?php echo $t_pendaftaran->RowAttributes() ?>>
<?php if ($t_pendaftaran->PASIENBARU->Visible) { // PASIENBARU ?>
		<td<?php echo $t_pendaftaran->PASIENBARU->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_PASIENBARU" class="t_pendaftaran_PASIENBARU">
<span<?php echo $t_pendaftaran->PASIENBARU->ViewAttributes() ?>>
<?php echo $t_pendaftaran->PASIENBARU->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->NOMR->Visible) { // NOMR ?>
		<td<?php echo $t_pendaftaran->NOMR->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_NOMR" class="t_pendaftaran_NOMR">
<span<?php echo $t_pendaftaran->NOMR->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NOMR->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->TGLREG->Visible) { // TGLREG ?>
		<td<?php echo $t_pendaftaran->TGLREG->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_TGLREG" class="t_pendaftaran_TGLREG">
<span<?php echo $t_pendaftaran->TGLREG->ViewAttributes() ?>>
<?php echo $t_pendaftaran->TGLREG->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->KDDOKTER->Visible) { // KDDOKTER ?>
		<td<?php echo $t_pendaftaran->KDDOKTER->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_KDDOKTER" class="t_pendaftaran_KDDOKTER">
<span<?php echo $t_pendaftaran->KDDOKTER->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDDOKTER->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->KDPOLY->Visible) { // KDPOLY ?>
		<td<?php echo $t_pendaftaran->KDPOLY->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_KDPOLY" class="t_pendaftaran_KDPOLY">
<span<?php echo $t_pendaftaran->KDPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDPOLY->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->KDRUJUK->Visible) { // KDRUJUK ?>
		<td<?php echo $t_pendaftaran->KDRUJUK->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_KDRUJUK" class="t_pendaftaran_KDRUJUK">
<span<?php echo $t_pendaftaran->KDRUJUK->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDRUJUK->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<td<?php echo $t_pendaftaran->KDCARABAYAR->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_KDCARABAYAR" class="t_pendaftaran_KDCARABAYAR">
<span<?php echo $t_pendaftaran->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDCARABAYAR->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->SHIFT->Visible) { // SHIFT ?>
		<td<?php echo $t_pendaftaran->SHIFT->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_SHIFT" class="t_pendaftaran_SHIFT">
<span<?php echo $t_pendaftaran->SHIFT->ViewAttributes() ?>>
<?php echo $t_pendaftaran->SHIFT->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->NIP->Visible) { // NIP ?>
		<td<?php echo $t_pendaftaran->NIP->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_NIP" class="t_pendaftaran_NIP">
<span<?php echo $t_pendaftaran->NIP->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NIP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->MASUKPOLY->Visible) { // MASUKPOLY ?>
		<td<?php echo $t_pendaftaran->MASUKPOLY->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_MASUKPOLY" class="t_pendaftaran_MASUKPOLY">
<span<?php echo $t_pendaftaran->MASUKPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->MASUKPOLY->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->KELUARPOLY->Visible) { // KELUARPOLY ?>
		<td<?php echo $t_pendaftaran->KELUARPOLY->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_KELUARPOLY" class="t_pendaftaran_KELUARPOLY">
<span<?php echo $t_pendaftaran->KELUARPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KELUARPOLY->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->pasien_NAMA->Visible) { // pasien_NAMA ?>
		<td<?php echo $t_pendaftaran->pasien_NAMA->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_pasien_NAMA" class="t_pendaftaran_pasien_NAMA">
<span<?php echo $t_pendaftaran->pasien_NAMA->ViewAttributes() ?>>
<?php echo $t_pendaftaran->pasien_NAMA->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->pasien_TEMPAT->Visible) { // pasien_TEMPAT ?>
		<td<?php echo $t_pendaftaran->pasien_TEMPAT->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_pasien_TEMPAT" class="t_pendaftaran_pasien_TEMPAT">
<span<?php echo $t_pendaftaran->pasien_TEMPAT->ViewAttributes() ?>>
<?php echo $t_pendaftaran->pasien_TEMPAT->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->peserta_cob->Visible) { // peserta_cob ?>
		<td<?php echo $t_pendaftaran->peserta_cob->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_peserta_cob" class="t_pendaftaran_peserta_cob">
<span<?php echo $t_pendaftaran->peserta_cob->ViewAttributes() ?>>
<?php echo $t_pendaftaran->peserta_cob->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_pendaftaran->poli_eksekutif->Visible) { // poli_eksekutif ?>
		<td<?php echo $t_pendaftaran->poli_eksekutif->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_delete->RowCnt ?>_t_pendaftaran_poli_eksekutif" class="t_pendaftaran_poli_eksekutif">
<span<?php echo $t_pendaftaran->poli_eksekutif->ViewAttributes() ?>>
<?php echo $t_pendaftaran->poli_eksekutif->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_pendaftaran_delete->Recordset->MoveNext();
}
$t_pendaftaran_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_pendaftaran_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_pendaftarandelete.Init();
</script>
<?php
$t_pendaftaran_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_pendaftaran_delete->Page_Terminate();
?>
