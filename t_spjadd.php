<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_spjinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "detail_spjgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_spj_add = NULL; // Initialize page object first

class ct_spj_add extends ct_spj {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_spj';

	// Page object name
	var $PageObjName = 't_spj_add';

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

		// Table object (t_spj)
		if (!isset($GLOBALS["t_spj"]) || get_class($GLOBALS["t_spj"]) == "ct_spj") {
			$GLOBALS["t_spj"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_spj"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_spj', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_spjlist.php"));
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
		$this->jenis_spj->SetVisibility();
		$this->no_spj->SetVisibility();
		$this->tgl_spj->SetVisibility();
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->tahun_anggaran->SetVisibility();

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

			// Process auto fill for detail table 'detail_spj'
			if (@$_POST["grid"] == "fdetail_spjgrid") {
				if (!isset($GLOBALS["detail_spj_grid"])) $GLOBALS["detail_spj_grid"] = new cdetail_spj_grid;
				$GLOBALS["detail_spj_grid"]->Page_Init();
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
		global $EW_EXPORT, $t_spj;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_spj);
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("t_spjlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_spjlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_spjview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->jenis_spj->CurrentValue = NULL;
		$this->jenis_spj->OldValue = $this->jenis_spj->CurrentValue;
		$this->no_spj->CurrentValue = NULL;
		$this->no_spj->OldValue = $this->no_spj->CurrentValue;
		$this->tgl_spj->CurrentValue = date("d/m/Y");
		$this->program->CurrentValue = NULL;
		$this->program->OldValue = $this->program->CurrentValue;
		$this->kegiatan->CurrentValue = NULL;
		$this->kegiatan->OldValue = $this->kegiatan->CurrentValue;
		$this->sub_kegiatan->CurrentValue = NULL;
		$this->sub_kegiatan->OldValue = $this->sub_kegiatan->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->tahun_anggaran->CurrentValue = 2018;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->jenis_spj->FldIsDetailKey) {
			$this->jenis_spj->setFormValue($objForm->GetValue("x_jenis_spj"));
		}
		if (!$this->no_spj->FldIsDetailKey) {
			$this->no_spj->setFormValue($objForm->GetValue("x_no_spj"));
		}
		if (!$this->tgl_spj->FldIsDetailKey) {
			$this->tgl_spj->setFormValue($objForm->GetValue("x_tgl_spj"));
			$this->tgl_spj->CurrentValue = ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7);
		}
		if (!$this->program->FldIsDetailKey) {
			$this->program->setFormValue($objForm->GetValue("x_program"));
		}
		if (!$this->kegiatan->FldIsDetailKey) {
			$this->kegiatan->setFormValue($objForm->GetValue("x_kegiatan"));
		}
		if (!$this->sub_kegiatan->FldIsDetailKey) {
			$this->sub_kegiatan->setFormValue($objForm->GetValue("x_sub_kegiatan"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->tahun_anggaran->FldIsDetailKey) {
			$this->tahun_anggaran->setFormValue($objForm->GetValue("x_tahun_anggaran"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->jenis_spj->CurrentValue = $this->jenis_spj->FormValue;
		$this->no_spj->CurrentValue = $this->no_spj->FormValue;
		$this->tgl_spj->CurrentValue = $this->tgl_spj->FormValue;
		$this->tgl_spj->CurrentValue = ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7);
		$this->program->CurrentValue = $this->program->FormValue;
		$this->kegiatan->CurrentValue = $this->kegiatan->FormValue;
		$this->sub_kegiatan->CurrentValue = $this->sub_kegiatan->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->FormValue;
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
		$this->jenis_spj->setDbValue($rs->fields('jenis_spj'));
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->nama_kuasa->setDbValue($rs->fields('nama_kuasa'));
		$this->nip_kuasa->setDbValue($rs->fields('nip_kuasa'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->jenis_spj->DbValue = $row['jenis_spj'];
		$this->no_spj->DbValue = $row['no_spj'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->nama_kuasa->DbValue = $row['nama_kuasa'];
		$this->nip_kuasa->DbValue = $row['nip_kuasa'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
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
		// jenis_spj
		// no_spj
		// tgl_spj
		// program
		// kegiatan
		// sub_kegiatan
		// keterangan
		// nama_kuasa
		// nip_kuasa
		// tahun_anggaran

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// jenis_spj
		if (strval($this->jenis_spj->CurrentValue) <> "") {
			$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
		} else {
			$this->jenis_spj->ViewValue = NULL;
		}
		$this->jenis_spj->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 7);
		$this->tgl_spj->ViewCustomAttributes = "";

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

		// kegiatan
		if (strval($this->kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
		$sWhereWrk = "";
		$this->kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kegiatan->ViewValue = $this->kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
			}
		} else {
			$this->kegiatan->ViewValue = NULL;
		}
		$this->kegiatan->ViewCustomAttributes = "";

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

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

			// jenis_spj
			$this->jenis_spj->LinkCustomAttributes = "";
			$this->jenis_spj->HrefValue = "";
			$this->jenis_spj->TooltipValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";
			$this->no_spj->TooltipValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";
			$this->tgl_spj->TooltipValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";
			$this->program->TooltipValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";
			$this->kegiatan->TooltipValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";
			$this->sub_kegiatan->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// jenis_spj
			$this->jenis_spj->EditAttrs["class"] = "form-control";
			$this->jenis_spj->EditCustomAttributes = "";
			$this->jenis_spj->EditValue = $this->jenis_spj->Options(TRUE);

			// no_spj
			$this->no_spj->EditAttrs["class"] = "form-control";
			$this->no_spj->EditCustomAttributes = "";
			$this->no_spj->EditValue = ew_HtmlEncode($this->no_spj->CurrentValue);
			$this->no_spj->PlaceHolder = ew_RemoveHtml($this->no_spj->FldCaption());

			// tgl_spj
			$this->tgl_spj->EditAttrs["class"] = "form-control";
			$this->tgl_spj->EditCustomAttributes = "";
			$this->tgl_spj->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_spj->CurrentValue, 7));
			$this->tgl_spj->PlaceHolder = ew_RemoveHtml($this->tgl_spj->FldCaption());

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

			// kegiatan
			$this->kegiatan->EditAttrs["class"] = "form-control";
			$this->kegiatan->EditCustomAttributes = "";
			if (trim(strval($this->kegiatan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kode_program` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_kegiatan`";
			$sWhereWrk = "";
			$this->kegiatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kegiatan->EditValue = $arwrk;

			// sub_kegiatan
			$this->sub_kegiatan->EditAttrs["class"] = "form-control";
			$this->sub_kegiatan->EditCustomAttributes = "";
			if (trim(strval($this->sub_kegiatan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kode_kegiatan` AS `SelectFilterFld`, `kode_program` AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_sub_kegiatan`";
			$sWhereWrk = "";
			$this->sub_kegiatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->sub_kegiatan->EditValue = $arwrk;

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// tahun_anggaran
			$this->tahun_anggaran->EditAttrs["class"] = "form-control";
			$this->tahun_anggaran->EditCustomAttributes = "";
			$this->tahun_anggaran->EditValue = ew_HtmlEncode($this->tahun_anggaran->CurrentValue);
			$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

			// Add refer script
			// jenis_spj

			$this->jenis_spj->LinkCustomAttributes = "";
			$this->jenis_spj->HrefValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->tgl_spj->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spj->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tahun_anggaran->FormValue)) {
			ew_AddMessage($gsFormError, $this->tahun_anggaran->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("detail_spj", $DetailTblVar) && $GLOBALS["detail_spj"]->DetailAdd) {
			if (!isset($GLOBALS["detail_spj_grid"])) $GLOBALS["detail_spj_grid"] = new cdetail_spj_grid(); // get detail page object
			$GLOBALS["detail_spj_grid"]->ValidateGridForm();
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// jenis_spj
		$this->jenis_spj->SetDbValueDef($rsnew, $this->jenis_spj->CurrentValue, NULL, FALSE);

		// no_spj
		$this->no_spj->SetDbValueDef($rsnew, $this->no_spj->CurrentValue, NULL, FALSE);

		// tgl_spj
		$this->tgl_spj->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7), NULL, FALSE);

		// program
		$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, FALSE);

		// kegiatan
		$this->kegiatan->SetDbValueDef($rsnew, $this->kegiatan->CurrentValue, NULL, FALSE);

		// sub_kegiatan
		$this->sub_kegiatan->SetDbValueDef($rsnew, $this->sub_kegiatan->CurrentValue, NULL, FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, FALSE);

		// tahun_anggaran
		$this->tahun_anggaran->SetDbValueDef($rsnew, $this->tahun_anggaran->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("detail_spj", $DetailTblVar) && $GLOBALS["detail_spj"]->DetailAdd) {
				$GLOBALS["detail_spj"]->no_spj->setSessionValue($this->no_spj->CurrentValue); // Set master key
				$GLOBALS["detail_spj"]->id_spj->setSessionValue($this->id->CurrentValue); // Set master key
				$GLOBALS["detail_spj"]->tgl_spj->setSessionValue($this->tgl_spj->CurrentValue); // Set master key
				$GLOBALS["detail_spj"]->program->setSessionValue($this->program->CurrentValue); // Set master key
				$GLOBALS["detail_spj"]->kegiatan->setSessionValue($this->kegiatan->CurrentValue); // Set master key
				$GLOBALS["detail_spj"]->tahun_anggaran->setSessionValue($this->tahun_anggaran->CurrentValue); // Set master key
				$GLOBALS["detail_spj"]->sub_kegiatan->setSessionValue($this->sub_kegiatan->CurrentValue); // Set master key
				$GLOBALS["detail_spj"]->jenis_spj->setSessionValue($this->jenis_spj->CurrentValue); // Set master key
				if (!isset($GLOBALS["detail_spj_grid"])) $GLOBALS["detail_spj_grid"] = new cdetail_spj_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "detail_spj"); // Load user level of detail table
				$AddRow = $GLOBALS["detail_spj_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["detail_spj"]->jenis_spj->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("detail_spj", $DetailTblVar)) {
				if (!isset($GLOBALS["detail_spj_grid"]))
					$GLOBALS["detail_spj_grid"] = new cdetail_spj_grid;
				if ($GLOBALS["detail_spj_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["detail_spj_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["detail_spj_grid"]->CurrentMode = "add";
					$GLOBALS["detail_spj_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["detail_spj_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["detail_spj_grid"]->setStartRecordNumber(1);
					$GLOBALS["detail_spj_grid"]->no_spj->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->no_spj->CurrentValue = $this->no_spj->CurrentValue;
					$GLOBALS["detail_spj_grid"]->no_spj->setSessionValue($GLOBALS["detail_spj_grid"]->no_spj->CurrentValue);
					$GLOBALS["detail_spj_grid"]->id_spj->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->id_spj->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["detail_spj_grid"]->id_spj->setSessionValue($GLOBALS["detail_spj_grid"]->id_spj->CurrentValue);
					$GLOBALS["detail_spj_grid"]->tgl_spj->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->tgl_spj->CurrentValue = $this->tgl_spj->CurrentValue;
					$GLOBALS["detail_spj_grid"]->tgl_spj->setSessionValue($GLOBALS["detail_spj_grid"]->tgl_spj->CurrentValue);
					$GLOBALS["detail_spj_grid"]->program->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->program->CurrentValue = $this->program->CurrentValue;
					$GLOBALS["detail_spj_grid"]->program->setSessionValue($GLOBALS["detail_spj_grid"]->program->CurrentValue);
					$GLOBALS["detail_spj_grid"]->kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->kegiatan->CurrentValue = $this->kegiatan->CurrentValue;
					$GLOBALS["detail_spj_grid"]->kegiatan->setSessionValue($GLOBALS["detail_spj_grid"]->kegiatan->CurrentValue);
					$GLOBALS["detail_spj_grid"]->tahun_anggaran->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->tahun_anggaran->CurrentValue = $this->tahun_anggaran->CurrentValue;
					$GLOBALS["detail_spj_grid"]->tahun_anggaran->setSessionValue($GLOBALS["detail_spj_grid"]->tahun_anggaran->CurrentValue);
					$GLOBALS["detail_spj_grid"]->sub_kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->sub_kegiatan->CurrentValue = $this->sub_kegiatan->CurrentValue;
					$GLOBALS["detail_spj_grid"]->sub_kegiatan->setSessionValue($GLOBALS["detail_spj_grid"]->sub_kegiatan->CurrentValue);
					$GLOBALS["detail_spj_grid"]->jenis_spj->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->jenis_spj->CurrentValue = $this->jenis_spj->CurrentValue;
					$GLOBALS["detail_spj_grid"]->jenis_spj->setSessionValue($GLOBALS["detail_spj_grid"]->jenis_spj->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_spjlist.php"), "", $this->TableVar, TRUE);
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
		case "x_kegiatan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode_kegiatan` AS `LinkFld`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
			$sWhereWrk = "{filter}";
			$this->kegiatan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_kegiatan` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kode_program` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_sub_kegiatan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode_sub_kegiatan` AS `LinkFld`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
			$sWhereWrk = "{filter}";
			$this->sub_kegiatan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_sub_kegiatan` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kode_kegiatan` IN ({filter_value})', "t1" => "200", "fn1" => "", "f2" => '`kode_program` IN ({filter_value})', "t2" => "200", "fn2" => "");
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
if (!isset($t_spj_add)) $t_spj_add = new ct_spj_add();

// Page init
$t_spj_add->Page_Init();

// Page main
$t_spj_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_spj_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_spjadd = new ew_Form("ft_spjadd", "add");

// Validate form
ft_spjadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_spj");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spj->tgl_spj->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tahun_anggaran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spj->tahun_anggaran->FldErrMsg()) ?>");

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
ft_spjadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_spjadd.ValidateRequired = true;
<?php } else { ?>
ft_spjadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_spjadd.Lists["x_jenis_spj"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_spjadd.Lists["x_jenis_spj"].Options = <?php echo json_encode($t_spj->jenis_spj->Options()) ?>;
ft_spjadd.Lists["x_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kegiatan","x_sub_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
ft_spjadd.Lists["x_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_program"],"ChildFields":["x_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
ft_spjadd.Lists["x_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_kegiatan","x_program"],"ChildFields":[],"FilterFields":["x_kode_kegiatan","x_kode_program"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_spj_add->IsModal) { ?>
<?php } ?>
<?php $t_spj_add->ShowPageHeader(); ?>
<?php
$t_spj_add->ShowMessage();
?>
<form name="ft_spjadd" id="ft_spjadd" class="<?php echo $t_spj_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_spj_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_spj_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_spj">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_spj_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_spj->jenis_spj->Visible) { // jenis_spj ?>
	<div id="r_jenis_spj" class="form-group">
		<label id="elh_t_spj_jenis_spj" for="x_jenis_spj" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->jenis_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->jenis_spj->CellAttributes() ?>>
<span id="el_t_spj_jenis_spj">
<select data-table="t_spj" data-field="x_jenis_spj" data-value-separator="<?php echo $t_spj->jenis_spj->DisplayValueSeparatorAttribute() ?>" id="x_jenis_spj" name="x_jenis_spj"<?php echo $t_spj->jenis_spj->EditAttributes() ?>>
<?php echo $t_spj->jenis_spj->SelectOptionListHtml("x_jenis_spj") ?>
</select>
</span>
<?php echo $t_spj->jenis_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spj->no_spj->Visible) { // no_spj ?>
	<div id="r_no_spj" class="form-group">
		<label id="elh_t_spj_no_spj" for="x_no_spj" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->no_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->no_spj->CellAttributes() ?>>
<span id="el_t_spj_no_spj">
<input type="text" data-table="t_spj" data-field="x_no_spj" name="x_no_spj" id="x_no_spj" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spj->no_spj->getPlaceHolder()) ?>" value="<?php echo $t_spj->no_spj->EditValue ?>"<?php echo $t_spj->no_spj->EditAttributes() ?>>
</span>
<?php echo $t_spj->no_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spj->tgl_spj->Visible) { // tgl_spj ?>
	<div id="r_tgl_spj" class="form-group">
		<label id="elh_t_spj_tgl_spj" for="x_tgl_spj" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->tgl_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->tgl_spj->CellAttributes() ?>>
<span id="el_t_spj_tgl_spj">
<input type="text" data-table="t_spj" data-field="x_tgl_spj" data-format="7" name="x_tgl_spj" id="x_tgl_spj" placeholder="<?php echo ew_HtmlEncode($t_spj->tgl_spj->getPlaceHolder()) ?>" value="<?php echo $t_spj->tgl_spj->EditValue ?>"<?php echo $t_spj->tgl_spj->EditAttributes() ?>>
<?php if (!$t_spj->tgl_spj->ReadOnly && !$t_spj->tgl_spj->Disabled && !isset($t_spj->tgl_spj->EditAttrs["readonly"]) && !isset($t_spj->tgl_spj->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_spjadd", "x_tgl_spj", 7);
</script>
<?php } ?>
</span>
<?php echo $t_spj->tgl_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spj->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_t_spj_program" for="x_program" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->program->CellAttributes() ?>>
<span id="el_t_spj_program">
<?php $t_spj->program->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_spj->program->EditAttrs["onchange"]; ?>
<select data-table="t_spj" data-field="x_program" data-value-separator="<?php echo $t_spj->program->DisplayValueSeparatorAttribute() ?>" id="x_program" name="x_program"<?php echo $t_spj->program->EditAttributes() ?>>
<?php echo $t_spj->program->SelectOptionListHtml("x_program") ?>
</select>
<input type="hidden" name="s_x_program" id="s_x_program" value="<?php echo $t_spj->program->LookupFilterQuery() ?>">
</span>
<?php echo $t_spj->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spj->kegiatan->Visible) { // kegiatan ?>
	<div id="r_kegiatan" class="form-group">
		<label id="elh_t_spj_kegiatan" for="x_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->kegiatan->CellAttributes() ?>>
<span id="el_t_spj_kegiatan">
<?php $t_spj->kegiatan->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_spj->kegiatan->EditAttrs["onchange"]; ?>
<select data-table="t_spj" data-field="x_kegiatan" data-value-separator="<?php echo $t_spj->kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kegiatan" name="x_kegiatan"<?php echo $t_spj->kegiatan->EditAttributes() ?>>
<?php echo $t_spj->kegiatan->SelectOptionListHtml("x_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kegiatan" id="s_x_kegiatan" value="<?php echo $t_spj->kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $t_spj->kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spj->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<div id="r_sub_kegiatan" class="form-group">
		<label id="elh_t_spj_sub_kegiatan" for="x_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->sub_kegiatan->CellAttributes() ?>>
<span id="el_t_spj_sub_kegiatan">
<select data-table="t_spj" data-field="x_sub_kegiatan" data-value-separator="<?php echo $t_spj->sub_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_sub_kegiatan" name="x_sub_kegiatan"<?php echo $t_spj->sub_kegiatan->EditAttributes() ?>>
<?php echo $t_spj->sub_kegiatan->SelectOptionListHtml("x_sub_kegiatan") ?>
</select>
<input type="hidden" name="s_x_sub_kegiatan" id="s_x_sub_kegiatan" value="<?php echo $t_spj->sub_kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $t_spj->sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spj->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_t_spj_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->keterangan->CellAttributes() ?>>
<span id="el_t_spj_keterangan">
<input type="text" data-table="t_spj" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spj->keterangan->getPlaceHolder()) ?>" value="<?php echo $t_spj->keterangan->EditValue ?>"<?php echo $t_spj->keterangan->EditAttributes() ?>>
</span>
<?php echo $t_spj->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spj->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<div id="r_tahun_anggaran" class="form-group">
		<label id="elh_t_spj_tahun_anggaran" for="x_tahun_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $t_spj->tahun_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spj->tahun_anggaran->CellAttributes() ?>>
<span id="el_t_spj_tahun_anggaran">
<input type="text" data-table="t_spj" data-field="x_tahun_anggaran" name="x_tahun_anggaran" id="x_tahun_anggaran" size="30" placeholder="<?php echo ew_HtmlEncode($t_spj->tahun_anggaran->getPlaceHolder()) ?>" value="<?php echo $t_spj->tahun_anggaran->EditValue ?>"<?php echo $t_spj->tahun_anggaran->EditAttributes() ?>>
</span>
<?php echo $t_spj->tahun_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("detail_spj", explode(",", $t_spj->getCurrentDetailTable())) && $detail_spj->DetailAdd) {
?>
<?php if ($t_spj->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detail_spj", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detail_spjgrid.php" ?>
<?php } ?>
<?php if (!$t_spj_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_spj_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_spjadd.Init();
</script>
<?php
$t_spj_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_spj_add->Page_Terminate();
?>
