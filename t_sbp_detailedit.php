<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_sbp_detailinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "t_sbpinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_sbp_detail_edit = NULL; // Initialize page object first

class ct_sbp_detail_edit extends ct_sbp_detail {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sbp_detail';

	// Page object name
	var $PageObjName = 't_sbp_detail_edit';

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

		// Table object (t_sbp_detail)
		if (!isset($GLOBALS["t_sbp_detail"]) || get_class($GLOBALS["t_sbp_detail"]) == "ct_sbp_detail") {
			$GLOBALS["t_sbp_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_sbp_detail"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (t_sbp)
		if (!isset($GLOBALS['t_sbp'])) $GLOBALS['t_sbp'] = new ct_sbp();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_sbp_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_sbp_detaillist.php"));
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
		$this->uraian_tambahan->SetVisibility();

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
		global $EW_EXPORT, $t_sbp_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_sbp_detail);
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
			$this->Page_Terminate("t_sbp_detaillist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("t_sbp_detaillist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t_sbp_detaillist.php")
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
		if (!$this->uraian_tambahan->FldIsDetailKey) {
			$this->uraian_tambahan->setFormValue($objForm->GetValue("x_uraian_tambahan"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->akun1->CurrentValue = $this->akun1->FormValue;
		$this->akun2->CurrentValue = $this->akun2->FormValue;
		$this->akun3->CurrentValue = $this->akun3->FormValue;
		$this->akun4->CurrentValue = $this->akun4->FormValue;
		$this->akun5->CurrentValue = $this->akun5->FormValue;
		$this->jumlah_belanja->CurrentValue = $this->jumlah_belanja->FormValue;
		$this->uraian_tambahan->CurrentValue = $this->uraian_tambahan->FormValue;
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
		$this->id_sbp->setDbValue($rs->fields('id_sbp'));
		$this->tipe_sbp->setDbValue($rs->fields('tipe_sbp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->kd_rekening_belanja->setDbValue($rs->fields('kd_rekening_belanja'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->uraian_tambahan->setDbValue($rs->fields('uraian_tambahan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_sbp->DbValue = $row['id_sbp'];
		$this->tipe_sbp->DbValue = $row['tipe_sbp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->kd_rekening_belanja->DbValue = $row['kd_rekening_belanja'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
		$this->uraian_tambahan->DbValue = $row['uraian_tambahan'];
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
		// id_sbp
		// tipe_sbp
		// detail_jenis_spp
		// no_sbp
		// program
		// kegiatan
		// sub_kegiatan
		// tahun_anggaran
		// kd_rekening_belanja
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5
		// jumlah_belanja
		// uraian_tambahan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_sbp
		$this->id_sbp->ViewValue = $this->id_sbp->CurrentValue;
		$this->id_sbp->ViewCustomAttributes = "";

		// tipe_sbp
		$this->tipe_sbp->ViewValue = $this->tipe_sbp->CurrentValue;
		$this->tipe_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

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

		// kd_rekening_belanja
		$this->kd_rekening_belanja->ViewValue = $this->kd_rekening_belanja->CurrentValue;
		$this->kd_rekening_belanja->ViewCustomAttributes = "";

		// akun1
		if (strval($this->akun1->CurrentValue) <> "") {
			$sFilterWrk = "`kel1`" . ew_SearchString("=", $this->akun1->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kel1`, `nmkel1` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun1`";
		$sWhereWrk = "";
		$this->akun1->LookupFilters = array();
		$lookuptblfilter = "`kel1`= 5";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

		// uraian_tambahan
		$this->uraian_tambahan->ViewValue = $this->uraian_tambahan->CurrentValue;
		$this->uraian_tambahan->ViewCustomAttributes = "";

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

			// uraian_tambahan
			$this->uraian_tambahan->LinkCustomAttributes = "";
			$this->uraian_tambahan->HrefValue = "";
			$this->uraian_tambahan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			$lookuptblfilter = "`kel1`= 5";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

			// uraian_tambahan
			$this->uraian_tambahan->EditAttrs["class"] = "form-control";
			$this->uraian_tambahan->EditCustomAttributes = "";
			$this->uraian_tambahan->EditValue = ew_HtmlEncode($this->uraian_tambahan->CurrentValue);
			$this->uraian_tambahan->PlaceHolder = ew_RemoveHtml($this->uraian_tambahan->FldCaption());

			// Edit refer script
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

			// uraian_tambahan
			$this->uraian_tambahan->LinkCustomAttributes = "";
			$this->uraian_tambahan->HrefValue = "";
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

			// akun1
			$this->akun1->SetDbValueDef($rsnew, $this->akun1->CurrentValue, NULL, $this->akun1->ReadOnly);

			// akun2
			$this->akun2->SetDbValueDef($rsnew, $this->akun2->CurrentValue, NULL, $this->akun2->ReadOnly);

			// akun3
			$this->akun3->SetDbValueDef($rsnew, $this->akun3->CurrentValue, NULL, $this->akun3->ReadOnly);

			// akun4
			$this->akun4->SetDbValueDef($rsnew, $this->akun4->CurrentValue, NULL, $this->akun4->ReadOnly);

			// akun5
			$this->akun5->SetDbValueDef($rsnew, $this->akun5->CurrentValue, NULL, $this->akun5->ReadOnly);

			// jumlah_belanja
			$this->jumlah_belanja->SetDbValueDef($rsnew, $this->jumlah_belanja->CurrentValue, NULL, $this->jumlah_belanja->ReadOnly);

			// uraian_tambahan
			$this->uraian_tambahan->SetDbValueDef($rsnew, $this->uraian_tambahan->CurrentValue, NULL, $this->uraian_tambahan->ReadOnly);

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
			if ($sMasterTblVar == "t_sbp") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t_sbp"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_sbp->setQueryStringValue($GLOBALS["t_sbp"]->id->QueryStringValue);
					$this->id_sbp->setSessionValue($this->id_sbp->QueryStringValue);
					if (!is_numeric($GLOBALS["t_sbp"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tipe_sbp"] <> "") {
					$GLOBALS["t_sbp"]->tipe_sbp->setQueryStringValue($_GET["fk_tipe_sbp"]);
					$this->tipe_sbp->setQueryStringValue($GLOBALS["t_sbp"]->tipe_sbp->QueryStringValue);
					$this->tipe_sbp->setSessionValue($this->tipe_sbp->QueryStringValue);
					if (!is_numeric($GLOBALS["t_sbp"]->tipe_sbp->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_no_sbp"] <> "") {
					$GLOBALS["t_sbp"]->no_sbp->setQueryStringValue($_GET["fk_no_sbp"]);
					$this->no_sbp->setQueryStringValue($GLOBALS["t_sbp"]->no_sbp->QueryStringValue);
					$this->no_sbp->setSessionValue($this->no_sbp->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_program"] <> "") {
					$GLOBALS["t_sbp"]->program->setQueryStringValue($_GET["fk_program"]);
					$this->program->setQueryStringValue($GLOBALS["t_sbp"]->program->QueryStringValue);
					$this->program->setSessionValue($this->program->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kegiatan"] <> "") {
					$GLOBALS["t_sbp"]->kegiatan->setQueryStringValue($_GET["fk_kegiatan"]);
					$this->kegiatan->setQueryStringValue($GLOBALS["t_sbp"]->kegiatan->QueryStringValue);
					$this->kegiatan->setSessionValue($this->kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_sbp"]->sub_kegiatan->setQueryStringValue($_GET["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setQueryStringValue($GLOBALS["t_sbp"]->sub_kegiatan->QueryStringValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_sbp"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["t_sbp"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["t_sbp"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t_sbp") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t_sbp"]->id->setFormValue($_POST["fk_id"]);
					$this->id_sbp->setFormValue($GLOBALS["t_sbp"]->id->FormValue);
					$this->id_sbp->setSessionValue($this->id_sbp->FormValue);
					if (!is_numeric($GLOBALS["t_sbp"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tipe_sbp"] <> "") {
					$GLOBALS["t_sbp"]->tipe_sbp->setFormValue($_POST["fk_tipe_sbp"]);
					$this->tipe_sbp->setFormValue($GLOBALS["t_sbp"]->tipe_sbp->FormValue);
					$this->tipe_sbp->setSessionValue($this->tipe_sbp->FormValue);
					if (!is_numeric($GLOBALS["t_sbp"]->tipe_sbp->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_no_sbp"] <> "") {
					$GLOBALS["t_sbp"]->no_sbp->setFormValue($_POST["fk_no_sbp"]);
					$this->no_sbp->setFormValue($GLOBALS["t_sbp"]->no_sbp->FormValue);
					$this->no_sbp->setSessionValue($this->no_sbp->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_program"] <> "") {
					$GLOBALS["t_sbp"]->program->setFormValue($_POST["fk_program"]);
					$this->program->setFormValue($GLOBALS["t_sbp"]->program->FormValue);
					$this->program->setSessionValue($this->program->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kegiatan"] <> "") {
					$GLOBALS["t_sbp"]->kegiatan->setFormValue($_POST["fk_kegiatan"]);
					$this->kegiatan->setFormValue($GLOBALS["t_sbp"]->kegiatan->FormValue);
					$this->kegiatan->setSessionValue($this->kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_sbp"]->sub_kegiatan->setFormValue($_POST["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setFormValue($GLOBALS["t_sbp"]->sub_kegiatan->FormValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_sbp"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["t_sbp"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["t_sbp"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "t_sbp") {
				if ($this->id_sbp->CurrentValue == "") $this->id_sbp->setSessionValue("");
				if ($this->tipe_sbp->CurrentValue == "") $this->tipe_sbp->setSessionValue("");
				if ($this->no_sbp->CurrentValue == "") $this->no_sbp->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_sbp_detaillist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
			$lookuptblfilter = "`kel1`= 5";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
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
if (!isset($t_sbp_detail_edit)) $t_sbp_detail_edit = new ct_sbp_detail_edit();

// Page init
$t_sbp_detail_edit->Page_Init();

// Page main
$t_sbp_detail_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sbp_detail_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft_sbp_detailedit = new ew_Form("ft_sbp_detailedit", "edit");

// Validate form
ft_sbp_detailedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sbp_detail->jumlah_belanja->FldErrMsg()) ?>");

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
ft_sbp_detailedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sbp_detailedit.ValidateRequired = true;
<?php } else { ?>
ft_sbp_detailedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sbp_detailedit.Lists["x_akun1"] = {"LinkField":"x_kel1","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel1","","",""],"ParentFields":[],"ChildFields":["x_akun2","x_akun3","x_akun4","x_akun5"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun1"};
ft_sbp_detailedit.Lists["x_akun2"] = {"LinkField":"x_kel2","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel2","","",""],"ParentFields":["x_akun1"],"ChildFields":["x_akun3","x_akun4","x_akun5"],"FilterFields":["x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun2"};
ft_sbp_detailedit.Lists["x_akun3"] = {"LinkField":"x_kel3","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel3","","",""],"ParentFields":["x_akun2","x_akun1"],"ChildFields":["x_akun4","x_akun5"],"FilterFields":["x_kel2","x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun3"};
ft_sbp_detailedit.Lists["x_akun4"] = {"LinkField":"x_kel4","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel4","","",""],"ParentFields":["x_akun3","x_akun2","x_akun1"],"ChildFields":["x_akun5"],"FilterFields":["x_kel3","x_kel2","x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun4"};
ft_sbp_detailedit.Lists["x_akun5"] = {"LinkField":"x_akun5","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_akun","","",""],"ParentFields":["x_akun4","x_akun3","x_akun2","x_akun1"],"ChildFields":[],"FilterFields":["x_akun4","x_akun3","x_akun2","x_akun1"],"Options":[],"Template":"","LinkTable":"keu_akun5"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_sbp_detail_edit->IsModal) { ?>
<?php } ?>
<?php $t_sbp_detail_edit->ShowPageHeader(); ?>
<?php
$t_sbp_detail_edit->ShowMessage();
?>
<form name="ft_sbp_detailedit" id="ft_sbp_detailedit" class="<?php echo $t_sbp_detail_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_sbp_detail_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_sbp_detail_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_sbp_detail">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t_sbp_detail_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($t_sbp_detail->getCurrentMasterTable() == "t_sbp") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_sbp">
<input type="hidden" name="fk_id" value="<?php echo $t_sbp_detail->id_sbp->getSessionValue() ?>">
<input type="hidden" name="fk_tipe_sbp" value="<?php echo $t_sbp_detail->tipe_sbp->getSessionValue() ?>">
<input type="hidden" name="fk_no_sbp" value="<?php echo $t_sbp_detail->no_sbp->getSessionValue() ?>">
<input type="hidden" name="fk_program" value="<?php echo $t_sbp_detail->program->getSessionValue() ?>">
<input type="hidden" name="fk_kegiatan" value="<?php echo $t_sbp_detail->kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_sub_kegiatan" value="<?php echo $t_sbp_detail->sub_kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_tahun_anggaran" value="<?php echo $t_sbp_detail->tahun_anggaran->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($t_sbp_detail->akun1->Visible) { // akun1 ?>
	<div id="r_akun1" class="form-group">
		<label id="elh_t_sbp_detail_akun1" for="x_akun1" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp_detail->akun1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp_detail->akun1->CellAttributes() ?>>
<span id="el_t_sbp_detail_akun1">
<?php $t_sbp_detail->akun1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp_detail->akun1->EditAttrs["onchange"]; ?>
<select data-table="t_sbp_detail" data-field="x_akun1" data-value-separator="<?php echo $t_sbp_detail->akun1->DisplayValueSeparatorAttribute() ?>" id="x_akun1" name="x_akun1"<?php echo $t_sbp_detail->akun1->EditAttributes() ?>>
<?php echo $t_sbp_detail->akun1->SelectOptionListHtml("x_akun1") ?>
</select>
<input type="hidden" name="s_x_akun1" id="s_x_akun1" value="<?php echo $t_sbp_detail->akun1->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp_detail->akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp_detail->akun2->Visible) { // akun2 ?>
	<div id="r_akun2" class="form-group">
		<label id="elh_t_sbp_detail_akun2" for="x_akun2" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp_detail->akun2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp_detail->akun2->CellAttributes() ?>>
<span id="el_t_sbp_detail_akun2">
<?php $t_sbp_detail->akun2->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp_detail->akun2->EditAttrs["onchange"]; ?>
<select data-table="t_sbp_detail" data-field="x_akun2" data-value-separator="<?php echo $t_sbp_detail->akun2->DisplayValueSeparatorAttribute() ?>" id="x_akun2" name="x_akun2"<?php echo $t_sbp_detail->akun2->EditAttributes() ?>>
<?php echo $t_sbp_detail->akun2->SelectOptionListHtml("x_akun2") ?>
</select>
<input type="hidden" name="s_x_akun2" id="s_x_akun2" value="<?php echo $t_sbp_detail->akun2->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp_detail->akun2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp_detail->akun3->Visible) { // akun3 ?>
	<div id="r_akun3" class="form-group">
		<label id="elh_t_sbp_detail_akun3" for="x_akun3" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp_detail->akun3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp_detail->akun3->CellAttributes() ?>>
<span id="el_t_sbp_detail_akun3">
<?php $t_sbp_detail->akun3->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp_detail->akun3->EditAttrs["onchange"]; ?>
<select data-table="t_sbp_detail" data-field="x_akun3" data-value-separator="<?php echo $t_sbp_detail->akun3->DisplayValueSeparatorAttribute() ?>" id="x_akun3" name="x_akun3"<?php echo $t_sbp_detail->akun3->EditAttributes() ?>>
<?php echo $t_sbp_detail->akun3->SelectOptionListHtml("x_akun3") ?>
</select>
<input type="hidden" name="s_x_akun3" id="s_x_akun3" value="<?php echo $t_sbp_detail->akun3->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp_detail->akun3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp_detail->akun4->Visible) { // akun4 ?>
	<div id="r_akun4" class="form-group">
		<label id="elh_t_sbp_detail_akun4" for="x_akun4" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp_detail->akun4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp_detail->akun4->CellAttributes() ?>>
<span id="el_t_sbp_detail_akun4">
<?php $t_sbp_detail->akun4->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp_detail->akun4->EditAttrs["onchange"]; ?>
<select data-table="t_sbp_detail" data-field="x_akun4" data-value-separator="<?php echo $t_sbp_detail->akun4->DisplayValueSeparatorAttribute() ?>" id="x_akun4" name="x_akun4"<?php echo $t_sbp_detail->akun4->EditAttributes() ?>>
<?php echo $t_sbp_detail->akun4->SelectOptionListHtml("x_akun4") ?>
</select>
<input type="hidden" name="s_x_akun4" id="s_x_akun4" value="<?php echo $t_sbp_detail->akun4->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp_detail->akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp_detail->akun5->Visible) { // akun5 ?>
	<div id="r_akun5" class="form-group">
		<label id="elh_t_sbp_detail_akun5" for="x_akun5" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp_detail->akun5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp_detail->akun5->CellAttributes() ?>>
<span id="el_t_sbp_detail_akun5">
<select data-table="t_sbp_detail" data-field="x_akun5" data-value-separator="<?php echo $t_sbp_detail->akun5->DisplayValueSeparatorAttribute() ?>" id="x_akun5" name="x_akun5"<?php echo $t_sbp_detail->akun5->EditAttributes() ?>>
<?php echo $t_sbp_detail->akun5->SelectOptionListHtml("x_akun5") ?>
</select>
<input type="hidden" name="s_x_akun5" id="s_x_akun5" value="<?php echo $t_sbp_detail->akun5->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp_detail->akun5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<div id="r_jumlah_belanja" class="form-group">
		<label id="elh_t_sbp_detail_jumlah_belanja" for="x_jumlah_belanja" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp_detail->jumlah_belanja->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp_detail->jumlah_belanja->CellAttributes() ?>>
<span id="el_t_sbp_detail_jumlah_belanja">
<input type="text" data-table="t_sbp_detail" data-field="x_jumlah_belanja" name="x_jumlah_belanja" id="x_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp_detail->jumlah_belanja->EditValue ?>"<?php echo $t_sbp_detail->jumlah_belanja->EditAttributes() ?>>
</span>
<?php echo $t_sbp_detail->jumlah_belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp_detail->uraian_tambahan->Visible) { // uraian_tambahan ?>
	<div id="r_uraian_tambahan" class="form-group">
		<label id="elh_t_sbp_detail_uraian_tambahan" for="x_uraian_tambahan" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp_detail->uraian_tambahan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp_detail->uraian_tambahan->CellAttributes() ?>>
<span id="el_t_sbp_detail_uraian_tambahan">
<textarea data-table="t_sbp_detail" data-field="x_uraian_tambahan" name="x_uraian_tambahan" id="x_uraian_tambahan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t_sbp_detail->uraian_tambahan->getPlaceHolder()) ?>"<?php echo $t_sbp_detail->uraian_tambahan->EditAttributes() ?>><?php echo $t_sbp_detail->uraian_tambahan->EditValue ?></textarea>
</span>
<?php echo $t_sbp_detail->uraian_tambahan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="t_sbp_detail" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t_sbp_detail->id->CurrentValue) ?>">
<?php if (!$t_sbp_detail_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_sbp_detail_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_sbp_detailedit.Init();
</script>
<?php
$t_sbp_detail_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_sbp_detail_edit->Page_Terminate();
?>
