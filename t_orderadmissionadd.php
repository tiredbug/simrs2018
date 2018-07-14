<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_orderadmissioninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_orderadmission_add = NULL; // Initialize page object first

class ct_orderadmission_add extends ct_orderadmission {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_orderadmission';

	// Page object name
	var $PageObjName = 't_orderadmission_add';

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

		// Table object (t_orderadmission)
		if (!isset($GLOBALS["t_orderadmission"]) || get_class($GLOBALS["t_orderadmission"]) == "ct_orderadmission") {
			$GLOBALS["t_orderadmission"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_orderadmission"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_orderadmission', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_orderadmissionlist.php"));
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
		$this->TGLORDER->SetVisibility();
		$this->IDXDAFTAR->SetVisibility();
		$this->NOMR->SetVisibility();
		$this->POLYPENGIRIM->SetVisibility();
		$this->DRPENGIRIM->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->KDRUJUK->SetVisibility();
		$this->STATUS->SetVisibility();

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
		global $EW_EXPORT, $t_orderadmission;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_orderadmission);
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
			if (@$_GET["IDXORDER"] != "") {
				$this->IDXORDER->setQueryStringValue($_GET["IDXORDER"]);
				$this->setKey("IDXORDER", $this->IDXORDER->CurrentValue); // Set up key
			} else {
				$this->setKey("IDXORDER", ""); // Clear key
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
					$this->Page_Terminate("t_orderadmissionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_orderadmissionlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_orderadmissionview.php")
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
		$this->TGLORDER->CurrentValue = NULL;
		$this->TGLORDER->OldValue = $this->TGLORDER->CurrentValue;
		$this->IDXDAFTAR->CurrentValue = NULL;
		$this->IDXDAFTAR->OldValue = $this->IDXDAFTAR->CurrentValue;
		$this->NOMR->CurrentValue = NULL;
		$this->NOMR->OldValue = $this->NOMR->CurrentValue;
		$this->POLYPENGIRIM->CurrentValue = NULL;
		$this->POLYPENGIRIM->OldValue = $this->POLYPENGIRIM->CurrentValue;
		$this->DRPENGIRIM->CurrentValue = NULL;
		$this->DRPENGIRIM->OldValue = $this->DRPENGIRIM->CurrentValue;
		$this->KDCARABAYAR->CurrentValue = NULL;
		$this->KDCARABAYAR->OldValue = $this->KDCARABAYAR->CurrentValue;
		$this->KDRUJUK->CurrentValue = NULL;
		$this->KDRUJUK->OldValue = $this->KDRUJUK->CurrentValue;
		$this->STATUS->CurrentValue = NULL;
		$this->STATUS->OldValue = $this->STATUS->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->TGLORDER->FldIsDetailKey) {
			$this->TGLORDER->setFormValue($objForm->GetValue("x_TGLORDER"));
			$this->TGLORDER->CurrentValue = ew_UnFormatDateTime($this->TGLORDER->CurrentValue, 0);
		}
		if (!$this->IDXDAFTAR->FldIsDetailKey) {
			$this->IDXDAFTAR->setFormValue($objForm->GetValue("x_IDXDAFTAR"));
		}
		if (!$this->NOMR->FldIsDetailKey) {
			$this->NOMR->setFormValue($objForm->GetValue("x_NOMR"));
		}
		if (!$this->POLYPENGIRIM->FldIsDetailKey) {
			$this->POLYPENGIRIM->setFormValue($objForm->GetValue("x_POLYPENGIRIM"));
		}
		if (!$this->DRPENGIRIM->FldIsDetailKey) {
			$this->DRPENGIRIM->setFormValue($objForm->GetValue("x_DRPENGIRIM"));
		}
		if (!$this->KDCARABAYAR->FldIsDetailKey) {
			$this->KDCARABAYAR->setFormValue($objForm->GetValue("x_KDCARABAYAR"));
		}
		if (!$this->KDRUJUK->FldIsDetailKey) {
			$this->KDRUJUK->setFormValue($objForm->GetValue("x_KDRUJUK"));
		}
		if (!$this->STATUS->FldIsDetailKey) {
			$this->STATUS->setFormValue($objForm->GetValue("x_STATUS"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->TGLORDER->CurrentValue = $this->TGLORDER->FormValue;
		$this->TGLORDER->CurrentValue = ew_UnFormatDateTime($this->TGLORDER->CurrentValue, 0);
		$this->IDXDAFTAR->CurrentValue = $this->IDXDAFTAR->FormValue;
		$this->NOMR->CurrentValue = $this->NOMR->FormValue;
		$this->POLYPENGIRIM->CurrentValue = $this->POLYPENGIRIM->FormValue;
		$this->DRPENGIRIM->CurrentValue = $this->DRPENGIRIM->FormValue;
		$this->KDCARABAYAR->CurrentValue = $this->KDCARABAYAR->FormValue;
		$this->KDRUJUK->CurrentValue = $this->KDRUJUK->FormValue;
		$this->STATUS->CurrentValue = $this->STATUS->FormValue;
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
		$this->IDXORDER->setDbValue($rs->fields('IDXORDER'));
		$this->TGLORDER->setDbValue($rs->fields('TGLORDER'));
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->POLYPENGIRIM->setDbValue($rs->fields('POLYPENGIRIM'));
		$this->DRPENGIRIM->setDbValue($rs->fields('DRPENGIRIM'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXORDER->DbValue = $row['IDXORDER'];
		$this->TGLORDER->DbValue = $row['TGLORDER'];
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->POLYPENGIRIM->DbValue = $row['POLYPENGIRIM'];
		$this->DRPENGIRIM->DbValue = $row['DRPENGIRIM'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->STATUS->DbValue = $row['STATUS'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("IDXORDER")) <> "")
			$this->IDXORDER->CurrentValue = $this->getKey("IDXORDER"); // IDXORDER
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
		// IDXORDER
		// TGLORDER
		// IDXDAFTAR
		// NOMR
		// POLYPENGIRIM
		// DRPENGIRIM
		// KDCARABAYAR
		// KDRUJUK
		// STATUS

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXORDER
		$this->IDXORDER->ViewValue = $this->IDXORDER->CurrentValue;
		$this->IDXORDER->ViewCustomAttributes = "";

		// TGLORDER
		$this->TGLORDER->ViewValue = $this->TGLORDER->CurrentValue;
		$this->TGLORDER->ViewValue = ew_FormatDateTime($this->TGLORDER->ViewValue, 0);
		$this->TGLORDER->ViewCustomAttributes = "";

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// POLYPENGIRIM
		if (strval($this->POLYPENGIRIM->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->POLYPENGIRIM->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->POLYPENGIRIM->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->POLYPENGIRIM, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->POLYPENGIRIM->ViewValue = $this->POLYPENGIRIM->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->POLYPENGIRIM->ViewValue = $this->POLYPENGIRIM->CurrentValue;
			}
		} else {
			$this->POLYPENGIRIM->ViewValue = NULL;
		}
		$this->POLYPENGIRIM->ViewCustomAttributes = "";

		// DRPENGIRIM
		if (strval($this->DRPENGIRIM->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->DRPENGIRIM->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->DRPENGIRIM->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DRPENGIRIM, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->DRPENGIRIM->ViewValue = $this->DRPENGIRIM->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DRPENGIRIM->ViewValue = $this->DRPENGIRIM->CurrentValue;
			}
		} else {
			$this->DRPENGIRIM->ViewValue = NULL;
		}
		$this->DRPENGIRIM->ViewCustomAttributes = "";

		// KDCARABAYAR
		if (strval($this->KDCARABAYAR->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->KDCARABAYAR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
			}
		} else {
			$this->KDCARABAYAR->ViewValue = NULL;
		}
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// KDRUJUK
		if (strval($this->KDRUJUK->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDRUJUK->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->KDRUJUK->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
			}
		} else {
			$this->KDRUJUK->ViewValue = NULL;
		}
		$this->KDRUJUK->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

			// TGLORDER
			$this->TGLORDER->LinkCustomAttributes = "";
			$this->TGLORDER->HrefValue = "";
			$this->TGLORDER->TooltipValue = "";

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";
			$this->IDXDAFTAR->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// POLYPENGIRIM
			$this->POLYPENGIRIM->LinkCustomAttributes = "";
			$this->POLYPENGIRIM->HrefValue = "";
			$this->POLYPENGIRIM->TooltipValue = "";

			// DRPENGIRIM
			$this->DRPENGIRIM->LinkCustomAttributes = "";
			$this->DRPENGIRIM->HrefValue = "";
			$this->DRPENGIRIM->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// KDRUJUK
			$this->KDRUJUK->LinkCustomAttributes = "";
			$this->KDRUJUK->HrefValue = "";
			$this->KDRUJUK->TooltipValue = "";

			// STATUS
			$this->STATUS->LinkCustomAttributes = "";
			$this->STATUS->HrefValue = "";
			$this->STATUS->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// TGLORDER
			$this->TGLORDER->EditAttrs["class"] = "form-control";
			$this->TGLORDER->EditCustomAttributes = "";
			$this->TGLORDER->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TGLORDER->CurrentValue, 8));
			$this->TGLORDER->PlaceHolder = ew_RemoveHtml($this->TGLORDER->FldCaption());

			// IDXDAFTAR
			$this->IDXDAFTAR->EditAttrs["class"] = "form-control";
			$this->IDXDAFTAR->EditCustomAttributes = "";
			$this->IDXDAFTAR->EditValue = ew_HtmlEncode($this->IDXDAFTAR->CurrentValue);
			$this->IDXDAFTAR->PlaceHolder = ew_RemoveHtml($this->IDXDAFTAR->FldCaption());

			// NOMR
			$this->NOMR->EditAttrs["class"] = "form-control";
			$this->NOMR->EditCustomAttributes = "";
			$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->CurrentValue);
			if (strval($this->NOMR->CurrentValue) <> "") {
				$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "";
			$this->NOMR->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
					$this->NOMR->EditValue = $this->NOMR->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->CurrentValue);
				}
			} else {
				$this->NOMR->EditValue = NULL;
			}
			$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

			// POLYPENGIRIM
			$this->POLYPENGIRIM->EditAttrs["class"] = "form-control";
			$this->POLYPENGIRIM->EditCustomAttributes = "";
			if (trim(strval($this->POLYPENGIRIM->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->POLYPENGIRIM->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_poly`";
			$sWhereWrk = "";
			$this->POLYPENGIRIM->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->POLYPENGIRIM, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->POLYPENGIRIM->EditValue = $arwrk;

			// DRPENGIRIM
			$this->DRPENGIRIM->EditAttrs["class"] = "form-control";
			$this->DRPENGIRIM->EditCustomAttributes = "";
			if (trim(strval($this->DRPENGIRIM->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->DRPENGIRIM->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->DRPENGIRIM->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->DRPENGIRIM, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->DRPENGIRIM->EditValue = $arwrk;

			// KDCARABAYAR
			$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
			$this->KDCARABAYAR->EditCustomAttributes = "";
			if (trim(strval($this->KDCARABAYAR->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->KDCARABAYAR->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDCARABAYAR->EditValue = $arwrk;

			// KDRUJUK
			$this->KDRUJUK->EditAttrs["class"] = "form-control";
			$this->KDRUJUK->EditCustomAttributes = "";
			if (trim(strval($this->KDRUJUK->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDRUJUK->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_rujukan`";
			$sWhereWrk = "";
			$this->KDRUJUK->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDRUJUK->EditValue = $arwrk;

			// STATUS
			$this->STATUS->EditAttrs["class"] = "form-control";
			$this->STATUS->EditCustomAttributes = "";
			$this->STATUS->EditValue = ew_HtmlEncode($this->STATUS->CurrentValue);
			$this->STATUS->PlaceHolder = ew_RemoveHtml($this->STATUS->FldCaption());

			// Add refer script
			// TGLORDER

			$this->TGLORDER->LinkCustomAttributes = "";
			$this->TGLORDER->HrefValue = "";

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";

			// POLYPENGIRIM
			$this->POLYPENGIRIM->LinkCustomAttributes = "";
			$this->POLYPENGIRIM->HrefValue = "";

			// DRPENGIRIM
			$this->DRPENGIRIM->LinkCustomAttributes = "";
			$this->DRPENGIRIM->HrefValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";

			// KDRUJUK
			$this->KDRUJUK->LinkCustomAttributes = "";
			$this->KDRUJUK->HrefValue = "";

			// STATUS
			$this->STATUS->LinkCustomAttributes = "";
			$this->STATUS->HrefValue = "";
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
		if (!$this->TGLORDER->FldIsDetailKey && !is_null($this->TGLORDER->FormValue) && $this->TGLORDER->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TGLORDER->FldCaption(), $this->TGLORDER->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->TGLORDER->FormValue)) {
			ew_AddMessage($gsFormError, $this->TGLORDER->FldErrMsg());
		}
		if (!$this->IDXDAFTAR->FldIsDetailKey && !is_null($this->IDXDAFTAR->FormValue) && $this->IDXDAFTAR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->IDXDAFTAR->FldCaption(), $this->IDXDAFTAR->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->IDXDAFTAR->FormValue)) {
			ew_AddMessage($gsFormError, $this->IDXDAFTAR->FldErrMsg());
		}
		if (!$this->NOMR->FldIsDetailKey && !is_null($this->NOMR->FormValue) && $this->NOMR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NOMR->FldCaption(), $this->NOMR->ReqErrMsg));
		}
		if (!$this->POLYPENGIRIM->FldIsDetailKey && !is_null($this->POLYPENGIRIM->FormValue) && $this->POLYPENGIRIM->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->POLYPENGIRIM->FldCaption(), $this->POLYPENGIRIM->ReqErrMsg));
		}
		if (!$this->DRPENGIRIM->FldIsDetailKey && !is_null($this->DRPENGIRIM->FormValue) && $this->DRPENGIRIM->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->DRPENGIRIM->FldCaption(), $this->DRPENGIRIM->ReqErrMsg));
		}
		if (!$this->KDCARABAYAR->FldIsDetailKey && !is_null($this->KDCARABAYAR->FormValue) && $this->KDCARABAYAR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDCARABAYAR->FldCaption(), $this->KDCARABAYAR->ReqErrMsg));
		}
		if (!$this->KDRUJUK->FldIsDetailKey && !is_null($this->KDRUJUK->FormValue) && $this->KDRUJUK->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDRUJUK->FldCaption(), $this->KDRUJUK->ReqErrMsg));
		}
		if (!$this->STATUS->FldIsDetailKey && !is_null($this->STATUS->FormValue) && $this->STATUS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->STATUS->FldCaption(), $this->STATUS->ReqErrMsg));
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

		// TGLORDER
		$this->TGLORDER->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TGLORDER->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// IDXDAFTAR
		$this->IDXDAFTAR->SetDbValueDef($rsnew, $this->IDXDAFTAR->CurrentValue, 0, FALSE);

		// NOMR
		$this->NOMR->SetDbValueDef($rsnew, $this->NOMR->CurrentValue, "", FALSE);

		// POLYPENGIRIM
		$this->POLYPENGIRIM->SetDbValueDef($rsnew, $this->POLYPENGIRIM->CurrentValue, 0, FALSE);

		// DRPENGIRIM
		$this->DRPENGIRIM->SetDbValueDef($rsnew, $this->DRPENGIRIM->CurrentValue, 0, FALSE);

		// KDCARABAYAR
		$this->KDCARABAYAR->SetDbValueDef($rsnew, $this->KDCARABAYAR->CurrentValue, 0, FALSE);

		// KDRUJUK
		$this->KDRUJUK->SetDbValueDef($rsnew, $this->KDRUJUK->CurrentValue, 0, FALSE);

		// STATUS
		$this->STATUS->SetDbValueDef($rsnew, ((strval($this->STATUS->CurrentValue) == "1") ? "1" : "0"), 0, FALSE);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_orderadmissionlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_NOMR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR` AS `LinkFld`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "{filter}";
			$this->NOMR->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`NOMR` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_POLYPENGIRIM":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "";
			$this->POLYPENGIRIM->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->POLYPENGIRIM, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_DRPENGIRIM":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->DRPENGIRIM->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KDDOKTER` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->DRPENGIRIM, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDCARABAYAR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE` AS `LinkFld`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->KDCARABAYAR->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KODE` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDRUJUK":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE` AS `LinkFld`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
			$sWhereWrk = "";
			$this->KDRUJUK->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KODE` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
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
		case "x_NOMR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld` FROM `m_pasien`";
			$sWhereWrk = "`NOMR` LIKE '%{query_value}%' OR `NAMA` LIKE '%{query_value}%' OR `ALAMAT` LIKE '%{query_value}%' OR CONCAT(`NOMR`,'" . ew_ValueSeparator(1, $this->NOMR) . "',`NAMA`,'" . ew_ValueSeparator(2, $this->NOMR) . "',`ALAMAT`) LIKE '{query_value}%'";
			$this->NOMR->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t_orderadmission_add)) $t_orderadmission_add = new ct_orderadmission_add();

// Page init
$t_orderadmission_add->Page_Init();

// Page main
$t_orderadmission_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_orderadmission_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_orderadmissionadd = new ew_Form("ft_orderadmissionadd", "add");

// Validate form
ft_orderadmissionadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_TGLORDER");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->TGLORDER->FldCaption(), $t_orderadmission->TGLORDER->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TGLORDER");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_orderadmission->TGLORDER->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IDXDAFTAR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->IDXDAFTAR->FldCaption(), $t_orderadmission->IDXDAFTAR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_IDXDAFTAR");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_orderadmission->IDXDAFTAR->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NOMR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->NOMR->FldCaption(), $t_orderadmission->NOMR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_POLYPENGIRIM");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->POLYPENGIRIM->FldCaption(), $t_orderadmission->POLYPENGIRIM->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DRPENGIRIM");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->DRPENGIRIM->FldCaption(), $t_orderadmission->DRPENGIRIM->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KDCARABAYAR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->KDCARABAYAR->FldCaption(), $t_orderadmission->KDCARABAYAR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KDRUJUK");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->KDRUJUK->FldCaption(), $t_orderadmission->KDRUJUK->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_STATUS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_orderadmission->STATUS->FldCaption(), $t_orderadmission->STATUS->ReqErrMsg)) ?>");

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
ft_orderadmissionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_orderadmissionadd.ValidateRequired = true;
<?php } else { ?>
ft_orderadmissionadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_orderadmissionadd.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","x_ALAMAT",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_orderadmissionadd.Lists["x_POLYPENGIRIM"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_orderadmissionadd.Lists["x_DRPENGIRIM"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_orderadmissionadd.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_orderadmissionadd.Lists["x_KDRUJUK"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_orderadmission_add->IsModal) { ?>
<?php } ?>
<?php $t_orderadmission_add->ShowPageHeader(); ?>
<?php
$t_orderadmission_add->ShowMessage();
?>
<form name="ft_orderadmissionadd" id="ft_orderadmissionadd" class="<?php echo $t_orderadmission_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_orderadmission_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_orderadmission_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_orderadmission">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_orderadmission_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_orderadmission->TGLORDER->Visible) { // TGLORDER ?>
	<div id="r_TGLORDER" class="form-group">
		<label id="elh_t_orderadmission_TGLORDER" for="x_TGLORDER" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->TGLORDER->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->TGLORDER->CellAttributes() ?>>
<span id="el_t_orderadmission_TGLORDER">
<input type="text" data-table="t_orderadmission" data-field="x_TGLORDER" name="x_TGLORDER" id="x_TGLORDER" placeholder="<?php echo ew_HtmlEncode($t_orderadmission->TGLORDER->getPlaceHolder()) ?>" value="<?php echo $t_orderadmission->TGLORDER->EditValue ?>"<?php echo $t_orderadmission->TGLORDER->EditAttributes() ?>>
</span>
<?php echo $t_orderadmission->TGLORDER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_orderadmission->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<div id="r_IDXDAFTAR" class="form-group">
		<label id="elh_t_orderadmission_IDXDAFTAR" for="x_IDXDAFTAR" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->IDXDAFTAR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->IDXDAFTAR->CellAttributes() ?>>
<span id="el_t_orderadmission_IDXDAFTAR">
<input type="text" data-table="t_orderadmission" data-field="x_IDXDAFTAR" name="x_IDXDAFTAR" id="x_IDXDAFTAR" size="30" placeholder="<?php echo ew_HtmlEncode($t_orderadmission->IDXDAFTAR->getPlaceHolder()) ?>" value="<?php echo $t_orderadmission->IDXDAFTAR->EditValue ?>"<?php echo $t_orderadmission->IDXDAFTAR->EditAttributes() ?>>
</span>
<?php echo $t_orderadmission->IDXDAFTAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_orderadmission->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label id="elh_t_orderadmission_NOMR" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->NOMR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->NOMR->CellAttributes() ?>>
<span id="el_t_orderadmission_NOMR">
<?php
$wrkonchange = trim(" " . @$t_orderadmission->NOMR->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_orderadmission->NOMR->EditAttrs["onchange"] = "";
?>
<span id="as_x_NOMR" style="white-space: nowrap; z-index: 8960">
	<input type="text" name="sv_x_NOMR" id="sv_x_NOMR" value="<?php echo $t_orderadmission->NOMR->EditValue ?>" size="30" maxlength="11" placeholder="<?php echo ew_HtmlEncode($t_orderadmission->NOMR->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_orderadmission->NOMR->getPlaceHolder()) ?>"<?php echo $t_orderadmission->NOMR->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_orderadmission" data-field="x_NOMR" data-value-separator="<?php echo $t_orderadmission->NOMR->DisplayValueSeparatorAttribute() ?>" name="x_NOMR" id="x_NOMR" value="<?php echo ew_HtmlEncode($t_orderadmission->NOMR->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_NOMR" id="q_x_NOMR" value="<?php echo $t_orderadmission->NOMR->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_orderadmissionadd.CreateAutoSuggest({"id":"x_NOMR","forceSelect":false});
</script>
</span>
<?php echo $t_orderadmission->NOMR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_orderadmission->POLYPENGIRIM->Visible) { // POLYPENGIRIM ?>
	<div id="r_POLYPENGIRIM" class="form-group">
		<label id="elh_t_orderadmission_POLYPENGIRIM" for="x_POLYPENGIRIM" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->POLYPENGIRIM->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->POLYPENGIRIM->CellAttributes() ?>>
<span id="el_t_orderadmission_POLYPENGIRIM">
<select data-table="t_orderadmission" data-field="x_POLYPENGIRIM" data-value-separator="<?php echo $t_orderadmission->POLYPENGIRIM->DisplayValueSeparatorAttribute() ?>" id="x_POLYPENGIRIM" name="x_POLYPENGIRIM"<?php echo $t_orderadmission->POLYPENGIRIM->EditAttributes() ?>>
<?php echo $t_orderadmission->POLYPENGIRIM->SelectOptionListHtml("x_POLYPENGIRIM") ?>
</select>
<input type="hidden" name="s_x_POLYPENGIRIM" id="s_x_POLYPENGIRIM" value="<?php echo $t_orderadmission->POLYPENGIRIM->LookupFilterQuery() ?>">
</span>
<?php echo $t_orderadmission->POLYPENGIRIM->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_orderadmission->DRPENGIRIM->Visible) { // DRPENGIRIM ?>
	<div id="r_DRPENGIRIM" class="form-group">
		<label id="elh_t_orderadmission_DRPENGIRIM" for="x_DRPENGIRIM" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->DRPENGIRIM->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->DRPENGIRIM->CellAttributes() ?>>
<span id="el_t_orderadmission_DRPENGIRIM">
<select data-table="t_orderadmission" data-field="x_DRPENGIRIM" data-value-separator="<?php echo $t_orderadmission->DRPENGIRIM->DisplayValueSeparatorAttribute() ?>" id="x_DRPENGIRIM" name="x_DRPENGIRIM"<?php echo $t_orderadmission->DRPENGIRIM->EditAttributes() ?>>
<?php echo $t_orderadmission->DRPENGIRIM->SelectOptionListHtml("x_DRPENGIRIM") ?>
</select>
<input type="hidden" name="s_x_DRPENGIRIM" id="s_x_DRPENGIRIM" value="<?php echo $t_orderadmission->DRPENGIRIM->LookupFilterQuery() ?>">
</span>
<?php echo $t_orderadmission->DRPENGIRIM->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_orderadmission->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<div id="r_KDCARABAYAR" class="form-group">
		<label id="elh_t_orderadmission_KDCARABAYAR" for="x_KDCARABAYAR" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->KDCARABAYAR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->KDCARABAYAR->CellAttributes() ?>>
<span id="el_t_orderadmission_KDCARABAYAR">
<select data-table="t_orderadmission" data-field="x_KDCARABAYAR" data-value-separator="<?php echo $t_orderadmission->KDCARABAYAR->DisplayValueSeparatorAttribute() ?>" id="x_KDCARABAYAR" name="x_KDCARABAYAR"<?php echo $t_orderadmission->KDCARABAYAR->EditAttributes() ?>>
<?php echo $t_orderadmission->KDCARABAYAR->SelectOptionListHtml("x_KDCARABAYAR") ?>
</select>
<input type="hidden" name="s_x_KDCARABAYAR" id="s_x_KDCARABAYAR" value="<?php echo $t_orderadmission->KDCARABAYAR->LookupFilterQuery() ?>">
</span>
<?php echo $t_orderadmission->KDCARABAYAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_orderadmission->KDRUJUK->Visible) { // KDRUJUK ?>
	<div id="r_KDRUJUK" class="form-group">
		<label id="elh_t_orderadmission_KDRUJUK" for="x_KDRUJUK" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->KDRUJUK->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->KDRUJUK->CellAttributes() ?>>
<span id="el_t_orderadmission_KDRUJUK">
<select data-table="t_orderadmission" data-field="x_KDRUJUK" data-value-separator="<?php echo $t_orderadmission->KDRUJUK->DisplayValueSeparatorAttribute() ?>" id="x_KDRUJUK" name="x_KDRUJUK"<?php echo $t_orderadmission->KDRUJUK->EditAttributes() ?>>
<?php echo $t_orderadmission->KDRUJUK->SelectOptionListHtml("x_KDRUJUK") ?>
</select>
<input type="hidden" name="s_x_KDRUJUK" id="s_x_KDRUJUK" value="<?php echo $t_orderadmission->KDRUJUK->LookupFilterQuery() ?>">
</span>
<?php echo $t_orderadmission->KDRUJUK->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_orderadmission->STATUS->Visible) { // STATUS ?>
	<div id="r_STATUS" class="form-group">
		<label id="elh_t_orderadmission_STATUS" for="x_STATUS" class="col-sm-2 control-label ewLabel"><?php echo $t_orderadmission->STATUS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_orderadmission->STATUS->CellAttributes() ?>>
<span id="el_t_orderadmission_STATUS">
<input type="text" data-table="t_orderadmission" data-field="x_STATUS" name="x_STATUS" id="x_STATUS" size="30" maxlength="1" placeholder="<?php echo ew_HtmlEncode($t_orderadmission->STATUS->getPlaceHolder()) ?>" value="<?php echo $t_orderadmission->STATUS->EditValue ?>"<?php echo $t_orderadmission->STATUS->EditAttributes() ?>>
</span>
<?php echo $t_orderadmission->STATUS->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_orderadmission_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_orderadmission_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_orderadmissionadd.Init();
</script>
<?php
$t_orderadmission_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_orderadmission_add->Page_Terminate();
?>
