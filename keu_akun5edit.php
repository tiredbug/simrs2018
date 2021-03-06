<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "keu_akun5info.php" ?>
<?php include_once "keu_akun4info.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$keu_akun5_edit = NULL; // Initialize page object first

class ckeu_akun5_edit extends ckeu_akun5 {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'keu_akun5';

	// Page object name
	var $PageObjName = 'keu_akun5_edit';

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

		// Table object (keu_akun5)
		if (!isset($GLOBALS["keu_akun5"]) || get_class($GLOBALS["keu_akun5"]) == "ckeu_akun5") {
			$GLOBALS["keu_akun5"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["keu_akun5"];
		}

		// Table object (keu_akun4)
		if (!isset($GLOBALS['keu_akun4'])) $GLOBALS['keu_akun4'] = new ckeu_akun4();

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'keu_akun5', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("keu_akun5list.php"));
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
		$this->kd_akun->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();
		$this->nama_akun->SetVisibility();
		$this->kd_akun4->SetVisibility();

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
		global $EW_EXPORT, $keu_akun5;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($keu_akun5);
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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("keu_akun5list.php"); // Invalid key, return to list
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
					$this->Page_Terminate("keu_akun5list.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "keu_akun5list.php")
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
		if (!$this->kd_akun->FldIsDetailKey) {
			$this->kd_akun->setFormValue($objForm->GetValue("x_kd_akun"));
		}
		if (!$this->akun1->FldIsDetailKey) {
			$this->akun1->setFormValue($objForm->GetValue("x_akun1"));
		}
		if (!$this->akun2->FldIsDetailKey) {
			$this->akun2->setFormValue($objForm->GetValue("x_akun2"));
		}
		if (!$this->akun3->FldIsDetailKey) {
			$this->akun3->setFormValue($objForm->GetValue("x_akun3"));
		}
		if (!$this->akun4->FldIsDetailKey) {
			$this->akun4->setFormValue($objForm->GetValue("x_akun4"));
		}
		if (!$this->akun5->FldIsDetailKey) {
			$this->akun5->setFormValue($objForm->GetValue("x_akun5"));
		}
		if (!$this->nama_akun->FldIsDetailKey) {
			$this->nama_akun->setFormValue($objForm->GetValue("x_nama_akun"));
		}
		if (!$this->kd_akun4->FldIsDetailKey) {
			$this->kd_akun4->setFormValue($objForm->GetValue("x_kd_akun4"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->kd_akun->CurrentValue = $this->kd_akun->FormValue;
		$this->akun1->CurrentValue = $this->akun1->FormValue;
		$this->akun2->CurrentValue = $this->akun2->FormValue;
		$this->akun3->CurrentValue = $this->akun3->FormValue;
		$this->akun4->CurrentValue = $this->akun4->FormValue;
		$this->akun5->CurrentValue = $this->akun5->FormValue;
		$this->nama_akun->CurrentValue = $this->nama_akun->FormValue;
		$this->kd_akun4->CurrentValue = $this->kd_akun4->FormValue;
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
		$this->kd_akun->setDbValue($rs->fields('kd_akun'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->nama_akun->setDbValue($rs->fields('nama_akun'));
		$this->kd_akun4->setDbValue($rs->fields('kd_akun4'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->kd_akun->DbValue = $row['kd_akun'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
		$this->nama_akun->DbValue = $row['nama_akun'];
		$this->kd_akun4->DbValue = $row['kd_akun4'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// kd_akun
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5
		// nama_akun
		// kd_akun4

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kd_akun
		$this->kd_akun->ViewValue = $this->kd_akun->CurrentValue;
		$this->kd_akun->ViewCustomAttributes = "";

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		$this->akun2->ViewValue = $this->akun2->CurrentValue;
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		$this->akun3->ViewValue = $this->akun3->CurrentValue;
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		$this->akun4->ViewValue = $this->akun4->CurrentValue;
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		$this->akun5->ViewValue = $this->akun5->CurrentValue;
		$this->akun5->ViewCustomAttributes = "";

		// nama_akun
		$this->nama_akun->ViewValue = $this->nama_akun->CurrentValue;
		$this->nama_akun->ViewCustomAttributes = "";

		// kd_akun4
		$this->kd_akun4->ViewValue = $this->kd_akun4->CurrentValue;
		$this->kd_akun4->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// kd_akun
			$this->kd_akun->LinkCustomAttributes = "";
			$this->kd_akun->HrefValue = "";
			$this->kd_akun->TooltipValue = "";

			// akun1
			$this->akun1->LinkCustomAttributes = "";
			$this->akun1->HrefValue = "";
			$this->akun1->TooltipValue = "";

			// akun2
			$this->akun2->LinkCustomAttributes = "";
			$this->akun2->HrefValue = "";
			$this->akun2->TooltipValue = "";

			// akun3
			$this->akun3->LinkCustomAttributes = "";
			$this->akun3->HrefValue = "";
			$this->akun3->TooltipValue = "";

			// akun4
			$this->akun4->LinkCustomAttributes = "";
			$this->akun4->HrefValue = "";
			$this->akun4->TooltipValue = "";

			// akun5
			$this->akun5->LinkCustomAttributes = "";
			$this->akun5->HrefValue = "";
			$this->akun5->TooltipValue = "";

			// nama_akun
			$this->nama_akun->LinkCustomAttributes = "";
			$this->nama_akun->HrefValue = "";
			$this->nama_akun->TooltipValue = "";

			// kd_akun4
			$this->kd_akun4->LinkCustomAttributes = "";
			$this->kd_akun4->HrefValue = "";
			$this->kd_akun4->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// kd_akun
			$this->kd_akun->EditAttrs["class"] = "form-control";
			$this->kd_akun->EditCustomAttributes = "";
			$this->kd_akun->EditValue = ew_HtmlEncode($this->kd_akun->CurrentValue);
			$this->kd_akun->PlaceHolder = ew_RemoveHtml($this->kd_akun->FldCaption());

			// akun1
			$this->akun1->EditAttrs["class"] = "form-control";
			$this->akun1->EditCustomAttributes = "";
			if ($this->akun1->getSessionValue() <> "") {
				$this->akun1->CurrentValue = $this->akun1->getSessionValue();
			$this->akun1->ViewValue = $this->akun1->CurrentValue;
			$this->akun1->ViewCustomAttributes = "";
			} else {
			$this->akun1->EditValue = ew_HtmlEncode($this->akun1->CurrentValue);
			$this->akun1->PlaceHolder = ew_RemoveHtml($this->akun1->FldCaption());
			}

			// akun2
			$this->akun2->EditAttrs["class"] = "form-control";
			$this->akun2->EditCustomAttributes = "";
			if ($this->akun2->getSessionValue() <> "") {
				$this->akun2->CurrentValue = $this->akun2->getSessionValue();
			$this->akun2->ViewValue = $this->akun2->CurrentValue;
			$this->akun2->ViewCustomAttributes = "";
			} else {
			$this->akun2->EditValue = ew_HtmlEncode($this->akun2->CurrentValue);
			$this->akun2->PlaceHolder = ew_RemoveHtml($this->akun2->FldCaption());
			}

			// akun3
			$this->akun3->EditAttrs["class"] = "form-control";
			$this->akun3->EditCustomAttributes = "";
			if ($this->akun3->getSessionValue() <> "") {
				$this->akun3->CurrentValue = $this->akun3->getSessionValue();
			$this->akun3->ViewValue = $this->akun3->CurrentValue;
			$this->akun3->ViewCustomAttributes = "";
			} else {
			$this->akun3->EditValue = ew_HtmlEncode($this->akun3->CurrentValue);
			$this->akun3->PlaceHolder = ew_RemoveHtml($this->akun3->FldCaption());
			}

			// akun4
			$this->akun4->EditAttrs["class"] = "form-control";
			$this->akun4->EditCustomAttributes = "";
			if ($this->akun4->getSessionValue() <> "") {
				$this->akun4->CurrentValue = $this->akun4->getSessionValue();
			$this->akun4->ViewValue = $this->akun4->CurrentValue;
			$this->akun4->ViewCustomAttributes = "";
			} else {
			$this->akun4->EditValue = ew_HtmlEncode($this->akun4->CurrentValue);
			$this->akun4->PlaceHolder = ew_RemoveHtml($this->akun4->FldCaption());
			}

			// akun5
			$this->akun5->EditAttrs["class"] = "form-control";
			$this->akun5->EditCustomAttributes = "";
			$this->akun5->EditValue = ew_HtmlEncode($this->akun5->CurrentValue);
			$this->akun5->PlaceHolder = ew_RemoveHtml($this->akun5->FldCaption());

			// nama_akun
			$this->nama_akun->EditAttrs["class"] = "form-control";
			$this->nama_akun->EditCustomAttributes = "";
			$this->nama_akun->EditValue = ew_HtmlEncode($this->nama_akun->CurrentValue);
			$this->nama_akun->PlaceHolder = ew_RemoveHtml($this->nama_akun->FldCaption());

			// kd_akun4
			$this->kd_akun4->EditAttrs["class"] = "form-control";
			$this->kd_akun4->EditCustomAttributes = "";
			$this->kd_akun4->EditValue = ew_HtmlEncode($this->kd_akun4->CurrentValue);
			$this->kd_akun4->PlaceHolder = ew_RemoveHtml($this->kd_akun4->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// kd_akun
			$this->kd_akun->LinkCustomAttributes = "";
			$this->kd_akun->HrefValue = "";

			// akun1
			$this->akun1->LinkCustomAttributes = "";
			$this->akun1->HrefValue = "";

			// akun2
			$this->akun2->LinkCustomAttributes = "";
			$this->akun2->HrefValue = "";

			// akun3
			$this->akun3->LinkCustomAttributes = "";
			$this->akun3->HrefValue = "";

			// akun4
			$this->akun4->LinkCustomAttributes = "";
			$this->akun4->HrefValue = "";

			// akun5
			$this->akun5->LinkCustomAttributes = "";
			$this->akun5->HrefValue = "";

			// nama_akun
			$this->nama_akun->LinkCustomAttributes = "";
			$this->nama_akun->HrefValue = "";

			// kd_akun4
			$this->kd_akun4->LinkCustomAttributes = "";
			$this->kd_akun4->HrefValue = "";
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
		if (!ew_CheckInteger($this->kd_akun4->FormValue)) {
			ew_AddMessage($gsFormError, $this->kd_akun4->FldErrMsg());
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

			// kd_akun
			$this->kd_akun->SetDbValueDef($rsnew, $this->kd_akun->CurrentValue, NULL, $this->kd_akun->ReadOnly);

			// akun1
			$this->akun1->SetDbValueDef($rsnew, $this->akun1->CurrentValue, NULL, $this->akun1->ReadOnly);

			// akun2
			$this->akun2->SetDbValueDef($rsnew, $this->akun2->CurrentValue, NULL, $this->akun2->ReadOnly);

			// akun3
			$this->akun3->SetDbValueDef($rsnew, $this->akun3->CurrentValue, NULL, $this->akun3->ReadOnly);

			// akun4
			$this->akun4->SetDbValueDef($rsnew, $this->akun4->CurrentValue, NULL, $this->akun4->ReadOnly);

			// akun5
			$this->akun5->SetDbValueDef($rsnew, $this->akun5->CurrentValue, NULL, $this->akun5->ReadOnly);

			// nama_akun
			$this->nama_akun->SetDbValueDef($rsnew, $this->nama_akun->CurrentValue, NULL, $this->nama_akun->ReadOnly);

			// kd_akun4
			$this->kd_akun4->SetDbValueDef($rsnew, $this->kd_akun4->CurrentValue, NULL, $this->kd_akun4->ReadOnly);

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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "keu_akun4") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_kel1"] <> "") {
					$GLOBALS["keu_akun4"]->kel1->setQueryStringValue($_GET["fk_kel1"]);
					$this->akun1->setQueryStringValue($GLOBALS["keu_akun4"]->kel1->QueryStringValue);
					$this->akun1->setSessionValue($this->akun1->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kel2"] <> "") {
					$GLOBALS["keu_akun4"]->kel2->setQueryStringValue($_GET["fk_kel2"]);
					$this->akun2->setQueryStringValue($GLOBALS["keu_akun4"]->kel2->QueryStringValue);
					$this->akun2->setSessionValue($this->akun2->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kel3"] <> "") {
					$GLOBALS["keu_akun4"]->kel3->setQueryStringValue($_GET["fk_kel3"]);
					$this->akun3->setQueryStringValue($GLOBALS["keu_akun4"]->kel3->QueryStringValue);
					$this->akun3->setSessionValue($this->akun3->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kel4"] <> "") {
					$GLOBALS["keu_akun4"]->kel4->setQueryStringValue($_GET["fk_kel4"]);
					$this->akun4->setQueryStringValue($GLOBALS["keu_akun4"]->kel4->QueryStringValue);
					$this->akun4->setSessionValue($this->akun4->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "keu_akun4") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_kel1"] <> "") {
					$GLOBALS["keu_akun4"]->kel1->setFormValue($_POST["fk_kel1"]);
					$this->akun1->setFormValue($GLOBALS["keu_akun4"]->kel1->FormValue);
					$this->akun1->setSessionValue($this->akun1->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kel2"] <> "") {
					$GLOBALS["keu_akun4"]->kel2->setFormValue($_POST["fk_kel2"]);
					$this->akun2->setFormValue($GLOBALS["keu_akun4"]->kel2->FormValue);
					$this->akun2->setSessionValue($this->akun2->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kel3"] <> "") {
					$GLOBALS["keu_akun4"]->kel3->setFormValue($_POST["fk_kel3"]);
					$this->akun3->setFormValue($GLOBALS["keu_akun4"]->kel3->FormValue);
					$this->akun3->setSessionValue($this->akun3->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kel4"] <> "") {
					$GLOBALS["keu_akun4"]->kel4->setFormValue($_POST["fk_kel4"]);
					$this->akun4->setFormValue($GLOBALS["keu_akun4"]->kel4->FormValue);
					$this->akun4->setSessionValue($this->akun4->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "keu_akun4") {
				if ($this->akun1->CurrentValue == "") $this->akun1->setSessionValue("");
				if ($this->akun2->CurrentValue == "") $this->akun2->setSessionValue("");
				if ($this->akun3->CurrentValue == "") $this->akun3->setSessionValue("");
				if ($this->akun4->CurrentValue == "") $this->akun4->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("keu_akun5list.php"), "", $this->TableVar, TRUE);
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
if (!isset($keu_akun5_edit)) $keu_akun5_edit = new ckeu_akun5_edit();

// Page init
$keu_akun5_edit->Page_Init();

// Page main
$keu_akun5_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$keu_akun5_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fkeu_akun5edit = new ew_Form("fkeu_akun5edit", "edit");

// Validate form
fkeu_akun5edit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kd_akun4");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($keu_akun5->kd_akun4->FldErrMsg()) ?>");

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
fkeu_akun5edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkeu_akun5edit.ValidateRequired = true;
<?php } else { ?>
fkeu_akun5edit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$keu_akun5_edit->IsModal) { ?>
<?php } ?>
<?php $keu_akun5_edit->ShowPageHeader(); ?>
<?php
$keu_akun5_edit->ShowMessage();
?>
<form name="fkeu_akun5edit" id="fkeu_akun5edit" class="<?php echo $keu_akun5_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($keu_akun5_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $keu_akun5_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="keu_akun5">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($keu_akun5_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($keu_akun5->getCurrentMasterTable() == "keu_akun4") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="keu_akun4">
<input type="hidden" name="fk_kel1" value="<?php echo $keu_akun5->akun1->getSessionValue() ?>">
<input type="hidden" name="fk_kel2" value="<?php echo $keu_akun5->akun2->getSessionValue() ?>">
<input type="hidden" name="fk_kel3" value="<?php echo $keu_akun5->akun3->getSessionValue() ?>">
<input type="hidden" name="fk_kel4" value="<?php echo $keu_akun5->akun4->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($keu_akun5->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_keu_akun5_id" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->id->CellAttributes() ?>>
<span id="el_keu_akun5_id">
<span<?php echo $keu_akun5->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun5" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($keu_akun5->id->CurrentValue) ?>">
<?php echo $keu_akun5->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->kd_akun->Visible) { // kd_akun ?>
	<div id="r_kd_akun" class="form-group">
		<label id="elh_keu_akun5_kd_akun" for="x_kd_akun" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->kd_akun->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->kd_akun->CellAttributes() ?>>
<span id="el_keu_akun5_kd_akun">
<input type="text" data-table="keu_akun5" data-field="x_kd_akun" name="x_kd_akun" id="x_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->kd_akun->EditValue ?>"<?php echo $keu_akun5->kd_akun->EditAttributes() ?>>
</span>
<?php echo $keu_akun5->kd_akun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->akun1->Visible) { // akun1 ?>
	<div id="r_akun1" class="form-group">
		<label id="elh_keu_akun5_akun1" for="x_akun1" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->akun1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->akun1->CellAttributes() ?>>
<?php if ($keu_akun5->akun1->getSessionValue() <> "") { ?>
<span id="el_keu_akun5_akun1">
<span<?php echo $keu_akun5->akun1->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->akun1->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_akun1" name="x_akun1" value="<?php echo ew_HtmlEncode($keu_akun5->akun1->CurrentValue) ?>">
<?php } else { ?>
<span id="el_keu_akun5_akun1">
<input type="text" data-table="keu_akun5" data-field="x_akun1" name="x_akun1" id="x_akun1" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun1->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun1->EditValue ?>"<?php echo $keu_akun5->akun1->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $keu_akun5->akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->akun2->Visible) { // akun2 ?>
	<div id="r_akun2" class="form-group">
		<label id="elh_keu_akun5_akun2" for="x_akun2" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->akun2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->akun2->CellAttributes() ?>>
<?php if ($keu_akun5->akun2->getSessionValue() <> "") { ?>
<span id="el_keu_akun5_akun2">
<span<?php echo $keu_akun5->akun2->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->akun2->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_akun2" name="x_akun2" value="<?php echo ew_HtmlEncode($keu_akun5->akun2->CurrentValue) ?>">
<?php } else { ?>
<span id="el_keu_akun5_akun2">
<input type="text" data-table="keu_akun5" data-field="x_akun2" name="x_akun2" id="x_akun2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun2->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun2->EditValue ?>"<?php echo $keu_akun5->akun2->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $keu_akun5->akun2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->akun3->Visible) { // akun3 ?>
	<div id="r_akun3" class="form-group">
		<label id="elh_keu_akun5_akun3" for="x_akun3" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->akun3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->akun3->CellAttributes() ?>>
<?php if ($keu_akun5->akun3->getSessionValue() <> "") { ?>
<span id="el_keu_akun5_akun3">
<span<?php echo $keu_akun5->akun3->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->akun3->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_akun3" name="x_akun3" value="<?php echo ew_HtmlEncode($keu_akun5->akun3->CurrentValue) ?>">
<?php } else { ?>
<span id="el_keu_akun5_akun3">
<input type="text" data-table="keu_akun5" data-field="x_akun3" name="x_akun3" id="x_akun3" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun3->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun3->EditValue ?>"<?php echo $keu_akun5->akun3->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $keu_akun5->akun3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->akun4->Visible) { // akun4 ?>
	<div id="r_akun4" class="form-group">
		<label id="elh_keu_akun5_akun4" for="x_akun4" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->akun4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->akun4->CellAttributes() ?>>
<?php if ($keu_akun5->akun4->getSessionValue() <> "") { ?>
<span id="el_keu_akun5_akun4">
<span<?php echo $keu_akun5->akun4->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun5->akun4->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_akun4" name="x_akun4" value="<?php echo ew_HtmlEncode($keu_akun5->akun4->CurrentValue) ?>">
<?php } else { ?>
<span id="el_keu_akun5_akun4">
<input type="text" data-table="keu_akun5" data-field="x_akun4" name="x_akun4" id="x_akun4" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun4->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun4->EditValue ?>"<?php echo $keu_akun5->akun4->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $keu_akun5->akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->akun5->Visible) { // akun5 ?>
	<div id="r_akun5" class="form-group">
		<label id="elh_keu_akun5_akun5" for="x_akun5" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->akun5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->akun5->CellAttributes() ?>>
<span id="el_keu_akun5_akun5">
<input type="text" data-table="keu_akun5" data-field="x_akun5" name="x_akun5" id="x_akun5" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun5->akun5->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->akun5->EditValue ?>"<?php echo $keu_akun5->akun5->EditAttributes() ?>>
</span>
<?php echo $keu_akun5->akun5->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->nama_akun->Visible) { // nama_akun ?>
	<div id="r_nama_akun" class="form-group">
		<label id="elh_keu_akun5_nama_akun" for="x_nama_akun" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->nama_akun->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->nama_akun->CellAttributes() ?>>
<span id="el_keu_akun5_nama_akun">
<input type="text" data-table="keu_akun5" data-field="x_nama_akun" name="x_nama_akun" id="x_nama_akun" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun5->nama_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->nama_akun->EditValue ?>"<?php echo $keu_akun5->nama_akun->EditAttributes() ?>>
</span>
<?php echo $keu_akun5->nama_akun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun5->kd_akun4->Visible) { // kd_akun4 ?>
	<div id="r_kd_akun4" class="form-group">
		<label id="elh_keu_akun5_kd_akun4" for="x_kd_akun4" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun5->kd_akun4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun5->kd_akun4->CellAttributes() ?>>
<span id="el_keu_akun5_kd_akun4">
<input type="text" data-table="keu_akun5" data-field="x_kd_akun4" name="x_kd_akun4" id="x_kd_akun4" size="30" placeholder="<?php echo ew_HtmlEncode($keu_akun5->kd_akun4->getPlaceHolder()) ?>" value="<?php echo $keu_akun5->kd_akun4->EditValue ?>"<?php echo $keu_akun5->kd_akun4->EditAttributes() ?>>
</span>
<?php echo $keu_akun5->kd_akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$keu_akun5_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $keu_akun5_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fkeu_akun5edit.Init();
</script>
<?php
$keu_akun5_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$keu_akun5_edit->Page_Terminate();
?>
