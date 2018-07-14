<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bill_ranap_detail_pelayanan_losinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_bill_ranapinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bill_ranap_detail_pelayanan_los_list = NULL; // Initialize page object first

class cvw_bill_ranap_detail_pelayanan_los_list extends cvw_bill_ranap_detail_pelayanan_los {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bill_ranap_detail_pelayanan_los';

	// Page object name
	var $PageObjName = 'vw_bill_ranap_detail_pelayanan_los_list';

	// Grid form hidden field names
	var $FormName = 'fvw_bill_ranap_detail_pelayanan_loslist';
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

		// Table object (vw_bill_ranap_detail_pelayanan_los)
		if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los"]) || get_class($GLOBALS["vw_bill_ranap_detail_pelayanan_los"]) == "cvw_bill_ranap_detail_pelayanan_los") {
			$GLOBALS["vw_bill_ranap_detail_pelayanan_los"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bill_ranap_detail_pelayanan_los"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_bill_ranap_detail_pelayanan_losadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_bill_ranap_detail_pelayanan_losdelete.php";
		$this->MultiUpdateUrl = "vw_bill_ranap_detail_pelayanan_losupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (vw_bill_ranap)
		if (!isset($GLOBALS['vw_bill_ranap'])) $GLOBALS['vw_bill_ranap'] = new cvw_bill_ranap();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bill_ranap_detail_pelayanan_los', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_bill_ranap_detail_pelayanan_loslistsrch";

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
		$this->kode_tindakan->SetVisibility();
		$this->tarif->SetVisibility();
		$this->qty->SetVisibility();
		$this->user->SetVisibility();
		$this->no_ruang->SetVisibility();

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
		global $EW_EXPORT, $vw_bill_ranap_detail_pelayanan_los;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bill_ranap_detail_pelayanan_los);
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "vw_bill_ranap") {
			global $vw_bill_ranap;
			$rsmaster = $vw_bill_ranap->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("vw_bill_ranaplist.php"); // Return to master page
			} else {
				$vw_bill_ranap->LoadListRowValues($rsmaster);
				$vw_bill_ranap->RowType = EW_ROWTYPE_MASTER; // Master row
				$vw_bill_ranap->RenderListRow();
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_bill_ranap_detail_pelayanan_loslistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->id_admission->AdvancedSearch->ToJSON(), ","); // Field id_admission
		$sFilterList = ew_Concat($sFilterList, $this->nomr->AdvancedSearch->ToJSON(), ","); // Field nomr
		$sFilterList = ew_Concat($sFilterList, $this->statusbayar->AdvancedSearch->ToJSON(), ","); // Field statusbayar
		$sFilterList = ew_Concat($sFilterList, $this->kelas->AdvancedSearch->ToJSON(), ","); // Field kelas
		$sFilterList = ew_Concat($sFilterList, $this->tanggal->AdvancedSearch->ToJSON(), ","); // Field tanggal
		$sFilterList = ew_Concat($sFilterList, $this->kode_tindakan->AdvancedSearch->ToJSON(), ","); // Field kode_tindakan
		$sFilterList = ew_Concat($sFilterList, $this->nama_tindakan->AdvancedSearch->ToJSON(), ","); // Field nama_tindakan
		$sFilterList = ew_Concat($sFilterList, $this->kelompok1->AdvancedSearch->ToJSON(), ","); // Field kelompok1
		$sFilterList = ew_Concat($sFilterList, $this->kelompok2->AdvancedSearch->ToJSON(), ","); // Field kelompok2
		$sFilterList = ew_Concat($sFilterList, $this->tarif->AdvancedSearch->ToJSON(), ","); // Field tarif
		$sFilterList = ew_Concat($sFilterList, $this->bhp->AdvancedSearch->ToJSON(), ","); // Field bhp
		$sFilterList = ew_Concat($sFilterList, $this->qty->AdvancedSearch->ToJSON(), ","); // Field qty
		$sFilterList = ew_Concat($sFilterList, $this->user->AdvancedSearch->ToJSON(), ","); // Field user
		$sFilterList = ew_Concat($sFilterList, $this->kelompok_tindakan->AdvancedSearch->ToJSON(), ","); // Field kelompok_tindakan
		$sFilterList = ew_Concat($sFilterList, $this->kode_dokter->AdvancedSearch->ToJSON(), ","); // Field kode_dokter
		$sFilterList = ew_Concat($sFilterList, $this->no_ruang->AdvancedSearch->ToJSON(), ","); // Field no_ruang
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_bill_ranap_detail_pelayanan_loslistsrch", $filters);

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

		// Field kelas
		$this->kelas->AdvancedSearch->SearchValue = @$filter["x_kelas"];
		$this->kelas->AdvancedSearch->SearchOperator = @$filter["z_kelas"];
		$this->kelas->AdvancedSearch->SearchCondition = @$filter["v_kelas"];
		$this->kelas->AdvancedSearch->SearchValue2 = @$filter["y_kelas"];
		$this->kelas->AdvancedSearch->SearchOperator2 = @$filter["w_kelas"];
		$this->kelas->AdvancedSearch->Save();

		// Field tanggal
		$this->tanggal->AdvancedSearch->SearchValue = @$filter["x_tanggal"];
		$this->tanggal->AdvancedSearch->SearchOperator = @$filter["z_tanggal"];
		$this->tanggal->AdvancedSearch->SearchCondition = @$filter["v_tanggal"];
		$this->tanggal->AdvancedSearch->SearchValue2 = @$filter["y_tanggal"];
		$this->tanggal->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal"];
		$this->tanggal->AdvancedSearch->Save();

		// Field kode_tindakan
		$this->kode_tindakan->AdvancedSearch->SearchValue = @$filter["x_kode_tindakan"];
		$this->kode_tindakan->AdvancedSearch->SearchOperator = @$filter["z_kode_tindakan"];
		$this->kode_tindakan->AdvancedSearch->SearchCondition = @$filter["v_kode_tindakan"];
		$this->kode_tindakan->AdvancedSearch->SearchValue2 = @$filter["y_kode_tindakan"];
		$this->kode_tindakan->AdvancedSearch->SearchOperator2 = @$filter["w_kode_tindakan"];
		$this->kode_tindakan->AdvancedSearch->Save();

		// Field nama_tindakan
		$this->nama_tindakan->AdvancedSearch->SearchValue = @$filter["x_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchOperator = @$filter["z_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchCondition = @$filter["v_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchValue2 = @$filter["y_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchOperator2 = @$filter["w_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->Save();

		// Field kelompok1
		$this->kelompok1->AdvancedSearch->SearchValue = @$filter["x_kelompok1"];
		$this->kelompok1->AdvancedSearch->SearchOperator = @$filter["z_kelompok1"];
		$this->kelompok1->AdvancedSearch->SearchCondition = @$filter["v_kelompok1"];
		$this->kelompok1->AdvancedSearch->SearchValue2 = @$filter["y_kelompok1"];
		$this->kelompok1->AdvancedSearch->SearchOperator2 = @$filter["w_kelompok1"];
		$this->kelompok1->AdvancedSearch->Save();

		// Field kelompok2
		$this->kelompok2->AdvancedSearch->SearchValue = @$filter["x_kelompok2"];
		$this->kelompok2->AdvancedSearch->SearchOperator = @$filter["z_kelompok2"];
		$this->kelompok2->AdvancedSearch->SearchCondition = @$filter["v_kelompok2"];
		$this->kelompok2->AdvancedSearch->SearchValue2 = @$filter["y_kelompok2"];
		$this->kelompok2->AdvancedSearch->SearchOperator2 = @$filter["w_kelompok2"];
		$this->kelompok2->AdvancedSearch->Save();

		// Field tarif
		$this->tarif->AdvancedSearch->SearchValue = @$filter["x_tarif"];
		$this->tarif->AdvancedSearch->SearchOperator = @$filter["z_tarif"];
		$this->tarif->AdvancedSearch->SearchCondition = @$filter["v_tarif"];
		$this->tarif->AdvancedSearch->SearchValue2 = @$filter["y_tarif"];
		$this->tarif->AdvancedSearch->SearchOperator2 = @$filter["w_tarif"];
		$this->tarif->AdvancedSearch->Save();

		// Field bhp
		$this->bhp->AdvancedSearch->SearchValue = @$filter["x_bhp"];
		$this->bhp->AdvancedSearch->SearchOperator = @$filter["z_bhp"];
		$this->bhp->AdvancedSearch->SearchCondition = @$filter["v_bhp"];
		$this->bhp->AdvancedSearch->SearchValue2 = @$filter["y_bhp"];
		$this->bhp->AdvancedSearch->SearchOperator2 = @$filter["w_bhp"];
		$this->bhp->AdvancedSearch->Save();

		// Field qty
		$this->qty->AdvancedSearch->SearchValue = @$filter["x_qty"];
		$this->qty->AdvancedSearch->SearchOperator = @$filter["z_qty"];
		$this->qty->AdvancedSearch->SearchCondition = @$filter["v_qty"];
		$this->qty->AdvancedSearch->SearchValue2 = @$filter["y_qty"];
		$this->qty->AdvancedSearch->SearchOperator2 = @$filter["w_qty"];
		$this->qty->AdvancedSearch->Save();

		// Field user
		$this->user->AdvancedSearch->SearchValue = @$filter["x_user"];
		$this->user->AdvancedSearch->SearchOperator = @$filter["z_user"];
		$this->user->AdvancedSearch->SearchCondition = @$filter["v_user"];
		$this->user->AdvancedSearch->SearchValue2 = @$filter["y_user"];
		$this->user->AdvancedSearch->SearchOperator2 = @$filter["w_user"];
		$this->user->AdvancedSearch->Save();

		// Field kelompok_tindakan
		$this->kelompok_tindakan->AdvancedSearch->SearchValue = @$filter["x_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchOperator = @$filter["z_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchCondition = @$filter["v_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchValue2 = @$filter["y_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchOperator2 = @$filter["w_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->Save();

		// Field kode_dokter
		$this->kode_dokter->AdvancedSearch->SearchValue = @$filter["x_kode_dokter"];
		$this->kode_dokter->AdvancedSearch->SearchOperator = @$filter["z_kode_dokter"];
		$this->kode_dokter->AdvancedSearch->SearchCondition = @$filter["v_kode_dokter"];
		$this->kode_dokter->AdvancedSearch->SearchValue2 = @$filter["y_kode_dokter"];
		$this->kode_dokter->AdvancedSearch->SearchOperator2 = @$filter["w_kode_dokter"];
		$this->kode_dokter->AdvancedSearch->Save();

		// Field no_ruang
		$this->no_ruang->AdvancedSearch->SearchValue = @$filter["x_no_ruang"];
		$this->no_ruang->AdvancedSearch->SearchOperator = @$filter["z_no_ruang"];
		$this->no_ruang->AdvancedSearch->SearchCondition = @$filter["v_no_ruang"];
		$this->no_ruang->AdvancedSearch->SearchValue2 = @$filter["y_no_ruang"];
		$this->no_ruang->AdvancedSearch->SearchOperator2 = @$filter["w_no_ruang"];
		$this->no_ruang->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nomr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nama_tindakan, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->user, $arKeywords, $type);
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
			$this->UpdateSort($this->kode_tindakan, $bCtrl); // kode_tindakan
			$this->UpdateSort($this->tarif, $bCtrl); // tarif
			$this->UpdateSort($this->qty, $bCtrl); // qty
			$this->UpdateSort($this->user, $bCtrl); // user
			$this->UpdateSort($this->no_ruang, $bCtrl); // no_ruang
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
				$this->id_admission->setSessionValue("");
				$this->nomr->setSessionValue("");
				$this->statusbayar->setSessionValue("");
				$this->kelas->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->kode_tindakan->setSort("");
				$this->tarif->setSort("");
				$this->qty->setSort("");
				$this->user->setSort("");
				$this->no_ruang->setSort("");
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
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_bill_ranap_detail_pelayanan_loslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_bill_ranap_detail_pelayanan_loslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_bill_ranap_detail_pelayanan_loslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fvw_bill_ranap_detail_pelayanan_loslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->kode_tindakan->setDbValue($rs->fields('kode_tindakan'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok1->setDbValue($rs->fields('kelompok1'));
		$this->kelompok2->setDbValue($rs->fields('kelompok2'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->bhp->setDbValue($rs->fields('bhp'));
		$this->qty->setDbValue($rs->fields('qty'));
		$this->user->setDbValue($rs->fields('user'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->kode_dokter->setDbValue($rs->fields('kode_dokter'));
		$this->no_ruang->setDbValue($rs->fields('no_ruang'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kelas->DbValue = $row['kelas'];
		$this->tanggal->DbValue = $row['tanggal'];
		$this->kode_tindakan->DbValue = $row['kode_tindakan'];
		$this->nama_tindakan->DbValue = $row['nama_tindakan'];
		$this->kelompok1->DbValue = $row['kelompok1'];
		$this->kelompok2->DbValue = $row['kelompok2'];
		$this->tarif->DbValue = $row['tarif'];
		$this->bhp->DbValue = $row['bhp'];
		$this->qty->DbValue = $row['qty'];
		$this->user->DbValue = $row['user'];
		$this->kelompok_tindakan->DbValue = $row['kelompok_tindakan'];
		$this->kode_dokter->DbValue = $row['kode_dokter'];
		$this->no_ruang->DbValue = $row['no_ruang'];
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

		// Convert decimal values if posted back
		if ($this->tarif->FormValue == $this->tarif->CurrentValue && is_numeric(ew_StrToFloat($this->tarif->CurrentValue)))
			$this->tarif->CurrentValue = ew_StrToFloat($this->tarif->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_admission
		// nomr
		// statusbayar
		// kelas
		// tanggal
		// kode_tindakan
		// nama_tindakan
		// kelompok1
		// kelompok2
		// tarif
		// bhp
		// qty
		// user
		// kelompok_tindakan
		// kode_dokter
		// no_ruang

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
		$this->statusbayar->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 0);
		$this->tanggal->ViewCustomAttributes = "";

		// kode_tindakan
		$this->kode_tindakan->ViewValue = $this->kode_tindakan->CurrentValue;
		if (strval($this->kode_tindakan->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_bill_ranap_data_tarif_tindakan`";
		$sWhereWrk = "";
		$this->kode_tindakan->LookupFilters = array();
		$lookuptblfilter = "`kelompok_tindakan`='8'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->CurrentValue;
			}
		} else {
			$this->kode_tindakan->ViewValue = NULL;
		}
		$this->kode_tindakan->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// kelompok1
		$this->kelompok1->ViewValue = $this->kelompok1->CurrentValue;
		$this->kelompok1->ViewCustomAttributes = "";

		// kelompok2
		$this->kelompok2->ViewValue = $this->kelompok2->CurrentValue;
		$this->kelompok2->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

		// qty
		$this->qty->ViewValue = $this->qty->CurrentValue;
		$this->qty->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// kode_dokter
		$this->kode_dokter->ViewValue = $this->kode_dokter->CurrentValue;
		$this->kode_dokter->ViewCustomAttributes = "";

		// no_ruang
		$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->ViewCustomAttributes = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";
			$this->kode_tindakan->TooltipValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";
			$this->tarif->TooltipValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";
			$this->qty->TooltipValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";
			$this->user->TooltipValue = "";

			// no_ruang
			$this->no_ruang->LinkCustomAttributes = "";
			$this->no_ruang->HrefValue = "";
			$this->no_ruang->TooltipValue = "";
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
			if ($sMasterTblVar == "vw_bill_ranap") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id_admission"] <> "") {
					$GLOBALS["vw_bill_ranap"]->id_admission->setQueryStringValue($_GET["fk_id_admission"]);
					$this->id_admission->setQueryStringValue($GLOBALS["vw_bill_ranap"]->id_admission->QueryStringValue);
					$this->id_admission->setSessionValue($this->id_admission->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->id_admission->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_nomr"] <> "") {
					$GLOBALS["vw_bill_ranap"]->nomr->setQueryStringValue($_GET["fk_nomr"]);
					$this->nomr->setQueryStringValue($GLOBALS["vw_bill_ranap"]->nomr->QueryStringValue);
					$this->nomr->setSessionValue($this->nomr->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_statusbayar"] <> "") {
					$GLOBALS["vw_bill_ranap"]->statusbayar->setQueryStringValue($_GET["fk_statusbayar"]);
					$this->statusbayar->setQueryStringValue($GLOBALS["vw_bill_ranap"]->statusbayar->QueryStringValue);
					$this->statusbayar->setSessionValue($this->statusbayar->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->statusbayar->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_KELASPERAWATAN_ID"] <> "") {
					$GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->setQueryStringValue($_GET["fk_KELASPERAWATAN_ID"]);
					$this->kelas->setQueryStringValue($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->QueryStringValue);
					$this->kelas->setSessionValue($this->kelas->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "vw_bill_ranap") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id_admission"] <> "") {
					$GLOBALS["vw_bill_ranap"]->id_admission->setFormValue($_POST["fk_id_admission"]);
					$this->id_admission->setFormValue($GLOBALS["vw_bill_ranap"]->id_admission->FormValue);
					$this->id_admission->setSessionValue($this->id_admission->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->id_admission->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_nomr"] <> "") {
					$GLOBALS["vw_bill_ranap"]->nomr->setFormValue($_POST["fk_nomr"]);
					$this->nomr->setFormValue($GLOBALS["vw_bill_ranap"]->nomr->FormValue);
					$this->nomr->setSessionValue($this->nomr->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_statusbayar"] <> "") {
					$GLOBALS["vw_bill_ranap"]->statusbayar->setFormValue($_POST["fk_statusbayar"]);
					$this->statusbayar->setFormValue($GLOBALS["vw_bill_ranap"]->statusbayar->FormValue);
					$this->statusbayar->setSessionValue($this->statusbayar->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->statusbayar->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_KELASPERAWATAN_ID"] <> "") {
					$GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->setFormValue($_POST["fk_KELASPERAWATAN_ID"]);
					$this->kelas->setFormValue($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->FormValue);
					$this->kelas->setSessionValue($this->kelas->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "vw_bill_ranap") {
				if ($this->id_admission->CurrentValue == "") $this->id_admission->setSessionValue("");
				if ($this->nomr->CurrentValue == "") $this->nomr->setSessionValue("");
				if ($this->statusbayar->CurrentValue == "") $this->statusbayar->setSessionValue("");
				if ($this->kelas->CurrentValue == "") $this->kelas->setSessionValue("");
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
if (!isset($vw_bill_ranap_detail_pelayanan_los_list)) $vw_bill_ranap_detail_pelayanan_los_list = new cvw_bill_ranap_detail_pelayanan_los_list();

// Page init
$vw_bill_ranap_detail_pelayanan_los_list->Page_Init();

// Page main
$vw_bill_ranap_detail_pelayanan_los_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_pelayanan_los_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_bill_ranap_detail_pelayanan_loslist = new ew_Form("fvw_bill_ranap_detail_pelayanan_loslist", "list");
fvw_bill_ranap_detail_pelayanan_loslist.FormKeyCountName = '<?php echo $vw_bill_ranap_detail_pelayanan_los_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvw_bill_ranap_detail_pelayanan_loslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_pelayanan_loslist.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_pelayanan_loslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_pelayanan_loslist.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};

// Form object for search
var CurrentSearchForm = fvw_bill_ranap_detail_pelayanan_loslistsrch = new ew_Form("fvw_bill_ranap_detail_pelayanan_loslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->TotalRecs > 0 && $vw_bill_ranap_detail_pelayanan_los_list->ExportOptions->Visible()) { ?>
<?php $vw_bill_ranap_detail_pelayanan_los_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->SearchOptions->Visible()) { ?>
<?php $vw_bill_ranap_detail_pelayanan_los_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->FilterOptions->Visible()) { ?>
<?php $vw_bill_ranap_detail_pelayanan_los_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php if (($vw_bill_ranap_detail_pelayanan_los->Export == "") || (EW_EXPORT_MASTER_RECORD && $vw_bill_ranap_detail_pelayanan_los->Export == "print")) { ?>
<?php
if ($vw_bill_ranap_detail_pelayanan_los_list->DbMasterFilter <> "" && $vw_bill_ranap_detail_pelayanan_los->getCurrentMasterTable() == "vw_bill_ranap") {
	if ($vw_bill_ranap_detail_pelayanan_los_list->MasterRecordExists) {
?>
<?php include_once "vw_bill_ranapmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $vw_bill_ranap_detail_pelayanan_los_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bill_ranap_detail_pelayanan_los_list->TotalRecs <= 0)
			$vw_bill_ranap_detail_pelayanan_los_list->TotalRecs = $vw_bill_ranap_detail_pelayanan_los->SelectRecordCount();
	} else {
		if (!$vw_bill_ranap_detail_pelayanan_los_list->Recordset && ($vw_bill_ranap_detail_pelayanan_los_list->Recordset = $vw_bill_ranap_detail_pelayanan_los_list->LoadRecordset()))
			$vw_bill_ranap_detail_pelayanan_los_list->TotalRecs = $vw_bill_ranap_detail_pelayanan_los_list->Recordset->RecordCount();
	}
	$vw_bill_ranap_detail_pelayanan_los_list->StartRec = 1;
	if ($vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs <= 0 || ($vw_bill_ranap_detail_pelayanan_los->Export <> "" && $vw_bill_ranap_detail_pelayanan_los->ExportAll)) // Display all records
		$vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs = $vw_bill_ranap_detail_pelayanan_los_list->TotalRecs;
	if (!($vw_bill_ranap_detail_pelayanan_los->Export <> "" && $vw_bill_ranap_detail_pelayanan_los->ExportAll))
		$vw_bill_ranap_detail_pelayanan_los_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_bill_ranap_detail_pelayanan_los_list->Recordset = $vw_bill_ranap_detail_pelayanan_los_list->LoadRecordset($vw_bill_ranap_detail_pelayanan_los_list->StartRec-1, $vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs);

	// Set no record found message
	if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "" && $vw_bill_ranap_detail_pelayanan_los_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bill_ranap_detail_pelayanan_los_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_bill_ranap_detail_pelayanan_los_list->SearchWhere == "0=101")
			$vw_bill_ranap_detail_pelayanan_los_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bill_ranap_detail_pelayanan_los_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($vw_bill_ranap_detail_pelayanan_los_list->AuditTrailOnSearch && $vw_bill_ranap_detail_pelayanan_los_list->Command == "search" && !$vw_bill_ranap_detail_pelayanan_los_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $vw_bill_ranap_detail_pelayanan_los_list->getSessionWhere();
		$vw_bill_ranap_detail_pelayanan_los_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$vw_bill_ranap_detail_pelayanan_los_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->Export == "" && $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "") { ?>
<form name="fvw_bill_ranap_detail_pelayanan_loslistsrch" id="fvw_bill_ranap_detail_pelayanan_loslistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($vw_bill_ranap_detail_pelayanan_los_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fvw_bill_ranap_detail_pelayanan_loslistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vw_bill_ranap_detail_pelayanan_los">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_pelayanan_los_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $vw_bill_ranap_detail_pelayanan_los_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($vw_bill_ranap_detail_pelayanan_los_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($vw_bill_ranap_detail_pelayanan_los_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($vw_bill_ranap_detail_pelayanan_los_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($vw_bill_ranap_detail_pelayanan_los_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $vw_bill_ranap_detail_pelayanan_los_list->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_pelayanan_los_list->ShowMessage();
?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->TotalRecs > 0 || $vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bill_ranap_detail_pelayanan_los">
<form name="fvw_bill_ranap_detail_pelayanan_loslist" id="fvw_bill_ranap_detail_pelayanan_loslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bill_ranap_detail_pelayanan_los">
<?php if ($vw_bill_ranap_detail_pelayanan_los->getCurrentMasterTable() == "vw_bill_ranap" && $vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="vw_bill_ranap">
<input type="hidden" name="fk_id_admission" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->id_admission->getSessionValue() ?>">
<input type="hidden" name="fk_nomr" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->nomr->getSessionValue() ?>">
<input type="hidden" name="fk_statusbayar" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->statusbayar->getSessionValue() ?>">
<input type="hidden" name="fk_KELASPERAWATAN_ID" value="<?php echo $vw_bill_ranap_detail_pelayanan_los->kelas->getSessionValue() ?>">
<?php } ?>
<div id="gmp_vw_bill_ranap_detail_pelayanan_los" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->TotalRecs > 0 || $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_bill_ranap_detail_pelayanan_loslist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap_detail_pelayanan_los->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bill_ranap_detail_pelayanan_los_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bill_ranap_detail_pelayanan_los_list->RenderListOptions();

// Render list options (header, left)
$vw_bill_ranap_detail_pelayanan_los_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->Visible) { // kode_tindakan ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->kode_tindakan) == "") { ?>
		<th data-name="kode_tindakan"><div id="elh_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="vw_bill_ranap_detail_pelayanan_los_kode_tindakan"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_tindakan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->kode_tindakan) ?>',2);"><div id="elh_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->tarif->Visible) { // tarif ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->tarif) == "") { ?>
		<th data-name="tarif"><div id="elh_vw_bill_ranap_detail_pelayanan_los_tarif" class="vw_bill_ranap_detail_pelayanan_los_tarif"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tarif"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->tarif) ?>',2);"><div id="elh_vw_bill_ranap_detail_pelayanan_los_tarif" class="vw_bill_ranap_detail_pelayanan_los_tarif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->tarif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->tarif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->qty->Visible) { // qty ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->qty) == "") { ?>
		<th data-name="qty"><div id="elh_vw_bill_ranap_detail_pelayanan_los_qty" class="vw_bill_ranap_detail_pelayanan_los_qty"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->qty->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qty"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->qty) ?>',2);"><div id="elh_vw_bill_ranap_detail_pelayanan_los_qty" class="vw_bill_ranap_detail_pelayanan_los_qty">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->qty->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->qty->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->qty->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->user->Visible) { // user ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->user) == "") { ?>
		<th data-name="user"><div id="elh_vw_bill_ranap_detail_pelayanan_los_user" class="vw_bill_ranap_detail_pelayanan_los_user"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->user->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->user) ?>',2);"><div id="elh_vw_bill_ranap_detail_pelayanan_los_user" class="vw_bill_ranap_detail_pelayanan_los_user">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->user->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->user->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->user->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_pelayanan_los->no_ruang->Visible) { // no_ruang ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->no_ruang) == "") { ?>
		<th data-name="no_ruang"><div id="elh_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="vw_bill_ranap_detail_pelayanan_los_no_ruang"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_ruang"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_pelayanan_los->SortUrl($vw_bill_ranap_detail_pelayanan_los->no_ruang) ?>',2);"><div id="elh_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="vw_bill_ranap_detail_pelayanan_los_no_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_pelayanan_los->no_ruang->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_pelayanan_los->no_ruang->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bill_ranap_detail_pelayanan_los_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_bill_ranap_detail_pelayanan_los->ExportAll && $vw_bill_ranap_detail_pelayanan_los->Export <> "") {
	$vw_bill_ranap_detail_pelayanan_los_list->StopRec = $vw_bill_ranap_detail_pelayanan_los_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_bill_ranap_detail_pelayanan_los_list->TotalRecs > $vw_bill_ranap_detail_pelayanan_los_list->StartRec + $vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs - 1)
		$vw_bill_ranap_detail_pelayanan_los_list->StopRec = $vw_bill_ranap_detail_pelayanan_los_list->StartRec + $vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs - 1;
	else
		$vw_bill_ranap_detail_pelayanan_los_list->StopRec = $vw_bill_ranap_detail_pelayanan_los_list->TotalRecs;
}
$vw_bill_ranap_detail_pelayanan_los_list->RecCnt = $vw_bill_ranap_detail_pelayanan_los_list->StartRec - 1;
if ($vw_bill_ranap_detail_pelayanan_los_list->Recordset && !$vw_bill_ranap_detail_pelayanan_los_list->Recordset->EOF) {
	$vw_bill_ranap_detail_pelayanan_los_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_bill_ranap_detail_pelayanan_los_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_bill_ranap_detail_pelayanan_los_list->StartRec > 1)
		$vw_bill_ranap_detail_pelayanan_los_list->Recordset->Move($vw_bill_ranap_detail_pelayanan_los_list->StartRec - 1);
} elseif (!$vw_bill_ranap_detail_pelayanan_los->AllowAddDeleteRow && $vw_bill_ranap_detail_pelayanan_los_list->StopRec == 0) {
	$vw_bill_ranap_detail_pelayanan_los_list->StopRec = $vw_bill_ranap_detail_pelayanan_los->GridAddRowCount;
}

// Initialize aggregate
$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bill_ranap_detail_pelayanan_los->ResetAttrs();
$vw_bill_ranap_detail_pelayanan_los_list->RenderRow();
while ($vw_bill_ranap_detail_pelayanan_los_list->RecCnt < $vw_bill_ranap_detail_pelayanan_los_list->StopRec) {
	$vw_bill_ranap_detail_pelayanan_los_list->RecCnt++;
	if (intval($vw_bill_ranap_detail_pelayanan_los_list->RecCnt) >= intval($vw_bill_ranap_detail_pelayanan_los_list->StartRec)) {
		$vw_bill_ranap_detail_pelayanan_los_list->RowCnt++;

		// Set up key count
		$vw_bill_ranap_detail_pelayanan_los_list->KeyCount = $vw_bill_ranap_detail_pelayanan_los_list->RowIndex;

		// Init row class and style
		$vw_bill_ranap_detail_pelayanan_los->ResetAttrs();
		$vw_bill_ranap_detail_pelayanan_los->CssClass = "";
		if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "gridadd") {
		} else {
			$vw_bill_ranap_detail_pelayanan_los_list->LoadRowValues($vw_bill_ranap_detail_pelayanan_los_list->Recordset); // Load row values
		}
		$vw_bill_ranap_detail_pelayanan_los->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vw_bill_ranap_detail_pelayanan_los->RowAttrs = array_merge($vw_bill_ranap_detail_pelayanan_los->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_pelayanan_los_list->RowCnt, 'id'=>'r' . $vw_bill_ranap_detail_pelayanan_los_list->RowCnt . '_vw_bill_ranap_detail_pelayanan_los', 'data-rowtype'=>$vw_bill_ranap_detail_pelayanan_los->RowType));

		// Render row
		$vw_bill_ranap_detail_pelayanan_los_list->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_pelayanan_los_list->RenderListOptions();
?>
	<tr<?php echo $vw_bill_ranap_detail_pelayanan_los->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_pelayanan_los_list->ListOptions->Render("body", "left", $vw_bill_ranap_detail_pelayanan_los_list->RowCnt);
?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan"<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_list->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_kode_tindakan" class="vw_bill_ranap_detail_pelayanan_los_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->kode_tindakan->ListViewValue() ?></span>
</span>
<a id="<?php echo $vw_bill_ranap_detail_pelayanan_los_list->PageObjName . "_row_" . $vw_bill_ranap_detail_pelayanan_los_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->tarif->Visible) { // tarif ?>
		<td data-name="tarif"<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_list->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_tarif" class="vw_bill_ranap_detail_pelayanan_los_tarif">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->tarif->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->qty->Visible) { // qty ?>
		<td data-name="qty"<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_list->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_qty" class="vw_bill_ranap_detail_pelayanan_los_qty">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->qty->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->user->Visible) { // user ?>
		<td data-name="user"<?php echo $vw_bill_ranap_detail_pelayanan_los->user->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_list->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_user" class="vw_bill_ranap_detail_pelayanan_los_user">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->user->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->user->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_pelayanan_los->no_ruang->Visible) { // no_ruang ?>
		<td data-name="no_ruang"<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_pelayanan_los_list->RowCnt ?>_vw_bill_ranap_detail_pelayanan_los_no_ruang" class="vw_bill_ranap_detail_pelayanan_los_no_ruang">
<span<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_pelayanan_los->no_ruang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_pelayanan_los_list->ListOptions->Render("body", "right", $vw_bill_ranap_detail_pelayanan_los_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "gridadd")
		$vw_bill_ranap_detail_pelayanan_los_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_bill_ranap_detail_pelayanan_los_list->Recordset)
	$vw_bill_ranap_detail_pelayanan_los_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "gridadd" && $vw_bill_ranap_detail_pelayanan_los->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_bill_ranap_detail_pelayanan_los_list->Pager)) $vw_bill_ranap_detail_pelayanan_los_list->Pager = new cPrevNextPager($vw_bill_ranap_detail_pelayanan_los_list->StartRec, $vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs, $vw_bill_ranap_detail_pelayanan_los_list->TotalRecs) ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->Pager->RecordCount > 0 && $vw_bill_ranap_detail_pelayanan_los_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_bill_ranap_detail_pelayanan_los_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_bill_ranap_detail_pelayanan_los_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_bill_ranap_detail_pelayanan_los_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_bill_ranap_detail_pelayanan_los_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_bill_ranap_detail_pelayanan_los_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_bill_ranap_detail_pelayanan_los_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_bill_ranap_detail_pelayanan_los_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_bill_ranap_detail_pelayanan_los_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_bill_ranap_detail_pelayanan_los_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_bill_ranap_detail_pelayanan_los_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_bill_ranap_detail_pelayanan_los">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_bill_ranap_detail_pelayanan_los_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_pelayanan_los_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_pelayanan_los_list->TotalRecs == 0 && $vw_bill_ranap_detail_pelayanan_los->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_pelayanan_los_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_bill_ranap_detail_pelayanan_loslistsrch.FilterList = <?php echo $vw_bill_ranap_detail_pelayanan_los_list->GetFilterList() ?>;
fvw_bill_ranap_detail_pelayanan_loslistsrch.Init();
fvw_bill_ranap_detail_pelayanan_loslist.Init();
</script>
<?php
$vw_bill_ranap_detail_pelayanan_los_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bill_ranap_detail_pelayanan_los_list->Page_Terminate();
?>
