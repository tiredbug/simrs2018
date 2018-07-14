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

$vw_bridging_sep_by_no_rujukan_edit = NULL; // Initialize page object first

class cvw_bridging_sep_by_no_rujukan_edit extends cvw_bridging_sep_by_no_rujukan {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bridging_sep_by_no_rujukan';

	// Page object name
	var $PageObjName = 'vw_bridging_sep_by_no_rujukan_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		global $EW_EXPORT, $vw_bridging_sep_by_no_rujukan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
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
			$this->Page_Terminate("vw_bridging_sep_by_no_rujukanlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_bridging_sep_by_no_rujukanlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_bridging_sep_by_no_rujukanlist.php")
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
		if (!$this->NOMR->FldIsDetailKey) {
			$this->NOMR->setFormValue($objForm->GetValue("x_NOMR"));
		}
		if (!$this->KDPOLY->FldIsDetailKey) {
			$this->KDPOLY->setFormValue($objForm->GetValue("x_KDPOLY"));
		}
		if (!$this->TGLREG->FldIsDetailKey) {
			$this->TGLREG->setFormValue($objForm->GetValue("x_TGLREG"));
			$this->TGLREG->CurrentValue = ew_UnFormatDateTime($this->TGLREG->CurrentValue, 0);
		}
		if (!$this->KDCARABAYAR->FldIsDetailKey) {
			$this->KDCARABAYAR->setFormValue($objForm->GetValue("x_KDCARABAYAR"));
		}
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
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
		if (!$this->generate_sep->FldIsDetailKey) {
			$this->generate_sep->setFormValue($objForm->GetValue("x_generate_sep"));
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
		if (!$this->mapingtransaksi->FldIsDetailKey) {
			$this->mapingtransaksi->setFormValue($objForm->GetValue("x_mapingtransaksi"));
		}
		if (!$this->bridging_by_no_rujukan->FldIsDetailKey) {
			$this->bridging_by_no_rujukan->setFormValue($objForm->GetValue("x_bridging_by_no_rujukan"));
		}
		if (!$this->bridging_rujukan_faskes_2->FldIsDetailKey) {
			$this->bridging_rujukan_faskes_2->setFormValue($objForm->GetValue("x_bridging_rujukan_faskes_2"));
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
		if (!$this->IDXDAFTAR->FldIsDetailKey)
			$this->IDXDAFTAR->setFormValue($objForm->GetValue("x_IDXDAFTAR"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->IDXDAFTAR->CurrentValue = $this->IDXDAFTAR->FormValue;
		$this->NOMR->CurrentValue = $this->NOMR->FormValue;
		$this->KDPOLY->CurrentValue = $this->KDPOLY->FormValue;
		$this->TGLREG->CurrentValue = $this->TGLREG->FormValue;
		$this->TGLREG->CurrentValue = ew_UnFormatDateTime($this->TGLREG->CurrentValue, 0);
		$this->KDCARABAYAR->CurrentValue = $this->KDCARABAYAR->FormValue;
		$this->NIP->CurrentValue = $this->NIP->FormValue;
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
		$this->generate_sep->CurrentValue = $this->generate_sep->FormValue;
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
		$this->mapingtransaksi->CurrentValue = $this->mapingtransaksi->FormValue;
		$this->bridging_by_no_rujukan->CurrentValue = $this->bridging_by_no_rujukan->FormValue;
		$this->bridging_rujukan_faskes_2->CurrentValue = $this->bridging_rujukan_faskes_2->FormValue;
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
		$this->KDPOLY->ViewValue = $this->KDPOLY->CurrentValue;
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

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
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

		// generate_sep
		if (strval($this->generate_sep->CurrentValue) <> "") {
			$this->generate_sep->ViewValue = "";
			$arwrk = explode(",", strval($this->generate_sep->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->generate_sep->ViewValue .= $this->generate_sep->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->generate_sep->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->generate_sep->ViewValue = NULL;
		}
		$this->generate_sep->ViewCustomAttributes = "";

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
		$this->POLITUJUAN_SEP->ViewValue = $this->POLITUJUAN_SEP->CurrentValue;
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

		// mapingtransaksi
		if (strval($this->mapingtransaksi->CurrentValue) <> "") {
			$this->mapingtransaksi->ViewValue = "";
			$arwrk = explode(",", strval($this->mapingtransaksi->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->mapingtransaksi->ViewValue .= $this->mapingtransaksi->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->mapingtransaksi->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->mapingtransaksi->ViewValue = NULL;
		}
		$this->mapingtransaksi->ViewCustomAttributes = "";

		// bridging_by_no_rujukan
		if (strval($this->bridging_by_no_rujukan->CurrentValue) <> "") {
			$this->bridging_by_no_rujukan->ViewValue = "";
			$arwrk = explode(",", strval($this->bridging_by_no_rujukan->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->bridging_by_no_rujukan->ViewValue .= $this->bridging_by_no_rujukan->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->bridging_by_no_rujukan->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->bridging_by_no_rujukan->ViewValue = NULL;
		}
		$this->bridging_by_no_rujukan->ViewCustomAttributes = "";

		// bridging_rujukan_faskes_2
		if (strval($this->bridging_rujukan_faskes_2->CurrentValue) <> "") {
			$this->bridging_rujukan_faskes_2->ViewValue = "";
			$arwrk = explode(",", strval($this->bridging_rujukan_faskes_2->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->bridging_rujukan_faskes_2->ViewValue .= $this->bridging_rujukan_faskes_2->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->bridging_rujukan_faskes_2->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->bridging_rujukan_faskes_2->ViewValue = NULL;
		}
		$this->bridging_rujukan_faskes_2->ViewCustomAttributes = "";

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

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

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

			// generate_sep
			$this->generate_sep->LinkCustomAttributes = "";
			$this->generate_sep->HrefValue = "";
			$this->generate_sep->TooltipValue = "";

			// PESERTANIK_SEP
			$this->PESERTANIK_SEP->LinkCustomAttributes = "";
			$this->PESERTANIK_SEP->HrefValue = "";
			$this->PESERTANIK_SEP->TooltipValue = "";

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

			// mapingtransaksi
			$this->mapingtransaksi->LinkCustomAttributes = "";
			$this->mapingtransaksi->HrefValue = "";
			$this->mapingtransaksi->TooltipValue = "";

			// bridging_by_no_rujukan
			$this->bridging_by_no_rujukan->LinkCustomAttributes = "";
			$this->bridging_by_no_rujukan->HrefValue = "";
			$this->bridging_by_no_rujukan->TooltipValue = "";

			// bridging_rujukan_faskes_2
			$this->bridging_rujukan_faskes_2->LinkCustomAttributes = "";
			$this->bridging_rujukan_faskes_2->HrefValue = "";
			$this->bridging_rujukan_faskes_2->TooltipValue = "";

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
			$this->KDPOLY->EditValue = $this->KDPOLY->CurrentValue;
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

			// TGLREG
			$this->TGLREG->EditAttrs["class"] = "form-control";
			$this->TGLREG->EditCustomAttributes = "";
			$this->TGLREG->EditValue = $this->TGLREG->CurrentValue;
			$this->TGLREG->EditValue = ew_FormatDateTime($this->TGLREG->EditValue, 0);
			$this->TGLREG->ViewCustomAttributes = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
			$this->KDCARABAYAR->EditCustomAttributes = "";
			$this->KDCARABAYAR->EditValue = $this->KDCARABAYAR->CurrentValue;
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
			$this->JENISPERAWATAN_SEP->EditAttrs["class"] = "form-control";
			$this->JENISPERAWATAN_SEP->EditCustomAttributes = "";
			if (trim(strval($this->JENISPERAWATAN_SEP->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`jeniskeperawatan_id`" . ew_SearchString("=", $this->JENISPERAWATAN_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `jeniskeperawatan_id`, `jeniskeperawatan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jeniskeperawatan`";
			$sWhereWrk = "";
			$this->JENISPERAWATAN_SEP->LookupFilters = array();
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

			// generate_sep
			$this->generate_sep->EditCustomAttributes = "";
			$this->generate_sep->EditValue = $this->generate_sep->Options(FALSE);

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
			$this->POLITUJUAN_SEP->EditValue = ew_HtmlEncode($this->POLITUJUAN_SEP->CurrentValue);
			$this->POLITUJUAN_SEP->PlaceHolder = ew_RemoveHtml($this->POLITUJUAN_SEP->FldCaption());

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

			// mapingtransaksi
			$this->mapingtransaksi->EditCustomAttributes = "";
			$this->mapingtransaksi->EditValue = $this->mapingtransaksi->Options(FALSE);

			// bridging_by_no_rujukan
			$this->bridging_by_no_rujukan->EditCustomAttributes = "";
			$this->bridging_by_no_rujukan->EditValue = $this->bridging_by_no_rujukan->Options(FALSE);

			// bridging_rujukan_faskes_2
			$this->bridging_rujukan_faskes_2->EditCustomAttributes = "";
			$this->bridging_rujukan_faskes_2->EditValue = $this->bridging_rujukan_faskes_2->Options(FALSE);

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
			// NOMR

			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

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

			// generate_sep
			$this->generate_sep->LinkCustomAttributes = "";
			$this->generate_sep->HrefValue = "";

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

			// mapingtransaksi
			$this->mapingtransaksi->LinkCustomAttributes = "";
			$this->mapingtransaksi->HrefValue = "";

			// bridging_by_no_rujukan
			$this->bridging_by_no_rujukan->LinkCustomAttributes = "";
			$this->bridging_by_no_rujukan->HrefValue = "";

			// bridging_rujukan_faskes_2
			$this->bridging_rujukan_faskes_2->LinkCustomAttributes = "";
			$this->bridging_rujukan_faskes_2->HrefValue = "";

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

			// generate_sep
			$this->generate_sep->SetDbValueDef($rsnew, $this->generate_sep->CurrentValue, NULL, $this->generate_sep->ReadOnly);

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

			// mapingtransaksi
			$this->mapingtransaksi->SetDbValueDef($rsnew, $this->mapingtransaksi->CurrentValue, NULL, $this->mapingtransaksi->ReadOnly);

			// bridging_by_no_rujukan
			$this->bridging_by_no_rujukan->SetDbValueDef($rsnew, $this->bridging_by_no_rujukan->CurrentValue, NULL, $this->bridging_by_no_rujukan->ReadOnly);

			// bridging_rujukan_faskes_2
			$this->bridging_rujukan_faskes_2->SetDbValueDef($rsnew, $this->bridging_rujukan_faskes_2->CurrentValue, NULL, $this->bridging_rujukan_faskes_2->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bridging_sep_by_no_rujukanlist.php"), "", $this->TableVar, TRUE);
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
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`jeniskeperawatan_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->JENISPERAWATAN_SEP, $sWhereWrk); // Call Lookup selecting
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
if (!isset($vw_bridging_sep_by_no_rujukan_edit)) $vw_bridging_sep_by_no_rujukan_edit = new cvw_bridging_sep_by_no_rujukan_edit();

// Page init
$vw_bridging_sep_by_no_rujukan_edit->Page_Init();

// Page main
$vw_bridging_sep_by_no_rujukan_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bridging_sep_by_no_rujukan_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_bridging_sep_by_no_rujukanedit = new ew_Form("fvw_bridging_sep_by_no_rujukanedit", "edit");

// Validate form
fvw_bridging_sep_by_no_rujukanedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TANGGALRUJUK_SEP");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_KELASRAWAT_SEP");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->FldErrMsg()) ?>");

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
fvw_bridging_sep_by_no_rujukanedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bridging_sep_by_no_rujukanedit.ValidateRequired = true;
<?php } else { ?>
fvw_bridging_sep_by_no_rujukanedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bridging_sep_by_no_rujukanedit.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_JENISPERAWATAN_SEP"] = {"LinkField":"x_jeniskeperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskeperawatan_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskeperawatan"};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_LAKALANTAS_SEP"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_lakalantas","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_lakalantas"};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_generate_sep[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_generate_sep[]"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->generate_sep->Options()) ?>;
fvw_bridging_sep_by_no_rujukanedit.Lists["x_mapingtransaksi[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_mapingtransaksi[]"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->mapingtransaksi->Options()) ?>;
fvw_bridging_sep_by_no_rujukanedit.Lists["x_bridging_by_no_rujukan[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_bridging_by_no_rujukan[]"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->Options()) ?>;
fvw_bridging_sep_by_no_rujukanedit.Lists["x_bridging_rujukan_faskes_2[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_bridging_rujukan_faskes_2[]"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->Options()) ?>;
fvw_bridging_sep_by_no_rujukanedit.Lists["x_penjamin_kkl_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_penjamin_kkl_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->Options()) ?>;
fvw_bridging_sep_by_no_rujukanedit.Lists["x_asalfaskesrujukan_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_asalfaskesrujukan_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->Options()) ?>;
fvw_bridging_sep_by_no_rujukanedit.Lists["x_peserta_cob"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_peserta_cob"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->peserta_cob->Options()) ?>;
fvw_bridging_sep_by_no_rujukanedit.Lists["x_poli_eksekutif"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_rujukanedit.Lists["x_poli_eksekutif"].Options = <?php echo json_encode($vw_bridging_sep_by_no_rujukan->poli_eksekutif->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
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
	$('#cek_rujukan_f2').hide();
	$('#cek_rujukan_f1').hide();
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
	$("#x_asalfaskesrujukan_id").change(function() {
		if (this.value == "1") {     
			$('#cek_rujukan_f2').hide();
			$('#cek_rujukan_f1').show();
		} else {
			$('#cek_rujukan_f2').show();
			$('#cek_rujukan_f1').hide();
		} 
	});
	$("#cek_rujukan_f1").click(function() {
		$.getJSON("ws/get_rujukan_faskes_pertama.php", {kode_rujukan: $("#x_NORUJUKAN_SEP").val(),noMR : $("#x_NOMR").val()},
		function(result){

					//alert(JSON.stringify(result));
					let pesan_error = result.result.pesan_error.status;
					if(pesan_error!='sukses')
					{
						alert("sambungan bermasalah , hubungi IT");
					}else
					{
						let status = result.result.hasil.metaData.code;
						if(status==200)
						{

							//alert(result.result.hasil.metaData.message);
							alert("NO Rujukan : "+result.result.hasil.response.rujukan.noKunjungan+"\n"+"keluhan : "+result.result.hasil.response.rujukan.keluhan);
							$("#x_DIAGNOSAAWAL_SEP").val(result.result.hasil.response.rujukan.diagnosa.kode);
							$("#x_NAMADIAGNOSA_SEP").val(result.result.hasil.response.rujukan.diagnosa.nama);
							$("#x_POLITUJUAN_SEP").val(result.result.hasil.response.rujukan.poliRujukan.kode);
							$("#x_NAMAPOLITUJUAN_SEP").val(result.result.hasil.response.rujukan.poliRujukan.nama);

							//$("#x_CATATAN_SEP").val('keluhan : '+result.result.hasil.response.rujukan.keluhan);
							$("#x_CATATAN_SEP").val(result.result.hasil.response.rujukan.peserta.alamat);
							$("#x_TANGGALRUJUK_SEP").val(result.result.hasil.response.rujukan.tglKunjungan);
							$("#x_status_kepesertaan_BPJS").val(result.result.hasil.response.rujukan.peserta.statusPeserta.keterangan);
							$("#x_PESERTANAMA_SEP").val(result.result.hasil.response.rujukan.peserta.nama);
							$("#x_PESERTANIK_SEP").val(result.result.hasil.response.rujukan.peserta.nik);
							$("#x_PESERTATGLLAHIR").val(result.result.hasil.response.rujukan.peserta.tglLahir);
							$("#x_PESERTAJENISKELAMIN_SEP").val(result.result.hasil.response.rujukan.peserta.sex);
							$("#x_PESERTAPISAT").val(result.result.hasil.response.rujukan.peserta.pisa);
							$("#x_PESERTANAMAKELAS_SEP").val(result.result.hasil.response.rujukan.peserta.hakKelas.keterangan);
							$("#x_KELASRAWAT_SEP").val(result.result.hasil.response.rujukan.peserta.hakKelas.kode);
							$("#x_KDPPKRUJUKAN_SEP").val(result.result.hasil.response.rujukan.provPerujuk.kode);
							$("#x_NMPPKRUJUKAN_SEP").val(result.result.hasil.response.rujukan.provPerujuk.nama);
							$("#x_NOKARTU").val(result.result.hasil.response.rujukan.peserta.noKartu);
							$("#x_pasien_NOTELP").val("");
							var tlp_simrs = result.result.hasil.response.rujukan.peserta.telepon_pasien;
							var tlp_bpjs = result.result.hasil.response.rujukan.peserta.mr.noTelepon;
							if (tlp_simrs.length < 10)
							{
								$("#x_pasien_NOTELP").val(tlp_bpjs);
							}else{
								$("#x_pasien_NOTELP").val(tlp_simrs);
							}
							$("#x_JENISPERAWATAN_SEP option[value="+result.result.hasil.response.rujukan.pelayanan.kode+"]").attr("selected", "selected");
						}else
						{
							alert(result.result.hasil.metaData.message);
						}
					}
				});     
	});
$("#buttonParent").click(function() {

		//alert('ok')
	var norujukan = $("#x_NORUJUKAN_SEP").val();
		if (norujukan==""){alert ("Nomer Rujukan Belum Di isi"); return;}
		var noTelp = $("#x_pasien_NOTELP").val();
		var length_tlp = noTelp.length;

		//alert("length tlp : "+noTelp.length);
		if (noTelp==""){alert ("noTelp  kosong"); return;}
		if (length_tlp<10){alert ("digit nomer telepon kurang"); return;}
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

		//alert("eksekutif : "+eksekutif);
		if (eksekutif==""){alert ("status poli eksekutif kosong"); return;}

		//alert("noKartu : "+$("#x_NOKARTU").val());
		var tanggal = $("#x_TANGGAL_SEP").val();
		if (tanggal==""){alert ("Tanggal SEP kosong"); return;}

		//alert("tglSep : "+tanggal)
		//alert("ppkPelayanan : "+$("#x_PPKPELAYANAN_SEP").val());

		var ppkPelayanan = $("#x_PPKPELAYANAN_SEP").val();
		if (ppkPelayanan==""){alert ("ppkPelayanan SEP kosong"); return;}
		/*alert("jnsPelayanan : "+$("input[name=x_JENISPERAWATAN_SEP]:checked").val());
		var jnsPelayanan = $("input[name=x_JENISPERAWATAN_SEP]:checked").val();
		if (jnsPelayanan==""){alert ("jenis layananan kosong"); return;}*/

		//alert("jnsPelayanan : "+$("#x_JENISPERAWATAN_SEP").val());
		var jnsPelayanan = $("#x_JENISPERAWATAN_SEP").val();
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

		//alert(" tlp : "+noTelp);
		if (noTelp==""){alert ("noTelp  kosong"); return;}
		if (length_tlp<10){alert ("digit nomer telepon kurang"); return;}

		//alert("user : "+$("#x_USER").val());
		var user = $("#x_USER").val();
		if (user==""){alert ("user  kosong"); return;}
	$.getJSON("ws/insert_sep_vclaim.php",   
		 { noKartu: $("#x_NOKARTU").val(), 
		   tglSep: $("#x_TANGGAL_SEP").val(),
		   ppkPelayanan: $("#x_PPKPELAYANAN_SEP").val(),
		   jnsPelayanan: $("#x_JENISPERAWATAN_SEP").val(),
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
	$("#cek_rujukan_f2").click(function() {
		$.getJSON("ws/get_rujukan_faskes_dua.php", {kode_rujukan: $("#x_NORUJUKAN_SEP").val(),noMR : $("#x_NOMR").val()},
		function(result){

					//alert(JSON.stringify(result));
					let pesan_error = result.result.pesan_error.status;
					if(pesan_error!='sukses')
					{
						alert("sambungan bermasalah , hubungi IT");
					}else
					{
						let status = result.result.hasil.metaData.code;
						if(status==200)
						{

						//alert(result.result.hasil.metaData.message);
							alert("NO Rujukan : "+result.result.hasil.response.rujukan.noKunjungan+"\n"+"keluhan : "+result.result.hasil.response.rujukan.keluhan);
							$("#x_DIAGNOSAAWAL_SEP").val(result.result.hasil.response.rujukan.diagnosa.kode);
							$("#x_NAMADIAGNOSA_SEP").val(result.result.hasil.response.rujukan.diagnosa.nama);
							$("#x_POLITUJUAN_SEP").val(result.result.hasil.response.rujukan.poliRujukan.kode);
							$("#x_NAMAPOLITUJUAN_SEP").val(result.result.hasil.response.rujukan.poliRujukan.nama);

							//$("#x_CATATAN_SEP").val('keluhan : '+result.result.hasil.response.rujukan.keluhan);
							$("#x_CATATAN_SEP").val(result.result.hasil.response.rujukan.peserta.alamat);
							$("#x_TANGGALRUJUK_SEP").val(result.result.hasil.response.rujukan.tglKunjungan);
							$("#x_status_kepesertaan_BPJS").val(result.result.hasil.response.rujukan.peserta.statusPeserta.keterangan);
							$("#x_PESERTANAMA_SEP").val(result.result.hasil.response.rujukan.peserta.nama);
							$("#x_PESERTANIK_SEP").val(result.result.hasil.response.rujukan.peserta.nik);
							$("#x_PESERTATGLLAHIR").val(result.result.hasil.response.rujukan.peserta.tglLahir);
							$("#x_PESERTAJENISKELAMIN_SEP").val(result.result.hasil.response.rujukan.peserta.sex);
							$("#x_PESERTAPISAT").val(result.result.hasil.response.rujukan.peserta.pisa);
							$("#x_PESERTANAMAKELAS_SEP").val(result.result.hasil.response.rujukan.peserta.hakKelas.keterangan);
							$("#x_KELASRAWAT_SEP").val(result.result.hasil.response.rujukan.peserta.hakKelas.kode);
							$("#x_KDPPKRUJUKAN_SEP").val(result.result.hasil.response.rujukan.provPerujuk.kode);
							$("#x_NMPPKRUJUKAN_SEP").val(result.result.hasil.response.rujukan.provPerujuk.nama);
							$("#x_NOKARTU").val(result.result.hasil.response.rujukan.peserta.noKartu);
							$("#x_pasien_NOTELP").val("");
							var tlp_simrs = result.result.hasil.response.rujukan.peserta.telepon_pasien;
							var tlp_bpjs = result.result.hasil.response.rujukan.peserta.mr.noTelepon;
							if (tlp_simrs.length < 10)
							{
								$("#x_pasien_NOTELP").val(tlp_bpjs);
							}else{
								$("#x_pasien_NOTELP").val(tlp_simrs);
							}
							$("#x_JENISPERAWATAN_SEP option[value="+result.result.hasil.response.rujukan.pelayanan.kode+"]").attr("selected", "selected");
						}else
						{
							alert(result.result.hasil.metaData.message);
						}
					}
				});     
	});
});
</script>
<?php if (!$vw_bridging_sep_by_no_rujukan_edit->IsModal) { ?>
<?php } ?>
<?php $vw_bridging_sep_by_no_rujukan_edit->ShowPageHeader(); ?>
<?php
$vw_bridging_sep_by_no_rujukan_edit->ShowMessage();
?>
<form name="fvw_bridging_sep_by_no_rujukanedit" id="fvw_bridging_sep_by_no_rujukanedit" class="<?php echo $vw_bridging_sep_by_no_rujukan_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bridging_sep_by_no_rujukan_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bridging_sep_by_no_rujukan">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_bridging_sep_by_no_rujukan_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_vw_bridging_sep_by_no_rujukanedit" class="ewCustomTemplate"></div>
<script id="tpm_vw_bridging_sep_by_no_rujukanedit" type="text/html">
<div id="ct_vw_bridging_sep_by_no_rujukan_edit"><section class="content">
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
						<h3 class="profile-username text-center" id="lblnama"><?php echo $vw_bridging_sep_by_no_rujukan->NOMR->FldCaption() ?>:{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NOMR"/}}</h3>
						<p class="text-muted text-center" id="lblnoka"><?php echo $vw_bridging_sep_by_no_rujukan->NOKARTU->FldCaption() ?>:{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NOKARTU"/}}</p>
						<!-- <p class="text-muted text-center" id="lblnoka">{{include tmpl="#tpcaption_bridging_kepesertaan_by_no_ka"/}}{{include tmpl="#tpx_bridging_kepesertaan_by_no_ka"/}}</p> -->
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
											<span class="fa fa-sort-numeric-asc"></span><a title="NIK" class="pull-right-container" id="lblnik">{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_PESERTANIK_SEP"/}} <?php echo $vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->FldCaption() ?></a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-sort-numeric-asc"></span><a title="Nama Peserta" class="pull-right-container" id="lblnamapeserta"><?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_PESERTANAMA_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-calendar"></span> <a title="Tanggal Lahir" class="pull-right-container" id="lbltgllahir"><?php echo $vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_PESERTATGLLAHIR"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-hospital-o"></span> <a title="Hak Kelas Rawat" class="pull-right-container" id="lblhakkelas"><?php echo $vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_KELASRAWAT_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-hospital-o"></span> <a title="Nama Hak Kelas Rawat" class="pull-right-container" id="lblnama hakkelas"><?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_PESERTANAMAKELAS_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-stethoscope"></span>  <a title="Faskes Tingkat 1" class="pull-right-container" id="lblfktp"><?php echo $vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_KDPPKRUJUKAN_SEP"/}}</a>	
										</li>
										<li class="list-group-item">
											<span class="fa fa-stethoscope"></span>  <a title="Nama Faskes Tingkat 1" class="pull-right-container" id="lblnamafktp"><?php echo $vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NMPPKRUJUKAN_SEP"/}}</a>	
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
											<span class="fa fa-calendar"></span>  <a title="Jenis Peserta" class="pull-right-container" id="lblpeserta"><?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_PESERTAJENISKELAMIN_SEP"/}}</a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-calendar"></span>  <a title="Jenis Peserta" class="pull-right-container" id="lblpeserta"><?php echo $vw_bridging_sep_by_no_rujukan->PESERTAPISAT->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_PESERTAPISAT"/}}</a>
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
											<span class="fa fa-bank"></span> <a title="Nama Poli" class="pull-right-container" id="lblnamapoli"></a>
										</li>
										<li class="list-group-item">
											<span class="fa fa-bank"></span> <a title="Nama Diagnosa" class="pull-right-container" id="lblnamadiagnosa"></a>
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
						<div id="divRujukan">
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->FldCaption() ?></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_asalfaskesrujukan_id"/}}
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NORUJUKAN_SEP"/}}
									</div>
								</div>
									<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										<input type="button"  class="btn bg-maroon btn-flat margin" value="Cari Rujukan Faskes 1" id="cek_rujukan_f1">
										<input type="button" class="btn bg-olive btn-flat margin" value="Cari Rujukan Faskes 2" id="cek_rujukan_f2">
									</div>
								</div>
							</div>
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><label style="color:gray;font-size:x-small"></label> <?php echo $vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->FldCaption() ?></label>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<div class='input-group date'>
											{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_TANGGALRUJUK_SEP"/}}
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_status_kepesertaan_BPJS"/}} 
									</div>
								</div>
							<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_JENISPERAWATAN_SEP"/}} 
									</div>
							</div>
							<div class="form-group">
									<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->USER->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
									<div class="col-md-9 col-sm-9 col-xs-12">
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_USER"/}} 
									</div>
							</div>
							<div class="form-group" id="divPoli">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">                                        
										<span class="input-group-addon">
										</span>
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_POLITUJUAN_SEP"/}}
									</div>
								</div>
							</div>
							<div class="form-group" id="divPoli">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->FldCaption() ?> <label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="input-group">                                        
										<span class="input-group-addon">
										</span>
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NAMAPOLITUJUAN_SEP"/}}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_poli_eksekutif"/}}
								</div>
							</div> 
							<!-- end rujukan -->
							<div class="clearfix"></div>
							<!-- sep -->
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><label style="color:gray;font-size:x-small"></label> <?php echo $vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->FldCaption() ?></label>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<div class='input-group date'>
										{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_TANGGAL_SEP"/}}
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="input-group">
										 {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_PPKPELAYANAN_SEP"/}}
										<span class="input-group-addon">
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_peserta_cob"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_DIAGNOSAAWAL_SEP"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NAMADIAGNOSA_SEP"/}}
								</div>
							</div>
							<!--
								<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
								{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NAMADIAGNOSA_SEP"/}}
								</div>
							</div> -->
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->FldCaption() ?><label style="color:red;font-size:small">*</label></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_pasien_NOTELP"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->CATATAN_SEP->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_CATATAN_SEP"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_LAKALANTAS_SEP"/}}
								</div>
							</div>
							<div class="form-group">
								<label  id="lbl_LOKASILAKALANTAS" class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_LOKASILAKALANTAS"/}}
								</div>
							</div>
							<div class="form-group">
								<label id="lbl_penjamin_kkl_id" class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_penjamin_kkl_id"/}}
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
											<!--<?php echo $vw_bridging_sep_by_no_rujukan->generate_sep->FldCaption() ?> {{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_generate_sep"/}}  -->
									<input type="button" class="btn bg-olive btn-flat margin" value="Buat Nomer SEP" id="buttonParent">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $vw_bridging_sep_by_no_rujukan->NO_SJP->FldCaption() ?></label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									{{include tmpl="#tpx_vw_bridging_sep_by_no_rujukan_NO_SJP"/}}
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
<?php if ($vw_bridging_sep_by_no_rujukan->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NOMR" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NOMR" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NOMR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NOMR->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NOMR" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NOMR">
<span<?php echo $vw_bridging_sep_by_no_rujukan->NOMR->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_rujukan->NOMR->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NOMR" name="x_NOMR" id="x_NOMR" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NOMR->CurrentValue) ?>">
<script type="text/html" class="vw_bridging_sep_by_no_rujukanedit_js">
fvw_bridging_sep_by_no_rujukanedit.CreateAutoSuggest({"id":"x_NOMR","forceSelect":false});
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->NOMR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->KDPOLY->Visible) { // KDPOLY ?>
	<div id="r_KDPOLY" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_KDPOLY" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_KDPOLY" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->KDPOLY->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->KDPOLY->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_KDPOLY" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_KDPOLY">
<span<?php echo $vw_bridging_sep_by_no_rujukan->KDPOLY->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_rujukan->KDPOLY->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_KDPOLY" name="x_KDPOLY" id="x_KDPOLY" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->KDPOLY->CurrentValue) ?>">
<script type="text/html" class="vw_bridging_sep_by_no_rujukanedit_js">
fvw_bridging_sep_by_no_rujukanedit.CreateAutoSuggest({"id":"x_KDPOLY","forceSelect":false});
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->KDPOLY->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->TGLREG->Visible) { // TGLREG ?>
	<div id="r_TGLREG" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_TGLREG" for="x_TGLREG" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_TGLREG" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->TGLREG->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->TGLREG->CellAttributes() ?>>
<div id="orig_vw_bridging_sep_by_no_rujukan_TGLREG" class="hide">
<span id="el_vw_bridging_sep_by_no_rujukan_TGLREG">
<span<?php echo $vw_bridging_sep_by_no_rujukan->TGLREG->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_rujukan->TGLREG->EditValue ?></p></span>
</span>
</div>
<script id="tpx_vw_bridging_sep_by_no_rujukan_TGLREG" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="cvt_vw_bridging_sep_by_no_rujukan_TGLREG"><?php

//$s = CurrentPage()->NOMR->CurrentValue;
//$dd = getNamaPasienByNOMR($s);
//echo $dd;

?>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_TGLREG" name="x_TGLREG" id="x_TGLREG" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->TGLREG->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_rujukan->TGLREG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<div id="r_KDCARABAYAR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_KDCARABAYAR" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_KDCARABAYAR" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->KDCARABAYAR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->KDCARABAYAR->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_KDCARABAYAR" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_KDCARABAYAR">
<span<?php echo $vw_bridging_sep_by_no_rujukan->KDCARABAYAR->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_rujukan->KDCARABAYAR->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_KDCARABAYAR" name="x_KDCARABAYAR" id="x_KDCARABAYAR" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->KDCARABAYAR->CurrentValue) ?>">
<script type="text/html" class="vw_bridging_sep_by_no_rujukanedit_js">
fvw_bridging_sep_by_no_rujukanedit.CreateAutoSuggest({"id":"x_KDCARABAYAR","forceSelect":false});
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->KDCARABAYAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NIP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NIP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NIP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NIP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NIP">
<span<?php echo $vw_bridging_sep_by_no_rujukan->NIP->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_rujukan->NIP->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NIP" name="x_NIP" id="x_NIP" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NIP->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_rujukan->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->JAMREG->Visible) { // JAMREG ?>
	<div id="r_JAMREG" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_JAMREG" for="x_JAMREG" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_JAMREG" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->JAMREG->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->JAMREG->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_JAMREG" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_JAMREG">
<span<?php echo $vw_bridging_sep_by_no_rujukan->JAMREG->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bridging_sep_by_no_rujukan->JAMREG->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_JAMREG" name="x_JAMREG" id="x_JAMREG" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->JAMREG->CurrentValue) ?>">
<?php echo $vw_bridging_sep_by_no_rujukan->JAMREG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->NO_SJP->Visible) { // NO_SJP ?>
	<div id="r_NO_SJP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NO_SJP" for="x_NO_SJP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NO_SJP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NO_SJP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NO_SJP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NO_SJP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NO_SJP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NO_SJP" name="x_NO_SJP" id="x_NO_SJP" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NO_SJP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->NO_SJP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->NO_SJP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->NO_SJP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->NOKARTU->Visible) { // NOKARTU ?>
	<div id="r_NOKARTU" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NOKARTU" for="x_NOKARTU" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NOKARTU" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NOKARTU->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NOKARTU->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NOKARTU" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NOKARTU">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NOKARTU" name="x_NOKARTU" id="x_NOKARTU" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NOKARTU->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->NOKARTU->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->NOKARTU->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->NOKARTU->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->Visible) { // TANGGAL_SEP ?>
	<div id="r_TANGGAL_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_TANGGAL_SEP" for="x_TANGGAL_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_TANGGAL_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_TANGGAL_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_TANGGAL_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_TANGGAL_SEP" data-format="5" name="x_TANGGAL_SEP" id="x_TANGGAL_SEP" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->TANGGAL_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->Visible) { // TANGGALRUJUK_SEP ?>
	<div id="r_TANGGALRUJUK_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_TANGGALRUJUK_SEP" for="x_TANGGALRUJUK_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_TANGGALRUJUK_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_TANGGALRUJUK_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_TANGGALRUJUK_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_TANGGALRUJUK_SEP" data-format="5" name="x_TANGGALRUJUK_SEP" id="x_TANGGALRUJUK_SEP" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->TANGGALRUJUK_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->Visible) { // KELASRAWAT_SEP ?>
	<div id="r_KELASRAWAT_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_KELASRAWAT_SEP" for="x_KELASRAWAT_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_KELASRAWAT_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_KELASRAWAT_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_KELASRAWAT_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_KELASRAWAT_SEP" name="x_KELASRAWAT_SEP" id="x_KELASRAWAT_SEP" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->KELASRAWAT_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->Visible) { // NORUJUKAN_SEP ?>
	<div id="r_NORUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NORUJUKAN_SEP" for="x_NORUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NORUJUKAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NORUJUKAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NORUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NORUJUKAN_SEP" name="x_NORUJUKAN_SEP" id="x_NORUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->NORUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->Visible) { // PPKPELAYANAN_SEP ?>
	<div id="r_PPKPELAYANAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PPKPELAYANAN_SEP" for="x_PPKPELAYANAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PPKPELAYANAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PPKPELAYANAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PPKPELAYANAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PPKPELAYANAN_SEP" name="x_PPKPELAYANAN_SEP" id="x_PPKPELAYANAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PPKPELAYANAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->Visible) { // JENISPERAWATAN_SEP ?>
	<div id="r_JENISPERAWATAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_JENISPERAWATAN_SEP" for="x_JENISPERAWATAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_JENISPERAWATAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_JENISPERAWATAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_JENISPERAWATAN_SEP">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_JENISPERAWATAN_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->DisplayValueSeparatorAttribute() ?>" id="x_JENISPERAWATAN_SEP" name="x_JENISPERAWATAN_SEP"<?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->SelectOptionListHtml("x_JENISPERAWATAN_SEP") ?>
</select>
<input type="hidden" name="s_x_JENISPERAWATAN_SEP" id="s_x_JENISPERAWATAN_SEP" value="<?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->JENISPERAWATAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->CATATAN_SEP->Visible) { // CATATAN_SEP ?>
	<div id="r_CATATAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_CATATAN_SEP" for="x_CATATAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_CATATAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->CATATAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->CATATAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_CATATAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_CATATAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_CATATAN_SEP" name="x_CATATAN_SEP" id="x_CATATAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->CATATAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->CATATAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->CATATAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->CATATAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->Visible) { // DIAGNOSAAWAL_SEP ?>
	<div id="r_DIAGNOSAAWAL_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_DIAGNOSAAWAL_SEP" for="x_DIAGNOSAAWAL_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_DIAGNOSAAWAL_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_DIAGNOSAAWAL_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_DIAGNOSAAWAL_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_DIAGNOSAAWAL_SEP" name="x_DIAGNOSAAWAL_SEP" id="x_DIAGNOSAAWAL_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->DIAGNOSAAWAL_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->Visible) { // NAMADIAGNOSA_SEP ?>
	<div id="r_NAMADIAGNOSA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NAMADIAGNOSA_SEP" for="x_NAMADIAGNOSA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NAMADIAGNOSA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NAMADIAGNOSA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NAMADIAGNOSA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NAMADIAGNOSA_SEP" name="x_NAMADIAGNOSA_SEP" id="x_NAMADIAGNOSA_SEP" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->NAMADIAGNOSA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->Visible) { // LAKALANTAS_SEP ?>
	<div id="r_LAKALANTAS_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_LAKALANTAS_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_LAKALANTAS_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_LAKALANTAS_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_LAKALANTAS_SEP">
<div id="tp_x_LAKALANTAS_SEP" class="ewTemplate"><input type="radio" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_LAKALANTAS_SEP" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->DisplayValueSeparatorAttribute() ?>" name="x_LAKALANTAS_SEP" id="x_LAKALANTAS_SEP" value="{value}"<?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->EditAttributes() ?>></div>
<div id="dsl_x_LAKALANTAS_SEP" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->RadioButtonListHtml(FALSE, "x_LAKALANTAS_SEP") ?>
</div></div>
<input type="hidden" name="s_x_LAKALANTAS_SEP" id="s_x_LAKALANTAS_SEP" value="<?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->LAKALANTAS_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->Visible) { // LOKASILAKALANTAS ?>
	<div id="r_LOKASILAKALANTAS" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_LOKASILAKALANTAS" for="x_LOKASILAKALANTAS" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_LOKASILAKALANTAS" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_LOKASILAKALANTAS" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_LOKASILAKALANTAS">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_LOKASILAKALANTAS" name="x_LOKASILAKALANTAS" id="x_LOKASILAKALANTAS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->LOKASILAKALANTAS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->USER->Visible) { // USER ?>
	<div id="r_USER" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_USER" for="x_USER" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_USER" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->USER->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->USER->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_USER" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_USER">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_USER" name="x_USER" id="x_USER" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->USER->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->USER->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->USER->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->USER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->generate_sep->Visible) { // generate_sep ?>
	<div id="r_generate_sep" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_generate_sep" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_generate_sep" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->generate_sep->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->generate_sep->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_generate_sep" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_generate_sep">
<div id="tp_x_generate_sep" class="ewTemplate"><input type="checkbox" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_generate_sep" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->generate_sep->DisplayValueSeparatorAttribute() ?>" name="x_generate_sep[]" id="x_generate_sep[]" value="{value}"<?php echo $vw_bridging_sep_by_no_rujukan->generate_sep->EditAttributes() ?>></div>
<div id="dsl_x_generate_sep" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_rujukan->generate_sep->CheckBoxListHtml(FALSE, "x_generate_sep[]") ?>
</div></div>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->generate_sep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->Visible) { // PESERTANIK_SEP ?>
	<div id="r_PESERTANIK_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTANIK_SEP" for="x_PESERTANIK_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTANIK_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTANIK_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTANIK_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTANIK_SEP" name="x_PESERTANIK_SEP" id="x_PESERTANIK_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANIK_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->Visible) { // PESERTANAMA_SEP ?>
	<div id="r_PESERTANAMA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTANAMA_SEP" for="x_PESERTANAMA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTANAMA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTANAMA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTANAMA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTANAMA_SEP" name="x_PESERTANAMA_SEP" id="x_PESERTANAMA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->Visible) { // PESERTAJENISKELAMIN_SEP ?>
	<div id="r_PESERTAJENISKELAMIN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTAJENISKELAMIN_SEP" for="x_PESERTAJENISKELAMIN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTAJENISKELAMIN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTAJENISKELAMIN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTAJENISKELAMIN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTAJENISKELAMIN_SEP" name="x_PESERTAJENISKELAMIN_SEP" id="x_PESERTAJENISKELAMIN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISKELAMIN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->Visible) { // PESERTANAMAKELAS_SEP ?>
	<div id="r_PESERTANAMAKELAS_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTANAMAKELAS_SEP" for="x_PESERTANAMAKELAS_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTANAMAKELAS_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTANAMAKELAS_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTANAMAKELAS_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTANAMAKELAS_SEP" name="x_PESERTANAMAKELAS_SEP" id="x_PESERTANAMAKELAS_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAKELAS_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTAPISAT->Visible) { // PESERTAPISAT ?>
	<div id="r_PESERTAPISAT" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTAPISAT" for="x_PESERTAPISAT" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTAPISAT" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTAPISAT->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAPISAT->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTAPISAT" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTAPISAT">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTAPISAT" name="x_PESERTAPISAT" id="x_PESERTAPISAT" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTAPISAT->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAPISAT->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAPISAT->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAPISAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->Visible) { // PESERTATGLLAHIR ?>
	<div id="r_PESERTATGLLAHIR" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTATGLLAHIR" for="x_PESERTATGLLAHIR" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTATGLLAHIR" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTATGLLAHIR" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTATGLLAHIR">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTATGLLAHIR" name="x_PESERTATGLLAHIR" id="x_PESERTATGLLAHIR" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTATGLLAHIR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTAJENISPESERTA_SEP->Visible) { // PESERTAJENISPESERTA_SEP ?>
	<div id="r_PESERTAJENISPESERTA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTAJENISPESERTA_SEP" for="x_PESERTAJENISPESERTA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISPESERTA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISPESERTA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTAJENISPESERTA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTAJENISPESERTA_SEP" name="x_PESERTAJENISPESERTA_SEP" id="x_PESERTAJENISPESERTA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTAJENISPESERTA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISPESERTA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISPESERTA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTAJENISPESERTA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->PESERTANAMAJENISPESERTA_SEP->Visible) { // PESERTANAMAJENISPESERTA_SEP ?>
	<div id="r_PESERTANAMAJENISPESERTA_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_PESERTANAMAJENISPESERTA_SEP" for="x_PESERTANAMAJENISPESERTA_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_PESERTANAMAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAJENISPESERTA_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAJENISPESERTA_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_PESERTANAMAJENISPESERTA_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_PESERTANAMAJENISPESERTA_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_PESERTANAMAJENISPESERTA_SEP" name="x_PESERTANAMAJENISPESERTA_SEP" id="x_PESERTANAMAJENISPESERTA_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->PESERTANAMAJENISPESERTA_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAJENISPESERTA_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAJENISPESERTA_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->PESERTANAMAJENISPESERTA_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->Visible) { // POLITUJUAN_SEP ?>
	<div id="r_POLITUJUAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_POLITUJUAN_SEP" for="x_POLITUJUAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_POLITUJUAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_POLITUJUAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_POLITUJUAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_POLITUJUAN_SEP" name="x_POLITUJUAN_SEP" id="x_POLITUJUAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->POLITUJUAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->Visible) { // NAMAPOLITUJUAN_SEP ?>
	<div id="r_NAMAPOLITUJUAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NAMAPOLITUJUAN_SEP" for="x_NAMAPOLITUJUAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NAMAPOLITUJUAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NAMAPOLITUJUAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NAMAPOLITUJUAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NAMAPOLITUJUAN_SEP" name="x_NAMAPOLITUJUAN_SEP" id="x_NAMAPOLITUJUAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->NAMAPOLITUJUAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->Visible) { // KDPPKRUJUKAN_SEP ?>
	<div id="r_KDPPKRUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_KDPPKRUJUKAN_SEP" for="x_KDPPKRUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_KDPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_KDPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_KDPPKRUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_KDPPKRUJUKAN_SEP" name="x_KDPPKRUJUKAN_SEP" id="x_KDPPKRUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->KDPPKRUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->Visible) { // NMPPKRUJUKAN_SEP ?>
	<div id="r_NMPPKRUJUKAN_SEP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_NMPPKRUJUKAN_SEP" for="x_NMPPKRUJUKAN_SEP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_NMPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_NMPPKRUJUKAN_SEP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_NMPPKRUJUKAN_SEP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_NMPPKRUJUKAN_SEP" name="x_NMPPKRUJUKAN_SEP" id="x_NMPPKRUJUKAN_SEP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->NMPPKRUJUKAN_SEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->mapingtransaksi->Visible) { // mapingtransaksi ?>
	<div id="r_mapingtransaksi" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_mapingtransaksi" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_mapingtransaksi" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->mapingtransaksi->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->mapingtransaksi->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_mapingtransaksi" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_mapingtransaksi">
<div id="tp_x_mapingtransaksi" class="ewTemplate"><input type="checkbox" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_mapingtransaksi" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->mapingtransaksi->DisplayValueSeparatorAttribute() ?>" name="x_mapingtransaksi[]" id="x_mapingtransaksi[]" value="{value}"<?php echo $vw_bridging_sep_by_no_rujukan->mapingtransaksi->EditAttributes() ?>></div>
<div id="dsl_x_mapingtransaksi" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_rujukan->mapingtransaksi->CheckBoxListHtml(FALSE, "x_mapingtransaksi[]") ?>
</div></div>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->mapingtransaksi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->Visible) { // bridging_by_no_rujukan ?>
	<div id="r_bridging_by_no_rujukan" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_bridging_by_no_rujukan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_bridging_by_no_rujukan" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_bridging_by_no_rujukan" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_bridging_by_no_rujukan">
<div id="tp_x_bridging_by_no_rujukan" class="ewTemplate"><input type="checkbox" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_bridging_by_no_rujukan" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->DisplayValueSeparatorAttribute() ?>" name="x_bridging_by_no_rujukan[]" id="x_bridging_by_no_rujukan[]" value="{value}"<?php echo $vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->EditAttributes() ?>></div>
<div id="dsl_x_bridging_by_no_rujukan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->CheckBoxListHtml(FALSE, "x_bridging_by_no_rujukan[]") ?>
</div></div>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->bridging_by_no_rujukan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->Visible) { // bridging_rujukan_faskes_2 ?>
	<div id="r_bridging_rujukan_faskes_2" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_bridging_rujukan_faskes_2" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_bridging_rujukan_faskes_2" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_bridging_rujukan_faskes_2" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_bridging_rujukan_faskes_2">
<div id="tp_x_bridging_rujukan_faskes_2" class="ewTemplate"><input type="checkbox" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_bridging_rujukan_faskes_2" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->DisplayValueSeparatorAttribute() ?>" name="x_bridging_rujukan_faskes_2[]" id="x_bridging_rujukan_faskes_2[]" value="{value}"<?php echo $vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->EditAttributes() ?>></div>
<div id="dsl_x_bridging_rujukan_faskes_2" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->CheckBoxListHtml(FALSE, "x_bridging_rujukan_faskes_2[]") ?>
</div></div>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->bridging_rujukan_faskes_2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->pasien_NOTELP->Visible) { // pasien_NOTELP ?>
	<div id="r_pasien_NOTELP" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_pasien_NOTELP" for="x_pasien_NOTELP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_pasien_NOTELP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_pasien_NOTELP" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_pasien_NOTELP">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_pasien_NOTELP" name="x_pasien_NOTELP" id="x_pasien_NOTELP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->pasien_NOTELP->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->pasien_NOTELP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->Visible) { // penjamin_kkl_id ?>
	<div id="r_penjamin_kkl_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_penjamin_kkl_id" for="x_penjamin_kkl_id" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_penjamin_kkl_id" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_penjamin_kkl_id" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_penjamin_kkl_id">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_penjamin_kkl_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->DisplayValueSeparatorAttribute() ?>" id="x_penjamin_kkl_id" name="x_penjamin_kkl_id"<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->SelectOptionListHtml("x_penjamin_kkl_id") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->penjamin_kkl_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->Visible) { // asalfaskesrujukan_id ?>
	<div id="r_asalfaskesrujukan_id" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_asalfaskesrujukan_id" for="x_asalfaskesrujukan_id" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_asalfaskesrujukan_id" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_asalfaskesrujukan_id" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_asalfaskesrujukan_id">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_asalfaskesrujukan_id" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->DisplayValueSeparatorAttribute() ?>" id="x_asalfaskesrujukan_id" name="x_asalfaskesrujukan_id"<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->SelectOptionListHtml("x_asalfaskesrujukan_id") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->asalfaskesrujukan_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->peserta_cob->Visible) { // peserta_cob ?>
	<div id="r_peserta_cob" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_peserta_cob" for="x_peserta_cob" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_peserta_cob" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_peserta_cob" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_peserta_cob">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_peserta_cob" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->DisplayValueSeparatorAttribute() ?>" id="x_peserta_cob" name="x_peserta_cob"<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->SelectOptionListHtml("x_peserta_cob") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->peserta_cob->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<div id="r_poli_eksekutif" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_poli_eksekutif" for="x_poli_eksekutif" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_poli_eksekutif" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_poli_eksekutif" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_poli_eksekutif">
<select data-table="vw_bridging_sep_by_no_rujukan" data-field="x_poli_eksekutif" data-value-separator="<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->DisplayValueSeparatorAttribute() ?>" id="x_poli_eksekutif" name="x_poli_eksekutif"<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->EditAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->SelectOptionListHtml("x_poli_eksekutif") ?>
</select>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->poli_eksekutif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->Visible) { // status_kepesertaan_BPJS ?>
	<div id="r_status_kepesertaan_BPJS" class="form-group">
		<label id="elh_vw_bridging_sep_by_no_rujukan_status_kepesertaan_BPJS" for="x_status_kepesertaan_BPJS" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_bridging_sep_by_no_rujukan_status_kepesertaan_BPJS" class="vw_bridging_sep_by_no_rujukanedit" type="text/html"><span><?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->CellAttributes() ?>>
<script id="tpx_vw_bridging_sep_by_no_rujukan_status_kepesertaan_BPJS" class="vw_bridging_sep_by_no_rujukanedit" type="text/html">
<span id="el_vw_bridging_sep_by_no_rujukan_status_kepesertaan_BPJS">
<input type="text" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_status_kepesertaan_BPJS" name="x_status_kepesertaan_BPJS" id="x_status_kepesertaan_BPJS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->getPlaceHolder()) ?>" value="<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->EditValue ?>"<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_bridging_sep_by_no_rujukan->status_kepesertaan_BPJS->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="vw_bridging_sep_by_no_rujukan" data-field="x_IDXDAFTAR" name="x_IDXDAFTAR" id="x_IDXDAFTAR" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_rujukan->IDXDAFTAR->CurrentValue) ?>">
<?php if (!$vw_bridging_sep_by_no_rujukan_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bridging_sep_by_no_rujukan_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_vw_bridging_sep_by_no_rujukanedit", "tpm_vw_bridging_sep_by_no_rujukanedit", "vw_bridging_sep_by_no_rujukanedit", "<?php echo $vw_bridging_sep_by_no_rujukan->CustomExport ?>");
jQuery("script.vw_bridging_sep_by_no_rujukanedit_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
fvw_bridging_sep_by_no_rujukanedit.Init();
</script>
<?php
$vw_bridging_sep_by_no_rujukan_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bridging_sep_by_no_rujukan_edit->Page_Terminate();
?>
