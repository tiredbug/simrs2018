<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "detail_spjinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "t_spjinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$detail_spj_view = NULL; // Initialize page object first

class cdetail_spj_view extends cdetail_spj {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'detail_spj';

	// Page object name
	var $PageObjName = 'detail_spj_view';

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

		// Table object (detail_spj)
		if (!isset($GLOBALS["detail_spj"]) || get_class($GLOBALS["detail_spj"]) == "cdetail_spj") {
			$GLOBALS["detail_spj"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detail_spj"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
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

		// Table object (t_spj)
		if (!isset($GLOBALS['t_spj'])) $GLOBALS['t_spj'] = new ct_spj();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detail_spj', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("detail_spjlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->no_spj->SetVisibility();
		$this->no_sbp->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->belanja->SetVisibility();
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();
		$this->tahun_anggaran->SetVisibility();
		$this->tgl_sbp->SetVisibility();
		$this->tgl_spj->SetVisibility();
		$this->id_spj->SetVisibility();
		$this->jenis_spj->SetVisibility();

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
		global $EW_EXPORT, $detail_spj;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detail_spj);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "detail_spjlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "detail_spjlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "detail_spjlist.php"; // Not page request, return to list
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
		$this->id->setDbValue($rs->fields('id'));
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->belanja->setDbValue($rs->fields('belanja'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->tgl_sbp->setDbValue($rs->fields('tgl_sbp'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->id_spj->setDbValue($rs->fields('id_spj'));
		$this->jenis_spj->setDbValue($rs->fields('jenis_spj'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_spj->DbValue = $row['no_spj'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->belanja->DbValue = $row['belanja'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->tgl_sbp->DbValue = $row['tgl_sbp'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->id_spj->DbValue = $row['id_spj'];
		$this->jenis_spj->DbValue = $row['jenis_spj'];
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
		if ($this->belanja->FormValue == $this->belanja->CurrentValue && is_numeric(ew_StrToFloat($this->belanja->CurrentValue)))
			$this->belanja->CurrentValue = ew_StrToFloat($this->belanja->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// no_spj
		// no_sbp
		// kode_rekening
		// belanja
		// program
		// kegiatan
		// sub_kegiatan
		// tahun_anggaran
		// tgl_sbp
		// tgl_spj
		// id_spj
		// jenis_spj

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// no_sbp
		if (strval($this->no_sbp->CurrentValue) <> "") {
			$sFilterWrk = "`no_sbp`" . ew_SearchString("=", $this->no_sbp->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `no_sbp`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_list_spj`";
		$sWhereWrk = "";
		$this->no_sbp->LookupFilters = array("dx1" => '`no_sbp`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->no_sbp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->no_sbp->ViewValue = $this->no_sbp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
			}
		} else {
			$this->no_sbp->ViewValue = NULL;
		}
		$this->no_sbp->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// belanja
		$this->belanja->ViewValue = $this->belanja->CurrentValue;
		$this->belanja->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// tgl_sbp
		$this->tgl_sbp->ViewValue = $this->tgl_sbp->CurrentValue;
		$this->tgl_sbp->ViewValue = ew_FormatDateTime($this->tgl_sbp->ViewValue, 0);
		$this->tgl_sbp->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 0);
		$this->tgl_spj->ViewCustomAttributes = "";

		// id_spj
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		$this->id_spj->ViewCustomAttributes = "";

		// jenis_spj
		if (strval($this->jenis_spj->CurrentValue) <> "") {
			$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
		} else {
			$this->jenis_spj->ViewValue = NULL;
		}
		$this->jenis_spj->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";
			$this->no_spj->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

			// belanja
			$this->belanja->LinkCustomAttributes = "";
			$this->belanja->HrefValue = "";
			$this->belanja->TooltipValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";
			$this->program->TooltipValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";
			$this->kegiatan->TooltipValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";
			$this->sub_kegiatan->TooltipValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";
			$this->tgl_sbp->TooltipValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";
			$this->tgl_spj->TooltipValue = "";

			// id_spj
			$this->id_spj->LinkCustomAttributes = "";
			$this->id_spj->HrefValue = "";
			$this->id_spj->TooltipValue = "";

			// jenis_spj
			$this->jenis_spj->LinkCustomAttributes = "";
			$this->jenis_spj->HrefValue = "";
			$this->jenis_spj->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t_spj") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_no_spj"] <> "") {
					$GLOBALS["t_spj"]->no_spj->setQueryStringValue($_GET["fk_no_spj"]);
					$this->no_spj->setQueryStringValue($GLOBALS["t_spj"]->no_spj->QueryStringValue);
					$this->no_spj->setSessionValue($this->no_spj->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t_spj"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_spj->setQueryStringValue($GLOBALS["t_spj"]->id->QueryStringValue);
					$this->id_spj->setSessionValue($this->id_spj->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tgl_spj"] <> "") {
					$GLOBALS["t_spj"]->tgl_spj->setQueryStringValue($_GET["fk_tgl_spj"]);
					$this->tgl_spj->setQueryStringValue($GLOBALS["t_spj"]->tgl_spj->QueryStringValue);
					$this->tgl_spj->setSessionValue($this->tgl_spj->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_program"] <> "") {
					$GLOBALS["t_spj"]->program->setQueryStringValue($_GET["fk_program"]);
					$this->program->setQueryStringValue($GLOBALS["t_spj"]->program->QueryStringValue);
					$this->program->setSessionValue($this->program->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->kegiatan->setQueryStringValue($_GET["fk_kegiatan"]);
					$this->kegiatan->setQueryStringValue($GLOBALS["t_spj"]->kegiatan->QueryStringValue);
					$this->kegiatan->setSessionValue($this->kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_spj"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["t_spj"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->sub_kegiatan->setQueryStringValue($_GET["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setQueryStringValue($GLOBALS["t_spj"]->sub_kegiatan->QueryStringValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_jenis_spj"] <> "") {
					$GLOBALS["t_spj"]->jenis_spj->setQueryStringValue($_GET["fk_jenis_spj"]);
					$this->jenis_spj->setQueryStringValue($GLOBALS["t_spj"]->jenis_spj->QueryStringValue);
					$this->jenis_spj->setSessionValue($this->jenis_spj->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->jenis_spj->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "t_spj") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_no_spj"] <> "") {
					$GLOBALS["t_spj"]->no_spj->setFormValue($_POST["fk_no_spj"]);
					$this->no_spj->setFormValue($GLOBALS["t_spj"]->no_spj->FormValue);
					$this->no_spj->setSessionValue($this->no_spj->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t_spj"]->id->setFormValue($_POST["fk_id"]);
					$this->id_spj->setFormValue($GLOBALS["t_spj"]->id->FormValue);
					$this->id_spj->setSessionValue($this->id_spj->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tgl_spj"] <> "") {
					$GLOBALS["t_spj"]->tgl_spj->setFormValue($_POST["fk_tgl_spj"]);
					$this->tgl_spj->setFormValue($GLOBALS["t_spj"]->tgl_spj->FormValue);
					$this->tgl_spj->setSessionValue($this->tgl_spj->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_program"] <> "") {
					$GLOBALS["t_spj"]->program->setFormValue($_POST["fk_program"]);
					$this->program->setFormValue($GLOBALS["t_spj"]->program->FormValue);
					$this->program->setSessionValue($this->program->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->kegiatan->setFormValue($_POST["fk_kegiatan"]);
					$this->kegiatan->setFormValue($GLOBALS["t_spj"]->kegiatan->FormValue);
					$this->kegiatan->setSessionValue($this->kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_spj"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["t_spj"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->sub_kegiatan->setFormValue($_POST["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setFormValue($GLOBALS["t_spj"]->sub_kegiatan->FormValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_jenis_spj"] <> "") {
					$GLOBALS["t_spj"]->jenis_spj->setFormValue($_POST["fk_jenis_spj"]);
					$this->jenis_spj->setFormValue($GLOBALS["t_spj"]->jenis_spj->FormValue);
					$this->jenis_spj->setSessionValue($this->jenis_spj->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->jenis_spj->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_spj") {
				if ($this->no_spj->CurrentValue == "") $this->no_spj->setSessionValue("");
				if ($this->id_spj->CurrentValue == "") $this->id_spj->setSessionValue("");
				if ($this->tgl_spj->CurrentValue == "") $this->tgl_spj->setSessionValue("");
				if ($this->program->CurrentValue == "") $this->program->setSessionValue("");
				if ($this->kegiatan->CurrentValue == "") $this->kegiatan->setSessionValue("");
				if ($this->tahun_anggaran->CurrentValue == "") $this->tahun_anggaran->setSessionValue("");
				if ($this->sub_kegiatan->CurrentValue == "") $this->sub_kegiatan->setSessionValue("");
				if ($this->jenis_spj->CurrentValue == "") $this->jenis_spj->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("detail_spjlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($detail_spj_view)) $detail_spj_view = new cdetail_spj_view();

// Page init
$detail_spj_view->Page_Init();

// Page main
$detail_spj_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detail_spj_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fdetail_spjview = new ew_Form("fdetail_spjview", "view");

// Form_CustomValidate event
fdetail_spjview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetail_spjview.ValidateRequired = true;
<?php } else { ?>
fdetail_spjview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetail_spjview.Lists["x_no_sbp"] = {"LinkField":"x_no_sbp","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_sbp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_list_spj"};
fdetail_spjview.Lists["x_jenis_spj"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdetail_spjview.Lists["x_jenis_spj"].Options = <?php echo json_encode($detail_spj->jenis_spj->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$detail_spj_view->IsModal) { ?>
<?php } ?>
<?php $detail_spj_view->ExportOptions->Render("body") ?>
<?php
	foreach ($detail_spj_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$detail_spj_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $detail_spj_view->ShowPageHeader(); ?>
<?php
$detail_spj_view->ShowMessage();
?>
<form name="fdetail_spjview" id="fdetail_spjview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detail_spj_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detail_spj_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detail_spj">
<?php if ($detail_spj_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($detail_spj->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_detail_spj_id"><?php echo $detail_spj->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $detail_spj->id->CellAttributes() ?>>
<span id="el_detail_spj_id">
<span<?php echo $detail_spj->id->ViewAttributes() ?>>
<?php echo $detail_spj->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->no_spj->Visible) { // no_spj ?>
	<tr id="r_no_spj">
		<td><span id="elh_detail_spj_no_spj"><?php echo $detail_spj->no_spj->FldCaption() ?></span></td>
		<td data-name="no_spj"<?php echo $detail_spj->no_spj->CellAttributes() ?>>
<span id="el_detail_spj_no_spj">
<span<?php echo $detail_spj->no_spj->ViewAttributes() ?>>
<?php echo $detail_spj->no_spj->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->no_sbp->Visible) { // no_sbp ?>
	<tr id="r_no_sbp">
		<td><span id="elh_detail_spj_no_sbp"><?php echo $detail_spj->no_sbp->FldCaption() ?></span></td>
		<td data-name="no_sbp"<?php echo $detail_spj->no_sbp->CellAttributes() ?>>
<span id="el_detail_spj_no_sbp">
<span<?php echo $detail_spj->no_sbp->ViewAttributes() ?>>
<?php echo $detail_spj->no_sbp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->kode_rekening->Visible) { // kode_rekening ?>
	<tr id="r_kode_rekening">
		<td><span id="elh_detail_spj_kode_rekening"><?php echo $detail_spj->kode_rekening->FldCaption() ?></span></td>
		<td data-name="kode_rekening"<?php echo $detail_spj->kode_rekening->CellAttributes() ?>>
<span id="el_detail_spj_kode_rekening">
<span<?php echo $detail_spj->kode_rekening->ViewAttributes() ?>>
<?php echo $detail_spj->kode_rekening->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->belanja->Visible) { // belanja ?>
	<tr id="r_belanja">
		<td><span id="elh_detail_spj_belanja"><?php echo $detail_spj->belanja->FldCaption() ?></span></td>
		<td data-name="belanja"<?php echo $detail_spj->belanja->CellAttributes() ?>>
<span id="el_detail_spj_belanja">
<span<?php echo $detail_spj->belanja->ViewAttributes() ?>>
<?php echo $detail_spj->belanja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->program->Visible) { // program ?>
	<tr id="r_program">
		<td><span id="elh_detail_spj_program"><?php echo $detail_spj->program->FldCaption() ?></span></td>
		<td data-name="program"<?php echo $detail_spj->program->CellAttributes() ?>>
<span id="el_detail_spj_program">
<span<?php echo $detail_spj->program->ViewAttributes() ?>>
<?php echo $detail_spj->program->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->kegiatan->Visible) { // kegiatan ?>
	<tr id="r_kegiatan">
		<td><span id="elh_detail_spj_kegiatan"><?php echo $detail_spj->kegiatan->FldCaption() ?></span></td>
		<td data-name="kegiatan"<?php echo $detail_spj->kegiatan->CellAttributes() ?>>
<span id="el_detail_spj_kegiatan">
<span<?php echo $detail_spj->kegiatan->ViewAttributes() ?>>
<?php echo $detail_spj->kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<tr id="r_sub_kegiatan">
		<td><span id="elh_detail_spj_sub_kegiatan"><?php echo $detail_spj->sub_kegiatan->FldCaption() ?></span></td>
		<td data-name="sub_kegiatan"<?php echo $detail_spj->sub_kegiatan->CellAttributes() ?>>
<span id="el_detail_spj_sub_kegiatan">
<span<?php echo $detail_spj->sub_kegiatan->ViewAttributes() ?>>
<?php echo $detail_spj->sub_kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<tr id="r_tahun_anggaran">
		<td><span id="elh_detail_spj_tahun_anggaran"><?php echo $detail_spj->tahun_anggaran->FldCaption() ?></span></td>
		<td data-name="tahun_anggaran"<?php echo $detail_spj->tahun_anggaran->CellAttributes() ?>>
<span id="el_detail_spj_tahun_anggaran">
<span<?php echo $detail_spj->tahun_anggaran->ViewAttributes() ?>>
<?php echo $detail_spj->tahun_anggaran->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->tgl_sbp->Visible) { // tgl_sbp ?>
	<tr id="r_tgl_sbp">
		<td><span id="elh_detail_spj_tgl_sbp"><?php echo $detail_spj->tgl_sbp->FldCaption() ?></span></td>
		<td data-name="tgl_sbp"<?php echo $detail_spj->tgl_sbp->CellAttributes() ?>>
<span id="el_detail_spj_tgl_sbp">
<span<?php echo $detail_spj->tgl_sbp->ViewAttributes() ?>>
<?php echo $detail_spj->tgl_sbp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->tgl_spj->Visible) { // tgl_spj ?>
	<tr id="r_tgl_spj">
		<td><span id="elh_detail_spj_tgl_spj"><?php echo $detail_spj->tgl_spj->FldCaption() ?></span></td>
		<td data-name="tgl_spj"<?php echo $detail_spj->tgl_spj->CellAttributes() ?>>
<span id="el_detail_spj_tgl_spj">
<span<?php echo $detail_spj->tgl_spj->ViewAttributes() ?>>
<?php echo $detail_spj->tgl_spj->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->id_spj->Visible) { // id_spj ?>
	<tr id="r_id_spj">
		<td><span id="elh_detail_spj_id_spj"><?php echo $detail_spj->id_spj->FldCaption() ?></span></td>
		<td data-name="id_spj"<?php echo $detail_spj->id_spj->CellAttributes() ?>>
<span id="el_detail_spj_id_spj">
<span<?php echo $detail_spj->id_spj->ViewAttributes() ?>>
<?php echo $detail_spj->id_spj->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($detail_spj->jenis_spj->Visible) { // jenis_spj ?>
	<tr id="r_jenis_spj">
		<td><span id="elh_detail_spj_jenis_spj"><?php echo $detail_spj->jenis_spj->FldCaption() ?></span></td>
		<td data-name="jenis_spj"<?php echo $detail_spj->jenis_spj->CellAttributes() ?>>
<span id="el_detail_spj_jenis_spj">
<span<?php echo $detail_spj->jenis_spj->ViewAttributes() ?>>
<?php echo $detail_spj->jenis_spj->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fdetail_spjview.Init();
</script>
<?php
$detail_spj_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$detail_spj_view->Page_Terminate();
?>
