<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_perawatinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_bill_ranapinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bill_ranap_detail_tindakan_perawat_list = NULL; // Initialize page object first

class cvw_bill_ranap_detail_tindakan_perawat_list extends cvw_bill_ranap_detail_tindakan_perawat {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bill_ranap_detail_tindakan_perawat';

	// Page object name
	var $PageObjName = 'vw_bill_ranap_detail_tindakan_perawat_list';

	// Grid form hidden field names
	var $FormName = 'fvw_bill_ranap_detail_tindakan_perawatlist';
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

		// Table object (vw_bill_ranap_detail_tindakan_perawat)
		if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]) || get_class($GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]) == "cvw_bill_ranap_detail_tindakan_perawat") {
			$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_bill_ranap_detail_tindakan_perawatadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_bill_ranap_detail_tindakan_perawatdelete.php";
		$this->MultiUpdateUrl = "vw_bill_ranap_detail_tindakan_perawatupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (vw_bill_ranap)
		if (!isset($GLOBALS['vw_bill_ranap'])) $GLOBALS['vw_bill_ranap'] = new cvw_bill_ranap();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bill_ranap_detail_tindakan_perawat', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_bill_ranap_detail_tindakan_perawatlistsrch";

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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->statusbayar->SetVisibility();
		$this->tanggal->SetVisibility();
		$this->kode_tindakan->SetVisibility();
		$this->qty->SetVisibility();
		$this->tarif->SetVisibility();
		$this->bhp->SetVisibility();
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
		global $EW_EXPORT, $vw_bill_ranap_detail_tindakan_perawat;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bill_ranap_detail_tindakan_perawat);
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->tarif->FormValue = ""; // Clear form value
		$this->bhp->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_statusbayar") && $objForm->HasValue("o_statusbayar") && $this->statusbayar->CurrentValue <> $this->statusbayar->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_tanggal") && $objForm->HasValue("o_tanggal") && $this->tanggal->CurrentValue <> $this->tanggal->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_kode_tindakan") && $objForm->HasValue("o_kode_tindakan") && $this->kode_tindakan->CurrentValue <> $this->kode_tindakan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_qty") && $objForm->HasValue("o_qty") && $this->qty->CurrentValue <> $this->qty->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_tarif") && $objForm->HasValue("o_tarif") && $this->tarif->CurrentValue <> $this->tarif->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_bhp") && $objForm->HasValue("o_bhp") && $this->bhp->CurrentValue <> $this->bhp->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_user") && $objForm->HasValue("o_user") && $this->user->CurrentValue <> $this->user->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_no_ruang") && $objForm->HasValue("o_no_ruang") && $this->no_ruang->CurrentValue <> $this->no_ruang->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_bill_ranap_detail_tindakan_perawatlistsrch") : "";
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
		$sFilterList = ew_Concat($sFilterList, $this->qty->AdvancedSearch->ToJSON(), ","); // Field qty
		$sFilterList = ew_Concat($sFilterList, $this->tarif->AdvancedSearch->ToJSON(), ","); // Field tarif
		$sFilterList = ew_Concat($sFilterList, $this->bhp->AdvancedSearch->ToJSON(), ","); // Field bhp
		$sFilterList = ew_Concat($sFilterList, $this->nama_tindakan->AdvancedSearch->ToJSON(), ","); // Field nama_tindakan
		$sFilterList = ew_Concat($sFilterList, $this->kelompok_tindakan->AdvancedSearch->ToJSON(), ","); // Field kelompok_tindakan
		$sFilterList = ew_Concat($sFilterList, $this->kelompok1->AdvancedSearch->ToJSON(), ","); // Field kelompok1
		$sFilterList = ew_Concat($sFilterList, $this->kelompok2->AdvancedSearch->ToJSON(), ","); // Field kelompok2
		$sFilterList = ew_Concat($sFilterList, $this->user->AdvancedSearch->ToJSON(), ","); // Field user
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_bill_ranap_detail_tindakan_perawatlistsrch", $filters);

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

		// Field qty
		$this->qty->AdvancedSearch->SearchValue = @$filter["x_qty"];
		$this->qty->AdvancedSearch->SearchOperator = @$filter["z_qty"];
		$this->qty->AdvancedSearch->SearchCondition = @$filter["v_qty"];
		$this->qty->AdvancedSearch->SearchValue2 = @$filter["y_qty"];
		$this->qty->AdvancedSearch->SearchOperator2 = @$filter["w_qty"];
		$this->qty->AdvancedSearch->Save();

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

		// Field nama_tindakan
		$this->nama_tindakan->AdvancedSearch->SearchValue = @$filter["x_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchOperator = @$filter["z_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchCondition = @$filter["v_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchValue2 = @$filter["y_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->SearchOperator2 = @$filter["w_nama_tindakan"];
		$this->nama_tindakan->AdvancedSearch->Save();

		// Field kelompok_tindakan
		$this->kelompok_tindakan->AdvancedSearch->SearchValue = @$filter["x_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchOperator = @$filter["z_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchCondition = @$filter["v_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchValue2 = @$filter["y_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->SearchOperator2 = @$filter["w_kelompok_tindakan"];
		$this->kelompok_tindakan->AdvancedSearch->Save();

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

		// Field user
		$this->user->AdvancedSearch->SearchValue = @$filter["x_user"];
		$this->user->AdvancedSearch->SearchOperator = @$filter["z_user"];
		$this->user->AdvancedSearch->SearchCondition = @$filter["v_user"];
		$this->user->AdvancedSearch->SearchValue2 = @$filter["y_user"];
		$this->user->AdvancedSearch->SearchOperator2 = @$filter["w_user"];
		$this->user->AdvancedSearch->Save();

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
		$this->BuildBasicSearchSQL($sWhere, $this->kode_tindakan, $arKeywords, $type);
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
			$this->UpdateSort($this->statusbayar, $bCtrl); // statusbayar
			$this->UpdateSort($this->tanggal, $bCtrl); // tanggal
			$this->UpdateSort($this->kode_tindakan, $bCtrl); // kode_tindakan
			$this->UpdateSort($this->qty, $bCtrl); // qty
			$this->UpdateSort($this->tarif, $bCtrl); // tarif
			$this->UpdateSort($this->bhp, $bCtrl); // bhp
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
				$this->no_ruang->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->statusbayar->setSort("");
				$this->tanggal->setSort("");
				$this->kode_tindakan->setSort("");
				$this->qty->setSort("");
				$this->tarif->setSort("");
				$this->bhp->setSort("");
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

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"btn btn-danger btn-xs\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . " Delete</a>";
				}
			}
		}

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
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
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
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . " " . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$buttontext = ew_HtmlTitle($Language->Phrase("GridEditLink"));
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"btn btn-xs btn-warning\" title=\"" . $buttontext . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . " $buttontext</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_bill_ranap_detail_tindakan_perawatlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_bill_ranap_detail_tindakan_perawatlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_bill_ranap_detail_tindakan_perawatlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"btn btn-xs btn-default line-2592\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"btn btn-xs btn-default\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fvw_bill_ranap_detail_tindakan_perawatlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->statusbayar->CurrentValue = NULL;
		$this->statusbayar->OldValue = $this->statusbayar->CurrentValue;
		$this->tanggal->CurrentValue = date("d/m/Y");
		$this->tanggal->OldValue = $this->tanggal->CurrentValue;
		$this->kode_tindakan->CurrentValue = NULL;
		$this->kode_tindakan->OldValue = $this->kode_tindakan->CurrentValue;
		$this->qty->CurrentValue = 1;
		$this->qty->OldValue = $this->qty->CurrentValue;
		$this->tarif->CurrentValue = 0;
		$this->tarif->OldValue = $this->tarif->CurrentValue;
		$this->bhp->CurrentValue = 0;
		$this->bhp->OldValue = $this->bhp->CurrentValue;
		$this->user->CurrentValue = CurrentUserName();
		$this->user->OldValue = $this->user->CurrentValue;
		$this->no_ruang->CurrentValue = NULL;
		$this->no_ruang->OldValue = $this->no_ruang->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->statusbayar->FldIsDetailKey) {
			$this->statusbayar->setFormValue($objForm->GetValue("x_statusbayar"));
		}
		$this->statusbayar->setOldValue($objForm->GetValue("o_statusbayar"));
		if (!$this->tanggal->FldIsDetailKey) {
			$this->tanggal->setFormValue($objForm->GetValue("x_tanggal"));
			$this->tanggal->CurrentValue = ew_UnFormatDateTime($this->tanggal->CurrentValue, 7);
		}
		$this->tanggal->setOldValue($objForm->GetValue("o_tanggal"));
		if (!$this->kode_tindakan->FldIsDetailKey) {
			$this->kode_tindakan->setFormValue($objForm->GetValue("x_kode_tindakan"));
		}
		$this->kode_tindakan->setOldValue($objForm->GetValue("o_kode_tindakan"));
		if (!$this->qty->FldIsDetailKey) {
			$this->qty->setFormValue($objForm->GetValue("x_qty"));
		}
		$this->qty->setOldValue($objForm->GetValue("o_qty"));
		if (!$this->tarif->FldIsDetailKey) {
			$this->tarif->setFormValue($objForm->GetValue("x_tarif"));
		}
		$this->tarif->setOldValue($objForm->GetValue("o_tarif"));
		if (!$this->bhp->FldIsDetailKey) {
			$this->bhp->setFormValue($objForm->GetValue("x_bhp"));
		}
		$this->bhp->setOldValue($objForm->GetValue("o_bhp"));
		if (!$this->user->FldIsDetailKey) {
			$this->user->setFormValue($objForm->GetValue("x_user"));
		}
		$this->user->setOldValue($objForm->GetValue("o_user"));
		if (!$this->no_ruang->FldIsDetailKey) {
			$this->no_ruang->setFormValue($objForm->GetValue("x_no_ruang"));
		}
		$this->no_ruang->setOldValue($objForm->GetValue("o_no_ruang"));
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
		$this->tanggal->CurrentValue = $this->tanggal->FormValue;
		$this->tanggal->CurrentValue = ew_UnFormatDateTime($this->tanggal->CurrentValue, 7);
		$this->kode_tindakan->CurrentValue = $this->kode_tindakan->FormValue;
		$this->qty->CurrentValue = $this->qty->FormValue;
		$this->tarif->CurrentValue = $this->tarif->FormValue;
		$this->bhp->CurrentValue = $this->bhp->FormValue;
		$this->user->CurrentValue = $this->user->FormValue;
		$this->no_ruang->CurrentValue = $this->no_ruang->FormValue;
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
		$this->qty->setDbValue($rs->fields('qty'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->bhp->setDbValue($rs->fields('bhp'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->kelompok1->setDbValue($rs->fields('kelompok1'));
		$this->kelompok2->setDbValue($rs->fields('kelompok2'));
		$this->user->setDbValue($rs->fields('user'));
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
		$this->qty->DbValue = $row['qty'];
		$this->tarif->DbValue = $row['tarif'];
		$this->bhp->DbValue = $row['bhp'];
		$this->nama_tindakan->DbValue = $row['nama_tindakan'];
		$this->kelompok_tindakan->DbValue = $row['kelompok_tindakan'];
		$this->kelompok1->DbValue = $row['kelompok1'];
		$this->kelompok2->DbValue = $row['kelompok2'];
		$this->user->DbValue = $row['user'];
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

		// Convert decimal values if posted back
		if ($this->bhp->FormValue == $this->bhp->CurrentValue && is_numeric(ew_StrToFloat($this->bhp->CurrentValue)))
			$this->bhp->CurrentValue = ew_StrToFloat($this->bhp->CurrentValue);

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
		// qty
		// tarif
		// bhp
		// nama_tindakan
		// kelompok_tindakan
		// kelompok1
		// kelompok2
		// user
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
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->ViewCustomAttributes = "";

		// kode_tindakan
		if (strval($this->kode_tindakan->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_bill_ranap_data_tarif_tindakan`";
		$sWhereWrk = "";
		$this->kode_tindakan->LookupFilters = array();
		$lookuptblfilter = "`kelompok_tindakan`='2'";
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

		// qty
		$this->qty->ViewValue = $this->qty->CurrentValue;
		$this->qty->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// kelompok1
		$this->kelompok1->ViewValue = $this->kelompok1->CurrentValue;
		$this->kelompok1->ViewCustomAttributes = "";

		// kelompok2
		$this->kelompok2->ViewValue = $this->kelompok2->CurrentValue;
		$this->kelompok2->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// kode_dokter
		$this->kode_dokter->ViewValue = $this->kode_dokter->CurrentValue;
		$this->kode_dokter->ViewCustomAttributes = "";

		// no_ruang
		$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->ViewCustomAttributes = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";
			$this->kode_tindakan->TooltipValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";
			$this->qty->TooltipValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";
			$this->tarif->TooltipValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";
			$this->bhp->TooltipValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";
			$this->user->TooltipValue = "";

			// no_ruang
			$this->no_ruang->LinkCustomAttributes = "";
			$this->no_ruang->HrefValue = "";
			$this->no_ruang->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			if ($this->statusbayar->getSessionValue() <> "") {
				$this->statusbayar->CurrentValue = $this->statusbayar->getSessionValue();
				$this->statusbayar->OldValue = $this->statusbayar->CurrentValue;
			$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			$this->statusbayar->ViewCustomAttributes = "";
			} else {
			$this->statusbayar->EditValue = ew_HtmlEncode($this->statusbayar->CurrentValue);
			$this->statusbayar->PlaceHolder = ew_RemoveHtml($this->statusbayar->FldCaption());
			}

			// tanggal
			$this->tanggal->EditAttrs["class"] = "form-control";
			$this->tanggal->EditCustomAttributes = "";
			$this->tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal->CurrentValue, 7));
			$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

			// kode_tindakan
			$this->kode_tindakan->EditAttrs["class"] = "form-control";
			$this->kode_tindakan->EditCustomAttributes = "";
			if (trim(strval($this->kode_tindakan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `vw_bill_ranap_data_tarif_tindakan`";
			$sWhereWrk = "";
			$this->kode_tindakan->LookupFilters = array();
			$lookuptblfilter = "`kelompok_tindakan`='2'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kode_tindakan->EditValue = $arwrk;

			// qty
			$this->qty->EditAttrs["class"] = "form-control";
			$this->qty->EditCustomAttributes = "";
			$this->qty->EditValue = ew_HtmlEncode($this->qty->CurrentValue);
			$this->qty->PlaceHolder = ew_RemoveHtml($this->qty->FldCaption());

			// tarif
			$this->tarif->EditAttrs["class"] = "form-control";
			$this->tarif->EditCustomAttributes = "";
			$this->tarif->EditValue = ew_HtmlEncode($this->tarif->CurrentValue);
			$this->tarif->PlaceHolder = ew_RemoveHtml($this->tarif->FldCaption());
			if (strval($this->tarif->EditValue) <> "" && is_numeric($this->tarif->EditValue)) {
			$this->tarif->EditValue = ew_FormatNumber($this->tarif->EditValue, -2, -1, -2, 0);
			$this->tarif->OldValue = $this->tarif->EditValue;
			}

			// bhp
			$this->bhp->EditAttrs["class"] = "form-control";
			$this->bhp->EditCustomAttributes = "";
			$this->bhp->EditValue = ew_HtmlEncode($this->bhp->CurrentValue);
			$this->bhp->PlaceHolder = ew_RemoveHtml($this->bhp->FldCaption());
			if (strval($this->bhp->EditValue) <> "" && is_numeric($this->bhp->EditValue)) {
			$this->bhp->EditValue = ew_FormatNumber($this->bhp->EditValue, -2, -1, -2, 0);
			$this->bhp->OldValue = $this->bhp->EditValue;
			}

			// user
			$this->user->EditAttrs["class"] = "form-control";
			$this->user->EditCustomAttributes = "";
			$this->user->EditValue = ew_HtmlEncode($this->user->CurrentValue);
			$this->user->PlaceHolder = ew_RemoveHtml($this->user->FldCaption());

			// no_ruang
			$this->no_ruang->EditAttrs["class"] = "form-control";
			$this->no_ruang->EditCustomAttributes = "";
			if ($this->no_ruang->getSessionValue() <> "") {
				$this->no_ruang->CurrentValue = $this->no_ruang->getSessionValue();
				$this->no_ruang->OldValue = $this->no_ruang->CurrentValue;
			$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
			$this->no_ruang->ViewCustomAttributes = "";
			} else {
			$this->no_ruang->EditValue = ew_HtmlEncode($this->no_ruang->CurrentValue);
			$this->no_ruang->PlaceHolder = ew_RemoveHtml($this->no_ruang->FldCaption());
			}

			// Add refer script
			// statusbayar

			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";

			// no_ruang
			$this->no_ruang->LinkCustomAttributes = "";
			$this->no_ruang->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			if ($this->statusbayar->getSessionValue() <> "") {
				$this->statusbayar->CurrentValue = $this->statusbayar->getSessionValue();
				$this->statusbayar->OldValue = $this->statusbayar->CurrentValue;
			$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			$this->statusbayar->ViewCustomAttributes = "";
			} else {
			$this->statusbayar->EditValue = ew_HtmlEncode($this->statusbayar->CurrentValue);
			$this->statusbayar->PlaceHolder = ew_RemoveHtml($this->statusbayar->FldCaption());
			}

			// tanggal
			$this->tanggal->EditAttrs["class"] = "form-control";
			$this->tanggal->EditCustomAttributes = "";
			$this->tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal->CurrentValue, 7));
			$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

			// kode_tindakan
			$this->kode_tindakan->EditAttrs["class"] = "form-control";
			$this->kode_tindakan->EditCustomAttributes = "";
			if (trim(strval($this->kode_tindakan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `vw_bill_ranap_data_tarif_tindakan`";
			$sWhereWrk = "";
			$this->kode_tindakan->LookupFilters = array();
			$lookuptblfilter = "`kelompok_tindakan`='2'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kode_tindakan->EditValue = $arwrk;

			// qty
			$this->qty->EditAttrs["class"] = "form-control";
			$this->qty->EditCustomAttributes = "";
			$this->qty->EditValue = ew_HtmlEncode($this->qty->CurrentValue);
			$this->qty->PlaceHolder = ew_RemoveHtml($this->qty->FldCaption());

			// tarif
			$this->tarif->EditAttrs["class"] = "form-control";
			$this->tarif->EditCustomAttributes = "";
			$this->tarif->EditValue = ew_HtmlEncode($this->tarif->CurrentValue);
			$this->tarif->PlaceHolder = ew_RemoveHtml($this->tarif->FldCaption());
			if (strval($this->tarif->EditValue) <> "" && is_numeric($this->tarif->EditValue)) {
			$this->tarif->EditValue = ew_FormatNumber($this->tarif->EditValue, -2, -1, -2, 0);
			$this->tarif->OldValue = $this->tarif->EditValue;
			}

			// bhp
			$this->bhp->EditAttrs["class"] = "form-control";
			$this->bhp->EditCustomAttributes = "";
			$this->bhp->EditValue = ew_HtmlEncode($this->bhp->CurrentValue);
			$this->bhp->PlaceHolder = ew_RemoveHtml($this->bhp->FldCaption());
			if (strval($this->bhp->EditValue) <> "" && is_numeric($this->bhp->EditValue)) {
			$this->bhp->EditValue = ew_FormatNumber($this->bhp->EditValue, -2, -1, -2, 0);
			$this->bhp->OldValue = $this->bhp->EditValue;
			}

			// user
			$this->user->EditAttrs["class"] = "form-control";
			$this->user->EditCustomAttributes = "";
			$this->user->EditValue = ew_HtmlEncode($this->user->CurrentValue);
			$this->user->PlaceHolder = ew_RemoveHtml($this->user->FldCaption());

			// no_ruang
			$this->no_ruang->EditAttrs["class"] = "form-control";
			$this->no_ruang->EditCustomAttributes = "";
			if ($this->no_ruang->getSessionValue() <> "") {
				$this->no_ruang->CurrentValue = $this->no_ruang->getSessionValue();
				$this->no_ruang->OldValue = $this->no_ruang->CurrentValue;
			$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
			$this->no_ruang->ViewCustomAttributes = "";
			} else {
			$this->no_ruang->EditValue = ew_HtmlEncode($this->no_ruang->CurrentValue);
			$this->no_ruang->PlaceHolder = ew_RemoveHtml($this->no_ruang->FldCaption());
			}

			// Edit refer script
			// statusbayar

			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";

			// no_ruang
			$this->no_ruang->LinkCustomAttributes = "";
			$this->no_ruang->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->statusbayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->statusbayar->FldErrMsg());
		}
		if (!$this->tanggal->FldIsDetailKey && !is_null($this->tanggal->FormValue) && $this->tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tanggal->FldCaption(), $this->tanggal->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal->FldErrMsg());
		}
		if (!$this->kode_tindakan->FldIsDetailKey && !is_null($this->kode_tindakan->FormValue) && $this->kode_tindakan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kode_tindakan->FldCaption(), $this->kode_tindakan->ReqErrMsg));
		}
		if (!$this->qty->FldIsDetailKey && !is_null($this->qty->FormValue) && $this->qty->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->qty->FldCaption(), $this->qty->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->qty->FormValue)) {
			ew_AddMessage($gsFormError, $this->qty->FldErrMsg());
		}
		if (!$this->tarif->FldIsDetailKey && !is_null($this->tarif->FormValue) && $this->tarif->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tarif->FldCaption(), $this->tarif->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->tarif->FormValue)) {
			ew_AddMessage($gsFormError, $this->tarif->FldErrMsg());
		}
		if (!ew_CheckNumber($this->bhp->FormValue)) {
			ew_AddMessage($gsFormError, $this->bhp->FldErrMsg());
		}
		if (!$this->user->FldIsDetailKey && !is_null($this->user->FormValue) && $this->user->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->user->FldCaption(), $this->user->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->no_ruang->FormValue)) {
			ew_AddMessage($gsFormError, $this->no_ruang->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// statusbayar
			$this->statusbayar->SetDbValueDef($rsnew, $this->statusbayar->CurrentValue, NULL, $this->statusbayar->ReadOnly);

			// tanggal
			$this->tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal->CurrentValue, 7), NULL, $this->tanggal->ReadOnly);

			// kode_tindakan
			$this->kode_tindakan->SetDbValueDef($rsnew, $this->kode_tindakan->CurrentValue, NULL, $this->kode_tindakan->ReadOnly);

			// qty
			$this->qty->SetDbValueDef($rsnew, $this->qty->CurrentValue, NULL, $this->qty->ReadOnly);

			// tarif
			$this->tarif->SetDbValueDef($rsnew, $this->tarif->CurrentValue, NULL, $this->tarif->ReadOnly);

			// bhp
			$this->bhp->SetDbValueDef($rsnew, $this->bhp->CurrentValue, NULL, $this->bhp->ReadOnly);

			// user
			$this->user->SetDbValueDef($rsnew, $this->user->CurrentValue, NULL, $this->user->ReadOnly);

			// no_ruang
			$this->no_ruang->SetDbValueDef($rsnew, $this->no_ruang->CurrentValue, NULL, $this->no_ruang->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// statusbayar
		$this->statusbayar->SetDbValueDef($rsnew, $this->statusbayar->CurrentValue, NULL, FALSE);

		// tanggal
		$this->tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal->CurrentValue, 7), NULL, FALSE);

		// kode_tindakan
		$this->kode_tindakan->SetDbValueDef($rsnew, $this->kode_tindakan->CurrentValue, NULL, FALSE);

		// qty
		$this->qty->SetDbValueDef($rsnew, $this->qty->CurrentValue, NULL, FALSE);

		// tarif
		$this->tarif->SetDbValueDef($rsnew, $this->tarif->CurrentValue, NULL, strval($this->tarif->CurrentValue) == "");

		// bhp
		$this->bhp->SetDbValueDef($rsnew, $this->bhp->CurrentValue, NULL, strval($this->bhp->CurrentValue) == "");

		// user
		$this->user->SetDbValueDef($rsnew, $this->user->CurrentValue, NULL, FALSE);

		// no_ruang
		$this->no_ruang->SetDbValueDef($rsnew, $this->no_ruang->CurrentValue, NULL, FALSE);

		// id_admission
		if ($this->id_admission->getSessionValue() <> "") {
			$rsnew['id_admission'] = $this->id_admission->getSessionValue();
		}

		// nomr
		if ($this->nomr->getSessionValue() <> "") {
			$rsnew['nomr'] = $this->nomr->getSessionValue();
		}

		// kelas
		if ($this->kelas->getSessionValue() <> "") {
			$rsnew['kelas'] = $this->kelas->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
				if (@$_GET["fk_noruang"] <> "") {
					$GLOBALS["vw_bill_ranap"]->noruang->setQueryStringValue($_GET["fk_noruang"]);
					$this->no_ruang->setQueryStringValue($GLOBALS["vw_bill_ranap"]->noruang->QueryStringValue);
					$this->no_ruang->setSessionValue($this->no_ruang->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->noruang->QueryStringValue)) $bValidMaster = FALSE;
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
				if (@$_POST["fk_noruang"] <> "") {
					$GLOBALS["vw_bill_ranap"]->noruang->setFormValue($_POST["fk_noruang"]);
					$this->no_ruang->setFormValue($GLOBALS["vw_bill_ranap"]->noruang->FormValue);
					$this->no_ruang->setSessionValue($this->no_ruang->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->noruang->FormValue)) $bValidMaster = FALSE;
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
				if ($this->no_ruang->CurrentValue == "") $this->no_ruang->setSessionValue("");
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
		case "x_kode_tindakan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_bill_ranap_data_tarif_tindakan`";
			$sWhereWrk = "";
			$this->kode_tindakan->LookupFilters = array();
			$lookuptblfilter = "`kelompok_tindakan`='2'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($vw_bill_ranap_detail_tindakan_perawat_list)) $vw_bill_ranap_detail_tindakan_perawat_list = new cvw_bill_ranap_detail_tindakan_perawat_list();

// Page init
$vw_bill_ranap_detail_tindakan_perawat_list->Page_Init();

// Page main
$vw_bill_ranap_detail_tindakan_perawat_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_tindakan_perawat_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_bill_ranap_detail_tindakan_perawatlist = new ew_Form("fvw_bill_ranap_detail_tindakan_perawatlist", "list");
fvw_bill_ranap_detail_tindakan_perawatlist.FormKeyCountName = '<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->FormKeyCountName ?>';

// Validate form
fvw_bill_ranap_detail_tindakan_perawatlist.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_statusbayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_perawat->statusbayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_perawat->tanggal->FldCaption(), $vw_bill_ranap_detail_tindakan_perawat->tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_perawat->tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kode_tindakan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->FldCaption(), $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_perawat->qty->FldCaption(), $vw_bill_ranap_detail_tindakan_perawat->qty->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_perawat->qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_perawat->tarif->FldCaption(), $vw_bill_ranap_detail_tindakan_perawat->tarif->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_perawat->tarif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bhp");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_perawat->bhp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_tindakan_perawat->user->FldCaption(), $vw_bill_ranap_detail_tindakan_perawat->user->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_no_ruang");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_tindakan_perawat->no_ruang->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fvw_bill_ranap_detail_tindakan_perawatlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "statusbayar", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tanggal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "kode_tindakan", false)) return false;
	if (ew_ValueChanged(fobj, infix, "qty", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tarif", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bhp", false)) return false;
	if (ew_ValueChanged(fobj, infix, "user", false)) return false;
	if (ew_ValueChanged(fobj, infix, "no_ruang", false)) return false;
	return true;
}

// Form_CustomValidate event
fvw_bill_ranap_detail_tindakan_perawatlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_tindakan_perawatlist.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_tindakan_perawatlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_tindakan_perawatlist.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};

// Form object for search
var CurrentSearchForm = fvw_bill_ranap_detail_tindakan_perawatlistsrch = new ew_Form("fvw_bill_ranap_detail_tindakan_perawatlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs > 0 && $vw_bill_ranap_detail_tindakan_perawat_list->ExportOptions->Visible()) { ?>
<?php $vw_bill_ranap_detail_tindakan_perawat_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->SearchOptions->Visible()) { ?>
<?php $vw_bill_ranap_detail_tindakan_perawat_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->FilterOptions->Visible()) { ?>
<?php $vw_bill_ranap_detail_tindakan_perawat_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php if (($vw_bill_ranap_detail_tindakan_perawat->Export == "") || (EW_EXPORT_MASTER_RECORD && $vw_bill_ranap_detail_tindakan_perawat->Export == "print")) { ?>
<?php
if ($vw_bill_ranap_detail_tindakan_perawat_list->DbMasterFilter <> "" && $vw_bill_ranap_detail_tindakan_perawat->getCurrentMasterTable() == "vw_bill_ranap") {
	if ($vw_bill_ranap_detail_tindakan_perawat_list->MasterRecordExists) {
?>
<?php include_once "vw_bill_ranapmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd") {
	$vw_bill_ranap_detail_tindakan_perawat->CurrentFilter = "0=1";
	$vw_bill_ranap_detail_tindakan_perawat_list->StartRec = 1;
	$vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs = $vw_bill_ranap_detail_tindakan_perawat->GridAddRowCount;
	$vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs = $vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs;
	$vw_bill_ranap_detail_tindakan_perawat_list->StopRec = $vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs;
} else {
	$bSelectLimit = $vw_bill_ranap_detail_tindakan_perawat_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs <= 0)
			$vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs = $vw_bill_ranap_detail_tindakan_perawat->SelectRecordCount();
	} else {
		if (!$vw_bill_ranap_detail_tindakan_perawat_list->Recordset && ($vw_bill_ranap_detail_tindakan_perawat_list->Recordset = $vw_bill_ranap_detail_tindakan_perawat_list->LoadRecordset()))
			$vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs = $vw_bill_ranap_detail_tindakan_perawat_list->Recordset->RecordCount();
	}
	$vw_bill_ranap_detail_tindakan_perawat_list->StartRec = 1;
	if ($vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs <= 0 || ($vw_bill_ranap_detail_tindakan_perawat->Export <> "" && $vw_bill_ranap_detail_tindakan_perawat->ExportAll)) // Display all records
		$vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs = $vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs;
	if (!($vw_bill_ranap_detail_tindakan_perawat->Export <> "" && $vw_bill_ranap_detail_tindakan_perawat->ExportAll))
		$vw_bill_ranap_detail_tindakan_perawat_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_bill_ranap_detail_tindakan_perawat_list->Recordset = $vw_bill_ranap_detail_tindakan_perawat_list->LoadRecordset($vw_bill_ranap_detail_tindakan_perawat_list->StartRec-1, $vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs);

	// Set no record found message
	if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "" && $vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bill_ranap_detail_tindakan_perawat_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_bill_ranap_detail_tindakan_perawat_list->SearchWhere == "0=101")
			$vw_bill_ranap_detail_tindakan_perawat_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bill_ranap_detail_tindakan_perawat_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($vw_bill_ranap_detail_tindakan_perawat_list->AuditTrailOnSearch && $vw_bill_ranap_detail_tindakan_perawat_list->Command == "search" && !$vw_bill_ranap_detail_tindakan_perawat_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $vw_bill_ranap_detail_tindakan_perawat_list->getSessionWhere();
		$vw_bill_ranap_detail_tindakan_perawat_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$vw_bill_ranap_detail_tindakan_perawat_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->Export == "" && $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "") { ?>
<form name="fvw_bill_ranap_detail_tindakan_perawatlistsrch" id="fvw_bill_ranap_detail_tindakan_perawatlistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($vw_bill_ranap_detail_tindakan_perawat_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fvw_bill_ranap_detail_tindakan_perawatlistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vw_bill_ranap_detail_tindakan_perawat">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $vw_bill_ranap_detail_tindakan_perawat_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $vw_bill_ranap_detail_tindakan_perawat_list->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_tindakan_perawat_list->ShowMessage();
?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs > 0 || $vw_bill_ranap_detail_tindakan_perawat->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bill_ranap_detail_tindakan_perawat">
<form name="fvw_bill_ranap_detail_tindakan_perawatlist" id="fvw_bill_ranap_detail_tindakan_perawatlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bill_ranap_detail_tindakan_perawat">
<?php if ($vw_bill_ranap_detail_tindakan_perawat->getCurrentMasterTable() == "vw_bill_ranap" && $vw_bill_ranap_detail_tindakan_perawat->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="vw_bill_ranap">
<input type="hidden" name="fk_id_admission" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->id_admission->getSessionValue() ?>">
<input type="hidden" name="fk_nomr" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->nomr->getSessionValue() ?>">
<input type="hidden" name="fk_statusbayar" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->getSessionValue() ?>">
<input type="hidden" name="fk_KELASPERAWATAN_ID" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->kelas->getSessionValue() ?>">
<input type="hidden" name="fk_noruang" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->getSessionValue() ?>">
<?php } ?>
<div id="gmp_vw_bill_ranap_detail_tindakan_perawat" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs > 0 || $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_bill_ranap_detail_tindakan_perawatlist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap_detail_tindakan_perawat->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bill_ranap_detail_tindakan_perawat_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bill_ranap_detail_tindakan_perawat_list->RenderListOptions();

// Render list options (header, left)
$vw_bill_ranap_detail_tindakan_perawat_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->Visible) { // statusbayar ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->statusbayar) == "") { ?>
		<th data-name="statusbayar"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="vw_bill_ranap_detail_tindakan_perawat_statusbayar"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="statusbayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->statusbayar) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="vw_bill_ranap_detail_tindakan_perawat_statusbayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_perawat->tanggal->Visible) { // tanggal ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->tanggal) == "") { ?>
		<th data-name="tanggal"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_tanggal" class="vw_bill_ranap_detail_tindakan_perawat_tanggal"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->tanggal) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_tanggal" class="vw_bill_ranap_detail_tindakan_perawat_tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->tanggal->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->tanggal->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->Visible) { // kode_tindakan ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan) == "") { ?>
		<th data-name="kode_tindakan"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_kode_tindakan" class="vw_bill_ranap_detail_tindakan_perawat_kode_tindakan"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="kode_tindakan"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_kode_tindakan" class="vw_bill_ranap_detail_tindakan_perawat_kode_tindakan">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_perawat->qty->Visible) { // qty ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->qty) == "") { ?>
		<th data-name="qty"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_qty" class="vw_bill_ranap_detail_tindakan_perawat_qty"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="qty"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->qty) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_qty" class="vw_bill_ranap_detail_tindakan_perawat_qty">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->qty->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->qty->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_perawat->tarif->Visible) { // tarif ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->tarif) == "") { ?>
		<th data-name="tarif"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_tarif" class="vw_bill_ranap_detail_tindakan_perawat_tarif"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tarif"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->tarif) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_tarif" class="vw_bill_ranap_detail_tindakan_perawat_tarif">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->tarif->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->tarif->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_perawat->bhp->Visible) { // bhp ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->bhp) == "") { ?>
		<th data-name="bhp"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_bhp" class="vw_bill_ranap_detail_tindakan_perawat_bhp"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bhp"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->bhp) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_bhp" class="vw_bill_ranap_detail_tindakan_perawat_bhp">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->bhp->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->bhp->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_perawat->user->Visible) { // user ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->user) == "") { ?>
		<th data-name="user"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_user" class="vw_bill_ranap_detail_tindakan_perawat_user"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->user->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="user"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->user) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_user" class="vw_bill_ranap_detail_tindakan_perawat_user">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->user->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->user->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->user->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->Visible) { // no_ruang ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->no_ruang) == "") { ?>
		<th data-name="no_ruang"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="vw_bill_ranap_detail_tindakan_perawat_no_ruang"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="no_ruang"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap_detail_tindakan_perawat->SortUrl($vw_bill_ranap_detail_tindakan_perawat->no_ruang) ?>',2);"><div id="elh_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="vw_bill_ranap_detail_tindakan_perawat_no_ruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bill_ranap_detail_tindakan_perawat_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_bill_ranap_detail_tindakan_perawat->ExportAll && $vw_bill_ranap_detail_tindakan_perawat->Export <> "") {
	$vw_bill_ranap_detail_tindakan_perawat_list->StopRec = $vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs > $vw_bill_ranap_detail_tindakan_perawat_list->StartRec + $vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs - 1)
		$vw_bill_ranap_detail_tindakan_perawat_list->StopRec = $vw_bill_ranap_detail_tindakan_perawat_list->StartRec + $vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs - 1;
	else
		$vw_bill_ranap_detail_tindakan_perawat_list->StopRec = $vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($vw_bill_ranap_detail_tindakan_perawat_list->FormKeyCountName) && ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd" || $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit" || $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "F")) {
		$vw_bill_ranap_detail_tindakan_perawat_list->KeyCount = $objForm->GetValue($vw_bill_ranap_detail_tindakan_perawat_list->FormKeyCountName);
		$vw_bill_ranap_detail_tindakan_perawat_list->StopRec = $vw_bill_ranap_detail_tindakan_perawat_list->StartRec + $vw_bill_ranap_detail_tindakan_perawat_list->KeyCount - 1;
	}
}
$vw_bill_ranap_detail_tindakan_perawat_list->RecCnt = $vw_bill_ranap_detail_tindakan_perawat_list->StartRec - 1;
if ($vw_bill_ranap_detail_tindakan_perawat_list->Recordset && !$vw_bill_ranap_detail_tindakan_perawat_list->Recordset->EOF) {
	$vw_bill_ranap_detail_tindakan_perawat_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_bill_ranap_detail_tindakan_perawat_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_bill_ranap_detail_tindakan_perawat_list->StartRec > 1)
		$vw_bill_ranap_detail_tindakan_perawat_list->Recordset->Move($vw_bill_ranap_detail_tindakan_perawat_list->StartRec - 1);
} elseif (!$vw_bill_ranap_detail_tindakan_perawat->AllowAddDeleteRow && $vw_bill_ranap_detail_tindakan_perawat_list->StopRec == 0) {
	$vw_bill_ranap_detail_tindakan_perawat_list->StopRec = $vw_bill_ranap_detail_tindakan_perawat->GridAddRowCount;
}

// Initialize aggregate
$vw_bill_ranap_detail_tindakan_perawat->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bill_ranap_detail_tindakan_perawat->ResetAttrs();
$vw_bill_ranap_detail_tindakan_perawat_list->RenderRow();
if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd")
	$vw_bill_ranap_detail_tindakan_perawat_list->RowIndex = 0;
if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit")
	$vw_bill_ranap_detail_tindakan_perawat_list->RowIndex = 0;
while ($vw_bill_ranap_detail_tindakan_perawat_list->RecCnt < $vw_bill_ranap_detail_tindakan_perawat_list->StopRec) {
	$vw_bill_ranap_detail_tindakan_perawat_list->RecCnt++;
	if (intval($vw_bill_ranap_detail_tindakan_perawat_list->RecCnt) >= intval($vw_bill_ranap_detail_tindakan_perawat_list->StartRec)) {
		$vw_bill_ranap_detail_tindakan_perawat_list->RowCnt++;
		if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd" || $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit" || $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "F") {
			$vw_bill_ranap_detail_tindakan_perawat_list->RowIndex++;
			$objForm->Index = $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex;
			if ($objForm->HasValue($vw_bill_ranap_detail_tindakan_perawat_list->FormActionName))
				$vw_bill_ranap_detail_tindakan_perawat_list->RowAction = strval($objForm->GetValue($vw_bill_ranap_detail_tindakan_perawat_list->FormActionName));
			elseif ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd")
				$vw_bill_ranap_detail_tindakan_perawat_list->RowAction = "insert";
			else
				$vw_bill_ranap_detail_tindakan_perawat_list->RowAction = "";
		}

		// Set up key count
		$vw_bill_ranap_detail_tindakan_perawat_list->KeyCount = $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex;

		// Init row class and style
		$vw_bill_ranap_detail_tindakan_perawat->ResetAttrs();
		$vw_bill_ranap_detail_tindakan_perawat->CssClass = "";
		if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd") {
			$vw_bill_ranap_detail_tindakan_perawat_list->LoadDefaultValues(); // Load default values
		} else {
			$vw_bill_ranap_detail_tindakan_perawat_list->LoadRowValues($vw_bill_ranap_detail_tindakan_perawat_list->Recordset); // Load row values
		}
		$vw_bill_ranap_detail_tindakan_perawat->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd") // Grid add
			$vw_bill_ranap_detail_tindakan_perawat->RowType = EW_ROWTYPE_ADD; // Render add
		if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd" && $vw_bill_ranap_detail_tindakan_perawat->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$vw_bill_ranap_detail_tindakan_perawat_list->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_perawat_list->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit") { // Grid edit
			if ($vw_bill_ranap_detail_tindakan_perawat->EventCancelled) {
				$vw_bill_ranap_detail_tindakan_perawat_list->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_perawat_list->RowIndex); // Restore form values
			}
			if ($vw_bill_ranap_detail_tindakan_perawat_list->RowAction == "insert")
				$vw_bill_ranap_detail_tindakan_perawat->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$vw_bill_ranap_detail_tindakan_perawat->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit" && ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) && $vw_bill_ranap_detail_tindakan_perawat->EventCancelled) // Update failed
			$vw_bill_ranap_detail_tindakan_perawat_list->RestoreCurrentRowFormValues($vw_bill_ranap_detail_tindakan_perawat_list->RowIndex); // Restore form values
		if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) // Edit row
			$vw_bill_ranap_detail_tindakan_perawat_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$vw_bill_ranap_detail_tindakan_perawat->RowAttrs = array_merge($vw_bill_ranap_detail_tindakan_perawat->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_tindakan_perawat_list->RowCnt, 'id'=>'r' . $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt . '_vw_bill_ranap_detail_tindakan_perawat', 'data-rowtype'=>$vw_bill_ranap_detail_tindakan_perawat->RowType));

		// Render row
		$vw_bill_ranap_detail_tindakan_perawat_list->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_tindakan_perawat_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($vw_bill_ranap_detail_tindakan_perawat_list->RowAction <> "delete" && $vw_bill_ranap_detail_tindakan_perawat_list->RowAction <> "insertdelete" && !($vw_bill_ranap_detail_tindakan_perawat_list->RowAction == "insert" && $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "F" && $vw_bill_ranap_detail_tindakan_perawat_list->EmptyRow())) {
?>
	<tr<?php echo $vw_bill_ranap_detail_tindakan_perawat->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_tindakan_perawat_list->ListOptions->Render("body", "left", $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt);
?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->Visible) { // statusbayar ?>
		<td data-name="statusbayar"<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getSessionValue() <> "") { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="form-group vw_bill_ranap_detail_tindakan_perawat_statusbayar">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="form-group vw_bill_ranap_detail_tindakan_perawat_statusbayar">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_statusbayar" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_statusbayar" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getSessionValue() <> "") { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="form-group vw_bill_ranap_detail_tindakan_perawat_statusbayar">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="form-group vw_bill_ranap_detail_tindakan_perawat_statusbayar">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_statusbayar" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="vw_bill_ranap_detail_tindakan_perawat_statusbayar">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->PageObjName . "_row_" . $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->id->CurrentValue) ?>">
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_id" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_id" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->id->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT || $vw_bill_ranap_detail_tindakan_perawat->CurrentMode == "edit") { ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_id" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_id" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_id" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->id->CurrentValue) ?>">
<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_tanggal" class="form-group vw_bill_ranap_detail_tindakan_perawat_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_perawat->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_perawat->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_perawatlist", "x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tanggal->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_tanggal" class="form-group vw_bill_ranap_detail_tindakan_perawat_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_perawat->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_perawat->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_perawatlist", "x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_tanggal" class="vw_bill_ranap_detail_tindakan_perawat_tanggal">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_perawat_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp">
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_perawat_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp">
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_kode_tindakan" class="vw_bill_ranap_detail_tindakan_perawat_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->qty->Visible) { // qty ?>
		<td data-name="qty"<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_qty" class="form-group vw_bill_ranap_detail_tindakan_perawat_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->qty->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_qty" class="form-group vw_bill_ranap_detail_tindakan_perawat_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_qty" class="vw_bill_ranap_detail_tindakan_perawat_qty">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->tarif->Visible) { // tarif ?>
		<td data-name="tarif"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_tarif" class="form-group vw_bill_ranap_detail_tindakan_perawat_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tarif->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_tarif" class="form-group vw_bill_ranap_detail_tindakan_perawat_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_tarif" class="vw_bill_ranap_detail_tindakan_perawat_tarif">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->bhp->Visible) { // bhp ?>
		<td data-name="bhp"<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_bhp" class="form-group vw_bill_ranap_detail_tindakan_perawat_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->bhp->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_bhp" class="form-group vw_bill_ranap_detail_tindakan_perawat_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_bhp" class="vw_bill_ranap_detail_tindakan_perawat_bhp">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->user->Visible) { // user ?>
		<td data-name="user"<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_user" class="form-group vw_bill_ranap_detail_tindakan_perawat_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->user->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_user" class="form-group vw_bill_ranap_detail_tindakan_perawat_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_user" class="vw_bill_ranap_detail_tindakan_perawat_user">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->Visible) { // no_ruang ?>
		<td data-name="no_ruang"<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getSessionValue() <> "") { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="form-group vw_bill_ranap_detail_tindakan_perawat_no_ruang">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="form-group vw_bill_ranap_detail_tindakan_perawat_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->OldValue) ?>">
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getSessionValue() <> "") { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="form-group vw_bill_ranap_detail_tindakan_perawat_no_ruang">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="form-group vw_bill_ranap_detail_tindakan_perawat_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt ?>_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="vw_bill_ranap_detail_tindakan_perawat_no_ruang">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_tindakan_perawat_list->ListOptions->Render("body", "right", $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt);
?>
	</tr>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_ADD || $vw_bill_ranap_detail_tindakan_perawat->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_perawatlist.UpdateOpts(<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction <> "gridadd")
		if (!$vw_bill_ranap_detail_tindakan_perawat_list->Recordset->EOF) $vw_bill_ranap_detail_tindakan_perawat_list->Recordset->MoveNext();
}
?>
<?php
	if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd" || $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit") {
		$vw_bill_ranap_detail_tindakan_perawat_list->RowIndex = '$rowindex$';
		$vw_bill_ranap_detail_tindakan_perawat_list->LoadDefaultValues();

		// Set row properties
		$vw_bill_ranap_detail_tindakan_perawat->ResetAttrs();
		$vw_bill_ranap_detail_tindakan_perawat->RowAttrs = array_merge($vw_bill_ranap_detail_tindakan_perawat->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_detail_tindakan_perawat_list->RowIndex, 'id'=>'r0_vw_bill_ranap_detail_tindakan_perawat', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($vw_bill_ranap_detail_tindakan_perawat->RowAttrs["class"], "ewTemplate");
		$vw_bill_ranap_detail_tindakan_perawat->RowType = EW_ROWTYPE_ADD;

		// Render row
		$vw_bill_ranap_detail_tindakan_perawat_list->RenderRow();

		// Render list options
		$vw_bill_ranap_detail_tindakan_perawat_list->RenderListOptions();
		$vw_bill_ranap_detail_tindakan_perawat_list->StartRowCnt = 0;
?>
	<tr<?php echo $vw_bill_ranap_detail_tindakan_perawat->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_detail_tindakan_perawat_list->ListOptions->Render("body", "left", $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex);
?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->Visible) { // statusbayar ?>
		<td data-name="statusbayar">
<?php if ($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getSessionValue() <> "") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="form-group vw_bill_ranap_detail_tindakan_perawat_statusbayar">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_statusbayar" class="form-group vw_bill_ranap_detail_tindakan_perawat_statusbayar">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_statusbayar" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->statusbayar->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_statusbayar" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_statusbayar" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->statusbayar->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal">
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_tanggal" class="form-group vw_bill_ranap_detail_tindakan_perawat_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tanggal" data-format="7" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" size="10" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_tindakan_perawat->tanggal->ReadOnly && !$vw_bill_ranap_detail_tindakan_perawat->tanggal->Disabled && !isset($vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_tindakan_perawat->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_tindakan_perawatlist", "x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tanggal" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tanggal" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tanggal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->Visible) { // kode_tindakan ?>
		<td data-name="kode_tindakan">
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_kode_tindakan" class="form-group vw_bill_ranap_detail_tindakan_perawat_kode_tindakan">
<?php $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan"<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->SelectOptionListHtml("x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="s_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="ln_x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif,x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp">
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_kode_tindakan" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_kode_tindakan" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->kode_tindakan->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->qty->Visible) { // qty ?>
		<td data-name="qty">
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_qty" class="form-group vw_bill_ranap_detail_tindakan_perawat_qty">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_qty" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->qty->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_qty" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_qty" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->qty->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->tarif->Visible) { // tarif ?>
		<td data-name="tarif">
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_tarif" class="form-group vw_bill_ranap_detail_tindakan_perawat_tarif">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tarif" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->tarif->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_tarif" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_tarif" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->tarif->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->bhp->Visible) { // bhp ?>
		<td data-name="bhp">
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_bhp" class="form-group vw_bill_ranap_detail_tindakan_perawat_bhp">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_bhp" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" size="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->bhp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_bhp" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_bhp" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->bhp->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->user->Visible) { // user ?>
		<td data-name="user">
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_user" class="form-group vw_bill_ranap_detail_tindakan_perawat_user">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_user" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->user->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_user" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_user" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->user->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->Visible) { // no_ruang ?>
		<td data-name="no_ruang">
<?php if ($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getSessionValue() <> "") { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="form-group vw_bill_ranap_detail_tindakan_perawat_no_ruang">
<span<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_vw_bill_ranap_detail_tindakan_perawat_no_ruang" class="form-group vw_bill_ranap_detail_tindakan_perawat_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_no_ruang" name="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" id="x<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_tindakan_perawat->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="vw_bill_ranap_detail_tindakan_perawat" data-field="x_no_ruang" name="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" id="o<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_tindakan_perawat->no_ruang->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_detail_tindakan_perawat_list->ListOptions->Render("body", "right", $vw_bill_ranap_detail_tindakan_perawat_list->RowCnt);
?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_perawatlist.UpdateOpts(<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->FormKeyCountName ?>" id="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->FormKeyCountName ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->KeyCount ?>">
<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->MultiSelectKey ?>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_bill_ranap_detail_tindakan_perawat_list->Recordset)
	$vw_bill_ranap_detail_tindakan_perawat_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_bill_ranap_detail_tindakan_perawat->CurrentAction <> "gridadd" && $vw_bill_ranap_detail_tindakan_perawat->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_bill_ranap_detail_tindakan_perawat_list->Pager)) $vw_bill_ranap_detail_tindakan_perawat_list->Pager = new cPrevNextPager($vw_bill_ranap_detail_tindakan_perawat_list->StartRec, $vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs, $vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs) ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->Pager->RecordCount > 0 && $vw_bill_ranap_detail_tindakan_perawat_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_bill_ranap_detail_tindakan_perawat_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_bill_ranap_detail_tindakan_perawat_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_bill_ranap_detail_tindakan_perawat">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_tindakan_perawat_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_tindakan_perawat_list->TotalRecs == 0 && $vw_bill_ranap_detail_tindakan_perawat->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_detail_tindakan_perawat_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_bill_ranap_detail_tindakan_perawatlistsrch.FilterList = <?php echo $vw_bill_ranap_detail_tindakan_perawat_list->GetFilterList() ?>;
fvw_bill_ranap_detail_tindakan_perawatlistsrch.Init();
fvw_bill_ranap_detail_tindakan_perawatlist.Init();
</script>
<?php
$vw_bill_ranap_detail_tindakan_perawat_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bill_ranap_detail_tindakan_perawat_list->Page_Terminate();
?>
