<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_ruanginfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_ruang_delete = NULL; // Initialize page object first

class cm_ruang_delete extends cm_ruang {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_ruang';

	// Page object name
	var $PageObjName = 'm_ruang_delete';

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

		// Table object (m_ruang)
		if (!isset($GLOBALS["m_ruang"]) || get_class($GLOBALS["m_ruang"]) == "cm_ruang") {
			$GLOBALS["m_ruang"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_ruang"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_ruang', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_ruanglist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->no->SetVisibility();
		$this->no->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nama->SetVisibility();
		$this->kelas->SetVisibility();
		$this->ruang->SetVisibility();
		$this->jumlah_tt->SetVisibility();

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
		global $EW_EXPORT, $m_ruang;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_ruang);
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
			$this->Page_Terminate("m_ruanglist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in m_ruang class, m_ruanginfo.php

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
				$this->Page_Terminate("m_ruanglist.php"); // Return to list
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
		$this->no->setDbValue($rs->fields('no'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->ruang->setDbValue($rs->fields('ruang'));
		$this->jumlah_tt->setDbValue($rs->fields('jumlah_tt'));
		$this->ket_ruang->setDbValue($rs->fields('ket_ruang'));
		$this->fasilitas->setDbValue($rs->fields('fasilitas'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->kepala_ruangan->setDbValue($rs->fields('kepala_ruangan'));
		$this->nip_kepala_ruangan->setDbValue($rs->fields('nip_kepala_ruangan'));
		$this->group_id->setDbValue($rs->fields('group_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->no->DbValue = $row['no'];
		$this->nama->DbValue = $row['nama'];
		$this->kelas->DbValue = $row['kelas'];
		$this->ruang->DbValue = $row['ruang'];
		$this->jumlah_tt->DbValue = $row['jumlah_tt'];
		$this->ket_ruang->DbValue = $row['ket_ruang'];
		$this->fasilitas->DbValue = $row['fasilitas'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->kepala_ruangan->DbValue = $row['kepala_ruangan'];
		$this->nip_kepala_ruangan->DbValue = $row['nip_kepala_ruangan'];
		$this->group_id->DbValue = $row['group_id'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// no
		// nama
		// kelas
		// ruang
		// jumlah_tt
		// ket_ruang
		// fasilitas
		// keterangan
		// kepala_ruangan
		// nip_kepala_ruangan
		// group_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// no
		$this->no->ViewValue = $this->no->CurrentValue;
		$this->no->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// ruang
		$this->ruang->ViewValue = $this->ruang->CurrentValue;
		$this->ruang->ViewCustomAttributes = "";

		// jumlah_tt
		$this->jumlah_tt->ViewValue = $this->jumlah_tt->CurrentValue;
		$this->jumlah_tt->ViewCustomAttributes = "";

		// ket_ruang
		$this->ket_ruang->ViewValue = $this->ket_ruang->CurrentValue;
		$this->ket_ruang->ViewCustomAttributes = "";

		// kepala_ruangan
		$this->kepala_ruangan->ViewValue = $this->kepala_ruangan->CurrentValue;
		$this->kepala_ruangan->ViewCustomAttributes = "";

		// nip_kepala_ruangan
		$this->nip_kepala_ruangan->ViewValue = $this->nip_kepala_ruangan->CurrentValue;
		$this->nip_kepala_ruangan->ViewCustomAttributes = "";

		// group_id
		$this->group_id->ViewValue = $this->group_id->CurrentValue;
		$this->group_id->ViewCustomAttributes = "";

			// no
			$this->no->LinkCustomAttributes = "";
			$this->no->HrefValue = "";
			$this->no->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";
			$this->kelas->TooltipValue = "";

			// ruang
			$this->ruang->LinkCustomAttributes = "";
			$this->ruang->HrefValue = "";
			$this->ruang->TooltipValue = "";

			// jumlah_tt
			$this->jumlah_tt->LinkCustomAttributes = "";
			$this->jumlah_tt->HrefValue = "";
			$this->jumlah_tt->TooltipValue = "";
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
				$sThisKey .= $row['no'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_ruanglist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_ruang_delete)) $m_ruang_delete = new cm_ruang_delete();

// Page init
$m_ruang_delete->Page_Init();

// Page main
$m_ruang_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_ruang_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fm_ruangdelete = new ew_Form("fm_ruangdelete", "delete");

// Form_CustomValidate event
fm_ruangdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_ruangdelete.ValidateRequired = true;
<?php } else { ?>
fm_ruangdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $m_ruang_delete->ShowPageHeader(); ?>
<?php
$m_ruang_delete->ShowMessage();
?>
<form name="fm_ruangdelete" id="fm_ruangdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_ruang_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_ruang_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_ruang">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($m_ruang_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_ruang->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($m_ruang->no->Visible) { // no ?>
		<th><span id="elh_m_ruang_no" class="m_ruang_no"><?php echo $m_ruang->no->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_ruang->nama->Visible) { // nama ?>
		<th><span id="elh_m_ruang_nama" class="m_ruang_nama"><?php echo $m_ruang->nama->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_ruang->kelas->Visible) { // kelas ?>
		<th><span id="elh_m_ruang_kelas" class="m_ruang_kelas"><?php echo $m_ruang->kelas->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_ruang->ruang->Visible) { // ruang ?>
		<th><span id="elh_m_ruang_ruang" class="m_ruang_ruang"><?php echo $m_ruang->ruang->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_ruang->jumlah_tt->Visible) { // jumlah_tt ?>
		<th><span id="elh_m_ruang_jumlah_tt" class="m_ruang_jumlah_tt"><?php echo $m_ruang->jumlah_tt->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$m_ruang_delete->RecCnt = 0;
$i = 0;
while (!$m_ruang_delete->Recordset->EOF) {
	$m_ruang_delete->RecCnt++;
	$m_ruang_delete->RowCnt++;

	// Set row properties
	$m_ruang->ResetAttrs();
	$m_ruang->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$m_ruang_delete->LoadRowValues($m_ruang_delete->Recordset);

	// Render row
	$m_ruang_delete->RenderRow();
?>
	<tr<?php echo $m_ruang->RowAttributes() ?>>
<?php if ($m_ruang->no->Visible) { // no ?>
		<td<?php echo $m_ruang->no->CellAttributes() ?>>
<span id="el<?php echo $m_ruang_delete->RowCnt ?>_m_ruang_no" class="m_ruang_no">
<span<?php echo $m_ruang->no->ViewAttributes() ?>>
<?php echo $m_ruang->no->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_ruang->nama->Visible) { // nama ?>
		<td<?php echo $m_ruang->nama->CellAttributes() ?>>
<span id="el<?php echo $m_ruang_delete->RowCnt ?>_m_ruang_nama" class="m_ruang_nama">
<span<?php echo $m_ruang->nama->ViewAttributes() ?>>
<?php echo $m_ruang->nama->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_ruang->kelas->Visible) { // kelas ?>
		<td<?php echo $m_ruang->kelas->CellAttributes() ?>>
<span id="el<?php echo $m_ruang_delete->RowCnt ?>_m_ruang_kelas" class="m_ruang_kelas">
<span<?php echo $m_ruang->kelas->ViewAttributes() ?>>
<?php echo $m_ruang->kelas->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_ruang->ruang->Visible) { // ruang ?>
		<td<?php echo $m_ruang->ruang->CellAttributes() ?>>
<span id="el<?php echo $m_ruang_delete->RowCnt ?>_m_ruang_ruang" class="m_ruang_ruang">
<span<?php echo $m_ruang->ruang->ViewAttributes() ?>>
<?php echo $m_ruang->ruang->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_ruang->jumlah_tt->Visible) { // jumlah_tt ?>
		<td<?php echo $m_ruang->jumlah_tt->CellAttributes() ?>>
<div id="orig<?php echo $m_ruang_delete->RowCnt ?>_m_ruang_jumlah_tt" class="hide">
<span id="el<?php echo $m_ruang_delete->RowCnt ?>_m_ruang_jumlah_tt" class="m_ruang_jumlah_tt">
<span<?php echo $m_ruang->jumlah_tt->ViewAttributes() ?>>
<?php echo $m_ruang->jumlah_tt->ListViewValue() ?></span>
</span>
</div>
<div align="left">
	  <?php

        //include '../include/connect.php';
         include 'phpcon/koneksi.php';
	  	$idx=CurrentPage()->no->CurrentValue;
		$namarg=CurrentPage()->nama->CurrentValue;
		$detail="SELECT idxruang,no_tt,id FROM m_detail_tempat_tidur WHERE idxruang='".$idx."'";

		//$detail="SELECT id, ruang_id, bed  FROM m_ruang_detail WHERE ruang_id='".$idx."'";
		//print '<pre>'.$detail.'</pre>';

	  	$result=mysqli_query($conn,$detail);
	  	while($brs=@mysqli_fetch_array($result)){
		 $seleksi="SELECT id,no_tt,KETERANGAN FROM m_detail_tempat_tidur WHERE idxruang=".$brs['idxruang']." and id =".$brs['id']." ";

		 //$seleksi="SELECT id,KETERANGAN FROM m_ruang_detail WHERE ruang_id=".$brs['ruang_id']." and id =".$brs['id']." ";
		 //print $seleksi;
		 //print '<pre>'.$seleksi.'</pre>';

		 $hasilseleksi=mysqli_query($conn,$seleksi);
		 $rr = @mysqli_fetch_array($hasilseleksi);
		 $tt =  $rr["KETERANGAN"];
		 if ($tt != null){
				echo "<input class='btn btn-danger btn-lg' type=button name=button id=".$brs['no_tt']." value='Ruang.".$rr['no_tt']."-".$rr["KETERANGAN"]."' disabled><br/>";
		 }else{	
		 		echo "<input class='btn btn-success btn-lg'    type=button name=button id=".$brs['no_tt']." value='R.".$brs['no_tt']."- Kosong';><br/>";
		}
	}
	  ?>
</div>
</td>
<?php } ?>
	</tr>
<?php
	$m_ruang_delete->Recordset->MoveNext();
}
$m_ruang_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_ruang_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fm_ruangdelete.Init();
</script>
<?php
$m_ruang_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_ruang_delete->Page_Terminate();
?>
