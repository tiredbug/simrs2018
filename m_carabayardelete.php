<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_carabayarinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_carabayar_delete = NULL; // Initialize page object first

class cm_carabayar_delete extends cm_carabayar {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_carabayar';

	// Page object name
	var $PageObjName = 'm_carabayar_delete';

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

		// Table object (m_carabayar)
		if (!isset($GLOBALS["m_carabayar"]) || get_class($GLOBALS["m_carabayar"]) == "cm_carabayar") {
			$GLOBALS["m_carabayar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_carabayar"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_carabayar', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_carabayarlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->KODE->SetVisibility();
		$this->NAMA->SetVisibility();
		$this->ORDERS->SetVisibility();
		$this->JMKS->SetVisibility();
		$this->payor_id->SetVisibility();
		$this->payor_cn->SetVisibility();

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
		global $EW_EXPORT, $m_carabayar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_carabayar);
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
			$this->Page_Terminate("m_carabayarlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in m_carabayar class, m_carabayarinfo.php

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
				$this->Page_Terminate("m_carabayarlist.php"); // Return to list
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
		$this->KODE->setDbValue($rs->fields('KODE'));
		$this->NAMA->setDbValue($rs->fields('NAMA'));
		$this->ORDERS->setDbValue($rs->fields('ORDERS'));
		$this->JMKS->setDbValue($rs->fields('JMKS'));
		$this->payor_id->setDbValue($rs->fields('payor_id'));
		$this->payor_cn->setDbValue($rs->fields('payor_cn'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->KODE->DbValue = $row['KODE'];
		$this->NAMA->DbValue = $row['NAMA'];
		$this->ORDERS->DbValue = $row['ORDERS'];
		$this->JMKS->DbValue = $row['JMKS'];
		$this->payor_id->DbValue = $row['payor_id'];
		$this->payor_cn->DbValue = $row['payor_cn'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// KODE
		// NAMA
		// ORDERS
		// JMKS
		// payor_id
		// payor_cn

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// KODE
		$this->KODE->ViewValue = $this->KODE->CurrentValue;
		$this->KODE->ViewCustomAttributes = "";

		// NAMA
		$this->NAMA->ViewValue = $this->NAMA->CurrentValue;
		$this->NAMA->ViewCustomAttributes = "";

		// ORDERS
		$this->ORDERS->ViewValue = $this->ORDERS->CurrentValue;
		$this->ORDERS->ViewCustomAttributes = "";

		// JMKS
		if (ew_ConvertToBool($this->JMKS->CurrentValue)) {
			$this->JMKS->ViewValue = $this->JMKS->FldTagCaption(2) <> "" ? $this->JMKS->FldTagCaption(2) : "1";
		} else {
			$this->JMKS->ViewValue = $this->JMKS->FldTagCaption(1) <> "" ? $this->JMKS->FldTagCaption(1) : "0";
		}
		$this->JMKS->ViewCustomAttributes = "";

		// payor_id
		$this->payor_id->ViewValue = $this->payor_id->CurrentValue;
		$this->payor_id->ViewCustomAttributes = "";

		// payor_cn
		$this->payor_cn->ViewValue = $this->payor_cn->CurrentValue;
		$this->payor_cn->ViewCustomAttributes = "";

			// KODE
			$this->KODE->LinkCustomAttributes = "";
			$this->KODE->HrefValue = "";
			$this->KODE->TooltipValue = "";

			// NAMA
			$this->NAMA->LinkCustomAttributes = "";
			$this->NAMA->HrefValue = "";
			$this->NAMA->TooltipValue = "";

			// ORDERS
			$this->ORDERS->LinkCustomAttributes = "";
			$this->ORDERS->HrefValue = "";
			$this->ORDERS->TooltipValue = "";

			// JMKS
			$this->JMKS->LinkCustomAttributes = "";
			$this->JMKS->HrefValue = "";
			$this->JMKS->TooltipValue = "";

			// payor_id
			$this->payor_id->LinkCustomAttributes = "";
			$this->payor_id->HrefValue = "";
			$this->payor_id->TooltipValue = "";

			// payor_cn
			$this->payor_cn->LinkCustomAttributes = "";
			$this->payor_cn->HrefValue = "";
			$this->payor_cn->TooltipValue = "";
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
				$sThisKey .= $row['KODE'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_carabayarlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_carabayar_delete)) $m_carabayar_delete = new cm_carabayar_delete();

// Page init
$m_carabayar_delete->Page_Init();

// Page main
$m_carabayar_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_carabayar_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fm_carabayardelete = new ew_Form("fm_carabayardelete", "delete");

// Form_CustomValidate event
fm_carabayardelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_carabayardelete.ValidateRequired = true;
<?php } else { ?>
fm_carabayardelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_carabayardelete.Lists["x_JMKS[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fm_carabayardelete.Lists["x_JMKS[]"].Options = <?php echo json_encode($m_carabayar->JMKS->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $m_carabayar_delete->ShowPageHeader(); ?>
<?php
$m_carabayar_delete->ShowMessage();
?>
<form name="fm_carabayardelete" id="fm_carabayardelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_carabayar_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_carabayar_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_carabayar">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($m_carabayar_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_carabayar->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($m_carabayar->KODE->Visible) { // KODE ?>
		<th><span id="elh_m_carabayar_KODE" class="m_carabayar_KODE"><?php echo $m_carabayar->KODE->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_carabayar->NAMA->Visible) { // NAMA ?>
		<th><span id="elh_m_carabayar_NAMA" class="m_carabayar_NAMA"><?php echo $m_carabayar->NAMA->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_carabayar->ORDERS->Visible) { // ORDERS ?>
		<th><span id="elh_m_carabayar_ORDERS" class="m_carabayar_ORDERS"><?php echo $m_carabayar->ORDERS->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_carabayar->JMKS->Visible) { // JMKS ?>
		<th><span id="elh_m_carabayar_JMKS" class="m_carabayar_JMKS"><?php echo $m_carabayar->JMKS->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_carabayar->payor_id->Visible) { // payor_id ?>
		<th><span id="elh_m_carabayar_payor_id" class="m_carabayar_payor_id"><?php echo $m_carabayar->payor_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_carabayar->payor_cn->Visible) { // payor_cn ?>
		<th><span id="elh_m_carabayar_payor_cn" class="m_carabayar_payor_cn"><?php echo $m_carabayar->payor_cn->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$m_carabayar_delete->RecCnt = 0;
$i = 0;
while (!$m_carabayar_delete->Recordset->EOF) {
	$m_carabayar_delete->RecCnt++;
	$m_carabayar_delete->RowCnt++;

	// Set row properties
	$m_carabayar->ResetAttrs();
	$m_carabayar->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$m_carabayar_delete->LoadRowValues($m_carabayar_delete->Recordset);

	// Render row
	$m_carabayar_delete->RenderRow();
?>
	<tr<?php echo $m_carabayar->RowAttributes() ?>>
<?php if ($m_carabayar->KODE->Visible) { // KODE ?>
		<td<?php echo $m_carabayar->KODE->CellAttributes() ?>>
<span id="el<?php echo $m_carabayar_delete->RowCnt ?>_m_carabayar_KODE" class="m_carabayar_KODE">
<span<?php echo $m_carabayar->KODE->ViewAttributes() ?>>
<?php echo $m_carabayar->KODE->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_carabayar->NAMA->Visible) { // NAMA ?>
		<td<?php echo $m_carabayar->NAMA->CellAttributes() ?>>
<span id="el<?php echo $m_carabayar_delete->RowCnt ?>_m_carabayar_NAMA" class="m_carabayar_NAMA">
<span<?php echo $m_carabayar->NAMA->ViewAttributes() ?>>
<?php echo $m_carabayar->NAMA->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_carabayar->ORDERS->Visible) { // ORDERS ?>
		<td<?php echo $m_carabayar->ORDERS->CellAttributes() ?>>
<span id="el<?php echo $m_carabayar_delete->RowCnt ?>_m_carabayar_ORDERS" class="m_carabayar_ORDERS">
<span<?php echo $m_carabayar->ORDERS->ViewAttributes() ?>>
<?php echo $m_carabayar->ORDERS->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_carabayar->JMKS->Visible) { // JMKS ?>
		<td<?php echo $m_carabayar->JMKS->CellAttributes() ?>>
<span id="el<?php echo $m_carabayar_delete->RowCnt ?>_m_carabayar_JMKS" class="m_carabayar_JMKS">
<span<?php echo $m_carabayar->JMKS->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($m_carabayar->JMKS->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $m_carabayar->JMKS->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $m_carabayar->JMKS->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($m_carabayar->payor_id->Visible) { // payor_id ?>
		<td<?php echo $m_carabayar->payor_id->CellAttributes() ?>>
<span id="el<?php echo $m_carabayar_delete->RowCnt ?>_m_carabayar_payor_id" class="m_carabayar_payor_id">
<span<?php echo $m_carabayar->payor_id->ViewAttributes() ?>>
<?php echo $m_carabayar->payor_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_carabayar->payor_cn->Visible) { // payor_cn ?>
		<td<?php echo $m_carabayar->payor_cn->CellAttributes() ?>>
<span id="el<?php echo $m_carabayar_delete->RowCnt ?>_m_carabayar_payor_cn" class="m_carabayar_payor_cn">
<span<?php echo $m_carabayar->payor_cn->ViewAttributes() ?>>
<?php echo $m_carabayar->payor_cn->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$m_carabayar_delete->Recordset->MoveNext();
}
$m_carabayar_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_carabayar_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fm_carabayardelete.Init();
</script>
<?php
$m_carabayar_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_carabayar_delete->Page_Terminate();
?>
