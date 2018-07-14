<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_pengembalian_penerimaaninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_spp_pengembalian_penerimaan_detail_belanjagridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_pengembalian_penerimaan_list = NULL; // Initialize page object first

class cvw_spp_pengembalian_penerimaan_list extends cvw_spp_pengembalian_penerimaan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_pengembalian_penerimaan';

	// Page object name
	var $PageObjName = 'vw_spp_pengembalian_penerimaan_list';

	// Grid form hidden field names
	var $FormName = 'fvw_spp_pengembalian_penerimaanlist';
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

		// Table object (vw_spp_pengembalian_penerimaan)
		if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan"]) || get_class($GLOBALS["vw_spp_pengembalian_penerimaan"]) == "cvw_spp_pengembalian_penerimaan") {
			$GLOBALS["vw_spp_pengembalian_penerimaan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_pengembalian_penerimaan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_spp_pengembalian_penerimaanadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_spp_pengembalian_penerimaandelete.php";
		$this->MultiUpdateUrl = "vw_spp_pengembalian_penerimaanupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_pengembalian_penerimaan', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_spp_pengembalian_penerimaanlistsrch";

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
		$this->status_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();

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

			// Process auto fill for detail table 'vw_spp_pengembalian_penerimaan_detail_belanja'
			if (@$_POST["grid"] == "fvw_spp_pengembalian_penerimaan_detail_belanjagrid") {
				if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"])) $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"] = new cvw_spp_pengembalian_penerimaan_detail_belanja_grid;
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $vw_spp_pengembalian_penerimaan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_pengembalian_penerimaan);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_spp_pengembalian_penerimaanlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->id_jenis_spp->AdvancedSearch->ToJSON(), ","); // Field id_jenis_spp
		$sFilterList = ew_Concat($sFilterList, $this->detail_jenis_spp->AdvancedSearch->ToJSON(), ","); // Field detail_jenis_spp
		$sFilterList = ew_Concat($sFilterList, $this->status_spp->AdvancedSearch->ToJSON(), ","); // Field status_spp
		$sFilterList = ew_Concat($sFilterList, $this->kode_program->AdvancedSearch->ToJSON(), ","); // Field kode_program
		$sFilterList = ew_Concat($sFilterList, $this->kode_kegiatan->AdvancedSearch->ToJSON(), ","); // Field kode_kegiatan
		$sFilterList = ew_Concat($sFilterList, $this->kode_sub_kegiatan->AdvancedSearch->ToJSON(), ","); // Field kode_sub_kegiatan
		$sFilterList = ew_Concat($sFilterList, $this->no_spp->AdvancedSearch->ToJSON(), ","); // Field no_spp
		$sFilterList = ew_Concat($sFilterList, $this->nama_bendahara->AdvancedSearch->ToJSON(), ","); // Field nama_bendahara
		$sFilterList = ew_Concat($sFilterList, $this->nip_bendahara->AdvancedSearch->ToJSON(), ","); // Field nip_bendahara
		$sFilterList = ew_Concat($sFilterList, $this->tgl_spp->AdvancedSearch->ToJSON(), ","); // Field tgl_spp
		$sFilterList = ew_Concat($sFilterList, $this->kode_rekening->AdvancedSearch->ToJSON(), ","); // Field kode_rekening
		$sFilterList = ew_Concat($sFilterList, $this->keterangan->AdvancedSearch->ToJSON(), ","); // Field keterangan
		$sFilterList = ew_Concat($sFilterList, $this->tahun_anggaran->AdvancedSearch->ToJSON(), ","); // Field tahun_anggaran
		$sFilterList = ew_Concat($sFilterList, $this->id_spd->AdvancedSearch->ToJSON(), ","); // Field id_spd
		$sFilterList = ew_Concat($sFilterList, $this->tanggal_spd->AdvancedSearch->ToJSON(), ","); // Field tanggal_spd
		$sFilterList = ew_Concat($sFilterList, $this->nomer_dasar_spd->AdvancedSearch->ToJSON(), ","); // Field nomer_dasar_spd
		$sFilterList = ew_Concat($sFilterList, $this->jumlah_spd->AdvancedSearch->ToJSON(), ","); // Field jumlah_spd
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_spp_pengembalian_penerimaanlistsrch", $filters);

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

		// Field id_jenis_spp
		$this->id_jenis_spp->AdvancedSearch->SearchValue = @$filter["x_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchOperator = @$filter["z_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchCondition = @$filter["v_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchValue2 = @$filter["y_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchOperator2 = @$filter["w_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->Save();

		// Field detail_jenis_spp
		$this->detail_jenis_spp->AdvancedSearch->SearchValue = @$filter["x_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchOperator = @$filter["z_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchCondition = @$filter["v_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchValue2 = @$filter["y_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchOperator2 = @$filter["w_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->Save();

		// Field status_spp
		$this->status_spp->AdvancedSearch->SearchValue = @$filter["x_status_spp"];
		$this->status_spp->AdvancedSearch->SearchOperator = @$filter["z_status_spp"];
		$this->status_spp->AdvancedSearch->SearchCondition = @$filter["v_status_spp"];
		$this->status_spp->AdvancedSearch->SearchValue2 = @$filter["y_status_spp"];
		$this->status_spp->AdvancedSearch->SearchOperator2 = @$filter["w_status_spp"];
		$this->status_spp->AdvancedSearch->Save();

		// Field kode_program
		$this->kode_program->AdvancedSearch->SearchValue = @$filter["x_kode_program"];
		$this->kode_program->AdvancedSearch->SearchOperator = @$filter["z_kode_program"];
		$this->kode_program->AdvancedSearch->SearchCondition = @$filter["v_kode_program"];
		$this->kode_program->AdvancedSearch->SearchValue2 = @$filter["y_kode_program"];
		$this->kode_program->AdvancedSearch->SearchOperator2 = @$filter["w_kode_program"];
		$this->kode_program->AdvancedSearch->Save();

		// Field kode_kegiatan
		$this->kode_kegiatan->AdvancedSearch->SearchValue = @$filter["x_kode_kegiatan"];
		$this->kode_kegiatan->AdvancedSearch->SearchOperator = @$filter["z_kode_kegiatan"];
		$this->kode_kegiatan->AdvancedSearch->SearchCondition = @$filter["v_kode_kegiatan"];
		$this->kode_kegiatan->AdvancedSearch->SearchValue2 = @$filter["y_kode_kegiatan"];
		$this->kode_kegiatan->AdvancedSearch->SearchOperator2 = @$filter["w_kode_kegiatan"];
		$this->kode_kegiatan->AdvancedSearch->Save();

		// Field kode_sub_kegiatan
		$this->kode_sub_kegiatan->AdvancedSearch->SearchValue = @$filter["x_kode_sub_kegiatan"];
		$this->kode_sub_kegiatan->AdvancedSearch->SearchOperator = @$filter["z_kode_sub_kegiatan"];
		$this->kode_sub_kegiatan->AdvancedSearch->SearchCondition = @$filter["v_kode_sub_kegiatan"];
		$this->kode_sub_kegiatan->AdvancedSearch->SearchValue2 = @$filter["y_kode_sub_kegiatan"];
		$this->kode_sub_kegiatan->AdvancedSearch->SearchOperator2 = @$filter["w_kode_sub_kegiatan"];
		$this->kode_sub_kegiatan->AdvancedSearch->Save();

		// Field no_spp
		$this->no_spp->AdvancedSearch->SearchValue = @$filter["x_no_spp"];
		$this->no_spp->AdvancedSearch->SearchOperator = @$filter["z_no_spp"];
		$this->no_spp->AdvancedSearch->SearchCondition = @$filter["v_no_spp"];
		$this->no_spp->AdvancedSearch->SearchValue2 = @$filter["y_no_spp"];
		$this->no_spp->AdvancedSearch->SearchOperator2 = @$filter["w_no_spp"];
		$this->no_spp->AdvancedSearch->Save();

		// Field nama_bendahara
		$this->nama_bendahara->AdvancedSearch->SearchValue = @$filter["x_nama_bendahara"];
		$this->nama_bendahara->AdvancedSearch->SearchOperator = @$filter["z_nama_bendahara"];
		$this->nama_bendahara->AdvancedSearch->SearchCondition = @$filter["v_nama_bendahara"];
		$this->nama_bendahara->AdvancedSearch->SearchValue2 = @$filter["y_nama_bendahara"];
		$this->nama_bendahara->AdvancedSearch->SearchOperator2 = @$filter["w_nama_bendahara"];
		$this->nama_bendahara->AdvancedSearch->Save();

		// Field nip_bendahara
		$this->nip_bendahara->AdvancedSearch->SearchValue = @$filter["x_nip_bendahara"];
		$this->nip_bendahara->AdvancedSearch->SearchOperator = @$filter["z_nip_bendahara"];
		$this->nip_bendahara->AdvancedSearch->SearchCondition = @$filter["v_nip_bendahara"];
		$this->nip_bendahara->AdvancedSearch->SearchValue2 = @$filter["y_nip_bendahara"];
		$this->nip_bendahara->AdvancedSearch->SearchOperator2 = @$filter["w_nip_bendahara"];
		$this->nip_bendahara->AdvancedSearch->Save();

		// Field tgl_spp
		$this->tgl_spp->AdvancedSearch->SearchValue = @$filter["x_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchOperator = @$filter["z_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchCondition = @$filter["v_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchValue2 = @$filter["y_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->Save();

		// Field kode_rekening
		$this->kode_rekening->AdvancedSearch->SearchValue = @$filter["x_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchOperator = @$filter["z_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchCondition = @$filter["v_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchValue2 = @$filter["y_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->SearchOperator2 = @$filter["w_kode_rekening"];
		$this->kode_rekening->AdvancedSearch->Save();

		// Field keterangan
		$this->keterangan->AdvancedSearch->SearchValue = @$filter["x_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator = @$filter["z_keterangan"];
		$this->keterangan->AdvancedSearch->SearchCondition = @$filter["v_keterangan"];
		$this->keterangan->AdvancedSearch->SearchValue2 = @$filter["y_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_keterangan"];
		$this->keterangan->AdvancedSearch->Save();

		// Field tahun_anggaran
		$this->tahun_anggaran->AdvancedSearch->SearchValue = @$filter["x_tahun_anggaran"];
		$this->tahun_anggaran->AdvancedSearch->SearchOperator = @$filter["z_tahun_anggaran"];
		$this->tahun_anggaran->AdvancedSearch->SearchCondition = @$filter["v_tahun_anggaran"];
		$this->tahun_anggaran->AdvancedSearch->SearchValue2 = @$filter["y_tahun_anggaran"];
		$this->tahun_anggaran->AdvancedSearch->SearchOperator2 = @$filter["w_tahun_anggaran"];
		$this->tahun_anggaran->AdvancedSearch->Save();

		// Field id_spd
		$this->id_spd->AdvancedSearch->SearchValue = @$filter["x_id_spd"];
		$this->id_spd->AdvancedSearch->SearchOperator = @$filter["z_id_spd"];
		$this->id_spd->AdvancedSearch->SearchCondition = @$filter["v_id_spd"];
		$this->id_spd->AdvancedSearch->SearchValue2 = @$filter["y_id_spd"];
		$this->id_spd->AdvancedSearch->SearchOperator2 = @$filter["w_id_spd"];
		$this->id_spd->AdvancedSearch->Save();

		// Field tanggal_spd
		$this->tanggal_spd->AdvancedSearch->SearchValue = @$filter["x_tanggal_spd"];
		$this->tanggal_spd->AdvancedSearch->SearchOperator = @$filter["z_tanggal_spd"];
		$this->tanggal_spd->AdvancedSearch->SearchCondition = @$filter["v_tanggal_spd"];
		$this->tanggal_spd->AdvancedSearch->SearchValue2 = @$filter["y_tanggal_spd"];
		$this->tanggal_spd->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal_spd"];
		$this->tanggal_spd->AdvancedSearch->Save();

		// Field nomer_dasar_spd
		$this->nomer_dasar_spd->AdvancedSearch->SearchValue = @$filter["x_nomer_dasar_spd"];
		$this->nomer_dasar_spd->AdvancedSearch->SearchOperator = @$filter["z_nomer_dasar_spd"];
		$this->nomer_dasar_spd->AdvancedSearch->SearchCondition = @$filter["v_nomer_dasar_spd"];
		$this->nomer_dasar_spd->AdvancedSearch->SearchValue2 = @$filter["y_nomer_dasar_spd"];
		$this->nomer_dasar_spd->AdvancedSearch->SearchOperator2 = @$filter["w_nomer_dasar_spd"];
		$this->nomer_dasar_spd->AdvancedSearch->Save();

		// Field jumlah_spd
		$this->jumlah_spd->AdvancedSearch->SearchValue = @$filter["x_jumlah_spd"];
		$this->jumlah_spd->AdvancedSearch->SearchOperator = @$filter["z_jumlah_spd"];
		$this->jumlah_spd->AdvancedSearch->SearchCondition = @$filter["v_jumlah_spd"];
		$this->jumlah_spd->AdvancedSearch->SearchValue2 = @$filter["y_jumlah_spd"];
		$this->jumlah_spd->AdvancedSearch->SearchOperator2 = @$filter["w_jumlah_spd"];
		$this->jumlah_spd->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->kode_program, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_kegiatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_sub_kegiatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_spp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_bendahara, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nip_bendahara, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_rekening, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->keterangan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomer_dasar_spd, $arKeywords, $type);
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
			$this->UpdateSort($this->status_spp, $bCtrl); // status_spp
			$this->UpdateSort($this->no_spp, $bCtrl); // no_spp
			$this->UpdateSort($this->tgl_spp, $bCtrl); // tgl_spp
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
				$this->status_spp->setSort("");
				$this->no_spp->setSort("");
				$this->tgl_spp->setSort("");
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

		// "detail_vw_spp_pengembalian_penerimaan_detail_belanja"
		$item = &$this->ListOptions->Add("detail_vw_spp_pengembalian_penerimaan_detail_belanja");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_spp_pengembalian_penerimaan_detail_belanja') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"])) $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"] = new cvw_spp_pengembalian_penerimaan_detail_belanja_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("vw_spp_pengembalian_penerimaan_detail_belanja");
		$this->DetailPages = $pages;

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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_vw_spp_pengembalian_penerimaan_detail_belanja"
		$oListOpt = &$this->ListOptions->Items["detail_vw_spp_pengembalian_penerimaan_detail_belanja"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_spp_pengembalian_penerimaan_detail_belanja')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_spp_pengembalian_penerimaan_detail_belanja", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_spp_pengembalian_penerimaan_detail_belanjalist.php?" . EW_TABLE_SHOW_MASTER . "=vw_spp_pengembalian_penerimaan&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "&fk_id_jenis_spp=" . urlencode(strval($this->id_jenis_spp->CurrentValue)) . "&fk_detail_jenis_spp=" . urlencode(strval($this->detail_jenis_spp->CurrentValue)) . "&fk_no_spp=" . urlencode(strval($this->no_spp->CurrentValue)) . "&fk_kode_program=" . urlencode(strval($this->kode_program->CurrentValue)) . "&fk_kode_kegiatan=" . urlencode(strval($this->kode_kegiatan->CurrentValue)) . "&fk_kode_sub_kegiatan=" . urlencode(strval($this->kode_sub_kegiatan->CurrentValue)) . "&fk_tahun_anggaran=" . urlencode(strval($this->tahun_anggaran->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_spp_pengembalian_penerimaan_detail_belanja')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_spp_pengembalian_penerimaan_detail_belanja")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_spp_pengembalian_penerimaan_detail_belanja";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"btn btn-info btn-xs\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"btn btn-success btn-xs\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewMasterDetail btn-xs\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
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
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_vw_spp_pengembalian_penerimaan_detail_belanja");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_spp_pengembalian_penerimaan_detail_belanja");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_spp_pengembalian_penerimaan_detail_belanja') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_spp_pengembalian_penerimaan_detail_belanja";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $Language->Phrase("AddMasterDetailLink") . " " . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_spp_pengembalian_penerimaanlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_spp_pengembalian_penerimaanlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_spp_pengembalian_penerimaanlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fvw_spp_pengembalian_penerimaanlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->status_spp->setDbValue($rs->fields('status_spp'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->status_spp->DbValue = $row['status_spp'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->tgl_spp->DbValue = $row['tgl_spp'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->id_spd->DbValue = $row['id_spd'];
		$this->tanggal_spd->DbValue = $row['tanggal_spd'];
		$this->nomer_dasar_spd->DbValue = $row['nomer_dasar_spd'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
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
		// id_jenis_spp
		// detail_jenis_spp
		// status_spp
		// kode_program
		// kode_kegiatan
		// kode_sub_kegiatan
		// no_spp
		// nama_bendahara
		// nip_bendahara
		// tgl_spp
		// kode_rekening
		// keterangan
		// tahun_anggaran
		// id_spd
		// tanggal_spd
		// nomer_dasar_spd
		// jumlah_spd

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_jenis_spp
		if (strval($this->id_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_spp`";
		$sWhereWrk = "";
		$this->id_jenis_spp->LookupFilters = array();
		$lookuptblfilter = "`id`= 5";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
			}
		} else {
			$this->id_jenis_spp->ViewValue = NULL;
		}
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// detail_jenis_spp
		if (strval($this->detail_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->detail_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_detail_spp`";
		$sWhereWrk = "";
		$this->detail_jenis_spp->LookupFilters = array();
		$lookuptblfilter = "`id`=10";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
			}
		} else {
			$this->detail_jenis_spp->ViewValue = NULL;
		}
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// status_spp
		if (strval($this->status_spp->CurrentValue) <> "") {
			$this->status_spp->ViewValue = $this->status_spp->OptionCaption($this->status_spp->CurrentValue);
		} else {
			$this->status_spp->ViewValue = NULL;
		}
		$this->status_spp->ViewCustomAttributes = "";

		// kode_program
		if (strval($this->kode_program->CurrentValue) <> "") {
			$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->kode_program->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
		$sWhereWrk = "";
		$this->kode_program->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_program, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_program->ViewValue = $this->kode_program->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
			}
		} else {
			$this->kode_program->ViewValue = NULL;
		}
		$this->kode_program->ViewCustomAttributes = "";

		// kode_kegiatan
		if (strval($this->kode_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kode_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
		$sWhereWrk = "";
		$this->kode_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->CurrentValue;
			}
		} else {
			$this->kode_kegiatan->ViewValue = NULL;
		}
		$this->kode_kegiatan->ViewCustomAttributes = "";

		// kode_sub_kegiatan
		if (strval($this->kode_sub_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->kode_sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
		$sWhereWrk = "";
		$this->kode_sub_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_sub_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->CurrentValue;
			}
		} else {
			$this->kode_sub_kegiatan->ViewValue = NULL;
		}
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// nama_bendahara
		if (strval($this->nama_bendahara->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_bendahara->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_bendahara->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->CurrentValue;
			}
		} else {
			$this->nama_bendahara->ViewValue = NULL;
		}
		$this->nama_bendahara->ViewCustomAttributes = "";

		// nip_bendahara
		$this->nip_bendahara->ViewValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->ViewCustomAttributes = "";

		// tgl_spp
		$this->tgl_spp->ViewValue = $this->tgl_spp->CurrentValue;
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 7);
		$this->tgl_spp->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// id_spd
		$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
		$this->id_spd->ViewCustomAttributes = "";

		// tanggal_spd
		$this->tanggal_spd->ViewValue = $this->tanggal_spd->CurrentValue;
		$this->tanggal_spd->ViewValue = ew_FormatDateTime($this->tanggal_spd->ViewValue, 0);
		$this->tanggal_spd->ViewCustomAttributes = "";

		// nomer_dasar_spd
		$this->nomer_dasar_spd->ViewValue = $this->nomer_dasar_spd->CurrentValue;
		$this->nomer_dasar_spd->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// status_spp
			$this->status_spp->LinkCustomAttributes = "";
			$this->status_spp->HrefValue = "";
			$this->status_spp->TooltipValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";
			$this->no_spp->TooltipValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";
			$this->tgl_spp->TooltipValue = "";
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
if (!isset($vw_spp_pengembalian_penerimaan_list)) $vw_spp_pengembalian_penerimaan_list = new cvw_spp_pengembalian_penerimaan_list();

// Page init
$vw_spp_pengembalian_penerimaan_list->Page_Init();

// Page main
$vw_spp_pengembalian_penerimaan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_pengembalian_penerimaan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_spp_pengembalian_penerimaanlist = new ew_Form("fvw_spp_pengembalian_penerimaanlist", "list");
fvw_spp_pengembalian_penerimaanlist.FormKeyCountName = '<?php echo $vw_spp_pengembalian_penerimaan_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvw_spp_pengembalian_penerimaanlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_pengembalian_penerimaanlist.ValidateRequired = true;
<?php } else { ?>
fvw_spp_pengembalian_penerimaanlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_pengembalian_penerimaanlist.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spp_pengembalian_penerimaanlist.Lists["x_status_spp"].Options = <?php echo json_encode($vw_spp_pengembalian_penerimaan->status_spp->Options()) ?>;

// Form object for search
var CurrentSearchForm = fvw_spp_pengembalian_penerimaanlistsrch = new ew_Form("fvw_spp_pengembalian_penerimaanlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_spp_pengembalian_penerimaan_list->TotalRecs > 0 && $vw_spp_pengembalian_penerimaan_list->ExportOptions->Visible()) { ?>
<?php $vw_spp_pengembalian_penerimaan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_list->SearchOptions->Visible()) { ?>
<?php $vw_spp_pengembalian_penerimaan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_list->FilterOptions->Visible()) { ?>
<?php $vw_spp_pengembalian_penerimaan_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $vw_spp_pengembalian_penerimaan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_spp_pengembalian_penerimaan_list->TotalRecs <= 0)
			$vw_spp_pengembalian_penerimaan_list->TotalRecs = $vw_spp_pengembalian_penerimaan->SelectRecordCount();
	} else {
		if (!$vw_spp_pengembalian_penerimaan_list->Recordset && ($vw_spp_pengembalian_penerimaan_list->Recordset = $vw_spp_pengembalian_penerimaan_list->LoadRecordset()))
			$vw_spp_pengembalian_penerimaan_list->TotalRecs = $vw_spp_pengembalian_penerimaan_list->Recordset->RecordCount();
	}
	$vw_spp_pengembalian_penerimaan_list->StartRec = 1;
	if ($vw_spp_pengembalian_penerimaan_list->DisplayRecs <= 0 || ($vw_spp_pengembalian_penerimaan->Export <> "" && $vw_spp_pengembalian_penerimaan->ExportAll)) // Display all records
		$vw_spp_pengembalian_penerimaan_list->DisplayRecs = $vw_spp_pengembalian_penerimaan_list->TotalRecs;
	if (!($vw_spp_pengembalian_penerimaan->Export <> "" && $vw_spp_pengembalian_penerimaan->ExportAll))
		$vw_spp_pengembalian_penerimaan_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_spp_pengembalian_penerimaan_list->Recordset = $vw_spp_pengembalian_penerimaan_list->LoadRecordset($vw_spp_pengembalian_penerimaan_list->StartRec-1, $vw_spp_pengembalian_penerimaan_list->DisplayRecs);

	// Set no record found message
	if ($vw_spp_pengembalian_penerimaan->CurrentAction == "" && $vw_spp_pengembalian_penerimaan_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_spp_pengembalian_penerimaan_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_spp_pengembalian_penerimaan_list->SearchWhere == "0=101")
			$vw_spp_pengembalian_penerimaan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_spp_pengembalian_penerimaan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$vw_spp_pengembalian_penerimaan_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($vw_spp_pengembalian_penerimaan->Export == "" && $vw_spp_pengembalian_penerimaan->CurrentAction == "") { ?>
<form name="fvw_spp_pengembalian_penerimaanlistsrch" id="fvw_spp_pengembalian_penerimaanlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($vw_spp_pengembalian_penerimaan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fvw_spp_pengembalian_penerimaanlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vw_spp_pengembalian_penerimaan">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $vw_spp_pengembalian_penerimaan_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($vw_spp_pengembalian_penerimaan_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($vw_spp_pengembalian_penerimaan_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($vw_spp_pengembalian_penerimaan_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($vw_spp_pengembalian_penerimaan_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $vw_spp_pengembalian_penerimaan_list->ShowPageHeader(); ?>
<?php
$vw_spp_pengembalian_penerimaan_list->ShowMessage();
?>
<?php if ($vw_spp_pengembalian_penerimaan_list->TotalRecs > 0 || $vw_spp_pengembalian_penerimaan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_spp_pengembalian_penerimaan">
<form name="fvw_spp_pengembalian_penerimaanlist" id="fvw_spp_pengembalian_penerimaanlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_pengembalian_penerimaan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_pengembalian_penerimaan">
<div id="gmp_vw_spp_pengembalian_penerimaan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_spp_pengembalian_penerimaan_list->TotalRecs > 0 || $vw_spp_pengembalian_penerimaan->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_spp_pengembalian_penerimaanlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_spp_pengembalian_penerimaan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_spp_pengembalian_penerimaan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_spp_pengembalian_penerimaan_list->RenderListOptions();

// Render list options (header, left)
$vw_spp_pengembalian_penerimaan_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_spp_pengembalian_penerimaan->id->Visible) { // id ?>
	<?php if ($vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->id) == "") { ?>
		<th data-name="id"><div id="elh_vw_spp_pengembalian_penerimaan_id" class="vw_spp_pengembalian_penerimaan_id"><div class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->id) ?>',2);"><div id="elh_vw_spp_pengembalian_penerimaan_id" class="vw_spp_pengembalian_penerimaan_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_pengembalian_penerimaan->id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_pengembalian_penerimaan->id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_pengembalian_penerimaan->status_spp->Visible) { // status_spp ?>
	<?php if ($vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->status_spp) == "") { ?>
		<th data-name="status_spp"><div id="elh_vw_spp_pengembalian_penerimaan_status_spp" class="vw_spp_pengembalian_penerimaan_status_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->status_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->status_spp) ?>',2);"><div id="elh_vw_spp_pengembalian_penerimaan_status_spp" class="vw_spp_pengembalian_penerimaan_status_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->status_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_pengembalian_penerimaan->status_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_pengembalian_penerimaan->status_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_pengembalian_penerimaan->no_spp->Visible) { // no_spp ?>
	<?php if ($vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->no_spp) == "") { ?>
		<th data-name="no_spp"><div id="elh_vw_spp_pengembalian_penerimaan_no_spp" class="vw_spp_pengembalian_penerimaan_no_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->no_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->no_spp) ?>',2);"><div id="elh_vw_spp_pengembalian_penerimaan_no_spp" class="vw_spp_pengembalian_penerimaan_no_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->no_spp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_pengembalian_penerimaan->no_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_pengembalian_penerimaan->no_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_pengembalian_penerimaan->tgl_spp->Visible) { // tgl_spp ?>
	<?php if ($vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->tgl_spp) == "") { ?>
		<th data-name="tgl_spp"><div id="elh_vw_spp_pengembalian_penerimaan_tgl_spp" class="vw_spp_pengembalian_penerimaan_tgl_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_pengembalian_penerimaan->SortUrl($vw_spp_pengembalian_penerimaan->tgl_spp) ?>',2);"><div id="elh_vw_spp_pengembalian_penerimaan_tgl_spp" class="vw_spp_pengembalian_penerimaan_tgl_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_pengembalian_penerimaan->tgl_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_pengembalian_penerimaan->tgl_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_spp_pengembalian_penerimaan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_spp_pengembalian_penerimaan->ExportAll && $vw_spp_pengembalian_penerimaan->Export <> "") {
	$vw_spp_pengembalian_penerimaan_list->StopRec = $vw_spp_pengembalian_penerimaan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_spp_pengembalian_penerimaan_list->TotalRecs > $vw_spp_pengembalian_penerimaan_list->StartRec + $vw_spp_pengembalian_penerimaan_list->DisplayRecs - 1)
		$vw_spp_pengembalian_penerimaan_list->StopRec = $vw_spp_pengembalian_penerimaan_list->StartRec + $vw_spp_pengembalian_penerimaan_list->DisplayRecs - 1;
	else
		$vw_spp_pengembalian_penerimaan_list->StopRec = $vw_spp_pengembalian_penerimaan_list->TotalRecs;
}
$vw_spp_pengembalian_penerimaan_list->RecCnt = $vw_spp_pengembalian_penerimaan_list->StartRec - 1;
if ($vw_spp_pengembalian_penerimaan_list->Recordset && !$vw_spp_pengembalian_penerimaan_list->Recordset->EOF) {
	$vw_spp_pengembalian_penerimaan_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_spp_pengembalian_penerimaan_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_spp_pengembalian_penerimaan_list->StartRec > 1)
		$vw_spp_pengembalian_penerimaan_list->Recordset->Move($vw_spp_pengembalian_penerimaan_list->StartRec - 1);
} elseif (!$vw_spp_pengembalian_penerimaan->AllowAddDeleteRow && $vw_spp_pengembalian_penerimaan_list->StopRec == 0) {
	$vw_spp_pengembalian_penerimaan_list->StopRec = $vw_spp_pengembalian_penerimaan->GridAddRowCount;
}

// Initialize aggregate
$vw_spp_pengembalian_penerimaan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_spp_pengembalian_penerimaan->ResetAttrs();
$vw_spp_pengembalian_penerimaan_list->RenderRow();
while ($vw_spp_pengembalian_penerimaan_list->RecCnt < $vw_spp_pengembalian_penerimaan_list->StopRec) {
	$vw_spp_pengembalian_penerimaan_list->RecCnt++;
	if (intval($vw_spp_pengembalian_penerimaan_list->RecCnt) >= intval($vw_spp_pengembalian_penerimaan_list->StartRec)) {
		$vw_spp_pengembalian_penerimaan_list->RowCnt++;

		// Set up key count
		$vw_spp_pengembalian_penerimaan_list->KeyCount = $vw_spp_pengembalian_penerimaan_list->RowIndex;

		// Init row class and style
		$vw_spp_pengembalian_penerimaan->ResetAttrs();
		$vw_spp_pengembalian_penerimaan->CssClass = "";
		if ($vw_spp_pengembalian_penerimaan->CurrentAction == "gridadd") {
		} else {
			$vw_spp_pengembalian_penerimaan_list->LoadRowValues($vw_spp_pengembalian_penerimaan_list->Recordset); // Load row values
		}
		$vw_spp_pengembalian_penerimaan->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vw_spp_pengembalian_penerimaan->RowAttrs = array_merge($vw_spp_pengembalian_penerimaan->RowAttrs, array('data-rowindex'=>$vw_spp_pengembalian_penerimaan_list->RowCnt, 'id'=>'r' . $vw_spp_pengembalian_penerimaan_list->RowCnt . '_vw_spp_pengembalian_penerimaan', 'data-rowtype'=>$vw_spp_pengembalian_penerimaan->RowType));

		// Render row
		$vw_spp_pengembalian_penerimaan_list->RenderRow();

		// Render list options
		$vw_spp_pengembalian_penerimaan_list->RenderListOptions();
?>
	<tr<?php echo $vw_spp_pengembalian_penerimaan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_pengembalian_penerimaan_list->ListOptions->Render("body", "left", $vw_spp_pengembalian_penerimaan_list->RowCnt);
?>
	<?php if ($vw_spp_pengembalian_penerimaan->id->Visible) { // id ?>
		<td data-name="id"<?php echo $vw_spp_pengembalian_penerimaan->id->CellAttributes() ?>>
<div id="orig<?php echo $vw_spp_pengembalian_penerimaan_list->RowCnt ?>_vw_spp_pengembalian_penerimaan_id" class="hide">
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_list->RowCnt ?>_vw_spp_pengembalian_penerimaan_id" class="vw_spp_pengembalian_penerimaan_id">
<span<?php echo $vw_spp_pengembalian_penerimaan->id->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->id->ListViewValue() ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r == 7)
{ ?>
	<a class="btn btn-success btn-xs"  target="_blank" href="cetak_spp_pp.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK SPP
	 <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a>
<?php
}else {
 }
?>
<a id="<?php echo $vw_spp_pengembalian_penerimaan_list->PageObjName . "_row_" . $vw_spp_pengembalian_penerimaan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vw_spp_pengembalian_penerimaan->status_spp->Visible) { // status_spp ?>
		<td data-name="status_spp"<?php echo $vw_spp_pengembalian_penerimaan->status_spp->CellAttributes() ?>>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_list->RowCnt ?>_vw_spp_pengembalian_penerimaan_status_spp" class="vw_spp_pengembalian_penerimaan_status_spp">
<span<?php echo $vw_spp_pengembalian_penerimaan->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->status_spp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_spp_pengembalian_penerimaan->no_spp->Visible) { // no_spp ?>
		<td data-name="no_spp"<?php echo $vw_spp_pengembalian_penerimaan->no_spp->CellAttributes() ?>>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_list->RowCnt ?>_vw_spp_pengembalian_penerimaan_no_spp" class="vw_spp_pengembalian_penerimaan_no_spp">
<span<?php echo $vw_spp_pengembalian_penerimaan->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->no_spp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_spp_pengembalian_penerimaan->tgl_spp->Visible) { // tgl_spp ?>
		<td data-name="tgl_spp"<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->CellAttributes() ?>>
<span id="el<?php echo $vw_spp_pengembalian_penerimaan_list->RowCnt ?>_vw_spp_pengembalian_penerimaan_tgl_spp" class="vw_spp_pengembalian_penerimaan_tgl_spp">
<span<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_pengembalian_penerimaan_list->ListOptions->Render("body", "right", $vw_spp_pengembalian_penerimaan_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($vw_spp_pengembalian_penerimaan->CurrentAction <> "gridadd")
		$vw_spp_pengembalian_penerimaan_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_spp_pengembalian_penerimaan_list->Recordset)
	$vw_spp_pengembalian_penerimaan_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_spp_pengembalian_penerimaan->CurrentAction <> "gridadd" && $vw_spp_pengembalian_penerimaan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_spp_pengembalian_penerimaan_list->Pager)) $vw_spp_pengembalian_penerimaan_list->Pager = new cPrevNextPager($vw_spp_pengembalian_penerimaan_list->StartRec, $vw_spp_pengembalian_penerimaan_list->DisplayRecs, $vw_spp_pengembalian_penerimaan_list->TotalRecs) ?>
<?php if ($vw_spp_pengembalian_penerimaan_list->Pager->RecordCount > 0 && $vw_spp_pengembalian_penerimaan_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_spp_pengembalian_penerimaan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_spp_pengembalian_penerimaan_list->PageUrl() ?>start=<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_spp_pengembalian_penerimaan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_spp_pengembalian_penerimaan_list->PageUrl() ?>start=<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_spp_pengembalian_penerimaan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_spp_pengembalian_penerimaan_list->PageUrl() ?>start=<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_spp_pengembalian_penerimaan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_spp_pengembalian_penerimaan_list->PageUrl() ?>start=<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_spp_pengembalian_penerimaan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_spp_pengembalian_penerimaan_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_spp_pengembalian_penerimaan">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_spp_pengembalian_penerimaan_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_spp_pengembalian_penerimaan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_spp_pengembalian_penerimaan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_spp_pengembalian_penerimaan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_spp_pengembalian_penerimaan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_spp_pengembalian_penerimaan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan_list->TotalRecs == 0 && $vw_spp_pengembalian_penerimaan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_spp_pengembalian_penerimaan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_spp_pengembalian_penerimaanlistsrch.FilterList = <?php echo $vw_spp_pengembalian_penerimaan_list->GetFilterList() ?>;
fvw_spp_pengembalian_penerimaanlistsrch.Init();
fvw_spp_pengembalian_penerimaanlist.Init();
</script>
<?php
$vw_spp_pengembalian_penerimaan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_pengembalian_penerimaan_list->Page_Terminate();
?>
