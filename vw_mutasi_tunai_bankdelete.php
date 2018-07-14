<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_mutasi_tunai_bankinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_mutasi_tunai_bank_delete = NULL; // Initialize page object first

class cvw_mutasi_tunai_bank_delete extends cvw_mutasi_tunai_bank {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_mutasi_tunai_bank';

	// Page object name
	var $PageObjName = 'vw_mutasi_tunai_bank_delete';

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

		// Table object (vw_mutasi_tunai_bank)
		if (!isset($GLOBALS["vw_mutasi_tunai_bank"]) || get_class($GLOBALS["vw_mutasi_tunai_bank"]) == "cvw_mutasi_tunai_bank") {
			$GLOBALS["vw_mutasi_tunai_bank"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_mutasi_tunai_bank"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_mutasi_tunai_bank', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_mutasi_tunai_banklist.php"));
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
		$this->jenis_mutasi->SetVisibility();
		$this->no_bukti->SetVisibility();
		$this->tgl_bukti->SetVisibility();
		$this->uraian->SetVisibility();
		$this->jumlah->SetVisibility();

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
		global $EW_EXPORT, $vw_mutasi_tunai_bank;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_mutasi_tunai_bank);
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
			$this->Page_Terminate("vw_mutasi_tunai_banklist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in vw_mutasi_tunai_bank class, vw_mutasi_tunai_bankinfo.php

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
				$this->Page_Terminate("vw_mutasi_tunai_banklist.php"); // Return to list
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
		$this->jenis_mutasi->setDbValue($rs->fields('jenis_mutasi'));
		$this->no_bukti->setDbValue($rs->fields('no_bukti'));
		$this->tgl_bukti->setDbValue($rs->fields('tgl_bukti'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->jumlah->setDbValue($rs->fields('jumlah'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->jenis_mutasi->DbValue = $row['jenis_mutasi'];
		$this->no_bukti->DbValue = $row['no_bukti'];
		$this->tgl_bukti->DbValue = $row['tgl_bukti'];
		$this->uraian->DbValue = $row['uraian'];
		$this->jumlah->DbValue = $row['jumlah'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->jumlah->FormValue == $this->jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah->CurrentValue)))
			$this->jumlah->CurrentValue = ew_StrToFloat($this->jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// jenis_mutasi
		// no_bukti
		// tgl_bukti
		// uraian
		// jumlah

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// jenis_mutasi
		if (strval($this->jenis_mutasi->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->jenis_mutasi->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `jenis_mutasi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_mutasi`";
		$sWhereWrk = "";
		$this->jenis_mutasi->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->jenis_mutasi, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->jenis_mutasi->ViewValue = $this->jenis_mutasi->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->jenis_mutasi->ViewValue = $this->jenis_mutasi->CurrentValue;
			}
		} else {
			$this->jenis_mutasi->ViewValue = NULL;
		}
		$this->jenis_mutasi->ViewCustomAttributes = "";

		// no_bukti
		$this->no_bukti->ViewValue = $this->no_bukti->CurrentValue;
		$this->no_bukti->ViewCustomAttributes = "";

		// tgl_bukti
		$this->tgl_bukti->ViewValue = $this->tgl_bukti->CurrentValue;
		$this->tgl_bukti->ViewValue = ew_FormatDateTime($this->tgl_bukti->ViewValue, 7);
		$this->tgl_bukti->ViewCustomAttributes = "";

		// uraian
		$this->uraian->ViewValue = $this->uraian->CurrentValue;
		$this->uraian->ViewCustomAttributes = "";

		// jumlah
		$this->jumlah->ViewValue = $this->jumlah->CurrentValue;
		$this->jumlah->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// jenis_mutasi
			$this->jenis_mutasi->LinkCustomAttributes = "";
			$this->jenis_mutasi->HrefValue = "";
			$this->jenis_mutasi->TooltipValue = "";

			// no_bukti
			$this->no_bukti->LinkCustomAttributes = "";
			$this->no_bukti->HrefValue = "";
			$this->no_bukti->TooltipValue = "";

			// tgl_bukti
			$this->tgl_bukti->LinkCustomAttributes = "";
			$this->tgl_bukti->HrefValue = "";
			$this->tgl_bukti->TooltipValue = "";

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";
			$this->uraian->TooltipValue = "";

			// jumlah
			$this->jumlah->LinkCustomAttributes = "";
			$this->jumlah->HrefValue = "";
			$this->jumlah->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_mutasi_tunai_banklist.php"), "", $this->TableVar, TRUE);
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
if (!isset($vw_mutasi_tunai_bank_delete)) $vw_mutasi_tunai_bank_delete = new cvw_mutasi_tunai_bank_delete();

// Page init
$vw_mutasi_tunai_bank_delete->Page_Init();

// Page main
$vw_mutasi_tunai_bank_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_mutasi_tunai_bank_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fvw_mutasi_tunai_bankdelete = new ew_Form("fvw_mutasi_tunai_bankdelete", "delete");

// Form_CustomValidate event
fvw_mutasi_tunai_bankdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_mutasi_tunai_bankdelete.ValidateRequired = true;
<?php } else { ?>
fvw_mutasi_tunai_bankdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_mutasi_tunai_bankdelete.Lists["x_jenis_mutasi"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_mutasi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_mutasi"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $vw_mutasi_tunai_bank_delete->ShowPageHeader(); ?>
<?php
$vw_mutasi_tunai_bank_delete->ShowMessage();
?>
<form name="fvw_mutasi_tunai_bankdelete" id="fvw_mutasi_tunai_bankdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_mutasi_tunai_bank_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_mutasi_tunai_bank_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_mutasi_tunai_bank">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($vw_mutasi_tunai_bank_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $vw_mutasi_tunai_bank->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($vw_mutasi_tunai_bank->id->Visible) { // id ?>
		<th><span id="elh_vw_mutasi_tunai_bank_id" class="vw_mutasi_tunai_bank_id"><?php echo $vw_mutasi_tunai_bank->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->jenis_mutasi->Visible) { // jenis_mutasi ?>
		<th><span id="elh_vw_mutasi_tunai_bank_jenis_mutasi" class="vw_mutasi_tunai_bank_jenis_mutasi"><?php echo $vw_mutasi_tunai_bank->jenis_mutasi->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->no_bukti->Visible) { // no_bukti ?>
		<th><span id="elh_vw_mutasi_tunai_bank_no_bukti" class="vw_mutasi_tunai_bank_no_bukti"><?php echo $vw_mutasi_tunai_bank->no_bukti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->tgl_bukti->Visible) { // tgl_bukti ?>
		<th><span id="elh_vw_mutasi_tunai_bank_tgl_bukti" class="vw_mutasi_tunai_bank_tgl_bukti"><?php echo $vw_mutasi_tunai_bank->tgl_bukti->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->uraian->Visible) { // uraian ?>
		<th><span id="elh_vw_mutasi_tunai_bank_uraian" class="vw_mutasi_tunai_bank_uraian"><?php echo $vw_mutasi_tunai_bank->uraian->FldCaption() ?></span></th>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->jumlah->Visible) { // jumlah ?>
		<th><span id="elh_vw_mutasi_tunai_bank_jumlah" class="vw_mutasi_tunai_bank_jumlah"><?php echo $vw_mutasi_tunai_bank->jumlah->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$vw_mutasi_tunai_bank_delete->RecCnt = 0;
$i = 0;
while (!$vw_mutasi_tunai_bank_delete->Recordset->EOF) {
	$vw_mutasi_tunai_bank_delete->RecCnt++;
	$vw_mutasi_tunai_bank_delete->RowCnt++;

	// Set row properties
	$vw_mutasi_tunai_bank->ResetAttrs();
	$vw_mutasi_tunai_bank->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$vw_mutasi_tunai_bank_delete->LoadRowValues($vw_mutasi_tunai_bank_delete->Recordset);

	// Render row
	$vw_mutasi_tunai_bank_delete->RenderRow();
?>
	<tr<?php echo $vw_mutasi_tunai_bank->RowAttributes() ?>>
<?php if ($vw_mutasi_tunai_bank->id->Visible) { // id ?>
		<td<?php echo $vw_mutasi_tunai_bank->id->CellAttributes() ?>>
<span id="el<?php echo $vw_mutasi_tunai_bank_delete->RowCnt ?>_vw_mutasi_tunai_bank_id" class="vw_mutasi_tunai_bank_id">
<span<?php echo $vw_mutasi_tunai_bank->id->ViewAttributes() ?>>
<?php echo $vw_mutasi_tunai_bank->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->jenis_mutasi->Visible) { // jenis_mutasi ?>
		<td<?php echo $vw_mutasi_tunai_bank->jenis_mutasi->CellAttributes() ?>>
<span id="el<?php echo $vw_mutasi_tunai_bank_delete->RowCnt ?>_vw_mutasi_tunai_bank_jenis_mutasi" class="vw_mutasi_tunai_bank_jenis_mutasi">
<span<?php echo $vw_mutasi_tunai_bank->jenis_mutasi->ViewAttributes() ?>>
<?php echo $vw_mutasi_tunai_bank->jenis_mutasi->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->no_bukti->Visible) { // no_bukti ?>
		<td<?php echo $vw_mutasi_tunai_bank->no_bukti->CellAttributes() ?>>
<span id="el<?php echo $vw_mutasi_tunai_bank_delete->RowCnt ?>_vw_mutasi_tunai_bank_no_bukti" class="vw_mutasi_tunai_bank_no_bukti">
<span<?php echo $vw_mutasi_tunai_bank->no_bukti->ViewAttributes() ?>>
<?php echo $vw_mutasi_tunai_bank->no_bukti->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->tgl_bukti->Visible) { // tgl_bukti ?>
		<td<?php echo $vw_mutasi_tunai_bank->tgl_bukti->CellAttributes() ?>>
<span id="el<?php echo $vw_mutasi_tunai_bank_delete->RowCnt ?>_vw_mutasi_tunai_bank_tgl_bukti" class="vw_mutasi_tunai_bank_tgl_bukti">
<span<?php echo $vw_mutasi_tunai_bank->tgl_bukti->ViewAttributes() ?>>
<?php echo $vw_mutasi_tunai_bank->tgl_bukti->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->uraian->Visible) { // uraian ?>
		<td<?php echo $vw_mutasi_tunai_bank->uraian->CellAttributes() ?>>
<span id="el<?php echo $vw_mutasi_tunai_bank_delete->RowCnt ?>_vw_mutasi_tunai_bank_uraian" class="vw_mutasi_tunai_bank_uraian">
<span<?php echo $vw_mutasi_tunai_bank->uraian->ViewAttributes() ?>>
<?php echo $vw_mutasi_tunai_bank->uraian->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($vw_mutasi_tunai_bank->jumlah->Visible) { // jumlah ?>
		<td<?php echo $vw_mutasi_tunai_bank->jumlah->CellAttributes() ?>>
<span id="el<?php echo $vw_mutasi_tunai_bank_delete->RowCnt ?>_vw_mutasi_tunai_bank_jumlah" class="vw_mutasi_tunai_bank_jumlah">
<span<?php echo $vw_mutasi_tunai_bank->jumlah->ViewAttributes() ?>>
<?php echo $vw_mutasi_tunai_bank->jumlah->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$vw_mutasi_tunai_bank_delete->Recordset->MoveNext();
}
$vw_mutasi_tunai_bank_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_mutasi_tunai_bank_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fvw_mutasi_tunai_bankdelete.Init();
</script>
<?php
$vw_mutasi_tunai_bank_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_mutasi_tunai_bank_delete->Page_Terminate();
?>
