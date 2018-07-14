<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_kegiatan_tahunan_rsinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_kegiatan_tahunan_rs_add = NULL; // Initialize page object first

class cm_kegiatan_tahunan_rs_add extends cm_kegiatan_tahunan_rs {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_kegiatan_tahunan_rs';

	// Page object name
	var $PageObjName = 'm_kegiatan_tahunan_rs_add';

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

		// Table object (m_kegiatan_tahunan_rs)
		if (!isset($GLOBALS["m_kegiatan_tahunan_rs"]) || get_class($GLOBALS["m_kegiatan_tahunan_rs"]) == "cm_kegiatan_tahunan_rs") {
			$GLOBALS["m_kegiatan_tahunan_rs"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_kegiatan_tahunan_rs"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_kegiatan_tahunan_rs', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (m_login)
		if (!isset($UserTable)) {
			$UserTable = new cm_login();
			$UserTableConn = Conn($UserTable->DBID);
		}
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
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("m_kegiatan_tahunan_rslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->tahun->SetVisibility();
		$this->program->SetVisibility();
		$this->kode_kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();

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
		global $EW_EXPORT, $m_kegiatan_tahunan_rs;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_kegiatan_tahunan_rs);
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("m_kegiatan_tahunan_rslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "m_kegiatan_tahunan_rslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "m_kegiatan_tahunan_rsview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->tahun->CurrentValue = 2018;
		$this->program->CurrentValue = "1.02.037";
		$this->kode_kegiatan->CurrentValue = "1.02.037.0009";
		$this->sub_kegiatan->CurrentValue = NULL;
		$this->sub_kegiatan->OldValue = $this->sub_kegiatan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->tahun->FldIsDetailKey) {
			$this->tahun->setFormValue($objForm->GetValue("x_tahun"));
		}
		if (!$this->program->FldIsDetailKey) {
			$this->program->setFormValue($objForm->GetValue("x_program"));
		}
		if (!$this->kode_kegiatan->FldIsDetailKey) {
			$this->kode_kegiatan->setFormValue($objForm->GetValue("x_kode_kegiatan"));
		}
		if (!$this->sub_kegiatan->FldIsDetailKey) {
			$this->sub_kegiatan->setFormValue($objForm->GetValue("x_sub_kegiatan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->tahun->CurrentValue = $this->tahun->FormValue;
		$this->program->CurrentValue = $this->program->FormValue;
		$this->kode_kegiatan->CurrentValue = $this->kode_kegiatan->FormValue;
		$this->sub_kegiatan->CurrentValue = $this->sub_kegiatan->FormValue;
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
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->tahun->DbValue = $row['tahun'];
		$this->program->DbValue = $row['program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// tahun
		// program
		// kode_kegiatan
		// sub_kegiatan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// tahun
		if (strval($this->tahun->CurrentValue) <> "") {
			$this->tahun->ViewValue = $this->tahun->OptionCaption($this->tahun->CurrentValue);
		} else {
			$this->tahun->ViewValue = NULL;
		}
		$this->tahun->ViewCustomAttributes = "";

		// program
		if (strval($this->program->CurrentValue) <> "") {
			$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->program->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
		$sWhereWrk = "";
		$this->program->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->program, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->program->ViewValue = $this->program->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->program->ViewValue = $this->program->CurrentValue;
			}
		} else {
			$this->program->ViewValue = NULL;
		}
		$this->program->ViewCustomAttributes = "";

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

		// sub_kegiatan
		if (strval($this->sub_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
		$sWhereWrk = "";
		$this->sub_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
			}
		} else {
			$this->sub_kegiatan->ViewValue = NULL;
		}
		$this->sub_kegiatan->ViewCustomAttributes = "";

			// tahun
			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";
			$this->tahun->TooltipValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";
			$this->program->TooltipValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";
			$this->kode_kegiatan->TooltipValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";
			$this->sub_kegiatan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// tahun
			$this->tahun->EditAttrs["class"] = "form-control";
			$this->tahun->EditCustomAttributes = "";
			$this->tahun->EditValue = $this->tahun->Options(TRUE);

			// program
			$this->program->EditAttrs["class"] = "form-control";
			$this->program->EditCustomAttributes = "";
			if (trim(strval($this->program->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->program->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_program`";
			$sWhereWrk = "";
			$this->program->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->program, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->program->EditValue = $arwrk;

			// kode_kegiatan
			$this->kode_kegiatan->EditAttrs["class"] = "form-control";
			$this->kode_kegiatan->EditCustomAttributes = "";
			if (trim(strval($this->kode_kegiatan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kode_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kode_program` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_kegiatan`";
			$sWhereWrk = "";
			$this->kode_kegiatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kode_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kode_kegiatan->EditValue = $arwrk;

			// sub_kegiatan
			$this->sub_kegiatan->EditAttrs["class"] = "form-control";
			$this->sub_kegiatan->EditCustomAttributes = "";
			if (trim(strval($this->sub_kegiatan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kode_program` AS `SelectFilterFld`, `kode_kegiatan` AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_sub_kegiatan`";
			$sWhereWrk = "";
			$this->sub_kegiatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->sub_kegiatan->EditValue = $arwrk;

			// Add refer script
			// tahun

			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// tahun
		$this->tahun->SetDbValueDef($rsnew, $this->tahun->CurrentValue, NULL, FALSE);

		// program
		$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, FALSE);

		// kode_kegiatan
		$this->kode_kegiatan->SetDbValueDef($rsnew, $this->kode_kegiatan->CurrentValue, NULL, FALSE);

		// sub_kegiatan
		$this->sub_kegiatan->SetDbValueDef($rsnew, $this->sub_kegiatan->CurrentValue, NULL, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_kegiatan_tahunan_rslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_program":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode_program` AS `LinkFld`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
			$sWhereWrk = "";
			$this->program->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_program` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->program, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kode_kegiatan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode_kegiatan` AS `LinkFld`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
			$sWhereWrk = "{filter}";
			$this->kode_kegiatan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_kegiatan` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kode_program` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kode_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_sub_kegiatan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode_sub_kegiatan` AS `LinkFld`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
			$sWhereWrk = "{filter}";
			$this->sub_kegiatan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_sub_kegiatan` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kode_program` IN ({filter_value})', "t1" => "200", "fn1" => "", "f2" => '`kode_kegiatan` IN ({filter_value})', "t2" => "200", "fn2" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($m_kegiatan_tahunan_rs_add)) $m_kegiatan_tahunan_rs_add = new cm_kegiatan_tahunan_rs_add();

// Page init
$m_kegiatan_tahunan_rs_add->Page_Init();

// Page main
$m_kegiatan_tahunan_rs_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_kegiatan_tahunan_rs_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fm_kegiatan_tahunan_rsadd = new ew_Form("fm_kegiatan_tahunan_rsadd", "add");

// Validate form
fm_kegiatan_tahunan_rsadd.Validate = function() {
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

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fm_kegiatan_tahunan_rsadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_kegiatan_tahunan_rsadd.ValidateRequired = true;
<?php } else { ?>
fm_kegiatan_tahunan_rsadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_kegiatan_tahunan_rsadd.Lists["x_tahun"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fm_kegiatan_tahunan_rsadd.Lists["x_tahun"].Options = <?php echo json_encode($m_kegiatan_tahunan_rs->tahun->Options()) ?>;
fm_kegiatan_tahunan_rsadd.Lists["x_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kode_kegiatan","x_sub_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
fm_kegiatan_tahunan_rsadd.Lists["x_kode_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_program"],"ChildFields":["x_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
fm_kegiatan_tahunan_rsadd.Lists["x_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_program","x_kode_kegiatan"],"ChildFields":[],"FilterFields":["x_kode_program","x_kode_kegiatan"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_kegiatan_tahunan_rs_add->IsModal) { ?>
<?php } ?>
<?php $m_kegiatan_tahunan_rs_add->ShowPageHeader(); ?>
<?php
$m_kegiatan_tahunan_rs_add->ShowMessage();
?>
<form name="fm_kegiatan_tahunan_rsadd" id="fm_kegiatan_tahunan_rsadd" class="<?php echo $m_kegiatan_tahunan_rs_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_kegiatan_tahunan_rs_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_kegiatan_tahunan_rs_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_kegiatan_tahunan_rs">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($m_kegiatan_tahunan_rs_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_kegiatan_tahunan_rs->tahun->Visible) { // tahun ?>
	<div id="r_tahun" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_tahun" for="x_tahun" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs->tahun->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs->tahun->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_tahun">
<select data-table="m_kegiatan_tahunan_rs" data-field="x_tahun" data-value-separator="<?php echo $m_kegiatan_tahunan_rs->tahun->DisplayValueSeparatorAttribute() ?>" id="x_tahun" name="x_tahun"<?php echo $m_kegiatan_tahunan_rs->tahun->EditAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs->tahun->SelectOptionListHtml("x_tahun") ?>
</select>
</span>
<?php echo $m_kegiatan_tahunan_rs->tahun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_program" for="x_program" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs->program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs->program->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_program">
<?php $m_kegiatan_tahunan_rs->program->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$m_kegiatan_tahunan_rs->program->EditAttrs["onchange"]; ?>
<select data-table="m_kegiatan_tahunan_rs" data-field="x_program" data-value-separator="<?php echo $m_kegiatan_tahunan_rs->program->DisplayValueSeparatorAttribute() ?>" id="x_program" name="x_program"<?php echo $m_kegiatan_tahunan_rs->program->EditAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs->program->SelectOptionListHtml("x_program") ?>
</select>
<input type="hidden" name="s_x_program" id="s_x_program" value="<?php echo $m_kegiatan_tahunan_rs->program->LookupFilterQuery() ?>">
</span>
<?php echo $m_kegiatan_tahunan_rs->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<div id="r_kode_kegiatan" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_kode_kegiatan" for="x_kode_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs->kode_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs->kode_kegiatan->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_kode_kegiatan">
<?php $m_kegiatan_tahunan_rs->kode_kegiatan->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$m_kegiatan_tahunan_rs->kode_kegiatan->EditAttrs["onchange"]; ?>
<select data-table="m_kegiatan_tahunan_rs" data-field="x_kode_kegiatan" data-value-separator="<?php echo $m_kegiatan_tahunan_rs->kode_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kode_kegiatan" name="x_kode_kegiatan"<?php echo $m_kegiatan_tahunan_rs->kode_kegiatan->EditAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs->kode_kegiatan->SelectOptionListHtml("x_kode_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kode_kegiatan" id="s_x_kode_kegiatan" value="<?php echo $m_kegiatan_tahunan_rs->kode_kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $m_kegiatan_tahunan_rs->kode_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<div id="r_sub_kegiatan" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_sub_kegiatan" for="x_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs->sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs->sub_kegiatan->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_sub_kegiatan">
<select data-table="m_kegiatan_tahunan_rs" data-field="x_sub_kegiatan" data-value-separator="<?php echo $m_kegiatan_tahunan_rs->sub_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_sub_kegiatan" name="x_sub_kegiatan"<?php echo $m_kegiatan_tahunan_rs->sub_kegiatan->EditAttributes() ?>>
<?php echo $m_kegiatan_tahunan_rs->sub_kegiatan->SelectOptionListHtml("x_sub_kegiatan") ?>
</select>
<input type="hidden" name="s_x_sub_kegiatan" id="s_x_sub_kegiatan" value="<?php echo $m_kegiatan_tahunan_rs->sub_kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $m_kegiatan_tahunan_rs->sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_kegiatan_tahunan_rs_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_kegiatan_tahunan_rs_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_kegiatan_tahunan_rsadd.Init();
</script>
<?php
$m_kegiatan_tahunan_rs_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_kegiatan_tahunan_rs_add->Page_Terminate();
?>
