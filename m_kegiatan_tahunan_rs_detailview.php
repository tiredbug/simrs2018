<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_kegiatan_tahunan_rs_detailinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_kegiatan_tahunan_rs_detail_view = NULL; // Initialize page object first

class cm_kegiatan_tahunan_rs_detail_view extends cm_kegiatan_tahunan_rs_detail {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_kegiatan_tahunan_rs_detail';

	// Page object name
	var $PageObjName = 'm_kegiatan_tahunan_rs_detail_view';

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

		// Table object (m_kegiatan_tahunan_rs_detail)
		if (!isset($GLOBALS["m_kegiatan_tahunan_rs_detail"]) || get_class($GLOBALS["m_kegiatan_tahunan_rs_detail"]) == "cm_kegiatan_tahunan_rs_detail") {
			$GLOBALS["m_kegiatan_tahunan_rs_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_kegiatan_tahunan_rs_detail"];
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_kegiatan_tahunan_rs_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_kegiatan_tahunan_rs_detaillist.php"));
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
		$this->tahun->SetVisibility();
		$this->program->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();

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
		global $EW_EXPORT, $m_kegiatan_tahunan_rs_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_kegiatan_tahunan_rs_detail);
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
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "m_kegiatan_tahunan_rs_detaillist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "m_kegiatan_tahunan_rs_detaillist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "m_kegiatan_tahunan_rs_detaillist.php"; // Not page request, return to list
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
		$this->tahun->setDbValue($rs->fields('tahun'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->tahun->DbValue = $row['tahun'];
		$this->program->DbValue = $row['program'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
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
		// id
		// tahun
		// program
		// kode_rekening
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// tahun
		$this->tahun->ViewValue = $this->tahun->CurrentValue;
		$this->tahun->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		$this->akun2->ViewValue = $this->akun2->CurrentValue;
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		$this->akun3->ViewValue = $this->akun3->CurrentValue;
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		$this->akun4->ViewValue = $this->akun4->CurrentValue;
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		$this->akun5->ViewValue = $this->akun5->CurrentValue;
		$this->akun5->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// tahun
			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";
			$this->tahun->TooltipValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";
			$this->program->TooltipValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

			// akun1
			$this->akun1->LinkCustomAttributes = "";
			$this->akun1->HrefValue = "";
			$this->akun1->TooltipValue = "";

			// akun2
			$this->akun2->LinkCustomAttributes = "";
			$this->akun2->HrefValue = "";
			$this->akun2->TooltipValue = "";

			// akun3
			$this->akun3->LinkCustomAttributes = "";
			$this->akun3->HrefValue = "";
			$this->akun3->TooltipValue = "";

			// akun4
			$this->akun4->LinkCustomAttributes = "";
			$this->akun4->HrefValue = "";
			$this->akun4->TooltipValue = "";

			// akun5
			$this->akun5->LinkCustomAttributes = "";
			$this->akun5->HrefValue = "";
			$this->akun5->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_kegiatan_tahunan_rs_detaillist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_kegiatan_tahunan_rs_detail_view)) $m_kegiatan_tahunan_rs_detail_view = new cm_kegiatan_tahunan_rs_detail_view();

// Page init
$m_kegiatan_tahunan_rs_detail_view->Page_Init();

// Page main
$m_kegiatan_tahunan_rs_detail_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_kegiatan_tahunan_rs_detail_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fm_kegiatan_tahunan_rs_detailview = new ew_Form("fm_kegiatan_tahunan_rs_detailview", "view");

// Form_CustomValidate event
fm_kegiatan_tahunan_rs_detailview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_kegiatan_tahunan_rs_detailview.ValidateRequired = true;
<?php } else { ?>
fm_kegiatan_tahunan_rs_detailview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_kegiatan_tahunan_rs_detail_view->IsModal) { ?>
<?php } ?>
<?php $m_kegiatan_tahunan_rs_detail_view->ExportOptions->Render("body") ?>
<?php
	foreach ($m_kegiatan_tahunan_rs_detail_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$m_kegiatan_tahunan_rs_detail_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $m_kegiatan_tahunan_rs_detail_view->ShowPageHeader(); ?>
<?php
$m_kegiatan_tahunan_rs_detail_view->ShowMessage();
?>
<form name="fm_kegiatan_tahunan_rs_detailview" id="fm_kegiatan_tahunan_rs_detailview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_kegiatan_tahunan_rs_detail_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_kegiatan_tahunan_rs_detail">
<?php if ($m_kegiatan_tahunan_rs_detail_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($m_kegiatan_tahunan_rs_detail->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_id"><?php echo $m_kegiatan_tahunan_rs_detail->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $m_kegiatan_tahunan_rs_detail->id->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_id">
<span<?php echo $m_kegiatan_tahunan_rs_detail->id->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->tahun->Visible) { // tahun ?>
	<tr id="r_tahun">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_tahun"><?php echo $m_kegiatan_tahunan_rs_detail->tahun->FldCaption() ?></span></td>
		<td data-name="tahun"<?php echo $m_kegiatan_tahunan_rs_detail->tahun->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_tahun">
<span<?php echo $m_kegiatan_tahunan_rs_detail->tahun->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->tahun->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->program->Visible) { // program ?>
	<tr id="r_program">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_program"><?php echo $m_kegiatan_tahunan_rs_detail->program->FldCaption() ?></span></td>
		<td data-name="program"<?php echo $m_kegiatan_tahunan_rs_detail->program->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_program">
<span<?php echo $m_kegiatan_tahunan_rs_detail->program->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->program->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->kode_rekening->Visible) { // kode_rekening ?>
	<tr id="r_kode_rekening">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_kode_rekening"><?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->FldCaption() ?></span></td>
		<td data-name="kode_rekening"<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_kode_rekening">
<span<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun1->Visible) { // akun1 ?>
	<tr id="r_akun1">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_akun1"><?php echo $m_kegiatan_tahunan_rs_detail->akun1->FldCaption() ?></span></td>
		<td data-name="akun1"<?php echo $m_kegiatan_tahunan_rs_detail->akun1->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun1">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun1->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun2->Visible) { // akun2 ?>
	<tr id="r_akun2">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_akun2"><?php echo $m_kegiatan_tahunan_rs_detail->akun2->FldCaption() ?></span></td>
		<td data-name="akun2"<?php echo $m_kegiatan_tahunan_rs_detail->akun2->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun2">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun2->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun3->Visible) { // akun3 ?>
	<tr id="r_akun3">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_akun3"><?php echo $m_kegiatan_tahunan_rs_detail->akun3->FldCaption() ?></span></td>
		<td data-name="akun3"<?php echo $m_kegiatan_tahunan_rs_detail->akun3->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun3">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun3->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun4->Visible) { // akun4 ?>
	<tr id="r_akun4">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_akun4"><?php echo $m_kegiatan_tahunan_rs_detail->akun4->FldCaption() ?></span></td>
		<td data-name="akun4"<?php echo $m_kegiatan_tahunan_rs_detail->akun4->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun4">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun4->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun5->Visible) { // akun5 ?>
	<tr id="r_akun5">
		<td><span id="elh_m_kegiatan_tahunan_rs_detail_akun5"><?php echo $m_kegiatan_tahunan_rs_detail->akun5->FldCaption() ?></span></td>
		<td data-name="akun5"<?php echo $m_kegiatan_tahunan_rs_detail->akun5->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun5">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun5->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fm_kegiatan_tahunan_rs_detailview.Init();
</script>
<?php
$m_kegiatan_tahunan_rs_detail_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_kegiatan_tahunan_rs_detail_view->Page_Terminate();
?>
