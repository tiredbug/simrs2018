<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "tbantrianpoliinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$tbantrianpoli_list = NULL; // Initialize page object first

class ctbantrianpoli_list extends ctbantrianpoli {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'tbantrianpoli';

	// Page object name
	var $PageObjName = 'tbantrianpoli_list';

	// Grid form hidden field names
	var $FormName = 'ftbantrianpolilist';
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

		// Table object (tbantrianpoli)
		if (!isset($GLOBALS["tbantrianpoli"]) || get_class($GLOBALS["tbantrianpoli"]) == "ctbantrianpoli") {
			$GLOBALS["tbantrianpoli"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tbantrianpoli"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tbantrianpoliadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tbantrianpolidelete.php";
		$this->MultiUpdateUrl = "tbantrianpoliupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tbantrianpoli', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ftbantrianpolilistsrch";

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
		$this->NO->SetVisibility();
		$this->Klinik->SetVisibility();
		$this->DOKTER->SetVisibility();
		$this->No_Pasien->SetVisibility();
		$this->Nama->SetVisibility();
		$this->Alamat->SetVisibility();
		$this->Tanggal->SetVisibility();
		$this->Masuk->SetVisibility();
		$this->Lewati->SetVisibility();
		$this->RMOK->SetVisibility();
		$this->CETAK->SetVisibility();
		$this->NOANTRI->SetVisibility();

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
		global $EW_EXPORT, $tbantrianpoli;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tbantrianpoli);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "ftbantrianpolilistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->NO->AdvancedSearch->ToJSON(), ","); // Field NO
		$sFilterList = ew_Concat($sFilterList, $this->Klinik->AdvancedSearch->ToJSON(), ","); // Field Klinik
		$sFilterList = ew_Concat($sFilterList, $this->DOKTER->AdvancedSearch->ToJSON(), ","); // Field DOKTER
		$sFilterList = ew_Concat($sFilterList, $this->No_Pasien->AdvancedSearch->ToJSON(), ","); // Field No_Pasien
		$sFilterList = ew_Concat($sFilterList, $this->Nama->AdvancedSearch->ToJSON(), ","); // Field Nama
		$sFilterList = ew_Concat($sFilterList, $this->Alamat->AdvancedSearch->ToJSON(), ","); // Field Alamat
		$sFilterList = ew_Concat($sFilterList, $this->Tanggal->AdvancedSearch->ToJSON(), ","); // Field Tanggal
		$sFilterList = ew_Concat($sFilterList, $this->Masuk->AdvancedSearch->ToJSON(), ","); // Field Masuk
		$sFilterList = ew_Concat($sFilterList, $this->Lewati->AdvancedSearch->ToJSON(), ","); // Field Lewati
		$sFilterList = ew_Concat($sFilterList, $this->RMOK->AdvancedSearch->ToJSON(), ","); // Field RMOK
		$sFilterList = ew_Concat($sFilterList, $this->CETAK->AdvancedSearch->ToJSON(), ","); // Field CETAK
		$sFilterList = ew_Concat($sFilterList, $this->NOANTRI->AdvancedSearch->ToJSON(), ","); // Field NOANTRI
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "ftbantrianpolilistsrch", $filters);

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

		// Field NO
		$this->NO->AdvancedSearch->SearchValue = @$filter["x_NO"];
		$this->NO->AdvancedSearch->SearchOperator = @$filter["z_NO"];
		$this->NO->AdvancedSearch->SearchCondition = @$filter["v_NO"];
		$this->NO->AdvancedSearch->SearchValue2 = @$filter["y_NO"];
		$this->NO->AdvancedSearch->SearchOperator2 = @$filter["w_NO"];
		$this->NO->AdvancedSearch->Save();

		// Field Klinik
		$this->Klinik->AdvancedSearch->SearchValue = @$filter["x_Klinik"];
		$this->Klinik->AdvancedSearch->SearchOperator = @$filter["z_Klinik"];
		$this->Klinik->AdvancedSearch->SearchCondition = @$filter["v_Klinik"];
		$this->Klinik->AdvancedSearch->SearchValue2 = @$filter["y_Klinik"];
		$this->Klinik->AdvancedSearch->SearchOperator2 = @$filter["w_Klinik"];
		$this->Klinik->AdvancedSearch->Save();

		// Field DOKTER
		$this->DOKTER->AdvancedSearch->SearchValue = @$filter["x_DOKTER"];
		$this->DOKTER->AdvancedSearch->SearchOperator = @$filter["z_DOKTER"];
		$this->DOKTER->AdvancedSearch->SearchCondition = @$filter["v_DOKTER"];
		$this->DOKTER->AdvancedSearch->SearchValue2 = @$filter["y_DOKTER"];
		$this->DOKTER->AdvancedSearch->SearchOperator2 = @$filter["w_DOKTER"];
		$this->DOKTER->AdvancedSearch->Save();

		// Field No_Pasien
		$this->No_Pasien->AdvancedSearch->SearchValue = @$filter["x_No_Pasien"];
		$this->No_Pasien->AdvancedSearch->SearchOperator = @$filter["z_No_Pasien"];
		$this->No_Pasien->AdvancedSearch->SearchCondition = @$filter["v_No_Pasien"];
		$this->No_Pasien->AdvancedSearch->SearchValue2 = @$filter["y_No_Pasien"];
		$this->No_Pasien->AdvancedSearch->SearchOperator2 = @$filter["w_No_Pasien"];
		$this->No_Pasien->AdvancedSearch->Save();

		// Field Nama
		$this->Nama->AdvancedSearch->SearchValue = @$filter["x_Nama"];
		$this->Nama->AdvancedSearch->SearchOperator = @$filter["z_Nama"];
		$this->Nama->AdvancedSearch->SearchCondition = @$filter["v_Nama"];
		$this->Nama->AdvancedSearch->SearchValue2 = @$filter["y_Nama"];
		$this->Nama->AdvancedSearch->SearchOperator2 = @$filter["w_Nama"];
		$this->Nama->AdvancedSearch->Save();

		// Field Alamat
		$this->Alamat->AdvancedSearch->SearchValue = @$filter["x_Alamat"];
		$this->Alamat->AdvancedSearch->SearchOperator = @$filter["z_Alamat"];
		$this->Alamat->AdvancedSearch->SearchCondition = @$filter["v_Alamat"];
		$this->Alamat->AdvancedSearch->SearchValue2 = @$filter["y_Alamat"];
		$this->Alamat->AdvancedSearch->SearchOperator2 = @$filter["w_Alamat"];
		$this->Alamat->AdvancedSearch->Save();

		// Field Tanggal
		$this->Tanggal->AdvancedSearch->SearchValue = @$filter["x_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchOperator = @$filter["z_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchCondition = @$filter["v_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchValue2 = @$filter["y_Tanggal"];
		$this->Tanggal->AdvancedSearch->SearchOperator2 = @$filter["w_Tanggal"];
		$this->Tanggal->AdvancedSearch->Save();

		// Field Masuk
		$this->Masuk->AdvancedSearch->SearchValue = @$filter["x_Masuk"];
		$this->Masuk->AdvancedSearch->SearchOperator = @$filter["z_Masuk"];
		$this->Masuk->AdvancedSearch->SearchCondition = @$filter["v_Masuk"];
		$this->Masuk->AdvancedSearch->SearchValue2 = @$filter["y_Masuk"];
		$this->Masuk->AdvancedSearch->SearchOperator2 = @$filter["w_Masuk"];
		$this->Masuk->AdvancedSearch->Save();

		// Field Lewati
		$this->Lewati->AdvancedSearch->SearchValue = @$filter["x_Lewati"];
		$this->Lewati->AdvancedSearch->SearchOperator = @$filter["z_Lewati"];
		$this->Lewati->AdvancedSearch->SearchCondition = @$filter["v_Lewati"];
		$this->Lewati->AdvancedSearch->SearchValue2 = @$filter["y_Lewati"];
		$this->Lewati->AdvancedSearch->SearchOperator2 = @$filter["w_Lewati"];
		$this->Lewati->AdvancedSearch->Save();

		// Field RMOK
		$this->RMOK->AdvancedSearch->SearchValue = @$filter["x_RMOK"];
		$this->RMOK->AdvancedSearch->SearchOperator = @$filter["z_RMOK"];
		$this->RMOK->AdvancedSearch->SearchCondition = @$filter["v_RMOK"];
		$this->RMOK->AdvancedSearch->SearchValue2 = @$filter["y_RMOK"];
		$this->RMOK->AdvancedSearch->SearchOperator2 = @$filter["w_RMOK"];
		$this->RMOK->AdvancedSearch->Save();

		// Field CETAK
		$this->CETAK->AdvancedSearch->SearchValue = @$filter["x_CETAK"];
		$this->CETAK->AdvancedSearch->SearchOperator = @$filter["z_CETAK"];
		$this->CETAK->AdvancedSearch->SearchCondition = @$filter["v_CETAK"];
		$this->CETAK->AdvancedSearch->SearchValue2 = @$filter["y_CETAK"];
		$this->CETAK->AdvancedSearch->SearchOperator2 = @$filter["w_CETAK"];
		$this->CETAK->AdvancedSearch->Save();

		// Field NOANTRI
		$this->NOANTRI->AdvancedSearch->SearchValue = @$filter["x_NOANTRI"];
		$this->NOANTRI->AdvancedSearch->SearchOperator = @$filter["z_NOANTRI"];
		$this->NOANTRI->AdvancedSearch->SearchCondition = @$filter["v_NOANTRI"];
		$this->NOANTRI->AdvancedSearch->SearchValue2 = @$filter["y_NOANTRI"];
		$this->NOANTRI->AdvancedSearch->SearchOperator2 = @$filter["w_NOANTRI"];
		$this->NOANTRI->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->NO, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Klinik, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->DOKTER, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->No_Pasien, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Masuk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Lewati, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->RMOK, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->CETAK, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NOANTRI, $arKeywords, $type);
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
			$this->UpdateSort($this->NO, $bCtrl); // NO
			$this->UpdateSort($this->Klinik, $bCtrl); // Klinik
			$this->UpdateSort($this->DOKTER, $bCtrl); // DOKTER
			$this->UpdateSort($this->No_Pasien, $bCtrl); // No_Pasien
			$this->UpdateSort($this->Nama, $bCtrl); // Nama
			$this->UpdateSort($this->Alamat, $bCtrl); // Alamat
			$this->UpdateSort($this->Tanggal, $bCtrl); // Tanggal
			$this->UpdateSort($this->Masuk, $bCtrl); // Masuk
			$this->UpdateSort($this->Lewati, $bCtrl); // Lewati
			$this->UpdateSort($this->RMOK, $bCtrl); // RMOK
			$this->UpdateSort($this->CETAK, $bCtrl); // CETAK
			$this->UpdateSort($this->NOANTRI, $bCtrl); // NOANTRI
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
				$this->NO->setSort("");
				$this->Klinik->setSort("");
				$this->DOKTER->setSort("");
				$this->No_Pasien->setSort("");
				$this->Nama->setSort("");
				$this->Alamat->setSort("");
				$this->Tanggal->setSort("");
				$this->Masuk->setSort("");
				$this->Lewati->setSort("");
				$this->RMOK->setSort("");
				$this->CETAK->setSort("");
				$this->NOANTRI->setSort("");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftbantrianpolilistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftbantrianpolilistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftbantrianpolilist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ftbantrianpolilistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->NO->setDbValue($rs->fields('NO'));
		$this->Klinik->setDbValue($rs->fields('Klinik'));
		$this->DOKTER->setDbValue($rs->fields('DOKTER'));
		$this->No_Pasien->setDbValue($rs->fields('No_Pasien'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Tanggal->setDbValue($rs->fields('Tanggal'));
		$this->Masuk->setDbValue($rs->fields('Masuk'));
		$this->Lewati->setDbValue($rs->fields('Lewati'));
		$this->RMOK->setDbValue($rs->fields('RMOK'));
		$this->CETAK->setDbValue($rs->fields('CETAK'));
		$this->NOANTRI->setDbValue($rs->fields('NOANTRI'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NO->DbValue = $row['NO'];
		$this->Klinik->DbValue = $row['Klinik'];
		$this->DOKTER->DbValue = $row['DOKTER'];
		$this->No_Pasien->DbValue = $row['No_Pasien'];
		$this->Nama->DbValue = $row['Nama'];
		$this->Alamat->DbValue = $row['Alamat'];
		$this->Tanggal->DbValue = $row['Tanggal'];
		$this->Masuk->DbValue = $row['Masuk'];
		$this->Lewati->DbValue = $row['Lewati'];
		$this->RMOK->DbValue = $row['RMOK'];
		$this->CETAK->DbValue = $row['CETAK'];
		$this->NOANTRI->DbValue = $row['NOANTRI'];
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
		// NO
		// Klinik
		// DOKTER
		// No_Pasien
		// Nama
		// Alamat
		// Tanggal
		// Masuk
		// Lewati
		// RMOK
		// CETAK
		// NOANTRI

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NO
		$this->NO->ViewValue = $this->NO->CurrentValue;
		$this->NO->ViewCustomAttributes = "";

		// Klinik
		$this->Klinik->ViewValue = $this->Klinik->CurrentValue;
		$this->Klinik->ViewCustomAttributes = "";

		// DOKTER
		$this->DOKTER->ViewValue = $this->DOKTER->CurrentValue;
		$this->DOKTER->ViewCustomAttributes = "";

		// No_Pasien
		$this->No_Pasien->ViewValue = $this->No_Pasien->CurrentValue;
		$this->No_Pasien->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 0);
		$this->Tanggal->ViewCustomAttributes = "";

		// Masuk
		$this->Masuk->ViewValue = $this->Masuk->CurrentValue;
		$this->Masuk->ViewCustomAttributes = "";

		// Lewati
		$this->Lewati->ViewValue = $this->Lewati->CurrentValue;
		$this->Lewati->ViewCustomAttributes = "";

		// RMOK
		$this->RMOK->ViewValue = $this->RMOK->CurrentValue;
		$this->RMOK->ViewCustomAttributes = "";

		// CETAK
		$this->CETAK->ViewValue = $this->CETAK->CurrentValue;
		$this->CETAK->ViewCustomAttributes = "";

		// NOANTRI
		$this->NOANTRI->ViewValue = $this->NOANTRI->CurrentValue;
		$this->NOANTRI->ViewCustomAttributes = "";

			// NO
			$this->NO->LinkCustomAttributes = "";
			$this->NO->HrefValue = "";
			$this->NO->TooltipValue = "";

			// Klinik
			$this->Klinik->LinkCustomAttributes = "";
			$this->Klinik->HrefValue = "";
			$this->Klinik->TooltipValue = "";

			// DOKTER
			$this->DOKTER->LinkCustomAttributes = "";
			$this->DOKTER->HrefValue = "";
			$this->DOKTER->TooltipValue = "";

			// No_Pasien
			$this->No_Pasien->LinkCustomAttributes = "";
			$this->No_Pasien->HrefValue = "";
			$this->No_Pasien->TooltipValue = "";

			// Nama
			$this->Nama->LinkCustomAttributes = "";
			$this->Nama->HrefValue = "";
			$this->Nama->TooltipValue = "";

			// Alamat
			$this->Alamat->LinkCustomAttributes = "";
			$this->Alamat->HrefValue = "";
			$this->Alamat->TooltipValue = "";

			// Tanggal
			$this->Tanggal->LinkCustomAttributes = "";
			$this->Tanggal->HrefValue = "";
			$this->Tanggal->TooltipValue = "";

			// Masuk
			$this->Masuk->LinkCustomAttributes = "";
			$this->Masuk->HrefValue = "";
			$this->Masuk->TooltipValue = "";

			// Lewati
			$this->Lewati->LinkCustomAttributes = "";
			$this->Lewati->HrefValue = "";
			$this->Lewati->TooltipValue = "";

			// RMOK
			$this->RMOK->LinkCustomAttributes = "";
			$this->RMOK->HrefValue = "";
			$this->RMOK->TooltipValue = "";

			// CETAK
			$this->CETAK->LinkCustomAttributes = "";
			$this->CETAK->HrefValue = "";
			$this->CETAK->TooltipValue = "";

			// NOANTRI
			$this->NOANTRI->LinkCustomAttributes = "";
			$this->NOANTRI->HrefValue = "";
			$this->NOANTRI->TooltipValue = "";
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

			$r = Security()->CurrentUserLevelID();
		if($r==4)
		{
			$header = "<div class=\"alert alert-warning ewAlert\">Modul ini Masih Dalam Pengembangan</div>";
		}
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
if (!isset($tbantrianpoli_list)) $tbantrianpoli_list = new ctbantrianpoli_list();

// Page init
$tbantrianpoli_list->Page_Init();

// Page main
$tbantrianpoli_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tbantrianpoli_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftbantrianpolilist = new ew_Form("ftbantrianpolilist", "list");
ftbantrianpolilist.FormKeyCountName = '<?php echo $tbantrianpoli_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftbantrianpolilist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftbantrianpolilist.ValidateRequired = true;
<?php } else { ?>
ftbantrianpolilist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = ftbantrianpolilistsrch = new ew_Form("ftbantrianpolilistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($tbantrianpoli_list->TotalRecs > 0 && $tbantrianpoli_list->ExportOptions->Visible()) { ?>
<?php $tbantrianpoli_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($tbantrianpoli_list->SearchOptions->Visible()) { ?>
<?php $tbantrianpoli_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($tbantrianpoli_list->FilterOptions->Visible()) { ?>
<?php $tbantrianpoli_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $tbantrianpoli_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tbantrianpoli_list->TotalRecs <= 0)
			$tbantrianpoli_list->TotalRecs = $tbantrianpoli->SelectRecordCount();
	} else {
		if (!$tbantrianpoli_list->Recordset && ($tbantrianpoli_list->Recordset = $tbantrianpoli_list->LoadRecordset()))
			$tbantrianpoli_list->TotalRecs = $tbantrianpoli_list->Recordset->RecordCount();
	}
	$tbantrianpoli_list->StartRec = 1;
	if ($tbantrianpoli_list->DisplayRecs <= 0 || ($tbantrianpoli->Export <> "" && $tbantrianpoli->ExportAll)) // Display all records
		$tbantrianpoli_list->DisplayRecs = $tbantrianpoli_list->TotalRecs;
	if (!($tbantrianpoli->Export <> "" && $tbantrianpoli->ExportAll))
		$tbantrianpoli_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tbantrianpoli_list->Recordset = $tbantrianpoli_list->LoadRecordset($tbantrianpoli_list->StartRec-1, $tbantrianpoli_list->DisplayRecs);

	// Set no record found message
	if ($tbantrianpoli->CurrentAction == "" && $tbantrianpoli_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$tbantrianpoli_list->setWarningMessage(ew_DeniedMsg());
		if ($tbantrianpoli_list->SearchWhere == "0=101")
			$tbantrianpoli_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tbantrianpoli_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$tbantrianpoli_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($tbantrianpoli->Export == "" && $tbantrianpoli->CurrentAction == "") { ?>
<form name="ftbantrianpolilistsrch" id="ftbantrianpolilistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($tbantrianpoli_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ftbantrianpolilistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tbantrianpoli">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($tbantrianpoli_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($tbantrianpoli_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $tbantrianpoli_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($tbantrianpoli_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($tbantrianpoli_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($tbantrianpoli_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($tbantrianpoli_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $tbantrianpoli_list->ShowPageHeader(); ?>
<?php
$tbantrianpoli_list->ShowMessage();
?>
<?php if ($tbantrianpoli_list->TotalRecs > 0 || $tbantrianpoli->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid tbantrianpoli">
<form name="ftbantrianpolilist" id="ftbantrianpolilist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tbantrianpoli_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tbantrianpoli_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tbantrianpoli">
<div id="gmp_tbantrianpoli" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($tbantrianpoli_list->TotalRecs > 0 || $tbantrianpoli->CurrentAction == "gridedit") { ?>
<table id="tbl_tbantrianpolilist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $tbantrianpoli->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$tbantrianpoli_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tbantrianpoli_list->RenderListOptions();

// Render list options (header, left)
$tbantrianpoli_list->ListOptions->Render("header", "left");
?>
<?php if ($tbantrianpoli->NO->Visible) { // NO ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->NO) == "") { ?>
		<th data-name="NO"><div id="elh_tbantrianpoli_NO" class="tbantrianpoli_NO"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->NO->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NO"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->NO) ?>',2);"><div id="elh_tbantrianpoli_NO" class="tbantrianpoli_NO">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->NO->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->NO->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->NO->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->Klinik->Visible) { // Klinik ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->Klinik) == "") { ?>
		<th data-name="Klinik"><div id="elh_tbantrianpoli_Klinik" class="tbantrianpoli_Klinik"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Klinik->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Klinik"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->Klinik) ?>',2);"><div id="elh_tbantrianpoli_Klinik" class="tbantrianpoli_Klinik">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Klinik->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->Klinik->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->Klinik->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->DOKTER->Visible) { // DOKTER ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->DOKTER) == "") { ?>
		<th data-name="DOKTER"><div id="elh_tbantrianpoli_DOKTER" class="tbantrianpoli_DOKTER"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->DOKTER->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DOKTER"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->DOKTER) ?>',2);"><div id="elh_tbantrianpoli_DOKTER" class="tbantrianpoli_DOKTER">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->DOKTER->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->DOKTER->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->DOKTER->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->No_Pasien->Visible) { // No_Pasien ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->No_Pasien) == "") { ?>
		<th data-name="No_Pasien"><div id="elh_tbantrianpoli_No_Pasien" class="tbantrianpoli_No_Pasien"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->No_Pasien->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="No_Pasien"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->No_Pasien) ?>',2);"><div id="elh_tbantrianpoli_No_Pasien" class="tbantrianpoli_No_Pasien">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->No_Pasien->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->No_Pasien->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->No_Pasien->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->Nama->Visible) { // Nama ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->Nama) == "") { ?>
		<th data-name="Nama"><div id="elh_tbantrianpoli_Nama" class="tbantrianpoli_Nama"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Nama->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nama"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->Nama) ?>',2);"><div id="elh_tbantrianpoli_Nama" class="tbantrianpoli_Nama">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Nama->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->Nama->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->Nama->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->Alamat->Visible) { // Alamat ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->Alamat) == "") { ?>
		<th data-name="Alamat"><div id="elh_tbantrianpoli_Alamat" class="tbantrianpoli_Alamat"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Alamat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Alamat"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->Alamat) ?>',2);"><div id="elh_tbantrianpoli_Alamat" class="tbantrianpoli_Alamat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Alamat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->Alamat->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->Alamat->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->Tanggal->Visible) { // Tanggal ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->Tanggal) == "") { ?>
		<th data-name="Tanggal"><div id="elh_tbantrianpoli_Tanggal" class="tbantrianpoli_Tanggal"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Tanggal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->Tanggal) ?>',2);"><div id="elh_tbantrianpoli_Tanggal" class="tbantrianpoli_Tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->Tanggal->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->Tanggal->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->Masuk->Visible) { // Masuk ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->Masuk) == "") { ?>
		<th data-name="Masuk"><div id="elh_tbantrianpoli_Masuk" class="tbantrianpoli_Masuk"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Masuk->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Masuk"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->Masuk) ?>',2);"><div id="elh_tbantrianpoli_Masuk" class="tbantrianpoli_Masuk">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Masuk->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->Masuk->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->Masuk->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->Lewati->Visible) { // Lewati ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->Lewati) == "") { ?>
		<th data-name="Lewati"><div id="elh_tbantrianpoli_Lewati" class="tbantrianpoli_Lewati"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Lewati->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Lewati"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->Lewati) ?>',2);"><div id="elh_tbantrianpoli_Lewati" class="tbantrianpoli_Lewati">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->Lewati->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->Lewati->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->Lewati->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->RMOK->Visible) { // RMOK ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->RMOK) == "") { ?>
		<th data-name="RMOK"><div id="elh_tbantrianpoli_RMOK" class="tbantrianpoli_RMOK"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->RMOK->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="RMOK"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->RMOK) ?>',2);"><div id="elh_tbantrianpoli_RMOK" class="tbantrianpoli_RMOK">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->RMOK->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->RMOK->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->RMOK->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->CETAK->Visible) { // CETAK ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->CETAK) == "") { ?>
		<th data-name="CETAK"><div id="elh_tbantrianpoli_CETAK" class="tbantrianpoli_CETAK"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->CETAK->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CETAK"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->CETAK) ?>',2);"><div id="elh_tbantrianpoli_CETAK" class="tbantrianpoli_CETAK">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->CETAK->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->CETAK->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->CETAK->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tbantrianpoli->NOANTRI->Visible) { // NOANTRI ?>
	<?php if ($tbantrianpoli->SortUrl($tbantrianpoli->NOANTRI) == "") { ?>
		<th data-name="NOANTRI"><div id="elh_tbantrianpoli_NOANTRI" class="tbantrianpoli_NOANTRI"><div class="ewTableHeaderCaption"><?php echo $tbantrianpoli->NOANTRI->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NOANTRI"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tbantrianpoli->SortUrl($tbantrianpoli->NOANTRI) ?>',2);"><div id="elh_tbantrianpoli_NOANTRI" class="tbantrianpoli_NOANTRI">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tbantrianpoli->NOANTRI->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($tbantrianpoli->NOANTRI->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($tbantrianpoli->NOANTRI->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tbantrianpoli_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tbantrianpoli->ExportAll && $tbantrianpoli->Export <> "") {
	$tbantrianpoli_list->StopRec = $tbantrianpoli_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tbantrianpoli_list->TotalRecs > $tbantrianpoli_list->StartRec + $tbantrianpoli_list->DisplayRecs - 1)
		$tbantrianpoli_list->StopRec = $tbantrianpoli_list->StartRec + $tbantrianpoli_list->DisplayRecs - 1;
	else
		$tbantrianpoli_list->StopRec = $tbantrianpoli_list->TotalRecs;
}
$tbantrianpoli_list->RecCnt = $tbantrianpoli_list->StartRec - 1;
if ($tbantrianpoli_list->Recordset && !$tbantrianpoli_list->Recordset->EOF) {
	$tbantrianpoli_list->Recordset->MoveFirst();
	$bSelectLimit = $tbantrianpoli_list->UseSelectLimit;
	if (!$bSelectLimit && $tbantrianpoli_list->StartRec > 1)
		$tbantrianpoli_list->Recordset->Move($tbantrianpoli_list->StartRec - 1);
} elseif (!$tbantrianpoli->AllowAddDeleteRow && $tbantrianpoli_list->StopRec == 0) {
	$tbantrianpoli_list->StopRec = $tbantrianpoli->GridAddRowCount;
}

// Initialize aggregate
$tbantrianpoli->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tbantrianpoli->ResetAttrs();
$tbantrianpoli_list->RenderRow();
while ($tbantrianpoli_list->RecCnt < $tbantrianpoli_list->StopRec) {
	$tbantrianpoli_list->RecCnt++;
	if (intval($tbantrianpoli_list->RecCnt) >= intval($tbantrianpoli_list->StartRec)) {
		$tbantrianpoli_list->RowCnt++;

		// Set up key count
		$tbantrianpoli_list->KeyCount = $tbantrianpoli_list->RowIndex;

		// Init row class and style
		$tbantrianpoli->ResetAttrs();
		$tbantrianpoli->CssClass = "";
		if ($tbantrianpoli->CurrentAction == "gridadd") {
		} else {
			$tbantrianpoli_list->LoadRowValues($tbantrianpoli_list->Recordset); // Load row values
		}
		$tbantrianpoli->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$tbantrianpoli->RowAttrs = array_merge($tbantrianpoli->RowAttrs, array('data-rowindex'=>$tbantrianpoli_list->RowCnt, 'id'=>'r' . $tbantrianpoli_list->RowCnt . '_tbantrianpoli', 'data-rowtype'=>$tbantrianpoli->RowType));

		// Render row
		$tbantrianpoli_list->RenderRow();

		// Render list options
		$tbantrianpoli_list->RenderListOptions();
?>
	<tr<?php echo $tbantrianpoli->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tbantrianpoli_list->ListOptions->Render("body", "left", $tbantrianpoli_list->RowCnt);
?>
	<?php if ($tbantrianpoli->NO->Visible) { // NO ?>
		<td data-name="NO"<?php echo $tbantrianpoli->NO->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_NO" class="tbantrianpoli_NO">
<span<?php echo $tbantrianpoli->NO->ViewAttributes() ?>>
<?php echo $tbantrianpoli->NO->ListViewValue() ?></span>
</span>
<a id="<?php echo $tbantrianpoli_list->PageObjName . "_row_" . $tbantrianpoli_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($tbantrianpoli->Klinik->Visible) { // Klinik ?>
		<td data-name="Klinik"<?php echo $tbantrianpoli->Klinik->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_Klinik" class="tbantrianpoli_Klinik">
<span<?php echo $tbantrianpoli->Klinik->ViewAttributes() ?>>
<?php echo $tbantrianpoli->Klinik->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->DOKTER->Visible) { // DOKTER ?>
		<td data-name="DOKTER"<?php echo $tbantrianpoli->DOKTER->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_DOKTER" class="tbantrianpoli_DOKTER">
<span<?php echo $tbantrianpoli->DOKTER->ViewAttributes() ?>>
<?php echo $tbantrianpoli->DOKTER->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->No_Pasien->Visible) { // No_Pasien ?>
		<td data-name="No_Pasien"<?php echo $tbantrianpoli->No_Pasien->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_No_Pasien" class="tbantrianpoli_No_Pasien">
<span<?php echo $tbantrianpoli->No_Pasien->ViewAttributes() ?>>
<?php echo $tbantrianpoli->No_Pasien->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->Nama->Visible) { // Nama ?>
		<td data-name="Nama"<?php echo $tbantrianpoli->Nama->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_Nama" class="tbantrianpoli_Nama">
<span<?php echo $tbantrianpoli->Nama->ViewAttributes() ?>>
<?php echo $tbantrianpoli->Nama->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->Alamat->Visible) { // Alamat ?>
		<td data-name="Alamat"<?php echo $tbantrianpoli->Alamat->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_Alamat" class="tbantrianpoli_Alamat">
<span<?php echo $tbantrianpoli->Alamat->ViewAttributes() ?>>
<?php echo $tbantrianpoli->Alamat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->Tanggal->Visible) { // Tanggal ?>
		<td data-name="Tanggal"<?php echo $tbantrianpoli->Tanggal->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_Tanggal" class="tbantrianpoli_Tanggal">
<span<?php echo $tbantrianpoli->Tanggal->ViewAttributes() ?>>
<?php echo $tbantrianpoli->Tanggal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->Masuk->Visible) { // Masuk ?>
		<td data-name="Masuk"<?php echo $tbantrianpoli->Masuk->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_Masuk" class="tbantrianpoli_Masuk">
<span<?php echo $tbantrianpoli->Masuk->ViewAttributes() ?>>
<?php echo $tbantrianpoli->Masuk->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->Lewati->Visible) { // Lewati ?>
		<td data-name="Lewati"<?php echo $tbantrianpoli->Lewati->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_Lewati" class="tbantrianpoli_Lewati">
<span<?php echo $tbantrianpoli->Lewati->ViewAttributes() ?>>
<?php echo $tbantrianpoli->Lewati->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->RMOK->Visible) { // RMOK ?>
		<td data-name="RMOK"<?php echo $tbantrianpoli->RMOK->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_RMOK" class="tbantrianpoli_RMOK">
<span<?php echo $tbantrianpoli->RMOK->ViewAttributes() ?>>
<?php echo $tbantrianpoli->RMOK->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->CETAK->Visible) { // CETAK ?>
		<td data-name="CETAK"<?php echo $tbantrianpoli->CETAK->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_CETAK" class="tbantrianpoli_CETAK">
<span<?php echo $tbantrianpoli->CETAK->ViewAttributes() ?>>
<?php echo $tbantrianpoli->CETAK->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($tbantrianpoli->NOANTRI->Visible) { // NOANTRI ?>
		<td data-name="NOANTRI"<?php echo $tbantrianpoli->NOANTRI->CellAttributes() ?>>
<span id="el<?php echo $tbantrianpoli_list->RowCnt ?>_tbantrianpoli_NOANTRI" class="tbantrianpoli_NOANTRI">
<span<?php echo $tbantrianpoli->NOANTRI->ViewAttributes() ?>>
<?php echo $tbantrianpoli->NOANTRI->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tbantrianpoli_list->ListOptions->Render("body", "right", $tbantrianpoli_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($tbantrianpoli->CurrentAction <> "gridadd")
		$tbantrianpoli_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tbantrianpoli->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tbantrianpoli_list->Recordset)
	$tbantrianpoli_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($tbantrianpoli->CurrentAction <> "gridadd" && $tbantrianpoli->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($tbantrianpoli_list->Pager)) $tbantrianpoli_list->Pager = new cPrevNextPager($tbantrianpoli_list->StartRec, $tbantrianpoli_list->DisplayRecs, $tbantrianpoli_list->TotalRecs) ?>
<?php if ($tbantrianpoli_list->Pager->RecordCount > 0 && $tbantrianpoli_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($tbantrianpoli_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $tbantrianpoli_list->PageUrl() ?>start=<?php echo $tbantrianpoli_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tbantrianpoli_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $tbantrianpoli_list->PageUrl() ?>start=<?php echo $tbantrianpoli_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tbantrianpoli_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($tbantrianpoli_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $tbantrianpoli_list->PageUrl() ?>start=<?php echo $tbantrianpoli_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tbantrianpoli_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $tbantrianpoli_list->PageUrl() ?>start=<?php echo $tbantrianpoli_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tbantrianpoli_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tbantrianpoli_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tbantrianpoli_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tbantrianpoli_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($tbantrianpoli_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $tbantrianpoli_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="tbantrianpoli">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($tbantrianpoli_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($tbantrianpoli_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($tbantrianpoli_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($tbantrianpoli_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($tbantrianpoli_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tbantrianpoli_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($tbantrianpoli_list->TotalRecs == 0 && $tbantrianpoli->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tbantrianpoli_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
ftbantrianpolilistsrch.FilterList = <?php echo $tbantrianpoli_list->GetFilterList() ?>;
ftbantrianpolilistsrch.Init();
ftbantrianpolilist.Init();
</script>
<?php
$tbantrianpoli_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tbantrianpoli_list->Page_Terminate();
?>
