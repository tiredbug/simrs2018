<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_sep_rawat_inap_by_nokainfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_sep_rawat_inap_by_noka_edit = NULL; // Initialize page object first

class cvw_sep_rawat_inap_by_noka_edit extends cvw_sep_rawat_inap_by_noka {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_sep_rawat_inap_by_noka';

	// Page object name
	var $PageObjName = 'vw_sep_rawat_inap_by_noka_edit';

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

		// Table object (vw_sep_rawat_inap_by_noka)
		if (!isset($GLOBALS["vw_sep_rawat_inap_by_noka"]) || get_class($GLOBALS["vw_sep_rawat_inap_by_noka"]) == "cvw_sep_rawat_inap_by_noka") {
			$GLOBALS["vw_sep_rawat_inap_by_noka"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_sep_rawat_inap_by_noka"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_sep_rawat_inap_by_noka', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_sep_rawat_inap_by_nokalist.php"));
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
		global $EW_EXPORT, $vw_sep_rawat_inap_by_noka;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_sep_rawat_inap_by_noka);
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
			$this->Page_Terminate("vw_sep_rawat_inap_by_nokalist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_sep_rawat_inap_by_nokalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_sep_rawat_inap_by_nokalist.php")
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
		if (!$this->ket_jeniskelamin->FldIsDetailKey) {
			$this->ket_jeniskelamin->setFormValue($objForm->GetValue("x_ket_jeniskelamin"));
		}
		if (!$this->ket_title->FldIsDetailKey) {
			$this->ket_title->setFormValue($objForm->GetValue("x_ket_title"));
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
			$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 0);
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
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey) {
			$this->dokter_penanggungjawab->setFormValue($objForm->GetValue("x_dokter_penanggungjawab"));
		}
		if (!$this->KELASPERAWATAN_ID->FldIsDetailKey) {
			$this->KELASPERAWATAN_ID->setFormValue($objForm->GetValue("x_KELASPERAWATAN_ID"));
		}
		if (!$this->NO_SKP->FldIsDetailKey) {
			$this->NO_SKP->setFormValue($objForm->GetValue("x_NO_SKP"));
		}
		if (!$this->sep_tglsep->FldIsDetailKey) {
			$this->sep_tglsep->setFormValue($objForm->GetValue("x_sep_tglsep"));
			$this->sep_tglsep->CurrentValue = ew_UnFormatDateTime($this->sep_tglsep->CurrentValue, 5);
		}
		if (!$this->sep_tglrujuk->FldIsDetailKey) {
			$this->sep_tglrujuk->setFormValue($objForm->GetValue("x_sep_tglrujuk"));
			$this->sep_tglrujuk->CurrentValue = ew_UnFormatDateTime($this->sep_tglrujuk->CurrentValue, 5);
		}
		if (!$this->sep_kodekelasrawat->FldIsDetailKey) {
			$this->sep_kodekelasrawat->setFormValue($objForm->GetValue("x_sep_kodekelasrawat"));
		}
		if (!$this->sep_norujukan->FldIsDetailKey) {
			$this->sep_norujukan->setFormValue($objForm->GetValue("x_sep_norujukan"));
		}
		if (!$this->sep_kodeppkasal->FldIsDetailKey) {
			$this->sep_kodeppkasal->setFormValue($objForm->GetValue("x_sep_kodeppkasal"));
		}
		if (!$this->sep_namappkasal->FldIsDetailKey) {
			$this->sep_namappkasal->setFormValue($objForm->GetValue("x_sep_namappkasal"));
		}
		if (!$this->sep_kodeppkpelayanan->FldIsDetailKey) {
			$this->sep_kodeppkpelayanan->setFormValue($objForm->GetValue("x_sep_kodeppkpelayanan"));
		}
		if (!$this->sep_jenisperawatan->FldIsDetailKey) {
			$this->sep_jenisperawatan->setFormValue($objForm->GetValue("x_sep_jenisperawatan"));
		}
		if (!$this->sep_catatan->FldIsDetailKey) {
			$this->sep_catatan->setFormValue($objForm->GetValue("x_sep_catatan"));
		}
		if (!$this->sep_kodediagnosaawal->FldIsDetailKey) {
			$this->sep_kodediagnosaawal->setFormValue($objForm->GetValue("x_sep_kodediagnosaawal"));
		}
		if (!$this->sep_namadiagnosaawal->FldIsDetailKey) {
			$this->sep_namadiagnosaawal->setFormValue($objForm->GetValue("x_sep_namadiagnosaawal"));
		}
		if (!$this->sep_lakalantas->FldIsDetailKey) {
			$this->sep_lakalantas->setFormValue($objForm->GetValue("x_sep_lakalantas"));
		}
		if (!$this->sep_lokasilaka->FldIsDetailKey) {
			$this->sep_lokasilaka->setFormValue($objForm->GetValue("x_sep_lokasilaka"));
		}
		if (!$this->sep_user->FldIsDetailKey) {
			$this->sep_user->setFormValue($objForm->GetValue("x_sep_user"));
		}
		if (!$this->sep_flag_cekpeserta->FldIsDetailKey) {
			$this->sep_flag_cekpeserta->setFormValue($objForm->GetValue("x_sep_flag_cekpeserta"));
		}
		if (!$this->sep_flag_generatesep->FldIsDetailKey) {
			$this->sep_flag_generatesep->setFormValue($objForm->GetValue("x_sep_flag_generatesep"));
		}
		if (!$this->sep_nik->FldIsDetailKey) {
			$this->sep_nik->setFormValue($objForm->GetValue("x_sep_nik"));
		}
		if (!$this->sep_namapeserta->FldIsDetailKey) {
			$this->sep_namapeserta->setFormValue($objForm->GetValue("x_sep_namapeserta"));
		}
		if (!$this->sep_jeniskelamin->FldIsDetailKey) {
			$this->sep_jeniskelamin->setFormValue($objForm->GetValue("x_sep_jeniskelamin"));
		}
		if (!$this->sep_pisat->FldIsDetailKey) {
			$this->sep_pisat->setFormValue($objForm->GetValue("x_sep_pisat"));
		}
		if (!$this->sep_tgllahir->FldIsDetailKey) {
			$this->sep_tgllahir->setFormValue($objForm->GetValue("x_sep_tgllahir"));
		}
		if (!$this->sep_kodejeniskepesertaan->FldIsDetailKey) {
			$this->sep_kodejeniskepesertaan->setFormValue($objForm->GetValue("x_sep_kodejeniskepesertaan"));
		}
		if (!$this->sep_namajeniskepesertaan->FldIsDetailKey) {
			$this->sep_namajeniskepesertaan->setFormValue($objForm->GetValue("x_sep_namajeniskepesertaan"));
		}
		if (!$this->sep_nokabpjs->FldIsDetailKey) {
			$this->sep_nokabpjs->setFormValue($objForm->GetValue("x_sep_nokabpjs"));
		}
		if (!$this->sep_status_peserta->FldIsDetailKey) {
			$this->sep_status_peserta->setFormValue($objForm->GetValue("x_sep_status_peserta"));
		}
		if (!$this->sep_umur_pasien_sekarang->FldIsDetailKey) {
			$this->sep_umur_pasien_sekarang->setFormValue($objForm->GetValue("x_sep_umur_pasien_sekarang"));
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
		$this->ket_jeniskelamin->CurrentValue = $this->ket_jeniskelamin->FormValue;
		$this->ket_title->CurrentValue = $this->ket_title->FormValue;
		$this->dokterpengirim->CurrentValue = $this->dokterpengirim->FormValue;
		$this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
		$this->kirimdari->CurrentValue = $this->kirimdari->FormValue;
		$this->keluargadekat->CurrentValue = $this->keluargadekat->FormValue;
		$this->panggungjawab->CurrentValue = $this->panggungjawab->FormValue;
		$this->masukrs->CurrentValue = $this->masukrs->FormValue;
		$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 0);
		$this->noruang->CurrentValue = $this->noruang->FormValue;
		$this->tempat_tidur_id->CurrentValue = $this->tempat_tidur_id->FormValue;
		$this->nott->CurrentValue = $this->nott->FormValue;
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->dokter_penanggungjawab->CurrentValue = $this->dokter_penanggungjawab->FormValue;
		$this->KELASPERAWATAN_ID->CurrentValue = $this->KELASPERAWATAN_ID->FormValue;
		$this->NO_SKP->CurrentValue = $this->NO_SKP->FormValue;
		$this->sep_tglsep->CurrentValue = $this->sep_tglsep->FormValue;
		$this->sep_tglsep->CurrentValue = ew_UnFormatDateTime($this->sep_tglsep->CurrentValue, 5);
		$this->sep_tglrujuk->CurrentValue = $this->sep_tglrujuk->FormValue;
		$this->sep_tglrujuk->CurrentValue = ew_UnFormatDateTime($this->sep_tglrujuk->CurrentValue, 5);
		$this->sep_kodekelasrawat->CurrentValue = $this->sep_kodekelasrawat->FormValue;
		$this->sep_norujukan->CurrentValue = $this->sep_norujukan->FormValue;
		$this->sep_kodeppkasal->CurrentValue = $this->sep_kodeppkasal->FormValue;
		$this->sep_namappkasal->CurrentValue = $this->sep_namappkasal->FormValue;
		$this->sep_kodeppkpelayanan->CurrentValue = $this->sep_kodeppkpelayanan->FormValue;
		$this->sep_jenisperawatan->CurrentValue = $this->sep_jenisperawatan->FormValue;
		$this->sep_catatan->CurrentValue = $this->sep_catatan->FormValue;
		$this->sep_kodediagnosaawal->CurrentValue = $this->sep_kodediagnosaawal->FormValue;
		$this->sep_namadiagnosaawal->CurrentValue = $this->sep_namadiagnosaawal->FormValue;
		$this->sep_lakalantas->CurrentValue = $this->sep_lakalantas->FormValue;
		$this->sep_lokasilaka->CurrentValue = $this->sep_lokasilaka->FormValue;
		$this->sep_user->CurrentValue = $this->sep_user->FormValue;
		$this->sep_flag_cekpeserta->CurrentValue = $this->sep_flag_cekpeserta->FormValue;
		$this->sep_flag_generatesep->CurrentValue = $this->sep_flag_generatesep->FormValue;
		$this->sep_nik->CurrentValue = $this->sep_nik->FormValue;
		$this->sep_namapeserta->CurrentValue = $this->sep_namapeserta->FormValue;
		$this->sep_jeniskelamin->CurrentValue = $this->sep_jeniskelamin->FormValue;
		$this->sep_pisat->CurrentValue = $this->sep_pisat->FormValue;
		$this->sep_tgllahir->CurrentValue = $this->sep_tgllahir->FormValue;
		$this->sep_kodejeniskepesertaan->CurrentValue = $this->sep_kodejeniskepesertaan->FormValue;
		$this->sep_namajeniskepesertaan->CurrentValue = $this->sep_namajeniskepesertaan->FormValue;
		$this->sep_nokabpjs->CurrentValue = $this->sep_nokabpjs->FormValue;
		$this->sep_status_peserta->CurrentValue = $this->sep_status_peserta->FormValue;
		$this->sep_umur_pasien_sekarang->CurrentValue = $this->sep_umur_pasien_sekarang->FormValue;
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
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->nott->setDbValue($rs->fields('nott'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->sep_tglsep->setDbValue($rs->fields('sep_tglsep'));
		$this->sep_tglrujuk->setDbValue($rs->fields('sep_tglrujuk'));
		$this->sep_kodekelasrawat->setDbValue($rs->fields('sep_kodekelasrawat'));
		$this->sep_norujukan->setDbValue($rs->fields('sep_norujukan'));
		$this->sep_kodeppkasal->setDbValue($rs->fields('sep_kodeppkasal'));
		$this->sep_namappkasal->setDbValue($rs->fields('sep_namappkasal'));
		$this->sep_kodeppkpelayanan->setDbValue($rs->fields('sep_kodeppkpelayanan'));
		$this->sep_jenisperawatan->setDbValue($rs->fields('sep_jenisperawatan'));
		$this->sep_catatan->setDbValue($rs->fields('sep_catatan'));
		$this->sep_kodediagnosaawal->setDbValue($rs->fields('sep_kodediagnosaawal'));
		$this->sep_namadiagnosaawal->setDbValue($rs->fields('sep_namadiagnosaawal'));
		$this->sep_lakalantas->setDbValue($rs->fields('sep_lakalantas'));
		$this->sep_lokasilaka->setDbValue($rs->fields('sep_lokasilaka'));
		$this->sep_user->setDbValue($rs->fields('sep_user'));
		$this->sep_flag_cekpeserta->setDbValue($rs->fields('sep_flag_cekpeserta'));
		$this->sep_flag_generatesep->setDbValue($rs->fields('sep_flag_generatesep'));
		$this->sep_nik->setDbValue($rs->fields('sep_nik'));
		$this->sep_namapeserta->setDbValue($rs->fields('sep_namapeserta'));
		$this->sep_jeniskelamin->setDbValue($rs->fields('sep_jeniskelamin'));
		$this->sep_pisat->setDbValue($rs->fields('sep_pisat'));
		$this->sep_tgllahir->setDbValue($rs->fields('sep_tgllahir'));
		$this->sep_kodejeniskepesertaan->setDbValue($rs->fields('sep_kodejeniskepesertaan'));
		$this->sep_namajeniskepesertaan->setDbValue($rs->fields('sep_namajeniskepesertaan'));
		$this->sep_nokabpjs->setDbValue($rs->fields('sep_nokabpjs'));
		$this->sep_status_peserta->setDbValue($rs->fields('sep_status_peserta'));
		$this->sep_umur_pasien_sekarang->setDbValue($rs->fields('sep_umur_pasien_sekarang'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
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
		$this->ket_jeniskelamin->DbValue = $row['ket_jeniskelamin'];
		$this->ket_title->DbValue = $row['ket_title'];
		$this->dokterpengirim->DbValue = $row['dokterpengirim'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kirimdari->DbValue = $row['kirimdari'];
		$this->keluargadekat->DbValue = $row['keluargadekat'];
		$this->panggungjawab->DbValue = $row['panggungjawab'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->nott->DbValue = $row['nott'];
		$this->NIP->DbValue = $row['NIP'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->sep_tglsep->DbValue = $row['sep_tglsep'];
		$this->sep_tglrujuk->DbValue = $row['sep_tglrujuk'];
		$this->sep_kodekelasrawat->DbValue = $row['sep_kodekelasrawat'];
		$this->sep_norujukan->DbValue = $row['sep_norujukan'];
		$this->sep_kodeppkasal->DbValue = $row['sep_kodeppkasal'];
		$this->sep_namappkasal->DbValue = $row['sep_namappkasal'];
		$this->sep_kodeppkpelayanan->DbValue = $row['sep_kodeppkpelayanan'];
		$this->sep_jenisperawatan->DbValue = $row['sep_jenisperawatan'];
		$this->sep_catatan->DbValue = $row['sep_catatan'];
		$this->sep_kodediagnosaawal->DbValue = $row['sep_kodediagnosaawal'];
		$this->sep_namadiagnosaawal->DbValue = $row['sep_namadiagnosaawal'];
		$this->sep_lakalantas->DbValue = $row['sep_lakalantas'];
		$this->sep_lokasilaka->DbValue = $row['sep_lokasilaka'];
		$this->sep_user->DbValue = $row['sep_user'];
		$this->sep_flag_cekpeserta->DbValue = $row['sep_flag_cekpeserta'];
		$this->sep_flag_generatesep->DbValue = $row['sep_flag_generatesep'];
		$this->sep_nik->DbValue = $row['sep_nik'];
		$this->sep_namapeserta->DbValue = $row['sep_namapeserta'];
		$this->sep_jeniskelamin->DbValue = $row['sep_jeniskelamin'];
		$this->sep_pisat->DbValue = $row['sep_pisat'];
		$this->sep_tgllahir->DbValue = $row['sep_tgllahir'];
		$this->sep_kodejeniskepesertaan->DbValue = $row['sep_kodejeniskepesertaan'];
		$this->sep_namajeniskepesertaan->DbValue = $row['sep_namajeniskepesertaan'];
		$this->sep_nokabpjs->DbValue = $row['sep_nokabpjs'];
		$this->sep_status_peserta->DbValue = $row['sep_status_peserta'];
		$this->sep_umur_pasien_sekarang->DbValue = $row['sep_umur_pasien_sekarang'];
		$this->statuskeluarranap_id->DbValue = $row['statuskeluarranap_id'];
		$this->keluarrs->DbValue = $row['keluarrs'];
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
		// ket_jeniskelamin
		// ket_title
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// nott
		// NIP
		// dokter_penanggungjawab
		// KELASPERAWATAN_ID
		// NO_SKP
		// sep_tglsep
		// sep_tglrujuk
		// sep_kodekelasrawat
		// sep_norujukan
		// sep_kodeppkasal
		// sep_namappkasal
		// sep_kodeppkpelayanan
		// sep_jenisperawatan
		// sep_catatan
		// sep_kodediagnosaawal
		// sep_namadiagnosaawal
		// sep_lakalantas
		// sep_lokasilaka
		// sep_user
		// sep_flag_cekpeserta
		// sep_flag_generatesep
		// sep_nik
		// sep_namapeserta
		// sep_jeniskelamin
		// sep_pisat
		// sep_tgllahir
		// sep_kodejeniskepesertaan
		// sep_namajeniskepesertaan
		// sep_nokabpjs
		// sep_status_peserta
		// sep_umur_pasien_sekarang
		// statuskeluarranap_id
		// keluarrs

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
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

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// dokterpengirim
		$this->dokterpengirim->ViewValue = $this->dokterpengirim->CurrentValue;
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
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
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
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 0);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		$this->noruang->ViewValue = $this->noruang->CurrentValue;
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
		$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->CurrentValue;
		$this->tempat_tidur_id->ViewCustomAttributes = "";

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->CurrentValue;
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

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// sep_tglsep
		$this->sep_tglsep->ViewValue = $this->sep_tglsep->CurrentValue;
		$this->sep_tglsep->ViewValue = ew_FormatDateTime($this->sep_tglsep->ViewValue, 5);
		$this->sep_tglsep->ViewCustomAttributes = "";

		// sep_tglrujuk
		$this->sep_tglrujuk->ViewValue = $this->sep_tglrujuk->CurrentValue;
		$this->sep_tglrujuk->ViewValue = ew_FormatDateTime($this->sep_tglrujuk->ViewValue, 5);
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

		// sep_jenisperawatan
		$this->sep_jenisperawatan->ViewValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_jenisperawatan->ViewCustomAttributes = "";

		// sep_catatan
		$this->sep_catatan->ViewValue = $this->sep_catatan->CurrentValue;
		$this->sep_catatan->ViewCustomAttributes = "";

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
		if (strval($this->sep_kodediagnosaawal->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->sep_kodediagnosaawal->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
		$sWhereWrk = "";
		$this->sep_kodediagnosaawal->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sep_kodediagnosaawal, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
			}
		} else {
			$this->sep_kodediagnosaawal->ViewValue = NULL;
		}
		$this->sep_kodediagnosaawal->ViewCustomAttributes = "";

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->ViewValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->ViewCustomAttributes = "";

		// sep_lakalantas
		if (strval($this->sep_lakalantas->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sep_lakalantas->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_lakalantas`";
		$sWhereWrk = "";
		$this->sep_lakalantas->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sep_lakalantas, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->CurrentValue;
			}
		} else {
			$this->sep_lakalantas->ViewValue = NULL;
		}
		$this->sep_lakalantas->ViewCustomAttributes = "";

		// sep_lokasilaka
		$this->sep_lokasilaka->ViewValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_lokasilaka->ViewCustomAttributes = "";

		// sep_user
		$this->sep_user->ViewValue = $this->sep_user->CurrentValue;
		$this->sep_user->ViewCustomAttributes = "";

		// sep_flag_cekpeserta
		if (strval($this->sep_flag_cekpeserta->CurrentValue) <> "") {
			$this->sep_flag_cekpeserta->ViewValue = "";
			$arwrk = explode(",", strval($this->sep_flag_cekpeserta->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->sep_flag_cekpeserta->ViewValue .= $this->sep_flag_cekpeserta->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->sep_flag_cekpeserta->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->sep_flag_cekpeserta->ViewValue = NULL;
		}
		$this->sep_flag_cekpeserta->ViewCustomAttributes = "";

		// sep_flag_generatesep
		if (strval($this->sep_flag_generatesep->CurrentValue) <> "") {
			$this->sep_flag_generatesep->ViewValue = "";
			$arwrk = explode(",", strval($this->sep_flag_generatesep->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->sep_flag_generatesep->ViewValue .= $this->sep_flag_generatesep->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->sep_flag_generatesep->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->sep_flag_generatesep->ViewValue = NULL;
		}
		$this->sep_flag_generatesep->ViewCustomAttributes = "";

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

		// sep_nokabpjs
		$this->sep_nokabpjs->ViewValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->ViewCustomAttributes = "";

		// sep_status_peserta
		$this->sep_status_peserta->ViewValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_status_peserta->ViewCustomAttributes = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->ViewValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->sep_umur_pasien_sekarang->ViewCustomAttributes = "";

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

			// ket_jeniskelamin
			$this->ket_jeniskelamin->LinkCustomAttributes = "";
			$this->ket_jeniskelamin->HrefValue = "";
			$this->ket_jeniskelamin->TooltipValue = "";

			// ket_title
			$this->ket_title->LinkCustomAttributes = "";
			$this->ket_title->HrefValue = "";
			$this->ket_title->TooltipValue = "";

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

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";
			$this->dokter_penanggungjawab->TooltipValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// NO_SKP
			$this->NO_SKP->LinkCustomAttributes = "";
			$this->NO_SKP->HrefValue = "";
			$this->NO_SKP->TooltipValue = "";

			// sep_tglsep
			$this->sep_tglsep->LinkCustomAttributes = "";
			$this->sep_tglsep->HrefValue = "";
			$this->sep_tglsep->TooltipValue = "";

			// sep_tglrujuk
			$this->sep_tglrujuk->LinkCustomAttributes = "";
			$this->sep_tglrujuk->HrefValue = "";
			$this->sep_tglrujuk->TooltipValue = "";

			// sep_kodekelasrawat
			$this->sep_kodekelasrawat->LinkCustomAttributes = "";
			$this->sep_kodekelasrawat->HrefValue = "";
			$this->sep_kodekelasrawat->TooltipValue = "";

			// sep_norujukan
			$this->sep_norujukan->LinkCustomAttributes = "";
			$this->sep_norujukan->HrefValue = "";
			$this->sep_norujukan->TooltipValue = "";

			// sep_kodeppkasal
			$this->sep_kodeppkasal->LinkCustomAttributes = "";
			$this->sep_kodeppkasal->HrefValue = "";
			$this->sep_kodeppkasal->TooltipValue = "";

			// sep_namappkasal
			$this->sep_namappkasal->LinkCustomAttributes = "";
			$this->sep_namappkasal->HrefValue = "";
			$this->sep_namappkasal->TooltipValue = "";

			// sep_kodeppkpelayanan
			$this->sep_kodeppkpelayanan->LinkCustomAttributes = "";
			$this->sep_kodeppkpelayanan->HrefValue = "";
			$this->sep_kodeppkpelayanan->TooltipValue = "";

			// sep_jenisperawatan
			$this->sep_jenisperawatan->LinkCustomAttributes = "";
			$this->sep_jenisperawatan->HrefValue = "";
			$this->sep_jenisperawatan->TooltipValue = "";

			// sep_catatan
			$this->sep_catatan->LinkCustomAttributes = "";
			$this->sep_catatan->HrefValue = "";
			$this->sep_catatan->TooltipValue = "";

			// sep_kodediagnosaawal
			$this->sep_kodediagnosaawal->LinkCustomAttributes = "";
			$this->sep_kodediagnosaawal->HrefValue = "";
			$this->sep_kodediagnosaawal->TooltipValue = "";

			// sep_namadiagnosaawal
			$this->sep_namadiagnosaawal->LinkCustomAttributes = "";
			$this->sep_namadiagnosaawal->HrefValue = "";
			$this->sep_namadiagnosaawal->TooltipValue = "";

			// sep_lakalantas
			$this->sep_lakalantas->LinkCustomAttributes = "";
			$this->sep_lakalantas->HrefValue = "";
			$this->sep_lakalantas->TooltipValue = "";

			// sep_lokasilaka
			$this->sep_lokasilaka->LinkCustomAttributes = "";
			$this->sep_lokasilaka->HrefValue = "";
			$this->sep_lokasilaka->TooltipValue = "";

			// sep_user
			$this->sep_user->LinkCustomAttributes = "";
			$this->sep_user->HrefValue = "";
			$this->sep_user->TooltipValue = "";

			// sep_flag_cekpeserta
			$this->sep_flag_cekpeserta->LinkCustomAttributes = "";
			$this->sep_flag_cekpeserta->HrefValue = "";
			$this->sep_flag_cekpeserta->TooltipValue = "";

			// sep_flag_generatesep
			$this->sep_flag_generatesep->LinkCustomAttributes = "";
			$this->sep_flag_generatesep->HrefValue = "";
			$this->sep_flag_generatesep->TooltipValue = "";

			// sep_nik
			$this->sep_nik->LinkCustomAttributes = "";
			$this->sep_nik->HrefValue = "";
			$this->sep_nik->TooltipValue = "";

			// sep_namapeserta
			$this->sep_namapeserta->LinkCustomAttributes = "";
			$this->sep_namapeserta->HrefValue = "";
			$this->sep_namapeserta->TooltipValue = "";

			// sep_jeniskelamin
			$this->sep_jeniskelamin->LinkCustomAttributes = "";
			$this->sep_jeniskelamin->HrefValue = "";
			$this->sep_jeniskelamin->TooltipValue = "";

			// sep_pisat
			$this->sep_pisat->LinkCustomAttributes = "";
			$this->sep_pisat->HrefValue = "";
			$this->sep_pisat->TooltipValue = "";

			// sep_tgllahir
			$this->sep_tgllahir->LinkCustomAttributes = "";
			$this->sep_tgllahir->HrefValue = "";
			$this->sep_tgllahir->TooltipValue = "";

			// sep_kodejeniskepesertaan
			$this->sep_kodejeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_kodejeniskepesertaan->HrefValue = "";
			$this->sep_kodejeniskepesertaan->TooltipValue = "";

			// sep_namajeniskepesertaan
			$this->sep_namajeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_namajeniskepesertaan->HrefValue = "";
			$this->sep_namajeniskepesertaan->TooltipValue = "";

			// sep_nokabpjs
			$this->sep_nokabpjs->LinkCustomAttributes = "";
			$this->sep_nokabpjs->HrefValue = "";
			$this->sep_nokabpjs->TooltipValue = "";

			// sep_status_peserta
			$this->sep_status_peserta->LinkCustomAttributes = "";
			$this->sep_status_peserta->HrefValue = "";
			$this->sep_status_peserta->TooltipValue = "";

			// sep_umur_pasien_sekarang
			$this->sep_umur_pasien_sekarang->LinkCustomAttributes = "";
			$this->sep_umur_pasien_sekarang->HrefValue = "";
			$this->sep_umur_pasien_sekarang->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
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

			// dokterpengirim
			$this->dokterpengirim->EditAttrs["class"] = "form-control";
			$this->dokterpengirim->EditCustomAttributes = "";
			$this->dokterpengirim->EditValue = ew_HtmlEncode($this->dokterpengirim->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->dokterpengirim->EditValue = $this->dokterpengirim->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->dokterpengirim->EditValue = ew_HtmlEncode($this->dokterpengirim->CurrentValue);
				}
			} else {
				$this->dokterpengirim->EditValue = NULL;
			}
			$this->dokterpengirim->PlaceHolder = ew_RemoveHtml($this->dokterpengirim->FldCaption());

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			$this->statusbayar->EditValue = ew_HtmlEncode($this->statusbayar->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->statusbayar->EditValue = $this->statusbayar->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->statusbayar->EditValue = ew_HtmlEncode($this->statusbayar->CurrentValue);
				}
			} else {
				$this->statusbayar->EditValue = NULL;
			}
			$this->statusbayar->PlaceHolder = ew_RemoveHtml($this->statusbayar->FldCaption());

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
			$this->masukrs->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->masukrs->CurrentValue, 8));
			$this->masukrs->PlaceHolder = ew_RemoveHtml($this->masukrs->FldCaption());

			// noruang
			$this->noruang->EditAttrs["class"] = "form-control";
			$this->noruang->EditCustomAttributes = "";
			$this->noruang->EditValue = ew_HtmlEncode($this->noruang->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->noruang->EditValue = $this->noruang->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->noruang->EditValue = ew_HtmlEncode($this->noruang->CurrentValue);
				}
			} else {
				$this->noruang->EditValue = NULL;
			}
			$this->noruang->PlaceHolder = ew_RemoveHtml($this->noruang->FldCaption());

			// tempat_tidur_id
			$this->tempat_tidur_id->EditAttrs["class"] = "form-control";
			$this->tempat_tidur_id->EditCustomAttributes = "";
			$this->tempat_tidur_id->EditValue = ew_HtmlEncode($this->tempat_tidur_id->CurrentValue);
			$this->tempat_tidur_id->PlaceHolder = ew_RemoveHtml($this->tempat_tidur_id->FldCaption());

			// nott
			$this->nott->EditAttrs["class"] = "form-control";
			$this->nott->EditCustomAttributes = "";
			$this->nott->EditValue = ew_HtmlEncode($this->nott->CurrentValue);
			$this->nott->PlaceHolder = ew_RemoveHtml($this->nott->FldCaption());

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = ew_HtmlEncode($this->NIP->CurrentValue);
			$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->EditAttrs["class"] = "form-control";
			$this->dokter_penanggungjawab->EditCustomAttributes = "";
			$this->dokter_penanggungjawab->EditValue = ew_HtmlEncode($this->dokter_penanggungjawab->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->dokter_penanggungjawab->EditValue = $this->dokter_penanggungjawab->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->dokter_penanggungjawab->EditValue = ew_HtmlEncode($this->dokter_penanggungjawab->CurrentValue);
				}
			} else {
				$this->dokter_penanggungjawab->EditValue = NULL;
			}
			$this->dokter_penanggungjawab->PlaceHolder = ew_RemoveHtml($this->dokter_penanggungjawab->FldCaption());

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->EditAttrs["class"] = "form-control";
			$this->KELASPERAWATAN_ID->EditCustomAttributes = "";
			$this->KELASPERAWATAN_ID->EditValue = ew_HtmlEncode($this->KELASPERAWATAN_ID->CurrentValue);
			$this->KELASPERAWATAN_ID->PlaceHolder = ew_RemoveHtml($this->KELASPERAWATAN_ID->FldCaption());

			// NO_SKP
			$this->NO_SKP->EditAttrs["class"] = "form-control";
			$this->NO_SKP->EditCustomAttributes = "";
			$this->NO_SKP->EditValue = ew_HtmlEncode($this->NO_SKP->CurrentValue);
			$this->NO_SKP->PlaceHolder = ew_RemoveHtml($this->NO_SKP->FldCaption());

			// sep_tglsep
			$this->sep_tglsep->EditAttrs["class"] = "form-control";
			$this->sep_tglsep->EditCustomAttributes = "";
			$this->sep_tglsep->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sep_tglsep->CurrentValue, 5));
			$this->sep_tglsep->PlaceHolder = ew_RemoveHtml($this->sep_tglsep->FldCaption());

			// sep_tglrujuk
			$this->sep_tglrujuk->EditAttrs["class"] = "form-control";
			$this->sep_tglrujuk->EditCustomAttributes = "";
			$this->sep_tglrujuk->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sep_tglrujuk->CurrentValue, 5));
			$this->sep_tglrujuk->PlaceHolder = ew_RemoveHtml($this->sep_tglrujuk->FldCaption());

			// sep_kodekelasrawat
			$this->sep_kodekelasrawat->EditAttrs["class"] = "form-control";
			$this->sep_kodekelasrawat->EditCustomAttributes = "";
			$this->sep_kodekelasrawat->EditValue = ew_HtmlEncode($this->sep_kodekelasrawat->CurrentValue);
			$this->sep_kodekelasrawat->PlaceHolder = ew_RemoveHtml($this->sep_kodekelasrawat->FldCaption());

			// sep_norujukan
			$this->sep_norujukan->EditAttrs["class"] = "form-control";
			$this->sep_norujukan->EditCustomAttributes = "";
			$this->sep_norujukan->EditValue = ew_HtmlEncode($this->sep_norujukan->CurrentValue);
			$this->sep_norujukan->PlaceHolder = ew_RemoveHtml($this->sep_norujukan->FldCaption());

			// sep_kodeppkasal
			$this->sep_kodeppkasal->EditAttrs["class"] = "form-control";
			$this->sep_kodeppkasal->EditCustomAttributes = "";
			$this->sep_kodeppkasal->EditValue = ew_HtmlEncode($this->sep_kodeppkasal->CurrentValue);
			$this->sep_kodeppkasal->PlaceHolder = ew_RemoveHtml($this->sep_kodeppkasal->FldCaption());

			// sep_namappkasal
			$this->sep_namappkasal->EditAttrs["class"] = "form-control";
			$this->sep_namappkasal->EditCustomAttributes = "";
			$this->sep_namappkasal->EditValue = ew_HtmlEncode($this->sep_namappkasal->CurrentValue);
			$this->sep_namappkasal->PlaceHolder = ew_RemoveHtml($this->sep_namappkasal->FldCaption());

			// sep_kodeppkpelayanan
			$this->sep_kodeppkpelayanan->EditAttrs["class"] = "form-control";
			$this->sep_kodeppkpelayanan->EditCustomAttributes = "";
			$this->sep_kodeppkpelayanan->EditValue = ew_HtmlEncode($this->sep_kodeppkpelayanan->CurrentValue);
			$this->sep_kodeppkpelayanan->PlaceHolder = ew_RemoveHtml($this->sep_kodeppkpelayanan->FldCaption());

			// sep_jenisperawatan
			$this->sep_jenisperawatan->EditAttrs["class"] = "form-control";
			$this->sep_jenisperawatan->EditCustomAttributes = "";
			$this->sep_jenisperawatan->EditValue = ew_HtmlEncode($this->sep_jenisperawatan->CurrentValue);
			$this->sep_jenisperawatan->PlaceHolder = ew_RemoveHtml($this->sep_jenisperawatan->FldCaption());

			// sep_catatan
			$this->sep_catatan->EditAttrs["class"] = "form-control";
			$this->sep_catatan->EditCustomAttributes = "";
			$this->sep_catatan->EditValue = ew_HtmlEncode($this->sep_catatan->CurrentValue);
			$this->sep_catatan->PlaceHolder = ew_RemoveHtml($this->sep_catatan->FldCaption());

			// sep_kodediagnosaawal
			$this->sep_kodediagnosaawal->EditAttrs["class"] = "form-control";
			$this->sep_kodediagnosaawal->EditCustomAttributes = "";
			$this->sep_kodediagnosaawal->EditValue = ew_HtmlEncode($this->sep_kodediagnosaawal->CurrentValue);
			if (strval($this->sep_kodediagnosaawal->CurrentValue) <> "") {
				$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->sep_kodediagnosaawal->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "";
			$this->sep_kodediagnosaawal->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sep_kodediagnosaawal, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->sep_kodediagnosaawal->EditValue = $this->sep_kodediagnosaawal->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->sep_kodediagnosaawal->EditValue = ew_HtmlEncode($this->sep_kodediagnosaawal->CurrentValue);
				}
			} else {
				$this->sep_kodediagnosaawal->EditValue = NULL;
			}
			$this->sep_kodediagnosaawal->PlaceHolder = ew_RemoveHtml($this->sep_kodediagnosaawal->FldCaption());

			// sep_namadiagnosaawal
			$this->sep_namadiagnosaawal->EditAttrs["class"] = "form-control";
			$this->sep_namadiagnosaawal->EditCustomAttributes = "";
			$this->sep_namadiagnosaawal->EditValue = ew_HtmlEncode($this->sep_namadiagnosaawal->CurrentValue);
			$this->sep_namadiagnosaawal->PlaceHolder = ew_RemoveHtml($this->sep_namadiagnosaawal->FldCaption());

			// sep_lakalantas
			$this->sep_lakalantas->EditCustomAttributes = "";
			if (trim(strval($this->sep_lakalantas->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->sep_lakalantas->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_lakalantas`";
			$sWhereWrk = "";
			$this->sep_lakalantas->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->sep_lakalantas, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->sep_lakalantas->EditValue = $arwrk;

			// sep_lokasilaka
			$this->sep_lokasilaka->EditAttrs["class"] = "form-control";
			$this->sep_lokasilaka->EditCustomAttributes = "";
			$this->sep_lokasilaka->EditValue = ew_HtmlEncode($this->sep_lokasilaka->CurrentValue);
			$this->sep_lokasilaka->PlaceHolder = ew_RemoveHtml($this->sep_lokasilaka->FldCaption());

			// sep_user
			$this->sep_user->EditAttrs["class"] = "form-control";
			$this->sep_user->EditCustomAttributes = "";
			$this->sep_user->EditValue = ew_HtmlEncode($this->sep_user->CurrentValue);
			$this->sep_user->PlaceHolder = ew_RemoveHtml($this->sep_user->FldCaption());

			// sep_flag_cekpeserta
			$this->sep_flag_cekpeserta->EditCustomAttributes = "";
			$this->sep_flag_cekpeserta->EditValue = $this->sep_flag_cekpeserta->Options(FALSE);

			// sep_flag_generatesep
			$this->sep_flag_generatesep->EditCustomAttributes = "";
			$this->sep_flag_generatesep->EditValue = $this->sep_flag_generatesep->Options(FALSE);

			// sep_nik
			$this->sep_nik->EditAttrs["class"] = "form-control";
			$this->sep_nik->EditCustomAttributes = "";
			$this->sep_nik->EditValue = ew_HtmlEncode($this->sep_nik->CurrentValue);
			$this->sep_nik->PlaceHolder = ew_RemoveHtml($this->sep_nik->FldCaption());

			// sep_namapeserta
			$this->sep_namapeserta->EditAttrs["class"] = "form-control";
			$this->sep_namapeserta->EditCustomAttributes = "";
			$this->sep_namapeserta->EditValue = ew_HtmlEncode($this->sep_namapeserta->CurrentValue);
			$this->sep_namapeserta->PlaceHolder = ew_RemoveHtml($this->sep_namapeserta->FldCaption());

			// sep_jeniskelamin
			$this->sep_jeniskelamin->EditAttrs["class"] = "form-control";
			$this->sep_jeniskelamin->EditCustomAttributes = "";
			$this->sep_jeniskelamin->EditValue = ew_HtmlEncode($this->sep_jeniskelamin->CurrentValue);
			$this->sep_jeniskelamin->PlaceHolder = ew_RemoveHtml($this->sep_jeniskelamin->FldCaption());

			// sep_pisat
			$this->sep_pisat->EditAttrs["class"] = "form-control";
			$this->sep_pisat->EditCustomAttributes = "";
			$this->sep_pisat->EditValue = ew_HtmlEncode($this->sep_pisat->CurrentValue);
			$this->sep_pisat->PlaceHolder = ew_RemoveHtml($this->sep_pisat->FldCaption());

			// sep_tgllahir
			$this->sep_tgllahir->EditAttrs["class"] = "form-control";
			$this->sep_tgllahir->EditCustomAttributes = "";
			$this->sep_tgllahir->EditValue = ew_HtmlEncode($this->sep_tgllahir->CurrentValue);
			$this->sep_tgllahir->PlaceHolder = ew_RemoveHtml($this->sep_tgllahir->FldCaption());

			// sep_kodejeniskepesertaan
			$this->sep_kodejeniskepesertaan->EditAttrs["class"] = "form-control";
			$this->sep_kodejeniskepesertaan->EditCustomAttributes = "";
			$this->sep_kodejeniskepesertaan->EditValue = ew_HtmlEncode($this->sep_kodejeniskepesertaan->CurrentValue);
			$this->sep_kodejeniskepesertaan->PlaceHolder = ew_RemoveHtml($this->sep_kodejeniskepesertaan->FldCaption());

			// sep_namajeniskepesertaan
			$this->sep_namajeniskepesertaan->EditAttrs["class"] = "form-control";
			$this->sep_namajeniskepesertaan->EditCustomAttributes = "";
			$this->sep_namajeniskepesertaan->EditValue = ew_HtmlEncode($this->sep_namajeniskepesertaan->CurrentValue);
			$this->sep_namajeniskepesertaan->PlaceHolder = ew_RemoveHtml($this->sep_namajeniskepesertaan->FldCaption());

			// sep_nokabpjs
			$this->sep_nokabpjs->EditAttrs["class"] = "form-control";
			$this->sep_nokabpjs->EditCustomAttributes = "";
			$this->sep_nokabpjs->EditValue = ew_HtmlEncode($this->sep_nokabpjs->CurrentValue);
			$this->sep_nokabpjs->PlaceHolder = ew_RemoveHtml($this->sep_nokabpjs->FldCaption());

			// sep_status_peserta
			$this->sep_status_peserta->EditAttrs["class"] = "form-control";
			$this->sep_status_peserta->EditCustomAttributes = "";
			$this->sep_status_peserta->EditValue = ew_HtmlEncode($this->sep_status_peserta->CurrentValue);
			$this->sep_status_peserta->PlaceHolder = ew_RemoveHtml($this->sep_status_peserta->FldCaption());

			// sep_umur_pasien_sekarang
			$this->sep_umur_pasien_sekarang->EditAttrs["class"] = "form-control";
			$this->sep_umur_pasien_sekarang->EditCustomAttributes = "";
			$this->sep_umur_pasien_sekarang->EditValue = ew_HtmlEncode($this->sep_umur_pasien_sekarang->CurrentValue);
			$this->sep_umur_pasien_sekarang->PlaceHolder = ew_RemoveHtml($this->sep_umur_pasien_sekarang->FldCaption());

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

			// ket_jeniskelamin
			$this->ket_jeniskelamin->LinkCustomAttributes = "";
			$this->ket_jeniskelamin->HrefValue = "";

			// ket_title
			$this->ket_title->LinkCustomAttributes = "";
			$this->ket_title->HrefValue = "";

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

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";

			// NO_SKP
			$this->NO_SKP->LinkCustomAttributes = "";
			$this->NO_SKP->HrefValue = "";

			// sep_tglsep
			$this->sep_tglsep->LinkCustomAttributes = "";
			$this->sep_tglsep->HrefValue = "";

			// sep_tglrujuk
			$this->sep_tglrujuk->LinkCustomAttributes = "";
			$this->sep_tglrujuk->HrefValue = "";

			// sep_kodekelasrawat
			$this->sep_kodekelasrawat->LinkCustomAttributes = "";
			$this->sep_kodekelasrawat->HrefValue = "";

			// sep_norujukan
			$this->sep_norujukan->LinkCustomAttributes = "";
			$this->sep_norujukan->HrefValue = "";

			// sep_kodeppkasal
			$this->sep_kodeppkasal->LinkCustomAttributes = "";
			$this->sep_kodeppkasal->HrefValue = "";

			// sep_namappkasal
			$this->sep_namappkasal->LinkCustomAttributes = "";
			$this->sep_namappkasal->HrefValue = "";

			// sep_kodeppkpelayanan
			$this->sep_kodeppkpelayanan->LinkCustomAttributes = "";
			$this->sep_kodeppkpelayanan->HrefValue = "";

			// sep_jenisperawatan
			$this->sep_jenisperawatan->LinkCustomAttributes = "";
			$this->sep_jenisperawatan->HrefValue = "";

			// sep_catatan
			$this->sep_catatan->LinkCustomAttributes = "";
			$this->sep_catatan->HrefValue = "";

			// sep_kodediagnosaawal
			$this->sep_kodediagnosaawal->LinkCustomAttributes = "";
			$this->sep_kodediagnosaawal->HrefValue = "";

			// sep_namadiagnosaawal
			$this->sep_namadiagnosaawal->LinkCustomAttributes = "";
			$this->sep_namadiagnosaawal->HrefValue = "";

			// sep_lakalantas
			$this->sep_lakalantas->LinkCustomAttributes = "";
			$this->sep_lakalantas->HrefValue = "";

			// sep_lokasilaka
			$this->sep_lokasilaka->LinkCustomAttributes = "";
			$this->sep_lokasilaka->HrefValue = "";

			// sep_user
			$this->sep_user->LinkCustomAttributes = "";
			$this->sep_user->HrefValue = "";

			// sep_flag_cekpeserta
			$this->sep_flag_cekpeserta->LinkCustomAttributes = "";
			$this->sep_flag_cekpeserta->HrefValue = "";

			// sep_flag_generatesep
			$this->sep_flag_generatesep->LinkCustomAttributes = "";
			$this->sep_flag_generatesep->HrefValue = "";

			// sep_nik
			$this->sep_nik->LinkCustomAttributes = "";
			$this->sep_nik->HrefValue = "";

			// sep_namapeserta
			$this->sep_namapeserta->LinkCustomAttributes = "";
			$this->sep_namapeserta->HrefValue = "";

			// sep_jeniskelamin
			$this->sep_jeniskelamin->LinkCustomAttributes = "";
			$this->sep_jeniskelamin->HrefValue = "";

			// sep_pisat
			$this->sep_pisat->LinkCustomAttributes = "";
			$this->sep_pisat->HrefValue = "";

			// sep_tgllahir
			$this->sep_tgllahir->LinkCustomAttributes = "";
			$this->sep_tgllahir->HrefValue = "";

			// sep_kodejeniskepesertaan
			$this->sep_kodejeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_kodejeniskepesertaan->HrefValue = "";

			// sep_namajeniskepesertaan
			$this->sep_namajeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_namajeniskepesertaan->HrefValue = "";

			// sep_nokabpjs
			$this->sep_nokabpjs->LinkCustomAttributes = "";
			$this->sep_nokabpjs->HrefValue = "";

			// sep_status_peserta
			$this->sep_status_peserta->LinkCustomAttributes = "";
			$this->sep_status_peserta->HrefValue = "";

			// sep_umur_pasien_sekarang
			$this->sep_umur_pasien_sekarang->LinkCustomAttributes = "";
			$this->sep_umur_pasien_sekarang->HrefValue = "";
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
		if (!ew_CheckInteger($this->dokterpengirim->FormValue)) {
			ew_AddMessage($gsFormError, $this->dokterpengirim->FldErrMsg());
		}
		if (!$this->statusbayar->FldIsDetailKey && !is_null($this->statusbayar->FormValue) && $this->statusbayar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->statusbayar->FldCaption(), $this->statusbayar->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->statusbayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->statusbayar->FldErrMsg());
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
		if (!ew_CheckDateDef($this->masukrs->FormValue)) {
			ew_AddMessage($gsFormError, $this->masukrs->FldErrMsg());
		}
		if (!$this->noruang->FldIsDetailKey && !is_null($this->noruang->FormValue) && $this->noruang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->noruang->FldCaption(), $this->noruang->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->noruang->FormValue)) {
			ew_AddMessage($gsFormError, $this->noruang->FldErrMsg());
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey && !is_null($this->tempat_tidur_id->FormValue) && $this->tempat_tidur_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tempat_tidur_id->FldCaption(), $this->tempat_tidur_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->tempat_tidur_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->tempat_tidur_id->FldErrMsg());
		}
		if (!$this->nott->FldIsDetailKey && !is_null($this->nott->FormValue) && $this->nott->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nott->FldCaption(), $this->nott->ReqErrMsg));
		}
		if (!$this->NIP->FldIsDetailKey && !is_null($this->NIP->FormValue) && $this->NIP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NIP->FldCaption(), $this->NIP->ReqErrMsg));
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey && !is_null($this->dokter_penanggungjawab->FormValue) && $this->dokter_penanggungjawab->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dokter_penanggungjawab->FldCaption(), $this->dokter_penanggungjawab->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->dokter_penanggungjawab->FormValue)) {
			ew_AddMessage($gsFormError, $this->dokter_penanggungjawab->FldErrMsg());
		}
		if (!ew_CheckInteger($this->KELASPERAWATAN_ID->FormValue)) {
			ew_AddMessage($gsFormError, $this->KELASPERAWATAN_ID->FldErrMsg());
		}
		if (!ew_CheckDate($this->sep_tglsep->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_tglsep->FldErrMsg());
		}
		if (!ew_CheckDate($this->sep_tglrujuk->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_tglrujuk->FldErrMsg());
		}
		if (!ew_CheckInteger($this->sep_jenisperawatan->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_jenisperawatan->FldErrMsg());
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

			// ket_jeniskelamin
			$this->ket_jeniskelamin->SetDbValueDef($rsnew, $this->ket_jeniskelamin->CurrentValue, NULL, $this->ket_jeniskelamin->ReadOnly);

			// ket_title
			$this->ket_title->SetDbValueDef($rsnew, $this->ket_title->CurrentValue, NULL, $this->ket_title->ReadOnly);

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
			$this->masukrs->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->masukrs->CurrentValue, 0), NULL, $this->masukrs->ReadOnly);

			// noruang
			$this->noruang->SetDbValueDef($rsnew, $this->noruang->CurrentValue, 0, $this->noruang->ReadOnly);

			// tempat_tidur_id
			$this->tempat_tidur_id->SetDbValueDef($rsnew, $this->tempat_tidur_id->CurrentValue, 0, $this->tempat_tidur_id->ReadOnly);

			// nott
			$this->nott->SetDbValueDef($rsnew, $this->nott->CurrentValue, "", $this->nott->ReadOnly);

			// NIP
			$this->NIP->SetDbValueDef($rsnew, $this->NIP->CurrentValue, "", $this->NIP->ReadOnly);

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->SetDbValueDef($rsnew, $this->dokter_penanggungjawab->CurrentValue, 0, $this->dokter_penanggungjawab->ReadOnly);

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->SetDbValueDef($rsnew, $this->KELASPERAWATAN_ID->CurrentValue, NULL, $this->KELASPERAWATAN_ID->ReadOnly);

			// NO_SKP
			$this->NO_SKP->SetDbValueDef($rsnew, $this->NO_SKP->CurrentValue, NULL, $this->NO_SKP->ReadOnly);

			// sep_tglsep
			$this->sep_tglsep->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sep_tglsep->CurrentValue, 5), NULL, $this->sep_tglsep->ReadOnly);

			// sep_tglrujuk
			$this->sep_tglrujuk->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sep_tglrujuk->CurrentValue, 5), NULL, $this->sep_tglrujuk->ReadOnly);

			// sep_kodekelasrawat
			$this->sep_kodekelasrawat->SetDbValueDef($rsnew, $this->sep_kodekelasrawat->CurrentValue, NULL, $this->sep_kodekelasrawat->ReadOnly);

			// sep_norujukan
			$this->sep_norujukan->SetDbValueDef($rsnew, $this->sep_norujukan->CurrentValue, NULL, $this->sep_norujukan->ReadOnly);

			// sep_kodeppkasal
			$this->sep_kodeppkasal->SetDbValueDef($rsnew, $this->sep_kodeppkasal->CurrentValue, NULL, $this->sep_kodeppkasal->ReadOnly);

			// sep_namappkasal
			$this->sep_namappkasal->SetDbValueDef($rsnew, $this->sep_namappkasal->CurrentValue, NULL, $this->sep_namappkasal->ReadOnly);

			// sep_kodeppkpelayanan
			$this->sep_kodeppkpelayanan->SetDbValueDef($rsnew, $this->sep_kodeppkpelayanan->CurrentValue, NULL, $this->sep_kodeppkpelayanan->ReadOnly);

			// sep_jenisperawatan
			$this->sep_jenisperawatan->SetDbValueDef($rsnew, $this->sep_jenisperawatan->CurrentValue, NULL, $this->sep_jenisperawatan->ReadOnly);

			// sep_catatan
			$this->sep_catatan->SetDbValueDef($rsnew, $this->sep_catatan->CurrentValue, NULL, $this->sep_catatan->ReadOnly);

			// sep_kodediagnosaawal
			$this->sep_kodediagnosaawal->SetDbValueDef($rsnew, $this->sep_kodediagnosaawal->CurrentValue, NULL, $this->sep_kodediagnosaawal->ReadOnly);

			// sep_namadiagnosaawal
			$this->sep_namadiagnosaawal->SetDbValueDef($rsnew, $this->sep_namadiagnosaawal->CurrentValue, NULL, $this->sep_namadiagnosaawal->ReadOnly);

			// sep_lakalantas
			$this->sep_lakalantas->SetDbValueDef($rsnew, $this->sep_lakalantas->CurrentValue, NULL, $this->sep_lakalantas->ReadOnly);

			// sep_lokasilaka
			$this->sep_lokasilaka->SetDbValueDef($rsnew, $this->sep_lokasilaka->CurrentValue, NULL, $this->sep_lokasilaka->ReadOnly);

			// sep_user
			$this->sep_user->SetDbValueDef($rsnew, $this->sep_user->CurrentValue, NULL, $this->sep_user->ReadOnly);

			// sep_flag_cekpeserta
			$this->sep_flag_cekpeserta->SetDbValueDef($rsnew, $this->sep_flag_cekpeserta->CurrentValue, NULL, $this->sep_flag_cekpeserta->ReadOnly);

			// sep_flag_generatesep
			$this->sep_flag_generatesep->SetDbValueDef($rsnew, $this->sep_flag_generatesep->CurrentValue, NULL, $this->sep_flag_generatesep->ReadOnly);

			// sep_nik
			$this->sep_nik->SetDbValueDef($rsnew, $this->sep_nik->CurrentValue, NULL, $this->sep_nik->ReadOnly);

			// sep_namapeserta
			$this->sep_namapeserta->SetDbValueDef($rsnew, $this->sep_namapeserta->CurrentValue, NULL, $this->sep_namapeserta->ReadOnly);

			// sep_jeniskelamin
			$this->sep_jeniskelamin->SetDbValueDef($rsnew, $this->sep_jeniskelamin->CurrentValue, NULL, $this->sep_jeniskelamin->ReadOnly);

			// sep_pisat
			$this->sep_pisat->SetDbValueDef($rsnew, $this->sep_pisat->CurrentValue, NULL, $this->sep_pisat->ReadOnly);

			// sep_tgllahir
			$this->sep_tgllahir->SetDbValueDef($rsnew, $this->sep_tgllahir->CurrentValue, NULL, $this->sep_tgllahir->ReadOnly);

			// sep_kodejeniskepesertaan
			$this->sep_kodejeniskepesertaan->SetDbValueDef($rsnew, $this->sep_kodejeniskepesertaan->CurrentValue, NULL, $this->sep_kodejeniskepesertaan->ReadOnly);

			// sep_namajeniskepesertaan
			$this->sep_namajeniskepesertaan->SetDbValueDef($rsnew, $this->sep_namajeniskepesertaan->CurrentValue, NULL, $this->sep_namajeniskepesertaan->ReadOnly);

			// sep_nokabpjs
			$this->sep_nokabpjs->SetDbValueDef($rsnew, $this->sep_nokabpjs->CurrentValue, NULL, $this->sep_nokabpjs->ReadOnly);

			// sep_status_peserta
			$this->sep_status_peserta->SetDbValueDef($rsnew, $this->sep_status_peserta->CurrentValue, NULL, $this->sep_status_peserta->ReadOnly);

			// sep_umur_pasien_sekarang
			$this->sep_umur_pasien_sekarang->SetDbValueDef($rsnew, $this->sep_umur_pasien_sekarang->CurrentValue, NULL, $this->sep_umur_pasien_sekarang->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_sep_rawat_inap_by_nokalist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_dokterpengirim":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
			$sWhereWrk = "{filter}";
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
			$sWhereWrk = "{filter}";
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
			$sWhereWrk = "{filter}";
			$this->noruang->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`no` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_dokter_penanggungjawab":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
			$sWhereWrk = "{filter}";
			$this->dokter_penanggungjawab->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KDDOKTER` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_sep_kodediagnosaawal":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE` AS `LinkFld`, `CODE` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "{filter}";
			$this->sep_kodediagnosaawal->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`CODE` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sep_kodediagnosaawal, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_sep_lakalantas":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_lakalantas`";
			$sWhereWrk = "";
			$this->sep_lakalantas->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sep_lakalantas, $sWhereWrk); // Call Lookup selecting
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
		case "x_dokterpengirim":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld` FROM `m_dokter`";
			$sWhereWrk = "`NAMADOKTER` LIKE '%{query_value}%'";
			$this->dokterpengirim->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_statusbayar":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld` FROM `m_carabayar`";
			$sWhereWrk = "`NAMA` LIKE '%{query_value}%'";
			$this->statusbayar->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
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
		case "x_noruang":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `no`, `nama` AS `DispFld` FROM `m_ruang`";
			$sWhereWrk = "`nama` LIKE '%{query_value}%'";
			$this->noruang->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_dokter_penanggungjawab":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld` FROM `m_dokter`";
			$sWhereWrk = "`NAMADOKTER` LIKE '%{query_value}%'";
			$this->dokter_penanggungjawab->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_sep_kodediagnosaawal":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "`CODE` LIKE '%{query_value}%'";
			$this->sep_kodediagnosaawal->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->sep_kodediagnosaawal, $sWhereWrk); // Call Lookup selecting
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
				$url = "cetak_sep_rawat_inap.php?no=".$this->NO_SKP->FormValue."&id=".$this->id_admission->FormValue;
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
if (!isset($vw_sep_rawat_inap_by_noka_edit)) $vw_sep_rawat_inap_by_noka_edit = new cvw_sep_rawat_inap_by_noka_edit();

// Page init
$vw_sep_rawat_inap_by_noka_edit->Page_Init();

// Page main
$vw_sep_rawat_inap_by_noka_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_sep_rawat_inap_by_noka_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_sep_rawat_inap_by_nokaedit = new ew_Form("fvw_sep_rawat_inap_by_nokaedit", "edit");

// Validate form
fvw_sep_rawat_inap_by_nokaedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->nomr->FldCaption(), $vw_sep_rawat_inap_by_noka->nomr->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ket_tgllahir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->ket_tgllahir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dokterpengirim");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->dokterpengirim->FldCaption(), $vw_sep_rawat_inap_by_noka->dokterpengirim->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dokterpengirim");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->dokterpengirim->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_statusbayar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->statusbayar->FldCaption(), $vw_sep_rawat_inap_by_noka->statusbayar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_statusbayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->statusbayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kirimdari");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->kirimdari->FldCaption(), $vw_sep_rawat_inap_by_noka->kirimdari->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kirimdari");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->kirimdari->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keluargadekat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->keluargadekat->FldCaption(), $vw_sep_rawat_inap_by_noka->keluargadekat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_panggungjawab");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->panggungjawab->FldCaption(), $vw_sep_rawat_inap_by_noka->panggungjawab->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_masukrs");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->masukrs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_noruang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->noruang->FldCaption(), $vw_sep_rawat_inap_by_noka->noruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_noruang");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->noruang->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tempat_tidur_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->tempat_tidur_id->FldCaption(), $vw_sep_rawat_inap_by_noka->tempat_tidur_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tempat_tidur_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->tempat_tidur_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nott");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->nott->FldCaption(), $vw_sep_rawat_inap_by_noka->nott->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NIP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->NIP->FldCaption(), $vw_sep_rawat_inap_by_noka->NIP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dokter_penanggungjawab");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->FldCaption(), $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dokter_penanggungjawab");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_KELASPERAWATAN_ID");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_tglsep");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->sep_tglsep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_tglrujuk");
			if (elm && !ew_CheckDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->sep_tglrujuk->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_jenisperawatan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sep_rawat_inap_by_noka->sep_jenisperawatan->FldErrMsg()) ?>");

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
fvw_sep_rawat_inap_by_nokaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_sep_rawat_inap_by_nokaedit.ValidateRequired = true;
<?php } else { ?>
fvw_sep_rawat_inap_by_nokaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_sep_rawat_inap_by_nokaedit.Lists["x_dokterpengirim"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_kirimdari"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_dokter_penanggungjawab"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_sep_kodediagnosaawal"] = {"LinkField":"x_CODE","Ajax":true,"AutoFill":true,"DisplayFields":["x_CODE","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_diagnosa_eklaim"};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_sep_lakalantas"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_lakalantas","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_lakalantas"};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_sep_flag_cekpeserta[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_sep_flag_cekpeserta[]"].Options = <?php echo json_encode($vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->Options()) ?>;
fvw_sep_rawat_inap_by_nokaedit.Lists["x_sep_flag_generatesep[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_sep_rawat_inap_by_nokaedit.Lists["x_sep_flag_generatesep[]"].Options = <?php echo json_encode($vw_sep_rawat_inap_by_noka->sep_flag_generatesep->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
$(document).ready(function() {
	$('#x_sep_catatan').css('background-color', '#ffff00');
	$('#x_sep_status_peserta').css('background-color', '#ffff00');
	$('#x_NO_SKP').css('background-color', '#ffff00');
	$('#x_sep_namapeserta').css('background-color', '#ffff00');
 	if ($("#x_sep_lakalantas").val() == "2") {
		$('#x_sep_lokasilaka').removeAttr('disabled');
	} else {
		$('#x_sep_lokasilaka').attr('disabled','disabled'); 
	}
		var date = new Date();
		var yyyy = date.getFullYear().toString();
		var mm = (date.getMonth()+1).toString();
		var dd  = date.getDate().toString();   
		var mmChars = mm.split('');   
		var ddChars = dd.split('');
		var datestring = yyyy + '/' + (mmChars[1]?mm:"0"+mmChars[0]) + '/' + (ddChars[1]?dd:"0"+ddChars[0]); 
		var norujukan = (ddChars[1]?dd:"0"+ddChars[0]) + '/' + (mmChars[1]?mm:"0"+mmChars[0]) + '/' + yyyy;
		$("#x_sep_tglsep").val(datestring);
		$("#x_sep_tglrujuk").val(datestring); 

		//$("#x_NORUJUKAN_SEP").val(norujukan);
	// Kondisi saat ComboBox (Select Option) dipilih nilainya  

	$("#x_sep_lakalantas").change(function() {
		if (this.value == "2") {     
			$('#x_sep_lokasilaka').attr('disabled','disabled'); 
			$('#x_sep_lokasilaka').val('');
			$('#x_sep_lokasilaka').css('background-color', 'transparent');
		} else {
			$('#x_sep_lokasilaka').removeAttr('disabled');
			$('#x_sep_lokasilaka').focus();
			$('#x_sep_lokasilaka').css('background-color', '#ffff00');
		} 
	}); 
});   
</script>
<?php if (!$vw_sep_rawat_inap_by_noka_edit->IsModal) { ?>
<?php } ?>
<?php $vw_sep_rawat_inap_by_noka_edit->ShowPageHeader(); ?>
<?php
$vw_sep_rawat_inap_by_noka_edit->ShowMessage();
?>
<form name="fvw_sep_rawat_inap_by_nokaedit" id="fvw_sep_rawat_inap_by_nokaedit" class="<?php echo $vw_sep_rawat_inap_by_noka_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_sep_rawat_inap_by_noka_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_sep_rawat_inap_by_noka_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_sep_rawat_inap_by_noka">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_sep_rawat_inap_by_noka_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_vw_sep_rawat_inap_by_nokaedit" class="ewCustomTemplate"></div>
<script id="tpm_vw_sep_rawat_inap_by_nokaedit" type="text/html">
<div id="ct_vw_sep_rawat_inap_by_noka_edit"><!-- Nav tabs, ini tombol tab di atas -->
<ul class="nav nav-tabs">
<!-- Untuk Semua Tab.. pastikan a href=”#nama_id” sama dengan nama id di “Tap Pane” dibawah-->
  <li class="active"><a href="#home" data-toggle="tab">Entry SEP</a></li> <!-- Untuk Tab pertama berikan li class=”active” agar pertama kali halaman di load tab langsung active-->
  <li><a href="#profile" data-toggle="tab">Riwayat SEP BPJS</a></li>
</ul>
<!-- Tab panes, ini content dari tab di atas -->
<div class="tab-content">
<div class="tab-pane active" id="home">
<!-- CONTENT TAB HOME DIMULAI DISINI -->
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Identitas Pasien Rawat Inap</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
			<!--<div id="r_Field_One" class="form-group">
			<label id="elh_sample_Field_One" for="x_Field_One" 
			class="col-sm-4 control-label ewLabel"  >
			<?php echo $vw_sep_rawat_inap_by_noka->id_admission->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_id_admission"/}}</div>
			</div> -->
			<div id="r_Field_Two" class="form-group">
			<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->nomr->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_nomr"/}}</div>
			</div>
			<div id="r_Field_ket_nama" class="form-group">
			<label id="elh_sample_ket_nama" for="x_Field_ket_nama" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->ket_nama->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_ket_nama"/}}</div>
			</div>
			<div id="r_Field_ket_tgllahir" class="form-group">
			<label id="elh_sample_ket_tgllahir" for="x_Field_ket_tgllahir" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->ket_tgllahir->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_ket_tgllahir"/}}</div>
			</div>
			<div id="r_Field_ket_alamat" class="form-group">
			<label id="elh_sample_ket_alamat" for="x_Field_ket_alamat" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->ket_alamat->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_ket_alamat"/}}</div>
			</div>
			<div id="r_Field_ket_jeniskelamin" class="form-group">
			<label id="elh_sample_ket_jeniskelamin" for="x_Field_ket_jeniskelamin" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->ket_jeniskelamin->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_ket_jeniskelamin"/}}</div>
			</div>
			<div id="r_Field_ket_title" class="form-group">
			<label id="elh_sample_ket_title" for="x_Field_ket_title" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->ket_title->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_ket_title"/}}</div>
			</div>
			<div id="r_Field_Three" class="form-group">
			<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_dokterpengirim"/}}</div>
			</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
			<div id="r_Field_statusbayar" class="form-group">
			<label id="elh_statusbayar" for="x_statusbayar" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->statusbayar->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_statusbayar"/}}</div>
			</div>
			<div id="r_Field_kirimdari" class="form-group">
			<label id="elh_kirimdari" for="x_kirimdari" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->kirimdari->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_kirimdari"/}}</div>
			</div>
			 <div id="r_Field_keluargadekat" class="form-group">
			<label id="elh_keluargadekat" for="x_keluargadekat" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->keluargadekat->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_keluargadekat"/}}</div>
			</div>
			<div id="r_Field_panggungjawab" class="form-group">
			<label id="elh_panggungjawab" for="x_panggungjawab" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->panggungjawab->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_panggungjawab"/}}</div>
			</div>
			<div id="r_Field_dokter_penanggungjawab" class="form-group">
			<label id="elh_dokter_penanggungjawab" for="x_dokter_penanggungjawab" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_dokter_penanggungjawab"/}}</div>
			</div>
			<div id="r_Field_masukrs" class="form-group">
			<label id="elh_masukrs" for="x_masukrs" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->masukrs->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_masukrs"/}}</div>
			</div>
			<div id="r_Field_noruang" class="form-group">
			<label id="elh_noruang" for="x_noruang" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->noruang->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_noruang"/}}</div>
			</div>
			<div id="r_Field_tempat_tidur_id" class="form-group">
			<label id="elh_tempat_tidur_id" for="x_tempat_tidur_id" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->tempat_tidur_id->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_tempat_tidur_id"/}}</div>
			</div>
			<div id="r_nott" class="form-group">
			<label id="elh_nott" for="x_nott" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->nott->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_nott"/}}</div>
			</div>
  </div>
  </div>
</div>
</div>
<!--  ------------------------------------------------- ---------------------------------     -->
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data SEP BPJS</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
			<div id="r_Field_sep_nokabpjs" class="form-group">
			<label id="elh_sep_nokabpjs" for="x_sep_nokabpjs" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_nokabpjs->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_nokabpjs"/}}</div>
			</div>
			<div id="r_Field_sep_flag_cekpeserta" class="form-group">
			<label id="elh_sep_flag_cekpeserta" for="x_sep_flag_cekpeserta" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_flag_cekpeserta"/}}</div>
			</div>
			<div id="r_Field_sep_sep_status_peserta" class="form-group">
			<label id="elh_sep_sep_status_peserta" for="x_sep_sep_status_peserta" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_status_peserta->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_status_peserta"/}}</div>
			</div>
			<div id="r_Field_KELASPERAWATAN_ID" class="form-group">
			<label id="elh_KELASPERAWATAN_ID" for="x_KELASPERAWATAN_ID" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_KELASPERAWATAN_ID"/}}</div>
			</div>
			<div id="r_Field_sep_umur_pasien_sekarang" class="form-group">
			<label id="elh_sep_umur_pasien_sekarang" for="x_sep_umur_pasien_sekarang" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_umur_pasien_sekarang"/}}</div>
			</div>
			<div id="r_Field_sep_namapeserta" class="form-group">
			<label id="elh_sep_namapeserta" for="x_sep_namapeserta" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_namapeserta->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_namapeserta"/}}</div>
			</div>
			<div id="r_Field_sep_tglsep" class="form-group">
			<label id="elh_sep_tglsep" for="x_sep_tglsep" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_tglsep->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_tglsep"/}}</div>
			</div>
			<div id="r_Field_sep_tglrujuk" class="form-group">
			<label id="elh_sep_tglrujuk" for="x_sep_tglrujuk" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_tglrujuk->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_tglrujuk"/}}</div>
			</div>
			<div id="r_Field_sep_norujukan" class="form-group">
			<label id="elh_sep_norujukan" for="x_sep_norujukan" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_norujukan->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_norujukan"/}}</div>
			</div>
			<div id="r_Field_sep_catatan" class="form-group">
			<label id="elh_sample_sep_catatan" for="x_Field_sep_catatan" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_catatan->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_catatan"/}}</div>
			</div>
			<div id="r_Field_sep_kodediagnosaawal" class="form-group">
			<label id="elh_sample_Field_sep_kodediagnosaawal" for="x_Field_sep_kodediagnosaawal" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_kodediagnosaawal"/}}</div>
			</div>
			<div id="r_Field_sep_lakalantas" class="form-group">
			<label id="elh_sep_lakalantas" for="x_sep_lakalantas" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_lakalantas"/}}</div>
			</div>
			<div id="r_Field_sep_lokasilaka" class="form-group">
			<label id="elh_sep_lokasilaka" for="x_sep_lokasilaka" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_lokasilaka->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_lokasilaka"/}}</div>
			</div>
			<div id="r_Field_sep_flag_generatesep" class="form-group">
			<label id="elh_sep_flag_generatesep" for="x_sep_flag_generatesep" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_generatesep->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_flag_generatesep"/}}</div>
			</div>
			<div id="r_Field_NO_SKP" class="form-group">
			<label id="elh_NO_SKP" for="x_NO_SKP" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->NO_SKP->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_NO_SKP"/}}</div>
			</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
		 <div id="r_Field_sep_user" class="form-group">
		<label id="elh_sep_user" for="x_sep_user" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_user->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_user"/}}</div>
		</div>
		<div id="r_Field_sep_jenisperawatan" class="form-group">
		<label id="elh_sample_sep_jenisperawatan" for="x_Field_sep_jenisperawatan" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_jenisperawatan->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_jenisperawatan"/}}</div>
		</div>
			<div id="r_Field_sep_kodekelasrawat" class="form-group">
			<label id="elh_sep_kodekelasrawat" for="x_sep_kodekelasrawat" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_kodekelasrawat"/}}</div>
			</div>
		<div id="r_Field_sep_nik" class="form-group">
		<label id="elh_sep_nik" for="x_sep_nik" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_nik->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_nik"/}}</div>
		</div>
		<div id="r_Field_sep_jeniskelamin" class="form-group">
		<label id="elh_sep_jeniskelamin" for="x_sep_jeniskelamin" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_jeniskelamin->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_jeniskelamin"/}}</div>
		</div>
		<div id="r_Field_sep_pisat" class="form-group">
		<label id="elh_sep_pisat" for="x_sep_pisat" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_pisat->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_pisat"/}}</div>
		</div>
		<div id="r_Field_sep_tgllahir" class="form-group">
		<label id="elh_sep_tgllahir" for="x_sep_tgllahir" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_tgllahir->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_tgllahir"/}}</div>
		</div>
		<div id="r_Field_sep_kodejeniskepesertaan" class="form-group">
		<label id="elh_sep_kodejeniskepesertaan" for="x_sep_kodejeniskepesertaan" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_kodejeniskepesertaan"/}}</div>
		</div>
		<div id="r_Field_sep_namajeniskepesertaan" class="form-group">
		<label id="elh_sep_namajeniskepesertaan" for="x_sep_namajeniskepesertaan" class="col-sm-4 control-label ewLabel">
		<?php echo $vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->FldCaption() ?></label>
		<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_namajeniskepesertaan"/}}</div>
		</div>
			<div id="r_Field_sep_kodeppkasal" class="form-group">
			<label id="elh_sep_kodeppkasal" for="x_sep_kodeppkasal" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkasal->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_kodeppkasal"/}}</div>
			</div>
			<div id="r_Field_sep_namappkasal" class="form-group">
			<label id="elh_sep_namappkasal" for="x_sep_namappkasal" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_namappkasal->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_namappkasal"/}}</div>
			</div>
			<div id="r_Field_sep_kodeppkpelayanan" class="form-group">
			<label id="elh_sep_kodeppkpelayanan" for="x_sep_kodeppkpelayanan" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_kodeppkpelayanan"/}}</div>
			</div>
			<div id="r_Field_sep_namadiagnosaawal" class="form-group">
			<label id="elh_sep_namadiagnosaawal" for="x_sep_namadiagnosaawal" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_sep_namadiagnosaawal"/}}</div>
			</div>
			<div id="r_Field_NIP" class="form-group">
			<label id="elh_NIP" for="x_NIP" class="col-sm-4 control-label ewLabel">
			<?php echo $vw_sep_rawat_inap_by_noka->NIP->FldCaption() ?></label>
			<div class="col-sm-8">{{include tmpl="#tpx_vw_sep_rawat_inap_by_noka_NIP"/}}</div>
			</div>
  </div>
  </div>
</div>
</div>
 <!-- CONTENT TAB HOME SELESAI DISINI-->
  </div><!-- Untuk Tab pertama berikan div class=”active” agar pertama kali halaman di load content langsung active-->
  <div class="tab-pane" id="profile">
  <!-- CONTENT TAB PROFIL DIMULAI DISINI-->
  <div class="ewRow">
  	<div class="panel panel-default">
		<div class="panel-body">
		 <?php
		error_reporting(0);
		include 'phpcon/koneksi.php';
		$id_pendaftaran = $_GET['id_admission'];
		$sql1 = "SELECT nomr FROM t_admission WHERE id_admission = ". $id_pendaftaran;
		$sql_query1 = $conn->query($sql1);
		$data_sql_query1 = $sql_query1->fetch_assoc();
		$sql2 = "SELECT * FROM m_pasien WHERE NOMR = ". $data_sql_query1['nomr'];
		$sql_query2 = $conn->query($sql2);
		$data_sql_query2 = $sql_query2->fetch_assoc();
		$nomor_kartu = $data_sql_query2['NO_KARTU'];
		$consumer_id = "1457"; 
		$secretKey = "5uR5F9F782";
		$url = "http://192.168.1.104:8080/WsLokalRest/sep/peserta/".$nomor_kartu;
		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		$signature = hash_hmac('sha256', $consumer_id."&".$tStamp, $secretKey, true);
		$encodedSignature = base64_encode($signature);
		$urlencodedSignature = urlencode($encodedSignature);
		$opts = array(
		 'http'=>array(
		 'method'=>"GET",
		 'header'=>"Host: api.asterix.co.id\r\n".
		 "Connection: close\r\n".
		 "X-timestamp: ".$tStamp."\r\n".
		 "X-signature: ".$encodedSignature."\r\n".
		 "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64)\r\n".
		 "X-cons-id: ".$consumer_id."\r\n".
		 "Accept: application/json\r\n"
		 )
		);
		$context = stream_context_create($opts);
		$result = file_get_contents($url, false, $context);
		if ($result === false) 
		{ 
			echo "Tidak dapat menyambung ke server"; 
		}
		else 
		{ 
			$resultarr = json_decode($result, true);
		}
		$url2 = "http://192.168.1.104:8080/WsLokalRest/Peserta/Peserta/".$nomor_kartu;
		date_default_timezone_set('UTC');
		$tStamp2 = strval(time()-strtotime('1970-01-01 00:00:00'));
		$signature2 = hash_hmac('sha256', $consumer_id."&".$tStamp2, $secretKey, true);
		$encodedSignature2 = base64_encode($signature2);
		$urlencodedSignature2 = urlencode($encodedSignature2);
		$opts2 = array(
		 'http'=>array(
		 'method'=>"GET",
		 'header'=>"Host: api.asterix.co.id\r\n".
		 "Connection: close\r\n".
		 "X-timestamp: ".$tStamp2."\r\n".
		 "X-signature: ".$encodedSignature2."\r\n".
		 "User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64)\r\n".
		 "X-cons-id: ".$consumer_id."\r\n".
		 "Accept: application/json\r\n"
		 )
		);
		$context2 = stream_context_create($opts2);
		$result2 = file_get_contents($url2, false, $context2);
		if ($result2 === false) 
		{ 
			echo "Tidak dapat menyambung ke server"; 
		}
		else 
		{ 
			$resultarr2 = json_decode($result2, true);
		}
		?>
		<table  width="900" class="table table-striped" border="0">
		  <tr>
			<td width="67">Nokartu</td>
			<td width="10">:</td>
			<td width="239"><?php  echo $resultarr2['response']['peserta']['noKartu'] ;?></td>
			<td width="10">&nbsp;</td>
			<td width="43">Nama</td>
			<td width="10">:</td>
			<td width="491"><?php  echo $resultarr2['response']['peserta']['nama'] ;?> (KTP :<?php  echo $resultarr2['response']['peserta']['nik'] ;?>)</td>
		  </tr>
		</table>
		<p>&nbsp;</p>
		<table width="900"class="table table-striped">
		  <thead>
			<tr>
			<th>No</th>
			  <th>noSEP</th>
			  <th>kdPoli</th>
			  <th>nmPoli</th>
			  <th>kodeDiagnosa</th>
			  <th>namaDiagnosa</th>
			  <th>jnsPelayanan</th>
			  <th>tglSEP</th>
			  <th>tglPulang</th>
			  <th>biayaTagihan</th>
			</tr>
		  </thead>
		  <tbody>
		<?php
			$id = 0;
			$nomer = 1;
			while($id<$resultarr['response']['count'])
			{
		?>
			<tr>
			<th scope="row"><?php  echo $nomer ;?></th>
			  <td><?php  echo $resultarr['response']['list'][$id]['noSEP'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['poliTujuan']['kdPoli'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['poliTujuan']['nmPoli'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['diagnosa']['kodeDiagnosa'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['diagnosa']['namaDiagnosa'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['jnsPelayanan'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['tglSEP'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['tglPulang'] ;?></td>
			  <td><?php  echo $resultarr['response']['list'][$id]['biayaTagihan'] ;?></td>
			</tr>
		 <?php $id ++; 
		  $nomer ++;  } ?>
		  </tbody>
		</table>
	<!-- conten -->
 <!-- SELESAI TABEL -->
 		</div>
 	</div>
	</div>
  <!-- CONTENT TAB PROFIL SELESAI DISINI-->
  </div>
</div>
</div>
</script>
<div style="display: none">
<?php if ($vw_sep_rawat_inap_by_noka->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_nomr" for="x_nomr" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_nomr" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->nomr->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->nomr->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_nomr" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_nomr">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_nomr" name="x_nomr" id="x_nomr" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->nomr->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->nomr->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->nomr->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->ket_nama->Visible) { // ket_nama ?>
	<div id="r_ket_nama" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_ket_nama" for="x_ket_nama" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_ket_nama" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->ket_nama->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->ket_nama->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_ket_nama" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_ket_nama">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_ket_nama" name="x_ket_nama" id="x_ket_nama" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->ket_nama->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->ket_nama->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->ket_nama->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->ket_nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->ket_tgllahir->Visible) { // ket_tgllahir ?>
	<div id="r_ket_tgllahir" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_ket_tgllahir" for="x_ket_tgllahir" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_ket_tgllahir" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->ket_tgllahir->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->ket_tgllahir->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_ket_tgllahir" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_ket_tgllahir">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_ket_tgllahir" name="x_ket_tgllahir" id="x_ket_tgllahir" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->ket_tgllahir->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->ket_tgllahir->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->ket_tgllahir->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->ket_tgllahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->ket_alamat->Visible) { // ket_alamat ?>
	<div id="r_ket_alamat" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_ket_alamat" for="x_ket_alamat" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_ket_alamat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->ket_alamat->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->ket_alamat->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_ket_alamat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_ket_alamat">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_ket_alamat" name="x_ket_alamat" id="x_ket_alamat" size="30" maxlength="225" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->ket_alamat->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->ket_alamat->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->ket_alamat->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->ket_alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->ket_jeniskelamin->Visible) { // ket_jeniskelamin ?>
	<div id="r_ket_jeniskelamin" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_ket_jeniskelamin" for="x_ket_jeniskelamin" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_ket_jeniskelamin" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->ket_jeniskelamin->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->ket_jeniskelamin->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_ket_jeniskelamin" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_ket_jeniskelamin">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_ket_jeniskelamin" name="x_ket_jeniskelamin" id="x_ket_jeniskelamin" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->ket_jeniskelamin->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->ket_jeniskelamin->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->ket_jeniskelamin->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->ket_jeniskelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->ket_title->Visible) { // ket_title ?>
	<div id="r_ket_title" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_ket_title" for="x_ket_title" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_ket_title" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->ket_title->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->ket_title->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_ket_title" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_ket_title">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_ket_title" name="x_ket_title" id="x_ket_title" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->ket_title->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->ket_title->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->ket_title->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->ket_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->dokterpengirim->Visible) { // dokterpengirim ?>
	<div id="r_dokterpengirim" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_dokterpengirim" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_dokterpengirim" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_dokterpengirim" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_dokterpengirim">
<?php
$wrkonchange = trim(" " . @$vw_sep_rawat_inap_by_noka->dokterpengirim->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_sep_rawat_inap_by_noka->dokterpengirim->EditAttrs["onchange"] = "";
?>
<span id="as_x_dokterpengirim" style="white-space: nowrap; z-index: 8920">
	<input type="text" name="sv_x_dokterpengirim" id="sv_x_dokterpengirim" value="<?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->dokterpengirim->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->dokterpengirim->getPlaceHolder()) ?>"<?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_sep_rawat_inap_by_noka" data-field="x_dokterpengirim" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->DisplayValueSeparatorAttribute() ?>" name="x_dokterpengirim" id="x_dokterpengirim" value="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->dokterpengirim->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_dokterpengirim" id="q_x_dokterpengirim" value="<?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
fvw_sep_rawat_inap_by_nokaedit.CreateAutoSuggest({"id":"x_dokterpengirim","forceSelect":false});
</script>
<?php echo $vw_sep_rawat_inap_by_noka->dokterpengirim->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->statusbayar->Visible) { // statusbayar ?>
	<div id="r_statusbayar" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_statusbayar" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_statusbayar" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->statusbayar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->statusbayar->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_statusbayar" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_statusbayar">
<?php
$wrkonchange = trim(" " . @$vw_sep_rawat_inap_by_noka->statusbayar->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_sep_rawat_inap_by_noka->statusbayar->EditAttrs["onchange"] = "";
?>
<span id="as_x_statusbayar" style="white-space: nowrap; z-index: 8910">
	<input type="text" name="sv_x_statusbayar" id="sv_x_statusbayar" value="<?php echo $vw_sep_rawat_inap_by_noka->statusbayar->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->statusbayar->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->statusbayar->getPlaceHolder()) ?>"<?php echo $vw_sep_rawat_inap_by_noka->statusbayar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_sep_rawat_inap_by_noka" data-field="x_statusbayar" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->statusbayar->DisplayValueSeparatorAttribute() ?>" name="x_statusbayar" id="x_statusbayar" value="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->statusbayar->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_statusbayar" id="q_x_statusbayar" value="<?php echo $vw_sep_rawat_inap_by_noka->statusbayar->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
fvw_sep_rawat_inap_by_nokaedit.CreateAutoSuggest({"id":"x_statusbayar","forceSelect":false});
</script>
<?php echo $vw_sep_rawat_inap_by_noka->statusbayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->kirimdari->Visible) { // kirimdari ?>
	<div id="r_kirimdari" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_kirimdari" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_kirimdari" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->kirimdari->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->kirimdari->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_kirimdari" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_kirimdari">
<?php
$wrkonchange = trim(" " . @$vw_sep_rawat_inap_by_noka->kirimdari->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_sep_rawat_inap_by_noka->kirimdari->EditAttrs["onchange"] = "";
?>
<span id="as_x_kirimdari" style="white-space: nowrap; z-index: 8900">
	<input type="text" name="sv_x_kirimdari" id="sv_x_kirimdari" value="<?php echo $vw_sep_rawat_inap_by_noka->kirimdari->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->kirimdari->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->kirimdari->getPlaceHolder()) ?>"<?php echo $vw_sep_rawat_inap_by_noka->kirimdari->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_sep_rawat_inap_by_noka" data-field="x_kirimdari" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->kirimdari->DisplayValueSeparatorAttribute() ?>" name="x_kirimdari" id="x_kirimdari" value="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->kirimdari->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_kirimdari" id="q_x_kirimdari" value="<?php echo $vw_sep_rawat_inap_by_noka->kirimdari->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
fvw_sep_rawat_inap_by_nokaedit.CreateAutoSuggest({"id":"x_kirimdari","forceSelect":false});
</script>
<?php echo $vw_sep_rawat_inap_by_noka->kirimdari->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->keluargadekat->Visible) { // keluargadekat ?>
	<div id="r_keluargadekat" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_keluargadekat" for="x_keluargadekat" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_keluargadekat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->keluargadekat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->keluargadekat->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_keluargadekat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_keluargadekat">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_keluargadekat" name="x_keluargadekat" id="x_keluargadekat" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->keluargadekat->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->keluargadekat->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->keluargadekat->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->keluargadekat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->panggungjawab->Visible) { // panggungjawab ?>
	<div id="r_panggungjawab" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_panggungjawab" for="x_panggungjawab" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_panggungjawab" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->panggungjawab->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->panggungjawab->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_panggungjawab" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_panggungjawab">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_panggungjawab" name="x_panggungjawab" id="x_panggungjawab" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->panggungjawab->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->panggungjawab->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->panggungjawab->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->panggungjawab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->masukrs->Visible) { // masukrs ?>
	<div id="r_masukrs" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_masukrs" for="x_masukrs" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_masukrs" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->masukrs->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->masukrs->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_masukrs" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_masukrs">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_masukrs" name="x_masukrs" id="x_masukrs" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->masukrs->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->masukrs->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->masukrs->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->masukrs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->noruang->Visible) { // noruang ?>
	<div id="r_noruang" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_noruang" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_noruang" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->noruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->noruang->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_noruang" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_noruang">
<?php
$wrkonchange = trim(" " . @$vw_sep_rawat_inap_by_noka->noruang->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_sep_rawat_inap_by_noka->noruang->EditAttrs["onchange"] = "";
?>
<span id="as_x_noruang" style="white-space: nowrap; z-index: 8860">
	<input type="text" name="sv_x_noruang" id="sv_x_noruang" value="<?php echo $vw_sep_rawat_inap_by_noka->noruang->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->noruang->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->noruang->getPlaceHolder()) ?>"<?php echo $vw_sep_rawat_inap_by_noka->noruang->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_sep_rawat_inap_by_noka" data-field="x_noruang" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->noruang->DisplayValueSeparatorAttribute() ?>" name="x_noruang" id="x_noruang" value="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->noruang->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_noruang" id="q_x_noruang" value="<?php echo $vw_sep_rawat_inap_by_noka->noruang->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
fvw_sep_rawat_inap_by_nokaedit.CreateAutoSuggest({"id":"x_noruang","forceSelect":false});
</script>
<?php echo $vw_sep_rawat_inap_by_noka->noruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->tempat_tidur_id->Visible) { // tempat_tidur_id ?>
	<div id="r_tempat_tidur_id" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_tempat_tidur_id" for="x_tempat_tidur_id" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_tempat_tidur_id" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->tempat_tidur_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->tempat_tidur_id->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_tempat_tidur_id" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_tempat_tidur_id">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_tempat_tidur_id" name="x_tempat_tidur_id" id="x_tempat_tidur_id" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->tempat_tidur_id->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->tempat_tidur_id->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->tempat_tidur_id->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->tempat_tidur_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->nott->Visible) { // nott ?>
	<div id="r_nott" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_nott" for="x_nott" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_nott" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->nott->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->nott->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_nott" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_nott">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_nott" name="x_nott" id="x_nott" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->nott->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->nott->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->nott->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->nott->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_NIP" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->NIP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->NIP->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_NIP" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_NIP">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_NIP" name="x_NIP" id="x_NIP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->NIP->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->NIP->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->NIP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->Visible) { // dokter_penanggungjawab ?>
	<div id="r_dokter_penanggungjawab" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_dokter_penanggungjawab" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_dokter_penanggungjawab" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_dokter_penanggungjawab" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_dokter_penanggungjawab">
<?php
$wrkonchange = trim(" " . @$vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->EditAttrs["onchange"] = "";
?>
<span id="as_x_dokter_penanggungjawab" style="white-space: nowrap; z-index: 8820">
	<input type="text" name="sv_x_dokter_penanggungjawab" id="sv_x_dokter_penanggungjawab" value="<?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->getPlaceHolder()) ?>"<?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_sep_rawat_inap_by_noka" data-field="x_dokter_penanggungjawab" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->DisplayValueSeparatorAttribute() ?>" name="x_dokter_penanggungjawab" id="x_dokter_penanggungjawab" value="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_dokter_penanggungjawab" id="q_x_dokter_penanggungjawab" value="<?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
fvw_sep_rawat_inap_by_nokaedit.CreateAutoSuggest({"id":"x_dokter_penanggungjawab","forceSelect":false});
</script>
<?php echo $vw_sep_rawat_inap_by_noka->dokter_penanggungjawab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<div id="r_KELASPERAWATAN_ID" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_KELASPERAWATAN_ID" for="x_KELASPERAWATAN_ID" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_KELASPERAWATAN_ID" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_KELASPERAWATAN_ID" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_KELASPERAWATAN_ID">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_KELASPERAWATAN_ID" name="x_KELASPERAWATAN_ID" id="x_KELASPERAWATAN_ID" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->KELASPERAWATAN_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->NO_SKP->Visible) { // NO_SKP ?>
	<div id="r_NO_SKP" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_NO_SKP" for="x_NO_SKP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_NO_SKP" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->NO_SKP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->NO_SKP->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_NO_SKP" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_NO_SKP">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_NO_SKP" name="x_NO_SKP" id="x_NO_SKP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->NO_SKP->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->NO_SKP->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->NO_SKP->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->NO_SKP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_tglsep->Visible) { // sep_tglsep ?>
	<div id="r_sep_tglsep" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_tglsep" for="x_sep_tglsep" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_tglsep" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_tglsep->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_tglsep->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_tglsep" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_tglsep">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_tglsep" data-format="5" name="x_sep_tglsep" id="x_sep_tglsep" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_tglsep->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_tglsep->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_tglsep->EditAttributes() ?>>
<?php if (!$vw_sep_rawat_inap_by_noka->sep_tglsep->ReadOnly && !$vw_sep_rawat_inap_by_noka->sep_tglsep->Disabled && !isset($vw_sep_rawat_inap_by_noka->sep_tglsep->EditAttrs["readonly"]) && !isset($vw_sep_rawat_inap_by_noka->sep_tglsep->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
ew_CreateCalendar("fvw_sep_rawat_inap_by_nokaedit", "x_sep_tglsep", 5);
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_tglsep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_tglrujuk->Visible) { // sep_tglrujuk ?>
	<div id="r_sep_tglrujuk" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_tglrujuk" for="x_sep_tglrujuk" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_tglrujuk" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_tglrujuk->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_tglrujuk->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_tglrujuk" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_tglrujuk">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_tglrujuk" data-format="5" name="x_sep_tglrujuk" id="x_sep_tglrujuk" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_tglrujuk->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_tglrujuk->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_tglrujuk->EditAttributes() ?>>
<?php if (!$vw_sep_rawat_inap_by_noka->sep_tglrujuk->ReadOnly && !$vw_sep_rawat_inap_by_noka->sep_tglrujuk->Disabled && !isset($vw_sep_rawat_inap_by_noka->sep_tglrujuk->EditAttrs["readonly"]) && !isset($vw_sep_rawat_inap_by_noka->sep_tglrujuk->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
ew_CreateCalendar("fvw_sep_rawat_inap_by_nokaedit", "x_sep_tglrujuk", 5);
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_tglrujuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->Visible) { // sep_kodekelasrawat ?>
	<div id="r_sep_kodekelasrawat" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_kodekelasrawat" for="x_sep_kodekelasrawat" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_kodekelasrawat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_kodekelasrawat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_kodekelasrawat">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_kodekelasrawat" name="x_sep_kodekelasrawat" id="x_sep_kodekelasrawat" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_kodekelasrawat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_norujukan->Visible) { // sep_norujukan ?>
	<div id="r_sep_norujukan" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_norujukan" for="x_sep_norujukan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_norujukan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_norujukan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_norujukan->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_norujukan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_norujukan">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_norujukan" name="x_sep_norujukan" id="x_sep_norujukan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_norujukan->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_norujukan->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_norujukan->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_norujukan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_kodeppkasal->Visible) { // sep_kodeppkasal ?>
	<div id="r_sep_kodeppkasal" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_kodeppkasal" for="x_sep_kodeppkasal" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_kodeppkasal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkasal->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkasal->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_kodeppkasal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_kodeppkasal">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_kodeppkasal" name="x_sep_kodeppkasal" id="x_sep_kodeppkasal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_kodeppkasal->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkasal->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkasal->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkasal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_namappkasal->Visible) { // sep_namappkasal ?>
	<div id="r_sep_namappkasal" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_namappkasal" for="x_sep_namappkasal" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_namappkasal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_namappkasal->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_namappkasal->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_namappkasal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_namappkasal">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_namappkasal" name="x_sep_namappkasal" id="x_sep_namappkasal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_namappkasal->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_namappkasal->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_namappkasal->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_namappkasal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->Visible) { // sep_kodeppkpelayanan ?>
	<div id="r_sep_kodeppkpelayanan" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_kodeppkpelayanan" for="x_sep_kodeppkpelayanan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_kodeppkpelayanan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_kodeppkpelayanan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_kodeppkpelayanan">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_kodeppkpelayanan" name="x_sep_kodeppkpelayanan" id="x_sep_kodeppkpelayanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_kodeppkpelayanan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_jenisperawatan->Visible) { // sep_jenisperawatan ?>
	<div id="r_sep_jenisperawatan" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_jenisperawatan" for="x_sep_jenisperawatan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_jenisperawatan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_jenisperawatan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_jenisperawatan->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_jenisperawatan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_jenisperawatan">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_jenisperawatan" name="x_sep_jenisperawatan" id="x_sep_jenisperawatan" size="30" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_jenisperawatan->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_jenisperawatan->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_jenisperawatan->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_jenisperawatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_catatan->Visible) { // sep_catatan ?>
	<div id="r_sep_catatan" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_catatan" for="x_sep_catatan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_catatan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_catatan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_catatan->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_catatan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_catatan">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_catatan" name="x_sep_catatan" id="x_sep_catatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_catatan->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_catatan->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_catatan->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_catatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->Visible) { // sep_kodediagnosaawal ?>
	<div id="r_sep_kodediagnosaawal" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_kodediagnosaawal" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_kodediagnosaawal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_kodediagnosaawal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_kodediagnosaawal">
<?php
$wrkonchange = trim("ew_AutoFill(this); " . @$vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->EditAttrs["onchange"] = "";
?>
<span id="as_x_sep_kodediagnosaawal" style="white-space: nowrap; z-index: 8700">
	<input type="text" name="sv_x_sep_kodediagnosaawal" id="sv_x_sep_kodediagnosaawal" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->EditValue ?>" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->getPlaceHolder()) ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_kodediagnosaawal" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->DisplayValueSeparatorAttribute() ?>" name="x_sep_kodediagnosaawal" id="x_sep_kodediagnosaawal" value="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_sep_kodediagnosaawal" id="q_x_sep_kodediagnosaawal" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->LookupFilterQuery(true) ?>">
<input type="hidden" name="ln_x_sep_kodediagnosaawal" id="ln_x_sep_kodediagnosaawal" value="x_sep_namadiagnosaawal">
</span>
</script>
<script type="text/html" class="vw_sep_rawat_inap_by_nokaedit_js">
fvw_sep_rawat_inap_by_nokaedit.CreateAutoSuggest({"id":"x_sep_kodediagnosaawal","forceSelect":true});
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_kodediagnosaawal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->Visible) { // sep_namadiagnosaawal ?>
	<div id="r_sep_namadiagnosaawal" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_namadiagnosaawal" for="x_sep_namadiagnosaawal" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_namadiagnosaawal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_namadiagnosaawal" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_namadiagnosaawal">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_namadiagnosaawal" name="x_sep_namadiagnosaawal" id="x_sep_namadiagnosaawal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_namadiagnosaawal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_lakalantas->Visible) { // sep_lakalantas ?>
	<div id="r_sep_lakalantas" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_lakalantas" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_lakalantas" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_lakalantas" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_lakalantas">
<div id="tp_x_sep_lakalantas" class="ewTemplate"><input type="radio" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_lakalantas" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->DisplayValueSeparatorAttribute() ?>" name="x_sep_lakalantas" id="x_sep_lakalantas" value="{value}"<?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->EditAttributes() ?>></div>
<div id="dsl_x_sep_lakalantas" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->RadioButtonListHtml(FALSE, "x_sep_lakalantas") ?>
</div></div>
<input type="hidden" name="s_x_sep_lakalantas" id="s_x_sep_lakalantas" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_lakalantas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_lokasilaka->Visible) { // sep_lokasilaka ?>
	<div id="r_sep_lokasilaka" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_lokasilaka" for="x_sep_lokasilaka" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_lokasilaka" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_lokasilaka->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_lokasilaka->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_lokasilaka" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_lokasilaka">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_lokasilaka" name="x_sep_lokasilaka" id="x_sep_lokasilaka" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_lokasilaka->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_lokasilaka->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_lokasilaka->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_lokasilaka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_user->Visible) { // sep_user ?>
	<div id="r_sep_user" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_user" for="x_sep_user" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_user" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_user->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_user->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_user" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_user">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_user" name="x_sep_user" id="x_sep_user" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_user->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_user->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_user->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_user->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->Visible) { // sep_flag_cekpeserta ?>
	<div id="r_sep_flag_cekpeserta" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_flag_cekpeserta" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_flag_cekpeserta" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_flag_cekpeserta" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_flag_cekpeserta">
<div id="tp_x_sep_flag_cekpeserta" class="ewTemplate"><input type="checkbox" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_flag_cekpeserta" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->DisplayValueSeparatorAttribute() ?>" name="x_sep_flag_cekpeserta[]" id="x_sep_flag_cekpeserta[]" value="{value}"<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->EditAttributes() ?>></div>
<div id="dsl_x_sep_flag_cekpeserta" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->CheckBoxListHtml(FALSE, "x_sep_flag_cekpeserta[]") ?>
</div></div>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_cekpeserta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_flag_generatesep->Visible) { // sep_flag_generatesep ?>
	<div id="r_sep_flag_generatesep" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_flag_generatesep" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_flag_generatesep" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_flag_generatesep->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_generatesep->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_flag_generatesep" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_flag_generatesep">
<div id="tp_x_sep_flag_generatesep" class="ewTemplate"><input type="checkbox" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_flag_generatesep" data-value-separator="<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_generatesep->DisplayValueSeparatorAttribute() ?>" name="x_sep_flag_generatesep[]" id="x_sep_flag_generatesep[]" value="{value}"<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_generatesep->EditAttributes() ?>></div>
<div id="dsl_x_sep_flag_generatesep" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_generatesep->CheckBoxListHtml(FALSE, "x_sep_flag_generatesep[]") ?>
</div></div>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_flag_generatesep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_nik->Visible) { // sep_nik ?>
	<div id="r_sep_nik" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_nik" for="x_sep_nik" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_nik" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_nik->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_nik->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_nik" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_nik">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_nik" name="x_sep_nik" id="x_sep_nik" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_nik->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_nik->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_nik->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_nik->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_namapeserta->Visible) { // sep_namapeserta ?>
	<div id="r_sep_namapeserta" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_namapeserta" for="x_sep_namapeserta" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_namapeserta" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_namapeserta->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_namapeserta->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_namapeserta" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_namapeserta">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_namapeserta" name="x_sep_namapeserta" id="x_sep_namapeserta" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_namapeserta->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_namapeserta->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_namapeserta->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_namapeserta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_jeniskelamin->Visible) { // sep_jeniskelamin ?>
	<div id="r_sep_jeniskelamin" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_jeniskelamin" for="x_sep_jeniskelamin" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_jeniskelamin" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_jeniskelamin->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_jeniskelamin->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_jeniskelamin" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_jeniskelamin">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_jeniskelamin" name="x_sep_jeniskelamin" id="x_sep_jeniskelamin" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_jeniskelamin->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_jeniskelamin->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_jeniskelamin->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_jeniskelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_pisat->Visible) { // sep_pisat ?>
	<div id="r_sep_pisat" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_pisat" for="x_sep_pisat" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_pisat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_pisat->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_pisat->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_pisat" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_pisat">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_pisat" name="x_sep_pisat" id="x_sep_pisat" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_pisat->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_pisat->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_pisat->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_pisat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_tgllahir->Visible) { // sep_tgllahir ?>
	<div id="r_sep_tgllahir" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_tgllahir" for="x_sep_tgllahir" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_tgllahir" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_tgllahir->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_tgllahir->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_tgllahir" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_tgllahir">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_tgllahir" name="x_sep_tgllahir" id="x_sep_tgllahir" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_tgllahir->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_tgllahir->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_tgllahir->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_tgllahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->Visible) { // sep_kodejeniskepesertaan ?>
	<div id="r_sep_kodejeniskepesertaan" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_kodejeniskepesertaan" for="x_sep_kodejeniskepesertaan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_kodejeniskepesertaan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_kodejeniskepesertaan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_kodejeniskepesertaan">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_kodejeniskepesertaan" name="x_sep_kodejeniskepesertaan" id="x_sep_kodejeniskepesertaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_kodejeniskepesertaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->Visible) { // sep_namajeniskepesertaan ?>
	<div id="r_sep_namajeniskepesertaan" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_namajeniskepesertaan" for="x_sep_namajeniskepesertaan" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_namajeniskepesertaan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_namajeniskepesertaan" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_namajeniskepesertaan">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_namajeniskepesertaan" name="x_sep_namajeniskepesertaan" id="x_sep_namajeniskepesertaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_namajeniskepesertaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_nokabpjs->Visible) { // sep_nokabpjs ?>
	<div id="r_sep_nokabpjs" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_nokabpjs" for="x_sep_nokabpjs" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_nokabpjs" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_nokabpjs->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_nokabpjs->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_nokabpjs" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_nokabpjs">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_nokabpjs" name="x_sep_nokabpjs" id="x_sep_nokabpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_nokabpjs->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_nokabpjs->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_nokabpjs->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_nokabpjs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_status_peserta->Visible) { // sep_status_peserta ?>
	<div id="r_sep_status_peserta" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_status_peserta" for="x_sep_status_peserta" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_status_peserta" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_status_peserta->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_status_peserta->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_status_peserta" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_status_peserta">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_status_peserta" name="x_sep_status_peserta" id="x_sep_status_peserta" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_status_peserta->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_status_peserta->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_status_peserta->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_status_peserta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->Visible) { // sep_umur_pasien_sekarang ?>
	<div id="r_sep_umur_pasien_sekarang" class="form-group">
		<label id="elh_vw_sep_rawat_inap_by_noka_sep_umur_pasien_sekarang" for="x_sep_umur_pasien_sekarang" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_sep_rawat_inap_by_noka_sep_umur_pasien_sekarang" class="vw_sep_rawat_inap_by_nokaedit" type="text/html"><span><?php echo $vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->CellAttributes() ?>>
<script id="tpx_vw_sep_rawat_inap_by_noka_sep_umur_pasien_sekarang" class="vw_sep_rawat_inap_by_nokaedit" type="text/html">
<span id="el_vw_sep_rawat_inap_by_noka_sep_umur_pasien_sekarang">
<input type="text" data-table="vw_sep_rawat_inap_by_noka" data-field="x_sep_umur_pasien_sekarang" name="x_sep_umur_pasien_sekarang" id="x_sep_umur_pasien_sekarang" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->getPlaceHolder()) ?>" value="<?php echo $vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->EditValue ?>"<?php echo $vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->EditAttributes() ?>>
</span>
</script>
<?php echo $vw_sep_rawat_inap_by_noka->sep_umur_pasien_sekarang->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="vw_sep_rawat_inap_by_noka" data-field="x_id_admission" name="x_id_admission" id="x_id_admission" value="<?php echo ew_HtmlEncode($vw_sep_rawat_inap_by_noka->id_admission->CurrentValue) ?>">
<?php if (!$vw_sep_rawat_inap_by_noka_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_sep_rawat_inap_by_noka_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_vw_sep_rawat_inap_by_nokaedit", "tpm_vw_sep_rawat_inap_by_nokaedit", "vw_sep_rawat_inap_by_nokaedit", "<?php echo $vw_sep_rawat_inap_by_noka->CustomExport ?>");
jQuery("script.vw_sep_rawat_inap_by_nokaedit_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
fvw_sep_rawat_inap_by_nokaedit.Init();
</script>
<?php
$vw_sep_rawat_inap_by_noka_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");
function cek_peserta()
{
	var jqxhr = $.get( "cek_kepesertaan_bpjs.php",
		{
		 	id_admission: $("#x_id_admission").val(),
			nomor_kartu : $("#x_sep_nokabpjs").val()
		 }, function(data, status) {
		 	let parsed = JSON.parse(data);
		 	let code = parsed.metadata.code;
		 	let message = parsed.metadata.message;
			if(code == 200)
			{
				$("#x_sep_namapeserta").val(parsed.response.peserta.nama);
				$("#x_sep_nik").val(parsed.response.peserta.nik);
				$("#x_sep_jeniskelamin").val(parsed.response.peserta.sex);
				$("#x_sep_kodejeniskepesertaan").val(parsed.response.peserta.jenisPeserta.kdJenisPeserta);
				$("#x_sep_namajeniskepesertaan").val(parsed.response.peserta.jenisPeserta.nmJenisPeserta);			
				$("#x_sep_kodekelasrawat").val(parsed.response.peserta.kelasTanggungan.nmKelas);
				$("#x_KELASPERAWATAN_ID").val(parsed.response.peserta.kelasTanggungan.kdKelas);
				$("#x_sep_kodeppkasal").val(parsed.response.peserta.provUmum.kdProvider);
				$("#x_sep_namappkasal").val(parsed.response.peserta.provUmum.nmProvider);
				$("#x_sep_tgllahir").val(parsed.response.peserta.tglLahir);
				$("#x_sep_pisat").val(parsed.response.peserta.pisa);
				$("#x_sep_status_peserta").val(parsed.response.peserta.statusPeserta.keterangan);
				$("#x_sep_umur_pasien_sekarang").val(parsed.response.peserta.umur.umurSekarang);
				let h = $("#x_noruang option:selected").text();
				let nik = parsed.response.peserta.nik;
				$("#x_sep_catatan").val(h+' '+nik);
			}else
			{
				alert(message);
			}
		}).done(function() {
		}).fail(function() {
		}).always(function() {
		});
		jqxhr.always(function() {
		});	
}

function insert_sep()
{ //jnsPelayanan: $("input[name=x_sep_jenisperawatan]:checked").val(),
	var jqxhr = $.get( "insert_sep_ranap.php",
	{
		id_admission: $("#x_id_admission").val(), 
		noKartu: $("#x_sep_nokabpjs").val(), 
		tglSep: $("#x_sep_tglsep").val(),               
		tglRujukan: $("#x_sep_tglrujuk").val(),  
		noRujukan: $("#x_sep_norujukan").val(),
		ppkRujukan: $("#x_sep_kodeppkasal").val(),
		ppkPelayanan: $("#x_sep_kodeppkpelayanan").val(),
		jnsPelayanan: $("#x_sep_jenisperawatan").val(),
		catatan: $("#x_sep_catatan").val(), 
		diagAwal: $("#x_sep_kodediagnosaawal").val(),   
		klsRawat: $("#x_KELASPERAWATAN_ID").val(), 
		lakaLantas: $("input[name=x_sep_lakalantas]:checked").val(),
		lokasiLaka: $("#x_sep_lokasilaka").val(), 
		noMr: $("#x_nomr").val(),
		user: $("#x_sep_user").val()
	}, function(data, status) {
		 	let parsed = JSON.parse(data);
		 	let code = parsed.metadata.code;
		 	let message = parsed.metadata.message;
			if(code == 200)
			{
				$("#x_NO_SKP").val(parsed.response);
				maping_simrs();
			}else
			{
				alert(message);
			}
		}).done(function() {
		}).fail(function() {
		}).always(function() {
		});
		jqxhr.always(function() {
		});	
}

function maping_simrs()
{
	var jqxhr = $.get( "maping_sep_ranap.php",
	{
		noSep: $("#x_NO_SKP").val(), 
		noTrans: $("#x_id_admission").val(),
		ppkPelayanan: $("#x_sep_kodeppkpelayanan").val()
	}, function(data, status) {
		 	let parsed = JSON.parse(data);
		 	let code = parsed.metadata.code;
		 	let message = parsed.metadata.message;
			if(code == 200)
			{
				alert('mapping status: '+parsed.response);
			}else
			{
				alert(message);
			}
		}).done(function() {
		}).fail(function() {
		}).always(function() {
		});
		jqxhr.always(function() {
		});	
}
$("input[name='x_sep_flag_cekpeserta[]']").click(function() {
	if (this.checked)                   
	{
		alert('OK');
		cek_peserta();
	}                                                          
});
$("input[name='x_sep_flag_generatesep[]']").click(function() {
	if (this.checked)                   
	{              
		insert_sep();
	}             
});
</script>
<?php include_once "footer.php" ?>
<?php
$vw_sep_rawat_inap_by_noka_edit->Page_Terminate();
?>
