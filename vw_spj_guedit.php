<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spj_guinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spj_gu_edit = NULL; // Initialize page object first

class cvw_spj_gu_edit extends cvw_spj_gu {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spj_gu';

	// Page object name
	var $PageObjName = 'vw_spj_gu_edit';

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

		// Table object (vw_spj_gu)
		if (!isset($GLOBALS["vw_spj_gu"]) || get_class($GLOBALS["vw_spj_gu"]) == "cvw_spj_gu") {
			$GLOBALS["vw_spj_gu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spj_gu"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spj_gu', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spj_gulist.php"));
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
		$this->no_spj->SetVisibility();
		$this->tgl_spj->SetVisibility();
		$this->tipe_sbp->SetVisibility();
		$this->no_sbp->SetVisibility();
		$this->tgl_sbp->SetVisibility();
		$this->uraian->SetVisibility();
		$this->nama_penerima->SetVisibility();

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
		global $EW_EXPORT, $vw_spj_gu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spj_gu);
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
			$this->Page_Terminate("vw_spj_gulist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_spj_gulist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_spj_gulist.php")
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
		if (!$this->no_spj->FldIsDetailKey) {
			$this->no_spj->setFormValue($objForm->GetValue("x_no_spj"));
		}
		if (!$this->tgl_spj->FldIsDetailKey) {
			$this->tgl_spj->setFormValue($objForm->GetValue("x_tgl_spj"));
			$this->tgl_spj->CurrentValue = ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7);
		}
		if (!$this->tipe_sbp->FldIsDetailKey) {
			$this->tipe_sbp->setFormValue($objForm->GetValue("x_tipe_sbp"));
		}
		if (!$this->no_sbp->FldIsDetailKey) {
			$this->no_sbp->setFormValue($objForm->GetValue("x_no_sbp"));
		}
		if (!$this->tgl_sbp->FldIsDetailKey) {
			$this->tgl_sbp->setFormValue($objForm->GetValue("x_tgl_sbp"));
			$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0);
		}
		if (!$this->uraian->FldIsDetailKey) {
			$this->uraian->setFormValue($objForm->GetValue("x_uraian"));
		}
		if (!$this->nama_penerima->FldIsDetailKey) {
			$this->nama_penerima->setFormValue($objForm->GetValue("x_nama_penerima"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->no_spj->CurrentValue = $this->no_spj->FormValue;
		$this->tgl_spj->CurrentValue = $this->tgl_spj->FormValue;
		$this->tgl_spj->CurrentValue = ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7);
		$this->tipe_sbp->CurrentValue = $this->tipe_sbp->FormValue;
		$this->no_sbp->CurrentValue = $this->no_sbp->FormValue;
		$this->tgl_sbp->CurrentValue = $this->tgl_sbp->FormValue;
		$this->tgl_sbp->CurrentValue = ew_UnFormatDateTime($this->tgl_sbp->CurrentValue, 0);
		$this->uraian->CurrentValue = $this->uraian->FormValue;
		$this->nama_penerima->CurrentValue = $this->nama_penerima->FormValue;
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
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->tipe->setDbValue($rs->fields('tipe'));
		$this->tipe_sbp->setDbValue($rs->fields('tipe_sbp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->tgl_sbp->setDbValue($rs->fields('tgl_sbp'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->nama_penerima->setDbValue($rs->fields('nama_penerima'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_spj->DbValue = $row['no_spj'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->tipe->DbValue = $row['tipe'];
		$this->tipe_sbp->DbValue = $row['tipe_sbp'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->tgl_sbp->DbValue = $row['tgl_sbp'];
		$this->uraian->DbValue = $row['uraian'];
		$this->nama_penerima->DbValue = $row['nama_penerima'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// no_spj
		// tgl_spj
		// tipe
		// tipe_sbp
		// no_sbp
		// tgl_sbp
		// uraian
		// nama_penerima

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 7);
		$this->tgl_spj->ViewCustomAttributes = "";

		// tipe
		if (strval($this->tipe->CurrentValue) <> "") {
			$this->tipe->ViewValue = $this->tipe->OptionCaption($this->tipe->CurrentValue);
		} else {
			$this->tipe->ViewValue = NULL;
		}
		$this->tipe->ViewCustomAttributes = "";

		// tipe_sbp
		if (strval($this->tipe_sbp->CurrentValue) <> "") {
			$this->tipe_sbp->ViewValue = $this->tipe_sbp->OptionCaption($this->tipe_sbp->CurrentValue);
		} else {
			$this->tipe_sbp->ViewValue = NULL;
		}
		$this->tipe_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

		// tgl_sbp
		$this->tgl_sbp->ViewValue = $this->tgl_sbp->CurrentValue;
		$this->tgl_sbp->ViewValue = ew_FormatDateTime($this->tgl_sbp->ViewValue, 0);
		$this->tgl_sbp->ViewCustomAttributes = "";

		// uraian
		$this->uraian->ViewValue = $this->uraian->CurrentValue;
		$this->uraian->ViewCustomAttributes = "";

		// nama_penerima
		$this->nama_penerima->ViewValue = $this->nama_penerima->CurrentValue;
		$this->nama_penerima->ViewCustomAttributes = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";
			$this->no_spj->TooltipValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";
			$this->tgl_spj->TooltipValue = "";

			// tipe_sbp
			$this->tipe_sbp->LinkCustomAttributes = "";
			$this->tipe_sbp->HrefValue = "";
			$this->tipe_sbp->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";
			$this->tgl_sbp->TooltipValue = "";

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";
			$this->uraian->TooltipValue = "";

			// nama_penerima
			$this->nama_penerima->LinkCustomAttributes = "";
			$this->nama_penerima->HrefValue = "";
			$this->nama_penerima->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// no_spj
			$this->no_spj->EditAttrs["class"] = "form-control";
			$this->no_spj->EditCustomAttributes = "";
			$this->no_spj->EditValue = ew_HtmlEncode($this->no_spj->CurrentValue);
			$this->no_spj->PlaceHolder = ew_RemoveHtml($this->no_spj->FldCaption());

			// tgl_spj
			$this->tgl_spj->EditAttrs["class"] = "form-control";
			$this->tgl_spj->EditCustomAttributes = "";
			$this->tgl_spj->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_spj->CurrentValue, 7));
			$this->tgl_spj->PlaceHolder = ew_RemoveHtml($this->tgl_spj->FldCaption());

			// tipe_sbp
			$this->tipe_sbp->EditAttrs["class"] = "form-control";
			$this->tipe_sbp->EditCustomAttributes = "";
			if (strval($this->tipe_sbp->CurrentValue) <> "") {
				$this->tipe_sbp->EditValue = $this->tipe_sbp->OptionCaption($this->tipe_sbp->CurrentValue);
			} else {
				$this->tipe_sbp->EditValue = NULL;
			}
			$this->tipe_sbp->ViewCustomAttributes = "";

			// no_sbp
			$this->no_sbp->EditAttrs["class"] = "form-control";
			$this->no_sbp->EditCustomAttributes = "";
			$this->no_sbp->EditValue = $this->no_sbp->CurrentValue;
			$this->no_sbp->ViewCustomAttributes = "";

			// tgl_sbp
			$this->tgl_sbp->EditAttrs["class"] = "form-control";
			$this->tgl_sbp->EditCustomAttributes = "";
			$this->tgl_sbp->EditValue = $this->tgl_sbp->CurrentValue;
			$this->tgl_sbp->EditValue = ew_FormatDateTime($this->tgl_sbp->EditValue, 0);
			$this->tgl_sbp->ViewCustomAttributes = "";

			// uraian
			$this->uraian->EditAttrs["class"] = "form-control";
			$this->uraian->EditCustomAttributes = "";
			$this->uraian->EditValue = $this->uraian->CurrentValue;
			$this->uraian->ViewCustomAttributes = "";

			// nama_penerima
			$this->nama_penerima->EditAttrs["class"] = "form-control";
			$this->nama_penerima->EditCustomAttributes = "";
			$this->nama_penerima->EditValue = $this->nama_penerima->CurrentValue;
			$this->nama_penerima->ViewCustomAttributes = "";

			// Edit refer script
			// no_spj

			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";

			// tipe_sbp
			$this->tipe_sbp->LinkCustomAttributes = "";
			$this->tipe_sbp->HrefValue = "";
			$this->tipe_sbp->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";
			$this->tgl_sbp->TooltipValue = "";

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";
			$this->uraian->TooltipValue = "";

			// nama_penerima
			$this->nama_penerima->LinkCustomAttributes = "";
			$this->nama_penerima->HrefValue = "";
			$this->nama_penerima->TooltipValue = "";
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
		if (!ew_CheckEuroDate($this->tgl_spj->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spj->FldErrMsg());
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

			// no_spj
			$this->no_spj->SetDbValueDef($rsnew, $this->no_spj->CurrentValue, NULL, $this->no_spj->ReadOnly);

			// tgl_spj
			$this->tgl_spj->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 7), NULL, $this->tgl_spj->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spj_gulist.php"), "", $this->TableVar, TRUE);
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
			$this->OtherOptions["edit"] = new cListOptions();
		$this->OtherOptions["edit"]->Body = "";
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
if (!isset($vw_spj_gu_edit)) $vw_spj_gu_edit = new cvw_spj_gu_edit();

// Page init
$vw_spj_gu_edit->Page_Init();

// Page main
$vw_spj_gu_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spj_gu_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_spj_guedit = new ew_Form("fvw_spj_guedit", "edit");

// Validate form
fvw_spj_guedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_spj");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spj_gu->tgl_spj->FldErrMsg()) ?>");

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
fvw_spj_guedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spj_guedit.ValidateRequired = true;
<?php } else { ?>
fvw_spj_guedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spj_guedit.Lists["x_tipe_sbp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spj_guedit.Lists["x_tipe_sbp"].Options = <?php echo json_encode($vw_spj_gu->tipe_sbp->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spj_gu_edit->IsModal) { ?>
<?php } ?>
<?php $vw_spj_gu_edit->ShowPageHeader(); ?>
<?php
$vw_spj_gu_edit->ShowMessage();
?>
<form name="fvw_spj_guedit" id="fvw_spj_guedit" class="<?php echo $vw_spj_gu_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spj_gu_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spj_gu_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spj_gu">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_spj_gu_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_spj_gu->no_spj->Visible) { // no_spj ?>
	<div id="r_no_spj" class="form-group">
		<label id="elh_vw_spj_gu_no_spj" for="x_no_spj" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->no_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->no_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_spj">
<input type="text" data-table="vw_spj_gu" data-field="x_no_spj" name="x_no_spj" id="x_no_spj" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->no_spj->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->no_spj->EditValue ?>"<?php echo $vw_spj_gu->no_spj->EditAttributes() ?>>
</span>
<?php echo $vw_spj_gu->no_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->tgl_spj->Visible) { // tgl_spj ?>
	<div id="r_tgl_spj" class="form-group">
		<label id="elh_vw_spj_gu_tgl_spj" for="x_tgl_spj" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->tgl_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->tgl_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_spj">
<input type="text" data-table="vw_spj_gu" data-field="x_tgl_spj" data-format="7" name="x_tgl_spj" id="x_tgl_spj" placeholder="<?php echo ew_HtmlEncode($vw_spj_gu->tgl_spj->getPlaceHolder()) ?>" value="<?php echo $vw_spj_gu->tgl_spj->EditValue ?>"<?php echo $vw_spj_gu->tgl_spj->EditAttributes() ?>>
<?php if (!$vw_spj_gu->tgl_spj->ReadOnly && !$vw_spj_gu->tgl_spj->Disabled && !isset($vw_spj_gu->tgl_spj->EditAttrs["readonly"]) && !isset($vw_spj_gu->tgl_spj->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_spj_guedit", "x_tgl_spj", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_spj_gu->tgl_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->tipe_sbp->Visible) { // tipe_sbp ?>
	<div id="r_tipe_sbp" class="form-group">
		<label id="elh_vw_spj_gu_tipe_sbp" for="x_tipe_sbp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->tipe_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->tipe_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tipe_sbp">
<span<?php echo $vw_spj_gu->tipe_sbp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spj_gu->tipe_sbp->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spj_gu" data-field="x_tipe_sbp" name="x_tipe_sbp" id="x_tipe_sbp" value="<?php echo ew_HtmlEncode($vw_spj_gu->tipe_sbp->CurrentValue) ?>">
<?php echo $vw_spj_gu->tipe_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->no_sbp->Visible) { // no_sbp ?>
	<div id="r_no_sbp" class="form-group">
		<label id="elh_vw_spj_gu_no_sbp" for="x_no_sbp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->no_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->no_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_sbp">
<span<?php echo $vw_spj_gu->no_sbp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spj_gu->no_sbp->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spj_gu" data-field="x_no_sbp" name="x_no_sbp" id="x_no_sbp" value="<?php echo ew_HtmlEncode($vw_spj_gu->no_sbp->CurrentValue) ?>">
<?php echo $vw_spj_gu->no_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->tgl_sbp->Visible) { // tgl_sbp ?>
	<div id="r_tgl_sbp" class="form-group">
		<label id="elh_vw_spj_gu_tgl_sbp" for="x_tgl_sbp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->tgl_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->tgl_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_sbp">
<span<?php echo $vw_spj_gu->tgl_sbp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spj_gu->tgl_sbp->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spj_gu" data-field="x_tgl_sbp" name="x_tgl_sbp" id="x_tgl_sbp" value="<?php echo ew_HtmlEncode($vw_spj_gu->tgl_sbp->CurrentValue) ?>">
<?php echo $vw_spj_gu->tgl_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->uraian->Visible) { // uraian ?>
	<div id="r_uraian" class="form-group">
		<label id="elh_vw_spj_gu_uraian" for="x_uraian" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->uraian->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->uraian->CellAttributes() ?>>
<span id="el_vw_spj_gu_uraian">
<span<?php echo $vw_spj_gu->uraian->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spj_gu->uraian->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spj_gu" data-field="x_uraian" name="x_uraian" id="x_uraian" value="<?php echo ew_HtmlEncode($vw_spj_gu->uraian->CurrentValue) ?>">
<?php echo $vw_spj_gu->uraian->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spj_gu->nama_penerima->Visible) { // nama_penerima ?>
	<div id="r_nama_penerima" class="form-group">
		<label id="elh_vw_spj_gu_nama_penerima" for="x_nama_penerima" class="col-sm-2 control-label ewLabel"><?php echo $vw_spj_gu->nama_penerima->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spj_gu->nama_penerima->CellAttributes() ?>>
<span id="el_vw_spj_gu_nama_penerima">
<span<?php echo $vw_spj_gu->nama_penerima->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spj_gu->nama_penerima->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_spj_gu" data-field="x_nama_penerima" name="x_nama_penerima" id="x_nama_penerima" value="<?php echo ew_HtmlEncode($vw_spj_gu->nama_penerima->CurrentValue) ?>">
<?php echo $vw_spj_gu->nama_penerima->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="vw_spj_gu" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($vw_spj_gu->id->CurrentValue) ?>">
<?php if (!$vw_spj_gu_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spj_gu_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spj_guedit.Init();
</script>
<?php
$vw_spj_gu_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spj_gu_edit->Page_Terminate();
?>
