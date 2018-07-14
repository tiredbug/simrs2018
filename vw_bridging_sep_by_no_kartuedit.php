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

$vw_bridging_sep_by_no_kartu_edit = NULL; // Initialize page object first

class cvw_bridging_sep_by_no_kartu_edit extends cvw_bridging_sep_by_no_kartu {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bridging_sep_by_no_kartu';

	// Page object name
	var $PageObjName = 'vw_bridging_sep_by_no_kartu_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		if (@$_POST["customexport"] == "") {

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		global $EW_EXPORT, $vw_bridging_sep_by_no_kartu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
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
	if ($this->CustomExport <> "") { // Save temp images array for custom export
		if (is_array($gTmpImages))
			$_SESSION[EW_SESSION_TEMP_IMAGES] = $gTmpImages;
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
			$this->Page_Terminate("vw_bridging_sep_by_no_kartulist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_bridging_sep_by_no_kartulist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_bridging_sep_by_no_kartulist.php")
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
		$this->LoadRow();
		$this->IDXDAFTAR->CurrentValue = $this->IDXDAFTAR->FormValue;
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

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";
			$this->IDXDAFTAR->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// IDXDAFTAR
			$this->IDXDAFTAR->EditAttrs["class"] = "form-control";
			$this->IDXDAFTAR->EditCustomAttributes = "";
			$this->IDXDAFTAR->EditValue = $this->IDXDAFTAR->CurrentValue;
			$this->IDXDAFTAR->ViewCustomAttributes = "";

			// NOMR
			$this->NOMR->EditAttrs["class"] = "form-control";
			$this->NOMR->EditCustomAttributes = "";
			$this->NOMR->EditValue = $this->NOMR->CurrentValue;
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
					$this->NOMR->EditValue = $this->NOMR->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NOMR->EditValue = $this->NOMR->CurrentValue;
				}
			} else {
				$this->NOMR->EditValue = NULL;
			}
			$this->NOMR->ViewCustomAttributes = "";

			// KDPOLY
			$this->KDPOLY->EditAttrs["class"] = "form-control";
			$this->KDPOLY->EditCustomAttributes = "";
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
					$this->KDPOLY->EditValue = $this->KDPOLY->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->KDPOLY->EditValue = $this->KDPOLY->CurrentValue;
				}
			} else {
				$this->KDPOLY->EditValue = NULL;
			}
			$this->KDPOLY->ViewCustomAttributes = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
			$this->KDCARABAYAR->EditCustomAttributes = "";
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
					$this->KDCARABAYAR->EditValue = $this->KDCARABAYAR->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->KDCARABAYAR->EditValue = $this->KDCARABAYAR->CurrentValue;
				}
			} else {
				$this->KDCARABAYAR->EditValue = NULL;
			}
			$this->KDCARABAYAR->ViewCustomAttributes = "";

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = $this->NIP->CurrentValue;
			$this->NIP->ViewCustomAttributes = "";

			// TGLREG
			$this->TGLREG->EditAttrs["class"] = "form-control";
			$this->TGLREG->EditCustomAttributes = "";
			$this->TGLREG->EditValue = $this->TGLREG->CurrentValue;
			$this->TGLREG->EditValue = ew_FormatDateTime($this->TGLREG->EditValue, 0);
			$this->TGLREG->ViewCustomAttributes = "";

			// JAMREG
			$this->JAMREG->EditAttrs["class"] = "form-control";
			$this->JAMREG->EditCustomAttributes = "";
			$this->JAMREG->EditValue = $this->JAMREG->CurrentValue;
			$this->JAMREG->EditValue = ew_FormatDateTime($this->JAMREG->EditValue, 0);
			$this->JAMREG->ViewCustomAttributes = "";

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

			// Edit refer script
			// IDXDAFTAR

			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";

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

			// NO_SJP
			$this->NO_SJP->SetDbValueDef($rsnew, $this->NO_SJP->CurrentValue, NULL, $this->NO_SJP->ReadOnly);

			// NOKARTU
			$this->NOKARTU->SetDbValueDef($rsnew, $this->NOKARTU->CurrentValue, NULL, $this->NOKARTU->ReadOnly);

			// TANGGAL_SEP
			$this->TANGGAL_SEP->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TANGGAL_SEP->CurrentValue, 5), NULL, $this->TANGGAL_SEP->ReadOnly);

			// TANGGALRUJUK_SEP
			$this->TANGGALRUJUK_SEP->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TANGGALRUJUK_SEP->CurrentValue, 5), NULL, $this->TANGGALRUJUK_SEP->ReadOnly);

			// KELASRAWAT_SEP
			$this->KELASRAWAT_SEP->SetDbValueDef($rsnew, $this->KELASRAWAT_SEP->CurrentValue, NULL, $this->KELASRAWAT_SEP->ReadOnly);

			// NORUJUKAN_SEP
			$this->NORUJUKAN_SEP->SetDbValueDef($rsnew, $this->NORUJUKAN_SEP->CurrentValue, NULL, $this->NORUJUKAN_SEP->ReadOnly);

			// PPKPELAYANAN_SEP
			$this->PPKPELAYANAN_SEP->SetDbValueDef($rsnew, $this->PPKPELAYANAN_SEP->CurrentValue, NULL, $this->PPKPELAYANAN_SEP->ReadOnly);

			// JENISPERAWATAN_SEP
			$this->JENISPERAWATAN_SEP->SetDbValueDef($rsnew, $this->JENISPERAWATAN_SEP->CurrentValue, NULL, $this->JENISPERAWATAN_SEP->ReadOnly);

			// CATATAN_SEP
			$this->CATATAN_SEP->SetDbValueDef($rsnew, $this->CATATAN_SEP->CurrentValue, NULL, $this->CATATAN_SEP->ReadOnly);

			// DIAGNOSAAWAL_SEP
			$this->DIAGNOSAAWAL_SEP->SetDbValueDef($rsnew, $this->DIAGNOSAAWAL_SEP->CurrentValue, NULL, $this->DIAGNOSAAWAL_SEP->ReadOnly);

			// NAMADIAGNOSA_SEP
			$this->NAMADIAGNOSA_SEP->SetDbValueDef($rsnew, $this->NAMADIAGNOSA_SEP->CurrentValue, NULL, $this->NAMADIAGNOSA_SEP->ReadOnly);

			// LAKALANTAS_SEP
			$this->LAKALANTAS_SEP->SetDbValueDef($rsnew, $this->LAKALANTAS_SEP->CurrentValue, NULL, $this->LAKALANTAS_SEP->ReadOnly);

			// LOKASILAKALANTAS
			$this->LOKASILAKALANTAS->SetDbValueDef($rsnew, $this->LOKASILAKALANTAS->CurrentValue, NULL, $this->LOKASILAKALANTAS->ReadOnly);

			// USER
			$this->USER->SetDbValueDef($rsnew, $this->USER->CurrentValue, NULL, $this->USER->ReadOnly);

			// PESERTANIK_SEP
			$this->PESERTANIK_SEP->SetDbValueDef($rsnew, $this->PESERTANIK_SEP->CurrentValue, NULL, $this->PESERTANIK_SEP->ReadOnly);

			// PESERTANAMA_SEP
			$this->PESERTANAMA_SEP->SetDbValueDef($rsnew, $this->PESERTANAMA_SEP->CurrentValue, NULL, $this->PESERTANAMA_SEP->ReadOnly);

			// PESERTAJENISKELAMIN_SEP
			$this->PESERTAJENISKELAMIN_SEP->SetDbValueDef($rsnew, $this->PESERTAJENISKELAMIN_SEP->CurrentValue, NULL, $this->PESERTAJENISKELAMIN_SEP->ReadOnly);

			// PESERTANAMAKELAS_SEP
			$this->PESERTANAMAKELAS_SEP->SetDbValueDef($rsnew, $this->PESERTANAMAKELAS_SEP->CurrentValue, NULL, $this->PESERTANAMAKELAS_SEP->ReadOnly);

			// PESERTAPISAT
			$this->PESERTAPISAT->SetDbValueDef($rsnew, $this->PESERTAPISAT->CurrentValue, NULL, $this->PESERTAPISAT->ReadOnly);

			// PESERTATGLLAHIR
			$this->PESERTATGLLAHIR->SetDbValueDef($rsnew, $this->PESERTATGLLAHIR->CurrentValue, NULL, $this->PESERTATGLLAHIR->ReadOnly);

			// PESERTAJENISPESERTA_SEP
			$this->PESERTAJENISPESERTA_SEP->SetDbValueDef($rsnew, $this->PESERTAJENISPESERTA_SEP->CurrentValue, NULL, $this->PESERTAJENISPESERTA_SEP->ReadOnly);

			// PESERTANAMAJENISPESERTA_SEP
			$this->PESERTANAMAJENISPESERTA_SEP->SetDbValueDef($rsnew, $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue, NULL, $this->PESERTANAMAJENISPESERTA_SEP->ReadOnly);

			// POLITUJUAN_SEP
			$this->POLITUJUAN_SEP->SetDbValueDef($rsnew, $this->POLITUJUAN_SEP->CurrentValue, NULL, $this->POLITUJUAN_SEP->ReadOnly);

			// NAMAPOLITUJUAN_SEP
			$this->NAMAPOLITUJUAN_SEP->SetDbValueDef($rsnew, $this->NAMAPOLITUJUAN_SEP->CurrentValue, NULL, $this->NAMAPOLITUJUAN_SEP->ReadOnly);

			// KDPPKRUJUKAN_SEP
			$this->KDPPKRUJUKAN_SEP->SetDbValueDef($rsnew, $this->KDPPKRUJUKAN_SEP->CurrentValue, NULL, $this->KDPPKRUJUKAN_SEP->ReadOnly);

			// NMPPKRUJUKAN_SEP
			$this->NMPPKRUJUKAN_SEP->SetDbValueDef($rsnew, $this->NMPPKRUJUKAN_SEP->CurrentValue, NULL, $this->NMPPKRUJUKAN_SEP->ReadOnly);

			// pasien_NOTELP
			$this->pasien_NOTELP->SetDbValueDef($rsnew, $this->pasien_NOTELP->CurrentValue, NULL, $this->pasien_NOTELP->ReadOnly);

			// penjamin_kkl_id
			$this->penjamin_kkl_id->SetDbValueDef($rsnew, $this->penjamin_kkl_id->CurrentValue, NULL, $this->penjamin_kkl_id->ReadOnly);

			// asalfaskesrujukan_id
			$this->asalfaskesrujukan_id->SetDbValueDef($rsnew, $this->asalfaskesrujukan_id->CurrentValue, NULL, $this->asalfaskesrujukan_id->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bridging_sep_by_no_kartulist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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

			if ($this->CurrentAction == "U") {
			$url = "cetak_vclaim_sep_rajal.php?id=".$this->IDXDAFTAR->FormValue."&&no=".$this->NO_SJP->FormValue;
		}
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
if (!isset($vw_bridging_sep_by_no_kartu_edit)) $vw_bridging_sep_by_no_kartu_edit = new cvw_bridging_sep_by_no_kartu_edit();

// Page init
$vw_bridging_sep_by_no_kartu_edit->Page_Init();

// Page main
$vw_bridging_sep_by_no_kartu_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bridging_sep_by_no_kartu_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_bridging_sep_by_no_kartuedit = new ew_Form("fvw_bridging_sep_by_no_kartuedit", "edit");

// Validate form
fvw_bridging_sep_by_no_kartuedit.Validate = function() {
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
fvw_bridging_sep_by_no_kartuedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bridging_sep_by_no_kartuedit.ValidateRequired = true;
<?php } else { ?>
fvw_bridging_sep_by_no_kartuedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bridging_sep_by_no_kartuedit.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_bridging_sep_by_no_kartuedit.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_bridging_sep_by_no_kartuedit.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_bridging_sep_by_no_kartuedit.Lists["x_JENISPERAWATAN_SEP"] = {"LinkField":"x_jeniskeperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskeperawatan_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskeperawatan"};
fvw_bridging_sep_by_no_kartuedit.Lists["x_DIAGNOSAAWAL_SEP"] = {"LinkField":"x_Code","Ajax":true,"AutoFill":true,"DisplayFields":["x_Code","x_Description","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"refdiagnosis"};
fvw_bridging_sep_by_no_kartuedit.Lists["x_LAKALANTAS_SEP"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_lakalantas","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_lakalantas"};
fvw_bridging_sep_by_no_kartuedit.Lists["x_POLITUJUAN_SEP"] = {"LinkField":"x_KDPOLI","Ajax":true,"AutoFill":true,"DisplayFields":["x_KDPOLI","x_NMPOLI","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"refpoli"};
fvw_bridging_sep_by_no_kartuedit.Lists["x_penjamin_kkl_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuedit.Lists["x_penjamin_kkl_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->penjamin_kkl_id->Options()) ?>;
fvw_bridging_sep_by_no_kartuedit.Lists["x_asalfaskesrujukan_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuedit.Lists["x_asalfaskesrujukan_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->Options()) ?>;
fvw_bridging_sep_by_no_kartuedit.Lists["x_peserta_cob"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuedit.Lists["x_peserta_cob"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->peserta_cob->Options()) ?>;
fvw_bridging_sep_by_no_kartuedit.Lists["x_poli_eksekutif"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuedit.Lists["x_poli_eksekutif"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->poli_eksekutif->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

function formatDate(date) {
	var d = new Date(date),
		month = '' + (d.getMonth() + 1),
		day = '' + d.getDate(),
		year = d.getFullYear();
	if (month.length < 2) month = '0' + month;
	if (day.length < 2) day = '0' + day;
	return [year, month, day].join('-');
}
$(document).ready(function() {
	$("#x_JENISPERAWATAN_SEP").attr("checked", true);

	//$('#x_POLITUJUAN_SEP').css('background-color', '#ffff00');
	//$('#x_NORUJUKAN_SEP').css('background-color', '#ffff00');
	//$('#x_TANGGALRUJUK_SEP').css('background-color', '#ffff00');
	//$('#x_CATATAN_SEP').css('background-color', '#ffff00');
	//$('#x_TANGGAL_SEP').css('background-color', '#ffff00');

	$('#x_NO_SJP').css('background-color', '#ffff00');

	//$('#x_NO_SJP').css('background-color', '#ffff00');
	$('#x_status_kepesertaan_BPJS').css('background-color', '#ffff00');
	$('#x_NOKARTU').css('background-color', '#ffff00');

	//$('#x_USER').css('background-color', '#ffff00');
	//$('#x_asalfaskesrujukan_id').css('background-color', '#ffff00');
	//$('#x_PPKPELAYANAN_SEP').css('background-color', '#ffff00');
	//$('#x_peserta_cob').css('background-color', '#ffff00');
//	$('#x_DIAGNOSAAWAL_SEP').css('background-color', '#ffff00');

	$('#x_pasien_NOTELP').css('background-color', '#ffff00');
	$('#x_penjamin_kkl_id').hide();
	$('#lbl_penjamin_kkl_id').hide();
	$('#lbl_LOKASILAKALANTAS').hide();
	$('#x_LOKASILAKALANTAS').hide();
 	if ($("#x_LAKALANTAS_SEP").val() == "2") {
		$('#x_LOKASILAKALANTAS').removeAttr('disabled');
	} else {
		$('#x_LOKASILAKALANTAS').attr('disabled','disabled'); 
	}	
		var date = new Date();
		var yyyy = date.getFullYear().toString();
		var mm = (date.getMonth()+1).toString();
		var dd  = date.getDate().toString();   
		var mmChars = mm.split('');   
		var ddChars = dd.split('');
		var datestring = yyyy + '/' + (mmChars[1]?mm:"0"+mmChars[0]) + '/' + (ddChars[1]?dd:"0"+ddChars[0]); 
		var norujukan = (ddChars[1]?dd:"0"+ddChars[0]) + '/' + (mmChars[1]?mm:"0"+mmChars[0]) + '/' + yyyy;
	$("#x_TANGGAL_SEP").val(datestring);
	$("#x_TANGGALRUJUK_SEP").val(datestring); 
	$("#x_NORUJUKAN_SEP").val(norujukan);
	$("#x_asalfaskesrujukan_id").val(1);

	//var no_kartu = $('#x_NOKARTU').val();
	//if (no_kartu==""){alert ("no kartu harus diisi"); return;}
	//var tgl = $('#x_TANGGAL_SEP').val();
	//if (tgl==""){alert ("Tanggal harus diisi"); return;}
	//var tanggal = formatDate($("#x_TANGGAL_SEP").val());
	// Kondisi saat ComboBox (Select Option) dipilih nilainya  

	$("#x_LAKALANTAS_SEP").change(function() {
		if (this.value == "2") {     
			$('#x_LOKASILAKALANTAS').attr('disabled','disabled'); 
			$('#x_LOKASILAKALANTAS').val('');
			$('#x_LOKASILAKALANTAS').css('background-color', 'transparent');
			$('#x_penjamin_kkl_id').hide();
			$('#x_penjamin_kkl_id').val('');
			$('#lbl_penjamin_kkl_id').hide();
			$('#lbl_LOKASILAKALANTAS').hide();
			$('#x_LOKASILAKALANTAS').hide();
		} else {
			$('#x_LOKASILAKALANTAS').removeAttr('disabled');
			$('#x_LOKASILAKALANTAS').focus();
			$('#x_LOKASILAKALANTAS').css('background-color', '#ffff00');
			$('#x_penjamin_kkl_id').show();
			$('#x_penjamin_kkl_id').val('');
			$('#lbl_penjamin_kkl_id').show();
			$('#lbl_LOKASILAKALANTAS').show();
			$('#x_LOKASILAKALANTAS').show();
		} 
	});
	$("#button_cek_peserta").click(function() {

	//alert('ok');
		var no_kartu = $('#x_NOKARTU').val();
		if (no_kartu==""){alert ("no kartu harus diisi"); return;}
		var tgl = $('#x_TANGGAL_SEP').val();
		if (tgl==""){alert ("Tanggal harus diisi"); return;}
		var tanggal = formatDate($("#x_TANGGAL_SEP").val());

	  	//alert($("#x_NOKARTU").val());
	  	//alert(tanggal);
//insert_kepesertaan_bpjs_vclaim.php
	   	//$.getJSON("vclaim_peserta_nobpjs.php", {nomor_kartu: $("#x_NOKARTU").val(),tglSEP : tanggal,noMR : $("#x_NOMR").val()},    

	   	$.getJSON("ws/insert_kepesertaan_bpjs_vclaim.php", {nomor_kartu: $("#x_NOKARTU").val(),tglSEP : tanggal,noMR : $("#x_NOMR").val()},
		function(result){

					//alert(JSON.stringify(result));
					let status = result.result.hasil.metaData.code;

					//alert(status);
					if(status==200)
					{
						alert(result.result.hasil.response.peserta.statusPeserta.keterangan);
						$("#x_PESERTANIK_SEP").val(result.result.hasil.response.peserta.nik);
						$("#x_PESERTATGLLAHIR").val(result.result.hasil.response.peserta.tglLahir);
						$("#x_PESERTANAMA_SEP").val(result.result.hasil.response.peserta.nama);
						var status_kartu = result.result.hasil.response.peserta.statusPeserta.keterangan;
						if (status_kartu!= 'AKTIF')
						{
							alert(status_kartu);
						}
						$("#x_PESERTAJENISKELAMIN_SEP").val(result.result.hasil.response.peserta.sex);
						$("#x_PESERTAPISAT").val(result.result.hasil.response.peserta.pisa);
						$("#x_status_kepesertaan_BPJS").val(result.result.hasil.response.peserta.statusPeserta.keterangan);
						$("#x_PESERTANAMAKELAS_SEP").val(result.result.hasil.response.peserta.hakKelas.keterangan);
						$("#x_KELASRAWAT_SEP").val(result.result.hasil.response.peserta.hakKelas.kode);
						$("#x_KDPPKRUJUKAN_SEP").val(result.result.hasil.response.peserta.provUmum.kdProvider);
						$("#x_NMPPKRUJUKAN_SEP").val(result.result.hasil.response.peserta.provUmum.nmProvider);
						$("#x_CATATAN_SEP").val(result.result.hasil.response.peserta.alamat_pasien);
						var tlp_simrs = result.result.hasil.response.peserta.telepon_pasien;
						var tlp_bpjs = result.result.hasil.response.peserta.mr.noTelepon;
						if (tlp_simrs.length < 10)
						{
							$("#x_pasien_NOTELP").val(tlp_bpjs);
						}else{
							$("#x_pasien_NOTELP").val(tlp_simrs);
						}
					}else
					{
						alert(result.result.hasil.metaData.message);
					}
				});             
		});
	$("#buttonParent").click(function() {
		var NO_SJP = $("#x_NO_SJP").val();
		var length_NO_SJP = NO_SJP.length;
		if (length_NO_SJP>0){alert ("SEP SUDAH TERBIT. TIDAK BISA MENCETAK SEP LAGI"); return;}
		var x_status_kepesertaan_BPJS = $('#x_status_kepesertaan_BPJS').val();
		if (x_status_kepesertaan_BPJS==""){alert ("Status Kepesertaan belum dicek"); return;}
		var no_kartu = $('#x_NOKARTU').val();
		if (no_kartu==""){alert ("No kartu harus diisi"); return;}
		var tgl = $('#x_TANGGAL_SEP').val();
		if (tgl==""){alert ("Tanggal harus diisi"); return;}
		var cob = $('#x_peserta_cob').val();
		var eksekutif = $('#x_poli_eksekutif').val();

		//alert("eksekutif : "+eksekutif);
		if (eksekutif==""){alert ("status poli eksekutif kosong"); return;}

		//alert("noKartu : "+$("#x_NOKARTU").val());
		var tanggal = $("#x_TANGGAL_SEP").val();
		if (tanggal==""){alert ("Tanggal SEP kosong"); return;}

		//alert("tglSep : "+tanggal)
		//alert("ppkPelayanan : "+$("#x_PPKPELAYANAN_SEP").val());

		var ppkPelayanan = $("#x_PPKPELAYANAN_SEP").val();
		if (ppkPelayanan==""){alert ("ppkPelayanan SEP kosong"); return;}

		//alert("jnsPelayanan : "+$("input[name=x_JENISPERAWATAN_SEP]:checked").val());
		var jnsPelayanan = $("input[name=x_JENISPERAWATAN_SEP]:checked").val();
		if (jnsPelayanan==""){alert ("jenis layananan kosong"); return;}

		//alert("klsRawat : "+$("#x_KELASRAWAT_SEP").val());
		var klsRawat = $("#x_KELASRAWAT_SEP").val();
		if (klsRawat==""){alert ("kelas rawat kosong"); return;}

		//alert("noMR : "+$("#x_NOMR").val());
		var noMR = $("#x_NOMR").val();
		if (noMR==""){alert ("noMR  kosong"); return;}

		//alert("asalRujukan : "+$("#x_KDPPKRUJUKAN_SEP").val());
		var asalRujukan = $("#x_KDPPKRUJUKAN_SEP").val();
		if (asalRujukan==""){alert ("asalRujukan  kosong"); return;}
		var asalfaskesrujukan = $("#x_asalfaskesrujukan_id").val();

		//alert("rujukankkejehbbhbehcece : "+asalfaskesrujukan);
		if (asalfaskesrujukan==""){alert ("asal faskes rujukan  kosong"); return;}
		var tanggal_rujukan = formatDate($("#x_TANGGALRUJUK_SEP").val());

		//alert("tglRujukan : "+tanggal_rujukan);
		if (tanggal_rujukan==""){alert ("tanggal_rujukan  kosong"); return;}

		//alert("noRujukan : "+$("#x_NORUJUKAN_SEP").val());
		var noRujukan = $("#x_NORUJUKAN_SEP").val();
		if (noRujukan==""){alert ("noRujukan  kosong"); return;}

		//alert("ppkRujukan : "+$("#x_KDPPKRUJUKAN_SEP").val());
		var ppkRujukan = $("#x_KDPPKRUJUKAN_SEP").val();
		if (ppkRujukan==""){alert ("ppkRujukan  kosong"); return;}

		//alert("catatan : "+$("#x_CATATAN_SEP").val());
		var catatan = $("#x_CATATAN_SEP").val();
		if (catatan==""){alert ("catatan  kosong"); return;}

		//alert("diagAwal : "+$("#x_DIAGNOSAAWAL_SEP").val());
		var diagAwal = $("#x_DIAGNOSAAWAL_SEP").val();
		if (diagAwal==""){alert ("diagAwal  kosong"); return;}

		//alert("tujuan : "+$("#x_POLITUJUAN_SEP").val());
		var tujuan = $("#x_POLITUJUAN_SEP").val();
		if (tujuan==""){alert ("tujuan  kosong"); return;}

		//alert("lakaLantas : "+$("input[name=x_LAKALANTAS_SEP]:checked").val());
		var lakaLantas = $("input[name=x_LAKALANTAS_SEP]:checked").val();
		if (lakaLantas==""){alert ("lakaLantas  kosong"); return;}
		/*alert("penjamin : "+$("#x_penjamin_kkl_id").val());
		var penjamin = $("#x_penjamin_kkl_id").val();
		if (penjamin==""){alert ("penjamin  kosong"); return;}*/

		//alert("eksekutif : "+$("#x_poli_eksekutif").val());
		var eksekutif = $("#x_poli_eksekutif").val();
		if (eksekutif==""){alert ("x_poli_eksekutif  kosong"); return;}

		//alert("lokasiLaka : "+$("input[name=x_LAKALANTAS_SEP]:checked").val());
		//alert("noTelp : "+$("#x_pasien_NOTELP").val());

		var noTelp = $("#x_pasien_NOTELP").val();
		var length_tlp = noTelp.length;

		//alert("length tlp : "+noTelp);
		if (noTelp==""){alert ("noTelp  kosong"); return;}
		if (length_tlp<10){alert ("digit nomer telepon kurang"); return;}

		//alert("user : "+$("#x_USER").val());
		var user = $("#x_USER").val();
		if (user==""){alert ("user  kosong"); return;}

		//alert($("#x_NMPPKRUJUKAN_SEP").val());
		//$.getJSON("insert_sep_vclaim_rajal.php",

		$.getJSON("ws/insert_sep_vclaim.php",   
		 { noKartu: $("#x_NOKARTU").val(), 
		   tglSep: $("#x_TANGGAL_SEP").val(),
		   ppkPelayanan: $("#x_PPKPELAYANAN_SEP").val(),
		   jnsPelayanan: $("input[name=x_JENISPERAWATAN_SEP]:checked").val(),
		   klsRawat: $("#x_KELASRAWAT_SEP").val(),
		   noMR: $("#x_NOMR").val(),
		   asalRujukan: $("#x_asalfaskesrujukan_id").val(),
		   tglRujukan: formatDate($("#x_TANGGALRUJUK_SEP").val()),
		   noRujukan: $("#x_NORUJUKAN_SEP").val(),
		   ppkRujukan: $("#x_KDPPKRUJUKAN_SEP").val(),
		   catatan: $("#x_CATATAN_SEP").val(), 
		   diagAwal: $("#x_DIAGNOSAAWAL_SEP").val(),
		   tujuan: $("#x_POLITUJUAN_SEP").val(),
		   eksekutif: $("#x_poli_eksekutif").val(),
		   cob: $("#x_peserta_cob").val(),
		   lakaLantas: $("input[name=x_LAKALANTAS_SEP]:checked").val(),
		   penjamin: $("#x_penjamin_kkl_id").val(),
		   lokasiLaka: $("#x_LOKASILAKALANTAS").val(), 
		   noTelp: $("#x_pasien_NOTELP").val(),
		   user: $("#x_USER").val(),
		   idx:$("#x_IDXDAFTAR").val(),
		   nik:$("#x_PESERTANIK_SEP").val(),
		   status_kartu:$("#x_status_kepesertaan_BPJS").val(),
		   nama_ppk:$("#x_NMPPKRUJUKAN_SEP").val()
		 },  
		function(result){                                   

		//	alert(JSON.stringify(result));
			let status = result.result.metaData.code;

			//alert(status);
			if(status==200){
				alert(result.result.response.sep.noSep);
				$("#x_NO_SJP").val(result.result.response.sep.noSep);

				//$("#x_CATATAN_SEP").val(result.result.sql);
			}else{
				alert(result.result.metaData.message);
			}
		});
		});
});  
</script>
<?php if (!$vw_bridging_sep_by_no_kartu_edit->IsModal) { ?>
<?php } ?>
<?php $vw_bridging_sep_by_no_kartu_edit->ShowPageHeader(); ?>
<?php
$vw_bridging_sep_by_no_kartu_edit->ShowMessage();
?>
<form name="fvw_bridging_sep_by_no_kartuedit" id="fvw_bridging_sep_by_no_kartuedit" class="<?php echo $vw_bridging_sep_by_no_kartu_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bridging_sep_by_no_kartu_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bridging_sep_by_no_kartu_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bridging_sep_by_no_kartu">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_bridging_sep_by_no_kartu_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_vw_bridging_sep_by_no_kartuedit" class="ewCustomTemplate"></div>
<script id="tpm_vw_bridging_sep_by_no_kartuedit" type="text/html">
<div id="ct_vw_bridging_sep_by_no_kartu_edit"><section class="content">
	<div class="row">
		<!-- -->
		<!--- -------------------------------------  detail -->
		<div id="divDetail">
			<div class="col-md-3">
				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body box-profile">
						<input type="hidden" id="txtkelamin" />
						<input type="hidden" id="txtkdstatuspst" />
							<?php
								$a = "L";
								if($a =="L"){
								?>
								 <img class="profile-user-img img-responsive img-circle" src="uploads/male.png" alt="User profile picture" id="imgMale"> 
								<?php
								}elseif($a =="P")
								{
								?>
									 <img class="profile-user-img img-responsive img-circle" src="uploads/female.png" alt="User profile picture" id="imgFemale"> 
								<?php
								}
							?>
						<h3 class="profile-username text-center" id="lblnama"><?php echo $vw_bridging_sep_by_no_kartu->NOMR->FldCaption() ?>:{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_NOMR"/}}</h3>
						<p class="text-muted text-center" id="lblnoka"><?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->FldCaption() ?>:{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_NOKARTU"/}}</p>
						<!-- <p class="text-muted text-center" id="lblnoka"><?php echo $vw_bridging_sep_by_no_kartu->bridging_kepesertaan_by_no_ka->FldCaption() ?>{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_bridging_kepesertaan_by_no_ka"/}}</p> -->
						<input type="button"  class="btn bg-maroon btn-flat margin" value="Validasi Peserta" id="button_cek_peserta">
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
				<!-- About Me Box -->
				<div class="box box-default">
					<!-- /.box-header -->
					<div class="box-body">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a title="Profile Peserta" href="#tab_1" data-toggle="tab"><span class="fa fa-user"></span></a></li>
								<li><a href="#tab_2" title="COB" data-toggle="tab"><span class="fa fa-building"></span></a></li>
								<li><a href="#tab_3" title="Histori" data-toggle="tab" id="tabHistori"><span class="fa fa-list"></span></a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1">
									<ul class="list-group list-group-unbordered">
										<li class="list-group-item">
											<span class="fa fa-sort-numeric-asc"></span><a title="NIK" class="pull-right-container" id="lblnik">{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP"/}} <?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->FldCaption() ?></a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-sort-numeric-asc"></span><a title="Nama Peserta" class="pull-right-container" id="lblnamapeserta"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-calendar"></span> <a title="Tanggal Lahir" class="pull-right-container" id="lbltgllahir"><?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-hospital-o"></span> <a title="Hak Kelas Rawat" class="pull-right-container" id="lblhakkelas"><?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-hospital-o"></span> <a title="Nama Hak Kelas Rawat" class="pull-right-container" id="lblnama hakkelas"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-stethoscope"></span>  <a title="Faskes Tingkat 1" class="pull-right-container" id="lblfktp"><?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP"/}}</a>	
										</li>
										<li class="list-group-item">
											<span class="fa fa-stethoscope"></span>  <a title="Nama Faskes Tingkat 1" class="pull-right-container" id="lblnamafktp"><?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP"/}}</a>	
										</li>
									<!-- 	<li class="list-group-item">
											<span class="fa fa-calendar"></span>  <a title="TMT dan TAT Peserta" class="pull-right-container" id="lbltmt_tat">tmt/tat</a>
											<input id="txttmtpst" type="hidden" />
										</li>
										<li class="list-group-item">
											<span class="fa fa-calendar"></span>  <a title="Jenis Peserta" class="pull-right-container" id="lblpeserta">Peserta</a>
											<input type="hidden" id="txtjnspst" />
										</li> -->
										<li class="list-group-item">
											<span class="fa fa-calendar"></span>  <a title="Jenis Peserta" class="pull-right-container" id="lblpeserta"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-calendar"></span>  <a title="Jenis Peserta" class="pull-right-container" id="lblpeserta"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_PESERTAPISAT"/}}</a>
										</li>
									</ul>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" id="tab_2">
									<ul class="list-group list-group-unbordered">
										<!-- <li class="list-group-item">
											<span class="fa fa-sort-numeric-asc"></span> <a title="No. Asuransi" class="pull-right-container" id="lblnoasu">Asuransi</a>
											<input type="hidden" id="txtkdasu" />
										</li>
										<li class="list-group-item">
											<span class="fa fa-windows"></span> <a title="Nama Asuransi" class="pull-right-container" id="lblnmasu">Nama Asuransi</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-calendar"></span> <a title="TMT dan TAT Asuransi" class="pull-right-container" id="lbltmt_tatasu">TMT/TAT</a>
											<input type="hidden" id="txttmtasu" />
											<input type="hidden" id="txttatasu" />
										</li>
										<li class="list-group-item">
											<span class="fa fa-bank"></span> <a title="Nama Badan Usaha" class="pull-right-container" id="lblnamabu">Nama BU</a>
											<input type="hidden" id="txtkdbu" />
										</li> -->
										<li class="list-group-item">
											<span class="fa fa-bank"></span> <a title="Nama Poli" class="pull-right-container" id="lblnamapoli"><?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-bank"></span> <a title="Nama Diagnosa" class="pull-right-container" id="lblnamadiagnosa"><?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->FldCaption() ?>   {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP"/}}</a>
										</li>
									</ul>
								</div>
								<div class="tab-pane" id="tab_3">
									<div id="divHistori" class="list-group">
									</div>
								</div>
							</div>
							<!-- /.tab-content -->
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- form sep -->
			<div class="col-md-9">
				<!-- <div class="alert alert-danger alert-dismissible" id="divInformasi">
					<h4><i class="icon fa fa-ban"></i> PERHATIAN!</h4>
					<p id="pProlanis"></p>
					<p id="pDinsos"></p>
					<input type="hidden" id="txtdinsos" />
				</div> -->
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title"><label class="pull-right" style="font-size:larger" id="lblnosep"></label> </h3> 
						<label class="pull-right" style="font-size:larger" id="lbljenpel"></label>
						<input type="hidden" id="txtjenpel" />
					</div>
					<form class="form-horizontal">
						<input type="hidden" id="txtprsklaimsep" />
						<div class="box-body">
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS"/}} 
									</div>
								</div>
							<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP"/}} 
									</div>
							</div>
							<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->USER->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_USER"/}} 
									</div>
							</div>
							<div id="divRujukan">
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->FldCaption() ?></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id"/}}
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><label style="color:gray;font-size:x-small"></label> <?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->FldCaption() ?></label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<div class='input-group date'>
											{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP"/}}
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP"/}}
									</div>
								</div>
							</div>
							<!-- end rujukan -->
							<div class="clearfix"></div>
							<!-- sep -->
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><label style="color:gray;font-size:x-small"></label> <?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->FldCaption() ?></label>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<div class='input-group date'>
										{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_TANGGAL_SEP"/}}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="input-group">
										 {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP"/}}
										<span class="input-group-addon">
										</span>
									</div>
								</div>
							</div>
								<div class="form-group" id="divPoli">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">                                        
										<span class="input-group-addon">
										</span>
										{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP"/}}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_poli_eksekutif"/}}
								</div>
							</div> 
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_peserta_cob"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_pasien_NOTELP"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_CATATAN_SEP"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP"/}}
								</div>
							</div>
							<div class="form-group">
								<label  id="lbl_LOKASILAKALANTAS" class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS"/}}
								</div>
							</div>
							<div class="form-group">
								<label id="lbl_penjamin_kkl_id" class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_penjamin_kkl_id"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
											<!--<?php echo $vw_bridging_sep_by_no_kartu->generate_sep->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_generate_sep"/}}  -->
									<input type="button" class="btn bg-olive btn-flat margin" value="Buat Nomer SEP" id="buttonParent">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_kartu_NO_SJP"/}}
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- end detail -->
	</div>
</section>
</div>
</script>
<div style="display: none">
<?php if ($vw_bridging_sep_by_no_kartu->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<div id="r_IDXDAFTAR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->CellAttributes() ?>>
<div id="orig_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="hide">
<span id="el_vw_bridging_sep_by_no_kartu_IDXDAFTAR">
<span<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->EditValue ?></p></span>
</span>
</div>
<script id="tpx_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="cvt_vw_bridging_sep_by_no_kartu_IDXDAFTAR"><div class="btn-group">
	<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>   Menu</button>
		<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul style="background:#605CA8" class="dropdown-menu" role="menu" >
			<li class="divider"></li>
			<li><a style="color:#ffffff" target="_self" href="vw_bridging_sep_by_no_kartuedit.php?IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) ?>"><b>-  </b><b> Pembuatan Nomer SEP </b></a></li>
			<!-- <li><a style="color:#ffffff" target="_blank" href="cetak_sep_rajal.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) ?>&&no=<?php echo urlencode(CurrentPage()->NO_SJP->CurrentValue) ?>" onclick="return confirm('Klik OK. untuk Memulai proses Brigding  Cetak  SEP.......,?')"><b>-  </b><b> Cetak SEP</b></a></li> -->
			<li><a style="color:#ffffff" target="_blank" href="cetak_vclaim_sep_rajal.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) ?>&&no=<?php echo urlencode(CurrentPage()->NO_SJP->CurrentValue) ?>" onclick="return confirm('Klik OK. untuk Memulai proses Brigding  Cetak  SEP.......,?')"><b>-  </b><b> Cetak SEP VCLAIM</b></a></li>
			<li class="divider"></li>
		</ul>
</div>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_IDXDAFTAR" name="x_IDXDAFTAR" id="x_IDXDAFTAR" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->IDXDAFTAR->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NOMR" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NOMR" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NOMR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NOMR->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NOMR" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NOMR">
<span<?php echo $vw_bridging_sep_by_no_kartu->NOMR->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_kartu->NOMR->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NOMR" name="x_NOMR" id="x_NOMR" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NOMR->CurrentValue) ?>">
<script type="text/html" class="vw_bridging_sep_by_no_kartuedit_js">
fvw_bridging_sep_by_no_kartuedit.CreateAutoSuggest({"id":"x_NOMR","forceSelect":false});
</script>
<?php echo $vw_bridging_sep_by_no_kartu->NOMR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDPOLY->Visible) { // KDPOLY ?>
	<div id="r_KDPOLY" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KDPOLY" for="x_KDPOLY" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_KDPOLY" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_KDPOLY" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_KDPOLY">
<span<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_KDPOLY" name="x_KDPOLY" id="x_KDPOLY" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->KDPOLY->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<div id="r_KDCARABAYAR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KDCARABAYAR" for="x_KDCARABAYAR" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_KDCARABAYAR" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_KDCARABAYAR" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_KDCARABAYAR">
<span<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_KDCARABAYAR" name="x_KDCARABAYAR" id="x_KDCARABAYAR" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->KDCARABAYAR->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NIP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NIP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NIP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NIP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NIP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NIP->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_kartu->NIP->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NIP" name="x_NIP" id="x_NIP" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NIP->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_kartu->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TGLREG->Visible) { // TGLREG ?>
	<div id="r_TGLREG" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_TGLREG" for="x_TGLREG" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_TGLREG" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->TGLREG->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_TGLREG" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_TGLREG">
<span<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_kartu->TGLREG->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_TGLREG" name="x_TGLREG" id="x_TGLREG" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->TGLREG->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->JAMREG->Visible) { // JAMREG ?>
	<div id="r_JAMREG" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_JAMREG" for="x_JAMREG" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_JAMREG" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->JAMREG->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_JAMREG" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_JAMREG">
<span<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_kartu->JAMREG->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_kartu" data-field="x_JAMREG" name="x_JAMREG" id="x_JAMREG" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->JAMREG->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NO_SJP->Visible) { // NO_SJP ?>
	<div id="r_NO_SJP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NO_SJP" for="x_NO_SJP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NO_SJP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NO_SJP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NO_SJP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NO_SJP" name="x_NO_SJP" id="x_NO_SJP" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NO_SJP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NOKARTU->Visible) { // NOKARTU ?>
	<div id="r_NOKARTU" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NOKARTU" for="x_NOKARTU" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NOKARTU" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NOKARTU" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NOKARTU">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NOKARTU" name="x_NOKARTU" id="x_NOKARTU" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NOKARTU->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->Visible) { // TANGGAL_SEP ?>
	<div id="r_TANGGAL_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_TANGGAL_SEP" for="x_TANGGAL_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_TANGGAL_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_TANGGAL_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_TANGGAL_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_TANGGAL_SEP" data-format="5" name="x_TANGGAL_SEP" id="x_TANGGAL_SEP" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditAttributes() ?>>
<?php if (!$vw_bridging_sep_by_no_kartu->TANGGAL_SEP->ReadOnly && !$vw_bridging_sep_by_no_kartu->TANGGAL_SEP->Disabled && !isset($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditAttrs["readonly"]) && !isset($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="vw_bridging_sep_by_no_kartuedit_js">
ew_CreateCalendar("fvw_bridging_sep_by_no_kartuedit", "x_TANGGAL_SEP", 5);
</script>
<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->Visible) { // TANGGALRUJUK_SEP ?>
	<div id="r_TANGGALRUJUK_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP" for="x_TANGGALRUJUK_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_TANGGALRUJUK_SEP" data-format="5" name="x_TANGGALRUJUK_SEP" id="x_TANGGALRUJUK_SEP" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditAttributes() ?>>
<?php if (!$vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->ReadOnly && !$vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->Disabled && !isset($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditAttrs["readonly"]) && !isset($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="vw_bridging_sep_by_no_kartuedit_js">
ew_CreateCalendar("fvw_bridging_sep_by_no_kartuedit", "x_TANGGALRUJUK_SEP", 5);
</script>
<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->Visible) { // KELASRAWAT_SEP ?>
	<div id="r_KELASRAWAT_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP" for="x_KELASRAWAT_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_KELASRAWAT_SEP" name="x_KELASRAWAT_SEP" id="x_KELASRAWAT_SEP" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->Visible) { // NORUJUKAN_SEP ?>
	<div id="r_NORUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP" for="x_NORUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NORUJUKAN_SEP" name="x_NORUJUKAN_SEP" id="x_NORUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->Visible) { // PPKPELAYANAN_SEP ?>
	<div id="r_PPKPELAYANAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP" for="x_PPKPELAYANAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PPKPELAYANAN_SEP" name="x_PPKPELAYANAN_SEP" id="x_PPKPELAYANAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->Visible) { // JENISPERAWATAN_SEP ?>
	<div id="r_JENISPERAWATAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP">
<div id="tp_x_JENISPERAWATAN_SEP" class="ewTemplate"><input type="radio" data-table="vw_bridging_sep_by_no_kartu" data-field="x_JENISPERAWATAN_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->DisplayValueSeparatorAttribute() ?>" name="x_JENISPERAWATAN_SEP" id="x_JENISPERAWATAN_SEP" value="{value}"<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->EditAttributes() ?>></div>
<div id="dsl_x_JENISPERAWATAN_SEP" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->RadioButtonListHtml(FALSE, "x_JENISPERAWATAN_SEP") ?>
</div></div>
<input type="hidden" name="s_x_JENISPERAWATAN_SEP" id="s_x_JENISPERAWATAN_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->CATATAN_SEP->Visible) { // CATATAN_SEP ?>
	<div id="r_CATATAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_CATATAN_SEP" for="x_CATATAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_CATATAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_CATATAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_CATATAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_CATATAN_SEP" name="x_CATATAN_SEP" id="x_CATATAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->CATATAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->Visible) { // DIAGNOSAAWAL_SEP ?>
	<div id="r_DIAGNOSAAWAL_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
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
<input type="hidden" name="ln_x_DIAGNOSAAWAL_SEP" id="ln_x_DIAGNOSAAWAL_SEP" value="x_NAMADIAGNOSA_SEP">
</span>
</script>
<script type="text/html" class="vw_bridging_sep_by_no_kartuedit_js">
fvw_bridging_sep_by_no_kartuedit.CreateAutoSuggest({"id":"x_DIAGNOSAAWAL_SEP","forceSelect":true});
</script>
<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->Visible) { // NAMADIAGNOSA_SEP ?>
	<div id="r_NAMADIAGNOSA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP" for="x_NAMADIAGNOSA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NAMADIAGNOSA_SEP" name="x_NAMADIAGNOSA_SEP" id="x_NAMADIAGNOSA_SEP" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->Visible) { // LAKALANTAS_SEP ?>
	<div id="r_LAKALANTAS_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP">
<div id="tp_x_LAKALANTAS_SEP" class="ewTemplate"><input type="radio" data-table="vw_bridging_sep_by_no_kartu" data-field="x_LAKALANTAS_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->DisplayValueSeparatorAttribute() ?>" name="x_LAKALANTAS_SEP" id="x_LAKALANTAS_SEP" value="{value}"<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->EditAttributes() ?>></div>
<div id="dsl_x_LAKALANTAS_SEP" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->RadioButtonListHtml(FALSE, "x_LAKALANTAS_SEP") ?>
</div></div>
<input type="hidden" name="s_x_LAKALANTAS_SEP" id="s_x_LAKALANTAS_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->Visible) { // LOKASILAKALANTAS ?>
	<div id="r_LOKASILAKALANTAS" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS" for="x_LOKASILAKALANTAS" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_LOKASILAKALANTAS" name="x_LOKASILAKALANTAS" id="x_LOKASILAKALANTAS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->USER->Visible) { // USER ?>
	<div id="r_USER" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_USER" for="x_USER" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_USER" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->USER->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->USER->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_USER" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_USER">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_USER" name="x_USER" id="x_USER" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->USER->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->USER->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->USER->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->USER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->Visible) { // PESERTANIK_SEP ?>
	<div id="r_PESERTANIK_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP" for="x_PESERTANIK_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANIK_SEP" name="x_PESERTANIK_SEP" id="x_PESERTANIK_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->Visible) { // PESERTANAMA_SEP ?>
	<div id="r_PESERTANAMA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP" for="x_PESERTANAMA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANAMA_SEP" name="x_PESERTANAMA_SEP" id="x_PESERTANAMA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->Visible) { // PESERTAJENISKELAMIN_SEP ?>
	<div id="r_PESERTAJENISKELAMIN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP" for="x_PESERTAJENISKELAMIN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTAJENISKELAMIN_SEP" name="x_PESERTAJENISKELAMIN_SEP" id="x_PESERTAJENISKELAMIN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->Visible) { // PESERTANAMAKELAS_SEP ?>
	<div id="r_PESERTANAMAKELAS_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP" for="x_PESERTANAMAKELAS_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANAMAKELAS_SEP" name="x_PESERTANAMAKELAS_SEP" id="x_PESERTANAMAKELAS_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAPISAT->Visible) { // PESERTAPISAT ?>
	<div id="r_PESERTAPISAT" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTAPISAT" for="x_PESERTAPISAT" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTAPISAT" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTAPISAT" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAPISAT">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTAPISAT" name="x_PESERTAPISAT" id="x_PESERTAPISAT" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTAPISAT->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->Visible) { // PESERTATGLLAHIR ?>
	<div id="r_PESERTATGLLAHIR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR" for="x_PESERTATGLLAHIR" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTATGLLAHIR" name="x_PESERTATGLLAHIR" id="x_PESERTATGLLAHIR" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->Visible) { // PESERTAJENISPESERTA_SEP ?>
	<div id="r_PESERTAJENISPESERTA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP" for="x_PESERTAJENISPESERTA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTAJENISPESERTA_SEP" name="x_PESERTAJENISPESERTA_SEP" id="x_PESERTAJENISPESERTA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->Visible) { // PESERTANAMAJENISPESERTA_SEP ?>
	<div id="r_PESERTANAMAJENISPESERTA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP" for="x_PESERTANAMAJENISPESERTA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_PESERTANAMAJENISPESERTA_SEP" name="x_PESERTANAMAJENISPESERTA_SEP" id="x_PESERTANAMAJENISPESERTA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->Visible) { // POLITUJUAN_SEP ?>
	<div id="r_POLITUJUAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP" for="x_POLITUJUAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP">
<?php $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->EditAttrs["onchange"]; ?>
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_POLITUJUAN_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->DisplayValueSeparatorAttribute() ?>" id="x_POLITUJUAN_SEP" name="x_POLITUJUAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->SelectOptionListHtml("x_POLITUJUAN_SEP") ?>
</select>
<input type="hidden" name="s_x_POLITUJUAN_SEP" id="s_x_POLITUJUAN_SEP" value="<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_POLITUJUAN_SEP" id="ln_x_POLITUJUAN_SEP" value="x_NAMAPOLITUJUAN_SEP">
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->Visible) { // NAMAPOLITUJUAN_SEP ?>
	<div id="r_NAMAPOLITUJUAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP" for="x_NAMAPOLITUJUAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NAMAPOLITUJUAN_SEP" name="x_NAMAPOLITUJUAN_SEP" id="x_NAMAPOLITUJUAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->Visible) { // KDPPKRUJUKAN_SEP ?>
	<div id="r_KDPPKRUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP" for="x_KDPPKRUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_KDPPKRUJUKAN_SEP" name="x_KDPPKRUJUKAN_SEP" id="x_KDPPKRUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->Visible) { // NMPPKRUJUKAN_SEP ?>
	<div id="r_NMPPKRUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP" for="x_NMPPKRUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_NMPPKRUJUKAN_SEP" name="x_NMPPKRUJUKAN_SEP" id="x_NMPPKRUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->pasien_NOTELP->Visible) { // pasien_NOTELP ?>
	<div id="r_pasien_NOTELP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_pasien_NOTELP" for="x_pasien_NOTELP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_pasien_NOTELP" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_pasien_NOTELP" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_pasien_NOTELP">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_pasien_NOTELP" name="x_pasien_NOTELP" id="x_pasien_NOTELP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->pasien_NOTELP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->penjamin_kkl_id->Visible) { // penjamin_kkl_id ?>
	<div id="r_penjamin_kkl_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_penjamin_kkl_id" for="x_penjamin_kkl_id" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_penjamin_kkl_id" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_penjamin_kkl_id" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_penjamin_kkl_id">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_penjamin_kkl_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->DisplayValueSeparatorAttribute() ?>" id="x_penjamin_kkl_id" name="x_penjamin_kkl_id"<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->SelectOptionListHtml("x_penjamin_kkl_id") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->Visible) { // asalfaskesrujukan_id ?>
	<div id="r_asalfaskesrujukan_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id" for="x_asalfaskesrujukan_id" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_asalfaskesrujukan_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->DisplayValueSeparatorAttribute() ?>" id="x_asalfaskesrujukan_id" name="x_asalfaskesrujukan_id"<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->SelectOptionListHtml("x_asalfaskesrujukan_id") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->peserta_cob->Visible) { // peserta_cob ?>
	<div id="r_peserta_cob" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_peserta_cob" for="x_peserta_cob" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_peserta_cob" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_peserta_cob" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_peserta_cob">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_peserta_cob" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->DisplayValueSeparatorAttribute() ?>" id="x_peserta_cob" name="x_peserta_cob"<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->SelectOptionListHtml("x_peserta_cob") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<div id="r_poli_eksekutif" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_poli_eksekutif" for="x_poli_eksekutif" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_poli_eksekutif" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_poli_eksekutif" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_poli_eksekutif">
<select data-table="vw_bridging_sep_by_no_kartu" data-field="x_poli_eksekutif" data-value-separator="<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->DisplayValueSeparatorAttribute() ?>" id="x_poli_eksekutif" name="x_poli_eksekutif"<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->SelectOptionListHtml("x_poli_eksekutif") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->Visible) { // status_kepesertaan_BPJS ?>
	<div id="r_status_kepesertaan_BPJS" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS" for="x_status_kepesertaan_BPJS" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS" class="vw_bridging_sep_by_no_kartuedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS" class="vw_bridging_sep_by_no_kartuedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS">
<input type="text" data-table="vw_bridging_sep_by_no_kartu" data-field="x_status_kepesertaan_BPJS" name="x_status_kepesertaan_BPJS" id="x_status_kepesertaan_BPJS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->EditValue ?>"<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_bridging_sep_by_no_kartu_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bridging_sep_by_no_kartu_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_vw_bridging_sep_by_no_kartuedit", "tpm_vw_bridging_sep_by_no_kartuedit", "vw_bridging_sep_by_no_kartuedit", "<?php echo $vw_bridging_sep_by_no_kartu->CustomExport ?>");
jQuery("script.vw_bridging_sep_by_no_kartuedit_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
fvw_bridging_sep_by_no_kartuedit.Init();
</script>
<?php
$vw_bridging_sep_by_no_kartu_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bridging_sep_by_no_kartu_edit->Page_Terminate();
?>
