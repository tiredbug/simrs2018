<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_mutasi_bank_tunaiinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_mutasi_bank_tunai_edit = NULL; // Initialize page object first

class cvw_mutasi_bank_tunai_edit extends cvw_mutasi_bank_tunai {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_mutasi_bank_tunai';

	// Page object name
	var $PageObjName = 'vw_mutasi_bank_tunai_edit';

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

		// Table object (vw_mutasi_bank_tunai)
		if (!isset($GLOBALS["vw_mutasi_bank_tunai"]) || get_class($GLOBALS["vw_mutasi_bank_tunai"]) == "cvw_mutasi_bank_tunai") {
			$GLOBALS["vw_mutasi_bank_tunai"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_mutasi_bank_tunai"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_mutasi_bank_tunai', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_mutasi_bank_tunailist.php"));
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
		$this->jenis_mutasi->SetVisibility();
		$this->no_bukti->SetVisibility();
		$this->tgl_bukti->SetVisibility();
		$this->uraian->SetVisibility();
		$this->jumlah->SetVisibility();

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
		global $EW_EXPORT, $vw_mutasi_bank_tunai;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_mutasi_bank_tunai);
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
			$this->Page_Terminate("vw_mutasi_bank_tunailist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_mutasi_bank_tunailist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_mutasi_bank_tunailist.php")
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
		if (!$this->jenis_mutasi->FldIsDetailKey) {
			$this->jenis_mutasi->setFormValue($objForm->GetValue("x_jenis_mutasi"));
		}
		if (!$this->no_bukti->FldIsDetailKey) {
			$this->no_bukti->setFormValue($objForm->GetValue("x_no_bukti"));
		}
		if (!$this->tgl_bukti->FldIsDetailKey) {
			$this->tgl_bukti->setFormValue($objForm->GetValue("x_tgl_bukti"));
			$this->tgl_bukti->CurrentValue = ew_UnFormatDateTime($this->tgl_bukti->CurrentValue, 7);
		}
		if (!$this->uraian->FldIsDetailKey) {
			$this->uraian->setFormValue($objForm->GetValue("x_uraian"));
		}
		if (!$this->jumlah->FldIsDetailKey) {
			$this->jumlah->setFormValue($objForm->GetValue("x_jumlah"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->jenis_mutasi->CurrentValue = $this->jenis_mutasi->FormValue;
		$this->no_bukti->CurrentValue = $this->no_bukti->FormValue;
		$this->tgl_bukti->CurrentValue = $this->tgl_bukti->FormValue;
		$this->tgl_bukti->CurrentValue = ew_UnFormatDateTime($this->tgl_bukti->CurrentValue, 7);
		$this->uraian->CurrentValue = $this->uraian->FormValue;
		$this->jumlah->CurrentValue = $this->jumlah->FormValue;
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
		$this->jenis_mutasi->setDbValue($rs->fields('jenis_mutasi'));
		$this->no_bukti->setDbValue($rs->fields('no_bukti'));
		$this->tgl_bukti->setDbValue($rs->fields('tgl_bukti'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->jumlah->setDbValue($rs->fields('jumlah'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->jenis_mutasi->DbValue = $row['jenis_mutasi'];
		$this->no_bukti->DbValue = $row['no_bukti'];
		$this->tgl_bukti->DbValue = $row['tgl_bukti'];
		$this->uraian->DbValue = $row['uraian'];
		$this->jumlah->DbValue = $row['jumlah'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->jumlah->FormValue == $this->jumlah->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah->CurrentValue)))
			$this->jumlah->CurrentValue = ew_StrToFloat($this->jumlah->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// jenis_mutasi
		// no_bukti
		// tgl_bukti
		// uraian
		// jumlah

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// jenis_mutasi
		if (strval($this->jenis_mutasi->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->jenis_mutasi->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `jenis_mutasi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_mutasi`";
		$sWhereWrk = "";
		$this->jenis_mutasi->LookupFilters = array();
		$lookuptblfilter = "`id`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->jenis_mutasi, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->jenis_mutasi->ViewValue = $this->jenis_mutasi->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->jenis_mutasi->ViewValue = $this->jenis_mutasi->CurrentValue;
			}
		} else {
			$this->jenis_mutasi->ViewValue = NULL;
		}
		$this->jenis_mutasi->ViewCustomAttributes = "";

		// no_bukti
		$this->no_bukti->ViewValue = $this->no_bukti->CurrentValue;
		$this->no_bukti->ViewCustomAttributes = "";

		// tgl_bukti
		$this->tgl_bukti->ViewValue = $this->tgl_bukti->CurrentValue;
		$this->tgl_bukti->ViewValue = ew_FormatDateTime($this->tgl_bukti->ViewValue, 7);
		$this->tgl_bukti->ViewCustomAttributes = "";

		// uraian
		$this->uraian->ViewValue = $this->uraian->CurrentValue;
		$this->uraian->ViewCustomAttributes = "";

		// jumlah
		$this->jumlah->ViewValue = $this->jumlah->CurrentValue;
		$this->jumlah->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// jenis_mutasi
			$this->jenis_mutasi->LinkCustomAttributes = "";
			$this->jenis_mutasi->HrefValue = "";
			$this->jenis_mutasi->TooltipValue = "";

			// no_bukti
			$this->no_bukti->LinkCustomAttributes = "";
			$this->no_bukti->HrefValue = "";
			$this->no_bukti->TooltipValue = "";

			// tgl_bukti
			$this->tgl_bukti->LinkCustomAttributes = "";
			$this->tgl_bukti->HrefValue = "";
			$this->tgl_bukti->TooltipValue = "";

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";
			$this->uraian->TooltipValue = "";

			// jumlah
			$this->jumlah->LinkCustomAttributes = "";
			$this->jumlah->HrefValue = "";
			$this->jumlah->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// jenis_mutasi
			$this->jenis_mutasi->EditAttrs["class"] = "form-control";
			$this->jenis_mutasi->EditCustomAttributes = "";
			if (trim(strval($this->jenis_mutasi->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->jenis_mutasi->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `jenis_mutasi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jenis_mutasi`";
			$sWhereWrk = "";
			$this->jenis_mutasi->LookupFilters = array();
			$lookuptblfilter = "`id`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->jenis_mutasi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->jenis_mutasi->EditValue = $arwrk;

			// no_bukti
			$this->no_bukti->EditAttrs["class"] = "form-control";
			$this->no_bukti->EditCustomAttributes = "";
			$this->no_bukti->EditValue = ew_HtmlEncode($this->no_bukti->CurrentValue);
			$this->no_bukti->PlaceHolder = ew_RemoveHtml($this->no_bukti->FldCaption());

			// tgl_bukti
			$this->tgl_bukti->EditAttrs["class"] = "form-control";
			$this->tgl_bukti->EditCustomAttributes = "";
			$this->tgl_bukti->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_bukti->CurrentValue, 7));
			$this->tgl_bukti->PlaceHolder = ew_RemoveHtml($this->tgl_bukti->FldCaption());

			// uraian
			$this->uraian->EditAttrs["class"] = "form-control";
			$this->uraian->EditCustomAttributes = "";
			$this->uraian->EditValue = ew_HtmlEncode($this->uraian->CurrentValue);
			$this->uraian->PlaceHolder = ew_RemoveHtml($this->uraian->FldCaption());

			// jumlah
			$this->jumlah->EditAttrs["class"] = "form-control";
			$this->jumlah->EditCustomAttributes = "";
			$this->jumlah->EditValue = ew_HtmlEncode($this->jumlah->CurrentValue);
			$this->jumlah->PlaceHolder = ew_RemoveHtml($this->jumlah->FldCaption());
			if (strval($this->jumlah->EditValue) <> "" && is_numeric($this->jumlah->EditValue)) $this->jumlah->EditValue = ew_FormatNumber($this->jumlah->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// jenis_mutasi
			$this->jenis_mutasi->LinkCustomAttributes = "";
			$this->jenis_mutasi->HrefValue = "";

			// no_bukti
			$this->no_bukti->LinkCustomAttributes = "";
			$this->no_bukti->HrefValue = "";

			// tgl_bukti
			$this->tgl_bukti->LinkCustomAttributes = "";
			$this->tgl_bukti->HrefValue = "";

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";

			// jumlah
			$this->jumlah->LinkCustomAttributes = "";
			$this->jumlah->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->tgl_bukti->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_bukti->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah->FldErrMsg());
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

			// jenis_mutasi
			$this->jenis_mutasi->SetDbValueDef($rsnew, $this->jenis_mutasi->CurrentValue, NULL, $this->jenis_mutasi->ReadOnly);

			// no_bukti
			$this->no_bukti->SetDbValueDef($rsnew, $this->no_bukti->CurrentValue, NULL, $this->no_bukti->ReadOnly);

			// tgl_bukti
			$this->tgl_bukti->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_bukti->CurrentValue, 7), NULL, $this->tgl_bukti->ReadOnly);

			// uraian
			$this->uraian->SetDbValueDef($rsnew, $this->uraian->CurrentValue, NULL, $this->uraian->ReadOnly);

			// jumlah
			$this->jumlah->SetDbValueDef($rsnew, $this->jumlah->CurrentValue, NULL, $this->jumlah->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_mutasi_bank_tunailist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_jenis_mutasi":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `jenis_mutasi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_mutasi`";
			$sWhereWrk = "";
			$this->jenis_mutasi->LookupFilters = array();
			$lookuptblfilter = "`id`=1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->jenis_mutasi, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($vw_mutasi_bank_tunai_edit)) $vw_mutasi_bank_tunai_edit = new cvw_mutasi_bank_tunai_edit();

// Page init
$vw_mutasi_bank_tunai_edit->Page_Init();

// Page main
$vw_mutasi_bank_tunai_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_mutasi_bank_tunai_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_mutasi_bank_tunaiedit = new ew_Form("fvw_mutasi_bank_tunaiedit", "edit");

// Validate form
fvw_mutasi_bank_tunaiedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tgl_bukti");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_mutasi_bank_tunai->tgl_bukti->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_mutasi_bank_tunai->jumlah->FldErrMsg()) ?>");

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
fvw_mutasi_bank_tunaiedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_mutasi_bank_tunaiedit.ValidateRequired = true;
<?php } else { ?>
fvw_mutasi_bank_tunaiedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_mutasi_bank_tunaiedit.Lists["x_jenis_mutasi"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_mutasi","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_mutasi"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_mutasi_bank_tunai_edit->IsModal) { ?>
<?php } ?>
<?php $vw_mutasi_bank_tunai_edit->ShowPageHeader(); ?>
<?php
$vw_mutasi_bank_tunai_edit->ShowMessage();
?>
<form name="fvw_mutasi_bank_tunaiedit" id="fvw_mutasi_bank_tunaiedit" class="<?php echo $vw_mutasi_bank_tunai_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_mutasi_bank_tunai_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_mutasi_bank_tunai_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_mutasi_bank_tunai">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_mutasi_bank_tunai_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_mutasi_bank_tunai->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_vw_mutasi_bank_tunai_id" class="col-sm-2 control-label ewLabel"><?php echo $vw_mutasi_bank_tunai->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_mutasi_bank_tunai->id->CellAttributes() ?>>
<span id="el_vw_mutasi_bank_tunai_id">
<span<?php echo $vw_mutasi_bank_tunai->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_mutasi_bank_tunai->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_mutasi_bank_tunai" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($vw_mutasi_bank_tunai->id->CurrentValue) ?>">
<?php echo $vw_mutasi_bank_tunai->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_mutasi_bank_tunai->jenis_mutasi->Visible) { // jenis_mutasi ?>
	<div id="r_jenis_mutasi" class="form-group">
		<label id="elh_vw_mutasi_bank_tunai_jenis_mutasi" for="x_jenis_mutasi" class="col-sm-2 control-label ewLabel"><?php echo $vw_mutasi_bank_tunai->jenis_mutasi->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_mutasi_bank_tunai->jenis_mutasi->CellAttributes() ?>>
<span id="el_vw_mutasi_bank_tunai_jenis_mutasi">
<select data-table="vw_mutasi_bank_tunai" data-field="x_jenis_mutasi" data-value-separator="<?php echo $vw_mutasi_bank_tunai->jenis_mutasi->DisplayValueSeparatorAttribute() ?>" id="x_jenis_mutasi" name="x_jenis_mutasi"<?php echo $vw_mutasi_bank_tunai->jenis_mutasi->EditAttributes() ?>>
<?php echo $vw_mutasi_bank_tunai->jenis_mutasi->SelectOptionListHtml("x_jenis_mutasi") ?>
</select>
<input type="hidden" name="s_x_jenis_mutasi" id="s_x_jenis_mutasi" value="<?php echo $vw_mutasi_bank_tunai->jenis_mutasi->LookupFilterQuery() ?>">
</span>
<?php echo $vw_mutasi_bank_tunai->jenis_mutasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_mutasi_bank_tunai->no_bukti->Visible) { // no_bukti ?>
	<div id="r_no_bukti" class="form-group">
		<label id="elh_vw_mutasi_bank_tunai_no_bukti" for="x_no_bukti" class="col-sm-2 control-label ewLabel"><?php echo $vw_mutasi_bank_tunai->no_bukti->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_mutasi_bank_tunai->no_bukti->CellAttributes() ?>>
<span id="el_vw_mutasi_bank_tunai_no_bukti">
<input type="text" data-table="vw_mutasi_bank_tunai" data-field="x_no_bukti" name="x_no_bukti" id="x_no_bukti" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_mutasi_bank_tunai->no_bukti->getPlaceHolder()) ?>" value="<?php echo $vw_mutasi_bank_tunai->no_bukti->EditValue ?>"<?php echo $vw_mutasi_bank_tunai->no_bukti->EditAttributes() ?>>
</span>
<?php echo $vw_mutasi_bank_tunai->no_bukti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_mutasi_bank_tunai->tgl_bukti->Visible) { // tgl_bukti ?>
	<div id="r_tgl_bukti" class="form-group">
		<label id="elh_vw_mutasi_bank_tunai_tgl_bukti" for="x_tgl_bukti" class="col-sm-2 control-label ewLabel"><?php echo $vw_mutasi_bank_tunai->tgl_bukti->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_mutasi_bank_tunai->tgl_bukti->CellAttributes() ?>>
<span id="el_vw_mutasi_bank_tunai_tgl_bukti">
<input type="text" data-table="vw_mutasi_bank_tunai" data-field="x_tgl_bukti" data-format="7" name="x_tgl_bukti" id="x_tgl_bukti" placeholder="<?php echo ew_HtmlEncode($vw_mutasi_bank_tunai->tgl_bukti->getPlaceHolder()) ?>" value="<?php echo $vw_mutasi_bank_tunai->tgl_bukti->EditValue ?>"<?php echo $vw_mutasi_bank_tunai->tgl_bukti->EditAttributes() ?>>
<?php if (!$vw_mutasi_bank_tunai->tgl_bukti->ReadOnly && !$vw_mutasi_bank_tunai->tgl_bukti->Disabled && !isset($vw_mutasi_bank_tunai->tgl_bukti->EditAttrs["readonly"]) && !isset($vw_mutasi_bank_tunai->tgl_bukti->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_mutasi_bank_tunaiedit", "x_tgl_bukti", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_mutasi_bank_tunai->tgl_bukti->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_mutasi_bank_tunai->uraian->Visible) { // uraian ?>
	<div id="r_uraian" class="form-group">
		<label id="elh_vw_mutasi_bank_tunai_uraian" for="x_uraian" class="col-sm-2 control-label ewLabel"><?php echo $vw_mutasi_bank_tunai->uraian->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_mutasi_bank_tunai->uraian->CellAttributes() ?>>
<span id="el_vw_mutasi_bank_tunai_uraian">
<input type="text" data-table="vw_mutasi_bank_tunai" data-field="x_uraian" name="x_uraian" id="x_uraian" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_mutasi_bank_tunai->uraian->getPlaceHolder()) ?>" value="<?php echo $vw_mutasi_bank_tunai->uraian->EditValue ?>"<?php echo $vw_mutasi_bank_tunai->uraian->EditAttributes() ?>>
</span>
<?php echo $vw_mutasi_bank_tunai->uraian->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_mutasi_bank_tunai->jumlah->Visible) { // jumlah ?>
	<div id="r_jumlah" class="form-group">
		<label id="elh_vw_mutasi_bank_tunai_jumlah" for="x_jumlah" class="col-sm-2 control-label ewLabel"><?php echo $vw_mutasi_bank_tunai->jumlah->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_mutasi_bank_tunai->jumlah->CellAttributes() ?>>
<span id="el_vw_mutasi_bank_tunai_jumlah">
<input type="text" data-table="vw_mutasi_bank_tunai" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" placeholder="<?php echo ew_HtmlEncode($vw_mutasi_bank_tunai->jumlah->getPlaceHolder()) ?>" value="<?php echo $vw_mutasi_bank_tunai->jumlah->EditValue ?>"<?php echo $vw_mutasi_bank_tunai->jumlah->EditAttributes() ?>>
</span>
<?php echo $vw_mutasi_bank_tunai->jumlah->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_mutasi_bank_tunai_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_mutasi_bank_tunai_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_mutasi_bank_tunaiedit.Init();
</script>
<?php
$vw_mutasi_bank_tunai_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_mutasi_bank_tunai_edit->Page_Terminate();
?>
