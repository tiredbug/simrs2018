<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_blud_rsinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_blud_rs_delete = NULL; // Initialize page object first

class cm_blud_rs_delete extends cm_blud_rs {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_blud_rs';

	// Page object name
	var $PageObjName = 'm_blud_rs_delete';

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

		// Table object (m_blud_rs)
		if (!isset($GLOBALS["m_blud_rs"]) || get_class($GLOBALS["m_blud_rs"]) == "cm_blud_rs") {
			$GLOBALS["m_blud_rs"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_blud_rs"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_blud_rs', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_blud_rslist.php"));
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
		$this->direktur->SetVisibility();
		$this->nip->SetVisibility();
		$this->jabatan_keuangan->SetVisibility();
		$this->rekening->SetVisibility();
		$this->nomer_rekening->SetVisibility();
		$this->npwp->SetVisibility();
		$this->bendahara_keuangan->SetVisibility();
		$this->nip_bendahara_keuangan->SetVisibility();

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
		global $EW_EXPORT, $m_blud_rs;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_blud_rs);
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
			$this->Page_Terminate("m_blud_rslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in m_blud_rs class, m_blud_rsinfo.php

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
				$this->Page_Terminate("m_blud_rslist.php"); // Return to list
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
		$this->direktur->setDbValue($rs->fields('direktur'));
		$this->nip->setDbValue($rs->fields('nip'));
		$this->jabatan_keuangan->setDbValue($rs->fields('jabatan_keuangan'));
		$this->rekening->setDbValue($rs->fields('rekening'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->bendahara_keuangan->setDbValue($rs->fields('bendahara_keuangan'));
		$this->nip_bendahara_keuangan->setDbValue($rs->fields('nip_bendahara_keuangan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->direktur->DbValue = $row['direktur'];
		$this->nip->DbValue = $row['nip'];
		$this->jabatan_keuangan->DbValue = $row['jabatan_keuangan'];
		$this->rekening->DbValue = $row['rekening'];
		$this->nomer_rekening->DbValue = $row['nomer_rekening'];
		$this->npwp->DbValue = $row['npwp'];
		$this->bendahara_keuangan->DbValue = $row['bendahara_keuangan'];
		$this->nip_bendahara_keuangan->DbValue = $row['nip_bendahara_keuangan'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// direktur
		// nip
		// jabatan_keuangan
		// rekening
		// nomer_rekening
		// npwp
		// bendahara_keuangan
		// nip_bendahara_keuangan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// direktur
		$this->direktur->ViewValue = $this->direktur->CurrentValue;
		$this->direktur->ViewCustomAttributes = "";

		// nip
		$this->nip->ViewValue = $this->nip->CurrentValue;
		$this->nip->ViewCustomAttributes = "";

		// jabatan_keuangan
		$this->jabatan_keuangan->ViewValue = $this->jabatan_keuangan->CurrentValue;
		$this->jabatan_keuangan->ViewCustomAttributes = "";

		// rekening
		$this->rekening->ViewValue = $this->rekening->CurrentValue;
		$this->rekening->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// bendahara_keuangan
		$this->bendahara_keuangan->ViewValue = $this->bendahara_keuangan->CurrentValue;
		$this->bendahara_keuangan->ViewCustomAttributes = "";

		// nip_bendahara_keuangan
		$this->nip_bendahara_keuangan->ViewValue = $this->nip_bendahara_keuangan->CurrentValue;
		$this->nip_bendahara_keuangan->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// direktur
			$this->direktur->LinkCustomAttributes = "";
			$this->direktur->HrefValue = "";
			$this->direktur->TooltipValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";
			$this->nip->TooltipValue = "";

			// jabatan_keuangan
			$this->jabatan_keuangan->LinkCustomAttributes = "";
			$this->jabatan_keuangan->HrefValue = "";
			$this->jabatan_keuangan->TooltipValue = "";

			// rekening
			$this->rekening->LinkCustomAttributes = "";
			$this->rekening->HrefValue = "";
			$this->rekening->TooltipValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";
			$this->nomer_rekening->TooltipValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";
			$this->npwp->TooltipValue = "";

			// bendahara_keuangan
			$this->bendahara_keuangan->LinkCustomAttributes = "";
			$this->bendahara_keuangan->HrefValue = "";
			$this->bendahara_keuangan->TooltipValue = "";

			// nip_bendahara_keuangan
			$this->nip_bendahara_keuangan->LinkCustomAttributes = "";
			$this->nip_bendahara_keuangan->HrefValue = "";
			$this->nip_bendahara_keuangan->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_blud_rslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_blud_rs_delete)) $m_blud_rs_delete = new cm_blud_rs_delete();

// Page init
$m_blud_rs_delete->Page_Init();

// Page main
$m_blud_rs_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_blud_rs_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fm_blud_rsdelete = new ew_Form("fm_blud_rsdelete", "delete");

// Form_CustomValidate event
fm_blud_rsdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_blud_rsdelete.ValidateRequired = true;
<?php } else { ?>
fm_blud_rsdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $m_blud_rs_delete->ShowPageHeader(); ?>
<?php
$m_blud_rs_delete->ShowMessage();
?>
<form name="fm_blud_rsdelete" id="fm_blud_rsdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_blud_rs_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_blud_rs_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_blud_rs">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($m_blud_rs_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_blud_rs->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($m_blud_rs->id->Visible) { // id ?>
		<th><span id="elh_m_blud_rs_id" class="m_blud_rs_id"><?php echo $m_blud_rs->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->direktur->Visible) { // direktur ?>
		<th><span id="elh_m_blud_rs_direktur" class="m_blud_rs_direktur"><?php echo $m_blud_rs->direktur->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->nip->Visible) { // nip ?>
		<th><span id="elh_m_blud_rs_nip" class="m_blud_rs_nip"><?php echo $m_blud_rs->nip->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->jabatan_keuangan->Visible) { // jabatan_keuangan ?>
		<th><span id="elh_m_blud_rs_jabatan_keuangan" class="m_blud_rs_jabatan_keuangan"><?php echo $m_blud_rs->jabatan_keuangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->rekening->Visible) { // rekening ?>
		<th><span id="elh_m_blud_rs_rekening" class="m_blud_rs_rekening"><?php echo $m_blud_rs->rekening->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->nomer_rekening->Visible) { // nomer_rekening ?>
		<th><span id="elh_m_blud_rs_nomer_rekening" class="m_blud_rs_nomer_rekening"><?php echo $m_blud_rs->nomer_rekening->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->npwp->Visible) { // npwp ?>
		<th><span id="elh_m_blud_rs_npwp" class="m_blud_rs_npwp"><?php echo $m_blud_rs->npwp->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->bendahara_keuangan->Visible) { // bendahara_keuangan ?>
		<th><span id="elh_m_blud_rs_bendahara_keuangan" class="m_blud_rs_bendahara_keuangan"><?php echo $m_blud_rs->bendahara_keuangan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_blud_rs->nip_bendahara_keuangan->Visible) { // nip_bendahara_keuangan ?>
		<th><span id="elh_m_blud_rs_nip_bendahara_keuangan" class="m_blud_rs_nip_bendahara_keuangan"><?php echo $m_blud_rs->nip_bendahara_keuangan->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$m_blud_rs_delete->RecCnt = 0;
$i = 0;
while (!$m_blud_rs_delete->Recordset->EOF) {
	$m_blud_rs_delete->RecCnt++;
	$m_blud_rs_delete->RowCnt++;

	// Set row properties
	$m_blud_rs->ResetAttrs();
	$m_blud_rs->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$m_blud_rs_delete->LoadRowValues($m_blud_rs_delete->Recordset);

	// Render row
	$m_blud_rs_delete->RenderRow();
?>
	<tr<?php echo $m_blud_rs->RowAttributes() ?>>
<?php if ($m_blud_rs->id->Visible) { // id ?>
		<td<?php echo $m_blud_rs->id->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_id" class="m_blud_rs_id">
<span<?php echo $m_blud_rs->id->ViewAttributes() ?>>
<?php echo $m_blud_rs->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->direktur->Visible) { // direktur ?>
		<td<?php echo $m_blud_rs->direktur->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_direktur" class="m_blud_rs_direktur">
<span<?php echo $m_blud_rs->direktur->ViewAttributes() ?>>
<?php echo $m_blud_rs->direktur->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->nip->Visible) { // nip ?>
		<td<?php echo $m_blud_rs->nip->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_nip" class="m_blud_rs_nip">
<span<?php echo $m_blud_rs->nip->ViewAttributes() ?>>
<?php echo $m_blud_rs->nip->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->jabatan_keuangan->Visible) { // jabatan_keuangan ?>
		<td<?php echo $m_blud_rs->jabatan_keuangan->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_jabatan_keuangan" class="m_blud_rs_jabatan_keuangan">
<span<?php echo $m_blud_rs->jabatan_keuangan->ViewAttributes() ?>>
<?php echo $m_blud_rs->jabatan_keuangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->rekening->Visible) { // rekening ?>
		<td<?php echo $m_blud_rs->rekening->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_rekening" class="m_blud_rs_rekening">
<span<?php echo $m_blud_rs->rekening->ViewAttributes() ?>>
<?php echo $m_blud_rs->rekening->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->nomer_rekening->Visible) { // nomer_rekening ?>
		<td<?php echo $m_blud_rs->nomer_rekening->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_nomer_rekening" class="m_blud_rs_nomer_rekening">
<span<?php echo $m_blud_rs->nomer_rekening->ViewAttributes() ?>>
<?php echo $m_blud_rs->nomer_rekening->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->npwp->Visible) { // npwp ?>
		<td<?php echo $m_blud_rs->npwp->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_npwp" class="m_blud_rs_npwp">
<span<?php echo $m_blud_rs->npwp->ViewAttributes() ?>>
<?php echo $m_blud_rs->npwp->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->bendahara_keuangan->Visible) { // bendahara_keuangan ?>
		<td<?php echo $m_blud_rs->bendahara_keuangan->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_bendahara_keuangan" class="m_blud_rs_bendahara_keuangan">
<span<?php echo $m_blud_rs->bendahara_keuangan->ViewAttributes() ?>>
<?php echo $m_blud_rs->bendahara_keuangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_blud_rs->nip_bendahara_keuangan->Visible) { // nip_bendahara_keuangan ?>
		<td<?php echo $m_blud_rs->nip_bendahara_keuangan->CellAttributes() ?>>
<span id="el<?php echo $m_blud_rs_delete->RowCnt ?>_m_blud_rs_nip_bendahara_keuangan" class="m_blud_rs_nip_bendahara_keuangan">
<span<?php echo $m_blud_rs->nip_bendahara_keuangan->ViewAttributes() ?>>
<?php echo $m_blud_rs->nip_bendahara_keuangan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$m_blud_rs_delete->Recordset->MoveNext();
}
$m_blud_rs_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_blud_rs_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fm_blud_rsdelete.Init();
</script>
<?php
$m_blud_rs_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_blud_rs_delete->Page_Terminate();
?>
