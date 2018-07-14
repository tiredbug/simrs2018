<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_data_tarifinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_data_tarif_add = NULL; // Initialize page object first

class cm_data_tarif_add extends cm_data_tarif {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_data_tarif';

	// Page object name
	var $PageObjName = 'm_data_tarif_add';

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

		// Table object (m_data_tarif)
		if (!isset($GLOBALS["m_data_tarif"]) || get_class($GLOBALS["m_data_tarif"]) == "cm_data_tarif") {
			$GLOBALS["m_data_tarif"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_data_tarif"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_data_tarif', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_data_tariflist.php"));
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
		$this->kode->SetVisibility();
		$this->nama_tindakan->SetVisibility();
		$this->kelompok_tindakan->SetVisibility();
		$this->sub_kelompok1->SetVisibility();
		$this->sub_kelompok2->SetVisibility();
		$this->kelas->SetVisibility();
		$this->tarif->SetVisibility();
		$this->bhp->SetVisibility();

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
		global $EW_EXPORT, $m_data_tarif;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_data_tarif);
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
					$this->Page_Terminate("m_data_tariflist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "m_data_tariflist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "m_data_tarifview.php")
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
		$this->kode->CurrentValue = NULL;
		$this->kode->OldValue = $this->kode->CurrentValue;
		$this->nama_tindakan->CurrentValue = NULL;
		$this->nama_tindakan->OldValue = $this->nama_tindakan->CurrentValue;
		$this->kelompok_tindakan->CurrentValue = NULL;
		$this->kelompok_tindakan->OldValue = $this->kelompok_tindakan->CurrentValue;
		$this->sub_kelompok1->CurrentValue = NULL;
		$this->sub_kelompok1->OldValue = $this->sub_kelompok1->CurrentValue;
		$this->sub_kelompok2->CurrentValue = NULL;
		$this->sub_kelompok2->OldValue = $this->sub_kelompok2->CurrentValue;
		$this->kelas->CurrentValue = NULL;
		$this->kelas->OldValue = $this->kelas->CurrentValue;
		$this->tarif->CurrentValue = 0;
		$this->bhp->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->kode->FldIsDetailKey) {
			$this->kode->setFormValue($objForm->GetValue("x_kode"));
		}
		if (!$this->nama_tindakan->FldIsDetailKey) {
			$this->nama_tindakan->setFormValue($objForm->GetValue("x_nama_tindakan"));
		}
		if (!$this->kelompok_tindakan->FldIsDetailKey) {
			$this->kelompok_tindakan->setFormValue($objForm->GetValue("x_kelompok_tindakan"));
		}
		if (!$this->sub_kelompok1->FldIsDetailKey) {
			$this->sub_kelompok1->setFormValue($objForm->GetValue("x_sub_kelompok1"));
		}
		if (!$this->sub_kelompok2->FldIsDetailKey) {
			$this->sub_kelompok2->setFormValue($objForm->GetValue("x_sub_kelompok2"));
		}
		if (!$this->kelas->FldIsDetailKey) {
			$this->kelas->setFormValue($objForm->GetValue("x_kelas"));
		}
		if (!$this->tarif->FldIsDetailKey) {
			$this->tarif->setFormValue($objForm->GetValue("x_tarif"));
		}
		if (!$this->bhp->FldIsDetailKey) {
			$this->bhp->setFormValue($objForm->GetValue("x_bhp"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->kode->CurrentValue = $this->kode->FormValue;
		$this->nama_tindakan->CurrentValue = $this->nama_tindakan->FormValue;
		$this->kelompok_tindakan->CurrentValue = $this->kelompok_tindakan->FormValue;
		$this->sub_kelompok1->CurrentValue = $this->sub_kelompok1->FormValue;
		$this->sub_kelompok2->CurrentValue = $this->sub_kelompok2->FormValue;
		$this->kelas->CurrentValue = $this->kelas->FormValue;
		$this->tarif->CurrentValue = $this->tarif->FormValue;
		$this->bhp->CurrentValue = $this->bhp->FormValue;
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
		$this->kode->setDbValue($rs->fields('kode'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->sub_kelompok1->setDbValue($rs->fields('sub_kelompok1'));
		$this->sub_kelompok2->setDbValue($rs->fields('sub_kelompok2'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->bhp->setDbValue($rs->fields('bhp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->kode->DbValue = $row['kode'];
		$this->nama_tindakan->DbValue = $row['nama_tindakan'];
		$this->kelompok_tindakan->DbValue = $row['kelompok_tindakan'];
		$this->sub_kelompok1->DbValue = $row['sub_kelompok1'];
		$this->sub_kelompok2->DbValue = $row['sub_kelompok2'];
		$this->kelas->DbValue = $row['kelas'];
		$this->tarif->DbValue = $row['tarif'];
		$this->bhp->DbValue = $row['bhp'];
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
		// Convert decimal values if posted back

		if ($this->tarif->FormValue == $this->tarif->CurrentValue && is_numeric(ew_StrToFloat($this->tarif->CurrentValue)))
			$this->tarif->CurrentValue = ew_StrToFloat($this->tarif->CurrentValue);

		// Convert decimal values if posted back
		if ($this->bhp->FormValue == $this->bhp->CurrentValue && is_numeric(ew_StrToFloat($this->bhp->CurrentValue)))
			$this->bhp->CurrentValue = ew_StrToFloat($this->bhp->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// kode
		// nama_tindakan
		// kelompok_tindakan
		// sub_kelompok1
		// sub_kelompok2
		// kelas
		// tarif
		// bhp

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kode
		$this->kode->ViewValue = $this->kode->CurrentValue;
		$this->kode->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// kelompok_tindakan
		if (strval($this->kelompok_tindakan->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->kelompok_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `kelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_kelompok_tindakan`";
		$sWhereWrk = "";
		$this->kelompok_tindakan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kelompok_tindakan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
			}
		} else {
			$this->kelompok_tindakan->ViewValue = NULL;
		}
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// sub_kelompok1
		if (strval($this->sub_kelompok1->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub_kelompok1->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `subkelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_sub_kelompok_1`";
		$sWhereWrk = "";
		$this->sub_kelompok1->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sub_kelompok1, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sub_kelompok1->ViewValue = $this->sub_kelompok1->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sub_kelompok1->ViewValue = $this->sub_kelompok1->CurrentValue;
			}
		} else {
			$this->sub_kelompok1->ViewValue = NULL;
		}
		$this->sub_kelompok1->ViewCustomAttributes = "";

		// sub_kelompok2
		if (strval($this->sub_kelompok2->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub_kelompok2->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `subkelompok2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_sub_kelompok_2`";
		$sWhereWrk = "";
		$this->sub_kelompok2->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sub_kelompok2, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sub_kelompok2->ViewValue = $this->sub_kelompok2->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sub_kelompok2->ViewValue = $this->sub_kelompok2->CurrentValue;
			}
		} else {
			$this->sub_kelompok2->ViewValue = NULL;
		}
		$this->sub_kelompok2->ViewCustomAttributes = "";

		// kelas
		if (strval($this->kelas->CurrentValue) <> "") {
			$this->kelas->ViewValue = $this->kelas->OptionCaption($this->kelas->CurrentValue);
		} else {
			$this->kelas->ViewValue = NULL;
		}
		$this->kelas->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

			// kode
			$this->kode->LinkCustomAttributes = "";
			$this->kode->HrefValue = "";
			$this->kode->TooltipValue = "";

			// nama_tindakan
			$this->nama_tindakan->LinkCustomAttributes = "";
			$this->nama_tindakan->HrefValue = "";
			$this->nama_tindakan->TooltipValue = "";

			// kelompok_tindakan
			$this->kelompok_tindakan->LinkCustomAttributes = "";
			$this->kelompok_tindakan->HrefValue = "";
			$this->kelompok_tindakan->TooltipValue = "";

			// sub_kelompok1
			$this->sub_kelompok1->LinkCustomAttributes = "";
			$this->sub_kelompok1->HrefValue = "";
			$this->sub_kelompok1->TooltipValue = "";

			// sub_kelompok2
			$this->sub_kelompok2->LinkCustomAttributes = "";
			$this->sub_kelompok2->HrefValue = "";
			$this->sub_kelompok2->TooltipValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";
			$this->kelas->TooltipValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";
			$this->tarif->TooltipValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";
			$this->bhp->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// kode
			$this->kode->EditAttrs["class"] = "form-control";
			$this->kode->EditCustomAttributes = "";
			$this->kode->EditValue = ew_HtmlEncode($this->kode->CurrentValue);
			$this->kode->PlaceHolder = ew_RemoveHtml($this->kode->FldCaption());

			// nama_tindakan
			$this->nama_tindakan->EditAttrs["class"] = "form-control";
			$this->nama_tindakan->EditCustomAttributes = "";
			$this->nama_tindakan->EditValue = ew_HtmlEncode($this->nama_tindakan->CurrentValue);
			$this->nama_tindakan->PlaceHolder = ew_RemoveHtml($this->nama_tindakan->FldCaption());

			// kelompok_tindakan
			$this->kelompok_tindakan->EditAttrs["class"] = "form-control";
			$this->kelompok_tindakan->EditCustomAttributes = "";
			if (trim(strval($this->kelompok_tindakan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->kelompok_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `kelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_tarif_kelompok_tindakan`";
			$sWhereWrk = "";
			$this->kelompok_tindakan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kelompok_tindakan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kelompok_tindakan->EditValue = $arwrk;

			// sub_kelompok1
			$this->sub_kelompok1->EditAttrs["class"] = "form-control";
			$this->sub_kelompok1->EditCustomAttributes = "";
			if (trim(strval($this->sub_kelompok1->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub_kelompok1->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `subkelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_tarif_sub_kelompok_1`";
			$sWhereWrk = "";
			$this->sub_kelompok1->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sub_kelompok1, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->sub_kelompok1->EditValue = $arwrk;

			// sub_kelompok2
			$this->sub_kelompok2->EditAttrs["class"] = "form-control";
			$this->sub_kelompok2->EditCustomAttributes = "";
			if (trim(strval($this->sub_kelompok2->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->sub_kelompok2->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `subkelompok2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `subkelompok1` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_tarif_sub_kelompok_2`";
			$sWhereWrk = "";
			$this->sub_kelompok2->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sub_kelompok2, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->sub_kelompok2->EditValue = $arwrk;

			// kelas
			$this->kelas->EditAttrs["class"] = "form-control";
			$this->kelas->EditCustomAttributes = "";
			$this->kelas->EditValue = $this->kelas->Options(TRUE);

			// tarif
			$this->tarif->EditAttrs["class"] = "form-control";
			$this->tarif->EditCustomAttributes = "";
			$this->tarif->EditValue = ew_HtmlEncode($this->tarif->CurrentValue);
			$this->tarif->PlaceHolder = ew_RemoveHtml($this->tarif->FldCaption());
			if (strval($this->tarif->EditValue) <> "" && is_numeric($this->tarif->EditValue)) $this->tarif->EditValue = ew_FormatNumber($this->tarif->EditValue, -2, -1, -2, 0);

			// bhp
			$this->bhp->EditAttrs["class"] = "form-control";
			$this->bhp->EditCustomAttributes = "";
			$this->bhp->EditValue = ew_HtmlEncode($this->bhp->CurrentValue);
			$this->bhp->PlaceHolder = ew_RemoveHtml($this->bhp->FldCaption());
			if (strval($this->bhp->EditValue) <> "" && is_numeric($this->bhp->EditValue)) $this->bhp->EditValue = ew_FormatNumber($this->bhp->EditValue, -2, -1, -2, 0);

			// Add refer script
			// kode

			$this->kode->LinkCustomAttributes = "";
			$this->kode->HrefValue = "";

			// nama_tindakan
			$this->nama_tindakan->LinkCustomAttributes = "";
			$this->nama_tindakan->HrefValue = "";

			// kelompok_tindakan
			$this->kelompok_tindakan->LinkCustomAttributes = "";
			$this->kelompok_tindakan->HrefValue = "";

			// sub_kelompok1
			$this->sub_kelompok1->LinkCustomAttributes = "";
			$this->sub_kelompok1->HrefValue = "";

			// sub_kelompok2
			$this->sub_kelompok2->LinkCustomAttributes = "";
			$this->sub_kelompok2->HrefValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";
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
		if (!ew_CheckInteger($this->kode->FormValue)) {
			ew_AddMessage($gsFormError, $this->kode->FldErrMsg());
		}
		if (!ew_CheckNumber($this->tarif->FormValue)) {
			ew_AddMessage($gsFormError, $this->tarif->FldErrMsg());
		}
		if (!ew_CheckNumber($this->bhp->FormValue)) {
			ew_AddMessage($gsFormError, $this->bhp->FldErrMsg());
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

		// kode
		$this->kode->SetDbValueDef($rsnew, $this->kode->CurrentValue, NULL, FALSE);

		// nama_tindakan
		$this->nama_tindakan->SetDbValueDef($rsnew, $this->nama_tindakan->CurrentValue, NULL, FALSE);

		// kelompok_tindakan
		$this->kelompok_tindakan->SetDbValueDef($rsnew, $this->kelompok_tindakan->CurrentValue, NULL, FALSE);

		// sub_kelompok1
		$this->sub_kelompok1->SetDbValueDef($rsnew, $this->sub_kelompok1->CurrentValue, NULL, FALSE);

		// sub_kelompok2
		$this->sub_kelompok2->SetDbValueDef($rsnew, $this->sub_kelompok2->CurrentValue, NULL, FALSE);

		// kelas
		$this->kelas->SetDbValueDef($rsnew, $this->kelas->CurrentValue, NULL, FALSE);

		// tarif
		$this->tarif->SetDbValueDef($rsnew, $this->tarif->CurrentValue, NULL, strval($this->tarif->CurrentValue) == "");

		// bhp
		$this->bhp->SetDbValueDef($rsnew, $this->bhp->CurrentValue, NULL, strval($this->bhp->CurrentValue) == "");

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_data_tariflist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_kelompok_tindakan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `kelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_kelompok_tindakan`";
			$sWhereWrk = "";
			$this->kelompok_tindakan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kelompok_tindakan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_sub_kelompok1":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `subkelompok` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_sub_kelompok_1`";
			$sWhereWrk = "";
			$this->sub_kelompok1->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sub_kelompok1, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_sub_kelompok2":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `subkelompok2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_tarif_sub_kelompok_2`";
			$sWhereWrk = "{filter}";
			$this->sub_kelompok2->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`subkelompok1` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sub_kelompok2, $sWhereWrk); // Call Lookup selecting
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
if (!isset($m_data_tarif_add)) $m_data_tarif_add = new cm_data_tarif_add();

// Page init
$m_data_tarif_add->Page_Init();

// Page main
$m_data_tarif_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_data_tarif_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fm_data_tarifadd = new ew_Form("fm_data_tarifadd", "add");

// Validate form
fm_data_tarifadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kode");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_data_tarif->kode->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_data_tarif->tarif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bhp");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_data_tarif->bhp->FldErrMsg()) ?>");

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
fm_data_tarifadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_data_tarifadd.ValidateRequired = true;
<?php } else { ?>
fm_data_tarifadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_data_tarifadd.Lists["x_kelompok_tindakan"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kelompok","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_tarif_kelompok_tindakan"};
fm_data_tarifadd.Lists["x_sub_kelompok1"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subkelompok","","",""],"ParentFields":[],"ChildFields":["x_sub_kelompok2"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_tarif_sub_kelompok_1"};
fm_data_tarifadd.Lists["x_sub_kelompok2"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_subkelompok2","","",""],"ParentFields":["x_sub_kelompok1"],"ChildFields":[],"FilterFields":["x_subkelompok1"],"Options":[],"Template":"","LinkTable":"l_tarif_sub_kelompok_2"};
fm_data_tarifadd.Lists["x_kelas"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fm_data_tarifadd.Lists["x_kelas"].Options = <?php echo json_encode($m_data_tarif->kelas->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_data_tarif_add->IsModal) { ?>
<?php } ?>
<?php $m_data_tarif_add->ShowPageHeader(); ?>
<?php
$m_data_tarif_add->ShowMessage();
?>
<form name="fm_data_tarifadd" id="fm_data_tarifadd" class="<?php echo $m_data_tarif_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_data_tarif_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_data_tarif_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_data_tarif">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($m_data_tarif_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_data_tarif->kode->Visible) { // kode ?>
	<div id="r_kode" class="form-group">
		<label id="elh_m_data_tarif_kode" for="x_kode" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->kode->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->kode->CellAttributes() ?>>
<span id="el_m_data_tarif_kode">
<input type="text" data-table="m_data_tarif" data-field="x_kode" name="x_kode" id="x_kode" size="30" placeholder="<?php echo ew_HtmlEncode($m_data_tarif->kode->getPlaceHolder()) ?>" value="<?php echo $m_data_tarif->kode->EditValue ?>"<?php echo $m_data_tarif->kode->EditAttributes() ?>>
</span>
<?php echo $m_data_tarif->kode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_data_tarif->nama_tindakan->Visible) { // nama_tindakan ?>
	<div id="r_nama_tindakan" class="form-group">
		<label id="elh_m_data_tarif_nama_tindakan" for="x_nama_tindakan" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->nama_tindakan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->nama_tindakan->CellAttributes() ?>>
<span id="el_m_data_tarif_nama_tindakan">
<input type="text" data-table="m_data_tarif" data-field="x_nama_tindakan" name="x_nama_tindakan" id="x_nama_tindakan" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($m_data_tarif->nama_tindakan->getPlaceHolder()) ?>" value="<?php echo $m_data_tarif->nama_tindakan->EditValue ?>"<?php echo $m_data_tarif->nama_tindakan->EditAttributes() ?>>
</span>
<?php echo $m_data_tarif->nama_tindakan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_data_tarif->kelompok_tindakan->Visible) { // kelompok_tindakan ?>
	<div id="r_kelompok_tindakan" class="form-group">
		<label id="elh_m_data_tarif_kelompok_tindakan" for="x_kelompok_tindakan" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->kelompok_tindakan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->kelompok_tindakan->CellAttributes() ?>>
<span id="el_m_data_tarif_kelompok_tindakan">
<select data-table="m_data_tarif" data-field="x_kelompok_tindakan" data-value-separator="<?php echo $m_data_tarif->kelompok_tindakan->DisplayValueSeparatorAttribute() ?>" id="x_kelompok_tindakan" name="x_kelompok_tindakan"<?php echo $m_data_tarif->kelompok_tindakan->EditAttributes() ?>>
<?php echo $m_data_tarif->kelompok_tindakan->SelectOptionListHtml("x_kelompok_tindakan") ?>
</select>
<input type="hidden" name="s_x_kelompok_tindakan" id="s_x_kelompok_tindakan" value="<?php echo $m_data_tarif->kelompok_tindakan->LookupFilterQuery() ?>">
</span>
<?php echo $m_data_tarif->kelompok_tindakan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_data_tarif->sub_kelompok1->Visible) { // sub_kelompok1 ?>
	<div id="r_sub_kelompok1" class="form-group">
		<label id="elh_m_data_tarif_sub_kelompok1" for="x_sub_kelompok1" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->sub_kelompok1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->sub_kelompok1->CellAttributes() ?>>
<span id="el_m_data_tarif_sub_kelompok1">
<?php $m_data_tarif->sub_kelompok1->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$m_data_tarif->sub_kelompok1->EditAttrs["onchange"]; ?>
<select data-table="m_data_tarif" data-field="x_sub_kelompok1" data-value-separator="<?php echo $m_data_tarif->sub_kelompok1->DisplayValueSeparatorAttribute() ?>" id="x_sub_kelompok1" name="x_sub_kelompok1"<?php echo $m_data_tarif->sub_kelompok1->EditAttributes() ?>>
<?php echo $m_data_tarif->sub_kelompok1->SelectOptionListHtml("x_sub_kelompok1") ?>
</select>
<input type="hidden" name="s_x_sub_kelompok1" id="s_x_sub_kelompok1" value="<?php echo $m_data_tarif->sub_kelompok1->LookupFilterQuery() ?>">
</span>
<?php echo $m_data_tarif->sub_kelompok1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_data_tarif->sub_kelompok2->Visible) { // sub_kelompok2 ?>
	<div id="r_sub_kelompok2" class="form-group">
		<label id="elh_m_data_tarif_sub_kelompok2" for="x_sub_kelompok2" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->sub_kelompok2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->sub_kelompok2->CellAttributes() ?>>
<span id="el_m_data_tarif_sub_kelompok2">
<select data-table="m_data_tarif" data-field="x_sub_kelompok2" data-value-separator="<?php echo $m_data_tarif->sub_kelompok2->DisplayValueSeparatorAttribute() ?>" id="x_sub_kelompok2" name="x_sub_kelompok2"<?php echo $m_data_tarif->sub_kelompok2->EditAttributes() ?>>
<?php echo $m_data_tarif->sub_kelompok2->SelectOptionListHtml("x_sub_kelompok2") ?>
</select>
<input type="hidden" name="s_x_sub_kelompok2" id="s_x_sub_kelompok2" value="<?php echo $m_data_tarif->sub_kelompok2->LookupFilterQuery() ?>">
</span>
<?php echo $m_data_tarif->sub_kelompok2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_data_tarif->kelas->Visible) { // kelas ?>
	<div id="r_kelas" class="form-group">
		<label id="elh_m_data_tarif_kelas" for="x_kelas" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->kelas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->kelas->CellAttributes() ?>>
<span id="el_m_data_tarif_kelas">
<select data-table="m_data_tarif" data-field="x_kelas" data-value-separator="<?php echo $m_data_tarif->kelas->DisplayValueSeparatorAttribute() ?>" id="x_kelas" name="x_kelas"<?php echo $m_data_tarif->kelas->EditAttributes() ?>>
<?php echo $m_data_tarif->kelas->SelectOptionListHtml("x_kelas") ?>
</select>
</span>
<?php echo $m_data_tarif->kelas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_data_tarif->tarif->Visible) { // tarif ?>
	<div id="r_tarif" class="form-group">
		<label id="elh_m_data_tarif_tarif" for="x_tarif" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->tarif->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->tarif->CellAttributes() ?>>
<span id="el_m_data_tarif_tarif">
<input type="text" data-table="m_data_tarif" data-field="x_tarif" name="x_tarif" id="x_tarif" size="30" placeholder="<?php echo ew_HtmlEncode($m_data_tarif->tarif->getPlaceHolder()) ?>" value="<?php echo $m_data_tarif->tarif->EditValue ?>"<?php echo $m_data_tarif->tarif->EditAttributes() ?>>
</span>
<?php echo $m_data_tarif->tarif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_data_tarif->bhp->Visible) { // bhp ?>
	<div id="r_bhp" class="form-group">
		<label id="elh_m_data_tarif_bhp" for="x_bhp" class="col-sm-2 control-label ewLabel"><?php echo $m_data_tarif->bhp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_data_tarif->bhp->CellAttributes() ?>>
<span id="el_m_data_tarif_bhp">
<input type="text" data-table="m_data_tarif" data-field="x_bhp" name="x_bhp" id="x_bhp" size="30" placeholder="<?php echo ew_HtmlEncode($m_data_tarif->bhp->getPlaceHolder()) ?>" value="<?php echo $m_data_tarif->bhp->EditValue ?>"<?php echo $m_data_tarif->bhp->EditAttributes() ?>>
</span>
<?php echo $m_data_tarif->bhp->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_data_tarif_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_data_tarif_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_data_tarifadd.Init();
</script>
<?php
$m_data_tarif_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_data_tarif_add->Page_Terminate();
?>
