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

$m_blud_rs_edit = NULL; // Initialize page object first

class cm_blud_rs_edit extends cm_blud_rs {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_blud_rs';

	// Page object name
	var $PageObjName = 'm_blud_rs_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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

		// Create form object
		$objForm = new cFormObj();
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
			$this->Page_Terminate("m_blud_rslist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("m_blud_rslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "m_blud_rslist.php")
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
		if (!$this->direktur->FldIsDetailKey) {
			$this->direktur->setFormValue($objForm->GetValue("x_direktur"));
		}
		if (!$this->nip->FldIsDetailKey) {
			$this->nip->setFormValue($objForm->GetValue("x_nip"));
		}
		if (!$this->jabatan_keuangan->FldIsDetailKey) {
			$this->jabatan_keuangan->setFormValue($objForm->GetValue("x_jabatan_keuangan"));
		}
		if (!$this->rekening->FldIsDetailKey) {
			$this->rekening->setFormValue($objForm->GetValue("x_rekening"));
		}
		if (!$this->nomer_rekening->FldIsDetailKey) {
			$this->nomer_rekening->setFormValue($objForm->GetValue("x_nomer_rekening"));
		}
		if (!$this->npwp->FldIsDetailKey) {
			$this->npwp->setFormValue($objForm->GetValue("x_npwp"));
		}
		if (!$this->bendahara_keuangan->FldIsDetailKey) {
			$this->bendahara_keuangan->setFormValue($objForm->GetValue("x_bendahara_keuangan"));
		}
		if (!$this->nip_bendahara_keuangan->FldIsDetailKey) {
			$this->nip_bendahara_keuangan->setFormValue($objForm->GetValue("x_nip_bendahara_keuangan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->direktur->CurrentValue = $this->direktur->FormValue;
		$this->nip->CurrentValue = $this->nip->FormValue;
		$this->jabatan_keuangan->CurrentValue = $this->jabatan_keuangan->FormValue;
		$this->rekening->CurrentValue = $this->rekening->FormValue;
		$this->nomer_rekening->CurrentValue = $this->nomer_rekening->FormValue;
		$this->npwp->CurrentValue = $this->npwp->FormValue;
		$this->bendahara_keuangan->CurrentValue = $this->bendahara_keuangan->FormValue;
		$this->nip_bendahara_keuangan->CurrentValue = $this->nip_bendahara_keuangan->FormValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// direktur
			$this->direktur->EditAttrs["class"] = "form-control";
			$this->direktur->EditCustomAttributes = "";
			$this->direktur->EditValue = ew_HtmlEncode($this->direktur->CurrentValue);
			$this->direktur->PlaceHolder = ew_RemoveHtml($this->direktur->FldCaption());

			// nip
			$this->nip->EditAttrs["class"] = "form-control";
			$this->nip->EditCustomAttributes = "";
			$this->nip->EditValue = ew_HtmlEncode($this->nip->CurrentValue);
			$this->nip->PlaceHolder = ew_RemoveHtml($this->nip->FldCaption());

			// jabatan_keuangan
			$this->jabatan_keuangan->EditAttrs["class"] = "form-control";
			$this->jabatan_keuangan->EditCustomAttributes = "";
			$this->jabatan_keuangan->EditValue = ew_HtmlEncode($this->jabatan_keuangan->CurrentValue);
			$this->jabatan_keuangan->PlaceHolder = ew_RemoveHtml($this->jabatan_keuangan->FldCaption());

			// rekening
			$this->rekening->EditAttrs["class"] = "form-control";
			$this->rekening->EditCustomAttributes = "";
			$this->rekening->EditValue = ew_HtmlEncode($this->rekening->CurrentValue);
			$this->rekening->PlaceHolder = ew_RemoveHtml($this->rekening->FldCaption());

			// nomer_rekening
			$this->nomer_rekening->EditAttrs["class"] = "form-control";
			$this->nomer_rekening->EditCustomAttributes = "";
			$this->nomer_rekening->EditValue = ew_HtmlEncode($this->nomer_rekening->CurrentValue);
			$this->nomer_rekening->PlaceHolder = ew_RemoveHtml($this->nomer_rekening->FldCaption());

			// npwp
			$this->npwp->EditAttrs["class"] = "form-control";
			$this->npwp->EditCustomAttributes = "";
			$this->npwp->EditValue = ew_HtmlEncode($this->npwp->CurrentValue);
			$this->npwp->PlaceHolder = ew_RemoveHtml($this->npwp->FldCaption());

			// bendahara_keuangan
			$this->bendahara_keuangan->EditAttrs["class"] = "form-control";
			$this->bendahara_keuangan->EditCustomAttributes = "";
			$this->bendahara_keuangan->EditValue = ew_HtmlEncode($this->bendahara_keuangan->CurrentValue);
			$this->bendahara_keuangan->PlaceHolder = ew_RemoveHtml($this->bendahara_keuangan->FldCaption());

			// nip_bendahara_keuangan
			$this->nip_bendahara_keuangan->EditAttrs["class"] = "form-control";
			$this->nip_bendahara_keuangan->EditCustomAttributes = "";
			$this->nip_bendahara_keuangan->EditValue = ew_HtmlEncode($this->nip_bendahara_keuangan->CurrentValue);
			$this->nip_bendahara_keuangan->PlaceHolder = ew_RemoveHtml($this->nip_bendahara_keuangan->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// direktur
			$this->direktur->LinkCustomAttributes = "";
			$this->direktur->HrefValue = "";

			// nip
			$this->nip->LinkCustomAttributes = "";
			$this->nip->HrefValue = "";

			// jabatan_keuangan
			$this->jabatan_keuangan->LinkCustomAttributes = "";
			$this->jabatan_keuangan->HrefValue = "";

			// rekening
			$this->rekening->LinkCustomAttributes = "";
			$this->rekening->HrefValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";

			// bendahara_keuangan
			$this->bendahara_keuangan->LinkCustomAttributes = "";
			$this->bendahara_keuangan->HrefValue = "";

			// nip_bendahara_keuangan
			$this->nip_bendahara_keuangan->LinkCustomAttributes = "";
			$this->nip_bendahara_keuangan->HrefValue = "";
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

			// direktur
			$this->direktur->SetDbValueDef($rsnew, $this->direktur->CurrentValue, NULL, $this->direktur->ReadOnly);

			// nip
			$this->nip->SetDbValueDef($rsnew, $this->nip->CurrentValue, NULL, $this->nip->ReadOnly);

			// jabatan_keuangan
			$this->jabatan_keuangan->SetDbValueDef($rsnew, $this->jabatan_keuangan->CurrentValue, NULL, $this->jabatan_keuangan->ReadOnly);

			// rekening
			$this->rekening->SetDbValueDef($rsnew, $this->rekening->CurrentValue, NULL, $this->rekening->ReadOnly);

			// nomer_rekening
			$this->nomer_rekening->SetDbValueDef($rsnew, $this->nomer_rekening->CurrentValue, NULL, $this->nomer_rekening->ReadOnly);

			// npwp
			$this->npwp->SetDbValueDef($rsnew, $this->npwp->CurrentValue, NULL, $this->npwp->ReadOnly);

			// bendahara_keuangan
			$this->bendahara_keuangan->SetDbValueDef($rsnew, $this->bendahara_keuangan->CurrentValue, NULL, $this->bendahara_keuangan->ReadOnly);

			// nip_bendahara_keuangan
			$this->nip_bendahara_keuangan->SetDbValueDef($rsnew, $this->nip_bendahara_keuangan->CurrentValue, NULL, $this->nip_bendahara_keuangan->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_blud_rslist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_blud_rs_edit)) $m_blud_rs_edit = new cm_blud_rs_edit();

// Page init
$m_blud_rs_edit->Page_Init();

// Page main
$m_blud_rs_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_blud_rs_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fm_blud_rsedit = new ew_Form("fm_blud_rsedit", "edit");

// Validate form
fm_blud_rsedit.Validate = function() {
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
fm_blud_rsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_blud_rsedit.ValidateRequired = true;
<?php } else { ?>
fm_blud_rsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_blud_rs_edit->IsModal) { ?>
<?php } ?>
<?php $m_blud_rs_edit->ShowPageHeader(); ?>
<?php
$m_blud_rs_edit->ShowMessage();
?>
<form name="fm_blud_rsedit" id="fm_blud_rsedit" class="<?php echo $m_blud_rs_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_blud_rs_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_blud_rs_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_blud_rs">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($m_blud_rs_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_blud_rs->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_m_blud_rs_id" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->id->CellAttributes() ?>>
<span id="el_m_blud_rs_id">
<span<?php echo $m_blud_rs->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_blud_rs->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="m_blud_rs" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($m_blud_rs->id->CurrentValue) ?>">
<?php echo $m_blud_rs->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->direktur->Visible) { // direktur ?>
	<div id="r_direktur" class="form-group">
		<label id="elh_m_blud_rs_direktur" for="x_direktur" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->direktur->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->direktur->CellAttributes() ?>>
<span id="el_m_blud_rs_direktur">
<input type="text" data-table="m_blud_rs" data-field="x_direktur" name="x_direktur" id="x_direktur" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->direktur->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->direktur->EditValue ?>"<?php echo $m_blud_rs->direktur->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->direktur->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->nip->Visible) { // nip ?>
	<div id="r_nip" class="form-group">
		<label id="elh_m_blud_rs_nip" for="x_nip" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->nip->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->nip->CellAttributes() ?>>
<span id="el_m_blud_rs_nip">
<input type="text" data-table="m_blud_rs" data-field="x_nip" name="x_nip" id="x_nip" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->nip->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->nip->EditValue ?>"<?php echo $m_blud_rs->nip->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->nip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->jabatan_keuangan->Visible) { // jabatan_keuangan ?>
	<div id="r_jabatan_keuangan" class="form-group">
		<label id="elh_m_blud_rs_jabatan_keuangan" for="x_jabatan_keuangan" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->jabatan_keuangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->jabatan_keuangan->CellAttributes() ?>>
<span id="el_m_blud_rs_jabatan_keuangan">
<input type="text" data-table="m_blud_rs" data-field="x_jabatan_keuangan" name="x_jabatan_keuangan" id="x_jabatan_keuangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->jabatan_keuangan->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->jabatan_keuangan->EditValue ?>"<?php echo $m_blud_rs->jabatan_keuangan->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->jabatan_keuangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->rekening->Visible) { // rekening ?>
	<div id="r_rekening" class="form-group">
		<label id="elh_m_blud_rs_rekening" for="x_rekening" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->rekening->CellAttributes() ?>>
<span id="el_m_blud_rs_rekening">
<input type="text" data-table="m_blud_rs" data-field="x_rekening" name="x_rekening" id="x_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->rekening->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->rekening->EditValue ?>"<?php echo $m_blud_rs->rekening->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->nomer_rekening->Visible) { // nomer_rekening ?>
	<div id="r_nomer_rekening" class="form-group">
		<label id="elh_m_blud_rs_nomer_rekening" for="x_nomer_rekening" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->nomer_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->nomer_rekening->CellAttributes() ?>>
<span id="el_m_blud_rs_nomer_rekening">
<input type="text" data-table="m_blud_rs" data-field="x_nomer_rekening" name="x_nomer_rekening" id="x_nomer_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->nomer_rekening->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->nomer_rekening->EditValue ?>"<?php echo $m_blud_rs->nomer_rekening->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->nomer_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->npwp->Visible) { // npwp ?>
	<div id="r_npwp" class="form-group">
		<label id="elh_m_blud_rs_npwp" for="x_npwp" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->npwp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->npwp->CellAttributes() ?>>
<span id="el_m_blud_rs_npwp">
<input type="text" data-table="m_blud_rs" data-field="x_npwp" name="x_npwp" id="x_npwp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->npwp->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->npwp->EditValue ?>"<?php echo $m_blud_rs->npwp->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->npwp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->bendahara_keuangan->Visible) { // bendahara_keuangan ?>
	<div id="r_bendahara_keuangan" class="form-group">
		<label id="elh_m_blud_rs_bendahara_keuangan" for="x_bendahara_keuangan" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->bendahara_keuangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->bendahara_keuangan->CellAttributes() ?>>
<span id="el_m_blud_rs_bendahara_keuangan">
<input type="text" data-table="m_blud_rs" data-field="x_bendahara_keuangan" name="x_bendahara_keuangan" id="x_bendahara_keuangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->bendahara_keuangan->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->bendahara_keuangan->EditValue ?>"<?php echo $m_blud_rs->bendahara_keuangan->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->bendahara_keuangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_blud_rs->nip_bendahara_keuangan->Visible) { // nip_bendahara_keuangan ?>
	<div id="r_nip_bendahara_keuangan" class="form-group">
		<label id="elh_m_blud_rs_nip_bendahara_keuangan" for="x_nip_bendahara_keuangan" class="col-sm-2 control-label ewLabel"><?php echo $m_blud_rs->nip_bendahara_keuangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_blud_rs->nip_bendahara_keuangan->CellAttributes() ?>>
<span id="el_m_blud_rs_nip_bendahara_keuangan">
<input type="text" data-table="m_blud_rs" data-field="x_nip_bendahara_keuangan" name="x_nip_bendahara_keuangan" id="x_nip_bendahara_keuangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_blud_rs->nip_bendahara_keuangan->getPlaceHolder()) ?>" value="<?php echo $m_blud_rs->nip_bendahara_keuangan->EditValue ?>"<?php echo $m_blud_rs->nip_bendahara_keuangan->EditAttributes() ?>>
</span>
<?php echo $m_blud_rs->nip_bendahara_keuangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_blud_rs_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_blud_rs_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_blud_rsedit.Init();
</script>
<?php
$m_blud_rs_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_blud_rs_edit->Page_Terminate();
?>
