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

$vw_bridging_sep_by_no_kartu_view = NULL; // Initialize page object first

class cvw_bridging_sep_by_no_kartu_view extends cvw_bridging_sep_by_no_kartu {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bridging_sep_by_no_kartu';

	// Page object name
	var $PageObjName = 'vw_bridging_sep_by_no_kartu_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["IDXDAFTAR"] <> "") {
			$this->RecKey["IDXDAFTAR"] = $_GET["IDXDAFTAR"];
			$KeyUrl .= "&amp;IDXDAFTAR=" . urlencode($this->RecKey["IDXDAFTAR"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->IDXDAFTAR->SetVisibility();
		$this->IDXDAFTAR->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["IDXDAFTAR"] <> "") {
				$this->IDXDAFTAR->setQueryStringValue($_GET["IDXDAFTAR"]);
				$this->RecKey["IDXDAFTAR"] = $this->IDXDAFTAR->QueryStringValue;
			} elseif (@$_POST["IDXDAFTAR"] <> "") {
				$this->IDXDAFTAR->setFormValue($_POST["IDXDAFTAR"]);
				$this->RecKey["IDXDAFTAR"] = $this->IDXDAFTAR->FormValue;
			} else {
				$sReturnUrl = "vw_bridging_sep_by_no_kartulist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "vw_bridging_sep_by_no_kartulist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "vw_bridging_sep_by_no_kartulist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bridging_sep_by_no_kartulist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($vw_bridging_sep_by_no_kartu_view)) $vw_bridging_sep_by_no_kartu_view = new cvw_bridging_sep_by_no_kartu_view();

// Page init
$vw_bridging_sep_by_no_kartu_view->Page_Init();

// Page main
$vw_bridging_sep_by_no_kartu_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bridging_sep_by_no_kartu_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fvw_bridging_sep_by_no_kartuview = new ew_Form("fvw_bridging_sep_by_no_kartuview", "view");

// Form_CustomValidate event
fvw_bridging_sep_by_no_kartuview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bridging_sep_by_no_kartuview.ValidateRequired = true;
<?php } else { ?>
fvw_bridging_sep_by_no_kartuview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bridging_sep_by_no_kartuview.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_bridging_sep_by_no_kartuview.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_bridging_sep_by_no_kartuview.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_bridging_sep_by_no_kartuview.Lists["x_JENISPERAWATAN_SEP"] = {"LinkField":"x_jeniskeperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskeperawatan_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskeperawatan"};
fvw_bridging_sep_by_no_kartuview.Lists["x_DIAGNOSAAWAL_SEP"] = {"LinkField":"x_Code","Ajax":true,"AutoFill":false,"DisplayFields":["x_Code","x_Description","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"refdiagnosis"};
fvw_bridging_sep_by_no_kartuview.Lists["x_LAKALANTAS_SEP"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_lakalantas","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_lakalantas"};
fvw_bridging_sep_by_no_kartuview.Lists["x_POLITUJUAN_SEP"] = {"LinkField":"x_KDPOLI","Ajax":true,"AutoFill":false,"DisplayFields":["x_KDPOLI","x_NMPOLI","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"refpoli"};
fvw_bridging_sep_by_no_kartuview.Lists["x_penjamin_kkl_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuview.Lists["x_penjamin_kkl_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->penjamin_kkl_id->Options()) ?>;
fvw_bridging_sep_by_no_kartuview.Lists["x_asalfaskesrujukan_id"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuview.Lists["x_asalfaskesrujukan_id"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->Options()) ?>;
fvw_bridging_sep_by_no_kartuview.Lists["x_peserta_cob"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuview.Lists["x_peserta_cob"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->peserta_cob->Options()) ?>;
fvw_bridging_sep_by_no_kartuview.Lists["x_poli_eksekutif"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_bridging_sep_by_no_kartuview.Lists["x_poli_eksekutif"].Options = <?php echo json_encode($vw_bridging_sep_by_no_kartu->poli_eksekutif->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_bridging_sep_by_no_kartu_view->IsModal) { ?>
<?php } ?>
<?php $vw_bridging_sep_by_no_kartu_view->ExportOptions->Render("body") ?>
<?php
	foreach ($vw_bridging_sep_by_no_kartu_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$vw_bridging_sep_by_no_kartu_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $vw_bridging_sep_by_no_kartu_view->ShowPageHeader(); ?>
<?php
$vw_bridging_sep_by_no_kartu_view->ShowMessage();
?>
<form name="fvw_bridging_sep_by_no_kartuview" id="fvw_bridging_sep_by_no_kartuview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bridging_sep_by_no_kartu_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bridging_sep_by_no_kartu_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bridging_sep_by_no_kartu">
<?php if ($vw_bridging_sep_by_no_kartu_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($vw_bridging_sep_by_no_kartu->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<tr id="r_IDXDAFTAR">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_IDXDAFTAR"><?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->FldCaption() ?></span></td>
		<td data-name="IDXDAFTAR"<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->CellAttributes() ?>>
<div id="orig_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="hide">
<span id="el_vw_bridging_sep_by_no_kartu_IDXDAFTAR">
<span<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->ViewValue ?></span>
</span>
</div>
<div class="btn-group">
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
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NOMR->Visible) { // NOMR ?>
	<tr id="r_NOMR">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NOMR"><?php echo $vw_bridging_sep_by_no_kartu->NOMR->FldCaption() ?></span></td>
		<td data-name="NOMR"<?php echo $vw_bridging_sep_by_no_kartu->NOMR->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NOMR">
<span<?php echo $vw_bridging_sep_by_no_kartu->NOMR->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NOMR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDPOLY->Visible) { // KDPOLY ?>
	<tr id="r_KDPOLY">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_KDPOLY"><?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->FldCaption() ?></span></td>
		<td data-name="KDPOLY"<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KDPOLY">
<span<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->KDPOLY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<tr id="r_KDCARABAYAR">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_KDCARABAYAR"><?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->FldCaption() ?></span></td>
		<td data-name="KDCARABAYAR"<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KDCARABAYAR">
<span<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NIP->Visible) { // NIP ?>
	<tr id="r_NIP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NIP"><?php echo $vw_bridging_sep_by_no_kartu->NIP->FldCaption() ?></span></td>
		<td data-name="NIP"<?php echo $vw_bridging_sep_by_no_kartu->NIP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NIP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NIP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NIP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TGLREG->Visible) { // TGLREG ?>
	<tr id="r_TGLREG">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_TGLREG"><?php echo $vw_bridging_sep_by_no_kartu->TGLREG->FldCaption() ?></span></td>
		<td data-name="TGLREG"<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_TGLREG">
<span<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->TGLREG->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->JAMREG->Visible) { // JAMREG ?>
	<tr id="r_JAMREG">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_JAMREG"><?php echo $vw_bridging_sep_by_no_kartu->JAMREG->FldCaption() ?></span></td>
		<td data-name="JAMREG"<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_JAMREG">
<span<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NO_SJP->Visible) { // NO_SJP ?>
	<tr id="r_NO_SJP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NO_SJP"><?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->FldCaption() ?></span></td>
		<td data-name="NO_SJP"<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NO_SJP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NOKARTU->Visible) { // NOKARTU ?>
	<tr id="r_NOKARTU">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NOKARTU"><?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->FldCaption() ?></span></td>
		<td data-name="NOKARTU"<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NOKARTU">
<span<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TANGGAL_SEP->Visible) { // TANGGAL_SEP ?>
	<tr id="r_TANGGAL_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_TANGGAL_SEP"><?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->FldCaption() ?></span></td>
		<td data-name="TANGGAL_SEP"<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_TANGGAL_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->TANGGAL_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->Visible) { // TANGGALRUJUK_SEP ?>
	<tr id="r_TANGGALRUJUK_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP"><?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->FldCaption() ?></span></td>
		<td data-name="TANGGALRUJUK_SEP"<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_TANGGALRUJUK_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->TANGGALRUJUK_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->Visible) { // KELASRAWAT_SEP ?>
	<tr id="r_KELASRAWAT_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP"><?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->FldCaption() ?></span></td>
		<td data-name="KELASRAWAT_SEP"<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KELASRAWAT_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->KELASRAWAT_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->Visible) { // NORUJUKAN_SEP ?>
	<tr id="r_NORUJUKAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->FldCaption() ?></span></td>
		<td data-name="NORUJUKAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NORUJUKAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NORUJUKAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->Visible) { // PPKPELAYANAN_SEP ?>
	<tr id="r_PPKPELAYANAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->FldCaption() ?></span></td>
		<td data-name="PPKPELAYANAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PPKPELAYANAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PPKPELAYANAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->Visible) { // JENISPERAWATAN_SEP ?>
	<tr id="r_JENISPERAWATAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->FldCaption() ?></span></td>
		<td data-name="JENISPERAWATAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_JENISPERAWATAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->JENISPERAWATAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->CATATAN_SEP->Visible) { // CATATAN_SEP ?>
	<tr id="r_CATATAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_CATATAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->FldCaption() ?></span></td>
		<td data-name="CATATAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_CATATAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->CATATAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->Visible) { // DIAGNOSAAWAL_SEP ?>
	<tr id="r_DIAGNOSAAWAL_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP"><?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->FldCaption() ?></span></td>
		<td data-name="DIAGNOSAAWAL_SEP"<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_DIAGNOSAAWAL_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->DIAGNOSAAWAL_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->Visible) { // NAMADIAGNOSA_SEP ?>
	<tr id="r_NAMADIAGNOSA_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP"><?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->FldCaption() ?></span></td>
		<td data-name="NAMADIAGNOSA_SEP"<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NAMADIAGNOSA_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NAMADIAGNOSA_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->Visible) { // LAKALANTAS_SEP ?>
	<tr id="r_LAKALANTAS_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP"><?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->FldCaption() ?></span></td>
		<td data-name="LAKALANTAS_SEP"<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_LAKALANTAS_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->LAKALANTAS_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->Visible) { // LOKASILAKALANTAS ?>
	<tr id="r_LOKASILAKALANTAS">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS"><?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->FldCaption() ?></span></td>
		<td data-name="LOKASILAKALANTAS"<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_LOKASILAKALANTAS">
<span<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->LOKASILAKALANTAS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->USER->Visible) { // USER ?>
	<tr id="r_USER">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_USER"><?php echo $vw_bridging_sep_by_no_kartu->USER->FldCaption() ?></span></td>
		<td data-name="USER"<?php echo $vw_bridging_sep_by_no_kartu->USER->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_USER">
<span<?php echo $vw_bridging_sep_by_no_kartu->USER->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->USER->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->Visible) { // PESERTANIK_SEP ?>
	<tr id="r_PESERTANIK_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->FldCaption() ?></span></td>
		<td data-name="PESERTANIK_SEP"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANIK_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->ViewAttributes() ?>>
<?php if ((!ew_EmptyStr($vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->TooltipValue)) && $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->LinkAttributes() <> "") { ?>
<a<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->LinkAttributes() ?>><?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->ViewValue ?></a>
<?php } else { ?>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->ViewValue ?>
<?php } ?>
<span id="tt_vw_bridging_sep_by_no_kartu_x_PESERTANIK_SEP" style="display: none">
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANIK_SEP->TooltipValue ?>
</span></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->Visible) { // PESERTANAMA_SEP ?>
	<tr id="r_PESERTANAMA_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->FldCaption() ?></span></td>
		<td data-name="PESERTANAMA_SEP"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMA_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMA_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->Visible) { // PESERTAJENISKELAMIN_SEP ?>
	<tr id="r_PESERTAJENISKELAMIN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->FldCaption() ?></span></td>
		<td data-name="PESERTAJENISKELAMIN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAJENISKELAMIN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISKELAMIN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->Visible) { // PESERTANAMAKELAS_SEP ?>
	<tr id="r_PESERTANAMAKELAS_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->FldCaption() ?></span></td>
		<td data-name="PESERTANAMAKELAS_SEP"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMAKELAS_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAKELAS_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAPISAT->Visible) { // PESERTAPISAT ?>
	<tr id="r_PESERTAPISAT">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTAPISAT"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->FldCaption() ?></span></td>
		<td data-name="PESERTAPISAT"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAPISAT">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAPISAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->Visible) { // PESERTATGLLAHIR ?>
	<tr id="r_PESERTATGLLAHIR">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR"><?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->FldCaption() ?></span></td>
		<td data-name="PESERTATGLLAHIR"<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTATGLLAHIR">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTATGLLAHIR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->Visible) { // PESERTAJENISPESERTA_SEP ?>
	<tr id="r_PESERTAJENISPESERTA_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP"><?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->FldCaption() ?></span></td>
		<td data-name="PESERTAJENISPESERTA_SEP"<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTAJENISPESERTA_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTAJENISPESERTA_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->Visible) { // PESERTANAMAJENISPESERTA_SEP ?>
	<tr id="r_PESERTANAMAJENISPESERTA_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP"><?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->FldCaption() ?></span></td>
		<td data-name="PESERTANAMAJENISPESERTA_SEP"<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_PESERTANAMAJENISPESERTA_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->PESERTANAMAJENISPESERTA_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->Visible) { // POLITUJUAN_SEP ?>
	<tr id="r_POLITUJUAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->FldCaption() ?></span></td>
		<td data-name="POLITUJUAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_POLITUJUAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->POLITUJUAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->Visible) { // NAMAPOLITUJUAN_SEP ?>
	<tr id="r_NAMAPOLITUJUAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->FldCaption() ?></span></td>
		<td data-name="NAMAPOLITUJUAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NAMAPOLITUJUAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NAMAPOLITUJUAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->Visible) { // KDPPKRUJUKAN_SEP ?>
	<tr id="r_KDPPKRUJUKAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->FldCaption() ?></span></td>
		<td data-name="KDPPKRUJUKAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_KDPPKRUJUKAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->KDPPKRUJUKAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->Visible) { // NMPPKRUJUKAN_SEP ?>
	<tr id="r_NMPPKRUJUKAN_SEP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP"><?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->FldCaption() ?></span></td>
		<td data-name="NMPPKRUJUKAN_SEP"<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_NMPPKRUJUKAN_SEP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NMPPKRUJUKAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->pasien_NOTELP->Visible) { // pasien_NOTELP ?>
	<tr id="r_pasien_NOTELP">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_pasien_NOTELP"><?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->FldCaption() ?></span></td>
		<td data-name="pasien_NOTELP"<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_pasien_NOTELP">
<span<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->pasien_NOTELP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->penjamin_kkl_id->Visible) { // penjamin_kkl_id ?>
	<tr id="r_penjamin_kkl_id">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_penjamin_kkl_id"><?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->FldCaption() ?></span></td>
		<td data-name="penjamin_kkl_id"<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_penjamin_kkl_id">
<span<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->penjamin_kkl_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->Visible) { // asalfaskesrujukan_id ?>
	<tr id="r_asalfaskesrujukan_id">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id"><?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->FldCaption() ?></span></td>
		<td data-name="asalfaskesrujukan_id"<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_asalfaskesrujukan_id">
<span<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->asalfaskesrujukan_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->peserta_cob->Visible) { // peserta_cob ?>
	<tr id="r_peserta_cob">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_peserta_cob"><?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->FldCaption() ?></span></td>
		<td data-name="peserta_cob"<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_peserta_cob">
<span<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->peserta_cob->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<tr id="r_poli_eksekutif">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_poli_eksekutif"><?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->FldCaption() ?></span></td>
		<td data-name="poli_eksekutif"<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_poli_eksekutif">
<span<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->poli_eksekutif->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->Visible) { // status_kepesertaan_BPJS ?>
	<tr id="r_status_kepesertaan_BPJS">
		<td><span id="elh_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS"><?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->FldCaption() ?></span></td>
		<td data-name="status_kepesertaan_BPJS"<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->CellAttributes() ?>>
<span id="el_vw_bridging_sep_by_no_kartu_status_kepesertaan_BPJS">
<span<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->status_kepesertaan_BPJS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fvw_bridging_sep_by_no_kartuview.Init();
</script>
<?php
$vw_bridging_sep_by_no_kartu_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bridging_sep_by_no_kartu_view->Page_Terminate();
?>
