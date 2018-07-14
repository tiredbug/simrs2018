<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_sensus_harian_rawat_jalaninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_sensus_harian_rawat_jalan_list = NULL; // Initialize page object first

class cvw_sensus_harian_rawat_jalan_list extends cvw_sensus_harian_rawat_jalan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_sensus_harian_rawat_jalan';

	// Page object name
	var $PageObjName = 'vw_sensus_harian_rawat_jalan_list';

	// Grid form hidden field names
	var $FormName = 'fvw_sensus_harian_rawat_jalanlist';
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

		// Table object (vw_sensus_harian_rawat_jalan)
		if (!isset($GLOBALS["vw_sensus_harian_rawat_jalan"]) || get_class($GLOBALS["vw_sensus_harian_rawat_jalan"]) == "cvw_sensus_harian_rawat_jalan") {
			$GLOBALS["vw_sensus_harian_rawat_jalan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_sensus_harian_rawat_jalan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_sensus_harian_rawat_jalanadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_sensus_harian_rawat_jalandelete.php";
		$this->MultiUpdateUrl = "vw_sensus_harian_rawat_jalanupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_sensus_harian_rawat_jalan', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_sensus_harian_rawat_jalanlistsrch";

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
		$this->IDXDAFTAR->SetVisibility();
		$this->IDXDAFTAR->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->NOMR->SetVisibility();
		$this->TGLREG->SetVisibility();
		$this->KDDOKTER->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->KDRUJUK->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->SHIFT->SetVisibility();
		$this->STATUS->SetVisibility();
		$this->PASIENBARU->SetVisibility();
		$this->KETRUJUK->SetVisibility();
		$this->NO_SJP->SetVisibility();

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
		global $EW_EXPORT, $vw_sensus_harian_rawat_jalan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_sensus_harian_rawat_jalan);
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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
			$this->IDXDAFTAR->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->IDXDAFTAR->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_sensus_harian_rawat_jalanlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->TGLREG->AdvancedSearch->ToJSON(), ","); // Field TGLREG
		$sFilterList = ew_Concat($sFilterList, $this->KDPOLY->AdvancedSearch->ToJSON(), ","); // Field KDPOLY
		$sFilterList = ew_Concat($sFilterList, $this->NO_SJP->AdvancedSearch->ToJSON(), ","); // Field NO_SJP
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_sensus_harian_rawat_jalanlistsrch", $filters);

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

		// Field TGLREG
		$this->TGLREG->AdvancedSearch->SearchValue = @$filter["x_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchOperator = @$filter["z_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchCondition = @$filter["v_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchValue2 = @$filter["y_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchOperator2 = @$filter["w_TGLREG"];
		$this->TGLREG->AdvancedSearch->Save();

		// Field KDPOLY
		$this->KDPOLY->AdvancedSearch->SearchValue = @$filter["x_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchOperator = @$filter["z_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchCondition = @$filter["v_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchValue2 = @$filter["y_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchOperator2 = @$filter["w_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->Save();

		// Field NO_SJP
		$this->NO_SJP->AdvancedSearch->SearchValue = @$filter["x_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchOperator = @$filter["z_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchCondition = @$filter["v_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchValue2 = @$filter["y_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchOperator2 = @$filter["w_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->TGLREG, $Default, FALSE); // TGLREG
		$this->BuildSearchSql($sWhere, $this->KDPOLY, $Default, FALSE); // KDPOLY
		$this->BuildSearchSql($sWhere, $this->NO_SJP, $Default, FALSE); // NO_SJP

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->TGLREG->AdvancedSearch->Save(); // TGLREG
			$this->KDPOLY->AdvancedSearch->Save(); // KDPOLY
			$this->NO_SJP->AdvancedSearch->Save(); // NO_SJP
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NOMR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->KETRUJUK, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NO_SJP, $arKeywords, $type);
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
		if ($this->TGLREG->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->KDPOLY->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NO_SJP->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->TGLREG->AdvancedSearch->UnsetSession();
		$this->KDPOLY->AdvancedSearch->UnsetSession();
		$this->NO_SJP->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->TGLREG->AdvancedSearch->Load();
		$this->KDPOLY->AdvancedSearch->Load();
		$this->NO_SJP->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->IDXDAFTAR, $bCtrl); // IDXDAFTAR
			$this->UpdateSort($this->NOMR, $bCtrl); // NOMR
			$this->UpdateSort($this->TGLREG, $bCtrl); // TGLREG
			$this->UpdateSort($this->KDDOKTER, $bCtrl); // KDDOKTER
			$this->UpdateSort($this->KDPOLY, $bCtrl); // KDPOLY
			$this->UpdateSort($this->KDRUJUK, $bCtrl); // KDRUJUK
			$this->UpdateSort($this->KDCARABAYAR, $bCtrl); // KDCARABAYAR
			$this->UpdateSort($this->SHIFT, $bCtrl); // SHIFT
			$this->UpdateSort($this->STATUS, $bCtrl); // STATUS
			$this->UpdateSort($this->PASIENBARU, $bCtrl); // PASIENBARU
			$this->UpdateSort($this->KETRUJUK, $bCtrl); // KETRUJUK
			$this->UpdateSort($this->NO_SJP, $bCtrl); // NO_SJP
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
				$this->IDXDAFTAR->setSort("");
				$this->NOMR->setSort("");
				$this->TGLREG->setSort("");
				$this->KDDOKTER->setSort("");
				$this->KDPOLY->setSort("");
				$this->KDRUJUK->setSort("");
				$this->KDCARABAYAR->setSort("");
				$this->SHIFT->setSort("");
				$this->STATUS->setSort("");
				$this->PASIENBARU->setSort("");
				$this->KETRUJUK->setSort("");
				$this->NO_SJP->setSort("");
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

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
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

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

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
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->IDXDAFTAR->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_sensus_harian_rawat_jalanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_sensus_harian_rawat_jalanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_sensus_harian_rawat_jalanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fvw_sensus_harian_rawat_jalanlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"vw_sensus_harian_rawat_jalansrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// TGLREG

		$this->TGLREG->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_TGLREG"]);
		if ($this->TGLREG->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->TGLREG->AdvancedSearch->SearchOperator = @$_GET["z_TGLREG"];

		// KDPOLY
		$this->KDPOLY->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_KDPOLY"]);
		if ($this->KDPOLY->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->KDPOLY->AdvancedSearch->SearchOperator = @$_GET["z_KDPOLY"];

		// NO_SJP
		$this->NO_SJP->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NO_SJP"]);
		if ($this->NO_SJP->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NO_SJP->AdvancedSearch->SearchOperator = @$_GET["z_NO_SJP"];
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
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
		$this->KETRUJUK->setDbValue($rs->fields('KETRUJUK'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->KDDOKTER->DbValue = $row['KDDOKTER'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->SHIFT->DbValue = $row['SHIFT'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->PASIENBARU->DbValue = $row['PASIENBARU'];
		$this->KETRUJUK->DbValue = $row['KETRUJUK'];
		$this->NO_SJP->DbValue = $row['NO_SJP'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("IDXDAFTAR")) <> "")
			$this->IDXDAFTAR->CurrentValue = $this->getKey("IDXDAFTAR"); // IDXDAFTAR
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
		// IDXDAFTAR
		// NOMR
		// TGLREG
		// KDDOKTER
		// KDPOLY
		// KDRUJUK
		// KDCARABAYAR
		// SHIFT
		// STATUS
		// PASIENBARU
		// KETRUJUK
		// NO_SJP

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDDOKTER
		$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
		$this->KDDOKTER->ViewCustomAttributes = "";

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

		// KDRUJUK
		$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
		$this->KDRUJUK->ViewCustomAttributes = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// SHIFT
		$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
		$this->SHIFT->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// PASIENBARU
		$this->PASIENBARU->ViewValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->ViewCustomAttributes = "";

		// KETRUJUK
		$this->KETRUJUK->ViewValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";
			$this->IDXDAFTAR->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// KDDOKTER
			$this->KDDOKTER->LinkCustomAttributes = "";
			$this->KDDOKTER->HrefValue = "";
			$this->KDDOKTER->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

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

			// STATUS
			$this->STATUS->LinkCustomAttributes = "";
			$this->STATUS->HrefValue = "";
			$this->STATUS->TooltipValue = "";

			// PASIENBARU
			$this->PASIENBARU->LinkCustomAttributes = "";
			$this->PASIENBARU->HrefValue = "";
			$this->PASIENBARU->TooltipValue = "";

			// KETRUJUK
			$this->KETRUJUK->LinkCustomAttributes = "";
			$this->KETRUJUK->HrefValue = "";
			$this->KETRUJUK->TooltipValue = "";

			// NO_SJP
			$this->NO_SJP->LinkCustomAttributes = "";
			$this->NO_SJP->HrefValue = "";
			$this->NO_SJP->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->TGLREG->AdvancedSearch->Load();
		$this->KDPOLY->AdvancedSearch->Load();
		$this->NO_SJP->AdvancedSearch->Load();
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
if (!isset($vw_sensus_harian_rawat_jalan_list)) $vw_sensus_harian_rawat_jalan_list = new cvw_sensus_harian_rawat_jalan_list();

// Page init
$vw_sensus_harian_rawat_jalan_list->Page_Init();

// Page main
$vw_sensus_harian_rawat_jalan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_sensus_harian_rawat_jalan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_sensus_harian_rawat_jalanlist = new ew_Form("fvw_sensus_harian_rawat_jalanlist", "list");
fvw_sensus_harian_rawat_jalanlist.FormKeyCountName = '<?php echo $vw_sensus_harian_rawat_jalan_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvw_sensus_harian_rawat_jalanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_sensus_harian_rawat_jalanlist.ValidateRequired = true;
<?php } else { ?>
fvw_sensus_harian_rawat_jalanlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_sensus_harian_rawat_jalanlist.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};

// Form object for search
var CurrentSearchForm = fvw_sensus_harian_rawat_jalanlistsrch = new ew_Form("fvw_sensus_harian_rawat_jalanlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_sensus_harian_rawat_jalan_list->TotalRecs > 0 && $vw_sensus_harian_rawat_jalan_list->ExportOptions->Visible()) { ?>
<?php $vw_sensus_harian_rawat_jalan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_sensus_harian_rawat_jalan_list->SearchOptions->Visible()) { ?>
<?php $vw_sensus_harian_rawat_jalan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_sensus_harian_rawat_jalan_list->FilterOptions->Visible()) { ?>
<?php $vw_sensus_harian_rawat_jalan_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $vw_sensus_harian_rawat_jalan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_sensus_harian_rawat_jalan_list->TotalRecs <= 0)
			$vw_sensus_harian_rawat_jalan_list->TotalRecs = $vw_sensus_harian_rawat_jalan->SelectRecordCount();
	} else {
		if (!$vw_sensus_harian_rawat_jalan_list->Recordset && ($vw_sensus_harian_rawat_jalan_list->Recordset = $vw_sensus_harian_rawat_jalan_list->LoadRecordset()))
			$vw_sensus_harian_rawat_jalan_list->TotalRecs = $vw_sensus_harian_rawat_jalan_list->Recordset->RecordCount();
	}
	$vw_sensus_harian_rawat_jalan_list->StartRec = 1;
	if ($vw_sensus_harian_rawat_jalan_list->DisplayRecs <= 0 || ($vw_sensus_harian_rawat_jalan->Export <> "" && $vw_sensus_harian_rawat_jalan->ExportAll)) // Display all records
		$vw_sensus_harian_rawat_jalan_list->DisplayRecs = $vw_sensus_harian_rawat_jalan_list->TotalRecs;
	if (!($vw_sensus_harian_rawat_jalan->Export <> "" && $vw_sensus_harian_rawat_jalan->ExportAll))
		$vw_sensus_harian_rawat_jalan_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_sensus_harian_rawat_jalan_list->Recordset = $vw_sensus_harian_rawat_jalan_list->LoadRecordset($vw_sensus_harian_rawat_jalan_list->StartRec-1, $vw_sensus_harian_rawat_jalan_list->DisplayRecs);

	// Set no record found message
	if ($vw_sensus_harian_rawat_jalan->CurrentAction == "" && $vw_sensus_harian_rawat_jalan_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_sensus_harian_rawat_jalan_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_sensus_harian_rawat_jalan_list->SearchWhere == "0=101")
			$vw_sensus_harian_rawat_jalan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_sensus_harian_rawat_jalan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$vw_sensus_harian_rawat_jalan_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($vw_sensus_harian_rawat_jalan->Export == "" && $vw_sensus_harian_rawat_jalan->CurrentAction == "") { ?>
<form name="fvw_sensus_harian_rawat_jalanlistsrch" id="fvw_sensus_harian_rawat_jalanlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($vw_sensus_harian_rawat_jalan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fvw_sensus_harian_rawat_jalanlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vw_sensus_harian_rawat_jalan">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($vw_sensus_harian_rawat_jalan_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($vw_sensus_harian_rawat_jalan_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $vw_sensus_harian_rawat_jalan_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($vw_sensus_harian_rawat_jalan_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($vw_sensus_harian_rawat_jalan_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($vw_sensus_harian_rawat_jalan_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($vw_sensus_harian_rawat_jalan_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $vw_sensus_harian_rawat_jalan_list->ShowPageHeader(); ?>
<?php
$vw_sensus_harian_rawat_jalan_list->ShowMessage();
?>
<?php if ($vw_sensus_harian_rawat_jalan_list->TotalRecs > 0 || $vw_sensus_harian_rawat_jalan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_sensus_harian_rawat_jalan">
<form name="fvw_sensus_harian_rawat_jalanlist" id="fvw_sensus_harian_rawat_jalanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_sensus_harian_rawat_jalan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_sensus_harian_rawat_jalan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_sensus_harian_rawat_jalan">
<div id="gmp_vw_sensus_harian_rawat_jalan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_sensus_harian_rawat_jalan_list->TotalRecs > 0 || $vw_sensus_harian_rawat_jalan->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_sensus_harian_rawat_jalanlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_sensus_harian_rawat_jalan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_sensus_harian_rawat_jalan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_sensus_harian_rawat_jalan_list->RenderListOptions();

// Render list options (header, left)
$vw_sensus_harian_rawat_jalan_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_sensus_harian_rawat_jalan->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->IDXDAFTAR) == "") { ?>
		<th data-name="IDXDAFTAR"><div id="elh_vw_sensus_harian_rawat_jalan_IDXDAFTAR" class="vw_sensus_harian_rawat_jalan_IDXDAFTAR"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->IDXDAFTAR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="IDXDAFTAR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->IDXDAFTAR) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_IDXDAFTAR" class="vw_sensus_harian_rawat_jalan_IDXDAFTAR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->IDXDAFTAR->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->IDXDAFTAR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->IDXDAFTAR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->NOMR->Visible) { // NOMR ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->NOMR) == "") { ?>
		<th data-name="NOMR"><div id="elh_vw_sensus_harian_rawat_jalan_NOMR" class="vw_sensus_harian_rawat_jalan_NOMR"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->NOMR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NOMR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->NOMR) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_NOMR" class="vw_sensus_harian_rawat_jalan_NOMR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->NOMR->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->NOMR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->NOMR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->TGLREG->Visible) { // TGLREG ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->TGLREG) == "") { ?>
		<th data-name="TGLREG"><div id="elh_vw_sensus_harian_rawat_jalan_TGLREG" class="vw_sensus_harian_rawat_jalan_TGLREG"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->TGLREG->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TGLREG"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->TGLREG) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_TGLREG" class="vw_sensus_harian_rawat_jalan_TGLREG">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->TGLREG->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->TGLREG->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->TGLREG->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->KDDOKTER->Visible) { // KDDOKTER ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDDOKTER) == "") { ?>
		<th data-name="KDDOKTER"><div id="elh_vw_sensus_harian_rawat_jalan_KDDOKTER" class="vw_sensus_harian_rawat_jalan_KDDOKTER"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDDOKTER->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDDOKTER"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDDOKTER) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_KDDOKTER" class="vw_sensus_harian_rawat_jalan_KDDOKTER">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDDOKTER->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->KDDOKTER->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->KDDOKTER->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->KDPOLY->Visible) { // KDPOLY ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDPOLY) == "") { ?>
		<th data-name="KDPOLY"><div id="elh_vw_sensus_harian_rawat_jalan_KDPOLY" class="vw_sensus_harian_rawat_jalan_KDPOLY"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDPOLY"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDPOLY) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_KDPOLY" class="vw_sensus_harian_rawat_jalan_KDPOLY">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->KDPOLY->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->KDPOLY->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->KDRUJUK->Visible) { // KDRUJUK ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDRUJUK) == "") { ?>
		<th data-name="KDRUJUK"><div id="elh_vw_sensus_harian_rawat_jalan_KDRUJUK" class="vw_sensus_harian_rawat_jalan_KDRUJUK"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDRUJUK->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDRUJUK"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDRUJUK) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_KDRUJUK" class="vw_sensus_harian_rawat_jalan_KDRUJUK">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDRUJUK->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->KDRUJUK->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->KDRUJUK->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDCARABAYAR) == "") { ?>
		<th data-name="KDCARABAYAR"><div id="elh_vw_sensus_harian_rawat_jalan_KDCARABAYAR" class="vw_sensus_harian_rawat_jalan_KDCARABAYAR"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDCARABAYAR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDCARABAYAR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KDCARABAYAR) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_KDCARABAYAR" class="vw_sensus_harian_rawat_jalan_KDCARABAYAR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KDCARABAYAR->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->KDCARABAYAR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->KDCARABAYAR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->SHIFT->Visible) { // SHIFT ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->SHIFT) == "") { ?>
		<th data-name="SHIFT"><div id="elh_vw_sensus_harian_rawat_jalan_SHIFT" class="vw_sensus_harian_rawat_jalan_SHIFT"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->SHIFT->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SHIFT"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->SHIFT) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_SHIFT" class="vw_sensus_harian_rawat_jalan_SHIFT">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->SHIFT->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->SHIFT->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->SHIFT->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->STATUS->Visible) { // STATUS ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->STATUS) == "") { ?>
		<th data-name="STATUS"><div id="elh_vw_sensus_harian_rawat_jalan_STATUS" class="vw_sensus_harian_rawat_jalan_STATUS"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->STATUS->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="STATUS"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->STATUS) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_STATUS" class="vw_sensus_harian_rawat_jalan_STATUS">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->STATUS->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->STATUS->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->STATUS->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->PASIENBARU->Visible) { // PASIENBARU ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->PASIENBARU) == "") { ?>
		<th data-name="PASIENBARU"><div id="elh_vw_sensus_harian_rawat_jalan_PASIENBARU" class="vw_sensus_harian_rawat_jalan_PASIENBARU"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->PASIENBARU->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PASIENBARU"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->PASIENBARU) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_PASIENBARU" class="vw_sensus_harian_rawat_jalan_PASIENBARU">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->PASIENBARU->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->PASIENBARU->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->PASIENBARU->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->KETRUJUK->Visible) { // KETRUJUK ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KETRUJUK) == "") { ?>
		<th data-name="KETRUJUK"><div id="elh_vw_sensus_harian_rawat_jalan_KETRUJUK" class="vw_sensus_harian_rawat_jalan_KETRUJUK"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KETRUJUK->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KETRUJUK"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->KETRUJUK) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_KETRUJUK" class="vw_sensus_harian_rawat_jalan_KETRUJUK">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->KETRUJUK->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->KETRUJUK->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->KETRUJUK->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_sensus_harian_rawat_jalan->NO_SJP->Visible) { // NO_SJP ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->NO_SJP) == "") { ?>
		<th data-name="NO_SJP"><div id="elh_vw_sensus_harian_rawat_jalan_NO_SJP" class="vw_sensus_harian_rawat_jalan_NO_SJP"><div class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NO_SJP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_sensus_harian_rawat_jalan->SortUrl($vw_sensus_harian_rawat_jalan->NO_SJP) ?>',2);"><div id="elh_vw_sensus_harian_rawat_jalan_NO_SJP" class="vw_sensus_harian_rawat_jalan_NO_SJP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_sensus_harian_rawat_jalan->NO_SJP->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_sensus_harian_rawat_jalan->NO_SJP->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_sensus_harian_rawat_jalan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_sensus_harian_rawat_jalan->ExportAll && $vw_sensus_harian_rawat_jalan->Export <> "") {
	$vw_sensus_harian_rawat_jalan_list->StopRec = $vw_sensus_harian_rawat_jalan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_sensus_harian_rawat_jalan_list->TotalRecs > $vw_sensus_harian_rawat_jalan_list->StartRec + $vw_sensus_harian_rawat_jalan_list->DisplayRecs - 1)
		$vw_sensus_harian_rawat_jalan_list->StopRec = $vw_sensus_harian_rawat_jalan_list->StartRec + $vw_sensus_harian_rawat_jalan_list->DisplayRecs - 1;
	else
		$vw_sensus_harian_rawat_jalan_list->StopRec = $vw_sensus_harian_rawat_jalan_list->TotalRecs;
}
$vw_sensus_harian_rawat_jalan_list->RecCnt = $vw_sensus_harian_rawat_jalan_list->StartRec - 1;
if ($vw_sensus_harian_rawat_jalan_list->Recordset && !$vw_sensus_harian_rawat_jalan_list->Recordset->EOF) {
	$vw_sensus_harian_rawat_jalan_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_sensus_harian_rawat_jalan_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_sensus_harian_rawat_jalan_list->StartRec > 1)
		$vw_sensus_harian_rawat_jalan_list->Recordset->Move($vw_sensus_harian_rawat_jalan_list->StartRec - 1);
} elseif (!$vw_sensus_harian_rawat_jalan->AllowAddDeleteRow && $vw_sensus_harian_rawat_jalan_list->StopRec == 0) {
	$vw_sensus_harian_rawat_jalan_list->StopRec = $vw_sensus_harian_rawat_jalan->GridAddRowCount;
}

// Initialize aggregate
$vw_sensus_harian_rawat_jalan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_sensus_harian_rawat_jalan->ResetAttrs();
$vw_sensus_harian_rawat_jalan_list->RenderRow();
while ($vw_sensus_harian_rawat_jalan_list->RecCnt < $vw_sensus_harian_rawat_jalan_list->StopRec) {
	$vw_sensus_harian_rawat_jalan_list->RecCnt++;
	if (intval($vw_sensus_harian_rawat_jalan_list->RecCnt) >= intval($vw_sensus_harian_rawat_jalan_list->StartRec)) {
		$vw_sensus_harian_rawat_jalan_list->RowCnt++;

		// Set up key count
		$vw_sensus_harian_rawat_jalan_list->KeyCount = $vw_sensus_harian_rawat_jalan_list->RowIndex;

		// Init row class and style
		$vw_sensus_harian_rawat_jalan->ResetAttrs();
		$vw_sensus_harian_rawat_jalan->CssClass = "";
		if ($vw_sensus_harian_rawat_jalan->CurrentAction == "gridadd") {
		} else {
			$vw_sensus_harian_rawat_jalan_list->LoadRowValues($vw_sensus_harian_rawat_jalan_list->Recordset); // Load row values
		}
		$vw_sensus_harian_rawat_jalan->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vw_sensus_harian_rawat_jalan->RowAttrs = array_merge($vw_sensus_harian_rawat_jalan->RowAttrs, array('data-rowindex'=>$vw_sensus_harian_rawat_jalan_list->RowCnt, 'id'=>'r' . $vw_sensus_harian_rawat_jalan_list->RowCnt . '_vw_sensus_harian_rawat_jalan', 'data-rowtype'=>$vw_sensus_harian_rawat_jalan->RowType));

		// Render row
		$vw_sensus_harian_rawat_jalan_list->RenderRow();

		// Render list options
		$vw_sensus_harian_rawat_jalan_list->RenderListOptions();
?>
	<tr<?php echo $vw_sensus_harian_rawat_jalan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_sensus_harian_rawat_jalan_list->ListOptions->Render("body", "left", $vw_sensus_harian_rawat_jalan_list->RowCnt);
?>
	<?php if ($vw_sensus_harian_rawat_jalan->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
		<td data-name="IDXDAFTAR"<?php echo $vw_sensus_harian_rawat_jalan->IDXDAFTAR->CellAttributes() ?>>
<div id="orig<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_IDXDAFTAR" class="hide">
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_IDXDAFTAR" class="vw_sensus_harian_rawat_jalan_IDXDAFTAR">
<span<?php echo $vw_sensus_harian_rawat_jalan->IDXDAFTAR->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->IDXDAFTAR->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-danger btn-xs" 
target="_blank"
href="cetak_sensus_rawat_harian_jalan.php?tgl=<?php echo urlencode(CurrentPage()->TGLREG->CurrentValue)?>&poli=<?php echo urlencode(CurrentPage()->KDPOLY->CurrentValue) ?>"
onclick="return confirm('Klik OK. untuk Cetak Sensus.......,?')">
CETAK_SENSUS<span class="glyphicon glyphicon-print" aria-hidden="true"></span> 
</a> 
<a id="<?php echo $vw_sensus_harian_rawat_jalan_list->PageObjName . "_row_" . $vw_sensus_harian_rawat_jalan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->NOMR->Visible) { // NOMR ?>
		<td data-name="NOMR"<?php echo $vw_sensus_harian_rawat_jalan->NOMR->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_NOMR" class="vw_sensus_harian_rawat_jalan_NOMR">
<span<?php echo $vw_sensus_harian_rawat_jalan->NOMR->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->NOMR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->TGLREG->Visible) { // TGLREG ?>
		<td data-name="TGLREG"<?php echo $vw_sensus_harian_rawat_jalan->TGLREG->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_TGLREG" class="vw_sensus_harian_rawat_jalan_TGLREG">
<span<?php echo $vw_sensus_harian_rawat_jalan->TGLREG->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->TGLREG->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->KDDOKTER->Visible) { // KDDOKTER ?>
		<td data-name="KDDOKTER"<?php echo $vw_sensus_harian_rawat_jalan->KDDOKTER->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_KDDOKTER" class="vw_sensus_harian_rawat_jalan_KDDOKTER">
<span<?php echo $vw_sensus_harian_rawat_jalan->KDDOKTER->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->KDDOKTER->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->KDPOLY->Visible) { // KDPOLY ?>
		<td data-name="KDPOLY"<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_KDPOLY" class="vw_sensus_harian_rawat_jalan_KDPOLY">
<span<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->KDRUJUK->Visible) { // KDRUJUK ?>
		<td data-name="KDRUJUK"<?php echo $vw_sensus_harian_rawat_jalan->KDRUJUK->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_KDRUJUK" class="vw_sensus_harian_rawat_jalan_KDRUJUK">
<span<?php echo $vw_sensus_harian_rawat_jalan->KDRUJUK->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->KDRUJUK->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<td data-name="KDCARABAYAR"<?php echo $vw_sensus_harian_rawat_jalan->KDCARABAYAR->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_KDCARABAYAR" class="vw_sensus_harian_rawat_jalan_KDCARABAYAR">
<span<?php echo $vw_sensus_harian_rawat_jalan->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->KDCARABAYAR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->SHIFT->Visible) { // SHIFT ?>
		<td data-name="SHIFT"<?php echo $vw_sensus_harian_rawat_jalan->SHIFT->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_SHIFT" class="vw_sensus_harian_rawat_jalan_SHIFT">
<span<?php echo $vw_sensus_harian_rawat_jalan->SHIFT->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->SHIFT->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->STATUS->Visible) { // STATUS ?>
		<td data-name="STATUS"<?php echo $vw_sensus_harian_rawat_jalan->STATUS->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_STATUS" class="vw_sensus_harian_rawat_jalan_STATUS">
<span<?php echo $vw_sensus_harian_rawat_jalan->STATUS->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->STATUS->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->PASIENBARU->Visible) { // PASIENBARU ?>
		<td data-name="PASIENBARU"<?php echo $vw_sensus_harian_rawat_jalan->PASIENBARU->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_PASIENBARU" class="vw_sensus_harian_rawat_jalan_PASIENBARU">
<span<?php echo $vw_sensus_harian_rawat_jalan->PASIENBARU->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->PASIENBARU->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->KETRUJUK->Visible) { // KETRUJUK ?>
		<td data-name="KETRUJUK"<?php echo $vw_sensus_harian_rawat_jalan->KETRUJUK->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_KETRUJUK" class="vw_sensus_harian_rawat_jalan_KETRUJUK">
<span<?php echo $vw_sensus_harian_rawat_jalan->KETRUJUK->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->KETRUJUK->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_sensus_harian_rawat_jalan->NO_SJP->Visible) { // NO_SJP ?>
		<td data-name="NO_SJP"<?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->CellAttributes() ?>>
<span id="el<?php echo $vw_sensus_harian_rawat_jalan_list->RowCnt ?>_vw_sensus_harian_rawat_jalan_NO_SJP" class="vw_sensus_harian_rawat_jalan_NO_SJP">
<span<?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->ViewAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_sensus_harian_rawat_jalan_list->ListOptions->Render("body", "right", $vw_sensus_harian_rawat_jalan_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($vw_sensus_harian_rawat_jalan->CurrentAction <> "gridadd")
		$vw_sensus_harian_rawat_jalan_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_sensus_harian_rawat_jalan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_sensus_harian_rawat_jalan_list->Recordset)
	$vw_sensus_harian_rawat_jalan_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_sensus_harian_rawat_jalan->CurrentAction <> "gridadd" && $vw_sensus_harian_rawat_jalan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_sensus_harian_rawat_jalan_list->Pager)) $vw_sensus_harian_rawat_jalan_list->Pager = new cPrevNextPager($vw_sensus_harian_rawat_jalan_list->StartRec, $vw_sensus_harian_rawat_jalan_list->DisplayRecs, $vw_sensus_harian_rawat_jalan_list->TotalRecs) ?>
<?php if ($vw_sensus_harian_rawat_jalan_list->Pager->RecordCount > 0 && $vw_sensus_harian_rawat_jalan_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_sensus_harian_rawat_jalan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_sensus_harian_rawat_jalan_list->PageUrl() ?>start=<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_sensus_harian_rawat_jalan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_sensus_harian_rawat_jalan_list->PageUrl() ?>start=<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_sensus_harian_rawat_jalan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_sensus_harian_rawat_jalan_list->PageUrl() ?>start=<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_sensus_harian_rawat_jalan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_sensus_harian_rawat_jalan_list->PageUrl() ?>start=<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_sensus_harian_rawat_jalan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_sensus_harian_rawat_jalan_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_sensus_harian_rawat_jalan_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_sensus_harian_rawat_jalan">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_sensus_harian_rawat_jalan_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_sensus_harian_rawat_jalan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_sensus_harian_rawat_jalan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_sensus_harian_rawat_jalan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_sensus_harian_rawat_jalan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_sensus_harian_rawat_jalan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_sensus_harian_rawat_jalan_list->TotalRecs == 0 && $vw_sensus_harian_rawat_jalan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_sensus_harian_rawat_jalan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_sensus_harian_rawat_jalanlistsrch.FilterList = <?php echo $vw_sensus_harian_rawat_jalan_list->GetFilterList() ?>;
fvw_sensus_harian_rawat_jalanlistsrch.Init();
fvw_sensus_harian_rawat_jalanlist.Init();
</script>
<?php
$vw_sensus_harian_rawat_jalan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_sensus_harian_rawat_jalan_list->Page_Terminate();
?>
