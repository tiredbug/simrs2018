<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_spdinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_spd_add = NULL; // Initialize page object first

class ct_spd_add extends ct_spd {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_spd';

	// Page object name
	var $PageObjName = 't_spd_add';

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

		// Table object (t_spd)
		if (!isset($GLOBALS["t_spd"]) || get_class($GLOBALS["t_spd"]) == "ct_spd") {
			$GLOBALS["t_spd"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_spd"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_spd', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_spdlist.php"));
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
		$this->jenis_peraturan->SetVisibility();
		$this->tanggal->SetVisibility();
		$this->no_spd->SetVisibility();
		$this->jumlah_spd->SetVisibility();
		$this->pembayaran->SetVisibility();
		$this->no_sk_dir->SetVisibility();
		$this->tgl_sk_dir->SetVisibility();
		$this->th_anggaran->SetVisibility();
		$this->tentang->SetVisibility();

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
		global $EW_EXPORT, $t_spd;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_spd);
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
					$this->Page_Terminate("t_spdlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_spdlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_spdview.php")
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
		$this->jenis_peraturan->CurrentValue = NULL;
		$this->jenis_peraturan->OldValue = $this->jenis_peraturan->CurrentValue;
		$this->tanggal->CurrentValue = NULL;
		$this->tanggal->OldValue = $this->tanggal->CurrentValue;
		$this->no_spd->CurrentValue = NULL;
		$this->no_spd->OldValue = $this->no_spd->CurrentValue;
		$this->jumlah_spd->CurrentValue = NULL;
		$this->jumlah_spd->OldValue = $this->jumlah_spd->CurrentValue;
		$this->pembayaran->CurrentValue = NULL;
		$this->pembayaran->OldValue = $this->pembayaran->CurrentValue;
		$this->no_sk_dir->CurrentValue = NULL;
		$this->no_sk_dir->OldValue = $this->no_sk_dir->CurrentValue;
		$this->tgl_sk_dir->CurrentValue = NULL;
		$this->tgl_sk_dir->OldValue = $this->tgl_sk_dir->CurrentValue;
		$this->th_anggaran->CurrentValue = NULL;
		$this->th_anggaran->OldValue = $this->th_anggaran->CurrentValue;
		$this->tentang->CurrentValue = NULL;
		$this->tentang->OldValue = $this->tentang->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->jenis_peraturan->FldIsDetailKey) {
			$this->jenis_peraturan->setFormValue($objForm->GetValue("x_jenis_peraturan"));
		}
		if (!$this->tanggal->FldIsDetailKey) {
			$this->tanggal->setFormValue($objForm->GetValue("x_tanggal"));
			$this->tanggal->CurrentValue = ew_UnFormatDateTime($this->tanggal->CurrentValue, 7);
		}
		if (!$this->no_spd->FldIsDetailKey) {
			$this->no_spd->setFormValue($objForm->GetValue("x_no_spd"));
		}
		if (!$this->jumlah_spd->FldIsDetailKey) {
			$this->jumlah_spd->setFormValue($objForm->GetValue("x_jumlah_spd"));
		}
		if (!$this->pembayaran->FldIsDetailKey) {
			$this->pembayaran->setFormValue($objForm->GetValue("x_pembayaran"));
		}
		if (!$this->no_sk_dir->FldIsDetailKey) {
			$this->no_sk_dir->setFormValue($objForm->GetValue("x_no_sk_dir"));
		}
		if (!$this->tgl_sk_dir->FldIsDetailKey) {
			$this->tgl_sk_dir->setFormValue($objForm->GetValue("x_tgl_sk_dir"));
			$this->tgl_sk_dir->CurrentValue = ew_UnFormatDateTime($this->tgl_sk_dir->CurrentValue, 7);
		}
		if (!$this->th_anggaran->FldIsDetailKey) {
			$this->th_anggaran->setFormValue($objForm->GetValue("x_th_anggaran"));
		}
		if (!$this->tentang->FldIsDetailKey) {
			$this->tentang->setFormValue($objForm->GetValue("x_tentang"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->jenis_peraturan->CurrentValue = $this->jenis_peraturan->FormValue;
		$this->tanggal->CurrentValue = $this->tanggal->FormValue;
		$this->tanggal->CurrentValue = ew_UnFormatDateTime($this->tanggal->CurrentValue, 7);
		$this->no_spd->CurrentValue = $this->no_spd->FormValue;
		$this->jumlah_spd->CurrentValue = $this->jumlah_spd->FormValue;
		$this->pembayaran->CurrentValue = $this->pembayaran->FormValue;
		$this->no_sk_dir->CurrentValue = $this->no_sk_dir->FormValue;
		$this->tgl_sk_dir->CurrentValue = $this->tgl_sk_dir->FormValue;
		$this->tgl_sk_dir->CurrentValue = ew_UnFormatDateTime($this->tgl_sk_dir->CurrentValue, 7);
		$this->th_anggaran->CurrentValue = $this->th_anggaran->FormValue;
		$this->tentang->CurrentValue = $this->tentang->FormValue;
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
		$this->jenis_peraturan->setDbValue($rs->fields('jenis_peraturan'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->no_spd->setDbValue($rs->fields('no_spd'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->pembayaran->setDbValue($rs->fields('pembayaran'));
		$this->no_sk_dir->setDbValue($rs->fields('no_sk_dir'));
		$this->tgl_sk_dir->setDbValue($rs->fields('tgl_sk_dir'));
		$this->th_anggaran->setDbValue($rs->fields('th_anggaran'));
		$this->tentang->setDbValue($rs->fields('tentang'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->jenis_peraturan->DbValue = $row['jenis_peraturan'];
		$this->tanggal->DbValue = $row['tanggal'];
		$this->no_spd->DbValue = $row['no_spd'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
		$this->pembayaran->DbValue = $row['pembayaran'];
		$this->no_sk_dir->DbValue = $row['no_sk_dir'];
		$this->tgl_sk_dir->DbValue = $row['tgl_sk_dir'];
		$this->th_anggaran->DbValue = $row['th_anggaran'];
		$this->tentang->DbValue = $row['tentang'];
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

		if ($this->jumlah_spd->FormValue == $this->jumlah_spd->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_spd->CurrentValue)))
			$this->jumlah_spd->CurrentValue = ew_StrToFloat($this->jumlah_spd->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// jenis_peraturan
		// tanggal
		// no_spd
		// jumlah_spd
		// pembayaran
		// no_sk_dir
		// tgl_sk_dir
		// th_anggaran
		// tentang

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// jenis_peraturan
		if (strval($this->jenis_peraturan->CurrentValue) <> "") {
			$this->jenis_peraturan->ViewValue = $this->jenis_peraturan->OptionCaption($this->jenis_peraturan->CurrentValue);
		} else {
			$this->jenis_peraturan->ViewValue = NULL;
		}
		$this->jenis_peraturan->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->ViewCustomAttributes = "";

		// no_spd
		$this->no_spd->ViewValue = $this->no_spd->CurrentValue;
		$this->no_spd->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

		// pembayaran
		$this->pembayaran->ViewValue = $this->pembayaran->CurrentValue;
		$this->pembayaran->ViewCustomAttributes = "";

		// no_sk_dir
		$this->no_sk_dir->ViewValue = $this->no_sk_dir->CurrentValue;
		$this->no_sk_dir->ViewCustomAttributes = "";

		// tgl_sk_dir
		$this->tgl_sk_dir->ViewValue = $this->tgl_sk_dir->CurrentValue;
		$this->tgl_sk_dir->ViewValue = ew_FormatDateTime($this->tgl_sk_dir->ViewValue, 7);
		$this->tgl_sk_dir->ViewCustomAttributes = "";

		// th_anggaran
		$this->th_anggaran->ViewValue = $this->th_anggaran->CurrentValue;
		$this->th_anggaran->ViewCustomAttributes = "";

		// tentang
		$this->tentang->ViewValue = $this->tentang->CurrentValue;
		$this->tentang->ViewCustomAttributes = "";

			// jenis_peraturan
			$this->jenis_peraturan->LinkCustomAttributes = "";
			$this->jenis_peraturan->HrefValue = "";
			$this->jenis_peraturan->TooltipValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// no_spd
			$this->no_spd->LinkCustomAttributes = "";
			$this->no_spd->HrefValue = "";
			$this->no_spd->TooltipValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";
			$this->jumlah_spd->TooltipValue = "";

			// pembayaran
			$this->pembayaran->LinkCustomAttributes = "";
			$this->pembayaran->HrefValue = "";
			$this->pembayaran->TooltipValue = "";

			// no_sk_dir
			$this->no_sk_dir->LinkCustomAttributes = "";
			$this->no_sk_dir->HrefValue = "";
			$this->no_sk_dir->TooltipValue = "";

			// tgl_sk_dir
			$this->tgl_sk_dir->LinkCustomAttributes = "";
			$this->tgl_sk_dir->HrefValue = "";
			$this->tgl_sk_dir->TooltipValue = "";

			// th_anggaran
			$this->th_anggaran->LinkCustomAttributes = "";
			$this->th_anggaran->HrefValue = "";
			$this->th_anggaran->TooltipValue = "";

			// tentang
			$this->tentang->LinkCustomAttributes = "";
			$this->tentang->HrefValue = "";
			$this->tentang->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// jenis_peraturan
			$this->jenis_peraturan->EditAttrs["class"] = "form-control";
			$this->jenis_peraturan->EditCustomAttributes = "";
			$this->jenis_peraturan->EditValue = $this->jenis_peraturan->Options(TRUE);

			// tanggal
			$this->tanggal->EditAttrs["class"] = "form-control";
			$this->tanggal->EditCustomAttributes = "";
			$this->tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal->CurrentValue, 7));
			$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

			// no_spd
			$this->no_spd->EditAttrs["class"] = "form-control";
			$this->no_spd->EditCustomAttributes = "";
			$this->no_spd->EditValue = ew_HtmlEncode($this->no_spd->CurrentValue);
			$this->no_spd->PlaceHolder = ew_RemoveHtml($this->no_spd->FldCaption());

			// jumlah_spd
			$this->jumlah_spd->EditAttrs["class"] = "form-control";
			$this->jumlah_spd->EditCustomAttributes = "";
			$this->jumlah_spd->EditValue = ew_HtmlEncode($this->jumlah_spd->CurrentValue);
			$this->jumlah_spd->PlaceHolder = ew_RemoveHtml($this->jumlah_spd->FldCaption());
			if (strval($this->jumlah_spd->EditValue) <> "" && is_numeric($this->jumlah_spd->EditValue)) $this->jumlah_spd->EditValue = ew_FormatNumber($this->jumlah_spd->EditValue, -2, -1, -2, 0);

			// pembayaran
			$this->pembayaran->EditAttrs["class"] = "form-control";
			$this->pembayaran->EditCustomAttributes = "";
			$this->pembayaran->EditValue = ew_HtmlEncode($this->pembayaran->CurrentValue);
			$this->pembayaran->PlaceHolder = ew_RemoveHtml($this->pembayaran->FldCaption());

			// no_sk_dir
			$this->no_sk_dir->EditAttrs["class"] = "form-control";
			$this->no_sk_dir->EditCustomAttributes = "";
			$this->no_sk_dir->EditValue = ew_HtmlEncode($this->no_sk_dir->CurrentValue);
			$this->no_sk_dir->PlaceHolder = ew_RemoveHtml($this->no_sk_dir->FldCaption());

			// tgl_sk_dir
			$this->tgl_sk_dir->EditAttrs["class"] = "form-control";
			$this->tgl_sk_dir->EditCustomAttributes = "";
			$this->tgl_sk_dir->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sk_dir->CurrentValue, 7));
			$this->tgl_sk_dir->PlaceHolder = ew_RemoveHtml($this->tgl_sk_dir->FldCaption());

			// th_anggaran
			$this->th_anggaran->EditAttrs["class"] = "form-control";
			$this->th_anggaran->EditCustomAttributes = "";
			$this->th_anggaran->EditValue = ew_HtmlEncode($this->th_anggaran->CurrentValue);
			$this->th_anggaran->PlaceHolder = ew_RemoveHtml($this->th_anggaran->FldCaption());

			// tentang
			$this->tentang->EditAttrs["class"] = "form-control";
			$this->tentang->EditCustomAttributes = "";
			$this->tentang->EditValue = ew_HtmlEncode($this->tentang->CurrentValue);
			$this->tentang->PlaceHolder = ew_RemoveHtml($this->tentang->FldCaption());

			// Add refer script
			// jenis_peraturan

			$this->jenis_peraturan->LinkCustomAttributes = "";
			$this->jenis_peraturan->HrefValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";

			// no_spd
			$this->no_spd->LinkCustomAttributes = "";
			$this->no_spd->HrefValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";

			// pembayaran
			$this->pembayaran->LinkCustomAttributes = "";
			$this->pembayaran->HrefValue = "";

			// no_sk_dir
			$this->no_sk_dir->LinkCustomAttributes = "";
			$this->no_sk_dir->HrefValue = "";

			// tgl_sk_dir
			$this->tgl_sk_dir->LinkCustomAttributes = "";
			$this->tgl_sk_dir->HrefValue = "";

			// th_anggaran
			$this->th_anggaran->LinkCustomAttributes = "";
			$this->th_anggaran->HrefValue = "";

			// tentang
			$this->tentang->LinkCustomAttributes = "";
			$this->tentang->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->tanggal->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal->FldErrMsg());
		}
		if (!ew_CheckNumber($this->jumlah_spd->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_spd->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->tgl_sk_dir->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_sk_dir->FldErrMsg());
		}
		if (!ew_CheckInteger($this->th_anggaran->FormValue)) {
			ew_AddMessage($gsFormError, $this->th_anggaran->FldErrMsg());
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

		// jenis_peraturan
		$this->jenis_peraturan->SetDbValueDef($rsnew, $this->jenis_peraturan->CurrentValue, NULL, FALSE);

		// tanggal
		$this->tanggal->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal->CurrentValue, 7), NULL, FALSE);

		// no_spd
		$this->no_spd->SetDbValueDef($rsnew, $this->no_spd->CurrentValue, NULL, FALSE);

		// jumlah_spd
		$this->jumlah_spd->SetDbValueDef($rsnew, $this->jumlah_spd->CurrentValue, NULL, FALSE);

		// pembayaran
		$this->pembayaran->SetDbValueDef($rsnew, $this->pembayaran->CurrentValue, NULL, FALSE);

		// no_sk_dir
		$this->no_sk_dir->SetDbValueDef($rsnew, $this->no_sk_dir->CurrentValue, NULL, FALSE);

		// tgl_sk_dir
		$this->tgl_sk_dir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sk_dir->CurrentValue, 7), NULL, FALSE);

		// th_anggaran
		$this->th_anggaran->SetDbValueDef($rsnew, $this->th_anggaran->CurrentValue, NULL, FALSE);

		// tentang
		$this->tentang->SetDbValueDef($rsnew, $this->tentang->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_spdlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_spd_add)) $t_spd_add = new ct_spd_add();

// Page init
$t_spd_add->Page_Init();

// Page main
$t_spd_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_spd_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_spdadd = new ew_Form("ft_spdadd", "add");

// Validate form
ft_spdadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tanggal");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spd->tanggal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_spd");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spd->jumlah_spd->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_sk_dir");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spd->tgl_sk_dir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_th_anggaran");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_spd->th_anggaran->FldErrMsg()) ?>");

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
ft_spdadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_spdadd.ValidateRequired = true;
<?php } else { ?>
ft_spdadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_spdadd.Lists["x_jenis_peraturan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_spdadd.Lists["x_jenis_peraturan"].Options = <?php echo json_encode($t_spd->jenis_peraturan->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_spd_add->IsModal) { ?>
<?php } ?>
<?php $t_spd_add->ShowPageHeader(); ?>
<?php
$t_spd_add->ShowMessage();
?>
<form name="ft_spdadd" id="ft_spdadd" class="<?php echo $t_spd_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_spd_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_spd_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_spd">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_spd_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_spd->jenis_peraturan->Visible) { // jenis_peraturan ?>
	<div id="r_jenis_peraturan" class="form-group">
		<label id="elh_t_spd_jenis_peraturan" for="x_jenis_peraturan" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->jenis_peraturan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->jenis_peraturan->CellAttributes() ?>>
<span id="el_t_spd_jenis_peraturan">
<select data-table="t_spd" data-field="x_jenis_peraturan" data-value-separator="<?php echo $t_spd->jenis_peraturan->DisplayValueSeparatorAttribute() ?>" id="x_jenis_peraturan" name="x_jenis_peraturan"<?php echo $t_spd->jenis_peraturan->EditAttributes() ?>>
<?php echo $t_spd->jenis_peraturan->SelectOptionListHtml("x_jenis_peraturan") ?>
</select>
</span>
<?php echo $t_spd->jenis_peraturan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->tanggal->Visible) { // tanggal ?>
	<div id="r_tanggal" class="form-group">
		<label id="elh_t_spd_tanggal" for="x_tanggal" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->tanggal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->tanggal->CellAttributes() ?>>
<span id="el_t_spd_tanggal">
<input type="text" data-table="t_spd" data-field="x_tanggal" data-format="7" name="x_tanggal" id="x_tanggal" placeholder="<?php echo ew_HtmlEncode($t_spd->tanggal->getPlaceHolder()) ?>" value="<?php echo $t_spd->tanggal->EditValue ?>"<?php echo $t_spd->tanggal->EditAttributes() ?>>
<?php if (!$t_spd->tanggal->ReadOnly && !$t_spd->tanggal->Disabled && !isset($t_spd->tanggal->EditAttrs["readonly"]) && !isset($t_spd->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_spdadd", "x_tanggal", 7);
</script>
<?php } ?>
</span>
<?php echo $t_spd->tanggal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->no_spd->Visible) { // no_spd ?>
	<div id="r_no_spd" class="form-group">
		<label id="elh_t_spd_no_spd" for="x_no_spd" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->no_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->no_spd->CellAttributes() ?>>
<span id="el_t_spd_no_spd">
<input type="text" data-table="t_spd" data-field="x_no_spd" name="x_no_spd" id="x_no_spd" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spd->no_spd->getPlaceHolder()) ?>" value="<?php echo $t_spd->no_spd->EditValue ?>"<?php echo $t_spd->no_spd->EditAttributes() ?>>
</span>
<?php echo $t_spd->no_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->jumlah_spd->Visible) { // jumlah_spd ?>
	<div id="r_jumlah_spd" class="form-group">
		<label id="elh_t_spd_jumlah_spd" for="x_jumlah_spd" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->jumlah_spd->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->jumlah_spd->CellAttributes() ?>>
<span id="el_t_spd_jumlah_spd">
<input type="text" data-table="t_spd" data-field="x_jumlah_spd" name="x_jumlah_spd" id="x_jumlah_spd" size="30" placeholder="<?php echo ew_HtmlEncode($t_spd->jumlah_spd->getPlaceHolder()) ?>" value="<?php echo $t_spd->jumlah_spd->EditValue ?>"<?php echo $t_spd->jumlah_spd->EditAttributes() ?>>
</span>
<?php echo $t_spd->jumlah_spd->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->pembayaran->Visible) { // pembayaran ?>
	<div id="r_pembayaran" class="form-group">
		<label id="elh_t_spd_pembayaran" for="x_pembayaran" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->pembayaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->pembayaran->CellAttributes() ?>>
<span id="el_t_spd_pembayaran">
<input type="text" data-table="t_spd" data-field="x_pembayaran" name="x_pembayaran" id="x_pembayaran" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spd->pembayaran->getPlaceHolder()) ?>" value="<?php echo $t_spd->pembayaran->EditValue ?>"<?php echo $t_spd->pembayaran->EditAttributes() ?>>
</span>
<?php echo $t_spd->pembayaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->no_sk_dir->Visible) { // no_sk_dir ?>
	<div id="r_no_sk_dir" class="form-group">
		<label id="elh_t_spd_no_sk_dir" for="x_no_sk_dir" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->no_sk_dir->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->no_sk_dir->CellAttributes() ?>>
<span id="el_t_spd_no_sk_dir">
<input type="text" data-table="t_spd" data-field="x_no_sk_dir" name="x_no_sk_dir" id="x_no_sk_dir" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_spd->no_sk_dir->getPlaceHolder()) ?>" value="<?php echo $t_spd->no_sk_dir->EditValue ?>"<?php echo $t_spd->no_sk_dir->EditAttributes() ?>>
</span>
<?php echo $t_spd->no_sk_dir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->tgl_sk_dir->Visible) { // tgl_sk_dir ?>
	<div id="r_tgl_sk_dir" class="form-group">
		<label id="elh_t_spd_tgl_sk_dir" for="x_tgl_sk_dir" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->tgl_sk_dir->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->tgl_sk_dir->CellAttributes() ?>>
<span id="el_t_spd_tgl_sk_dir">
<input type="text" data-table="t_spd" data-field="x_tgl_sk_dir" data-format="7" name="x_tgl_sk_dir" id="x_tgl_sk_dir" placeholder="<?php echo ew_HtmlEncode($t_spd->tgl_sk_dir->getPlaceHolder()) ?>" value="<?php echo $t_spd->tgl_sk_dir->EditValue ?>"<?php echo $t_spd->tgl_sk_dir->EditAttributes() ?>>
<?php if (!$t_spd->tgl_sk_dir->ReadOnly && !$t_spd->tgl_sk_dir->Disabled && !isset($t_spd->tgl_sk_dir->EditAttrs["readonly"]) && !isset($t_spd->tgl_sk_dir->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_spdadd", "x_tgl_sk_dir", 7);
</script>
<?php } ?>
</span>
<?php echo $t_spd->tgl_sk_dir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->th_anggaran->Visible) { // th_anggaran ?>
	<div id="r_th_anggaran" class="form-group">
		<label id="elh_t_spd_th_anggaran" for="x_th_anggaran" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->th_anggaran->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->th_anggaran->CellAttributes() ?>>
<span id="el_t_spd_th_anggaran">
<input type="text" data-table="t_spd" data-field="x_th_anggaran" name="x_th_anggaran" id="x_th_anggaran" size="30" placeholder="<?php echo ew_HtmlEncode($t_spd->th_anggaran->getPlaceHolder()) ?>" value="<?php echo $t_spd->th_anggaran->EditValue ?>"<?php echo $t_spd->th_anggaran->EditAttributes() ?>>
</span>
<?php echo $t_spd->th_anggaran->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_spd->tentang->Visible) { // tentang ?>
	<div id="r_tentang" class="form-group">
		<label id="elh_t_spd_tentang" for="x_tentang" class="col-sm-2 control-label ewLabel"><?php echo $t_spd->tentang->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_spd->tentang->CellAttributes() ?>>
<span id="el_t_spd_tentang">
<textarea data-table="t_spd" data-field="x_tentang" name="x_tentang" id="x_tentang" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($t_spd->tentang->getPlaceHolder()) ?>"<?php echo $t_spd->tentang->EditAttributes() ?>><?php echo $t_spd->tentang->EditValue ?></textarea>
</span>
<?php echo $t_spd->tentang->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_spd_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_spd_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_spdadd.Init();
</script>
<?php
$t_spd_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_spd_add->Page_Terminate();
?>
