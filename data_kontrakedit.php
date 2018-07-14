<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "data_kontrakinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "data_kontrak_detail_termingridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$data_kontrak_edit = NULL; // Initialize page object first

class cdata_kontrak_edit extends cdata_kontrak {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'data_kontrak';

	// Page object name
	var $PageObjName = 'data_kontrak_edit';

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

		// Table object (data_kontrak)
		if (!isset($GLOBALS["data_kontrak"]) || get_class($GLOBALS["data_kontrak"]) == "cdata_kontrak") {
			$GLOBALS["data_kontrak"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["data_kontrak"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'data_kontrak', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("data_kontraklist.php"));
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
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();
		$this->no_kontrak->SetVisibility();
		$this->tgl_kontrak->SetVisibility();
		$this->nama_perusahaan->SetVisibility();
		$this->bentuk_perusahaan->SetVisibility();
		$this->alamat_perusahaan->SetVisibility();
		$this->kepala_perusahaan->SetVisibility();
		$this->npwp->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->nama_rekening->SetVisibility();
		$this->nomer_rekening->SetVisibility();
		$this->lanjutkan->SetVisibility();
		$this->waktu_kontrak->SetVisibility();
		$this->tgl_mulai->SetVisibility();
		$this->tgl_selesai->SetVisibility();
		$this->paket_pekerjaan->SetVisibility();
		$this->nama_ppkom->SetVisibility();
		$this->nip_ppkom->SetVisibility();

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

			// Process auto fill for detail table 'data_kontrak_detail_termin'
			if (@$_POST["grid"] == "fdata_kontrak_detail_termingrid") {
				if (!isset($GLOBALS["data_kontrak_detail_termin_grid"])) $GLOBALS["data_kontrak_detail_termin_grid"] = new cdata_kontrak_detail_termin_grid;
				$GLOBALS["data_kontrak_detail_termin_grid"]->Page_Init();
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
		global $EW_EXPORT, $data_kontrak;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($data_kontrak);
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
			$this->Page_Terminate("data_kontraklist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("data_kontraklist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "data_kontraklist.php")
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
		if (!$this->program->FldIsDetailKey) {
			$this->program->setFormValue($objForm->GetValue("x_program"));
		}
		if (!$this->kegiatan->FldIsDetailKey) {
			$this->kegiatan->setFormValue($objForm->GetValue("x_kegiatan"));
		}
		if (!$this->sub_kegiatan->FldIsDetailKey) {
			$this->sub_kegiatan->setFormValue($objForm->GetValue("x_sub_kegiatan"));
		}
		if (!$this->no_kontrak->FldIsDetailKey) {
			$this->no_kontrak->setFormValue($objForm->GetValue("x_no_kontrak"));
		}
		if (!$this->tgl_kontrak->FldIsDetailKey) {
			$this->tgl_kontrak->setFormValue($objForm->GetValue("x_tgl_kontrak"));
			$this->tgl_kontrak->CurrentValue = ew_UnFormatDateTime($this->tgl_kontrak->CurrentValue, 0);
		}
		if (!$this->nama_perusahaan->FldIsDetailKey) {
			$this->nama_perusahaan->setFormValue($objForm->GetValue("x_nama_perusahaan"));
		}
		if (!$this->bentuk_perusahaan->FldIsDetailKey) {
			$this->bentuk_perusahaan->setFormValue($objForm->GetValue("x_bentuk_perusahaan"));
		}
		if (!$this->alamat_perusahaan->FldIsDetailKey) {
			$this->alamat_perusahaan->setFormValue($objForm->GetValue("x_alamat_perusahaan"));
		}
		if (!$this->kepala_perusahaan->FldIsDetailKey) {
			$this->kepala_perusahaan->setFormValue($objForm->GetValue("x_kepala_perusahaan"));
		}
		if (!$this->npwp->FldIsDetailKey) {
			$this->npwp->setFormValue($objForm->GetValue("x_npwp"));
		}
		if (!$this->nama_bank->FldIsDetailKey) {
			$this->nama_bank->setFormValue($objForm->GetValue("x_nama_bank"));
		}
		if (!$this->nama_rekening->FldIsDetailKey) {
			$this->nama_rekening->setFormValue($objForm->GetValue("x_nama_rekening"));
		}
		if (!$this->nomer_rekening->FldIsDetailKey) {
			$this->nomer_rekening->setFormValue($objForm->GetValue("x_nomer_rekening"));
		}
		if (!$this->lanjutkan->FldIsDetailKey) {
			$this->lanjutkan->setFormValue($objForm->GetValue("x_lanjutkan"));
		}
		if (!$this->waktu_kontrak->FldIsDetailKey) {
			$this->waktu_kontrak->setFormValue($objForm->GetValue("x_waktu_kontrak"));
		}
		if (!$this->tgl_mulai->FldIsDetailKey) {
			$this->tgl_mulai->setFormValue($objForm->GetValue("x_tgl_mulai"));
			$this->tgl_mulai->CurrentValue = ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 7);
		}
		if (!$this->tgl_selesai->FldIsDetailKey) {
			$this->tgl_selesai->setFormValue($objForm->GetValue("x_tgl_selesai"));
			$this->tgl_selesai->CurrentValue = ew_UnFormatDateTime($this->tgl_selesai->CurrentValue, 7);
		}
		if (!$this->paket_pekerjaan->FldIsDetailKey) {
			$this->paket_pekerjaan->setFormValue($objForm->GetValue("x_paket_pekerjaan"));
		}
		if (!$this->nama_ppkom->FldIsDetailKey) {
			$this->nama_ppkom->setFormValue($objForm->GetValue("x_nama_ppkom"));
		}
		if (!$this->nip_ppkom->FldIsDetailKey) {
			$this->nip_ppkom->setFormValue($objForm->GetValue("x_nip_ppkom"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->program->CurrentValue = $this->program->FormValue;
		$this->kegiatan->CurrentValue = $this->kegiatan->FormValue;
		$this->sub_kegiatan->CurrentValue = $this->sub_kegiatan->FormValue;
		$this->no_kontrak->CurrentValue = $this->no_kontrak->FormValue;
		$this->tgl_kontrak->CurrentValue = $this->tgl_kontrak->FormValue;
		$this->tgl_kontrak->CurrentValue = ew_UnFormatDateTime($this->tgl_kontrak->CurrentValue, 0);
		$this->nama_perusahaan->CurrentValue = $this->nama_perusahaan->FormValue;
		$this->bentuk_perusahaan->CurrentValue = $this->bentuk_perusahaan->FormValue;
		$this->alamat_perusahaan->CurrentValue = $this->alamat_perusahaan->FormValue;
		$this->kepala_perusahaan->CurrentValue = $this->kepala_perusahaan->FormValue;
		$this->npwp->CurrentValue = $this->npwp->FormValue;
		$this->nama_bank->CurrentValue = $this->nama_bank->FormValue;
		$this->nama_rekening->CurrentValue = $this->nama_rekening->FormValue;
		$this->nomer_rekening->CurrentValue = $this->nomer_rekening->FormValue;
		$this->lanjutkan->CurrentValue = $this->lanjutkan->FormValue;
		$this->waktu_kontrak->CurrentValue = $this->waktu_kontrak->FormValue;
		$this->tgl_mulai->CurrentValue = $this->tgl_mulai->FormValue;
		$this->tgl_mulai->CurrentValue = ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 7);
		$this->tgl_selesai->CurrentValue = $this->tgl_selesai->FormValue;
		$this->tgl_selesai->CurrentValue = ew_UnFormatDateTime($this->tgl_selesai->CurrentValue, 7);
		$this->paket_pekerjaan->CurrentValue = $this->paket_pekerjaan->FormValue;
		$this->nama_ppkom->CurrentValue = $this->nama_ppkom->FormValue;
		$this->nip_ppkom->CurrentValue = $this->nip_ppkom->FormValue;
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
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->no_kontrak->setDbValue($rs->fields('no_kontrak'));
		$this->tgl_kontrak->setDbValue($rs->fields('tgl_kontrak'));
		$this->nama_perusahaan->setDbValue($rs->fields('nama_perusahaan'));
		$this->bentuk_perusahaan->setDbValue($rs->fields('bentuk_perusahaan'));
		$this->alamat_perusahaan->setDbValue($rs->fields('alamat_perusahaan'));
		$this->kepala_perusahaan->setDbValue($rs->fields('kepala_perusahaan'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nama_rekening->setDbValue($rs->fields('nama_rekening'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->lanjutkan->setDbValue($rs->fields('lanjutkan'));
		$this->waktu_kontrak->setDbValue($rs->fields('waktu_kontrak'));
		$this->tgl_mulai->setDbValue($rs->fields('tgl_mulai'));
		$this->tgl_selesai->setDbValue($rs->fields('tgl_selesai'));
		$this->paket_pekerjaan->setDbValue($rs->fields('paket_pekerjaan'));
		$this->nama_ppkom->setDbValue($rs->fields('nama_ppkom'));
		$this->nip_ppkom->setDbValue($rs->fields('nip_ppkom'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->no_kontrak->DbValue = $row['no_kontrak'];
		$this->tgl_kontrak->DbValue = $row['tgl_kontrak'];
		$this->nama_perusahaan->DbValue = $row['nama_perusahaan'];
		$this->bentuk_perusahaan->DbValue = $row['bentuk_perusahaan'];
		$this->alamat_perusahaan->DbValue = $row['alamat_perusahaan'];
		$this->kepala_perusahaan->DbValue = $row['kepala_perusahaan'];
		$this->npwp->DbValue = $row['npwp'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->nama_rekening->DbValue = $row['nama_rekening'];
		$this->nomer_rekening->DbValue = $row['nomer_rekening'];
		$this->lanjutkan->DbValue = $row['lanjutkan'];
		$this->waktu_kontrak->DbValue = $row['waktu_kontrak'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_selesai->DbValue = $row['tgl_selesai'];
		$this->paket_pekerjaan->DbValue = $row['paket_pekerjaan'];
		$this->nama_ppkom->DbValue = $row['nama_ppkom'];
		$this->nip_ppkom->DbValue = $row['nip_ppkom'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// program
		// kegiatan
		// sub_kegiatan
		// no_kontrak
		// tgl_kontrak
		// nama_perusahaan
		// bentuk_perusahaan
		// alamat_perusahaan
		// kepala_perusahaan
		// npwp
		// nama_bank
		// nama_rekening
		// nomer_rekening
		// lanjutkan
		// waktu_kontrak
		// tgl_mulai
		// tgl_selesai
		// paket_pekerjaan
		// nama_ppkom
		// nip_ppkom

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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

		// no_kontrak
		$this->no_kontrak->ViewValue = $this->no_kontrak->CurrentValue;
		$this->no_kontrak->ViewCustomAttributes = "";

		// tgl_kontrak
		$this->tgl_kontrak->ViewValue = $this->tgl_kontrak->CurrentValue;
		$this->tgl_kontrak->ViewValue = ew_FormatDateTime($this->tgl_kontrak->ViewValue, 0);
		$this->tgl_kontrak->ViewCustomAttributes = "";

		// nama_perusahaan
		$this->nama_perusahaan->ViewValue = $this->nama_perusahaan->CurrentValue;
		$this->nama_perusahaan->ViewCustomAttributes = "";

		// bentuk_perusahaan
		if (strval($this->bentuk_perusahaan->CurrentValue) <> "") {
			$sFilterWrk = "`bentuk perusahaan`" . ew_SearchString("=", $this->bentuk_perusahaan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `bentuk perusahaan`, `bentuk perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bentuk_perusahaan`";
		$sWhereWrk = "";
		$this->bentuk_perusahaan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bentuk_perusahaan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->CurrentValue;
			}
		} else {
			$this->bentuk_perusahaan->ViewValue = NULL;
		}
		$this->bentuk_perusahaan->ViewCustomAttributes = "";

		// alamat_perusahaan
		$this->alamat_perusahaan->ViewValue = $this->alamat_perusahaan->CurrentValue;
		$this->alamat_perusahaan->ViewCustomAttributes = "";

		// kepala_perusahaan
		$this->kepala_perusahaan->ViewValue = $this->kepala_perusahaan->CurrentValue;
		$this->kepala_perusahaan->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nama_rekening
		$this->nama_rekening->ViewValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// lanjutkan
		if (strval($this->lanjutkan->CurrentValue) <> "") {
			$this->lanjutkan->ViewValue = $this->lanjutkan->OptionCaption($this->lanjutkan->CurrentValue);
		} else {
			$this->lanjutkan->ViewValue = NULL;
		}
		$this->lanjutkan->ViewCustomAttributes = "";

		// waktu_kontrak
		$this->waktu_kontrak->ViewValue = $this->waktu_kontrak->CurrentValue;
		$this->waktu_kontrak->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 7);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_selesai
		$this->tgl_selesai->ViewValue = $this->tgl_selesai->CurrentValue;
		$this->tgl_selesai->ViewValue = ew_FormatDateTime($this->tgl_selesai->ViewValue, 7);
		$this->tgl_selesai->ViewCustomAttributes = "";

		// paket_pekerjaan
		$this->paket_pekerjaan->ViewValue = $this->paket_pekerjaan->CurrentValue;
		$this->paket_pekerjaan->ViewCustomAttributes = "";

		// nama_ppkom
		if (strval($this->nama_ppkom->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_ppkom->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_ppkom->LookupFilters = array();
		$lookuptblfilter = "`jabatan`=3";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_ppkom, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->CurrentValue;
			}
		} else {
			$this->nama_ppkom->ViewValue = NULL;
		}
		$this->nama_ppkom->ViewCustomAttributes = "";

		// nip_ppkom
		$this->nip_ppkom->ViewValue = $this->nip_ppkom->CurrentValue;
		$this->nip_ppkom->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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

			// no_kontrak
			$this->no_kontrak->LinkCustomAttributes = "";
			$this->no_kontrak->HrefValue = "";
			$this->no_kontrak->TooltipValue = "";

			// tgl_kontrak
			$this->tgl_kontrak->LinkCustomAttributes = "";
			$this->tgl_kontrak->HrefValue = "";
			$this->tgl_kontrak->TooltipValue = "";

			// nama_perusahaan
			$this->nama_perusahaan->LinkCustomAttributes = "";
			$this->nama_perusahaan->HrefValue = "";
			$this->nama_perusahaan->TooltipValue = "";

			// bentuk_perusahaan
			$this->bentuk_perusahaan->LinkCustomAttributes = "";
			$this->bentuk_perusahaan->HrefValue = "";
			$this->bentuk_perusahaan->TooltipValue = "";

			// alamat_perusahaan
			$this->alamat_perusahaan->LinkCustomAttributes = "";
			$this->alamat_perusahaan->HrefValue = "";
			$this->alamat_perusahaan->TooltipValue = "";

			// kepala_perusahaan
			$this->kepala_perusahaan->LinkCustomAttributes = "";
			$this->kepala_perusahaan->HrefValue = "";
			$this->kepala_perusahaan->TooltipValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";
			$this->npwp->TooltipValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";
			$this->nama_bank->TooltipValue = "";

			// nama_rekening
			$this->nama_rekening->LinkCustomAttributes = "";
			$this->nama_rekening->HrefValue = "";
			$this->nama_rekening->TooltipValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";
			$this->nomer_rekening->TooltipValue = "";

			// lanjutkan
			$this->lanjutkan->LinkCustomAttributes = "";
			$this->lanjutkan->HrefValue = "";
			$this->lanjutkan->TooltipValue = "";

			// waktu_kontrak
			$this->waktu_kontrak->LinkCustomAttributes = "";
			$this->waktu_kontrak->HrefValue = "";
			$this->waktu_kontrak->TooltipValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";
			$this->tgl_mulai->TooltipValue = "";

			// tgl_selesai
			$this->tgl_selesai->LinkCustomAttributes = "";
			$this->tgl_selesai->HrefValue = "";
			$this->tgl_selesai->TooltipValue = "";

			// paket_pekerjaan
			$this->paket_pekerjaan->LinkCustomAttributes = "";
			$this->paket_pekerjaan->HrefValue = "";
			$this->paket_pekerjaan->TooltipValue = "";

			// nama_ppkom
			$this->nama_ppkom->LinkCustomAttributes = "";
			$this->nama_ppkom->HrefValue = "";
			$this->nama_ppkom->TooltipValue = "";

			// nip_ppkom
			$this->nip_ppkom->LinkCustomAttributes = "";
			$this->nip_ppkom->HrefValue = "";
			$this->nip_ppkom->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

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
			$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kode_kegiatan` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_sub_kegiatan`";
			$sWhereWrk = "";
			$this->sub_kegiatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->sub_kegiatan->EditValue = $arwrk;

			// no_kontrak
			$this->no_kontrak->EditAttrs["class"] = "form-control";
			$this->no_kontrak->EditCustomAttributes = "";
			$this->no_kontrak->EditValue = ew_HtmlEncode($this->no_kontrak->CurrentValue);
			$this->no_kontrak->PlaceHolder = ew_RemoveHtml($this->no_kontrak->FldCaption());

			// tgl_kontrak
			$this->tgl_kontrak->EditAttrs["class"] = "form-control";
			$this->tgl_kontrak->EditCustomAttributes = "";
			$this->tgl_kontrak->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_kontrak->CurrentValue, 8));
			$this->tgl_kontrak->PlaceHolder = ew_RemoveHtml($this->tgl_kontrak->FldCaption());

			// nama_perusahaan
			$this->nama_perusahaan->EditAttrs["class"] = "form-control";
			$this->nama_perusahaan->EditCustomAttributes = "";
			$this->nama_perusahaan->EditValue = ew_HtmlEncode($this->nama_perusahaan->CurrentValue);
			$this->nama_perusahaan->PlaceHolder = ew_RemoveHtml($this->nama_perusahaan->FldCaption());

			// bentuk_perusahaan
			$this->bentuk_perusahaan->EditAttrs["class"] = "form-control";
			$this->bentuk_perusahaan->EditCustomAttributes = "";
			if (trim(strval($this->bentuk_perusahaan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`bentuk perusahaan`" . ew_SearchString("=", $this->bentuk_perusahaan->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `bentuk perusahaan`, `bentuk perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `bentuk_perusahaan`";
			$sWhereWrk = "";
			$this->bentuk_perusahaan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->bentuk_perusahaan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->bentuk_perusahaan->EditValue = $arwrk;

			// alamat_perusahaan
			$this->alamat_perusahaan->EditAttrs["class"] = "form-control";
			$this->alamat_perusahaan->EditCustomAttributes = "";
			$this->alamat_perusahaan->EditValue = ew_HtmlEncode($this->alamat_perusahaan->CurrentValue);
			$this->alamat_perusahaan->PlaceHolder = ew_RemoveHtml($this->alamat_perusahaan->FldCaption());

			// kepala_perusahaan
			$this->kepala_perusahaan->EditAttrs["class"] = "form-control";
			$this->kepala_perusahaan->EditCustomAttributes = "";
			$this->kepala_perusahaan->EditValue = ew_HtmlEncode($this->kepala_perusahaan->CurrentValue);
			$this->kepala_perusahaan->PlaceHolder = ew_RemoveHtml($this->kepala_perusahaan->FldCaption());

			// npwp
			$this->npwp->EditAttrs["class"] = "form-control";
			$this->npwp->EditCustomAttributes = "";
			$this->npwp->EditValue = ew_HtmlEncode($this->npwp->CurrentValue);
			$this->npwp->PlaceHolder = ew_RemoveHtml($this->npwp->FldCaption());

			// nama_bank
			$this->nama_bank->EditAttrs["class"] = "form-control";
			$this->nama_bank->EditCustomAttributes = "";
			$this->nama_bank->EditValue = ew_HtmlEncode($this->nama_bank->CurrentValue);
			$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

			// nama_rekening
			$this->nama_rekening->EditAttrs["class"] = "form-control";
			$this->nama_rekening->EditCustomAttributes = "";
			$this->nama_rekening->EditValue = ew_HtmlEncode($this->nama_rekening->CurrentValue);
			$this->nama_rekening->PlaceHolder = ew_RemoveHtml($this->nama_rekening->FldCaption());

			// nomer_rekening
			$this->nomer_rekening->EditAttrs["class"] = "form-control";
			$this->nomer_rekening->EditCustomAttributes = "";
			$this->nomer_rekening->EditValue = ew_HtmlEncode($this->nomer_rekening->CurrentValue);
			$this->nomer_rekening->PlaceHolder = ew_RemoveHtml($this->nomer_rekening->FldCaption());

			// lanjutkan
			$this->lanjutkan->EditAttrs["class"] = "form-control";
			$this->lanjutkan->EditCustomAttributes = "";
			$this->lanjutkan->EditValue = $this->lanjutkan->Options(TRUE);

			// waktu_kontrak
			$this->waktu_kontrak->EditAttrs["class"] = "form-control";
			$this->waktu_kontrak->EditCustomAttributes = "";
			$this->waktu_kontrak->EditValue = ew_HtmlEncode($this->waktu_kontrak->CurrentValue);
			$this->waktu_kontrak->PlaceHolder = ew_RemoveHtml($this->waktu_kontrak->FldCaption());

			// tgl_mulai
			$this->tgl_mulai->EditAttrs["class"] = "form-control";
			$this->tgl_mulai->EditCustomAttributes = "";
			$this->tgl_mulai->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_mulai->CurrentValue, 7));
			$this->tgl_mulai->PlaceHolder = ew_RemoveHtml($this->tgl_mulai->FldCaption());

			// tgl_selesai
			$this->tgl_selesai->EditAttrs["class"] = "form-control";
			$this->tgl_selesai->EditCustomAttributes = "";
			$this->tgl_selesai->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_selesai->CurrentValue, 7));
			$this->tgl_selesai->PlaceHolder = ew_RemoveHtml($this->tgl_selesai->FldCaption());

			// paket_pekerjaan
			$this->paket_pekerjaan->EditAttrs["class"] = "form-control";
			$this->paket_pekerjaan->EditCustomAttributes = "";
			$this->paket_pekerjaan->EditValue = ew_HtmlEncode($this->paket_pekerjaan->CurrentValue);
			$this->paket_pekerjaan->PlaceHolder = ew_RemoveHtml($this->paket_pekerjaan->FldCaption());

			// nama_ppkom
			$this->nama_ppkom->EditAttrs["class"] = "form-control";
			$this->nama_ppkom->EditCustomAttributes = "";
			if (trim(strval($this->nama_ppkom->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_ppkom->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_ppkom->LookupFilters = array();
			$lookuptblfilter = "`jabatan`=3";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_ppkom, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_ppkom->EditValue = $arwrk;

			// nip_ppkom
			$this->nip_ppkom->EditAttrs["class"] = "form-control";
			$this->nip_ppkom->EditCustomAttributes = "";
			$this->nip_ppkom->EditValue = ew_HtmlEncode($this->nip_ppkom->CurrentValue);
			$this->nip_ppkom->PlaceHolder = ew_RemoveHtml($this->nip_ppkom->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";

			// no_kontrak
			$this->no_kontrak->LinkCustomAttributes = "";
			$this->no_kontrak->HrefValue = "";

			// tgl_kontrak
			$this->tgl_kontrak->LinkCustomAttributes = "";
			$this->tgl_kontrak->HrefValue = "";

			// nama_perusahaan
			$this->nama_perusahaan->LinkCustomAttributes = "";
			$this->nama_perusahaan->HrefValue = "";

			// bentuk_perusahaan
			$this->bentuk_perusahaan->LinkCustomAttributes = "";
			$this->bentuk_perusahaan->HrefValue = "";

			// alamat_perusahaan
			$this->alamat_perusahaan->LinkCustomAttributes = "";
			$this->alamat_perusahaan->HrefValue = "";

			// kepala_perusahaan
			$this->kepala_perusahaan->LinkCustomAttributes = "";
			$this->kepala_perusahaan->HrefValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";

			// nama_rekening
			$this->nama_rekening->LinkCustomAttributes = "";
			$this->nama_rekening->HrefValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";

			// lanjutkan
			$this->lanjutkan->LinkCustomAttributes = "";
			$this->lanjutkan->HrefValue = "";

			// waktu_kontrak
			$this->waktu_kontrak->LinkCustomAttributes = "";
			$this->waktu_kontrak->HrefValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";

			// tgl_selesai
			$this->tgl_selesai->LinkCustomAttributes = "";
			$this->tgl_selesai->HrefValue = "";

			// paket_pekerjaan
			$this->paket_pekerjaan->LinkCustomAttributes = "";
			$this->paket_pekerjaan->HrefValue = "";

			// nama_ppkom
			$this->nama_ppkom->LinkCustomAttributes = "";
			$this->nama_ppkom->HrefValue = "";

			// nip_ppkom
			$this->nip_ppkom->LinkCustomAttributes = "";
			$this->nip_ppkom->HrefValue = "";
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
		if (!ew_CheckDateDef($this->tgl_kontrak->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_kontrak->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->tgl_mulai->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_mulai->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->tgl_selesai->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_selesai->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("data_kontrak_detail_termin", $DetailTblVar) && $GLOBALS["data_kontrak_detail_termin"]->DetailEdit) {
			if (!isset($GLOBALS["data_kontrak_detail_termin_grid"])) $GLOBALS["data_kontrak_detail_termin_grid"] = new cdata_kontrak_detail_termin_grid(); // get detail page object
			$GLOBALS["data_kontrak_detail_termin_grid"]->ValidateGridForm();
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

			// program
			$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, $this->program->ReadOnly);

			// kegiatan
			$this->kegiatan->SetDbValueDef($rsnew, $this->kegiatan->CurrentValue, NULL, $this->kegiatan->ReadOnly);

			// sub_kegiatan
			$this->sub_kegiatan->SetDbValueDef($rsnew, $this->sub_kegiatan->CurrentValue, NULL, $this->sub_kegiatan->ReadOnly);

			// no_kontrak
			$this->no_kontrak->SetDbValueDef($rsnew, $this->no_kontrak->CurrentValue, NULL, $this->no_kontrak->ReadOnly);

			// tgl_kontrak
			$this->tgl_kontrak->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_kontrak->CurrentValue, 0), NULL, $this->tgl_kontrak->ReadOnly);

			// nama_perusahaan
			$this->nama_perusahaan->SetDbValueDef($rsnew, $this->nama_perusahaan->CurrentValue, NULL, $this->nama_perusahaan->ReadOnly);

			// bentuk_perusahaan
			$this->bentuk_perusahaan->SetDbValueDef($rsnew, $this->bentuk_perusahaan->CurrentValue, NULL, $this->bentuk_perusahaan->ReadOnly);

			// alamat_perusahaan
			$this->alamat_perusahaan->SetDbValueDef($rsnew, $this->alamat_perusahaan->CurrentValue, NULL, $this->alamat_perusahaan->ReadOnly);

			// kepala_perusahaan
			$this->kepala_perusahaan->SetDbValueDef($rsnew, $this->kepala_perusahaan->CurrentValue, NULL, $this->kepala_perusahaan->ReadOnly);

			// npwp
			$this->npwp->SetDbValueDef($rsnew, $this->npwp->CurrentValue, NULL, $this->npwp->ReadOnly);

			// nama_bank
			$this->nama_bank->SetDbValueDef($rsnew, $this->nama_bank->CurrentValue, NULL, $this->nama_bank->ReadOnly);

			// nama_rekening
			$this->nama_rekening->SetDbValueDef($rsnew, $this->nama_rekening->CurrentValue, NULL, $this->nama_rekening->ReadOnly);

			// nomer_rekening
			$this->nomer_rekening->SetDbValueDef($rsnew, $this->nomer_rekening->CurrentValue, NULL, $this->nomer_rekening->ReadOnly);

			// lanjutkan
			$this->lanjutkan->SetDbValueDef($rsnew, $this->lanjutkan->CurrentValue, NULL, $this->lanjutkan->ReadOnly);

			// waktu_kontrak
			$this->waktu_kontrak->SetDbValueDef($rsnew, $this->waktu_kontrak->CurrentValue, NULL, $this->waktu_kontrak->ReadOnly);

			// tgl_mulai
			$this->tgl_mulai->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_mulai->CurrentValue, 7), NULL, $this->tgl_mulai->ReadOnly);

			// tgl_selesai
			$this->tgl_selesai->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_selesai->CurrentValue, 7), NULL, $this->tgl_selesai->ReadOnly);

			// paket_pekerjaan
			$this->paket_pekerjaan->SetDbValueDef($rsnew, $this->paket_pekerjaan->CurrentValue, NULL, $this->paket_pekerjaan->ReadOnly);

			// nama_ppkom
			$this->nama_ppkom->SetDbValueDef($rsnew, $this->nama_ppkom->CurrentValue, NULL, $this->nama_ppkom->ReadOnly);

			// nip_ppkom
			$this->nip_ppkom->SetDbValueDef($rsnew, $this->nip_ppkom->CurrentValue, NULL, $this->nip_ppkom->ReadOnly);

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
					if (in_array("data_kontrak_detail_termin", $DetailTblVar) && $GLOBALS["data_kontrak_detail_termin"]->DetailEdit) {
						if (!isset($GLOBALS["data_kontrak_detail_termin_grid"])) $GLOBALS["data_kontrak_detail_termin_grid"] = new cdata_kontrak_detail_termin_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "data_kontrak_detail_termin"); // Load user level of detail table
						$EditRow = $GLOBALS["data_kontrak_detail_termin_grid"]->GridUpdate();
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
			if (in_array("data_kontrak_detail_termin", $DetailTblVar)) {
				if (!isset($GLOBALS["data_kontrak_detail_termin_grid"]))
					$GLOBALS["data_kontrak_detail_termin_grid"] = new cdata_kontrak_detail_termin_grid;
				if ($GLOBALS["data_kontrak_detail_termin_grid"]->DetailEdit) {
					$GLOBALS["data_kontrak_detail_termin_grid"]->CurrentMode = "edit";
					$GLOBALS["data_kontrak_detail_termin_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["data_kontrak_detail_termin_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["data_kontrak_detail_termin_grid"]->setStartRecordNumber(1);
					$GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->FldIsDetailKey = TRUE;
					$GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->setSessionValue($GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("data_kontraklist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_sub_kegiatan` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kode_kegiatan` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_bentuk_perusahaan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `bentuk perusahaan` AS `LinkFld`, `bentuk perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bentuk_perusahaan`";
			$sWhereWrk = "";
			$this->bentuk_perusahaan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`bentuk perusahaan` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->bentuk_perusahaan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nama_ppkom":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nama` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_ppkom->LookupFilters = array();
			$lookuptblfilter = "`jabatan`=3";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_ppkom, $sWhereWrk); // Call Lookup selecting
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
if (!isset($data_kontrak_edit)) $data_kontrak_edit = new cdata_kontrak_edit();

// Page init
$data_kontrak_edit->Page_Init();

// Page main
$data_kontrak_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$data_kontrak_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fdata_kontrakedit = new ew_Form("fdata_kontrakedit", "edit");

// Validate form
fdata_kontrakedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_kontrak");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak->tgl_kontrak->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_mulai");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak->tgl_mulai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_selesai");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak->tgl_selesai->FldErrMsg()) ?>");

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
fdata_kontrakedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdata_kontrakedit.ValidateRequired = true;
<?php } else { ?>
fdata_kontrakedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdata_kontrakedit.Lists["x_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
fdata_kontrakedit.Lists["x_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_program"],"ChildFields":["x_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
fdata_kontrakedit.Lists["x_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_kegiatan"],"ChildFields":[],"FilterFields":["x_kode_kegiatan"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};
fdata_kontrakedit.Lists["x_bentuk_perusahaan"] = {"LinkField":"x_bentuk_perusahaan","Ajax":true,"AutoFill":false,"DisplayFields":["x_bentuk_perusahaan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"bentuk_perusahaan"};
fdata_kontrakedit.Lists["x_lanjutkan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdata_kontrakedit.Lists["x_lanjutkan"].Options = <?php echo json_encode($data_kontrak->lanjutkan->Options()) ?>;
fdata_kontrakedit.Lists["x_nama_ppkom"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$data_kontrak_edit->IsModal) { ?>
<?php } ?>
<?php $data_kontrak_edit->ShowPageHeader(); ?>
<?php
$data_kontrak_edit->ShowMessage();
?>
<form name="fdata_kontrakedit" id="fdata_kontrakedit" class="<?php echo $data_kontrak_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($data_kontrak_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $data_kontrak_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="data_kontrak">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($data_kontrak_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($data_kontrak->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_data_kontrak_id" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->id->CellAttributes() ?>>
<span id="el_data_kontrak_id">
<span<?php echo $data_kontrak->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($data_kontrak->id->CurrentValue) ?>">
<?php echo $data_kontrak->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_data_kontrak_program" for="x_program" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->program->CellAttributes() ?>>
<span id="el_data_kontrak_program">
<?php $data_kontrak->program->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$data_kontrak->program->EditAttrs["onchange"]; ?>
<select data-table="data_kontrak" data-field="x_program" data-value-separator="<?php echo $data_kontrak->program->DisplayValueSeparatorAttribute() ?>" id="x_program" name="x_program"<?php echo $data_kontrak->program->EditAttributes() ?>>
<?php echo $data_kontrak->program->SelectOptionListHtml("x_program") ?>
</select>
<input type="hidden" name="s_x_program" id="s_x_program" value="<?php echo $data_kontrak->program->LookupFilterQuery() ?>">
</span>
<?php echo $data_kontrak->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->kegiatan->Visible) { // kegiatan ?>
	<div id="r_kegiatan" class="form-group">
		<label id="elh_data_kontrak_kegiatan" for="x_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->kegiatan->CellAttributes() ?>>
<span id="el_data_kontrak_kegiatan">
<?php $data_kontrak->kegiatan->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$data_kontrak->kegiatan->EditAttrs["onchange"]; ?>
<select data-table="data_kontrak" data-field="x_kegiatan" data-value-separator="<?php echo $data_kontrak->kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kegiatan" name="x_kegiatan"<?php echo $data_kontrak->kegiatan->EditAttributes() ?>>
<?php echo $data_kontrak->kegiatan->SelectOptionListHtml("x_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kegiatan" id="s_x_kegiatan" value="<?php echo $data_kontrak->kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $data_kontrak->kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<div id="r_sub_kegiatan" class="form-group">
		<label id="elh_data_kontrak_sub_kegiatan" for="x_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->sub_kegiatan->CellAttributes() ?>>
<span id="el_data_kontrak_sub_kegiatan">
<select data-table="data_kontrak" data-field="x_sub_kegiatan" data-value-separator="<?php echo $data_kontrak->sub_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_sub_kegiatan" name="x_sub_kegiatan"<?php echo $data_kontrak->sub_kegiatan->EditAttributes() ?>>
<?php echo $data_kontrak->sub_kegiatan->SelectOptionListHtml("x_sub_kegiatan") ?>
</select>
<input type="hidden" name="s_x_sub_kegiatan" id="s_x_sub_kegiatan" value="<?php echo $data_kontrak->sub_kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $data_kontrak->sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->no_kontrak->Visible) { // no_kontrak ?>
	<div id="r_no_kontrak" class="form-group">
		<label id="elh_data_kontrak_no_kontrak" for="x_no_kontrak" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->no_kontrak->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->no_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_no_kontrak">
<input type="text" data-table="data_kontrak" data-field="x_no_kontrak" name="x_no_kontrak" id="x_no_kontrak" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->no_kontrak->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->no_kontrak->EditValue ?>"<?php echo $data_kontrak->no_kontrak->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->no_kontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->tgl_kontrak->Visible) { // tgl_kontrak ?>
	<div id="r_tgl_kontrak" class="form-group">
		<label id="elh_data_kontrak_tgl_kontrak" for="x_tgl_kontrak" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->tgl_kontrak->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->tgl_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_tgl_kontrak">
<input type="text" data-table="data_kontrak" data-field="x_tgl_kontrak" name="x_tgl_kontrak" id="x_tgl_kontrak" placeholder="<?php echo ew_HtmlEncode($data_kontrak->tgl_kontrak->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->tgl_kontrak->EditValue ?>"<?php echo $data_kontrak->tgl_kontrak->EditAttributes() ?>>
<?php if (!$data_kontrak->tgl_kontrak->ReadOnly && !$data_kontrak->tgl_kontrak->Disabled && !isset($data_kontrak->tgl_kontrak->EditAttrs["readonly"]) && !isset($data_kontrak->tgl_kontrak->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdata_kontrakedit", "x_tgl_kontrak", 0);
</script>
<?php } ?>
</span>
<?php echo $data_kontrak->tgl_kontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->nama_perusahaan->Visible) { // nama_perusahaan ?>
	<div id="r_nama_perusahaan" class="form-group">
		<label id="elh_data_kontrak_nama_perusahaan" for="x_nama_perusahaan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->nama_perusahaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->nama_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_nama_perusahaan">
<input type="text" data-table="data_kontrak" data-field="x_nama_perusahaan" name="x_nama_perusahaan" id="x_nama_perusahaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->nama_perusahaan->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->nama_perusahaan->EditValue ?>"<?php echo $data_kontrak->nama_perusahaan->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->nama_perusahaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->bentuk_perusahaan->Visible) { // bentuk_perusahaan ?>
	<div id="r_bentuk_perusahaan" class="form-group">
		<label id="elh_data_kontrak_bentuk_perusahaan" for="x_bentuk_perusahaan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->bentuk_perusahaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->bentuk_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_bentuk_perusahaan">
<select data-table="data_kontrak" data-field="x_bentuk_perusahaan" data-value-separator="<?php echo $data_kontrak->bentuk_perusahaan->DisplayValueSeparatorAttribute() ?>" id="x_bentuk_perusahaan" name="x_bentuk_perusahaan"<?php echo $data_kontrak->bentuk_perusahaan->EditAttributes() ?>>
<?php echo $data_kontrak->bentuk_perusahaan->SelectOptionListHtml("x_bentuk_perusahaan") ?>
</select>
<input type="hidden" name="s_x_bentuk_perusahaan" id="s_x_bentuk_perusahaan" value="<?php echo $data_kontrak->bentuk_perusahaan->LookupFilterQuery() ?>">
</span>
<?php echo $data_kontrak->bentuk_perusahaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->alamat_perusahaan->Visible) { // alamat_perusahaan ?>
	<div id="r_alamat_perusahaan" class="form-group">
		<label id="elh_data_kontrak_alamat_perusahaan" for="x_alamat_perusahaan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->alamat_perusahaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->alamat_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_alamat_perusahaan">
<input type="text" data-table="data_kontrak" data-field="x_alamat_perusahaan" name="x_alamat_perusahaan" id="x_alamat_perusahaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->alamat_perusahaan->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->alamat_perusahaan->EditValue ?>"<?php echo $data_kontrak->alamat_perusahaan->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->alamat_perusahaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->kepala_perusahaan->Visible) { // kepala_perusahaan ?>
	<div id="r_kepala_perusahaan" class="form-group">
		<label id="elh_data_kontrak_kepala_perusahaan" for="x_kepala_perusahaan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->kepala_perusahaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->kepala_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_kepala_perusahaan">
<input type="text" data-table="data_kontrak" data-field="x_kepala_perusahaan" name="x_kepala_perusahaan" id="x_kepala_perusahaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->kepala_perusahaan->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->kepala_perusahaan->EditValue ?>"<?php echo $data_kontrak->kepala_perusahaan->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->kepala_perusahaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->npwp->Visible) { // npwp ?>
	<div id="r_npwp" class="form-group">
		<label id="elh_data_kontrak_npwp" for="x_npwp" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->npwp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->npwp->CellAttributes() ?>>
<span id="el_data_kontrak_npwp">
<input type="text" data-table="data_kontrak" data-field="x_npwp" name="x_npwp" id="x_npwp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->npwp->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->npwp->EditValue ?>"<?php echo $data_kontrak->npwp->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->npwp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->nama_bank->Visible) { // nama_bank ?>
	<div id="r_nama_bank" class="form-group">
		<label id="elh_data_kontrak_nama_bank" for="x_nama_bank" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->nama_bank->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->nama_bank->CellAttributes() ?>>
<span id="el_data_kontrak_nama_bank">
<input type="text" data-table="data_kontrak" data-field="x_nama_bank" name="x_nama_bank" id="x_nama_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->nama_bank->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->nama_bank->EditValue ?>"<?php echo $data_kontrak->nama_bank->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->nama_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->nama_rekening->Visible) { // nama_rekening ?>
	<div id="r_nama_rekening" class="form-group">
		<label id="elh_data_kontrak_nama_rekening" for="x_nama_rekening" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->nama_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->nama_rekening->CellAttributes() ?>>
<span id="el_data_kontrak_nama_rekening">
<input type="text" data-table="data_kontrak" data-field="x_nama_rekening" name="x_nama_rekening" id="x_nama_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->nama_rekening->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->nama_rekening->EditValue ?>"<?php echo $data_kontrak->nama_rekening->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->nama_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->nomer_rekening->Visible) { // nomer_rekening ?>
	<div id="r_nomer_rekening" class="form-group">
		<label id="elh_data_kontrak_nomer_rekening" for="x_nomer_rekening" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->nomer_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->nomer_rekening->CellAttributes() ?>>
<span id="el_data_kontrak_nomer_rekening">
<input type="text" data-table="data_kontrak" data-field="x_nomer_rekening" name="x_nomer_rekening" id="x_nomer_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->nomer_rekening->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->nomer_rekening->EditValue ?>"<?php echo $data_kontrak->nomer_rekening->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->nomer_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->lanjutkan->Visible) { // lanjutkan ?>
	<div id="r_lanjutkan" class="form-group">
		<label id="elh_data_kontrak_lanjutkan" for="x_lanjutkan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->lanjutkan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->lanjutkan->CellAttributes() ?>>
<span id="el_data_kontrak_lanjutkan">
<select data-table="data_kontrak" data-field="x_lanjutkan" data-value-separator="<?php echo $data_kontrak->lanjutkan->DisplayValueSeparatorAttribute() ?>" id="x_lanjutkan" name="x_lanjutkan"<?php echo $data_kontrak->lanjutkan->EditAttributes() ?>>
<?php echo $data_kontrak->lanjutkan->SelectOptionListHtml("x_lanjutkan") ?>
</select>
</span>
<?php echo $data_kontrak->lanjutkan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->waktu_kontrak->Visible) { // waktu_kontrak ?>
	<div id="r_waktu_kontrak" class="form-group">
		<label id="elh_data_kontrak_waktu_kontrak" for="x_waktu_kontrak" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->waktu_kontrak->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->waktu_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_waktu_kontrak">
<input type="text" data-table="data_kontrak" data-field="x_waktu_kontrak" name="x_waktu_kontrak" id="x_waktu_kontrak" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->waktu_kontrak->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->waktu_kontrak->EditValue ?>"<?php echo $data_kontrak->waktu_kontrak->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->waktu_kontrak->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->tgl_mulai->Visible) { // tgl_mulai ?>
	<div id="r_tgl_mulai" class="form-group">
		<label id="elh_data_kontrak_tgl_mulai" for="x_tgl_mulai" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->tgl_mulai->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->tgl_mulai->CellAttributes() ?>>
<span id="el_data_kontrak_tgl_mulai">
<input type="text" data-table="data_kontrak" data-field="x_tgl_mulai" data-format="7" name="x_tgl_mulai" id="x_tgl_mulai" placeholder="<?php echo ew_HtmlEncode($data_kontrak->tgl_mulai->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->tgl_mulai->EditValue ?>"<?php echo $data_kontrak->tgl_mulai->EditAttributes() ?>>
<?php if (!$data_kontrak->tgl_mulai->ReadOnly && !$data_kontrak->tgl_mulai->Disabled && !isset($data_kontrak->tgl_mulai->EditAttrs["readonly"]) && !isset($data_kontrak->tgl_mulai->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdata_kontrakedit", "x_tgl_mulai", 7);
</script>
<?php } ?>
</span>
<?php echo $data_kontrak->tgl_mulai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->tgl_selesai->Visible) { // tgl_selesai ?>
	<div id="r_tgl_selesai" class="form-group">
		<label id="elh_data_kontrak_tgl_selesai" for="x_tgl_selesai" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->tgl_selesai->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->tgl_selesai->CellAttributes() ?>>
<span id="el_data_kontrak_tgl_selesai">
<input type="text" data-table="data_kontrak" data-field="x_tgl_selesai" data-format="7" name="x_tgl_selesai" id="x_tgl_selesai" placeholder="<?php echo ew_HtmlEncode($data_kontrak->tgl_selesai->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->tgl_selesai->EditValue ?>"<?php echo $data_kontrak->tgl_selesai->EditAttributes() ?>>
<?php if (!$data_kontrak->tgl_selesai->ReadOnly && !$data_kontrak->tgl_selesai->Disabled && !isset($data_kontrak->tgl_selesai->EditAttrs["readonly"]) && !isset($data_kontrak->tgl_selesai->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdata_kontrakedit", "x_tgl_selesai", 7);
</script>
<?php } ?>
</span>
<?php echo $data_kontrak->tgl_selesai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->paket_pekerjaan->Visible) { // paket_pekerjaan ?>
	<div id="r_paket_pekerjaan" class="form-group">
		<label id="elh_data_kontrak_paket_pekerjaan" for="x_paket_pekerjaan" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->paket_pekerjaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->paket_pekerjaan->CellAttributes() ?>>
<span id="el_data_kontrak_paket_pekerjaan">
<input type="text" data-table="data_kontrak" data-field="x_paket_pekerjaan" name="x_paket_pekerjaan" id="x_paket_pekerjaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->paket_pekerjaan->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->paket_pekerjaan->EditValue ?>"<?php echo $data_kontrak->paket_pekerjaan->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->paket_pekerjaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->nama_ppkom->Visible) { // nama_ppkom ?>
	<div id="r_nama_ppkom" class="form-group">
		<label id="elh_data_kontrak_nama_ppkom" for="x_nama_ppkom" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->nama_ppkom->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->nama_ppkom->CellAttributes() ?>>
<span id="el_data_kontrak_nama_ppkom">
<?php $data_kontrak->nama_ppkom->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$data_kontrak->nama_ppkom->EditAttrs["onchange"]; ?>
<select data-table="data_kontrak" data-field="x_nama_ppkom" data-value-separator="<?php echo $data_kontrak->nama_ppkom->DisplayValueSeparatorAttribute() ?>" id="x_nama_ppkom" name="x_nama_ppkom"<?php echo $data_kontrak->nama_ppkom->EditAttributes() ?>>
<?php echo $data_kontrak->nama_ppkom->SelectOptionListHtml("x_nama_ppkom") ?>
</select>
<input type="hidden" name="s_x_nama_ppkom" id="s_x_nama_ppkom" value="<?php echo $data_kontrak->nama_ppkom->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_ppkom" id="ln_x_nama_ppkom" value="x_nip_ppkom">
</span>
<?php echo $data_kontrak->nama_ppkom->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak->nip_ppkom->Visible) { // nip_ppkom ?>
	<div id="r_nip_ppkom" class="form-group">
		<label id="elh_data_kontrak_nip_ppkom" for="x_nip_ppkom" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak->nip_ppkom->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak->nip_ppkom->CellAttributes() ?>>
<span id="el_data_kontrak_nip_ppkom">
<input type="text" data-table="data_kontrak" data-field="x_nip_ppkom" name="x_nip_ppkom" id="x_nip_ppkom" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($data_kontrak->nip_ppkom->getPlaceHolder()) ?>" value="<?php echo $data_kontrak->nip_ppkom->EditValue ?>"<?php echo $data_kontrak->nip_ppkom->EditAttributes() ?>>
</span>
<?php echo $data_kontrak->nip_ppkom->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("data_kontrak_detail_termin", explode(",", $data_kontrak->getCurrentDetailTable())) && $data_kontrak_detail_termin->DetailEdit) {
?>
<?php if ($data_kontrak->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("data_kontrak_detail_termin", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "data_kontrak_detail_termingrid.php" ?>
<?php } ?>
<?php if (!$data_kontrak_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $data_kontrak_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdata_kontrakedit.Init();
</script>
<?php
$data_kontrak_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$data_kontrak_edit->Page_Terminate();
?>
