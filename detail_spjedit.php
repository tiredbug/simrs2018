<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "detail_spjinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "t_spjinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$detail_spj_edit = NULL; // Initialize page object first

class cdetail_spj_edit extends cdetail_spj {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'detail_spj';

	// Page object name
	var $PageObjName = 'detail_spj_edit';

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

		// Table object (detail_spj)
		if (!isset($GLOBALS["detail_spj"]) || get_class($GLOBALS["detail_spj"]) == "cdetail_spj") {
			$GLOBALS["detail_spj"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detail_spj"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (t_spj)
		if (!isset($GLOBALS['t_spj'])) $GLOBALS['t_spj'] = new ct_spj();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detail_spj', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("detail_spjlist.php"));
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
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->no_spj->SetVisibility();
		$this->no_sbp->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->belanja->SetVisibility();
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();
		$this->tahun_anggaran->SetVisibility();
		$this->tgl_sbp->SetVisibility();
		$this->tgl_spj->SetVisibility();
		$this->id_spj->SetVisibility();
		$this->jenis_spj->SetVisibility();

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
		global $EW_EXPORT, $detail_spj;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detail_spj);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

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

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("detail_spjlist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("detail_spjlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "detail_spjlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->no_spj->FldIsDetailKey) {
			$this->no_spj->setFormValue($objForm->GetValue("x_no_spj"));
		}
		if (!$this->no_sbp->FldIsDetailKey) {
			$this->no_sbp->setFormValue($objForm->GetValue("x_no_sbp"));
		}
		if (!$this->kode_rekening->FldIsDetailKey) {
			$this->kode_rekening->setFormValue($objForm->GetValue("x_kode_rekening"));
		}
		if (!$this->belanja->FldIsDetailKey) {
			$this->belanja->setFormValue($objForm->GetValue("x_belanja"));
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
		if (!$this->tahun_anggaran->FldIsDetailKey) {
			$this->tahun_anggaran->setFormValue($objForm->GetValue("x_tahun_anggaran"));
		}
		if (!$this->tgl_sbp->FldIsDetailKey) {
			$this->tgl_sbp->setFormValue($objForm->GetValue("x_tgl_sbp"));
			$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0);
		}
		if (!$this->tgl_spj->FldIsDetailKey) {
			$this->tgl_spj->setFormValue($objForm->GetValue("x_tgl_spj"));
			$this->tgl_spj->CurrentValue = ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 0);
		}
		if (!$this->id_spj->FldIsDetailKey) {
			$this->id_spj->setFormValue($objForm->GetValue("x_id_spj"));
		}
		if (!$this->jenis_spj->FldIsDetailKey) {
			$this->jenis_spj->setFormValue($objForm->GetValue("x_jenis_spj"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->no_spj->CurrentValue = $this->no_spj->FormValue;
		$this->no_sbp->CurrentValue = $this->no_sbp->FormValue;
		$this->kode_rekening->CurrentValue = $this->kode_rekening->FormValue;
		$this->belanja->CurrentValue = $this->belanja->FormValue;
		$this->program->CurrentValue = $this->program->FormValue;
		$this->kegiatan->CurrentValue = $this->kegiatan->FormValue;
		$this->sub_kegiatan->CurrentValue = $this->sub_kegiatan->FormValue;
		$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->FormValue;
		$this->tgl_sbp->CurrentValue = $this->tgl_sbp->FormValue;
		$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0);
		$this->tgl_spj->CurrentValue = $this->tgl_spj->FormValue;
		$this->tgl_spj->CurrentValue = ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 0);
		$this->id_spj->CurrentValue = $this->id_spj->FormValue;
		$this->jenis_spj->CurrentValue = $this->jenis_spj->FormValue;
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
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->belanja->setDbValue($rs->fields('belanja'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->tgl_sbp->setDbValue($rs->fields('tgl_sbp'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->id_spj->setDbValue($rs->fields('id_spj'));
		$this->jenis_spj->setDbValue($rs->fields('jenis_spj'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_spj->DbValue = $row['no_spj'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->belanja->DbValue = $row['belanja'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->tgl_sbp->DbValue = $row['tgl_sbp'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->id_spj->DbValue = $row['id_spj'];
		$this->jenis_spj->DbValue = $row['jenis_spj'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->belanja->FormValue == $this->belanja->CurrentValue && is_numeric(ew_StrToFloat($this->belanja->CurrentValue)))
			$this->belanja->CurrentValue = ew_StrToFloat($this->belanja->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// no_spj
		// no_sbp
		// kode_rekening
		// belanja
		// program
		// kegiatan
		// sub_kegiatan
		// tahun_anggaran
		// tgl_sbp
		// tgl_spj
		// id_spj
		// jenis_spj

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// no_sbp
		if (strval($this->no_sbp->CurrentValue) <> "") {
			$sFilterWrk = "`no_sbp`" . ew_SearchString("=", $this->no_sbp->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `no_sbp`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_list_spj`";
		$sWhereWrk = "";
		$this->no_sbp->LookupFilters = array("dx1" => '`no_sbp`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->no_sbp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->no_sbp->ViewValue = $this->no_sbp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
			}
		} else {
			$this->no_sbp->ViewValue = NULL;
		}
		$this->no_sbp->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// belanja
		$this->belanja->ViewValue = $this->belanja->CurrentValue;
		$this->belanja->ViewCustomAttributes = "";

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

		// tgl_sbp
		$this->tgl_sbp->ViewValue = $this->tgl_sbp->CurrentValue;
		$this->tgl_sbp->ViewValue = ew_FormatDateTime($this->tgl_sbp->ViewValue, 0);
		$this->tgl_sbp->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 0);
		$this->tgl_spj->ViewCustomAttributes = "";

		// id_spj
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		$this->id_spj->ViewCustomAttributes = "";

		// jenis_spj
		if (strval($this->jenis_spj->CurrentValue) <> "") {
			$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
		} else {
			$this->jenis_spj->ViewValue = NULL;
		}
		$this->jenis_spj->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";
			$this->no_spj->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

			// belanja
			$this->belanja->LinkCustomAttributes = "";
			$this->belanja->HrefValue = "";
			$this->belanja->TooltipValue = "";

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

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";
			$this->tgl_sbp->TooltipValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";
			$this->tgl_spj->TooltipValue = "";

			// id_spj
			$this->id_spj->LinkCustomAttributes = "";
			$this->id_spj->HrefValue = "";
			$this->id_spj->TooltipValue = "";

			// jenis_spj
			$this->jenis_spj->LinkCustomAttributes = "";
			$this->jenis_spj->HrefValue = "";
			$this->jenis_spj->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// no_spj
			$this->no_spj->EditAttrs["class"] = "form-control";
			$this->no_spj->EditCustomAttributes = "";
			if ($this->no_spj->getSessionValue() <> "") {
				$this->no_spj->CurrentValue = $this->no_spj->getSessionValue();
			$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
			$this->no_spj->ViewCustomAttributes = "";
			} else {
			$this->no_spj->EditValue = ew_HtmlEncode($this->no_spj->CurrentValue);
			$this->no_spj->PlaceHolder = ew_RemoveHtml($this->no_spj->FldCaption());
			}

			// no_sbp
			$this->no_sbp->EditCustomAttributes = "";
			if (trim(strval($this->no_sbp->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`no_sbp`" . ew_SearchString("=", $this->no_sbp->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `no_sbp`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `vw_list_spj`";
			$sWhereWrk = "";
			$this->no_sbp->LookupFilters = array("dx1" => '`no_sbp`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->no_sbp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->no_sbp->ViewValue = $this->no_sbp->DisplayValue($arwrk);
			} else {
				$this->no_sbp->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->no_sbp->EditValue = $arwrk;

			// kode_rekening
			$this->kode_rekening->EditAttrs["class"] = "form-control";
			$this->kode_rekening->EditCustomAttributes = "";
			$this->kode_rekening->EditValue = ew_HtmlEncode($this->kode_rekening->CurrentValue);
			$this->kode_rekening->PlaceHolder = ew_RemoveHtml($this->kode_rekening->FldCaption());

			// belanja
			$this->belanja->EditAttrs["class"] = "form-control";
			$this->belanja->EditCustomAttributes = "";
			$this->belanja->EditValue = ew_HtmlEncode($this->belanja->CurrentValue);
			$this->belanja->PlaceHolder = ew_RemoveHtml($this->belanja->FldCaption());
			if (strval($this->belanja->EditValue) <> "" && is_numeric($this->belanja->EditValue)) $this->belanja->EditValue = ew_FormatNumber($this->belanja->EditValue, -2, -1, -2, 0);

			// program
			$this->program->EditAttrs["class"] = "form-control";
			$this->program->EditCustomAttributes = "";
			if ($this->program->getSessionValue() <> "") {
				$this->program->CurrentValue = $this->program->getSessionValue();
			$this->program->ViewValue = $this->program->CurrentValue;
			$this->program->ViewCustomAttributes = "";
			} else {
			$this->program->EditValue = ew_HtmlEncode($this->program->CurrentValue);
			$this->program->PlaceHolder = ew_RemoveHtml($this->program->FldCaption());
			}

			// kegiatan
			$this->kegiatan->EditAttrs["class"] = "form-control";
			$this->kegiatan->EditCustomAttributes = "";
			if ($this->kegiatan->getSessionValue() <> "") {
				$this->kegiatan->CurrentValue = $this->kegiatan->getSessionValue();
			$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
			$this->kegiatan->ViewCustomAttributes = "";
			} else {
			$this->kegiatan->EditValue = ew_HtmlEncode($this->kegiatan->CurrentValue);
			$this->kegiatan->PlaceHolder = ew_RemoveHtml($this->kegiatan->FldCaption());
			}

			// sub_kegiatan
			$this->sub_kegiatan->EditAttrs["class"] = "form-control";
			$this->sub_kegiatan->EditCustomAttributes = "";
			if ($this->sub_kegiatan->getSessionValue() <> "") {
				$this->sub_kegiatan->CurrentValue = $this->sub_kegiatan->getSessionValue();
			$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
			$this->sub_kegiatan->ViewCustomAttributes = "";
			} else {
			$this->sub_kegiatan->EditValue = ew_HtmlEncode($this->sub_kegiatan->CurrentValue);
			$this->sub_kegiatan->PlaceHolder = ew_RemoveHtml($this->sub_kegiatan->FldCaption());
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

			// tgl_sbp
			$this->tgl_sbp->EditAttrs["class"] = "form-control";
			$this->tgl_sbp->EditCustomAttributes = "";
			$this->tgl_sbp->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sbp->CurrentValue, 8));
			$this->tgl_sbp->PlaceHolder = ew_RemoveHtml($this->tgl_sbp->FldCaption());

			// tgl_spj
			$this->tgl_spj->EditAttrs["class"] = "form-control";
			$this->tgl_spj->EditCustomAttributes = "";
			if ($this->tgl_spj->getSessionValue() <> "") {
				$this->tgl_spj->CurrentValue = $this->tgl_spj->getSessionValue();
			$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
			$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 0);
			$this->tgl_spj->ViewCustomAttributes = "";
			} else {
			$this->tgl_spj->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_spj->CurrentValue, 8));
			$this->tgl_spj->PlaceHolder = ew_RemoveHtml($this->tgl_spj->FldCaption());
			}

			// id_spj
			$this->id_spj->EditAttrs["class"] = "form-control";
			$this->id_spj->EditCustomAttributes = "";
			if ($this->id_spj->getSessionValue() <> "") {
				$this->id_spj->CurrentValue = $this->id_spj->getSessionValue();
			$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
			$this->id_spj->ViewCustomAttributes = "";
			} else {
			$this->id_spj->EditValue = ew_HtmlEncode($this->id_spj->CurrentValue);
			$this->id_spj->PlaceHolder = ew_RemoveHtml($this->id_spj->FldCaption());
			}

			// jenis_spj
			$this->jenis_spj->EditAttrs["class"] = "form-control";
			$this->jenis_spj->EditCustomAttributes = "";
			if ($this->jenis_spj->getSessionValue() <> "") {
				$this->jenis_spj->CurrentValue = $this->jenis_spj->getSessionValue();
			if (strval($this->jenis_spj->CurrentValue) <> "") {
				$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
			} else {
				$this->jenis_spj->ViewValue = NULL;
			}
			$this->jenis_spj->ViewCustomAttributes = "";
			} else {
			$this->jenis_spj->EditValue = $this->jenis_spj->Options(TRUE);
			}

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";

			// belanja
			$this->belanja->LinkCustomAttributes = "";
			$this->belanja->HrefValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";

			// id_spj
			$this->id_spj->LinkCustomAttributes = "";
			$this->id_spj->HrefValue = "";

			// jenis_spj
			$this->jenis_spj->LinkCustomAttributes = "";
			$this->jenis_spj->HrefValue = "";
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
		if (!ew_CheckNumber($this->belanja->FormValue)) {
			ew_AddMessage($gsFormError, $this->belanja->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tahun_anggaran->FormValue)) {
			ew_AddMessage($gsFormError, $this->tahun_anggaran->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_sbp->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_sbp->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_spj->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spj->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_spj->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_spj->FldErrMsg());
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

			// no_spj
			$this->no_spj->SetDbValueDef($rsnew, $this->no_spj->CurrentValue, NULL, $this->no_spj->ReadOnly);

			// no_sbp
			$this->no_sbp->SetDbValueDef($rsnew, $this->no_sbp->CurrentValue, NULL, $this->no_sbp->ReadOnly);

			// kode_rekening
			$this->kode_rekening->SetDbValueDef($rsnew, $this->kode_rekening->CurrentValue, NULL, $this->kode_rekening->ReadOnly);

			// belanja
			$this->belanja->SetDbValueDef($rsnew, $this->belanja->CurrentValue, NULL, $this->belanja->ReadOnly);

			// program
			$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, $this->program->ReadOnly);

			// kegiatan
			$this->kegiatan->SetDbValueDef($rsnew, $this->kegiatan->CurrentValue, NULL, $this->kegiatan->ReadOnly);

			// sub_kegiatan
			$this->sub_kegiatan->SetDbValueDef($rsnew, $this->sub_kegiatan->CurrentValue, NULL, $this->sub_kegiatan->ReadOnly);

			// tahun_anggaran
			$this->tahun_anggaran->SetDbValueDef($rsnew, $this->tahun_anggaran->CurrentValue, NULL, $this->tahun_anggaran->ReadOnly);

			// tgl_sbp
			$this->tgl_sbp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0), NULL, $this->tgl_sbp->ReadOnly);

			// tgl_spj
			$this->tgl_spj->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 0), NULL, $this->tgl_spj->ReadOnly);

			// id_spj
			$this->id_spj->SetDbValueDef($rsnew, $this->id_spj->CurrentValue, NULL, $this->id_spj->ReadOnly);

			// jenis_spj
			$this->jenis_spj->SetDbValueDef($rsnew, $this->jenis_spj->CurrentValue, NULL, $this->jenis_spj->ReadOnly);

			// Check referential integrity for master table 't_spj'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_t_spj();
			$KeyValue = isset($rsnew['no_spj']) ? $rsnew['no_spj'] : $rsold['no_spj'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@no_spj@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['id_spj']) ? $rsnew['id_spj'] : $rsold['id_spj'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['tgl_spj']) ? $rsnew['tgl_spj'] : $rsold['tgl_spj'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@tgl_spj@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['program']) ? $rsnew['program'] : $rsold['program'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@program@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['kegiatan']) ? $rsnew['kegiatan'] : $rsold['kegiatan'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@kegiatan@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['tahun_anggaran']) ? $rsnew['tahun_anggaran'] : $rsold['tahun_anggaran'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@tahun_anggaran@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['sub_kegiatan']) ? $rsnew['sub_kegiatan'] : $rsold['sub_kegiatan'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@sub_kegiatan@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['jenis_spj']) ? $rsnew['jenis_spj'] : $rsold['jenis_spj'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@jenis_spj@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["t_spj"])) $GLOBALS["t_spj"] = new ct_spj();
				$rsmaster = $GLOBALS["t_spj"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "t_spj", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

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
			if ($sMasterTblVar == "t_spj") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_no_spj"] <> "") {
					$GLOBALS["t_spj"]->no_spj->setQueryStringValue($_GET["fk_no_spj"]);
					$this->no_spj->setQueryStringValue($GLOBALS["t_spj"]->no_spj->QueryStringValue);
					$this->no_spj->setSessionValue($this->no_spj->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t_spj"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_spj->setQueryStringValue($GLOBALS["t_spj"]->id->QueryStringValue);
					$this->id_spj->setSessionValue($this->id_spj->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tgl_spj"] <> "") {
					$GLOBALS["t_spj"]->tgl_spj->setQueryStringValue($_GET["fk_tgl_spj"]);
					$this->tgl_spj->setQueryStringValue($GLOBALS["t_spj"]->tgl_spj->QueryStringValue);
					$this->tgl_spj->setSessionValue($this->tgl_spj->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_program"] <> "") {
					$GLOBALS["t_spj"]->program->setQueryStringValue($_GET["fk_program"]);
					$this->program->setQueryStringValue($GLOBALS["t_spj"]->program->QueryStringValue);
					$this->program->setSessionValue($this->program->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->kegiatan->setQueryStringValue($_GET["fk_kegiatan"]);
					$this->kegiatan->setQueryStringValue($GLOBALS["t_spj"]->kegiatan->QueryStringValue);
					$this->kegiatan->setSessionValue($this->kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_spj"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["t_spj"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->sub_kegiatan->setQueryStringValue($_GET["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setQueryStringValue($GLOBALS["t_spj"]->sub_kegiatan->QueryStringValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_jenis_spj"] <> "") {
					$GLOBALS["t_spj"]->jenis_spj->setQueryStringValue($_GET["fk_jenis_spj"]);
					$this->jenis_spj->setQueryStringValue($GLOBALS["t_spj"]->jenis_spj->QueryStringValue);
					$this->jenis_spj->setSessionValue($this->jenis_spj->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->jenis_spj->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t_spj") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_no_spj"] <> "") {
					$GLOBALS["t_spj"]->no_spj->setFormValue($_POST["fk_no_spj"]);
					$this->no_spj->setFormValue($GLOBALS["t_spj"]->no_spj->FormValue);
					$this->no_spj->setSessionValue($this->no_spj->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t_spj"]->id->setFormValue($_POST["fk_id"]);
					$this->id_spj->setFormValue($GLOBALS["t_spj"]->id->FormValue);
					$this->id_spj->setSessionValue($this->id_spj->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tgl_spj"] <> "") {
					$GLOBALS["t_spj"]->tgl_spj->setFormValue($_POST["fk_tgl_spj"]);
					$this->tgl_spj->setFormValue($GLOBALS["t_spj"]->tgl_spj->FormValue);
					$this->tgl_spj->setSessionValue($this->tgl_spj->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_program"] <> "") {
					$GLOBALS["t_spj"]->program->setFormValue($_POST["fk_program"]);
					$this->program->setFormValue($GLOBALS["t_spj"]->program->FormValue);
					$this->program->setSessionValue($this->program->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->kegiatan->setFormValue($_POST["fk_kegiatan"]);
					$this->kegiatan->setFormValue($GLOBALS["t_spj"]->kegiatan->FormValue);
					$this->kegiatan->setSessionValue($this->kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_spj"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["t_spj"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->sub_kegiatan->setFormValue($_POST["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setFormValue($GLOBALS["t_spj"]->sub_kegiatan->FormValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_jenis_spj"] <> "") {
					$GLOBALS["t_spj"]->jenis_spj->setFormValue($_POST["fk_jenis_spj"]);
					$this->jenis_spj->setFormValue($GLOBALS["t_spj"]->jenis_spj->FormValue);
					$this->jenis_spj->setSessionValue($this->jenis_spj->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->jenis_spj->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_spj") {
				if ($this->no_spj->CurrentValue == "") $this->no_spj->setSessionValue("");
				if ($this->id_spj->CurrentValue == "") $this->id_spj->setSessionValue("");
				if ($this->tgl_spj->CurrentValue == "") $this->tgl_spj->setSessionValue("");
				if ($this->program->CurrentValue == "") $this->program->setSessionValue("");
				if ($this->kegiatan->CurrentValue == "") $this->kegiatan->setSessionValue("");
				if ($this->tahun_anggaran->CurrentValue == "") $this->tahun_anggaran->setSessionValue("");
				if ($this->sub_kegiatan->CurrentValue == "") $this->sub_kegiatan->setSessionValue("");
				if ($this->jenis_spj->CurrentValue == "") $this->jenis_spj->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("detail_spjlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_no_sbp":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `no_sbp` AS `LinkFld`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_list_spj`";
			$sWhereWrk = "{filter}";
			$this->no_sbp->LookupFilters = array("dx1" => '`no_sbp`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`no_sbp` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->no_sbp, $sWhereWrk); // Call Lookup selecting
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
if (!isset($detail_spj_edit)) $detail_spj_edit = new cdetail_spj_edit();

// Page init
$detail_spj_edit->Page_Init();

// Page main
$detail_spj_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detail_spj_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fdetail_spjedit = new ew_Form("fdetail_spjedit", "edit");

// Validate form
fdetail_spjedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->belanja->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tahun_anggaran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->tahun_anggaran->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_sbp");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->tgl_sbp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_spj");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->tgl_spj->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_spj");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->id_spj->FldErrMsg()) ?>");

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
fdetail_spjedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetail_spjedit.ValidateRequired = true;
<?php } else { ?>
fdetail_spjedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetail_spjedit.Lists["x_no_sbp"] = {"LinkField":"x_no_sbp","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_sbp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_list_spj"};
fdetail_spjedit.Lists["x_jenis_spj"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdetail_spjedit.Lists["x_jenis_spj"].Options = <?php echo json_encode($detail_spj->jenis_spj->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$detail_spj_edit->IsModal) { ?>
<?php } ?>
<?php $detail_spj_edit->ShowPageHeader(); ?>
<?php
$detail_spj_edit->ShowMessage();
?>
<form name="fdetail_spjedit" id="fdetail_spjedit" class="<?php echo $detail_spj_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detail_spj_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detail_spj_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detail_spj">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($detail_spj_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($detail_spj->getCurrentMasterTable() == "t_spj") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_spj">
<input type="hidden" name="fk_no_spj" value="<?php echo $detail_spj->no_spj->getSessionValue() ?>">
<input type="hidden" name="fk_id" value="<?php echo $detail_spj->id_spj->getSessionValue() ?>">
<input type="hidden" name="fk_tgl_spj" value="<?php echo $detail_spj->tgl_spj->getSessionValue() ?>">
<input type="hidden" name="fk_program" value="<?php echo $detail_spj->program->getSessionValue() ?>">
<input type="hidden" name="fk_kegiatan" value="<?php echo $detail_spj->kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_tahun_anggaran" value="<?php echo $detail_spj->tahun_anggaran->getSessionValue() ?>">
<input type="hidden" name="fk_sub_kegiatan" value="<?php echo $detail_spj->sub_kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_jenis_spj" value="<?php echo $detail_spj->jenis_spj->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($detail_spj->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_detail_spj_id" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->id->CellAttributes() ?>>
<span id="el_detail_spj_id">
<span<?php echo $detail_spj->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($detail_spj->id->CurrentValue) ?>">
<?php echo $detail_spj->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->no_spj->Visible) { // no_spj ?>
	<div id="r_no_spj" class="form-group">
		<label id="elh_detail_spj_no_spj" for="x_no_spj" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->no_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->no_spj->CellAttributes() ?>>
<?php if ($detail_spj->no_spj->getSessionValue() <> "") { ?>
<span id="el_detail_spj_no_spj">
<span<?php echo $detail_spj->no_spj->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->no_spj->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_no_spj" name="x_no_spj" value="<?php echo ew_HtmlEncode($detail_spj->no_spj->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_no_spj">
<input type="text" data-table="detail_spj" data-field="x_no_spj" name="x_no_spj" id="x_no_spj" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->no_spj->getPlaceHolder()) ?>" value="<?php echo $detail_spj->no_spj->EditValue ?>"<?php echo $detail_spj->no_spj->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->no_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->no_sbp->Visible) { // no_sbp ?>
	<div id="r_no_sbp" class="form-group">
		<label id="elh_detail_spj_no_sbp" for="x_no_sbp" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->no_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->no_sbp->CellAttributes() ?>>
<span id="el_detail_spj_no_sbp">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_no_sbp"><?php echo (strval($detail_spj->no_sbp->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $detail_spj->no_sbp->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($detail_spj->no_sbp->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_no_sbp',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="detail_spj" data-field="x_no_sbp" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $detail_spj->no_sbp->DisplayValueSeparatorAttribute() ?>" name="x_no_sbp" id="x_no_sbp" value="<?php echo $detail_spj->no_sbp->CurrentValue ?>"<?php echo $detail_spj->no_sbp->EditAttributes() ?>>
<input type="hidden" name="s_x_no_sbp" id="s_x_no_sbp" value="<?php echo $detail_spj->no_sbp->LookupFilterQuery() ?>">
</span>
<?php echo $detail_spj->no_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->kode_rekening->Visible) { // kode_rekening ?>
	<div id="r_kode_rekening" class="form-group">
		<label id="elh_detail_spj_kode_rekening" for="x_kode_rekening" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->kode_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->kode_rekening->CellAttributes() ?>>
<span id="el_detail_spj_kode_rekening">
<input type="text" data-table="detail_spj" data-field="x_kode_rekening" name="x_kode_rekening" id="x_kode_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->kode_rekening->getPlaceHolder()) ?>" value="<?php echo $detail_spj->kode_rekening->EditValue ?>"<?php echo $detail_spj->kode_rekening->EditAttributes() ?>>
</span>
<?php echo $detail_spj->kode_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->belanja->Visible) { // belanja ?>
	<div id="r_belanja" class="form-group">
		<label id="elh_detail_spj_belanja" for="x_belanja" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->belanja->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->belanja->CellAttributes() ?>>
<span id="el_detail_spj_belanja">
<input type="text" data-table="detail_spj" data-field="x_belanja" name="x_belanja" id="x_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->belanja->getPlaceHolder()) ?>" value="<?php echo $detail_spj->belanja->EditValue ?>"<?php echo $detail_spj->belanja->EditAttributes() ?>>
</span>
<?php echo $detail_spj->belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_detail_spj_program" for="x_program" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->program->CellAttributes() ?>>
<?php if ($detail_spj->program->getSessionValue() <> "") { ?>
<span id="el_detail_spj_program">
<span<?php echo $detail_spj->program->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->program->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_program" name="x_program" value="<?php echo ew_HtmlEncode($detail_spj->program->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_program">
<input type="text" data-table="detail_spj" data-field="x_program" name="x_program" id="x_program" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->program->getPlaceHolder()) ?>" value="<?php echo $detail_spj->program->EditValue ?>"<?php echo $detail_spj->program->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->kegiatan->Visible) { // kegiatan ?>
	<div id="r_kegiatan" class="form-group">
		<label id="elh_detail_spj_kegiatan" for="x_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->kegiatan->CellAttributes() ?>>
<?php if ($detail_spj->kegiatan->getSessionValue() <> "") { ?>
<span id="el_detail_spj_kegiatan">
<span<?php echo $detail_spj->kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_kegiatan" name="x_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_kegiatan">
<input type="text" data-table="detail_spj" data-field="x_kegiatan" name="x_kegiatan" id="x_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->kegiatan->getPlaceHolder()) ?>" value="<?php echo $detail_spj->kegiatan->EditValue ?>"<?php echo $detail_spj->kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<div id="r_sub_kegiatan" class="form-group">
		<label id="elh_detail_spj_sub_kegiatan" for="x_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->sub_kegiatan->CellAttributes() ?>>
<?php if ($detail_spj->sub_kegiatan->getSessionValue() <> "") { ?>
<span id="el_detail_spj_sub_kegiatan">
<span<?php echo $detail_spj->sub_kegiatan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->sub_kegiatan->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_sub_kegiatan" name="x_sub_kegiatan" value="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_sub_kegiatan">
<input type="text" data-table="detail_spj" data-field="x_sub_kegiatan" name="x_sub_kegiatan" id="x_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $detail_spj->sub_kegiatan->EditValue ?>"<?php echo $detail_spj->sub_kegiatan->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<div id="r_tahun_anggaran" class="form-group">
		<label id="elh_detail_spj_tahun_anggaran" for="x_tahun_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->tahun_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->tahun_anggaran->CellAttributes() ?>>
<?php if ($detail_spj->tahun_anggaran->getSessionValue() <> "") { ?>
<span id="el_detail_spj_tahun_anggaran">
<span<?php echo $detail_spj->tahun_anggaran->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->tahun_anggaran->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_tahun_anggaran" name="x_tahun_anggaran" value="<?php echo ew_HtmlEncode($detail_spj->tahun_anggaran->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_tahun_anggaran">
<input type="text" data-table="detail_spj" data-field="x_tahun_anggaran" name="x_tahun_anggaran" id="x_tahun_anggaran" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->tahun_anggaran->getPlaceHolder()) ?>" value="<?php echo $detail_spj->tahun_anggaran->EditValue ?>"<?php echo $detail_spj->tahun_anggaran->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->tahun_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->tgl_sbp->Visible) { // tgl_sbp ?>
	<div id="r_tgl_sbp" class="form-group">
		<label id="elh_detail_spj_tgl_sbp" for="x_tgl_sbp" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->tgl_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->tgl_sbp->CellAttributes() ?>>
<span id="el_detail_spj_tgl_sbp">
<input type="text" data-table="detail_spj" data-field="x_tgl_sbp" name="x_tgl_sbp" id="x_tgl_sbp" placeholder="<?php echo ew_HtmlEncode($detail_spj->tgl_sbp->getPlaceHolder()) ?>" value="<?php echo $detail_spj->tgl_sbp->EditValue ?>"<?php echo $detail_spj->tgl_sbp->EditAttributes() ?>>
</span>
<?php echo $detail_spj->tgl_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->tgl_spj->Visible) { // tgl_spj ?>
	<div id="r_tgl_spj" class="form-group">
		<label id="elh_detail_spj_tgl_spj" for="x_tgl_spj" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->tgl_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->tgl_spj->CellAttributes() ?>>
<?php if ($detail_spj->tgl_spj->getSessionValue() <> "") { ?>
<span id="el_detail_spj_tgl_spj">
<span<?php echo $detail_spj->tgl_spj->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->tgl_spj->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_tgl_spj" name="x_tgl_spj" value="<?php echo ew_HtmlEncode(ew_FormatDateTime($detail_spj->tgl_spj->CurrentValue, 0)) ?>">
<?php } else { ?>
<span id="el_detail_spj_tgl_spj">
<input type="text" data-table="detail_spj" data-field="x_tgl_spj" name="x_tgl_spj" id="x_tgl_spj" placeholder="<?php echo ew_HtmlEncode($detail_spj->tgl_spj->getPlaceHolder()) ?>" value="<?php echo $detail_spj->tgl_spj->EditValue ?>"<?php echo $detail_spj->tgl_spj->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->tgl_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->id_spj->Visible) { // id_spj ?>
	<div id="r_id_spj" class="form-group">
		<label id="elh_detail_spj_id_spj" for="x_id_spj" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->id_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->id_spj->CellAttributes() ?>>
<?php if ($detail_spj->id_spj->getSessionValue() <> "") { ?>
<span id="el_detail_spj_id_spj">
<span<?php echo $detail_spj->id_spj->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->id_spj->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_id_spj" name="x_id_spj" value="<?php echo ew_HtmlEncode($detail_spj->id_spj->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_id_spj">
<input type="text" data-table="detail_spj" data-field="x_id_spj" name="x_id_spj" id="x_id_spj" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->id_spj->getPlaceHolder()) ?>" value="<?php echo $detail_spj->id_spj->EditValue ?>"<?php echo $detail_spj->id_spj->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->id_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->jenis_spj->Visible) { // jenis_spj ?>
	<div id="r_jenis_spj" class="form-group">
		<label id="elh_detail_spj_jenis_spj" for="x_jenis_spj" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->jenis_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->jenis_spj->CellAttributes() ?>>
<?php if ($detail_spj->jenis_spj->getSessionValue() <> "") { ?>
<span id="el_detail_spj_jenis_spj">
<span<?php echo $detail_spj->jenis_spj->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->jenis_spj->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_jenis_spj" name="x_jenis_spj" value="<?php echo ew_HtmlEncode($detail_spj->jenis_spj->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_jenis_spj">
<select data-table="detail_spj" data-field="x_jenis_spj" data-value-separator="<?php echo $detail_spj->jenis_spj->DisplayValueSeparatorAttribute() ?>" id="x_jenis_spj" name="x_jenis_spj"<?php echo $detail_spj->jenis_spj->EditAttributes() ?>>
<?php echo $detail_spj->jenis_spj->SelectOptionListHtml("x_jenis_spj") ?>
</select>
</span>
<?php } ?>
<?php echo $detail_spj->jenis_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$detail_spj_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $detail_spj_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdetail_spjedit.Init();
</script>
<?php
$detail_spj_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$detail_spj_edit->Page_Terminate();
?>
