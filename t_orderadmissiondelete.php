<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_orderadmissioninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_orderadmission_delete = NULL; // Initialize page object first

class ct_orderadmission_delete extends ct_orderadmission {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_orderadmission';

	// Page object name
	var $PageObjName = 't_orderadmission_delete';

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

		// Table object (t_orderadmission)
		if (!isset($GLOBALS["t_orderadmission"]) || get_class($GLOBALS["t_orderadmission"]) == "ct_orderadmission") {
			$GLOBALS["t_orderadmission"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_orderadmission"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_orderadmission', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_orderadmissionlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->IDXORDER->SetVisibility();
		$this->IDXORDER->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->TGLORDER->SetVisibility();
		$this->NOMR->SetVisibility();
		$this->POLYPENGIRIM->SetVisibility();
		$this->DRPENGIRIM->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();

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
		global $EW_EXPORT, $t_orderadmission;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_orderadmission);
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
			$this->Page_Terminate("t_orderadmissionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_orderadmission class, t_orderadmissioninfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("t_orderadmissionlist.php"); // Return to list
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
		$this->IDXORDER->setDbValue($rs->fields('IDXORDER'));
		$this->TGLORDER->setDbValue($rs->fields('TGLORDER'));
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->POLYPENGIRIM->setDbValue($rs->fields('POLYPENGIRIM'));
		$this->DRPENGIRIM->setDbValue($rs->fields('DRPENGIRIM'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXORDER->DbValue = $row['IDXORDER'];
		$this->TGLORDER->DbValue = $row['TGLORDER'];
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->POLYPENGIRIM->DbValue = $row['POLYPENGIRIM'];
		$this->DRPENGIRIM->DbValue = $row['DRPENGIRIM'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->STATUS->DbValue = $row['STATUS'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXORDER
		// TGLORDER
		// IDXDAFTAR
		// NOMR
		// POLYPENGIRIM
		// DRPENGIRIM
		// KDCARABAYAR
		// KDRUJUK
		// STATUS

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXORDER
		$this->IDXORDER->ViewValue = $this->IDXORDER->CurrentValue;
		$this->IDXORDER->ViewCustomAttributes = "";

		// TGLORDER
		$this->TGLORDER->ViewValue = $this->TGLORDER->CurrentValue;
		$this->TGLORDER->ViewValue = ew_FormatDateTime($this->TGLORDER->ViewValue, 0);
		$this->TGLORDER->ViewCustomAttributes = "";

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// POLYPENGIRIM
		if (strval($this->POLYPENGIRIM->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->POLYPENGIRIM->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->POLYPENGIRIM->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->POLYPENGIRIM, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->POLYPENGIRIM->ViewValue = $this->POLYPENGIRIM->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->POLYPENGIRIM->ViewValue = $this->POLYPENGIRIM->CurrentValue;
			}
		} else {
			$this->POLYPENGIRIM->ViewValue = NULL;
		}
		$this->POLYPENGIRIM->ViewCustomAttributes = "";

		// DRPENGIRIM
		if (strval($this->DRPENGIRIM->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->DRPENGIRIM->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->DRPENGIRIM->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DRPENGIRIM, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->DRPENGIRIM->ViewValue = $this->DRPENGIRIM->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DRPENGIRIM->ViewValue = $this->DRPENGIRIM->CurrentValue;
			}
		} else {
			$this->DRPENGIRIM->ViewValue = NULL;
		}
		$this->DRPENGIRIM->ViewCustomAttributes = "";

		// KDCARABAYAR
		if (strval($this->KDCARABAYAR->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->KDCARABAYAR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
			}
		} else {
			$this->KDCARABAYAR->ViewValue = NULL;
		}
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// KDRUJUK
		if (strval($this->KDRUJUK->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDRUJUK->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->KDRUJUK->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
			}
		} else {
			$this->KDRUJUK->ViewValue = NULL;
		}
		$this->KDRUJUK->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

			// IDXORDER
			$this->IDXORDER->LinkCustomAttributes = "";
			$this->IDXORDER->HrefValue = "";
			$this->IDXORDER->TooltipValue = "";

			// TGLORDER
			$this->TGLORDER->LinkCustomAttributes = "";
			$this->TGLORDER->HrefValue = "";
			$this->TGLORDER->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// POLYPENGIRIM
			$this->POLYPENGIRIM->LinkCustomAttributes = "";
			$this->POLYPENGIRIM->HrefValue = "";
			$this->POLYPENGIRIM->TooltipValue = "";

			// DRPENGIRIM
			$this->DRPENGIRIM->LinkCustomAttributes = "";
			$this->DRPENGIRIM->HrefValue = "";
			$this->DRPENGIRIM->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";
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
				$sThisKey .= $row['IDXORDER'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_orderadmissionlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_orderadmission_delete)) $t_orderadmission_delete = new ct_orderadmission_delete();

// Page init
$t_orderadmission_delete->Page_Init();

// Page main
$t_orderadmission_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_orderadmission_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_orderadmissiondelete = new ew_Form("ft_orderadmissiondelete", "delete");

// Form_CustomValidate event
ft_orderadmissiondelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_orderadmissiondelete.ValidateRequired = true;
<?php } else { ?>
ft_orderadmissiondelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_orderadmissiondelete.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","x_ALAMAT",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_orderadmissiondelete.Lists["x_POLYPENGIRIM"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_orderadmissiondelete.Lists["x_DRPENGIRIM"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_orderadmissiondelete.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t_orderadmission_delete->ShowPageHeader(); ?>
<?php
$t_orderadmission_delete->ShowMessage();
?>
<form name="ft_orderadmissiondelete" id="ft_orderadmissiondelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_orderadmission_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_orderadmission_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_orderadmission">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_orderadmission_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_orderadmission->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_orderadmission->IDXORDER->Visible) { // IDXORDER ?>
		<th><span id="elh_t_orderadmission_IDXORDER" class="t_orderadmission_IDXORDER"><?php echo $t_orderadmission->IDXORDER->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_orderadmission->TGLORDER->Visible) { // TGLORDER ?>
		<th><span id="elh_t_orderadmission_TGLORDER" class="t_orderadmission_TGLORDER"><?php echo $t_orderadmission->TGLORDER->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_orderadmission->NOMR->Visible) { // NOMR ?>
		<th><span id="elh_t_orderadmission_NOMR" class="t_orderadmission_NOMR"><?php echo $t_orderadmission->NOMR->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_orderadmission->POLYPENGIRIM->Visible) { // POLYPENGIRIM ?>
		<th><span id="elh_t_orderadmission_POLYPENGIRIM" class="t_orderadmission_POLYPENGIRIM"><?php echo $t_orderadmission->POLYPENGIRIM->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_orderadmission->DRPENGIRIM->Visible) { // DRPENGIRIM ?>
		<th><span id="elh_t_orderadmission_DRPENGIRIM" class="t_orderadmission_DRPENGIRIM"><?php echo $t_orderadmission->DRPENGIRIM->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_orderadmission->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<th><span id="elh_t_orderadmission_KDCARABAYAR" class="t_orderadmission_KDCARABAYAR"><?php echo $t_orderadmission->KDCARABAYAR->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_orderadmission_delete->RecCnt = 0;
$i = 0;
while (!$t_orderadmission_delete->Recordset->EOF) {
	$t_orderadmission_delete->RecCnt++;
	$t_orderadmission_delete->RowCnt++;

	// Set row properties
	$t_orderadmission->ResetAttrs();
	$t_orderadmission->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_orderadmission_delete->LoadRowValues($t_orderadmission_delete->Recordset);

	// Render row
	$t_orderadmission_delete->RenderRow();
?>
	<tr<?php echo $t_orderadmission->RowAttributes() ?>>
<?php if ($t_orderadmission->IDXORDER->Visible) { // IDXORDER ?>
		<td<?php echo $t_orderadmission->IDXORDER->CellAttributes() ?>>
<div id="orig<?php echo $t_orderadmission_delete->RowCnt ?>_t_orderadmission_IDXORDER" class="hide">
<span id="el<?php echo $t_orderadmission_delete->RowCnt ?>_t_orderadmission_IDXORDER" class="t_orderadmission_IDXORDER">
<span<?php echo $t_orderadmission->IDXORDER->ViewAttributes() ?>>
<?php echo $t_orderadmission->IDXORDER->ListViewValue() ?></span>
</span>
</div>
<div class="btn-group">
	<button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>   Menu</button>
		<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul style="background:#605CA8" class="dropdown-menu" role="menu" >
			<?php
				$r = Security()->CurrentUserLevelID();
				if($r==4)
			{ ?>
				<li class="divider"></li>
				<li><a style="color:#ffffff" target="_self" href="t_orderadmissionedit.php?IDXORDER=<?php echo urlencode(CurrentPage()->IDXORDER->CurrentValue)?>&IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>-  </b><b> Proses Permohonan Rawan Inap</b></a></li>
				<li class="divider"></li>
			<?php
				}else {
				?>
				<li class="divider"></li>
				<li><a style="color:#ffffff" target="_self" href="t_orderadmissionedit.php?IDXORDER=<?php echo urlencode(CurrentPage()->IDXORDER->CurrentValue)?>&IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>"><span class="glyphicon glyphicon-print" aria-hidden="true"></span><b>-  </b><b> Proses Permohonan Rawan Inap</b></a></li>
				<li class="divider"></li>
			<?php
				}
			?>
		</ul>
</div>
</td>
<?php } ?>
<?php if ($t_orderadmission->TGLORDER->Visible) { // TGLORDER ?>
		<td<?php echo $t_orderadmission->TGLORDER->CellAttributes() ?>>
<span id="el<?php echo $t_orderadmission_delete->RowCnt ?>_t_orderadmission_TGLORDER" class="t_orderadmission_TGLORDER">
<span<?php echo $t_orderadmission->TGLORDER->ViewAttributes() ?>>
<?php echo $t_orderadmission->TGLORDER->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_orderadmission->NOMR->Visible) { // NOMR ?>
		<td<?php echo $t_orderadmission->NOMR->CellAttributes() ?>>
<span id="el<?php echo $t_orderadmission_delete->RowCnt ?>_t_orderadmission_NOMR" class="t_orderadmission_NOMR">
<span<?php echo $t_orderadmission->NOMR->ViewAttributes() ?>>
<?php echo $t_orderadmission->NOMR->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_orderadmission->POLYPENGIRIM->Visible) { // POLYPENGIRIM ?>
		<td<?php echo $t_orderadmission->POLYPENGIRIM->CellAttributes() ?>>
<span id="el<?php echo $t_orderadmission_delete->RowCnt ?>_t_orderadmission_POLYPENGIRIM" class="t_orderadmission_POLYPENGIRIM">
<span<?php echo $t_orderadmission->POLYPENGIRIM->ViewAttributes() ?>>
<?php echo $t_orderadmission->POLYPENGIRIM->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_orderadmission->DRPENGIRIM->Visible) { // DRPENGIRIM ?>
		<td<?php echo $t_orderadmission->DRPENGIRIM->CellAttributes() ?>>
<span id="el<?php echo $t_orderadmission_delete->RowCnt ?>_t_orderadmission_DRPENGIRIM" class="t_orderadmission_DRPENGIRIM">
<span<?php echo $t_orderadmission->DRPENGIRIM->ViewAttributes() ?>>
<?php echo $t_orderadmission->DRPENGIRIM->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_orderadmission->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
		<td<?php echo $t_orderadmission->KDCARABAYAR->CellAttributes() ?>>
<span id="el<?php echo $t_orderadmission_delete->RowCnt ?>_t_orderadmission_KDCARABAYAR" class="t_orderadmission_KDCARABAYAR">
<span<?php echo $t_orderadmission->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $t_orderadmission->KDCARABAYAR->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_orderadmission_delete->Recordset->MoveNext();
}
$t_orderadmission_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_orderadmission_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_orderadmissiondelete.Init();
</script>
<?php
$t_orderadmission_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_orderadmission_delete->Page_Terminate();
?>
