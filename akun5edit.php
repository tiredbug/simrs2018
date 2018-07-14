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

$akun5_edit = NULL; // Initialize page object first

class cakun5_edit extends cakun5 {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'akun5';

	// Page object name
	var $PageObjName = 'akun5_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

		// Create form object
		$objForm = new cFormObj();
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
		if (@$_GET["kel6"] <> "") {
			$this->kel6->setQueryStringValue($_GET["kel6"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->kel6->CurrentValue == "") {
			$this->Page_Terminate("akun5list.php"); // Invalid key, return to list
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
					$this->Page_Terminate("akun5list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "akun5list.php")
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
		if (!$this->kel1->FldIsDetailKey) {
			$this->kel1->setFormValue($objForm->GetValue("x_kel1"));
		}
		if (!$this->kel2->FldIsDetailKey) {
			$this->kel2->setFormValue($objForm->GetValue("x_kel2"));
		}
		if (!$this->kel3->FldIsDetailKey) {
			$this->kel3->setFormValue($objForm->GetValue("x_kel3"));
		}
		if (!$this->kel41->FldIsDetailKey) {
			$this->kel41->setFormValue($objForm->GetValue("x_kel41"));
		}
		if (!$this->kel4->FldIsDetailKey) {
			$this->kel4->setFormValue($objForm->GetValue("x_kel4"));
		}
		if (!$this->kel5->FldIsDetailKey) {
			$this->kel5->setFormValue($objForm->GetValue("x_kel5"));
		}
		if (!$this->kel6->FldIsDetailKey) {
			$this->kel6->setFormValue($objForm->GetValue("x_kel6"));
		}
		if (!$this->nmkel5->FldIsDetailKey) {
			$this->nmkel5->setFormValue($objForm->GetValue("x_nmkel5"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->kel1->CurrentValue = $this->kel1->FormValue;
		$this->kel2->CurrentValue = $this->kel2->FormValue;
		$this->kel3->CurrentValue = $this->kel3->FormValue;
		$this->kel41->CurrentValue = $this->kel41->FormValue;
		$this->kel4->CurrentValue = $this->kel4->FormValue;
		$this->kel5->CurrentValue = $this->kel5->FormValue;
		$this->kel6->CurrentValue = $this->kel6->FormValue;
		$this->nmkel5->CurrentValue = $this->nmkel5->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// kel41
			$this->kel41->EditAttrs["class"] = "form-control";
			$this->kel41->EditCustomAttributes = "";
			$this->kel41->EditValue = ew_HtmlEncode($this->kel41->CurrentValue);
			$this->kel41->PlaceHolder = ew_RemoveHtml($this->kel41->FldCaption());

			// kel4
			$this->kel4->EditAttrs["class"] = "form-control";
			$this->kel4->EditCustomAttributes = "";
			$this->kel4->EditValue = ew_HtmlEncode($this->kel4->CurrentValue);
			$this->kel4->PlaceHolder = ew_RemoveHtml($this->kel4->FldCaption());

			// kel5
			$this->kel5->EditAttrs["class"] = "form-control";
			$this->kel5->EditCustomAttributes = "";
			$this->kel5->EditValue = ew_HtmlEncode($this->kel5->CurrentValue);
			$this->kel5->PlaceHolder = ew_RemoveHtml($this->kel5->FldCaption());

			// kel6
			$this->kel6->EditAttrs["class"] = "form-control";
			$this->kel6->EditCustomAttributes = "";
			$this->kel6->EditValue = $this->kel6->CurrentValue;
			$this->kel6->ViewCustomAttributes = "";

			// nmkel5
			$this->nmkel5->EditAttrs["class"] = "form-control";
			$this->nmkel5->EditCustomAttributes = "";
			$this->nmkel5->EditValue = ew_HtmlEncode($this->nmkel5->CurrentValue);
			$this->nmkel5->PlaceHolder = ew_RemoveHtml($this->nmkel5->FldCaption());

			// Edit refer script
			// kel1

			$this->kel1->LinkCustomAttributes = "";
			$this->kel1->HrefValue = "";

			// kel2
			$this->kel2->LinkCustomAttributes = "";
			$this->kel2->HrefValue = "";

			// kel3
			$this->kel3->LinkCustomAttributes = "";
			$this->kel3->HrefValue = "";

			// kel41
			$this->kel41->LinkCustomAttributes = "";
			$this->kel41->HrefValue = "";

			// kel4
			$this->kel4->LinkCustomAttributes = "";
			$this->kel4->HrefValue = "";

			// kel5
			$this->kel5->LinkCustomAttributes = "";
			$this->kel5->HrefValue = "";

			// kel6
			$this->kel6->LinkCustomAttributes = "";
			$this->kel6->HrefValue = "";

			// nmkel5
			$this->nmkel5->LinkCustomAttributes = "";
			$this->nmkel5->HrefValue = "";
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
		if (!$this->kel6->FldIsDetailKey && !is_null($this->kel6->FormValue) && $this->kel6->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kel6->FldCaption(), $this->kel6->ReqErrMsg));
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

			// kel1
			$this->kel1->SetDbValueDef($rsnew, $this->kel1->CurrentValue, NULL, $this->kel1->ReadOnly);

			// kel2
			$this->kel2->SetDbValueDef($rsnew, $this->kel2->CurrentValue, NULL, $this->kel2->ReadOnly);

			// kel3
			$this->kel3->SetDbValueDef($rsnew, $this->kel3->CurrentValue, NULL, $this->kel3->ReadOnly);

			// kel41
			$this->kel41->SetDbValueDef($rsnew, $this->kel41->CurrentValue, NULL, $this->kel41->ReadOnly);

			// kel4
			$this->kel4->SetDbValueDef($rsnew, $this->kel4->CurrentValue, NULL, $this->kel4->ReadOnly);

			// kel5
			$this->kel5->SetDbValueDef($rsnew, $this->kel5->CurrentValue, NULL, $this->kel5->ReadOnly);

			// kel6
			// nmkel5

			$this->nmkel5->SetDbValueDef($rsnew, $this->nmkel5->CurrentValue, NULL, $this->nmkel5->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("akun5list.php"), "", $this->TableVar, TRUE);
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
if (!isset($akun5_edit)) $akun5_edit = new cakun5_edit();

// Page init
$akun5_edit->Page_Init();

// Page main
$akun5_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$akun5_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fakun5edit = new ew_Form("fakun5edit", "edit");

// Validate form
fakun5edit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kel6");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $akun5->kel6->FldCaption(), $akun5->kel6->ReqErrMsg)) ?>");

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
fakun5edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fakun5edit.ValidateRequired = true;
<?php } else { ?>
fakun5edit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$akun5_edit->IsModal) { ?>
<?php } ?>
<?php $akun5_edit->ShowPageHeader(); ?>
<?php
$akun5_edit->ShowMessage();
?>
<form name="fakun5edit" id="fakun5edit" class="<?php echo $akun5_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($akun5_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $akun5_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="akun5">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($akun5_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($akun5->kel1->Visible) { // kel1 ?>
	<div id="r_kel1" class="form-group">
		<label id="elh_akun5_kel1" for="x_kel1" class="col-sm-2 control-label ewLabel"><?php echo $akun5->kel1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->kel1->CellAttributes() ?>>
<span id="el_akun5_kel1">
<input type="text" data-table="akun5" data-field="x_kel1" name="x_kel1" id="x_kel1" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun5->kel1->getPlaceHolder()) ?>" value="<?php echo $akun5->kel1->EditValue ?>"<?php echo $akun5->kel1->EditAttributes() ?>>
</span>
<?php echo $akun5->kel1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun5->kel2->Visible) { // kel2 ?>
	<div id="r_kel2" class="form-group">
		<label id="elh_akun5_kel2" for="x_kel2" class="col-sm-2 control-label ewLabel"><?php echo $akun5->kel2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->kel2->CellAttributes() ?>>
<span id="el_akun5_kel2">
<input type="text" data-table="akun5" data-field="x_kel2" name="x_kel2" id="x_kel2" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun5->kel2->getPlaceHolder()) ?>" value="<?php echo $akun5->kel2->EditValue ?>"<?php echo $akun5->kel2->EditAttributes() ?>>
</span>
<?php echo $akun5->kel2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun5->kel3->Visible) { // kel3 ?>
	<div id="r_kel3" class="form-group">
		<label id="elh_akun5_kel3" for="x_kel3" class="col-sm-2 control-label ewLabel"><?php echo $akun5->kel3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->kel3->CellAttributes() ?>>
<span id="el_akun5_kel3">
<input type="text" data-table="akun5" data-field="x_kel3" name="x_kel3" id="x_kel3" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun5->kel3->getPlaceHolder()) ?>" value="<?php echo $akun5->kel3->EditValue ?>"<?php echo $akun5->kel3->EditAttributes() ?>>
</span>
<?php echo $akun5->kel3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun5->kel41->Visible) { // kel41 ?>
	<div id="r_kel41" class="form-group">
		<label id="elh_akun5_kel41" for="x_kel41" class="col-sm-2 control-label ewLabel"><?php echo $akun5->kel41->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->kel41->CellAttributes() ?>>
<span id="el_akun5_kel41">
<input type="text" data-table="akun5" data-field="x_kel41" name="x_kel41" id="x_kel41" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun5->kel41->getPlaceHolder()) ?>" value="<?php echo $akun5->kel41->EditValue ?>"<?php echo $akun5->kel41->EditAttributes() ?>>
</span>
<?php echo $akun5->kel41->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun5->kel4->Visible) { // kel4 ?>
	<div id="r_kel4" class="form-group">
		<label id="elh_akun5_kel4" for="x_kel4" class="col-sm-2 control-label ewLabel"><?php echo $akun5->kel4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->kel4->CellAttributes() ?>>
<span id="el_akun5_kel4">
<input type="text" data-table="akun5" data-field="x_kel4" name="x_kel4" id="x_kel4" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun5->kel4->getPlaceHolder()) ?>" value="<?php echo $akun5->kel4->EditValue ?>"<?php echo $akun5->kel4->EditAttributes() ?>>
</span>
<?php echo $akun5->kel4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun5->kel5->Visible) { // kel5 ?>
	<div id="r_kel5" class="form-group">
		<label id="elh_akun5_kel5" for="x_kel5" class="col-sm-2 control-label ewLabel"><?php echo $akun5->kel5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->kel5->CellAttributes() ?>>
<span id="el_akun5_kel5">
<input type="text" data-table="akun5" data-field="x_kel5" name="x_kel5" id="x_kel5" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($akun5->kel5->getPlaceHolder()) ?>" value="<?php echo $akun5->kel5->EditValue ?>"<?php echo $akun5->kel5->EditAttributes() ?>>
</span>
<?php echo $akun5->kel5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun5->kel6->Visible) { // kel6 ?>
	<div id="r_kel6" class="form-group">
		<label id="elh_akun5_kel6" for="x_kel6" class="col-sm-2 control-label ewLabel"><?php echo $akun5->kel6->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->kel6->CellAttributes() ?>>
<span id="el_akun5_kel6">
<span<?php echo $akun5->kel6->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $akun5->kel6->EditValue ?></p></span>
</span>
<input type="hidden" data-table="akun5" data-field="x_kel6" name="x_kel6" id="x_kel6" value="<?php echo ew_HtmlEncode($akun5->kel6->CurrentValue) ?>">
<?php echo $akun5->kel6->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($akun5->nmkel5->Visible) { // nmkel5 ?>
	<div id="r_nmkel5" class="form-group">
		<label id="elh_akun5_nmkel5" for="x_nmkel5" class="col-sm-2 control-label ewLabel"><?php echo $akun5->nmkel5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $akun5->nmkel5->CellAttributes() ?>>
<span id="el_akun5_nmkel5">
<input type="text" data-table="akun5" data-field="x_nmkel5" name="x_nmkel5" id="x_nmkel5" size="30" maxlength="75" placeholder="<?php echo ew_HtmlEncode($akun5->nmkel5->getPlaceHolder()) ?>" value="<?php echo $akun5->nmkel5->EditValue ?>"<?php echo $akun5->nmkel5->EditAttributes() ?>>
</span>
<?php echo $akun5->nmkel5->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$akun5_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $akun5_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fakun5edit.Init();
</script>
<?php
$akun5_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$akun5_edit->Page_Terminate();
?>
