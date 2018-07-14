<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bridging_sep_by_no_kartuinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bridging_sep_by_no_kartu_list = NULL; // Initialize page object first

class cvw_bridging_sep_by_no_kartu_list extends cvw_bridging_sep_by_no_kartu {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bridging_sep_by_no_kartu';

	// Page object name
	var $PageObjName = 'vw_bridging_sep_by_no_kartu_list';

	// Grid form hidden field names
	var $FormName = 'fvw_bridging_sep_by_no_kartulist';
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

		// Table object (vw_bridging_sep_by_no_kartu)
		if (!isset($GLOBALS["vw_bridging_sep_by_no_kartu"]) || get_class($GLOBALS["vw_bridging_sep_by_no_kartu"]) == "cvw_bridging_sep_by_no_kartu") {
			$GLOBALS["vw_bridging_sep_by_no_kartu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bridging_sep_by_no_kartu"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_bridging_sep_by_no_kartuadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_bridging_sep_by_no_kartudelete.php";
		$this->MultiUpdateUrl = "vw_bridging_sep_by_no_kartuupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bridging_sep_by_no_kartu', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_bridging_sep_by_no_kartulistsrch";

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
		$this->KDCARABAYAR->SetVisibility();
		$this->NIP->SetVisibility();
		$this->JAMREG->SetVisibility();
		$this->NO_SJP->SetVisibility();
		$this->NOKARTU->SetVisibility();
		$this->USER->SetVisibility();

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
		global $EW_EXPORT, $vw_bridging_sep_by_no_kartu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bridging_sep_by_no_kartu);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_bridging_sep_by_no_kartulistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->IDXDAFTAR->AdvancedSearch->ToJSON(), ","); // Field IDXDAFTAR
		$sFilterList = ew_Concat($sFilterList, $this->NOMR->AdvancedSearch->ToJSON(), ","); // Field NOMR
		$sFilterList = ew_Concat($sFilterList, $this->KDPOLY->AdvancedSearch->ToJSON(), ","); // Field KDPOLY
		$sFilterList = ew_Concat($sFilterList, $this->KDCARABAYAR->AdvancedSearch->ToJSON(), ","); // Field KDCARABAYAR
		$sFilterList = ew_Concat($sFilterList, $this->NIP->AdvancedSearch->ToJSON(), ","); // Field NIP
		$sFilterList = ew_Concat($sFilterList, $this->TGLREG->AdvancedSearch->ToJSON(), ","); // Field TGLREG
		$sFilterList = ew_Concat($sFilterList, $this->JAMREG->AdvancedSearch->ToJSON(), ","); // Field JAMREG
		$sFilterList = ew_Concat($sFilterList, $this->NO_SJP->AdvancedSearch->ToJSON(), ","); // Field NO_SJP
		$sFilterList = ew_Concat($sFilterList, $this->NOKARTU->AdvancedSearch->ToJSON(), ","); // Field NOKARTU
		$sFilterList = ew_Concat($sFilterList, $this->TANGGAL_SEP->AdvancedSearch->ToJSON(), ","); // Field TANGGAL_SEP
		$sFilterList = ew_Concat($sFilterList, $this->TANGGALRUJUK_SEP->AdvancedSearch->ToJSON(), ","); // Field TANGGALRUJUK_SEP
		$sFilterList = ew_Concat($sFilterList, $this->KELASRAWAT_SEP->AdvancedSearch->ToJSON(), ","); // Field KELASRAWAT_SEP
		$sFilterList = ew_Concat($sFilterList, $this->NORUJUKAN_SEP->AdvancedSearch->ToJSON(), ","); // Field NORUJUKAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->PPKPELAYANAN_SEP->AdvancedSearch->ToJSON(), ","); // Field PPKPELAYANAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->JENISPERAWATAN_SEP->AdvancedSearch->ToJSON(), ","); // Field JENISPERAWATAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->CATATAN_SEP->AdvancedSearch->ToJSON(), ","); // Field CATATAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->DIAGNOSAAWAL_SEP->AdvancedSearch->ToJSON(), ","); // Field DIAGNOSAAWAL_SEP
		$sFilterList = ew_Concat($sFilterList, $this->NAMADIAGNOSA_SEP->AdvancedSearch->ToJSON(), ","); // Field NAMADIAGNOSA_SEP
		$sFilterList = ew_Concat($sFilterList, $this->LAKALANTAS_SEP->AdvancedSearch->ToJSON(), ","); // Field LAKALANTAS_SEP
		$sFilterList = ew_Concat($sFilterList, $this->LOKASILAKALANTAS->AdvancedSearch->ToJSON(), ","); // Field LOKASILAKALANTAS
		$sFilterList = ew_Concat($sFilterList, $this->USER->AdvancedSearch->ToJSON(), ","); // Field USER
		$sFilterList = ew_Concat($sFilterList, $this->PESERTANIK_SEP->AdvancedSearch->ToJSON(), ","); // Field PESERTANIK_SEP
		$sFilterList = ew_Concat($sFilterList, $this->PESERTANAMA_SEP->AdvancedSearch->ToJSON(), ","); // Field PESERTANAMA_SEP
		$sFilterList = ew_Concat($sFilterList, $this->PESERTAJENISKELAMIN_SEP->AdvancedSearch->ToJSON(), ","); // Field PESERTAJENISKELAMIN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->PESERTANAMAKELAS_SEP->AdvancedSearch->ToJSON(), ","); // Field PESERTANAMAKELAS_SEP
		$sFilterList = ew_Concat($sFilterList, $this->PESERTAPISAT->AdvancedSearch->ToJSON(), ","); // Field PESERTAPISAT
		$sFilterList = ew_Concat($sFilterList, $this->PESERTATGLLAHIR->AdvancedSearch->ToJSON(), ","); // Field PESERTATGLLAHIR
		$sFilterList = ew_Concat($sFilterList, $this->PESERTAJENISPESERTA_SEP->AdvancedSearch->ToJSON(), ","); // Field PESERTAJENISPESERTA_SEP
		$sFilterList = ew_Concat($sFilterList, $this->PESERTANAMAJENISPESERTA_SEP->AdvancedSearch->ToJSON(), ","); // Field PESERTANAMAJENISPESERTA_SEP
		$sFilterList = ew_Concat($sFilterList, $this->POLITUJUAN_SEP->AdvancedSearch->ToJSON(), ","); // Field POLITUJUAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->NAMAPOLITUJUAN_SEP->AdvancedSearch->ToJSON(), ","); // Field NAMAPOLITUJUAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->KDPPKRUJUKAN_SEP->AdvancedSearch->ToJSON(), ","); // Field KDPPKRUJUKAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->NMPPKRUJUKAN_SEP->AdvancedSearch->ToJSON(), ","); // Field NMPPKRUJUKAN_SEP
		$sFilterList = ew_Concat($sFilterList, $this->pasien_NOTELP->AdvancedSearch->ToJSON(), ","); // Field pasien_NOTELP
		$sFilterList = ew_Concat($sFilterList, $this->penjamin_kkl_id->AdvancedSearch->ToJSON(), ","); // Field penjamin_kkl_id
		$sFilterList = ew_Concat($sFilterList, $this->asalfaskesrujukan_id->AdvancedSearch->ToJSON(), ","); // Field asalfaskesrujukan_id
		$sFilterList = ew_Concat($sFilterList, $this->peserta_cob->AdvancedSearch->ToJSON(), ","); // Field peserta_cob
		$sFilterList = ew_Concat($sFilterList, $this->poli_eksekutif->AdvancedSearch->ToJSON(), ","); // Field poli_eksekutif
		$sFilterList = ew_Concat($sFilterList, $this->status_kepesertaan_BPJS->AdvancedSearch->ToJSON(), ","); // Field status_kepesertaan_BPJS
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_bridging_sep_by_no_kartulistsrch", $filters);

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

		// Field IDXDAFTAR
		$this->IDXDAFTAR->AdvancedSearch->SearchValue = @$filter["x_IDXDAFTAR"];
		$this->IDXDAFTAR->AdvancedSearch->SearchOperator = @$filter["z_IDXDAFTAR"];
		$this->IDXDAFTAR->AdvancedSearch->SearchCondition = @$filter["v_IDXDAFTAR"];
		$this->IDXDAFTAR->AdvancedSearch->SearchValue2 = @$filter["y_IDXDAFTAR"];
		$this->IDXDAFTAR->AdvancedSearch->SearchOperator2 = @$filter["w_IDXDAFTAR"];
		$this->IDXDAFTAR->AdvancedSearch->Save();

		// Field NOMR
		$this->NOMR->AdvancedSearch->SearchValue = @$filter["x_NOMR"];
		$this->NOMR->AdvancedSearch->SearchOperator = @$filter["z_NOMR"];
		$this->NOMR->AdvancedSearch->SearchCondition = @$filter["v_NOMR"];
		$this->NOMR->AdvancedSearch->SearchValue2 = @$filter["y_NOMR"];
		$this->NOMR->AdvancedSearch->SearchOperator2 = @$filter["w_NOMR"];
		$this->NOMR->AdvancedSearch->Save();

		// Field KDPOLY
		$this->KDPOLY->AdvancedSearch->SearchValue = @$filter["x_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchOperator = @$filter["z_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchCondition = @$filter["v_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchValue2 = @$filter["y_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->SearchOperator2 = @$filter["w_KDPOLY"];
		$this->KDPOLY->AdvancedSearch->Save();

		// Field KDCARABAYAR
		$this->KDCARABAYAR->AdvancedSearch->SearchValue = @$filter["x_KDCARABAYAR"];
		$this->KDCARABAYAR->AdvancedSearch->SearchOperator = @$filter["z_KDCARABAYAR"];
		$this->KDCARABAYAR->AdvancedSearch->SearchCondition = @$filter["v_KDCARABAYAR"];
		$this->KDCARABAYAR->AdvancedSearch->SearchValue2 = @$filter["y_KDCARABAYAR"];
		$this->KDCARABAYAR->AdvancedSearch->SearchOperator2 = @$filter["w_KDCARABAYAR"];
		$this->KDCARABAYAR->AdvancedSearch->Save();

		// Field NIP
		$this->NIP->AdvancedSearch->SearchValue = @$filter["x_NIP"];
		$this->NIP->AdvancedSearch->SearchOperator = @$filter["z_NIP"];
		$this->NIP->AdvancedSearch->SearchCondition = @$filter["v_NIP"];
		$this->NIP->AdvancedSearch->SearchValue2 = @$filter["y_NIP"];
		$this->NIP->AdvancedSearch->SearchOperator2 = @$filter["w_NIP"];
		$this->NIP->AdvancedSearch->Save();

		// Field TGLREG
		$this->TGLREG->AdvancedSearch->SearchValue = @$filter["x_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchOperator = @$filter["z_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchCondition = @$filter["v_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchValue2 = @$filter["y_TGLREG"];
		$this->TGLREG->AdvancedSearch->SearchOperator2 = @$filter["w_TGLREG"];
		$this->TGLREG->AdvancedSearch->Save();

		// Field JAMREG
		$this->JAMREG->AdvancedSearch->SearchValue = @$filter["x_JAMREG"];
		$this->JAMREG->AdvancedSearch->SearchOperator = @$filter["z_JAMREG"];
		$this->JAMREG->AdvancedSearch->SearchCondition = @$filter["v_JAMREG"];
		$this->JAMREG->AdvancedSearch->SearchValue2 = @$filter["y_JAMREG"];
		$this->JAMREG->AdvancedSearch->SearchOperator2 = @$filter["w_JAMREG"];
		$this->JAMREG->AdvancedSearch->Save();

		// Field NO_SJP
		$this->NO_SJP->AdvancedSearch->SearchValue = @$filter["x_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchOperator = @$filter["z_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchCondition = @$filter["v_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchValue2 = @$filter["y_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->SearchOperator2 = @$filter["w_NO_SJP"];
		$this->NO_SJP->AdvancedSearch->Save();

		// Field NOKARTU
		$this->NOKARTU->AdvancedSearch->SearchValue = @$filter["x_NOKARTU"];
		$this->NOKARTU->AdvancedSearch->SearchOperator = @$filter["z_NOKARTU"];
		$this->NOKARTU->AdvancedSearch->SearchCondition = @$filter["v_NOKARTU"];
		$this->NOKARTU->AdvancedSearch->SearchValue2 = @$filter["y_NOKARTU"];
		$this->NOKARTU->AdvancedSearch->SearchOperator2 = @$filter["w_NOKARTU"];
		$this->NOKARTU->AdvancedSearch->Save();

		// Field TANGGAL_SEP
		$this->TANGGAL_SEP->AdvancedSearch->SearchValue = @$filter["x_TANGGAL_SEP"];
		$this->TANGGAL_SEP->AdvancedSearch->SearchOperator = @$filter["z_TANGGAL_SEP"];
		$this->TANGGAL_SEP->AdvancedSearch->SearchCondition = @$filter["v_TANGGAL_SEP"];
		$this->TANGGAL_SEP->AdvancedSearch->SearchValue2 = @$filter["y_TANGGAL_SEP"];
		$this->TANGGAL_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_TANGGAL_SEP"];
		$this->TANGGAL_SEP->AdvancedSearch->Save();

		// Field TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->AdvancedSearch->SearchValue = @$filter["x_TANGGALRUJUK_SEP"];
		$this->TANGGALRUJUK_SEP->AdvancedSearch->SearchOperator = @$filter["z_TANGGALRUJUK_SEP"];
		$this->TANGGALRUJUK_SEP->AdvancedSearch->SearchCondition = @$filter["v_TANGGALRUJUK_SEP"];
		$this->TANGGALRUJUK_SEP->AdvancedSearch->SearchValue2 = @$filter["y_TANGGALRUJUK_SEP"];
		$this->TANGGALRUJUK_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_TANGGALRUJUK_SEP"];
		$this->TANGGALRUJUK_SEP->AdvancedSearch->Save();

		// Field KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->AdvancedSearch->SearchValue = @$filter["x_KELASRAWAT_SEP"];
		$this->KELASRAWAT_SEP->AdvancedSearch->SearchOperator = @$filter["z_KELASRAWAT_SEP"];
		$this->KELASRAWAT_SEP->AdvancedSearch->SearchCondition = @$filter["v_KELASRAWAT_SEP"];
		$this->KELASRAWAT_SEP->AdvancedSearch->SearchValue2 = @$filter["y_KELASRAWAT_SEP"];
		$this->KELASRAWAT_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_KELASRAWAT_SEP"];
		$this->KELASRAWAT_SEP->AdvancedSearch->Save();

		// Field NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->AdvancedSearch->SearchValue = @$filter["x_NORUJUKAN_SEP"];
		$this->NORUJUKAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_NORUJUKAN_SEP"];
		$this->NORUJUKAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_NORUJUKAN_SEP"];
		$this->NORUJUKAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_NORUJUKAN_SEP"];
		$this->NORUJUKAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_NORUJUKAN_SEP"];
		$this->NORUJUKAN_SEP->AdvancedSearch->Save();

		// Field PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->AdvancedSearch->SearchValue = @$filter["x_PPKPELAYANAN_SEP"];
		$this->PPKPELAYANAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_PPKPELAYANAN_SEP"];
		$this->PPKPELAYANAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_PPKPELAYANAN_SEP"];
		$this->PPKPELAYANAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_PPKPELAYANAN_SEP"];
		$this->PPKPELAYANAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_PPKPELAYANAN_SEP"];
		$this->PPKPELAYANAN_SEP->AdvancedSearch->Save();

		// Field JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->AdvancedSearch->SearchValue = @$filter["x_JENISPERAWATAN_SEP"];
		$this->JENISPERAWATAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_JENISPERAWATAN_SEP"];
		$this->JENISPERAWATAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_JENISPERAWATAN_SEP"];
		$this->JENISPERAWATAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_JENISPERAWATAN_SEP"];
		$this->JENISPERAWATAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_JENISPERAWATAN_SEP"];
		$this->JENISPERAWATAN_SEP->AdvancedSearch->Save();

		// Field CATATAN_SEP
		$this->CATATAN_SEP->AdvancedSearch->SearchValue = @$filter["x_CATATAN_SEP"];
		$this->CATATAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_CATATAN_SEP"];
		$this->CATATAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_CATATAN_SEP"];
		$this->CATATAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_CATATAN_SEP"];
		$this->CATATAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_CATATAN_SEP"];
		$this->CATATAN_SEP->AdvancedSearch->Save();

		// Field DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->AdvancedSearch->SearchValue = @$filter["x_DIAGNOSAAWAL_SEP"];
		$this->DIAGNOSAAWAL_SEP->AdvancedSearch->SearchOperator = @$filter["z_DIAGNOSAAWAL_SEP"];
		$this->DIAGNOSAAWAL_SEP->AdvancedSearch->SearchCondition = @$filter["v_DIAGNOSAAWAL_SEP"];
		$this->DIAGNOSAAWAL_SEP->AdvancedSearch->SearchValue2 = @$filter["y_DIAGNOSAAWAL_SEP"];
		$this->DIAGNOSAAWAL_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_DIAGNOSAAWAL_SEP"];
		$this->DIAGNOSAAWAL_SEP->AdvancedSearch->Save();

		// Field NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->AdvancedSearch->SearchValue = @$filter["x_NAMADIAGNOSA_SEP"];
		$this->NAMADIAGNOSA_SEP->AdvancedSearch->SearchOperator = @$filter["z_NAMADIAGNOSA_SEP"];
		$this->NAMADIAGNOSA_SEP->AdvancedSearch->SearchCondition = @$filter["v_NAMADIAGNOSA_SEP"];
		$this->NAMADIAGNOSA_SEP->AdvancedSearch->SearchValue2 = @$filter["y_NAMADIAGNOSA_SEP"];
		$this->NAMADIAGNOSA_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_NAMADIAGNOSA_SEP"];
		$this->NAMADIAGNOSA_SEP->AdvancedSearch->Save();

		// Field LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->AdvancedSearch->SearchValue = @$filter["x_LAKALANTAS_SEP"];
		$this->LAKALANTAS_SEP->AdvancedSearch->SearchOperator = @$filter["z_LAKALANTAS_SEP"];
		$this->LAKALANTAS_SEP->AdvancedSearch->SearchCondition = @$filter["v_LAKALANTAS_SEP"];
		$this->LAKALANTAS_SEP->AdvancedSearch->SearchValue2 = @$filter["y_LAKALANTAS_SEP"];
		$this->LAKALANTAS_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_LAKALANTAS_SEP"];
		$this->LAKALANTAS_SEP->AdvancedSearch->Save();

		// Field LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->AdvancedSearch->SearchValue = @$filter["x_LOKASILAKALANTAS"];
		$this->LOKASILAKALANTAS->AdvancedSearch->SearchOperator = @$filter["z_LOKASILAKALANTAS"];
		$this->LOKASILAKALANTAS->AdvancedSearch->SearchCondition = @$filter["v_LOKASILAKALANTAS"];
		$this->LOKASILAKALANTAS->AdvancedSearch->SearchValue2 = @$filter["y_LOKASILAKALANTAS"];
		$this->LOKASILAKALANTAS->AdvancedSearch->SearchOperator2 = @$filter["w_LOKASILAKALANTAS"];
		$this->LOKASILAKALANTAS->AdvancedSearch->Save();

		// Field USER
		$this->USER->AdvancedSearch->SearchValue = @$filter["x_USER"];
		$this->USER->AdvancedSearch->SearchOperator = @$filter["z_USER"];
		$this->USER->AdvancedSearch->SearchCondition = @$filter["v_USER"];
		$this->USER->AdvancedSearch->SearchValue2 = @$filter["y_USER"];
		$this->USER->AdvancedSearch->SearchOperator2 = @$filter["w_USER"];
		$this->USER->AdvancedSearch->Save();

		// Field PESERTANIK_SEP
		$this->PESERTANIK_SEP->AdvancedSearch->SearchValue = @$filter["x_PESERTANIK_SEP"];
		$this->PESERTANIK_SEP->AdvancedSearch->SearchOperator = @$filter["z_PESERTANIK_SEP"];
		$this->PESERTANIK_SEP->AdvancedSearch->SearchCondition = @$filter["v_PESERTANIK_SEP"];
		$this->PESERTANIK_SEP->AdvancedSearch->SearchValue2 = @$filter["y_PESERTANIK_SEP"];
		$this->PESERTANIK_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTANIK_SEP"];
		$this->PESERTANIK_SEP->AdvancedSearch->Save();

		// Field PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->AdvancedSearch->SearchValue = @$filter["x_PESERTANAMA_SEP"];
		$this->PESERTANAMA_SEP->AdvancedSearch->SearchOperator = @$filter["z_PESERTANAMA_SEP"];
		$this->PESERTANAMA_SEP->AdvancedSearch->SearchCondition = @$filter["v_PESERTANAMA_SEP"];
		$this->PESERTANAMA_SEP->AdvancedSearch->SearchValue2 = @$filter["y_PESERTANAMA_SEP"];
		$this->PESERTANAMA_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTANAMA_SEP"];
		$this->PESERTANAMA_SEP->AdvancedSearch->Save();

		// Field PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->AdvancedSearch->SearchValue = @$filter["x_PESERTAJENISKELAMIN_SEP"];
		$this->PESERTAJENISKELAMIN_SEP->AdvancedSearch->SearchOperator = @$filter["z_PESERTAJENISKELAMIN_SEP"];
		$this->PESERTAJENISKELAMIN_SEP->AdvancedSearch->SearchCondition = @$filter["v_PESERTAJENISKELAMIN_SEP"];
		$this->PESERTAJENISKELAMIN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_PESERTAJENISKELAMIN_SEP"];
		$this->PESERTAJENISKELAMIN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTAJENISKELAMIN_SEP"];
		$this->PESERTAJENISKELAMIN_SEP->AdvancedSearch->Save();

		// Field PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->AdvancedSearch->SearchValue = @$filter["x_PESERTANAMAKELAS_SEP"];
		$this->PESERTANAMAKELAS_SEP->AdvancedSearch->SearchOperator = @$filter["z_PESERTANAMAKELAS_SEP"];
		$this->PESERTANAMAKELAS_SEP->AdvancedSearch->SearchCondition = @$filter["v_PESERTANAMAKELAS_SEP"];
		$this->PESERTANAMAKELAS_SEP->AdvancedSearch->SearchValue2 = @$filter["y_PESERTANAMAKELAS_SEP"];
		$this->PESERTANAMAKELAS_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTANAMAKELAS_SEP"];
		$this->PESERTANAMAKELAS_SEP->AdvancedSearch->Save();

		// Field PESERTAPISAT
		$this->PESERTAPISAT->AdvancedSearch->SearchValue = @$filter["x_PESERTAPISAT"];
		$this->PESERTAPISAT->AdvancedSearch->SearchOperator = @$filter["z_PESERTAPISAT"];
		$this->PESERTAPISAT->AdvancedSearch->SearchCondition = @$filter["v_PESERTAPISAT"];
		$this->PESERTAPISAT->AdvancedSearch->SearchValue2 = @$filter["y_PESERTAPISAT"];
		$this->PESERTAPISAT->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTAPISAT"];
		$this->PESERTAPISAT->AdvancedSearch->Save();

		// Field PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->AdvancedSearch->SearchValue = @$filter["x_PESERTATGLLAHIR"];
		$this->PESERTATGLLAHIR->AdvancedSearch->SearchOperator = @$filter["z_PESERTATGLLAHIR"];
		$this->PESERTATGLLAHIR->AdvancedSearch->SearchCondition = @$filter["v_PESERTATGLLAHIR"];
		$this->PESERTATGLLAHIR->AdvancedSearch->SearchValue2 = @$filter["y_PESERTATGLLAHIR"];
		$this->PESERTATGLLAHIR->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTATGLLAHIR"];
		$this->PESERTATGLLAHIR->AdvancedSearch->Save();

		// Field PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->AdvancedSearch->SearchValue = @$filter["x_PESERTAJENISPESERTA_SEP"];
		$this->PESERTAJENISPESERTA_SEP->AdvancedSearch->SearchOperator = @$filter["z_PESERTAJENISPESERTA_SEP"];
		$this->PESERTAJENISPESERTA_SEP->AdvancedSearch->SearchCondition = @$filter["v_PESERTAJENISPESERTA_SEP"];
		$this->PESERTAJENISPESERTA_SEP->AdvancedSearch->SearchValue2 = @$filter["y_PESERTAJENISPESERTA_SEP"];
		$this->PESERTAJENISPESERTA_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTAJENISPESERTA_SEP"];
		$this->PESERTAJENISPESERTA_SEP->AdvancedSearch->Save();

		// Field PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->AdvancedSearch->SearchValue = @$filter["x_PESERTANAMAJENISPESERTA_SEP"];
		$this->PESERTANAMAJENISPESERTA_SEP->AdvancedSearch->SearchOperator = @$filter["z_PESERTANAMAJENISPESERTA_SEP"];
		$this->PESERTANAMAJENISPESERTA_SEP->AdvancedSearch->SearchCondition = @$filter["v_PESERTANAMAJENISPESERTA_SEP"];
		$this->PESERTANAMAJENISPESERTA_SEP->AdvancedSearch->SearchValue2 = @$filter["y_PESERTANAMAJENISPESERTA_SEP"];
		$this->PESERTANAMAJENISPESERTA_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_PESERTANAMAJENISPESERTA_SEP"];
		$this->PESERTANAMAJENISPESERTA_SEP->AdvancedSearch->Save();

		// Field POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->AdvancedSearch->SearchValue = @$filter["x_POLITUJUAN_SEP"];
		$this->POLITUJUAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_POLITUJUAN_SEP"];
		$this->POLITUJUAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_POLITUJUAN_SEP"];
		$this->POLITUJUAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_POLITUJUAN_SEP"];
		$this->POLITUJUAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_POLITUJUAN_SEP"];
		$this->POLITUJUAN_SEP->AdvancedSearch->Save();

		// Field NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->AdvancedSearch->SearchValue = @$filter["x_NAMAPOLITUJUAN_SEP"];
		$this->NAMAPOLITUJUAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_NAMAPOLITUJUAN_SEP"];
		$this->NAMAPOLITUJUAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_NAMAPOLITUJUAN_SEP"];
		$this->NAMAPOLITUJUAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_NAMAPOLITUJUAN_SEP"];
		$this->NAMAPOLITUJUAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_NAMAPOLITUJUAN_SEP"];
		$this->NAMAPOLITUJUAN_SEP->AdvancedSearch->Save();

		// Field KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->AdvancedSearch->SearchValue = @$filter["x_KDPPKRUJUKAN_SEP"];
		$this->KDPPKRUJUKAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_KDPPKRUJUKAN_SEP"];
		$this->KDPPKRUJUKAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_KDPPKRUJUKAN_SEP"];
		$this->KDPPKRUJUKAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_KDPPKRUJUKAN_SEP"];
		$this->KDPPKRUJUKAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_KDPPKRUJUKAN_SEP"];
		$this->KDPPKRUJUKAN_SEP->AdvancedSearch->Save();

		// Field NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->AdvancedSearch->SearchValue = @$filter["x_NMPPKRUJUKAN_SEP"];
		$this->NMPPKRUJUKAN_SEP->AdvancedSearch->SearchOperator = @$filter["z_NMPPKRUJUKAN_SEP"];
		$this->NMPPKRUJUKAN_SEP->AdvancedSearch->SearchCondition = @$filter["v_NMPPKRUJUKAN_SEP"];
		$this->NMPPKRUJUKAN_SEP->AdvancedSearch->SearchValue2 = @$filter["y_NMPPKRUJUKAN_SEP"];
		$this->NMPPKRUJUKAN_SEP->AdvancedSearch->SearchOperator2 = @$filter["w_NMPPKRUJUKAN_SEP"];
		$this->NMPPKRUJUKAN_SEP->AdvancedSearch->Save();

		// Field pasien_NOTELP
		$this->pasien_NOTELP->AdvancedSearch->SearchValue = @$filter["x_pasien_NOTELP"];
		$this->pasien_NOTELP->AdvancedSearch->SearchOperator = @$filter["z_pasien_NOTELP"];
		$this->pasien_NOTELP->AdvancedSearch->SearchCondition = @$filter["v_pasien_NOTELP"];
		$this->pasien_NOTELP->AdvancedSearch->SearchValue2 = @$filter["y_pasien_NOTELP"];
		$this->pasien_NOTELP->AdvancedSearch->SearchOperator2 = @$filter["w_pasien_NOTELP"];
		$this->pasien_NOTELP->AdvancedSearch->Save();

		// Field penjamin_kkl_id
		$this->penjamin_kkl_id->AdvancedSearch->SearchValue = @$filter["x_penjamin_kkl_id"];
		$this->penjamin_kkl_id->AdvancedSearch->SearchOperator = @$filter["z_penjamin_kkl_id"];
		$this->penjamin_kkl_id->AdvancedSearch->SearchCondition = @$filter["v_penjamin_kkl_id"];
		$this->penjamin_kkl_id->AdvancedSearch->SearchValue2 = @$filter["y_penjamin_kkl_id"];
		$this->penjamin_kkl_id->AdvancedSearch->SearchOperator2 = @$filter["w_penjamin_kkl_id"];
		$this->penjamin_kkl_id->AdvancedSearch->Save();

		// Field asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->AdvancedSearch->SearchValue = @$filter["x_asalfaskesrujukan_id"];
		$this->asalfaskesrujukan_id->AdvancedSearch->SearchOperator = @$filter["z_asalfaskesrujukan_id"];
		$this->asalfaskesrujukan_id->AdvancedSearch->SearchCondition = @$filter["v_asalfaskesrujukan_id"];
		$this->asalfaskesrujukan_id->AdvancedSearch->SearchValue2 = @$filter["y_asalfaskesrujukan_id"];
		$this->asalfaskesrujukan_id->AdvancedSearch->SearchOperator2 = @$filter["w_asalfaskesrujukan_id"];
		$this->asalfaskesrujukan_id->AdvancedSearch->Save();

		// Field peserta_cob
		$this->peserta_cob->AdvancedSearch->SearchValue = @$filter["x_peserta_cob"];
		$this->peserta_cob->AdvancedSearch->SearchOperator = @$filter["z_peserta_cob"];
		$this->peserta_cob->AdvancedSearch->SearchCondition = @$filter["v_peserta_cob"];
		$this->peserta_cob->AdvancedSearch->SearchValue2 = @$filter["y_peserta_cob"];
		$this->peserta_cob->AdvancedSearch->SearchOperator2 = @$filter["w_peserta_cob"];
		$this->peserta_cob->AdvancedSearch->Save();

		// Field poli_eksekutif
		$this->poli_eksekutif->AdvancedSearch->SearchValue = @$filter["x_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchOperator = @$filter["z_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchCondition = @$filter["v_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchValue2 = @$filter["y_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchOperator2 = @$filter["w_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->Save();

		// Field status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->AdvancedSearch->SearchValue = @$filter["x_status_kepesertaan_BPJS"];
		$this->status_kepesertaan_BPJS->AdvancedSearch->SearchOperator = @$filter["z_status_kepesertaan_BPJS"];
		$this->status_kepesertaan_BPJS->AdvancedSearch->SearchCondition = @$filter["v_status_kepesertaan_BPJS"];
		$this->status_kepesertaan_BPJS->AdvancedSearch->SearchValue2 = @$filter["y_status_kepesertaan_BPJS"];
		$this->status_kepesertaan_BPJS->AdvancedSearch->SearchOperator2 = @$filter["w_status_kepesertaan_BPJS"];
		$this->status_kepesertaan_BPJS->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NOMR, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NIP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NO_SJP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NOKARTU, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NORUJUKAN_SEP, $arKeywords, $type);
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
		$this->BuildBasicSearchSQL($sWhere, $this->pasien_NOTELP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->status_kepesertaan_BPJS, $arKeywords, $type);
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
			$this->UpdateSort($this->IDXDAFTAR, $bCtrl); // IDXDAFTAR
			$this->UpdateSort($this->NOMR, $bCtrl); // NOMR
			$this->UpdateSort($this->KDCARABAYAR, $bCtrl); // KDCARABAYAR
			$this->UpdateSort($this->NIP, $bCtrl); // NIP
			$this->UpdateSort($this->JAMREG, $bCtrl); // JAMREG
			$this->UpdateSort($this->NO_SJP, $bCtrl); // NO_SJP
			$this->UpdateSort($this->NOKARTU, $bCtrl); // NOKARTU
			$this->UpdateSort($this->USER, $bCtrl); // USER
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
				$this->IDXDAFTAR->setSort("DESC");
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
				$this->KDCARABAYAR->setSort("");
				$this->NIP->setSort("");
				$this->JAMREG->setSort("");
				$this->NO_SJP->setSort("");
				$this->NOKARTU->setSort("");
				$this->USER->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_bridging_sep_by_no_kartulistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_bridging_sep_by_no_kartulistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_bridging_sep_by_no_kartulist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fvw_bridging_sep_by_no_kartulistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->JAMREG->setDbValue($rs->fields('JAMREG'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
		$this->NOKARTU->setDbValue($rs->fields('NOKARTU'));
		$this->TANGGAL_SEP->setDbValue($rs->fields('TANGGAL_SEP'));
		$this->TANGGALRUJUK_SEP->setDbValue($rs->fields('TANGGALRUJUK_SEP'));
		$this->KELASRAWAT_SEP->setDbValue($rs->fields('KELASRAWAT_SEP'));
		$this->NORUJUKAN_SEP->setDbValue($rs->fields('NORUJUKAN_SEP'));
		$this->PPKPELAYANAN_SEP->setDbValue($rs->fields('PPKPELAYANAN_SEP'));
		$this->JENISPERAWATAN_SEP->setDbValue($rs->fields('JENISPERAWATAN_SEP'));
		$this->CATATAN_SEP->setDbValue($rs->fields('CATATAN_SEP'));
		$this->DIAGNOSAAWAL_SEP->setDbValue($rs->fields('DIAGNOSAAWAL_SEP'));
		$this->NAMADIAGNOSA_SEP->setDbValue($rs->fields('NAMADIAGNOSA_SEP'));
		$this->LAKALANTAS_SEP->setDbValue($rs->fields('LAKALANTAS_SEP'));
		$this->LOKASILAKALANTAS->setDbValue($rs->fields('LOKASILAKALANTAS'));
		$this->USER->setDbValue($rs->fields('USER'));
		$this->generate_sep->setDbValue($rs->fields('generate_sep'));
		$this->PESERTANIK_SEP->setDbValue($rs->fields('PESERTANIK_SEP'));
		$this->PESERTANAMA_SEP->setDbValue($rs->fields('PESERTANAMA_SEP'));
		$this->PESERTAJENISKELAMIN_SEP->setDbValue($rs->fields('PESERTAJENISKELAMIN_SEP'));
		$this->PESERTANAMAKELAS_SEP->setDbValue($rs->fields('PESERTANAMAKELAS_SEP'));
		$this->PESERTAPISAT->setDbValue($rs->fields('PESERTAPISAT'));
		$this->PESERTATGLLAHIR->setDbValue($rs->fields('PESERTATGLLAHIR'));
		$this->PESERTAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTAJENISPESERTA_SEP'));
		$this->PESERTANAMAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTANAMAJENISPESERTA_SEP'));
		$this->POLITUJUAN_SEP->setDbValue($rs->fields('POLITUJUAN_SEP'));
		$this->NAMAPOLITUJUAN_SEP->setDbValue($rs->fields('NAMAPOLITUJUAN_SEP'));
		$this->KDPPKRUJUKAN_SEP->setDbValue($rs->fields('KDPPKRUJUKAN_SEP'));
		$this->NMPPKRUJUKAN_SEP->setDbValue($rs->fields('NMPPKRUJUKAN_SEP'));
		$this->mapingtransaksi->setDbValue($rs->fields('mapingtransaksi'));
		$this->bridging_kepesertaan_by_no_ka->setDbValue($rs->fields('bridging_kepesertaan_by_no_ka'));
		$this->pasien_NOTELP->setDbValue($rs->fields('pasien_NOTELP'));
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
		$this->NOMR->DbValue = $row['NOMR'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NIP->DbValue = $row['NIP'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->JAMREG->DbValue = $row['JAMREG'];
		$this->NO_SJP->DbValue = $row['NO_SJP'];
		$this->NOKARTU->DbValue = $row['NOKARTU'];
		$this->TANGGAL_SEP->DbValue = $row['TANGGAL_SEP'];
		$this->TANGGALRUJUK_SEP->DbValue = $row['TANGGALRUJUK_SEP'];
		$this->KELASRAWAT_SEP->DbValue = $row['KELASRAWAT_SEP'];
		$this->NORUJUKAN_SEP->DbValue = $row['NORUJUKAN_SEP'];
		$this->PPKPELAYANAN_SEP->DbValue = $row['PPKPELAYANAN_SEP'];
		$this->JENISPERAWATAN_SEP->DbValue = $row['JENISPERAWATAN_SEP'];
		$this->CATATAN_SEP->DbValue = $row['CATATAN_SEP'];
		$this->DIAGNOSAAWAL_SEP->DbValue = $row['DIAGNOSAAWAL_SEP'];
		$this->NAMADIAGNOSA_SEP->DbValue = $row['NAMADIAGNOSA_SEP'];
		$this->LAKALANTAS_SEP->DbValue = $row['LAKALANTAS_SEP'];
		$this->LOKASILAKALANTAS->DbValue = $row['LOKASILAKALANTAS'];
		$this->USER->DbValue = $row['USER'];
		$this->generate_sep->DbValue = $row['generate_sep'];
		$this->PESERTANIK_SEP->DbValue = $row['PESERTANIK_SEP'];
		$this->PESERTANAMA_SEP->DbValue = $row['PESERTANAMA_SEP'];
		$this->PESERTAJENISKELAMIN_SEP->DbValue = $row['PESERTAJENISKELAMIN_SEP'];
		$this->PESERTANAMAKELAS_SEP->DbValue = $row['PESERTANAMAKELAS_SEP'];
		$this->PESERTAPISAT->DbValue = $row['PESERTAPISAT'];
		$this->PESERTATGLLAHIR->DbValue = $row['PESERTATGLLAHIR'];
		$this->PESERTAJENISPESERTA_SEP->DbValue = $row['PESERTAJENISPESERTA_SEP'];
		$this->PESERTANAMAJENISPESERTA_SEP->DbValue = $row['PESERTANAMAJENISPESERTA_SEP'];
		$this->POLITUJUAN_SEP->DbValue = $row['POLITUJUAN_SEP'];
		$this->NAMAPOLITUJUAN_SEP->DbValue = $row['NAMAPOLITUJUAN_SEP'];
		$this->KDPPKRUJUKAN_SEP->DbValue = $row['KDPPKRUJUKAN_SEP'];
		$this->NMPPKRUJUKAN_SEP->DbValue = $row['NMPPKRUJUKAN_SEP'];
		$this->mapingtransaksi->DbValue = $row['mapingtransaksi'];
		$this->bridging_kepesertaan_by_no_ka->DbValue = $row['bridging_kepesertaan_by_no_ka'];
		$this->pasien_NOTELP->DbValue = $row['pasien_NOTELP'];
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
		// NOMR
		// KDPOLY
		// KDCARABAYAR
		// NIP
		// TGLREG
		// JAMREG
		// NO_SJP
		// NOKARTU
		// TANGGAL_SEP
		// TANGGALRUJUK_SEP
		// KELASRAWAT_SEP
		// NORUJUKAN_SEP
		// PPKPELAYANAN_SEP
		// JENISPERAWATAN_SEP
		// CATATAN_SEP
		// DIAGNOSAAWAL_SEP
		// NAMADIAGNOSA_SEP
		// LAKALANTAS_SEP
		// LOKASILAKALANTAS
		// USER
		// generate_sep

		$this->generate_sep->CellCssStyle = "white-space: nowrap;";

		// PESERTANIK_SEP
		// PESERTANAMA_SEP
		// PESERTAJENISKELAMIN_SEP
		// PESERTANAMAKELAS_SEP
		// PESERTAPISAT
		// PESERTATGLLAHIR
		// PESERTAJENISPESERTA_SEP
		// PESERTANAMAJENISPESERTA_SEP
		// POLITUJUAN_SEP
		// NAMAPOLITUJUAN_SEP
		// KDPPKRUJUKAN_SEP
		// NMPPKRUJUKAN_SEP
		// mapingtransaksi

		$this->mapingtransaksi->CellCssStyle = "white-space: nowrap;";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->CellCssStyle = "white-space: nowrap;";

		// pasien_NOTELP
		// penjamin_kkl_id
		// asalfaskesrujukan_id
		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

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

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->ViewValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->ViewValue = ew_FormatDateTime($this->JAMREG->ViewValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->ViewValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->ViewValue = ew_FormatDateTime($this->TANGGAL_SEP->ViewValue, 5);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->ViewValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->ViewValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->ViewValue, 5);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->ViewValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->ViewValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->ViewValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		if (strval($this->JENISPERAWATAN_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`jeniskeperawatan_id`" . ew_SearchString("=", $this->JENISPERAWATAN_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `jeniskeperawatan_id`, `jeniskeperawatan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskeperawatan`";
		$sWhereWrk = "";
		$this->JENISPERAWATAN_SEP->LookupFilters = array();
		$lookuptblfilter = "`jeniskeperawatan_id`='2'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JENISPERAWATAN_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->CurrentValue;
			}
		} else {
			$this->JENISPERAWATAN_SEP->ViewValue = NULL;
		}
		$this->JENISPERAWATAN_SEP->ViewCustomAttributes = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->ViewValue = $this->CATATAN_SEP->CurrentValue;
		$this->CATATAN_SEP->ViewCustomAttributes = "";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		if (strval($this->DIAGNOSAAWAL_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`Code`" . ew_SearchString("=", $this->DIAGNOSAAWAL_SEP->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `Code`, `Code` AS `DispFld`, `Description` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `refdiagnosis`";
		$sWhereWrk = "";
		$this->DIAGNOSAAWAL_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DIAGNOSAAWAL_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
			}
		} else {
			$this->DIAGNOSAAWAL_SEP->ViewValue = NULL;
		}
		$this->DIAGNOSAAWAL_SEP->ViewCustomAttributes = "";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->ViewValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->ViewCustomAttributes = "";

		// LAKALANTAS_SEP
		if (strval($this->LAKALANTAS_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->LAKALANTAS_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_lakalantas`";
		$sWhereWrk = "";
		$this->LAKALANTAS_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->LAKALANTAS_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->CurrentValue;
			}
		} else {
			$this->LAKALANTAS_SEP->ViewValue = NULL;
		}
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->ViewValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->ViewValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->ViewValue = $this->PESERTANIK_SEP->CurrentValue;
		$this->PESERTANIK_SEP->ViewCustomAttributes = "";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->ViewValue = $this->PESERTANAMA_SEP->CurrentValue;
		$this->PESERTANAMA_SEP->ViewCustomAttributes = "";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->ViewValue = $this->PESERTAJENISKELAMIN_SEP->CurrentValue;
		$this->PESERTAJENISKELAMIN_SEP->ViewCustomAttributes = "";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->ViewValue = $this->PESERTANAMAKELAS_SEP->CurrentValue;
		$this->PESERTANAMAKELAS_SEP->ViewCustomAttributes = "";

		// PESERTAPISAT
		$this->PESERTAPISAT->ViewValue = $this->PESERTAPISAT->CurrentValue;
		$this->PESERTAPISAT->ViewCustomAttributes = "";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->ViewValue = $this->PESERTATGLLAHIR->CurrentValue;
		$this->PESERTATGLLAHIR->ViewCustomAttributes = "";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->ViewValue = $this->PESERTAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->ViewValue = $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTANAMAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// POLITUJUAN_SEP
		if (strval($this->POLITUJUAN_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`KDPOLI`" . ew_SearchString("=", $this->POLITUJUAN_SEP->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `KDPOLI`, `KDPOLI` AS `DispFld`, `NMPOLI` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `refpoli`";
		$sWhereWrk = "";
		$this->POLITUJUAN_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->POLITUJUAN_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->POLITUJUAN_SEP->ViewValue = $this->POLITUJUAN_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->POLITUJUAN_SEP->ViewValue = $this->POLITUJUAN_SEP->CurrentValue;
			}
		} else {
			$this->POLITUJUAN_SEP->ViewValue = NULL;
		}
		$this->POLITUJUAN_SEP->ViewCustomAttributes = "";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->ViewValue = $this->NAMAPOLITUJUAN_SEP->CurrentValue;
		$this->NAMAPOLITUJUAN_SEP->ViewCustomAttributes = "";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->ViewValue = $this->KDPPKRUJUKAN_SEP->CurrentValue;
		$this->KDPPKRUJUKAN_SEP->ViewCustomAttributes = "";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->ViewValue = $this->NMPPKRUJUKAN_SEP->CurrentValue;
		$this->NMPPKRUJUKAN_SEP->ViewCustomAttributes = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->ViewValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->ViewCustomAttributes = "";

		// penjamin_kkl_id
		if (strval($this->penjamin_kkl_id->CurrentValue) <> "") {
			$this->penjamin_kkl_id->ViewValue = $this->penjamin_kkl_id->OptionCaption($this->penjamin_kkl_id->CurrentValue);
		} else {
			$this->penjamin_kkl_id->ViewValue = NULL;
		}
		$this->penjamin_kkl_id->ViewCustomAttributes = "";

		// asalfaskesrujukan_id
		if (strval($this->asalfaskesrujukan_id->CurrentValue) <> "") {
			$this->asalfaskesrujukan_id->ViewValue = $this->asalfaskesrujukan_id->OptionCaption($this->asalfaskesrujukan_id->CurrentValue);
		} else {
			$this->asalfaskesrujukan_id->ViewValue = NULL;
		}
		$this->asalfaskesrujukan_id->ViewCustomAttributes = "";

		// peserta_cob
		if (strval($this->peserta_cob->CurrentValue) <> "") {
			$this->peserta_cob->ViewValue = $this->peserta_cob->OptionCaption($this->peserta_cob->CurrentValue);
		} else {
			$this->peserta_cob->ViewValue = NULL;
		}
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		if (strval($this->poli_eksekutif->CurrentValue) <> "") {
			$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->OptionCaption($this->poli_eksekutif->CurrentValue);
		} else {
			$this->poli_eksekutif->ViewValue = NULL;
		}
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->ViewValue = $this->status_kepesertaan_BPJS->CurrentValue;
		$this->status_kepesertaan_BPJS->ViewCustomAttributes = "";

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";
			$this->IDXDAFTAR->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// JAMREG
			$this->JAMREG->LinkCustomAttributes = "";
			$this->JAMREG->HrefValue = "";
			$this->JAMREG->TooltipValue = "";

			// NO_SJP
			$this->NO_SJP->LinkCustomAttributes = "";
			$this->NO_SJP->HrefValue = "";
			$this->NO_SJP->TooltipValue = "";

			// NOKARTU
			$this->NOKARTU->LinkCustomAttributes = "";
			$this->NOKARTU->HrefValue = "";
			$this->NOKARTU->TooltipValue = "";

			// USER
			$this->USER->LinkCustomAttributes = "";
			$this->USER->HrefValue = "";
			$this->USER->TooltipValue = "";
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
			$MyTimer = new cTimer;
		$GLOBALS["StartTime"] = $MyTimer->GetTime();
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

		$r = Security()->CurrentUserLevelID();
		if($r==4)
		{

			//$header = "Pasien yang di tampilkan adalah pasien rawat jalan 6 hari terakhir";
			$header = "<div class=\"alert alert-info ewAlert\">Data Pendaftaran yang ditampilkan pada Halaman ini adalah data Pendaftaran Pasien 3 hari terakhir</div>";
		}
	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

		$MyTimer = new cTimer;
		$MyTimer->EndTime = $MyTimer->GetTime();
		$footer = "<div class=\"alert alert-info ewAlert\">Kecepatan Pemrosesan Halaman: " . ($MyTimer->EndTime - $GLOBALS["StartTime"]) . " detik</div>";
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

		$this->ListOptions->Items["edit"]->Visible = FALSE;
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
if (!isset($vw_bridging_sep_by_no_kartu_list)) $vw_bridging_sep_by_no_kartu_list = new cvw_bridging_sep_by_no_kartu_list();

// Page init
$vw_bridging_sep_by_no_kartu_list->Page_Init();

// Page main
$vw_bridging_sep_by_no_kartu_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bridging_sep_by_no_kartu_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_bridging_sep_by_no_kartulist = new ew_Form("fvw_bridging_sep_by_no_kartulist", "list");
fvw_bridging_sep_by_no_kartulist.FormKeyCountName = '<?php echo $vw_bridging_sep_by_no_kartu_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvw_bridging_sep_by_no_kartulist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bridging_sep_by_no_kartulist.ValidateRequired = true;
<?php } else { ?>
fvw_bridging_sep_by_no_kartulist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bridging_sep_by_no_kartulist.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_bridging_sep_by_no_kartulist.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};

// Form object for search
var CurrentSearchForm = fvw_bridging_sep_by_no_kartulistsrch = new ew_Form("fvw_bridging_sep_by_no_kartulistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_bridging_sep_by_no_kartu_list->TotalRecs > 0 && $vw_bridging_sep_by_no_kartu_list->ExportOptions->Visible()) { ?>
<?php $vw_bridging_sep_by_no_kartu_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu_list->SearchOptions->Visible()) { ?>
<?php $vw_bridging_sep_by_no_kartu_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu_list->FilterOptions->Visible()) { ?>
<?php $vw_bridging_sep_by_no_kartu_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $vw_bridging_sep_by_no_kartu_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bridging_sep_by_no_kartu_list->TotalRecs <= 0)
			$vw_bridging_sep_by_no_kartu_list->TotalRecs = $vw_bridging_sep_by_no_kartu->SelectRecordCount();
	} else {
		if (!$vw_bridging_sep_by_no_kartu_list->Recordset && ($vw_bridging_sep_by_no_kartu_list->Recordset = $vw_bridging_sep_by_no_kartu_list->LoadRecordset()))
			$vw_bridging_sep_by_no_kartu_list->TotalRecs = $vw_bridging_sep_by_no_kartu_list->Recordset->RecordCount();
	}
	$vw_bridging_sep_by_no_kartu_list->StartRec = 1;
	if ($vw_bridging_sep_by_no_kartu_list->DisplayRecs <= 0 || ($vw_bridging_sep_by_no_kartu->Export <> "" && $vw_bridging_sep_by_no_kartu->ExportAll)) // Display all records
		$vw_bridging_sep_by_no_kartu_list->DisplayRecs = $vw_bridging_sep_by_no_kartu_list->TotalRecs;
	if (!($vw_bridging_sep_by_no_kartu->Export <> "" && $vw_bridging_sep_by_no_kartu->ExportAll))
		$vw_bridging_sep_by_no_kartu_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_bridging_sep_by_no_kartu_list->Recordset = $vw_bridging_sep_by_no_kartu_list->LoadRecordset($vw_bridging_sep_by_no_kartu_list->StartRec-1, $vw_bridging_sep_by_no_kartu_list->DisplayRecs);

	// Set no record found message
	if ($vw_bridging_sep_by_no_kartu->CurrentAction == "" && $vw_bridging_sep_by_no_kartu_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bridging_sep_by_no_kartu_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_bridging_sep_by_no_kartu_list->SearchWhere == "0=101")
			$vw_bridging_sep_by_no_kartu_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bridging_sep_by_no_kartu_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($vw_bridging_sep_by_no_kartu_list->AuditTrailOnSearch && $vw_bridging_sep_by_no_kartu_list->Command == "search" && !$vw_bridging_sep_by_no_kartu_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $vw_bridging_sep_by_no_kartu_list->getSessionWhere();
		$vw_bridging_sep_by_no_kartu_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$vw_bridging_sep_by_no_kartu_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($vw_bridging_sep_by_no_kartu->Export == "" && $vw_bridging_sep_by_no_kartu->CurrentAction == "") { ?>
<form name="fvw_bridging_sep_by_no_kartulistsrch" id="fvw_bridging_sep_by_no_kartulistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($vw_bridging_sep_by_no_kartu_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fvw_bridging_sep_by_no_kartulistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vw_bridging_sep_by_no_kartu">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($vw_bridging_sep_by_no_kartu_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $vw_bridging_sep_by_no_kartu_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($vw_bridging_sep_by_no_kartu_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($vw_bridging_sep_by_no_kartu_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($vw_bridging_sep_by_no_kartu_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($vw_bridging_sep_by_no_kartu_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $vw_bridging_sep_by_no_kartu_list->ShowPageHeader(); ?>
<?php
$vw_bridging_sep_by_no_kartu_list->ShowMessage();
?>
<?php if ($vw_bridging_sep_by_no_kartu_list->TotalRecs > 0 || $vw_bridging_sep_by_no_kartu->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bridging_sep_by_no_kartu">
<form name="fvw_bridging_sep_by_no_kartulist" id="fvw_bridging_sep_by_no_kartulist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bridging_sep_by_no_kartu_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bridging_sep_by_no_kartu_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bridging_sep_by_no_kartu">
<div id="gmp_vw_bridging_sep_by_no_kartu" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_bridging_sep_by_no_kartu_list->TotalRecs > 0 || $vw_bridging_sep_by_no_kartu->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_bridging_sep_by_no_kartulist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bridging_sep_by_no_kartu->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bridging_sep_by_no_kartu_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bridging_sep_by_no_kartu_list->RenderListOptions();

// Render list options (header, left)
$vw_bridging_sep_by_no_kartu_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_bridging_sep_by_no_kartu->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->IDXDAFTAR) == "") { ?>
		<th data-name="IDXDAFTAR"><div id="elh_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="vw_bridging_sep_by_no_kartu_IDXDAFTAR"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="IDXDAFTAR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->IDXDAFTAR) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="vw_bridging_sep_by_no_kartu_IDXDAFTAR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->IDXDAFTAR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->IDXDAFTAR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bridging_sep_by_no_kartu->NOMR->Visible) { // NOMR ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NOMR) == "") { ?>
		<th data-name="NOMR"><div id="elh_vw_bridging_sep_by_no_kartu_NOMR" class="vw_bridging_sep_by_no_kartu_NOMR"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NOMR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NOMR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NOMR) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_NOMR" class="vw_bridging_sep_by_no_kartu_NOMR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NOMR->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->NOMR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->NOMR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bridging_sep_by_no_kartu->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->KDCARABAYAR) == "") { ?>
		<th data-name="KDCARABAYAR"><div id="elh_vw_bridging_sep_by_no_kartu_KDCARABAYAR" class="vw_bridging_sep_by_no_kartu_KDCARABAYAR"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KDCARABAYAR"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->KDCARABAYAR) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_KDCARABAYAR" class="vw_bridging_sep_by_no_kartu_KDCARABAYAR">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->KDCARABAYAR->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->KDCARABAYAR->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bridging_sep_by_no_kartu->NIP->Visible) { // NIP ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NIP) == "") { ?>
		<th data-name="NIP"><div id="elh_vw_bridging_sep_by_no_kartu_NIP" class="vw_bridging_sep_by_no_kartu_NIP"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NIP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NIP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NIP) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_NIP" class="vw_bridging_sep_by_no_kartu_NIP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NIP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->NIP->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->NIP->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bridging_sep_by_no_kartu->JAMREG->Visible) { // JAMREG ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->JAMREG) == "") { ?>
		<th data-name="JAMREG"><div id="elh_vw_bridging_sep_by_no_kartu_JAMREG" class="vw_bridging_sep_by_no_kartu_JAMREG"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->JAMREG->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="JAMREG"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->JAMREG) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_JAMREG" class="vw_bridging_sep_by_no_kartu_JAMREG">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->JAMREG->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->JAMREG->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->JAMREG->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bridging_sep_by_no_kartu->NO_SJP->Visible) { // NO_SJP ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NO_SJP) == "") { ?>
		<th data-name="NO_SJP"><div id="elh_vw_bridging_sep_by_no_kartu_NO_SJP" class="vw_bridging_sep_by_no_kartu_NO_SJP"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NO_SJP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NO_SJP) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_NO_SJP" class="vw_bridging_sep_by_no_kartu_NO_SJP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->NO_SJP->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->NO_SJP->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bridging_sep_by_no_kartu->NOKARTU->Visible) { // NOKARTU ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NOKARTU) == "") { ?>
		<th data-name="NOKARTU"><div id="elh_vw_bridging_sep_by_no_kartu_NOKARTU" class="vw_bridging_sep_by_no_kartu_NOKARTU"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NOKARTU"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->NOKARTU) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_NOKARTU" class="vw_bridging_sep_by_no_kartu_NOKARTU">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->NOKARTU->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->NOKARTU->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bridging_sep_by_no_kartu->USER->Visible) { // USER ?>
	<?php if ($vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->USER) == "") { ?>
		<th data-name="USER"><div id="elh_vw_bridging_sep_by_no_kartu_USER" class="vw_bridging_sep_by_no_kartu_USER"><div class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->USER->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="USER"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bridging_sep_by_no_kartu->SortUrl($vw_bridging_sep_by_no_kartu->USER) ?>',2);"><div id="elh_vw_bridging_sep_by_no_kartu_USER" class="vw_bridging_sep_by_no_kartu_USER">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bridging_sep_by_no_kartu->USER->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bridging_sep_by_no_kartu->USER->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bridging_sep_by_no_kartu->USER->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bridging_sep_by_no_kartu_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_bridging_sep_by_no_kartu->ExportAll && $vw_bridging_sep_by_no_kartu->Export <> "") {
	$vw_bridging_sep_by_no_kartu_list->StopRec = $vw_bridging_sep_by_no_kartu_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_bridging_sep_by_no_kartu_list->TotalRecs > $vw_bridging_sep_by_no_kartu_list->StartRec + $vw_bridging_sep_by_no_kartu_list->DisplayRecs - 1)
		$vw_bridging_sep_by_no_kartu_list->StopRec = $vw_bridging_sep_by_no_kartu_list->StartRec + $vw_bridging_sep_by_no_kartu_list->DisplayRecs - 1;
	else
		$vw_bridging_sep_by_no_kartu_list->StopRec = $vw_bridging_sep_by_no_kartu_list->TotalRecs;
}
$vw_bridging_sep_by_no_kartu_list->RecCnt = $vw_bridging_sep_by_no_kartu_list->StartRec - 1;
if ($vw_bridging_sep_by_no_kartu_list->Recordset && !$vw_bridging_sep_by_no_kartu_list->Recordset->EOF) {
	$vw_bridging_sep_by_no_kartu_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_bridging_sep_by_no_kartu_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_bridging_sep_by_no_kartu_list->StartRec > 1)
		$vw_bridging_sep_by_no_kartu_list->Recordset->Move($vw_bridging_sep_by_no_kartu_list->StartRec - 1);
} elseif (!$vw_bridging_sep_by_no_kartu->AllowAddDeleteRow && $vw_bridging_sep_by_no_kartu_list->StopRec == 0) {
	$vw_bridging_sep_by_no_kartu_list->StopRec = $vw_bridging_sep_by_no_kartu->GridAddRowCount;
}

// Initialize aggregate
$vw_bridging_sep_by_no_kartu->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bridging_sep_by_no_kartu->ResetAttrs();
$vw_bridging_sep_by_no_kartu_list->RenderRow();
while ($vw_bridging_sep_by_no_kartu_list->RecCnt < $vw_bridging_sep_by_no_kartu_list->StopRec) {
	$vw_bridging_sep_by_no_kartu_list->RecCnt++;
	if (intval($vw_bridging_sep_by_no_kartu_list->RecCnt) >= intval($vw_bridging_sep_by_no_kartu_list->StartRec)) {
		$vw_bridging_sep_by_no_kartu_list->RowCnt++;

		// Set up key count
		$vw_bridging_sep_by_no_kartu_list->KeyCount = $vw_bridging_sep_by_no_kartu_list->RowIndex;

		// Init row class and style
		$vw_bridging_sep_by_no_kartu->ResetAttrs();
		$vw_bridging_sep_by_no_kartu->CssClass = "";
		if ($vw_bridging_sep_by_no_kartu->CurrentAction == "gridadd") {
		} else {
			$vw_bridging_sep_by_no_kartu_list->LoadRowValues($vw_bridging_sep_by_no_kartu_list->Recordset); // Load row values
		}
		$vw_bridging_sep_by_no_kartu->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vw_bridging_sep_by_no_kartu->RowAttrs = array_merge($vw_bridging_sep_by_no_kartu->RowAttrs, array('data-rowindex'=>$vw_bridging_sep_by_no_kartu_list->RowCnt, 'id'=>'r' . $vw_bridging_sep_by_no_kartu_list->RowCnt . '_vw_bridging_sep_by_no_kartu', 'data-rowtype'=>$vw_bridging_sep_by_no_kartu->RowType));

		// Render row
		$vw_bridging_sep_by_no_kartu_list->RenderRow();

		// Render list options
		$vw_bridging_sep_by_no_kartu_list->RenderListOptions();
?>
	<tr<?php echo $vw_bridging_sep_by_no_kartu->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bridging_sep_by_no_kartu_list->ListOptions->Render("body", "left", $vw_bridging_sep_by_no_kartu_list->RowCnt);
?>
	<?php if ($vw_bridging_sep_by_no_kartu->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
		<td data-name="IDXDAFTAR"<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->CellAttributes() ?>>
<div id="orig<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="hide">
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_IDXDAFTAR" class="vw_bridging_sep_by_no_kartu_IDXDAFTAR">
<span<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->IDXDAFTAR->ListViewValue() ?></span>
</span>
</div>
<div class="btn-group">
	<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>   Menu</button>
		<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul style="background:#605CA8" class="dropdown-menu" role="menu" >
			<li class="divider"></li>
			<li><a style="color:#ffffff" target="_self" href="vw_bridging_sep_by_no_kartuedit.php?IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) ?>"><b>-  </b><b> Pembuatan Nomer SEP </b></a></li>
			<!-- <li><a style="color:#ffffff" target="_blank" href="cetak_sep_rajal.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) ?>&&no=<?php echo urlencode(CurrentPage()->NO_SJP->CurrentValue) ?>" onclick="return confirm('Klik OK. untuk Memulai proses Brigding  Cetak  SEP.......,?')"><b>-  </b><b> Cetak SEP</b></a></li> -->
			<li><a style="color:#ffffff" target="_blank" href="cetak_vclaim_sep_rajal.php?id=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue) ?>&&no=<?php echo urlencode(CurrentPage()->NO_SJP->CurrentValue) ?>" onclick="return confirm('Klik OK. untuk Memulai proses Brigding  Cetak  SEP.......,?')"><b>-  </b><b> Cetak SEP VCLAIM</b></a></li>
			<li class="divider"></li>
		</ul>
</div>
<a id="<?php echo $vw_bridging_sep_by_no_kartu_list->PageObjName . "_row_" . $vw_bridging_sep_by_no_kartu_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vw_bridging_sep_by_no_kartu->NOMR->Visible) { // NOMR ?>
		<td data-name="NOMR"<?php echo $vw_bridging_sep_by_no_kartu->NOMR->CellAttributes() ?>>
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_NOMR" class="vw_bridging_sep_by_no_kartu_NOMR">
<span<?php echo $vw_bridging_sep_by_no_kartu->NOMR->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NOMR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bridging_sep_by_no_kartu->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<td data-name="KDCARABAYAR"<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->CellAttributes() ?>>
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_KDCARABAYAR" class="vw_bridging_sep_by_no_kartu_KDCARABAYAR">
<span<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->KDCARABAYAR->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bridging_sep_by_no_kartu->NIP->Visible) { // NIP ?>
		<td data-name="NIP"<?php echo $vw_bridging_sep_by_no_kartu->NIP->CellAttributes() ?>>
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_NIP" class="vw_bridging_sep_by_no_kartu_NIP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NIP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NIP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bridging_sep_by_no_kartu->JAMREG->Visible) { // JAMREG ?>
		<td data-name="JAMREG"<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->CellAttributes() ?>>
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_JAMREG" class="vw_bridging_sep_by_no_kartu_JAMREG">
<span<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->JAMREG->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bridging_sep_by_no_kartu->NO_SJP->Visible) { // NO_SJP ?>
		<td data-name="NO_SJP"<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->CellAttributes() ?>>
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_NO_SJP" class="vw_bridging_sep_by_no_kartu_NO_SJP">
<span<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NO_SJP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bridging_sep_by_no_kartu->NOKARTU->Visible) { // NOKARTU ?>
		<td data-name="NOKARTU"<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->CellAttributes() ?>>
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_NOKARTU" class="vw_bridging_sep_by_no_kartu_NOKARTU">
<span<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->NOKARTU->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bridging_sep_by_no_kartu->USER->Visible) { // USER ?>
		<td data-name="USER"<?php echo $vw_bridging_sep_by_no_kartu->USER->CellAttributes() ?>>
<span id="el<?php echo $vw_bridging_sep_by_no_kartu_list->RowCnt ?>_vw_bridging_sep_by_no_kartu_USER" class="vw_bridging_sep_by_no_kartu_USER">
<span<?php echo $vw_bridging_sep_by_no_kartu->USER->ViewAttributes() ?>>
<?php echo $vw_bridging_sep_by_no_kartu->USER->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bridging_sep_by_no_kartu_list->ListOptions->Render("body", "right", $vw_bridging_sep_by_no_kartu_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($vw_bridging_sep_by_no_kartu->CurrentAction <> "gridadd")
		$vw_bridging_sep_by_no_kartu_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_bridging_sep_by_no_kartu_list->Recordset)
	$vw_bridging_sep_by_no_kartu_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_bridging_sep_by_no_kartu->CurrentAction <> "gridadd" && $vw_bridging_sep_by_no_kartu->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_bridging_sep_by_no_kartu_list->Pager)) $vw_bridging_sep_by_no_kartu_list->Pager = new cPrevNextPager($vw_bridging_sep_by_no_kartu_list->StartRec, $vw_bridging_sep_by_no_kartu_list->DisplayRecs, $vw_bridging_sep_by_no_kartu_list->TotalRecs) ?>
<?php if ($vw_bridging_sep_by_no_kartu_list->Pager->RecordCount > 0 && $vw_bridging_sep_by_no_kartu_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_bridging_sep_by_no_kartu_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_bridging_sep_by_no_kartu_list->PageUrl() ?>start=<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_bridging_sep_by_no_kartu_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_bridging_sep_by_no_kartu_list->PageUrl() ?>start=<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_bridging_sep_by_no_kartu_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_bridging_sep_by_no_kartu_list->PageUrl() ?>start=<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_bridging_sep_by_no_kartu_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_bridging_sep_by_no_kartu_list->PageUrl() ?>start=<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_bridging_sep_by_no_kartu_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_bridging_sep_by_no_kartu_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_bridging_sep_by_no_kartu">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_bridging_sep_by_no_kartu_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_bridging_sep_by_no_kartu_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_bridging_sep_by_no_kartu_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_bridging_sep_by_no_kartu_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_bridging_sep_by_no_kartu_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bridging_sep_by_no_kartu_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_bridging_sep_by_no_kartu_list->TotalRecs == 0 && $vw_bridging_sep_by_no_kartu->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bridging_sep_by_no_kartu_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_bridging_sep_by_no_kartulistsrch.FilterList = <?php echo $vw_bridging_sep_by_no_kartu_list->GetFilterList() ?>;
fvw_bridging_sep_by_no_kartulistsrch.Init();
fvw_bridging_sep_by_no_kartulist.Init();
</script>
<?php
$vw_bridging_sep_by_no_kartu_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bridging_sep_by_no_kartu_list->Page_Terminate();
?>
