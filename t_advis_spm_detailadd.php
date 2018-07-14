<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_advis_spm_detailinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "t_advis_spminfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_advis_spm_detail_add = NULL; // Initialize page object first

class ct_advis_spm_detail_add extends ct_advis_spm_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_advis_spm_detail';

	// Page object name
	var $PageObjName = 't_advis_spm_detail_add';

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

		// Table object (t_advis_spm_detail)
		if (!isset($GLOBALS["t_advis_spm_detail"]) || get_class($GLOBALS["t_advis_spm_detail"]) == "ct_advis_spm_detail") {
			$GLOBALS["t_advis_spm_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_advis_spm_detail"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (t_advis_spm)
		if (!isset($GLOBALS['t_advis_spm'])) $GLOBALS['t_advis_spm'] = new ct_advis_spm();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_advis_spm_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_advis_spm_detaillist.php"));
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
		$this->id_advis->SetVisibility();
		$this->tahun_anggaran->SetVisibility();
		$this->id_spp->SetVisibility();
		$this->no_spm->SetVisibility();
		$this->nama_rekanan->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->nomer_rekening->SetVisibility();
		$this->nama_rekening->SetVisibility();
		$this->bruto->SetVisibility();
		$this->pajak->SetVisibility();
		$this->netto->SetVisibility();
		$this->no_advis->SetVisibility();

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
		global $EW_EXPORT, $t_advis_spm_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_advis_spm_detail);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

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
					$this->Page_Terminate("t_advis_spm_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_advis_spm_detaillist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_advis_spm_detailview.php")
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
		$this->id_advis->CurrentValue = NULL;
		$this->id_advis->OldValue = $this->id_advis->CurrentValue;
		$this->tahun_anggaran->CurrentValue = NULL;
		$this->tahun_anggaran->OldValue = $this->tahun_anggaran->CurrentValue;
		$this->id_spp->CurrentValue = NULL;
		$this->id_spp->OldValue = $this->id_spp->CurrentValue;
		$this->no_spm->CurrentValue = NULL;
		$this->no_spm->OldValue = $this->no_spm->CurrentValue;
		$this->nama_rekanan->CurrentValue = NULL;
		$this->nama_rekanan->OldValue = $this->nama_rekanan->CurrentValue;
		$this->nama_bank->CurrentValue = NULL;
		$this->nama_bank->OldValue = $this->nama_bank->CurrentValue;
		$this->nomer_rekening->CurrentValue = NULL;
		$this->nomer_rekening->OldValue = $this->nomer_rekening->CurrentValue;
		$this->nama_rekening->CurrentValue = NULL;
		$this->nama_rekening->OldValue = $this->nama_rekening->CurrentValue;
		$this->bruto->CurrentValue = NULL;
		$this->bruto->OldValue = $this->bruto->CurrentValue;
		$this->pajak->CurrentValue = NULL;
		$this->pajak->OldValue = $this->pajak->CurrentValue;
		$this->netto->CurrentValue = NULL;
		$this->netto->OldValue = $this->netto->CurrentValue;
		$this->no_advis->CurrentValue = NULL;
		$this->no_advis->OldValue = $this->no_advis->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_advis->FldIsDetailKey) {
			$this->id_advis->setFormValue($objForm->GetValue("x_id_advis"));
		}
		if (!$this->tahun_anggaran->FldIsDetailKey) {
			$this->tahun_anggaran->setFormValue($objForm->GetValue("x_tahun_anggaran"));
		}
		if (!$this->id_spp->FldIsDetailKey) {
			$this->id_spp->setFormValue($objForm->GetValue("x_id_spp"));
		}
		if (!$this->no_spm->FldIsDetailKey) {
			$this->no_spm->setFormValue($objForm->GetValue("x_no_spm"));
		}
		if (!$this->nama_rekanan->FldIsDetailKey) {
			$this->nama_rekanan->setFormValue($objForm->GetValue("x_nama_rekanan"));
		}
		if (!$this->nama_bank->FldIsDetailKey) {
			$this->nama_bank->setFormValue($objForm->GetValue("x_nama_bank"));
		}
		if (!$this->nomer_rekening->FldIsDetailKey) {
			$this->nomer_rekening->setFormValue($objForm->GetValue("x_nomer_rekening"));
		}
		if (!$this->nama_rekening->FldIsDetailKey) {
			$this->nama_rekening->setFormValue($objForm->GetValue("x_nama_rekening"));
		}
		if (!$this->bruto->FldIsDetailKey) {
			$this->bruto->setFormValue($objForm->GetValue("x_bruto"));
		}
		if (!$this->pajak->FldIsDetailKey) {
			$this->pajak->setFormValue($objForm->GetValue("x_pajak"));
		}
		if (!$this->netto->FldIsDetailKey) {
			$this->netto->setFormValue($objForm->GetValue("x_netto"));
		}
		if (!$this->no_advis->FldIsDetailKey) {
			$this->no_advis->setFormValue($objForm->GetValue("x_no_advis"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_advis->CurrentValue = $this->id_advis->FormValue;
		$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->FormValue;
		$this->id_spp->CurrentValue = $this->id_spp->FormValue;
		$this->no_spm->CurrentValue = $this->no_spm->FormValue;
		$this->nama_rekanan->CurrentValue = $this->nama_rekanan->FormValue;
		$this->nama_bank->CurrentValue = $this->nama_bank->FormValue;
		$this->nomer_rekening->CurrentValue = $this->nomer_rekening->FormValue;
		$this->nama_rekening->CurrentValue = $this->nama_rekening->FormValue;
		$this->bruto->CurrentValue = $this->bruto->FormValue;
		$this->pajak->CurrentValue = $this->pajak->FormValue;
		$this->netto->CurrentValue = $this->netto->FormValue;
		$this->no_advis->CurrentValue = $this->no_advis->FormValue;
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
		$this->id_advis->setDbValue($rs->fields('id_advis'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->id_spp->setDbValue($rs->fields('id_spp'));
		$this->no_spm->setDbValue($rs->fields('no_spm'));
		$this->nama_rekanan->setDbValue($rs->fields('nama_rekanan'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->nama_rekening->setDbValue($rs->fields('nama_rekening'));
		$this->bruto->setDbValue($rs->fields('bruto'));
		$this->pajak->setDbValue($rs->fields('pajak'));
		$this->netto->setDbValue($rs->fields('netto'));
		$this->no_advis->setDbValue($rs->fields('no_advis'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_advis->DbValue = $row['id_advis'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->id_spp->DbValue = $row['id_spp'];
		$this->no_spm->DbValue = $row['no_spm'];
		$this->nama_rekanan->DbValue = $row['nama_rekanan'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->nomer_rekening->DbValue = $row['nomer_rekening'];
		$this->nama_rekening->DbValue = $row['nama_rekening'];
		$this->bruto->DbValue = $row['bruto'];
		$this->pajak->DbValue = $row['pajak'];
		$this->netto->DbValue = $row['netto'];
		$this->no_advis->DbValue = $row['no_advis'];
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
		// id_advis
		// tahun_anggaran
		// id_spp
		// no_spm
		// nama_rekanan
		// nama_bank
		// nomer_rekening
		// nama_rekening
		// bruto
		// pajak
		// netto
		// no_advis

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_advis
		$this->id_advis->ViewValue = $this->id_advis->CurrentValue;
		$this->id_advis->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// id_spp
		$this->id_spp->ViewValue = $this->id_spp->CurrentValue;
		if (strval($this->id_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spp`";
		$sWhereWrk = "";
		$this->id_spp->LookupFilters = array("dx1" => '`no_spp`');
		$lookuptblfilter = "`no_spm` is not null ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_spp->ViewValue = $this->id_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_spp->ViewValue = $this->id_spp->CurrentValue;
			}
		} else {
			$this->id_spp->ViewValue = NULL;
		}
		$this->id_spp->ViewCustomAttributes = "";

		// no_spm
		$this->no_spm->ViewValue = $this->no_spm->CurrentValue;
		$this->no_spm->ViewCustomAttributes = "";

		// nama_rekanan
		$this->nama_rekanan->ViewValue = $this->nama_rekanan->CurrentValue;
		$this->nama_rekanan->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// nama_rekening
		$this->nama_rekening->ViewValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->ViewCustomAttributes = "";

		// bruto
		$this->bruto->ViewValue = $this->bruto->CurrentValue;
		$this->bruto->ViewCustomAttributes = "";

		// pajak
		$this->pajak->ViewValue = $this->pajak->CurrentValue;
		$this->pajak->ViewCustomAttributes = "";

		// netto
		$this->netto->ViewValue = $this->netto->CurrentValue;
		$this->netto->ViewCustomAttributes = "";

		// no_advis
		$this->no_advis->ViewValue = $this->no_advis->CurrentValue;
		$this->no_advis->ViewCustomAttributes = "";

			// id_advis
			$this->id_advis->LinkCustomAttributes = "";
			$this->id_advis->HrefValue = "";
			$this->id_advis->TooltipValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

			// id_spp
			$this->id_spp->LinkCustomAttributes = "";
			$this->id_spp->HrefValue = "";
			$this->id_spp->TooltipValue = "";

			// no_spm
			$this->no_spm->LinkCustomAttributes = "";
			$this->no_spm->HrefValue = "";
			$this->no_spm->TooltipValue = "";

			// nama_rekanan
			$this->nama_rekanan->LinkCustomAttributes = "";
			$this->nama_rekanan->HrefValue = "";
			$this->nama_rekanan->TooltipValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";
			$this->nama_bank->TooltipValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";
			$this->nomer_rekening->TooltipValue = "";

			// nama_rekening
			$this->nama_rekening->LinkCustomAttributes = "";
			$this->nama_rekening->HrefValue = "";
			$this->nama_rekening->TooltipValue = "";

			// bruto
			$this->bruto->LinkCustomAttributes = "";
			$this->bruto->HrefValue = "";
			$this->bruto->TooltipValue = "";

			// pajak
			$this->pajak->LinkCustomAttributes = "";
			$this->pajak->HrefValue = "";
			$this->pajak->TooltipValue = "";

			// netto
			$this->netto->LinkCustomAttributes = "";
			$this->netto->HrefValue = "";
			$this->netto->TooltipValue = "";

			// no_advis
			$this->no_advis->LinkCustomAttributes = "";
			$this->no_advis->HrefValue = "";
			$this->no_advis->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_advis
			$this->id_advis->EditAttrs["class"] = "form-control";
			$this->id_advis->EditCustomAttributes = "";
			if ($this->id_advis->getSessionValue() <> "") {
				$this->id_advis->CurrentValue = $this->id_advis->getSessionValue();
			$this->id_advis->ViewValue = $this->id_advis->CurrentValue;
			$this->id_advis->ViewCustomAttributes = "";
			} else {
			$this->id_advis->EditValue = ew_HtmlEncode($this->id_advis->CurrentValue);
			$this->id_advis->PlaceHolder = ew_RemoveHtml($this->id_advis->FldCaption());
			}

			// tahun_anggaran
			$this->tahun_anggaran->EditAttrs["class"] = "form-control";
			$this->tahun_anggaran->EditCustomAttributes = "";
			if ($this->tahun_anggaran->getSessionValue() <> "") {
				$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->getSessionValue();
			$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
			$this->tahun_anggaran->ViewCustomAttributes = "";
			} else {
			$this->tahun_anggaran->EditValue = ew_HtmlEncode($this->tahun_anggaran->CurrentValue);
			$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());
			}

			// id_spp
			$this->id_spp->EditAttrs["class"] = "form-control";
			$this->id_spp->EditCustomAttributes = "";
			$this->id_spp->EditValue = ew_HtmlEncode($this->id_spp->CurrentValue);
			if (strval($this->id_spp->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `no_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spp`";
			$sWhereWrk = "";
			$this->id_spp->LookupFilters = array("dx1" => '`no_spp`');
			$lookuptblfilter = "`no_spm` is not null ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_spp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->id_spp->EditValue = $this->id_spp->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->id_spp->EditValue = ew_HtmlEncode($this->id_spp->CurrentValue);
				}
			} else {
				$this->id_spp->EditValue = NULL;
			}
			$this->id_spp->PlaceHolder = ew_RemoveHtml($this->id_spp->FldCaption());

			// no_spm
			$this->no_spm->EditAttrs["class"] = "form-control";
			$this->no_spm->EditCustomAttributes = "";
			$this->no_spm->EditValue = ew_HtmlEncode($this->no_spm->CurrentValue);
			$this->no_spm->PlaceHolder = ew_RemoveHtml($this->no_spm->FldCaption());

			// nama_rekanan
			$this->nama_rekanan->EditAttrs["class"] = "form-control";
			$this->nama_rekanan->EditCustomAttributes = "";
			$this->nama_rekanan->EditValue = ew_HtmlEncode($this->nama_rekanan->CurrentValue);
			$this->nama_rekanan->PlaceHolder = ew_RemoveHtml($this->nama_rekanan->FldCaption());

			// nama_bank
			$this->nama_bank->EditAttrs["class"] = "form-control";
			$this->nama_bank->EditCustomAttributes = "";
			$this->nama_bank->EditValue = ew_HtmlEncode($this->nama_bank->CurrentValue);
			$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

			// nomer_rekening
			$this->nomer_rekening->EditAttrs["class"] = "form-control";
			$this->nomer_rekening->EditCustomAttributes = "";
			$this->nomer_rekening->EditValue = ew_HtmlEncode($this->nomer_rekening->CurrentValue);
			$this->nomer_rekening->PlaceHolder = ew_RemoveHtml($this->nomer_rekening->FldCaption());

			// nama_rekening
			$this->nama_rekening->EditAttrs["class"] = "form-control";
			$this->nama_rekening->EditCustomAttributes = "";
			$this->nama_rekening->EditValue = ew_HtmlEncode($this->nama_rekening->CurrentValue);
			$this->nama_rekening->PlaceHolder = ew_RemoveHtml($this->nama_rekening->FldCaption());

			// bruto
			$this->bruto->EditAttrs["class"] = "form-control";
			$this->bruto->EditCustomAttributes = "";
			$this->bruto->EditValue = ew_HtmlEncode($this->bruto->CurrentValue);
			$this->bruto->PlaceHolder = ew_RemoveHtml($this->bruto->FldCaption());

			// pajak
			$this->pajak->EditAttrs["class"] = "form-control";
			$this->pajak->EditCustomAttributes = "";
			$this->pajak->EditValue = ew_HtmlEncode($this->pajak->CurrentValue);
			$this->pajak->PlaceHolder = ew_RemoveHtml($this->pajak->FldCaption());

			// netto
			$this->netto->EditAttrs["class"] = "form-control";
			$this->netto->EditCustomAttributes = "";
			$this->netto->EditValue = ew_HtmlEncode($this->netto->CurrentValue);
			$this->netto->PlaceHolder = ew_RemoveHtml($this->netto->FldCaption());

			// no_advis
			$this->no_advis->EditAttrs["class"] = "form-control";
			$this->no_advis->EditCustomAttributes = "";
			if ($this->no_advis->getSessionValue() <> "") {
				$this->no_advis->CurrentValue = $this->no_advis->getSessionValue();
			$this->no_advis->ViewValue = $this->no_advis->CurrentValue;
			$this->no_advis->ViewCustomAttributes = "";
			} else {
			$this->no_advis->EditValue = ew_HtmlEncode($this->no_advis->CurrentValue);
			$this->no_advis->PlaceHolder = ew_RemoveHtml($this->no_advis->FldCaption());
			}

			// Add refer script
			// id_advis

			$this->id_advis->LinkCustomAttributes = "";
			$this->id_advis->HrefValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";

			// id_spp
			$this->id_spp->LinkCustomAttributes = "";
			$this->id_spp->HrefValue = "";

			// no_spm
			$this->no_spm->LinkCustomAttributes = "";
			$this->no_spm->HrefValue = "";

			// nama_rekanan
			$this->nama_rekanan->LinkCustomAttributes = "";
			$this->nama_rekanan->HrefValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";

			// nama_rekening
			$this->nama_rekening->LinkCustomAttributes = "";
			$this->nama_rekening->HrefValue = "";

			// bruto
			$this->bruto->LinkCustomAttributes = "";
			$this->bruto->HrefValue = "";

			// pajak
			$this->pajak->LinkCustomAttributes = "";
			$this->pajak->HrefValue = "";

			// netto
			$this->netto->LinkCustomAttributes = "";
			$this->netto->HrefValue = "";

			// no_advis
			$this->no_advis->LinkCustomAttributes = "";
			$this->no_advis->HrefValue = "";
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

		// id_advis
		$this->id_advis->SetDbValueDef($rsnew, $this->id_advis->CurrentValue, NULL, FALSE);

		// tahun_anggaran
		$this->tahun_anggaran->SetDbValueDef($rsnew, $this->tahun_anggaran->CurrentValue, NULL, FALSE);

		// id_spp
		$this->id_spp->SetDbValueDef($rsnew, $this->id_spp->CurrentValue, NULL, FALSE);

		// no_spm
		$this->no_spm->SetDbValueDef($rsnew, $this->no_spm->CurrentValue, NULL, FALSE);

		// nama_rekanan
		$this->nama_rekanan->SetDbValueDef($rsnew, $this->nama_rekanan->CurrentValue, NULL, FALSE);

		// nama_bank
		$this->nama_bank->SetDbValueDef($rsnew, $this->nama_bank->CurrentValue, NULL, FALSE);

		// nomer_rekening
		$this->nomer_rekening->SetDbValueDef($rsnew, $this->nomer_rekening->CurrentValue, NULL, FALSE);

		// nama_rekening
		$this->nama_rekening->SetDbValueDef($rsnew, $this->nama_rekening->CurrentValue, NULL, FALSE);

		// bruto
		$this->bruto->SetDbValueDef($rsnew, $this->bruto->CurrentValue, NULL, FALSE);

		// pajak
		$this->pajak->SetDbValueDef($rsnew, $this->pajak->CurrentValue, NULL, FALSE);

		// netto
		$this->netto->SetDbValueDef($rsnew, $this->netto->CurrentValue, NULL, FALSE);

		// no_advis
		$this->no_advis->SetDbValueDef($rsnew, $this->no_advis->CurrentValue, NULL, FALSE);

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
			if ($sMasterTblVar == "t_advis_spm") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t_advis_spm"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_advis->setQueryStringValue($GLOBALS["t_advis_spm"]->id->QueryStringValue);
					$this->id_advis->setSessionValue($this->id_advis->QueryStringValue);
					if (!is_numeric($GLOBALS["t_advis_spm"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_advis"] <> "") {
					$GLOBALS["t_advis_spm"]->kode_advis->setQueryStringValue($_GET["fk_kode_advis"]);
					$this->no_advis->setQueryStringValue($GLOBALS["t_advis_spm"]->kode_advis->QueryStringValue);
					$this->no_advis->setSessionValue($this->no_advis->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_advis_spm"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["t_advis_spm"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["t_advis_spm"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t_advis_spm") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t_advis_spm"]->id->setFormValue($_POST["fk_id"]);
					$this->id_advis->setFormValue($GLOBALS["t_advis_spm"]->id->FormValue);
					$this->id_advis->setSessionValue($this->id_advis->FormValue);
					if (!is_numeric($GLOBALS["t_advis_spm"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_advis"] <> "") {
					$GLOBALS["t_advis_spm"]->kode_advis->setFormValue($_POST["fk_kode_advis"]);
					$this->no_advis->setFormValue($GLOBALS["t_advis_spm"]->kode_advis->FormValue);
					$this->no_advis->setSessionValue($this->no_advis->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_advis_spm"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["t_advis_spm"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["t_advis_spm"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_advis_spm") {
				if ($this->id_advis->CurrentValue == "") $this->id_advis->setSessionValue("");
				if ($this->no_advis->CurrentValue == "") $this->no_advis->setSessionValue("");
				if ($this->tahun_anggaran->CurrentValue == "") $this->tahun_anggaran->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_advis_spm_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_id_spp":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spp`";
			$sWhereWrk = "{filter}";
			$this->id_spp->LookupFilters = array("dx1" => '`no_spp`');
			$lookuptblfilter = "`no_spm` is not null ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_spp, $sWhereWrk); // Call Lookup selecting
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
		case "x_id_spp":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_spp` AS `DispFld` FROM `t_spp`";
			$sWhereWrk = "`no_spp` LIKE '%{query_value}%'";
			$this->id_spp->LookupFilters = array("dx1" => '`no_spp`');
			$lookuptblfilter = "`no_spm` is not null ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_spp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	if (@$_POST["myajax"] == 1 && @$_POST["value"] != "") { 
		 $val = json_encode(ew_ExecuteRow("call simrs2012.sp_lokup_laporan_advis(".$_POST["value"].")")); 
		 echo $val;
		 $this->Page_Terminate();
	 } 
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
if (!isset($t_advis_spm_detail_add)) $t_advis_spm_detail_add = new ct_advis_spm_detail_add();

// Page init
$t_advis_spm_detail_add->Page_Init();

// Page main
$t_advis_spm_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_advis_spm_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_advis_spm_detailadd = new ew_Form("ft_advis_spm_detailadd", "add");

// Validate form
ft_advis_spm_detailadd.Validate = function() {
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
ft_advis_spm_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_advis_spm_detailadd.ValidateRequired = true;
<?php } else { ?>
ft_advis_spm_detailadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_advis_spm_detailadd.Lists["x_id_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_spp"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_advis_spm_detail_add->IsModal) { ?>
<?php } ?>
<?php $t_advis_spm_detail_add->ShowPageHeader(); ?>
<?php
$t_advis_spm_detail_add->ShowMessage();
?>
<form name="ft_advis_spm_detailadd" id="ft_advis_spm_detailadd" class="<?php echo $t_advis_spm_detail_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_advis_spm_detail_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_advis_spm_detail_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_advis_spm_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_advis_spm_detail_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($t_advis_spm_detail->getCurrentMasterTable() == "t_advis_spm") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_advis_spm">
<input type="hidden" name="fk_id" value="<?php echo $t_advis_spm_detail->id_advis->getSessionValue() ?>">
<input type="hidden" name="fk_kode_advis" value="<?php echo $t_advis_spm_detail->no_advis->getSessionValue() ?>">
<input type="hidden" name="fk_tahun_anggaran" value="<?php echo $t_advis_spm_detail->tahun_anggaran->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($t_advis_spm_detail->id_advis->Visible) { // id_advis ?>
	<div id="r_id_advis" class="form-group">
		<label id="elh_t_advis_spm_detail_id_advis" for="x_id_advis" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->id_advis->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->id_advis->CellAttributes() ?>>
<?php if ($t_advis_spm_detail->id_advis->getSessionValue() <> "") { ?>
<span id="el_t_advis_spm_detail_id_advis">
<span<?php echo $t_advis_spm_detail->id_advis->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_advis_spm_detail->id_advis->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_id_advis" name="x_id_advis" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->id_advis->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t_advis_spm_detail_id_advis">
<input type="text" data-table="t_advis_spm_detail" data-field="x_id_advis" name="x_id_advis" id="x_id_advis" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->id_advis->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->id_advis->EditValue ?>"<?php echo $t_advis_spm_detail->id_advis->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $t_advis_spm_detail->id_advis->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<div id="r_tahun_anggaran" class="form-group">
		<label id="elh_t_advis_spm_detail_tahun_anggaran" for="x_tahun_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->tahun_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->tahun_anggaran->CellAttributes() ?>>
<?php if ($t_advis_spm_detail->tahun_anggaran->getSessionValue() <> "") { ?>
<span id="el_t_advis_spm_detail_tahun_anggaran">
<span<?php echo $t_advis_spm_detail->tahun_anggaran->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_advis_spm_detail->tahun_anggaran->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_tahun_anggaran" name="x_tahun_anggaran" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->tahun_anggaran->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t_advis_spm_detail_tahun_anggaran">
<input type="text" data-table="t_advis_spm_detail" data-field="x_tahun_anggaran" name="x_tahun_anggaran" id="x_tahun_anggaran" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->tahun_anggaran->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->tahun_anggaran->EditValue ?>"<?php echo $t_advis_spm_detail->tahun_anggaran->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $t_advis_spm_detail->tahun_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->id_spp->Visible) { // id_spp ?>
	<div id="r_id_spp" class="form-group">
		<label id="elh_t_advis_spm_detail_id_spp" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->id_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->id_spp->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_id_spp">
<?php
$wrkonchange = trim(" " . @$t_advis_spm_detail->id_spp->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_advis_spm_detail->id_spp->EditAttrs["onchange"] = "";
?>
<span id="as_x_id_spp" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_id_spp" id="sv_x_id_spp" value="<?php echo $t_advis_spm_detail->id_spp->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->id_spp->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->id_spp->getPlaceHolder()) ?>"<?php echo $t_advis_spm_detail->id_spp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_advis_spm_detail" data-field="x_id_spp" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_advis_spm_detail->id_spp->DisplayValueSeparatorAttribute() ?>" name="x_id_spp" id="x_id_spp" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->id_spp->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_id_spp" id="q_x_id_spp" value="<?php echo $t_advis_spm_detail->id_spp->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_advis_spm_detailadd.CreateAutoSuggest({"id":"x_id_spp","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_advis_spm_detail->id_spp->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_id_spp',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_id_spp" id="s_x_id_spp" value="<?php echo $t_advis_spm_detail->id_spp->LookupFilterQuery(false) ?>">
</span>
<?php echo $t_advis_spm_detail->id_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->no_spm->Visible) { // no_spm ?>
	<div id="r_no_spm" class="form-group">
		<label id="elh_t_advis_spm_detail_no_spm" for="x_no_spm" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->no_spm->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->no_spm->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_no_spm">
<input type="text" data-table="t_advis_spm_detail" data-field="x_no_spm" name="x_no_spm" id="x_no_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_spm->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->no_spm->EditValue ?>"<?php echo $t_advis_spm_detail->no_spm->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->no_spm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->nama_rekanan->Visible) { // nama_rekanan ?>
	<div id="r_nama_rekanan" class="form-group">
		<label id="elh_t_advis_spm_detail_nama_rekanan" for="x_nama_rekanan" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->nama_rekanan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->nama_rekanan->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_nama_rekanan">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_rekanan" name="x_nama_rekanan" id="x_nama_rekanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekanan->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_rekanan->EditValue ?>"<?php echo $t_advis_spm_detail->nama_rekanan->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->nama_rekanan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->nama_bank->Visible) { // nama_bank ?>
	<div id="r_nama_bank" class="form-group">
		<label id="elh_t_advis_spm_detail_nama_bank" for="x_nama_bank" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->nama_bank->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->nama_bank->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_nama_bank">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_bank" name="x_nama_bank" id="x_nama_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_bank->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_bank->EditValue ?>"<?php echo $t_advis_spm_detail->nama_bank->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->nama_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->nomer_rekening->Visible) { // nomer_rekening ?>
	<div id="r_nomer_rekening" class="form-group">
		<label id="elh_t_advis_spm_detail_nomer_rekening" for="x_nomer_rekening" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->nomer_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->nomer_rekening->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_nomer_rekening">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nomer_rekening" name="x_nomer_rekening" id="x_nomer_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nomer_rekening->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nomer_rekening->EditValue ?>"<?php echo $t_advis_spm_detail->nomer_rekening->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->nomer_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->nama_rekening->Visible) { // nama_rekening ?>
	<div id="r_nama_rekening" class="form-group">
		<label id="elh_t_advis_spm_detail_nama_rekening" for="x_nama_rekening" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->nama_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->nama_rekening->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_nama_rekening">
<input type="text" data-table="t_advis_spm_detail" data-field="x_nama_rekening" name="x_nama_rekening" id="x_nama_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->nama_rekening->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->nama_rekening->EditValue ?>"<?php echo $t_advis_spm_detail->nama_rekening->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->nama_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->bruto->Visible) { // bruto ?>
	<div id="r_bruto" class="form-group">
		<label id="elh_t_advis_spm_detail_bruto" for="x_bruto" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->bruto->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->bruto->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_bruto">
<input type="text" data-table="t_advis_spm_detail" data-field="x_bruto" name="x_bruto" id="x_bruto" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->bruto->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->bruto->EditValue ?>"<?php echo $t_advis_spm_detail->bruto->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->bruto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->pajak->Visible) { // pajak ?>
	<div id="r_pajak" class="form-group">
		<label id="elh_t_advis_spm_detail_pajak" for="x_pajak" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->pajak->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->pajak->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_pajak">
<input type="text" data-table="t_advis_spm_detail" data-field="x_pajak" name="x_pajak" id="x_pajak" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->pajak->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->pajak->EditValue ?>"<?php echo $t_advis_spm_detail->pajak->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->pajak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->netto->Visible) { // netto ?>
	<div id="r_netto" class="form-group">
		<label id="elh_t_advis_spm_detail_netto" for="x_netto" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->netto->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->netto->CellAttributes() ?>>
<span id="el_t_advis_spm_detail_netto">
<input type="text" data-table="t_advis_spm_detail" data-field="x_netto" name="x_netto" id="x_netto" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->netto->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->netto->EditValue ?>"<?php echo $t_advis_spm_detail->netto->EditAttributes() ?>>
</span>
<?php echo $t_advis_spm_detail->netto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_advis_spm_detail->no_advis->Visible) { // no_advis ?>
	<div id="r_no_advis" class="form-group">
		<label id="elh_t_advis_spm_detail_no_advis" for="x_no_advis" class="col-sm-2 control-label ewLabel"><?php echo $t_advis_spm_detail->no_advis->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_advis_spm_detail->no_advis->CellAttributes() ?>>
<?php if ($t_advis_spm_detail->no_advis->getSessionValue() <> "") { ?>
<span id="el_t_advis_spm_detail_no_advis">
<span<?php echo $t_advis_spm_detail->no_advis->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_advis_spm_detail->no_advis->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_no_advis" name="x_no_advis" value="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_advis->CurrentValue) ?>">
<?php } else { ?>
<span id="el_t_advis_spm_detail_no_advis">
<input type="text" data-table="t_advis_spm_detail" data-field="x_no_advis" name="x_no_advis" id="x_no_advis" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_advis_spm_detail->no_advis->getPlaceHolder()) ?>" value="<?php echo $t_advis_spm_detail->no_advis->EditValue ?>"<?php echo $t_advis_spm_detail->no_advis->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $t_advis_spm_detail->no_advis->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_advis_spm_detail_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_advis_spm_detail_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_advis_spm_detailadd.Init();
</script>
<?php
$t_advis_spm_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

 /*$("#x_id_spp").change(function() { 
	 var result = ew_Ajax(ewVar.MyCustomSql, $(this).val()); 
	 $("#x_nama_rekanan").val(result); 
 });*/
 $("#x_id_spp").change(function() { 
	 $.post(ew_CurrentPage(), { "myajax": 1, "token": EW_TOKEN, "value": $(this).val() }, function(result) { 
		 let parsed = JSON.parse(result);
		 $("#x_nama_rekanan").val(parsed.nama_perusahaan);
		 $("#x_no_spm").val(parsed.no_spm);
		 $("#x_nama_bank").val(parsed.nama_bank);
		 $("#x_nama_rekening").val(parsed.nama_rekening);
		 $("#x_nomer_rekening").val(parsed.nomer_rekening);
		 $("#x_bruto").val(parsed.BRUTO);
		 $("#x_pajak").val(parsed.PAJAK);
		 $("#x_netto").val(parsed.NETTO);
	 });
 });
</script>
<?php include_once "footer.php" ?>
<?php
$t_advis_spm_detail_add->Page_Terminate();
?>
