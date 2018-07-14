<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "pd_notificationsinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$pd_notifications_edit = NULL; // Initialize page object first

class cpd_notifications_edit extends cpd_notifications {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'pd_notifications';

	// Page object name
	var $PageObjName = 'pd_notifications_edit';

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

		// Table object (pd_notifications)
		if (!isset($GLOBALS["pd_notifications"]) || get_class($GLOBALS["pd_notifications"]) == "cpd_notifications") {
			$GLOBALS["pd_notifications"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pd_notifications"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'pd_notifications', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("pd_notificationslist.php"));
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
		$this->n_id->SetVisibility();
		$this->n_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->n_datetime->SetVisibility();
		$this->n_content->SetVisibility();
		$this->n_targetlevel->SetVisibility();

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
		global $EW_EXPORT, $pd_notifications;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($pd_notifications);
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

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

		// Load key from QueryString
		if (@$_GET["n_id"] <> "") {
			$this->n_id->setQueryStringValue($_GET["n_id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->n_id->CurrentValue == "") {
			$this->Page_Terminate("pd_notificationslist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("pd_notificationslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "pd_notificationslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->n_id->FldIsDetailKey)
			$this->n_id->setFormValue($objForm->GetValue("x_n_id"));
		if (!$this->n_datetime->FldIsDetailKey) {
			$this->n_datetime->setFormValue($objForm->GetValue("x_n_datetime"));
			$this->n_datetime->CurrentValue = ew_UnFormatDateTime($this->n_datetime->CurrentValue, 0);
		}
		if (!$this->n_content->FldIsDetailKey) {
			$this->n_content->setFormValue($objForm->GetValue("x_n_content"));
		}
		if (!$this->n_targetlevel->FldIsDetailKey) {
			$this->n_targetlevel->setFormValue($objForm->GetValue("x_n_targetlevel"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->n_id->CurrentValue = $this->n_id->FormValue;
		$this->n_datetime->CurrentValue = $this->n_datetime->FormValue;
		$this->n_datetime->CurrentValue = ew_UnFormatDateTime($this->n_datetime->CurrentValue, 0);
		$this->n_content->CurrentValue = $this->n_content->FormValue;
		$this->n_targetlevel->CurrentValue = $this->n_targetlevel->FormValue;
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
		$this->n_id->setDbValue($rs->fields('n_id'));
		$this->n_datetime->setDbValue($rs->fields('n_datetime'));
		$this->n_content->setDbValue($rs->fields('n_content'));
		$this->n_targetlevel->setDbValue($rs->fields('n_targetlevel'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->n_id->DbValue = $row['n_id'];
		$this->n_datetime->DbValue = $row['n_datetime'];
		$this->n_content->DbValue = $row['n_content'];
		$this->n_targetlevel->DbValue = $row['n_targetlevel'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// n_id
		// n_datetime
		// n_content
		// n_targetlevel

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// n_id
		$this->n_id->ViewValue = $this->n_id->CurrentValue;
		$this->n_id->ViewCustomAttributes = "";

		// n_datetime
		$this->n_datetime->ViewValue = $this->n_datetime->CurrentValue;
		$this->n_datetime->ViewValue = ew_FormatDateTime($this->n_datetime->ViewValue, 0);
		$this->n_datetime->ViewCustomAttributes = "";

		// n_content
		$this->n_content->ViewValue = $this->n_content->CurrentValue;
		$this->n_content->ViewCustomAttributes = "";

		// n_targetlevel
		$this->n_targetlevel->ViewValue = $this->n_targetlevel->CurrentValue;
		$this->n_targetlevel->ViewCustomAttributes = "";

			// n_id
			$this->n_id->LinkCustomAttributes = "";
			$this->n_id->HrefValue = "";
			$this->n_id->TooltipValue = "";

			// n_datetime
			$this->n_datetime->LinkCustomAttributes = "";
			$this->n_datetime->HrefValue = "";
			$this->n_datetime->TooltipValue = "";

			// n_content
			$this->n_content->LinkCustomAttributes = "";
			$this->n_content->HrefValue = "";
			$this->n_content->TooltipValue = "";

			// n_targetlevel
			$this->n_targetlevel->LinkCustomAttributes = "";
			$this->n_targetlevel->HrefValue = "";
			$this->n_targetlevel->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// n_id
			$this->n_id->EditAttrs["class"] = "form-control";
			$this->n_id->EditCustomAttributes = "";
			$this->n_id->EditValue = $this->n_id->CurrentValue;
			$this->n_id->ViewCustomAttributes = "";

			// n_datetime
			$this->n_datetime->EditAttrs["class"] = "form-control";
			$this->n_datetime->EditCustomAttributes = "";
			$this->n_datetime->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->n_datetime->CurrentValue, 8));
			$this->n_datetime->PlaceHolder = ew_RemoveHtml($this->n_datetime->FldCaption());

			// n_content
			$this->n_content->EditAttrs["class"] = "form-control";
			$this->n_content->EditCustomAttributes = "";
			$this->n_content->EditValue = ew_HtmlEncode($this->n_content->CurrentValue);
			$this->n_content->PlaceHolder = ew_RemoveHtml($this->n_content->FldCaption());

			// n_targetlevel
			$this->n_targetlevel->EditAttrs["class"] = "form-control";
			$this->n_targetlevel->EditCustomAttributes = "";
			$this->n_targetlevel->EditValue = ew_HtmlEncode($this->n_targetlevel->CurrentValue);
			$this->n_targetlevel->PlaceHolder = ew_RemoveHtml($this->n_targetlevel->FldCaption());

			// Edit refer script
			// n_id

			$this->n_id->LinkCustomAttributes = "";
			$this->n_id->HrefValue = "";

			// n_datetime
			$this->n_datetime->LinkCustomAttributes = "";
			$this->n_datetime->HrefValue = "";

			// n_content
			$this->n_content->LinkCustomAttributes = "";
			$this->n_content->HrefValue = "";

			// n_targetlevel
			$this->n_targetlevel->LinkCustomAttributes = "";
			$this->n_targetlevel->HrefValue = "";
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
		if (!ew_CheckDateDef($this->n_datetime->FormValue)) {
			ew_AddMessage($gsFormError, $this->n_datetime->FldErrMsg());
		}
		if (!ew_CheckInteger($this->n_targetlevel->FormValue)) {
			ew_AddMessage($gsFormError, $this->n_targetlevel->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// n_datetime
			$this->n_datetime->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->n_datetime->CurrentValue, 0), NULL, $this->n_datetime->ReadOnly);

			// n_content
			$this->n_content->SetDbValueDef($rsnew, $this->n_content->CurrentValue, NULL, $this->n_content->ReadOnly);

			// n_targetlevel
			$this->n_targetlevel->SetDbValueDef($rsnew, $this->n_targetlevel->CurrentValue, NULL, $this->n_targetlevel->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("pd_notificationslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($pd_notifications_edit)) $pd_notifications_edit = new cpd_notifications_edit();

// Page init
$pd_notifications_edit->Page_Init();

// Page main
$pd_notifications_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$pd_notifications_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fpd_notificationsedit = new ew_Form("fpd_notificationsedit", "edit");

// Validate form
fpd_notificationsedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_n_datetime");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pd_notifications->n_datetime->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_n_targetlevel");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($pd_notifications->n_targetlevel->FldErrMsg()) ?>");

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
fpd_notificationsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpd_notificationsedit.ValidateRequired = true;
<?php } else { ?>
fpd_notificationsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$pd_notifications_edit->IsModal) { ?>
<?php } ?>
<?php $pd_notifications_edit->ShowPageHeader(); ?>
<?php
$pd_notifications_edit->ShowMessage();
?>
<form name="fpd_notificationsedit" id="fpd_notificationsedit" class="<?php echo $pd_notifications_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($pd_notifications_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $pd_notifications_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="pd_notifications">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($pd_notifications_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($pd_notifications->n_id->Visible) { // n_id ?>
	<div id="r_n_id" class="form-group">
		<label id="elh_pd_notifications_n_id" class="col-sm-2 control-label ewLabel"><?php echo $pd_notifications->n_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_notifications->n_id->CellAttributes() ?>>
<span id="el_pd_notifications_n_id">
<span<?php echo $pd_notifications->n_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $pd_notifications->n_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="pd_notifications" data-field="x_n_id" name="x_n_id" id="x_n_id" value="<?php echo ew_HtmlEncode($pd_notifications->n_id->CurrentValue) ?>">
<?php echo $pd_notifications->n_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_notifications->n_datetime->Visible) { // n_datetime ?>
	<div id="r_n_datetime" class="form-group">
		<label id="elh_pd_notifications_n_datetime" for="x_n_datetime" class="col-sm-2 control-label ewLabel"><?php echo $pd_notifications->n_datetime->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_notifications->n_datetime->CellAttributes() ?>>
<span id="el_pd_notifications_n_datetime">
<input type="text" data-table="pd_notifications" data-field="x_n_datetime" name="x_n_datetime" id="x_n_datetime" placeholder="<?php echo ew_HtmlEncode($pd_notifications->n_datetime->getPlaceHolder()) ?>" value="<?php echo $pd_notifications->n_datetime->EditValue ?>"<?php echo $pd_notifications->n_datetime->EditAttributes() ?>>
</span>
<?php echo $pd_notifications->n_datetime->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_notifications->n_content->Visible) { // n_content ?>
	<div id="r_n_content" class="form-group">
		<label id="elh_pd_notifications_n_content" for="x_n_content" class="col-sm-2 control-label ewLabel"><?php echo $pd_notifications->n_content->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_notifications->n_content->CellAttributes() ?>>
<span id="el_pd_notifications_n_content">
<textarea data-table="pd_notifications" data-field="x_n_content" name="x_n_content" id="x_n_content" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($pd_notifications->n_content->getPlaceHolder()) ?>"<?php echo $pd_notifications->n_content->EditAttributes() ?>><?php echo $pd_notifications->n_content->EditValue ?></textarea>
</span>
<?php echo $pd_notifications->n_content->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($pd_notifications->n_targetlevel->Visible) { // n_targetlevel ?>
	<div id="r_n_targetlevel" class="form-group">
		<label id="elh_pd_notifications_n_targetlevel" for="x_n_targetlevel" class="col-sm-2 control-label ewLabel"><?php echo $pd_notifications->n_targetlevel->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $pd_notifications->n_targetlevel->CellAttributes() ?>>
<span id="el_pd_notifications_n_targetlevel">
<input type="text" data-table="pd_notifications" data-field="x_n_targetlevel" name="x_n_targetlevel" id="x_n_targetlevel" size="30" placeholder="<?php echo ew_HtmlEncode($pd_notifications->n_targetlevel->getPlaceHolder()) ?>" value="<?php echo $pd_notifications->n_targetlevel->EditValue ?>"<?php echo $pd_notifications->n_targetlevel->EditAttributes() ?>>
</span>
<?php echo $pd_notifications->n_targetlevel->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$pd_notifications_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $pd_notifications_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fpd_notificationsedit.Init();
</script>
<?php
$pd_notifications_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$pd_notifications_edit->Page_Terminate();
?>
