<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "akun3info.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$akun3_add = NULL; // Initialize page object first

class cakun3_add extends cakun3 {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'akun3';

	// Page object name
	var $PageObjName = 'akun3_add';

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

		// Table object (akun3)
		if (!isset($GLOBALS["akun3"]) || get_class($GLOBALS["akun3"]) == "cakun3") {
			$GLOBALS["akun3"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["akun3"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'akun3', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("akun3list.php"));
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
		$this->kel1->SetVisibility();
		$this->kel2->SetVisibility();
		$this->kel3->SetVisibility();
		$this->kel4->SetVisibility();
		$this->nmkel3->SetVisibility();

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
		global $EW_EXPORT, $akun3;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($akun3);
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
			if (@$_GET["kel4"] != "") {
				$this->kel4->setQueryStringValue($_GET["kel4"]);
				$this->setKey("kel4", $this->kel4->CurrentValue); // Set up key
			} else {
				$this->setKey("kel4", ""); // Clear key
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
					$this->Page_Terminate("akun3list.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "akun3list.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "akun3view.php")
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
		$this->kel1->CurrentValue = NULL;
		$this->kel1->OldValue = $this->kel1->CurrentValue;
		$this->kel2->CurrentValue = NULL;
		$this->kel2->OldValue = $this->kel2->CurrentValue;
		$this->kel3->CurrentValue = NULL;
		$this->kel3->OldValue = $this->kel3->CurrentValue;
		$this->kel4->CurrentValue = NULL;
		$this->kel4->OldValue = $this->kel4->CurrentValue;
		$this->nmkel3->CurrentValue = NULL;
		$this->nmkel3->OldValue = $this->nmkel3->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->kel1->FldIsDetailKey) {
			$this->kel1->setFormValue($objForm->GetValue("x_kel1"));
		}
		if (!$this->kel2->FldIsDetailKey) {
			$this->kel2->setFormValue($objForm->GetValue("x_kel2"));
		}
		if (!$this->kel3->FldIsDetailKey) {
			$this->kel3->setFormValue($objForm->GetValue("x_kel3"));
		}
		if (!$this->kel4->FldIsDetailKey) {
			$this->kel4->setFormValue($objForm->GetValue("x_kel4"));
		}
		if (!$this->nmkel3->FldIsDetailKey) {
			$this->nmkel3->setFormValue($objForm->GetValue("x_nmkel3"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->kel1->CurrentValue = $this->kel1->FormValue;
		$this->kel2->CurrentValue = $this->kel2->FormValue;
		$this->kel3->CurrentValue = $this->kel3->FormValue;
		$this->kel4->CurrentValue = $this->kel4->FormValue;
		$this->nmkel3->CurrentValue = $this->nmkel3->FormValue;
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
		$this->kel4->setDbValue($rs->fields('kel4'));
		$this->nmkel3->setDbValue($rs->fields('nmkel3'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->kel1->DbValue = $row['kel1'];
		$this->kel2->DbValue = $row['kel2'];
		$this->kel3->DbValue = $row['kel3'];
		$this->kel4->DbValue = $row['kel4'];
		$this->nmkel3->DbValue = $row['nmkel3'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("kel4")) <> "")
			$this->kel4->CurrentValue = $this->getKey("kel4"); // kel4
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
		// kel1
		// kel2
		// kel3
		// kel4
		// nmkel3

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

		// kel4
		$this->kel4->ViewValue = $this->kel4->CurrentValue;
		$this->kel4->ViewCustomAttributes = "";

		// nmkel3
		$this->nmkel3->ViewValue = $this->nmkel3->CurrentValue;
		$this->nmkel3->ViewCustomAttributes = "";

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

			// kel4
			$this->kel4->LinkCustomAttributes = "";
			$this->kel4->HrefValue = "";
			$this->kel4->TooltipValue = "";

			// nmkel3
			$this->nmkel3->LinkCustomAttributes = "";
			$this->nmkel3->HrefValue = "";
			$this->nmkel3->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// kel1
			$this->kel1->EditAttrs["class"] = "form-control";
			$this->kel1->EditCustomAttributes = "";
			$this->kel1->EditValue = ew_HtmlEncode($this->kel1->CurrentValue);
			$this->kel1->PlaceHolder = ew_RemoveHtml($this->kel1->FldCaption());

			// kel2
			$this->kel2->EditAttrs["class"] = "form-control";
			$this->kel2->EditCustomAttributes = "";
			$this->kel2->EditValue = ew_HtmlEncode($this->kel2->CurrentValue);
			$this->kel2->PlaceHolder = ew_RemoveHtml($this->kel2->FldCaption());

			// kel3
			$this->kel3->EditAttrs["class"] = "form-control";
			$this->kel3->EditCustomAttributes = "";
			$this->kel3->EditValue = ew_HtmlEncode($this->kel3->CurrentValue);
			$this->kel3->PlaceHolder = ew_RemoveHtml($this->kel3->FldCaption());

			// kel4
			$this->kel4->EditAttrs["class"] = "form-control";
			$this->kel4->EditCustomAttributes = "";
			$this->kel4->EditValue = ew_HtmlEncode($this->kel4->CurrentValue);
			$this->kel4->PlaceHolder = ew_RemoveHtml($this->kel4->FldCaption());

			// nmkel3
			$this->nmkel3->EditAttrs["class"] = "form-control";
			$this->nmkel3->EditCustomAttributes = "";
			$this->nmkel3->EditValue = ew_HtmlEncode($this->nmkel3->CurrentValue);
			$this->nmkel3->PlaceHolder = ew_RemoveHtml($this->nmkel3->FldCaption());

			// Add refer script
			// kel1

			$this->kel1->LinkCustomAttributes = "";
			$this->kel1->HrefValue = "";

			// kel2
			$this->kel2->LinkCustomAttributes = "";
			$this->kel2->HrefValue = "";

			// kel3
			$this->kel3->LinkCustomAttributes = "";
			$this->kel3->HrefValue = "";

			// kel4
			$this->kel4->LinkCustomAttributes = "";
			$this->kel4->HrefValue = "";

			// nmkel3
			$this->nmkel3->LinkCustomAttributes = "";
			$this->nmkel3->HrefValue = "";
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
		if (!$this->kel4->FldIsDetailKey && !is_null($this->kel4->FormValue) && $this->kel4->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kel4->FldCaption(), $this->kel4->ReqErrMsg));
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

		// kel1
		$this->kel1->SetDbValueDef($rsnew, $this->kel1->CurrentValue, NULL, FALSE);

		// kel2
		$this->kel2->SetDbValueDef($rsnew, $this->kel2->CurrentValue, NULL, FALSE);

		// kel3
		$this->kel3->SetDbValueDef($rsnew, $this->kel3->CurrentValue, NULL, FALSE);

		// kel4
		$this->kel4->SetDbValueDef($rsnew, $this->kel4->CurrentValue, "", FALSE);

		// nmkel3
		$this->nmkel3->SetDbValueDef($rsnew, $this->nmkel3->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['kel4']) == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("akun3list.php"), "", $this->TableVar, TRUE);
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
if (!isset($akun3_add)) $akun3_add = new cakun3_add();

// Page init
$akun3_add->Page_Init();

// Page main
$akun3_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$akun3_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fakun3add = new ew_Form("fakun3add", "add");

// Validate form
fakun3add.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kel4");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $akun3->kel4->FldCaption(), $akun3->kel4->ReqErrMsg)) ?>");

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
fakun3add.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fakun3add.ValidateRequired = true;
<?php } else { ?>
fakun3add.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$akun3_add->IsModal) { ?>
<?php } ?>
<?php $akun3_add->ShowPageHeader(); ?>
<?php
$akun3_add->ShowMessage();
?>
<form name="fakun3add" id="fakun3add" class="<?php echo $akun3_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($akun3_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $akun3_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="akun3">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($akun3_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($akun3->kel1->Visible) { // kel1 ?>
	<div id="r_kel1" class="form-group">
		<label id="elh_akun3_kel1" for="x_kel1" class="col-sm-2 control-label ewLabel"><?php echo $akun3->kel1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun3->kel1->CellAttributes() ?>>
<span id="el_akun3_kel1">
<input type="text" data-table="akun3" data-field="x_kel1" name="x_kel1" id="x_kel1" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun3->kel1->getPlaceHolder()) ?>" value="<?php echo $akun3->kel1->EditValue ?>"<?php echo $akun3->kel1->EditAttributes() ?>>
</span>
<?php echo $akun3->kel1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun3->kel2->Visible) { // kel2 ?>
	<div id="r_kel2" class="form-group">
		<label id="elh_akun3_kel2" for="x_kel2" class="col-sm-2 control-label ewLabel"><?php echo $akun3->kel2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun3->kel2->CellAttributes() ?>>
<span id="el_akun3_kel2">
<input type="text" data-table="akun3" data-field="x_kel2" name="x_kel2" id="x_kel2" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun3->kel2->getPlaceHolder()) ?>" value="<?php echo $akun3->kel2->EditValue ?>"<?php echo $akun3->kel2->EditAttributes() ?>>
</span>
<?php echo $akun3->kel2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun3->kel3->Visible) { // kel3 ?>
	<div id="r_kel3" class="form-group">
		<label id="elh_akun3_kel3" for="x_kel3" class="col-sm-2 control-label ewLabel"><?php echo $akun3->kel3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun3->kel3->CellAttributes() ?>>
<span id="el_akun3_kel3">
<input type="text" data-table="akun3" data-field="x_kel3" name="x_kel3" id="x_kel3" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun3->kel3->getPlaceHolder()) ?>" value="<?php echo $akun3->kel3->EditValue ?>"<?php echo $akun3->kel3->EditAttributes() ?>>
</span>
<?php echo $akun3->kel3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun3->kel4->Visible) { // kel4 ?>
	<div id="r_kel4" class="form-group">
		<label id="elh_akun3_kel4" for="x_kel4" class="col-sm-2 control-label ewLabel"><?php echo $akun3->kel4->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $akun3->kel4->CellAttributes() ?>>
<span id="el_akun3_kel4">
<input type="text" data-table="akun3" data-field="x_kel4" name="x_kel4" id="x_kel4" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun3->kel4->getPlaceHolder()) ?>" value="<?php echo $akun3->kel4->EditValue ?>"<?php echo $akun3->kel4->EditAttributes() ?>>
</span>
<?php echo $akun3->kel4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun3->nmkel3->Visible) { // nmkel3 ?>
	<div id="r_nmkel3" class="form-group">
		<label id="elh_akun3_nmkel3" for="x_nmkel3" class="col-sm-2 control-label ewLabel"><?php echo $akun3->nmkel3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun3->nmkel3->CellAttributes() ?>>
<span id="el_akun3_nmkel3">
<input type="text" data-table="akun3" data-field="x_nmkel3" name="x_nmkel3" id="x_nmkel3" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun3->nmkel3->getPlaceHolder()) ?>" value="<?php echo $akun3->nmkel3->EditValue ?>"<?php echo $akun3->nmkel3->EditAttributes() ?>>
</span>
<?php echo $akun3->nmkel3->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$akun3_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $akun3_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fakun3add.Init();
</script>
<?php
$akun3_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$akun3_add->Page_Terminate();
?>
