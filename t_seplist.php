<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_sepinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_sep_list = NULL; // Initialize page object first

class ct_sep_list extends ct_sep {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sep';

	// Page object name
	var $PageObjName = 't_sep_list';

	// Grid form hidden field names
	var $FormName = 'ft_seplist';
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

		// Table object (t_sep)
		if (!isset($GLOBALS["t_sep"]) || get_class($GLOBALS["t_sep"]) == "ct_sep") {
			$GLOBALS["t_sep"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_sep"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "t_sepadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "t_sepdelete.php";
		$this->MultiUpdateUrl = "t_sepupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_sep', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ft_seplistsrch";

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
		$this->nomer_sep->SetVisibility();
		$this->nomr->SetVisibility();
		$this->no_kartubpjs->SetVisibility();
		$this->jenis_layanan->SetVisibility();
		$this->tgl_sep->SetVisibility();
		$this->poli_eksekutif->SetVisibility();
		$this->cob->SetVisibility();
		$this->penjamin_laka->SetVisibility();
		$this->no_telp->SetVisibility();
		$this->status_kepesertaan_bpjs->SetVisibility();
		$this->faskes_id->SetVisibility();
		$this->nama_layanan->SetVisibility();
		$this->nama_kelas->SetVisibility();
		$this->table_source->SetVisibility();

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
		global $EW_EXPORT, $t_sep;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_sep);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ft_seplistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->nomer_sep->AdvancedSearch->ToJSON(), ","); // Field nomer_sep
		$sFilterList = ew_Concat($sFilterList, $this->nomr->AdvancedSearch->ToJSON(), ","); // Field nomr
		$sFilterList = ew_Concat($sFilterList, $this->jenis_layanan->AdvancedSearch->ToJSON(), ","); // Field jenis_layanan
		$sFilterList = ew_Concat($sFilterList, $this->flag_proc->AdvancedSearch->ToJSON(), ","); // Field flag_proc
		$sFilterList = ew_Concat($sFilterList, $this->poli_eksekutif->AdvancedSearch->ToJSON(), ","); // Field poli_eksekutif
		$sFilterList = ew_Concat($sFilterList, $this->cob->AdvancedSearch->ToJSON(), ","); // Field cob
		$sFilterList = ew_Concat($sFilterList, $this->penjamin_laka->AdvancedSearch->ToJSON(), ","); // Field penjamin_laka
		$sFilterList = ew_Concat($sFilterList, $this->no_telp->AdvancedSearch->ToJSON(), ","); // Field no_telp
		$sFilterList = ew_Concat($sFilterList, $this->status_kepesertaan_bpjs->AdvancedSearch->ToJSON(), ","); // Field status_kepesertaan_bpjs
		$sFilterList = ew_Concat($sFilterList, $this->faskes_id->AdvancedSearch->ToJSON(), ","); // Field faskes_id
		$sFilterList = ew_Concat($sFilterList, $this->nama_layanan->AdvancedSearch->ToJSON(), ","); // Field nama_layanan
		$sFilterList = ew_Concat($sFilterList, $this->nama_kelas->AdvancedSearch->ToJSON(), ","); // Field nama_kelas
		$sFilterList = ew_Concat($sFilterList, $this->table_source->AdvancedSearch->ToJSON(), ","); // Field table_source
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ft_seplistsrch", $filters);

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

		// Field nomer_sep
		$this->nomer_sep->AdvancedSearch->SearchValue = @$filter["x_nomer_sep"];
		$this->nomer_sep->AdvancedSearch->SearchOperator = @$filter["z_nomer_sep"];
		$this->nomer_sep->AdvancedSearch->SearchCondition = @$filter["v_nomer_sep"];
		$this->nomer_sep->AdvancedSearch->SearchValue2 = @$filter["y_nomer_sep"];
		$this->nomer_sep->AdvancedSearch->SearchOperator2 = @$filter["w_nomer_sep"];
		$this->nomer_sep->AdvancedSearch->Save();

		// Field nomr
		$this->nomr->AdvancedSearch->SearchValue = @$filter["x_nomr"];
		$this->nomr->AdvancedSearch->SearchOperator = @$filter["z_nomr"];
		$this->nomr->AdvancedSearch->SearchCondition = @$filter["v_nomr"];
		$this->nomr->AdvancedSearch->SearchValue2 = @$filter["y_nomr"];
		$this->nomr->AdvancedSearch->SearchOperator2 = @$filter["w_nomr"];
		$this->nomr->AdvancedSearch->Save();

		// Field jenis_layanan
		$this->jenis_layanan->AdvancedSearch->SearchValue = @$filter["x_jenis_layanan"];
		$this->jenis_layanan->AdvancedSearch->SearchOperator = @$filter["z_jenis_layanan"];
		$this->jenis_layanan->AdvancedSearch->SearchCondition = @$filter["v_jenis_layanan"];
		$this->jenis_layanan->AdvancedSearch->SearchValue2 = @$filter["y_jenis_layanan"];
		$this->jenis_layanan->AdvancedSearch->SearchOperator2 = @$filter["w_jenis_layanan"];
		$this->jenis_layanan->AdvancedSearch->Save();

		// Field flag_proc
		$this->flag_proc->AdvancedSearch->SearchValue = @$filter["x_flag_proc"];
		$this->flag_proc->AdvancedSearch->SearchOperator = @$filter["z_flag_proc"];
		$this->flag_proc->AdvancedSearch->SearchCondition = @$filter["v_flag_proc"];
		$this->flag_proc->AdvancedSearch->SearchValue2 = @$filter["y_flag_proc"];
		$this->flag_proc->AdvancedSearch->SearchOperator2 = @$filter["w_flag_proc"];
		$this->flag_proc->AdvancedSearch->Save();

		// Field poli_eksekutif
		$this->poli_eksekutif->AdvancedSearch->SearchValue = @$filter["x_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchOperator = @$filter["z_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchCondition = @$filter["v_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchValue2 = @$filter["y_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->SearchOperator2 = @$filter["w_poli_eksekutif"];
		$this->poli_eksekutif->AdvancedSearch->Save();

		// Field cob
		$this->cob->AdvancedSearch->SearchValue = @$filter["x_cob"];
		$this->cob->AdvancedSearch->SearchOperator = @$filter["z_cob"];
		$this->cob->AdvancedSearch->SearchCondition = @$filter["v_cob"];
		$this->cob->AdvancedSearch->SearchValue2 = @$filter["y_cob"];
		$this->cob->AdvancedSearch->SearchOperator2 = @$filter["w_cob"];
		$this->cob->AdvancedSearch->Save();

		// Field penjamin_laka
		$this->penjamin_laka->AdvancedSearch->SearchValue = @$filter["x_penjamin_laka"];
		$this->penjamin_laka->AdvancedSearch->SearchOperator = @$filter["z_penjamin_laka"];
		$this->penjamin_laka->AdvancedSearch->SearchCondition = @$filter["v_penjamin_laka"];
		$this->penjamin_laka->AdvancedSearch->SearchValue2 = @$filter["y_penjamin_laka"];
		$this->penjamin_laka->AdvancedSearch->SearchOperator2 = @$filter["w_penjamin_laka"];
		$this->penjamin_laka->AdvancedSearch->Save();

		// Field no_telp
		$this->no_telp->AdvancedSearch->SearchValue = @$filter["x_no_telp"];
		$this->no_telp->AdvancedSearch->SearchOperator = @$filter["z_no_telp"];
		$this->no_telp->AdvancedSearch->SearchCondition = @$filter["v_no_telp"];
		$this->no_telp->AdvancedSearch->SearchValue2 = @$filter["y_no_telp"];
		$this->no_telp->AdvancedSearch->SearchOperator2 = @$filter["w_no_telp"];
		$this->no_telp->AdvancedSearch->Save();

		// Field status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchValue = @$filter["x_status_kepesertaan_bpjs"];
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchOperator = @$filter["z_status_kepesertaan_bpjs"];
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchCondition = @$filter["v_status_kepesertaan_bpjs"];
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchValue2 = @$filter["y_status_kepesertaan_bpjs"];
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchOperator2 = @$filter["w_status_kepesertaan_bpjs"];
		$this->status_kepesertaan_bpjs->AdvancedSearch->Save();

		// Field faskes_id
		$this->faskes_id->AdvancedSearch->SearchValue = @$filter["x_faskes_id"];
		$this->faskes_id->AdvancedSearch->SearchOperator = @$filter["z_faskes_id"];
		$this->faskes_id->AdvancedSearch->SearchCondition = @$filter["v_faskes_id"];
		$this->faskes_id->AdvancedSearch->SearchValue2 = @$filter["y_faskes_id"];
		$this->faskes_id->AdvancedSearch->SearchOperator2 = @$filter["w_faskes_id"];
		$this->faskes_id->AdvancedSearch->Save();

		// Field nama_layanan
		$this->nama_layanan->AdvancedSearch->SearchValue = @$filter["x_nama_layanan"];
		$this->nama_layanan->AdvancedSearch->SearchOperator = @$filter["z_nama_layanan"];
		$this->nama_layanan->AdvancedSearch->SearchCondition = @$filter["v_nama_layanan"];
		$this->nama_layanan->AdvancedSearch->SearchValue2 = @$filter["y_nama_layanan"];
		$this->nama_layanan->AdvancedSearch->SearchOperator2 = @$filter["w_nama_layanan"];
		$this->nama_layanan->AdvancedSearch->Save();

		// Field nama_kelas
		$this->nama_kelas->AdvancedSearch->SearchValue = @$filter["x_nama_kelas"];
		$this->nama_kelas->AdvancedSearch->SearchOperator = @$filter["z_nama_kelas"];
		$this->nama_kelas->AdvancedSearch->SearchCondition = @$filter["v_nama_kelas"];
		$this->nama_kelas->AdvancedSearch->SearchValue2 = @$filter["y_nama_kelas"];
		$this->nama_kelas->AdvancedSearch->SearchOperator2 = @$filter["w_nama_kelas"];
		$this->nama_kelas->AdvancedSearch->Save();

		// Field table_source
		$this->table_source->AdvancedSearch->SearchValue = @$filter["x_table_source"];
		$this->table_source->AdvancedSearch->SearchOperator = @$filter["z_table_source"];
		$this->table_source->AdvancedSearch->SearchCondition = @$filter["v_table_source"];
		$this->table_source->AdvancedSearch->SearchValue2 = @$filter["y_table_source"];
		$this->table_source->AdvancedSearch->SearchOperator2 = @$filter["w_table_source"];
		$this->table_source->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->nomer_sep, $Default, FALSE); // nomer_sep
		$this->BuildSearchSql($sWhere, $this->nomr, $Default, FALSE); // nomr
		$this->BuildSearchSql($sWhere, $this->jenis_layanan, $Default, FALSE); // jenis_layanan
		$this->BuildSearchSql($sWhere, $this->flag_proc, $Default, FALSE); // flag_proc
		$this->BuildSearchSql($sWhere, $this->poli_eksekutif, $Default, FALSE); // poli_eksekutif
		$this->BuildSearchSql($sWhere, $this->cob, $Default, FALSE); // cob
		$this->BuildSearchSql($sWhere, $this->penjamin_laka, $Default, FALSE); // penjamin_laka
		$this->BuildSearchSql($sWhere, $this->no_telp, $Default, FALSE); // no_telp
		$this->BuildSearchSql($sWhere, $this->status_kepesertaan_bpjs, $Default, FALSE); // status_kepesertaan_bpjs
		$this->BuildSearchSql($sWhere, $this->faskes_id, $Default, FALSE); // faskes_id
		$this->BuildSearchSql($sWhere, $this->nama_layanan, $Default, FALSE); // nama_layanan
		$this->BuildSearchSql($sWhere, $this->nama_kelas, $Default, FALSE); // nama_kelas
		$this->BuildSearchSql($sWhere, $this->table_source, $Default, FALSE); // table_source

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->nomer_sep->AdvancedSearch->Save(); // nomer_sep
			$this->nomr->AdvancedSearch->Save(); // nomr
			$this->jenis_layanan->AdvancedSearch->Save(); // jenis_layanan
			$this->flag_proc->AdvancedSearch->Save(); // flag_proc
			$this->poli_eksekutif->AdvancedSearch->Save(); // poli_eksekutif
			$this->cob->AdvancedSearch->Save(); // cob
			$this->penjamin_laka->AdvancedSearch->Save(); // penjamin_laka
			$this->no_telp->AdvancedSearch->Save(); // no_telp
			$this->status_kepesertaan_bpjs->AdvancedSearch->Save(); // status_kepesertaan_bpjs
			$this->faskes_id->AdvancedSearch->Save(); // faskes_id
			$this->nama_layanan->AdvancedSearch->Save(); // nama_layanan
			$this->nama_kelas->AdvancedSearch->Save(); // nama_kelas
			$this->table_source->AdvancedSearch->Save(); // table_source
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
		$this->BuildBasicSearchSQL($sWhere, $this->nomer_sep, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nomr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_kartubpjs, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_rujukan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ppk_asal, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_ppk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ppk_pelayanan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->catatan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_diagnosaawal, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_diagnosaawal, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->lokasi_laka, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->user, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nik, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->kode_politujuan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_politujuan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->idx, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->petugas_klaim, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->no_telp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->status_kepesertaan_bpjs, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_layanan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_kelas, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->table_source, $arKeywords, $type);
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
		if ($this->nomer_sep->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->nomr->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->jenis_layanan->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->flag_proc->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->poli_eksekutif->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->cob->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->penjamin_laka->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->no_telp->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->status_kepesertaan_bpjs->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->faskes_id->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->nama_layanan->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->nama_kelas->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->table_source->AdvancedSearch->IssetSession())
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
		$this->nomer_sep->AdvancedSearch->UnsetSession();
		$this->nomr->AdvancedSearch->UnsetSession();
		$this->jenis_layanan->AdvancedSearch->UnsetSession();
		$this->flag_proc->AdvancedSearch->UnsetSession();
		$this->poli_eksekutif->AdvancedSearch->UnsetSession();
		$this->cob->AdvancedSearch->UnsetSession();
		$this->penjamin_laka->AdvancedSearch->UnsetSession();
		$this->no_telp->AdvancedSearch->UnsetSession();
		$this->status_kepesertaan_bpjs->AdvancedSearch->UnsetSession();
		$this->faskes_id->AdvancedSearch->UnsetSession();
		$this->nama_layanan->AdvancedSearch->UnsetSession();
		$this->nama_kelas->AdvancedSearch->UnsetSession();
		$this->table_source->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->nomer_sep->AdvancedSearch->Load();
		$this->nomr->AdvancedSearch->Load();
		$this->jenis_layanan->AdvancedSearch->Load();
		$this->flag_proc->AdvancedSearch->Load();
		$this->poli_eksekutif->AdvancedSearch->Load();
		$this->cob->AdvancedSearch->Load();
		$this->penjamin_laka->AdvancedSearch->Load();
		$this->no_telp->AdvancedSearch->Load();
		$this->status_kepesertaan_bpjs->AdvancedSearch->Load();
		$this->faskes_id->AdvancedSearch->Load();
		$this->nama_layanan->AdvancedSearch->Load();
		$this->nama_kelas->AdvancedSearch->Load();
		$this->table_source->AdvancedSearch->Load();
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
			$this->UpdateSort($this->nomer_sep, $bCtrl); // nomer_sep
			$this->UpdateSort($this->nomr, $bCtrl); // nomr
			$this->UpdateSort($this->no_kartubpjs, $bCtrl); // no_kartubpjs
			$this->UpdateSort($this->jenis_layanan, $bCtrl); // jenis_layanan
			$this->UpdateSort($this->tgl_sep, $bCtrl); // tgl_sep
			$this->UpdateSort($this->poli_eksekutif, $bCtrl); // poli_eksekutif
			$this->UpdateSort($this->cob, $bCtrl); // cob
			$this->UpdateSort($this->penjamin_laka, $bCtrl); // penjamin_laka
			$this->UpdateSort($this->no_telp, $bCtrl); // no_telp
			$this->UpdateSort($this->status_kepesertaan_bpjs, $bCtrl); // status_kepesertaan_bpjs
			$this->UpdateSort($this->faskes_id, $bCtrl); // faskes_id
			$this->UpdateSort($this->nama_layanan, $bCtrl); // nama_layanan
			$this->UpdateSort($this->nama_kelas, $bCtrl); // nama_kelas
			$this->UpdateSort($this->table_source, $bCtrl); // table_source
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
				$this->nomer_sep->setSort("");
				$this->nomr->setSort("");
				$this->no_kartubpjs->setSort("");
				$this->jenis_layanan->setSort("");
				$this->tgl_sep->setSort("");
				$this->poli_eksekutif->setSort("");
				$this->cob->setSort("");
				$this->penjamin_laka->setSort("");
				$this->no_telp->setSort("");
				$this->status_kepesertaan_bpjs->setSort("");
				$this->faskes_id->setSort("");
				$this->nama_layanan->setSort("");
				$this->nama_kelas->setSort("");
				$this->table_source->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ft_seplistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ft_seplistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ft_seplist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ft_seplistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"t_sepsrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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
		// nomer_sep

		$this->nomer_sep->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_nomer_sep"]);
		if ($this->nomer_sep->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->nomer_sep->AdvancedSearch->SearchOperator = @$_GET["z_nomer_sep"];

		// nomr
		$this->nomr->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_nomr"]);
		if ($this->nomr->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->nomr->AdvancedSearch->SearchOperator = @$_GET["z_nomr"];

		// jenis_layanan
		$this->jenis_layanan->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_jenis_layanan"]);
		if ($this->jenis_layanan->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->jenis_layanan->AdvancedSearch->SearchOperator = @$_GET["z_jenis_layanan"];

		// flag_proc
		$this->flag_proc->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_flag_proc"]);
		if ($this->flag_proc->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->flag_proc->AdvancedSearch->SearchOperator = @$_GET["z_flag_proc"];

		// poli_eksekutif
		$this->poli_eksekutif->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_poli_eksekutif"]);
		if ($this->poli_eksekutif->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->poli_eksekutif->AdvancedSearch->SearchOperator = @$_GET["z_poli_eksekutif"];

		// cob
		$this->cob->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_cob"]);
		if ($this->cob->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->cob->AdvancedSearch->SearchOperator = @$_GET["z_cob"];

		// penjamin_laka
		$this->penjamin_laka->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_penjamin_laka"]);
		if ($this->penjamin_laka->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->penjamin_laka->AdvancedSearch->SearchOperator = @$_GET["z_penjamin_laka"];

		// no_telp
		$this->no_telp->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_no_telp"]);
		if ($this->no_telp->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->no_telp->AdvancedSearch->SearchOperator = @$_GET["z_no_telp"];

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_status_kepesertaan_bpjs"]);
		if ($this->status_kepesertaan_bpjs->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchOperator = @$_GET["z_status_kepesertaan_bpjs"];

		// faskes_id
		$this->faskes_id->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_faskes_id"]);
		if ($this->faskes_id->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->faskes_id->AdvancedSearch->SearchOperator = @$_GET["z_faskes_id"];

		// nama_layanan
		$this->nama_layanan->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_nama_layanan"]);
		if ($this->nama_layanan->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->nama_layanan->AdvancedSearch->SearchOperator = @$_GET["z_nama_layanan"];

		// nama_kelas
		$this->nama_kelas->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_nama_kelas"]);
		if ($this->nama_kelas->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->nama_kelas->AdvancedSearch->SearchOperator = @$_GET["z_nama_kelas"];

		// table_source
		$this->table_source->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_table_source"]);
		if ($this->table_source->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->table_source->AdvancedSearch->SearchOperator = @$_GET["z_table_source"];
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
		$this->nomer_sep->setDbValue($rs->fields('nomer_sep'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->no_kartubpjs->setDbValue($rs->fields('no_kartubpjs'));
		$this->jenis_layanan->setDbValue($rs->fields('jenis_layanan'));
		$this->tgl_sep->setDbValue($rs->fields('tgl_sep'));
		$this->tgl_rujukan->setDbValue($rs->fields('tgl_rujukan'));
		$this->kelas_rawat->setDbValue($rs->fields('kelas_rawat'));
		$this->no_rujukan->setDbValue($rs->fields('no_rujukan'));
		$this->ppk_asal->setDbValue($rs->fields('ppk_asal'));
		$this->nama_ppk->setDbValue($rs->fields('nama_ppk'));
		$this->ppk_pelayanan->setDbValue($rs->fields('ppk_pelayanan'));
		$this->catatan->setDbValue($rs->fields('catatan'));
		$this->kode_diagnosaawal->setDbValue($rs->fields('kode_diagnosaawal'));
		$this->nama_diagnosaawal->setDbValue($rs->fields('nama_diagnosaawal'));
		$this->laka_lantas->setDbValue($rs->fields('laka_lantas'));
		$this->lokasi_laka->setDbValue($rs->fields('lokasi_laka'));
		$this->user->setDbValue($rs->fields('user'));
		$this->nik->setDbValue($rs->fields('nik'));
		$this->kode_politujuan->setDbValue($rs->fields('kode_politujuan'));
		$this->nama_politujuan->setDbValue($rs->fields('nama_politujuan'));
		$this->dpjp->setDbValue($rs->fields('dpjp'));
		$this->idx->setDbValue($rs->fields('idx'));
		$this->last_update->setDbValue($rs->fields('last_update'));
		$this->pasien_baru->setDbValue($rs->fields('pasien_baru'));
		$this->cara_bayar->setDbValue($rs->fields('cara_bayar'));
		$this->petugas_klaim->setDbValue($rs->fields('petugas_klaim'));
		$this->total_biaya_rs->setDbValue($rs->fields('total_biaya_rs'));
		$this->total_biaya_rs_adjust->setDbValue($rs->fields('total_biaya_rs_adjust'));
		$this->tgl_pulang->setDbValue($rs->fields('tgl_pulang'));
		$this->flag_proc->setDbValue($rs->fields('flag_proc'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->cob->setDbValue($rs->fields('cob'));
		$this->penjamin_laka->setDbValue($rs->fields('penjamin_laka'));
		$this->no_telp->setDbValue($rs->fields('no_telp'));
		$this->status_kepesertaan_bpjs->setDbValue($rs->fields('status_kepesertaan_bpjs'));
		$this->faskes_id->setDbValue($rs->fields('faskes_id'));
		$this->nama_layanan->setDbValue($rs->fields('nama_layanan'));
		$this->nama_kelas->setDbValue($rs->fields('nama_kelas'));
		$this->table_source->setDbValue($rs->fields('table_source'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nomer_sep->DbValue = $row['nomer_sep'];
		$this->nomr->DbValue = $row['nomr'];
		$this->no_kartubpjs->DbValue = $row['no_kartubpjs'];
		$this->jenis_layanan->DbValue = $row['jenis_layanan'];
		$this->tgl_sep->DbValue = $row['tgl_sep'];
		$this->tgl_rujukan->DbValue = $row['tgl_rujukan'];
		$this->kelas_rawat->DbValue = $row['kelas_rawat'];
		$this->no_rujukan->DbValue = $row['no_rujukan'];
		$this->ppk_asal->DbValue = $row['ppk_asal'];
		$this->nama_ppk->DbValue = $row['nama_ppk'];
		$this->ppk_pelayanan->DbValue = $row['ppk_pelayanan'];
		$this->catatan->DbValue = $row['catatan'];
		$this->kode_diagnosaawal->DbValue = $row['kode_diagnosaawal'];
		$this->nama_diagnosaawal->DbValue = $row['nama_diagnosaawal'];
		$this->laka_lantas->DbValue = $row['laka_lantas'];
		$this->lokasi_laka->DbValue = $row['lokasi_laka'];
		$this->user->DbValue = $row['user'];
		$this->nik->DbValue = $row['nik'];
		$this->kode_politujuan->DbValue = $row['kode_politujuan'];
		$this->nama_politujuan->DbValue = $row['nama_politujuan'];
		$this->dpjp->DbValue = $row['dpjp'];
		$this->idx->DbValue = $row['idx'];
		$this->last_update->DbValue = $row['last_update'];
		$this->pasien_baru->DbValue = $row['pasien_baru'];
		$this->cara_bayar->DbValue = $row['cara_bayar'];
		$this->petugas_klaim->DbValue = $row['petugas_klaim'];
		$this->total_biaya_rs->DbValue = $row['total_biaya_rs'];
		$this->total_biaya_rs_adjust->DbValue = $row['total_biaya_rs_adjust'];
		$this->tgl_pulang->DbValue = $row['tgl_pulang'];
		$this->flag_proc->DbValue = $row['flag_proc'];
		$this->poli_eksekutif->DbValue = $row['poli_eksekutif'];
		$this->cob->DbValue = $row['cob'];
		$this->penjamin_laka->DbValue = $row['penjamin_laka'];
		$this->no_telp->DbValue = $row['no_telp'];
		$this->status_kepesertaan_bpjs->DbValue = $row['status_kepesertaan_bpjs'];
		$this->faskes_id->DbValue = $row['faskes_id'];
		$this->nama_layanan->DbValue = $row['nama_layanan'];
		$this->nama_kelas->DbValue = $row['nama_kelas'];
		$this->table_source->DbValue = $row['table_source'];
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
		// nomer_sep
		// nomr
		// no_kartubpjs
		// jenis_layanan
		// tgl_sep
		// tgl_rujukan
		// kelas_rawat
		// no_rujukan
		// ppk_asal
		// nama_ppk
		// ppk_pelayanan
		// catatan
		// kode_diagnosaawal
		// nama_diagnosaawal
		// laka_lantas
		// lokasi_laka
		// user
		// nik
		// kode_politujuan
		// nama_politujuan
		// dpjp
		// idx
		// last_update
		// pasien_baru
		// cara_bayar
		// petugas_klaim
		// total_biaya_rs
		// total_biaya_rs_adjust
		// tgl_pulang
		// flag_proc
		// poli_eksekutif
		// cob
		// penjamin_laka
		// no_telp
		// status_kepesertaan_bpjs
		// faskes_id
		// nama_layanan
		// nama_kelas
		// table_source

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nomer_sep
		$this->nomer_sep->ViewValue = $this->nomer_sep->CurrentValue;
		$this->nomer_sep->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// no_kartubpjs
		$this->no_kartubpjs->ViewValue = $this->no_kartubpjs->CurrentValue;
		$this->no_kartubpjs->ViewCustomAttributes = "";

		// jenis_layanan
		if (strval($this->jenis_layanan->CurrentValue) <> "") {
			$this->jenis_layanan->ViewValue = $this->jenis_layanan->OptionCaption($this->jenis_layanan->CurrentValue);
		} else {
			$this->jenis_layanan->ViewValue = NULL;
		}
		$this->jenis_layanan->ViewCustomAttributes = "";

		// tgl_sep
		$this->tgl_sep->ViewValue = $this->tgl_sep->CurrentValue;
		$this->tgl_sep->ViewValue = ew_FormatDateTime($this->tgl_sep->ViewValue, 0);
		$this->tgl_sep->ViewCustomAttributes = "";

		// tgl_rujukan
		$this->tgl_rujukan->ViewValue = $this->tgl_rujukan->CurrentValue;
		$this->tgl_rujukan->ViewValue = ew_FormatDateTime($this->tgl_rujukan->ViewValue, 0);
		$this->tgl_rujukan->ViewCustomAttributes = "";

		// kelas_rawat
		$this->kelas_rawat->ViewValue = $this->kelas_rawat->CurrentValue;
		$this->kelas_rawat->ViewCustomAttributes = "";

		// no_rujukan
		$this->no_rujukan->ViewValue = $this->no_rujukan->CurrentValue;
		$this->no_rujukan->ViewCustomAttributes = "";

		// ppk_asal
		$this->ppk_asal->ViewValue = $this->ppk_asal->CurrentValue;
		$this->ppk_asal->ViewCustomAttributes = "";

		// nama_ppk
		$this->nama_ppk->ViewValue = $this->nama_ppk->CurrentValue;
		$this->nama_ppk->ViewCustomAttributes = "";

		// ppk_pelayanan
		$this->ppk_pelayanan->ViewValue = $this->ppk_pelayanan->CurrentValue;
		$this->ppk_pelayanan->ViewCustomAttributes = "";

		// catatan
		$this->catatan->ViewValue = $this->catatan->CurrentValue;
		$this->catatan->ViewCustomAttributes = "";

		// kode_diagnosaawal
		$this->kode_diagnosaawal->ViewValue = $this->kode_diagnosaawal->CurrentValue;
		$this->kode_diagnosaawal->ViewCustomAttributes = "";

		// nama_diagnosaawal
		$this->nama_diagnosaawal->ViewValue = $this->nama_diagnosaawal->CurrentValue;
		$this->nama_diagnosaawal->ViewCustomAttributes = "";

		// laka_lantas
		$this->laka_lantas->ViewValue = $this->laka_lantas->CurrentValue;
		$this->laka_lantas->ViewCustomAttributes = "";

		// lokasi_laka
		$this->lokasi_laka->ViewValue = $this->lokasi_laka->CurrentValue;
		$this->lokasi_laka->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// nik
		$this->nik->ViewValue = $this->nik->CurrentValue;
		$this->nik->ViewCustomAttributes = "";

		// kode_politujuan
		$this->kode_politujuan->ViewValue = $this->kode_politujuan->CurrentValue;
		$this->kode_politujuan->ViewCustomAttributes = "";

		// nama_politujuan
		$this->nama_politujuan->ViewValue = $this->nama_politujuan->CurrentValue;
		$this->nama_politujuan->ViewCustomAttributes = "";

		// dpjp
		$this->dpjp->ViewValue = $this->dpjp->CurrentValue;
		$this->dpjp->ViewCustomAttributes = "";

		// idx
		$this->idx->ViewValue = $this->idx->CurrentValue;
		$this->idx->ViewCustomAttributes = "";

		// last_update
		$this->last_update->ViewValue = $this->last_update->CurrentValue;
		$this->last_update->ViewValue = ew_FormatDateTime($this->last_update->ViewValue, 0);
		$this->last_update->ViewCustomAttributes = "";

		// pasien_baru
		$this->pasien_baru->ViewValue = $this->pasien_baru->CurrentValue;
		$this->pasien_baru->ViewCustomAttributes = "";

		// cara_bayar
		$this->cara_bayar->ViewValue = $this->cara_bayar->CurrentValue;
		$this->cara_bayar->ViewCustomAttributes = "";

		// petugas_klaim
		$this->petugas_klaim->ViewValue = $this->petugas_klaim->CurrentValue;
		$this->petugas_klaim->ViewCustomAttributes = "";

		// total_biaya_rs
		$this->total_biaya_rs->ViewValue = $this->total_biaya_rs->CurrentValue;
		$this->total_biaya_rs->ViewCustomAttributes = "";

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust->ViewValue = $this->total_biaya_rs_adjust->CurrentValue;
		$this->total_biaya_rs_adjust->ViewCustomAttributes = "";

		// tgl_pulang
		$this->tgl_pulang->ViewValue = $this->tgl_pulang->CurrentValue;
		$this->tgl_pulang->ViewValue = ew_FormatDateTime($this->tgl_pulang->ViewValue, 0);
		$this->tgl_pulang->ViewCustomAttributes = "";

		// flag_proc
		$this->flag_proc->ViewValue = $this->flag_proc->CurrentValue;
		$this->flag_proc->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// cob
		$this->cob->ViewValue = $this->cob->CurrentValue;
		$this->cob->ViewCustomAttributes = "";

		// penjamin_laka
		$this->penjamin_laka->ViewValue = $this->penjamin_laka->CurrentValue;
		$this->penjamin_laka->ViewCustomAttributes = "";

		// no_telp
		$this->no_telp->ViewValue = $this->no_telp->CurrentValue;
		$this->no_telp->ViewCustomAttributes = "";

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->ViewValue = $this->status_kepesertaan_bpjs->CurrentValue;
		$this->status_kepesertaan_bpjs->ViewCustomAttributes = "";

		// faskes_id
		$this->faskes_id->ViewValue = $this->faskes_id->CurrentValue;
		$this->faskes_id->ViewCustomAttributes = "";

		// nama_layanan
		$this->nama_layanan->ViewValue = $this->nama_layanan->CurrentValue;
		$this->nama_layanan->ViewCustomAttributes = "";

		// nama_kelas
		$this->nama_kelas->ViewValue = $this->nama_kelas->CurrentValue;
		$this->nama_kelas->ViewCustomAttributes = "";

		// table_source
		$this->table_source->ViewValue = $this->table_source->CurrentValue;
		$this->table_source->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nomer_sep
			$this->nomer_sep->LinkCustomAttributes = "";
			$this->nomer_sep->HrefValue = "";
			$this->nomer_sep->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// no_kartubpjs
			$this->no_kartubpjs->LinkCustomAttributes = "";
			$this->no_kartubpjs->HrefValue = "";
			$this->no_kartubpjs->TooltipValue = "";

			// jenis_layanan
			$this->jenis_layanan->LinkCustomAttributes = "";
			$this->jenis_layanan->HrefValue = "";
			$this->jenis_layanan->TooltipValue = "";

			// tgl_sep
			$this->tgl_sep->LinkCustomAttributes = "";
			$this->tgl_sep->HrefValue = "";
			$this->tgl_sep->TooltipValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";
			$this->poli_eksekutif->TooltipValue = "";

			// cob
			$this->cob->LinkCustomAttributes = "";
			$this->cob->HrefValue = "";
			$this->cob->TooltipValue = "";

			// penjamin_laka
			$this->penjamin_laka->LinkCustomAttributes = "";
			$this->penjamin_laka->HrefValue = "";
			$this->penjamin_laka->TooltipValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";
			$this->no_telp->TooltipValue = "";

			// status_kepesertaan_bpjs
			$this->status_kepesertaan_bpjs->LinkCustomAttributes = "";
			$this->status_kepesertaan_bpjs->HrefValue = "";
			$this->status_kepesertaan_bpjs->TooltipValue = "";

			// faskes_id
			$this->faskes_id->LinkCustomAttributes = "";
			$this->faskes_id->HrefValue = "";
			$this->faskes_id->TooltipValue = "";

			// nama_layanan
			$this->nama_layanan->LinkCustomAttributes = "";
			$this->nama_layanan->HrefValue = "";
			$this->nama_layanan->TooltipValue = "";

			// nama_kelas
			$this->nama_kelas->LinkCustomAttributes = "";
			$this->nama_kelas->HrefValue = "";
			$this->nama_kelas->TooltipValue = "";

			// table_source
			$this->table_source->LinkCustomAttributes = "";
			$this->table_source->HrefValue = "";
			$this->table_source->TooltipValue = "";
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
		$this->nomer_sep->AdvancedSearch->Load();
		$this->nomr->AdvancedSearch->Load();
		$this->jenis_layanan->AdvancedSearch->Load();
		$this->flag_proc->AdvancedSearch->Load();
		$this->poli_eksekutif->AdvancedSearch->Load();
		$this->cob->AdvancedSearch->Load();
		$this->penjamin_laka->AdvancedSearch->Load();
		$this->no_telp->AdvancedSearch->Load();
		$this->status_kepesertaan_bpjs->AdvancedSearch->Load();
		$this->faskes_id->AdvancedSearch->Load();
		$this->nama_layanan->AdvancedSearch->Load();
		$this->nama_kelas->AdvancedSearch->Load();
		$this->table_source->AdvancedSearch->Load();
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
if (!isset($t_sep_list)) $t_sep_list = new ct_sep_list();

// Page init
$t_sep_list->Page_Init();

// Page main
$t_sep_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sep_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ft_seplist = new ew_Form("ft_seplist", "list");
ft_seplist.FormKeyCountName = '<?php echo $t_sep_list->FormKeyCountName ?>';

// Form_CustomValidate event
ft_seplist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_seplist.ValidateRequired = true;
<?php } else { ?>
ft_seplist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_seplist.Lists["x_jenis_layanan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_seplist.Lists["x_jenis_layanan"].Options = <?php echo json_encode($t_sep->jenis_layanan->Options()) ?>;

// Form object for search
var CurrentSearchForm = ft_seplistsrch = new ew_Form("ft_seplistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($t_sep_list->TotalRecs > 0 && $t_sep_list->ExportOptions->Visible()) { ?>
<?php $t_sep_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($t_sep_list->SearchOptions->Visible()) { ?>
<?php $t_sep_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($t_sep_list->FilterOptions->Visible()) { ?>
<?php $t_sep_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $t_sep_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($t_sep_list->TotalRecs <= 0)
			$t_sep_list->TotalRecs = $t_sep->SelectRecordCount();
	} else {
		if (!$t_sep_list->Recordset && ($t_sep_list->Recordset = $t_sep_list->LoadRecordset()))
			$t_sep_list->TotalRecs = $t_sep_list->Recordset->RecordCount();
	}
	$t_sep_list->StartRec = 1;
	if ($t_sep_list->DisplayRecs <= 0 || ($t_sep->Export <> "" && $t_sep->ExportAll)) // Display all records
		$t_sep_list->DisplayRecs = $t_sep_list->TotalRecs;
	if (!($t_sep->Export <> "" && $t_sep->ExportAll))
		$t_sep_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$t_sep_list->Recordset = $t_sep_list->LoadRecordset($t_sep_list->StartRec-1, $t_sep_list->DisplayRecs);

	// Set no record found message
	if ($t_sep->CurrentAction == "" && $t_sep_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$t_sep_list->setWarningMessage(ew_DeniedMsg());
		if ($t_sep_list->SearchWhere == "0=101")
			$t_sep_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$t_sep_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$t_sep_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($t_sep->Export == "" && $t_sep->CurrentAction == "") { ?>
<form name="ft_seplistsrch" id="ft_seplistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($t_sep_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ft_seplistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="t_sep">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($t_sep_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($t_sep_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $t_sep_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($t_sep_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($t_sep_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($t_sep_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($t_sep_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $t_sep_list->ShowPageHeader(); ?>
<?php
$t_sep_list->ShowMessage();
?>
<?php if ($t_sep_list->TotalRecs > 0 || $t_sep->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid t_sep">
<form name="ft_seplist" id="ft_seplist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_sep_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_sep_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_sep">
<div id="gmp_t_sep" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($t_sep_list->TotalRecs > 0 || $t_sep->CurrentAction == "gridedit") { ?>
<table id="tbl_t_seplist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_sep->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$t_sep_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$t_sep_list->RenderListOptions();

// Render list options (header, left)
$t_sep_list->ListOptions->Render("header", "left");
?>
<?php if ($t_sep->id->Visible) { // id ?>
	<?php if ($t_sep->SortUrl($t_sep->id) == "") { ?>
		<th data-name="id"><div id="elh_t_sep_id" class="t_sep_id"><div class="ewTableHeaderCaption"><?php echo $t_sep->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->id) ?>',2);"><div id="elh_t_sep_id" class="t_sep_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->nomer_sep->Visible) { // nomer_sep ?>
	<?php if ($t_sep->SortUrl($t_sep->nomer_sep) == "") { ?>
		<th data-name="nomer_sep"><div id="elh_t_sep_nomer_sep" class="t_sep_nomer_sep"><div class="ewTableHeaderCaption"><?php echo $t_sep->nomer_sep->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomer_sep"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->nomer_sep) ?>',2);"><div id="elh_t_sep_nomer_sep" class="t_sep_nomer_sep">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->nomer_sep->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->nomer_sep->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->nomer_sep->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->nomr->Visible) { // nomr ?>
	<?php if ($t_sep->SortUrl($t_sep->nomr) == "") { ?>
		<th data-name="nomr"><div id="elh_t_sep_nomr" class="t_sep_nomr"><div class="ewTableHeaderCaption"><?php echo $t_sep->nomr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomr"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->nomr) ?>',2);"><div id="elh_t_sep_nomr" class="t_sep_nomr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->nomr->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->nomr->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->nomr->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->no_kartubpjs->Visible) { // no_kartubpjs ?>
	<?php if ($t_sep->SortUrl($t_sep->no_kartubpjs) == "") { ?>
		<th data-name="no_kartubpjs"><div id="elh_t_sep_no_kartubpjs" class="t_sep_no_kartubpjs"><div class="ewTableHeaderCaption"><?php echo $t_sep->no_kartubpjs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_kartubpjs"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->no_kartubpjs) ?>',2);"><div id="elh_t_sep_no_kartubpjs" class="t_sep_no_kartubpjs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->no_kartubpjs->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->no_kartubpjs->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->no_kartubpjs->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->jenis_layanan->Visible) { // jenis_layanan ?>
	<?php if ($t_sep->SortUrl($t_sep->jenis_layanan) == "") { ?>
		<th data-name="jenis_layanan"><div id="elh_t_sep_jenis_layanan" class="t_sep_jenis_layanan"><div class="ewTableHeaderCaption"><?php echo $t_sep->jenis_layanan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis_layanan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->jenis_layanan) ?>',2);"><div id="elh_t_sep_jenis_layanan" class="t_sep_jenis_layanan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->jenis_layanan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->jenis_layanan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->jenis_layanan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->tgl_sep->Visible) { // tgl_sep ?>
	<?php if ($t_sep->SortUrl($t_sep->tgl_sep) == "") { ?>
		<th data-name="tgl_sep"><div id="elh_t_sep_tgl_sep" class="t_sep_tgl_sep"><div class="ewTableHeaderCaption"><?php echo $t_sep->tgl_sep->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_sep"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->tgl_sep) ?>',2);"><div id="elh_t_sep_tgl_sep" class="t_sep_tgl_sep">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->tgl_sep->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->tgl_sep->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->tgl_sep->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<?php if ($t_sep->SortUrl($t_sep->poli_eksekutif) == "") { ?>
		<th data-name="poli_eksekutif"><div id="elh_t_sep_poli_eksekutif" class="t_sep_poli_eksekutif"><div class="ewTableHeaderCaption"><?php echo $t_sep->poli_eksekutif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="poli_eksekutif"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->poli_eksekutif) ?>',2);"><div id="elh_t_sep_poli_eksekutif" class="t_sep_poli_eksekutif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->poli_eksekutif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->poli_eksekutif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->poli_eksekutif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->cob->Visible) { // cob ?>
	<?php if ($t_sep->SortUrl($t_sep->cob) == "") { ?>
		<th data-name="cob"><div id="elh_t_sep_cob" class="t_sep_cob"><div class="ewTableHeaderCaption"><?php echo $t_sep->cob->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cob"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->cob) ?>',2);"><div id="elh_t_sep_cob" class="t_sep_cob">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->cob->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->cob->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->cob->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->penjamin_laka->Visible) { // penjamin_laka ?>
	<?php if ($t_sep->SortUrl($t_sep->penjamin_laka) == "") { ?>
		<th data-name="penjamin_laka"><div id="elh_t_sep_penjamin_laka" class="t_sep_penjamin_laka"><div class="ewTableHeaderCaption"><?php echo $t_sep->penjamin_laka->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="penjamin_laka"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->penjamin_laka) ?>',2);"><div id="elh_t_sep_penjamin_laka" class="t_sep_penjamin_laka">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->penjamin_laka->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->penjamin_laka->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->penjamin_laka->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->no_telp->Visible) { // no_telp ?>
	<?php if ($t_sep->SortUrl($t_sep->no_telp) == "") { ?>
		<th data-name="no_telp"><div id="elh_t_sep_no_telp" class="t_sep_no_telp"><div class="ewTableHeaderCaption"><?php echo $t_sep->no_telp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_telp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->no_telp) ?>',2);"><div id="elh_t_sep_no_telp" class="t_sep_no_telp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->no_telp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->no_telp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->no_telp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->status_kepesertaan_bpjs->Visible) { // status_kepesertaan_bpjs ?>
	<?php if ($t_sep->SortUrl($t_sep->status_kepesertaan_bpjs) == "") { ?>
		<th data-name="status_kepesertaan_bpjs"><div id="elh_t_sep_status_kepesertaan_bpjs" class="t_sep_status_kepesertaan_bpjs"><div class="ewTableHeaderCaption"><?php echo $t_sep->status_kepesertaan_bpjs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status_kepesertaan_bpjs"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->status_kepesertaan_bpjs) ?>',2);"><div id="elh_t_sep_status_kepesertaan_bpjs" class="t_sep_status_kepesertaan_bpjs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->status_kepesertaan_bpjs->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->status_kepesertaan_bpjs->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->status_kepesertaan_bpjs->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->faskes_id->Visible) { // faskes_id ?>
	<?php if ($t_sep->SortUrl($t_sep->faskes_id) == "") { ?>
		<th data-name="faskes_id"><div id="elh_t_sep_faskes_id" class="t_sep_faskes_id"><div class="ewTableHeaderCaption"><?php echo $t_sep->faskes_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="faskes_id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->faskes_id) ?>',2);"><div id="elh_t_sep_faskes_id" class="t_sep_faskes_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->faskes_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->faskes_id->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->faskes_id->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->nama_layanan->Visible) { // nama_layanan ?>
	<?php if ($t_sep->SortUrl($t_sep->nama_layanan) == "") { ?>
		<th data-name="nama_layanan"><div id="elh_t_sep_nama_layanan" class="t_sep_nama_layanan"><div class="ewTableHeaderCaption"><?php echo $t_sep->nama_layanan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_layanan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->nama_layanan) ?>',2);"><div id="elh_t_sep_nama_layanan" class="t_sep_nama_layanan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->nama_layanan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->nama_layanan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->nama_layanan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->nama_kelas->Visible) { // nama_kelas ?>
	<?php if ($t_sep->SortUrl($t_sep->nama_kelas) == "") { ?>
		<th data-name="nama_kelas"><div id="elh_t_sep_nama_kelas" class="t_sep_nama_kelas"><div class="ewTableHeaderCaption"><?php echo $t_sep->nama_kelas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nama_kelas"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->nama_kelas) ?>',2);"><div id="elh_t_sep_nama_kelas" class="t_sep_nama_kelas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->nama_kelas->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->nama_kelas->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->nama_kelas->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($t_sep->table_source->Visible) { // table_source ?>
	<?php if ($t_sep->SortUrl($t_sep->table_source) == "") { ?>
		<th data-name="table_source"><div id="elh_t_sep_table_source" class="t_sep_table_source"><div class="ewTableHeaderCaption"><?php echo $t_sep->table_source->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="table_source"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $t_sep->SortUrl($t_sep->table_source) ?>',2);"><div id="elh_t_sep_table_source" class="t_sep_table_source">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $t_sep->table_source->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($t_sep->table_source->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($t_sep->table_source->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$t_sep_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($t_sep->ExportAll && $t_sep->Export <> "") {
	$t_sep_list->StopRec = $t_sep_list->TotalRecs;
} else {

	// Set the last record to display
	if ($t_sep_list->TotalRecs > $t_sep_list->StartRec + $t_sep_list->DisplayRecs - 1)
		$t_sep_list->StopRec = $t_sep_list->StartRec + $t_sep_list->DisplayRecs - 1;
	else
		$t_sep_list->StopRec = $t_sep_list->TotalRecs;
}
$t_sep_list->RecCnt = $t_sep_list->StartRec - 1;
if ($t_sep_list->Recordset && !$t_sep_list->Recordset->EOF) {
	$t_sep_list->Recordset->MoveFirst();
	$bSelectLimit = $t_sep_list->UseSelectLimit;
	if (!$bSelectLimit && $t_sep_list->StartRec > 1)
		$t_sep_list->Recordset->Move($t_sep_list->StartRec - 1);
} elseif (!$t_sep->AllowAddDeleteRow && $t_sep_list->StopRec == 0) {
	$t_sep_list->StopRec = $t_sep->GridAddRowCount;
}

// Initialize aggregate
$t_sep->RowType = EW_ROWTYPE_AGGREGATEINIT;
$t_sep->ResetAttrs();
$t_sep_list->RenderRow();
while ($t_sep_list->RecCnt < $t_sep_list->StopRec) {
	$t_sep_list->RecCnt++;
	if (intval($t_sep_list->RecCnt) >= intval($t_sep_list->StartRec)) {
		$t_sep_list->RowCnt++;

		// Set up key count
		$t_sep_list->KeyCount = $t_sep_list->RowIndex;

		// Init row class and style
		$t_sep->ResetAttrs();
		$t_sep->CssClass = "";
		if ($t_sep->CurrentAction == "gridadd") {
		} else {
			$t_sep_list->LoadRowValues($t_sep_list->Recordset); // Load row values
		}
		$t_sep->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$t_sep->RowAttrs = array_merge($t_sep->RowAttrs, array('data-rowindex'=>$t_sep_list->RowCnt, 'id'=>'r' . $t_sep_list->RowCnt . '_t_sep', 'data-rowtype'=>$t_sep->RowType));

		// Render row
		$t_sep_list->RenderRow();

		// Render list options
		$t_sep_list->RenderListOptions();
?>
	<tr<?php echo $t_sep->RowAttributes() ?>>
<?php

// Render list options (body, left)
$t_sep_list->ListOptions->Render("body", "left", $t_sep_list->RowCnt);
?>
	<?php if ($t_sep->id->Visible) { // id ?>
		<td data-name="id"<?php echo $t_sep->id->CellAttributes() ?>>
<div id="orig<?php echo $t_sep_list->RowCnt ?>_t_sep_id" class="hide">
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_id" class="t_sep_id">
<span<?php echo $t_sep->id->ViewAttributes() ?>>
<?php echo $t_sep->id->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-success btn-xs"
target="_blank"
href="cetak_form_klaim_52.php?kdspp=<?php echo urlencode(CurrentPage()->idx->CurrentValue)?>">
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>Cetak </b> FORM EKLAIM</a>
<a id="<?php echo $t_sep_list->PageObjName . "_row_" . $t_sep_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($t_sep->nomer_sep->Visible) { // nomer_sep ?>
		<td data-name="nomer_sep"<?php echo $t_sep->nomer_sep->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_nomer_sep" class="t_sep_nomer_sep">
<span<?php echo $t_sep->nomer_sep->ViewAttributes() ?>>
<?php echo $t_sep->nomer_sep->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->nomr->Visible) { // nomr ?>
		<td data-name="nomr"<?php echo $t_sep->nomr->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_nomr" class="t_sep_nomr">
<span<?php echo $t_sep->nomr->ViewAttributes() ?>>
<?php echo $t_sep->nomr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->no_kartubpjs->Visible) { // no_kartubpjs ?>
		<td data-name="no_kartubpjs"<?php echo $t_sep->no_kartubpjs->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_no_kartubpjs" class="t_sep_no_kartubpjs">
<span<?php echo $t_sep->no_kartubpjs->ViewAttributes() ?>>
<?php echo $t_sep->no_kartubpjs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->jenis_layanan->Visible) { // jenis_layanan ?>
		<td data-name="jenis_layanan"<?php echo $t_sep->jenis_layanan->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_jenis_layanan" class="t_sep_jenis_layanan">
<span<?php echo $t_sep->jenis_layanan->ViewAttributes() ?>>
<?php echo $t_sep->jenis_layanan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->tgl_sep->Visible) { // tgl_sep ?>
		<td data-name="tgl_sep"<?php echo $t_sep->tgl_sep->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_tgl_sep" class="t_sep_tgl_sep">
<span<?php echo $t_sep->tgl_sep->ViewAttributes() ?>>
<?php echo $t_sep->tgl_sep->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->poli_eksekutif->Visible) { // poli_eksekutif ?>
		<td data-name="poli_eksekutif"<?php echo $t_sep->poli_eksekutif->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_poli_eksekutif" class="t_sep_poli_eksekutif">
<span<?php echo $t_sep->poli_eksekutif->ViewAttributes() ?>>
<?php echo $t_sep->poli_eksekutif->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->cob->Visible) { // cob ?>
		<td data-name="cob"<?php echo $t_sep->cob->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_cob" class="t_sep_cob">
<span<?php echo $t_sep->cob->ViewAttributes() ?>>
<?php echo $t_sep->cob->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->penjamin_laka->Visible) { // penjamin_laka ?>
		<td data-name="penjamin_laka"<?php echo $t_sep->penjamin_laka->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_penjamin_laka" class="t_sep_penjamin_laka">
<span<?php echo $t_sep->penjamin_laka->ViewAttributes() ?>>
<?php echo $t_sep->penjamin_laka->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->no_telp->Visible) { // no_telp ?>
		<td data-name="no_telp"<?php echo $t_sep->no_telp->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_no_telp" class="t_sep_no_telp">
<span<?php echo $t_sep->no_telp->ViewAttributes() ?>>
<?php echo $t_sep->no_telp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->status_kepesertaan_bpjs->Visible) { // status_kepesertaan_bpjs ?>
		<td data-name="status_kepesertaan_bpjs"<?php echo $t_sep->status_kepesertaan_bpjs->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_status_kepesertaan_bpjs" class="t_sep_status_kepesertaan_bpjs">
<span<?php echo $t_sep->status_kepesertaan_bpjs->ViewAttributes() ?>>
<?php echo $t_sep->status_kepesertaan_bpjs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->faskes_id->Visible) { // faskes_id ?>
		<td data-name="faskes_id"<?php echo $t_sep->faskes_id->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_faskes_id" class="t_sep_faskes_id">
<span<?php echo $t_sep->faskes_id->ViewAttributes() ?>>
<?php echo $t_sep->faskes_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->nama_layanan->Visible) { // nama_layanan ?>
		<td data-name="nama_layanan"<?php echo $t_sep->nama_layanan->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_nama_layanan" class="t_sep_nama_layanan">
<span<?php echo $t_sep->nama_layanan->ViewAttributes() ?>>
<?php echo $t_sep->nama_layanan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->nama_kelas->Visible) { // nama_kelas ?>
		<td data-name="nama_kelas"<?php echo $t_sep->nama_kelas->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_nama_kelas" class="t_sep_nama_kelas">
<span<?php echo $t_sep->nama_kelas->ViewAttributes() ?>>
<?php echo $t_sep->nama_kelas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($t_sep->table_source->Visible) { // table_source ?>
		<td data-name="table_source"<?php echo $t_sep->table_source->CellAttributes() ?>>
<span id="el<?php echo $t_sep_list->RowCnt ?>_t_sep_table_source" class="t_sep_table_source">
<span<?php echo $t_sep->table_source->ViewAttributes() ?>>
<?php echo $t_sep->table_source->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$t_sep_list->ListOptions->Render("body", "right", $t_sep_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($t_sep->CurrentAction <> "gridadd")
		$t_sep_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($t_sep->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($t_sep_list->Recordset)
	$t_sep_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($t_sep->CurrentAction <> "gridadd" && $t_sep->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($t_sep_list->Pager)) $t_sep_list->Pager = new cPrevNextPager($t_sep_list->StartRec, $t_sep_list->DisplayRecs, $t_sep_list->TotalRecs) ?>
<?php if ($t_sep_list->Pager->RecordCount > 0 && $t_sep_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($t_sep_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $t_sep_list->PageUrl() ?>start=<?php echo $t_sep_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($t_sep_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $t_sep_list->PageUrl() ?>start=<?php echo $t_sep_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $t_sep_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($t_sep_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $t_sep_list->PageUrl() ?>start=<?php echo $t_sep_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($t_sep_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $t_sep_list->PageUrl() ?>start=<?php echo $t_sep_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $t_sep_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $t_sep_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $t_sep_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $t_sep_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($t_sep_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $t_sep_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="t_sep">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($t_sep_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($t_sep_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($t_sep_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($t_sep_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($t_sep_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_sep_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($t_sep_list->TotalRecs == 0 && $t_sep->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($t_sep_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ft_seplistsrch.FilterList = <?php echo $t_sep_list->GetFilterList() ?>;
ft_seplistsrch.Init();
ft_seplist.Init();
</script>
<?php
$t_sep_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_sep_list->Page_Terminate();
?>
