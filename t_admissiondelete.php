<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_admissioninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_admission_delete = NULL; // Initialize page object first

class ct_admission_delete extends ct_admission {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_admission';

	// Page object name
	var $PageObjName = 't_admission_delete';

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

		// Table object (t_admission)
		if (!isset($GLOBALS["t_admission"]) || get_class($GLOBALS["t_admission"]) == "ct_admission") {
			$GLOBALS["t_admission"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_admission"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_admission', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_admissionlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nomr->SetVisibility();
		$this->ket_tgllahir->SetVisibility();
		$this->ket_alamat->SetVisibility();
		$this->statusbayar->SetVisibility();
		$this->masukrs->SetVisibility();
		$this->noruang->SetVisibility();
		$this->nott->SetVisibility();

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
		global $EW_EXPORT, $t_admission;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_admission);
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
			$this->Page_Terminate("t_admissionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_admission class, t_admissioninfo.php

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
				$this->Page_Terminate("t_admissionlist.php"); // Return to list
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->ket_nama->setDbValue($rs->fields('ket_nama'));
		$this->ket_tgllahir->setDbValue($rs->fields('ket_tgllahir'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->parent_nomr->setDbValue($rs->fields('parent_nomr'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->nott->setDbValue($rs->fields('nott'));
		$this->deposit->setDbValue($rs->fields('deposit'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->icd_masuk->setDbValue($rs->fields('icd_masuk'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->noruang_asal->setDbValue($rs->fields('noruang_asal'));
		$this->nott_asal->setDbValue($rs->fields('nott_asal'));
		$this->tgl_pindah->setDbValue($rs->fields('tgl_pindah'));
		$this->kd_rujuk->setDbValue($rs->fields('kd_rujuk'));
		$this->st_bayar->setDbValue($rs->fields('st_bayar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->perawat->setDbValue($rs->fields('perawat'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->LOS->setDbValue($rs->fields('LOS'));
		$this->TOT_TRF_TIND_DOKTER->setDbValue($rs->fields('TOT_TRF_TIND_DOKTER'));
		$this->TOT_BHP_DOKTER->setDbValue($rs->fields('TOT_BHP_DOKTER'));
		$this->TOT_TRF_PERAWAT->setDbValue($rs->fields('TOT_TRF_PERAWAT'));
		$this->TOT_BHP_PERAWAT->setDbValue($rs->fields('TOT_BHP_PERAWAT'));
		$this->TOT_TRF_DOKTER->setDbValue($rs->fields('TOT_TRF_DOKTER'));
		$this->TOT_BIAYA_RAD->setDbValue($rs->fields('TOT_BIAYA_RAD'));
		$this->TOT_BIAYA_CDRPOLI->setDbValue($rs->fields('TOT_BIAYA_CDRPOLI'));
		$this->TOT_BIAYA_LAB_IGD->setDbValue($rs->fields('TOT_BIAYA_LAB_IGD'));
		$this->TOT_BIAYA_OKSIGEN->setDbValue($rs->fields('TOT_BIAYA_OKSIGEN'));
		$this->TOTAL_BIAYA_OBAT->setDbValue($rs->fields('TOTAL_BIAYA_OBAT'));
		$this->LINK_SET_KELAS->setDbValue($rs->fields('LINK_SET_KELAS'));
		$this->biaya_obat->setDbValue($rs->fields('biaya_obat'));
		$this->biaya_retur_obat->setDbValue($rs->fields('biaya_retur_obat'));
		$this->TOT_BIAYA_GIZI->setDbValue($rs->fields('TOT_BIAYA_GIZI'));
		$this->TOT_BIAYA_TMO->setDbValue($rs->fields('TOT_BIAYA_TMO'));
		$this->TOT_BIAYA_AMBULAN->setDbValue($rs->fields('TOT_BIAYA_AMBULAN'));
		$this->TOT_BIAYA_FISIO->setDbValue($rs->fields('TOT_BIAYA_FISIO'));
		$this->TOT_BIAYA_LAINLAIN->setDbValue($rs->fields('TOT_BIAYA_LAINLAIN'));
		$this->jenisperawatan_id->setDbValue($rs->fields('jenisperawatan_id'));
		$this->status_transaksi->setDbValue($rs->fields('status_transaksi'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
		$this->TOT_BIAYA_AKOMODASI->setDbValue($rs->fields('TOT_BIAYA_AKOMODASI'));
		$this->TOTAL_BIAYA_ASKEP->setDbValue($rs->fields('TOTAL_BIAYA_ASKEP'));
		$this->TOTAL_BIAYA_SIMRS->setDbValue($rs->fields('TOTAL_BIAYA_SIMRS'));
		$this->TOT_PENJ_NMEDIS->setDbValue($rs->fields('TOT_PENJ_NMEDIS'));
		$this->LINK_MASTERDETAIL->setDbValue($rs->fields('LINK_MASTERDETAIL'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->LINK_PELAYANAN_OBAT->setDbValue($rs->fields('LINK_PELAYANAN_OBAT'));
		$this->TOT_TIND_RAJAL->setDbValue($rs->fields('TOT_TIND_RAJAL'));
		$this->TOT_TIND_IGD->setDbValue($rs->fields('TOT_TIND_IGD'));
		$this->tanggal_pengembalian_status->setDbValue($rs->fields('tanggal_pengembalian_status'));
		$this->naik_kelas->setDbValue($rs->fields('naik_kelas'));
		$this->iuran_kelas_lama->setDbValue($rs->fields('iuran_kelas_lama'));
		$this->iuran_kelas_baru->setDbValue($rs->fields('iuran_kelas_baru'));
		$this->ketrangan_naik_kelas->setDbValue($rs->fields('ketrangan_naik_kelas'));
		$this->tgl_pengiriman_ad_klaim->setDbValue($rs->fields('tgl_pengiriman_ad_klaim'));
		$this->diagnosa_keluar->setDbValue($rs->fields('diagnosa_keluar'));
		$this->sep_tglsep->setDbValue($rs->fields('sep_tglsep'));
		$this->sep_tglrujuk->setDbValue($rs->fields('sep_tglrujuk'));
		$this->sep_kodekelasrawat->setDbValue($rs->fields('sep_kodekelasrawat'));
		$this->sep_norujukan->setDbValue($rs->fields('sep_norujukan'));
		$this->sep_kodeppkasal->setDbValue($rs->fields('sep_kodeppkasal'));
		$this->sep_namappkasal->setDbValue($rs->fields('sep_namappkasal'));
		$this->sep_kodeppkpelayanan->setDbValue($rs->fields('sep_kodeppkpelayanan'));
		$this->sep_namappkpelayanan->setDbValue($rs->fields('sep_namappkpelayanan'));
		$this->t_admissioncol->setDbValue($rs->fields('t_admissioncol'));
		$this->sep_jenisperawatan->setDbValue($rs->fields('sep_jenisperawatan'));
		$this->sep_catatan->setDbValue($rs->fields('sep_catatan'));
		$this->sep_kodediagnosaawal->setDbValue($rs->fields('sep_kodediagnosaawal'));
		$this->sep_namadiagnosaawal->setDbValue($rs->fields('sep_namadiagnosaawal'));
		$this->sep_lakalantas->setDbValue($rs->fields('sep_lakalantas'));
		$this->sep_lokasilaka->setDbValue($rs->fields('sep_lokasilaka'));
		$this->sep_user->setDbValue($rs->fields('sep_user'));
		$this->sep_flag_cekpeserta->setDbValue($rs->fields('sep_flag_cekpeserta'));
		$this->sep_flag_generatesep->setDbValue($rs->fields('sep_flag_generatesep'));
		$this->sep_flag_mapingsep->setDbValue($rs->fields('sep_flag_mapingsep'));
		$this->sep_nik->setDbValue($rs->fields('sep_nik'));
		$this->sep_namapeserta->setDbValue($rs->fields('sep_namapeserta'));
		$this->sep_jeniskelamin->setDbValue($rs->fields('sep_jeniskelamin'));
		$this->sep_pisat->setDbValue($rs->fields('sep_pisat'));
		$this->sep_tgllahir->setDbValue($rs->fields('sep_tgllahir'));
		$this->sep_kodejeniskepesertaan->setDbValue($rs->fields('sep_kodejeniskepesertaan'));
		$this->sep_namajeniskepesertaan->setDbValue($rs->fields('sep_namajeniskepesertaan'));
		$this->sep_kodepolitujuan->setDbValue($rs->fields('sep_kodepolitujuan'));
		$this->sep_namapolitujuan->setDbValue($rs->fields('sep_namapolitujuan'));
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->sep_nokabpjs->setDbValue($rs->fields('sep_nokabpjs'));
		$this->counter_cetak_sep->setDbValue($rs->fields('counter_cetak_sep'));
		$this->sep_petugas_hapus_sep->setDbValue($rs->fields('sep_petugas_hapus_sep'));
		$this->sep_petugas_set_tgl_pulang->setDbValue($rs->fields('sep_petugas_set_tgl_pulang'));
		$this->sep_jam_generate_sep->setDbValue($rs->fields('sep_jam_generate_sep'));
		$this->sep_status_peserta->setDbValue($rs->fields('sep_status_peserta'));
		$this->sep_umur_pasien_sekarang->setDbValue($rs->fields('sep_umur_pasien_sekarang'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->status_daftar_ranap->setDbValue($rs->fields('status_daftar_ranap'));
		$this->IBS_SETMARKING->setDbValue($rs->fields('IBS_SETMARKING'));
		$this->IBS_PATOLOGI->setDbValue($rs->fields('IBS_PATOLOGI'));
		$this->IBS_JENISANESTESI->setDbValue($rs->fields('IBS_JENISANESTESI'));
		$this->IBS_NO_OK->setDbValue($rs->fields('IBS_NO_OK'));
		$this->IBS_ASISSTEN->setDbValue($rs->fields('IBS_ASISSTEN'));
		$this->IBS_JAM_ELEFTIF->setDbValue($rs->fields('IBS_JAM_ELEFTIF'));
		$this->IBS_JAM_ELEKTIF_SELESAI->setDbValue($rs->fields('IBS_JAM_ELEKTIF_SELESAI'));
		$this->IBS_JAM_CYTO->setDbValue($rs->fields('IBS_JAM_CYTO'));
		$this->IBS_JAM_CYTO_SELESAI->setDbValue($rs->fields('IBS_JAM_CYTO_SELESAI'));
		$this->IBS_TGL_DFTR_OP->setDbValue($rs->fields('IBS_TGL_DFTR_OP'));
		$this->IBS_TGL_OP->setDbValue($rs->fields('IBS_TGL_OP'));
		$this->grup_ruang_id->setDbValue($rs->fields('grup_ruang_id'));
		$this->status_order_ibs->setDbValue($rs->fields('status_order_ibs'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->ket_nama->DbValue = $row['ket_nama'];
		$this->ket_tgllahir->DbValue = $row['ket_tgllahir'];
		$this->ket_alamat->DbValue = $row['ket_alamat'];
		$this->parent_nomr->DbValue = $row['parent_nomr'];
		$this->dokterpengirim->DbValue = $row['dokterpengirim'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kirimdari->DbValue = $row['kirimdari'];
		$this->keluargadekat->DbValue = $row['keluargadekat'];
		$this->panggungjawab->DbValue = $row['panggungjawab'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->nott->DbValue = $row['nott'];
		$this->deposit->DbValue = $row['deposit'];
		$this->keluarrs->DbValue = $row['keluarrs'];
		$this->icd_masuk->DbValue = $row['icd_masuk'];
		$this->icd_keluar->DbValue = $row['icd_keluar'];
		$this->NIP->DbValue = $row['NIP'];
		$this->noruang_asal->DbValue = $row['noruang_asal'];
		$this->nott_asal->DbValue = $row['nott_asal'];
		$this->tgl_pindah->DbValue = $row['tgl_pindah'];
		$this->kd_rujuk->DbValue = $row['kd_rujuk'];
		$this->st_bayar->DbValue = $row['st_bayar'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->perawat->DbValue = $row['perawat'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->LOS->DbValue = $row['LOS'];
		$this->TOT_TRF_TIND_DOKTER->DbValue = $row['TOT_TRF_TIND_DOKTER'];
		$this->TOT_BHP_DOKTER->DbValue = $row['TOT_BHP_DOKTER'];
		$this->TOT_TRF_PERAWAT->DbValue = $row['TOT_TRF_PERAWAT'];
		$this->TOT_BHP_PERAWAT->DbValue = $row['TOT_BHP_PERAWAT'];
		$this->TOT_TRF_DOKTER->DbValue = $row['TOT_TRF_DOKTER'];
		$this->TOT_BIAYA_RAD->DbValue = $row['TOT_BIAYA_RAD'];
		$this->TOT_BIAYA_CDRPOLI->DbValue = $row['TOT_BIAYA_CDRPOLI'];
		$this->TOT_BIAYA_LAB_IGD->DbValue = $row['TOT_BIAYA_LAB_IGD'];
		$this->TOT_BIAYA_OKSIGEN->DbValue = $row['TOT_BIAYA_OKSIGEN'];
		$this->TOTAL_BIAYA_OBAT->DbValue = $row['TOTAL_BIAYA_OBAT'];
		$this->LINK_SET_KELAS->DbValue = $row['LINK_SET_KELAS'];
		$this->biaya_obat->DbValue = $row['biaya_obat'];
		$this->biaya_retur_obat->DbValue = $row['biaya_retur_obat'];
		$this->TOT_BIAYA_GIZI->DbValue = $row['TOT_BIAYA_GIZI'];
		$this->TOT_BIAYA_TMO->DbValue = $row['TOT_BIAYA_TMO'];
		$this->TOT_BIAYA_AMBULAN->DbValue = $row['TOT_BIAYA_AMBULAN'];
		$this->TOT_BIAYA_FISIO->DbValue = $row['TOT_BIAYA_FISIO'];
		$this->TOT_BIAYA_LAINLAIN->DbValue = $row['TOT_BIAYA_LAINLAIN'];
		$this->jenisperawatan_id->DbValue = $row['jenisperawatan_id'];
		$this->status_transaksi->DbValue = $row['status_transaksi'];
		$this->statuskeluarranap_id->DbValue = $row['statuskeluarranap_id'];
		$this->TOT_BIAYA_AKOMODASI->DbValue = $row['TOT_BIAYA_AKOMODASI'];
		$this->TOTAL_BIAYA_ASKEP->DbValue = $row['TOTAL_BIAYA_ASKEP'];
		$this->TOTAL_BIAYA_SIMRS->DbValue = $row['TOTAL_BIAYA_SIMRS'];
		$this->TOT_PENJ_NMEDIS->DbValue = $row['TOT_PENJ_NMEDIS'];
		$this->LINK_MASTERDETAIL->DbValue = $row['LINK_MASTERDETAIL'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->LINK_PELAYANAN_OBAT->DbValue = $row['LINK_PELAYANAN_OBAT'];
		$this->TOT_TIND_RAJAL->DbValue = $row['TOT_TIND_RAJAL'];
		$this->TOT_TIND_IGD->DbValue = $row['TOT_TIND_IGD'];
		$this->tanggal_pengembalian_status->DbValue = $row['tanggal_pengembalian_status'];
		$this->naik_kelas->DbValue = $row['naik_kelas'];
		$this->iuran_kelas_lama->DbValue = $row['iuran_kelas_lama'];
		$this->iuran_kelas_baru->DbValue = $row['iuran_kelas_baru'];
		$this->ketrangan_naik_kelas->DbValue = $row['ketrangan_naik_kelas'];
		$this->tgl_pengiriman_ad_klaim->DbValue = $row['tgl_pengiriman_ad_klaim'];
		$this->diagnosa_keluar->DbValue = $row['diagnosa_keluar'];
		$this->sep_tglsep->DbValue = $row['sep_tglsep'];
		$this->sep_tglrujuk->DbValue = $row['sep_tglrujuk'];
		$this->sep_kodekelasrawat->DbValue = $row['sep_kodekelasrawat'];
		$this->sep_norujukan->DbValue = $row['sep_norujukan'];
		$this->sep_kodeppkasal->DbValue = $row['sep_kodeppkasal'];
		$this->sep_namappkasal->DbValue = $row['sep_namappkasal'];
		$this->sep_kodeppkpelayanan->DbValue = $row['sep_kodeppkpelayanan'];
		$this->sep_namappkpelayanan->DbValue = $row['sep_namappkpelayanan'];
		$this->t_admissioncol->DbValue = $row['t_admissioncol'];
		$this->sep_jenisperawatan->DbValue = $row['sep_jenisperawatan'];
		$this->sep_catatan->DbValue = $row['sep_catatan'];
		$this->sep_kodediagnosaawal->DbValue = $row['sep_kodediagnosaawal'];
		$this->sep_namadiagnosaawal->DbValue = $row['sep_namadiagnosaawal'];
		$this->sep_lakalantas->DbValue = $row['sep_lakalantas'];
		$this->sep_lokasilaka->DbValue = $row['sep_lokasilaka'];
		$this->sep_user->DbValue = $row['sep_user'];
		$this->sep_flag_cekpeserta->DbValue = $row['sep_flag_cekpeserta'];
		$this->sep_flag_generatesep->DbValue = $row['sep_flag_generatesep'];
		$this->sep_flag_mapingsep->DbValue = $row['sep_flag_mapingsep'];
		$this->sep_nik->DbValue = $row['sep_nik'];
		$this->sep_namapeserta->DbValue = $row['sep_namapeserta'];
		$this->sep_jeniskelamin->DbValue = $row['sep_jeniskelamin'];
		$this->sep_pisat->DbValue = $row['sep_pisat'];
		$this->sep_tgllahir->DbValue = $row['sep_tgllahir'];
		$this->sep_kodejeniskepesertaan->DbValue = $row['sep_kodejeniskepesertaan'];
		$this->sep_namajeniskepesertaan->DbValue = $row['sep_namajeniskepesertaan'];
		$this->sep_kodepolitujuan->DbValue = $row['sep_kodepolitujuan'];
		$this->sep_namapolitujuan->DbValue = $row['sep_namapolitujuan'];
		$this->ket_jeniskelamin->DbValue = $row['ket_jeniskelamin'];
		$this->sep_nokabpjs->DbValue = $row['sep_nokabpjs'];
		$this->counter_cetak_sep->DbValue = $row['counter_cetak_sep'];
		$this->sep_petugas_hapus_sep->DbValue = $row['sep_petugas_hapus_sep'];
		$this->sep_petugas_set_tgl_pulang->DbValue = $row['sep_petugas_set_tgl_pulang'];
		$this->sep_jam_generate_sep->DbValue = $row['sep_jam_generate_sep'];
		$this->sep_status_peserta->DbValue = $row['sep_status_peserta'];
		$this->sep_umur_pasien_sekarang->DbValue = $row['sep_umur_pasien_sekarang'];
		$this->ket_title->DbValue = $row['ket_title'];
		$this->status_daftar_ranap->DbValue = $row['status_daftar_ranap'];
		$this->IBS_SETMARKING->DbValue = $row['IBS_SETMARKING'];
		$this->IBS_PATOLOGI->DbValue = $row['IBS_PATOLOGI'];
		$this->IBS_JENISANESTESI->DbValue = $row['IBS_JENISANESTESI'];
		$this->IBS_NO_OK->DbValue = $row['IBS_NO_OK'];
		$this->IBS_ASISSTEN->DbValue = $row['IBS_ASISSTEN'];
		$this->IBS_JAM_ELEFTIF->DbValue = $row['IBS_JAM_ELEFTIF'];
		$this->IBS_JAM_ELEKTIF_SELESAI->DbValue = $row['IBS_JAM_ELEKTIF_SELESAI'];
		$this->IBS_JAM_CYTO->DbValue = $row['IBS_JAM_CYTO'];
		$this->IBS_JAM_CYTO_SELESAI->DbValue = $row['IBS_JAM_CYTO_SELESAI'];
		$this->IBS_TGL_DFTR_OP->DbValue = $row['IBS_TGL_DFTR_OP'];
		$this->IBS_TGL_OP->DbValue = $row['IBS_TGL_OP'];
		$this->grup_ruang_id->DbValue = $row['grup_ruang_id'];
		$this->status_order_ibs->DbValue = $row['status_order_ibs'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_admission
		// nomr
		// ket_nama
		// ket_tgllahir
		// ket_alamat
		// parent_nomr
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// nott
		// deposit
		// keluarrs
		// icd_masuk
		// icd_keluar
		// NIP
		// noruang_asal
		// nott_asal
		// tgl_pindah
		// kd_rujuk
		// st_bayar
		// dokter_penanggungjawab
		// perawat
		// KELASPERAWATAN_ID
		// LOS
		// TOT_TRF_TIND_DOKTER
		// TOT_BHP_DOKTER
		// TOT_TRF_PERAWAT
		// TOT_BHP_PERAWAT
		// TOT_TRF_DOKTER
		// TOT_BIAYA_RAD
		// TOT_BIAYA_CDRPOLI
		// TOT_BIAYA_LAB_IGD
		// TOT_BIAYA_OKSIGEN
		// TOTAL_BIAYA_OBAT
		// LINK_SET_KELAS
		// biaya_obat
		// biaya_retur_obat
		// TOT_BIAYA_GIZI
		// TOT_BIAYA_TMO
		// TOT_BIAYA_AMBULAN
		// TOT_BIAYA_FISIO
		// TOT_BIAYA_LAINLAIN
		// jenisperawatan_id
		// status_transaksi
		// statuskeluarranap_id
		// TOT_BIAYA_AKOMODASI
		// TOTAL_BIAYA_ASKEP
		// TOTAL_BIAYA_SIMRS
		// TOT_PENJ_NMEDIS
		// LINK_MASTERDETAIL
		// NO_SKP
		// LINK_PELAYANAN_OBAT
		// TOT_TIND_RAJAL
		// TOT_TIND_IGD
		// tanggal_pengembalian_status
		// naik_kelas
		// iuran_kelas_lama
		// iuran_kelas_baru
		// ketrangan_naik_kelas
		// tgl_pengiriman_ad_klaim
		// diagnosa_keluar
		// sep_tglsep
		// sep_tglrujuk
		// sep_kodekelasrawat
		// sep_norujukan
		// sep_kodeppkasal
		// sep_namappkasal
		// sep_kodeppkpelayanan
		// sep_namappkpelayanan
		// t_admissioncol
		// sep_jenisperawatan
		// sep_catatan
		// sep_kodediagnosaawal
		// sep_namadiagnosaawal
		// sep_lakalantas
		// sep_lokasilaka
		// sep_user
		// sep_flag_cekpeserta
		// sep_flag_generatesep
		// sep_flag_mapingsep
		// sep_nik
		// sep_namapeserta
		// sep_jeniskelamin
		// sep_pisat
		// sep_tgllahir
		// sep_kodejeniskepesertaan
		// sep_namajeniskepesertaan
		// sep_kodepolitujuan
		// sep_namapolitujuan
		// ket_jeniskelamin
		// sep_nokabpjs
		// counter_cetak_sep
		// sep_petugas_hapus_sep
		// sep_petugas_set_tgl_pulang
		// sep_jam_generate_sep
		// sep_status_peserta
		// sep_umur_pasien_sekarang
		// ket_title
		// status_daftar_ranap
		// IBS_SETMARKING
		// IBS_PATOLOGI
		// IBS_JENISANESTESI
		// IBS_NO_OK
		// IBS_ASISSTEN
		// IBS_JAM_ELEFTIF
		// IBS_JAM_ELEKTIF_SELESAI
		// IBS_JAM_CYTO
		// IBS_JAM_CYTO_SELESAI
		// IBS_TGL_DFTR_OP
		// IBS_TGL_OP
		// grup_ruang_id
		// status_order_ibs

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		if (strval($this->nomr->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->nomr->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->nomr->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->nomr->ViewValue = $this->nomr->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomr->ViewValue = $this->nomr->CurrentValue;
			}
		} else {
			$this->nomr->ViewValue = NULL;
		}
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// ket_tgllahir
		$this->ket_tgllahir->ViewValue = $this->ket_tgllahir->CurrentValue;
		$this->ket_tgllahir->ViewValue = ew_FormatDateTime($this->ket_tgllahir->ViewValue, 0);
		$this->ket_tgllahir->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// parent_nomr
		$this->parent_nomr->ViewValue = $this->parent_nomr->CurrentValue;
		$this->parent_nomr->ViewCustomAttributes = "";

		// dokterpengirim
		if (strval($this->dokterpengirim->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokterpengirim->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokterpengirim->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->CurrentValue;
			}
		} else {
			$this->dokterpengirim->ViewValue = NULL;
		}
		$this->dokterpengirim->ViewCustomAttributes = "";

		// statusbayar
		if (strval($this->statusbayar->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->statusbayar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statusbayar->ViewValue = $this->statusbayar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			}
		} else {
			$this->statusbayar->ViewValue = NULL;
		}
		$this->statusbayar->ViewCustomAttributes = "";

		// kirimdari
		$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
		if (strval($this->kirimdari->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kirimdari->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->kirimdari->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kirimdari->ViewValue = $this->kirimdari->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
			}
		} else {
			$this->kirimdari->ViewValue = NULL;
		}
		$this->kirimdari->ViewCustomAttributes = "";

		// keluargadekat
		$this->keluargadekat->ViewValue = $this->keluargadekat->CurrentValue;
		$this->keluargadekat->ViewCustomAttributes = "";

		// panggungjawab
		$this->panggungjawab->ViewValue = $this->panggungjawab->CurrentValue;
		$this->panggungjawab->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 11);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		if (strval($this->noruang->CurrentValue) <> "") {
			$sFilterWrk = "`no`" . ew_SearchString("=", $this->noruang->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `no`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_ruang`";
		$sWhereWrk = "";
		$this->noruang->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->noruang->ViewValue = $this->noruang->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->noruang->ViewValue = $this->noruang->CurrentValue;
			}
		} else {
			$this->noruang->ViewValue = NULL;
		}
		$this->noruang->ViewCustomAttributes = "";

		// tempat_tidur_id
		if (strval($this->tempat_tidur_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
		$sWhereWrk = "";
		$this->tempat_tidur_id->LookupFilters = array();
		$lookuptblfilter = "isnull(`KETERANGAN`)";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->CurrentValue;
			}
		} else {
			$this->tempat_tidur_id->ViewValue = NULL;
		}
		$this->tempat_tidur_id->ViewCustomAttributes = "";

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

		// deposit
		$this->deposit->ViewValue = $this->deposit->CurrentValue;
		$this->deposit->ViewCustomAttributes = "";

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 0);
		$this->keluarrs->ViewCustomAttributes = "";

		// icd_masuk
		$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
		if (strval($this->icd_masuk->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_masuk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
		$sWhereWrk = "";
		$this->icd_masuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_masuk->ViewValue = $this->icd_masuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
			}
		} else {
			$this->icd_masuk->ViewValue = NULL;
		}
		$this->icd_masuk->ViewCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		$this->icd_keluar->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// noruang_asal
		$this->noruang_asal->ViewValue = $this->noruang_asal->CurrentValue;
		$this->noruang_asal->ViewCustomAttributes = "";

		// nott_asal
		$this->nott_asal->ViewValue = $this->nott_asal->CurrentValue;
		$this->nott_asal->ViewCustomAttributes = "";

		// tgl_pindah
		$this->tgl_pindah->ViewValue = $this->tgl_pindah->CurrentValue;
		$this->tgl_pindah->ViewValue = ew_FormatDateTime($this->tgl_pindah->ViewValue, 0);
		$this->tgl_pindah->ViewCustomAttributes = "";

		// kd_rujuk
		if (strval($this->kd_rujuk->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->kd_rujuk->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->kd_rujuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->CurrentValue;
			}
		} else {
			$this->kd_rujuk->ViewValue = NULL;
		}
		$this->kd_rujuk->ViewCustomAttributes = "";

		// st_bayar
		$this->st_bayar->ViewValue = $this->st_bayar->CurrentValue;
		$this->st_bayar->ViewCustomAttributes = "";

		// dokter_penanggungjawab
		if (strval($this->dokter_penanggungjawab->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokter_penanggungjawab->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokter_penanggungjawab->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->CurrentValue;
			}
		} else {
			$this->dokter_penanggungjawab->ViewValue = NULL;
		}
		$this->dokter_penanggungjawab->ViewCustomAttributes = "";

		// perawat
		$this->perawat->ViewValue = $this->perawat->CurrentValue;
		$this->perawat->ViewCustomAttributes = "";

		// KELASPERAWATAN_ID
		if (strval($this->KELASPERAWATAN_ID->CurrentValue) <> "") {
			$sFilterWrk = "`kelasperawatan_id`" . ew_SearchString("=", $this->KELASPERAWATAN_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kelasperawatan_id`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_kelas_perawatan`";
		$sWhereWrk = "";
		$this->KELASPERAWATAN_ID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
			}
		} else {
			$this->KELASPERAWATAN_ID->ViewValue = NULL;
		}
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// LOS
		$this->LOS->ViewValue = $this->LOS->CurrentValue;
		$this->LOS->ViewCustomAttributes = "";

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER->ViewValue = $this->TOT_TRF_TIND_DOKTER->CurrentValue;
		$this->TOT_TRF_TIND_DOKTER->ViewCustomAttributes = "";

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER->ViewValue = $this->TOT_BHP_DOKTER->CurrentValue;
		$this->TOT_BHP_DOKTER->ViewCustomAttributes = "";

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT->ViewValue = $this->TOT_TRF_PERAWAT->CurrentValue;
		$this->TOT_TRF_PERAWAT->ViewCustomAttributes = "";

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT->ViewValue = $this->TOT_BHP_PERAWAT->CurrentValue;
		$this->TOT_BHP_PERAWAT->ViewCustomAttributes = "";

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER->ViewValue = $this->TOT_TRF_DOKTER->CurrentValue;
		$this->TOT_TRF_DOKTER->ViewCustomAttributes = "";

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD->ViewValue = $this->TOT_BIAYA_RAD->CurrentValue;
		$this->TOT_BIAYA_RAD->ViewCustomAttributes = "";

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI->ViewValue = $this->TOT_BIAYA_CDRPOLI->CurrentValue;
		$this->TOT_BIAYA_CDRPOLI->ViewCustomAttributes = "";

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD->ViewValue = $this->TOT_BIAYA_LAB_IGD->CurrentValue;
		$this->TOT_BIAYA_LAB_IGD->ViewCustomAttributes = "";

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN->ViewValue = $this->TOT_BIAYA_OKSIGEN->CurrentValue;
		$this->TOT_BIAYA_OKSIGEN->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->ViewValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->ViewCustomAttributes = "";

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS->ViewValue = $this->LINK_SET_KELAS->CurrentValue;
		$this->LINK_SET_KELAS->ViewCustomAttributes = "";

		// biaya_obat
		$this->biaya_obat->ViewValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->ViewCustomAttributes = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->ViewValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->ViewCustomAttributes = "";

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI->ViewValue = $this->TOT_BIAYA_GIZI->CurrentValue;
		$this->TOT_BIAYA_GIZI->ViewCustomAttributes = "";

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO->ViewValue = $this->TOT_BIAYA_TMO->CurrentValue;
		$this->TOT_BIAYA_TMO->ViewCustomAttributes = "";

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN->ViewValue = $this->TOT_BIAYA_AMBULAN->CurrentValue;
		$this->TOT_BIAYA_AMBULAN->ViewCustomAttributes = "";

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO->ViewValue = $this->TOT_BIAYA_FISIO->CurrentValue;
		$this->TOT_BIAYA_FISIO->ViewCustomAttributes = "";

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN->ViewValue = $this->TOT_BIAYA_LAINLAIN->CurrentValue;
		$this->TOT_BIAYA_LAINLAIN->ViewCustomAttributes = "";

		// jenisperawatan_id
		$this->jenisperawatan_id->ViewValue = $this->jenisperawatan_id->CurrentValue;
		$this->jenisperawatan_id->ViewCustomAttributes = "";

		// status_transaksi
		$this->status_transaksi->ViewValue = $this->status_transaksi->CurrentValue;
		$this->status_transaksi->ViewCustomAttributes = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI->ViewValue = $this->TOT_BIAYA_AKOMODASI->CurrentValue;
		$this->TOT_BIAYA_AKOMODASI->ViewCustomAttributes = "";

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP->ViewValue = $this->TOTAL_BIAYA_ASKEP->CurrentValue;
		$this->TOTAL_BIAYA_ASKEP->ViewCustomAttributes = "";

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS->ViewValue = $this->TOTAL_BIAYA_SIMRS->CurrentValue;
		$this->TOTAL_BIAYA_SIMRS->ViewCustomAttributes = "";

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS->ViewValue = $this->TOT_PENJ_NMEDIS->CurrentValue;
		$this->TOT_PENJ_NMEDIS->ViewCustomAttributes = "";

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL->ViewValue = $this->LINK_MASTERDETAIL->CurrentValue;
		$this->LINK_MASTERDETAIL->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT->ViewValue = $this->LINK_PELAYANAN_OBAT->CurrentValue;
		$this->LINK_PELAYANAN_OBAT->ViewCustomAttributes = "";

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL->ViewValue = $this->TOT_TIND_RAJAL->CurrentValue;
		$this->TOT_TIND_RAJAL->ViewCustomAttributes = "";

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD->ViewValue = $this->TOT_TIND_IGD->CurrentValue;
		$this->TOT_TIND_IGD->ViewCustomAttributes = "";

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status->ViewValue = $this->tanggal_pengembalian_status->CurrentValue;
		$this->tanggal_pengembalian_status->ViewValue = ew_FormatDateTime($this->tanggal_pengembalian_status->ViewValue, 0);
		$this->tanggal_pengembalian_status->ViewCustomAttributes = "";

		// naik_kelas
		$this->naik_kelas->ViewValue = $this->naik_kelas->CurrentValue;
		$this->naik_kelas->ViewCustomAttributes = "";

		// iuran_kelas_lama
		$this->iuran_kelas_lama->ViewValue = $this->iuran_kelas_lama->CurrentValue;
		$this->iuran_kelas_lama->ViewCustomAttributes = "";

		// iuran_kelas_baru
		$this->iuran_kelas_baru->ViewValue = $this->iuran_kelas_baru->CurrentValue;
		$this->iuran_kelas_baru->ViewCustomAttributes = "";

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas->ViewValue = $this->ketrangan_naik_kelas->CurrentValue;
		$this->ketrangan_naik_kelas->ViewCustomAttributes = "";

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim->ViewValue = $this->tgl_pengiriman_ad_klaim->CurrentValue;
		$this->tgl_pengiriman_ad_klaim->ViewValue = ew_FormatDateTime($this->tgl_pengiriman_ad_klaim->ViewValue, 0);
		$this->tgl_pengiriman_ad_klaim->ViewCustomAttributes = "";

		// diagnosa_keluar
		$this->diagnosa_keluar->ViewValue = $this->diagnosa_keluar->CurrentValue;
		$this->diagnosa_keluar->ViewCustomAttributes = "";

		// sep_tglsep
		$this->sep_tglsep->ViewValue = $this->sep_tglsep->CurrentValue;
		$this->sep_tglsep->ViewValue = ew_FormatDateTime($this->sep_tglsep->ViewValue, 0);
		$this->sep_tglsep->ViewCustomAttributes = "";

		// sep_tglrujuk
		$this->sep_tglrujuk->ViewValue = $this->sep_tglrujuk->CurrentValue;
		$this->sep_tglrujuk->ViewValue = ew_FormatDateTime($this->sep_tglrujuk->ViewValue, 0);
		$this->sep_tglrujuk->ViewCustomAttributes = "";

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat->ViewValue = $this->sep_kodekelasrawat->CurrentValue;
		$this->sep_kodekelasrawat->ViewCustomAttributes = "";

		// sep_norujukan
		$this->sep_norujukan->ViewValue = $this->sep_norujukan->CurrentValue;
		$this->sep_norujukan->ViewCustomAttributes = "";

		// sep_kodeppkasal
		$this->sep_kodeppkasal->ViewValue = $this->sep_kodeppkasal->CurrentValue;
		$this->sep_kodeppkasal->ViewCustomAttributes = "";

		// sep_namappkasal
		$this->sep_namappkasal->ViewValue = $this->sep_namappkasal->CurrentValue;
		$this->sep_namappkasal->ViewCustomAttributes = "";

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan->ViewValue = $this->sep_kodeppkpelayanan->CurrentValue;
		$this->sep_kodeppkpelayanan->ViewCustomAttributes = "";

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan->ViewValue = $this->sep_namappkpelayanan->CurrentValue;
		$this->sep_namappkpelayanan->ViewCustomAttributes = "";

		// t_admissioncol
		$this->t_admissioncol->ViewValue = $this->t_admissioncol->CurrentValue;
		$this->t_admissioncol->ViewCustomAttributes = "";

		// sep_jenisperawatan
		$this->sep_jenisperawatan->ViewValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_jenisperawatan->ViewCustomAttributes = "";

		// sep_catatan
		$this->sep_catatan->ViewValue = $this->sep_catatan->CurrentValue;
		$this->sep_catatan->ViewCustomAttributes = "";

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
		$this->sep_kodediagnosaawal->ViewCustomAttributes = "";

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->ViewValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->ViewCustomAttributes = "";

		// sep_lakalantas
		$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->CurrentValue;
		$this->sep_lakalantas->ViewCustomAttributes = "";

		// sep_lokasilaka
		$this->sep_lokasilaka->ViewValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_lokasilaka->ViewCustomAttributes = "";

		// sep_user
		$this->sep_user->ViewValue = $this->sep_user->CurrentValue;
		$this->sep_user->ViewCustomAttributes = "";

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta->ViewValue = $this->sep_flag_cekpeserta->CurrentValue;
		$this->sep_flag_cekpeserta->ViewCustomAttributes = "";

		// sep_flag_generatesep
		$this->sep_flag_generatesep->ViewValue = $this->sep_flag_generatesep->CurrentValue;
		$this->sep_flag_generatesep->ViewCustomAttributes = "";

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep->ViewValue = $this->sep_flag_mapingsep->CurrentValue;
		$this->sep_flag_mapingsep->ViewCustomAttributes = "";

		// sep_nik
		$this->sep_nik->ViewValue = $this->sep_nik->CurrentValue;
		$this->sep_nik->ViewCustomAttributes = "";

		// sep_namapeserta
		$this->sep_namapeserta->ViewValue = $this->sep_namapeserta->CurrentValue;
		$this->sep_namapeserta->ViewCustomAttributes = "";

		// sep_jeniskelamin
		$this->sep_jeniskelamin->ViewValue = $this->sep_jeniskelamin->CurrentValue;
		$this->sep_jeniskelamin->ViewCustomAttributes = "";

		// sep_pisat
		$this->sep_pisat->ViewValue = $this->sep_pisat->CurrentValue;
		$this->sep_pisat->ViewCustomAttributes = "";

		// sep_tgllahir
		$this->sep_tgllahir->ViewValue = $this->sep_tgllahir->CurrentValue;
		$this->sep_tgllahir->ViewCustomAttributes = "";

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan->ViewValue = $this->sep_kodejeniskepesertaan->CurrentValue;
		$this->sep_kodejeniskepesertaan->ViewCustomAttributes = "";

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan->ViewValue = $this->sep_namajeniskepesertaan->CurrentValue;
		$this->sep_namajeniskepesertaan->ViewCustomAttributes = "";

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan->ViewValue = $this->sep_kodepolitujuan->CurrentValue;
		$this->sep_kodepolitujuan->ViewCustomAttributes = "";

		// sep_namapolitujuan
		$this->sep_namapolitujuan->ViewValue = $this->sep_namapolitujuan->CurrentValue;
		$this->sep_namapolitujuan->ViewCustomAttributes = "";

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// sep_nokabpjs
		$this->sep_nokabpjs->ViewValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->ViewCustomAttributes = "";

		// counter_cetak_sep
		$this->counter_cetak_sep->ViewValue = $this->counter_cetak_sep->CurrentValue;
		$this->counter_cetak_sep->ViewCustomAttributes = "";

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep->ViewValue = $this->sep_petugas_hapus_sep->CurrentValue;
		$this->sep_petugas_hapus_sep->ViewCustomAttributes = "";

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang->ViewValue = $this->sep_petugas_set_tgl_pulang->CurrentValue;
		$this->sep_petugas_set_tgl_pulang->ViewCustomAttributes = "";

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep->ViewValue = $this->sep_jam_generate_sep->CurrentValue;
		$this->sep_jam_generate_sep->ViewValue = ew_FormatDateTime($this->sep_jam_generate_sep->ViewValue, 0);
		$this->sep_jam_generate_sep->ViewCustomAttributes = "";

		// sep_status_peserta
		$this->sep_status_peserta->ViewValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_status_peserta->ViewCustomAttributes = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->ViewValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->sep_umur_pasien_sekarang->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// status_daftar_ranap
		$this->status_daftar_ranap->ViewValue = $this->status_daftar_ranap->CurrentValue;
		$this->status_daftar_ranap->ViewCustomAttributes = "";

		// IBS_SETMARKING
		$this->IBS_SETMARKING->ViewValue = $this->IBS_SETMARKING->CurrentValue;
		$this->IBS_SETMARKING->ViewCustomAttributes = "";

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI->ViewValue = $this->IBS_PATOLOGI->CurrentValue;
		$this->IBS_PATOLOGI->ViewCustomAttributes = "";

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI->ViewValue = $this->IBS_JENISANESTESI->CurrentValue;
		$this->IBS_JENISANESTESI->ViewCustomAttributes = "";

		// IBS_NO_OK
		$this->IBS_NO_OK->ViewValue = $this->IBS_NO_OK->CurrentValue;
		$this->IBS_NO_OK->ViewCustomAttributes = "";

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN->ViewValue = $this->IBS_ASISSTEN->CurrentValue;
		$this->IBS_ASISSTEN->ViewCustomAttributes = "";

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF->ViewValue = $this->IBS_JAM_ELEFTIF->CurrentValue;
		$this->IBS_JAM_ELEFTIF->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEFTIF->ViewValue, 0);
		$this->IBS_JAM_ELEFTIF->ViewCustomAttributes = "";

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = $this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue;
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->ViewValue, 0);
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewCustomAttributes = "";

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO->ViewValue = $this->IBS_JAM_CYTO->CurrentValue;
		$this->IBS_JAM_CYTO->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO->ViewValue, 0);
		$this->IBS_JAM_CYTO->ViewCustomAttributes = "";

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = $this->IBS_JAM_CYTO_SELESAI->CurrentValue;
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO_SELESAI->ViewValue, 0);
		$this->IBS_JAM_CYTO_SELESAI->ViewCustomAttributes = "";

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP->ViewValue = $this->IBS_TGL_DFTR_OP->CurrentValue;
		$this->IBS_TGL_DFTR_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_DFTR_OP->ViewValue, 0);
		$this->IBS_TGL_DFTR_OP->ViewCustomAttributes = "";

		// IBS_TGL_OP
		$this->IBS_TGL_OP->ViewValue = $this->IBS_TGL_OP->CurrentValue;
		$this->IBS_TGL_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_OP->ViewValue, 0);
		$this->IBS_TGL_OP->ViewCustomAttributes = "";

		// grup_ruang_id
		$this->grup_ruang_id->ViewValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->ViewCustomAttributes = "";

		// status_order_ibs
		$this->status_order_ibs->ViewValue = $this->status_order_ibs->CurrentValue;
		$this->status_order_ibs->ViewCustomAttributes = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// ket_tgllahir
			$this->ket_tgllahir->LinkCustomAttributes = "";
			$this->ket_tgllahir->HrefValue = "";
			$this->ket_tgllahir->TooltipValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";
			$this->ket_alamat->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";
			$this->masukrs->TooltipValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";
			$this->noruang->TooltipValue = "";

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";
			$this->nott->TooltipValue = "";
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
				$sThisKey .= $row['id_admission'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_admissionlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_admission_delete)) $t_admission_delete = new ct_admission_delete();

// Page init
$t_admission_delete->Page_Init();

// Page main
$t_admission_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_admission_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_admissiondelete = new ew_Form("ft_admissiondelete", "delete");

// Form_CustomValidate event
ft_admissiondelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_admissiondelete.ValidateRequired = true;
<?php } else { ?>
ft_admissiondelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_admissiondelete.Lists["x_nomr"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_admissiondelete.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_admissiondelete.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t_admission_delete->ShowPageHeader(); ?>
<?php
$t_admission_delete->ShowMessage();
?>
<form name="ft_admissiondelete" id="ft_admissiondelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_admission_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_admission_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_admission">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_admission_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_admission->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_admission->nomr->Visible) { // nomr ?>
		<th><span id="elh_t_admission_nomr" class="t_admission_nomr"><?php echo $t_admission->nomr->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission->ket_tgllahir->Visible) { // ket_tgllahir ?>
		<th><span id="elh_t_admission_ket_tgllahir" class="t_admission_ket_tgllahir"><?php echo $t_admission->ket_tgllahir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission->ket_alamat->Visible) { // ket_alamat ?>
		<th><span id="elh_t_admission_ket_alamat" class="t_admission_ket_alamat"><?php echo $t_admission->ket_alamat->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission->statusbayar->Visible) { // statusbayar ?>
		<th><span id="elh_t_admission_statusbayar" class="t_admission_statusbayar"><?php echo $t_admission->statusbayar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission->masukrs->Visible) { // masukrs ?>
		<th><span id="elh_t_admission_masukrs" class="t_admission_masukrs"><?php echo $t_admission->masukrs->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission->noruang->Visible) { // noruang ?>
		<th><span id="elh_t_admission_noruang" class="t_admission_noruang"><?php echo $t_admission->noruang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission->nott->Visible) { // nott ?>
		<th><span id="elh_t_admission_nott" class="t_admission_nott"><?php echo $t_admission->nott->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_admission_delete->RecCnt = 0;
$i = 0;
while (!$t_admission_delete->Recordset->EOF) {
	$t_admission_delete->RecCnt++;
	$t_admission_delete->RowCnt++;

	// Set row properties
	$t_admission->ResetAttrs();
	$t_admission->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_admission_delete->LoadRowValues($t_admission_delete->Recordset);

	// Render row
	$t_admission_delete->RenderRow();
?>
	<tr<?php echo $t_admission->RowAttributes() ?>>
<?php if ($t_admission->nomr->Visible) { // nomr ?>
		<td<?php echo $t_admission->nomr->CellAttributes() ?>>
<span id="el<?php echo $t_admission_delete->RowCnt ?>_t_admission_nomr" class="t_admission_nomr">
<span<?php echo $t_admission->nomr->ViewAttributes() ?>>
<?php echo $t_admission->nomr->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission->ket_tgllahir->Visible) { // ket_tgllahir ?>
		<td<?php echo $t_admission->ket_tgllahir->CellAttributes() ?>>
<span id="el<?php echo $t_admission_delete->RowCnt ?>_t_admission_ket_tgllahir" class="t_admission_ket_tgllahir">
<span<?php echo $t_admission->ket_tgllahir->ViewAttributes() ?>>
<?php echo $t_admission->ket_tgllahir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission->ket_alamat->Visible) { // ket_alamat ?>
		<td<?php echo $t_admission->ket_alamat->CellAttributes() ?>>
<span id="el<?php echo $t_admission_delete->RowCnt ?>_t_admission_ket_alamat" class="t_admission_ket_alamat">
<span<?php echo $t_admission->ket_alamat->ViewAttributes() ?>>
<?php echo $t_admission->ket_alamat->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission->statusbayar->Visible) { // statusbayar ?>
		<td<?php echo $t_admission->statusbayar->CellAttributes() ?>>
<span id="el<?php echo $t_admission_delete->RowCnt ?>_t_admission_statusbayar" class="t_admission_statusbayar">
<span<?php echo $t_admission->statusbayar->ViewAttributes() ?>>
<?php echo $t_admission->statusbayar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission->masukrs->Visible) { // masukrs ?>
		<td<?php echo $t_admission->masukrs->CellAttributes() ?>>
<span id="el<?php echo $t_admission_delete->RowCnt ?>_t_admission_masukrs" class="t_admission_masukrs">
<span<?php echo $t_admission->masukrs->ViewAttributes() ?>>
<?php echo $t_admission->masukrs->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission->noruang->Visible) { // noruang ?>
		<td<?php echo $t_admission->noruang->CellAttributes() ?>>
<div id="orig<?php echo $t_admission_delete->RowCnt ?>_t_admission_noruang" class="hide">
<span id="el<?php echo $t_admission_delete->RowCnt ?>_t_admission_noruang" class="t_admission_noruang">
<span<?php echo $t_admission->noruang->ViewAttributes() ?>>
<?php echo $t_admission->noruang->ListViewValue() ?></span>
</span>
</div>
<?php
$flag = urlencode(CurrentPage()->noruang->CurrentValue);
if ($flag==0)
{
	print '<a class="btn btn-danger btn-xs">  Kamar belum di input</a>';
}else
{
	echo $t_admission->noruang->ListViewValue();
}
?>
</td>
<?php } ?>
<?php if ($t_admission->nott->Visible) { // nott ?>
		<td<?php echo $t_admission->nott->CellAttributes() ?>>
<div id="orig<?php echo $t_admission_delete->RowCnt ?>_t_admission_nott" class="hide">
<span id="el<?php echo $t_admission_delete->RowCnt ?>_t_admission_nott" class="t_admission_nott">
<span<?php echo $t_admission->nott->ViewAttributes() ?>>
<?php echo $t_admission->nott->ListViewValue() ?></span>
</span>
</div>
<?php
$flag = urlencode(CurrentPage()->nott->CurrentValue);
if ($flag==0)
{
	print '<a class="btn btn-danger btn-xs">  Bed belum di input</a>';
}else
{
	echo $t_admission->nott->ListViewValue();
}
?>
</td>
<?php } ?>
	</tr>
<?php
	$t_admission_delete->Recordset->MoveNext();
}
$t_admission_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_admission_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_admissiondelete.Init();
</script>
<?php
$t_admission_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_admission_delete->Page_Terminate();
?>
