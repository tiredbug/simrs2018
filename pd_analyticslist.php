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

$pd_analytics_list = NULL; // Initialize page object first

class cpd_analytics_list extends cpd_analytics {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pd_analytics';

	// Page object name
	var $PageObjName = 'pd_analytics_list';

	// Grid form hidden field names
	var $FormName = 'fpd_analyticslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "pd_analyticsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "pd_analyticsdelete.php";
		$this->MultiUpdateUrl = "pd_analyticsupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fpd_analyticslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 10;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 10; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->aid->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->aid->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fpd_analyticslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->aid->AdvancedSearch->ToJSON(), ","); // Field aid
		$sFilterList = ew_Concat($sFilterList, $this->v_ipaddr->AdvancedSearch->ToJSON(), ","); // Field v_ipaddr
		$sFilterList = ew_Concat($sFilterList, $this->v_datetime->AdvancedSearch->ToJSON(), ","); // Field v_datetime
		$sFilterList = ew_Concat($sFilterList, $this->v_referer->AdvancedSearch->ToJSON(), ","); // Field v_referer
		$sFilterList = ew_Concat($sFilterList, $this->v_language->AdvancedSearch->ToJSON(), ","); // Field v_language
		$sFilterList = ew_Concat($sFilterList, $this->v_http_cookie->AdvancedSearch->ToJSON(), ","); // Field v_http_cookie
		$sFilterList = ew_Concat($sFilterList, $this->v_locale->AdvancedSearch->ToJSON(), ","); // Field v_locale
		$sFilterList = ew_Concat($sFilterList, $this->v_useragent->AdvancedSearch->ToJSON(), ","); // Field v_useragent
		$sFilterList = ew_Concat($sFilterList, $this->v_remote_addr->AdvancedSearch->ToJSON(), ","); // Field v_remote_addr
		$sFilterList = ew_Concat($sFilterList, $this->v_browser->AdvancedSearch->ToJSON(), ","); // Field v_browser
		$sFilterList = ew_Concat($sFilterList, $this->v_platform->AdvancedSearch->ToJSON(), ","); // Field v_platform
		$sFilterList = ew_Concat($sFilterList, $this->v_version->AdvancedSearch->ToJSON(), ","); // Field v_version
		$sFilterList = ew_Concat($sFilterList, $this->v_city->AdvancedSearch->ToJSON(), ","); // Field v_city
		$sFilterList = ew_Concat($sFilterList, $this->v_country->AdvancedSearch->ToJSON(), ","); // Field v_country
		$sFilterList = ew_Concat($sFilterList, $this->v_countrycode->AdvancedSearch->ToJSON(), ","); // Field v_countrycode
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpd_analyticslistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field aid
		$this->aid->AdvancedSearch->SearchValue = @$filter["x_aid"];
		$this->aid->AdvancedSearch->SearchOperator = @$filter["z_aid"];
		$this->aid->AdvancedSearch->SearchCondition = @$filter["v_aid"];
		$this->aid->AdvancedSearch->SearchValue2 = @$filter["y_aid"];
		$this->aid->AdvancedSearch->SearchOperator2 = @$filter["w_aid"];
		$this->aid->AdvancedSearch->Save();

		// Field v_ipaddr
		$this->v_ipaddr->AdvancedSearch->SearchValue = @$filter["x_v_ipaddr"];
		$this->v_ipaddr->AdvancedSearch->SearchOperator = @$filter["z_v_ipaddr"];
		$this->v_ipaddr->AdvancedSearch->SearchCondition = @$filter["v_v_ipaddr"];
		$this->v_ipaddr->AdvancedSearch->SearchValue2 = @$filter["y_v_ipaddr"];
		$this->v_ipaddr->AdvancedSearch->SearchOperator2 = @$filter["w_v_ipaddr"];
		$this->v_ipaddr->AdvancedSearch->Save();

		// Field v_datetime
		$this->v_datetime->AdvancedSearch->SearchValue = @$filter["x_v_datetime"];
		$this->v_datetime->AdvancedSearch->SearchOperator = @$filter["z_v_datetime"];
		$this->v_datetime->AdvancedSearch->SearchCondition = @$filter["v_v_datetime"];
		$this->v_datetime->AdvancedSearch->SearchValue2 = @$filter["y_v_datetime"];
		$this->v_datetime->AdvancedSearch->SearchOperator2 = @$filter["w_v_datetime"];
		$this->v_datetime->AdvancedSearch->Save();

		// Field v_referer
		$this->v_referer->AdvancedSearch->SearchValue = @$filter["x_v_referer"];
		$this->v_referer->AdvancedSearch->SearchOperator = @$filter["z_v_referer"];
		$this->v_referer->AdvancedSearch->SearchCondition = @$filter["v_v_referer"];
		$this->v_referer->AdvancedSearch->SearchValue2 = @$filter["y_v_referer"];
		$this->v_referer->AdvancedSearch->SearchOperator2 = @$filter["w_v_referer"];
		$this->v_referer->AdvancedSearch->Save();

		// Field v_language
		$this->v_language->AdvancedSearch->SearchValue = @$filter["x_v_language"];
		$this->v_language->AdvancedSearch->SearchOperator = @$filter["z_v_language"];
		$this->v_language->AdvancedSearch->SearchCondition = @$filter["v_v_language"];
		$this->v_language->AdvancedSearch->SearchValue2 = @$filter["y_v_language"];
		$this->v_language->AdvancedSearch->SearchOperator2 = @$filter["w_v_language"];
		$this->v_language->AdvancedSearch->Save();

		// Field v_http_cookie
		$this->v_http_cookie->AdvancedSearch->SearchValue = @$filter["x_v_http_cookie"];
		$this->v_http_cookie->AdvancedSearch->SearchOperator = @$filter["z_v_http_cookie"];
		$this->v_http_cookie->AdvancedSearch->SearchCondition = @$filter["v_v_http_cookie"];
		$this->v_http_cookie->AdvancedSearch->SearchValue2 = @$filter["y_v_http_cookie"];
		$this->v_http_cookie->AdvancedSearch->SearchOperator2 = @$filter["w_v_http_cookie"];
		$this->v_http_cookie->AdvancedSearch->Save();

		// Field v_locale
		$this->v_locale->AdvancedSearch->SearchValue = @$filter["x_v_locale"];
		$this->v_locale->AdvancedSearch->SearchOperator = @$filter["z_v_locale"];
		$this->v_locale->AdvancedSearch->SearchCondition = @$filter["v_v_locale"];
		$this->v_locale->AdvancedSearch->SearchValue2 = @$filter["y_v_locale"];
		$this->v_locale->AdvancedSearch->SearchOperator2 = @$filter["w_v_locale"];
		$this->v_locale->AdvancedSearch->Save();

		// Field v_useragent
		$this->v_useragent->AdvancedSearch->SearchValue = @$filter["x_v_useragent"];
		$this->v_useragent->AdvancedSearch->SearchOperator = @$filter["z_v_useragent"];
		$this->v_useragent->AdvancedSearch->SearchCondition = @$filter["v_v_useragent"];
		$this->v_useragent->AdvancedSearch->SearchValue2 = @$filter["y_v_useragent"];
		$this->v_useragent->AdvancedSearch->SearchOperator2 = @$filter["w_v_useragent"];
		$this->v_useragent->AdvancedSearch->Save();

		// Field v_remote_addr
		$this->v_remote_addr->AdvancedSearch->SearchValue = @$filter["x_v_remote_addr"];
		$this->v_remote_addr->AdvancedSearch->SearchOperator = @$filter["z_v_remote_addr"];
		$this->v_remote_addr->AdvancedSearch->SearchCondition = @$filter["v_v_remote_addr"];
		$this->v_remote_addr->AdvancedSearch->SearchValue2 = @$filter["y_v_remote_addr"];
		$this->v_remote_addr->AdvancedSearch->SearchOperator2 = @$filter["w_v_remote_addr"];
		$this->v_remote_addr->AdvancedSearch->Save();

		// Field v_browser
		$this->v_browser->AdvancedSearch->SearchValue = @$filter["x_v_browser"];
		$this->v_browser->AdvancedSearch->SearchOperator = @$filter["z_v_browser"];
		$this->v_browser->AdvancedSearch->SearchCondition = @$filter["v_v_browser"];
		$this->v_browser->AdvancedSearch->SearchValue2 = @$filter["y_v_browser"];
		$this->v_browser->AdvancedSearch->SearchOperator2 = @$filter["w_v_browser"];
		$this->v_browser->AdvancedSearch->Save();

		// Field v_platform
		$this->v_platform->AdvancedSearch->SearchValue = @$filter["x_v_platform"];
		$this->v_platform->AdvancedSearch->SearchOperator = @$filter["z_v_platform"];
		$this->v_platform->AdvancedSearch->SearchCondition = @$filter["v_v_platform"];
		$this->v_platform->AdvancedSearch->SearchValue2 = @$filter["y_v_platform"];
		$this->v_platform->AdvancedSearch->SearchOperator2 = @$filter["w_v_platform"];
		$this->v_platform->AdvancedSearch->Save();

		// Field v_version
		$this->v_version->AdvancedSearch->SearchValue = @$filter["x_v_version"];
		$this->v_version->AdvancedSearch->SearchOperator = @$filter["z_v_version"];
		$this->v_version->AdvancedSearch->SearchCondition = @$filter["v_v_version"];
		$this->v_version->AdvancedSearch->SearchValue2 = @$filter["y_v_version"];
		$this->v_version->AdvancedSearch->SearchOperator2 = @$filter["w_v_version"];
		$this->v_version->AdvancedSearch->Save();

		// Field v_city
		$this->v_city->AdvancedSearch->SearchValue = @$filter["x_v_city"];
		$this->v_city->AdvancedSearch->SearchOperator = @$filter["z_v_city"];
		$this->v_city->AdvancedSearch->SearchCondition = @$filter["v_v_city"];
		$this->v_city->AdvancedSearch->SearchValue2 = @$filter["y_v_city"];
		$this->v_city->AdvancedSearch->SearchOperator2 = @$filter["w_v_city"];
		$this->v_city->AdvancedSearch->Save();

		// Field v_country
		$this->v_country->AdvancedSearch->SearchValue = @$filter["x_v_country"];
		$this->v_country->AdvancedSearch->SearchOperator = @$filter["z_v_country"];
		$this->v_country->AdvancedSearch->SearchCondition = @$filter["v_v_country"];
		$this->v_country->AdvancedSearch->SearchValue2 = @$filter["y_v_country"];
		$this->v_country->AdvancedSearch->SearchOperator2 = @$filter["w_v_country"];
		$this->v_country->AdvancedSearch->Save();

		// Field v_countrycode
		$this->v_countrycode->AdvancedSearch->SearchValue = @$filter["x_v_countrycode"];
		$this->v_countrycode->AdvancedSearch->SearchOperator = @$filter["z_v_countrycode"];
		$this->v_countrycode->AdvancedSearch->SearchCondition = @$filter["v_v_countrycode"];
		$this->v_countrycode->AdvancedSearch->SearchValue2 = @$filter["y_v_countrycode"];
		$this->v_countrycode->AdvancedSearch->SearchOperator2 = @$filter["w_v_countrycode"];
		$this->v_countrycode->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->v_ipaddr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_referer, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_language, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_http_cookie, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_locale, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_useragent, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_remote_addr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_browser, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_platform, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_version, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_city, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_country, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->v_countrycode, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->aid, $bCtrl); // aid
			$this->UpdateSort($this->v_ipaddr, $bCtrl); // v_ipaddr
			$this->UpdateSort($this->v_datetime, $bCtrl); // v_datetime
			$this->UpdateSort($this->v_referer, $bCtrl); // v_referer
			$this->UpdateSort($this->v_language, $bCtrl); // v_language
			$this->UpdateSort($this->v_http_cookie, $bCtrl); // v_http_cookie
			$this->UpdateSort($this->v_locale, $bCtrl); // v_locale
			$this->UpdateSort($this->v_useragent, $bCtrl); // v_useragent
			$this->UpdateSort($this->v_remote_addr, $bCtrl); // v_remote_addr
			$this->UpdateSort($this->v_browser, $bCtrl); // v_browser
			$this->UpdateSort($this->v_platform, $bCtrl); // v_platform
			$this->UpdateSort($this->v_version, $bCtrl); // v_version
			$this->UpdateSort($this->v_city, $bCtrl); // v_city
			$this->UpdateSort($this->v_country, $bCtrl); // v_country
			$this->UpdateSort($this->v_countrycode, $bCtrl); // v_countrycode
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->aid->setSort("");
				$this->v_ipaddr->setSort("");
				$this->v_datetime->setSort("");
				$this->v_referer->setSort("");
				$this->v_language->setSort("");
				$this->v_http_cookie->setSort("");
				$this->v_locale->setSort("");
				$this->v_useragent->setSort("");
				$this->v_remote_addr->setSort("");
				$this->v_browser->setSort("");
				$this->v_platform->setSort("");
				$this->v_version->setSort("");
				$this->v_city->setSort("");
				$this->v_country->setSort("");
				$this->v_countrycode->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<div class=\"checkbox\"><label><input class=\"magic-checkbox\" type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\"><span></span></label></div>";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"btn btn-info btn-xs\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") ." ". $viewcaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"btn btn-warning btn-xs\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") ." ". $editcaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"btn btn-success btn-xs\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") ." ". $copycaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"btn btn-danger btn-xs\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") ." ". ew_HtmlTitle($Language->Phrase("DeleteLink")) . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . " " . ew_HtmlTitle($caption) . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction btn btn-xs btn-primary\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") ." " . ew_HtmlTitle($caption) . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default ewActions btn-xs line-2053\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->aid->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"btn btn-success btn-xs\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . " $addcaption</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-xs"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpd_analyticslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpd_analyticslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpd_analyticslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpd_analyticslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("aid")) <> "")
			$this->aid->CurrentValue = $this->getKey("aid"); // aid
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($pd_analytics_list)) $pd_analytics_list = new cpd_analytics_list();

// Page init
$pd_analytics_list->Page_Init();

// Page main
$pd_analytics_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pd_analytics_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpd_analyticslist = new ew_Form("fpd_analyticslist", "list");
fpd_analyticslist.FormKeyCountName = '<?php echo $pd_analytics_list->FormKeyCountName ?>';

// Form_CustomValidate event
fpd_analyticslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpd_analyticslist.ValidateRequired = true;
<?php } else { ?>
fpd_analyticslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fpd_analyticslistsrch = new ew_Form("fpd_analyticslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($pd_analytics_list->TotalRecs > 0 && $pd_analytics_list->ExportOptions->Visible()) { ?>
<?php $pd_analytics_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($pd_analytics_list->SearchOptions->Visible()) { ?>
<?php $pd_analytics_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($pd_analytics_list->FilterOptions->Visible()) { ?>
<?php $pd_analytics_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $pd_analytics_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($pd_analytics_list->TotalRecs <= 0)
			$pd_analytics_list->TotalRecs = $pd_analytics->SelectRecordCount();
	} else {
		if (!$pd_analytics_list->Recordset && ($pd_analytics_list->Recordset = $pd_analytics_list->LoadRecordset()))
			$pd_analytics_list->TotalRecs = $pd_analytics_list->Recordset->RecordCount();
	}
	$pd_analytics_list->StartRec = 1;
	if ($pd_analytics_list->DisplayRecs <= 0 || ($pd_analytics->Export <> "" && $pd_analytics->ExportAll)) // Display all records
		$pd_analytics_list->DisplayRecs = $pd_analytics_list->TotalRecs;
	if (!($pd_analytics->Export <> "" && $pd_analytics->ExportAll))
		$pd_analytics_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$pd_analytics_list->Recordset = $pd_analytics_list->LoadRecordset($pd_analytics_list->StartRec-1, $pd_analytics_list->DisplayRecs);

	// Set no record found message
	if ($pd_analytics->CurrentAction == "" && $pd_analytics_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$pd_analytics_list->setWarningMessage(ew_DeniedMsg());
		if ($pd_analytics_list->SearchWhere == "0=101")
			$pd_analytics_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$pd_analytics_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$pd_analytics_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($pd_analytics->Export == "" && $pd_analytics->CurrentAction == "") { ?>
<form name="fpd_analyticslistsrch" id="fpd_analyticslistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($pd_analytics_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpd_analyticslistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pd_analytics">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($pd_analytics_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($pd_analytics_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $pd_analytics_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($pd_analytics_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($pd_analytics_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($pd_analytics_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($pd_analytics_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $pd_analytics_list->ShowPageHeader(); ?>
<?php
$pd_analytics_list->ShowMessage();
?>
<?php if ($pd_analytics_list->TotalRecs > 0 || $pd_analytics->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid pd_analytics">
<form name="fpd_analyticslist" id="fpd_analyticslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pd_analytics_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pd_analytics_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pd_analytics">
<div id="gmp_pd_analytics" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($pd_analytics_list->TotalRecs > 0 || $pd_analytics->CurrentAction == "gridedit") { ?>
<table id="tbl_pd_analyticslist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $pd_analytics->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$pd_analytics_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$pd_analytics_list->RenderListOptions();

// Render list options (header, left)
$pd_analytics_list->ListOptions->Render("header", "left");
?>
<?php if ($pd_analytics->aid->Visible) { // aid ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->aid) == "") { ?>
		<th data-name="aid"><div id="elh_pd_analytics_aid" class="pd_analytics_aid"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->aid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="aid"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->aid) ?>',2);"><div id="elh_pd_analytics_aid" class="pd_analytics_aid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->aid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->aid->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->aid->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_ipaddr->Visible) { // v_ipaddr ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_ipaddr) == "") { ?>
		<th data-name="v_ipaddr"><div id="elh_pd_analytics_v_ipaddr" class="pd_analytics_v_ipaddr"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_ipaddr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_ipaddr"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_ipaddr) ?>',2);"><div id="elh_pd_analytics_v_ipaddr" class="pd_analytics_v_ipaddr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_ipaddr->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_ipaddr->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_ipaddr->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_datetime->Visible) { // v_datetime ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_datetime) == "") { ?>
		<th data-name="v_datetime"><div id="elh_pd_analytics_v_datetime" class="pd_analytics_v_datetime"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_datetime->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_datetime"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_datetime) ?>',2);"><div id="elh_pd_analytics_v_datetime" class="pd_analytics_v_datetime">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_datetime->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_datetime->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_datetime->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_referer->Visible) { // v_referer ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_referer) == "") { ?>
		<th data-name="v_referer"><div id="elh_pd_analytics_v_referer" class="pd_analytics_v_referer"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_referer->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_referer"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_referer) ?>',2);"><div id="elh_pd_analytics_v_referer" class="pd_analytics_v_referer">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_referer->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_referer->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_referer->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_language->Visible) { // v_language ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_language) == "") { ?>
		<th data-name="v_language"><div id="elh_pd_analytics_v_language" class="pd_analytics_v_language"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_language->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_language"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_language) ?>',2);"><div id="elh_pd_analytics_v_language" class="pd_analytics_v_language">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_language->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_language->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_language->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_http_cookie->Visible) { // v_http_cookie ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_http_cookie) == "") { ?>
		<th data-name="v_http_cookie"><div id="elh_pd_analytics_v_http_cookie" class="pd_analytics_v_http_cookie"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_http_cookie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_http_cookie"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_http_cookie) ?>',2);"><div id="elh_pd_analytics_v_http_cookie" class="pd_analytics_v_http_cookie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_http_cookie->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_http_cookie->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_http_cookie->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_locale->Visible) { // v_locale ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_locale) == "") { ?>
		<th data-name="v_locale"><div id="elh_pd_analytics_v_locale" class="pd_analytics_v_locale"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_locale->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_locale"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_locale) ?>',2);"><div id="elh_pd_analytics_v_locale" class="pd_analytics_v_locale">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_locale->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_locale->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_locale->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_useragent->Visible) { // v_useragent ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_useragent) == "") { ?>
		<th data-name="v_useragent"><div id="elh_pd_analytics_v_useragent" class="pd_analytics_v_useragent"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_useragent->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_useragent"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_useragent) ?>',2);"><div id="elh_pd_analytics_v_useragent" class="pd_analytics_v_useragent">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_useragent->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_useragent->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_useragent->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_remote_addr->Visible) { // v_remote_addr ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_remote_addr) == "") { ?>
		<th data-name="v_remote_addr"><div id="elh_pd_analytics_v_remote_addr" class="pd_analytics_v_remote_addr"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_remote_addr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_remote_addr"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_remote_addr) ?>',2);"><div id="elh_pd_analytics_v_remote_addr" class="pd_analytics_v_remote_addr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_remote_addr->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_remote_addr->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_remote_addr->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_browser->Visible) { // v_browser ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_browser) == "") { ?>
		<th data-name="v_browser"><div id="elh_pd_analytics_v_browser" class="pd_analytics_v_browser"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_browser->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_browser"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_browser) ?>',2);"><div id="elh_pd_analytics_v_browser" class="pd_analytics_v_browser">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_browser->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_browser->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_browser->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_platform->Visible) { // v_platform ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_platform) == "") { ?>
		<th data-name="v_platform"><div id="elh_pd_analytics_v_platform" class="pd_analytics_v_platform"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_platform->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_platform"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_platform) ?>',2);"><div id="elh_pd_analytics_v_platform" class="pd_analytics_v_platform">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_platform->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_platform->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_platform->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_version->Visible) { // v_version ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_version) == "") { ?>
		<th data-name="v_version"><div id="elh_pd_analytics_v_version" class="pd_analytics_v_version"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_version->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_version"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_version) ?>',2);"><div id="elh_pd_analytics_v_version" class="pd_analytics_v_version">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_version->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_version->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_version->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_city->Visible) { // v_city ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_city) == "") { ?>
		<th data-name="v_city"><div id="elh_pd_analytics_v_city" class="pd_analytics_v_city"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_city->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_city"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_city) ?>',2);"><div id="elh_pd_analytics_v_city" class="pd_analytics_v_city">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_city->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_city->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_city->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_country->Visible) { // v_country ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_country) == "") { ?>
		<th data-name="v_country"><div id="elh_pd_analytics_v_country" class="pd_analytics_v_country"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_country->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_country"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_country) ?>',2);"><div id="elh_pd_analytics_v_country" class="pd_analytics_v_country">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_country->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_country->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_country->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($pd_analytics->v_countrycode->Visible) { // v_countrycode ?>
	<?php if ($pd_analytics->SortUrl($pd_analytics->v_countrycode) == "") { ?>
		<th data-name="v_countrycode"><div id="elh_pd_analytics_v_countrycode" class="pd_analytics_v_countrycode"><div class="ewTableHeaderCaption"><?php echo $pd_analytics->v_countrycode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="v_countrycode"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $pd_analytics->SortUrl($pd_analytics->v_countrycode) ?>',2);"><div id="elh_pd_analytics_v_countrycode" class="pd_analytics_v_countrycode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $pd_analytics->v_countrycode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($pd_analytics->v_countrycode->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($pd_analytics->v_countrycode->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$pd_analytics_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($pd_analytics->ExportAll && $pd_analytics->Export <> "") {
	$pd_analytics_list->StopRec = $pd_analytics_list->TotalRecs;
} else {

	// Set the last record to display
	if ($pd_analytics_list->TotalRecs > $pd_analytics_list->StartRec + $pd_analytics_list->DisplayRecs - 1)
		$pd_analytics_list->StopRec = $pd_analytics_list->StartRec + $pd_analytics_list->DisplayRecs - 1;
	else
		$pd_analytics_list->StopRec = $pd_analytics_list->TotalRecs;
}
$pd_analytics_list->RecCnt = $pd_analytics_list->StartRec - 1;
if ($pd_analytics_list->Recordset && !$pd_analytics_list->Recordset->EOF) {
	$pd_analytics_list->Recordset->MoveFirst();
	$bSelectLimit = $pd_analytics_list->UseSelectLimit;
	if (!$bSelectLimit && $pd_analytics_list->StartRec > 1)
		$pd_analytics_list->Recordset->Move($pd_analytics_list->StartRec - 1);
} elseif (!$pd_analytics->AllowAddDeleteRow && $pd_analytics_list->StopRec == 0) {
	$pd_analytics_list->StopRec = $pd_analytics->GridAddRowCount;
}

// Initialize aggregate
$pd_analytics->RowType = EW_ROWTYPE_AGGREGATEINIT;
$pd_analytics->ResetAttrs();
$pd_analytics_list->RenderRow();
while ($pd_analytics_list->RecCnt < $pd_analytics_list->StopRec) {
	$pd_analytics_list->RecCnt++;
	if (intval($pd_analytics_list->RecCnt) >= intval($pd_analytics_list->StartRec)) {
		$pd_analytics_list->RowCnt++;

		// Set up key count
		$pd_analytics_list->KeyCount = $pd_analytics_list->RowIndex;

		// Init row class and style
		$pd_analytics->ResetAttrs();
		$pd_analytics->CssClass = "";
		if ($pd_analytics->CurrentAction == "gridadd") {
		} else {
			$pd_analytics_list->LoadRowValues($pd_analytics_list->Recordset); // Load row values
		}
		$pd_analytics->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$pd_analytics->RowAttrs = array_merge($pd_analytics->RowAttrs, array('data-rowindex'=>$pd_analytics_list->RowCnt, 'id'=>'r' . $pd_analytics_list->RowCnt . '_pd_analytics', 'data-rowtype'=>$pd_analytics->RowType));

		// Render row
		$pd_analytics_list->RenderRow();

		// Render list options
		$pd_analytics_list->RenderListOptions();
?>
	<tr<?php echo $pd_analytics->RowAttributes() ?>>
<?php

// Render list options (body, left)
$pd_analytics_list->ListOptions->Render("body", "left", $pd_analytics_list->RowCnt);
?>
	<?php if ($pd_analytics->aid->Visible) { // aid ?>
		<td data-name="aid"<?php echo $pd_analytics->aid->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_aid" class="pd_analytics_aid">
<span<?php echo $pd_analytics->aid->ViewAttributes() ?>>
<?php echo $pd_analytics->aid->ListViewValue() ?></span>
</span>
<a id="<?php echo $pd_analytics_list->PageObjName . "_row_" . $pd_analytics_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($pd_analytics->v_ipaddr->Visible) { // v_ipaddr ?>
		<td data-name="v_ipaddr"<?php echo $pd_analytics->v_ipaddr->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_ipaddr" class="pd_analytics_v_ipaddr">
<span<?php echo $pd_analytics->v_ipaddr->ViewAttributes() ?>>
<?php echo $pd_analytics->v_ipaddr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_datetime->Visible) { // v_datetime ?>
		<td data-name="v_datetime"<?php echo $pd_analytics->v_datetime->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_datetime" class="pd_analytics_v_datetime">
<span<?php echo $pd_analytics->v_datetime->ViewAttributes() ?>>
<?php echo $pd_analytics->v_datetime->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_referer->Visible) { // v_referer ?>
		<td data-name="v_referer"<?php echo $pd_analytics->v_referer->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_referer" class="pd_analytics_v_referer">
<span<?php echo $pd_analytics->v_referer->ViewAttributes() ?>>
<?php echo $pd_analytics->v_referer->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_language->Visible) { // v_language ?>
		<td data-name="v_language"<?php echo $pd_analytics->v_language->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_language" class="pd_analytics_v_language">
<span<?php echo $pd_analytics->v_language->ViewAttributes() ?>>
<?php echo $pd_analytics->v_language->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_http_cookie->Visible) { // v_http_cookie ?>
		<td data-name="v_http_cookie"<?php echo $pd_analytics->v_http_cookie->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_http_cookie" class="pd_analytics_v_http_cookie">
<span<?php echo $pd_analytics->v_http_cookie->ViewAttributes() ?>>
<?php echo $pd_analytics->v_http_cookie->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_locale->Visible) { // v_locale ?>
		<td data-name="v_locale"<?php echo $pd_analytics->v_locale->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_locale" class="pd_analytics_v_locale">
<span<?php echo $pd_analytics->v_locale->ViewAttributes() ?>>
<?php echo $pd_analytics->v_locale->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_useragent->Visible) { // v_useragent ?>
		<td data-name="v_useragent"<?php echo $pd_analytics->v_useragent->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_useragent" class="pd_analytics_v_useragent">
<span<?php echo $pd_analytics->v_useragent->ViewAttributes() ?>>
<?php echo $pd_analytics->v_useragent->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_remote_addr->Visible) { // v_remote_addr ?>
		<td data-name="v_remote_addr"<?php echo $pd_analytics->v_remote_addr->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_remote_addr" class="pd_analytics_v_remote_addr">
<span<?php echo $pd_analytics->v_remote_addr->ViewAttributes() ?>>
<?php echo $pd_analytics->v_remote_addr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_browser->Visible) { // v_browser ?>
		<td data-name="v_browser"<?php echo $pd_analytics->v_browser->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_browser" class="pd_analytics_v_browser">
<span<?php echo $pd_analytics->v_browser->ViewAttributes() ?>>
<?php echo $pd_analytics->v_browser->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_platform->Visible) { // v_platform ?>
		<td data-name="v_platform"<?php echo $pd_analytics->v_platform->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_platform" class="pd_analytics_v_platform">
<span<?php echo $pd_analytics->v_platform->ViewAttributes() ?>>
<?php echo $pd_analytics->v_platform->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_version->Visible) { // v_version ?>
		<td data-name="v_version"<?php echo $pd_analytics->v_version->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_version" class="pd_analytics_v_version">
<span<?php echo $pd_analytics->v_version->ViewAttributes() ?>>
<?php echo $pd_analytics->v_version->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_city->Visible) { // v_city ?>
		<td data-name="v_city"<?php echo $pd_analytics->v_city->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_city" class="pd_analytics_v_city">
<span<?php echo $pd_analytics->v_city->ViewAttributes() ?>>
<?php echo $pd_analytics->v_city->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_country->Visible) { // v_country ?>
		<td data-name="v_country"<?php echo $pd_analytics->v_country->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_country" class="pd_analytics_v_country">
<span<?php echo $pd_analytics->v_country->ViewAttributes() ?>>
<?php echo $pd_analytics->v_country->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($pd_analytics->v_countrycode->Visible) { // v_countrycode ?>
		<td data-name="v_countrycode"<?php echo $pd_analytics->v_countrycode->CellAttributes() ?>>
<span id="el<?php echo $pd_analytics_list->RowCnt ?>_pd_analytics_v_countrycode" class="pd_analytics_v_countrycode">
<span<?php echo $pd_analytics->v_countrycode->ViewAttributes() ?>>
<?php echo $pd_analytics->v_countrycode->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$pd_analytics_list->ListOptions->Render("body", "right", $pd_analytics_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($pd_analytics->CurrentAction <> "gridadd")
		$pd_analytics_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($pd_analytics->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($pd_analytics_list->Recordset)
	$pd_analytics_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($pd_analytics->CurrentAction <> "gridadd" && $pd_analytics->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($pd_analytics_list->Pager)) $pd_analytics_list->Pager = new cPrevNextPager($pd_analytics_list->StartRec, $pd_analytics_list->DisplayRecs, $pd_analytics_list->TotalRecs) ?>
<?php if ($pd_analytics_list->Pager->RecordCount > 0 && $pd_analytics_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($pd_analytics_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $pd_analytics_list->PageUrl() ?>start=<?php echo $pd_analytics_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($pd_analytics_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $pd_analytics_list->PageUrl() ?>start=<?php echo $pd_analytics_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $pd_analytics_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($pd_analytics_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $pd_analytics_list->PageUrl() ?>start=<?php echo $pd_analytics_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($pd_analytics_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $pd_analytics_list->PageUrl() ?>start=<?php echo $pd_analytics_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $pd_analytics_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $pd_analytics_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $pd_analytics_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $pd_analytics_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($pd_analytics_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $pd_analytics_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="pd_analytics">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($pd_analytics_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($pd_analytics_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($pd_analytics_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($pd_analytics_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($pd_analytics_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pd_analytics_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($pd_analytics_list->TotalRecs == 0 && $pd_analytics->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($pd_analytics_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fpd_analyticslistsrch.FilterList = <?php echo $pd_analytics_list->GetFilterList() ?>;
fpd_analyticslistsrch.Init();
fpd_analyticslist.Init();
</script>
<?php
$pd_analytics_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pd_analytics_list->Page_Terminate();
?>
