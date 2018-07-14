<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_pasieninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_pasien_add = NULL; // Initialize page object first

class cm_pasien_add extends cm_pasien {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_pasien';

	// Page object name
	var $PageObjName = 'm_pasien_add';

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

		// Table object (m_pasien)
		if (!isset($GLOBALS["m_pasien"]) || get_class($GLOBALS["m_pasien"]) == "cm_pasien") {
			$GLOBALS["m_pasien"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_pasien"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_pasien', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_pasienlist.php"));
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
		global $EW_EXPORT, $m_pasien;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_pasien);
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
					$this->Page_Terminate("m_pasienlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "m_pasienlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "m_pasienview.php")
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
		$this->TITLE->CurrentValue = NULL;
		$this->TITLE->OldValue = $this->TITLE->CurrentValue;
		$this->NAMA->CurrentValue = "-";
		$this->TEMPAT->CurrentValue = "-";
		$this->TGLLAHIR->CurrentValue = date("d/m/Y");
		$this->JENISKELAMIN->CurrentValue = "-";
		$this->ALAMAT->CurrentValue = "-";
		$this->KDPROVINSI->CurrentValue = NULL;
		$this->KDPROVINSI->OldValue = $this->KDPROVINSI->CurrentValue;
		$this->KOTA->CurrentValue = "-";
		$this->KDKECAMATAN->CurrentValue = 0;
		$this->KELURAHAN->CurrentValue = "-";
		$this->NOTELP->CurrentValue = "-";
		$this->NOKTP->CurrentValue = "-";
		$this->PEKERJAAN->CurrentValue = "-";
		$this->STATUS->CurrentValue = 0;
		$this->AGAMA->CurrentValue = 0;
		$this->PENDIDIKAN->CurrentValue = 0;
		$this->KDCARABAYAR->CurrentValue = 0;
		$this->NIP->CurrentValue = NULL;
		$this->NIP->OldValue = $this->NIP->CurrentValue;
		$this->TGLDAFTAR->CurrentValue = date("d/m/Y");
		$this->ALAMAT_KTP->CurrentValue = NULL;
		$this->ALAMAT_KTP->OldValue = $this->ALAMAT_KTP->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_NAMA->OldValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_HUBUNGAN->OldValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_ALAMAT->OldValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->CurrentValue = NULL;
		$this->PENANGGUNGJAWAB_PHONE->OldValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->NO_KARTU->CurrentValue = NULL;
		$this->NO_KARTU->OldValue = $this->NO_KARTU->CurrentValue;
		$this->JNS_PASIEN->CurrentValue = NULL;
		$this->JNS_PASIEN->OldValue = $this->JNS_PASIEN->CurrentValue;
		$this->nama_ayah->CurrentValue = NULL;
		$this->nama_ayah->OldValue = $this->nama_ayah->CurrentValue;
		$this->nama_ibu->CurrentValue = NULL;
		$this->nama_ibu->OldValue = $this->nama_ibu->CurrentValue;
		$this->nama_suami->CurrentValue = NULL;
		$this->nama_suami->OldValue = $this->nama_suami->CurrentValue;
		$this->nama_istri->CurrentValue = NULL;
		$this->nama_istri->OldValue = $this->nama_istri->CurrentValue;
		$this->KD_ETNIS->CurrentValue = NULL;
		$this->KD_ETNIS->OldValue = $this->KD_ETNIS->CurrentValue;
		$this->KD_BHS_HARIAN->CurrentValue = NULL;
		$this->KD_BHS_HARIAN->OldValue = $this->KD_BHS_HARIAN->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->TITLE->FldIsDetailKey) {
			$this->TITLE->setFormValue($objForm->GetValue("x_TITLE"));
		}
		if (!$this->NAMA->FldIsDetailKey) {
			$this->NAMA->setFormValue($objForm->GetValue("x_NAMA"));
		}
		if (!$this->TEMPAT->FldIsDetailKey) {
			$this->TEMPAT->setFormValue($objForm->GetValue("x_TEMPAT"));
		}
		if (!$this->TGLLAHIR->FldIsDetailKey) {
			$this->TGLLAHIR->setFormValue($objForm->GetValue("x_TGLLAHIR"));
			$this->TGLLAHIR->CurrentValue = ew_UnFormatDateTime($this->TGLLAHIR->CurrentValue, 7);
		}
		if (!$this->JENISKELAMIN->FldIsDetailKey) {
			$this->JENISKELAMIN->setFormValue($objForm->GetValue("x_JENISKELAMIN"));
		}
		if (!$this->ALAMAT->FldIsDetailKey) {
			$this->ALAMAT->setFormValue($objForm->GetValue("x_ALAMAT"));
		}
		if (!$this->KDPROVINSI->FldIsDetailKey) {
			$this->KDPROVINSI->setFormValue($objForm->GetValue("x_KDPROVINSI"));
		}
		if (!$this->KOTA->FldIsDetailKey) {
			$this->KOTA->setFormValue($objForm->GetValue("x_KOTA"));
		}
		if (!$this->KDKECAMATAN->FldIsDetailKey) {
			$this->KDKECAMATAN->setFormValue($objForm->GetValue("x_KDKECAMATAN"));
		}
		if (!$this->KELURAHAN->FldIsDetailKey) {
			$this->KELURAHAN->setFormValue($objForm->GetValue("x_KELURAHAN"));
		}
		if (!$this->NOTELP->FldIsDetailKey) {
			$this->NOTELP->setFormValue($objForm->GetValue("x_NOTELP"));
		}
		if (!$this->NOKTP->FldIsDetailKey) {
			$this->NOKTP->setFormValue($objForm->GetValue("x_NOKTP"));
		}
		if (!$this->PEKERJAAN->FldIsDetailKey) {
			$this->PEKERJAAN->setFormValue($objForm->GetValue("x_PEKERJAAN"));
		}
		if (!$this->STATUS->FldIsDetailKey) {
			$this->STATUS->setFormValue($objForm->GetValue("x_STATUS"));
		}
		if (!$this->AGAMA->FldIsDetailKey) {
			$this->AGAMA->setFormValue($objForm->GetValue("x_AGAMA"));
		}
		if (!$this->PENDIDIKAN->FldIsDetailKey) {
			$this->PENDIDIKAN->setFormValue($objForm->GetValue("x_PENDIDIKAN"));
		}
		if (!$this->KDCARABAYAR->FldIsDetailKey) {
			$this->KDCARABAYAR->setFormValue($objForm->GetValue("x_KDCARABAYAR"));
		}
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->TGLDAFTAR->FldIsDetailKey) {
			$this->TGLDAFTAR->setFormValue($objForm->GetValue("x_TGLDAFTAR"));
			$this->TGLDAFTAR->CurrentValue = ew_UnFormatDateTime($this->TGLDAFTAR->CurrentValue, 7);
		}
		if (!$this->ALAMAT_KTP->FldIsDetailKey) {
			$this->ALAMAT_KTP->setFormValue($objForm->GetValue("x_ALAMAT_KTP"));
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
		if (!$this->NO_KARTU->FldIsDetailKey) {
			$this->NO_KARTU->setFormValue($objForm->GetValue("x_NO_KARTU"));
		}
		if (!$this->JNS_PASIEN->FldIsDetailKey) {
			$this->JNS_PASIEN->setFormValue($objForm->GetValue("x_JNS_PASIEN"));
		}
		if (!$this->nama_ayah->FldIsDetailKey) {
			$this->nama_ayah->setFormValue($objForm->GetValue("x_nama_ayah"));
		}
		if (!$this->nama_ibu->FldIsDetailKey) {
			$this->nama_ibu->setFormValue($objForm->GetValue("x_nama_ibu"));
		}
		if (!$this->nama_suami->FldIsDetailKey) {
			$this->nama_suami->setFormValue($objForm->GetValue("x_nama_suami"));
		}
		if (!$this->nama_istri->FldIsDetailKey) {
			$this->nama_istri->setFormValue($objForm->GetValue("x_nama_istri"));
		}
		if (!$this->KD_ETNIS->FldIsDetailKey) {
			$this->KD_ETNIS->setFormValue($objForm->GetValue("x_KD_ETNIS"));
		}
		if (!$this->KD_BHS_HARIAN->FldIsDetailKey) {
			$this->KD_BHS_HARIAN->setFormValue($objForm->GetValue("x_KD_BHS_HARIAN"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->TITLE->CurrentValue = $this->TITLE->FormValue;
		$this->NAMA->CurrentValue = $this->NAMA->FormValue;
		$this->TEMPAT->CurrentValue = $this->TEMPAT->FormValue;
		$this->TGLLAHIR->CurrentValue = $this->TGLLAHIR->FormValue;
		$this->TGLLAHIR->CurrentValue = ew_UnFormatDateTime($this->TGLLAHIR->CurrentValue, 7);
		$this->JENISKELAMIN->CurrentValue = $this->JENISKELAMIN->FormValue;
		$this->ALAMAT->CurrentValue = $this->ALAMAT->FormValue;
		$this->KDPROVINSI->CurrentValue = $this->KDPROVINSI->FormValue;
		$this->KOTA->CurrentValue = $this->KOTA->FormValue;
		$this->KDKECAMATAN->CurrentValue = $this->KDKECAMATAN->FormValue;
		$this->KELURAHAN->CurrentValue = $this->KELURAHAN->FormValue;
		$this->NOTELP->CurrentValue = $this->NOTELP->FormValue;
		$this->NOKTP->CurrentValue = $this->NOKTP->FormValue;
		$this->PEKERJAAN->CurrentValue = $this->PEKERJAAN->FormValue;
		$this->STATUS->CurrentValue = $this->STATUS->FormValue;
		$this->AGAMA->CurrentValue = $this->AGAMA->FormValue;
		$this->PENDIDIKAN->CurrentValue = $this->PENDIDIKAN->FormValue;
		$this->KDCARABAYAR->CurrentValue = $this->KDCARABAYAR->FormValue;
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->TGLDAFTAR->CurrentValue = $this->TGLDAFTAR->FormValue;
		$this->TGLDAFTAR->CurrentValue = ew_UnFormatDateTime($this->TGLDAFTAR->CurrentValue, 7);
		$this->ALAMAT_KTP->CurrentValue = $this->ALAMAT_KTP->FormValue;
		$this->PENANGGUNGJAWAB_NAMA->CurrentValue = $this->PENANGGUNGJAWAB_NAMA->FormValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue = $this->PENANGGUNGJAWAB_HUBUNGAN->FormValue;
		$this->PENANGGUNGJAWAB_ALAMAT->CurrentValue = $this->PENANGGUNGJAWAB_ALAMAT->FormValue;
		$this->PENANGGUNGJAWAB_PHONE->CurrentValue = $this->PENANGGUNGJAWAB_PHONE->FormValue;
		$this->NO_KARTU->CurrentValue = $this->NO_KARTU->FormValue;
		$this->JNS_PASIEN->CurrentValue = $this->JNS_PASIEN->FormValue;
		$this->nama_ayah->CurrentValue = $this->nama_ayah->FormValue;
		$this->nama_ibu->CurrentValue = $this->nama_ibu->FormValue;
		$this->nama_suami->CurrentValue = $this->nama_suami->FormValue;
		$this->nama_istri->CurrentValue = $this->nama_istri->FormValue;
		$this->KD_ETNIS->CurrentValue = $this->KD_ETNIS->FormValue;
		$this->KD_BHS_HARIAN->CurrentValue = $this->KD_BHS_HARIAN->FormValue;
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
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TITLE->setDbValue($rs->fields('TITLE'));
		$this->NAMA->setDbValue($rs->fields('NAMA'));
		$this->IBUKANDUNG->setDbValue($rs->fields('IBUKANDUNG'));
		$this->TEMPAT->setDbValue($rs->fields('TEMPAT'));
		$this->TGLLAHIR->setDbValue($rs->fields('TGLLAHIR'));
		$this->JENISKELAMIN->setDbValue($rs->fields('JENISKELAMIN'));
		$this->ALAMAT->setDbValue($rs->fields('ALAMAT'));
		$this->KDPROVINSI->setDbValue($rs->fields('KDPROVINSI'));
		$this->KOTA->setDbValue($rs->fields('KOTA'));
		$this->KDKECAMATAN->setDbValue($rs->fields('KDKECAMATAN'));
		$this->KELURAHAN->setDbValue($rs->fields('KELURAHAN'));
		$this->NOTELP->setDbValue($rs->fields('NOTELP'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->SUAMI_ORTU->setDbValue($rs->fields('SUAMI_ORTU'));
		$this->PEKERJAAN->setDbValue($rs->fields('PEKERJAAN'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->AGAMA->setDbValue($rs->fields('AGAMA'));
		$this->PENDIDIKAN->setDbValue($rs->fields('PENDIDIKAN'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->TGLDAFTAR->setDbValue($rs->fields('TGLDAFTAR'));
		$this->ALAMAT_KTP->setDbValue($rs->fields('ALAMAT_KTP'));
		$this->PARENT_NOMR->setDbValue($rs->fields('PARENT_NOMR'));
		$this->NAMA_OBAT->setDbValue($rs->fields('NAMA_OBAT'));
		$this->DOSIS->setDbValue($rs->fields('DOSIS'));
		$this->CARA_PEMBERIAN->setDbValue($rs->fields('CARA_PEMBERIAN'));
		$this->FREKUENSI->setDbValue($rs->fields('FREKUENSI'));
		$this->WAKTU_TGL->setDbValue($rs->fields('WAKTU_TGL'));
		$this->LAMA_WAKTU->setDbValue($rs->fields('LAMA_WAKTU'));
		$this->ALERGI_OBAT->setDbValue($rs->fields('ALERGI_OBAT'));
		$this->REAKSI_ALERGI->setDbValue($rs->fields('REAKSI_ALERGI'));
		$this->RIWAYAT_KES->setDbValue($rs->fields('RIWAYAT_KES'));
		$this->BB_LAHIR->setDbValue($rs->fields('BB_LAHIR'));
		$this->BB_SEKARANG->setDbValue($rs->fields('BB_SEKARANG'));
		$this->FISIK_FONTANEL->setDbValue($rs->fields('FISIK_FONTANEL'));
		$this->FISIK_REFLEKS->setDbValue($rs->fields('FISIK_REFLEKS'));
		$this->FISIK_SENSASI->setDbValue($rs->fields('FISIK_SENSASI'));
		$this->MOTORIK_KASAR->setDbValue($rs->fields('MOTORIK_KASAR'));
		$this->MOTORIK_HALUS->setDbValue($rs->fields('MOTORIK_HALUS'));
		$this->MAMPU_BICARA->setDbValue($rs->fields('MAMPU_BICARA'));
		$this->MAMPU_SOSIALISASI->setDbValue($rs->fields('MAMPU_SOSIALISASI'));
		$this->BCG->setDbValue($rs->fields('BCG'));
		$this->POLIO->setDbValue($rs->fields('POLIO'));
		$this->DPT->setDbValue($rs->fields('DPT'));
		$this->CAMPAK->setDbValue($rs->fields('CAMPAK'));
		$this->HEPATITIS_B->setDbValue($rs->fields('HEPATITIS_B'));
		$this->TD->setDbValue($rs->fields('TD'));
		$this->SUHU->setDbValue($rs->fields('SUHU'));
		$this->RR->setDbValue($rs->fields('RR'));
		$this->NADI->setDbValue($rs->fields('NADI'));
		$this->BB->setDbValue($rs->fields('BB'));
		$this->TB->setDbValue($rs->fields('TB'));
		$this->EYE->setDbValue($rs->fields('EYE'));
		$this->MOTORIK->setDbValue($rs->fields('MOTORIK'));
		$this->VERBAL->setDbValue($rs->fields('VERBAL'));
		$this->TOTAL_GCS->setDbValue($rs->fields('TOTAL_GCS'));
		$this->REAKSI_PUPIL->setDbValue($rs->fields('REAKSI_PUPIL'));
		$this->KESADARAN->setDbValue($rs->fields('KESADARAN'));
		$this->KEPALA->setDbValue($rs->fields('KEPALA'));
		$this->RAMBUT->setDbValue($rs->fields('RAMBUT'));
		$this->MUKA->setDbValue($rs->fields('MUKA'));
		$this->MATA->setDbValue($rs->fields('MATA'));
		$this->GANG_LIHAT->setDbValue($rs->fields('GANG_LIHAT'));
		$this->ALATBANTU_LIHAT->setDbValue($rs->fields('ALATBANTU_LIHAT'));
		$this->BENTUK->setDbValue($rs->fields('BENTUK'));
		$this->PENDENGARAN->setDbValue($rs->fields('PENDENGARAN'));
		$this->LUB_TELINGA->setDbValue($rs->fields('LUB_TELINGA'));
		$this->BENTUK_HIDUNG->setDbValue($rs->fields('BENTUK_HIDUNG'));
		$this->MEMBRAN_MUK->setDbValue($rs->fields('MEMBRAN_MUK'));
		$this->MAMPU_HIDU->setDbValue($rs->fields('MAMPU_HIDU'));
		$this->ALAT_HIDUNG->setDbValue($rs->fields('ALAT_HIDUNG'));
		$this->RONGGA_MULUT->setDbValue($rs->fields('RONGGA_MULUT'));
		$this->WARNA_MEMBRAN->setDbValue($rs->fields('WARNA_MEMBRAN'));
		$this->LEMBAB->setDbValue($rs->fields('LEMBAB'));
		$this->STOMATITIS->setDbValue($rs->fields('STOMATITIS'));
		$this->LIDAH->setDbValue($rs->fields('LIDAH'));
		$this->GIGI->setDbValue($rs->fields('GIGI'));
		$this->TONSIL->setDbValue($rs->fields('TONSIL'));
		$this->KELAINAN->setDbValue($rs->fields('KELAINAN'));
		$this->PERGERAKAN->setDbValue($rs->fields('PERGERAKAN'));
		$this->KEL_TIROID->setDbValue($rs->fields('KEL_TIROID'));
		$this->KEL_GETAH->setDbValue($rs->fields('KEL_GETAH'));
		$this->TEKANAN_VENA->setDbValue($rs->fields('TEKANAN_VENA'));
		$this->REF_MENELAN->setDbValue($rs->fields('REF_MENELAN'));
		$this->NYERI->setDbValue($rs->fields('NYERI'));
		$this->KREPITASI->setDbValue($rs->fields('KREPITASI'));
		$this->KEL_LAIN->setDbValue($rs->fields('KEL_LAIN'));
		$this->BENTUK_DADA->setDbValue($rs->fields('BENTUK_DADA'));
		$this->POLA_NAPAS->setDbValue($rs->fields('POLA_NAPAS'));
		$this->BENTUK_THORAKS->setDbValue($rs->fields('BENTUK_THORAKS'));
		$this->PAL_KREP->setDbValue($rs->fields('PAL_KREP'));
		$this->BENJOLAN->setDbValue($rs->fields('BENJOLAN'));
		$this->PAL_NYERI->setDbValue($rs->fields('PAL_NYERI'));
		$this->PERKUSI->setDbValue($rs->fields('PERKUSI'));
		$this->PARU->setDbValue($rs->fields('PARU'));
		$this->JANTUNG->setDbValue($rs->fields('JANTUNG'));
		$this->SUARA_JANTUNG->setDbValue($rs->fields('SUARA_JANTUNG'));
		$this->ALATBANTU_JAN->setDbValue($rs->fields('ALATBANTU_JAN'));
		$this->BENTUK_ABDOMEN->setDbValue($rs->fields('BENTUK_ABDOMEN'));
		$this->AUSKULTASI->setDbValue($rs->fields('AUSKULTASI'));
		$this->NYERI_PASI->setDbValue($rs->fields('NYERI_PASI'));
		$this->PEM_KELENJAR->setDbValue($rs->fields('PEM_KELENJAR'));
		$this->PERKUSI_AUS->setDbValue($rs->fields('PERKUSI_AUS'));
		$this->VAGINA->setDbValue($rs->fields('VAGINA'));
		$this->MENSTRUASI->setDbValue($rs->fields('MENSTRUASI'));
		$this->KATETER->setDbValue($rs->fields('KATETER'));
		$this->LABIA_PROM->setDbValue($rs->fields('LABIA_PROM'));
		$this->HAMIL->setDbValue($rs->fields('HAMIL'));
		$this->TGL_HAID->setDbValue($rs->fields('TGL_HAID'));
		$this->PERIKSA_CERVIX->setDbValue($rs->fields('PERIKSA_CERVIX'));
		$this->BENTUK_PAYUDARA->setDbValue($rs->fields('BENTUK_PAYUDARA'));
		$this->KENYAL->setDbValue($rs->fields('KENYAL'));
		$this->MASSA->setDbValue($rs->fields('MASSA'));
		$this->NYERI_RABA->setDbValue($rs->fields('NYERI_RABA'));
		$this->BENTUK_PUTING->setDbValue($rs->fields('BENTUK_PUTING'));
		$this->MAMMO->setDbValue($rs->fields('MAMMO'));
		$this->ALAT_KONTRASEPSI->setDbValue($rs->fields('ALAT_KONTRASEPSI'));
		$this->MASALAH_SEKS->setDbValue($rs->fields('MASALAH_SEKS'));
		$this->PREPUTIUM->setDbValue($rs->fields('PREPUTIUM'));
		$this->MASALAH_PROSTAT->setDbValue($rs->fields('MASALAH_PROSTAT'));
		$this->BENTUK_SKROTUM->setDbValue($rs->fields('BENTUK_SKROTUM'));
		$this->TESTIS->setDbValue($rs->fields('TESTIS'));
		$this->MASSA_BEN->setDbValue($rs->fields('MASSA_BEN'));
		$this->HERNIASI->setDbValue($rs->fields('HERNIASI'));
		$this->LAIN2->setDbValue($rs->fields('LAIN2'));
		$this->ALAT_KONTRA->setDbValue($rs->fields('ALAT_KONTRA'));
		$this->MASALAH_REPRO->setDbValue($rs->fields('MASALAH_REPRO'));
		$this->EKSTREMITAS_ATAS->setDbValue($rs->fields('EKSTREMITAS_ATAS'));
		$this->EKSTREMITAS_BAWAH->setDbValue($rs->fields('EKSTREMITAS_BAWAH'));
		$this->AKTIVITAS->setDbValue($rs->fields('AKTIVITAS'));
		$this->BERJALAN->setDbValue($rs->fields('BERJALAN'));
		$this->SISTEM_INTE->setDbValue($rs->fields('SISTEM_INTE'));
		$this->KENYAMANAN->setDbValue($rs->fields('KENYAMANAN'));
		$this->KES_DIRI->setDbValue($rs->fields('KES_DIRI'));
		$this->SOS_SUPORT->setDbValue($rs->fields('SOS_SUPORT'));
		$this->ANSIETAS->setDbValue($rs->fields('ANSIETAS'));
		$this->KEHILANGAN->setDbValue($rs->fields('KEHILANGAN'));
		$this->STATUS_EMOSI->setDbValue($rs->fields('STATUS_EMOSI'));
		$this->KONSEP_DIRI->setDbValue($rs->fields('KONSEP_DIRI'));
		$this->RESPON_HILANG->setDbValue($rs->fields('RESPON_HILANG'));
		$this->SUMBER_STRESS->setDbValue($rs->fields('SUMBER_STRESS'));
		$this->BERARTI->setDbValue($rs->fields('BERARTI'));
		$this->TERLIBAT->setDbValue($rs->fields('TERLIBAT'));
		$this->HUBUNGAN->setDbValue($rs->fields('HUBUNGAN'));
		$this->KOMUNIKASI->setDbValue($rs->fields('KOMUNIKASI'));
		$this->KEPUTUSAN->setDbValue($rs->fields('KEPUTUSAN'));
		$this->MENGASUH->setDbValue($rs->fields('MENGASUH'));
		$this->DUKUNGAN->setDbValue($rs->fields('DUKUNGAN'));
		$this->REAKSI->setDbValue($rs->fields('REAKSI'));
		$this->BUDAYA->setDbValue($rs->fields('BUDAYA'));
		$this->POLA_AKTIVITAS->setDbValue($rs->fields('POLA_AKTIVITAS'));
		$this->POLA_ISTIRAHAT->setDbValue($rs->fields('POLA_ISTIRAHAT'));
		$this->POLA_MAKAN->setDbValue($rs->fields('POLA_MAKAN'));
		$this->PANTANGAN->setDbValue($rs->fields('PANTANGAN'));
		$this->KEPERCAYAAN->setDbValue($rs->fields('KEPERCAYAAN'));
		$this->PANTANGAN_HARI->setDbValue($rs->fields('PANTANGAN_HARI'));
		$this->PANTANGAN_LAIN->setDbValue($rs->fields('PANTANGAN_LAIN'));
		$this->ANJURAN->setDbValue($rs->fields('ANJURAN'));
		$this->NILAI_KEYAKINAN->setDbValue($rs->fields('NILAI_KEYAKINAN'));
		$this->KEGIATAN_IBADAH->setDbValue($rs->fields('KEGIATAN_IBADAH'));
		$this->PENG_AGAMA->setDbValue($rs->fields('PENG_AGAMA'));
		$this->SPIRIT->setDbValue($rs->fields('SPIRIT'));
		$this->BANTUAN->setDbValue($rs->fields('BANTUAN'));
		$this->PAHAM_PENYAKIT->setDbValue($rs->fields('PAHAM_PENYAKIT'));
		$this->PAHAM_OBAT->setDbValue($rs->fields('PAHAM_OBAT'));
		$this->PAHAM_NUTRISI->setDbValue($rs->fields('PAHAM_NUTRISI'));
		$this->PAHAM_RAWAT->setDbValue($rs->fields('PAHAM_RAWAT'));
		$this->HAMBATAN_EDUKASI->setDbValue($rs->fields('HAMBATAN_EDUKASI'));
		$this->FREK_MAKAN->setDbValue($rs->fields('FREK_MAKAN'));
		$this->JUM_MAKAN->setDbValue($rs->fields('JUM_MAKAN'));
		$this->JEN_MAKAN->setDbValue($rs->fields('JEN_MAKAN'));
		$this->KOM_MAKAN->setDbValue($rs->fields('KOM_MAKAN'));
		$this->DIET->setDbValue($rs->fields('DIET'));
		$this->CARA_MAKAN->setDbValue($rs->fields('CARA_MAKAN'));
		$this->GANGGUAN->setDbValue($rs->fields('GANGGUAN'));
		$this->FREK_MINUM->setDbValue($rs->fields('FREK_MINUM'));
		$this->JUM_MINUM->setDbValue($rs->fields('JUM_MINUM'));
		$this->JEN_MINUM->setDbValue($rs->fields('JEN_MINUM'));
		$this->GANG_MINUM->setDbValue($rs->fields('GANG_MINUM'));
		$this->FREK_BAK->setDbValue($rs->fields('FREK_BAK'));
		$this->WARNA_BAK->setDbValue($rs->fields('WARNA_BAK'));
		$this->JMLH_BAK->setDbValue($rs->fields('JMLH_BAK'));
		$this->PENG_KAT_BAK->setDbValue($rs->fields('PENG_KAT_BAK'));
		$this->KEM_HAN_BAK->setDbValue($rs->fields('KEM_HAN_BAK'));
		$this->INKONT_BAK->setDbValue($rs->fields('INKONT_BAK'));
		$this->DIURESIS_BAK->setDbValue($rs->fields('DIURESIS_BAK'));
		$this->FREK_BAB->setDbValue($rs->fields('FREK_BAB'));
		$this->WARNA_BAB->setDbValue($rs->fields('WARNA_BAB'));
		$this->KONSIST_BAB->setDbValue($rs->fields('KONSIST_BAB'));
		$this->GANG_BAB->setDbValue($rs->fields('GANG_BAB'));
		$this->STOMA_BAB->setDbValue($rs->fields('STOMA_BAB'));
		$this->PENG_OBAT_BAB->setDbValue($rs->fields('PENG_OBAT_BAB'));
		$this->IST_SIANG->setDbValue($rs->fields('IST_SIANG'));
		$this->IST_MALAM->setDbValue($rs->fields('IST_MALAM'));
		$this->IST_CAHAYA->setDbValue($rs->fields('IST_CAHAYA'));
		$this->IST_POSISI->setDbValue($rs->fields('IST_POSISI'));
		$this->IST_LING->setDbValue($rs->fields('IST_LING'));
		$this->IST_GANG_TIDUR->setDbValue($rs->fields('IST_GANG_TIDUR'));
		$this->PENG_OBAT_IST->setDbValue($rs->fields('PENG_OBAT_IST'));
		$this->FREK_MAND->setDbValue($rs->fields('FREK_MAND'));
		$this->CUC_RAMB_MAND->setDbValue($rs->fields('CUC_RAMB_MAND'));
		$this->SIH_GIGI_MAND->setDbValue($rs->fields('SIH_GIGI_MAND'));
		$this->BANT_MAND->setDbValue($rs->fields('BANT_MAND'));
		$this->GANT_PAKAI->setDbValue($rs->fields('GANT_PAKAI'));
		$this->PAK_CUCI->setDbValue($rs->fields('PAK_CUCI'));
		$this->PAK_BANT->setDbValue($rs->fields('PAK_BANT'));
		$this->ALT_BANT->setDbValue($rs->fields('ALT_BANT'));
		$this->KEMP_MUND->setDbValue($rs->fields('KEMP_MUND'));
		$this->BIL_PUT->setDbValue($rs->fields('BIL_PUT'));
		$this->ADAPTIF->setDbValue($rs->fields('ADAPTIF'));
		$this->MALADAPTIF->setDbValue($rs->fields('MALADAPTIF'));
		$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields('PENANGGUNGJAWAB_NAMA'));
		$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields('PENANGGUNGJAWAB_HUBUNGAN'));
		$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields('PENANGGUNGJAWAB_ALAMAT'));
		$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields('PENANGGUNGJAWAB_PHONE'));
		$this->obat2->setDbValue($rs->fields('obat2'));
		$this->PERBANDINGAN_BB->setDbValue($rs->fields('PERBANDINGAN_BB'));
		$this->KONTINENSIA->setDbValue($rs->fields('KONTINENSIA'));
		$this->JENIS_KULIT1->setDbValue($rs->fields('JENIS_KULIT1'));
		$this->MOBILITAS->setDbValue($rs->fields('MOBILITAS'));
		$this->JK->setDbValue($rs->fields('JK'));
		$this->UMUR->setDbValue($rs->fields('UMUR'));
		$this->NAFSU_MAKAN->setDbValue($rs->fields('NAFSU_MAKAN'));
		$this->OBAT1->setDbValue($rs->fields('OBAT1'));
		$this->MALNUTRISI->setDbValue($rs->fields('MALNUTRISI'));
		$this->MOTORIK1->setDbValue($rs->fields('MOTORIK1'));
		$this->SPINAL->setDbValue($rs->fields('SPINAL'));
		$this->MEJA_OPERASI->setDbValue($rs->fields('MEJA_OPERASI'));
		$this->RIWAYAT_JATUH->setDbValue($rs->fields('RIWAYAT_JATUH'));
		$this->DIAGNOSIS_SEKUNDER->setDbValue($rs->fields('DIAGNOSIS_SEKUNDER'));
		$this->ALAT_BANTU->setDbValue($rs->fields('ALAT_BANTU'));
		$this->HEPARIN->setDbValue($rs->fields('HEPARIN'));
		$this->GAYA_BERJALAN->setDbValue($rs->fields('GAYA_BERJALAN'));
		$this->KESADARAN1->setDbValue($rs->fields('KESADARAN1'));
		$this->NOMR_LAMA->setDbValue($rs->fields('NOMR_LAMA'));
		$this->NO_KARTU->setDbValue($rs->fields('NO_KARTU'));
		$this->JNS_PASIEN->setDbValue($rs->fields('JNS_PASIEN'));
		$this->nama_ayah->setDbValue($rs->fields('nama_ayah'));
		$this->nama_ibu->setDbValue($rs->fields('nama_ibu'));
		$this->nama_suami->setDbValue($rs->fields('nama_suami'));
		$this->nama_istri->setDbValue($rs->fields('nama_istri'));
		$this->KD_ETNIS->setDbValue($rs->fields('KD_ETNIS'));
		$this->KD_BHS_HARIAN->setDbValue($rs->fields('KD_BHS_HARIAN'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->TITLE->DbValue = $row['TITLE'];
		$this->NAMA->DbValue = $row['NAMA'];
		$this->IBUKANDUNG->DbValue = $row['IBUKANDUNG'];
		$this->TEMPAT->DbValue = $row['TEMPAT'];
		$this->TGLLAHIR->DbValue = $row['TGLLAHIR'];
		$this->JENISKELAMIN->DbValue = $row['JENISKELAMIN'];
		$this->ALAMAT->DbValue = $row['ALAMAT'];
		$this->KDPROVINSI->DbValue = $row['KDPROVINSI'];
		$this->KOTA->DbValue = $row['KOTA'];
		$this->KDKECAMATAN->DbValue = $row['KDKECAMATAN'];
		$this->KELURAHAN->DbValue = $row['KELURAHAN'];
		$this->NOTELP->DbValue = $row['NOTELP'];
		$this->NOKTP->DbValue = $row['NOKTP'];
		$this->SUAMI_ORTU->DbValue = $row['SUAMI_ORTU'];
		$this->PEKERJAAN->DbValue = $row['PEKERJAAN'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->AGAMA->DbValue = $row['AGAMA'];
		$this->PENDIDIKAN->DbValue = $row['PENDIDIKAN'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NIP->DbValue = $row['NIP'];
		$this->TGLDAFTAR->DbValue = $row['TGLDAFTAR'];
		$this->ALAMAT_KTP->DbValue = $row['ALAMAT_KTP'];
		$this->PARENT_NOMR->DbValue = $row['PARENT_NOMR'];
		$this->NAMA_OBAT->DbValue = $row['NAMA_OBAT'];
		$this->DOSIS->DbValue = $row['DOSIS'];
		$this->CARA_PEMBERIAN->DbValue = $row['CARA_PEMBERIAN'];
		$this->FREKUENSI->DbValue = $row['FREKUENSI'];
		$this->WAKTU_TGL->DbValue = $row['WAKTU_TGL'];
		$this->LAMA_WAKTU->DbValue = $row['LAMA_WAKTU'];
		$this->ALERGI_OBAT->DbValue = $row['ALERGI_OBAT'];
		$this->REAKSI_ALERGI->DbValue = $row['REAKSI_ALERGI'];
		$this->RIWAYAT_KES->DbValue = $row['RIWAYAT_KES'];
		$this->BB_LAHIR->DbValue = $row['BB_LAHIR'];
		$this->BB_SEKARANG->DbValue = $row['BB_SEKARANG'];
		$this->FISIK_FONTANEL->DbValue = $row['FISIK_FONTANEL'];
		$this->FISIK_REFLEKS->DbValue = $row['FISIK_REFLEKS'];
		$this->FISIK_SENSASI->DbValue = $row['FISIK_SENSASI'];
		$this->MOTORIK_KASAR->DbValue = $row['MOTORIK_KASAR'];
		$this->MOTORIK_HALUS->DbValue = $row['MOTORIK_HALUS'];
		$this->MAMPU_BICARA->DbValue = $row['MAMPU_BICARA'];
		$this->MAMPU_SOSIALISASI->DbValue = $row['MAMPU_SOSIALISASI'];
		$this->BCG->DbValue = $row['BCG'];
		$this->POLIO->DbValue = $row['POLIO'];
		$this->DPT->DbValue = $row['DPT'];
		$this->CAMPAK->DbValue = $row['CAMPAK'];
		$this->HEPATITIS_B->DbValue = $row['HEPATITIS_B'];
		$this->TD->DbValue = $row['TD'];
		$this->SUHU->DbValue = $row['SUHU'];
		$this->RR->DbValue = $row['RR'];
		$this->NADI->DbValue = $row['NADI'];
		$this->BB->DbValue = $row['BB'];
		$this->TB->DbValue = $row['TB'];
		$this->EYE->DbValue = $row['EYE'];
		$this->MOTORIK->DbValue = $row['MOTORIK'];
		$this->VERBAL->DbValue = $row['VERBAL'];
		$this->TOTAL_GCS->DbValue = $row['TOTAL_GCS'];
		$this->REAKSI_PUPIL->DbValue = $row['REAKSI_PUPIL'];
		$this->KESADARAN->DbValue = $row['KESADARAN'];
		$this->KEPALA->DbValue = $row['KEPALA'];
		$this->RAMBUT->DbValue = $row['RAMBUT'];
		$this->MUKA->DbValue = $row['MUKA'];
		$this->MATA->DbValue = $row['MATA'];
		$this->GANG_LIHAT->DbValue = $row['GANG_LIHAT'];
		$this->ALATBANTU_LIHAT->DbValue = $row['ALATBANTU_LIHAT'];
		$this->BENTUK->DbValue = $row['BENTUK'];
		$this->PENDENGARAN->DbValue = $row['PENDENGARAN'];
		$this->LUB_TELINGA->DbValue = $row['LUB_TELINGA'];
		$this->BENTUK_HIDUNG->DbValue = $row['BENTUK_HIDUNG'];
		$this->MEMBRAN_MUK->DbValue = $row['MEMBRAN_MUK'];
		$this->MAMPU_HIDU->DbValue = $row['MAMPU_HIDU'];
		$this->ALAT_HIDUNG->DbValue = $row['ALAT_HIDUNG'];
		$this->RONGGA_MULUT->DbValue = $row['RONGGA_MULUT'];
		$this->WARNA_MEMBRAN->DbValue = $row['WARNA_MEMBRAN'];
		$this->LEMBAB->DbValue = $row['LEMBAB'];
		$this->STOMATITIS->DbValue = $row['STOMATITIS'];
		$this->LIDAH->DbValue = $row['LIDAH'];
		$this->GIGI->DbValue = $row['GIGI'];
		$this->TONSIL->DbValue = $row['TONSIL'];
		$this->KELAINAN->DbValue = $row['KELAINAN'];
		$this->PERGERAKAN->DbValue = $row['PERGERAKAN'];
		$this->KEL_TIROID->DbValue = $row['KEL_TIROID'];
		$this->KEL_GETAH->DbValue = $row['KEL_GETAH'];
		$this->TEKANAN_VENA->DbValue = $row['TEKANAN_VENA'];
		$this->REF_MENELAN->DbValue = $row['REF_MENELAN'];
		$this->NYERI->DbValue = $row['NYERI'];
		$this->KREPITASI->DbValue = $row['KREPITASI'];
		$this->KEL_LAIN->DbValue = $row['KEL_LAIN'];
		$this->BENTUK_DADA->DbValue = $row['BENTUK_DADA'];
		$this->POLA_NAPAS->DbValue = $row['POLA_NAPAS'];
		$this->BENTUK_THORAKS->DbValue = $row['BENTUK_THORAKS'];
		$this->PAL_KREP->DbValue = $row['PAL_KREP'];
		$this->BENJOLAN->DbValue = $row['BENJOLAN'];
		$this->PAL_NYERI->DbValue = $row['PAL_NYERI'];
		$this->PERKUSI->DbValue = $row['PERKUSI'];
		$this->PARU->DbValue = $row['PARU'];
		$this->JANTUNG->DbValue = $row['JANTUNG'];
		$this->SUARA_JANTUNG->DbValue = $row['SUARA_JANTUNG'];
		$this->ALATBANTU_JAN->DbValue = $row['ALATBANTU_JAN'];
		$this->BENTUK_ABDOMEN->DbValue = $row['BENTUK_ABDOMEN'];
		$this->AUSKULTASI->DbValue = $row['AUSKULTASI'];
		$this->NYERI_PASI->DbValue = $row['NYERI_PASI'];
		$this->PEM_KELENJAR->DbValue = $row['PEM_KELENJAR'];
		$this->PERKUSI_AUS->DbValue = $row['PERKUSI_AUS'];
		$this->VAGINA->DbValue = $row['VAGINA'];
		$this->MENSTRUASI->DbValue = $row['MENSTRUASI'];
		$this->KATETER->DbValue = $row['KATETER'];
		$this->LABIA_PROM->DbValue = $row['LABIA_PROM'];
		$this->HAMIL->DbValue = $row['HAMIL'];
		$this->TGL_HAID->DbValue = $row['TGL_HAID'];
		$this->PERIKSA_CERVIX->DbValue = $row['PERIKSA_CERVIX'];
		$this->BENTUK_PAYUDARA->DbValue = $row['BENTUK_PAYUDARA'];
		$this->KENYAL->DbValue = $row['KENYAL'];
		$this->MASSA->DbValue = $row['MASSA'];
		$this->NYERI_RABA->DbValue = $row['NYERI_RABA'];
		$this->BENTUK_PUTING->DbValue = $row['BENTUK_PUTING'];
		$this->MAMMO->DbValue = $row['MAMMO'];
		$this->ALAT_KONTRASEPSI->DbValue = $row['ALAT_KONTRASEPSI'];
		$this->MASALAH_SEKS->DbValue = $row['MASALAH_SEKS'];
		$this->PREPUTIUM->DbValue = $row['PREPUTIUM'];
		$this->MASALAH_PROSTAT->DbValue = $row['MASALAH_PROSTAT'];
		$this->BENTUK_SKROTUM->DbValue = $row['BENTUK_SKROTUM'];
		$this->TESTIS->DbValue = $row['TESTIS'];
		$this->MASSA_BEN->DbValue = $row['MASSA_BEN'];
		$this->HERNIASI->DbValue = $row['HERNIASI'];
		$this->LAIN2->DbValue = $row['LAIN2'];
		$this->ALAT_KONTRA->DbValue = $row['ALAT_KONTRA'];
		$this->MASALAH_REPRO->DbValue = $row['MASALAH_REPRO'];
		$this->EKSTREMITAS_ATAS->DbValue = $row['EKSTREMITAS_ATAS'];
		$this->EKSTREMITAS_BAWAH->DbValue = $row['EKSTREMITAS_BAWAH'];
		$this->AKTIVITAS->DbValue = $row['AKTIVITAS'];
		$this->BERJALAN->DbValue = $row['BERJALAN'];
		$this->SISTEM_INTE->DbValue = $row['SISTEM_INTE'];
		$this->KENYAMANAN->DbValue = $row['KENYAMANAN'];
		$this->KES_DIRI->DbValue = $row['KES_DIRI'];
		$this->SOS_SUPORT->DbValue = $row['SOS_SUPORT'];
		$this->ANSIETAS->DbValue = $row['ANSIETAS'];
		$this->KEHILANGAN->DbValue = $row['KEHILANGAN'];
		$this->STATUS_EMOSI->DbValue = $row['STATUS_EMOSI'];
		$this->KONSEP_DIRI->DbValue = $row['KONSEP_DIRI'];
		$this->RESPON_HILANG->DbValue = $row['RESPON_HILANG'];
		$this->SUMBER_STRESS->DbValue = $row['SUMBER_STRESS'];
		$this->BERARTI->DbValue = $row['BERARTI'];
		$this->TERLIBAT->DbValue = $row['TERLIBAT'];
		$this->HUBUNGAN->DbValue = $row['HUBUNGAN'];
		$this->KOMUNIKASI->DbValue = $row['KOMUNIKASI'];
		$this->KEPUTUSAN->DbValue = $row['KEPUTUSAN'];
		$this->MENGASUH->DbValue = $row['MENGASUH'];
		$this->DUKUNGAN->DbValue = $row['DUKUNGAN'];
		$this->REAKSI->DbValue = $row['REAKSI'];
		$this->BUDAYA->DbValue = $row['BUDAYA'];
		$this->POLA_AKTIVITAS->DbValue = $row['POLA_AKTIVITAS'];
		$this->POLA_ISTIRAHAT->DbValue = $row['POLA_ISTIRAHAT'];
		$this->POLA_MAKAN->DbValue = $row['POLA_MAKAN'];
		$this->PANTANGAN->DbValue = $row['PANTANGAN'];
		$this->KEPERCAYAAN->DbValue = $row['KEPERCAYAAN'];
		$this->PANTANGAN_HARI->DbValue = $row['PANTANGAN_HARI'];
		$this->PANTANGAN_LAIN->DbValue = $row['PANTANGAN_LAIN'];
		$this->ANJURAN->DbValue = $row['ANJURAN'];
		$this->NILAI_KEYAKINAN->DbValue = $row['NILAI_KEYAKINAN'];
		$this->KEGIATAN_IBADAH->DbValue = $row['KEGIATAN_IBADAH'];
		$this->PENG_AGAMA->DbValue = $row['PENG_AGAMA'];
		$this->SPIRIT->DbValue = $row['SPIRIT'];
		$this->BANTUAN->DbValue = $row['BANTUAN'];
		$this->PAHAM_PENYAKIT->DbValue = $row['PAHAM_PENYAKIT'];
		$this->PAHAM_OBAT->DbValue = $row['PAHAM_OBAT'];
		$this->PAHAM_NUTRISI->DbValue = $row['PAHAM_NUTRISI'];
		$this->PAHAM_RAWAT->DbValue = $row['PAHAM_RAWAT'];
		$this->HAMBATAN_EDUKASI->DbValue = $row['HAMBATAN_EDUKASI'];
		$this->FREK_MAKAN->DbValue = $row['FREK_MAKAN'];
		$this->JUM_MAKAN->DbValue = $row['JUM_MAKAN'];
		$this->JEN_MAKAN->DbValue = $row['JEN_MAKAN'];
		$this->KOM_MAKAN->DbValue = $row['KOM_MAKAN'];
		$this->DIET->DbValue = $row['DIET'];
		$this->CARA_MAKAN->DbValue = $row['CARA_MAKAN'];
		$this->GANGGUAN->DbValue = $row['GANGGUAN'];
		$this->FREK_MINUM->DbValue = $row['FREK_MINUM'];
		$this->JUM_MINUM->DbValue = $row['JUM_MINUM'];
		$this->JEN_MINUM->DbValue = $row['JEN_MINUM'];
		$this->GANG_MINUM->DbValue = $row['GANG_MINUM'];
		$this->FREK_BAK->DbValue = $row['FREK_BAK'];
		$this->WARNA_BAK->DbValue = $row['WARNA_BAK'];
		$this->JMLH_BAK->DbValue = $row['JMLH_BAK'];
		$this->PENG_KAT_BAK->DbValue = $row['PENG_KAT_BAK'];
		$this->KEM_HAN_BAK->DbValue = $row['KEM_HAN_BAK'];
		$this->INKONT_BAK->DbValue = $row['INKONT_BAK'];
		$this->DIURESIS_BAK->DbValue = $row['DIURESIS_BAK'];
		$this->FREK_BAB->DbValue = $row['FREK_BAB'];
		$this->WARNA_BAB->DbValue = $row['WARNA_BAB'];
		$this->KONSIST_BAB->DbValue = $row['KONSIST_BAB'];
		$this->GANG_BAB->DbValue = $row['GANG_BAB'];
		$this->STOMA_BAB->DbValue = $row['STOMA_BAB'];
		$this->PENG_OBAT_BAB->DbValue = $row['PENG_OBAT_BAB'];
		$this->IST_SIANG->DbValue = $row['IST_SIANG'];
		$this->IST_MALAM->DbValue = $row['IST_MALAM'];
		$this->IST_CAHAYA->DbValue = $row['IST_CAHAYA'];
		$this->IST_POSISI->DbValue = $row['IST_POSISI'];
		$this->IST_LING->DbValue = $row['IST_LING'];
		$this->IST_GANG_TIDUR->DbValue = $row['IST_GANG_TIDUR'];
		$this->PENG_OBAT_IST->DbValue = $row['PENG_OBAT_IST'];
		$this->FREK_MAND->DbValue = $row['FREK_MAND'];
		$this->CUC_RAMB_MAND->DbValue = $row['CUC_RAMB_MAND'];
		$this->SIH_GIGI_MAND->DbValue = $row['SIH_GIGI_MAND'];
		$this->BANT_MAND->DbValue = $row['BANT_MAND'];
		$this->GANT_PAKAI->DbValue = $row['GANT_PAKAI'];
		$this->PAK_CUCI->DbValue = $row['PAK_CUCI'];
		$this->PAK_BANT->DbValue = $row['PAK_BANT'];
		$this->ALT_BANT->DbValue = $row['ALT_BANT'];
		$this->KEMP_MUND->DbValue = $row['KEMP_MUND'];
		$this->BIL_PUT->DbValue = $row['BIL_PUT'];
		$this->ADAPTIF->DbValue = $row['ADAPTIF'];
		$this->MALADAPTIF->DbValue = $row['MALADAPTIF'];
		$this->PENANGGUNGJAWAB_NAMA->DbValue = $row['PENANGGUNGJAWAB_NAMA'];
		$this->PENANGGUNGJAWAB_HUBUNGAN->DbValue = $row['PENANGGUNGJAWAB_HUBUNGAN'];
		$this->PENANGGUNGJAWAB_ALAMAT->DbValue = $row['PENANGGUNGJAWAB_ALAMAT'];
		$this->PENANGGUNGJAWAB_PHONE->DbValue = $row['PENANGGUNGJAWAB_PHONE'];
		$this->obat2->DbValue = $row['obat2'];
		$this->PERBANDINGAN_BB->DbValue = $row['PERBANDINGAN_BB'];
		$this->KONTINENSIA->DbValue = $row['KONTINENSIA'];
		$this->JENIS_KULIT1->DbValue = $row['JENIS_KULIT1'];
		$this->MOBILITAS->DbValue = $row['MOBILITAS'];
		$this->JK->DbValue = $row['JK'];
		$this->UMUR->DbValue = $row['UMUR'];
		$this->NAFSU_MAKAN->DbValue = $row['NAFSU_MAKAN'];
		$this->OBAT1->DbValue = $row['OBAT1'];
		$this->MALNUTRISI->DbValue = $row['MALNUTRISI'];
		$this->MOTORIK1->DbValue = $row['MOTORIK1'];
		$this->SPINAL->DbValue = $row['SPINAL'];
		$this->MEJA_OPERASI->DbValue = $row['MEJA_OPERASI'];
		$this->RIWAYAT_JATUH->DbValue = $row['RIWAYAT_JATUH'];
		$this->DIAGNOSIS_SEKUNDER->DbValue = $row['DIAGNOSIS_SEKUNDER'];
		$this->ALAT_BANTU->DbValue = $row['ALAT_BANTU'];
		$this->HEPARIN->DbValue = $row['HEPARIN'];
		$this->GAYA_BERJALAN->DbValue = $row['GAYA_BERJALAN'];
		$this->KESADARAN1->DbValue = $row['KESADARAN1'];
		$this->NOMR_LAMA->DbValue = $row['NOMR_LAMA'];
		$this->NO_KARTU->DbValue = $row['NO_KARTU'];
		$this->JNS_PASIEN->DbValue = $row['JNS_PASIEN'];
		$this->nama_ayah->DbValue = $row['nama_ayah'];
		$this->nama_ibu->DbValue = $row['nama_ibu'];
		$this->nama_suami->DbValue = $row['nama_suami'];
		$this->nama_istri->DbValue = $row['nama_istri'];
		$this->KD_ETNIS->DbValue = $row['KD_ETNIS'];
		$this->KD_BHS_HARIAN->DbValue = $row['KD_BHS_HARIAN'];
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
		// NOMR
		// TITLE
		// NAMA
		// IBUKANDUNG
		// TEMPAT
		// TGLLAHIR
		// JENISKELAMIN
		// ALAMAT
		// KDPROVINSI
		// KOTA
		// KDKECAMATAN
		// KELURAHAN
		// NOTELP
		// NOKTP
		// SUAMI_ORTU
		// PEKERJAAN
		// STATUS
		// AGAMA
		// PENDIDIKAN
		// KDCARABAYAR
		// NIP
		// TGLDAFTAR
		// ALAMAT_KTP
		// PARENT_NOMR
		// NAMA_OBAT
		// DOSIS
		// CARA_PEMBERIAN
		// FREKUENSI
		// WAKTU_TGL
		// LAMA_WAKTU
		// ALERGI_OBAT
		// REAKSI_ALERGI
		// RIWAYAT_KES
		// BB_LAHIR
		// BB_SEKARANG
		// FISIK_FONTANEL
		// FISIK_REFLEKS
		// FISIK_SENSASI
		// MOTORIK_KASAR
		// MOTORIK_HALUS
		// MAMPU_BICARA
		// MAMPU_SOSIALISASI
		// BCG
		// POLIO
		// DPT
		// CAMPAK
		// HEPATITIS_B
		// TD
		// SUHU
		// RR
		// NADI
		// BB
		// TB
		// EYE
		// MOTORIK
		// VERBAL
		// TOTAL_GCS
		// REAKSI_PUPIL
		// KESADARAN
		// KEPALA
		// RAMBUT
		// MUKA
		// MATA
		// GANG_LIHAT
		// ALATBANTU_LIHAT
		// BENTUK
		// PENDENGARAN
		// LUB_TELINGA
		// BENTUK_HIDUNG
		// MEMBRAN_MUK
		// MAMPU_HIDU
		// ALAT_HIDUNG
		// RONGGA_MULUT
		// WARNA_MEMBRAN
		// LEMBAB
		// STOMATITIS
		// LIDAH
		// GIGI
		// TONSIL
		// KELAINAN
		// PERGERAKAN
		// KEL_TIROID
		// KEL_GETAH
		// TEKANAN_VENA
		// REF_MENELAN
		// NYERI
		// KREPITASI
		// KEL_LAIN
		// BENTUK_DADA
		// POLA_NAPAS
		// BENTUK_THORAKS
		// PAL_KREP
		// BENJOLAN
		// PAL_NYERI
		// PERKUSI
		// PARU
		// JANTUNG
		// SUARA_JANTUNG
		// ALATBANTU_JAN
		// BENTUK_ABDOMEN
		// AUSKULTASI
		// NYERI_PASI
		// PEM_KELENJAR
		// PERKUSI_AUS
		// VAGINA
		// MENSTRUASI
		// KATETER
		// LABIA_PROM
		// HAMIL
		// TGL_HAID
		// PERIKSA_CERVIX
		// BENTUK_PAYUDARA
		// KENYAL
		// MASSA
		// NYERI_RABA
		// BENTUK_PUTING
		// MAMMO
		// ALAT_KONTRASEPSI
		// MASALAH_SEKS
		// PREPUTIUM
		// MASALAH_PROSTAT
		// BENTUK_SKROTUM
		// TESTIS
		// MASSA_BEN
		// HERNIASI
		// LAIN2
		// ALAT_KONTRA
		// MASALAH_REPRO
		// EKSTREMITAS_ATAS
		// EKSTREMITAS_BAWAH
		// AKTIVITAS
		// BERJALAN
		// SISTEM_INTE
		// KENYAMANAN
		// KES_DIRI
		// SOS_SUPORT
		// ANSIETAS
		// KEHILANGAN
		// STATUS_EMOSI
		// KONSEP_DIRI
		// RESPON_HILANG
		// SUMBER_STRESS
		// BERARTI
		// TERLIBAT
		// HUBUNGAN
		// KOMUNIKASI
		// KEPUTUSAN
		// MENGASUH
		// DUKUNGAN
		// REAKSI
		// BUDAYA
		// POLA_AKTIVITAS
		// POLA_ISTIRAHAT
		// POLA_MAKAN
		// PANTANGAN
		// KEPERCAYAAN
		// PANTANGAN_HARI
		// PANTANGAN_LAIN
		// ANJURAN
		// NILAI_KEYAKINAN
		// KEGIATAN_IBADAH
		// PENG_AGAMA
		// SPIRIT
		// BANTUAN
		// PAHAM_PENYAKIT
		// PAHAM_OBAT
		// PAHAM_NUTRISI
		// PAHAM_RAWAT
		// HAMBATAN_EDUKASI
		// FREK_MAKAN
		// JUM_MAKAN
		// JEN_MAKAN
		// KOM_MAKAN
		// DIET
		// CARA_MAKAN
		// GANGGUAN
		// FREK_MINUM
		// JUM_MINUM
		// JEN_MINUM
		// GANG_MINUM
		// FREK_BAK
		// WARNA_BAK
		// JMLH_BAK
		// PENG_KAT_BAK
		// KEM_HAN_BAK
		// INKONT_BAK
		// DIURESIS_BAK
		// FREK_BAB
		// WARNA_BAB
		// KONSIST_BAB
		// GANG_BAB
		// STOMA_BAB
		// PENG_OBAT_BAB
		// IST_SIANG
		// IST_MALAM
		// IST_CAHAYA
		// IST_POSISI
		// IST_LING
		// IST_GANG_TIDUR
		// PENG_OBAT_IST
		// FREK_MAND
		// CUC_RAMB_MAND
		// SIH_GIGI_MAND
		// BANT_MAND
		// GANT_PAKAI
		// PAK_CUCI
		// PAK_BANT
		// ALT_BANT
		// KEMP_MUND
		// BIL_PUT
		// ADAPTIF
		// MALADAPTIF
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// obat2
		// PERBANDINGAN_BB
		// KONTINENSIA
		// JENIS_KULIT1
		// MOBILITAS
		// JK
		// UMUR
		// NAFSU_MAKAN
		// OBAT1
		// MALNUTRISI
		// MOTORIK1
		// SPINAL
		// MEJA_OPERASI
		// RIWAYAT_JATUH
		// DIAGNOSIS_SEKUNDER
		// ALAT_BANTU
		// HEPARIN
		// GAYA_BERJALAN
		// KESADARAN1
		// NOMR_LAMA
		// NO_KARTU
		// JNS_PASIEN
		// nama_ayah
		// nama_ibu
		// nama_suami
		// nama_istri
		// KD_ETNIS
		// KD_BHS_HARIAN

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// TITLE
		if (strval($this->TITLE->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->TITLE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
		$sWhereWrk = "";
		$this->TITLE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->TITLE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->TITLE->ViewValue = $this->TITLE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->TITLE->ViewValue = $this->TITLE->CurrentValue;
			}
		} else {
			$this->TITLE->ViewValue = NULL;
		}
		$this->TITLE->ViewCustomAttributes = "";

		// NAMA
		$this->NAMA->ViewValue = $this->NAMA->CurrentValue;
		$this->NAMA->ViewCustomAttributes = "";

		// TEMPAT
		$this->TEMPAT->ViewValue = $this->TEMPAT->CurrentValue;
		$this->TEMPAT->ViewCustomAttributes = "";

		// TGLLAHIR
		$this->TGLLAHIR->ViewValue = $this->TGLLAHIR->CurrentValue;
		$this->TGLLAHIR->ViewValue = ew_FormatDateTime($this->TGLLAHIR->ViewValue, 7);
		$this->TGLLAHIR->ViewCustomAttributes = "";

		// JENISKELAMIN
		if (strval($this->JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->JENISKELAMIN->ViewValue = NULL;
		}
		$this->JENISKELAMIN->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// KDPROVINSI
		if (strval($this->KDPROVINSI->CurrentValue) <> "") {
			$sFilterWrk = "`idprovinsi`" . ew_SearchString("=", $this->KDPROVINSI->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idprovinsi`, `namaprovinsi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_provinsi`";
		$sWhereWrk = "";
		$this->KDPROVINSI->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDPROVINSI, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDPROVINSI->ViewValue = $this->KDPROVINSI->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDPROVINSI->ViewValue = $this->KDPROVINSI->CurrentValue;
			}
		} else {
			$this->KDPROVINSI->ViewValue = NULL;
		}
		$this->KDPROVINSI->ViewCustomAttributes = "";

		// KOTA
		if (strval($this->KOTA->CurrentValue) <> "") {
			$sFilterWrk = "`idkota`" . ew_SearchString("=", $this->KOTA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkota`, `namakota` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kota`";
		$sWhereWrk = "";
		$this->KOTA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KOTA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KOTA->ViewValue = $this->KOTA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KOTA->ViewValue = $this->KOTA->CurrentValue;
			}
		} else {
			$this->KOTA->ViewValue = NULL;
		}
		$this->KOTA->ViewCustomAttributes = "";

		// KDKECAMATAN
		if (strval($this->KDKECAMATAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkecamatan`" . ew_SearchString("=", $this->KDKECAMATAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkecamatan`, `namakecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kecamatan`";
		$sWhereWrk = "";
		$this->KDKECAMATAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDKECAMATAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDKECAMATAN->ViewValue = $this->KDKECAMATAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDKECAMATAN->ViewValue = $this->KDKECAMATAN->CurrentValue;
			}
		} else {
			$this->KDKECAMATAN->ViewValue = NULL;
		}
		$this->KDKECAMATAN->ViewCustomAttributes = "";

		// KELURAHAN
		if (strval($this->KELURAHAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkelurahan`" . ew_SearchString("=", $this->KELURAHAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkelurahan`, `namakelurahan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kelurahan`";
		$sWhereWrk = "";
		$this->KELURAHAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KELURAHAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KELURAHAN->ViewValue = $this->KELURAHAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KELURAHAN->ViewValue = $this->KELURAHAN->CurrentValue;
			}
		} else {
			$this->KELURAHAN->ViewValue = NULL;
		}
		$this->KELURAHAN->ViewCustomAttributes = "";

		// NOTELP
		$this->NOTELP->ViewValue = $this->NOTELP->CurrentValue;
		$this->NOTELP->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// PEKERJAAN
		$this->PEKERJAAN->ViewValue = $this->PEKERJAAN->CurrentValue;
		$this->PEKERJAAN->ViewCustomAttributes = "";

		// STATUS
		if (strval($this->STATUS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->STATUS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `statusperkawinan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_statusperkawin`";
		$sWhereWrk = "";
		$this->STATUS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->STATUS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->STATUS->ViewValue = $this->STATUS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
			}
		} else {
			$this->STATUS->ViewValue = NULL;
		}
		$this->STATUS->ViewCustomAttributes = "";

		// AGAMA
		if (strval($this->AGAMA->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
		$sWhereWrk = "";
		$this->AGAMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->AGAMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->AGAMA->ViewValue = $this->AGAMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->AGAMA->ViewValue = $this->AGAMA->CurrentValue;
			}
		} else {
			$this->AGAMA->ViewValue = NULL;
		}
		$this->AGAMA->ViewCustomAttributes = "";

		// PENDIDIKAN
		if (strval($this->PENDIDIKAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
		$sWhereWrk = "";
		$this->PENDIDIKAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PENDIDIKAN->ViewValue = $this->PENDIDIKAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PENDIDIKAN->ViewValue = $this->PENDIDIKAN->CurrentValue;
			}
		} else {
			$this->PENDIDIKAN->ViewValue = NULL;
		}
		$this->PENDIDIKAN->ViewCustomAttributes = "";

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

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// TGLDAFTAR
		$this->TGLDAFTAR->ViewValue = $this->TGLDAFTAR->CurrentValue;
		$this->TGLDAFTAR->ViewValue = ew_FormatDateTime($this->TGLDAFTAR->ViewValue, 7);
		$this->TGLDAFTAR->ViewCustomAttributes = "";

		// ALAMAT_KTP
		$this->ALAMAT_KTP->ViewValue = $this->ALAMAT_KTP->CurrentValue;
		$this->ALAMAT_KTP->ViewCustomAttributes = "";

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

		// NO_KARTU
		$this->NO_KARTU->ViewValue = $this->NO_KARTU->CurrentValue;
		$this->NO_KARTU->ViewCustomAttributes = "";

		// JNS_PASIEN
		if (strval($this->JNS_PASIEN->CurrentValue) <> "") {
			$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
		$sWhereWrk = "";
		$this->JNS_PASIEN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JNS_PASIEN->ViewValue = $this->JNS_PASIEN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JNS_PASIEN->ViewValue = $this->JNS_PASIEN->CurrentValue;
			}
		} else {
			$this->JNS_PASIEN->ViewValue = NULL;
		}
		$this->JNS_PASIEN->ViewCustomAttributes = "";

		// nama_ayah
		$this->nama_ayah->ViewValue = $this->nama_ayah->CurrentValue;
		$this->nama_ayah->ViewCustomAttributes = "";

		// nama_ibu
		$this->nama_ibu->ViewValue = $this->nama_ibu->CurrentValue;
		$this->nama_ibu->ViewCustomAttributes = "";

		// nama_suami
		$this->nama_suami->ViewValue = $this->nama_suami->CurrentValue;
		$this->nama_suami->ViewCustomAttributes = "";

		// nama_istri
		$this->nama_istri->ViewValue = $this->nama_istri->CurrentValue;
		$this->nama_istri->ViewCustomAttributes = "";

		// KD_ETNIS
		if (strval($this->KD_ETNIS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
		$sWhereWrk = "";
		$this->KD_ETNIS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KD_ETNIS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KD_ETNIS->ViewValue = $this->KD_ETNIS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KD_ETNIS->ViewValue = $this->KD_ETNIS->CurrentValue;
			}
		} else {
			$this->KD_ETNIS->ViewValue = NULL;
		}
		$this->KD_ETNIS->ViewCustomAttributes = "";

		// KD_BHS_HARIAN
		if (strval($this->KD_BHS_HARIAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
		$sWhereWrk = "";
		$this->KD_BHS_HARIAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KD_BHS_HARIAN->ViewValue = $this->KD_BHS_HARIAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KD_BHS_HARIAN->ViewValue = $this->KD_BHS_HARIAN->CurrentValue;
			}
		} else {
			$this->KD_BHS_HARIAN->ViewValue = NULL;
		}
		$this->KD_BHS_HARIAN->ViewCustomAttributes = "";

			// TITLE
			$this->TITLE->LinkCustomAttributes = "";
			$this->TITLE->HrefValue = "";
			$this->TITLE->TooltipValue = "";

			// NAMA
			$this->NAMA->LinkCustomAttributes = "";
			$this->NAMA->HrefValue = "";
			$this->NAMA->TooltipValue = "";

			// TEMPAT
			$this->TEMPAT->LinkCustomAttributes = "";
			$this->TEMPAT->HrefValue = "";
			$this->TEMPAT->TooltipValue = "";

			// TGLLAHIR
			$this->TGLLAHIR->LinkCustomAttributes = "";
			$this->TGLLAHIR->HrefValue = "";
			$this->TGLLAHIR->TooltipValue = "";

			// JENISKELAMIN
			$this->JENISKELAMIN->LinkCustomAttributes = "";
			$this->JENISKELAMIN->HrefValue = "";
			$this->JENISKELAMIN->TooltipValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";
			$this->ALAMAT->TooltipValue = "";

			// KDPROVINSI
			$this->KDPROVINSI->LinkCustomAttributes = "";
			$this->KDPROVINSI->HrefValue = "";
			$this->KDPROVINSI->TooltipValue = "";

			// KOTA
			$this->KOTA->LinkCustomAttributes = "";
			$this->KOTA->HrefValue = "";
			$this->KOTA->TooltipValue = "";

			// KDKECAMATAN
			$this->KDKECAMATAN->LinkCustomAttributes = "";
			$this->KDKECAMATAN->HrefValue = "";
			$this->KDKECAMATAN->TooltipValue = "";

			// KELURAHAN
			$this->KELURAHAN->LinkCustomAttributes = "";
			$this->KELURAHAN->HrefValue = "";
			$this->KELURAHAN->TooltipValue = "";

			// NOTELP
			$this->NOTELP->LinkCustomAttributes = "";
			$this->NOTELP->HrefValue = "";
			$this->NOTELP->TooltipValue = "";

			// NOKTP
			$this->NOKTP->LinkCustomAttributes = "";
			$this->NOKTP->HrefValue = "";
			$this->NOKTP->TooltipValue = "";

			// PEKERJAAN
			$this->PEKERJAAN->LinkCustomAttributes = "";
			$this->PEKERJAAN->HrefValue = "";
			$this->PEKERJAAN->TooltipValue = "";

			// STATUS
			$this->STATUS->LinkCustomAttributes = "";
			$this->STATUS->HrefValue = "";
			$this->STATUS->TooltipValue = "";

			// AGAMA
			$this->AGAMA->LinkCustomAttributes = "";
			$this->AGAMA->HrefValue = "";
			$this->AGAMA->TooltipValue = "";

			// PENDIDIKAN
			$this->PENDIDIKAN->LinkCustomAttributes = "";
			$this->PENDIDIKAN->HrefValue = "";
			$this->PENDIDIKAN->TooltipValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";
			$this->KDCARABAYAR->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// TGLDAFTAR
			$this->TGLDAFTAR->LinkCustomAttributes = "";
			$this->TGLDAFTAR->HrefValue = "";
			$this->TGLDAFTAR->TooltipValue = "";

			// ALAMAT_KTP
			$this->ALAMAT_KTP->LinkCustomAttributes = "";
			$this->ALAMAT_KTP->HrefValue = "";
			$this->ALAMAT_KTP->TooltipValue = "";

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

			// NO_KARTU
			$this->NO_KARTU->LinkCustomAttributes = "";
			$this->NO_KARTU->HrefValue = "";
			$this->NO_KARTU->TooltipValue = "";

			// JNS_PASIEN
			$this->JNS_PASIEN->LinkCustomAttributes = "";
			$this->JNS_PASIEN->HrefValue = "";
			$this->JNS_PASIEN->TooltipValue = "";

			// nama_ayah
			$this->nama_ayah->LinkCustomAttributes = "";
			$this->nama_ayah->HrefValue = "";
			$this->nama_ayah->TooltipValue = "";

			// nama_ibu
			$this->nama_ibu->LinkCustomAttributes = "";
			$this->nama_ibu->HrefValue = "";
			$this->nama_ibu->TooltipValue = "";

			// nama_suami
			$this->nama_suami->LinkCustomAttributes = "";
			$this->nama_suami->HrefValue = "";
			$this->nama_suami->TooltipValue = "";

			// nama_istri
			$this->nama_istri->LinkCustomAttributes = "";
			$this->nama_istri->HrefValue = "";
			$this->nama_istri->TooltipValue = "";

			// KD_ETNIS
			$this->KD_ETNIS->LinkCustomAttributes = "";
			$this->KD_ETNIS->HrefValue = "";
			$this->KD_ETNIS->TooltipValue = "";

			// KD_BHS_HARIAN
			$this->KD_BHS_HARIAN->LinkCustomAttributes = "";
			$this->KD_BHS_HARIAN->HrefValue = "";
			$this->KD_BHS_HARIAN->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// TITLE
			$this->TITLE->EditAttrs["class"] = "form-control";
			$this->TITLE->EditCustomAttributes = "";
			if (trim(strval($this->TITLE->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->TITLE->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_titel`";
			$sWhereWrk = "";
			$this->TITLE->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->TITLE, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->TITLE->EditValue = $arwrk;

			// NAMA
			$this->NAMA->EditAttrs["class"] = "form-control";
			$this->NAMA->EditCustomAttributes = "";
			$this->NAMA->EditValue = ew_HtmlEncode($this->NAMA->CurrentValue);
			$this->NAMA->PlaceHolder = ew_RemoveHtml($this->NAMA->FldCaption());

			// TEMPAT
			$this->TEMPAT->EditAttrs["class"] = "form-control";
			$this->TEMPAT->EditCustomAttributes = "";
			$this->TEMPAT->EditValue = ew_HtmlEncode($this->TEMPAT->CurrentValue);
			$this->TEMPAT->PlaceHolder = ew_RemoveHtml($this->TEMPAT->FldCaption());

			// TGLLAHIR
			$this->TGLLAHIR->EditAttrs["class"] = "form-control";
			$this->TGLLAHIR->EditCustomAttributes = "";
			$this->TGLLAHIR->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TGLLAHIR->CurrentValue, 7));
			$this->TGLLAHIR->PlaceHolder = ew_RemoveHtml($this->TGLLAHIR->FldCaption());

			// JENISKELAMIN
			$this->JENISKELAMIN->EditCustomAttributes = "";
			if (trim(strval($this->JENISKELAMIN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jeniskelamin`";
			$sWhereWrk = "";
			$this->JENISKELAMIN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->JENISKELAMIN->EditValue = $arwrk;

			// ALAMAT
			$this->ALAMAT->EditAttrs["class"] = "form-control";
			$this->ALAMAT->EditCustomAttributes = "";
			$this->ALAMAT->EditValue = ew_HtmlEncode($this->ALAMAT->CurrentValue);
			$this->ALAMAT->PlaceHolder = ew_RemoveHtml($this->ALAMAT->FldCaption());

			// KDPROVINSI
			$this->KDPROVINSI->EditAttrs["class"] = "form-control";
			$this->KDPROVINSI->EditCustomAttributes = "";
			if (trim(strval($this->KDPROVINSI->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idprovinsi`" . ew_SearchString("=", $this->KDPROVINSI->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idprovinsi`, `namaprovinsi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_provinsi`";
			$sWhereWrk = "";
			$this->KDPROVINSI->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDPROVINSI, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDPROVINSI->EditValue = $arwrk;

			// KOTA
			$this->KOTA->EditAttrs["class"] = "form-control";
			$this->KOTA->EditCustomAttributes = "";
			if (trim(strval($this->KOTA->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idkota`" . ew_SearchString("=", $this->KOTA->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idkota`, `namakota` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idprovinsi` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_kota`";
			$sWhereWrk = "";
			$this->KOTA->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KOTA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KOTA->EditValue = $arwrk;

			// KDKECAMATAN
			$this->KDKECAMATAN->EditAttrs["class"] = "form-control";
			$this->KDKECAMATAN->EditCustomAttributes = "";
			if (trim(strval($this->KDKECAMATAN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idkecamatan`" . ew_SearchString("=", $this->KDKECAMATAN->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idkecamatan`, `namakecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idkota` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_kecamatan`";
			$sWhereWrk = "";
			$this->KDKECAMATAN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDKECAMATAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDKECAMATAN->EditValue = $arwrk;

			// KELURAHAN
			$this->KELURAHAN->EditAttrs["class"] = "form-control";
			$this->KELURAHAN->EditCustomAttributes = "";
			if (trim(strval($this->KELURAHAN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idkelurahan`" . ew_SearchString("=", $this->KELURAHAN->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idkelurahan`, `namakelurahan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idkecamatan` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_kelurahan`";
			$sWhereWrk = "";
			$this->KELURAHAN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KELURAHAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KELURAHAN->EditValue = $arwrk;

			// NOTELP
			$this->NOTELP->EditAttrs["class"] = "form-control";
			$this->NOTELP->EditCustomAttributes = "";
			$this->NOTELP->EditValue = ew_HtmlEncode($this->NOTELP->CurrentValue);
			$this->NOTELP->PlaceHolder = ew_RemoveHtml($this->NOTELP->FldCaption());

			// NOKTP
			$this->NOKTP->EditAttrs["class"] = "form-control";
			$this->NOKTP->EditCustomAttributes = "";
			$this->NOKTP->EditValue = ew_HtmlEncode($this->NOKTP->CurrentValue);
			$this->NOKTP->PlaceHolder = ew_RemoveHtml($this->NOKTP->FldCaption());

			// PEKERJAAN
			$this->PEKERJAAN->EditAttrs["class"] = "form-control";
			$this->PEKERJAAN->EditCustomAttributes = "";
			$this->PEKERJAAN->EditValue = ew_HtmlEncode($this->PEKERJAAN->CurrentValue);
			$this->PEKERJAAN->PlaceHolder = ew_RemoveHtml($this->PEKERJAAN->FldCaption());

			// STATUS
			$this->STATUS->EditAttrs["class"] = "form-control";
			$this->STATUS->EditCustomAttributes = "";
			if (trim(strval($this->STATUS->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->STATUS->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `statusperkawinan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_statusperkawin`";
			$sWhereWrk = "";
			$this->STATUS->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->STATUS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->STATUS->EditValue = $arwrk;

			// AGAMA
			$this->AGAMA->EditAttrs["class"] = "form-control";
			$this->AGAMA->EditCustomAttributes = "";
			if (trim(strval($this->AGAMA->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_agama`";
			$sWhereWrk = "";
			$this->AGAMA->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->AGAMA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->AGAMA->EditValue = $arwrk;

			// PENDIDIKAN
			$this->PENDIDIKAN->EditAttrs["class"] = "form-control";
			$this->PENDIDIKAN->EditCustomAttributes = "";
			if (trim(strval($this->PENDIDIKAN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_pendidikanterakhir`";
			$sWhereWrk = "";
			$this->PENDIDIKAN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->PENDIDIKAN->EditValue = $arwrk;

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

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = ew_HtmlEncode($this->NIP->CurrentValue);
			$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

			// TGLDAFTAR
			$this->TGLDAFTAR->EditAttrs["class"] = "form-control";
			$this->TGLDAFTAR->EditCustomAttributes = "";
			$this->TGLDAFTAR->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->TGLDAFTAR->CurrentValue, 7));
			$this->TGLDAFTAR->PlaceHolder = ew_RemoveHtml($this->TGLDAFTAR->FldCaption());

			// ALAMAT_KTP
			$this->ALAMAT_KTP->EditAttrs["class"] = "form-control";
			$this->ALAMAT_KTP->EditCustomAttributes = "";
			$this->ALAMAT_KTP->EditValue = ew_HtmlEncode($this->ALAMAT_KTP->CurrentValue);
			$this->ALAMAT_KTP->PlaceHolder = ew_RemoveHtml($this->ALAMAT_KTP->FldCaption());

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

			// NO_KARTU
			$this->NO_KARTU->EditAttrs["class"] = "form-control";
			$this->NO_KARTU->EditCustomAttributes = "";
			$this->NO_KARTU->EditValue = ew_HtmlEncode($this->NO_KARTU->CurrentValue);
			$this->NO_KARTU->PlaceHolder = ew_RemoveHtml($this->NO_KARTU->FldCaption());

			// JNS_PASIEN
			$this->JNS_PASIEN->EditAttrs["class"] = "form-control";
			$this->JNS_PASIEN->EditCustomAttributes = "";
			if (trim(strval($this->JNS_PASIEN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_jenis_pasien`";
			$sWhereWrk = "";
			$this->JNS_PASIEN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->JNS_PASIEN->EditValue = $arwrk;

			// nama_ayah
			$this->nama_ayah->EditAttrs["class"] = "form-control";
			$this->nama_ayah->EditCustomAttributes = "";
			$this->nama_ayah->EditValue = ew_HtmlEncode($this->nama_ayah->CurrentValue);
			$this->nama_ayah->PlaceHolder = ew_RemoveHtml($this->nama_ayah->FldCaption());

			// nama_ibu
			$this->nama_ibu->EditAttrs["class"] = "form-control";
			$this->nama_ibu->EditCustomAttributes = "";
			$this->nama_ibu->EditValue = ew_HtmlEncode($this->nama_ibu->CurrentValue);
			$this->nama_ibu->PlaceHolder = ew_RemoveHtml($this->nama_ibu->FldCaption());

			// nama_suami
			$this->nama_suami->EditAttrs["class"] = "form-control";
			$this->nama_suami->EditCustomAttributes = "";
			$this->nama_suami->EditValue = ew_HtmlEncode($this->nama_suami->CurrentValue);
			$this->nama_suami->PlaceHolder = ew_RemoveHtml($this->nama_suami->FldCaption());

			// nama_istri
			$this->nama_istri->EditAttrs["class"] = "form-control";
			$this->nama_istri->EditCustomAttributes = "";
			$this->nama_istri->EditValue = ew_HtmlEncode($this->nama_istri->CurrentValue);
			$this->nama_istri->PlaceHolder = ew_RemoveHtml($this->nama_istri->FldCaption());

			// KD_ETNIS
			$this->KD_ETNIS->EditAttrs["class"] = "form-control";
			$this->KD_ETNIS->EditCustomAttributes = "";
			if (trim(strval($this->KD_ETNIS->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_etnis`";
			$sWhereWrk = "";
			$this->KD_ETNIS->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KD_ETNIS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KD_ETNIS->EditValue = $arwrk;

			// KD_BHS_HARIAN
			$this->KD_BHS_HARIAN->EditAttrs["class"] = "form-control";
			$this->KD_BHS_HARIAN->EditCustomAttributes = "";
			if (trim(strval($this->KD_BHS_HARIAN->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_bahasa_harian`";
			$sWhereWrk = "";
			$this->KD_BHS_HARIAN->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KD_BHS_HARIAN->EditValue = $arwrk;

			// Add refer script
			// TITLE

			$this->TITLE->LinkCustomAttributes = "";
			$this->TITLE->HrefValue = "";

			// NAMA
			$this->NAMA->LinkCustomAttributes = "";
			$this->NAMA->HrefValue = "";

			// TEMPAT
			$this->TEMPAT->LinkCustomAttributes = "";
			$this->TEMPAT->HrefValue = "";

			// TGLLAHIR
			$this->TGLLAHIR->LinkCustomAttributes = "";
			$this->TGLLAHIR->HrefValue = "";

			// JENISKELAMIN
			$this->JENISKELAMIN->LinkCustomAttributes = "";
			$this->JENISKELAMIN->HrefValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";

			// KDPROVINSI
			$this->KDPROVINSI->LinkCustomAttributes = "";
			$this->KDPROVINSI->HrefValue = "";

			// KOTA
			$this->KOTA->LinkCustomAttributes = "";
			$this->KOTA->HrefValue = "";

			// KDKECAMATAN
			$this->KDKECAMATAN->LinkCustomAttributes = "";
			$this->KDKECAMATAN->HrefValue = "";

			// KELURAHAN
			$this->KELURAHAN->LinkCustomAttributes = "";
			$this->KELURAHAN->HrefValue = "";

			// NOTELP
			$this->NOTELP->LinkCustomAttributes = "";
			$this->NOTELP->HrefValue = "";

			// NOKTP
			$this->NOKTP->LinkCustomAttributes = "";
			$this->NOKTP->HrefValue = "";

			// PEKERJAAN
			$this->PEKERJAAN->LinkCustomAttributes = "";
			$this->PEKERJAAN->HrefValue = "";

			// STATUS
			$this->STATUS->LinkCustomAttributes = "";
			$this->STATUS->HrefValue = "";

			// AGAMA
			$this->AGAMA->LinkCustomAttributes = "";
			$this->AGAMA->HrefValue = "";

			// PENDIDIKAN
			$this->PENDIDIKAN->LinkCustomAttributes = "";
			$this->PENDIDIKAN->HrefValue = "";

			// KDCARABAYAR
			$this->KDCARABAYAR->LinkCustomAttributes = "";
			$this->KDCARABAYAR->HrefValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";

			// TGLDAFTAR
			$this->TGLDAFTAR->LinkCustomAttributes = "";
			$this->TGLDAFTAR->HrefValue = "";

			// ALAMAT_KTP
			$this->ALAMAT_KTP->LinkCustomAttributes = "";
			$this->ALAMAT_KTP->HrefValue = "";

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

			// NO_KARTU
			$this->NO_KARTU->LinkCustomAttributes = "";
			$this->NO_KARTU->HrefValue = "";

			// JNS_PASIEN
			$this->JNS_PASIEN->LinkCustomAttributes = "";
			$this->JNS_PASIEN->HrefValue = "";

			// nama_ayah
			$this->nama_ayah->LinkCustomAttributes = "";
			$this->nama_ayah->HrefValue = "";

			// nama_ibu
			$this->nama_ibu->LinkCustomAttributes = "";
			$this->nama_ibu->HrefValue = "";

			// nama_suami
			$this->nama_suami->LinkCustomAttributes = "";
			$this->nama_suami->HrefValue = "";

			// nama_istri
			$this->nama_istri->LinkCustomAttributes = "";
			$this->nama_istri->HrefValue = "";

			// KD_ETNIS
			$this->KD_ETNIS->LinkCustomAttributes = "";
			$this->KD_ETNIS->HrefValue = "";

			// KD_BHS_HARIAN
			$this->KD_BHS_HARIAN->LinkCustomAttributes = "";
			$this->KD_BHS_HARIAN->HrefValue = "";
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
		if (!$this->TITLE->FldIsDetailKey && !is_null($this->TITLE->FormValue) && $this->TITLE->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TITLE->FldCaption(), $this->TITLE->ReqErrMsg));
		}
		if (!$this->NAMA->FldIsDetailKey && !is_null($this->NAMA->FormValue) && $this->NAMA->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NAMA->FldCaption(), $this->NAMA->ReqErrMsg));
		}
		if (!$this->TEMPAT->FldIsDetailKey && !is_null($this->TEMPAT->FormValue) && $this->TEMPAT->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TEMPAT->FldCaption(), $this->TEMPAT->ReqErrMsg));
		}
		if (!$this->TGLLAHIR->FldIsDetailKey && !is_null($this->TGLLAHIR->FormValue) && $this->TGLLAHIR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TGLLAHIR->FldCaption(), $this->TGLLAHIR->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->TGLLAHIR->FormValue)) {
			ew_AddMessage($gsFormError, $this->TGLLAHIR->FldErrMsg());
		}
		if ($this->JENISKELAMIN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->JENISKELAMIN->FldCaption(), $this->JENISKELAMIN->ReqErrMsg));
		}
		if (!$this->ALAMAT->FldIsDetailKey && !is_null($this->ALAMAT->FormValue) && $this->ALAMAT->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ALAMAT->FldCaption(), $this->ALAMAT->ReqErrMsg));
		}
		if (!$this->KDPROVINSI->FldIsDetailKey && !is_null($this->KDPROVINSI->FormValue) && $this->KDPROVINSI->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDPROVINSI->FldCaption(), $this->KDPROVINSI->ReqErrMsg));
		}
		if (!$this->KOTA->FldIsDetailKey && !is_null($this->KOTA->FormValue) && $this->KOTA->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KOTA->FldCaption(), $this->KOTA->ReqErrMsg));
		}
		if (!$this->KDKECAMATAN->FldIsDetailKey && !is_null($this->KDKECAMATAN->FormValue) && $this->KDKECAMATAN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDKECAMATAN->FldCaption(), $this->KDKECAMATAN->ReqErrMsg));
		}
		if (!$this->KELURAHAN->FldIsDetailKey && !is_null($this->KELURAHAN->FormValue) && $this->KELURAHAN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KELURAHAN->FldCaption(), $this->KELURAHAN->ReqErrMsg));
		}
		if (!$this->NOTELP->FldIsDetailKey && !is_null($this->NOTELP->FormValue) && $this->NOTELP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NOTELP->FldCaption(), $this->NOTELP->ReqErrMsg));
		}
		if (!$this->NOKTP->FldIsDetailKey && !is_null($this->NOKTP->FormValue) && $this->NOKTP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NOKTP->FldCaption(), $this->NOKTP->ReqErrMsg));
		}
		if (!$this->PEKERJAAN->FldIsDetailKey && !is_null($this->PEKERJAAN->FormValue) && $this->PEKERJAAN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PEKERJAAN->FldCaption(), $this->PEKERJAAN->ReqErrMsg));
		}
		if (!$this->STATUS->FldIsDetailKey && !is_null($this->STATUS->FormValue) && $this->STATUS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->STATUS->FldCaption(), $this->STATUS->ReqErrMsg));
		}
		if (!$this->AGAMA->FldIsDetailKey && !is_null($this->AGAMA->FormValue) && $this->AGAMA->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->AGAMA->FldCaption(), $this->AGAMA->ReqErrMsg));
		}
		if (!$this->PENDIDIKAN->FldIsDetailKey && !is_null($this->PENDIDIKAN->FormValue) && $this->PENDIDIKAN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PENDIDIKAN->FldCaption(), $this->PENDIDIKAN->ReqErrMsg));
		}
		if (!$this->NIP->FldIsDetailKey && !is_null($this->NIP->FormValue) && $this->NIP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NIP->FldCaption(), $this->NIP->ReqErrMsg));
		}
		if (!$this->TGLDAFTAR->FldIsDetailKey && !is_null($this->TGLDAFTAR->FormValue) && $this->TGLDAFTAR->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TGLDAFTAR->FldCaption(), $this->TGLDAFTAR->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->TGLDAFTAR->FormValue)) {
			ew_AddMessage($gsFormError, $this->TGLDAFTAR->FldErrMsg());
		}
		if (!$this->ALAMAT_KTP->FldIsDetailKey && !is_null($this->ALAMAT_KTP->FormValue) && $this->ALAMAT_KTP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ALAMAT_KTP->FldCaption(), $this->ALAMAT_KTP->ReqErrMsg));
		}
		if (!$this->nama_ayah->FldIsDetailKey && !is_null($this->nama_ayah->FormValue) && $this->nama_ayah->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_ayah->FldCaption(), $this->nama_ayah->ReqErrMsg));
		}
		if (!$this->nama_ibu->FldIsDetailKey && !is_null($this->nama_ibu->FormValue) && $this->nama_ibu->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_ibu->FldCaption(), $this->nama_ibu->ReqErrMsg));
		}
		if (!$this->nama_suami->FldIsDetailKey && !is_null($this->nama_suami->FormValue) && $this->nama_suami->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_suami->FldCaption(), $this->nama_suami->ReqErrMsg));
		}
		if (!$this->nama_istri->FldIsDetailKey && !is_null($this->nama_istri->FormValue) && $this->nama_istri->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama_istri->FldCaption(), $this->nama_istri->ReqErrMsg));
		}
		if (!$this->KD_ETNIS->FldIsDetailKey && !is_null($this->KD_ETNIS->FormValue) && $this->KD_ETNIS->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KD_ETNIS->FldCaption(), $this->KD_ETNIS->ReqErrMsg));
		}
		if (!$this->KD_BHS_HARIAN->FldIsDetailKey && !is_null($this->KD_BHS_HARIAN->FormValue) && $this->KD_BHS_HARIAN->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KD_BHS_HARIAN->FldCaption(), $this->KD_BHS_HARIAN->ReqErrMsg));
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

		// TITLE
		$this->TITLE->SetDbValueDef($rsnew, $this->TITLE->CurrentValue, NULL, FALSE);

		// NAMA
		$this->NAMA->SetDbValueDef($rsnew, $this->NAMA->CurrentValue, "", strval($this->NAMA->CurrentValue) == "");

		// TEMPAT
		$this->TEMPAT->SetDbValueDef($rsnew, $this->TEMPAT->CurrentValue, "", strval($this->TEMPAT->CurrentValue) == "");

		// TGLLAHIR
		$this->TGLLAHIR->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TGLLAHIR->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// JENISKELAMIN
		$this->JENISKELAMIN->SetDbValueDef($rsnew, $this->JENISKELAMIN->CurrentValue, "", strval($this->JENISKELAMIN->CurrentValue) == "");

		// ALAMAT
		$this->ALAMAT->SetDbValueDef($rsnew, $this->ALAMAT->CurrentValue, "", strval($this->ALAMAT->CurrentValue) == "");

		// KDPROVINSI
		$this->KDPROVINSI->SetDbValueDef($rsnew, $this->KDPROVINSI->CurrentValue, 0, FALSE);

		// KOTA
		$this->KOTA->SetDbValueDef($rsnew, $this->KOTA->CurrentValue, "", strval($this->KOTA->CurrentValue) == "");

		// KDKECAMATAN
		$this->KDKECAMATAN->SetDbValueDef($rsnew, $this->KDKECAMATAN->CurrentValue, 0, strval($this->KDKECAMATAN->CurrentValue) == "");

		// KELURAHAN
		$this->KELURAHAN->SetDbValueDef($rsnew, $this->KELURAHAN->CurrentValue, "", strval($this->KELURAHAN->CurrentValue) == "");

		// NOTELP
		$this->NOTELP->SetDbValueDef($rsnew, $this->NOTELP->CurrentValue, "", strval($this->NOTELP->CurrentValue) == "");

		// NOKTP
		$this->NOKTP->SetDbValueDef($rsnew, $this->NOKTP->CurrentValue, "", strval($this->NOKTP->CurrentValue) == "");

		// PEKERJAAN
		$this->PEKERJAAN->SetDbValueDef($rsnew, $this->PEKERJAAN->CurrentValue, "", strval($this->PEKERJAAN->CurrentValue) == "");

		// STATUS
		$this->STATUS->SetDbValueDef($rsnew, $this->STATUS->CurrentValue, 0, strval($this->STATUS->CurrentValue) == "");

		// AGAMA
		$this->AGAMA->SetDbValueDef($rsnew, $this->AGAMA->CurrentValue, 0, strval($this->AGAMA->CurrentValue) == "");

		// PENDIDIKAN
		$this->PENDIDIKAN->SetDbValueDef($rsnew, $this->PENDIDIKAN->CurrentValue, 0, strval($this->PENDIDIKAN->CurrentValue) == "");

		// KDCARABAYAR
		$this->KDCARABAYAR->SetDbValueDef($rsnew, $this->KDCARABAYAR->CurrentValue, NULL, strval($this->KDCARABAYAR->CurrentValue) == "");

		// NIP
		$this->NIP->SetDbValueDef($rsnew, $this->NIP->CurrentValue, "", FALSE);

		// TGLDAFTAR
		$this->TGLDAFTAR->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->TGLDAFTAR->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// ALAMAT_KTP
		$this->ALAMAT_KTP->SetDbValueDef($rsnew, $this->ALAMAT_KTP->CurrentValue, "", FALSE);

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_NAMA->CurrentValue, NULL, FALSE);

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue, NULL, FALSE);

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue, NULL, FALSE);

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->SetDbValueDef($rsnew, $this->PENANGGUNGJAWAB_PHONE->CurrentValue, NULL, FALSE);

		// NO_KARTU
		$this->NO_KARTU->SetDbValueDef($rsnew, $this->NO_KARTU->CurrentValue, NULL, FALSE);

		// JNS_PASIEN
		$this->JNS_PASIEN->SetDbValueDef($rsnew, $this->JNS_PASIEN->CurrentValue, NULL, FALSE);

		// nama_ayah
		$this->nama_ayah->SetDbValueDef($rsnew, $this->nama_ayah->CurrentValue, "", FALSE);

		// nama_ibu
		$this->nama_ibu->SetDbValueDef($rsnew, $this->nama_ibu->CurrentValue, "", FALSE);

		// nama_suami
		$this->nama_suami->SetDbValueDef($rsnew, $this->nama_suami->CurrentValue, "", FALSE);

		// nama_istri
		$this->nama_istri->SetDbValueDef($rsnew, $this->nama_istri->CurrentValue, "", FALSE);

		// KD_ETNIS
		$this->KD_ETNIS->SetDbValueDef($rsnew, $this->KD_ETNIS->CurrentValue, NULL, FALSE);

		// KD_BHS_HARIAN
		$this->KD_BHS_HARIAN->SetDbValueDef($rsnew, $this->KD_BHS_HARIAN->CurrentValue, NULL, FALSE);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_pasienlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_TITLE":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
			$sWhereWrk = "";
			$this->TITLE->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->TITLE, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_JENISKELAMIN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
			$sWhereWrk = "";
			$this->JENISKELAMIN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDPROVINSI":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `idprovinsi` AS `LinkFld`, `namaprovinsi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_provinsi`";
			$sWhereWrk = "";
			$this->KDPROVINSI->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`idprovinsi` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDPROVINSI, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KOTA":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `idkota` AS `LinkFld`, `namakota` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kota`";
			$sWhereWrk = "{filter}";
			$this->KOTA->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`idkota` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`idprovinsi` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KOTA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDKECAMATAN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `idkecamatan` AS `LinkFld`, `namakecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kecamatan`";
			$sWhereWrk = "{filter}";
			$this->KDKECAMATAN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`idkecamatan` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`idkota` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDKECAMATAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KELURAHAN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `idkelurahan` AS `LinkFld`, `namakelurahan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kelurahan`";
			$sWhereWrk = "{filter}";
			$this->KELURAHAN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`idkelurahan` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`idkecamatan` IN ({filter_value})', "t1" => "3", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KELURAHAN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_STATUS":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `statusperkawinan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_statusperkawin`";
			$sWhereWrk = "";
			$this->STATUS->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->STATUS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_AGAMA":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
			$sWhereWrk = "";
			$this->AGAMA->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->AGAMA, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_PENDIDIKAN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
			$sWhereWrk = "";
			$this->PENDIDIKAN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
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
		case "x_JNS_PASIEN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `jenis_pasien` AS `LinkFld`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
			$sWhereWrk = "";
			$this->JNS_PASIEN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`jenis_pasien` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KD_ETNIS":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
			$sWhereWrk = "";
			$this->KD_ETNIS->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KD_ETNIS, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KD_BHS_HARIAN":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
			$sWhereWrk = "";
			$this->KD_BHS_HARIAN->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
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

			//$url = "t_pendaftaranadd.php?flag=".$this->NOMR->CurrentValue;;
			$url = "sukses_simpan_pasien.php?id=".$this->id->CurrentValue."&NOMR=".$this->NOMR->CurrentValue."";
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

		$header = "<div class=\"alert alert-warning ewAlert\">Khusus Pada Halaman ini Abaikan  NOMR yang Tertulis</div>";
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
if (!isset($m_pasien_add)) $m_pasien_add = new cm_pasien_add();

// Page init
$m_pasien_add->Page_Init();

// Page main
$m_pasien_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_pasien_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fm_pasienadd = new ew_Form("fm_pasienadd", "add");

// Validate form
fm_pasienadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_TITLE");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->TITLE->FldCaption(), $m_pasien->TITLE->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NAMA");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->NAMA->FldCaption(), $m_pasien->NAMA->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TEMPAT");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->TEMPAT->FldCaption(), $m_pasien->TEMPAT->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TGLLAHIR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->TGLLAHIR->FldCaption(), $m_pasien->TGLLAHIR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TGLLAHIR");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_pasien->TGLLAHIR->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_JENISKELAMIN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->JENISKELAMIN->FldCaption(), $m_pasien->JENISKELAMIN->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ALAMAT");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->ALAMAT->FldCaption(), $m_pasien->ALAMAT->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KDPROVINSI");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->KDPROVINSI->FldCaption(), $m_pasien->KDPROVINSI->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KOTA");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->KOTA->FldCaption(), $m_pasien->KOTA->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KDKECAMATAN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->KDKECAMATAN->FldCaption(), $m_pasien->KDKECAMATAN->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KELURAHAN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->KELURAHAN->FldCaption(), $m_pasien->KELURAHAN->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NOTELP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->NOTELP->FldCaption(), $m_pasien->NOTELP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NOKTP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->NOKTP->FldCaption(), $m_pasien->NOKTP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PEKERJAAN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->PEKERJAAN->FldCaption(), $m_pasien->PEKERJAAN->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_STATUS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->STATUS->FldCaption(), $m_pasien->STATUS->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_AGAMA");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->AGAMA->FldCaption(), $m_pasien->AGAMA->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PENDIDIKAN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->PENDIDIKAN->FldCaption(), $m_pasien->PENDIDIKAN->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NIP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->NIP->FldCaption(), $m_pasien->NIP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TGLDAFTAR");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->TGLDAFTAR->FldCaption(), $m_pasien->TGLDAFTAR->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TGLDAFTAR");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_pasien->TGLDAFTAR->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_ALAMAT_KTP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->ALAMAT_KTP->FldCaption(), $m_pasien->ALAMAT_KTP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_ayah");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->nama_ayah->FldCaption(), $m_pasien->nama_ayah->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_ibu");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->nama_ibu->FldCaption(), $m_pasien->nama_ibu->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_suami");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->nama_suami->FldCaption(), $m_pasien->nama_suami->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nama_istri");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->nama_istri->FldCaption(), $m_pasien->nama_istri->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KD_ETNIS");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->KD_ETNIS->FldCaption(), $m_pasien->KD_ETNIS->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KD_BHS_HARIAN");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_pasien->KD_BHS_HARIAN->FldCaption(), $m_pasien->KD_BHS_HARIAN->ReqErrMsg)) ?>");

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
fm_pasienadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_pasienadd.ValidateRequired = true;
<?php } else { ?>
fm_pasienadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_pasienadd.Lists["x_TITLE"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_titel"};
fm_pasienadd.Lists["x_JENISKELAMIN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskelamin","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskelamin"};
fm_pasienadd.Lists["x_KDPROVINSI"] = {"LinkField":"x_idprovinsi","Ajax":true,"AutoFill":false,"DisplayFields":["x_namaprovinsi","","",""],"ParentFields":[],"ChildFields":["x_KOTA"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_provinsi"};
fm_pasienadd.Lists["x_KOTA"] = {"LinkField":"x_idkota","Ajax":true,"AutoFill":false,"DisplayFields":["x_namakota","","",""],"ParentFields":["x_KDPROVINSI"],"ChildFields":["x_KDKECAMATAN"],"FilterFields":["x_idprovinsi"],"Options":[],"Template":"","LinkTable":"m_kota"};
fm_pasienadd.Lists["x_KDKECAMATAN"] = {"LinkField":"x_idkecamatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_namakecamatan","","",""],"ParentFields":["x_KOTA"],"ChildFields":["x_KELURAHAN"],"FilterFields":["x_idkota"],"Options":[],"Template":"","LinkTable":"m_kecamatan"};
fm_pasienadd.Lists["x_KELURAHAN"] = {"LinkField":"x_idkelurahan","Ajax":true,"AutoFill":false,"DisplayFields":["x_namakelurahan","","",""],"ParentFields":["x_KDKECAMATAN"],"ChildFields":[],"FilterFields":["x_idkecamatan"],"Options":[],"Template":"","LinkTable":"m_kelurahan"};
fm_pasienadd.Lists["x_STATUS"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_statusperkawinan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_statusperkawin"};
fm_pasienadd.Lists["x_AGAMA"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_agama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_agama"};
fm_pasienadd.Lists["x_PENDIDIKAN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_pendidikan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_pendidikanterakhir"};
fm_pasienadd.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fm_pasienadd.Lists["x_JNS_PASIEN"] = {"LinkField":"x_jenis_pasien","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_pasien"};
fm_pasienadd.Lists["x_KD_ETNIS"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_etnis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_etnis"};
fm_pasienadd.Lists["x_KD_BHS_HARIAN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bahasa_harian","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_bahasa_harian"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
$(document).ready(function() {

	//$('#x_NOMR').css('color', 'transparent');
	$('#x_NOKTP').css('background-color', '#ffff00');
	$('#x_TITLE').css('background-color', '#ffff00');
	$('#x_NAMA').css('background-color', '#ffff00');
	$('#x_TEMPAT').css('background-color', '#ffff00');
	$('#x_TGLLAHIR').css('background-color', '#ffff00');
	$('#x_NOTELP').css('background-color', '#ffff00');
	$('#x_JENISKELAMIN').css('background-color', '#ffff00');
	$('#x_NOTELP').css('background-color', '#ffff00');
	$('#x_PEKERJAAN').css('background-color', '#ffff00');
	$('#x_SUAMI_ORTU').css('background-color', '#ffff00');
	$('#x_KDPROVINSI').css('background-color', '#ffff00');
	$('#x_KOTA').css('background-color', '#ffff00');
	$('#x_KDKECAMATAN').css('background-color', '#ffff00');
	$('#x_KELURAHAN').css('background-color', '#ffff00');
	$('#x_STATUS').css('background-color', '#ffff00');
		$('#x_ALAMAT').css('background-color', '#ffff00');
		$('#x_AGAMA').css('background-color', '#ffff00');
		$('#x_PENDIDIKAN').css('background-color', '#ffff00');
		$('#x_ALAMAT_KTP').css('background-color', '#ffff00');
		$('#x_KD_ETNIS').css('background-color', '#ffff00');
		$('#x_KD_BHS_HARIAN').css('background-color', '#ffff00');
		$('#x_nama_ayah').css('background-color', '#ffff00');
		$('#x_nama_ibu').css('background-color', '#ffff00');
		$('#x_nama_suami').css('background-color', '#ffff00');
		$('#x_nama_istri').css('background-color', '#ffff00');
		$('#x_NO_KARTU').css('background-color', '#ffff00');
		$('#x_PENANGGUNGJAWAB_NAMA').css('background-color', '#ffff00');
		$('#x_PENANGGUNGJAWAB_HUBUNGAN').css('background-color', '#ffff00');
		$('#x_PENANGGUNGJAWAB_ALAMAT').css('background-color', '#ffff00');
		$('#x_PENANGGUNGJAWAB_PHONE').css('background-color', '#ffff00');
});
</script>
<?php if (!$m_pasien_add->IsModal) { ?>
<?php } ?>
<?php $m_pasien_add->ShowPageHeader(); ?>
<?php
$m_pasien_add->ShowMessage();
?>
<form name="fm_pasienadd" id="fm_pasienadd" class="<?php echo $m_pasien_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_pasien_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_pasien_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_pasien">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($m_pasien_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_m_pasienadd" class="ewCustomTemplate"></div>
<script id="tpm_m_pasienadd" type="text/html">
<div id="ct_m_pasien_add"><div id="ct_sample_add">
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Identitas Pribadi Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<!--<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->NOMR->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_NOMR"/}}</div>
	</div> -->
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->TGLDAFTAR->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_TGLDAFTAR"/}}</div>
	</div>
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->NIP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_NIP"/}}</div>
	</div>
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->NOKTP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_NOKTP"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->TITLE->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_TITLE"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->NAMA->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_NAMA"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->TEMPAT->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_TEMPAT"/}}</div>
	</div>
		<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->TGLLAHIR->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_TGLLAHIR"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->JENISKELAMIN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_JENISKELAMIN"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->NOTELP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_NOTELP"/}}</div>
	</div>
	 <div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->PEKERJAAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_PEKERJAAN"/}}</div>
	</div>
	<div id="r_Field_Four" class="form-group">
	<label id="elh_status" for="x_status" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->STATUS->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_STATUS"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
  	<!-- <div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->SUAMI_ORTU->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_SUAMI_ORTU"/}}</div>
	</div> -->
  	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->KDPROVINSI->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_KDPROVINSI"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->KOTA->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_KOTA"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->KDKECAMATAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_KDKECAMATAN"/}}</div>
	</div>
	  <div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->KELURAHAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_KELURAHAN"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->ALAMAT->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_ALAMAT"/}}</div>
	</div>
	 <div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->AGAMA->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_AGAMA"/}}</div>
	</div> 
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->PENDIDIKAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_PENDIDIKAN"/}}</div>
	</div>
	 <div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->ALAMAT_KTP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_ALAMAT_KTP"/}}</div>
	</div>
	<div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->KD_ETNIS->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_KD_ETNIS"/}}</div>
	</div>
	<div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->KD_BHS_HARIAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_KD_BHS_HARIAN"/}}</div>
	</div>
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Keluarga Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->nama_ayah->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_nama_ayah"/}}</div>
	</div>
	 <div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->nama_ibu->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_nama_ibu"/}}</div>
	</div>
	 <div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->nama_suami->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_nama_suami"/}}</div>
	</div>
	<div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->nama_istri->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_nama_istri"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Jaminan (Kolom ini Boleh Dibiarkan Kosong)</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->JNS_PASIEN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_JNS_PASIEN"/}}</div>
	</div>
	<div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->KDCARABAYAR->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_KDCARABAYAR"/}}</div>
	</div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
  	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->NO_KARTU->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_NO_KARTU"/}}</div>
	</div>
  </div>
</div>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><strong>Data Penanggung Jawab Pasien</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_PENANGGUNGJAWAB_NAMA"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_PENANGGUNGJAWAB_HUBUNGAN"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_PENANGGUNGJAWAB_ALAMAT"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_m_pasien_PENANGGUNGJAWAB_PHONE"/}}</div>
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
<?php if ($m_pasien->TITLE->Visible) { // TITLE ?>
	<div id="r_TITLE" class="form-group">
		<label id="elh_m_pasien_TITLE" for="x_TITLE" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_TITLE" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->TITLE->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->TITLE->CellAttributes() ?>>
<script id="tpx_m_pasien_TITLE" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_TITLE">
<select data-table="m_pasien" data-field="x_TITLE" data-value-separator="<?php echo $m_pasien->TITLE->DisplayValueSeparatorAttribute() ?>" id="x_TITLE" name="x_TITLE"<?php echo $m_pasien->TITLE->EditAttributes() ?>>
<?php echo $m_pasien->TITLE->SelectOptionListHtml("x_TITLE") ?>
</select>
<input type="hidden" name="s_x_TITLE" id="s_x_TITLE" value="<?php echo $m_pasien->TITLE->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->TITLE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->NAMA->Visible) { // NAMA ?>
	<div id="r_NAMA" class="form-group">
		<label id="elh_m_pasien_NAMA" for="x_NAMA" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_NAMA" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->NAMA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->NAMA->CellAttributes() ?>>
<script id="tpx_m_pasien_NAMA" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_NAMA">
<input type="text" data-table="m_pasien" data-field="x_NAMA" name="x_NAMA" id="x_NAMA" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->NAMA->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NAMA->EditValue ?>"<?php echo $m_pasien->NAMA->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->NAMA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->TEMPAT->Visible) { // TEMPAT ?>
	<div id="r_TEMPAT" class="form-group">
		<label id="elh_m_pasien_TEMPAT" for="x_TEMPAT" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_TEMPAT" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->TEMPAT->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->TEMPAT->CellAttributes() ?>>
<script id="tpx_m_pasien_TEMPAT" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_TEMPAT">
<input type="text" data-table="m_pasien" data-field="x_TEMPAT" name="x_TEMPAT" id="x_TEMPAT" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($m_pasien->TEMPAT->getPlaceHolder()) ?>" value="<?php echo $m_pasien->TEMPAT->EditValue ?>"<?php echo $m_pasien->TEMPAT->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->TEMPAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->TGLLAHIR->Visible) { // TGLLAHIR ?>
	<div id="r_TGLLAHIR" class="form-group">
		<label id="elh_m_pasien_TGLLAHIR" for="x_TGLLAHIR" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_TGLLAHIR" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->TGLLAHIR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->TGLLAHIR->CellAttributes() ?>>
<script id="tpx_m_pasien_TGLLAHIR" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_TGLLAHIR">
<input type="text" data-table="m_pasien" data-field="x_TGLLAHIR" data-format="7" name="x_TGLLAHIR" id="x_TGLLAHIR" placeholder="<?php echo ew_HtmlEncode($m_pasien->TGLLAHIR->getPlaceHolder()) ?>" value="<?php echo $m_pasien->TGLLAHIR->EditValue ?>"<?php echo $m_pasien->TGLLAHIR->EditAttributes() ?>>
<?php if (!$m_pasien->TGLLAHIR->ReadOnly && !$m_pasien->TGLLAHIR->Disabled && !isset($m_pasien->TGLLAHIR->EditAttrs["readonly"]) && !isset($m_pasien->TGLLAHIR->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="m_pasienadd_js">
ew_CreateCalendar("fm_pasienadd", "x_TGLLAHIR", 7);
</script>
<?php echo $m_pasien->TGLLAHIR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->JENISKELAMIN->Visible) { // JENISKELAMIN ?>
	<div id="r_JENISKELAMIN" class="form-group">
		<label id="elh_m_pasien_JENISKELAMIN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_JENISKELAMIN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->JENISKELAMIN->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->JENISKELAMIN->CellAttributes() ?>>
<script id="tpx_m_pasien_JENISKELAMIN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_JENISKELAMIN">
<div id="tp_x_JENISKELAMIN" class="ewTemplate"><input type="radio" data-table="m_pasien" data-field="x_JENISKELAMIN" data-value-separator="<?php echo $m_pasien->JENISKELAMIN->DisplayValueSeparatorAttribute() ?>" name="x_JENISKELAMIN" id="x_JENISKELAMIN" value="{value}"<?php echo $m_pasien->JENISKELAMIN->EditAttributes() ?>></div>
<div id="dsl_x_JENISKELAMIN" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $m_pasien->JENISKELAMIN->RadioButtonListHtml(FALSE, "x_JENISKELAMIN") ?>
</div></div>
<input type="hidden" name="s_x_JENISKELAMIN" id="s_x_JENISKELAMIN" value="<?php echo $m_pasien->JENISKELAMIN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->JENISKELAMIN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->ALAMAT->Visible) { // ALAMAT ?>
	<div id="r_ALAMAT" class="form-group">
		<label id="elh_m_pasien_ALAMAT" for="x_ALAMAT" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_ALAMAT" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->ALAMAT->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->ALAMAT->CellAttributes() ?>>
<script id="tpx_m_pasien_ALAMAT" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_ALAMAT">
<input type="text" data-table="m_pasien" data-field="x_ALAMAT" name="x_ALAMAT" id="x_ALAMAT" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->ALAMAT->getPlaceHolder()) ?>" value="<?php echo $m_pasien->ALAMAT->EditValue ?>"<?php echo $m_pasien->ALAMAT->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->ALAMAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->KDPROVINSI->Visible) { // KDPROVINSI ?>
	<div id="r_KDPROVINSI" class="form-group">
		<label id="elh_m_pasien_KDPROVINSI" for="x_KDPROVINSI" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_KDPROVINSI" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->KDPROVINSI->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->KDPROVINSI->CellAttributes() ?>>
<script id="tpx_m_pasien_KDPROVINSI" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_KDPROVINSI">
<?php $m_pasien->KDPROVINSI->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$m_pasien->KDPROVINSI->EditAttrs["onchange"]; ?>
<select data-table="m_pasien" data-field="x_KDPROVINSI" data-value-separator="<?php echo $m_pasien->KDPROVINSI->DisplayValueSeparatorAttribute() ?>" id="x_KDPROVINSI" name="x_KDPROVINSI"<?php echo $m_pasien->KDPROVINSI->EditAttributes() ?>>
<?php echo $m_pasien->KDPROVINSI->SelectOptionListHtml("x_KDPROVINSI") ?>
</select>
<input type="hidden" name="s_x_KDPROVINSI" id="s_x_KDPROVINSI" value="<?php echo $m_pasien->KDPROVINSI->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->KDPROVINSI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->KOTA->Visible) { // KOTA ?>
	<div id="r_KOTA" class="form-group">
		<label id="elh_m_pasien_KOTA" for="x_KOTA" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_KOTA" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->KOTA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->KOTA->CellAttributes() ?>>
<script id="tpx_m_pasien_KOTA" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_KOTA">
<?php $m_pasien->KOTA->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$m_pasien->KOTA->EditAttrs["onchange"]; ?>
<select data-table="m_pasien" data-field="x_KOTA" data-value-separator="<?php echo $m_pasien->KOTA->DisplayValueSeparatorAttribute() ?>" id="x_KOTA" name="x_KOTA"<?php echo $m_pasien->KOTA->EditAttributes() ?>>
<?php echo $m_pasien->KOTA->SelectOptionListHtml("x_KOTA") ?>
</select>
<input type="hidden" name="s_x_KOTA" id="s_x_KOTA" value="<?php echo $m_pasien->KOTA->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->KOTA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->KDKECAMATAN->Visible) { // KDKECAMATAN ?>
	<div id="r_KDKECAMATAN" class="form-group">
		<label id="elh_m_pasien_KDKECAMATAN" for="x_KDKECAMATAN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_KDKECAMATAN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->KDKECAMATAN->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->KDKECAMATAN->CellAttributes() ?>>
<script id="tpx_m_pasien_KDKECAMATAN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_KDKECAMATAN">
<?php $m_pasien->KDKECAMATAN->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$m_pasien->KDKECAMATAN->EditAttrs["onchange"]; ?>
<select data-table="m_pasien" data-field="x_KDKECAMATAN" data-value-separator="<?php echo $m_pasien->KDKECAMATAN->DisplayValueSeparatorAttribute() ?>" id="x_KDKECAMATAN" name="x_KDKECAMATAN"<?php echo $m_pasien->KDKECAMATAN->EditAttributes() ?>>
<?php echo $m_pasien->KDKECAMATAN->SelectOptionListHtml("x_KDKECAMATAN") ?>
</select>
<input type="hidden" name="s_x_KDKECAMATAN" id="s_x_KDKECAMATAN" value="<?php echo $m_pasien->KDKECAMATAN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->KDKECAMATAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->KELURAHAN->Visible) { // KELURAHAN ?>
	<div id="r_KELURAHAN" class="form-group">
		<label id="elh_m_pasien_KELURAHAN" for="x_KELURAHAN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_KELURAHAN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->KELURAHAN->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->KELURAHAN->CellAttributes() ?>>
<script id="tpx_m_pasien_KELURAHAN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_KELURAHAN">
<select data-table="m_pasien" data-field="x_KELURAHAN" data-value-separator="<?php echo $m_pasien->KELURAHAN->DisplayValueSeparatorAttribute() ?>" id="x_KELURAHAN" name="x_KELURAHAN"<?php echo $m_pasien->KELURAHAN->EditAttributes() ?>>
<?php echo $m_pasien->KELURAHAN->SelectOptionListHtml("x_KELURAHAN") ?>
</select>
<input type="hidden" name="s_x_KELURAHAN" id="s_x_KELURAHAN" value="<?php echo $m_pasien->KELURAHAN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->KELURAHAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->NOTELP->Visible) { // NOTELP ?>
	<div id="r_NOTELP" class="form-group">
		<label id="elh_m_pasien_NOTELP" for="x_NOTELP" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_NOTELP" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->NOTELP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->NOTELP->CellAttributes() ?>>
<script id="tpx_m_pasien_NOTELP" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_NOTELP">
<input type="text" data-table="m_pasien" data-field="x_NOTELP" name="x_NOTELP" id="x_NOTELP" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($m_pasien->NOTELP->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NOTELP->EditValue ?>"<?php echo $m_pasien->NOTELP->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->NOTELP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->NOKTP->Visible) { // NOKTP ?>
	<div id="r_NOKTP" class="form-group">
		<label id="elh_m_pasien_NOKTP" for="x_NOKTP" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_NOKTP" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->NOKTP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->NOKTP->CellAttributes() ?>>
<script id="tpx_m_pasien_NOKTP" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_NOKTP">
<input type="text" data-table="m_pasien" data-field="x_NOKTP" name="x_NOKTP" id="x_NOKTP" size="30" maxlength="32" placeholder="<?php echo ew_HtmlEncode($m_pasien->NOKTP->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NOKTP->EditValue ?>"<?php echo $m_pasien->NOKTP->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->NOKTP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->PEKERJAAN->Visible) { // PEKERJAAN ?>
	<div id="r_PEKERJAAN" class="form-group">
		<label id="elh_m_pasien_PEKERJAAN" for="x_PEKERJAAN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_PEKERJAAN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->PEKERJAAN->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->PEKERJAAN->CellAttributes() ?>>
<script id="tpx_m_pasien_PEKERJAAN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_PEKERJAAN">
<input type="text" data-table="m_pasien" data-field="x_PEKERJAAN" name="x_PEKERJAAN" id="x_PEKERJAAN" size="30" maxlength="32" placeholder="<?php echo ew_HtmlEncode($m_pasien->PEKERJAAN->getPlaceHolder()) ?>" value="<?php echo $m_pasien->PEKERJAAN->EditValue ?>"<?php echo $m_pasien->PEKERJAAN->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->PEKERJAAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->STATUS->Visible) { // STATUS ?>
	<div id="r_STATUS" class="form-group">
		<label id="elh_m_pasien_STATUS" for="x_STATUS" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_STATUS" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->STATUS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->STATUS->CellAttributes() ?>>
<script id="tpx_m_pasien_STATUS" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_STATUS">
<select data-table="m_pasien" data-field="x_STATUS" data-value-separator="<?php echo $m_pasien->STATUS->DisplayValueSeparatorAttribute() ?>" id="x_STATUS" name="x_STATUS"<?php echo $m_pasien->STATUS->EditAttributes() ?>>
<?php echo $m_pasien->STATUS->SelectOptionListHtml("x_STATUS") ?>
</select>
<input type="hidden" name="s_x_STATUS" id="s_x_STATUS" value="<?php echo $m_pasien->STATUS->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->STATUS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->AGAMA->Visible) { // AGAMA ?>
	<div id="r_AGAMA" class="form-group">
		<label id="elh_m_pasien_AGAMA" for="x_AGAMA" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_AGAMA" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->AGAMA->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->AGAMA->CellAttributes() ?>>
<script id="tpx_m_pasien_AGAMA" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_AGAMA">
<select data-table="m_pasien" data-field="x_AGAMA" data-value-separator="<?php echo $m_pasien->AGAMA->DisplayValueSeparatorAttribute() ?>" id="x_AGAMA" name="x_AGAMA"<?php echo $m_pasien->AGAMA->EditAttributes() ?>>
<?php echo $m_pasien->AGAMA->SelectOptionListHtml("x_AGAMA") ?>
</select>
<input type="hidden" name="s_x_AGAMA" id="s_x_AGAMA" value="<?php echo $m_pasien->AGAMA->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->AGAMA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->PENDIDIKAN->Visible) { // PENDIDIKAN ?>
	<div id="r_PENDIDIKAN" class="form-group">
		<label id="elh_m_pasien_PENDIDIKAN" for="x_PENDIDIKAN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_PENDIDIKAN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->PENDIDIKAN->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->PENDIDIKAN->CellAttributes() ?>>
<script id="tpx_m_pasien_PENDIDIKAN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_PENDIDIKAN">
<select data-table="m_pasien" data-field="x_PENDIDIKAN" data-value-separator="<?php echo $m_pasien->PENDIDIKAN->DisplayValueSeparatorAttribute() ?>" id="x_PENDIDIKAN" name="x_PENDIDIKAN"<?php echo $m_pasien->PENDIDIKAN->EditAttributes() ?>>
<?php echo $m_pasien->PENDIDIKAN->SelectOptionListHtml("x_PENDIDIKAN") ?>
</select>
<input type="hidden" name="s_x_PENDIDIKAN" id="s_x_PENDIDIKAN" value="<?php echo $m_pasien->PENDIDIKAN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->PENDIDIKAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<div id="r_KDCARABAYAR" class="form-group">
		<label id="elh_m_pasien_KDCARABAYAR" for="x_KDCARABAYAR" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_KDCARABAYAR" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->KDCARABAYAR->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->KDCARABAYAR->CellAttributes() ?>>
<script id="tpx_m_pasien_KDCARABAYAR" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_KDCARABAYAR">
<select data-table="m_pasien" data-field="x_KDCARABAYAR" data-value-separator="<?php echo $m_pasien->KDCARABAYAR->DisplayValueSeparatorAttribute() ?>" id="x_KDCARABAYAR" name="x_KDCARABAYAR"<?php echo $m_pasien->KDCARABAYAR->EditAttributes() ?>>
<?php echo $m_pasien->KDCARABAYAR->SelectOptionListHtml("x_KDCARABAYAR") ?>
</select>
<input type="hidden" name="s_x_KDCARABAYAR" id="s_x_KDCARABAYAR" value="<?php echo $m_pasien->KDCARABAYAR->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->KDCARABAYAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_m_pasien_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_NIP" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->NIP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->NIP->CellAttributes() ?>>
<script id="tpx_m_pasien_NIP" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_NIP">
<input type="text" data-table="m_pasien" data-field="x_NIP" name="x_NIP" id="x_NIP" size="30" maxlength="16" placeholder="<?php echo ew_HtmlEncode($m_pasien->NIP->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NIP->EditValue ?>"<?php echo $m_pasien->NIP->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->TGLDAFTAR->Visible) { // TGLDAFTAR ?>
	<div id="r_TGLDAFTAR" class="form-group">
		<label id="elh_m_pasien_TGLDAFTAR" for="x_TGLDAFTAR" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_TGLDAFTAR" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->TGLDAFTAR->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->TGLDAFTAR->CellAttributes() ?>>
<script id="tpx_m_pasien_TGLDAFTAR" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_TGLDAFTAR">
<input type="text" data-table="m_pasien" data-field="x_TGLDAFTAR" data-format="7" name="x_TGLDAFTAR" id="x_TGLDAFTAR" placeholder="<?php echo ew_HtmlEncode($m_pasien->TGLDAFTAR->getPlaceHolder()) ?>" value="<?php echo $m_pasien->TGLDAFTAR->EditValue ?>"<?php echo $m_pasien->TGLDAFTAR->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->TGLDAFTAR->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->ALAMAT_KTP->Visible) { // ALAMAT_KTP ?>
	<div id="r_ALAMAT_KTP" class="form-group">
		<label id="elh_m_pasien_ALAMAT_KTP" for="x_ALAMAT_KTP" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_ALAMAT_KTP" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->ALAMAT_KTP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->ALAMAT_KTP->CellAttributes() ?>>
<script id="tpx_m_pasien_ALAMAT_KTP" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_ALAMAT_KTP">
<input type="text" data-table="m_pasien" data-field="x_ALAMAT_KTP" name="x_ALAMAT_KTP" id="x_ALAMAT_KTP" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($m_pasien->ALAMAT_KTP->getPlaceHolder()) ?>" value="<?php echo $m_pasien->ALAMAT_KTP->EditValue ?>"<?php echo $m_pasien->ALAMAT_KTP->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->ALAMAT_KTP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_NAMA->Visible) { // PENANGGUNGJAWAB_NAMA ?>
	<div id="r_PENANGGUNGJAWAB_NAMA" class="form-group">
		<label id="elh_m_pasien_PENANGGUNGJAWAB_NAMA" for="x_PENANGGUNGJAWAB_NAMA" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_PENANGGUNGJAWAB_NAMA" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->CellAttributes() ?>>
<script id="tpx_m_pasien_PENANGGUNGJAWAB_NAMA" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_PENANGGUNGJAWAB_NAMA">
<input type="text" data-table="m_pasien" data-field="x_PENANGGUNGJAWAB_NAMA" name="x_PENANGGUNGJAWAB_NAMA" id="x_PENANGGUNGJAWAB_NAMA" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($m_pasien->PENANGGUNGJAWAB_NAMA->getPlaceHolder()) ?>" value="<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->EditValue ?>"<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_HUBUNGAN->Visible) { // PENANGGUNGJAWAB_HUBUNGAN ?>
	<div id="r_PENANGGUNGJAWAB_HUBUNGAN" class="form-group">
		<label id="elh_m_pasien_PENANGGUNGJAWAB_HUBUNGAN" for="x_PENANGGUNGJAWAB_HUBUNGAN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_PENANGGUNGJAWAB_HUBUNGAN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->CellAttributes() ?>>
<script id="tpx_m_pasien_PENANGGUNGJAWAB_HUBUNGAN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_PENANGGUNGJAWAB_HUBUNGAN">
<input type="text" data-table="m_pasien" data-field="x_PENANGGUNGJAWAB_HUBUNGAN" name="x_PENANGGUNGJAWAB_HUBUNGAN" id="x_PENANGGUNGJAWAB_HUBUNGAN" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($m_pasien->PENANGGUNGJAWAB_HUBUNGAN->getPlaceHolder()) ?>" value="<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->EditValue ?>"<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_ALAMAT->Visible) { // PENANGGUNGJAWAB_ALAMAT ?>
	<div id="r_PENANGGUNGJAWAB_ALAMAT" class="form-group">
		<label id="elh_m_pasien_PENANGGUNGJAWAB_ALAMAT" for="x_PENANGGUNGJAWAB_ALAMAT" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_PENANGGUNGJAWAB_ALAMAT" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->CellAttributes() ?>>
<script id="tpx_m_pasien_PENANGGUNGJAWAB_ALAMAT" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_PENANGGUNGJAWAB_ALAMAT">
<input type="text" data-table="m_pasien" data-field="x_PENANGGUNGJAWAB_ALAMAT" name="x_PENANGGUNGJAWAB_ALAMAT" id="x_PENANGGUNGJAWAB_ALAMAT" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($m_pasien->PENANGGUNGJAWAB_ALAMAT->getPlaceHolder()) ?>" value="<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->EditValue ?>"<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_PHONE->Visible) { // PENANGGUNGJAWAB_PHONE ?>
	<div id="r_PENANGGUNGJAWAB_PHONE" class="form-group">
		<label id="elh_m_pasien_PENANGGUNGJAWAB_PHONE" for="x_PENANGGUNGJAWAB_PHONE" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_PENANGGUNGJAWAB_PHONE" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->CellAttributes() ?>>
<script id="tpx_m_pasien_PENANGGUNGJAWAB_PHONE" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_PENANGGUNGJAWAB_PHONE">
<input type="text" data-table="m_pasien" data-field="x_PENANGGUNGJAWAB_PHONE" name="x_PENANGGUNGJAWAB_PHONE" id="x_PENANGGUNGJAWAB_PHONE" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($m_pasien->PENANGGUNGJAWAB_PHONE->getPlaceHolder()) ?>" value="<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->EditValue ?>"<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->NO_KARTU->Visible) { // NO_KARTU ?>
	<div id="r_NO_KARTU" class="form-group">
		<label id="elh_m_pasien_NO_KARTU" for="x_NO_KARTU" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_NO_KARTU" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->NO_KARTU->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->NO_KARTU->CellAttributes() ?>>
<script id="tpx_m_pasien_NO_KARTU" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_NO_KARTU">
<input type="text" data-table="m_pasien" data-field="x_NO_KARTU" name="x_NO_KARTU" id="x_NO_KARTU" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($m_pasien->NO_KARTU->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NO_KARTU->EditValue ?>"<?php echo $m_pasien->NO_KARTU->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->NO_KARTU->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->JNS_PASIEN->Visible) { // JNS_PASIEN ?>
	<div id="r_JNS_PASIEN" class="form-group">
		<label id="elh_m_pasien_JNS_PASIEN" for="x_JNS_PASIEN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_JNS_PASIEN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->JNS_PASIEN->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->JNS_PASIEN->CellAttributes() ?>>
<script id="tpx_m_pasien_JNS_PASIEN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_JNS_PASIEN">
<select data-table="m_pasien" data-field="x_JNS_PASIEN" data-value-separator="<?php echo $m_pasien->JNS_PASIEN->DisplayValueSeparatorAttribute() ?>" id="x_JNS_PASIEN" name="x_JNS_PASIEN"<?php echo $m_pasien->JNS_PASIEN->EditAttributes() ?>>
<?php echo $m_pasien->JNS_PASIEN->SelectOptionListHtml("x_JNS_PASIEN") ?>
</select>
<input type="hidden" name="s_x_JNS_PASIEN" id="s_x_JNS_PASIEN" value="<?php echo $m_pasien->JNS_PASIEN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->JNS_PASIEN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->nama_ayah->Visible) { // nama_ayah ?>
	<div id="r_nama_ayah" class="form-group">
		<label id="elh_m_pasien_nama_ayah" for="x_nama_ayah" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_nama_ayah" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->nama_ayah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->nama_ayah->CellAttributes() ?>>
<script id="tpx_m_pasien_nama_ayah" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_nama_ayah">
<input type="text" data-table="m_pasien" data-field="x_nama_ayah" name="x_nama_ayah" id="x_nama_ayah" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->nama_ayah->getPlaceHolder()) ?>" value="<?php echo $m_pasien->nama_ayah->EditValue ?>"<?php echo $m_pasien->nama_ayah->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->nama_ayah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->nama_ibu->Visible) { // nama_ibu ?>
	<div id="r_nama_ibu" class="form-group">
		<label id="elh_m_pasien_nama_ibu" for="x_nama_ibu" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_nama_ibu" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->nama_ibu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->nama_ibu->CellAttributes() ?>>
<script id="tpx_m_pasien_nama_ibu" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_nama_ibu">
<input type="text" data-table="m_pasien" data-field="x_nama_ibu" name="x_nama_ibu" id="x_nama_ibu" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->nama_ibu->getPlaceHolder()) ?>" value="<?php echo $m_pasien->nama_ibu->EditValue ?>"<?php echo $m_pasien->nama_ibu->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->nama_ibu->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->nama_suami->Visible) { // nama_suami ?>
	<div id="r_nama_suami" class="form-group">
		<label id="elh_m_pasien_nama_suami" for="x_nama_suami" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_nama_suami" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->nama_suami->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->nama_suami->CellAttributes() ?>>
<script id="tpx_m_pasien_nama_suami" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_nama_suami">
<input type="text" data-table="m_pasien" data-field="x_nama_suami" name="x_nama_suami" id="x_nama_suami" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->nama_suami->getPlaceHolder()) ?>" value="<?php echo $m_pasien->nama_suami->EditValue ?>"<?php echo $m_pasien->nama_suami->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->nama_suami->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->nama_istri->Visible) { // nama_istri ?>
	<div id="r_nama_istri" class="form-group">
		<label id="elh_m_pasien_nama_istri" for="x_nama_istri" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_nama_istri" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->nama_istri->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->nama_istri->CellAttributes() ?>>
<script id="tpx_m_pasien_nama_istri" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_nama_istri">
<input type="text" data-table="m_pasien" data-field="x_nama_istri" name="x_nama_istri" id="x_nama_istri" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->nama_istri->getPlaceHolder()) ?>" value="<?php echo $m_pasien->nama_istri->EditValue ?>"<?php echo $m_pasien->nama_istri->EditAttributes() ?>>
</span>
</script>
<?php echo $m_pasien->nama_istri->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->KD_ETNIS->Visible) { // KD_ETNIS ?>
	<div id="r_KD_ETNIS" class="form-group">
		<label id="elh_m_pasien_KD_ETNIS" for="x_KD_ETNIS" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_KD_ETNIS" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->KD_ETNIS->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->KD_ETNIS->CellAttributes() ?>>
<script id="tpx_m_pasien_KD_ETNIS" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_KD_ETNIS">
<select data-table="m_pasien" data-field="x_KD_ETNIS" data-value-separator="<?php echo $m_pasien->KD_ETNIS->DisplayValueSeparatorAttribute() ?>" id="x_KD_ETNIS" name="x_KD_ETNIS"<?php echo $m_pasien->KD_ETNIS->EditAttributes() ?>>
<?php echo $m_pasien->KD_ETNIS->SelectOptionListHtml("x_KD_ETNIS") ?>
</select>
<input type="hidden" name="s_x_KD_ETNIS" id="s_x_KD_ETNIS" value="<?php echo $m_pasien->KD_ETNIS->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->KD_ETNIS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->KD_BHS_HARIAN->Visible) { // KD_BHS_HARIAN ?>
	<div id="r_KD_BHS_HARIAN" class="form-group">
		<label id="elh_m_pasien_KD_BHS_HARIAN" for="x_KD_BHS_HARIAN" class="col-sm-2 control-label ewLabel"><script id="tpc_m_pasien_KD_BHS_HARIAN" class="m_pasienadd" type="text/html"><span><?php echo $m_pasien->KD_BHS_HARIAN->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $m_pasien->KD_BHS_HARIAN->CellAttributes() ?>>
<script id="tpx_m_pasien_KD_BHS_HARIAN" class="m_pasienadd" type="text/html">
<span id="el_m_pasien_KD_BHS_HARIAN">
<select data-table="m_pasien" data-field="x_KD_BHS_HARIAN" data-value-separator="<?php echo $m_pasien->KD_BHS_HARIAN->DisplayValueSeparatorAttribute() ?>" id="x_KD_BHS_HARIAN" name="x_KD_BHS_HARIAN"<?php echo $m_pasien->KD_BHS_HARIAN->EditAttributes() ?>>
<?php echo $m_pasien->KD_BHS_HARIAN->SelectOptionListHtml("x_KD_BHS_HARIAN") ?>
</select>
<input type="hidden" name="s_x_KD_BHS_HARIAN" id="s_x_KD_BHS_HARIAN" value="<?php echo $m_pasien->KD_BHS_HARIAN->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $m_pasien->KD_BHS_HARIAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_pasien_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_pasien_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_m_pasienadd", "tpm_m_pasienadd", "m_pasienadd", "<?php echo $m_pasien->CustomExport ?>");
jQuery("script.m_pasienadd_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
fm_pasienadd.Init();
</script>
<?php
$m_pasien_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

$("#x_NOTELP").keyup(function () {
	   let NOTELP = $("#x_NOTELP").val();
	   $("#x_PENANGGUNGJAWAB_PHONE").val(NOTELP);
});
$("#x_ALAMAT").keyup(function () {
	   let ALAMAT = $("#x_ALAMAT").val();
	   $("#x_ALAMAT_KTP").val(ALAMAT);
});
</script>
<?php include_once "footer.php" ?>
<?php
$m_pasien_add->Page_Terminate();
?>
