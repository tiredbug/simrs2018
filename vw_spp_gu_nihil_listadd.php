<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_gu_nihil_listinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_gu_nihil_list_add = NULL; // Initialize page object first

class cvw_spp_gu_nihil_list_add extends cvw_spp_gu_nihil_list {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_gu_nihil_list';

	// Page object name
	var $PageObjName = 'vw_spp_gu_nihil_list_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
		$this->tahun_anggaran->SetVisibility();
		$this->id_spj->SetVisibility();
		$this->id_spd->SetVisibility();

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
					$this->Page_Terminate("vw_spp_gu_nihil_listlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_spp_gu_nihil_listlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_spp_gu_nihil_listview.php")
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
		$this->id_jenis_spp->CurrentValue = 2;
		$this->detail_jenis_spp->CurrentValue = 2;
		$this->status_spp->CurrentValue = NULL;
		$this->status_spp->OldValue = $this->status_spp->CurrentValue;
		$this->no_spp->CurrentValue = NULL;
		$this->no_spp->OldValue = $this->no_spp->CurrentValue;
		$this->tgl_spp->CurrentValue = date("d/m/Y");
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->nama_bendahara->CurrentValue = NULL;
		$this->nama_bendahara->OldValue = $this->nama_bendahara->CurrentValue;
		$this->nip_bendahara->CurrentValue = NULL;
		$this->nip_bendahara->OldValue = $this->nip_bendahara->CurrentValue;
		$this->nama_pptk->CurrentValue = NULL;
		$this->nama_pptk->OldValue = $this->nama_pptk->CurrentValue;
		$this->nip_pptk->CurrentValue = NULL;
		$this->nip_pptk->OldValue = $this->nip_pptk->CurrentValue;
		$this->kode_program->CurrentValue = NULL;
		$this->kode_program->OldValue = $this->kode_program->CurrentValue;
		$this->kode_kegiatan->CurrentValue = NULL;
		$this->kode_kegiatan->OldValue = $this->kode_kegiatan->CurrentValue;
		$this->kode_sub_kegiatan->CurrentValue = NULL;
		$this->kode_sub_kegiatan->OldValue = $this->kode_sub_kegiatan->CurrentValue;
		$this->tahun_anggaran->CurrentValue = 2018;
		$this->id_spj->CurrentValue = NULL;
		$this->id_spj->OldValue = $this->id_spj->CurrentValue;
		$this->id_spd->CurrentValue = NULL;
		$this->id_spd->OldValue = $this->id_spd->CurrentValue;
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
		if (!$this->tahun_anggaran->FldIsDetailKey) {
			$this->tahun_anggaran->setFormValue($objForm->GetValue("x_tahun_anggaran"));
		}
		if (!$this->id_spj->FldIsDetailKey) {
			$this->id_spj->setFormValue($objForm->GetValue("x_id_spj"));
		}
		if (!$this->id_spd->FldIsDetailKey) {
			$this->id_spd->setFormValue($objForm->GetValue("x_id_spd"));
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
		$this->nama_bendahara->CurrentValue = $this->nama_bendahara->FormValue;
		$this->nip_bendahara->CurrentValue = $this->nip_bendahara->FormValue;
		$this->nama_pptk->CurrentValue = $this->nama_pptk->FormValue;
		$this->nip_pptk->CurrentValue = $this->nip_pptk->FormValue;
		$this->kode_program->CurrentValue = $this->kode_program->FormValue;
		$this->kode_kegiatan->CurrentValue = $this->kode_kegiatan->FormValue;
		$this->kode_sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->FormValue;
		$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->FormValue;
		$this->id_spj->CurrentValue = $this->id_spj->FormValue;
		$this->id_spd->CurrentValue = $this->id_spd->FormValue;
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
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->id_spj->setDbValue($rs->fields('id_spj'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
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
		$this->keterangan->DbValue = $row['keterangan'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->nama_pptk->DbValue = $row['nama_pptk'];
		$this->nip_pptk->DbValue = $row['nip_pptk'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->id_spj->DbValue = $row['id_spj'];
		$this->id_spd->DbValue = $row['id_spd'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
		$this->nomer_dasar_spd->DbValue = $row['nomer_dasar_spd'];
		$this->tanggal_spd->DbValue = $row['tanggal_spd'];
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
		// tahun_anggaran
		// id_spj
		// id_spd
		// jumlah_spd
		// nomer_dasar_spd
		// tanggal_spd

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

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// id_spj
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		if (strval($this->id_spj->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spj->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_spj` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spj`";
		$sWhereWrk = "";
		$this->id_spj->LookupFilters = array("dx1" => '`no_spj`');
		$lookuptblfilter = "`jenis_spj`=2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_spj, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_spj->ViewValue = $this->id_spj->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
			}
		} else {
			$this->id_spj->ViewValue = NULL;
		}
		$this->id_spj->ViewCustomAttributes = "";

		// id_spd
		$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
		if (strval($this->id_spd->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spd->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_spd` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spd`";
		$sWhereWrk = "";
		$this->id_spd->LookupFilters = array("dx1" => '`no_spd`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_spd, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_spd->ViewValue = $this->id_spd->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
			}
		} else {
			$this->id_spd->ViewValue = NULL;
		}
		$this->id_spd->ViewCustomAttributes = "";

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

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

			// id_spj
			$this->id_spj->LinkCustomAttributes = "";
			$this->id_spj->HrefValue = "";
			$this->id_spj->TooltipValue = "";

			// id_spd
			$this->id_spd->LinkCustomAttributes = "";
			$this->id_spd->HrefValue = "";
			$this->id_spd->TooltipValue = "";
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

			// tahun_anggaran
			$this->tahun_anggaran->EditAttrs["class"] = "form-control";
			$this->tahun_anggaran->EditCustomAttributes = "";
			$this->tahun_anggaran->EditValue = ew_HtmlEncode($this->tahun_anggaran->CurrentValue);
			$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

			// id_spj
			$this->id_spj->EditAttrs["class"] = "form-control";
			$this->id_spj->EditCustomAttributes = "";
			$this->id_spj->EditValue = ew_HtmlEncode($this->id_spj->CurrentValue);
			if (strval($this->id_spj->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spj->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `no_spj` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spj`";
			$sWhereWrk = "";
			$this->id_spj->LookupFilters = array("dx1" => '`no_spj`');
			$lookuptblfilter = "`jenis_spj`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_spj, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->id_spj->EditValue = $this->id_spj->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->id_spj->EditValue = ew_HtmlEncode($this->id_spj->CurrentValue);
				}
			} else {
				$this->id_spj->EditValue = NULL;
			}
			$this->id_spj->PlaceHolder = ew_RemoveHtml($this->id_spj->FldCaption());

			// id_spd
			$this->id_spd->EditAttrs["class"] = "form-control";
			$this->id_spd->EditCustomAttributes = "";
			$this->id_spd->EditValue = ew_HtmlEncode($this->id_spd->CurrentValue);
			if (strval($this->id_spd->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spd->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `no_spd` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spd`";
			$sWhereWrk = "";
			$this->id_spd->LookupFilters = array("dx1" => '`no_spd`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_spd, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->id_spd->EditValue = $this->id_spd->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->id_spd->EditValue = ew_HtmlEncode($this->id_spd->CurrentValue);
				}
			} else {
				$this->id_spd->EditValue = NULL;
			}
			$this->id_spd->PlaceHolder = ew_RemoveHtml($this->id_spd->FldCaption());

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

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";

			// id_spj
			$this->id_spj->LinkCustomAttributes = "";
			$this->id_spj->HrefValue = "";

			// id_spd
			$this->id_spd->LinkCustomAttributes = "";
			$this->id_spd->HrefValue = "";
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
		if (!ew_CheckInteger($this->tahun_anggaran->FormValue)) {
			ew_AddMessage($gsFormError, $this->tahun_anggaran->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_spj->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_spj->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_spd->FldErrMsg());
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
		if ($this->id_spj->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(id_spj = " . ew_AdjustSql($this->id_spj->CurrentValue, $this->DBID) . ")";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->id_spj->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->id_spj->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
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

		// nama_bendahara
		$this->nama_bendahara->SetDbValueDef($rsnew, $this->nama_bendahara->CurrentValue, NULL, FALSE);

		// nip_bendahara
		$this->nip_bendahara->SetDbValueDef($rsnew, $this->nip_bendahara->CurrentValue, NULL, FALSE);

		// nama_pptk
		$this->nama_pptk->SetDbValueDef($rsnew, $this->nama_pptk->CurrentValue, NULL, FALSE);

		// nip_pptk
		$this->nip_pptk->SetDbValueDef($rsnew, $this->nip_pptk->CurrentValue, NULL, FALSE);

		// kode_program
		$this->kode_program->SetDbValueDef($rsnew, $this->kode_program->CurrentValue, NULL, FALSE);

		// kode_kegiatan
		$this->kode_kegiatan->SetDbValueDef($rsnew, $this->kode_kegiatan->CurrentValue, NULL, FALSE);

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->SetDbValueDef($rsnew, $this->kode_sub_kegiatan->CurrentValue, NULL, FALSE);

		// tahun_anggaran
		$this->tahun_anggaran->SetDbValueDef($rsnew, $this->tahun_anggaran->CurrentValue, NULL, strval($this->tahun_anggaran->CurrentValue) == "");

		// id_spj
		$this->id_spj->SetDbValueDef($rsnew, $this->id_spj->CurrentValue, NULL, FALSE);

		// id_spd
		$this->id_spd->SetDbValueDef($rsnew, $this->id_spd->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_gu_nihil_listlist.php"), "", $this->TableVar, TRUE);
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
		case "x_id_spj":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_spj` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spj`";
			$sWhereWrk = "{filter}";
			$this->id_spj->LookupFilters = array("dx1" => '`no_spj`');
			$lookuptblfilter = "`jenis_spj`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_spj, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_id_spd":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_spd` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spd`";
			$sWhereWrk = "{filter}";
			$this->id_spd->LookupFilters = array("dx1" => '`no_spd`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_spd, $sWhereWrk); // Call Lookup selecting
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
		case "x_id_spj":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_spj` AS `DispFld` FROM `t_spj`";
			$sWhereWrk = "`no_spj` LIKE '%{query_value}%'";
			$this->id_spj->LookupFilters = array("dx1" => '`no_spj`');
			$lookuptblfilter = "`jenis_spj`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_spj, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_id_spd":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_spd` AS `DispFld` FROM `t_spd`";
			$sWhereWrk = "`no_spd` LIKE '%{query_value}%'";
			$this->id_spd->LookupFilters = array("dx1" => '`no_spd`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_spd, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($vw_spp_gu_nihil_list_add)) $vw_spp_gu_nihil_list_add = new cvw_spp_gu_nihil_list_add();

// Page init
$vw_spp_gu_nihil_list_add->Page_Init();

// Page main
$vw_spp_gu_nihil_list_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_gu_nihil_list_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_spp_gu_nihil_listadd = new ew_Form("fvw_spp_gu_nihil_listadd", "add");

// Validate form
fvw_spp_gu_nihil_listadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tahun_anggaran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_gu_nihil_list->tahun_anggaran->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_spj");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_gu_nihil_list->id_spj->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_spd");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_gu_nihil_list->id_spd->FldErrMsg()) ?>");

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
fvw_spp_gu_nihil_listadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_gu_nihil_listadd.ValidateRequired = true;
<?php } else { ?>
fvw_spp_gu_nihil_listadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_gu_nihil_listadd.Lists["x_id_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_spp"};
fvw_spp_gu_nihil_listadd.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
fvw_spp_gu_nihil_listadd.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spp_gu_nihil_listadd.Lists["x_status_spp"].Options = <?php echo json_encode($vw_spp_gu_nihil_list->status_spp->Options()) ?>;
fvw_spp_gu_nihil_listadd.Lists["x_nama_bendahara"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
fvw_spp_gu_nihil_listadd.Lists["x_nama_pptk"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
fvw_spp_gu_nihil_listadd.Lists["x_kode_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kode_kegiatan","x_kode_sub_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
fvw_spp_gu_nihil_listadd.Lists["x_kode_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_kode_program"],"ChildFields":["x_kode_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
fvw_spp_gu_nihil_listadd.Lists["x_kode_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_kode_kegiatan","x_kode_program"],"ChildFields":[],"FilterFields":["x_kode_kegiatan","x_kode_program"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};
fvw_spp_gu_nihil_listadd.Lists["x_id_spj"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_spj","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_spj"};
fvw_spp_gu_nihil_listadd.Lists["x_id_spd"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_spd","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"t_spd"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_gu_nihil_list_add->IsModal) { ?>
<?php } ?>
<?php $vw_spp_gu_nihil_list_add->ShowPageHeader(); ?>
<?php
$vw_spp_gu_nihil_list_add->ShowMessage();
?>
<form name="fvw_spp_gu_nihil_listadd" id="fvw_spp_gu_nihil_listadd" class="<?php echo $vw_spp_gu_nihil_list_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_gu_nihil_list_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_gu_nihil_list_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_gu_nihil_list">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_spp_gu_nihil_list_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
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
ew_CreateCalendar("fvw_spp_gu_nihil_listadd", "x_tgl_spp", 7);
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
<?php if ($vw_spp_gu_nihil_list->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<div id="r_tahun_anggaran" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_tahun_anggaran" for="x_tahun_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->tahun_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->tahun_anggaran->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_tahun_anggaran">
<input type="text" data-table="vw_spp_gu_nihil_list" data-field="x_tahun_anggaran" name="x_tahun_anggaran" id="x_tahun_anggaran" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->tahun_anggaran->getPlaceHolder()) ?>" value="<?php echo $vw_spp_gu_nihil_list->tahun_anggaran->EditValue ?>"<?php echo $vw_spp_gu_nihil_list->tahun_anggaran->EditAttributes() ?>>
</span>
<?php echo $vw_spp_gu_nihil_list->tahun_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->id_spj->Visible) { // id_spj ?>
	<div id="r_id_spj" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_id_spj" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->id_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->id_spj->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_id_spj">
<?php
$wrkonchange = trim(" " . @$vw_spp_gu_nihil_list->id_spj->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_spp_gu_nihil_list->id_spj->EditAttrs["onchange"] = "";
?>
<span id="as_x_id_spj" style="white-space: nowrap; z-index: 8840">
	<input type="text" name="sv_x_id_spj" id="sv_x_id_spj" value="<?php echo $vw_spp_gu_nihil_list->id_spj->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->id_spj->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->id_spj->getPlaceHolder()) ?>"<?php echo $vw_spp_gu_nihil_list->id_spj->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_gu_nihil_list" data-field="x_id_spj" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $vw_spp_gu_nihil_list->id_spj->DisplayValueSeparatorAttribute() ?>" name="x_id_spj" id="x_id_spj" value="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->id_spj->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_id_spj" id="q_x_id_spj" value="<?php echo $vw_spp_gu_nihil_list->id_spj->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_spp_gu_nihil_listadd.CreateAutoSuggest({"id":"x_id_spj","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($vw_spp_gu_nihil_list->id_spj->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_id_spj',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_id_spj" id="s_x_id_spj" value="<?php echo $vw_spp_gu_nihil_list->id_spj->LookupFilterQuery(false) ?>">
</span>
<?php echo $vw_spp_gu_nihil_list->id_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_gu_nihil_list->id_spd->Visible) { // id_spd ?>
	<div id="r_id_spd" class="form-group">
		<label id="elh_vw_spp_gu_nihil_list_id_spd" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_gu_nihil_list->id_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_gu_nihil_list->id_spd->CellAttributes() ?>>
<span id="el_vw_spp_gu_nihil_list_id_spd">
<?php
$wrkonchange = trim(" " . @$vw_spp_gu_nihil_list->id_spd->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_spp_gu_nihil_list->id_spd->EditAttrs["onchange"] = "";
?>
<span id="as_x_id_spd" style="white-space: nowrap; z-index: 8830">
	<input type="text" name="sv_x_id_spd" id="sv_x_id_spd" value="<?php echo $vw_spp_gu_nihil_list->id_spd->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->id_spd->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->id_spd->getPlaceHolder()) ?>"<?php echo $vw_spp_gu_nihil_list->id_spd->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_spp_gu_nihil_list" data-field="x_id_spd" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $vw_spp_gu_nihil_list->id_spd->DisplayValueSeparatorAttribute() ?>" name="x_id_spd" id="x_id_spd" value="<?php echo ew_HtmlEncode($vw_spp_gu_nihil_list->id_spd->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_id_spd" id="q_x_id_spd" value="<?php echo $vw_spp_gu_nihil_list->id_spd->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_spp_gu_nihil_listadd.CreateAutoSuggest({"id":"x_id_spd","forceSelect":false});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($vw_spp_gu_nihil_list->id_spd->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_id_spd',m:0,n:10,srch:true});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_id_spd" id="s_x_id_spd" value="<?php echo $vw_spp_gu_nihil_list->id_spd->LookupFilterQuery(false) ?>">
</span>
<?php echo $vw_spp_gu_nihil_list->id_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_spp_gu_nihil_list_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spp_gu_nihil_list_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spp_gu_nihil_listadd.Init();
</script>
<?php
$vw_spp_gu_nihil_list_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_gu_nihil_list_add->Page_Terminate();
?>
