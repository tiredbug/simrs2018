<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_ls_gaji_list_detail_belanjainfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_spp_ls_gaji_listinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_ls_gaji_list_detail_belanja_add = NULL; // Initialize page object first

class cvw_spp_ls_gaji_list_detail_belanja_add extends cvw_spp_ls_gaji_list_detail_belanja {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_ls_gaji_list_detail_belanja';

	// Page object name
	var $PageObjName = 'vw_spp_ls_gaji_list_detail_belanja_add';

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

		// Table object (vw_spp_ls_gaji_list_detail_belanja)
		if (!isset($GLOBALS["vw_spp_ls_gaji_list_detail_belanja"]) || get_class($GLOBALS["vw_spp_ls_gaji_list_detail_belanja"]) == "cvw_spp_ls_gaji_list_detail_belanja") {
			$GLOBALS["vw_spp_ls_gaji_list_detail_belanja"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_ls_gaji_list_detail_belanja"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (vw_spp_ls_gaji_list)
		if (!isset($GLOBALS['vw_spp_ls_gaji_list'])) $GLOBALS['vw_spp_ls_gaji_list'] = new cvw_spp_ls_gaji_list();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_ls_gaji_list_detail_belanja', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_ls_gaji_list_detail_belanjalist.php"));
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
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();
		$this->jumlah_belanja->SetVisibility();

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
		global $EW_EXPORT, $vw_spp_ls_gaji_list_detail_belanja;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_ls_gaji_list_detail_belanja);
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
					$this->Page_Terminate("vw_spp_ls_gaji_list_detail_belanjalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_spp_ls_gaji_list_detail_belanjalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_spp_ls_gaji_list_detail_belanjaview.php")
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
		$this->akun1->CurrentValue = NULL;
		$this->akun1->OldValue = $this->akun1->CurrentValue;
		$this->akun2->CurrentValue = NULL;
		$this->akun2->OldValue = $this->akun2->CurrentValue;
		$this->akun3->CurrentValue = NULL;
		$this->akun3->OldValue = $this->akun3->CurrentValue;
		$this->akun4->CurrentValue = NULL;
		$this->akun4->OldValue = $this->akun4->CurrentValue;
		$this->akun5->CurrentValue = NULL;
		$this->akun5->OldValue = $this->akun5->CurrentValue;
		$this->jumlah_belanja->CurrentValue = NULL;
		$this->jumlah_belanja->OldValue = $this->jumlah_belanja->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->akun1->FldIsDetailKey) {
			$this->akun1->setFormValue($objForm->GetValue("x_akun1"));
		}
		if (!$this->akun2->FldIsDetailKey) {
			$this->akun2->setFormValue($objForm->GetValue("x_akun2"));
		}
		if (!$this->akun3->FldIsDetailKey) {
			$this->akun3->setFormValue($objForm->GetValue("x_akun3"));
		}
		if (!$this->akun4->FldIsDetailKey) {
			$this->akun4->setFormValue($objForm->GetValue("x_akun4"));
		}
		if (!$this->akun5->FldIsDetailKey) {
			$this->akun5->setFormValue($objForm->GetValue("x_akun5"));
		}
		if (!$this->jumlah_belanja->FldIsDetailKey) {
			$this->jumlah_belanja->setFormValue($objForm->GetValue("x_jumlah_belanja"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->akun1->CurrentValue = $this->akun1->FormValue;
		$this->akun2->CurrentValue = $this->akun2->FormValue;
		$this->akun3->CurrentValue = $this->akun3->FormValue;
		$this->akun4->CurrentValue = $this->akun4->FormValue;
		$this->akun5->CurrentValue = $this->akun5->FormValue;
		$this->jumlah_belanja->CurrentValue = $this->jumlah_belanja->FormValue;
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
		$this->id_spp->setDbValue($rs->fields('id_spp'));
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->kd_rekening_belanja->setDbValue($rs->fields('kd_rekening_belanja'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_spp->DbValue = $row['id_spp'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
		$this->kd_rekening_belanja->DbValue = $row['kd_rekening_belanja'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
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
		// Convert decimal values if posted back

		if ($this->jumlah_belanja->FormValue == $this->jumlah_belanja->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_belanja->CurrentValue)))
			$this->jumlah_belanja->CurrentValue = ew_StrToFloat($this->jumlah_belanja->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_spp
		// id_jenis_spp
		// detail_jenis_spp
		// no_spp
		// program
		// kegiatan
		// sub_kegiatan
		// tahun_anggaran
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5
		// kd_rekening_belanja
		// jumlah_belanja

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_spp
		$this->id_spp->ViewValue = $this->id_spp->CurrentValue;
		$this->id_spp->ViewCustomAttributes = "";

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// akun1
		if (strval($this->akun1->CurrentValue) <> "") {
			$sFilterWrk = "`kel1`" . ew_SearchString("=", $this->akun1->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kel1`, `nmkel1` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun1`";
		$sWhereWrk = "";
		$this->akun1->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun1, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun1->ViewValue = $this->akun1->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun1->ViewValue = $this->akun1->CurrentValue;
			}
		} else {
			$this->akun1->ViewValue = NULL;
		}
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		if (strval($this->akun2->CurrentValue) <> "") {
			$sFilterWrk = "`kel2`" . ew_SearchString("=", $this->akun2->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel2`, `nmkel2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun2`";
		$sWhereWrk = "";
		$this->akun2->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun2, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun2->ViewValue = $this->akun2->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun2->ViewValue = $this->akun2->CurrentValue;
			}
		} else {
			$this->akun2->ViewValue = NULL;
		}
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		if (strval($this->akun3->CurrentValue) <> "") {
			$sFilterWrk = "`kel3`" . ew_SearchString("=", $this->akun3->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel3`, `nmkel3` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun3`";
		$sWhereWrk = "";
		$this->akun3->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun3, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun3->ViewValue = $this->akun3->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun3->ViewValue = $this->akun3->CurrentValue;
			}
		} else {
			$this->akun3->ViewValue = NULL;
		}
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		if (strval($this->akun4->CurrentValue) <> "") {
			$sFilterWrk = "`kel4`" . ew_SearchString("=", $this->akun4->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel4`, `nmkel4` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun4`";
		$sWhereWrk = "";
		$this->akun4->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun4, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun4->ViewValue = $this->akun4->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun4->ViewValue = $this->akun4->CurrentValue;
			}
		} else {
			$this->akun4->ViewValue = NULL;
		}
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		if (strval($this->akun5->CurrentValue) <> "") {
			$sFilterWrk = "`akun5`" . ew_SearchString("=", $this->akun5->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `akun5`, `nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
		$sWhereWrk = "";
		$this->akun5->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun5, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun5->ViewValue = $this->akun5->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun5->ViewValue = $this->akun5->CurrentValue;
			}
		} else {
			$this->akun5->ViewValue = NULL;
		}
		$this->akun5->ViewCustomAttributes = "";

		// kd_rekening_belanja
		$this->kd_rekening_belanja->ViewValue = $this->kd_rekening_belanja->CurrentValue;
		$this->kd_rekening_belanja->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

			// akun1
			$this->akun1->LinkCustomAttributes = "";
			$this->akun1->HrefValue = "";
			$this->akun1->TooltipValue = "";

			// akun2
			$this->akun2->LinkCustomAttributes = "";
			$this->akun2->HrefValue = "";
			$this->akun2->TooltipValue = "";

			// akun3
			$this->akun3->LinkCustomAttributes = "";
			$this->akun3->HrefValue = "";
			$this->akun3->TooltipValue = "";

			// akun4
			$this->akun4->LinkCustomAttributes = "";
			$this->akun4->HrefValue = "";
			$this->akun4->TooltipValue = "";

			// akun5
			$this->akun5->LinkCustomAttributes = "";
			$this->akun5->HrefValue = "";
			$this->akun5->TooltipValue = "";

			// jumlah_belanja
			$this->jumlah_belanja->LinkCustomAttributes = "";
			$this->jumlah_belanja->HrefValue = "";
			$this->jumlah_belanja->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// akun1
			$this->akun1->EditAttrs["class"] = "form-control";
			$this->akun1->EditCustomAttributes = "";
			if (trim(strval($this->akun1->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kel1`" . ew_SearchString("=", $this->akun1->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kel1`, `nmkel1` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `keu_akun1`";
			$sWhereWrk = "";
			$this->akun1->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akun1, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->akun1->EditValue = $arwrk;

			// akun2
			$this->akun2->EditAttrs["class"] = "form-control";
			$this->akun2->EditCustomAttributes = "";
			if (trim(strval($this->akun2->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kel2`" . ew_SearchString("=", $this->akun2->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kel2`, `nmkel2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kel1` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `keu_akun2`";
			$sWhereWrk = "";
			$this->akun2->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akun2, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->akun2->EditValue = $arwrk;

			// akun3
			$this->akun3->EditAttrs["class"] = "form-control";
			$this->akun3->EditCustomAttributes = "";
			if (trim(strval($this->akun3->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kel3`" . ew_SearchString("=", $this->akun3->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kel3`, `nmkel3` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kel2` AS `SelectFilterFld`, `kel1` AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `keu_akun3`";
			$sWhereWrk = "";
			$this->akun3->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akun3, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->akun3->EditValue = $arwrk;

			// akun4
			$this->akun4->EditAttrs["class"] = "form-control";
			$this->akun4->EditCustomAttributes = "";
			if (trim(strval($this->akun4->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kel4`" . ew_SearchString("=", $this->akun4->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kel4`, `nmkel4` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kel3` AS `SelectFilterFld`, `kel2` AS `SelectFilterFld2`, `kel1` AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `keu_akun4`";
			$sWhereWrk = "";
			$this->akun4->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akun4, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->akun4->EditValue = $arwrk;

			// akun5
			$this->akun5->EditAttrs["class"] = "form-control";
			$this->akun5->EditCustomAttributes = "";
			if (trim(strval($this->akun5->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`akun5`" . ew_SearchString("=", $this->akun5->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `akun5`, `nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `akun4` AS `SelectFilterFld`, `akun3` AS `SelectFilterFld2`, `akun2` AS `SelectFilterFld3`, `akun1` AS `SelectFilterFld4` FROM `keu_akun5`";
			$sWhereWrk = "";
			$this->akun5->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->akun5, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->akun5->EditValue = $arwrk;

			// jumlah_belanja
			$this->jumlah_belanja->EditAttrs["class"] = "form-control";
			$this->jumlah_belanja->EditCustomAttributes = "";
			$this->jumlah_belanja->EditValue = ew_HtmlEncode($this->jumlah_belanja->CurrentValue);
			$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
			if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

			// Add refer script
			// akun1

			$this->akun1->LinkCustomAttributes = "";
			$this->akun1->HrefValue = "";

			// akun2
			$this->akun2->LinkCustomAttributes = "";
			$this->akun2->HrefValue = "";

			// akun3
			$this->akun3->LinkCustomAttributes = "";
			$this->akun3->HrefValue = "";

			// akun4
			$this->akun4->LinkCustomAttributes = "";
			$this->akun4->HrefValue = "";

			// akun5
			$this->akun5->LinkCustomAttributes = "";
			$this->akun5->HrefValue = "";

			// jumlah_belanja
			$this->jumlah_belanja->LinkCustomAttributes = "";
			$this->jumlah_belanja->HrefValue = "";
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
		if (!$this->akun1->FldIsDetailKey && !is_null($this->akun1->FormValue) && $this->akun1->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->akun1->FldCaption(), $this->akun1->ReqErrMsg));
		}
		if (!$this->akun2->FldIsDetailKey && !is_null($this->akun2->FormValue) && $this->akun2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->akun2->FldCaption(), $this->akun2->ReqErrMsg));
		}
		if (!$this->akun3->FldIsDetailKey && !is_null($this->akun3->FormValue) && $this->akun3->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->akun3->FldCaption(), $this->akun3->ReqErrMsg));
		}
		if (!$this->akun4->FldIsDetailKey && !is_null($this->akun4->FormValue) && $this->akun4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->akun4->FldCaption(), $this->akun4->ReqErrMsg));
		}
		if (!$this->akun5->FldIsDetailKey && !is_null($this->akun5->FormValue) && $this->akun5->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->akun5->FldCaption(), $this->akun5->ReqErrMsg));
		}
		if (!$this->jumlah_belanja->FldIsDetailKey && !is_null($this->jumlah_belanja->FormValue) && $this->jumlah_belanja->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jumlah_belanja->FldCaption(), $this->jumlah_belanja->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->jumlah_belanja->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_belanja->FldErrMsg());
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

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// akun1
		$this->akun1->SetDbValueDef($rsnew, $this->akun1->CurrentValue, "", FALSE);

		// akun2
		$this->akun2->SetDbValueDef($rsnew, $this->akun2->CurrentValue, "", FALSE);

		// akun3
		$this->akun3->SetDbValueDef($rsnew, $this->akun3->CurrentValue, "", FALSE);

		// akun4
		$this->akun4->SetDbValueDef($rsnew, $this->akun4->CurrentValue, "", FALSE);

		// akun5
		$this->akun5->SetDbValueDef($rsnew, $this->akun5->CurrentValue, "", FALSE);

		// jumlah_belanja
		$this->jumlah_belanja->SetDbValueDef($rsnew, $this->jumlah_belanja->CurrentValue, 0, FALSE);

		// id_spp
		if ($this->id_spp->getSessionValue() <> "") {
			$rsnew['id_spp'] = $this->id_spp->getSessionValue();
		}

		// id_jenis_spp
		if ($this->id_jenis_spp->getSessionValue() <> "") {
			$rsnew['id_jenis_spp'] = $this->id_jenis_spp->getSessionValue();
		}

		// detail_jenis_spp
		if ($this->detail_jenis_spp->getSessionValue() <> "") {
			$rsnew['detail_jenis_spp'] = $this->detail_jenis_spp->getSessionValue();
		}

		// no_spp
		if ($this->no_spp->getSessionValue() <> "") {
			$rsnew['no_spp'] = $this->no_spp->getSessionValue();
		}

		// program
		if ($this->program->getSessionValue() <> "") {
			$rsnew['program'] = $this->program->getSessionValue();
		}

		// kegiatan
		if ($this->kegiatan->getSessionValue() <> "") {
			$rsnew['kegiatan'] = $this->kegiatan->getSessionValue();
		}

		// sub_kegiatan
		if ($this->sub_kegiatan->getSessionValue() <> "") {
			$rsnew['sub_kegiatan'] = $this->sub_kegiatan->getSessionValue();
		}

		// tahun_anggaran
		if ($this->tahun_anggaran->getSessionValue() <> "") {
			$rsnew['tahun_anggaran'] = $this->tahun_anggaran->getSessionValue();
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
			if ($sMasterTblVar == "vw_spp_ls_gaji_list") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_spp->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->id->QueryStringValue);
					$this->id_spp->setSessionValue($this->id_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->id_jenis_spp->setQueryStringValue($_GET["fk_id_jenis_spp"]);
					$this->id_jenis_spp->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->id_jenis_spp->QueryStringValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->id_jenis_spp->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_detail_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->detail_jenis_spp->setQueryStringValue($_GET["fk_detail_jenis_spp"]);
					$this->detail_jenis_spp->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->detail_jenis_spp->QueryStringValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->detail_jenis_spp->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_no_spp"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->no_spp->setQueryStringValue($_GET["fk_no_spp"]);
					$this->no_spp->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->no_spp->QueryStringValue);
					$this->no_spp->setSessionValue($this->no_spp->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_program"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->kode_program->setQueryStringValue($_GET["fk_kode_program"]);
					$this->program->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->kode_program->QueryStringValue);
					$this->program->setSessionValue($this->program->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->kode_kegiatan->setQueryStringValue($_GET["fk_kode_kegiatan"]);
					$this->kegiatan->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->kode_kegiatan->QueryStringValue);
					$this->kegiatan->setSessionValue($this->kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_sub_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->kode_sub_kegiatan->setQueryStringValue($_GET["fk_kode_sub_kegiatan"]);
					$this->sub_kegiatan->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->kode_sub_kegiatan->QueryStringValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["vw_spp_ls_gaji_list"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "vw_spp_ls_gaji_list") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->id->setFormValue($_POST["fk_id"]);
					$this->id_spp->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->id->FormValue);
					$this->id_spp->setSessionValue($this->id_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->id_jenis_spp->setFormValue($_POST["fk_id_jenis_spp"]);
					$this->id_jenis_spp->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->id_jenis_spp->FormValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->id_jenis_spp->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_detail_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->detail_jenis_spp->setFormValue($_POST["fk_detail_jenis_spp"]);
					$this->detail_jenis_spp->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->detail_jenis_spp->FormValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->detail_jenis_spp->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_no_spp"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->no_spp->setFormValue($_POST["fk_no_spp"]);
					$this->no_spp->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->no_spp->FormValue);
					$this->no_spp->setSessionValue($this->no_spp->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_program"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->kode_program->setFormValue($_POST["fk_kode_program"]);
					$this->program->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->kode_program->FormValue);
					$this->program->setSessionValue($this->program->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->kode_kegiatan->setFormValue($_POST["fk_kode_kegiatan"]);
					$this->kegiatan->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->kode_kegiatan->FormValue);
					$this->kegiatan->setSessionValue($this->kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_sub_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->kode_sub_kegiatan->setFormValue($_POST["fk_kode_sub_kegiatan"]);
					$this->sub_kegiatan->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->kode_sub_kegiatan->FormValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["vw_spp_ls_gaji_list"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["vw_spp_ls_gaji_list"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_gaji_list"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "vw_spp_ls_gaji_list") {
				if ($this->id_spp->CurrentValue == "") $this->id_spp->setSessionValue("");
				if ($this->id_jenis_spp->CurrentValue == "") $this->id_jenis_spp->setSessionValue("");
				if ($this->detail_jenis_spp->CurrentValue == "") $this->detail_jenis_spp->setSessionValue("");
				if ($this->no_spp->CurrentValue == "") $this->no_spp->setSessionValue("");
				if ($this->program->CurrentValue == "") $this->program->setSessionValue("");
				if ($this->kegiatan->CurrentValue == "") $this->kegiatan->setSessionValue("");
				if ($this->sub_kegiatan->CurrentValue == "") $this->sub_kegiatan->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_ls_gaji_list_detail_belanjalist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_akun1":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kel1` AS `LinkFld`, `nmkel1` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun1`";
			$sWhereWrk = "";
			$this->akun1->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kel1` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun1, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_akun2":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kel2` AS `LinkFld`, `nmkel2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun2`";
			$sWhereWrk = "{filter}";
			$this->akun2->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kel2` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kel1` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun2, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_akun3":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kel3` AS `LinkFld`, `nmkel3` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun3`";
			$sWhereWrk = "{filter}";
			$this->akun3->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kel3` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kel2` IN ({filter_value})', "t1" => "200", "fn1" => "", "f2" => '`kel1` IN ({filter_value})', "t2" => "200", "fn2" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun3, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_akun4":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kel4` AS `LinkFld`, `nmkel4` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun4`";
			$sWhereWrk = "{filter}";
			$this->akun4->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kel4` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kel3` IN ({filter_value})', "t1" => "200", "fn1" => "", "f2" => '`kel2` IN ({filter_value})', "t2" => "200", "fn2" => "", "f3" => '`kel1` IN ({filter_value})', "t3" => "200", "fn3" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun4, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_akun5":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `akun5` AS `LinkFld`, `nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
			$sWhereWrk = "{filter}";
			$this->akun5->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`akun5` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`akun4` IN ({filter_value})', "t1" => "200", "fn1" => "", "f2" => '`akun3` IN ({filter_value})', "t2" => "200", "fn2" => "", "f3" => '`akun2` IN ({filter_value})', "t3" => "200", "fn3" => "", "f4" => '`akun1` IN ({filter_value})', "t4" => "200", "fn4" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->akun5, $sWhereWrk); // Call Lookup selecting
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
if (!isset($vw_spp_ls_gaji_list_detail_belanja_add)) $vw_spp_ls_gaji_list_detail_belanja_add = new cvw_spp_ls_gaji_list_detail_belanja_add();

// Page init
$vw_spp_ls_gaji_list_detail_belanja_add->Page_Init();

// Page main
$vw_spp_ls_gaji_list_detail_belanja_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_ls_gaji_list_detail_belanja_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_spp_ls_gaji_list_detail_belanjaadd = new ew_Form("fvw_spp_ls_gaji_list_detail_belanjaadd", "add");

// Validate form
fvw_spp_ls_gaji_list_detail_belanjaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_akun1");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_gaji_list_detail_belanja->akun1->FldCaption(), $vw_spp_ls_gaji_list_detail_belanja->akun1->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_akun2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_gaji_list_detail_belanja->akun2->FldCaption(), $vw_spp_ls_gaji_list_detail_belanja->akun2->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_akun3");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_gaji_list_detail_belanja->akun3->FldCaption(), $vw_spp_ls_gaji_list_detail_belanja->akun3->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_akun4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_gaji_list_detail_belanja->akun4->FldCaption(), $vw_spp_ls_gaji_list_detail_belanja->akun4->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_akun5");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_gaji_list_detail_belanja->akun5->FldCaption(), $vw_spp_ls_gaji_list_detail_belanja->akun5->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->FldCaption(), $vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->FldErrMsg()) ?>");

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
fvw_spp_ls_gaji_list_detail_belanjaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_ls_gaji_list_detail_belanjaadd.ValidateRequired = true;
<?php } else { ?>
fvw_spp_ls_gaji_list_detail_belanjaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_ls_gaji_list_detail_belanjaadd.Lists["x_akun1"] = {"LinkField":"x_kel1","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel1","","",""],"ParentFields":[],"ChildFields":["x_akun2","x_akun3","x_akun4","x_akun5"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun1"};
fvw_spp_ls_gaji_list_detail_belanjaadd.Lists["x_akun2"] = {"LinkField":"x_kel2","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel2","","",""],"ParentFields":["x_akun1"],"ChildFields":["x_akun3","x_akun4","x_akun5"],"FilterFields":["x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun2"};
fvw_spp_ls_gaji_list_detail_belanjaadd.Lists["x_akun3"] = {"LinkField":"x_kel3","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel3","","",""],"ParentFields":["x_akun2","x_akun1"],"ChildFields":["x_akun4","x_akun5"],"FilterFields":["x_kel2","x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun3"};
fvw_spp_ls_gaji_list_detail_belanjaadd.Lists["x_akun4"] = {"LinkField":"x_kel4","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel4","","",""],"ParentFields":["x_akun3","x_akun2","x_akun1"],"ChildFields":["x_akun5"],"FilterFields":["x_kel3","x_kel2","x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun4"};
fvw_spp_ls_gaji_list_detail_belanjaadd.Lists["x_akun5"] = {"LinkField":"x_akun5","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_akun","","",""],"ParentFields":["x_akun4","x_akun3","x_akun2","x_akun1"],"ChildFields":[],"FilterFields":["x_akun4","x_akun3","x_akun2","x_akun1"],"Options":[],"Template":"","LinkTable":"keu_akun5"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_ls_gaji_list_detail_belanja_add->IsModal) { ?>
<?php } ?>
<?php $vw_spp_ls_gaji_list_detail_belanja_add->ShowPageHeader(); ?>
<?php
$vw_spp_ls_gaji_list_detail_belanja_add->ShowMessage();
?>
<form name="fvw_spp_ls_gaji_list_detail_belanjaadd" id="fvw_spp_ls_gaji_list_detail_belanjaadd" class="<?php echo $vw_spp_ls_gaji_list_detail_belanja_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_ls_gaji_list_detail_belanja_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_ls_gaji_list_detail_belanja">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_spp_ls_gaji_list_detail_belanja_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($vw_spp_ls_gaji_list_detail_belanja->getCurrentMasterTable() == "vw_spp_ls_gaji_list") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="vw_spp_ls_gaji_list">
<input type="hidden" name="fk_id" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->id_spp->getSessionValue() ?>">
<input type="hidden" name="fk_id_jenis_spp" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->id_jenis_spp->getSessionValue() ?>">
<input type="hidden" name="fk_detail_jenis_spp" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->detail_jenis_spp->getSessionValue() ?>">
<input type="hidden" name="fk_no_spp" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->no_spp->getSessionValue() ?>">
<input type="hidden" name="fk_kode_program" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->program->getSessionValue() ?>">
<input type="hidden" name="fk_kode_kegiatan" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_kode_sub_kegiatan" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->sub_kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_tahun_anggaran" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->tahun_anggaran->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($vw_spp_ls_gaji_list_detail_belanja->akun1->Visible) { // akun1 ?>
	<div id="r_akun1" class="form-group">
		<label id="elh_vw_spp_ls_gaji_list_detail_belanja_akun1" for="x_akun1" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_list_detail_belanja->akun1->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun1->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_detail_belanja_akun1">
<?php $vw_spp_ls_gaji_list_detail_belanja->akun1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_ls_gaji_list_detail_belanja->akun1->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_ls_gaji_list_detail_belanja" data-field="x_akun1" data-value-separator="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun1->DisplayValueSeparatorAttribute() ?>" id="x_akun1" name="x_akun1"<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun1->EditAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun1->SelectOptionListHtml("x_akun1") ?>
</select>
<input type="hidden" name="s_x_akun1" id="s_x_akun1" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun1->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list_detail_belanja->akun2->Visible) { // akun2 ?>
	<div id="r_akun2" class="form-group">
		<label id="elh_vw_spp_ls_gaji_list_detail_belanja_akun2" for="x_akun2" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_list_detail_belanja->akun2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun2->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_detail_belanja_akun2">
<?php $vw_spp_ls_gaji_list_detail_belanja->akun2->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_ls_gaji_list_detail_belanja->akun2->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_ls_gaji_list_detail_belanja" data-field="x_akun2" data-value-separator="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun2->DisplayValueSeparatorAttribute() ?>" id="x_akun2" name="x_akun2"<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun2->EditAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun2->SelectOptionListHtml("x_akun2") ?>
</select>
<input type="hidden" name="s_x_akun2" id="s_x_akun2" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun2->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list_detail_belanja->akun3->Visible) { // akun3 ?>
	<div id="r_akun3" class="form-group">
		<label id="elh_vw_spp_ls_gaji_list_detail_belanja_akun3" for="x_akun3" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_list_detail_belanja->akun3->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun3->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_detail_belanja_akun3">
<?php $vw_spp_ls_gaji_list_detail_belanja->akun3->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_ls_gaji_list_detail_belanja->akun3->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_ls_gaji_list_detail_belanja" data-field="x_akun3" data-value-separator="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun3->DisplayValueSeparatorAttribute() ?>" id="x_akun3" name="x_akun3"<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun3->EditAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun3->SelectOptionListHtml("x_akun3") ?>
</select>
<input type="hidden" name="s_x_akun3" id="s_x_akun3" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun3->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list_detail_belanja->akun4->Visible) { // akun4 ?>
	<div id="r_akun4" class="form-group">
		<label id="elh_vw_spp_ls_gaji_list_detail_belanja_akun4" for="x_akun4" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_list_detail_belanja->akun4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun4->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_detail_belanja_akun4">
<?php $vw_spp_ls_gaji_list_detail_belanja->akun4->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_ls_gaji_list_detail_belanja->akun4->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_ls_gaji_list_detail_belanja" data-field="x_akun4" data-value-separator="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun4->DisplayValueSeparatorAttribute() ?>" id="x_akun4" name="x_akun4"<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun4->EditAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun4->SelectOptionListHtml("x_akun4") ?>
</select>
<input type="hidden" name="s_x_akun4" id="s_x_akun4" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun4->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list_detail_belanja->akun5->Visible) { // akun5 ?>
	<div id="r_akun5" class="form-group">
		<label id="elh_vw_spp_ls_gaji_list_detail_belanja_akun5" for="x_akun5" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_list_detail_belanja->akun5->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun5->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_detail_belanja_akun5">
<select data-table="vw_spp_ls_gaji_list_detail_belanja" data-field="x_akun5" data-value-separator="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun5->DisplayValueSeparatorAttribute() ?>" id="x_akun5" name="x_akun5"<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun5->EditAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun5->SelectOptionListHtml("x_akun5") ?>
</select>
<input type="hidden" name="s_x_akun5" id="s_x_akun5" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun5->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->akun5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<div id="r_jumlah_belanja" class="form-group">
		<label id="elh_vw_spp_ls_gaji_list_detail_belanja_jumlah_belanja" for="x_jumlah_belanja" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_detail_belanja_jumlah_belanja">
<input type="text" data-table="vw_spp_ls_gaji_list_detail_belanja" data-field="x_jumlah_belanja" name="x_jumlah_belanja" id="x_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->EditAttributes() ?>>
</span>
<?php echo $vw_spp_ls_gaji_list_detail_belanja->jumlah_belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->id_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_id_spp" id="x_id_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->id_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->id_jenis_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_id_jenis_spp" id="x_id_jenis_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->id_jenis_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->detail_jenis_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_detail_jenis_spp" id="x_detail_jenis_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->detail_jenis_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->no_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_no_spp" id="x_no_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->no_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->program->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_program" id="x_program" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->program->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->kegiatan->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_kegiatan" id="x_kegiatan" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->kegiatan->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->sub_kegiatan->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_sub_kegiatan" id="x_sub_kegiatan" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->sub_kegiatan->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_ls_gaji_list_detail_belanja->tahun_anggaran->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_tahun_anggaran" id="x_tahun_anggaran" value="<?php echo ew_HtmlEncode(strval($vw_spp_ls_gaji_list_detail_belanja->tahun_anggaran->getSessionValue())) ?>">
<?php } ?>
<?php if (!$vw_spp_ls_gaji_list_detail_belanja_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spp_ls_gaji_list_detail_belanja_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spp_ls_gaji_list_detail_belanjaadd.Init();
</script>
<?php
$vw_spp_ls_gaji_list_detail_belanja_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_ls_gaji_list_detail_belanja_add->Page_Terminate();
?>
