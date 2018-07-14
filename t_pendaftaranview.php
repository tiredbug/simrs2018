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

$t_pendaftaran_view = NULL; // Initialize page object first

class ct_pendaftaran_view extends ct_pendaftaran {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_pendaftaran';

	// Page object name
	var $PageObjName = 't_pendaftaran_view';

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

		// Table object (t_pendaftaran)
		if (!isset($GLOBALS["t_pendaftaran"]) || get_class($GLOBALS["t_pendaftaran"]) == "ct_pendaftaran") {
			$GLOBALS["t_pendaftaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_pendaftaran"];
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
		$this->IDXDAFTAR->SetVisibility();
		$this->IDXDAFTAR->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->TGLREG->SetVisibility();
		$this->NOMR->SetVisibility();
		$this->pasien_TITLE->SetVisibility();
		$this->pasien_NAMA->SetVisibility();
		$this->pasien_ALAMAT->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->KDDOKTER->SetVisibility();
		$this->KDRUJUK->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->SHIFT->SetVisibility();
		$this->PASIENBARU->SetVisibility();
		$this->NIP->SetVisibility();
		$this->MASUKPOLY->SetVisibility();
		$this->KELUARPOLY->SetVisibility();
		$this->KETRUJUK->SetVisibility();
		$this->JAMREG->SetVisibility();
		$this->NO_SJP->SetVisibility();
		$this->NOKARTU->SetVisibility();
		$this->TANGGAL_SEP->SetVisibility();
		$this->TANGGALRUJUK_SEP->SetVisibility();
		$this->biaya_obat_2->SetVisibility();
		$this->biaya_retur_obat_2->SetVisibility();
		$this->TOTAL_BIAYA_OBAT_2->SetVisibility();
		$this->KDCARABAYAR2->SetVisibility();

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
				$sReturnUrl = "t_pendaftaranlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t_pendaftaranlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "t_pendaftaranlist.php"; // Not page request, return to list
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

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

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
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->pasien_TITLE->setDbValue($rs->fields('pasien_TITLE'));
		$this->pasien_NAMA->setDbValue($rs->fields('pasien_NAMA'));
		$this->pasien_ALAMAT->setDbValue($rs->fields('pasien_ALAMAT'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NOJAMINAN->setDbValue($rs->fields('NOJAMINAN'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->KETERANGAN_STATUS->setDbValue($rs->fields('KETERANGAN_STATUS'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
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
		$this->pasien_TEMPAT->setDbValue($rs->fields('pasien_TEMPAT'));
		$this->pasien_TGLLAHIR->setDbValue($rs->fields('pasien_TGLLAHIR'));
		$this->pasien_JENISKELAMIN->setDbValue($rs->fields('pasien_JENISKELAMIN'));
		$this->pasien_KDPROVINSI->setDbValue($rs->fields('pasien_KDPROVINSI'));
		$this->pasien_KOTA->setDbValue($rs->fields('pasien_KOTA'));
		$this->pasien_KDKECAMATAN->setDbValue($rs->fields('pasien_KDKECAMATAN'));
		$this->pasien_KELURAHAN->setDbValue($rs->fields('pasien_KELURAHAN'));
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
		$this->biaya_obat_2->setDbValue($rs->fields('biaya_obat_2'));
		$this->biaya_retur_obat_2->setDbValue($rs->fields('biaya_retur_obat_2'));
		$this->TOTAL_BIAYA_OBAT_2->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_2'));
		$this->KDCARABAYAR2->setDbValue($rs->fields('KDCARABAYAR2'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->pasien_TITLE->DbValue = $row['pasien_TITLE'];
		$this->pasien_NAMA->DbValue = $row['pasien_NAMA'];
		$this->pasien_ALAMAT->DbValue = $row['pasien_ALAMAT'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->KDDOKTER->DbValue = $row['KDDOKTER'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NOJAMINAN->DbValue = $row['NOJAMINAN'];
		$this->SHIFT->DbValue = $row['SHIFT'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->KETERANGAN_STATUS->DbValue = $row['KETERANGAN_STATUS'];
		$this->PASIENBARU->DbValue = $row['PASIENBARU'];
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
		$this->pasien_TEMPAT->DbValue = $row['pasien_TEMPAT'];
		$this->pasien_TGLLAHIR->DbValue = $row['pasien_TGLLAHIR'];
		$this->pasien_JENISKELAMIN->DbValue = $row['pasien_JENISKELAMIN'];
		$this->pasien_KDPROVINSI->DbValue = $row['pasien_KDPROVINSI'];
		$this->pasien_KOTA->DbValue = $row['pasien_KOTA'];
		$this->pasien_KDKECAMATAN->DbValue = $row['pasien_KDKECAMATAN'];
		$this->pasien_KELURAHAN->DbValue = $row['pasien_KELURAHAN'];
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
		$this->biaya_obat_2->DbValue = $row['biaya_obat_2'];
		$this->biaya_retur_obat_2->DbValue = $row['biaya_retur_obat_2'];
		$this->TOTAL_BIAYA_OBAT_2->DbValue = $row['TOTAL_BIAYA_OBAT_2'];
		$this->KDCARABAYAR2->DbValue = $row['KDCARABAYAR2'];
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

		// Convert decimal values if posted back
		if ($this->biaya_obat_2->FormValue == $this->biaya_obat_2->CurrentValue && is_numeric(ew_StrToFloat($this->biaya_obat_2->CurrentValue)))
			$this->biaya_obat_2->CurrentValue = ew_StrToFloat($this->biaya_obat_2->CurrentValue);

		// Convert decimal values if posted back
		if ($this->biaya_retur_obat_2->FormValue == $this->biaya_retur_obat_2->CurrentValue && is_numeric(ew_StrToFloat($this->biaya_retur_obat_2->CurrentValue)))
			$this->biaya_retur_obat_2->CurrentValue = ew_StrToFloat($this->biaya_retur_obat_2->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOTAL_BIAYA_OBAT_2->FormValue == $this->TOTAL_BIAYA_OBAT_2->CurrentValue && is_numeric(ew_StrToFloat($this->TOTAL_BIAYA_OBAT_2->CurrentValue)))
			$this->TOTAL_BIAYA_OBAT_2->CurrentValue = ew_StrToFloat($this->TOTAL_BIAYA_OBAT_2->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXDAFTAR
		// TGLREG
		// NOMR
		// pasien_TITLE
		// pasien_NAMA
		// pasien_ALAMAT
		// KDPOLY
		// KDDOKTER
		// KDRUJUK
		// KDCARABAYAR
		// NOJAMINAN
		// SHIFT
		// STATUS
		// KETERANGAN_STATUS
		// PASIENBARU
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
		// pasien_TEMPAT
		// pasien_TGLLAHIR
		// pasien_JENISKELAMIN
		// pasien_KDPROVINSI
		// pasien_KOTA
		// pasien_KDKECAMATAN
		// pasien_KELURAHAN
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
		// biaya_obat_2
		// biaya_retur_obat_2
		// TOTAL_BIAYA_OBAT_2
		// KDCARABAYAR2

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 7);
		$this->TGLREG->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array("dx1" => '`NOMR`', "dx2" => '`NAMA`', "dx3" => '`ALAMAT`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// pasien_TITLE
		if (strval($this->pasien_TITLE->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_TITLE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
		$sWhereWrk = "";
		$this->pasien_TITLE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_TITLE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->CurrentValue;
			}
		} else {
			$this->pasien_TITLE->ViewValue = NULL;
		}
		$this->pasien_TITLE->ViewCustomAttributes = "";

		// pasien_NAMA
		$this->pasien_NAMA->ViewValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_NAMA->ViewCustomAttributes = "";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->ViewValue = $this->pasien_ALAMAT->CurrentValue;
		$this->pasien_ALAMAT->ViewCustomAttributes = "";

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

		// NOJAMINAN
		$this->NOJAMINAN->ViewValue = $this->NOJAMINAN->CurrentValue;
		$this->NOJAMINAN->ViewCustomAttributes = "";

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

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->ViewValue = $this->KETERANGAN_STATUS->CurrentValue;
		$this->KETERANGAN_STATUS->ViewCustomAttributes = "";

		// PASIENBARU
		$this->PASIENBARU->ViewValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->ViewCustomAttributes = "";

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

		// KETRUJUK
		$this->KETRUJUK->ViewValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// KETBAYAR
		$this->KETBAYAR->ViewValue = $this->KETBAYAR->CurrentValue;
		$this->KETBAYAR->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->ViewValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->ViewValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->ViewValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->ViewValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->ViewValue = ew_FormatDateTime($this->JAMREG->ViewValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// BATAL
		$this->BATAL->ViewValue = $this->BATAL->CurrentValue;
		$this->BATAL->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NO_PESERTA
		$this->NO_PESERTA->ViewValue = $this->NO_PESERTA->CurrentValue;
		$this->NO_PESERTA->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->ViewValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->ViewCustomAttributes = "";

		// biaya_obat
		$this->biaya_obat->ViewValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->ViewCustomAttributes = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->ViewValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->ViewValue = $this->TOTAL_BIAYA_OBAT_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_RAJAL->ViewCustomAttributes = "";

		// biaya_obat_rajal
		$this->biaya_obat_rajal->ViewValue = $this->biaya_obat_rajal->CurrentValue;
		$this->biaya_obat_rajal->ViewCustomAttributes = "";

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->ViewValue = $this->biaya_retur_obat_rajal->CurrentValue;
		$this->biaya_retur_obat_rajal->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->ViewValue = $this->TOTAL_BIAYA_OBAT_IGD->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IGD->ViewCustomAttributes = "";

		// biaya_obat_igd
		$this->biaya_obat_igd->ViewValue = $this->biaya_obat_igd->CurrentValue;
		$this->biaya_obat_igd->ViewCustomAttributes = "";

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->ViewValue = $this->biaya_retur_obat_igd->CurrentValue;
		$this->biaya_retur_obat_igd->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->ViewValue = $this->TOTAL_BIAYA_OBAT_IBS->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IBS->ViewCustomAttributes = "";

		// biaya_obat_ibs
		$this->biaya_obat_ibs->ViewValue = $this->biaya_obat_ibs->CurrentValue;
		$this->biaya_obat_ibs->ViewCustomAttributes = "";

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->ViewValue = $this->biaya_retur_obat_ibs->CurrentValue;
		$this->biaya_retur_obat_ibs->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->ViewValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->ViewValue = ew_FormatDateTime($this->TANGGAL_SEP->ViewValue, 0);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->ViewValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->ViewValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->ViewValue, 0);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->ViewValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// MINTA_RUJUKAN
		if (strval($this->MINTA_RUJUKAN->CurrentValue) <> "") {
			$this->MINTA_RUJUKAN->ViewValue = "";
			$arwrk = explode(",", strval($this->MINTA_RUJUKAN->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->MINTA_RUJUKAN->ViewValue .= $this->MINTA_RUJUKAN->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->MINTA_RUJUKAN->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->MINTA_RUJUKAN->ViewValue = NULL;
		}
		$this->MINTA_RUJUKAN->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->ViewValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->ViewValue = $this->PPKRUJUKANASAL_SEP->CurrentValue;
		$this->PPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->ViewValue = $this->NAMAPPKRUJUKANASAL_SEP->CurrentValue;
		$this->NAMAPPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->ViewValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->CurrentValue;
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
		$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->CurrentValue;
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->ViewValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->ViewValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->ViewValue = $this->cek_data_kepesertaan->CurrentValue;
		$this->cek_data_kepesertaan->ViewCustomAttributes = "";

		// generate_sep
		$this->generate_sep->ViewValue = $this->generate_sep->CurrentValue;
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

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->ViewValue = $this->PESERTATGLCETAKKARTU_SEP->CurrentValue;
		$this->PESERTATGLCETAKKARTU_SEP->ViewValue = ew_FormatDateTime($this->PESERTATGLCETAKKARTU_SEP->ViewValue, 0);
		$this->PESERTATGLCETAKKARTU_SEP->ViewCustomAttributes = "";

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

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->ViewValue = $this->UPDATETGLPLNG_SEP->CurrentValue;
		$this->UPDATETGLPLNG_SEP->ViewValue = ew_FormatDateTime($this->UPDATETGLPLNG_SEP->ViewValue, 0);
		$this->UPDATETGLPLNG_SEP->ViewCustomAttributes = "";

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->ViewValue = $this->bridging_upt_tglplng->CurrentValue;
		$this->bridging_upt_tglplng->ViewCustomAttributes = "";

		// mapingtransaksi
		$this->mapingtransaksi->ViewValue = $this->mapingtransaksi->CurrentValue;
		$this->mapingtransaksi->ViewCustomAttributes = "";

		// bridging_no_rujukan
		$this->bridging_no_rujukan->ViewValue = $this->bridging_no_rujukan->CurrentValue;
		$this->bridging_no_rujukan->ViewCustomAttributes = "";

		// bridging_hapus_sep
		$this->bridging_hapus_sep->ViewValue = $this->bridging_hapus_sep->CurrentValue;
		$this->bridging_hapus_sep->ViewCustomAttributes = "";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->ViewValue = $this->bridging_kepesertaan_by_no_ka->CurrentValue;
		$this->bridging_kepesertaan_by_no_ka->ViewCustomAttributes = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->ViewValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->ViewCustomAttributes = "";

		// counter_cetak_kartu
		$this->counter_cetak_kartu->ViewValue = $this->counter_cetak_kartu->CurrentValue;
		$this->counter_cetak_kartu->ViewCustomAttributes = "";

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->ViewValue = $this->bridging_kepesertaan_by_nik->CurrentValue;
		$this->bridging_kepesertaan_by_nik->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->ViewValue = $this->bridging_by_no_rujukan->CurrentValue;
		$this->bridging_by_no_rujukan->ViewCustomAttributes = "";

		// maping_hapus_sep
		$this->maping_hapus_sep->ViewValue = $this->maping_hapus_sep->CurrentValue;
		$this->maping_hapus_sep->ViewCustomAttributes = "";

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->ViewValue = $this->counter_cetak_kartu_ranap->CurrentValue;
		$this->counter_cetak_kartu_ranap->ViewCustomAttributes = "";

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->ViewValue = $this->BIAYA_PENDAFTARAN->CurrentValue;
		$this->BIAYA_PENDAFTARAN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->ViewValue = $this->BIAYA_TINDAKAN_POLI->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->ViewValue = $this->BIAYA_TINDAKAN_RADIOLOGI->CurrentValue;
		$this->BIAYA_TINDAKAN_RADIOLOGI->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->ViewValue = $this->BIAYA_TINDAKAN_LABORAT->CurrentValue;
		$this->BIAYA_TINDAKAN_LABORAT->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->ViewValue = $this->BIAYA_TINDAKAN_KONSULTASI->CurrentValue;
		$this->BIAYA_TINDAKAN_KONSULTASI->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->ViewValue = $this->BIAYA_TARIF_DOKTER->CurrentValue;
		$this->BIAYA_TARIF_DOKTER->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->ViewValue = $this->BIAYA_TARIF_DOKTER_KONSUL->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL->ViewCustomAttributes = "";

		// INCLUDE
		$this->INCLUDE->ViewValue = $this->INCLUDE->CurrentValue;
		$this->INCLUDE->ViewCustomAttributes = "";

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->ViewValue = $this->eklaim_kelas_rawat_rajal->CurrentValue;
		$this->eklaim_kelas_rawat_rajal->ViewCustomAttributes = "";

		// eklaim_adl_score
		$this->eklaim_adl_score->ViewValue = $this->eklaim_adl_score->CurrentValue;
		$this->eklaim_adl_score->ViewCustomAttributes = "";

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->ViewValue = $this->eklaim_adl_sub_acute->CurrentValue;
		$this->eklaim_adl_sub_acute->ViewCustomAttributes = "";

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->ViewValue = $this->eklaim_adl_chronic->CurrentValue;
		$this->eklaim_adl_chronic->ViewCustomAttributes = "";

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->ViewValue = $this->eklaim_icu_indikator->CurrentValue;
		$this->eklaim_icu_indikator->ViewCustomAttributes = "";

		// eklaim_icu_los
		$this->eklaim_icu_los->ViewValue = $this->eklaim_icu_los->CurrentValue;
		$this->eklaim_icu_los->ViewCustomAttributes = "";

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->ViewValue = $this->eklaim_ventilator_hour->CurrentValue;
		$this->eklaim_ventilator_hour->ViewCustomAttributes = "";

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->ViewValue = $this->eklaim_upgrade_class_ind->CurrentValue;
		$this->eklaim_upgrade_class_ind->ViewCustomAttributes = "";

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->ViewValue = $this->eklaim_upgrade_class_class->CurrentValue;
		$this->eklaim_upgrade_class_class->ViewCustomAttributes = "";

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->ViewValue = $this->eklaim_upgrade_class_los->CurrentValue;
		$this->eklaim_upgrade_class_los->ViewCustomAttributes = "";

		// eklaim_birth_weight
		$this->eklaim_birth_weight->ViewValue = $this->eklaim_birth_weight->CurrentValue;
		$this->eklaim_birth_weight->ViewCustomAttributes = "";

		// eklaim_discharge_status
		$this->eklaim_discharge_status->ViewValue = $this->eklaim_discharge_status->CurrentValue;
		$this->eklaim_discharge_status->ViewCustomAttributes = "";

		// eklaim_diagnosa
		$this->eklaim_diagnosa->ViewValue = $this->eklaim_diagnosa->CurrentValue;
		$this->eklaim_diagnosa->ViewCustomAttributes = "";

		// eklaim_procedure
		$this->eklaim_procedure->ViewValue = $this->eklaim_procedure->CurrentValue;
		$this->eklaim_procedure->ViewCustomAttributes = "";

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->ViewValue = $this->eklaim_tarif_rs->CurrentValue;
		$this->eklaim_tarif_rs->ViewCustomAttributes = "";

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->ViewValue = $this->eklaim_tarif_poli_eks->CurrentValue;
		$this->eklaim_tarif_poli_eks->ViewCustomAttributes = "";

		// eklaim_id_dokter
		$this->eklaim_id_dokter->ViewValue = $this->eklaim_id_dokter->CurrentValue;
		$this->eklaim_id_dokter->ViewCustomAttributes = "";

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->ViewValue = $this->eklaim_nama_dokter->CurrentValue;
		$this->eklaim_nama_dokter->ViewCustomAttributes = "";

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->ViewValue = $this->eklaim_kode_tarif->CurrentValue;
		$this->eklaim_kode_tarif->ViewCustomAttributes = "";

		// eklaim_payor_id
		$this->eklaim_payor_id->ViewValue = $this->eklaim_payor_id->CurrentValue;
		$this->eklaim_payor_id->ViewCustomAttributes = "";

		// eklaim_payor_cd
		$this->eklaim_payor_cd->ViewValue = $this->eklaim_payor_cd->CurrentValue;
		$this->eklaim_payor_cd->ViewCustomAttributes = "";

		// eklaim_coder_nik
		$this->eklaim_coder_nik->ViewValue = $this->eklaim_coder_nik->CurrentValue;
		$this->eklaim_coder_nik->ViewCustomAttributes = "";

		// eklaim_los
		$this->eklaim_los->ViewValue = $this->eklaim_los->CurrentValue;
		$this->eklaim_los->ViewCustomAttributes = "";

		// eklaim_patient_id
		$this->eklaim_patient_id->ViewValue = $this->eklaim_patient_id->CurrentValue;
		$this->eklaim_patient_id->ViewCustomAttributes = "";

		// eklaim_admission_id
		$this->eklaim_admission_id->ViewValue = $this->eklaim_admission_id->CurrentValue;
		$this->eklaim_admission_id->ViewCustomAttributes = "";

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->ViewValue = $this->eklaim_hospital_admission_id->CurrentValue;
		$this->eklaim_hospital_admission_id->ViewCustomAttributes = "";

		// bridging_hapussep
		$this->bridging_hapussep->ViewValue = $this->bridging_hapussep->CurrentValue;
		$this->bridging_hapussep->ViewCustomAttributes = "";

		// user_penghapus_sep
		$this->user_penghapus_sep->ViewValue = $this->user_penghapus_sep->CurrentValue;
		$this->user_penghapus_sep->ViewCustomAttributes = "";

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->ViewValue = $this->BIAYA_BILLING_RAJAL->CurrentValue;
		$this->BIAYA_BILLING_RAJAL->ViewCustomAttributes = "";

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->ViewValue = $this->STATUS_PEMBAYARAN->CurrentValue;
		$this->STATUS_PEMBAYARAN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->ViewValue = $this->BIAYA_TINDAKAN_FISIOTERAPI->CurrentValue;
		$this->BIAYA_TINDAKAN_FISIOTERAPI->ViewCustomAttributes = "";

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->ViewValue = $this->eklaim_reg_pasien->CurrentValue;
		$this->eklaim_reg_pasien->ViewCustomAttributes = "";

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->ViewValue = $this->eklaim_reg_klaim_baru->CurrentValue;
		$this->eklaim_reg_klaim_baru->ViewCustomAttributes = "";

		// eklaim_gruper1
		$this->eklaim_gruper1->ViewValue = $this->eklaim_gruper1->CurrentValue;
		$this->eklaim_gruper1->ViewCustomAttributes = "";

		// eklaim_gruper2
		$this->eklaim_gruper2->ViewValue = $this->eklaim_gruper2->CurrentValue;
		$this->eklaim_gruper2->ViewCustomAttributes = "";

		// eklaim_finalklaim
		$this->eklaim_finalklaim->ViewValue = $this->eklaim_finalklaim->CurrentValue;
		$this->eklaim_finalklaim->ViewCustomAttributes = "";

		// eklaim_sendklaim
		$this->eklaim_sendklaim->ViewValue = $this->eklaim_sendklaim->CurrentValue;
		$this->eklaim_sendklaim->ViewCustomAttributes = "";

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->ViewValue = $this->eklaim_flag_hapus_pasien->CurrentValue;
		$this->eklaim_flag_hapus_pasien->ViewCustomAttributes = "";

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->ViewValue = $this->eklaim_flag_hapus_klaim->CurrentValue;
		$this->eklaim_flag_hapus_klaim->ViewCustomAttributes = "";

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->ViewValue = $this->eklaim_kemkes_dc_Status->CurrentValue;
		$this->eklaim_kemkes_dc_Status->ViewCustomAttributes = "";

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->ViewValue = $this->eklaim_bpjs_dc_Status->CurrentValue;
		$this->eklaim_bpjs_dc_Status->ViewCustomAttributes = "";

		// eklaim_cbg_code
		$this->eklaim_cbg_code->ViewValue = $this->eklaim_cbg_code->CurrentValue;
		$this->eklaim_cbg_code->ViewCustomAttributes = "";

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->ViewValue = $this->eklaim_cbg_descprition->CurrentValue;
		$this->eklaim_cbg_descprition->ViewCustomAttributes = "";

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->ViewValue = $this->eklaim_cbg_tariff->CurrentValue;
		$this->eklaim_cbg_tariff->ViewCustomAttributes = "";

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->ViewValue = $this->eklaim_sub_acute_code->CurrentValue;
		$this->eklaim_sub_acute_code->ViewCustomAttributes = "";

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->ViewValue = $this->eklaim_sub_acute_deskripsi->CurrentValue;
		$this->eklaim_sub_acute_deskripsi->ViewCustomAttributes = "";

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->ViewValue = $this->eklaim_sub_acute_tariff->CurrentValue;
		$this->eklaim_sub_acute_tariff->ViewCustomAttributes = "";

		// eklaim_chronic_code
		$this->eklaim_chronic_code->ViewValue = $this->eklaim_chronic_code->CurrentValue;
		$this->eklaim_chronic_code->ViewCustomAttributes = "";

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->ViewValue = $this->eklaim_chronic_deskripsi->CurrentValue;
		$this->eklaim_chronic_deskripsi->ViewCustomAttributes = "";

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->ViewValue = $this->eklaim_chronic_tariff->CurrentValue;
		$this->eklaim_chronic_tariff->ViewCustomAttributes = "";

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->ViewValue = $this->eklaim_inacbg_version->CurrentValue;
		$this->eklaim_inacbg_version->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_IBS_RAJAL->ViewCustomAttributes = "";

		// VERIFY_ICD
		$this->VERIFY_ICD->ViewValue = $this->VERIFY_ICD->CurrentValue;
		$this->VERIFY_ICD->ViewCustomAttributes = "";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->ViewValue = $this->bridging_rujukan_faskes_2->CurrentValue;
		$this->bridging_rujukan_faskes_2->ViewCustomAttributes = "";

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->ViewValue = $this->eklaim_reedit_claim->CurrentValue;
		$this->eklaim_reedit_claim->ViewCustomAttributes = "";

		// KETERANGAN
		$this->KETERANGAN->ViewValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->ViewCustomAttributes = "";

		// TGLLAHIR
		$this->TGLLAHIR->ViewValue = $this->TGLLAHIR->CurrentValue;
		$this->TGLLAHIR->ViewValue = ew_FormatDateTime($this->TGLLAHIR->ViewValue, 0);
		$this->TGLLAHIR->ViewCustomAttributes = "";

		// USER_KASIR
		$this->USER_KASIR->ViewValue = $this->USER_KASIR->CurrentValue;
		$this->USER_KASIR->ViewCustomAttributes = "";

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->ViewValue = $this->eklaim_tgl_gruping->CurrentValue;
		$this->eklaim_tgl_gruping->ViewValue = ew_FormatDateTime($this->eklaim_tgl_gruping->ViewValue, 0);
		$this->eklaim_tgl_gruping->ViewCustomAttributes = "";

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->ViewValue = $this->eklaim_tgl_finalklaim->CurrentValue;
		$this->eklaim_tgl_finalklaim->ViewValue = ew_FormatDateTime($this->eklaim_tgl_finalklaim->ViewValue, 0);
		$this->eklaim_tgl_finalklaim->ViewCustomAttributes = "";

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->ViewValue = $this->eklaim_tgl_kirim_klaim->CurrentValue;
		$this->eklaim_tgl_kirim_klaim->ViewValue = ew_FormatDateTime($this->eklaim_tgl_kirim_klaim->ViewValue, 0);
		$this->eklaim_tgl_kirim_klaim->ViewCustomAttributes = "";

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->ViewValue = $this->BIAYA_OBAT_RS->CurrentValue;
		$this->BIAYA_OBAT_RS->ViewCustomAttributes = "";

		// EKG_RAJAL
		$this->EKG_RAJAL->ViewValue = $this->EKG_RAJAL->CurrentValue;
		$this->EKG_RAJAL->ViewCustomAttributes = "";

		// USG_RAJAL
		$this->USG_RAJAL->ViewValue = $this->USG_RAJAL->CurrentValue;
		$this->USG_RAJAL->ViewCustomAttributes = "";

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->ViewValue = $this->FISIOTERAPI_RAJAL->CurrentValue;
		$this->FISIOTERAPI_RAJAL->ViewCustomAttributes = "";

		// BHP_RAJAL
		$this->BHP_RAJAL->ViewValue = $this->BHP_RAJAL->CurrentValue;
		$this->BHP_RAJAL->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->ViewCustomAttributes = "";

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->ViewValue = $this->TOTAL_BIAYA_IBS_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_IBS_RAJAL->ViewCustomAttributes = "";

		// ORDER_LAB
		$this->ORDER_LAB->ViewValue = $this->ORDER_LAB->CurrentValue;
		$this->ORDER_LAB->ViewCustomAttributes = "";

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->ViewValue = $this->BILL_RAJAL_SELESAI->CurrentValue;
		$this->BILL_RAJAL_SELESAI->ViewCustomAttributes = "";

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->ViewValue = $this->INCLUDE_IDXDAFTAR->CurrentValue;
		$this->INCLUDE_IDXDAFTAR->ViewCustomAttributes = "";

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->ViewValue = $this->INCLUDE_HARGA->CurrentValue;
		$this->INCLUDE_HARGA->ViewCustomAttributes = "";

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->ViewValue = $this->TARIF_JASA_SARANA->CurrentValue;
		$this->TARIF_JASA_SARANA->ViewCustomAttributes = "";

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->ViewValue = $this->TARIF_PENUNJANG_NON_MEDIS->CurrentValue;
		$this->TARIF_PENUNJANG_NON_MEDIS->ViewCustomAttributes = "";

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->ViewValue = $this->TARIF_ASUHAN_KEPERAWATAN->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN->ViewCustomAttributes = "";

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->ViewValue = $this->KDDOKTER_RAJAL->CurrentValue;
		$this->KDDOKTER_RAJAL->ViewCustomAttributes = "";

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->ViewValue = $this->KDDOKTER_KONSUL_RAJAL->CurrentValue;
		$this->KDDOKTER_KONSUL_RAJAL->ViewCustomAttributes = "";

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->ViewValue = $this->BIAYA_BILLING_RS->CurrentValue;
		$this->BIAYA_BILLING_RS->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->ViewValue = $this->BIAYA_TINDAKAN_POLI_TMO->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_TMO->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->ViewValue = $this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->ViewCustomAttributes = "";

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->ViewValue = $this->BHP_RAJAL_TMO->CurrentValue;
		$this->BHP_RAJAL_TMO->ViewCustomAttributes = "";

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->ViewValue = $this->BHP_RAJAL_KEPERAWATAN->CurrentValue;
		$this->BHP_RAJAL_KEPERAWATAN->ViewCustomAttributes = "";

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->ViewValue = $this->TARIF_AKOMODASI->CurrentValue;
		$this->TARIF_AKOMODASI->ViewCustomAttributes = "";

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->ViewValue = $this->TARIF_AMBULAN->CurrentValue;
		$this->TARIF_AMBULAN->ViewCustomAttributes = "";

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->ViewValue = $this->TARIF_OKSIGEN->CurrentValue;
		$this->TARIF_OKSIGEN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->ViewValue = $this->BIAYA_TINDAKAN_JENAZAH->CurrentValue;
		$this->BIAYA_TINDAKAN_JENAZAH->ViewCustomAttributes = "";

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->ViewValue = $this->BIAYA_BILLING_IGD->CurrentValue;
		$this->BIAYA_BILLING_IGD->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->ViewValue = $this->BIAYA_TINDAKAN_POLI_PERSALINAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->ViewCustomAttributes = "";

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->ViewValue = $this->BHP_RAJAL_PERSALINAN->CurrentValue;
		$this->BHP_RAJAL_PERSALINAN->ViewCustomAttributes = "";

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->ViewValue = $this->TARIF_BIMBINGAN_ROHANI->CurrentValue;
		$this->TARIF_BIMBINGAN_ROHANI->ViewCustomAttributes = "";

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->ViewValue = $this->BIAYA_BILLING_RS2->CurrentValue;
		$this->BIAYA_BILLING_RS2->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_IGD->ViewCustomAttributes = "";

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->ViewValue = $this->BIAYA_PENDAFTARAN_IGD->CurrentValue;
		$this->BIAYA_PENDAFTARAN_IGD->ViewCustomAttributes = "";

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->ViewValue = $this->BIAYA_BILLING_IBS->CurrentValue;
		$this->BIAYA_BILLING_IBS->ViewCustomAttributes = "";

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->ViewValue = $this->TARIF_JASA_SARANA_IGD->CurrentValue;
		$this->TARIF_JASA_SARANA_IGD->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_KONSUL_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->ViewCustomAttributes = "";

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->ViewValue = $this->TARIF_MAKAN_IGD->CurrentValue;
		$this->TARIF_MAKAN_IGD->ViewCustomAttributes = "";

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->ViewValue = $this->TARIF_ASUHAN_KEPERAWATAN_IGD->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->ViewCustomAttributes = "";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->ViewValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TEMPAT->ViewCustomAttributes = "";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->ViewValue = $this->pasien_TGLLAHIR->CurrentValue;
		$this->pasien_TGLLAHIR->ViewValue = ew_FormatDateTime($this->pasien_TGLLAHIR->ViewValue, 7);
		$this->pasien_TGLLAHIR->ViewCustomAttributes = "";

		// pasien_JENISKELAMIN
		if (strval($this->pasien_JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->pasien_JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->pasien_JENISKELAMIN->ViewValue = NULL;
		}
		$this->pasien_JENISKELAMIN->ViewCustomAttributes = "";

		// pasien_KDPROVINSI
		if (strval($this->pasien_KDPROVINSI->CurrentValue) <> "") {
			$sFilterWrk = "`idprovinsi`" . ew_SearchString("=", $this->pasien_KDPROVINSI->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idprovinsi`, `namaprovinsi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_provinsi`";
		$sWhereWrk = "";
		$this->pasien_KDPROVINSI->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KDPROVINSI, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KDPROVINSI->ViewValue = $this->pasien_KDPROVINSI->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KDPROVINSI->ViewValue = $this->pasien_KDPROVINSI->CurrentValue;
			}
		} else {
			$this->pasien_KDPROVINSI->ViewValue = NULL;
		}
		$this->pasien_KDPROVINSI->ViewCustomAttributes = "";

		// pasien_KOTA
		if (strval($this->pasien_KOTA->CurrentValue) <> "") {
			$sFilterWrk = "`idkota`" . ew_SearchString("=", $this->pasien_KOTA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkota`, `namakota` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kota`";
		$sWhereWrk = "";
		$this->pasien_KOTA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KOTA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KOTA->ViewValue = $this->pasien_KOTA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KOTA->ViewValue = $this->pasien_KOTA->CurrentValue;
			}
		} else {
			$this->pasien_KOTA->ViewValue = NULL;
		}
		$this->pasien_KOTA->ViewCustomAttributes = "";

		// pasien_KDKECAMATAN
		if (strval($this->pasien_KDKECAMATAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkecamatan`" . ew_SearchString("=", $this->pasien_KDKECAMATAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkecamatan`, `namakecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kecamatan`";
		$sWhereWrk = "";
		$this->pasien_KDKECAMATAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KDKECAMATAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KDKECAMATAN->ViewValue = $this->pasien_KDKECAMATAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KDKECAMATAN->ViewValue = $this->pasien_KDKECAMATAN->CurrentValue;
			}
		} else {
			$this->pasien_KDKECAMATAN->ViewValue = NULL;
		}
		$this->pasien_KDKECAMATAN->ViewCustomAttributes = "";

		// pasien_KELURAHAN
		if (strval($this->pasien_KELURAHAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkelurahan`" . ew_SearchString("=", $this->pasien_KELURAHAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkelurahan`, `namakelurahan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kelurahan`";
		$sWhereWrk = "";
		$this->pasien_KELURAHAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KELURAHAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KELURAHAN->ViewValue = $this->pasien_KELURAHAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KELURAHAN->ViewValue = $this->pasien_KELURAHAN->CurrentValue;
			}
		} else {
			$this->pasien_KELURAHAN->ViewValue = NULL;
		}
		$this->pasien_KELURAHAN->ViewCustomAttributes = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->ViewValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->ViewCustomAttributes = "";

		// pasien_NOKTP
		$this->pasien_NOKTP->ViewValue = $this->pasien_NOKTP->CurrentValue;
		$this->pasien_NOKTP->ViewCustomAttributes = "";

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->ViewValue = $this->pasien_SUAMI_ORTU->CurrentValue;
		$this->pasien_SUAMI_ORTU->ViewCustomAttributes = "";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->ViewValue = $this->pasien_PEKERJAAN->CurrentValue;
		$this->pasien_PEKERJAAN->ViewCustomAttributes = "";

		// pasien_AGAMA
		if (strval($this->pasien_AGAMA->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
		$sWhereWrk = "";
		$this->pasien_AGAMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_AGAMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->CurrentValue;
			}
		} else {
			$this->pasien_AGAMA->ViewValue = NULL;
		}
		$this->pasien_AGAMA->ViewCustomAttributes = "";

		// pasien_PENDIDIKAN
		if (strval($this->pasien_PENDIDIKAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
		$sWhereWrk = "";
		$this->pasien_PENDIDIKAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->CurrentValue;
			}
		} else {
			$this->pasien_PENDIDIKAN->ViewValue = NULL;
		}
		$this->pasien_PENDIDIKAN->ViewCustomAttributes = "";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->ViewValue = $this->pasien_ALAMAT_KTP->CurrentValue;
		$this->pasien_ALAMAT_KTP->ViewCustomAttributes = "";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->ViewValue = $this->pasien_NO_KARTU->CurrentValue;
		$this->pasien_NO_KARTU->ViewCustomAttributes = "";

		// pasien_JNS_PASIEN
		if (strval($this->pasien_JNS_PASIEN->CurrentValue) <> "") {
			$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->pasien_JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
		$sWhereWrk = "";
		$this->pasien_JNS_PASIEN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->CurrentValue;
			}
		} else {
			$this->pasien_JNS_PASIEN->ViewValue = NULL;
		}
		$this->pasien_JNS_PASIEN->ViewCustomAttributes = "";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->ViewValue = $this->pasien_nama_ayah->CurrentValue;
		$this->pasien_nama_ayah->ViewCustomAttributes = "";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->ViewValue = $this->pasien_nama_ibu->CurrentValue;
		$this->pasien_nama_ibu->ViewCustomAttributes = "";

		// pasien_nama_suami
		$this->pasien_nama_suami->ViewValue = $this->pasien_nama_suami->CurrentValue;
		$this->pasien_nama_suami->ViewCustomAttributes = "";

		// pasien_nama_istri
		$this->pasien_nama_istri->ViewValue = $this->pasien_nama_istri->CurrentValue;
		$this->pasien_nama_istri->ViewCustomAttributes = "";

		// pasien_KD_ETNIS
		if (strval($this->pasien_KD_ETNIS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
		$sWhereWrk = "";
		$this->pasien_KD_ETNIS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_ETNIS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->CurrentValue;
			}
		} else {
			$this->pasien_KD_ETNIS->ViewValue = NULL;
		}
		$this->pasien_KD_ETNIS->ViewCustomAttributes = "";

		// pasien_KD_BHS_HARIAN
		if (strval($this->pasien_KD_BHS_HARIAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
		$sWhereWrk = "";
		$this->pasien_KD_BHS_HARIAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->CurrentValue;
			}
		} else {
			$this->pasien_KD_BHS_HARIAN->ViewValue = NULL;
		}
		$this->pasien_KD_BHS_HARIAN->ViewCustomAttributes = "";

		// biaya_obat_2
		$this->biaya_obat_2->ViewValue = $this->biaya_obat_2->CurrentValue;
		$this->biaya_obat_2->ViewCustomAttributes = "";

		// biaya_retur_obat_2
		$this->biaya_retur_obat_2->ViewValue = $this->biaya_retur_obat_2->CurrentValue;
		$this->biaya_retur_obat_2->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_2
		$this->TOTAL_BIAYA_OBAT_2->ViewValue = $this->TOTAL_BIAYA_OBAT_2->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_2->ViewCustomAttributes = "";

		// KDCARABAYAR2
		$this->KDCARABAYAR2->ViewValue = $this->KDCARABAYAR2->CurrentValue;
		$this->KDCARABAYAR2->ViewCustomAttributes = "";

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";
			$this->IDXDAFTAR->TooltipValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// pasien_TITLE
			$this->pasien_TITLE->LinkCustomAttributes = "";
			$this->pasien_TITLE->HrefValue = "";
			$this->pasien_TITLE->TooltipValue = "";

			// pasien_NAMA
			$this->pasien_NAMA->LinkCustomAttributes = "";
			$this->pasien_NAMA->HrefValue = "";
			$this->pasien_NAMA->TooltipValue = "";

			// pasien_ALAMAT
			$this->pasien_ALAMAT->LinkCustomAttributes = "";
			$this->pasien_ALAMAT->HrefValue = "";
			$this->pasien_ALAMAT->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// KDDOKTER
			$this->KDDOKTER->LinkCustomAttributes = "";
			$this->KDDOKTER->HrefValue = "";
			$this->KDDOKTER->TooltipValue = "";

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

			// PASIENBARU
			$this->PASIENBARU->LinkCustomAttributes = "";
			$this->PASIENBARU->HrefValue = "";
			$this->PASIENBARU->TooltipValue = "";

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

			// KETRUJUK
			$this->KETRUJUK->LinkCustomAttributes = "";
			$this->KETRUJUK->HrefValue = "";
			$this->KETRUJUK->TooltipValue = "";

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

			// biaya_obat_2
			$this->biaya_obat_2->LinkCustomAttributes = "";
			$this->biaya_obat_2->HrefValue = "";
			$this->biaya_obat_2->TooltipValue = "";

			// biaya_retur_obat_2
			$this->biaya_retur_obat_2->LinkCustomAttributes = "";
			$this->biaya_retur_obat_2->HrefValue = "";
			$this->biaya_retur_obat_2->TooltipValue = "";

			// TOTAL_BIAYA_OBAT_2
			$this->TOTAL_BIAYA_OBAT_2->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_OBAT_2->HrefValue = "";
			$this->TOTAL_BIAYA_OBAT_2->TooltipValue = "";

			// KDCARABAYAR2
			$this->KDCARABAYAR2->LinkCustomAttributes = "";
			$this->KDCARABAYAR2->HrefValue = "";
			$this->KDCARABAYAR2->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_pendaftaranlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_pendaftaran_view)) $t_pendaftaran_view = new ct_pendaftaran_view();

// Page init
$t_pendaftaran_view->Page_Init();

// Page main
$t_pendaftaran_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_pendaftaran_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft_pendaftaranview = new ew_Form("ft_pendaftaranview", "view");

// Form_CustomValidate event
ft_pendaftaranview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_pendaftaranview.ValidateRequired = true;
<?php } else { ?>
ft_pendaftaranview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_pendaftaranview.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","x_ALAMAT",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_pendaftaranview.Lists["x_pasien_TITLE"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_titel"};
ft_pendaftaranview.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_KDDOKTER"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_pendaftaranview.Lists["x_KDDOKTER"] = {"LinkField":"x_kddokter","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_lookup_dokter_poli"};
ft_pendaftaranview.Lists["x_KDRUJUK"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
ft_pendaftaranview.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_pendaftaranview.Lists["x_SHIFT"] = {"LinkField":"x_id_shift","Ajax":true,"AutoFill":false,"DisplayFields":["x_shift","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_shift"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_pendaftaran_view->IsModal) { ?>
<?php } ?>
<?php $t_pendaftaran_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t_pendaftaran_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$t_pendaftaran_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $t_pendaftaran_view->ShowPageHeader(); ?>
<?php
$t_pendaftaran_view->ShowMessage();
?>
<form name="ft_pendaftaranview" id="ft_pendaftaranview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_pendaftaran_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_pendaftaran_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_pendaftaran">
<?php if ($t_pendaftaran_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($t_pendaftaran->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<tr id="r_IDXDAFTAR">
		<td><span id="elh_t_pendaftaran_IDXDAFTAR"><?php echo $t_pendaftaran->IDXDAFTAR->FldCaption() ?></span></td>
		<td data-name="IDXDAFTAR"<?php echo $t_pendaftaran->IDXDAFTAR->CellAttributes() ?>>
<div id="orig_t_pendaftaran_IDXDAFTAR" class="hide">
<span id="el_t_pendaftaran_IDXDAFTAR">
<span<?php echo $t_pendaftaran->IDXDAFTAR->ViewAttributes() ?>>
<?php echo $t_pendaftaran->IDXDAFTAR->ViewValue ?></span>
</span>
</div>
<div class="btn-group">
	<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>   Menu</button>
		<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul style="background:#605CA8" class="dropdown-menu" role="menu" >
			<?php
				$r = Security()->CurrentUserLevelID();
				if($r==4)
			{ ?>
				<!-- <li class="divider"></li>
				<li><a style="color:#ffffff" target="_blank" href="cetak_formulir_pendaftaran_pasien.php?KDPOLY=<?php echo urlencode(CurrentPage()->KDPOLY->CurrentValue)?>&IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>&TGLREG=<?php echo urlencode(CurrentPage()->TGLREG->CurrentValue)?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>-  </b><b> Cetak Formulir Pendaftaran</b></a></li>
				<li class="divider"></li> -->
			<?php
				}else { print '-'; }
			?>
		</ul>
</div>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->TGLREG->Visible) { // TGLREG ?>
	<tr id="r_TGLREG">
		<td><span id="elh_t_pendaftaran_TGLREG"><?php echo $t_pendaftaran->TGLREG->FldCaption() ?></span></td>
		<td data-name="TGLREG"<?php echo $t_pendaftaran->TGLREG->CellAttributes() ?>>
<span id="el_t_pendaftaran_TGLREG">
<span<?php echo $t_pendaftaran->TGLREG->ViewAttributes() ?>>
<?php echo $t_pendaftaran->TGLREG->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->NOMR->Visible) { // NOMR ?>
	<tr id="r_NOMR">
		<td><span id="elh_t_pendaftaran_NOMR"><?php echo $t_pendaftaran->NOMR->FldCaption() ?></span></td>
		<td data-name="NOMR"<?php echo $t_pendaftaran->NOMR->CellAttributes() ?>>
<span id="el_t_pendaftaran_NOMR">
<span<?php echo $t_pendaftaran->NOMR->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NOMR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->pasien_TITLE->Visible) { // pasien_TITLE ?>
	<tr id="r_pasien_TITLE">
		<td><span id="elh_t_pendaftaran_pasien_TITLE"><?php echo $t_pendaftaran->pasien_TITLE->FldCaption() ?></span></td>
		<td data-name="pasien_TITLE"<?php echo $t_pendaftaran->pasien_TITLE->CellAttributes() ?>>
<span id="el_t_pendaftaran_pasien_TITLE">
<span<?php echo $t_pendaftaran->pasien_TITLE->ViewAttributes() ?>>
<?php echo $t_pendaftaran->pasien_TITLE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->pasien_NAMA->Visible) { // pasien_NAMA ?>
	<tr id="r_pasien_NAMA">
		<td><span id="elh_t_pendaftaran_pasien_NAMA"><?php echo $t_pendaftaran->pasien_NAMA->FldCaption() ?></span></td>
		<td data-name="pasien_NAMA"<?php echo $t_pendaftaran->pasien_NAMA->CellAttributes() ?>>
<span id="el_t_pendaftaran_pasien_NAMA">
<span<?php echo $t_pendaftaran->pasien_NAMA->ViewAttributes() ?>>
<?php echo $t_pendaftaran->pasien_NAMA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->pasien_ALAMAT->Visible) { // pasien_ALAMAT ?>
	<tr id="r_pasien_ALAMAT">
		<td><span id="elh_t_pendaftaran_pasien_ALAMAT"><?php echo $t_pendaftaran->pasien_ALAMAT->FldCaption() ?></span></td>
		<td data-name="pasien_ALAMAT"<?php echo $t_pendaftaran->pasien_ALAMAT->CellAttributes() ?>>
<span id="el_t_pendaftaran_pasien_ALAMAT">
<span<?php echo $t_pendaftaran->pasien_ALAMAT->ViewAttributes() ?>>
<?php echo $t_pendaftaran->pasien_ALAMAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->KDPOLY->Visible) { // KDPOLY ?>
	<tr id="r_KDPOLY">
		<td><span id="elh_t_pendaftaran_KDPOLY"><?php echo $t_pendaftaran->KDPOLY->FldCaption() ?></span></td>
		<td data-name="KDPOLY"<?php echo $t_pendaftaran->KDPOLY->CellAttributes() ?>>
<span id="el_t_pendaftaran_KDPOLY">
<span<?php echo $t_pendaftaran->KDPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDPOLY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->KDDOKTER->Visible) { // KDDOKTER ?>
	<tr id="r_KDDOKTER">
		<td><span id="elh_t_pendaftaran_KDDOKTER"><?php echo $t_pendaftaran->KDDOKTER->FldCaption() ?></span></td>
		<td data-name="KDDOKTER"<?php echo $t_pendaftaran->KDDOKTER->CellAttributes() ?>>
<span id="el_t_pendaftaran_KDDOKTER">
<span<?php echo $t_pendaftaran->KDDOKTER->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDDOKTER->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->KDRUJUK->Visible) { // KDRUJUK ?>
	<tr id="r_KDRUJUK">
		<td><span id="elh_t_pendaftaran_KDRUJUK"><?php echo $t_pendaftaran->KDRUJUK->FldCaption() ?></span></td>
		<td data-name="KDRUJUK"<?php echo $t_pendaftaran->KDRUJUK->CellAttributes() ?>>
<span id="el_t_pendaftaran_KDRUJUK">
<span<?php echo $t_pendaftaran->KDRUJUK->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDRUJUK->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<tr id="r_KDCARABAYAR">
		<td><span id="elh_t_pendaftaran_KDCARABAYAR"><?php echo $t_pendaftaran->KDCARABAYAR->FldCaption() ?></span></td>
		<td data-name="KDCARABAYAR"<?php echo $t_pendaftaran->KDCARABAYAR->CellAttributes() ?>>
<span id="el_t_pendaftaran_KDCARABAYAR">
<span<?php echo $t_pendaftaran->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDCARABAYAR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->SHIFT->Visible) { // SHIFT ?>
	<tr id="r_SHIFT">
		<td><span id="elh_t_pendaftaran_SHIFT"><?php echo $t_pendaftaran->SHIFT->FldCaption() ?></span></td>
		<td data-name="SHIFT"<?php echo $t_pendaftaran->SHIFT->CellAttributes() ?>>
<span id="el_t_pendaftaran_SHIFT">
<span<?php echo $t_pendaftaran->SHIFT->ViewAttributes() ?>>
<?php echo $t_pendaftaran->SHIFT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->PASIENBARU->Visible) { // PASIENBARU ?>
	<tr id="r_PASIENBARU">
		<td><span id="elh_t_pendaftaran_PASIENBARU"><?php echo $t_pendaftaran->PASIENBARU->FldCaption() ?></span></td>
		<td data-name="PASIENBARU"<?php echo $t_pendaftaran->PASIENBARU->CellAttributes() ?>>
<div id="orig_t_pendaftaran_PASIENBARU" class="hide">
<span id="el_t_pendaftaran_PASIENBARU">
<span<?php echo $t_pendaftaran->PASIENBARU->ViewAttributes() ?>>
<?php echo $t_pendaftaran->PASIENBARU->ViewValue ?></span>
</span>
</div>
<?php
$status = urlencode(CurrentPage()->PASIENBARU->CurrentValue);
if($status == 0){
	echo 'L';
}else
{
	echo 'B';
}
?>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->NIP->Visible) { // NIP ?>
	<tr id="r_NIP">
		<td><span id="elh_t_pendaftaran_NIP"><?php echo $t_pendaftaran->NIP->FldCaption() ?></span></td>
		<td data-name="NIP"<?php echo $t_pendaftaran->NIP->CellAttributes() ?>>
<span id="el_t_pendaftaran_NIP">
<span<?php echo $t_pendaftaran->NIP->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NIP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->MASUKPOLY->Visible) { // MASUKPOLY ?>
	<tr id="r_MASUKPOLY">
		<td><span id="elh_t_pendaftaran_MASUKPOLY"><?php echo $t_pendaftaran->MASUKPOLY->FldCaption() ?></span></td>
		<td data-name="MASUKPOLY"<?php echo $t_pendaftaran->MASUKPOLY->CellAttributes() ?>>
<span id="el_t_pendaftaran_MASUKPOLY">
<span<?php echo $t_pendaftaran->MASUKPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->MASUKPOLY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->KELUARPOLY->Visible) { // KELUARPOLY ?>
	<tr id="r_KELUARPOLY">
		<td><span id="elh_t_pendaftaran_KELUARPOLY"><?php echo $t_pendaftaran->KELUARPOLY->FldCaption() ?></span></td>
		<td data-name="KELUARPOLY"<?php echo $t_pendaftaran->KELUARPOLY->CellAttributes() ?>>
<span id="el_t_pendaftaran_KELUARPOLY">
<span<?php echo $t_pendaftaran->KELUARPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KELUARPOLY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->KETRUJUK->Visible) { // KETRUJUK ?>
	<tr id="r_KETRUJUK">
		<td><span id="elh_t_pendaftaran_KETRUJUK"><?php echo $t_pendaftaran->KETRUJUK->FldCaption() ?></span></td>
		<td data-name="KETRUJUK"<?php echo $t_pendaftaran->KETRUJUK->CellAttributes() ?>>
<span id="el_t_pendaftaran_KETRUJUK">
<span<?php echo $t_pendaftaran->KETRUJUK->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KETRUJUK->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->JAMREG->Visible) { // JAMREG ?>
	<tr id="r_JAMREG">
		<td><span id="elh_t_pendaftaran_JAMREG"><?php echo $t_pendaftaran->JAMREG->FldCaption() ?></span></td>
		<td data-name="JAMREG"<?php echo $t_pendaftaran->JAMREG->CellAttributes() ?>>
<span id="el_t_pendaftaran_JAMREG">
<span<?php echo $t_pendaftaran->JAMREG->ViewAttributes() ?>>
<?php echo $t_pendaftaran->JAMREG->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->NO_SJP->Visible) { // NO_SJP ?>
	<tr id="r_NO_SJP">
		<td><span id="elh_t_pendaftaran_NO_SJP"><?php echo $t_pendaftaran->NO_SJP->FldCaption() ?></span></td>
		<td data-name="NO_SJP"<?php echo $t_pendaftaran->NO_SJP->CellAttributes() ?>>
<span id="el_t_pendaftaran_NO_SJP">
<span<?php echo $t_pendaftaran->NO_SJP->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NO_SJP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->NOKARTU->Visible) { // NOKARTU ?>
	<tr id="r_NOKARTU">
		<td><span id="elh_t_pendaftaran_NOKARTU"><?php echo $t_pendaftaran->NOKARTU->FldCaption() ?></span></td>
		<td data-name="NOKARTU"<?php echo $t_pendaftaran->NOKARTU->CellAttributes() ?>>
<span id="el_t_pendaftaran_NOKARTU">
<span<?php echo $t_pendaftaran->NOKARTU->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NOKARTU->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->TANGGAL_SEP->Visible) { // TANGGAL_SEP ?>
	<tr id="r_TANGGAL_SEP">
		<td><span id="elh_t_pendaftaran_TANGGAL_SEP"><?php echo $t_pendaftaran->TANGGAL_SEP->FldCaption() ?></span></td>
		<td data-name="TANGGAL_SEP"<?php echo $t_pendaftaran->TANGGAL_SEP->CellAttributes() ?>>
<span id="el_t_pendaftaran_TANGGAL_SEP">
<span<?php echo $t_pendaftaran->TANGGAL_SEP->ViewAttributes() ?>>
<?php echo $t_pendaftaran->TANGGAL_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->TANGGALRUJUK_SEP->Visible) { // TANGGALRUJUK_SEP ?>
	<tr id="r_TANGGALRUJUK_SEP">
		<td><span id="elh_t_pendaftaran_TANGGALRUJUK_SEP"><?php echo $t_pendaftaran->TANGGALRUJUK_SEP->FldCaption() ?></span></td>
		<td data-name="TANGGALRUJUK_SEP"<?php echo $t_pendaftaran->TANGGALRUJUK_SEP->CellAttributes() ?>>
<span id="el_t_pendaftaran_TANGGALRUJUK_SEP">
<span<?php echo $t_pendaftaran->TANGGALRUJUK_SEP->ViewAttributes() ?>>
<?php echo $t_pendaftaran->TANGGALRUJUK_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->biaya_obat_2->Visible) { // biaya_obat_2 ?>
	<tr id="r_biaya_obat_2">
		<td><span id="elh_t_pendaftaran_biaya_obat_2"><?php echo $t_pendaftaran->biaya_obat_2->FldCaption() ?></span></td>
		<td data-name="biaya_obat_2"<?php echo $t_pendaftaran->biaya_obat_2->CellAttributes() ?>>
<span id="el_t_pendaftaran_biaya_obat_2">
<span<?php echo $t_pendaftaran->biaya_obat_2->ViewAttributes() ?>>
<?php echo $t_pendaftaran->biaya_obat_2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->biaya_retur_obat_2->Visible) { // biaya_retur_obat_2 ?>
	<tr id="r_biaya_retur_obat_2">
		<td><span id="elh_t_pendaftaran_biaya_retur_obat_2"><?php echo $t_pendaftaran->biaya_retur_obat_2->FldCaption() ?></span></td>
		<td data-name="biaya_retur_obat_2"<?php echo $t_pendaftaran->biaya_retur_obat_2->CellAttributes() ?>>
<span id="el_t_pendaftaran_biaya_retur_obat_2">
<span<?php echo $t_pendaftaran->biaya_retur_obat_2->ViewAttributes() ?>>
<?php echo $t_pendaftaran->biaya_retur_obat_2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->TOTAL_BIAYA_OBAT_2->Visible) { // TOTAL_BIAYA_OBAT_2 ?>
	<tr id="r_TOTAL_BIAYA_OBAT_2">
		<td><span id="elh_t_pendaftaran_TOTAL_BIAYA_OBAT_2"><?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->FldCaption() ?></span></td>
		<td data-name="TOTAL_BIAYA_OBAT_2"<?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->CellAttributes() ?>>
<span id="el_t_pendaftaran_TOTAL_BIAYA_OBAT_2">
<span<?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->ViewAttributes() ?>>
<?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_pendaftaran->KDCARABAYAR2->Visible) { // KDCARABAYAR2 ?>
	<tr id="r_KDCARABAYAR2">
		<td><span id="elh_t_pendaftaran_KDCARABAYAR2"><?php echo $t_pendaftaran->KDCARABAYAR2->FldCaption() ?></span></td>
		<td data-name="KDCARABAYAR2"<?php echo $t_pendaftaran->KDCARABAYAR2->CellAttributes() ?>>
<span id="el_t_pendaftaran_KDCARABAYAR2">
<span<?php echo $t_pendaftaran->KDCARABAYAR2->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDCARABAYAR2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
ft_pendaftaranview.Init();
</script>
<?php
$t_pendaftaran_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_pendaftaran_view->Page_Terminate();
?>
