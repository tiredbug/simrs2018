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

$t_sbp_delete = NULL; // Initialize page object first

class ct_sbp_delete extends ct_sbp {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sbp';

	// Page object name
	var $PageObjName = 't_sbp_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->tipe_sbp->SetVisibility();
		$this->no_sbp->SetVisibility();

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
			$this->Page_Terminate("t_sbplist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_sbp class, t_sbpinfo.php

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
				$this->Page_Terminate("t_sbplist.php"); // Return to list
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id

		$this->id->CellCssStyle = "white-space: nowrap;";

		// tipe
		$this->tipe->CellCssStyle = "white-space: nowrap;";

		// tipe_sbp
		$this->tipe_sbp->CellCssStyle = "white-space: nowrap;";

		// no_sbp
		$this->no_sbp->CellCssStyle = "white-space: nowrap;";

		// tgl_sbp
		$this->tgl_sbp->CellCssStyle = "white-space: nowrap;";

		// program
		$this->program->CellCssStyle = "white-space: nowrap;";

		// kegiatan
		$this->kegiatan->CellCssStyle = "white-space: nowrap;";

		// sub_kegiatan
		$this->sub_kegiatan->CellCssStyle = "white-space: nowrap;";

		// uraian
		$this->uraian->CellCssStyle = "white-space: nowrap;";

		// nama_penerima
		$this->nama_penerima->CellCssStyle = "white-space: nowrap;";

		// alamat_penerima
		$this->alamat_penerima->CellCssStyle = "white-space: nowrap;";

		// nama_pptk
		$this->nama_pptk->CellCssStyle = "white-space: nowrap;";

		// nip_pptk
		$this->nip_pptk->CellCssStyle = "white-space: nowrap;";

		// nama_pengguna
		$this->nama_pengguna->CellCssStyle = "white-space: nowrap;";

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->CellCssStyle = "white-space: nowrap;";

		// akun1
		$this->akun1->CellCssStyle = "white-space: nowrap;";

		// akun2
		$this->akun2->CellCssStyle = "white-space: nowrap;";

		// akun3
		$this->akun3->CellCssStyle = "white-space: nowrap;";

		// akun4
		$this->akun4->CellCssStyle = "white-space: nowrap;";

		// akun5
		$this->akun5->CellCssStyle = "white-space: nowrap;";

		// kode_rekening
		$this->kode_rekening->CellCssStyle = "white-space: nowrap;";

		// pph21
		$this->pph21->CellCssStyle = "white-space: nowrap;";

		// pph22
		$this->pph22->CellCssStyle = "white-space: nowrap;";

		// pph23
		$this->pph23->CellCssStyle = "white-space: nowrap;";

		// pph4
		$this->pph4->CellCssStyle = "white-space: nowrap;";

		// jumlah_belanja
		$this->jumlah_belanja->CellCssStyle = "white-space: nowrap;";

		// no_spj
		$this->no_spj->CellCssStyle = "white-space: nowrap;";

		// tgl_spj
		$this->tgl_spj->CellCssStyle = "white-space: nowrap;";

		// tahun_anggaran
		$this->tahun_anggaran->CellCssStyle = "white-space: nowrap;";

		// kode_opd
		$this->kode_opd->CellCssStyle = "white-space: nowrap;";

		// ppn
		$this->ppn->CellCssStyle = "white-space: nowrap;";

		// nama_bendahara_pengeluaran
		$this->nama_bendahara_pengeluaran->CellCssStyle = "white-space: nowrap;";

		// nip_bendahara_pengeluaran
		$this->nip_bendahara_pengeluaran->CellCssStyle = "white-space: nowrap;";

		// status_spj
		$this->status_spj->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// tipe_sbp
			$this->tipe_sbp->LinkCustomAttributes = "";
			$this->tipe_sbp->HrefValue = "";
			$this->tipe_sbp->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_sbplist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_sbp_delete)) $t_sbp_delete = new ct_sbp_delete();

// Page init
$t_sbp_delete->Page_Init();

// Page main
$t_sbp_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sbp_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_sbpdelete = new ew_Form("ft_sbpdelete", "delete");

// Form_CustomValidate event
ft_sbpdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sbpdelete.ValidateRequired = true;
<?php } else { ?>
ft_sbpdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sbpdelete.Lists["x_tipe_sbp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sbpdelete.Lists["x_tipe_sbp"].Options = <?php echo json_encode($t_sbp->tipe_sbp->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t_sbp_delete->ShowPageHeader(); ?>
<?php
$t_sbp_delete->ShowMessage();
?>
<form name="ft_sbpdelete" id="ft_sbpdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_sbp_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_sbp_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_sbp">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_sbp_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_sbp->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_sbp->id->Visible) { // id ?>
		<th><span id="elh_t_sbp_id" class="t_sbp_id"><?php echo $t_sbp->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_sbp->tipe_sbp->Visible) { // tipe_sbp ?>
		<th><span id="elh_t_sbp_tipe_sbp" class="t_sbp_tipe_sbp"><?php echo $t_sbp->tipe_sbp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_sbp->no_sbp->Visible) { // no_sbp ?>
		<th><span id="elh_t_sbp_no_sbp" class="t_sbp_no_sbp"><?php echo $t_sbp->no_sbp->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_sbp_delete->RecCnt = 0;
$i = 0;
while (!$t_sbp_delete->Recordset->EOF) {
	$t_sbp_delete->RecCnt++;
	$t_sbp_delete->RowCnt++;

	// Set row properties
	$t_sbp->ResetAttrs();
	$t_sbp->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_sbp_delete->LoadRowValues($t_sbp_delete->Recordset);

	// Render row
	$t_sbp_delete->RenderRow();
?>
	<tr<?php echo $t_sbp->RowAttributes() ?>>
<?php if ($t_sbp->id->Visible) { // id ?>
		<td<?php echo $t_sbp->id->CellAttributes() ?>>
<div id="orig<?php echo $t_sbp_delete->RowCnt ?>_t_sbp_id" class="hide">
<span id="el<?php echo $t_sbp_delete->RowCnt ?>_t_sbp_id" class="t_sbp_id">
<span<?php echo $t_sbp->id->ViewAttributes() ?>>
<?php echo $t_sbp->id->ListViewValue() ?></span>
</span>
</div>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_sbp.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">
CETAK SBP <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
</td>
<?php } ?>
<?php if ($t_sbp->tipe_sbp->Visible) { // tipe_sbp ?>
		<td<?php echo $t_sbp->tipe_sbp->CellAttributes() ?>>
<span id="el<?php echo $t_sbp_delete->RowCnt ?>_t_sbp_tipe_sbp" class="t_sbp_tipe_sbp">
<span<?php echo $t_sbp->tipe_sbp->ViewAttributes() ?>>
<?php echo $t_sbp->tipe_sbp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_sbp->no_sbp->Visible) { // no_sbp ?>
		<td<?php echo $t_sbp->no_sbp->CellAttributes() ?>>
<span id="el<?php echo $t_sbp_delete->RowCnt ?>_t_sbp_no_sbp" class="t_sbp_no_sbp">
<span<?php echo $t_sbp->no_sbp->ViewAttributes() ?>>
<?php echo $t_sbp->no_sbp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_sbp_delete->Recordset->MoveNext();
}
$t_sbp_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_sbp_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_sbpdelete.Init();
</script>
<?php
$t_sbp_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_sbp_delete->Page_Terminate();
?>
