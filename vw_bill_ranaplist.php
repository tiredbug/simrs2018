<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bill_ranapinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_bill_ranap_detail_visitekonsul_doktergridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_konsul_doktergridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tmnogridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_perawatgridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_visite_gizigridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_visite_farmasigridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_penunjanggridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_konsul_vctgridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_pelayanan_losgridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_laingridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_kebidanangridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bill_ranap_list = NULL; // Initialize page object first

class cvw_bill_ranap_list extends cvw_bill_ranap {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bill_ranap';

	// Page object name
	var $PageObjName = 'vw_bill_ranap_list';

	// Grid form hidden field names
	var $FormName = 'fvw_bill_ranaplist';
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

		// Table object (vw_bill_ranap)
		if (!isset($GLOBALS["vw_bill_ranap"]) || get_class($GLOBALS["vw_bill_ranap"]) == "cvw_bill_ranap") {
			$GLOBALS["vw_bill_ranap"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bill_ranap"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "vw_bill_ranapadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "vw_bill_ranapdelete.php";
		$this->MultiUpdateUrl = "vw_bill_ranapupdate.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bill_ranap', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fvw_bill_ranaplistsrch";

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
		$this->statusbayar->SetVisibility();
		$this->masukrs->SetVisibility();
		$this->noruang->SetVisibility();
		$this->KELASPERAWATAN_ID->SetVisibility();
		$this->nott->SetVisibility();

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

			// Process auto fill for detail table 'vw_bill_ranap_detail_visitekonsul_dokter'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_visitekonsul_doktergrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid;
				$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_konsul_dokter'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_konsul_doktergrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid;
				$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tmno'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tmnogrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"])) $GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid;
				$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_perawat'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_perawatgrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_visite_gizi'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_visite_gizigrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid;
				$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_visite_farmasi'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_visite_farmasigrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid;
				$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_penunjang'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_penunjanggrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_konsul_vct'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_konsul_vctgrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid;
				$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_pelayanan_los'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_pelayanan_losgrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"])) $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid;
				$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_lain'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_laingrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_kebidanan'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_kebidanangrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"] = new cvw_bill_ranap_detail_tindakan_kebidanan_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->Page_Init();
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
		global $EW_EXPORT, $vw_bill_ranap;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bill_ranap);
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
			$sSavedFilterList = isset($UserProfile) ? $UserProfile->GetSearchFilters(CurrentUserName(), "fvw_bill_ranaplistsrch") : "";
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id_admission->AdvancedSearch->ToJSON(), ","); // Field id_admission
		$sFilterList = ew_Concat($sFilterList, $this->nomr->AdvancedSearch->ToJSON(), ","); // Field nomr
		$sFilterList = ew_Concat($sFilterList, $this->ket_nama->AdvancedSearch->ToJSON(), ","); // Field ket_nama
		$sFilterList = ew_Concat($sFilterList, $this->parent_nomr->AdvancedSearch->ToJSON(), ","); // Field parent_nomr
		$sFilterList = ew_Concat($sFilterList, $this->dokterpengirim->AdvancedSearch->ToJSON(), ","); // Field dokterpengirim
		$sFilterList = ew_Concat($sFilterList, $this->statusbayar->AdvancedSearch->ToJSON(), ","); // Field statusbayar
		$sFilterList = ew_Concat($sFilterList, $this->kirimdari->AdvancedSearch->ToJSON(), ","); // Field kirimdari
		$sFilterList = ew_Concat($sFilterList, $this->keluargadekat->AdvancedSearch->ToJSON(), ","); // Field keluargadekat
		$sFilterList = ew_Concat($sFilterList, $this->panggungjawab->AdvancedSearch->ToJSON(), ","); // Field panggungjawab
		$sFilterList = ew_Concat($sFilterList, $this->masukrs->AdvancedSearch->ToJSON(), ","); // Field masukrs
		$sFilterList = ew_Concat($sFilterList, $this->noruang->AdvancedSearch->ToJSON(), ","); // Field noruang
		$sFilterList = ew_Concat($sFilterList, $this->tempat_tidur_id->AdvancedSearch->ToJSON(), ","); // Field tempat_tidur_id
		$sFilterList = ew_Concat($sFilterList, $this->keluarrs->AdvancedSearch->ToJSON(), ","); // Field keluarrs
		$sFilterList = ew_Concat($sFilterList, $this->icd_masuk->AdvancedSearch->ToJSON(), ","); // Field icd_masuk
		$sFilterList = ew_Concat($sFilterList, $this->icd_keluar->AdvancedSearch->ToJSON(), ","); // Field icd_keluar
		$sFilterList = ew_Concat($sFilterList, $this->NIP->AdvancedSearch->ToJSON(), ","); // Field NIP
		$sFilterList = ew_Concat($sFilterList, $this->kd_rujuk->AdvancedSearch->ToJSON(), ","); // Field kd_rujuk
		$sFilterList = ew_Concat($sFilterList, $this->st_bayar->AdvancedSearch->ToJSON(), ","); // Field st_bayar
		$sFilterList = ew_Concat($sFilterList, $this->dokter_penanggungjawab->AdvancedSearch->ToJSON(), ","); // Field dokter_penanggungjawab
		$sFilterList = ew_Concat($sFilterList, $this->perawat->AdvancedSearch->ToJSON(), ","); // Field perawat
		$sFilterList = ew_Concat($sFilterList, $this->KELASPERAWATAN_ID->AdvancedSearch->ToJSON(), ","); // Field KELASPERAWATAN_ID
		$sFilterList = ew_Concat($sFilterList, $this->NO_SKP->AdvancedSearch->ToJSON(), ","); // Field NO_SKP
		$sFilterList = ew_Concat($sFilterList, $this->ket_tgllahir->AdvancedSearch->ToJSON(), ","); // Field ket_tgllahir
		$sFilterList = ew_Concat($sFilterList, $this->ket_alamat->AdvancedSearch->ToJSON(), ","); // Field ket_alamat
		$sFilterList = ew_Concat($sFilterList, $this->ket_jeniskelamin->AdvancedSearch->ToJSON(), ","); // Field ket_jeniskelamin
		$sFilterList = ew_Concat($sFilterList, $this->ket_title->AdvancedSearch->ToJSON(), ","); // Field ket_title
		$sFilterList = ew_Concat($sFilterList, $this->grup_ruang_id->AdvancedSearch->ToJSON(), ","); // Field grup_ruang_id
		$sFilterList = ew_Concat($sFilterList, $this->nott->AdvancedSearch->ToJSON(), ","); // Field nott
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fvw_bill_ranaplistsrch", $filters);

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

		// Field ket_nama
		$this->ket_nama->AdvancedSearch->SearchValue = @$filter["x_ket_nama"];
		$this->ket_nama->AdvancedSearch->SearchOperator = @$filter["z_ket_nama"];
		$this->ket_nama->AdvancedSearch->SearchCondition = @$filter["v_ket_nama"];
		$this->ket_nama->AdvancedSearch->SearchValue2 = @$filter["y_ket_nama"];
		$this->ket_nama->AdvancedSearch->SearchOperator2 = @$filter["w_ket_nama"];
		$this->ket_nama->AdvancedSearch->Save();

		// Field parent_nomr
		$this->parent_nomr->AdvancedSearch->SearchValue = @$filter["x_parent_nomr"];
		$this->parent_nomr->AdvancedSearch->SearchOperator = @$filter["z_parent_nomr"];
		$this->parent_nomr->AdvancedSearch->SearchCondition = @$filter["v_parent_nomr"];
		$this->parent_nomr->AdvancedSearch->SearchValue2 = @$filter["y_parent_nomr"];
		$this->parent_nomr->AdvancedSearch->SearchOperator2 = @$filter["w_parent_nomr"];
		$this->parent_nomr->AdvancedSearch->Save();

		// Field dokterpengirim
		$this->dokterpengirim->AdvancedSearch->SearchValue = @$filter["x_dokterpengirim"];
		$this->dokterpengirim->AdvancedSearch->SearchOperator = @$filter["z_dokterpengirim"];
		$this->dokterpengirim->AdvancedSearch->SearchCondition = @$filter["v_dokterpengirim"];
		$this->dokterpengirim->AdvancedSearch->SearchValue2 = @$filter["y_dokterpengirim"];
		$this->dokterpengirim->AdvancedSearch->SearchOperator2 = @$filter["w_dokterpengirim"];
		$this->dokterpengirim->AdvancedSearch->Save();

		// Field statusbayar
		$this->statusbayar->AdvancedSearch->SearchValue = @$filter["x_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchOperator = @$filter["z_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchCondition = @$filter["v_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchValue2 = @$filter["y_statusbayar"];
		$this->statusbayar->AdvancedSearch->SearchOperator2 = @$filter["w_statusbayar"];
		$this->statusbayar->AdvancedSearch->Save();

		// Field kirimdari
		$this->kirimdari->AdvancedSearch->SearchValue = @$filter["x_kirimdari"];
		$this->kirimdari->AdvancedSearch->SearchOperator = @$filter["z_kirimdari"];
		$this->kirimdari->AdvancedSearch->SearchCondition = @$filter["v_kirimdari"];
		$this->kirimdari->AdvancedSearch->SearchValue2 = @$filter["y_kirimdari"];
		$this->kirimdari->AdvancedSearch->SearchOperator2 = @$filter["w_kirimdari"];
		$this->kirimdari->AdvancedSearch->Save();

		// Field keluargadekat
		$this->keluargadekat->AdvancedSearch->SearchValue = @$filter["x_keluargadekat"];
		$this->keluargadekat->AdvancedSearch->SearchOperator = @$filter["z_keluargadekat"];
		$this->keluargadekat->AdvancedSearch->SearchCondition = @$filter["v_keluargadekat"];
		$this->keluargadekat->AdvancedSearch->SearchValue2 = @$filter["y_keluargadekat"];
		$this->keluargadekat->AdvancedSearch->SearchOperator2 = @$filter["w_keluargadekat"];
		$this->keluargadekat->AdvancedSearch->Save();

		// Field panggungjawab
		$this->panggungjawab->AdvancedSearch->SearchValue = @$filter["x_panggungjawab"];
		$this->panggungjawab->AdvancedSearch->SearchOperator = @$filter["z_panggungjawab"];
		$this->panggungjawab->AdvancedSearch->SearchCondition = @$filter["v_panggungjawab"];
		$this->panggungjawab->AdvancedSearch->SearchValue2 = @$filter["y_panggungjawab"];
		$this->panggungjawab->AdvancedSearch->SearchOperator2 = @$filter["w_panggungjawab"];
		$this->panggungjawab->AdvancedSearch->Save();

		// Field masukrs
		$this->masukrs->AdvancedSearch->SearchValue = @$filter["x_masukrs"];
		$this->masukrs->AdvancedSearch->SearchOperator = @$filter["z_masukrs"];
		$this->masukrs->AdvancedSearch->SearchCondition = @$filter["v_masukrs"];
		$this->masukrs->AdvancedSearch->SearchValue2 = @$filter["y_masukrs"];
		$this->masukrs->AdvancedSearch->SearchOperator2 = @$filter["w_masukrs"];
		$this->masukrs->AdvancedSearch->Save();

		// Field noruang
		$this->noruang->AdvancedSearch->SearchValue = @$filter["x_noruang"];
		$this->noruang->AdvancedSearch->SearchOperator = @$filter["z_noruang"];
		$this->noruang->AdvancedSearch->SearchCondition = @$filter["v_noruang"];
		$this->noruang->AdvancedSearch->SearchValue2 = @$filter["y_noruang"];
		$this->noruang->AdvancedSearch->SearchOperator2 = @$filter["w_noruang"];
		$this->noruang->AdvancedSearch->Save();

		// Field tempat_tidur_id
		$this->tempat_tidur_id->AdvancedSearch->SearchValue = @$filter["x_tempat_tidur_id"];
		$this->tempat_tidur_id->AdvancedSearch->SearchOperator = @$filter["z_tempat_tidur_id"];
		$this->tempat_tidur_id->AdvancedSearch->SearchCondition = @$filter["v_tempat_tidur_id"];
		$this->tempat_tidur_id->AdvancedSearch->SearchValue2 = @$filter["y_tempat_tidur_id"];
		$this->tempat_tidur_id->AdvancedSearch->SearchOperator2 = @$filter["w_tempat_tidur_id"];
		$this->tempat_tidur_id->AdvancedSearch->Save();

		// Field keluarrs
		$this->keluarrs->AdvancedSearch->SearchValue = @$filter["x_keluarrs"];
		$this->keluarrs->AdvancedSearch->SearchOperator = @$filter["z_keluarrs"];
		$this->keluarrs->AdvancedSearch->SearchCondition = @$filter["v_keluarrs"];
		$this->keluarrs->AdvancedSearch->SearchValue2 = @$filter["y_keluarrs"];
		$this->keluarrs->AdvancedSearch->SearchOperator2 = @$filter["w_keluarrs"];
		$this->keluarrs->AdvancedSearch->Save();

		// Field icd_masuk
		$this->icd_masuk->AdvancedSearch->SearchValue = @$filter["x_icd_masuk"];
		$this->icd_masuk->AdvancedSearch->SearchOperator = @$filter["z_icd_masuk"];
		$this->icd_masuk->AdvancedSearch->SearchCondition = @$filter["v_icd_masuk"];
		$this->icd_masuk->AdvancedSearch->SearchValue2 = @$filter["y_icd_masuk"];
		$this->icd_masuk->AdvancedSearch->SearchOperator2 = @$filter["w_icd_masuk"];
		$this->icd_masuk->AdvancedSearch->Save();

		// Field icd_keluar
		$this->icd_keluar->AdvancedSearch->SearchValue = @$filter["x_icd_keluar"];
		$this->icd_keluar->AdvancedSearch->SearchOperator = @$filter["z_icd_keluar"];
		$this->icd_keluar->AdvancedSearch->SearchCondition = @$filter["v_icd_keluar"];
		$this->icd_keluar->AdvancedSearch->SearchValue2 = @$filter["y_icd_keluar"];
		$this->icd_keluar->AdvancedSearch->SearchOperator2 = @$filter["w_icd_keluar"];
		$this->icd_keluar->AdvancedSearch->Save();

		// Field NIP
		$this->NIP->AdvancedSearch->SearchValue = @$filter["x_NIP"];
		$this->NIP->AdvancedSearch->SearchOperator = @$filter["z_NIP"];
		$this->NIP->AdvancedSearch->SearchCondition = @$filter["v_NIP"];
		$this->NIP->AdvancedSearch->SearchValue2 = @$filter["y_NIP"];
		$this->NIP->AdvancedSearch->SearchOperator2 = @$filter["w_NIP"];
		$this->NIP->AdvancedSearch->Save();

		// Field kd_rujuk
		$this->kd_rujuk->AdvancedSearch->SearchValue = @$filter["x_kd_rujuk"];
		$this->kd_rujuk->AdvancedSearch->SearchOperator = @$filter["z_kd_rujuk"];
		$this->kd_rujuk->AdvancedSearch->SearchCondition = @$filter["v_kd_rujuk"];
		$this->kd_rujuk->AdvancedSearch->SearchValue2 = @$filter["y_kd_rujuk"];
		$this->kd_rujuk->AdvancedSearch->SearchOperator2 = @$filter["w_kd_rujuk"];
		$this->kd_rujuk->AdvancedSearch->Save();

		// Field st_bayar
		$this->st_bayar->AdvancedSearch->SearchValue = @$filter["x_st_bayar"];
		$this->st_bayar->AdvancedSearch->SearchOperator = @$filter["z_st_bayar"];
		$this->st_bayar->AdvancedSearch->SearchCondition = @$filter["v_st_bayar"];
		$this->st_bayar->AdvancedSearch->SearchValue2 = @$filter["y_st_bayar"];
		$this->st_bayar->AdvancedSearch->SearchOperator2 = @$filter["w_st_bayar"];
		$this->st_bayar->AdvancedSearch->Save();

		// Field dokter_penanggungjawab
		$this->dokter_penanggungjawab->AdvancedSearch->SearchValue = @$filter["x_dokter_penanggungjawab"];
		$this->dokter_penanggungjawab->AdvancedSearch->SearchOperator = @$filter["z_dokter_penanggungjawab"];
		$this->dokter_penanggungjawab->AdvancedSearch->SearchCondition = @$filter["v_dokter_penanggungjawab"];
		$this->dokter_penanggungjawab->AdvancedSearch->SearchValue2 = @$filter["y_dokter_penanggungjawab"];
		$this->dokter_penanggungjawab->AdvancedSearch->SearchOperator2 = @$filter["w_dokter_penanggungjawab"];
		$this->dokter_penanggungjawab->AdvancedSearch->Save();

		// Field perawat
		$this->perawat->AdvancedSearch->SearchValue = @$filter["x_perawat"];
		$this->perawat->AdvancedSearch->SearchOperator = @$filter["z_perawat"];
		$this->perawat->AdvancedSearch->SearchCondition = @$filter["v_perawat"];
		$this->perawat->AdvancedSearch->SearchValue2 = @$filter["y_perawat"];
		$this->perawat->AdvancedSearch->SearchOperator2 = @$filter["w_perawat"];
		$this->perawat->AdvancedSearch->Save();

		// Field KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchValue = @$filter["x_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchOperator = @$filter["z_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchCondition = @$filter["v_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchValue2 = @$filter["y_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->SearchOperator2 = @$filter["w_KELASPERAWATAN_ID"];
		$this->KELASPERAWATAN_ID->AdvancedSearch->Save();

		// Field NO_SKP
		$this->NO_SKP->AdvancedSearch->SearchValue = @$filter["x_NO_SKP"];
		$this->NO_SKP->AdvancedSearch->SearchOperator = @$filter["z_NO_SKP"];
		$this->NO_SKP->AdvancedSearch->SearchCondition = @$filter["v_NO_SKP"];
		$this->NO_SKP->AdvancedSearch->SearchValue2 = @$filter["y_NO_SKP"];
		$this->NO_SKP->AdvancedSearch->SearchOperator2 = @$filter["w_NO_SKP"];
		$this->NO_SKP->AdvancedSearch->Save();

		// Field ket_tgllahir
		$this->ket_tgllahir->AdvancedSearch->SearchValue = @$filter["x_ket_tgllahir"];
		$this->ket_tgllahir->AdvancedSearch->SearchOperator = @$filter["z_ket_tgllahir"];
		$this->ket_tgllahir->AdvancedSearch->SearchCondition = @$filter["v_ket_tgllahir"];
		$this->ket_tgllahir->AdvancedSearch->SearchValue2 = @$filter["y_ket_tgllahir"];
		$this->ket_tgllahir->AdvancedSearch->SearchOperator2 = @$filter["w_ket_tgllahir"];
		$this->ket_tgllahir->AdvancedSearch->Save();

		// Field ket_alamat
		$this->ket_alamat->AdvancedSearch->SearchValue = @$filter["x_ket_alamat"];
		$this->ket_alamat->AdvancedSearch->SearchOperator = @$filter["z_ket_alamat"];
		$this->ket_alamat->AdvancedSearch->SearchCondition = @$filter["v_ket_alamat"];
		$this->ket_alamat->AdvancedSearch->SearchValue2 = @$filter["y_ket_alamat"];
		$this->ket_alamat->AdvancedSearch->SearchOperator2 = @$filter["w_ket_alamat"];
		$this->ket_alamat->AdvancedSearch->Save();

		// Field ket_jeniskelamin
		$this->ket_jeniskelamin->AdvancedSearch->SearchValue = @$filter["x_ket_jeniskelamin"];
		$this->ket_jeniskelamin->AdvancedSearch->SearchOperator = @$filter["z_ket_jeniskelamin"];
		$this->ket_jeniskelamin->AdvancedSearch->SearchCondition = @$filter["v_ket_jeniskelamin"];
		$this->ket_jeniskelamin->AdvancedSearch->SearchValue2 = @$filter["y_ket_jeniskelamin"];
		$this->ket_jeniskelamin->AdvancedSearch->SearchOperator2 = @$filter["w_ket_jeniskelamin"];
		$this->ket_jeniskelamin->AdvancedSearch->Save();

		// Field ket_title
		$this->ket_title->AdvancedSearch->SearchValue = @$filter["x_ket_title"];
		$this->ket_title->AdvancedSearch->SearchOperator = @$filter["z_ket_title"];
		$this->ket_title->AdvancedSearch->SearchCondition = @$filter["v_ket_title"];
		$this->ket_title->AdvancedSearch->SearchValue2 = @$filter["y_ket_title"];
		$this->ket_title->AdvancedSearch->SearchOperator2 = @$filter["w_ket_title"];
		$this->ket_title->AdvancedSearch->Save();

		// Field grup_ruang_id
		$this->grup_ruang_id->AdvancedSearch->SearchValue = @$filter["x_grup_ruang_id"];
		$this->grup_ruang_id->AdvancedSearch->SearchOperator = @$filter["z_grup_ruang_id"];
		$this->grup_ruang_id->AdvancedSearch->SearchCondition = @$filter["v_grup_ruang_id"];
		$this->grup_ruang_id->AdvancedSearch->SearchValue2 = @$filter["y_grup_ruang_id"];
		$this->grup_ruang_id->AdvancedSearch->SearchOperator2 = @$filter["w_grup_ruang_id"];
		$this->grup_ruang_id->AdvancedSearch->Save();

		// Field nott
		$this->nott->AdvancedSearch->SearchValue = @$filter["x_nott"];
		$this->nott->AdvancedSearch->SearchOperator = @$filter["z_nott"];
		$this->nott->AdvancedSearch->SearchCondition = @$filter["v_nott"];
		$this->nott->AdvancedSearch->SearchValue2 = @$filter["y_nott"];
		$this->nott->AdvancedSearch->SearchOperator2 = @$filter["w_nott"];
		$this->nott->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nomr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket_nama, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->parent_nomr, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->keluargadekat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->panggungjawab, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->icd_masuk, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->icd_keluar, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NIP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NO_SKP, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket_alamat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket_jeniskelamin, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ket_title, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nott, $arKeywords, $type);
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
			$this->UpdateSort($this->id_admission, $bCtrl); // id_admission
			$this->UpdateSort($this->nomr, $bCtrl); // nomr
			$this->UpdateSort($this->statusbayar, $bCtrl); // statusbayar
			$this->UpdateSort($this->masukrs, $bCtrl); // masukrs
			$this->UpdateSort($this->noruang, $bCtrl); // noruang
			$this->UpdateSort($this->KELASPERAWATAN_ID, $bCtrl); // KELASPERAWATAN_ID
			$this->UpdateSort($this->nott, $bCtrl); // nott
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
				$this->id_admission->setSort("DESC");
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
				$this->statusbayar->setSort("");
				$this->masukrs->setSort("");
				$this->noruang->setSort("");
				$this->KELASPERAWATAN_ID->setSort("");
				$this->nott->setSort("");
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

		// "detail_vw_bill_ranap_detail_visitekonsul_dokter"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_visitekonsul_dokter");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visitekonsul_dokter') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid;

		// "detail_vw_bill_ranap_detail_konsul_dokter"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_konsul_dokter");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_dokter') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid;

		// "detail_vw_bill_ranap_detail_tmno"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_tmno");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tmno') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"])) $GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid;

		// "detail_vw_bill_ranap_detail_tindakan_perawat"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_tindakan_perawat");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_perawat') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid;

		// "detail_vw_bill_ranap_detail_visite_gizi"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_visite_gizi");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visite_gizi') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid;

		// "detail_vw_bill_ranap_detail_visite_farmasi"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_visite_farmasi");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visite_farmasi') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid;

		// "detail_vw_bill_ranap_detail_tindakan_penunjang"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_tindakan_penunjang");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_penunjang') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid;

		// "detail_vw_bill_ranap_detail_konsul_vct"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_konsul_vct");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_vct') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid;

		// "detail_vw_bill_ranap_detail_pelayanan_los"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_pelayanan_los");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_pelayanan_los') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"])) $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid;

		// "detail_vw_bill_ranap_detail_tindakan_lain"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_tindakan_lain");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_lain') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid;

		// "detail_vw_bill_ranap_detail_tindakan_kebidanan"
		$item = &$this->ListOptions->Add("detail_vw_bill_ranap_detail_tindakan_kebidanan");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_kebidanan') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"] = new cvw_bill_ranap_detail_tindakan_kebidanan_grid;

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
		$pages->Add("vw_bill_ranap_detail_visitekonsul_dokter");
		$pages->Add("vw_bill_ranap_detail_konsul_dokter");
		$pages->Add("vw_bill_ranap_detail_tmno");
		$pages->Add("vw_bill_ranap_detail_tindakan_perawat");
		$pages->Add("vw_bill_ranap_detail_visite_gizi");
		$pages->Add("vw_bill_ranap_detail_visite_farmasi");
		$pages->Add("vw_bill_ranap_detail_tindakan_penunjang");
		$pages->Add("vw_bill_ranap_detail_konsul_vct");
		$pages->Add("vw_bill_ranap_detail_pelayanan_los");
		$pages->Add("vw_bill_ranap_detail_tindakan_lain");
		$pages->Add("vw_bill_ranap_detail_tindakan_kebidanan");
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

		// "detail_vw_bill_ranap_detail_visitekonsul_dokter"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_visitekonsul_dokter"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visitekonsul_dokter')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_visitekonsul_dokter", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_visitekonsul_dokterlist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "&fk_noruang=" . urlencode(strval($this->noruang->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_visitekonsul_dokter')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_visitekonsul_dokter")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_visitekonsul_dokter";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_konsul_dokter"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_konsul_dokter"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_dokter')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_konsul_dokter", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_konsul_dokterlist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "&fk_noruang=" . urlencode(strval($this->noruang->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_dokter')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_konsul_dokter")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_konsul_dokter";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_tmno"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_tmno"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tmno')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_tmno", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_tmnolist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "&fk_noruang=" . urlencode(strval($this->noruang->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_tmno')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tmno")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_tmno";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_tindakan_perawat"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_tindakan_perawat"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_perawat')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_tindakan_perawat", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_tindakan_perawatlist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "&fk_noruang=" . urlencode(strval($this->noruang->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_perawat')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_perawat")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_tindakan_perawat";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_visite_gizi"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_visite_gizi"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visite_gizi')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_visite_gizi", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_visite_gizilist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "&fk_noruang=" . urlencode(strval($this->noruang->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_visite_gizi')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_visite_gizi")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_visite_gizi";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_visite_farmasi"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_visite_farmasi"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_visite_farmasi')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_visite_farmasi", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_visite_farmasilist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "&fk_noruang=" . urlencode(strval($this->noruang->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_visite_farmasi')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_visite_farmasi")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_visite_farmasi";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_tindakan_penunjang"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_tindakan_penunjang"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_penunjang')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_tindakan_penunjang", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_tindakan_penunjanglist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_penunjang')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_penunjang")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_tindakan_penunjang";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_konsul_vct"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_konsul_vct"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_vct')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_konsul_vct", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_konsul_vctlist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_vct')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_konsul_vct")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_konsul_vct";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_pelayanan_los"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_pelayanan_los"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_pelayanan_los')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_pelayanan_los", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_pelayanan_loslist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_pelayanan_los')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_pelayanan_los")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_pelayanan_los";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_tindakan_lain"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_tindakan_lain"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_lain')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_tindakan_lain", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_tindakan_lainlist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_lain')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_lain")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_tindakan_lain";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default ewDetail btn-xs\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_vw_bill_ranap_detail_tindakan_kebidanan"
		$oListOpt = &$this->ListOptions->Items["detail_vw_bill_ranap_detail_tindakan_kebidanan"];
		if ($Security->AllowList(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_kebidanan')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("vw_bill_ranap_detail_tindakan_kebidanan", "TblCaption");
			$body = "<a class=\"btn btn-default ewRowLink ewDetail btn-xs line-2139\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_bill_ranap_detail_tindakan_kebidananlist.php?" . EW_TABLE_SHOW_MASTER . "=vw_bill_ranap&fk_id_admission=" . urlencode(strval($this->id_admission->CurrentValue)) . "&fk_nomr=" . urlencode(strval($this->nomr->CurrentValue)) . "&fk_statusbayar=" . urlencode(strval($this->statusbayar->CurrentValue)) . "&fk_KELASPERAWATAN_ID=" . urlencode(strval($this->KELASPERAWATAN_ID->CurrentValue)) . "&fk_noruang=" . urlencode(strval($this->noruang->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_kebidanan')) {
				$links .= "<li><a class=\"btn btn-warning btn-xs\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_kebidanan")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "vw_bill_ranap_detail_tindakan_kebidanan";
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
		$oListOpt->Body = "<label><input class=\"magic-checkbox ewPointer\" type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id_admission->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'><span></span></label>";
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
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_visitekonsul_dokter");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_visitekonsul_dokter");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_visitekonsul_dokter') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_visitekonsul_dokter";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_konsul_dokter");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_konsul_dokter");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_dokter') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_konsul_dokter";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_tmno");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tmno");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_tmno"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_tmno"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_tmno') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_tmno";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_tindakan_perawat");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_perawat");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_perawat') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_tindakan_perawat";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_visite_gizi");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_visite_gizi");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_visite_gizi"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_visite_gizi"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_visite_gizi') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_visite_gizi";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_visite_farmasi");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_visite_farmasi");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_visite_farmasi') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_visite_farmasi";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_tindakan_penunjang");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_penunjang");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_penunjang') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_tindakan_penunjang";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_konsul_vct");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_konsul_vct");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_konsul_vct"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_konsul_vct"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_konsul_vct') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_konsul_vct";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_pelayanan_los");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_pelayanan_los");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_pelayanan_los') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_pelayanan_los";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_tindakan_lain");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_lain");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_lain') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_tindakan_lain";
		}
		$item = &$option->Add("detailadd_vw_bill_ranap_detail_tindakan_kebidanan");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=vw_bill_ranap_detail_tindakan_kebidanan");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->TableCaption();
		$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'vw_bill_ranap_detail_tindakan_kebidanan') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_bill_ranap_detail_tindakan_kebidanan";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fvw_bill_ranaplistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fvw_bill_ranaplistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"btn btn-xs btn-default line-2540\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fvw_bill_ranaplist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fvw_bill_ranaplistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->ket_nama->setDbValue($rs->fields('ket_nama'));
		$this->parent_nomr->setDbValue($rs->fields('parent_nomr'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->icd_masuk->setDbValue($rs->fields('icd_masuk'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->kd_rujuk->setDbValue($rs->fields('kd_rujuk'));
		$this->st_bayar->setDbValue($rs->fields('st_bayar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->perawat->setDbValue($rs->fields('perawat'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->ket_tgllahir->setDbValue($rs->fields('ket_tgllahir'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->grup_ruang_id->setDbValue($rs->fields('grup_ruang_id'));
		$this->nott->setDbValue($rs->fields('nott'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->ket_nama->DbValue = $row['ket_nama'];
		$this->parent_nomr->DbValue = $row['parent_nomr'];
		$this->dokterpengirim->DbValue = $row['dokterpengirim'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kirimdari->DbValue = $row['kirimdari'];
		$this->keluargadekat->DbValue = $row['keluargadekat'];
		$this->panggungjawab->DbValue = $row['panggungjawab'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->keluarrs->DbValue = $row['keluarrs'];
		$this->icd_masuk->DbValue = $row['icd_masuk'];
		$this->icd_keluar->DbValue = $row['icd_keluar'];
		$this->NIP->DbValue = $row['NIP'];
		$this->kd_rujuk->DbValue = $row['kd_rujuk'];
		$this->st_bayar->DbValue = $row['st_bayar'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->perawat->DbValue = $row['perawat'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->ket_tgllahir->DbValue = $row['ket_tgllahir'];
		$this->ket_alamat->DbValue = $row['ket_alamat'];
		$this->ket_jeniskelamin->DbValue = $row['ket_jeniskelamin'];
		$this->ket_title->DbValue = $row['ket_title'];
		$this->grup_ruang_id->DbValue = $row['grup_ruang_id'];
		$this->nott->DbValue = $row['nott'];
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
		// parent_nomr
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// keluarrs
		// icd_masuk
		// icd_keluar
		// NIP
		// kd_rujuk
		// st_bayar
		// dokter_penanggungjawab
		// perawat
		// KELASPERAWATAN_ID
		// NO_SKP
		// ket_tgllahir
		// ket_alamat
		// ket_jeniskelamin
		// ket_title
		// grup_ruang_id
		// nott

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		if (strval($this->nomr->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->nomr->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->nomr->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->nomr->ViewValue = $this->nomr->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomr->ViewValue = $this->nomr->CurrentValue;
			}
		} else {
			$this->nomr->ViewValue = NULL;
		}
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// parent_nomr
		$this->parent_nomr->ViewValue = $this->parent_nomr->CurrentValue;
		$this->parent_nomr->ViewCustomAttributes = "";

		// dokterpengirim
		if (strval($this->dokterpengirim->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokterpengirim->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokterpengirim->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->CurrentValue;
			}
		} else {
			$this->dokterpengirim->ViewValue = NULL;
		}
		$this->dokterpengirim->ViewCustomAttributes = "";

		// statusbayar
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

		// kirimdari
		if (strval($this->kirimdari->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kirimdari->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->kirimdari->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kirimdari->ViewValue = $this->kirimdari->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
			}
		} else {
			$this->kirimdari->ViewValue = NULL;
		}
		$this->kirimdari->ViewCustomAttributes = "";

		// keluargadekat
		$this->keluargadekat->ViewValue = $this->keluargadekat->CurrentValue;
		$this->keluargadekat->ViewCustomAttributes = "";

		// panggungjawab
		$this->panggungjawab->ViewValue = $this->panggungjawab->CurrentValue;
		$this->panggungjawab->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 11);
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

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 0);
		$this->keluarrs->ViewCustomAttributes = "";

		// icd_masuk
		$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
		if (strval($this->icd_masuk->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_masuk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
		$sWhereWrk = "";
		$this->icd_masuk->LookupFilters = array();
		$lookuptblfilter = "`CBG_USE_IND`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_masuk->ViewValue = $this->icd_masuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
			}
		} else {
			$this->icd_masuk->ViewValue = NULL;
		}
		$this->icd_masuk->ViewCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		$this->icd_keluar->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// kd_rujuk
		if (strval($this->kd_rujuk->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->kd_rujuk->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->kd_rujuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->CurrentValue;
			}
		} else {
			$this->kd_rujuk->ViewValue = NULL;
		}
		$this->kd_rujuk->ViewCustomAttributes = "";

		// st_bayar
		$this->st_bayar->ViewValue = $this->st_bayar->CurrentValue;
		$this->st_bayar->ViewCustomAttributes = "";

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

		// perawat
		$this->perawat->ViewValue = $this->perawat->CurrentValue;
		$this->perawat->ViewCustomAttributes = "";

		// KELASPERAWATAN_ID
		if (strval($this->KELASPERAWATAN_ID->CurrentValue) <> "") {
			$sFilterWrk = "`kelasperawatan_id`" . ew_SearchString("=", $this->KELASPERAWATAN_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kelasperawatan_id`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_kelas_perawatan`";
		$sWhereWrk = "";
		$this->KELASPERAWATAN_ID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
			}
		} else {
			$this->KELASPERAWATAN_ID->ViewValue = NULL;
		}
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// ket_tgllahir
		$this->ket_tgllahir->ViewValue = $this->ket_tgllahir->CurrentValue;
		$this->ket_tgllahir->ViewValue = ew_FormatDateTime($this->ket_tgllahir->ViewValue, 0);
		$this->ket_tgllahir->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// grup_ruang_id
		$this->grup_ruang_id->ViewValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->ViewCustomAttributes = "";

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

			// id_admission
			$this->id_admission->LinkCustomAttributes = "";
			$this->id_admission->HrefValue = "";
			$this->id_admission->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

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

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";
			$this->nott->TooltipValue = "";
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
		$r = Security()->CurrentUserLevelID();
		if($r==5)
		{
			$this->OtherOptions['addedit'] = new cListOptions();
			$this->OtherOptions['addedit']->Body = "";
			$this->OtherOptions['detail'] = new cListOptions();
			$this->OtherOptions['detail']->Body = "";
		}
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = echo "ID Halaman: ".CurrentPageID();

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
		//$this->ListOptions->Items["details"]->Visible = FALSE;
		//$this->ListOptions->Items["edit"]->Visible = FALSE;

		$r = Security()->CurrentUserLevelID();
		if($r==5)
		{

			//$this->ListOptions->Items["details"]->Visible = FALSE;
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
if (!isset($vw_bill_ranap_list)) $vw_bill_ranap_list = new cvw_bill_ranap_list();

// Page init
$vw_bill_ranap_list->Page_Init();

// Page main
$vw_bill_ranap_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fvw_bill_ranaplist = new ew_Form("fvw_bill_ranaplist", "list");
fvw_bill_ranaplist.FormKeyCountName = '<?php echo $vw_bill_ranap_list->FormKeyCountName ?>';

// Form_CustomValidate event
fvw_bill_ranaplist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranaplist.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranaplist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranaplist.Lists["x_nomr"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_bill_ranaplist.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_bill_ranaplist.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
fvw_bill_ranaplist.Lists["x_KELASPERAWATAN_ID"] = {"LinkField":"x_kelasperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kelasperawatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_kelas_perawatan"};

// Form object for search
var CurrentSearchForm = fvw_bill_ranaplistsrch = new ew_Form("fvw_bill_ranaplistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if ($vw_bill_ranap_list->TotalRecs > 0 && $vw_bill_ranap_list->ExportOptions->Visible()) { ?>
<?php $vw_bill_ranap_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bill_ranap_list->SearchOptions->Visible()) { ?>
<?php $vw_bill_ranap_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($vw_bill_ranap_list->FilterOptions->Visible()) { ?>
<?php $vw_bill_ranap_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
<?php
	$bSelectLimit = $vw_bill_ranap_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($vw_bill_ranap_list->TotalRecs <= 0)
			$vw_bill_ranap_list->TotalRecs = $vw_bill_ranap->SelectRecordCount();
	} else {
		if (!$vw_bill_ranap_list->Recordset && ($vw_bill_ranap_list->Recordset = $vw_bill_ranap_list->LoadRecordset()))
			$vw_bill_ranap_list->TotalRecs = $vw_bill_ranap_list->Recordset->RecordCount();
	}
	$vw_bill_ranap_list->StartRec = 1;
	if ($vw_bill_ranap_list->DisplayRecs <= 0 || ($vw_bill_ranap->Export <> "" && $vw_bill_ranap->ExportAll)) // Display all records
		$vw_bill_ranap_list->DisplayRecs = $vw_bill_ranap_list->TotalRecs;
	if (!($vw_bill_ranap->Export <> "" && $vw_bill_ranap->ExportAll))
		$vw_bill_ranap_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$vw_bill_ranap_list->Recordset = $vw_bill_ranap_list->LoadRecordset($vw_bill_ranap_list->StartRec-1, $vw_bill_ranap_list->DisplayRecs);

	// Set no record found message
	if ($vw_bill_ranap->CurrentAction == "" && $vw_bill_ranap_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$vw_bill_ranap_list->setWarningMessage(ew_DeniedMsg());
		if ($vw_bill_ranap_list->SearchWhere == "0=101")
			$vw_bill_ranap_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$vw_bill_ranap_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($vw_bill_ranap_list->AuditTrailOnSearch && $vw_bill_ranap_list->Command == "search" && !$vw_bill_ranap_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $vw_bill_ranap_list->getSessionWhere();
		$vw_bill_ranap_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$vw_bill_ranap_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($vw_bill_ranap->Export == "" && $vw_bill_ranap->CurrentAction == "") { ?>
<form name="fvw_bill_ranaplistsrch" id="fvw_bill_ranaplistsrch" class="form-horizontal ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($vw_bill_ranap_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fvw_bill_ranaplistsrch_SearchPanel" class="box box-default collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="vw_bill_ranap">
<div class="box-body">
<div id="xsr_1">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($vw_bill_ranap_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($vw_bill_ranap_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $vw_bill_ranap_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($vw_bill_ranap_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($vw_bill_ranap_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($vw_bill_ranap_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($vw_bill_ranap_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $vw_bill_ranap_list->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_list->ShowMessage();
?>
<?php if ($vw_bill_ranap_list->TotalRecs > 0 || $vw_bill_ranap->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid vw_bill_ranap">
<form name="fvw_bill_ranaplist" id="fvw_bill_ranaplist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bill_ranap_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bill_ranap_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bill_ranap">
<div id="gmp_vw_bill_ranap" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>box box-primary">
<?php if ($vw_bill_ranap_list->TotalRecs > 0 || $vw_bill_ranap->CurrentAction == "gridedit") { ?>
<table id="tbl_vw_bill_ranaplist" class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$vw_bill_ranap_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$vw_bill_ranap_list->RenderListOptions();

// Render list options (header, left)
$vw_bill_ranap_list->ListOptions->Render("header", "left");
?>
<?php if ($vw_bill_ranap->id_admission->Visible) { // id_admission ?>
	<?php if ($vw_bill_ranap->SortUrl($vw_bill_ranap->id_admission) == "") { ?>
		<th data-name="id_admission"><div id="elh_vw_bill_ranap_id_admission" class="vw_bill_ranap_id_admission"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->id_admission->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id_admission"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap->SortUrl($vw_bill_ranap->id_admission) ?>',2);"><div id="elh_vw_bill_ranap_id_admission" class="vw_bill_ranap_id_admission">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->id_admission->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap->id_admission->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap->id_admission->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap->nomr->Visible) { // nomr ?>
	<?php if ($vw_bill_ranap->SortUrl($vw_bill_ranap->nomr) == "") { ?>
		<th data-name="nomr"><div id="elh_vw_bill_ranap_nomr" class="vw_bill_ranap_nomr"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->nomr->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomr"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap->SortUrl($vw_bill_ranap->nomr) ?>',2);"><div id="elh_vw_bill_ranap_nomr" class="vw_bill_ranap_nomr">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->nomr->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap->nomr->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap->nomr->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap->statusbayar->Visible) { // statusbayar ?>
	<?php if ($vw_bill_ranap->SortUrl($vw_bill_ranap->statusbayar) == "") { ?>
		<th data-name="statusbayar"><div id="elh_vw_bill_ranap_statusbayar" class="vw_bill_ranap_statusbayar"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->statusbayar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="statusbayar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap->SortUrl($vw_bill_ranap->statusbayar) ?>',2);"><div id="elh_vw_bill_ranap_statusbayar" class="vw_bill_ranap_statusbayar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->statusbayar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap->statusbayar->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap->statusbayar->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap->masukrs->Visible) { // masukrs ?>
	<?php if ($vw_bill_ranap->SortUrl($vw_bill_ranap->masukrs) == "") { ?>
		<th data-name="masukrs"><div id="elh_vw_bill_ranap_masukrs" class="vw_bill_ranap_masukrs"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->masukrs->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="masukrs"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap->SortUrl($vw_bill_ranap->masukrs) ?>',2);"><div id="elh_vw_bill_ranap_masukrs" class="vw_bill_ranap_masukrs">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->masukrs->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap->masukrs->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap->masukrs->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap->noruang->Visible) { // noruang ?>
	<?php if ($vw_bill_ranap->SortUrl($vw_bill_ranap->noruang) == "") { ?>
		<th data-name="noruang"><div id="elh_vw_bill_ranap_noruang" class="vw_bill_ranap_noruang"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->noruang->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="noruang"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap->SortUrl($vw_bill_ranap->noruang) ?>',2);"><div id="elh_vw_bill_ranap_noruang" class="vw_bill_ranap_noruang">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->noruang->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap->noruang->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap->noruang->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<?php if ($vw_bill_ranap->SortUrl($vw_bill_ranap->KELASPERAWATAN_ID) == "") { ?>
		<th data-name="KELASPERAWATAN_ID"><div id="elh_vw_bill_ranap_KELASPERAWATAN_ID" class="vw_bill_ranap_KELASPERAWATAN_ID"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->KELASPERAWATAN_ID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="KELASPERAWATAN_ID"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap->SortUrl($vw_bill_ranap->KELASPERAWATAN_ID) ?>',2);"><div id="elh_vw_bill_ranap_KELASPERAWATAN_ID" class="vw_bill_ranap_KELASPERAWATAN_ID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->KELASPERAWATAN_ID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap->KELASPERAWATAN_ID->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap->KELASPERAWATAN_ID->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($vw_bill_ranap->nott->Visible) { // nott ?>
	<?php if ($vw_bill_ranap->SortUrl($vw_bill_ranap->nott) == "") { ?>
		<th data-name="nott"><div id="elh_vw_bill_ranap_nott" class="vw_bill_ranap_nott"><div class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->nott->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nott"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $vw_bill_ranap->SortUrl($vw_bill_ranap->nott) ?>',2);"><div id="elh_vw_bill_ranap_nott" class="vw_bill_ranap_nott">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $vw_bill_ranap->nott->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($vw_bill_ranap->nott->getSort() == "ASC") { ?> <i class="fa fa-sort-amount-asc text-muted"></i><?php } elseif ($vw_bill_ranap->nott->getSort() == "DESC") { ?> <i class="fa fa-sort-amount-desc text-muted"></i><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$vw_bill_ranap_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($vw_bill_ranap->ExportAll && $vw_bill_ranap->Export <> "") {
	$vw_bill_ranap_list->StopRec = $vw_bill_ranap_list->TotalRecs;
} else {

	// Set the last record to display
	if ($vw_bill_ranap_list->TotalRecs > $vw_bill_ranap_list->StartRec + $vw_bill_ranap_list->DisplayRecs - 1)
		$vw_bill_ranap_list->StopRec = $vw_bill_ranap_list->StartRec + $vw_bill_ranap_list->DisplayRecs - 1;
	else
		$vw_bill_ranap_list->StopRec = $vw_bill_ranap_list->TotalRecs;
}
$vw_bill_ranap_list->RecCnt = $vw_bill_ranap_list->StartRec - 1;
if ($vw_bill_ranap_list->Recordset && !$vw_bill_ranap_list->Recordset->EOF) {
	$vw_bill_ranap_list->Recordset->MoveFirst();
	$bSelectLimit = $vw_bill_ranap_list->UseSelectLimit;
	if (!$bSelectLimit && $vw_bill_ranap_list->StartRec > 1)
		$vw_bill_ranap_list->Recordset->Move($vw_bill_ranap_list->StartRec - 1);
} elseif (!$vw_bill_ranap->AllowAddDeleteRow && $vw_bill_ranap_list->StopRec == 0) {
	$vw_bill_ranap_list->StopRec = $vw_bill_ranap->GridAddRowCount;
}

// Initialize aggregate
$vw_bill_ranap->RowType = EW_ROWTYPE_AGGREGATEINIT;
$vw_bill_ranap->ResetAttrs();
$vw_bill_ranap_list->RenderRow();
while ($vw_bill_ranap_list->RecCnt < $vw_bill_ranap_list->StopRec) {
	$vw_bill_ranap_list->RecCnt++;
	if (intval($vw_bill_ranap_list->RecCnt) >= intval($vw_bill_ranap_list->StartRec)) {
		$vw_bill_ranap_list->RowCnt++;

		// Set up key count
		$vw_bill_ranap_list->KeyCount = $vw_bill_ranap_list->RowIndex;

		// Init row class and style
		$vw_bill_ranap->ResetAttrs();
		$vw_bill_ranap->CssClass = "";
		if ($vw_bill_ranap->CurrentAction == "gridadd") {
		} else {
			$vw_bill_ranap_list->LoadRowValues($vw_bill_ranap_list->Recordset); // Load row values
		}
		$vw_bill_ranap->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$vw_bill_ranap->RowAttrs = array_merge($vw_bill_ranap->RowAttrs, array('data-rowindex'=>$vw_bill_ranap_list->RowCnt, 'id'=>'r' . $vw_bill_ranap_list->RowCnt . '_vw_bill_ranap', 'data-rowtype'=>$vw_bill_ranap->RowType));

		// Render row
		$vw_bill_ranap_list->RenderRow();

		// Render list options
		$vw_bill_ranap_list->RenderListOptions();
?>
	<tr<?php echo $vw_bill_ranap->RowAttributes() ?>>
<?php

// Render list options (body, left)
$vw_bill_ranap_list->ListOptions->Render("body", "left", $vw_bill_ranap_list->RowCnt);
?>
	<?php if ($vw_bill_ranap->id_admission->Visible) { // id_admission ?>
		<td data-name="id_admission"<?php echo $vw_bill_ranap->id_admission->CellAttributes() ?>>
<div id="orig<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_id_admission" class="hide">
<span id="el<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_id_admission" class="vw_bill_ranap_id_admission">
<span<?php echo $vw_bill_ranap->id_admission->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->id_admission->ListViewValue() ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r==5)
{ ?>
<div class="btn-group">
	<button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>   Pilihan Menu</button>
		<button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul style="background:#605CA8" class="dropdown-menu" role="menu" >
                  	<li class="divider"></li>
                    <li><a style="color:#ffffff" href="vw_bill_ranapedit.php?showdetail=vw_bill_ranap_detail_visitekonsul_dokter,vw_bill_ranap_detail_konsul_dokter,vw_bill_ranap_detail_tmno,vw_bill_ranap_detail_tindakan_perawat,vw_bill_ranap_detail_tindakan_kebidanan,vw_bill_ranap_detail_visite_gizi,vw_bill_ranap_detail_visite_farmasi,vw_bill_ranap_detail_tindakan_penunjang,vw_bill_ranap_detail_konsul_vct,vw_bill_ranap_detail_pelayanan_los,vw_bill_ranap_detail_tindakan_lain&id_admission=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>"><b>-  </b><b>Input Billing</b></a></li>
                    <li><a style="color:#ffffff" target="_self" href="vw_set_tanggal_pulangedit.php?id_admission=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>"><b>-  </b><b>Set Resume Pulang </b></a></li>
                    <li class="divider"></li>
                    <li><a style="color:#ffffff" target="_blank" href="cetak_tmno_rawat_inap.php?home=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>&p1=<?php echo urlencode(CurrentPage()->nomr->CurrentValue)?>&p2=<?php echo urlencode(CurrentPage()->statusbayar->CurrentValue) ?>&p3=<?php echo urlencode(CurrentPage()->KELASPERAWATAN_ID->CurrentValue) ?>"><b>-  </b><b>Cetak rincian TMNO </b></a></li>
                    <li><a style="color:#ffffff" target="_blank" href="cetak_rincian_adm_rawat_inap.php?home=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue)?>&p1=<?php echo urlencode(CurrentPage()->nomr->CurrentValue)?>&p2=<?php echo urlencode(CurrentPage()->statusbayar->CurrentValue) ?>&p3=<?php echo urlencode(CurrentPage()->KELASPERAWATAN_ID->CurrentValue) ?>"><b>-  </b><b>Cetak Rincian Adm/Inadrg </b></a></li>
                    <li class="divider"></li>
                  </ul>
</div>
<?php
}else { print '-'; }
?>
<a id="<?php echo $vw_bill_ranap_list->PageObjName . "_row_" . $vw_bill_ranap_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($vw_bill_ranap->nomr->Visible) { // nomr ?>
		<td data-name="nomr"<?php echo $vw_bill_ranap->nomr->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_nomr" class="vw_bill_ranap_nomr">
<span<?php echo $vw_bill_ranap->nomr->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->nomr->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap->statusbayar->Visible) { // statusbayar ?>
		<td data-name="statusbayar"<?php echo $vw_bill_ranap->statusbayar->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_statusbayar" class="vw_bill_ranap_statusbayar">
<span<?php echo $vw_bill_ranap->statusbayar->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->statusbayar->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap->masukrs->Visible) { // masukrs ?>
		<td data-name="masukrs"<?php echo $vw_bill_ranap->masukrs->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_masukrs" class="vw_bill_ranap_masukrs">
<span<?php echo $vw_bill_ranap->masukrs->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->masukrs->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap->noruang->Visible) { // noruang ?>
		<td data-name="noruang"<?php echo $vw_bill_ranap->noruang->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_noruang" class="vw_bill_ranap_noruang">
<span<?php echo $vw_bill_ranap->noruang->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->noruang->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
		<td data-name="KELASPERAWATAN_ID"<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_KELASPERAWATAN_ID" class="vw_bill_ranap_KELASPERAWATAN_ID">
<span<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($vw_bill_ranap->nott->Visible) { // nott ?>
		<td data-name="nott"<?php echo $vw_bill_ranap->nott->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_list->RowCnt ?>_vw_bill_ranap_nott" class="vw_bill_ranap_nott">
<span<?php echo $vw_bill_ranap->nott->ViewAttributes() ?>>
<?php echo $vw_bill_ranap->nott->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$vw_bill_ranap_list->ListOptions->Render("body", "right", $vw_bill_ranap_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($vw_bill_ranap->CurrentAction <> "gridadd")
		$vw_bill_ranap_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($vw_bill_ranap->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($vw_bill_ranap_list->Recordset)
	$vw_bill_ranap_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($vw_bill_ranap->CurrentAction <> "gridadd" && $vw_bill_ranap->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($vw_bill_ranap_list->Pager)) $vw_bill_ranap_list->Pager = new cPrevNextPager($vw_bill_ranap_list->StartRec, $vw_bill_ranap_list->DisplayRecs, $vw_bill_ranap_list->TotalRecs) ?>
<?php if ($vw_bill_ranap_list->Pager->RecordCount > 0 && $vw_bill_ranap_list->Pager->Visible) { ?>
<div class="text-center">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($vw_bill_ranap_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $vw_bill_ranap_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_list->Pager->FirstButton->Start ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="fa fa-fast-backward"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($vw_bill_ranap_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $vw_bill_ranap_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_list->Pager->PrevButton->Start ?>"><span class="fa fa-step-backward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="fa fa-step-backward"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $vw_bill_ranap_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($vw_bill_ranap_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $vw_bill_ranap_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_list->Pager->NextButton->Start ?>"><span class="fa fa-step-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="fa fa-step-forward"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($vw_bill_ranap_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $vw_bill_ranap_list->PageUrl() ?>start=<?php echo $vw_bill_ranap_list->Pager->LastButton->Start ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="fa fa-fast-forward"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $vw_bill_ranap_list->Pager->PageCount ?></span>
</div>
<div class="text-center">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $vw_bill_ranap_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $vw_bill_ranap_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $vw_bill_ranap_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_list->TotalRecs > 0 && (!EW_AUTO_HIDE_PAGE_SIZE_SELECTOR || $vw_bill_ranap_list->Pager->Visible)) { ?>
<div class="text-center">
<input type="hidden" name="t" value="vw_bill_ranap">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="5"<?php if ($vw_bill_ranap_list->DisplayRecs == 5) { ?> selected<?php } ?>>5</option>
<option value="10"<?php if ($vw_bill_ranap_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($vw_bill_ranap_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($vw_bill_ranap_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($vw_bill_ranap_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($vw_bill_ranap_list->TotalRecs == 0 && $vw_bill_ranap->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($vw_bill_ranap_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fvw_bill_ranaplistsrch.FilterList = <?php echo $vw_bill_ranap_list->GetFilterList() ?>;
fvw_bill_ranaplistsrch.Init();
fvw_bill_ranaplist.Init();
</script>
<?php
$vw_bill_ranap_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bill_ranap_list->Page_Terminate();
?>
