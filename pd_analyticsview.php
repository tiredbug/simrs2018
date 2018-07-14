<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pd_analyticsinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pd_analytics_view = NULL; // Initialize page object first

class cpd_analytics_view extends cpd_analytics {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pd_analytics';

	// Page object name
	var $PageObjName = 'pd_analytics_view';

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

		// Table object (pd_analytics)
		if (!isset($GLOBALS["pd_analytics"]) || get_class($GLOBALS["pd_analytics"]) == "cpd_analytics") {
			$GLOBALS["pd_analytics"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pd_analytics"];
		}
		$KeyUrl = "";
		if (@$_GET["aid"] <> "") {
			$this->RecKey["aid"] = $_GET["aid"];
			$KeyUrl .= "&amp;aid=" . urlencode($this->RecKey["aid"]);
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
			define("EW_TABLE_NAME", 'pd_analytics', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pd_analyticslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->aid->SetVisibility();
		$this->aid->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->v_ipaddr->SetVisibility();
		$this->v_datetime->SetVisibility();
		$this->v_referer->SetVisibility();
		$this->v_language->SetVisibility();
		$this->v_http_cookie->SetVisibility();
		$this->v_locale->SetVisibility();
		$this->v_useragent->SetVisibility();
		$this->v_remote_addr->SetVisibility();
		$this->v_browser->SetVisibility();
		$this->v_platform->SetVisibility();
		$this->v_version->SetVisibility();
		$this->v_city->SetVisibility();
		$this->v_country->SetVisibility();
		$this->v_countrycode->SetVisibility();

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
		global $EW_EXPORT, $pd_analytics;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pd_analytics);
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
			if (@$_GET["aid"] <> "") {
				$this->aid->setQueryStringValue($_GET["aid"]);
				$this->RecKey["aid"] = $this->aid->QueryStringValue;
			} elseif (@$_POST["aid"] <> "") {
				$this->aid->setFormValue($_POST["aid"]);
				$this->RecKey["aid"] = $this->aid->FormValue;
			} else {
				$sReturnUrl = "pd_analyticslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "pd_analyticslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "pd_analyticslist.php"; // Not page request, return to list
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
		$this->aid->setDbValue($rs->fields('aid'));
		$this->v_ipaddr->setDbValue($rs->fields('v_ipaddr'));
		$this->v_datetime->setDbValue($rs->fields('v_datetime'));
		$this->v_referer->setDbValue($rs->fields('v_referer'));
		$this->v_language->setDbValue($rs->fields('v_language'));
		$this->v_http_cookie->setDbValue($rs->fields('v_http_cookie'));
		$this->v_locale->setDbValue($rs->fields('v_locale'));
		$this->v_useragent->setDbValue($rs->fields('v_useragent'));
		$this->v_remote_addr->setDbValue($rs->fields('v_remote_addr'));
		$this->v_browser->setDbValue($rs->fields('v_browser'));
		$this->v_platform->setDbValue($rs->fields('v_platform'));
		$this->v_version->setDbValue($rs->fields('v_version'));
		$this->v_city->setDbValue($rs->fields('v_city'));
		$this->v_country->setDbValue($rs->fields('v_country'));
		$this->v_countrycode->setDbValue($rs->fields('v_countrycode'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->aid->DbValue = $row['aid'];
		$this->v_ipaddr->DbValue = $row['v_ipaddr'];
		$this->v_datetime->DbValue = $row['v_datetime'];
		$this->v_referer->DbValue = $row['v_referer'];
		$this->v_language->DbValue = $row['v_language'];
		$this->v_http_cookie->DbValue = $row['v_http_cookie'];
		$this->v_locale->DbValue = $row['v_locale'];
		$this->v_useragent->DbValue = $row['v_useragent'];
		$this->v_remote_addr->DbValue = $row['v_remote_addr'];
		$this->v_browser->DbValue = $row['v_browser'];
		$this->v_platform->DbValue = $row['v_platform'];
		$this->v_version->DbValue = $row['v_version'];
		$this->v_city->DbValue = $row['v_city'];
		$this->v_country->DbValue = $row['v_country'];
		$this->v_countrycode->DbValue = $row['v_countrycode'];
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
		// aid
		// v_ipaddr
		// v_datetime
		// v_referer
		// v_language
		// v_http_cookie
		// v_locale
		// v_useragent
		// v_remote_addr
		// v_browser
		// v_platform
		// v_version
		// v_city
		// v_country
		// v_countrycode

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// aid
		$this->aid->ViewValue = $this->aid->CurrentValue;
		$this->aid->ViewCustomAttributes = "";

		// v_ipaddr
		$this->v_ipaddr->ViewValue = $this->v_ipaddr->CurrentValue;
		$this->v_ipaddr->ViewCustomAttributes = "";

		// v_datetime
		$this->v_datetime->ViewValue = $this->v_datetime->CurrentValue;
		$this->v_datetime->ViewValue = ew_FormatDateTime($this->v_datetime->ViewValue, 0);
		$this->v_datetime->ViewCustomAttributes = "";

		// v_referer
		$this->v_referer->ViewValue = $this->v_referer->CurrentValue;
		$this->v_referer->ViewCustomAttributes = "";

		// v_language
		$this->v_language->ViewValue = $this->v_language->CurrentValue;
		$this->v_language->ViewCustomAttributes = "";

		// v_http_cookie
		$this->v_http_cookie->ViewValue = $this->v_http_cookie->CurrentValue;
		$this->v_http_cookie->ViewCustomAttributes = "";

		// v_locale
		$this->v_locale->ViewValue = $this->v_locale->CurrentValue;
		$this->v_locale->ViewCustomAttributes = "";

		// v_useragent
		$this->v_useragent->ViewValue = $this->v_useragent->CurrentValue;
		$this->v_useragent->ViewCustomAttributes = "";

		// v_remote_addr
		$this->v_remote_addr->ViewValue = $this->v_remote_addr->CurrentValue;
		$this->v_remote_addr->ViewCustomAttributes = "";

		// v_browser
		$this->v_browser->ViewValue = $this->v_browser->CurrentValue;
		$this->v_browser->ViewCustomAttributes = "";

		// v_platform
		$this->v_platform->ViewValue = $this->v_platform->CurrentValue;
		$this->v_platform->ViewCustomAttributes = "";

		// v_version
		$this->v_version->ViewValue = $this->v_version->CurrentValue;
		$this->v_version->ViewCustomAttributes = "";

		// v_city
		$this->v_city->ViewValue = $this->v_city->CurrentValue;
		$this->v_city->ViewCustomAttributes = "";

		// v_country
		$this->v_country->ViewValue = $this->v_country->CurrentValue;
		$this->v_country->ViewCustomAttributes = "";

		// v_countrycode
		$this->v_countrycode->ViewValue = $this->v_countrycode->CurrentValue;
		$this->v_countrycode->ViewCustomAttributes = "";

			// aid
			$this->aid->LinkCustomAttributes = "";
			$this->aid->HrefValue = "";
			$this->aid->TooltipValue = "";

			// v_ipaddr
			$this->v_ipaddr->LinkCustomAttributes = "";
			$this->v_ipaddr->HrefValue = "";
			$this->v_ipaddr->TooltipValue = "";

			// v_datetime
			$this->v_datetime->LinkCustomAttributes = "";
			$this->v_datetime->HrefValue = "";
			$this->v_datetime->TooltipValue = "";

			// v_referer
			$this->v_referer->LinkCustomAttributes = "";
			$this->v_referer->HrefValue = "";
			$this->v_referer->TooltipValue = "";

			// v_language
			$this->v_language->LinkCustomAttributes = "";
			$this->v_language->HrefValue = "";
			$this->v_language->TooltipValue = "";

			// v_http_cookie
			$this->v_http_cookie->LinkCustomAttributes = "";
			$this->v_http_cookie->HrefValue = "";
			$this->v_http_cookie->TooltipValue = "";

			// v_locale
			$this->v_locale->LinkCustomAttributes = "";
			$this->v_locale->HrefValue = "";
			$this->v_locale->TooltipValue = "";

			// v_useragent
			$this->v_useragent->LinkCustomAttributes = "";
			$this->v_useragent->HrefValue = "";
			$this->v_useragent->TooltipValue = "";

			// v_remote_addr
			$this->v_remote_addr->LinkCustomAttributes = "";
			$this->v_remote_addr->HrefValue = "";
			$this->v_remote_addr->TooltipValue = "";

			// v_browser
			$this->v_browser->LinkCustomAttributes = "";
			$this->v_browser->HrefValue = "";
			$this->v_browser->TooltipValue = "";

			// v_platform
			$this->v_platform->LinkCustomAttributes = "";
			$this->v_platform->HrefValue = "";
			$this->v_platform->TooltipValue = "";

			// v_version
			$this->v_version->LinkCustomAttributes = "";
			$this->v_version->HrefValue = "";
			$this->v_version->TooltipValue = "";

			// v_city
			$this->v_city->LinkCustomAttributes = "";
			$this->v_city->HrefValue = "";
			$this->v_city->TooltipValue = "";

			// v_country
			$this->v_country->LinkCustomAttributes = "";
			$this->v_country->HrefValue = "";
			$this->v_country->TooltipValue = "";

			// v_countrycode
			$this->v_countrycode->LinkCustomAttributes = "";
			$this->v_countrycode->HrefValue = "";
			$this->v_countrycode->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pd_analyticslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($pd_analytics_view)) $pd_analytics_view = new cpd_analytics_view();

// Page init
$pd_analytics_view->Page_Init();

// Page main
$pd_analytics_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pd_analytics_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fpd_analyticsview = new ew_Form("fpd_analyticsview", "view");

// Form_CustomValidate event
fpd_analyticsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpd_analyticsview.ValidateRequired = true;
<?php } else { ?>
fpd_analyticsview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$pd_analytics_view->IsModal) { ?>
<?php } ?>
<?php $pd_analytics_view->ExportOptions->Render("body") ?>
<?php
	foreach ($pd_analytics_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$pd_analytics_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $pd_analytics_view->ShowPageHeader(); ?>
<?php
$pd_analytics_view->ShowMessage();
?>
<form name="fpd_analyticsview" id="fpd_analyticsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pd_analytics_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pd_analytics_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pd_analytics">
<?php if ($pd_analytics_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($pd_analytics->aid->Visible) { // aid ?>
	<tr id="r_aid">
		<td><span id="elh_pd_analytics_aid"><?php echo $pd_analytics->aid->FldCaption() ?></span></td>
		<td data-name="aid"<?php echo $pd_analytics->aid->CellAttributes() ?>>
<span id="el_pd_analytics_aid">
<span<?php echo $pd_analytics->aid->ViewAttributes() ?>>
<?php echo $pd_analytics->aid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_ipaddr->Visible) { // v_ipaddr ?>
	<tr id="r_v_ipaddr">
		<td><span id="elh_pd_analytics_v_ipaddr"><?php echo $pd_analytics->v_ipaddr->FldCaption() ?></span></td>
		<td data-name="v_ipaddr"<?php echo $pd_analytics->v_ipaddr->CellAttributes() ?>>
<span id="el_pd_analytics_v_ipaddr">
<span<?php echo $pd_analytics->v_ipaddr->ViewAttributes() ?>>
<?php echo $pd_analytics->v_ipaddr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_datetime->Visible) { // v_datetime ?>
	<tr id="r_v_datetime">
		<td><span id="elh_pd_analytics_v_datetime"><?php echo $pd_analytics->v_datetime->FldCaption() ?></span></td>
		<td data-name="v_datetime"<?php echo $pd_analytics->v_datetime->CellAttributes() ?>>
<span id="el_pd_analytics_v_datetime">
<span<?php echo $pd_analytics->v_datetime->ViewAttributes() ?>>
<?php echo $pd_analytics->v_datetime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_referer->Visible) { // v_referer ?>
	<tr id="r_v_referer">
		<td><span id="elh_pd_analytics_v_referer"><?php echo $pd_analytics->v_referer->FldCaption() ?></span></td>
		<td data-name="v_referer"<?php echo $pd_analytics->v_referer->CellAttributes() ?>>
<span id="el_pd_analytics_v_referer">
<span<?php echo $pd_analytics->v_referer->ViewAttributes() ?>>
<?php echo $pd_analytics->v_referer->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_language->Visible) { // v_language ?>
	<tr id="r_v_language">
		<td><span id="elh_pd_analytics_v_language"><?php echo $pd_analytics->v_language->FldCaption() ?></span></td>
		<td data-name="v_language"<?php echo $pd_analytics->v_language->CellAttributes() ?>>
<span id="el_pd_analytics_v_language">
<span<?php echo $pd_analytics->v_language->ViewAttributes() ?>>
<?php echo $pd_analytics->v_language->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_http_cookie->Visible) { // v_http_cookie ?>
	<tr id="r_v_http_cookie">
		<td><span id="elh_pd_analytics_v_http_cookie"><?php echo $pd_analytics->v_http_cookie->FldCaption() ?></span></td>
		<td data-name="v_http_cookie"<?php echo $pd_analytics->v_http_cookie->CellAttributes() ?>>
<span id="el_pd_analytics_v_http_cookie">
<span<?php echo $pd_analytics->v_http_cookie->ViewAttributes() ?>>
<?php echo $pd_analytics->v_http_cookie->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_locale->Visible) { // v_locale ?>
	<tr id="r_v_locale">
		<td><span id="elh_pd_analytics_v_locale"><?php echo $pd_analytics->v_locale->FldCaption() ?></span></td>
		<td data-name="v_locale"<?php echo $pd_analytics->v_locale->CellAttributes() ?>>
<span id="el_pd_analytics_v_locale">
<span<?php echo $pd_analytics->v_locale->ViewAttributes() ?>>
<?php echo $pd_analytics->v_locale->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_useragent->Visible) { // v_useragent ?>
	<tr id="r_v_useragent">
		<td><span id="elh_pd_analytics_v_useragent"><?php echo $pd_analytics->v_useragent->FldCaption() ?></span></td>
		<td data-name="v_useragent"<?php echo $pd_analytics->v_useragent->CellAttributes() ?>>
<span id="el_pd_analytics_v_useragent">
<span<?php echo $pd_analytics->v_useragent->ViewAttributes() ?>>
<?php echo $pd_analytics->v_useragent->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_remote_addr->Visible) { // v_remote_addr ?>
	<tr id="r_v_remote_addr">
		<td><span id="elh_pd_analytics_v_remote_addr"><?php echo $pd_analytics->v_remote_addr->FldCaption() ?></span></td>
		<td data-name="v_remote_addr"<?php echo $pd_analytics->v_remote_addr->CellAttributes() ?>>
<span id="el_pd_analytics_v_remote_addr">
<span<?php echo $pd_analytics->v_remote_addr->ViewAttributes() ?>>
<?php echo $pd_analytics->v_remote_addr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_browser->Visible) { // v_browser ?>
	<tr id="r_v_browser">
		<td><span id="elh_pd_analytics_v_browser"><?php echo $pd_analytics->v_browser->FldCaption() ?></span></td>
		<td data-name="v_browser"<?php echo $pd_analytics->v_browser->CellAttributes() ?>>
<span id="el_pd_analytics_v_browser">
<span<?php echo $pd_analytics->v_browser->ViewAttributes() ?>>
<?php echo $pd_analytics->v_browser->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_platform->Visible) { // v_platform ?>
	<tr id="r_v_platform">
		<td><span id="elh_pd_analytics_v_platform"><?php echo $pd_analytics->v_platform->FldCaption() ?></span></td>
		<td data-name="v_platform"<?php echo $pd_analytics->v_platform->CellAttributes() ?>>
<span id="el_pd_analytics_v_platform">
<span<?php echo $pd_analytics->v_platform->ViewAttributes() ?>>
<?php echo $pd_analytics->v_platform->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_version->Visible) { // v_version ?>
	<tr id="r_v_version">
		<td><span id="elh_pd_analytics_v_version"><?php echo $pd_analytics->v_version->FldCaption() ?></span></td>
		<td data-name="v_version"<?php echo $pd_analytics->v_version->CellAttributes() ?>>
<span id="el_pd_analytics_v_version">
<span<?php echo $pd_analytics->v_version->ViewAttributes() ?>>
<?php echo $pd_analytics->v_version->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_city->Visible) { // v_city ?>
	<tr id="r_v_city">
		<td><span id="elh_pd_analytics_v_city"><?php echo $pd_analytics->v_city->FldCaption() ?></span></td>
		<td data-name="v_city"<?php echo $pd_analytics->v_city->CellAttributes() ?>>
<span id="el_pd_analytics_v_city">
<span<?php echo $pd_analytics->v_city->ViewAttributes() ?>>
<?php echo $pd_analytics->v_city->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_country->Visible) { // v_country ?>
	<tr id="r_v_country">
		<td><span id="elh_pd_analytics_v_country"><?php echo $pd_analytics->v_country->FldCaption() ?></span></td>
		<td data-name="v_country"<?php echo $pd_analytics->v_country->CellAttributes() ?>>
<span id="el_pd_analytics_v_country">
<span<?php echo $pd_analytics->v_country->ViewAttributes() ?>>
<?php echo $pd_analytics->v_country->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($pd_analytics->v_countrycode->Visible) { // v_countrycode ?>
	<tr id="r_v_countrycode">
		<td><span id="elh_pd_analytics_v_countrycode"><?php echo $pd_analytics->v_countrycode->FldCaption() ?></span></td>
		<td data-name="v_countrycode"<?php echo $pd_analytics->v_countrycode->CellAttributes() ?>>
<span id="el_pd_analytics_v_countrycode">
<span<?php echo $pd_analytics->v_countrycode->ViewAttributes() ?>>
<?php echo $pd_analytics->v_countrycode->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fpd_analyticsview.Init();
</script>
<?php
$pd_analytics_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pd_analytics_view->Page_Terminate();
?>
