<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_sbpinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "t_sbp_detailgridcls.php" ?>
<?php include_once "vw_pajak_sbp_detailgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_sbp_add = NULL; // Initialize page object first

class ct_sbp_add extends ct_sbp {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sbp';

	// Page object name
	var $PageObjName = 't_sbp_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

			// Process auto fill for detail table 't_sbp_detail'
			if (@$_POST["grid"] == "ft_sbp_detailgrid") {
				if (!isset($GLOBALS["t_sbp_detail_grid"])) $GLOBALS["t_sbp_detail_grid"] = new ct_sbp_detail_grid;
				$GLOBALS["t_sbp_detail_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_pajak_sbp_detail'
			if (@$_POST["grid"] == "fvw_pajak_sbp_detailgrid") {
				if (!isset($GLOBALS["vw_pajak_sbp_detail_grid"])) $GLOBALS["vw_pajak_sbp_detail_grid"] = new cvw_pajak_sbp_detail_grid;
				$GLOBALS["vw_pajak_sbp_detail_grid"]->Page_Init();
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
		if (@$_POST["customexport"] == "") {

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		global $EW_EXPORT, $t_sbp;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
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
	if ($this->CustomExport <> "") { // Save temp images array for custom export
		if (is_array($gTmpImages))
			$_SESSION[EW_SESSION_TEMP_IMAGES] = $gTmpImages;
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("t_sbplist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_sbplist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_sbpview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->tipe_sbp->CurrentValue = NULL;
		$this->tipe_sbp->OldValue = $this->tipe_sbp->CurrentValue;
		$this->no_sbp->CurrentValue = NULL;
		$this->no_sbp->OldValue = $this->no_sbp->CurrentValue;
		$this->tgl_sbp->CurrentValue = date("d/m/Y");
		$this->program->CurrentValue = "1.02.037";
		$this->kegiatan->CurrentValue = "1.02.037.0009";
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
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
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
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->kode_opd->setDbValue($rs->fields('kode_opd'));
		$this->ppn->setDbValue($rs->fields('ppn'));
		$this->nama_bendahara_pengeluaran->setDbValue($rs->fields('nama_bendahara_pengeluaran'));
		$this->nip_bendahara_pengeluaran->setDbValue($rs->fields('nip_bendahara_pengeluaran'));
		$this->status_spj->setDbValue($rs->fields('status_spj'));
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
		$this->no_spj->DbValue = $row['no_spj'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->kode_opd->DbValue = $row['kode_opd'];
		$this->ppn->DbValue = $row['ppn'];
		$this->nama_bendahara_pengeluaran->DbValue = $row['nama_bendahara_pengeluaran'];
		$this->nip_bendahara_pengeluaran->DbValue = $row['nip_bendahara_pengeluaran'];
		$this->status_spj->DbValue = $row['status_spj'];
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
		// no_spj
		// tgl_spj
		// tahun_anggaran
		// kode_opd
		// ppn
		// nama_bendahara_pengeluaran
		// nip_bendahara_pengeluaran
		// status_spj

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// Add refer script
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

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("t_sbp_detail", $DetailTblVar) && $GLOBALS["t_sbp_detail"]->DetailAdd) {
			if (!isset($GLOBALS["t_sbp_detail_grid"])) $GLOBALS["t_sbp_detail_grid"] = new ct_sbp_detail_grid(); // get detail page object
			$GLOBALS["t_sbp_detail_grid"]->ValidateGridForm();
		}
		if (in_array("vw_pajak_sbp_detail", $DetailTblVar) && $GLOBALS["vw_pajak_sbp_detail"]->DetailAdd) {
			if (!isset($GLOBALS["vw_pajak_sbp_detail_grid"])) $GLOBALS["vw_pajak_sbp_detail_grid"] = new cvw_pajak_sbp_detail_grid(); // get detail page object
			$GLOBALS["vw_pajak_sbp_detail_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// tipe_sbp
		$this->tipe_sbp->SetDbValueDef($rsnew, $this->tipe_sbp->CurrentValue, NULL, FALSE);

		// no_sbp
		$this->no_sbp->SetDbValueDef($rsnew, $this->no_sbp->CurrentValue, NULL, FALSE);

		// tgl_sbp
		$this->tgl_sbp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 7), NULL, FALSE);

		// program
		$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, FALSE);

		// kegiatan
		$this->kegiatan->SetDbValueDef($rsnew, $this->kegiatan->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("t_sbp_detail", $DetailTblVar) && $GLOBALS["t_sbp_detail"]->DetailAdd) {
				$GLOBALS["t_sbp_detail"]->id_sbp->setSessionValue($this->id->CurrentValue); // Set master key
				$GLOBALS["t_sbp_detail"]->tipe_sbp->setSessionValue($this->tipe_sbp->CurrentValue); // Set master key
				$GLOBALS["t_sbp_detail"]->no_sbp->setSessionValue($this->no_sbp->CurrentValue); // Set master key
				$GLOBALS["t_sbp_detail"]->program->setSessionValue($this->program->CurrentValue); // Set master key
				$GLOBALS["t_sbp_detail"]->kegiatan->setSessionValue($this->kegiatan->CurrentValue); // Set master key
				$GLOBALS["t_sbp_detail"]->sub_kegiatan->setSessionValue($this->sub_kegiatan->CurrentValue); // Set master key
				$GLOBALS["t_sbp_detail"]->tahun_anggaran->setSessionValue($this->tahun_anggaran->CurrentValue); // Set master key
				if (!isset($GLOBALS["t_sbp_detail_grid"])) $GLOBALS["t_sbp_detail_grid"] = new ct_sbp_detail_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "t_sbp_detail"); // Load user level of detail table
				$AddRow = $GLOBALS["t_sbp_detail_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["t_sbp_detail"]->tahun_anggaran->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_pajak_sbp_detail", $DetailTblVar) && $GLOBALS["vw_pajak_sbp_detail"]->DetailAdd) {
				$GLOBALS["vw_pajak_sbp_detail"]->id_sbp->setSessionValue($this->id->CurrentValue); // Set master key
				$GLOBALS["vw_pajak_sbp_detail"]->tipe_sbp->setSessionValue($this->tipe_sbp->CurrentValue); // Set master key
				$GLOBALS["vw_pajak_sbp_detail"]->no_sbp->setSessionValue($this->no_sbp->CurrentValue); // Set master key
				$GLOBALS["vw_pajak_sbp_detail"]->program->setSessionValue($this->program->CurrentValue); // Set master key
				$GLOBALS["vw_pajak_sbp_detail"]->kegiatan->setSessionValue($this->kegiatan->CurrentValue); // Set master key
				$GLOBALS["vw_pajak_sbp_detail"]->sub_kegiatan->setSessionValue($this->sub_kegiatan->CurrentValue); // Set master key
				$GLOBALS["vw_pajak_sbp_detail"]->tahun_anggaran->setSessionValue($this->tahun_anggaran->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_pajak_sbp_detail_grid"])) $GLOBALS["vw_pajak_sbp_detail_grid"] = new cvw_pajak_sbp_detail_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_pajak_sbp_detail"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_pajak_sbp_detail_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_pajak_sbp_detail"]->tahun_anggaran->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
			if (in_array("t_sbp_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["t_sbp_detail_grid"]))
					$GLOBALS["t_sbp_detail_grid"] = new ct_sbp_detail_grid;
				if ($GLOBALS["t_sbp_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["t_sbp_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["t_sbp_detail_grid"]->CurrentMode = "add";
					$GLOBALS["t_sbp_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["t_sbp_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t_sbp_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["t_sbp_detail_grid"]->id_sbp->FldIsDetailKey = TRUE;
					$GLOBALS["t_sbp_detail_grid"]->id_sbp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t_sbp_detail_grid"]->id_sbp->setSessionValue($GLOBALS["t_sbp_detail_grid"]->id_sbp->CurrentValue);
					$GLOBALS["t_sbp_detail_grid"]->tipe_sbp->FldIsDetailKey = TRUE;
					$GLOBALS["t_sbp_detail_grid"]->tipe_sbp->CurrentValue = $this->tipe_sbp->CurrentValue;
					$GLOBALS["t_sbp_detail_grid"]->tipe_sbp->setSessionValue($GLOBALS["t_sbp_detail_grid"]->tipe_sbp->CurrentValue);
					$GLOBALS["t_sbp_detail_grid"]->no_sbp->FldIsDetailKey = TRUE;
					$GLOBALS["t_sbp_detail_grid"]->no_sbp->CurrentValue = $this->no_sbp->CurrentValue;
					$GLOBALS["t_sbp_detail_grid"]->no_sbp->setSessionValue($GLOBALS["t_sbp_detail_grid"]->no_sbp->CurrentValue);
					$GLOBALS["t_sbp_detail_grid"]->program->FldIsDetailKey = TRUE;
					$GLOBALS["t_sbp_detail_grid"]->program->CurrentValue = $this->program->CurrentValue;
					$GLOBALS["t_sbp_detail_grid"]->program->setSessionValue($GLOBALS["t_sbp_detail_grid"]->program->CurrentValue);
					$GLOBALS["t_sbp_detail_grid"]->kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["t_sbp_detail_grid"]->kegiatan->CurrentValue = $this->kegiatan->CurrentValue;
					$GLOBALS["t_sbp_detail_grid"]->kegiatan->setSessionValue($GLOBALS["t_sbp_detail_grid"]->kegiatan->CurrentValue);
					$GLOBALS["t_sbp_detail_grid"]->sub_kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["t_sbp_detail_grid"]->sub_kegiatan->CurrentValue = $this->sub_kegiatan->CurrentValue;
					$GLOBALS["t_sbp_detail_grid"]->sub_kegiatan->setSessionValue($GLOBALS["t_sbp_detail_grid"]->sub_kegiatan->CurrentValue);
					$GLOBALS["t_sbp_detail_grid"]->tahun_anggaran->FldIsDetailKey = TRUE;
					$GLOBALS["t_sbp_detail_grid"]->tahun_anggaran->CurrentValue = $this->tahun_anggaran->CurrentValue;
					$GLOBALS["t_sbp_detail_grid"]->tahun_anggaran->setSessionValue($GLOBALS["t_sbp_detail_grid"]->tahun_anggaran->CurrentValue);
				}
			}
			if (in_array("vw_pajak_sbp_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_pajak_sbp_detail_grid"]))
					$GLOBALS["vw_pajak_sbp_detail_grid"] = new cvw_pajak_sbp_detail_grid;
				if ($GLOBALS["vw_pajak_sbp_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_pajak_sbp_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_pajak_sbp_detail_grid"]->CurrentMode = "add";
					$GLOBALS["vw_pajak_sbp_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["vw_pajak_sbp_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->id_sbp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->id_sbp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->id_sbp->setSessionValue($GLOBALS["vw_pajak_sbp_detail_grid"]->id_sbp->CurrentValue);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->tipe_sbp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->tipe_sbp->CurrentValue = $this->tipe_sbp->CurrentValue;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->tipe_sbp->setSessionValue($GLOBALS["vw_pajak_sbp_detail_grid"]->tipe_sbp->CurrentValue);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->no_sbp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->no_sbp->CurrentValue = $this->no_sbp->CurrentValue;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->no_sbp->setSessionValue($GLOBALS["vw_pajak_sbp_detail_grid"]->no_sbp->CurrentValue);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->program->FldIsDetailKey = TRUE;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->program->CurrentValue = $this->program->CurrentValue;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->program->setSessionValue($GLOBALS["vw_pajak_sbp_detail_grid"]->program->CurrentValue);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->kegiatan->CurrentValue = $this->kegiatan->CurrentValue;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->kegiatan->setSessionValue($GLOBALS["vw_pajak_sbp_detail_grid"]->kegiatan->CurrentValue);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->sub_kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->sub_kegiatan->CurrentValue = $this->sub_kegiatan->CurrentValue;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->sub_kegiatan->setSessionValue($GLOBALS["vw_pajak_sbp_detail_grid"]->sub_kegiatan->CurrentValue);
					$GLOBALS["vw_pajak_sbp_detail_grid"]->tahun_anggaran->FldIsDetailKey = TRUE;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->tahun_anggaran->CurrentValue = $this->tahun_anggaran->CurrentValue;
					$GLOBALS["vw_pajak_sbp_detail_grid"]->tahun_anggaran->setSessionValue($GLOBALS["vw_pajak_sbp_detail_grid"]->tahun_anggaran->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_sbplist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
			$lookuptblfilter = "`jabatan`=4";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t_sbp_add)) $t_sbp_add = new ct_sbp_add();

// Page init
$t_sbp_add->Page_Init();

// Page main
$t_sbp_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sbp_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_sbpadd = new ew_Form("ft_sbpadd", "add");

// Validate form
ft_sbpadd.Validate = function() {
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
ft_sbpadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sbpadd.ValidateRequired = true;
<?php } else { ?>
ft_sbpadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sbpadd.Lists["x_tipe_sbp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sbpadd.Lists["x_tipe_sbp"].Options = <?php echo json_encode($t_sbp->tipe_sbp->Options()) ?>;
ft_sbpadd.Lists["x_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
ft_sbpadd.Lists["x_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_program"],"ChildFields":["x_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
ft_sbpadd.Lists["x_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_kegiatan"],"ChildFields":[],"FilterFields":["x_kode_kegiatan"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};
ft_sbpadd.Lists["x_nama_pptk"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_sbp_add->IsModal) { ?>
<?php } ?>
<?php $t_sbp_add->ShowPageHeader(); ?>
<?php
$t_sbp_add->ShowMessage();
?>
<form name="ft_sbpadd" id="ft_sbpadd" class="<?php echo $t_sbp_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_sbp_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_sbp_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_sbp">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_sbp_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_t_sbpadd" class="ewCustomTemplate"></div>
<script id="tpm_t_sbpadd" type="text/html">
<div id="ct_t_sbp_add"><div id="ct_sample_add">
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong></strong></div>
  <div class="panel-body">
 <!-- Start   KOLOM 1 -->
  <div class="col-lg-6 col-md-6 col-sm-6">
	<!-- <div id="r_id_jenis_spp" class="form-group">
	<label id="elh_id_jenis_spp" for="x_id_jenis_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->tipe->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_tipe"/}}</div>
	</div> -->
	<div id="r_detail_jenis_spp" class="form-group">
	<label id="elh_detail_jenis_spp" for="x_detail_jenis_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->tipe_sbp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_tipe_sbp"/}}</div>
	</div>
	<div id="r_status_spp" class="form-group">
	<label id="elh_status_spp" for="x_status_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->no_sbp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_no_sbp"/}}</div>
	</div>
	<div id="r_no_spp" class="form-group">
	<label id="elh_no_spp" for="x_no_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->tgl_sbp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_tgl_sbp"/}}</div>
	</div>
	<div id="r_tgl_spp" class="form-group">
	<label id="elh_tgl_spp" for="x_tgl_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->nama_pptk->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_nama_pptk"/}}</div>
	</div>
	<div id="r_kode_program" class="form-group">
	<label id="elh_kode_program" for="x_kode_program" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->program->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_program"/}}</div>
	</div>
	<div id="r_kode_kegiatan" class="form-group">
	<label id="elh_kode_kegiatan" for="x_kode_kegiatan" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->kegiatan->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_kegiatan"/}}</div>
	</div>
	<div id="r_kode_sub_kegiatan" class="form-group">
	<label id="elh_kode_sub_kegiatan" for="x_kode_sub_kegiatan" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->sub_kegiatan->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_sub_kegiatan"/}}</div>
	</div>
	<div id="r_keterangan" class="form-group">
	<label id="elh_keterangan" for="x_keterangan" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->uraian->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_uraian"/}}</div>
	</div>
	<div id="r_nama_penerima" class="form-group">
	<label id="elh_nama_penerima" for="x_nama_penerima" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->nama_penerima->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_nama_penerima"/}}</div>
	</div>
	<div id="r_alamat_penerima" class="form-group">
	<label id="elh_alamat_penerima" for="x_alamat_penerima" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->alamat_penerima->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_alamat_penerima"/}}</div>
	</div>
	<div id="r_nama_bendahara" class="form-group">
	<label id="elh_nama_bendahara" for="x_nama_bendahara" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->nip_pptk->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_nip_pptk"/}}</div>
	</div>
  </div>
 <!-- end   KOLOM 1 -->
 <!-- Start   KOLOM 2 -->
  <div class="col-lg-6 col-md-6 col-sm-6">
	<!-- <div id="r_akun1" class="form-group">
	<label id="elh_akun1" for="x_akun1" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->akun1->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_akun1"/}}</div>
	</div>
	<div id="r_akun2" class="form-group">
	<label id="elh_akun2" for="x_akun2" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->akun2->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_akun2"/}}</div>
	</div>
	<div id="r_akun3" class="form-group">
	<label id="elh_akun3" for="x_akun3" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->akun3->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_akun3"/}}</div>
	</div>
	<div id="r_akun4" class="form-group">
	<label id="elh_akun4" for="x_akun4" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->akun4->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_akun4"/}}</div>
	</div>
	<div id="r_akun5" class="form-group">
	<label id="elh_akun5" for="x_akun5" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->akun5->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_akun5"/}}</div>
	</div>
	<div id="r_jumlah_belanja" class="form-group">
	<label id="elh_jumlah_belanja" for="x_jumlah_belanja" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->jumlah_belanja->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_jumlah_belanja"/}}</div>
	</div>
-->
	<!--
	<div id="r_kode_rekening" class="form-group">
	<label id="elh_kode_rekening" for="x_kode_rekening" class="col-sm-3 control-label ewLabel">
	<?php echo $t_sbp->kode_rekening->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_sbp_kode_rekening"/}}</div>
	</div> -->
  </div>
   <!-- End   KOLOM 2 -->
</div>
</div>
</div>
</script>
<div style="display: none">
<?php if ($t_sbp->tipe_sbp->Visible) { // tipe_sbp ?>
	<div id="r_tipe_sbp" class="form-group">
		<label id="elh_t_sbp_tipe_sbp" for="x_tipe_sbp" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_tipe_sbp" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->tipe_sbp->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->tipe_sbp->CellAttributes() ?>>
<script id="tpx_t_sbp_tipe_sbp" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_tipe_sbp">
<select data-table="t_sbp" data-field="x_tipe_sbp" data-value-separator="<?php echo $t_sbp->tipe_sbp->DisplayValueSeparatorAttribute() ?>" id="x_tipe_sbp" name="x_tipe_sbp"<?php echo $t_sbp->tipe_sbp->EditAttributes() ?>>
<?php echo $t_sbp->tipe_sbp->SelectOptionListHtml("x_tipe_sbp") ?>
</select>
</span>
</script>
<?php echo $t_sbp->tipe_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->no_sbp->Visible) { // no_sbp ?>
	<div id="r_no_sbp" class="form-group">
		<label id="elh_t_sbp_no_sbp" for="x_no_sbp" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_no_sbp" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->no_sbp->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->no_sbp->CellAttributes() ?>>
<script id="tpx_t_sbp_no_sbp" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_no_sbp">
<input type="text" data-table="t_sbp" data-field="x_no_sbp" name="x_no_sbp" id="x_no_sbp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->no_sbp->getPlaceHolder()) ?>" value="<?php echo $t_sbp->no_sbp->EditValue ?>"<?php echo $t_sbp->no_sbp->EditAttributes() ?>>
</span>
</script>
<?php echo $t_sbp->no_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->tgl_sbp->Visible) { // tgl_sbp ?>
	<div id="r_tgl_sbp" class="form-group">
		<label id="elh_t_sbp_tgl_sbp" for="x_tgl_sbp" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_tgl_sbp" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->tgl_sbp->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->tgl_sbp->CellAttributes() ?>>
<script id="tpx_t_sbp_tgl_sbp" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_tgl_sbp">
<input type="text" data-table="t_sbp" data-field="x_tgl_sbp" data-format="7" name="x_tgl_sbp" id="x_tgl_sbp" placeholder="<?php echo ew_HtmlEncode($t_sbp->tgl_sbp->getPlaceHolder()) ?>" value="<?php echo $t_sbp->tgl_sbp->EditValue ?>"<?php echo $t_sbp->tgl_sbp->EditAttributes() ?>>
<?php if (!$t_sbp->tgl_sbp->ReadOnly && !$t_sbp->tgl_sbp->Disabled && !isset($t_sbp->tgl_sbp->EditAttrs["readonly"]) && !isset($t_sbp->tgl_sbp->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="t_sbpadd_js">
ew_CreateCalendar("ft_sbpadd", "x_tgl_sbp", 7);
</script>
<?php echo $t_sbp->tgl_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_t_sbp_program" for="x_program" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_program" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->program->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->program->CellAttributes() ?>>
<script id="tpx_t_sbp_program" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_program">
<?php $t_sbp->program->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->program->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_program" data-value-separator="<?php echo $t_sbp->program->DisplayValueSeparatorAttribute() ?>" id="x_program" name="x_program"<?php echo $t_sbp->program->EditAttributes() ?>>
<?php echo $t_sbp->program->SelectOptionListHtml("x_program") ?>
</select>
<input type="hidden" name="s_x_program" id="s_x_program" value="<?php echo $t_sbp->program->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_sbp->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->kegiatan->Visible) { // kegiatan ?>
	<div id="r_kegiatan" class="form-group">
		<label id="elh_t_sbp_kegiatan" for="x_kegiatan" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_kegiatan" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->kegiatan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->kegiatan->CellAttributes() ?>>
<script id="tpx_t_sbp_kegiatan" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_kegiatan">
<?php $t_sbp->kegiatan->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_sbp->kegiatan->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_kegiatan" data-value-separator="<?php echo $t_sbp->kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kegiatan" name="x_kegiatan"<?php echo $t_sbp->kegiatan->EditAttributes() ?>>
<?php echo $t_sbp->kegiatan->SelectOptionListHtml("x_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kegiatan" id="s_x_kegiatan" value="<?php echo $t_sbp->kegiatan->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_sbp->kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<div id="r_sub_kegiatan" class="form-group">
		<label id="elh_t_sbp_sub_kegiatan" for="x_sub_kegiatan" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_sub_kegiatan" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->sub_kegiatan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->sub_kegiatan->CellAttributes() ?>>
<script id="tpx_t_sbp_sub_kegiatan" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_sub_kegiatan">
<select data-table="t_sbp" data-field="x_sub_kegiatan" data-value-separator="<?php echo $t_sbp->sub_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_sub_kegiatan" name="x_sub_kegiatan"<?php echo $t_sbp->sub_kegiatan->EditAttributes() ?>>
<?php echo $t_sbp->sub_kegiatan->SelectOptionListHtml("x_sub_kegiatan") ?>
</select>
<input type="hidden" name="s_x_sub_kegiatan" id="s_x_sub_kegiatan" value="<?php echo $t_sbp->sub_kegiatan->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_sbp->sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->uraian->Visible) { // uraian ?>
	<div id="r_uraian" class="form-group">
		<label id="elh_t_sbp_uraian" for="x_uraian" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_uraian" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->uraian->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->uraian->CellAttributes() ?>>
<script id="tpx_t_sbp_uraian" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_uraian">
<input type="text" data-table="t_sbp" data-field="x_uraian" name="x_uraian" id="x_uraian" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->uraian->getPlaceHolder()) ?>" value="<?php echo $t_sbp->uraian->EditValue ?>"<?php echo $t_sbp->uraian->EditAttributes() ?>>
</span>
</script>
<?php echo $t_sbp->uraian->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nama_penerima->Visible) { // nama_penerima ?>
	<div id="r_nama_penerima" class="form-group">
		<label id="elh_t_sbp_nama_penerima" for="x_nama_penerima" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_nama_penerima" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->nama_penerima->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nama_penerima->CellAttributes() ?>>
<script id="tpx_t_sbp_nama_penerima" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_nama_penerima">
<input type="text" data-table="t_sbp" data-field="x_nama_penerima" name="x_nama_penerima" id="x_nama_penerima" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->nama_penerima->getPlaceHolder()) ?>" value="<?php echo $t_sbp->nama_penerima->EditValue ?>"<?php echo $t_sbp->nama_penerima->EditAttributes() ?>>
</span>
</script>
<?php echo $t_sbp->nama_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->alamat_penerima->Visible) { // alamat_penerima ?>
	<div id="r_alamat_penerima" class="form-group">
		<label id="elh_t_sbp_alamat_penerima" for="x_alamat_penerima" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_alamat_penerima" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->alamat_penerima->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->alamat_penerima->CellAttributes() ?>>
<script id="tpx_t_sbp_alamat_penerima" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_alamat_penerima">
<input type="text" data-table="t_sbp" data-field="x_alamat_penerima" name="x_alamat_penerima" id="x_alamat_penerima" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->alamat_penerima->getPlaceHolder()) ?>" value="<?php echo $t_sbp->alamat_penerima->EditValue ?>"<?php echo $t_sbp->alamat_penerima->EditAttributes() ?>>
</span>
</script>
<?php echo $t_sbp->alamat_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nama_pptk->Visible) { // nama_pptk ?>
	<div id="r_nama_pptk" class="form-group">
		<label id="elh_t_sbp_nama_pptk" for="x_nama_pptk" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_nama_pptk" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->nama_pptk->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nama_pptk->CellAttributes() ?>>
<script id="tpx_t_sbp_nama_pptk" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_nama_pptk">
<?php $t_sbp->nama_pptk->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$t_sbp->nama_pptk->EditAttrs["onchange"]; ?>
<select data-table="t_sbp" data-field="x_nama_pptk" data-value-separator="<?php echo $t_sbp->nama_pptk->DisplayValueSeparatorAttribute() ?>" id="x_nama_pptk" name="x_nama_pptk"<?php echo $t_sbp->nama_pptk->EditAttributes() ?>>
<?php echo $t_sbp->nama_pptk->SelectOptionListHtml("x_nama_pptk") ?>
</select>
<input type="hidden" name="s_x_nama_pptk" id="s_x_nama_pptk" value="<?php echo $t_sbp->nama_pptk->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_pptk" id="ln_x_nama_pptk" value="x_nip_pptk">
</span>
</script>
<?php echo $t_sbp->nama_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_sbp->nip_pptk->Visible) { // nip_pptk ?>
	<div id="r_nip_pptk" class="form-group">
		<label id="elh_t_sbp_nip_pptk" for="x_nip_pptk" class="col-sm-2 control-label ewLabel"><script id="tpc_t_sbp_nip_pptk" class="t_sbpadd" type="text/html"><span><?php echo $t_sbp->nip_pptk->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_sbp->nip_pptk->CellAttributes() ?>>
<script id="tpx_t_sbp_nip_pptk" class="t_sbpadd" type="text/html">
<span id="el_t_sbp_nip_pptk">
<input type="text" data-table="t_sbp" data-field="x_nip_pptk" name="x_nip_pptk" id="x_nip_pptk" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sbp->nip_pptk->getPlaceHolder()) ?>" value="<?php echo $t_sbp->nip_pptk->EditValue ?>"<?php echo $t_sbp->nip_pptk->EditAttributes() ?>>
</span>
</script>
<?php echo $t_sbp->nip_pptk->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("t_sbp_detail", explode(",", $t_sbp->getCurrentDetailTable())) && $t_sbp_detail->DetailAdd) {
?>
<?php if ($t_sbp->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("t_sbp_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "t_sbp_detailgrid.php" ?>
<?php } ?>
<?php
	if (in_array("vw_pajak_sbp_detail", explode(",", $t_sbp->getCurrentDetailTable())) && $vw_pajak_sbp_detail->DetailAdd) {
?>
<?php if ($t_sbp->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("vw_pajak_sbp_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "vw_pajak_sbp_detailgrid.php" ?>
<?php } ?>
<?php if (!$t_sbp_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_sbp_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_t_sbpadd", "tpm_t_sbpadd", "t_sbpadd", "<?php echo $t_sbp->CustomExport ?>");
jQuery("script.t_sbpadd_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
ft_sbpadd.Init();
</script>
<?php
$t_sbp_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_sbp_add->Page_Terminate();
?>
