<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_pendaftaraninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_pendaftaran_add = NULL; // Initialize page object first

class ct_pendaftaran_add extends ct_pendaftaran {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_pendaftaran';

	// Page object name
	var $PageObjName = 't_pendaftaran_add';

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

		// Table object (t_pendaftaran)
		if (!isset($GLOBALS["t_pendaftaran"]) || get_class($GLOBALS["t_pendaftaran"]) == "ct_pendaftaran") {
			$GLOBALS["t_pendaftaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_pendaftaran"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_pendaftaran', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_pendaftaranlist.php"));
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
		global $EW_EXPORT, $t_pendaftaran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_pendaftaran);
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
			if (@$_GET["IDXDAFTAR"] != "") {
				$this->IDXDAFTAR->setQueryStringValue($_GET["IDXDAFTAR"]);
				$this->setKey("IDXDAFTAR", $this->IDXDAFTAR->CurrentValue); // Set up key
			} else {
				$this->setKey("IDXDAFTAR", ""); // Clear key
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
					$this->Page_Terminate("t_pendaftaranlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_pendaftaranlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_pendaftaranview.php")
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
		$this->PASIENBARU->CurrentValue = 0;
		$this->NOMR->CurrentValue = NULL;
		$this->NOMR->OldValue = $this->NOMR->CurrentValue;
		$this->TGLREG->CurrentValue = date("d/m/Y");
		$this->KDDOKTER->CurrentValue = NULL;
		$this->KDDOKTER->OldValue = $this->KDDOKTER->CurrentValue;
		$this->KDPOLY->CurrentValue = NULL;
		$this->KDPOLY->OldValue = $this->KDPOLY->CurrentValue;
		$this->KDRUJUK->CurrentValue = NULL;
		$this->KDRUJUK->OldValue = $this->KDRUJUK->CurrentValue;
		$this->KDCARABAYAR->CurrentValue = NULL;
		$this->KDCARABAYAR->OldValue = $this->KDCARABAYAR->CurrentValue;
		$this->SHIFT->CurrentValue = 1;
		$this->NIP->CurrentValue = NULL;
		$this->NIP->OldValue = $this->NIP->CurrentValue;
		$this->KETRUJUK->CurrentValue = NULL;
		$this->KETRUJUK->OldValue = $this->KETRUJUK->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_NAMA->OldValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_HUBUNGAN->OldValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_ALAMAT->OldValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_PHONE->OldValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->NOKARTU->CurrentValue = NULL;
		$this->NOKARTU->OldValue = $this->NOKARTU->CurrentValue;
		$this->MINTA_RUJUKAN->CurrentValue = NULL;
		$this->MINTA_RUJUKAN->OldValue = $this->MINTA_RUJUKAN->CurrentValue;
		$this->pasien_TITLE->CurrentValue = NULL;
		$this->pasien_TITLE->OldValue = $this->pasien_TITLE->CurrentValue;
		$this->pasien_NAMA->CurrentValue = NULL;
		$this->pasien_NAMA->OldValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_TEMPAT->CurrentValue = NULL;
		$this->pasien_TEMPAT->OldValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TGLLAHIR->CurrentValue = date("d/m/Y");
		$this->pasien_JENISKELAMIN->CurrentValue = NULL;
		$this->pasien_JENISKELAMIN->OldValue = $this->pasien_JENISKELAMIN->CurrentValue;
		$this->pasien_ALAMAT->CurrentValue = NULL;
		$this->pasien_ALAMAT->OldValue = $this->pasien_ALAMAT->CurrentValue;
		$this->pasien_NOTELP->CurrentValue = NULL;
		$this->pasien_NOTELP->OldValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOKTP->CurrentValue = NULL;
		$this->pasien_NOKTP->OldValue = $this->pasien_NOKTP->CurrentValue;
		$this->pasien_PEKERJAAN->CurrentValue = NULL;
		$this->pasien_PEKERJAAN->OldValue = $this->pasien_PEKERJAAN->CurrentValue;
		$this->pasien_AGAMA->CurrentValue = NULL;
		$this->pasien_AGAMA->OldValue = $this->pasien_AGAMA->CurrentValue;
		$this->pasien_PENDIDIKAN->CurrentValue = NULL;
		$this->pasien_PENDIDIKAN->OldValue = $this->pasien_PENDIDIKAN->CurrentValue;
		$this->pasien_ALAMAT_KTP->CurrentValue = NULL;
		$this->pasien_ALAMAT_KTP->OldValue = $this->pasien_ALAMAT_KTP->CurrentValue;
		$this->pasien_NO_KARTU->CurrentValue = NULL;
		$this->pasien_NO_KARTU->OldValue = $this->pasien_NO_KARTU->CurrentValue;
		$this->pasien_JNS_PASIEN->CurrentValue = NULL;
		$this->pasien_JNS_PASIEN->OldValue = $this->pasien_JNS_PASIEN->CurrentValue;
		$this->pasien_nama_ayah->CurrentValue = NULL;
		$this->pasien_nama_ayah->OldValue = $this->pasien_nama_ayah->CurrentValue;
		$this->pasien_nama_ibu->CurrentValue = NULL;
		$this->pasien_nama_ibu->OldValue = $this->pasien_nama_ibu->CurrentValue;
		$this->pasien_nama_suami->CurrentValue = NULL;
		$this->pasien_nama_suami->OldValue = $this->pasien_nama_suami->CurrentValue;
		$this->pasien_nama_istri->CurrentValue = NULL;
		$this->pasien_nama_istri->OldValue = $this->pasien_nama_istri->CurrentValue;
		$this->pasien_KD_ETNIS->CurrentValue = NULL;
		$this->pasien_KD_ETNIS->OldValue = $this->pasien_KD_ETNIS->CurrentValue;
		$this->pasien_KD_BHS_HARIAN->CurrentValue = NULL;
		$this->pasien_KD_BHS_HARIAN->OldValue = $this->pasien_KD_BHS_HARIAN->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->PASIENBARU->FldIsDetailKey) {
			$this->PASIENBARU->setFormValue($objForm->GetValue("x_PASIENBARU"));
		}
		if (!$this->NOMR->FldIsDetailKey) {
			$this->NOMR->setFormValue($objForm->GetValue("x_NOMR"));
		}
		if (!$this->TGLREG->FldIsDetailKey) {
			$this->TGLREG->setFormValue($objForm->GetValue("x_TGLREG"));
			$this->TGLREG->CurrentValue = ew_UnFormatDateTime($this->TGLREG->CurrentValue, 7);
		}
		if (!$this->KDDOKTER->FldIsDetailKey) {
			$this->KDDOKTER->setFormValue($objForm->GetValue("x_KDDOKTER"));
		}
		if (!$this->KDPOLY->FldIsDetailKey) {
			$this->KDPOLY->setFormValue($objForm->GetValue("x_KDPOLY"));
		}
		if (!$this->KDRUJUK->FldIsDetailKey) {
			$this->KDRUJUK->setFormValue($objForm->GetValue("x_KDRUJUK"));
		}
		if (!$this->KDCARABAYAR->FldIsDetailKey) {
			$this->KDCARABAYAR->setFormValue($objForm->GetValue("x_KDCARABAYAR"));
		}
		if (!$this->SHIFT->FldIsDetailKey) {
			$this->SHIFT->setFormValue($objForm->GetValue("x_SHIFT"));
		}
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->KETRUJUK->FldIsDetailKey) {
			$this->KETRUJUK->setFormValue($objForm->GetValue("x_KETRUJUK"));
		}
		if (!$this->PENANGGUNGJAWAB_NAMA->FldIsDetailKey) {
			$this->PENANGGUNGJAWAB_NAMA->setFormValue($objForm->GetValue("x_PENANGGUNGJAWAB_NAMA"));
		}
		if (!$this->PENANGGUNGJAWAB_HUBUNGAN->FldIsDetailKey) {
			$this->PENANGGUNGJAWAB_HUBUNGAN->setFormValue($objForm->GetValue("x_PENANGGUNGJAWAB_HUBUNGAN"));
		}
		if (!$this->PENANGGUNGJAWAB_ALAMAT->FldIsDetailKey) {
			$this->PENANGGUNGJAWAB_ALAMAT->setFormValue($objForm->GetValue("x_PENANGGUNGJAWAB_ALAMAT"));
		}
		if (!$this->PENANGGUNGJAWAB_PHONE->FldIsDetailKey) {
			$this->PENANGGUNGJAWAB_PHONE->setFormValue($objForm->GetValue("x_PENANGGUNGJAWAB_PHONE"));
		}
		if (!$this->NOKARTU->FldIsDetailKey) {
			$this->NOKARTU->setFormValue($objForm->GetValue("x_NOKARTU"));
		}
		if (!$this->MINTA_RUJUKAN->FldIsDetailKey) {
			$this->MINTA_RUJUKAN->setFormValue($objForm->GetValue("x_MINTA_RUJUKAN"));
		}
		if (!$this->pasien_TITLE->FldIsDetailKey) {
			$this->pasien_TITLE->setFormValue($objForm->GetValue("x_pasien_TITLE"));
		}
		if (!$this->pasien_NAMA->FldIsDetailKey) {
			$this->pasien_NAMA->setFormValue($objForm->GetValue("x_pasien_NAMA"));
		}
		if (!$this->pasien_TEMPAT->FldIsDetailKey) {
			$this->pasien_TEMPAT->setFormValue($objForm->GetValue("x_pasien_TEMPAT"));
		}
		if (!$this->pasien_TGLLAHIR->FldIsDetailKey) {
			$this->pasien_TGLLAHIR->setFormValue($objForm->GetValue("x_pasien_TGLLAHIR"));
			$this->pasien_TGLLAHIR->CurrentValue = ew_UnFormatDateTime($this->pasien_TGLLAHIR->CurrentValue, 7);
		}
		if (!$this->pasien_JENISKELAMIN->FldIsDetailKey) {
			$this->pasien_JENISKELAMIN->setFormValue($objForm->GetValue("x_pasien_JENISKELAMIN"));
		}
		if (!$this->pasien_ALAMAT->FldIsDetailKey) {
			$this->pasien_ALAMAT->setFormValue($objForm->GetValue("x_pasien_ALAMAT"));
		}
		if (!$this->pasien_NOTELP->FldIsDetailKey) {
			$this->pasien_NOTELP->setFormValue($objForm->GetValue("x_pasien_NOTELP"));
		}
		if (!$this->pasien_NOKTP->FldIsDetailKey) {
			$this->pasien_NOKTP->setFormValue($objForm->GetValue("x_pasien_NOKTP"));
		}
		if (!$this->pasien_PEKERJAAN->FldIsDetailKey) {
			$this->pasien_PEKERJAAN->setFormValue($objForm->GetValue("x_pasien_PEKERJAAN"));
		}
		if (!$this->pasien_AGAMA->FldIsDetailKey) {
			$this->pasien_AGAMA->setFormValue($objForm->GetValue("x_pasien_AGAMA"));
		}
		if (!$this->pasien_PENDIDIKAN->FldIsDetailKey) {
			$this->pasien_PENDIDIKAN->setFormValue($objForm->GetValue("x_pasien_PENDIDIKAN"));
		}
		if (!$this->pasien_ALAMAT_KTP->FldIsDetailKey) {
			$this->pasien_ALAMAT_KTP->setFormValue($objForm->GetValue("x_pasien_ALAMAT_KTP"));
		}
		if (!$this->pasien_NO_KARTU->FldIsDetailKey) {
			$this->pasien_NO_KARTU->setFormValue($objForm->GetValue("x_pasien_NO_KARTU"));
		}
		if (!$this->pasien_JNS_PASIEN->FldIsDetailKey) {
			$this->pasien_JNS_PASIEN->setFormValue($objForm->GetValue("x_pasien_JNS_PASIEN"));
		}
		if (!$this->pasien_nama_ayah->FldIsDetailKey) {
			$this->pasien_nama_ayah->setFormValue($objForm->GetValue("x_pasien_nama_ayah"));
		}
		if (!$this->pasien_nama_ibu->FldIsDetailKey) {
			$this->pasien_nama_ibu->setFormValue($objForm->GetValue("x_pasien_nama_ibu"));
		}
		if (!$this->pasien_nama_suami->FldIsDetailKey) {
			$this->pasien_nama_suami->setFormValue($objForm->GetValue("x_pasien_nama_suami"));
		}
		if (!$this->pasien_nama_istri->FldIsDetailKey) {
			$this->pasien_nama_istri->setFormValue($objForm->GetValue("x_pasien_nama_istri"));
		}
		if (!$this->pasien_KD_ETNIS->FldIsDetailKey) {
			$this->pasien_KD_ETNIS->setFormValue($objForm->GetValue("x_pasien_KD_ETNIS"));
		}
		if (!$this->pasien_KD_BHS_HARIAN->FldIsDetailKey) {
			$this->pasien_KD_BHS_HARIAN->setFormValue($objForm->GetValue("x_pasien_KD_BHS_HARIAN"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->PASIENBARU->CurrentValue = $this->PASIENBARU->FormValue;
		$this->NOMR->CurrentValue = $this->NOMR->FormValue;
		$this->TGLREG->CurrentValue = $this->TGLREG->FormValue;
		$this->TGLREG->CurrentValue = ew_UnFormatDateTime($this->TGLREG->CurrentValue, 7);
		$this->KDDOKTER->CurrentValue = $this->KDDOKTER->FormValue;
		$this->KDPOLY->CurrentValue = $this->KDPOLY->FormValue;
		$this->KDRUJUK->CurrentValue = $this->KDRUJUK->FormValue;
		$this->KDCARABAYAR->CurrentValue = $this->KDCARABAYAR->FormValue;
		$this->SHIFT->CurrentValue = $this->SHIFT->FormValue;
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->KETRUJUK->CurrentValue = $this->KETRUJUK->FormValue;
		$this->PENANGGUNGJAWAB_NAMA->CurrentValue = $this->PENANGGUNGJAWAB_NAMA->FormValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue = $this->PENANGGUNGJAWAB_HUBUNGAN->FormValue;
		$this->PENANGGUNGJAWAB_ALAMAT->CurrentValue = $this->PENANGGUNGJAWAB_ALAMAT->FormValue;
		$this->PENANGGUNGJAWAB_PHONE->CurrentValue = $this->PENANGGUNGJAWAB_PHONE->FormValue;
		$this->NOKARTU->CurrentValue = $this->NOKARTU->FormValue;
		$this->MINTA_RUJUKAN->CurrentValue = $this->MINTA_RUJUKAN->FormValue;
		$this->pasien_TITLE->CurrentValue = $this->pasien_TITLE->FormValue;
		$this->pasien_NAMA->CurrentValue = $this->pasien_NAMA->FormValue;
		$this->pasien_TEMPAT->CurrentValue = $this->pasien_TEMPAT->FormValue;
		$this->pasien_TGLLAHIR->CurrentValue = $this->pasien_TGLLAHIR->FormValue;
		$this->pasien_TGLLAHIR->CurrentValue = ew_UnFormatDateTime($this->pasien_TGLLAHIR->CurrentValue, 7);
		$this->pasien_JENISKELAMIN->CurrentValue = $this->pasien_JENISKELAMIN->FormValue;
		$this->pasien_ALAMAT->CurrentValue = $this->pasien_ALAMAT->FormValue;
		$this->pasien_NOTELP->CurrentValue = $this->pasien_NOTELP->FormValue;
		$this->pasien_NOKTP->CurrentValue = $this->pasien_NOKTP->FormValue;
		$this->pasien_PEKERJAAN->CurrentValue = $this->pasien_PEKERJAAN->FormValue;
		$this->pasien_AGAMA->CurrentValue = $this->pasien_AGAMA->FormValue;
		$this->pasien_PENDIDIKAN->CurrentValue = $this->pasien_PENDIDIKAN->FormValue;
		$this->pasien_ALAMAT_KTP->CurrentValue = $this->pasien_ALAMAT_KTP->FormValue;
		$this->pasien_NO_KARTU->CurrentValue = $this->pasien_NO_KARTU->FormValue;
		$this->pasien_JNS_PASIEN->CurrentValue = $this->pasien_JNS_PASIEN->FormValue;
		$this->pasien_nama_ayah->CurrentValue = $this->pasien_nama_ayah->FormValue;
		$this->pasien_nama_ibu->CurrentValue = $this->pasien_nama_ibu->FormValue;
		$this->pasien_nama_suami->CurrentValue = $this->pasien_nama_suami->FormValue;
		$this->pasien_nama_istri->CurrentValue = $this->pasien_nama_istri->FormValue;
		$this->pasien_KD_ETNIS->CurrentValue = $this->pasien_KD_ETNIS->FormValue;
		$this->pasien_KD_BHS_HARIAN->CurrentValue = $this->pasien_KD_BHS_HARIAN->FormValue;
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
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NOJAMINAN->setDbValue($rs->fields('NOJAMINAN'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->KETERANGAN_STATUS->setDbValue($rs->fields('KETERANGAN_STATUS'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->MASUKPOLY->setDbValue($rs->fields('MASUKPOLY'));
		$this->KELUARPOLY->setDbValue($rs->fields('KELUARPOLY'));
		$this->KETRUJUK->setDbValue($rs->fields('KETRUJUK'));
		$this->KETBAYAR->setDbValue($rs->fields('KETBAYAR'));
		$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields('PENANGGUNGJAWAB_NAMA'));
		$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields('PENANGGUNGJAWAB_HUBUNGAN'));
		$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields('PENANGGUNGJAWAB_ALAMAT'));
		$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields('PENANGGUNGJAWAB_PHONE'));
		$this->JAMREG->setDbValue($rs->fields('JAMREG'));
		$this->BATAL->setDbValue($rs->fields('BATAL'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
		$this->NO_PESERTA->setDbValue($rs->fields('NO_PESERTA'));
		$this->NOKARTU->setDbValue($rs->fields('NOKARTU'));
		$this->TOTAL_BIAYA_OBAT->setDbValue($rs->fields('TOTAL_BIAYA_OBAT'));
		$this->biaya_obat->setDbValue($rs->fields('biaya_obat'));
		$this->biaya_retur_obat->setDbValue($rs->fields('biaya_retur_obat'));
		$this->TOTAL_BIAYA_OBAT_RAJAL->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_RAJAL'));
		$this->biaya_obat_rajal->setDbValue($rs->fields('biaya_obat_rajal'));
		$this->biaya_retur_obat_rajal->setDbValue($rs->fields('biaya_retur_obat_rajal'));
		$this->TOTAL_BIAYA_OBAT_IGD->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_IGD'));
		$this->biaya_obat_igd->setDbValue($rs->fields('biaya_obat_igd'));
		$this->biaya_retur_obat_igd->setDbValue($rs->fields('biaya_retur_obat_igd'));
		$this->TOTAL_BIAYA_OBAT_IBS->setDbValue($rs->fields('TOTAL_BIAYA_OBAT_IBS'));
		$this->biaya_obat_ibs->setDbValue($rs->fields('biaya_obat_ibs'));
		$this->biaya_retur_obat_ibs->setDbValue($rs->fields('biaya_retur_obat_ibs'));
		$this->TANGGAL_SEP->setDbValue($rs->fields('TANGGAL_SEP'));
		$this->TANGGALRUJUK_SEP->setDbValue($rs->fields('TANGGALRUJUK_SEP'));
		$this->KELASRAWAT_SEP->setDbValue($rs->fields('KELASRAWAT_SEP'));
		$this->MINTA_RUJUKAN->setDbValue($rs->fields('MINTA_RUJUKAN'));
		$this->NORUJUKAN_SEP->setDbValue($rs->fields('NORUJUKAN_SEP'));
		$this->PPKRUJUKANASAL_SEP->setDbValue($rs->fields('PPKRUJUKANASAL_SEP'));
		$this->NAMAPPKRUJUKANASAL_SEP->setDbValue($rs->fields('NAMAPPKRUJUKANASAL_SEP'));
		$this->PPKPELAYANAN_SEP->setDbValue($rs->fields('PPKPELAYANAN_SEP'));
		$this->JENISPERAWATAN_SEP->setDbValue($rs->fields('JENISPERAWATAN_SEP'));
		$this->CATATAN_SEP->setDbValue($rs->fields('CATATAN_SEP'));
		$this->DIAGNOSAAWAL_SEP->setDbValue($rs->fields('DIAGNOSAAWAL_SEP'));
		$this->NAMADIAGNOSA_SEP->setDbValue($rs->fields('NAMADIAGNOSA_SEP'));
		$this->LAKALANTAS_SEP->setDbValue($rs->fields('LAKALANTAS_SEP'));
		$this->LOKASILAKALANTAS->setDbValue($rs->fields('LOKASILAKALANTAS'));
		$this->USER->setDbValue($rs->fields('USER'));
		$this->cek_data_kepesertaan->setDbValue($rs->fields('cek_data_kepesertaan'));
		$this->generate_sep->setDbValue($rs->fields('generate_sep'));
		$this->PESERTANIK_SEP->setDbValue($rs->fields('PESERTANIK_SEP'));
		$this->PESERTANAMA_SEP->setDbValue($rs->fields('PESERTANAMA_SEP'));
		$this->PESERTAJENISKELAMIN_SEP->setDbValue($rs->fields('PESERTAJENISKELAMIN_SEP'));
		$this->PESERTANAMAKELAS_SEP->setDbValue($rs->fields('PESERTANAMAKELAS_SEP'));
		$this->PESERTAPISAT->setDbValue($rs->fields('PESERTAPISAT'));
		$this->PESERTATGLLAHIR->setDbValue($rs->fields('PESERTATGLLAHIR'));
		$this->PESERTAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTAJENISPESERTA_SEP'));
		$this->PESERTANAMAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTANAMAJENISPESERTA_SEP'));
		$this->PESERTATGLCETAKKARTU_SEP->setDbValue($rs->fields('PESERTATGLCETAKKARTU_SEP'));
		$this->POLITUJUAN_SEP->setDbValue($rs->fields('POLITUJUAN_SEP'));
		$this->NAMAPOLITUJUAN_SEP->setDbValue($rs->fields('NAMAPOLITUJUAN_SEP'));
		$this->KDPPKRUJUKAN_SEP->setDbValue($rs->fields('KDPPKRUJUKAN_SEP'));
		$this->NMPPKRUJUKAN_SEP->setDbValue($rs->fields('NMPPKRUJUKAN_SEP'));
		$this->UPDATETGLPLNG_SEP->setDbValue($rs->fields('UPDATETGLPLNG_SEP'));
		$this->bridging_upt_tglplng->setDbValue($rs->fields('bridging_upt_tglplng'));
		$this->mapingtransaksi->setDbValue($rs->fields('mapingtransaksi'));
		$this->bridging_no_rujukan->setDbValue($rs->fields('bridging_no_rujukan'));
		$this->bridging_hapus_sep->setDbValue($rs->fields('bridging_hapus_sep'));
		$this->bridging_kepesertaan_by_no_ka->setDbValue($rs->fields('bridging_kepesertaan_by_no_ka'));
		$this->NOKARTU_BPJS->setDbValue($rs->fields('NOKARTU_BPJS'));
		$this->counter_cetak_kartu->setDbValue($rs->fields('counter_cetak_kartu'));
		$this->bridging_kepesertaan_by_nik->setDbValue($rs->fields('bridging_kepesertaan_by_nik'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->bridging_by_no_rujukan->setDbValue($rs->fields('bridging_by_no_rujukan'));
		$this->maping_hapus_sep->setDbValue($rs->fields('maping_hapus_sep'));
		$this->counter_cetak_kartu_ranap->setDbValue($rs->fields('counter_cetak_kartu_ranap'));
		$this->BIAYA_PENDAFTARAN->setDbValue($rs->fields('BIAYA_PENDAFTARAN'));
		$this->BIAYA_TINDAKAN_POLI->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI'));
		$this->BIAYA_TINDAKAN_RADIOLOGI->setDbValue($rs->fields('BIAYA_TINDAKAN_RADIOLOGI'));
		$this->BIAYA_TINDAKAN_LABORAT->setDbValue($rs->fields('BIAYA_TINDAKAN_LABORAT'));
		$this->BIAYA_TINDAKAN_KONSULTASI->setDbValue($rs->fields('BIAYA_TINDAKAN_KONSULTASI'));
		$this->BIAYA_TARIF_DOKTER->setDbValue($rs->fields('BIAYA_TARIF_DOKTER'));
		$this->BIAYA_TARIF_DOKTER_KONSUL->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_KONSUL'));
		$this->INCLUDE->setDbValue($rs->fields('INCLUDE'));
		$this->eklaim_kelas_rawat_rajal->setDbValue($rs->fields('eklaim_kelas_rawat_rajal'));
		$this->eklaim_adl_score->setDbValue($rs->fields('eklaim_adl_score'));
		$this->eklaim_adl_sub_acute->setDbValue($rs->fields('eklaim_adl_sub_acute'));
		$this->eklaim_adl_chronic->setDbValue($rs->fields('eklaim_adl_chronic'));
		$this->eklaim_icu_indikator->setDbValue($rs->fields('eklaim_icu_indikator'));
		$this->eklaim_icu_los->setDbValue($rs->fields('eklaim_icu_los'));
		$this->eklaim_ventilator_hour->setDbValue($rs->fields('eklaim_ventilator_hour'));
		$this->eklaim_upgrade_class_ind->setDbValue($rs->fields('eklaim_upgrade_class_ind'));
		$this->eklaim_upgrade_class_class->setDbValue($rs->fields('eklaim_upgrade_class_class'));
		$this->eklaim_upgrade_class_los->setDbValue($rs->fields('eklaim_upgrade_class_los'));
		$this->eklaim_birth_weight->setDbValue($rs->fields('eklaim_birth_weight'));
		$this->eklaim_discharge_status->setDbValue($rs->fields('eklaim_discharge_status'));
		$this->eklaim_diagnosa->setDbValue($rs->fields('eklaim_diagnosa'));
		$this->eklaim_procedure->setDbValue($rs->fields('eklaim_procedure'));
		$this->eklaim_tarif_rs->setDbValue($rs->fields('eklaim_tarif_rs'));
		$this->eklaim_tarif_poli_eks->setDbValue($rs->fields('eklaim_tarif_poli_eks'));
		$this->eklaim_id_dokter->setDbValue($rs->fields('eklaim_id_dokter'));
		$this->eklaim_nama_dokter->setDbValue($rs->fields('eklaim_nama_dokter'));
		$this->eklaim_kode_tarif->setDbValue($rs->fields('eklaim_kode_tarif'));
		$this->eklaim_payor_id->setDbValue($rs->fields('eklaim_payor_id'));
		$this->eklaim_payor_cd->setDbValue($rs->fields('eklaim_payor_cd'));
		$this->eklaim_coder_nik->setDbValue($rs->fields('eklaim_coder_nik'));
		$this->eklaim_los->setDbValue($rs->fields('eklaim_los'));
		$this->eklaim_patient_id->setDbValue($rs->fields('eklaim_patient_id'));
		$this->eklaim_admission_id->setDbValue($rs->fields('eklaim_admission_id'));
		$this->eklaim_hospital_admission_id->setDbValue($rs->fields('eklaim_hospital_admission_id'));
		$this->bridging_hapussep->setDbValue($rs->fields('bridging_hapussep'));
		$this->user_penghapus_sep->setDbValue($rs->fields('user_penghapus_sep'));
		$this->BIAYA_BILLING_RAJAL->setDbValue($rs->fields('BIAYA_BILLING_RAJAL'));
		$this->STATUS_PEMBAYARAN->setDbValue($rs->fields('STATUS_PEMBAYARAN'));
		$this->BIAYA_TINDAKAN_FISIOTERAPI->setDbValue($rs->fields('BIAYA_TINDAKAN_FISIOTERAPI'));
		$this->eklaim_reg_pasien->setDbValue($rs->fields('eklaim_reg_pasien'));
		$this->eklaim_reg_klaim_baru->setDbValue($rs->fields('eklaim_reg_klaim_baru'));
		$this->eklaim_gruper1->setDbValue($rs->fields('eklaim_gruper1'));
		$this->eklaim_gruper2->setDbValue($rs->fields('eklaim_gruper2'));
		$this->eklaim_finalklaim->setDbValue($rs->fields('eklaim_finalklaim'));
		$this->eklaim_sendklaim->setDbValue($rs->fields('eklaim_sendklaim'));
		$this->eklaim_flag_hapus_pasien->setDbValue($rs->fields('eklaim_flag_hapus_pasien'));
		$this->eklaim_flag_hapus_klaim->setDbValue($rs->fields('eklaim_flag_hapus_klaim'));
		$this->eklaim_kemkes_dc_Status->setDbValue($rs->fields('eklaim_kemkes_dc_Status'));
		$this->eklaim_bpjs_dc_Status->setDbValue($rs->fields('eklaim_bpjs_dc_Status'));
		$this->eklaim_cbg_code->setDbValue($rs->fields('eklaim_cbg_code'));
		$this->eklaim_cbg_descprition->setDbValue($rs->fields('eklaim_cbg_descprition'));
		$this->eklaim_cbg_tariff->setDbValue($rs->fields('eklaim_cbg_tariff'));
		$this->eklaim_sub_acute_code->setDbValue($rs->fields('eklaim_sub_acute_code'));
		$this->eklaim_sub_acute_deskripsi->setDbValue($rs->fields('eklaim_sub_acute_deskripsi'));
		$this->eklaim_sub_acute_tariff->setDbValue($rs->fields('eklaim_sub_acute_tariff'));
		$this->eklaim_chronic_code->setDbValue($rs->fields('eklaim_chronic_code'));
		$this->eklaim_chronic_deskripsi->setDbValue($rs->fields('eklaim_chronic_deskripsi'));
		$this->eklaim_chronic_tariff->setDbValue($rs->fields('eklaim_chronic_tariff'));
		$this->eklaim_inacbg_version->setDbValue($rs->fields('eklaim_inacbg_version'));
		$this->BIAYA_TINDAKAN_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_IBS_RAJAL'));
		$this->VERIFY_ICD->setDbValue($rs->fields('VERIFY_ICD'));
		$this->bridging_rujukan_faskes_2->setDbValue($rs->fields('bridging_rujukan_faskes_2'));
		$this->eklaim_reedit_claim->setDbValue($rs->fields('eklaim_reedit_claim'));
		$this->KETERANGAN->setDbValue($rs->fields('KETERANGAN'));
		$this->TGLLAHIR->setDbValue($rs->fields('TGLLAHIR'));
		$this->USER_KASIR->setDbValue($rs->fields('USER_KASIR'));
		$this->eklaim_tgl_gruping->setDbValue($rs->fields('eklaim_tgl_gruping'));
		$this->eklaim_tgl_finalklaim->setDbValue($rs->fields('eklaim_tgl_finalklaim'));
		$this->eklaim_tgl_kirim_klaim->setDbValue($rs->fields('eklaim_tgl_kirim_klaim'));
		$this->BIAYA_OBAT_RS->setDbValue($rs->fields('BIAYA_OBAT_RS'));
		$this->EKG_RAJAL->setDbValue($rs->fields('EKG_RAJAL'));
		$this->USG_RAJAL->setDbValue($rs->fields('USG_RAJAL'));
		$this->FISIOTERAPI_RAJAL->setDbValue($rs->fields('FISIOTERAPI_RAJAL'));
		$this->BHP_RAJAL->setDbValue($rs->fields('BHP_RAJAL'));
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_ASKEP_IBS_RAJAL'));
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->setDbValue($rs->fields('BIAYA_TINDAKAN_TMNO_IBS_RAJAL'));
		$this->TOTAL_BIAYA_IBS_RAJAL->setDbValue($rs->fields('TOTAL_BIAYA_IBS_RAJAL'));
		$this->ORDER_LAB->setDbValue($rs->fields('ORDER_LAB'));
		$this->BILL_RAJAL_SELESAI->setDbValue($rs->fields('BILL_RAJAL_SELESAI'));
		$this->INCLUDE_IDXDAFTAR->setDbValue($rs->fields('INCLUDE_IDXDAFTAR'));
		$this->INCLUDE_HARGA->setDbValue($rs->fields('INCLUDE_HARGA'));
		$this->TARIF_JASA_SARANA->setDbValue($rs->fields('TARIF_JASA_SARANA'));
		$this->TARIF_PENUNJANG_NON_MEDIS->setDbValue($rs->fields('TARIF_PENUNJANG_NON_MEDIS'));
		$this->TARIF_ASUHAN_KEPERAWATAN->setDbValue($rs->fields('TARIF_ASUHAN_KEPERAWATAN'));
		$this->KDDOKTER_RAJAL->setDbValue($rs->fields('KDDOKTER_RAJAL'));
		$this->KDDOKTER_KONSUL_RAJAL->setDbValue($rs->fields('KDDOKTER_KONSUL_RAJAL'));
		$this->BIAYA_BILLING_RS->setDbValue($rs->fields('BIAYA_BILLING_RS'));
		$this->BIAYA_TINDAKAN_POLI_TMO->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_TMO'));
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_KEPERAWATAN'));
		$this->BHP_RAJAL_TMO->setDbValue($rs->fields('BHP_RAJAL_TMO'));
		$this->BHP_RAJAL_KEPERAWATAN->setDbValue($rs->fields('BHP_RAJAL_KEPERAWATAN'));
		$this->TARIF_AKOMODASI->setDbValue($rs->fields('TARIF_AKOMODASI'));
		$this->TARIF_AMBULAN->setDbValue($rs->fields('TARIF_AMBULAN'));
		$this->TARIF_OKSIGEN->setDbValue($rs->fields('TARIF_OKSIGEN'));
		$this->BIAYA_TINDAKAN_JENAZAH->setDbValue($rs->fields('BIAYA_TINDAKAN_JENAZAH'));
		$this->BIAYA_BILLING_IGD->setDbValue($rs->fields('BIAYA_BILLING_IGD'));
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->setDbValue($rs->fields('BIAYA_TINDAKAN_POLI_PERSALINAN'));
		$this->BHP_RAJAL_PERSALINAN->setDbValue($rs->fields('BHP_RAJAL_PERSALINAN'));
		$this->TARIF_BIMBINGAN_ROHANI->setDbValue($rs->fields('TARIF_BIMBINGAN_ROHANI'));
		$this->BIAYA_BILLING_RS2->setDbValue($rs->fields('BIAYA_BILLING_RS2'));
		$this->BIAYA_TARIF_DOKTER_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_IGD'));
		$this->BIAYA_PENDAFTARAN_IGD->setDbValue($rs->fields('BIAYA_PENDAFTARAN_IGD'));
		$this->BIAYA_BILLING_IBS->setDbValue($rs->fields('BIAYA_BILLING_IBS'));
		$this->TARIF_JASA_SARANA_IGD->setDbValue($rs->fields('TARIF_JASA_SARANA_IGD'));
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_SPESIALIS_IGD'));
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->setDbValue($rs->fields('BIAYA_TARIF_DOKTER_KONSUL_IGD'));
		$this->TARIF_MAKAN_IGD->setDbValue($rs->fields('TARIF_MAKAN_IGD'));
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->setDbValue($rs->fields('TARIF_ASUHAN_KEPERAWATAN_IGD'));
		$this->pasien_TITLE->setDbValue($rs->fields('pasien_TITLE'));
		$this->pasien_NAMA->setDbValue($rs->fields('pasien_NAMA'));
		$this->pasien_TEMPAT->setDbValue($rs->fields('pasien_TEMPAT'));
		$this->pasien_TGLLAHIR->setDbValue($rs->fields('pasien_TGLLAHIR'));
		$this->pasien_JENISKELAMIN->setDbValue($rs->fields('pasien_JENISKELAMIN'));
		$this->pasien_ALAMAT->setDbValue($rs->fields('pasien_ALAMAT'));
		$this->pasien_KELURAHAN->setDbValue($rs->fields('pasien_KELURAHAN'));
		$this->pasien_KDKECAMATAN->setDbValue($rs->fields('pasien_KDKECAMATAN'));
		$this->pasien_KOTA->setDbValue($rs->fields('pasien_KOTA'));
		$this->pasien_KDPROVINSI->setDbValue($rs->fields('pasien_KDPROVINSI'));
		$this->pasien_NOTELP->setDbValue($rs->fields('pasien_NOTELP'));
		$this->pasien_NOKTP->setDbValue($rs->fields('pasien_NOKTP'));
		$this->pasien_SUAMI_ORTU->setDbValue($rs->fields('pasien_SUAMI_ORTU'));
		$this->pasien_PEKERJAAN->setDbValue($rs->fields('pasien_PEKERJAAN'));
		$this->pasien_AGAMA->setDbValue($rs->fields('pasien_AGAMA'));
		$this->pasien_PENDIDIKAN->setDbValue($rs->fields('pasien_PENDIDIKAN'));
		$this->pasien_ALAMAT_KTP->setDbValue($rs->fields('pasien_ALAMAT_KTP'));
		$this->pasien_NO_KARTU->setDbValue($rs->fields('pasien_NO_KARTU'));
		$this->pasien_JNS_PASIEN->setDbValue($rs->fields('pasien_JNS_PASIEN'));
		$this->pasien_nama_ayah->setDbValue($rs->fields('pasien_nama_ayah'));
		$this->pasien_nama_ibu->setDbValue($rs->fields('pasien_nama_ibu'));
		$this->pasien_nama_suami->setDbValue($rs->fields('pasien_nama_suami'));
		$this->pasien_nama_istri->setDbValue($rs->fields('pasien_nama_istri'));
		$this->pasien_KD_ETNIS->setDbValue($rs->fields('pasien_KD_ETNIS'));
		$this->pasien_KD_BHS_HARIAN->setDbValue($rs->fields('pasien_KD_BHS_HARIAN'));
		$this->BILL_FARMASI_SELESAI->setDbValue($rs->fields('BILL_FARMASI_SELESAI'));
		$this->TARIF_PELAYANAN_SIMRS->setDbValue($rs->fields('TARIF_PELAYANAN_SIMRS'));
		$this->USER_ADM->setDbValue($rs->fields('USER_ADM'));
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->setDbValue($rs->fields('TARIF_PENUNJANG_NON_MEDIS_IGD'));
		$this->TARIF_PELAYANAN_DARAH->setDbValue($rs->fields('TARIF_PELAYANAN_DARAH'));
		$this->penjamin_kkl_id->setDbValue($rs->fields('penjamin_kkl_id'));
		$this->asalfaskesrujukan_id->setDbValue($rs->fields('asalfaskesrujukan_id'));
		$this->peserta_cob->setDbValue($rs->fields('peserta_cob'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->status_kepesertaan_BPJS->setDbValue($rs->fields('status_kepesertaan_BPJS'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->PASIENBARU->DbValue = $row['PASIENBARU'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->KDDOKTER->DbValue = $row['KDDOKTER'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NOJAMINAN->DbValue = $row['NOJAMINAN'];
		$this->SHIFT->DbValue = $row['SHIFT'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->KETERANGAN_STATUS->DbValue = $row['KETERANGAN_STATUS'];
		$this->NIP->DbValue = $row['NIP'];
		$this->MASUKPOLY->DbValue = $row['MASUKPOLY'];
		$this->KELUARPOLY->DbValue = $row['KELUARPOLY'];
		$this->KETRUJUK->DbValue = $row['KETRUJUK'];
		$this->KETBAYAR->DbValue = $row['KETBAYAR'];
		$this->PENANGGUNGJAWAB_NAMA->DbValue = $row['PENANGGUNGJAWAB_NAMA'];
		$this->PENANGGUNGJAWAB_HUBUNGAN->DbValue = $row['PENANGGUNGJAWAB_HUBUNGAN'];
		$this->PENANGGUNGJAWAB_ALAMAT->DbValue = $row['PENANGGUNGJAWAB_ALAMAT'];
		$this->PENANGGUNGJAWAB_PHONE->DbValue = $row['PENANGGUNGJAWAB_PHONE'];
		$this->JAMREG->DbValue = $row['JAMREG'];
		$this->BATAL->DbValue = $row['BATAL'];
		$this->NO_SJP->DbValue = $row['NO_SJP'];
		$this->NO_PESERTA->DbValue = $row['NO_PESERTA'];
		$this->NOKARTU->DbValue = $row['NOKARTU'];
		$this->TOTAL_BIAYA_OBAT->DbValue = $row['TOTAL_BIAYA_OBAT'];
		$this->biaya_obat->DbValue = $row['biaya_obat'];
		$this->biaya_retur_obat->DbValue = $row['biaya_retur_obat'];
		$this->TOTAL_BIAYA_OBAT_RAJAL->DbValue = $row['TOTAL_BIAYA_OBAT_RAJAL'];
		$this->biaya_obat_rajal->DbValue = $row['biaya_obat_rajal'];
		$this->biaya_retur_obat_rajal->DbValue = $row['biaya_retur_obat_rajal'];
		$this->TOTAL_BIAYA_OBAT_IGD->DbValue = $row['TOTAL_BIAYA_OBAT_IGD'];
		$this->biaya_obat_igd->DbValue = $row['biaya_obat_igd'];
		$this->biaya_retur_obat_igd->DbValue = $row['biaya_retur_obat_igd'];
		$this->TOTAL_BIAYA_OBAT_IBS->DbValue = $row['TOTAL_BIAYA_OBAT_IBS'];
		$this->biaya_obat_ibs->DbValue = $row['biaya_obat_ibs'];
		$this->biaya_retur_obat_ibs->DbValue = $row['biaya_retur_obat_ibs'];
		$this->TANGGAL_SEP->DbValue = $row['TANGGAL_SEP'];
		$this->TANGGALRUJUK_SEP->DbValue = $row['TANGGALRUJUK_SEP'];
		$this->KELASRAWAT_SEP->DbValue = $row['KELASRAWAT_SEP'];
		$this->MINTA_RUJUKAN->DbValue = $row['MINTA_RUJUKAN'];
		$this->NORUJUKAN_SEP->DbValue = $row['NORUJUKAN_SEP'];
		$this->PPKRUJUKANASAL_SEP->DbValue = $row['PPKRUJUKANASAL_SEP'];
		$this->NAMAPPKRUJUKANASAL_SEP->DbValue = $row['NAMAPPKRUJUKANASAL_SEP'];
		$this->PPKPELAYANAN_SEP->DbValue = $row['PPKPELAYANAN_SEP'];
		$this->JENISPERAWATAN_SEP->DbValue = $row['JENISPERAWATAN_SEP'];
		$this->CATATAN_SEP->DbValue = $row['CATATAN_SEP'];
		$this->DIAGNOSAAWAL_SEP->DbValue = $row['DIAGNOSAAWAL_SEP'];
		$this->NAMADIAGNOSA_SEP->DbValue = $row['NAMADIAGNOSA_SEP'];
		$this->LAKALANTAS_SEP->DbValue = $row['LAKALANTAS_SEP'];
		$this->LOKASILAKALANTAS->DbValue = $row['LOKASILAKALANTAS'];
		$this->USER->DbValue = $row['USER'];
		$this->cek_data_kepesertaan->DbValue = $row['cek_data_kepesertaan'];
		$this->generate_sep->DbValue = $row['generate_sep'];
		$this->PESERTANIK_SEP->DbValue = $row['PESERTANIK_SEP'];
		$this->PESERTANAMA_SEP->DbValue = $row['PESERTANAMA_SEP'];
		$this->PESERTAJENISKELAMIN_SEP->DbValue = $row['PESERTAJENISKELAMIN_SEP'];
		$this->PESERTANAMAKELAS_SEP->DbValue = $row['PESERTANAMAKELAS_SEP'];
		$this->PESERTAPISAT->DbValue = $row['PESERTAPISAT'];
		$this->PESERTATGLLAHIR->DbValue = $row['PESERTATGLLAHIR'];
		$this->PESERTAJENISPESERTA_SEP->DbValue = $row['PESERTAJENISPESERTA_SEP'];
		$this->PESERTANAMAJENISPESERTA_SEP->DbValue = $row['PESERTANAMAJENISPESERTA_SEP'];
		$this->PESERTATGLCETAKKARTU_SEP->DbValue = $row['PESERTATGLCETAKKARTU_SEP'];
		$this->POLITUJUAN_SEP->DbValue = $row['POLITUJUAN_SEP'];
		$this->NAMAPOLITUJUAN_SEP->DbValue = $row['NAMAPOLITUJUAN_SEP'];
		$this->KDPPKRUJUKAN_SEP->DbValue = $row['KDPPKRUJUKAN_SEP'];
		$this->NMPPKRUJUKAN_SEP->DbValue = $row['NMPPKRUJUKAN_SEP'];
		$this->UPDATETGLPLNG_SEP->DbValue = $row['UPDATETGLPLNG_SEP'];
		$this->bridging_upt_tglplng->DbValue = $row['bridging_upt_tglplng'];
		$this->mapingtransaksi->DbValue = $row['mapingtransaksi'];
		$this->bridging_no_rujukan->DbValue = $row['bridging_no_rujukan'];
		$this->bridging_hapus_sep->DbValue = $row['bridging_hapus_sep'];
		$this->bridging_kepesertaan_by_no_ka->DbValue = $row['bridging_kepesertaan_by_no_ka'];
		$this->NOKARTU_BPJS->DbValue = $row['NOKARTU_BPJS'];
		$this->counter_cetak_kartu->DbValue = $row['counter_cetak_kartu'];
		$this->bridging_kepesertaan_by_nik->DbValue = $row['bridging_kepesertaan_by_nik'];
		$this->NOKTP->DbValue = $row['NOKTP'];
		$this->bridging_by_no_rujukan->DbValue = $row['bridging_by_no_rujukan'];
		$this->maping_hapus_sep->DbValue = $row['maping_hapus_sep'];
		$this->counter_cetak_kartu_ranap->DbValue = $row['counter_cetak_kartu_ranap'];
		$this->BIAYA_PENDAFTARAN->DbValue = $row['BIAYA_PENDAFTARAN'];
		$this->BIAYA_TINDAKAN_POLI->DbValue = $row['BIAYA_TINDAKAN_POLI'];
		$this->BIAYA_TINDAKAN_RADIOLOGI->DbValue = $row['BIAYA_TINDAKAN_RADIOLOGI'];
		$this->BIAYA_TINDAKAN_LABORAT->DbValue = $row['BIAYA_TINDAKAN_LABORAT'];
		$this->BIAYA_TINDAKAN_KONSULTASI->DbValue = $row['BIAYA_TINDAKAN_KONSULTASI'];
		$this->BIAYA_TARIF_DOKTER->DbValue = $row['BIAYA_TARIF_DOKTER'];
		$this->BIAYA_TARIF_DOKTER_KONSUL->DbValue = $row['BIAYA_TARIF_DOKTER_KONSUL'];
		$this->INCLUDE->DbValue = $row['INCLUDE'];
		$this->eklaim_kelas_rawat_rajal->DbValue = $row['eklaim_kelas_rawat_rajal'];
		$this->eklaim_adl_score->DbValue = $row['eklaim_adl_score'];
		$this->eklaim_adl_sub_acute->DbValue = $row['eklaim_adl_sub_acute'];
		$this->eklaim_adl_chronic->DbValue = $row['eklaim_adl_chronic'];
		$this->eklaim_icu_indikator->DbValue = $row['eklaim_icu_indikator'];
		$this->eklaim_icu_los->DbValue = $row['eklaim_icu_los'];
		$this->eklaim_ventilator_hour->DbValue = $row['eklaim_ventilator_hour'];
		$this->eklaim_upgrade_class_ind->DbValue = $row['eklaim_upgrade_class_ind'];
		$this->eklaim_upgrade_class_class->DbValue = $row['eklaim_upgrade_class_class'];
		$this->eklaim_upgrade_class_los->DbValue = $row['eklaim_upgrade_class_los'];
		$this->eklaim_birth_weight->DbValue = $row['eklaim_birth_weight'];
		$this->eklaim_discharge_status->DbValue = $row['eklaim_discharge_status'];
		$this->eklaim_diagnosa->DbValue = $row['eklaim_diagnosa'];
		$this->eklaim_procedure->DbValue = $row['eklaim_procedure'];
		$this->eklaim_tarif_rs->DbValue = $row['eklaim_tarif_rs'];
		$this->eklaim_tarif_poli_eks->DbValue = $row['eklaim_tarif_poli_eks'];
		$this->eklaim_id_dokter->DbValue = $row['eklaim_id_dokter'];
		$this->eklaim_nama_dokter->DbValue = $row['eklaim_nama_dokter'];
		$this->eklaim_kode_tarif->DbValue = $row['eklaim_kode_tarif'];
		$this->eklaim_payor_id->DbValue = $row['eklaim_payor_id'];
		$this->eklaim_payor_cd->DbValue = $row['eklaim_payor_cd'];
		$this->eklaim_coder_nik->DbValue = $row['eklaim_coder_nik'];
		$this->eklaim_los->DbValue = $row['eklaim_los'];
		$this->eklaim_patient_id->DbValue = $row['eklaim_patient_id'];
		$this->eklaim_admission_id->DbValue = $row['eklaim_admission_id'];
		$this->eklaim_hospital_admission_id->DbValue = $row['eklaim_hospital_admission_id'];
		$this->bridging_hapussep->DbValue = $row['bridging_hapussep'];
		$this->user_penghapus_sep->DbValue = $row['user_penghapus_sep'];
		$this->BIAYA_BILLING_RAJAL->DbValue = $row['BIAYA_BILLING_RAJAL'];
		$this->STATUS_PEMBAYARAN->DbValue = $row['STATUS_PEMBAYARAN'];
		$this->BIAYA_TINDAKAN_FISIOTERAPI->DbValue = $row['BIAYA_TINDAKAN_FISIOTERAPI'];
		$this->eklaim_reg_pasien->DbValue = $row['eklaim_reg_pasien'];
		$this->eklaim_reg_klaim_baru->DbValue = $row['eklaim_reg_klaim_baru'];
		$this->eklaim_gruper1->DbValue = $row['eklaim_gruper1'];
		$this->eklaim_gruper2->DbValue = $row['eklaim_gruper2'];
		$this->eklaim_finalklaim->DbValue = $row['eklaim_finalklaim'];
		$this->eklaim_sendklaim->DbValue = $row['eklaim_sendklaim'];
		$this->eklaim_flag_hapus_pasien->DbValue = $row['eklaim_flag_hapus_pasien'];
		$this->eklaim_flag_hapus_klaim->DbValue = $row['eklaim_flag_hapus_klaim'];
		$this->eklaim_kemkes_dc_Status->DbValue = $row['eklaim_kemkes_dc_Status'];
		$this->eklaim_bpjs_dc_Status->DbValue = $row['eklaim_bpjs_dc_Status'];
		$this->eklaim_cbg_code->DbValue = $row['eklaim_cbg_code'];
		$this->eklaim_cbg_descprition->DbValue = $row['eklaim_cbg_descprition'];
		$this->eklaim_cbg_tariff->DbValue = $row['eklaim_cbg_tariff'];
		$this->eklaim_sub_acute_code->DbValue = $row['eklaim_sub_acute_code'];
		$this->eklaim_sub_acute_deskripsi->DbValue = $row['eklaim_sub_acute_deskripsi'];
		$this->eklaim_sub_acute_tariff->DbValue = $row['eklaim_sub_acute_tariff'];
		$this->eklaim_chronic_code->DbValue = $row['eklaim_chronic_code'];
		$this->eklaim_chronic_deskripsi->DbValue = $row['eklaim_chronic_deskripsi'];
		$this->eklaim_chronic_tariff->DbValue = $row['eklaim_chronic_tariff'];
		$this->eklaim_inacbg_version->DbValue = $row['eklaim_inacbg_version'];
		$this->BIAYA_TINDAKAN_IBS_RAJAL->DbValue = $row['BIAYA_TINDAKAN_IBS_RAJAL'];
		$this->VERIFY_ICD->DbValue = $row['VERIFY_ICD'];
		$this->bridging_rujukan_faskes_2->DbValue = $row['bridging_rujukan_faskes_2'];
		$this->eklaim_reedit_claim->DbValue = $row['eklaim_reedit_claim'];
		$this->KETERANGAN->DbValue = $row['KETERANGAN'];
		$this->TGLLAHIR->DbValue = $row['TGLLAHIR'];
		$this->USER_KASIR->DbValue = $row['USER_KASIR'];
		$this->eklaim_tgl_gruping->DbValue = $row['eklaim_tgl_gruping'];
		$this->eklaim_tgl_finalklaim->DbValue = $row['eklaim_tgl_finalklaim'];
		$this->eklaim_tgl_kirim_klaim->DbValue = $row['eklaim_tgl_kirim_klaim'];
		$this->BIAYA_OBAT_RS->DbValue = $row['BIAYA_OBAT_RS'];
		$this->EKG_RAJAL->DbValue = $row['EKG_RAJAL'];
		$this->USG_RAJAL->DbValue = $row['USG_RAJAL'];
		$this->FISIOTERAPI_RAJAL->DbValue = $row['FISIOTERAPI_RAJAL'];
		$this->BHP_RAJAL->DbValue = $row['BHP_RAJAL'];
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->DbValue = $row['BIAYA_TINDAKAN_ASKEP_IBS_RAJAL'];
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->DbValue = $row['BIAYA_TINDAKAN_TMNO_IBS_RAJAL'];
		$this->TOTAL_BIAYA_IBS_RAJAL->DbValue = $row['TOTAL_BIAYA_IBS_RAJAL'];
		$this->ORDER_LAB->DbValue = $row['ORDER_LAB'];
		$this->BILL_RAJAL_SELESAI->DbValue = $row['BILL_RAJAL_SELESAI'];
		$this->INCLUDE_IDXDAFTAR->DbValue = $row['INCLUDE_IDXDAFTAR'];
		$this->INCLUDE_HARGA->DbValue = $row['INCLUDE_HARGA'];
		$this->TARIF_JASA_SARANA->DbValue = $row['TARIF_JASA_SARANA'];
		$this->TARIF_PENUNJANG_NON_MEDIS->DbValue = $row['TARIF_PENUNJANG_NON_MEDIS'];
		$this->TARIF_ASUHAN_KEPERAWATAN->DbValue = $row['TARIF_ASUHAN_KEPERAWATAN'];
		$this->KDDOKTER_RAJAL->DbValue = $row['KDDOKTER_RAJAL'];
		$this->KDDOKTER_KONSUL_RAJAL->DbValue = $row['KDDOKTER_KONSUL_RAJAL'];
		$this->BIAYA_BILLING_RS->DbValue = $row['BIAYA_BILLING_RS'];
		$this->BIAYA_TINDAKAN_POLI_TMO->DbValue = $row['BIAYA_TINDAKAN_POLI_TMO'];
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->DbValue = $row['BIAYA_TINDAKAN_POLI_KEPERAWATAN'];
		$this->BHP_RAJAL_TMO->DbValue = $row['BHP_RAJAL_TMO'];
		$this->BHP_RAJAL_KEPERAWATAN->DbValue = $row['BHP_RAJAL_KEPERAWATAN'];
		$this->TARIF_AKOMODASI->DbValue = $row['TARIF_AKOMODASI'];
		$this->TARIF_AMBULAN->DbValue = $row['TARIF_AMBULAN'];
		$this->TARIF_OKSIGEN->DbValue = $row['TARIF_OKSIGEN'];
		$this->BIAYA_TINDAKAN_JENAZAH->DbValue = $row['BIAYA_TINDAKAN_JENAZAH'];
		$this->BIAYA_BILLING_IGD->DbValue = $row['BIAYA_BILLING_IGD'];
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->DbValue = $row['BIAYA_TINDAKAN_POLI_PERSALINAN'];
		$this->BHP_RAJAL_PERSALINAN->DbValue = $row['BHP_RAJAL_PERSALINAN'];
		$this->TARIF_BIMBINGAN_ROHANI->DbValue = $row['TARIF_BIMBINGAN_ROHANI'];
		$this->BIAYA_BILLING_RS2->DbValue = $row['BIAYA_BILLING_RS2'];
		$this->BIAYA_TARIF_DOKTER_IGD->DbValue = $row['BIAYA_TARIF_DOKTER_IGD'];
		$this->BIAYA_PENDAFTARAN_IGD->DbValue = $row['BIAYA_PENDAFTARAN_IGD'];
		$this->BIAYA_BILLING_IBS->DbValue = $row['BIAYA_BILLING_IBS'];
		$this->TARIF_JASA_SARANA_IGD->DbValue = $row['TARIF_JASA_SARANA_IGD'];
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->DbValue = $row['BIAYA_TARIF_DOKTER_SPESIALIS_IGD'];
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->DbValue = $row['BIAYA_TARIF_DOKTER_KONSUL_IGD'];
		$this->TARIF_MAKAN_IGD->DbValue = $row['TARIF_MAKAN_IGD'];
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->DbValue = $row['TARIF_ASUHAN_KEPERAWATAN_IGD'];
		$this->pasien_TITLE->DbValue = $row['pasien_TITLE'];
		$this->pasien_NAMA->DbValue = $row['pasien_NAMA'];
		$this->pasien_TEMPAT->DbValue = $row['pasien_TEMPAT'];
		$this->pasien_TGLLAHIR->DbValue = $row['pasien_TGLLAHIR'];
		$this->pasien_JENISKELAMIN->DbValue = $row['pasien_JENISKELAMIN'];
		$this->pasien_ALAMAT->DbValue = $row['pasien_ALAMAT'];
		$this->pasien_KELURAHAN->DbValue = $row['pasien_KELURAHAN'];
		$this->pasien_KDKECAMATAN->DbValue = $row['pasien_KDKECAMATAN'];
		$this->pasien_KOTA->DbValue = $row['pasien_KOTA'];
		$this->pasien_KDPROVINSI->DbValue = $row['pasien_KDPROVINSI'];
		$this->pasien_NOTELP->DbValue = $row['pasien_NOTELP'];
		$this->pasien_NOKTP->DbValue = $row['pasien_NOKTP'];
		$this->pasien_SUAMI_ORTU->DbValue = $row['pasien_SUAMI_ORTU'];
		$this->pasien_PEKERJAAN->DbValue = $row['pasien_PEKERJAAN'];
		$this->pasien_AGAMA->DbValue = $row['pasien_AGAMA'];
		$this->pasien_PENDIDIKAN->DbValue = $row['pasien_PENDIDIKAN'];
		$this->pasien_ALAMAT_KTP->DbValue = $row['pasien_ALAMAT_KTP'];
		$this->pasien_NO_KARTU->DbValue = $row['pasien_NO_KARTU'];
		$this->pasien_JNS_PASIEN->DbValue = $row['pasien_JNS_PASIEN'];
		$this->pasien_nama_ayah->DbValue = $row['pasien_nama_ayah'];
		$this->pasien_nama_ibu->DbValue = $row['pasien_nama_ibu'];
		$this->pasien_nama_suami->DbValue = $row['pasien_nama_suami'];
		$this->pasien_nama_istri->DbValue = $row['pasien_nama_istri'];
		$this->pasien_KD_ETNIS->DbValue = $row['pasien_KD_ETNIS'];
		$this->pasien_KD_BHS_HARIAN->DbValue = $row['pasien_KD_BHS_HARIAN'];
		$this->BILL_FARMASI_SELESAI->DbValue = $row['BILL_FARMASI_SELESAI'];
		$this->TARIF_PELAYANAN_SIMRS->DbValue = $row['TARIF_PELAYANAN_SIMRS'];
		$this->USER_ADM->DbValue = $row['USER_ADM'];
		$this->TARIF_PENUNJANG_NON_MEDIS_IGD->DbValue = $row['TARIF_PENUNJANG_NON_MEDIS_IGD'];
		$this->TARIF_PELAYANAN_DARAH->DbValue = $row['TARIF_PELAYANAN_DARAH'];
		$this->penjamin_kkl_id->DbValue = $row['penjamin_kkl_id'];
		$this->asalfaskesrujukan_id->DbValue = $row['asalfaskesrujukan_id'];
		$this->peserta_cob->DbValue = $row['peserta_cob'];
		$this->poli_eksekutif->DbValue = $row['poli_eksekutif'];
		$this->status_kepesertaan_BPJS->DbValue = $row['status_kepesertaan_BPJS'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("IDXDAFTAR")) <> "")
			$this->IDXDAFTAR->CurrentValue = $this->getKey("IDXDAFTAR"); // IDXDAFTAR
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
		// IDXDAFTAR
		// PASIENBARU
		// NOMR
		// TGLREG
		// KDDOKTER
		// KDPOLY
		// KDRUJUK
		// KDCARABAYAR
		// NOJAMINAN
		// SHIFT
		// STATUS
		// KETERANGAN_STATUS
		// NIP
		// MASUKPOLY
		// KELUARPOLY
		// KETRUJUK
		// KETBAYAR
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// JAMREG
		// BATAL
		// NO_SJP
		// NO_PESERTA
		// NOKARTU
		// TOTAL_BIAYA_OBAT
		// biaya_obat
		// biaya_retur_obat
		// TOTAL_BIAYA_OBAT_RAJAL
		// biaya_obat_rajal
		// biaya_retur_obat_rajal
		// TOTAL_BIAYA_OBAT_IGD
		// biaya_obat_igd
		// biaya_retur_obat_igd
		// TOTAL_BIAYA_OBAT_IBS
		// biaya_obat_ibs
		// biaya_retur_obat_ibs
		// TANGGAL_SEP
		// TANGGALRUJUK_SEP
		// KELASRAWAT_SEP
		// MINTA_RUJUKAN
		// NORUJUKAN_SEP
		// PPKRUJUKANASAL_SEP
		// NAMAPPKRUJUKANASAL_SEP
		// PPKPELAYANAN_SEP
		// JENISPERAWATAN_SEP
		// CATATAN_SEP
		// DIAGNOSAAWAL_SEP
		// NAMADIAGNOSA_SEP
		// LAKALANTAS_SEP
		// LOKASILAKALANTAS
		// USER
		// cek_data_kepesertaan
		// generate_sep
		// PESERTANIK_SEP
		// PESERTANAMA_SEP
		// PESERTAJENISKELAMIN_SEP
		// PESERTANAMAKELAS_SEP
		// PESERTAPISAT
		// PESERTATGLLAHIR
		// PESERTAJENISPESERTA_SEP
		// PESERTANAMAJENISPESERTA_SEP
		// PESERTATGLCETAKKARTU_SEP
		// POLITUJUAN_SEP
		// NAMAPOLITUJUAN_SEP
		// KDPPKRUJUKAN_SEP
		// NMPPKRUJUKAN_SEP
		// UPDATETGLPLNG_SEP
		// bridging_upt_tglplng
		// mapingtransaksi
		// bridging_no_rujukan
		// bridging_hapus_sep
		// bridging_kepesertaan_by_no_ka
		// NOKARTU_BPJS
		// counter_cetak_kartu
		// bridging_kepesertaan_by_nik
		// NOKTP
		// bridging_by_no_rujukan
		// maping_hapus_sep
		// counter_cetak_kartu_ranap
		// BIAYA_PENDAFTARAN
		// BIAYA_TINDAKAN_POLI
		// BIAYA_TINDAKAN_RADIOLOGI
		// BIAYA_TINDAKAN_LABORAT
		// BIAYA_TINDAKAN_KONSULTASI
		// BIAYA_TARIF_DOKTER
		// BIAYA_TARIF_DOKTER_KONSUL
		// INCLUDE
		// eklaim_kelas_rawat_rajal
		// eklaim_adl_score
		// eklaim_adl_sub_acute
		// eklaim_adl_chronic
		// eklaim_icu_indikator
		// eklaim_icu_los
		// eklaim_ventilator_hour
		// eklaim_upgrade_class_ind
		// eklaim_upgrade_class_class
		// eklaim_upgrade_class_los
		// eklaim_birth_weight
		// eklaim_discharge_status
		// eklaim_diagnosa
		// eklaim_procedure
		// eklaim_tarif_rs
		// eklaim_tarif_poli_eks
		// eklaim_id_dokter
		// eklaim_nama_dokter
		// eklaim_kode_tarif
		// eklaim_payor_id
		// eklaim_payor_cd
		// eklaim_coder_nik
		// eklaim_los
		// eklaim_patient_id
		// eklaim_admission_id
		// eklaim_hospital_admission_id
		// bridging_hapussep
		// user_penghapus_sep
		// BIAYA_BILLING_RAJAL
		// STATUS_PEMBAYARAN
		// BIAYA_TINDAKAN_FISIOTERAPI
		// eklaim_reg_pasien
		// eklaim_reg_klaim_baru
		// eklaim_gruper1
		// eklaim_gruper2
		// eklaim_finalklaim
		// eklaim_sendklaim
		// eklaim_flag_hapus_pasien
		// eklaim_flag_hapus_klaim
		// eklaim_kemkes_dc_Status
		// eklaim_bpjs_dc_Status
		// eklaim_cbg_code
		// eklaim_cbg_descprition
		// eklaim_cbg_tariff
		// eklaim_sub_acute_code
		// eklaim_sub_acute_deskripsi
		// eklaim_sub_acute_tariff
		// eklaim_chronic_code
		// eklaim_chronic_deskripsi
		// eklaim_chronic_tariff
		// eklaim_inacbg_version
		// BIAYA_TINDAKAN_IBS_RAJAL
		// VERIFY_ICD
		// bridging_rujukan_faskes_2
		// eklaim_reedit_claim
		// KETERANGAN
		// TGLLAHIR
		// USER_KASIR
		// eklaim_tgl_gruping
		// eklaim_tgl_finalklaim
		// eklaim_tgl_kirim_klaim
		// BIAYA_OBAT_RS
		// EKG_RAJAL
		// USG_RAJAL
		// FISIOTERAPI_RAJAL
		// BHP_RAJAL
		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		// TOTAL_BIAYA_IBS_RAJAL
		// ORDER_LAB
		// BILL_RAJAL_SELESAI
		// INCLUDE_IDXDAFTAR
		// INCLUDE_HARGA
		// TARIF_JASA_SARANA
		// TARIF_PENUNJANG_NON_MEDIS
		// TARIF_ASUHAN_KEPERAWATAN
		// KDDOKTER_RAJAL
		// KDDOKTER_KONSUL_RAJAL
		// BIAYA_BILLING_RS
		// BIAYA_TINDAKAN_POLI_TMO
		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		// BHP_RAJAL_TMO
		// BHP_RAJAL_KEPERAWATAN
		// TARIF_AKOMODASI
		// TARIF_AMBULAN
		// TARIF_OKSIGEN
		// BIAYA_TINDAKAN_JENAZAH
		// BIAYA_BILLING_IGD
		// BIAYA_TINDAKAN_POLI_PERSALINAN
		// BHP_RAJAL_PERSALINAN
		// TARIF_BIMBINGAN_ROHANI
		// BIAYA_BILLING_RS2
		// BIAYA_TARIF_DOKTER_IGD
		// BIAYA_PENDAFTARAN_IGD
		// BIAYA_BILLING_IBS
		// TARIF_JASA_SARANA_IGD
		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		// TARIF_MAKAN_IGD
		// TARIF_ASUHAN_KEPERAWATAN_IGD
		// pasien_TITLE
		// pasien_NAMA
		// pasien_TEMPAT
		// pasien_TGLLAHIR
		// pasien_JENISKELAMIN
		// pasien_ALAMAT
		// pasien_KELURAHAN
		// pasien_KDKECAMATAN
		// pasien_KOTA
		// pasien_KDPROVINSI
		// pasien_NOTELP
		// pasien_NOKTP
		// pasien_SUAMI_ORTU
		// pasien_PEKERJAAN
		// pasien_AGAMA
		// pasien_PENDIDIKAN
		// pasien_ALAMAT_KTP
		// pasien_NO_KARTU
		// pasien_JNS_PASIEN
		// pasien_nama_ayah
		// pasien_nama_ibu
		// pasien_nama_suami
		// pasien_nama_istri
		// pasien_KD_ETNIS
		// pasien_KD_BHS_HARIAN
		// BILL_FARMASI_SELESAI
		// TARIF_PELAYANAN_SIMRS
		// USER_ADM
		// TARIF_PENUNJANG_NON_MEDIS_IGD
		// TARIF_PELAYANAN_DARAH
		// penjamin_kkl_id
		// asalfaskesrujukan_id
		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// PASIENBARU
		if (strval($this->PASIENBARU->CurrentValue) <> "") {
			$this->PASIENBARU->ViewValue = $this->PASIENBARU->OptionCaption($this->PASIENBARU->CurrentValue);
		} else {
			$this->PASIENBARU->ViewValue = NULL;
		}
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 7);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDDOKTER
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`kddokter`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kddokter`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_lookup_dokter_poli`";
		$sWhereWrk = "";
		$this->KDDOKTER->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDDOKTER, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
			}
		} else {
			$this->KDDOKTER->ViewValue = NULL;
		}
		$this->KDDOKTER->ViewCustomAttributes = "";

		// KDPOLY
		if (strval($this->KDPOLY->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->KDPOLY->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDPOLY->ViewValue = $this->KDPOLY->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDPOLY->ViewValue = $this->KDPOLY->CurrentValue;
			}
		} else {
			$this->KDPOLY->ViewValue = NULL;
		}
		$this->KDPOLY->ViewCustomAttributes = "";

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

		// SHIFT
		if (strval($this->SHIFT->CurrentValue) <> "") {
			$sFilterWrk = "`id_shift`" . ew_SearchString("=", $this->SHIFT->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_shift`, `shift` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_shift`";
		$sWhereWrk = "";
		$this->SHIFT->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->SHIFT, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->SHIFT->ViewValue = $this->SHIFT->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
			}
		} else {
			$this->SHIFT->ViewValue = NULL;
		}
		$this->SHIFT->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// KETRUJUK
		$this->KETRUJUK->ViewValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->ViewValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->ViewValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->ViewValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// MINTA_RUJUKAN
		if (strval($this->MINTA_RUJUKAN->CurrentValue) <> "") {
			$this->MINTA_RUJUKAN->ViewValue = "";
			$arwrk = explode(",", strval($this->MINTA_RUJUKAN->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->MINTA_RUJUKAN->ViewValue .= $this->MINTA_RUJUKAN->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->MINTA_RUJUKAN->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->MINTA_RUJUKAN->ViewValue = NULL;
		}
		$this->MINTA_RUJUKAN->ViewCustomAttributes = "";

		// pasien_TITLE
		if (strval($this->pasien_TITLE->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_TITLE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
		$sWhereWrk = "";
		$this->pasien_TITLE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_TITLE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->CurrentValue;
			}
		} else {
			$this->pasien_TITLE->ViewValue = NULL;
		}
		$this->pasien_TITLE->ViewCustomAttributes = "";

		// pasien_NAMA
		$this->pasien_NAMA->ViewValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_NAMA->ViewCustomAttributes = "";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->ViewValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TEMPAT->ViewCustomAttributes = "";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->ViewValue = $this->pasien_TGLLAHIR->CurrentValue;
		$this->pasien_TGLLAHIR->ViewValue = ew_FormatDateTime($this->pasien_TGLLAHIR->ViewValue, 7);
		$this->pasien_TGLLAHIR->ViewCustomAttributes = "";

		// pasien_JENISKELAMIN
		if (strval($this->pasien_JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->pasien_JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->pasien_JENISKELAMIN->ViewValue = NULL;
		}
		$this->pasien_JENISKELAMIN->ViewCustomAttributes = "";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->ViewValue = $this->pasien_ALAMAT->CurrentValue;
		$this->pasien_ALAMAT->ViewCustomAttributes = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->ViewValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->ViewCustomAttributes = "";

		// pasien_NOKTP
		$this->pasien_NOKTP->ViewValue = $this->pasien_NOKTP->CurrentValue;
		$this->pasien_NOKTP->ViewCustomAttributes = "";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->ViewValue = $this->pasien_PEKERJAAN->CurrentValue;
		$this->pasien_PEKERJAAN->ViewCustomAttributes = "";

		// pasien_AGAMA
		if (strval($this->pasien_AGAMA->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
		$sWhereWrk = "";
		$this->pasien_AGAMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_AGAMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->CurrentValue;
			}
		} else {
			$this->pasien_AGAMA->ViewValue = NULL;
		}
		$this->pasien_AGAMA->ViewCustomAttributes = "";

		// pasien_PENDIDIKAN
		if (strval($this->pasien_PENDIDIKAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
		$sWhereWrk = "";
		$this->pasien_PENDIDIKAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->CurrentValue;
			}
		} else {
			$this->pasien_PENDIDIKAN->ViewValue = NULL;
		}
		$this->pasien_PENDIDIKAN->ViewCustomAttributes = "";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->ViewValue = $this->pasien_ALAMAT_KTP->CurrentValue;
		$this->pasien_ALAMAT_KTP->ViewCustomAttributes = "";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->ViewValue = $this->pasien_NO_KARTU->CurrentValue;
		$this->pasien_NO_KARTU->ViewCustomAttributes = "";

		// pasien_JNS_PASIEN
		if (strval($this->pasien_JNS_PASIEN->CurrentValue) <> "") {
			$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->pasien_JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
		$sWhereWrk = "";
		$this->pasien_JNS_PASIEN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->CurrentValue;
			}
		} else {
			$this->pasien_JNS_PASIEN->ViewValue = NULL;
		}
		$this->pasien_JNS_PASIEN->ViewCustomAttributes = "";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->ViewValue = $this->pasien_nama_ayah->CurrentValue;
		$this->pasien_nama_ayah->ViewCustomAttributes = "";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->ViewValue = $this->pasien_nama_ibu->CurrentValue;
		$this->pasien_nama_ibu->ViewCustomAttributes = "";

		// pasien_nama_suami
		$this->pasien_nama_suami->ViewValue = $this->pasien_nama_suami->CurrentValue;
		$this->pasien_nama_suami->ViewCustomAttributes = "";

		// pasien_nama_istri
		$this->pasien_nama_istri->ViewValue = $this->pasien_nama_istri->CurrentValue;
		$this->pasien_nama_istri->ViewCustomAttributes = "";

		// pasien_KD_ETNIS
		if (strval($this->pasien_KD_ETNIS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
		$sWhereWrk = "";
		$this->pasien_KD_ETNIS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_ETNIS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->CurrentValue;
			}
		} else {
			$this->pasien_KD_ETNIS->ViewValue = NULL;
		}
		$this->pasien_KD_ETNIS->ViewCustomAttributes = "";

		// pasien_KD_BHS_HARIAN
		if (strval($this->pasien_KD_BHS_HARIAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
		$sWhereWrk = "";
		$this->pasien_KD_BHS_HARIAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->CurrentValue;
			}
		} else {
			$this->pasien_KD_BHS_HARIAN->ViewValue = NULL;
		}
		$this->pasien_KD_BHS_HARIAN->ViewCustomAttributes = "";

		// peserta_cob
		$this->peserta_cob->ViewValue = $this->peserta_cob->CurrentValue;
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

			// PASIENBARU
			$this->PASIENBARU->LinkCustomAttributes = "";
			$this->PASIENBARU->HrefValue = "";
			$this->PASIENBARU->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// KDDOKTER
			$this->KDDOKTER->LinkCustomAttributes = "";
			$this->KDDOKTER->HrefValue = "";
			$this->KDDOKTER->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// KDRUJUK
			$this->KDRUJUK->LinkCustomAttributes = "";
			$this->KDRUJUK->HrefValue = "";
			$this->KDRUJUK->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// SHIFT
			$this->SHIFT->LinkCustomAttributes = "";
			$this->SHIFT->HrefValue = "";
			$this->SHIFT->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// KETRUJUK
			$this->KETRUJUK->LinkCustomAttributes = "";
			$this->KETRUJUK->HrefValue = "";
			$this->KETRUJUK->TooltipValue = "";

			// PENANGGUNGJAWAB_NAMA
			$this->PENANGGUNGJAWAB_NAMA->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_NAMA->HrefValue = "";
			$this->PENANGGUNGJAWAB_NAMA->TooltipValue = "";

			// PENANGGUNGJAWAB_HUBUNGAN
			$this->PENANGGUNGJAWAB_HUBUNGAN->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_HUBUNGAN->HrefValue = "";
			$this->PENANGGUNGJAWAB_HUBUNGAN->TooltipValue = "";

			// PENANGGUNGJAWAB_ALAMAT
			$this->PENANGGUNGJAWAB_ALAMAT->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_ALAMAT->HrefValue = "";
			$this->PENANGGUNGJAWAB_ALAMAT->TooltipValue = "";

			// PENANGGUNGJAWAB_PHONE
			$this->PENANGGUNGJAWAB_PHONE->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_PHONE->HrefValue = "";
			$this->PENANGGUNGJAWAB_PHONE->TooltipValue = "";

			// NOKARTU
			$this->NOKARTU->LinkCustomAttributes = "";
			$this->NOKARTU->HrefValue = "";
			$this->NOKARTU->TooltipValue = "";

			// MINTA_RUJUKAN
			$this->MINTA_RUJUKAN->LinkCustomAttributes = "";
			$this->MINTA_RUJUKAN->HrefValue = "";
			$this->MINTA_RUJUKAN->TooltipValue = "";

			// pasien_TITLE
			$this->pasien_TITLE->LinkCustomAttributes = "";
			$this->pasien_TITLE->HrefValue = "";
			$this->pasien_TITLE->TooltipValue = "";

			// pasien_NAMA
			$this->pasien_NAMA->LinkCustomAttributes = "";
			$this->pasien_NAMA->HrefValue = "";
			$this->pasien_NAMA->TooltipValue = "";

			// pasien_TEMPAT
			$this->pasien_TEMPAT->LinkCustomAttributes = "";
			$this->pasien_TEMPAT->HrefValue = "";
			$this->pasien_TEMPAT->TooltipValue = "";

			// pasien_TGLLAHIR
			$this->pasien_TGLLAHIR->LinkCustomAttributes = "";
			$this->pasien_TGLLAHIR->HrefValue = "";
			$this->pasien_TGLLAHIR->TooltipValue = "";

			// pasien_JENISKELAMIN
			$this->pasien_JENISKELAMIN->LinkCustomAttributes = "";
			$this->pasien_JENISKELAMIN->HrefValue = "";
			$this->pasien_JENISKELAMIN->TooltipValue = "";

			// pasien_ALAMAT
			$this->pasien_ALAMAT->LinkCustomAttributes = "";
			$this->pasien_ALAMAT->HrefValue = "";
			$this->pasien_ALAMAT->TooltipValue = "";

			// pasien_NOTELP
			$this->pasien_NOTELP->LinkCustomAttributes = "";
			$this->pasien_NOTELP->HrefValue = "";
			$this->pasien_NOTELP->TooltipValue = "";

			// pasien_NOKTP
			$this->pasien_NOKTP->LinkCustomAttributes = "";
			$this->pasien_NOKTP->HrefValue = "";
			$this->pasien_NOKTP->TooltipValue = "";

			// pasien_PEKERJAAN
			$this->pasien_PEKERJAAN->LinkCustomAttributes = "";
			$this->pasien_PEKERJAAN->HrefValue = "";
			$this->pasien_PEKERJAAN->TooltipValue = "";

			// pasien_AGAMA
			$this->pasien_AGAMA->LinkCustomAttributes = "";
			$this->pasien_AGAMA->HrefValue = "";
			$this->pasien_AGAMA->TooltipValue = "";

			// pasien_PENDIDIKAN
			$this->pasien_PENDIDIKAN->LinkCustomAttributes = "";
			$this->pasien_PENDIDIKAN->HrefValue = "";
			$this->pasien_PENDIDIKAN->TooltipValue = "";

			// pasien_ALAMAT_KTP
			$this->pasien_ALAMAT_KTP->LinkCustomAttributes = "";
			$this->pasien_ALAMAT_KTP->HrefValue = "";
			$this->pasien_ALAMAT_KTP->TooltipValue = "";

			// pasien_NO_KARTU
			$this->pasien_NO_KARTU->LinkCustomAttributes = "";
			$this->pasien_NO_KARTU->HrefValue = "";
			$this->pasien_NO_KARTU->TooltipValue = "";

			// pasien_JNS_PASIEN
			$this->pasien_JNS_PASIEN->LinkCustomAttributes = "";
			$this->pasien_JNS_PASIEN->HrefValue = "";
			$this->pasien_JNS_PASIEN->TooltipValue = "";

			// pasien_nama_ayah
			$this->pasien_nama_ayah->LinkCustomAttributes = "";
			$this->pasien_nama_ayah->HrefValue = "";
			$this->pasien_nama_ayah->TooltipValue = "";

			// pasien_nama_ibu
			$this->pasien_nama_ibu->LinkCustomAttributes = "";
			$this->pasien_nama_ibu->HrefValue = "";
			$this->pasien_nama_ibu->TooltipValue = "";

			// pasien_nama_suami
			$this->pasien_nama_suami->LinkCustomAttributes = "";
			$this->pasien_nama_suami->HrefValue = "";
			$this->pasien_nama_suami->TooltipValue = "";

			// pasien_nama_istri
			$this->pasien_nama_istri->LinkCustomAttributes = "";
			$this->pasien_nama_istri->HrefValue = "";
			$this->pasien_nama_istri->TooltipValue = "";

			// pasien_KD_ETNIS
			$this->pasien_KD_ETNIS->LinkCustomAttributes = "";
			$this->pasien_KD_ETNIS->HrefValue = "";
			$this->pasien_KD_ETNIS->TooltipValue = "";

			// pasien_KD_BHS_HARIAN
			$this->pasien_KD_BHS_HARIAN->LinkCustomAttributes = "";
			$this->pasien_KD_BHS_HARIAN->HrefValue = "";
			$this->pasien_KD_BHS_HARIAN->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// PASIENBARU
			$this->PASIENBARU->EditAttrs["class"] = "form-control";
			$this->PASIENBARU->EditCustomAttributes = "";
			$this->PASIENBARU->EditValue = $this->PASIENBARU->Options(TRUE);

			// NOMR
			$this->NOMR->EditAttrs["class"] = "form-control";
			$this->NOMR->EditCustomAttributes = "";
			$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->CurrentValue);
			$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

			// TGLREG
			$this->TGLREG->EditAttrs["class"] = "form-control";
			$this->TGLREG->EditCustomAttributes = "";
			$this->TGLREG->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TGLREG->CurrentValue, 7));
			$this->TGLREG->PlaceHolder = ew_RemoveHtml($this->TGLREG->FldCaption());

			// KDDOKTER
			$this->KDDOKTER->EditAttrs["class"] = "form-control";
			$this->KDDOKTER->EditCustomAttributes = "";
			if (trim(strval($this->KDDOKTER->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kddokter`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kddokter`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `kdpoly` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `vw_lookup_dokter_poli`";
			$sWhereWrk = "";
			$this->KDDOKTER->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDDOKTER, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDDOKTER->EditValue = $arwrk;

			// KDPOLY
			$this->KDPOLY->EditAttrs["class"] = "form-control";
			$this->KDPOLY->EditCustomAttributes = "";
			if (trim(strval($this->KDPOLY->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_poly`";
			$sWhereWrk = "";
			$this->KDPOLY->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDPOLY->EditValue = $arwrk;

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

			// SHIFT
			$this->SHIFT->EditCustomAttributes = "";
			if (trim(strval($this->SHIFT->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_shift`" . ew_SearchString("=", $this->SHIFT->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id_shift`, `shift` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_shift`";
			$sWhereWrk = "";
			$this->SHIFT->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->SHIFT, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->SHIFT->EditValue = $arwrk;

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = ew_HtmlEncode($this->NIP->CurrentValue);
			$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

			// KETRUJUK
			$this->KETRUJUK->EditAttrs["class"] = "form-control";
			$this->KETRUJUK->EditCustomAttributes = "";
			$this->KETRUJUK->EditValue = ew_HtmlEncode($this->KETRUJUK->CurrentValue);
			$this->KETRUJUK->PlaceHolder = ew_RemoveHtml($this->KETRUJUK->FldCaption());

			// PENANGGUNGJAWAB_NAMA
			$this->PENANGGUNGJAWAB_NAMA->EditAttrs["class"] = "form-control";
			$this->PENANGGUNGJAWAB_NAMA->EditCustomAttributes = "";
			$this->PENANGGUNGJAWAB_NAMA->EditValue = ew_HtmlEncode($this->PENANGGUNGJAWAB_NAMA->CurrentValue);
			$this->PENANGGUNGJAWAB_NAMA->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_NAMA->FldCaption());

			// PENANGGUNGJAWAB_HUBUNGAN
			$this->PENANGGUNGJAWAB_HUBUNGAN->EditAttrs["class"] = "form-control";
			$this->PENANGGUNGJAWAB_HUBUNGAN->EditCustomAttributes = "";
			$this->PENANGGUNGJAWAB_HUBUNGAN->EditValue = ew_HtmlEncode($this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue);
			$this->PENANGGUNGJAWAB_HUBUNGAN->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_HUBUNGAN->FldCaption());

			// PENANGGUNGJAWAB_ALAMAT
			$this->PENANGGUNGJAWAB_ALAMAT->EditAttrs["class"] = "form-control";
			$this->PENANGGUNGJAWAB_ALAMAT->EditCustomAttributes = "";
			$this->PENANGGUNGJAWAB_ALAMAT->EditValue = ew_HtmlEncode($this->PENANGGUNGJAWAB_ALAMAT->CurrentValue);
			$this->PENANGGUNGJAWAB_ALAMAT->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_ALAMAT->FldCaption());

			// PENANGGUNGJAWAB_PHONE
			$this->PENANGGUNGJAWAB_PHONE->EditAttrs["class"] = "form-control";
			$this->PENANGGUNGJAWAB_PHONE->EditCustomAttributes = "";
			$this->PENANGGUNGJAWAB_PHONE->EditValue = ew_HtmlEncode($this->PENANGGUNGJAWAB_PHONE->CurrentValue);
			$this->PENANGGUNGJAWAB_PHONE->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_PHONE->FldCaption());

			// NOKARTU
			$this->NOKARTU->EditAttrs["class"] = "form-control";
			$this->NOKARTU->EditCustomAttributes = "";
			$this->NOKARTU->EditValue = ew_HtmlEncode($this->NOKARTU->CurrentValue);
			$this->NOKARTU->PlaceHolder = ew_RemoveHtml($this->NOKARTU->FldCaption());

			// MINTA_RUJUKAN
			$this->MINTA_RUJUKAN->EditCustomAttributes = "";
			$this->MINTA_RUJUKAN->EditValue = $this->MINTA_RUJUKAN->Options(FALSE);

			// pasien_TITLE
			$this->pasien_TITLE->EditAttrs["class"] = "form-control";
			$this->pasien_TITLE->EditCustomAttributes = "";
			if (trim(strval($this->pasien_TITLE->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_TITLE->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_titel`";
			$sWhereWrk = "";
			$this->pasien_TITLE->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pasien_TITLE, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pasien_TITLE->EditValue = $arwrk;

			// pasien_NAMA
			$this->pasien_NAMA->EditAttrs["class"] = "form-control";
			$this->pasien_NAMA->EditCustomAttributes = "";
			$this->pasien_NAMA->EditValue = ew_HtmlEncode($this->pasien_NAMA->CurrentValue);
			$this->pasien_NAMA->PlaceHolder = ew_RemoveHtml($this->pasien_NAMA->FldCaption());

			// pasien_TEMPAT
			$this->pasien_TEMPAT->EditAttrs["class"] = "form-control";
			$this->pasien_TEMPAT->EditCustomAttributes = "";
			$this->pasien_TEMPAT->EditValue = ew_HtmlEncode($this->pasien_TEMPAT->CurrentValue);
			$this->pasien_TEMPAT->PlaceHolder = ew_RemoveHtml($this->pasien_TEMPAT->FldCaption());

			// pasien_TGLLAHIR
			$this->pasien_TGLLAHIR->EditAttrs["class"] = "form-control";
			$this->pasien_TGLLAHIR->EditCustomAttributes = "";
			$this->pasien_TGLLAHIR->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->pasien_TGLLAHIR->CurrentValue, 7));
			$this->pasien_TGLLAHIR->PlaceHolder = ew_RemoveHtml($this->pasien_TGLLAHIR->FldCaption());

			// pasien_JENISKELAMIN
			$this->pasien_JENISKELAMIN->EditCustomAttributes = "";
			if (trim(strval($this->pasien_JENISKELAMIN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jeniskelamin`";
			$sWhereWrk = "";
			$this->pasien_JENISKELAMIN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pasien_JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pasien_JENISKELAMIN->EditValue = $arwrk;

			// pasien_ALAMAT
			$this->pasien_ALAMAT->EditAttrs["class"] = "form-control";
			$this->pasien_ALAMAT->EditCustomAttributes = "";
			$this->pasien_ALAMAT->EditValue = ew_HtmlEncode($this->pasien_ALAMAT->CurrentValue);
			$this->pasien_ALAMAT->PlaceHolder = ew_RemoveHtml($this->pasien_ALAMAT->FldCaption());

			// pasien_NOTELP
			$this->pasien_NOTELP->EditAttrs["class"] = "form-control";
			$this->pasien_NOTELP->EditCustomAttributes = "";
			$this->pasien_NOTELP->EditValue = ew_HtmlEncode($this->pasien_NOTELP->CurrentValue);
			$this->pasien_NOTELP->PlaceHolder = ew_RemoveHtml($this->pasien_NOTELP->FldCaption());

			// pasien_NOKTP
			$this->pasien_NOKTP->EditAttrs["class"] = "form-control";
			$this->pasien_NOKTP->EditCustomAttributes = "";
			$this->pasien_NOKTP->EditValue = ew_HtmlEncode($this->pasien_NOKTP->CurrentValue);
			$this->pasien_NOKTP->PlaceHolder = ew_RemoveHtml($this->pasien_NOKTP->FldCaption());

			// pasien_PEKERJAAN
			$this->pasien_PEKERJAAN->EditAttrs["class"] = "form-control";
			$this->pasien_PEKERJAAN->EditCustomAttributes = "";
			$this->pasien_PEKERJAAN->EditValue = ew_HtmlEncode($this->pasien_PEKERJAAN->CurrentValue);
			$this->pasien_PEKERJAAN->PlaceHolder = ew_RemoveHtml($this->pasien_PEKERJAAN->FldCaption());

			// pasien_AGAMA
			$this->pasien_AGAMA->EditAttrs["class"] = "form-control";
			$this->pasien_AGAMA->EditCustomAttributes = "";
			if (trim(strval($this->pasien_AGAMA->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_agama`";
			$sWhereWrk = "";
			$this->pasien_AGAMA->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pasien_AGAMA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pasien_AGAMA->EditValue = $arwrk;

			// pasien_PENDIDIKAN
			$this->pasien_PENDIDIKAN->EditAttrs["class"] = "form-control";
			$this->pasien_PENDIDIKAN->EditCustomAttributes = "";
			if (trim(strval($this->pasien_PENDIDIKAN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_pendidikanterakhir`";
			$sWhereWrk = "";
			$this->pasien_PENDIDIKAN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pasien_PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pasien_PENDIDIKAN->EditValue = $arwrk;

			// pasien_ALAMAT_KTP
			$this->pasien_ALAMAT_KTP->EditAttrs["class"] = "form-control";
			$this->pasien_ALAMAT_KTP->EditCustomAttributes = "";
			$this->pasien_ALAMAT_KTP->EditValue = ew_HtmlEncode($this->pasien_ALAMAT_KTP->CurrentValue);
			$this->pasien_ALAMAT_KTP->PlaceHolder = ew_RemoveHtml($this->pasien_ALAMAT_KTP->FldCaption());

			// pasien_NO_KARTU
			$this->pasien_NO_KARTU->EditAttrs["class"] = "form-control";
			$this->pasien_NO_KARTU->EditCustomAttributes = "";
			$this->pasien_NO_KARTU->EditValue = ew_HtmlEncode($this->pasien_NO_KARTU->CurrentValue);
			$this->pasien_NO_KARTU->PlaceHolder = ew_RemoveHtml($this->pasien_NO_KARTU->FldCaption());

			// pasien_JNS_PASIEN
			$this->pasien_JNS_PASIEN->EditAttrs["class"] = "form-control";
			$this->pasien_JNS_PASIEN->EditCustomAttributes = "";
			if (trim(strval($this->pasien_JNS_PASIEN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->pasien_JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jenis_pasien`";
			$sWhereWrk = "";
			$this->pasien_JNS_PASIEN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pasien_JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pasien_JNS_PASIEN->EditValue = $arwrk;

			// pasien_nama_ayah
			$this->pasien_nama_ayah->EditAttrs["class"] = "form-control";
			$this->pasien_nama_ayah->EditCustomAttributes = "";
			$this->pasien_nama_ayah->EditValue = ew_HtmlEncode($this->pasien_nama_ayah->CurrentValue);
			$this->pasien_nama_ayah->PlaceHolder = ew_RemoveHtml($this->pasien_nama_ayah->FldCaption());

			// pasien_nama_ibu
			$this->pasien_nama_ibu->EditAttrs["class"] = "form-control";
			$this->pasien_nama_ibu->EditCustomAttributes = "";
			$this->pasien_nama_ibu->EditValue = ew_HtmlEncode($this->pasien_nama_ibu->CurrentValue);
			$this->pasien_nama_ibu->PlaceHolder = ew_RemoveHtml($this->pasien_nama_ibu->FldCaption());

			// pasien_nama_suami
			$this->pasien_nama_suami->EditAttrs["class"] = "form-control";
			$this->pasien_nama_suami->EditCustomAttributes = "";
			$this->pasien_nama_suami->EditValue = ew_HtmlEncode($this->pasien_nama_suami->CurrentValue);
			$this->pasien_nama_suami->PlaceHolder = ew_RemoveHtml($this->pasien_nama_suami->FldCaption());

			// pasien_nama_istri
			$this->pasien_nama_istri->EditAttrs["class"] = "form-control";
			$this->pasien_nama_istri->EditCustomAttributes = "";
			$this->pasien_nama_istri->EditValue = ew_HtmlEncode($this->pasien_nama_istri->CurrentValue);
			$this->pasien_nama_istri->PlaceHolder = ew_RemoveHtml($this->pasien_nama_istri->FldCaption());

			// pasien_KD_ETNIS
			$this->pasien_KD_ETNIS->EditAttrs["class"] = "form-control";
			$this->pasien_KD_ETNIS->EditCustomAttributes = "";
			if (trim(strval($this->pasien_KD_ETNIS->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_etnis`";
			$sWhereWrk = "";
			$this->pasien_KD_ETNIS->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pasien_KD_ETNIS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pasien_KD_ETNIS->EditValue = $arwrk;

			// pasien_KD_BHS_HARIAN
			$this->pasien_KD_BHS_HARIAN->EditAttrs["class"] = "form-control";
			$this->pasien_KD_BHS_HARIAN->EditCustomAttributes = "";
			if (trim(strval($this->pasien_KD_BHS_HARIAN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_bahasa_harian`";
			$sWhereWrk = "";
			$this->pasien_KD_BHS_HARIAN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->pasien_KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->pasien_KD_BHS_HARIAN->EditValue = $arwrk;

			// Add refer script
			// PASIENBARU

			$this->PASIENBARU->LinkCustomAttributes = "";
			$this->PASIENBARU->HrefValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";

			// KDDOKTER
			$this->KDDOKTER->LinkCustomAttributes = "";
			$this->KDDOKTER->HrefValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";

			// KDRUJUK
			$this->KDRUJUK->LinkCustomAttributes = "";
			$this->KDRUJUK->HrefValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";

			// SHIFT
			$this->SHIFT->LinkCustomAttributes = "";
			$this->SHIFT->HrefValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";

			// KETRUJUK
			$this->KETRUJUK->LinkCustomAttributes = "";
			$this->KETRUJUK->HrefValue = "";

			// PENANGGUNGJAWAB_NAMA
			$this->PENANGGUNGJAWAB_NAMA->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_NAMA->HrefValue = "";

			// PENANGGUNGJAWAB_HUBUNGAN
			$this->PENANGGUNGJAWAB_HUBUNGAN->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_HUBUNGAN->HrefValue = "";

			// PENANGGUNGJAWAB_ALAMAT
			$this->PENANGGUNGJAWAB_ALAMAT->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_ALAMAT->HrefValue = "";

			// PENANGGUNGJAWAB_PHONE
			$this->PENANGGUNGJAWAB_PHONE->LinkCustomAttributes = "";
			$this->PENANGGUNGJAWAB_PHONE->HrefValue = "";

			// NOKARTU
			$this->NOKARTU->LinkCustomAttributes = "";
			$this->NOKARTU->HrefValue = "";

			// MINTA_RUJUKAN
			$this->MINTA_RUJUKAN->LinkCustomAttributes = "";
			$this->MINTA_RUJUKAN->HrefValue = "";

			// pasien_TITLE
			$this->pasien_TITLE->LinkCustomAttributes = "";
			$this->pasien_TITLE->HrefValue = "";

			// pasien_NAMA
			$this->pasien_NAMA->LinkCustomAttributes = "";
			$this->pasien_NAMA->HrefValue = "";

			// pasien_TEMPAT
			$this->pasien_TEMPAT->LinkCustomAttributes = "";
			$this->pasien_TEMPAT->HrefValue = "";

			// pasien_TGLLAHIR
			$this->pasien_TGLLAHIR->LinkCustomAttributes = "";
			$this->pasien_TGLLAHIR->HrefValue = "";

			// pasien_JENISKELAMIN
			$this->pasien_JENISKELAMIN->LinkCustomAttributes = "";
			$this->pasien_JENISKELAMIN->HrefValue = "";

			// pasien_ALAMAT
			$this->pasien_ALAMAT->LinkCustomAttributes = "";
			$this->pasien_ALAMAT->HrefValue = "";

			// pasien_NOTELP
			$this->pasien_NOTELP->LinkCustomAttributes = "";
			$this->pasien_NOTELP->HrefValue = "";

			// pasien_NOKTP
			$this->pasien_NOKTP->LinkCustomAttributes = "";
			$this->pasien_NOKTP->HrefValue = "";

			// pasien_PEKERJAAN
			$this->pasien_PEKERJAAN->LinkCustomAttributes = "";
			$this->pasien_PEKERJAAN->HrefValue = "";

			// pasien_AGAMA
			$this->pasien_AGAMA->LinkCustomAttributes = "";
			$this->pasien_AGAMA->HrefValue = "";

			// pasien_PENDIDIKAN
			$this->pasien_PENDIDIKAN->LinkCustomAttributes = "";
			$this->pasien_PENDIDIKAN->HrefValue = "";

			// pasien_ALAMAT_KTP
			$this->pasien_ALAMAT_KTP->LinkCustomAttributes = "";
			$this->pasien_ALAMAT_KTP->HrefValue = "";

			// pasien_NO_KARTU
			$this->pasien_NO_KARTU->LinkCustomAttributes = "";
			$this->pasien_NO_KARTU->HrefValue = "";

			// pasien_JNS_PASIEN
			$this->pasien_JNS_PASIEN->LinkCustomAttributes = "";
			$this->pasien_JNS_PASIEN->HrefValue = "";

			// pasien_nama_ayah
			$this->pasien_nama_ayah->LinkCustomAttributes = "";
			$this->pasien_nama_ayah->HrefValue = "";

			// pasien_nama_ibu
			$this->pasien_nama_ibu->LinkCustomAttributes = "";
			$this->pasien_nama_ibu->HrefValue = "";

			// pasien_nama_suami
			$this->pasien_nama_suami->LinkCustomAttributes = "";
			$this->pasien_nama_suami->HrefValue = "";

			// pasien_nama_istri
			$this->pasien_nama_istri->LinkCustomAttributes = "";
			$this->pasien_nama_istri->HrefValue = "";

			// pasien_KD_ETNIS
			$this->pasien_KD_ETNIS->LinkCustomAttributes = "";
			$this->pasien_KD_ETNIS->HrefValue = "";

			// pasien_KD_BHS_HARIAN
			$this->pasien_KD_BHS_HARIAN->LinkCustomAttributes = "";
			$this->pasien_KD_BHS_HARIAN->HrefValue = "";
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
		if (!$this->NOMR->FldIsDetailKey && !is_null($this->NOMR->FormValue) && $this->NOMR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NOMR->FldCaption(), $this->NOMR->ReqErrMsg));
		}
		if (!$this->TGLREG->FldIsDetailKey && !is_null($this->TGLREG->FormValue) && $this->TGLREG->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TGLREG->FldCaption(), $this->TGLREG->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->TGLREG->FormValue)) {
			ew_AddMessage($gsFormError, $this->TGLREG->FldErrMsg());
		}
		if (!$this->KDDOKTER->FldIsDetailKey && !is_null($this->KDDOKTER->FormValue) && $this->KDDOKTER->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDDOKTER->FldCaption(), $this->KDDOKTER->ReqErrMsg));
		}
		if (!$this->KDPOLY->FldIsDetailKey && !is_null($this->KDPOLY->FormValue) && $this->KDPOLY->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDPOLY->FldCaption(), $this->KDPOLY->ReqErrMsg));
		}
		if (!$this->KDRUJUK->FldIsDetailKey && !is_null($this->KDRUJUK->FormValue) && $this->KDRUJUK->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDRUJUK->FldCaption(), $this->KDRUJUK->ReqErrMsg));
		}
		if (!$this->pasien_TGLLAHIR->FldIsDetailKey && !is_null($this->pasien_TGLLAHIR->FormValue) && $this->pasien_TGLLAHIR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pasien_TGLLAHIR->FldCaption(), $this->pasien_TGLLAHIR->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->pasien_TGLLAHIR->FormValue)) {
			ew_AddMessage($gsFormError, $this->pasien_TGLLAHIR->FldErrMsg());
		}
		if (!$this->pasien_KD_ETNIS->FldIsDetailKey && !is_null($this->pasien_KD_ETNIS->FormValue) && $this->pasien_KD_ETNIS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pasien_KD_ETNIS->FldCaption(), $this->pasien_KD_ETNIS->ReqErrMsg));
		}
		if (!$this->pasien_KD_BHS_HARIAN->FldIsDetailKey && !is_null($this->pasien_KD_BHS_HARIAN->FormValue) && $this->pasien_KD_BHS_HARIAN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pasien_KD_BHS_HARIAN->FldCaption(), $this->pasien_KD_BHS_HARIAN->ReqErrMsg));
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

		// PASIENBARU
		$this->PASIENBARU->SetDbValueDef($rsnew, $this->PASIENBARU->CurrentValue, NULL, FALSE);

		// NOMR
		$this->NOMR->SetDbValueDef($rsnew, $this->NOMR->CurrentValue, NULL, FALSE);

		// TGLREG
		$this->TGLREG->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TGLREG->CurrentValue, 7), NULL, FALSE);

		// KDDOKTER
		$this->KDDOKTER->SetDbValueDef($rsnew, $this->KDDOKTER->CurrentValue, NULL, FALSE);

		// KDPOLY
		$this->KDPOLY->SetDbValueDef($rsnew, $this->KDPOLY->CurrentValue, NULL, FALSE);

		// KDRUJUK
		$this->KDRUJUK->SetDbValueDef($rsnew, $this->KDRUJUK->CurrentValue, 0, FALSE);

		// KDCARABAYAR
		$this->KDCARABAYAR->SetDbValueDef($rsnew, $this->KDCARABAYAR->CurrentValue, NULL, FALSE);

		// SHIFT
		$this->SHIFT->SetDbValueDef($rsnew, $this->SHIFT->CurrentValue, NULL, FALSE);

		// NIP
		$this->NIP->SetDbValueDef($rsnew, $this->NIP->CurrentValue, NULL, FALSE);

		// KETRUJUK
		$this->KETRUJUK->SetDbValueDef($rsnew, $this->KETRUJUK->CurrentValue, NULL, FALSE);

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_NAMA->CurrentValue, NULL, FALSE);

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue, NULL, FALSE);

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue, NULL, FALSE);

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_PHONE->CurrentValue, NULL, FALSE);

		// NOKARTU
		$this->NOKARTU->SetDbValueDef($rsnew, $this->NOKARTU->CurrentValue, NULL, FALSE);

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->SetDbValueDef($rsnew, $this->MINTA_RUJUKAN->CurrentValue, NULL, FALSE);

		// pasien_TITLE
		$this->pasien_TITLE->SetDbValueDef($rsnew, $this->pasien_TITLE->CurrentValue, NULL, FALSE);

		// pasien_NAMA
		$this->pasien_NAMA->SetDbValueDef($rsnew, $this->pasien_NAMA->CurrentValue, NULL, FALSE);

		// pasien_TEMPAT
		$this->pasien_TEMPAT->SetDbValueDef($rsnew, $this->pasien_TEMPAT->CurrentValue, NULL, FALSE);

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->pasien_TGLLAHIR->CurrentValue, 7), NULL, FALSE);

		// pasien_JENISKELAMIN
		$this->pasien_JENISKELAMIN->SetDbValueDef($rsnew, $this->pasien_JENISKELAMIN->CurrentValue, NULL, FALSE);

		// pasien_ALAMAT
		$this->pasien_ALAMAT->SetDbValueDef($rsnew, $this->pasien_ALAMAT->CurrentValue, NULL, FALSE);

		// pasien_NOTELP
		$this->pasien_NOTELP->SetDbValueDef($rsnew, $this->pasien_NOTELP->CurrentValue, NULL, FALSE);

		// pasien_NOKTP
		$this->pasien_NOKTP->SetDbValueDef($rsnew, $this->pasien_NOKTP->CurrentValue, NULL, FALSE);

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->SetDbValueDef($rsnew, $this->pasien_PEKERJAAN->CurrentValue, NULL, FALSE);

		// pasien_AGAMA
		$this->pasien_AGAMA->SetDbValueDef($rsnew, $this->pasien_AGAMA->CurrentValue, NULL, FALSE);

		// pasien_PENDIDIKAN
		$this->pasien_PENDIDIKAN->SetDbValueDef($rsnew, $this->pasien_PENDIDIKAN->CurrentValue, NULL, FALSE);

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->SetDbValueDef($rsnew, $this->pasien_ALAMAT_KTP->CurrentValue, NULL, FALSE);

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->SetDbValueDef($rsnew, $this->pasien_NO_KARTU->CurrentValue, NULL, FALSE);

		// pasien_JNS_PASIEN
		$this->pasien_JNS_PASIEN->SetDbValueDef($rsnew, $this->pasien_JNS_PASIEN->CurrentValue, NULL, FALSE);

		// pasien_nama_ayah
		$this->pasien_nama_ayah->SetDbValueDef($rsnew, $this->pasien_nama_ayah->CurrentValue, NULL, FALSE);

		// pasien_nama_ibu
		$this->pasien_nama_ibu->SetDbValueDef($rsnew, $this->pasien_nama_ibu->CurrentValue, NULL, FALSE);

		// pasien_nama_suami
		$this->pasien_nama_suami->SetDbValueDef($rsnew, $this->pasien_nama_suami->CurrentValue, NULL, FALSE);

		// pasien_nama_istri
		$this->pasien_nama_istri->SetDbValueDef($rsnew, $this->pasien_nama_istri->CurrentValue, NULL, FALSE);

		// pasien_KD_ETNIS
		$this->pasien_KD_ETNIS->SetDbValueDef($rsnew, $this->pasien_KD_ETNIS->CurrentValue, NULL, FALSE);

		// pasien_KD_BHS_HARIAN
		$this->pasien_KD_BHS_HARIAN->SetDbValueDef($rsnew, $this->pasien_KD_BHS_HARIAN->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_pendaftaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_KDDOKTER":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kddokter` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_lookup_dokter_poli`";
			$sWhereWrk = "{filter}";
			$this->KDDOKTER->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kddokter` = {filter_value}', "t0" => "2", "fn0" => "", "f1" => '`kdpoly` IN ({filter_value})', "t1" => "2", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDDOKTER, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDPOLY":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "";
			$this->KDPOLY->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
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
		case "x_SHIFT":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_shift` AS `LinkFld`, `shift` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_shift`";
			$sWhereWrk = "";
			$this->SHIFT->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_shift` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->SHIFT, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_pasien_TITLE":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
			$sWhereWrk = "";
			$this->pasien_TITLE->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pasien_TITLE, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_pasien_JENISKELAMIN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
			$sWhereWrk = "";
			$this->pasien_JENISKELAMIN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pasien_JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_pasien_AGAMA":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
			$sWhereWrk = "";
			$this->pasien_AGAMA->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pasien_AGAMA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_pasien_PENDIDIKAN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
			$sWhereWrk = "";
			$this->pasien_PENDIDIKAN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pasien_PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_pasien_JNS_PASIEN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `jenis_pasien` AS `LinkFld`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
			$sWhereWrk = "";
			$this->pasien_JNS_PASIEN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`jenis_pasien` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pasien_JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_pasien_KD_ETNIS":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
			$sWhereWrk = "";
			$this->pasien_KD_ETNIS->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pasien_KD_ETNIS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_pasien_KD_BHS_HARIAN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
			$sWhereWrk = "";
			$this->pasien_KD_BHS_HARIAN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->pasien_KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
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

		if ($this->CurrentAction == "A") {
			$url = "pendaftaran_sukses.php?IDXDAFTAR=".$this->IDXDAFTAR->CurrentValue."&KDPOLY=".$this->KDPOLY->CurrentValue."&TGLREG=".$this->TGLREG->CurrentValue."&NOMR=".$this->NOMR->CurrentValue."&KDCARABAYAR=".$this->KDCARABAYAR->CurrentValue;
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
		//$header = "<div class=\"alert alert-warning ewAlert\"> Tekan Ctrl + F5 secara bersamaan untuk merefresh Halaman (Apabila diperlukan) </div>";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		$rs = $this->GetFieldValues("FormValue");
		$requiredValue = $rs["KETRUJUK"];
		$v_KDRUJUK = $rs["KDRUJUK"];
		$v_pasien_NO_KARTU = $rs["pasien_NO_KARTU"];
		$v_pasien_JNS_PASIEN = $rs["pasien_JNS_PASIEN"];
		$v_NOKARTU = $rs["NOKARTU"];
		$v_KDCARABAYAR = $rs["KDCARABAYAR"];

		// VALIDASI KODE RUJUKAN
	/*if($v_KDRUJUK!=1){
		if($requiredValue == ""){
		  $CustomError = "Ket. Rujukan Tidak Boleh Kosong";
		  	return FALSE;
		 }
	}*/
	if($v_KDCARABAYAR!=1){
		if($v_NOKARTU == "") {
		  $CustomError = "Nomer Kartu BPJS Tidak Boleh Kosong";
		  return FALSE;
		}
		if($v_pasien_JNS_PASIEN == "") {
		  $CustomError = "Jenis peserta Tidak Boleh Kosong";
		  return FALSE;
		}
		if($v_pasien_NO_KARTU == "") {
		  $CustomError = "No> kartu BPJS Tidak Boleh Kosong";
		  return FALSE;
		}else{
			return TRUE;
		}
	}else{
		return TRUE;
	}
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_pendaftaran_add)) $t_pendaftaran_add = new ct_pendaftaran_add();

// Page init
$t_pendaftaran_add->Page_Init();

// Page main
$t_pendaftaran_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_pendaftaran_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_pendaftaranadd = new ew_Form("ft_pendaftaranadd", "add");

// Validate form
ft_pendaftaranadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_NOMR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->NOMR->FldCaption(), $t_pendaftaran->NOMR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TGLREG");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->TGLREG->FldCaption(), $t_pendaftaran->TGLREG->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TGLREG");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->TGLREG->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_KDDOKTER");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->KDDOKTER->FldCaption(), $t_pendaftaran->KDDOKTER->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KDPOLY");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->KDPOLY->FldCaption(), $t_pendaftaran->KDPOLY->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KDRUJUK");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->KDRUJUK->FldCaption(), $t_pendaftaran->KDRUJUK->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pasien_TGLLAHIR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->pasien_TGLLAHIR->FldCaption(), $t_pendaftaran->pasien_TGLLAHIR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pasien_TGLLAHIR");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->pasien_TGLLAHIR->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pasien_KD_ETNIS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->pasien_KD_ETNIS->FldCaption(), $t_pendaftaran->pasien_KD_ETNIS->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pasien_KD_BHS_HARIAN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_pendaftaran->pasien_KD_BHS_HARIAN->FldCaption(), $t_pendaftaran->pasien_KD_BHS_HARIAN->ReqErrMsg)) ?>");

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
ft_pendaftaranadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_pendaftaranadd.ValidateRequired = true;
<?php } else { ?>
ft_pendaftaranadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_pendaftaranadd.Lists["x_PASIENBARU"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_pendaftaranadd.Lists["x_PASIENBARU"].Options = <?php echo json_encode($t_pendaftaran->PASIENBARU->Options()) ?>;
ft_pendaftaranadd.Lists["x_KDDOKTER"] = {"LinkField":"x_kddokter","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":["x_KDPOLY"],"ChildFields":[],"FilterFields":["x_kdpoly"],"Options":[],"Template":"","LinkTable":"vw_lookup_dokter_poli"};
ft_pendaftaranadd.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_KDDOKTER"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_pendaftaranadd.Lists["x_KDRUJUK"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
ft_pendaftaranadd.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_pendaftaranadd.Lists["x_SHIFT"] = {"LinkField":"x_id_shift","Ajax":true,"AutoFill":false,"DisplayFields":["x_shift","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_shift"};
ft_pendaftaranadd.Lists["x_MINTA_RUJUKAN[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_pendaftaranadd.Lists["x_MINTA_RUJUKAN[]"].Options = <?php echo json_encode($t_pendaftaran->MINTA_RUJUKAN->Options()) ?>;
ft_pendaftaranadd.Lists["x_pasien_TITLE"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_titel"};
ft_pendaftaranadd.Lists["x_pasien_JENISKELAMIN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskelamin","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskelamin"};
ft_pendaftaranadd.Lists["x_pasien_AGAMA"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_agama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_agama"};
ft_pendaftaranadd.Lists["x_pasien_PENDIDIKAN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_pendidikan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_pendidikanterakhir"};
ft_pendaftaranadd.Lists["x_pasien_JNS_PASIEN"] = {"LinkField":"x_jenis_pasien","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_pasien"};
ft_pendaftaranadd.Lists["x_pasien_KD_ETNIS"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_etnis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_etnis"};
ft_pendaftaranadd.Lists["x_pasien_KD_BHS_HARIAN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bahasa_harian","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_bahasa_harian"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
$(document).ready(function() {
	$("#x_PASIENBARU").change(function() {
		if (this.value == "0") {
			console.log(0);
			$('#x_NOMR').show();
			$('#elh_sample_NOMR').show();
		} else {
			console.log(1);
			$('#x_NOMR').hide();
			$('#elh_sample_NOMR').hide();
		} 
	});
$("#x_JENISPERAWATAN_SEP").attr("checked", true);
	$('#x_NOMR').css('background-color', '#ffff00');

	//$('#x_TGLREG').css('background-color', '#ffff00');
//	$('#x_KDPOLY').css('background-color', '#ffff00');
	//$('#x_KDDOKTER').css('background-color', '#ffff00');
	///$('#x_MINTA_RUJUKAN').css('background-color', '#ffff00');
	////$('#x_KDRUJUK').css('background-color', '#ffff00');
	//$('#x_KETRUJUK').css('background-color', '#ffff00');
	//$('#x_KDCARABAYAR').css('background-color', '#ffff00');
	//$('#x_SHIFT').css('background-color', '#ffff00');
	//$('#x_NIP').css('background-color', '#ffff00');
	//$('#x_KDRUJUK').hide();

	$('#x_KETRUJUK').hide();

	//$('#elh_sample_KDRUJUK').hide();
	$('#elh_sample_KETRUJUK').hide();
}); 
</script>
<?php if (!$t_pendaftaran_add->IsModal) { ?>
<?php } ?>
<?php $t_pendaftaran_add->ShowPageHeader(); ?>
<?php
$t_pendaftaran_add->ShowMessage();
?>
<form name="ft_pendaftaranadd" id="ft_pendaftaranadd" class="<?php echo $t_pendaftaran_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_pendaftaran_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_pendaftaran_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_pendaftaran">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_pendaftaran_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_t_pendaftaranadd" class="ewCustomTemplate"></div>
<script id="tpm_t_pendaftaranadd" type="text/html">
<div id="ct_t_pendaftaran_add"><?php
	if(isset($_GET["flag"])) {
		$nomr = $_GET["flag"];
		$header = "<div class=\"alert alert-info ewAlert\">Pendaftaran Pasien Rawat Jalan demgan NOMR : ".$nomr."</div>";
		print $header;
	}else{  
	}
?>
<div id="ct_sample_add">
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Pendaftaran</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
  	<div id="r_TGLREG" class="form-group">
	<label id="elh_sample_TGLREG" for="x_TGLREG" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->TGLREG->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_TGLREG"/}}</div>
	</div>
	<div id="r_PASIENBARU" class="form-group">
	<label id="elh_PASIENBARU" for="x_PASIENBARU" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->PASIENBARU->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_PASIENBARU"/}}</div>
	</div>
	<div id="r_NOMR" class="form-group">
	<label id="elh_sample_NOMR" for="x_NOMR" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->NOMR->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_NOMR"/}}</div>
	</div>
	<div id="r_KDPOLY" class="form-group">
	<label id="elh_KDPOLY" for="x_KDPOLY" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->KDPOLY->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_KDPOLY"/}}</div>
	</div>
	<div id="r_KDDOKTER" class="form-group">
	<label id="elh_sample_KDDOKTER" for="x_KDDOKTER" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->KDDOKTER->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_KDDOKTER"/}}</div>
	</div>
	<div id="r_MINTA_RUJUKAN" class="form-group">
	<label id="elh_sample_MINTA_RUJUKAN" for="x_MINTA_RUJUKAN" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->MINTA_RUJUKAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_MINTA_RUJUKAN"/}}</div>
	</div>
	<div id="r_KDCARABAYAR" class="form-group">
	<label id="elh_sample_KDCARABAYAR" for="x_KDCARABAYAR" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->KDCARABAYAR->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_KDCARABAYAR"/}}</div>
	</div>
	 <div id="r_KDRUJUK" class="form-group">
	<label id="elh_sample_KDRUJUK" for="x_KDRUJUK" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->KDRUJUK->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_KDRUJUK"/}}</div>
	</div>
	<div id="r_KETRUJUK" class="form-group">
	<label id="elh_sample_KETRUJUK" for="x_KETRUJUK" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->KETRUJUK->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_KETRUJUK"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_SHIFT" class="form-group">
	<label id="elh_sample_SHIFT" for="x_SHIFT" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->SHIFT->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_SHIFT"/}}</div>
	</div>
		<div id="r_NIP" class="form-group">
	<label id="elh_NIP" for="x_NIP" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->NIP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_NIP"/}}</div>
	</div>
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Identitas Pribadi Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_NOKARTU" class="form-group">
	<label id="elh_NOKARTU" for="x_NOKARTU" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->NOKARTU->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_NOKARTU"/}}</div>
	</div>
	<div id="r_pasien_TITLE" class="form-group">
	<label id="elh_pasien_TITLE" for="x_pasien_TITLE" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_TITLE->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_TITLE"/}}</div>
	</div>
	<div id="r_pasien_NAMA" class="form-group">
	<label id="elh_pasien_NAMA" for="x_pasien_NAMA" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_NAMA->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_NAMA"/}}</div>
	</div>
	<div id="r_pasien_TEMPAT" class="form-group">
	<label id="elh_pasien_TEMPAT" for="x_pasien_TEMPAT" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_TEMPAT->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_TEMPAT"/}}</div>
	</div>
		<div id="r_pasien_TGLLAHIR" class="form-group">
	<label id="elh_pasien_TGLLAHIR" for="x_pasien_TGLLAHIR" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_TGLLAHIR->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_TGLLAHIR"/}}</div>
	</div>
	<div id="r_pasien_JENISKELAMIN" class="form-group">
	<label id="elh_pasien_JENISKELAMIN" for="x_pasien_JENISKELAMIN" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_JENISKELAMIN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_JENISKELAMIN"/}}</div>
	</div>
	<div id="r_pasien_ALAMAT" class="form-group">
	<label id="elh_pasien_ALAMAT" for="x_pasien_ALAMAT" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_ALAMAT->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_ALAMAT"/}}</div>
	</div>
	<div id="r_pasien_NOTELP" class="form-group">
	<label id="elh_pasien_NOTELP" for="x_pasien_NOTELP" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_NOTELP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_NOTELP"/}}</div>
	</div>
	<div id="r_pasien_NOKTP" class="form-group">
	<label id="elh_pasien_NOKTP" for="x_pasien_NOKTP" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_NOKTP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_NOKTP"/}}</div>
	</div>
	<div id="r_pasien_PEKERJAAN" class="form-group">
	<label id="elh_pasien_PEKERJAAN" for="x_pasien_PEKERJAAN" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_PEKERJAAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_PEKERJAAN"/}}</div>
	</div>
	 <div id="r_pasien_AGAMA" class="form-group">
	<label id="elh_pasien_AGAMA" for="x_pasien_AGAMA" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_AGAMA->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_AGAMA"/}}</div>
	</div> 
	<div id="r_pasien_PENDIDIKAN" class="form-group">
	<label id="elh_pasien_PENDIDIKAN" for="x_pasien_PENDIDIKAN" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_PENDIDIKAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_PENDIDIKAN"/}}</div>
	</div>
	 <div id="r_pasien_ALAMAT_KTP" class="form-group">
	<label id="elh_pasien_ALAMAT_KTP" for="x_pasien_ALAMAT_KTP" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_ALAMAT_KTP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_ALAMAT_KTP"/}}</div>
	</div>
	 <div id="r_pasien_NO_KARTU" class="form-group">
	<label id="elh_pasien_NO_KARTU" for="x_pasien_NO_KARTU" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_NO_KARTU->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_NO_KARTU"/}}</div>
	</div>
	 <div id="r_pasien_JNS_PASIEN" class="form-group">
	<label id="elh_pasien_JNS_PASIEN" for="x_pasien_JNS_PASIEN" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_JNS_PASIEN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_JNS_PASIEN"/}}</div>
	</div>
		 <div id="r_pasien_KD_ETNIS" class="form-group">
	<label id="elh_pasien_KD_ETNIS" for="x_pasien_KD_ETNIS" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_KD_ETNIS->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_KD_ETNIS"/}}</div>
	</div>
	<div id="r_pasien_KD_BHS_HARIAN" class="form-group">
	<label id="elh_pasien_KD_BHS_HARIAN" for="x_pasien_KD_BHS_HARIAN" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_KD_BHS_HARIAN"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
<!--
	<div id="r_pasien_SUAMI_ORTU" class="form-group">
	<label id="elh_pasien_SUAMI_ORTU" for="x_pasien_SUAMI_ORTU" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_SUAMI_ORTU->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_SUAMI_ORTU"/}}</div>
	</div> -->
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Keluarga Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_pasien_nama_ayah" class="form-group">
	<label id="elh_pasien_nama_ayah" for="x_pasien_nama_ayah" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_nama_ayah->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_nama_ayah"/}}</div>
	</div>
	 <div id="r_pasien_nama_ibu" class="form-group">
	<label id="elh_pasien_nama_ibu" for="x_pasien_nama_ibu" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_nama_ibu->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_nama_ibu"/}}</div>
	</div>
	 <div id="r_pasien_nama_suami" class="form-group">
	<label id="elh_pasien_nama_suami" for="x_pasien_nama_suami" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_nama_suami->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_nama_suami"/}}</div>
	</div>
	<div id="r_pasien_nama_istri" class="form-group">
	<label id="elh_pasien_nama_istri" for="x_pasien_nama_istri" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->pasien_nama_istri->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_pasien_nama_istri"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Penanggung Jawab Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_PENANGGUNGJAWAB_NAMA" class="form-group">
	<label id="elh_PENANGGUNGJAWAB_NAMA" for="x_PENANGGUNGJAWAB_NAMA" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->PENANGGUNGJAWAB_NAMA->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_PENANGGUNGJAWAB_NAMA"/}}</div>
	</div>
	<div id="r_PENANGGUNGJAWAB_HUBUNGAN" class="form-group">
	<label id="elh_PENANGGUNGJAWAB_HUBUNGAN" for="x_PENANGGUNGJAWAB_HUBUNGAN" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_PENANGGUNGJAWAB_HUBUNGAN"/}}</div>
	</div>
	<div id="r_PENANGGUNGJAWAB_ALAMAT" class="form-group">
	<label id="elh_PENANGGUNGJAWAB_ALAMAT" for="x_PENANGGUNGJAWAB_ALAMAT" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_PENANGGUNGJAWAB_ALAMAT"/}}</div>
	</div>
	<div id="r_PENANGGUNGJAWAB_PHONE" class="form-group">
	<label id="elh_PENANGGUNGJAWAB_PHONE" for="x_PENANGGUNGJAWAB_PHONE" class="col-sm-3 control-label ewLabel">
	<?php echo $t_pendaftaran->PENANGGUNGJAWAB_PHONE->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_t_pendaftaran_PENANGGUNGJAWAB_PHONE"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
  </div>
</div>
</div>
</div>
</div>
</script>
<div style="display: none">
<?php if ($t_pendaftaran->PASIENBARU->Visible) { // PASIENBARU ?>
	<div id="r_PASIENBARU" class="form-group">
		<label id="elh_t_pendaftaran_PASIENBARU" for="x_PASIENBARU" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_PASIENBARU" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->PASIENBARU->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->PASIENBARU->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_PASIENBARU" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_PASIENBARU">
<select data-table="t_pendaftaran" data-field="x_PASIENBARU" data-value-separator="<?php echo $t_pendaftaran->PASIENBARU->DisplayValueSeparatorAttribute() ?>" id="x_PASIENBARU" name="x_PASIENBARU"<?php echo $t_pendaftaran->PASIENBARU->EditAttributes() ?>>
<?php echo $t_pendaftaran->PASIENBARU->SelectOptionListHtml("x_PASIENBARU") ?>
</select>
</span>
</script>
<?php echo $t_pendaftaran->PASIENBARU->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label id="elh_t_pendaftaran_NOMR" for="x_NOMR" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_NOMR" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->NOMR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->NOMR->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_NOMR" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_NOMR">
<input type="text" data-table="t_pendaftaran" data-field="x_NOMR" name="x_NOMR" id="x_NOMR" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->NOMR->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->NOMR->EditValue ?>"<?php echo $t_pendaftaran->NOMR->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->NOMR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->TGLREG->Visible) { // TGLREG ?>
	<div id="r_TGLREG" class="form-group">
		<label id="elh_t_pendaftaran_TGLREG" for="x_TGLREG" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_TGLREG" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->TGLREG->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->TGLREG->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_TGLREG" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_TGLREG">
<input type="text" data-table="t_pendaftaran" data-field="x_TGLREG" data-format="7" name="x_TGLREG" id="x_TGLREG" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->TGLREG->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->TGLREG->EditValue ?>"<?php echo $t_pendaftaran->TGLREG->EditAttributes() ?>>
<?php if (!$t_pendaftaran->TGLREG->ReadOnly && !$t_pendaftaran->TGLREG->Disabled && !isset($t_pendaftaran->TGLREG->EditAttrs["readonly"]) && !isset($t_pendaftaran->TGLREG->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="t_pendaftaranadd_js">
ew_CreateCalendar("ft_pendaftaranadd", "x_TGLREG", 7);
</script>
<?php echo $t_pendaftaran->TGLREG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->KDDOKTER->Visible) { // KDDOKTER ?>
	<div id="r_KDDOKTER" class="form-group">
		<label id="elh_t_pendaftaran_KDDOKTER" for="x_KDDOKTER" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_KDDOKTER" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->KDDOKTER->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->KDDOKTER->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_KDDOKTER" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_KDDOKTER">
<select data-table="t_pendaftaran" data-field="x_KDDOKTER" data-value-separator="<?php echo $t_pendaftaran->KDDOKTER->DisplayValueSeparatorAttribute() ?>" id="x_KDDOKTER" name="x_KDDOKTER"<?php echo $t_pendaftaran->KDDOKTER->EditAttributes() ?>>
<?php echo $t_pendaftaran->KDDOKTER->SelectOptionListHtml("x_KDDOKTER") ?>
</select>
<input type="hidden" name="s_x_KDDOKTER" id="s_x_KDDOKTER" value="<?php echo $t_pendaftaran->KDDOKTER->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->KDDOKTER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->KDPOLY->Visible) { // KDPOLY ?>
	<div id="r_KDPOLY" class="form-group">
		<label id="elh_t_pendaftaran_KDPOLY" for="x_KDPOLY" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_KDPOLY" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->KDPOLY->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->KDPOLY->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_KDPOLY" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_KDPOLY">
<?php $t_pendaftaran->KDPOLY->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_pendaftaran->KDPOLY->EditAttrs["onchange"]; ?>
<select data-table="t_pendaftaran" data-field="x_KDPOLY" data-value-separator="<?php echo $t_pendaftaran->KDPOLY->DisplayValueSeparatorAttribute() ?>" id="x_KDPOLY" name="x_KDPOLY"<?php echo $t_pendaftaran->KDPOLY->EditAttributes() ?>>
<?php echo $t_pendaftaran->KDPOLY->SelectOptionListHtml("x_KDPOLY") ?>
</select>
<input type="hidden" name="s_x_KDPOLY" id="s_x_KDPOLY" value="<?php echo $t_pendaftaran->KDPOLY->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->KDPOLY->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->KDRUJUK->Visible) { // KDRUJUK ?>
	<div id="r_KDRUJUK" class="form-group">
		<label id="elh_t_pendaftaran_KDRUJUK" for="x_KDRUJUK" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_KDRUJUK" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->KDRUJUK->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->KDRUJUK->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_KDRUJUK" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_KDRUJUK">
<select data-table="t_pendaftaran" data-field="x_KDRUJUK" data-value-separator="<?php echo $t_pendaftaran->KDRUJUK->DisplayValueSeparatorAttribute() ?>" id="x_KDRUJUK" name="x_KDRUJUK"<?php echo $t_pendaftaran->KDRUJUK->EditAttributes() ?>>
<?php echo $t_pendaftaran->KDRUJUK->SelectOptionListHtml("x_KDRUJUK") ?>
</select>
<input type="hidden" name="s_x_KDRUJUK" id="s_x_KDRUJUK" value="<?php echo $t_pendaftaran->KDRUJUK->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->KDRUJUK->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<div id="r_KDCARABAYAR" class="form-group">
		<label id="elh_t_pendaftaran_KDCARABAYAR" for="x_KDCARABAYAR" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_KDCARABAYAR" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->KDCARABAYAR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->KDCARABAYAR->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_KDCARABAYAR" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_KDCARABAYAR">
<select data-table="t_pendaftaran" data-field="x_KDCARABAYAR" data-value-separator="<?php echo $t_pendaftaran->KDCARABAYAR->DisplayValueSeparatorAttribute() ?>" id="x_KDCARABAYAR" name="x_KDCARABAYAR"<?php echo $t_pendaftaran->KDCARABAYAR->EditAttributes() ?>>
<?php echo $t_pendaftaran->KDCARABAYAR->SelectOptionListHtml("x_KDCARABAYAR") ?>
</select>
<input type="hidden" name="s_x_KDCARABAYAR" id="s_x_KDCARABAYAR" value="<?php echo $t_pendaftaran->KDCARABAYAR->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->KDCARABAYAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->SHIFT->Visible) { // SHIFT ?>
	<div id="r_SHIFT" class="form-group">
		<label id="elh_t_pendaftaran_SHIFT" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_SHIFT" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->SHIFT->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->SHIFT->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_SHIFT" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_SHIFT">
<div id="tp_x_SHIFT" class="ewTemplate"><input type="radio" data-table="t_pendaftaran" data-field="x_SHIFT" data-value-separator="<?php echo $t_pendaftaran->SHIFT->DisplayValueSeparatorAttribute() ?>" name="x_SHIFT" id="x_SHIFT" value="{value}"<?php echo $t_pendaftaran->SHIFT->EditAttributes() ?>></div>
<div id="dsl_x_SHIFT" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_pendaftaran->SHIFT->RadioButtonListHtml(FALSE, "x_SHIFT") ?>
</div></div>
<input type="hidden" name="s_x_SHIFT" id="s_x_SHIFT" value="<?php echo $t_pendaftaran->SHIFT->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->SHIFT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_t_pendaftaran_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_NIP" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->NIP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->NIP->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_NIP" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_NIP">
<input type="text" data-table="t_pendaftaran" data-field="x_NIP" name="x_NIP" id="x_NIP" size="30" maxlength="16" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->NIP->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->NIP->EditValue ?>"<?php echo $t_pendaftaran->NIP->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->KETRUJUK->Visible) { // KETRUJUK ?>
	<div id="r_KETRUJUK" class="form-group">
		<label id="elh_t_pendaftaran_KETRUJUK" for="x_KETRUJUK" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_KETRUJUK" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->KETRUJUK->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->KETRUJUK->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_KETRUJUK" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_KETRUJUK">
<input type="text" data-table="t_pendaftaran" data-field="x_KETRUJUK" name="x_KETRUJUK" id="x_KETRUJUK" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->KETRUJUK->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->KETRUJUK->EditValue ?>"<?php echo $t_pendaftaran->KETRUJUK->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->KETRUJUK->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->PENANGGUNGJAWAB_NAMA->Visible) { // PENANGGUNGJAWAB_NAMA ?>
	<div id="r_PENANGGUNGJAWAB_NAMA" class="form-group">
		<label id="elh_t_pendaftaran_PENANGGUNGJAWAB_NAMA" for="x_PENANGGUNGJAWAB_NAMA" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_PENANGGUNGJAWAB_NAMA" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->PENANGGUNGJAWAB_NAMA->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->PENANGGUNGJAWAB_NAMA->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_PENANGGUNGJAWAB_NAMA" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_PENANGGUNGJAWAB_NAMA">
<input type="text" data-table="t_pendaftaran" data-field="x_PENANGGUNGJAWAB_NAMA" name="x_PENANGGUNGJAWAB_NAMA" id="x_PENANGGUNGJAWAB_NAMA" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->PENANGGUNGJAWAB_NAMA->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->PENANGGUNGJAWAB_NAMA->EditValue ?>"<?php echo $t_pendaftaran->PENANGGUNGJAWAB_NAMA->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->PENANGGUNGJAWAB_NAMA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->Visible) { // PENANGGUNGJAWAB_HUBUNGAN ?>
	<div id="r_PENANGGUNGJAWAB_HUBUNGAN" class="form-group">
		<label id="elh_t_pendaftaran_PENANGGUNGJAWAB_HUBUNGAN" for="x_PENANGGUNGJAWAB_HUBUNGAN" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_PENANGGUNGJAWAB_HUBUNGAN" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_PENANGGUNGJAWAB_HUBUNGAN" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_PENANGGUNGJAWAB_HUBUNGAN">
<input type="text" data-table="t_pendaftaran" data-field="x_PENANGGUNGJAWAB_HUBUNGAN" name="x_PENANGGUNGJAWAB_HUBUNGAN" id="x_PENANGGUNGJAWAB_HUBUNGAN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->EditValue ?>"<?php echo $t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->PENANGGUNGJAWAB_HUBUNGAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->Visible) { // PENANGGUNGJAWAB_ALAMAT ?>
	<div id="r_PENANGGUNGJAWAB_ALAMAT" class="form-group">
		<label id="elh_t_pendaftaran_PENANGGUNGJAWAB_ALAMAT" for="x_PENANGGUNGJAWAB_ALAMAT" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_PENANGGUNGJAWAB_ALAMAT" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_PENANGGUNGJAWAB_ALAMAT" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_PENANGGUNGJAWAB_ALAMAT">
<input type="text" data-table="t_pendaftaran" data-field="x_PENANGGUNGJAWAB_ALAMAT" name="x_PENANGGUNGJAWAB_ALAMAT" id="x_PENANGGUNGJAWAB_ALAMAT" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->EditValue ?>"<?php echo $t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->PENANGGUNGJAWAB_ALAMAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->PENANGGUNGJAWAB_PHONE->Visible) { // PENANGGUNGJAWAB_PHONE ?>
	<div id="r_PENANGGUNGJAWAB_PHONE" class="form-group">
		<label id="elh_t_pendaftaran_PENANGGUNGJAWAB_PHONE" for="x_PENANGGUNGJAWAB_PHONE" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_PENANGGUNGJAWAB_PHONE" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->PENANGGUNGJAWAB_PHONE->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->PENANGGUNGJAWAB_PHONE->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_PENANGGUNGJAWAB_PHONE" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_PENANGGUNGJAWAB_PHONE">
<input type="text" data-table="t_pendaftaran" data-field="x_PENANGGUNGJAWAB_PHONE" name="x_PENANGGUNGJAWAB_PHONE" id="x_PENANGGUNGJAWAB_PHONE" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->PENANGGUNGJAWAB_PHONE->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->PENANGGUNGJAWAB_PHONE->EditValue ?>"<?php echo $t_pendaftaran->PENANGGUNGJAWAB_PHONE->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->PENANGGUNGJAWAB_PHONE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->NOKARTU->Visible) { // NOKARTU ?>
	<div id="r_NOKARTU" class="form-group">
		<label id="elh_t_pendaftaran_NOKARTU" for="x_NOKARTU" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_NOKARTU" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->NOKARTU->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->NOKARTU->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_NOKARTU" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_NOKARTU">
<input type="text" data-table="t_pendaftaran" data-field="x_NOKARTU" name="x_NOKARTU" id="x_NOKARTU" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->NOKARTU->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->NOKARTU->EditValue ?>"<?php echo $t_pendaftaran->NOKARTU->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->NOKARTU->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->MINTA_RUJUKAN->Visible) { // MINTA_RUJUKAN ?>
	<div id="r_MINTA_RUJUKAN" class="form-group">
		<label id="elh_t_pendaftaran_MINTA_RUJUKAN" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_MINTA_RUJUKAN" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->MINTA_RUJUKAN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->MINTA_RUJUKAN->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_MINTA_RUJUKAN" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_MINTA_RUJUKAN">
<div id="tp_x_MINTA_RUJUKAN" class="ewTemplate"><input type="checkbox" data-table="t_pendaftaran" data-field="x_MINTA_RUJUKAN" data-value-separator="<?php echo $t_pendaftaran->MINTA_RUJUKAN->DisplayValueSeparatorAttribute() ?>" name="x_MINTA_RUJUKAN[]" id="x_MINTA_RUJUKAN[]" value="{value}"<?php echo $t_pendaftaran->MINTA_RUJUKAN->EditAttributes() ?>></div>
<div id="dsl_x_MINTA_RUJUKAN" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_pendaftaran->MINTA_RUJUKAN->CheckBoxListHtml(FALSE, "x_MINTA_RUJUKAN[]") ?>
</div></div>
</span>
</script>
<?php echo $t_pendaftaran->MINTA_RUJUKAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_TITLE->Visible) { // pasien_TITLE ?>
	<div id="r_pasien_TITLE" class="form-group">
		<label id="elh_t_pendaftaran_pasien_TITLE" for="x_pasien_TITLE" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_TITLE" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_TITLE->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_TITLE->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_TITLE" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_TITLE">
<select data-table="t_pendaftaran" data-field="x_pasien_TITLE" data-value-separator="<?php echo $t_pendaftaran->pasien_TITLE->DisplayValueSeparatorAttribute() ?>" id="x_pasien_TITLE" name="x_pasien_TITLE"<?php echo $t_pendaftaran->pasien_TITLE->EditAttributes() ?>>
<?php echo $t_pendaftaran->pasien_TITLE->SelectOptionListHtml("x_pasien_TITLE") ?>
</select>
<input type="hidden" name="s_x_pasien_TITLE" id="s_x_pasien_TITLE" value="<?php echo $t_pendaftaran->pasien_TITLE->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->pasien_TITLE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_NAMA->Visible) { // pasien_NAMA ?>
	<div id="r_pasien_NAMA" class="form-group">
		<label id="elh_t_pendaftaran_pasien_NAMA" for="x_pasien_NAMA" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_NAMA" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_NAMA->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_NAMA->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_NAMA" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_NAMA">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_NAMA" name="x_pasien_NAMA" id="x_pasien_NAMA" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_NAMA->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_NAMA->EditValue ?>"<?php echo $t_pendaftaran->pasien_NAMA->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_NAMA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_TEMPAT->Visible) { // pasien_TEMPAT ?>
	<div id="r_pasien_TEMPAT" class="form-group">
		<label id="elh_t_pendaftaran_pasien_TEMPAT" for="x_pasien_TEMPAT" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_TEMPAT" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_TEMPAT->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_TEMPAT->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_TEMPAT" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_TEMPAT">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_TEMPAT" name="x_pasien_TEMPAT" id="x_pasien_TEMPAT" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_TEMPAT->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_TEMPAT->EditValue ?>"<?php echo $t_pendaftaran->pasien_TEMPAT->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_TEMPAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_TGLLAHIR->Visible) { // pasien_TGLLAHIR ?>
	<div id="r_pasien_TGLLAHIR" class="form-group">
		<label id="elh_t_pendaftaran_pasien_TGLLAHIR" for="x_pasien_TGLLAHIR" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_TGLLAHIR" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_TGLLAHIR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_TGLLAHIR->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_TGLLAHIR" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_TGLLAHIR">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_TGLLAHIR" data-format="7" name="x_pasien_TGLLAHIR" id="x_pasien_TGLLAHIR" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_TGLLAHIR->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_TGLLAHIR->EditValue ?>"<?php echo $t_pendaftaran->pasien_TGLLAHIR->EditAttributes() ?>>
<?php if (!$t_pendaftaran->pasien_TGLLAHIR->ReadOnly && !$t_pendaftaran->pasien_TGLLAHIR->Disabled && !isset($t_pendaftaran->pasien_TGLLAHIR->EditAttrs["readonly"]) && !isset($t_pendaftaran->pasien_TGLLAHIR->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="t_pendaftaranadd_js">
ew_CreateCalendar("ft_pendaftaranadd", "x_pasien_TGLLAHIR", 7);
</script>
<?php echo $t_pendaftaran->pasien_TGLLAHIR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_JENISKELAMIN->Visible) { // pasien_JENISKELAMIN ?>
	<div id="r_pasien_JENISKELAMIN" class="form-group">
		<label id="elh_t_pendaftaran_pasien_JENISKELAMIN" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_JENISKELAMIN" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_JENISKELAMIN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_JENISKELAMIN->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_JENISKELAMIN" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_JENISKELAMIN">
<div id="tp_x_pasien_JENISKELAMIN" class="ewTemplate"><input type="radio" data-table="t_pendaftaran" data-field="x_pasien_JENISKELAMIN" data-value-separator="<?php echo $t_pendaftaran->pasien_JENISKELAMIN->DisplayValueSeparatorAttribute() ?>" name="x_pasien_JENISKELAMIN" id="x_pasien_JENISKELAMIN" value="{value}"<?php echo $t_pendaftaran->pasien_JENISKELAMIN->EditAttributes() ?>></div>
<div id="dsl_x_pasien_JENISKELAMIN" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_pendaftaran->pasien_JENISKELAMIN->RadioButtonListHtml(FALSE, "x_pasien_JENISKELAMIN") ?>
</div></div>
<input type="hidden" name="s_x_pasien_JENISKELAMIN" id="s_x_pasien_JENISKELAMIN" value="<?php echo $t_pendaftaran->pasien_JENISKELAMIN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->pasien_JENISKELAMIN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_ALAMAT->Visible) { // pasien_ALAMAT ?>
	<div id="r_pasien_ALAMAT" class="form-group">
		<label id="elh_t_pendaftaran_pasien_ALAMAT" for="x_pasien_ALAMAT" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_ALAMAT" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_ALAMAT->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_ALAMAT->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_ALAMAT" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_ALAMAT">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_ALAMAT" name="x_pasien_ALAMAT" id="x_pasien_ALAMAT" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_ALAMAT->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_ALAMAT->EditValue ?>"<?php echo $t_pendaftaran->pasien_ALAMAT->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_ALAMAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_NOTELP->Visible) { // pasien_NOTELP ?>
	<div id="r_pasien_NOTELP" class="form-group">
		<label id="elh_t_pendaftaran_pasien_NOTELP" for="x_pasien_NOTELP" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_NOTELP" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_NOTELP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_NOTELP->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_NOTELP" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_NOTELP">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_NOTELP" name="x_pasien_NOTELP" id="x_pasien_NOTELP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_NOTELP->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_NOTELP->EditValue ?>"<?php echo $t_pendaftaran->pasien_NOTELP->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_NOTELP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_NOKTP->Visible) { // pasien_NOKTP ?>
	<div id="r_pasien_NOKTP" class="form-group">
		<label id="elh_t_pendaftaran_pasien_NOKTP" for="x_pasien_NOKTP" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_NOKTP" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_NOKTP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_NOKTP->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_NOKTP" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_NOKTP">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_NOKTP" name="x_pasien_NOKTP" id="x_pasien_NOKTP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_NOKTP->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_NOKTP->EditValue ?>"<?php echo $t_pendaftaran->pasien_NOKTP->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_NOKTP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_PEKERJAAN->Visible) { // pasien_PEKERJAAN ?>
	<div id="r_pasien_PEKERJAAN" class="form-group">
		<label id="elh_t_pendaftaran_pasien_PEKERJAAN" for="x_pasien_PEKERJAAN" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_PEKERJAAN" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_PEKERJAAN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_PEKERJAAN->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_PEKERJAAN" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_PEKERJAAN">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_PEKERJAAN" name="x_pasien_PEKERJAAN" id="x_pasien_PEKERJAAN" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_PEKERJAAN->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_PEKERJAAN->EditValue ?>"<?php echo $t_pendaftaran->pasien_PEKERJAAN->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_PEKERJAAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_AGAMA->Visible) { // pasien_AGAMA ?>
	<div id="r_pasien_AGAMA" class="form-group">
		<label id="elh_t_pendaftaran_pasien_AGAMA" for="x_pasien_AGAMA" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_AGAMA" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_AGAMA->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_AGAMA->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_AGAMA" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_AGAMA">
<select data-table="t_pendaftaran" data-field="x_pasien_AGAMA" data-value-separator="<?php echo $t_pendaftaran->pasien_AGAMA->DisplayValueSeparatorAttribute() ?>" id="x_pasien_AGAMA" name="x_pasien_AGAMA"<?php echo $t_pendaftaran->pasien_AGAMA->EditAttributes() ?>>
<?php echo $t_pendaftaran->pasien_AGAMA->SelectOptionListHtml("x_pasien_AGAMA") ?>
</select>
<input type="hidden" name="s_x_pasien_AGAMA" id="s_x_pasien_AGAMA" value="<?php echo $t_pendaftaran->pasien_AGAMA->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->pasien_AGAMA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_PENDIDIKAN->Visible) { // pasien_PENDIDIKAN ?>
	<div id="r_pasien_PENDIDIKAN" class="form-group">
		<label id="elh_t_pendaftaran_pasien_PENDIDIKAN" for="x_pasien_PENDIDIKAN" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_PENDIDIKAN" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_PENDIDIKAN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_PENDIDIKAN->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_PENDIDIKAN" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_PENDIDIKAN">
<select data-table="t_pendaftaran" data-field="x_pasien_PENDIDIKAN" data-value-separator="<?php echo $t_pendaftaran->pasien_PENDIDIKAN->DisplayValueSeparatorAttribute() ?>" id="x_pasien_PENDIDIKAN" name="x_pasien_PENDIDIKAN"<?php echo $t_pendaftaran->pasien_PENDIDIKAN->EditAttributes() ?>>
<?php echo $t_pendaftaran->pasien_PENDIDIKAN->SelectOptionListHtml("x_pasien_PENDIDIKAN") ?>
</select>
<input type="hidden" name="s_x_pasien_PENDIDIKAN" id="s_x_pasien_PENDIDIKAN" value="<?php echo $t_pendaftaran->pasien_PENDIDIKAN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->pasien_PENDIDIKAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_ALAMAT_KTP->Visible) { // pasien_ALAMAT_KTP ?>
	<div id="r_pasien_ALAMAT_KTP" class="form-group">
		<label id="elh_t_pendaftaran_pasien_ALAMAT_KTP" for="x_pasien_ALAMAT_KTP" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_ALAMAT_KTP" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_ALAMAT_KTP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_ALAMAT_KTP->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_ALAMAT_KTP" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_ALAMAT_KTP">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_ALAMAT_KTP" name="x_pasien_ALAMAT_KTP" id="x_pasien_ALAMAT_KTP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_ALAMAT_KTP->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_ALAMAT_KTP->EditValue ?>"<?php echo $t_pendaftaran->pasien_ALAMAT_KTP->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_ALAMAT_KTP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_NO_KARTU->Visible) { // pasien_NO_KARTU ?>
	<div id="r_pasien_NO_KARTU" class="form-group">
		<label id="elh_t_pendaftaran_pasien_NO_KARTU" for="x_pasien_NO_KARTU" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_NO_KARTU" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_NO_KARTU->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_NO_KARTU->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_NO_KARTU" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_NO_KARTU">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_NO_KARTU" name="x_pasien_NO_KARTU" id="x_pasien_NO_KARTU" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_NO_KARTU->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_NO_KARTU->EditValue ?>"<?php echo $t_pendaftaran->pasien_NO_KARTU->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_NO_KARTU->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_JNS_PASIEN->Visible) { // pasien_JNS_PASIEN ?>
	<div id="r_pasien_JNS_PASIEN" class="form-group">
		<label id="elh_t_pendaftaran_pasien_JNS_PASIEN" for="x_pasien_JNS_PASIEN" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_JNS_PASIEN" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_JNS_PASIEN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_JNS_PASIEN->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_JNS_PASIEN" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_JNS_PASIEN">
<select data-table="t_pendaftaran" data-field="x_pasien_JNS_PASIEN" data-value-separator="<?php echo $t_pendaftaran->pasien_JNS_PASIEN->DisplayValueSeparatorAttribute() ?>" id="x_pasien_JNS_PASIEN" name="x_pasien_JNS_PASIEN"<?php echo $t_pendaftaran->pasien_JNS_PASIEN->EditAttributes() ?>>
<?php echo $t_pendaftaran->pasien_JNS_PASIEN->SelectOptionListHtml("x_pasien_JNS_PASIEN") ?>
</select>
<input type="hidden" name="s_x_pasien_JNS_PASIEN" id="s_x_pasien_JNS_PASIEN" value="<?php echo $t_pendaftaran->pasien_JNS_PASIEN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->pasien_JNS_PASIEN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_nama_ayah->Visible) { // pasien_nama_ayah ?>
	<div id="r_pasien_nama_ayah" class="form-group">
		<label id="elh_t_pendaftaran_pasien_nama_ayah" for="x_pasien_nama_ayah" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_nama_ayah" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_nama_ayah->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_nama_ayah->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_nama_ayah" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_nama_ayah">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_nama_ayah" name="x_pasien_nama_ayah" id="x_pasien_nama_ayah" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_nama_ayah->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_nama_ayah->EditValue ?>"<?php echo $t_pendaftaran->pasien_nama_ayah->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_nama_ayah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_nama_ibu->Visible) { // pasien_nama_ibu ?>
	<div id="r_pasien_nama_ibu" class="form-group">
		<label id="elh_t_pendaftaran_pasien_nama_ibu" for="x_pasien_nama_ibu" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_nama_ibu" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_nama_ibu->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_nama_ibu->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_nama_ibu" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_nama_ibu">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_nama_ibu" name="x_pasien_nama_ibu" id="x_pasien_nama_ibu" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_nama_ibu->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_nama_ibu->EditValue ?>"<?php echo $t_pendaftaran->pasien_nama_ibu->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_nama_ibu->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_nama_suami->Visible) { // pasien_nama_suami ?>
	<div id="r_pasien_nama_suami" class="form-group">
		<label id="elh_t_pendaftaran_pasien_nama_suami" for="x_pasien_nama_suami" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_nama_suami" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_nama_suami->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_nama_suami->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_nama_suami" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_nama_suami">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_nama_suami" name="x_pasien_nama_suami" id="x_pasien_nama_suami" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_nama_suami->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_nama_suami->EditValue ?>"<?php echo $t_pendaftaran->pasien_nama_suami->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_nama_suami->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_nama_istri->Visible) { // pasien_nama_istri ?>
	<div id="r_pasien_nama_istri" class="form-group">
		<label id="elh_t_pendaftaran_pasien_nama_istri" for="x_pasien_nama_istri" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_nama_istri" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_nama_istri->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_nama_istri->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_nama_istri" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_nama_istri">
<input type="text" data-table="t_pendaftaran" data-field="x_pasien_nama_istri" name="x_pasien_nama_istri" id="x_pasien_nama_istri" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->pasien_nama_istri->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->pasien_nama_istri->EditValue ?>"<?php echo $t_pendaftaran->pasien_nama_istri->EditAttributes() ?>>
</span>
</script>
<?php echo $t_pendaftaran->pasien_nama_istri->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_KD_ETNIS->Visible) { // pasien_KD_ETNIS ?>
	<div id="r_pasien_KD_ETNIS" class="form-group">
		<label id="elh_t_pendaftaran_pasien_KD_ETNIS" for="x_pasien_KD_ETNIS" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_KD_ETNIS" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_KD_ETNIS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_KD_ETNIS->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_KD_ETNIS" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_KD_ETNIS">
<select data-table="t_pendaftaran" data-field="x_pasien_KD_ETNIS" data-value-separator="<?php echo $t_pendaftaran->pasien_KD_ETNIS->DisplayValueSeparatorAttribute() ?>" id="x_pasien_KD_ETNIS" name="x_pasien_KD_ETNIS"<?php echo $t_pendaftaran->pasien_KD_ETNIS->EditAttributes() ?>>
<?php echo $t_pendaftaran->pasien_KD_ETNIS->SelectOptionListHtml("x_pasien_KD_ETNIS") ?>
</select>
<input type="hidden" name="s_x_pasien_KD_ETNIS" id="s_x_pasien_KD_ETNIS" value="<?php echo $t_pendaftaran->pasien_KD_ETNIS->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->pasien_KD_ETNIS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->pasien_KD_BHS_HARIAN->Visible) { // pasien_KD_BHS_HARIAN ?>
	<div id="r_pasien_KD_BHS_HARIAN" class="form-group">
		<label id="elh_t_pendaftaran_pasien_KD_BHS_HARIAN" for="x_pasien_KD_BHS_HARIAN" class="col-sm-2 control-label ewLabel"><script id="tpc_t_pendaftaran_pasien_KD_BHS_HARIAN" class="t_pendaftaranadd" type="text/html"><span><?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->CellAttributes() ?>>
<script id="tpx_t_pendaftaran_pasien_KD_BHS_HARIAN" class="t_pendaftaranadd" type="text/html">
<span id="el_t_pendaftaran_pasien_KD_BHS_HARIAN">
<select data-table="t_pendaftaran" data-field="x_pasien_KD_BHS_HARIAN" data-value-separator="<?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->DisplayValueSeparatorAttribute() ?>" id="x_pasien_KD_BHS_HARIAN" name="x_pasien_KD_BHS_HARIAN"<?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->EditAttributes() ?>>
<?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->SelectOptionListHtml("x_pasien_KD_BHS_HARIAN") ?>
</select>
<input type="hidden" name="s_x_pasien_KD_BHS_HARIAN" id="s_x_pasien_KD_BHS_HARIAN" value="<?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $t_pendaftaran->pasien_KD_BHS_HARIAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_pendaftaran_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_pendaftaran_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_t_pendaftaranadd", "tpm_t_pendaftaranadd", "t_pendaftaranadd", "<?php echo $t_pendaftaran->CustomExport ?>");
jQuery("script.t_pendaftaranadd_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
ft_pendaftaranadd.Init();
</script>
<?php
$t_pendaftaran_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

$("#x_NOKARTU").keyup(function () {
	   let NOKARTU = $("#x_NOKARTU").val();
	   $("#x_pasien_NO_KARTU").val(NOKARTU);
});
$("#x_pasien_ALAMAT").keyup(function () {
	   let pasien_ALAMAT = $("#x_pasien_ALAMAT").val();
	   $("#x_pasien_ALAMAT_KTP").val(pasien_ALAMAT);
	   $("#x_PENANGGUNGJAWAB_ALAMAT").val(pasien_ALAMAT);
});
$("#x_pasien_NOTELP").keyup(function () {
	   let pasien_NOTELP = $("#x_pasien_NOTELP").val();

	   //alert(pasien_NOTELP);
	   $("#x_PENANGGUNGJAWAB_PHONE").val(pasien_NOTELP);
});
$("#x_KDCARABAYAR").on('change',function(){
	 let carabayar = $("#x_KDCARABAYAR").val();

	// alert(carabayar);
	 if(carabayar == 1){

	 	//$('#x_KDRUJUK').hide();
	  	$('#x_KETRUJUK').hide();

	  	//$('#elh_sample_KDRUJUK').hide();
	  	$('#elh_sample_KETRUJUK').hide();
	  }else{

	  	//$('#x_KDRUJUK').show();
	  	$('#x_KETRUJUK').show();

	  	//$('#elh_sample_KDRUJUK').show();
	  	$('#elh_sample_KETRUJUK').show();
	  }
});
</script>
<?php include_once "footer.php" ?>
<?php
$t_pendaftaran_add->Page_Terminate();
?>
