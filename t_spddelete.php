<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_spdinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_spd_delete = NULL; // Initialize page object first

class ct_spd_delete extends ct_spd {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_spd';

	// Page object name
	var $PageObjName = 't_spd_delete';

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

		// Table object (t_spd)
		if (!isset($GLOBALS["t_spd"]) || get_class($GLOBALS["t_spd"]) == "ct_spd") {
			$GLOBALS["t_spd"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_spd"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_spd', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_spdlist.php"));
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
		$this->jenis_peraturan->SetVisibility();
		$this->tanggal->SetVisibility();
		$this->no_spd->SetVisibility();
		$this->jumlah_spd->SetVisibility();
		$this->pembayaran->SetVisibility();
		$this->no_sk_dir->SetVisibility();
		$this->tgl_sk_dir->SetVisibility();
		$this->th_anggaran->SetVisibility();

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
		global $EW_EXPORT, $t_spd;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_spd);
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
			$this->Page_Terminate("t_spdlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in t_spd class, t_spdinfo.php

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
				$this->Page_Terminate("t_spdlist.php"); // Return to list
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
		$this->jenis_peraturan->setDbValue($rs->fields('jenis_peraturan'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->no_spd->setDbValue($rs->fields('no_spd'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->pembayaran->setDbValue($rs->fields('pembayaran'));
		$this->no_sk_dir->setDbValue($rs->fields('no_sk_dir'));
		$this->tgl_sk_dir->setDbValue($rs->fields('tgl_sk_dir'));
		$this->th_anggaran->setDbValue($rs->fields('th_anggaran'));
		$this->tentang->setDbValue($rs->fields('tentang'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->jenis_peraturan->DbValue = $row['jenis_peraturan'];
		$this->tanggal->DbValue = $row['tanggal'];
		$this->no_spd->DbValue = $row['no_spd'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
		$this->pembayaran->DbValue = $row['pembayaran'];
		$this->no_sk_dir->DbValue = $row['no_sk_dir'];
		$this->tgl_sk_dir->DbValue = $row['tgl_sk_dir'];
		$this->th_anggaran->DbValue = $row['th_anggaran'];
		$this->tentang->DbValue = $row['tentang'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->jumlah_spd->FormValue == $this->jumlah_spd->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_spd->CurrentValue)))
			$this->jumlah_spd->CurrentValue = ew_StrToFloat($this->jumlah_spd->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// jenis_peraturan
		// tanggal
		// no_spd
		// jumlah_spd
		// pembayaran
		// no_sk_dir
		// tgl_sk_dir
		// th_anggaran
		// tentang

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// jenis_peraturan
		if (strval($this->jenis_peraturan->CurrentValue) <> "") {
			$this->jenis_peraturan->ViewValue = $this->jenis_peraturan->OptionCaption($this->jenis_peraturan->CurrentValue);
		} else {
			$this->jenis_peraturan->ViewValue = NULL;
		}
		$this->jenis_peraturan->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->ViewCustomAttributes = "";

		// no_spd
		$this->no_spd->ViewValue = $this->no_spd->CurrentValue;
		$this->no_spd->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

		// pembayaran
		$this->pembayaran->ViewValue = $this->pembayaran->CurrentValue;
		$this->pembayaran->ViewCustomAttributes = "";

		// no_sk_dir
		$this->no_sk_dir->ViewValue = $this->no_sk_dir->CurrentValue;
		$this->no_sk_dir->ViewCustomAttributes = "";

		// tgl_sk_dir
		$this->tgl_sk_dir->ViewValue = $this->tgl_sk_dir->CurrentValue;
		$this->tgl_sk_dir->ViewValue = ew_FormatDateTime($this->tgl_sk_dir->ViewValue, 7);
		$this->tgl_sk_dir->ViewCustomAttributes = "";

		// th_anggaran
		$this->th_anggaran->ViewValue = $this->th_anggaran->CurrentValue;
		$this->th_anggaran->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// jenis_peraturan
			$this->jenis_peraturan->LinkCustomAttributes = "";
			$this->jenis_peraturan->HrefValue = "";
			$this->jenis_peraturan->TooltipValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// no_spd
			$this->no_spd->LinkCustomAttributes = "";
			$this->no_spd->HrefValue = "";
			$this->no_spd->TooltipValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";
			$this->jumlah_spd->TooltipValue = "";

			// pembayaran
			$this->pembayaran->LinkCustomAttributes = "";
			$this->pembayaran->HrefValue = "";
			$this->pembayaran->TooltipValue = "";

			// no_sk_dir
			$this->no_sk_dir->LinkCustomAttributes = "";
			$this->no_sk_dir->HrefValue = "";
			$this->no_sk_dir->TooltipValue = "";

			// tgl_sk_dir
			$this->tgl_sk_dir->LinkCustomAttributes = "";
			$this->tgl_sk_dir->HrefValue = "";
			$this->tgl_sk_dir->TooltipValue = "";

			// th_anggaran
			$this->th_anggaran->LinkCustomAttributes = "";
			$this->th_anggaran->HrefValue = "";
			$this->th_anggaran->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_spdlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_spd_delete)) $t_spd_delete = new ct_spd_delete();

// Page init
$t_spd_delete->Page_Init();

// Page main
$t_spd_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_spd_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ft_spddelete = new ew_Form("ft_spddelete", "delete");

// Form_CustomValidate event
ft_spddelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_spddelete.ValidateRequired = true;
<?php } else { ?>
ft_spddelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_spddelete.Lists["x_jenis_peraturan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_spddelete.Lists["x_jenis_peraturan"].Options = <?php echo json_encode($t_spd->jenis_peraturan->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $t_spd_delete->ShowPageHeader(); ?>
<?php
$t_spd_delete->ShowMessage();
?>
<form name="ft_spddelete" id="ft_spddelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_spd_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_spd_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_spd">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($t_spd_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $t_spd->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($t_spd->id->Visible) { // id ?>
		<th><span id="elh_t_spd_id" class="t_spd_id"><?php echo $t_spd->id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->jenis_peraturan->Visible) { // jenis_peraturan ?>
		<th><span id="elh_t_spd_jenis_peraturan" class="t_spd_jenis_peraturan"><?php echo $t_spd->jenis_peraturan->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->tanggal->Visible) { // tanggal ?>
		<th><span id="elh_t_spd_tanggal" class="t_spd_tanggal"><?php echo $t_spd->tanggal->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->no_spd->Visible) { // no_spd ?>
		<th><span id="elh_t_spd_no_spd" class="t_spd_no_spd"><?php echo $t_spd->no_spd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->jumlah_spd->Visible) { // jumlah_spd ?>
		<th><span id="elh_t_spd_jumlah_spd" class="t_spd_jumlah_spd"><?php echo $t_spd->jumlah_spd->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->pembayaran->Visible) { // pembayaran ?>
		<th><span id="elh_t_spd_pembayaran" class="t_spd_pembayaran"><?php echo $t_spd->pembayaran->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->no_sk_dir->Visible) { // no_sk_dir ?>
		<th><span id="elh_t_spd_no_sk_dir" class="t_spd_no_sk_dir"><?php echo $t_spd->no_sk_dir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->tgl_sk_dir->Visible) { // tgl_sk_dir ?>
		<th><span id="elh_t_spd_tgl_sk_dir" class="t_spd_tgl_sk_dir"><?php echo $t_spd->tgl_sk_dir->FldCaption() ?></span></th>
<?php } ?>
<?php if ($t_spd->th_anggaran->Visible) { // th_anggaran ?>
		<th><span id="elh_t_spd_th_anggaran" class="t_spd_th_anggaran"><?php echo $t_spd->th_anggaran->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$t_spd_delete->RecCnt = 0;
$i = 0;
while (!$t_spd_delete->Recordset->EOF) {
	$t_spd_delete->RecCnt++;
	$t_spd_delete->RowCnt++;

	// Set row properties
	$t_spd->ResetAttrs();
	$t_spd->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$t_spd_delete->LoadRowValues($t_spd_delete->Recordset);

	// Render row
	$t_spd_delete->RenderRow();
?>
	<tr<?php echo $t_spd->RowAttributes() ?>>
<?php if ($t_spd->id->Visible) { // id ?>
		<td<?php echo $t_spd->id->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_id" class="t_spd_id">
<span<?php echo $t_spd->id->ViewAttributes() ?>>
<?php echo $t_spd->id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->jenis_peraturan->Visible) { // jenis_peraturan ?>
		<td<?php echo $t_spd->jenis_peraturan->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_jenis_peraturan" class="t_spd_jenis_peraturan">
<span<?php echo $t_spd->jenis_peraturan->ViewAttributes() ?>>
<?php echo $t_spd->jenis_peraturan->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->tanggal->Visible) { // tanggal ?>
		<td<?php echo $t_spd->tanggal->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_tanggal" class="t_spd_tanggal">
<span<?php echo $t_spd->tanggal->ViewAttributes() ?>>
<?php echo $t_spd->tanggal->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->no_spd->Visible) { // no_spd ?>
		<td<?php echo $t_spd->no_spd->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_no_spd" class="t_spd_no_spd">
<span<?php echo $t_spd->no_spd->ViewAttributes() ?>>
<?php echo $t_spd->no_spd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->jumlah_spd->Visible) { // jumlah_spd ?>
		<td<?php echo $t_spd->jumlah_spd->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_jumlah_spd" class="t_spd_jumlah_spd">
<span<?php echo $t_spd->jumlah_spd->ViewAttributes() ?>>
<?php echo $t_spd->jumlah_spd->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->pembayaran->Visible) { // pembayaran ?>
		<td<?php echo $t_spd->pembayaran->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_pembayaran" class="t_spd_pembayaran">
<span<?php echo $t_spd->pembayaran->ViewAttributes() ?>>
<?php echo $t_spd->pembayaran->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->no_sk_dir->Visible) { // no_sk_dir ?>
		<td<?php echo $t_spd->no_sk_dir->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_no_sk_dir" class="t_spd_no_sk_dir">
<span<?php echo $t_spd->no_sk_dir->ViewAttributes() ?>>
<?php echo $t_spd->no_sk_dir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->tgl_sk_dir->Visible) { // tgl_sk_dir ?>
		<td<?php echo $t_spd->tgl_sk_dir->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_tgl_sk_dir" class="t_spd_tgl_sk_dir">
<span<?php echo $t_spd->tgl_sk_dir->ViewAttributes() ?>>
<?php echo $t_spd->tgl_sk_dir->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($t_spd->th_anggaran->Visible) { // th_anggaran ?>
		<td<?php echo $t_spd->th_anggaran->CellAttributes() ?>>
<span id="el<?php echo $t_spd_delete->RowCnt ?>_t_spd_th_anggaran" class="t_spd_th_anggaran">
<span<?php echo $t_spd->th_anggaran->ViewAttributes() ?>>
<?php echo $t_spd->th_anggaran->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$t_spd_delete->Recordset->MoveNext();
}
$t_spd_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_spd_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ft_spddelete.Init();
</script>
<?php
$t_spd_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_spd_delete->Page_Terminate();
?>
