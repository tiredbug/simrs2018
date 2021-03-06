<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_pengembalian_penerimaaninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_spp_pengembalian_penerimaan_detail_belanjagridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_pengembalian_penerimaan_add = NULL; // Initialize page object first

class cvw_spp_pengembalian_penerimaan_add extends cvw_spp_pengembalian_penerimaan {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_pengembalian_penerimaan';

	// Page object name
	var $PageObjName = 'vw_spp_pengembalian_penerimaan_add';

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

		// Table object (vw_spp_pengembalian_penerimaan)
		if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan"]) || get_class($GLOBALS["vw_spp_pengembalian_penerimaan"]) == "cvw_spp_pengembalian_penerimaan") {
			$GLOBALS["vw_spp_pengembalian_penerimaan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_pengembalian_penerimaan"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_pengembalian_penerimaan', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_pengembalian_penerimaanlist.php"));
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

			// Process auto fill for detail table 'vw_spp_pengembalian_penerimaan_detail_belanja'
			if (@$_POST["grid"] == "fvw_spp_pengembalian_penerimaan_detail_belanjagrid") {
				if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"])) $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"] = new cvw_spp_pengembalian_penerimaan_detail_belanja_grid;
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->Page_Init();
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
		global $EW_EXPORT, $vw_spp_pengembalian_penerimaan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_pengembalian_penerimaan);
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
					$this->Page_Terminate("vw_spp_pengembalian_penerimaanlist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "vw_spp_pengembalian_penerimaanlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_spp_pengembalian_penerimaanview.php")
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
		$this->id_jenis_spp->CurrentValue = 5;
		$this->detail_jenis_spp->CurrentValue = 10;
		$this->status_spp->CurrentValue = 0;
		$this->kode_program->CurrentValue = "0.00.000";
		$this->kode_kegiatan->CurrentValue = "0.00.000.0000";
		$this->kode_sub_kegiatan->CurrentValue = "-";
		$this->no_spp->CurrentValue = NULL;
		$this->no_spp->OldValue = $this->no_spp->CurrentValue;
		$this->nama_bendahara->CurrentValue = NULL;
		$this->nama_bendahara->OldValue = $this->nama_bendahara->CurrentValue;
		$this->nip_bendahara->CurrentValue = NULL;
		$this->nip_bendahara->OldValue = $this->nip_bendahara->CurrentValue;
		$this->tgl_spp->CurrentValue = date("d/m/Y");
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
		$this->tahun_anggaran->CurrentValue = 2018;
		$this->id_spd->CurrentValue = NULL;
		$this->id_spd->OldValue = $this->id_spd->CurrentValue;
		$this->tanggal_spd->CurrentValue = NULL;
		$this->tanggal_spd->OldValue = $this->tanggal_spd->CurrentValue;
		$this->nomer_dasar_spd->CurrentValue = NULL;
		$this->nomer_dasar_spd->OldValue = $this->nomer_dasar_spd->CurrentValue;
		$this->jumlah_spd->CurrentValue = NULL;
		$this->jumlah_spd->OldValue = $this->jumlah_spd->CurrentValue;
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
		if (!$this->kode_program->FldIsDetailKey) {
			$this->kode_program->setFormValue($objForm->GetValue("x_kode_program"));
		}
		if (!$this->kode_kegiatan->FldIsDetailKey) {
			$this->kode_kegiatan->setFormValue($objForm->GetValue("x_kode_kegiatan"));
		}
		if (!$this->kode_sub_kegiatan->FldIsDetailKey) {
			$this->kode_sub_kegiatan->setFormValue($objForm->GetValue("x_kode_sub_kegiatan"));
		}
		if (!$this->no_spp->FldIsDetailKey) {
			$this->no_spp->setFormValue($objForm->GetValue("x_no_spp"));
		}
		if (!$this->nama_bendahara->FldIsDetailKey) {
			$this->nama_bendahara->setFormValue($objForm->GetValue("x_nama_bendahara"));
		}
		if (!$this->nip_bendahara->FldIsDetailKey) {
			$this->nip_bendahara->setFormValue($objForm->GetValue("x_nip_bendahara"));
		}
		if (!$this->tgl_spp->FldIsDetailKey) {
			$this->tgl_spp->setFormValue($objForm->GetValue("x_tgl_spp"));
			$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7);
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->tahun_anggaran->FldIsDetailKey) {
			$this->tahun_anggaran->setFormValue($objForm->GetValue("x_tahun_anggaran"));
		}
		if (!$this->id_spd->FldIsDetailKey) {
			$this->id_spd->setFormValue($objForm->GetValue("x_id_spd"));
		}
		if (!$this->tanggal_spd->FldIsDetailKey) {
			$this->tanggal_spd->setFormValue($objForm->GetValue("x_tanggal_spd"));
			$this->tanggal_spd->CurrentValue = ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0);
		}
		if (!$this->nomer_dasar_spd->FldIsDetailKey) {
			$this->nomer_dasar_spd->setFormValue($objForm->GetValue("x_nomer_dasar_spd"));
		}
		if (!$this->jumlah_spd->FldIsDetailKey) {
			$this->jumlah_spd->setFormValue($objForm->GetValue("x_jumlah_spd"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_jenis_spp->CurrentValue = $this->id_jenis_spp->FormValue;
		$this->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->FormValue;
		$this->status_spp->CurrentValue = $this->status_spp->FormValue;
		$this->kode_program->CurrentValue = $this->kode_program->FormValue;
		$this->kode_kegiatan->CurrentValue = $this->kode_kegiatan->FormValue;
		$this->kode_sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->FormValue;
		$this->no_spp->CurrentValue = $this->no_spp->FormValue;
		$this->nama_bendahara->CurrentValue = $this->nama_bendahara->FormValue;
		$this->nip_bendahara->CurrentValue = $this->nip_bendahara->FormValue;
		$this->tgl_spp->CurrentValue = $this->tgl_spp->FormValue;
		$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7);
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->FormValue;
		$this->id_spd->CurrentValue = $this->id_spd->FormValue;
		$this->tanggal_spd->CurrentValue = $this->tanggal_spd->FormValue;
		$this->tanggal_spd->CurrentValue = ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0);
		$this->nomer_dasar_spd->CurrentValue = $this->nomer_dasar_spd->FormValue;
		$this->jumlah_spd->CurrentValue = $this->jumlah_spd->FormValue;
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
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->status_spp->DbValue = $row['status_spp'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->tgl_spp->DbValue = $row['tgl_spp'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->id_spd->DbValue = $row['id_spd'];
		$this->tanggal_spd->DbValue = $row['tanggal_spd'];
		$this->nomer_dasar_spd->DbValue = $row['nomer_dasar_spd'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
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

		if ($this->jumlah_spd->FormValue == $this->jumlah_spd->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_spd->CurrentValue)))
			$this->jumlah_spd->CurrentValue = ew_StrToFloat($this->jumlah_spd->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_jenis_spp
		// detail_jenis_spp
		// status_spp
		// kode_program
		// kode_kegiatan
		// kode_sub_kegiatan
		// no_spp
		// nama_bendahara
		// nip_bendahara
		// tgl_spp
		// kode_rekening
		// keterangan
		// tahun_anggaran
		// id_spd
		// tanggal_spd
		// nomer_dasar_spd
		// jumlah_spd

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
		$lookuptblfilter = "`id`= 5";
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
		$lookuptblfilter = "`id`=10";
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

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// nama_bendahara
		if (strval($this->nama_bendahara->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_bendahara->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_bendahara->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
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

		// tgl_spp
		$this->tgl_spp->ViewValue = $this->tgl_spp->CurrentValue;
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 7);
		$this->tgl_spp->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// id_spd
		$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
		$this->id_spd->ViewCustomAttributes = "";

		// tanggal_spd
		$this->tanggal_spd->ViewValue = $this->tanggal_spd->CurrentValue;
		$this->tanggal_spd->ViewValue = ew_FormatDateTime($this->tanggal_spd->ViewValue, 0);
		$this->tanggal_spd->ViewCustomAttributes = "";

		// nomer_dasar_spd
		$this->nomer_dasar_spd->ViewValue = $this->nomer_dasar_spd->CurrentValue;
		$this->nomer_dasar_spd->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

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

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";
			$this->no_spp->TooltipValue = "";

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";
			$this->nama_bendahara->TooltipValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";
			$this->nip_bendahara->TooltipValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";
			$this->tgl_spp->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

			// id_spd
			$this->id_spd->LinkCustomAttributes = "";
			$this->id_spd->HrefValue = "";
			$this->id_spd->TooltipValue = "";

			// tanggal_spd
			$this->tanggal_spd->LinkCustomAttributes = "";
			$this->tanggal_spd->HrefValue = "";
			$this->tanggal_spd->TooltipValue = "";

			// nomer_dasar_spd
			$this->nomer_dasar_spd->LinkCustomAttributes = "";
			$this->nomer_dasar_spd->HrefValue = "";
			$this->nomer_dasar_spd->TooltipValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";
			$this->jumlah_spd->TooltipValue = "";
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
			$lookuptblfilter = "`id`= 5";
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
			$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `id_jenis` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jenis_detail_spp`";
			$sWhereWrk = "";
			$this->detail_jenis_spp->LookupFilters = array();
			$lookuptblfilter = "`id`=10";
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
			$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kode_kegiatan` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_sub_kegiatan`";
			$sWhereWrk = "";
			$this->kode_sub_kegiatan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kode_sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kode_sub_kegiatan->EditValue = $arwrk;

			// no_spp
			$this->no_spp->EditAttrs["class"] = "form-control";
			$this->no_spp->EditCustomAttributes = "";
			$this->no_spp->EditValue = ew_HtmlEncode($this->no_spp->CurrentValue);
			$this->no_spp->PlaceHolder = ew_RemoveHtml($this->no_spp->FldCaption());

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
			$lookuptblfilter = "`id`=2";
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

			// tahun_anggaran
			$this->tahun_anggaran->EditAttrs["class"] = "form-control";
			$this->tahun_anggaran->EditCustomAttributes = "";
			$this->tahun_anggaran->EditValue = ew_HtmlEncode($this->tahun_anggaran->CurrentValue);
			$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

			// id_spd
			$this->id_spd->EditAttrs["class"] = "form-control";
			$this->id_spd->EditCustomAttributes = "";
			$this->id_spd->EditValue = ew_HtmlEncode($this->id_spd->CurrentValue);
			$this->id_spd->PlaceHolder = ew_RemoveHtml($this->id_spd->FldCaption());

			// tanggal_spd
			$this->tanggal_spd->EditAttrs["class"] = "form-control";
			$this->tanggal_spd->EditCustomAttributes = "";
			$this->tanggal_spd->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_spd->CurrentValue, 8));
			$this->tanggal_spd->PlaceHolder = ew_RemoveHtml($this->tanggal_spd->FldCaption());

			// nomer_dasar_spd
			$this->nomer_dasar_spd->EditAttrs["class"] = "form-control";
			$this->nomer_dasar_spd->EditCustomAttributes = "";
			$this->nomer_dasar_spd->EditValue = ew_HtmlEncode($this->nomer_dasar_spd->CurrentValue);
			$this->nomer_dasar_spd->PlaceHolder = ew_RemoveHtml($this->nomer_dasar_spd->FldCaption());

			// jumlah_spd
			$this->jumlah_spd->EditAttrs["class"] = "form-control";
			$this->jumlah_spd->EditCustomAttributes = "";
			$this->jumlah_spd->EditValue = ew_HtmlEncode($this->jumlah_spd->CurrentValue);
			$this->jumlah_spd->PlaceHolder = ew_RemoveHtml($this->jumlah_spd->FldCaption());
			if (strval($this->jumlah_spd->EditValue) <> "" && is_numeric($this->jumlah_spd->EditValue)) $this->jumlah_spd->EditValue = ew_FormatNumber($this->jumlah_spd->EditValue, -2, -1, -2, 0);

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

			// kode_program
			$this->kode_program->LinkCustomAttributes = "";
			$this->kode_program->HrefValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";

			// id_spd
			$this->id_spd->LinkCustomAttributes = "";
			$this->id_spd->HrefValue = "";

			// tanggal_spd
			$this->tanggal_spd->LinkCustomAttributes = "";
			$this->tanggal_spd->HrefValue = "";

			// nomer_dasar_spd
			$this->nomer_dasar_spd->LinkCustomAttributes = "";
			$this->nomer_dasar_spd->HrefValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";
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
		if (!$this->tgl_spp->FldIsDetailKey && !is_null($this->tgl_spp->FormValue) && $this->tgl_spp->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tgl_spp->FldCaption(), $this->tgl_spp->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->tgl_spp->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spp->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tahun_anggaran->FormValue)) {
			ew_AddMessage($gsFormError, $this->tahun_anggaran->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_spd->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_spd->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_spd->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("vw_spp_pengembalian_penerimaan_detail_belanja", $DetailTblVar) && $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->DetailAdd) {
			if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"])) $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"] = new cvw_spp_pengembalian_penerimaan_detail_belanja_grid(); // get detail page object
			$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->ValidateGridForm();
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

		// id_jenis_spp
		$this->id_jenis_spp->SetDbValueDef($rsnew, $this->id_jenis_spp->CurrentValue, NULL, FALSE);

		// detail_jenis_spp
		$this->detail_jenis_spp->SetDbValueDef($rsnew, $this->detail_jenis_spp->CurrentValue, NULL, FALSE);

		// status_spp
		$this->status_spp->SetDbValueDef($rsnew, $this->status_spp->CurrentValue, NULL, FALSE);

		// kode_program
		$this->kode_program->SetDbValueDef($rsnew, $this->kode_program->CurrentValue, NULL, FALSE);

		// kode_kegiatan
		$this->kode_kegiatan->SetDbValueDef($rsnew, $this->kode_kegiatan->CurrentValue, NULL, FALSE);

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->SetDbValueDef($rsnew, $this->kode_sub_kegiatan->CurrentValue, NULL, FALSE);

		// no_spp
		$this->no_spp->SetDbValueDef($rsnew, $this->no_spp->CurrentValue, NULL, FALSE);

		// nama_bendahara
		$this->nama_bendahara->SetDbValueDef($rsnew, $this->nama_bendahara->CurrentValue, NULL, FALSE);

		// nip_bendahara
		$this->nip_bendahara->SetDbValueDef($rsnew, $this->nip_bendahara->CurrentValue, NULL, FALSE);

		// tgl_spp
		$this->tgl_spp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 7), NULL, FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, FALSE);

		// tahun_anggaran
		$this->tahun_anggaran->SetDbValueDef($rsnew, $this->tahun_anggaran->CurrentValue, NULL, strval($this->tahun_anggaran->CurrentValue) == "");

		// id_spd
		$this->id_spd->SetDbValueDef($rsnew, $this->id_spd->CurrentValue, NULL, FALSE);

		// tanggal_spd
		$this->tanggal_spd->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_spd->CurrentValue, 0), NULL, FALSE);

		// nomer_dasar_spd
		$this->nomer_dasar_spd->SetDbValueDef($rsnew, $this->nomer_dasar_spd->CurrentValue, NULL, FALSE);

		// jumlah_spd
		$this->jumlah_spd->SetDbValueDef($rsnew, $this->jumlah_spd->CurrentValue, NULL, FALSE);

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
			if (in_array("vw_spp_pengembalian_penerimaan_detail_belanja", $DetailTblVar) && $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->DetailAdd) {
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->id_spp->setSessionValue($this->id->CurrentValue); // Set master key
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->id_jenis_spp->setSessionValue($this->id_jenis_spp->CurrentValue); // Set master key
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->CurrentValue); // Set master key
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->no_spp->setSessionValue($this->no_spp->CurrentValue); // Set master key
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->program->setSessionValue($this->kode_program->CurrentValue); // Set master key
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->kegiatan->setSessionValue($this->kode_kegiatan->CurrentValue); // Set master key
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->sub_kegiatan->setSessionValue($this->kode_sub_kegiatan->CurrentValue); // Set master key
				$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->tahun_anggaran->setSessionValue($this->tahun_anggaran->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"])) $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"] = new cvw_spp_pengembalian_penerimaan_detail_belanja_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_spp_pengembalian_penerimaan_detail_belanja"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja"]->tahun_anggaran->setSessionValue(""); // Clear master key if insert failed
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
			if (in_array("vw_spp_pengembalian_penerimaan_detail_belanja", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]))
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"] = new cvw_spp_pengembalian_penerimaan_detail_belanja_grid;
				if ($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->CurrentMode = "add";
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_spp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_spp->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_spp->CurrentValue);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_jenis_spp->CurrentValue = $this->id_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_jenis_spp->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->id_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->detail_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->detail_jenis_spp->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->detail_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->no_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->no_spp->CurrentValue = $this->no_spp->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->no_spp->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->no_spp->CurrentValue);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->program->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->program->CurrentValue = $this->kode_program->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->program->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->program->CurrentValue);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->kegiatan->CurrentValue = $this->kode_kegiatan->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->kegiatan->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->kegiatan->CurrentValue);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->sub_kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->sub_kegiatan->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->sub_kegiatan->CurrentValue);
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->tahun_anggaran->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->tahun_anggaran->CurrentValue = $this->tahun_anggaran->CurrentValue;
					$GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->tahun_anggaran->setSessionValue($GLOBALS["vw_spp_pengembalian_penerimaan_detail_belanja_grid"]->tahun_anggaran->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_pengembalian_penerimaanlist.php"), "", $this->TableVar, TRUE);
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
			$lookuptblfilter = "`id`= 5";
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
			$sWhereWrk = "{filter}";
			$this->detail_jenis_spp->LookupFilters = array();
			$lookuptblfilter = "`id`=10";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`id_jenis` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
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
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode_sub_kegiatan` = {filter_value}', "t0" => "200", "fn0" => "", "f1" => '`kode_kegiatan` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kode_sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_nama_bendahara":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `nama` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
			$sWhereWrk = "";
			$this->nama_bendahara->LookupFilters = array();
			$lookuptblfilter = "`id`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`nama` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
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
if (!isset($vw_spp_pengembalian_penerimaan_add)) $vw_spp_pengembalian_penerimaan_add = new cvw_spp_pengembalian_penerimaan_add();

// Page init
$vw_spp_pengembalian_penerimaan_add->Page_Init();

// Page main
$vw_spp_pengembalian_penerimaan_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_pengembalian_penerimaan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_spp_pengembalian_penerimaanadd = new ew_Form("fvw_spp_pengembalian_penerimaanadd", "add");

// Validate form
fvw_spp_pengembalian_penerimaanadd.Validate = function() {
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
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_pengembalian_penerimaan->tgl_spp->FldCaption(), $vw_spp_pengembalian_penerimaan->tgl_spp->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_spp");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_pengembalian_penerimaan->tgl_spp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tahun_anggaran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_pengembalian_penerimaan->tahun_anggaran->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_spd");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_pengembalian_penerimaan->id_spd->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_spd");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_pengembalian_penerimaan->tanggal_spd->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_spd");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_pengembalian_penerimaan->jumlah_spd->FldErrMsg()) ?>");

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
fvw_spp_pengembalian_penerimaanadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_pengembalian_penerimaanadd.ValidateRequired = true;
<?php } else { ?>
fvw_spp_pengembalian_penerimaanadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_pengembalian_penerimaanadd.Lists["x_id_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_spp","","",""],"ParentFields":[],"ChildFields":["x_detail_jenis_spp"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_spp"};
fvw_spp_pengembalian_penerimaanadd.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":["x_id_jenis_spp"],"ChildFields":[],"FilterFields":["x_id_jenis"],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
fvw_spp_pengembalian_penerimaanadd.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spp_pengembalian_penerimaanadd.Lists["x_status_spp"].Options = <?php echo json_encode($vw_spp_pengembalian_penerimaan->status_spp->Options()) ?>;
fvw_spp_pengembalian_penerimaanadd.Lists["x_kode_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kode_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
fvw_spp_pengembalian_penerimaanadd.Lists["x_kode_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":["x_kode_program"],"ChildFields":["x_kode_sub_kegiatan"],"FilterFields":["x_kode_program"],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
fvw_spp_pengembalian_penerimaanadd.Lists["x_kode_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":["x_kode_kegiatan"],"ChildFields":[],"FilterFields":["x_kode_kegiatan"],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};
fvw_spp_pengembalian_penerimaanadd.Lists["x_nama_bendahara"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_pengembalian_penerimaan_add->IsModal) { ?>
<?php } ?>
<?php $vw_spp_pengembalian_penerimaan_add->ShowPageHeader(); ?>
<?php
$vw_spp_pengembalian_penerimaan_add->ShowMessage();
?>
<form name="fvw_spp_pengembalian_penerimaanadd" id="fvw_spp_pengembalian_penerimaanadd" class="<?php echo $vw_spp_pengembalian_penerimaan_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_pengembalian_penerimaan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_pengembalian_penerimaan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_pengembalian_penerimaan">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_spp_pengembalian_penerimaan_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_vw_spp_pengembalian_penerimaanadd" class="ewCustomTemplate"></div>
<script id="tpm_vw_spp_pengembalian_penerimaanadd" type="text/html">
<div id="ct_vw_spp_pengembalian_penerimaan_add"><div id="ct_sample_add">
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong>Form</strong></div>
  <div class="panel-body">
 <!-- Start   KOLOM 1 -->
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_id_jenis_spp" class="form-group">
	<label id="elh_id_jenis_spp" for="x_id_jenis_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_id_jenis_spp"/}}</div>
	</div>
	<div id="r_detail_jenis_spp" class="form-group">
	<label id="elh_detail_jenis_spp" for="x_detail_jenis_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_detail_jenis_spp"/}}</div>
	</div>
	<div id="r_status_spp" class="form-group">
	<label id="elh_status_spp" for="x_status_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->status_spp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_status_spp"/}}</div>
	</div>
	<div id="r_no_spp" class="form-group">
	<label id="elh_no_spp" for="x_no_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->no_spp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_no_spp"/}}</div>
	</div>
	<div id="r_tgl_spp" class="form-group">
	<label id="elh_tgl_spp" for="x_tgl_spp" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_tgl_spp"/}}</div>
	</div>
	<div id="r_nama_bendahara" class="form-group">
	<label id="elh_nama_bendahara" for="x_nama_bendahara" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_nama_bendahara"/}}</div>
	</div>
	<div id="r_kode_program" class="form-group">
	<label id="elh_kode_program" for="x_kode_program" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->kode_program->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_kode_program"/}}</div>
	</div>
	<div id="r_kode_kegiatan" class="form-group">
	<label id="elh_kode_kegiatan" for="x_kode_kegiatan" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_kode_kegiatan"/}}</div>
	</div>
	<div id="r_kode_sub_kegiatan" class="form-group">
	<label id="elh_kode_sub_kegiatan" for="x_kode_sub_kegiatan" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_kode_sub_kegiatan"/}}</div>
	</div>
  </div>
 <!-- end   KOLOM 1 -->
 <!-- Start   KOLOM 2 -->
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_keterangan" class="form-group">
	<label id="elh_keterangan" for="x_keterangan" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->keterangan->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_keterangan"/}}</div>
	</div>
	<!-- <div id="r_kode_rekening" class="form-group">
	<label id="elh_kode_rekening" for="x_kode_rekening" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->kode_rekening->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_kode_rekening"/}}</div>
	</div> -->
  </div>
   <!-- End   KOLOM 2 -->
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Program</strong></div>
  <div class="panel-body">
 <!-- Start   KOLOM 1 -->
	<div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_nip_bendahara" class="form-group">
	<label id="elh_nip_bendahara" for="x_nip_bendahara" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_spp_pengembalian_penerimaan->nip_bendahara->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_spp_pengembalian_penerimaan_nip_bendahara"/}}</div>
	</div>
  </div>
 <!-- end   KOLOM 1 -->
 <!-- Start   KOLOM 2 -->
  <div class="col-lg-6 col-md-6 col-sm-6">
  </div>
   <!-- End   KOLOM 2 -->
</div>
</div>
</div>
</div>
</script>
<div style="display: none">
<?php if ($vw_spp_pengembalian_penerimaan->id_jenis_spp->Visible) { // id_jenis_spp ?>
	<div id="r_id_jenis_spp" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_id_jenis_spp" for="x_id_jenis_spp" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_id_jenis_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_id_jenis_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_id_jenis_spp">
<?php $vw_spp_pengembalian_penerimaan->id_jenis_spp->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_pengembalian_penerimaan->id_jenis_spp->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_pengembalian_penerimaan" data-field="x_id_jenis_spp" data-value-separator="<?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->DisplayValueSeparatorAttribute() ?>" id="x_id_jenis_spp" name="x_id_jenis_spp"<?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->EditAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->SelectOptionListHtml("x_id_jenis_spp") ?>
</select>
<input type="hidden" name="s_x_id_jenis_spp" id="s_x_id_jenis_spp" value="<?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->id_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<div id="r_detail_jenis_spp" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_detail_jenis_spp" for="x_detail_jenis_spp" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_detail_jenis_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_detail_jenis_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_detail_jenis_spp">
<select data-table="vw_spp_pengembalian_penerimaan" data-field="x_detail_jenis_spp" data-value-separator="<?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->DisplayValueSeparatorAttribute() ?>" id="x_detail_jenis_spp" name="x_detail_jenis_spp"<?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->EditAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->SelectOptionListHtml("x_detail_jenis_spp") ?>
</select>
<input type="hidden" name="s_x_detail_jenis_spp" id="s_x_detail_jenis_spp" value="<?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->detail_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->status_spp->Visible) { // status_spp ?>
	<div id="r_status_spp" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_status_spp" for="x_status_spp" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_status_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->status_spp->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->status_spp->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_status_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_status_spp">
<select data-table="vw_spp_pengembalian_penerimaan" data-field="x_status_spp" data-value-separator="<?php echo $vw_spp_pengembalian_penerimaan->status_spp->DisplayValueSeparatorAttribute() ?>" id="x_status_spp" name="x_status_spp"<?php echo $vw_spp_pengembalian_penerimaan->status_spp->EditAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->status_spp->SelectOptionListHtml("x_status_spp") ?>
</select>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->status_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->kode_program->Visible) { // kode_program ?>
	<div id="r_kode_program" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_kode_program" for="x_kode_program" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_kode_program" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->kode_program->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->kode_program->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_kode_program" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_kode_program">
<?php $vw_spp_pengembalian_penerimaan->kode_program->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_pengembalian_penerimaan->kode_program->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_pengembalian_penerimaan" data-field="x_kode_program" data-value-separator="<?php echo $vw_spp_pengembalian_penerimaan->kode_program->DisplayValueSeparatorAttribute() ?>" id="x_kode_program" name="x_kode_program"<?php echo $vw_spp_pengembalian_penerimaan->kode_program->EditAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->kode_program->SelectOptionListHtml("x_kode_program") ?>
</select>
<input type="hidden" name="s_x_kode_program" id="s_x_kode_program" value="<?php echo $vw_spp_pengembalian_penerimaan->kode_program->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->kode_program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<div id="r_kode_kegiatan" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_kode_kegiatan" for="x_kode_kegiatan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_kode_kegiatan" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_kode_kegiatan" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_kode_kegiatan">
<?php $vw_spp_pengembalian_penerimaan->kode_kegiatan->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_spp_pengembalian_penerimaan->kode_kegiatan->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_pengembalian_penerimaan" data-field="x_kode_kegiatan" data-value-separator="<?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kode_kegiatan" name="x_kode_kegiatan"<?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->EditAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->SelectOptionListHtml("x_kode_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kode_kegiatan" id="s_x_kode_kegiatan" value="<?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->kode_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
	<div id="r_kode_sub_kegiatan" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_kode_sub_kegiatan" for="x_kode_sub_kegiatan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_kode_sub_kegiatan" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_kode_sub_kegiatan" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_kode_sub_kegiatan">
<select data-table="vw_spp_pengembalian_penerimaan" data-field="x_kode_sub_kegiatan" data-value-separator="<?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->DisplayValueSeparatorAttribute() ?>" id="x_kode_sub_kegiatan" name="x_kode_sub_kegiatan"<?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->EditAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->SelectOptionListHtml("x_kode_sub_kegiatan") ?>
</select>
<input type="hidden" name="s_x_kode_sub_kegiatan" id="s_x_kode_sub_kegiatan" value="<?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->kode_sub_kegiatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->no_spp->Visible) { // no_spp ?>
	<div id="r_no_spp" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_no_spp" for="x_no_spp" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_no_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->no_spp->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->no_spp->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_no_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_no_spp">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_no_spp" name="x_no_spp" id="x_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->no_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->no_spp->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->no_spp->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->no_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->nama_bendahara->Visible) { // nama_bendahara ?>
	<div id="r_nama_bendahara" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_nama_bendahara" for="x_nama_bendahara" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_nama_bendahara" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_nama_bendahara" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_nama_bendahara">
<?php $vw_spp_pengembalian_penerimaan->nama_bendahara->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_spp_pengembalian_penerimaan->nama_bendahara->EditAttrs["onchange"]; ?>
<select data-table="vw_spp_pengembalian_penerimaan" data-field="x_nama_bendahara" data-value-separator="<?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->DisplayValueSeparatorAttribute() ?>" id="x_nama_bendahara" name="x_nama_bendahara"<?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->EditAttributes() ?>>
<?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->SelectOptionListHtml("x_nama_bendahara") ?>
</select>
<input type="hidden" name="s_x_nama_bendahara" id="s_x_nama_bendahara" value="<?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_nama_bendahara" id="ln_x_nama_bendahara" value="x_nip_bendahara">
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->nama_bendahara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->nip_bendahara->Visible) { // nip_bendahara ?>
	<div id="r_nip_bendahara" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_nip_bendahara" for="x_nip_bendahara" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_nip_bendahara" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->nip_bendahara->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->nip_bendahara->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_nip_bendahara" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_nip_bendahara">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_nip_bendahara" name="x_nip_bendahara" id="x_nip_bendahara" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->nip_bendahara->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->nip_bendahara->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->nip_bendahara->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->nip_bendahara->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->tgl_spp->Visible) { // tgl_spp ?>
	<div id="r_tgl_spp" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_tgl_spp" for="x_tgl_spp" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_tgl_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_tgl_spp" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_tgl_spp">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_tgl_spp" data-format="7" name="x_tgl_spp" id="x_tgl_spp" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->EditAttributes() ?>>
<?php if (!$vw_spp_pengembalian_penerimaan->tgl_spp->ReadOnly && !$vw_spp_pengembalian_penerimaan->tgl_spp->Disabled && !isset($vw_spp_pengembalian_penerimaan->tgl_spp->EditAttrs["readonly"]) && !isset($vw_spp_pengembalian_penerimaan->tgl_spp->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="vw_spp_pengembalian_penerimaanadd_js">
ew_CreateCalendar("fvw_spp_pengembalian_penerimaanadd", "x_tgl_spp", 7);
</script>
<?php echo $vw_spp_pengembalian_penerimaan->tgl_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_keterangan" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->keterangan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->keterangan->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_keterangan" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_keterangan">
<textarea data-table="vw_spp_pengembalian_penerimaan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->keterangan->getPlaceHolder()) ?>"<?php echo $vw_spp_pengembalian_penerimaan->keterangan->EditAttributes() ?>><?php echo $vw_spp_pengembalian_penerimaan->keterangan->EditValue ?></textarea>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<div id="r_tahun_anggaran" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_tahun_anggaran" for="x_tahun_anggaran" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_tahun_anggaran" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->tahun_anggaran->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->tahun_anggaran->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_tahun_anggaran" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_tahun_anggaran">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_tahun_anggaran" name="x_tahun_anggaran" id="x_tahun_anggaran" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->tahun_anggaran->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->tahun_anggaran->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->tahun_anggaran->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->tahun_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->id_spd->Visible) { // id_spd ?>
	<div id="r_id_spd" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_id_spd" for="x_id_spd" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_id_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->id_spd->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->id_spd->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_id_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_id_spd">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_id_spd" name="x_id_spd" id="x_id_spd" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->id_spd->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->id_spd->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->id_spd->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->id_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->tanggal_spd->Visible) { // tanggal_spd ?>
	<div id="r_tanggal_spd" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_tanggal_spd" for="x_tanggal_spd" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_tanggal_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->tanggal_spd->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->tanggal_spd->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_tanggal_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_tanggal_spd">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_tanggal_spd" name="x_tanggal_spd" id="x_tanggal_spd" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->tanggal_spd->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->tanggal_spd->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->tanggal_spd->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->tanggal_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->nomer_dasar_spd->Visible) { // nomer_dasar_spd ?>
	<div id="r_nomer_dasar_spd" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_nomer_dasar_spd" for="x_nomer_dasar_spd" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_nomer_dasar_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->nomer_dasar_spd->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->nomer_dasar_spd->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_nomer_dasar_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_nomer_dasar_spd">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_nomer_dasar_spd" name="x_nomer_dasar_spd" id="x_nomer_dasar_spd" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->nomer_dasar_spd->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->nomer_dasar_spd->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->nomer_dasar_spd->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->nomer_dasar_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_pengembalian_penerimaan->jumlah_spd->Visible) { // jumlah_spd ?>
	<div id="r_jumlah_spd" class="form-group">
		<label id="elh_vw_spp_pengembalian_penerimaan_jumlah_spd" for="x_jumlah_spd" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_spp_pengembalian_penerimaan_jumlah_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html"><span><?php echo $vw_spp_pengembalian_penerimaan->jumlah_spd->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_pengembalian_penerimaan->jumlah_spd->CellAttributes() ?>>
<script id="tpx_vw_spp_pengembalian_penerimaan_jumlah_spd" class="vw_spp_pengembalian_penerimaanadd" type="text/html">
<span id="el_vw_spp_pengembalian_penerimaan_jumlah_spd">
<input type="text" data-table="vw_spp_pengembalian_penerimaan" data-field="x_jumlah_spd" name="x_jumlah_spd" id="x_jumlah_spd" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_pengembalian_penerimaan->jumlah_spd->getPlaceHolder()) ?>" value="<?php echo $vw_spp_pengembalian_penerimaan->jumlah_spd->EditValue ?>"<?php echo $vw_spp_pengembalian_penerimaan->jumlah_spd->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_spp_pengembalian_penerimaan->jumlah_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("vw_spp_pengembalian_penerimaan_detail_belanja", explode(",", $vw_spp_pengembalian_penerimaan->getCurrentDetailTable())) && $vw_spp_pengembalian_penerimaan_detail_belanja->DetailAdd) {
?>
<?php if ($vw_spp_pengembalian_penerimaan->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("vw_spp_pengembalian_penerimaan_detail_belanja", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "vw_spp_pengembalian_penerimaan_detail_belanjagrid.php" ?>
<?php } ?>
<?php if (!$vw_spp_pengembalian_penerimaan_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spp_pengembalian_penerimaan_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_vw_spp_pengembalian_penerimaanadd", "tpm_vw_spp_pengembalian_penerimaanadd", "vw_spp_pengembalian_penerimaanadd", "<?php echo $vw_spp_pengembalian_penerimaan->CustomExport ?>");
jQuery("script.vw_spp_pengembalian_penerimaanadd_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
fvw_spp_pengembalian_penerimaanadd.Init();
</script>
<?php
$vw_spp_pengembalian_penerimaan_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_pengembalian_penerimaan_add->Page_Terminate();
?>
