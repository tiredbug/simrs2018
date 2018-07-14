<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_ls_gaji_tunjanganinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "l_jenis_detail_sppinfo.php" ?>
<?php include_once "t_spp_detailgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_ls_gaji_tunjangan_add = NULL; // Initialize page object first

class cvw_spp_ls_gaji_tunjangan_add extends cvw_spp_ls_gaji_tunjangan {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_ls_gaji_tunjangan';

	// Page object name
	var $PageObjName = 'vw_spp_ls_gaji_tunjangan_add';

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

		// Table object (vw_spp_ls_gaji_tunjangan)
		if (!isset($GLOBALS["vw_spp_ls_gaji_tunjangan"]) || get_class($GLOBALS["vw_spp_ls_gaji_tunjangan"]) == "cvw_spp_ls_gaji_tunjangan") {
			$GLOBALS["vw_spp_ls_gaji_tunjangan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_ls_gaji_tunjangan"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (l_jenis_detail_spp)
		if (!isset($GLOBALS['l_jenis_detail_spp'])) $GLOBALS['l_jenis_detail_spp'] = new cl_jenis_detail_spp();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_ls_gaji_tunjangan', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_ls_gaji_tunjanganlist.php"));
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
		$this->detail_jenis_spp->SetVisibility();
		$this->id_jenis_spp->SetVisibility();
		$this->status_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();
		$this->keterangan->SetVisibility();

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

			// Process auto fill for detail table 't_spp_detail'
			if (@$_POST["grid"] == "ft_spp_detailgrid") {
				if (!isset($GLOBALS["t_spp_detail_grid"])) $GLOBALS["t_spp_detail_grid"] = new ct_spp_detail_grid;
				$GLOBALS["t_spp_detail_grid"]->Page_Init();
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
		global $EW_EXPORT, $vw_spp_ls_gaji_tunjangan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_ls_gaji_tunjangan);
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("vw_spp_ls_gaji_tunjanganlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_spp_ls_gaji_tunjanganlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_spp_ls_gaji_tunjanganview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->detail_jenis_spp->CurrentValue = NULL;
		$this->detail_jenis_spp->OldValue = $this->detail_jenis_spp->CurrentValue;
		$this->id_jenis_spp->CurrentValue = NULL;
		$this->id_jenis_spp->OldValue = $this->id_jenis_spp->CurrentValue;
		$this->status_spp->CurrentValue = NULL;
		$this->status_spp->OldValue = $this->status_spp->CurrentValue;
		$this->no_spp->CurrentValue = NULL;
		$this->no_spp->OldValue = $this->no_spp->CurrentValue;
		$this->tgl_spp->CurrentValue = NULL;
		$this->tgl_spp->OldValue = $this->tgl_spp->CurrentValue;
		$this->keterangan->CurrentValue = NULL;
		$this->keterangan->OldValue = $this->keterangan->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->detail_jenis_spp->FldIsDetailKey) {
			$this->detail_jenis_spp->setFormValue($objForm->GetValue("x_detail_jenis_spp"));
		}
		if (!$this->id_jenis_spp->FldIsDetailKey) {
			$this->id_jenis_spp->setFormValue($objForm->GetValue("x_id_jenis_spp"));
		}
		if (!$this->status_spp->FldIsDetailKey) {
			$this->status_spp->setFormValue($objForm->GetValue("x_status_spp"));
		}
		if (!$this->no_spp->FldIsDetailKey) {
			$this->no_spp->setFormValue($objForm->GetValue("x_no_spp"));
		}
		if (!$this->tgl_spp->FldIsDetailKey) {
			$this->tgl_spp->setFormValue($objForm->GetValue("x_tgl_spp"));
			$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 0);
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->FormValue;
		$this->id_jenis_spp->CurrentValue = $this->id_jenis_spp->FormValue;
		$this->status_spp->CurrentValue = $this->status_spp->FormValue;
		$this->no_spp->CurrentValue = $this->no_spp->FormValue;
		$this->tgl_spp->CurrentValue = $this->tgl_spp->FormValue;
		$this->tgl_spp->CurrentValue = ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 0);
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
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
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->status_spp->setDbValue($rs->fields('status_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->status_spp->DbValue = $row['status_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->tgl_spp->DbValue = $row['tgl_spp'];
		$this->keterangan->DbValue = $row['keterangan'];
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
		// detail_jenis_spp
		// id_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// keterangan

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// status_spp
		$this->status_spp->ViewValue = $this->status_spp->CurrentValue;
		$this->status_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// tgl_spp
		$this->tgl_spp->ViewValue = $this->tgl_spp->CurrentValue;
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 0);
		$this->tgl_spp->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

			// detail_jenis_spp
			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";
			$this->detail_jenis_spp->TooltipValue = "";

			// id_jenis_spp
			$this->id_jenis_spp->LinkCustomAttributes = "";
			$this->id_jenis_spp->HrefValue = "";
			$this->id_jenis_spp->TooltipValue = "";

			// status_spp
			$this->status_spp->LinkCustomAttributes = "";
			$this->status_spp->HrefValue = "";
			$this->status_spp->TooltipValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";
			$this->no_spp->TooltipValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";
			$this->tgl_spp->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// detail_jenis_spp
			$this->detail_jenis_spp->EditAttrs["class"] = "form-control";
			$this->detail_jenis_spp->EditCustomAttributes = "";
			if ($this->detail_jenis_spp->getSessionValue() <> "") {
				$this->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->getSessionValue();
			$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
			$this->detail_jenis_spp->ViewCustomAttributes = "";
			} else {
			$this->detail_jenis_spp->EditValue = ew_HtmlEncode($this->detail_jenis_spp->CurrentValue);
			$this->detail_jenis_spp->PlaceHolder = ew_RemoveHtml($this->detail_jenis_spp->FldCaption());
			}

			// id_jenis_spp
			$this->id_jenis_spp->EditAttrs["class"] = "form-control";
			$this->id_jenis_spp->EditCustomAttributes = "";
			if ($this->id_jenis_spp->getSessionValue() <> "") {
				$this->id_jenis_spp->CurrentValue = $this->id_jenis_spp->getSessionValue();
			$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
			$this->id_jenis_spp->ViewCustomAttributes = "";
			} else {
			$this->id_jenis_spp->EditValue = ew_HtmlEncode($this->id_jenis_spp->CurrentValue);
			$this->id_jenis_spp->PlaceHolder = ew_RemoveHtml($this->id_jenis_spp->FldCaption());
			}

			// status_spp
			$this->status_spp->EditAttrs["class"] = "form-control";
			$this->status_spp->EditCustomAttributes = "";
			$this->status_spp->EditValue = ew_HtmlEncode($this->status_spp->CurrentValue);
			$this->status_spp->PlaceHolder = ew_RemoveHtml($this->status_spp->FldCaption());

			// no_spp
			$this->no_spp->EditAttrs["class"] = "form-control";
			$this->no_spp->EditCustomAttributes = "";
			$this->no_spp->EditValue = ew_HtmlEncode($this->no_spp->CurrentValue);
			$this->no_spp->PlaceHolder = ew_RemoveHtml($this->no_spp->FldCaption());

			// tgl_spp
			$this->tgl_spp->EditAttrs["class"] = "form-control";
			$this->tgl_spp->EditCustomAttributes = "";
			$this->tgl_spp->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_spp->CurrentValue, 8));
			$this->tgl_spp->PlaceHolder = ew_RemoveHtml($this->tgl_spp->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// Add refer script
			// detail_jenis_spp

			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";

			// id_jenis_spp
			$this->id_jenis_spp->LinkCustomAttributes = "";
			$this->id_jenis_spp->HrefValue = "";

			// status_spp
			$this->status_spp->LinkCustomAttributes = "";
			$this->status_spp->HrefValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";

			// tgl_spp
			$this->tgl_spp->LinkCustomAttributes = "";
			$this->tgl_spp->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
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
		if (!ew_CheckInteger($this->detail_jenis_spp->FormValue)) {
			ew_AddMessage($gsFormError, $this->detail_jenis_spp->FldErrMsg());
		}
		if (!ew_CheckInteger($this->id_jenis_spp->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_jenis_spp->FldErrMsg());
		}
		if (!ew_CheckInteger($this->status_spp->FormValue)) {
			ew_AddMessage($gsFormError, $this->status_spp->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_spp->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_spp->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("t_spp_detail", $DetailTblVar) && $GLOBALS["t_spp_detail"]->DetailAdd) {
			if (!isset($GLOBALS["t_spp_detail_grid"])) $GLOBALS["t_spp_detail_grid"] = new ct_spp_detail_grid(); // get detail page object
			$GLOBALS["t_spp_detail_grid"]->ValidateGridForm();
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

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// detail_jenis_spp
		$this->detail_jenis_spp->SetDbValueDef($rsnew, $this->detail_jenis_spp->CurrentValue, NULL, FALSE);

		// id_jenis_spp
		$this->id_jenis_spp->SetDbValueDef($rsnew, $this->id_jenis_spp->CurrentValue, NULL, FALSE);

		// status_spp
		$this->status_spp->SetDbValueDef($rsnew, $this->status_spp->CurrentValue, NULL, FALSE);

		// no_spp
		$this->no_spp->SetDbValueDef($rsnew, $this->no_spp->CurrentValue, NULL, FALSE);

		// tgl_spp
		$this->tgl_spp->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_spp->CurrentValue, 0), NULL, FALSE);

		// keterangan
		$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, NULL, FALSE);

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("t_spp_detail", $DetailTblVar) && $GLOBALS["t_spp_detail"]->DetailAdd) {
				$GLOBALS["t_spp_detail"]->id_spp->setSessionValue($this->id->CurrentValue); // Set master key
				$GLOBALS["t_spp_detail"]->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->CurrentValue); // Set master key
				$GLOBALS["t_spp_detail"]->id_jenis_spp->setSessionValue($this->id_jenis_spp->CurrentValue); // Set master key
				$GLOBALS["t_spp_detail"]->no_spp->setSessionValue($this->no_spp->CurrentValue); // Set master key
				if (!isset($GLOBALS["t_spp_detail_grid"])) $GLOBALS["t_spp_detail_grid"] = new ct_spp_detail_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "t_spp_detail"); // Load user level of detail table
				$AddRow = $GLOBALS["t_spp_detail_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["t_spp_detail"]->no_spp->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
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
			if ($sMasterTblVar == "l_jenis_detail_spp") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->detail_jenis_spp->setQueryStringValue($GLOBALS["l_jenis_detail_spp"]->id->QueryStringValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id_jenis"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id_jenis->setQueryStringValue($_GET["fk_id_jenis"]);
					$this->id_jenis_spp->setQueryStringValue($GLOBALS["l_jenis_detail_spp"]->id_jenis->QueryStringValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id_jenis->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "l_jenis_detail_spp") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id->setFormValue($_POST["fk_id"]);
					$this->detail_jenis_spp->setFormValue($GLOBALS["l_jenis_detail_spp"]->id->FormValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id_jenis"] <> "") {
					$GLOBALS["l_jenis_detail_spp"]->id_jenis->setFormValue($_POST["fk_id_jenis"]);
					$this->id_jenis_spp->setFormValue($GLOBALS["l_jenis_detail_spp"]->id_jenis->FormValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["l_jenis_detail_spp"]->id_jenis->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "l_jenis_detail_spp") {
				if ($this->detail_jenis_spp->CurrentValue == "") $this->detail_jenis_spp->setSessionValue("");
				if ($this->id_jenis_spp->CurrentValue == "") $this->id_jenis_spp->setSessionValue("");
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
			if (in_array("t_spp_detail", $DetailTblVar)) {
				if (!isset($GLOBALS["t_spp_detail_grid"]))
					$GLOBALS["t_spp_detail_grid"] = new ct_spp_detail_grid;
				if ($GLOBALS["t_spp_detail_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["t_spp_detail_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["t_spp_detail_grid"]->CurrentMode = "add";
					$GLOBALS["t_spp_detail_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["t_spp_detail_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["t_spp_detail_grid"]->setStartRecordNumber(1);
					$GLOBALS["t_spp_detail_grid"]->id_spp->FldIsDetailKey = TRUE;
					$GLOBALS["t_spp_detail_grid"]->id_spp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["t_spp_detail_grid"]->id_spp->setSessionValue($GLOBALS["t_spp_detail_grid"]->id_spp->CurrentValue);
					$GLOBALS["t_spp_detail_grid"]->detail_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["t_spp_detail_grid"]->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->CurrentValue;
					$GLOBALS["t_spp_detail_grid"]->detail_jenis_spp->setSessionValue($GLOBALS["t_spp_detail_grid"]->detail_jenis_spp->CurrentValue);
					$GLOBALS["t_spp_detail_grid"]->id_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["t_spp_detail_grid"]->id_jenis_spp->CurrentValue = $this->id_jenis_spp->CurrentValue;
					$GLOBALS["t_spp_detail_grid"]->id_jenis_spp->setSessionValue($GLOBALS["t_spp_detail_grid"]->id_jenis_spp->CurrentValue);
					$GLOBALS["t_spp_detail_grid"]->no_spp->FldIsDetailKey = TRUE;
					$GLOBALS["t_spp_detail_grid"]->no_spp->CurrentValue = $this->no_spp->CurrentValue;
					$GLOBALS["t_spp_detail_grid"]->no_spp->setSessionValue($GLOBALS["t_spp_detail_grid"]->no_spp->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_ls_gaji_tunjanganlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($vw_spp_ls_gaji_tunjangan_add)) $vw_spp_ls_gaji_tunjangan_add = new cvw_spp_ls_gaji_tunjangan_add();

// Page init
$vw_spp_ls_gaji_tunjangan_add->Page_Init();

// Page main
$vw_spp_ls_gaji_tunjangan_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_ls_gaji_tunjangan_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_spp_ls_gaji_tunjanganadd = new ew_Form("fvw_spp_ls_gaji_tunjanganadd", "add");

// Validate form
fvw_spp_ls_gaji_tunjanganadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_detail_jenis_spp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_gaji_tunjangan->detail_jenis_spp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_id_jenis_spp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_gaji_tunjangan->id_jenis_spp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_spp");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_gaji_tunjangan->status_spp->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_spp");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_ls_gaji_tunjangan->tgl_spp->FldErrMsg()) ?>");

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
fvw_spp_ls_gaji_tunjanganadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_ls_gaji_tunjanganadd.ValidateRequired = true;
<?php } else { ?>
fvw_spp_ls_gaji_tunjanganadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_ls_gaji_tunjangan_add->IsModal) { ?>
<?php } ?>
<?php $vw_spp_ls_gaji_tunjangan_add->ShowPageHeader(); ?>
<?php
$vw_spp_ls_gaji_tunjangan_add->ShowMessage();
?>
<form name="fvw_spp_ls_gaji_tunjanganadd" id="fvw_spp_ls_gaji_tunjanganadd" class="<?php echo $vw_spp_ls_gaji_tunjangan_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_ls_gaji_tunjangan_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_ls_gaji_tunjangan">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_spp_ls_gaji_tunjangan_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->getCurrentMasterTable() == "l_jenis_detail_spp") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="l_jenis_detail_spp">
<input type="hidden" name="fk_id" value="<?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->getSessionValue() ?>">
<input type="hidden" name="fk_id_jenis" value="<?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($vw_spp_ls_gaji_tunjangan->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<div id="r_detail_jenis_spp" class="form-group">
		<label id="elh_vw_spp_ls_gaji_tunjangan_detail_jenis_spp" for="x_detail_jenis_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->CellAttributes() ?>>
<?php if ($vw_spp_ls_gaji_tunjangan->detail_jenis_spp->getSessionValue() <> "") { ?>
<span id="el_vw_spp_ls_gaji_tunjangan_detail_jenis_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_detail_jenis_spp" name="x_detail_jenis_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->detail_jenis_spp->CurrentValue) ?>">
<?php } else { ?>
<span id="el_vw_spp_ls_gaji_tunjangan_detail_jenis_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_detail_jenis_spp" name="x_detail_jenis_spp" id="x_detail_jenis_spp" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->detail_jenis_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $vw_spp_ls_gaji_tunjangan->detail_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->id_jenis_spp->Visible) { // id_jenis_spp ?>
	<div id="r_id_jenis_spp" class="form-group">
		<label id="elh_vw_spp_ls_gaji_tunjangan_id_jenis_spp" for="x_id_jenis_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->CellAttributes() ?>>
<?php if ($vw_spp_ls_gaji_tunjangan->id_jenis_spp->getSessionValue() <> "") { ?>
<span id="el_vw_spp_ls_gaji_tunjangan_id_jenis_spp">
<span<?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_id_jenis_spp" name="x_id_jenis_spp" value="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->id_jenis_spp->CurrentValue) ?>">
<?php } else { ?>
<span id="el_vw_spp_ls_gaji_tunjangan_id_jenis_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_id_jenis_spp" name="x_id_jenis_spp" id="x_id_jenis_spp" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->id_jenis_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $vw_spp_ls_gaji_tunjangan->id_jenis_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->status_spp->Visible) { // status_spp ?>
	<div id="r_status_spp" class="form-group">
		<label id="elh_vw_spp_ls_gaji_tunjangan_status_spp" for="x_status_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_tunjangan->status_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_status_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_status_spp" name="x_status_spp" id="x_status_spp" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->status_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->EditAttributes() ?>>
</span>
<?php echo $vw_spp_ls_gaji_tunjangan->status_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->no_spp->Visible) { // no_spp ?>
	<div id="r_no_spp" class="form-group">
		<label id="elh_vw_spp_ls_gaji_tunjangan_no_spp" for="x_no_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_tunjangan->no_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_no_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_no_spp" name="x_no_spp" id="x_no_spp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->no_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->EditAttributes() ?>>
</span>
<?php echo $vw_spp_ls_gaji_tunjangan->no_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->tgl_spp->Visible) { // tgl_spp ?>
	<div id="r_tgl_spp" class="form-group">
		<label id="elh_vw_spp_ls_gaji_tunjangan_tgl_spp" for="x_tgl_spp" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_tgl_spp">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_tgl_spp" name="x_tgl_spp" id="x_tgl_spp" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->tgl_spp->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->EditAttributes() ?>>
</span>
<?php echo $vw_spp_ls_gaji_tunjangan->tgl_spp->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_ls_gaji_tunjangan->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_vw_spp_ls_gaji_tunjangan_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_ls_gaji_tunjangan->keterangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_tunjangan_keterangan">
<input type="text" data-table="vw_spp_ls_gaji_tunjangan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_spp_ls_gaji_tunjangan->keterangan->getPlaceHolder()) ?>" value="<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditValue ?>"<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->EditAttributes() ?>>
</span>
<?php echo $vw_spp_ls_gaji_tunjangan->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("t_spp_detail", explode(",", $vw_spp_ls_gaji_tunjangan->getCurrentDetailTable())) && $t_spp_detail->DetailAdd) {
?>
<?php if ($vw_spp_ls_gaji_tunjangan->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("t_spp_detail", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "t_spp_detailgrid.php" ?>
<?php } ?>
<?php if (!$vw_spp_ls_gaji_tunjangan_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spp_ls_gaji_tunjangan_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spp_ls_gaji_tunjanganadd.Init();
</script>
<?php
$vw_spp_ls_gaji_tunjangan_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_ls_gaji_tunjangan_add->Page_Terminate();
?>
