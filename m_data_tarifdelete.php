<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_data_tarifinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_data_tarif_delete = NULL; // Initialize page object first

class cm_data_tarif_delete extends cm_data_tarif {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_data_tarif';

	// Page object name
	var $PageObjName = 'm_data_tarif_delete';

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

		// Table object (m_data_tarif)
		if (!isset($GLOBALS["m_data_tarif"]) || get_class($GLOBALS["m_data_tarif"]) == "cm_data_tarif") {
			$GLOBALS["m_data_tarif"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_data_tarif"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_data_tarif', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_data_tariflist.php"));
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
		$this->kode->SetVisibility();
		$this->nama_tindakan->SetVisibility();
		$this->kelompok_tindakan->SetVisibility();
		$this->sub_kelompok1->SetVisibility();
		$this->sub_kelompok2->SetVisibility();
		$this->kelas->SetVisibility();
		$this->tarif->SetVisibility();
		$this->bhp->SetVisibility();

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
		global $EW_EXPORT, $m_data_tarif;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_data_tarif);
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
			$this->Page_Terminate("m_data_tariflist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in m_data_tarif class, m_data_tarifinfo.php

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
				$this->Page_Terminate("m_data_tariflist.php"); // Return to list
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
		$this->kode->setDbValue($rs->fields('kode'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->sub_kelompok1->setDbValue($rs->fields('sub_kelompok1'));
		$this->sub_kelompok2->setDbValue($rs->fields('sub_kelompok2'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->bhp->setDbValue($rs->fields('bhp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->kode->DbValue = $row['kode'];
		$this->nama_tindakan->DbValue = $row['nama_tindakan'];
		$this->kelompok_tindakan->DbValue = $row['kelompok_tindakan'];
		$this->sub_kelompok1->DbValue = $row['sub_kelompok1'];
		$this->sub_kelompok2->DbValue = $row['sub_kelompok2'];
		$this->kelas->DbValue = $row['kelas'];
		$this->tarif->DbValue = $row['tarif'];
		$this->bhp->DbValue = $row['bhp'];
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
		// kode
		// nama_tindakan
		// kelompok_tindakan
		// sub_kelompok1
		// sub_kelompok2
		// kelas
		// tarif
		// bhp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kode
		$this->kode->ViewValue = $this->kode->CurrentValue;
		$this->kode->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// kelompok_tindakan
		if (strval($this->kelompok_tindakan->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->kelompok_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `kelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_kelompok_tindakan`";
		$sWhereWrk = "";
		$this->kelompok_tindakan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kelompok_tindakan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
			}
		} else {
			$this->kelompok_tindakan->ViewValue = NULL;
		}
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// sub_kelompok1
		if (strval($this->sub_kelompok1->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub_kelompok1->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `subkelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_sub_kelompok_1`";
		$sWhereWrk = "";
		$this->sub_kelompok1->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sub_kelompok1, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sub_kelompok1->ViewValue = $this->sub_kelompok1->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sub_kelompok1->ViewValue = $this->sub_kelompok1->CurrentValue;
			}
		} else {
			$this->sub_kelompok1->ViewValue = NULL;
		}
		$this->sub_kelompok1->ViewCustomAttributes = "";

		// sub_kelompok2
		if (strval($this->sub_kelompok2->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub_kelompok2->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `subkelompok2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_sub_kelompok_2`";
		$sWhereWrk = "";
		$this->sub_kelompok2->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sub_kelompok2, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sub_kelompok2->ViewValue = $this->sub_kelompok2->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sub_kelompok2->ViewValue = $this->sub_kelompok2->CurrentValue;
			}
		} else {
			$this->sub_kelompok2->ViewValue = NULL;
		}
		$this->sub_kelompok2->ViewCustomAttributes = "";

		// kelas
		if (strval($this->kelas->CurrentValue) <> "") {
			$this->kelas->ViewValue = $this->kelas->OptionCaption($this->kelas->CurrentValue);
		} else {
			$this->kelas->ViewValue = NULL;
		}
		$this->kelas->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// kode
			$this->kode->LinkCustomAttributes = "";
			$this->kode->HrefValue = "";
			$this->kode->TooltipValue = "";

			// nama_tindakan
			$this->nama_tindakan->LinkCustomAttributes = "";
			$this->nama_tindakan->HrefValue = "";
			$this->nama_tindakan->TooltipValue = "";

			// kelompok_tindakan
			$this->kelompok_tindakan->LinkCustomAttributes = "";
			$this->kelompok_tindakan->HrefValue = "";
			$this->kelompok_tindakan->TooltipValue = "";

			// sub_kelompok1
			$this->sub_kelompok1->LinkCustomAttributes = "";
			$this->sub_kelompok1->HrefValue = "";
			$this->sub_kelompok1->TooltipValue = "";

			// sub_kelompok2
			$this->sub_kelompok2->LinkCustomAttributes = "";
			$this->sub_kelompok2->HrefValue = "";
			$this->sub_kelompok2->TooltipValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";
			$this->kelas->TooltipValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";
			$this->tarif->TooltipValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";
			$this->bhp->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_data_tariflist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_data_tarif_delete)) $m_data_tarif_delete = new cm_data_tarif_delete();

// Page init
$m_data_tarif_delete->Page_Init();

// Page main
$m_data_tarif_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_data_tarif_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fm_data_tarifdelete = new ew_Form("fm_data_tarifdelete", "delete");

// Form_CustomValidate event
fm_data_tarifdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_data_tarifdelete.ValidateRequired = true;
<?php } else { ?>
fm_data_tarifdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_data_tarifdelete.Lists["x_kelompok_tindakan"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kelompok","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_tarif_kelompok_tindakan"};
fm_data_tarifdelete.Lists["x_sub_kelompok1"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subkelompok","","",""],"ParentFields":[],"ChildFields":["x_sub_kelompok2"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_tarif_sub_kelompok_1"};
fm_data_tarifdelete.Lists["x_sub_kelompok2"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subkelompok2","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_tarif_sub_kelompok_2"};
fm_data_tarifdelete.Lists["x_kelas"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fm_data_tarifdelete.Lists["x_kelas"].Options = <?php echo json_encode($m_data_tarif->kelas->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $m_data_tarif_delete->ShowPageHeader(); ?>
<?php
$m_data_tarif_delete->ShowMessage();
?>
<form name="fm_data_tarifdelete" id="fm_data_tarifdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_data_tarif_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_data_tarif_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_data_tarif">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($m_data_tarif_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_data_tarif->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($m_data_tarif->id->Visible) { // id ?>
		<th><span id="elh_m_data_tarif_id" class="m_data_tarif_id"><?php echo $m_data_tarif->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->kode->Visible) { // kode ?>
		<th><span id="elh_m_data_tarif_kode" class="m_data_tarif_kode"><?php echo $m_data_tarif->kode->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->nama_tindakan->Visible) { // nama_tindakan ?>
		<th><span id="elh_m_data_tarif_nama_tindakan" class="m_data_tarif_nama_tindakan"><?php echo $m_data_tarif->nama_tindakan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->kelompok_tindakan->Visible) { // kelompok_tindakan ?>
		<th><span id="elh_m_data_tarif_kelompok_tindakan" class="m_data_tarif_kelompok_tindakan"><?php echo $m_data_tarif->kelompok_tindakan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->sub_kelompok1->Visible) { // sub_kelompok1 ?>
		<th><span id="elh_m_data_tarif_sub_kelompok1" class="m_data_tarif_sub_kelompok1"><?php echo $m_data_tarif->sub_kelompok1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->sub_kelompok2->Visible) { // sub_kelompok2 ?>
		<th><span id="elh_m_data_tarif_sub_kelompok2" class="m_data_tarif_sub_kelompok2"><?php echo $m_data_tarif->sub_kelompok2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->kelas->Visible) { // kelas ?>
		<th><span id="elh_m_data_tarif_kelas" class="m_data_tarif_kelas"><?php echo $m_data_tarif->kelas->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->tarif->Visible) { // tarif ?>
		<th><span id="elh_m_data_tarif_tarif" class="m_data_tarif_tarif"><?php echo $m_data_tarif->tarif->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_data_tarif->bhp->Visible) { // bhp ?>
		<th><span id="elh_m_data_tarif_bhp" class="m_data_tarif_bhp"><?php echo $m_data_tarif->bhp->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$m_data_tarif_delete->RecCnt = 0;
$i = 0;
while (!$m_data_tarif_delete->Recordset->EOF) {
	$m_data_tarif_delete->RecCnt++;
	$m_data_tarif_delete->RowCnt++;

	// Set row properties
	$m_data_tarif->ResetAttrs();
	$m_data_tarif->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$m_data_tarif_delete->LoadRowValues($m_data_tarif_delete->Recordset);

	// Render row
	$m_data_tarif_delete->RenderRow();
?>
	<tr<?php echo $m_data_tarif->RowAttributes() ?>>
<?php if ($m_data_tarif->id->Visible) { // id ?>
		<td<?php echo $m_data_tarif->id->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_id" class="m_data_tarif_id">
<span<?php echo $m_data_tarif->id->ViewAttributes() ?>>
<?php echo $m_data_tarif->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->kode->Visible) { // kode ?>
		<td<?php echo $m_data_tarif->kode->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_kode" class="m_data_tarif_kode">
<span<?php echo $m_data_tarif->kode->ViewAttributes() ?>>
<?php echo $m_data_tarif->kode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->nama_tindakan->Visible) { // nama_tindakan ?>
		<td<?php echo $m_data_tarif->nama_tindakan->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_nama_tindakan" class="m_data_tarif_nama_tindakan">
<span<?php echo $m_data_tarif->nama_tindakan->ViewAttributes() ?>>
<?php echo $m_data_tarif->nama_tindakan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->kelompok_tindakan->Visible) { // kelompok_tindakan ?>
		<td<?php echo $m_data_tarif->kelompok_tindakan->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_kelompok_tindakan" class="m_data_tarif_kelompok_tindakan">
<span<?php echo $m_data_tarif->kelompok_tindakan->ViewAttributes() ?>>
<?php echo $m_data_tarif->kelompok_tindakan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->sub_kelompok1->Visible) { // sub_kelompok1 ?>
		<td<?php echo $m_data_tarif->sub_kelompok1->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_sub_kelompok1" class="m_data_tarif_sub_kelompok1">
<span<?php echo $m_data_tarif->sub_kelompok1->ViewAttributes() ?>>
<?php echo $m_data_tarif->sub_kelompok1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->sub_kelompok2->Visible) { // sub_kelompok2 ?>
		<td<?php echo $m_data_tarif->sub_kelompok2->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_sub_kelompok2" class="m_data_tarif_sub_kelompok2">
<span<?php echo $m_data_tarif->sub_kelompok2->ViewAttributes() ?>>
<?php echo $m_data_tarif->sub_kelompok2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->kelas->Visible) { // kelas ?>
		<td<?php echo $m_data_tarif->kelas->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_kelas" class="m_data_tarif_kelas">
<span<?php echo $m_data_tarif->kelas->ViewAttributes() ?>>
<?php echo $m_data_tarif->kelas->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->tarif->Visible) { // tarif ?>
		<td<?php echo $m_data_tarif->tarif->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_tarif" class="m_data_tarif_tarif">
<span<?php echo $m_data_tarif->tarif->ViewAttributes() ?>>
<?php echo $m_data_tarif->tarif->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_data_tarif->bhp->Visible) { // bhp ?>
		<td<?php echo $m_data_tarif->bhp->CellAttributes() ?>>
<span id="el<?php echo $m_data_tarif_delete->RowCnt ?>_m_data_tarif_bhp" class="m_data_tarif_bhp">
<span<?php echo $m_data_tarif->bhp->ViewAttributes() ?>>
<?php echo $m_data_tarif->bhp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$m_data_tarif_delete->Recordset->MoveNext();
}
$m_data_tarif_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_data_tarif_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fm_data_tarifdelete.Init();
</script>
<?php
$m_data_tarif_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_data_tarif_delete->Page_Terminate();
?>
