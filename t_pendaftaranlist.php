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

$t_pendaftaran_list = NULL; // Initialize page object first

class ct_pendaftaran_list extends ct_pendaftaran {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_pendaftaran';

	// Page object name
	var $PageObjName = 't_pendaftaran_list';

	// Grid form hidden field names
	var $FormName = 'ft_pendaftaranlist';
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

		// Table object (t_pendaftaran)
		if (!isset($GLOBALS["t_pendaftaran"]) || get_class($GLOBALS["t_pendaftaran"]) == "ct_pendaftaran") {
			$GLOBALS["t_pendaftaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_pendaftaran"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t_pendaftaranadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t_pendaftarandelete.php";
		$this->MultiUpdateUrl = "t_pendaftaranupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft_pendaftaranlistsrch";

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
		$this->PASIENBARU->SetVisibility();
		$this->NOMR->SetVisibility();
		$this->TGLREG->SetVisibility();
		$this->KDDOKTER->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->KDRUJUK->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->SHIFT->SetVisibility();
		$this->NIP->SetVisibility();
		$this->MASUKPOLY->SetVisibility();
		$this->KELUARPOLY->SetVisibility();
		$this->pasien_NAMA->SetVisibility();
		$this->pasien_TEMPAT->SetVisibility();
		$this->peserta_cob->SetVisibility();
		$this->poli_eksekutif->SetVisibility();

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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft_pendaftaranlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft_pendaftaranlistsrch", $filters);

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
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NOMR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NOJAMINAN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NIP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->KETRUJUK, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->KETBAYAR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PENANGGUNGJAWAB_NAMA, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PENANGGUNGJAWAB_HUBUNGAN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PENANGGUNGJAWAB_ALAMAT, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PENANGGUNGJAWAB_PHONE, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->BATAL, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NO_SJP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NO_PESERTA, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NOKARTU, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->MINTA_RUJUKAN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NORUJUKAN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PPKRUJUKANASAL_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NAMAPPKRUJUKANASAL_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PPKPELAYANAN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->CATATAN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DIAGNOSAAWAL_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NAMADIAGNOSA_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->LOKASILAKALANTAS, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->USER, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTANIK_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTANAMA_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTAJENISKELAMIN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTANAMAKELAS_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTAPISAT, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTATGLLAHIR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTAJENISPESERTA_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PESERTANAMAJENISPESERTA_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->POLITUJUAN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NAMAPOLITUJUAN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->KDPPKRUJUKAN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NMPPKRUJUKAN_SEP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bridging_upt_tglplng, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NOKARTU_BPJS, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NOKTP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_upgrade_class_class, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_diagnosa, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_procedure, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_nama_dokter, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_kode_tarif, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_payor_cd, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_coder_nik, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_patient_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_admission_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_hospital_admission_id, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->user_penghapus_sep, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_kemkes_dc_Status, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_bpjs_dc_Status, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_cbg_code, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_cbg_descprition, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_sub_acute_code, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_sub_acute_deskripsi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_chronic_code, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_chronic_deskripsi, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->eklaim_inacbg_version, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->KETERANGAN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->USER_KASIR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_TITLE, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_NAMA, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_TEMPAT, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_JENISKELAMIN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_ALAMAT, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_KELURAHAN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_KOTA, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_NOTELP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_NOKTP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_SUAMI_ORTU, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_PEKERJAAN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_ALAMAT_KTP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_NO_KARTU, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_JNS_PASIEN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_nama_ayah, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_nama_ibu, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_nama_suami, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_nama_istri, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->USER_ADM, $arKeywords, $type);
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
			$this->UpdateSort($this->PASIENBARU, $bCtrl); // PASIENBARU
			$this->UpdateSort($this->NOMR, $bCtrl); // NOMR
			$this->UpdateSort($this->TGLREG, $bCtrl); // TGLREG
			$this->UpdateSort($this->KDDOKTER, $bCtrl); // KDDOKTER
			$this->UpdateSort($this->KDPOLY, $bCtrl); // KDPOLY
			$this->UpdateSort($this->KDRUJUK, $bCtrl); // KDRUJUK
			$this->UpdateSort($this->KDCARABAYAR, $bCtrl); // KDCARABAYAR
			$this->UpdateSort($this->SHIFT, $bCtrl); // SHIFT
			$this->UpdateSort($this->NIP, $bCtrl); // NIP
			$this->UpdateSort($this->MASUKPOLY, $bCtrl); // MASUKPOLY
			$this->UpdateSort($this->KELUARPOLY, $bCtrl); // KELUARPOLY
			$this->UpdateSort($this->pasien_NAMA, $bCtrl); // pasien_NAMA
			$this->UpdateSort($this->pasien_TEMPAT, $bCtrl); // pasien_TEMPAT
			$this->UpdateSort($this->peserta_cob, $bCtrl); // peserta_cob
			$this->UpdateSort($this->poli_eksekutif, $bCtrl); // poli_eksekutif
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
				$this->PASIENBARU->setSort("");
				$this->NOMR->setSort("");
				$this->TGLREG->setSort("");
				$this->KDDOKTER->setSort("");
				$this->KDPOLY->setSort("");
				$this->KDRUJUK->setSort("");
				$this->KDCARABAYAR->setSort("");
				$this->SHIFT->setSort("");
				$this->NIP->setSort("");
				$this->MASUKPOLY->setSort("");
				$this->KELUARPOLY->setSort("");
				$this->pasien_NAMA->setSort("");
				$this->pasien_TEMPAT->setSort("");
				$this->peserta_cob->setSort("");
				$this->poli_eksekutif->setSort("");
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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
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

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"btn btn-warning btn-xs\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") ." ". $editcaption . "</a>";
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
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->IDXDAFTAR->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft_pendaftaranlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft_pendaftaranlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft_pendaftaranlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft_pendaftaranlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NOJAMINAN->setDbValue($rs->fields('NOJAMINAN'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->KETERANGAN_STATUS->setDbValue($rs->fields('KETERANGAN_STATUS'));
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
		$this->pasien_TITLE->setDbValue($rs->fields('pasien_TITLE'));
		$this->pasien_NAMA->setDbValue($rs->fields('pasien_NAMA'));
		$this->pasien_TEMPAT->setDbValue($rs->fields('pasien_TEMPAT'));
		$this->pasien_TGLLAHIR->setDbValue($rs->fields('pasien_TGLLAHIR'));
		$this->pasien_JENISKELAMIN->setDbValue($rs->fields('pasien_JENISKELAMIN'));
		$this->pasien_ALAMAT->setDbValue($rs->fields('pasien_ALAMAT'));
		$this->pasien_KELURAHAN->setDbValue($rs->fields('pasien_KELURAHAN'));
		$this->pasien_KDKECAMATAN->setDbValue($rs->fields('pasien_KDKECAMATAN'));
		$this->pasien_KOTA->setDbValue($rs->fields('pasien_KOTA'));
		$this->pasien_KDPROVINSI->setDbValue($rs->fields('pasien_KDPROVINSI'));
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
		$this->USER_ADM->setDbValue($rs->fields('USER_ADM'));
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->setDbValue($rs->fields('TARIF_PENUNJANG_NON_MEDIS_IGD'));
		$this->TARIF_PELAYANAN_DARAH->setDbValue($rs->fields('TARIF_PELAYANAN_DARAH'));
		$this->penjamin_kkl_id->setDbValue($rs->fields('penjamin_kkl_id'));
		$this->asalfaskesrujukan_id->setDbValue($rs->fields('asalfaskesrujukan_id'));
		$this->peserta_cob->setDbValue($rs->fields('peserta_cob'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->status_kepesertaan_BPJS->setDbValue($rs->fields('status_kepesertaan_BPJS'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->PASIENBARU->DbValue = $row['PASIENBARU'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->KDDOKTER->DbValue = $row['KDDOKTER'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NOJAMINAN->DbValue = $row['NOJAMINAN'];
		$this->SHIFT->DbValue = $row['SHIFT'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->KETERANGAN_STATUS->DbValue = $row['KETERANGAN_STATUS'];
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
		$this->pasien_TITLE->DbValue = $row['pasien_TITLE'];
		$this->pasien_NAMA->DbValue = $row['pasien_NAMA'];
		$this->pasien_TEMPAT->DbValue = $row['pasien_TEMPAT'];
		$this->pasien_TGLLAHIR->DbValue = $row['pasien_TGLLAHIR'];
		$this->pasien_JENISKELAMIN->DbValue = $row['pasien_JENISKELAMIN'];
		$this->pasien_ALAMAT->DbValue = $row['pasien_ALAMAT'];
		$this->pasien_KELURAHAN->DbValue = $row['pasien_KELURAHAN'];
		$this->pasien_KDKECAMATAN->DbValue = $row['pasien_KDKECAMATAN'];
		$this->pasien_KOTA->DbValue = $row['pasien_KOTA'];
		$this->pasien_KDPROVINSI->DbValue = $row['pasien_KDPROVINSI'];
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
		$this->USER_ADM->DbValue = $row['USER_ADM'];
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->DbValue = $row['TARIF_PENUNJANG_NON_MEDIS_IGD'];
		$this->TARIF_PELAYANAN_DARAH->DbValue = $row['TARIF_PELAYANAN_DARAH'];
		$this->penjamin_kkl_id->DbValue = $row['penjamin_kkl_id'];
		$this->asalfaskesrujukan_id->DbValue = $row['asalfaskesrujukan_id'];
		$this->peserta_cob->DbValue = $row['peserta_cob'];
		$this->poli_eksekutif->DbValue = $row['poli_eksekutif'];
		$this->status_kepesertaan_BPJS->DbValue = $row['status_kepesertaan_BPJS'];
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

		$this->IDXDAFTAR->CellCssStyle = "white-space: nowrap;";

		// PASIENBARU
		$this->PASIENBARU->CellCssStyle = "white-space: nowrap;";

		// NOMR
		$this->NOMR->CellCssStyle = "white-space: nowrap;";

		// TGLREG
		$this->TGLREG->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER
		$this->KDDOKTER->CellCssStyle = "white-space: nowrap;";

		// KDPOLY
		$this->KDPOLY->CellCssStyle = "white-space: nowrap;";

		// KDRUJUK
		$this->KDRUJUK->CellCssStyle = "white-space: nowrap;";

		// KDCARABAYAR
		$this->KDCARABAYAR->CellCssStyle = "white-space: nowrap;";

		// NOJAMINAN
		$this->NOJAMINAN->CellCssStyle = "white-space: nowrap;";

		// SHIFT
		$this->SHIFT->CellCssStyle = "white-space: nowrap;";

		// STATUS
		$this->STATUS->CellCssStyle = "white-space: nowrap;";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->CellCssStyle = "white-space: nowrap;";

		// NIP
		$this->NIP->CellCssStyle = "white-space: nowrap;";

		// MASUKPOLY
		$this->MASUKPOLY->CellCssStyle = "white-space: nowrap;";

		// KELUARPOLY
		$this->KELUARPOLY->CellCssStyle = "white-space: nowrap;";

		// KETRUJUK
		$this->KETRUJUK->CellCssStyle = "white-space: nowrap;";

		// KETBAYAR
		$this->KETBAYAR->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->CellCssStyle = "white-space: nowrap;";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->CellCssStyle = "white-space: nowrap;";

		// JAMREG
		$this->JAMREG->CellCssStyle = "white-space: nowrap;";

		// BATAL
		$this->BATAL->CellCssStyle = "white-space: nowrap;";

		// NO_SJP
		$this->NO_SJP->CellCssStyle = "white-space: nowrap;";

		// NO_PESERTA
		$this->NO_PESERTA->CellCssStyle = "white-space: nowrap;";

		// NOKARTU
		$this->NOKARTU->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->CellCssStyle = "white-space: nowrap;";

		// biaya_obat
		$this->biaya_obat->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat
		$this->biaya_retur_obat->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_rajal
		$this->biaya_obat_rajal->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_igd
		$this->biaya_obat_igd->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->CellCssStyle = "white-space: nowrap;";

		// biaya_obat_ibs
		$this->biaya_obat_ibs->CellCssStyle = "white-space: nowrap;";

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->CellCssStyle = "white-space: nowrap;";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->CellCssStyle = "white-space: nowrap;";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->CellCssStyle = "white-space: nowrap;";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->CellCssStyle = "white-space: nowrap;";

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->CellCssStyle = "white-space: nowrap;";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->CellCssStyle = "white-space: nowrap;";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->CellCssStyle = "white-space: nowrap;";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->CellCssStyle = "white-space: nowrap;";

		// CATATAN_SEP
		$this->CATATAN_SEP->CellCssStyle = "white-space: nowrap;";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->CellCssStyle = "white-space: nowrap;";

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->CellCssStyle = "white-space: nowrap;";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->CellCssStyle = "white-space: nowrap;";

		// USER
		$this->USER->CellCssStyle = "white-space: nowrap;";

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->CellCssStyle = "white-space: nowrap;";

		// generate_sep
		$this->generate_sep->CellCssStyle = "white-space: nowrap;";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTAPISAT
		$this->PESERTAPISAT->CellCssStyle = "white-space: nowrap;";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->CellCssStyle = "white-space: nowrap;";

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->CellCssStyle = "white-space: nowrap;";

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->CellCssStyle = "white-space: nowrap;";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->CellCssStyle = "white-space: nowrap;";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->CellCssStyle = "white-space: nowrap;";

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->CellCssStyle = "white-space: nowrap;";

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->CellCssStyle = "white-space: nowrap;";

		// mapingtransaksi
		$this->mapingtransaksi->CellCssStyle = "white-space: nowrap;";

		// bridging_no_rujukan
		$this->bridging_no_rujukan->CellCssStyle = "white-space: nowrap;";

		// bridging_hapus_sep
		$this->bridging_hapus_sep->CellCssStyle = "white-space: nowrap;";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->CellCssStyle = "white-space: nowrap;";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->CellCssStyle = "white-space: nowrap;";

		// counter_cetak_kartu
		$this->counter_cetak_kartu->CellCssStyle = "white-space: nowrap;";

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->CellCssStyle = "white-space: nowrap;";

		// NOKTP
		$this->NOKTP->CellCssStyle = "white-space: nowrap;";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->CellCssStyle = "white-space: nowrap;";

		// maping_hapus_sep
		$this->maping_hapus_sep->CellCssStyle = "white-space: nowrap;";

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->CellCssStyle = "white-space: nowrap;";

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->CellCssStyle = "white-space: nowrap;";

		// INCLUDE
		$this->INCLUDE->CellCssStyle = "white-space: nowrap;";

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_score
		$this->eklaim_adl_score->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->CellCssStyle = "white-space: nowrap;";

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->CellCssStyle = "white-space: nowrap;";

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->CellCssStyle = "white-space: nowrap;";

		// eklaim_icu_los
		$this->eklaim_icu_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->CellCssStyle = "white-space: nowrap;";

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_birth_weight
		$this->eklaim_birth_weight->CellCssStyle = "white-space: nowrap;";

		// eklaim_discharge_status
		$this->eklaim_discharge_status->CellCssStyle = "white-space: nowrap;";

		// eklaim_diagnosa
		$this->eklaim_diagnosa->CellCssStyle = "white-space: nowrap;";

		// eklaim_procedure
		$this->eklaim_procedure->CellCssStyle = "white-space: nowrap;";

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->CellCssStyle = "white-space: nowrap;";

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->CellCssStyle = "white-space: nowrap;";

		// eklaim_id_dokter
		$this->eklaim_id_dokter->CellCssStyle = "white-space: nowrap;";

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->CellCssStyle = "white-space: nowrap;";

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->CellCssStyle = "white-space: nowrap;";

		// eklaim_payor_id
		$this->eklaim_payor_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_payor_cd
		$this->eklaim_payor_cd->CellCssStyle = "white-space: nowrap;";

		// eklaim_coder_nik
		$this->eklaim_coder_nik->CellCssStyle = "white-space: nowrap;";

		// eklaim_los
		$this->eklaim_los->CellCssStyle = "white-space: nowrap;";

		// eklaim_patient_id
		$this->eklaim_patient_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_admission_id
		$this->eklaim_admission_id->CellCssStyle = "white-space: nowrap;";

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->CellCssStyle = "white-space: nowrap;";

		// bridging_hapussep
		$this->bridging_hapussep->CellCssStyle = "white-space: nowrap;";

		// user_penghapus_sep
		$this->user_penghapus_sep->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->CellCssStyle = "white-space: nowrap;";

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->CellCssStyle = "white-space: nowrap;";

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->CellCssStyle = "white-space: nowrap;";

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->CellCssStyle = "white-space: nowrap;";

		// eklaim_gruper1
		$this->eklaim_gruper1->CellCssStyle = "white-space: nowrap;";

		// eklaim_gruper2
		$this->eklaim_gruper2->CellCssStyle = "white-space: nowrap;";

		// eklaim_finalklaim
		$this->eklaim_finalklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_sendklaim
		$this->eklaim_sendklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->CellCssStyle = "white-space: nowrap;";

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->CellCssStyle = "white-space: nowrap;";

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_code
		$this->eklaim_cbg_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->CellCssStyle = "white-space: nowrap;";

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->CellCssStyle = "white-space: nowrap;";

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_code
		$this->eklaim_chronic_code->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->CellCssStyle = "white-space: nowrap;";

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->CellCssStyle = "white-space: nowrap;";

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// VERIFY_ICD
		$this->VERIFY_ICD->CellCssStyle = "white-space: nowrap;";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->CellCssStyle = "white-space: nowrap;";

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->CellCssStyle = "white-space: nowrap;";

		// KETERANGAN
		$this->KETERANGAN->CellCssStyle = "white-space: nowrap;";

		// TGLLAHIR
		$this->TGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// USER_KASIR
		$this->USER_KASIR->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->CellCssStyle = "white-space: nowrap;";

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->CellCssStyle = "white-space: nowrap;";

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->CellCssStyle = "white-space: nowrap;";

		// EKG_RAJAL
		$this->EKG_RAJAL->CellCssStyle = "white-space: nowrap;";

		// USG_RAJAL
		$this->USG_RAJAL->CellCssStyle = "white-space: nowrap;";

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL
		$this->BHP_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->CellCssStyle = "white-space: nowrap;";

		// ORDER_LAB
		$this->ORDER_LAB->CellCssStyle = "white-space: nowrap;";

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->CellCssStyle = "white-space: nowrap;";

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->CellCssStyle = "white-space: nowrap;";

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->CellCssStyle = "white-space: nowrap;";

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->CellCssStyle = "white-space: nowrap;";

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->CellCssStyle = "white-space: nowrap;";

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->CellCssStyle = "white-space: nowrap;";

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->CellCssStyle = "white-space: nowrap;";

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->CellCssStyle = "white-space: nowrap;";

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->CellCssStyle = "white-space: nowrap;";

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->CellCssStyle = "white-space: nowrap;";

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->CellCssStyle = "white-space: nowrap;";

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->CellCssStyle = "white-space: nowrap;";

		// pasien_TITLE
		$this->pasien_TITLE->CellCssStyle = "white-space: nowrap;";

		// pasien_NAMA
		$this->pasien_NAMA->CellCssStyle = "white-space: nowrap;";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->CellCssStyle = "white-space: nowrap;";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->CellCssStyle = "white-space: nowrap;";

		// pasien_JENISKELAMIN
		$this->pasien_JENISKELAMIN->CellCssStyle = "white-space: nowrap;";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->CellCssStyle = "white-space: nowrap;";

		// pasien_KELURAHAN
		$this->pasien_KELURAHAN->CellCssStyle = "white-space: nowrap;";

		// pasien_KDKECAMATAN
		$this->pasien_KDKECAMATAN->CellCssStyle = "white-space: nowrap;";

		// pasien_KOTA
		$this->pasien_KOTA->CellCssStyle = "white-space: nowrap;";

		// pasien_KDPROVINSI
		$this->pasien_KDPROVINSI->CellCssStyle = "white-space: nowrap;";

		// pasien_NOTELP
		$this->pasien_NOTELP->CellCssStyle = "white-space: nowrap;";

		// pasien_NOKTP
		$this->pasien_NOKTP->CellCssStyle = "white-space: nowrap;";

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->CellCssStyle = "white-space: nowrap;";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->CellCssStyle = "white-space: nowrap;";

		// pasien_AGAMA
		$this->pasien_AGAMA->CellCssStyle = "white-space: nowrap;";

		// pasien_PENDIDIKAN
		$this->pasien_PENDIDIKAN->CellCssStyle = "white-space: nowrap;";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->CellCssStyle = "white-space: nowrap;";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->CellCssStyle = "white-space: nowrap;";

		// pasien_JNS_PASIEN
		$this->pasien_JNS_PASIEN->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_suami
		$this->pasien_nama_suami->CellCssStyle = "white-space: nowrap;";

		// pasien_nama_istri
		$this->pasien_nama_istri->CellCssStyle = "white-space: nowrap;";

		// pasien_KD_ETNIS
		$this->pasien_KD_ETNIS->CellCssStyle = "white-space: nowrap;";

		// pasien_KD_BHS_HARIAN
		$this->pasien_KD_BHS_HARIAN->CellCssStyle = "white-space: nowrap;";

		// BILL_FARMASI_SELESAI
		$this->BILL_FARMASI_SELESAI->CellCssStyle = "white-space: nowrap;";

		// TARIF_PELAYANAN_SIMRS
		$this->TARIF_PELAYANAN_SIMRS->CellCssStyle = "white-space: nowrap;";

		// USER_ADM
		$this->USER_ADM->CellCssStyle = "white-space: nowrap;";

		// TARIF_PENUNJANG_NON_MEDIS_IGD
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->CellCssStyle = "white-space: nowrap;";

		// TARIF_PELAYANAN_DARAH
		$this->TARIF_PELAYANAN_DARAH->CellCssStyle = "white-space: nowrap;";

		// penjamin_kkl_id
		$this->penjamin_kkl_id->CellCssStyle = "white-space: nowrap;";

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->CellCssStyle = "white-space: nowrap;";

		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		$this->status_kepesertaan_BPJS->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// PASIENBARU
		if (strval($this->PASIENBARU->CurrentValue) <> "") {
			$this->PASIENBARU->ViewValue = $this->PASIENBARU->OptionCaption($this->PASIENBARU->CurrentValue);
		} else {
			$this->PASIENBARU->ViewValue = NULL;
		}
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 7);
		$this->TGLREG->ViewCustomAttributes = "";

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

		// pasien_NAMA
		$this->pasien_NAMA->ViewValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_NAMA->ViewCustomAttributes = "";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->ViewValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TEMPAT->ViewCustomAttributes = "";

		// peserta_cob
		$this->peserta_cob->ViewValue = $this->peserta_cob->CurrentValue;
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

			// PASIENBARU
			$this->PASIENBARU->LinkCustomAttributes = "";
			$this->PASIENBARU->HrefValue = "";
			$this->PASIENBARU->TooltipValue = "";

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

			// pasien_NAMA
			$this->pasien_NAMA->LinkCustomAttributes = "";
			$this->pasien_NAMA->HrefValue = "";
			$this->pasien_NAMA->TooltipValue = "";

			// pasien_TEMPAT
			$this->pasien_TEMPAT->LinkCustomAttributes = "";
			$this->pasien_TEMPAT->HrefValue = "";
			$this->pasien_TEMPAT->TooltipValue = "";

			// peserta_cob
			$this->peserta_cob->LinkCustomAttributes = "";
			$this->peserta_cob->HrefValue = "";
			$this->peserta_cob->TooltipValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";
			$this->poli_eksekutif->TooltipValue = "";
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
			$this->ListOptions->Items["edit"]->Visible = FALSE;
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
if (!isset($t_pendaftaran_list)) $t_pendaftaran_list = new ct_pendaftaran_list();

// Page init
$t_pendaftaran_list->Page_Init();

// Page main
$t_pendaftaran_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_pendaftaran_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft_pendaftaranlist = new ew_Form("ft_pendaftaranlist", "list");
ft_pendaftaranlist.FormKeyCountName = '<?php echo $t_pendaftaran_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft_pendaftaranlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_pendaftaranlist.ValidateRequired = true;
<?php } else { ?>
ft_pendaftaranlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_pendaftaranlist.Lists["x_PASIENBARU"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_pendaftaranlist.Lists["x_PASIENBARU"].Options = <?php echo json_encode($t_pendaftaran->PASIENBARU->Options()) ?>;
ft_pendaftaranlist.Lists["x_KDDOKTER"] = {"LinkField":"x_kddokter","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_lookup_dokter_poli"};
ft_pendaftaranlist.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_KDDOKTER"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_pendaftaranlist.Lists["x_KDRUJUK"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
ft_pendaftaranlist.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_pendaftaranlist.Lists["x_SHIFT"] = {"LinkField":"x_id_shift","Ajax":true,"AutoFill":false,"DisplayFields":["x_shift","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_shift"};

// Form object for search
var CurrentSearchForm = ft_pendaftaranlistsrch = new ew_Form("ft_pendaftaranlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($t_pendaftaran_list->TotalRecs > 0 && $t_pendaftaran_list->ExportOptions->Visible()) { ?>
<?php $t_pendaftaran_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t_pendaftaran_list->SearchOptions->Visible()) { ?>
<?php $t_pendaftaran_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t_pendaftaran_list->FilterOptions->Visible()) { ?>
<?php $t_pendaftaran_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $t_pendaftaran_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_pendaftaran_list->TotalRecs <= 0)
			$t_pendaftaran_list->TotalRecs = $t_pendaftaran->SelectRecordCount();
	} else {
		if (!$t_pendaftaran_list->Recordset && ($t_pendaftaran_list->Recordset = $t_pendaftaran_list->LoadRecordset()))
			$t_pendaftaran_list->TotalRecs = $t_pendaftaran_list->Recordset->RecordCount();
	}
	$t_pendaftaran_list->StartRec = 1;
	if ($t_pendaftaran_list->DisplayRecs <= 0 || ($t_pendaftaran->Export <> "" && $t_pendaftaran->ExportAll)) // Display all records
		$t_pendaftaran_list->DisplayRecs = $t_pendaftaran_list->TotalRecs;
	if (!($t_pendaftaran->Export <> "" && $t_pendaftaran->ExportAll))
		$t_pendaftaran_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t_pendaftaran_list->Recordset = $t_pendaftaran_list->LoadRecordset($t_pendaftaran_list->StartRec-1, $t_pendaftaran_list->DisplayRecs);

	// Set no record found message
	if ($t_pendaftaran->CurrentAction == "" && $t_pendaftaran_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_pendaftaran_list->setWarningMessage(ew_DeniedMsg());
		if ($t_pendaftaran_list->SearchWhere == "0=101")
			$t_pendaftaran_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_pendaftaran_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($t_pendaftaran_list->AuditTrailOnSearch && $t_pendaftaran_list->Command == "search" && !$t_pendaftaran_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $t_pendaftaran_list->getSessionWhere();
		$t_pendaftaran_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$t_pendaftaran_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t_pendaftaran->Export == "" && $t_pendaftaran->CurrentAction == "") { ?>
<form name="ft_pendaftaranlistsrch" id="ft_pendaftaranlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t_pendaftaran_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft_pendaftaranlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t_pendaftaran">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t_pendaftaran_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t_pendaftaran_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t_pendaftaran_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t_pendaftaran_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t_pendaftaran_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t_pendaftaran_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t_pendaftaran_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $t_pendaftaran_list->ShowPageHeader(); ?>
<?php
$t_pendaftaran_list->ShowMessage();
?>
<?php if ($t_pendaftaran_list->TotalRecs > 0 || $t_pendaftaran->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_pendaftaran">
<form name="ft_pendaftaranlist" id="ft_pendaftaranlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_pendaftaran_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_pendaftaran_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_pendaftaran">
<div id="gmp_t_pendaftaran" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($t_pendaftaran_list->TotalRecs > 0 || $t_pendaftaran->CurrentAction == "gridedit") { ?>
<table id="tbl_t_pendaftaranlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_pendaftaran->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_pendaftaran_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_pendaftaran_list->RenderListOptions();

// Render list options (header, left)
$t_pendaftaran_list->ListOptions->Render("header", "left");
?>
<?php if ($t_pendaftaran->PASIENBARU->Visible) { // PASIENBARU ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->PASIENBARU) == "") { ?>
		<th data-name="PASIENBARU"><div id="elh_t_pendaftaran_PASIENBARU" class="t_pendaftaran_PASIENBARU"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->PASIENBARU->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PASIENBARU"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->PASIENBARU) ?>',2);"><div id="elh_t_pendaftaran_PASIENBARU" class="t_pendaftaran_PASIENBARU">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->PASIENBARU->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->PASIENBARU->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->PASIENBARU->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->NOMR->Visible) { // NOMR ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->NOMR) == "") { ?>
		<th data-name="NOMR"><div id="elh_t_pendaftaran_NOMR" class="t_pendaftaran_NOMR"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->NOMR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NOMR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->NOMR) ?>',2);"><div id="elh_t_pendaftaran_NOMR" class="t_pendaftaran_NOMR">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->NOMR->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->NOMR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->NOMR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->TGLREG->Visible) { // TGLREG ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->TGLREG) == "") { ?>
		<th data-name="TGLREG"><div id="elh_t_pendaftaran_TGLREG" class="t_pendaftaran_TGLREG"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->TGLREG->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TGLREG"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->TGLREG) ?>',2);"><div id="elh_t_pendaftaran_TGLREG" class="t_pendaftaran_TGLREG">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->TGLREG->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->TGLREG->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->TGLREG->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->KDDOKTER->Visible) { // KDDOKTER ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->KDDOKTER) == "") { ?>
		<th data-name="KDDOKTER"><div id="elh_t_pendaftaran_KDDOKTER" class="t_pendaftaran_KDDOKTER"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->KDDOKTER->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDDOKTER"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->KDDOKTER) ?>',2);"><div id="elh_t_pendaftaran_KDDOKTER" class="t_pendaftaran_KDDOKTER">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->KDDOKTER->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->KDDOKTER->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->KDDOKTER->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->KDPOLY->Visible) { // KDPOLY ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->KDPOLY) == "") { ?>
		<th data-name="KDPOLY"><div id="elh_t_pendaftaran_KDPOLY" class="t_pendaftaran_KDPOLY"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->KDPOLY->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDPOLY"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->KDPOLY) ?>',2);"><div id="elh_t_pendaftaran_KDPOLY" class="t_pendaftaran_KDPOLY">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->KDPOLY->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->KDPOLY->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->KDPOLY->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->KDRUJUK->Visible) { // KDRUJUK ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->KDRUJUK) == "") { ?>
		<th data-name="KDRUJUK"><div id="elh_t_pendaftaran_KDRUJUK" class="t_pendaftaran_KDRUJUK"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->KDRUJUK->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDRUJUK"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->KDRUJUK) ?>',2);"><div id="elh_t_pendaftaran_KDRUJUK" class="t_pendaftaran_KDRUJUK">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->KDRUJUK->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->KDRUJUK->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->KDRUJUK->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->KDCARABAYAR) == "") { ?>
		<th data-name="KDCARABAYAR"><div id="elh_t_pendaftaran_KDCARABAYAR" class="t_pendaftaran_KDCARABAYAR"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->KDCARABAYAR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDCARABAYAR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->KDCARABAYAR) ?>',2);"><div id="elh_t_pendaftaran_KDCARABAYAR" class="t_pendaftaran_KDCARABAYAR">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->KDCARABAYAR->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->KDCARABAYAR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->KDCARABAYAR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->SHIFT->Visible) { // SHIFT ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->SHIFT) == "") { ?>
		<th data-name="SHIFT"><div id="elh_t_pendaftaran_SHIFT" class="t_pendaftaran_SHIFT"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->SHIFT->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SHIFT"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->SHIFT) ?>',2);"><div id="elh_t_pendaftaran_SHIFT" class="t_pendaftaran_SHIFT">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->SHIFT->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->SHIFT->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->SHIFT->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->NIP->Visible) { // NIP ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->NIP) == "") { ?>
		<th data-name="NIP"><div id="elh_t_pendaftaran_NIP" class="t_pendaftaran_NIP"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->NIP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NIP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->NIP) ?>',2);"><div id="elh_t_pendaftaran_NIP" class="t_pendaftaran_NIP">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->NIP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->NIP->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->NIP->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->MASUKPOLY->Visible) { // MASUKPOLY ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->MASUKPOLY) == "") { ?>
		<th data-name="MASUKPOLY"><div id="elh_t_pendaftaran_MASUKPOLY" class="t_pendaftaran_MASUKPOLY"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->MASUKPOLY->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MASUKPOLY"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->MASUKPOLY) ?>',2);"><div id="elh_t_pendaftaran_MASUKPOLY" class="t_pendaftaran_MASUKPOLY">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->MASUKPOLY->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->MASUKPOLY->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->MASUKPOLY->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->KELUARPOLY->Visible) { // KELUARPOLY ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->KELUARPOLY) == "") { ?>
		<th data-name="KELUARPOLY"><div id="elh_t_pendaftaran_KELUARPOLY" class="t_pendaftaran_KELUARPOLY"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->KELUARPOLY->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KELUARPOLY"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->KELUARPOLY) ?>',2);"><div id="elh_t_pendaftaran_KELUARPOLY" class="t_pendaftaran_KELUARPOLY">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->KELUARPOLY->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->KELUARPOLY->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->KELUARPOLY->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->pasien_NAMA->Visible) { // pasien_NAMA ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->pasien_NAMA) == "") { ?>
		<th data-name="pasien_NAMA"><div id="elh_t_pendaftaran_pasien_NAMA" class="t_pendaftaran_pasien_NAMA"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->pasien_NAMA->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pasien_NAMA"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->pasien_NAMA) ?>',2);"><div id="elh_t_pendaftaran_pasien_NAMA" class="t_pendaftaran_pasien_NAMA">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->pasien_NAMA->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->pasien_NAMA->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->pasien_NAMA->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->pasien_TEMPAT->Visible) { // pasien_TEMPAT ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->pasien_TEMPAT) == "") { ?>
		<th data-name="pasien_TEMPAT"><div id="elh_t_pendaftaran_pasien_TEMPAT" class="t_pendaftaran_pasien_TEMPAT"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $t_pendaftaran->pasien_TEMPAT->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pasien_TEMPAT"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->pasien_TEMPAT) ?>',2);"><div id="elh_t_pendaftaran_pasien_TEMPAT" class="t_pendaftaran_pasien_TEMPAT">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->pasien_TEMPAT->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->pasien_TEMPAT->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->pasien_TEMPAT->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->peserta_cob->Visible) { // peserta_cob ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->peserta_cob) == "") { ?>
		<th data-name="peserta_cob"><div id="elh_t_pendaftaran_peserta_cob" class="t_pendaftaran_peserta_cob"><div class="ewTableHeaderCaption"><?php echo $t_pendaftaran->peserta_cob->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="peserta_cob"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->peserta_cob) ?>',2);"><div id="elh_t_pendaftaran_peserta_cob" class="t_pendaftaran_peserta_cob">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->peserta_cob->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->peserta_cob->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->peserta_cob->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_pendaftaran->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<?php if ($t_pendaftaran->SortUrl($t_pendaftaran->poli_eksekutif) == "") { ?>
		<th data-name="poli_eksekutif"><div id="elh_t_pendaftaran_poli_eksekutif" class="t_pendaftaran_poli_eksekutif"><div class="ewTableHeaderCaption"><?php echo $t_pendaftaran->poli_eksekutif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="poli_eksekutif"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_pendaftaran->SortUrl($t_pendaftaran->poli_eksekutif) ?>',2);"><div id="elh_t_pendaftaran_poli_eksekutif" class="t_pendaftaran_poli_eksekutif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_pendaftaran->poli_eksekutif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_pendaftaran->poli_eksekutif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_pendaftaran->poli_eksekutif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_pendaftaran_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t_pendaftaran->ExportAll && $t_pendaftaran->Export <> "") {
	$t_pendaftaran_list->StopRec = $t_pendaftaran_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t_pendaftaran_list->TotalRecs > $t_pendaftaran_list->StartRec + $t_pendaftaran_list->DisplayRecs - 1)
		$t_pendaftaran_list->StopRec = $t_pendaftaran_list->StartRec + $t_pendaftaran_list->DisplayRecs - 1;
	else
		$t_pendaftaran_list->StopRec = $t_pendaftaran_list->TotalRecs;
}
$t_pendaftaran_list->RecCnt = $t_pendaftaran_list->StartRec - 1;
if ($t_pendaftaran_list->Recordset && !$t_pendaftaran_list->Recordset->EOF) {
	$t_pendaftaran_list->Recordset->MoveFirst();
	$bSelectLimit = $t_pendaftaran_list->UseSelectLimit;
	if (!$bSelectLimit && $t_pendaftaran_list->StartRec > 1)
		$t_pendaftaran_list->Recordset->Move($t_pendaftaran_list->StartRec - 1);
} elseif (!$t_pendaftaran->AllowAddDeleteRow && $t_pendaftaran_list->StopRec == 0) {
	$t_pendaftaran_list->StopRec = $t_pendaftaran->GridAddRowCount;
}

// Initialize aggregate
$t_pendaftaran->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_pendaftaran->ResetAttrs();
$t_pendaftaran_list->RenderRow();
while ($t_pendaftaran_list->RecCnt < $t_pendaftaran_list->StopRec) {
	$t_pendaftaran_list->RecCnt++;
	if (intval($t_pendaftaran_list->RecCnt) >= intval($t_pendaftaran_list->StartRec)) {
		$t_pendaftaran_list->RowCnt++;

		// Set up key count
		$t_pendaftaran_list->KeyCount = $t_pendaftaran_list->RowIndex;

		// Init row class and style
		$t_pendaftaran->ResetAttrs();
		$t_pendaftaran->CssClass = "";
		if ($t_pendaftaran->CurrentAction == "gridadd") {
		} else {
			$t_pendaftaran_list->LoadRowValues($t_pendaftaran_list->Recordset); // Load row values
		}
		$t_pendaftaran->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t_pendaftaran->RowAttrs = array_merge($t_pendaftaran->RowAttrs, array('data-rowindex'=>$t_pendaftaran_list->RowCnt, 'id'=>'r' . $t_pendaftaran_list->RowCnt . '_t_pendaftaran', 'data-rowtype'=>$t_pendaftaran->RowType));

		// Render row
		$t_pendaftaran_list->RenderRow();

		// Render list options
		$t_pendaftaran_list->RenderListOptions();
?>
	<tr<?php echo $t_pendaftaran->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_pendaftaran_list->ListOptions->Render("body", "left", $t_pendaftaran_list->RowCnt);
?>
	<?php if ($t_pendaftaran->PASIENBARU->Visible) { // PASIENBARU ?>
		<td data-name="PASIENBARU"<?php echo $t_pendaftaran->PASIENBARU->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_PASIENBARU" class="t_pendaftaran_PASIENBARU">
<span<?php echo $t_pendaftaran->PASIENBARU->ViewAttributes() ?>>
<?php echo $t_pendaftaran->PASIENBARU->ListViewValue() ?></span>
</span>
<a id="<?php echo $t_pendaftaran_list->PageObjName . "_row_" . $t_pendaftaran_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t_pendaftaran->NOMR->Visible) { // NOMR ?>
		<td data-name="NOMR"<?php echo $t_pendaftaran->NOMR->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_NOMR" class="t_pendaftaran_NOMR">
<span<?php echo $t_pendaftaran->NOMR->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NOMR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->TGLREG->Visible) { // TGLREG ?>
		<td data-name="TGLREG"<?php echo $t_pendaftaran->TGLREG->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_TGLREG" class="t_pendaftaran_TGLREG">
<span<?php echo $t_pendaftaran->TGLREG->ViewAttributes() ?>>
<?php echo $t_pendaftaran->TGLREG->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->KDDOKTER->Visible) { // KDDOKTER ?>
		<td data-name="KDDOKTER"<?php echo $t_pendaftaran->KDDOKTER->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_KDDOKTER" class="t_pendaftaran_KDDOKTER">
<span<?php echo $t_pendaftaran->KDDOKTER->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDDOKTER->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->KDPOLY->Visible) { // KDPOLY ?>
		<td data-name="KDPOLY"<?php echo $t_pendaftaran->KDPOLY->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_KDPOLY" class="t_pendaftaran_KDPOLY">
<span<?php echo $t_pendaftaran->KDPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDPOLY->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->KDRUJUK->Visible) { // KDRUJUK ?>
		<td data-name="KDRUJUK"<?php echo $t_pendaftaran->KDRUJUK->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_KDRUJUK" class="t_pendaftaran_KDRUJUK">
<span<?php echo $t_pendaftaran->KDRUJUK->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDRUJUK->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<td data-name="KDCARABAYAR"<?php echo $t_pendaftaran->KDCARABAYAR->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_KDCARABAYAR" class="t_pendaftaran_KDCARABAYAR">
<span<?php echo $t_pendaftaran->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KDCARABAYAR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->SHIFT->Visible) { // SHIFT ?>
		<td data-name="SHIFT"<?php echo $t_pendaftaran->SHIFT->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_SHIFT" class="t_pendaftaran_SHIFT">
<span<?php echo $t_pendaftaran->SHIFT->ViewAttributes() ?>>
<?php echo $t_pendaftaran->SHIFT->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->NIP->Visible) { // NIP ?>
		<td data-name="NIP"<?php echo $t_pendaftaran->NIP->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_NIP" class="t_pendaftaran_NIP">
<span<?php echo $t_pendaftaran->NIP->ViewAttributes() ?>>
<?php echo $t_pendaftaran->NIP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->MASUKPOLY->Visible) { // MASUKPOLY ?>
		<td data-name="MASUKPOLY"<?php echo $t_pendaftaran->MASUKPOLY->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_MASUKPOLY" class="t_pendaftaran_MASUKPOLY">
<span<?php echo $t_pendaftaran->MASUKPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->MASUKPOLY->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->KELUARPOLY->Visible) { // KELUARPOLY ?>
		<td data-name="KELUARPOLY"<?php echo $t_pendaftaran->KELUARPOLY->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_KELUARPOLY" class="t_pendaftaran_KELUARPOLY">
<span<?php echo $t_pendaftaran->KELUARPOLY->ViewAttributes() ?>>
<?php echo $t_pendaftaran->KELUARPOLY->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->pasien_NAMA->Visible) { // pasien_NAMA ?>
		<td data-name="pasien_NAMA"<?php echo $t_pendaftaran->pasien_NAMA->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_pasien_NAMA" class="t_pendaftaran_pasien_NAMA">
<span<?php echo $t_pendaftaran->pasien_NAMA->ViewAttributes() ?>>
<?php echo $t_pendaftaran->pasien_NAMA->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->pasien_TEMPAT->Visible) { // pasien_TEMPAT ?>
		<td data-name="pasien_TEMPAT"<?php echo $t_pendaftaran->pasien_TEMPAT->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_pasien_TEMPAT" class="t_pendaftaran_pasien_TEMPAT">
<span<?php echo $t_pendaftaran->pasien_TEMPAT->ViewAttributes() ?>>
<?php echo $t_pendaftaran->pasien_TEMPAT->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->peserta_cob->Visible) { // peserta_cob ?>
		<td data-name="peserta_cob"<?php echo $t_pendaftaran->peserta_cob->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_peserta_cob" class="t_pendaftaran_peserta_cob">
<span<?php echo $t_pendaftaran->peserta_cob->ViewAttributes() ?>>
<?php echo $t_pendaftaran->peserta_cob->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_pendaftaran->poli_eksekutif->Visible) { // poli_eksekutif ?>
		<td data-name="poli_eksekutif"<?php echo $t_pendaftaran->poli_eksekutif->CellAttributes() ?>>
<span id="el<?php echo $t_pendaftaran_list->RowCnt ?>_t_pendaftaran_poli_eksekutif" class="t_pendaftaran_poli_eksekutif">
<span<?php echo $t_pendaftaran->poli_eksekutif->ViewAttributes() ?>>
<?php echo $t_pendaftaran->poli_eksekutif->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_pendaftaran_list->ListOptions->Render("body", "right", $t_pendaftaran_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t_pendaftaran->CurrentAction <> "gridadd")
		$t_pendaftaran_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t_pendaftaran->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t_pendaftaran_list->Recordset)
	$t_pendaftaran_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t_pendaftaran->CurrentAction <> "gridadd" && $t_pendaftaran->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_pendaftaran_list->Pager)) $t_pendaftaran_list->Pager = new cPrevNextPager($t_pendaftaran_list->StartRec, $t_pendaftaran_list->DisplayRecs, $t_pendaftaran_list->TotalRecs) ?>
<?php if ($t_pendaftaran_list->Pager->RecordCount > 0 && $t_pendaftaran_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_pendaftaran_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_pendaftaran_list->PageUrl() ?>start=<?php echo $t_pendaftaran_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_pendaftaran_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_pendaftaran_list->PageUrl() ?>start=<?php echo $t_pendaftaran_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_pendaftaran_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_pendaftaran_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_pendaftaran_list->PageUrl() ?>start=<?php echo $t_pendaftaran_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_pendaftaran_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_pendaftaran_list->PageUrl() ?>start=<?php echo $t_pendaftaran_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_pendaftaran_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t_pendaftaran_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t_pendaftaran_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t_pendaftaran_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t_pendaftaran_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t_pendaftaran_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="t_pendaftaran">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($t_pendaftaran_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($t_pendaftaran_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t_pendaftaran_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t_pendaftaran_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t_pendaftaran_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_pendaftaran_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t_pendaftaran_list->TotalRecs == 0 && $t_pendaftaran->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_pendaftaran_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft_pendaftaranlistsrch.FilterList = <?php echo $t_pendaftaran_list->GetFilterList() ?>;
ft_pendaftaranlistsrch.Init();
ft_pendaftaranlist.Init();
</script>
<?php
$t_pendaftaran_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_pendaftaran_list->Page_Terminate();
?>
