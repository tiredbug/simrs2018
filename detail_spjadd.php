<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "detail_spjinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "t_spjinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$detail_spj_add = NULL; // Initialize page object first

class cdetail_spj_add extends cdetail_spj {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'detail_spj';

	// Page object name
	var $PageObjName = 'detail_spj_add';

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

		// Table object (detail_spj)
		if (!isset($GLOBALS["detail_spj"]) || get_class($GLOBALS["detail_spj"]) == "cdetail_spj") {
			$GLOBALS["detail_spj"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["detail_spj"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (t_spj)
		if (!isset($GLOBALS['t_spj'])) $GLOBALS['t_spj'] = new ct_spj();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'detail_spj', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("detail_spjlist.php"));
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
		$this->id_detail_sbp->SetVisibility();
		$this->no_spj->SetVisibility();
		$this->id_sbp->SetVisibility();
		$this->no_sbp->SetVisibility();

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
		global $EW_EXPORT, $detail_spj;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($detail_spj);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

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
					$this->Page_Terminate("detail_spjlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "detail_spjlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "detail_spjview.php")
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
		$this->id_detail_sbp->CurrentValue = NULL;
		$this->id_detail_sbp->OldValue = $this->id_detail_sbp->CurrentValue;
		$this->no_spj->CurrentValue = NULL;
		$this->no_spj->OldValue = $this->no_spj->CurrentValue;
		$this->id_sbp->CurrentValue = NULL;
		$this->id_sbp->OldValue = $this->id_sbp->CurrentValue;
		$this->no_sbp->CurrentValue = NULL;
		$this->no_sbp->OldValue = $this->no_sbp->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_detail_sbp->FldIsDetailKey) {
			$this->id_detail_sbp->setFormValue($objForm->GetValue("x_id_detail_sbp"));
		}
		if (!$this->no_spj->FldIsDetailKey) {
			$this->no_spj->setFormValue($objForm->GetValue("x_no_spj"));
		}
		if (!$this->id_sbp->FldIsDetailKey) {
			$this->id_sbp->setFormValue($objForm->GetValue("x_id_sbp"));
		}
		if (!$this->no_sbp->FldIsDetailKey) {
			$this->no_sbp->setFormValue($objForm->GetValue("x_no_sbp"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_detail_sbp->CurrentValue = $this->id_detail_sbp->FormValue;
		$this->no_spj->CurrentValue = $this->no_spj->FormValue;
		$this->id_sbp->CurrentValue = $this->id_sbp->FormValue;
		$this->no_sbp->CurrentValue = $this->no_sbp->FormValue;
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
		$this->id_detail_sbp->setDbValue($rs->fields('id_detail_sbp'));
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->id_sbp->setDbValue($rs->fields('id_sbp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->id_spj->setDbValue($rs->fields('id_spj'));
		$this->jenis_spj->setDbValue($rs->fields('jenis_spj'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->pajak->setDbValue($rs->fields('pajak'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_detail_sbp->DbValue = $row['id_detail_sbp'];
		$this->no_spj->DbValue = $row['no_spj'];
		$this->id_sbp->DbValue = $row['id_sbp'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->id_spj->DbValue = $row['id_spj'];
		$this->jenis_spj->DbValue = $row['jenis_spj'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
		$this->uraian->DbValue = $row['uraian'];
		$this->pajak->DbValue = $row['pajak'];
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
		// id_detail_sbp
		// no_spj
		// id_sbp
		// no_sbp
		// program
		// kegiatan
		// sub_kegiatan
		// tahun_anggaran
		// tgl_spj
		// id_spj
		// jenis_spj
		// jumlah_belanja
		// uraian
		// pajak

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_detail_sbp
		$this->id_detail_sbp->ViewValue = $this->id_detail_sbp->CurrentValue;
		if (strval($this->id_detail_sbp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_detail_sbp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_list_spj`";
		$sWhereWrk = "";
		$this->id_detail_sbp->LookupFilters = array("dx1" => '`no_sbp`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_detail_sbp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_detail_sbp->ViewValue = $this->id_detail_sbp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_detail_sbp->ViewValue = $this->id_detail_sbp->CurrentValue;
			}
		} else {
			$this->id_detail_sbp->ViewValue = NULL;
		}
		$this->id_detail_sbp->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// id_sbp
		$this->id_sbp->ViewValue = $this->id_sbp->CurrentValue;
		$this->id_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 0);
		$this->tgl_spj->ViewCustomAttributes = "";

		// id_spj
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		$this->id_spj->ViewCustomAttributes = "";

		// jenis_spj
		if (strval($this->jenis_spj->CurrentValue) <> "") {
			$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
		} else {
			$this->jenis_spj->ViewValue = NULL;
		}
		$this->jenis_spj->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

		// pajak
		$this->pajak->ViewValue = $this->pajak->CurrentValue;
		$this->pajak->ViewCustomAttributes = "";

			// id_detail_sbp
			$this->id_detail_sbp->LinkCustomAttributes = "";
			$this->id_detail_sbp->HrefValue = "";
			$this->id_detail_sbp->TooltipValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";
			$this->no_spj->TooltipValue = "";

			// id_sbp
			$this->id_sbp->LinkCustomAttributes = "";
			$this->id_sbp->HrefValue = "";
			$this->id_sbp->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_detail_sbp
			$this->id_detail_sbp->EditAttrs["class"] = "form-control";
			$this->id_detail_sbp->EditCustomAttributes = "";
			$this->id_detail_sbp->EditValue = ew_HtmlEncode($this->id_detail_sbp->CurrentValue);
			if (strval($this->id_detail_sbp->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_detail_sbp->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `id`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_list_spj`";
			$sWhereWrk = "";
			$this->id_detail_sbp->LookupFilters = array("dx1" => '`no_sbp`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->id_detail_sbp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->id_detail_sbp->EditValue = $this->id_detail_sbp->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->id_detail_sbp->EditValue = ew_HtmlEncode($this->id_detail_sbp->CurrentValue);
				}
			} else {
				$this->id_detail_sbp->EditValue = NULL;
			}
			$this->id_detail_sbp->PlaceHolder = ew_RemoveHtml($this->id_detail_sbp->FldCaption());

			// no_spj
			$this->no_spj->EditAttrs["class"] = "form-control";
			$this->no_spj->EditCustomAttributes = "";
			if ($this->no_spj->getSessionValue() <> "") {
				$this->no_spj->CurrentValue = $this->no_spj->getSessionValue();
			$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
			$this->no_spj->ViewCustomAttributes = "";
			} else {
			$this->no_spj->EditValue = ew_HtmlEncode($this->no_spj->CurrentValue);
			$this->no_spj->PlaceHolder = ew_RemoveHtml($this->no_spj->FldCaption());
			}

			// id_sbp
			$this->id_sbp->EditAttrs["class"] = "form-control";
			$this->id_sbp->EditCustomAttributes = "";
			$this->id_sbp->EditValue = ew_HtmlEncode($this->id_sbp->CurrentValue);
			$this->id_sbp->PlaceHolder = ew_RemoveHtml($this->id_sbp->FldCaption());

			// no_sbp
			$this->no_sbp->EditAttrs["class"] = "form-control";
			$this->no_sbp->EditCustomAttributes = "";
			$this->no_sbp->EditValue = ew_HtmlEncode($this->no_sbp->CurrentValue);
			$this->no_sbp->PlaceHolder = ew_RemoveHtml($this->no_sbp->FldCaption());

			// Add refer script
			// id_detail_sbp

			$this->id_detail_sbp->LinkCustomAttributes = "";
			$this->id_detail_sbp->HrefValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";

			// id_sbp
			$this->id_sbp->LinkCustomAttributes = "";
			$this->id_sbp->HrefValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
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
		if (!ew_CheckInteger($this->id_detail_sbp->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_detail_sbp->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_sbp->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_sbp->FldErrMsg());
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

		// Check referential integrity for master table 't_spj'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_t_spj();
		if (strval($this->no_spj->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@no_spj@", ew_AdjustSql($this->no_spj->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->id_spj->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@id@", ew_AdjustSql($this->id_spj->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->tgl_spj->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@tgl_spj@", ew_AdjustSql($this->tgl_spj->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->program->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@program@", ew_AdjustSql($this->program->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->kegiatan->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@kegiatan@", ew_AdjustSql($this->kegiatan->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->tahun_anggaran->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@tahun_anggaran@", ew_AdjustSql($this->tahun_anggaran->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->sub_kegiatan->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@sub_kegiatan@", ew_AdjustSql($this->sub_kegiatan->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->jenis_spj->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@jenis_spj@", ew_AdjustSql($this->jenis_spj->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["t_spj"])) $GLOBALS["t_spj"] = new ct_spj();
			$rsmaster = $GLOBALS["t_spj"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "t_spj", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// id_detail_sbp
		$this->id_detail_sbp->SetDbValueDef($rsnew, $this->id_detail_sbp->CurrentValue, NULL, FALSE);

		// no_spj
		$this->no_spj->SetDbValueDef($rsnew, $this->no_spj->CurrentValue, NULL, FALSE);

		// id_sbp
		$this->id_sbp->SetDbValueDef($rsnew, $this->id_sbp->CurrentValue, NULL, FALSE);

		// no_sbp
		$this->no_sbp->SetDbValueDef($rsnew, $this->no_sbp->CurrentValue, NULL, FALSE);

		// program
		if ($this->program->getSessionValue() <> "") {
			$rsnew['program'] = $this->program->getSessionValue();
		}

		// kegiatan
		if ($this->kegiatan->getSessionValue() <> "") {
			$rsnew['kegiatan'] = $this->kegiatan->getSessionValue();
		}

		// sub_kegiatan
		if ($this->sub_kegiatan->getSessionValue() <> "") {
			$rsnew['sub_kegiatan'] = $this->sub_kegiatan->getSessionValue();
		}

		// tahun_anggaran
		if ($this->tahun_anggaran->getSessionValue() <> "") {
			$rsnew['tahun_anggaran'] = $this->tahun_anggaran->getSessionValue();
		}

		// tgl_spj
		if ($this->tgl_spj->getSessionValue() <> "") {
			$rsnew['tgl_spj'] = $this->tgl_spj->getSessionValue();
		}

		// id_spj
		if ($this->id_spj->getSessionValue() <> "") {
			$rsnew['id_spj'] = $this->id_spj->getSessionValue();
		}

		// jenis_spj
		if ($this->jenis_spj->getSessionValue() <> "") {
			$rsnew['jenis_spj'] = $this->jenis_spj->getSessionValue();
		}

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
			if ($sMasterTblVar == "t_spj") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_no_spj"] <> "") {
					$GLOBALS["t_spj"]->no_spj->setQueryStringValue($_GET["fk_no_spj"]);
					$this->no_spj->setQueryStringValue($GLOBALS["t_spj"]->no_spj->QueryStringValue);
					$this->no_spj->setSessionValue($this->no_spj->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["t_spj"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_spj->setQueryStringValue($GLOBALS["t_spj"]->id->QueryStringValue);
					$this->id_spj->setSessionValue($this->id_spj->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tgl_spj"] <> "") {
					$GLOBALS["t_spj"]->tgl_spj->setQueryStringValue($_GET["fk_tgl_spj"]);
					$this->tgl_spj->setQueryStringValue($GLOBALS["t_spj"]->tgl_spj->QueryStringValue);
					$this->tgl_spj->setSessionValue($this->tgl_spj->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_program"] <> "") {
					$GLOBALS["t_spj"]->program->setQueryStringValue($_GET["fk_program"]);
					$this->program->setQueryStringValue($GLOBALS["t_spj"]->program->QueryStringValue);
					$this->program->setSessionValue($this->program->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->kegiatan->setQueryStringValue($_GET["fk_kegiatan"]);
					$this->kegiatan->setQueryStringValue($GLOBALS["t_spj"]->kegiatan->QueryStringValue);
					$this->kegiatan->setSessionValue($this->kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_spj"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["t_spj"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->sub_kegiatan->setQueryStringValue($_GET["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setQueryStringValue($GLOBALS["t_spj"]->sub_kegiatan->QueryStringValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_jenis_spj"] <> "") {
					$GLOBALS["t_spj"]->jenis_spj->setQueryStringValue($_GET["fk_jenis_spj"]);
					$this->jenis_spj->setQueryStringValue($GLOBALS["t_spj"]->jenis_spj->QueryStringValue);
					$this->jenis_spj->setSessionValue($this->jenis_spj->QueryStringValue);
					if (!is_numeric($GLOBALS["t_spj"]->jenis_spj->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "t_spj") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_no_spj"] <> "") {
					$GLOBALS["t_spj"]->no_spj->setFormValue($_POST["fk_no_spj"]);
					$this->no_spj->setFormValue($GLOBALS["t_spj"]->no_spj->FormValue);
					$this->no_spj->setSessionValue($this->no_spj->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["t_spj"]->id->setFormValue($_POST["fk_id"]);
					$this->id_spj->setFormValue($GLOBALS["t_spj"]->id->FormValue);
					$this->id_spj->setSessionValue($this->id_spj->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tgl_spj"] <> "") {
					$GLOBALS["t_spj"]->tgl_spj->setFormValue($_POST["fk_tgl_spj"]);
					$this->tgl_spj->setFormValue($GLOBALS["t_spj"]->tgl_spj->FormValue);
					$this->tgl_spj->setSessionValue($this->tgl_spj->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_program"] <> "") {
					$GLOBALS["t_spj"]->program->setFormValue($_POST["fk_program"]);
					$this->program->setFormValue($GLOBALS["t_spj"]->program->FormValue);
					$this->program->setSessionValue($this->program->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->kegiatan->setFormValue($_POST["fk_kegiatan"]);
					$this->kegiatan->setFormValue($GLOBALS["t_spj"]->kegiatan->FormValue);
					$this->kegiatan->setSessionValue($this->kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["t_spj"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["t_spj"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_sub_kegiatan"] <> "") {
					$GLOBALS["t_spj"]->sub_kegiatan->setFormValue($_POST["fk_sub_kegiatan"]);
					$this->sub_kegiatan->setFormValue($GLOBALS["t_spj"]->sub_kegiatan->FormValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_jenis_spj"] <> "") {
					$GLOBALS["t_spj"]->jenis_spj->setFormValue($_POST["fk_jenis_spj"]);
					$this->jenis_spj->setFormValue($GLOBALS["t_spj"]->jenis_spj->FormValue);
					$this->jenis_spj->setSessionValue($this->jenis_spj->FormValue);
					if (!is_numeric($GLOBALS["t_spj"]->jenis_spj->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "t_spj") {
				if ($this->no_spj->CurrentValue == "") $this->no_spj->setSessionValue("");
				if ($this->id_spj->CurrentValue == "") $this->id_spj->setSessionValue("");
				if ($this->tgl_spj->CurrentValue == "") $this->tgl_spj->setSessionValue("");
				if ($this->program->CurrentValue == "") $this->program->setSessionValue("");
				if ($this->kegiatan->CurrentValue == "") $this->kegiatan->setSessionValue("");
				if ($this->tahun_anggaran->CurrentValue == "") $this->tahun_anggaran->setSessionValue("");
				if ($this->sub_kegiatan->CurrentValue == "") $this->sub_kegiatan->setSessionValue("");
				if ($this->jenis_spj->CurrentValue == "") $this->jenis_spj->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("detail_spjlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_id_detail_sbp":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_list_spj`";
			$sWhereWrk = "{filter}";
			$this->id_detail_sbp->LookupFilters = array("dx1" => '`no_sbp`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_detail_sbp, $sWhereWrk); // Call Lookup selecting
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
		case "x_id_detail_sbp":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id`, `no_sbp` AS `DispFld` FROM `vw_list_spj`";
			$sWhereWrk = "`no_sbp` LIKE '%{query_value}%'";
			$this->id_detail_sbp->LookupFilters = array("dx1" => '`no_sbp`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->id_detail_sbp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($detail_spj_add)) $detail_spj_add = new cdetail_spj_add();

// Page init
$detail_spj_add->Page_Init();

// Page main
$detail_spj_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$detail_spj_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdetail_spjadd = new ew_Form("fdetail_spjadd", "add");

// Validate form
fdetail_spjadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id_detail_sbp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->id_detail_sbp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_sbp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($detail_spj->id_sbp->FldErrMsg()) ?>");

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
fdetail_spjadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdetail_spjadd.ValidateRequired = true;
<?php } else { ?>
fdetail_spjadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdetail_spjadd.Lists["x_id_detail_sbp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_no_sbp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_list_spj"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$detail_spj_add->IsModal) { ?>
<?php } ?>
<?php $detail_spj_add->ShowPageHeader(); ?>
<?php
$detail_spj_add->ShowMessage();
?>
<form name="fdetail_spjadd" id="fdetail_spjadd" class="<?php echo $detail_spj_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($detail_spj_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $detail_spj_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="detail_spj">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($detail_spj_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($detail_spj->getCurrentMasterTable() == "t_spj") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="t_spj">
<input type="hidden" name="fk_no_spj" value="<?php echo $detail_spj->no_spj->getSessionValue() ?>">
<input type="hidden" name="fk_id" value="<?php echo $detail_spj->id_spj->getSessionValue() ?>">
<input type="hidden" name="fk_tgl_spj" value="<?php echo $detail_spj->tgl_spj->getSessionValue() ?>">
<input type="hidden" name="fk_program" value="<?php echo $detail_spj->program->getSessionValue() ?>">
<input type="hidden" name="fk_kegiatan" value="<?php echo $detail_spj->kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_tahun_anggaran" value="<?php echo $detail_spj->tahun_anggaran->getSessionValue() ?>">
<input type="hidden" name="fk_sub_kegiatan" value="<?php echo $detail_spj->sub_kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_jenis_spj" value="<?php echo $detail_spj->jenis_spj->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($detail_spj->id_detail_sbp->Visible) { // id_detail_sbp ?>
	<div id="r_id_detail_sbp" class="form-group">
		<label id="elh_detail_spj_id_detail_sbp" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->id_detail_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->id_detail_sbp->CellAttributes() ?>>
<span id="el_detail_spj_id_detail_sbp">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$detail_spj->id_detail_sbp->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$detail_spj->id_detail_sbp->EditAttrs["onchange"] = "";
?>
<span id="as_x_id_detail_sbp" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_id_detail_sbp" id="sv_x_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->getPlaceHolder()) ?>"<?php echo $detail_spj->id_detail_sbp->EditAttributes() ?>>
</span>
<input type="hidden" data-table="detail_spj" data-field="x_id_detail_sbp" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $detail_spj->id_detail_sbp->DisplayValueSeparatorAttribute() ?>" name="x_id_detail_sbp" id="x_id_detail_sbp" value="<?php echo ew_HtmlEncode($detail_spj->id_detail_sbp->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_id_detail_sbp" id="q_x_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fdetail_spjadd.CreateAutoSuggest({"id":"x_id_detail_sbp","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($detail_spj->id_detail_sbp->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_id_detail_sbp',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_id_detail_sbp" id="s_x_id_detail_sbp" value="<?php echo $detail_spj->id_detail_sbp->LookupFilterQuery(false) ?>">
<input type="hidden" name="ln_x_id_detail_sbp" id="ln_x_id_detail_sbp" value="x_id_sbp,x_no_sbp">
</span>
<?php echo $detail_spj->id_detail_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->no_spj->Visible) { // no_spj ?>
	<div id="r_no_spj" class="form-group">
		<label id="elh_detail_spj_no_spj" for="x_no_spj" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->no_spj->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->no_spj->CellAttributes() ?>>
<?php if ($detail_spj->no_spj->getSessionValue() <> "") { ?>
<span id="el_detail_spj_no_spj">
<span<?php echo $detail_spj->no_spj->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $detail_spj->no_spj->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_no_spj" name="x_no_spj" value="<?php echo ew_HtmlEncode($detail_spj->no_spj->CurrentValue) ?>">
<?php } else { ?>
<span id="el_detail_spj_no_spj">
<input type="text" data-table="detail_spj" data-field="x_no_spj" name="x_no_spj" id="x_no_spj" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->no_spj->getPlaceHolder()) ?>" value="<?php echo $detail_spj->no_spj->EditValue ?>"<?php echo $detail_spj->no_spj->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $detail_spj->no_spj->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->id_sbp->Visible) { // id_sbp ?>
	<div id="r_id_sbp" class="form-group">
		<label id="elh_detail_spj_id_sbp" for="x_id_sbp" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->id_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->id_sbp->CellAttributes() ?>>
<span id="el_detail_spj_id_sbp">
<input type="text" data-table="detail_spj" data-field="x_id_sbp" name="x_id_sbp" id="x_id_sbp" size="30" placeholder="<?php echo ew_HtmlEncode($detail_spj->id_sbp->getPlaceHolder()) ?>" value="<?php echo $detail_spj->id_sbp->EditValue ?>"<?php echo $detail_spj->id_sbp->EditAttributes() ?>>
</span>
<?php echo $detail_spj->id_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($detail_spj->no_sbp->Visible) { // no_sbp ?>
	<div id="r_no_sbp" class="form-group">
		<label id="elh_detail_spj_no_sbp" for="x_no_sbp" class="col-sm-2 control-label ewLabel"><?php echo $detail_spj->no_sbp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $detail_spj->no_sbp->CellAttributes() ?>>
<span id="el_detail_spj_no_sbp">
<input type="text" data-table="detail_spj" data-field="x_no_sbp" name="x_no_sbp" id="x_no_sbp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($detail_spj->no_sbp->getPlaceHolder()) ?>" value="<?php echo $detail_spj->no_sbp->EditValue ?>"<?php echo $detail_spj->no_sbp->EditAttributes() ?>>
</span>
<?php echo $detail_spj->no_sbp->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($detail_spj->program->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_program" id="x_program" value="<?php echo ew_HtmlEncode(strval($detail_spj->program->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($detail_spj->kegiatan->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_kegiatan" id="x_kegiatan" value="<?php echo ew_HtmlEncode(strval($detail_spj->kegiatan->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($detail_spj->sub_kegiatan->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_sub_kegiatan" id="x_sub_kegiatan" value="<?php echo ew_HtmlEncode(strval($detail_spj->sub_kegiatan->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($detail_spj->tahun_anggaran->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_tahun_anggaran" id="x_tahun_anggaran" value="<?php echo ew_HtmlEncode(strval($detail_spj->tahun_anggaran->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($detail_spj->tgl_spj->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_tgl_spj" id="x_tgl_spj" value="<?php echo ew_HtmlEncode(strval($detail_spj->tgl_spj->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($detail_spj->id_spj->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_id_spj" id="x_id_spj" value="<?php echo ew_HtmlEncode(strval($detail_spj->id_spj->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($detail_spj->jenis_spj->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_jenis_spj" id="x_jenis_spj" value="<?php echo ew_HtmlEncode(strval($detail_spj->jenis_spj->getSessionValue())) ?>">
<?php } ?>
<?php if (!$detail_spj_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $detail_spj_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fdetail_spjadd.Init();
</script>
<?php
$detail_spj_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$detail_spj_add->Page_Terminate();
?>
