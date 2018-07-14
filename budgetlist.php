<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "budgetinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$budget_list = NULL; // Initialize page object first

class cbudget_list extends cbudget {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'budget';

	// Page object name
	var $PageObjName = 'budget_list';

	// Grid form hidden field names
	var $FormName = 'fbudgetlist';
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

		// Table object (budget)
		if (!isset($GLOBALS["budget"]) || get_class($GLOBALS["budget"]) == "cbudget") {
			$GLOBALS["budget"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["budget"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "budgetadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "budgetdelete.php";
		$this->MultiUpdateUrl = "budgetupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'budget', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fbudgetlistsrch";

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
		$this->kodkeg->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->kel1->SetVisibility();
		$this->kel2->SetVisibility();
		$this->kel3->SetVisibility();
		$this->kel4->SetVisibility();
		$this->nama->SetVisibility();
		$this->nama1->SetVisibility();
		$this->tw1->SetVisibility();
		$this->tw2->SetVisibility();
		$this->tw3->SetVisibility();
		$this->tw4->SetVisibility();
		$this->so->SetVisibility();
		$this->tri->SetVisibility();
		$this->lap->SetVisibility();
		$this->rek->SetVisibility();
		$this->rek1->SetVisibility();

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
		global $EW_EXPORT, $budget;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($budget);
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
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fbudgetlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->kodkeg->AdvancedSearch->ToJSON(), ","); // Field kodkeg
		$sFilterList = ew_Concat($sFilterList, $this->kegiatan->AdvancedSearch->ToJSON(), ","); // Field kegiatan
		$sFilterList = ew_Concat($sFilterList, $this->kel1->AdvancedSearch->ToJSON(), ","); // Field kel1
		$sFilterList = ew_Concat($sFilterList, $this->kel2->AdvancedSearch->ToJSON(), ","); // Field kel2
		$sFilterList = ew_Concat($sFilterList, $this->kel3->AdvancedSearch->ToJSON(), ","); // Field kel3
		$sFilterList = ew_Concat($sFilterList, $this->kel4->AdvancedSearch->ToJSON(), ","); // Field kel4
		$sFilterList = ew_Concat($sFilterList, $this->nama->AdvancedSearch->ToJSON(), ","); // Field nama
		$sFilterList = ew_Concat($sFilterList, $this->nama1->AdvancedSearch->ToJSON(), ","); // Field nama1
		$sFilterList = ew_Concat($sFilterList, $this->tw1->AdvancedSearch->ToJSON(), ","); // Field tw1
		$sFilterList = ew_Concat($sFilterList, $this->tw2->AdvancedSearch->ToJSON(), ","); // Field tw2
		$sFilterList = ew_Concat($sFilterList, $this->tw3->AdvancedSearch->ToJSON(), ","); // Field tw3
		$sFilterList = ew_Concat($sFilterList, $this->tw4->AdvancedSearch->ToJSON(), ","); // Field tw4
		$sFilterList = ew_Concat($sFilterList, $this->so->AdvancedSearch->ToJSON(), ","); // Field so
		$sFilterList = ew_Concat($sFilterList, $this->tri->AdvancedSearch->ToJSON(), ","); // Field tri
		$sFilterList = ew_Concat($sFilterList, $this->lap->AdvancedSearch->ToJSON(), ","); // Field lap
		$sFilterList = ew_Concat($sFilterList, $this->rek->AdvancedSearch->ToJSON(), ","); // Field rek
		$sFilterList = ew_Concat($sFilterList, $this->rek1->AdvancedSearch->ToJSON(), ","); // Field rek1
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fbudgetlistsrch", $filters);

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

		// Field kodkeg
		$this->kodkeg->AdvancedSearch->SearchValue = @$filter["x_kodkeg"];
		$this->kodkeg->AdvancedSearch->SearchOperator = @$filter["z_kodkeg"];
		$this->kodkeg->AdvancedSearch->SearchCondition = @$filter["v_kodkeg"];
		$this->kodkeg->AdvancedSearch->SearchValue2 = @$filter["y_kodkeg"];
		$this->kodkeg->AdvancedSearch->SearchOperator2 = @$filter["w_kodkeg"];
		$this->kodkeg->AdvancedSearch->Save();

		// Field kegiatan
		$this->kegiatan->AdvancedSearch->SearchValue = @$filter["x_kegiatan"];
		$this->kegiatan->AdvancedSearch->SearchOperator = @$filter["z_kegiatan"];
		$this->kegiatan->AdvancedSearch->SearchCondition = @$filter["v_kegiatan"];
		$this->kegiatan->AdvancedSearch->SearchValue2 = @$filter["y_kegiatan"];
		$this->kegiatan->AdvancedSearch->SearchOperator2 = @$filter["w_kegiatan"];
		$this->kegiatan->AdvancedSearch->Save();

		// Field kel1
		$this->kel1->AdvancedSearch->SearchValue = @$filter["x_kel1"];
		$this->kel1->AdvancedSearch->SearchOperator = @$filter["z_kel1"];
		$this->kel1->AdvancedSearch->SearchCondition = @$filter["v_kel1"];
		$this->kel1->AdvancedSearch->SearchValue2 = @$filter["y_kel1"];
		$this->kel1->AdvancedSearch->SearchOperator2 = @$filter["w_kel1"];
		$this->kel1->AdvancedSearch->Save();

		// Field kel2
		$this->kel2->AdvancedSearch->SearchValue = @$filter["x_kel2"];
		$this->kel2->AdvancedSearch->SearchOperator = @$filter["z_kel2"];
		$this->kel2->AdvancedSearch->SearchCondition = @$filter["v_kel2"];
		$this->kel2->AdvancedSearch->SearchValue2 = @$filter["y_kel2"];
		$this->kel2->AdvancedSearch->SearchOperator2 = @$filter["w_kel2"];
		$this->kel2->AdvancedSearch->Save();

		// Field kel3
		$this->kel3->AdvancedSearch->SearchValue = @$filter["x_kel3"];
		$this->kel3->AdvancedSearch->SearchOperator = @$filter["z_kel3"];
		$this->kel3->AdvancedSearch->SearchCondition = @$filter["v_kel3"];
		$this->kel3->AdvancedSearch->SearchValue2 = @$filter["y_kel3"];
		$this->kel3->AdvancedSearch->SearchOperator2 = @$filter["w_kel3"];
		$this->kel3->AdvancedSearch->Save();

		// Field kel4
		$this->kel4->AdvancedSearch->SearchValue = @$filter["x_kel4"];
		$this->kel4->AdvancedSearch->SearchOperator = @$filter["z_kel4"];
		$this->kel4->AdvancedSearch->SearchCondition = @$filter["v_kel4"];
		$this->kel4->AdvancedSearch->SearchValue2 = @$filter["y_kel4"];
		$this->kel4->AdvancedSearch->SearchOperator2 = @$filter["w_kel4"];
		$this->kel4->AdvancedSearch->Save();

		// Field nama
		$this->nama->AdvancedSearch->SearchValue = @$filter["x_nama"];
		$this->nama->AdvancedSearch->SearchOperator = @$filter["z_nama"];
		$this->nama->AdvancedSearch->SearchCondition = @$filter["v_nama"];
		$this->nama->AdvancedSearch->SearchValue2 = @$filter["y_nama"];
		$this->nama->AdvancedSearch->SearchOperator2 = @$filter["w_nama"];
		$this->nama->AdvancedSearch->Save();

		// Field nama1
		$this->nama1->AdvancedSearch->SearchValue = @$filter["x_nama1"];
		$this->nama1->AdvancedSearch->SearchOperator = @$filter["z_nama1"];
		$this->nama1->AdvancedSearch->SearchCondition = @$filter["v_nama1"];
		$this->nama1->AdvancedSearch->SearchValue2 = @$filter["y_nama1"];
		$this->nama1->AdvancedSearch->SearchOperator2 = @$filter["w_nama1"];
		$this->nama1->AdvancedSearch->Save();

		// Field tw1
		$this->tw1->AdvancedSearch->SearchValue = @$filter["x_tw1"];
		$this->tw1->AdvancedSearch->SearchOperator = @$filter["z_tw1"];
		$this->tw1->AdvancedSearch->SearchCondition = @$filter["v_tw1"];
		$this->tw1->AdvancedSearch->SearchValue2 = @$filter["y_tw1"];
		$this->tw1->AdvancedSearch->SearchOperator2 = @$filter["w_tw1"];
		$this->tw1->AdvancedSearch->Save();

		// Field tw2
		$this->tw2->AdvancedSearch->SearchValue = @$filter["x_tw2"];
		$this->tw2->AdvancedSearch->SearchOperator = @$filter["z_tw2"];
		$this->tw2->AdvancedSearch->SearchCondition = @$filter["v_tw2"];
		$this->tw2->AdvancedSearch->SearchValue2 = @$filter["y_tw2"];
		$this->tw2->AdvancedSearch->SearchOperator2 = @$filter["w_tw2"];
		$this->tw2->AdvancedSearch->Save();

		// Field tw3
		$this->tw3->AdvancedSearch->SearchValue = @$filter["x_tw3"];
		$this->tw3->AdvancedSearch->SearchOperator = @$filter["z_tw3"];
		$this->tw3->AdvancedSearch->SearchCondition = @$filter["v_tw3"];
		$this->tw3->AdvancedSearch->SearchValue2 = @$filter["y_tw3"];
		$this->tw3->AdvancedSearch->SearchOperator2 = @$filter["w_tw3"];
		$this->tw3->AdvancedSearch->Save();

		// Field tw4
		$this->tw4->AdvancedSearch->SearchValue = @$filter["x_tw4"];
		$this->tw4->AdvancedSearch->SearchOperator = @$filter["z_tw4"];
		$this->tw4->AdvancedSearch->SearchCondition = @$filter["v_tw4"];
		$this->tw4->AdvancedSearch->SearchValue2 = @$filter["y_tw4"];
		$this->tw4->AdvancedSearch->SearchOperator2 = @$filter["w_tw4"];
		$this->tw4->AdvancedSearch->Save();

		// Field so
		$this->so->AdvancedSearch->SearchValue = @$filter["x_so"];
		$this->so->AdvancedSearch->SearchOperator = @$filter["z_so"];
		$this->so->AdvancedSearch->SearchCondition = @$filter["v_so"];
		$this->so->AdvancedSearch->SearchValue2 = @$filter["y_so"];
		$this->so->AdvancedSearch->SearchOperator2 = @$filter["w_so"];
		$this->so->AdvancedSearch->Save();

		// Field tri
		$this->tri->AdvancedSearch->SearchValue = @$filter["x_tri"];
		$this->tri->AdvancedSearch->SearchOperator = @$filter["z_tri"];
		$this->tri->AdvancedSearch->SearchCondition = @$filter["v_tri"];
		$this->tri->AdvancedSearch->SearchValue2 = @$filter["y_tri"];
		$this->tri->AdvancedSearch->SearchOperator2 = @$filter["w_tri"];
		$this->tri->AdvancedSearch->Save();

		// Field lap
		$this->lap->AdvancedSearch->SearchValue = @$filter["x_lap"];
		$this->lap->AdvancedSearch->SearchOperator = @$filter["z_lap"];
		$this->lap->AdvancedSearch->SearchCondition = @$filter["v_lap"];
		$this->lap->AdvancedSearch->SearchValue2 = @$filter["y_lap"];
		$this->lap->AdvancedSearch->SearchOperator2 = @$filter["w_lap"];
		$this->lap->AdvancedSearch->Save();

		// Field rek
		$this->rek->AdvancedSearch->SearchValue = @$filter["x_rek"];
		$this->rek->AdvancedSearch->SearchOperator = @$filter["z_rek"];
		$this->rek->AdvancedSearch->SearchCondition = @$filter["v_rek"];
		$this->rek->AdvancedSearch->SearchValue2 = @$filter["y_rek"];
		$this->rek->AdvancedSearch->SearchOperator2 = @$filter["w_rek"];
		$this->rek->AdvancedSearch->Save();

		// Field rek1
		$this->rek1->AdvancedSearch->SearchValue = @$filter["x_rek1"];
		$this->rek1->AdvancedSearch->SearchOperator = @$filter["z_rek1"];
		$this->rek1->AdvancedSearch->SearchCondition = @$filter["v_rek1"];
		$this->rek1->AdvancedSearch->SearchValue2 = @$filter["y_rek1"];
		$this->rek1->AdvancedSearch->SearchOperator2 = @$filter["w_rek1"];
		$this->rek1->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->kodkeg, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kegiatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kel1, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kel2, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kel3, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kel4, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama1, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tri, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->rek, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->rek1, $arKeywords, $type);
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
			$this->UpdateSort($this->kodkeg, $bCtrl); // kodkeg
			$this->UpdateSort($this->kegiatan, $bCtrl); // kegiatan
			$this->UpdateSort($this->kel1, $bCtrl); // kel1
			$this->UpdateSort($this->kel2, $bCtrl); // kel2
			$this->UpdateSort($this->kel3, $bCtrl); // kel3
			$this->UpdateSort($this->kel4, $bCtrl); // kel4
			$this->UpdateSort($this->nama, $bCtrl); // nama
			$this->UpdateSort($this->nama1, $bCtrl); // nama1
			$this->UpdateSort($this->tw1, $bCtrl); // tw1
			$this->UpdateSort($this->tw2, $bCtrl); // tw2
			$this->UpdateSort($this->tw3, $bCtrl); // tw3
			$this->UpdateSort($this->tw4, $bCtrl); // tw4
			$this->UpdateSort($this->so, $bCtrl); // so
			$this->UpdateSort($this->tri, $bCtrl); // tri
			$this->UpdateSort($this->lap, $bCtrl); // lap
			$this->UpdateSort($this->rek, $bCtrl); // rek
			$this->UpdateSort($this->rek1, $bCtrl); // rek1
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
				$this->kodkeg->setSort("");
				$this->kegiatan->setSort("");
				$this->kel1->setSort("");
				$this->kel2->setSort("");
				$this->kel3->setSort("");
				$this->kel4->setSort("");
				$this->nama->setSort("");
				$this->nama1->setSort("");
				$this->tw1->setSort("");
				$this->tw2->setSort("");
				$this->tw3->setSort("");
				$this->tw4->setSort("");
				$this->so->setSort("");
				$this->tri->setSort("");
				$this->lap->setSort("");
				$this->rek->setSort("");
				$this->rek1->setSort("");
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
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fbudgetlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fbudgetlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fbudgetlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fbudgetlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->kodkeg->setDbValue($rs->fields('kodkeg'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->kel1->setDbValue($rs->fields('kel1'));
		$this->kel2->setDbValue($rs->fields('kel2'));
		$this->kel3->setDbValue($rs->fields('kel3'));
		$this->kel4->setDbValue($rs->fields('kel4'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->nama1->setDbValue($rs->fields('nama1'));
		$this->tw1->setDbValue($rs->fields('tw1'));
		$this->tw2->setDbValue($rs->fields('tw2'));
		$this->tw3->setDbValue($rs->fields('tw3'));
		$this->tw4->setDbValue($rs->fields('tw4'));
		$this->so->setDbValue($rs->fields('so'));
		$this->tri->setDbValue($rs->fields('tri'));
		$this->lap->setDbValue($rs->fields('lap'));
		$this->rek->setDbValue($rs->fields('rek'));
		$this->rek1->setDbValue($rs->fields('rek1'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kodkeg->DbValue = $row['kodkeg'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->kel1->DbValue = $row['kel1'];
		$this->kel2->DbValue = $row['kel2'];
		$this->kel3->DbValue = $row['kel3'];
		$this->kel4->DbValue = $row['kel4'];
		$this->nama->DbValue = $row['nama'];
		$this->nama1->DbValue = $row['nama1'];
		$this->tw1->DbValue = $row['tw1'];
		$this->tw2->DbValue = $row['tw2'];
		$this->tw3->DbValue = $row['tw3'];
		$this->tw4->DbValue = $row['tw4'];
		$this->so->DbValue = $row['so'];
		$this->tri->DbValue = $row['tri'];
		$this->lap->DbValue = $row['lap'];
		$this->rek->DbValue = $row['rek'];
		$this->rek1->DbValue = $row['rek1'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;

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
		// kodkeg
		// kegiatan
		// kel1
		// kel2
		// kel3
		// kel4
		// nama
		// nama1
		// tw1
		// tw2
		// tw3
		// tw4
		// so
		// tri
		// lap
		// rek
		// rek1

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kodkeg
		$this->kodkeg->ViewValue = $this->kodkeg->CurrentValue;
		$this->kodkeg->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// kel1
		$this->kel1->ViewValue = $this->kel1->CurrentValue;
		$this->kel1->ViewCustomAttributes = "";

		// kel2
		$this->kel2->ViewValue = $this->kel2->CurrentValue;
		$this->kel2->ViewCustomAttributes = "";

		// kel3
		$this->kel3->ViewValue = $this->kel3->CurrentValue;
		$this->kel3->ViewCustomAttributes = "";

		// kel4
		$this->kel4->ViewValue = $this->kel4->CurrentValue;
		$this->kel4->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// nama1
		$this->nama1->ViewValue = $this->nama1->CurrentValue;
		$this->nama1->ViewCustomAttributes = "";

		// tw1
		$this->tw1->ViewValue = $this->tw1->CurrentValue;
		$this->tw1->ViewCustomAttributes = "";

		// tw2
		$this->tw2->ViewValue = $this->tw2->CurrentValue;
		$this->tw2->ViewCustomAttributes = "";

		// tw3
		$this->tw3->ViewValue = $this->tw3->CurrentValue;
		$this->tw3->ViewCustomAttributes = "";

		// tw4
		$this->tw4->ViewValue = $this->tw4->CurrentValue;
		$this->tw4->ViewCustomAttributes = "";

		// so
		$this->so->ViewValue = $this->so->CurrentValue;
		$this->so->ViewCustomAttributes = "";

		// tri
		$this->tri->ViewValue = $this->tri->CurrentValue;
		$this->tri->ViewCustomAttributes = "";

		// lap
		$this->lap->ViewValue = $this->lap->CurrentValue;
		$this->lap->ViewCustomAttributes = "";

		// rek
		$this->rek->ViewValue = $this->rek->CurrentValue;
		$this->rek->ViewCustomAttributes = "";

		// rek1
		$this->rek1->ViewValue = $this->rek1->CurrentValue;
		$this->rek1->ViewCustomAttributes = "";

			// kodkeg
			$this->kodkeg->LinkCustomAttributes = "";
			$this->kodkeg->HrefValue = "";
			$this->kodkeg->TooltipValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";
			$this->kegiatan->TooltipValue = "";

			// kel1
			$this->kel1->LinkCustomAttributes = "";
			$this->kel1->HrefValue = "";
			$this->kel1->TooltipValue = "";

			// kel2
			$this->kel2->LinkCustomAttributes = "";
			$this->kel2->HrefValue = "";
			$this->kel2->TooltipValue = "";

			// kel3
			$this->kel3->LinkCustomAttributes = "";
			$this->kel3->HrefValue = "";
			$this->kel3->TooltipValue = "";

			// kel4
			$this->kel4->LinkCustomAttributes = "";
			$this->kel4->HrefValue = "";
			$this->kel4->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// nama1
			$this->nama1->LinkCustomAttributes = "";
			$this->nama1->HrefValue = "";
			$this->nama1->TooltipValue = "";

			// tw1
			$this->tw1->LinkCustomAttributes = "";
			$this->tw1->HrefValue = "";
			$this->tw1->TooltipValue = "";

			// tw2
			$this->tw2->LinkCustomAttributes = "";
			$this->tw2->HrefValue = "";
			$this->tw2->TooltipValue = "";

			// tw3
			$this->tw3->LinkCustomAttributes = "";
			$this->tw3->HrefValue = "";
			$this->tw3->TooltipValue = "";

			// tw4
			$this->tw4->LinkCustomAttributes = "";
			$this->tw4->HrefValue = "";
			$this->tw4->TooltipValue = "";

			// so
			$this->so->LinkCustomAttributes = "";
			$this->so->HrefValue = "";
			$this->so->TooltipValue = "";

			// tri
			$this->tri->LinkCustomAttributes = "";
			$this->tri->HrefValue = "";
			$this->tri->TooltipValue = "";

			// lap
			$this->lap->LinkCustomAttributes = "";
			$this->lap->HrefValue = "";
			$this->lap->TooltipValue = "";

			// rek
			$this->rek->LinkCustomAttributes = "";
			$this->rek->HrefValue = "";
			$this->rek->TooltipValue = "";

			// rek1
			$this->rek1->LinkCustomAttributes = "";
			$this->rek1->HrefValue = "";
			$this->rek1->TooltipValue = "";
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
if (!isset($budget_list)) $budget_list = new cbudget_list();

// Page init
$budget_list->Page_Init();

// Page main
$budget_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$budget_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fbudgetlist = new ew_Form("fbudgetlist", "list");
fbudgetlist.FormKeyCountName = '<?php echo $budget_list->FormKeyCountName ?>';

// Form_CustomValidate event
fbudgetlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbudgetlist.ValidateRequired = true;
<?php } else { ?>
fbudgetlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fbudgetlistsrch = new ew_Form("fbudgetlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($budget_list->TotalRecs > 0 && $budget_list->ExportOptions->Visible()) { ?>
<?php $budget_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($budget_list->SearchOptions->Visible()) { ?>
<?php $budget_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($budget_list->FilterOptions->Visible()) { ?>
<?php $budget_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $budget_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($budget_list->TotalRecs <= 0)
			$budget_list->TotalRecs = $budget->SelectRecordCount();
	} else {
		if (!$budget_list->Recordset && ($budget_list->Recordset = $budget_list->LoadRecordset()))
			$budget_list->TotalRecs = $budget_list->Recordset->RecordCount();
	}
	$budget_list->StartRec = 1;
	if ($budget_list->DisplayRecs <= 0 || ($budget->Export <> "" && $budget->ExportAll)) // Display all records
		$budget_list->DisplayRecs = $budget_list->TotalRecs;
	if (!($budget->Export <> "" && $budget->ExportAll))
		$budget_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$budget_list->Recordset = $budget_list->LoadRecordset($budget_list->StartRec-1, $budget_list->DisplayRecs);

	// Set no record found message
	if ($budget->CurrentAction == "" && $budget_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$budget_list->setWarningMessage(ew_DeniedMsg());
		if ($budget_list->SearchWhere == "0=101")
			$budget_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$budget_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$budget_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($budget->Export == "" && $budget->CurrentAction == "") { ?>
<form name="fbudgetlistsrch" id="fbudgetlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($budget_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fbudgetlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="budget">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($budget_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($budget_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $budget_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($budget_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($budget_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($budget_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($budget_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $budget_list->ShowPageHeader(); ?>
<?php
$budget_list->ShowMessage();
?>
<?php if ($budget_list->TotalRecs > 0 || $budget->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid budget">
<form name="fbudgetlist" id="fbudgetlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($budget_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $budget_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="budget">
<div id="gmp_budget" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($budget_list->TotalRecs > 0 || $budget->CurrentAction == "gridedit") { ?>
<table id="tbl_budgetlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $budget->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$budget_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$budget_list->RenderListOptions();

// Render list options (header, left)
$budget_list->ListOptions->Render("header", "left");
?>
<?php if ($budget->kodkeg->Visible) { // kodkeg ?>
	<?php if ($budget->SortUrl($budget->kodkeg) == "") { ?>
		<th data-name="kodkeg"><div id="elh_budget_kodkeg" class="budget_kodkeg"><div class="ewTableHeaderCaption"><?php echo $budget->kodkeg->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kodkeg"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->kodkeg) ?>',2);"><div id="elh_budget_kodkeg" class="budget_kodkeg">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->kodkeg->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->kodkeg->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->kodkeg->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->kegiatan->Visible) { // kegiatan ?>
	<?php if ($budget->SortUrl($budget->kegiatan) == "") { ?>
		<th data-name="kegiatan"><div id="elh_budget_kegiatan" class="budget_kegiatan"><div class="ewTableHeaderCaption"><?php echo $budget->kegiatan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kegiatan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->kegiatan) ?>',2);"><div id="elh_budget_kegiatan" class="budget_kegiatan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->kegiatan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->kegiatan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->kegiatan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->kel1->Visible) { // kel1 ?>
	<?php if ($budget->SortUrl($budget->kel1) == "") { ?>
		<th data-name="kel1"><div id="elh_budget_kel1" class="budget_kel1"><div class="ewTableHeaderCaption"><?php echo $budget->kel1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kel1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->kel1) ?>',2);"><div id="elh_budget_kel1" class="budget_kel1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->kel1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->kel1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->kel1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->kel2->Visible) { // kel2 ?>
	<?php if ($budget->SortUrl($budget->kel2) == "") { ?>
		<th data-name="kel2"><div id="elh_budget_kel2" class="budget_kel2"><div class="ewTableHeaderCaption"><?php echo $budget->kel2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kel2"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->kel2) ?>',2);"><div id="elh_budget_kel2" class="budget_kel2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->kel2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->kel2->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->kel2->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->kel3->Visible) { // kel3 ?>
	<?php if ($budget->SortUrl($budget->kel3) == "") { ?>
		<th data-name="kel3"><div id="elh_budget_kel3" class="budget_kel3"><div class="ewTableHeaderCaption"><?php echo $budget->kel3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kel3"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->kel3) ?>',2);"><div id="elh_budget_kel3" class="budget_kel3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->kel3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->kel3->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->kel3->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->kel4->Visible) { // kel4 ?>
	<?php if ($budget->SortUrl($budget->kel4) == "") { ?>
		<th data-name="kel4"><div id="elh_budget_kel4" class="budget_kel4"><div class="ewTableHeaderCaption"><?php echo $budget->kel4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kel4"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->kel4) ?>',2);"><div id="elh_budget_kel4" class="budget_kel4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->kel4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->kel4->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->kel4->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->nama->Visible) { // nama ?>
	<?php if ($budget->SortUrl($budget->nama) == "") { ?>
		<th data-name="nama"><div id="elh_budget_nama" class="budget_nama"><div class="ewTableHeaderCaption"><?php echo $budget->nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->nama) ?>',2);"><div id="elh_budget_nama" class="budget_nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->nama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->nama->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->nama->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->nama1->Visible) { // nama1 ?>
	<?php if ($budget->SortUrl($budget->nama1) == "") { ?>
		<th data-name="nama1"><div id="elh_budget_nama1" class="budget_nama1"><div class="ewTableHeaderCaption"><?php echo $budget->nama1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->nama1) ?>',2);"><div id="elh_budget_nama1" class="budget_nama1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->nama1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->nama1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->nama1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->tw1->Visible) { // tw1 ?>
	<?php if ($budget->SortUrl($budget->tw1) == "") { ?>
		<th data-name="tw1"><div id="elh_budget_tw1" class="budget_tw1"><div class="ewTableHeaderCaption"><?php echo $budget->tw1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tw1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->tw1) ?>',2);"><div id="elh_budget_tw1" class="budget_tw1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->tw1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($budget->tw1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->tw1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->tw2->Visible) { // tw2 ?>
	<?php if ($budget->SortUrl($budget->tw2) == "") { ?>
		<th data-name="tw2"><div id="elh_budget_tw2" class="budget_tw2"><div class="ewTableHeaderCaption"><?php echo $budget->tw2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tw2"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->tw2) ?>',2);"><div id="elh_budget_tw2" class="budget_tw2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->tw2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($budget->tw2->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->tw2->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->tw3->Visible) { // tw3 ?>
	<?php if ($budget->SortUrl($budget->tw3) == "") { ?>
		<th data-name="tw3"><div id="elh_budget_tw3" class="budget_tw3"><div class="ewTableHeaderCaption"><?php echo $budget->tw3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tw3"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->tw3) ?>',2);"><div id="elh_budget_tw3" class="budget_tw3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->tw3->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($budget->tw3->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->tw3->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->tw4->Visible) { // tw4 ?>
	<?php if ($budget->SortUrl($budget->tw4) == "") { ?>
		<th data-name="tw4"><div id="elh_budget_tw4" class="budget_tw4"><div class="ewTableHeaderCaption"><?php echo $budget->tw4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tw4"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->tw4) ?>',2);"><div id="elh_budget_tw4" class="budget_tw4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->tw4->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($budget->tw4->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->tw4->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->so->Visible) { // so ?>
	<?php if ($budget->SortUrl($budget->so) == "") { ?>
		<th data-name="so"><div id="elh_budget_so" class="budget_so"><div class="ewTableHeaderCaption"><?php echo $budget->so->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="so"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->so) ?>',2);"><div id="elh_budget_so" class="budget_so">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->so->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($budget->so->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->so->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->tri->Visible) { // tri ?>
	<?php if ($budget->SortUrl($budget->tri) == "") { ?>
		<th data-name="tri"><div id="elh_budget_tri" class="budget_tri"><div class="ewTableHeaderCaption"><?php echo $budget->tri->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tri"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->tri) ?>',2);"><div id="elh_budget_tri" class="budget_tri">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->tri->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->tri->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->tri->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->lap->Visible) { // lap ?>
	<?php if ($budget->SortUrl($budget->lap) == "") { ?>
		<th data-name="lap"><div id="elh_budget_lap" class="budget_lap"><div class="ewTableHeaderCaption"><?php echo $budget->lap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lap"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->lap) ?>',2);"><div id="elh_budget_lap" class="budget_lap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->lap->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($budget->lap->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->lap->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->rek->Visible) { // rek ?>
	<?php if ($budget->SortUrl($budget->rek) == "") { ?>
		<th data-name="rek"><div id="elh_budget_rek" class="budget_rek"><div class="ewTableHeaderCaption"><?php echo $budget->rek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rek"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->rek) ?>',2);"><div id="elh_budget_rek" class="budget_rek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->rek->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->rek->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->rek->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($budget->rek1->Visible) { // rek1 ?>
	<?php if ($budget->SortUrl($budget->rek1) == "") { ?>
		<th data-name="rek1"><div id="elh_budget_rek1" class="budget_rek1"><div class="ewTableHeaderCaption"><?php echo $budget->rek1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rek1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $budget->SortUrl($budget->rek1) ?>',2);"><div id="elh_budget_rek1" class="budget_rek1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $budget->rek1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($budget->rek1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($budget->rek1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$budget_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($budget->ExportAll && $budget->Export <> "") {
	$budget_list->StopRec = $budget_list->TotalRecs;
} else {

	// Set the last record to display
	if ($budget_list->TotalRecs > $budget_list->StartRec + $budget_list->DisplayRecs - 1)
		$budget_list->StopRec = $budget_list->StartRec + $budget_list->DisplayRecs - 1;
	else
		$budget_list->StopRec = $budget_list->TotalRecs;
}
$budget_list->RecCnt = $budget_list->StartRec - 1;
if ($budget_list->Recordset && !$budget_list->Recordset->EOF) {
	$budget_list->Recordset->MoveFirst();
	$bSelectLimit = $budget_list->UseSelectLimit;
	if (!$bSelectLimit && $budget_list->StartRec > 1)
		$budget_list->Recordset->Move($budget_list->StartRec - 1);
} elseif (!$budget->AllowAddDeleteRow && $budget_list->StopRec == 0) {
	$budget_list->StopRec = $budget->GridAddRowCount;
}

// Initialize aggregate
$budget->RowType = EW_ROWTYPE_AGGREGATEINIT;
$budget->ResetAttrs();
$budget_list->RenderRow();
while ($budget_list->RecCnt < $budget_list->StopRec) {
	$budget_list->RecCnt++;
	if (intval($budget_list->RecCnt) >= intval($budget_list->StartRec)) {
		$budget_list->RowCnt++;

		// Set up key count
		$budget_list->KeyCount = $budget_list->RowIndex;

		// Init row class and style
		$budget->ResetAttrs();
		$budget->CssClass = "";
		if ($budget->CurrentAction == "gridadd") {
		} else {
			$budget_list->LoadRowValues($budget_list->Recordset); // Load row values
		}
		$budget->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$budget->RowAttrs = array_merge($budget->RowAttrs, array('data-rowindex'=>$budget_list->RowCnt, 'id'=>'r' . $budget_list->RowCnt . '_budget', 'data-rowtype'=>$budget->RowType));

		// Render row
		$budget_list->RenderRow();

		// Render list options
		$budget_list->RenderListOptions();
?>
	<tr<?php echo $budget->RowAttributes() ?>>
<?php

// Render list options (body, left)
$budget_list->ListOptions->Render("body", "left", $budget_list->RowCnt);
?>
	<?php if ($budget->kodkeg->Visible) { // kodkeg ?>
		<td data-name="kodkeg"<?php echo $budget->kodkeg->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_kodkeg" class="budget_kodkeg">
<span<?php echo $budget->kodkeg->ViewAttributes() ?>>
<?php echo $budget->kodkeg->ListViewValue() ?></span>
</span>
<a id="<?php echo $budget_list->PageObjName . "_row_" . $budget_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($budget->kegiatan->Visible) { // kegiatan ?>
		<td data-name="kegiatan"<?php echo $budget->kegiatan->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_kegiatan" class="budget_kegiatan">
<span<?php echo $budget->kegiatan->ViewAttributes() ?>>
<?php echo $budget->kegiatan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->kel1->Visible) { // kel1 ?>
		<td data-name="kel1"<?php echo $budget->kel1->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_kel1" class="budget_kel1">
<span<?php echo $budget->kel1->ViewAttributes() ?>>
<?php echo $budget->kel1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->kel2->Visible) { // kel2 ?>
		<td data-name="kel2"<?php echo $budget->kel2->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_kel2" class="budget_kel2">
<span<?php echo $budget->kel2->ViewAttributes() ?>>
<?php echo $budget->kel2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->kel3->Visible) { // kel3 ?>
		<td data-name="kel3"<?php echo $budget->kel3->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_kel3" class="budget_kel3">
<span<?php echo $budget->kel3->ViewAttributes() ?>>
<?php echo $budget->kel3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->kel4->Visible) { // kel4 ?>
		<td data-name="kel4"<?php echo $budget->kel4->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_kel4" class="budget_kel4">
<span<?php echo $budget->kel4->ViewAttributes() ?>>
<?php echo $budget->kel4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->nama->Visible) { // nama ?>
		<td data-name="nama"<?php echo $budget->nama->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_nama" class="budget_nama">
<span<?php echo $budget->nama->ViewAttributes() ?>>
<?php echo $budget->nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->nama1->Visible) { // nama1 ?>
		<td data-name="nama1"<?php echo $budget->nama1->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_nama1" class="budget_nama1">
<span<?php echo $budget->nama1->ViewAttributes() ?>>
<?php echo $budget->nama1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->tw1->Visible) { // tw1 ?>
		<td data-name="tw1"<?php echo $budget->tw1->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_tw1" class="budget_tw1">
<span<?php echo $budget->tw1->ViewAttributes() ?>>
<?php echo $budget->tw1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->tw2->Visible) { // tw2 ?>
		<td data-name="tw2"<?php echo $budget->tw2->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_tw2" class="budget_tw2">
<span<?php echo $budget->tw2->ViewAttributes() ?>>
<?php echo $budget->tw2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->tw3->Visible) { // tw3 ?>
		<td data-name="tw3"<?php echo $budget->tw3->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_tw3" class="budget_tw3">
<span<?php echo $budget->tw3->ViewAttributes() ?>>
<?php echo $budget->tw3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->tw4->Visible) { // tw4 ?>
		<td data-name="tw4"<?php echo $budget->tw4->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_tw4" class="budget_tw4">
<span<?php echo $budget->tw4->ViewAttributes() ?>>
<?php echo $budget->tw4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->so->Visible) { // so ?>
		<td data-name="so"<?php echo $budget->so->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_so" class="budget_so">
<span<?php echo $budget->so->ViewAttributes() ?>>
<?php echo $budget->so->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->tri->Visible) { // tri ?>
		<td data-name="tri"<?php echo $budget->tri->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_tri" class="budget_tri">
<span<?php echo $budget->tri->ViewAttributes() ?>>
<?php echo $budget->tri->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->lap->Visible) { // lap ?>
		<td data-name="lap"<?php echo $budget->lap->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_lap" class="budget_lap">
<span<?php echo $budget->lap->ViewAttributes() ?>>
<?php echo $budget->lap->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->rek->Visible) { // rek ?>
		<td data-name="rek"<?php echo $budget->rek->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_rek" class="budget_rek">
<span<?php echo $budget->rek->ViewAttributes() ?>>
<?php echo $budget->rek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($budget->rek1->Visible) { // rek1 ?>
		<td data-name="rek1"<?php echo $budget->rek1->CellAttributes() ?>>
<span id="el<?php echo $budget_list->RowCnt ?>_budget_rek1" class="budget_rek1">
<span<?php echo $budget->rek1->ViewAttributes() ?>>
<?php echo $budget->rek1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$budget_list->ListOptions->Render("body", "right", $budget_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($budget->CurrentAction <> "gridadd")
		$budget_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($budget->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($budget_list->Recordset)
	$budget_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($budget->CurrentAction <> "gridadd" && $budget->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($budget_list->Pager)) $budget_list->Pager = new cPrevNextPager($budget_list->StartRec, $budget_list->DisplayRecs, $budget_list->TotalRecs) ?>
<?php if ($budget_list->Pager->RecordCount > 0 && $budget_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($budget_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $budget_list->PageUrl() ?>start=<?php echo $budget_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($budget_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $budget_list->PageUrl() ?>start=<?php echo $budget_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $budget_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($budget_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $budget_list->PageUrl() ?>start=<?php echo $budget_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($budget_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $budget_list->PageUrl() ?>start=<?php echo $budget_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $budget_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $budget_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $budget_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $budget_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($budget_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $budget_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="budget">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($budget_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($budget_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($budget_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($budget_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($budget_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($budget_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($budget_list->TotalRecs == 0 && $budget->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($budget_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fbudgetlistsrch.FilterList = <?php echo $budget_list->GetFilterList() ?>;
fbudgetlistsrch.Init();
fbudgetlist.Init();
</script>
<?php
$budget_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$budget_list->Page_Terminate();
?>
