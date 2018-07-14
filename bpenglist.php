<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "bpenginfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$bpeng_list = NULL; // Initialize page object first

class cbpeng_list extends cbpeng {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'bpeng';

	// Page object name
	var $PageObjName = 'bpeng_list';

	// Grid form hidden field names
	var $FormName = 'fbpenglist';
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

		// Table object (bpeng)
		if (!isset($GLOBALS["bpeng"]) || get_class($GLOBALS["bpeng"]) == "cbpeng") {
			$GLOBALS["bpeng"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["bpeng"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "bpengadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "bpengdelete.php";
		$this->MultiUpdateUrl = "bpengupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'bpeng', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fbpenglistsrch";

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
		$this->noper->SetVisibility();
		$this->nobuk->SetVisibility();
		$this->keg->SetVisibility();
		$this->bud->SetVisibility();
		$this->ket->SetVisibility();
		$this->jumlahd->SetVisibility();
		$this->jumlahk->SetVisibility();
		$this->chek->SetVisibility();
		$this->debkre->SetVisibility();
		$this->post->SetVisibility();
		$this->foll->SetVisibility();
		$this->jns->SetVisibility();
		$this->jp->SetVisibility();
		$this->spm->SetVisibility();
		$this->spm1->SetVisibility();
		$this->ppn->SetVisibility();
		$this->ps21->SetVisibility();
		$this->ps22->SetVisibility();
		$this->ps23->SetVisibility();
		$this->ps24->SetVisibility();
		$this->ps4->SetVisibility();

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
		global $EW_EXPORT, $bpeng;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($bpeng);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fbpenglistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->tgl->AdvancedSearch->ToJSON(), ","); // Field tgl
		$sFilterList = ew_Concat($sFilterList, $this->noper->AdvancedSearch->ToJSON(), ","); // Field noper
		$sFilterList = ew_Concat($sFilterList, $this->nobuk->AdvancedSearch->ToJSON(), ","); // Field nobuk
		$sFilterList = ew_Concat($sFilterList, $this->keg->AdvancedSearch->ToJSON(), ","); // Field keg
		$sFilterList = ew_Concat($sFilterList, $this->bud->AdvancedSearch->ToJSON(), ","); // Field bud
		$sFilterList = ew_Concat($sFilterList, $this->ket->AdvancedSearch->ToJSON(), ","); // Field ket
		$sFilterList = ew_Concat($sFilterList, $this->jumlahd->AdvancedSearch->ToJSON(), ","); // Field jumlahd
		$sFilterList = ew_Concat($sFilterList, $this->jumlahk->AdvancedSearch->ToJSON(), ","); // Field jumlahk
		$sFilterList = ew_Concat($sFilterList, $this->chek->AdvancedSearch->ToJSON(), ","); // Field chek
		$sFilterList = ew_Concat($sFilterList, $this->debkre->AdvancedSearch->ToJSON(), ","); // Field debkre
		$sFilterList = ew_Concat($sFilterList, $this->post->AdvancedSearch->ToJSON(), ","); // Field post
		$sFilterList = ew_Concat($sFilterList, $this->foll->AdvancedSearch->ToJSON(), ","); // Field foll
		$sFilterList = ew_Concat($sFilterList, $this->jns->AdvancedSearch->ToJSON(), ","); // Field jns
		$sFilterList = ew_Concat($sFilterList, $this->jp->AdvancedSearch->ToJSON(), ","); // Field jp
		$sFilterList = ew_Concat($sFilterList, $this->spm->AdvancedSearch->ToJSON(), ","); // Field spm
		$sFilterList = ew_Concat($sFilterList, $this->spm1->AdvancedSearch->ToJSON(), ","); // Field spm1
		$sFilterList = ew_Concat($sFilterList, $this->ppn->AdvancedSearch->ToJSON(), ","); // Field ppn
		$sFilterList = ew_Concat($sFilterList, $this->ps21->AdvancedSearch->ToJSON(), ","); // Field ps21
		$sFilterList = ew_Concat($sFilterList, $this->ps22->AdvancedSearch->ToJSON(), ","); // Field ps22
		$sFilterList = ew_Concat($sFilterList, $this->ps23->AdvancedSearch->ToJSON(), ","); // Field ps23
		$sFilterList = ew_Concat($sFilterList, $this->ps24->AdvancedSearch->ToJSON(), ","); // Field ps24
		$sFilterList = ew_Concat($sFilterList, $this->ps4->AdvancedSearch->ToJSON(), ","); // Field ps4
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fbpenglistsrch", $filters);

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

		// Field noper
		$this->noper->AdvancedSearch->SearchValue = @$filter["x_noper"];
		$this->noper->AdvancedSearch->SearchOperator = @$filter["z_noper"];
		$this->noper->AdvancedSearch->SearchCondition = @$filter["v_noper"];
		$this->noper->AdvancedSearch->SearchValue2 = @$filter["y_noper"];
		$this->noper->AdvancedSearch->SearchOperator2 = @$filter["w_noper"];
		$this->noper->AdvancedSearch->Save();

		// Field nobuk
		$this->nobuk->AdvancedSearch->SearchValue = @$filter["x_nobuk"];
		$this->nobuk->AdvancedSearch->SearchOperator = @$filter["z_nobuk"];
		$this->nobuk->AdvancedSearch->SearchCondition = @$filter["v_nobuk"];
		$this->nobuk->AdvancedSearch->SearchValue2 = @$filter["y_nobuk"];
		$this->nobuk->AdvancedSearch->SearchOperator2 = @$filter["w_nobuk"];
		$this->nobuk->AdvancedSearch->Save();

		// Field keg
		$this->keg->AdvancedSearch->SearchValue = @$filter["x_keg"];
		$this->keg->AdvancedSearch->SearchOperator = @$filter["z_keg"];
		$this->keg->AdvancedSearch->SearchCondition = @$filter["v_keg"];
		$this->keg->AdvancedSearch->SearchValue2 = @$filter["y_keg"];
		$this->keg->AdvancedSearch->SearchOperator2 = @$filter["w_keg"];
		$this->keg->AdvancedSearch->Save();

		// Field bud
		$this->bud->AdvancedSearch->SearchValue = @$filter["x_bud"];
		$this->bud->AdvancedSearch->SearchOperator = @$filter["z_bud"];
		$this->bud->AdvancedSearch->SearchCondition = @$filter["v_bud"];
		$this->bud->AdvancedSearch->SearchValue2 = @$filter["y_bud"];
		$this->bud->AdvancedSearch->SearchOperator2 = @$filter["w_bud"];
		$this->bud->AdvancedSearch->Save();

		// Field ket
		$this->ket->AdvancedSearch->SearchValue = @$filter["x_ket"];
		$this->ket->AdvancedSearch->SearchOperator = @$filter["z_ket"];
		$this->ket->AdvancedSearch->SearchCondition = @$filter["v_ket"];
		$this->ket->AdvancedSearch->SearchValue2 = @$filter["y_ket"];
		$this->ket->AdvancedSearch->SearchOperator2 = @$filter["w_ket"];
		$this->ket->AdvancedSearch->Save();

		// Field jumlahd
		$this->jumlahd->AdvancedSearch->SearchValue = @$filter["x_jumlahd"];
		$this->jumlahd->AdvancedSearch->SearchOperator = @$filter["z_jumlahd"];
		$this->jumlahd->AdvancedSearch->SearchCondition = @$filter["v_jumlahd"];
		$this->jumlahd->AdvancedSearch->SearchValue2 = @$filter["y_jumlahd"];
		$this->jumlahd->AdvancedSearch->SearchOperator2 = @$filter["w_jumlahd"];
		$this->jumlahd->AdvancedSearch->Save();

		// Field jumlahk
		$this->jumlahk->AdvancedSearch->SearchValue = @$filter["x_jumlahk"];
		$this->jumlahk->AdvancedSearch->SearchOperator = @$filter["z_jumlahk"];
		$this->jumlahk->AdvancedSearch->SearchCondition = @$filter["v_jumlahk"];
		$this->jumlahk->AdvancedSearch->SearchValue2 = @$filter["y_jumlahk"];
		$this->jumlahk->AdvancedSearch->SearchOperator2 = @$filter["w_jumlahk"];
		$this->jumlahk->AdvancedSearch->Save();

		// Field chek
		$this->chek->AdvancedSearch->SearchValue = @$filter["x_chek"];
		$this->chek->AdvancedSearch->SearchOperator = @$filter["z_chek"];
		$this->chek->AdvancedSearch->SearchCondition = @$filter["v_chek"];
		$this->chek->AdvancedSearch->SearchValue2 = @$filter["y_chek"];
		$this->chek->AdvancedSearch->SearchOperator2 = @$filter["w_chek"];
		$this->chek->AdvancedSearch->Save();

		// Field debkre
		$this->debkre->AdvancedSearch->SearchValue = @$filter["x_debkre"];
		$this->debkre->AdvancedSearch->SearchOperator = @$filter["z_debkre"];
		$this->debkre->AdvancedSearch->SearchCondition = @$filter["v_debkre"];
		$this->debkre->AdvancedSearch->SearchValue2 = @$filter["y_debkre"];
		$this->debkre->AdvancedSearch->SearchOperator2 = @$filter["w_debkre"];
		$this->debkre->AdvancedSearch->Save();

		// Field post
		$this->post->AdvancedSearch->SearchValue = @$filter["x_post"];
		$this->post->AdvancedSearch->SearchOperator = @$filter["z_post"];
		$this->post->AdvancedSearch->SearchCondition = @$filter["v_post"];
		$this->post->AdvancedSearch->SearchValue2 = @$filter["y_post"];
		$this->post->AdvancedSearch->SearchOperator2 = @$filter["w_post"];
		$this->post->AdvancedSearch->Save();

		// Field foll
		$this->foll->AdvancedSearch->SearchValue = @$filter["x_foll"];
		$this->foll->AdvancedSearch->SearchOperator = @$filter["z_foll"];
		$this->foll->AdvancedSearch->SearchCondition = @$filter["v_foll"];
		$this->foll->AdvancedSearch->SearchValue2 = @$filter["y_foll"];
		$this->foll->AdvancedSearch->SearchOperator2 = @$filter["w_foll"];
		$this->foll->AdvancedSearch->Save();

		// Field jns
		$this->jns->AdvancedSearch->SearchValue = @$filter["x_jns"];
		$this->jns->AdvancedSearch->SearchOperator = @$filter["z_jns"];
		$this->jns->AdvancedSearch->SearchCondition = @$filter["v_jns"];
		$this->jns->AdvancedSearch->SearchValue2 = @$filter["y_jns"];
		$this->jns->AdvancedSearch->SearchOperator2 = @$filter["w_jns"];
		$this->jns->AdvancedSearch->Save();

		// Field jp
		$this->jp->AdvancedSearch->SearchValue = @$filter["x_jp"];
		$this->jp->AdvancedSearch->SearchOperator = @$filter["z_jp"];
		$this->jp->AdvancedSearch->SearchCondition = @$filter["v_jp"];
		$this->jp->AdvancedSearch->SearchValue2 = @$filter["y_jp"];
		$this->jp->AdvancedSearch->SearchOperator2 = @$filter["w_jp"];
		$this->jp->AdvancedSearch->Save();

		// Field spm
		$this->spm->AdvancedSearch->SearchValue = @$filter["x_spm"];
		$this->spm->AdvancedSearch->SearchOperator = @$filter["z_spm"];
		$this->spm->AdvancedSearch->SearchCondition = @$filter["v_spm"];
		$this->spm->AdvancedSearch->SearchValue2 = @$filter["y_spm"];
		$this->spm->AdvancedSearch->SearchOperator2 = @$filter["w_spm"];
		$this->spm->AdvancedSearch->Save();

		// Field spm1
		$this->spm1->AdvancedSearch->SearchValue = @$filter["x_spm1"];
		$this->spm1->AdvancedSearch->SearchOperator = @$filter["z_spm1"];
		$this->spm1->AdvancedSearch->SearchCondition = @$filter["v_spm1"];
		$this->spm1->AdvancedSearch->SearchValue2 = @$filter["y_spm1"];
		$this->spm1->AdvancedSearch->SearchOperator2 = @$filter["w_spm1"];
		$this->spm1->AdvancedSearch->Save();

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

		// Field ps24
		$this->ps24->AdvancedSearch->SearchValue = @$filter["x_ps24"];
		$this->ps24->AdvancedSearch->SearchOperator = @$filter["z_ps24"];
		$this->ps24->AdvancedSearch->SearchCondition = @$filter["v_ps24"];
		$this->ps24->AdvancedSearch->SearchValue2 = @$filter["y_ps24"];
		$this->ps24->AdvancedSearch->SearchOperator2 = @$filter["w_ps24"];
		$this->ps24->AdvancedSearch->Save();

		// Field ps4
		$this->ps4->AdvancedSearch->SearchValue = @$filter["x_ps4"];
		$this->ps4->AdvancedSearch->SearchOperator = @$filter["z_ps4"];
		$this->ps4->AdvancedSearch->SearchCondition = @$filter["v_ps4"];
		$this->ps4->AdvancedSearch->SearchValue2 = @$filter["y_ps4"];
		$this->ps4->AdvancedSearch->SearchOperator2 = @$filter["w_ps4"];
		$this->ps4->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->noper, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nobuk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->keg, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bud, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->chek, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->debkre, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->post, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->foll, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jns, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->spm, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->spm1, $arKeywords, $type);
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
			$this->UpdateSort($this->noper, $bCtrl); // noper
			$this->UpdateSort($this->nobuk, $bCtrl); // nobuk
			$this->UpdateSort($this->keg, $bCtrl); // keg
			$this->UpdateSort($this->bud, $bCtrl); // bud
			$this->UpdateSort($this->ket, $bCtrl); // ket
			$this->UpdateSort($this->jumlahd, $bCtrl); // jumlahd
			$this->UpdateSort($this->jumlahk, $bCtrl); // jumlahk
			$this->UpdateSort($this->chek, $bCtrl); // chek
			$this->UpdateSort($this->debkre, $bCtrl); // debkre
			$this->UpdateSort($this->post, $bCtrl); // post
			$this->UpdateSort($this->foll, $bCtrl); // foll
			$this->UpdateSort($this->jns, $bCtrl); // jns
			$this->UpdateSort($this->jp, $bCtrl); // jp
			$this->UpdateSort($this->spm, $bCtrl); // spm
			$this->UpdateSort($this->spm1, $bCtrl); // spm1
			$this->UpdateSort($this->ppn, $bCtrl); // ppn
			$this->UpdateSort($this->ps21, $bCtrl); // ps21
			$this->UpdateSort($this->ps22, $bCtrl); // ps22
			$this->UpdateSort($this->ps23, $bCtrl); // ps23
			$this->UpdateSort($this->ps24, $bCtrl); // ps24
			$this->UpdateSort($this->ps4, $bCtrl); // ps4
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
				$this->noper->setSort("");
				$this->nobuk->setSort("");
				$this->keg->setSort("");
				$this->bud->setSort("");
				$this->ket->setSort("");
				$this->jumlahd->setSort("");
				$this->jumlahk->setSort("");
				$this->chek->setSort("");
				$this->debkre->setSort("");
				$this->post->setSort("");
				$this->foll->setSort("");
				$this->jns->setSort("");
				$this->jp->setSort("");
				$this->spm->setSort("");
				$this->spm1->setSort("");
				$this->ppn->setSort("");
				$this->ps21->setSort("");
				$this->ps22->setSort("");
				$this->ps23->setSort("");
				$this->ps24->setSort("");
				$this->ps4->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fbpenglistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fbpenglistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fbpenglist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fbpenglistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->noper->setDbValue($rs->fields('noper'));
		$this->nobuk->setDbValue($rs->fields('nobuk'));
		$this->keg->setDbValue($rs->fields('keg'));
		$this->bud->setDbValue($rs->fields('bud'));
		$this->ket->setDbValue($rs->fields('ket'));
		$this->jumlahd->setDbValue($rs->fields('jumlahd'));
		$this->jumlahk->setDbValue($rs->fields('jumlahk'));
		$this->chek->setDbValue($rs->fields('chek'));
		$this->debkre->setDbValue($rs->fields('debkre'));
		$this->post->setDbValue($rs->fields('post'));
		$this->foll->setDbValue($rs->fields('foll'));
		$this->jns->setDbValue($rs->fields('jns'));
		$this->jp->setDbValue($rs->fields('jp'));
		$this->spm->setDbValue($rs->fields('spm'));
		$this->spm1->setDbValue($rs->fields('spm1'));
		$this->ppn->setDbValue($rs->fields('ppn'));
		$this->ps21->setDbValue($rs->fields('ps21'));
		$this->ps22->setDbValue($rs->fields('ps22'));
		$this->ps23->setDbValue($rs->fields('ps23'));
		$this->ps24->setDbValue($rs->fields('ps24'));
		$this->ps4->setDbValue($rs->fields('ps4'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->tgl->DbValue = $row['tgl'];
		$this->noper->DbValue = $row['noper'];
		$this->nobuk->DbValue = $row['nobuk'];
		$this->keg->DbValue = $row['keg'];
		$this->bud->DbValue = $row['bud'];
		$this->ket->DbValue = $row['ket'];
		$this->jumlahd->DbValue = $row['jumlahd'];
		$this->jumlahk->DbValue = $row['jumlahk'];
		$this->chek->DbValue = $row['chek'];
		$this->debkre->DbValue = $row['debkre'];
		$this->post->DbValue = $row['post'];
		$this->foll->DbValue = $row['foll'];
		$this->jns->DbValue = $row['jns'];
		$this->jp->DbValue = $row['jp'];
		$this->spm->DbValue = $row['spm'];
		$this->spm1->DbValue = $row['spm1'];
		$this->ppn->DbValue = $row['ppn'];
		$this->ps21->DbValue = $row['ps21'];
		$this->ps22->DbValue = $row['ps22'];
		$this->ps23->DbValue = $row['ps23'];
		$this->ps24->DbValue = $row['ps24'];
		$this->ps4->DbValue = $row['ps4'];
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
		// noper
		// nobuk
		// keg
		// bud
		// ket
		// jumlahd
		// jumlahk
		// chek
		// debkre
		// post
		// foll
		// jns
		// jp
		// spm
		// spm1
		// ppn
		// ps21
		// ps22
		// ps23
		// ps24
		// ps4

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// tgl
		$this->tgl->ViewValue = $this->tgl->CurrentValue;
		$this->tgl->ViewValue = ew_FormatDateTime($this->tgl->ViewValue, 0);
		$this->tgl->ViewCustomAttributes = "";

		// noper
		$this->noper->ViewValue = $this->noper->CurrentValue;
		$this->noper->ViewCustomAttributes = "";

		// nobuk
		$this->nobuk->ViewValue = $this->nobuk->CurrentValue;
		$this->nobuk->ViewCustomAttributes = "";

		// keg
		$this->keg->ViewValue = $this->keg->CurrentValue;
		$this->keg->ViewCustomAttributes = "";

		// bud
		$this->bud->ViewValue = $this->bud->CurrentValue;
		$this->bud->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// jumlahd
		$this->jumlahd->ViewValue = $this->jumlahd->CurrentValue;
		$this->jumlahd->ViewCustomAttributes = "";

		// jumlahk
		$this->jumlahk->ViewValue = $this->jumlahk->CurrentValue;
		$this->jumlahk->ViewCustomAttributes = "";

		// chek
		$this->chek->ViewValue = $this->chek->CurrentValue;
		$this->chek->ViewCustomAttributes = "";

		// debkre
		$this->debkre->ViewValue = $this->debkre->CurrentValue;
		$this->debkre->ViewCustomAttributes = "";

		// post
		$this->post->ViewValue = $this->post->CurrentValue;
		$this->post->ViewCustomAttributes = "";

		// foll
		$this->foll->ViewValue = $this->foll->CurrentValue;
		$this->foll->ViewCustomAttributes = "";

		// jns
		$this->jns->ViewValue = $this->jns->CurrentValue;
		$this->jns->ViewCustomAttributes = "";

		// jp
		$this->jp->ViewValue = $this->jp->CurrentValue;
		$this->jp->ViewCustomAttributes = "";

		// spm
		$this->spm->ViewValue = $this->spm->CurrentValue;
		$this->spm->ViewCustomAttributes = "";

		// spm1
		$this->spm1->ViewValue = $this->spm1->CurrentValue;
		$this->spm1->ViewCustomAttributes = "";

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

		// ps24
		$this->ps24->ViewValue = $this->ps24->CurrentValue;
		$this->ps24->ViewCustomAttributes = "";

		// ps4
		$this->ps4->ViewValue = $this->ps4->CurrentValue;
		$this->ps4->ViewCustomAttributes = "";

			// tgl
			$this->tgl->LinkCustomAttributes = "";
			$this->tgl->HrefValue = "";
			$this->tgl->TooltipValue = "";

			// noper
			$this->noper->LinkCustomAttributes = "";
			$this->noper->HrefValue = "";
			$this->noper->TooltipValue = "";

			// nobuk
			$this->nobuk->LinkCustomAttributes = "";
			$this->nobuk->HrefValue = "";
			$this->nobuk->TooltipValue = "";

			// keg
			$this->keg->LinkCustomAttributes = "";
			$this->keg->HrefValue = "";
			$this->keg->TooltipValue = "";

			// bud
			$this->bud->LinkCustomAttributes = "";
			$this->bud->HrefValue = "";
			$this->bud->TooltipValue = "";

			// ket
			$this->ket->LinkCustomAttributes = "";
			$this->ket->HrefValue = "";
			$this->ket->TooltipValue = "";

			// jumlahd
			$this->jumlahd->LinkCustomAttributes = "";
			$this->jumlahd->HrefValue = "";
			$this->jumlahd->TooltipValue = "";

			// jumlahk
			$this->jumlahk->LinkCustomAttributes = "";
			$this->jumlahk->HrefValue = "";
			$this->jumlahk->TooltipValue = "";

			// chek
			$this->chek->LinkCustomAttributes = "";
			$this->chek->HrefValue = "";
			$this->chek->TooltipValue = "";

			// debkre
			$this->debkre->LinkCustomAttributes = "";
			$this->debkre->HrefValue = "";
			$this->debkre->TooltipValue = "";

			// post
			$this->post->LinkCustomAttributes = "";
			$this->post->HrefValue = "";
			$this->post->TooltipValue = "";

			// foll
			$this->foll->LinkCustomAttributes = "";
			$this->foll->HrefValue = "";
			$this->foll->TooltipValue = "";

			// jns
			$this->jns->LinkCustomAttributes = "";
			$this->jns->HrefValue = "";
			$this->jns->TooltipValue = "";

			// jp
			$this->jp->LinkCustomAttributes = "";
			$this->jp->HrefValue = "";
			$this->jp->TooltipValue = "";

			// spm
			$this->spm->LinkCustomAttributes = "";
			$this->spm->HrefValue = "";
			$this->spm->TooltipValue = "";

			// spm1
			$this->spm1->LinkCustomAttributes = "";
			$this->spm1->HrefValue = "";
			$this->spm1->TooltipValue = "";

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

			// ps24
			$this->ps24->LinkCustomAttributes = "";
			$this->ps24->HrefValue = "";
			$this->ps24->TooltipValue = "";

			// ps4
			$this->ps4->LinkCustomAttributes = "";
			$this->ps4->HrefValue = "";
			$this->ps4->TooltipValue = "";
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
if (!isset($bpeng_list)) $bpeng_list = new cbpeng_list();

// Page init
$bpeng_list->Page_Init();

// Page main
$bpeng_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$bpeng_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fbpenglist = new ew_Form("fbpenglist", "list");
fbpenglist.FormKeyCountName = '<?php echo $bpeng_list->FormKeyCountName ?>';

// Form_CustomValidate event
fbpenglist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbpenglist.ValidateRequired = true;
<?php } else { ?>
fbpenglist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fbpenglistsrch = new ew_Form("fbpenglistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($bpeng_list->TotalRecs > 0 && $bpeng_list->ExportOptions->Visible()) { ?>
<?php $bpeng_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($bpeng_list->SearchOptions->Visible()) { ?>
<?php $bpeng_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($bpeng_list->FilterOptions->Visible()) { ?>
<?php $bpeng_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $bpeng_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($bpeng_list->TotalRecs <= 0)
			$bpeng_list->TotalRecs = $bpeng->SelectRecordCount();
	} else {
		if (!$bpeng_list->Recordset && ($bpeng_list->Recordset = $bpeng_list->LoadRecordset()))
			$bpeng_list->TotalRecs = $bpeng_list->Recordset->RecordCount();
	}
	$bpeng_list->StartRec = 1;
	if ($bpeng_list->DisplayRecs <= 0 || ($bpeng->Export <> "" && $bpeng->ExportAll)) // Display all records
		$bpeng_list->DisplayRecs = $bpeng_list->TotalRecs;
	if (!($bpeng->Export <> "" && $bpeng->ExportAll))
		$bpeng_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$bpeng_list->Recordset = $bpeng_list->LoadRecordset($bpeng_list->StartRec-1, $bpeng_list->DisplayRecs);

	// Set no record found message
	if ($bpeng->CurrentAction == "" && $bpeng_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$bpeng_list->setWarningMessage(ew_DeniedMsg());
		if ($bpeng_list->SearchWhere == "0=101")
			$bpeng_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$bpeng_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$bpeng_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($bpeng->Export == "" && $bpeng->CurrentAction == "") { ?>
<form name="fbpenglistsrch" id="fbpenglistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($bpeng_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fbpenglistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="bpeng">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($bpeng_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($bpeng_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $bpeng_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($bpeng_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($bpeng_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($bpeng_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($bpeng_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $bpeng_list->ShowPageHeader(); ?>
<?php
$bpeng_list->ShowMessage();
?>
<?php if ($bpeng_list->TotalRecs > 0 || $bpeng->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid bpeng">
<form name="fbpenglist" id="fbpenglist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($bpeng_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $bpeng_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="bpeng">
<div id="gmp_bpeng" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($bpeng_list->TotalRecs > 0 || $bpeng->CurrentAction == "gridedit") { ?>
<table id="tbl_bpenglist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $bpeng->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$bpeng_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$bpeng_list->RenderListOptions();

// Render list options (header, left)
$bpeng_list->ListOptions->Render("header", "left");
?>
<?php if ($bpeng->tgl->Visible) { // tgl ?>
	<?php if ($bpeng->SortUrl($bpeng->tgl) == "") { ?>
		<th data-name="tgl"><div id="elh_bpeng_tgl" class="bpeng_tgl"><div class="ewTableHeaderCaption"><?php echo $bpeng->tgl->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->tgl) ?>',2);"><div id="elh_bpeng_tgl" class="bpeng_tgl">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->tgl->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->tgl->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->tgl->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->noper->Visible) { // noper ?>
	<?php if ($bpeng->SortUrl($bpeng->noper) == "") { ?>
		<th data-name="noper"><div id="elh_bpeng_noper" class="bpeng_noper"><div class="ewTableHeaderCaption"><?php echo $bpeng->noper->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="noper"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->noper) ?>',2);"><div id="elh_bpeng_noper" class="bpeng_noper">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->noper->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->noper->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->noper->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->nobuk->Visible) { // nobuk ?>
	<?php if ($bpeng->SortUrl($bpeng->nobuk) == "") { ?>
		<th data-name="nobuk"><div id="elh_bpeng_nobuk" class="bpeng_nobuk"><div class="ewTableHeaderCaption"><?php echo $bpeng->nobuk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nobuk"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->nobuk) ?>',2);"><div id="elh_bpeng_nobuk" class="bpeng_nobuk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->nobuk->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->nobuk->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->nobuk->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->keg->Visible) { // keg ?>
	<?php if ($bpeng->SortUrl($bpeng->keg) == "") { ?>
		<th data-name="keg"><div id="elh_bpeng_keg" class="bpeng_keg"><div class="ewTableHeaderCaption"><?php echo $bpeng->keg->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keg"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->keg) ?>',2);"><div id="elh_bpeng_keg" class="bpeng_keg">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->keg->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->keg->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->keg->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->bud->Visible) { // bud ?>
	<?php if ($bpeng->SortUrl($bpeng->bud) == "") { ?>
		<th data-name="bud"><div id="elh_bpeng_bud" class="bpeng_bud"><div class="ewTableHeaderCaption"><?php echo $bpeng->bud->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bud"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->bud) ?>',2);"><div id="elh_bpeng_bud" class="bpeng_bud">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->bud->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->bud->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->bud->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->ket->Visible) { // ket ?>
	<?php if ($bpeng->SortUrl($bpeng->ket) == "") { ?>
		<th data-name="ket"><div id="elh_bpeng_ket" class="bpeng_ket"><div class="ewTableHeaderCaption"><?php echo $bpeng->ket->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ket"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->ket) ?>',2);"><div id="elh_bpeng_ket" class="bpeng_ket">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->ket->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->ket->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->ket->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->jumlahd->Visible) { // jumlahd ?>
	<?php if ($bpeng->SortUrl($bpeng->jumlahd) == "") { ?>
		<th data-name="jumlahd"><div id="elh_bpeng_jumlahd" class="bpeng_jumlahd"><div class="ewTableHeaderCaption"><?php echo $bpeng->jumlahd->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlahd"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->jumlahd) ?>',2);"><div id="elh_bpeng_jumlahd" class="bpeng_jumlahd">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->jumlahd->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->jumlahd->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->jumlahd->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->jumlahk->Visible) { // jumlahk ?>
	<?php if ($bpeng->SortUrl($bpeng->jumlahk) == "") { ?>
		<th data-name="jumlahk"><div id="elh_bpeng_jumlahk" class="bpeng_jumlahk"><div class="ewTableHeaderCaption"><?php echo $bpeng->jumlahk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jumlahk"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->jumlahk) ?>',2);"><div id="elh_bpeng_jumlahk" class="bpeng_jumlahk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->jumlahk->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->jumlahk->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->jumlahk->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->chek->Visible) { // chek ?>
	<?php if ($bpeng->SortUrl($bpeng->chek) == "") { ?>
		<th data-name="chek"><div id="elh_bpeng_chek" class="bpeng_chek"><div class="ewTableHeaderCaption"><?php echo $bpeng->chek->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chek"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->chek) ?>',2);"><div id="elh_bpeng_chek" class="bpeng_chek">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->chek->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->chek->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->chek->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->debkre->Visible) { // debkre ?>
	<?php if ($bpeng->SortUrl($bpeng->debkre) == "") { ?>
		<th data-name="debkre"><div id="elh_bpeng_debkre" class="bpeng_debkre"><div class="ewTableHeaderCaption"><?php echo $bpeng->debkre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="debkre"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->debkre) ?>',2);"><div id="elh_bpeng_debkre" class="bpeng_debkre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->debkre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->debkre->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->debkre->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->post->Visible) { // post ?>
	<?php if ($bpeng->SortUrl($bpeng->post) == "") { ?>
		<th data-name="post"><div id="elh_bpeng_post" class="bpeng_post"><div class="ewTableHeaderCaption"><?php echo $bpeng->post->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="post"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->post) ?>',2);"><div id="elh_bpeng_post" class="bpeng_post">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->post->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->post->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->post->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->foll->Visible) { // foll ?>
	<?php if ($bpeng->SortUrl($bpeng->foll) == "") { ?>
		<th data-name="foll"><div id="elh_bpeng_foll" class="bpeng_foll"><div class="ewTableHeaderCaption"><?php echo $bpeng->foll->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="foll"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->foll) ?>',2);"><div id="elh_bpeng_foll" class="bpeng_foll">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->foll->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->foll->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->foll->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->jns->Visible) { // jns ?>
	<?php if ($bpeng->SortUrl($bpeng->jns) == "") { ?>
		<th data-name="jns"><div id="elh_bpeng_jns" class="bpeng_jns"><div class="ewTableHeaderCaption"><?php echo $bpeng->jns->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jns"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->jns) ?>',2);"><div id="elh_bpeng_jns" class="bpeng_jns">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->jns->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->jns->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->jns->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->jp->Visible) { // jp ?>
	<?php if ($bpeng->SortUrl($bpeng->jp) == "") { ?>
		<th data-name="jp"><div id="elh_bpeng_jp" class="bpeng_jp"><div class="ewTableHeaderCaption"><?php echo $bpeng->jp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->jp) ?>',2);"><div id="elh_bpeng_jp" class="bpeng_jp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->jp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->jp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->jp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->spm->Visible) { // spm ?>
	<?php if ($bpeng->SortUrl($bpeng->spm) == "") { ?>
		<th data-name="spm"><div id="elh_bpeng_spm" class="bpeng_spm"><div class="ewTableHeaderCaption"><?php echo $bpeng->spm->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="spm"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->spm) ?>',2);"><div id="elh_bpeng_spm" class="bpeng_spm">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->spm->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->spm->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->spm->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->spm1->Visible) { // spm1 ?>
	<?php if ($bpeng->SortUrl($bpeng->spm1) == "") { ?>
		<th data-name="spm1"><div id="elh_bpeng_spm1" class="bpeng_spm1"><div class="ewTableHeaderCaption"><?php echo $bpeng->spm1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="spm1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->spm1) ?>',2);"><div id="elh_bpeng_spm1" class="bpeng_spm1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->spm1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->spm1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->spm1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->ppn->Visible) { // ppn ?>
	<?php if ($bpeng->SortUrl($bpeng->ppn) == "") { ?>
		<th data-name="ppn"><div id="elh_bpeng_ppn" class="bpeng_ppn"><div class="ewTableHeaderCaption"><?php echo $bpeng->ppn->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ppn"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->ppn) ?>',2);"><div id="elh_bpeng_ppn" class="bpeng_ppn">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->ppn->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->ppn->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->ppn->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->ps21->Visible) { // ps21 ?>
	<?php if ($bpeng->SortUrl($bpeng->ps21) == "") { ?>
		<th data-name="ps21"><div id="elh_bpeng_ps21" class="bpeng_ps21"><div class="ewTableHeaderCaption"><?php echo $bpeng->ps21->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps21"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->ps21) ?>',2);"><div id="elh_bpeng_ps21" class="bpeng_ps21">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->ps21->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->ps21->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->ps21->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->ps22->Visible) { // ps22 ?>
	<?php if ($bpeng->SortUrl($bpeng->ps22) == "") { ?>
		<th data-name="ps22"><div id="elh_bpeng_ps22" class="bpeng_ps22"><div class="ewTableHeaderCaption"><?php echo $bpeng->ps22->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps22"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->ps22) ?>',2);"><div id="elh_bpeng_ps22" class="bpeng_ps22">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->ps22->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->ps22->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->ps22->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->ps23->Visible) { // ps23 ?>
	<?php if ($bpeng->SortUrl($bpeng->ps23) == "") { ?>
		<th data-name="ps23"><div id="elh_bpeng_ps23" class="bpeng_ps23"><div class="ewTableHeaderCaption"><?php echo $bpeng->ps23->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps23"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->ps23) ?>',2);"><div id="elh_bpeng_ps23" class="bpeng_ps23">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->ps23->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->ps23->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->ps23->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->ps24->Visible) { // ps24 ?>
	<?php if ($bpeng->SortUrl($bpeng->ps24) == "") { ?>
		<th data-name="ps24"><div id="elh_bpeng_ps24" class="bpeng_ps24"><div class="ewTableHeaderCaption"><?php echo $bpeng->ps24->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps24"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->ps24) ?>',2);"><div id="elh_bpeng_ps24" class="bpeng_ps24">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->ps24->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->ps24->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->ps24->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($bpeng->ps4->Visible) { // ps4 ?>
	<?php if ($bpeng->SortUrl($bpeng->ps4) == "") { ?>
		<th data-name="ps4"><div id="elh_bpeng_ps4" class="bpeng_ps4"><div class="ewTableHeaderCaption"><?php echo $bpeng->ps4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ps4"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $bpeng->SortUrl($bpeng->ps4) ?>',2);"><div id="elh_bpeng_ps4" class="bpeng_ps4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $bpeng->ps4->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($bpeng->ps4->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($bpeng->ps4->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$bpeng_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($bpeng->ExportAll && $bpeng->Export <> "") {
	$bpeng_list->StopRec = $bpeng_list->TotalRecs;
} else {

	// Set the last record to display
	if ($bpeng_list->TotalRecs > $bpeng_list->StartRec + $bpeng_list->DisplayRecs - 1)
		$bpeng_list->StopRec = $bpeng_list->StartRec + $bpeng_list->DisplayRecs - 1;
	else
		$bpeng_list->StopRec = $bpeng_list->TotalRecs;
}
$bpeng_list->RecCnt = $bpeng_list->StartRec - 1;
if ($bpeng_list->Recordset && !$bpeng_list->Recordset->EOF) {
	$bpeng_list->Recordset->MoveFirst();
	$bSelectLimit = $bpeng_list->UseSelectLimit;
	if (!$bSelectLimit && $bpeng_list->StartRec > 1)
		$bpeng_list->Recordset->Move($bpeng_list->StartRec - 1);
} elseif (!$bpeng->AllowAddDeleteRow && $bpeng_list->StopRec == 0) {
	$bpeng_list->StopRec = $bpeng->GridAddRowCount;
}

// Initialize aggregate
$bpeng->RowType = EW_ROWTYPE_AGGREGATEINIT;
$bpeng->ResetAttrs();
$bpeng_list->RenderRow();
while ($bpeng_list->RecCnt < $bpeng_list->StopRec) {
	$bpeng_list->RecCnt++;
	if (intval($bpeng_list->RecCnt) >= intval($bpeng_list->StartRec)) {
		$bpeng_list->RowCnt++;

		// Set up key count
		$bpeng_list->KeyCount = $bpeng_list->RowIndex;

		// Init row class and style
		$bpeng->ResetAttrs();
		$bpeng->CssClass = "";
		if ($bpeng->CurrentAction == "gridadd") {
		} else {
			$bpeng_list->LoadRowValues($bpeng_list->Recordset); // Load row values
		}
		$bpeng->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$bpeng->RowAttrs = array_merge($bpeng->RowAttrs, array('data-rowindex'=>$bpeng_list->RowCnt, 'id'=>'r' . $bpeng_list->RowCnt . '_bpeng', 'data-rowtype'=>$bpeng->RowType));

		// Render row
		$bpeng_list->RenderRow();

		// Render list options
		$bpeng_list->RenderListOptions();
?>
	<tr<?php echo $bpeng->RowAttributes() ?>>
<?php

// Render list options (body, left)
$bpeng_list->ListOptions->Render("body", "left", $bpeng_list->RowCnt);
?>
	<?php if ($bpeng->tgl->Visible) { // tgl ?>
		<td data-name="tgl"<?php echo $bpeng->tgl->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_tgl" class="bpeng_tgl">
<span<?php echo $bpeng->tgl->ViewAttributes() ?>>
<?php echo $bpeng->tgl->ListViewValue() ?></span>
</span>
<a id="<?php echo $bpeng_list->PageObjName . "_row_" . $bpeng_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($bpeng->noper->Visible) { // noper ?>
		<td data-name="noper"<?php echo $bpeng->noper->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_noper" class="bpeng_noper">
<span<?php echo $bpeng->noper->ViewAttributes() ?>>
<?php echo $bpeng->noper->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->nobuk->Visible) { // nobuk ?>
		<td data-name="nobuk"<?php echo $bpeng->nobuk->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_nobuk" class="bpeng_nobuk">
<span<?php echo $bpeng->nobuk->ViewAttributes() ?>>
<?php echo $bpeng->nobuk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->keg->Visible) { // keg ?>
		<td data-name="keg"<?php echo $bpeng->keg->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_keg" class="bpeng_keg">
<span<?php echo $bpeng->keg->ViewAttributes() ?>>
<?php echo $bpeng->keg->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->bud->Visible) { // bud ?>
		<td data-name="bud"<?php echo $bpeng->bud->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_bud" class="bpeng_bud">
<span<?php echo $bpeng->bud->ViewAttributes() ?>>
<?php echo $bpeng->bud->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->ket->Visible) { // ket ?>
		<td data-name="ket"<?php echo $bpeng->ket->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_ket" class="bpeng_ket">
<span<?php echo $bpeng->ket->ViewAttributes() ?>>
<?php echo $bpeng->ket->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->jumlahd->Visible) { // jumlahd ?>
		<td data-name="jumlahd"<?php echo $bpeng->jumlahd->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_jumlahd" class="bpeng_jumlahd">
<span<?php echo $bpeng->jumlahd->ViewAttributes() ?>>
<?php echo $bpeng->jumlahd->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->jumlahk->Visible) { // jumlahk ?>
		<td data-name="jumlahk"<?php echo $bpeng->jumlahk->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_jumlahk" class="bpeng_jumlahk">
<span<?php echo $bpeng->jumlahk->ViewAttributes() ?>>
<?php echo $bpeng->jumlahk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->chek->Visible) { // chek ?>
		<td data-name="chek"<?php echo $bpeng->chek->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_chek" class="bpeng_chek">
<span<?php echo $bpeng->chek->ViewAttributes() ?>>
<?php echo $bpeng->chek->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->debkre->Visible) { // debkre ?>
		<td data-name="debkre"<?php echo $bpeng->debkre->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_debkre" class="bpeng_debkre">
<span<?php echo $bpeng->debkre->ViewAttributes() ?>>
<?php echo $bpeng->debkre->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->post->Visible) { // post ?>
		<td data-name="post"<?php echo $bpeng->post->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_post" class="bpeng_post">
<span<?php echo $bpeng->post->ViewAttributes() ?>>
<?php echo $bpeng->post->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->foll->Visible) { // foll ?>
		<td data-name="foll"<?php echo $bpeng->foll->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_foll" class="bpeng_foll">
<span<?php echo $bpeng->foll->ViewAttributes() ?>>
<?php echo $bpeng->foll->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->jns->Visible) { // jns ?>
		<td data-name="jns"<?php echo $bpeng->jns->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_jns" class="bpeng_jns">
<span<?php echo $bpeng->jns->ViewAttributes() ?>>
<?php echo $bpeng->jns->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->jp->Visible) { // jp ?>
		<td data-name="jp"<?php echo $bpeng->jp->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_jp" class="bpeng_jp">
<span<?php echo $bpeng->jp->ViewAttributes() ?>>
<?php echo $bpeng->jp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->spm->Visible) { // spm ?>
		<td data-name="spm"<?php echo $bpeng->spm->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_spm" class="bpeng_spm">
<span<?php echo $bpeng->spm->ViewAttributes() ?>>
<?php echo $bpeng->spm->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->spm1->Visible) { // spm1 ?>
		<td data-name="spm1"<?php echo $bpeng->spm1->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_spm1" class="bpeng_spm1">
<span<?php echo $bpeng->spm1->ViewAttributes() ?>>
<?php echo $bpeng->spm1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->ppn->Visible) { // ppn ?>
		<td data-name="ppn"<?php echo $bpeng->ppn->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_ppn" class="bpeng_ppn">
<span<?php echo $bpeng->ppn->ViewAttributes() ?>>
<?php echo $bpeng->ppn->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->ps21->Visible) { // ps21 ?>
		<td data-name="ps21"<?php echo $bpeng->ps21->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_ps21" class="bpeng_ps21">
<span<?php echo $bpeng->ps21->ViewAttributes() ?>>
<?php echo $bpeng->ps21->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->ps22->Visible) { // ps22 ?>
		<td data-name="ps22"<?php echo $bpeng->ps22->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_ps22" class="bpeng_ps22">
<span<?php echo $bpeng->ps22->ViewAttributes() ?>>
<?php echo $bpeng->ps22->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->ps23->Visible) { // ps23 ?>
		<td data-name="ps23"<?php echo $bpeng->ps23->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_ps23" class="bpeng_ps23">
<span<?php echo $bpeng->ps23->ViewAttributes() ?>>
<?php echo $bpeng->ps23->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->ps24->Visible) { // ps24 ?>
		<td data-name="ps24"<?php echo $bpeng->ps24->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_ps24" class="bpeng_ps24">
<span<?php echo $bpeng->ps24->ViewAttributes() ?>>
<?php echo $bpeng->ps24->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($bpeng->ps4->Visible) { // ps4 ?>
		<td data-name="ps4"<?php echo $bpeng->ps4->CellAttributes() ?>>
<span id="el<?php echo $bpeng_list->RowCnt ?>_bpeng_ps4" class="bpeng_ps4">
<span<?php echo $bpeng->ps4->ViewAttributes() ?>>
<?php echo $bpeng->ps4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$bpeng_list->ListOptions->Render("body", "right", $bpeng_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($bpeng->CurrentAction <> "gridadd")
		$bpeng_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($bpeng->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($bpeng_list->Recordset)
	$bpeng_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($bpeng->CurrentAction <> "gridadd" && $bpeng->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($bpeng_list->Pager)) $bpeng_list->Pager = new cPrevNextPager($bpeng_list->StartRec, $bpeng_list->DisplayRecs, $bpeng_list->TotalRecs) ?>
<?php if ($bpeng_list->Pager->RecordCount > 0 && $bpeng_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($bpeng_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $bpeng_list->PageUrl() ?>start=<?php echo $bpeng_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($bpeng_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $bpeng_list->PageUrl() ?>start=<?php echo $bpeng_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $bpeng_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($bpeng_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $bpeng_list->PageUrl() ?>start=<?php echo $bpeng_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($bpeng_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $bpeng_list->PageUrl() ?>start=<?php echo $bpeng_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $bpeng_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $bpeng_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $bpeng_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $bpeng_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($bpeng_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $bpeng_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="bpeng">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($bpeng_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($bpeng_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($bpeng_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($bpeng_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($bpeng_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($bpeng_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($bpeng_list->TotalRecs == 0 && $bpeng->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($bpeng_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fbpenglistsrch.FilterList = <?php echo $bpeng_list->GetFilterList() ?>;
fbpenglistsrch.Init();
fbpenglist.Init();
</script>
<?php
$bpeng_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$bpeng_list->Page_Terminate();
?>
