<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bridging_sep_by_no_rujukaninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bridging_sep_by_no_rujukan_add = NULL; // Initialize page object first

class cvw_bridging_sep_by_no_rujukan_add extends cvw_bridging_sep_by_no_rujukan {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bridging_sep_by_no_rujukan';

	// Page object name
	var $PageObjName = 'vw_bridging_sep_by_no_rujukan_add';

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

		// Table object (vw_bridging_sep_by_no_rujukan)
		if (!isset($GLOBALS["vw_bridging_sep_by_no_rujukan"]) || get_class($GLOBALS["vw_bridging_sep_by_no_rujukan"]) == "cvw_bridging_sep_by_no_rujukan") {
			$GLOBALS["vw_bridging_sep_by_no_rujukan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bridging_sep_by_no_rujukan"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bridging_sep_by_no_rujukan', TRUE);

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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("vw_bridging_sep_by_no_rujukanlist.php"));
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
		$this->pasien_NOTELP->SetVisibility();
		$this->penjamin_kkl_id->SetVisibility();
		$this->asalfaskesrujukan_id->SetVisibility();
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
		global $EW_EXPORT, $vw_bridging_sep_by_no_rujukan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bridging_sep_by_no_rujukan);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["IDXDAFTAR"] != "") {
				$this->IDXDAFTAR->setQueryStringValue($_GET["IDXDAFTAR"]);
				$this->setKey("IDXDAFTAR", $this->IDXDAFTAR->CurrentValue); // Set up key
			} else {
				$this->setKey("IDXDAFTAR", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("vw_bridging_sep_by_no_rujukanlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_bridging_sep_by_no_rujukanlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_bridging_sep_by_no_rujukanview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->pasien_NOTELP->CurrentValue = NULL;
		$this->pasien_NOTELP->OldValue = $this->pasien_NOTELP->CurrentValue;
		$this->penjamin_kkl_id->CurrentValue = 0;
		$this->asalfaskesrujukan_id->CurrentValue = NULL;
		$this->asalfaskesrujukan_id->OldValue = $this->asalfaskesrujukan_id->CurrentValue;
		$this->peserta_cob->CurrentValue = 0;
		$this->poli_eksekutif->CurrentValue = 0;
		$this->status_kepesertaan_BPJS->CurrentValue = NULL;
		$this->status_kepesertaan_BPJS->OldValue = $this->status_kepesertaan_BPJS->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->pasien_NOTELP->FldIsDetailKey) {
			$this->pasien_NOTELP->setFormValue($objForm->GetValue("x_pasien_NOTELP"));
		}
		if (!$this->penjamin_kkl_id->FldIsDetailKey) {
			$this->penjamin_kkl_id->setFormValue($objForm->GetValue("x_penjamin_kkl_id"));
		}
		if (!$this->asalfaskesrujukan_id->FldIsDetailKey) {
			$this->asalfaskesrujukan_id->setFormValue($objForm->GetValue("x_asalfaskesrujukan_id"));
		}
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
		$this->LoadOldRecord();
		$this->pasien_NOTELP->CurrentValue = $this->pasien_NOTELP->FormValue;
		$this->penjamin_kkl_id->CurrentValue = $this->penjamin_kkl_id->FormValue;
		$this->asalfaskesrujukan_id->CurrentValue = $this->asalfaskesrujukan_id->FormValue;
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
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->JAMREG->setDbValue($rs->fields('JAMREG'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
		$this->NOKARTU->setDbValue($rs->fields('NOKARTU'));
		$this->TANGGAL_SEP->setDbValue($rs->fields('TANGGAL_SEP'));
		$this->TANGGALRUJUK_SEP->setDbValue($rs->fields('TANGGALRUJUK_SEP'));
		$this->KELASRAWAT_SEP->setDbValue($rs->fields('KELASRAWAT_SEP'));
		$this->NORUJUKAN_SEP->setDbValue($rs->fields('NORUJUKAN_SEP'));
		$this->PPKPELAYANAN_SEP->setDbValue($rs->fields('PPKPELAYANAN_SEP'));
		$this->JENISPERAWATAN_SEP->setDbValue($rs->fields('JENISPERAWATAN_SEP'));
		$this->CATATAN_SEP->setDbValue($rs->fields('CATATAN_SEP'));
		$this->DIAGNOSAAWAL_SEP->setDbValue($rs->fields('DIAGNOSAAWAL_SEP'));
		$this->NAMADIAGNOSA_SEP->setDbValue($rs->fields('NAMADIAGNOSA_SEP'));
		$this->LAKALANTAS_SEP->setDbValue($rs->fields('LAKALANTAS_SEP'));
		$this->LOKASILAKALANTAS->setDbValue($rs->fields('LOKASILAKALANTAS'));
		$this->USER->setDbValue($rs->fields('USER'));
		$this->generate_sep->setDbValue($rs->fields('generate_sep'));
		$this->PESERTANIK_SEP->setDbValue($rs->fields('PESERTANIK_SEP'));
		$this->PESERTANAMA_SEP->setDbValue($rs->fields('PESERTANAMA_SEP'));
		$this->PESERTAJENISKELAMIN_SEP->setDbValue($rs->fields('PESERTAJENISKELAMIN_SEP'));
		$this->PESERTANAMAKELAS_SEP->setDbValue($rs->fields('PESERTANAMAKELAS_SEP'));
		$this->PESERTAPISAT->setDbValue($rs->fields('PESERTAPISAT'));
		$this->PESERTATGLLAHIR->setDbValue($rs->fields('PESERTATGLLAHIR'));
		$this->PESERTAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTAJENISPESERTA_SEP'));
		$this->PESERTANAMAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTANAMAJENISPESERTA_SEP'));
		$this->POLITUJUAN_SEP->setDbValue($rs->fields('POLITUJUAN_SEP'));
		$this->NAMAPOLITUJUAN_SEP->setDbValue($rs->fields('NAMAPOLITUJUAN_SEP'));
		$this->KDPPKRUJUKAN_SEP->setDbValue($rs->fields('KDPPKRUJUKAN_SEP'));
		$this->NMPPKRUJUKAN_SEP->setDbValue($rs->fields('NMPPKRUJUKAN_SEP'));
		$this->mapingtransaksi->setDbValue($rs->fields('mapingtransaksi'));
		$this->bridging_by_no_rujukan->setDbValue($rs->fields('bridging_by_no_rujukan'));
		$this->bridging_rujukan_faskes_2->setDbValue($rs->fields('bridging_rujukan_faskes_2'));
		$this->pasien_NOTELP->setDbValue($rs->fields('pasien_NOTELP'));
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
		$this->NOMR->DbValue = $row['NOMR'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NIP->DbValue = $row['NIP'];
		$this->JAMREG->DbValue = $row['JAMREG'];
		$this->NO_SJP->DbValue = $row['NO_SJP'];
		$this->NOKARTU->DbValue = $row['NOKARTU'];
		$this->TANGGAL_SEP->DbValue = $row['TANGGAL_SEP'];
		$this->TANGGALRUJUK_SEP->DbValue = $row['TANGGALRUJUK_SEP'];
		$this->KELASRAWAT_SEP->DbValue = $row['KELASRAWAT_SEP'];
		$this->NORUJUKAN_SEP->DbValue = $row['NORUJUKAN_SEP'];
		$this->PPKPELAYANAN_SEP->DbValue = $row['PPKPELAYANAN_SEP'];
		$this->JENISPERAWATAN_SEP->DbValue = $row['JENISPERAWATAN_SEP'];
		$this->CATATAN_SEP->DbValue = $row['CATATAN_SEP'];
		$this->DIAGNOSAAWAL_SEP->DbValue = $row['DIAGNOSAAWAL_SEP'];
		$this->NAMADIAGNOSA_SEP->DbValue = $row['NAMADIAGNOSA_SEP'];
		$this->LAKALANTAS_SEP->DbValue = $row['LAKALANTAS_SEP'];
		$this->LOKASILAKALANTAS->DbValue = $row['LOKASILAKALANTAS'];
		$this->USER->DbValue = $row['USER'];
		$this->generate_sep->DbValue = $row['generate_sep'];
		$this->PESERTANIK_SEP->DbValue = $row['PESERTANIK_SEP'];
		$this->PESERTANAMA_SEP->DbValue = $row['PESERTANAMA_SEP'];
		$this->PESERTAJENISKELAMIN_SEP->DbValue = $row['PESERTAJENISKELAMIN_SEP'];
		$this->PESERTANAMAKELAS_SEP->DbValue = $row['PESERTANAMAKELAS_SEP'];
		$this->PESERTAPISAT->DbValue = $row['PESERTAPISAT'];
		$this->PESERTATGLLAHIR->DbValue = $row['PESERTATGLLAHIR'];
		$this->PESERTAJENISPESERTA_SEP->DbValue = $row['PESERTAJENISPESERTA_SEP'];
		$this->PESERTANAMAJENISPESERTA_SEP->DbValue = $row['PESERTANAMAJENISPESERTA_SEP'];
		$this->POLITUJUAN_SEP->DbValue = $row['POLITUJUAN_SEP'];
		$this->NAMAPOLITUJUAN_SEP->DbValue = $row['NAMAPOLITUJUAN_SEP'];
		$this->KDPPKRUJUKAN_SEP->DbValue = $row['KDPPKRUJUKAN_SEP'];
		$this->NMPPKRUJUKAN_SEP->DbValue = $row['NMPPKRUJUKAN_SEP'];
		$this->mapingtransaksi->DbValue = $row['mapingtransaksi'];
		$this->bridging_by_no_rujukan->DbValue = $row['bridging_by_no_rujukan'];
		$this->bridging_rujukan_faskes_2->DbValue = $row['bridging_rujukan_faskes_2'];
		$this->pasien_NOTELP->DbValue = $row['pasien_NOTELP'];
		$this->penjamin_kkl_id->DbValue = $row['penjamin_kkl_id'];
		$this->asalfaskesrujukan_id->DbValue = $row['asalfaskesrujukan_id'];
		$this->peserta_cob->DbValue = $row['peserta_cob'];
		$this->poli_eksekutif->DbValue = $row['poli_eksekutif'];
		$this->status_kepesertaan_BPJS->DbValue = $row['status_kepesertaan_BPJS'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("IDXDAFTAR")) <> "")
			$this->IDXDAFTAR->CurrentValue = $this->getKey("IDXDAFTAR"); // IDXDAFTAR
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXDAFTAR
		// NOMR
		// KDPOLY
		// TGLREG
		// KDCARABAYAR
		// NIP
		// JAMREG
		// NO_SJP
		// NOKARTU
		// TANGGAL_SEP
		// TANGGALRUJUK_SEP
		// KELASRAWAT_SEP
		// NORUJUKAN_SEP
		// PPKPELAYANAN_SEP
		// JENISPERAWATAN_SEP
		// CATATAN_SEP
		// DIAGNOSAAWAL_SEP
		// NAMADIAGNOSA_SEP
		// LAKALANTAS_SEP
		// LOKASILAKALANTAS
		// USER
		// generate_sep
		// PESERTANIK_SEP
		// PESERTANAMA_SEP
		// PESERTAJENISKELAMIN_SEP
		// PESERTANAMAKELAS_SEP
		// PESERTAPISAT
		// PESERTATGLLAHIR
		// PESERTAJENISPESERTA_SEP
		// PESERTANAMAJENISPESERTA_SEP
		// POLITUJUAN_SEP
		// NAMAPOLITUJUAN_SEP
		// KDPPKRUJUKAN_SEP
		// NMPPKRUJUKAN_SEP
		// mapingtransaksi
		// bridging_by_no_rujukan
		// bridging_rujukan_faskes_2
		// pasien_NOTELP
		// penjamin_kkl_id
		// asalfaskesrujukan_id
		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// pasien_NOTELP
		$this->pasien_NOTELP->ViewValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->ViewCustomAttributes = "";

		// penjamin_kkl_id
		if (strval($this->penjamin_kkl_id->CurrentValue) <> "") {
			$this->penjamin_kkl_id->ViewValue = $this->penjamin_kkl_id->OptionCaption($this->penjamin_kkl_id->CurrentValue);
		} else {
			$this->penjamin_kkl_id->ViewValue = NULL;
		}
		$this->penjamin_kkl_id->ViewCustomAttributes = "";

		// asalfaskesrujukan_id
		if (strval($this->asalfaskesrujukan_id->CurrentValue) <> "") {
			$this->asalfaskesrujukan_id->ViewValue = $this->asalfaskesrujukan_id->OptionCaption($this->asalfaskesrujukan_id->CurrentValue);
		} else {
			$this->asalfaskesrujukan_id->ViewValue = NULL;
		}
		$this->asalfaskesrujukan_id->ViewCustomAttributes = "";

		// peserta_cob
		if (strval($this->peserta_cob->CurrentValue) <> "") {
			$this->peserta_cob->ViewValue = $this->peserta_cob->OptionCaption($this->peserta_cob->CurrentValue);
		} else {
			$this->peserta_cob->ViewValue = NULL;
		}
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		if (strval($this->poli_eksekutif->CurrentValue) <> "") {
			$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->OptionCaption($this->poli_eksekutif->CurrentValue);
		} else {
			$this->poli_eksekutif->ViewValue = NULL;
		}
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->ViewValue = $this->status_kepesertaan_BPJS->CurrentValue;
		$this->status_kepesertaan_BPJS->ViewCustomAttributes = "";

			// pasien_NOTELP
			$this->pasien_NOTELP->LinkCustomAttributes = "";
			$this->pasien_NOTELP->HrefValue = "";
			$this->pasien_NOTELP->TooltipValue = "";

			// penjamin_kkl_id
			$this->penjamin_kkl_id->LinkCustomAttributes = "";
			$this->penjamin_kkl_id->HrefValue = "";
			$this->penjamin_kkl_id->TooltipValue = "";

			// asalfaskesrujukan_id
			$this->asalfaskesrujukan_id->LinkCustomAttributes = "";
			$this->asalfaskesrujukan_id->HrefValue = "";
			$this->asalfaskesrujukan_id->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// pasien_NOTELP
			$this->pasien_NOTELP->EditAttrs["class"] = "form-control";
			$this->pasien_NOTELP->EditCustomAttributes = "";
			$this->pasien_NOTELP->EditValue = ew_HtmlEncode($this->pasien_NOTELP->CurrentValue);
			$this->pasien_NOTELP->PlaceHolder = ew_RemoveHtml($this->pasien_NOTELP->FldCaption());

			// penjamin_kkl_id
			$this->penjamin_kkl_id->EditAttrs["class"] = "form-control";
			$this->penjamin_kkl_id->EditCustomAttributes = "";
			$this->penjamin_kkl_id->EditValue = $this->penjamin_kkl_id->Options(TRUE);

			// asalfaskesrujukan_id
			$this->asalfaskesrujukan_id->EditAttrs["class"] = "form-control";
			$this->asalfaskesrujukan_id->EditCustomAttributes = "";
			$this->asalfaskesrujukan_id->EditValue = $this->asalfaskesrujukan_id->Options(TRUE);

			// peserta_cob
			$this->peserta_cob->EditAttrs["class"] = "form-control";
			$this->peserta_cob->EditCustomAttributes = "";
			$this->peserta_cob->EditValue = $this->peserta_cob->Options(TRUE);

			// poli_eksekutif
			$this->poli_eksekutif->EditAttrs["class"] = "form-control";
			$this->poli_eksekutif->EditCustomAttributes = "";
			$this->poli_eksekutif->EditValue = $this->poli_eksekutif->Options(TRUE);

			// status_kepesertaan_BPJS
			$this->status_kepesertaan_BPJS->EditAttrs["class"] = "form-control";
			$this->status_kepesertaan_BPJS->EditCustomAttributes = "";
			$this->status_kepesertaan_BPJS->EditValue = ew_HtmlEncode($this->status_kepesertaan_BPJS->CurrentValue);
			$this->status_kepesertaan_BPJS->PlaceHolder = ew_RemoveHtml($this->status_kepesertaan_BPJS->FldCaption());

			// Add refer script
			// pasien_NOTELP

			$this->pasien_NOTELP->LinkCustomAttributes = "";
			$this->pasien_NOTELP->HrefValue = "";

			// penjamin_kkl_id
			$this->penjamin_kkl_id->LinkCustomAttributes = "";
			$this->penjamin_kkl_id->HrefValue = "";

			// asalfaskesrujukan_id
			$this->asalfaskesrujukan_id->LinkCustomAttributes = "";
			$this->asalfaskesrujukan_id->HrefValue = "";

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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// pasien_NOTELP
		$this->pasien_NOTELP->SetDbValueDef($rsnew, $this->pasien_NOTELP->CurrentValue, NULL, FALSE);

		// penjamin_kkl_id
		$this->penjamin_kkl_id->SetDbValueDef($rsnew, $this->penjamin_kkl_id->CurrentValue, NULL, strval($this->penjamin_kkl_id->CurrentValue) == "");

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->SetDbValueDef($rsnew, $this->asalfaskesrujukan_id->CurrentValue, NULL, FALSE);

		// peserta_cob
		$this->peserta_cob->SetDbValueDef($rsnew, $this->peserta_cob->CurrentValue, NULL, strval($this->peserta_cob->CurrentValue) == "");

		// poli_eksekutif
		$this->poli_eksekutif->SetDbValueDef($rsnew, $this->poli_eksekutif->CurrentValue, NULL, strval($this->poli_eksekutif->CurrentValue) == "");

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->SetDbValueDef($rsnew, $this->status_kepesertaan_BPJS->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bridging_sep_by_no_rujukanlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($vw_bridging_sep_by_no_rujukan_add)) $vw_bridging_sep_by_no_rujukan_add = new cvw_bridging_sep_by_no_rujukan_add();

// Page init
$vw_bridging_sep_by_no_rujukan_add->Page_Init();

// Page main
$vw_bridging_sep_by_no_rujukan_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bridging_sep_by_no_rujukan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_bridging_sep_by_no_rujukanadd = new ew_Form("fvw_bridging_sep_by_no_rujukanadd", "add");

// Validate form
fvw_bridging_sep_by_no_rujukanadd.Validate = function() {
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
fvw_bridging_sep_by_no_rujukanadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bridging_sep_by_no_rujukanadd.ValidateRequired = true;
<?php } else { ?>
fvw_bridging_sep_by_no_rujukanadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bridging_sep_by_no_rujukanadd.Lists["x_penjamin_kkl_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanadd.Lists["x_penjamin_kkl_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->Options()) ?>;
fvw_bridging_sep_by_no_rujukanadd.Lists["x_asalfaskesrujukan_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanadd.Lists["x_asalfaskesrujukan_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->Options()) ?>;
fvw_bridging_sep_by_no_rujukanadd.Lists["x_peserta_cob"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanadd.Lists["x_peserta_cob"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->peserta_cob->Options()) ?>;
fvw_bridging_sep_by_no_rujukanadd.Lists["x_poli_eksekutif"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanadd.Lists["x_poli_eksekutif"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->poli_eksekutif->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_bridging_sep_by_no_rujukan_add->IsModal) { ?>
<?php } ?>
<?php $vw_bridging_sep_by_no_rujukan_add->ShowPageHeader(); ?>
<?php
$vw_bridging_sep_by_no_rujukan_add->ShowMessage();
?>
<form name="fvw_bridging_sep_by_no_rujukanadd" id="fvw_bridging_sep_by_no_rujukanadd" class="<?php echo $vw_bridging_sep_by_no_rujukan_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bridging_sep_by_no_rujukan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bridging_sep_by_no_rujukan">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_bridging_sep_by_no_rujukan_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_bridging_sep_by_no_rujukan->pasien_NOTELP->Visible) { // pasien_NOTELP ?>
	<div id="r_pasien_NOTELP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_pasien_NOTELP" for="x_pasien_NOTELP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_rujukan_pasien_NOTELP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_pasien_NOTELP" name="x_pasien_NOTELP" id="x_pasien_NOTELP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->pasien_NOTELP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->Visible) { // penjamin_kkl_id ?>
	<div id="r_penjamin_kkl_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_penjamin_kkl_id" for="x_penjamin_kkl_id" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_rujukan_penjamin_kkl_id">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_penjamin_kkl_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->DisplayValueSeparatorAttribute() ?>" id="x_penjamin_kkl_id" name="x_penjamin_kkl_id"<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->SelectOptionListHtml("x_penjamin_kkl_id") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->Visible) { // asalfaskesrujukan_id ?>
	<div id="r_asalfaskesrujukan_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_asalfaskesrujukan_id" for="x_asalfaskesrujukan_id" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_rujukan_asalfaskesrujukan_id">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_asalfaskesrujukan_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->DisplayValueSeparatorAttribute() ?>" id="x_asalfaskesrujukan_id" name="x_asalfaskesrujukan_id"<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->SelectOptionListHtml("x_asalfaskesrujukan_id") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->peserta_cob->Visible) { // peserta_cob ?>
	<div id="r_peserta_cob" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_peserta_cob" for="x_peserta_cob" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_rujukan_peserta_cob">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_peserta_cob" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->DisplayValueSeparatorAttribute() ?>" id="x_peserta_cob" name="x_peserta_cob"<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->SelectOptionListHtml("x_peserta_cob") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<div id="r_poli_eksekutif" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_poli_eksekutif" for="x_poli_eksekutif" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_rujukan_poli_eksekutif">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_poli_eksekutif" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->DisplayValueSeparatorAttribute() ?>" id="x_poli_eksekutif" name="x_poli_eksekutif"<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->SelectOptionListHtml("x_poli_eksekutif") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->Visible) { // status_kepesertaan_BPJS ?>
	<div id="r_status_kepesertaan_BPJS" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_status_kepesertaan_BPJS" for="x_status_kepesertaan_BPJS" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_rujukan_status_kepesertaan_BPJS">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_status_kepesertaan_BPJS" name="x_status_kepesertaan_BPJS" id="x_status_kepesertaan_BPJS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_bridging_sep_by_no_rujukan_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bridging_sep_by_no_rujukan_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_bridging_sep_by_no_rujukanadd.Init();
</script>
<?php
$vw_bridging_sep_by_no_rujukan_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bridging_sep_by_no_rujukan_add->Page_Terminate();
?>
