<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_ls_gaji_tunjanganinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "l_jenis_detail_sppinfo.php" ?>
<?php include_once "t_spp_detailgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_ls_gaji_tunjangan_list = NULL; // Initialize page object first

class cvw_spp_ls_gaji_tunjangan_list extends cvw_spp_ls_gaji_tunjangan {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_ls_gaji_tunjangan';

	// Page object name
	var $PageObjName = 'vw_spp_ls_gaji_tunjangan_list';

	// Grid form hidden field names
	var $FormName = 'fvw_spp_ls_gaji_tunjanganlist';
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

		// Table object (vw_spp_ls_gaji_tunjangan)
		if (!isset($GLOBALS["vw_spp_ls_gaji_tunjangan"]) || get_class($GLOBALS["vw_spp_ls_gaji_tunjangan"]) == "cvw_spp_ls_gaji_tunjangan") {
			$GLOBALS["vw_spp_ls_gaji_tunjangan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_ls_gaji_tunjangan"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_spp_ls_gaji_tunjanganadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_spp_ls_gaji_tunjangandelete.php";
		$this->MultiUpdateUrl = "vw_spp_ls_gaji_tunjanganupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (l_jenis_detail_spp)
		if (!isset($GLOBALS['l_jenis_detail_spp'])) $GLOBALS['l_jenis_detail_spp'] = new cl_jenis_detail_spp();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_ls_gaji_tunjangan', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_spp_ls_gaji_tunjanganlistsrch";

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
		$this->status_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();
		$this->keterangan->SetVisibility();

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

			// Process auto fill for detail table 't_spp_detail'
			if (@$_POST["grid"] == "ft_spp_detailgrid") {
				if (!isset($GLOBALS["t_spp_detail_grid"])) $GLOBALS["t_spp_detail_grid"] = new ct_spp_detail_grid;
				$GLOBALS["t_spp_detail_grid"]->Page_Init();
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

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		global $EW_EXPORT, $vw_spp_ls_gaji_tunjangan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_ls_gaji_tunjangan);
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "l_jenis_detail_spp") {
			global $l_jenis_detail_spp;
			$rsmaster = $l_jenis_detail_spp->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("l_jenis_detail_spplist.php"); // Return to master page
			} else {
				$l_jenis_detail_spp->LoadListRowValues($rsmaster);
				$l_jenis_detail_spp->RowType = EW_ROWTYPE_MASTER; // Master row
				$l_jenis_detail_spp->RenderListRow();
				$rsmaster->Close();
			}
		}

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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_spp_ls_gaji_tunjanganlistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->detail_jenis_spp->AdvancedSearch->ToJSON(), ","); // Field detail_jenis_spp
		$sFilterList = ew_Concat($sFilterList, $this->id_jenis_spp->AdvancedSearch->ToJSON(), ","); // Field id_jenis_spp
		$sFilterList = ew_Concat($sFilterList, $this->status_spp->AdvancedSearch->ToJSON(), ","); // Field status_spp
		$sFilterList = ew_Concat($sFilterList, $this->no_spp->AdvancedSearch->ToJSON(), ","); // Field no_spp
		$sFilterList = ew_Concat($sFilterList, $this->tgl_spp->AdvancedSearch->ToJSON(), ","); // Field tgl_spp
		$sFilterList = ew_Concat($sFilterList, $this->keterangan->AdvancedSearch->ToJSON(), ","); // Field keterangan
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_spp_ls_gaji_tunjanganlistsrch", $filters);

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

		// Field detail_jenis_spp
		$this->detail_jenis_spp->AdvancedSearch->SearchValue = @$filter["x_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchOperator = @$filter["z_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchCondition = @$filter["v_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchValue2 = @$filter["y_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->SearchOperator2 = @$filter["w_detail_jenis_spp"];
		$this->detail_jenis_spp->AdvancedSearch->Save();

		// Field id_jenis_spp
		$this->id_jenis_spp->AdvancedSearch->SearchValue = @$filter["x_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchOperator = @$filter["z_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchCondition = @$filter["v_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchValue2 = @$filter["y_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->SearchOperator2 = @$filter["w_id_jenis_spp"];
		$this->id_jenis_spp->AdvancedSearch->Save();

		// Field status_spp
		$this->status_spp->AdvancedSearch->SearchValue = @$filter["x_status_spp"];
		$this->status_spp->AdvancedSearch->SearchOperator = @$filter["z_status_spp"];
		$this->status_spp->AdvancedSearch->SearchCondition = @$filter["v_status_spp"];
		$this->status_spp->AdvancedSearch->SearchValue2 = @$filter["y_status_spp"];
		$this->status_spp->AdvancedSearch->SearchOperator2 = @$filter["w_status_spp"];
		$this->status_spp->AdvancedSearch->Save();

		// Field no_spp
		$this->no_spp->AdvancedSearch->SearchValue = @$filter["x_no_spp"];
		$this->no_spp->AdvancedSearch->SearchOperator = @$filter["z_no_spp"];
		$this->no_spp->AdvancedSearch->SearchCondition = @$filter["v_no_spp"];
		$this->no_spp->AdvancedSearch->SearchValue2 = @$filter["y_no_spp"];
		$this->no_spp->AdvancedSearch->SearchOperator2 = @$filter["w_no_spp"];
		$this->no_spp->AdvancedSearch->Save();

		// Field tgl_spp
		$this->tgl_spp->AdvancedSearch->SearchValue = @$filter["x_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchOperator = @$filter["z_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchCondition = @$filter["v_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchValue2 = @$filter["y_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->SearchOperator2 = @$filter["w_tgl_spp"];
		$this->tgl_spp->AdvancedSearch->Save();

		// Field keterangan
		$this->keterangan->AdvancedSearch->SearchValue = @$filter["x_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator = @$filter["z_keterangan"];
		$this->keterangan->AdvancedSearch->SearchCondition = @$filter["v_keterangan"];
		$this->keterangan->AdvancedSearch->SearchValue2 = @$filter["y_keterangan"];
		$this->keterangan->AdvancedSearch->SearchOperator2 = @$filter["w_keterangan"];
		$this->keterangan->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->no_spp, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->keterangan, $arKeywords, $type);
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
			$this->UpdateSort($this->status_spp, $bCtrl); // status_spp
			$this->UpdateSort($this->no_spp, $bCtrl); // no_spp
			$this->UpdateSort($this->tgl_spp, $bCtrl); // tgl_spp
			$this->UpdateSort($this->keterangan, $bCtrl); // keterangan
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->detail_jenis_spp->setSessionValue("");
				$this->id_jenis_spp->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->status_spp->setSort("");
				$this->no_spp->setSort("");
				$this->tgl_spp->setSort("");
				$this->keterangan->setSort("");
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

		// "detail_t_spp_detail"
		$item = &$this->ListOptions->Add("detail_t_spp_detail");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 't_spp_detail') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["t_spp_detail_grid"])) $GLOBALS["t_spp_detail_grid"] = new ct_spp_detail_grid;

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
		$pages->Add("t_spp_detail");
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

		// "detail_t_spp_detail"
		$oListOpt = &$this->ListOptions->Items["detail_t_spp_detail"];
		if ($Security->AllowList(CurrentProjectID() . 't_spp_detail')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("t_spp_detail", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("t_spp_detaillist.php?" . EW_TABLE_SHOW_MASTER . "=vw_spp_ls_gaji_tunjangan&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "&fk_detail_jenis_spp=" . urlencode(strval($this->detail_jenis_spp->CurrentValue)) . "&fk_id_jenis_spp=" . urlencode(strval($this->id_jenis_spp->CurrentValue)) . "&fk_no_spp=" . urlencode(strval($this->no_spp->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["t_spp_detail_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 't_spp_detail')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=t_spp_detail")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "t_spp_detail";
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
		$item = &$option->Add("detailadd_t_spp_detail");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=t_spp_detail");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["t_spp_detail"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["t_spp_detail"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 't_spp_detail') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "t_spp_detail";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_spp_ls_gaji_tunjanganlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_spp_ls_gaji_tunjanganlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_spp_ls_gaji_tunjanganlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fvw_spp_ls_gaji_tunjanganlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->status_spp->setDbValue($rs->fields('status_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->status_spp->DbValue = $row['status_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->tgl_spp->DbValue = $row['tgl_spp'];
		$this->keterangan->DbValue = $row['keterangan'];
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
		// detail_jenis_spp
		// id_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// keterangan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// status_spp
		$this->status_spp->ViewValue = $this->status_spp->CurrentValue;
		$this->status_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// tgl_spp
		$this->tgl_spp->ViewValue = $this->tgl_spp->CurrentValue;
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 0);
		$this->tgl_spp->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

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

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "l_jenis_detail_spp") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->detail_jenis_spp->setQueryStringValue($GLOBALS["l_jenis_detail_spp"]->id->QueryStringValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id_jenis"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id_jenis->setQueryStringValue($_GET["fk_id_jenis"]);
					$this->id_jenis_spp->setQueryStringValue($GLOBALS["l_jenis_detail_spp"]->id_jenis->QueryStringValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id_jenis->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "l_jenis_detail_spp") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id->setFormValue($_POST["fk_id"]);
					$this->detail_jenis_spp->setFormValue($GLOBALS["l_jenis_detail_spp"]->id->FormValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id_jenis"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id_jenis->setFormValue($_POST["fk_id_jenis"]);
					$this->id_jenis_spp->setFormValue($GLOBALS["l_jenis_detail_spp"]->id_jenis->FormValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id_jenis->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "l_jenis_detail_spp") {
				if ($this->detail_jenis_spp->CurrentValue == "") $this->detail_jenis_spp->setSessionValue("");
				if ($this->id_jenis_spp->CurrentValue == "") $this->id_jenis_spp->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
if (!isset($vw_spp_ls_gaji_tunjangan_list)) $vw_spp_ls_gaji_tunjangan_list = new cvw_spp_ls_gaji_tunjangan_list();

// Page init
$vw_spp_ls_gaji_tunjangan_list->Page_Init();

// Page main
$vw_spp_ls_gaji_tunjangan_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_ls_gaji_tunjangan_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_spp_ls_gaji_tunjanganlist = new ew_Form("fvw_spp_ls_gaji_tunjanganlist", "list");
fvw_spp_ls_gaji_tunjanganlist.FormKeyCountName = '<?php echo $vw_spp_ls_gaji_tunjangan_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvw_spp_ls_gaji_tunjanganlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_ls_gaji_tunjanganlist.ValidateRequired = true;
<?php } else { ?>
fvw_spp_ls_gaji_tunjanganlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fvw_spp_ls_gaji_tunjanganlistsrch = new ew_Form("fvw_spp_ls_gaji_tunjanganlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_spp_ls_gaji_tunjangan_list->TotalRecs > 0 && $vw_spp_ls_gaji_tunjangan_list->ExportOptions->Visible()) { ?>
<?php $vw_spp_ls_gaji_tunjangan_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan_list->SearchOptions->Visible()) { ?>
<?php $vw_spp_ls_gaji_tunjangan_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan_list->FilterOptions->Visible()) { ?>
<?php $vw_spp_ls_gaji_tunjangan_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php if (($vw_spp_ls_gaji_tunjangan->Export == "") || (EW_EXPORT_MASTER_RECORD && $vw_spp_ls_gaji_tunjangan->Export == "print")) { ?>
<?php
if ($vw_spp_ls_gaji_tunjangan_list->DbMasterFilter <> "" && $vw_spp_ls_gaji_tunjangan->getCurrentMasterTable() == "l_jenis_detail_spp") {
	if ($vw_spp_ls_gaji_tunjangan_list->MasterRecordExists) {
?>
<?php include_once "l_jenis_detail_sppmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $vw_spp_ls_gaji_tunjangan_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_spp_ls_gaji_tunjangan_list->TotalRecs <= 0)
			$vw_spp_ls_gaji_tunjangan_list->TotalRecs = $vw_spp_ls_gaji_tunjangan->SelectRecordCount();
	} else {
		if (!$vw_spp_ls_gaji_tunjangan_list->Recordset && ($vw_spp_ls_gaji_tunjangan_list->Recordset = $vw_spp_ls_gaji_tunjangan_list->LoadRecordset()))
			$vw_spp_ls_gaji_tunjangan_list->TotalRecs = $vw_spp_ls_gaji_tunjangan_list->Recordset->RecordCount();
	}
	$vw_spp_ls_gaji_tunjangan_list->StartRec = 1;
	if ($vw_spp_ls_gaji_tunjangan_list->DisplayRecs <= 0 || ($vw_spp_ls_gaji_tunjangan->Export <> "" && $vw_spp_ls_gaji_tunjangan->ExportAll)) // Display all records
		$vw_spp_ls_gaji_tunjangan_list->DisplayRecs = $vw_spp_ls_gaji_tunjangan_list->TotalRecs;
	if (!($vw_spp_ls_gaji_tunjangan->Export <> "" && $vw_spp_ls_gaji_tunjangan->ExportAll))
		$vw_spp_ls_gaji_tunjangan_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_spp_ls_gaji_tunjangan_list->Recordset = $vw_spp_ls_gaji_tunjangan_list->LoadRecordset($vw_spp_ls_gaji_tunjangan_list->StartRec-1, $vw_spp_ls_gaji_tunjangan_list->DisplayRecs);

	// Set no record found message
	if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "" && $vw_spp_ls_gaji_tunjangan_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_spp_ls_gaji_tunjangan_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_spp_ls_gaji_tunjangan_list->SearchWhere == "0=101")
			$vw_spp_ls_gaji_tunjangan_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_spp_ls_gaji_tunjangan_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$vw_spp_ls_gaji_tunjangan_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($vw_spp_ls_gaji_tunjangan->Export == "" && $vw_spp_ls_gaji_tunjangan->CurrentAction == "") { ?>
<form name="fvw_spp_ls_gaji_tunjanganlistsrch" id="fvw_spp_ls_gaji_tunjanganlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($vw_spp_ls_gaji_tunjangan_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fvw_spp_ls_gaji_tunjanganlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vw_spp_ls_gaji_tunjangan">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $vw_spp_ls_gaji_tunjangan_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($vw_spp_ls_gaji_tunjangan_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($vw_spp_ls_gaji_tunjangan_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($vw_spp_ls_gaji_tunjangan_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($vw_spp_ls_gaji_tunjangan_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $vw_spp_ls_gaji_tunjangan_list->ShowPageHeader(); ?>
<?php
$vw_spp_ls_gaji_tunjangan_list->ShowMessage();
?>
<?php if ($vw_spp_ls_gaji_tunjangan_list->TotalRecs > 0 || $vw_spp_ls_gaji_tunjangan->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_spp_ls_gaji_tunjangan">
<form name="fvw_spp_ls_gaji_tunjanganlist" id="fvw_spp_ls_gaji_tunjanganlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_ls_gaji_tunjangan_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_ls_gaji_tunjangan">
<?php if ($vw_spp_ls_gaji_tunjangan->getCurrentMasterTable() == "l_jenis_detail_spp" && $vw_spp_ls_gaji_tunjangan->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="l_jenis_detail_spp">
<input type="hidden" name="fk_id" value="<?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->getSessionValue() ?>">
<input type="hidden" name="fk_id_jenis" value="<?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->getSessionValue() ?>">
<?php } ?>
<div id="gmp_vw_spp_ls_gaji_tunjangan" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_spp_ls_gaji_tunjangan_list->TotalRecs > 0 || $vw_spp_ls_gaji_tunjangan->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_spp_ls_gaji_tunjanganlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_spp_ls_gaji_tunjangan->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_spp_ls_gaji_tunjangan_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_spp_ls_gaji_tunjangan_list->RenderListOptions();

// Render list options (header, left)
$vw_spp_ls_gaji_tunjangan_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_spp_ls_gaji_tunjangan->status_spp->Visible) { // status_spp ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->status_spp) == "") { ?>
		<th data-name="status_spp"><div id="elh_vw_spp_ls_gaji_tunjangan_status_spp" class="vw_spp_ls_gaji_tunjangan_status_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->status_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->status_spp) ?>',2);"><div id="elh_vw_spp_ls_gaji_tunjangan_status_spp" class="vw_spp_ls_gaji_tunjangan_status_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->status_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->status_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->status_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_ls_gaji_tunjangan->no_spp->Visible) { // no_spp ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->no_spp) == "") { ?>
		<th data-name="no_spp"><div id="elh_vw_spp_ls_gaji_tunjangan_no_spp" class="vw_spp_ls_gaji_tunjangan_no_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->no_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->no_spp) ?>',2);"><div id="elh_vw_spp_ls_gaji_tunjangan_no_spp" class="vw_spp_ls_gaji_tunjangan_no_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->no_spp->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->no_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->no_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->Visible) { // tgl_spp ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->tgl_spp) == "") { ?>
		<th data-name="tgl_spp"><div id="elh_vw_spp_ls_gaji_tunjangan_tgl_spp" class="vw_spp_ls_gaji_tunjangan_tgl_spp"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tgl_spp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->tgl_spp) ?>',2);"><div id="elh_vw_spp_ls_gaji_tunjangan_tgl_spp" class="vw_spp_ls_gaji_tunjangan_tgl_spp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->tgl_spp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_spp_ls_gaji_tunjangan->keterangan->Visible) { // keterangan ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->keterangan) == "") { ?>
		<th data-name="keterangan"><div id="elh_vw_spp_ls_gaji_tunjangan_keterangan" class="vw_spp_ls_gaji_tunjangan_keterangan"><div class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->keterangan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="keterangan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_spp_ls_gaji_tunjangan->SortUrl($vw_spp_ls_gaji_tunjangan->keterangan) ?>',2);"><div id="elh_vw_spp_ls_gaji_tunjangan_keterangan" class="vw_spp_ls_gaji_tunjangan_keterangan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_spp_ls_gaji_tunjangan->keterangan->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_spp_ls_gaji_tunjangan->keterangan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_spp_ls_gaji_tunjangan->keterangan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_spp_ls_gaji_tunjangan_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_spp_ls_gaji_tunjangan->ExportAll && $vw_spp_ls_gaji_tunjangan->Export <> "") {
	$vw_spp_ls_gaji_tunjangan_list->StopRec = $vw_spp_ls_gaji_tunjangan_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_spp_ls_gaji_tunjangan_list->TotalRecs > $vw_spp_ls_gaji_tunjangan_list->StartRec + $vw_spp_ls_gaji_tunjangan_list->DisplayRecs - 1)
		$vw_spp_ls_gaji_tunjangan_list->StopRec = $vw_spp_ls_gaji_tunjangan_list->StartRec + $vw_spp_ls_gaji_tunjangan_list->DisplayRecs - 1;
	else
		$vw_spp_ls_gaji_tunjangan_list->StopRec = $vw_spp_ls_gaji_tunjangan_list->TotalRecs;
}
$vw_spp_ls_gaji_tunjangan_list->RecCnt = $vw_spp_ls_gaji_tunjangan_list->StartRec - 1;
if ($vw_spp_ls_gaji_tunjangan_list->Recordset && !$vw_spp_ls_gaji_tunjangan_list->Recordset->EOF) {
	$vw_spp_ls_gaji_tunjangan_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_spp_ls_gaji_tunjangan_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_spp_ls_gaji_tunjangan_list->StartRec > 1)
		$vw_spp_ls_gaji_tunjangan_list->Recordset->Move($vw_spp_ls_gaji_tunjangan_list->StartRec - 1);
} elseif (!$vw_spp_ls_gaji_tunjangan->AllowAddDeleteRow && $vw_spp_ls_gaji_tunjangan_list->StopRec == 0) {
	$vw_spp_ls_gaji_tunjangan_list->StopRec = $vw_spp_ls_gaji_tunjangan->GridAddRowCount;
}

// Initialize aggregate
$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_spp_ls_gaji_tunjangan->ResetAttrs();
$vw_spp_ls_gaji_tunjangan_list->RenderRow();
while ($vw_spp_ls_gaji_tunjangan_list->RecCnt < $vw_spp_ls_gaji_tunjangan_list->StopRec) {
	$vw_spp_ls_gaji_tunjangan_list->RecCnt++;
	if (intval($vw_spp_ls_gaji_tunjangan_list->RecCnt) >= intval($vw_spp_ls_gaji_tunjangan_list->StartRec)) {
		$vw_spp_ls_gaji_tunjangan_list->RowCnt++;

		// Set up key count
		$vw_spp_ls_gaji_tunjangan_list->KeyCount = $vw_spp_ls_gaji_tunjangan_list->RowIndex;

		// Init row class and style
		$vw_spp_ls_gaji_tunjangan->ResetAttrs();
		$vw_spp_ls_gaji_tunjangan->CssClass = "";
		if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "gridadd") {
		} else {
			$vw_spp_ls_gaji_tunjangan_list->LoadRowValues($vw_spp_ls_gaji_tunjangan_list->Recordset); // Load row values
		}
		$vw_spp_ls_gaji_tunjangan->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vw_spp_ls_gaji_tunjangan->RowAttrs = array_merge($vw_spp_ls_gaji_tunjangan->RowAttrs, array('data-rowindex'=>$vw_spp_ls_gaji_tunjangan_list->RowCnt, 'id'=>'r' . $vw_spp_ls_gaji_tunjangan_list->RowCnt . '_vw_spp_ls_gaji_tunjangan', 'data-rowtype'=>$vw_spp_ls_gaji_tunjangan->RowType));

		// Render row
		$vw_spp_ls_gaji_tunjangan_list->RenderRow();

		// Render list options
		$vw_spp_ls_gaji_tunjangan_list->RenderListOptions();
?>
	<tr<?php echo $vw_spp_ls_gaji_tunjangan->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_spp_ls_gaji_tunjangan_list->ListOptions->Render("body", "left", $vw_spp_ls_gaji_tunjangan_list->RowCnt);
?>
	<?php if ($vw_spp_ls_gaji_tunjangan->status_spp->Visible) { // status_spp ?>
		<td data-name="status_spp"<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->CellAttributes() ?>>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_list->RowCnt ?>_vw_spp_ls_gaji_tunjangan_status_spp" class="vw_spp_ls_gaji_tunjangan_status_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->ListViewValue() ?></span>
</span>
<a id="<?php echo $vw_spp_ls_gaji_tunjangan_list->PageObjName . "_row_" . $vw_spp_ls_gaji_tunjangan_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->no_spp->Visible) { // no_spp ?>
		<td data-name="no_spp"<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->CellAttributes() ?>>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_list->RowCnt ?>_vw_spp_ls_gaji_tunjangan_no_spp" class="vw_spp_ls_gaji_tunjangan_no_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->Visible) { // tgl_spp ?>
		<td data-name="tgl_spp"<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->CellAttributes() ?>>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_list->RowCnt ?>_vw_spp_ls_gaji_tunjangan_tgl_spp" class="vw_spp_ls_gaji_tunjangan_tgl_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_spp_ls_gaji_tunjangan->keterangan->Visible) { // keterangan ?>
		<td data-name="keterangan"<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->CellAttributes() ?>>
<span id="el<?php echo $vw_spp_ls_gaji_tunjangan_list->RowCnt ?>_vw_spp_ls_gaji_tunjangan_keterangan" class="vw_spp_ls_gaji_tunjangan_keterangan">
<span<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_spp_ls_gaji_tunjangan_list->ListOptions->Render("body", "right", $vw_spp_ls_gaji_tunjangan_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "gridadd")
		$vw_spp_ls_gaji_tunjangan_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_spp_ls_gaji_tunjangan_list->Recordset)
	$vw_spp_ls_gaji_tunjangan_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_spp_ls_gaji_tunjangan->CurrentAction <> "gridadd" && $vw_spp_ls_gaji_tunjangan->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_spp_ls_gaji_tunjangan_list->Pager)) $vw_spp_ls_gaji_tunjangan_list->Pager = new cPrevNextPager($vw_spp_ls_gaji_tunjangan_list->StartRec, $vw_spp_ls_gaji_tunjangan_list->DisplayRecs, $vw_spp_ls_gaji_tunjangan_list->TotalRecs) ?>
<?php if ($vw_spp_ls_gaji_tunjangan_list->Pager->RecordCount > 0 && $vw_spp_ls_gaji_tunjangan_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_spp_ls_gaji_tunjangan_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_spp_ls_gaji_tunjangan_list->PageUrl() ?>start=<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_spp_ls_gaji_tunjangan_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_spp_ls_gaji_tunjangan_list->PageUrl() ?>start=<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_spp_ls_gaji_tunjangan_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_spp_ls_gaji_tunjangan_list->PageUrl() ?>start=<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_spp_ls_gaji_tunjangan_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_spp_ls_gaji_tunjangan_list->PageUrl() ?>start=<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_spp_ls_gaji_tunjangan_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_spp_ls_gaji_tunjangan_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_spp_ls_gaji_tunjangan">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_spp_ls_gaji_tunjangan_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_spp_ls_gaji_tunjangan_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_spp_ls_gaji_tunjangan_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_spp_ls_gaji_tunjangan_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_spp_ls_gaji_tunjangan_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_spp_ls_gaji_tunjangan_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan_list->TotalRecs == 0 && $vw_spp_ls_gaji_tunjangan->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_spp_ls_gaji_tunjangan_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_spp_ls_gaji_tunjanganlistsrch.FilterList = <?php echo $vw_spp_ls_gaji_tunjangan_list->GetFilterList() ?>;
fvw_spp_ls_gaji_tunjanganlistsrch.Init();
fvw_spp_ls_gaji_tunjanganlist.Init();
</script>
<?php
$vw_spp_ls_gaji_tunjangan_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_ls_gaji_tunjangan_list->Page_Terminate();
?>
