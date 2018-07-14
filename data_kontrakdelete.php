<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "data_kontrakinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$data_kontrak_delete = NULL; // Initialize page object first

class cdata_kontrak_delete extends cdata_kontrak {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'data_kontrak';

	// Page object name
	var $PageObjName = 'data_kontrak_delete';

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

		// Table object (data_kontrak)
		if (!isset($GLOBALS["data_kontrak"]) || get_class($GLOBALS["data_kontrak"]) == "cdata_kontrak") {
			$GLOBALS["data_kontrak"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["data_kontrak"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'data_kontrak', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("data_kontraklist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->sub_kegiatan->SetVisibility();
		$this->no_kontrak->SetVisibility();
		$this->tgl_kontrak->SetVisibility();
		$this->nama_perusahaan->SetVisibility();

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
		global $EW_EXPORT, $data_kontrak;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($data_kontrak);
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
			$this->Page_Terminate("data_kontraklist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in data_kontrak class, data_kontrakinfo.php

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
				$this->Page_Terminate("data_kontraklist.php"); // Return to list
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
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->no_kontrak->setDbValue($rs->fields('no_kontrak'));
		$this->tgl_kontrak->setDbValue($rs->fields('tgl_kontrak'));
		$this->nama_perusahaan->setDbValue($rs->fields('nama_perusahaan'));
		$this->bentuk_perusahaan->setDbValue($rs->fields('bentuk_perusahaan'));
		$this->alamat_perusahaan->setDbValue($rs->fields('alamat_perusahaan'));
		$this->kepala_perusahaan->setDbValue($rs->fields('kepala_perusahaan'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nama_rekening->setDbValue($rs->fields('nama_rekening'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->lanjutkan->setDbValue($rs->fields('lanjutkan'));
		$this->waktu_kontrak->setDbValue($rs->fields('waktu_kontrak'));
		$this->tgl_mulai->setDbValue($rs->fields('tgl_mulai'));
		$this->tgl_selesai->setDbValue($rs->fields('tgl_selesai'));
		$this->paket_pekerjaan->setDbValue($rs->fields('paket_pekerjaan'));
		$this->nama_ppkom->setDbValue($rs->fields('nama_ppkom'));
		$this->nip_ppkom->setDbValue($rs->fields('nip_ppkom'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->no_kontrak->DbValue = $row['no_kontrak'];
		$this->tgl_kontrak->DbValue = $row['tgl_kontrak'];
		$this->nama_perusahaan->DbValue = $row['nama_perusahaan'];
		$this->bentuk_perusahaan->DbValue = $row['bentuk_perusahaan'];
		$this->alamat_perusahaan->DbValue = $row['alamat_perusahaan'];
		$this->kepala_perusahaan->DbValue = $row['kepala_perusahaan'];
		$this->npwp->DbValue = $row['npwp'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->nama_rekening->DbValue = $row['nama_rekening'];
		$this->nomer_rekening->DbValue = $row['nomer_rekening'];
		$this->lanjutkan->DbValue = $row['lanjutkan'];
		$this->waktu_kontrak->DbValue = $row['waktu_kontrak'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_selesai->DbValue = $row['tgl_selesai'];
		$this->paket_pekerjaan->DbValue = $row['paket_pekerjaan'];
		$this->nama_ppkom->DbValue = $row['nama_ppkom'];
		$this->nip_ppkom->DbValue = $row['nip_ppkom'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// program
		// kegiatan
		// sub_kegiatan
		// no_kontrak
		// tgl_kontrak
		// nama_perusahaan
		// bentuk_perusahaan
		// alamat_perusahaan
		// kepala_perusahaan
		// npwp
		// nama_bank
		// nama_rekening
		// nomer_rekening
		// lanjutkan
		// waktu_kontrak
		// tgl_mulai
		// tgl_selesai
		// paket_pekerjaan
		// nama_ppkom
		// nip_ppkom

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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

		// no_kontrak
		$this->no_kontrak->ViewValue = $this->no_kontrak->CurrentValue;
		$this->no_kontrak->ViewCustomAttributes = "";

		// tgl_kontrak
		$this->tgl_kontrak->ViewValue = $this->tgl_kontrak->CurrentValue;
		$this->tgl_kontrak->ViewValue = ew_FormatDateTime($this->tgl_kontrak->ViewValue, 0);
		$this->tgl_kontrak->ViewCustomAttributes = "";

		// nama_perusahaan
		$this->nama_perusahaan->ViewValue = $this->nama_perusahaan->CurrentValue;
		$this->nama_perusahaan->ViewCustomAttributes = "";

		// bentuk_perusahaan
		if (strval($this->bentuk_perusahaan->CurrentValue) <> "") {
			$sFilterWrk = "`bentuk perusahaan`" . ew_SearchString("=", $this->bentuk_perusahaan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `bentuk perusahaan`, `bentuk perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bentuk_perusahaan`";
		$sWhereWrk = "";
		$this->bentuk_perusahaan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bentuk_perusahaan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->CurrentValue;
			}
		} else {
			$this->bentuk_perusahaan->ViewValue = NULL;
		}
		$this->bentuk_perusahaan->ViewCustomAttributes = "";

		// alamat_perusahaan
		$this->alamat_perusahaan->ViewValue = $this->alamat_perusahaan->CurrentValue;
		$this->alamat_perusahaan->ViewCustomAttributes = "";

		// kepala_perusahaan
		$this->kepala_perusahaan->ViewValue = $this->kepala_perusahaan->CurrentValue;
		$this->kepala_perusahaan->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nama_rekening
		$this->nama_rekening->ViewValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// lanjutkan
		if (strval($this->lanjutkan->CurrentValue) <> "") {
			$this->lanjutkan->ViewValue = $this->lanjutkan->OptionCaption($this->lanjutkan->CurrentValue);
		} else {
			$this->lanjutkan->ViewValue = NULL;
		}
		$this->lanjutkan->ViewCustomAttributes = "";

		// waktu_kontrak
		$this->waktu_kontrak->ViewValue = $this->waktu_kontrak->CurrentValue;
		$this->waktu_kontrak->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 7);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_selesai
		$this->tgl_selesai->ViewValue = $this->tgl_selesai->CurrentValue;
		$this->tgl_selesai->ViewValue = ew_FormatDateTime($this->tgl_selesai->ViewValue, 7);
		$this->tgl_selesai->ViewCustomAttributes = "";

		// paket_pekerjaan
		$this->paket_pekerjaan->ViewValue = $this->paket_pekerjaan->CurrentValue;
		$this->paket_pekerjaan->ViewCustomAttributes = "";

		// nama_ppkom
		if (strval($this->nama_ppkom->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_ppkom->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_ppkom->LookupFilters = array();
		$lookuptblfilter = "`jabatan`=3";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_ppkom, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->CurrentValue;
			}
		} else {
			$this->nama_ppkom->ViewValue = NULL;
		}
		$this->nama_ppkom->ViewCustomAttributes = "";

		// nip_ppkom
		$this->nip_ppkom->ViewValue = $this->nip_ppkom->CurrentValue;
		$this->nip_ppkom->ViewCustomAttributes = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";
			$this->sub_kegiatan->TooltipValue = "";

			// no_kontrak
			$this->no_kontrak->LinkCustomAttributes = "";
			$this->no_kontrak->HrefValue = "";
			$this->no_kontrak->TooltipValue = "";

			// tgl_kontrak
			$this->tgl_kontrak->LinkCustomAttributes = "";
			$this->tgl_kontrak->HrefValue = "";
			$this->tgl_kontrak->TooltipValue = "";

			// nama_perusahaan
			$this->nama_perusahaan->LinkCustomAttributes = "";
			$this->nama_perusahaan->HrefValue = "";
			$this->nama_perusahaan->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("data_kontraklist.php"), "", $this->TableVar, TRUE);
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
if (!isset($data_kontrak_delete)) $data_kontrak_delete = new cdata_kontrak_delete();

// Page init
$data_kontrak_delete->Page_Init();

// Page main
$data_kontrak_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$data_kontrak_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fdata_kontrakdelete = new ew_Form("fdata_kontrakdelete", "delete");

// Form_CustomValidate event
fdata_kontrakdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdata_kontrakdelete.ValidateRequired = true;
<?php } else { ?>
fdata_kontrakdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdata_kontrakdelete.Lists["x_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $data_kontrak_delete->ShowPageHeader(); ?>
<?php
$data_kontrak_delete->ShowMessage();
?>
<form name="fdata_kontrakdelete" id="fdata_kontrakdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($data_kontrak_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $data_kontrak_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="data_kontrak">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($data_kontrak_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $data_kontrak->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($data_kontrak->sub_kegiatan->Visible) { // sub_kegiatan ?>
		<th><span id="elh_data_kontrak_sub_kegiatan" class="data_kontrak_sub_kegiatan"><?php echo $data_kontrak->sub_kegiatan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($data_kontrak->no_kontrak->Visible) { // no_kontrak ?>
		<th><span id="elh_data_kontrak_no_kontrak" class="data_kontrak_no_kontrak"><?php echo $data_kontrak->no_kontrak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($data_kontrak->tgl_kontrak->Visible) { // tgl_kontrak ?>
		<th><span id="elh_data_kontrak_tgl_kontrak" class="data_kontrak_tgl_kontrak"><?php echo $data_kontrak->tgl_kontrak->FldCaption() ?></span></th>
<?php } ?>
<?php if ($data_kontrak->nama_perusahaan->Visible) { // nama_perusahaan ?>
		<th><span id="elh_data_kontrak_nama_perusahaan" class="data_kontrak_nama_perusahaan"><?php echo $data_kontrak->nama_perusahaan->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$data_kontrak_delete->RecCnt = 0;
$i = 0;
while (!$data_kontrak_delete->Recordset->EOF) {
	$data_kontrak_delete->RecCnt++;
	$data_kontrak_delete->RowCnt++;

	// Set row properties
	$data_kontrak->ResetAttrs();
	$data_kontrak->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$data_kontrak_delete->LoadRowValues($data_kontrak_delete->Recordset);

	// Render row
	$data_kontrak_delete->RenderRow();
?>
	<tr<?php echo $data_kontrak->RowAttributes() ?>>
<?php if ($data_kontrak->sub_kegiatan->Visible) { // sub_kegiatan ?>
		<td<?php echo $data_kontrak->sub_kegiatan->CellAttributes() ?>>
<span id="el<?php echo $data_kontrak_delete->RowCnt ?>_data_kontrak_sub_kegiatan" class="data_kontrak_sub_kegiatan">
<span<?php echo $data_kontrak->sub_kegiatan->ViewAttributes() ?>>
<?php echo $data_kontrak->sub_kegiatan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($data_kontrak->no_kontrak->Visible) { // no_kontrak ?>
		<td<?php echo $data_kontrak->no_kontrak->CellAttributes() ?>>
<span id="el<?php echo $data_kontrak_delete->RowCnt ?>_data_kontrak_no_kontrak" class="data_kontrak_no_kontrak">
<span<?php echo $data_kontrak->no_kontrak->ViewAttributes() ?>>
<?php echo $data_kontrak->no_kontrak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($data_kontrak->tgl_kontrak->Visible) { // tgl_kontrak ?>
		<td<?php echo $data_kontrak->tgl_kontrak->CellAttributes() ?>>
<span id="el<?php echo $data_kontrak_delete->RowCnt ?>_data_kontrak_tgl_kontrak" class="data_kontrak_tgl_kontrak">
<span<?php echo $data_kontrak->tgl_kontrak->ViewAttributes() ?>>
<?php echo $data_kontrak->tgl_kontrak->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($data_kontrak->nama_perusahaan->Visible) { // nama_perusahaan ?>
		<td<?php echo $data_kontrak->nama_perusahaan->CellAttributes() ?>>
<span id="el<?php echo $data_kontrak_delete->RowCnt ?>_data_kontrak_nama_perusahaan" class="data_kontrak_nama_perusahaan">
<span<?php echo $data_kontrak->nama_perusahaan->ViewAttributes() ?>>
<?php echo $data_kontrak->nama_perusahaan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$data_kontrak_delete->Recordset->MoveNext();
}
$data_kontrak_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $data_kontrak_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fdata_kontrakdelete.Init();
</script>
<?php
$data_kontrak_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$data_kontrak_delete->Page_Terminate();
?>
