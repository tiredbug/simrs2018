<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_admission_detailinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_admission_detail_delete = NULL; // Initialize page object first

class ct_admission_detail_delete extends ct_admission_detail {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_admission_detail';

	// Page object name
	var $PageObjName = 't_admission_detail_delete';

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

		// Table object (t_admission_detail)
		if (!isset($GLOBALS["t_admission_detail"]) || get_class($GLOBALS["t_admission_detail"]) == "ct_admission_detail") {
			$GLOBALS["t_admission_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_admission_detail"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_admission_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_admission_detaillist.php"));
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
		$this->id_admission->SetVisibility();
		$this->nomr->SetVisibility();
		$this->statusbayar->SetVisibility();
		$this->kelas->SetVisibility();
		$this->tanggal->SetVisibility();
		$this->kode_tindakan->SetVisibility();
		$this->nama_tindakan->SetVisibility();
		$this->kelompok_tindakan->SetVisibility();
		$this->kelompok1->SetVisibility();
		$this->kelompok2->SetVisibility();
		$this->tarif->SetVisibility();
		$this->bhp->SetVisibility();
		$this->qty->SetVisibility();
		$this->user->SetVisibility();
		$this->kode_dokter->SetVisibility();
		$this->kode_farmasi->SetVisibility();
		$this->no_ruang->SetVisibility();

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
		global $EW_EXPORT, $t_admission_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_admission_detail);
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
			$this->Page_Terminate("t_admission_detaillist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_admission_detail class, t_admission_detailinfo.php

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
				$this->Page_Terminate("t_admission_detaillist.php"); // Return to list
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->kode_tindakan->setDbValue($rs->fields('kode_tindakan'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->kelompok1->setDbValue($rs->fields('kelompok1'));
		$this->kelompok2->setDbValue($rs->fields('kelompok2'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->bhp->setDbValue($rs->fields('bhp'));
		$this->qty->setDbValue($rs->fields('qty'));
		$this->user->setDbValue($rs->fields('user'));
		$this->kode_dokter->setDbValue($rs->fields('kode_dokter'));
		$this->kode_farmasi->setDbValue($rs->fields('kode_farmasi'));
		$this->no_ruang->setDbValue($rs->fields('no_ruang'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kelas->DbValue = $row['kelas'];
		$this->tanggal->DbValue = $row['tanggal'];
		$this->kode_tindakan->DbValue = $row['kode_tindakan'];
		$this->nama_tindakan->DbValue = $row['nama_tindakan'];
		$this->kelompok_tindakan->DbValue = $row['kelompok_tindakan'];
		$this->kelompok1->DbValue = $row['kelompok1'];
		$this->kelompok2->DbValue = $row['kelompok2'];
		$this->tarif->DbValue = $row['tarif'];
		$this->bhp->DbValue = $row['bhp'];
		$this->qty->DbValue = $row['qty'];
		$this->user->DbValue = $row['user'];
		$this->kode_dokter->DbValue = $row['kode_dokter'];
		$this->kode_farmasi->DbValue = $row['kode_farmasi'];
		$this->no_ruang->DbValue = $row['no_ruang'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->tarif->FormValue == $this->tarif->CurrentValue && is_numeric(ew_StrToFloat($this->tarif->CurrentValue)))
			$this->tarif->CurrentValue = ew_StrToFloat($this->tarif->CurrentValue);

		// Convert decimal values if posted back
		if ($this->bhp->FormValue == $this->bhp->CurrentValue && is_numeric(ew_StrToFloat($this->bhp->CurrentValue)))
			$this->bhp->CurrentValue = ew_StrToFloat($this->bhp->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_admission
		// nomr
		// statusbayar
		// kelas
		// tanggal
		// kode_tindakan
		// nama_tindakan
		// kelompok_tindakan
		// kelompok1
		// kelompok2
		// tarif
		// bhp
		// qty
		// user
		// kode_dokter
		// kode_farmasi
		// no_ruang

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
		$this->statusbayar->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 0);
		$this->tanggal->ViewCustomAttributes = "";

		// kode_tindakan
		$this->kode_tindakan->ViewValue = $this->kode_tindakan->CurrentValue;
		$this->kode_tindakan->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// kelompok1
		$this->kelompok1->ViewValue = $this->kelompok1->CurrentValue;
		$this->kelompok1->ViewCustomAttributes = "";

		// kelompok2
		$this->kelompok2->ViewValue = $this->kelompok2->CurrentValue;
		$this->kelompok2->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

		// qty
		$this->qty->ViewValue = $this->qty->CurrentValue;
		$this->qty->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// kode_dokter
		$this->kode_dokter->ViewValue = $this->kode_dokter->CurrentValue;
		$this->kode_dokter->ViewCustomAttributes = "";

		// kode_farmasi
		$this->kode_farmasi->ViewValue = $this->kode_farmasi->CurrentValue;
		$this->kode_farmasi->ViewCustomAttributes = "";

		// no_ruang
		$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// id_admission
			$this->id_admission->LinkCustomAttributes = "";
			$this->id_admission->HrefValue = "";
			$this->id_admission->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";
			$this->kelas->TooltipValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";
			$this->kode_tindakan->TooltipValue = "";

			// nama_tindakan
			$this->nama_tindakan->LinkCustomAttributes = "";
			$this->nama_tindakan->HrefValue = "";
			$this->nama_tindakan->TooltipValue = "";

			// kelompok_tindakan
			$this->kelompok_tindakan->LinkCustomAttributes = "";
			$this->kelompok_tindakan->HrefValue = "";
			$this->kelompok_tindakan->TooltipValue = "";

			// kelompok1
			$this->kelompok1->LinkCustomAttributes = "";
			$this->kelompok1->HrefValue = "";
			$this->kelompok1->TooltipValue = "";

			// kelompok2
			$this->kelompok2->LinkCustomAttributes = "";
			$this->kelompok2->HrefValue = "";
			$this->kelompok2->TooltipValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";
			$this->tarif->TooltipValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";
			$this->bhp->TooltipValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";
			$this->qty->TooltipValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";
			$this->user->TooltipValue = "";

			// kode_dokter
			$this->kode_dokter->LinkCustomAttributes = "";
			$this->kode_dokter->HrefValue = "";
			$this->kode_dokter->TooltipValue = "";

			// kode_farmasi
			$this->kode_farmasi->LinkCustomAttributes = "";
			$this->kode_farmasi->HrefValue = "";
			$this->kode_farmasi->TooltipValue = "";

			// no_ruang
			$this->no_ruang->LinkCustomAttributes = "";
			$this->no_ruang->HrefValue = "";
			$this->no_ruang->TooltipValue = "";
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
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

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
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_admission_detaillist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_admission_detail_delete)) $t_admission_detail_delete = new ct_admission_detail_delete();

// Page init
$t_admission_detail_delete->Page_Init();

// Page main
$t_admission_detail_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_admission_detail_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_admission_detaildelete = new ew_Form("ft_admission_detaildelete", "delete");

// Form_CustomValidate event
ft_admission_detaildelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_admission_detaildelete.ValidateRequired = true;
<?php } else { ?>
ft_admission_detaildelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t_admission_detail_delete->ShowPageHeader(); ?>
<?php
$t_admission_detail_delete->ShowMessage();
?>
<form name="ft_admission_detaildelete" id="ft_admission_detaildelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_admission_detail_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_admission_detail_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_admission_detail">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_admission_detail_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_admission_detail->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_admission_detail->id->Visible) { // id ?>
		<th><span id="elh_t_admission_detail_id" class="t_admission_detail_id"><?php echo $t_admission_detail->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->id_admission->Visible) { // id_admission ?>
		<th><span id="elh_t_admission_detail_id_admission" class="t_admission_detail_id_admission"><?php echo $t_admission_detail->id_admission->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->nomr->Visible) { // nomr ?>
		<th><span id="elh_t_admission_detail_nomr" class="t_admission_detail_nomr"><?php echo $t_admission_detail->nomr->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->statusbayar->Visible) { // statusbayar ?>
		<th><span id="elh_t_admission_detail_statusbayar" class="t_admission_detail_statusbayar"><?php echo $t_admission_detail->statusbayar->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->kelas->Visible) { // kelas ?>
		<th><span id="elh_t_admission_detail_kelas" class="t_admission_detail_kelas"><?php echo $t_admission_detail->kelas->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->tanggal->Visible) { // tanggal ?>
		<th><span id="elh_t_admission_detail_tanggal" class="t_admission_detail_tanggal"><?php echo $t_admission_detail->tanggal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->kode_tindakan->Visible) { // kode_tindakan ?>
		<th><span id="elh_t_admission_detail_kode_tindakan" class="t_admission_detail_kode_tindakan"><?php echo $t_admission_detail->kode_tindakan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->nama_tindakan->Visible) { // nama_tindakan ?>
		<th><span id="elh_t_admission_detail_nama_tindakan" class="t_admission_detail_nama_tindakan"><?php echo $t_admission_detail->nama_tindakan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->kelompok_tindakan->Visible) { // kelompok_tindakan ?>
		<th><span id="elh_t_admission_detail_kelompok_tindakan" class="t_admission_detail_kelompok_tindakan"><?php echo $t_admission_detail->kelompok_tindakan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->kelompok1->Visible) { // kelompok1 ?>
		<th><span id="elh_t_admission_detail_kelompok1" class="t_admission_detail_kelompok1"><?php echo $t_admission_detail->kelompok1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->kelompok2->Visible) { // kelompok2 ?>
		<th><span id="elh_t_admission_detail_kelompok2" class="t_admission_detail_kelompok2"><?php echo $t_admission_detail->kelompok2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->tarif->Visible) { // tarif ?>
		<th><span id="elh_t_admission_detail_tarif" class="t_admission_detail_tarif"><?php echo $t_admission_detail->tarif->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->bhp->Visible) { // bhp ?>
		<th><span id="elh_t_admission_detail_bhp" class="t_admission_detail_bhp"><?php echo $t_admission_detail->bhp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->qty->Visible) { // qty ?>
		<th><span id="elh_t_admission_detail_qty" class="t_admission_detail_qty"><?php echo $t_admission_detail->qty->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->user->Visible) { // user ?>
		<th><span id="elh_t_admission_detail_user" class="t_admission_detail_user"><?php echo $t_admission_detail->user->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->kode_dokter->Visible) { // kode_dokter ?>
		<th><span id="elh_t_admission_detail_kode_dokter" class="t_admission_detail_kode_dokter"><?php echo $t_admission_detail->kode_dokter->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->kode_farmasi->Visible) { // kode_farmasi ?>
		<th><span id="elh_t_admission_detail_kode_farmasi" class="t_admission_detail_kode_farmasi"><?php echo $t_admission_detail->kode_farmasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_admission_detail->no_ruang->Visible) { // no_ruang ?>
		<th><span id="elh_t_admission_detail_no_ruang" class="t_admission_detail_no_ruang"><?php echo $t_admission_detail->no_ruang->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_admission_detail_delete->RecCnt = 0;
$i = 0;
while (!$t_admission_detail_delete->Recordset->EOF) {
	$t_admission_detail_delete->RecCnt++;
	$t_admission_detail_delete->RowCnt++;

	// Set row properties
	$t_admission_detail->ResetAttrs();
	$t_admission_detail->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_admission_detail_delete->LoadRowValues($t_admission_detail_delete->Recordset);

	// Render row
	$t_admission_detail_delete->RenderRow();
?>
	<tr<?php echo $t_admission_detail->RowAttributes() ?>>
<?php if ($t_admission_detail->id->Visible) { // id ?>
		<td<?php echo $t_admission_detail->id->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_id" class="t_admission_detail_id">
<span<?php echo $t_admission_detail->id->ViewAttributes() ?>>
<?php echo $t_admission_detail->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->id_admission->Visible) { // id_admission ?>
		<td<?php echo $t_admission_detail->id_admission->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_id_admission" class="t_admission_detail_id_admission">
<span<?php echo $t_admission_detail->id_admission->ViewAttributes() ?>>
<?php echo $t_admission_detail->id_admission->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->nomr->Visible) { // nomr ?>
		<td<?php echo $t_admission_detail->nomr->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_nomr" class="t_admission_detail_nomr">
<span<?php echo $t_admission_detail->nomr->ViewAttributes() ?>>
<?php echo $t_admission_detail->nomr->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->statusbayar->Visible) { // statusbayar ?>
		<td<?php echo $t_admission_detail->statusbayar->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_statusbayar" class="t_admission_detail_statusbayar">
<span<?php echo $t_admission_detail->statusbayar->ViewAttributes() ?>>
<?php echo $t_admission_detail->statusbayar->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->kelas->Visible) { // kelas ?>
		<td<?php echo $t_admission_detail->kelas->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_kelas" class="t_admission_detail_kelas">
<span<?php echo $t_admission_detail->kelas->ViewAttributes() ?>>
<?php echo $t_admission_detail->kelas->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->tanggal->Visible) { // tanggal ?>
		<td<?php echo $t_admission_detail->tanggal->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_tanggal" class="t_admission_detail_tanggal">
<span<?php echo $t_admission_detail->tanggal->ViewAttributes() ?>>
<?php echo $t_admission_detail->tanggal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->kode_tindakan->Visible) { // kode_tindakan ?>
		<td<?php echo $t_admission_detail->kode_tindakan->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_kode_tindakan" class="t_admission_detail_kode_tindakan">
<span<?php echo $t_admission_detail->kode_tindakan->ViewAttributes() ?>>
<?php echo $t_admission_detail->kode_tindakan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->nama_tindakan->Visible) { // nama_tindakan ?>
		<td<?php echo $t_admission_detail->nama_tindakan->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_nama_tindakan" class="t_admission_detail_nama_tindakan">
<span<?php echo $t_admission_detail->nama_tindakan->ViewAttributes() ?>>
<?php echo $t_admission_detail->nama_tindakan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->kelompok_tindakan->Visible) { // kelompok_tindakan ?>
		<td<?php echo $t_admission_detail->kelompok_tindakan->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_kelompok_tindakan" class="t_admission_detail_kelompok_tindakan">
<span<?php echo $t_admission_detail->kelompok_tindakan->ViewAttributes() ?>>
<?php echo $t_admission_detail->kelompok_tindakan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->kelompok1->Visible) { // kelompok1 ?>
		<td<?php echo $t_admission_detail->kelompok1->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_kelompok1" class="t_admission_detail_kelompok1">
<span<?php echo $t_admission_detail->kelompok1->ViewAttributes() ?>>
<?php echo $t_admission_detail->kelompok1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->kelompok2->Visible) { // kelompok2 ?>
		<td<?php echo $t_admission_detail->kelompok2->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_kelompok2" class="t_admission_detail_kelompok2">
<span<?php echo $t_admission_detail->kelompok2->ViewAttributes() ?>>
<?php echo $t_admission_detail->kelompok2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->tarif->Visible) { // tarif ?>
		<td<?php echo $t_admission_detail->tarif->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_tarif" class="t_admission_detail_tarif">
<span<?php echo $t_admission_detail->tarif->ViewAttributes() ?>>
<?php echo $t_admission_detail->tarif->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->bhp->Visible) { // bhp ?>
		<td<?php echo $t_admission_detail->bhp->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_bhp" class="t_admission_detail_bhp">
<span<?php echo $t_admission_detail->bhp->ViewAttributes() ?>>
<?php echo $t_admission_detail->bhp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->qty->Visible) { // qty ?>
		<td<?php echo $t_admission_detail->qty->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_qty" class="t_admission_detail_qty">
<span<?php echo $t_admission_detail->qty->ViewAttributes() ?>>
<?php echo $t_admission_detail->qty->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->user->Visible) { // user ?>
		<td<?php echo $t_admission_detail->user->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_user" class="t_admission_detail_user">
<span<?php echo $t_admission_detail->user->ViewAttributes() ?>>
<?php echo $t_admission_detail->user->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->kode_dokter->Visible) { // kode_dokter ?>
		<td<?php echo $t_admission_detail->kode_dokter->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_kode_dokter" class="t_admission_detail_kode_dokter">
<span<?php echo $t_admission_detail->kode_dokter->ViewAttributes() ?>>
<?php echo $t_admission_detail->kode_dokter->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->kode_farmasi->Visible) { // kode_farmasi ?>
		<td<?php echo $t_admission_detail->kode_farmasi->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_kode_farmasi" class="t_admission_detail_kode_farmasi">
<span<?php echo $t_admission_detail->kode_farmasi->ViewAttributes() ?>>
<?php echo $t_admission_detail->kode_farmasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_admission_detail->no_ruang->Visible) { // no_ruang ?>
		<td<?php echo $t_admission_detail->no_ruang->CellAttributes() ?>>
<span id="el<?php echo $t_admission_detail_delete->RowCnt ?>_t_admission_detail_no_ruang" class="t_admission_detail_no_ruang">
<span<?php echo $t_admission_detail->no_ruang->ViewAttributes() ?>>
<?php echo $t_admission_detail->no_ruang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_admission_detail_delete->Recordset->MoveNext();
}
$t_admission_detail_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_admission_detail_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_admission_detaildelete.Init();
</script>
<?php
$t_admission_detail_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_admission_detail_delete->Page_Terminate();
?>
