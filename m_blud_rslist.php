<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_blud_rsinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_blud_rs_list = NULL; // Initialize page object first

class cm_blud_rs_list extends cm_blud_rs {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_blud_rs';

	// Page object name
	var $PageObjName = 'm_blud_rs_list';

	// Grid form hidden field names
	var $FormName = 'fm_blud_rslist';
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

		// Table object (m_blud_rs)
		if (!isset($GLOBALS["m_blud_rs"]) || get_class($GLOBALS["m_blud_rs"]) == "cm_blud_rs") {
			$GLOBALS["m_blud_rs"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_blud_rs"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "m_blud_rsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "m_blud_rsdelete.php";
		$this->MultiUpdateUrl = "m_blud_rsupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_blud_rs', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fm_blud_rslistsrch";

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
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->direktur->SetVisibility();
		$this->nip->SetVisibility();
		$this->jabatan_keuangan->SetVisibility();
		$this->rekening->SetVisibility();
		$this->nomer_rekening->SetVisibility();
		$this->npwp->SetVisibility();
		$this->bendahara_keuangan->SetVisibility();
		$this->nip_bendahara_keuangan->SetVisibility();

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
		global $EW_EXPORT, $m_blud_rs;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_blud_rs);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fm_blud_rslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->direktur->AdvancedSearch->ToJSON(), ","); // Field direktur
		$sFilterList = ew_Concat($sFilterList, $this->nip->AdvancedSearch->ToJSON(), ","); // Field nip
		$sFilterList = ew_Concat($sFilterList, $this->jabatan_keuangan->AdvancedSearch->ToJSON(), ","); // Field jabatan_keuangan
		$sFilterList = ew_Concat($sFilterList, $this->rekening->AdvancedSearch->ToJSON(), ","); // Field rekening
		$sFilterList = ew_Concat($sFilterList, $this->nomer_rekening->AdvancedSearch->ToJSON(), ","); // Field nomer_rekening
		$sFilterList = ew_Concat($sFilterList, $this->npwp->AdvancedSearch->ToJSON(), ","); // Field npwp
		$sFilterList = ew_Concat($sFilterList, $this->bendahara_keuangan->AdvancedSearch->ToJSON(), ","); // Field bendahara_keuangan
		$sFilterList = ew_Concat($sFilterList, $this->nip_bendahara_keuangan->AdvancedSearch->ToJSON(), ","); // Field nip_bendahara_keuangan
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fm_blud_rslistsrch", $filters);

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

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field direktur
		$this->direktur->AdvancedSearch->SearchValue = @$filter["x_direktur"];
		$this->direktur->AdvancedSearch->SearchOperator = @$filter["z_direktur"];
		$this->direktur->AdvancedSearch->SearchCondition = @$filter["v_direktur"];
		$this->direktur->AdvancedSearch->SearchValue2 = @$filter["y_direktur"];
		$this->direktur->AdvancedSearch->SearchOperator2 = @$filter["w_direktur"];
		$this->direktur->AdvancedSearch->Save();

		// Field nip
		$this->nip->AdvancedSearch->SearchValue = @$filter["x_nip"];
		$this->nip->AdvancedSearch->SearchOperator = @$filter["z_nip"];
		$this->nip->AdvancedSearch->SearchCondition = @$filter["v_nip"];
		$this->nip->AdvancedSearch->SearchValue2 = @$filter["y_nip"];
		$this->nip->AdvancedSearch->SearchOperator2 = @$filter["w_nip"];
		$this->nip->AdvancedSearch->Save();

		// Field jabatan_keuangan
		$this->jabatan_keuangan->AdvancedSearch->SearchValue = @$filter["x_jabatan_keuangan"];
		$this->jabatan_keuangan->AdvancedSearch->SearchOperator = @$filter["z_jabatan_keuangan"];
		$this->jabatan_keuangan->AdvancedSearch->SearchCondition = @$filter["v_jabatan_keuangan"];
		$this->jabatan_keuangan->AdvancedSearch->SearchValue2 = @$filter["y_jabatan_keuangan"];
		$this->jabatan_keuangan->AdvancedSearch->SearchOperator2 = @$filter["w_jabatan_keuangan"];
		$this->jabatan_keuangan->AdvancedSearch->Save();

		// Field rekening
		$this->rekening->AdvancedSearch->SearchValue = @$filter["x_rekening"];
		$this->rekening->AdvancedSearch->SearchOperator = @$filter["z_rekening"];
		$this->rekening->AdvancedSearch->SearchCondition = @$filter["v_rekening"];
		$this->rekening->AdvancedSearch->SearchValue2 = @$filter["y_rekening"];
		$this->rekening->AdvancedSearch->SearchOperator2 = @$filter["w_rekening"];
		$this->rekening->AdvancedSearch->Save();

		// Field nomer_rekening
		$this->nomer_rekening->AdvancedSearch->SearchValue = @$filter["x_nomer_rekening"];
		$this->nomer_rekening->AdvancedSearch->SearchOperator = @$filter["z_nomer_rekening"];
		$this->nomer_rekening->AdvancedSearch->SearchCondition = @$filter["v_nomer_rekening"];
		$this->nomer_rekening->AdvancedSearch->SearchValue2 = @$filter["y_nomer_rekening"];
		$this->nomer_rekening->AdvancedSearch->SearchOperator2 = @$filter["w_nomer_rekening"];
		$this->nomer_rekening->AdvancedSearch->Save();

		// Field npwp
		$this->npwp->AdvancedSearch->SearchValue = @$filter["x_npwp"];
		$this->npwp->AdvancedSearch->SearchOperator = @$filter["z_npwp"];
		$this->npwp->AdvancedSearch->SearchCondition = @$filter["v_npwp"];
		$this->npwp->AdvancedSearch->SearchValue2 = @$filter["y_npwp"];
		$this->npwp->AdvancedSearch->SearchOperator2 = @$filter["w_npwp"];
		$this->npwp->AdvancedSearch->Save();

		// Field bendahara_keuangan
		$this->bendahara_keuangan->AdvancedSearch->SearchValue = @$filter["x_bendahara_keuangan"];
		$this->bendahara_keuangan->AdvancedSearch->SearchOperator = @$filter["z_bendahara_keuangan"];
		$this->bendahara_keuangan->AdvancedSearch->SearchCondition = @$filter["v_bendahara_keuangan"];
		$this->bendahara_keuangan->AdvancedSearch->SearchValue2 = @$filter["y_bendahara_keuangan"];
		$this->bendahara_keuangan->AdvancedSearch->SearchOperator2 = @$filter["w_bendahara_keuangan"];
		$this->bendahara_keuangan->AdvancedSearch->Save();

		// Field nip_bendahara_keuangan
		$this->nip_bendahara_keuangan->AdvancedSearch->SearchValue = @$filter["x_nip_bendahara_keuangan"];
		$this->nip_bendahara_keuangan->AdvancedSearch->SearchOperator = @$filter["z_nip_bendahara_keuangan"];
		$this->nip_bendahara_keuangan->AdvancedSearch->SearchCondition = @$filter["v_nip_bendahara_keuangan"];
		$this->nip_bendahara_keuangan->AdvancedSearch->SearchValue2 = @$filter["y_nip_bendahara_keuangan"];
		$this->nip_bendahara_keuangan->AdvancedSearch->SearchOperator2 = @$filter["w_nip_bendahara_keuangan"];
		$this->nip_bendahara_keuangan->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->direktur, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nip, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->jabatan_keuangan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->rekening, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomer_rekening, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->npwp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bendahara_keuangan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nip_bendahara_keuangan, $arKeywords, $type);
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
			$this->UpdateSort($this->id, $bCtrl); // id
			$this->UpdateSort($this->direktur, $bCtrl); // direktur
			$this->UpdateSort($this->nip, $bCtrl); // nip
			$this->UpdateSort($this->jabatan_keuangan, $bCtrl); // jabatan_keuangan
			$this->UpdateSort($this->rekening, $bCtrl); // rekening
			$this->UpdateSort($this->nomer_rekening, $bCtrl); // nomer_rekening
			$this->UpdateSort($this->npwp, $bCtrl); // npwp
			$this->UpdateSort($this->bendahara_keuangan, $bCtrl); // bendahara_keuangan
			$this->UpdateSort($this->nip_bendahara_keuangan, $bCtrl); // nip_bendahara_keuangan
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
				$this->id->setSort("");
				$this->direktur->setSort("");
				$this->nip->setSort("");
				$this->jabatan_keuangan->setSort("");
				$this->rekening->setSort("");
				$this->nomer_rekening->setSort("");
				$this->npwp->setSort("");
				$this->bendahara_keuangan->setSort("");
				$this->nip_bendahara_keuangan->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fm_blud_rslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fm_blud_rslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fm_blud_rslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fm_blud_rslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->id->setDbValue($rs->fields('id'));
		$this->direktur->setDbValue($rs->fields('direktur'));
		$this->nip->setDbValue($rs->fields('nip'));
		$this->jabatan_keuangan->setDbValue($rs->fields('jabatan_keuangan'));
		$this->rekening->setDbValue($rs->fields('rekening'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->bendahara_keuangan->setDbValue($rs->fields('bendahara_keuangan'));
		$this->nip_bendahara_keuangan->setDbValue($rs->fields('nip_bendahara_keuangan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->direktur->DbValue = $row['direktur'];
		$this->nip->DbValue = $row['nip'];
		$this->jabatan_keuangan->DbValue = $row['jabatan_keuangan'];
		$this->rekening->DbValue = $row['rekening'];
		$this->nomer_rekening->DbValue = $row['nomer_rekening'];
		$this->npwp->DbValue = $row['npwp'];
		$this->bendahara_keuangan->DbValue = $row['bendahara_keuangan'];
		$this->nip_bendahara_keuangan->DbValue = $row['nip_bendahara_keuangan'];
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
		// direktur
		// nip
		// jabatan_keuangan
		// rekening
		// nomer_rekening
		// npwp
		// bendahara_keuangan
		// nip_bendahara_keuangan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// direktur
		$this->direktur->ViewValue = $this->direktur->CurrentValue;
		$this->direktur->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// jabatan_keuangan
		$this->jabatan_keuangan->ViewValue = $this->jabatan_keuangan->CurrentValue;
		$this->jabatan_keuangan->ViewCustomAttributes = "";

		// rekening
		$this->rekening->ViewValue = $this->rekening->CurrentValue;
		$this->rekening->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// bendahara_keuangan
		$this->bendahara_keuangan->ViewValue = $this->bendahara_keuangan->CurrentValue;
		$this->bendahara_keuangan->ViewCustomAttributes = "";

		// nip_bendahara_keuangan
		$this->nip_bendahara_keuangan->ViewValue = $this->nip_bendahara_keuangan->CurrentValue;
		$this->nip_bendahara_keuangan->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// direktur
			$this->direktur->LinkCustomAttributes = "";
			$this->direktur->HrefValue = "";
			$this->direktur->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// jabatan_keuangan
			$this->jabatan_keuangan->LinkCustomAttributes = "";
			$this->jabatan_keuangan->HrefValue = "";
			$this->jabatan_keuangan->TooltipValue = "";

			// rekening
			$this->rekening->LinkCustomAttributes = "";
			$this->rekening->HrefValue = "";
			$this->rekening->TooltipValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";
			$this->nomer_rekening->TooltipValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";
			$this->npwp->TooltipValue = "";

			// bendahara_keuangan
			$this->bendahara_keuangan->LinkCustomAttributes = "";
			$this->bendahara_keuangan->HrefValue = "";
			$this->bendahara_keuangan->TooltipValue = "";

			// nip_bendahara_keuangan
			$this->nip_bendahara_keuangan->LinkCustomAttributes = "";
			$this->nip_bendahara_keuangan->HrefValue = "";
			$this->nip_bendahara_keuangan->TooltipValue = "";
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
if (!isset($m_blud_rs_list)) $m_blud_rs_list = new cm_blud_rs_list();

// Page init
$m_blud_rs_list->Page_Init();

// Page main
$m_blud_rs_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_blud_rs_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fm_blud_rslist = new ew_Form("fm_blud_rslist", "list");
fm_blud_rslist.FormKeyCountName = '<?php echo $m_blud_rs_list->FormKeyCountName ?>';

// Form_CustomValidate event
fm_blud_rslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_blud_rslist.ValidateRequired = true;
<?php } else { ?>
fm_blud_rslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fm_blud_rslistsrch = new ew_Form("fm_blud_rslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($m_blud_rs_list->TotalRecs > 0 && $m_blud_rs_list->ExportOptions->Visible()) { ?>
<?php $m_blud_rs_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($m_blud_rs_list->SearchOptions->Visible()) { ?>
<?php $m_blud_rs_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($m_blud_rs_list->FilterOptions->Visible()) { ?>
<?php $m_blud_rs_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $m_blud_rs_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($m_blud_rs_list->TotalRecs <= 0)
			$m_blud_rs_list->TotalRecs = $m_blud_rs->SelectRecordCount();
	} else {
		if (!$m_blud_rs_list->Recordset && ($m_blud_rs_list->Recordset = $m_blud_rs_list->LoadRecordset()))
			$m_blud_rs_list->TotalRecs = $m_blud_rs_list->Recordset->RecordCount();
	}
	$m_blud_rs_list->StartRec = 1;
	if ($m_blud_rs_list->DisplayRecs <= 0 || ($m_blud_rs->Export <> "" && $m_blud_rs->ExportAll)) // Display all records
		$m_blud_rs_list->DisplayRecs = $m_blud_rs_list->TotalRecs;
	if (!($m_blud_rs->Export <> "" && $m_blud_rs->ExportAll))
		$m_blud_rs_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$m_blud_rs_list->Recordset = $m_blud_rs_list->LoadRecordset($m_blud_rs_list->StartRec-1, $m_blud_rs_list->DisplayRecs);

	// Set no record found message
	if ($m_blud_rs->CurrentAction == "" && $m_blud_rs_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$m_blud_rs_list->setWarningMessage(ew_DeniedMsg());
		if ($m_blud_rs_list->SearchWhere == "0=101")
			$m_blud_rs_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$m_blud_rs_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$m_blud_rs_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($m_blud_rs->Export == "" && $m_blud_rs->CurrentAction == "") { ?>
<form name="fm_blud_rslistsrch" id="fm_blud_rslistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($m_blud_rs_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fm_blud_rslistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="m_blud_rs">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($m_blud_rs_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($m_blud_rs_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $m_blud_rs_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($m_blud_rs_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($m_blud_rs_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($m_blud_rs_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($m_blud_rs_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $m_blud_rs_list->ShowPageHeader(); ?>
<?php
$m_blud_rs_list->ShowMessage();
?>
<?php if ($m_blud_rs_list->TotalRecs > 0 || $m_blud_rs->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid m_blud_rs">
<form name="fm_blud_rslist" id="fm_blud_rslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_blud_rs_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_blud_rs_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_blud_rs">
<div id="gmp_m_blud_rs" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($m_blud_rs_list->TotalRecs > 0 || $m_blud_rs->CurrentAction == "gridedit") { ?>
<table id="tbl_m_blud_rslist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_blud_rs->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$m_blud_rs_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$m_blud_rs_list->RenderListOptions();

// Render list options (header, left)
$m_blud_rs_list->ListOptions->Render("header", "left");
?>
<?php if ($m_blud_rs->id->Visible) { // id ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->id) == "") { ?>
		<th data-name="id"><div id="elh_m_blud_rs_id" class="m_blud_rs_id"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->id) ?>',2);"><div id="elh_m_blud_rs_id" class="m_blud_rs_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->direktur->Visible) { // direktur ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->direktur) == "") { ?>
		<th data-name="direktur"><div id="elh_m_blud_rs_direktur" class="m_blud_rs_direktur"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->direktur->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="direktur"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->direktur) ?>',2);"><div id="elh_m_blud_rs_direktur" class="m_blud_rs_direktur">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->direktur->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->direktur->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->direktur->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->nip->Visible) { // nip ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->nip) == "") { ?>
		<th data-name="nip"><div id="elh_m_blud_rs_nip" class="m_blud_rs_nip"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->nip->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nip"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->nip) ?>',2);"><div id="elh_m_blud_rs_nip" class="m_blud_rs_nip">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->nip->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->nip->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->nip->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->jabatan_keuangan->Visible) { // jabatan_keuangan ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->jabatan_keuangan) == "") { ?>
		<th data-name="jabatan_keuangan"><div id="elh_m_blud_rs_jabatan_keuangan" class="m_blud_rs_jabatan_keuangan"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->jabatan_keuangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jabatan_keuangan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->jabatan_keuangan) ?>',2);"><div id="elh_m_blud_rs_jabatan_keuangan" class="m_blud_rs_jabatan_keuangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->jabatan_keuangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->jabatan_keuangan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->jabatan_keuangan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->rekening->Visible) { // rekening ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->rekening) == "") { ?>
		<th data-name="rekening"><div id="elh_m_blud_rs_rekening" class="m_blud_rs_rekening"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->rekening->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rekening"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->rekening) ?>',2);"><div id="elh_m_blud_rs_rekening" class="m_blud_rs_rekening">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->rekening->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->rekening->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->rekening->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->nomer_rekening->Visible) { // nomer_rekening ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->nomer_rekening) == "") { ?>
		<th data-name="nomer_rekening"><div id="elh_m_blud_rs_nomer_rekening" class="m_blud_rs_nomer_rekening"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->nomer_rekening->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomer_rekening"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->nomer_rekening) ?>',2);"><div id="elh_m_blud_rs_nomer_rekening" class="m_blud_rs_nomer_rekening">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->nomer_rekening->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->nomer_rekening->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->nomer_rekening->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->npwp->Visible) { // npwp ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->npwp) == "") { ?>
		<th data-name="npwp"><div id="elh_m_blud_rs_npwp" class="m_blud_rs_npwp"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->npwp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="npwp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->npwp) ?>',2);"><div id="elh_m_blud_rs_npwp" class="m_blud_rs_npwp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->npwp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->npwp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->npwp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->bendahara_keuangan->Visible) { // bendahara_keuangan ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->bendahara_keuangan) == "") { ?>
		<th data-name="bendahara_keuangan"><div id="elh_m_blud_rs_bendahara_keuangan" class="m_blud_rs_bendahara_keuangan"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->bendahara_keuangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bendahara_keuangan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->bendahara_keuangan) ?>',2);"><div id="elh_m_blud_rs_bendahara_keuangan" class="m_blud_rs_bendahara_keuangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->bendahara_keuangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->bendahara_keuangan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->bendahara_keuangan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_blud_rs->nip_bendahara_keuangan->Visible) { // nip_bendahara_keuangan ?>
	<?php if ($m_blud_rs->SortUrl($m_blud_rs->nip_bendahara_keuangan) == "") { ?>
		<th data-name="nip_bendahara_keuangan"><div id="elh_m_blud_rs_nip_bendahara_keuangan" class="m_blud_rs_nip_bendahara_keuangan"><div class="ewTableHeaderCaption"><?php echo $m_blud_rs->nip_bendahara_keuangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nip_bendahara_keuangan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_blud_rs->SortUrl($m_blud_rs->nip_bendahara_keuangan) ?>',2);"><div id="elh_m_blud_rs_nip_bendahara_keuangan" class="m_blud_rs_nip_bendahara_keuangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_blud_rs->nip_bendahara_keuangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_blud_rs->nip_bendahara_keuangan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_blud_rs->nip_bendahara_keuangan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$m_blud_rs_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($m_blud_rs->ExportAll && $m_blud_rs->Export <> "") {
	$m_blud_rs_list->StopRec = $m_blud_rs_list->TotalRecs;
} else {

	// Set the last record to display
	if ($m_blud_rs_list->TotalRecs > $m_blud_rs_list->StartRec + $m_blud_rs_list->DisplayRecs - 1)
		$m_blud_rs_list->StopRec = $m_blud_rs_list->StartRec + $m_blud_rs_list->DisplayRecs - 1;
	else
		$m_blud_rs_list->StopRec = $m_blud_rs_list->TotalRecs;
}
$m_blud_rs_list->RecCnt = $m_blud_rs_list->StartRec - 1;
if ($m_blud_rs_list->Recordset && !$m_blud_rs_list->Recordset->EOF) {
	$m_blud_rs_list->Recordset->MoveFirst();
	$bSelectLimit = $m_blud_rs_list->UseSelectLimit;
	if (!$bSelectLimit && $m_blud_rs_list->StartRec > 1)
		$m_blud_rs_list->Recordset->Move($m_blud_rs_list->StartRec - 1);
} elseif (!$m_blud_rs->AllowAddDeleteRow && $m_blud_rs_list->StopRec == 0) {
	$m_blud_rs_list->StopRec = $m_blud_rs->GridAddRowCount;
}

// Initialize aggregate
$m_blud_rs->RowType = EW_ROWTYPE_AGGREGATEINIT;
$m_blud_rs->ResetAttrs();
$m_blud_rs_list->RenderRow();
while ($m_blud_rs_list->RecCnt < $m_blud_rs_list->StopRec) {
	$m_blud_rs_list->RecCnt++;
	if (intval($m_blud_rs_list->RecCnt) >= intval($m_blud_rs_list->StartRec)) {
		$m_blud_rs_list->RowCnt++;

		// Set up key count
		$m_blud_rs_list->KeyCount = $m_blud_rs_list->RowIndex;

		// Init row class and style
		$m_blud_rs->ResetAttrs();
		$m_blud_rs->CssClass = "";
		if ($m_blud_rs->CurrentAction == "gridadd") {
		} else {
			$m_blud_rs_list->LoadRowValues($m_blud_rs_list->Recordset); // Load row values
		}
		$m_blud_rs->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$m_blud_rs->RowAttrs = array_merge($m_blud_rs->RowAttrs, array('data-rowindex'=>$m_blud_rs_list->RowCnt, 'id'=>'r' . $m_blud_rs_list->RowCnt . '_m_blud_rs', 'data-rowtype'=>$m_blud_rs->RowType));

		// Render row
		$m_blud_rs_list->RenderRow();

		// Render list options
		$m_blud_rs_list->RenderListOptions();
?>
	<tr<?php echo $m_blud_rs->RowAttributes() ?>>
<?php

// Render list options (body, left)
$m_blud_rs_list->ListOptions->Render("body", "left", $m_blud_rs_list->RowCnt);
?>
	<?php if ($m_blud_rs->id->Visible) { // id ?>
		<td data-name="id"<?php echo $m_blud_rs->id->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_id" class="m_blud_rs_id">
<span<?php echo $m_blud_rs->id->ViewAttributes() ?>>
<?php echo $m_blud_rs->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $m_blud_rs_list->PageObjName . "_row_" . $m_blud_rs_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($m_blud_rs->direktur->Visible) { // direktur ?>
		<td data-name="direktur"<?php echo $m_blud_rs->direktur->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_direktur" class="m_blud_rs_direktur">
<span<?php echo $m_blud_rs->direktur->ViewAttributes() ?>>
<?php echo $m_blud_rs->direktur->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_blud_rs->nip->Visible) { // nip ?>
		<td data-name="nip"<?php echo $m_blud_rs->nip->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_nip" class="m_blud_rs_nip">
<span<?php echo $m_blud_rs->nip->ViewAttributes() ?>>
<?php echo $m_blud_rs->nip->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_blud_rs->jabatan_keuangan->Visible) { // jabatan_keuangan ?>
		<td data-name="jabatan_keuangan"<?php echo $m_blud_rs->jabatan_keuangan->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_jabatan_keuangan" class="m_blud_rs_jabatan_keuangan">
<span<?php echo $m_blud_rs->jabatan_keuangan->ViewAttributes() ?>>
<?php echo $m_blud_rs->jabatan_keuangan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_blud_rs->rekening->Visible) { // rekening ?>
		<td data-name="rekening"<?php echo $m_blud_rs->rekening->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_rekening" class="m_blud_rs_rekening">
<span<?php echo $m_blud_rs->rekening->ViewAttributes() ?>>
<?php echo $m_blud_rs->rekening->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_blud_rs->nomer_rekening->Visible) { // nomer_rekening ?>
		<td data-name="nomer_rekening"<?php echo $m_blud_rs->nomer_rekening->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_nomer_rekening" class="m_blud_rs_nomer_rekening">
<span<?php echo $m_blud_rs->nomer_rekening->ViewAttributes() ?>>
<?php echo $m_blud_rs->nomer_rekening->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_blud_rs->npwp->Visible) { // npwp ?>
		<td data-name="npwp"<?php echo $m_blud_rs->npwp->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_npwp" class="m_blud_rs_npwp">
<span<?php echo $m_blud_rs->npwp->ViewAttributes() ?>>
<?php echo $m_blud_rs->npwp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_blud_rs->bendahara_keuangan->Visible) { // bendahara_keuangan ?>
		<td data-name="bendahara_keuangan"<?php echo $m_blud_rs->bendahara_keuangan->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_bendahara_keuangan" class="m_blud_rs_bendahara_keuangan">
<span<?php echo $m_blud_rs->bendahara_keuangan->ViewAttributes() ?>>
<?php echo $m_blud_rs->bendahara_keuangan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_blud_rs->nip_bendahara_keuangan->Visible) { // nip_bendahara_keuangan ?>
		<td data-name="nip_bendahara_keuangan"<?php echo $m_blud_rs->nip_bendahara_keuangan->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_list->RowCnt ?>_m_blud_rs_nip_bendahara_keuangan" class="m_blud_rs_nip_bendahara_keuangan">
<span<?php echo $m_blud_rs->nip_bendahara_keuangan->ViewAttributes() ?>>
<?php echo $m_blud_rs->nip_bendahara_keuangan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$m_blud_rs_list->ListOptions->Render("body", "right", $m_blud_rs_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($m_blud_rs->CurrentAction <> "gridadd")
		$m_blud_rs_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($m_blud_rs->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($m_blud_rs_list->Recordset)
	$m_blud_rs_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($m_blud_rs->CurrentAction <> "gridadd" && $m_blud_rs->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($m_blud_rs_list->Pager)) $m_blud_rs_list->Pager = new cPrevNextPager($m_blud_rs_list->StartRec, $m_blud_rs_list->DisplayRecs, $m_blud_rs_list->TotalRecs) ?>
<?php if ($m_blud_rs_list->Pager->RecordCount > 0 && $m_blud_rs_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($m_blud_rs_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $m_blud_rs_list->PageUrl() ?>start=<?php echo $m_blud_rs_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($m_blud_rs_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $m_blud_rs_list->PageUrl() ?>start=<?php echo $m_blud_rs_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $m_blud_rs_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($m_blud_rs_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $m_blud_rs_list->PageUrl() ?>start=<?php echo $m_blud_rs_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($m_blud_rs_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $m_blud_rs_list->PageUrl() ?>start=<?php echo $m_blud_rs_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $m_blud_rs_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $m_blud_rs_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $m_blud_rs_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $m_blud_rs_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($m_blud_rs_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $m_blud_rs_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="m_blud_rs">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($m_blud_rs_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($m_blud_rs_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($m_blud_rs_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($m_blud_rs_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($m_blud_rs_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_blud_rs_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($m_blud_rs_list->TotalRecs == 0 && $m_blud_rs->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_blud_rs_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fm_blud_rslistsrch.FilterList = <?php echo $m_blud_rs_list->GetFilterList() ?>;
fm_blud_rslistsrch.Init();
fm_blud_rslist.Init();
</script>
<?php
$m_blud_rs_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_blud_rs_list->Page_Terminate();
?>
