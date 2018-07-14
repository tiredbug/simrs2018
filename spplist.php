<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "sppinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$spp_list = NULL; // Initialize page object first

class cspp_list extends cspp {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'spp';

	// Page object name
	var $PageObjName = 'spp_list';

	// Grid form hidden field names
	var $FormName = 'fspplist';
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

		// Table object (spp)
		if (!isset($GLOBALS["spp"]) || get_class($GLOBALS["spp"]) == "cspp") {
			$GLOBALS["spp"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["spp"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "sppadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "sppdelete.php";
		$this->MultiUpdateUrl = "sppupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'spp', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fspplistsrch";

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
		$this->tgl->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->jns_spp->SetVisibility();
		$this->kd_mata->SetVisibility();
		$this->urai->SetVisibility();
		$this->jmlh->SetVisibility();
		$this->jmlh1->SetVisibility();
		$this->jmlh2->SetVisibility();
		$this->jmlh3->SetVisibility();
		$this->jmlh4->SetVisibility();
		$this->nm_perus->SetVisibility();
		$this->alamat->SetVisibility();
		$this->npwp->SetVisibility();
		$this->pimpinan->SetVisibility();
		$this->bank->SetVisibility();
		$this->rek->SetVisibility();
		$this->nospm->SetVisibility();
		$this->tglspm->SetVisibility();
		$this->ppn->SetVisibility();
		$this->ps21->SetVisibility();
		$this->ps22->SetVisibility();
		$this->ps23->SetVisibility();
		$this->ps4->SetVisibility();
		$this->kodespm->SetVisibility();
		$this->nambud->SetVisibility();
		$this->nppk->SetVisibility();
		$this->nipppk->SetVisibility();
		$this->prog->SetVisibility();
		$this->prog1->SetVisibility();
		$this->bayar->SetVisibility();

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
		global $EW_EXPORT, $spp;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($spp);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fspplistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->tgl->AdvancedSearch->ToJSON(), ","); // Field tgl
		$sFilterList = ew_Concat($sFilterList, $this->no_spp->AdvancedSearch->ToJSON(), ","); // Field no_spp
		$sFilterList = ew_Concat($sFilterList, $this->jns_spp->AdvancedSearch->ToJSON(), ","); // Field jns_spp
		$sFilterList = ew_Concat($sFilterList, $this->kd_mata->AdvancedSearch->ToJSON(), ","); // Field kd_mata
		$sFilterList = ew_Concat($sFilterList, $this->urai->AdvancedSearch->ToJSON(), ","); // Field urai
		$sFilterList = ew_Concat($sFilterList, $this->jmlh->AdvancedSearch->ToJSON(), ","); // Field jmlh
		$sFilterList = ew_Concat($sFilterList, $this->jmlh1->AdvancedSearch->ToJSON(), ","); // Field jmlh1
		$sFilterList = ew_Concat($sFilterList, $this->jmlh2->AdvancedSearch->ToJSON(), ","); // Field jmlh2
		$sFilterList = ew_Concat($sFilterList, $this->jmlh3->AdvancedSearch->ToJSON(), ","); // Field jmlh3
		$sFilterList = ew_Concat($sFilterList, $this->jmlh4->AdvancedSearch->ToJSON(), ","); // Field jmlh4
		$sFilterList = ew_Concat($sFilterList, $this->nm_perus->AdvancedSearch->ToJSON(), ","); // Field nm_perus
		$sFilterList = ew_Concat($sFilterList, $this->alamat->AdvancedSearch->ToJSON(), ","); // Field alamat
		$sFilterList = ew_Concat($sFilterList, $this->npwp->AdvancedSearch->ToJSON(), ","); // Field npwp
		$sFilterList = ew_Concat($sFilterList, $this->pimpinan->AdvancedSearch->ToJSON(), ","); // Field pimpinan
		$sFilterList = ew_Concat($sFilterList, $this->bank->AdvancedSearch->ToJSON(), ","); // Field bank
		$sFilterList = ew_Concat($sFilterList, $this->rek->AdvancedSearch->ToJSON(), ","); // Field rek
		$sFilterList = ew_Concat($sFilterList, $this->nospm->AdvancedSearch->ToJSON(), ","); // Field nospm
		$sFilterList = ew_Concat($sFilterList, $this->tglspm->AdvancedSearch->ToJSON(), ","); // Field tglspm
		$sFilterList = ew_Concat($sFilterList, $this->ppn->AdvancedSearch->ToJSON(), ","); // Field ppn
		$sFilterList = ew_Concat($sFilterList, $this->ps21->AdvancedSearch->ToJSON(), ","); // Field ps21
		$sFilterList = ew_Concat($sFilterList, $this->ps22->AdvancedSearch->ToJSON(), ","); // Field ps22
		$sFilterList = ew_Concat($sFilterList, $this->ps23->AdvancedSearch->ToJSON(), ","); // Field ps23
		$sFilterList = ew_Concat($sFilterList, $this->ps4->AdvancedSearch->ToJSON(), ","); // Field ps4
		$sFilterList = ew_Concat($sFilterList, $this->kodespm->AdvancedSearch->ToJSON(), ","); // Field kodespm
		$sFilterList = ew_Concat($sFilterList, $this->nambud->AdvancedSearch->ToJSON(), ","); // Field nambud
		$sFilterList = ew_Concat($sFilterList, $this->nppk->AdvancedSearch->ToJSON(), ","); // Field nppk
		$sFilterList = ew_Concat($sFilterList, $this->nipppk->AdvancedSearch->ToJSON(), ","); // Field nipppk
		$sFilterList = ew_Concat($sFilterList, $this->prog->AdvancedSearch->ToJSON(), ","); // Field prog
		$sFilterList = ew_Concat($sFilterList, $this->prog1->AdvancedSearch->ToJSON(), ","); // Field prog1
		$sFilterList = ew_Concat($sFilterList, $this->bayar->AdvancedSearch->ToJSON(), ","); // Field bayar
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fspplistsrch", $filters);

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

		// Field tgl
		$this->tgl->AdvancedSearch->SearchValue = @$filter["x_tgl"];
		$this->tgl->AdvancedSearch->SearchOperator = @$filter["z_tgl"];
		$this->tgl->AdvancedSearch->SearchCondition = @$filter["v_tgl"];
		$this->tgl->AdvancedSearch->SearchValue2 = @$filter["y_tgl"];
		$this->tgl->AdvancedSearch->SearchOperator2 = @$filter["w_tgl"];
		$this->tgl->AdvancedSearch->Save();

		// Field no_spp
		$this->no_spp->AdvancedSearch->SearchValue = @$filter["x_no_spp"];
		$this->no_spp->AdvancedSearch->SearchOperator = @$filter["z_no_spp"];
		$this->no_spp->AdvancedSearch->SearchCondition = @$filter["v_no_spp"];
		$this->no_spp->AdvancedSearch->SearchValue2 = @$filter["y_no_spp"];
		$this->no_spp->AdvancedSearch->SearchOperator2 = @$filter["w_no_spp"];
		$this->no_spp->AdvancedSearch->Save();

		// Field jns_spp
		$this->jns_spp->AdvancedSearch->SearchValue = @$filter["x_jns_spp"];
		$this->jns_spp->AdvancedSearch->SearchOperator = @$filter["z_jns_spp"];
		$this->jns_spp->AdvancedSearch->SearchCondition = @$filter["v_jns_spp"];
		$this->jns_spp->AdvancedSearch->SearchValue2 = @$filter["y_jns_spp"];
		$this->jns_spp->AdvancedSearch->SearchOperator2 = @$filter["w_jns_spp"];
		$this->jns_spp->AdvancedSearch->Save();

		// Field kd_mata
		$this->kd_mata->AdvancedSearch->SearchValue = @$filter["x_kd_mata"];
		$this->kd_mata->AdvancedSearch->SearchOperator = @$filter["z_kd_mata"];
		$this->kd_mata->AdvancedSearch->SearchCondition = @$filter["v_kd_mata"];
		$this->kd_mata->AdvancedSearch->SearchValue2 = @$filter["y_kd_mata"];
		$this->kd_mata->AdvancedSearch->SearchOperator2 = @$filter["w_kd_mata"];
		$this->kd_mata->AdvancedSearch->Save();

		// Field urai
		$this->urai->AdvancedSearch->SearchValue = @$filter["x_urai"];
		$this->urai->AdvancedSearch->SearchOperator = @$filter["z_urai"];
		$this->urai->AdvancedSearch->SearchCondition = @$filter["v_urai"];
		$this->urai->AdvancedSearch->SearchValue2 = @$filter["y_urai"];
		$this->urai->AdvancedSearch->SearchOperator2 = @$filter["w_urai"];
		$this->urai->AdvancedSearch->Save();

		// Field jmlh
		$this->jmlh->AdvancedSearch->SearchValue = @$filter["x_jmlh"];
		$this->jmlh->AdvancedSearch->SearchOperator = @$filter["z_jmlh"];
		$this->jmlh->AdvancedSearch->SearchCondition = @$filter["v_jmlh"];
		$this->jmlh->AdvancedSearch->SearchValue2 = @$filter["y_jmlh"];
		$this->jmlh->AdvancedSearch->SearchOperator2 = @$filter["w_jmlh"];
		$this->jmlh->AdvancedSearch->Save();

		// Field jmlh1
		$this->jmlh1->AdvancedSearch->SearchValue = @$filter["x_jmlh1"];
		$this->jmlh1->AdvancedSearch->SearchOperator = @$filter["z_jmlh1"];
		$this->jmlh1->AdvancedSearch->SearchCondition = @$filter["v_jmlh1"];
		$this->jmlh1->AdvancedSearch->SearchValue2 = @$filter["y_jmlh1"];
		$this->jmlh1->AdvancedSearch->SearchOperator2 = @$filter["w_jmlh1"];
		$this->jmlh1->AdvancedSearch->Save();

		// Field jmlh2
		$this->jmlh2->AdvancedSearch->SearchValue = @$filter["x_jmlh2"];
		$this->jmlh2->AdvancedSearch->SearchOperator = @$filter["z_jmlh2"];
		$this->jmlh2->AdvancedSearch->SearchCondition = @$filter["v_jmlh2"];
		$this->jmlh2->AdvancedSearch->SearchValue2 = @$filter["y_jmlh2"];
		$this->jmlh2->AdvancedSearch->SearchOperator2 = @$filter["w_jmlh2"];
		$this->jmlh2->AdvancedSearch->Save();

		// Field jmlh3
		$this->jmlh3->AdvancedSearch->SearchValue = @$filter["x_jmlh3"];
		$this->jmlh3->AdvancedSearch->SearchOperator = @$filter["z_jmlh3"];
		$this->jmlh3->AdvancedSearch->SearchCondition = @$filter["v_jmlh3"];
		$this->jmlh3->AdvancedSearch->SearchValue2 = @$filter["y_jmlh3"];
		$this->jmlh3->AdvancedSearch->SearchOperator2 = @$filter["w_jmlh3"];
		$this->jmlh3->AdvancedSearch->Save();

		// Field jmlh4
		$this->jmlh4->AdvancedSearch->SearchValue = @$filter["x_jmlh4"];
		$this->jmlh4->AdvancedSearch->SearchOperator = @$filter["z_jmlh4"];
		$this->jmlh4->AdvancedSearch->SearchCondition = @$filter["v_jmlh4"];
		$this->jmlh4->AdvancedSearch->SearchValue2 = @$filter["y_jmlh4"];
		$this->jmlh4->AdvancedSearch->SearchOperator2 = @$filter["w_jmlh4"];
		$this->jmlh4->AdvancedSearch->Save();

		// Field nm_perus
		$this->nm_perus->AdvancedSearch->SearchValue = @$filter["x_nm_perus"];
		$this->nm_perus->AdvancedSearch->SearchOperator = @$filter["z_nm_perus"];
		$this->nm_perus->AdvancedSearch->SearchCondition = @$filter["v_nm_perus"];
		$this->nm_perus->AdvancedSearch->SearchValue2 = @$filter["y_nm_perus"];
		$this->nm_perus->AdvancedSearch->SearchOperator2 = @$filter["w_nm_perus"];
		$this->nm_perus->AdvancedSearch->Save();

		// Field alamat
		$this->alamat->AdvancedSearch->SearchValue = @$filter["x_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator = @$filter["z_alamat"];
		$this->alamat->AdvancedSearch->SearchCondition = @$filter["v_alamat"];
		$this->alamat->AdvancedSearch->SearchValue2 = @$filter["y_alamat"];
		$this->alamat->AdvancedSearch->SearchOperator2 = @$filter["w_alamat"];
		$this->alamat->AdvancedSearch->Save();

		// Field npwp
		$this->npwp->AdvancedSearch->SearchValue = @$filter["x_npwp"];
		$this->npwp->AdvancedSearch->SearchOperator = @$filter["z_npwp"];
		$this->npwp->AdvancedSearch->SearchCondition = @$filter["v_npwp"];
		$this->npwp->AdvancedSearch->SearchValue2 = @$filter["y_npwp"];
		$this->npwp->AdvancedSearch->SearchOperator2 = @$filter["w_npwp"];
		$this->npwp->AdvancedSearch->Save();

		// Field pimpinan
		$this->pimpinan->AdvancedSearch->SearchValue = @$filter["x_pimpinan"];
		$this->pimpinan->AdvancedSearch->SearchOperator = @$filter["z_pimpinan"];
		$this->pimpinan->AdvancedSearch->SearchCondition = @$filter["v_pimpinan"];
		$this->pimpinan->AdvancedSearch->SearchValue2 = @$filter["y_pimpinan"];
		$this->pimpinan->AdvancedSearch->SearchOperator2 = @$filter["w_pimpinan"];
		$this->pimpinan->AdvancedSearch->Save();

		// Field bank
		$this->bank->AdvancedSearch->SearchValue = @$filter["x_bank"];
		$this->bank->AdvancedSearch->SearchOperator = @$filter["z_bank"];
		$this->bank->AdvancedSearch->SearchCondition = @$filter["v_bank"];
		$this->bank->AdvancedSearch->SearchValue2 = @$filter["y_bank"];
		$this->bank->AdvancedSearch->SearchOperator2 = @$filter["w_bank"];
		$this->bank->AdvancedSearch->Save();

		// Field rek
		$this->rek->AdvancedSearch->SearchValue = @$filter["x_rek"];
		$this->rek->AdvancedSearch->SearchOperator = @$filter["z_rek"];
		$this->rek->AdvancedSearch->SearchCondition = @$filter["v_rek"];
		$this->rek->AdvancedSearch->SearchValue2 = @$filter["y_rek"];
		$this->rek->AdvancedSearch->SearchOperator2 = @$filter["w_rek"];
		$this->rek->AdvancedSearch->Save();

		// Field nospm
		$this->nospm->AdvancedSearch->SearchValue = @$filter["x_nospm"];
		$this->nospm->AdvancedSearch->SearchOperator = @$filter["z_nospm"];
		$this->nospm->AdvancedSearch->SearchCondition = @$filter["v_nospm"];
		$this->nospm->AdvancedSearch->SearchValue2 = @$filter["y_nospm"];
		$this->nospm->AdvancedSearch->SearchOperator2 = @$filter["w_nospm"];
		$this->nospm->AdvancedSearch->Save();

		// Field tglspm
		$this->tglspm->AdvancedSearch->SearchValue = @$filter["x_tglspm"];
		$this->tglspm->AdvancedSearch->SearchOperator = @$filter["z_tglspm"];
		$this->tglspm->AdvancedSearch->SearchCondition = @$filter["v_tglspm"];
		$this->tglspm->AdvancedSearch->SearchValue2 = @$filter["y_tglspm"];
		$this->tglspm->AdvancedSearch->SearchOperator2 = @$filter["w_tglspm"];
		$this->tglspm->AdvancedSearch->Save();

		// Field ppn
		$this->ppn->AdvancedSearch->SearchValue = @$filter["x_ppn"];
		$this->ppn->AdvancedSearch->SearchOperator = @$filter["z_ppn"];
		$this->ppn->AdvancedSearch->SearchCondition = @$filter["v_ppn"];
		$this->ppn->AdvancedSearch->SearchValue2 = @$filter["y_ppn"];
		$this->ppn->AdvancedSearch->SearchOperator2 = @$filter["w_ppn"];
		$this->ppn->AdvancedSearch->Save();

		// Field ps21
		$this->ps21->AdvancedSearch->SearchValue = @$filter["x_ps21"];
		$this->ps21->AdvancedSearch->SearchOperator = @$filter["z_ps21"];
		$this->ps21->AdvancedSearch->SearchCondition = @$filter["v_ps21"];
		$this->ps21->AdvancedSearch->SearchValue2 = @$filter["y_ps21"];
		$this->ps21->AdvancedSearch->SearchOperator2 = @$filter["w_ps21"];
		$this->ps21->AdvancedSearch->Save();

		// Field ps22
		$this->ps22->AdvancedSearch->SearchValue = @$filter["x_ps22"];
		$this->ps22->AdvancedSearch->SearchOperator = @$filter["z_ps22"];
		$this->ps22->AdvancedSearch->SearchCondition = @$filter["v_ps22"];
		$this->ps22->AdvancedSearch->SearchValue2 = @$filter["y_ps22"];
		$this->ps22->AdvancedSearch->SearchOperator2 = @$filter["w_ps22"];
		$this->ps22->AdvancedSearch->Save();

		// Field ps23
		$this->ps23->AdvancedSearch->SearchValue = @$filter["x_ps23"];
		$this->ps23->AdvancedSearch->SearchOperator = @$filter["z_ps23"];
		$this->ps23->AdvancedSearch->SearchCondition = @$filter["v_ps23"];
		$this->ps23->AdvancedSearch->SearchValue2 = @$filter["y_ps23"];
		$this->ps23->AdvancedSearch->SearchOperator2 = @$filter["w_ps23"];
		$this->ps23->AdvancedSearch->Save();

		// Field ps4
		$this->ps4->AdvancedSearch->SearchValue = @$filter["x_ps4"];
		$this->ps4->AdvancedSearch->SearchOperator = @$filter["z_ps4"];
		$this->ps4->AdvancedSearch->SearchCondition = @$filter["v_ps4"];
		$this->ps4->AdvancedSearch->SearchValue2 = @$filter["y_ps4"];
		$this->ps4->AdvancedSearch->SearchOperator2 = @$filter["w_ps4"];
		$this->ps4->AdvancedSearch->Save();

		// Field kodespm
		$this->kodespm->AdvancedSearch->SearchValue = @$filter["x_kodespm"];
		$this->kodespm->AdvancedSearch->SearchOperator = @$filter["z_kodespm"];
		$this->kodespm->AdvancedSearch->SearchCondition = @$filter["v_kodespm"];
		$this->kodespm->AdvancedSearch->SearchValue2 = @$filter["y_kodespm"];
		$this->kodespm->AdvancedSearch->SearchOperator2 = @$filter["w_kodespm"];
		$this->kodespm->AdvancedSearch->Save();

		// Field nambud
		$this->nambud->AdvancedSearch->SearchValue = @$filter["x_nambud"];
		$this->nambud->AdvancedSearch->SearchOperator = @$filter["z_nambud"];
		$this->nambud->AdvancedSearch->SearchCondition = @$filter["v_nambud"];
		$this->nambud->AdvancedSearch->SearchValue2 = @$filter["y_nambud"];
		$this->nambud->AdvancedSearch->SearchOperator2 = @$filter["w_nambud"];
		$this->nambud->AdvancedSearch->Save();

		// Field nppk
		$this->nppk->AdvancedSearch->SearchValue = @$filter["x_nppk"];
		$this->nppk->AdvancedSearch->SearchOperator = @$filter["z_nppk"];
		$this->nppk->AdvancedSearch->SearchCondition = @$filter["v_nppk"];
		$this->nppk->AdvancedSearch->SearchValue2 = @$filter["y_nppk"];
		$this->nppk->AdvancedSearch->SearchOperator2 = @$filter["w_nppk"];
		$this->nppk->AdvancedSearch->Save();

		// Field nipppk
		$this->nipppk->AdvancedSearch->SearchValue = @$filter["x_nipppk"];
		$this->nipppk->AdvancedSearch->SearchOperator = @$filter["z_nipppk"];
		$this->nipppk->AdvancedSearch->SearchCondition = @$filter["v_nipppk"];
		$this->nipppk->AdvancedSearch->SearchValue2 = @$filter["y_nipppk"];
		$this->nipppk->AdvancedSearch->SearchOperator2 = @$filter["w_nipppk"];
		$this->nipppk->AdvancedSearch->Save();

		// Field prog
		$this->prog->AdvancedSearch->SearchValue = @$filter["x_prog"];
		$this->prog->AdvancedSearch->SearchOperator = @$filter["z_prog"];
		$this->prog->AdvancedSearch->SearchCondition = @$filter["v_prog"];
		$this->prog->AdvancedSearch->SearchValue2 = @$filter["y_prog"];
		$this->prog->AdvancedSearch->SearchOperator2 = @$filter["w_prog"];
		$this->prog->AdvancedSearch->Save();

		// Field prog1
		$this->prog1->AdvancedSearch->SearchValue = @$filter["x_prog1"];
		$this->prog1->AdvancedSearch->SearchOperator = @$filter["z_prog1"];
		$this->prog1->AdvancedSearch->SearchCondition = @$filter["v_prog1"];
		$this->prog1->AdvancedSearch->SearchValue2 = @$filter["y_prog1"];
		$this->prog1->AdvancedSearch->SearchOperator2 = @$filter["w_prog1"];
		$this->prog1->AdvancedSearch->Save();

		// Field bayar
		$this->bayar->AdvancedSearch->SearchValue = @$filter["x_bayar"];
		$this->bayar->AdvancedSearch->SearchOperator = @$filter["z_bayar"];
		$this->bayar->AdvancedSearch->SearchCondition = @$filter["v_bayar"];
		$this->bayar->AdvancedSearch->SearchValue2 = @$filter["y_bayar"];
		$this->bayar->AdvancedSearch->SearchOperator2 = @$filter["w_bayar"];
		$this->bayar->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->no_spp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jns_spp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kd_mata, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->urai, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nm_perus, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->npwp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pimpinan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bank, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->rek, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nospm, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kodespm, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nambud, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nppk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nipppk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->prog, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->prog1, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bayar, $arKeywords, $type);
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
			$this->UpdateSort($this->tgl, $bCtrl); // tgl
			$this->UpdateSort($this->no_spp, $bCtrl); // no_spp
			$this->UpdateSort($this->jns_spp, $bCtrl); // jns_spp
			$this->UpdateSort($this->kd_mata, $bCtrl); // kd_mata
			$this->UpdateSort($this->urai, $bCtrl); // urai
			$this->UpdateSort($this->jmlh, $bCtrl); // jmlh
			$this->UpdateSort($this->jmlh1, $bCtrl); // jmlh1
			$this->UpdateSort($this->jmlh2, $bCtrl); // jmlh2
			$this->UpdateSort($this->jmlh3, $bCtrl); // jmlh3
			$this->UpdateSort($this->jmlh4, $bCtrl); // jmlh4
			$this->UpdateSort($this->nm_perus, $bCtrl); // nm_perus
			$this->UpdateSort($this->alamat, $bCtrl); // alamat
			$this->UpdateSort($this->npwp, $bCtrl); // npwp
			$this->UpdateSort($this->pimpinan, $bCtrl); // pimpinan
			$this->UpdateSort($this->bank, $bCtrl); // bank
			$this->UpdateSort($this->rek, $bCtrl); // rek
			$this->UpdateSort($this->nospm, $bCtrl); // nospm
			$this->UpdateSort($this->tglspm, $bCtrl); // tglspm
			$this->UpdateSort($this->ppn, $bCtrl); // ppn
			$this->UpdateSort($this->ps21, $bCtrl); // ps21
			$this->UpdateSort($this->ps22, $bCtrl); // ps22
			$this->UpdateSort($this->ps23, $bCtrl); // ps23
			$this->UpdateSort($this->ps4, $bCtrl); // ps4
			$this->UpdateSort($this->kodespm, $bCtrl); // kodespm
			$this->UpdateSort($this->nambud, $bCtrl); // nambud
			$this->UpdateSort($this->nppk, $bCtrl); // nppk
			$this->UpdateSort($this->nipppk, $bCtrl); // nipppk
			$this->UpdateSort($this->prog, $bCtrl); // prog
			$this->UpdateSort($this->prog1, $bCtrl); // prog1
			$this->UpdateSort($this->bayar, $bCtrl); // bayar
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
				$this->tgl->setSort("");
				$this->no_spp->setSort("");
				$this->jns_spp->setSort("");
				$this->kd_mata->setSort("");
				$this->urai->setSort("");
				$this->jmlh->setSort("");
				$this->jmlh1->setSort("");
				$this->jmlh2->setSort("");
				$this->jmlh3->setSort("");
				$this->jmlh4->setSort("");
				$this->nm_perus->setSort("");
				$this->alamat->setSort("");
				$this->npwp->setSort("");
				$this->pimpinan->setSort("");
				$this->bank->setSort("");
				$this->rek->setSort("");
				$this->nospm->setSort("");
				$this->tglspm->setSort("");
				$this->ppn->setSort("");
				$this->ps21->setSort("");
				$this->ps22->setSort("");
				$this->ps23->setSort("");
				$this->ps4->setSort("");
				$this->kodespm->setSort("");
				$this->nambud->setSort("");
				$this->nppk->setSort("");
				$this->nipppk->setSort("");
				$this->prog->setSort("");
				$this->prog1->setSort("");
				$this->bayar->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fspplistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fspplistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fspplist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fspplistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->tgl->setDbValue($rs->fields('tgl'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->jns_spp->setDbValue($rs->fields('jns_spp'));
		$this->kd_mata->setDbValue($rs->fields('kd_mata'));
		$this->urai->setDbValue($rs->fields('urai'));
		$this->jmlh->setDbValue($rs->fields('jmlh'));
		$this->jmlh1->setDbValue($rs->fields('jmlh1'));
		$this->jmlh2->setDbValue($rs->fields('jmlh2'));
		$this->jmlh3->setDbValue($rs->fields('jmlh3'));
		$this->jmlh4->setDbValue($rs->fields('jmlh4'));
		$this->nm_perus->setDbValue($rs->fields('nm_perus'));
		$this->alamat->setDbValue($rs->fields('alamat'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->pimpinan->setDbValue($rs->fields('pimpinan'));
		$this->bank->setDbValue($rs->fields('bank'));
		$this->rek->setDbValue($rs->fields('rek'));
		$this->nospm->setDbValue($rs->fields('nospm'));
		$this->tglspm->setDbValue($rs->fields('tglspm'));
		$this->ppn->setDbValue($rs->fields('ppn'));
		$this->ps21->setDbValue($rs->fields('ps21'));
		$this->ps22->setDbValue($rs->fields('ps22'));
		$this->ps23->setDbValue($rs->fields('ps23'));
		$this->ps4->setDbValue($rs->fields('ps4'));
		$this->kodespm->setDbValue($rs->fields('kodespm'));
		$this->nambud->setDbValue($rs->fields('nambud'));
		$this->nppk->setDbValue($rs->fields('nppk'));
		$this->nipppk->setDbValue($rs->fields('nipppk'));
		$this->prog->setDbValue($rs->fields('prog'));
		$this->prog1->setDbValue($rs->fields('prog1'));
		$this->bayar->setDbValue($rs->fields('bayar'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->tgl->DbValue = $row['tgl'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->jns_spp->DbValue = $row['jns_spp'];
		$this->kd_mata->DbValue = $row['kd_mata'];
		$this->urai->DbValue = $row['urai'];
		$this->jmlh->DbValue = $row['jmlh'];
		$this->jmlh1->DbValue = $row['jmlh1'];
		$this->jmlh2->DbValue = $row['jmlh2'];
		$this->jmlh3->DbValue = $row['jmlh3'];
		$this->jmlh4->DbValue = $row['jmlh4'];
		$this->nm_perus->DbValue = $row['nm_perus'];
		$this->alamat->DbValue = $row['alamat'];
		$this->npwp->DbValue = $row['npwp'];
		$this->pimpinan->DbValue = $row['pimpinan'];
		$this->bank->DbValue = $row['bank'];
		$this->rek->DbValue = $row['rek'];
		$this->nospm->DbValue = $row['nospm'];
		$this->tglspm->DbValue = $row['tglspm'];
		$this->ppn->DbValue = $row['ppn'];
		$this->ps21->DbValue = $row['ps21'];
		$this->ps22->DbValue = $row['ps22'];
		$this->ps23->DbValue = $row['ps23'];
		$this->ps4->DbValue = $row['ps4'];
		$this->kodespm->DbValue = $row['kodespm'];
		$this->nambud->DbValue = $row['nambud'];
		$this->nppk->DbValue = $row['nppk'];
		$this->nipppk->DbValue = $row['nipppk'];
		$this->prog->DbValue = $row['prog'];
		$this->prog1->DbValue = $row['prog1'];
		$this->bayar->DbValue = $row['bayar'];
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
		// tgl
		// no_spp
		// jns_spp
		// kd_mata
		// urai
		// jmlh
		// jmlh1
		// jmlh2
		// jmlh3
		// jmlh4
		// nm_perus
		// alamat
		// npwp
		// pimpinan
		// bank
		// rek
		// nospm
		// tglspm
		// ppn
		// ps21
		// ps22
		// ps23
		// ps4
		// kodespm
		// nambud
		// nppk
		// nipppk
		// prog
		// prog1
		// bayar

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// tgl
		$this->tgl->ViewValue = $this->tgl->CurrentValue;
		$this->tgl->ViewValue = ew_FormatDateTime($this->tgl->ViewValue, 0);
		$this->tgl->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// jns_spp
		$this->jns_spp->ViewValue = $this->jns_spp->CurrentValue;
		$this->jns_spp->ViewCustomAttributes = "";

		// kd_mata
		$this->kd_mata->ViewValue = $this->kd_mata->CurrentValue;
		$this->kd_mata->ViewCustomAttributes = "";

		// urai
		$this->urai->ViewValue = $this->urai->CurrentValue;
		$this->urai->ViewCustomAttributes = "";

		// jmlh
		$this->jmlh->ViewValue = $this->jmlh->CurrentValue;
		$this->jmlh->ViewCustomAttributes = "";

		// jmlh1
		$this->jmlh1->ViewValue = $this->jmlh1->CurrentValue;
		$this->jmlh1->ViewCustomAttributes = "";

		// jmlh2
		$this->jmlh2->ViewValue = $this->jmlh2->CurrentValue;
		$this->jmlh2->ViewCustomAttributes = "";

		// jmlh3
		$this->jmlh3->ViewValue = $this->jmlh3->CurrentValue;
		$this->jmlh3->ViewCustomAttributes = "";

		// jmlh4
		$this->jmlh4->ViewValue = $this->jmlh4->CurrentValue;
		$this->jmlh4->ViewCustomAttributes = "";

		// nm_perus
		$this->nm_perus->ViewValue = $this->nm_perus->CurrentValue;
		$this->nm_perus->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// pimpinan
		$this->pimpinan->ViewValue = $this->pimpinan->CurrentValue;
		$this->pimpinan->ViewCustomAttributes = "";

		// bank
		$this->bank->ViewValue = $this->bank->CurrentValue;
		$this->bank->ViewCustomAttributes = "";

		// rek
		$this->rek->ViewValue = $this->rek->CurrentValue;
		$this->rek->ViewCustomAttributes = "";

		// nospm
		$this->nospm->ViewValue = $this->nospm->CurrentValue;
		$this->nospm->ViewCustomAttributes = "";

		// tglspm
		$this->tglspm->ViewValue = $this->tglspm->CurrentValue;
		$this->tglspm->ViewValue = ew_FormatDateTime($this->tglspm->ViewValue, 0);
		$this->tglspm->ViewCustomAttributes = "";

		// ppn
		$this->ppn->ViewValue = $this->ppn->CurrentValue;
		$this->ppn->ViewCustomAttributes = "";

		// ps21
		$this->ps21->ViewValue = $this->ps21->CurrentValue;
		$this->ps21->ViewCustomAttributes = "";

		// ps22
		$this->ps22->ViewValue = $this->ps22->CurrentValue;
		$this->ps22->ViewCustomAttributes = "";

		// ps23
		$this->ps23->ViewValue = $this->ps23->CurrentValue;
		$this->ps23->ViewCustomAttributes = "";

		// ps4
		$this->ps4->ViewValue = $this->ps4->CurrentValue;
		$this->ps4->ViewCustomAttributes = "";

		// kodespm
		$this->kodespm->ViewValue = $this->kodespm->CurrentValue;
		$this->kodespm->ViewCustomAttributes = "";

		// nambud
		$this->nambud->ViewValue = $this->nambud->CurrentValue;
		$this->nambud->ViewCustomAttributes = "";

		// nppk
		$this->nppk->ViewValue = $this->nppk->CurrentValue;
		$this->nppk->ViewCustomAttributes = "";

		// nipppk
		$this->nipppk->ViewValue = $this->nipppk->CurrentValue;
		$this->nipppk->ViewCustomAttributes = "";

		// prog
		$this->prog->ViewValue = $this->prog->CurrentValue;
		$this->prog->ViewCustomAttributes = "";

		// prog1
		$this->prog1->ViewValue = $this->prog1->CurrentValue;
		$this->prog1->ViewCustomAttributes = "";

		// bayar
		$this->bayar->ViewValue = $this->bayar->CurrentValue;
		$this->bayar->ViewCustomAttributes = "";

			// tgl
			$this->tgl->LinkCustomAttributes = "";
			$this->tgl->HrefValue = "";
			$this->tgl->TooltipValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";
			$this->no_spp->TooltipValue = "";

			// jns_spp
			$this->jns_spp->LinkCustomAttributes = "";
			$this->jns_spp->HrefValue = "";
			$this->jns_spp->TooltipValue = "";

			// kd_mata
			$this->kd_mata->LinkCustomAttributes = "";
			$this->kd_mata->HrefValue = "";
			$this->kd_mata->TooltipValue = "";

			// urai
			$this->urai->LinkCustomAttributes = "";
			$this->urai->HrefValue = "";
			$this->urai->TooltipValue = "";

			// jmlh
			$this->jmlh->LinkCustomAttributes = "";
			$this->jmlh->HrefValue = "";
			$this->jmlh->TooltipValue = "";

			// jmlh1
			$this->jmlh1->LinkCustomAttributes = "";
			$this->jmlh1->HrefValue = "";
			$this->jmlh1->TooltipValue = "";

			// jmlh2
			$this->jmlh2->LinkCustomAttributes = "";
			$this->jmlh2->HrefValue = "";
			$this->jmlh2->TooltipValue = "";

			// jmlh3
			$this->jmlh3->LinkCustomAttributes = "";
			$this->jmlh3->HrefValue = "";
			$this->jmlh3->TooltipValue = "";

			// jmlh4
			$this->jmlh4->LinkCustomAttributes = "";
			$this->jmlh4->HrefValue = "";
			$this->jmlh4->TooltipValue = "";

			// nm_perus
			$this->nm_perus->LinkCustomAttributes = "";
			$this->nm_perus->HrefValue = "";
			$this->nm_perus->TooltipValue = "";

			// alamat
			$this->alamat->LinkCustomAttributes = "";
			$this->alamat->HrefValue = "";
			$this->alamat->TooltipValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";
			$this->npwp->TooltipValue = "";

			// pimpinan
			$this->pimpinan->LinkCustomAttributes = "";
			$this->pimpinan->HrefValue = "";
			$this->pimpinan->TooltipValue = "";

			// bank
			$this->bank->LinkCustomAttributes = "";
			$this->bank->HrefValue = "";
			$this->bank->TooltipValue = "";

			// rek
			$this->rek->LinkCustomAttributes = "";
			$this->rek->HrefValue = "";
			$this->rek->TooltipValue = "";

			// nospm
			$this->nospm->LinkCustomAttributes = "";
			$this->nospm->HrefValue = "";
			$this->nospm->TooltipValue = "";

			// tglspm
			$this->tglspm->LinkCustomAttributes = "";
			$this->tglspm->HrefValue = "";
			$this->tglspm->TooltipValue = "";

			// ppn
			$this->ppn->LinkCustomAttributes = "";
			$this->ppn->HrefValue = "";
			$this->ppn->TooltipValue = "";

			// ps21
			$this->ps21->LinkCustomAttributes = "";
			$this->ps21->HrefValue = "";
			$this->ps21->TooltipValue = "";

			// ps22
			$this->ps22->LinkCustomAttributes = "";
			$this->ps22->HrefValue = "";
			$this->ps22->TooltipValue = "";

			// ps23
			$this->ps23->LinkCustomAttributes = "";
			$this->ps23->HrefValue = "";
			$this->ps23->TooltipValue = "";

			// ps4
			$this->ps4->LinkCustomAttributes = "";
			$this->ps4->HrefValue = "";
			$this->ps4->TooltipValue = "";

			// kodespm
			$this->kodespm->LinkCustomAttributes = "";
			$this->kodespm->HrefValue = "";
			$this->kodespm->TooltipValue = "";

			// nambud
			$this->nambud->LinkCustomAttributes = "";
			$this->nambud->HrefValue = "";
			$this->nambud->TooltipValue = "";

			// nppk
			$this->nppk->LinkCustomAttributes = "";
			$this->nppk->HrefValue = "";
			$this->nppk->TooltipValue = "";

			// nipppk
			$this->nipppk->LinkCustomAttributes = "";
			$this->nipppk->HrefValue = "";
			$this->nipppk->TooltipValue = "";

			// prog
			$this->prog->LinkCustomAttributes = "";
			$this->prog->HrefValue = "";
			$this->prog->TooltipValue = "";

			// prog1
			$this->prog1->LinkCustomAttributes = "";
			$this->prog1->HrefValue = "";
			$this->prog1->TooltipValue = "";

			// bayar
			$this->bayar->LinkCustomAttributes = "";
			$this->bayar->HrefValue = "";
			$this->bayar->TooltipValue = "";
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
if (!isset($spp_list)) $spp_list = new cspp_list();

// Page init
$spp_list->Page_Init();

// Page main
$spp_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$spp_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fspplist = new ew_Form("fspplist", "list");
fspplist.FormKeyCountName = '<?php echo $spp_list->FormKeyCountName ?>';

// Form_CustomValidate event
fspplist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fspplist.ValidateRequired = true;
<?php } else { ?>
fspplist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fspplistsrch = new ew_Form("fspplistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($spp_list->TotalRecs > 0 && $spp_list->ExportOptions->Visible()) { ?>
<?php $spp_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($spp_list->SearchOptions->Visible()) { ?>
<?php $spp_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($spp_list->FilterOptions->Visible()) { ?>
<?php $spp_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $spp_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($spp_list->TotalRecs <= 0)
			$spp_list->TotalRecs = $spp->SelectRecordCount();
	} else {
		if (!$spp_list->Recordset && ($spp_list->Recordset = $spp_list->LoadRecordset()))
			$spp_list->TotalRecs = $spp_list->Recordset->RecordCount();
	}
	$spp_list->StartRec = 1;
	if ($spp_list->DisplayRecs <= 0 || ($spp->Export <> "" && $spp->ExportAll)) // Display all records
		$spp_list->DisplayRecs = $spp_list->TotalRecs;
	if (!($spp->Export <> "" && $spp->ExportAll))
		$spp_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$spp_list->Recordset = $spp_list->LoadRecordset($spp_list->StartRec-1, $spp_list->DisplayRecs);

	// Set no record found message
	if ($spp->CurrentAction == "" && $spp_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$spp_list->setWarningMessage(ew_DeniedMsg());
		if ($spp_list->SearchWhere == "0=101")
			$spp_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$spp_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$spp_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($spp->Export == "" && $spp->CurrentAction == "") { ?>
<form name="fspplistsrch" id="fspplistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($spp_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fspplistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="spp">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($spp_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($spp_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $spp_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($spp_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($spp_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($spp_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($spp_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $spp_list->ShowPageHeader(); ?>
<?php
$spp_list->ShowMessage();
?>
<?php if ($spp_list->TotalRecs > 0 || $spp->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid spp">
<form name="fspplist" id="fspplist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($spp_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $spp_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="spp">
<div id="gmp_spp" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($spp_list->TotalRecs > 0 || $spp->CurrentAction == "gridedit") { ?>
<table id="tbl_spplist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $spp->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$spp_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$spp_list->RenderListOptions();

// Render list options (header, left)
$spp_list->ListOptions->Render("header", "left");
?>
<?php if ($spp->tgl->Visible) { // tgl ?>
	<?php if ($spp->SortUrl($spp->tgl) == "") { ?>
		<th data-name="tgl"><div id="elh_spp_tgl" class="spp_tgl"><div class="ewTableHeaderCaption"><?php echo $spp->tgl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->tgl) ?>',2);"><div id="elh_spp_tgl" class="spp_tgl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->tgl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->tgl->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->tgl->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->no_spp->Visible) { // no_spp ?>
	<?php if ($spp->SortUrl($spp->no_spp) == "") { ?>
		<th data-name="no_spp"><div id="elh_spp_no_spp" class="spp_no_spp"><div class="ewTableHeaderCaption"><?php echo $spp->no_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->no_spp) ?>',2);"><div id="elh_spp_no_spp" class="spp_no_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->no_spp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->no_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->no_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->jns_spp->Visible) { // jns_spp ?>
	<?php if ($spp->SortUrl($spp->jns_spp) == "") { ?>
		<th data-name="jns_spp"><div id="elh_spp_jns_spp" class="spp_jns_spp"><div class="ewTableHeaderCaption"><?php echo $spp->jns_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jns_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->jns_spp) ?>',2);"><div id="elh_spp_jns_spp" class="spp_jns_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->jns_spp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->jns_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->jns_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->kd_mata->Visible) { // kd_mata ?>
	<?php if ($spp->SortUrl($spp->kd_mata) == "") { ?>
		<th data-name="kd_mata"><div id="elh_spp_kd_mata" class="spp_kd_mata"><div class="ewTableHeaderCaption"><?php echo $spp->kd_mata->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kd_mata"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->kd_mata) ?>',2);"><div id="elh_spp_kd_mata" class="spp_kd_mata">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->kd_mata->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->kd_mata->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->kd_mata->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->urai->Visible) { // urai ?>
	<?php if ($spp->SortUrl($spp->urai) == "") { ?>
		<th data-name="urai"><div id="elh_spp_urai" class="spp_urai"><div class="ewTableHeaderCaption"><?php echo $spp->urai->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="urai"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->urai) ?>',2);"><div id="elh_spp_urai" class="spp_urai">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->urai->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->urai->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->urai->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->jmlh->Visible) { // jmlh ?>
	<?php if ($spp->SortUrl($spp->jmlh) == "") { ?>
		<th data-name="jmlh"><div id="elh_spp_jmlh" class="spp_jmlh"><div class="ewTableHeaderCaption"><?php echo $spp->jmlh->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jmlh"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->jmlh) ?>',2);"><div id="elh_spp_jmlh" class="spp_jmlh">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->jmlh->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->jmlh->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->jmlh->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->jmlh1->Visible) { // jmlh1 ?>
	<?php if ($spp->SortUrl($spp->jmlh1) == "") { ?>
		<th data-name="jmlh1"><div id="elh_spp_jmlh1" class="spp_jmlh1"><div class="ewTableHeaderCaption"><?php echo $spp->jmlh1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jmlh1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->jmlh1) ?>',2);"><div id="elh_spp_jmlh1" class="spp_jmlh1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->jmlh1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->jmlh1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->jmlh1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->jmlh2->Visible) { // jmlh2 ?>
	<?php if ($spp->SortUrl($spp->jmlh2) == "") { ?>
		<th data-name="jmlh2"><div id="elh_spp_jmlh2" class="spp_jmlh2"><div class="ewTableHeaderCaption"><?php echo $spp->jmlh2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jmlh2"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->jmlh2) ?>',2);"><div id="elh_spp_jmlh2" class="spp_jmlh2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->jmlh2->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->jmlh2->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->jmlh2->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->jmlh3->Visible) { // jmlh3 ?>
	<?php if ($spp->SortUrl($spp->jmlh3) == "") { ?>
		<th data-name="jmlh3"><div id="elh_spp_jmlh3" class="spp_jmlh3"><div class="ewTableHeaderCaption"><?php echo $spp->jmlh3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jmlh3"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->jmlh3) ?>',2);"><div id="elh_spp_jmlh3" class="spp_jmlh3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->jmlh3->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->jmlh3->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->jmlh3->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->jmlh4->Visible) { // jmlh4 ?>
	<?php if ($spp->SortUrl($spp->jmlh4) == "") { ?>
		<th data-name="jmlh4"><div id="elh_spp_jmlh4" class="spp_jmlh4"><div class="ewTableHeaderCaption"><?php echo $spp->jmlh4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jmlh4"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->jmlh4) ?>',2);"><div id="elh_spp_jmlh4" class="spp_jmlh4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->jmlh4->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->jmlh4->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->jmlh4->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->nm_perus->Visible) { // nm_perus ?>
	<?php if ($spp->SortUrl($spp->nm_perus) == "") { ?>
		<th data-name="nm_perus"><div id="elh_spp_nm_perus" class="spp_nm_perus"><div class="ewTableHeaderCaption"><?php echo $spp->nm_perus->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nm_perus"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->nm_perus) ?>',2);"><div id="elh_spp_nm_perus" class="spp_nm_perus">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->nm_perus->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->nm_perus->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->nm_perus->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->alamat->Visible) { // alamat ?>
	<?php if ($spp->SortUrl($spp->alamat) == "") { ?>
		<th data-name="alamat"><div id="elh_spp_alamat" class="spp_alamat"><div class="ewTableHeaderCaption"><?php echo $spp->alamat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="alamat"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->alamat) ?>',2);"><div id="elh_spp_alamat" class="spp_alamat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->alamat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->alamat->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->alamat->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->npwp->Visible) { // npwp ?>
	<?php if ($spp->SortUrl($spp->npwp) == "") { ?>
		<th data-name="npwp"><div id="elh_spp_npwp" class="spp_npwp"><div class="ewTableHeaderCaption"><?php echo $spp->npwp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="npwp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->npwp) ?>',2);"><div id="elh_spp_npwp" class="spp_npwp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->npwp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->npwp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->npwp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->pimpinan->Visible) { // pimpinan ?>
	<?php if ($spp->SortUrl($spp->pimpinan) == "") { ?>
		<th data-name="pimpinan"><div id="elh_spp_pimpinan" class="spp_pimpinan"><div class="ewTableHeaderCaption"><?php echo $spp->pimpinan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pimpinan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->pimpinan) ?>',2);"><div id="elh_spp_pimpinan" class="spp_pimpinan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->pimpinan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->pimpinan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->pimpinan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->bank->Visible) { // bank ?>
	<?php if ($spp->SortUrl($spp->bank) == "") { ?>
		<th data-name="bank"><div id="elh_spp_bank" class="spp_bank"><div class="ewTableHeaderCaption"><?php echo $spp->bank->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bank"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->bank) ?>',2);"><div id="elh_spp_bank" class="spp_bank">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->bank->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->bank->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->bank->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->rek->Visible) { // rek ?>
	<?php if ($spp->SortUrl($spp->rek) == "") { ?>
		<th data-name="rek"><div id="elh_spp_rek" class="spp_rek"><div class="ewTableHeaderCaption"><?php echo $spp->rek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rek"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->rek) ?>',2);"><div id="elh_spp_rek" class="spp_rek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->rek->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->rek->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->rek->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->nospm->Visible) { // nospm ?>
	<?php if ($spp->SortUrl($spp->nospm) == "") { ?>
		<th data-name="nospm"><div id="elh_spp_nospm" class="spp_nospm"><div class="ewTableHeaderCaption"><?php echo $spp->nospm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nospm"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->nospm) ?>',2);"><div id="elh_spp_nospm" class="spp_nospm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->nospm->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->nospm->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->nospm->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->tglspm->Visible) { // tglspm ?>
	<?php if ($spp->SortUrl($spp->tglspm) == "") { ?>
		<th data-name="tglspm"><div id="elh_spp_tglspm" class="spp_tglspm"><div class="ewTableHeaderCaption"><?php echo $spp->tglspm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tglspm"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->tglspm) ?>',2);"><div id="elh_spp_tglspm" class="spp_tglspm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->tglspm->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->tglspm->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->tglspm->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->ppn->Visible) { // ppn ?>
	<?php if ($spp->SortUrl($spp->ppn) == "") { ?>
		<th data-name="ppn"><div id="elh_spp_ppn" class="spp_ppn"><div class="ewTableHeaderCaption"><?php echo $spp->ppn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ppn"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->ppn) ?>',2);"><div id="elh_spp_ppn" class="spp_ppn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->ppn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->ppn->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->ppn->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->ps21->Visible) { // ps21 ?>
	<?php if ($spp->SortUrl($spp->ps21) == "") { ?>
		<th data-name="ps21"><div id="elh_spp_ps21" class="spp_ps21"><div class="ewTableHeaderCaption"><?php echo $spp->ps21->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps21"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->ps21) ?>',2);"><div id="elh_spp_ps21" class="spp_ps21">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->ps21->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->ps21->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->ps21->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->ps22->Visible) { // ps22 ?>
	<?php if ($spp->SortUrl($spp->ps22) == "") { ?>
		<th data-name="ps22"><div id="elh_spp_ps22" class="spp_ps22"><div class="ewTableHeaderCaption"><?php echo $spp->ps22->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps22"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->ps22) ?>',2);"><div id="elh_spp_ps22" class="spp_ps22">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->ps22->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->ps22->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->ps22->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->ps23->Visible) { // ps23 ?>
	<?php if ($spp->SortUrl($spp->ps23) == "") { ?>
		<th data-name="ps23"><div id="elh_spp_ps23" class="spp_ps23"><div class="ewTableHeaderCaption"><?php echo $spp->ps23->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps23"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->ps23) ?>',2);"><div id="elh_spp_ps23" class="spp_ps23">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->ps23->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->ps23->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->ps23->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->ps4->Visible) { // ps4 ?>
	<?php if ($spp->SortUrl($spp->ps4) == "") { ?>
		<th data-name="ps4"><div id="elh_spp_ps4" class="spp_ps4"><div class="ewTableHeaderCaption"><?php echo $spp->ps4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps4"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->ps4) ?>',2);"><div id="elh_spp_ps4" class="spp_ps4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->ps4->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($spp->ps4->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->ps4->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->kodespm->Visible) { // kodespm ?>
	<?php if ($spp->SortUrl($spp->kodespm) == "") { ?>
		<th data-name="kodespm"><div id="elh_spp_kodespm" class="spp_kodespm"><div class="ewTableHeaderCaption"><?php echo $spp->kodespm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kodespm"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->kodespm) ?>',2);"><div id="elh_spp_kodespm" class="spp_kodespm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->kodespm->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->kodespm->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->kodespm->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->nambud->Visible) { // nambud ?>
	<?php if ($spp->SortUrl($spp->nambud) == "") { ?>
		<th data-name="nambud"><div id="elh_spp_nambud" class="spp_nambud"><div class="ewTableHeaderCaption"><?php echo $spp->nambud->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nambud"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->nambud) ?>',2);"><div id="elh_spp_nambud" class="spp_nambud">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->nambud->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->nambud->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->nambud->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->nppk->Visible) { // nppk ?>
	<?php if ($spp->SortUrl($spp->nppk) == "") { ?>
		<th data-name="nppk"><div id="elh_spp_nppk" class="spp_nppk"><div class="ewTableHeaderCaption"><?php echo $spp->nppk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nppk"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->nppk) ?>',2);"><div id="elh_spp_nppk" class="spp_nppk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->nppk->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->nppk->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->nppk->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->nipppk->Visible) { // nipppk ?>
	<?php if ($spp->SortUrl($spp->nipppk) == "") { ?>
		<th data-name="nipppk"><div id="elh_spp_nipppk" class="spp_nipppk"><div class="ewTableHeaderCaption"><?php echo $spp->nipppk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nipppk"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->nipppk) ?>',2);"><div id="elh_spp_nipppk" class="spp_nipppk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->nipppk->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->nipppk->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->nipppk->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->prog->Visible) { // prog ?>
	<?php if ($spp->SortUrl($spp->prog) == "") { ?>
		<th data-name="prog"><div id="elh_spp_prog" class="spp_prog"><div class="ewTableHeaderCaption"><?php echo $spp->prog->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="prog"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->prog) ?>',2);"><div id="elh_spp_prog" class="spp_prog">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->prog->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->prog->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->prog->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->prog1->Visible) { // prog1 ?>
	<?php if ($spp->SortUrl($spp->prog1) == "") { ?>
		<th data-name="prog1"><div id="elh_spp_prog1" class="spp_prog1"><div class="ewTableHeaderCaption"><?php echo $spp->prog1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="prog1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->prog1) ?>',2);"><div id="elh_spp_prog1" class="spp_prog1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->prog1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->prog1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->prog1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($spp->bayar->Visible) { // bayar ?>
	<?php if ($spp->SortUrl($spp->bayar) == "") { ?>
		<th data-name="bayar"><div id="elh_spp_bayar" class="spp_bayar"><div class="ewTableHeaderCaption"><?php echo $spp->bayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $spp->SortUrl($spp->bayar) ?>',2);"><div id="elh_spp_bayar" class="spp_bayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $spp->bayar->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($spp->bayar->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($spp->bayar->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$spp_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($spp->ExportAll && $spp->Export <> "") {
	$spp_list->StopRec = $spp_list->TotalRecs;
} else {

	// Set the last record to display
	if ($spp_list->TotalRecs > $spp_list->StartRec + $spp_list->DisplayRecs - 1)
		$spp_list->StopRec = $spp_list->StartRec + $spp_list->DisplayRecs - 1;
	else
		$spp_list->StopRec = $spp_list->TotalRecs;
}
$spp_list->RecCnt = $spp_list->StartRec - 1;
if ($spp_list->Recordset && !$spp_list->Recordset->EOF) {
	$spp_list->Recordset->MoveFirst();
	$bSelectLimit = $spp_list->UseSelectLimit;
	if (!$bSelectLimit && $spp_list->StartRec > 1)
		$spp_list->Recordset->Move($spp_list->StartRec - 1);
} elseif (!$spp->AllowAddDeleteRow && $spp_list->StopRec == 0) {
	$spp_list->StopRec = $spp->GridAddRowCount;
}

// Initialize aggregate
$spp->RowType = EW_ROWTYPE_AGGREGATEINIT;
$spp->ResetAttrs();
$spp_list->RenderRow();
while ($spp_list->RecCnt < $spp_list->StopRec) {
	$spp_list->RecCnt++;
	if (intval($spp_list->RecCnt) >= intval($spp_list->StartRec)) {
		$spp_list->RowCnt++;

		// Set up key count
		$spp_list->KeyCount = $spp_list->RowIndex;

		// Init row class and style
		$spp->ResetAttrs();
		$spp->CssClass = "";
		if ($spp->CurrentAction == "gridadd") {
		} else {
			$spp_list->LoadRowValues($spp_list->Recordset); // Load row values
		}
		$spp->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$spp->RowAttrs = array_merge($spp->RowAttrs, array('data-rowindex'=>$spp_list->RowCnt, 'id'=>'r' . $spp_list->RowCnt . '_spp', 'data-rowtype'=>$spp->RowType));

		// Render row
		$spp_list->RenderRow();

		// Render list options
		$spp_list->RenderListOptions();
?>
	<tr<?php echo $spp->RowAttributes() ?>>
<?php

// Render list options (body, left)
$spp_list->ListOptions->Render("body", "left", $spp_list->RowCnt);
?>
	<?php if ($spp->tgl->Visible) { // tgl ?>
		<td data-name="tgl"<?php echo $spp->tgl->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_tgl" class="spp_tgl">
<span<?php echo $spp->tgl->ViewAttributes() ?>>
<?php echo $spp->tgl->ListViewValue() ?></span>
</span>
<a id="<?php echo $spp_list->PageObjName . "_row_" . $spp_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($spp->no_spp->Visible) { // no_spp ?>
		<td data-name="no_spp"<?php echo $spp->no_spp->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_no_spp" class="spp_no_spp">
<span<?php echo $spp->no_spp->ViewAttributes() ?>>
<?php echo $spp->no_spp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->jns_spp->Visible) { // jns_spp ?>
		<td data-name="jns_spp"<?php echo $spp->jns_spp->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_jns_spp" class="spp_jns_spp">
<span<?php echo $spp->jns_spp->ViewAttributes() ?>>
<?php echo $spp->jns_spp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->kd_mata->Visible) { // kd_mata ?>
		<td data-name="kd_mata"<?php echo $spp->kd_mata->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_kd_mata" class="spp_kd_mata">
<span<?php echo $spp->kd_mata->ViewAttributes() ?>>
<?php echo $spp->kd_mata->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->urai->Visible) { // urai ?>
		<td data-name="urai"<?php echo $spp->urai->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_urai" class="spp_urai">
<span<?php echo $spp->urai->ViewAttributes() ?>>
<?php echo $spp->urai->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->jmlh->Visible) { // jmlh ?>
		<td data-name="jmlh"<?php echo $spp->jmlh->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_jmlh" class="spp_jmlh">
<span<?php echo $spp->jmlh->ViewAttributes() ?>>
<?php echo $spp->jmlh->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->jmlh1->Visible) { // jmlh1 ?>
		<td data-name="jmlh1"<?php echo $spp->jmlh1->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_jmlh1" class="spp_jmlh1">
<span<?php echo $spp->jmlh1->ViewAttributes() ?>>
<?php echo $spp->jmlh1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->jmlh2->Visible) { // jmlh2 ?>
		<td data-name="jmlh2"<?php echo $spp->jmlh2->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_jmlh2" class="spp_jmlh2">
<span<?php echo $spp->jmlh2->ViewAttributes() ?>>
<?php echo $spp->jmlh2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->jmlh3->Visible) { // jmlh3 ?>
		<td data-name="jmlh3"<?php echo $spp->jmlh3->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_jmlh3" class="spp_jmlh3">
<span<?php echo $spp->jmlh3->ViewAttributes() ?>>
<?php echo $spp->jmlh3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->jmlh4->Visible) { // jmlh4 ?>
		<td data-name="jmlh4"<?php echo $spp->jmlh4->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_jmlh4" class="spp_jmlh4">
<span<?php echo $spp->jmlh4->ViewAttributes() ?>>
<?php echo $spp->jmlh4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->nm_perus->Visible) { // nm_perus ?>
		<td data-name="nm_perus"<?php echo $spp->nm_perus->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_nm_perus" class="spp_nm_perus">
<span<?php echo $spp->nm_perus->ViewAttributes() ?>>
<?php echo $spp->nm_perus->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->alamat->Visible) { // alamat ?>
		<td data-name="alamat"<?php echo $spp->alamat->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_alamat" class="spp_alamat">
<span<?php echo $spp->alamat->ViewAttributes() ?>>
<?php echo $spp->alamat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->npwp->Visible) { // npwp ?>
		<td data-name="npwp"<?php echo $spp->npwp->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_npwp" class="spp_npwp">
<span<?php echo $spp->npwp->ViewAttributes() ?>>
<?php echo $spp->npwp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->pimpinan->Visible) { // pimpinan ?>
		<td data-name="pimpinan"<?php echo $spp->pimpinan->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_pimpinan" class="spp_pimpinan">
<span<?php echo $spp->pimpinan->ViewAttributes() ?>>
<?php echo $spp->pimpinan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->bank->Visible) { // bank ?>
		<td data-name="bank"<?php echo $spp->bank->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_bank" class="spp_bank">
<span<?php echo $spp->bank->ViewAttributes() ?>>
<?php echo $spp->bank->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->rek->Visible) { // rek ?>
		<td data-name="rek"<?php echo $spp->rek->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_rek" class="spp_rek">
<span<?php echo $spp->rek->ViewAttributes() ?>>
<?php echo $spp->rek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->nospm->Visible) { // nospm ?>
		<td data-name="nospm"<?php echo $spp->nospm->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_nospm" class="spp_nospm">
<span<?php echo $spp->nospm->ViewAttributes() ?>>
<?php echo $spp->nospm->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->tglspm->Visible) { // tglspm ?>
		<td data-name="tglspm"<?php echo $spp->tglspm->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_tglspm" class="spp_tglspm">
<span<?php echo $spp->tglspm->ViewAttributes() ?>>
<?php echo $spp->tglspm->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->ppn->Visible) { // ppn ?>
		<td data-name="ppn"<?php echo $spp->ppn->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_ppn" class="spp_ppn">
<span<?php echo $spp->ppn->ViewAttributes() ?>>
<?php echo $spp->ppn->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->ps21->Visible) { // ps21 ?>
		<td data-name="ps21"<?php echo $spp->ps21->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_ps21" class="spp_ps21">
<span<?php echo $spp->ps21->ViewAttributes() ?>>
<?php echo $spp->ps21->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->ps22->Visible) { // ps22 ?>
		<td data-name="ps22"<?php echo $spp->ps22->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_ps22" class="spp_ps22">
<span<?php echo $spp->ps22->ViewAttributes() ?>>
<?php echo $spp->ps22->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->ps23->Visible) { // ps23 ?>
		<td data-name="ps23"<?php echo $spp->ps23->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_ps23" class="spp_ps23">
<span<?php echo $spp->ps23->ViewAttributes() ?>>
<?php echo $spp->ps23->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->ps4->Visible) { // ps4 ?>
		<td data-name="ps4"<?php echo $spp->ps4->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_ps4" class="spp_ps4">
<span<?php echo $spp->ps4->ViewAttributes() ?>>
<?php echo $spp->ps4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->kodespm->Visible) { // kodespm ?>
		<td data-name="kodespm"<?php echo $spp->kodespm->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_kodespm" class="spp_kodespm">
<span<?php echo $spp->kodespm->ViewAttributes() ?>>
<?php echo $spp->kodespm->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->nambud->Visible) { // nambud ?>
		<td data-name="nambud"<?php echo $spp->nambud->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_nambud" class="spp_nambud">
<span<?php echo $spp->nambud->ViewAttributes() ?>>
<?php echo $spp->nambud->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->nppk->Visible) { // nppk ?>
		<td data-name="nppk"<?php echo $spp->nppk->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_nppk" class="spp_nppk">
<span<?php echo $spp->nppk->ViewAttributes() ?>>
<?php echo $spp->nppk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->nipppk->Visible) { // nipppk ?>
		<td data-name="nipppk"<?php echo $spp->nipppk->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_nipppk" class="spp_nipppk">
<span<?php echo $spp->nipppk->ViewAttributes() ?>>
<?php echo $spp->nipppk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->prog->Visible) { // prog ?>
		<td data-name="prog"<?php echo $spp->prog->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_prog" class="spp_prog">
<span<?php echo $spp->prog->ViewAttributes() ?>>
<?php echo $spp->prog->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->prog1->Visible) { // prog1 ?>
		<td data-name="prog1"<?php echo $spp->prog1->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_prog1" class="spp_prog1">
<span<?php echo $spp->prog1->ViewAttributes() ?>>
<?php echo $spp->prog1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($spp->bayar->Visible) { // bayar ?>
		<td data-name="bayar"<?php echo $spp->bayar->CellAttributes() ?>>
<span id="el<?php echo $spp_list->RowCnt ?>_spp_bayar" class="spp_bayar">
<span<?php echo $spp->bayar->ViewAttributes() ?>>
<?php echo $spp->bayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$spp_list->ListOptions->Render("body", "right", $spp_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($spp->CurrentAction <> "gridadd")
		$spp_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($spp->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($spp_list->Recordset)
	$spp_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($spp->CurrentAction <> "gridadd" && $spp->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($spp_list->Pager)) $spp_list->Pager = new cPrevNextPager($spp_list->StartRec, $spp_list->DisplayRecs, $spp_list->TotalRecs) ?>
<?php if ($spp_list->Pager->RecordCount > 0 && $spp_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($spp_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $spp_list->PageUrl() ?>start=<?php echo $spp_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($spp_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $spp_list->PageUrl() ?>start=<?php echo $spp_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $spp_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($spp_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $spp_list->PageUrl() ?>start=<?php echo $spp_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($spp_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $spp_list->PageUrl() ?>start=<?php echo $spp_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $spp_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $spp_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $spp_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $spp_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($spp_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $spp_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="spp">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($spp_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($spp_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($spp_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($spp_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($spp_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($spp_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($spp_list->TotalRecs == 0 && $spp->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($spp_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fspplistsrch.FilterList = <?php echo $spp_list->GetFilterList() ?>;
fspplistsrch.Init();
fspplist.Init();
</script>
<?php
$spp_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$spp_list->Page_Terminate();
?>
