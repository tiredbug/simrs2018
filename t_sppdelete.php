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

$t_spp_delete = NULL; // Initialize page object first

class ct_spp_delete extends ct_spp {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_spp';

	// Page object name
	var $PageObjName = 't_spp_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("t_spplist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_spp class, t_sppinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t_spplist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_spplist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_spp_delete)) $t_spp_delete = new ct_spp_delete();

// Page init
$t_spp_delete->Page_Init();

// Page main
$t_spp_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_spp_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_sppdelete = new ew_Form("ft_sppdelete", "delete");

// Form_CustomValidate event
ft_sppdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sppdelete.ValidateRequired = true;
<?php } else { ?>
ft_sppdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sppdelete.Lists["x_id_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_spp","","",""],"ParentFields":[],"ChildFields":["x_detail_jenis_spp"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_spp"};
ft_sppdelete.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
ft_sppdelete.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sppdelete.Lists["x_status_spp"].Options = <?php echo json_encode($t_spp->status_spp->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t_spp_delete->ShowPageHeader(); ?>
<?php
$t_spp_delete->ShowMessage();
?>
<form name="ft_sppdelete" id="ft_sppdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_spp_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_spp_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_spp">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_spp_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_spp->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_spp->id->Visible) { // id ?>
		<th><span id="elh_t_spp_id" class="t_spp_id"><?php echo $t_spp->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->id_jenis_spp->Visible) { // id_jenis_spp ?>
		<th><span id="elh_t_spp_id_jenis_spp" class="t_spp_id_jenis_spp"><?php echo $t_spp->id_jenis_spp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
		<th><span id="elh_t_spp_detail_jenis_spp" class="t_spp_detail_jenis_spp"><?php echo $t_spp->detail_jenis_spp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->status_spp->Visible) { // status_spp ?>
		<th><span id="elh_t_spp_status_spp" class="t_spp_status_spp"><?php echo $t_spp->status_spp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->no_spp->Visible) { // no_spp ?>
		<th><span id="elh_t_spp_no_spp" class="t_spp_no_spp"><?php echo $t_spp->no_spp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->tgl_spp->Visible) { // tgl_spp ?>
		<th><span id="elh_t_spp_tgl_spp" class="t_spp_tgl_spp"><?php echo $t_spp->tgl_spp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->keterangan->Visible) { // keterangan ?>
		<th><span id="elh_t_spp_keterangan" class="t_spp_keterangan"><?php echo $t_spp->keterangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->jumlah_up->Visible) { // jumlah_up ?>
		<th><span id="elh_t_spp_jumlah_up" class="t_spp_jumlah_up"><?php echo $t_spp->jumlah_up->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->bendahara->Visible) { // bendahara ?>
		<th><span id="elh_t_spp_bendahara" class="t_spp_bendahara"><?php echo $t_spp->bendahara->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nama_pptk->Visible) { // nama_pptk ?>
		<th><span id="elh_t_spp_nama_pptk" class="t_spp_nama_pptk"><?php echo $t_spp->nama_pptk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nip_pptk->Visible) { // nip_pptk ?>
		<th><span id="elh_t_spp_nip_pptk" class="t_spp_nip_pptk"><?php echo $t_spp->nip_pptk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->status_spm->Visible) { // status_spm ?>
		<th><span id="elh_t_spp_status_spm" class="t_spp_status_spm"><?php echo $t_spp->status_spm->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->kode_kegiatan->Visible) { // kode_kegiatan ?>
		<th><span id="elh_t_spp_kode_kegiatan" class="t_spp_kode_kegiatan"><?php echo $t_spp->kode_kegiatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
		<th><span id="elh_t_spp_kode_sub_kegiatan" class="t_spp_kode_sub_kegiatan"><?php echo $t_spp->kode_sub_kegiatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->tahun_anggaran->Visible) { // tahun_anggaran ?>
		<th><span id="elh_t_spp_tahun_anggaran" class="t_spp_tahun_anggaran"><?php echo $t_spp->tahun_anggaran->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->jumlah_spd->Visible) { // jumlah_spd ?>
		<th><span id="elh_t_spp_jumlah_spd" class="t_spp_jumlah_spd"><?php echo $t_spp->jumlah_spd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nomer_dasar_spd->Visible) { // nomer_dasar_spd ?>
		<th><span id="elh_t_spp_nomer_dasar_spd" class="t_spp_nomer_dasar_spd"><?php echo $t_spp->nomer_dasar_spd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->tanggal_spd->Visible) { // tanggal_spd ?>
		<th><span id="elh_t_spp_tanggal_spd" class="t_spp_tanggal_spd"><?php echo $t_spp->tanggal_spd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->id_spd->Visible) { // id_spd ?>
		<th><span id="elh_t_spp_id_spd" class="t_spp_id_spd"><?php echo $t_spp->id_spd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->kode_program->Visible) { // kode_program ?>
		<th><span id="elh_t_spp_kode_program" class="t_spp_kode_program"><?php echo $t_spp->kode_program->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->kode_rekening->Visible) { // kode_rekening ?>
		<th><span id="elh_t_spp_kode_rekening" class="t_spp_kode_rekening"><?php echo $t_spp->kode_rekening->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nama_bendahara->Visible) { // nama_bendahara ?>
		<th><span id="elh_t_spp_nama_bendahara" class="t_spp_nama_bendahara"><?php echo $t_spp->nama_bendahara->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nip_bendahara->Visible) { // nip_bendahara ?>
		<th><span id="elh_t_spp_nip_bendahara" class="t_spp_nip_bendahara"><?php echo $t_spp->nip_bendahara->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->no_spm->Visible) { // no_spm ?>
		<th><span id="elh_t_spp_no_spm" class="t_spp_no_spm"><?php echo $t_spp->no_spm->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->tgl_spm->Visible) { // tgl_spm ?>
		<th><span id="elh_t_spp_tgl_spm" class="t_spp_tgl_spm"><?php echo $t_spp->tgl_spm->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nama_bank->Visible) { // nama_bank ?>
		<th><span id="elh_t_spp_nama_bank" class="t_spp_nama_bank"><?php echo $t_spp->nama_bank->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nomer_rekening_bank->Visible) { // nomer_rekening_bank ?>
		<th><span id="elh_t_spp_nomer_rekening_bank" class="t_spp_nomer_rekening_bank"><?php echo $t_spp->nomer_rekening_bank->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->npwp->Visible) { // npwp ?>
		<th><span id="elh_t_spp_npwp" class="t_spp_npwp"><?php echo $t_spp->npwp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->pph21->Visible) { // pph21 ?>
		<th><span id="elh_t_spp_pph21" class="t_spp_pph21"><?php echo $t_spp->pph21->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->pph22->Visible) { // pph22 ?>
		<th><span id="elh_t_spp_pph22" class="t_spp_pph22"><?php echo $t_spp->pph22->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->pph23->Visible) { // pph23 ?>
		<th><span id="elh_t_spp_pph23" class="t_spp_pph23"><?php echo $t_spp->pph23->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->pph4->Visible) { // pph4 ?>
		<th><span id="elh_t_spp_pph4" class="t_spp_pph4"><?php echo $t_spp->pph4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<th><span id="elh_t_spp_jumlah_belanja" class="t_spp_jumlah_belanja"><?php echo $t_spp->jumlah_belanja->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->kontrak_id->Visible) { // kontrak_id ?>
		<th><span id="elh_t_spp_kontrak_id" class="t_spp_kontrak_id"><?php echo $t_spp->kontrak_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->akun1->Visible) { // akun1 ?>
		<th><span id="elh_t_spp_akun1" class="t_spp_akun1"><?php echo $t_spp->akun1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->akun2->Visible) { // akun2 ?>
		<th><span id="elh_t_spp_akun2" class="t_spp_akun2"><?php echo $t_spp->akun2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->akun3->Visible) { // akun3 ?>
		<th><span id="elh_t_spp_akun3" class="t_spp_akun3"><?php echo $t_spp->akun3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->akun4->Visible) { // akun4 ?>
		<th><span id="elh_t_spp_akun4" class="t_spp_akun4"><?php echo $t_spp->akun4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->akun5->Visible) { // akun5 ?>
		<th><span id="elh_t_spp_akun5" class="t_spp_akun5"><?php echo $t_spp->akun5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->pimpinan_blud->Visible) { // pimpinan_blud ?>
		<th><span id="elh_t_spp_pimpinan_blud" class="t_spp_pimpinan_blud"><?php echo $t_spp->pimpinan_blud->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->nip_pimpinan->Visible) { // nip_pimpinan ?>
		<th><span id="elh_t_spp_nip_pimpinan" class="t_spp_nip_pimpinan"><?php echo $t_spp->nip_pimpinan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->opd->Visible) { // opd ?>
		<th><span id="elh_t_spp_opd" class="t_spp_opd"><?php echo $t_spp->opd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->urusan_pemerintahan->Visible) { // urusan_pemerintahan ?>
		<th><span id="elh_t_spp_urusan_pemerintahan" class="t_spp_urusan_pemerintahan"><?php echo $t_spp->urusan_pemerintahan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->tgl_sptb->Visible) { // tgl_sptb ?>
		<th><span id="elh_t_spp_tgl_sptb" class="t_spp_tgl_sptb"><?php echo $t_spp->tgl_sptb->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->no_sptb->Visible) { // no_sptb ?>
		<th><span id="elh_t_spp_no_sptb" class="t_spp_no_sptb"><?php echo $t_spp->no_sptb->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->status_advis->Visible) { // status_advis ?>
		<th><span id="elh_t_spp_status_advis" class="t_spp_status_advis"><?php echo $t_spp->status_advis->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spp->id_spj->Visible) { // id_spj ?>
		<th><span id="elh_t_spp_id_spj" class="t_spp_id_spj"><?php echo $t_spp->id_spj->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_spp_delete->RecCnt = 0;
$i = 0;
while (!$t_spp_delete->Recordset->EOF) {
	$t_spp_delete->RecCnt++;
	$t_spp_delete->RowCnt++;

	// Set row properties
	$t_spp->ResetAttrs();
	$t_spp->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_spp_delete->LoadRowValues($t_spp_delete->Recordset);

	// Render row
	$t_spp_delete->RenderRow();
?>
	<tr<?php echo $t_spp->RowAttributes() ?>>
<?php if ($t_spp->id->Visible) { // id ?>
		<td<?php echo $t_spp->id->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_id" class="t_spp_id">
<span<?php echo $t_spp->id->ViewAttributes() ?>>
<?php echo $t_spp->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->id_jenis_spp->Visible) { // id_jenis_spp ?>
		<td<?php echo $t_spp->id_jenis_spp->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_id_jenis_spp" class="t_spp_id_jenis_spp">
<span<?php echo $t_spp->id_jenis_spp->ViewAttributes() ?>>
<?php echo $t_spp->id_jenis_spp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
		<td<?php echo $t_spp->detail_jenis_spp->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_detail_jenis_spp" class="t_spp_detail_jenis_spp">
<span<?php echo $t_spp->detail_jenis_spp->ViewAttributes() ?>>
<?php echo $t_spp->detail_jenis_spp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->status_spp->Visible) { // status_spp ?>
		<td<?php echo $t_spp->status_spp->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_status_spp" class="t_spp_status_spp">
<span<?php echo $t_spp->status_spp->ViewAttributes() ?>>
<?php echo $t_spp->status_spp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->no_spp->Visible) { // no_spp ?>
		<td<?php echo $t_spp->no_spp->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_no_spp" class="t_spp_no_spp">
<span<?php echo $t_spp->no_spp->ViewAttributes() ?>>
<?php echo $t_spp->no_spp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->tgl_spp->Visible) { // tgl_spp ?>
		<td<?php echo $t_spp->tgl_spp->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_tgl_spp" class="t_spp_tgl_spp">
<span<?php echo $t_spp->tgl_spp->ViewAttributes() ?>>
<?php echo $t_spp->tgl_spp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->keterangan->Visible) { // keterangan ?>
		<td<?php echo $t_spp->keterangan->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_keterangan" class="t_spp_keterangan">
<span<?php echo $t_spp->keterangan->ViewAttributes() ?>>
<?php echo $t_spp->keterangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->jumlah_up->Visible) { // jumlah_up ?>
		<td<?php echo $t_spp->jumlah_up->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_jumlah_up" class="t_spp_jumlah_up">
<span<?php echo $t_spp->jumlah_up->ViewAttributes() ?>>
<?php echo $t_spp->jumlah_up->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->bendahara->Visible) { // bendahara ?>
		<td<?php echo $t_spp->bendahara->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_bendahara" class="t_spp_bendahara">
<span<?php echo $t_spp->bendahara->ViewAttributes() ?>>
<?php echo $t_spp->bendahara->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nama_pptk->Visible) { // nama_pptk ?>
		<td<?php echo $t_spp->nama_pptk->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nama_pptk" class="t_spp_nama_pptk">
<span<?php echo $t_spp->nama_pptk->ViewAttributes() ?>>
<?php echo $t_spp->nama_pptk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nip_pptk->Visible) { // nip_pptk ?>
		<td<?php echo $t_spp->nip_pptk->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nip_pptk" class="t_spp_nip_pptk">
<span<?php echo $t_spp->nip_pptk->ViewAttributes() ?>>
<?php echo $t_spp->nip_pptk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->status_spm->Visible) { // status_spm ?>
		<td<?php echo $t_spp->status_spm->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_status_spm" class="t_spp_status_spm">
<span<?php echo $t_spp->status_spm->ViewAttributes() ?>>
<?php echo $t_spp->status_spm->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->kode_kegiatan->Visible) { // kode_kegiatan ?>
		<td<?php echo $t_spp->kode_kegiatan->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_kode_kegiatan" class="t_spp_kode_kegiatan">
<span<?php echo $t_spp->kode_kegiatan->ViewAttributes() ?>>
<?php echo $t_spp->kode_kegiatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
		<td<?php echo $t_spp->kode_sub_kegiatan->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_kode_sub_kegiatan" class="t_spp_kode_sub_kegiatan">
<span<?php echo $t_spp->kode_sub_kegiatan->ViewAttributes() ?>>
<?php echo $t_spp->kode_sub_kegiatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->tahun_anggaran->Visible) { // tahun_anggaran ?>
		<td<?php echo $t_spp->tahun_anggaran->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_tahun_anggaran" class="t_spp_tahun_anggaran">
<span<?php echo $t_spp->tahun_anggaran->ViewAttributes() ?>>
<?php echo $t_spp->tahun_anggaran->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->jumlah_spd->Visible) { // jumlah_spd ?>
		<td<?php echo $t_spp->jumlah_spd->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_jumlah_spd" class="t_spp_jumlah_spd">
<span<?php echo $t_spp->jumlah_spd->ViewAttributes() ?>>
<?php echo $t_spp->jumlah_spd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nomer_dasar_spd->Visible) { // nomer_dasar_spd ?>
		<td<?php echo $t_spp->nomer_dasar_spd->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nomer_dasar_spd" class="t_spp_nomer_dasar_spd">
<span<?php echo $t_spp->nomer_dasar_spd->ViewAttributes() ?>>
<?php echo $t_spp->nomer_dasar_spd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->tanggal_spd->Visible) { // tanggal_spd ?>
		<td<?php echo $t_spp->tanggal_spd->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_tanggal_spd" class="t_spp_tanggal_spd">
<span<?php echo $t_spp->tanggal_spd->ViewAttributes() ?>>
<?php echo $t_spp->tanggal_spd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->id_spd->Visible) { // id_spd ?>
		<td<?php echo $t_spp->id_spd->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_id_spd" class="t_spp_id_spd">
<span<?php echo $t_spp->id_spd->ViewAttributes() ?>>
<?php echo $t_spp->id_spd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->kode_program->Visible) { // kode_program ?>
		<td<?php echo $t_spp->kode_program->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_kode_program" class="t_spp_kode_program">
<span<?php echo $t_spp->kode_program->ViewAttributes() ?>>
<?php echo $t_spp->kode_program->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->kode_rekening->Visible) { // kode_rekening ?>
		<td<?php echo $t_spp->kode_rekening->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_kode_rekening" class="t_spp_kode_rekening">
<span<?php echo $t_spp->kode_rekening->ViewAttributes() ?>>
<?php echo $t_spp->kode_rekening->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nama_bendahara->Visible) { // nama_bendahara ?>
		<td<?php echo $t_spp->nama_bendahara->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nama_bendahara" class="t_spp_nama_bendahara">
<span<?php echo $t_spp->nama_bendahara->ViewAttributes() ?>>
<?php echo $t_spp->nama_bendahara->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nip_bendahara->Visible) { // nip_bendahara ?>
		<td<?php echo $t_spp->nip_bendahara->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nip_bendahara" class="t_spp_nip_bendahara">
<span<?php echo $t_spp->nip_bendahara->ViewAttributes() ?>>
<?php echo $t_spp->nip_bendahara->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->no_spm->Visible) { // no_spm ?>
		<td<?php echo $t_spp->no_spm->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_no_spm" class="t_spp_no_spm">
<span<?php echo $t_spp->no_spm->ViewAttributes() ?>>
<?php echo $t_spp->no_spm->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->tgl_spm->Visible) { // tgl_spm ?>
		<td<?php echo $t_spp->tgl_spm->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_tgl_spm" class="t_spp_tgl_spm">
<span<?php echo $t_spp->tgl_spm->ViewAttributes() ?>>
<?php echo $t_spp->tgl_spm->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nama_bank->Visible) { // nama_bank ?>
		<td<?php echo $t_spp->nama_bank->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nama_bank" class="t_spp_nama_bank">
<span<?php echo $t_spp->nama_bank->ViewAttributes() ?>>
<?php echo $t_spp->nama_bank->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nomer_rekening_bank->Visible) { // nomer_rekening_bank ?>
		<td<?php echo $t_spp->nomer_rekening_bank->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nomer_rekening_bank" class="t_spp_nomer_rekening_bank">
<span<?php echo $t_spp->nomer_rekening_bank->ViewAttributes() ?>>
<?php echo $t_spp->nomer_rekening_bank->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->npwp->Visible) { // npwp ?>
		<td<?php echo $t_spp->npwp->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_npwp" class="t_spp_npwp">
<span<?php echo $t_spp->npwp->ViewAttributes() ?>>
<?php echo $t_spp->npwp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->pph21->Visible) { // pph21 ?>
		<td<?php echo $t_spp->pph21->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_pph21" class="t_spp_pph21">
<span<?php echo $t_spp->pph21->ViewAttributes() ?>>
<?php echo $t_spp->pph21->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->pph22->Visible) { // pph22 ?>
		<td<?php echo $t_spp->pph22->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_pph22" class="t_spp_pph22">
<span<?php echo $t_spp->pph22->ViewAttributes() ?>>
<?php echo $t_spp->pph22->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->pph23->Visible) { // pph23 ?>
		<td<?php echo $t_spp->pph23->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_pph23" class="t_spp_pph23">
<span<?php echo $t_spp->pph23->ViewAttributes() ?>>
<?php echo $t_spp->pph23->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->pph4->Visible) { // pph4 ?>
		<td<?php echo $t_spp->pph4->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_pph4" class="t_spp_pph4">
<span<?php echo $t_spp->pph4->ViewAttributes() ?>>
<?php echo $t_spp->pph4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td<?php echo $t_spp->jumlah_belanja->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_jumlah_belanja" class="t_spp_jumlah_belanja">
<span<?php echo $t_spp->jumlah_belanja->ViewAttributes() ?>>
<?php echo $t_spp->jumlah_belanja->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->kontrak_id->Visible) { // kontrak_id ?>
		<td<?php echo $t_spp->kontrak_id->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_kontrak_id" class="t_spp_kontrak_id">
<span<?php echo $t_spp->kontrak_id->ViewAttributes() ?>>
<?php echo $t_spp->kontrak_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->akun1->Visible) { // akun1 ?>
		<td<?php echo $t_spp->akun1->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_akun1" class="t_spp_akun1">
<span<?php echo $t_spp->akun1->ViewAttributes() ?>>
<?php echo $t_spp->akun1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->akun2->Visible) { // akun2 ?>
		<td<?php echo $t_spp->akun2->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_akun2" class="t_spp_akun2">
<span<?php echo $t_spp->akun2->ViewAttributes() ?>>
<?php echo $t_spp->akun2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->akun3->Visible) { // akun3 ?>
		<td<?php echo $t_spp->akun3->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_akun3" class="t_spp_akun3">
<span<?php echo $t_spp->akun3->ViewAttributes() ?>>
<?php echo $t_spp->akun3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->akun4->Visible) { // akun4 ?>
		<td<?php echo $t_spp->akun4->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_akun4" class="t_spp_akun4">
<span<?php echo $t_spp->akun4->ViewAttributes() ?>>
<?php echo $t_spp->akun4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->akun5->Visible) { // akun5 ?>
		<td<?php echo $t_spp->akun5->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_akun5" class="t_spp_akun5">
<span<?php echo $t_spp->akun5->ViewAttributes() ?>>
<?php echo $t_spp->akun5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->pimpinan_blud->Visible) { // pimpinan_blud ?>
		<td<?php echo $t_spp->pimpinan_blud->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_pimpinan_blud" class="t_spp_pimpinan_blud">
<span<?php echo $t_spp->pimpinan_blud->ViewAttributes() ?>>
<?php echo $t_spp->pimpinan_blud->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->nip_pimpinan->Visible) { // nip_pimpinan ?>
		<td<?php echo $t_spp->nip_pimpinan->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_nip_pimpinan" class="t_spp_nip_pimpinan">
<span<?php echo $t_spp->nip_pimpinan->ViewAttributes() ?>>
<?php echo $t_spp->nip_pimpinan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->opd->Visible) { // opd ?>
		<td<?php echo $t_spp->opd->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_opd" class="t_spp_opd">
<span<?php echo $t_spp->opd->ViewAttributes() ?>>
<?php echo $t_spp->opd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->urusan_pemerintahan->Visible) { // urusan_pemerintahan ?>
		<td<?php echo $t_spp->urusan_pemerintahan->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_urusan_pemerintahan" class="t_spp_urusan_pemerintahan">
<span<?php echo $t_spp->urusan_pemerintahan->ViewAttributes() ?>>
<?php echo $t_spp->urusan_pemerintahan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->tgl_sptb->Visible) { // tgl_sptb ?>
		<td<?php echo $t_spp->tgl_sptb->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_tgl_sptb" class="t_spp_tgl_sptb">
<span<?php echo $t_spp->tgl_sptb->ViewAttributes() ?>>
<?php echo $t_spp->tgl_sptb->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->no_sptb->Visible) { // no_sptb ?>
		<td<?php echo $t_spp->no_sptb->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_no_sptb" class="t_spp_no_sptb">
<span<?php echo $t_spp->no_sptb->ViewAttributes() ?>>
<?php echo $t_spp->no_sptb->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->status_advis->Visible) { // status_advis ?>
		<td<?php echo $t_spp->status_advis->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_status_advis" class="t_spp_status_advis">
<span<?php echo $t_spp->status_advis->ViewAttributes() ?>>
<?php echo $t_spp->status_advis->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spp->id_spj->Visible) { // id_spj ?>
		<td<?php echo $t_spp->id_spj->CellAttributes() ?>>
<span id="el<?php echo $t_spp_delete->RowCnt ?>_t_spp_id_spj" class="t_spp_id_spj">
<span<?php echo $t_spp->id_spj->ViewAttributes() ?>>
<?php echo $t_spp->id_spj->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_spp_delete->Recordset->MoveNext();
}
$t_spp_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_spp_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_sppdelete.Init();
</script>
<?php
$t_spp_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_spp_delete->Page_Terminate();
?>
