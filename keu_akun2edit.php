<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "keu_akun2info.php" ?>
<?php include_once "keu_akun1info.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "keu_akun3gridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$keu_akun2_edit = NULL; // Initialize page object first

class ckeu_akun2_edit extends ckeu_akun2 {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'keu_akun2';

	// Page object name
	var $PageObjName = 'keu_akun2_edit';

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

		// Table object (keu_akun2)
		if (!isset($GLOBALS["keu_akun2"]) || get_class($GLOBALS["keu_akun2"]) == "ckeu_akun2") {
			$GLOBALS["keu_akun2"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["keu_akun2"];
		}

		// Table object (keu_akun1)
		if (!isset($GLOBALS['keu_akun1'])) $GLOBALS['keu_akun1'] = new ckeu_akun1();

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'keu_akun2', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("keu_akun2list.php"));
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
		$this->kel1->SetVisibility();
		$this->kel2->SetVisibility();
		$this->nmkel2->SetVisibility();
		$this->kode_akun1->SetVisibility();

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

			// Process auto fill for detail table 'keu_akun3'
			if (@$_POST["grid"] == "fkeu_akun3grid") {
				if (!isset($GLOBALS["keu_akun3_grid"])) $GLOBALS["keu_akun3_grid"] = new ckeu_akun3_grid;
				$GLOBALS["keu_akun3_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $keu_akun2;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($keu_akun2);
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

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("keu_akun2list.php"); // Invalid key, return to list
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
					$this->Page_Terminate("keu_akun2list.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "keu_akun2list.php")
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

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->kel1->FldIsDetailKey) {
			$this->kel1->setFormValue($objForm->GetValue("x_kel1"));
		}
		if (!$this->kel2->FldIsDetailKey) {
			$this->kel2->setFormValue($objForm->GetValue("x_kel2"));
		}
		if (!$this->nmkel2->FldIsDetailKey) {
			$this->nmkel2->setFormValue($objForm->GetValue("x_nmkel2"));
		}
		if (!$this->kode_akun1->FldIsDetailKey) {
			$this->kode_akun1->setFormValue($objForm->GetValue("x_kode_akun1"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->kd_akun->CurrentValue = $this->kd_akun->FormValue;
		$this->kel1->CurrentValue = $this->kel1->FormValue;
		$this->kel2->CurrentValue = $this->kel2->FormValue;
		$this->nmkel2->CurrentValue = $this->nmkel2->FormValue;
		$this->kode_akun1->CurrentValue = $this->kode_akun1->FormValue;
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
		$this->kel1->setDbValue($rs->fields('kel1'));
		$this->kel2->setDbValue($rs->fields('kel2'));
		$this->nmkel2->setDbValue($rs->fields('nmkel2'));
		$this->kode_akun1->setDbValue($rs->fields('kode_akun1'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->kd_akun->DbValue = $row['kd_akun'];
		$this->kel1->DbValue = $row['kel1'];
		$this->kel2->DbValue = $row['kel2'];
		$this->nmkel2->DbValue = $row['nmkel2'];
		$this->kode_akun1->DbValue = $row['kode_akun1'];
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
		// kel1
		// kel2
		// nmkel2
		// kode_akun1

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kd_akun
		$this->kd_akun->ViewValue = $this->kd_akun->CurrentValue;
		$this->kd_akun->ViewCustomAttributes = "";

		// kel1
		$this->kel1->ViewValue = $this->kel1->CurrentValue;
		$this->kel1->ViewCustomAttributes = "";

		// kel2
		$this->kel2->ViewValue = $this->kel2->CurrentValue;
		$this->kel2->ViewCustomAttributes = "";

		// nmkel2
		$this->nmkel2->ViewValue = $this->nmkel2->CurrentValue;
		$this->nmkel2->ViewCustomAttributes = "";

		// kode_akun1
		$this->kode_akun1->ViewValue = $this->kode_akun1->CurrentValue;
		$this->kode_akun1->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// kd_akun
			$this->kd_akun->LinkCustomAttributes = "";
			$this->kd_akun->HrefValue = "";
			$this->kd_akun->TooltipValue = "";

			// kel1
			$this->kel1->LinkCustomAttributes = "";
			$this->kel1->HrefValue = "";
			$this->kel1->TooltipValue = "";

			// kel2
			$this->kel2->LinkCustomAttributes = "";
			$this->kel2->HrefValue = "";
			$this->kel2->TooltipValue = "";

			// nmkel2
			$this->nmkel2->LinkCustomAttributes = "";
			$this->nmkel2->HrefValue = "";
			$this->nmkel2->TooltipValue = "";

			// kode_akun1
			$this->kode_akun1->LinkCustomAttributes = "";
			$this->kode_akun1->HrefValue = "";
			$this->kode_akun1->TooltipValue = "";
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

			// kel1
			$this->kel1->EditAttrs["class"] = "form-control";
			$this->kel1->EditCustomAttributes = "";
			if ($this->kel1->getSessionValue() <> "") {
				$this->kel1->CurrentValue = $this->kel1->getSessionValue();
			$this->kel1->ViewValue = $this->kel1->CurrentValue;
			$this->kel1->ViewCustomAttributes = "";
			} else {
			$this->kel1->EditValue = ew_HtmlEncode($this->kel1->CurrentValue);
			$this->kel1->PlaceHolder = ew_RemoveHtml($this->kel1->FldCaption());
			}

			// kel2
			$this->kel2->EditAttrs["class"] = "form-control";
			$this->kel2->EditCustomAttributes = "";
			$this->kel2->EditValue = ew_HtmlEncode($this->kel2->CurrentValue);
			$this->kel2->PlaceHolder = ew_RemoveHtml($this->kel2->FldCaption());

			// nmkel2
			$this->nmkel2->EditAttrs["class"] = "form-control";
			$this->nmkel2->EditCustomAttributes = "";
			$this->nmkel2->EditValue = ew_HtmlEncode($this->nmkel2->CurrentValue);
			$this->nmkel2->PlaceHolder = ew_RemoveHtml($this->nmkel2->FldCaption());

			// kode_akun1
			$this->kode_akun1->EditAttrs["class"] = "form-control";
			$this->kode_akun1->EditCustomAttributes = "";
			$this->kode_akun1->EditValue = ew_HtmlEncode($this->kode_akun1->CurrentValue);
			$this->kode_akun1->PlaceHolder = ew_RemoveHtml($this->kode_akun1->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// kd_akun
			$this->kd_akun->LinkCustomAttributes = "";
			$this->kd_akun->HrefValue = "";

			// kel1
			$this->kel1->LinkCustomAttributes = "";
			$this->kel1->HrefValue = "";

			// kel2
			$this->kel2->LinkCustomAttributes = "";
			$this->kel2->HrefValue = "";

			// nmkel2
			$this->nmkel2->LinkCustomAttributes = "";
			$this->nmkel2->HrefValue = "";

			// kode_akun1
			$this->kode_akun1->LinkCustomAttributes = "";
			$this->kode_akun1->HrefValue = "";
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
		if (!ew_CheckInteger($this->kode_akun1->FormValue)) {
			ew_AddMessage($gsFormError, $this->kode_akun1->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("keu_akun3", $DetailTblVar) && $GLOBALS["keu_akun3"]->DetailEdit) {
			if (!isset($GLOBALS["keu_akun3_grid"])) $GLOBALS["keu_akun3_grid"] = new ckeu_akun3_grid(); // get detail page object
			$GLOBALS["keu_akun3_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// kd_akun
			$this->kd_akun->SetDbValueDef($rsnew, $this->kd_akun->CurrentValue, NULL, $this->kd_akun->ReadOnly);

			// kel1
			$this->kel1->SetDbValueDef($rsnew, $this->kel1->CurrentValue, NULL, $this->kel1->ReadOnly);

			// kel2
			$this->kel2->SetDbValueDef($rsnew, $this->kel2->CurrentValue, NULL, $this->kel2->ReadOnly);

			// nmkel2
			$this->nmkel2->SetDbValueDef($rsnew, $this->nmkel2->CurrentValue, NULL, $this->nmkel2->ReadOnly);

			// kode_akun1
			$this->kode_akun1->SetDbValueDef($rsnew, $this->kode_akun1->CurrentValue, NULL, $this->kode_akun1->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("keu_akun3", $DetailTblVar) && $GLOBALS["keu_akun3"]->DetailEdit) {
						if (!isset($GLOBALS["keu_akun3_grid"])) $GLOBALS["keu_akun3_grid"] = new ckeu_akun3_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "keu_akun3"); // Load user level of detail table
						$EditRow = $GLOBALS["keu_akun3_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if ($sMasterTblVar == "keu_akun1") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_kel1"] <> "") {
					$GLOBALS["keu_akun1"]->kel1->setQueryStringValue($_GET["fk_kel1"]);
					$this->kel1->setQueryStringValue($GLOBALS["keu_akun1"]->kel1->QueryStringValue);
					$this->kel1->setSessionValue($this->kel1->QueryStringValue);
					if (!is_numeric($GLOBALS["keu_akun1"]->kel1->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "keu_akun1") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_kel1"] <> "") {
					$GLOBALS["keu_akun1"]->kel1->setFormValue($_POST["fk_kel1"]);
					$this->kel1->setFormValue($GLOBALS["keu_akun1"]->kel1->FormValue);
					$this->kel1->setSessionValue($this->kel1->FormValue);
					if (!is_numeric($GLOBALS["keu_akun1"]->kel1->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "keu_akun1") {
				if ($this->kel1->CurrentValue == "") $this->kel1->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("keu_akun3", $DetailTblVar)) {
				if (!isset($GLOBALS["keu_akun3_grid"]))
					$GLOBALS["keu_akun3_grid"] = new ckeu_akun3_grid;
				if ($GLOBALS["keu_akun3_grid"]->DetailEdit) {
					$GLOBALS["keu_akun3_grid"]->CurrentMode = "edit";
					$GLOBALS["keu_akun3_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["keu_akun3_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["keu_akun3_grid"]->setStartRecordNumber(1);
					$GLOBALS["keu_akun3_grid"]->kel1->FldIsDetailKey = TRUE;
					$GLOBALS["keu_akun3_grid"]->kel1->CurrentValue = $this->kel1->CurrentValue;
					$GLOBALS["keu_akun3_grid"]->kel1->setSessionValue($GLOBALS["keu_akun3_grid"]->kel1->CurrentValue);
					$GLOBALS["keu_akun3_grid"]->kel2->FldIsDetailKey = TRUE;
					$GLOBALS["keu_akun3_grid"]->kel2->CurrentValue = $this->kel2->CurrentValue;
					$GLOBALS["keu_akun3_grid"]->kel2->setSessionValue($GLOBALS["keu_akun3_grid"]->kel2->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("keu_akun2list.php"), "", $this->TableVar, TRUE);
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
if (!isset($keu_akun2_edit)) $keu_akun2_edit = new ckeu_akun2_edit();

// Page init
$keu_akun2_edit->Page_Init();

// Page main
$keu_akun2_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$keu_akun2_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fkeu_akun2edit = new ew_Form("fkeu_akun2edit", "edit");

// Validate form
fkeu_akun2edit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kode_akun1");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($keu_akun2->kode_akun1->FldErrMsg()) ?>");

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
fkeu_akun2edit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fkeu_akun2edit.ValidateRequired = true;
<?php } else { ?>
fkeu_akun2edit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$keu_akun2_edit->IsModal) { ?>
<?php } ?>
<?php $keu_akun2_edit->ShowPageHeader(); ?>
<?php
$keu_akun2_edit->ShowMessage();
?>
<form name="fkeu_akun2edit" id="fkeu_akun2edit" class="<?php echo $keu_akun2_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($keu_akun2_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $keu_akun2_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="keu_akun2">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($keu_akun2_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($keu_akun2->getCurrentMasterTable() == "keu_akun1") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="keu_akun1">
<input type="hidden" name="fk_kel1" value="<?php echo $keu_akun2->kel1->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($keu_akun2->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_keu_akun2_id" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun2->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun2->id->CellAttributes() ?>>
<span id="el_keu_akun2_id">
<span<?php echo $keu_akun2->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun2->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="keu_akun2" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($keu_akun2->id->CurrentValue) ?>">
<?php echo $keu_akun2->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun2->kd_akun->Visible) { // kd_akun ?>
	<div id="r_kd_akun" class="form-group">
		<label id="elh_keu_akun2_kd_akun" for="x_kd_akun" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun2->kd_akun->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun2->kd_akun->CellAttributes() ?>>
<span id="el_keu_akun2_kd_akun">
<input type="text" data-table="keu_akun2" data-field="x_kd_akun" name="x_kd_akun" id="x_kd_akun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kd_akun->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kd_akun->EditValue ?>"<?php echo $keu_akun2->kd_akun->EditAttributes() ?>>
</span>
<?php echo $keu_akun2->kd_akun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun2->kel1->Visible) { // kel1 ?>
	<div id="r_kel1" class="form-group">
		<label id="elh_keu_akun2_kel1" for="x_kel1" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun2->kel1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun2->kel1->CellAttributes() ?>>
<?php if ($keu_akun2->kel1->getSessionValue() <> "") { ?>
<span id="el_keu_akun2_kel1">
<span<?php echo $keu_akun2->kel1->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $keu_akun2->kel1->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_kel1" name="x_kel1" value="<?php echo ew_HtmlEncode($keu_akun2->kel1->CurrentValue) ?>">
<?php } else { ?>
<span id="el_keu_akun2_kel1">
<input type="text" data-table="keu_akun2" data-field="x_kel1" name="x_kel1" id="x_kel1" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kel1->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kel1->EditValue ?>"<?php echo $keu_akun2->kel1->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $keu_akun2->kel1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun2->kel2->Visible) { // kel2 ?>
	<div id="r_kel2" class="form-group">
		<label id="elh_keu_akun2_kel2" for="x_kel2" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun2->kel2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun2->kel2->CellAttributes() ?>>
<span id="el_keu_akun2_kel2">
<input type="text" data-table="keu_akun2" data-field="x_kel2" name="x_kel2" id="x_kel2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kel2->EditValue ?>"<?php echo $keu_akun2->kel2->EditAttributes() ?>>
</span>
<?php echo $keu_akun2->kel2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun2->nmkel2->Visible) { // nmkel2 ?>
	<div id="r_nmkel2" class="form-group">
		<label id="elh_keu_akun2_nmkel2" for="x_nmkel2" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun2->nmkel2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun2->nmkel2->CellAttributes() ?>>
<span id="el_keu_akun2_nmkel2">
<input type="text" data-table="keu_akun2" data-field="x_nmkel2" name="x_nmkel2" id="x_nmkel2" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($keu_akun2->nmkel2->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->nmkel2->EditValue ?>"<?php echo $keu_akun2->nmkel2->EditAttributes() ?>>
</span>
<?php echo $keu_akun2->nmkel2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($keu_akun2->kode_akun1->Visible) { // kode_akun1 ?>
	<div id="r_kode_akun1" class="form-group">
		<label id="elh_keu_akun2_kode_akun1" for="x_kode_akun1" class="col-sm-2 control-label ewLabel"><?php echo $keu_akun2->kode_akun1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $keu_akun2->kode_akun1->CellAttributes() ?>>
<span id="el_keu_akun2_kode_akun1">
<input type="text" data-table="keu_akun2" data-field="x_kode_akun1" name="x_kode_akun1" id="x_kode_akun1" size="30" placeholder="<?php echo ew_HtmlEncode($keu_akun2->kode_akun1->getPlaceHolder()) ?>" value="<?php echo $keu_akun2->kode_akun1->EditValue ?>"<?php echo $keu_akun2->kode_akun1->EditAttributes() ?>>
</span>
<?php echo $keu_akun2->kode_akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("keu_akun3", explode(",", $keu_akun2->getCurrentDetailTable())) && $keu_akun3->DetailEdit) {
?>
<?php if ($keu_akun2->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("keu_akun3", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "keu_akun3grid.php" ?>
<?php } ?>
<?php if (!$keu_akun2_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $keu_akun2_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fkeu_akun2edit.Init();
</script>
<?php
$keu_akun2_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$keu_akun2_edit->Page_Terminate();
?>
