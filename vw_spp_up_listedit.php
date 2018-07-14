<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_up_listinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_up_list_edit = NULL; // Initialize page object first

class cvw_spp_up_list_edit extends cvw_spp_up_list {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_up_list';

	// Page object name
	var $PageObjName = 'vw_spp_up_list_edit';

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

		// Table object (vw_spp_up_list)
		if (!isset($GLOBALS["vw_spp_up_list"]) || get_class($GLOBALS["vw_spp_up_list"]) == "cvw_spp_up_list") {
			$GLOBALS["vw_spp_up_list"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_up_list"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_up_list', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_up_listlist.php"));
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
		$this->status_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();
		$this->kode_kegiatan->SetVisibility();
		$this->kode_sub_kegiatan->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->jumlah_up->SetVisibility();
		$this->jumlah_spd->SetVisibility();
		$this->nomer_dasar_spd->SetVisibility();
		$this->tanggal_spd->SetVisibility();

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
		global $EW_EXPORT, $vw_spp_up_list;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_up_list);
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

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("vw_spp_up_listlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_spp_up_listlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_spp_up_listlist.php")
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
		if (!$this->status_spp->FldIsDetailKey) {
			$this->status_spp->setFormValue($objForm->GetValue("x_status_spp"));
		}
		if (!$this->no_spp->FldIsDetailKey) {
			$this->no_spp->setFormValue($objForm->GetValue("x_no_spp"));
		}
		if (!$this->tgl_spp->FldIsDetailKey) {
			$this->tgl_spp->setFormValue($objForm->GetValue("x_tgl_spp"));
			$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7);
		}
		if (!$this->kode_kegiatan->FldIsDetailKey) {
			$this->kode_kegiatan->setFormValue($objForm->GetValue("x_kode_kegiatan"));
		}
		if (!$this->kode_sub_kegiatan->FldIsDetailKey) {
			$this->kode_sub_kegiatan->setFormValue($objForm->GetValue("x_kode_sub_kegiatan"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->jumlah_up->FldIsDetailKey) {
			$this->jumlah_up->setFormValue($objForm->GetValue("x_jumlah_up"));
		}
		if (!$this->jumlah_spd->FldIsDetailKey) {
			$this->jumlah_spd->setFormValue($objForm->GetValue("x_jumlah_spd"));
		}
		if (!$this->nomer_dasar_spd->FldIsDetailKey) {
			$this->nomer_dasar_spd->setFormValue($objForm->GetValue("x_nomer_dasar_spd"));
		}
		if (!$this->tanggal_spd->FldIsDetailKey) {
			$this->tanggal_spd->setFormValue($objForm->GetValue("x_tanggal_spd"));
			$this->tanggal_spd->CurrentValue = ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0);
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->status_spp->CurrentValue = $this->status_spp->FormValue;
		$this->no_spp->CurrentValue = $this->no_spp->FormValue;
		$this->tgl_spp->CurrentValue = $this->tgl_spp->FormValue;
		$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7);
		$this->kode_kegiatan->CurrentValue = $this->kode_kegiatan->FormValue;
		$this->kode_sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->jumlah_up->CurrentValue = $this->jumlah_up->FormValue;
		$this->jumlah_spd->CurrentValue = $this->jumlah_spd->FormValue;
		$this->nomer_dasar_spd->CurrentValue = $this->nomer_dasar_spd->FormValue;
		$this->tanggal_spd->CurrentValue = $this->tanggal_spd->FormValue;
		$this->tanggal_spd->CurrentValue = ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0);
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
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->status_spp->setDbValue($rs->fields('status_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->jumlah_up->setDbValue($rs->fields('jumlah_up'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->status_spp->DbValue = $row['status_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->tgl_spp->DbValue = $row['tgl_spp'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->jumlah_up->DbValue = $row['jumlah_up'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
		$this->nomer_dasar_spd->DbValue = $row['nomer_dasar_spd'];
		$this->tanggal_spd->DbValue = $row['tanggal_spd'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->jumlah_up->FormValue == $this->jumlah_up->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_up->CurrentValue)))
			$this->jumlah_up->CurrentValue = ew_StrToFloat($this->jumlah_up->CurrentValue);

		// Convert decimal values if posted back
		if ($this->jumlah_spd->FormValue == $this->jumlah_spd->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_spd->CurrentValue)))
			$this->jumlah_spd->CurrentValue = ew_StrToFloat($this->jumlah_spd->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_jenis_spp
		// detail_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// kode_kegiatan
		// kode_sub_kegiatan
		// keterangan
		// jumlah_up
		// jumlah_spd
		// nomer_dasar_spd
		// tanggal_spd

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		if (strval($this->id_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_spp`";
		$sWhereWrk = "";
		$this->id_jenis_spp->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
			}
		} else {
			$this->id_jenis_spp->ViewValue = NULL;
		}
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		if (strval($this->detail_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->detail_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_detail_spp`";
		$sWhereWrk = "";
		$this->detail_jenis_spp->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
			}
		} else {
			$this->detail_jenis_spp->ViewValue = NULL;
		}
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// status_spp
		if (strval($this->status_spp->CurrentValue) <> "") {
			$this->status_spp->ViewValue = $this->status_spp->OptionCaption($this->status_spp->CurrentValue);
		} else {
			$this->status_spp->ViewValue = NULL;
		}
		$this->status_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// tgl_spp
		$this->tgl_spp->ViewValue = $this->tgl_spp->CurrentValue;
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 7);
		$this->tgl_spp->ViewCustomAttributes = "";

		// kode_kegiatan
		$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->CurrentValue;
		$this->kode_kegiatan->ViewCustomAttributes = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->CurrentValue;
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// jumlah_up
		$this->jumlah_up->ViewValue = $this->jumlah_up->CurrentValue;
		$this->jumlah_up->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

		// nomer_dasar_spd
		$this->nomer_dasar_spd->ViewValue = $this->nomer_dasar_spd->CurrentValue;
		$this->nomer_dasar_spd->ViewCustomAttributes = "";

		// tanggal_spd
		$this->tanggal_spd->ViewValue = $this->tanggal_spd->CurrentValue;
		$this->tanggal_spd->ViewValue = ew_FormatDateTime($this->tanggal_spd->ViewValue, 0);
		$this->tanggal_spd->ViewCustomAttributes = "";

			// status_spp
			$this->status_spp->LinkCustomAttributes = "";
			$this->status_spp->HrefValue = "";
			$this->status_spp->TooltipValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";
			$this->no_spp->TooltipValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";
			$this->tgl_spp->TooltipValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";
			$this->kode_kegiatan->TooltipValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";
			$this->kode_sub_kegiatan->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// jumlah_up
			$this->jumlah_up->LinkCustomAttributes = "";
			$this->jumlah_up->HrefValue = "";
			$this->jumlah_up->TooltipValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";
			$this->jumlah_spd->TooltipValue = "";

			// nomer_dasar_spd
			$this->nomer_dasar_spd->LinkCustomAttributes = "";
			$this->nomer_dasar_spd->HrefValue = "";
			$this->nomer_dasar_spd->TooltipValue = "";

			// tanggal_spd
			$this->tanggal_spd->LinkCustomAttributes = "";
			$this->tanggal_spd->HrefValue = "";
			$this->tanggal_spd->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// status_spp
			$this->status_spp->EditAttrs["class"] = "form-control";
			$this->status_spp->EditCustomAttributes = "";
			$this->status_spp->EditValue = $this->status_spp->Options(TRUE);

			// no_spp
			$this->no_spp->EditAttrs["class"] = "form-control";
			$this->no_spp->EditCustomAttributes = "";
			$this->no_spp->EditValue = ew_HtmlEncode($this->no_spp->CurrentValue);
			$this->no_spp->PlaceHolder = ew_RemoveHtml($this->no_spp->FldCaption());

			// tgl_spp
			$this->tgl_spp->EditAttrs["class"] = "form-control";
			$this->tgl_spp->EditCustomAttributes = "";
			$this->tgl_spp->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_spp->CurrentValue, 7));
			$this->tgl_spp->PlaceHolder = ew_RemoveHtml($this->tgl_spp->FldCaption());

			// kode_kegiatan
			$this->kode_kegiatan->EditAttrs["class"] = "form-control";
			$this->kode_kegiatan->EditCustomAttributes = "";
			$this->kode_kegiatan->EditValue = ew_HtmlEncode($this->kode_kegiatan->CurrentValue);
			$this->kode_kegiatan->PlaceHolder = ew_RemoveHtml($this->kode_kegiatan->FldCaption());

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->EditAttrs["class"] = "form-control";
			$this->kode_sub_kegiatan->EditCustomAttributes = "";
			$this->kode_sub_kegiatan->EditValue = ew_HtmlEncode($this->kode_sub_kegiatan->CurrentValue);
			$this->kode_sub_kegiatan->PlaceHolder = ew_RemoveHtml($this->kode_sub_kegiatan->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// jumlah_up
			$this->jumlah_up->EditAttrs["class"] = "form-control";
			$this->jumlah_up->EditCustomAttributes = "";
			$this->jumlah_up->EditValue = ew_HtmlEncode($this->jumlah_up->CurrentValue);
			$this->jumlah_up->PlaceHolder = ew_RemoveHtml($this->jumlah_up->FldCaption());
			if (strval($this->jumlah_up->EditValue) <> "" && is_numeric($this->jumlah_up->EditValue)) $this->jumlah_up->EditValue = ew_FormatNumber($this->jumlah_up->EditValue, -2, -1, -2, 0);

			// jumlah_spd
			$this->jumlah_spd->EditAttrs["class"] = "form-control";
			$this->jumlah_spd->EditCustomAttributes = "";
			$this->jumlah_spd->EditValue = ew_HtmlEncode($this->jumlah_spd->CurrentValue);
			$this->jumlah_spd->PlaceHolder = ew_RemoveHtml($this->jumlah_spd->FldCaption());
			if (strval($this->jumlah_spd->EditValue) <> "" && is_numeric($this->jumlah_spd->EditValue)) $this->jumlah_spd->EditValue = ew_FormatNumber($this->jumlah_spd->EditValue, -2, -1, -2, 0);

			// nomer_dasar_spd
			$this->nomer_dasar_spd->EditAttrs["class"] = "form-control";
			$this->nomer_dasar_spd->EditCustomAttributes = "";
			$this->nomer_dasar_spd->EditValue = ew_HtmlEncode($this->nomer_dasar_spd->CurrentValue);
			$this->nomer_dasar_spd->PlaceHolder = ew_RemoveHtml($this->nomer_dasar_spd->FldCaption());

			// tanggal_spd
			$this->tanggal_spd->EditAttrs["class"] = "form-control";
			$this->tanggal_spd->EditCustomAttributes = "";
			$this->tanggal_spd->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_spd->CurrentValue, 8));
			$this->tanggal_spd->PlaceHolder = ew_RemoveHtml($this->tanggal_spd->FldCaption());

			// Edit refer script
			// status_spp

			$this->status_spp->LinkCustomAttributes = "";
			$this->status_spp->HrefValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// jumlah_up
			$this->jumlah_up->LinkCustomAttributes = "";
			$this->jumlah_up->HrefValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";

			// nomer_dasar_spd
			$this->nomer_dasar_spd->LinkCustomAttributes = "";
			$this->nomer_dasar_spd->HrefValue = "";

			// tanggal_spd
			$this->tanggal_spd->LinkCustomAttributes = "";
			$this->tanggal_spd->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->tgl_spp->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spp->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah_up->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_up->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_spd->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_spd->FldErrMsg());
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

			// status_spp
			$this->status_spp->SetDbValueDef($rsnew, $this->status_spp->CurrentValue, NULL, $this->status_spp->ReadOnly);

			// no_spp
			$this->no_spp->SetDbValueDef($rsnew, $this->no_spp->CurrentValue, NULL, $this->no_spp->ReadOnly);

			// tgl_spp
			$this->tgl_spp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7), NULL, $this->tgl_spp->ReadOnly);

			// kode_kegiatan
			$this->kode_kegiatan->SetDbValueDef($rsnew, $this->kode_kegiatan->CurrentValue, NULL, $this->kode_kegiatan->ReadOnly);

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->SetDbValueDef($rsnew, $this->kode_sub_kegiatan->CurrentValue, NULL, $this->kode_sub_kegiatan->ReadOnly);

			// keterangan
			$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, $this->keterangan->ReadOnly);

			// jumlah_up
			$this->jumlah_up->SetDbValueDef($rsnew, $this->jumlah_up->CurrentValue, NULL, $this->jumlah_up->ReadOnly);

			// jumlah_spd
			$this->jumlah_spd->SetDbValueDef($rsnew, $this->jumlah_spd->CurrentValue, NULL, $this->jumlah_spd->ReadOnly);

			// nomer_dasar_spd
			$this->nomer_dasar_spd->SetDbValueDef($rsnew, $this->nomer_dasar_spd->CurrentValue, NULL, $this->nomer_dasar_spd->ReadOnly);

			// tanggal_spd
			$this->tanggal_spd->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0), NULL, $this->tanggal_spd->ReadOnly);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_up_listlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($vw_spp_up_list_edit)) $vw_spp_up_list_edit = new cvw_spp_up_list_edit();

// Page init
$vw_spp_up_list_edit->Page_Init();

// Page main
$vw_spp_up_list_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_up_list_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_spp_up_listedit = new ew_Form("fvw_spp_up_listedit", "edit");

// Validate form
fvw_spp_up_listedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_spp");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_up_list->tgl_spp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_up");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_up_list->jumlah_up->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_spd");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_up_list->jumlah_spd->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_spd");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_up_list->tanggal_spd->FldErrMsg()) ?>");

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
fvw_spp_up_listedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_up_listedit.ValidateRequired = true;
<?php } else { ?>
fvw_spp_up_listedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_up_listedit.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spp_up_listedit.Lists["x_status_spp"].Options = <?php echo json_encode($vw_spp_up_list->status_spp->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_up_list_edit->IsModal) { ?>
<?php } ?>
<?php $vw_spp_up_list_edit->ShowPageHeader(); ?>
<?php
$vw_spp_up_list_edit->ShowMessage();
?>
<form name="fvw_spp_up_listedit" id="fvw_spp_up_listedit" class="<?php echo $vw_spp_up_list_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_up_list_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_up_list_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_up_list">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_spp_up_list_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_spp_up_list->status_spp->Visible) { // status_spp ?>
	<div id="r_status_spp" class="form-group">
		<label id="elh_vw_spp_up_list_status_spp" for="x_status_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->status_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_up_list_status_spp">
<select data-table="vw_spp_up_list" data-field="x_status_spp" data-value-separator="<?php echo $vw_spp_up_list->status_spp->DisplayValueSeparatorAttribute() ?>" id="x_status_spp" name="x_status_spp"<?php echo $vw_spp_up_list->status_spp->EditAttributes() ?>>
<?php echo $vw_spp_up_list->status_spp->SelectOptionListHtml("x_status_spp") ?>
</select>
</span>
<?php echo $vw_spp_up_list->status_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->no_spp->Visible) { // no_spp ?>
	<div id="r_no_spp" class="form-group">
		<label id="elh_vw_spp_up_list_no_spp" for="x_no_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->no_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_up_list_no_spp">
<input type="text" data-table="vw_spp_up_list" data-field="x_no_spp" name="x_no_spp" id="x_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->no_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->no_spp->EditValue ?>"<?php echo $vw_spp_up_list->no_spp->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->no_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->tgl_spp->Visible) { // tgl_spp ?>
	<div id="r_tgl_spp" class="form-group">
		<label id="elh_vw_spp_up_list_tgl_spp" for="x_tgl_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->tgl_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_up_list_tgl_spp">
<input type="text" data-table="vw_spp_up_list" data-field="x_tgl_spp" data-format="7" name="x_tgl_spp" id="x_tgl_spp" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->tgl_spp->EditValue ?>"<?php echo $vw_spp_up_list->tgl_spp->EditAttributes() ?>>
<?php if (!$vw_spp_up_list->tgl_spp->ReadOnly && !$vw_spp_up_list->tgl_spp->Disabled && !isset($vw_spp_up_list->tgl_spp->EditAttrs["readonly"]) && !isset($vw_spp_up_list->tgl_spp->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_spp_up_listedit", "x_tgl_spp", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_spp_up_list->tgl_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<div id="r_kode_kegiatan" class="form-group">
		<label id="elh_vw_spp_up_list_kode_kegiatan" for="x_kode_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->kode_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->kode_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_up_list_kode_kegiatan">
<input type="text" data-table="vw_spp_up_list" data-field="x_kode_kegiatan" name="x_kode_kegiatan" id="x_kode_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->kode_kegiatan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->kode_kegiatan->EditValue ?>"<?php echo $vw_spp_up_list->kode_kegiatan->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->kode_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
	<div id="r_kode_sub_kegiatan" class="form-group">
		<label id="elh_vw_spp_up_list_kode_sub_kegiatan" for="x_kode_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->kode_sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->kode_sub_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_up_list_kode_sub_kegiatan">
<input type="text" data-table="vw_spp_up_list" data-field="x_kode_sub_kegiatan" name="x_kode_sub_kegiatan" id="x_kode_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->kode_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->kode_sub_kegiatan->EditValue ?>"<?php echo $vw_spp_up_list->kode_sub_kegiatan->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->kode_sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_vw_spp_up_list_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_up_list_keterangan">
<input type="text" data-table="vw_spp_up_list" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->keterangan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->keterangan->EditValue ?>"<?php echo $vw_spp_up_list->keterangan->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->jumlah_up->Visible) { // jumlah_up ?>
	<div id="r_jumlah_up" class="form-group">
		<label id="elh_vw_spp_up_list_jumlah_up" for="x_jumlah_up" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->jumlah_up->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->jumlah_up->CellAttributes() ?>>
<span id="el_vw_spp_up_list_jumlah_up">
<input type="text" data-table="vw_spp_up_list" data-field="x_jumlah_up" name="x_jumlah_up" id="x_jumlah_up" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->jumlah_up->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->jumlah_up->EditValue ?>"<?php echo $vw_spp_up_list->jumlah_up->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->jumlah_up->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->jumlah_spd->Visible) { // jumlah_spd ?>
	<div id="r_jumlah_spd" class="form-group">
		<label id="elh_vw_spp_up_list_jumlah_spd" for="x_jumlah_spd" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->jumlah_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->jumlah_spd->CellAttributes() ?>>
<span id="el_vw_spp_up_list_jumlah_spd">
<input type="text" data-table="vw_spp_up_list" data-field="x_jumlah_spd" name="x_jumlah_spd" id="x_jumlah_spd" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->jumlah_spd->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->jumlah_spd->EditValue ?>"<?php echo $vw_spp_up_list->jumlah_spd->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->jumlah_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->nomer_dasar_spd->Visible) { // nomer_dasar_spd ?>
	<div id="r_nomer_dasar_spd" class="form-group">
		<label id="elh_vw_spp_up_list_nomer_dasar_spd" for="x_nomer_dasar_spd" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->nomer_dasar_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->nomer_dasar_spd->CellAttributes() ?>>
<span id="el_vw_spp_up_list_nomer_dasar_spd">
<input type="text" data-table="vw_spp_up_list" data-field="x_nomer_dasar_spd" name="x_nomer_dasar_spd" id="x_nomer_dasar_spd" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->nomer_dasar_spd->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->nomer_dasar_spd->EditValue ?>"<?php echo $vw_spp_up_list->nomer_dasar_spd->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->nomer_dasar_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_up_list->tanggal_spd->Visible) { // tanggal_spd ?>
	<div id="r_tanggal_spd" class="form-group">
		<label id="elh_vw_spp_up_list_tanggal_spd" for="x_tanggal_spd" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_up_list->tanggal_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_up_list->tanggal_spd->CellAttributes() ?>>
<span id="el_vw_spp_up_list_tanggal_spd">
<input type="text" data-table="vw_spp_up_list" data-field="x_tanggal_spd" name="x_tanggal_spd" id="x_tanggal_spd" placeholder="<?php echo ew_HtmlEncode($vw_spp_up_list->tanggal_spd->getPlaceHolder()) ?>" value="<?php echo $vw_spp_up_list->tanggal_spd->EditValue ?>"<?php echo $vw_spp_up_list->tanggal_spd->EditAttributes() ?>>
</span>
<?php echo $vw_spp_up_list->tanggal_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="vw_spp_up_list" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($vw_spp_up_list->id->CurrentValue) ?>">
<?php if (!$vw_spp_up_list_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spp_up_list_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spp_up_listedit.Init();
</script>
<?php
$vw_spp_up_list_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_up_list_edit->Page_Terminate();
?>
