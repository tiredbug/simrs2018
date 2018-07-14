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

$vw_spj_gu_delete = NULL; // Initialize page object first

class cvw_spj_gu_delete extends cvw_spj_gu {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spj_gu';

	// Page object name
	var $PageObjName = 'vw_spj_gu_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
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
			$this->Page_Terminate("vw_spj_gulist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in vw_spj_gu class, vw_spj_guinfo.php

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
				$this->Page_Terminate("vw_spj_gulist.php"); // Return to list
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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spj_gulist.php"), "", $this->TableVar, TRUE);
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
if (!isset($vw_spj_gu_delete)) $vw_spj_gu_delete = new cvw_spj_gu_delete();

// Page init
$vw_spj_gu_delete->Page_Init();

// Page main
$vw_spj_gu_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spj_gu_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fvw_spj_gudelete = new ew_Form("fvw_spj_gudelete", "delete");

// Form_CustomValidate event
fvw_spj_gudelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spj_gudelete.ValidateRequired = true;
<?php } else { ?>
fvw_spj_gudelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $vw_spj_gu_delete->ShowPageHeader(); ?>
<?php
$vw_spj_gu_delete->ShowMessage();
?>
<form name="fvw_spj_gudelete" id="fvw_spj_gudelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spj_gu_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spj_gu_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spj_gu">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($vw_spj_gu_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_spj_gu->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($vw_spj_gu->id->Visible) { // id ?>
		<th><span id="elh_vw_spj_gu_id" class="vw_spj_gu_id"><?php echo $vw_spj_gu->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->no_spj->Visible) { // no_spj ?>
		<th><span id="elh_vw_spj_gu_no_spj" class="vw_spj_gu_no_spj"><?php echo $vw_spj_gu->no_spj->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->tgl_spj->Visible) { // tgl_spj ?>
		<th><span id="elh_vw_spj_gu_tgl_spj" class="vw_spj_gu_tgl_spj"><?php echo $vw_spj_gu->tgl_spj->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->program->Visible) { // program ?>
		<th><span id="elh_vw_spj_gu_program" class="vw_spj_gu_program"><?php echo $vw_spj_gu->program->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->kegiatan->Visible) { // kegiatan ?>
		<th><span id="elh_vw_spj_gu_kegiatan" class="vw_spj_gu_kegiatan"><?php echo $vw_spj_gu->kegiatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->tipe->Visible) { // tipe ?>
		<th><span id="elh_vw_spj_gu_tipe" class="vw_spj_gu_tipe"><?php echo $vw_spj_gu->tipe->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->tipe_sbp->Visible) { // tipe_sbp ?>
		<th><span id="elh_vw_spj_gu_tipe_sbp" class="vw_spj_gu_tipe_sbp"><?php echo $vw_spj_gu->tipe_sbp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->no_sbp->Visible) { // no_sbp ?>
		<th><span id="elh_vw_spj_gu_no_sbp" class="vw_spj_gu_no_sbp"><?php echo $vw_spj_gu->no_sbp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->tgl_sbp->Visible) { // tgl_sbp ?>
		<th><span id="elh_vw_spj_gu_tgl_sbp" class="vw_spj_gu_tgl_sbp"><?php echo $vw_spj_gu->tgl_sbp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->sub_kegiatan->Visible) { // sub_kegiatan ?>
		<th><span id="elh_vw_spj_gu_sub_kegiatan" class="vw_spj_gu_sub_kegiatan"><?php echo $vw_spj_gu->sub_kegiatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->uraian->Visible) { // uraian ?>
		<th><span id="elh_vw_spj_gu_uraian" class="vw_spj_gu_uraian"><?php echo $vw_spj_gu->uraian->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->nama_penerima->Visible) { // nama_penerima ?>
		<th><span id="elh_vw_spj_gu_nama_penerima" class="vw_spj_gu_nama_penerima"><?php echo $vw_spj_gu->nama_penerima->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->alamat_penerima->Visible) { // alamat_penerima ?>
		<th><span id="elh_vw_spj_gu_alamat_penerima" class="vw_spj_gu_alamat_penerima"><?php echo $vw_spj_gu->alamat_penerima->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->nama_pptk->Visible) { // nama_pptk ?>
		<th><span id="elh_vw_spj_gu_nama_pptk" class="vw_spj_gu_nama_pptk"><?php echo $vw_spj_gu->nama_pptk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->nip_pptk->Visible) { // nip_pptk ?>
		<th><span id="elh_vw_spj_gu_nip_pptk" class="vw_spj_gu_nip_pptk"><?php echo $vw_spj_gu->nip_pptk->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->nama_pengguna->Visible) { // nama_pengguna ?>
		<th><span id="elh_vw_spj_gu_nama_pengguna" class="vw_spj_gu_nama_pengguna"><?php echo $vw_spj_gu->nama_pengguna->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->nip_pengguna_anggaran->Visible) { // nip_pengguna_anggaran ?>
		<th><span id="elh_vw_spj_gu_nip_pengguna_anggaran" class="vw_spj_gu_nip_pengguna_anggaran"><?php echo $vw_spj_gu->nip_pengguna_anggaran->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->akun1->Visible) { // akun1 ?>
		<th><span id="elh_vw_spj_gu_akun1" class="vw_spj_gu_akun1"><?php echo $vw_spj_gu->akun1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->akun2->Visible) { // akun2 ?>
		<th><span id="elh_vw_spj_gu_akun2" class="vw_spj_gu_akun2"><?php echo $vw_spj_gu->akun2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->akun3->Visible) { // akun3 ?>
		<th><span id="elh_vw_spj_gu_akun3" class="vw_spj_gu_akun3"><?php echo $vw_spj_gu->akun3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->akun4->Visible) { // akun4 ?>
		<th><span id="elh_vw_spj_gu_akun4" class="vw_spj_gu_akun4"><?php echo $vw_spj_gu->akun4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->akun5->Visible) { // akun5 ?>
		<th><span id="elh_vw_spj_gu_akun5" class="vw_spj_gu_akun5"><?php echo $vw_spj_gu->akun5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->kode_rekening->Visible) { // kode_rekening ?>
		<th><span id="elh_vw_spj_gu_kode_rekening" class="vw_spj_gu_kode_rekening"><?php echo $vw_spj_gu->kode_rekening->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->pph21->Visible) { // pph21 ?>
		<th><span id="elh_vw_spj_gu_pph21" class="vw_spj_gu_pph21"><?php echo $vw_spj_gu->pph21->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->pph22->Visible) { // pph22 ?>
		<th><span id="elh_vw_spj_gu_pph22" class="vw_spj_gu_pph22"><?php echo $vw_spj_gu->pph22->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->pph23->Visible) { // pph23 ?>
		<th><span id="elh_vw_spj_gu_pph23" class="vw_spj_gu_pph23"><?php echo $vw_spj_gu->pph23->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->pph4->Visible) { // pph4 ?>
		<th><span id="elh_vw_spj_gu_pph4" class="vw_spj_gu_pph4"><?php echo $vw_spj_gu->pph4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_spj_gu->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<th><span id="elh_vw_spj_gu_jumlah_belanja" class="vw_spj_gu_jumlah_belanja"><?php echo $vw_spj_gu->jumlah_belanja->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$vw_spj_gu_delete->RecCnt = 0;
$i = 0;
while (!$vw_spj_gu_delete->Recordset->EOF) {
	$vw_spj_gu_delete->RecCnt++;
	$vw_spj_gu_delete->RowCnt++;

	// Set row properties
	$vw_spj_gu->ResetAttrs();
	$vw_spj_gu->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$vw_spj_gu_delete->LoadRowValues($vw_spj_gu_delete->Recordset);

	// Render row
	$vw_spj_gu_delete->RenderRow();
?>
	<tr<?php echo $vw_spj_gu->RowAttributes() ?>>
<?php if ($vw_spj_gu->id->Visible) { // id ?>
		<td<?php echo $vw_spj_gu->id->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_id" class="vw_spj_gu_id">
<span<?php echo $vw_spj_gu->id->ViewAttributes() ?>>
<?php echo $vw_spj_gu->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->no_spj->Visible) { // no_spj ?>
		<td<?php echo $vw_spj_gu->no_spj->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_no_spj" class="vw_spj_gu_no_spj">
<span<?php echo $vw_spj_gu->no_spj->ViewAttributes() ?>>
<?php echo $vw_spj_gu->no_spj->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->tgl_spj->Visible) { // tgl_spj ?>
		<td<?php echo $vw_spj_gu->tgl_spj->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_tgl_spj" class="vw_spj_gu_tgl_spj">
<span<?php echo $vw_spj_gu->tgl_spj->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tgl_spj->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->program->Visible) { // program ?>
		<td<?php echo $vw_spj_gu->program->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_program" class="vw_spj_gu_program">
<span<?php echo $vw_spj_gu->program->ViewAttributes() ?>>
<?php echo $vw_spj_gu->program->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->kegiatan->Visible) { // kegiatan ?>
		<td<?php echo $vw_spj_gu->kegiatan->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_kegiatan" class="vw_spj_gu_kegiatan">
<span<?php echo $vw_spj_gu->kegiatan->ViewAttributes() ?>>
<?php echo $vw_spj_gu->kegiatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->tipe->Visible) { // tipe ?>
		<td<?php echo $vw_spj_gu->tipe->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_tipe" class="vw_spj_gu_tipe">
<span<?php echo $vw_spj_gu->tipe->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tipe->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->tipe_sbp->Visible) { // tipe_sbp ?>
		<td<?php echo $vw_spj_gu->tipe_sbp->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_tipe_sbp" class="vw_spj_gu_tipe_sbp">
<span<?php echo $vw_spj_gu->tipe_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tipe_sbp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->no_sbp->Visible) { // no_sbp ?>
		<td<?php echo $vw_spj_gu->no_sbp->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_no_sbp" class="vw_spj_gu_no_sbp">
<span<?php echo $vw_spj_gu->no_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->no_sbp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->tgl_sbp->Visible) { // tgl_sbp ?>
		<td<?php echo $vw_spj_gu->tgl_sbp->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_tgl_sbp" class="vw_spj_gu_tgl_sbp">
<span<?php echo $vw_spj_gu->tgl_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tgl_sbp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->sub_kegiatan->Visible) { // sub_kegiatan ?>
		<td<?php echo $vw_spj_gu->sub_kegiatan->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_sub_kegiatan" class="vw_spj_gu_sub_kegiatan">
<span<?php echo $vw_spj_gu->sub_kegiatan->ViewAttributes() ?>>
<?php echo $vw_spj_gu->sub_kegiatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->uraian->Visible) { // uraian ?>
		<td<?php echo $vw_spj_gu->uraian->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_uraian" class="vw_spj_gu_uraian">
<span<?php echo $vw_spj_gu->uraian->ViewAttributes() ?>>
<?php echo $vw_spj_gu->uraian->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->nama_penerima->Visible) { // nama_penerima ?>
		<td<?php echo $vw_spj_gu->nama_penerima->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_nama_penerima" class="vw_spj_gu_nama_penerima">
<span<?php echo $vw_spj_gu->nama_penerima->ViewAttributes() ?>>
<?php echo $vw_spj_gu->nama_penerima->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->alamat_penerima->Visible) { // alamat_penerima ?>
		<td<?php echo $vw_spj_gu->alamat_penerima->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_alamat_penerima" class="vw_spj_gu_alamat_penerima">
<span<?php echo $vw_spj_gu->alamat_penerima->ViewAttributes() ?>>
<?php echo $vw_spj_gu->alamat_penerima->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->nama_pptk->Visible) { // nama_pptk ?>
		<td<?php echo $vw_spj_gu->nama_pptk->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_nama_pptk" class="vw_spj_gu_nama_pptk">
<span<?php echo $vw_spj_gu->nama_pptk->ViewAttributes() ?>>
<?php echo $vw_spj_gu->nama_pptk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->nip_pptk->Visible) { // nip_pptk ?>
		<td<?php echo $vw_spj_gu->nip_pptk->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_nip_pptk" class="vw_spj_gu_nip_pptk">
<span<?php echo $vw_spj_gu->nip_pptk->ViewAttributes() ?>>
<?php echo $vw_spj_gu->nip_pptk->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->nama_pengguna->Visible) { // nama_pengguna ?>
		<td<?php echo $vw_spj_gu->nama_pengguna->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_nama_pengguna" class="vw_spj_gu_nama_pengguna">
<span<?php echo $vw_spj_gu->nama_pengguna->ViewAttributes() ?>>
<?php echo $vw_spj_gu->nama_pengguna->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->nip_pengguna_anggaran->Visible) { // nip_pengguna_anggaran ?>
		<td<?php echo $vw_spj_gu->nip_pengguna_anggaran->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_nip_pengguna_anggaran" class="vw_spj_gu_nip_pengguna_anggaran">
<span<?php echo $vw_spj_gu->nip_pengguna_anggaran->ViewAttributes() ?>>
<?php echo $vw_spj_gu->nip_pengguna_anggaran->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->akun1->Visible) { // akun1 ?>
		<td<?php echo $vw_spj_gu->akun1->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_akun1" class="vw_spj_gu_akun1">
<span<?php echo $vw_spj_gu->akun1->ViewAttributes() ?>>
<?php echo $vw_spj_gu->akun1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->akun2->Visible) { // akun2 ?>
		<td<?php echo $vw_spj_gu->akun2->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_akun2" class="vw_spj_gu_akun2">
<span<?php echo $vw_spj_gu->akun2->ViewAttributes() ?>>
<?php echo $vw_spj_gu->akun2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->akun3->Visible) { // akun3 ?>
		<td<?php echo $vw_spj_gu->akun3->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_akun3" class="vw_spj_gu_akun3">
<span<?php echo $vw_spj_gu->akun3->ViewAttributes() ?>>
<?php echo $vw_spj_gu->akun3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->akun4->Visible) { // akun4 ?>
		<td<?php echo $vw_spj_gu->akun4->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_akun4" class="vw_spj_gu_akun4">
<span<?php echo $vw_spj_gu->akun4->ViewAttributes() ?>>
<?php echo $vw_spj_gu->akun4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->akun5->Visible) { // akun5 ?>
		<td<?php echo $vw_spj_gu->akun5->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_akun5" class="vw_spj_gu_akun5">
<span<?php echo $vw_spj_gu->akun5->ViewAttributes() ?>>
<?php echo $vw_spj_gu->akun5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->kode_rekening->Visible) { // kode_rekening ?>
		<td<?php echo $vw_spj_gu->kode_rekening->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_kode_rekening" class="vw_spj_gu_kode_rekening">
<span<?php echo $vw_spj_gu->kode_rekening->ViewAttributes() ?>>
<?php echo $vw_spj_gu->kode_rekening->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->pph21->Visible) { // pph21 ?>
		<td<?php echo $vw_spj_gu->pph21->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_pph21" class="vw_spj_gu_pph21">
<span<?php echo $vw_spj_gu->pph21->ViewAttributes() ?>>
<?php echo $vw_spj_gu->pph21->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->pph22->Visible) { // pph22 ?>
		<td<?php echo $vw_spj_gu->pph22->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_pph22" class="vw_spj_gu_pph22">
<span<?php echo $vw_spj_gu->pph22->ViewAttributes() ?>>
<?php echo $vw_spj_gu->pph22->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->pph23->Visible) { // pph23 ?>
		<td<?php echo $vw_spj_gu->pph23->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_pph23" class="vw_spj_gu_pph23">
<span<?php echo $vw_spj_gu->pph23->ViewAttributes() ?>>
<?php echo $vw_spj_gu->pph23->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->pph4->Visible) { // pph4 ?>
		<td<?php echo $vw_spj_gu->pph4->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_pph4" class="vw_spj_gu_pph4">
<span<?php echo $vw_spj_gu->pph4->ViewAttributes() ?>>
<?php echo $vw_spj_gu->pph4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_spj_gu->jumlah_belanja->Visible) { // jumlah_belanja ?>
		<td<?php echo $vw_spj_gu->jumlah_belanja->CellAttributes() ?>>
<span id="el<?php echo $vw_spj_gu_delete->RowCnt ?>_vw_spj_gu_jumlah_belanja" class="vw_spj_gu_jumlah_belanja">
<span<?php echo $vw_spj_gu->jumlah_belanja->ViewAttributes() ?>>
<?php echo $vw_spj_gu->jumlah_belanja->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$vw_spj_gu_delete->Recordset->MoveNext();
}
$vw_spj_gu_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spj_gu_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fvw_spj_gudelete.Init();
</script>
<?php
$vw_spj_gu_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spj_gu_delete->Page_Terminate();
?>
