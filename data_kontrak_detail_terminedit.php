<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "data_kontrak_detail_termininfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$data_kontrak_detail_termin_edit = NULL; // Initialize page object first

class cdata_kontrak_detail_termin_edit extends cdata_kontrak_detail_termin {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'data_kontrak_detail_termin';

	// Page object name
	var $PageObjName = 'data_kontrak_detail_termin_edit';

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

		// Table object (data_kontrak_detail_termin)
		if (!isset($GLOBALS["data_kontrak_detail_termin"]) || get_class($GLOBALS["data_kontrak_detail_termin"]) == "cdata_kontrak_detail_termin") {
			$GLOBALS["data_kontrak_detail_termin"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["data_kontrak_detail_termin"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'data_kontrak_detail_termin', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("data_kontrak_detail_terminlist.php"));
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
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->terminke->SetVisibility();
		$this->target_fisik->SetVisibility();
		$this->nilai->SetVisibility();
		$this->id_detail->SetVisibility();

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
		global $EW_EXPORT, $data_kontrak_detail_termin;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($data_kontrak_detail_termin);
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
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("data_kontrak_detail_terminlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("data_kontrak_detail_terminlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "data_kontrak_detail_terminlist.php")
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
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->terminke->FldIsDetailKey) {
			$this->terminke->setFormValue($objForm->GetValue("x_terminke"));
		}
		if (!$this->target_fisik->FldIsDetailKey) {
			$this->target_fisik->setFormValue($objForm->GetValue("x_target_fisik"));
		}
		if (!$this->nilai->FldIsDetailKey) {
			$this->nilai->setFormValue($objForm->GetValue("x_nilai"));
		}
		if (!$this->id_detail->FldIsDetailKey) {
			$this->id_detail->setFormValue($objForm->GetValue("x_id_detail"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->terminke->CurrentValue = $this->terminke->FormValue;
		$this->target_fisik->CurrentValue = $this->target_fisik->FormValue;
		$this->nilai->CurrentValue = $this->nilai->FormValue;
		$this->id_detail->CurrentValue = $this->id_detail->FormValue;
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
		$this->terminke->setDbValue($rs->fields('terminke'));
		$this->target_fisik->setDbValue($rs->fields('target_fisik'));
		$this->nilai->setDbValue($rs->fields('nilai'));
		$this->id_detail->setDbValue($rs->fields('id_detail'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->terminke->DbValue = $row['terminke'];
		$this->target_fisik->DbValue = $row['target_fisik'];
		$this->nilai->DbValue = $row['nilai'];
		$this->id_detail->DbValue = $row['id_detail'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->target_fisik->FormValue == $this->target_fisik->CurrentValue && is_numeric(ew_StrToFloat($this->target_fisik->CurrentValue)))
			$this->target_fisik->CurrentValue = ew_StrToFloat($this->target_fisik->CurrentValue);

		// Convert decimal values if posted back
		if ($this->nilai->FormValue == $this->nilai->CurrentValue && is_numeric(ew_StrToFloat($this->nilai->CurrentValue)))
			$this->nilai->CurrentValue = ew_StrToFloat($this->nilai->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// terminke
		// target_fisik
		// nilai
		// id_detail

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// terminke
		$this->terminke->ViewValue = $this->terminke->CurrentValue;
		$this->terminke->ViewCustomAttributes = "";

		// target_fisik
		$this->target_fisik->ViewValue = $this->target_fisik->CurrentValue;
		$this->target_fisik->ViewCustomAttributes = "";

		// nilai
		$this->nilai->ViewValue = $this->nilai->CurrentValue;
		$this->nilai->ViewCustomAttributes = "";

		// id_detail
		$this->id_detail->ViewValue = $this->id_detail->CurrentValue;
		$this->id_detail->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// terminke
			$this->terminke->LinkCustomAttributes = "";
			$this->terminke->HrefValue = "";
			$this->terminke->TooltipValue = "";

			// target_fisik
			$this->target_fisik->LinkCustomAttributes = "";
			$this->target_fisik->HrefValue = "";
			$this->target_fisik->TooltipValue = "";

			// nilai
			$this->nilai->LinkCustomAttributes = "";
			$this->nilai->HrefValue = "";
			$this->nilai->TooltipValue = "";

			// id_detail
			$this->id_detail->LinkCustomAttributes = "";
			$this->id_detail->HrefValue = "";
			$this->id_detail->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// terminke
			$this->terminke->EditAttrs["class"] = "form-control";
			$this->terminke->EditCustomAttributes = "";
			$this->terminke->EditValue = ew_HtmlEncode($this->terminke->CurrentValue);
			$this->terminke->PlaceHolder = ew_RemoveHtml($this->terminke->FldCaption());

			// target_fisik
			$this->target_fisik->EditAttrs["class"] = "form-control";
			$this->target_fisik->EditCustomAttributes = "";
			$this->target_fisik->EditValue = ew_HtmlEncode($this->target_fisik->CurrentValue);
			$this->target_fisik->PlaceHolder = ew_RemoveHtml($this->target_fisik->FldCaption());
			if (strval($this->target_fisik->EditValue) <> "" && is_numeric($this->target_fisik->EditValue)) $this->target_fisik->EditValue = ew_FormatNumber($this->target_fisik->EditValue, -2, -1, -2, 0);

			// nilai
			$this->nilai->EditAttrs["class"] = "form-control";
			$this->nilai->EditCustomAttributes = "";
			$this->nilai->EditValue = ew_HtmlEncode($this->nilai->CurrentValue);
			$this->nilai->PlaceHolder = ew_RemoveHtml($this->nilai->FldCaption());
			if (strval($this->nilai->EditValue) <> "" && is_numeric($this->nilai->EditValue)) $this->nilai->EditValue = ew_FormatNumber($this->nilai->EditValue, -2, -1, -2, 0);

			// id_detail
			$this->id_detail->EditAttrs["class"] = "form-control";
			$this->id_detail->EditCustomAttributes = "";
			$this->id_detail->EditValue = ew_HtmlEncode($this->id_detail->CurrentValue);
			$this->id_detail->PlaceHolder = ew_RemoveHtml($this->id_detail->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// terminke
			$this->terminke->LinkCustomAttributes = "";
			$this->terminke->HrefValue = "";

			// target_fisik
			$this->target_fisik->LinkCustomAttributes = "";
			$this->target_fisik->HrefValue = "";

			// nilai
			$this->nilai->LinkCustomAttributes = "";
			$this->nilai->HrefValue = "";

			// id_detail
			$this->id_detail->LinkCustomAttributes = "";
			$this->id_detail->HrefValue = "";
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
		if (!ew_CheckInteger($this->terminke->FormValue)) {
			ew_AddMessage($gsFormError, $this->terminke->FldErrMsg());
		}
		if (!ew_CheckNumber($this->target_fisik->FormValue)) {
			ew_AddMessage($gsFormError, $this->target_fisik->FldErrMsg());
		}
		if (!ew_CheckNumber($this->nilai->FormValue)) {
			ew_AddMessage($gsFormError, $this->nilai->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_detail->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_detail->FldErrMsg());
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

			// terminke
			$this->terminke->SetDbValueDef($rsnew, $this->terminke->CurrentValue, NULL, $this->terminke->ReadOnly);

			// target_fisik
			$this->target_fisik->SetDbValueDef($rsnew, $this->target_fisik->CurrentValue, NULL, $this->target_fisik->ReadOnly);

			// nilai
			$this->nilai->SetDbValueDef($rsnew, $this->nilai->CurrentValue, NULL, $this->nilai->ReadOnly);

			// id_detail
			$this->id_detail->SetDbValueDef($rsnew, $this->id_detail->CurrentValue, NULL, $this->id_detail->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("data_kontrak_detail_terminlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($data_kontrak_detail_termin_edit)) $data_kontrak_detail_termin_edit = new cdata_kontrak_detail_termin_edit();

// Page init
$data_kontrak_detail_termin_edit->Page_Init();

// Page main
$data_kontrak_detail_termin_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$data_kontrak_detail_termin_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fdata_kontrak_detail_terminedit = new ew_Form("fdata_kontrak_detail_terminedit", "edit");

// Validate form
fdata_kontrak_detail_terminedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_terminke");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->terminke->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_target_fisik");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->target_fisik->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nilai");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->nilai->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_detail");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($data_kontrak_detail_termin->id_detail->FldErrMsg()) ?>");

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
fdata_kontrak_detail_terminedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdata_kontrak_detail_terminedit.ValidateRequired = true;
<?php } else { ?>
fdata_kontrak_detail_terminedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$data_kontrak_detail_termin_edit->IsModal) { ?>
<?php } ?>
<?php $data_kontrak_detail_termin_edit->ShowPageHeader(); ?>
<?php
$data_kontrak_detail_termin_edit->ShowMessage();
?>
<form name="fdata_kontrak_detail_terminedit" id="fdata_kontrak_detail_terminedit" class="<?php echo $data_kontrak_detail_termin_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($data_kontrak_detail_termin_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $data_kontrak_detail_termin_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="data_kontrak_detail_termin">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($data_kontrak_detail_termin_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($data_kontrak_detail_termin->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_data_kontrak_detail_termin_id" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak_detail_termin->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak_detail_termin->id->CellAttributes() ?>>
<span id="el_data_kontrak_detail_termin_id">
<span<?php echo $data_kontrak_detail_termin->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $data_kontrak_detail_termin->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="data_kontrak_detail_termin" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id->CurrentValue) ?>">
<?php echo $data_kontrak_detail_termin->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak_detail_termin->terminke->Visible) { // terminke ?>
	<div id="r_terminke" class="form-group">
		<label id="elh_data_kontrak_detail_termin_terminke" for="x_terminke" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak_detail_termin->terminke->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak_detail_termin->terminke->CellAttributes() ?>>
<span id="el_data_kontrak_detail_termin_terminke">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_terminke" name="x_terminke" id="x_terminke" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->terminke->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->terminke->EditValue ?>"<?php echo $data_kontrak_detail_termin->terminke->EditAttributes() ?>>
</span>
<?php echo $data_kontrak_detail_termin->terminke->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak_detail_termin->target_fisik->Visible) { // target_fisik ?>
	<div id="r_target_fisik" class="form-group">
		<label id="elh_data_kontrak_detail_termin_target_fisik" for="x_target_fisik" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak_detail_termin->target_fisik->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak_detail_termin->target_fisik->CellAttributes() ?>>
<span id="el_data_kontrak_detail_termin_target_fisik">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_target_fisik" name="x_target_fisik" id="x_target_fisik" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->target_fisik->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->target_fisik->EditValue ?>"<?php echo $data_kontrak_detail_termin->target_fisik->EditAttributes() ?>>
</span>
<?php echo $data_kontrak_detail_termin->target_fisik->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak_detail_termin->nilai->Visible) { // nilai ?>
	<div id="r_nilai" class="form-group">
		<label id="elh_data_kontrak_detail_termin_nilai" for="x_nilai" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak_detail_termin->nilai->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak_detail_termin->nilai->CellAttributes() ?>>
<span id="el_data_kontrak_detail_termin_nilai">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_nilai" name="x_nilai" id="x_nilai" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->nilai->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->nilai->EditValue ?>"<?php echo $data_kontrak_detail_termin->nilai->EditAttributes() ?>>
</span>
<?php echo $data_kontrak_detail_termin->nilai->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($data_kontrak_detail_termin->id_detail->Visible) { // id_detail ?>
	<div id="r_id_detail" class="form-group">
		<label id="elh_data_kontrak_detail_termin_id_detail" for="x_id_detail" class="col-sm-2 control-label ewLabel"><?php echo $data_kontrak_detail_termin->id_detail->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $data_kontrak_detail_termin->id_detail->CellAttributes() ?>>
<span id="el_data_kontrak_detail_termin_id_detail">
<input type="text" data-table="data_kontrak_detail_termin" data-field="x_id_detail" name="x_id_detail" id="x_id_detail" size="30" placeholder="<?php echo ew_HtmlEncode($data_kontrak_detail_termin->id_detail->getPlaceHolder()) ?>" value="<?php echo $data_kontrak_detail_termin->id_detail->EditValue ?>"<?php echo $data_kontrak_detail_termin->id_detail->EditAttributes() ?>>
</span>
<?php echo $data_kontrak_detail_termin->id_detail->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$data_kontrak_detail_termin_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $data_kontrak_detail_termin_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdata_kontrak_detail_terminedit.Init();
</script>
<?php
$data_kontrak_detail_termin_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$data_kontrak_detail_termin_edit->Page_Terminate();
?>
