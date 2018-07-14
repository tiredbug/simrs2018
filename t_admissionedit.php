<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_admissioninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_admission_edit = NULL; // Initialize page object first

class ct_admission_edit extends ct_admission {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_admission';

	// Page object name
	var $PageObjName = 't_admission_edit';

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

		// Table object (t_admission)
		if (!isset($GLOBALS["t_admission"]) || get_class($GLOBALS["t_admission"]) == "ct_admission") {
			$GLOBALS["t_admission"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_admission"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_admission', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_admissionlist.php"));
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
		if (@$_POST["customexport"] == "") {

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		global $EW_EXPORT, $t_admission;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_admission);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
	if ($this->CustomExport <> "") { // Save temp images array for custom export
		if (is_array($gTmpImages))
			$_SESSION[EW_SESSION_TEMP_IMAGES] = $gTmpImages;
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
		if (@$_GET["id_admission"] <> "") {
			$this->id_admission->setQueryStringValue($_GET["id_admission"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id_admission->CurrentValue == "") {
			$this->Page_Terminate("t_admissionlist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("t_admissionlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "t_admissionlist.php")
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
		if (!$this->nomr->FldIsDetailKey) {
			$this->nomr->setFormValue($objForm->GetValue("x_nomr"));
		}
		if (!$this->ket_nama->FldIsDetailKey) {
			$this->ket_nama->setFormValue($objForm->GetValue("x_ket_nama"));
		}
		if (!$this->ket_tgllahir->FldIsDetailKey) {
			$this->ket_tgllahir->setFormValue($objForm->GetValue("x_ket_tgllahir"));
			$this->ket_tgllahir->CurrentValue = ew_UnFormatDateTime($this->ket_tgllahir->CurrentValue, 0);
		}
		if (!$this->ket_alamat->FldIsDetailKey) {
			$this->ket_alamat->setFormValue($objForm->GetValue("x_ket_alamat"));
		}
		if (!$this->dokterpengirim->FldIsDetailKey) {
			$this->dokterpengirim->setFormValue($objForm->GetValue("x_dokterpengirim"));
		}
		if (!$this->statusbayar->FldIsDetailKey) {
			$this->statusbayar->setFormValue($objForm->GetValue("x_statusbayar"));
		}
		if (!$this->kirimdari->FldIsDetailKey) {
			$this->kirimdari->setFormValue($objForm->GetValue("x_kirimdari"));
		}
		if (!$this->keluargadekat->FldIsDetailKey) {
			$this->keluargadekat->setFormValue($objForm->GetValue("x_keluargadekat"));
		}
		if (!$this->panggungjawab->FldIsDetailKey) {
			$this->panggungjawab->setFormValue($objForm->GetValue("x_panggungjawab"));
		}
		if (!$this->masukrs->FldIsDetailKey) {
			$this->masukrs->setFormValue($objForm->GetValue("x_masukrs"));
			$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 11);
		}
		if (!$this->noruang->FldIsDetailKey) {
			$this->noruang->setFormValue($objForm->GetValue("x_noruang"));
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey) {
			$this->tempat_tidur_id->setFormValue($objForm->GetValue("x_tempat_tidur_id"));
		}
		if (!$this->nott->FldIsDetailKey) {
			$this->nott->setFormValue($objForm->GetValue("x_nott"));
		}
		if (!$this->icd_masuk->FldIsDetailKey) {
			$this->icd_masuk->setFormValue($objForm->GetValue("x_icd_masuk"));
		}
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->kd_rujuk->FldIsDetailKey) {
			$this->kd_rujuk->setFormValue($objForm->GetValue("x_kd_rujuk"));
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey) {
			$this->dokter_penanggungjawab->setFormValue($objForm->GetValue("x_dokter_penanggungjawab"));
		}
		if (!$this->KELASPERAWATAN_ID->FldIsDetailKey) {
			$this->KELASPERAWATAN_ID->setFormValue($objForm->GetValue("x_KELASPERAWATAN_ID"));
		}
		if (!$this->ket_jeniskelamin->FldIsDetailKey) {
			$this->ket_jeniskelamin->setFormValue($objForm->GetValue("x_ket_jeniskelamin"));
		}
		if (!$this->ket_title->FldIsDetailKey) {
			$this->ket_title->setFormValue($objForm->GetValue("x_ket_title"));
		}
		if (!$this->id_admission->FldIsDetailKey)
			$this->id_admission->setFormValue($objForm->GetValue("x_id_admission"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id_admission->CurrentValue = $this->id_admission->FormValue;
		$this->nomr->CurrentValue = $this->nomr->FormValue;
		$this->ket_nama->CurrentValue = $this->ket_nama->FormValue;
		$this->ket_tgllahir->CurrentValue = $this->ket_tgllahir->FormValue;
		$this->ket_tgllahir->CurrentValue = ew_UnFormatDateTime($this->ket_tgllahir->CurrentValue, 0);
		$this->ket_alamat->CurrentValue = $this->ket_alamat->FormValue;
		$this->dokterpengirim->CurrentValue = $this->dokterpengirim->FormValue;
		$this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
		$this->kirimdari->CurrentValue = $this->kirimdari->FormValue;
		$this->keluargadekat->CurrentValue = $this->keluargadekat->FormValue;
		$this->panggungjawab->CurrentValue = $this->panggungjawab->FormValue;
		$this->masukrs->CurrentValue = $this->masukrs->FormValue;
		$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 11);
		$this->noruang->CurrentValue = $this->noruang->FormValue;
		$this->tempat_tidur_id->CurrentValue = $this->tempat_tidur_id->FormValue;
		$this->nott->CurrentValue = $this->nott->FormValue;
		$this->icd_masuk->CurrentValue = $this->icd_masuk->FormValue;
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->kd_rujuk->CurrentValue = $this->kd_rujuk->FormValue;
		$this->dokter_penanggungjawab->CurrentValue = $this->dokter_penanggungjawab->FormValue;
		$this->KELASPERAWATAN_ID->CurrentValue = $this->KELASPERAWATAN_ID->FormValue;
		$this->ket_jeniskelamin->CurrentValue = $this->ket_jeniskelamin->FormValue;
		$this->ket_title->CurrentValue = $this->ket_title->FormValue;
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->ket_nama->setDbValue($rs->fields('ket_nama'));
		$this->ket_tgllahir->setDbValue($rs->fields('ket_tgllahir'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->parent_nomr->setDbValue($rs->fields('parent_nomr'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->nott->setDbValue($rs->fields('nott'));
		$this->deposit->setDbValue($rs->fields('deposit'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->icd_masuk->setDbValue($rs->fields('icd_masuk'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->noruang_asal->setDbValue($rs->fields('noruang_asal'));
		$this->nott_asal->setDbValue($rs->fields('nott_asal'));
		$this->tgl_pindah->setDbValue($rs->fields('tgl_pindah'));
		$this->kd_rujuk->setDbValue($rs->fields('kd_rujuk'));
		$this->st_bayar->setDbValue($rs->fields('st_bayar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->perawat->setDbValue($rs->fields('perawat'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->LOS->setDbValue($rs->fields('LOS'));
		$this->TOT_TRF_TIND_DOKTER->setDbValue($rs->fields('TOT_TRF_TIND_DOKTER'));
		$this->TOT_BHP_DOKTER->setDbValue($rs->fields('TOT_BHP_DOKTER'));
		$this->TOT_TRF_PERAWAT->setDbValue($rs->fields('TOT_TRF_PERAWAT'));
		$this->TOT_BHP_PERAWAT->setDbValue($rs->fields('TOT_BHP_PERAWAT'));
		$this->TOT_TRF_DOKTER->setDbValue($rs->fields('TOT_TRF_DOKTER'));
		$this->TOT_BIAYA_RAD->setDbValue($rs->fields('TOT_BIAYA_RAD'));
		$this->TOT_BIAYA_CDRPOLI->setDbValue($rs->fields('TOT_BIAYA_CDRPOLI'));
		$this->TOT_BIAYA_LAB_IGD->setDbValue($rs->fields('TOT_BIAYA_LAB_IGD'));
		$this->TOT_BIAYA_OKSIGEN->setDbValue($rs->fields('TOT_BIAYA_OKSIGEN'));
		$this->TOTAL_BIAYA_OBAT->setDbValue($rs->fields('TOTAL_BIAYA_OBAT'));
		$this->LINK_SET_KELAS->setDbValue($rs->fields('LINK_SET_KELAS'));
		$this->biaya_obat->setDbValue($rs->fields('biaya_obat'));
		$this->biaya_retur_obat->setDbValue($rs->fields('biaya_retur_obat'));
		$this->TOT_BIAYA_GIZI->setDbValue($rs->fields('TOT_BIAYA_GIZI'));
		$this->TOT_BIAYA_TMO->setDbValue($rs->fields('TOT_BIAYA_TMO'));
		$this->TOT_BIAYA_AMBULAN->setDbValue($rs->fields('TOT_BIAYA_AMBULAN'));
		$this->TOT_BIAYA_FISIO->setDbValue($rs->fields('TOT_BIAYA_FISIO'));
		$this->TOT_BIAYA_LAINLAIN->setDbValue($rs->fields('TOT_BIAYA_LAINLAIN'));
		$this->jenisperawatan_id->setDbValue($rs->fields('jenisperawatan_id'));
		$this->status_transaksi->setDbValue($rs->fields('status_transaksi'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
		$this->TOT_BIAYA_AKOMODASI->setDbValue($rs->fields('TOT_BIAYA_AKOMODASI'));
		$this->TOTAL_BIAYA_ASKEP->setDbValue($rs->fields('TOTAL_BIAYA_ASKEP'));
		$this->TOTAL_BIAYA_SIMRS->setDbValue($rs->fields('TOTAL_BIAYA_SIMRS'));
		$this->TOT_PENJ_NMEDIS->setDbValue($rs->fields('TOT_PENJ_NMEDIS'));
		$this->LINK_MASTERDETAIL->setDbValue($rs->fields('LINK_MASTERDETAIL'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->LINK_PELAYANAN_OBAT->setDbValue($rs->fields('LINK_PELAYANAN_OBAT'));
		$this->TOT_TIND_RAJAL->setDbValue($rs->fields('TOT_TIND_RAJAL'));
		$this->TOT_TIND_IGD->setDbValue($rs->fields('TOT_TIND_IGD'));
		$this->tanggal_pengembalian_status->setDbValue($rs->fields('tanggal_pengembalian_status'));
		$this->naik_kelas->setDbValue($rs->fields('naik_kelas'));
		$this->iuran_kelas_lama->setDbValue($rs->fields('iuran_kelas_lama'));
		$this->iuran_kelas_baru->setDbValue($rs->fields('iuran_kelas_baru'));
		$this->ketrangan_naik_kelas->setDbValue($rs->fields('ketrangan_naik_kelas'));
		$this->tgl_pengiriman_ad_klaim->setDbValue($rs->fields('tgl_pengiriman_ad_klaim'));
		$this->diagnosa_keluar->setDbValue($rs->fields('diagnosa_keluar'));
		$this->sep_tglsep->setDbValue($rs->fields('sep_tglsep'));
		$this->sep_tglrujuk->setDbValue($rs->fields('sep_tglrujuk'));
		$this->sep_kodekelasrawat->setDbValue($rs->fields('sep_kodekelasrawat'));
		$this->sep_norujukan->setDbValue($rs->fields('sep_norujukan'));
		$this->sep_kodeppkasal->setDbValue($rs->fields('sep_kodeppkasal'));
		$this->sep_namappkasal->setDbValue($rs->fields('sep_namappkasal'));
		$this->sep_kodeppkpelayanan->setDbValue($rs->fields('sep_kodeppkpelayanan'));
		$this->sep_namappkpelayanan->setDbValue($rs->fields('sep_namappkpelayanan'));
		$this->t_admissioncol->setDbValue($rs->fields('t_admissioncol'));
		$this->sep_jenisperawatan->setDbValue($rs->fields('sep_jenisperawatan'));
		$this->sep_catatan->setDbValue($rs->fields('sep_catatan'));
		$this->sep_kodediagnosaawal->setDbValue($rs->fields('sep_kodediagnosaawal'));
		$this->sep_namadiagnosaawal->setDbValue($rs->fields('sep_namadiagnosaawal'));
		$this->sep_lakalantas->setDbValue($rs->fields('sep_lakalantas'));
		$this->sep_lokasilaka->setDbValue($rs->fields('sep_lokasilaka'));
		$this->sep_user->setDbValue($rs->fields('sep_user'));
		$this->sep_flag_cekpeserta->setDbValue($rs->fields('sep_flag_cekpeserta'));
		$this->sep_flag_generatesep->setDbValue($rs->fields('sep_flag_generatesep'));
		$this->sep_flag_mapingsep->setDbValue($rs->fields('sep_flag_mapingsep'));
		$this->sep_nik->setDbValue($rs->fields('sep_nik'));
		$this->sep_namapeserta->setDbValue($rs->fields('sep_namapeserta'));
		$this->sep_jeniskelamin->setDbValue($rs->fields('sep_jeniskelamin'));
		$this->sep_pisat->setDbValue($rs->fields('sep_pisat'));
		$this->sep_tgllahir->setDbValue($rs->fields('sep_tgllahir'));
		$this->sep_kodejeniskepesertaan->setDbValue($rs->fields('sep_kodejeniskepesertaan'));
		$this->sep_namajeniskepesertaan->setDbValue($rs->fields('sep_namajeniskepesertaan'));
		$this->sep_kodepolitujuan->setDbValue($rs->fields('sep_kodepolitujuan'));
		$this->sep_namapolitujuan->setDbValue($rs->fields('sep_namapolitujuan'));
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->sep_nokabpjs->setDbValue($rs->fields('sep_nokabpjs'));
		$this->counter_cetak_sep->setDbValue($rs->fields('counter_cetak_sep'));
		$this->sep_petugas_hapus_sep->setDbValue($rs->fields('sep_petugas_hapus_sep'));
		$this->sep_petugas_set_tgl_pulang->setDbValue($rs->fields('sep_petugas_set_tgl_pulang'));
		$this->sep_jam_generate_sep->setDbValue($rs->fields('sep_jam_generate_sep'));
		$this->sep_status_peserta->setDbValue($rs->fields('sep_status_peserta'));
		$this->sep_umur_pasien_sekarang->setDbValue($rs->fields('sep_umur_pasien_sekarang'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->status_daftar_ranap->setDbValue($rs->fields('status_daftar_ranap'));
		$this->IBS_SETMARKING->setDbValue($rs->fields('IBS_SETMARKING'));
		$this->IBS_PATOLOGI->setDbValue($rs->fields('IBS_PATOLOGI'));
		$this->IBS_JENISANESTESI->setDbValue($rs->fields('IBS_JENISANESTESI'));
		$this->IBS_NO_OK->setDbValue($rs->fields('IBS_NO_OK'));
		$this->IBS_ASISSTEN->setDbValue($rs->fields('IBS_ASISSTEN'));
		$this->IBS_JAM_ELEFTIF->setDbValue($rs->fields('IBS_JAM_ELEFTIF'));
		$this->IBS_JAM_ELEKTIF_SELESAI->setDbValue($rs->fields('IBS_JAM_ELEKTIF_SELESAI'));
		$this->IBS_JAM_CYTO->setDbValue($rs->fields('IBS_JAM_CYTO'));
		$this->IBS_JAM_CYTO_SELESAI->setDbValue($rs->fields('IBS_JAM_CYTO_SELESAI'));
		$this->IBS_TGL_DFTR_OP->setDbValue($rs->fields('IBS_TGL_DFTR_OP'));
		$this->IBS_TGL_OP->setDbValue($rs->fields('IBS_TGL_OP'));
		$this->grup_ruang_id->setDbValue($rs->fields('grup_ruang_id'));
		$this->status_order_ibs->setDbValue($rs->fields('status_order_ibs'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->ket_nama->DbValue = $row['ket_nama'];
		$this->ket_tgllahir->DbValue = $row['ket_tgllahir'];
		$this->ket_alamat->DbValue = $row['ket_alamat'];
		$this->parent_nomr->DbValue = $row['parent_nomr'];
		$this->dokterpengirim->DbValue = $row['dokterpengirim'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kirimdari->DbValue = $row['kirimdari'];
		$this->keluargadekat->DbValue = $row['keluargadekat'];
		$this->panggungjawab->DbValue = $row['panggungjawab'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->nott->DbValue = $row['nott'];
		$this->deposit->DbValue = $row['deposit'];
		$this->keluarrs->DbValue = $row['keluarrs'];
		$this->icd_masuk->DbValue = $row['icd_masuk'];
		$this->icd_keluar->DbValue = $row['icd_keluar'];
		$this->NIP->DbValue = $row['NIP'];
		$this->noruang_asal->DbValue = $row['noruang_asal'];
		$this->nott_asal->DbValue = $row['nott_asal'];
		$this->tgl_pindah->DbValue = $row['tgl_pindah'];
		$this->kd_rujuk->DbValue = $row['kd_rujuk'];
		$this->st_bayar->DbValue = $row['st_bayar'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->perawat->DbValue = $row['perawat'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->LOS->DbValue = $row['LOS'];
		$this->TOT_TRF_TIND_DOKTER->DbValue = $row['TOT_TRF_TIND_DOKTER'];
		$this->TOT_BHP_DOKTER->DbValue = $row['TOT_BHP_DOKTER'];
		$this->TOT_TRF_PERAWAT->DbValue = $row['TOT_TRF_PERAWAT'];
		$this->TOT_BHP_PERAWAT->DbValue = $row['TOT_BHP_PERAWAT'];
		$this->TOT_TRF_DOKTER->DbValue = $row['TOT_TRF_DOKTER'];
		$this->TOT_BIAYA_RAD->DbValue = $row['TOT_BIAYA_RAD'];
		$this->TOT_BIAYA_CDRPOLI->DbValue = $row['TOT_BIAYA_CDRPOLI'];
		$this->TOT_BIAYA_LAB_IGD->DbValue = $row['TOT_BIAYA_LAB_IGD'];
		$this->TOT_BIAYA_OKSIGEN->DbValue = $row['TOT_BIAYA_OKSIGEN'];
		$this->TOTAL_BIAYA_OBAT->DbValue = $row['TOTAL_BIAYA_OBAT'];
		$this->LINK_SET_KELAS->DbValue = $row['LINK_SET_KELAS'];
		$this->biaya_obat->DbValue = $row['biaya_obat'];
		$this->biaya_retur_obat->DbValue = $row['biaya_retur_obat'];
		$this->TOT_BIAYA_GIZI->DbValue = $row['TOT_BIAYA_GIZI'];
		$this->TOT_BIAYA_TMO->DbValue = $row['TOT_BIAYA_TMO'];
		$this->TOT_BIAYA_AMBULAN->DbValue = $row['TOT_BIAYA_AMBULAN'];
		$this->TOT_BIAYA_FISIO->DbValue = $row['TOT_BIAYA_FISIO'];
		$this->TOT_BIAYA_LAINLAIN->DbValue = $row['TOT_BIAYA_LAINLAIN'];
		$this->jenisperawatan_id->DbValue = $row['jenisperawatan_id'];
		$this->status_transaksi->DbValue = $row['status_transaksi'];
		$this->statuskeluarranap_id->DbValue = $row['statuskeluarranap_id'];
		$this->TOT_BIAYA_AKOMODASI->DbValue = $row['TOT_BIAYA_AKOMODASI'];
		$this->TOTAL_BIAYA_ASKEP->DbValue = $row['TOTAL_BIAYA_ASKEP'];
		$this->TOTAL_BIAYA_SIMRS->DbValue = $row['TOTAL_BIAYA_SIMRS'];
		$this->TOT_PENJ_NMEDIS->DbValue = $row['TOT_PENJ_NMEDIS'];
		$this->LINK_MASTERDETAIL->DbValue = $row['LINK_MASTERDETAIL'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->LINK_PELAYANAN_OBAT->DbValue = $row['LINK_PELAYANAN_OBAT'];
		$this->TOT_TIND_RAJAL->DbValue = $row['TOT_TIND_RAJAL'];
		$this->TOT_TIND_IGD->DbValue = $row['TOT_TIND_IGD'];
		$this->tanggal_pengembalian_status->DbValue = $row['tanggal_pengembalian_status'];
		$this->naik_kelas->DbValue = $row['naik_kelas'];
		$this->iuran_kelas_lama->DbValue = $row['iuran_kelas_lama'];
		$this->iuran_kelas_baru->DbValue = $row['iuran_kelas_baru'];
		$this->ketrangan_naik_kelas->DbValue = $row['ketrangan_naik_kelas'];
		$this->tgl_pengiriman_ad_klaim->DbValue = $row['tgl_pengiriman_ad_klaim'];
		$this->diagnosa_keluar->DbValue = $row['diagnosa_keluar'];
		$this->sep_tglsep->DbValue = $row['sep_tglsep'];
		$this->sep_tglrujuk->DbValue = $row['sep_tglrujuk'];
		$this->sep_kodekelasrawat->DbValue = $row['sep_kodekelasrawat'];
		$this->sep_norujukan->DbValue = $row['sep_norujukan'];
		$this->sep_kodeppkasal->DbValue = $row['sep_kodeppkasal'];
		$this->sep_namappkasal->DbValue = $row['sep_namappkasal'];
		$this->sep_kodeppkpelayanan->DbValue = $row['sep_kodeppkpelayanan'];
		$this->sep_namappkpelayanan->DbValue = $row['sep_namappkpelayanan'];
		$this->t_admissioncol->DbValue = $row['t_admissioncol'];
		$this->sep_jenisperawatan->DbValue = $row['sep_jenisperawatan'];
		$this->sep_catatan->DbValue = $row['sep_catatan'];
		$this->sep_kodediagnosaawal->DbValue = $row['sep_kodediagnosaawal'];
		$this->sep_namadiagnosaawal->DbValue = $row['sep_namadiagnosaawal'];
		$this->sep_lakalantas->DbValue = $row['sep_lakalantas'];
		$this->sep_lokasilaka->DbValue = $row['sep_lokasilaka'];
		$this->sep_user->DbValue = $row['sep_user'];
		$this->sep_flag_cekpeserta->DbValue = $row['sep_flag_cekpeserta'];
		$this->sep_flag_generatesep->DbValue = $row['sep_flag_generatesep'];
		$this->sep_flag_mapingsep->DbValue = $row['sep_flag_mapingsep'];
		$this->sep_nik->DbValue = $row['sep_nik'];
		$this->sep_namapeserta->DbValue = $row['sep_namapeserta'];
		$this->sep_jeniskelamin->DbValue = $row['sep_jeniskelamin'];
		$this->sep_pisat->DbValue = $row['sep_pisat'];
		$this->sep_tgllahir->DbValue = $row['sep_tgllahir'];
		$this->sep_kodejeniskepesertaan->DbValue = $row['sep_kodejeniskepesertaan'];
		$this->sep_namajeniskepesertaan->DbValue = $row['sep_namajeniskepesertaan'];
		$this->sep_kodepolitujuan->DbValue = $row['sep_kodepolitujuan'];
		$this->sep_namapolitujuan->DbValue = $row['sep_namapolitujuan'];
		$this->ket_jeniskelamin->DbValue = $row['ket_jeniskelamin'];
		$this->sep_nokabpjs->DbValue = $row['sep_nokabpjs'];
		$this->counter_cetak_sep->DbValue = $row['counter_cetak_sep'];
		$this->sep_petugas_hapus_sep->DbValue = $row['sep_petugas_hapus_sep'];
		$this->sep_petugas_set_tgl_pulang->DbValue = $row['sep_petugas_set_tgl_pulang'];
		$this->sep_jam_generate_sep->DbValue = $row['sep_jam_generate_sep'];
		$this->sep_status_peserta->DbValue = $row['sep_status_peserta'];
		$this->sep_umur_pasien_sekarang->DbValue = $row['sep_umur_pasien_sekarang'];
		$this->ket_title->DbValue = $row['ket_title'];
		$this->status_daftar_ranap->DbValue = $row['status_daftar_ranap'];
		$this->IBS_SETMARKING->DbValue = $row['IBS_SETMARKING'];
		$this->IBS_PATOLOGI->DbValue = $row['IBS_PATOLOGI'];
		$this->IBS_JENISANESTESI->DbValue = $row['IBS_JENISANESTESI'];
		$this->IBS_NO_OK->DbValue = $row['IBS_NO_OK'];
		$this->IBS_ASISSTEN->DbValue = $row['IBS_ASISSTEN'];
		$this->IBS_JAM_ELEFTIF->DbValue = $row['IBS_JAM_ELEFTIF'];
		$this->IBS_JAM_ELEKTIF_SELESAI->DbValue = $row['IBS_JAM_ELEKTIF_SELESAI'];
		$this->IBS_JAM_CYTO->DbValue = $row['IBS_JAM_CYTO'];
		$this->IBS_JAM_CYTO_SELESAI->DbValue = $row['IBS_JAM_CYTO_SELESAI'];
		$this->IBS_TGL_DFTR_OP->DbValue = $row['IBS_TGL_DFTR_OP'];
		$this->IBS_TGL_OP->DbValue = $row['IBS_TGL_OP'];
		$this->grup_ruang_id->DbValue = $row['grup_ruang_id'];
		$this->status_order_ibs->DbValue = $row['status_order_ibs'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_admission
		// nomr
		// ket_nama
		// ket_tgllahir
		// ket_alamat
		// parent_nomr
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// nott
		// deposit
		// keluarrs
		// icd_masuk
		// icd_keluar
		// NIP
		// noruang_asal
		// nott_asal
		// tgl_pindah
		// kd_rujuk
		// st_bayar
		// dokter_penanggungjawab
		// perawat
		// KELASPERAWATAN_ID
		// LOS
		// TOT_TRF_TIND_DOKTER
		// TOT_BHP_DOKTER
		// TOT_TRF_PERAWAT
		// TOT_BHP_PERAWAT
		// TOT_TRF_DOKTER
		// TOT_BIAYA_RAD
		// TOT_BIAYA_CDRPOLI
		// TOT_BIAYA_LAB_IGD
		// TOT_BIAYA_OKSIGEN
		// TOTAL_BIAYA_OBAT
		// LINK_SET_KELAS
		// biaya_obat
		// biaya_retur_obat
		// TOT_BIAYA_GIZI
		// TOT_BIAYA_TMO
		// TOT_BIAYA_AMBULAN
		// TOT_BIAYA_FISIO
		// TOT_BIAYA_LAINLAIN
		// jenisperawatan_id
		// status_transaksi
		// statuskeluarranap_id
		// TOT_BIAYA_AKOMODASI
		// TOTAL_BIAYA_ASKEP
		// TOTAL_BIAYA_SIMRS
		// TOT_PENJ_NMEDIS
		// LINK_MASTERDETAIL
		// NO_SKP
		// LINK_PELAYANAN_OBAT
		// TOT_TIND_RAJAL
		// TOT_TIND_IGD
		// tanggal_pengembalian_status
		// naik_kelas
		// iuran_kelas_lama
		// iuran_kelas_baru
		// ketrangan_naik_kelas
		// tgl_pengiriman_ad_klaim
		// diagnosa_keluar
		// sep_tglsep
		// sep_tglrujuk
		// sep_kodekelasrawat
		// sep_norujukan
		// sep_kodeppkasal
		// sep_namappkasal
		// sep_kodeppkpelayanan
		// sep_namappkpelayanan
		// t_admissioncol
		// sep_jenisperawatan
		// sep_catatan
		// sep_kodediagnosaawal
		// sep_namadiagnosaawal
		// sep_lakalantas
		// sep_lokasilaka
		// sep_user
		// sep_flag_cekpeserta
		// sep_flag_generatesep
		// sep_flag_mapingsep
		// sep_nik
		// sep_namapeserta
		// sep_jeniskelamin
		// sep_pisat
		// sep_tgllahir
		// sep_kodejeniskepesertaan
		// sep_namajeniskepesertaan
		// sep_kodepolitujuan
		// sep_namapolitujuan
		// ket_jeniskelamin
		// sep_nokabpjs
		// counter_cetak_sep
		// sep_petugas_hapus_sep
		// sep_petugas_set_tgl_pulang
		// sep_jam_generate_sep
		// sep_status_peserta
		// sep_umur_pasien_sekarang
		// ket_title
		// status_daftar_ranap
		// IBS_SETMARKING
		// IBS_PATOLOGI
		// IBS_JENISANESTESI
		// IBS_NO_OK
		// IBS_ASISSTEN
		// IBS_JAM_ELEFTIF
		// IBS_JAM_ELEKTIF_SELESAI
		// IBS_JAM_CYTO
		// IBS_JAM_CYTO_SELESAI
		// IBS_TGL_DFTR_OP
		// IBS_TGL_OP
		// grup_ruang_id
		// status_order_ibs

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		if (strval($this->nomr->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->nomr->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->nomr->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->nomr->ViewValue = $this->nomr->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomr->ViewValue = $this->nomr->CurrentValue;
			}
		} else {
			$this->nomr->ViewValue = NULL;
		}
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// ket_tgllahir
		$this->ket_tgllahir->ViewValue = $this->ket_tgllahir->CurrentValue;
		$this->ket_tgllahir->ViewValue = ew_FormatDateTime($this->ket_tgllahir->ViewValue, 0);
		$this->ket_tgllahir->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// parent_nomr
		$this->parent_nomr->ViewValue = $this->parent_nomr->CurrentValue;
		$this->parent_nomr->ViewCustomAttributes = "";

		// dokterpengirim
		if (strval($this->dokterpengirim->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokterpengirim->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokterpengirim->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->CurrentValue;
			}
		} else {
			$this->dokterpengirim->ViewValue = NULL;
		}
		$this->dokterpengirim->ViewCustomAttributes = "";

		// statusbayar
		if (strval($this->statusbayar->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->statusbayar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statusbayar->ViewValue = $this->statusbayar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			}
		} else {
			$this->statusbayar->ViewValue = NULL;
		}
		$this->statusbayar->ViewCustomAttributes = "";

		// kirimdari
		$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
		if (strval($this->kirimdari->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kirimdari->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->kirimdari->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kirimdari->ViewValue = $this->kirimdari->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
			}
		} else {
			$this->kirimdari->ViewValue = NULL;
		}
		$this->kirimdari->ViewCustomAttributes = "";

		// keluargadekat
		$this->keluargadekat->ViewValue = $this->keluargadekat->CurrentValue;
		$this->keluargadekat->ViewCustomAttributes = "";

		// panggungjawab
		$this->panggungjawab->ViewValue = $this->panggungjawab->CurrentValue;
		$this->panggungjawab->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 11);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		if (strval($this->noruang->CurrentValue) <> "") {
			$sFilterWrk = "`no`" . ew_SearchString("=", $this->noruang->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `no`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_ruang`";
		$sWhereWrk = "";
		$this->noruang->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->noruang->ViewValue = $this->noruang->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->noruang->ViewValue = $this->noruang->CurrentValue;
			}
		} else {
			$this->noruang->ViewValue = NULL;
		}
		$this->noruang->ViewCustomAttributes = "";

		// tempat_tidur_id
		if (strval($this->tempat_tidur_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
		$sWhereWrk = "";
		$this->tempat_tidur_id->LookupFilters = array();
		$lookuptblfilter = "isnull(`KETERANGAN`)";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->CurrentValue;
			}
		} else {
			$this->tempat_tidur_id->ViewValue = NULL;
		}
		$this->tempat_tidur_id->ViewCustomAttributes = "";

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

		// deposit
		$this->deposit->ViewValue = $this->deposit->CurrentValue;
		$this->deposit->ViewCustomAttributes = "";

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 0);
		$this->keluarrs->ViewCustomAttributes = "";

		// icd_masuk
		$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
		if (strval($this->icd_masuk->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_masuk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
		$sWhereWrk = "";
		$this->icd_masuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_masuk->ViewValue = $this->icd_masuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
			}
		} else {
			$this->icd_masuk->ViewValue = NULL;
		}
		$this->icd_masuk->ViewCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		$this->icd_keluar->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// noruang_asal
		$this->noruang_asal->ViewValue = $this->noruang_asal->CurrentValue;
		$this->noruang_asal->ViewCustomAttributes = "";

		// nott_asal
		$this->nott_asal->ViewValue = $this->nott_asal->CurrentValue;
		$this->nott_asal->ViewCustomAttributes = "";

		// tgl_pindah
		$this->tgl_pindah->ViewValue = $this->tgl_pindah->CurrentValue;
		$this->tgl_pindah->ViewValue = ew_FormatDateTime($this->tgl_pindah->ViewValue, 0);
		$this->tgl_pindah->ViewCustomAttributes = "";

		// kd_rujuk
		if (strval($this->kd_rujuk->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->kd_rujuk->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->kd_rujuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->CurrentValue;
			}
		} else {
			$this->kd_rujuk->ViewValue = NULL;
		}
		$this->kd_rujuk->ViewCustomAttributes = "";

		// st_bayar
		$this->st_bayar->ViewValue = $this->st_bayar->CurrentValue;
		$this->st_bayar->ViewCustomAttributes = "";

		// dokter_penanggungjawab
		if (strval($this->dokter_penanggungjawab->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokter_penanggungjawab->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokter_penanggungjawab->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->CurrentValue;
			}
		} else {
			$this->dokter_penanggungjawab->ViewValue = NULL;
		}
		$this->dokter_penanggungjawab->ViewCustomAttributes = "";

		// perawat
		$this->perawat->ViewValue = $this->perawat->CurrentValue;
		$this->perawat->ViewCustomAttributes = "";

		// KELASPERAWATAN_ID
		if (strval($this->KELASPERAWATAN_ID->CurrentValue) <> "") {
			$sFilterWrk = "`kelasperawatan_id`" . ew_SearchString("=", $this->KELASPERAWATAN_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kelasperawatan_id`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_kelas_perawatan`";
		$sWhereWrk = "";
		$this->KELASPERAWATAN_ID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
			}
		} else {
			$this->KELASPERAWATAN_ID->ViewValue = NULL;
		}
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// LOS
		$this->LOS->ViewValue = $this->LOS->CurrentValue;
		$this->LOS->ViewCustomAttributes = "";

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER->ViewValue = $this->TOT_TRF_TIND_DOKTER->CurrentValue;
		$this->TOT_TRF_TIND_DOKTER->ViewCustomAttributes = "";

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER->ViewValue = $this->TOT_BHP_DOKTER->CurrentValue;
		$this->TOT_BHP_DOKTER->ViewCustomAttributes = "";

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT->ViewValue = $this->TOT_TRF_PERAWAT->CurrentValue;
		$this->TOT_TRF_PERAWAT->ViewCustomAttributes = "";

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT->ViewValue = $this->TOT_BHP_PERAWAT->CurrentValue;
		$this->TOT_BHP_PERAWAT->ViewCustomAttributes = "";

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER->ViewValue = $this->TOT_TRF_DOKTER->CurrentValue;
		$this->TOT_TRF_DOKTER->ViewCustomAttributes = "";

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD->ViewValue = $this->TOT_BIAYA_RAD->CurrentValue;
		$this->TOT_BIAYA_RAD->ViewCustomAttributes = "";

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI->ViewValue = $this->TOT_BIAYA_CDRPOLI->CurrentValue;
		$this->TOT_BIAYA_CDRPOLI->ViewCustomAttributes = "";

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD->ViewValue = $this->TOT_BIAYA_LAB_IGD->CurrentValue;
		$this->TOT_BIAYA_LAB_IGD->ViewCustomAttributes = "";

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN->ViewValue = $this->TOT_BIAYA_OKSIGEN->CurrentValue;
		$this->TOT_BIAYA_OKSIGEN->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->ViewValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->ViewCustomAttributes = "";

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS->ViewValue = $this->LINK_SET_KELAS->CurrentValue;
		$this->LINK_SET_KELAS->ViewCustomAttributes = "";

		// biaya_obat
		$this->biaya_obat->ViewValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->ViewCustomAttributes = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->ViewValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->ViewCustomAttributes = "";

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI->ViewValue = $this->TOT_BIAYA_GIZI->CurrentValue;
		$this->TOT_BIAYA_GIZI->ViewCustomAttributes = "";

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO->ViewValue = $this->TOT_BIAYA_TMO->CurrentValue;
		$this->TOT_BIAYA_TMO->ViewCustomAttributes = "";

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN->ViewValue = $this->TOT_BIAYA_AMBULAN->CurrentValue;
		$this->TOT_BIAYA_AMBULAN->ViewCustomAttributes = "";

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO->ViewValue = $this->TOT_BIAYA_FISIO->CurrentValue;
		$this->TOT_BIAYA_FISIO->ViewCustomAttributes = "";

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN->ViewValue = $this->TOT_BIAYA_LAINLAIN->CurrentValue;
		$this->TOT_BIAYA_LAINLAIN->ViewCustomAttributes = "";

		// jenisperawatan_id
		$this->jenisperawatan_id->ViewValue = $this->jenisperawatan_id->CurrentValue;
		$this->jenisperawatan_id->ViewCustomAttributes = "";

		// status_transaksi
		$this->status_transaksi->ViewValue = $this->status_transaksi->CurrentValue;
		$this->status_transaksi->ViewCustomAttributes = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI->ViewValue = $this->TOT_BIAYA_AKOMODASI->CurrentValue;
		$this->TOT_BIAYA_AKOMODASI->ViewCustomAttributes = "";

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP->ViewValue = $this->TOTAL_BIAYA_ASKEP->CurrentValue;
		$this->TOTAL_BIAYA_ASKEP->ViewCustomAttributes = "";

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS->ViewValue = $this->TOTAL_BIAYA_SIMRS->CurrentValue;
		$this->TOTAL_BIAYA_SIMRS->ViewCustomAttributes = "";

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS->ViewValue = $this->TOT_PENJ_NMEDIS->CurrentValue;
		$this->TOT_PENJ_NMEDIS->ViewCustomAttributes = "";

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL->ViewValue = $this->LINK_MASTERDETAIL->CurrentValue;
		$this->LINK_MASTERDETAIL->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT->ViewValue = $this->LINK_PELAYANAN_OBAT->CurrentValue;
		$this->LINK_PELAYANAN_OBAT->ViewCustomAttributes = "";

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL->ViewValue = $this->TOT_TIND_RAJAL->CurrentValue;
		$this->TOT_TIND_RAJAL->ViewCustomAttributes = "";

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD->ViewValue = $this->TOT_TIND_IGD->CurrentValue;
		$this->TOT_TIND_IGD->ViewCustomAttributes = "";

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status->ViewValue = $this->tanggal_pengembalian_status->CurrentValue;
		$this->tanggal_pengembalian_status->ViewValue = ew_FormatDateTime($this->tanggal_pengembalian_status->ViewValue, 0);
		$this->tanggal_pengembalian_status->ViewCustomAttributes = "";

		// naik_kelas
		$this->naik_kelas->ViewValue = $this->naik_kelas->CurrentValue;
		$this->naik_kelas->ViewCustomAttributes = "";

		// iuran_kelas_lama
		$this->iuran_kelas_lama->ViewValue = $this->iuran_kelas_lama->CurrentValue;
		$this->iuran_kelas_lama->ViewCustomAttributes = "";

		// iuran_kelas_baru
		$this->iuran_kelas_baru->ViewValue = $this->iuran_kelas_baru->CurrentValue;
		$this->iuran_kelas_baru->ViewCustomAttributes = "";

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas->ViewValue = $this->ketrangan_naik_kelas->CurrentValue;
		$this->ketrangan_naik_kelas->ViewCustomAttributes = "";

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim->ViewValue = $this->tgl_pengiriman_ad_klaim->CurrentValue;
		$this->tgl_pengiriman_ad_klaim->ViewValue = ew_FormatDateTime($this->tgl_pengiriman_ad_klaim->ViewValue, 0);
		$this->tgl_pengiriman_ad_klaim->ViewCustomAttributes = "";

		// diagnosa_keluar
		$this->diagnosa_keluar->ViewValue = $this->diagnosa_keluar->CurrentValue;
		$this->diagnosa_keluar->ViewCustomAttributes = "";

		// sep_tglsep
		$this->sep_tglsep->ViewValue = $this->sep_tglsep->CurrentValue;
		$this->sep_tglsep->ViewValue = ew_FormatDateTime($this->sep_tglsep->ViewValue, 0);
		$this->sep_tglsep->ViewCustomAttributes = "";

		// sep_tglrujuk
		$this->sep_tglrujuk->ViewValue = $this->sep_tglrujuk->CurrentValue;
		$this->sep_tglrujuk->ViewValue = ew_FormatDateTime($this->sep_tglrujuk->ViewValue, 0);
		$this->sep_tglrujuk->ViewCustomAttributes = "";

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat->ViewValue = $this->sep_kodekelasrawat->CurrentValue;
		$this->sep_kodekelasrawat->ViewCustomAttributes = "";

		// sep_norujukan
		$this->sep_norujukan->ViewValue = $this->sep_norujukan->CurrentValue;
		$this->sep_norujukan->ViewCustomAttributes = "";

		// sep_kodeppkasal
		$this->sep_kodeppkasal->ViewValue = $this->sep_kodeppkasal->CurrentValue;
		$this->sep_kodeppkasal->ViewCustomAttributes = "";

		// sep_namappkasal
		$this->sep_namappkasal->ViewValue = $this->sep_namappkasal->CurrentValue;
		$this->sep_namappkasal->ViewCustomAttributes = "";

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan->ViewValue = $this->sep_kodeppkpelayanan->CurrentValue;
		$this->sep_kodeppkpelayanan->ViewCustomAttributes = "";

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan->ViewValue = $this->sep_namappkpelayanan->CurrentValue;
		$this->sep_namappkpelayanan->ViewCustomAttributes = "";

		// t_admissioncol
		$this->t_admissioncol->ViewValue = $this->t_admissioncol->CurrentValue;
		$this->t_admissioncol->ViewCustomAttributes = "";

		// sep_jenisperawatan
		$this->sep_jenisperawatan->ViewValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_jenisperawatan->ViewCustomAttributes = "";

		// sep_catatan
		$this->sep_catatan->ViewValue = $this->sep_catatan->CurrentValue;
		$this->sep_catatan->ViewCustomAttributes = "";

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
		$this->sep_kodediagnosaawal->ViewCustomAttributes = "";

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->ViewValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->ViewCustomAttributes = "";

		// sep_lakalantas
		$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->CurrentValue;
		$this->sep_lakalantas->ViewCustomAttributes = "";

		// sep_lokasilaka
		$this->sep_lokasilaka->ViewValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_lokasilaka->ViewCustomAttributes = "";

		// sep_user
		$this->sep_user->ViewValue = $this->sep_user->CurrentValue;
		$this->sep_user->ViewCustomAttributes = "";

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta->ViewValue = $this->sep_flag_cekpeserta->CurrentValue;
		$this->sep_flag_cekpeserta->ViewCustomAttributes = "";

		// sep_flag_generatesep
		$this->sep_flag_generatesep->ViewValue = $this->sep_flag_generatesep->CurrentValue;
		$this->sep_flag_generatesep->ViewCustomAttributes = "";

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep->ViewValue = $this->sep_flag_mapingsep->CurrentValue;
		$this->sep_flag_mapingsep->ViewCustomAttributes = "";

		// sep_nik
		$this->sep_nik->ViewValue = $this->sep_nik->CurrentValue;
		$this->sep_nik->ViewCustomAttributes = "";

		// sep_namapeserta
		$this->sep_namapeserta->ViewValue = $this->sep_namapeserta->CurrentValue;
		$this->sep_namapeserta->ViewCustomAttributes = "";

		// sep_jeniskelamin
		$this->sep_jeniskelamin->ViewValue = $this->sep_jeniskelamin->CurrentValue;
		$this->sep_jeniskelamin->ViewCustomAttributes = "";

		// sep_pisat
		$this->sep_pisat->ViewValue = $this->sep_pisat->CurrentValue;
		$this->sep_pisat->ViewCustomAttributes = "";

		// sep_tgllahir
		$this->sep_tgllahir->ViewValue = $this->sep_tgllahir->CurrentValue;
		$this->sep_tgllahir->ViewCustomAttributes = "";

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan->ViewValue = $this->sep_kodejeniskepesertaan->CurrentValue;
		$this->sep_kodejeniskepesertaan->ViewCustomAttributes = "";

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan->ViewValue = $this->sep_namajeniskepesertaan->CurrentValue;
		$this->sep_namajeniskepesertaan->ViewCustomAttributes = "";

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan->ViewValue = $this->sep_kodepolitujuan->CurrentValue;
		$this->sep_kodepolitujuan->ViewCustomAttributes = "";

		// sep_namapolitujuan
		$this->sep_namapolitujuan->ViewValue = $this->sep_namapolitujuan->CurrentValue;
		$this->sep_namapolitujuan->ViewCustomAttributes = "";

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// sep_nokabpjs
		$this->sep_nokabpjs->ViewValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->ViewCustomAttributes = "";

		// counter_cetak_sep
		$this->counter_cetak_sep->ViewValue = $this->counter_cetak_sep->CurrentValue;
		$this->counter_cetak_sep->ViewCustomAttributes = "";

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep->ViewValue = $this->sep_petugas_hapus_sep->CurrentValue;
		$this->sep_petugas_hapus_sep->ViewCustomAttributes = "";

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang->ViewValue = $this->sep_petugas_set_tgl_pulang->CurrentValue;
		$this->sep_petugas_set_tgl_pulang->ViewCustomAttributes = "";

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep->ViewValue = $this->sep_jam_generate_sep->CurrentValue;
		$this->sep_jam_generate_sep->ViewValue = ew_FormatDateTime($this->sep_jam_generate_sep->ViewValue, 0);
		$this->sep_jam_generate_sep->ViewCustomAttributes = "";

		// sep_status_peserta
		$this->sep_status_peserta->ViewValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_status_peserta->ViewCustomAttributes = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->ViewValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->sep_umur_pasien_sekarang->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// status_daftar_ranap
		$this->status_daftar_ranap->ViewValue = $this->status_daftar_ranap->CurrentValue;
		$this->status_daftar_ranap->ViewCustomAttributes = "";

		// IBS_SETMARKING
		$this->IBS_SETMARKING->ViewValue = $this->IBS_SETMARKING->CurrentValue;
		$this->IBS_SETMARKING->ViewCustomAttributes = "";

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI->ViewValue = $this->IBS_PATOLOGI->CurrentValue;
		$this->IBS_PATOLOGI->ViewCustomAttributes = "";

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI->ViewValue = $this->IBS_JENISANESTESI->CurrentValue;
		$this->IBS_JENISANESTESI->ViewCustomAttributes = "";

		// IBS_NO_OK
		$this->IBS_NO_OK->ViewValue = $this->IBS_NO_OK->CurrentValue;
		$this->IBS_NO_OK->ViewCustomAttributes = "";

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN->ViewValue = $this->IBS_ASISSTEN->CurrentValue;
		$this->IBS_ASISSTEN->ViewCustomAttributes = "";

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF->ViewValue = $this->IBS_JAM_ELEFTIF->CurrentValue;
		$this->IBS_JAM_ELEFTIF->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEFTIF->ViewValue, 0);
		$this->IBS_JAM_ELEFTIF->ViewCustomAttributes = "";

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = $this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue;
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->ViewValue, 0);
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewCustomAttributes = "";

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO->ViewValue = $this->IBS_JAM_CYTO->CurrentValue;
		$this->IBS_JAM_CYTO->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO->ViewValue, 0);
		$this->IBS_JAM_CYTO->ViewCustomAttributes = "";

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = $this->IBS_JAM_CYTO_SELESAI->CurrentValue;
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO_SELESAI->ViewValue, 0);
		$this->IBS_JAM_CYTO_SELESAI->ViewCustomAttributes = "";

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP->ViewValue = $this->IBS_TGL_DFTR_OP->CurrentValue;
		$this->IBS_TGL_DFTR_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_DFTR_OP->ViewValue, 0);
		$this->IBS_TGL_DFTR_OP->ViewCustomAttributes = "";

		// IBS_TGL_OP
		$this->IBS_TGL_OP->ViewValue = $this->IBS_TGL_OP->CurrentValue;
		$this->IBS_TGL_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_OP->ViewValue, 0);
		$this->IBS_TGL_OP->ViewCustomAttributes = "";

		// grup_ruang_id
		$this->grup_ruang_id->ViewValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->ViewCustomAttributes = "";

		// status_order_ibs
		$this->status_order_ibs->ViewValue = $this->status_order_ibs->CurrentValue;
		$this->status_order_ibs->ViewCustomAttributes = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// ket_nama
			$this->ket_nama->LinkCustomAttributes = "";
			$this->ket_nama->HrefValue = "";
			$this->ket_nama->TooltipValue = "";

			// ket_tgllahir
			$this->ket_tgllahir->LinkCustomAttributes = "";
			$this->ket_tgllahir->HrefValue = "";
			$this->ket_tgllahir->TooltipValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";
			$this->ket_alamat->TooltipValue = "";

			// dokterpengirim
			$this->dokterpengirim->LinkCustomAttributes = "";
			$this->dokterpengirim->HrefValue = "";
			$this->dokterpengirim->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// kirimdari
			$this->kirimdari->LinkCustomAttributes = "";
			$this->kirimdari->HrefValue = "";
			$this->kirimdari->TooltipValue = "";

			// keluargadekat
			$this->keluargadekat->LinkCustomAttributes = "";
			$this->keluargadekat->HrefValue = "";
			$this->keluargadekat->TooltipValue = "";

			// panggungjawab
			$this->panggungjawab->LinkCustomAttributes = "";
			$this->panggungjawab->HrefValue = "";
			$this->panggungjawab->TooltipValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";
			$this->masukrs->TooltipValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";
			$this->noruang->TooltipValue = "";

			// tempat_tidur_id
			$this->tempat_tidur_id->LinkCustomAttributes = "";
			$this->tempat_tidur_id->HrefValue = "";
			$this->tempat_tidur_id->TooltipValue = "";

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";
			$this->nott->TooltipValue = "";

			// icd_masuk
			$this->icd_masuk->LinkCustomAttributes = "";
			$this->icd_masuk->HrefValue = "";
			$this->icd_masuk->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// kd_rujuk
			$this->kd_rujuk->LinkCustomAttributes = "";
			$this->kd_rujuk->HrefValue = "";
			$this->kd_rujuk->TooltipValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";
			$this->dokter_penanggungjawab->TooltipValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// ket_jeniskelamin
			$this->ket_jeniskelamin->LinkCustomAttributes = "";
			$this->ket_jeniskelamin->HrefValue = "";
			$this->ket_jeniskelamin->TooltipValue = "";

			// ket_title
			$this->ket_title->LinkCustomAttributes = "";
			$this->ket_title->HrefValue = "";
			$this->ket_title->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
			if (strval($this->nomr->CurrentValue) <> "") {
				$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->nomr->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "";
			$this->nomr->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->nomr->EditValue = $this->nomr->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
				}
			} else {
				$this->nomr->EditValue = NULL;
			}
			$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());

			// ket_nama
			$this->ket_nama->EditAttrs["class"] = "form-control";
			$this->ket_nama->EditCustomAttributes = "";
			$this->ket_nama->EditValue = ew_HtmlEncode($this->ket_nama->CurrentValue);
			$this->ket_nama->PlaceHolder = ew_RemoveHtml($this->ket_nama->FldCaption());

			// ket_tgllahir
			$this->ket_tgllahir->EditAttrs["class"] = "form-control";
			$this->ket_tgllahir->EditCustomAttributes = "";
			$this->ket_tgllahir->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->ket_tgllahir->CurrentValue, 8));
			$this->ket_tgllahir->PlaceHolder = ew_RemoveHtml($this->ket_tgllahir->FldCaption());

			// ket_alamat
			$this->ket_alamat->EditAttrs["class"] = "form-control";
			$this->ket_alamat->EditCustomAttributes = "";
			$this->ket_alamat->EditValue = ew_HtmlEncode($this->ket_alamat->CurrentValue);
			$this->ket_alamat->PlaceHolder = ew_RemoveHtml($this->ket_alamat->FldCaption());

			// dokterpengirim
			$this->dokterpengirim->EditAttrs["class"] = "form-control";
			$this->dokterpengirim->EditCustomAttributes = "";
			if (trim(strval($this->dokterpengirim->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokterpengirim->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokterpengirim->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->dokterpengirim->EditValue = $arwrk;

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			if (trim(strval($this->statusbayar->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->statusbayar->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->statusbayar->EditValue = $arwrk;

			// kirimdari
			$this->kirimdari->EditAttrs["class"] = "form-control";
			$this->kirimdari->EditCustomAttributes = "";
			$this->kirimdari->EditValue = ew_HtmlEncode($this->kirimdari->CurrentValue);
			if (strval($this->kirimdari->CurrentValue) <> "") {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kirimdari->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "";
			$this->kirimdari->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->kirimdari->EditValue = $this->kirimdari->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->kirimdari->EditValue = ew_HtmlEncode($this->kirimdari->CurrentValue);
				}
			} else {
				$this->kirimdari->EditValue = NULL;
			}
			$this->kirimdari->PlaceHolder = ew_RemoveHtml($this->kirimdari->FldCaption());

			// keluargadekat
			$this->keluargadekat->EditAttrs["class"] = "form-control";
			$this->keluargadekat->EditCustomAttributes = "";
			$this->keluargadekat->EditValue = ew_HtmlEncode($this->keluargadekat->CurrentValue);
			$this->keluargadekat->PlaceHolder = ew_RemoveHtml($this->keluargadekat->FldCaption());

			// panggungjawab
			$this->panggungjawab->EditAttrs["class"] = "form-control";
			$this->panggungjawab->EditCustomAttributes = "";
			$this->panggungjawab->EditValue = ew_HtmlEncode($this->panggungjawab->CurrentValue);
			$this->panggungjawab->PlaceHolder = ew_RemoveHtml($this->panggungjawab->FldCaption());

			// masukrs
			$this->masukrs->EditAttrs["class"] = "form-control";
			$this->masukrs->EditCustomAttributes = "";
			$this->masukrs->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->masukrs->CurrentValue, 11));
			$this->masukrs->PlaceHolder = ew_RemoveHtml($this->masukrs->FldCaption());

			// noruang
			$this->noruang->EditAttrs["class"] = "form-control";
			$this->noruang->EditCustomAttributes = "";
			if (trim(strval($this->noruang->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`no`" . ew_SearchString("=", $this->noruang->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `no`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_ruang`";
			$sWhereWrk = "";
			$this->noruang->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->noruang->EditValue = $arwrk;

			// tempat_tidur_id
			$this->tempat_tidur_id->EditAttrs["class"] = "form-control";
			$this->tempat_tidur_id->EditCustomAttributes = "";
			if (trim(strval($this->tempat_tidur_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idxruang` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_detail_tempat_tidur`";
			$sWhereWrk = "";
			$this->tempat_tidur_id->LookupFilters = array();
			$lookuptblfilter = "isnull(`KETERANGAN`)";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->tempat_tidur_id->EditValue = $arwrk;

			// nott
			$this->nott->EditAttrs["class"] = "form-control";
			$this->nott->EditCustomAttributes = "";
			$this->nott->EditValue = ew_HtmlEncode($this->nott->CurrentValue);
			$this->nott->PlaceHolder = ew_RemoveHtml($this->nott->FldCaption());

			// icd_masuk
			$this->icd_masuk->EditAttrs["class"] = "form-control";
			$this->icd_masuk->EditCustomAttributes = "";
			$this->icd_masuk->EditValue = ew_HtmlEncode($this->icd_masuk->CurrentValue);
			if (strval($this->icd_masuk->CurrentValue) <> "") {
				$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_masuk->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "";
			$this->icd_masuk->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->icd_masuk->EditValue = $this->icd_masuk->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->icd_masuk->EditValue = ew_HtmlEncode($this->icd_masuk->CurrentValue);
				}
			} else {
				$this->icd_masuk->EditValue = NULL;
			}
			$this->icd_masuk->PlaceHolder = ew_RemoveHtml($this->icd_masuk->FldCaption());

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = ew_HtmlEncode($this->NIP->CurrentValue);
			$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

			// kd_rujuk
			$this->kd_rujuk->EditAttrs["class"] = "form-control";
			$this->kd_rujuk->EditCustomAttributes = "";
			if (trim(strval($this->kd_rujuk->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->kd_rujuk->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_rujukan`";
			$sWhereWrk = "";
			$this->kd_rujuk->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kd_rujuk->EditValue = $arwrk;

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->EditAttrs["class"] = "form-control";
			$this->dokter_penanggungjawab->EditCustomAttributes = "";
			if (trim(strval($this->dokter_penanggungjawab->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokter_penanggungjawab->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokter_penanggungjawab->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->dokter_penanggungjawab->EditValue = $arwrk;

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->EditAttrs["class"] = "form-control";
			$this->KELASPERAWATAN_ID->EditCustomAttributes = "";
			if (trim(strval($this->KELASPERAWATAN_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kelasperawatan_id`" . ew_SearchString("=", $this->KELASPERAWATAN_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kelasperawatan_id`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_kelas_perawatan`";
			$sWhereWrk = "";
			$this->KELASPERAWATAN_ID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KELASPERAWATAN_ID->EditValue = $arwrk;

			// ket_jeniskelamin
			$this->ket_jeniskelamin->EditAttrs["class"] = "form-control";
			$this->ket_jeniskelamin->EditCustomAttributes = "";
			$this->ket_jeniskelamin->EditValue = ew_HtmlEncode($this->ket_jeniskelamin->CurrentValue);
			$this->ket_jeniskelamin->PlaceHolder = ew_RemoveHtml($this->ket_jeniskelamin->FldCaption());

			// ket_title
			$this->ket_title->EditAttrs["class"] = "form-control";
			$this->ket_title->EditCustomAttributes = "";
			$this->ket_title->EditValue = ew_HtmlEncode($this->ket_title->CurrentValue);
			$this->ket_title->PlaceHolder = ew_RemoveHtml($this->ket_title->FldCaption());

			// Edit refer script
			// nomr

			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";

			// ket_nama
			$this->ket_nama->LinkCustomAttributes = "";
			$this->ket_nama->HrefValue = "";

			// ket_tgllahir
			$this->ket_tgllahir->LinkCustomAttributes = "";
			$this->ket_tgllahir->HrefValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";

			// dokterpengirim
			$this->dokterpengirim->LinkCustomAttributes = "";
			$this->dokterpengirim->HrefValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";

			// kirimdari
			$this->kirimdari->LinkCustomAttributes = "";
			$this->kirimdari->HrefValue = "";

			// keluargadekat
			$this->keluargadekat->LinkCustomAttributes = "";
			$this->keluargadekat->HrefValue = "";

			// panggungjawab
			$this->panggungjawab->LinkCustomAttributes = "";
			$this->panggungjawab->HrefValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";

			// tempat_tidur_id
			$this->tempat_tidur_id->LinkCustomAttributes = "";
			$this->tempat_tidur_id->HrefValue = "";

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";

			// icd_masuk
			$this->icd_masuk->LinkCustomAttributes = "";
			$this->icd_masuk->HrefValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";

			// kd_rujuk
			$this->kd_rujuk->LinkCustomAttributes = "";
			$this->kd_rujuk->HrefValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";

			// ket_jeniskelamin
			$this->ket_jeniskelamin->LinkCustomAttributes = "";
			$this->ket_jeniskelamin->HrefValue = "";

			// ket_title
			$this->ket_title->LinkCustomAttributes = "";
			$this->ket_title->HrefValue = "";
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
		if (!$this->nomr->FldIsDetailKey && !is_null($this->nomr->FormValue) && $this->nomr->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomr->FldCaption(), $this->nomr->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->ket_tgllahir->FormValue)) {
			ew_AddMessage($gsFormError, $this->ket_tgllahir->FldErrMsg());
		}
		if (!$this->dokterpengirim->FldIsDetailKey && !is_null($this->dokterpengirim->FormValue) && $this->dokterpengirim->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dokterpengirim->FldCaption(), $this->dokterpengirim->ReqErrMsg));
		}
		if (!$this->statusbayar->FldIsDetailKey && !is_null($this->statusbayar->FormValue) && $this->statusbayar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->statusbayar->FldCaption(), $this->statusbayar->ReqErrMsg));
		}
		if (!$this->kirimdari->FldIsDetailKey && !is_null($this->kirimdari->FormValue) && $this->kirimdari->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kirimdari->FldCaption(), $this->kirimdari->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->kirimdari->FormValue)) {
			ew_AddMessage($gsFormError, $this->kirimdari->FldErrMsg());
		}
		if (!$this->keluargadekat->FldIsDetailKey && !is_null($this->keluargadekat->FormValue) && $this->keluargadekat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->keluargadekat->FldCaption(), $this->keluargadekat->ReqErrMsg));
		}
		if (!$this->panggungjawab->FldIsDetailKey && !is_null($this->panggungjawab->FormValue) && $this->panggungjawab->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->panggungjawab->FldCaption(), $this->panggungjawab->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->masukrs->FormValue)) {
			ew_AddMessage($gsFormError, $this->masukrs->FldErrMsg());
		}
		if (!$this->noruang->FldIsDetailKey && !is_null($this->noruang->FormValue) && $this->noruang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->noruang->FldCaption(), $this->noruang->ReqErrMsg));
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey && !is_null($this->tempat_tidur_id->FormValue) && $this->tempat_tidur_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tempat_tidur_id->FldCaption(), $this->tempat_tidur_id->ReqErrMsg));
		}
		if (!$this->nott->FldIsDetailKey && !is_null($this->nott->FormValue) && $this->nott->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nott->FldCaption(), $this->nott->ReqErrMsg));
		}
		if (!$this->icd_masuk->FldIsDetailKey && !is_null($this->icd_masuk->FormValue) && $this->icd_masuk->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->icd_masuk->FldCaption(), $this->icd_masuk->ReqErrMsg));
		}
		if (!$this->NIP->FldIsDetailKey && !is_null($this->NIP->FormValue) && $this->NIP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NIP->FldCaption(), $this->NIP->ReqErrMsg));
		}
		if (!$this->kd_rujuk->FldIsDetailKey && !is_null($this->kd_rujuk->FormValue) && $this->kd_rujuk->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_rujuk->FldCaption(), $this->kd_rujuk->ReqErrMsg));
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey && !is_null($this->dokter_penanggungjawab->FormValue) && $this->dokter_penanggungjawab->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dokter_penanggungjawab->FldCaption(), $this->dokter_penanggungjawab->ReqErrMsg));
		}
		if (!$this->KELASPERAWATAN_ID->FldIsDetailKey && !is_null($this->KELASPERAWATAN_ID->FormValue) && $this->KELASPERAWATAN_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KELASPERAWATAN_ID->FldCaption(), $this->KELASPERAWATAN_ID->ReqErrMsg));
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

			// nomr
			$this->nomr->SetDbValueDef($rsnew, $this->nomr->CurrentValue, "", $this->nomr->ReadOnly);

			// ket_nama
			$this->ket_nama->SetDbValueDef($rsnew, $this->ket_nama->CurrentValue, NULL, $this->ket_nama->ReadOnly);

			// ket_tgllahir
			$this->ket_tgllahir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->ket_tgllahir->CurrentValue, 0), NULL, $this->ket_tgllahir->ReadOnly);

			// ket_alamat
			$this->ket_alamat->SetDbValueDef($rsnew, $this->ket_alamat->CurrentValue, NULL, $this->ket_alamat->ReadOnly);

			// dokterpengirim
			$this->dokterpengirim->SetDbValueDef($rsnew, $this->dokterpengirim->CurrentValue, 0, $this->dokterpengirim->ReadOnly);

			// statusbayar
			$this->statusbayar->SetDbValueDef($rsnew, $this->statusbayar->CurrentValue, 0, $this->statusbayar->ReadOnly);

			// kirimdari
			$this->kirimdari->SetDbValueDef($rsnew, $this->kirimdari->CurrentValue, 0, $this->kirimdari->ReadOnly);

			// keluargadekat
			$this->keluargadekat->SetDbValueDef($rsnew, $this->keluargadekat->CurrentValue, "", $this->keluargadekat->ReadOnly);

			// panggungjawab
			$this->panggungjawab->SetDbValueDef($rsnew, $this->panggungjawab->CurrentValue, "", $this->panggungjawab->ReadOnly);

			// masukrs
			$this->masukrs->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->masukrs->CurrentValue, 11), NULL, $this->masukrs->ReadOnly);

			// noruang
			$this->noruang->SetDbValueDef($rsnew, $this->noruang->CurrentValue, 0, $this->noruang->ReadOnly);

			// tempat_tidur_id
			$this->tempat_tidur_id->SetDbValueDef($rsnew, $this->tempat_tidur_id->CurrentValue, 0, $this->tempat_tidur_id->ReadOnly);

			// nott
			$this->nott->SetDbValueDef($rsnew, $this->nott->CurrentValue, "", $this->nott->ReadOnly);

			// icd_masuk
			$this->icd_masuk->SetDbValueDef($rsnew, $this->icd_masuk->CurrentValue, NULL, $this->icd_masuk->ReadOnly);

			// NIP
			$this->NIP->SetDbValueDef($rsnew, $this->NIP->CurrentValue, "", $this->NIP->ReadOnly);

			// kd_rujuk
			$this->kd_rujuk->SetDbValueDef($rsnew, $this->kd_rujuk->CurrentValue, 0, $this->kd_rujuk->ReadOnly);

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->SetDbValueDef($rsnew, $this->dokter_penanggungjawab->CurrentValue, 0, $this->dokter_penanggungjawab->ReadOnly);

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->SetDbValueDef($rsnew, $this->KELASPERAWATAN_ID->CurrentValue, NULL, $this->KELASPERAWATAN_ID->ReadOnly);

			// ket_jeniskelamin
			$this->ket_jeniskelamin->SetDbValueDef($rsnew, $this->ket_jeniskelamin->CurrentValue, NULL, $this->ket_jeniskelamin->ReadOnly);

			// ket_title
			$this->ket_title->SetDbValueDef($rsnew, $this->ket_title->CurrentValue, NULL, $this->ket_title->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_admissionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_nomr":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR` AS `LinkFld`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "{filter}";
			$this->nomr->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`NOMR` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_dokterpengirim":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokterpengirim->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KDDOKTER` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_statusbayar":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE` AS `LinkFld`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->statusbayar->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KODE` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kirimdari":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "{filter}";
			$this->kirimdari->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_noruang":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `no` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_ruang`";
			$sWhereWrk = "";
			$this->noruang->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`no` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_tempat_tidur_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
			$sWhereWrk = "{filter}";
			$this->tempat_tidur_id->LookupFilters = array();
			$lookuptblfilter = "isnull(`KETERANGAN`)";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`idxruang` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_icd_masuk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE` AS `LinkFld`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "{filter}";
			$this->icd_masuk->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`CODE` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kd_rujuk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE` AS `LinkFld`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
			$sWhereWrk = "";
			$this->kd_rujuk->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KODE` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_dokter_penanggungjawab":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokter_penanggungjawab->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KDDOKTER` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KELASPERAWATAN_ID":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kelasperawatan_id` AS `LinkFld`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_kelas_perawatan`";
			$sWhereWrk = "";
			$this->KELASPERAWATAN_ID->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kelasperawatan_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
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
		case "x_nomr":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld` FROM `m_pasien`";
			$sWhereWrk = "`NOMR` LIKE '%{query_value}%' OR `NAMA` LIKE '%{query_value}%' OR CONCAT(`NOMR`,'" . ew_ValueSeparator(1, $this->nomr) . "',`NAMA`) LIKE '{query_value}%'";
			$this->nomr->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kirimdari":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld` FROM `m_poly`";
			$sWhereWrk = "`nama` LIKE '%{query_value}%'";
			$this->kirimdari->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_icd_masuk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "`CODE` LIKE '%{query_value}%' OR `STR` LIKE '%{query_value}%' OR CONCAT(`CODE`,'" . ew_ValueSeparator(1, $this->icd_masuk) . "',`STR`) LIKE '{query_value}%'";
			$this->icd_masuk->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
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

		if ($this->CurrentAction == "U") {

	//$KDCARABAYAR
			$url = "pendaftaran_ranap_sukses.php?idadmission=".$this->id_admission->CurrentValue."&nomr=".$this->nomr->CurrentValue."&KDCARABAYAR=".$this->statusbayar->CurrentValue;
		}
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
if (!isset($t_admission_edit)) $t_admission_edit = new ct_admission_edit();

// Page init
$t_admission_edit->Page_Init();

// Page main
$t_admission_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_admission_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ft_admissionedit = new ew_Form("ft_admissionedit", "edit");

// Validate form
ft_admissionedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nomr");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->nomr->FldCaption(), $t_admission->nomr->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ket_tgllahir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->ket_tgllahir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dokterpengirim");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->dokterpengirim->FldCaption(), $t_admission->dokterpengirim->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_statusbayar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->statusbayar->FldCaption(), $t_admission->statusbayar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kirimdari");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->kirimdari->FldCaption(), $t_admission->kirimdari->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kirimdari");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->kirimdari->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keluargadekat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->keluargadekat->FldCaption(), $t_admission->keluargadekat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_panggungjawab");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->panggungjawab->FldCaption(), $t_admission->panggungjawab->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_masukrs");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->masukrs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_noruang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->noruang->FldCaption(), $t_admission->noruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tempat_tidur_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->tempat_tidur_id->FldCaption(), $t_admission->tempat_tidur_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nott");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->nott->FldCaption(), $t_admission->nott->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_icd_masuk");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->icd_masuk->FldCaption(), $t_admission->icd_masuk->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NIP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->NIP->FldCaption(), $t_admission->NIP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kd_rujuk");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->kd_rujuk->FldCaption(), $t_admission->kd_rujuk->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dokter_penanggungjawab");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->dokter_penanggungjawab->FldCaption(), $t_admission->dokter_penanggungjawab->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KELASPERAWATAN_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->KELASPERAWATAN_ID->FldCaption(), $t_admission->KELASPERAWATAN_ID->ReqErrMsg)) ?>");

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
ft_admissionedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_admissionedit.ValidateRequired = true;
<?php } else { ?>
ft_admissionedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_admissionedit.Lists["x_nomr"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_admissionedit.Lists["x_dokterpengirim"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_admissionedit.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_admissionedit.Lists["x_kirimdari"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_admissionedit.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
ft_admissionedit.Lists["x_tempat_tidur_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_no_tt","","",""],"ParentFields":["x_noruang"],"ChildFields":[],"FilterFields":["x_idxruang"],"Options":[],"Template":"","LinkTable":"m_detail_tempat_tidur"};
ft_admissionedit.Lists["x_icd_masuk"] = {"LinkField":"x_CODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_CODE","x_STR","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_diagnosa_eklaim"};
ft_admissionedit.Lists["x_kd_rujuk"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
ft_admissionedit.Lists["x_dokter_penanggungjawab"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_admissionedit.Lists["x_KELASPERAWATAN_ID"] = {"LinkField":"x_kelasperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kelasperawatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_kelas_perawatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_admission_edit->IsModal) { ?>
<?php } ?>
<?php $t_admission_edit->ShowPageHeader(); ?>
<?php
$t_admission_edit->ShowMessage();
?>
<form name="ft_admissionedit" id="ft_admissionedit" class="<?php echo $t_admission_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_admission_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_admission_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_admission">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($t_admission_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_t_admissionedit" class="ewCustomTemplate"></div>
<script id="tpm_t_admissionedit" type="text/html">
<div id="ct_t_admission_edit"><div id="ct_sample_add">
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Pendaftaran</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->nomr->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_nomr"/}}</div>
	</div>
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->dokterpengirim->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_dokterpengirim"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->statusbayar->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_statusbayar"/}}</div>
	</div>
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->kirimdari->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_kirimdari"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
<div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->masukrs->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_masukrs"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->noruang->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_noruang"/}}</div>
	</div>
		<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->tempat_tidur_id->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_tempat_tidur_id"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->nott->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_nott"/}}</div>
	</div>
		<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->KELASPERAWATAN_ID->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_KELASPERAWATAN_ID"/}}</div>
	</div>
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Identitas Pribadi Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->ket_nama->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_ket_nama"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->ket_tgllahir->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_ket_tgllahir"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->ket_alamat->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_ket_alamat"/}}</div>
	</div>
	  <div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->ket_jeniskelamin->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_ket_jeniskelamin"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->ket_title->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_ket_title"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->icd_masuk->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_icd_masuk"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->NIP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_NIP"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->kd_rujuk->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_kd_rujuk"/}}</div>
	</div>
		<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->dokter_penanggungjawab->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_dokter_penanggungjawab"/}}</div>
	</div>
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Keluarga Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
		<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->keluargadekat->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_keluargadekat"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $t_admission->panggungjawab->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_admission_panggungjawab"/}}</div>
	</div>
  </div>
</div>
</div>
</div>
</script>
<div style="display: none">
<?php if ($t_admission->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label id="elh_t_admission_nomr" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_nomr" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->nomr->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->nomr->CellAttributes() ?>>
<script id="tpx_t_admission_nomr" class="t_admissionedit" type="text/html">
<span id="el_t_admission_nomr">
<?php
$wrkonchange = trim(" " . @$t_admission->nomr->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_admission->nomr->EditAttrs["onchange"] = "";
?>
<span id="as_x_nomr" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_nomr" id="sv_x_nomr" value="<?php echo $t_admission->nomr->EditValue ?>" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->nomr->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_admission->nomr->getPlaceHolder()) ?>"<?php echo $t_admission->nomr->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_admission" data-field="x_nomr" data-value-separator="<?php echo $t_admission->nomr->DisplayValueSeparatorAttribute() ?>" name="x_nomr" id="x_nomr" value="<?php echo ew_HtmlEncode($t_admission->nomr->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_nomr" id="q_x_nomr" value="<?php echo $t_admission->nomr->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="t_admissionedit_js">
ft_admissionedit.CreateAutoSuggest({"id":"x_nomr","forceSelect":false});
</script>
<?php echo $t_admission->nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_nama->Visible) { // ket_nama ?>
	<div id="r_ket_nama" class="form-group">
		<label id="elh_t_admission_ket_nama" for="x_ket_nama" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_ket_nama" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->ket_nama->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_nama->CellAttributes() ?>>
<script id="tpx_t_admission_ket_nama" class="t_admissionedit" type="text/html">
<span id="el_t_admission_ket_nama">
<input type="text" data-table="t_admission" data-field="x_ket_nama" name="x_ket_nama" id="x_ket_nama" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_nama->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_nama->EditValue ?>"<?php echo $t_admission->ket_nama->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->ket_nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_tgllahir->Visible) { // ket_tgllahir ?>
	<div id="r_ket_tgllahir" class="form-group">
		<label id="elh_t_admission_ket_tgllahir" for="x_ket_tgllahir" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_ket_tgllahir" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->ket_tgllahir->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_tgllahir->CellAttributes() ?>>
<script id="tpx_t_admission_ket_tgllahir" class="t_admissionedit" type="text/html">
<span id="el_t_admission_ket_tgllahir">
<input type="text" data-table="t_admission" data-field="x_ket_tgllahir" name="x_ket_tgllahir" id="x_ket_tgllahir" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_tgllahir->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_tgllahir->EditValue ?>"<?php echo $t_admission->ket_tgllahir->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->ket_tgllahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_alamat->Visible) { // ket_alamat ?>
	<div id="r_ket_alamat" class="form-group">
		<label id="elh_t_admission_ket_alamat" for="x_ket_alamat" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_ket_alamat" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->ket_alamat->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_alamat->CellAttributes() ?>>
<script id="tpx_t_admission_ket_alamat" class="t_admissionedit" type="text/html">
<span id="el_t_admission_ket_alamat">
<input type="text" data-table="t_admission" data-field="x_ket_alamat" name="x_ket_alamat" id="x_ket_alamat" size="30" maxlength="225" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_alamat->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_alamat->EditValue ?>"<?php echo $t_admission->ket_alamat->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->ket_alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->dokterpengirim->Visible) { // dokterpengirim ?>
	<div id="r_dokterpengirim" class="form-group">
		<label id="elh_t_admission_dokterpengirim" for="x_dokterpengirim" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_dokterpengirim" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->dokterpengirim->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->dokterpengirim->CellAttributes() ?>>
<script id="tpx_t_admission_dokterpengirim" class="t_admissionedit" type="text/html">
<span id="el_t_admission_dokterpengirim">
<select data-table="t_admission" data-field="x_dokterpengirim" data-value-separator="<?php echo $t_admission->dokterpengirim->DisplayValueSeparatorAttribute() ?>" id="x_dokterpengirim" name="x_dokterpengirim"<?php echo $t_admission->dokterpengirim->EditAttributes() ?>>
<?php echo $t_admission->dokterpengirim->SelectOptionListHtml("x_dokterpengirim") ?>
</select>
<input type="hidden" name="s_x_dokterpengirim" id="s_x_dokterpengirim" value="<?php echo $t_admission->dokterpengirim->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_admission->dokterpengirim->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->statusbayar->Visible) { // statusbayar ?>
	<div id="r_statusbayar" class="form-group">
		<label id="elh_t_admission_statusbayar" for="x_statusbayar" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_statusbayar" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->statusbayar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->statusbayar->CellAttributes() ?>>
<script id="tpx_t_admission_statusbayar" class="t_admissionedit" type="text/html">
<span id="el_t_admission_statusbayar">
<select data-table="t_admission" data-field="x_statusbayar" data-value-separator="<?php echo $t_admission->statusbayar->DisplayValueSeparatorAttribute() ?>" id="x_statusbayar" name="x_statusbayar"<?php echo $t_admission->statusbayar->EditAttributes() ?>>
<?php echo $t_admission->statusbayar->SelectOptionListHtml("x_statusbayar") ?>
</select>
<input type="hidden" name="s_x_statusbayar" id="s_x_statusbayar" value="<?php echo $t_admission->statusbayar->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_admission->statusbayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->kirimdari->Visible) { // kirimdari ?>
	<div id="r_kirimdari" class="form-group">
		<label id="elh_t_admission_kirimdari" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_kirimdari" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->kirimdari->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->kirimdari->CellAttributes() ?>>
<script id="tpx_t_admission_kirimdari" class="t_admissionedit" type="text/html">
<span id="el_t_admission_kirimdari">
<?php
$wrkonchange = trim(" " . @$t_admission->kirimdari->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_admission->kirimdari->EditAttrs["onchange"] = "";
?>
<span id="as_x_kirimdari" style="white-space: nowrap; z-index: 8910">
	<input type="text" name="sv_x_kirimdari" id="sv_x_kirimdari" value="<?php echo $t_admission->kirimdari->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->kirimdari->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_admission->kirimdari->getPlaceHolder()) ?>"<?php echo $t_admission->kirimdari->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_admission" data-field="x_kirimdari" data-value-separator="<?php echo $t_admission->kirimdari->DisplayValueSeparatorAttribute() ?>" name="x_kirimdari" id="x_kirimdari" value="<?php echo ew_HtmlEncode($t_admission->kirimdari->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_kirimdari" id="q_x_kirimdari" value="<?php echo $t_admission->kirimdari->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="t_admissionedit_js">
ft_admissionedit.CreateAutoSuggest({"id":"x_kirimdari","forceSelect":false});
</script>
<?php echo $t_admission->kirimdari->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->keluargadekat->Visible) { // keluargadekat ?>
	<div id="r_keluargadekat" class="form-group">
		<label id="elh_t_admission_keluargadekat" for="x_keluargadekat" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_keluargadekat" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->keluargadekat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->keluargadekat->CellAttributes() ?>>
<script id="tpx_t_admission_keluargadekat" class="t_admissionedit" type="text/html">
<span id="el_t_admission_keluargadekat">
<input type="text" data-table="t_admission" data-field="x_keluargadekat" name="x_keluargadekat" id="x_keluargadekat" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_admission->keluargadekat->getPlaceHolder()) ?>" value="<?php echo $t_admission->keluargadekat->EditValue ?>"<?php echo $t_admission->keluargadekat->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->keluargadekat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->panggungjawab->Visible) { // panggungjawab ?>
	<div id="r_panggungjawab" class="form-group">
		<label id="elh_t_admission_panggungjawab" for="x_panggungjawab" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_panggungjawab" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->panggungjawab->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->panggungjawab->CellAttributes() ?>>
<script id="tpx_t_admission_panggungjawab" class="t_admissionedit" type="text/html">
<span id="el_t_admission_panggungjawab">
<input type="text" data-table="t_admission" data-field="x_panggungjawab" name="x_panggungjawab" id="x_panggungjawab" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_admission->panggungjawab->getPlaceHolder()) ?>" value="<?php echo $t_admission->panggungjawab->EditValue ?>"<?php echo $t_admission->panggungjawab->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->panggungjawab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->masukrs->Visible) { // masukrs ?>
	<div id="r_masukrs" class="form-group">
		<label id="elh_t_admission_masukrs" for="x_masukrs" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_masukrs" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->masukrs->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->masukrs->CellAttributes() ?>>
<script id="tpx_t_admission_masukrs" class="t_admissionedit" type="text/html">
<span id="el_t_admission_masukrs">
<input type="text" data-table="t_admission" data-field="x_masukrs" data-format="11" name="x_masukrs" id="x_masukrs" placeholder="<?php echo ew_HtmlEncode($t_admission->masukrs->getPlaceHolder()) ?>" value="<?php echo $t_admission->masukrs->EditValue ?>"<?php echo $t_admission->masukrs->EditAttributes() ?>>
<?php if (!$t_admission->masukrs->ReadOnly && !$t_admission->masukrs->Disabled && !isset($t_admission->masukrs->EditAttrs["readonly"]) && !isset($t_admission->masukrs->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="t_admissionedit_js">
ew_CreateCalendar("ft_admissionedit", "x_masukrs", 11);
</script>
<?php echo $t_admission->masukrs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->noruang->Visible) { // noruang ?>
	<div id="r_noruang" class="form-group">
		<label id="elh_t_admission_noruang" for="x_noruang" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_noruang" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->noruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->noruang->CellAttributes() ?>>
<script id="tpx_t_admission_noruang" class="t_admissionedit" type="text/html">
<span id="el_t_admission_noruang">
<?php $t_admission->noruang->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_admission->noruang->EditAttrs["onchange"]; ?>
<select data-table="t_admission" data-field="x_noruang" data-value-separator="<?php echo $t_admission->noruang->DisplayValueSeparatorAttribute() ?>" id="x_noruang" name="x_noruang"<?php echo $t_admission->noruang->EditAttributes() ?>>
<?php echo $t_admission->noruang->SelectOptionListHtml("x_noruang") ?>
</select>
<input type="hidden" name="s_x_noruang" id="s_x_noruang" value="<?php echo $t_admission->noruang->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_admission->noruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->tempat_tidur_id->Visible) { // tempat_tidur_id ?>
	<div id="r_tempat_tidur_id" class="form-group">
		<label id="elh_t_admission_tempat_tidur_id" for="x_tempat_tidur_id" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_tempat_tidur_id" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->tempat_tidur_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->tempat_tidur_id->CellAttributes() ?>>
<script id="tpx_t_admission_tempat_tidur_id" class="t_admissionedit" type="text/html">
<span id="el_t_admission_tempat_tidur_id">
<?php $t_admission->tempat_tidur_id->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$t_admission->tempat_tidur_id->EditAttrs["onchange"]; ?>
<select data-table="t_admission" data-field="x_tempat_tidur_id" data-value-separator="<?php echo $t_admission->tempat_tidur_id->DisplayValueSeparatorAttribute() ?>" id="x_tempat_tidur_id" name="x_tempat_tidur_id"<?php echo $t_admission->tempat_tidur_id->EditAttributes() ?>>
<?php echo $t_admission->tempat_tidur_id->SelectOptionListHtml("x_tempat_tidur_id") ?>
</select>
<input type="hidden" name="s_x_tempat_tidur_id" id="s_x_tempat_tidur_id" value="<?php echo $t_admission->tempat_tidur_id->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_tempat_tidur_id" id="ln_x_tempat_tidur_id" value="x_nott">
</span>
</script>
<?php echo $t_admission->tempat_tidur_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->nott->Visible) { // nott ?>
	<div id="r_nott" class="form-group">
		<label id="elh_t_admission_nott" for="x_nott" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_nott" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->nott->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->nott->CellAttributes() ?>>
<script id="tpx_t_admission_nott" class="t_admissionedit" type="text/html">
<span id="el_t_admission_nott">
<input type="text" data-table="t_admission" data-field="x_nott" name="x_nott" id="x_nott" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($t_admission->nott->getPlaceHolder()) ?>" value="<?php echo $t_admission->nott->EditValue ?>"<?php echo $t_admission->nott->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->nott->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->icd_masuk->Visible) { // icd_masuk ?>
	<div id="r_icd_masuk" class="form-group">
		<label id="elh_t_admission_icd_masuk" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_icd_masuk" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->icd_masuk->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->icd_masuk->CellAttributes() ?>>
<script id="tpx_t_admission_icd_masuk" class="t_admissionedit" type="text/html">
<span id="el_t_admission_icd_masuk">
<?php
$wrkonchange = trim(" " . @$t_admission->icd_masuk->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_admission->icd_masuk->EditAttrs["onchange"] = "";
?>
<span id="as_x_icd_masuk" style="white-space: nowrap; z-index: 8820">
	<input type="text" name="sv_x_icd_masuk" id="sv_x_icd_masuk" value="<?php echo $t_admission->icd_masuk->EditValue ?>" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->icd_masuk->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_admission->icd_masuk->getPlaceHolder()) ?>"<?php echo $t_admission->icd_masuk->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_admission" data-field="x_icd_masuk" data-value-separator="<?php echo $t_admission->icd_masuk->DisplayValueSeparatorAttribute() ?>" name="x_icd_masuk" id="x_icd_masuk" value="<?php echo ew_HtmlEncode($t_admission->icd_masuk->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_icd_masuk" id="q_x_icd_masuk" value="<?php echo $t_admission->icd_masuk->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="t_admissionedit_js">
ft_admissionedit.CreateAutoSuggest({"id":"x_icd_masuk","forceSelect":false});
</script>
<?php echo $t_admission->icd_masuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_t_admission_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_NIP" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->NIP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->NIP->CellAttributes() ?>>
<script id="tpx_t_admission_NIP" class="t_admissionedit" type="text/html">
<span id="el_t_admission_NIP">
<input type="text" data-table="t_admission" data-field="x_NIP" name="x_NIP" id="x_NIP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_admission->NIP->getPlaceHolder()) ?>" value="<?php echo $t_admission->NIP->EditValue ?>"<?php echo $t_admission->NIP->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->kd_rujuk->Visible) { // kd_rujuk ?>
	<div id="r_kd_rujuk" class="form-group">
		<label id="elh_t_admission_kd_rujuk" for="x_kd_rujuk" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_kd_rujuk" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->kd_rujuk->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->kd_rujuk->CellAttributes() ?>>
<script id="tpx_t_admission_kd_rujuk" class="t_admissionedit" type="text/html">
<span id="el_t_admission_kd_rujuk">
<select data-table="t_admission" data-field="x_kd_rujuk" data-value-separator="<?php echo $t_admission->kd_rujuk->DisplayValueSeparatorAttribute() ?>" id="x_kd_rujuk" name="x_kd_rujuk"<?php echo $t_admission->kd_rujuk->EditAttributes() ?>>
<?php echo $t_admission->kd_rujuk->SelectOptionListHtml("x_kd_rujuk") ?>
</select>
<input type="hidden" name="s_x_kd_rujuk" id="s_x_kd_rujuk" value="<?php echo $t_admission->kd_rujuk->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_admission->kd_rujuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->dokter_penanggungjawab->Visible) { // dokter_penanggungjawab ?>
	<div id="r_dokter_penanggungjawab" class="form-group">
		<label id="elh_t_admission_dokter_penanggungjawab" for="x_dokter_penanggungjawab" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_dokter_penanggungjawab" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->dokter_penanggungjawab->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->dokter_penanggungjawab->CellAttributes() ?>>
<script id="tpx_t_admission_dokter_penanggungjawab" class="t_admissionedit" type="text/html">
<span id="el_t_admission_dokter_penanggungjawab">
<select data-table="t_admission" data-field="x_dokter_penanggungjawab" data-value-separator="<?php echo $t_admission->dokter_penanggungjawab->DisplayValueSeparatorAttribute() ?>" id="x_dokter_penanggungjawab" name="x_dokter_penanggungjawab"<?php echo $t_admission->dokter_penanggungjawab->EditAttributes() ?>>
<?php echo $t_admission->dokter_penanggungjawab->SelectOptionListHtml("x_dokter_penanggungjawab") ?>
</select>
<input type="hidden" name="s_x_dokter_penanggungjawab" id="s_x_dokter_penanggungjawab" value="<?php echo $t_admission->dokter_penanggungjawab->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_admission->dokter_penanggungjawab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<div id="r_KELASPERAWATAN_ID" class="form-group">
		<label id="elh_t_admission_KELASPERAWATAN_ID" for="x_KELASPERAWATAN_ID" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_KELASPERAWATAN_ID" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->KELASPERAWATAN_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->KELASPERAWATAN_ID->CellAttributes() ?>>
<script id="tpx_t_admission_KELASPERAWATAN_ID" class="t_admissionedit" type="text/html">
<span id="el_t_admission_KELASPERAWATAN_ID">
<select data-table="t_admission" data-field="x_KELASPERAWATAN_ID" data-value-separator="<?php echo $t_admission->KELASPERAWATAN_ID->DisplayValueSeparatorAttribute() ?>" id="x_KELASPERAWATAN_ID" name="x_KELASPERAWATAN_ID"<?php echo $t_admission->KELASPERAWATAN_ID->EditAttributes() ?>>
<?php echo $t_admission->KELASPERAWATAN_ID->SelectOptionListHtml("x_KELASPERAWATAN_ID") ?>
</select>
<input type="hidden" name="s_x_KELASPERAWATAN_ID" id="s_x_KELASPERAWATAN_ID" value="<?php echo $t_admission->KELASPERAWATAN_ID->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_admission->KELASPERAWATAN_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_jeniskelamin->Visible) { // ket_jeniskelamin ?>
	<div id="r_ket_jeniskelamin" class="form-group">
		<label id="elh_t_admission_ket_jeniskelamin" for="x_ket_jeniskelamin" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_ket_jeniskelamin" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->ket_jeniskelamin->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_jeniskelamin->CellAttributes() ?>>
<script id="tpx_t_admission_ket_jeniskelamin" class="t_admissionedit" type="text/html">
<span id="el_t_admission_ket_jeniskelamin">
<input type="text" data-table="t_admission" data-field="x_ket_jeniskelamin" name="x_ket_jeniskelamin" id="x_ket_jeniskelamin" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_jeniskelamin->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_jeniskelamin->EditValue ?>"<?php echo $t_admission->ket_jeniskelamin->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->ket_jeniskelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_title->Visible) { // ket_title ?>
	<div id="r_ket_title" class="form-group">
		<label id="elh_t_admission_ket_title" for="x_ket_title" class="col-sm-2 control-label ewLabel"><script id="tpc_t_admission_ket_title" class="t_admissionedit" type="text/html"><span><?php echo $t_admission->ket_title->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_title->CellAttributes() ?>>
<script id="tpx_t_admission_ket_title" class="t_admissionedit" type="text/html">
<span id="el_t_admission_ket_title">
<input type="text" data-table="t_admission" data-field="x_ket_title" name="x_ket_title" id="x_ket_title" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_title->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_title->EditValue ?>"<?php echo $t_admission->ket_title->EditAttributes() ?>>
</span>
</script>
<?php echo $t_admission->ket_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="t_admission" data-field="x_id_admission" name="x_id_admission" id="x_id_admission" value="<?php echo ew_HtmlEncode($t_admission->id_admission->CurrentValue) ?>">
<?php if (!$t_admission_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_admission_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_t_admissionedit", "tpm_t_admissionedit", "t_admissionedit", "<?php echo $t_admission->CustomExport ?>");
jQuery("script.t_admissionedit_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
ft_admissionedit.Init();
</script>
<?php
$t_admission_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_admission_edit->Page_Terminate();
?>
