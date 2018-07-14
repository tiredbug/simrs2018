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

$pd_analytics_edit = NULL; // Initialize page object first

class cpd_analytics_edit extends cpd_analytics {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pd_analytics';

	// Page object name
	var $PageObjName = 'pd_analytics_edit';

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

		// Table object (pd_analytics)
		if (!isset($GLOBALS["pd_analytics"]) || get_class($GLOBALS["pd_analytics"]) == "cpd_analytics") {
			$GLOBALS["pd_analytics"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pd_analytics"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pd_analyticslist.php"));
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
		if (@$_GET["aid"] <> "") {
			$this->aid->setQueryStringValue($_GET["aid"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->aid->CurrentValue == "") {
			$this->Page_Terminate("pd_analyticslist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("pd_analyticslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "pd_analyticslist.php")
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
		if (!$this->aid->FldIsDetailKey)
			$this->aid->setFormValue($objForm->GetValue("x_aid"));
		if (!$this->v_ipaddr->FldIsDetailKey) {
			$this->v_ipaddr->setFormValue($objForm->GetValue("x_v_ipaddr"));
		}
		if (!$this->v_datetime->FldIsDetailKey) {
			$this->v_datetime->setFormValue($objForm->GetValue("x_v_datetime"));
			$this->v_datetime->CurrentValue = ew_UnFormatDateTime($this->v_datetime->CurrentValue, 0);
		}
		if (!$this->v_referer->FldIsDetailKey) {
			$this->v_referer->setFormValue($objForm->GetValue("x_v_referer"));
		}
		if (!$this->v_language->FldIsDetailKey) {
			$this->v_language->setFormValue($objForm->GetValue("x_v_language"));
		}
		if (!$this->v_http_cookie->FldIsDetailKey) {
			$this->v_http_cookie->setFormValue($objForm->GetValue("x_v_http_cookie"));
		}
		if (!$this->v_locale->FldIsDetailKey) {
			$this->v_locale->setFormValue($objForm->GetValue("x_v_locale"));
		}
		if (!$this->v_useragent->FldIsDetailKey) {
			$this->v_useragent->setFormValue($objForm->GetValue("x_v_useragent"));
		}
		if (!$this->v_remote_addr->FldIsDetailKey) {
			$this->v_remote_addr->setFormValue($objForm->GetValue("x_v_remote_addr"));
		}
		if (!$this->v_browser->FldIsDetailKey) {
			$this->v_browser->setFormValue($objForm->GetValue("x_v_browser"));
		}
		if (!$this->v_platform->FldIsDetailKey) {
			$this->v_platform->setFormValue($objForm->GetValue("x_v_platform"));
		}
		if (!$this->v_version->FldIsDetailKey) {
			$this->v_version->setFormValue($objForm->GetValue("x_v_version"));
		}
		if (!$this->v_city->FldIsDetailKey) {
			$this->v_city->setFormValue($objForm->GetValue("x_v_city"));
		}
		if (!$this->v_country->FldIsDetailKey) {
			$this->v_country->setFormValue($objForm->GetValue("x_v_country"));
		}
		if (!$this->v_countrycode->FldIsDetailKey) {
			$this->v_countrycode->setFormValue($objForm->GetValue("x_v_countrycode"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->aid->CurrentValue = $this->aid->FormValue;
		$this->v_ipaddr->CurrentValue = $this->v_ipaddr->FormValue;
		$this->v_datetime->CurrentValue = $this->v_datetime->FormValue;
		$this->v_datetime->CurrentValue = ew_UnFormatDateTime($this->v_datetime->CurrentValue, 0);
		$this->v_referer->CurrentValue = $this->v_referer->FormValue;
		$this->v_language->CurrentValue = $this->v_language->FormValue;
		$this->v_http_cookie->CurrentValue = $this->v_http_cookie->FormValue;
		$this->v_locale->CurrentValue = $this->v_locale->FormValue;
		$this->v_useragent->CurrentValue = $this->v_useragent->FormValue;
		$this->v_remote_addr->CurrentValue = $this->v_remote_addr->FormValue;
		$this->v_browser->CurrentValue = $this->v_browser->FormValue;
		$this->v_platform->CurrentValue = $this->v_platform->FormValue;
		$this->v_version->CurrentValue = $this->v_version->FormValue;
		$this->v_city->CurrentValue = $this->v_city->FormValue;
		$this->v_country->CurrentValue = $this->v_country->FormValue;
		$this->v_countrycode->CurrentValue = $this->v_countrycode->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// aid
			$this->aid->EditAttrs["class"] = "form-control";
			$this->aid->EditCustomAttributes = "";
			$this->aid->EditValue = $this->aid->CurrentValue;
			$this->aid->ViewCustomAttributes = "";

			// v_ipaddr
			$this->v_ipaddr->EditAttrs["class"] = "form-control";
			$this->v_ipaddr->EditCustomAttributes = "";
			$this->v_ipaddr->EditValue = ew_HtmlEncode($this->v_ipaddr->CurrentValue);
			$this->v_ipaddr->PlaceHolder = ew_RemoveHtml($this->v_ipaddr->FldCaption());

			// v_datetime
			$this->v_datetime->EditAttrs["class"] = "form-control";
			$this->v_datetime->EditCustomAttributes = "";
			$this->v_datetime->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->v_datetime->CurrentValue, 8));
			$this->v_datetime->PlaceHolder = ew_RemoveHtml($this->v_datetime->FldCaption());

			// v_referer
			$this->v_referer->EditAttrs["class"] = "form-control";
			$this->v_referer->EditCustomAttributes = "";
			$this->v_referer->EditValue = ew_HtmlEncode($this->v_referer->CurrentValue);
			$this->v_referer->PlaceHolder = ew_RemoveHtml($this->v_referer->FldCaption());

			// v_language
			$this->v_language->EditAttrs["class"] = "form-control";
			$this->v_language->EditCustomAttributes = "";
			$this->v_language->EditValue = ew_HtmlEncode($this->v_language->CurrentValue);
			$this->v_language->PlaceHolder = ew_RemoveHtml($this->v_language->FldCaption());

			// v_http_cookie
			$this->v_http_cookie->EditAttrs["class"] = "form-control";
			$this->v_http_cookie->EditCustomAttributes = "";
			$this->v_http_cookie->EditValue = ew_HtmlEncode($this->v_http_cookie->CurrentValue);
			$this->v_http_cookie->PlaceHolder = ew_RemoveHtml($this->v_http_cookie->FldCaption());

			// v_locale
			$this->v_locale->EditAttrs["class"] = "form-control";
			$this->v_locale->EditCustomAttributes = "";
			$this->v_locale->EditValue = ew_HtmlEncode($this->v_locale->CurrentValue);
			$this->v_locale->PlaceHolder = ew_RemoveHtml($this->v_locale->FldCaption());

			// v_useragent
			$this->v_useragent->EditAttrs["class"] = "form-control";
			$this->v_useragent->EditCustomAttributes = "";
			$this->v_useragent->EditValue = ew_HtmlEncode($this->v_useragent->CurrentValue);
			$this->v_useragent->PlaceHolder = ew_RemoveHtml($this->v_useragent->FldCaption());

			// v_remote_addr
			$this->v_remote_addr->EditAttrs["class"] = "form-control";
			$this->v_remote_addr->EditCustomAttributes = "";
			$this->v_remote_addr->EditValue = ew_HtmlEncode($this->v_remote_addr->CurrentValue);
			$this->v_remote_addr->PlaceHolder = ew_RemoveHtml($this->v_remote_addr->FldCaption());

			// v_browser
			$this->v_browser->EditAttrs["class"] = "form-control";
			$this->v_browser->EditCustomAttributes = "";
			$this->v_browser->EditValue = ew_HtmlEncode($this->v_browser->CurrentValue);
			$this->v_browser->PlaceHolder = ew_RemoveHtml($this->v_browser->FldCaption());

			// v_platform
			$this->v_platform->EditAttrs["class"] = "form-control";
			$this->v_platform->EditCustomAttributes = "";
			$this->v_platform->EditValue = ew_HtmlEncode($this->v_platform->CurrentValue);
			$this->v_platform->PlaceHolder = ew_RemoveHtml($this->v_platform->FldCaption());

			// v_version
			$this->v_version->EditAttrs["class"] = "form-control";
			$this->v_version->EditCustomAttributes = "";
			$this->v_version->EditValue = ew_HtmlEncode($this->v_version->CurrentValue);
			$this->v_version->PlaceHolder = ew_RemoveHtml($this->v_version->FldCaption());

			// v_city
			$this->v_city->EditAttrs["class"] = "form-control";
			$this->v_city->EditCustomAttributes = "";
			$this->v_city->EditValue = ew_HtmlEncode($this->v_city->CurrentValue);
			$this->v_city->PlaceHolder = ew_RemoveHtml($this->v_city->FldCaption());

			// v_country
			$this->v_country->EditAttrs["class"] = "form-control";
			$this->v_country->EditCustomAttributes = "";
			$this->v_country->EditValue = ew_HtmlEncode($this->v_country->CurrentValue);
			$this->v_country->PlaceHolder = ew_RemoveHtml($this->v_country->FldCaption());

			// v_countrycode
			$this->v_countrycode->EditAttrs["class"] = "form-control";
			$this->v_countrycode->EditCustomAttributes = "";
			$this->v_countrycode->EditValue = ew_HtmlEncode($this->v_countrycode->CurrentValue);
			$this->v_countrycode->PlaceHolder = ew_RemoveHtml($this->v_countrycode->FldCaption());

			// Edit refer script
			// aid

			$this->aid->LinkCustomAttributes = "";
			$this->aid->HrefValue = "";

			// v_ipaddr
			$this->v_ipaddr->LinkCustomAttributes = "";
			$this->v_ipaddr->HrefValue = "";

			// v_datetime
			$this->v_datetime->LinkCustomAttributes = "";
			$this->v_datetime->HrefValue = "";

			// v_referer
			$this->v_referer->LinkCustomAttributes = "";
			$this->v_referer->HrefValue = "";

			// v_language
			$this->v_language->LinkCustomAttributes = "";
			$this->v_language->HrefValue = "";

			// v_http_cookie
			$this->v_http_cookie->LinkCustomAttributes = "";
			$this->v_http_cookie->HrefValue = "";

			// v_locale
			$this->v_locale->LinkCustomAttributes = "";
			$this->v_locale->HrefValue = "";

			// v_useragent
			$this->v_useragent->LinkCustomAttributes = "";
			$this->v_useragent->HrefValue = "";

			// v_remote_addr
			$this->v_remote_addr->LinkCustomAttributes = "";
			$this->v_remote_addr->HrefValue = "";

			// v_browser
			$this->v_browser->LinkCustomAttributes = "";
			$this->v_browser->HrefValue = "";

			// v_platform
			$this->v_platform->LinkCustomAttributes = "";
			$this->v_platform->HrefValue = "";

			// v_version
			$this->v_version->LinkCustomAttributes = "";
			$this->v_version->HrefValue = "";

			// v_city
			$this->v_city->LinkCustomAttributes = "";
			$this->v_city->HrefValue = "";

			// v_country
			$this->v_country->LinkCustomAttributes = "";
			$this->v_country->HrefValue = "";

			// v_countrycode
			$this->v_countrycode->LinkCustomAttributes = "";
			$this->v_countrycode->HrefValue = "";
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
		if (!ew_CheckDateDef($this->v_datetime->FormValue)) {
			ew_AddMessage($gsFormError, $this->v_datetime->FldErrMsg());
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

			// v_ipaddr
			$this->v_ipaddr->SetDbValueDef($rsnew, $this->v_ipaddr->CurrentValue, NULL, $this->v_ipaddr->ReadOnly);

			// v_datetime
			$this->v_datetime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->v_datetime->CurrentValue, 0), NULL, $this->v_datetime->ReadOnly);

			// v_referer
			$this->v_referer->SetDbValueDef($rsnew, $this->v_referer->CurrentValue, NULL, $this->v_referer->ReadOnly);

			// v_language
			$this->v_language->SetDbValueDef($rsnew, $this->v_language->CurrentValue, NULL, $this->v_language->ReadOnly);

			// v_http_cookie
			$this->v_http_cookie->SetDbValueDef($rsnew, $this->v_http_cookie->CurrentValue, NULL, $this->v_http_cookie->ReadOnly);

			// v_locale
			$this->v_locale->SetDbValueDef($rsnew, $this->v_locale->CurrentValue, NULL, $this->v_locale->ReadOnly);

			// v_useragent
			$this->v_useragent->SetDbValueDef($rsnew, $this->v_useragent->CurrentValue, NULL, $this->v_useragent->ReadOnly);

			// v_remote_addr
			$this->v_remote_addr->SetDbValueDef($rsnew, $this->v_remote_addr->CurrentValue, NULL, $this->v_remote_addr->ReadOnly);

			// v_browser
			$this->v_browser->SetDbValueDef($rsnew, $this->v_browser->CurrentValue, NULL, $this->v_browser->ReadOnly);

			// v_platform
			$this->v_platform->SetDbValueDef($rsnew, $this->v_platform->CurrentValue, NULL, $this->v_platform->ReadOnly);

			// v_version
			$this->v_version->SetDbValueDef($rsnew, $this->v_version->CurrentValue, NULL, $this->v_version->ReadOnly);

			// v_city
			$this->v_city->SetDbValueDef($rsnew, $this->v_city->CurrentValue, NULL, $this->v_city->ReadOnly);

			// v_country
			$this->v_country->SetDbValueDef($rsnew, $this->v_country->CurrentValue, NULL, $this->v_country->ReadOnly);

			// v_countrycode
			$this->v_countrycode->SetDbValueDef($rsnew, $this->v_countrycode->CurrentValue, NULL, $this->v_countrycode->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pd_analyticslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($pd_analytics_edit)) $pd_analytics_edit = new cpd_analytics_edit();

// Page init
$pd_analytics_edit->Page_Init();

// Page main
$pd_analytics_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pd_analytics_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fpd_analyticsedit = new ew_Form("fpd_analyticsedit", "edit");

// Validate form
fpd_analyticsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_v_datetime");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pd_analytics->v_datetime->FldErrMsg()) ?>");

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
fpd_analyticsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpd_analyticsedit.ValidateRequired = true;
<?php } else { ?>
fpd_analyticsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$pd_analytics_edit->IsModal) { ?>
<?php } ?>
<?php $pd_analytics_edit->ShowPageHeader(); ?>
<?php
$pd_analytics_edit->ShowMessage();
?>
<form name="fpd_analyticsedit" id="fpd_analyticsedit" class="<?php echo $pd_analytics_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pd_analytics_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pd_analytics_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pd_analytics">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($pd_analytics_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($pd_analytics->aid->Visible) { // aid ?>
	<div id="r_aid" class="form-group">
		<label id="elh_pd_analytics_aid" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->aid->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->aid->CellAttributes() ?>>
<span id="el_pd_analytics_aid">
<span<?php echo $pd_analytics->aid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pd_analytics->aid->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pd_analytics" data-field="x_aid" name="x_aid" id="x_aid" value="<?php echo ew_HtmlEncode($pd_analytics->aid->CurrentValue) ?>">
<?php echo $pd_analytics->aid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_ipaddr->Visible) { // v_ipaddr ?>
	<div id="r_v_ipaddr" class="form-group">
		<label id="elh_pd_analytics_v_ipaddr" for="x_v_ipaddr" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_ipaddr->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_ipaddr->CellAttributes() ?>>
<span id="el_pd_analytics_v_ipaddr">
<input type="text" data-table="pd_analytics" data-field="x_v_ipaddr" name="x_v_ipaddr" id="x_v_ipaddr" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_ipaddr->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_ipaddr->EditValue ?>"<?php echo $pd_analytics->v_ipaddr->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_ipaddr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_datetime->Visible) { // v_datetime ?>
	<div id="r_v_datetime" class="form-group">
		<label id="elh_pd_analytics_v_datetime" for="x_v_datetime" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_datetime->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_datetime->CellAttributes() ?>>
<span id="el_pd_analytics_v_datetime">
<input type="text" data-table="pd_analytics" data-field="x_v_datetime" name="x_v_datetime" id="x_v_datetime" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_datetime->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_datetime->EditValue ?>"<?php echo $pd_analytics->v_datetime->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_datetime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_referer->Visible) { // v_referer ?>
	<div id="r_v_referer" class="form-group">
		<label id="elh_pd_analytics_v_referer" for="x_v_referer" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_referer->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_referer->CellAttributes() ?>>
<span id="el_pd_analytics_v_referer">
<input type="text" data-table="pd_analytics" data-field="x_v_referer" name="x_v_referer" id="x_v_referer" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_referer->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_referer->EditValue ?>"<?php echo $pd_analytics->v_referer->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_referer->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_language->Visible) { // v_language ?>
	<div id="r_v_language" class="form-group">
		<label id="elh_pd_analytics_v_language" for="x_v_language" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_language->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_language->CellAttributes() ?>>
<span id="el_pd_analytics_v_language">
<input type="text" data-table="pd_analytics" data-field="x_v_language" name="x_v_language" id="x_v_language" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_language->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_language->EditValue ?>"<?php echo $pd_analytics->v_language->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_language->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_http_cookie->Visible) { // v_http_cookie ?>
	<div id="r_v_http_cookie" class="form-group">
		<label id="elh_pd_analytics_v_http_cookie" for="x_v_http_cookie" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_http_cookie->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_http_cookie->CellAttributes() ?>>
<span id="el_pd_analytics_v_http_cookie">
<input type="text" data-table="pd_analytics" data-field="x_v_http_cookie" name="x_v_http_cookie" id="x_v_http_cookie" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_http_cookie->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_http_cookie->EditValue ?>"<?php echo $pd_analytics->v_http_cookie->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_http_cookie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_locale->Visible) { // v_locale ?>
	<div id="r_v_locale" class="form-group">
		<label id="elh_pd_analytics_v_locale" for="x_v_locale" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_locale->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_locale->CellAttributes() ?>>
<span id="el_pd_analytics_v_locale">
<input type="text" data-table="pd_analytics" data-field="x_v_locale" name="x_v_locale" id="x_v_locale" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_locale->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_locale->EditValue ?>"<?php echo $pd_analytics->v_locale->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_locale->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_useragent->Visible) { // v_useragent ?>
	<div id="r_v_useragent" class="form-group">
		<label id="elh_pd_analytics_v_useragent" for="x_v_useragent" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_useragent->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_useragent->CellAttributes() ?>>
<span id="el_pd_analytics_v_useragent">
<input type="text" data-table="pd_analytics" data-field="x_v_useragent" name="x_v_useragent" id="x_v_useragent" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_useragent->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_useragent->EditValue ?>"<?php echo $pd_analytics->v_useragent->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_useragent->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_remote_addr->Visible) { // v_remote_addr ?>
	<div id="r_v_remote_addr" class="form-group">
		<label id="elh_pd_analytics_v_remote_addr" for="x_v_remote_addr" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_remote_addr->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_remote_addr->CellAttributes() ?>>
<span id="el_pd_analytics_v_remote_addr">
<input type="text" data-table="pd_analytics" data-field="x_v_remote_addr" name="x_v_remote_addr" id="x_v_remote_addr" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_remote_addr->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_remote_addr->EditValue ?>"<?php echo $pd_analytics->v_remote_addr->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_remote_addr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_browser->Visible) { // v_browser ?>
	<div id="r_v_browser" class="form-group">
		<label id="elh_pd_analytics_v_browser" for="x_v_browser" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_browser->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_browser->CellAttributes() ?>>
<span id="el_pd_analytics_v_browser">
<input type="text" data-table="pd_analytics" data-field="x_v_browser" name="x_v_browser" id="x_v_browser" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_browser->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_browser->EditValue ?>"<?php echo $pd_analytics->v_browser->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_browser->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_platform->Visible) { // v_platform ?>
	<div id="r_v_platform" class="form-group">
		<label id="elh_pd_analytics_v_platform" for="x_v_platform" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_platform->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_platform->CellAttributes() ?>>
<span id="el_pd_analytics_v_platform">
<input type="text" data-table="pd_analytics" data-field="x_v_platform" name="x_v_platform" id="x_v_platform" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_platform->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_platform->EditValue ?>"<?php echo $pd_analytics->v_platform->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_platform->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_version->Visible) { // v_version ?>
	<div id="r_v_version" class="form-group">
		<label id="elh_pd_analytics_v_version" for="x_v_version" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_version->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_version->CellAttributes() ?>>
<span id="el_pd_analytics_v_version">
<input type="text" data-table="pd_analytics" data-field="x_v_version" name="x_v_version" id="x_v_version" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_version->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_version->EditValue ?>"<?php echo $pd_analytics->v_version->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_version->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_city->Visible) { // v_city ?>
	<div id="r_v_city" class="form-group">
		<label id="elh_pd_analytics_v_city" for="x_v_city" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_city->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_city->CellAttributes() ?>>
<span id="el_pd_analytics_v_city">
<input type="text" data-table="pd_analytics" data-field="x_v_city" name="x_v_city" id="x_v_city" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_city->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_city->EditValue ?>"<?php echo $pd_analytics->v_city->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_city->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_country->Visible) { // v_country ?>
	<div id="r_v_country" class="form-group">
		<label id="elh_pd_analytics_v_country" for="x_v_country" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_country->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_country->CellAttributes() ?>>
<span id="el_pd_analytics_v_country">
<input type="text" data-table="pd_analytics" data-field="x_v_country" name="x_v_country" id="x_v_country" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_country->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_country->EditValue ?>"<?php echo $pd_analytics->v_country->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_country->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_analytics->v_countrycode->Visible) { // v_countrycode ?>
	<div id="r_v_countrycode" class="form-group">
		<label id="elh_pd_analytics_v_countrycode" for="x_v_countrycode" class="col-sm-2 control-label ewLabel"><?php echo $pd_analytics->v_countrycode->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_analytics->v_countrycode->CellAttributes() ?>>
<span id="el_pd_analytics_v_countrycode">
<input type="text" data-table="pd_analytics" data-field="x_v_countrycode" name="x_v_countrycode" id="x_v_countrycode" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($pd_analytics->v_countrycode->getPlaceHolder()) ?>" value="<?php echo $pd_analytics->v_countrycode->EditValue ?>"<?php echo $pd_analytics->v_countrycode->EditAttributes() ?>>
</span>
<?php echo $pd_analytics->v_countrycode->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$pd_analytics_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pd_analytics_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpd_analyticsedit.Init();
</script>
<?php
$pd_analytics_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pd_analytics_edit->Page_Terminate();
?>
