<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_pasieninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_pasien_list = NULL; // Initialize page object first

class cm_pasien_list extends cm_pasien {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_pasien';

	// Page object name
	var $PageObjName = 'm_pasien_list';

	// Grid form hidden field names
	var $FormName = 'fm_pasienlist';
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

		// Table object (m_pasien)
		if (!isset($GLOBALS["m_pasien"]) || get_class($GLOBALS["m_pasien"]) == "cm_pasien") {
			$GLOBALS["m_pasien"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_pasien"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "m_pasienadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "m_pasiendelete.php";
		$this->MultiUpdateUrl = "m_pasienupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_pasien', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fm_pasienlistsrch";

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
		$this->NOMR->SetVisibility();
		$this->NAMA->SetVisibility();
		$this->TEMPAT->SetVisibility();
		$this->TGLLAHIR->SetVisibility();
		$this->JENISKELAMIN->SetVisibility();
		$this->ALAMAT->SetVisibility();
		$this->NOTELP->SetVisibility();

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
		global $EW_EXPORT, $m_pasien;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_pasien);
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
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fm_pasienlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->NOMR->AdvancedSearch->ToJSON(), ","); // Field NOMR
		$sFilterList = ew_Concat($sFilterList, $this->NAMA->AdvancedSearch->ToJSON(), ","); // Field NAMA
		$sFilterList = ew_Concat($sFilterList, $this->ALAMAT->AdvancedSearch->ToJSON(), ","); // Field ALAMAT
		$sFilterList = ew_Concat($sFilterList, $this->NO_KARTU->AdvancedSearch->ToJSON(), ","); // Field NO_KARTU
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fm_pasienlistsrch", $filters);

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

		// Field NOMR
		$this->NOMR->AdvancedSearch->SearchValue = @$filter["x_NOMR"];
		$this->NOMR->AdvancedSearch->SearchOperator = @$filter["z_NOMR"];
		$this->NOMR->AdvancedSearch->SearchCondition = @$filter["v_NOMR"];
		$this->NOMR->AdvancedSearch->SearchValue2 = @$filter["y_NOMR"];
		$this->NOMR->AdvancedSearch->SearchOperator2 = @$filter["w_NOMR"];
		$this->NOMR->AdvancedSearch->Save();

		// Field NAMA
		$this->NAMA->AdvancedSearch->SearchValue = @$filter["x_NAMA"];
		$this->NAMA->AdvancedSearch->SearchOperator = @$filter["z_NAMA"];
		$this->NAMA->AdvancedSearch->SearchCondition = @$filter["v_NAMA"];
		$this->NAMA->AdvancedSearch->SearchValue2 = @$filter["y_NAMA"];
		$this->NAMA->AdvancedSearch->SearchOperator2 = @$filter["w_NAMA"];
		$this->NAMA->AdvancedSearch->Save();

		// Field ALAMAT
		$this->ALAMAT->AdvancedSearch->SearchValue = @$filter["x_ALAMAT"];
		$this->ALAMAT->AdvancedSearch->SearchOperator = @$filter["z_ALAMAT"];
		$this->ALAMAT->AdvancedSearch->SearchCondition = @$filter["v_ALAMAT"];
		$this->ALAMAT->AdvancedSearch->SearchValue2 = @$filter["y_ALAMAT"];
		$this->ALAMAT->AdvancedSearch->SearchOperator2 = @$filter["w_ALAMAT"];
		$this->ALAMAT->AdvancedSearch->Save();

		// Field NO_KARTU
		$this->NO_KARTU->AdvancedSearch->SearchValue = @$filter["x_NO_KARTU"];
		$this->NO_KARTU->AdvancedSearch->SearchOperator = @$filter["z_NO_KARTU"];
		$this->NO_KARTU->AdvancedSearch->SearchCondition = @$filter["v_NO_KARTU"];
		$this->NO_KARTU->AdvancedSearch->SearchValue2 = @$filter["y_NO_KARTU"];
		$this->NO_KARTU->AdvancedSearch->SearchOperator2 = @$filter["w_NO_KARTU"];
		$this->NO_KARTU->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->NOMR, $Default, FALSE); // NOMR
		$this->BuildSearchSql($sWhere, $this->NAMA, $Default, FALSE); // NAMA
		$this->BuildSearchSql($sWhere, $this->ALAMAT, $Default, FALSE); // ALAMAT
		$this->BuildSearchSql($sWhere, $this->NO_KARTU, $Default, FALSE); // NO_KARTU

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->NOMR->AdvancedSearch->Save(); // NOMR
			$this->NAMA->AdvancedSearch->Save(); // NAMA
			$this->ALAMAT->AdvancedSearch->Save(); // ALAMAT
			$this->NO_KARTU->AdvancedSearch->Save(); // NO_KARTU
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
		$this->BuildBasicSearchSQL($sWhere, $this->NAMA, $arKeywords, $type);
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
		if ($this->NOMR->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NAMA->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->ALAMAT->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NO_KARTU->AdvancedSearch->IssetSession())
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
		$this->NOMR->AdvancedSearch->UnsetSession();
		$this->NAMA->AdvancedSearch->UnsetSession();
		$this->ALAMAT->AdvancedSearch->UnsetSession();
		$this->NO_KARTU->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->NOMR->AdvancedSearch->Load();
		$this->NAMA->AdvancedSearch->Load();
		$this->ALAMAT->AdvancedSearch->Load();
		$this->NO_KARTU->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->NOMR, $bCtrl); // NOMR
			$this->UpdateSort($this->NAMA, $bCtrl); // NAMA
			$this->UpdateSort($this->TEMPAT, $bCtrl); // TEMPAT
			$this->UpdateSort($this->TGLLAHIR, $bCtrl); // TGLLAHIR
			$this->UpdateSort($this->JENISKELAMIN, $bCtrl); // JENISKELAMIN
			$this->UpdateSort($this->ALAMAT, $bCtrl); // ALAMAT
			$this->UpdateSort($this->NOTELP, $bCtrl); // NOTELP
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
				$this->NOMR->setSort("");
				$this->NAMA->setSort("");
				$this->TEMPAT->setSort("");
				$this->TGLLAHIR->setSort("");
				$this->JENISKELAMIN->setSort("");
				$this->ALAMAT->setSort("");
				$this->NOTELP->setSort("");
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
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fm_pasienlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fm_pasienlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fm_pasienlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fm_pasienlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"m_pasiensrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Search highlight button
		$item = &$this->SearchOptions->Add("searchhighlight");
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewHighlight active\" title=\"" . $Language->Phrase("Highlight") . "\" data-caption=\"" . $Language->Phrase("Highlight") . "\" data-toggle=\"button\" data-form=\"fm_pasienlistsrch\" data-name=\"" . $this->HighlightName() . "\">" . $Language->Phrase("HighlightBtn") . "</button>";
		$item->Visible = ($this->SearchWhere <> "" && $this->TotalRecs > 0);

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
		// NOMR

		$this->NOMR->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NOMR"]);
		if ($this->NOMR->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NOMR->AdvancedSearch->SearchOperator = @$_GET["z_NOMR"];

		// NAMA
		$this->NAMA->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NAMA"]);
		if ($this->NAMA->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NAMA->AdvancedSearch->SearchOperator = @$_GET["z_NAMA"];

		// ALAMAT
		$this->ALAMAT->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_ALAMAT"]);
		if ($this->ALAMAT->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->ALAMAT->AdvancedSearch->SearchOperator = @$_GET["z_ALAMAT"];

		// NO_KARTU
		$this->NO_KARTU->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NO_KARTU"]);
		if ($this->NO_KARTU->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NO_KARTU->AdvancedSearch->SearchOperator = @$_GET["z_NO_KARTU"];
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
		$this->id->setDbValue($rs->fields('id'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TITLE->setDbValue($rs->fields('TITLE'));
		$this->NAMA->setDbValue($rs->fields('NAMA'));
		$this->IBUKANDUNG->setDbValue($rs->fields('IBUKANDUNG'));
		$this->TEMPAT->setDbValue($rs->fields('TEMPAT'));
		$this->TGLLAHIR->setDbValue($rs->fields('TGLLAHIR'));
		$this->JENISKELAMIN->setDbValue($rs->fields('JENISKELAMIN'));
		$this->ALAMAT->setDbValue($rs->fields('ALAMAT'));
		$this->KDPROVINSI->setDbValue($rs->fields('KDPROVINSI'));
		$this->KOTA->setDbValue($rs->fields('KOTA'));
		$this->KDKECAMATAN->setDbValue($rs->fields('KDKECAMATAN'));
		$this->KELURAHAN->setDbValue($rs->fields('KELURAHAN'));
		$this->NOTELP->setDbValue($rs->fields('NOTELP'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->SUAMI_ORTU->setDbValue($rs->fields('SUAMI_ORTU'));
		$this->PEKERJAAN->setDbValue($rs->fields('PEKERJAAN'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->AGAMA->setDbValue($rs->fields('AGAMA'));
		$this->PENDIDIKAN->setDbValue($rs->fields('PENDIDIKAN'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->TGLDAFTAR->setDbValue($rs->fields('TGLDAFTAR'));
		$this->ALAMAT_KTP->setDbValue($rs->fields('ALAMAT_KTP'));
		$this->PARENT_NOMR->setDbValue($rs->fields('PARENT_NOMR'));
		$this->NAMA_OBAT->setDbValue($rs->fields('NAMA_OBAT'));
		$this->DOSIS->setDbValue($rs->fields('DOSIS'));
		$this->CARA_PEMBERIAN->setDbValue($rs->fields('CARA_PEMBERIAN'));
		$this->FREKUENSI->setDbValue($rs->fields('FREKUENSI'));
		$this->WAKTU_TGL->setDbValue($rs->fields('WAKTU_TGL'));
		$this->LAMA_WAKTU->setDbValue($rs->fields('LAMA_WAKTU'));
		$this->ALERGI_OBAT->setDbValue($rs->fields('ALERGI_OBAT'));
		$this->REAKSI_ALERGI->setDbValue($rs->fields('REAKSI_ALERGI'));
		$this->RIWAYAT_KES->setDbValue($rs->fields('RIWAYAT_KES'));
		$this->BB_LAHIR->setDbValue($rs->fields('BB_LAHIR'));
		$this->BB_SEKARANG->setDbValue($rs->fields('BB_SEKARANG'));
		$this->FISIK_FONTANEL->setDbValue($rs->fields('FISIK_FONTANEL'));
		$this->FISIK_REFLEKS->setDbValue($rs->fields('FISIK_REFLEKS'));
		$this->FISIK_SENSASI->setDbValue($rs->fields('FISIK_SENSASI'));
		$this->MOTORIK_KASAR->setDbValue($rs->fields('MOTORIK_KASAR'));
		$this->MOTORIK_HALUS->setDbValue($rs->fields('MOTORIK_HALUS'));
		$this->MAMPU_BICARA->setDbValue($rs->fields('MAMPU_BICARA'));
		$this->MAMPU_SOSIALISASI->setDbValue($rs->fields('MAMPU_SOSIALISASI'));
		$this->BCG->setDbValue($rs->fields('BCG'));
		$this->POLIO->setDbValue($rs->fields('POLIO'));
		$this->DPT->setDbValue($rs->fields('DPT'));
		$this->CAMPAK->setDbValue($rs->fields('CAMPAK'));
		$this->HEPATITIS_B->setDbValue($rs->fields('HEPATITIS_B'));
		$this->TD->setDbValue($rs->fields('TD'));
		$this->SUHU->setDbValue($rs->fields('SUHU'));
		$this->RR->setDbValue($rs->fields('RR'));
		$this->NADI->setDbValue($rs->fields('NADI'));
		$this->BB->setDbValue($rs->fields('BB'));
		$this->TB->setDbValue($rs->fields('TB'));
		$this->EYE->setDbValue($rs->fields('EYE'));
		$this->MOTORIK->setDbValue($rs->fields('MOTORIK'));
		$this->VERBAL->setDbValue($rs->fields('VERBAL'));
		$this->TOTAL_GCS->setDbValue($rs->fields('TOTAL_GCS'));
		$this->REAKSI_PUPIL->setDbValue($rs->fields('REAKSI_PUPIL'));
		$this->KESADARAN->setDbValue($rs->fields('KESADARAN'));
		$this->KEPALA->setDbValue($rs->fields('KEPALA'));
		$this->RAMBUT->setDbValue($rs->fields('RAMBUT'));
		$this->MUKA->setDbValue($rs->fields('MUKA'));
		$this->MATA->setDbValue($rs->fields('MATA'));
		$this->GANG_LIHAT->setDbValue($rs->fields('GANG_LIHAT'));
		$this->ALATBANTU_LIHAT->setDbValue($rs->fields('ALATBANTU_LIHAT'));
		$this->BENTUK->setDbValue($rs->fields('BENTUK'));
		$this->PENDENGARAN->setDbValue($rs->fields('PENDENGARAN'));
		$this->LUB_TELINGA->setDbValue($rs->fields('LUB_TELINGA'));
		$this->BENTUK_HIDUNG->setDbValue($rs->fields('BENTUK_HIDUNG'));
		$this->MEMBRAN_MUK->setDbValue($rs->fields('MEMBRAN_MUK'));
		$this->MAMPU_HIDU->setDbValue($rs->fields('MAMPU_HIDU'));
		$this->ALAT_HIDUNG->setDbValue($rs->fields('ALAT_HIDUNG'));
		$this->RONGGA_MULUT->setDbValue($rs->fields('RONGGA_MULUT'));
		$this->WARNA_MEMBRAN->setDbValue($rs->fields('WARNA_MEMBRAN'));
		$this->LEMBAB->setDbValue($rs->fields('LEMBAB'));
		$this->STOMATITIS->setDbValue($rs->fields('STOMATITIS'));
		$this->LIDAH->setDbValue($rs->fields('LIDAH'));
		$this->GIGI->setDbValue($rs->fields('GIGI'));
		$this->TONSIL->setDbValue($rs->fields('TONSIL'));
		$this->KELAINAN->setDbValue($rs->fields('KELAINAN'));
		$this->PERGERAKAN->setDbValue($rs->fields('PERGERAKAN'));
		$this->KEL_TIROID->setDbValue($rs->fields('KEL_TIROID'));
		$this->KEL_GETAH->setDbValue($rs->fields('KEL_GETAH'));
		$this->TEKANAN_VENA->setDbValue($rs->fields('TEKANAN_VENA'));
		$this->REF_MENELAN->setDbValue($rs->fields('REF_MENELAN'));
		$this->NYERI->setDbValue($rs->fields('NYERI'));
		$this->KREPITASI->setDbValue($rs->fields('KREPITASI'));
		$this->KEL_LAIN->setDbValue($rs->fields('KEL_LAIN'));
		$this->BENTUK_DADA->setDbValue($rs->fields('BENTUK_DADA'));
		$this->POLA_NAPAS->setDbValue($rs->fields('POLA_NAPAS'));
		$this->BENTUK_THORAKS->setDbValue($rs->fields('BENTUK_THORAKS'));
		$this->PAL_KREP->setDbValue($rs->fields('PAL_KREP'));
		$this->BENJOLAN->setDbValue($rs->fields('BENJOLAN'));
		$this->PAL_NYERI->setDbValue($rs->fields('PAL_NYERI'));
		$this->PERKUSI->setDbValue($rs->fields('PERKUSI'));
		$this->PARU->setDbValue($rs->fields('PARU'));
		$this->JANTUNG->setDbValue($rs->fields('JANTUNG'));
		$this->SUARA_JANTUNG->setDbValue($rs->fields('SUARA_JANTUNG'));
		$this->ALATBANTU_JAN->setDbValue($rs->fields('ALATBANTU_JAN'));
		$this->BENTUK_ABDOMEN->setDbValue($rs->fields('BENTUK_ABDOMEN'));
		$this->AUSKULTASI->setDbValue($rs->fields('AUSKULTASI'));
		$this->NYERI_PASI->setDbValue($rs->fields('NYERI_PASI'));
		$this->PEM_KELENJAR->setDbValue($rs->fields('PEM_KELENJAR'));
		$this->PERKUSI_AUS->setDbValue($rs->fields('PERKUSI_AUS'));
		$this->VAGINA->setDbValue($rs->fields('VAGINA'));
		$this->MENSTRUASI->setDbValue($rs->fields('MENSTRUASI'));
		$this->KATETER->setDbValue($rs->fields('KATETER'));
		$this->LABIA_PROM->setDbValue($rs->fields('LABIA_PROM'));
		$this->HAMIL->setDbValue($rs->fields('HAMIL'));
		$this->TGL_HAID->setDbValue($rs->fields('TGL_HAID'));
		$this->PERIKSA_CERVIX->setDbValue($rs->fields('PERIKSA_CERVIX'));
		$this->BENTUK_PAYUDARA->setDbValue($rs->fields('BENTUK_PAYUDARA'));
		$this->KENYAL->setDbValue($rs->fields('KENYAL'));
		$this->MASSA->setDbValue($rs->fields('MASSA'));
		$this->NYERI_RABA->setDbValue($rs->fields('NYERI_RABA'));
		$this->BENTUK_PUTING->setDbValue($rs->fields('BENTUK_PUTING'));
		$this->MAMMO->setDbValue($rs->fields('MAMMO'));
		$this->ALAT_KONTRASEPSI->setDbValue($rs->fields('ALAT_KONTRASEPSI'));
		$this->MASALAH_SEKS->setDbValue($rs->fields('MASALAH_SEKS'));
		$this->PREPUTIUM->setDbValue($rs->fields('PREPUTIUM'));
		$this->MASALAH_PROSTAT->setDbValue($rs->fields('MASALAH_PROSTAT'));
		$this->BENTUK_SKROTUM->setDbValue($rs->fields('BENTUK_SKROTUM'));
		$this->TESTIS->setDbValue($rs->fields('TESTIS'));
		$this->MASSA_BEN->setDbValue($rs->fields('MASSA_BEN'));
		$this->HERNIASI->setDbValue($rs->fields('HERNIASI'));
		$this->LAIN2->setDbValue($rs->fields('LAIN2'));
		$this->ALAT_KONTRA->setDbValue($rs->fields('ALAT_KONTRA'));
		$this->MASALAH_REPRO->setDbValue($rs->fields('MASALAH_REPRO'));
		$this->EKSTREMITAS_ATAS->setDbValue($rs->fields('EKSTREMITAS_ATAS'));
		$this->EKSTREMITAS_BAWAH->setDbValue($rs->fields('EKSTREMITAS_BAWAH'));
		$this->AKTIVITAS->setDbValue($rs->fields('AKTIVITAS'));
		$this->BERJALAN->setDbValue($rs->fields('BERJALAN'));
		$this->SISTEM_INTE->setDbValue($rs->fields('SISTEM_INTE'));
		$this->KENYAMANAN->setDbValue($rs->fields('KENYAMANAN'));
		$this->KES_DIRI->setDbValue($rs->fields('KES_DIRI'));
		$this->SOS_SUPORT->setDbValue($rs->fields('SOS_SUPORT'));
		$this->ANSIETAS->setDbValue($rs->fields('ANSIETAS'));
		$this->KEHILANGAN->setDbValue($rs->fields('KEHILANGAN'));
		$this->STATUS_EMOSI->setDbValue($rs->fields('STATUS_EMOSI'));
		$this->KONSEP_DIRI->setDbValue($rs->fields('KONSEP_DIRI'));
		$this->RESPON_HILANG->setDbValue($rs->fields('RESPON_HILANG'));
		$this->SUMBER_STRESS->setDbValue($rs->fields('SUMBER_STRESS'));
		$this->BERARTI->setDbValue($rs->fields('BERARTI'));
		$this->TERLIBAT->setDbValue($rs->fields('TERLIBAT'));
		$this->HUBUNGAN->setDbValue($rs->fields('HUBUNGAN'));
		$this->KOMUNIKASI->setDbValue($rs->fields('KOMUNIKASI'));
		$this->KEPUTUSAN->setDbValue($rs->fields('KEPUTUSAN'));
		$this->MENGASUH->setDbValue($rs->fields('MENGASUH'));
		$this->DUKUNGAN->setDbValue($rs->fields('DUKUNGAN'));
		$this->REAKSI->setDbValue($rs->fields('REAKSI'));
		$this->BUDAYA->setDbValue($rs->fields('BUDAYA'));
		$this->POLA_AKTIVITAS->setDbValue($rs->fields('POLA_AKTIVITAS'));
		$this->POLA_ISTIRAHAT->setDbValue($rs->fields('POLA_ISTIRAHAT'));
		$this->POLA_MAKAN->setDbValue($rs->fields('POLA_MAKAN'));
		$this->PANTANGAN->setDbValue($rs->fields('PANTANGAN'));
		$this->KEPERCAYAAN->setDbValue($rs->fields('KEPERCAYAAN'));
		$this->PANTANGAN_HARI->setDbValue($rs->fields('PANTANGAN_HARI'));
		$this->PANTANGAN_LAIN->setDbValue($rs->fields('PANTANGAN_LAIN'));
		$this->ANJURAN->setDbValue($rs->fields('ANJURAN'));
		$this->NILAI_KEYAKINAN->setDbValue($rs->fields('NILAI_KEYAKINAN'));
		$this->KEGIATAN_IBADAH->setDbValue($rs->fields('KEGIATAN_IBADAH'));
		$this->PENG_AGAMA->setDbValue($rs->fields('PENG_AGAMA'));
		$this->SPIRIT->setDbValue($rs->fields('SPIRIT'));
		$this->BANTUAN->setDbValue($rs->fields('BANTUAN'));
		$this->PAHAM_PENYAKIT->setDbValue($rs->fields('PAHAM_PENYAKIT'));
		$this->PAHAM_OBAT->setDbValue($rs->fields('PAHAM_OBAT'));
		$this->PAHAM_NUTRISI->setDbValue($rs->fields('PAHAM_NUTRISI'));
		$this->PAHAM_RAWAT->setDbValue($rs->fields('PAHAM_RAWAT'));
		$this->HAMBATAN_EDUKASI->setDbValue($rs->fields('HAMBATAN_EDUKASI'));
		$this->FREK_MAKAN->setDbValue($rs->fields('FREK_MAKAN'));
		$this->JUM_MAKAN->setDbValue($rs->fields('JUM_MAKAN'));
		$this->JEN_MAKAN->setDbValue($rs->fields('JEN_MAKAN'));
		$this->KOM_MAKAN->setDbValue($rs->fields('KOM_MAKAN'));
		$this->DIET->setDbValue($rs->fields('DIET'));
		$this->CARA_MAKAN->setDbValue($rs->fields('CARA_MAKAN'));
		$this->GANGGUAN->setDbValue($rs->fields('GANGGUAN'));
		$this->FREK_MINUM->setDbValue($rs->fields('FREK_MINUM'));
		$this->JUM_MINUM->setDbValue($rs->fields('JUM_MINUM'));
		$this->JEN_MINUM->setDbValue($rs->fields('JEN_MINUM'));
		$this->GANG_MINUM->setDbValue($rs->fields('GANG_MINUM'));
		$this->FREK_BAK->setDbValue($rs->fields('FREK_BAK'));
		$this->WARNA_BAK->setDbValue($rs->fields('WARNA_BAK'));
		$this->JMLH_BAK->setDbValue($rs->fields('JMLH_BAK'));
		$this->PENG_KAT_BAK->setDbValue($rs->fields('PENG_KAT_BAK'));
		$this->KEM_HAN_BAK->setDbValue($rs->fields('KEM_HAN_BAK'));
		$this->INKONT_BAK->setDbValue($rs->fields('INKONT_BAK'));
		$this->DIURESIS_BAK->setDbValue($rs->fields('DIURESIS_BAK'));
		$this->FREK_BAB->setDbValue($rs->fields('FREK_BAB'));
		$this->WARNA_BAB->setDbValue($rs->fields('WARNA_BAB'));
		$this->KONSIST_BAB->setDbValue($rs->fields('KONSIST_BAB'));
		$this->GANG_BAB->setDbValue($rs->fields('GANG_BAB'));
		$this->STOMA_BAB->setDbValue($rs->fields('STOMA_BAB'));
		$this->PENG_OBAT_BAB->setDbValue($rs->fields('PENG_OBAT_BAB'));
		$this->IST_SIANG->setDbValue($rs->fields('IST_SIANG'));
		$this->IST_MALAM->setDbValue($rs->fields('IST_MALAM'));
		$this->IST_CAHAYA->setDbValue($rs->fields('IST_CAHAYA'));
		$this->IST_POSISI->setDbValue($rs->fields('IST_POSISI'));
		$this->IST_LING->setDbValue($rs->fields('IST_LING'));
		$this->IST_GANG_TIDUR->setDbValue($rs->fields('IST_GANG_TIDUR'));
		$this->PENG_OBAT_IST->setDbValue($rs->fields('PENG_OBAT_IST'));
		$this->FREK_MAND->setDbValue($rs->fields('FREK_MAND'));
		$this->CUC_RAMB_MAND->setDbValue($rs->fields('CUC_RAMB_MAND'));
		$this->SIH_GIGI_MAND->setDbValue($rs->fields('SIH_GIGI_MAND'));
		$this->BANT_MAND->setDbValue($rs->fields('BANT_MAND'));
		$this->GANT_PAKAI->setDbValue($rs->fields('GANT_PAKAI'));
		$this->PAK_CUCI->setDbValue($rs->fields('PAK_CUCI'));
		$this->PAK_BANT->setDbValue($rs->fields('PAK_BANT'));
		$this->ALT_BANT->setDbValue($rs->fields('ALT_BANT'));
		$this->KEMP_MUND->setDbValue($rs->fields('KEMP_MUND'));
		$this->BIL_PUT->setDbValue($rs->fields('BIL_PUT'));
		$this->ADAPTIF->setDbValue($rs->fields('ADAPTIF'));
		$this->MALADAPTIF->setDbValue($rs->fields('MALADAPTIF'));
		$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields('PENANGGUNGJAWAB_NAMA'));
		$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields('PENANGGUNGJAWAB_HUBUNGAN'));
		$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields('PENANGGUNGJAWAB_ALAMAT'));
		$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields('PENANGGUNGJAWAB_PHONE'));
		$this->obat2->setDbValue($rs->fields('obat2'));
		$this->PERBANDINGAN_BB->setDbValue($rs->fields('PERBANDINGAN_BB'));
		$this->KONTINENSIA->setDbValue($rs->fields('KONTINENSIA'));
		$this->JENIS_KULIT1->setDbValue($rs->fields('JENIS_KULIT1'));
		$this->MOBILITAS->setDbValue($rs->fields('MOBILITAS'));
		$this->JK->setDbValue($rs->fields('JK'));
		$this->UMUR->setDbValue($rs->fields('UMUR'));
		$this->NAFSU_MAKAN->setDbValue($rs->fields('NAFSU_MAKAN'));
		$this->OBAT1->setDbValue($rs->fields('OBAT1'));
		$this->MALNUTRISI->setDbValue($rs->fields('MALNUTRISI'));
		$this->MOTORIK1->setDbValue($rs->fields('MOTORIK1'));
		$this->SPINAL->setDbValue($rs->fields('SPINAL'));
		$this->MEJA_OPERASI->setDbValue($rs->fields('MEJA_OPERASI'));
		$this->RIWAYAT_JATUH->setDbValue($rs->fields('RIWAYAT_JATUH'));
		$this->DIAGNOSIS_SEKUNDER->setDbValue($rs->fields('DIAGNOSIS_SEKUNDER'));
		$this->ALAT_BANTU->setDbValue($rs->fields('ALAT_BANTU'));
		$this->HEPARIN->setDbValue($rs->fields('HEPARIN'));
		$this->GAYA_BERJALAN->setDbValue($rs->fields('GAYA_BERJALAN'));
		$this->KESADARAN1->setDbValue($rs->fields('KESADARAN1'));
		$this->NOMR_LAMA->setDbValue($rs->fields('NOMR_LAMA'));
		$this->NO_KARTU->setDbValue($rs->fields('NO_KARTU'));
		$this->JNS_PASIEN->setDbValue($rs->fields('JNS_PASIEN'));
		$this->nama_ayah->setDbValue($rs->fields('nama_ayah'));
		$this->nama_ibu->setDbValue($rs->fields('nama_ibu'));
		$this->nama_suami->setDbValue($rs->fields('nama_suami'));
		$this->nama_istri->setDbValue($rs->fields('nama_istri'));
		$this->KD_ETNIS->setDbValue($rs->fields('KD_ETNIS'));
		$this->KD_BHS_HARIAN->setDbValue($rs->fields('KD_BHS_HARIAN'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->TITLE->DbValue = $row['TITLE'];
		$this->NAMA->DbValue = $row['NAMA'];
		$this->IBUKANDUNG->DbValue = $row['IBUKANDUNG'];
		$this->TEMPAT->DbValue = $row['TEMPAT'];
		$this->TGLLAHIR->DbValue = $row['TGLLAHIR'];
		$this->JENISKELAMIN->DbValue = $row['JENISKELAMIN'];
		$this->ALAMAT->DbValue = $row['ALAMAT'];
		$this->KDPROVINSI->DbValue = $row['KDPROVINSI'];
		$this->KOTA->DbValue = $row['KOTA'];
		$this->KDKECAMATAN->DbValue = $row['KDKECAMATAN'];
		$this->KELURAHAN->DbValue = $row['KELURAHAN'];
		$this->NOTELP->DbValue = $row['NOTELP'];
		$this->NOKTP->DbValue = $row['NOKTP'];
		$this->SUAMI_ORTU->DbValue = $row['SUAMI_ORTU'];
		$this->PEKERJAAN->DbValue = $row['PEKERJAAN'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->AGAMA->DbValue = $row['AGAMA'];
		$this->PENDIDIKAN->DbValue = $row['PENDIDIKAN'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NIP->DbValue = $row['NIP'];
		$this->TGLDAFTAR->DbValue = $row['TGLDAFTAR'];
		$this->ALAMAT_KTP->DbValue = $row['ALAMAT_KTP'];
		$this->PARENT_NOMR->DbValue = $row['PARENT_NOMR'];
		$this->NAMA_OBAT->DbValue = $row['NAMA_OBAT'];
		$this->DOSIS->DbValue = $row['DOSIS'];
		$this->CARA_PEMBERIAN->DbValue = $row['CARA_PEMBERIAN'];
		$this->FREKUENSI->DbValue = $row['FREKUENSI'];
		$this->WAKTU_TGL->DbValue = $row['WAKTU_TGL'];
		$this->LAMA_WAKTU->DbValue = $row['LAMA_WAKTU'];
		$this->ALERGI_OBAT->DbValue = $row['ALERGI_OBAT'];
		$this->REAKSI_ALERGI->DbValue = $row['REAKSI_ALERGI'];
		$this->RIWAYAT_KES->DbValue = $row['RIWAYAT_KES'];
		$this->BB_LAHIR->DbValue = $row['BB_LAHIR'];
		$this->BB_SEKARANG->DbValue = $row['BB_SEKARANG'];
		$this->FISIK_FONTANEL->DbValue = $row['FISIK_FONTANEL'];
		$this->FISIK_REFLEKS->DbValue = $row['FISIK_REFLEKS'];
		$this->FISIK_SENSASI->DbValue = $row['FISIK_SENSASI'];
		$this->MOTORIK_KASAR->DbValue = $row['MOTORIK_KASAR'];
		$this->MOTORIK_HALUS->DbValue = $row['MOTORIK_HALUS'];
		$this->MAMPU_BICARA->DbValue = $row['MAMPU_BICARA'];
		$this->MAMPU_SOSIALISASI->DbValue = $row['MAMPU_SOSIALISASI'];
		$this->BCG->DbValue = $row['BCG'];
		$this->POLIO->DbValue = $row['POLIO'];
		$this->DPT->DbValue = $row['DPT'];
		$this->CAMPAK->DbValue = $row['CAMPAK'];
		$this->HEPATITIS_B->DbValue = $row['HEPATITIS_B'];
		$this->TD->DbValue = $row['TD'];
		$this->SUHU->DbValue = $row['SUHU'];
		$this->RR->DbValue = $row['RR'];
		$this->NADI->DbValue = $row['NADI'];
		$this->BB->DbValue = $row['BB'];
		$this->TB->DbValue = $row['TB'];
		$this->EYE->DbValue = $row['EYE'];
		$this->MOTORIK->DbValue = $row['MOTORIK'];
		$this->VERBAL->DbValue = $row['VERBAL'];
		$this->TOTAL_GCS->DbValue = $row['TOTAL_GCS'];
		$this->REAKSI_PUPIL->DbValue = $row['REAKSI_PUPIL'];
		$this->KESADARAN->DbValue = $row['KESADARAN'];
		$this->KEPALA->DbValue = $row['KEPALA'];
		$this->RAMBUT->DbValue = $row['RAMBUT'];
		$this->MUKA->DbValue = $row['MUKA'];
		$this->MATA->DbValue = $row['MATA'];
		$this->GANG_LIHAT->DbValue = $row['GANG_LIHAT'];
		$this->ALATBANTU_LIHAT->DbValue = $row['ALATBANTU_LIHAT'];
		$this->BENTUK->DbValue = $row['BENTUK'];
		$this->PENDENGARAN->DbValue = $row['PENDENGARAN'];
		$this->LUB_TELINGA->DbValue = $row['LUB_TELINGA'];
		$this->BENTUK_HIDUNG->DbValue = $row['BENTUK_HIDUNG'];
		$this->MEMBRAN_MUK->DbValue = $row['MEMBRAN_MUK'];
		$this->MAMPU_HIDU->DbValue = $row['MAMPU_HIDU'];
		$this->ALAT_HIDUNG->DbValue = $row['ALAT_HIDUNG'];
		$this->RONGGA_MULUT->DbValue = $row['RONGGA_MULUT'];
		$this->WARNA_MEMBRAN->DbValue = $row['WARNA_MEMBRAN'];
		$this->LEMBAB->DbValue = $row['LEMBAB'];
		$this->STOMATITIS->DbValue = $row['STOMATITIS'];
		$this->LIDAH->DbValue = $row['LIDAH'];
		$this->GIGI->DbValue = $row['GIGI'];
		$this->TONSIL->DbValue = $row['TONSIL'];
		$this->KELAINAN->DbValue = $row['KELAINAN'];
		$this->PERGERAKAN->DbValue = $row['PERGERAKAN'];
		$this->KEL_TIROID->DbValue = $row['KEL_TIROID'];
		$this->KEL_GETAH->DbValue = $row['KEL_GETAH'];
		$this->TEKANAN_VENA->DbValue = $row['TEKANAN_VENA'];
		$this->REF_MENELAN->DbValue = $row['REF_MENELAN'];
		$this->NYERI->DbValue = $row['NYERI'];
		$this->KREPITASI->DbValue = $row['KREPITASI'];
		$this->KEL_LAIN->DbValue = $row['KEL_LAIN'];
		$this->BENTUK_DADA->DbValue = $row['BENTUK_DADA'];
		$this->POLA_NAPAS->DbValue = $row['POLA_NAPAS'];
		$this->BENTUK_THORAKS->DbValue = $row['BENTUK_THORAKS'];
		$this->PAL_KREP->DbValue = $row['PAL_KREP'];
		$this->BENJOLAN->DbValue = $row['BENJOLAN'];
		$this->PAL_NYERI->DbValue = $row['PAL_NYERI'];
		$this->PERKUSI->DbValue = $row['PERKUSI'];
		$this->PARU->DbValue = $row['PARU'];
		$this->JANTUNG->DbValue = $row['JANTUNG'];
		$this->SUARA_JANTUNG->DbValue = $row['SUARA_JANTUNG'];
		$this->ALATBANTU_JAN->DbValue = $row['ALATBANTU_JAN'];
		$this->BENTUK_ABDOMEN->DbValue = $row['BENTUK_ABDOMEN'];
		$this->AUSKULTASI->DbValue = $row['AUSKULTASI'];
		$this->NYERI_PASI->DbValue = $row['NYERI_PASI'];
		$this->PEM_KELENJAR->DbValue = $row['PEM_KELENJAR'];
		$this->PERKUSI_AUS->DbValue = $row['PERKUSI_AUS'];
		$this->VAGINA->DbValue = $row['VAGINA'];
		$this->MENSTRUASI->DbValue = $row['MENSTRUASI'];
		$this->KATETER->DbValue = $row['KATETER'];
		$this->LABIA_PROM->DbValue = $row['LABIA_PROM'];
		$this->HAMIL->DbValue = $row['HAMIL'];
		$this->TGL_HAID->DbValue = $row['TGL_HAID'];
		$this->PERIKSA_CERVIX->DbValue = $row['PERIKSA_CERVIX'];
		$this->BENTUK_PAYUDARA->DbValue = $row['BENTUK_PAYUDARA'];
		$this->KENYAL->DbValue = $row['KENYAL'];
		$this->MASSA->DbValue = $row['MASSA'];
		$this->NYERI_RABA->DbValue = $row['NYERI_RABA'];
		$this->BENTUK_PUTING->DbValue = $row['BENTUK_PUTING'];
		$this->MAMMO->DbValue = $row['MAMMO'];
		$this->ALAT_KONTRASEPSI->DbValue = $row['ALAT_KONTRASEPSI'];
		$this->MASALAH_SEKS->DbValue = $row['MASALAH_SEKS'];
		$this->PREPUTIUM->DbValue = $row['PREPUTIUM'];
		$this->MASALAH_PROSTAT->DbValue = $row['MASALAH_PROSTAT'];
		$this->BENTUK_SKROTUM->DbValue = $row['BENTUK_SKROTUM'];
		$this->TESTIS->DbValue = $row['TESTIS'];
		$this->MASSA_BEN->DbValue = $row['MASSA_BEN'];
		$this->HERNIASI->DbValue = $row['HERNIASI'];
		$this->LAIN2->DbValue = $row['LAIN2'];
		$this->ALAT_KONTRA->DbValue = $row['ALAT_KONTRA'];
		$this->MASALAH_REPRO->DbValue = $row['MASALAH_REPRO'];
		$this->EKSTREMITAS_ATAS->DbValue = $row['EKSTREMITAS_ATAS'];
		$this->EKSTREMITAS_BAWAH->DbValue = $row['EKSTREMITAS_BAWAH'];
		$this->AKTIVITAS->DbValue = $row['AKTIVITAS'];
		$this->BERJALAN->DbValue = $row['BERJALAN'];
		$this->SISTEM_INTE->DbValue = $row['SISTEM_INTE'];
		$this->KENYAMANAN->DbValue = $row['KENYAMANAN'];
		$this->KES_DIRI->DbValue = $row['KES_DIRI'];
		$this->SOS_SUPORT->DbValue = $row['SOS_SUPORT'];
		$this->ANSIETAS->DbValue = $row['ANSIETAS'];
		$this->KEHILANGAN->DbValue = $row['KEHILANGAN'];
		$this->STATUS_EMOSI->DbValue = $row['STATUS_EMOSI'];
		$this->KONSEP_DIRI->DbValue = $row['KONSEP_DIRI'];
		$this->RESPON_HILANG->DbValue = $row['RESPON_HILANG'];
		$this->SUMBER_STRESS->DbValue = $row['SUMBER_STRESS'];
		$this->BERARTI->DbValue = $row['BERARTI'];
		$this->TERLIBAT->DbValue = $row['TERLIBAT'];
		$this->HUBUNGAN->DbValue = $row['HUBUNGAN'];
		$this->KOMUNIKASI->DbValue = $row['KOMUNIKASI'];
		$this->KEPUTUSAN->DbValue = $row['KEPUTUSAN'];
		$this->MENGASUH->DbValue = $row['MENGASUH'];
		$this->DUKUNGAN->DbValue = $row['DUKUNGAN'];
		$this->REAKSI->DbValue = $row['REAKSI'];
		$this->BUDAYA->DbValue = $row['BUDAYA'];
		$this->POLA_AKTIVITAS->DbValue = $row['POLA_AKTIVITAS'];
		$this->POLA_ISTIRAHAT->DbValue = $row['POLA_ISTIRAHAT'];
		$this->POLA_MAKAN->DbValue = $row['POLA_MAKAN'];
		$this->PANTANGAN->DbValue = $row['PANTANGAN'];
		$this->KEPERCAYAAN->DbValue = $row['KEPERCAYAAN'];
		$this->PANTANGAN_HARI->DbValue = $row['PANTANGAN_HARI'];
		$this->PANTANGAN_LAIN->DbValue = $row['PANTANGAN_LAIN'];
		$this->ANJURAN->DbValue = $row['ANJURAN'];
		$this->NILAI_KEYAKINAN->DbValue = $row['NILAI_KEYAKINAN'];
		$this->KEGIATAN_IBADAH->DbValue = $row['KEGIATAN_IBADAH'];
		$this->PENG_AGAMA->DbValue = $row['PENG_AGAMA'];
		$this->SPIRIT->DbValue = $row['SPIRIT'];
		$this->BANTUAN->DbValue = $row['BANTUAN'];
		$this->PAHAM_PENYAKIT->DbValue = $row['PAHAM_PENYAKIT'];
		$this->PAHAM_OBAT->DbValue = $row['PAHAM_OBAT'];
		$this->PAHAM_NUTRISI->DbValue = $row['PAHAM_NUTRISI'];
		$this->PAHAM_RAWAT->DbValue = $row['PAHAM_RAWAT'];
		$this->HAMBATAN_EDUKASI->DbValue = $row['HAMBATAN_EDUKASI'];
		$this->FREK_MAKAN->DbValue = $row['FREK_MAKAN'];
		$this->JUM_MAKAN->DbValue = $row['JUM_MAKAN'];
		$this->JEN_MAKAN->DbValue = $row['JEN_MAKAN'];
		$this->KOM_MAKAN->DbValue = $row['KOM_MAKAN'];
		$this->DIET->DbValue = $row['DIET'];
		$this->CARA_MAKAN->DbValue = $row['CARA_MAKAN'];
		$this->GANGGUAN->DbValue = $row['GANGGUAN'];
		$this->FREK_MINUM->DbValue = $row['FREK_MINUM'];
		$this->JUM_MINUM->DbValue = $row['JUM_MINUM'];
		$this->JEN_MINUM->DbValue = $row['JEN_MINUM'];
		$this->GANG_MINUM->DbValue = $row['GANG_MINUM'];
		$this->FREK_BAK->DbValue = $row['FREK_BAK'];
		$this->WARNA_BAK->DbValue = $row['WARNA_BAK'];
		$this->JMLH_BAK->DbValue = $row['JMLH_BAK'];
		$this->PENG_KAT_BAK->DbValue = $row['PENG_KAT_BAK'];
		$this->KEM_HAN_BAK->DbValue = $row['KEM_HAN_BAK'];
		$this->INKONT_BAK->DbValue = $row['INKONT_BAK'];
		$this->DIURESIS_BAK->DbValue = $row['DIURESIS_BAK'];
		$this->FREK_BAB->DbValue = $row['FREK_BAB'];
		$this->WARNA_BAB->DbValue = $row['WARNA_BAB'];
		$this->KONSIST_BAB->DbValue = $row['KONSIST_BAB'];
		$this->GANG_BAB->DbValue = $row['GANG_BAB'];
		$this->STOMA_BAB->DbValue = $row['STOMA_BAB'];
		$this->PENG_OBAT_BAB->DbValue = $row['PENG_OBAT_BAB'];
		$this->IST_SIANG->DbValue = $row['IST_SIANG'];
		$this->IST_MALAM->DbValue = $row['IST_MALAM'];
		$this->IST_CAHAYA->DbValue = $row['IST_CAHAYA'];
		$this->IST_POSISI->DbValue = $row['IST_POSISI'];
		$this->IST_LING->DbValue = $row['IST_LING'];
		$this->IST_GANG_TIDUR->DbValue = $row['IST_GANG_TIDUR'];
		$this->PENG_OBAT_IST->DbValue = $row['PENG_OBAT_IST'];
		$this->FREK_MAND->DbValue = $row['FREK_MAND'];
		$this->CUC_RAMB_MAND->DbValue = $row['CUC_RAMB_MAND'];
		$this->SIH_GIGI_MAND->DbValue = $row['SIH_GIGI_MAND'];
		$this->BANT_MAND->DbValue = $row['BANT_MAND'];
		$this->GANT_PAKAI->DbValue = $row['GANT_PAKAI'];
		$this->PAK_CUCI->DbValue = $row['PAK_CUCI'];
		$this->PAK_BANT->DbValue = $row['PAK_BANT'];
		$this->ALT_BANT->DbValue = $row['ALT_BANT'];
		$this->KEMP_MUND->DbValue = $row['KEMP_MUND'];
		$this->BIL_PUT->DbValue = $row['BIL_PUT'];
		$this->ADAPTIF->DbValue = $row['ADAPTIF'];
		$this->MALADAPTIF->DbValue = $row['MALADAPTIF'];
		$this->PENANGGUNGJAWAB_NAMA->DbValue = $row['PENANGGUNGJAWAB_NAMA'];
		$this->PENANGGUNGJAWAB_HUBUNGAN->DbValue = $row['PENANGGUNGJAWAB_HUBUNGAN'];
		$this->PENANGGUNGJAWAB_ALAMAT->DbValue = $row['PENANGGUNGJAWAB_ALAMAT'];
		$this->PENANGGUNGJAWAB_PHONE->DbValue = $row['PENANGGUNGJAWAB_PHONE'];
		$this->obat2->DbValue = $row['obat2'];
		$this->PERBANDINGAN_BB->DbValue = $row['PERBANDINGAN_BB'];
		$this->KONTINENSIA->DbValue = $row['KONTINENSIA'];
		$this->JENIS_KULIT1->DbValue = $row['JENIS_KULIT1'];
		$this->MOBILITAS->DbValue = $row['MOBILITAS'];
		$this->JK->DbValue = $row['JK'];
		$this->UMUR->DbValue = $row['UMUR'];
		$this->NAFSU_MAKAN->DbValue = $row['NAFSU_MAKAN'];
		$this->OBAT1->DbValue = $row['OBAT1'];
		$this->MALNUTRISI->DbValue = $row['MALNUTRISI'];
		$this->MOTORIK1->DbValue = $row['MOTORIK1'];
		$this->SPINAL->DbValue = $row['SPINAL'];
		$this->MEJA_OPERASI->DbValue = $row['MEJA_OPERASI'];
		$this->RIWAYAT_JATUH->DbValue = $row['RIWAYAT_JATUH'];
		$this->DIAGNOSIS_SEKUNDER->DbValue = $row['DIAGNOSIS_SEKUNDER'];
		$this->ALAT_BANTU->DbValue = $row['ALAT_BANTU'];
		$this->HEPARIN->DbValue = $row['HEPARIN'];
		$this->GAYA_BERJALAN->DbValue = $row['GAYA_BERJALAN'];
		$this->KESADARAN1->DbValue = $row['KESADARAN1'];
		$this->NOMR_LAMA->DbValue = $row['NOMR_LAMA'];
		$this->NO_KARTU->DbValue = $row['NO_KARTU'];
		$this->JNS_PASIEN->DbValue = $row['JNS_PASIEN'];
		$this->nama_ayah->DbValue = $row['nama_ayah'];
		$this->nama_ibu->DbValue = $row['nama_ibu'];
		$this->nama_suami->DbValue = $row['nama_suami'];
		$this->nama_istri->DbValue = $row['nama_istri'];
		$this->KD_ETNIS->DbValue = $row['KD_ETNIS'];
		$this->KD_BHS_HARIAN->DbValue = $row['KD_BHS_HARIAN'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// NOMR
		// TITLE
		// NAMA
		// IBUKANDUNG
		// TEMPAT
		// TGLLAHIR
		// JENISKELAMIN
		// ALAMAT
		// KDPROVINSI
		// KOTA
		// KDKECAMATAN
		// KELURAHAN
		// NOTELP
		// NOKTP
		// SUAMI_ORTU
		// PEKERJAAN
		// STATUS
		// AGAMA
		// PENDIDIKAN
		// KDCARABAYAR
		// NIP
		// TGLDAFTAR
		// ALAMAT_KTP
		// PARENT_NOMR
		// NAMA_OBAT
		// DOSIS
		// CARA_PEMBERIAN
		// FREKUENSI
		// WAKTU_TGL
		// LAMA_WAKTU
		// ALERGI_OBAT
		// REAKSI_ALERGI
		// RIWAYAT_KES
		// BB_LAHIR
		// BB_SEKARANG
		// FISIK_FONTANEL
		// FISIK_REFLEKS
		// FISIK_SENSASI
		// MOTORIK_KASAR
		// MOTORIK_HALUS
		// MAMPU_BICARA
		// MAMPU_SOSIALISASI
		// BCG
		// POLIO
		// DPT
		// CAMPAK
		// HEPATITIS_B
		// TD
		// SUHU
		// RR
		// NADI
		// BB
		// TB
		// EYE
		// MOTORIK
		// VERBAL
		// TOTAL_GCS
		// REAKSI_PUPIL
		// KESADARAN
		// KEPALA
		// RAMBUT
		// MUKA
		// MATA
		// GANG_LIHAT
		// ALATBANTU_LIHAT
		// BENTUK
		// PENDENGARAN
		// LUB_TELINGA
		// BENTUK_HIDUNG
		// MEMBRAN_MUK
		// MAMPU_HIDU
		// ALAT_HIDUNG
		// RONGGA_MULUT
		// WARNA_MEMBRAN
		// LEMBAB
		// STOMATITIS
		// LIDAH
		// GIGI
		// TONSIL
		// KELAINAN
		// PERGERAKAN
		// KEL_TIROID
		// KEL_GETAH
		// TEKANAN_VENA
		// REF_MENELAN
		// NYERI
		// KREPITASI
		// KEL_LAIN
		// BENTUK_DADA
		// POLA_NAPAS
		// BENTUK_THORAKS
		// PAL_KREP
		// BENJOLAN
		// PAL_NYERI
		// PERKUSI
		// PARU
		// JANTUNG
		// SUARA_JANTUNG
		// ALATBANTU_JAN
		// BENTUK_ABDOMEN
		// AUSKULTASI
		// NYERI_PASI
		// PEM_KELENJAR
		// PERKUSI_AUS
		// VAGINA
		// MENSTRUASI
		// KATETER
		// LABIA_PROM
		// HAMIL
		// TGL_HAID
		// PERIKSA_CERVIX
		// BENTUK_PAYUDARA
		// KENYAL
		// MASSA
		// NYERI_RABA
		// BENTUK_PUTING
		// MAMMO
		// ALAT_KONTRASEPSI
		// MASALAH_SEKS
		// PREPUTIUM
		// MASALAH_PROSTAT
		// BENTUK_SKROTUM
		// TESTIS
		// MASSA_BEN
		// HERNIASI
		// LAIN2
		// ALAT_KONTRA
		// MASALAH_REPRO
		// EKSTREMITAS_ATAS
		// EKSTREMITAS_BAWAH
		// AKTIVITAS
		// BERJALAN
		// SISTEM_INTE
		// KENYAMANAN
		// KES_DIRI
		// SOS_SUPORT
		// ANSIETAS
		// KEHILANGAN
		// STATUS_EMOSI
		// KONSEP_DIRI
		// RESPON_HILANG
		// SUMBER_STRESS
		// BERARTI
		// TERLIBAT
		// HUBUNGAN
		// KOMUNIKASI
		// KEPUTUSAN
		// MENGASUH
		// DUKUNGAN
		// REAKSI
		// BUDAYA
		// POLA_AKTIVITAS
		// POLA_ISTIRAHAT
		// POLA_MAKAN
		// PANTANGAN
		// KEPERCAYAAN
		// PANTANGAN_HARI
		// PANTANGAN_LAIN
		// ANJURAN
		// NILAI_KEYAKINAN
		// KEGIATAN_IBADAH
		// PENG_AGAMA
		// SPIRIT
		// BANTUAN
		// PAHAM_PENYAKIT
		// PAHAM_OBAT
		// PAHAM_NUTRISI
		// PAHAM_RAWAT
		// HAMBATAN_EDUKASI
		// FREK_MAKAN
		// JUM_MAKAN
		// JEN_MAKAN
		// KOM_MAKAN
		// DIET
		// CARA_MAKAN
		// GANGGUAN
		// FREK_MINUM
		// JUM_MINUM
		// JEN_MINUM
		// GANG_MINUM
		// FREK_BAK
		// WARNA_BAK
		// JMLH_BAK
		// PENG_KAT_BAK
		// KEM_HAN_BAK
		// INKONT_BAK
		// DIURESIS_BAK
		// FREK_BAB
		// WARNA_BAB
		// KONSIST_BAB
		// GANG_BAB
		// STOMA_BAB
		// PENG_OBAT_BAB
		// IST_SIANG
		// IST_MALAM
		// IST_CAHAYA
		// IST_POSISI
		// IST_LING
		// IST_GANG_TIDUR
		// PENG_OBAT_IST
		// FREK_MAND
		// CUC_RAMB_MAND
		// SIH_GIGI_MAND
		// BANT_MAND
		// GANT_PAKAI
		// PAK_CUCI
		// PAK_BANT
		// ALT_BANT
		// KEMP_MUND
		// BIL_PUT
		// ADAPTIF
		// MALADAPTIF
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// obat2
		// PERBANDINGAN_BB
		// KONTINENSIA
		// JENIS_KULIT1
		// MOBILITAS
		// JK
		// UMUR
		// NAFSU_MAKAN
		// OBAT1
		// MALNUTRISI
		// MOTORIK1
		// SPINAL
		// MEJA_OPERASI
		// RIWAYAT_JATUH
		// DIAGNOSIS_SEKUNDER
		// ALAT_BANTU
		// HEPARIN
		// GAYA_BERJALAN
		// KESADARAN1
		// NOMR_LAMA
		// NO_KARTU
		// JNS_PASIEN
		// nama_ayah
		// nama_ibu
		// nama_suami
		// nama_istri
		// KD_ETNIS
		// KD_BHS_HARIAN

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// NAMA
		$this->NAMA->ViewValue = $this->NAMA->CurrentValue;
		$this->NAMA->ViewCustomAttributes = "";

		// TEMPAT
		$this->TEMPAT->ViewValue = $this->TEMPAT->CurrentValue;
		$this->TEMPAT->ViewCustomAttributes = "";

		// TGLLAHIR
		$this->TGLLAHIR->ViewValue = $this->TGLLAHIR->CurrentValue;
		$this->TGLLAHIR->ViewValue = ew_FormatDateTime($this->TGLLAHIR->ViewValue, 7);
		$this->TGLLAHIR->ViewCustomAttributes = "";

		// JENISKELAMIN
		if (strval($this->JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->JENISKELAMIN->ViewValue = NULL;
		}
		$this->JENISKELAMIN->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// NOTELP
		$this->NOTELP->ViewValue = $this->NOTELP->CurrentValue;
		$this->NOTELP->ViewCustomAttributes = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";
			if ($this->Export == "")
				$this->NOMR->ViewValue = ew_Highlight($this->HighlightName(), $this->NOMR->ViewValue, $this->BasicSearch->getKeyword(), $this->BasicSearch->getType(), $this->NOMR->AdvancedSearch->getValue("x"), "");

			// NAMA
			$this->NAMA->LinkCustomAttributes = "";
			$this->NAMA->HrefValue = "";
			$this->NAMA->TooltipValue = "";
			if ($this->Export == "")
				$this->NAMA->ViewValue = ew_Highlight($this->HighlightName(), $this->NAMA->ViewValue, $this->BasicSearch->getKeyword(), $this->BasicSearch->getType(), $this->NAMA->AdvancedSearch->getValue("x"), "");

			// TEMPAT
			$this->TEMPAT->LinkCustomAttributes = "";
			$this->TEMPAT->HrefValue = "";
			$this->TEMPAT->TooltipValue = "";

			// TGLLAHIR
			$this->TGLLAHIR->LinkCustomAttributes = "";
			$this->TGLLAHIR->HrefValue = "";
			$this->TGLLAHIR->TooltipValue = "";

			// JENISKELAMIN
			$this->JENISKELAMIN->LinkCustomAttributes = "";
			$this->JENISKELAMIN->HrefValue = "";
			$this->JENISKELAMIN->TooltipValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";
			$this->ALAMAT->TooltipValue = "";
			if ($this->Export == "")
				$this->ALAMAT->ViewValue = ew_Highlight($this->HighlightName(), $this->ALAMAT->ViewValue, "", "", $this->ALAMAT->AdvancedSearch->getValue("x"), "");

			// NOTELP
			$this->NOTELP->LinkCustomAttributes = "";
			$this->NOTELP->HrefValue = "";
			$this->NOTELP->TooltipValue = "";
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
		$this->NOMR->AdvancedSearch->Load();
		$this->NAMA->AdvancedSearch->Load();
		$this->ALAMAT->AdvancedSearch->Load();
		$this->NO_KARTU->AdvancedSearch->Load();
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
		$r = Security()->CurrentUserLevelID();
		if($r==4)
		{
			$this->OtherOptions['addedit'] = new cListOptions();
			$this->OtherOptions['addedit']->Body = "";
		}
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

		$r = Security()->CurrentUserLevelID();
		if($r==4)
		{
			$this->ListOptions->Items["copy"]->Visible = FALSE;

			//$this->ListOptions->Items["edit"]->Visible = FALSE;
			$this->ListOptions->Items["delete"]->Visible = FALSE;
		}
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
if (!isset($m_pasien_list)) $m_pasien_list = new cm_pasien_list();

// Page init
$m_pasien_list->Page_Init();

// Page main
$m_pasien_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_pasien_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fm_pasienlist = new ew_Form("fm_pasienlist", "list");
fm_pasienlist.FormKeyCountName = '<?php echo $m_pasien_list->FormKeyCountName ?>';

// Form_CustomValidate event
fm_pasienlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_pasienlist.ValidateRequired = true;
<?php } else { ?>
fm_pasienlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_pasienlist.Lists["x_JENISKELAMIN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskelamin","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskelamin"};

// Form object for search
var CurrentSearchForm = fm_pasienlistsrch = new ew_Form("fm_pasienlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($m_pasien_list->TotalRecs > 0 && $m_pasien_list->ExportOptions->Visible()) { ?>
<?php $m_pasien_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($m_pasien_list->SearchOptions->Visible()) { ?>
<?php $m_pasien_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($m_pasien_list->FilterOptions->Visible()) { ?>
<?php $m_pasien_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $m_pasien_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($m_pasien_list->TotalRecs <= 0)
			$m_pasien_list->TotalRecs = $m_pasien->SelectRecordCount();
	} else {
		if (!$m_pasien_list->Recordset && ($m_pasien_list->Recordset = $m_pasien_list->LoadRecordset()))
			$m_pasien_list->TotalRecs = $m_pasien_list->Recordset->RecordCount();
	}
	$m_pasien_list->StartRec = 1;
	if ($m_pasien_list->DisplayRecs <= 0 || ($m_pasien->Export <> "" && $m_pasien->ExportAll)) // Display all records
		$m_pasien_list->DisplayRecs = $m_pasien_list->TotalRecs;
	if (!($m_pasien->Export <> "" && $m_pasien->ExportAll))
		$m_pasien_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$m_pasien_list->Recordset = $m_pasien_list->LoadRecordset($m_pasien_list->StartRec-1, $m_pasien_list->DisplayRecs);

	// Set no record found message
	if ($m_pasien->CurrentAction == "" && $m_pasien_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$m_pasien_list->setWarningMessage(ew_DeniedMsg());
		if ($m_pasien_list->SearchWhere == "0=101")
			$m_pasien_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$m_pasien_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($m_pasien_list->AuditTrailOnSearch && $m_pasien_list->Command == "search" && !$m_pasien_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $m_pasien_list->getSessionWhere();
		$m_pasien_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$m_pasien_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($m_pasien->Export == "" && $m_pasien->CurrentAction == "") { ?>
<form name="fm_pasienlistsrch" id="fm_pasienlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($m_pasien_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fm_pasienlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="m_pasien">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($m_pasien_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($m_pasien_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $m_pasien_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($m_pasien_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($m_pasien_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($m_pasien_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($m_pasien_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $m_pasien_list->ShowPageHeader(); ?>
<?php
$m_pasien_list->ShowMessage();
?>
<?php if ($m_pasien_list->TotalRecs > 0 || $m_pasien->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid m_pasien">
<form name="fm_pasienlist" id="fm_pasienlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_pasien_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_pasien_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_pasien">
<div id="gmp_m_pasien" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($m_pasien_list->TotalRecs > 0 || $m_pasien->CurrentAction == "gridedit") { ?>
<table id="tbl_m_pasienlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_pasien->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$m_pasien_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$m_pasien_list->RenderListOptions();

// Render list options (header, left)
$m_pasien_list->ListOptions->Render("header", "left");
?>
<?php if ($m_pasien->NOMR->Visible) { // NOMR ?>
	<?php if ($m_pasien->SortUrl($m_pasien->NOMR) == "") { ?>
		<th data-name="NOMR"><div id="elh_m_pasien_NOMR" class="m_pasien_NOMR"><div class="ewTableHeaderCaption"><?php echo $m_pasien->NOMR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NOMR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_pasien->SortUrl($m_pasien->NOMR) ?>',2);"><div id="elh_m_pasien_NOMR" class="m_pasien_NOMR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_pasien->NOMR->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_pasien->NOMR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_pasien->NOMR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_pasien->NAMA->Visible) { // NAMA ?>
	<?php if ($m_pasien->SortUrl($m_pasien->NAMA) == "") { ?>
		<th data-name="NAMA"><div id="elh_m_pasien_NAMA" class="m_pasien_NAMA"><div class="ewTableHeaderCaption"><?php echo $m_pasien->NAMA->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NAMA"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_pasien->SortUrl($m_pasien->NAMA) ?>',2);"><div id="elh_m_pasien_NAMA" class="m_pasien_NAMA">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_pasien->NAMA->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_pasien->NAMA->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_pasien->NAMA->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_pasien->TEMPAT->Visible) { // TEMPAT ?>
	<?php if ($m_pasien->SortUrl($m_pasien->TEMPAT) == "") { ?>
		<th data-name="TEMPAT"><div id="elh_m_pasien_TEMPAT" class="m_pasien_TEMPAT"><div class="ewTableHeaderCaption"><?php echo $m_pasien->TEMPAT->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TEMPAT"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_pasien->SortUrl($m_pasien->TEMPAT) ?>',2);"><div id="elh_m_pasien_TEMPAT" class="m_pasien_TEMPAT">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_pasien->TEMPAT->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_pasien->TEMPAT->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_pasien->TEMPAT->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_pasien->TGLLAHIR->Visible) { // TGLLAHIR ?>
	<?php if ($m_pasien->SortUrl($m_pasien->TGLLAHIR) == "") { ?>
		<th data-name="TGLLAHIR"><div id="elh_m_pasien_TGLLAHIR" class="m_pasien_TGLLAHIR"><div class="ewTableHeaderCaption"><?php echo $m_pasien->TGLLAHIR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TGLLAHIR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_pasien->SortUrl($m_pasien->TGLLAHIR) ?>',2);"><div id="elh_m_pasien_TGLLAHIR" class="m_pasien_TGLLAHIR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_pasien->TGLLAHIR->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_pasien->TGLLAHIR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_pasien->TGLLAHIR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_pasien->JENISKELAMIN->Visible) { // JENISKELAMIN ?>
	<?php if ($m_pasien->SortUrl($m_pasien->JENISKELAMIN) == "") { ?>
		<th data-name="JENISKELAMIN"><div id="elh_m_pasien_JENISKELAMIN" class="m_pasien_JENISKELAMIN"><div class="ewTableHeaderCaption"><?php echo $m_pasien->JENISKELAMIN->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="JENISKELAMIN"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_pasien->SortUrl($m_pasien->JENISKELAMIN) ?>',2);"><div id="elh_m_pasien_JENISKELAMIN" class="m_pasien_JENISKELAMIN">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_pasien->JENISKELAMIN->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_pasien->JENISKELAMIN->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_pasien->JENISKELAMIN->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_pasien->ALAMAT->Visible) { // ALAMAT ?>
	<?php if ($m_pasien->SortUrl($m_pasien->ALAMAT) == "") { ?>
		<th data-name="ALAMAT"><div id="elh_m_pasien_ALAMAT" class="m_pasien_ALAMAT"><div class="ewTableHeaderCaption"><?php echo $m_pasien->ALAMAT->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ALAMAT"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_pasien->SortUrl($m_pasien->ALAMAT) ?>',2);"><div id="elh_m_pasien_ALAMAT" class="m_pasien_ALAMAT">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_pasien->ALAMAT->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_pasien->ALAMAT->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_pasien->ALAMAT->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_pasien->NOTELP->Visible) { // NOTELP ?>
	<?php if ($m_pasien->SortUrl($m_pasien->NOTELP) == "") { ?>
		<th data-name="NOTELP"><div id="elh_m_pasien_NOTELP" class="m_pasien_NOTELP"><div class="ewTableHeaderCaption"><?php echo $m_pasien->NOTELP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NOTELP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_pasien->SortUrl($m_pasien->NOTELP) ?>',2);"><div id="elh_m_pasien_NOTELP" class="m_pasien_NOTELP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_pasien->NOTELP->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_pasien->NOTELP->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_pasien->NOTELP->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$m_pasien_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($m_pasien->ExportAll && $m_pasien->Export <> "") {
	$m_pasien_list->StopRec = $m_pasien_list->TotalRecs;
} else {

	// Set the last record to display
	if ($m_pasien_list->TotalRecs > $m_pasien_list->StartRec + $m_pasien_list->DisplayRecs - 1)
		$m_pasien_list->StopRec = $m_pasien_list->StartRec + $m_pasien_list->DisplayRecs - 1;
	else
		$m_pasien_list->StopRec = $m_pasien_list->TotalRecs;
}
$m_pasien_list->RecCnt = $m_pasien_list->StartRec - 1;
if ($m_pasien_list->Recordset && !$m_pasien_list->Recordset->EOF) {
	$m_pasien_list->Recordset->MoveFirst();
	$bSelectLimit = $m_pasien_list->UseSelectLimit;
	if (!$bSelectLimit && $m_pasien_list->StartRec > 1)
		$m_pasien_list->Recordset->Move($m_pasien_list->StartRec - 1);
} elseif (!$m_pasien->AllowAddDeleteRow && $m_pasien_list->StopRec == 0) {
	$m_pasien_list->StopRec = $m_pasien->GridAddRowCount;
}

// Initialize aggregate
$m_pasien->RowType = EW_ROWTYPE_AGGREGATEINIT;
$m_pasien->ResetAttrs();
$m_pasien_list->RenderRow();
while ($m_pasien_list->RecCnt < $m_pasien_list->StopRec) {
	$m_pasien_list->RecCnt++;
	if (intval($m_pasien_list->RecCnt) >= intval($m_pasien_list->StartRec)) {
		$m_pasien_list->RowCnt++;

		// Set up key count
		$m_pasien_list->KeyCount = $m_pasien_list->RowIndex;

		// Init row class and style
		$m_pasien->ResetAttrs();
		$m_pasien->CssClass = "";
		if ($m_pasien->CurrentAction == "gridadd") {
		} else {
			$m_pasien_list->LoadRowValues($m_pasien_list->Recordset); // Load row values
		}
		$m_pasien->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$m_pasien->RowAttrs = array_merge($m_pasien->RowAttrs, array('data-rowindex'=>$m_pasien_list->RowCnt, 'id'=>'r' . $m_pasien_list->RowCnt . '_m_pasien', 'data-rowtype'=>$m_pasien->RowType));

		// Render row
		$m_pasien_list->RenderRow();

		// Render list options
		$m_pasien_list->RenderListOptions();
?>
	<tr<?php echo $m_pasien->RowAttributes() ?>>
<?php

// Render list options (body, left)
$m_pasien_list->ListOptions->Render("body", "left", $m_pasien_list->RowCnt);
?>
	<?php if ($m_pasien->NOMR->Visible) { // NOMR ?>
		<td data-name="NOMR"<?php echo $m_pasien->NOMR->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_list->RowCnt ?>_m_pasien_NOMR" class="m_pasien_NOMR">
<span<?php echo $m_pasien->NOMR->ViewAttributes() ?>>
<?php echo $m_pasien->NOMR->ListViewValue() ?></span>
</span>
<a id="<?php echo $m_pasien_list->PageObjName . "_row_" . $m_pasien_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($m_pasien->NAMA->Visible) { // NAMA ?>
		<td data-name="NAMA"<?php echo $m_pasien->NAMA->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_list->RowCnt ?>_m_pasien_NAMA" class="m_pasien_NAMA">
<span<?php echo $m_pasien->NAMA->ViewAttributes() ?>>
<?php echo $m_pasien->NAMA->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_pasien->TEMPAT->Visible) { // TEMPAT ?>
		<td data-name="TEMPAT"<?php echo $m_pasien->TEMPAT->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_list->RowCnt ?>_m_pasien_TEMPAT" class="m_pasien_TEMPAT">
<span<?php echo $m_pasien->TEMPAT->ViewAttributes() ?>>
<?php echo $m_pasien->TEMPAT->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_pasien->TGLLAHIR->Visible) { // TGLLAHIR ?>
		<td data-name="TGLLAHIR"<?php echo $m_pasien->TGLLAHIR->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_list->RowCnt ?>_m_pasien_TGLLAHIR" class="m_pasien_TGLLAHIR">
<span<?php echo $m_pasien->TGLLAHIR->ViewAttributes() ?>>
<?php echo $m_pasien->TGLLAHIR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_pasien->JENISKELAMIN->Visible) { // JENISKELAMIN ?>
		<td data-name="JENISKELAMIN"<?php echo $m_pasien->JENISKELAMIN->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_list->RowCnt ?>_m_pasien_JENISKELAMIN" class="m_pasien_JENISKELAMIN">
<span<?php echo $m_pasien->JENISKELAMIN->ViewAttributes() ?>>
<?php echo $m_pasien->JENISKELAMIN->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_pasien->ALAMAT->Visible) { // ALAMAT ?>
		<td data-name="ALAMAT"<?php echo $m_pasien->ALAMAT->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_list->RowCnt ?>_m_pasien_ALAMAT" class="m_pasien_ALAMAT">
<span<?php echo $m_pasien->ALAMAT->ViewAttributes() ?>>
<?php echo $m_pasien->ALAMAT->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_pasien->NOTELP->Visible) { // NOTELP ?>
		<td data-name="NOTELP"<?php echo $m_pasien->NOTELP->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_list->RowCnt ?>_m_pasien_NOTELP" class="m_pasien_NOTELP">
<span<?php echo $m_pasien->NOTELP->ViewAttributes() ?>>
<?php echo $m_pasien->NOTELP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$m_pasien_list->ListOptions->Render("body", "right", $m_pasien_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($m_pasien->CurrentAction <> "gridadd")
		$m_pasien_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($m_pasien->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($m_pasien_list->Recordset)
	$m_pasien_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($m_pasien->CurrentAction <> "gridadd" && $m_pasien->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($m_pasien_list->Pager)) $m_pasien_list->Pager = new cPrevNextPager($m_pasien_list->StartRec, $m_pasien_list->DisplayRecs, $m_pasien_list->TotalRecs) ?>
<?php if ($m_pasien_list->Pager->RecordCount > 0 && $m_pasien_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($m_pasien_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $m_pasien_list->PageUrl() ?>start=<?php echo $m_pasien_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($m_pasien_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $m_pasien_list->PageUrl() ?>start=<?php echo $m_pasien_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $m_pasien_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($m_pasien_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $m_pasien_list->PageUrl() ?>start=<?php echo $m_pasien_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($m_pasien_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $m_pasien_list->PageUrl() ?>start=<?php echo $m_pasien_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $m_pasien_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $m_pasien_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $m_pasien_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $m_pasien_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($m_pasien_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $m_pasien_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="m_pasien">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($m_pasien_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($m_pasien_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($m_pasien_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($m_pasien_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($m_pasien_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_pasien_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($m_pasien_list->TotalRecs == 0 && $m_pasien->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_pasien_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fm_pasienlistsrch.FilterList = <?php echo $m_pasien_list->GetFilterList() ?>;
fm_pasienlistsrch.Init();
fm_pasienlist.Init();
</script>
<?php
$m_pasien_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_pasien_list->Page_Terminate();
?>
