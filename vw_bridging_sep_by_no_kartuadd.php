<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bridging_sep_by_no_kartuinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bridging_sep_by_no_kartu_add = NULL; // Initialize page object first

class cvw_bridging_sep_by_no_kartu_add extends cvw_bridging_sep_by_no_kartu {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bridging_sep_by_no_kartu';

	// Page object name
	var $PageObjName = 'vw_bridging_sep_by_no_kartu_add';

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

		// Table object (vw_bridging_sep_by_no_kartu)
		if (!isset($GLOBALS["vw_bridging_sep_by_no_kartu"]) || get_class($GLOBALS["vw_bridging_sep_by_no_kartu"]) == "cvw_bridging_sep_by_no_kartu") {
			$GLOBALS["vw_bridging_sep_by_no_kartu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bridging_sep_by_no_kartu"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bridging_sep_by_no_kartu', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_bridging_sep_by_no_kartulist.php"));
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
		$this->NOMR->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->NIP->SetVisibility();
		$this->TGLREG->SetVisibility();
		$this->JAMREG->SetVisibility();
		$this->NO_SJP->SetVisibility();
		$this->NOKARTU->SetVisibility();
		$this->TANGGAL_SEP->SetVisibility();
		$this->TANGGALRUJUK_SEP->SetVisibility();
		$this->KELASRAWAT_SEP->SetVisibility();
		$this->NORUJUKAN_SEP->SetVisibility();
		$this->PPKPELAYANAN_SEP->SetVisibility();
		$this->JENISPERAWATAN_SEP->SetVisibility();
		$this->CATATAN_SEP->SetVisibility();
		$this->DIAGNOSAAWAL_SEP->SetVisibility();
		$this->NAMADIAGNOSA_SEP->SetVisibility();
		$this->LAKALANTAS_SEP->SetVisibility();
		$this->LOKASILAKALANTAS->SetVisibility();
		$this->USER->SetVisibility();
		$this->PESERTANIK_SEP->SetVisibility();
		$this->PESERTANAMA_SEP->SetVisibility();
		$this->PESERTAJENISKELAMIN_SEP->SetVisibility();
		$this->PESERTANAMAKELAS_SEP->SetVisibility();
		$this->PESERTAPISAT->SetVisibility();
		$this->PESERTATGLLAHIR->SetVisibility();
		$this->PESERTAJENISPESERTA_SEP->SetVisibility();
		$this->PESERTANAMAJENISPESERTA_SEP->SetVisibility();
		$this->POLITUJUAN_SEP->SetVisibility();
		$this->NAMAPOLITUJUAN_SEP->SetVisibility();
		$this->KDPPKRUJUKAN_SEP->SetVisibility();
		$this->NMPPKRUJUKAN_SEP->SetVisibility();
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
		global $EW_EXPORT, $vw_bridging_sep_by_no_kartu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bridging_sep_by_no_kartu);
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
					$this->Page_Terminate("vw_bridging_sep_by_no_kartulist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_bridging_sep_by_no_kartulist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_bridging_sep_by_no_kartuview.php")
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
		$this->NOMR->CurrentValue = NULL;
		$this->NOMR->OldValue = $this->NOMR->CurrentValue;
		$this->KDPOLY->CurrentValue = NULL;
		$this->KDPOLY->OldValue = $this->KDPOLY->CurrentValue;
		$this->KDCARABAYAR->CurrentValue = NULL;
		$this->KDCARABAYAR->OldValue = $this->KDCARABAYAR->CurrentValue;
		$this->NIP->CurrentValue = NULL;
		$this->NIP->OldValue = $this->NIP->CurrentValue;
		$this->TGLREG->CurrentValue = NULL;
		$this->TGLREG->OldValue = $this->TGLREG->CurrentValue;
		$this->JAMREG->CurrentValue = NULL;
		$this->JAMREG->OldValue = $this->JAMREG->CurrentValue;
		$this->NO_SJP->CurrentValue = NULL;
		$this->NO_SJP->OldValue = $this->NO_SJP->CurrentValue;
		$this->NOKARTU->CurrentValue = NULL;
		$this->NOKARTU->OldValue = $this->NOKARTU->CurrentValue;
		$this->TANGGAL_SEP->CurrentValue = date("Y/m/d");
		$this->TANGGALRUJUK_SEP->CurrentValue = date("Y/m/d");
		$this->KELASRAWAT_SEP->CurrentValue = NULL;
		$this->KELASRAWAT_SEP->OldValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->CurrentValue = NULL;
		$this->NORUJUKAN_SEP->OldValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->CurrentValue = NULL;
		$this->PPKPELAYANAN_SEP->OldValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->JENISPERAWATAN_SEP->CurrentValue = 2;
		$this->CATATAN_SEP->CurrentValue = NULL;
		$this->CATATAN_SEP->OldValue = $this->CATATAN_SEP->CurrentValue;
		$this->DIAGNOSAAWAL_SEP->CurrentValue = NULL;
		$this->DIAGNOSAAWAL_SEP->OldValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->CurrentValue = NULL;
		$this->NAMADIAGNOSA_SEP->OldValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->LAKALANTAS_SEP->CurrentValue = 2;
		$this->LOKASILAKALANTAS->CurrentValue = NULL;
		$this->LOKASILAKALANTAS->OldValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->USER->CurrentValue = NULL;
		$this->USER->OldValue = $this->USER->CurrentValue;
		$this->PESERTANIK_SEP->CurrentValue = NULL;
		$this->PESERTANIK_SEP->OldValue = $this->PESERTANIK_SEP->CurrentValue;
		$this->PESERTANAMA_SEP->CurrentValue = NULL;
		$this->PESERTANAMA_SEP->OldValue = $this->PESERTANAMA_SEP->CurrentValue;
		$this->PESERTAJENISKELAMIN_SEP->CurrentValue = NULL;
		$this->PESERTAJENISKELAMIN_SEP->OldValue = $this->PESERTAJENISKELAMIN_SEP->CurrentValue;
		$this->PESERTANAMAKELAS_SEP->CurrentValue = NULL;
		$this->PESERTANAMAKELAS_SEP->OldValue = $this->PESERTANAMAKELAS_SEP->CurrentValue;
		$this->PESERTAPISAT->CurrentValue = NULL;
		$this->PESERTAPISAT->OldValue = $this->PESERTAPISAT->CurrentValue;
		$this->PESERTATGLLAHIR->CurrentValue = NULL;
		$this->PESERTATGLLAHIR->OldValue = $this->PESERTATGLLAHIR->CurrentValue;
		$this->PESERTAJENISPESERTA_SEP->CurrentValue = NULL;
		$this->PESERTAJENISPESERTA_SEP->OldValue = $this->PESERTAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTANAMAJENISPESERTA_SEP->CurrentValue = NULL;
		$this->PESERTANAMAJENISPESERTA_SEP->OldValue = $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue;
		$this->POLITUJUAN_SEP->CurrentValue = NULL;
		$this->POLITUJUAN_SEP->OldValue = $this->POLITUJUAN_SEP->CurrentValue;
		$this->NAMAPOLITUJUAN_SEP->CurrentValue = NULL;
		$this->NAMAPOLITUJUAN_SEP->OldValue = $this->NAMAPOLITUJUAN_SEP->CurrentValue;
		$this->KDPPKRUJUKAN_SEP->CurrentValue = NULL;
		$this->KDPPKRUJUKAN_SEP->OldValue = $this->KDPPKRUJUKAN_SEP->CurrentValue;
		$this->NMPPKRUJUKAN_SEP->CurrentValue = NULL;
		$this->NMPPKRUJUKAN_SEP->OldValue = $this->NMPPKRUJUKAN_SEP->CurrentValue;
		$this->pasien_NOTELP->CurrentValue = NULL;
		$this->pasien_NOTELP->OldValue = $this->pasien_NOTELP->CurrentValue;
		$this->penjamin_kkl_id->CurrentValue = NULL;
		$this->penjamin_kkl_id->OldValue = $this->penjamin_kkl_id->CurrentValue;
		$this->asalfaskesrujukan_id->CurrentValue = 1;
		$this->peserta_cob->CurrentValue = 0;
		$this->poli_eksekutif->CurrentValue = 0;
		$this->status_kepesertaan_BPJS->CurrentValue = NULL;
		$this->status_kepesertaan_BPJS->OldValue = $this->status_kepesertaan_BPJS->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->NOMR->FldIsDetailKey) {
			$this->NOMR->setFormValue($objForm->GetValue("x_NOMR"));
		}
		if (!$this->KDPOLY->FldIsDetailKey) {
			$this->KDPOLY->setFormValue($objForm->GetValue("x_KDPOLY"));
		}
		if (!$this->KDCARABAYAR->FldIsDetailKey) {
			$this->KDCARABAYAR->setFormValue($objForm->GetValue("x_KDCARABAYAR"));
		}
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->TGLREG->FldIsDetailKey) {
			$this->TGLREG->setFormValue($objForm->GetValue("x_TGLREG"));
			$this->TGLREG->CurrentValue = ew_UnFormatDateTime($this->TGLREG->CurrentValue, 0);
		}
		if (!$this->JAMREG->FldIsDetailKey) {
			$this->JAMREG->setFormValue($objForm->GetValue("x_JAMREG"));
			$this->JAMREG->CurrentValue = ew_UnFormatDateTime($this->JAMREG->CurrentValue, 0);
		}
		if (!$this->NO_SJP->FldIsDetailKey) {
			$this->NO_SJP->setFormValue($objForm->GetValue("x_NO_SJP"));
		}
		if (!$this->NOKARTU->FldIsDetailKey) {
			$this->NOKARTU->setFormValue($objForm->GetValue("x_NOKARTU"));
		}
		if (!$this->TANGGAL_SEP->FldIsDetailKey) {
			$this->TANGGAL_SEP->setFormValue($objForm->GetValue("x_TANGGAL_SEP"));
			$this->TANGGAL_SEP->CurrentValue = ew_UnFormatDateTime($this->TANGGAL_SEP->CurrentValue, 5);
		}
		if (!$this->TANGGALRUJUK_SEP->FldIsDetailKey) {
			$this->TANGGALRUJUK_SEP->setFormValue($objForm->GetValue("x_TANGGALRUJUK_SEP"));
			$this->TANGGALRUJUK_SEP->CurrentValue = ew_UnFormatDateTime($this->TANGGALRUJUK_SEP->CurrentValue, 5);
		}
		if (!$this->KELASRAWAT_SEP->FldIsDetailKey) {
			$this->KELASRAWAT_SEP->setFormValue($objForm->GetValue("x_KELASRAWAT_SEP"));
		}
		if (!$this->NORUJUKAN_SEP->FldIsDetailKey) {
			$this->NORUJUKAN_SEP->setFormValue($objForm->GetValue("x_NORUJUKAN_SEP"));
		}
		if (!$this->PPKPELAYANAN_SEP->FldIsDetailKey) {
			$this->PPKPELAYANAN_SEP->setFormValue($objForm->GetValue("x_PPKPELAYANAN_SEP"));
		}
		if (!$this->JENISPERAWATAN_SEP->FldIsDetailKey) {
			$this->JENISPERAWATAN_SEP->setFormValue($objForm->GetValue("x_JENISPERAWATAN_SEP"));
		}
		if (!$this->CATATAN_SEP->FldIsDetailKey) {
			$this->CATATAN_SEP->setFormValue($objForm->GetValue("x_CATATAN_SEP"));
		}
		if (!$this->DIAGNOSAAWAL_SEP->FldIsDetailKey) {
			$this->DIAGNOSAAWAL_SEP->setFormValue($objForm->GetValue("x_DIAGNOSAAWAL_SEP"));
		}
		if (!$this->NAMADIAGNOSA_SEP->FldIsDetailKey) {
			$this->NAMADIAGNOSA_SEP->setFormValue($objForm->GetValue("x_NAMADIAGNOSA_SEP"));
		}
		if (!$this->LAKALANTAS_SEP->FldIsDetailKey) {
			$this->LAKALANTAS_SEP->setFormValue($objForm->GetValue("x_LAKALANTAS_SEP"));
		}
		if (!$this->LOKASILAKALANTAS->FldIsDetailKey) {
			$this->LOKASILAKALANTAS->setFormValue($objForm->GetValue("x_LOKASILAKALANTAS"));
		}
		if (!$this->USER->FldIsDetailKey) {
			$this->USER->setFormValue($objForm->GetValue("x_USER"));
		}
		if (!$this->PESERTANIK_SEP->FldIsDetailKey) {
			$this->PESERTANIK_SEP->setFormValue($objForm->GetValue("x_PESERTANIK_SEP"));
		}
		if (!$this->PESERTANAMA_SEP->FldIsDetailKey) {
			$this->PESERTANAMA_SEP->setFormValue($objForm->GetValue("x_PESERTANAMA_SEP"));
		}
		if (!$this->PESERTAJENISKELAMIN_SEP->FldIsDetailKey) {
			$this->PESERTAJENISKELAMIN_SEP->setFormValue($objForm->GetValue("x_PESERTAJENISKELAMIN_SEP"));
		}
		if (!$this->PESERTANAMAKELAS_SEP->FldIsDetailKey) {
			$this->PESERTANAMAKELAS_SEP->setFormValue($objForm->GetValue("x_PESERTANAMAKELAS_SEP"));
		}
		if (!$this->PESERTAPISAT->FldIsDetailKey) {
			$this->PESERTAPISAT->setFormValue($objForm->GetValue("x_PESERTAPISAT"));
		}
		if (!$this->PESERTATGLLAHIR->FldIsDetailKey) {
			$this->PESERTATGLLAHIR->setFormValue($objForm->GetValue("x_PESERTATGLLAHIR"));
		}
		if (!$this->PESERTAJENISPESERTA_SEP->FldIsDetailKey) {
			$this->PESERTAJENISPESERTA_SEP->setFormValue($objForm->GetValue("x_PESERTAJENISPESERTA_SEP"));
		}
		if (!$this->PESERTANAMAJENISPESERTA_SEP->FldIsDetailKey) {
			$this->PESERTANAMAJENISPESERTA_SEP->setFormValue($objForm->GetValue("x_PESERTANAMAJENISPESERTA_SEP"));
		}
		if (!$this->POLITUJUAN_SEP->FldIsDetailKey) {
			$this->POLITUJUAN_SEP->setFormValue($objForm->GetValue("x_POLITUJUAN_SEP"));
		}
		if (!$this->NAMAPOLITUJUAN_SEP->FldIsDetailKey) {
			$this->NAMAPOLITUJUAN_SEP->setFormValue($objForm->GetValue("x_NAMAPOLITUJUAN_SEP"));
		}
		if (!$this->KDPPKRUJUKAN_SEP->FldIsDetailKey) {
			$this->KDPPKRUJUKAN_SEP->setFormValue($objForm->GetValue("x_KDPPKRUJUKAN_SEP"));
		}
		if (!$this->NMPPKRUJUKAN_SEP->FldIsDetailKey) {
			$this->NMPPKRUJUKAN_SEP->setFormValue($objForm->GetValue("x_NMPPKRUJUKAN_SEP"));
		}
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
		$this->NOMR->CurrentValue = $this->NOMR->FormValue;
		$this->KDPOLY->CurrentValue = $this->KDPOLY->FormValue;
		$this->KDCARABAYAR->CurrentValue = $this->KDCARABAYAR->FormValue;
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->TGLREG->CurrentValue = $this->TGLREG->FormValue;
		$this->TGLREG->CurrentValue = ew_UnFormatDateTime($this->TGLREG->CurrentValue, 0);
		$this->JAMREG->CurrentValue = $this->JAMREG->FormValue;
		$this->JAMREG->CurrentValue = ew_UnFormatDateTime($this->JAMREG->CurrentValue, 0);
		$this->NO_SJP->CurrentValue = $this->NO_SJP->FormValue;
		$this->NOKARTU->CurrentValue = $this->NOKARTU->FormValue;
		$this->TANGGAL_SEP->CurrentValue = $this->TANGGAL_SEP->FormValue;
		$this->TANGGAL_SEP->CurrentValue = ew_UnFormatDateTime($this->TANGGAL_SEP->CurrentValue, 5);
		$this->TANGGALRUJUK_SEP->CurrentValue = $this->TANGGALRUJUK_SEP->FormValue;
		$this->TANGGALRUJUK_SEP->CurrentValue = ew_UnFormatDateTime($this->TANGGALRUJUK_SEP->CurrentValue, 5);
		$this->KELASRAWAT_SEP->CurrentValue = $this->KELASRAWAT_SEP->FormValue;
		$this->NORUJUKAN_SEP->CurrentValue = $this->NORUJUKAN_SEP->FormValue;
		$this->PPKPELAYANAN_SEP->CurrentValue = $this->PPKPELAYANAN_SEP->FormValue;
		$this->JENISPERAWATAN_SEP->CurrentValue = $this->JENISPERAWATAN_SEP->FormValue;
		$this->CATATAN_SEP->CurrentValue = $this->CATATAN_SEP->FormValue;
		$this->DIAGNOSAAWAL_SEP->CurrentValue = $this->DIAGNOSAAWAL_SEP->FormValue;
		$this->NAMADIAGNOSA_SEP->CurrentValue = $this->NAMADIAGNOSA_SEP->FormValue;
		$this->LAKALANTAS_SEP->CurrentValue = $this->LAKALANTAS_SEP->FormValue;
		$this->LOKASILAKALANTAS->CurrentValue = $this->LOKASILAKALANTAS->FormValue;
		$this->USER->CurrentValue = $this->USER->FormValue;
		$this->PESERTANIK_SEP->CurrentValue = $this->PESERTANIK_SEP->FormValue;
		$this->PESERTANAMA_SEP->CurrentValue = $this->PESERTANAMA_SEP->FormValue;
		$this->PESERTAJENISKELAMIN_SEP->CurrentValue = $this->PESERTAJENISKELAMIN_SEP->FormValue;
		$this->PESERTANAMAKELAS_SEP->CurrentValue = $this->PESERTANAMAKELAS_SEP->FormValue;
		$this->PESERTAPISAT->CurrentValue = $this->PESERTAPISAT->FormValue;
		$this->PESERTATGLLAHIR->CurrentValue = $this->PESERTATGLLAHIR->FormValue;
		$this->PESERTAJENISPESERTA_SEP->CurrentValue = $this->PESERTAJENISPESERTA_SEP->FormValue;
		$this->PESERTANAMAJENISPESERTA_SEP->CurrentValue = $this->PESERTANAMAJENISPESERTA_SEP->FormValue;
		$this->POLITUJUAN_SEP->CurrentValue = $this->POLITUJUAN_SEP->FormValue;
		$this->NAMAPOLITUJUAN_SEP->CurrentValue = $this->NAMAPOLITUJUAN_SEP->FormValue;
		$this->KDPPKRUJUKAN_SEP->CurrentValue = $this->KDPPKRUJUKAN_SEP->FormValue;
		$this->NMPPKRUJUKAN_SEP->CurrentValue = $this->NMPPKRUJUKAN_SEP->FormValue;
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
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
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
		$this->bridging_kepesertaan_by_no_ka->setDbValue($rs->fields('bridging_kepesertaan_by_no_ka'));
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
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NIP->DbValue = $row['NIP'];
		$this->TGLREG->DbValue = $row['TGLREG'];
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
		$this->bridging_kepesertaan_by_no_ka->DbValue = $row['bridging_kepesertaan_by_no_ka'];
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
		// KDCARABAYAR
		// NIP
		// TGLREG
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
		// bridging_kepesertaan_by_no_ka
		// pasien_NOTELP
		// penjamin_kkl_id
		// asalfaskesrujukan_id
		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

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

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->ViewValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->ViewValue = ew_FormatDateTime($this->JAMREG->ViewValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->ViewValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->ViewValue = ew_FormatDateTime($this->TANGGAL_SEP->ViewValue, 5);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->ViewValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->ViewValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->ViewValue, 5);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->ViewValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->ViewValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->ViewValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		if (strval($this->JENISPERAWATAN_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`jeniskeperawatan_id`" . ew_SearchString("=", $this->JENISPERAWATAN_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `jeniskeperawatan_id`, `jeniskeperawatan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskeperawatan`";
		$sWhereWrk = "";
		$this->JENISPERAWATAN_SEP->LookupFilters = array();
		$lookuptblfilter = "`jeniskeperawatan_id`='2'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JENISPERAWATAN_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->CurrentValue;
			}
		} else {
			$this->JENISPERAWATAN_SEP->ViewValue = NULL;
		}
		$this->JENISPERAWATAN_SEP->ViewCustomAttributes = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->ViewValue = $this->CATATAN_SEP->CurrentValue;
		$this->CATATAN_SEP->ViewCustomAttributes = "";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		if (strval($this->DIAGNOSAAWAL_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`Code`" . ew_SearchString("=", $this->DIAGNOSAAWAL_SEP->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Code`, `Code` AS `DispFld`, `Description` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `refdiagnosis`";
		$sWhereWrk = "";
		$this->DIAGNOSAAWAL_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DIAGNOSAAWAL_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
			}
		} else {
			$this->DIAGNOSAAWAL_SEP->ViewValue = NULL;
		}
		$this->DIAGNOSAAWAL_SEP->ViewCustomAttributes = "";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->ViewValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->ViewCustomAttributes = "";

		// LAKALANTAS_SEP
		if (strval($this->LAKALANTAS_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->LAKALANTAS_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_lakalantas`";
		$sWhereWrk = "";
		$this->LAKALANTAS_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->LAKALANTAS_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->CurrentValue;
			}
		} else {
			$this->LAKALANTAS_SEP->ViewValue = NULL;
		}
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->ViewValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->ViewValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->ViewValue = $this->PESERTANIK_SEP->CurrentValue;
		$this->PESERTANIK_SEP->ViewCustomAttributes = "";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->ViewValue = $this->PESERTANAMA_SEP->CurrentValue;
		$this->PESERTANAMA_SEP->ViewCustomAttributes = "";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->ViewValue = $this->PESERTAJENISKELAMIN_SEP->CurrentValue;
		$this->PESERTAJENISKELAMIN_SEP->ViewCustomAttributes = "";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->ViewValue = $this->PESERTANAMAKELAS_SEP->CurrentValue;
		$this->PESERTANAMAKELAS_SEP->ViewCustomAttributes = "";

		// PESERTAPISAT
		$this->PESERTAPISAT->ViewValue = $this->PESERTAPISAT->CurrentValue;
		$this->PESERTAPISAT->ViewCustomAttributes = "";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->ViewValue = $this->PESERTATGLLAHIR->CurrentValue;
		$this->PESERTATGLLAHIR->ViewCustomAttributes = "";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->ViewValue = $this->PESERTAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->ViewValue = $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTANAMAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// POLITUJUAN_SEP
		if (strval($this->POLITUJUAN_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`KDPOLI`" . ew_SearchString("=", $this->POLITUJUAN_SEP->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `KDPOLI`, `KDPOLI` AS `DispFld`, `NMPOLI` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `refpoli`";
		$sWhereWrk = "";
		$this->POLITUJUAN_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->POLITUJUAN_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->POLITUJUAN_SEP->ViewValue = $this->POLITUJUAN_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->POLITUJUAN_SEP->ViewValue = $this->POLITUJUAN_SEP->CurrentValue;
			}
		} else {
			$this->POLITUJUAN_SEP->ViewValue = NULL;
		}
		$this->POLITUJUAN_SEP->ViewCustomAttributes = "";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->ViewValue = $this->NAMAPOLITUJUAN_SEP->CurrentValue;
		$this->NAMAPOLITUJUAN_SEP->ViewCustomAttributes = "";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->ViewValue = $this->KDPPKRUJUKAN_SEP->CurrentValue;
		$this->KDPPKRUJUKAN_SEP->ViewCustomAttributes = "";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->ViewValue = $this->NMPPKRUJUKAN_SEP->CurrentValue;
		$this->NMPPKRUJUKAN_SEP->ViewCustomAttributes = "";

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

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// JAMREG
			$this->JAMREG->LinkCustomAttributes = "";
			$this->JAMREG->HrefValue = "";
			$this->JAMREG->TooltipValue = "";

			// NO_SJP
			$this->NO_SJP->LinkCustomAttributes = "";
			$this->NO_SJP->HrefValue = "";
			$this->NO_SJP->TooltipValue = "";

			// NOKARTU
			$this->NOKARTU->LinkCustomAttributes = "";
			$this->NOKARTU->HrefValue = "";
			$this->NOKARTU->TooltipValue = "";

			// TANGGAL_SEP
			$this->TANGGAL_SEP->LinkCustomAttributes = "";
			$this->TANGGAL_SEP->HrefValue = "";
			$this->TANGGAL_SEP->TooltipValue = "";

			// TANGGALRUJUK_SEP
			$this->TANGGALRUJUK_SEP->LinkCustomAttributes = "";
			$this->TANGGALRUJUK_SEP->HrefValue = "";
			$this->TANGGALRUJUK_SEP->TooltipValue = "";

			// KELASRAWAT_SEP
			$this->KELASRAWAT_SEP->LinkCustomAttributes = "";
			$this->KELASRAWAT_SEP->HrefValue = "";
			$this->KELASRAWAT_SEP->TooltipValue = "";

			// NORUJUKAN_SEP
			$this->NORUJUKAN_SEP->LinkCustomAttributes = "";
			$this->NORUJUKAN_SEP->HrefValue = "";
			$this->NORUJUKAN_SEP->TooltipValue = "";

			// PPKPELAYANAN_SEP
			$this->PPKPELAYANAN_SEP->LinkCustomAttributes = "";
			$this->PPKPELAYANAN_SEP->HrefValue = "";
			$this->PPKPELAYANAN_SEP->TooltipValue = "";

			// JENISPERAWATAN_SEP
			$this->JENISPERAWATAN_SEP->LinkCustomAttributes = "";
			$this->JENISPERAWATAN_SEP->HrefValue = "";
			$this->JENISPERAWATAN_SEP->TooltipValue = "";

			// CATATAN_SEP
			$this->CATATAN_SEP->LinkCustomAttributes = "";
			$this->CATATAN_SEP->HrefValue = "";
			$this->CATATAN_SEP->TooltipValue = "";

			// DIAGNOSAAWAL_SEP
			$this->DIAGNOSAAWAL_SEP->LinkCustomAttributes = "";
			$this->DIAGNOSAAWAL_SEP->HrefValue = "";
			$this->DIAGNOSAAWAL_SEP->TooltipValue = "";

			// NAMADIAGNOSA_SEP
			$this->NAMADIAGNOSA_SEP->LinkCustomAttributes = "";
			$this->NAMADIAGNOSA_SEP->HrefValue = "";
			$this->NAMADIAGNOSA_SEP->TooltipValue = "";

			// LAKALANTAS_SEP
			$this->LAKALANTAS_SEP->LinkCustomAttributes = "";
			$this->LAKALANTAS_SEP->HrefValue = "";
			$this->LAKALANTAS_SEP->TooltipValue = "";

			// LOKASILAKALANTAS
			$this->LOKASILAKALANTAS->LinkCustomAttributes = "";
			$this->LOKASILAKALANTAS->HrefValue = "";
			$this->LOKASILAKALANTAS->TooltipValue = "";

			// USER
			$this->USER->LinkCustomAttributes = "";
			$this->USER->HrefValue = "";
			$this->USER->TooltipValue = "";

			// PESERTANIK_SEP
			$this->PESERTANIK_SEP->LinkCustomAttributes = "";
			$this->PESERTANIK_SEP->HrefValue = "";
			if ($this->Export == "") {
				$this->PESERTANIK_SEP->TooltipValue = ($this->PESERTANIK_SEP->ViewValue <> "") ? $this->PESERTANIK_SEP->ViewValue : $this->PESERTANIK_SEP->CurrentValue;
				if ($this->PESERTANIK_SEP->HrefValue == "") $this->PESERTANIK_SEP->HrefValue = "javascript:void(0);";
				ew_AppendClass($this->PESERTANIK_SEP->LinkAttrs["class"], "ewTooltipLink");
				$this->PESERTANIK_SEP->LinkAttrs["data-tooltip-id"] = "tt_vw_bridging_sep_by_no_kartu_x_PESERTANIK_SEP";
				$this->PESERTANIK_SEP->LinkAttrs["data-tooltip-width"] = $this->PESERTANIK_SEP->TooltipWidth;
				$this->PESERTANIK_SEP->LinkAttrs["data-placement"] = $GLOBALS["EW_CSS_FLIP"] ? "left" : "right";
			}

			// PESERTANAMA_SEP
			$this->PESERTANAMA_SEP->LinkCustomAttributes = "";
			$this->PESERTANAMA_SEP->HrefValue = "";
			$this->PESERTANAMA_SEP->TooltipValue = "";

			// PESERTAJENISKELAMIN_SEP
			$this->PESERTAJENISKELAMIN_SEP->LinkCustomAttributes = "";
			$this->PESERTAJENISKELAMIN_SEP->HrefValue = "";
			$this->PESERTAJENISKELAMIN_SEP->TooltipValue = "";

			// PESERTANAMAKELAS_SEP
			$this->PESERTANAMAKELAS_SEP->LinkCustomAttributes = "";
			$this->PESERTANAMAKELAS_SEP->HrefValue = "";
			$this->PESERTANAMAKELAS_SEP->TooltipValue = "";

			// PESERTAPISAT
			$this->PESERTAPISAT->LinkCustomAttributes = "";
			$this->PESERTAPISAT->HrefValue = "";
			$this->PESERTAPISAT->TooltipValue = "";

			// PESERTATGLLAHIR
			$this->PESERTATGLLAHIR->LinkCustomAttributes = "";
			$this->PESERTATGLLAHIR->HrefValue = "";
			$this->PESERTATGLLAHIR->TooltipValue = "";

			// PESERTAJENISPESERTA_SEP
			$this->PESERTAJENISPESERTA_SEP->LinkCustomAttributes = "";
			$this->PESERTAJENISPESERTA_SEP->HrefValue = "";
			$this->PESERTAJENISPESERTA_SEP->TooltipValue = "";

			// PESERTANAMAJENISPESERTA_SEP
			$this->PESERTANAMAJENISPESERTA_SEP->LinkCustomAttributes = "";
			$this->PESERTANAMAJENISPESERTA_SEP->HrefValue = "";
			$this->PESERTANAMAJENISPESERTA_SEP->TooltipValue = "";

			// POLITUJUAN_SEP
			$this->POLITUJUAN_SEP->LinkCustomAttributes = "";
			$this->POLITUJUAN_SEP->HrefValue = "";
			$this->POLITUJUAN_SEP->TooltipValue = "";

			// NAMAPOLITUJUAN_SEP
			$this->NAMAPOLITUJUAN_SEP->LinkCustomAttributes = "";
			$this->NAMAPOLITUJUAN_SEP->HrefValue = "";
			$this->NAMAPOLITUJUAN_SEP->TooltipValue = "";

			// KDPPKRUJUKAN_SEP
			$this->KDPPKRUJUKAN_SEP->LinkCustomAttributes = "";
			$this->KDPPKRUJUKAN_SEP->HrefValue = "";
			$this->KDPPKRUJUKAN_SEP->TooltipValue = "";

			// NMPPKRUJUKAN_SEP
			$this->NMPPKRUJUKAN_SEP->LinkCustomAttributes = "";
			$this->NMPPKRUJUKAN_SEP->HrefValue = "";
			$this->NMPPKRUJUKAN_SEP->TooltipValue = "";

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

			// NOMR
			$this->NOMR->EditAttrs["class"] = "form-control";
			$this->NOMR->EditCustomAttributes = "";
			$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->CurrentValue);
			if (strval($this->NOMR->CurrentValue) <> "") {
				$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "";
			$this->NOMR->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->NOMR->EditValue = $this->NOMR->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->CurrentValue);
				}
			} else {
				$this->NOMR->EditValue = NULL;
			}
			$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

			// KDPOLY
			$this->KDPOLY->EditAttrs["class"] = "form-control";
			$this->KDPOLY->EditCustomAttributes = "";
			if (trim(strval($this->KDPOLY->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_poly`";
			$sWhereWrk = "";
			$this->KDPOLY->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDPOLY->EditValue = $arwrk;

			// KDCARABAYAR
			$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
			$this->KDCARABAYAR->EditCustomAttributes = "";
			if (trim(strval($this->KDCARABAYAR->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->KDCARABAYAR->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDCARABAYAR->EditValue = $arwrk;

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = ew_HtmlEncode($this->NIP->CurrentValue);
			$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

			// TGLREG
			$this->TGLREG->EditAttrs["class"] = "form-control";
			$this->TGLREG->EditCustomAttributes = "";
			$this->TGLREG->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TGLREG->CurrentValue, 8));
			$this->TGLREG->PlaceHolder = ew_RemoveHtml($this->TGLREG->FldCaption());

			// JAMREG
			$this->JAMREG->EditAttrs["class"] = "form-control";
			$this->JAMREG->EditCustomAttributes = "";
			$this->JAMREG->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->JAMREG->CurrentValue, 8));
			$this->JAMREG->PlaceHolder = ew_RemoveHtml($this->JAMREG->FldCaption());

			// NO_SJP
			$this->NO_SJP->EditAttrs["class"] = "form-control";
			$this->NO_SJP->EditCustomAttributes = "";
			$this->NO_SJP->EditValue = ew_HtmlEncode($this->NO_SJP->CurrentValue);
			$this->NO_SJP->PlaceHolder = ew_RemoveHtml($this->NO_SJP->FldCaption());

			// NOKARTU
			$this->NOKARTU->EditAttrs["class"] = "form-control";
			$this->NOKARTU->EditCustomAttributes = "";
			$this->NOKARTU->EditValue = ew_HtmlEncode($this->NOKARTU->CurrentValue);
			$this->NOKARTU->PlaceHolder = ew_RemoveHtml($this->NOKARTU->FldCaption());

			// TANGGAL_SEP
			$this->TANGGAL_SEP->EditAttrs["class"] = "form-control";
			$this->TANGGAL_SEP->EditCustomAttributes = "";
			$this->TANGGAL_SEP->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TANGGAL_SEP->CurrentValue, 5));
			$this->TANGGAL_SEP->PlaceHolder = ew_RemoveHtml($this->TANGGAL_SEP->FldCaption());

			// TANGGALRUJUK_SEP
			$this->TANGGALRUJUK_SEP->EditAttrs["class"] = "form-control";
			$this->TANGGALRUJUK_SEP->EditCustomAttributes = "";
			$this->TANGGALRUJUK_SEP->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TANGGALRUJUK_SEP->CurrentValue, 5));
			$this->TANGGALRUJUK_SEP->PlaceHolder = ew_RemoveHtml($this->TANGGALRUJUK_SEP->FldCaption());

			// KELASRAWAT_SEP
			$this->KELASRAWAT_SEP->EditAttrs["class"] = "form-control";
			$this->KELASRAWAT_SEP->EditCustomAttributes = "";
			$this->KELASRAWAT_SEP->EditValue = ew_HtmlEncode($this->KELASRAWAT_SEP->CurrentValue);
			$this->KELASRAWAT_SEP->PlaceHolder = ew_RemoveHtml($this->KELASRAWAT_SEP->FldCaption());

			// NORUJUKAN_SEP
			$this->NORUJUKAN_SEP->EditAttrs["class"] = "form-control";
			$this->NORUJUKAN_SEP->EditCustomAttributes = "";
			$this->NORUJUKAN_SEP->EditValue = ew_HtmlEncode($this->NORUJUKAN_SEP->CurrentValue);
			$this->NORUJUKAN_SEP->PlaceHolder = ew_RemoveHtml($this->NORUJUKAN_SEP->FldCaption());

			// PPKPELAYANAN_SEP
			$this->PPKPELAYANAN_SEP->EditAttrs["class"] = "form-control";
			$this->PPKPELAYANAN_SEP->EditCustomAttributes = "";
			$this->PPKPELAYANAN_SEP->EditValue = ew_HtmlEncode($this->PPKPELAYANAN_SEP->CurrentValue);
			$this->PPKPELAYANAN_SEP->PlaceHolder = ew_RemoveHtml($this->PPKPELAYANAN_SEP->FldCaption());

			// JENISPERAWATAN_SEP
			$this->JENISPERAWATAN_SEP->EditCustomAttributes = "";
			if (trim(strval($this->JENISPERAWATAN_SEP->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`jeniskeperawatan_id`" . ew_SearchString("=", $this->JENISPERAWATAN_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `jeniskeperawatan_id`, `jeniskeperawatan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jeniskeperawatan`";
			$sWhereWrk = "";
			$this->JENISPERAWATAN_SEP->LookupFilters = array();
			$lookuptblfilter = "`jeniskeperawatan_id`='2'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->JENISPERAWATAN_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->JENISPERAWATAN_SEP->EditValue = $arwrk;

			// CATATAN_SEP
			$this->CATATAN_SEP->EditAttrs["class"] = "form-control";
			$this->CATATAN_SEP->EditCustomAttributes = "";
			$this->CATATAN_SEP->EditValue = ew_HtmlEncode($this->CATATAN_SEP->CurrentValue);
			$this->CATATAN_SEP->PlaceHolder = ew_RemoveHtml($this->CATATAN_SEP->FldCaption());

			// DIAGNOSAAWAL_SEP
			$this->DIAGNOSAAWAL_SEP->EditAttrs["class"] = "form-control";
			$this->DIAGNOSAAWAL_SEP->EditCustomAttributes = "";
			$this->DIAGNOSAAWAL_SEP->EditValue = ew_HtmlEncode($this->DIAGNOSAAWAL_SEP->CurrentValue);
			if (strval($this->DIAGNOSAAWAL_SEP->CurrentValue) <> "") {
				$sFilterWrk = "`Code`" . ew_SearchString("=", $this->DIAGNOSAAWAL_SEP->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `Code`, `Code` AS `DispFld`, `Description` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `refdiagnosis`";
			$sWhereWrk = "";
			$this->DIAGNOSAAWAL_SEP->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->DIAGNOSAAWAL_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->DIAGNOSAAWAL_SEP->EditValue = $this->DIAGNOSAAWAL_SEP->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->DIAGNOSAAWAL_SEP->EditValue = ew_HtmlEncode($this->DIAGNOSAAWAL_SEP->CurrentValue);
				}
			} else {
				$this->DIAGNOSAAWAL_SEP->EditValue = NULL;
			}
			$this->DIAGNOSAAWAL_SEP->PlaceHolder = ew_RemoveHtml($this->DIAGNOSAAWAL_SEP->FldCaption());

			// NAMADIAGNOSA_SEP
			$this->NAMADIAGNOSA_SEP->EditAttrs["class"] = "form-control";
			$this->NAMADIAGNOSA_SEP->EditCustomAttributes = "";
			$this->NAMADIAGNOSA_SEP->EditValue = ew_HtmlEncode($this->NAMADIAGNOSA_SEP->CurrentValue);
			$this->NAMADIAGNOSA_SEP->PlaceHolder = ew_RemoveHtml($this->NAMADIAGNOSA_SEP->FldCaption());

			// LAKALANTAS_SEP
			$this->LAKALANTAS_SEP->EditCustomAttributes = "";
			if (trim(strval($this->LAKALANTAS_SEP->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->LAKALANTAS_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_lakalantas`";
			$sWhereWrk = "";
			$this->LAKALANTAS_SEP->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->LAKALANTAS_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->LAKALANTAS_SEP->EditValue = $arwrk;

			// LOKASILAKALANTAS
			$this->LOKASILAKALANTAS->EditAttrs["class"] = "form-control";
			$this->LOKASILAKALANTAS->EditCustomAttributes = "";
			$this->LOKASILAKALANTAS->EditValue = ew_HtmlEncode($this->LOKASILAKALANTAS->CurrentValue);
			$this->LOKASILAKALANTAS->PlaceHolder = ew_RemoveHtml($this->LOKASILAKALANTAS->FldCaption());

			// USER
			$this->USER->EditAttrs["class"] = "form-control";
			$this->USER->EditCustomAttributes = "";
			$this->USER->EditValue = ew_HtmlEncode($this->USER->CurrentValue);
			$this->USER->PlaceHolder = ew_RemoveHtml($this->USER->FldCaption());

			// PESERTANIK_SEP
			$this->PESERTANIK_SEP->EditAttrs["class"] = "form-control";
			$this->PESERTANIK_SEP->EditCustomAttributes = "";
			$this->PESERTANIK_SEP->EditValue = ew_HtmlEncode($this->PESERTANIK_SEP->CurrentValue);
			$this->PESERTANIK_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANIK_SEP->FldCaption());

			// PESERTANAMA_SEP
			$this->PESERTANAMA_SEP->EditAttrs["class"] = "form-control";
			$this->PESERTANAMA_SEP->EditCustomAttributes = "";
			$this->PESERTANAMA_SEP->EditValue = ew_HtmlEncode($this->PESERTANAMA_SEP->CurrentValue);
			$this->PESERTANAMA_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANAMA_SEP->FldCaption());

			// PESERTAJENISKELAMIN_SEP
			$this->PESERTAJENISKELAMIN_SEP->EditAttrs["class"] = "form-control";
			$this->PESERTAJENISKELAMIN_SEP->EditCustomAttributes = "";
			$this->PESERTAJENISKELAMIN_SEP->EditValue = ew_HtmlEncode($this->PESERTAJENISKELAMIN_SEP->CurrentValue);
			$this->PESERTAJENISKELAMIN_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTAJENISKELAMIN_SEP->FldCaption());

			// PESERTANAMAKELAS_SEP
			$this->PESERTANAMAKELAS_SEP->EditAttrs["class"] = "form-control";
			$this->PESERTANAMAKELAS_SEP->EditCustomAttributes = "";
			$this->PESERTANAMAKELAS_SEP->EditValue = ew_HtmlEncode($this->PESERTANAMAKELAS_SEP->CurrentValue);
			$this->PESERTANAMAKELAS_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANAMAKELAS_SEP->FldCaption());

			// PESERTAPISAT
			$this->PESERTAPISAT->EditAttrs["class"] = "form-control";
			$this->PESERTAPISAT->EditCustomAttributes = "";
			$this->PESERTAPISAT->EditValue = ew_HtmlEncode($this->PESERTAPISAT->CurrentValue);
			$this->PESERTAPISAT->PlaceHolder = ew_RemoveHtml($this->PESERTAPISAT->FldCaption());

			// PESERTATGLLAHIR
			$this->PESERTATGLLAHIR->EditAttrs["class"] = "form-control";
			$this->PESERTATGLLAHIR->EditCustomAttributes = "";
			$this->PESERTATGLLAHIR->EditValue = ew_HtmlEncode($this->PESERTATGLLAHIR->CurrentValue);
			$this->PESERTATGLLAHIR->PlaceHolder = ew_RemoveHtml($this->PESERTATGLLAHIR->FldCaption());

			// PESERTAJENISPESERTA_SEP
			$this->PESERTAJENISPESERTA_SEP->EditAttrs["class"] = "form-control";
			$this->PESERTAJENISPESERTA_SEP->EditCustomAttributes = "";
			$this->PESERTAJENISPESERTA_SEP->EditValue = ew_HtmlEncode($this->PESERTAJENISPESERTA_SEP->CurrentValue);
			$this->PESERTAJENISPESERTA_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTAJENISPESERTA_SEP->FldCaption());

			// PESERTANAMAJENISPESERTA_SEP
			$this->PESERTANAMAJENISPESERTA_SEP->EditAttrs["class"] = "form-control";
			$this->PESERTANAMAJENISPESERTA_SEP->EditCustomAttributes = "";
			$this->PESERTANAMAJENISPESERTA_SEP->EditValue = ew_HtmlEncode($this->PESERTANAMAJENISPESERTA_SEP->CurrentValue);
			$this->PESERTANAMAJENISPESERTA_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANAMAJENISPESERTA_SEP->FldCaption());

			// POLITUJUAN_SEP
			$this->POLITUJUAN_SEP->EditAttrs["class"] = "form-control";
			$this->POLITUJUAN_SEP->EditCustomAttributes = "";
			if (trim(strval($this->POLITUJUAN_SEP->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KDPOLI`" . ew_SearchString("=", $this->POLITUJUAN_SEP->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `KDPOLI`, `KDPOLI` AS `DispFld`, `NMPOLI` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `refpoli`";
			$sWhereWrk = "";
			$this->POLITUJUAN_SEP->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->POLITUJUAN_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->POLITUJUAN_SEP->EditValue = $arwrk;

			// NAMAPOLITUJUAN_SEP
			$this->NAMAPOLITUJUAN_SEP->EditAttrs["class"] = "form-control";
			$this->NAMAPOLITUJUAN_SEP->EditCustomAttributes = "";
			$this->NAMAPOLITUJUAN_SEP->EditValue = ew_HtmlEncode($this->NAMAPOLITUJUAN_SEP->CurrentValue);
			$this->NAMAPOLITUJUAN_SEP->PlaceHolder = ew_RemoveHtml($this->NAMAPOLITUJUAN_SEP->FldCaption());

			// KDPPKRUJUKAN_SEP
			$this->KDPPKRUJUKAN_SEP->EditAttrs["class"] = "form-control";
			$this->KDPPKRUJUKAN_SEP->EditCustomAttributes = "";
			$this->KDPPKRUJUKAN_SEP->EditValue = ew_HtmlEncode($this->KDPPKRUJUKAN_SEP->CurrentValue);
			$this->KDPPKRUJUKAN_SEP->PlaceHolder = ew_RemoveHtml($this->KDPPKRUJUKAN_SEP->FldCaption());

			// NMPPKRUJUKAN_SEP
			$this->NMPPKRUJUKAN_SEP->EditAttrs["class"] = "form-control";
			$this->NMPPKRUJUKAN_SEP->EditCustomAttributes = "";
			$this->NMPPKRUJUKAN_SEP->EditValue = ew_HtmlEncode($this->NMPPKRUJUKAN_SEP->CurrentValue);
			$this->NMPPKRUJUKAN_SEP->PlaceHolder = ew_RemoveHtml($this->NMPPKRUJUKAN_SEP->FldCaption());

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
			// NOMR

			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";

			// JAMREG
			$this->JAMREG->LinkCustomAttributes = "";
			$this->JAMREG->HrefValue = "";

			// NO_SJP
			$this->NO_SJP->LinkCustomAttributes = "";
			$this->NO_SJP->HrefValue = "";

			// NOKARTU
			$this->NOKARTU->LinkCustomAttributes = "";
			$this->NOKARTU->HrefValue = "";

			// TANGGAL_SEP
			$this->TANGGAL_SEP->LinkCustomAttributes = "";
			$this->TANGGAL_SEP->HrefValue = "";

			// TANGGALRUJUK_SEP
			$this->TANGGALRUJUK_SEP->LinkCustomAttributes = "";
			$this->TANGGALRUJUK_SEP->HrefValue = "";

			// KELASRAWAT_SEP
			$this->KELASRAWAT_SEP->LinkCustomAttributes = "";
			$this->KELASRAWAT_SEP->HrefValue = "";

			// NORUJUKAN_SEP
			$this->NORUJUKAN_SEP->LinkCustomAttributes = "";
			$this->NORUJUKAN_SEP->HrefValue = "";

			// PPKPELAYANAN_SEP
			$this->PPKPELAYANAN_SEP->LinkCustomAttributes = "";
			$this->PPKPELAYANAN_SEP->HrefValue = "";

			// JENISPERAWATAN_SEP
			$this->JENISPERAWATAN_SEP->LinkCustomAttributes = "";
			$this->JENISPERAWATAN_SEP->HrefValue = "";

			// CATATAN_SEP
			$this->CATATAN_SEP->LinkCustomAttributes = "";
			$this->CATATAN_SEP->HrefValue = "";

			// DIAGNOSAAWAL_SEP
			$this->DIAGNOSAAWAL_SEP->LinkCustomAttributes = "";
			$this->DIAGNOSAAWAL_SEP->HrefValue = "";

			// NAMADIAGNOSA_SEP
			$this->NAMADIAGNOSA_SEP->LinkCustomAttributes = "";
			$this->NAMADIAGNOSA_SEP->HrefValue = "";

			// LAKALANTAS_SEP
			$this->LAKALANTAS_SEP->LinkCustomAttributes = "";
			$this->LAKALANTAS_SEP->HrefValue = "";

			// LOKASILAKALANTAS
			$this->LOKASILAKALANTAS->LinkCustomAttributes = "";
			$this->LOKASILAKALANTAS->HrefValue = "";

			// USER
			$this->USER->LinkCustomAttributes = "";
			$this->USER->HrefValue = "";

			// PESERTANIK_SEP
			$this->PESERTANIK_SEP->LinkCustomAttributes = "";
			$this->PESERTANIK_SEP->HrefValue = "";

			// PESERTANAMA_SEP
			$this->PESERTANAMA_SEP->LinkCustomAttributes = "";
			$this->PESERTANAMA_SEP->HrefValue = "";

			// PESERTAJENISKELAMIN_SEP
			$this->PESERTAJENISKELAMIN_SEP->LinkCustomAttributes = "";
			$this->PESERTAJENISKELAMIN_SEP->HrefValue = "";

			// PESERTANAMAKELAS_SEP
			$this->PESERTANAMAKELAS_SEP->LinkCustomAttributes = "";
			$this->PESERTANAMAKELAS_SEP->HrefValue = "";

			// PESERTAPISAT
			$this->PESERTAPISAT->LinkCustomAttributes = "";
			$this->PESERTAPISAT->HrefValue = "";

			// PESERTATGLLAHIR
			$this->PESERTATGLLAHIR->LinkCustomAttributes = "";
			$this->PESERTATGLLAHIR->HrefValue = "";

			// PESERTAJENISPESERTA_SEP
			$this->PESERTAJENISPESERTA_SEP->LinkCustomAttributes = "";
			$this->PESERTAJENISPESERTA_SEP->HrefValue = "";

			// PESERTANAMAJENISPESERTA_SEP
			$this->PESERTANAMAJENISPESERTA_SEP->LinkCustomAttributes = "";
			$this->PESERTANAMAJENISPESERTA_SEP->HrefValue = "";

			// POLITUJUAN_SEP
			$this->POLITUJUAN_SEP->LinkCustomAttributes = "";
			$this->POLITUJUAN_SEP->HrefValue = "";

			// NAMAPOLITUJUAN_SEP
			$this->NAMAPOLITUJUAN_SEP->LinkCustomAttributes = "";
			$this->NAMAPOLITUJUAN_SEP->HrefValue = "";

			// KDPPKRUJUKAN_SEP
			$this->KDPPKRUJUKAN_SEP->LinkCustomAttributes = "";
			$this->KDPPKRUJUKAN_SEP->HrefValue = "";

			// NMPPKRUJUKAN_SEP
			$this->NMPPKRUJUKAN_SEP->LinkCustomAttributes = "";
			$this->NMPPKRUJUKAN_SEP->HrefValue = "";

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
		if (!ew_CheckDateDef($this->TGLREG->FormValue)) {
			ew_AddMessage($gsFormError, $this->TGLREG->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->JAMREG->FormValue)) {
			ew_AddMessage($gsFormError, $this->JAMREG->FldErrMsg());
		}
		if (!ew_CheckDate($this->TANGGAL_SEP->FormValue)) {
			ew_AddMessage($gsFormError, $this->TANGGAL_SEP->FldErrMsg());
		}
		if (!ew_CheckDate($this->TANGGALRUJUK_SEP->FormValue)) {
			ew_AddMessage($gsFormError, $this->TANGGALRUJUK_SEP->FldErrMsg());
		}
		if (!ew_CheckInteger($this->KELASRAWAT_SEP->FormValue)) {
			ew_AddMessage($gsFormError, $this->KELASRAWAT_SEP->FldErrMsg());
		}
		if (!$this->status_kepesertaan_BPJS->FldIsDetailKey && !is_null($this->status_kepesertaan_BPJS->FormValue) && $this->status_kepesertaan_BPJS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status_kepesertaan_BPJS->FldCaption(), $this->status_kepesertaan_BPJS->ReqErrMsg));
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// NOMR
		$this->NOMR->SetDbValueDef($rsnew, $this->NOMR->CurrentValue, NULL, FALSE);

		// KDPOLY
		$this->KDPOLY->SetDbValueDef($rsnew, $this->KDPOLY->CurrentValue, NULL, FALSE);

		// KDCARABAYAR
		$this->KDCARABAYAR->SetDbValueDef($rsnew, $this->KDCARABAYAR->CurrentValue, NULL, FALSE);

		// NIP
		$this->NIP->SetDbValueDef($rsnew, $this->NIP->CurrentValue, NULL, FALSE);

		// TGLREG
		$this->TGLREG->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TGLREG->CurrentValue, 0), NULL, FALSE);

		// JAMREG
		$this->JAMREG->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->JAMREG->CurrentValue, 0), NULL, FALSE);

		// NO_SJP
		$this->NO_SJP->SetDbValueDef($rsnew, $this->NO_SJP->CurrentValue, NULL, FALSE);

		// NOKARTU
		$this->NOKARTU->SetDbValueDef($rsnew, $this->NOKARTU->CurrentValue, NULL, FALSE);

		// TANGGAL_SEP
		$this->TANGGAL_SEP->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TANGGAL_SEP->CurrentValue, 5), NULL, FALSE);

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TANGGALRUJUK_SEP->CurrentValue, 5), NULL, FALSE);

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->SetDbValueDef($rsnew, $this->KELASRAWAT_SEP->CurrentValue, NULL, FALSE);

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->SetDbValueDef($rsnew, $this->NORUJUKAN_SEP->CurrentValue, NULL, FALSE);

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->SetDbValueDef($rsnew, $this->PPKPELAYANAN_SEP->CurrentValue, NULL, FALSE);

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->SetDbValueDef($rsnew, $this->JENISPERAWATAN_SEP->CurrentValue, NULL, FALSE);

		// CATATAN_SEP
		$this->CATATAN_SEP->SetDbValueDef($rsnew, $this->CATATAN_SEP->CurrentValue, NULL, FALSE);

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->SetDbValueDef($rsnew, $this->DIAGNOSAAWAL_SEP->CurrentValue, NULL, FALSE);

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->SetDbValueDef($rsnew, $this->NAMADIAGNOSA_SEP->CurrentValue, NULL, FALSE);

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->SetDbValueDef($rsnew, $this->LAKALANTAS_SEP->CurrentValue, NULL, strval($this->LAKALANTAS_SEP->CurrentValue) == "");

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->SetDbValueDef($rsnew, $this->LOKASILAKALANTAS->CurrentValue, NULL, FALSE);

		// USER
		$this->USER->SetDbValueDef($rsnew, $this->USER->CurrentValue, NULL, FALSE);

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->SetDbValueDef($rsnew, $this->PESERTANIK_SEP->CurrentValue, NULL, FALSE);

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->SetDbValueDef($rsnew, $this->PESERTANAMA_SEP->CurrentValue, NULL, FALSE);

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->SetDbValueDef($rsnew, $this->PESERTAJENISKELAMIN_SEP->CurrentValue, NULL, FALSE);

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->SetDbValueDef($rsnew, $this->PESERTANAMAKELAS_SEP->CurrentValue, NULL, FALSE);

		// PESERTAPISAT
		$this->PESERTAPISAT->SetDbValueDef($rsnew, $this->PESERTAPISAT->CurrentValue, NULL, FALSE);

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->SetDbValueDef($rsnew, $this->PESERTATGLLAHIR->CurrentValue, NULL, FALSE);

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->SetDbValueDef($rsnew, $this->PESERTAJENISPESERTA_SEP->CurrentValue, NULL, FALSE);

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->SetDbValueDef($rsnew, $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue, NULL, FALSE);

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->SetDbValueDef($rsnew, $this->POLITUJUAN_SEP->CurrentValue, NULL, FALSE);

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->SetDbValueDef($rsnew, $this->NAMAPOLITUJUAN_SEP->CurrentValue, NULL, FALSE);

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->SetDbValueDef($rsnew, $this->KDPPKRUJUKAN_SEP->CurrentValue, NULL, FALSE);

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->SetDbValueDef($rsnew, $this->NMPPKRUJUKAN_SEP->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bridging_sep_by_no_kartulist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_NOMR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR` AS `LinkFld`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "{filter}";
			$this->NOMR->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`NOMR` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDPOLY":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "";
			$this->KDPOLY->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDCARABAYAR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE` AS `LinkFld`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->KDCARABAYAR->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KODE` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_JENISPERAWATAN_SEP":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `jeniskeperawatan_id` AS `LinkFld`, `jeniskeperawatan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskeperawatan`";
			$sWhereWrk = "";
			$this->JENISPERAWATAN_SEP->LookupFilters = array();
			$lookuptblfilter = "`jeniskeperawatan_id`='2'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`jeniskeperawatan_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->JENISPERAWATAN_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_DIAGNOSAAWAL_SEP":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Code` AS `LinkFld`, `Code` AS `DispFld`, `Description` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `refdiagnosis`";
			$sWhereWrk = "{filter}";
			$this->DIAGNOSAAWAL_SEP->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`Code` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->DIAGNOSAAWAL_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_LAKALANTAS_SEP":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_lakalantas`";
			$sWhereWrk = "";
			$this->LAKALANTAS_SEP->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->LAKALANTAS_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_POLITUJUAN_SEP":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDPOLI` AS `LinkFld`, `KDPOLI` AS `DispFld`, `NMPOLI` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `refpoli`";
			$sWhereWrk = "";
			$this->POLITUJUAN_SEP->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KDPOLI` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->POLITUJUAN_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_NOMR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld` FROM `m_pasien`";
			$sWhereWrk = "`NOMR` LIKE '%{query_value}%' OR `NAMA` LIKE '%{query_value}%' OR CONCAT(`NOMR`,'" . ew_ValueSeparator(1, $this->NOMR) . "',`NAMA`) LIKE '{query_value}%'";
			$this->NOMR->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_DIAGNOSAAWAL_SEP":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Code`, `Code` AS `DispFld`, `Description` AS `Disp2Fld` FROM `refdiagnosis`";
			$sWhereWrk = "`Code` LIKE '%{query_value}%' OR `Description` LIKE '%{query_value}%' OR CONCAT(`Code`,'" . ew_ValueSeparator(1, $this->DIAGNOSAAWAL_SEP) . "',`Description`) LIKE '{query_value}%'";
			$this->DIAGNOSAAWAL_SEP->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->DIAGNOSAAWAL_SEP, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($vw_bridging_sep_by_no_kartu_add)) $vw_bridging_sep_by_no_kartu_add = new cvw_bridging_sep_by_no_kartu_add();

// Page init
$vw_bridging_sep_by_no_kartu_add->Page_Init();

// Page main
$vw_bridging_sep_by_no_kartu_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bridging_sep_by_no_kartu_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_bridging_sep_by_no_kartuadd = new ew_Form("fvw_bridging_sep_by_no_kartuadd", "add");

// Validate form
fvw_bridging_sep_by_no_kartuadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_TGLREG");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_kartu->TGLREG->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_JAMREG");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_kartu->JAMREG->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TANGGAL_SEP");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TANGGALRUJUK_SEP");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_KELASRAWAT_SEP");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_kepesertaan_BPJS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->FldCaption(), $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->ReqErrMsg)) ?>");

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
fvw_bridging_sep_by_no_kartuadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bridging_sep_by_no_kartuadd.ValidateRequired = true;
<?php } else { ?>
fvw_bridging_sep_by_no_kartuadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bridging_sep_by_no_kartuadd.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_bridging_sep_by_no_kartuadd.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_bridging_sep_by_no_kartuadd.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_bridging_sep_by_no_kartuadd.Lists["x_JENISPERAWATAN_SEP"] = {"LinkField":"x_jeniskeperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskeperawatan_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskeperawatan"};
fvw_bridging_sep_by_no_kartuadd.Lists["x_DIAGNOSAAWAL_SEP"] = {"LinkField":"x_Code","Ajax":true,"AutoFill":true,"DisplayFields":["x_Code","x_Description","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"refdiagnosis"};
fvw_bridging_sep_by_no_kartuadd.Lists["x_LAKALANTAS_SEP"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_lakalantas","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_lakalantas"};
fvw_bridging_sep_by_no_kartuadd.Lists["x_POLITUJUAN_SEP"] = {"LinkField":"x_KDPOLI","Ajax":true,"AutoFill":true,"DisplayFields":["x_KDPOLI","x_NMPOLI","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"refpoli"};
fvw_bridging_sep_by_no_kartuadd.Lists["x_penjamin_kkl_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuadd.Lists["x_penjamin_kkl_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->penjamin_kkl_id->Options()) ?>;
fvw_bridging_sep_by_no_kartuadd.Lists["x_asalfaskesrujukan_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuadd.Lists["x_asalfaskesrujukan_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->Options()) ?>;
fvw_bridging_sep_by_no_kartuadd.Lists["x_peserta_cob"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuadd.Lists["x_peserta_cob"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->peserta_cob->Options()) ?>;
fvw_bridging_sep_by_no_kartuadd.Lists["x_poli_eksekutif"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuadd.Lists["x_poli_eksekutif"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->poli_eksekutif->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_bridging_sep_by_no_kartu_add->IsModal) { ?>
<?php } ?>
<?php $vw_bridging_sep_by_no_kartu_add->ShowPageHeader(); ?>
<?php
$vw_bridging_sep_by_no_kartu_add->ShowMessage();
?>
<form name="fvw_bridging_sep_by_no_kartuadd" id="fvw_bridging_sep_by_no_kartuadd" class="<?php echo $vw_bridging_sep_by_no_kartu_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bridging_sep_by_no_kartu_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bridging_sep_by_no_kartu_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bridging_sep_by_no_kartu">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_bridging_sep_by_no_kartu_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_bridging_sep_by_no_kartu->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NOMR" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NOMR->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NOMR->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NOMR">
<?php
$wrkonchange = trim(" " . @$vw_bridging_sep_by_no_kartu->NOMR->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_bridging_sep_by_no_kartu->NOMR->EditAttrs["onchange"] = "";
?>
<span id="as_x_NOMR" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_NOMR" id="sv_x_NOMR" value="<?php echo $vw_bridging_sep_by_no_kartu->NOMR->EditValue ?>" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NOMR->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NOMR->getPlaceHolder()) ?>"<?php echo $vw_bridging_sep_by_no_kartu->NOMR->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NOMR" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->NOMR->DisplayValueSeparatorAttribute() ?>" name="x_NOMR" id="x_NOMR" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NOMR->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_NOMR" id="q_x_NOMR" value="<?php echo $vw_bridging_sep_by_no_kartu->NOMR->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_bridging_sep_by_no_kartuadd.CreateAutoSuggest({"id":"x_NOMR","forceSelect":false});
</script>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NOMR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDPOLY->Visible) { // KDPOLY ?>
	<div id="r_KDPOLY" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KDPOLY" for="x_KDPOLY" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KDPOLY">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_KDPOLY" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->DisplayValueSeparatorAttribute() ?>" id="x_KDPOLY" name="x_KDPOLY"<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->SelectOptionListHtml("x_KDPOLY") ?>
</select>
<input type="hidden" name="s_x_KDPOLY" id="s_x_KDPOLY" value="<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->LookupFilterQuery() ?>">
</span>
<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<div id="r_KDCARABAYAR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KDCARABAYAR" for="x_KDCARABAYAR" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KDCARABAYAR">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_KDCARABAYAR" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->DisplayValueSeparatorAttribute() ?>" id="x_KDCARABAYAR" name="x_KDCARABAYAR"<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->SelectOptionListHtml("x_KDCARABAYAR") ?>
</select>
<input type="hidden" name="s_x_KDCARABAYAR" id="s_x_KDCARABAYAR" value="<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->LookupFilterQuery() ?>">
</span>
<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NIP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NIP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NIP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NIP" name="x_NIP" id="x_NIP" size="30" maxlength="16" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NIP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NIP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NIP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TGLREG->Visible) { // TGLREG ?>
	<div id="r_TGLREG" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_TGLREG" for="x_TGLREG" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->TGLREG->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_TGLREG">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_TGLREG" name="x_TGLREG" id="x_TGLREG" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->TGLREG->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->JAMREG->Visible) { // JAMREG ?>
	<div id="r_JAMREG" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_JAMREG" for="x_JAMREG" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->JAMREG->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_JAMREG">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_JAMREG" name="x_JAMREG" id="x_JAMREG" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->JAMREG->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NO_SJP->Visible) { // NO_SJP ?>
	<div id="r_NO_SJP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NO_SJP" for="x_NO_SJP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NO_SJP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NO_SJP" name="x_NO_SJP" id="x_NO_SJP" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NO_SJP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NOKARTU->Visible) { // NOKARTU ?>
	<div id="r_NOKARTU" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NOKARTU" for="x_NOKARTU" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NOKARTU">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NOKARTU" name="x_NOKARTU" id="x_NOKARTU" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NOKARTU->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->Visible) { // TANGGAL_SEP ?>
	<div id="r_TANGGAL_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_TANGGAL_SEP" for="x_TANGGAL_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_TANGGAL_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_TANGGAL_SEP" data-format="5" name="x_TANGGAL_SEP" id="x_TANGGAL_SEP" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditAttributes() ?>>
<?php if (!$vw_bridging_sep_by_no_kartu->TANGGAL_SEP->ReadOnly && !$vw_bridging_sep_by_no_kartu->TANGGAL_SEP->Disabled && !isset($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditAttrs["readonly"]) && !isset($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bridging_sep_by_no_kartuadd", "x_TANGGAL_SEP", 5);
</script>
<?php } ?>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->Visible) { // TANGGALRUJUK_SEP ?>
	<div id="r_TANGGALRUJUK_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP" for="x_TANGGALRUJUK_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_TANGGALRUJUK_SEP" data-format="5" name="x_TANGGALRUJUK_SEP" id="x_TANGGALRUJUK_SEP" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditAttributes() ?>>
<?php if (!$vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->ReadOnly && !$vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->Disabled && !isset($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditAttrs["readonly"]) && !isset($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bridging_sep_by_no_kartuadd", "x_TANGGALRUJUK_SEP", 5);
</script>
<?php } ?>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->Visible) { // KELASRAWAT_SEP ?>
	<div id="r_KELASRAWAT_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP" for="x_KELASRAWAT_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_KELASRAWAT_SEP" name="x_KELASRAWAT_SEP" id="x_KELASRAWAT_SEP" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->Visible) { // NORUJUKAN_SEP ?>
	<div id="r_NORUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP" for="x_NORUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NORUJUKAN_SEP" name="x_NORUJUKAN_SEP" id="x_NORUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->Visible) { // PPKPELAYANAN_SEP ?>
	<div id="r_PPKPELAYANAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP" for="x_PPKPELAYANAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PPKPELAYANAN_SEP" name="x_PPKPELAYANAN_SEP" id="x_PPKPELAYANAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->Visible) { // JENISPERAWATAN_SEP ?>
	<div id="r_JENISPERAWATAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP">
<div id="tp_x_JENISPERAWATAN_SEP" class="ewTemplate"><input type="radio" data-table="vw_bridging_sep_by_no_kartu" data-field="x_JENISPERAWATAN_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->DisplayValueSeparatorAttribute() ?>" name="x_JENISPERAWATAN_SEP" id="x_JENISPERAWATAN_SEP" value="{value}"<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->EditAttributes() ?>></div>
<div id="dsl_x_JENISPERAWATAN_SEP" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->RadioButtonListHtml(FALSE, "x_JENISPERAWATAN_SEP") ?>
</div></div>
<input type="hidden" name="s_x_JENISPERAWATAN_SEP" id="s_x_JENISPERAWATAN_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->LookupFilterQuery() ?>">
</span>
<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->CATATAN_SEP->Visible) { // CATATAN_SEP ?>
	<div id="r_CATATAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_CATATAN_SEP" for="x_CATATAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_CATATAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_CATATAN_SEP" name="x_CATATAN_SEP" id="x_CATATAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->CATATAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->Visible) { // DIAGNOSAAWAL_SEP ?>
	<div id="r_DIAGNOSAAWAL_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->EditAttrs["onchange"] = "";
?>
<span id="as_x_DIAGNOSAAWAL_SEP" style="white-space: nowrap; z-index: 8830">
	<input type="text" name="sv_x_DIAGNOSAAWAL_SEP" id="sv_x_DIAGNOSAAWAL_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->getPlaceHolder()) ?>"<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_DIAGNOSAAWAL_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->DisplayValueSeparatorAttribute() ?>" name="x_DIAGNOSAAWAL_SEP" id="x_DIAGNOSAAWAL_SEP" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_DIAGNOSAAWAL_SEP" id="q_x_DIAGNOSAAWAL_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_bridging_sep_by_no_kartuadd.CreateAutoSuggest({"id":"x_DIAGNOSAAWAL_SEP","forceSelect":true});
</script>
<input type="hidden" name="ln_x_DIAGNOSAAWAL_SEP" id="ln_x_DIAGNOSAAWAL_SEP" value="x_NAMADIAGNOSA_SEP">
</span>
<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->Visible) { // NAMADIAGNOSA_SEP ?>
	<div id="r_NAMADIAGNOSA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP" for="x_NAMADIAGNOSA_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NAMADIAGNOSA_SEP" name="x_NAMADIAGNOSA_SEP" id="x_NAMADIAGNOSA_SEP" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->Visible) { // LAKALANTAS_SEP ?>
	<div id="r_LAKALANTAS_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP">
<div id="tp_x_LAKALANTAS_SEP" class="ewTemplate"><input type="radio" data-table="vw_bridging_sep_by_no_kartu" data-field="x_LAKALANTAS_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->DisplayValueSeparatorAttribute() ?>" name="x_LAKALANTAS_SEP" id="x_LAKALANTAS_SEP" value="{value}"<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->EditAttributes() ?>></div>
<div id="dsl_x_LAKALANTAS_SEP" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->RadioButtonListHtml(FALSE, "x_LAKALANTAS_SEP") ?>
</div></div>
<input type="hidden" name="s_x_LAKALANTAS_SEP" id="s_x_LAKALANTAS_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->LookupFilterQuery() ?>">
</span>
<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->Visible) { // LOKASILAKALANTAS ?>
	<div id="r_LOKASILAKALANTAS" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS" for="x_LOKASILAKALANTAS" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_LOKASILAKALANTAS" name="x_LOKASILAKALANTAS" id="x_LOKASILAKALANTAS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->USER->Visible) { // USER ?>
	<div id="r_USER" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_USER" for="x_USER" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->USER->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->USER->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_USER">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_USER" name="x_USER" id="x_USER" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->USER->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->USER->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->USER->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->USER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->Visible) { // PESERTANIK_SEP ?>
	<div id="r_PESERTANIK_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP" for="x_PESERTANIK_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANIK_SEP" name="x_PESERTANIK_SEP" id="x_PESERTANIK_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->Visible) { // PESERTANAMA_SEP ?>
	<div id="r_PESERTANAMA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP" for="x_PESERTANAMA_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANAMA_SEP" name="x_PESERTANAMA_SEP" id="x_PESERTANAMA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->Visible) { // PESERTAJENISKELAMIN_SEP ?>
	<div id="r_PESERTAJENISKELAMIN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP" for="x_PESERTAJENISKELAMIN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTAJENISKELAMIN_SEP" name="x_PESERTAJENISKELAMIN_SEP" id="x_PESERTAJENISKELAMIN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->Visible) { // PESERTANAMAKELAS_SEP ?>
	<div id="r_PESERTANAMAKELAS_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP" for="x_PESERTANAMAKELAS_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANAMAKELAS_SEP" name="x_PESERTANAMAKELAS_SEP" id="x_PESERTANAMAKELAS_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAPISAT->Visible) { // PESERTAPISAT ?>
	<div id="r_PESERTAPISAT" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTAPISAT" for="x_PESERTAPISAT" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAPISAT">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTAPISAT" name="x_PESERTAPISAT" id="x_PESERTAPISAT" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTAPISAT->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->Visible) { // PESERTATGLLAHIR ?>
	<div id="r_PESERTATGLLAHIR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR" for="x_PESERTATGLLAHIR" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTATGLLAHIR" name="x_PESERTATGLLAHIR" id="x_PESERTATGLLAHIR" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->Visible) { // PESERTAJENISPESERTA_SEP ?>
	<div id="r_PESERTAJENISPESERTA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP" for="x_PESERTAJENISPESERTA_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTAJENISPESERTA_SEP" name="x_PESERTAJENISPESERTA_SEP" id="x_PESERTAJENISPESERTA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->Visible) { // PESERTANAMAJENISPESERTA_SEP ?>
	<div id="r_PESERTANAMAJENISPESERTA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP" for="x_PESERTANAMAJENISPESERTA_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANAMAJENISPESERTA_SEP" name="x_PESERTANAMAJENISPESERTA_SEP" id="x_PESERTANAMAJENISPESERTA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->Visible) { // POLITUJUAN_SEP ?>
	<div id="r_POLITUJUAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP" for="x_POLITUJUAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP">
<?php $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->EditAttrs["onchange"]; ?>
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_POLITUJUAN_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->DisplayValueSeparatorAttribute() ?>" id="x_POLITUJUAN_SEP" name="x_POLITUJUAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->SelectOptionListHtml("x_POLITUJUAN_SEP") ?>
</select>
<input type="hidden" name="s_x_POLITUJUAN_SEP" id="s_x_POLITUJUAN_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_POLITUJUAN_SEP" id="ln_x_POLITUJUAN_SEP" value="x_NAMAPOLITUJUAN_SEP">
</span>
<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->Visible) { // NAMAPOLITUJUAN_SEP ?>
	<div id="r_NAMAPOLITUJUAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP" for="x_NAMAPOLITUJUAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NAMAPOLITUJUAN_SEP" name="x_NAMAPOLITUJUAN_SEP" id="x_NAMAPOLITUJUAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->Visible) { // KDPPKRUJUKAN_SEP ?>
	<div id="r_KDPPKRUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP" for="x_KDPPKRUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_KDPPKRUJUKAN_SEP" name="x_KDPPKRUJUKAN_SEP" id="x_KDPPKRUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->Visible) { // NMPPKRUJUKAN_SEP ?>
	<div id="r_NMPPKRUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP" for="x_NMPPKRUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NMPPKRUJUKAN_SEP" name="x_NMPPKRUJUKAN_SEP" id="x_NMPPKRUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->pasien_NOTELP->Visible) { // pasien_NOTELP ?>
	<div id="r_pasien_NOTELP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_pasien_NOTELP" for="x_pasien_NOTELP" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_pasien_NOTELP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_pasien_NOTELP" name="x_pasien_NOTELP" id="x_pasien_NOTELP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->pasien_NOTELP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->penjamin_kkl_id->Visible) { // penjamin_kkl_id ?>
	<div id="r_penjamin_kkl_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_penjamin_kkl_id" for="x_penjamin_kkl_id" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_penjamin_kkl_id">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_penjamin_kkl_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->DisplayValueSeparatorAttribute() ?>" id="x_penjamin_kkl_id" name="x_penjamin_kkl_id"<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->SelectOptionListHtml("x_penjamin_kkl_id") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->Visible) { // asalfaskesrujukan_id ?>
	<div id="r_asalfaskesrujukan_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id" for="x_asalfaskesrujukan_id" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_asalfaskesrujukan_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->DisplayValueSeparatorAttribute() ?>" id="x_asalfaskesrujukan_id" name="x_asalfaskesrujukan_id"<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->SelectOptionListHtml("x_asalfaskesrujukan_id") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->peserta_cob->Visible) { // peserta_cob ?>
	<div id="r_peserta_cob" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_peserta_cob" for="x_peserta_cob" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_peserta_cob">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_peserta_cob" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->DisplayValueSeparatorAttribute() ?>" id="x_peserta_cob" name="x_peserta_cob"<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->SelectOptionListHtml("x_peserta_cob") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<div id="r_poli_eksekutif" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_poli_eksekutif" for="x_poli_eksekutif" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_poli_eksekutif">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_poli_eksekutif" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->DisplayValueSeparatorAttribute() ?>" id="x_poli_eksekutif" name="x_poli_eksekutif"<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->SelectOptionListHtml("x_poli_eksekutif") ?>
</select>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->Visible) { // status_kepesertaan_BPJS ?>
	<div id="r_status_kepesertaan_BPJS" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS" for="x_status_kepesertaan_BPJS" class="col-sm-2 control-label ewLabel"><?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_status_kepesertaan_BPJS" name="x_status_kepesertaan_BPJS" id="x_status_kepesertaan_BPJS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->EditAttributes() ?>>
</span>
<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_bridging_sep_by_no_kartu_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bridging_sep_by_no_kartu_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_bridging_sep_by_no_kartuadd.Init();
</script>
<?php
$vw_bridging_sep_by_no_kartu_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bridging_sep_by_no_kartu_add->Page_Terminate();
?>
