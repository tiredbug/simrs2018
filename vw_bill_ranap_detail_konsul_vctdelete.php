<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bill_ranap_detail_konsul_vctinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_bill_ranapinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bill_ranap_detail_konsul_vct_delete = NULL; // Initialize page object first

class cvw_bill_ranap_detail_konsul_vct_delete extends cvw_bill_ranap_detail_konsul_vct {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bill_ranap_detail_konsul_vct';

	// Page object name
	var $PageObjName = 'vw_bill_ranap_detail_konsul_vct_delete';

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

		// Table object (vw_bill_ranap_detail_konsul_vct)
		if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct"]) || get_class($GLOBALS["vw_bill_ranap_detail_konsul_vct"]) == "cvw_bill_ranap_detail_konsul_vct") {
			$GLOBALS["vw_bill_ranap_detail_konsul_vct"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bill_ranap_detail_konsul_vct"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (vw_bill_ranap)
		if (!isset($GLOBALS['vw_bill_ranap'])) $GLOBALS['vw_bill_ranap'] = new cvw_bill_ranap();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bill_ranap_detail_konsul_vct', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_bill_ranap_detail_konsul_vctlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->tanggal->SetVisibility();
		$this->kode_tindakan->SetVisibility();
		$this->kode_dokter->SetVisibility();
		$this->tarif->SetVisibility();
		$this->qty->SetVisibility();
		$this->user->SetVisibility();

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
		global $EW_EXPORT, $vw_bill_ranap_detail_konsul_vct;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bill_ranap_detail_konsul_vct);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("vw_bill_ranap_detail_konsul_vctlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in vw_bill_ranap_detail_konsul_vct class, vw_bill_ranap_detail_konsul_vctinfo.php

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
				$this->Page_Terminate("vw_bill_ranap_detail_konsul_vctlist.php"); // Return to list
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
		$this->kode_dokter->setDbValue($rs->fields('kode_dokter'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->qty->setDbValue($rs->fields('qty'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->kelompok1->setDbValue($rs->fields('kelompok1'));
		$this->kelompok2->setDbValue($rs->fields('kelompok2'));
		$this->bhp->setDbValue($rs->fields('bhp'));
		$this->user->setDbValue($rs->fields('user'));
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
		$this->kode_dokter->DbValue = $row['kode_dokter'];
		$this->tarif->DbValue = $row['tarif'];
		$this->qty->DbValue = $row['qty'];
		$this->nama_tindakan->DbValue = $row['nama_tindakan'];
		$this->kelompok_tindakan->DbValue = $row['kelompok_tindakan'];
		$this->kelompok1->DbValue = $row['kelompok1'];
		$this->kelompok2->DbValue = $row['kelompok2'];
		$this->bhp->DbValue = $row['bhp'];
		$this->user->DbValue = $row['user'];
		$this->no_ruang->DbValue = $row['no_ruang'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->tarif->FormValue == $this->tarif->CurrentValue && is_numeric(ew_StrToFloat($this->tarif->CurrentValue)))
			$this->tarif->CurrentValue = ew_StrToFloat($this->tarif->CurrentValue);

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
		// kode_dokter
		// tarif
		// qty
		// nama_tindakan
		// kelompok_tindakan
		// kelompok1
		// kelompok2
		// bhp
		// user
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
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->ViewCustomAttributes = "";

		// kode_tindakan
		if (strval($this->kode_tindakan->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_bill_ranap_data_tarif_tindakan`";
		$sWhereWrk = "";
		$this->kode_tindakan->LookupFilters = array();
		$lookuptblfilter = "`kelompok_tindakan`='10'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->CurrentValue;
			}
		} else {
			$this->kode_tindakan->ViewValue = NULL;
		}
		$this->kode_tindakan->ViewCustomAttributes = "";

		// kode_dokter
		if (strval($this->kode_dokter->CurrentValue) <> "") {
			$sFilterWrk = "`kd_dokter`" . ew_SearchString("=", $this->kode_dokter->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kd_dokter`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_dokter_jaga_ranap`";
		$sWhereWrk = "";
		$this->kode_dokter->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_dokter, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_dokter->ViewValue = $this->kode_dokter->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_dokter->ViewValue = $this->kode_dokter->CurrentValue;
			}
		} else {
			$this->kode_dokter->ViewValue = NULL;
		}
		$this->kode_dokter->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// qty
		$this->qty->ViewValue = $this->qty->CurrentValue;
		$this->qty->ViewCustomAttributes = "";

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

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// no_ruang
		$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->ViewCustomAttributes = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";
			$this->kode_tindakan->TooltipValue = "";

			// kode_dokter
			$this->kode_dokter->LinkCustomAttributes = "";
			$this->kode_dokter->HrefValue = "";
			$this->kode_dokter->TooltipValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";
			$this->tarif->TooltipValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";
			$this->qty->TooltipValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";
			$this->user->TooltipValue = "";
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "vw_bill_ranap") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id_admission"] <> "") {
					$GLOBALS["vw_bill_ranap"]->id_admission->setQueryStringValue($_GET["fk_id_admission"]);
					$this->id_admission->setQueryStringValue($GLOBALS["vw_bill_ranap"]->id_admission->QueryStringValue);
					$this->id_admission->setSessionValue($this->id_admission->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->id_admission->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_nomr"] <> "") {
					$GLOBALS["vw_bill_ranap"]->nomr->setQueryStringValue($_GET["fk_nomr"]);
					$this->nomr->setQueryStringValue($GLOBALS["vw_bill_ranap"]->nomr->QueryStringValue);
					$this->nomr->setSessionValue($this->nomr->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_statusbayar"] <> "") {
					$GLOBALS["vw_bill_ranap"]->statusbayar->setQueryStringValue($_GET["fk_statusbayar"]);
					$this->statusbayar->setQueryStringValue($GLOBALS["vw_bill_ranap"]->statusbayar->QueryStringValue);
					$this->statusbayar->setSessionValue($this->statusbayar->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->statusbayar->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_KELASPERAWATAN_ID"] <> "") {
					$GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->setQueryStringValue($_GET["fk_KELASPERAWATAN_ID"]);
					$this->kelas->setQueryStringValue($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->QueryStringValue);
					$this->kelas->setSessionValue($this->kelas->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "vw_bill_ranap") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id_admission"] <> "") {
					$GLOBALS["vw_bill_ranap"]->id_admission->setFormValue($_POST["fk_id_admission"]);
					$this->id_admission->setFormValue($GLOBALS["vw_bill_ranap"]->id_admission->FormValue);
					$this->id_admission->setSessionValue($this->id_admission->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->id_admission->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_nomr"] <> "") {
					$GLOBALS["vw_bill_ranap"]->nomr->setFormValue($_POST["fk_nomr"]);
					$this->nomr->setFormValue($GLOBALS["vw_bill_ranap"]->nomr->FormValue);
					$this->nomr->setSessionValue($this->nomr->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_statusbayar"] <> "") {
					$GLOBALS["vw_bill_ranap"]->statusbayar->setFormValue($_POST["fk_statusbayar"]);
					$this->statusbayar->setFormValue($GLOBALS["vw_bill_ranap"]->statusbayar->FormValue);
					$this->statusbayar->setSessionValue($this->statusbayar->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->statusbayar->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_KELASPERAWATAN_ID"] <> "") {
					$GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->setFormValue($_POST["fk_KELASPERAWATAN_ID"]);
					$this->kelas->setFormValue($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->FormValue);
					$this->kelas->setSessionValue($this->kelas->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "vw_bill_ranap") {
				if ($this->id_admission->CurrentValue == "") $this->id_admission->setSessionValue("");
				if ($this->nomr->CurrentValue == "") $this->nomr->setSessionValue("");
				if ($this->statusbayar->CurrentValue == "") $this->statusbayar->setSessionValue("");
				if ($this->kelas->CurrentValue == "") $this->kelas->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bill_ranap_detail_konsul_vctlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($vw_bill_ranap_detail_konsul_vct_delete)) $vw_bill_ranap_detail_konsul_vct_delete = new cvw_bill_ranap_detail_konsul_vct_delete();

// Page init
$vw_bill_ranap_detail_konsul_vct_delete->Page_Init();

// Page main
$vw_bill_ranap_detail_konsul_vct_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_konsul_vct_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fvw_bill_ranap_detail_konsul_vctdelete = new ew_Form("fvw_bill_ranap_detail_konsul_vctdelete", "delete");

// Form_CustomValidate event
fvw_bill_ranap_detail_konsul_vctdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_konsul_vctdelete.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_konsul_vctdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_konsul_vctdelete.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};
fvw_bill_ranap_detail_konsul_vctdelete.Lists["x_kode_dokter"] = {"LinkField":"x_kd_dokter","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_dokter_jaga_ranap"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $vw_bill_ranap_detail_konsul_vct_delete->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_konsul_vct_delete->ShowMessage();
?>
<form name="fvw_bill_ranap_detail_konsul_vctdelete" id="fvw_bill_ranap_detail_konsul_vctdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bill_ranap_detail_konsul_vct_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bill_ranap_detail_konsul_vct_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bill_ranap_detail_konsul_vct">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($vw_bill_ranap_detail_konsul_vct_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_bill_ranap_detail_konsul_vct->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($vw_bill_ranap_detail_konsul_vct->tanggal->Visible) { // tanggal ?>
		<th><span id="elh_vw_bill_ranap_detail_konsul_vct_tanggal" class="vw_bill_ranap_detail_konsul_vct_tanggal"><?php echo $vw_bill_ranap_detail_konsul_vct->tanggal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->kode_tindakan->Visible) { // kode_tindakan ?>
		<th><span id="elh_vw_bill_ranap_detail_konsul_vct_kode_tindakan" class="vw_bill_ranap_detail_konsul_vct_kode_tindakan"><?php echo $vw_bill_ranap_detail_konsul_vct->kode_tindakan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->kode_dokter->Visible) { // kode_dokter ?>
		<th><span id="elh_vw_bill_ranap_detail_konsul_vct_kode_dokter" class="vw_bill_ranap_detail_konsul_vct_kode_dokter"><?php echo $vw_bill_ranap_detail_konsul_vct->kode_dokter->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->tarif->Visible) { // tarif ?>
		<th><span id="elh_vw_bill_ranap_detail_konsul_vct_tarif" class="vw_bill_ranap_detail_konsul_vct_tarif"><?php echo $vw_bill_ranap_detail_konsul_vct->tarif->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->qty->Visible) { // qty ?>
		<th><span id="elh_vw_bill_ranap_detail_konsul_vct_qty" class="vw_bill_ranap_detail_konsul_vct_qty"><?php echo $vw_bill_ranap_detail_konsul_vct->qty->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->user->Visible) { // user ?>
		<th><span id="elh_vw_bill_ranap_detail_konsul_vct_user" class="vw_bill_ranap_detail_konsul_vct_user"><?php echo $vw_bill_ranap_detail_konsul_vct->user->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$vw_bill_ranap_detail_konsul_vct_delete->RecCnt = 0;
$i = 0;
while (!$vw_bill_ranap_detail_konsul_vct_delete->Recordset->EOF) {
	$vw_bill_ranap_detail_konsul_vct_delete->RecCnt++;
	$vw_bill_ranap_detail_konsul_vct_delete->RowCnt++;

	// Set row properties
	$vw_bill_ranap_detail_konsul_vct->ResetAttrs();
	$vw_bill_ranap_detail_konsul_vct->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$vw_bill_ranap_detail_konsul_vct_delete->LoadRowValues($vw_bill_ranap_detail_konsul_vct_delete->Recordset);

	// Render row
	$vw_bill_ranap_detail_konsul_vct_delete->RenderRow();
?>
	<tr<?php echo $vw_bill_ranap_detail_konsul_vct->RowAttributes() ?>>
<?php if ($vw_bill_ranap_detail_konsul_vct->tanggal->Visible) { // tanggal ?>
		<td<?php echo $vw_bill_ranap_detail_konsul_vct->tanggal->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_vct_delete->RowCnt ?>_vw_bill_ranap_detail_konsul_vct_tanggal" class="vw_bill_ranap_detail_konsul_vct_tanggal">
<span<?php echo $vw_bill_ranap_detail_konsul_vct->tanggal->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_vct->tanggal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->kode_tindakan->Visible) { // kode_tindakan ?>
		<td<?php echo $vw_bill_ranap_detail_konsul_vct->kode_tindakan->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_vct_delete->RowCnt ?>_vw_bill_ranap_detail_konsul_vct_kode_tindakan" class="vw_bill_ranap_detail_konsul_vct_kode_tindakan">
<span<?php echo $vw_bill_ranap_detail_konsul_vct->kode_tindakan->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_vct->kode_tindakan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->kode_dokter->Visible) { // kode_dokter ?>
		<td<?php echo $vw_bill_ranap_detail_konsul_vct->kode_dokter->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_vct_delete->RowCnt ?>_vw_bill_ranap_detail_konsul_vct_kode_dokter" class="vw_bill_ranap_detail_konsul_vct_kode_dokter">
<span<?php echo $vw_bill_ranap_detail_konsul_vct->kode_dokter->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_vct->kode_dokter->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->tarif->Visible) { // tarif ?>
		<td<?php echo $vw_bill_ranap_detail_konsul_vct->tarif->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_vct_delete->RowCnt ?>_vw_bill_ranap_detail_konsul_vct_tarif" class="vw_bill_ranap_detail_konsul_vct_tarif">
<span<?php echo $vw_bill_ranap_detail_konsul_vct->tarif->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_vct->tarif->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->qty->Visible) { // qty ?>
		<td<?php echo $vw_bill_ranap_detail_konsul_vct->qty->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_vct_delete->RowCnt ?>_vw_bill_ranap_detail_konsul_vct_qty" class="vw_bill_ranap_detail_konsul_vct_qty">
<span<?php echo $vw_bill_ranap_detail_konsul_vct->qty->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_vct->qty->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_bill_ranap_detail_konsul_vct->user->Visible) { // user ?>
		<td<?php echo $vw_bill_ranap_detail_konsul_vct->user->CellAttributes() ?>>
<span id="el<?php echo $vw_bill_ranap_detail_konsul_vct_delete->RowCnt ?>_vw_bill_ranap_detail_konsul_vct_user" class="vw_bill_ranap_detail_konsul_vct_user">
<span<?php echo $vw_bill_ranap_detail_konsul_vct->user->ViewAttributes() ?>>
<?php echo $vw_bill_ranap_detail_konsul_vct->user->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$vw_bill_ranap_detail_konsul_vct_delete->Recordset->MoveNext();
}
$vw_bill_ranap_detail_konsul_vct_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bill_ranap_detail_konsul_vct_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fvw_bill_ranap_detail_konsul_vctdelete.Init();
</script>
<?php
$vw_bill_ranap_detail_konsul_vct_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bill_ranap_detail_konsul_vct_delete->Page_Terminate();
?>
