<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pd_tasksinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pd_tasks_add = NULL; // Initialize page object first

class cpd_tasks_add extends cpd_tasks {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pd_tasks';

	// Page object name
	var $PageObjName = 'pd_tasks_add';

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

		// Table object (pd_tasks)
		if (!isset($GLOBALS["pd_tasks"]) || get_class($GLOBALS["pd_tasks"]) == "cpd_tasks") {
			$GLOBALS["pd_tasks"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pd_tasks"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pd_tasks', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("pd_taskslist.php"));
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
		$this->t_title->SetVisibility();
		$this->t_completion->SetVisibility();
		$this->t_urgency->SetVisibility();
		$this->t_order->SetVisibility();

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
		global $EW_EXPORT, $pd_tasks;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pd_tasks);
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
			if (@$_GET["t_id"] != "") {
				$this->t_id->setQueryStringValue($_GET["t_id"]);
				$this->setKey("t_id", $this->t_id->CurrentValue); // Set up key
			} else {
				$this->setKey("t_id", ""); // Clear key
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
					$this->Page_Terminate("pd_taskslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "pd_taskslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "pd_tasksview.php")
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
		$this->t_title->CurrentValue = NULL;
		$this->t_title->OldValue = $this->t_title->CurrentValue;
		$this->t_completion->CurrentValue = NULL;
		$this->t_completion->OldValue = $this->t_completion->CurrentValue;
		$this->t_urgency->CurrentValue = NULL;
		$this->t_urgency->OldValue = $this->t_urgency->CurrentValue;
		$this->t_order->CurrentValue = NULL;
		$this->t_order->OldValue = $this->t_order->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->t_title->FldIsDetailKey) {
			$this->t_title->setFormValue($objForm->GetValue("x_t_title"));
		}
		if (!$this->t_completion->FldIsDetailKey) {
			$this->t_completion->setFormValue($objForm->GetValue("x_t_completion"));
		}
		if (!$this->t_urgency->FldIsDetailKey) {
			$this->t_urgency->setFormValue($objForm->GetValue("x_t_urgency"));
		}
		if (!$this->t_order->FldIsDetailKey) {
			$this->t_order->setFormValue($objForm->GetValue("x_t_order"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->t_title->CurrentValue = $this->t_title->FormValue;
		$this->t_completion->CurrentValue = $this->t_completion->FormValue;
		$this->t_urgency->CurrentValue = $this->t_urgency->FormValue;
		$this->t_order->CurrentValue = $this->t_order->FormValue;
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
		$this->t_id->setDbValue($rs->fields('t_id'));
		$this->t_title->setDbValue($rs->fields('t_title'));
		$this->t_completion->setDbValue($rs->fields('t_completion'));
		$this->t_urgency->setDbValue($rs->fields('t_urgency'));
		$this->t_order->setDbValue($rs->fields('t_order'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->t_id->DbValue = $row['t_id'];
		$this->t_title->DbValue = $row['t_title'];
		$this->t_completion->DbValue = $row['t_completion'];
		$this->t_urgency->DbValue = $row['t_urgency'];
		$this->t_order->DbValue = $row['t_order'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("t_id")) <> "")
			$this->t_id->CurrentValue = $this->getKey("t_id"); // t_id
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
		// Convert decimal values if posted back

		if ($this->t_completion->FormValue == $this->t_completion->CurrentValue && is_numeric(ew_StrToFloat($this->t_completion->CurrentValue)))
			$this->t_completion->CurrentValue = ew_StrToFloat($this->t_completion->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// t_id
		// t_title
		// t_completion
		// t_urgency
		// t_order

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// t_id
		$this->t_id->ViewValue = $this->t_id->CurrentValue;
		$this->t_id->ViewCustomAttributes = "";

		// t_title
		$this->t_title->ViewValue = $this->t_title->CurrentValue;
		$this->t_title->ViewCustomAttributes = "";

		// t_completion
		$this->t_completion->ViewValue = $this->t_completion->CurrentValue;
		$this->t_completion->ViewCustomAttributes = "";

		// t_urgency
		$this->t_urgency->ViewValue = $this->t_urgency->CurrentValue;
		$this->t_urgency->ViewCustomAttributes = "";

		// t_order
		$this->t_order->ViewValue = $this->t_order->CurrentValue;
		$this->t_order->ViewCustomAttributes = "";

			// t_title
			$this->t_title->LinkCustomAttributes = "";
			$this->t_title->HrefValue = "";
			$this->t_title->TooltipValue = "";

			// t_completion
			$this->t_completion->LinkCustomAttributes = "";
			$this->t_completion->HrefValue = "";
			$this->t_completion->TooltipValue = "";

			// t_urgency
			$this->t_urgency->LinkCustomAttributes = "";
			$this->t_urgency->HrefValue = "";
			$this->t_urgency->TooltipValue = "";

			// t_order
			$this->t_order->LinkCustomAttributes = "";
			$this->t_order->HrefValue = "";
			$this->t_order->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// t_title
			$this->t_title->EditAttrs["class"] = "form-control";
			$this->t_title->EditCustomAttributes = "";
			$this->t_title->EditValue = ew_HtmlEncode($this->t_title->CurrentValue);
			$this->t_title->PlaceHolder = ew_RemoveHtml($this->t_title->FldCaption());

			// t_completion
			$this->t_completion->EditAttrs["class"] = "form-control";
			$this->t_completion->EditCustomAttributes = "";
			$this->t_completion->EditValue = ew_HtmlEncode($this->t_completion->CurrentValue);
			$this->t_completion->PlaceHolder = ew_RemoveHtml($this->t_completion->FldCaption());
			if (strval($this->t_completion->EditValue) <> "" && is_numeric($this->t_completion->EditValue)) $this->t_completion->EditValue = ew_FormatNumber($this->t_completion->EditValue, -2, -1, -2, 0);

			// t_urgency
			$this->t_urgency->EditAttrs["class"] = "form-control";
			$this->t_urgency->EditCustomAttributes = "";
			$this->t_urgency->EditValue = ew_HtmlEncode($this->t_urgency->CurrentValue);
			$this->t_urgency->PlaceHolder = ew_RemoveHtml($this->t_urgency->FldCaption());

			// t_order
			$this->t_order->EditAttrs["class"] = "form-control";
			$this->t_order->EditCustomAttributes = "";
			$this->t_order->EditValue = ew_HtmlEncode($this->t_order->CurrentValue);
			$this->t_order->PlaceHolder = ew_RemoveHtml($this->t_order->FldCaption());

			// Add refer script
			// t_title

			$this->t_title->LinkCustomAttributes = "";
			$this->t_title->HrefValue = "";

			// t_completion
			$this->t_completion->LinkCustomAttributes = "";
			$this->t_completion->HrefValue = "";

			// t_urgency
			$this->t_urgency->LinkCustomAttributes = "";
			$this->t_urgency->HrefValue = "";

			// t_order
			$this->t_order->LinkCustomAttributes = "";
			$this->t_order->HrefValue = "";
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
		if (!ew_CheckNumber($this->t_completion->FormValue)) {
			ew_AddMessage($gsFormError, $this->t_completion->FldErrMsg());
		}
		if (!ew_CheckInteger($this->t_urgency->FormValue)) {
			ew_AddMessage($gsFormError, $this->t_urgency->FldErrMsg());
		}
		if (!ew_CheckInteger($this->t_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->t_order->FldErrMsg());
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

		// t_title
		$this->t_title->SetDbValueDef($rsnew, $this->t_title->CurrentValue, NULL, FALSE);

		// t_completion
		$this->t_completion->SetDbValueDef($rsnew, $this->t_completion->CurrentValue, NULL, FALSE);

		// t_urgency
		$this->t_urgency->SetDbValueDef($rsnew, $this->t_urgency->CurrentValue, NULL, FALSE);

		// t_order
		$this->t_order->SetDbValueDef($rsnew, $this->t_order->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pd_taskslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($pd_tasks_add)) $pd_tasks_add = new cpd_tasks_add();

// Page init
$pd_tasks_add->Page_Init();

// Page main
$pd_tasks_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pd_tasks_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpd_tasksadd = new ew_Form("fpd_tasksadd", "add");

// Validate form
fpd_tasksadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_t_completion");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pd_tasks->t_completion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_t_urgency");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pd_tasks->t_urgency->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_t_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pd_tasks->t_order->FldErrMsg()) ?>");

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
fpd_tasksadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpd_tasksadd.ValidateRequired = true;
<?php } else { ?>
fpd_tasksadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$pd_tasks_add->IsModal) { ?>
<?php } ?>
<?php $pd_tasks_add->ShowPageHeader(); ?>
<?php
$pd_tasks_add->ShowMessage();
?>
<form name="fpd_tasksadd" id="fpd_tasksadd" class="<?php echo $pd_tasks_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pd_tasks_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pd_tasks_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pd_tasks">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($pd_tasks_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($pd_tasks->t_title->Visible) { // t_title ?>
	<div id="r_t_title" class="form-group">
		<label id="elh_pd_tasks_t_title" for="x_t_title" class="col-sm-2 control-label ewLabel"><?php echo $pd_tasks->t_title->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_tasks->t_title->CellAttributes() ?>>
<span id="el_pd_tasks_t_title">
<input type="text" data-table="pd_tasks" data-field="x_t_title" name="x_t_title" id="x_t_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($pd_tasks->t_title->getPlaceHolder()) ?>" value="<?php echo $pd_tasks->t_title->EditValue ?>"<?php echo $pd_tasks->t_title->EditAttributes() ?>>
</span>
<?php echo $pd_tasks->t_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_tasks->t_completion->Visible) { // t_completion ?>
	<div id="r_t_completion" class="form-group">
		<label id="elh_pd_tasks_t_completion" for="x_t_completion" class="col-sm-2 control-label ewLabel"><?php echo $pd_tasks->t_completion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_tasks->t_completion->CellAttributes() ?>>
<span id="el_pd_tasks_t_completion">
<input type="text" data-table="pd_tasks" data-field="x_t_completion" name="x_t_completion" id="x_t_completion" size="30" placeholder="<?php echo ew_HtmlEncode($pd_tasks->t_completion->getPlaceHolder()) ?>" value="<?php echo $pd_tasks->t_completion->EditValue ?>"<?php echo $pd_tasks->t_completion->EditAttributes() ?>>
</span>
<?php echo $pd_tasks->t_completion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_tasks->t_urgency->Visible) { // t_urgency ?>
	<div id="r_t_urgency" class="form-group">
		<label id="elh_pd_tasks_t_urgency" for="x_t_urgency" class="col-sm-2 control-label ewLabel"><?php echo $pd_tasks->t_urgency->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_tasks->t_urgency->CellAttributes() ?>>
<span id="el_pd_tasks_t_urgency">
<input type="text" data-table="pd_tasks" data-field="x_t_urgency" name="x_t_urgency" id="x_t_urgency" size="30" placeholder="<?php echo ew_HtmlEncode($pd_tasks->t_urgency->getPlaceHolder()) ?>" value="<?php echo $pd_tasks->t_urgency->EditValue ?>"<?php echo $pd_tasks->t_urgency->EditAttributes() ?>>
</span>
<?php echo $pd_tasks->t_urgency->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_tasks->t_order->Visible) { // t_order ?>
	<div id="r_t_order" class="form-group">
		<label id="elh_pd_tasks_t_order" for="x_t_order" class="col-sm-2 control-label ewLabel"><?php echo $pd_tasks->t_order->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_tasks->t_order->CellAttributes() ?>>
<span id="el_pd_tasks_t_order">
<input type="text" data-table="pd_tasks" data-field="x_t_order" name="x_t_order" id="x_t_order" size="30" placeholder="<?php echo ew_HtmlEncode($pd_tasks->t_order->getPlaceHolder()) ?>" value="<?php echo $pd_tasks->t_order->EditValue ?>"<?php echo $pd_tasks->t_order->EditAttributes() ?>>
</span>
<?php echo $pd_tasks->t_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$pd_tasks_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pd_tasks_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpd_tasksadd.Init();
</script>
<?php
$pd_tasks_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pd_tasks_add->Page_Terminate();
?>
