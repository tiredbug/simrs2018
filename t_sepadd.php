<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_sepinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_sep_add = NULL; // Initialize page object first

class ct_sep_add extends ct_sep {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sep';

	// Page object name
	var $PageObjName = 't_sep_add';

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

		// Table object (t_sep)
		if (!isset($GLOBALS["t_sep"]) || get_class($GLOBALS["t_sep"]) == "ct_sep") {
			$GLOBALS["t_sep"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_sep"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_sep', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_seplist.php"));
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
		$this->nomer_sep->SetVisibility();
		$this->nomr->SetVisibility();
		$this->no_kartubpjs->SetVisibility();
		$this->jenis_layanan->SetVisibility();
		$this->tgl_sep->SetVisibility();
		$this->tgl_rujukan->SetVisibility();
		$this->kelas_rawat->SetVisibility();
		$this->no_rujukan->SetVisibility();
		$this->ppk_asal->SetVisibility();
		$this->nama_ppk->SetVisibility();
		$this->ppk_pelayanan->SetVisibility();
		$this->catatan->SetVisibility();
		$this->kode_diagnosaawal->SetVisibility();
		$this->nama_diagnosaawal->SetVisibility();
		$this->laka_lantas->SetVisibility();
		$this->lokasi_laka->SetVisibility();
		$this->user->SetVisibility();
		$this->nik->SetVisibility();
		$this->kode_politujuan->SetVisibility();
		$this->nama_politujuan->SetVisibility();
		$this->dpjp->SetVisibility();
		$this->idx->SetVisibility();
		$this->last_update->SetVisibility();
		$this->pasien_baru->SetVisibility();
		$this->cara_bayar->SetVisibility();
		$this->petugas_klaim->SetVisibility();
		$this->total_biaya_rs->SetVisibility();
		$this->total_biaya_rs_adjust->SetVisibility();
		$this->flag_proc->SetVisibility();
		$this->poli_eksekutif->SetVisibility();
		$this->cob->SetVisibility();
		$this->penjamin_laka->SetVisibility();
		$this->no_telp->SetVisibility();
		$this->status_kepesertaan_bpjs->SetVisibility();
		$this->faskes_id->SetVisibility();
		$this->nama_layanan->SetVisibility();
		$this->nama_kelas->SetVisibility();
		$this->table_source->SetVisibility();

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
		global $EW_EXPORT, $t_sep;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_sep);
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
					$this->Page_Terminate("t_seplist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_seplist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_sepview.php")
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
		$this->nomer_sep->CurrentValue = NULL;
		$this->nomer_sep->OldValue = $this->nomer_sep->CurrentValue;
		$this->nomr->CurrentValue = NULL;
		$this->nomr->OldValue = $this->nomr->CurrentValue;
		$this->no_kartubpjs->CurrentValue = NULL;
		$this->no_kartubpjs->OldValue = $this->no_kartubpjs->CurrentValue;
		$this->jenis_layanan->CurrentValue = NULL;
		$this->jenis_layanan->OldValue = $this->jenis_layanan->CurrentValue;
		$this->tgl_sep->CurrentValue = NULL;
		$this->tgl_sep->OldValue = $this->tgl_sep->CurrentValue;
		$this->tgl_rujukan->CurrentValue = NULL;
		$this->tgl_rujukan->OldValue = $this->tgl_rujukan->CurrentValue;
		$this->kelas_rawat->CurrentValue = NULL;
		$this->kelas_rawat->OldValue = $this->kelas_rawat->CurrentValue;
		$this->no_rujukan->CurrentValue = NULL;
		$this->no_rujukan->OldValue = $this->no_rujukan->CurrentValue;
		$this->ppk_asal->CurrentValue = NULL;
		$this->ppk_asal->OldValue = $this->ppk_asal->CurrentValue;
		$this->nama_ppk->CurrentValue = NULL;
		$this->nama_ppk->OldValue = $this->nama_ppk->CurrentValue;
		$this->ppk_pelayanan->CurrentValue = NULL;
		$this->ppk_pelayanan->OldValue = $this->ppk_pelayanan->CurrentValue;
		$this->catatan->CurrentValue = NULL;
		$this->catatan->OldValue = $this->catatan->CurrentValue;
		$this->kode_diagnosaawal->CurrentValue = NULL;
		$this->kode_diagnosaawal->OldValue = $this->kode_diagnosaawal->CurrentValue;
		$this->nama_diagnosaawal->CurrentValue = NULL;
		$this->nama_diagnosaawal->OldValue = $this->nama_diagnosaawal->CurrentValue;
		$this->laka_lantas->CurrentValue = NULL;
		$this->laka_lantas->OldValue = $this->laka_lantas->CurrentValue;
		$this->lokasi_laka->CurrentValue = NULL;
		$this->lokasi_laka->OldValue = $this->lokasi_laka->CurrentValue;
		$this->user->CurrentValue = NULL;
		$this->user->OldValue = $this->user->CurrentValue;
		$this->nik->CurrentValue = NULL;
		$this->nik->OldValue = $this->nik->CurrentValue;
		$this->kode_politujuan->CurrentValue = NULL;
		$this->kode_politujuan->OldValue = $this->kode_politujuan->CurrentValue;
		$this->nama_politujuan->CurrentValue = NULL;
		$this->nama_politujuan->OldValue = $this->nama_politujuan->CurrentValue;
		$this->dpjp->CurrentValue = NULL;
		$this->dpjp->OldValue = $this->dpjp->CurrentValue;
		$this->idx->CurrentValue = NULL;
		$this->idx->OldValue = $this->idx->CurrentValue;
		$this->last_update->CurrentValue = NULL;
		$this->last_update->OldValue = $this->last_update->CurrentValue;
		$this->pasien_baru->CurrentValue = NULL;
		$this->pasien_baru->OldValue = $this->pasien_baru->CurrentValue;
		$this->cara_bayar->CurrentValue = NULL;
		$this->cara_bayar->OldValue = $this->cara_bayar->CurrentValue;
		$this->petugas_klaim->CurrentValue = NULL;
		$this->petugas_klaim->OldValue = $this->petugas_klaim->CurrentValue;
		$this->total_biaya_rs->CurrentValue = 0;
		$this->total_biaya_rs_adjust->CurrentValue = 0;
		$this->flag_proc->CurrentValue = NULL;
		$this->flag_proc->OldValue = $this->flag_proc->CurrentValue;
		$this->poli_eksekutif->CurrentValue = NULL;
		$this->poli_eksekutif->OldValue = $this->poli_eksekutif->CurrentValue;
		$this->cob->CurrentValue = NULL;
		$this->cob->OldValue = $this->cob->CurrentValue;
		$this->penjamin_laka->CurrentValue = NULL;
		$this->penjamin_laka->OldValue = $this->penjamin_laka->CurrentValue;
		$this->no_telp->CurrentValue = NULL;
		$this->no_telp->OldValue = $this->no_telp->CurrentValue;
		$this->status_kepesertaan_bpjs->CurrentValue = NULL;
		$this->status_kepesertaan_bpjs->OldValue = $this->status_kepesertaan_bpjs->CurrentValue;
		$this->faskes_id->CurrentValue = NULL;
		$this->faskes_id->OldValue = $this->faskes_id->CurrentValue;
		$this->nama_layanan->CurrentValue = NULL;
		$this->nama_layanan->OldValue = $this->nama_layanan->CurrentValue;
		$this->nama_kelas->CurrentValue = NULL;
		$this->nama_kelas->OldValue = $this->nama_kelas->CurrentValue;
		$this->table_source->CurrentValue = NULL;
		$this->table_source->OldValue = $this->table_source->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nomer_sep->FldIsDetailKey) {
			$this->nomer_sep->setFormValue($objForm->GetValue("x_nomer_sep"));
		}
		if (!$this->nomr->FldIsDetailKey) {
			$this->nomr->setFormValue($objForm->GetValue("x_nomr"));
		}
		if (!$this->no_kartubpjs->FldIsDetailKey) {
			$this->no_kartubpjs->setFormValue($objForm->GetValue("x_no_kartubpjs"));
		}
		if (!$this->jenis_layanan->FldIsDetailKey) {
			$this->jenis_layanan->setFormValue($objForm->GetValue("x_jenis_layanan"));
		}
		if (!$this->tgl_sep->FldIsDetailKey) {
			$this->tgl_sep->setFormValue($objForm->GetValue("x_tgl_sep"));
			$this->tgl_sep->CurrentValue = ew_UnFormatDateTime($this->tgl_sep->CurrentValue, 0);
		}
		if (!$this->tgl_rujukan->FldIsDetailKey) {
			$this->tgl_rujukan->setFormValue($objForm->GetValue("x_tgl_rujukan"));
			$this->tgl_rujukan->CurrentValue = ew_UnFormatDateTime($this->tgl_rujukan->CurrentValue, 0);
		}
		if (!$this->kelas_rawat->FldIsDetailKey) {
			$this->kelas_rawat->setFormValue($objForm->GetValue("x_kelas_rawat"));
		}
		if (!$this->no_rujukan->FldIsDetailKey) {
			$this->no_rujukan->setFormValue($objForm->GetValue("x_no_rujukan"));
		}
		if (!$this->ppk_asal->FldIsDetailKey) {
			$this->ppk_asal->setFormValue($objForm->GetValue("x_ppk_asal"));
		}
		if (!$this->nama_ppk->FldIsDetailKey) {
			$this->nama_ppk->setFormValue($objForm->GetValue("x_nama_ppk"));
		}
		if (!$this->ppk_pelayanan->FldIsDetailKey) {
			$this->ppk_pelayanan->setFormValue($objForm->GetValue("x_ppk_pelayanan"));
		}
		if (!$this->catatan->FldIsDetailKey) {
			$this->catatan->setFormValue($objForm->GetValue("x_catatan"));
		}
		if (!$this->kode_diagnosaawal->FldIsDetailKey) {
			$this->kode_diagnosaawal->setFormValue($objForm->GetValue("x_kode_diagnosaawal"));
		}
		if (!$this->nama_diagnosaawal->FldIsDetailKey) {
			$this->nama_diagnosaawal->setFormValue($objForm->GetValue("x_nama_diagnosaawal"));
		}
		if (!$this->laka_lantas->FldIsDetailKey) {
			$this->laka_lantas->setFormValue($objForm->GetValue("x_laka_lantas"));
		}
		if (!$this->lokasi_laka->FldIsDetailKey) {
			$this->lokasi_laka->setFormValue($objForm->GetValue("x_lokasi_laka"));
		}
		if (!$this->user->FldIsDetailKey) {
			$this->user->setFormValue($objForm->GetValue("x_user"));
		}
		if (!$this->nik->FldIsDetailKey) {
			$this->nik->setFormValue($objForm->GetValue("x_nik"));
		}
		if (!$this->kode_politujuan->FldIsDetailKey) {
			$this->kode_politujuan->setFormValue($objForm->GetValue("x_kode_politujuan"));
		}
		if (!$this->nama_politujuan->FldIsDetailKey) {
			$this->nama_politujuan->setFormValue($objForm->GetValue("x_nama_politujuan"));
		}
		if (!$this->dpjp->FldIsDetailKey) {
			$this->dpjp->setFormValue($objForm->GetValue("x_dpjp"));
		}
		if (!$this->idx->FldIsDetailKey) {
			$this->idx->setFormValue($objForm->GetValue("x_idx"));
		}
		if (!$this->last_update->FldIsDetailKey) {
			$this->last_update->setFormValue($objForm->GetValue("x_last_update"));
			$this->last_update->CurrentValue = ew_UnFormatDateTime($this->last_update->CurrentValue, 0);
		}
		if (!$this->pasien_baru->FldIsDetailKey) {
			$this->pasien_baru->setFormValue($objForm->GetValue("x_pasien_baru"));
		}
		if (!$this->cara_bayar->FldIsDetailKey) {
			$this->cara_bayar->setFormValue($objForm->GetValue("x_cara_bayar"));
		}
		if (!$this->petugas_klaim->FldIsDetailKey) {
			$this->petugas_klaim->setFormValue($objForm->GetValue("x_petugas_klaim"));
		}
		if (!$this->total_biaya_rs->FldIsDetailKey) {
			$this->total_biaya_rs->setFormValue($objForm->GetValue("x_total_biaya_rs"));
		}
		if (!$this->total_biaya_rs_adjust->FldIsDetailKey) {
			$this->total_biaya_rs_adjust->setFormValue($objForm->GetValue("x_total_biaya_rs_adjust"));
		}
		if (!$this->flag_proc->FldIsDetailKey) {
			$this->flag_proc->setFormValue($objForm->GetValue("x_flag_proc"));
		}
		if (!$this->poli_eksekutif->FldIsDetailKey) {
			$this->poli_eksekutif->setFormValue($objForm->GetValue("x_poli_eksekutif"));
		}
		if (!$this->cob->FldIsDetailKey) {
			$this->cob->setFormValue($objForm->GetValue("x_cob"));
		}
		if (!$this->penjamin_laka->FldIsDetailKey) {
			$this->penjamin_laka->setFormValue($objForm->GetValue("x_penjamin_laka"));
		}
		if (!$this->no_telp->FldIsDetailKey) {
			$this->no_telp->setFormValue($objForm->GetValue("x_no_telp"));
		}
		if (!$this->status_kepesertaan_bpjs->FldIsDetailKey) {
			$this->status_kepesertaan_bpjs->setFormValue($objForm->GetValue("x_status_kepesertaan_bpjs"));
		}
		if (!$this->faskes_id->FldIsDetailKey) {
			$this->faskes_id->setFormValue($objForm->GetValue("x_faskes_id"));
		}
		if (!$this->nama_layanan->FldIsDetailKey) {
			$this->nama_layanan->setFormValue($objForm->GetValue("x_nama_layanan"));
		}
		if (!$this->nama_kelas->FldIsDetailKey) {
			$this->nama_kelas->setFormValue($objForm->GetValue("x_nama_kelas"));
		}
		if (!$this->table_source->FldIsDetailKey) {
			$this->table_source->setFormValue($objForm->GetValue("x_table_source"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nomer_sep->CurrentValue = $this->nomer_sep->FormValue;
		$this->nomr->CurrentValue = $this->nomr->FormValue;
		$this->no_kartubpjs->CurrentValue = $this->no_kartubpjs->FormValue;
		$this->jenis_layanan->CurrentValue = $this->jenis_layanan->FormValue;
		$this->tgl_sep->CurrentValue = $this->tgl_sep->FormValue;
		$this->tgl_sep->CurrentValue = ew_UnFormatDateTime($this->tgl_sep->CurrentValue, 0);
		$this->tgl_rujukan->CurrentValue = $this->tgl_rujukan->FormValue;
		$this->tgl_rujukan->CurrentValue = ew_UnFormatDateTime($this->tgl_rujukan->CurrentValue, 0);
		$this->kelas_rawat->CurrentValue = $this->kelas_rawat->FormValue;
		$this->no_rujukan->CurrentValue = $this->no_rujukan->FormValue;
		$this->ppk_asal->CurrentValue = $this->ppk_asal->FormValue;
		$this->nama_ppk->CurrentValue = $this->nama_ppk->FormValue;
		$this->ppk_pelayanan->CurrentValue = $this->ppk_pelayanan->FormValue;
		$this->catatan->CurrentValue = $this->catatan->FormValue;
		$this->kode_diagnosaawal->CurrentValue = $this->kode_diagnosaawal->FormValue;
		$this->nama_diagnosaawal->CurrentValue = $this->nama_diagnosaawal->FormValue;
		$this->laka_lantas->CurrentValue = $this->laka_lantas->FormValue;
		$this->lokasi_laka->CurrentValue = $this->lokasi_laka->FormValue;
		$this->user->CurrentValue = $this->user->FormValue;
		$this->nik->CurrentValue = $this->nik->FormValue;
		$this->kode_politujuan->CurrentValue = $this->kode_politujuan->FormValue;
		$this->nama_politujuan->CurrentValue = $this->nama_politujuan->FormValue;
		$this->dpjp->CurrentValue = $this->dpjp->FormValue;
		$this->idx->CurrentValue = $this->idx->FormValue;
		$this->last_update->CurrentValue = $this->last_update->FormValue;
		$this->last_update->CurrentValue = ew_UnFormatDateTime($this->last_update->CurrentValue, 0);
		$this->pasien_baru->CurrentValue = $this->pasien_baru->FormValue;
		$this->cara_bayar->CurrentValue = $this->cara_bayar->FormValue;
		$this->petugas_klaim->CurrentValue = $this->petugas_klaim->FormValue;
		$this->total_biaya_rs->CurrentValue = $this->total_biaya_rs->FormValue;
		$this->total_biaya_rs_adjust->CurrentValue = $this->total_biaya_rs_adjust->FormValue;
		$this->flag_proc->CurrentValue = $this->flag_proc->FormValue;
		$this->poli_eksekutif->CurrentValue = $this->poli_eksekutif->FormValue;
		$this->cob->CurrentValue = $this->cob->FormValue;
		$this->penjamin_laka->CurrentValue = $this->penjamin_laka->FormValue;
		$this->no_telp->CurrentValue = $this->no_telp->FormValue;
		$this->status_kepesertaan_bpjs->CurrentValue = $this->status_kepesertaan_bpjs->FormValue;
		$this->faskes_id->CurrentValue = $this->faskes_id->FormValue;
		$this->nama_layanan->CurrentValue = $this->nama_layanan->FormValue;
		$this->nama_kelas->CurrentValue = $this->nama_kelas->FormValue;
		$this->table_source->CurrentValue = $this->table_source->FormValue;
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
		$this->nomer_sep->setDbValue($rs->fields('nomer_sep'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->no_kartubpjs->setDbValue($rs->fields('no_kartubpjs'));
		$this->jenis_layanan->setDbValue($rs->fields('jenis_layanan'));
		$this->tgl_sep->setDbValue($rs->fields('tgl_sep'));
		$this->tgl_rujukan->setDbValue($rs->fields('tgl_rujukan'));
		$this->kelas_rawat->setDbValue($rs->fields('kelas_rawat'));
		$this->no_rujukan->setDbValue($rs->fields('no_rujukan'));
		$this->ppk_asal->setDbValue($rs->fields('ppk_asal'));
		$this->nama_ppk->setDbValue($rs->fields('nama_ppk'));
		$this->ppk_pelayanan->setDbValue($rs->fields('ppk_pelayanan'));
		$this->catatan->setDbValue($rs->fields('catatan'));
		$this->kode_diagnosaawal->setDbValue($rs->fields('kode_diagnosaawal'));
		$this->nama_diagnosaawal->setDbValue($rs->fields('nama_diagnosaawal'));
		$this->laka_lantas->setDbValue($rs->fields('laka_lantas'));
		$this->lokasi_laka->setDbValue($rs->fields('lokasi_laka'));
		$this->user->setDbValue($rs->fields('user'));
		$this->nik->setDbValue($rs->fields('nik'));
		$this->kode_politujuan->setDbValue($rs->fields('kode_politujuan'));
		$this->nama_politujuan->setDbValue($rs->fields('nama_politujuan'));
		$this->dpjp->setDbValue($rs->fields('dpjp'));
		$this->idx->setDbValue($rs->fields('idx'));
		$this->last_update->setDbValue($rs->fields('last_update'));
		$this->pasien_baru->setDbValue($rs->fields('pasien_baru'));
		$this->cara_bayar->setDbValue($rs->fields('cara_bayar'));
		$this->petugas_klaim->setDbValue($rs->fields('petugas_klaim'));
		$this->total_biaya_rs->setDbValue($rs->fields('total_biaya_rs'));
		$this->total_biaya_rs_adjust->setDbValue($rs->fields('total_biaya_rs_adjust'));
		$this->tgl_pulang->setDbValue($rs->fields('tgl_pulang'));
		$this->flag_proc->setDbValue($rs->fields('flag_proc'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->cob->setDbValue($rs->fields('cob'));
		$this->penjamin_laka->setDbValue($rs->fields('penjamin_laka'));
		$this->no_telp->setDbValue($rs->fields('no_telp'));
		$this->status_kepesertaan_bpjs->setDbValue($rs->fields('status_kepesertaan_bpjs'));
		$this->faskes_id->setDbValue($rs->fields('faskes_id'));
		$this->nama_layanan->setDbValue($rs->fields('nama_layanan'));
		$this->nama_kelas->setDbValue($rs->fields('nama_kelas'));
		$this->table_source->setDbValue($rs->fields('table_source'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nomer_sep->DbValue = $row['nomer_sep'];
		$this->nomr->DbValue = $row['nomr'];
		$this->no_kartubpjs->DbValue = $row['no_kartubpjs'];
		$this->jenis_layanan->DbValue = $row['jenis_layanan'];
		$this->tgl_sep->DbValue = $row['tgl_sep'];
		$this->tgl_rujukan->DbValue = $row['tgl_rujukan'];
		$this->kelas_rawat->DbValue = $row['kelas_rawat'];
		$this->no_rujukan->DbValue = $row['no_rujukan'];
		$this->ppk_asal->DbValue = $row['ppk_asal'];
		$this->nama_ppk->DbValue = $row['nama_ppk'];
		$this->ppk_pelayanan->DbValue = $row['ppk_pelayanan'];
		$this->catatan->DbValue = $row['catatan'];
		$this->kode_diagnosaawal->DbValue = $row['kode_diagnosaawal'];
		$this->nama_diagnosaawal->DbValue = $row['nama_diagnosaawal'];
		$this->laka_lantas->DbValue = $row['laka_lantas'];
		$this->lokasi_laka->DbValue = $row['lokasi_laka'];
		$this->user->DbValue = $row['user'];
		$this->nik->DbValue = $row['nik'];
		$this->kode_politujuan->DbValue = $row['kode_politujuan'];
		$this->nama_politujuan->DbValue = $row['nama_politujuan'];
		$this->dpjp->DbValue = $row['dpjp'];
		$this->idx->DbValue = $row['idx'];
		$this->last_update->DbValue = $row['last_update'];
		$this->pasien_baru->DbValue = $row['pasien_baru'];
		$this->cara_bayar->DbValue = $row['cara_bayar'];
		$this->petugas_klaim->DbValue = $row['petugas_klaim'];
		$this->total_biaya_rs->DbValue = $row['total_biaya_rs'];
		$this->total_biaya_rs_adjust->DbValue = $row['total_biaya_rs_adjust'];
		$this->tgl_pulang->DbValue = $row['tgl_pulang'];
		$this->flag_proc->DbValue = $row['flag_proc'];
		$this->poli_eksekutif->DbValue = $row['poli_eksekutif'];
		$this->cob->DbValue = $row['cob'];
		$this->penjamin_laka->DbValue = $row['penjamin_laka'];
		$this->no_telp->DbValue = $row['no_telp'];
		$this->status_kepesertaan_bpjs->DbValue = $row['status_kepesertaan_bpjs'];
		$this->faskes_id->DbValue = $row['faskes_id'];
		$this->nama_layanan->DbValue = $row['nama_layanan'];
		$this->nama_kelas->DbValue = $row['nama_kelas'];
		$this->table_source->DbValue = $row['table_source'];
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

		if ($this->total_biaya_rs->FormValue == $this->total_biaya_rs->CurrentValue && is_numeric(ew_StrToFloat($this->total_biaya_rs->CurrentValue)))
			$this->total_biaya_rs->CurrentValue = ew_StrToFloat($this->total_biaya_rs->CurrentValue);

		// Convert decimal values if posted back
		if ($this->total_biaya_rs_adjust->FormValue == $this->total_biaya_rs_adjust->CurrentValue && is_numeric(ew_StrToFloat($this->total_biaya_rs_adjust->CurrentValue)))
			$this->total_biaya_rs_adjust->CurrentValue = ew_StrToFloat($this->total_biaya_rs_adjust->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// nomer_sep
		// nomr
		// no_kartubpjs
		// jenis_layanan
		// tgl_sep
		// tgl_rujukan
		// kelas_rawat
		// no_rujukan
		// ppk_asal
		// nama_ppk
		// ppk_pelayanan
		// catatan
		// kode_diagnosaawal
		// nama_diagnosaawal
		// laka_lantas
		// lokasi_laka
		// user
		// nik
		// kode_politujuan
		// nama_politujuan
		// dpjp
		// idx
		// last_update
		// pasien_baru
		// cara_bayar
		// petugas_klaim
		// total_biaya_rs
		// total_biaya_rs_adjust
		// tgl_pulang
		// flag_proc
		// poli_eksekutif
		// cob
		// penjamin_laka
		// no_telp
		// status_kepesertaan_bpjs
		// faskes_id
		// nama_layanan
		// nama_kelas
		// table_source

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nomer_sep
		$this->nomer_sep->ViewValue = $this->nomer_sep->CurrentValue;
		$this->nomer_sep->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// no_kartubpjs
		$this->no_kartubpjs->ViewValue = $this->no_kartubpjs->CurrentValue;
		$this->no_kartubpjs->ViewCustomAttributes = "";

		// jenis_layanan
		if (strval($this->jenis_layanan->CurrentValue) <> "") {
			$this->jenis_layanan->ViewValue = $this->jenis_layanan->OptionCaption($this->jenis_layanan->CurrentValue);
		} else {
			$this->jenis_layanan->ViewValue = NULL;
		}
		$this->jenis_layanan->ViewCustomAttributes = "";

		// tgl_sep
		$this->tgl_sep->ViewValue = $this->tgl_sep->CurrentValue;
		$this->tgl_sep->ViewValue = ew_FormatDateTime($this->tgl_sep->ViewValue, 0);
		$this->tgl_sep->ViewCustomAttributes = "";

		// tgl_rujukan
		$this->tgl_rujukan->ViewValue = $this->tgl_rujukan->CurrentValue;
		$this->tgl_rujukan->ViewValue = ew_FormatDateTime($this->tgl_rujukan->ViewValue, 0);
		$this->tgl_rujukan->ViewCustomAttributes = "";

		// kelas_rawat
		$this->kelas_rawat->ViewValue = $this->kelas_rawat->CurrentValue;
		$this->kelas_rawat->ViewCustomAttributes = "";

		// no_rujukan
		$this->no_rujukan->ViewValue = $this->no_rujukan->CurrentValue;
		$this->no_rujukan->ViewCustomAttributes = "";

		// ppk_asal
		$this->ppk_asal->ViewValue = $this->ppk_asal->CurrentValue;
		$this->ppk_asal->ViewCustomAttributes = "";

		// nama_ppk
		$this->nama_ppk->ViewValue = $this->nama_ppk->CurrentValue;
		$this->nama_ppk->ViewCustomAttributes = "";

		// ppk_pelayanan
		$this->ppk_pelayanan->ViewValue = $this->ppk_pelayanan->CurrentValue;
		$this->ppk_pelayanan->ViewCustomAttributes = "";

		// catatan
		$this->catatan->ViewValue = $this->catatan->CurrentValue;
		$this->catatan->ViewCustomAttributes = "";

		// kode_diagnosaawal
		$this->kode_diagnosaawal->ViewValue = $this->kode_diagnosaawal->CurrentValue;
		$this->kode_diagnosaawal->ViewCustomAttributes = "";

		// nama_diagnosaawal
		$this->nama_diagnosaawal->ViewValue = $this->nama_diagnosaawal->CurrentValue;
		$this->nama_diagnosaawal->ViewCustomAttributes = "";

		// laka_lantas
		$this->laka_lantas->ViewValue = $this->laka_lantas->CurrentValue;
		$this->laka_lantas->ViewCustomAttributes = "";

		// lokasi_laka
		$this->lokasi_laka->ViewValue = $this->lokasi_laka->CurrentValue;
		$this->lokasi_laka->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// nik
		$this->nik->ViewValue = $this->nik->CurrentValue;
		$this->nik->ViewCustomAttributes = "";

		// kode_politujuan
		$this->kode_politujuan->ViewValue = $this->kode_politujuan->CurrentValue;
		$this->kode_politujuan->ViewCustomAttributes = "";

		// nama_politujuan
		$this->nama_politujuan->ViewValue = $this->nama_politujuan->CurrentValue;
		$this->nama_politujuan->ViewCustomAttributes = "";

		// dpjp
		$this->dpjp->ViewValue = $this->dpjp->CurrentValue;
		$this->dpjp->ViewCustomAttributes = "";

		// idx
		$this->idx->ViewValue = $this->idx->CurrentValue;
		$this->idx->ViewCustomAttributes = "";

		// last_update
		$this->last_update->ViewValue = $this->last_update->CurrentValue;
		$this->last_update->ViewValue = ew_FormatDateTime($this->last_update->ViewValue, 0);
		$this->last_update->ViewCustomAttributes = "";

		// pasien_baru
		$this->pasien_baru->ViewValue = $this->pasien_baru->CurrentValue;
		$this->pasien_baru->ViewCustomAttributes = "";

		// cara_bayar
		$this->cara_bayar->ViewValue = $this->cara_bayar->CurrentValue;
		$this->cara_bayar->ViewCustomAttributes = "";

		// petugas_klaim
		$this->petugas_klaim->ViewValue = $this->petugas_klaim->CurrentValue;
		$this->petugas_klaim->ViewCustomAttributes = "";

		// total_biaya_rs
		$this->total_biaya_rs->ViewValue = $this->total_biaya_rs->CurrentValue;
		$this->total_biaya_rs->ViewCustomAttributes = "";

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust->ViewValue = $this->total_biaya_rs_adjust->CurrentValue;
		$this->total_biaya_rs_adjust->ViewCustomAttributes = "";

		// tgl_pulang
		$this->tgl_pulang->ViewValue = $this->tgl_pulang->CurrentValue;
		$this->tgl_pulang->ViewValue = ew_FormatDateTime($this->tgl_pulang->ViewValue, 0);
		$this->tgl_pulang->ViewCustomAttributes = "";

		// flag_proc
		$this->flag_proc->ViewValue = $this->flag_proc->CurrentValue;
		$this->flag_proc->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// cob
		$this->cob->ViewValue = $this->cob->CurrentValue;
		$this->cob->ViewCustomAttributes = "";

		// penjamin_laka
		$this->penjamin_laka->ViewValue = $this->penjamin_laka->CurrentValue;
		$this->penjamin_laka->ViewCustomAttributes = "";

		// no_telp
		$this->no_telp->ViewValue = $this->no_telp->CurrentValue;
		$this->no_telp->ViewCustomAttributes = "";

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->ViewValue = $this->status_kepesertaan_bpjs->CurrentValue;
		$this->status_kepesertaan_bpjs->ViewCustomAttributes = "";

		// faskes_id
		$this->faskes_id->ViewValue = $this->faskes_id->CurrentValue;
		$this->faskes_id->ViewCustomAttributes = "";

		// nama_layanan
		$this->nama_layanan->ViewValue = $this->nama_layanan->CurrentValue;
		$this->nama_layanan->ViewCustomAttributes = "";

		// nama_kelas
		$this->nama_kelas->ViewValue = $this->nama_kelas->CurrentValue;
		$this->nama_kelas->ViewCustomAttributes = "";

		// table_source
		$this->table_source->ViewValue = $this->table_source->CurrentValue;
		$this->table_source->ViewCustomAttributes = "";

			// nomer_sep
			$this->nomer_sep->LinkCustomAttributes = "";
			$this->nomer_sep->HrefValue = "";
			$this->nomer_sep->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// no_kartubpjs
			$this->no_kartubpjs->LinkCustomAttributes = "";
			$this->no_kartubpjs->HrefValue = "";
			$this->no_kartubpjs->TooltipValue = "";

			// jenis_layanan
			$this->jenis_layanan->LinkCustomAttributes = "";
			$this->jenis_layanan->HrefValue = "";
			$this->jenis_layanan->TooltipValue = "";

			// tgl_sep
			$this->tgl_sep->LinkCustomAttributes = "";
			$this->tgl_sep->HrefValue = "";
			$this->tgl_sep->TooltipValue = "";

			// tgl_rujukan
			$this->tgl_rujukan->LinkCustomAttributes = "";
			$this->tgl_rujukan->HrefValue = "";
			$this->tgl_rujukan->TooltipValue = "";

			// kelas_rawat
			$this->kelas_rawat->LinkCustomAttributes = "";
			$this->kelas_rawat->HrefValue = "";
			$this->kelas_rawat->TooltipValue = "";

			// no_rujukan
			$this->no_rujukan->LinkCustomAttributes = "";
			$this->no_rujukan->HrefValue = "";
			$this->no_rujukan->TooltipValue = "";

			// ppk_asal
			$this->ppk_asal->LinkCustomAttributes = "";
			$this->ppk_asal->HrefValue = "";
			$this->ppk_asal->TooltipValue = "";

			// nama_ppk
			$this->nama_ppk->LinkCustomAttributes = "";
			$this->nama_ppk->HrefValue = "";
			$this->nama_ppk->TooltipValue = "";

			// ppk_pelayanan
			$this->ppk_pelayanan->LinkCustomAttributes = "";
			$this->ppk_pelayanan->HrefValue = "";
			$this->ppk_pelayanan->TooltipValue = "";

			// catatan
			$this->catatan->LinkCustomAttributes = "";
			$this->catatan->HrefValue = "";
			$this->catatan->TooltipValue = "";

			// kode_diagnosaawal
			$this->kode_diagnosaawal->LinkCustomAttributes = "";
			$this->kode_diagnosaawal->HrefValue = "";
			$this->kode_diagnosaawal->TooltipValue = "";

			// nama_diagnosaawal
			$this->nama_diagnosaawal->LinkCustomAttributes = "";
			$this->nama_diagnosaawal->HrefValue = "";
			$this->nama_diagnosaawal->TooltipValue = "";

			// laka_lantas
			$this->laka_lantas->LinkCustomAttributes = "";
			$this->laka_lantas->HrefValue = "";
			$this->laka_lantas->TooltipValue = "";

			// lokasi_laka
			$this->lokasi_laka->LinkCustomAttributes = "";
			$this->lokasi_laka->HrefValue = "";
			$this->lokasi_laka->TooltipValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";
			$this->user->TooltipValue = "";

			// nik
			$this->nik->LinkCustomAttributes = "";
			$this->nik->HrefValue = "";
			$this->nik->TooltipValue = "";

			// kode_politujuan
			$this->kode_politujuan->LinkCustomAttributes = "";
			$this->kode_politujuan->HrefValue = "";
			$this->kode_politujuan->TooltipValue = "";

			// nama_politujuan
			$this->nama_politujuan->LinkCustomAttributes = "";
			$this->nama_politujuan->HrefValue = "";
			$this->nama_politujuan->TooltipValue = "";

			// dpjp
			$this->dpjp->LinkCustomAttributes = "";
			$this->dpjp->HrefValue = "";
			$this->dpjp->TooltipValue = "";

			// idx
			$this->idx->LinkCustomAttributes = "";
			$this->idx->HrefValue = "";
			$this->idx->TooltipValue = "";

			// last_update
			$this->last_update->LinkCustomAttributes = "";
			$this->last_update->HrefValue = "";
			$this->last_update->TooltipValue = "";

			// pasien_baru
			$this->pasien_baru->LinkCustomAttributes = "";
			$this->pasien_baru->HrefValue = "";
			$this->pasien_baru->TooltipValue = "";

			// cara_bayar
			$this->cara_bayar->LinkCustomAttributes = "";
			$this->cara_bayar->HrefValue = "";
			$this->cara_bayar->TooltipValue = "";

			// petugas_klaim
			$this->petugas_klaim->LinkCustomAttributes = "";
			$this->petugas_klaim->HrefValue = "";
			$this->petugas_klaim->TooltipValue = "";

			// total_biaya_rs
			$this->total_biaya_rs->LinkCustomAttributes = "";
			$this->total_biaya_rs->HrefValue = "";
			$this->total_biaya_rs->TooltipValue = "";

			// total_biaya_rs_adjust
			$this->total_biaya_rs_adjust->LinkCustomAttributes = "";
			$this->total_biaya_rs_adjust->HrefValue = "";
			$this->total_biaya_rs_adjust->TooltipValue = "";

			// flag_proc
			$this->flag_proc->LinkCustomAttributes = "";
			$this->flag_proc->HrefValue = "";
			$this->flag_proc->TooltipValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";
			$this->poli_eksekutif->TooltipValue = "";

			// cob
			$this->cob->LinkCustomAttributes = "";
			$this->cob->HrefValue = "";
			$this->cob->TooltipValue = "";

			// penjamin_laka
			$this->penjamin_laka->LinkCustomAttributes = "";
			$this->penjamin_laka->HrefValue = "";
			$this->penjamin_laka->TooltipValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";
			$this->no_telp->TooltipValue = "";

			// status_kepesertaan_bpjs
			$this->status_kepesertaan_bpjs->LinkCustomAttributes = "";
			$this->status_kepesertaan_bpjs->HrefValue = "";
			$this->status_kepesertaan_bpjs->TooltipValue = "";

			// faskes_id
			$this->faskes_id->LinkCustomAttributes = "";
			$this->faskes_id->HrefValue = "";
			$this->faskes_id->TooltipValue = "";

			// nama_layanan
			$this->nama_layanan->LinkCustomAttributes = "";
			$this->nama_layanan->HrefValue = "";
			$this->nama_layanan->TooltipValue = "";

			// nama_kelas
			$this->nama_kelas->LinkCustomAttributes = "";
			$this->nama_kelas->HrefValue = "";
			$this->nama_kelas->TooltipValue = "";

			// table_source
			$this->table_source->LinkCustomAttributes = "";
			$this->table_source->HrefValue = "";
			$this->table_source->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nomer_sep
			$this->nomer_sep->EditAttrs["class"] = "form-control";
			$this->nomer_sep->EditCustomAttributes = "";
			$this->nomer_sep->EditValue = ew_HtmlEncode($this->nomer_sep->CurrentValue);
			$this->nomer_sep->PlaceHolder = ew_RemoveHtml($this->nomer_sep->FldCaption());

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
			$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());

			// no_kartubpjs
			$this->no_kartubpjs->EditAttrs["class"] = "form-control";
			$this->no_kartubpjs->EditCustomAttributes = "";
			$this->no_kartubpjs->EditValue = ew_HtmlEncode($this->no_kartubpjs->CurrentValue);
			$this->no_kartubpjs->PlaceHolder = ew_RemoveHtml($this->no_kartubpjs->FldCaption());

			// jenis_layanan
			$this->jenis_layanan->EditCustomAttributes = "";
			$this->jenis_layanan->EditValue = $this->jenis_layanan->Options(FALSE);

			// tgl_sep
			$this->tgl_sep->EditAttrs["class"] = "form-control";
			$this->tgl_sep->EditCustomAttributes = "";
			$this->tgl_sep->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sep->CurrentValue, 8));
			$this->tgl_sep->PlaceHolder = ew_RemoveHtml($this->tgl_sep->FldCaption());

			// tgl_rujukan
			$this->tgl_rujukan->EditAttrs["class"] = "form-control";
			$this->tgl_rujukan->EditCustomAttributes = "";
			$this->tgl_rujukan->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_rujukan->CurrentValue, 8));
			$this->tgl_rujukan->PlaceHolder = ew_RemoveHtml($this->tgl_rujukan->FldCaption());

			// kelas_rawat
			$this->kelas_rawat->EditAttrs["class"] = "form-control";
			$this->kelas_rawat->EditCustomAttributes = "";
			$this->kelas_rawat->EditValue = ew_HtmlEncode($this->kelas_rawat->CurrentValue);
			$this->kelas_rawat->PlaceHolder = ew_RemoveHtml($this->kelas_rawat->FldCaption());

			// no_rujukan
			$this->no_rujukan->EditAttrs["class"] = "form-control";
			$this->no_rujukan->EditCustomAttributes = "";
			$this->no_rujukan->EditValue = ew_HtmlEncode($this->no_rujukan->CurrentValue);
			$this->no_rujukan->PlaceHolder = ew_RemoveHtml($this->no_rujukan->FldCaption());

			// ppk_asal
			$this->ppk_asal->EditAttrs["class"] = "form-control";
			$this->ppk_asal->EditCustomAttributes = "";
			$this->ppk_asal->EditValue = ew_HtmlEncode($this->ppk_asal->CurrentValue);
			$this->ppk_asal->PlaceHolder = ew_RemoveHtml($this->ppk_asal->FldCaption());

			// nama_ppk
			$this->nama_ppk->EditAttrs["class"] = "form-control";
			$this->nama_ppk->EditCustomAttributes = "";
			$this->nama_ppk->EditValue = ew_HtmlEncode($this->nama_ppk->CurrentValue);
			$this->nama_ppk->PlaceHolder = ew_RemoveHtml($this->nama_ppk->FldCaption());

			// ppk_pelayanan
			$this->ppk_pelayanan->EditAttrs["class"] = "form-control";
			$this->ppk_pelayanan->EditCustomAttributes = "";
			$this->ppk_pelayanan->EditValue = ew_HtmlEncode($this->ppk_pelayanan->CurrentValue);
			$this->ppk_pelayanan->PlaceHolder = ew_RemoveHtml($this->ppk_pelayanan->FldCaption());

			// catatan
			$this->catatan->EditAttrs["class"] = "form-control";
			$this->catatan->EditCustomAttributes = "";
			$this->catatan->EditValue = ew_HtmlEncode($this->catatan->CurrentValue);
			$this->catatan->PlaceHolder = ew_RemoveHtml($this->catatan->FldCaption());

			// kode_diagnosaawal
			$this->kode_diagnosaawal->EditAttrs["class"] = "form-control";
			$this->kode_diagnosaawal->EditCustomAttributes = "";
			$this->kode_diagnosaawal->EditValue = ew_HtmlEncode($this->kode_diagnosaawal->CurrentValue);
			$this->kode_diagnosaawal->PlaceHolder = ew_RemoveHtml($this->kode_diagnosaawal->FldCaption());

			// nama_diagnosaawal
			$this->nama_diagnosaawal->EditAttrs["class"] = "form-control";
			$this->nama_diagnosaawal->EditCustomAttributes = "";
			$this->nama_diagnosaawal->EditValue = ew_HtmlEncode($this->nama_diagnosaawal->CurrentValue);
			$this->nama_diagnosaawal->PlaceHolder = ew_RemoveHtml($this->nama_diagnosaawal->FldCaption());

			// laka_lantas
			$this->laka_lantas->EditAttrs["class"] = "form-control";
			$this->laka_lantas->EditCustomAttributes = "";
			$this->laka_lantas->EditValue = ew_HtmlEncode($this->laka_lantas->CurrentValue);
			$this->laka_lantas->PlaceHolder = ew_RemoveHtml($this->laka_lantas->FldCaption());

			// lokasi_laka
			$this->lokasi_laka->EditAttrs["class"] = "form-control";
			$this->lokasi_laka->EditCustomAttributes = "";
			$this->lokasi_laka->EditValue = ew_HtmlEncode($this->lokasi_laka->CurrentValue);
			$this->lokasi_laka->PlaceHolder = ew_RemoveHtml($this->lokasi_laka->FldCaption());

			// user
			$this->user->EditAttrs["class"] = "form-control";
			$this->user->EditCustomAttributes = "";
			$this->user->EditValue = ew_HtmlEncode($this->user->CurrentValue);
			$this->user->PlaceHolder = ew_RemoveHtml($this->user->FldCaption());

			// nik
			$this->nik->EditAttrs["class"] = "form-control";
			$this->nik->EditCustomAttributes = "";
			$this->nik->EditValue = ew_HtmlEncode($this->nik->CurrentValue);
			$this->nik->PlaceHolder = ew_RemoveHtml($this->nik->FldCaption());

			// kode_politujuan
			$this->kode_politujuan->EditAttrs["class"] = "form-control";
			$this->kode_politujuan->EditCustomAttributes = "";
			$this->kode_politujuan->EditValue = ew_HtmlEncode($this->kode_politujuan->CurrentValue);
			$this->kode_politujuan->PlaceHolder = ew_RemoveHtml($this->kode_politujuan->FldCaption());

			// nama_politujuan
			$this->nama_politujuan->EditAttrs["class"] = "form-control";
			$this->nama_politujuan->EditCustomAttributes = "";
			$this->nama_politujuan->EditValue = ew_HtmlEncode($this->nama_politujuan->CurrentValue);
			$this->nama_politujuan->PlaceHolder = ew_RemoveHtml($this->nama_politujuan->FldCaption());

			// dpjp
			$this->dpjp->EditAttrs["class"] = "form-control";
			$this->dpjp->EditCustomAttributes = "";
			$this->dpjp->EditValue = ew_HtmlEncode($this->dpjp->CurrentValue);
			$this->dpjp->PlaceHolder = ew_RemoveHtml($this->dpjp->FldCaption());

			// idx
			$this->idx->EditAttrs["class"] = "form-control";
			$this->idx->EditCustomAttributes = "";
			$this->idx->EditValue = ew_HtmlEncode($this->idx->CurrentValue);
			$this->idx->PlaceHolder = ew_RemoveHtml($this->idx->FldCaption());

			// last_update
			$this->last_update->EditAttrs["class"] = "form-control";
			$this->last_update->EditCustomAttributes = "";
			$this->last_update->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->last_update->CurrentValue, 8));
			$this->last_update->PlaceHolder = ew_RemoveHtml($this->last_update->FldCaption());

			// pasien_baru
			$this->pasien_baru->EditAttrs["class"] = "form-control";
			$this->pasien_baru->EditCustomAttributes = "";
			$this->pasien_baru->EditValue = ew_HtmlEncode($this->pasien_baru->CurrentValue);
			$this->pasien_baru->PlaceHolder = ew_RemoveHtml($this->pasien_baru->FldCaption());

			// cara_bayar
			$this->cara_bayar->EditAttrs["class"] = "form-control";
			$this->cara_bayar->EditCustomAttributes = "";
			$this->cara_bayar->EditValue = ew_HtmlEncode($this->cara_bayar->CurrentValue);
			$this->cara_bayar->PlaceHolder = ew_RemoveHtml($this->cara_bayar->FldCaption());

			// petugas_klaim
			$this->petugas_klaim->EditAttrs["class"] = "form-control";
			$this->petugas_klaim->EditCustomAttributes = "";
			$this->petugas_klaim->EditValue = ew_HtmlEncode($this->petugas_klaim->CurrentValue);
			$this->petugas_klaim->PlaceHolder = ew_RemoveHtml($this->petugas_klaim->FldCaption());

			// total_biaya_rs
			$this->total_biaya_rs->EditAttrs["class"] = "form-control";
			$this->total_biaya_rs->EditCustomAttributes = "";
			$this->total_biaya_rs->EditValue = ew_HtmlEncode($this->total_biaya_rs->CurrentValue);
			$this->total_biaya_rs->PlaceHolder = ew_RemoveHtml($this->total_biaya_rs->FldCaption());
			if (strval($this->total_biaya_rs->EditValue) <> "" && is_numeric($this->total_biaya_rs->EditValue)) $this->total_biaya_rs->EditValue = ew_FormatNumber($this->total_biaya_rs->EditValue, -2, -1, -2, 0);

			// total_biaya_rs_adjust
			$this->total_biaya_rs_adjust->EditAttrs["class"] = "form-control";
			$this->total_biaya_rs_adjust->EditCustomAttributes = "";
			$this->total_biaya_rs_adjust->EditValue = ew_HtmlEncode($this->total_biaya_rs_adjust->CurrentValue);
			$this->total_biaya_rs_adjust->PlaceHolder = ew_RemoveHtml($this->total_biaya_rs_adjust->FldCaption());
			if (strval($this->total_biaya_rs_adjust->EditValue) <> "" && is_numeric($this->total_biaya_rs_adjust->EditValue)) $this->total_biaya_rs_adjust->EditValue = ew_FormatNumber($this->total_biaya_rs_adjust->EditValue, -2, -1, -2, 0);

			// flag_proc
			$this->flag_proc->EditAttrs["class"] = "form-control";
			$this->flag_proc->EditCustomAttributes = "";
			$this->flag_proc->EditValue = ew_HtmlEncode($this->flag_proc->CurrentValue);
			$this->flag_proc->PlaceHolder = ew_RemoveHtml($this->flag_proc->FldCaption());

			// poli_eksekutif
			$this->poli_eksekutif->EditAttrs["class"] = "form-control";
			$this->poli_eksekutif->EditCustomAttributes = "";
			$this->poli_eksekutif->EditValue = ew_HtmlEncode($this->poli_eksekutif->CurrentValue);
			$this->poli_eksekutif->PlaceHolder = ew_RemoveHtml($this->poli_eksekutif->FldCaption());

			// cob
			$this->cob->EditAttrs["class"] = "form-control";
			$this->cob->EditCustomAttributes = "";
			$this->cob->EditValue = ew_HtmlEncode($this->cob->CurrentValue);
			$this->cob->PlaceHolder = ew_RemoveHtml($this->cob->FldCaption());

			// penjamin_laka
			$this->penjamin_laka->EditAttrs["class"] = "form-control";
			$this->penjamin_laka->EditCustomAttributes = "";
			$this->penjamin_laka->EditValue = ew_HtmlEncode($this->penjamin_laka->CurrentValue);
			$this->penjamin_laka->PlaceHolder = ew_RemoveHtml($this->penjamin_laka->FldCaption());

			// no_telp
			$this->no_telp->EditAttrs["class"] = "form-control";
			$this->no_telp->EditCustomAttributes = "";
			$this->no_telp->EditValue = ew_HtmlEncode($this->no_telp->CurrentValue);
			$this->no_telp->PlaceHolder = ew_RemoveHtml($this->no_telp->FldCaption());

			// status_kepesertaan_bpjs
			$this->status_kepesertaan_bpjs->EditAttrs["class"] = "form-control";
			$this->status_kepesertaan_bpjs->EditCustomAttributes = "";
			$this->status_kepesertaan_bpjs->EditValue = ew_HtmlEncode($this->status_kepesertaan_bpjs->CurrentValue);
			$this->status_kepesertaan_bpjs->PlaceHolder = ew_RemoveHtml($this->status_kepesertaan_bpjs->FldCaption());

			// faskes_id
			$this->faskes_id->EditAttrs["class"] = "form-control";
			$this->faskes_id->EditCustomAttributes = "";
			$this->faskes_id->EditValue = ew_HtmlEncode($this->faskes_id->CurrentValue);
			$this->faskes_id->PlaceHolder = ew_RemoveHtml($this->faskes_id->FldCaption());

			// nama_layanan
			$this->nama_layanan->EditAttrs["class"] = "form-control";
			$this->nama_layanan->EditCustomAttributes = "";
			$this->nama_layanan->EditValue = ew_HtmlEncode($this->nama_layanan->CurrentValue);
			$this->nama_layanan->PlaceHolder = ew_RemoveHtml($this->nama_layanan->FldCaption());

			// nama_kelas
			$this->nama_kelas->EditAttrs["class"] = "form-control";
			$this->nama_kelas->EditCustomAttributes = "";
			$this->nama_kelas->EditValue = ew_HtmlEncode($this->nama_kelas->CurrentValue);
			$this->nama_kelas->PlaceHolder = ew_RemoveHtml($this->nama_kelas->FldCaption());

			// table_source
			$this->table_source->EditAttrs["class"] = "form-control";
			$this->table_source->EditCustomAttributes = "";
			$this->table_source->EditValue = ew_HtmlEncode($this->table_source->CurrentValue);
			$this->table_source->PlaceHolder = ew_RemoveHtml($this->table_source->FldCaption());

			// Add refer script
			// nomer_sep

			$this->nomer_sep->LinkCustomAttributes = "";
			$this->nomer_sep->HrefValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";

			// no_kartubpjs
			$this->no_kartubpjs->LinkCustomAttributes = "";
			$this->no_kartubpjs->HrefValue = "";

			// jenis_layanan
			$this->jenis_layanan->LinkCustomAttributes = "";
			$this->jenis_layanan->HrefValue = "";

			// tgl_sep
			$this->tgl_sep->LinkCustomAttributes = "";
			$this->tgl_sep->HrefValue = "";

			// tgl_rujukan
			$this->tgl_rujukan->LinkCustomAttributes = "";
			$this->tgl_rujukan->HrefValue = "";

			// kelas_rawat
			$this->kelas_rawat->LinkCustomAttributes = "";
			$this->kelas_rawat->HrefValue = "";

			// no_rujukan
			$this->no_rujukan->LinkCustomAttributes = "";
			$this->no_rujukan->HrefValue = "";

			// ppk_asal
			$this->ppk_asal->LinkCustomAttributes = "";
			$this->ppk_asal->HrefValue = "";

			// nama_ppk
			$this->nama_ppk->LinkCustomAttributes = "";
			$this->nama_ppk->HrefValue = "";

			// ppk_pelayanan
			$this->ppk_pelayanan->LinkCustomAttributes = "";
			$this->ppk_pelayanan->HrefValue = "";

			// catatan
			$this->catatan->LinkCustomAttributes = "";
			$this->catatan->HrefValue = "";

			// kode_diagnosaawal
			$this->kode_diagnosaawal->LinkCustomAttributes = "";
			$this->kode_diagnosaawal->HrefValue = "";

			// nama_diagnosaawal
			$this->nama_diagnosaawal->LinkCustomAttributes = "";
			$this->nama_diagnosaawal->HrefValue = "";

			// laka_lantas
			$this->laka_lantas->LinkCustomAttributes = "";
			$this->laka_lantas->HrefValue = "";

			// lokasi_laka
			$this->lokasi_laka->LinkCustomAttributes = "";
			$this->lokasi_laka->HrefValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";

			// nik
			$this->nik->LinkCustomAttributes = "";
			$this->nik->HrefValue = "";

			// kode_politujuan
			$this->kode_politujuan->LinkCustomAttributes = "";
			$this->kode_politujuan->HrefValue = "";

			// nama_politujuan
			$this->nama_politujuan->LinkCustomAttributes = "";
			$this->nama_politujuan->HrefValue = "";

			// dpjp
			$this->dpjp->LinkCustomAttributes = "";
			$this->dpjp->HrefValue = "";

			// idx
			$this->idx->LinkCustomAttributes = "";
			$this->idx->HrefValue = "";

			// last_update
			$this->last_update->LinkCustomAttributes = "";
			$this->last_update->HrefValue = "";

			// pasien_baru
			$this->pasien_baru->LinkCustomAttributes = "";
			$this->pasien_baru->HrefValue = "";

			// cara_bayar
			$this->cara_bayar->LinkCustomAttributes = "";
			$this->cara_bayar->HrefValue = "";

			// petugas_klaim
			$this->petugas_klaim->LinkCustomAttributes = "";
			$this->petugas_klaim->HrefValue = "";

			// total_biaya_rs
			$this->total_biaya_rs->LinkCustomAttributes = "";
			$this->total_biaya_rs->HrefValue = "";

			// total_biaya_rs_adjust
			$this->total_biaya_rs_adjust->LinkCustomAttributes = "";
			$this->total_biaya_rs_adjust->HrefValue = "";

			// flag_proc
			$this->flag_proc->LinkCustomAttributes = "";
			$this->flag_proc->HrefValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";

			// cob
			$this->cob->LinkCustomAttributes = "";
			$this->cob->HrefValue = "";

			// penjamin_laka
			$this->penjamin_laka->LinkCustomAttributes = "";
			$this->penjamin_laka->HrefValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";

			// status_kepesertaan_bpjs
			$this->status_kepesertaan_bpjs->LinkCustomAttributes = "";
			$this->status_kepesertaan_bpjs->HrefValue = "";

			// faskes_id
			$this->faskes_id->LinkCustomAttributes = "";
			$this->faskes_id->HrefValue = "";

			// nama_layanan
			$this->nama_layanan->LinkCustomAttributes = "";
			$this->nama_layanan->HrefValue = "";

			// nama_kelas
			$this->nama_kelas->LinkCustomAttributes = "";
			$this->nama_kelas->HrefValue = "";

			// table_source
			$this->table_source->LinkCustomAttributes = "";
			$this->table_source->HrefValue = "";
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
		if (!ew_CheckDateDef($this->tgl_sep->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_sep->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_rujukan->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_rujukan->FldErrMsg());
		}
		if (!ew_CheckInteger($this->kelas_rawat->FormValue)) {
			ew_AddMessage($gsFormError, $this->kelas_rawat->FldErrMsg());
		}
		if (!ew_CheckInteger($this->laka_lantas->FormValue)) {
			ew_AddMessage($gsFormError, $this->laka_lantas->FldErrMsg());
		}
		if (!ew_CheckInteger($this->dpjp->FormValue)) {
			ew_AddMessage($gsFormError, $this->dpjp->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->last_update->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_update->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pasien_baru->FormValue)) {
			ew_AddMessage($gsFormError, $this->pasien_baru->FldErrMsg());
		}
		if (!ew_CheckInteger($this->cara_bayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->cara_bayar->FldErrMsg());
		}
		if (!ew_CheckNumber($this->total_biaya_rs->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_biaya_rs->FldErrMsg());
		}
		if (!ew_CheckNumber($this->total_biaya_rs_adjust->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_biaya_rs_adjust->FldErrMsg());
		}
		if (!ew_CheckInteger($this->flag_proc->FormValue)) {
			ew_AddMessage($gsFormError, $this->flag_proc->FldErrMsg());
		}
		if (!ew_CheckInteger($this->poli_eksekutif->FormValue)) {
			ew_AddMessage($gsFormError, $this->poli_eksekutif->FldErrMsg());
		}
		if (!ew_CheckInteger($this->cob->FormValue)) {
			ew_AddMessage($gsFormError, $this->cob->FldErrMsg());
		}
		if (!ew_CheckInteger($this->penjamin_laka->FormValue)) {
			ew_AddMessage($gsFormError, $this->penjamin_laka->FldErrMsg());
		}
		if (!ew_CheckInteger($this->faskes_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->faskes_id->FldErrMsg());
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

		// nomer_sep
		$this->nomer_sep->SetDbValueDef($rsnew, $this->nomer_sep->CurrentValue, NULL, FALSE);

		// nomr
		$this->nomr->SetDbValueDef($rsnew, $this->nomr->CurrentValue, NULL, FALSE);

		// no_kartubpjs
		$this->no_kartubpjs->SetDbValueDef($rsnew, $this->no_kartubpjs->CurrentValue, NULL, FALSE);

		// jenis_layanan
		$this->jenis_layanan->SetDbValueDef($rsnew, $this->jenis_layanan->CurrentValue, NULL, FALSE);

		// tgl_sep
		$this->tgl_sep->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sep->CurrentValue, 0), NULL, FALSE);

		// tgl_rujukan
		$this->tgl_rujukan->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_rujukan->CurrentValue, 0), NULL, FALSE);

		// kelas_rawat
		$this->kelas_rawat->SetDbValueDef($rsnew, $this->kelas_rawat->CurrentValue, NULL, FALSE);

		// no_rujukan
		$this->no_rujukan->SetDbValueDef($rsnew, $this->no_rujukan->CurrentValue, NULL, FALSE);

		// ppk_asal
		$this->ppk_asal->SetDbValueDef($rsnew, $this->ppk_asal->CurrentValue, NULL, FALSE);

		// nama_ppk
		$this->nama_ppk->SetDbValueDef($rsnew, $this->nama_ppk->CurrentValue, NULL, FALSE);

		// ppk_pelayanan
		$this->ppk_pelayanan->SetDbValueDef($rsnew, $this->ppk_pelayanan->CurrentValue, NULL, FALSE);

		// catatan
		$this->catatan->SetDbValueDef($rsnew, $this->catatan->CurrentValue, NULL, FALSE);

		// kode_diagnosaawal
		$this->kode_diagnosaawal->SetDbValueDef($rsnew, $this->kode_diagnosaawal->CurrentValue, NULL, FALSE);

		// nama_diagnosaawal
		$this->nama_diagnosaawal->SetDbValueDef($rsnew, $this->nama_diagnosaawal->CurrentValue, NULL, FALSE);

		// laka_lantas
		$this->laka_lantas->SetDbValueDef($rsnew, $this->laka_lantas->CurrentValue, NULL, FALSE);

		// lokasi_laka
		$this->lokasi_laka->SetDbValueDef($rsnew, $this->lokasi_laka->CurrentValue, NULL, FALSE);

		// user
		$this->user->SetDbValueDef($rsnew, $this->user->CurrentValue, NULL, FALSE);

		// nik
		$this->nik->SetDbValueDef($rsnew, $this->nik->CurrentValue, NULL, FALSE);

		// kode_politujuan
		$this->kode_politujuan->SetDbValueDef($rsnew, $this->kode_politujuan->CurrentValue, NULL, FALSE);

		// nama_politujuan
		$this->nama_politujuan->SetDbValueDef($rsnew, $this->nama_politujuan->CurrentValue, NULL, FALSE);

		// dpjp
		$this->dpjp->SetDbValueDef($rsnew, $this->dpjp->CurrentValue, NULL, FALSE);

		// idx
		$this->idx->SetDbValueDef($rsnew, $this->idx->CurrentValue, NULL, FALSE);

		// last_update
		$this->last_update->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_update->CurrentValue, 0), NULL, FALSE);

		// pasien_baru
		$this->pasien_baru->SetDbValueDef($rsnew, $this->pasien_baru->CurrentValue, NULL, FALSE);

		// cara_bayar
		$this->cara_bayar->SetDbValueDef($rsnew, $this->cara_bayar->CurrentValue, NULL, FALSE);

		// petugas_klaim
		$this->petugas_klaim->SetDbValueDef($rsnew, $this->petugas_klaim->CurrentValue, NULL, FALSE);

		// total_biaya_rs
		$this->total_biaya_rs->SetDbValueDef($rsnew, $this->total_biaya_rs->CurrentValue, NULL, strval($this->total_biaya_rs->CurrentValue) == "");

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust->SetDbValueDef($rsnew, $this->total_biaya_rs_adjust->CurrentValue, NULL, strval($this->total_biaya_rs_adjust->CurrentValue) == "");

		// flag_proc
		$this->flag_proc->SetDbValueDef($rsnew, $this->flag_proc->CurrentValue, NULL, FALSE);

		// poli_eksekutif
		$this->poli_eksekutif->SetDbValueDef($rsnew, $this->poli_eksekutif->CurrentValue, NULL, FALSE);

		// cob
		$this->cob->SetDbValueDef($rsnew, $this->cob->CurrentValue, NULL, FALSE);

		// penjamin_laka
		$this->penjamin_laka->SetDbValueDef($rsnew, $this->penjamin_laka->CurrentValue, NULL, FALSE);

		// no_telp
		$this->no_telp->SetDbValueDef($rsnew, $this->no_telp->CurrentValue, NULL, FALSE);

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->SetDbValueDef($rsnew, $this->status_kepesertaan_bpjs->CurrentValue, NULL, FALSE);

		// faskes_id
		$this->faskes_id->SetDbValueDef($rsnew, $this->faskes_id->CurrentValue, NULL, FALSE);

		// nama_layanan
		$this->nama_layanan->SetDbValueDef($rsnew, $this->nama_layanan->CurrentValue, NULL, FALSE);

		// nama_kelas
		$this->nama_kelas->SetDbValueDef($rsnew, $this->nama_kelas->CurrentValue, NULL, FALSE);

		// table_source
		$this->table_source->SetDbValueDef($rsnew, $this->table_source->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_seplist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_sep_add)) $t_sep_add = new ct_sep_add();

// Page init
$t_sep_add->Page_Init();

// Page main
$t_sep_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sep_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_sepadd = new ew_Form("ft_sepadd", "add");

// Validate form
ft_sepadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_sep");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->tgl_sep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_rujukan");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->tgl_rujukan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kelas_rawat");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->kelas_rawat->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_laka_lantas");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->laka_lantas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dpjp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->dpjp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_update");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->last_update->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pasien_baru");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->pasien_baru->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cara_bayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->cara_bayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_biaya_rs");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->total_biaya_rs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_biaya_rs_adjust");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->total_biaya_rs_adjust->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_flag_proc");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->flag_proc->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_poli_eksekutif");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->poli_eksekutif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_cob");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->cob->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_penjamin_laka");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->penjamin_laka->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_faskes_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->faskes_id->FldErrMsg()) ?>");

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
ft_sepadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sepadd.ValidateRequired = true;
<?php } else { ?>
ft_sepadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sepadd.Lists["x_jenis_layanan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sepadd.Lists["x_jenis_layanan"].Options = <?php echo json_encode($t_sep->jenis_layanan->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_sep_add->IsModal) { ?>
<?php } ?>
<?php $t_sep_add->ShowPageHeader(); ?>
<?php
$t_sep_add->ShowMessage();
?>
<form name="ft_sepadd" id="ft_sepadd" class="<?php echo $t_sep_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_sep_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_sep_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_sep">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_sep_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_sep->nomer_sep->Visible) { // nomer_sep ?>
	<div id="r_nomer_sep" class="form-group">
		<label id="elh_t_sep_nomer_sep" for="x_nomer_sep" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nomer_sep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nomer_sep->CellAttributes() ?>>
<span id="el_t_sep_nomer_sep">
<input type="text" data-table="t_sep" data-field="x_nomer_sep" name="x_nomer_sep" id="x_nomer_sep" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomer_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomer_sep->EditValue ?>"<?php echo $t_sep->nomer_sep->EditAttributes() ?>>
</span>
<?php echo $t_sep->nomer_sep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label id="elh_t_sep_nomr" for="x_nomr" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nomr->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nomr->CellAttributes() ?>>
<span id="el_t_sep_nomr">
<input type="text" data-table="t_sep" data-field="x_nomr" name="x_nomr" id="x_nomr" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomr->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomr->EditValue ?>"<?php echo $t_sep->nomr->EditAttributes() ?>>
</span>
<?php echo $t_sep->nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->no_kartubpjs->Visible) { // no_kartubpjs ?>
	<div id="r_no_kartubpjs" class="form-group">
		<label id="elh_t_sep_no_kartubpjs" for="x_no_kartubpjs" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->no_kartubpjs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->no_kartubpjs->CellAttributes() ?>>
<span id="el_t_sep_no_kartubpjs">
<input type="text" data-table="t_sep" data-field="x_no_kartubpjs" name="x_no_kartubpjs" id="x_no_kartubpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_kartubpjs->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_kartubpjs->EditValue ?>"<?php echo $t_sep->no_kartubpjs->EditAttributes() ?>>
</span>
<?php echo $t_sep->no_kartubpjs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->jenis_layanan->Visible) { // jenis_layanan ?>
	<div id="r_jenis_layanan" class="form-group">
		<label id="elh_t_sep_jenis_layanan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->jenis_layanan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->jenis_layanan->CellAttributes() ?>>
<span id="el_t_sep_jenis_layanan">
<div id="tp_x_jenis_layanan" class="ewTemplate"><input type="radio" data-table="t_sep" data-field="x_jenis_layanan" data-value-separator="<?php echo $t_sep->jenis_layanan->DisplayValueSeparatorAttribute() ?>" name="x_jenis_layanan" id="x_jenis_layanan" value="{value}"<?php echo $t_sep->jenis_layanan->EditAttributes() ?>></div>
<div id="dsl_x_jenis_layanan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_sep->jenis_layanan->RadioButtonListHtml(FALSE, "x_jenis_layanan") ?>
</div></div>
</span>
<?php echo $t_sep->jenis_layanan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->tgl_sep->Visible) { // tgl_sep ?>
	<div id="r_tgl_sep" class="form-group">
		<label id="elh_t_sep_tgl_sep" for="x_tgl_sep" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->tgl_sep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->tgl_sep->CellAttributes() ?>>
<span id="el_t_sep_tgl_sep">
<input type="text" data-table="t_sep" data-field="x_tgl_sep" name="x_tgl_sep" id="x_tgl_sep" placeholder="<?php echo ew_HtmlEncode($t_sep->tgl_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->tgl_sep->EditValue ?>"<?php echo $t_sep->tgl_sep->EditAttributes() ?>>
</span>
<?php echo $t_sep->tgl_sep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->tgl_rujukan->Visible) { // tgl_rujukan ?>
	<div id="r_tgl_rujukan" class="form-group">
		<label id="elh_t_sep_tgl_rujukan" for="x_tgl_rujukan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->tgl_rujukan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->tgl_rujukan->CellAttributes() ?>>
<span id="el_t_sep_tgl_rujukan">
<input type="text" data-table="t_sep" data-field="x_tgl_rujukan" name="x_tgl_rujukan" id="x_tgl_rujukan" placeholder="<?php echo ew_HtmlEncode($t_sep->tgl_rujukan->getPlaceHolder()) ?>" value="<?php echo $t_sep->tgl_rujukan->EditValue ?>"<?php echo $t_sep->tgl_rujukan->EditAttributes() ?>>
</span>
<?php echo $t_sep->tgl_rujukan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->kelas_rawat->Visible) { // kelas_rawat ?>
	<div id="r_kelas_rawat" class="form-group">
		<label id="elh_t_sep_kelas_rawat" for="x_kelas_rawat" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->kelas_rawat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->kelas_rawat->CellAttributes() ?>>
<span id="el_t_sep_kelas_rawat">
<input type="text" data-table="t_sep" data-field="x_kelas_rawat" name="x_kelas_rawat" id="x_kelas_rawat" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->kelas_rawat->getPlaceHolder()) ?>" value="<?php echo $t_sep->kelas_rawat->EditValue ?>"<?php echo $t_sep->kelas_rawat->EditAttributes() ?>>
</span>
<?php echo $t_sep->kelas_rawat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->no_rujukan->Visible) { // no_rujukan ?>
	<div id="r_no_rujukan" class="form-group">
		<label id="elh_t_sep_no_rujukan" for="x_no_rujukan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->no_rujukan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->no_rujukan->CellAttributes() ?>>
<span id="el_t_sep_no_rujukan">
<input type="text" data-table="t_sep" data-field="x_no_rujukan" name="x_no_rujukan" id="x_no_rujukan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_rujukan->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_rujukan->EditValue ?>"<?php echo $t_sep->no_rujukan->EditAttributes() ?>>
</span>
<?php echo $t_sep->no_rujukan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->ppk_asal->Visible) { // ppk_asal ?>
	<div id="r_ppk_asal" class="form-group">
		<label id="elh_t_sep_ppk_asal" for="x_ppk_asal" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->ppk_asal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->ppk_asal->CellAttributes() ?>>
<span id="el_t_sep_ppk_asal">
<input type="text" data-table="t_sep" data-field="x_ppk_asal" name="x_ppk_asal" id="x_ppk_asal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->ppk_asal->getPlaceHolder()) ?>" value="<?php echo $t_sep->ppk_asal->EditValue ?>"<?php echo $t_sep->ppk_asal->EditAttributes() ?>>
</span>
<?php echo $t_sep->ppk_asal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nama_ppk->Visible) { // nama_ppk ?>
	<div id="r_nama_ppk" class="form-group">
		<label id="elh_t_sep_nama_ppk" for="x_nama_ppk" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nama_ppk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nama_ppk->CellAttributes() ?>>
<span id="el_t_sep_nama_ppk">
<input type="text" data-table="t_sep" data-field="x_nama_ppk" name="x_nama_ppk" id="x_nama_ppk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nama_ppk->getPlaceHolder()) ?>" value="<?php echo $t_sep->nama_ppk->EditValue ?>"<?php echo $t_sep->nama_ppk->EditAttributes() ?>>
</span>
<?php echo $t_sep->nama_ppk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->ppk_pelayanan->Visible) { // ppk_pelayanan ?>
	<div id="r_ppk_pelayanan" class="form-group">
		<label id="elh_t_sep_ppk_pelayanan" for="x_ppk_pelayanan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->ppk_pelayanan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->ppk_pelayanan->CellAttributes() ?>>
<span id="el_t_sep_ppk_pelayanan">
<input type="text" data-table="t_sep" data-field="x_ppk_pelayanan" name="x_ppk_pelayanan" id="x_ppk_pelayanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->ppk_pelayanan->getPlaceHolder()) ?>" value="<?php echo $t_sep->ppk_pelayanan->EditValue ?>"<?php echo $t_sep->ppk_pelayanan->EditAttributes() ?>>
</span>
<?php echo $t_sep->ppk_pelayanan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->catatan->Visible) { // catatan ?>
	<div id="r_catatan" class="form-group">
		<label id="elh_t_sep_catatan" for="x_catatan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->catatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->catatan->CellAttributes() ?>>
<span id="el_t_sep_catatan">
<input type="text" data-table="t_sep" data-field="x_catatan" name="x_catatan" id="x_catatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->catatan->getPlaceHolder()) ?>" value="<?php echo $t_sep->catatan->EditValue ?>"<?php echo $t_sep->catatan->EditAttributes() ?>>
</span>
<?php echo $t_sep->catatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->kode_diagnosaawal->Visible) { // kode_diagnosaawal ?>
	<div id="r_kode_diagnosaawal" class="form-group">
		<label id="elh_t_sep_kode_diagnosaawal" for="x_kode_diagnosaawal" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->kode_diagnosaawal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->kode_diagnosaawal->CellAttributes() ?>>
<span id="el_t_sep_kode_diagnosaawal">
<input type="text" data-table="t_sep" data-field="x_kode_diagnosaawal" name="x_kode_diagnosaawal" id="x_kode_diagnosaawal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->kode_diagnosaawal->getPlaceHolder()) ?>" value="<?php echo $t_sep->kode_diagnosaawal->EditValue ?>"<?php echo $t_sep->kode_diagnosaawal->EditAttributes() ?>>
</span>
<?php echo $t_sep->kode_diagnosaawal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nama_diagnosaawal->Visible) { // nama_diagnosaawal ?>
	<div id="r_nama_diagnosaawal" class="form-group">
		<label id="elh_t_sep_nama_diagnosaawal" for="x_nama_diagnosaawal" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nama_diagnosaawal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nama_diagnosaawal->CellAttributes() ?>>
<span id="el_t_sep_nama_diagnosaawal">
<input type="text" data-table="t_sep" data-field="x_nama_diagnosaawal" name="x_nama_diagnosaawal" id="x_nama_diagnosaawal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nama_diagnosaawal->getPlaceHolder()) ?>" value="<?php echo $t_sep->nama_diagnosaawal->EditValue ?>"<?php echo $t_sep->nama_diagnosaawal->EditAttributes() ?>>
</span>
<?php echo $t_sep->nama_diagnosaawal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->laka_lantas->Visible) { // laka_lantas ?>
	<div id="r_laka_lantas" class="form-group">
		<label id="elh_t_sep_laka_lantas" for="x_laka_lantas" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->laka_lantas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->laka_lantas->CellAttributes() ?>>
<span id="el_t_sep_laka_lantas">
<input type="text" data-table="t_sep" data-field="x_laka_lantas" name="x_laka_lantas" id="x_laka_lantas" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->laka_lantas->getPlaceHolder()) ?>" value="<?php echo $t_sep->laka_lantas->EditValue ?>"<?php echo $t_sep->laka_lantas->EditAttributes() ?>>
</span>
<?php echo $t_sep->laka_lantas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->lokasi_laka->Visible) { // lokasi_laka ?>
	<div id="r_lokasi_laka" class="form-group">
		<label id="elh_t_sep_lokasi_laka" for="x_lokasi_laka" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->lokasi_laka->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->lokasi_laka->CellAttributes() ?>>
<span id="el_t_sep_lokasi_laka">
<input type="text" data-table="t_sep" data-field="x_lokasi_laka" name="x_lokasi_laka" id="x_lokasi_laka" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->lokasi_laka->getPlaceHolder()) ?>" value="<?php echo $t_sep->lokasi_laka->EditValue ?>"<?php echo $t_sep->lokasi_laka->EditAttributes() ?>>
</span>
<?php echo $t_sep->lokasi_laka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->user->Visible) { // user ?>
	<div id="r_user" class="form-group">
		<label id="elh_t_sep_user" for="x_user" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->user->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->user->CellAttributes() ?>>
<span id="el_t_sep_user">
<input type="text" data-table="t_sep" data-field="x_user" name="x_user" id="x_user" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->user->getPlaceHolder()) ?>" value="<?php echo $t_sep->user->EditValue ?>"<?php echo $t_sep->user->EditAttributes() ?>>
</span>
<?php echo $t_sep->user->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nik->Visible) { // nik ?>
	<div id="r_nik" class="form-group">
		<label id="elh_t_sep_nik" for="x_nik" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nik->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nik->CellAttributes() ?>>
<span id="el_t_sep_nik">
<input type="text" data-table="t_sep" data-field="x_nik" name="x_nik" id="x_nik" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nik->getPlaceHolder()) ?>" value="<?php echo $t_sep->nik->EditValue ?>"<?php echo $t_sep->nik->EditAttributes() ?>>
</span>
<?php echo $t_sep->nik->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->kode_politujuan->Visible) { // kode_politujuan ?>
	<div id="r_kode_politujuan" class="form-group">
		<label id="elh_t_sep_kode_politujuan" for="x_kode_politujuan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->kode_politujuan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->kode_politujuan->CellAttributes() ?>>
<span id="el_t_sep_kode_politujuan">
<input type="text" data-table="t_sep" data-field="x_kode_politujuan" name="x_kode_politujuan" id="x_kode_politujuan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->kode_politujuan->getPlaceHolder()) ?>" value="<?php echo $t_sep->kode_politujuan->EditValue ?>"<?php echo $t_sep->kode_politujuan->EditAttributes() ?>>
</span>
<?php echo $t_sep->kode_politujuan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nama_politujuan->Visible) { // nama_politujuan ?>
	<div id="r_nama_politujuan" class="form-group">
		<label id="elh_t_sep_nama_politujuan" for="x_nama_politujuan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nama_politujuan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nama_politujuan->CellAttributes() ?>>
<span id="el_t_sep_nama_politujuan">
<input type="text" data-table="t_sep" data-field="x_nama_politujuan" name="x_nama_politujuan" id="x_nama_politujuan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nama_politujuan->getPlaceHolder()) ?>" value="<?php echo $t_sep->nama_politujuan->EditValue ?>"<?php echo $t_sep->nama_politujuan->EditAttributes() ?>>
</span>
<?php echo $t_sep->nama_politujuan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->dpjp->Visible) { // dpjp ?>
	<div id="r_dpjp" class="form-group">
		<label id="elh_t_sep_dpjp" for="x_dpjp" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->dpjp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->dpjp->CellAttributes() ?>>
<span id="el_t_sep_dpjp">
<input type="text" data-table="t_sep" data-field="x_dpjp" name="x_dpjp" id="x_dpjp" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->dpjp->getPlaceHolder()) ?>" value="<?php echo $t_sep->dpjp->EditValue ?>"<?php echo $t_sep->dpjp->EditAttributes() ?>>
</span>
<?php echo $t_sep->dpjp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->idx->Visible) { // idx ?>
	<div id="r_idx" class="form-group">
		<label id="elh_t_sep_idx" for="x_idx" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->idx->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->idx->CellAttributes() ?>>
<span id="el_t_sep_idx">
<input type="text" data-table="t_sep" data-field="x_idx" name="x_idx" id="x_idx" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->idx->getPlaceHolder()) ?>" value="<?php echo $t_sep->idx->EditValue ?>"<?php echo $t_sep->idx->EditAttributes() ?>>
</span>
<?php echo $t_sep->idx->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->last_update->Visible) { // last_update ?>
	<div id="r_last_update" class="form-group">
		<label id="elh_t_sep_last_update" for="x_last_update" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->last_update->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->last_update->CellAttributes() ?>>
<span id="el_t_sep_last_update">
<input type="text" data-table="t_sep" data-field="x_last_update" name="x_last_update" id="x_last_update" placeholder="<?php echo ew_HtmlEncode($t_sep->last_update->getPlaceHolder()) ?>" value="<?php echo $t_sep->last_update->EditValue ?>"<?php echo $t_sep->last_update->EditAttributes() ?>>
</span>
<?php echo $t_sep->last_update->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->pasien_baru->Visible) { // pasien_baru ?>
	<div id="r_pasien_baru" class="form-group">
		<label id="elh_t_sep_pasien_baru" for="x_pasien_baru" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->pasien_baru->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->pasien_baru->CellAttributes() ?>>
<span id="el_t_sep_pasien_baru">
<input type="text" data-table="t_sep" data-field="x_pasien_baru" name="x_pasien_baru" id="x_pasien_baru" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->pasien_baru->getPlaceHolder()) ?>" value="<?php echo $t_sep->pasien_baru->EditValue ?>"<?php echo $t_sep->pasien_baru->EditAttributes() ?>>
</span>
<?php echo $t_sep->pasien_baru->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->cara_bayar->Visible) { // cara_bayar ?>
	<div id="r_cara_bayar" class="form-group">
		<label id="elh_t_sep_cara_bayar" for="x_cara_bayar" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->cara_bayar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->cara_bayar->CellAttributes() ?>>
<span id="el_t_sep_cara_bayar">
<input type="text" data-table="t_sep" data-field="x_cara_bayar" name="x_cara_bayar" id="x_cara_bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->cara_bayar->getPlaceHolder()) ?>" value="<?php echo $t_sep->cara_bayar->EditValue ?>"<?php echo $t_sep->cara_bayar->EditAttributes() ?>>
</span>
<?php echo $t_sep->cara_bayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->petugas_klaim->Visible) { // petugas_klaim ?>
	<div id="r_petugas_klaim" class="form-group">
		<label id="elh_t_sep_petugas_klaim" for="x_petugas_klaim" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->petugas_klaim->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->petugas_klaim->CellAttributes() ?>>
<span id="el_t_sep_petugas_klaim">
<input type="text" data-table="t_sep" data-field="x_petugas_klaim" name="x_petugas_klaim" id="x_petugas_klaim" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->petugas_klaim->getPlaceHolder()) ?>" value="<?php echo $t_sep->petugas_klaim->EditValue ?>"<?php echo $t_sep->petugas_klaim->EditAttributes() ?>>
</span>
<?php echo $t_sep->petugas_klaim->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->total_biaya_rs->Visible) { // total_biaya_rs ?>
	<div id="r_total_biaya_rs" class="form-group">
		<label id="elh_t_sep_total_biaya_rs" for="x_total_biaya_rs" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->total_biaya_rs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->total_biaya_rs->CellAttributes() ?>>
<span id="el_t_sep_total_biaya_rs">
<input type="text" data-table="t_sep" data-field="x_total_biaya_rs" name="x_total_biaya_rs" id="x_total_biaya_rs" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->total_biaya_rs->getPlaceHolder()) ?>" value="<?php echo $t_sep->total_biaya_rs->EditValue ?>"<?php echo $t_sep->total_biaya_rs->EditAttributes() ?>>
</span>
<?php echo $t_sep->total_biaya_rs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->total_biaya_rs_adjust->Visible) { // total_biaya_rs_adjust ?>
	<div id="r_total_biaya_rs_adjust" class="form-group">
		<label id="elh_t_sep_total_biaya_rs_adjust" for="x_total_biaya_rs_adjust" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->total_biaya_rs_adjust->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->total_biaya_rs_adjust->CellAttributes() ?>>
<span id="el_t_sep_total_biaya_rs_adjust">
<input type="text" data-table="t_sep" data-field="x_total_biaya_rs_adjust" name="x_total_biaya_rs_adjust" id="x_total_biaya_rs_adjust" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->total_biaya_rs_adjust->getPlaceHolder()) ?>" value="<?php echo $t_sep->total_biaya_rs_adjust->EditValue ?>"<?php echo $t_sep->total_biaya_rs_adjust->EditAttributes() ?>>
</span>
<?php echo $t_sep->total_biaya_rs_adjust->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->flag_proc->Visible) { // flag_proc ?>
	<div id="r_flag_proc" class="form-group">
		<label id="elh_t_sep_flag_proc" for="x_flag_proc" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->flag_proc->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->flag_proc->CellAttributes() ?>>
<span id="el_t_sep_flag_proc">
<input type="text" data-table="t_sep" data-field="x_flag_proc" name="x_flag_proc" id="x_flag_proc" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->flag_proc->getPlaceHolder()) ?>" value="<?php echo $t_sep->flag_proc->EditValue ?>"<?php echo $t_sep->flag_proc->EditAttributes() ?>>
</span>
<?php echo $t_sep->flag_proc->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<div id="r_poli_eksekutif" class="form-group">
		<label id="elh_t_sep_poli_eksekutif" for="x_poli_eksekutif" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->poli_eksekutif->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->poli_eksekutif->CellAttributes() ?>>
<span id="el_t_sep_poli_eksekutif">
<input type="text" data-table="t_sep" data-field="x_poli_eksekutif" name="x_poli_eksekutif" id="x_poli_eksekutif" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->getPlaceHolder()) ?>" value="<?php echo $t_sep->poli_eksekutif->EditValue ?>"<?php echo $t_sep->poli_eksekutif->EditAttributes() ?>>
</span>
<?php echo $t_sep->poli_eksekutif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->cob->Visible) { // cob ?>
	<div id="r_cob" class="form-group">
		<label id="elh_t_sep_cob" for="x_cob" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->cob->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->cob->CellAttributes() ?>>
<span id="el_t_sep_cob">
<input type="text" data-table="t_sep" data-field="x_cob" name="x_cob" id="x_cob" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->cob->getPlaceHolder()) ?>" value="<?php echo $t_sep->cob->EditValue ?>"<?php echo $t_sep->cob->EditAttributes() ?>>
</span>
<?php echo $t_sep->cob->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->penjamin_laka->Visible) { // penjamin_laka ?>
	<div id="r_penjamin_laka" class="form-group">
		<label id="elh_t_sep_penjamin_laka" for="x_penjamin_laka" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->penjamin_laka->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->penjamin_laka->CellAttributes() ?>>
<span id="el_t_sep_penjamin_laka">
<input type="text" data-table="t_sep" data-field="x_penjamin_laka" name="x_penjamin_laka" id="x_penjamin_laka" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->getPlaceHolder()) ?>" value="<?php echo $t_sep->penjamin_laka->EditValue ?>"<?php echo $t_sep->penjamin_laka->EditAttributes() ?>>
</span>
<?php echo $t_sep->penjamin_laka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->no_telp->Visible) { // no_telp ?>
	<div id="r_no_telp" class="form-group">
		<label id="elh_t_sep_no_telp" for="x_no_telp" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->no_telp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->no_telp->CellAttributes() ?>>
<span id="el_t_sep_no_telp">
<input type="text" data-table="t_sep" data-field="x_no_telp" name="x_no_telp" id="x_no_telp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_telp->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_telp->EditValue ?>"<?php echo $t_sep->no_telp->EditAttributes() ?>>
</span>
<?php echo $t_sep->no_telp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->status_kepesertaan_bpjs->Visible) { // status_kepesertaan_bpjs ?>
	<div id="r_status_kepesertaan_bpjs" class="form-group">
		<label id="elh_t_sep_status_kepesertaan_bpjs" for="x_status_kepesertaan_bpjs" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->status_kepesertaan_bpjs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->status_kepesertaan_bpjs->CellAttributes() ?>>
<span id="el_t_sep_status_kepesertaan_bpjs">
<input type="text" data-table="t_sep" data-field="x_status_kepesertaan_bpjs" name="x_status_kepesertaan_bpjs" id="x_status_kepesertaan_bpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->status_kepesertaan_bpjs->getPlaceHolder()) ?>" value="<?php echo $t_sep->status_kepesertaan_bpjs->EditValue ?>"<?php echo $t_sep->status_kepesertaan_bpjs->EditAttributes() ?>>
</span>
<?php echo $t_sep->status_kepesertaan_bpjs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->faskes_id->Visible) { // faskes_id ?>
	<div id="r_faskes_id" class="form-group">
		<label id="elh_t_sep_faskes_id" for="x_faskes_id" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->faskes_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->faskes_id->CellAttributes() ?>>
<span id="el_t_sep_faskes_id">
<input type="text" data-table="t_sep" data-field="x_faskes_id" name="x_faskes_id" id="x_faskes_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->faskes_id->getPlaceHolder()) ?>" value="<?php echo $t_sep->faskes_id->EditValue ?>"<?php echo $t_sep->faskes_id->EditAttributes() ?>>
</span>
<?php echo $t_sep->faskes_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nama_layanan->Visible) { // nama_layanan ?>
	<div id="r_nama_layanan" class="form-group">
		<label id="elh_t_sep_nama_layanan" for="x_nama_layanan" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nama_layanan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nama_layanan->CellAttributes() ?>>
<span id="el_t_sep_nama_layanan">
<input type="text" data-table="t_sep" data-field="x_nama_layanan" name="x_nama_layanan" id="x_nama_layanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nama_layanan->getPlaceHolder()) ?>" value="<?php echo $t_sep->nama_layanan->EditValue ?>"<?php echo $t_sep->nama_layanan->EditAttributes() ?>>
</span>
<?php echo $t_sep->nama_layanan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nama_kelas->Visible) { // nama_kelas ?>
	<div id="r_nama_kelas" class="form-group">
		<label id="elh_t_sep_nama_kelas" for="x_nama_kelas" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->nama_kelas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->nama_kelas->CellAttributes() ?>>
<span id="el_t_sep_nama_kelas">
<input type="text" data-table="t_sep" data-field="x_nama_kelas" name="x_nama_kelas" id="x_nama_kelas" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nama_kelas->getPlaceHolder()) ?>" value="<?php echo $t_sep->nama_kelas->EditValue ?>"<?php echo $t_sep->nama_kelas->EditAttributes() ?>>
</span>
<?php echo $t_sep->nama_kelas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sep->table_source->Visible) { // table_source ?>
	<div id="r_table_source" class="form-group">
		<label id="elh_t_sep_table_source" for="x_table_source" class="col-sm-2 control-label ewLabel"><?php echo $t_sep->table_source->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_sep->table_source->CellAttributes() ?>>
<span id="el_t_sep_table_source">
<input type="text" data-table="t_sep" data-field="x_table_source" name="x_table_source" id="x_table_source" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->table_source->getPlaceHolder()) ?>" value="<?php echo $t_sep->table_source->EditValue ?>"<?php echo $t_sep->table_source->EditAttributes() ?>>
</span>
<?php echo $t_sep->table_source->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_sep_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_sep_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_sepadd.Init();
</script>
<?php
$t_sep_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_sep_add->Page_Terminate();
?>
