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

$t_pendaftaran_edit = NULL; // Initialize page object first

class ct_pendaftaran_edit extends ct_pendaftaran {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_pendaftaran';

	// Page object name
	var $PageObjName = 't_pendaftaran_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->IDXDAFTAR->SetVisibility();
		$this->IDXDAFTAR->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->peserta_cob->SetVisibility();
		$this->poli_eksekutif->SetVisibility();
		$this->status_kepesertaan_BPJS->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["IDXDAFTAR"] <> "") {
			$this->IDXDAFTAR->setQueryStringValue($_GET["IDXDAFTAR"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->IDXDAFTAR->CurrentValue == "") {
			$this->Page_Terminate("t_pendaftaranlist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("t_pendaftaranlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t_pendaftaranlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->IDXDAFTAR->FldIsDetailKey)
			$this->IDXDAFTAR->setFormValue($objForm->GetValue("x_IDXDAFTAR"));
		if (!$this->peserta_cob->FldIsDetailKey) {
			$this->peserta_cob->setFormValue($objForm->GetValue("x_peserta_cob"));
		}
		if (!$this->poli_eksekutif->FldIsDetailKey) {
			$this->poli_eksekutif->setFormValue($objForm->GetValue("x_poli_eksekutif"));
		}
		if (!$this->status_kepesertaan_BPJS->FldIsDetailKey) {
			$this->status_kepesertaan_BPJS->setFormValue($objForm->GetValue("x_status_kepesertaan_BPJS"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->IDXDAFTAR->CurrentValue = $this->IDXDAFTAR->FormValue;
		$this->peserta_cob->CurrentValue = $this->peserta_cob->FormValue;
		$this->poli_eksekutif->CurrentValue = $this->poli_eksekutif->FormValue;
		$this->status_kepesertaan_BPJS->CurrentValue = $this->status_kepesertaan_BPJS->FormValue;
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
		// PASIENBARU
		// NOMR
		// TGLREG
		// KDDOKTER
		// KDPOLY
		// KDRUJUK
		// KDCARABAYAR
		// NOJAMINAN
		// SHIFT
		// STATUS
		// KETERANGAN_STATUS
		// NIP
		// MASUKPOLY
		// KELUARPOLY
		// KETRUJUK
		// KETBAYAR
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// JAMREG
		// BATAL
		// NO_SJP
		// NO_PESERTA
		// NOKARTU
		// TOTAL_BIAYA_OBAT
		// biaya_obat
		// biaya_retur_obat
		// TOTAL_BIAYA_OBAT_RAJAL
		// biaya_obat_rajal
		// biaya_retur_obat_rajal
		// TOTAL_BIAYA_OBAT_IGD
		// biaya_obat_igd
		// biaya_retur_obat_igd
		// TOTAL_BIAYA_OBAT_IBS
		// biaya_obat_ibs
		// biaya_retur_obat_ibs
		// TANGGAL_SEP
		// TANGGALRUJUK_SEP
		// KELASRAWAT_SEP
		// MINTA_RUJUKAN
		// NORUJUKAN_SEP
		// PPKRUJUKANASAL_SEP
		// NAMAPPKRUJUKANASAL_SEP
		// PPKPELAYANAN_SEP
		// JENISPERAWATAN_SEP
		// CATATAN_SEP
		// DIAGNOSAAWAL_SEP
		// NAMADIAGNOSA_SEP
		// LAKALANTAS_SEP
		// LOKASILAKALANTAS
		// USER
		// cek_data_kepesertaan
		// generate_sep
		// PESERTANIK_SEP
		// PESERTANAMA_SEP
		// PESERTAJENISKELAMIN_SEP
		// PESERTANAMAKELAS_SEP
		// PESERTAPISAT
		// PESERTATGLLAHIR
		// PESERTAJENISPESERTA_SEP
		// PESERTANAMAJENISPESERTA_SEP
		// PESERTATGLCETAKKARTU_SEP
		// POLITUJUAN_SEP
		// NAMAPOLITUJUAN_SEP
		// KDPPKRUJUKAN_SEP
		// NMPPKRUJUKAN_SEP
		// UPDATETGLPLNG_SEP
		// bridging_upt_tglplng
		// mapingtransaksi
		// bridging_no_rujukan
		// bridging_hapus_sep
		// bridging_kepesertaan_by_no_ka
		// NOKARTU_BPJS
		// counter_cetak_kartu
		// bridging_kepesertaan_by_nik
		// NOKTP
		// bridging_by_no_rujukan
		// maping_hapus_sep
		// counter_cetak_kartu_ranap
		// BIAYA_PENDAFTARAN
		// BIAYA_TINDAKAN_POLI
		// BIAYA_TINDAKAN_RADIOLOGI
		// BIAYA_TINDAKAN_LABORAT
		// BIAYA_TINDAKAN_KONSULTASI
		// BIAYA_TARIF_DOKTER
		// BIAYA_TARIF_DOKTER_KONSUL
		// INCLUDE
		// eklaim_kelas_rawat_rajal
		// eklaim_adl_score
		// eklaim_adl_sub_acute
		// eklaim_adl_chronic
		// eklaim_icu_indikator
		// eklaim_icu_los
		// eklaim_ventilator_hour
		// eklaim_upgrade_class_ind
		// eklaim_upgrade_class_class
		// eklaim_upgrade_class_los
		// eklaim_birth_weight
		// eklaim_discharge_status
		// eklaim_diagnosa
		// eklaim_procedure
		// eklaim_tarif_rs
		// eklaim_tarif_poli_eks
		// eklaim_id_dokter
		// eklaim_nama_dokter
		// eklaim_kode_tarif
		// eklaim_payor_id
		// eklaim_payor_cd
		// eklaim_coder_nik
		// eklaim_los
		// eklaim_patient_id
		// eklaim_admission_id
		// eklaim_hospital_admission_id
		// bridging_hapussep
		// user_penghapus_sep
		// BIAYA_BILLING_RAJAL
		// STATUS_PEMBAYARAN
		// BIAYA_TINDAKAN_FISIOTERAPI
		// eklaim_reg_pasien
		// eklaim_reg_klaim_baru
		// eklaim_gruper1
		// eklaim_gruper2
		// eklaim_finalklaim
		// eklaim_sendklaim
		// eklaim_flag_hapus_pasien
		// eklaim_flag_hapus_klaim
		// eklaim_kemkes_dc_Status
		// eklaim_bpjs_dc_Status
		// eklaim_cbg_code
		// eklaim_cbg_descprition
		// eklaim_cbg_tariff
		// eklaim_sub_acute_code
		// eklaim_sub_acute_deskripsi
		// eklaim_sub_acute_tariff
		// eklaim_chronic_code
		// eklaim_chronic_deskripsi
		// eklaim_chronic_tariff
		// eklaim_inacbg_version
		// BIAYA_TINDAKAN_IBS_RAJAL
		// VERIFY_ICD
		// bridging_rujukan_faskes_2
		// eklaim_reedit_claim
		// KETERANGAN
		// TGLLAHIR
		// USER_KASIR
		// eklaim_tgl_gruping
		// eklaim_tgl_finalklaim
		// eklaim_tgl_kirim_klaim
		// BIAYA_OBAT_RS
		// EKG_RAJAL
		// USG_RAJAL
		// FISIOTERAPI_RAJAL
		// BHP_RAJAL
		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		// TOTAL_BIAYA_IBS_RAJAL
		// ORDER_LAB
		// BILL_RAJAL_SELESAI
		// INCLUDE_IDXDAFTAR
		// INCLUDE_HARGA
		// TARIF_JASA_SARANA
		// TARIF_PENUNJANG_NON_MEDIS
		// TARIF_ASUHAN_KEPERAWATAN
		// KDDOKTER_RAJAL
		// KDDOKTER_KONSUL_RAJAL
		// BIAYA_BILLING_RS
		// BIAYA_TINDAKAN_POLI_TMO
		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		// BHP_RAJAL_TMO
		// BHP_RAJAL_KEPERAWATAN
		// TARIF_AKOMODASI
		// TARIF_AMBULAN
		// TARIF_OKSIGEN
		// BIAYA_TINDAKAN_JENAZAH
		// BIAYA_BILLING_IGD
		// BIAYA_TINDAKAN_POLI_PERSALINAN
		// BHP_RAJAL_PERSALINAN
		// TARIF_BIMBINGAN_ROHANI
		// BIAYA_BILLING_RS2
		// BIAYA_TARIF_DOKTER_IGD
		// BIAYA_PENDAFTARAN_IGD
		// BIAYA_BILLING_IBS
		// TARIF_JASA_SARANA_IGD
		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		// TARIF_MAKAN_IGD
		// TARIF_ASUHAN_KEPERAWATAN_IGD
		// pasien_TITLE
		// pasien_NAMA
		// pasien_TEMPAT
		// pasien_TGLLAHIR
		// pasien_JENISKELAMIN
		// pasien_ALAMAT
		// pasien_KELURAHAN
		// pasien_KDKECAMATAN
		// pasien_KOTA
		// pasien_KDPROVINSI
		// pasien_NOTELP
		// pasien_NOKTP
		// pasien_SUAMI_ORTU
		// pasien_PEKERJAAN
		// pasien_AGAMA
		// pasien_PENDIDIKAN
		// pasien_ALAMAT_KTP
		// pasien_NO_KARTU
		// pasien_JNS_PASIEN
		// pasien_nama_ayah
		// pasien_nama_ibu
		// pasien_nama_suami
		// pasien_nama_istri
		// pasien_KD_ETNIS
		// pasien_KD_BHS_HARIAN
		// BILL_FARMASI_SELESAI
		// TARIF_PELAYANAN_SIMRS
		// USER_ADM
		// TARIF_PENUNJANG_NON_MEDIS_IGD
		// TARIF_PELAYANAN_DARAH
		// penjamin_kkl_id
		// asalfaskesrujukan_id
		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// peserta_cob
		$this->peserta_cob->ViewValue = $this->peserta_cob->CurrentValue;
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->ViewValue = $this->status_kepesertaan_BPJS->CurrentValue;
		$this->status_kepesertaan_BPJS->ViewCustomAttributes = "";

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";
			$this->IDXDAFTAR->TooltipValue = "";

			// peserta_cob
			$this->peserta_cob->LinkCustomAttributes = "";
			$this->peserta_cob->HrefValue = "";
			$this->peserta_cob->TooltipValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";
			$this->poli_eksekutif->TooltipValue = "";

			// status_kepesertaan_BPJS
			$this->status_kepesertaan_BPJS->LinkCustomAttributes = "";
			$this->status_kepesertaan_BPJS->HrefValue = "";
			$this->status_kepesertaan_BPJS->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// IDXDAFTAR
			$this->IDXDAFTAR->EditAttrs["class"] = "form-control";
			$this->IDXDAFTAR->EditCustomAttributes = "";
			$this->IDXDAFTAR->EditValue = $this->IDXDAFTAR->CurrentValue;
			$this->IDXDAFTAR->ViewCustomAttributes = "";

			// peserta_cob
			$this->peserta_cob->EditAttrs["class"] = "form-control";
			$this->peserta_cob->EditCustomAttributes = "";
			$this->peserta_cob->EditValue = ew_HtmlEncode($this->peserta_cob->CurrentValue);
			$this->peserta_cob->PlaceHolder = ew_RemoveHtml($this->peserta_cob->FldCaption());

			// poli_eksekutif
			$this->poli_eksekutif->EditAttrs["class"] = "form-control";
			$this->poli_eksekutif->EditCustomAttributes = "";
			$this->poli_eksekutif->EditValue = ew_HtmlEncode($this->poli_eksekutif->CurrentValue);
			$this->poli_eksekutif->PlaceHolder = ew_RemoveHtml($this->poli_eksekutif->FldCaption());

			// status_kepesertaan_BPJS
			$this->status_kepesertaan_BPJS->EditAttrs["class"] = "form-control";
			$this->status_kepesertaan_BPJS->EditCustomAttributes = "";
			$this->status_kepesertaan_BPJS->EditValue = ew_HtmlEncode($this->status_kepesertaan_BPJS->CurrentValue);
			$this->status_kepesertaan_BPJS->PlaceHolder = ew_RemoveHtml($this->status_kepesertaan_BPJS->FldCaption());

			// Edit refer script
			// IDXDAFTAR

			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";

			// peserta_cob
			$this->peserta_cob->LinkCustomAttributes = "";
			$this->peserta_cob->HrefValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";

			// status_kepesertaan_BPJS
			$this->status_kepesertaan_BPJS->LinkCustomAttributes = "";
			$this->status_kepesertaan_BPJS->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->peserta_cob->FormValue)) {
			ew_AddMessage($gsFormError, $this->peserta_cob->FldErrMsg());
		}
		if (!ew_CheckInteger($this->poli_eksekutif->FormValue)) {
			ew_AddMessage($gsFormError, $this->poli_eksekutif->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// peserta_cob
			$this->peserta_cob->SetDbValueDef($rsnew, $this->peserta_cob->CurrentValue, NULL, $this->peserta_cob->ReadOnly);

			// poli_eksekutif
			$this->poli_eksekutif->SetDbValueDef($rsnew, $this->poli_eksekutif->CurrentValue, NULL, $this->poli_eksekutif->ReadOnly);

			// status_kepesertaan_BPJS
			$this->status_kepesertaan_BPJS->SetDbValueDef($rsnew, $this->status_kepesertaan_BPJS->CurrentValue, NULL, $this->status_kepesertaan_BPJS->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_pendaftaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_pendaftaran_edit)) $t_pendaftaran_edit = new ct_pendaftaran_edit();

// Page init
$t_pendaftaran_edit->Page_Init();

// Page main
$t_pendaftaran_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_pendaftaran_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft_pendaftaranedit = new ew_Form("ft_pendaftaranedit", "edit");

// Validate form
ft_pendaftaranedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_peserta_cob");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->peserta_cob->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_poli_eksekutif");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->poli_eksekutif->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ft_pendaftaranedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_pendaftaranedit.ValidateRequired = true;
<?php } else { ?>
ft_pendaftaranedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_pendaftaran_edit->IsModal) { ?>
<?php } ?>
<?php $t_pendaftaran_edit->ShowPageHeader(); ?>
<?php
$t_pendaftaran_edit->ShowMessage();
?>
<form name="ft_pendaftaranedit" id="ft_pendaftaranedit" class="<?php echo $t_pendaftaran_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_pendaftaran_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_pendaftaran_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_pendaftaran">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t_pendaftaran_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_pendaftaran->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<div id="r_IDXDAFTAR" class="form-group">
		<label id="elh_t_pendaftaran_IDXDAFTAR" class="col-sm-2 control-label ewLabel"><?php echo $t_pendaftaran->IDXDAFTAR->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->IDXDAFTAR->CellAttributes() ?>>
<span id="el_t_pendaftaran_IDXDAFTAR">
<span<?php echo $t_pendaftaran->IDXDAFTAR->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_pendaftaran->IDXDAFTAR->EditValue ?></p></span>
</span>
<input type="hidden" data-table="t_pendaftaran" data-field="x_IDXDAFTAR" name="x_IDXDAFTAR" id="x_IDXDAFTAR" value="<?php echo ew_HtmlEncode($t_pendaftaran->IDXDAFTAR->CurrentValue) ?>">
<?php echo $t_pendaftaran->IDXDAFTAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->peserta_cob->Visible) { // peserta_cob ?>
	<div id="r_peserta_cob" class="form-group">
		<label id="elh_t_pendaftaran_peserta_cob" for="x_peserta_cob" class="col-sm-2 control-label ewLabel"><?php echo $t_pendaftaran->peserta_cob->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->peserta_cob->CellAttributes() ?>>
<span id="el_t_pendaftaran_peserta_cob">
<input type="text" data-table="t_pendaftaran" data-field="x_peserta_cob" name="x_peserta_cob" id="x_peserta_cob" size="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->peserta_cob->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->peserta_cob->EditValue ?>"<?php echo $t_pendaftaran->peserta_cob->EditAttributes() ?>>
</span>
<?php echo $t_pendaftaran->peserta_cob->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<div id="r_poli_eksekutif" class="form-group">
		<label id="elh_t_pendaftaran_poli_eksekutif" for="x_poli_eksekutif" class="col-sm-2 control-label ewLabel"><?php echo $t_pendaftaran->poli_eksekutif->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->poli_eksekutif->CellAttributes() ?>>
<span id="el_t_pendaftaran_poli_eksekutif">
<input type="text" data-table="t_pendaftaran" data-field="x_poli_eksekutif" name="x_poli_eksekutif" id="x_poli_eksekutif" size="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->poli_eksekutif->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->poli_eksekutif->EditValue ?>"<?php echo $t_pendaftaran->poli_eksekutif->EditAttributes() ?>>
</span>
<?php echo $t_pendaftaran->poli_eksekutif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->status_kepesertaan_BPJS->Visible) { // status_kepesertaan_BPJS ?>
	<div id="r_status_kepesertaan_BPJS" class="form-group">
		<label id="elh_t_pendaftaran_status_kepesertaan_BPJS" for="x_status_kepesertaan_BPJS" class="col-sm-2 control-label ewLabel"><?php echo $t_pendaftaran->status_kepesertaan_BPJS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->status_kepesertaan_BPJS->CellAttributes() ?>>
<span id="el_t_pendaftaran_status_kepesertaan_BPJS">
<input type="text" data-table="t_pendaftaran" data-field="x_status_kepesertaan_BPJS" name="x_status_kepesertaan_BPJS" id="x_status_kepesertaan_BPJS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->status_kepesertaan_BPJS->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->status_kepesertaan_BPJS->EditValue ?>"<?php echo $t_pendaftaran->status_kepesertaan_BPJS->EditAttributes() ?>>
</span>
<?php echo $t_pendaftaran->status_kepesertaan_BPJS->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_pendaftaran_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_pendaftaran_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_pendaftaranedit.Init();
</script>
<?php
$t_pendaftaran_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_pendaftaran_edit->Page_Terminate();
?>
