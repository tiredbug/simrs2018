<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_gu_nihil_listinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_spp_detail_pajakgridcls.php" ?>
<?php include_once "vw_spp_ls_barang_jasa_detailgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_gu_nihil_list_edit = NULL; // Initialize page object first

class cvw_spp_gu_nihil_list_edit extends cvw_spp_gu_nihil_list {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_gu_nihil_list';

	// Page object name
	var $PageObjName = 'vw_spp_gu_nihil_list_edit';

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

		// Table object (vw_spp_gu_nihil_list)
		if (!isset($GLOBALS["vw_spp_gu_nihil_list"]) || get_class($GLOBALS["vw_spp_gu_nihil_list"]) == "cvw_spp_gu_nihil_list") {
			$GLOBALS["vw_spp_gu_nihil_list"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_gu_nihil_list"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_gu_nihil_list', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_gu_nihil_listlist.php"));
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
		$this->id_jenis_spp->SetVisibility();
		$this->detail_jenis_spp->SetVisibility();
		$this->status_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->nama_bendahara->SetVisibility();
		$this->nip_bendahara->SetVisibility();
		$this->nama_pptk->SetVisibility();
		$this->nip_pptk->SetVisibility();
		$this->kode_program->SetVisibility();
		$this->kode_kegiatan->SetVisibility();
		$this->kode_sub_kegiatan->SetVisibility();

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

			// Process auto fill for detail table 'vw_spp_detail_pajak'
			if (@$_POST["grid"] == "fvw_spp_detail_pajakgrid") {
				if (!isset($GLOBALS["vw_spp_detail_pajak_grid"])) $GLOBALS["vw_spp_detail_pajak_grid"] = new cvw_spp_detail_pajak_grid;
				$GLOBALS["vw_spp_detail_pajak_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_spp_ls_barang_jasa_detail'
			if (@$_POST["grid"] == "fvw_spp_ls_barang_jasa_detailgrid") {
				if (!isset($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"])) $GLOBALS["vw_spp_ls_barang_jasa_detail_grid"] = new cvw_spp_ls_barang_jasa_detail_grid;
				$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->Page_Init();
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
		global $EW_EXPORT, $vw_spp_gu_nihil_list;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_gu_nihil_list);
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

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("vw_spp_gu_nihil_listlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_spp_gu_nihil_listlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_spp_gu_nihil_listlist.php")
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

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->id_jenis_spp->FldIsDetailKey) {
			$this->id_jenis_spp->setFormValue($objForm->GetValue("x_id_jenis_spp"));
		}
		if (!$this->detail_jenis_spp->FldIsDetailKey) {
			$this->detail_jenis_spp->setFormValue($objForm->GetValue("x_detail_jenis_spp"));
		}
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
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->nama_bendahara->FldIsDetailKey) {
			$this->nama_bendahara->setFormValue($objForm->GetValue("x_nama_bendahara"));
		}
		if (!$this->nip_bendahara->FldIsDetailKey) {
			$this->nip_bendahara->setFormValue($objForm->GetValue("x_nip_bendahara"));
		}
		if (!$this->nama_pptk->FldIsDetailKey) {
			$this->nama_pptk->setFormValue($objForm->GetValue("x_nama_pptk"));
		}
		if (!$this->nip_pptk->FldIsDetailKey) {
			$this->nip_pptk->setFormValue($objForm->GetValue("x_nip_pptk"));
		}
		if (!$this->kode_program->FldIsDetailKey) {
			$this->kode_program->setFormValue($objForm->GetValue("x_kode_program"));
		}
		if (!$this->kode_kegiatan->FldIsDetailKey) {
			$this->kode_kegiatan->setFormValue($objForm->GetValue("x_kode_kegiatan"));
		}
		if (!$this->kode_sub_kegiatan->FldIsDetailKey) {
			$this->kode_sub_kegiatan->setFormValue($objForm->GetValue("x_kode_sub_kegiatan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->id_jenis_spp->CurrentValue = $this->id_jenis_spp->FormValue;
		$this->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->FormValue;
		$this->status_spp->CurrentValue = $this->status_spp->FormValue;
		$this->no_spp->CurrentValue = $this->no_spp->FormValue;
		$this->tgl_spp->CurrentValue = $this->tgl_spp->FormValue;
		$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7);
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->nama_bendahara->CurrentValue = $this->nama_bendahara->FormValue;
		$this->nip_bendahara->CurrentValue = $this->nip_bendahara->FormValue;
		$this->nama_pptk->CurrentValue = $this->nama_pptk->FormValue;
		$this->nip_pptk->CurrentValue = $this->nip_pptk->FormValue;
		$this->kode_program->CurrentValue = $this->kode_program->FormValue;
		$this->kode_kegiatan->CurrentValue = $this->kode_kegiatan->FormValue;
		$this->kode_sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->FormValue;
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
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
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
		$this->keterangan->DbValue = $row['keterangan'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->nama_pptk->DbValue = $row['nama_pptk'];
		$this->nip_pptk->DbValue = $row['nip_pptk'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_jenis_spp
		// detail_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// keterangan
		// nama_bendahara
		// nip_bendahara
		// nama_pptk
		// nip_pptk
		// kode_program
		// kode_kegiatan
		// kode_sub_kegiatan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_jenis_spp
		if (strval($this->id_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_spp`";
		$sWhereWrk = "";
		$this->id_jenis_spp->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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
		if (strval($this->detail_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->detail_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_detail_spp`";
		$sWhereWrk = "";
		$this->detail_jenis_spp->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// nama_bendahara
		if (strval($this->nama_bendahara->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_bendahara->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_bendahara->LookupFilters = array();
		$lookuptblfilter = "`jabatan`= 2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->CurrentValue;
			}
		} else {
			$this->nama_bendahara->ViewValue = NULL;
		}
		$this->nama_bendahara->ViewCustomAttributes = "";

		// nip_bendahara
		$this->nip_bendahara->ViewValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->ViewCustomAttributes = "";

		// nama_pptk
		if (strval($this->nama_pptk->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_pptk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_pptk->LookupFilters = array();
		$lookuptblfilter = "`jabatan`=4";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_pptk->ViewValue = $this->nama_pptk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_pptk->ViewValue = $this->nama_pptk->CurrentValue;
			}
		} else {
			$this->nama_pptk->ViewValue = NULL;
		}
		$this->nama_pptk->ViewCustomAttributes = "";

		// nip_pptk
		$this->nip_pptk->ViewValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->ViewCustomAttributes = "";

		// kode_program
		if (strval($this->kode_program->CurrentValue) <> "") {
			$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->kode_program->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
		$sWhereWrk = "";
		$this->kode_program->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_program, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_program->ViewValue = $this->kode_program->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
			}
		} else {
			$this->kode_program->ViewValue = NULL;
		}
		$this->kode_program->ViewCustomAttributes = "";

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

		// kode_sub_kegiatan
		if (strval($this->kode_sub_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->kode_sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
		$sWhereWrk = "";
		$this->kode_sub_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_sub_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->CurrentValue;
			}
		} else {
			$this->kode_sub_kegiatan->ViewValue = NULL;
		}
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// id_jenis_spp
			$this->id_jenis_spp->LinkCustomAttributes = "";
			$this->id_jenis_spp->HrefValue = "";
			$this->id_jenis_spp->TooltipValue = "";

			// detail_jenis_spp
			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";
			$this->detail_jenis_spp->TooltipValue = "";

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

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";
			$this->nama_bendahara->TooltipValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";
			$this->nip_bendahara->TooltipValue = "";

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";
			$this->nama_pptk->TooltipValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";
			$this->nip_pptk->TooltipValue = "";

			// kode_program
			$this->kode_program->LinkCustomAttributes = "";
			$this->kode_program->HrefValue = "";
			$this->kode_program->TooltipValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";
			$this->kode_kegiatan->TooltipValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";
			$this->kode_sub_kegiatan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// id_jenis_spp
			$this->id_jenis_spp->EditAttrs["class"] = "form-control";
			$this->id_jenis_spp->EditCustomAttributes = "";
			if (trim(strval($this->id_jenis_spp->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jenis_spp`";
			$sWhereWrk = "";
			$this->id_jenis_spp->LookupFilters = array();
			$lookuptblfilter = "`id`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_jenis_spp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->id_jenis_spp->EditValue = $arwrk;

			// detail_jenis_spp
			$this->detail_jenis_spp->EditAttrs["class"] = "form-control";
			$this->detail_jenis_spp->EditCustomAttributes = "";
			if (trim(strval($this->detail_jenis_spp->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->detail_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jenis_detail_spp`";
			$sWhereWrk = "";
			$this->detail_jenis_spp->LookupFilters = array();
			$lookuptblfilter = "`id`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->detail_jenis_spp->EditValue = $arwrk;

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

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// nama_bendahara
			$this->nama_bendahara->EditAttrs["class"] = "form-control";
			$this->nama_bendahara->EditCustomAttributes = "";
			if (trim(strval($this->nama_bendahara->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_bendahara->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_bendahara->LookupFilters = array();
			$lookuptblfilter = "`jabatan`= 2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_bendahara->EditValue = $arwrk;

			// nip_bendahara
			$this->nip_bendahara->EditAttrs["class"] = "form-control";
			$this->nip_bendahara->EditCustomAttributes = "";
			$this->nip_bendahara->EditValue = ew_HtmlEncode($this->nip_bendahara->CurrentValue);
			$this->nip_bendahara->PlaceHolder = ew_RemoveHtml($this->nip_bendahara->FldCaption());

			// nama_pptk
			$this->nama_pptk->EditAttrs["class"] = "form-control";
			$this->nama_pptk->EditCustomAttributes = "";
			if (trim(strval($this->nama_pptk->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_pptk->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_pptk->LookupFilters = array();
			$lookuptblfilter = "`jabatan`=4";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_pptk->EditValue = $arwrk;

			// nip_pptk
			$this->nip_pptk->EditAttrs["class"] = "form-control";
			$this->nip_pptk->EditCustomAttributes = "";
			$this->nip_pptk->EditValue = ew_HtmlEncode($this->nip_pptk->CurrentValue);
			$this->nip_pptk->PlaceHolder = ew_RemoveHtml($this->nip_pptk->FldCaption());

			// kode_program
			$this->kode_program->EditAttrs["class"] = "form-control";
			$this->kode_program->EditCustomAttributes = "";
			if (trim(strval($this->kode_program->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->kode_program->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_program`";
			$sWhereWrk = "";
			$this->kode_program->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kode_program, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kode_program->EditValue = $arwrk;

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

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->EditAttrs["class"] = "form-control";
			$this->kode_sub_kegiatan->EditCustomAttributes = "";
			if (trim(strval($this->kode_sub_kegiatan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->kode_sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kode_kegiatan` AS `SelectFilterFld`, `kode_program` AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_sub_kegiatan`";
			$sWhereWrk = "";
			$this->kode_sub_kegiatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kode_sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kode_sub_kegiatan->EditValue = $arwrk;

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// id_jenis_spp
			$this->id_jenis_spp->LinkCustomAttributes = "";
			$this->id_jenis_spp->HrefValue = "";

			// detail_jenis_spp
			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";

			// status_spp
			$this->status_spp->LinkCustomAttributes = "";
			$this->status_spp->HrefValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";

			// kode_program
			$this->kode_program->LinkCustomAttributes = "";
			$this->kode_program->HrefValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";
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

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("vw_spp_detail_pajak", $DetailTblVar) && $GLOBALS["vw_spp_detail_pajak"]->DetailEdit) {
			if (!isset($GLOBALS["vw_spp_detail_pajak_grid"])) $GLOBALS["vw_spp_detail_pajak_grid"] = new cvw_spp_detail_pajak_grid(); // get detail page object
			$GLOBALS["vw_spp_detail_pajak_grid"]->ValidateGridForm();
		}
		if (in_array("vw_spp_ls_barang_jasa_detail", $DetailTblVar) && $GLOBALS["vw_spp_ls_barang_jasa_detail"]->DetailEdit) {
			if (!isset($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"])) $GLOBALS["vw_spp_ls_barang_jasa_detail_grid"] = new cvw_spp_ls_barang_jasa_detail_grid(); // get detail page object
			$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// id_jenis_spp
			$this->id_jenis_spp->SetDbValueDef($rsnew, $this->id_jenis_spp->CurrentValue, NULL, $this->id_jenis_spp->ReadOnly);

			// detail_jenis_spp
			$this->detail_jenis_spp->SetDbValueDef($rsnew, $this->detail_jenis_spp->CurrentValue, NULL, $this->detail_jenis_spp->ReadOnly);

			// status_spp
			$this->status_spp->SetDbValueDef($rsnew, $this->status_spp->CurrentValue, NULL, $this->status_spp->ReadOnly);

			// no_spp
			$this->no_spp->SetDbValueDef($rsnew, $this->no_spp->CurrentValue, NULL, $this->no_spp->ReadOnly);

			// tgl_spp
			$this->tgl_spp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7), NULL, $this->tgl_spp->ReadOnly);

			// keterangan
			$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, $this->keterangan->ReadOnly);

			// nama_bendahara
			$this->nama_bendahara->SetDbValueDef($rsnew, $this->nama_bendahara->CurrentValue, NULL, $this->nama_bendahara->ReadOnly);

			// nip_bendahara
			$this->nip_bendahara->SetDbValueDef($rsnew, $this->nip_bendahara->CurrentValue, NULL, $this->nip_bendahara->ReadOnly);

			// nama_pptk
			$this->nama_pptk->SetDbValueDef($rsnew, $this->nama_pptk->CurrentValue, NULL, $this->nama_pptk->ReadOnly);

			// nip_pptk
			$this->nip_pptk->SetDbValueDef($rsnew, $this->nip_pptk->CurrentValue, NULL, $this->nip_pptk->ReadOnly);

			// kode_program
			$this->kode_program->SetDbValueDef($rsnew, $this->kode_program->CurrentValue, NULL, $this->kode_program->ReadOnly);

			// kode_kegiatan
			$this->kode_kegiatan->SetDbValueDef($rsnew, $this->kode_kegiatan->CurrentValue, NULL, $this->kode_kegiatan->ReadOnly);

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->SetDbValueDef($rsnew, $this->kode_sub_kegiatan->CurrentValue, NULL, $this->kode_sub_kegiatan->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("vw_spp_detail_pajak", $DetailTblVar) && $GLOBALS["vw_spp_detail_pajak"]->DetailEdit) {
						if (!isset($GLOBALS["vw_spp_detail_pajak_grid"])) $GLOBALS["vw_spp_detail_pajak_grid"] = new cvw_spp_detail_pajak_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_spp_detail_pajak"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_spp_detail_pajak_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_spp_ls_barang_jasa_detail", $DetailTblVar) && $GLOBALS["vw_spp_ls_barang_jasa_detail"]->DetailEdit) {
						if (!isset($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"])) $GLOBALS["vw_spp_ls_barang_jasa_detail_grid"] = new cvw_spp_ls_barang_jasa_detail_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_spp_ls_barang_jasa_detail"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if (in_array("vw_spp_detail_pajak", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_spp_detail_pajak_grid"]))
					$GLOBALS["vw_spp_detail_pajak_grid"] = new cvw_spp_detail_pajak_grid;
				if ($GLOBALS["vw_spp_detail_pajak_grid"]->DetailEdit) {
					$GLOBALS["vw_spp_detail_pajak_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_spp_detail_pajak_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_spp_detail_pajak_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_spp_detail_pajak_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_spp_detail_pajak_grid"]->id_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_detail_pajak_grid"]->id_spp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["vw_spp_detail_pajak_grid"]->id_spp->setSessionValue($GLOBALS["vw_spp_detail_pajak_grid"]->id_spp->CurrentValue);
					$GLOBALS["vw_spp_detail_pajak_grid"]->id_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_detail_pajak_grid"]->id_jenis_spp->CurrentValue = $this->id_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_detail_pajak_grid"]->id_jenis_spp->setSessionValue($GLOBALS["vw_spp_detail_pajak_grid"]->id_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_detail_pajak_grid"]->detail_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_detail_pajak_grid"]->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_detail_pajak_grid"]->detail_jenis_spp->setSessionValue($GLOBALS["vw_spp_detail_pajak_grid"]->detail_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_detail_pajak_grid"]->no_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_detail_pajak_grid"]->no_spp->CurrentValue = $this->no_spp->CurrentValue;
					$GLOBALS["vw_spp_detail_pajak_grid"]->no_spp->setSessionValue($GLOBALS["vw_spp_detail_pajak_grid"]->no_spp->CurrentValue);
				}
			}
			if (in_array("vw_spp_ls_barang_jasa_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]))
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"] = new cvw_spp_ls_barang_jasa_detail_grid;
				if ($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->DetailEdit) {
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_spp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_spp->setSessionValue($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_jenis_spp->CurrentValue = $this->id_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_jenis_spp->setSessionValue($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->id_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->detail_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->detail_jenis_spp->setSessionValue($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->detail_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->no_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->no_spp->CurrentValue = $this->no_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->no_spp->setSessionValue($GLOBALS["vw_spp_ls_barang_jasa_detail_grid"]->no_spp->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_gu_nihil_listlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_id_jenis_spp":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_spp`";
			$sWhereWrk = "";
			$this->id_jenis_spp->LookupFilters = array();
			$lookuptblfilter = "`id`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_jenis_spp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_detail_jenis_spp":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_detail_spp`";
			$sWhereWrk = "";
			$this->detail_jenis_spp->LookupFilters = array();
			$lookuptblfilter = "`id`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nama_bendahara":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nama` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_bendahara->LookupFilters = array();
			$lookuptblfilter = "`jabatan`= 2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nama_pptk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nama` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_pptk->LookupFilters = array();
			$lookuptblfilter = "`jabatan`=4";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kode_program":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode_program` AS `LinkFld`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
			$sWhereWrk = "";
			$this->kode_program->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_program` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kode_program, $sWhereWrk); // Call Lookup selecting
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
		case "x_kode_sub_kegiatan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode_sub_kegiatan` AS `LinkFld`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
			$sWhereWrk = "{filter}";
			$this->kode_sub_kegiatan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_sub_kegiatan` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kode_kegiatan` IN ({filter_value})', "t1" => "200", "fn1" => "", "f2" => '`kode_program` IN ({filter_value})', "t2" => "200", "fn2" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kode_sub_kegiatan, $sWhereWrk); // Call Lookup selecting
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
if (!isset($vw_spp_gu_nihil_list_edit)) $vw_spp_gu_nihil_list_edit = new cvw_spp_gu_nihil_list_edit();

// Page init
$vw_spp_gu_nihil_list_edit->Page_Init();

// Page main
$vw_spp_gu_nihil_list_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_gu_nihil_list_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_spp_gu_nihil_listedit = new ew_Form("fvw_spp_gu_nihil_listedit", "edit");

// Validate form
fvw_spp_gu_nihil_listedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_gu_nihil_list->tgl_spp->FldErrMsg()) ?>");

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
fvw_spp_gu_nihil_listedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_gu_nihil_listedit.ValidateRequired = true;
<?php } else { ?>
fvw_spp_gu_nihil_listedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_gu_nihil_listedit.Lists["x_id_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_spp"};
fvw_spp_gu_nihil_listedit.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
fvw_spp_gu_nihil_listedit.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spp_gu_nihil_listedit.Lists["x_status_spp"].Options = <?php echo json_encode($vw_spp_gu_nihil_list->status_spp->Options()) ?>;
fvw_spp_gu_nihil_listedit.Lists["x_nama_bendahara"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
fvw_spp_gu_nihil_listedit.Lists["x_nama_pptk"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
fvw_spp_gu_nihil_listedit.Lists["x_kode_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kode_kegiatan","x_kode_sub_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
fvw_spp_gu_nihil_listedit.Lists["x_kode_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_kode_program"],"ChildFields":["x_kode_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
fvw_spp_gu_nihil_listedit.Lists["x_kode_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_kode_kegiatan","x_kode_program"],"ChildFields":[],"FilterFields":["x_kode_kegiatan","x_kode_program"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_gu_nihil_list_edit->IsModal) { ?>
<?php } ?>
<?php $vw_spp_gu_nihil_list_edit->ShowPageHeader(); ?>
<?php
$vw_spp_gu_nihil_list_edit->ShowMessage();
?>
<form name="fvw_spp_gu_nihil_listedit" id="fvw_spp_gu_nihil_listedit" class="<?php echo $vw_spp_gu_nihil_list_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_gu_nihil_list_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_gu_nihil_list_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_gu_nihil_list">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_spp_gu_nihil_list_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_spp_gu_nihil_list->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_id" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->id->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_id">
<span<?php echo $vw_spp_gu_nihil_list->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_gu_nihil_list->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spp_gu_nihil_list" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->id->CurrentValue) ?>">
<?php echo $vw_spp_gu_nihil_list->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->id_jenis_spp->Visible) { // id_jenis_spp ?>
	<div id="r_id_jenis_spp" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_id_jenis_spp" for="x_id_jenis_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->id_jenis_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->id_jenis_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_id_jenis_spp">
<select data-table="vw_spp_gu_nihil_list" data-field="x_id_jenis_spp" data-value-separator="<?php echo $vw_spp_gu_nihil_list->id_jenis_spp->DisplayValueSeparatorAttribute() ?>" id="x_id_jenis_spp" name="x_id_jenis_spp"<?php echo $vw_spp_gu_nihil_list->id_jenis_spp->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->id_jenis_spp->SelectOptionListHtml("x_id_jenis_spp") ?>
</select>
<input type="hidden" name="s_x_id_jenis_spp" id="s_x_id_jenis_spp" value="<?php echo $vw_spp_gu_nihil_list->id_jenis_spp->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_gu_nihil_list->id_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<div id="r_detail_jenis_spp" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_detail_jenis_spp" for="x_detail_jenis_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->detail_jenis_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->detail_jenis_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_detail_jenis_spp">
<select data-table="vw_spp_gu_nihil_list" data-field="x_detail_jenis_spp" data-value-separator="<?php echo $vw_spp_gu_nihil_list->detail_jenis_spp->DisplayValueSeparatorAttribute() ?>" id="x_detail_jenis_spp" name="x_detail_jenis_spp"<?php echo $vw_spp_gu_nihil_list->detail_jenis_spp->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->detail_jenis_spp->SelectOptionListHtml("x_detail_jenis_spp") ?>
</select>
<input type="hidden" name="s_x_detail_jenis_spp" id="s_x_detail_jenis_spp" value="<?php echo $vw_spp_gu_nihil_list->detail_jenis_spp->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_gu_nihil_list->detail_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->status_spp->Visible) { // status_spp ?>
	<div id="r_status_spp" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_status_spp" for="x_status_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->status_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_status_spp">
<select data-table="vw_spp_gu_nihil_list" data-field="x_status_spp" data-value-separator="<?php echo $vw_spp_gu_nihil_list->status_spp->DisplayValueSeparatorAttribute() ?>" id="x_status_spp" name="x_status_spp"<?php echo $vw_spp_gu_nihil_list->status_spp->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->status_spp->SelectOptionListHtml("x_status_spp") ?>
</select>
</span>
<?php echo $vw_spp_gu_nihil_list->status_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->no_spp->Visible) { // no_spp ?>
	<div id="r_no_spp" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_no_spp" for="x_no_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->no_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_no_spp">
<input type="text" data-table="vw_spp_gu_nihil_list" data-field="x_no_spp" name="x_no_spp" id="x_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->no_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_gu_nihil_list->no_spp->EditValue ?>"<?php echo $vw_spp_gu_nihil_list->no_spp->EditAttributes() ?>>
</span>
<?php echo $vw_spp_gu_nihil_list->no_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->tgl_spp->Visible) { // tgl_spp ?>
	<div id="r_tgl_spp" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_tgl_spp" for="x_tgl_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->tgl_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_tgl_spp">
<input type="text" data-table="vw_spp_gu_nihil_list" data-field="x_tgl_spp" data-format="7" name="x_tgl_spp" id="x_tgl_spp" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_gu_nihil_list->tgl_spp->EditValue ?>"<?php echo $vw_spp_gu_nihil_list->tgl_spp->EditAttributes() ?>>
<?php if (!$vw_spp_gu_nihil_list->tgl_spp->ReadOnly && !$vw_spp_gu_nihil_list->tgl_spp->Disabled && !isset($vw_spp_gu_nihil_list->tgl_spp->EditAttrs["readonly"]) && !isset($vw_spp_gu_nihil_list->tgl_spp->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_spp_gu_nihil_listedit", "x_tgl_spp", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_spp_gu_nihil_list->tgl_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_keterangan">
<input type="text" data-table="vw_spp_gu_nihil_list" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->keterangan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_gu_nihil_list->keterangan->EditValue ?>"<?php echo $vw_spp_gu_nihil_list->keterangan->EditAttributes() ?>>
</span>
<?php echo $vw_spp_gu_nihil_list->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->nama_bendahara->Visible) { // nama_bendahara ?>
	<div id="r_nama_bendahara" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_nama_bendahara" for="x_nama_bendahara" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->nama_bendahara->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->nama_bendahara->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_nama_bendahara">
<?php $vw_spp_gu_nihil_list->nama_bendahara->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_spp_gu_nihil_list->nama_bendahara->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_gu_nihil_list" data-field="x_nama_bendahara" data-value-separator="<?php echo $vw_spp_gu_nihil_list->nama_bendahara->DisplayValueSeparatorAttribute() ?>" id="x_nama_bendahara" name="x_nama_bendahara"<?php echo $vw_spp_gu_nihil_list->nama_bendahara->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->nama_bendahara->SelectOptionListHtml("x_nama_bendahara") ?>
</select>
<input type="hidden" name="s_x_nama_bendahara" id="s_x_nama_bendahara" value="<?php echo $vw_spp_gu_nihil_list->nama_bendahara->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_bendahara" id="ln_x_nama_bendahara" value="x_nip_bendahara">
</span>
<?php echo $vw_spp_gu_nihil_list->nama_bendahara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->nip_bendahara->Visible) { // nip_bendahara ?>
	<div id="r_nip_bendahara" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_nip_bendahara" for="x_nip_bendahara" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->nip_bendahara->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->nip_bendahara->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_nip_bendahara">
<input type="text" data-table="vw_spp_gu_nihil_list" data-field="x_nip_bendahara" name="x_nip_bendahara" id="x_nip_bendahara" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->nip_bendahara->getPlaceHolder()) ?>" value="<?php echo $vw_spp_gu_nihil_list->nip_bendahara->EditValue ?>"<?php echo $vw_spp_gu_nihil_list->nip_bendahara->EditAttributes() ?>>
</span>
<?php echo $vw_spp_gu_nihil_list->nip_bendahara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->nama_pptk->Visible) { // nama_pptk ?>
	<div id="r_nama_pptk" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_nama_pptk" for="x_nama_pptk" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->nama_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->nama_pptk->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_nama_pptk">
<?php $vw_spp_gu_nihil_list->nama_pptk->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_spp_gu_nihil_list->nama_pptk->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_gu_nihil_list" data-field="x_nama_pptk" data-value-separator="<?php echo $vw_spp_gu_nihil_list->nama_pptk->DisplayValueSeparatorAttribute() ?>" id="x_nama_pptk" name="x_nama_pptk"<?php echo $vw_spp_gu_nihil_list->nama_pptk->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->nama_pptk->SelectOptionListHtml("x_nama_pptk") ?>
</select>
<input type="hidden" name="s_x_nama_pptk" id="s_x_nama_pptk" value="<?php echo $vw_spp_gu_nihil_list->nama_pptk->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_pptk" id="ln_x_nama_pptk" value="x_nip_pptk">
</span>
<?php echo $vw_spp_gu_nihil_list->nama_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->nip_pptk->Visible) { // nip_pptk ?>
	<div id="r_nip_pptk" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_nip_pptk" for="x_nip_pptk" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->nip_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->nip_pptk->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_nip_pptk">
<input type="text" data-table="vw_spp_gu_nihil_list" data-field="x_nip_pptk" name="x_nip_pptk" id="x_nip_pptk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->nip_pptk->getPlaceHolder()) ?>" value="<?php echo $vw_spp_gu_nihil_list->nip_pptk->EditValue ?>"<?php echo $vw_spp_gu_nihil_list->nip_pptk->EditAttributes() ?>>
</span>
<?php echo $vw_spp_gu_nihil_list->nip_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->kode_program->Visible) { // kode_program ?>
	<div id="r_kode_program" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_kode_program" for="x_kode_program" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->kode_program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->kode_program->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_kode_program">
<?php $vw_spp_gu_nihil_list->kode_program->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_gu_nihil_list->kode_program->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_gu_nihil_list" data-field="x_kode_program" data-value-separator="<?php echo $vw_spp_gu_nihil_list->kode_program->DisplayValueSeparatorAttribute() ?>" id="x_kode_program" name="x_kode_program"<?php echo $vw_spp_gu_nihil_list->kode_program->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->kode_program->SelectOptionListHtml("x_kode_program") ?>
</select>
<input type="hidden" name="s_x_kode_program" id="s_x_kode_program" value="<?php echo $vw_spp_gu_nihil_list->kode_program->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_gu_nihil_list->kode_program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<div id="r_kode_kegiatan" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_kode_kegiatan" for="x_kode_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->kode_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->kode_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_kode_kegiatan">
<?php $vw_spp_gu_nihil_list->kode_kegiatan->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_gu_nihil_list->kode_kegiatan->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_gu_nihil_list" data-field="x_kode_kegiatan" data-value-separator="<?php echo $vw_spp_gu_nihil_list->kode_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kode_kegiatan" name="x_kode_kegiatan"<?php echo $vw_spp_gu_nihil_list->kode_kegiatan->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->kode_kegiatan->SelectOptionListHtml("x_kode_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kode_kegiatan" id="s_x_kode_kegiatan" value="<?php echo $vw_spp_gu_nihil_list->kode_kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_gu_nihil_list->kode_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
	<div id="r_kode_sub_kegiatan" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_kode_sub_kegiatan" for="x_kode_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->kode_sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->kode_sub_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_kode_sub_kegiatan">
<select data-table="vw_spp_gu_nihil_list" data-field="x_kode_sub_kegiatan" data-value-separator="<?php echo $vw_spp_gu_nihil_list->kode_sub_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kode_sub_kegiatan" name="x_kode_sub_kegiatan"<?php echo $vw_spp_gu_nihil_list->kode_sub_kegiatan->EditAttributes() ?>>
<?php echo $vw_spp_gu_nihil_list->kode_sub_kegiatan->SelectOptionListHtml("x_kode_sub_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kode_sub_kegiatan" id="s_x_kode_sub_kegiatan" value="<?php echo $vw_spp_gu_nihil_list->kode_sub_kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_gu_nihil_list->kode_sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("vw_spp_detail_pajak", explode(",", $vw_spp_gu_nihil_list->getCurrentDetailTable())) && $vw_spp_detail_pajak->DetailEdit) {
?>
<?php if ($vw_spp_gu_nihil_list->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("vw_spp_detail_pajak", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "vw_spp_detail_pajakgrid.php" ?>
<?php } ?>
<?php
	if (in_array("vw_spp_ls_barang_jasa_detail", explode(",", $vw_spp_gu_nihil_list->getCurrentDetailTable())) && $vw_spp_ls_barang_jasa_detail->DetailEdit) {
?>
<?php if ($vw_spp_gu_nihil_list->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("vw_spp_ls_barang_jasa_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "vw_spp_ls_barang_jasa_detailgrid.php" ?>
<?php } ?>
<?php if (!$vw_spp_gu_nihil_list_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spp_gu_nihil_list_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spp_gu_nihil_listedit.Init();
</script>
<?php
$vw_spp_gu_nihil_list_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_gu_nihil_list_edit->Page_Terminate();
?>
