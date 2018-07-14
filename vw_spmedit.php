<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spminfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spm_edit = NULL; // Initialize page object first

class cvw_spm_edit extends cvw_spm {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spm';

	// Page object name
	var $PageObjName = 'vw_spm_edit';

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

		// Table object (vw_spm)
		if (!isset($GLOBALS["vw_spm"]) || get_class($GLOBALS["vw_spm"]) == "cvw_spm") {
			$GLOBALS["vw_spm"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spm"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spm', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spmlist.php"));
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
		$this->detail_jenis_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->no_spm->SetVisibility();
		$this->tgl_spm->SetVisibility();
		$this->status_spm->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->nomer_rekening_bank->SetVisibility();
		$this->pimpinan_blud->SetVisibility();
		$this->nip_pimpinan->SetVisibility();
		$this->no_sptb->SetVisibility();
		$this->tgl_sptb->SetVisibility();

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
		global $EW_EXPORT, $vw_spm;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spm);
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
			$this->Page_Terminate("vw_spmlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_spmlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_spmlist.php")
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
		if (!$this->detail_jenis_spp->FldIsDetailKey) {
			$this->detail_jenis_spp->setFormValue($objForm->GetValue("x_detail_jenis_spp"));
		}
		if (!$this->no_spp->FldIsDetailKey) {
			$this->no_spp->setFormValue($objForm->GetValue("x_no_spp"));
		}
		if (!$this->tgl_spp->FldIsDetailKey) {
			$this->tgl_spp->setFormValue($objForm->GetValue("x_tgl_spp"));
			$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 0);
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->no_spm->FldIsDetailKey) {
			$this->no_spm->setFormValue($objForm->GetValue("x_no_spm"));
		}
		if (!$this->tgl_spm->FldIsDetailKey) {
			$this->tgl_spm->setFormValue($objForm->GetValue("x_tgl_spm"));
			$this->tgl_spm->CurrentValue = ew_UnFormatDateTime($this->tgl_spm->CurrentValue, 7);
		}
		if (!$this->status_spm->FldIsDetailKey) {
			$this->status_spm->setFormValue($objForm->GetValue("x_status_spm"));
		}
		if (!$this->nama_bank->FldIsDetailKey) {
			$this->nama_bank->setFormValue($objForm->GetValue("x_nama_bank"));
		}
		if (!$this->nomer_rekening_bank->FldIsDetailKey) {
			$this->nomer_rekening_bank->setFormValue($objForm->GetValue("x_nomer_rekening_bank"));
		}
		if (!$this->pimpinan_blud->FldIsDetailKey) {
			$this->pimpinan_blud->setFormValue($objForm->GetValue("x_pimpinan_blud"));
		}
		if (!$this->nip_pimpinan->FldIsDetailKey) {
			$this->nip_pimpinan->setFormValue($objForm->GetValue("x_nip_pimpinan"));
		}
		if (!$this->no_sptb->FldIsDetailKey) {
			$this->no_sptb->setFormValue($objForm->GetValue("x_no_sptb"));
		}
		if (!$this->tgl_sptb->FldIsDetailKey) {
			$this->tgl_sptb->setFormValue($objForm->GetValue("x_tgl_sptb"));
			$this->tgl_sptb->CurrentValue = ew_UnFormatDateTime($this->tgl_sptb->CurrentValue, 7);
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->FormValue;
		$this->no_spp->CurrentValue = $this->no_spp->FormValue;
		$this->tgl_spp->CurrentValue = $this->tgl_spp->FormValue;
		$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 0);
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->no_spm->CurrentValue = $this->no_spm->FormValue;
		$this->tgl_spm->CurrentValue = $this->tgl_spm->FormValue;
		$this->tgl_spm->CurrentValue = ew_UnFormatDateTime($this->tgl_spm->CurrentValue, 7);
		$this->status_spm->CurrentValue = $this->status_spm->FormValue;
		$this->nama_bank->CurrentValue = $this->nama_bank->FormValue;
		$this->nomer_rekening_bank->CurrentValue = $this->nomer_rekening_bank->FormValue;
		$this->pimpinan_blud->CurrentValue = $this->pimpinan_blud->FormValue;
		$this->nip_pimpinan->CurrentValue = $this->nip_pimpinan->FormValue;
		$this->no_sptb->CurrentValue = $this->no_sptb->FormValue;
		$this->tgl_sptb->CurrentValue = $this->tgl_sptb->FormValue;
		$this->tgl_sptb->CurrentValue = ew_UnFormatDateTime($this->tgl_sptb->CurrentValue, 7);
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
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->status_spp->setDbValue($rs->fields('status_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->jumlah_up->setDbValue($rs->fields('jumlah_up'));
		$this->bendahara->setDbValue($rs->fields('bendahara'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->no_spm->setDbValue($rs->fields('no_spm'));
		$this->tgl_spm->setDbValue($rs->fields('tgl_spm'));
		$this->status_spm->setDbValue($rs->fields('status_spm'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nomer_rekening_bank->setDbValue($rs->fields('nomer_rekening_bank'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->pimpinan_blud->setDbValue($rs->fields('pimpinan_blud'));
		$this->nip_pimpinan->setDbValue($rs->fields('nip_pimpinan'));
		$this->no_sptb->setDbValue($rs->fields('no_sptb'));
		$this->tgl_sptb->setDbValue($rs->fields('tgl_sptb'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->status_spp->DbValue = $row['status_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->tgl_spp->DbValue = $row['tgl_spp'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->jumlah_up->DbValue = $row['jumlah_up'];
		$this->bendahara->DbValue = $row['bendahara'];
		$this->nama_pptk->DbValue = $row['nama_pptk'];
		$this->nip_pptk->DbValue = $row['nip_pptk'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
		$this->nomer_dasar_spd->DbValue = $row['nomer_dasar_spd'];
		$this->tanggal_spd->DbValue = $row['tanggal_spd'];
		$this->id_spd->DbValue = $row['id_spd'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->no_spm->DbValue = $row['no_spm'];
		$this->tgl_spm->DbValue = $row['tgl_spm'];
		$this->status_spm->DbValue = $row['status_spm'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->nomer_rekening_bank->DbValue = $row['nomer_rekening_bank'];
		$this->npwp->DbValue = $row['npwp'];
		$this->pimpinan_blud->DbValue = $row['pimpinan_blud'];
		$this->nip_pimpinan->DbValue = $row['nip_pimpinan'];
		$this->no_sptb->DbValue = $row['no_sptb'];
		$this->tgl_sptb->DbValue = $row['tgl_sptb'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// detail_jenis_spp
		// id_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// keterangan
		// jumlah_up
		// bendahara
		// nama_pptk
		// nip_pptk
		// kode_program
		// kode_kegiatan
		// kode_sub_kegiatan
		// tahun_anggaran
		// jumlah_spd
		// nomer_dasar_spd
		// tanggal_spd
		// id_spd
		// kode_rekening
		// nama_bendahara
		// nip_bendahara
		// no_spm
		// tgl_spm
		// status_spm
		// nama_bank
		// nomer_rekening_bank
		// npwp
		// pimpinan_blud
		// nip_pimpinan
		// no_sptb
		// tgl_sptb

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// detail_jenis_spp
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

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		$this->id_jenis_spp->ViewCustomAttributes = "";

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
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 0);
		$this->tgl_spp->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// jumlah_up
		$this->jumlah_up->ViewValue = $this->jumlah_up->CurrentValue;
		$this->jumlah_up->ViewCustomAttributes = "";

		// bendahara
		$this->bendahara->ViewValue = $this->bendahara->CurrentValue;
		$this->bendahara->ViewCustomAttributes = "";

		// nama_pptk
		$this->nama_pptk->ViewValue = $this->nama_pptk->CurrentValue;
		$this->nama_pptk->ViewCustomAttributes = "";

		// nip_pptk
		$this->nip_pptk->ViewValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->ViewCustomAttributes = "";

		// kode_program
		$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
		$this->kode_program->ViewCustomAttributes = "";

		// kode_kegiatan
		$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->CurrentValue;
		$this->kode_kegiatan->ViewCustomAttributes = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->CurrentValue;
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

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

		// id_spd
		$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
		$this->id_spd->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// nama_bendahara
		$this->nama_bendahara->ViewValue = $this->nama_bendahara->CurrentValue;
		$this->nama_bendahara->ViewCustomAttributes = "";

		// nip_bendahara
		$this->nip_bendahara->ViewValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->ViewCustomAttributes = "";

		// no_spm
		$this->no_spm->ViewValue = $this->no_spm->CurrentValue;
		$this->no_spm->ViewCustomAttributes = "";

		// tgl_spm
		$this->tgl_spm->ViewValue = $this->tgl_spm->CurrentValue;
		$this->tgl_spm->ViewValue = ew_FormatDateTime($this->tgl_spm->ViewValue, 7);
		$this->tgl_spm->ViewCustomAttributes = "";

		// status_spm
		if (strval($this->status_spm->CurrentValue) <> "") {
			$this->status_spm->ViewValue = $this->status_spm->OptionCaption($this->status_spm->CurrentValue);
		} else {
			$this->status_spm->ViewValue = NULL;
		}
		$this->status_spm->ViewCustomAttributes = "";

		// nama_bank
		if (strval($this->nama_bank->CurrentValue) <> "") {
			$sFilterWrk = "`rekening`" . ew_SearchString("=", $this->nama_bank->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `rekening`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_blud_rs`";
		$sWhereWrk = "";
		$this->nama_bank->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_bank, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_bank->ViewValue = $this->nama_bank->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
			}
		} else {
			$this->nama_bank->ViewValue = NULL;
		}
		$this->nama_bank->ViewCustomAttributes = "";

		// nomer_rekening_bank
		$this->nomer_rekening_bank->ViewValue = $this->nomer_rekening_bank->CurrentValue;
		$this->nomer_rekening_bank->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// pimpinan_blud
		$this->pimpinan_blud->ViewValue = $this->pimpinan_blud->CurrentValue;
		$this->pimpinan_blud->ViewCustomAttributes = "";

		// nip_pimpinan
		$this->nip_pimpinan->ViewValue = $this->nip_pimpinan->CurrentValue;
		$this->nip_pimpinan->ViewCustomAttributes = "";

		// no_sptb
		$this->no_sptb->ViewValue = $this->no_sptb->CurrentValue;
		$this->no_sptb->ViewCustomAttributes = "";

		// tgl_sptb
		$this->tgl_sptb->ViewValue = $this->tgl_sptb->CurrentValue;
		$this->tgl_sptb->ViewValue = ew_FormatDateTime($this->tgl_sptb->ViewValue, 7);
		$this->tgl_sptb->ViewCustomAttributes = "";

			// detail_jenis_spp
			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";
			$this->detail_jenis_spp->TooltipValue = "";

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

			// no_spm
			$this->no_spm->LinkCustomAttributes = "";
			$this->no_spm->HrefValue = "";
			$this->no_spm->TooltipValue = "";

			// tgl_spm
			$this->tgl_spm->LinkCustomAttributes = "";
			$this->tgl_spm->HrefValue = "";
			$this->tgl_spm->TooltipValue = "";

			// status_spm
			$this->status_spm->LinkCustomAttributes = "";
			$this->status_spm->HrefValue = "";
			$this->status_spm->TooltipValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";
			$this->nama_bank->TooltipValue = "";

			// nomer_rekening_bank
			$this->nomer_rekening_bank->LinkCustomAttributes = "";
			$this->nomer_rekening_bank->HrefValue = "";
			$this->nomer_rekening_bank->TooltipValue = "";

			// pimpinan_blud
			$this->pimpinan_blud->LinkCustomAttributes = "";
			$this->pimpinan_blud->HrefValue = "";
			$this->pimpinan_blud->TooltipValue = "";

			// nip_pimpinan
			$this->nip_pimpinan->LinkCustomAttributes = "";
			$this->nip_pimpinan->HrefValue = "";
			$this->nip_pimpinan->TooltipValue = "";

			// no_sptb
			$this->no_sptb->LinkCustomAttributes = "";
			$this->no_sptb->HrefValue = "";
			$this->no_sptb->TooltipValue = "";

			// tgl_sptb
			$this->tgl_sptb->LinkCustomAttributes = "";
			$this->tgl_sptb->HrefValue = "";
			$this->tgl_sptb->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// detail_jenis_spp
			$this->detail_jenis_spp->EditAttrs["class"] = "form-control";
			$this->detail_jenis_spp->EditCustomAttributes = "";
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
					$this->detail_jenis_spp->EditValue = $this->detail_jenis_spp->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->detail_jenis_spp->EditValue = $this->detail_jenis_spp->CurrentValue;
				}
			} else {
				$this->detail_jenis_spp->EditValue = NULL;
			}
			$this->detail_jenis_spp->ViewCustomAttributes = "";

			// no_spp
			$this->no_spp->EditAttrs["class"] = "form-control";
			$this->no_spp->EditCustomAttributes = "";
			$this->no_spp->EditValue = $this->no_spp->CurrentValue;
			$this->no_spp->ViewCustomAttributes = "";

			// tgl_spp
			$this->tgl_spp->EditAttrs["class"] = "form-control";
			$this->tgl_spp->EditCustomAttributes = "";
			$this->tgl_spp->EditValue = $this->tgl_spp->CurrentValue;
			$this->tgl_spp->EditValue = ew_FormatDateTime($this->tgl_spp->EditValue, 0);
			$this->tgl_spp->ViewCustomAttributes = "";

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = $this->keterangan->CurrentValue;
			$this->keterangan->ViewCustomAttributes = "";

			// no_spm
			$this->no_spm->EditAttrs["class"] = "form-control";
			$this->no_spm->EditCustomAttributes = "";
			$this->no_spm->EditValue = ew_HtmlEncode($this->no_spm->CurrentValue);
			$this->no_spm->PlaceHolder = ew_RemoveHtml($this->no_spm->FldCaption());

			// tgl_spm
			$this->tgl_spm->EditAttrs["class"] = "form-control";
			$this->tgl_spm->EditCustomAttributes = "";
			$this->tgl_spm->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_spm->CurrentValue, 7));
			$this->tgl_spm->PlaceHolder = ew_RemoveHtml($this->tgl_spm->FldCaption());

			// status_spm
			$this->status_spm->EditCustomAttributes = "";
			$this->status_spm->EditValue = $this->status_spm->Options(FALSE);

			// nama_bank
			$this->nama_bank->EditAttrs["class"] = "form-control";
			$this->nama_bank->EditCustomAttributes = "";
			if (trim(strval($this->nama_bank->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`rekening`" . ew_SearchString("=", $this->nama_bank->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `rekening`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_blud_rs`";
			$sWhereWrk = "";
			$this->nama_bank->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_bank, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_bank->EditValue = $arwrk;

			// nomer_rekening_bank
			$this->nomer_rekening_bank->EditAttrs["class"] = "form-control";
			$this->nomer_rekening_bank->EditCustomAttributes = "";
			$this->nomer_rekening_bank->EditValue = ew_HtmlEncode($this->nomer_rekening_bank->CurrentValue);
			$this->nomer_rekening_bank->PlaceHolder = ew_RemoveHtml($this->nomer_rekening_bank->FldCaption());

			// pimpinan_blud
			$this->pimpinan_blud->EditAttrs["class"] = "form-control";
			$this->pimpinan_blud->EditCustomAttributes = "";
			$this->pimpinan_blud->EditValue = ew_HtmlEncode($this->pimpinan_blud->CurrentValue);
			$this->pimpinan_blud->PlaceHolder = ew_RemoveHtml($this->pimpinan_blud->FldCaption());

			// nip_pimpinan
			$this->nip_pimpinan->EditAttrs["class"] = "form-control";
			$this->nip_pimpinan->EditCustomAttributes = "";
			$this->nip_pimpinan->EditValue = ew_HtmlEncode($this->nip_pimpinan->CurrentValue);
			$this->nip_pimpinan->PlaceHolder = ew_RemoveHtml($this->nip_pimpinan->FldCaption());

			// no_sptb
			$this->no_sptb->EditAttrs["class"] = "form-control";
			$this->no_sptb->EditCustomAttributes = "";
			$this->no_sptb->EditValue = ew_HtmlEncode($this->no_sptb->CurrentValue);
			$this->no_sptb->PlaceHolder = ew_RemoveHtml($this->no_sptb->FldCaption());

			// tgl_sptb
			$this->tgl_sptb->EditAttrs["class"] = "form-control";
			$this->tgl_sptb->EditCustomAttributes = "";
			$this->tgl_sptb->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sptb->CurrentValue, 7));
			$this->tgl_sptb->PlaceHolder = ew_RemoveHtml($this->tgl_sptb->FldCaption());

			// Edit refer script
			// detail_jenis_spp

			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";
			$this->detail_jenis_spp->TooltipValue = "";

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

			// no_spm
			$this->no_spm->LinkCustomAttributes = "";
			$this->no_spm->HrefValue = "";

			// tgl_spm
			$this->tgl_spm->LinkCustomAttributes = "";
			$this->tgl_spm->HrefValue = "";

			// status_spm
			$this->status_spm->LinkCustomAttributes = "";
			$this->status_spm->HrefValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";

			// nomer_rekening_bank
			$this->nomer_rekening_bank->LinkCustomAttributes = "";
			$this->nomer_rekening_bank->HrefValue = "";

			// pimpinan_blud
			$this->pimpinan_blud->LinkCustomAttributes = "";
			$this->pimpinan_blud->HrefValue = "";

			// nip_pimpinan
			$this->nip_pimpinan->LinkCustomAttributes = "";
			$this->nip_pimpinan->HrefValue = "";

			// no_sptb
			$this->no_sptb->LinkCustomAttributes = "";
			$this->no_sptb->HrefValue = "";

			// tgl_sptb
			$this->tgl_sptb->LinkCustomAttributes = "";
			$this->tgl_sptb->HrefValue = "";
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
		if (!$this->tgl_spm->FldIsDetailKey && !is_null($this->tgl_spm->FormValue) && $this->tgl_spm->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tgl_spm->FldCaption(), $this->tgl_spm->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->tgl_spm->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spm->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->tgl_sptb->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_sptb->FldErrMsg());
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

			// no_spm
			$this->no_spm->SetDbValueDef($rsnew, $this->no_spm->CurrentValue, NULL, $this->no_spm->ReadOnly);

			// tgl_spm
			$this->tgl_spm->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spm->CurrentValue, 7), NULL, $this->tgl_spm->ReadOnly);

			// status_spm
			$this->status_spm->SetDbValueDef($rsnew, $this->status_spm->CurrentValue, NULL, $this->status_spm->ReadOnly);

			// nama_bank
			$this->nama_bank->SetDbValueDef($rsnew, $this->nama_bank->CurrentValue, NULL, $this->nama_bank->ReadOnly);

			// nomer_rekening_bank
			$this->nomer_rekening_bank->SetDbValueDef($rsnew, $this->nomer_rekening_bank->CurrentValue, NULL, $this->nomer_rekening_bank->ReadOnly);

			// pimpinan_blud
			$this->pimpinan_blud->SetDbValueDef($rsnew, $this->pimpinan_blud->CurrentValue, NULL, $this->pimpinan_blud->ReadOnly);

			// nip_pimpinan
			$this->nip_pimpinan->SetDbValueDef($rsnew, $this->nip_pimpinan->CurrentValue, NULL, $this->nip_pimpinan->ReadOnly);

			// no_sptb
			$this->no_sptb->SetDbValueDef($rsnew, $this->no_sptb->CurrentValue, NULL, $this->no_sptb->ReadOnly);

			// tgl_sptb
			$this->tgl_sptb->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sptb->CurrentValue, 7), NULL, $this->tgl_sptb->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spmlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_nama_bank":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `rekening` AS `LinkFld`, `rekening` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_blud_rs`";
			$sWhereWrk = "";
			$this->nama_bank->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`rekening` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_bank, $sWhereWrk); // Call Lookup selecting
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
		$this->OtherOptions["edit"] = new cListOptions();
		$this->OtherOptions["edit"]->Body = "";
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
if (!isset($vw_spm_edit)) $vw_spm_edit = new cvw_spm_edit();

// Page init
$vw_spm_edit->Page_Init();

// Page main
$vw_spm_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spm_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_spmedit = new ew_Form("fvw_spmedit", "edit");

// Validate form
fvw_spmedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_spm");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spm->tgl_spm->FldCaption(), $vw_spm->tgl_spm->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_spm");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spm->tgl_spm->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_sptb");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spm->tgl_sptb->FldErrMsg()) ?>");

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
fvw_spmedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spmedit.ValidateRequired = true;
<?php } else { ?>
fvw_spmedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spmedit.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
fvw_spmedit.Lists["x_status_spm"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spmedit.Lists["x_status_spm"].Options = <?php echo json_encode($vw_spm->status_spm->Options()) ?>;
fvw_spmedit.Lists["x_nama_bank"] = {"LinkField":"x_rekening","Ajax":true,"AutoFill":true,"DisplayFields":["x_rekening","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_blud_rs"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spm_edit->IsModal) { ?>
<?php } ?>
<?php $vw_spm_edit->ShowPageHeader(); ?>
<?php
$vw_spm_edit->ShowMessage();
?>
<form name="fvw_spmedit" id="fvw_spmedit" class="<?php echo $vw_spm_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spm_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spm_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spm">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_spm_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_spm->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<div id="r_detail_jenis_spp" class="form-group">
		<label id="elh_vw_spm_detail_jenis_spp" for="x_detail_jenis_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->detail_jenis_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->detail_jenis_spp->CellAttributes() ?>>
<span id="el_vw_spm_detail_jenis_spp">
<span<?php echo $vw_spm->detail_jenis_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spm->detail_jenis_spp->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spm" data-field="x_detail_jenis_spp" name="x_detail_jenis_spp" id="x_detail_jenis_spp" value="<?php echo ew_HtmlEncode($vw_spm->detail_jenis_spp->CurrentValue) ?>">
<?php echo $vw_spm->detail_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->no_spp->Visible) { // no_spp ?>
	<div id="r_no_spp" class="form-group">
		<label id="elh_vw_spm_no_spp" for="x_no_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->no_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->no_spp->CellAttributes() ?>>
<span id="el_vw_spm_no_spp">
<span<?php echo $vw_spm->no_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spm->no_spp->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spm" data-field="x_no_spp" name="x_no_spp" id="x_no_spp" value="<?php echo ew_HtmlEncode($vw_spm->no_spp->CurrentValue) ?>">
<?php echo $vw_spm->no_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->tgl_spp->Visible) { // tgl_spp ?>
	<div id="r_tgl_spp" class="form-group">
		<label id="elh_vw_spm_tgl_spp" for="x_tgl_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->tgl_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spm_tgl_spp">
<span<?php echo $vw_spm->tgl_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spm->tgl_spp->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spm" data-field="x_tgl_spp" name="x_tgl_spp" id="x_tgl_spp" value="<?php echo ew_HtmlEncode($vw_spm->tgl_spp->CurrentValue) ?>">
<?php echo $vw_spm->tgl_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_vw_spm_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->keterangan->CellAttributes() ?>>
<span id="el_vw_spm_keterangan">
<span<?php echo $vw_spm->keterangan->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spm->keterangan->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spm" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" value="<?php echo ew_HtmlEncode($vw_spm->keterangan->CurrentValue) ?>">
<?php echo $vw_spm->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->no_spm->Visible) { // no_spm ?>
	<div id="r_no_spm" class="form-group">
		<label id="elh_vw_spm_no_spm" for="x_no_spm" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->no_spm->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->no_spm->CellAttributes() ?>>
<span id="el_vw_spm_no_spm">
<input type="text" data-table="vw_spm" data-field="x_no_spm" name="x_no_spm" id="x_no_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spm->no_spm->getPlaceHolder()) ?>" value="<?php echo $vw_spm->no_spm->EditValue ?>"<?php echo $vw_spm->no_spm->EditAttributes() ?>>
</span>
<?php echo $vw_spm->no_spm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->tgl_spm->Visible) { // tgl_spm ?>
	<div id="r_tgl_spm" class="form-group">
		<label id="elh_vw_spm_tgl_spm" for="x_tgl_spm" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->tgl_spm->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->tgl_spm->CellAttributes() ?>>
<span id="el_vw_spm_tgl_spm">
<input type="text" data-table="vw_spm" data-field="x_tgl_spm" data-format="7" name="x_tgl_spm" id="x_tgl_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spm->tgl_spm->getPlaceHolder()) ?>" value="<?php echo $vw_spm->tgl_spm->EditValue ?>"<?php echo $vw_spm->tgl_spm->EditAttributes() ?>>
<?php if (!$vw_spm->tgl_spm->ReadOnly && !$vw_spm->tgl_spm->Disabled && !isset($vw_spm->tgl_spm->EditAttrs["readonly"]) && !isset($vw_spm->tgl_spm->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_spmedit", "x_tgl_spm", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_spm->tgl_spm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->status_spm->Visible) { // status_spm ?>
	<div id="r_status_spm" class="form-group">
		<label id="elh_vw_spm_status_spm" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->status_spm->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->status_spm->CellAttributes() ?>>
<span id="el_vw_spm_status_spm">
<div id="tp_x_status_spm" class="ewTemplate"><input type="radio" data-table="vw_spm" data-field="x_status_spm" data-value-separator="<?php echo $vw_spm->status_spm->DisplayValueSeparatorAttribute() ?>" name="x_status_spm" id="x_status_spm" value="{value}"<?php echo $vw_spm->status_spm->EditAttributes() ?>></div>
<div id="dsl_x_status_spm" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_spm->status_spm->RadioButtonListHtml(FALSE, "x_status_spm") ?>
</div></div>
</span>
<?php echo $vw_spm->status_spm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->nama_bank->Visible) { // nama_bank ?>
	<div id="r_nama_bank" class="form-group">
		<label id="elh_vw_spm_nama_bank" for="x_nama_bank" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->nama_bank->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->nama_bank->CellAttributes() ?>>
<span id="el_vw_spm_nama_bank">
<?php $vw_spm->nama_bank->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_spm->nama_bank->EditAttrs["onchange"]; ?>
<select data-table="vw_spm" data-field="x_nama_bank" data-value-separator="<?php echo $vw_spm->nama_bank->DisplayValueSeparatorAttribute() ?>" id="x_nama_bank" name="x_nama_bank"<?php echo $vw_spm->nama_bank->EditAttributes() ?>>
<?php echo $vw_spm->nama_bank->SelectOptionListHtml("x_nama_bank") ?>
</select>
<input type="hidden" name="s_x_nama_bank" id="s_x_nama_bank" value="<?php echo $vw_spm->nama_bank->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_bank" id="ln_x_nama_bank" value="x_nomer_rekening_bank,x_pimpinan_blud,x_nip_pimpinan">
</span>
<?php echo $vw_spm->nama_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->nomer_rekening_bank->Visible) { // nomer_rekening_bank ?>
	<div id="r_nomer_rekening_bank" class="form-group">
		<label id="elh_vw_spm_nomer_rekening_bank" for="x_nomer_rekening_bank" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->nomer_rekening_bank->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->nomer_rekening_bank->CellAttributes() ?>>
<span id="el_vw_spm_nomer_rekening_bank">
<input type="text" data-table="vw_spm" data-field="x_nomer_rekening_bank" name="x_nomer_rekening_bank" id="x_nomer_rekening_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spm->nomer_rekening_bank->getPlaceHolder()) ?>" value="<?php echo $vw_spm->nomer_rekening_bank->EditValue ?>"<?php echo $vw_spm->nomer_rekening_bank->EditAttributes() ?>>
</span>
<?php echo $vw_spm->nomer_rekening_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->pimpinan_blud->Visible) { // pimpinan_blud ?>
	<div id="r_pimpinan_blud" class="form-group">
		<label id="elh_vw_spm_pimpinan_blud" for="x_pimpinan_blud" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->pimpinan_blud->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->pimpinan_blud->CellAttributes() ?>>
<span id="el_vw_spm_pimpinan_blud">
<input type="text" data-table="vw_spm" data-field="x_pimpinan_blud" name="x_pimpinan_blud" id="x_pimpinan_blud" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spm->pimpinan_blud->getPlaceHolder()) ?>" value="<?php echo $vw_spm->pimpinan_blud->EditValue ?>"<?php echo $vw_spm->pimpinan_blud->EditAttributes() ?>>
</span>
<?php echo $vw_spm->pimpinan_blud->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->nip_pimpinan->Visible) { // nip_pimpinan ?>
	<div id="r_nip_pimpinan" class="form-group">
		<label id="elh_vw_spm_nip_pimpinan" for="x_nip_pimpinan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->nip_pimpinan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->nip_pimpinan->CellAttributes() ?>>
<span id="el_vw_spm_nip_pimpinan">
<input type="text" data-table="vw_spm" data-field="x_nip_pimpinan" name="x_nip_pimpinan" id="x_nip_pimpinan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spm->nip_pimpinan->getPlaceHolder()) ?>" value="<?php echo $vw_spm->nip_pimpinan->EditValue ?>"<?php echo $vw_spm->nip_pimpinan->EditAttributes() ?>>
</span>
<?php echo $vw_spm->nip_pimpinan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->no_sptb->Visible) { // no_sptb ?>
	<div id="r_no_sptb" class="form-group">
		<label id="elh_vw_spm_no_sptb" for="x_no_sptb" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->no_sptb->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->no_sptb->CellAttributes() ?>>
<span id="el_vw_spm_no_sptb">
<input type="text" data-table="vw_spm" data-field="x_no_sptb" name="x_no_sptb" id="x_no_sptb" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spm->no_sptb->getPlaceHolder()) ?>" value="<?php echo $vw_spm->no_sptb->EditValue ?>"<?php echo $vw_spm->no_sptb->EditAttributes() ?>>
</span>
<?php echo $vw_spm->no_sptb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spm->tgl_sptb->Visible) { // tgl_sptb ?>
	<div id="r_tgl_sptb" class="form-group">
		<label id="elh_vw_spm_tgl_sptb" for="x_tgl_sptb" class="col-sm-2 control-label ewLabel"><?php echo $vw_spm->tgl_sptb->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spm->tgl_sptb->CellAttributes() ?>>
<span id="el_vw_spm_tgl_sptb">
<input type="text" data-table="vw_spm" data-field="x_tgl_sptb" data-format="7" name="x_tgl_sptb" id="x_tgl_sptb" placeholder="<?php echo ew_HtmlEncode($vw_spm->tgl_sptb->getPlaceHolder()) ?>" value="<?php echo $vw_spm->tgl_sptb->EditValue ?>"<?php echo $vw_spm->tgl_sptb->EditAttributes() ?>>
<?php if (!$vw_spm->tgl_sptb->ReadOnly && !$vw_spm->tgl_sptb->Disabled && !isset($vw_spm->tgl_sptb->EditAttrs["readonly"]) && !isset($vw_spm->tgl_sptb->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_spmedit", "x_tgl_sptb", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_spm->tgl_sptb->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="vw_spm" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($vw_spm->id->CurrentValue) ?>">
<?php if (!$vw_spm_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spm_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spmedit.Init();
</script>
<?php
$vw_spm_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spm_edit->Page_Terminate();
?>
