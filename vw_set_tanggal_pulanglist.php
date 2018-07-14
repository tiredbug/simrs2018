<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_set_tanggal_pulanginfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_set_tanggal_pulang_list = NULL; // Initialize page object first

class cvw_set_tanggal_pulang_list extends cvw_set_tanggal_pulang {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_set_tanggal_pulang';

	// Page object name
	var $PageObjName = 'vw_set_tanggal_pulang_list';

	// Grid form hidden field names
	var $FormName = 'fvw_set_tanggal_pulanglist';
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

		// Table object (vw_set_tanggal_pulang)
		if (!isset($GLOBALS["vw_set_tanggal_pulang"]) || get_class($GLOBALS["vw_set_tanggal_pulang"]) == "cvw_set_tanggal_pulang") {
			$GLOBALS["vw_set_tanggal_pulang"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_set_tanggal_pulang"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_set_tanggal_pulangadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_set_tanggal_pulangdelete.php";
		$this->MultiUpdateUrl = "vw_set_tanggal_pulangupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_set_tanggal_pulang', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_set_tanggal_pulanglistsrch";

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
		$this->id_admission->SetVisibility();
		$this->nomr->SetVisibility();
		$this->ket_nama->SetVisibility();
		$this->ket_alamat->SetVisibility();
		$this->statusbayar->SetVisibility();
		$this->masukrs->SetVisibility();
		$this->noruang->SetVisibility();
		$this->dokter_penanggungjawab->SetVisibility();
		$this->KELASPERAWATAN_ID->SetVisibility();
		$this->NO_SKP->SetVisibility();

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
		global $EW_EXPORT, $vw_set_tanggal_pulang;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_set_tanggal_pulang);
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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

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
			$this->id_admission->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id_admission->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_set_tanggal_pulanglistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id_admission->AdvancedSearch->ToJSON(), ","); // Field id_admission
		$sFilterList = ew_Concat($sFilterList, $this->nomr->AdvancedSearch->ToJSON(), ","); // Field nomr
		$sFilterList = ew_Concat($sFilterList, $this->statusbayar->AdvancedSearch->ToJSON(), ","); // Field statusbayar
		$sFilterList = ew_Concat($sFilterList, $this->KELASPERAWATAN_ID->AdvancedSearch->ToJSON(), ","); // Field KELASPERAWATAN_ID
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_set_tanggal_pulanglistsrch", $filters);

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

		// Field id_admission
		$this->id_admission->AdvancedSearch->SearchValue = @$filter["x_id_admission"];
		$this->id_admission->AdvancedSearch->SearchOperator = @$filter["z_id_admission"];
		$this->id_admission->AdvancedSearch->SearchCondition = @$filter["v_id_admission"];
		$this->id_admission->AdvancedSearch->SearchValue2 = @$filter["y_id_admission"];
		$this->id_admission->AdvancedSearch->SearchOperator2 = @$filter["w_id_admission"];
		$this->id_admission->AdvancedSearch->Save();

		// Field nomr
		$this->nomr->AdvancedSearch->SearchValue = @$filter["x_nomr"];
		$this->nomr->AdvancedSearch->SearchOperator = @$filter["z_nomr"];
		$this->nomr->AdvancedSearch->SearchCondition = @$filter["v_nomr"];
		$this->nomr->AdvancedSearch->SearchValue2 = @$filter["y_nomr"];
		$this->nomr->AdvancedSearch->SearchOperator2 = @$filter["w_nomr"];
		$this->nomr->AdvancedSearch->Save();

		// Field statusbayar
		$this->statusbayar->AdvancedSearch->SearchValue = @$filter["x_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchOperator = @$filter["z_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchCondition = @$filter["v_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchValue2 = @$filter["y_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchOperator2 = @$filter["w_statusbayar"];
		$this->statusbayar->AdvancedSearch->Save();

		// Field KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchValue = @$filter["x_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchOperator = @$filter["z_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchCondition = @$filter["v_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchValue2 = @$filter["y_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->Save();
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->id_admission, $Default, FALSE); // id_admission
		$this->BuildSearchSql($sWhere, $this->nomr, $Default, FALSE); // nomr
		$this->BuildSearchSql($sWhere, $this->statusbayar, $Default, FALSE); // statusbayar
		$this->BuildSearchSql($sWhere, $this->KELASPERAWATAN_ID, $Default, FALSE); // KELASPERAWATAN_ID

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->id_admission->AdvancedSearch->Save(); // id_admission
			$this->nomr->AdvancedSearch->Save(); // nomr
			$this->statusbayar->AdvancedSearch->Save(); // statusbayar
			$this->KELASPERAWATAN_ID->AdvancedSearch->Save(); // KELASPERAWATAN_ID
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

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->id_admission->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->nomr->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->statusbayar->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->KELASPERAWATAN_ID->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->id_admission->AdvancedSearch->UnsetSession();
		$this->nomr->AdvancedSearch->UnsetSession();
		$this->statusbayar->AdvancedSearch->UnsetSession();
		$this->KELASPERAWATAN_ID->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->id_admission->AdvancedSearch->Load();
		$this->nomr->AdvancedSearch->Load();
		$this->statusbayar->AdvancedSearch->Load();
		$this->KELASPERAWATAN_ID->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id_admission, $bCtrl); // id_admission
			$this->UpdateSort($this->nomr, $bCtrl); // nomr
			$this->UpdateSort($this->ket_nama, $bCtrl); // ket_nama
			$this->UpdateSort($this->ket_alamat, $bCtrl); // ket_alamat
			$this->UpdateSort($this->statusbayar, $bCtrl); // statusbayar
			$this->UpdateSort($this->masukrs, $bCtrl); // masukrs
			$this->UpdateSort($this->noruang, $bCtrl); // noruang
			$this->UpdateSort($this->dokter_penanggungjawab, $bCtrl); // dokter_penanggungjawab
			$this->UpdateSort($this->KELASPERAWATAN_ID, $bCtrl); // KELASPERAWATAN_ID
			$this->UpdateSort($this->NO_SKP, $bCtrl); // NO_SKP
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
				$this->id_admission->setSort("");
				$this->nomr->setSort("");
				$this->ket_nama->setSort("");
				$this->ket_alamat->setSort("");
				$this->statusbayar->setSort("");
				$this->masukrs->setSort("");
				$this->noruang->setSort("");
				$this->dokter_penanggungjawab->setSort("");
				$this->KELASPERAWATAN_ID->setSort("");
				$this->NO_SKP->setSort("");
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
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id_admission->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_set_tanggal_pulanglistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_set_tanggal_pulanglistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_set_tanggal_pulanglist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"vw_set_tanggal_pulangsrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// id_admission

		$this->id_admission->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_id_admission"]);
		if ($this->id_admission->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->id_admission->AdvancedSearch->SearchOperator = @$_GET["z_id_admission"];

		// nomr
		$this->nomr->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_nomr"]);
		if ($this->nomr->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->nomr->AdvancedSearch->SearchOperator = @$_GET["z_nomr"];

		// statusbayar
		$this->statusbayar->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_statusbayar"]);
		if ($this->statusbayar->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->statusbayar->AdvancedSearch->SearchOperator = @$_GET["z_statusbayar"];

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_KELASPERAWATAN_ID"]);
		if ($this->KELASPERAWATAN_ID->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchOperator = @$_GET["z_KELASPERAWATAN_ID"];
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->ket_nama->setDbValue($rs->fields('ket_nama'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->ket_nama->DbValue = $row['ket_nama'];
		$this->ket_alamat->DbValue = $row['ket_alamat'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->keluarrs->DbValue = $row['keluarrs'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->icd_keluar->DbValue = $row['icd_keluar'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->statuskeluarranap_id->DbValue = $row['statuskeluarranap_id'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_admission")) <> "")
			$this->id_admission->CurrentValue = $this->getKey("id_admission"); // id_admission
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
		// id_admission
		// nomr
		// ket_nama
		// ket_alamat
		// statusbayar
		// masukrs
		// noruang
		// keluarrs
		// tempat_tidur_id
		// icd_keluar
		// dokter_penanggungjawab
		// KELASPERAWATAN_ID
		// NO_SKP
		// statuskeluarranap_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
		if (strval($this->statusbayar->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->statusbayar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statusbayar->ViewValue = $this->statusbayar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			}
		} else {
			$this->statusbayar->ViewValue = NULL;
		}
		$this->statusbayar->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 0);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		if (strval($this->noruang->CurrentValue) <> "") {
			$sFilterWrk = "`no`" . ew_SearchString("=", $this->noruang->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `no`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_ruang`";
		$sWhereWrk = "";
		$this->noruang->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->noruang->ViewValue = $this->noruang->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->noruang->ViewValue = $this->noruang->CurrentValue;
			}
		} else {
			$this->noruang->ViewValue = NULL;
		}
		$this->noruang->ViewCustomAttributes = "";

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 17);
		$this->keluarrs->ViewCustomAttributes = "";

		// tempat_tidur_id
		if (strval($this->tempat_tidur_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
		$sWhereWrk = "";
		$this->tempat_tidur_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->CurrentValue;
			}
		} else {
			$this->tempat_tidur_id->ViewValue = NULL;
		}
		$this->tempat_tidur_id->ViewCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		if (strval($this->icd_keluar->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_keluar->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `icd_eklaim`";
		$sWhereWrk = "";
		$this->icd_keluar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_keluar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_keluar->ViewValue = $this->icd_keluar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
			}
		} else {
			$this->icd_keluar->ViewValue = NULL;
		}
		$this->icd_keluar->ViewCustomAttributes = "";

		// dokter_penanggungjawab
		if (strval($this->dokter_penanggungjawab->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokter_penanggungjawab->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokter_penanggungjawab->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->CurrentValue;
			}
		} else {
			$this->dokter_penanggungjawab->ViewValue = NULL;
		}
		$this->dokter_penanggungjawab->ViewCustomAttributes = "";

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// statuskeluarranap_id
		if (strval($this->statuskeluarranap_id->CurrentValue) <> "") {
			$sFilterWrk = "`status`" . ew_SearchString("=", $this->statuskeluarranap_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `status`, `keterangan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_statuskeluar`";
		$sWhereWrk = "";
		$this->statuskeluarranap_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statuskeluarranap_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
			}
		} else {
			$this->statuskeluarranap_id->ViewValue = NULL;
		}
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

			// id_admission
			$this->id_admission->LinkCustomAttributes = "";
			$this->id_admission->HrefValue = "";
			$this->id_admission->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// ket_nama
			$this->ket_nama->LinkCustomAttributes = "";
			$this->ket_nama->HrefValue = "";
			$this->ket_nama->TooltipValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";
			$this->ket_alamat->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";
			$this->masukrs->TooltipValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";
			$this->noruang->TooltipValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";
			$this->dokter_penanggungjawab->TooltipValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// NO_SKP
			$this->NO_SKP->LinkCustomAttributes = "";
			$this->NO_SKP->HrefValue = "";
			$this->NO_SKP->TooltipValue = "";
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
		$this->id_admission->AdvancedSearch->Load();
		$this->nomr->AdvancedSearch->Load();
		$this->statusbayar->AdvancedSearch->Load();
		$this->KELASPERAWATAN_ID->AdvancedSearch->Load();
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

		$r = Security()->CurrentUserLevelID();
		if($r==5)
		{

			//$this->ListOptions->Items["details"]->Visible = FALSE;
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
if (!isset($vw_set_tanggal_pulang_list)) $vw_set_tanggal_pulang_list = new cvw_set_tanggal_pulang_list();

// Page init
$vw_set_tanggal_pulang_list->Page_Init();

// Page main
$vw_set_tanggal_pulang_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_set_tanggal_pulang_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_set_tanggal_pulanglist = new ew_Form("fvw_set_tanggal_pulanglist", "list");
fvw_set_tanggal_pulanglist.FormKeyCountName = '<?php echo $vw_set_tanggal_pulang_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvw_set_tanggal_pulanglist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_set_tanggal_pulanglist.ValidateRequired = true;
<?php } else { ?>
fvw_set_tanggal_pulanglist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_set_tanggal_pulanglist.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_set_tanggal_pulanglist.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
fvw_set_tanggal_pulanglist.Lists["x_dokter_penanggungjawab"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};

// Form object for search
var CurrentSearchForm = fvw_set_tanggal_pulanglistsrch = new ew_Form("fvw_set_tanggal_pulanglistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_set_tanggal_pulang_list->TotalRecs > 0 && $vw_set_tanggal_pulang_list->ExportOptions->Visible()) { ?>
<?php $vw_set_tanggal_pulang_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_set_tanggal_pulang_list->SearchOptions->Visible()) { ?>
<?php $vw_set_tanggal_pulang_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_set_tanggal_pulang_list->FilterOptions->Visible()) { ?>
<?php $vw_set_tanggal_pulang_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $vw_set_tanggal_pulang_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_set_tanggal_pulang_list->TotalRecs <= 0)
			$vw_set_tanggal_pulang_list->TotalRecs = $vw_set_tanggal_pulang->SelectRecordCount();
	} else {
		if (!$vw_set_tanggal_pulang_list->Recordset && ($vw_set_tanggal_pulang_list->Recordset = $vw_set_tanggal_pulang_list->LoadRecordset()))
			$vw_set_tanggal_pulang_list->TotalRecs = $vw_set_tanggal_pulang_list->Recordset->RecordCount();
	}
	$vw_set_tanggal_pulang_list->StartRec = 1;
	if ($vw_set_tanggal_pulang_list->DisplayRecs <= 0 || ($vw_set_tanggal_pulang->Export <> "" && $vw_set_tanggal_pulang->ExportAll)) // Display all records
		$vw_set_tanggal_pulang_list->DisplayRecs = $vw_set_tanggal_pulang_list->TotalRecs;
	if (!($vw_set_tanggal_pulang->Export <> "" && $vw_set_tanggal_pulang->ExportAll))
		$vw_set_tanggal_pulang_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_set_tanggal_pulang_list->Recordset = $vw_set_tanggal_pulang_list->LoadRecordset($vw_set_tanggal_pulang_list->StartRec-1, $vw_set_tanggal_pulang_list->DisplayRecs);

	// Set no record found message
	if ($vw_set_tanggal_pulang->CurrentAction == "" && $vw_set_tanggal_pulang_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_set_tanggal_pulang_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_set_tanggal_pulang_list->SearchWhere == "0=101")
			$vw_set_tanggal_pulang_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_set_tanggal_pulang_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$vw_set_tanggal_pulang_list->RenderOtherOptions();
?>
<?php $vw_set_tanggal_pulang_list->ShowPageHeader(); ?>
<?php
$vw_set_tanggal_pulang_list->ShowMessage();
?>
<?php if ($vw_set_tanggal_pulang_list->TotalRecs > 0 || $vw_set_tanggal_pulang->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_set_tanggal_pulang">
<form name="fvw_set_tanggal_pulanglist" id="fvw_set_tanggal_pulanglist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_set_tanggal_pulang_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_set_tanggal_pulang_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_set_tanggal_pulang">
<div id="gmp_vw_set_tanggal_pulang" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_set_tanggal_pulang_list->TotalRecs > 0 || $vw_set_tanggal_pulang->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_set_tanggal_pulanglist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_set_tanggal_pulang->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_set_tanggal_pulang_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_set_tanggal_pulang_list->RenderListOptions();

// Render list options (header, left)
$vw_set_tanggal_pulang_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_set_tanggal_pulang->id_admission->Visible) { // id_admission ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->id_admission) == "") { ?>
		<th data-name="id_admission"><div id="elh_vw_set_tanggal_pulang_id_admission" class="vw_set_tanggal_pulang_id_admission"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->id_admission->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_admission"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->id_admission) ?>',2);"><div id="elh_vw_set_tanggal_pulang_id_admission" class="vw_set_tanggal_pulang_id_admission">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->id_admission->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->id_admission->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->id_admission->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->nomr->Visible) { // nomr ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->nomr) == "") { ?>
		<th data-name="nomr"><div id="elh_vw_set_tanggal_pulang_nomr" class="vw_set_tanggal_pulang_nomr"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->nomr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomr"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->nomr) ?>',2);"><div id="elh_vw_set_tanggal_pulang_nomr" class="vw_set_tanggal_pulang_nomr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->nomr->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->nomr->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->nomr->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->ket_nama->Visible) { // ket_nama ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->ket_nama) == "") { ?>
		<th data-name="ket_nama"><div id="elh_vw_set_tanggal_pulang_ket_nama" class="vw_set_tanggal_pulang_ket_nama"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->ket_nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ket_nama"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->ket_nama) ?>',2);"><div id="elh_vw_set_tanggal_pulang_ket_nama" class="vw_set_tanggal_pulang_ket_nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->ket_nama->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->ket_nama->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->ket_nama->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->ket_alamat->Visible) { // ket_alamat ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->ket_alamat) == "") { ?>
		<th data-name="ket_alamat"><div id="elh_vw_set_tanggal_pulang_ket_alamat" class="vw_set_tanggal_pulang_ket_alamat"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->ket_alamat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ket_alamat"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->ket_alamat) ?>',2);"><div id="elh_vw_set_tanggal_pulang_ket_alamat" class="vw_set_tanggal_pulang_ket_alamat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->ket_alamat->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->ket_alamat->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->ket_alamat->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->statusbayar->Visible) { // statusbayar ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->statusbayar) == "") { ?>
		<th data-name="statusbayar"><div id="elh_vw_set_tanggal_pulang_statusbayar" class="vw_set_tanggal_pulang_statusbayar"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->statusbayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="statusbayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->statusbayar) ?>',2);"><div id="elh_vw_set_tanggal_pulang_statusbayar" class="vw_set_tanggal_pulang_statusbayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->statusbayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->statusbayar->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->statusbayar->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->masukrs->Visible) { // masukrs ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->masukrs) == "") { ?>
		<th data-name="masukrs"><div id="elh_vw_set_tanggal_pulang_masukrs" class="vw_set_tanggal_pulang_masukrs"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->masukrs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="masukrs"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->masukrs) ?>',2);"><div id="elh_vw_set_tanggal_pulang_masukrs" class="vw_set_tanggal_pulang_masukrs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->masukrs->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->masukrs->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->masukrs->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->noruang->Visible) { // noruang ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->noruang) == "") { ?>
		<th data-name="noruang"><div id="elh_vw_set_tanggal_pulang_noruang" class="vw_set_tanggal_pulang_noruang"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->noruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="noruang"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->noruang) ?>',2);"><div id="elh_vw_set_tanggal_pulang_noruang" class="vw_set_tanggal_pulang_noruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->noruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->noruang->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->noruang->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->dokter_penanggungjawab->Visible) { // dokter_penanggungjawab ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->dokter_penanggungjawab) == "") { ?>
		<th data-name="dokter_penanggungjawab"><div id="elh_vw_set_tanggal_pulang_dokter_penanggungjawab" class="vw_set_tanggal_pulang_dokter_penanggungjawab"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dokter_penanggungjawab"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->dokter_penanggungjawab) ?>',2);"><div id="elh_vw_set_tanggal_pulang_dokter_penanggungjawab" class="vw_set_tanggal_pulang_dokter_penanggungjawab">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->dokter_penanggungjawab->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->dokter_penanggungjawab->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->KELASPERAWATAN_ID) == "") { ?>
		<th data-name="KELASPERAWATAN_ID"><div id="elh_vw_set_tanggal_pulang_KELASPERAWATAN_ID" class="vw_set_tanggal_pulang_KELASPERAWATAN_ID"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KELASPERAWATAN_ID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->KELASPERAWATAN_ID) ?>',2);"><div id="elh_vw_set_tanggal_pulang_KELASPERAWATAN_ID" class="vw_set_tanggal_pulang_KELASPERAWATAN_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->KELASPERAWATAN_ID->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->KELASPERAWATAN_ID->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_set_tanggal_pulang->NO_SKP->Visible) { // NO_SKP ?>
	<?php if ($vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->NO_SKP) == "") { ?>
		<th data-name="NO_SKP"><div id="elh_vw_set_tanggal_pulang_NO_SKP" class="vw_set_tanggal_pulang_NO_SKP"><div class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->NO_SKP->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NO_SKP"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_set_tanggal_pulang->SortUrl($vw_set_tanggal_pulang->NO_SKP) ?>',2);"><div id="elh_vw_set_tanggal_pulang_NO_SKP" class="vw_set_tanggal_pulang_NO_SKP">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_set_tanggal_pulang->NO_SKP->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_set_tanggal_pulang->NO_SKP->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_set_tanggal_pulang->NO_SKP->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_set_tanggal_pulang_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_set_tanggal_pulang->ExportAll && $vw_set_tanggal_pulang->Export <> "") {
	$vw_set_tanggal_pulang_list->StopRec = $vw_set_tanggal_pulang_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_set_tanggal_pulang_list->TotalRecs > $vw_set_tanggal_pulang_list->StartRec + $vw_set_tanggal_pulang_list->DisplayRecs - 1)
		$vw_set_tanggal_pulang_list->StopRec = $vw_set_tanggal_pulang_list->StartRec + $vw_set_tanggal_pulang_list->DisplayRecs - 1;
	else
		$vw_set_tanggal_pulang_list->StopRec = $vw_set_tanggal_pulang_list->TotalRecs;
}
$vw_set_tanggal_pulang_list->RecCnt = $vw_set_tanggal_pulang_list->StartRec - 1;
if ($vw_set_tanggal_pulang_list->Recordset && !$vw_set_tanggal_pulang_list->Recordset->EOF) {
	$vw_set_tanggal_pulang_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_set_tanggal_pulang_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_set_tanggal_pulang_list->StartRec > 1)
		$vw_set_tanggal_pulang_list->Recordset->Move($vw_set_tanggal_pulang_list->StartRec - 1);
} elseif (!$vw_set_tanggal_pulang->AllowAddDeleteRow && $vw_set_tanggal_pulang_list->StopRec == 0) {
	$vw_set_tanggal_pulang_list->StopRec = $vw_set_tanggal_pulang->GridAddRowCount;
}

// Initialize aggregate
$vw_set_tanggal_pulang->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_set_tanggal_pulang->ResetAttrs();
$vw_set_tanggal_pulang_list->RenderRow();
while ($vw_set_tanggal_pulang_list->RecCnt < $vw_set_tanggal_pulang_list->StopRec) {
	$vw_set_tanggal_pulang_list->RecCnt++;
	if (intval($vw_set_tanggal_pulang_list->RecCnt) >= intval($vw_set_tanggal_pulang_list->StartRec)) {
		$vw_set_tanggal_pulang_list->RowCnt++;

		// Set up key count
		$vw_set_tanggal_pulang_list->KeyCount = $vw_set_tanggal_pulang_list->RowIndex;

		// Init row class and style
		$vw_set_tanggal_pulang->ResetAttrs();
		$vw_set_tanggal_pulang->CssClass = "";
		if ($vw_set_tanggal_pulang->CurrentAction == "gridadd") {
		} else {
			$vw_set_tanggal_pulang_list->LoadRowValues($vw_set_tanggal_pulang_list->Recordset); // Load row values
		}
		$vw_set_tanggal_pulang->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vw_set_tanggal_pulang->RowAttrs = array_merge($vw_set_tanggal_pulang->RowAttrs, array('data-rowindex'=>$vw_set_tanggal_pulang_list->RowCnt, 'id'=>'r' . $vw_set_tanggal_pulang_list->RowCnt . '_vw_set_tanggal_pulang', 'data-rowtype'=>$vw_set_tanggal_pulang->RowType));

		// Render row
		$vw_set_tanggal_pulang_list->RenderRow();

		// Render list options
		$vw_set_tanggal_pulang_list->RenderListOptions();
?>
	<tr<?php echo $vw_set_tanggal_pulang->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_set_tanggal_pulang_list->ListOptions->Render("body", "left", $vw_set_tanggal_pulang_list->RowCnt);
?>
	<?php if ($vw_set_tanggal_pulang->id_admission->Visible) { // id_admission ?>
		<td data-name="id_admission"<?php echo $vw_set_tanggal_pulang->id_admission->CellAttributes() ?>>
<div id="orig<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_id_admission" class="hide">
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_id_admission" class="vw_set_tanggal_pulang_id_admission">
<span<?php echo $vw_set_tanggal_pulang->id_admission->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->id_admission->ListViewValue() ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r==5)
{ ?>
	<a class="btn btn-warning btn-xs" 
	target="_self"
	href="vw_set_tanggal_pulangedit.php?id_admission=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>" >Input Resume Pulang <span class="glyphicon glyphicon-print" aria-hidden="true"></span> 
	</a>
<?php
}else { print '-'; }
?>
<a id="<?php echo $vw_set_tanggal_pulang_list->PageObjName . "_row_" . $vw_set_tanggal_pulang_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->nomr->Visible) { // nomr ?>
		<td data-name="nomr"<?php echo $vw_set_tanggal_pulang->nomr->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_nomr" class="vw_set_tanggal_pulang_nomr">
<span<?php echo $vw_set_tanggal_pulang->nomr->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->nomr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->ket_nama->Visible) { // ket_nama ?>
		<td data-name="ket_nama"<?php echo $vw_set_tanggal_pulang->ket_nama->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_ket_nama" class="vw_set_tanggal_pulang_ket_nama">
<span<?php echo $vw_set_tanggal_pulang->ket_nama->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->ket_nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->ket_alamat->Visible) { // ket_alamat ?>
		<td data-name="ket_alamat"<?php echo $vw_set_tanggal_pulang->ket_alamat->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_ket_alamat" class="vw_set_tanggal_pulang_ket_alamat">
<span<?php echo $vw_set_tanggal_pulang->ket_alamat->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->ket_alamat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->statusbayar->Visible) { // statusbayar ?>
		<td data-name="statusbayar"<?php echo $vw_set_tanggal_pulang->statusbayar->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_statusbayar" class="vw_set_tanggal_pulang_statusbayar">
<span<?php echo $vw_set_tanggal_pulang->statusbayar->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->statusbayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->masukrs->Visible) { // masukrs ?>
		<td data-name="masukrs"<?php echo $vw_set_tanggal_pulang->masukrs->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_masukrs" class="vw_set_tanggal_pulang_masukrs">
<span<?php echo $vw_set_tanggal_pulang->masukrs->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->masukrs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->noruang->Visible) { // noruang ?>
		<td data-name="noruang"<?php echo $vw_set_tanggal_pulang->noruang->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_noruang" class="vw_set_tanggal_pulang_noruang">
<span<?php echo $vw_set_tanggal_pulang->noruang->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->noruang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->dokter_penanggungjawab->Visible) { // dokter_penanggungjawab ?>
		<td data-name="dokter_penanggungjawab"<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_dokter_penanggungjawab" class="vw_set_tanggal_pulang_dokter_penanggungjawab">
<span<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
		<td data-name="KELASPERAWATAN_ID"<?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_KELASPERAWATAN_ID" class="vw_set_tanggal_pulang_KELASPERAWATAN_ID">
<span<?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_set_tanggal_pulang->NO_SKP->Visible) { // NO_SKP ?>
		<td data-name="NO_SKP"<?php echo $vw_set_tanggal_pulang->NO_SKP->CellAttributes() ?>>
<span id="el<?php echo $vw_set_tanggal_pulang_list->RowCnt ?>_vw_set_tanggal_pulang_NO_SKP" class="vw_set_tanggal_pulang_NO_SKP">
<span<?php echo $vw_set_tanggal_pulang->NO_SKP->ViewAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->NO_SKP->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_set_tanggal_pulang_list->ListOptions->Render("body", "right", $vw_set_tanggal_pulang_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($vw_set_tanggal_pulang->CurrentAction <> "gridadd")
		$vw_set_tanggal_pulang_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_set_tanggal_pulang_list->Recordset)
	$vw_set_tanggal_pulang_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_set_tanggal_pulang->CurrentAction <> "gridadd" && $vw_set_tanggal_pulang->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_set_tanggal_pulang_list->Pager)) $vw_set_tanggal_pulang_list->Pager = new cPrevNextPager($vw_set_tanggal_pulang_list->StartRec, $vw_set_tanggal_pulang_list->DisplayRecs, $vw_set_tanggal_pulang_list->TotalRecs) ?>
<?php if ($vw_set_tanggal_pulang_list->Pager->RecordCount > 0 && $vw_set_tanggal_pulang_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_set_tanggal_pulang_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_set_tanggal_pulang_list->PageUrl() ?>start=<?php echo $vw_set_tanggal_pulang_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_set_tanggal_pulang_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_set_tanggal_pulang_list->PageUrl() ?>start=<?php echo $vw_set_tanggal_pulang_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_set_tanggal_pulang_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_set_tanggal_pulang_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_set_tanggal_pulang_list->PageUrl() ?>start=<?php echo $vw_set_tanggal_pulang_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_set_tanggal_pulang_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_set_tanggal_pulang_list->PageUrl() ?>start=<?php echo $vw_set_tanggal_pulang_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_set_tanggal_pulang_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_set_tanggal_pulang_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_set_tanggal_pulang_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_set_tanggal_pulang_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_set_tanggal_pulang_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_set_tanggal_pulang">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_set_tanggal_pulang_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_set_tanggal_pulang_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_set_tanggal_pulang_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_set_tanggal_pulang_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_set_tanggal_pulang_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_set_tanggal_pulang_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang_list->TotalRecs == 0 && $vw_set_tanggal_pulang->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_set_tanggal_pulang_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_set_tanggal_pulanglistsrch.FilterList = <?php echo $vw_set_tanggal_pulang_list->GetFilterList() ?>;
fvw_set_tanggal_pulanglistsrch.Init();
fvw_set_tanggal_pulanglist.Init();
</script>
<?php
$vw_set_tanggal_pulang_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_set_tanggal_pulang_list->Page_Terminate();
?>
