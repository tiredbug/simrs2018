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

$pd_analytics_delete = NULL; // Initialize page object first

class cpd_analytics_delete extends cpd_analytics {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pd_analytics';

	// Page object name
	var $PageObjName = 'pd_analytics_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("pd_analyticslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in pd_analytics class, pd_analyticsinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("pd_analyticslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['aid'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pd_analyticslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($pd_analytics_delete)) $pd_analytics_delete = new cpd_analytics_delete();

// Page init
$pd_analytics_delete->Page_Init();

// Page main
$pd_analytics_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pd_analytics_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fpd_analyticsdelete = new ew_Form("fpd_analyticsdelete", "delete");

// Form_CustomValidate event
fpd_analyticsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpd_analyticsdelete.ValidateRequired = true;
<?php } else { ?>
fpd_analyticsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $pd_analytics_delete->ShowPageHeader(); ?>
<?php
$pd_analytics_delete->ShowMessage();
?>
<form name="fpd_analyticsdelete" id="fpd_analyticsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pd_analytics_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pd_analytics_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pd_analytics">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($pd_analytics_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $pd_analytics->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($pd_analytics->aid->Visible) { // aid ?>
		<th><span id="elh_pd_analytics_aid" class="pd_analytics_aid"><?php echo $pd_analytics->aid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_ipaddr->Visible) { // v_ipaddr ?>
		<th><span id="elh_pd_analytics_v_ipaddr" class="pd_analytics_v_ipaddr"><?php echo $pd_analytics->v_ipaddr->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_datetime->Visible) { // v_datetime ?>
		<th><span id="elh_pd_analytics_v_datetime" class="pd_analytics_v_datetime"><?php echo $pd_analytics->v_datetime->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_referer->Visible) { // v_referer ?>
		<th><span id="elh_pd_analytics_v_referer" class="pd_analytics_v_referer"><?php echo $pd_analytics->v_referer->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_language->Visible) { // v_language ?>
		<th><span id="elh_pd_analytics_v_language" class="pd_analytics_v_language"><?php echo $pd_analytics->v_language->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_http_cookie->Visible) { // v_http_cookie ?>
		<th><span id="elh_pd_analytics_v_http_cookie" class="pd_analytics_v_http_cookie"><?php echo $pd_analytics->v_http_cookie->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_locale->Visible) { // v_locale ?>
		<th><span id="elh_pd_analytics_v_locale" class="pd_analytics_v_locale"><?php echo $pd_analytics->v_locale->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_useragent->Visible) { // v_useragent ?>
		<th><span id="elh_pd_analytics_v_useragent" class="pd_analytics_v_useragent"><?php echo $pd_analytics->v_useragent->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_remote_addr->Visible) { // v_remote_addr ?>
		<th><span id="elh_pd_analytics_v_remote_addr" class="pd_analytics_v_remote_addr"><?php echo $pd_analytics->v_remote_addr->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_browser->Visible) { // v_browser ?>
		<th><span id="elh_pd_analytics_v_browser" class="pd_analytics_v_browser"><?php echo $pd_analytics->v_browser->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_platform->Visible) { // v_platform ?>
		<th><span id="elh_pd_analytics_v_platform" class="pd_analytics_v_platform"><?php echo $pd_analytics->v_platform->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_version->Visible) { // v_version ?>
		<th><span id="elh_pd_analytics_v_version" class="pd_analytics_v_version"><?php echo $pd_analytics->v_version->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_city->Visible) { // v_city ?>
		<th><span id="elh_pd_analytics_v_city" class="pd_analytics_v_city"><?php echo $pd_analytics->v_city->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_country->Visible) { // v_country ?>
		<th><span id="elh_pd_analytics_v_country" class="pd_analytics_v_country"><?php echo $pd_analytics->v_country->FldCaption() ?></span></th>
<?php } ?>
<?php if ($pd_analytics->v_countrycode->Visible) { // v_countrycode ?>
		<th><span id="elh_pd_analytics_v_countrycode" class="pd_analytics_v_countrycode"><?php echo $pd_analytics->v_countrycode->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$pd_analytics_delete->RecCnt = 0;
$i = 0;
while (!$pd_analytics_delete->Recordset->EOF) {
	$pd_analytics_delete->RecCnt++;
	$pd_analytics_delete->RowCnt++;

	// Set row properties
	$pd_analytics->ResetAttrs();
	$pd_analytics->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$pd_analytics_delete->LoadRowValues($pd_analytics_delete->Recordset);

	// Render row
	$pd_analytics_delete->RenderRow();
?>
	<tr<?php echo $pd_analytics->RowAttributes() ?>>
<?php if ($pd_analytics->aid->Visible) { // aid ?>
		<td<?php echo $pd_analytics->aid->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_aid" class="pd_analytics_aid">
<span<?php echo $pd_analytics->aid->ViewAttributes() ?>>
<?php echo $pd_analytics->aid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_ipaddr->Visible) { // v_ipaddr ?>
		<td<?php echo $pd_analytics->v_ipaddr->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_ipaddr" class="pd_analytics_v_ipaddr">
<span<?php echo $pd_analytics->v_ipaddr->ViewAttributes() ?>>
<?php echo $pd_analytics->v_ipaddr->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_datetime->Visible) { // v_datetime ?>
		<td<?php echo $pd_analytics->v_datetime->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_datetime" class="pd_analytics_v_datetime">
<span<?php echo $pd_analytics->v_datetime->ViewAttributes() ?>>
<?php echo $pd_analytics->v_datetime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_referer->Visible) { // v_referer ?>
		<td<?php echo $pd_analytics->v_referer->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_referer" class="pd_analytics_v_referer">
<span<?php echo $pd_analytics->v_referer->ViewAttributes() ?>>
<?php echo $pd_analytics->v_referer->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_language->Visible) { // v_language ?>
		<td<?php echo $pd_analytics->v_language->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_language" class="pd_analytics_v_language">
<span<?php echo $pd_analytics->v_language->ViewAttributes() ?>>
<?php echo $pd_analytics->v_language->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_http_cookie->Visible) { // v_http_cookie ?>
		<td<?php echo $pd_analytics->v_http_cookie->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_http_cookie" class="pd_analytics_v_http_cookie">
<span<?php echo $pd_analytics->v_http_cookie->ViewAttributes() ?>>
<?php echo $pd_analytics->v_http_cookie->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_locale->Visible) { // v_locale ?>
		<td<?php echo $pd_analytics->v_locale->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_locale" class="pd_analytics_v_locale">
<span<?php echo $pd_analytics->v_locale->ViewAttributes() ?>>
<?php echo $pd_analytics->v_locale->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_useragent->Visible) { // v_useragent ?>
		<td<?php echo $pd_analytics->v_useragent->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_useragent" class="pd_analytics_v_useragent">
<span<?php echo $pd_analytics->v_useragent->ViewAttributes() ?>>
<?php echo $pd_analytics->v_useragent->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_remote_addr->Visible) { // v_remote_addr ?>
		<td<?php echo $pd_analytics->v_remote_addr->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_remote_addr" class="pd_analytics_v_remote_addr">
<span<?php echo $pd_analytics->v_remote_addr->ViewAttributes() ?>>
<?php echo $pd_analytics->v_remote_addr->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_browser->Visible) { // v_browser ?>
		<td<?php echo $pd_analytics->v_browser->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_browser" class="pd_analytics_v_browser">
<span<?php echo $pd_analytics->v_browser->ViewAttributes() ?>>
<?php echo $pd_analytics->v_browser->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_platform->Visible) { // v_platform ?>
		<td<?php echo $pd_analytics->v_platform->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_platform" class="pd_analytics_v_platform">
<span<?php echo $pd_analytics->v_platform->ViewAttributes() ?>>
<?php echo $pd_analytics->v_platform->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_version->Visible) { // v_version ?>
		<td<?php echo $pd_analytics->v_version->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_version" class="pd_analytics_v_version">
<span<?php echo $pd_analytics->v_version->ViewAttributes() ?>>
<?php echo $pd_analytics->v_version->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_city->Visible) { // v_city ?>
		<td<?php echo $pd_analytics->v_city->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_city" class="pd_analytics_v_city">
<span<?php echo $pd_analytics->v_city->ViewAttributes() ?>>
<?php echo $pd_analytics->v_city->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_country->Visible) { // v_country ?>
		<td<?php echo $pd_analytics->v_country->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_country" class="pd_analytics_v_country">
<span<?php echo $pd_analytics->v_country->ViewAttributes() ?>>
<?php echo $pd_analytics->v_country->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($pd_analytics->v_countrycode->Visible) { // v_countrycode ?>
		<td<?php echo $pd_analytics->v_countrycode->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_delete->RowCnt ?>_pd_analytics_v_countrycode" class="pd_analytics_v_countrycode">
<span<?php echo $pd_analytics->v_countrycode->ViewAttributes() ?>>
<?php echo $pd_analytics->v_countrycode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$pd_analytics_delete->Recordset->MoveNext();
}
$pd_analytics_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pd_analytics_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fpd_analyticsdelete.Init();
</script>
<?php
$pd_analytics_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pd_analytics_delete->Page_Terminate();
?>
