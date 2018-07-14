<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_sppinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_spp_add = NULL; // Initialize page object first

class ct_spp_add extends ct_spp {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_spp';

	// Page object name
	var $PageObjName = 't_spp_add';

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

		// Table object (t_spp)
		if (!isset($GLOBALS["t_spp"]) || get_class($GLOBALS["t_spp"]) == "ct_spp") {
			$GLOBALS["t_spp"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_spp"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_spp', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_spplist.php"));
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
		$this->id_jenis_spp->SetVisibility();
		$this->detail_jenis_spp->SetVisibility();
		$this->status_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->jumlah_up->SetVisibility();
		$this->bendahara->SetVisibility();
		$this->nama_pptk->SetVisibility();
		$this->nip_pptk->SetVisibility();
		$this->status_spm->SetVisibility();
		$this->kode_kegiatan->SetVisibility();
		$this->kode_sub_kegiatan->SetVisibility();
		$this->tahun_anggaran->SetVisibility();
		$this->jumlah_spd->SetVisibility();
		$this->nomer_dasar_spd->SetVisibility();
		$this->tanggal_spd->SetVisibility();
		$this->id_spd->SetVisibility();
		$this->kode_program->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->nama_bendahara->SetVisibility();
		$this->nip_bendahara->SetVisibility();
		$this->no_spm->SetVisibility();
		$this->tgl_spm->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->nomer_rekening_bank->SetVisibility();
		$this->npwp->SetVisibility();
		$this->pph21->SetVisibility();
		$this->pph22->SetVisibility();
		$this->pph23->SetVisibility();
		$this->pph4->SetVisibility();
		$this->jumlah_belanja->SetVisibility();
		$this->kontrak_id->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();
		$this->pimpinan_blud->SetVisibility();
		$this->nip_pimpinan->SetVisibility();
		$this->opd->SetVisibility();
		$this->urusan_pemerintahan->SetVisibility();
		$this->tgl_sptb->SetVisibility();
		$this->no_sptb->SetVisibility();
		$this->status_advis->SetVisibility();
		$this->id_spj->SetVisibility();

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
		global $EW_EXPORT, $t_spp;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_spp);
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
					$this->Page_Terminate("t_spplist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_spplist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_sppview.php")
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
		$this->id_jenis_spp->CurrentValue = NULL;
		$this->id_jenis_spp->OldValue = $this->id_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->CurrentValue = NULL;
		$this->detail_jenis_spp->OldValue = $this->detail_jenis_spp->CurrentValue;
		$this->status_spp->CurrentValue = NULL;
		$this->status_spp->OldValue = $this->status_spp->CurrentValue;
		$this->no_spp->CurrentValue = NULL;
		$this->no_spp->OldValue = $this->no_spp->CurrentValue;
		$this->tgl_spp->CurrentValue = NULL;
		$this->tgl_spp->OldValue = $this->tgl_spp->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->jumlah_up->CurrentValue = NULL;
		$this->jumlah_up->OldValue = $this->jumlah_up->CurrentValue;
		$this->bendahara->CurrentValue = NULL;
		$this->bendahara->OldValue = $this->bendahara->CurrentValue;
		$this->nama_pptk->CurrentValue = NULL;
		$this->nama_pptk->OldValue = $this->nama_pptk->CurrentValue;
		$this->nip_pptk->CurrentValue = NULL;
		$this->nip_pptk->OldValue = $this->nip_pptk->CurrentValue;
		$this->status_spm->CurrentValue = NULL;
		$this->status_spm->OldValue = $this->status_spm->CurrentValue;
		$this->kode_kegiatan->CurrentValue = NULL;
		$this->kode_kegiatan->OldValue = $this->kode_kegiatan->CurrentValue;
		$this->kode_sub_kegiatan->CurrentValue = NULL;
		$this->kode_sub_kegiatan->OldValue = $this->kode_sub_kegiatan->CurrentValue;
		$this->tahun_anggaran->CurrentValue = 2018;
		$this->jumlah_spd->CurrentValue = NULL;
		$this->jumlah_spd->OldValue = $this->jumlah_spd->CurrentValue;
		$this->nomer_dasar_spd->CurrentValue = NULL;
		$this->nomer_dasar_spd->OldValue = $this->nomer_dasar_spd->CurrentValue;
		$this->tanggal_spd->CurrentValue = NULL;
		$this->tanggal_spd->OldValue = $this->tanggal_spd->CurrentValue;
		$this->id_spd->CurrentValue = NULL;
		$this->id_spd->OldValue = $this->id_spd->CurrentValue;
		$this->kode_program->CurrentValue = NULL;
		$this->kode_program->OldValue = $this->kode_program->CurrentValue;
		$this->kode_rekening->CurrentValue = NULL;
		$this->kode_rekening->OldValue = $this->kode_rekening->CurrentValue;
		$this->nama_bendahara->CurrentValue = NULL;
		$this->nama_bendahara->OldValue = $this->nama_bendahara->CurrentValue;
		$this->nip_bendahara->CurrentValue = NULL;
		$this->nip_bendahara->OldValue = $this->nip_bendahara->CurrentValue;
		$this->no_spm->CurrentValue = NULL;
		$this->no_spm->OldValue = $this->no_spm->CurrentValue;
		$this->tgl_spm->CurrentValue = NULL;
		$this->tgl_spm->OldValue = $this->tgl_spm->CurrentValue;
		$this->nama_bank->CurrentValue = NULL;
		$this->nama_bank->OldValue = $this->nama_bank->CurrentValue;
		$this->nomer_rekening_bank->CurrentValue = NULL;
		$this->nomer_rekening_bank->OldValue = $this->nomer_rekening_bank->CurrentValue;
		$this->npwp->CurrentValue = NULL;
		$this->npwp->OldValue = $this->npwp->CurrentValue;
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
		$this->kontrak_id->CurrentValue = NULL;
		$this->kontrak_id->OldValue = $this->kontrak_id->CurrentValue;
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
		$this->pimpinan_blud->CurrentValue = NULL;
		$this->pimpinan_blud->OldValue = $this->pimpinan_blud->CurrentValue;
		$this->nip_pimpinan->CurrentValue = NULL;
		$this->nip_pimpinan->OldValue = $this->nip_pimpinan->CurrentValue;
		$this->opd->CurrentValue = "1.02.03.001";
		$this->urusan_pemerintahan->CurrentValue = "1.02";
		$this->tgl_sptb->CurrentValue = NULL;
		$this->tgl_sptb->OldValue = $this->tgl_sptb->CurrentValue;
		$this->no_sptb->CurrentValue = NULL;
		$this->no_sptb->OldValue = $this->no_sptb->CurrentValue;
		$this->status_advis->CurrentValue = NULL;
		$this->status_advis->OldValue = $this->status_advis->CurrentValue;
		$this->id_spj->CurrentValue = NULL;
		$this->id_spj->OldValue = $this->id_spj->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
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
		if (!$this->jumlah_up->FldIsDetailKey) {
			$this->jumlah_up->setFormValue($objForm->GetValue("x_jumlah_up"));
		}
		if (!$this->bendahara->FldIsDetailKey) {
			$this->bendahara->setFormValue($objForm->GetValue("x_bendahara"));
		}
		if (!$this->nama_pptk->FldIsDetailKey) {
			$this->nama_pptk->setFormValue($objForm->GetValue("x_nama_pptk"));
		}
		if (!$this->nip_pptk->FldIsDetailKey) {
			$this->nip_pptk->setFormValue($objForm->GetValue("x_nip_pptk"));
		}
		if (!$this->status_spm->FldIsDetailKey) {
			$this->status_spm->setFormValue($objForm->GetValue("x_status_spm"));
		}
		if (!$this->kode_kegiatan->FldIsDetailKey) {
			$this->kode_kegiatan->setFormValue($objForm->GetValue("x_kode_kegiatan"));
		}
		if (!$this->kode_sub_kegiatan->FldIsDetailKey) {
			$this->kode_sub_kegiatan->setFormValue($objForm->GetValue("x_kode_sub_kegiatan"));
		}
		if (!$this->tahun_anggaran->FldIsDetailKey) {
			$this->tahun_anggaran->setFormValue($objForm->GetValue("x_tahun_anggaran"));
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
		if (!$this->id_spd->FldIsDetailKey) {
			$this->id_spd->setFormValue($objForm->GetValue("x_id_spd"));
		}
		if (!$this->kode_program->FldIsDetailKey) {
			$this->kode_program->setFormValue($objForm->GetValue("x_kode_program"));
		}
		if (!$this->kode_rekening->FldIsDetailKey) {
			$this->kode_rekening->setFormValue($objForm->GetValue("x_kode_rekening"));
		}
		if (!$this->nama_bendahara->FldIsDetailKey) {
			$this->nama_bendahara->setFormValue($objForm->GetValue("x_nama_bendahara"));
		}
		if (!$this->nip_bendahara->FldIsDetailKey) {
			$this->nip_bendahara->setFormValue($objForm->GetValue("x_nip_bendahara"));
		}
		if (!$this->no_spm->FldIsDetailKey) {
			$this->no_spm->setFormValue($objForm->GetValue("x_no_spm"));
		}
		if (!$this->tgl_spm->FldIsDetailKey) {
			$this->tgl_spm->setFormValue($objForm->GetValue("x_tgl_spm"));
			$this->tgl_spm->CurrentValue = ew_UnFormatDateTime($this->tgl_spm->CurrentValue, 0);
		}
		if (!$this->nama_bank->FldIsDetailKey) {
			$this->nama_bank->setFormValue($objForm->GetValue("x_nama_bank"));
		}
		if (!$this->nomer_rekening_bank->FldIsDetailKey) {
			$this->nomer_rekening_bank->setFormValue($objForm->GetValue("x_nomer_rekening_bank"));
		}
		if (!$this->npwp->FldIsDetailKey) {
			$this->npwp->setFormValue($objForm->GetValue("x_npwp"));
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
		if (!$this->kontrak_id->FldIsDetailKey) {
			$this->kontrak_id->setFormValue($objForm->GetValue("x_kontrak_id"));
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
		if (!$this->pimpinan_blud->FldIsDetailKey) {
			$this->pimpinan_blud->setFormValue($objForm->GetValue("x_pimpinan_blud"));
		}
		if (!$this->nip_pimpinan->FldIsDetailKey) {
			$this->nip_pimpinan->setFormValue($objForm->GetValue("x_nip_pimpinan"));
		}
		if (!$this->opd->FldIsDetailKey) {
			$this->opd->setFormValue($objForm->GetValue("x_opd"));
		}
		if (!$this->urusan_pemerintahan->FldIsDetailKey) {
			$this->urusan_pemerintahan->setFormValue($objForm->GetValue("x_urusan_pemerintahan"));
		}
		if (!$this->tgl_sptb->FldIsDetailKey) {
			$this->tgl_sptb->setFormValue($objForm->GetValue("x_tgl_sptb"));
			$this->tgl_sptb->CurrentValue = ew_UnFormatDateTime($this->tgl_sptb->CurrentValue, 0);
		}
		if (!$this->no_sptb->FldIsDetailKey) {
			$this->no_sptb->setFormValue($objForm->GetValue("x_no_sptb"));
		}
		if (!$this->status_advis->FldIsDetailKey) {
			$this->status_advis->setFormValue($objForm->GetValue("x_status_advis"));
		}
		if (!$this->id_spj->FldIsDetailKey) {
			$this->id_spj->setFormValue($objForm->GetValue("x_id_spj"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_jenis_spp->CurrentValue = $this->id_jenis_spp->FormValue;
		$this->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->FormValue;
		$this->status_spp->CurrentValue = $this->status_spp->FormValue;
		$this->no_spp->CurrentValue = $this->no_spp->FormValue;
		$this->tgl_spp->CurrentValue = $this->tgl_spp->FormValue;
		$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7);
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->jumlah_up->CurrentValue = $this->jumlah_up->FormValue;
		$this->bendahara->CurrentValue = $this->bendahara->FormValue;
		$this->nama_pptk->CurrentValue = $this->nama_pptk->FormValue;
		$this->nip_pptk->CurrentValue = $this->nip_pptk->FormValue;
		$this->status_spm->CurrentValue = $this->status_spm->FormValue;
		$this->kode_kegiatan->CurrentValue = $this->kode_kegiatan->FormValue;
		$this->kode_sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->FormValue;
		$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->FormValue;
		$this->jumlah_spd->CurrentValue = $this->jumlah_spd->FormValue;
		$this->nomer_dasar_spd->CurrentValue = $this->nomer_dasar_spd->FormValue;
		$this->tanggal_spd->CurrentValue = $this->tanggal_spd->FormValue;
		$this->tanggal_spd->CurrentValue = ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0);
		$this->id_spd->CurrentValue = $this->id_spd->FormValue;
		$this->kode_program->CurrentValue = $this->kode_program->FormValue;
		$this->kode_rekening->CurrentValue = $this->kode_rekening->FormValue;
		$this->nama_bendahara->CurrentValue = $this->nama_bendahara->FormValue;
		$this->nip_bendahara->CurrentValue = $this->nip_bendahara->FormValue;
		$this->no_spm->CurrentValue = $this->no_spm->FormValue;
		$this->tgl_spm->CurrentValue = $this->tgl_spm->FormValue;
		$this->tgl_spm->CurrentValue = ew_UnFormatDateTime($this->tgl_spm->CurrentValue, 0);
		$this->nama_bank->CurrentValue = $this->nama_bank->FormValue;
		$this->nomer_rekening_bank->CurrentValue = $this->nomer_rekening_bank->FormValue;
		$this->npwp->CurrentValue = $this->npwp->FormValue;
		$this->pph21->CurrentValue = $this->pph21->FormValue;
		$this->pph22->CurrentValue = $this->pph22->FormValue;
		$this->pph23->CurrentValue = $this->pph23->FormValue;
		$this->pph4->CurrentValue = $this->pph4->FormValue;
		$this->jumlah_belanja->CurrentValue = $this->jumlah_belanja->FormValue;
		$this->kontrak_id->CurrentValue = $this->kontrak_id->FormValue;
		$this->akun1->CurrentValue = $this->akun1->FormValue;
		$this->akun2->CurrentValue = $this->akun2->FormValue;
		$this->akun3->CurrentValue = $this->akun3->FormValue;
		$this->akun4->CurrentValue = $this->akun4->FormValue;
		$this->akun5->CurrentValue = $this->akun5->FormValue;
		$this->pimpinan_blud->CurrentValue = $this->pimpinan_blud->FormValue;
		$this->nip_pimpinan->CurrentValue = $this->nip_pimpinan->FormValue;
		$this->opd->CurrentValue = $this->opd->FormValue;
		$this->urusan_pemerintahan->CurrentValue = $this->urusan_pemerintahan->FormValue;
		$this->tgl_sptb->CurrentValue = $this->tgl_sptb->FormValue;
		$this->tgl_sptb->CurrentValue = ew_UnFormatDateTime($this->tgl_sptb->CurrentValue, 0);
		$this->no_sptb->CurrentValue = $this->no_sptb->FormValue;
		$this->status_advis->CurrentValue = $this->status_advis->FormValue;
		$this->id_spj->CurrentValue = $this->id_spj->FormValue;
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
		$this->jumlah_up->setDbValue($rs->fields('jumlah_up'));
		$this->bendahara->setDbValue($rs->fields('bendahara'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->status_spm->setDbValue($rs->fields('status_spm'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->no_spm->setDbValue($rs->fields('no_spm'));
		$this->tgl_spm->setDbValue($rs->fields('tgl_spm'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nomer_rekening_bank->setDbValue($rs->fields('nomer_rekening_bank'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->pph21->setDbValue($rs->fields('pph21'));
		$this->pph22->setDbValue($rs->fields('pph22'));
		$this->pph23->setDbValue($rs->fields('pph23'));
		$this->pph4->setDbValue($rs->fields('pph4'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->kontrak_id->setDbValue($rs->fields('kontrak_id'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->pimpinan_blud->setDbValue($rs->fields('pimpinan_blud'));
		$this->nip_pimpinan->setDbValue($rs->fields('nip_pimpinan'));
		$this->opd->setDbValue($rs->fields('opd'));
		$this->urusan_pemerintahan->setDbValue($rs->fields('urusan_pemerintahan'));
		$this->tgl_sptb->setDbValue($rs->fields('tgl_sptb'));
		$this->no_sptb->setDbValue($rs->fields('no_sptb'));
		$this->status_advis->setDbValue($rs->fields('status_advis'));
		$this->id_spj->setDbValue($rs->fields('id_spj'));
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
		$this->jumlah_up->DbValue = $row['jumlah_up'];
		$this->bendahara->DbValue = $row['bendahara'];
		$this->nama_pptk->DbValue = $row['nama_pptk'];
		$this->nip_pptk->DbValue = $row['nip_pptk'];
		$this->status_spm->DbValue = $row['status_spm'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
		$this->nomer_dasar_spd->DbValue = $row['nomer_dasar_spd'];
		$this->tanggal_spd->DbValue = $row['tanggal_spd'];
		$this->id_spd->DbValue = $row['id_spd'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->no_spm->DbValue = $row['no_spm'];
		$this->tgl_spm->DbValue = $row['tgl_spm'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->nomer_rekening_bank->DbValue = $row['nomer_rekening_bank'];
		$this->npwp->DbValue = $row['npwp'];
		$this->pph21->DbValue = $row['pph21'];
		$this->pph22->DbValue = $row['pph22'];
		$this->pph23->DbValue = $row['pph23'];
		$this->pph4->DbValue = $row['pph4'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
		$this->kontrak_id->DbValue = $row['kontrak_id'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
		$this->pimpinan_blud->DbValue = $row['pimpinan_blud'];
		$this->nip_pimpinan->DbValue = $row['nip_pimpinan'];
		$this->opd->DbValue = $row['opd'];
		$this->urusan_pemerintahan->DbValue = $row['urusan_pemerintahan'];
		$this->tgl_sptb->DbValue = $row['tgl_sptb'];
		$this->no_sptb->DbValue = $row['no_sptb'];
		$this->status_advis->DbValue = $row['status_advis'];
		$this->id_spj->DbValue = $row['id_spj'];
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

		if ($this->jumlah_up->FormValue == $this->jumlah_up->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_up->CurrentValue)))
			$this->jumlah_up->CurrentValue = ew_StrToFloat($this->jumlah_up->CurrentValue);

		// Convert decimal values if posted back
		if ($this->jumlah_spd->FormValue == $this->jumlah_spd->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_spd->CurrentValue)))
			$this->jumlah_spd->CurrentValue = ew_StrToFloat($this->jumlah_spd->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pph21->FormValue == $this->pph21->CurrentValue && is_numeric(ew_StrToFloat($this->pph21->CurrentValue)))
			$this->pph21->CurrentValue = ew_StrToFloat($this->pph21->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pph22->FormValue == $this->pph22->CurrentValue && is_numeric(ew_StrToFloat($this->pph22->CurrentValue)))
			$this->pph22->CurrentValue = ew_StrToFloat($this->pph22->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pph23->FormValue == $this->pph23->CurrentValue && is_numeric(ew_StrToFloat($this->pph23->CurrentValue)))
			$this->pph23->CurrentValue = ew_StrToFloat($this->pph23->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pph4->FormValue == $this->pph4->CurrentValue && is_numeric(ew_StrToFloat($this->pph4->CurrentValue)))
			$this->pph4->CurrentValue = ew_StrToFloat($this->pph4->CurrentValue);

		// Convert decimal values if posted back
		if ($this->jumlah_belanja->FormValue == $this->jumlah_belanja->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_belanja->CurrentValue)))
			$this->jumlah_belanja->CurrentValue = ew_StrToFloat($this->jumlah_belanja->CurrentValue);

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
		// jumlah_up
		// bendahara
		// nama_pptk
		// nip_pptk
		// status_spm
		// kode_kegiatan
		// kode_sub_kegiatan
		// tahun_anggaran
		// jumlah_spd
		// nomer_dasar_spd
		// tanggal_spd
		// id_spd
		// kode_program
		// kode_rekening
		// nama_bendahara
		// nip_bendahara
		// no_spm
		// tgl_spm
		// nama_bank
		// nomer_rekening_bank
		// npwp
		// pph21
		// pph22
		// pph23
		// pph4
		// jumlah_belanja
		// kontrak_id
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5
		// pimpinan_blud
		// nip_pimpinan
		// opd
		// urusan_pemerintahan
		// tgl_sptb
		// no_sptb
		// status_advis
		// id_spj

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

		// status_spm
		$this->status_spm->ViewValue = $this->status_spm->CurrentValue;
		$this->status_spm->ViewCustomAttributes = "";

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

		// kode_program
		$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
		$this->kode_program->ViewCustomAttributes = "";

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
		$this->tgl_spm->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nomer_rekening_bank
		$this->nomer_rekening_bank->ViewValue = $this->nomer_rekening_bank->CurrentValue;
		$this->nomer_rekening_bank->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

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

		// kontrak_id
		$this->kontrak_id->ViewValue = $this->kontrak_id->CurrentValue;
		$this->kontrak_id->ViewCustomAttributes = "";

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

		// pimpinan_blud
		$this->pimpinan_blud->ViewValue = $this->pimpinan_blud->CurrentValue;
		$this->pimpinan_blud->ViewCustomAttributes = "";

		// nip_pimpinan
		$this->nip_pimpinan->ViewValue = $this->nip_pimpinan->CurrentValue;
		$this->nip_pimpinan->ViewCustomAttributes = "";

		// opd
		$this->opd->ViewValue = $this->opd->CurrentValue;
		$this->opd->ViewCustomAttributes = "";

		// urusan_pemerintahan
		$this->urusan_pemerintahan->ViewValue = $this->urusan_pemerintahan->CurrentValue;
		$this->urusan_pemerintahan->ViewCustomAttributes = "";

		// tgl_sptb
		$this->tgl_sptb->ViewValue = $this->tgl_sptb->CurrentValue;
		$this->tgl_sptb->ViewValue = ew_FormatDateTime($this->tgl_sptb->ViewValue, 0);
		$this->tgl_sptb->ViewCustomAttributes = "";

		// no_sptb
		$this->no_sptb->ViewValue = $this->no_sptb->CurrentValue;
		$this->no_sptb->ViewCustomAttributes = "";

		// status_advis
		$this->status_advis->ViewValue = $this->status_advis->CurrentValue;
		$this->status_advis->ViewCustomAttributes = "";

		// id_spj
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		$this->id_spj->ViewCustomAttributes = "";

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

			// jumlah_up
			$this->jumlah_up->LinkCustomAttributes = "";
			$this->jumlah_up->HrefValue = "";
			$this->jumlah_up->TooltipValue = "";

			// bendahara
			$this->bendahara->LinkCustomAttributes = "";
			$this->bendahara->HrefValue = "";
			$this->bendahara->TooltipValue = "";

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";
			$this->nama_pptk->TooltipValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";
			$this->nip_pptk->TooltipValue = "";

			// status_spm
			$this->status_spm->LinkCustomAttributes = "";
			$this->status_spm->HrefValue = "";
			$this->status_spm->TooltipValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";
			$this->kode_kegiatan->TooltipValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";
			$this->kode_sub_kegiatan->TooltipValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

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

			// id_spd
			$this->id_spd->LinkCustomAttributes = "";
			$this->id_spd->HrefValue = "";
			$this->id_spd->TooltipValue = "";

			// kode_program
			$this->kode_program->LinkCustomAttributes = "";
			$this->kode_program->HrefValue = "";
			$this->kode_program->TooltipValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";
			$this->nama_bendahara->TooltipValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";
			$this->nip_bendahara->TooltipValue = "";

			// no_spm
			$this->no_spm->LinkCustomAttributes = "";
			$this->no_spm->HrefValue = "";
			$this->no_spm->TooltipValue = "";

			// tgl_spm
			$this->tgl_spm->LinkCustomAttributes = "";
			$this->tgl_spm->HrefValue = "";
			$this->tgl_spm->TooltipValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";
			$this->nama_bank->TooltipValue = "";

			// nomer_rekening_bank
			$this->nomer_rekening_bank->LinkCustomAttributes = "";
			$this->nomer_rekening_bank->HrefValue = "";
			$this->nomer_rekening_bank->TooltipValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";
			$this->npwp->TooltipValue = "";

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

			// kontrak_id
			$this->kontrak_id->LinkCustomAttributes = "";
			$this->kontrak_id->HrefValue = "";
			$this->kontrak_id->TooltipValue = "";

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

			// pimpinan_blud
			$this->pimpinan_blud->LinkCustomAttributes = "";
			$this->pimpinan_blud->HrefValue = "";
			$this->pimpinan_blud->TooltipValue = "";

			// nip_pimpinan
			$this->nip_pimpinan->LinkCustomAttributes = "";
			$this->nip_pimpinan->HrefValue = "";
			$this->nip_pimpinan->TooltipValue = "";

			// opd
			$this->opd->LinkCustomAttributes = "";
			$this->opd->HrefValue = "";
			$this->opd->TooltipValue = "";

			// urusan_pemerintahan
			$this->urusan_pemerintahan->LinkCustomAttributes = "";
			$this->urusan_pemerintahan->HrefValue = "";
			$this->urusan_pemerintahan->TooltipValue = "";

			// tgl_sptb
			$this->tgl_sptb->LinkCustomAttributes = "";
			$this->tgl_sptb->HrefValue = "";
			$this->tgl_sptb->TooltipValue = "";

			// no_sptb
			$this->no_sptb->LinkCustomAttributes = "";
			$this->no_sptb->HrefValue = "";
			$this->no_sptb->TooltipValue = "";

			// status_advis
			$this->status_advis->LinkCustomAttributes = "";
			$this->status_advis->HrefValue = "";
			$this->status_advis->TooltipValue = "";

			// id_spj
			$this->id_spj->LinkCustomAttributes = "";
			$this->id_spj->HrefValue = "";
			$this->id_spj->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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
			$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `id_jenis` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jenis_detail_spp`";
			$sWhereWrk = "";
			$this->detail_jenis_spp->LookupFilters = array();
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

			// jumlah_up
			$this->jumlah_up->EditAttrs["class"] = "form-control";
			$this->jumlah_up->EditCustomAttributes = "";
			$this->jumlah_up->EditValue = ew_HtmlEncode($this->jumlah_up->CurrentValue);
			$this->jumlah_up->PlaceHolder = ew_RemoveHtml($this->jumlah_up->FldCaption());
			if (strval($this->jumlah_up->EditValue) <> "" && is_numeric($this->jumlah_up->EditValue)) $this->jumlah_up->EditValue = ew_FormatNumber($this->jumlah_up->EditValue, -2, -1, -2, 0);

			// bendahara
			$this->bendahara->EditAttrs["class"] = "form-control";
			$this->bendahara->EditCustomAttributes = "";
			$this->bendahara->EditValue = ew_HtmlEncode($this->bendahara->CurrentValue);
			$this->bendahara->PlaceHolder = ew_RemoveHtml($this->bendahara->FldCaption());

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

			// status_spm
			$this->status_spm->EditAttrs["class"] = "form-control";
			$this->status_spm->EditCustomAttributes = "";
			$this->status_spm->EditValue = ew_HtmlEncode($this->status_spm->CurrentValue);
			$this->status_spm->PlaceHolder = ew_RemoveHtml($this->status_spm->FldCaption());

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

			// tahun_anggaran
			$this->tahun_anggaran->EditAttrs["class"] = "form-control";
			$this->tahun_anggaran->EditCustomAttributes = "";
			$this->tahun_anggaran->EditValue = ew_HtmlEncode($this->tahun_anggaran->CurrentValue);
			$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

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

			// id_spd
			$this->id_spd->EditAttrs["class"] = "form-control";
			$this->id_spd->EditCustomAttributes = "";
			$this->id_spd->EditValue = ew_HtmlEncode($this->id_spd->CurrentValue);
			$this->id_spd->PlaceHolder = ew_RemoveHtml($this->id_spd->FldCaption());

			// kode_program
			$this->kode_program->EditAttrs["class"] = "form-control";
			$this->kode_program->EditCustomAttributes = "";
			$this->kode_program->EditValue = ew_HtmlEncode($this->kode_program->CurrentValue);
			$this->kode_program->PlaceHolder = ew_RemoveHtml($this->kode_program->FldCaption());

			// kode_rekening
			$this->kode_rekening->EditAttrs["class"] = "form-control";
			$this->kode_rekening->EditCustomAttributes = "";
			$this->kode_rekening->EditValue = ew_HtmlEncode($this->kode_rekening->CurrentValue);
			$this->kode_rekening->PlaceHolder = ew_RemoveHtml($this->kode_rekening->FldCaption());

			// nama_bendahara
			$this->nama_bendahara->EditAttrs["class"] = "form-control";
			$this->nama_bendahara->EditCustomAttributes = "";
			$this->nama_bendahara->EditValue = ew_HtmlEncode($this->nama_bendahara->CurrentValue);
			$this->nama_bendahara->PlaceHolder = ew_RemoveHtml($this->nama_bendahara->FldCaption());

			// nip_bendahara
			$this->nip_bendahara->EditAttrs["class"] = "form-control";
			$this->nip_bendahara->EditCustomAttributes = "";
			$this->nip_bendahara->EditValue = ew_HtmlEncode($this->nip_bendahara->CurrentValue);
			$this->nip_bendahara->PlaceHolder = ew_RemoveHtml($this->nip_bendahara->FldCaption());

			// no_spm
			$this->no_spm->EditAttrs["class"] = "form-control";
			$this->no_spm->EditCustomAttributes = "";
			$this->no_spm->EditValue = ew_HtmlEncode($this->no_spm->CurrentValue);
			$this->no_spm->PlaceHolder = ew_RemoveHtml($this->no_spm->FldCaption());

			// tgl_spm
			$this->tgl_spm->EditAttrs["class"] = "form-control";
			$this->tgl_spm->EditCustomAttributes = "";
			$this->tgl_spm->EditValue = ew_HtmlEncode($this->tgl_spm->CurrentValue);
			$this->tgl_spm->PlaceHolder = ew_RemoveHtml($this->tgl_spm->FldCaption());

			// nama_bank
			$this->nama_bank->EditAttrs["class"] = "form-control";
			$this->nama_bank->EditCustomAttributes = "";
			$this->nama_bank->EditValue = ew_HtmlEncode($this->nama_bank->CurrentValue);
			$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

			// nomer_rekening_bank
			$this->nomer_rekening_bank->EditAttrs["class"] = "form-control";
			$this->nomer_rekening_bank->EditCustomAttributes = "";
			$this->nomer_rekening_bank->EditValue = ew_HtmlEncode($this->nomer_rekening_bank->CurrentValue);
			$this->nomer_rekening_bank->PlaceHolder = ew_RemoveHtml($this->nomer_rekening_bank->FldCaption());

			// npwp
			$this->npwp->EditAttrs["class"] = "form-control";
			$this->npwp->EditCustomAttributes = "";
			$this->npwp->EditValue = ew_HtmlEncode($this->npwp->CurrentValue);
			$this->npwp->PlaceHolder = ew_RemoveHtml($this->npwp->FldCaption());

			// pph21
			$this->pph21->EditAttrs["class"] = "form-control";
			$this->pph21->EditCustomAttributes = "";
			$this->pph21->EditValue = ew_HtmlEncode($this->pph21->CurrentValue);
			$this->pph21->PlaceHolder = ew_RemoveHtml($this->pph21->FldCaption());
			if (strval($this->pph21->EditValue) <> "" && is_numeric($this->pph21->EditValue)) $this->pph21->EditValue = ew_FormatNumber($this->pph21->EditValue, -2, -1, -2, 0);

			// pph22
			$this->pph22->EditAttrs["class"] = "form-control";
			$this->pph22->EditCustomAttributes = "";
			$this->pph22->EditValue = ew_HtmlEncode($this->pph22->CurrentValue);
			$this->pph22->PlaceHolder = ew_RemoveHtml($this->pph22->FldCaption());
			if (strval($this->pph22->EditValue) <> "" && is_numeric($this->pph22->EditValue)) $this->pph22->EditValue = ew_FormatNumber($this->pph22->EditValue, -2, -1, -2, 0);

			// pph23
			$this->pph23->EditAttrs["class"] = "form-control";
			$this->pph23->EditCustomAttributes = "";
			$this->pph23->EditValue = ew_HtmlEncode($this->pph23->CurrentValue);
			$this->pph23->PlaceHolder = ew_RemoveHtml($this->pph23->FldCaption());
			if (strval($this->pph23->EditValue) <> "" && is_numeric($this->pph23->EditValue)) $this->pph23->EditValue = ew_FormatNumber($this->pph23->EditValue, -2, -1, -2, 0);

			// pph4
			$this->pph4->EditAttrs["class"] = "form-control";
			$this->pph4->EditCustomAttributes = "";
			$this->pph4->EditValue = ew_HtmlEncode($this->pph4->CurrentValue);
			$this->pph4->PlaceHolder = ew_RemoveHtml($this->pph4->FldCaption());
			if (strval($this->pph4->EditValue) <> "" && is_numeric($this->pph4->EditValue)) $this->pph4->EditValue = ew_FormatNumber($this->pph4->EditValue, -2, -1, -2, 0);

			// jumlah_belanja
			$this->jumlah_belanja->EditAttrs["class"] = "form-control";
			$this->jumlah_belanja->EditCustomAttributes = "";
			$this->jumlah_belanja->EditValue = ew_HtmlEncode($this->jumlah_belanja->CurrentValue);
			$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
			if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

			// kontrak_id
			$this->kontrak_id->EditAttrs["class"] = "form-control";
			$this->kontrak_id->EditCustomAttributes = "";
			$this->kontrak_id->EditValue = ew_HtmlEncode($this->kontrak_id->CurrentValue);
			$this->kontrak_id->PlaceHolder = ew_RemoveHtml($this->kontrak_id->FldCaption());

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

			// opd
			$this->opd->EditAttrs["class"] = "form-control";
			$this->opd->EditCustomAttributes = "";
			$this->opd->EditValue = ew_HtmlEncode($this->opd->CurrentValue);
			$this->opd->PlaceHolder = ew_RemoveHtml($this->opd->FldCaption());

			// urusan_pemerintahan
			$this->urusan_pemerintahan->EditAttrs["class"] = "form-control";
			$this->urusan_pemerintahan->EditCustomAttributes = "";
			$this->urusan_pemerintahan->EditValue = ew_HtmlEncode($this->urusan_pemerintahan->CurrentValue);
			$this->urusan_pemerintahan->PlaceHolder = ew_RemoveHtml($this->urusan_pemerintahan->FldCaption());

			// tgl_sptb
			$this->tgl_sptb->EditAttrs["class"] = "form-control";
			$this->tgl_sptb->EditCustomAttributes = "";
			$this->tgl_sptb->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sptb->CurrentValue, 8));
			$this->tgl_sptb->PlaceHolder = ew_RemoveHtml($this->tgl_sptb->FldCaption());

			// no_sptb
			$this->no_sptb->EditAttrs["class"] = "form-control";
			$this->no_sptb->EditCustomAttributes = "";
			$this->no_sptb->EditValue = ew_HtmlEncode($this->no_sptb->CurrentValue);
			$this->no_sptb->PlaceHolder = ew_RemoveHtml($this->no_sptb->FldCaption());

			// status_advis
			$this->status_advis->EditAttrs["class"] = "form-control";
			$this->status_advis->EditCustomAttributes = "";
			$this->status_advis->EditValue = ew_HtmlEncode($this->status_advis->CurrentValue);
			$this->status_advis->PlaceHolder = ew_RemoveHtml($this->status_advis->FldCaption());

			// id_spj
			$this->id_spj->EditAttrs["class"] = "form-control";
			$this->id_spj->EditCustomAttributes = "";
			$this->id_spj->EditValue = ew_HtmlEncode($this->id_spj->CurrentValue);
			$this->id_spj->PlaceHolder = ew_RemoveHtml($this->id_spj->FldCaption());

			// Add refer script
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

			// jumlah_up
			$this->jumlah_up->LinkCustomAttributes = "";
			$this->jumlah_up->HrefValue = "";

			// bendahara
			$this->bendahara->LinkCustomAttributes = "";
			$this->bendahara->HrefValue = "";

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";

			// status_spm
			$this->status_spm->LinkCustomAttributes = "";
			$this->status_spm->HrefValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";

			// nomer_dasar_spd
			$this->nomer_dasar_spd->LinkCustomAttributes = "";
			$this->nomer_dasar_spd->HrefValue = "";

			// tanggal_spd
			$this->tanggal_spd->LinkCustomAttributes = "";
			$this->tanggal_spd->HrefValue = "";

			// id_spd
			$this->id_spd->LinkCustomAttributes = "";
			$this->id_spd->HrefValue = "";

			// kode_program
			$this->kode_program->LinkCustomAttributes = "";
			$this->kode_program->HrefValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";

			// no_spm
			$this->no_spm->LinkCustomAttributes = "";
			$this->no_spm->HrefValue = "";

			// tgl_spm
			$this->tgl_spm->LinkCustomAttributes = "";
			$this->tgl_spm->HrefValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";

			// nomer_rekening_bank
			$this->nomer_rekening_bank->LinkCustomAttributes = "";
			$this->nomer_rekening_bank->HrefValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";

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

			// kontrak_id
			$this->kontrak_id->LinkCustomAttributes = "";
			$this->kontrak_id->HrefValue = "";

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

			// pimpinan_blud
			$this->pimpinan_blud->LinkCustomAttributes = "";
			$this->pimpinan_blud->HrefValue = "";

			// nip_pimpinan
			$this->nip_pimpinan->LinkCustomAttributes = "";
			$this->nip_pimpinan->HrefValue = "";

			// opd
			$this->opd->LinkCustomAttributes = "";
			$this->opd->HrefValue = "";

			// urusan_pemerintahan
			$this->urusan_pemerintahan->LinkCustomAttributes = "";
			$this->urusan_pemerintahan->HrefValue = "";

			// tgl_sptb
			$this->tgl_sptb->LinkCustomAttributes = "";
			$this->tgl_sptb->HrefValue = "";

			// no_sptb
			$this->no_sptb->LinkCustomAttributes = "";
			$this->no_sptb->HrefValue = "";

			// status_advis
			$this->status_advis->LinkCustomAttributes = "";
			$this->status_advis->HrefValue = "";

			// id_spj
			$this->id_spj->LinkCustomAttributes = "";
			$this->id_spj->HrefValue = "";
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
		if (!ew_CheckInteger($this->bendahara->FormValue)) {
			ew_AddMessage($gsFormError, $this->bendahara->FldErrMsg());
		}
		if (!ew_CheckInteger($this->status_spm->FormValue)) {
			ew_AddMessage($gsFormError, $this->status_spm->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tahun_anggaran->FormValue)) {
			ew_AddMessage($gsFormError, $this->tahun_anggaran->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_spd->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_spd->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_spd->FldErrMsg());
		}
		if (!ew_CheckNumber($this->pph21->FormValue)) {
			ew_AddMessage($gsFormError, $this->pph21->FldErrMsg());
		}
		if (!ew_CheckNumber($this->pph22->FormValue)) {
			ew_AddMessage($gsFormError, $this->pph22->FldErrMsg());
		}
		if (!ew_CheckNumber($this->pph23->FormValue)) {
			ew_AddMessage($gsFormError, $this->pph23->FldErrMsg());
		}
		if (!ew_CheckNumber($this->pph4->FormValue)) {
			ew_AddMessage($gsFormError, $this->pph4->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah_belanja->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_belanja->FldErrMsg());
		}
		if (!ew_CheckInteger($this->kontrak_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->kontrak_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->akun1->FormValue)) {
			ew_AddMessage($gsFormError, $this->akun1->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_sptb->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_sptb->FldErrMsg());
		}
		if (!ew_CheckInteger($this->status_advis->FormValue)) {
			ew_AddMessage($gsFormError, $this->status_advis->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// id_jenis_spp
		$this->id_jenis_spp->SetDbValueDef($rsnew, $this->id_jenis_spp->CurrentValue, NULL, FALSE);

		// detail_jenis_spp
		$this->detail_jenis_spp->SetDbValueDef($rsnew, $this->detail_jenis_spp->CurrentValue, NULL, FALSE);

		// status_spp
		$this->status_spp->SetDbValueDef($rsnew, $this->status_spp->CurrentValue, NULL, FALSE);

		// no_spp
		$this->no_spp->SetDbValueDef($rsnew, $this->no_spp->CurrentValue, NULL, FALSE);

		// tgl_spp
		$this->tgl_spp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7), NULL, FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, FALSE);

		// jumlah_up
		$this->jumlah_up->SetDbValueDef($rsnew, $this->jumlah_up->CurrentValue, NULL, FALSE);

		// bendahara
		$this->bendahara->SetDbValueDef($rsnew, $this->bendahara->CurrentValue, NULL, FALSE);

		// nama_pptk
		$this->nama_pptk->SetDbValueDef($rsnew, $this->nama_pptk->CurrentValue, NULL, FALSE);

		// nip_pptk
		$this->nip_pptk->SetDbValueDef($rsnew, $this->nip_pptk->CurrentValue, NULL, FALSE);

		// status_spm
		$this->status_spm->SetDbValueDef($rsnew, $this->status_spm->CurrentValue, NULL, strval($this->status_spm->CurrentValue) == "");

		// kode_kegiatan
		$this->kode_kegiatan->SetDbValueDef($rsnew, $this->kode_kegiatan->CurrentValue, NULL, FALSE);

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->SetDbValueDef($rsnew, $this->kode_sub_kegiatan->CurrentValue, NULL, FALSE);

		// tahun_anggaran
		$this->tahun_anggaran->SetDbValueDef($rsnew, $this->tahun_anggaran->CurrentValue, NULL, strval($this->tahun_anggaran->CurrentValue) == "");

		// jumlah_spd
		$this->jumlah_spd->SetDbValueDef($rsnew, $this->jumlah_spd->CurrentValue, NULL, FALSE);

		// nomer_dasar_spd
		$this->nomer_dasar_spd->SetDbValueDef($rsnew, $this->nomer_dasar_spd->CurrentValue, NULL, FALSE);

		// tanggal_spd
		$this->tanggal_spd->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0), NULL, FALSE);

		// id_spd
		$this->id_spd->SetDbValueDef($rsnew, $this->id_spd->CurrentValue, NULL, FALSE);

		// kode_program
		$this->kode_program->SetDbValueDef($rsnew, $this->kode_program->CurrentValue, NULL, FALSE);

		// kode_rekening
		$this->kode_rekening->SetDbValueDef($rsnew, $this->kode_rekening->CurrentValue, NULL, FALSE);

		// nama_bendahara
		$this->nama_bendahara->SetDbValueDef($rsnew, $this->nama_bendahara->CurrentValue, NULL, FALSE);

		// nip_bendahara
		$this->nip_bendahara->SetDbValueDef($rsnew, $this->nip_bendahara->CurrentValue, NULL, FALSE);

		// no_spm
		$this->no_spm->SetDbValueDef($rsnew, $this->no_spm->CurrentValue, NULL, FALSE);

		// tgl_spm
		$this->tgl_spm->SetDbValueDef($rsnew, $this->tgl_spm->CurrentValue, NULL, FALSE);

		// nama_bank
		$this->nama_bank->SetDbValueDef($rsnew, $this->nama_bank->CurrentValue, NULL, FALSE);

		// nomer_rekening_bank
		$this->nomer_rekening_bank->SetDbValueDef($rsnew, $this->nomer_rekening_bank->CurrentValue, NULL, FALSE);

		// npwp
		$this->npwp->SetDbValueDef($rsnew, $this->npwp->CurrentValue, NULL, FALSE);

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

		// kontrak_id
		$this->kontrak_id->SetDbValueDef($rsnew, $this->kontrak_id->CurrentValue, NULL, FALSE);

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

		// pimpinan_blud
		$this->pimpinan_blud->SetDbValueDef($rsnew, $this->pimpinan_blud->CurrentValue, NULL, FALSE);

		// nip_pimpinan
		$this->nip_pimpinan->SetDbValueDef($rsnew, $this->nip_pimpinan->CurrentValue, NULL, FALSE);

		// opd
		$this->opd->SetDbValueDef($rsnew, $this->opd->CurrentValue, NULL, strval($this->opd->CurrentValue) == "");

		// urusan_pemerintahan
		$this->urusan_pemerintahan->SetDbValueDef($rsnew, $this->urusan_pemerintahan->CurrentValue, NULL, strval($this->urusan_pemerintahan->CurrentValue) == "");

		// tgl_sptb
		$this->tgl_sptb->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sptb->CurrentValue, 0), NULL, FALSE);

		// no_sptb
		$this->no_sptb->SetDbValueDef($rsnew, $this->no_sptb->CurrentValue, NULL, FALSE);

		// status_advis
		$this->status_advis->SetDbValueDef($rsnew, $this->status_advis->CurrentValue, NULL, strval($this->status_advis->CurrentValue) == "");

		// id_spj
		$this->id_spj->SetDbValueDef($rsnew, $this->id_spj->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_spplist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
			$sWhereWrk = "{filter}";
			$this->detail_jenis_spp->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`id_jenis` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t_spp_add)) $t_spp_add = new ct_spp_add();

// Page init
$t_spp_add->Page_Init();

// Page main
$t_spp_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_spp_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_sppadd = new ew_Form("ft_sppadd", "add");

// Validate form
ft_sppadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->tgl_spp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_up");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->jumlah_up->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bendahara");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->bendahara->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_spm");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->status_spm->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tahun_anggaran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->tahun_anggaran->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_spd");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->jumlah_spd->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_spd");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->tanggal_spd->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_spd");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->id_spd->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pph21");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->pph21->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pph22");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->pph22->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pph23");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->pph23->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pph4");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->pph4->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->jumlah_belanja->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kontrak_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->kontrak_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_akun1");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->akun1->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_sptb");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->tgl_sptb->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_advis");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->status_advis->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_spj");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spp->id_spj->FldErrMsg()) ?>");

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
ft_sppadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sppadd.ValidateRequired = true;
<?php } else { ?>
ft_sppadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sppadd.Lists["x_id_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_spp","","",""],"ParentFields":[],"ChildFields":["x_detail_jenis_spp"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_spp"};
ft_sppadd.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":["x_id_jenis_spp"],"ChildFields":[],"FilterFields":["x_id_jenis"],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
ft_sppadd.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sppadd.Lists["x_status_spp"].Options = <?php echo json_encode($t_spp->status_spp->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_spp_add->IsModal) { ?>
<?php } ?>
<?php $t_spp_add->ShowPageHeader(); ?>
<?php
$t_spp_add->ShowMessage();
?>
<form name="ft_sppadd" id="ft_sppadd" class="<?php echo $t_spp_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_spp_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_spp_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_spp">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_spp_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_spp->id_jenis_spp->Visible) { // id_jenis_spp ?>
	<div id="r_id_jenis_spp" class="form-group">
		<label id="elh_t_spp_id_jenis_spp" for="x_id_jenis_spp" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->id_jenis_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->id_jenis_spp->CellAttributes() ?>>
<span id="el_t_spp_id_jenis_spp">
<?php $t_spp->id_jenis_spp->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_spp->id_jenis_spp->EditAttrs["onchange"]; ?>
<select data-table="t_spp" data-field="x_id_jenis_spp" data-value-separator="<?php echo $t_spp->id_jenis_spp->DisplayValueSeparatorAttribute() ?>" id="x_id_jenis_spp" name="x_id_jenis_spp"<?php echo $t_spp->id_jenis_spp->EditAttributes() ?>>
<?php echo $t_spp->id_jenis_spp->SelectOptionListHtml("x_id_jenis_spp") ?>
</select>
<input type="hidden" name="s_x_id_jenis_spp" id="s_x_id_jenis_spp" value="<?php echo $t_spp->id_jenis_spp->LookupFilterQuery() ?>">
</span>
<?php echo $t_spp->id_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<div id="r_detail_jenis_spp" class="form-group">
		<label id="elh_t_spp_detail_jenis_spp" for="x_detail_jenis_spp" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->detail_jenis_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->detail_jenis_spp->CellAttributes() ?>>
<span id="el_t_spp_detail_jenis_spp">
<select data-table="t_spp" data-field="x_detail_jenis_spp" data-value-separator="<?php echo $t_spp->detail_jenis_spp->DisplayValueSeparatorAttribute() ?>" id="x_detail_jenis_spp" name="x_detail_jenis_spp"<?php echo $t_spp->detail_jenis_spp->EditAttributes() ?>>
<?php echo $t_spp->detail_jenis_spp->SelectOptionListHtml("x_detail_jenis_spp") ?>
</select>
<input type="hidden" name="s_x_detail_jenis_spp" id="s_x_detail_jenis_spp" value="<?php echo $t_spp->detail_jenis_spp->LookupFilterQuery() ?>">
</span>
<?php echo $t_spp->detail_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->status_spp->Visible) { // status_spp ?>
	<div id="r_status_spp" class="form-group">
		<label id="elh_t_spp_status_spp" for="x_status_spp" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->status_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->status_spp->CellAttributes() ?>>
<span id="el_t_spp_status_spp">
<select data-table="t_spp" data-field="x_status_spp" data-value-separator="<?php echo $t_spp->status_spp->DisplayValueSeparatorAttribute() ?>" id="x_status_spp" name="x_status_spp"<?php echo $t_spp->status_spp->EditAttributes() ?>>
<?php echo $t_spp->status_spp->SelectOptionListHtml("x_status_spp") ?>
</select>
</span>
<?php echo $t_spp->status_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->no_spp->Visible) { // no_spp ?>
	<div id="r_no_spp" class="form-group">
		<label id="elh_t_spp_no_spp" for="x_no_spp" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->no_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->no_spp->CellAttributes() ?>>
<span id="el_t_spp_no_spp">
<input type="text" data-table="t_spp" data-field="x_no_spp" name="x_no_spp" id="x_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->no_spp->getPlaceHolder()) ?>" value="<?php echo $t_spp->no_spp->EditValue ?>"<?php echo $t_spp->no_spp->EditAttributes() ?>>
</span>
<?php echo $t_spp->no_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->tgl_spp->Visible) { // tgl_spp ?>
	<div id="r_tgl_spp" class="form-group">
		<label id="elh_t_spp_tgl_spp" for="x_tgl_spp" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->tgl_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->tgl_spp->CellAttributes() ?>>
<span id="el_t_spp_tgl_spp">
<input type="text" data-table="t_spp" data-field="x_tgl_spp" data-format="7" name="x_tgl_spp" id="x_tgl_spp" placeholder="<?php echo ew_HtmlEncode($t_spp->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $t_spp->tgl_spp->EditValue ?>"<?php echo $t_spp->tgl_spp->EditAttributes() ?>>
<?php if (!$t_spp->tgl_spp->ReadOnly && !$t_spp->tgl_spp->Disabled && !isset($t_spp->tgl_spp->EditAttrs["readonly"]) && !isset($t_spp->tgl_spp->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_sppadd", "x_tgl_spp", 7);
</script>
<?php } ?>
</span>
<?php echo $t_spp->tgl_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_t_spp_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->keterangan->CellAttributes() ?>>
<span id="el_t_spp_keterangan">
<input type="text" data-table="t_spp" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->keterangan->getPlaceHolder()) ?>" value="<?php echo $t_spp->keterangan->EditValue ?>"<?php echo $t_spp->keterangan->EditAttributes() ?>>
</span>
<?php echo $t_spp->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->jumlah_up->Visible) { // jumlah_up ?>
	<div id="r_jumlah_up" class="form-group">
		<label id="elh_t_spp_jumlah_up" for="x_jumlah_up" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->jumlah_up->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->jumlah_up->CellAttributes() ?>>
<span id="el_t_spp_jumlah_up">
<input type="text" data-table="t_spp" data-field="x_jumlah_up" name="x_jumlah_up" id="x_jumlah_up" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->jumlah_up->getPlaceHolder()) ?>" value="<?php echo $t_spp->jumlah_up->EditValue ?>"<?php echo $t_spp->jumlah_up->EditAttributes() ?>>
</span>
<?php echo $t_spp->jumlah_up->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->bendahara->Visible) { // bendahara ?>
	<div id="r_bendahara" class="form-group">
		<label id="elh_t_spp_bendahara" for="x_bendahara" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->bendahara->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->bendahara->CellAttributes() ?>>
<span id="el_t_spp_bendahara">
<input type="text" data-table="t_spp" data-field="x_bendahara" name="x_bendahara" id="x_bendahara" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->bendahara->getPlaceHolder()) ?>" value="<?php echo $t_spp->bendahara->EditValue ?>"<?php echo $t_spp->bendahara->EditAttributes() ?>>
</span>
<?php echo $t_spp->bendahara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nama_pptk->Visible) { // nama_pptk ?>
	<div id="r_nama_pptk" class="form-group">
		<label id="elh_t_spp_nama_pptk" for="x_nama_pptk" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nama_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nama_pptk->CellAttributes() ?>>
<span id="el_t_spp_nama_pptk">
<input type="text" data-table="t_spp" data-field="x_nama_pptk" name="x_nama_pptk" id="x_nama_pptk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nama_pptk->getPlaceHolder()) ?>" value="<?php echo $t_spp->nama_pptk->EditValue ?>"<?php echo $t_spp->nama_pptk->EditAttributes() ?>>
</span>
<?php echo $t_spp->nama_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nip_pptk->Visible) { // nip_pptk ?>
	<div id="r_nip_pptk" class="form-group">
		<label id="elh_t_spp_nip_pptk" for="x_nip_pptk" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nip_pptk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nip_pptk->CellAttributes() ?>>
<span id="el_t_spp_nip_pptk">
<input type="text" data-table="t_spp" data-field="x_nip_pptk" name="x_nip_pptk" id="x_nip_pptk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nip_pptk->getPlaceHolder()) ?>" value="<?php echo $t_spp->nip_pptk->EditValue ?>"<?php echo $t_spp->nip_pptk->EditAttributes() ?>>
</span>
<?php echo $t_spp->nip_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->status_spm->Visible) { // status_spm ?>
	<div id="r_status_spm" class="form-group">
		<label id="elh_t_spp_status_spm" for="x_status_spm" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->status_spm->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->status_spm->CellAttributes() ?>>
<span id="el_t_spp_status_spm">
<input type="text" data-table="t_spp" data-field="x_status_spm" name="x_status_spm" id="x_status_spm" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->status_spm->getPlaceHolder()) ?>" value="<?php echo $t_spp->status_spm->EditValue ?>"<?php echo $t_spp->status_spm->EditAttributes() ?>>
</span>
<?php echo $t_spp->status_spm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<div id="r_kode_kegiatan" class="form-group">
		<label id="elh_t_spp_kode_kegiatan" for="x_kode_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->kode_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->kode_kegiatan->CellAttributes() ?>>
<span id="el_t_spp_kode_kegiatan">
<input type="text" data-table="t_spp" data-field="x_kode_kegiatan" name="x_kode_kegiatan" id="x_kode_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->kode_kegiatan->getPlaceHolder()) ?>" value="<?php echo $t_spp->kode_kegiatan->EditValue ?>"<?php echo $t_spp->kode_kegiatan->EditAttributes() ?>>
</span>
<?php echo $t_spp->kode_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
	<div id="r_kode_sub_kegiatan" class="form-group">
		<label id="elh_t_spp_kode_sub_kegiatan" for="x_kode_sub_kegiatan" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->kode_sub_kegiatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->kode_sub_kegiatan->CellAttributes() ?>>
<span id="el_t_spp_kode_sub_kegiatan">
<input type="text" data-table="t_spp" data-field="x_kode_sub_kegiatan" name="x_kode_sub_kegiatan" id="x_kode_sub_kegiatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->kode_sub_kegiatan->getPlaceHolder()) ?>" value="<?php echo $t_spp->kode_sub_kegiatan->EditValue ?>"<?php echo $t_spp->kode_sub_kegiatan->EditAttributes() ?>>
</span>
<?php echo $t_spp->kode_sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<div id="r_tahun_anggaran" class="form-group">
		<label id="elh_t_spp_tahun_anggaran" for="x_tahun_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->tahun_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->tahun_anggaran->CellAttributes() ?>>
<span id="el_t_spp_tahun_anggaran">
<input type="text" data-table="t_spp" data-field="x_tahun_anggaran" name="x_tahun_anggaran" id="x_tahun_anggaran" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->tahun_anggaran->getPlaceHolder()) ?>" value="<?php echo $t_spp->tahun_anggaran->EditValue ?>"<?php echo $t_spp->tahun_anggaran->EditAttributes() ?>>
</span>
<?php echo $t_spp->tahun_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->jumlah_spd->Visible) { // jumlah_spd ?>
	<div id="r_jumlah_spd" class="form-group">
		<label id="elh_t_spp_jumlah_spd" for="x_jumlah_spd" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->jumlah_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->jumlah_spd->CellAttributes() ?>>
<span id="el_t_spp_jumlah_spd">
<input type="text" data-table="t_spp" data-field="x_jumlah_spd" name="x_jumlah_spd" id="x_jumlah_spd" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->jumlah_spd->getPlaceHolder()) ?>" value="<?php echo $t_spp->jumlah_spd->EditValue ?>"<?php echo $t_spp->jumlah_spd->EditAttributes() ?>>
</span>
<?php echo $t_spp->jumlah_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nomer_dasar_spd->Visible) { // nomer_dasar_spd ?>
	<div id="r_nomer_dasar_spd" class="form-group">
		<label id="elh_t_spp_nomer_dasar_spd" for="x_nomer_dasar_spd" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nomer_dasar_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nomer_dasar_spd->CellAttributes() ?>>
<span id="el_t_spp_nomer_dasar_spd">
<input type="text" data-table="t_spp" data-field="x_nomer_dasar_spd" name="x_nomer_dasar_spd" id="x_nomer_dasar_spd" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nomer_dasar_spd->getPlaceHolder()) ?>" value="<?php echo $t_spp->nomer_dasar_spd->EditValue ?>"<?php echo $t_spp->nomer_dasar_spd->EditAttributes() ?>>
</span>
<?php echo $t_spp->nomer_dasar_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->tanggal_spd->Visible) { // tanggal_spd ?>
	<div id="r_tanggal_spd" class="form-group">
		<label id="elh_t_spp_tanggal_spd" for="x_tanggal_spd" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->tanggal_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->tanggal_spd->CellAttributes() ?>>
<span id="el_t_spp_tanggal_spd">
<input type="text" data-table="t_spp" data-field="x_tanggal_spd" name="x_tanggal_spd" id="x_tanggal_spd" placeholder="<?php echo ew_HtmlEncode($t_spp->tanggal_spd->getPlaceHolder()) ?>" value="<?php echo $t_spp->tanggal_spd->EditValue ?>"<?php echo $t_spp->tanggal_spd->EditAttributes() ?>>
</span>
<?php echo $t_spp->tanggal_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->id_spd->Visible) { // id_spd ?>
	<div id="r_id_spd" class="form-group">
		<label id="elh_t_spp_id_spd" for="x_id_spd" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->id_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->id_spd->CellAttributes() ?>>
<span id="el_t_spp_id_spd">
<input type="text" data-table="t_spp" data-field="x_id_spd" name="x_id_spd" id="x_id_spd" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->id_spd->getPlaceHolder()) ?>" value="<?php echo $t_spp->id_spd->EditValue ?>"<?php echo $t_spp->id_spd->EditAttributes() ?>>
</span>
<?php echo $t_spp->id_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->kode_program->Visible) { // kode_program ?>
	<div id="r_kode_program" class="form-group">
		<label id="elh_t_spp_kode_program" for="x_kode_program" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->kode_program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->kode_program->CellAttributes() ?>>
<span id="el_t_spp_kode_program">
<input type="text" data-table="t_spp" data-field="x_kode_program" name="x_kode_program" id="x_kode_program" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->kode_program->getPlaceHolder()) ?>" value="<?php echo $t_spp->kode_program->EditValue ?>"<?php echo $t_spp->kode_program->EditAttributes() ?>>
</span>
<?php echo $t_spp->kode_program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->kode_rekening->Visible) { // kode_rekening ?>
	<div id="r_kode_rekening" class="form-group">
		<label id="elh_t_spp_kode_rekening" for="x_kode_rekening" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->kode_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->kode_rekening->CellAttributes() ?>>
<span id="el_t_spp_kode_rekening">
<input type="text" data-table="t_spp" data-field="x_kode_rekening" name="x_kode_rekening" id="x_kode_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->kode_rekening->getPlaceHolder()) ?>" value="<?php echo $t_spp->kode_rekening->EditValue ?>"<?php echo $t_spp->kode_rekening->EditAttributes() ?>>
</span>
<?php echo $t_spp->kode_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nama_bendahara->Visible) { // nama_bendahara ?>
	<div id="r_nama_bendahara" class="form-group">
		<label id="elh_t_spp_nama_bendahara" for="x_nama_bendahara" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nama_bendahara->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nama_bendahara->CellAttributes() ?>>
<span id="el_t_spp_nama_bendahara">
<input type="text" data-table="t_spp" data-field="x_nama_bendahara" name="x_nama_bendahara" id="x_nama_bendahara" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nama_bendahara->getPlaceHolder()) ?>" value="<?php echo $t_spp->nama_bendahara->EditValue ?>"<?php echo $t_spp->nama_bendahara->EditAttributes() ?>>
</span>
<?php echo $t_spp->nama_bendahara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nip_bendahara->Visible) { // nip_bendahara ?>
	<div id="r_nip_bendahara" class="form-group">
		<label id="elh_t_spp_nip_bendahara" for="x_nip_bendahara" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nip_bendahara->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nip_bendahara->CellAttributes() ?>>
<span id="el_t_spp_nip_bendahara">
<input type="text" data-table="t_spp" data-field="x_nip_bendahara" name="x_nip_bendahara" id="x_nip_bendahara" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nip_bendahara->getPlaceHolder()) ?>" value="<?php echo $t_spp->nip_bendahara->EditValue ?>"<?php echo $t_spp->nip_bendahara->EditAttributes() ?>>
</span>
<?php echo $t_spp->nip_bendahara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->no_spm->Visible) { // no_spm ?>
	<div id="r_no_spm" class="form-group">
		<label id="elh_t_spp_no_spm" for="x_no_spm" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->no_spm->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->no_spm->CellAttributes() ?>>
<span id="el_t_spp_no_spm">
<input type="text" data-table="t_spp" data-field="x_no_spm" name="x_no_spm" id="x_no_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->no_spm->getPlaceHolder()) ?>" value="<?php echo $t_spp->no_spm->EditValue ?>"<?php echo $t_spp->no_spm->EditAttributes() ?>>
</span>
<?php echo $t_spp->no_spm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->tgl_spm->Visible) { // tgl_spm ?>
	<div id="r_tgl_spm" class="form-group">
		<label id="elh_t_spp_tgl_spm" for="x_tgl_spm" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->tgl_spm->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->tgl_spm->CellAttributes() ?>>
<span id="el_t_spp_tgl_spm">
<input type="text" data-table="t_spp" data-field="x_tgl_spm" name="x_tgl_spm" id="x_tgl_spm" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->tgl_spm->getPlaceHolder()) ?>" value="<?php echo $t_spp->tgl_spm->EditValue ?>"<?php echo $t_spp->tgl_spm->EditAttributes() ?>>
</span>
<?php echo $t_spp->tgl_spm->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nama_bank->Visible) { // nama_bank ?>
	<div id="r_nama_bank" class="form-group">
		<label id="elh_t_spp_nama_bank" for="x_nama_bank" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nama_bank->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nama_bank->CellAttributes() ?>>
<span id="el_t_spp_nama_bank">
<input type="text" data-table="t_spp" data-field="x_nama_bank" name="x_nama_bank" id="x_nama_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nama_bank->getPlaceHolder()) ?>" value="<?php echo $t_spp->nama_bank->EditValue ?>"<?php echo $t_spp->nama_bank->EditAttributes() ?>>
</span>
<?php echo $t_spp->nama_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nomer_rekening_bank->Visible) { // nomer_rekening_bank ?>
	<div id="r_nomer_rekening_bank" class="form-group">
		<label id="elh_t_spp_nomer_rekening_bank" for="x_nomer_rekening_bank" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nomer_rekening_bank->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nomer_rekening_bank->CellAttributes() ?>>
<span id="el_t_spp_nomer_rekening_bank">
<input type="text" data-table="t_spp" data-field="x_nomer_rekening_bank" name="x_nomer_rekening_bank" id="x_nomer_rekening_bank" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nomer_rekening_bank->getPlaceHolder()) ?>" value="<?php echo $t_spp->nomer_rekening_bank->EditValue ?>"<?php echo $t_spp->nomer_rekening_bank->EditAttributes() ?>>
</span>
<?php echo $t_spp->nomer_rekening_bank->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->npwp->Visible) { // npwp ?>
	<div id="r_npwp" class="form-group">
		<label id="elh_t_spp_npwp" for="x_npwp" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->npwp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->npwp->CellAttributes() ?>>
<span id="el_t_spp_npwp">
<input type="text" data-table="t_spp" data-field="x_npwp" name="x_npwp" id="x_npwp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->npwp->getPlaceHolder()) ?>" value="<?php echo $t_spp->npwp->EditValue ?>"<?php echo $t_spp->npwp->EditAttributes() ?>>
</span>
<?php echo $t_spp->npwp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->pph21->Visible) { // pph21 ?>
	<div id="r_pph21" class="form-group">
		<label id="elh_t_spp_pph21" for="x_pph21" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->pph21->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->pph21->CellAttributes() ?>>
<span id="el_t_spp_pph21">
<input type="text" data-table="t_spp" data-field="x_pph21" name="x_pph21" id="x_pph21" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->pph21->getPlaceHolder()) ?>" value="<?php echo $t_spp->pph21->EditValue ?>"<?php echo $t_spp->pph21->EditAttributes() ?>>
</span>
<?php echo $t_spp->pph21->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->pph22->Visible) { // pph22 ?>
	<div id="r_pph22" class="form-group">
		<label id="elh_t_spp_pph22" for="x_pph22" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->pph22->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->pph22->CellAttributes() ?>>
<span id="el_t_spp_pph22">
<input type="text" data-table="t_spp" data-field="x_pph22" name="x_pph22" id="x_pph22" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->pph22->getPlaceHolder()) ?>" value="<?php echo $t_spp->pph22->EditValue ?>"<?php echo $t_spp->pph22->EditAttributes() ?>>
</span>
<?php echo $t_spp->pph22->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->pph23->Visible) { // pph23 ?>
	<div id="r_pph23" class="form-group">
		<label id="elh_t_spp_pph23" for="x_pph23" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->pph23->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->pph23->CellAttributes() ?>>
<span id="el_t_spp_pph23">
<input type="text" data-table="t_spp" data-field="x_pph23" name="x_pph23" id="x_pph23" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->pph23->getPlaceHolder()) ?>" value="<?php echo $t_spp->pph23->EditValue ?>"<?php echo $t_spp->pph23->EditAttributes() ?>>
</span>
<?php echo $t_spp->pph23->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->pph4->Visible) { // pph4 ?>
	<div id="r_pph4" class="form-group">
		<label id="elh_t_spp_pph4" for="x_pph4" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->pph4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->pph4->CellAttributes() ?>>
<span id="el_t_spp_pph4">
<input type="text" data-table="t_spp" data-field="x_pph4" name="x_pph4" id="x_pph4" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->pph4->getPlaceHolder()) ?>" value="<?php echo $t_spp->pph4->EditValue ?>"<?php echo $t_spp->pph4->EditAttributes() ?>>
</span>
<?php echo $t_spp->pph4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<div id="r_jumlah_belanja" class="form-group">
		<label id="elh_t_spp_jumlah_belanja" for="x_jumlah_belanja" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->jumlah_belanja->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->jumlah_belanja->CellAttributes() ?>>
<span id="el_t_spp_jumlah_belanja">
<input type="text" data-table="t_spp" data-field="x_jumlah_belanja" name="x_jumlah_belanja" id="x_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $t_spp->jumlah_belanja->EditValue ?>"<?php echo $t_spp->jumlah_belanja->EditAttributes() ?>>
</span>
<?php echo $t_spp->jumlah_belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->kontrak_id->Visible) { // kontrak_id ?>
	<div id="r_kontrak_id" class="form-group">
		<label id="elh_t_spp_kontrak_id" for="x_kontrak_id" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->kontrak_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->kontrak_id->CellAttributes() ?>>
<span id="el_t_spp_kontrak_id">
<input type="text" data-table="t_spp" data-field="x_kontrak_id" name="x_kontrak_id" id="x_kontrak_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->kontrak_id->getPlaceHolder()) ?>" value="<?php echo $t_spp->kontrak_id->EditValue ?>"<?php echo $t_spp->kontrak_id->EditAttributes() ?>>
</span>
<?php echo $t_spp->kontrak_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->akun1->Visible) { // akun1 ?>
	<div id="r_akun1" class="form-group">
		<label id="elh_t_spp_akun1" for="x_akun1" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->akun1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->akun1->CellAttributes() ?>>
<span id="el_t_spp_akun1">
<input type="text" data-table="t_spp" data-field="x_akun1" name="x_akun1" id="x_akun1" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->akun1->getPlaceHolder()) ?>" value="<?php echo $t_spp->akun1->EditValue ?>"<?php echo $t_spp->akun1->EditAttributes() ?>>
</span>
<?php echo $t_spp->akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->akun2->Visible) { // akun2 ?>
	<div id="r_akun2" class="form-group">
		<label id="elh_t_spp_akun2" for="x_akun2" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->akun2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->akun2->CellAttributes() ?>>
<span id="el_t_spp_akun2">
<input type="text" data-table="t_spp" data-field="x_akun2" name="x_akun2" id="x_akun2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->akun2->getPlaceHolder()) ?>" value="<?php echo $t_spp->akun2->EditValue ?>"<?php echo $t_spp->akun2->EditAttributes() ?>>
</span>
<?php echo $t_spp->akun2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->akun3->Visible) { // akun3 ?>
	<div id="r_akun3" class="form-group">
		<label id="elh_t_spp_akun3" for="x_akun3" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->akun3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->akun3->CellAttributes() ?>>
<span id="el_t_spp_akun3">
<input type="text" data-table="t_spp" data-field="x_akun3" name="x_akun3" id="x_akun3" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->akun3->getPlaceHolder()) ?>" value="<?php echo $t_spp->akun3->EditValue ?>"<?php echo $t_spp->akun3->EditAttributes() ?>>
</span>
<?php echo $t_spp->akun3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->akun4->Visible) { // akun4 ?>
	<div id="r_akun4" class="form-group">
		<label id="elh_t_spp_akun4" for="x_akun4" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->akun4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->akun4->CellAttributes() ?>>
<span id="el_t_spp_akun4">
<input type="text" data-table="t_spp" data-field="x_akun4" name="x_akun4" id="x_akun4" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->akun4->getPlaceHolder()) ?>" value="<?php echo $t_spp->akun4->EditValue ?>"<?php echo $t_spp->akun4->EditAttributes() ?>>
</span>
<?php echo $t_spp->akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->akun5->Visible) { // akun5 ?>
	<div id="r_akun5" class="form-group">
		<label id="elh_t_spp_akun5" for="x_akun5" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->akun5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->akun5->CellAttributes() ?>>
<span id="el_t_spp_akun5">
<input type="text" data-table="t_spp" data-field="x_akun5" name="x_akun5" id="x_akun5" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->akun5->getPlaceHolder()) ?>" value="<?php echo $t_spp->akun5->EditValue ?>"<?php echo $t_spp->akun5->EditAttributes() ?>>
</span>
<?php echo $t_spp->akun5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->pimpinan_blud->Visible) { // pimpinan_blud ?>
	<div id="r_pimpinan_blud" class="form-group">
		<label id="elh_t_spp_pimpinan_blud" for="x_pimpinan_blud" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->pimpinan_blud->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->pimpinan_blud->CellAttributes() ?>>
<span id="el_t_spp_pimpinan_blud">
<input type="text" data-table="t_spp" data-field="x_pimpinan_blud" name="x_pimpinan_blud" id="x_pimpinan_blud" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->pimpinan_blud->getPlaceHolder()) ?>" value="<?php echo $t_spp->pimpinan_blud->EditValue ?>"<?php echo $t_spp->pimpinan_blud->EditAttributes() ?>>
</span>
<?php echo $t_spp->pimpinan_blud->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->nip_pimpinan->Visible) { // nip_pimpinan ?>
	<div id="r_nip_pimpinan" class="form-group">
		<label id="elh_t_spp_nip_pimpinan" for="x_nip_pimpinan" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->nip_pimpinan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->nip_pimpinan->CellAttributes() ?>>
<span id="el_t_spp_nip_pimpinan">
<input type="text" data-table="t_spp" data-field="x_nip_pimpinan" name="x_nip_pimpinan" id="x_nip_pimpinan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->nip_pimpinan->getPlaceHolder()) ?>" value="<?php echo $t_spp->nip_pimpinan->EditValue ?>"<?php echo $t_spp->nip_pimpinan->EditAttributes() ?>>
</span>
<?php echo $t_spp->nip_pimpinan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->opd->Visible) { // opd ?>
	<div id="r_opd" class="form-group">
		<label id="elh_t_spp_opd" for="x_opd" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->opd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->opd->CellAttributes() ?>>
<span id="el_t_spp_opd">
<input type="text" data-table="t_spp" data-field="x_opd" name="x_opd" id="x_opd" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->opd->getPlaceHolder()) ?>" value="<?php echo $t_spp->opd->EditValue ?>"<?php echo $t_spp->opd->EditAttributes() ?>>
</span>
<?php echo $t_spp->opd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->urusan_pemerintahan->Visible) { // urusan_pemerintahan ?>
	<div id="r_urusan_pemerintahan" class="form-group">
		<label id="elh_t_spp_urusan_pemerintahan" for="x_urusan_pemerintahan" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->urusan_pemerintahan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->urusan_pemerintahan->CellAttributes() ?>>
<span id="el_t_spp_urusan_pemerintahan">
<input type="text" data-table="t_spp" data-field="x_urusan_pemerintahan" name="x_urusan_pemerintahan" id="x_urusan_pemerintahan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->urusan_pemerintahan->getPlaceHolder()) ?>" value="<?php echo $t_spp->urusan_pemerintahan->EditValue ?>"<?php echo $t_spp->urusan_pemerintahan->EditAttributes() ?>>
</span>
<?php echo $t_spp->urusan_pemerintahan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->tgl_sptb->Visible) { // tgl_sptb ?>
	<div id="r_tgl_sptb" class="form-group">
		<label id="elh_t_spp_tgl_sptb" for="x_tgl_sptb" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->tgl_sptb->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->tgl_sptb->CellAttributes() ?>>
<span id="el_t_spp_tgl_sptb">
<input type="text" data-table="t_spp" data-field="x_tgl_sptb" name="x_tgl_sptb" id="x_tgl_sptb" placeholder="<?php echo ew_HtmlEncode($t_spp->tgl_sptb->getPlaceHolder()) ?>" value="<?php echo $t_spp->tgl_sptb->EditValue ?>"<?php echo $t_spp->tgl_sptb->EditAttributes() ?>>
</span>
<?php echo $t_spp->tgl_sptb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->no_sptb->Visible) { // no_sptb ?>
	<div id="r_no_sptb" class="form-group">
		<label id="elh_t_spp_no_sptb" for="x_no_sptb" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->no_sptb->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->no_sptb->CellAttributes() ?>>
<span id="el_t_spp_no_sptb">
<input type="text" data-table="t_spp" data-field="x_no_sptb" name="x_no_sptb" id="x_no_sptb" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spp->no_sptb->getPlaceHolder()) ?>" value="<?php echo $t_spp->no_sptb->EditValue ?>"<?php echo $t_spp->no_sptb->EditAttributes() ?>>
</span>
<?php echo $t_spp->no_sptb->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->status_advis->Visible) { // status_advis ?>
	<div id="r_status_advis" class="form-group">
		<label id="elh_t_spp_status_advis" for="x_status_advis" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->status_advis->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->status_advis->CellAttributes() ?>>
<span id="el_t_spp_status_advis">
<input type="text" data-table="t_spp" data-field="x_status_advis" name="x_status_advis" id="x_status_advis" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->status_advis->getPlaceHolder()) ?>" value="<?php echo $t_spp->status_advis->EditValue ?>"<?php echo $t_spp->status_advis->EditAttributes() ?>>
</span>
<?php echo $t_spp->status_advis->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spp->id_spj->Visible) { // id_spj ?>
	<div id="r_id_spj" class="form-group">
		<label id="elh_t_spp_id_spj" for="x_id_spj" class="col-sm-2 control-label ewLabel"><?php echo $t_spp->id_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spp->id_spj->CellAttributes() ?>>
<span id="el_t_spp_id_spj">
<input type="text" data-table="t_spp" data-field="x_id_spj" name="x_id_spj" id="x_id_spj" size="30" placeholder="<?php echo ew_HtmlEncode($t_spp->id_spj->getPlaceHolder()) ?>" value="<?php echo $t_spp->id_spj->EditValue ?>"<?php echo $t_spp->id_spj->EditAttributes() ?>>
</span>
<?php echo $t_spp->id_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_spp_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_spp_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_sppadd.Init();
</script>
<?php
$t_spp_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_spp_add->Page_Terminate();
?>
