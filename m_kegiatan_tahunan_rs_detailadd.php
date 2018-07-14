<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_kegiatan_tahunan_rs_detailinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_kegiatan_tahunan_rs_detail_add = NULL; // Initialize page object first

class cm_kegiatan_tahunan_rs_detail_add extends cm_kegiatan_tahunan_rs_detail {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_kegiatan_tahunan_rs_detail';

	// Page object name
	var $PageObjName = 'm_kegiatan_tahunan_rs_detail_add';

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

		// Table object (m_kegiatan_tahunan_rs_detail)
		if (!isset($GLOBALS["m_kegiatan_tahunan_rs_detail"]) || get_class($GLOBALS["m_kegiatan_tahunan_rs_detail"]) == "cm_kegiatan_tahunan_rs_detail") {
			$GLOBALS["m_kegiatan_tahunan_rs_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_kegiatan_tahunan_rs_detail"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_kegiatan_tahunan_rs_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_kegiatan_tahunan_rs_detaillist.php"));
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
		$this->tahun->SetVisibility();
		$this->program->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();

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
		global $EW_EXPORT, $m_kegiatan_tahunan_rs_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_kegiatan_tahunan_rs_detail);
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
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
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
					$this->Page_Terminate("m_kegiatan_tahunan_rs_detaillist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "m_kegiatan_tahunan_rs_detaillist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "m_kegiatan_tahunan_rs_detailview.php")
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
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->tahun->CurrentValue = NULL;
		$this->tahun->OldValue = $this->tahun->CurrentValue;
		$this->program->CurrentValue = NULL;
		$this->program->OldValue = $this->program->CurrentValue;
		$this->kode_rekening->CurrentValue = NULL;
		$this->kode_rekening->OldValue = $this->kode_rekening->CurrentValue;
		$this->akun1->CurrentValue = NULL;
		$this->akun1->OldValue = $this->akun1->CurrentValue;
		$this->akun2->CurrentValue = NULL;
		$this->akun2->OldValue = $this->akun2->CurrentValue;
		$this->akun3->CurrentValue = NULL;
		$this->akun3->OldValue = $this->akun3->CurrentValue;
		$this->akun4->CurrentValue = NULL;
		$this->akun4->OldValue = $this->akun4->CurrentValue;
		$this->akun5->CurrentValue = NULL;
		$this->akun5->OldValue = $this->akun5->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey) {
			$this->id->setFormValue($objForm->GetValue("x_id"));
		}
		if (!$this->tahun->FldIsDetailKey) {
			$this->tahun->setFormValue($objForm->GetValue("x_tahun"));
		}
		if (!$this->program->FldIsDetailKey) {
			$this->program->setFormValue($objForm->GetValue("x_program"));
		}
		if (!$this->kode_rekening->FldIsDetailKey) {
			$this->kode_rekening->setFormValue($objForm->GetValue("x_kode_rekening"));
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
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->tahun->CurrentValue = $this->tahun->FormValue;
		$this->program->CurrentValue = $this->program->FormValue;
		$this->kode_rekening->CurrentValue = $this->kode_rekening->FormValue;
		$this->akun1->CurrentValue = $this->akun1->FormValue;
		$this->akun2->CurrentValue = $this->akun2->FormValue;
		$this->akun3->CurrentValue = $this->akun3->FormValue;
		$this->akun4->CurrentValue = $this->akun4->FormValue;
		$this->akun5->CurrentValue = $this->akun5->FormValue;
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
		$this->tahun->setDbValue($rs->fields('tahun'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->tahun->DbValue = $row['tahun'];
		$this->program->DbValue = $row['program'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
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
		// id
		// tahun
		// program
		// kode_rekening
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// tahun
		$this->tahun->ViewValue = $this->tahun->CurrentValue;
		$this->tahun->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// tahun
			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";
			$this->tahun->TooltipValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";
			$this->program->TooltipValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = ew_HtmlEncode($this->id->CurrentValue);
			$this->id->PlaceHolder = ew_RemoveHtml($this->id->FldCaption());

			// tahun
			$this->tahun->EditAttrs["class"] = "form-control";
			$this->tahun->EditCustomAttributes = "";
			$this->tahun->EditValue = ew_HtmlEncode($this->tahun->CurrentValue);
			$this->tahun->PlaceHolder = ew_RemoveHtml($this->tahun->FldCaption());

			// program
			$this->program->EditAttrs["class"] = "form-control";
			$this->program->EditCustomAttributes = "";
			$this->program->EditValue = ew_HtmlEncode($this->program->CurrentValue);
			$this->program->PlaceHolder = ew_RemoveHtml($this->program->FldCaption());

			// kode_rekening
			$this->kode_rekening->EditAttrs["class"] = "form-control";
			$this->kode_rekening->EditCustomAttributes = "";
			$this->kode_rekening->EditValue = ew_HtmlEncode($this->kode_rekening->CurrentValue);
			$this->kode_rekening->PlaceHolder = ew_RemoveHtml($this->kode_rekening->FldCaption());

			// akun1
			$this->akun1->EditAttrs["class"] = "form-control";
			$this->akun1->EditCustomAttributes = "";
			$this->akun1->EditValue = ew_HtmlEncode($this->akun1->CurrentValue);
			$this->akun1->PlaceHolder = ew_RemoveHtml($this->akun1->FldCaption());

			// akun2
			$this->akun2->EditAttrs["class"] = "form-control";
			$this->akun2->EditCustomAttributes = "";
			$this->akun2->EditValue = ew_HtmlEncode($this->akun2->CurrentValue);
			$this->akun2->PlaceHolder = ew_RemoveHtml($this->akun2->FldCaption());

			// akun3
			$this->akun3->EditAttrs["class"] = "form-control";
			$this->akun3->EditCustomAttributes = "";
			$this->akun3->EditValue = ew_HtmlEncode($this->akun3->CurrentValue);
			$this->akun3->PlaceHolder = ew_RemoveHtml($this->akun3->FldCaption());

			// akun4
			$this->akun4->EditAttrs["class"] = "form-control";
			$this->akun4->EditCustomAttributes = "";
			$this->akun4->EditValue = ew_HtmlEncode($this->akun4->CurrentValue);
			$this->akun4->PlaceHolder = ew_RemoveHtml($this->akun4->FldCaption());

			// akun5
			$this->akun5->EditAttrs["class"] = "form-control";
			$this->akun5->EditCustomAttributes = "";
			$this->akun5->EditValue = ew_HtmlEncode($this->akun5->CurrentValue);
			$this->akun5->PlaceHolder = ew_RemoveHtml($this->akun5->FldCaption());

			// Add refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// tahun
			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";

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
		if (!$this->id->FldIsDetailKey && !is_null($this->id->FormValue) && $this->id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id->FldCaption(), $this->id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->id->FormValue)) {
			ew_AddMessage($gsFormError, $this->id->FldErrMsg());
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

		// id
		$this->id->SetDbValueDef($rsnew, $this->id->CurrentValue, 0, FALSE);

		// tahun
		$this->tahun->SetDbValueDef($rsnew, $this->tahun->CurrentValue, NULL, FALSE);

		// program
		$this->program->SetDbValueDef($rsnew, $this->program->CurrentValue, NULL, FALSE);

		// kode_rekening
		$this->kode_rekening->SetDbValueDef($rsnew, $this->kode_rekening->CurrentValue, NULL, FALSE);

		// akun1
		$this->akun1->SetDbValueDef($rsnew, $this->akun1->CurrentValue, NULL, FALSE);

		// akun2
		$this->akun2->SetDbValueDef($rsnew, $this->akun2->CurrentValue, NULL, FALSE);

		// akun3
		$this->akun3->SetDbValueDef($rsnew, $this->akun3->CurrentValue, NULL, FALSE);

		// akun4
		$this->akun4->SetDbValueDef($rsnew, $this->akun4->CurrentValue, NULL, FALSE);

		// akun5
		$this->akun5->SetDbValueDef($rsnew, $this->akun5->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['id']) == "") {
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_kegiatan_tahunan_rs_detaillist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_kegiatan_tahunan_rs_detail_add)) $m_kegiatan_tahunan_rs_detail_add = new cm_kegiatan_tahunan_rs_detail_add();

// Page init
$m_kegiatan_tahunan_rs_detail_add->Page_Init();

// Page main
$m_kegiatan_tahunan_rs_detail_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_kegiatan_tahunan_rs_detail_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fm_kegiatan_tahunan_rs_detailadd = new ew_Form("fm_kegiatan_tahunan_rs_detailadd", "add");

// Validate form
fm_kegiatan_tahunan_rs_detailadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_kegiatan_tahunan_rs_detail->id->FldCaption(), $m_kegiatan_tahunan_rs_detail->id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_kegiatan_tahunan_rs_detail->id->FldErrMsg()) ?>");

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
fm_kegiatan_tahunan_rs_detailadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_kegiatan_tahunan_rs_detailadd.ValidateRequired = true;
<?php } else { ?>
fm_kegiatan_tahunan_rs_detailadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_kegiatan_tahunan_rs_detail_add->IsModal) { ?>
<?php } ?>
<?php $m_kegiatan_tahunan_rs_detail_add->ShowPageHeader(); ?>
<?php
$m_kegiatan_tahunan_rs_detail_add->ShowMessage();
?>
<form name="fm_kegiatan_tahunan_rs_detailadd" id="fm_kegiatan_tahunan_rs_detailadd" class="<?php echo $m_kegiatan_tahunan_rs_detail_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_kegiatan_tahunan_rs_detail_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_kegiatan_tahunan_rs_detail">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($m_kegiatan_tahunan_rs_detail_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_kegiatan_tahunan_rs_detail->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_id" for="x_id" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->id->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_id">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_id" name="x_id" id="x_id" size="30" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->id->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->id->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->id->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->tahun->Visible) { // tahun ?>
	<div id="r_tahun" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_tahun" for="x_tahun" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->tahun->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->tahun->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_tahun">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_tahun" name="x_tahun" id="x_tahun" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->tahun->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->tahun->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->tahun->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->tahun->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->program->Visible) { // program ?>
	<div id="r_program" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_program" for="x_program" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->program->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->program->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_program">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_program" name="x_program" id="x_program" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->program->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->program->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->program->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->program->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->kode_rekening->Visible) { // kode_rekening ?>
	<div id="r_kode_rekening" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_kode_rekening" for="x_kode_rekening" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_kode_rekening">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_kode_rekening" name="x_kode_rekening" id="x_kode_rekening" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->kode_rekening->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->kode_rekening->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun1->Visible) { // akun1 ?>
	<div id="r_akun1" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_akun1" for="x_akun1" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->akun1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->akun1->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun1">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_akun1" name="x_akun1" id="x_akun1" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->akun1->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->akun1->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->akun1->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->akun1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun2->Visible) { // akun2 ?>
	<div id="r_akun2" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_akun2" for="x_akun2" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->akun2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->akun2->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun2">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_akun2" name="x_akun2" id="x_akun2" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->akun2->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->akun2->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->akun2->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->akun2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun3->Visible) { // akun3 ?>
	<div id="r_akun3" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_akun3" for="x_akun3" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->akun3->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->akun3->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun3">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_akun3" name="x_akun3" id="x_akun3" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->akun3->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->akun3->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->akun3->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->akun3->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun4->Visible) { // akun4 ?>
	<div id="r_akun4" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_akun4" for="x_akun4" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->akun4->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->akun4->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun4">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_akun4" name="x_akun4" id="x_akun4" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->akun4->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->akun4->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->akun4->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->akun4->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_kegiatan_tahunan_rs_detail->akun5->Visible) { // akun5 ?>
	<div id="r_akun5" class="form-group">
		<label id="elh_m_kegiatan_tahunan_rs_detail_akun5" for="x_akun5" class="col-sm-2 control-label ewLabel"><?php echo $m_kegiatan_tahunan_rs_detail->akun5->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_kegiatan_tahunan_rs_detail->akun5->CellAttributes() ?>>
<span id="el_m_kegiatan_tahunan_rs_detail_akun5">
<input type="text" data-table="m_kegiatan_tahunan_rs_detail" data-field="x_akun5" name="x_akun5" id="x_akun5" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_kegiatan_tahunan_rs_detail->akun5->getPlaceHolder()) ?>" value="<?php echo $m_kegiatan_tahunan_rs_detail->akun5->EditValue ?>"<?php echo $m_kegiatan_tahunan_rs_detail->akun5->EditAttributes() ?>>
</span>
<?php echo $m_kegiatan_tahunan_rs_detail->akun5->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_kegiatan_tahunan_rs_detail_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_kegiatan_tahunan_rs_detail_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_kegiatan_tahunan_rs_detailadd.Init();
</script>
<?php
$m_kegiatan_tahunan_rs_detail_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_kegiatan_tahunan_rs_detail_add->Page_Terminate();
?>
