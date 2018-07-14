<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "akun5info.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$akun5_delete = NULL; // Initialize page object first

class cakun5_delete extends cakun5 {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'akun5';

	// Page object name
	var $PageObjName = 'akun5_delete';

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

		// Table object (akun5)
		if (!isset($GLOBALS["akun5"]) || get_class($GLOBALS["akun5"]) == "cakun5") {
			$GLOBALS["akun5"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["akun5"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'akun5', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("akun5list.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->kel1->SetVisibility();
		$this->kel2->SetVisibility();
		$this->kel3->SetVisibility();
		$this->kel41->SetVisibility();
		$this->kel4->SetVisibility();
		$this->kel5->SetVisibility();
		$this->kel6->SetVisibility();
		$this->nmkel5->SetVisibility();

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
		global $EW_EXPORT, $akun5;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($akun5);
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
			$this->Page_Terminate("akun5list.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in akun5 class, akun5info.php

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
				$this->Page_Terminate("akun5list.php"); // Return to list
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
		$this->kel1->setDbValue($rs->fields('kel1'));
		$this->kel2->setDbValue($rs->fields('kel2'));
		$this->kel3->setDbValue($rs->fields('kel3'));
		$this->kel41->setDbValue($rs->fields('kel41'));
		$this->kel4->setDbValue($rs->fields('kel4'));
		$this->kel5->setDbValue($rs->fields('kel5'));
		$this->kel6->setDbValue($rs->fields('kel6'));
		$this->nmkel5->setDbValue($rs->fields('nmkel5'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kel1->DbValue = $row['kel1'];
		$this->kel2->DbValue = $row['kel2'];
		$this->kel3->DbValue = $row['kel3'];
		$this->kel41->DbValue = $row['kel41'];
		$this->kel4->DbValue = $row['kel4'];
		$this->kel5->DbValue = $row['kel5'];
		$this->kel6->DbValue = $row['kel6'];
		$this->nmkel5->DbValue = $row['nmkel5'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// kel1
		// kel2
		// kel3
		// kel41
		// kel4
		// kel5
		// kel6
		// nmkel5

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// kel1
		$this->kel1->ViewValue = $this->kel1->CurrentValue;
		$this->kel1->ViewCustomAttributes = "";

		// kel2
		$this->kel2->ViewValue = $this->kel2->CurrentValue;
		$this->kel2->ViewCustomAttributes = "";

		// kel3
		$this->kel3->ViewValue = $this->kel3->CurrentValue;
		$this->kel3->ViewCustomAttributes = "";

		// kel41
		$this->kel41->ViewValue = $this->kel41->CurrentValue;
		$this->kel41->ViewCustomAttributes = "";

		// kel4
		$this->kel4->ViewValue = $this->kel4->CurrentValue;
		$this->kel4->ViewCustomAttributes = "";

		// kel5
		$this->kel5->ViewValue = $this->kel5->CurrentValue;
		$this->kel5->ViewCustomAttributes = "";

		// kel6
		$this->kel6->ViewValue = $this->kel6->CurrentValue;
		$this->kel6->ViewCustomAttributes = "";

		// nmkel5
		$this->nmkel5->ViewValue = $this->nmkel5->CurrentValue;
		$this->nmkel5->ViewCustomAttributes = "";

			// kel1
			$this->kel1->LinkCustomAttributes = "";
			$this->kel1->HrefValue = "";
			$this->kel1->TooltipValue = "";

			// kel2
			$this->kel2->LinkCustomAttributes = "";
			$this->kel2->HrefValue = "";
			$this->kel2->TooltipValue = "";

			// kel3
			$this->kel3->LinkCustomAttributes = "";
			$this->kel3->HrefValue = "";
			$this->kel3->TooltipValue = "";

			// kel41
			$this->kel41->LinkCustomAttributes = "";
			$this->kel41->HrefValue = "";
			$this->kel41->TooltipValue = "";

			// kel4
			$this->kel4->LinkCustomAttributes = "";
			$this->kel4->HrefValue = "";
			$this->kel4->TooltipValue = "";

			// kel5
			$this->kel5->LinkCustomAttributes = "";
			$this->kel5->HrefValue = "";
			$this->kel5->TooltipValue = "";

			// kel6
			$this->kel6->LinkCustomAttributes = "";
			$this->kel6->HrefValue = "";
			$this->kel6->TooltipValue = "";

			// nmkel5
			$this->nmkel5->LinkCustomAttributes = "";
			$this->nmkel5->HrefValue = "";
			$this->nmkel5->TooltipValue = "";
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
				$sThisKey .= $row['kel6'];
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("akun5list.php"), "", $this->TableVar, TRUE);
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
if (!isset($akun5_delete)) $akun5_delete = new cakun5_delete();

// Page init
$akun5_delete->Page_Init();

// Page main
$akun5_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$akun5_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fakun5delete = new ew_Form("fakun5delete", "delete");

// Form_CustomValidate event
fakun5delete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fakun5delete.ValidateRequired = true;
<?php } else { ?>
fakun5delete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $akun5_delete->ShowPageHeader(); ?>
<?php
$akun5_delete->ShowMessage();
?>
<form name="fakun5delete" id="fakun5delete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($akun5_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $akun5_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="akun5">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($akun5_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $akun5->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($akun5->kel1->Visible) { // kel1 ?>
		<th><span id="elh_akun5_kel1" class="akun5_kel1"><?php echo $akun5->kel1->FldCaption() ?></span></th>
<?php } ?>
<?php if ($akun5->kel2->Visible) { // kel2 ?>
		<th><span id="elh_akun5_kel2" class="akun5_kel2"><?php echo $akun5->kel2->FldCaption() ?></span></th>
<?php } ?>
<?php if ($akun5->kel3->Visible) { // kel3 ?>
		<th><span id="elh_akun5_kel3" class="akun5_kel3"><?php echo $akun5->kel3->FldCaption() ?></span></th>
<?php } ?>
<?php if ($akun5->kel41->Visible) { // kel41 ?>
		<th><span id="elh_akun5_kel41" class="akun5_kel41"><?php echo $akun5->kel41->FldCaption() ?></span></th>
<?php } ?>
<?php if ($akun5->kel4->Visible) { // kel4 ?>
		<th><span id="elh_akun5_kel4" class="akun5_kel4"><?php echo $akun5->kel4->FldCaption() ?></span></th>
<?php } ?>
<?php if ($akun5->kel5->Visible) { // kel5 ?>
		<th><span id="elh_akun5_kel5" class="akun5_kel5"><?php echo $akun5->kel5->FldCaption() ?></span></th>
<?php } ?>
<?php if ($akun5->kel6->Visible) { // kel6 ?>
		<th><span id="elh_akun5_kel6" class="akun5_kel6"><?php echo $akun5->kel6->FldCaption() ?></span></th>
<?php } ?>
<?php if ($akun5->nmkel5->Visible) { // nmkel5 ?>
		<th><span id="elh_akun5_nmkel5" class="akun5_nmkel5"><?php echo $akun5->nmkel5->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$akun5_delete->RecCnt = 0;
$i = 0;
while (!$akun5_delete->Recordset->EOF) {
	$akun5_delete->RecCnt++;
	$akun5_delete->RowCnt++;

	// Set row properties
	$akun5->ResetAttrs();
	$akun5->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$akun5_delete->LoadRowValues($akun5_delete->Recordset);

	// Render row
	$akun5_delete->RenderRow();
?>
	<tr<?php echo $akun5->RowAttributes() ?>>
<?php if ($akun5->kel1->Visible) { // kel1 ?>
		<td<?php echo $akun5->kel1->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_kel1" class="akun5_kel1">
<span<?php echo $akun5->kel1->ViewAttributes() ?>>
<?php echo $akun5->kel1->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($akun5->kel2->Visible) { // kel2 ?>
		<td<?php echo $akun5->kel2->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_kel2" class="akun5_kel2">
<span<?php echo $akun5->kel2->ViewAttributes() ?>>
<?php echo $akun5->kel2->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($akun5->kel3->Visible) { // kel3 ?>
		<td<?php echo $akun5->kel3->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_kel3" class="akun5_kel3">
<span<?php echo $akun5->kel3->ViewAttributes() ?>>
<?php echo $akun5->kel3->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($akun5->kel41->Visible) { // kel41 ?>
		<td<?php echo $akun5->kel41->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_kel41" class="akun5_kel41">
<span<?php echo $akun5->kel41->ViewAttributes() ?>>
<?php echo $akun5->kel41->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($akun5->kel4->Visible) { // kel4 ?>
		<td<?php echo $akun5->kel4->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_kel4" class="akun5_kel4">
<span<?php echo $akun5->kel4->ViewAttributes() ?>>
<?php echo $akun5->kel4->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($akun5->kel5->Visible) { // kel5 ?>
		<td<?php echo $akun5->kel5->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_kel5" class="akun5_kel5">
<span<?php echo $akun5->kel5->ViewAttributes() ?>>
<?php echo $akun5->kel5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($akun5->kel6->Visible) { // kel6 ?>
		<td<?php echo $akun5->kel6->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_kel6" class="akun5_kel6">
<span<?php echo $akun5->kel6->ViewAttributes() ?>>
<?php echo $akun5->kel6->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($akun5->nmkel5->Visible) { // nmkel5 ?>
		<td<?php echo $akun5->nmkel5->CellAttributes() ?>>
<span id="el<?php echo $akun5_delete->RowCnt ?>_akun5_nmkel5" class="akun5_nmkel5">
<span<?php echo $akun5->nmkel5->ViewAttributes() ?>>
<?php echo $akun5->nmkel5->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$akun5_delete->Recordset->MoveNext();
}
$akun5_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $akun5_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fakun5delete.Init();
</script>
<?php
$akun5_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$akun5_delete->Page_Terminate();
?>
