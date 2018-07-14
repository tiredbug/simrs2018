<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_ruanginfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_ruang_edit = NULL; // Initialize page object first

class cm_ruang_edit extends cm_ruang {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_ruang';

	// Page object name
	var $PageObjName = 'm_ruang_edit';

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

		// Table object (m_ruang)
		if (!isset($GLOBALS["m_ruang"]) || get_class($GLOBALS["m_ruang"]) == "cm_ruang") {
			$GLOBALS["m_ruang"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_ruang"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_ruang', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_ruanglist.php"));
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
		$this->no->SetVisibility();
		$this->no->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nama->SetVisibility();
		$this->kelas->SetVisibility();
		$this->ruang->SetVisibility();
		$this->jumlah_tt->SetVisibility();
		$this->ket_ruang->SetVisibility();
		$this->fasilitas->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->kepala_ruangan->SetVisibility();
		$this->nip_kepala_ruangan->SetVisibility();
		$this->group_id->SetVisibility();

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
		global $EW_EXPORT, $m_ruang;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_ruang);
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
		if (@$_GET["no"] <> "") {
			$this->no->setQueryStringValue($_GET["no"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->no->CurrentValue == "") {
			$this->Page_Terminate("m_ruanglist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("m_ruanglist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "m_ruanglist.php")
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
		if (!$this->no->FldIsDetailKey)
			$this->no->setFormValue($objForm->GetValue("x_no"));
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->kelas->FldIsDetailKey) {
			$this->kelas->setFormValue($objForm->GetValue("x_kelas"));
		}
		if (!$this->ruang->FldIsDetailKey) {
			$this->ruang->setFormValue($objForm->GetValue("x_ruang"));
		}
		if (!$this->jumlah_tt->FldIsDetailKey) {
			$this->jumlah_tt->setFormValue($objForm->GetValue("x_jumlah_tt"));
		}
		if (!$this->ket_ruang->FldIsDetailKey) {
			$this->ket_ruang->setFormValue($objForm->GetValue("x_ket_ruang"));
		}
		if (!$this->fasilitas->FldIsDetailKey) {
			$this->fasilitas->setFormValue($objForm->GetValue("x_fasilitas"));
		}
		if (!$this->keterangan->FldIsDetailKey) {
			$this->keterangan->setFormValue($objForm->GetValue("x_keterangan"));
		}
		if (!$this->kepala_ruangan->FldIsDetailKey) {
			$this->kepala_ruangan->setFormValue($objForm->GetValue("x_kepala_ruangan"));
		}
		if (!$this->nip_kepala_ruangan->FldIsDetailKey) {
			$this->nip_kepala_ruangan->setFormValue($objForm->GetValue("x_nip_kepala_ruangan"));
		}
		if (!$this->group_id->FldIsDetailKey) {
			$this->group_id->setFormValue($objForm->GetValue("x_group_id"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->no->CurrentValue = $this->no->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->kelas->CurrentValue = $this->kelas->FormValue;
		$this->ruang->CurrentValue = $this->ruang->FormValue;
		$this->jumlah_tt->CurrentValue = $this->jumlah_tt->FormValue;
		$this->ket_ruang->CurrentValue = $this->ket_ruang->FormValue;
		$this->fasilitas->CurrentValue = $this->fasilitas->FormValue;
		$this->keterangan->CurrentValue = $this->keterangan->FormValue;
		$this->kepala_ruangan->CurrentValue = $this->kepala_ruangan->FormValue;
		$this->nip_kepala_ruangan->CurrentValue = $this->nip_kepala_ruangan->FormValue;
		$this->group_id->CurrentValue = $this->group_id->FormValue;
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
		$this->no->setDbValue($rs->fields('no'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->ruang->setDbValue($rs->fields('ruang'));
		$this->jumlah_tt->setDbValue($rs->fields('jumlah_tt'));
		$this->ket_ruang->setDbValue($rs->fields('ket_ruang'));
		$this->fasilitas->setDbValue($rs->fields('fasilitas'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->kepala_ruangan->setDbValue($rs->fields('kepala_ruangan'));
		$this->nip_kepala_ruangan->setDbValue($rs->fields('nip_kepala_ruangan'));
		$this->group_id->setDbValue($rs->fields('group_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->no->DbValue = $row['no'];
		$this->nama->DbValue = $row['nama'];
		$this->kelas->DbValue = $row['kelas'];
		$this->ruang->DbValue = $row['ruang'];
		$this->jumlah_tt->DbValue = $row['jumlah_tt'];
		$this->ket_ruang->DbValue = $row['ket_ruang'];
		$this->fasilitas->DbValue = $row['fasilitas'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->kepala_ruangan->DbValue = $row['kepala_ruangan'];
		$this->nip_kepala_ruangan->DbValue = $row['nip_kepala_ruangan'];
		$this->group_id->DbValue = $row['group_id'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// no
		// nama
		// kelas
		// ruang
		// jumlah_tt
		// ket_ruang
		// fasilitas
		// keterangan
		// kepala_ruangan
		// nip_kepala_ruangan
		// group_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// no
		$this->no->ViewValue = $this->no->CurrentValue;
		$this->no->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// ruang
		$this->ruang->ViewValue = $this->ruang->CurrentValue;
		$this->ruang->ViewCustomAttributes = "";

		// jumlah_tt
		$this->jumlah_tt->ViewValue = $this->jumlah_tt->CurrentValue;
		$this->jumlah_tt->ViewCustomAttributes = "";

		// ket_ruang
		$this->ket_ruang->ViewValue = $this->ket_ruang->CurrentValue;
		$this->ket_ruang->ViewCustomAttributes = "";

		// fasilitas
		$this->fasilitas->ViewValue = $this->fasilitas->CurrentValue;
		$this->fasilitas->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// kepala_ruangan
		$this->kepala_ruangan->ViewValue = $this->kepala_ruangan->CurrentValue;
		$this->kepala_ruangan->ViewCustomAttributes = "";

		// nip_kepala_ruangan
		$this->nip_kepala_ruangan->ViewValue = $this->nip_kepala_ruangan->CurrentValue;
		$this->nip_kepala_ruangan->ViewCustomAttributes = "";

		// group_id
		$this->group_id->ViewValue = $this->group_id->CurrentValue;
		$this->group_id->ViewCustomAttributes = "";

			// no
			$this->no->LinkCustomAttributes = "";
			$this->no->HrefValue = "";
			$this->no->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";
			$this->kelas->TooltipValue = "";

			// ruang
			$this->ruang->LinkCustomAttributes = "";
			$this->ruang->HrefValue = "";
			$this->ruang->TooltipValue = "";

			// jumlah_tt
			$this->jumlah_tt->LinkCustomAttributes = "";
			$this->jumlah_tt->HrefValue = "";
			$this->jumlah_tt->TooltipValue = "";

			// ket_ruang
			$this->ket_ruang->LinkCustomAttributes = "";
			$this->ket_ruang->HrefValue = "";
			$this->ket_ruang->TooltipValue = "";

			// fasilitas
			$this->fasilitas->LinkCustomAttributes = "";
			$this->fasilitas->HrefValue = "";
			$this->fasilitas->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// kepala_ruangan
			$this->kepala_ruangan->LinkCustomAttributes = "";
			$this->kepala_ruangan->HrefValue = "";
			$this->kepala_ruangan->TooltipValue = "";

			// nip_kepala_ruangan
			$this->nip_kepala_ruangan->LinkCustomAttributes = "";
			$this->nip_kepala_ruangan->HrefValue = "";
			$this->nip_kepala_ruangan->TooltipValue = "";

			// group_id
			$this->group_id->LinkCustomAttributes = "";
			$this->group_id->HrefValue = "";
			$this->group_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// no
			$this->no->EditAttrs["class"] = "form-control";
			$this->no->EditCustomAttributes = "";
			$this->no->EditValue = $this->no->CurrentValue;
			$this->no->ViewCustomAttributes = "";

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// kelas
			$this->kelas->EditAttrs["class"] = "form-control";
			$this->kelas->EditCustomAttributes = "";
			$this->kelas->EditValue = ew_HtmlEncode($this->kelas->CurrentValue);
			$this->kelas->PlaceHolder = ew_RemoveHtml($this->kelas->FldCaption());

			// ruang
			$this->ruang->EditAttrs["class"] = "form-control";
			$this->ruang->EditCustomAttributes = "";
			$this->ruang->EditValue = ew_HtmlEncode($this->ruang->CurrentValue);
			$this->ruang->PlaceHolder = ew_RemoveHtml($this->ruang->FldCaption());

			// jumlah_tt
			$this->jumlah_tt->EditAttrs["class"] = "form-control";
			$this->jumlah_tt->EditCustomAttributes = "";
			$this->jumlah_tt->EditValue = ew_HtmlEncode($this->jumlah_tt->CurrentValue);
			$this->jumlah_tt->PlaceHolder = ew_RemoveHtml($this->jumlah_tt->FldCaption());

			// ket_ruang
			$this->ket_ruang->EditAttrs["class"] = "form-control";
			$this->ket_ruang->EditCustomAttributes = "";
			$this->ket_ruang->EditValue = ew_HtmlEncode($this->ket_ruang->CurrentValue);
			$this->ket_ruang->PlaceHolder = ew_RemoveHtml($this->ket_ruang->FldCaption());

			// fasilitas
			$this->fasilitas->EditAttrs["class"] = "form-control";
			$this->fasilitas->EditCustomAttributes = "";
			$this->fasilitas->EditValue = ew_HtmlEncode($this->fasilitas->CurrentValue);
			$this->fasilitas->PlaceHolder = ew_RemoveHtml($this->fasilitas->FldCaption());

			// keterangan
			$this->keterangan->EditAttrs["class"] = "form-control";
			$this->keterangan->EditCustomAttributes = "";
			$this->keterangan->EditValue = ew_HtmlEncode($this->keterangan->CurrentValue);
			$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

			// kepala_ruangan
			$this->kepala_ruangan->EditAttrs["class"] = "form-control";
			$this->kepala_ruangan->EditCustomAttributes = "";
			$this->kepala_ruangan->EditValue = ew_HtmlEncode($this->kepala_ruangan->CurrentValue);
			$this->kepala_ruangan->PlaceHolder = ew_RemoveHtml($this->kepala_ruangan->FldCaption());

			// nip_kepala_ruangan
			$this->nip_kepala_ruangan->EditAttrs["class"] = "form-control";
			$this->nip_kepala_ruangan->EditCustomAttributes = "";
			$this->nip_kepala_ruangan->EditValue = ew_HtmlEncode($this->nip_kepala_ruangan->CurrentValue);
			$this->nip_kepala_ruangan->PlaceHolder = ew_RemoveHtml($this->nip_kepala_ruangan->FldCaption());

			// group_id
			$this->group_id->EditAttrs["class"] = "form-control";
			$this->group_id->EditCustomAttributes = "";
			$this->group_id->EditValue = ew_HtmlEncode($this->group_id->CurrentValue);
			$this->group_id->PlaceHolder = ew_RemoveHtml($this->group_id->FldCaption());

			// Edit refer script
			// no

			$this->no->LinkCustomAttributes = "";
			$this->no->HrefValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// kelas
			$this->kelas->LinkCustomAttributes = "";
			$this->kelas->HrefValue = "";

			// ruang
			$this->ruang->LinkCustomAttributes = "";
			$this->ruang->HrefValue = "";

			// jumlah_tt
			$this->jumlah_tt->LinkCustomAttributes = "";
			$this->jumlah_tt->HrefValue = "";

			// ket_ruang
			$this->ket_ruang->LinkCustomAttributes = "";
			$this->ket_ruang->HrefValue = "";

			// fasilitas
			$this->fasilitas->LinkCustomAttributes = "";
			$this->fasilitas->HrefValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";

			// kepala_ruangan
			$this->kepala_ruangan->LinkCustomAttributes = "";
			$this->kepala_ruangan->HrefValue = "";

			// nip_kepala_ruangan
			$this->nip_kepala_ruangan->LinkCustomAttributes = "";
			$this->nip_kepala_ruangan->HrefValue = "";

			// group_id
			$this->group_id->LinkCustomAttributes = "";
			$this->group_id->HrefValue = "";
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
		if (!$this->nama->FldIsDetailKey && !is_null($this->nama->FormValue) && $this->nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama->FldCaption(), $this->nama->ReqErrMsg));
		}
		if (!$this->kelas->FldIsDetailKey && !is_null($this->kelas->FormValue) && $this->kelas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kelas->FldCaption(), $this->kelas->ReqErrMsg));
		}
		if (!$this->ruang->FldIsDetailKey && !is_null($this->ruang->FormValue) && $this->ruang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ruang->FldCaption(), $this->ruang->ReqErrMsg));
		}
		if (!$this->jumlah_tt->FldIsDetailKey && !is_null($this->jumlah_tt->FormValue) && $this->jumlah_tt->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jumlah_tt->FldCaption(), $this->jumlah_tt->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->jumlah_tt->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_tt->FldErrMsg());
		}
		if (!$this->ket_ruang->FldIsDetailKey && !is_null($this->ket_ruang->FormValue) && $this->ket_ruang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ket_ruang->FldCaption(), $this->ket_ruang->ReqErrMsg));
		}
		if (!$this->fasilitas->FldIsDetailKey && !is_null($this->fasilitas->FormValue) && $this->fasilitas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->fasilitas->FldCaption(), $this->fasilitas->ReqErrMsg));
		}
		if (!$this->keterangan->FldIsDetailKey && !is_null($this->keterangan->FormValue) && $this->keterangan->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->keterangan->FldCaption(), $this->keterangan->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->group_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->group_id->FldErrMsg());
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

			// nama
			$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

			// kelas
			$this->kelas->SetDbValueDef($rsnew, $this->kelas->CurrentValue, "", $this->kelas->ReadOnly);

			// ruang
			$this->ruang->SetDbValueDef($rsnew, $this->ruang->CurrentValue, "", $this->ruang->ReadOnly);

			// jumlah_tt
			$this->jumlah_tt->SetDbValueDef($rsnew, $this->jumlah_tt->CurrentValue, 0, $this->jumlah_tt->ReadOnly);

			// ket_ruang
			$this->ket_ruang->SetDbValueDef($rsnew, $this->ket_ruang->CurrentValue, "", $this->ket_ruang->ReadOnly);

			// fasilitas
			$this->fasilitas->SetDbValueDef($rsnew, $this->fasilitas->CurrentValue, "", $this->fasilitas->ReadOnly);

			// keterangan
			$this->keterangan->SetDbValueDef($rsnew, $this->keterangan->CurrentValue, "", $this->keterangan->ReadOnly);

			// kepala_ruangan
			$this->kepala_ruangan->SetDbValueDef($rsnew, $this->kepala_ruangan->CurrentValue, NULL, $this->kepala_ruangan->ReadOnly);

			// nip_kepala_ruangan
			$this->nip_kepala_ruangan->SetDbValueDef($rsnew, $this->nip_kepala_ruangan->CurrentValue, NULL, $this->nip_kepala_ruangan->ReadOnly);

			// group_id
			$this->group_id->SetDbValueDef($rsnew, $this->group_id->CurrentValue, NULL, $this->group_id->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_ruanglist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_ruang_edit)) $m_ruang_edit = new cm_ruang_edit();

// Page init
$m_ruang_edit->Page_Init();

// Page main
$m_ruang_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_ruang_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fm_ruangedit = new ew_Form("fm_ruangedit", "edit");

// Validate form
fm_ruangedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_ruang->nama->FldCaption(), $m_ruang->nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kelas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_ruang->kelas->FldCaption(), $m_ruang->kelas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ruang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_ruang->ruang->FldCaption(), $m_ruang->ruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_tt");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_ruang->jumlah_tt->FldCaption(), $m_ruang->jumlah_tt->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_tt");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_ruang->jumlah_tt->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ket_ruang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_ruang->ket_ruang->FldCaption(), $m_ruang->ket_ruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fasilitas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_ruang->fasilitas->FldCaption(), $m_ruang->fasilitas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_keterangan");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_ruang->keterangan->FldCaption(), $m_ruang->keterangan->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_group_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_ruang->group_id->FldErrMsg()) ?>");

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
fm_ruangedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_ruangedit.ValidateRequired = true;
<?php } else { ?>
fm_ruangedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_ruang_edit->IsModal) { ?>
<?php } ?>
<?php $m_ruang_edit->ShowPageHeader(); ?>
<?php
$m_ruang_edit->ShowMessage();
?>
<form name="fm_ruangedit" id="fm_ruangedit" class="<?php echo $m_ruang_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_ruang_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_ruang_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_ruang">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($m_ruang_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_ruang->no->Visible) { // no ?>
	<div id="r_no" class="form-group">
		<label id="elh_m_ruang_no" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->no->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->no->CellAttributes() ?>>
<span id="el_m_ruang_no">
<span<?php echo $m_ruang->no->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_ruang->no->EditValue ?></p></span>
</span>
<input type="hidden" data-table="m_ruang" data-field="x_no" name="x_no" id="x_no" value="<?php echo ew_HtmlEncode($m_ruang->no->CurrentValue) ?>">
<?php echo $m_ruang->no->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_m_ruang_nama" for="x_nama" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->nama->CellAttributes() ?>>
<span id="el_m_ruang_nama">
<input type="text" data-table="m_ruang" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($m_ruang->nama->getPlaceHolder()) ?>" value="<?php echo $m_ruang->nama->EditValue ?>"<?php echo $m_ruang->nama->EditAttributes() ?>>
</span>
<?php echo $m_ruang->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->kelas->Visible) { // kelas ?>
	<div id="r_kelas" class="form-group">
		<label id="elh_m_ruang_kelas" for="x_kelas" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->kelas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->kelas->CellAttributes() ?>>
<span id="el_m_ruang_kelas">
<input type="text" data-table="m_ruang" data-field="x_kelas" name="x_kelas" id="x_kelas" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($m_ruang->kelas->getPlaceHolder()) ?>" value="<?php echo $m_ruang->kelas->EditValue ?>"<?php echo $m_ruang->kelas->EditAttributes() ?>>
</span>
<?php echo $m_ruang->kelas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->ruang->Visible) { // ruang ?>
	<div id="r_ruang" class="form-group">
		<label id="elh_m_ruang_ruang" for="x_ruang" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->ruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->ruang->CellAttributes() ?>>
<span id="el_m_ruang_ruang">
<input type="text" data-table="m_ruang" data-field="x_ruang" name="x_ruang" id="x_ruang" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($m_ruang->ruang->getPlaceHolder()) ?>" value="<?php echo $m_ruang->ruang->EditValue ?>"<?php echo $m_ruang->ruang->EditAttributes() ?>>
</span>
<?php echo $m_ruang->ruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->jumlah_tt->Visible) { // jumlah_tt ?>
	<div id="r_jumlah_tt" class="form-group">
		<label id="elh_m_ruang_jumlah_tt" for="x_jumlah_tt" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->jumlah_tt->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->jumlah_tt->CellAttributes() ?>>
<span id="el_m_ruang_jumlah_tt">
<input type="text" data-table="m_ruang" data-field="x_jumlah_tt" name="x_jumlah_tt" id="x_jumlah_tt" size="30" placeholder="<?php echo ew_HtmlEncode($m_ruang->jumlah_tt->getPlaceHolder()) ?>" value="<?php echo $m_ruang->jumlah_tt->EditValue ?>"<?php echo $m_ruang->jumlah_tt->EditAttributes() ?>>
</span>
<?php echo $m_ruang->jumlah_tt->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->ket_ruang->Visible) { // ket_ruang ?>
	<div id="r_ket_ruang" class="form-group">
		<label id="elh_m_ruang_ket_ruang" for="x_ket_ruang" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->ket_ruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->ket_ruang->CellAttributes() ?>>
<span id="el_m_ruang_ket_ruang">
<input type="text" data-table="m_ruang" data-field="x_ket_ruang" name="x_ket_ruang" id="x_ket_ruang" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($m_ruang->ket_ruang->getPlaceHolder()) ?>" value="<?php echo $m_ruang->ket_ruang->EditValue ?>"<?php echo $m_ruang->ket_ruang->EditAttributes() ?>>
</span>
<?php echo $m_ruang->ket_ruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->fasilitas->Visible) { // fasilitas ?>
	<div id="r_fasilitas" class="form-group">
		<label id="elh_m_ruang_fasilitas" for="x_fasilitas" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->fasilitas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->fasilitas->CellAttributes() ?>>
<span id="el_m_ruang_fasilitas">
<textarea data-table="m_ruang" data-field="x_fasilitas" name="x_fasilitas" id="x_fasilitas" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($m_ruang->fasilitas->getPlaceHolder()) ?>"<?php echo $m_ruang->fasilitas->EditAttributes() ?>><?php echo $m_ruang->fasilitas->EditValue ?></textarea>
</span>
<?php echo $m_ruang->fasilitas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->keterangan->Visible) { // keterangan ?>
	<div id="r_keterangan" class="form-group">
		<label id="elh_m_ruang_keterangan" for="x_keterangan" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->keterangan->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->keterangan->CellAttributes() ?>>
<span id="el_m_ruang_keterangan">
<textarea data-table="m_ruang" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($m_ruang->keterangan->getPlaceHolder()) ?>"<?php echo $m_ruang->keterangan->EditAttributes() ?>><?php echo $m_ruang->keterangan->EditValue ?></textarea>
</span>
<?php echo $m_ruang->keterangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->kepala_ruangan->Visible) { // kepala_ruangan ?>
	<div id="r_kepala_ruangan" class="form-group">
		<label id="elh_m_ruang_kepala_ruangan" for="x_kepala_ruangan" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->kepala_ruangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->kepala_ruangan->CellAttributes() ?>>
<span id="el_m_ruang_kepala_ruangan">
<input type="text" data-table="m_ruang" data-field="x_kepala_ruangan" name="x_kepala_ruangan" id="x_kepala_ruangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_ruang->kepala_ruangan->getPlaceHolder()) ?>" value="<?php echo $m_ruang->kepala_ruangan->EditValue ?>"<?php echo $m_ruang->kepala_ruangan->EditAttributes() ?>>
</span>
<?php echo $m_ruang->kepala_ruangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->nip_kepala_ruangan->Visible) { // nip_kepala_ruangan ?>
	<div id="r_nip_kepala_ruangan" class="form-group">
		<label id="elh_m_ruang_nip_kepala_ruangan" for="x_nip_kepala_ruangan" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->nip_kepala_ruangan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->nip_kepala_ruangan->CellAttributes() ?>>
<span id="el_m_ruang_nip_kepala_ruangan">
<input type="text" data-table="m_ruang" data-field="x_nip_kepala_ruangan" name="x_nip_kepala_ruangan" id="x_nip_kepala_ruangan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_ruang->nip_kepala_ruangan->getPlaceHolder()) ?>" value="<?php echo $m_ruang->nip_kepala_ruangan->EditValue ?>"<?php echo $m_ruang->nip_kepala_ruangan->EditAttributes() ?>>
</span>
<?php echo $m_ruang->nip_kepala_ruangan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_ruang->group_id->Visible) { // group_id ?>
	<div id="r_group_id" class="form-group">
		<label id="elh_m_ruang_group_id" for="x_group_id" class="col-sm-2 control-label ewLabel"><?php echo $m_ruang->group_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_ruang->group_id->CellAttributes() ?>>
<span id="el_m_ruang_group_id">
<input type="text" data-table="m_ruang" data-field="x_group_id" name="x_group_id" id="x_group_id" size="30" placeholder="<?php echo ew_HtmlEncode($m_ruang->group_id->getPlaceHolder()) ?>" value="<?php echo $m_ruang->group_id->EditValue ?>"<?php echo $m_ruang->group_id->EditAttributes() ?>>
</span>
<?php echo $m_ruang->group_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_ruang_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_ruang_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_ruangedit.Init();
</script>
<?php
$m_ruang_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_ruang_edit->Page_Terminate();
?>
