<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_kegiatan_tahunan_rs_detailinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_kegiatan_tahunan_rs_detail_list = NULL; // Initialize page object first

class cm_kegiatan_tahunan_rs_detail_list extends cm_kegiatan_tahunan_rs_detail {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_kegiatan_tahunan_rs_detail';

	// Page object name
	var $PageObjName = 'm_kegiatan_tahunan_rs_detail_list';

	// Grid form hidden field names
	var $FormName = 'fm_kegiatan_tahunan_rs_detaillist';
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

		// Table object (m_kegiatan_tahunan_rs_detail)
		if (!isset($GLOBALS["m_kegiatan_tahunan_rs_detail"]) || get_class($GLOBALS["m_kegiatan_tahunan_rs_detail"]) == "cm_kegiatan_tahunan_rs_detail") {
			$GLOBALS["m_kegiatan_tahunan_rs_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_kegiatan_tahunan_rs_detail"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "m_kegiatan_tahunan_rs_detailadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "m_kegiatan_tahunan_rs_detaildelete.php";
		$this->MultiUpdateUrl = "m_kegiatan_tahunan_rs_detailupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_kegiatan_tahunan_rs_detail', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fm_kegiatan_tahunan_rs_detaillistsrch";

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
		$this->tahun->SetVisibility();
		$this->program->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();

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
		global $EW_EXPORT, $m_kegiatan_tahunan_rs_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_kegiatan_tahunan_rs_detail);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fm_kegiatan_tahunan_rs_detaillistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->tahun->AdvancedSearch->ToJSON(), ","); // Field tahun
		$sFilterList = ew_Concat($sFilterList, $this->program->AdvancedSearch->ToJSON(), ","); // Field program
		$sFilterList = ew_Concat($sFilterList, $this->kode_rekening->AdvancedSearch->ToJSON(), ","); // Field kode_rekening
		$sFilterList = ew_Concat($sFilterList, $this->akun1->AdvancedSearch->ToJSON(), ","); // Field akun1
		$sFilterList = ew_Concat($sFilterList, $this->akun2->AdvancedSearch->ToJSON(), ","); // Field akun2
		$sFilterList = ew_Concat($sFilterList, $this->akun3->AdvancedSearch->ToJSON(), ","); // Field akun3
		$sFilterList = ew_Concat($sFilterList, $this->akun4->AdvancedSearch->ToJSON(), ","); // Field akun4
		$sFilterList = ew_Concat($sFilterList, $this->akun5->AdvancedSearch->ToJSON(), ","); // Field akun5
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fm_kegiatan_tahunan_rs_detaillistsrch", $filters);

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

		// Field tahun
		$this->tahun->AdvancedSearch->SearchValue = @$filter["x_tahun"];
		$this->tahun->AdvancedSearch->SearchOperator = @$filter["z_tahun"];
		$this->tahun->AdvancedSearch->SearchCondition = @$filter["v_tahun"];
		$this->tahun->AdvancedSearch->SearchValue2 = @$filter["y_tahun"];
		$this->tahun->AdvancedSearch->SearchOperator2 = @$filter["w_tahun"];
		$this->tahun->AdvancedSearch->Save();

		// Field program
		$this->program->AdvancedSearch->SearchValue = @$filter["x_program"];
		$this->program->AdvancedSearch->SearchOperator = @$filter["z_program"];
		$this->program->AdvancedSearch->SearchCondition = @$filter["v_program"];
		$this->program->AdvancedSearch->SearchValue2 = @$filter["y_program"];
		$this->program->AdvancedSearch->SearchOperator2 = @$filter["w_program"];
		$this->program->AdvancedSearch->Save();

		// Field kode_rekening
		$this->kode_rekening->AdvancedSearch->SearchValue = @$filter["x_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchOperator = @$filter["z_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchCondition = @$filter["v_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchValue2 = @$filter["y_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchOperator2 = @$filter["w_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->Save();

		// Field akun1
		$this->akun1->AdvancedSearch->SearchValue = @$filter["x_akun1"];
		$this->akun1->AdvancedSearch->SearchOperator = @$filter["z_akun1"];
		$this->akun1->AdvancedSearch->SearchCondition = @$filter["v_akun1"];
		$this->akun1->AdvancedSearch->SearchValue2 = @$filter["y_akun1"];
		$this->akun1->AdvancedSearch->SearchOperator2 = @$filter["w_akun1"];
		$this->akun1->AdvancedSearch->Save();

		// Field akun2
		$this->akun2->AdvancedSearch->SearchValue = @$filter["x_akun2"];
		$this->akun2->AdvancedSearch->SearchOperator = @$filter["z_akun2"];
		$this->akun2->AdvancedSearch->SearchCondition = @$filter["v_akun2"];
		$this->akun2->AdvancedSearch->SearchValue2 = @$filter["y_akun2"];
		$this->akun2->AdvancedSearch->SearchOperator2 = @$filter["w_akun2"];
		$this->akun2->AdvancedSearch->Save();

		// Field akun3
		$this->akun3->AdvancedSearch->SearchValue = @$filter["x_akun3"];
		$this->akun3->AdvancedSearch->SearchOperator = @$filter["z_akun3"];
		$this->akun3->AdvancedSearch->SearchCondition = @$filter["v_akun3"];
		$this->akun3->AdvancedSearch->SearchValue2 = @$filter["y_akun3"];
		$this->akun3->AdvancedSearch->SearchOperator2 = @$filter["w_akun3"];
		$this->akun3->AdvancedSearch->Save();

		// Field akun4
		$this->akun4->AdvancedSearch->SearchValue = @$filter["x_akun4"];
		$this->akun4->AdvancedSearch->SearchOperator = @$filter["z_akun4"];
		$this->akun4->AdvancedSearch->SearchCondition = @$filter["v_akun4"];
		$this->akun4->AdvancedSearch->SearchValue2 = @$filter["y_akun4"];
		$this->akun4->AdvancedSearch->SearchOperator2 = @$filter["w_akun4"];
		$this->akun4->AdvancedSearch->Save();

		// Field akun5
		$this->akun5->AdvancedSearch->SearchValue = @$filter["x_akun5"];
		$this->akun5->AdvancedSearch->SearchOperator = @$filter["z_akun5"];
		$this->akun5->AdvancedSearch->SearchCondition = @$filter["v_akun5"];
		$this->akun5->AdvancedSearch->SearchValue2 = @$filter["y_akun5"];
		$this->akun5->AdvancedSearch->SearchOperator2 = @$filter["w_akun5"];
		$this->akun5->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->tahun, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->program, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_rekening, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->akun1, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->akun2, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->akun3, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->akun4, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->akun5, $arKeywords, $type);
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
			$this->UpdateSort($this->tahun, $bCtrl); // tahun
			$this->UpdateSort($this->program, $bCtrl); // program
			$this->UpdateSort($this->kode_rekening, $bCtrl); // kode_rekening
			$this->UpdateSort($this->akun1, $bCtrl); // akun1
			$this->UpdateSort($this->akun2, $bCtrl); // akun2
			$this->UpdateSort($this->akun3, $bCtrl); // akun3
			$this->UpdateSort($this->akun4, $bCtrl); // akun4
			$this->UpdateSort($this->akun5, $bCtrl); // akun5
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
				$this->tahun->setSort("");
				$this->program->setSort("");
				$this->kode_rekening->setSort("");
				$this->akun1->setSort("");
				$this->akun2->setSort("");
				$this->akun3->setSort("");
				$this->akun4->setSort("");
				$this->akun5->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fm_kegiatan_tahunan_rs_detaillistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fm_kegiatan_tahunan_rs_detaillistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fm_kegiatan_tahunan_rs_detaillist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fm_kegiatan_tahunan_rs_detaillistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->tahun->setDbValue($rs->fields('tahun'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->tahun->DbValue = $row['tahun'];
		$this->program->DbValue = $row['program'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
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
		// tahun
		// program
		// kode_rekening
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// tahun
		$this->tahun->ViewValue = $this->tahun->CurrentValue;
		$this->tahun->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		$this->akun2->ViewValue = $this->akun2->CurrentValue;
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		$this->akun3->ViewValue = $this->akun3->CurrentValue;
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		$this->akun4->ViewValue = $this->akun4->CurrentValue;
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		$this->akun5->ViewValue = $this->akun5->CurrentValue;
		$this->akun5->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// tahun
			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";
			$this->tahun->TooltipValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";
			$this->program->TooltipValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

			// akun1
			$this->akun1->LinkCustomAttributes = "";
			$this->akun1->HrefValue = "";
			$this->akun1->TooltipValue = "";

			// akun2
			$this->akun2->LinkCustomAttributes = "";
			$this->akun2->HrefValue = "";
			$this->akun2->TooltipValue = "";

			// akun3
			$this->akun3->LinkCustomAttributes = "";
			$this->akun3->HrefValue = "";
			$this->akun3->TooltipValue = "";

			// akun4
			$this->akun4->LinkCustomAttributes = "";
			$this->akun4->HrefValue = "";
			$this->akun4->TooltipValue = "";

			// akun5
			$this->akun5->LinkCustomAttributes = "";
			$this->akun5->HrefValue = "";
			$this->akun5->TooltipValue = "";
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
if (!isset($m_kegiatan_tahunan_rs_detail_list)) $m_kegiatan_tahunan_rs_detail_list = new cm_kegiatan_tahunan_rs_detail_list();

// Page init
$m_kegiatan_tahunan_rs_detail_list->Page_Init();

// Page main
$m_kegiatan_tahunan_rs_detail_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_kegiatan_tahunan_rs_detail_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fm_kegiatan_tahunan_rs_detaillist = new ew_Form("fm_kegiatan_tahunan_rs_detaillist", "list");
fm_kegiatan_tahunan_rs_detaillist.FormKeyCountName = '<?php echo $m_kegiatan_tahunan_rs_detail_list->FormKeyCountName ?>';

// Form_CustomValidate event
fm_kegiatan_tahunan_rs_detaillist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_kegiatan_tahunan_rs_detaillist.ValidateRequired = true;
<?php } else { ?>
fm_kegiatan_tahunan_rs_detaillist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fm_kegiatan_tahunan_rs_detaillistsrch = new ew_Form("fm_kegiatan_tahunan_rs_detaillistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($m_kegiatan_tahunan_rs_detail_list->TotalRecs > 0 && $m_kegiatan_tahunan_rs_detail_list->ExportOptions->Visible()) { ?>
<?php $m_kegiatan_tahunan_rs_detail_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail_list->SearchOptions->Visible()) { ?>
<?php $m_kegiatan_tahunan_rs_detail_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail_list->FilterOptions->Visible()) { ?>
<?php $m_kegiatan_tahunan_rs_detail_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $m_kegiatan_tahunan_rs_detail_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($m_kegiatan_tahunan_rs_detail_list->TotalRecs <= 0)
			$m_kegiatan_tahunan_rs_detail_list->TotalRecs = $m_kegiatan_tahunan_rs_detail->SelectRecordCount();
	} else {
		if (!$m_kegiatan_tahunan_rs_detail_list->Recordset && ($m_kegiatan_tahunan_rs_detail_list->Recordset = $m_kegiatan_tahunan_rs_detail_list->LoadRecordset()))
			$m_kegiatan_tahunan_rs_detail_list->TotalRecs = $m_kegiatan_tahunan_rs_detail_list->Recordset->RecordCount();
	}
	$m_kegiatan_tahunan_rs_detail_list->StartRec = 1;
	if ($m_kegiatan_tahunan_rs_detail_list->DisplayRecs <= 0 || ($m_kegiatan_tahunan_rs_detail->Export <> "" && $m_kegiatan_tahunan_rs_detail->ExportAll)) // Display all records
		$m_kegiatan_tahunan_rs_detail_list->DisplayRecs = $m_kegiatan_tahunan_rs_detail_list->TotalRecs;
	if (!($m_kegiatan_tahunan_rs_detail->Export <> "" && $m_kegiatan_tahunan_rs_detail->ExportAll))
		$m_kegiatan_tahunan_rs_detail_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$m_kegiatan_tahunan_rs_detail_list->Recordset = $m_kegiatan_tahunan_rs_detail_list->LoadRecordset($m_kegiatan_tahunan_rs_detail_list->StartRec-1, $m_kegiatan_tahunan_rs_detail_list->DisplayRecs);

	// Set no record found message
	if ($m_kegiatan_tahunan_rs_detail->CurrentAction == "" && $m_kegiatan_tahunan_rs_detail_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$m_kegiatan_tahunan_rs_detail_list->setWarningMessage(ew_DeniedMsg());
		if ($m_kegiatan_tahunan_rs_detail_list->SearchWhere == "0=101")
			$m_kegiatan_tahunan_rs_detail_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$m_kegiatan_tahunan_rs_detail_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$m_kegiatan_tahunan_rs_detail_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($m_kegiatan_tahunan_rs_detail->Export == "" && $m_kegiatan_tahunan_rs_detail->CurrentAction == "") { ?>
<form name="fm_kegiatan_tahunan_rs_detaillistsrch" id="fm_kegiatan_tahunan_rs_detaillistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($m_kegiatan_tahunan_rs_detail_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fm_kegiatan_tahunan_rs_detaillistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="m_kegiatan_tahunan_rs_detail">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $m_kegiatan_tahunan_rs_detail_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($m_kegiatan_tahunan_rs_detail_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($m_kegiatan_tahunan_rs_detail_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($m_kegiatan_tahunan_rs_detail_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($m_kegiatan_tahunan_rs_detail_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $m_kegiatan_tahunan_rs_detail_list->ShowPageHeader(); ?>
<?php
$m_kegiatan_tahunan_rs_detail_list->ShowMessage();
?>
<?php if ($m_kegiatan_tahunan_rs_detail_list->TotalRecs > 0 || $m_kegiatan_tahunan_rs_detail->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid m_kegiatan_tahunan_rs_detail">
<form name="fm_kegiatan_tahunan_rs_detaillist" id="fm_kegiatan_tahunan_rs_detaillist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_kegiatan_tahunan_rs_detail_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_kegiatan_tahunan_rs_detail">
<div id="gmp_m_kegiatan_tahunan_rs_detail" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($m_kegiatan_tahunan_rs_detail_list->TotalRecs > 0 || $m_kegiatan_tahunan_rs_detail->CurrentAction == "gridedit") { ?>
<table id="tbl_m_kegiatan_tahunan_rs_detaillist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_kegiatan_tahunan_rs_detail->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$m_kegiatan_tahunan_rs_detail_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$m_kegiatan_tahunan_rs_detail_list->RenderListOptions();

// Render list options (header, left)
$m_kegiatan_tahunan_rs_detail_list->ListOptions->Render("header", "left");
?>
<?php if ($m_kegiatan_tahunan_rs_detail->id->Visible) { // id ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->id) == "") { ?>
		<th data-name="id"><div id="elh_m_kegiatan_tahunan_rs_detail_id" class="m_kegiatan_tahunan_rs_detail_id"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->id) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_id" class="m_kegiatan_tahunan_rs_detail_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->tahun->Visible) { // tahun ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->tahun) == "") { ?>
		<th data-name="tahun"><div id="elh_m_kegiatan_tahunan_rs_detail_tahun" class="m_kegiatan_tahunan_rs_detail_tahun"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->tahun->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tahun"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->tahun) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_tahun" class="m_kegiatan_tahunan_rs_detail_tahun">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->tahun->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->tahun->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->tahun->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->program->Visible) { // program ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->program) == "") { ?>
		<th data-name="program"><div id="elh_m_kegiatan_tahunan_rs_detail_program" class="m_kegiatan_tahunan_rs_detail_program"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->program->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="program"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->program) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_program" class="m_kegiatan_tahunan_rs_detail_program">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->program->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->program->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->program->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->kode_rekening->Visible) { // kode_rekening ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->kode_rekening) == "") { ?>
		<th data-name="kode_rekening"><div id="elh_m_kegiatan_tahunan_rs_detail_kode_rekening" class="m_kegiatan_tahunan_rs_detail_kode_rekening"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_rekening"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->kode_rekening) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_kode_rekening" class="m_kegiatan_tahunan_rs_detail_kode_rekening">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->kode_rekening->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->kode_rekening->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->akun1->Visible) { // akun1 ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun1) == "") { ?>
		<th data-name="akun1"><div id="elh_m_kegiatan_tahunan_rs_detail_akun1" class="m_kegiatan_tahunan_rs_detail_akun1"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun1"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun1) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_akun1" class="m_kegiatan_tahunan_rs_detail_akun1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun1->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->akun1->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->akun1->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->akun2->Visible) { // akun2 ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun2) == "") { ?>
		<th data-name="akun2"><div id="elh_m_kegiatan_tahunan_rs_detail_akun2" class="m_kegiatan_tahunan_rs_detail_akun2"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun2->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun2"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun2) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_akun2" class="m_kegiatan_tahunan_rs_detail_akun2">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun2->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->akun2->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->akun2->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->akun3->Visible) { // akun3 ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun3) == "") { ?>
		<th data-name="akun3"><div id="elh_m_kegiatan_tahunan_rs_detail_akun3" class="m_kegiatan_tahunan_rs_detail_akun3"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun3->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun3"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun3) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_akun3" class="m_kegiatan_tahunan_rs_detail_akun3">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun3->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->akun3->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->akun3->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->akun4->Visible) { // akun4 ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun4) == "") { ?>
		<th data-name="akun4"><div id="elh_m_kegiatan_tahunan_rs_detail_akun4" class="m_kegiatan_tahunan_rs_detail_akun4"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun4->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun4"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun4) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_akun4" class="m_kegiatan_tahunan_rs_detail_akun4">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun4->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->akun4->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->akun4->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($m_kegiatan_tahunan_rs_detail->akun5->Visible) { // akun5 ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun5) == "") { ?>
		<th data-name="akun5"><div id="elh_m_kegiatan_tahunan_rs_detail_akun5" class="m_kegiatan_tahunan_rs_detail_akun5"><div class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun5->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="akun5"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $m_kegiatan_tahunan_rs_detail->SortUrl($m_kegiatan_tahunan_rs_detail->akun5) ?>',2);"><div id="elh_m_kegiatan_tahunan_rs_detail_akun5" class="m_kegiatan_tahunan_rs_detail_akun5">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $m_kegiatan_tahunan_rs_detail->akun5->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($m_kegiatan_tahunan_rs_detail->akun5->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($m_kegiatan_tahunan_rs_detail->akun5->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$m_kegiatan_tahunan_rs_detail_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($m_kegiatan_tahunan_rs_detail->ExportAll && $m_kegiatan_tahunan_rs_detail->Export <> "") {
	$m_kegiatan_tahunan_rs_detail_list->StopRec = $m_kegiatan_tahunan_rs_detail_list->TotalRecs;
} else {

	// Set the last record to display
	if ($m_kegiatan_tahunan_rs_detail_list->TotalRecs > $m_kegiatan_tahunan_rs_detail_list->StartRec + $m_kegiatan_tahunan_rs_detail_list->DisplayRecs - 1)
		$m_kegiatan_tahunan_rs_detail_list->StopRec = $m_kegiatan_tahunan_rs_detail_list->StartRec + $m_kegiatan_tahunan_rs_detail_list->DisplayRecs - 1;
	else
		$m_kegiatan_tahunan_rs_detail_list->StopRec = $m_kegiatan_tahunan_rs_detail_list->TotalRecs;
}
$m_kegiatan_tahunan_rs_detail_list->RecCnt = $m_kegiatan_tahunan_rs_detail_list->StartRec - 1;
if ($m_kegiatan_tahunan_rs_detail_list->Recordset && !$m_kegiatan_tahunan_rs_detail_list->Recordset->EOF) {
	$m_kegiatan_tahunan_rs_detail_list->Recordset->MoveFirst();
	$bSelectLimit = $m_kegiatan_tahunan_rs_detail_list->UseSelectLimit;
	if (!$bSelectLimit && $m_kegiatan_tahunan_rs_detail_list->StartRec > 1)
		$m_kegiatan_tahunan_rs_detail_list->Recordset->Move($m_kegiatan_tahunan_rs_detail_list->StartRec - 1);
} elseif (!$m_kegiatan_tahunan_rs_detail->AllowAddDeleteRow && $m_kegiatan_tahunan_rs_detail_list->StopRec == 0) {
	$m_kegiatan_tahunan_rs_detail_list->StopRec = $m_kegiatan_tahunan_rs_detail->GridAddRowCount;
}

// Initialize aggregate
$m_kegiatan_tahunan_rs_detail->RowType = EW_ROWTYPE_AGGREGATEINIT;
$m_kegiatan_tahunan_rs_detail->ResetAttrs();
$m_kegiatan_tahunan_rs_detail_list->RenderRow();
while ($m_kegiatan_tahunan_rs_detail_list->RecCnt < $m_kegiatan_tahunan_rs_detail_list->StopRec) {
	$m_kegiatan_tahunan_rs_detail_list->RecCnt++;
	if (intval($m_kegiatan_tahunan_rs_detail_list->RecCnt) >= intval($m_kegiatan_tahunan_rs_detail_list->StartRec)) {
		$m_kegiatan_tahunan_rs_detail_list->RowCnt++;

		// Set up key count
		$m_kegiatan_tahunan_rs_detail_list->KeyCount = $m_kegiatan_tahunan_rs_detail_list->RowIndex;

		// Init row class and style
		$m_kegiatan_tahunan_rs_detail->ResetAttrs();
		$m_kegiatan_tahunan_rs_detail->CssClass = "";
		if ($m_kegiatan_tahunan_rs_detail->CurrentAction == "gridadd") {
		} else {
			$m_kegiatan_tahunan_rs_detail_list->LoadRowValues($m_kegiatan_tahunan_rs_detail_list->Recordset); // Load row values
		}
		$m_kegiatan_tahunan_rs_detail->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$m_kegiatan_tahunan_rs_detail->RowAttrs = array_merge($m_kegiatan_tahunan_rs_detail->RowAttrs, array('data-rowindex'=>$m_kegiatan_tahunan_rs_detail_list->RowCnt, 'id'=>'r' . $m_kegiatan_tahunan_rs_detail_list->RowCnt . '_m_kegiatan_tahunan_rs_detail', 'data-rowtype'=>$m_kegiatan_tahunan_rs_detail->RowType));

		// Render row
		$m_kegiatan_tahunan_rs_detail_list->RenderRow();

		// Render list options
		$m_kegiatan_tahunan_rs_detail_list->RenderListOptions();
?>
	<tr<?php echo $m_kegiatan_tahunan_rs_detail->RowAttributes() ?>>
<?php

// Render list options (body, left)
$m_kegiatan_tahunan_rs_detail_list->ListOptions->Render("body", "left", $m_kegiatan_tahunan_rs_detail_list->RowCnt);
?>
	<?php if ($m_kegiatan_tahunan_rs_detail->id->Visible) { // id ?>
		<td data-name="id"<?php echo $m_kegiatan_tahunan_rs_detail->id->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_id" class="m_kegiatan_tahunan_rs_detail_id">
<span<?php echo $m_kegiatan_tahunan_rs_detail->id->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $m_kegiatan_tahunan_rs_detail_list->PageObjName . "_row_" . $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->tahun->Visible) { // tahun ?>
		<td data-name="tahun"<?php echo $m_kegiatan_tahunan_rs_detail->tahun->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_tahun" class="m_kegiatan_tahunan_rs_detail_tahun">
<span<?php echo $m_kegiatan_tahunan_rs_detail->tahun->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->tahun->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->program->Visible) { // program ?>
		<td data-name="program"<?php echo $m_kegiatan_tahunan_rs_detail->program->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_program" class="m_kegiatan_tahunan_rs_detail_program">
<span<?php echo $m_kegiatan_tahunan_rs_detail->program->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->program->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->kode_rekening->Visible) { // kode_rekening ?>
		<td data-name="kode_rekening"<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_kode_rekening" class="m_kegiatan_tahunan_rs_detail_kode_rekening">
<span<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->akun1->Visible) { // akun1 ?>
		<td data-name="akun1"<?php echo $m_kegiatan_tahunan_rs_detail->akun1->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_akun1" class="m_kegiatan_tahunan_rs_detail_akun1">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun1->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->akun2->Visible) { // akun2 ?>
		<td data-name="akun2"<?php echo $m_kegiatan_tahunan_rs_detail->akun2->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_akun2" class="m_kegiatan_tahunan_rs_detail_akun2">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun2->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun2->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->akun3->Visible) { // akun3 ?>
		<td data-name="akun3"<?php echo $m_kegiatan_tahunan_rs_detail->akun3->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_akun3" class="m_kegiatan_tahunan_rs_detail_akun3">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun3->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun3->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->akun4->Visible) { // akun4 ?>
		<td data-name="akun4"<?php echo $m_kegiatan_tahunan_rs_detail->akun4->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_akun4" class="m_kegiatan_tahunan_rs_detail_akun4">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun4->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun4->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($m_kegiatan_tahunan_rs_detail->akun5->Visible) { // akun5 ?>
		<td data-name="akun5"<?php echo $m_kegiatan_tahunan_rs_detail->akun5->CellAttributes() ?>>
<span id="el<?php echo $m_kegiatan_tahunan_rs_detail_list->RowCnt ?>_m_kegiatan_tahunan_rs_detail_akun5" class="m_kegiatan_tahunan_rs_detail_akun5">
<span<?php echo $m_kegiatan_tahunan_rs_detail->akun5->ViewAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs_detail->akun5->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$m_kegiatan_tahunan_rs_detail_list->ListOptions->Render("body", "right", $m_kegiatan_tahunan_rs_detail_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($m_kegiatan_tahunan_rs_detail->CurrentAction <> "gridadd")
		$m_kegiatan_tahunan_rs_detail_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($m_kegiatan_tahunan_rs_detail_list->Recordset)
	$m_kegiatan_tahunan_rs_detail_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($m_kegiatan_tahunan_rs_detail->CurrentAction <> "gridadd" && $m_kegiatan_tahunan_rs_detail->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($m_kegiatan_tahunan_rs_detail_list->Pager)) $m_kegiatan_tahunan_rs_detail_list->Pager = new cPrevNextPager($m_kegiatan_tahunan_rs_detail_list->StartRec, $m_kegiatan_tahunan_rs_detail_list->DisplayRecs, $m_kegiatan_tahunan_rs_detail_list->TotalRecs) ?>
<?php if ($m_kegiatan_tahunan_rs_detail_list->Pager->RecordCount > 0 && $m_kegiatan_tahunan_rs_detail_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($m_kegiatan_tahunan_rs_detail_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $m_kegiatan_tahunan_rs_detail_list->PageUrl() ?>start=<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($m_kegiatan_tahunan_rs_detail_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $m_kegiatan_tahunan_rs_detail_list->PageUrl() ?>start=<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($m_kegiatan_tahunan_rs_detail_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $m_kegiatan_tahunan_rs_detail_list->PageUrl() ?>start=<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($m_kegiatan_tahunan_rs_detail_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $m_kegiatan_tahunan_rs_detail_list->PageUrl() ?>start=<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $m_kegiatan_tahunan_rs_detail_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $m_kegiatan_tahunan_rs_detail_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="m_kegiatan_tahunan_rs_detail">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($m_kegiatan_tahunan_rs_detail_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($m_kegiatan_tahunan_rs_detail_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($m_kegiatan_tahunan_rs_detail_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($m_kegiatan_tahunan_rs_detail_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($m_kegiatan_tahunan_rs_detail_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_kegiatan_tahunan_rs_detail_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail_list->TotalRecs == 0 && $m_kegiatan_tahunan_rs_detail->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($m_kegiatan_tahunan_rs_detail_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fm_kegiatan_tahunan_rs_detaillistsrch.FilterList = <?php echo $m_kegiatan_tahunan_rs_detail_list->GetFilterList() ?>;
fm_kegiatan_tahunan_rs_detaillistsrch.Init();
fm_kegiatan_tahunan_rs_detaillist.Init();
</script>
<?php
$m_kegiatan_tahunan_rs_detail_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_kegiatan_tahunan_rs_detail_list->Page_Terminate();
?>
