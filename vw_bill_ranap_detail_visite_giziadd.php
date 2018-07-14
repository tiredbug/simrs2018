<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bill_ranap_detail_visite_giziinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_bill_ranapinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bill_ranap_detail_visite_gizi_add = NULL; // Initialize page object first

class cvw_bill_ranap_detail_visite_gizi_add extends cvw_bill_ranap_detail_visite_gizi {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bill_ranap_detail_visite_gizi';

	// Page object name
	var $PageObjName = 'vw_bill_ranap_detail_visite_gizi_add';

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

		// Table object (vw_bill_ranap_detail_visite_gizi)
		if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi"]) || get_class($GLOBALS["vw_bill_ranap_detail_visite_gizi"]) == "cvw_bill_ranap_detail_visite_gizi") {
			$GLOBALS["vw_bill_ranap_detail_visite_gizi"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bill_ranap_detail_visite_gizi"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (vw_bill_ranap)
		if (!isset($GLOBALS['vw_bill_ranap'])) $GLOBALS['vw_bill_ranap'] = new cvw_bill_ranap();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bill_ranap_detail_visite_gizi', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_bill_ranap_detail_visite_gizilist.php"));
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
		$this->id_admission->SetVisibility();
		$this->nomr->SetVisibility();
		$this->statusbayar->SetVisibility();
		$this->kelas->SetVisibility();
		$this->tanggal->SetVisibility();
		$this->kode_tindakan->SetVisibility();
		$this->tarif->SetVisibility();
		$this->qty->SetVisibility();
		$this->bhp->SetVisibility();
		$this->kelompok1->SetVisibility();
		$this->nama_tindakan->SetVisibility();
		$this->kelompok_tindakan->SetVisibility();
		$this->user->SetVisibility();
		$this->kelompok2->SetVisibility();
		$this->kode_farmasi->SetVisibility();
		$this->no_ruang->SetVisibility();

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
		global $EW_EXPORT, $vw_bill_ranap_detail_visite_gizi;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bill_ranap_detail_visite_gizi);
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
					$this->Page_Terminate("vw_bill_ranap_detail_visite_gizilist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_bill_ranap_detail_visite_gizilist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_bill_ranap_detail_visite_giziview.php")
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
		$this->id_admission->CurrentValue = NULL;
		$this->id_admission->OldValue = $this->id_admission->CurrentValue;
		$this->nomr->CurrentValue = NULL;
		$this->nomr->OldValue = $this->nomr->CurrentValue;
		$this->statusbayar->CurrentValue = NULL;
		$this->statusbayar->OldValue = $this->statusbayar->CurrentValue;
		$this->kelas->CurrentValue = NULL;
		$this->kelas->OldValue = $this->kelas->CurrentValue;
		$this->tanggal->CurrentValue = date("d/m/Y");
		$this->kode_tindakan->CurrentValue = NULL;
		$this->kode_tindakan->OldValue = $this->kode_tindakan->CurrentValue;
		$this->tarif->CurrentValue = 0;
		$this->qty->CurrentValue = 1;
		$this->bhp->CurrentValue = 0;
		$this->kelompok1->CurrentValue = NULL;
		$this->kelompok1->OldValue = $this->kelompok1->CurrentValue;
		$this->nama_tindakan->CurrentValue = NULL;
		$this->nama_tindakan->OldValue = $this->nama_tindakan->CurrentValue;
		$this->kelompok_tindakan->CurrentValue = NULL;
		$this->kelompok_tindakan->OldValue = $this->kelompok_tindakan->CurrentValue;
		$this->user->CurrentValue = CurrentUserName();
		$this->kelompok2->CurrentValue = NULL;
		$this->kelompok2->OldValue = $this->kelompok2->CurrentValue;
		$this->kode_farmasi->CurrentValue = NULL;
		$this->kode_farmasi->OldValue = $this->kode_farmasi->CurrentValue;
		$this->no_ruang->CurrentValue = NULL;
		$this->no_ruang->OldValue = $this->no_ruang->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_admission->FldIsDetailKey) {
			$this->id_admission->setFormValue($objForm->GetValue("x_id_admission"));
		}
		if (!$this->nomr->FldIsDetailKey) {
			$this->nomr->setFormValue($objForm->GetValue("x_nomr"));
		}
		if (!$this->statusbayar->FldIsDetailKey) {
			$this->statusbayar->setFormValue($objForm->GetValue("x_statusbayar"));
		}
		if (!$this->kelas->FldIsDetailKey) {
			$this->kelas->setFormValue($objForm->GetValue("x_kelas"));
		}
		if (!$this->tanggal->FldIsDetailKey) {
			$this->tanggal->setFormValue($objForm->GetValue("x_tanggal"));
			$this->tanggal->CurrentValue = ew_UnFormatDateTime($this->tanggal->CurrentValue, 7);
		}
		if (!$this->kode_tindakan->FldIsDetailKey) {
			$this->kode_tindakan->setFormValue($objForm->GetValue("x_kode_tindakan"));
		}
		if (!$this->tarif->FldIsDetailKey) {
			$this->tarif->setFormValue($objForm->GetValue("x_tarif"));
		}
		if (!$this->qty->FldIsDetailKey) {
			$this->qty->setFormValue($objForm->GetValue("x_qty"));
		}
		if (!$this->bhp->FldIsDetailKey) {
			$this->bhp->setFormValue($objForm->GetValue("x_bhp"));
		}
		if (!$this->kelompok1->FldIsDetailKey) {
			$this->kelompok1->setFormValue($objForm->GetValue("x_kelompok1"));
		}
		if (!$this->nama_tindakan->FldIsDetailKey) {
			$this->nama_tindakan->setFormValue($objForm->GetValue("x_nama_tindakan"));
		}
		if (!$this->kelompok_tindakan->FldIsDetailKey) {
			$this->kelompok_tindakan->setFormValue($objForm->GetValue("x_kelompok_tindakan"));
		}
		if (!$this->user->FldIsDetailKey) {
			$this->user->setFormValue($objForm->GetValue("x_user"));
		}
		if (!$this->kelompok2->FldIsDetailKey) {
			$this->kelompok2->setFormValue($objForm->GetValue("x_kelompok2"));
		}
		if (!$this->kode_farmasi->FldIsDetailKey) {
			$this->kode_farmasi->setFormValue($objForm->GetValue("x_kode_farmasi"));
		}
		if (!$this->no_ruang->FldIsDetailKey) {
			$this->no_ruang->setFormValue($objForm->GetValue("x_no_ruang"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_admission->CurrentValue = $this->id_admission->FormValue;
		$this->nomr->CurrentValue = $this->nomr->FormValue;
		$this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
		$this->kelas->CurrentValue = $this->kelas->FormValue;
		$this->tanggal->CurrentValue = $this->tanggal->FormValue;
		$this->tanggal->CurrentValue = ew_UnFormatDateTime($this->tanggal->CurrentValue, 7);
		$this->kode_tindakan->CurrentValue = $this->kode_tindakan->FormValue;
		$this->tarif->CurrentValue = $this->tarif->FormValue;
		$this->qty->CurrentValue = $this->qty->FormValue;
		$this->bhp->CurrentValue = $this->bhp->FormValue;
		$this->kelompok1->CurrentValue = $this->kelompok1->FormValue;
		$this->nama_tindakan->CurrentValue = $this->nama_tindakan->FormValue;
		$this->kelompok_tindakan->CurrentValue = $this->kelompok_tindakan->FormValue;
		$this->user->CurrentValue = $this->user->FormValue;
		$this->kelompok2->CurrentValue = $this->kelompok2->FormValue;
		$this->kode_farmasi->CurrentValue = $this->kode_farmasi->FormValue;
		$this->no_ruang->CurrentValue = $this->no_ruang->FormValue;
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->kode_tindakan->setDbValue($rs->fields('kode_tindakan'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->qty->setDbValue($rs->fields('qty'));
		$this->bhp->setDbValue($rs->fields('bhp'));
		$this->kelompok1->setDbValue($rs->fields('kelompok1'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->user->setDbValue($rs->fields('user'));
		$this->kelompok2->setDbValue($rs->fields('kelompok2'));
		$this->kode_farmasi->setDbValue($rs->fields('kode_farmasi'));
		$this->no_ruang->setDbValue($rs->fields('no_ruang'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kelas->DbValue = $row['kelas'];
		$this->tanggal->DbValue = $row['tanggal'];
		$this->kode_tindakan->DbValue = $row['kode_tindakan'];
		$this->tarif->DbValue = $row['tarif'];
		$this->qty->DbValue = $row['qty'];
		$this->bhp->DbValue = $row['bhp'];
		$this->kelompok1->DbValue = $row['kelompok1'];
		$this->nama_tindakan->DbValue = $row['nama_tindakan'];
		$this->kelompok_tindakan->DbValue = $row['kelompok_tindakan'];
		$this->user->DbValue = $row['user'];
		$this->kelompok2->DbValue = $row['kelompok2'];
		$this->kode_farmasi->DbValue = $row['kode_farmasi'];
		$this->no_ruang->DbValue = $row['no_ruang'];
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
		// id_admission
		// nomr
		// statusbayar
		// kelas
		// tanggal
		// kode_tindakan
		// tarif
		// qty
		// bhp
		// kelompok1
		// nama_tindakan
		// kelompok_tindakan
		// user
		// kelompok2
		// kode_farmasi
		// no_ruang

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
		$this->statusbayar->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->ViewCustomAttributes = "";

		// kode_tindakan
		if (strval($this->kode_tindakan->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_bill_ranap_data_tarif_tindakan`";
		$sWhereWrk = "";
		$this->kode_tindakan->LookupFilters = array();
		$lookuptblfilter = "`kelompok_tindakan`='11' ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->CurrentValue;
			}
		} else {
			$this->kode_tindakan->ViewValue = NULL;
		}
		$this->kode_tindakan->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// qty
		$this->qty->ViewValue = $this->qty->CurrentValue;
		$this->qty->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

		// kelompok1
		$this->kelompok1->ViewValue = $this->kelompok1->CurrentValue;
		$this->kelompok1->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// kelompok2
		$this->kelompok2->ViewValue = $this->kelompok2->CurrentValue;
		$this->kelompok2->ViewCustomAttributes = "";

		// kode_farmasi
		$this->kode_farmasi->ViewValue = $this->kode_farmasi->CurrentValue;
		$this->kode_farmasi->ViewCustomAttributes = "";

		// no_ruang
		$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->ViewCustomAttributes = "";

			// id_admission
			$this->id_admission->LinkCustomAttributes = "";
			$this->id_admission->HrefValue = "";
			$this->id_admission->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";
			$this->kelas->TooltipValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";
			$this->kode_tindakan->TooltipValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";
			$this->tarif->TooltipValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";
			$this->qty->TooltipValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";
			$this->bhp->TooltipValue = "";

			// kelompok1
			$this->kelompok1->LinkCustomAttributes = "";
			$this->kelompok1->HrefValue = "";
			$this->kelompok1->TooltipValue = "";

			// nama_tindakan
			$this->nama_tindakan->LinkCustomAttributes = "";
			$this->nama_tindakan->HrefValue = "";
			$this->nama_tindakan->TooltipValue = "";

			// kelompok_tindakan
			$this->kelompok_tindakan->LinkCustomAttributes = "";
			$this->kelompok_tindakan->HrefValue = "";
			$this->kelompok_tindakan->TooltipValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";
			$this->user->TooltipValue = "";

			// kelompok2
			$this->kelompok2->LinkCustomAttributes = "";
			$this->kelompok2->HrefValue = "";
			$this->kelompok2->TooltipValue = "";

			// kode_farmasi
			$this->kode_farmasi->LinkCustomAttributes = "";
			$this->kode_farmasi->HrefValue = "";
			$this->kode_farmasi->TooltipValue = "";

			// no_ruang
			$this->no_ruang->LinkCustomAttributes = "";
			$this->no_ruang->HrefValue = "";
			$this->no_ruang->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_admission
			$this->id_admission->EditAttrs["class"] = "form-control";
			$this->id_admission->EditCustomAttributes = "";
			if ($this->id_admission->getSessionValue() <> "") {
				$this->id_admission->CurrentValue = $this->id_admission->getSessionValue();
			$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
			$this->id_admission->ViewCustomAttributes = "";
			} else {
			$this->id_admission->EditValue = ew_HtmlEncode($this->id_admission->CurrentValue);
			$this->id_admission->PlaceHolder = ew_RemoveHtml($this->id_admission->FldCaption());
			}

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			if ($this->nomr->getSessionValue() <> "") {
				$this->nomr->CurrentValue = $this->nomr->getSessionValue();
			$this->nomr->ViewValue = $this->nomr->CurrentValue;
			$this->nomr->ViewCustomAttributes = "";
			} else {
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
			$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());
			}

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			if ($this->statusbayar->getSessionValue() <> "") {
				$this->statusbayar->CurrentValue = $this->statusbayar->getSessionValue();
			$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			$this->statusbayar->ViewCustomAttributes = "";
			} else {
			$this->statusbayar->EditValue = ew_HtmlEncode($this->statusbayar->CurrentValue);
			$this->statusbayar->PlaceHolder = ew_RemoveHtml($this->statusbayar->FldCaption());
			}

			// kelas
			$this->kelas->EditAttrs["class"] = "form-control";
			$this->kelas->EditCustomAttributes = "";
			if ($this->kelas->getSessionValue() <> "") {
				$this->kelas->CurrentValue = $this->kelas->getSessionValue();
			$this->kelas->ViewValue = $this->kelas->CurrentValue;
			$this->kelas->ViewCustomAttributes = "";
			} else {
			$this->kelas->EditValue = ew_HtmlEncode($this->kelas->CurrentValue);
			$this->kelas->PlaceHolder = ew_RemoveHtml($this->kelas->FldCaption());
			}

			// tanggal
			$this->tanggal->EditAttrs["class"] = "form-control";
			$this->tanggal->EditCustomAttributes = "";
			$this->tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal->CurrentValue, 7));
			$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

			// kode_tindakan
			$this->kode_tindakan->EditAttrs["class"] = "form-control";
			$this->kode_tindakan->EditCustomAttributes = "";
			if (trim(strval($this->kode_tindakan->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `vw_bill_ranap_data_tarif_tindakan`";
			$sWhereWrk = "";
			$this->kode_tindakan->LookupFilters = array();
			$lookuptblfilter = "`kelompok_tindakan`='11' ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kode_tindakan->EditValue = $arwrk;

			// tarif
			$this->tarif->EditAttrs["class"] = "form-control";
			$this->tarif->EditCustomAttributes = "";
			$this->tarif->EditValue = ew_HtmlEncode($this->tarif->CurrentValue);
			$this->tarif->PlaceHolder = ew_RemoveHtml($this->tarif->FldCaption());
			if (strval($this->tarif->EditValue) <> "" && is_numeric($this->tarif->EditValue)) $this->tarif->EditValue = ew_FormatNumber($this->tarif->EditValue, -2, -1, -2, 0);

			// qty
			$this->qty->EditAttrs["class"] = "form-control";
			$this->qty->EditCustomAttributes = "";
			$this->qty->EditValue = ew_HtmlEncode($this->qty->CurrentValue);
			$this->qty->PlaceHolder = ew_RemoveHtml($this->qty->FldCaption());

			// bhp
			$this->bhp->EditAttrs["class"] = "form-control";
			$this->bhp->EditCustomAttributes = "";
			$this->bhp->EditValue = ew_HtmlEncode($this->bhp->CurrentValue);
			$this->bhp->PlaceHolder = ew_RemoveHtml($this->bhp->FldCaption());
			if (strval($this->bhp->EditValue) <> "" && is_numeric($this->bhp->EditValue)) $this->bhp->EditValue = ew_FormatNumber($this->bhp->EditValue, -2, -1, -2, 0);

			// kelompok1
			$this->kelompok1->EditAttrs["class"] = "form-control";
			$this->kelompok1->EditCustomAttributes = "";
			$this->kelompok1->EditValue = ew_HtmlEncode($this->kelompok1->CurrentValue);
			$this->kelompok1->PlaceHolder = ew_RemoveHtml($this->kelompok1->FldCaption());

			// nama_tindakan
			$this->nama_tindakan->EditAttrs["class"] = "form-control";
			$this->nama_tindakan->EditCustomAttributes = "";
			$this->nama_tindakan->EditValue = ew_HtmlEncode($this->nama_tindakan->CurrentValue);
			$this->nama_tindakan->PlaceHolder = ew_RemoveHtml($this->nama_tindakan->FldCaption());

			// kelompok_tindakan
			$this->kelompok_tindakan->EditAttrs["class"] = "form-control";
			$this->kelompok_tindakan->EditCustomAttributes = "";
			$this->kelompok_tindakan->EditValue = ew_HtmlEncode($this->kelompok_tindakan->CurrentValue);
			$this->kelompok_tindakan->PlaceHolder = ew_RemoveHtml($this->kelompok_tindakan->FldCaption());

			// user
			$this->user->EditAttrs["class"] = "form-control";
			$this->user->EditCustomAttributes = "";
			$this->user->EditValue = ew_HtmlEncode($this->user->CurrentValue);
			$this->user->PlaceHolder = ew_RemoveHtml($this->user->FldCaption());

			// kelompok2
			$this->kelompok2->EditAttrs["class"] = "form-control";
			$this->kelompok2->EditCustomAttributes = "";
			$this->kelompok2->EditValue = ew_HtmlEncode($this->kelompok2->CurrentValue);
			$this->kelompok2->PlaceHolder = ew_RemoveHtml($this->kelompok2->FldCaption());

			// kode_farmasi
			$this->kode_farmasi->EditAttrs["class"] = "form-control";
			$this->kode_farmasi->EditCustomAttributes = "";
			$this->kode_farmasi->EditValue = ew_HtmlEncode($this->kode_farmasi->CurrentValue);
			$this->kode_farmasi->PlaceHolder = ew_RemoveHtml($this->kode_farmasi->FldCaption());

			// no_ruang
			$this->no_ruang->EditAttrs["class"] = "form-control";
			$this->no_ruang->EditCustomAttributes = "";
			if ($this->no_ruang->getSessionValue() <> "") {
				$this->no_ruang->CurrentValue = $this->no_ruang->getSessionValue();
			$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
			$this->no_ruang->ViewCustomAttributes = "";
			} else {
			$this->no_ruang->EditValue = ew_HtmlEncode($this->no_ruang->CurrentValue);
			$this->no_ruang->PlaceHolder = ew_RemoveHtml($this->no_ruang->FldCaption());
			}

			// Add refer script
			// id_admission

			$this->id_admission->LinkCustomAttributes = "";
			$this->id_admission->HrefValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";

			// kode_tindakan
			$this->kode_tindakan->LinkCustomAttributes = "";
			$this->kode_tindakan->HrefValue = "";

			// tarif
			$this->tarif->LinkCustomAttributes = "";
			$this->tarif->HrefValue = "";

			// qty
			$this->qty->LinkCustomAttributes = "";
			$this->qty->HrefValue = "";

			// bhp
			$this->bhp->LinkCustomAttributes = "";
			$this->bhp->HrefValue = "";

			// kelompok1
			$this->kelompok1->LinkCustomAttributes = "";
			$this->kelompok1->HrefValue = "";

			// nama_tindakan
			$this->nama_tindakan->LinkCustomAttributes = "";
			$this->nama_tindakan->HrefValue = "";

			// kelompok_tindakan
			$this->kelompok_tindakan->LinkCustomAttributes = "";
			$this->kelompok_tindakan->HrefValue = "";

			// user
			$this->user->LinkCustomAttributes = "";
			$this->user->HrefValue = "";

			// kelompok2
			$this->kelompok2->LinkCustomAttributes = "";
			$this->kelompok2->HrefValue = "";

			// kode_farmasi
			$this->kode_farmasi->LinkCustomAttributes = "";
			$this->kode_farmasi->HrefValue = "";

			// no_ruang
			$this->no_ruang->LinkCustomAttributes = "";
			$this->no_ruang->HrefValue = "";
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
		if (!ew_CheckInteger($this->id_admission->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_admission->FldErrMsg());
		}
		if (!ew_CheckInteger($this->statusbayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->statusbayar->FldErrMsg());
		}
		if (!ew_CheckInteger($this->kelas->FormValue)) {
			ew_AddMessage($gsFormError, $this->kelas->FldErrMsg());
		}
		if (!$this->tanggal->FldIsDetailKey && !is_null($this->tanggal->FormValue) && $this->tanggal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tanggal->FldCaption(), $this->tanggal->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal->FldErrMsg());
		}
		if (!$this->kode_tindakan->FldIsDetailKey && !is_null($this->kode_tindakan->FormValue) && $this->kode_tindakan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kode_tindakan->FldCaption(), $this->kode_tindakan->ReqErrMsg));
		}
		if (!$this->tarif->FldIsDetailKey && !is_null($this->tarif->FormValue) && $this->tarif->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tarif->FldCaption(), $this->tarif->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->tarif->FormValue)) {
			ew_AddMessage($gsFormError, $this->tarif->FldErrMsg());
		}
		if (!$this->qty->FldIsDetailKey && !is_null($this->qty->FormValue) && $this->qty->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->qty->FldCaption(), $this->qty->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->qty->FormValue)) {
			ew_AddMessage($gsFormError, $this->qty->FldErrMsg());
		}
		if (!ew_CheckNumber($this->bhp->FormValue)) {
			ew_AddMessage($gsFormError, $this->bhp->FldErrMsg());
		}
		if (!ew_CheckInteger($this->kelompok1->FormValue)) {
			ew_AddMessage($gsFormError, $this->kelompok1->FldErrMsg());
		}
		if (!ew_CheckInteger($this->kelompok_tindakan->FormValue)) {
			ew_AddMessage($gsFormError, $this->kelompok_tindakan->FldErrMsg());
		}
		if (!$this->user->FldIsDetailKey && !is_null($this->user->FormValue) && $this->user->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->user->FldCaption(), $this->user->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->kelompok2->FormValue)) {
			ew_AddMessage($gsFormError, $this->kelompok2->FldErrMsg());
		}
		if (!ew_CheckInteger($this->kode_farmasi->FormValue)) {
			ew_AddMessage($gsFormError, $this->kode_farmasi->FldErrMsg());
		}
		if (!ew_CheckInteger($this->no_ruang->FormValue)) {
			ew_AddMessage($gsFormError, $this->no_ruang->FldErrMsg());
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

		// id_admission
		$this->id_admission->SetDbValueDef($rsnew, $this->id_admission->CurrentValue, NULL, FALSE);

		// nomr
		$this->nomr->SetDbValueDef($rsnew, $this->nomr->CurrentValue, NULL, FALSE);

		// statusbayar
		$this->statusbayar->SetDbValueDef($rsnew, $this->statusbayar->CurrentValue, NULL, FALSE);

		// kelas
		$this->kelas->SetDbValueDef($rsnew, $this->kelas->CurrentValue, NULL, FALSE);

		// tanggal
		$this->tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal->CurrentValue, 7), NULL, FALSE);

		// kode_tindakan
		$this->kode_tindakan->SetDbValueDef($rsnew, $this->kode_tindakan->CurrentValue, NULL, FALSE);

		// tarif
		$this->tarif->SetDbValueDef($rsnew, $this->tarif->CurrentValue, NULL, strval($this->tarif->CurrentValue) == "");

		// qty
		$this->qty->SetDbValueDef($rsnew, $this->qty->CurrentValue, NULL, FALSE);

		// bhp
		$this->bhp->SetDbValueDef($rsnew, $this->bhp->CurrentValue, NULL, strval($this->bhp->CurrentValue) == "");

		// kelompok1
		$this->kelompok1->SetDbValueDef($rsnew, $this->kelompok1->CurrentValue, NULL, FALSE);

		// nama_tindakan
		$this->nama_tindakan->SetDbValueDef($rsnew, $this->nama_tindakan->CurrentValue, NULL, FALSE);

		// kelompok_tindakan
		$this->kelompok_tindakan->SetDbValueDef($rsnew, $this->kelompok_tindakan->CurrentValue, NULL, FALSE);

		// user
		$this->user->SetDbValueDef($rsnew, $this->user->CurrentValue, NULL, FALSE);

		// kelompok2
		$this->kelompok2->SetDbValueDef($rsnew, $this->kelompok2->CurrentValue, NULL, FALSE);

		// kode_farmasi
		$this->kode_farmasi->SetDbValueDef($rsnew, $this->kode_farmasi->CurrentValue, NULL, FALSE);

		// no_ruang
		$this->no_ruang->SetDbValueDef($rsnew, $this->no_ruang->CurrentValue, NULL, FALSE);

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
			if ($sMasterTblVar == "vw_bill_ranap") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id_admission"] <> "") {
					$GLOBALS["vw_bill_ranap"]->id_admission->setQueryStringValue($_GET["fk_id_admission"]);
					$this->id_admission->setQueryStringValue($GLOBALS["vw_bill_ranap"]->id_admission->QueryStringValue);
					$this->id_admission->setSessionValue($this->id_admission->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->id_admission->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_nomr"] <> "") {
					$GLOBALS["vw_bill_ranap"]->nomr->setQueryStringValue($_GET["fk_nomr"]);
					$this->nomr->setQueryStringValue($GLOBALS["vw_bill_ranap"]->nomr->QueryStringValue);
					$this->nomr->setSessionValue($this->nomr->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_statusbayar"] <> "") {
					$GLOBALS["vw_bill_ranap"]->statusbayar->setQueryStringValue($_GET["fk_statusbayar"]);
					$this->statusbayar->setQueryStringValue($GLOBALS["vw_bill_ranap"]->statusbayar->QueryStringValue);
					$this->statusbayar->setSessionValue($this->statusbayar->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->statusbayar->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_KELASPERAWATAN_ID"] <> "") {
					$GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->setQueryStringValue($_GET["fk_KELASPERAWATAN_ID"]);
					$this->kelas->setQueryStringValue($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->QueryStringValue);
					$this->kelas->setSessionValue($this->kelas->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_noruang"] <> "") {
					$GLOBALS["vw_bill_ranap"]->noruang->setQueryStringValue($_GET["fk_noruang"]);
					$this->no_ruang->setQueryStringValue($GLOBALS["vw_bill_ranap"]->noruang->QueryStringValue);
					$this->no_ruang->setSessionValue($this->no_ruang->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->noruang->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "vw_bill_ranap") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id_admission"] <> "") {
					$GLOBALS["vw_bill_ranap"]->id_admission->setFormValue($_POST["fk_id_admission"]);
					$this->id_admission->setFormValue($GLOBALS["vw_bill_ranap"]->id_admission->FormValue);
					$this->id_admission->setSessionValue($this->id_admission->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->id_admission->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_nomr"] <> "") {
					$GLOBALS["vw_bill_ranap"]->nomr->setFormValue($_POST["fk_nomr"]);
					$this->nomr->setFormValue($GLOBALS["vw_bill_ranap"]->nomr->FormValue);
					$this->nomr->setSessionValue($this->nomr->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_statusbayar"] <> "") {
					$GLOBALS["vw_bill_ranap"]->statusbayar->setFormValue($_POST["fk_statusbayar"]);
					$this->statusbayar->setFormValue($GLOBALS["vw_bill_ranap"]->statusbayar->FormValue);
					$this->statusbayar->setSessionValue($this->statusbayar->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->statusbayar->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_KELASPERAWATAN_ID"] <> "") {
					$GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->setFormValue($_POST["fk_KELASPERAWATAN_ID"]);
					$this->kelas->setFormValue($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->FormValue);
					$this->kelas->setSessionValue($this->kelas->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->KELASPERAWATAN_ID->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_noruang"] <> "") {
					$GLOBALS["vw_bill_ranap"]->noruang->setFormValue($_POST["fk_noruang"]);
					$this->no_ruang->setFormValue($GLOBALS["vw_bill_ranap"]->noruang->FormValue);
					$this->no_ruang->setSessionValue($this->no_ruang->FormValue);
					if (!is_numeric($GLOBALS["vw_bill_ranap"]->noruang->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "vw_bill_ranap") {
				if ($this->id_admission->CurrentValue == "") $this->id_admission->setSessionValue("");
				if ($this->nomr->CurrentValue == "") $this->nomr->setSessionValue("");
				if ($this->statusbayar->CurrentValue == "") $this->statusbayar->setSessionValue("");
				if ($this->kelas->CurrentValue == "") $this->kelas->setSessionValue("");
				if ($this->no_ruang->CurrentValue == "") $this->no_ruang->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bill_ranap_detail_visite_gizilist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_kode_tindakan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_bill_ranap_data_tarif_tindakan`";
			$sWhereWrk = "";
			$this->kode_tindakan->LookupFilters = array();
			$lookuptblfilter = "`kelompok_tindakan`='11' ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
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
if (!isset($vw_bill_ranap_detail_visite_gizi_add)) $vw_bill_ranap_detail_visite_gizi_add = new cvw_bill_ranap_detail_visite_gizi_add();

// Page init
$vw_bill_ranap_detail_visite_gizi_add->Page_Init();

// Page main
$vw_bill_ranap_detail_visite_gizi_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_detail_visite_gizi_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_bill_ranap_detail_visite_giziadd = new ew_Form("fvw_bill_ranap_detail_visite_giziadd", "add");

// Validate form
fvw_bill_ranap_detail_visite_giziadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id_admission");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->id_admission->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_statusbayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->statusbayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kelas");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->kelas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_visite_gizi->tanggal->FldCaption(), $vw_bill_ranap_detail_visite_gizi->tanggal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kode_tindakan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_visite_gizi->kode_tindakan->FldCaption(), $vw_bill_ranap_detail_visite_gizi->kode_tindakan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_visite_gizi->tarif->FldCaption(), $vw_bill_ranap_detail_visite_gizi->tarif->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tarif");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->tarif->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_visite_gizi->qty->FldCaption(), $vw_bill_ranap_detail_visite_gizi->qty->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_qty");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->qty->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bhp");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->bhp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kelompok1");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->kelompok1->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kelompok_tindakan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_user");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap_detail_visite_gizi->user->FldCaption(), $vw_bill_ranap_detail_visite_gizi->user->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kelompok2");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->kelompok2->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kode_farmasi");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->kode_farmasi->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_no_ruang");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_bill_ranap_detail_visite_gizi->no_ruang->FldErrMsg()) ?>");

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
fvw_bill_ranap_detail_visite_giziadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranap_detail_visite_giziadd.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranap_detail_visite_giziadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranap_detail_visite_giziadd.Lists["x_kode_tindakan"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":true,"DisplayFields":["x_nama_tindakan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_bill_ranap_data_tarif_tindakan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_bill_ranap_detail_visite_gizi_add->IsModal) { ?>
<?php } ?>
<?php $vw_bill_ranap_detail_visite_gizi_add->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_detail_visite_gizi_add->ShowMessage();
?>
<form name="fvw_bill_ranap_detail_visite_giziadd" id="fvw_bill_ranap_detail_visite_giziadd" class="<?php echo $vw_bill_ranap_detail_visite_gizi_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bill_ranap_detail_visite_gizi_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bill_ranap_detail_visite_gizi">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_bill_ranap_detail_visite_gizi_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->getCurrentMasterTable() == "vw_bill_ranap") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="vw_bill_ranap">
<input type="hidden" name="fk_id_admission" value="<?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->getSessionValue() ?>">
<input type="hidden" name="fk_nomr" value="<?php echo $vw_bill_ranap_detail_visite_gizi->nomr->getSessionValue() ?>">
<input type="hidden" name="fk_statusbayar" value="<?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->getSessionValue() ?>">
<input type="hidden" name="fk_KELASPERAWATAN_ID" value="<?php echo $vw_bill_ranap_detail_visite_gizi->kelas->getSessionValue() ?>">
<input type="hidden" name="fk_noruang" value="<?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($vw_bill_ranap_detail_visite_gizi->id_admission->Visible) { // id_admission ?>
	<div id="r_id_admission" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_id_admission" for="x_id_admission" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_visite_gizi->id_admission->getSessionValue() <> "") { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_id_admission">
<span<?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_id_admission" name="x_id_admission" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->id_admission->CurrentValue) ?>">
<?php } else { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_id_admission">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_id_admission" name="x_id_admission" id="x_id_admission" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->id_admission->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $vw_bill_ranap_detail_visite_gizi->id_admission->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_nomr" for="x_nomr" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->nomr->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->nomr->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_visite_gizi->nomr->getSessionValue() <> "") { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_nomr">
<span<?php echo $vw_bill_ranap_detail_visite_gizi->nomr->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_visite_gizi->nomr->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_nomr" name="x_nomr" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->nomr->CurrentValue) ?>">
<?php } else { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_nomr">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_nomr" name="x_nomr" id="x_nomr" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->nomr->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->nomr->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->nomr->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $vw_bill_ranap_detail_visite_gizi->nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->statusbayar->Visible) { // statusbayar ?>
	<div id="r_statusbayar" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_statusbayar" for="x_statusbayar" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_visite_gizi->statusbayar->getSessionValue() <> "") { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_statusbayar">
<span<?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_statusbayar" name="x_statusbayar" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->statusbayar->CurrentValue) ?>">
<?php } else { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_statusbayar">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_statusbayar" name="x_statusbayar" id="x_statusbayar" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->statusbayar->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $vw_bill_ranap_detail_visite_gizi->statusbayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->kelas->Visible) { // kelas ?>
	<div id="r_kelas" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_kelas" for="x_kelas" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->kelas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->kelas->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_visite_gizi->kelas->getSessionValue() <> "") { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_kelas">
<span<?php echo $vw_bill_ranap_detail_visite_gizi->kelas->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_visite_gizi->kelas->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_kelas" name="x_kelas" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->kelas->CurrentValue) ?>">
<?php } else { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_kelas">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_kelas" name="x_kelas" id="x_kelas" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->kelas->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->kelas->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->kelas->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $vw_bill_ranap_detail_visite_gizi->kelas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->tanggal->Visible) { // tanggal ?>
	<div id="r_tanggal" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_tanggal" for="x_tanggal" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->tanggal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->tanggal->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_tanggal">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_tanggal" data-format="7" name="x_tanggal" id="x_tanggal" size="8" maxlength="8" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->tanggal->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->tanggal->EditAttributes() ?>>
<?php if (!$vw_bill_ranap_detail_visite_gizi->tanggal->ReadOnly && !$vw_bill_ranap_detail_visite_gizi->tanggal->Disabled && !isset($vw_bill_ranap_detail_visite_gizi->tanggal->EditAttrs["readonly"]) && !isset($vw_bill_ranap_detail_visite_gizi->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_bill_ranap_detail_visite_giziadd", "x_tanggal", 7);
</script>
<?php } ?>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->kode_tindakan->Visible) { // kode_tindakan ?>
	<div id="r_kode_tindakan" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_kode_tindakan" for="x_kode_tindakan" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->kode_tindakan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->kode_tindakan->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_kode_tindakan">
<?php $vw_bill_ranap_detail_visite_gizi->kode_tindakan->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap_detail_visite_gizi->kode_tindakan->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_kode_tindakan" data-value-separator="<?php echo $vw_bill_ranap_detail_visite_gizi->kode_tindakan->DisplayValueSeparatorAttribute() ?>" id="x_kode_tindakan" name="x_kode_tindakan"<?php echo $vw_bill_ranap_detail_visite_gizi->kode_tindakan->EditAttributes() ?>>
<?php echo $vw_bill_ranap_detail_visite_gizi->kode_tindakan->SelectOptionListHtml("x_kode_tindakan") ?>
</select>
<input type="hidden" name="s_x_kode_tindakan" id="s_x_kode_tindakan" value="<?php echo $vw_bill_ranap_detail_visite_gizi->kode_tindakan->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_kode_tindakan" id="ln_x_kode_tindakan" value="x_tarif,x_bhp">
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->kode_tindakan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->tarif->Visible) { // tarif ?>
	<div id="r_tarif" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_tarif" for="x_tarif" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->tarif->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->tarif->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_tarif">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_tarif" name="x_tarif" id="x_tarif" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->tarif->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->tarif->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->tarif->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->tarif->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->qty->Visible) { // qty ?>
	<div id="r_qty" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_qty" for="x_qty" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->qty->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->qty->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_qty">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_qty" name="x_qty" id="x_qty" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->qty->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->qty->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->qty->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->qty->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->bhp->Visible) { // bhp ?>
	<div id="r_bhp" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_bhp" for="x_bhp" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->bhp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->bhp->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_bhp">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_bhp" name="x_bhp" id="x_bhp" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->bhp->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->bhp->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->bhp->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->bhp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->kelompok1->Visible) { // kelompok1 ?>
	<div id="r_kelompok1" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_kelompok1" for="x_kelompok1" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->kelompok1->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok1->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_kelompok1">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_kelompok1" name="x_kelompok1" id="x_kelompok1" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->kelompok1->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok1->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok1->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok1->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->nama_tindakan->Visible) { // nama_tindakan ?>
	<div id="r_nama_tindakan" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_nama_tindakan" for="x_nama_tindakan" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->nama_tindakan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->nama_tindakan->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_nama_tindakan">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_nama_tindakan" name="x_nama_tindakan" id="x_nama_tindakan" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->nama_tindakan->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->nama_tindakan->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->nama_tindakan->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->nama_tindakan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->Visible) { // kelompok_tindakan ?>
	<div id="r_kelompok_tindakan" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_kelompok_tindakan" for="x_kelompok_tindakan" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_kelompok_tindakan">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_kelompok_tindakan" name="x_kelompok_tindakan" id="x_kelompok_tindakan" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok_tindakan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->user->Visible) { // user ?>
	<div id="r_user" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_user" for="x_user" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->user->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->user->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_user">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_user" name="x_user" id="x_user" size="1" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->user->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->user->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->user->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->user->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->kelompok2->Visible) { // kelompok2 ?>
	<div id="r_kelompok2" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_kelompok2" for="x_kelompok2" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->kelompok2->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok2->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_kelompok2">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_kelompok2" name="x_kelompok2" id="x_kelompok2" size="1" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->kelompok2->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok2->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok2->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->kelompok2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->kode_farmasi->Visible) { // kode_farmasi ?>
	<div id="r_kode_farmasi" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_kode_farmasi" for="x_kode_farmasi" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->kode_farmasi->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->kode_farmasi->CellAttributes() ?>>
<span id="el_vw_bill_ranap_detail_visite_gizi_kode_farmasi">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_kode_farmasi" name="x_kode_farmasi" id="x_kode_farmasi" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->kode_farmasi->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->kode_farmasi->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->kode_farmasi->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap_detail_visite_gizi->kode_farmasi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap_detail_visite_gizi->no_ruang->Visible) { // no_ruang ?>
	<div id="r_no_ruang" class="form-group">
		<label id="elh_vw_bill_ranap_detail_visite_gizi_no_ruang" for="x_no_ruang" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->CellAttributes() ?>>
<?php if ($vw_bill_ranap_detail_visite_gizi->no_ruang->getSessionValue() <> "") { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_no_ruang">
<span<?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_no_ruang" name="x_no_ruang" value="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->no_ruang->CurrentValue) ?>">
<?php } else { ?>
<span id="el_vw_bill_ranap_detail_visite_gizi_no_ruang">
<input type="text" data-table="vw_bill_ranap_detail_visite_gizi" data-field="x_no_ruang" name="x_no_ruang" id="x_no_ruang" size="30" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap_detail_visite_gizi->no_ruang->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->EditValue ?>"<?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $vw_bill_ranap_detail_visite_gizi->no_ruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_bill_ranap_detail_visite_gizi_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bill_ranap_detail_visite_gizi_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_bill_ranap_detail_visite_giziadd.Init();
</script>
<?php
$vw_bill_ranap_detail_visite_gizi_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bill_ranap_detail_visite_gizi_add->Page_Terminate();
?>
