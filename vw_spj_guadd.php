<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spj_guinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spj_gu_add = NULL; // Initialize page object first

class cvw_spj_gu_add extends cvw_spj_gu {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spj_gu';

	// Page object name
	var $PageObjName = 'vw_spj_gu_add';

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

		// Table object (vw_spj_gu)
		if (!isset($GLOBALS["vw_spj_gu"]) || get_class($GLOBALS["vw_spj_gu"]) == "cvw_spj_gu") {
			$GLOBALS["vw_spj_gu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spj_gu"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spj_gu', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spj_gulist.php"));
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
		$this->no_spj->SetVisibility();
		$this->tgl_spj->SetVisibility();
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->tipe->SetVisibility();
		$this->tipe_sbp->SetVisibility();
		$this->no_sbp->SetVisibility();
		$this->tgl_sbp->SetVisibility();
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
		global $EW_EXPORT, $vw_spj_gu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spj_gu);
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
					$this->Page_Terminate("vw_spj_gulist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_spj_gulist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_spj_guview.php")
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
		$this->no_spj->CurrentValue = NULL;
		$this->no_spj->OldValue = $this->no_spj->CurrentValue;
		$this->tgl_spj->CurrentValue = date("d/m/Y");
		$this->program->CurrentValue = NULL;
		$this->program->OldValue = $this->program->CurrentValue;
		$this->kegiatan->CurrentValue = NULL;
		$this->kegiatan->OldValue = $this->kegiatan->CurrentValue;
		$this->tipe->CurrentValue = NULL;
		$this->tipe->OldValue = $this->tipe->CurrentValue;
		$this->tipe_sbp->CurrentValue = NULL;
		$this->tipe_sbp->OldValue = $this->tipe_sbp->CurrentValue;
		$this->no_sbp->CurrentValue = NULL;
		$this->no_sbp->OldValue = $this->no_sbp->CurrentValue;
		$this->tgl_sbp->CurrentValue = NULL;
		$this->tgl_sbp->OldValue = $this->tgl_sbp->CurrentValue;
		$this->sub_kegiatan->CurrentValue = NULL;
		$this->sub_kegiatan->OldValue = $this->sub_kegiatan->CurrentValue;
		$this->uraian->CurrentValue = NULL;
		$this->uraian->OldValue = $this->uraian->CurrentValue;
		$this->nama_penerima->CurrentValue = NULL;
		$this->nama_penerima->OldValue = $this->nama_penerima->CurrentValue;
		$this->alamat_penerima->CurrentValue = NULL;
		$this->alamat_penerima->OldValue = $this->alamat_penerima->CurrentValue;
		$this->nama_pptk->CurrentValue = NULL;
		$this->nama_pptk->OldValue = $this->nama_pptk->CurrentValue;
		$this->nip_pptk->CurrentValue = NULL;
		$this->nip_pptk->OldValue = $this->nip_pptk->CurrentValue;
		$this->nama_pengguna->CurrentValue = NULL;
		$this->nama_pengguna->OldValue = $this->nama_pengguna->CurrentValue;
		$this->nip_pengguna_anggaran->CurrentValue = NULL;
		$this->nip_pengguna_anggaran->OldValue = $this->nip_pengguna_anggaran->CurrentValue;
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
		$this->kode_rekening->CurrentValue = NULL;
		$this->kode_rekening->OldValue = $this->kode_rekening->CurrentValue;
		$this->pph21->CurrentValue = NULL;
		$this->pph21->OldValue = $this->pph21->CurrentValue;
		$this->pph22->CurrentValue = NULL;
		$this->pph22->OldValue = $this->pph22->CurrentValue;
		$this->pph23->CurrentValue = NULL;
		$this->pph23->OldValue = $this->pph23->CurrentValue;
		$this->pph4->CurrentValue = NULL;
		$this->pph4->OldValue = $this->pph4->CurrentValue;
		$this->jumlah_belanja->CurrentValue = NULL;
		$this->jumlah_belanja->OldValue = $this->jumlah_belanja->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
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
			$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0);
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
		$this->LoadOldRecord();
		$this->no_spj->CurrentValue = $this->no_spj->FormValue;
		$this->tgl_spj->CurrentValue = $this->tgl_spj->FormValue;
		$this->tgl_spj->CurrentValue = ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7);
		$this->program->CurrentValue = $this->program->FormValue;
		$this->kegiatan->CurrentValue = $this->kegiatan->FormValue;
		$this->tipe->CurrentValue = $this->tipe->FormValue;
		$this->tipe_sbp->CurrentValue = $this->tipe_sbp->FormValue;
		$this->no_sbp->CurrentValue = $this->no_sbp->FormValue;
		$this->tgl_sbp->CurrentValue = $this->tgl_sbp->FormValue;
		$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0);
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
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->tipe->setDbValue($rs->fields('tipe'));
		$this->tipe_sbp->setDbValue($rs->fields('tipe_sbp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->tgl_sbp->setDbValue($rs->fields('tgl_sbp'));
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
		$this->no_spj->DbValue = $row['no_spj'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->tipe->DbValue = $row['tipe'];
		$this->tipe_sbp->DbValue = $row['tipe_sbp'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->tgl_sbp->DbValue = $row['tgl_sbp'];
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
		// no_spj
		// tgl_spj
		// program
		// kegiatan
		// tipe
		// tipe_sbp
		// no_sbp
		// tgl_sbp
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

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 7);
		$this->tgl_spj->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// tipe
		$this->tipe->ViewValue = $this->tipe->CurrentValue;
		$this->tipe->ViewCustomAttributes = "";

		// tipe_sbp
		$this->tipe_sbp->ViewValue = $this->tipe_sbp->CurrentValue;
		$this->tipe_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

		// tgl_sbp
		$this->tgl_sbp->ViewValue = $this->tgl_sbp->CurrentValue;
		$this->tgl_sbp->ViewValue = ew_FormatDateTime($this->tgl_sbp->ViewValue, 0);
		$this->tgl_sbp->ViewCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
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
		$this->nama_pptk->ViewValue = $this->nama_pptk->CurrentValue;
		$this->nama_pptk->ViewCustomAttributes = "";

		// nip_pptk
		$this->nip_pptk->ViewValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->ViewCustomAttributes = "";

		// nama_pengguna
		$this->nama_pengguna->ViewValue = $this->nama_pengguna->CurrentValue;
		$this->nama_pengguna->ViewCustomAttributes = "";

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->ViewValue = $this->nip_pengguna_anggaran->CurrentValue;
		$this->nip_pengguna_anggaran->ViewCustomAttributes = "";

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		$this->akun2->ViewValue = $this->akun2->CurrentValue;
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		$this->akun3->ViewValue = $this->akun3->CurrentValue;
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		$this->akun4->ViewValue = $this->akun4->CurrentValue;
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		$this->akun5->ViewValue = $this->akun5->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			$this->program->EditValue = ew_HtmlEncode($this->program->CurrentValue);
			$this->program->PlaceHolder = ew_RemoveHtml($this->program->FldCaption());

			// kegiatan
			$this->kegiatan->EditAttrs["class"] = "form-control";
			$this->kegiatan->EditCustomAttributes = "";
			$this->kegiatan->EditValue = ew_HtmlEncode($this->kegiatan->CurrentValue);
			$this->kegiatan->PlaceHolder = ew_RemoveHtml($this->kegiatan->FldCaption());

			// tipe
			$this->tipe->EditAttrs["class"] = "form-control";
			$this->tipe->EditCustomAttributes = "";
			$this->tipe->EditValue = ew_HtmlEncode($this->tipe->CurrentValue);
			$this->tipe->PlaceHolder = ew_RemoveHtml($this->tipe->FldCaption());

			// tipe_sbp
			$this->tipe_sbp->EditAttrs["class"] = "form-control";
			$this->tipe_sbp->EditCustomAttributes = "";
			$this->tipe_sbp->EditValue = ew_HtmlEncode($this->tipe_sbp->CurrentValue);
			$this->tipe_sbp->PlaceHolder = ew_RemoveHtml($this->tipe_sbp->FldCaption());

			// no_sbp
			$this->no_sbp->EditAttrs["class"] = "form-control";
			$this->no_sbp->EditCustomAttributes = "";
			$this->no_sbp->EditValue = ew_HtmlEncode($this->no_sbp->CurrentValue);
			$this->no_sbp->PlaceHolder = ew_RemoveHtml($this->no_sbp->FldCaption());

			// tgl_sbp
			$this->tgl_sbp->EditAttrs["class"] = "form-control";
			$this->tgl_sbp->EditCustomAttributes = "";
			$this->tgl_sbp->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sbp->CurrentValue, 8));
			$this->tgl_sbp->PlaceHolder = ew_RemoveHtml($this->tgl_sbp->FldCaption());

			// sub_kegiatan
			$this->sub_kegiatan->EditAttrs["class"] = "form-control";
			$this->sub_kegiatan->EditCustomAttributes = "";
			$this->sub_kegiatan->EditValue = ew_HtmlEncode($this->sub_kegiatan->CurrentValue);
			$this->sub_kegiatan->PlaceHolder = ew_RemoveHtml($this->sub_kegiatan->FldCaption());

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
			$this->nama_pptk->EditValue = ew_HtmlEncode($this->nama_pptk->CurrentValue);
			$this->nama_pptk->PlaceHolder = ew_RemoveHtml($this->nama_pptk->FldCaption());

			// nip_pptk
			$this->nip_pptk->EditAttrs["class"] = "form-control";
			$this->nip_pptk->EditCustomAttributes = "";
			$this->nip_pptk->EditValue = ew_HtmlEncode($this->nip_pptk->CurrentValue);
			$this->nip_pptk->PlaceHolder = ew_RemoveHtml($this->nip_pptk->FldCaption());

			// nama_pengguna
			$this->nama_pengguna->EditAttrs["class"] = "form-control";
			$this->nama_pengguna->EditCustomAttributes = "";
			$this->nama_pengguna->EditValue = ew_HtmlEncode($this->nama_pengguna->CurrentValue);
			$this->nama_pengguna->PlaceHolder = ew_RemoveHtml($this->nama_pengguna->FldCaption());

			// nip_pengguna_anggaran
			$this->nip_pengguna_anggaran->EditAttrs["class"] = "form-control";
			$this->nip_pengguna_anggaran->EditCustomAttributes = "";
			$this->nip_pengguna_anggaran->EditValue = ew_HtmlEncode($this->nip_pengguna_anggaran->CurrentValue);
			$this->nip_pengguna_anggaran->PlaceHolder = ew_RemoveHtml($this->nip_pengguna_anggaran->FldCaption());

			// akun1
			$this->akun1->EditAttrs["class"] = "form-control";
			$this->akun1->EditCustomAttributes = "";
			$this->akun1->EditValue = ew_HtmlEncode($this->akun1->CurrentValue);
			$this->akun1->PlaceHolder = ew_RemoveHtml($this->akun1->FldCaption());

			// akun2
			$this->akun2->EditAttrs["class"] = "form-control";
			$this->akun2->EditCustomAttributes = "";
			$this->akun2->EditValue = ew_HtmlEncode($this->akun2->CurrentValue);
			$this->akun2->PlaceHolder = ew_RemoveHtml($this->akun2->FldCaption());

			// akun3
			$this->akun3->EditAttrs["class"] = "form-control";
			$this->akun3->EditCustomAttributes = "";
			$this->akun3->EditValue = ew_HtmlEncode($this->akun3->CurrentValue);
			$this->akun3->PlaceHolder = ew_RemoveHtml($this->akun3->FldCaption());

			// akun4
			$this->akun4->EditAttrs["class"] = "form-control";
			$this->akun4->EditCustomAttributes = "";
			$this->akun4->EditValue = ew_HtmlEncode($this->akun4->CurrentValue);
			$this->akun4->PlaceHolder = ew_RemoveHtml($this->akun4->FldCaption());

			// akun5
			$this->akun5->EditAttrs["class"] = "form-control";
			$this->akun5->EditCustomAttributes = "";
			$this->akun5->EditValue = ew_HtmlEncode($this->akun5->CurrentValue);
			$this->akun5->PlaceHolder = ew_RemoveHtml($this->akun5->FldCaption());

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

			// Add refer script
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
		if (!ew_CheckEuroDate($this->tgl_spj->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spj->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tipe->FormValue)) {
			ew_AddMessage($gsFormError, $this->tipe->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tipe_sbp->FormValue)) {
			ew_AddMessage($gsFormError, $this->tipe_sbp->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_sbp->FormValue)) {
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// no_spj
		$this->no_spj->SetDbValueDef($rsnew, $this->no_spj->CurrentValue, NULL, FALSE);

		// tgl_spj
		$this->tgl_spj->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7), NULL, FALSE);

		// program
		$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, FALSE);

		// kegiatan
		$this->kegiatan->SetDbValueDef($rsnew, $this->kegiatan->CurrentValue, NULL, FALSE);

		// tipe
		$this->tipe->SetDbValueDef($rsnew, $this->tipe->CurrentValue, NULL, FALSE);

		// tipe_sbp
		$this->tipe_sbp->SetDbValueDef($rsnew, $this->tipe_sbp->CurrentValue, NULL, FALSE);

		// no_sbp
		$this->no_sbp->SetDbValueDef($rsnew, $this->no_sbp->CurrentValue, NULL, FALSE);

		// tgl_sbp
		$this->tgl_sbp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0), NULL, FALSE);

		// sub_kegiatan
		$this->sub_kegiatan->SetDbValueDef($rsnew, $this->sub_kegiatan->CurrentValue, NULL, FALSE);

		// uraian
		$this->uraian->SetDbValueDef($rsnew, $this->uraian->CurrentValue, NULL, FALSE);

		// nama_penerima
		$this->nama_penerima->SetDbValueDef($rsnew, $this->nama_penerima->CurrentValue, NULL, FALSE);

		// alamat_penerima
		$this->alamat_penerima->SetDbValueDef($rsnew, $this->alamat_penerima->CurrentValue, NULL, FALSE);

		// nama_pptk
		$this->nama_pptk->SetDbValueDef($rsnew, $this->nama_pptk->CurrentValue, NULL, FALSE);

		// nip_pptk
		$this->nip_pptk->SetDbValueDef($rsnew, $this->nip_pptk->CurrentValue, NULL, FALSE);

		// nama_pengguna
		$this->nama_pengguna->SetDbValueDef($rsnew, $this->nama_pengguna->CurrentValue, NULL, FALSE);

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->SetDbValueDef($rsnew, $this->nip_pengguna_anggaran->CurrentValue, NULL, FALSE);

		// akun1
		$this->akun1->SetDbValueDef($rsnew, $this->akun1->CurrentValue, NULL, FALSE);

		// akun2
		$this->akun2->SetDbValueDef($rsnew, $this->akun2->CurrentValue, NULL, FALSE);

		// akun3
		$this->akun3->SetDbValueDef($rsnew, $this->akun3->CurrentValue, NULL, FALSE);

		// akun4
		$this->akun4->SetDbValueDef($rsnew, $this->akun4->CurrentValue, NULL, FALSE);

		// akun5
		$this->akun5->SetDbValueDef($rsnew, $this->akun5->CurrentValue, NULL, FALSE);

		// kode_rekening
		$this->kode_rekening->SetDbValueDef($rsnew, $this->kode_rekening->CurrentValue, NULL, FALSE);

		// pph21
		$this->pph21->SetDbValueDef($rsnew, $this->pph21->CurrentValue, NULL, FALSE);

		// pph22
		$this->pph22->SetDbValueDef($rsnew, $this->pph22->CurrentValue, NULL, FALSE);

		// pph23
		$this->pph23->SetDbValueDef($rsnew, $this->pph23->CurrentValue, NULL, FALSE);

		// pph4
		$this->pph4->SetDbValueDef($rsnew, $this->pph4->CurrentValue, NULL, FALSE);

		// jumlah_belanja
		$this->jumlah_belanja->SetDbValueDef($rsnew, $this->jumlah_belanja->CurrentValue, NULL, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spj_gulist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($vw_spj_gu_add)) $vw_spj_gu_add = new cvw_spj_gu_add();

// Page init
$vw_spj_gu_add->Page_Init();

// Page main
$vw_spj_gu_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spj_gu_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_spj_guadd = new ew_Form("fvw_spj_guadd", "add");

// Validate form
fvw_spj_guadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spj_gu->tgl_spj->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tipe");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spj_gu->tipe->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tipe_sbp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spj_gu->tipe_sbp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_sbp");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spj_gu->tgl_sbp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spj_gu->jumlah_belanja->FldErrMsg()) ?>");

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
fvw_spj_guadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spj_guadd.ValidateRequired = true;
<?php } else { ?>
fvw_spj_guadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spj_gu_add->IsModal) { ?>
<?php } ?>
<?php $vw_spj_gu_add->ShowPageHeader(); ?>
<?php
$vw_spj_gu_add->ShowMessage();
?>
<form name="fvw_spj_guadd" id="fvw_spj_guadd" class="<?php echo $vw_spj_gu_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spj_gu_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spj_gu_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spj_gu">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_spj_gu_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_spj_gu->no_spj->Visible) { // no_spj ?>
	<div id="r_no_spj" class="form-group">
		<label id="elh_vw_spj_gu_no_spj" for="x_no_spj" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->no_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->no_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_spj">
<input type="text" data-table="vw_spj_gu" data-field="x_no_spj" name="x_no_spj" id="x_no_spj" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->no_spj->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->no_spj->EditValue ?>"<?php echo $vw_spj_gu->no_spj->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->no_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->tgl_spj->Visible) { // tgl_spj ?>
	<div id="r_tgl_spj" class="form-group">
		<label id="elh_vw_spj_gu_tgl_spj" for="x_tgl_spj" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->tgl_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->tgl_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_spj">
<input type="text" data-table="vw_spj_gu" data-field="x_tgl_spj" data-format="7" name="x_tgl_spj" id="x_tgl_spj" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->tgl_spj->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->tgl_spj->EditValue ?>"<?php echo $vw_spj_gu->tgl_spj->EditAttributes() ?>>
<?php if (!$vw_spj_gu->tgl_spj->ReadOnly && !$vw_spj_gu->tgl_spj->Disabled && !isset($vw_spj_gu->tgl_spj->EditAttrs["readonly"]) && !isset($vw_spj_gu->tgl_spj->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_spj_guadd", "x_tgl_spj", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_spj_gu->tgl_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_vw_spj_gu_program" for="x_program" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->program->CellAttributes() ?>>
<span id="el_vw_spj_gu_program">
<input type="text" data-table="vw_spj_gu" data-field="x_program" name="x_program" id="x_program" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->program->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->program->EditValue ?>"<?php echo $vw_spj_gu->program->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->kegiatan->Visible) { // kegiatan ?>
	<div id="r_kegiatan" class="form-group">
		<label id="elh_vw_spj_gu_kegiatan" for="x_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->kegiatan->CellAttributes() ?>>
<span id="el_vw_spj_gu_kegiatan">
<input type="text" data-table="vw_spj_gu" data-field="x_kegiatan" name="x_kegiatan" id="x_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->kegiatan->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->kegiatan->EditValue ?>"<?php echo $vw_spj_gu->kegiatan->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->tipe->Visible) { // tipe ?>
	<div id="r_tipe" class="form-group">
		<label id="elh_vw_spj_gu_tipe" for="x_tipe" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->tipe->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->tipe->CellAttributes() ?>>
<span id="el_vw_spj_gu_tipe">
<input type="text" data-table="vw_spj_gu" data-field="x_tipe" name="x_tipe" id="x_tipe" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->tipe->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->tipe->EditValue ?>"<?php echo $vw_spj_gu->tipe->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->tipe->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->tipe_sbp->Visible) { // tipe_sbp ?>
	<div id="r_tipe_sbp" class="form-group">
		<label id="elh_vw_spj_gu_tipe_sbp" for="x_tipe_sbp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->tipe_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->tipe_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tipe_sbp">
<input type="text" data-table="vw_spj_gu" data-field="x_tipe_sbp" name="x_tipe_sbp" id="x_tipe_sbp" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->tipe_sbp->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->tipe_sbp->EditValue ?>"<?php echo $vw_spj_gu->tipe_sbp->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->tipe_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->no_sbp->Visible) { // no_sbp ?>
	<div id="r_no_sbp" class="form-group">
		<label id="elh_vw_spj_gu_no_sbp" for="x_no_sbp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->no_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->no_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_sbp">
<input type="text" data-table="vw_spj_gu" data-field="x_no_sbp" name="x_no_sbp" id="x_no_sbp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->no_sbp->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->no_sbp->EditValue ?>"<?php echo $vw_spj_gu->no_sbp->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->no_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->tgl_sbp->Visible) { // tgl_sbp ?>
	<div id="r_tgl_sbp" class="form-group">
		<label id="elh_vw_spj_gu_tgl_sbp" for="x_tgl_sbp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->tgl_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->tgl_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_sbp">
<input type="text" data-table="vw_spj_gu" data-field="x_tgl_sbp" name="x_tgl_sbp" id="x_tgl_sbp" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->tgl_sbp->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->tgl_sbp->EditValue ?>"<?php echo $vw_spj_gu->tgl_sbp->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->tgl_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<div id="r_sub_kegiatan" class="form-group">
		<label id="elh_vw_spj_gu_sub_kegiatan" for="x_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->sub_kegiatan->CellAttributes() ?>>
<span id="el_vw_spj_gu_sub_kegiatan">
<input type="text" data-table="vw_spj_gu" data-field="x_sub_kegiatan" name="x_sub_kegiatan" id="x_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->sub_kegiatan->EditValue ?>"<?php echo $vw_spj_gu->sub_kegiatan->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->uraian->Visible) { // uraian ?>
	<div id="r_uraian" class="form-group">
		<label id="elh_vw_spj_gu_uraian" for="x_uraian" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->uraian->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->uraian->CellAttributes() ?>>
<span id="el_vw_spj_gu_uraian">
<input type="text" data-table="vw_spj_gu" data-field="x_uraian" name="x_uraian" id="x_uraian" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->uraian->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->uraian->EditValue ?>"<?php echo $vw_spj_gu->uraian->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->uraian->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->nama_penerima->Visible) { // nama_penerima ?>
	<div id="r_nama_penerima" class="form-group">
		<label id="elh_vw_spj_gu_nama_penerima" for="x_nama_penerima" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->nama_penerima->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->nama_penerima->CellAttributes() ?>>
<span id="el_vw_spj_gu_nama_penerima">
<input type="text" data-table="vw_spj_gu" data-field="x_nama_penerima" name="x_nama_penerima" id="x_nama_penerima" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->nama_penerima->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->nama_penerima->EditValue ?>"<?php echo $vw_spj_gu->nama_penerima->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->nama_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->alamat_penerima->Visible) { // alamat_penerima ?>
	<div id="r_alamat_penerima" class="form-group">
		<label id="elh_vw_spj_gu_alamat_penerima" for="x_alamat_penerima" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->alamat_penerima->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->alamat_penerima->CellAttributes() ?>>
<span id="el_vw_spj_gu_alamat_penerima">
<input type="text" data-table="vw_spj_gu" data-field="x_alamat_penerima" name="x_alamat_penerima" id="x_alamat_penerima" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->alamat_penerima->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->alamat_penerima->EditValue ?>"<?php echo $vw_spj_gu->alamat_penerima->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->alamat_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->nama_pptk->Visible) { // nama_pptk ?>
	<div id="r_nama_pptk" class="form-group">
		<label id="elh_vw_spj_gu_nama_pptk" for="x_nama_pptk" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->nama_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->nama_pptk->CellAttributes() ?>>
<span id="el_vw_spj_gu_nama_pptk">
<input type="text" data-table="vw_spj_gu" data-field="x_nama_pptk" name="x_nama_pptk" id="x_nama_pptk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->nama_pptk->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->nama_pptk->EditValue ?>"<?php echo $vw_spj_gu->nama_pptk->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->nama_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->nip_pptk->Visible) { // nip_pptk ?>
	<div id="r_nip_pptk" class="form-group">
		<label id="elh_vw_spj_gu_nip_pptk" for="x_nip_pptk" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->nip_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->nip_pptk->CellAttributes() ?>>
<span id="el_vw_spj_gu_nip_pptk">
<input type="text" data-table="vw_spj_gu" data-field="x_nip_pptk" name="x_nip_pptk" id="x_nip_pptk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->nip_pptk->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->nip_pptk->EditValue ?>"<?php echo $vw_spj_gu->nip_pptk->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->nip_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->nama_pengguna->Visible) { // nama_pengguna ?>
	<div id="r_nama_pengguna" class="form-group">
		<label id="elh_vw_spj_gu_nama_pengguna" for="x_nama_pengguna" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->nama_pengguna->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->nama_pengguna->CellAttributes() ?>>
<span id="el_vw_spj_gu_nama_pengguna">
<input type="text" data-table="vw_spj_gu" data-field="x_nama_pengguna" name="x_nama_pengguna" id="x_nama_pengguna" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->nama_pengguna->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->nama_pengguna->EditValue ?>"<?php echo $vw_spj_gu->nama_pengguna->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->nama_pengguna->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->nip_pengguna_anggaran->Visible) { // nip_pengguna_anggaran ?>
	<div id="r_nip_pengguna_anggaran" class="form-group">
		<label id="elh_vw_spj_gu_nip_pengguna_anggaran" for="x_nip_pengguna_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->nip_pengguna_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->nip_pengguna_anggaran->CellAttributes() ?>>
<span id="el_vw_spj_gu_nip_pengguna_anggaran">
<input type="text" data-table="vw_spj_gu" data-field="x_nip_pengguna_anggaran" name="x_nip_pengguna_anggaran" id="x_nip_pengguna_anggaran" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->nip_pengguna_anggaran->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->nip_pengguna_anggaran->EditValue ?>"<?php echo $vw_spj_gu->nip_pengguna_anggaran->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->nip_pengguna_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->akun1->Visible) { // akun1 ?>
	<div id="r_akun1" class="form-group">
		<label id="elh_vw_spj_gu_akun1" for="x_akun1" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->akun1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->akun1->CellAttributes() ?>>
<span id="el_vw_spj_gu_akun1">
<input type="text" data-table="vw_spj_gu" data-field="x_akun1" name="x_akun1" id="x_akun1" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->akun1->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->akun1->EditValue ?>"<?php echo $vw_spj_gu->akun1->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->akun2->Visible) { // akun2 ?>
	<div id="r_akun2" class="form-group">
		<label id="elh_vw_spj_gu_akun2" for="x_akun2" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->akun2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->akun2->CellAttributes() ?>>
<span id="el_vw_spj_gu_akun2">
<input type="text" data-table="vw_spj_gu" data-field="x_akun2" name="x_akun2" id="x_akun2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->akun2->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->akun2->EditValue ?>"<?php echo $vw_spj_gu->akun2->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->akun2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->akun3->Visible) { // akun3 ?>
	<div id="r_akun3" class="form-group">
		<label id="elh_vw_spj_gu_akun3" for="x_akun3" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->akun3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->akun3->CellAttributes() ?>>
<span id="el_vw_spj_gu_akun3">
<input type="text" data-table="vw_spj_gu" data-field="x_akun3" name="x_akun3" id="x_akun3" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->akun3->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->akun3->EditValue ?>"<?php echo $vw_spj_gu->akun3->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->akun3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->akun4->Visible) { // akun4 ?>
	<div id="r_akun4" class="form-group">
		<label id="elh_vw_spj_gu_akun4" for="x_akun4" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->akun4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->akun4->CellAttributes() ?>>
<span id="el_vw_spj_gu_akun4">
<input type="text" data-table="vw_spj_gu" data-field="x_akun4" name="x_akun4" id="x_akun4" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->akun4->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->akun4->EditValue ?>"<?php echo $vw_spj_gu->akun4->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->akun5->Visible) { // akun5 ?>
	<div id="r_akun5" class="form-group">
		<label id="elh_vw_spj_gu_akun5" for="x_akun5" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->akun5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->akun5->CellAttributes() ?>>
<span id="el_vw_spj_gu_akun5">
<input type="text" data-table="vw_spj_gu" data-field="x_akun5" name="x_akun5" id="x_akun5" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->akun5->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->akun5->EditValue ?>"<?php echo $vw_spj_gu->akun5->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->akun5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->kode_rekening->Visible) { // kode_rekening ?>
	<div id="r_kode_rekening" class="form-group">
		<label id="elh_vw_spj_gu_kode_rekening" for="x_kode_rekening" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->kode_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->kode_rekening->CellAttributes() ?>>
<span id="el_vw_spj_gu_kode_rekening">
<input type="text" data-table="vw_spj_gu" data-field="x_kode_rekening" name="x_kode_rekening" id="x_kode_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->kode_rekening->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->kode_rekening->EditValue ?>"<?php echo $vw_spj_gu->kode_rekening->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->kode_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->pph21->Visible) { // pph21 ?>
	<div id="r_pph21" class="form-group">
		<label id="elh_vw_spj_gu_pph21" for="x_pph21" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->pph21->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->pph21->CellAttributes() ?>>
<span id="el_vw_spj_gu_pph21">
<input type="text" data-table="vw_spj_gu" data-field="x_pph21" name="x_pph21" id="x_pph21" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->pph21->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->pph21->EditValue ?>"<?php echo $vw_spj_gu->pph21->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->pph21->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->pph22->Visible) { // pph22 ?>
	<div id="r_pph22" class="form-group">
		<label id="elh_vw_spj_gu_pph22" for="x_pph22" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->pph22->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->pph22->CellAttributes() ?>>
<span id="el_vw_spj_gu_pph22">
<input type="text" data-table="vw_spj_gu" data-field="x_pph22" name="x_pph22" id="x_pph22" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->pph22->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->pph22->EditValue ?>"<?php echo $vw_spj_gu->pph22->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->pph22->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->pph23->Visible) { // pph23 ?>
	<div id="r_pph23" class="form-group">
		<label id="elh_vw_spj_gu_pph23" for="x_pph23" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->pph23->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->pph23->CellAttributes() ?>>
<span id="el_vw_spj_gu_pph23">
<input type="text" data-table="vw_spj_gu" data-field="x_pph23" name="x_pph23" id="x_pph23" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->pph23->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->pph23->EditValue ?>"<?php echo $vw_spj_gu->pph23->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->pph23->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->pph4->Visible) { // pph4 ?>
	<div id="r_pph4" class="form-group">
		<label id="elh_vw_spj_gu_pph4" for="x_pph4" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->pph4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->pph4->CellAttributes() ?>>
<span id="el_vw_spj_gu_pph4">
<input type="text" data-table="vw_spj_gu" data-field="x_pph4" name="x_pph4" id="x_pph4" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->pph4->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->pph4->EditValue ?>"<?php echo $vw_spj_gu->pph4->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->pph4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<div id="r_jumlah_belanja" class="form-group">
		<label id="elh_vw_spj_gu_jumlah_belanja" for="x_jumlah_belanja" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->jumlah_belanja->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->jumlah_belanja->CellAttributes() ?>>
<span id="el_vw_spj_gu_jumlah_belanja">
<input type="text" data-table="vw_spj_gu" data-field="x_jumlah_belanja" name="x_jumlah_belanja" id="x_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->jumlah_belanja->EditValue ?>"<?php echo $vw_spj_gu->jumlah_belanja->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->jumlah_belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_spj_gu_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spj_gu_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spj_guadd.Init();
</script>
<?php
$vw_spj_gu_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spj_gu_add->Page_Terminate();
?>
