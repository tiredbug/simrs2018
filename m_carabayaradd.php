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

$m_carabayar_add = NULL; // Initialize page object first

class cm_carabayar_add extends cm_carabayar {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_carabayar';

	// Page object name
	var $PageObjName = 'm_carabayar_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["KODE"] != "") {
				$this->KODE->setQueryStringValue($_GET["KODE"]);
				$this->setKey("KODE", $this->KODE->CurrentValue); // Set up key
			} else {
				$this->setKey("KODE", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("m_carabayarlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "m_carabayarlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "m_carabayarview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->KODE->CurrentValue = 0;
		$this->NAMA->CurrentValue = NULL;
		$this->NAMA->OldValue = $this->NAMA->CurrentValue;
		$this->ORDERS->CurrentValue = 0;
		$this->JMKS->CurrentValue = "0";
		$this->payor_id->CurrentValue = NULL;
		$this->payor_id->OldValue = $this->payor_id->CurrentValue;
		$this->payor_cn->CurrentValue = NULL;
		$this->payor_cn->OldValue = $this->payor_cn->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->KODE->FldIsDetailKey) {
			$this->KODE->setFormValue($objForm->GetValue("x_KODE"));
		}
		if (!$this->NAMA->FldIsDetailKey) {
			$this->NAMA->setFormValue($objForm->GetValue("x_NAMA"));
		}
		if (!$this->ORDERS->FldIsDetailKey) {
			$this->ORDERS->setFormValue($objForm->GetValue("x_ORDERS"));
		}
		if (!$this->JMKS->FldIsDetailKey) {
			$this->JMKS->setFormValue($objForm->GetValue("x_JMKS"));
		}
		if (!$this->payor_id->FldIsDetailKey) {
			$this->payor_id->setFormValue($objForm->GetValue("x_payor_id"));
		}
		if (!$this->payor_cn->FldIsDetailKey) {
			$this->payor_cn->setFormValue($objForm->GetValue("x_payor_cn"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->KODE->CurrentValue = $this->KODE->FormValue;
		$this->NAMA->CurrentValue = $this->NAMA->FormValue;
		$this->ORDERS->CurrentValue = $this->ORDERS->FormValue;
		$this->JMKS->CurrentValue = $this->JMKS->FormValue;
		$this->payor_id->CurrentValue = $this->payor_id->FormValue;
		$this->payor_cn->CurrentValue = $this->payor_cn->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("KODE")) <> "")
			$this->KODE->CurrentValue = $this->getKey("KODE"); // KODE
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// KODE
			$this->KODE->EditAttrs["class"] = "form-control";
			$this->KODE->EditCustomAttributes = "";
			$this->KODE->EditValue = ew_HtmlEncode($this->KODE->CurrentValue);
			$this->KODE->PlaceHolder = ew_RemoveHtml($this->KODE->FldCaption());

			// NAMA
			$this->NAMA->EditAttrs["class"] = "form-control";
			$this->NAMA->EditCustomAttributes = "";
			$this->NAMA->EditValue = ew_HtmlEncode($this->NAMA->CurrentValue);
			$this->NAMA->PlaceHolder = ew_RemoveHtml($this->NAMA->FldCaption());

			// ORDERS
			$this->ORDERS->EditAttrs["class"] = "form-control";
			$this->ORDERS->EditCustomAttributes = "";
			$this->ORDERS->EditValue = ew_HtmlEncode($this->ORDERS->CurrentValue);
			$this->ORDERS->PlaceHolder = ew_RemoveHtml($this->ORDERS->FldCaption());

			// JMKS
			$this->JMKS->EditCustomAttributes = "";
			$this->JMKS->EditValue = $this->JMKS->Options(FALSE);

			// payor_id
			$this->payor_id->EditAttrs["class"] = "form-control";
			$this->payor_id->EditCustomAttributes = "";
			$this->payor_id->EditValue = ew_HtmlEncode($this->payor_id->CurrentValue);
			$this->payor_id->PlaceHolder = ew_RemoveHtml($this->payor_id->FldCaption());

			// payor_cn
			$this->payor_cn->EditAttrs["class"] = "form-control";
			$this->payor_cn->EditCustomAttributes = "";
			$this->payor_cn->EditValue = ew_HtmlEncode($this->payor_cn->CurrentValue);
			$this->payor_cn->PlaceHolder = ew_RemoveHtml($this->payor_cn->FldCaption());

			// Add refer script
			// KODE

			$this->KODE->LinkCustomAttributes = "";
			$this->KODE->HrefValue = "";

			// NAMA
			$this->NAMA->LinkCustomAttributes = "";
			$this->NAMA->HrefValue = "";

			// ORDERS
			$this->ORDERS->LinkCustomAttributes = "";
			$this->ORDERS->HrefValue = "";

			// JMKS
			$this->JMKS->LinkCustomAttributes = "";
			$this->JMKS->HrefValue = "";

			// payor_id
			$this->payor_id->LinkCustomAttributes = "";
			$this->payor_id->HrefValue = "";

			// payor_cn
			$this->payor_cn->LinkCustomAttributes = "";
			$this->payor_cn->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->KODE->FldIsDetailKey && !is_null($this->KODE->FormValue) && $this->KODE->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KODE->FldCaption(), $this->KODE->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->KODE->FormValue)) {
			ew_AddMessage($gsFormError, $this->KODE->FldErrMsg());
		}
		if (!$this->ORDERS->FldIsDetailKey && !is_null($this->ORDERS->FormValue) && $this->ORDERS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ORDERS->FldCaption(), $this->ORDERS->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->ORDERS->FormValue)) {
			ew_AddMessage($gsFormError, $this->ORDERS->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// KODE
		$this->KODE->SetDbValueDef($rsnew, $this->KODE->CurrentValue, 0, strval($this->KODE->CurrentValue) == "");

		// NAMA
		$this->NAMA->SetDbValueDef($rsnew, $this->NAMA->CurrentValue, NULL, FALSE);

		// ORDERS
		$this->ORDERS->SetDbValueDef($rsnew, $this->ORDERS->CurrentValue, 0, strval($this->ORDERS->CurrentValue) == "");

		// JMKS
		$tmpBool = $this->JMKS->CurrentValue;
		if ($tmpBool <> "1" && $tmpBool <> "0")
			$tmpBool = (!empty($tmpBool)) ? "1" : "0";
		$this->JMKS->SetDbValueDef($rsnew, $tmpBool, 0, strval($this->JMKS->CurrentValue) == "");

		// payor_id
		$this->payor_id->SetDbValueDef($rsnew, $this->payor_id->CurrentValue, NULL, FALSE);

		// payor_cn
		$this->payor_cn->SetDbValueDef($rsnew, $this->payor_cn->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['KODE']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_carabayarlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($m_carabayar_add)) $m_carabayar_add = new cm_carabayar_add();

// Page init
$m_carabayar_add->Page_Init();

// Page main
$m_carabayar_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_carabayar_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fm_carabayaradd = new ew_Form("fm_carabayaradd", "add");

// Validate form
fm_carabayaradd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_KODE");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_carabayar->KODE->FldCaption(), $m_carabayar->KODE->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KODE");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_carabayar->KODE->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ORDERS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_carabayar->ORDERS->FldCaption(), $m_carabayar->ORDERS->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ORDERS");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_carabayar->ORDERS->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fm_carabayaradd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_carabayaradd.ValidateRequired = true;
<?php } else { ?>
fm_carabayaradd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_carabayaradd.Lists["x_JMKS[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fm_carabayaradd.Lists["x_JMKS[]"].Options = <?php echo json_encode($m_carabayar->JMKS->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_carabayar_add->IsModal) { ?>
<?php } ?>
<?php $m_carabayar_add->ShowPageHeader(); ?>
<?php
$m_carabayar_add->ShowMessage();
?>
<form name="fm_carabayaradd" id="fm_carabayaradd" class="<?php echo $m_carabayar_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_carabayar_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_carabayar_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_carabayar">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($m_carabayar_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_carabayar->KODE->Visible) { // KODE ?>
	<div id="r_KODE" class="form-group">
		<label id="elh_m_carabayar_KODE" for="x_KODE" class="col-sm-2 control-label ewLabel"><?php echo $m_carabayar->KODE->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_carabayar->KODE->CellAttributes() ?>>
<span id="el_m_carabayar_KODE">
<input type="text" data-table="m_carabayar" data-field="x_KODE" name="x_KODE" id="x_KODE" size="30" placeholder="<?php echo ew_HtmlEncode($m_carabayar->KODE->getPlaceHolder()) ?>" value="<?php echo $m_carabayar->KODE->EditValue ?>"<?php echo $m_carabayar->KODE->EditAttributes() ?>>
</span>
<?php echo $m_carabayar->KODE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_carabayar->NAMA->Visible) { // NAMA ?>
	<div id="r_NAMA" class="form-group">
		<label id="elh_m_carabayar_NAMA" for="x_NAMA" class="col-sm-2 control-label ewLabel"><?php echo $m_carabayar->NAMA->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_carabayar->NAMA->CellAttributes() ?>>
<span id="el_m_carabayar_NAMA">
<input type="text" data-table="m_carabayar" data-field="x_NAMA" name="x_NAMA" id="x_NAMA" size="30" maxlength="32" placeholder="<?php echo ew_HtmlEncode($m_carabayar->NAMA->getPlaceHolder()) ?>" value="<?php echo $m_carabayar->NAMA->EditValue ?>"<?php echo $m_carabayar->NAMA->EditAttributes() ?>>
</span>
<?php echo $m_carabayar->NAMA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_carabayar->ORDERS->Visible) { // ORDERS ?>
	<div id="r_ORDERS" class="form-group">
		<label id="elh_m_carabayar_ORDERS" for="x_ORDERS" class="col-sm-2 control-label ewLabel"><?php echo $m_carabayar->ORDERS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_carabayar->ORDERS->CellAttributes() ?>>
<span id="el_m_carabayar_ORDERS">
<input type="text" data-table="m_carabayar" data-field="x_ORDERS" name="x_ORDERS" id="x_ORDERS" size="30" placeholder="<?php echo ew_HtmlEncode($m_carabayar->ORDERS->getPlaceHolder()) ?>" value="<?php echo $m_carabayar->ORDERS->EditValue ?>"<?php echo $m_carabayar->ORDERS->EditAttributes() ?>>
</span>
<?php echo $m_carabayar->ORDERS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_carabayar->JMKS->Visible) { // JMKS ?>
	<div id="r_JMKS" class="form-group">
		<label id="elh_m_carabayar_JMKS" class="col-sm-2 control-label ewLabel"><?php echo $m_carabayar->JMKS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_carabayar->JMKS->CellAttributes() ?>>
<span id="el_m_carabayar_JMKS">
<?php
$selwrk = (ew_ConvertToBool($m_carabayar->JMKS->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="m_carabayar" data-field="x_JMKS" name="x_JMKS[]" id="x_JMKS[]" value="1"<?php echo $selwrk ?><?php echo $m_carabayar->JMKS->EditAttributes() ?>>
</span>
<?php echo $m_carabayar->JMKS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_carabayar->payor_id->Visible) { // payor_id ?>
	<div id="r_payor_id" class="form-group">
		<label id="elh_m_carabayar_payor_id" for="x_payor_id" class="col-sm-2 control-label ewLabel"><?php echo $m_carabayar->payor_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_carabayar->payor_id->CellAttributes() ?>>
<span id="el_m_carabayar_payor_id">
<input type="text" data-table="m_carabayar" data-field="x_payor_id" name="x_payor_id" id="x_payor_id" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_carabayar->payor_id->getPlaceHolder()) ?>" value="<?php echo $m_carabayar->payor_id->EditValue ?>"<?php echo $m_carabayar->payor_id->EditAttributes() ?>>
</span>
<?php echo $m_carabayar->payor_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_carabayar->payor_cn->Visible) { // payor_cn ?>
	<div id="r_payor_cn" class="form-group">
		<label id="elh_m_carabayar_payor_cn" for="x_payor_cn" class="col-sm-2 control-label ewLabel"><?php echo $m_carabayar->payor_cn->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_carabayar->payor_cn->CellAttributes() ?>>
<span id="el_m_carabayar_payor_cn">
<input type="text" data-table="m_carabayar" data-field="x_payor_cn" name="x_payor_cn" id="x_payor_cn" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_carabayar->payor_cn->getPlaceHolder()) ?>" value="<?php echo $m_carabayar->payor_cn->EditValue ?>"<?php echo $m_carabayar->payor_cn->EditAttributes() ?>>
</span>
<?php echo $m_carabayar->payor_cn->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_carabayar_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_carabayar_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_carabayaradd.Init();
</script>
<?php
$m_carabayar_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_carabayar_add->Page_Terminate();
?>
