<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_sbpinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_sbp_edit = NULL; // Initialize page object first

class ct_sbp_edit extends ct_sbp {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sbp';

	// Page object name
	var $PageObjName = 't_sbp_edit';

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

		// Table object (t_sbp)
		if (!isset($GLOBALS["t_sbp"]) || get_class($GLOBALS["t_sbp"]) == "ct_sbp") {
			$GLOBALS["t_sbp"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_sbp"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_sbp', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_sbplist.php"));
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
		$this->tipe->SetVisibility();
		$this->tipe_sbp->SetVisibility();
		$this->no_sbp->SetVisibility();
		$this->tgl_sbp->SetVisibility();
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();
		$this->uraian->SetVisibility();
		$this->nama_penerima->SetVisibility();
		$this->alamat_penerima->SetVisibility();
		$this->nama_pptk->SetVisibility();
		$this->nip_pptk->SetVisibility();
		$this->nama_pengguna->SetVisibility();
		$this->nip_pengguna_anggaran->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->pph21->SetVisibility();
		$this->pph22->SetVisibility();
		$this->pph23->SetVisibility();
		$this->pph4->SetVisibility();
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
		global $EW_EXPORT, $t_sbp;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_sbp);
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
			$this->Page_Terminate("t_sbplist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("t_sbplist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t_sbplist.php")
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
		if (!$this->tipe->FldIsDetailKey) {
			$this->tipe->setFormValue($objForm->GetValue("x_tipe"));
		}
		if (!$this->tipe_sbp->FldIsDetailKey) {
			$this->tipe_sbp->setFormValue($objForm->GetValue("x_tipe_sbp"));
		}
		if (!$this->no_sbp->FldIsDetailKey) {
			$this->no_sbp->setFormValue($objForm->GetValue("x_no_sbp"));
		}
		if (!$this->tgl_sbp->FldIsDetailKey) {
			$this->tgl_sbp->setFormValue($objForm->GetValue("x_tgl_sbp"));
			$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 7);
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
		if (!$this->uraian->FldIsDetailKey) {
			$this->uraian->setFormValue($objForm->GetValue("x_uraian"));
		}
		if (!$this->nama_penerima->FldIsDetailKey) {
			$this->nama_penerima->setFormValue($objForm->GetValue("x_nama_penerima"));
		}
		if (!$this->alamat_penerima->FldIsDetailKey) {
			$this->alamat_penerima->setFormValue($objForm->GetValue("x_alamat_penerima"));
		}
		if (!$this->nama_pptk->FldIsDetailKey) {
			$this->nama_pptk->setFormValue($objForm->GetValue("x_nama_pptk"));
		}
		if (!$this->nip_pptk->FldIsDetailKey) {
			$this->nip_pptk->setFormValue($objForm->GetValue("x_nip_pptk"));
		}
		if (!$this->nama_pengguna->FldIsDetailKey) {
			$this->nama_pengguna->setFormValue($objForm->GetValue("x_nama_pengguna"));
		}
		if (!$this->nip_pengguna_anggaran->FldIsDetailKey) {
			$this->nip_pengguna_anggaran->setFormValue($objForm->GetValue("x_nip_pengguna_anggaran"));
		}
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
		if (!$this->kode_rekening->FldIsDetailKey) {
			$this->kode_rekening->setFormValue($objForm->GetValue("x_kode_rekening"));
		}
		if (!$this->pph21->FldIsDetailKey) {
			$this->pph21->setFormValue($objForm->GetValue("x_pph21"));
		}
		if (!$this->pph22->FldIsDetailKey) {
			$this->pph22->setFormValue($objForm->GetValue("x_pph22"));
		}
		if (!$this->pph23->FldIsDetailKey) {
			$this->pph23->setFormValue($objForm->GetValue("x_pph23"));
		}
		if (!$this->pph4->FldIsDetailKey) {
			$this->pph4->setFormValue($objForm->GetValue("x_pph4"));
		}
		if (!$this->jumlah_belanja->FldIsDetailKey) {
			$this->jumlah_belanja->setFormValue($objForm->GetValue("x_jumlah_belanja"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->tipe->CurrentValue = $this->tipe->FormValue;
		$this->tipe_sbp->CurrentValue = $this->tipe_sbp->FormValue;
		$this->no_sbp->CurrentValue = $this->no_sbp->FormValue;
		$this->tgl_sbp->CurrentValue = $this->tgl_sbp->FormValue;
		$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 7);
		$this->program->CurrentValue = $this->program->FormValue;
		$this->kegiatan->CurrentValue = $this->kegiatan->FormValue;
		$this->sub_kegiatan->CurrentValue = $this->sub_kegiatan->FormValue;
		$this->uraian->CurrentValue = $this->uraian->FormValue;
		$this->nama_penerima->CurrentValue = $this->nama_penerima->FormValue;
		$this->alamat_penerima->CurrentValue = $this->alamat_penerima->FormValue;
		$this->nama_pptk->CurrentValue = $this->nama_pptk->FormValue;
		$this->nip_pptk->CurrentValue = $this->nip_pptk->FormValue;
		$this->nama_pengguna->CurrentValue = $this->nama_pengguna->FormValue;
		$this->nip_pengguna_anggaran->CurrentValue = $this->nip_pengguna_anggaran->FormValue;
		$this->akun1->CurrentValue = $this->akun1->FormValue;
		$this->akun2->CurrentValue = $this->akun2->FormValue;
		$this->akun3->CurrentValue = $this->akun3->FormValue;
		$this->akun4->CurrentValue = $this->akun4->FormValue;
		$this->akun5->CurrentValue = $this->akun5->FormValue;
		$this->kode_rekening->CurrentValue = $this->kode_rekening->FormValue;
		$this->pph21->CurrentValue = $this->pph21->FormValue;
		$this->pph22->CurrentValue = $this->pph22->FormValue;
		$this->pph23->CurrentValue = $this->pph23->FormValue;
		$this->pph4->CurrentValue = $this->pph4->FormValue;
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
		$this->tipe->setDbValue($rs->fields('tipe'));
		$this->tipe_sbp->setDbValue($rs->fields('tipe_sbp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->tgl_sbp->setDbValue($rs->fields('tgl_sbp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->nama_penerima->setDbValue($rs->fields('nama_penerima'));
		$this->alamat_penerima->setDbValue($rs->fields('alamat_penerima'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->nama_pengguna->setDbValue($rs->fields('nama_pengguna'));
		$this->nip_pengguna_anggaran->setDbValue($rs->fields('nip_pengguna_anggaran'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->pph21->setDbValue($rs->fields('pph21'));
		$this->pph22->setDbValue($rs->fields('pph22'));
		$this->pph23->setDbValue($rs->fields('pph23'));
		$this->pph4->setDbValue($rs->fields('pph4'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->tipe->DbValue = $row['tipe'];
		$this->tipe_sbp->DbValue = $row['tipe_sbp'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->tgl_sbp->DbValue = $row['tgl_sbp'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->uraian->DbValue = $row['uraian'];
		$this->nama_penerima->DbValue = $row['nama_penerima'];
		$this->alamat_penerima->DbValue = $row['alamat_penerima'];
		$this->nama_pptk->DbValue = $row['nama_pptk'];
		$this->nip_pptk->DbValue = $row['nip_pptk'];
		$this->nama_pengguna->DbValue = $row['nama_pengguna'];
		$this->nip_pengguna_anggaran->DbValue = $row['nip_pengguna_anggaran'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->pph21->DbValue = $row['pph21'];
		$this->pph22->DbValue = $row['pph22'];
		$this->pph23->DbValue = $row['pph23'];
		$this->pph4->DbValue = $row['pph4'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
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
		// tipe
		// tipe_sbp
		// no_sbp
		// tgl_sbp
		// program
		// kegiatan
		// sub_kegiatan
		// uraian
		// nama_penerima
		// alamat_penerima
		// nama_pptk
		// nip_pptk
		// nama_pengguna
		// nip_pengguna_anggaran
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5
		// kode_rekening
		// pph21
		// pph22
		// pph23
		// pph4
		// jumlah_belanja

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// tipe
		if (strval($this->tipe->CurrentValue) <> "") {
			$this->tipe->ViewValue = $this->tipe->OptionCaption($this->tipe->CurrentValue);
		} else {
			$this->tipe->ViewValue = NULL;
		}
		$this->tipe->ViewCustomAttributes = "";

		// tipe_sbp
		if (strval($this->tipe_sbp->CurrentValue) <> "") {
			$this->tipe_sbp->ViewValue = $this->tipe_sbp->OptionCaption($this->tipe_sbp->CurrentValue);
		} else {
			$this->tipe_sbp->ViewValue = NULL;
		}
		$this->tipe_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

		// tgl_sbp
		$this->tgl_sbp->ViewValue = $this->tgl_sbp->CurrentValue;
		$this->tgl_sbp->ViewValue = ew_FormatDateTime($this->tgl_sbp->ViewValue, 7);
		$this->tgl_sbp->ViewCustomAttributes = "";

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

		// uraian
		$this->uraian->ViewValue = $this->uraian->CurrentValue;
		$this->uraian->ViewCustomAttributes = "";

		// nama_penerima
		$this->nama_penerima->ViewValue = $this->nama_penerima->CurrentValue;
		$this->nama_penerima->ViewCustomAttributes = "";

		// alamat_penerima
		$this->alamat_penerima->ViewValue = $this->alamat_penerima->CurrentValue;
		$this->alamat_penerima->ViewCustomAttributes = "";

		// nama_pptk
		if (strval($this->nama_pptk->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_pptk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_pptk->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
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

		// nama_pengguna
		if (strval($this->nama_pengguna->CurrentValue) <> "") {
			$sFilterWrk = "`direktur`" . ew_SearchString("=", $this->nama_pengguna->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `direktur`, `direktur` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_blud_rs`";
		$sWhereWrk = "";
		$this->nama_pengguna->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_pengguna, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_pengguna->ViewValue = $this->nama_pengguna->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_pengguna->ViewValue = $this->nama_pengguna->CurrentValue;
			}
		} else {
			$this->nama_pengguna->ViewValue = NULL;
		}
		$this->nama_pengguna->ViewCustomAttributes = "";

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->ViewValue = $this->nip_pengguna_anggaran->CurrentValue;
		$this->nip_pengguna_anggaran->ViewCustomAttributes = "";

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

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// pph21
		$this->pph21->ViewValue = $this->pph21->CurrentValue;
		$this->pph21->ViewCustomAttributes = "";

		// pph22
		$this->pph22->ViewValue = $this->pph22->CurrentValue;
		$this->pph22->ViewCustomAttributes = "";

		// pph23
		$this->pph23->ViewValue = $this->pph23->CurrentValue;
		$this->pph23->ViewCustomAttributes = "";

		// pph4
		$this->pph4->ViewValue = $this->pph4->CurrentValue;
		$this->pph4->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// tipe
			$this->tipe->LinkCustomAttributes = "";
			$this->tipe->HrefValue = "";
			$this->tipe->TooltipValue = "";

			// tipe_sbp
			$this->tipe_sbp->LinkCustomAttributes = "";
			$this->tipe_sbp->HrefValue = "";
			$this->tipe_sbp->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";
			$this->tgl_sbp->TooltipValue = "";

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

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";
			$this->uraian->TooltipValue = "";

			// nama_penerima
			$this->nama_penerima->LinkCustomAttributes = "";
			$this->nama_penerima->HrefValue = "";
			$this->nama_penerima->TooltipValue = "";

			// alamat_penerima
			$this->alamat_penerima->LinkCustomAttributes = "";
			$this->alamat_penerima->HrefValue = "";
			$this->alamat_penerima->TooltipValue = "";

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";
			$this->nama_pptk->TooltipValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";
			$this->nip_pptk->TooltipValue = "";

			// nama_pengguna
			$this->nama_pengguna->LinkCustomAttributes = "";
			$this->nama_pengguna->HrefValue = "";
			$this->nama_pengguna->TooltipValue = "";

			// nip_pengguna_anggaran
			$this->nip_pengguna_anggaran->LinkCustomAttributes = "";
			$this->nip_pengguna_anggaran->HrefValue = "";
			$this->nip_pengguna_anggaran->TooltipValue = "";

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

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

			// pph21
			$this->pph21->LinkCustomAttributes = "";
			$this->pph21->HrefValue = "";
			$this->pph21->TooltipValue = "";

			// pph22
			$this->pph22->LinkCustomAttributes = "";
			$this->pph22->HrefValue = "";
			$this->pph22->TooltipValue = "";

			// pph23
			$this->pph23->LinkCustomAttributes = "";
			$this->pph23->HrefValue = "";
			$this->pph23->TooltipValue = "";

			// pph4
			$this->pph4->LinkCustomAttributes = "";
			$this->pph4->HrefValue = "";
			$this->pph4->TooltipValue = "";

			// jumlah_belanja
			$this->jumlah_belanja->LinkCustomAttributes = "";
			$this->jumlah_belanja->HrefValue = "";
			$this->jumlah_belanja->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// tipe
			$this->tipe->EditAttrs["class"] = "form-control";
			$this->tipe->EditCustomAttributes = "";
			$this->tipe->EditValue = $this->tipe->Options(TRUE);

			// tipe_sbp
			$this->tipe_sbp->EditAttrs["class"] = "form-control";
			$this->tipe_sbp->EditCustomAttributes = "";
			$this->tipe_sbp->EditValue = $this->tipe_sbp->Options(TRUE);

			// no_sbp
			$this->no_sbp->EditAttrs["class"] = "form-control";
			$this->no_sbp->EditCustomAttributes = "";
			$this->no_sbp->EditValue = ew_HtmlEncode($this->no_sbp->CurrentValue);
			$this->no_sbp->PlaceHolder = ew_RemoveHtml($this->no_sbp->FldCaption());

			// tgl_sbp
			$this->tgl_sbp->EditAttrs["class"] = "form-control";
			$this->tgl_sbp->EditCustomAttributes = "";
			$this->tgl_sbp->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sbp->CurrentValue, 7));
			$this->tgl_sbp->PlaceHolder = ew_RemoveHtml($this->tgl_sbp->FldCaption());

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

			// uraian
			$this->uraian->EditAttrs["class"] = "form-control";
			$this->uraian->EditCustomAttributes = "";
			$this->uraian->EditValue = ew_HtmlEncode($this->uraian->CurrentValue);
			$this->uraian->PlaceHolder = ew_RemoveHtml($this->uraian->FldCaption());

			// nama_penerima
			$this->nama_penerima->EditAttrs["class"] = "form-control";
			$this->nama_penerima->EditCustomAttributes = "";
			$this->nama_penerima->EditValue = ew_HtmlEncode($this->nama_penerima->CurrentValue);
			$this->nama_penerima->PlaceHolder = ew_RemoveHtml($this->nama_penerima->FldCaption());

			// alamat_penerima
			$this->alamat_penerima->EditAttrs["class"] = "form-control";
			$this->alamat_penerima->EditCustomAttributes = "";
			$this->alamat_penerima->EditValue = ew_HtmlEncode($this->alamat_penerima->CurrentValue);
			$this->alamat_penerima->PlaceHolder = ew_RemoveHtml($this->alamat_penerima->FldCaption());

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
			$lookuptblfilter = "`id`=2";
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

			// nama_pengguna
			$this->nama_pengguna->EditAttrs["class"] = "form-control";
			$this->nama_pengguna->EditCustomAttributes = "";
			if (trim(strval($this->nama_pengguna->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`direktur`" . ew_SearchString("=", $this->nama_pengguna->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `direktur`, `direktur` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_blud_rs`";
			$sWhereWrk = "";
			$this->nama_pengguna->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nama_pengguna, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->nama_pengguna->EditValue = $arwrk;

			// nip_pengguna_anggaran
			$this->nip_pengguna_anggaran->EditAttrs["class"] = "form-control";
			$this->nip_pengguna_anggaran->EditCustomAttributes = "";
			$this->nip_pengguna_anggaran->EditValue = ew_HtmlEncode($this->nip_pengguna_anggaran->CurrentValue);
			$this->nip_pengguna_anggaran->PlaceHolder = ew_RemoveHtml($this->nip_pengguna_anggaran->FldCaption());

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

			// kode_rekening
			$this->kode_rekening->EditAttrs["class"] = "form-control";
			$this->kode_rekening->EditCustomAttributes = "";
			$this->kode_rekening->EditValue = ew_HtmlEncode($this->kode_rekening->CurrentValue);
			$this->kode_rekening->PlaceHolder = ew_RemoveHtml($this->kode_rekening->FldCaption());

			// pph21
			$this->pph21->EditAttrs["class"] = "form-control";
			$this->pph21->EditCustomAttributes = "";
			$this->pph21->EditValue = ew_HtmlEncode($this->pph21->CurrentValue);
			$this->pph21->PlaceHolder = ew_RemoveHtml($this->pph21->FldCaption());

			// pph22
			$this->pph22->EditAttrs["class"] = "form-control";
			$this->pph22->EditCustomAttributes = "";
			$this->pph22->EditValue = ew_HtmlEncode($this->pph22->CurrentValue);
			$this->pph22->PlaceHolder = ew_RemoveHtml($this->pph22->FldCaption());

			// pph23
			$this->pph23->EditAttrs["class"] = "form-control";
			$this->pph23->EditCustomAttributes = "";
			$this->pph23->EditValue = ew_HtmlEncode($this->pph23->CurrentValue);
			$this->pph23->PlaceHolder = ew_RemoveHtml($this->pph23->FldCaption());

			// pph4
			$this->pph4->EditAttrs["class"] = "form-control";
			$this->pph4->EditCustomAttributes = "";
			$this->pph4->EditValue = ew_HtmlEncode($this->pph4->CurrentValue);
			$this->pph4->PlaceHolder = ew_RemoveHtml($this->pph4->FldCaption());

			// jumlah_belanja
			$this->jumlah_belanja->EditAttrs["class"] = "form-control";
			$this->jumlah_belanja->EditCustomAttributes = "";
			$this->jumlah_belanja->EditValue = ew_HtmlEncode($this->jumlah_belanja->CurrentValue);
			$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
			if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// tipe
			$this->tipe->LinkCustomAttributes = "";
			$this->tipe->HrefValue = "";

			// tipe_sbp
			$this->tipe_sbp->LinkCustomAttributes = "";
			$this->tipe_sbp->HrefValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";

			// nama_penerima
			$this->nama_penerima->LinkCustomAttributes = "";
			$this->nama_penerima->HrefValue = "";

			// alamat_penerima
			$this->alamat_penerima->LinkCustomAttributes = "";
			$this->alamat_penerima->HrefValue = "";

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";

			// nama_pengguna
			$this->nama_pengguna->LinkCustomAttributes = "";
			$this->nama_pengguna->HrefValue = "";

			// nip_pengguna_anggaran
			$this->nip_pengguna_anggaran->LinkCustomAttributes = "";
			$this->nip_pengguna_anggaran->HrefValue = "";

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

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";

			// pph21
			$this->pph21->LinkCustomAttributes = "";
			$this->pph21->HrefValue = "";

			// pph22
			$this->pph22->LinkCustomAttributes = "";
			$this->pph22->HrefValue = "";

			// pph23
			$this->pph23->LinkCustomAttributes = "";
			$this->pph23->HrefValue = "";

			// pph4
			$this->pph4->LinkCustomAttributes = "";
			$this->pph4->HrefValue = "";

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
		if (!ew_CheckEuroDate($this->tgl_sbp->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_sbp->FldErrMsg());
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

			// tipe
			$this->tipe->SetDbValueDef($rsnew, $this->tipe->CurrentValue, NULL, $this->tipe->ReadOnly);

			// tipe_sbp
			$this->tipe_sbp->SetDbValueDef($rsnew, $this->tipe_sbp->CurrentValue, NULL, $this->tipe_sbp->ReadOnly);

			// no_sbp
			$this->no_sbp->SetDbValueDef($rsnew, $this->no_sbp->CurrentValue, NULL, $this->no_sbp->ReadOnly);

			// tgl_sbp
			$this->tgl_sbp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 7), NULL, $this->tgl_sbp->ReadOnly);

			// program
			$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, $this->program->ReadOnly);

			// kegiatan
			$this->kegiatan->SetDbValueDef($rsnew, $this->kegiatan->CurrentValue, NULL, $this->kegiatan->ReadOnly);

			// sub_kegiatan
			$this->sub_kegiatan->SetDbValueDef($rsnew, $this->sub_kegiatan->CurrentValue, NULL, $this->sub_kegiatan->ReadOnly);

			// uraian
			$this->uraian->SetDbValueDef($rsnew, $this->uraian->CurrentValue, NULL, $this->uraian->ReadOnly);

			// nama_penerima
			$this->nama_penerima->SetDbValueDef($rsnew, $this->nama_penerima->CurrentValue, NULL, $this->nama_penerima->ReadOnly);

			// alamat_penerima
			$this->alamat_penerima->SetDbValueDef($rsnew, $this->alamat_penerima->CurrentValue, NULL, $this->alamat_penerima->ReadOnly);

			// nama_pptk
			$this->nama_pptk->SetDbValueDef($rsnew, $this->nama_pptk->CurrentValue, NULL, $this->nama_pptk->ReadOnly);

			// nip_pptk
			$this->nip_pptk->SetDbValueDef($rsnew, $this->nip_pptk->CurrentValue, NULL, $this->nip_pptk->ReadOnly);

			// nama_pengguna
			$this->nama_pengguna->SetDbValueDef($rsnew, $this->nama_pengguna->CurrentValue, NULL, $this->nama_pengguna->ReadOnly);

			// nip_pengguna_anggaran
			$this->nip_pengguna_anggaran->SetDbValueDef($rsnew, $this->nip_pengguna_anggaran->CurrentValue, NULL, $this->nip_pengguna_anggaran->ReadOnly);

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

			// kode_rekening
			$this->kode_rekening->SetDbValueDef($rsnew, $this->kode_rekening->CurrentValue, NULL, $this->kode_rekening->ReadOnly);

			// pph21
			$this->pph21->SetDbValueDef($rsnew, $this->pph21->CurrentValue, NULL, $this->pph21->ReadOnly);

			// pph22
			$this->pph22->SetDbValueDef($rsnew, $this->pph22->CurrentValue, NULL, $this->pph22->ReadOnly);

			// pph23
			$this->pph23->SetDbValueDef($rsnew, $this->pph23->CurrentValue, NULL, $this->pph23->ReadOnly);

			// pph4
			$this->pph4->SetDbValueDef($rsnew, $this->pph4->CurrentValue, NULL, $this->pph4->ReadOnly);

			// jumlah_belanja
			$this->jumlah_belanja->SetDbValueDef($rsnew, $this->jumlah_belanja->CurrentValue, NULL, $this->jumlah_belanja->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_sbplist.php"), "", $this->TableVar, TRUE);
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
		case "x_nama_pptk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nama` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_pptk->LookupFilters = array();
			$lookuptblfilter = "`id`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nama_pengguna":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `direktur` AS `LinkFld`, `direktur` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_blud_rs`";
			$sWhereWrk = "";
			$this->nama_pengguna->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`direktur` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_pengguna, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($t_sbp_edit)) $t_sbp_edit = new ct_sbp_edit();

// Page init
$t_sbp_edit->Page_Init();

// Page main
$t_sbp_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sbp_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft_sbpedit = new ew_Form("ft_sbpedit", "edit");

// Validate form
ft_sbpedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_sbp");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sbp->tgl_sbp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sbp->jumlah_belanja->FldErrMsg()) ?>");

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
ft_sbpedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sbpedit.ValidateRequired = true;
<?php } else { ?>
ft_sbpedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sbpedit.Lists["x_tipe"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sbpedit.Lists["x_tipe"].Options = <?php echo json_encode($t_sbp->tipe->Options()) ?>;
ft_sbpedit.Lists["x_tipe_sbp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sbpedit.Lists["x_tipe_sbp"].Options = <?php echo json_encode($t_sbp->tipe_sbp->Options()) ?>;
ft_sbpedit.Lists["x_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
ft_sbpedit.Lists["x_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_program"],"ChildFields":["x_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
ft_sbpedit.Lists["x_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_kegiatan"],"ChildFields":[],"FilterFields":["x_kode_kegiatan"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};
ft_sbpedit.Lists["x_nama_pptk"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
ft_sbpedit.Lists["x_nama_pengguna"] = {"LinkField":"x_direktur","Ajax":true,"AutoFill":true,"DisplayFields":["x_direktur","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_blud_rs"};
ft_sbpedit.Lists["x_akun1"] = {"LinkField":"x_kel1","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel1","","",""],"ParentFields":[],"ChildFields":["x_akun2","x_akun3","x_akun4","x_akun5"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun1"};
ft_sbpedit.Lists["x_akun2"] = {"LinkField":"x_kel2","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel2","","",""],"ParentFields":["x_akun1"],"ChildFields":["x_akun3","x_akun4","x_akun5"],"FilterFields":["x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun2"};
ft_sbpedit.Lists["x_akun3"] = {"LinkField":"x_kel3","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel3","","",""],"ParentFields":["x_akun2","x_akun1"],"ChildFields":["x_akun4","x_akun5"],"FilterFields":["x_kel2","x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun3"};
ft_sbpedit.Lists["x_akun4"] = {"LinkField":"x_kel4","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel4","","",""],"ParentFields":["x_akun3","x_akun2","x_akun1"],"ChildFields":["x_akun5"],"FilterFields":["x_kel3","x_kel2","x_kel1"],"Options":[],"Template":"","LinkTable":"keu_akun4"};
ft_sbpedit.Lists["x_akun5"] = {"LinkField":"x_akun5","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_akun","","",""],"ParentFields":["x_akun4","x_akun3","x_akun2","x_akun1"],"ChildFields":[],"FilterFields":["x_akun4","x_akun3","x_akun2","x_akun1"],"Options":[],"Template":"","LinkTable":"keu_akun5"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_sbp_edit->IsModal) { ?>
<?php } ?>
<?php $t_sbp_edit->ShowPageHeader(); ?>
<?php
$t_sbp_edit->ShowMessage();
?>
<form name="ft_sbpedit" id="ft_sbpedit" class="<?php echo $t_sbp_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_sbp_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_sbp_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_sbp">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t_sbp_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_sbp->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_t_sbp_id" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->id->CellAttributes() ?>>
<div id="orig_t_sbp_id" class="hide">
<span id="el_t_sbp_id">
<span<?php echo $t_sbp->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $t_sbp->id->EditValue ?></p></span>
</span>
</div>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_spm_up.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">
CETAKSURATBUKTIPENGELUARAN <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
</div>
<input type="hidden" data-table="t_sbp" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($t_sbp->id->CurrentValue) ?>">
<?php echo $t_sbp->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->tipe->Visible) { // tipe ?>
	<div id="r_tipe" class="form-group">
		<label id="elh_t_sbp_tipe" for="x_tipe" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->tipe->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->tipe->CellAttributes() ?>>
<span id="el_t_sbp_tipe">
<select data-table="t_sbp" data-field="x_tipe" data-value-separator="<?php echo $t_sbp->tipe->DisplayValueSeparatorAttribute() ?>" id="x_tipe" name="x_tipe"<?php echo $t_sbp->tipe->EditAttributes() ?>>
<?php echo $t_sbp->tipe->SelectOptionListHtml("x_tipe") ?>
</select>
</span>
<?php echo $t_sbp->tipe->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->tipe_sbp->Visible) { // tipe_sbp ?>
	<div id="r_tipe_sbp" class="form-group">
		<label id="elh_t_sbp_tipe_sbp" for="x_tipe_sbp" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->tipe_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->tipe_sbp->CellAttributes() ?>>
<span id="el_t_sbp_tipe_sbp">
<select data-table="t_sbp" data-field="x_tipe_sbp" data-value-separator="<?php echo $t_sbp->tipe_sbp->DisplayValueSeparatorAttribute() ?>" id="x_tipe_sbp" name="x_tipe_sbp"<?php echo $t_sbp->tipe_sbp->EditAttributes() ?>>
<?php echo $t_sbp->tipe_sbp->SelectOptionListHtml("x_tipe_sbp") ?>
</select>
</span>
<?php echo $t_sbp->tipe_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->no_sbp->Visible) { // no_sbp ?>
	<div id="r_no_sbp" class="form-group">
		<label id="elh_t_sbp_no_sbp" for="x_no_sbp" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->no_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->no_sbp->CellAttributes() ?>>
<span id="el_t_sbp_no_sbp">
<input type="text" data-table="t_sbp" data-field="x_no_sbp" name="x_no_sbp" id="x_no_sbp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->no_sbp->getPlaceHolder()) ?>" value="<?php echo $t_sbp->no_sbp->EditValue ?>"<?php echo $t_sbp->no_sbp->EditAttributes() ?>>
</span>
<?php echo $t_sbp->no_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->tgl_sbp->Visible) { // tgl_sbp ?>
	<div id="r_tgl_sbp" class="form-group">
		<label id="elh_t_sbp_tgl_sbp" for="x_tgl_sbp" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->tgl_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->tgl_sbp->CellAttributes() ?>>
<span id="el_t_sbp_tgl_sbp">
<input type="text" data-table="t_sbp" data-field="x_tgl_sbp" data-format="7" name="x_tgl_sbp" id="x_tgl_sbp" placeholder="<?php echo ew_HtmlEncode($t_sbp->tgl_sbp->getPlaceHolder()) ?>" value="<?php echo $t_sbp->tgl_sbp->EditValue ?>"<?php echo $t_sbp->tgl_sbp->EditAttributes() ?>>
<?php if (!$t_sbp->tgl_sbp->ReadOnly && !$t_sbp->tgl_sbp->Disabled && !isset($t_sbp->tgl_sbp->EditAttrs["readonly"]) && !isset($t_sbp->tgl_sbp->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_sbpedit", "x_tgl_sbp", 7);
</script>
<?php } ?>
</span>
<?php echo $t_sbp->tgl_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_t_sbp_program" for="x_program" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->program->CellAttributes() ?>>
<span id="el_t_sbp_program">
<?php $t_sbp->program->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->program->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_program" data-value-separator="<?php echo $t_sbp->program->DisplayValueSeparatorAttribute() ?>" id="x_program" name="x_program"<?php echo $t_sbp->program->EditAttributes() ?>>
<?php echo $t_sbp->program->SelectOptionListHtml("x_program") ?>
</select>
<input type="hidden" name="s_x_program" id="s_x_program" value="<?php echo $t_sbp->program->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->kegiatan->Visible) { // kegiatan ?>
	<div id="r_kegiatan" class="form-group">
		<label id="elh_t_sbp_kegiatan" for="x_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->kegiatan->CellAttributes() ?>>
<span id="el_t_sbp_kegiatan">
<?php $t_sbp->kegiatan->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->kegiatan->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_kegiatan" data-value-separator="<?php echo $t_sbp->kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kegiatan" name="x_kegiatan"<?php echo $t_sbp->kegiatan->EditAttributes() ?>>
<?php echo $t_sbp->kegiatan->SelectOptionListHtml("x_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kegiatan" id="s_x_kegiatan" value="<?php echo $t_sbp->kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<div id="r_sub_kegiatan" class="form-group">
		<label id="elh_t_sbp_sub_kegiatan" for="x_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->sub_kegiatan->CellAttributes() ?>>
<span id="el_t_sbp_sub_kegiatan">
<select data-table="t_sbp" data-field="x_sub_kegiatan" data-value-separator="<?php echo $t_sbp->sub_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_sub_kegiatan" name="x_sub_kegiatan"<?php echo $t_sbp->sub_kegiatan->EditAttributes() ?>>
<?php echo $t_sbp->sub_kegiatan->SelectOptionListHtml("x_sub_kegiatan") ?>
</select>
<input type="hidden" name="s_x_sub_kegiatan" id="s_x_sub_kegiatan" value="<?php echo $t_sbp->sub_kegiatan->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->uraian->Visible) { // uraian ?>
	<div id="r_uraian" class="form-group">
		<label id="elh_t_sbp_uraian" for="x_uraian" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->uraian->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->uraian->CellAttributes() ?>>
<span id="el_t_sbp_uraian">
<input type="text" data-table="t_sbp" data-field="x_uraian" name="x_uraian" id="x_uraian" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->uraian->getPlaceHolder()) ?>" value="<?php echo $t_sbp->uraian->EditValue ?>"<?php echo $t_sbp->uraian->EditAttributes() ?>>
</span>
<?php echo $t_sbp->uraian->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nama_penerima->Visible) { // nama_penerima ?>
	<div id="r_nama_penerima" class="form-group">
		<label id="elh_t_sbp_nama_penerima" for="x_nama_penerima" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->nama_penerima->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nama_penerima->CellAttributes() ?>>
<span id="el_t_sbp_nama_penerima">
<input type="text" data-table="t_sbp" data-field="x_nama_penerima" name="x_nama_penerima" id="x_nama_penerima" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->nama_penerima->getPlaceHolder()) ?>" value="<?php echo $t_sbp->nama_penerima->EditValue ?>"<?php echo $t_sbp->nama_penerima->EditAttributes() ?>>
</span>
<?php echo $t_sbp->nama_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->alamat_penerima->Visible) { // alamat_penerima ?>
	<div id="r_alamat_penerima" class="form-group">
		<label id="elh_t_sbp_alamat_penerima" for="x_alamat_penerima" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->alamat_penerima->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->alamat_penerima->CellAttributes() ?>>
<span id="el_t_sbp_alamat_penerima">
<input type="text" data-table="t_sbp" data-field="x_alamat_penerima" name="x_alamat_penerima" id="x_alamat_penerima" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->alamat_penerima->getPlaceHolder()) ?>" value="<?php echo $t_sbp->alamat_penerima->EditValue ?>"<?php echo $t_sbp->alamat_penerima->EditAttributes() ?>>
</span>
<?php echo $t_sbp->alamat_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nama_pptk->Visible) { // nama_pptk ?>
	<div id="r_nama_pptk" class="form-group">
		<label id="elh_t_sbp_nama_pptk" for="x_nama_pptk" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->nama_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nama_pptk->CellAttributes() ?>>
<span id="el_t_sbp_nama_pptk">
<?php $t_sbp->nama_pptk->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$t_sbp->nama_pptk->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_nama_pptk" data-value-separator="<?php echo $t_sbp->nama_pptk->DisplayValueSeparatorAttribute() ?>" id="x_nama_pptk" name="x_nama_pptk"<?php echo $t_sbp->nama_pptk->EditAttributes() ?>>
<?php echo $t_sbp->nama_pptk->SelectOptionListHtml("x_nama_pptk") ?>
</select>
<input type="hidden" name="s_x_nama_pptk" id="s_x_nama_pptk" value="<?php echo $t_sbp->nama_pptk->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_pptk" id="ln_x_nama_pptk" value="x_nip_pptk">
</span>
<?php echo $t_sbp->nama_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nip_pptk->Visible) { // nip_pptk ?>
	<div id="r_nip_pptk" class="form-group">
		<label id="elh_t_sbp_nip_pptk" for="x_nip_pptk" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->nip_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nip_pptk->CellAttributes() ?>>
<span id="el_t_sbp_nip_pptk">
<input type="text" data-table="t_sbp" data-field="x_nip_pptk" name="x_nip_pptk" id="x_nip_pptk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->nip_pptk->getPlaceHolder()) ?>" value="<?php echo $t_sbp->nip_pptk->EditValue ?>"<?php echo $t_sbp->nip_pptk->EditAttributes() ?>>
</span>
<?php echo $t_sbp->nip_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nama_pengguna->Visible) { // nama_pengguna ?>
	<div id="r_nama_pengguna" class="form-group">
		<label id="elh_t_sbp_nama_pengguna" for="x_nama_pengguna" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->nama_pengguna->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nama_pengguna->CellAttributes() ?>>
<span id="el_t_sbp_nama_pengguna">
<?php $t_sbp->nama_pengguna->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$t_sbp->nama_pengguna->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_nama_pengguna" data-value-separator="<?php echo $t_sbp->nama_pengguna->DisplayValueSeparatorAttribute() ?>" id="x_nama_pengguna" name="x_nama_pengguna"<?php echo $t_sbp->nama_pengguna->EditAttributes() ?>>
<?php echo $t_sbp->nama_pengguna->SelectOptionListHtml("x_nama_pengguna") ?>
</select>
<input type="hidden" name="s_x_nama_pengguna" id="s_x_nama_pengguna" value="<?php echo $t_sbp->nama_pengguna->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_pengguna" id="ln_x_nama_pengguna" value="x_nip_pengguna_anggaran">
</span>
<?php echo $t_sbp->nama_pengguna->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nip_pengguna_anggaran->Visible) { // nip_pengguna_anggaran ?>
	<div id="r_nip_pengguna_anggaran" class="form-group">
		<label id="elh_t_sbp_nip_pengguna_anggaran" for="x_nip_pengguna_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->nip_pengguna_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nip_pengguna_anggaran->CellAttributes() ?>>
<span id="el_t_sbp_nip_pengguna_anggaran">
<input type="text" data-table="t_sbp" data-field="x_nip_pengguna_anggaran" name="x_nip_pengguna_anggaran" id="x_nip_pengguna_anggaran" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->nip_pengguna_anggaran->getPlaceHolder()) ?>" value="<?php echo $t_sbp->nip_pengguna_anggaran->EditValue ?>"<?php echo $t_sbp->nip_pengguna_anggaran->EditAttributes() ?>>
</span>
<?php echo $t_sbp->nip_pengguna_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->akun1->Visible) { // akun1 ?>
	<div id="r_akun1" class="form-group">
		<label id="elh_t_sbp_akun1" for="x_akun1" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->akun1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->akun1->CellAttributes() ?>>
<span id="el_t_sbp_akun1">
<?php $t_sbp->akun1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->akun1->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_akun1" data-value-separator="<?php echo $t_sbp->akun1->DisplayValueSeparatorAttribute() ?>" id="x_akun1" name="x_akun1"<?php echo $t_sbp->akun1->EditAttributes() ?>>
<?php echo $t_sbp->akun1->SelectOptionListHtml("x_akun1") ?>
</select>
<input type="hidden" name="s_x_akun1" id="s_x_akun1" value="<?php echo $t_sbp->akun1->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->akun2->Visible) { // akun2 ?>
	<div id="r_akun2" class="form-group">
		<label id="elh_t_sbp_akun2" for="x_akun2" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->akun2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->akun2->CellAttributes() ?>>
<span id="el_t_sbp_akun2">
<?php $t_sbp->akun2->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->akun2->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_akun2" data-value-separator="<?php echo $t_sbp->akun2->DisplayValueSeparatorAttribute() ?>" id="x_akun2" name="x_akun2"<?php echo $t_sbp->akun2->EditAttributes() ?>>
<?php echo $t_sbp->akun2->SelectOptionListHtml("x_akun2") ?>
</select>
<input type="hidden" name="s_x_akun2" id="s_x_akun2" value="<?php echo $t_sbp->akun2->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->akun2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->akun3->Visible) { // akun3 ?>
	<div id="r_akun3" class="form-group">
		<label id="elh_t_sbp_akun3" for="x_akun3" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->akun3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->akun3->CellAttributes() ?>>
<span id="el_t_sbp_akun3">
<?php $t_sbp->akun3->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->akun3->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_akun3" data-value-separator="<?php echo $t_sbp->akun3->DisplayValueSeparatorAttribute() ?>" id="x_akun3" name="x_akun3"<?php echo $t_sbp->akun3->EditAttributes() ?>>
<?php echo $t_sbp->akun3->SelectOptionListHtml("x_akun3") ?>
</select>
<input type="hidden" name="s_x_akun3" id="s_x_akun3" value="<?php echo $t_sbp->akun3->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->akun3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->akun4->Visible) { // akun4 ?>
	<div id="r_akun4" class="form-group">
		<label id="elh_t_sbp_akun4" for="x_akun4" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->akun4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->akun4->CellAttributes() ?>>
<span id="el_t_sbp_akun4">
<?php $t_sbp->akun4->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->akun4->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_akun4" data-value-separator="<?php echo $t_sbp->akun4->DisplayValueSeparatorAttribute() ?>" id="x_akun4" name="x_akun4"<?php echo $t_sbp->akun4->EditAttributes() ?>>
<?php echo $t_sbp->akun4->SelectOptionListHtml("x_akun4") ?>
</select>
<input type="hidden" name="s_x_akun4" id="s_x_akun4" value="<?php echo $t_sbp->akun4->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->akun5->Visible) { // akun5 ?>
	<div id="r_akun5" class="form-group">
		<label id="elh_t_sbp_akun5" for="x_akun5" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->akun5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->akun5->CellAttributes() ?>>
<span id="el_t_sbp_akun5">
<select data-table="t_sbp" data-field="x_akun5" data-value-separator="<?php echo $t_sbp->akun5->DisplayValueSeparatorAttribute() ?>" id="x_akun5" name="x_akun5"<?php echo $t_sbp->akun5->EditAttributes() ?>>
<?php echo $t_sbp->akun5->SelectOptionListHtml("x_akun5") ?>
</select>
<input type="hidden" name="s_x_akun5" id="s_x_akun5" value="<?php echo $t_sbp->akun5->LookupFilterQuery() ?>">
</span>
<?php echo $t_sbp->akun5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->kode_rekening->Visible) { // kode_rekening ?>
	<div id="r_kode_rekening" class="form-group">
		<label id="elh_t_sbp_kode_rekening" for="x_kode_rekening" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->kode_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->kode_rekening->CellAttributes() ?>>
<span id="el_t_sbp_kode_rekening">
<input type="text" data-table="t_sbp" data-field="x_kode_rekening" name="x_kode_rekening" id="x_kode_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->kode_rekening->getPlaceHolder()) ?>" value="<?php echo $t_sbp->kode_rekening->EditValue ?>"<?php echo $t_sbp->kode_rekening->EditAttributes() ?>>
</span>
<?php echo $t_sbp->kode_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->pph21->Visible) { // pph21 ?>
	<div id="r_pph21" class="form-group">
		<label id="elh_t_sbp_pph21" for="x_pph21" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->pph21->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->pph21->CellAttributes() ?>>
<span id="el_t_sbp_pph21">
<input type="text" data-table="t_sbp" data-field="x_pph21" name="x_pph21" id="x_pph21" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->pph21->getPlaceHolder()) ?>" value="<?php echo $t_sbp->pph21->EditValue ?>"<?php echo $t_sbp->pph21->EditAttributes() ?>>
</span>
<?php echo $t_sbp->pph21->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->pph22->Visible) { // pph22 ?>
	<div id="r_pph22" class="form-group">
		<label id="elh_t_sbp_pph22" for="x_pph22" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->pph22->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->pph22->CellAttributes() ?>>
<span id="el_t_sbp_pph22">
<input type="text" data-table="t_sbp" data-field="x_pph22" name="x_pph22" id="x_pph22" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->pph22->getPlaceHolder()) ?>" value="<?php echo $t_sbp->pph22->EditValue ?>"<?php echo $t_sbp->pph22->EditAttributes() ?>>
</span>
<?php echo $t_sbp->pph22->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->pph23->Visible) { // pph23 ?>
	<div id="r_pph23" class="form-group">
		<label id="elh_t_sbp_pph23" for="x_pph23" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->pph23->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->pph23->CellAttributes() ?>>
<span id="el_t_sbp_pph23">
<input type="text" data-table="t_sbp" data-field="x_pph23" name="x_pph23" id="x_pph23" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->pph23->getPlaceHolder()) ?>" value="<?php echo $t_sbp->pph23->EditValue ?>"<?php echo $t_sbp->pph23->EditAttributes() ?>>
</span>
<?php echo $t_sbp->pph23->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->pph4->Visible) { // pph4 ?>
	<div id="r_pph4" class="form-group">
		<label id="elh_t_sbp_pph4" for="x_pph4" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->pph4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->pph4->CellAttributes() ?>>
<span id="el_t_sbp_pph4">
<input type="text" data-table="t_sbp" data-field="x_pph4" name="x_pph4" id="x_pph4" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->pph4->getPlaceHolder()) ?>" value="<?php echo $t_sbp->pph4->EditValue ?>"<?php echo $t_sbp->pph4->EditAttributes() ?>>
</span>
<?php echo $t_sbp->pph4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<div id="r_jumlah_belanja" class="form-group">
		<label id="elh_t_sbp_jumlah_belanja" for="x_jumlah_belanja" class="col-sm-2 control-label ewLabel"><?php echo $t_sbp->jumlah_belanja->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->jumlah_belanja->CellAttributes() ?>>
<span id="el_t_sbp_jumlah_belanja">
<input type="text" data-table="t_sbp" data-field="x_jumlah_belanja" name="x_jumlah_belanja" id="x_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($t_sbp->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $t_sbp->jumlah_belanja->EditValue ?>"<?php echo $t_sbp->jumlah_belanja->EditAttributes() ?>>
</span>
<?php echo $t_sbp->jumlah_belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_sbp_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_sbp_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_sbpedit.Init();
</script>
<?php
$t_sbp_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_sbp_edit->Page_Terminate();
?>
