<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_login_list = NULL; // Initialize page object first

class cm_login_list extends cm_login {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_login';

	// Page object name
	var $PageObjName = 'm_login_list';

	// Grid form hidden field names
	var $FormName = 'fm_loginlist';
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

		// Table object (m_login)
		if (!isset($GLOBALS["m_login"]) || get_class($GLOBALS["m_login"]) == "cm_login") {
			$GLOBALS["m_login"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_login"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "m_loginadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "m_logindelete.php";
		$this->MultiUpdateUrl = "m_loginupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_login', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fm_loginlistsrch";

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
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate();
			}
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->NIP->SetVisibility();
		$this->DEPARTEMEN->SetVisibility();
		$this->pd_nickname->SetVisibility();
		$this->pd_avatar->SetVisibility();

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
		global $EW_EXPORT, $m_login;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_login);
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
		if (count($arrKeyFlds) >= 2) {
			$this->NIP->setFormValue($arrKeyFlds[0]);
			$this->id->setFormValue($arrKeyFlds[1]);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fm_loginlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->NIP->AdvancedSearch->ToJSON(), ","); // Field NIP
		$sFilterList = ew_Concat($sFilterList, $this->PWD->AdvancedSearch->ToJSON(), ","); // Field PWD
		$sFilterList = ew_Concat($sFilterList, $this->SES_REG->AdvancedSearch->ToJSON(), ","); // Field SES_REG
		$sFilterList = ew_Concat($sFilterList, $this->ROLES->AdvancedSearch->ToJSON(), ","); // Field ROLES
		$sFilterList = ew_Concat($sFilterList, $this->KDUNIT->AdvancedSearch->ToJSON(), ","); // Field KDUNIT
		$sFilterList = ew_Concat($sFilterList, $this->DEPARTEMEN->AdvancedSearch->ToJSON(), ","); // Field DEPARTEMEN
		$sFilterList = ew_Concat($sFilterList, $this->nama->AdvancedSearch->ToJSON(), ","); // Field nama
		$sFilterList = ew_Concat($sFilterList, $this->gambar->AdvancedSearch->ToJSON(), ","); // Field gambar
		$sFilterList = ew_Concat($sFilterList, $this->NIK->AdvancedSearch->ToJSON(), ","); // Field NIK
		$sFilterList = ew_Concat($sFilterList, $this->grup_ranap->AdvancedSearch->ToJSON(), ","); // Field grup_ranap
		$sFilterList = ew_Concat($sFilterList, $this->pd_nickname->AdvancedSearch->ToJSON(), ","); // Field pd_nickname
		$sFilterList = ew_Concat($sFilterList, $this->role_id->AdvancedSearch->ToJSON(), ","); // Field role_id
		$sFilterList = ew_Concat($sFilterList, $this->pd_avatar->AdvancedSearch->ToJSON(), ","); // Field pd_avatar
		$sFilterList = ew_Concat($sFilterList, $this->pd_datejoined->AdvancedSearch->ToJSON(), ","); // Field pd_datejoined
		$sFilterList = ew_Concat($sFilterList, $this->pd_parentid->AdvancedSearch->ToJSON(), ","); // Field pd_parentid
		$sFilterList = ew_Concat($sFilterList, $this->pd_email->AdvancedSearch->ToJSON(), ","); // Field pd_email
		$sFilterList = ew_Concat($sFilterList, $this->pd_activated->AdvancedSearch->ToJSON(), ","); // Field pd_activated
		$sFilterList = ew_Concat($sFilterList, $this->pd_profiletext->AdvancedSearch->ToJSON(), ","); // Field pd_profiletext
		$sFilterList = ew_Concat($sFilterList, $this->pd_title->AdvancedSearch->ToJSON(), ","); // Field pd_title
		$sFilterList = ew_Concat($sFilterList, $this->pd_ipaddr->AdvancedSearch->ToJSON(), ","); // Field pd_ipaddr
		$sFilterList = ew_Concat($sFilterList, $this->pd_useragent->AdvancedSearch->ToJSON(), ","); // Field pd_useragent
		$sFilterList = ew_Concat($sFilterList, $this->pd_online->AdvancedSearch->ToJSON(), ","); // Field pd_online
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fm_loginlistsrch", $filters);

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

		// Field NIP
		$this->NIP->AdvancedSearch->SearchValue = @$filter["x_NIP"];
		$this->NIP->AdvancedSearch->SearchOperator = @$filter["z_NIP"];
		$this->NIP->AdvancedSearch->SearchCondition = @$filter["v_NIP"];
		$this->NIP->AdvancedSearch->SearchValue2 = @$filter["y_NIP"];
		$this->NIP->AdvancedSearch->SearchOperator2 = @$filter["w_NIP"];
		$this->NIP->AdvancedSearch->Save();

		// Field PWD
		$this->PWD->AdvancedSearch->SearchValue = @$filter["x_PWD"];
		$this->PWD->AdvancedSearch->SearchOperator = @$filter["z_PWD"];
		$this->PWD->AdvancedSearch->SearchCondition = @$filter["v_PWD"];
		$this->PWD->AdvancedSearch->SearchValue2 = @$filter["y_PWD"];
		$this->PWD->AdvancedSearch->SearchOperator2 = @$filter["w_PWD"];
		$this->PWD->AdvancedSearch->Save();

		// Field SES_REG
		$this->SES_REG->AdvancedSearch->SearchValue = @$filter["x_SES_REG"];
		$this->SES_REG->AdvancedSearch->SearchOperator = @$filter["z_SES_REG"];
		$this->SES_REG->AdvancedSearch->SearchCondition = @$filter["v_SES_REG"];
		$this->SES_REG->AdvancedSearch->SearchValue2 = @$filter["y_SES_REG"];
		$this->SES_REG->AdvancedSearch->SearchOperator2 = @$filter["w_SES_REG"];
		$this->SES_REG->AdvancedSearch->Save();

		// Field ROLES
		$this->ROLES->AdvancedSearch->SearchValue = @$filter["x_ROLES"];
		$this->ROLES->AdvancedSearch->SearchOperator = @$filter["z_ROLES"];
		$this->ROLES->AdvancedSearch->SearchCondition = @$filter["v_ROLES"];
		$this->ROLES->AdvancedSearch->SearchValue2 = @$filter["y_ROLES"];
		$this->ROLES->AdvancedSearch->SearchOperator2 = @$filter["w_ROLES"];
		$this->ROLES->AdvancedSearch->Save();

		// Field KDUNIT
		$this->KDUNIT->AdvancedSearch->SearchValue = @$filter["x_KDUNIT"];
		$this->KDUNIT->AdvancedSearch->SearchOperator = @$filter["z_KDUNIT"];
		$this->KDUNIT->AdvancedSearch->SearchCondition = @$filter["v_KDUNIT"];
		$this->KDUNIT->AdvancedSearch->SearchValue2 = @$filter["y_KDUNIT"];
		$this->KDUNIT->AdvancedSearch->SearchOperator2 = @$filter["w_KDUNIT"];
		$this->KDUNIT->AdvancedSearch->Save();

		// Field DEPARTEMEN
		$this->DEPARTEMEN->AdvancedSearch->SearchValue = @$filter["x_DEPARTEMEN"];
		$this->DEPARTEMEN->AdvancedSearch->SearchOperator = @$filter["z_DEPARTEMEN"];
		$this->DEPARTEMEN->AdvancedSearch->SearchCondition = @$filter["v_DEPARTEMEN"];
		$this->DEPARTEMEN->AdvancedSearch->SearchValue2 = @$filter["y_DEPARTEMEN"];
		$this->DEPARTEMEN->AdvancedSearch->SearchOperator2 = @$filter["w_DEPARTEMEN"];
		$this->DEPARTEMEN->AdvancedSearch->Save();

		// Field nama
		$this->nama->AdvancedSearch->SearchValue = @$filter["x_nama"];
		$this->nama->AdvancedSearch->SearchOperator = @$filter["z_nama"];
		$this->nama->AdvancedSearch->SearchCondition = @$filter["v_nama"];
		$this->nama->AdvancedSearch->SearchValue2 = @$filter["y_nama"];
		$this->nama->AdvancedSearch->SearchOperator2 = @$filter["w_nama"];
		$this->nama->AdvancedSearch->Save();

		// Field gambar
		$this->gambar->AdvancedSearch->SearchValue = @$filter["x_gambar"];
		$this->gambar->AdvancedSearch->SearchOperator = @$filter["z_gambar"];
		$this->gambar->AdvancedSearch->SearchCondition = @$filter["v_gambar"];
		$this->gambar->AdvancedSearch->SearchValue2 = @$filter["y_gambar"];
		$this->gambar->AdvancedSearch->SearchOperator2 = @$filter["w_gambar"];
		$this->gambar->AdvancedSearch->Save();

		// Field NIK
		$this->NIK->AdvancedSearch->SearchValue = @$filter["x_NIK"];
		$this->NIK->AdvancedSearch->SearchOperator = @$filter["z_NIK"];
		$this->NIK->AdvancedSearch->SearchCondition = @$filter["v_NIK"];
		$this->NIK->AdvancedSearch->SearchValue2 = @$filter["y_NIK"];
		$this->NIK->AdvancedSearch->SearchOperator2 = @$filter["w_NIK"];
		$this->NIK->AdvancedSearch->Save();

		// Field grup_ranap
		$this->grup_ranap->AdvancedSearch->SearchValue = @$filter["x_grup_ranap"];
		$this->grup_ranap->AdvancedSearch->SearchOperator = @$filter["z_grup_ranap"];
		$this->grup_ranap->AdvancedSearch->SearchCondition = @$filter["v_grup_ranap"];
		$this->grup_ranap->AdvancedSearch->SearchValue2 = @$filter["y_grup_ranap"];
		$this->grup_ranap->AdvancedSearch->SearchOperator2 = @$filter["w_grup_ranap"];
		$this->grup_ranap->AdvancedSearch->Save();

		// Field pd_nickname
		$this->pd_nickname->AdvancedSearch->SearchValue = @$filter["x_pd_nickname"];
		$this->pd_nickname->AdvancedSearch->SearchOperator = @$filter["z_pd_nickname"];
		$this->pd_nickname->AdvancedSearch->SearchCondition = @$filter["v_pd_nickname"];
		$this->pd_nickname->AdvancedSearch->SearchValue2 = @$filter["y_pd_nickname"];
		$this->pd_nickname->AdvancedSearch->SearchOperator2 = @$filter["w_pd_nickname"];
		$this->pd_nickname->AdvancedSearch->Save();

		// Field role_id
		$this->role_id->AdvancedSearch->SearchValue = @$filter["x_role_id"];
		$this->role_id->AdvancedSearch->SearchOperator = @$filter["z_role_id"];
		$this->role_id->AdvancedSearch->SearchCondition = @$filter["v_role_id"];
		$this->role_id->AdvancedSearch->SearchValue2 = @$filter["y_role_id"];
		$this->role_id->AdvancedSearch->SearchOperator2 = @$filter["w_role_id"];
		$this->role_id->AdvancedSearch->Save();

		// Field pd_avatar
		$this->pd_avatar->AdvancedSearch->SearchValue = @$filter["x_pd_avatar"];
		$this->pd_avatar->AdvancedSearch->SearchOperator = @$filter["z_pd_avatar"];
		$this->pd_avatar->AdvancedSearch->SearchCondition = @$filter["v_pd_avatar"];
		$this->pd_avatar->AdvancedSearch->SearchValue2 = @$filter["y_pd_avatar"];
		$this->pd_avatar->AdvancedSearch->SearchOperator2 = @$filter["w_pd_avatar"];
		$this->pd_avatar->AdvancedSearch->Save();

		// Field pd_datejoined
		$this->pd_datejoined->AdvancedSearch->SearchValue = @$filter["x_pd_datejoined"];
		$this->pd_datejoined->AdvancedSearch->SearchOperator = @$filter["z_pd_datejoined"];
		$this->pd_datejoined->AdvancedSearch->SearchCondition = @$filter["v_pd_datejoined"];
		$this->pd_datejoined->AdvancedSearch->SearchValue2 = @$filter["y_pd_datejoined"];
		$this->pd_datejoined->AdvancedSearch->SearchOperator2 = @$filter["w_pd_datejoined"];
		$this->pd_datejoined->AdvancedSearch->Save();

		// Field pd_parentid
		$this->pd_parentid->AdvancedSearch->SearchValue = @$filter["x_pd_parentid"];
		$this->pd_parentid->AdvancedSearch->SearchOperator = @$filter["z_pd_parentid"];
		$this->pd_parentid->AdvancedSearch->SearchCondition = @$filter["v_pd_parentid"];
		$this->pd_parentid->AdvancedSearch->SearchValue2 = @$filter["y_pd_parentid"];
		$this->pd_parentid->AdvancedSearch->SearchOperator2 = @$filter["w_pd_parentid"];
		$this->pd_parentid->AdvancedSearch->Save();

		// Field pd_email
		$this->pd_email->AdvancedSearch->SearchValue = @$filter["x_pd_email"];
		$this->pd_email->AdvancedSearch->SearchOperator = @$filter["z_pd_email"];
		$this->pd_email->AdvancedSearch->SearchCondition = @$filter["v_pd_email"];
		$this->pd_email->AdvancedSearch->SearchValue2 = @$filter["y_pd_email"];
		$this->pd_email->AdvancedSearch->SearchOperator2 = @$filter["w_pd_email"];
		$this->pd_email->AdvancedSearch->Save();

		// Field pd_activated
		$this->pd_activated->AdvancedSearch->SearchValue = @$filter["x_pd_activated"];
		$this->pd_activated->AdvancedSearch->SearchOperator = @$filter["z_pd_activated"];
		$this->pd_activated->AdvancedSearch->SearchCondition = @$filter["v_pd_activated"];
		$this->pd_activated->AdvancedSearch->SearchValue2 = @$filter["y_pd_activated"];
		$this->pd_activated->AdvancedSearch->SearchOperator2 = @$filter["w_pd_activated"];
		$this->pd_activated->AdvancedSearch->Save();

		// Field pd_profiletext
		$this->pd_profiletext->AdvancedSearch->SearchValue = @$filter["x_pd_profiletext"];
		$this->pd_profiletext->AdvancedSearch->SearchOperator = @$filter["z_pd_profiletext"];
		$this->pd_profiletext->AdvancedSearch->SearchCondition = @$filter["v_pd_profiletext"];
		$this->pd_profiletext->AdvancedSearch->SearchValue2 = @$filter["y_pd_profiletext"];
		$this->pd_profiletext->AdvancedSearch->SearchOperator2 = @$filter["w_pd_profiletext"];
		$this->pd_profiletext->AdvancedSearch->Save();

		// Field pd_title
		$this->pd_title->AdvancedSearch->SearchValue = @$filter["x_pd_title"];
		$this->pd_title->AdvancedSearch->SearchOperator = @$filter["z_pd_title"];
		$this->pd_title->AdvancedSearch->SearchCondition = @$filter["v_pd_title"];
		$this->pd_title->AdvancedSearch->SearchValue2 = @$filter["y_pd_title"];
		$this->pd_title->AdvancedSearch->SearchOperator2 = @$filter["w_pd_title"];
		$this->pd_title->AdvancedSearch->Save();

		// Field pd_ipaddr
		$this->pd_ipaddr->AdvancedSearch->SearchValue = @$filter["x_pd_ipaddr"];
		$this->pd_ipaddr->AdvancedSearch->SearchOperator = @$filter["z_pd_ipaddr"];
		$this->pd_ipaddr->AdvancedSearch->SearchCondition = @$filter["v_pd_ipaddr"];
		$this->pd_ipaddr->AdvancedSearch->SearchValue2 = @$filter["y_pd_ipaddr"];
		$this->pd_ipaddr->AdvancedSearch->SearchOperator2 = @$filter["w_pd_ipaddr"];
		$this->pd_ipaddr->AdvancedSearch->Save();

		// Field pd_useragent
		$this->pd_useragent->AdvancedSearch->SearchValue = @$filter["x_pd_useragent"];
		$this->pd_useragent->AdvancedSearch->SearchOperator = @$filter["z_pd_useragent"];
		$this->pd_useragent->AdvancedSearch->SearchCondition = @$filter["v_pd_useragent"];
		$this->pd_useragent->AdvancedSearch->SearchValue2 = @$filter["y_pd_useragent"];
		$this->pd_useragent->AdvancedSearch->SearchOperator2 = @$filter["w_pd_useragent"];
		$this->pd_useragent->AdvancedSearch->Save();

		// Field pd_online
		$this->pd_online->AdvancedSearch->SearchValue = @$filter["x_pd_online"];
		$this->pd_online->AdvancedSearch->SearchOperator = @$filter["z_pd_online"];
		$this->pd_online->AdvancedSearch->SearchCondition = @$filter["v_pd_online"];
		$this->pd_online->AdvancedSearch->SearchValue2 = @$filter["y_pd_online"];
		$this->pd_online->AdvancedSearch->SearchOperator2 = @$filter["w_pd_online"];
		$this->pd_online->AdvancedSearch->Save();

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NIP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->PWD, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->SES_REG, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DEPARTEMEN, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->gambar, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NIK, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pd_nickname, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pd_avatar, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pd_email, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pd_profiletext, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pd_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pd_ipaddr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->pd_useragent, $arKeywords, $type);
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
			$this->UpdateSort($this->NIP, $bCtrl); // NIP
			$this->UpdateSort($this->DEPARTEMEN, $bCtrl); // DEPARTEMEN
			$this->UpdateSort($this->pd_nickname, $bCtrl); // pd_nickname
			$this->UpdateSort($this->pd_avatar, $bCtrl); // pd_avatar
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
				$this->NIP->setSort("");
				$this->DEPARTEMEN->setSort("");
				$this->pd_nickname->setSort("");
				$this->pd_avatar->setSort("");
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
		if ($Security->CanView() && $this->ShowOptionLink('view')) {
			$oListOpt->Body = "<a class=\"btn btn-info btn-xs\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") ." ". $viewcaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit() && $this->ShowOptionLink('edit')) {
			$oListOpt->Body = "<a class=\"btn btn-warning btn-xs\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") ." ". $editcaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd() && $this->ShowOptionLink('add')) {
			$oListOpt->Body = "<a class=\"btn btn-success btn-xs\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") ." ". $copycaption . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete() && $this->ShowOptionLink('delete'))
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
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->NIP->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fm_loginlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fm_loginlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fm_loginlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
					$user = $row['NIP'];
					if ($userlist <> "") $userlist .= ",";
					$userlist .= $user;
					if ($UserAction == "resendregisteremail")
						$Processed = FALSE;
					elseif ($UserAction == "resetconcurrentuser")
						$Processed = FALSE;
					elseif ($UserAction == "resetloginretry")
						$Processed = FALSE;
					elseif ($UserAction == "setpasswordexpired")
						$Processed = FALSE;
					else
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fm_loginlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->PWD->setDbValue($rs->fields('PWD'));
		$this->SES_REG->setDbValue($rs->fields('SES_REG'));
		$this->ROLES->setDbValue($rs->fields('ROLES'));
		$this->KDUNIT->setDbValue($rs->fields('KDUNIT'));
		$this->DEPARTEMEN->setDbValue($rs->fields('DEPARTEMEN'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->gambar->setDbValue($rs->fields('gambar'));
		$this->NIK->setDbValue($rs->fields('NIK'));
		$this->grup_ranap->setDbValue($rs->fields('grup_ranap'));
		$this->pd_nickname->setDbValue($rs->fields('pd_nickname'));
		$this->role_id->setDbValue($rs->fields('role_id'));
		$this->pd_avatar->Upload->DbValue = $rs->fields('pd_avatar');
		$this->pd_avatar->CurrentValue = $this->pd_avatar->Upload->DbValue;
		$this->pd_datejoined->setDbValue($rs->fields('pd_datejoined'));
		$this->pd_parentid->setDbValue($rs->fields('pd_parentid'));
		$this->pd_email->setDbValue($rs->fields('pd_email'));
		$this->pd_activated->setDbValue($rs->fields('pd_activated'));
		$this->pd_profiletext->setDbValue($rs->fields('pd_profiletext'));
		$this->pd_title->setDbValue($rs->fields('pd_title'));
		$this->pd_ipaddr->setDbValue($rs->fields('pd_ipaddr'));
		$this->pd_useragent->setDbValue($rs->fields('pd_useragent'));
		$this->pd_online->setDbValue($rs->fields('pd_online'));
		$this->id->setDbValue($rs->fields('id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NIP->DbValue = $row['NIP'];
		$this->PWD->DbValue = $row['PWD'];
		$this->SES_REG->DbValue = $row['SES_REG'];
		$this->ROLES->DbValue = $row['ROLES'];
		$this->KDUNIT->DbValue = $row['KDUNIT'];
		$this->DEPARTEMEN->DbValue = $row['DEPARTEMEN'];
		$this->nama->DbValue = $row['nama'];
		$this->gambar->DbValue = $row['gambar'];
		$this->NIK->DbValue = $row['NIK'];
		$this->grup_ranap->DbValue = $row['grup_ranap'];
		$this->pd_nickname->DbValue = $row['pd_nickname'];
		$this->role_id->DbValue = $row['role_id'];
		$this->pd_avatar->Upload->DbValue = $row['pd_avatar'];
		$this->pd_datejoined->DbValue = $row['pd_datejoined'];
		$this->pd_parentid->DbValue = $row['pd_parentid'];
		$this->pd_email->DbValue = $row['pd_email'];
		$this->pd_activated->DbValue = $row['pd_activated'];
		$this->pd_profiletext->DbValue = $row['pd_profiletext'];
		$this->pd_title->DbValue = $row['pd_title'];
		$this->pd_ipaddr->DbValue = $row['pd_ipaddr'];
		$this->pd_useragent->DbValue = $row['pd_useragent'];
		$this->pd_online->DbValue = $row['pd_online'];
		$this->id->DbValue = $row['id'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("NIP")) <> "")
			$this->NIP->CurrentValue = $this->getKey("NIP"); // NIP
		else
			$bValidKey = FALSE;
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
		// NIP
		// PWD
		// SES_REG
		// ROLES
		// KDUNIT
		// DEPARTEMEN
		// nama
		// gambar
		// NIK
		// grup_ranap
		// pd_nickname
		// role_id
		// pd_avatar
		// pd_datejoined
		// pd_parentid
		// pd_email
		// pd_activated
		// pd_profiletext
		// pd_title
		// pd_ipaddr
		// pd_useragent
		// pd_online
		// id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// PWD
		$this->PWD->ViewValue = $this->PWD->CurrentValue;
		$this->PWD->ViewCustomAttributes = "";

		// SES_REG
		$this->SES_REG->ViewValue = $this->SES_REG->CurrentValue;
		$this->SES_REG->ViewCustomAttributes = "";

		// ROLES
		$this->ROLES->ViewValue = $this->ROLES->CurrentValue;
		$this->ROLES->ViewCustomAttributes = "";

		// KDUNIT
		$this->KDUNIT->ViewValue = $this->KDUNIT->CurrentValue;
		$this->KDUNIT->ViewCustomAttributes = "";

		// DEPARTEMEN
		$this->DEPARTEMEN->ViewValue = $this->DEPARTEMEN->CurrentValue;
		$this->DEPARTEMEN->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// gambar
		$this->gambar->ViewValue = $this->gambar->CurrentValue;
		$this->gambar->ViewCustomAttributes = "";

		// NIK
		$this->NIK->ViewValue = $this->NIK->CurrentValue;
		$this->NIK->ViewCustomAttributes = "";

		// grup_ranap
		$this->grup_ranap->ViewValue = $this->grup_ranap->CurrentValue;
		$this->grup_ranap->ViewCustomAttributes = "";

		// pd_nickname
		$this->pd_nickname->ViewValue = $this->pd_nickname->CurrentValue;
		$this->pd_nickname->ViewCustomAttributes = "";

		// role_id
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->role_id->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->role_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->role_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->role_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->role_id->ViewValue = $this->role_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->role_id->ViewValue = $this->role_id->CurrentValue;
			}
		} else {
			$this->role_id->ViewValue = NULL;
		}
		} else {
			$this->role_id->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->role_id->ViewCustomAttributes = "";

		// pd_avatar
		if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
			$this->pd_avatar->ImageWidth = 50;
			$this->pd_avatar->ImageHeight = 50;
			$this->pd_avatar->ImageAlt = $this->pd_avatar->FldAlt();
			$this->pd_avatar->ViewValue = $this->pd_avatar->Upload->DbValue;
		} else {
			$this->pd_avatar->ViewValue = "";
		}
		$this->pd_avatar->ViewCustomAttributes = " class = 'img-circle' ";

		// pd_datejoined
		$this->pd_datejoined->ViewValue = $this->pd_datejoined->CurrentValue;
		$this->pd_datejoined->ViewValue = ew_FormatDateTime($this->pd_datejoined->ViewValue, 0);
		$this->pd_datejoined->ViewCustomAttributes = "";

		// pd_parentid
		$this->pd_parentid->ViewValue = $this->pd_parentid->CurrentValue;
		$this->pd_parentid->ViewCustomAttributes = "";

		// pd_email
		$this->pd_email->ViewValue = $this->pd_email->CurrentValue;
		$this->pd_email->ViewCustomAttributes = "";

		// pd_activated
		$this->pd_activated->ViewValue = $this->pd_activated->CurrentValue;
		$this->pd_activated->ViewCustomAttributes = "";

		// pd_title
		$this->pd_title->ViewValue = $this->pd_title->CurrentValue;
		$this->pd_title->ViewCustomAttributes = "";

		// pd_ipaddr
		$this->pd_ipaddr->ViewValue = $this->pd_ipaddr->CurrentValue;
		$this->pd_ipaddr->ViewCustomAttributes = "";

		// pd_useragent
		$this->pd_useragent->ViewValue = $this->pd_useragent->CurrentValue;
		$this->pd_useragent->ViewCustomAttributes = "";

		// pd_online
		$this->pd_online->ViewValue = $this->pd_online->CurrentValue;
		$this->pd_online->ViewCustomAttributes = "";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// DEPARTEMEN
			$this->DEPARTEMEN->LinkCustomAttributes = "";
			$this->DEPARTEMEN->HrefValue = "";
			$this->DEPARTEMEN->TooltipValue = "";

			// pd_nickname
			$this->pd_nickname->LinkCustomAttributes = "";
			$this->pd_nickname->HrefValue = "";
			$this->pd_nickname->TooltipValue = "";

			// pd_avatar
			$this->pd_avatar->LinkCustomAttributes = "";
			if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
				$this->pd_avatar->HrefValue = ew_GetFileUploadUrl($this->pd_avatar, $this->pd_avatar->Upload->DbValue); // Add prefix/suffix
				$this->pd_avatar->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->pd_avatar->HrefValue = ew_ConvertFullUrl($this->pd_avatar->HrefValue);
			} else {
				$this->pd_avatar->HrefValue = "";
			}
			$this->pd_avatar->HrefValue2 = $this->pd_avatar->UploadPath . $this->pd_avatar->Upload->DbValue;
			$this->pd_avatar->TooltipValue = "";
			if ($this->pd_avatar->UseColorbox) {
				if (ew_Empty($this->pd_avatar->TooltipValue))
					$this->pd_avatar->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->pd_avatar->LinkAttrs["data-rel"] = "m_login_x" . $this->RowCnt . "_pd_avatar";
				ew_AppendClass($this->pd_avatar->LinkAttrs["class"], "ewLightbox");
			}
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->id->CurrentValue);
		return TRUE;
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
if (!isset($m_login_list)) $m_login_list = new cm_login_list();

// Page init
$m_login_list->Page_Init();

// Page main
$m_login_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_login_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fm_loginlist = new ew_Form("fm_loginlist", "list");
fm_loginlist.FormKeyCountName = '<?php echo $m_login_list->FormKeyCountName ?>';

// Form_CustomValidate event
fm_loginlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_loginlist.ValidateRequired = true;
<?php } else { ?>
fm_loginlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fm_loginlistsrch = new ew_Form("fm_loginlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($m_login_list->TotalRecs > 0 && $m_login_list->ExportOptions->Visible()) { ?>
<?php $m_login_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($m_login_list->SearchOptions->Visible()) { ?>
<?php $m_login_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($m_login_list->FilterOptions->Visible()) { ?>
<?php $m_login_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $m_login_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($m_login_list->TotalRecs <= 0)
			$m_login_list->TotalRecs = $m_login->SelectRecordCount();
	} else {
		if (!$m_login_list->Recordset && ($m_login_list->Recordset = $m_login_list->LoadRecordset()))
			$m_login_list->TotalRecs = $m_login_list->Recordset->RecordCount();
	}
	$m_login_list->StartRec = 1;
	if ($m_login_list->DisplayRecs <= 0 || ($m_login->Export <> "" && $m_login->ExportAll)) // Display all records
		$m_login_list->DisplayRecs = $m_login_list->TotalRecs;
	if (!($m_login->Export <> "" && $m_login->ExportAll))
		$m_login_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$m_login_list->Recordset = $m_login_list->LoadRecordset($m_login_list->StartRec-1, $m_login_list->DisplayRecs);

	// Set no record found message
	if ($m_login->CurrentAction == "" && $m_login_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$m_login_list->setWarningMessage(ew_DeniedMsg());
		if ($m_login_list->SearchWhere == "0=101")
			$m_login_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$m_login_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($m_login_list->AuditTrailOnSearch && $m_login_list->Command == "search" && !$m_login_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $m_login_list->getSessionWhere();
		$m_login_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$m_login_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($m_login->Export == "" && $m_login->CurrentAction == "") { ?>
<form name="fm_loginlistsrch" id="fm_loginlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($m_login_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fm_loginlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="m_login">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($m_login_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($m_login_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $m_login_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($m_login_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($m_login_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($m_login_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($m_login_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $m_login_list->ShowPageHeader(); ?>
<?php
$m_login_list->ShowMessage();
?>
<?php if ($m_login_list->TotalRecs > 0 || $m_login->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid m_login">
<form name="fm_loginlist" id="fm_loginlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_login_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_login_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_login">
<div id="gmp_m_login" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($m_login_list->TotalRecs > 0 || $m_login->CurrentAction == "gridedit") { ?>
<table id="tbl_m_loginlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_login->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$m_login_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$m_login_list->RenderListOptions();

// Render list options (header, left)
$m_login_list->ListOptions->Render("header", "left");
?>
<?php if ($m_login->NIP->Visible) { // NIP ?>
	<?php if ($m_login->SortUrl($m_login->NIP) == "") { ?>
		<th data-name="NIP"><div id="elh_m_login_NIP" class="m_login_NIP"><div class="ewTableHeaderCaption"><?php echo $m_login->NIP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NIP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_login->SortUrl($m_login->NIP) ?>',2);"><div id="elh_m_login_NIP" class="m_login_NIP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_login->NIP->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_login->NIP->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_login->NIP->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_login->DEPARTEMEN->Visible) { // DEPARTEMEN ?>
	<?php if ($m_login->SortUrl($m_login->DEPARTEMEN) == "") { ?>
		<th data-name="DEPARTEMEN"><div id="elh_m_login_DEPARTEMEN" class="m_login_DEPARTEMEN"><div class="ewTableHeaderCaption"><?php echo $m_login->DEPARTEMEN->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DEPARTEMEN"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_login->SortUrl($m_login->DEPARTEMEN) ?>',2);"><div id="elh_m_login_DEPARTEMEN" class="m_login_DEPARTEMEN">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_login->DEPARTEMEN->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_login->DEPARTEMEN->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_login->DEPARTEMEN->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_login->pd_nickname->Visible) { // pd_nickname ?>
	<?php if ($m_login->SortUrl($m_login->pd_nickname) == "") { ?>
		<th data-name="pd_nickname"><div id="elh_m_login_pd_nickname" class="m_login_pd_nickname"><div class="ewTableHeaderCaption"><?php echo $m_login->pd_nickname->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pd_nickname"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_login->SortUrl($m_login->pd_nickname) ?>',2);"><div id="elh_m_login_pd_nickname" class="m_login_pd_nickname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_login->pd_nickname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_login->pd_nickname->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_login->pd_nickname->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_login->pd_avatar->Visible) { // pd_avatar ?>
	<?php if ($m_login->SortUrl($m_login->pd_avatar) == "") { ?>
		<th data-name="pd_avatar"><div id="elh_m_login_pd_avatar" class="m_login_pd_avatar"><div class="ewTableHeaderCaption"><?php echo $m_login->pd_avatar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pd_avatar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_login->SortUrl($m_login->pd_avatar) ?>',2);"><div id="elh_m_login_pd_avatar" class="m_login_pd_avatar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_login->pd_avatar->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_login->pd_avatar->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_login->pd_avatar->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$m_login_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($m_login->ExportAll && $m_login->Export <> "") {
	$m_login_list->StopRec = $m_login_list->TotalRecs;
} else {

	// Set the last record to display
	if ($m_login_list->TotalRecs > $m_login_list->StartRec + $m_login_list->DisplayRecs - 1)
		$m_login_list->StopRec = $m_login_list->StartRec + $m_login_list->DisplayRecs - 1;
	else
		$m_login_list->StopRec = $m_login_list->TotalRecs;
}
$m_login_list->RecCnt = $m_login_list->StartRec - 1;
if ($m_login_list->Recordset && !$m_login_list->Recordset->EOF) {
	$m_login_list->Recordset->MoveFirst();
	$bSelectLimit = $m_login_list->UseSelectLimit;
	if (!$bSelectLimit && $m_login_list->StartRec > 1)
		$m_login_list->Recordset->Move($m_login_list->StartRec - 1);
} elseif (!$m_login->AllowAddDeleteRow && $m_login_list->StopRec == 0) {
	$m_login_list->StopRec = $m_login->GridAddRowCount;
}

// Initialize aggregate
$m_login->RowType = EW_ROWTYPE_AGGREGATEINIT;
$m_login->ResetAttrs();
$m_login_list->RenderRow();
while ($m_login_list->RecCnt < $m_login_list->StopRec) {
	$m_login_list->RecCnt++;
	if (intval($m_login_list->RecCnt) >= intval($m_login_list->StartRec)) {
		$m_login_list->RowCnt++;

		// Set up key count
		$m_login_list->KeyCount = $m_login_list->RowIndex;

		// Init row class and style
		$m_login->ResetAttrs();
		$m_login->CssClass = "";
		if ($m_login->CurrentAction == "gridadd") {
		} else {
			$m_login_list->LoadRowValues($m_login_list->Recordset); // Load row values
		}
		$m_login->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$m_login->RowAttrs = array_merge($m_login->RowAttrs, array('data-rowindex'=>$m_login_list->RowCnt, 'id'=>'r' . $m_login_list->RowCnt . '_m_login', 'data-rowtype'=>$m_login->RowType));

		// Render row
		$m_login_list->RenderRow();

		// Render list options
		$m_login_list->RenderListOptions();
?>
	<tr<?php echo $m_login->RowAttributes() ?>>
<?php

// Render list options (body, left)
$m_login_list->ListOptions->Render("body", "left", $m_login_list->RowCnt);
?>
	<?php if ($m_login->NIP->Visible) { // NIP ?>
		<td data-name="NIP"<?php echo $m_login->NIP->CellAttributes() ?>>
<span id="el<?php echo $m_login_list->RowCnt ?>_m_login_NIP" class="m_login_NIP">
<span<?php echo $m_login->NIP->ViewAttributes() ?>>
<?php echo $m_login->NIP->ListViewValue() ?></span>
</span>
<a id="<?php echo $m_login_list->PageObjName . "_row_" . $m_login_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($m_login->DEPARTEMEN->Visible) { // DEPARTEMEN ?>
		<td data-name="DEPARTEMEN"<?php echo $m_login->DEPARTEMEN->CellAttributes() ?>>
<span id="el<?php echo $m_login_list->RowCnt ?>_m_login_DEPARTEMEN" class="m_login_DEPARTEMEN">
<span<?php echo $m_login->DEPARTEMEN->ViewAttributes() ?>>
<?php echo $m_login->DEPARTEMEN->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_login->pd_nickname->Visible) { // pd_nickname ?>
		<td data-name="pd_nickname"<?php echo $m_login->pd_nickname->CellAttributes() ?>>
<span id="el<?php echo $m_login_list->RowCnt ?>_m_login_pd_nickname" class="m_login_pd_nickname">
<span<?php echo $m_login->pd_nickname->ViewAttributes() ?>>
<?php echo $m_login->pd_nickname->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_login->pd_avatar->Visible) { // pd_avatar ?>
		<td data-name="pd_avatar"<?php echo $m_login->pd_avatar->CellAttributes() ?>>
<span id="el<?php echo $m_login_list->RowCnt ?>_m_login_pd_avatar" class="m_login_pd_avatar">
<span>
<?php echo ew_GetFileViewTag($m_login->pd_avatar, $m_login->pd_avatar->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$m_login_list->ListOptions->Render("body", "right", $m_login_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($m_login->CurrentAction <> "gridadd")
		$m_login_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($m_login->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($m_login_list->Recordset)
	$m_login_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($m_login->CurrentAction <> "gridadd" && $m_login->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($m_login_list->Pager)) $m_login_list->Pager = new cPrevNextPager($m_login_list->StartRec, $m_login_list->DisplayRecs, $m_login_list->TotalRecs) ?>
<?php if ($m_login_list->Pager->RecordCount > 0 && $m_login_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($m_login_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $m_login_list->PageUrl() ?>start=<?php echo $m_login_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($m_login_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $m_login_list->PageUrl() ?>start=<?php echo $m_login_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $m_login_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($m_login_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $m_login_list->PageUrl() ?>start=<?php echo $m_login_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($m_login_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $m_login_list->PageUrl() ?>start=<?php echo $m_login_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $m_login_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $m_login_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $m_login_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $m_login_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($m_login_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $m_login_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="m_login">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($m_login_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($m_login_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($m_login_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($m_login_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($m_login_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_login_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($m_login_list->TotalRecs == 0 && $m_login->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_login_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fm_loginlistsrch.FilterList = <?php echo $m_login_list->GetFilterList() ?>;
fm_loginlistsrch.Init();
fm_loginlist.Init();
</script>
<?php
$m_login_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_login_list->Page_Terminate();
?>
