<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_list_pasien_rawat_jalaninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_list_pasien_rawat_jalan_view = NULL; // Initialize page object first

class cvw_list_pasien_rawat_jalan_view extends cvw_list_pasien_rawat_jalan {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_list_pasien_rawat_jalan';

	// Page object name
	var $PageObjName = 'vw_list_pasien_rawat_jalan_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (vw_list_pasien_rawat_jalan)
		if (!isset($GLOBALS["vw_list_pasien_rawat_jalan"]) || get_class($GLOBALS["vw_list_pasien_rawat_jalan"]) == "cvw_list_pasien_rawat_jalan") {
			$GLOBALS["vw_list_pasien_rawat_jalan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_list_pasien_rawat_jalan"];
		}
		$KeyUrl = "";
		if (@$_GET["IDXDAFTAR"] <> "") {
			$this->RecKey["IDXDAFTAR"] = $_GET["IDXDAFTAR"];
			$KeyUrl .= "&amp;IDXDAFTAR=" . urlencode($this->RecKey["IDXDAFTAR"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_list_pasien_rawat_jalan', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (m_login)
		if (!isset($UserTable)) {
			$UserTable = new cm_login();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("vw_list_pasien_rawat_jalanlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->IDXDAFTAR->SetVisibility();
		$this->TGLREG->SetVisibility();
		$this->NOMR->SetVisibility();
		$this->KETERANGAN->SetVisibility();
		$this->NOKARTU_BPJS->SetVisibility();
		$this->NOKTP->SetVisibility();
		$this->KDDOKTER->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->KDRUJUK->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->NOJAMINAN->SetVisibility();
		$this->SHIFT->SetVisibility();
		$this->STATUS->SetVisibility();
		$this->KETERANGAN_STATUS->SetVisibility();
		$this->PASIENBARU->SetVisibility();
		$this->NIP->SetVisibility();
		$this->MASUKPOLY->SetVisibility();
		$this->KELUARPOLY->SetVisibility();
		$this->KETRUJUK->SetVisibility();
		$this->KETBAYAR->SetVisibility();
		$this->PENANGGUNGJAWAB_NAMA->SetVisibility();
		$this->PENANGGUNGJAWAB_HUBUNGAN->SetVisibility();
		$this->PENANGGUNGJAWAB_ALAMAT->SetVisibility();
		$this->PENANGGUNGJAWAB_PHONE->SetVisibility();
		$this->JAMREG->SetVisibility();
		$this->BATAL->SetVisibility();
		$this->NO_SJP->SetVisibility();
		$this->NO_PESERTA->SetVisibility();
		$this->NOKARTU->SetVisibility();
		$this->TANGGAL_SEP->SetVisibility();
		$this->TANGGALRUJUK_SEP->SetVisibility();
		$this->KELASRAWAT_SEP->SetVisibility();
		$this->MINTA_RUJUKAN->SetVisibility();
		$this->NORUJUKAN_SEP->SetVisibility();
		$this->PPKRUJUKANASAL_SEP->SetVisibility();
		$this->NAMAPPKRUJUKANASAL_SEP->SetVisibility();
		$this->PPKPELAYANAN_SEP->SetVisibility();
		$this->JENISPERAWATAN_SEP->SetVisibility();
		$this->CATATAN_SEP->SetVisibility();
		$this->DIAGNOSAAWAL_SEP->SetVisibility();
		$this->NAMADIAGNOSA_SEP->SetVisibility();
		$this->LAKALANTAS_SEP->SetVisibility();
		$this->LOKASILAKALANTAS->SetVisibility();
		$this->USER->SetVisibility();
		$this->tanggal->SetVisibility();
		$this->bulan->SetVisibility();
		$this->tahun->SetVisibility();

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
		global $EW_EXPORT, $vw_list_pasien_rawat_jalan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_list_pasien_rawat_jalan);
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["IDXDAFTAR"] <> "") {
				$this->IDXDAFTAR->setQueryStringValue($_GET["IDXDAFTAR"]);
				$this->RecKey["IDXDAFTAR"] = $this->IDXDAFTAR->QueryStringValue;
			} elseif (@$_POST["IDXDAFTAR"] <> "") {
				$this->IDXDAFTAR->setFormValue($_POST["IDXDAFTAR"]);
				$this->RecKey["IDXDAFTAR"] = $this->IDXDAFTAR->FormValue;
			} else {
				$sReturnUrl = "vw_list_pasien_rawat_jalanlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "vw_list_pasien_rawat_jalanlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "vw_list_pasien_rawat_jalanlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->KETERANGAN->setDbValue($rs->fields('KETERANGAN'));
		$this->NOKARTU_BPJS->setDbValue($rs->fields('NOKARTU_BPJS'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NOJAMINAN->setDbValue($rs->fields('NOJAMINAN'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->KETERANGAN_STATUS->setDbValue($rs->fields('KETERANGAN_STATUS'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
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
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->bulan->setDbValue($rs->fields('bulan'));
		$this->tahun->setDbValue($rs->fields('tahun'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->IDXDAFTAR->DbValue = $row['IDXDAFTAR'];
		$this->TGLREG->DbValue = $row['TGLREG'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->KETERANGAN->DbValue = $row['KETERANGAN'];
		$this->NOKARTU_BPJS->DbValue = $row['NOKARTU_BPJS'];
		$this->NOKTP->DbValue = $row['NOKTP'];
		$this->KDDOKTER->DbValue = $row['KDDOKTER'];
		$this->KDPOLY->DbValue = $row['KDPOLY'];
		$this->KDRUJUK->DbValue = $row['KDRUJUK'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NOJAMINAN->DbValue = $row['NOJAMINAN'];
		$this->SHIFT->DbValue = $row['SHIFT'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->KETERANGAN_STATUS->DbValue = $row['KETERANGAN_STATUS'];
		$this->PASIENBARU->DbValue = $row['PASIENBARU'];
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
		$this->tanggal->DbValue = $row['tanggal'];
		$this->bulan->DbValue = $row['bulan'];
		$this->tahun->DbValue = $row['tahun'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXDAFTAR
		// TGLREG
		// NOMR
		// KETERANGAN
		// NOKARTU_BPJS
		// NOKTP
		// KDDOKTER
		// KDPOLY
		// KDRUJUK
		// KDCARABAYAR
		// NOJAMINAN
		// SHIFT
		// STATUS
		// KETERANGAN_STATUS
		// PASIENBARU
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
		// tanggal
		// bulan
		// tahun

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
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
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// KETERANGAN
		$this->KETERANGAN->ViewValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->ViewCustomAttributes = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->ViewValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// KDDOKTER
		$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
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
		$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
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
		$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
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

		// NOJAMINAN
		$this->NOJAMINAN->ViewValue = $this->NOJAMINAN->CurrentValue;
		$this->NOJAMINAN->ViewCustomAttributes = "";

		// SHIFT
		$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
		$this->SHIFT->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->ViewValue = $this->KETERANGAN_STATUS->CurrentValue;
		$this->KETERANGAN_STATUS->ViewCustomAttributes = "";

		// PASIENBARU
		$this->PASIENBARU->ViewValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// MASUKPOLY
		$this->MASUKPOLY->ViewValue = $this->MASUKPOLY->CurrentValue;
		$this->MASUKPOLY->ViewValue = ew_FormatDateTime($this->MASUKPOLY->ViewValue, 4);
		$this->MASUKPOLY->ViewCustomAttributes = "";

		// KELUARPOLY
		$this->KELUARPOLY->ViewValue = $this->KELUARPOLY->CurrentValue;
		$this->KELUARPOLY->ViewValue = ew_FormatDateTime($this->KELUARPOLY->ViewValue, 4);
		$this->KELUARPOLY->ViewCustomAttributes = "";

		// KETRUJUK
		$this->KETRUJUK->ViewValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// KETBAYAR
		$this->KETBAYAR->ViewValue = $this->KETBAYAR->CurrentValue;
		$this->KETBAYAR->ViewCustomAttributes = "";

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

		// JAMREG
		$this->JAMREG->ViewValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->ViewValue = ew_FormatDateTime($this->JAMREG->ViewValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// BATAL
		$this->BATAL->ViewValue = $this->BATAL->CurrentValue;
		$this->BATAL->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NO_PESERTA
		$this->NO_PESERTA->ViewValue = $this->NO_PESERTA->CurrentValue;
		$this->NO_PESERTA->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->ViewValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->ViewValue = ew_FormatDateTime($this->TANGGAL_SEP->ViewValue, 0);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->ViewValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->ViewValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->ViewValue, 0);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->ViewValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->ViewValue = $this->MINTA_RUJUKAN->CurrentValue;
		$this->MINTA_RUJUKAN->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->ViewValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->ViewValue = $this->PPKRUJUKANASAL_SEP->CurrentValue;
		$this->PPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->ViewValue = $this->NAMAPPKRUJUKANASAL_SEP->CurrentValue;
		$this->NAMAPPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->ViewValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->CurrentValue;
		$this->JENISPERAWATAN_SEP->ViewCustomAttributes = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->ViewValue = $this->CATATAN_SEP->CurrentValue;
		$this->CATATAN_SEP->ViewCustomAttributes = "";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		$this->DIAGNOSAAWAL_SEP->ViewCustomAttributes = "";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->ViewValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->ViewCustomAttributes = "";

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->CurrentValue;
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->ViewValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->ViewValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewCustomAttributes = "";

		// bulan
		if (strval($this->bulan->CurrentValue) <> "") {
			$sFilterWrk = "`bulan_id`" . ew_SearchString("=", $this->bulan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `bulan_id`, `bulan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_bulan`";
		$sWhereWrk = "";
		$this->bulan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bulan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bulan->ViewValue = $this->bulan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bulan->ViewValue = $this->bulan->CurrentValue;
			}
		} else {
			$this->bulan->ViewValue = NULL;
		}
		$this->bulan->ViewCustomAttributes = "";

		// tahun
		$this->tahun->ViewValue = $this->tahun->CurrentValue;
		$this->tahun->ViewCustomAttributes = "";

			// IDXDAFTAR
			$this->IDXDAFTAR->LinkCustomAttributes = "";
			$this->IDXDAFTAR->HrefValue = "";
			$this->IDXDAFTAR->TooltipValue = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// KETERANGAN
			$this->KETERANGAN->LinkCustomAttributes = "";
			$this->KETERANGAN->HrefValue = "";
			$this->KETERANGAN->TooltipValue = "";

			// NOKARTU_BPJS
			$this->NOKARTU_BPJS->LinkCustomAttributes = "";
			$this->NOKARTU_BPJS->HrefValue = "";
			$this->NOKARTU_BPJS->TooltipValue = "";

			// NOKTP
			$this->NOKTP->LinkCustomAttributes = "";
			$this->NOKTP->HrefValue = "";
			$this->NOKTP->TooltipValue = "";

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

			// NOJAMINAN
			$this->NOJAMINAN->LinkCustomAttributes = "";
			$this->NOJAMINAN->HrefValue = "";
			$this->NOJAMINAN->TooltipValue = "";

			// SHIFT
			$this->SHIFT->LinkCustomAttributes = "";
			$this->SHIFT->HrefValue = "";
			$this->SHIFT->TooltipValue = "";

			// STATUS
			$this->STATUS->LinkCustomAttributes = "";
			$this->STATUS->HrefValue = "";
			$this->STATUS->TooltipValue = "";

			// KETERANGAN_STATUS
			$this->KETERANGAN_STATUS->LinkCustomAttributes = "";
			$this->KETERANGAN_STATUS->HrefValue = "";
			$this->KETERANGAN_STATUS->TooltipValue = "";

			// PASIENBARU
			$this->PASIENBARU->LinkCustomAttributes = "";
			$this->PASIENBARU->HrefValue = "";
			$this->PASIENBARU->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// MASUKPOLY
			$this->MASUKPOLY->LinkCustomAttributes = "";
			$this->MASUKPOLY->HrefValue = "";
			$this->MASUKPOLY->TooltipValue = "";

			// KELUARPOLY
			$this->KELUARPOLY->LinkCustomAttributes = "";
			$this->KELUARPOLY->HrefValue = "";
			$this->KELUARPOLY->TooltipValue = "";

			// KETRUJUK
			$this->KETRUJUK->LinkCustomAttributes = "";
			$this->KETRUJUK->HrefValue = "";
			$this->KETRUJUK->TooltipValue = "";

			// KETBAYAR
			$this->KETBAYAR->LinkCustomAttributes = "";
			$this->KETBAYAR->HrefValue = "";
			$this->KETBAYAR->TooltipValue = "";

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

			// JAMREG
			$this->JAMREG->LinkCustomAttributes = "";
			$this->JAMREG->HrefValue = "";
			$this->JAMREG->TooltipValue = "";

			// BATAL
			$this->BATAL->LinkCustomAttributes = "";
			$this->BATAL->HrefValue = "";
			$this->BATAL->TooltipValue = "";

			// NO_SJP
			$this->NO_SJP->LinkCustomAttributes = "";
			$this->NO_SJP->HrefValue = "";
			$this->NO_SJP->TooltipValue = "";

			// NO_PESERTA
			$this->NO_PESERTA->LinkCustomAttributes = "";
			$this->NO_PESERTA->HrefValue = "";
			$this->NO_PESERTA->TooltipValue = "";

			// NOKARTU
			$this->NOKARTU->LinkCustomAttributes = "";
			$this->NOKARTU->HrefValue = "";
			$this->NOKARTU->TooltipValue = "";

			// TANGGAL_SEP
			$this->TANGGAL_SEP->LinkCustomAttributes = "";
			$this->TANGGAL_SEP->HrefValue = "";
			$this->TANGGAL_SEP->TooltipValue = "";

			// TANGGALRUJUK_SEP
			$this->TANGGALRUJUK_SEP->LinkCustomAttributes = "";
			$this->TANGGALRUJUK_SEP->HrefValue = "";
			$this->TANGGALRUJUK_SEP->TooltipValue = "";

			// KELASRAWAT_SEP
			$this->KELASRAWAT_SEP->LinkCustomAttributes = "";
			$this->KELASRAWAT_SEP->HrefValue = "";
			$this->KELASRAWAT_SEP->TooltipValue = "";

			// MINTA_RUJUKAN
			$this->MINTA_RUJUKAN->LinkCustomAttributes = "";
			$this->MINTA_RUJUKAN->HrefValue = "";
			$this->MINTA_RUJUKAN->TooltipValue = "";

			// NORUJUKAN_SEP
			$this->NORUJUKAN_SEP->LinkCustomAttributes = "";
			$this->NORUJUKAN_SEP->HrefValue = "";
			$this->NORUJUKAN_SEP->TooltipValue = "";

			// PPKRUJUKANASAL_SEP
			$this->PPKRUJUKANASAL_SEP->LinkCustomAttributes = "";
			$this->PPKRUJUKANASAL_SEP->HrefValue = "";
			$this->PPKRUJUKANASAL_SEP->TooltipValue = "";

			// NAMAPPKRUJUKANASAL_SEP
			$this->NAMAPPKRUJUKANASAL_SEP->LinkCustomAttributes = "";
			$this->NAMAPPKRUJUKANASAL_SEP->HrefValue = "";
			$this->NAMAPPKRUJUKANASAL_SEP->TooltipValue = "";

			// PPKPELAYANAN_SEP
			$this->PPKPELAYANAN_SEP->LinkCustomAttributes = "";
			$this->PPKPELAYANAN_SEP->HrefValue = "";
			$this->PPKPELAYANAN_SEP->TooltipValue = "";

			// JENISPERAWATAN_SEP
			$this->JENISPERAWATAN_SEP->LinkCustomAttributes = "";
			$this->JENISPERAWATAN_SEP->HrefValue = "";
			$this->JENISPERAWATAN_SEP->TooltipValue = "";

			// CATATAN_SEP
			$this->CATATAN_SEP->LinkCustomAttributes = "";
			$this->CATATAN_SEP->HrefValue = "";
			$this->CATATAN_SEP->TooltipValue = "";

			// DIAGNOSAAWAL_SEP
			$this->DIAGNOSAAWAL_SEP->LinkCustomAttributes = "";
			$this->DIAGNOSAAWAL_SEP->HrefValue = "";
			$this->DIAGNOSAAWAL_SEP->TooltipValue = "";

			// NAMADIAGNOSA_SEP
			$this->NAMADIAGNOSA_SEP->LinkCustomAttributes = "";
			$this->NAMADIAGNOSA_SEP->HrefValue = "";
			$this->NAMADIAGNOSA_SEP->TooltipValue = "";

			// LAKALANTAS_SEP
			$this->LAKALANTAS_SEP->LinkCustomAttributes = "";
			$this->LAKALANTAS_SEP->HrefValue = "";
			$this->LAKALANTAS_SEP->TooltipValue = "";

			// LOKASILAKALANTAS
			$this->LOKASILAKALANTAS->LinkCustomAttributes = "";
			$this->LOKASILAKALANTAS->HrefValue = "";
			$this->LOKASILAKALANTAS->TooltipValue = "";

			// USER
			$this->USER->LinkCustomAttributes = "";
			$this->USER->HrefValue = "";
			$this->USER->TooltipValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// bulan
			$this->bulan->LinkCustomAttributes = "";
			$this->bulan->HrefValue = "";
			$this->bulan->TooltipValue = "";

			// tahun
			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";
			$this->tahun->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_list_pasien_rawat_jalanlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($vw_list_pasien_rawat_jalan_view)) $vw_list_pasien_rawat_jalan_view = new cvw_list_pasien_rawat_jalan_view();

// Page init
$vw_list_pasien_rawat_jalan_view->Page_Init();

// Page main
$vw_list_pasien_rawat_jalan_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_list_pasien_rawat_jalan_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fvw_list_pasien_rawat_jalanview = new ew_Form("fvw_list_pasien_rawat_jalanview", "view");

// Form_CustomValidate event
fvw_list_pasien_rawat_jalanview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_list_pasien_rawat_jalanview.ValidateRequired = true;
<?php } else { ?>
fvw_list_pasien_rawat_jalanview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_list_pasien_rawat_jalanview.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_list_pasien_rawat_jalanview.Lists["x_KDDOKTER"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
fvw_list_pasien_rawat_jalanview.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_list_pasien_rawat_jalanview.Lists["x_KDRUJUK"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
fvw_list_pasien_rawat_jalanview.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_list_pasien_rawat_jalanview.Lists["x_bulan"] = {"LinkField":"x_bulan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bulan_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_bulan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_list_pasien_rawat_jalan_view->IsModal) { ?>
<?php } ?>
<?php $vw_list_pasien_rawat_jalan_view->ExportOptions->Render("body") ?>
<?php
	foreach ($vw_list_pasien_rawat_jalan_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$vw_list_pasien_rawat_jalan_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $vw_list_pasien_rawat_jalan_view->ShowPageHeader(); ?>
<?php
$vw_list_pasien_rawat_jalan_view->ShowMessage();
?>
<form name="fvw_list_pasien_rawat_jalanview" id="fvw_list_pasien_rawat_jalanview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_list_pasien_rawat_jalan_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_list_pasien_rawat_jalan_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_list_pasien_rawat_jalan">
<?php if ($vw_list_pasien_rawat_jalan_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($vw_list_pasien_rawat_jalan->IDXDAFTAR->Visible) { // IDXDAFTAR ?>
	<tr id="r_IDXDAFTAR">
		<td><span id="elh_vw_list_pasien_rawat_jalan_IDXDAFTAR"><?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->FldCaption() ?></span></td>
		<td data-name="IDXDAFTAR"<?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->CellAttributes() ?>>
<div id="orig_vw_list_pasien_rawat_jalan_IDXDAFTAR" class="hide">
<span id="el_vw_list_pasien_rawat_jalan_IDXDAFTAR">
<span<?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->IDXDAFTAR->ViewValue ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r==4)
{ ?>
<a class="btn btn-success btn-xs"  
target="_self" 
href="vw_list_pasien_rawat_jalanedit.php?IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>">
ORDER RAWAT INAP <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_label_pasien_rajal.php?idx=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>&nomr=<?php echo urlencode(CurrentPage()->NOMR->CurrentValue)?>">
Cetak Label(Modul Sementara)<span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<a class="btn btn-success btn-xs"  
target="_blank" 
href="cetak_gelang_pasien_ranap.php?idx=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>&nomr=<?php echo urlencode(CurrentPage()->NOMR->CurrentValue)?>">
Cetak Gelang (Modul Sementara)<span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<?php
}else {
?>
<a class="btn btn-success btn-xs"  
target="_self" 
href="vw_list_pasien_rawat_jalanedit.php?IDXDAFTAR=<?php echo urlencode(CurrentPage()->IDXDAFTAR->CurrentValue)?>">
ORDER RAWAT INAP <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<?php
}
?>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->TGLREG->Visible) { // TGLREG ?>
	<tr id="r_TGLREG">
		<td><span id="elh_vw_list_pasien_rawat_jalan_TGLREG"><?php echo $vw_list_pasien_rawat_jalan->TGLREG->FldCaption() ?></span></td>
		<td data-name="TGLREG"<?php echo $vw_list_pasien_rawat_jalan->TGLREG->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_TGLREG">
<span<?php echo $vw_list_pasien_rawat_jalan->TGLREG->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->TGLREG->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NOMR->Visible) { // NOMR ?>
	<tr id="r_NOMR">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NOMR"><?php echo $vw_list_pasien_rawat_jalan->NOMR->FldCaption() ?></span></td>
		<td data-name="NOMR"<?php echo $vw_list_pasien_rawat_jalan->NOMR->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NOMR">
<span<?php echo $vw_list_pasien_rawat_jalan->NOMR->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NOMR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KETERANGAN->Visible) { // KETERANGAN ?>
	<tr id="r_KETERANGAN">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KETERANGAN"><?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->FldCaption() ?></span></td>
		<td data-name="KETERANGAN"<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KETERANGAN">
<span<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NOKARTU_BPJS->Visible) { // NOKARTU_BPJS ?>
	<tr id="r_NOKARTU_BPJS">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NOKARTU_BPJS"><?php echo $vw_list_pasien_rawat_jalan->NOKARTU_BPJS->FldCaption() ?></span></td>
		<td data-name="NOKARTU_BPJS"<?php echo $vw_list_pasien_rawat_jalan->NOKARTU_BPJS->CellAttributes() ?>>
<div id="orig_vw_list_pasien_rawat_jalan_NOKARTU_BPJS" class="hide">
<span id="el_vw_list_pasien_rawat_jalan_NOKARTU_BPJS">
<span<?php echo $vw_list_pasien_rawat_jalan->NOKARTU_BPJS->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NOKARTU_BPJS->ViewValue ?></span>
</span>
</div>
<?php

//print ew_ExecuteScalar("SELECT NAMA FROM simrs2012.m_pasien where nomr = ".urlencode(CurrentPage()->NOMR->CurrentValue)." limit 1 ");
//echo $MyField;

?>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NOKTP->Visible) { // NOKTP ?>
	<tr id="r_NOKTP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NOKTP"><?php echo $vw_list_pasien_rawat_jalan->NOKTP->FldCaption() ?></span></td>
		<td data-name="NOKTP"<?php echo $vw_list_pasien_rawat_jalan->NOKTP->CellAttributes() ?>>
<div id="orig_vw_list_pasien_rawat_jalan_NOKTP" class="hide">
<span id="el_vw_list_pasien_rawat_jalan_NOKTP">
<span<?php echo $vw_list_pasien_rawat_jalan->NOKTP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NOKTP->ViewValue ?></span>
</span>
</div>
<?php

//print ew_ExecuteScalar("SELECT ALAMAT FROM simrs2012.m_pasien where nomr = ".urlencode(CurrentPage()->NOMR->CurrentValue)." limit 1 ");
//echo $MyField;

?>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KDDOKTER->Visible) { // KDDOKTER ?>
	<tr id="r_KDDOKTER">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KDDOKTER"><?php echo $vw_list_pasien_rawat_jalan->KDDOKTER->FldCaption() ?></span></td>
		<td data-name="KDDOKTER"<?php echo $vw_list_pasien_rawat_jalan->KDDOKTER->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KDDOKTER">
<span<?php echo $vw_list_pasien_rawat_jalan->KDDOKTER->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KDDOKTER->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KDPOLY->Visible) { // KDPOLY ?>
	<tr id="r_KDPOLY">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KDPOLY"><?php echo $vw_list_pasien_rawat_jalan->KDPOLY->FldCaption() ?></span></td>
		<td data-name="KDPOLY"<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KDPOLY">
<span<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KDRUJUK->Visible) { // KDRUJUK ?>
	<tr id="r_KDRUJUK">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KDRUJUK"><?php echo $vw_list_pasien_rawat_jalan->KDRUJUK->FldCaption() ?></span></td>
		<td data-name="KDRUJUK"<?php echo $vw_list_pasien_rawat_jalan->KDRUJUK->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KDRUJUK">
<span<?php echo $vw_list_pasien_rawat_jalan->KDRUJUK->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KDRUJUK->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<tr id="r_KDCARABAYAR">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KDCARABAYAR"><?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->FldCaption() ?></span></td>
		<td data-name="KDCARABAYAR"<?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KDCARABAYAR">
<span<?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KDCARABAYAR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NOJAMINAN->Visible) { // NOJAMINAN ?>
	<tr id="r_NOJAMINAN">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NOJAMINAN"><?php echo $vw_list_pasien_rawat_jalan->NOJAMINAN->FldCaption() ?></span></td>
		<td data-name="NOJAMINAN"<?php echo $vw_list_pasien_rawat_jalan->NOJAMINAN->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NOJAMINAN">
<span<?php echo $vw_list_pasien_rawat_jalan->NOJAMINAN->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NOJAMINAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->SHIFT->Visible) { // SHIFT ?>
	<tr id="r_SHIFT">
		<td><span id="elh_vw_list_pasien_rawat_jalan_SHIFT"><?php echo $vw_list_pasien_rawat_jalan->SHIFT->FldCaption() ?></span></td>
		<td data-name="SHIFT"<?php echo $vw_list_pasien_rawat_jalan->SHIFT->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_SHIFT">
<span<?php echo $vw_list_pasien_rawat_jalan->SHIFT->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->SHIFT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->STATUS->Visible) { // STATUS ?>
	<tr id="r_STATUS">
		<td><span id="elh_vw_list_pasien_rawat_jalan_STATUS"><?php echo $vw_list_pasien_rawat_jalan->STATUS->FldCaption() ?></span></td>
		<td data-name="STATUS"<?php echo $vw_list_pasien_rawat_jalan->STATUS->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_STATUS">
<span<?php echo $vw_list_pasien_rawat_jalan->STATUS->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->STATUS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KETERANGAN_STATUS->Visible) { // KETERANGAN_STATUS ?>
	<tr id="r_KETERANGAN_STATUS">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KETERANGAN_STATUS"><?php echo $vw_list_pasien_rawat_jalan->KETERANGAN_STATUS->FldCaption() ?></span></td>
		<td data-name="KETERANGAN_STATUS"<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN_STATUS->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KETERANGAN_STATUS">
<span<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN_STATUS->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN_STATUS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->PASIENBARU->Visible) { // PASIENBARU ?>
	<tr id="r_PASIENBARU">
		<td><span id="elh_vw_list_pasien_rawat_jalan_PASIENBARU"><?php echo $vw_list_pasien_rawat_jalan->PASIENBARU->FldCaption() ?></span></td>
		<td data-name="PASIENBARU"<?php echo $vw_list_pasien_rawat_jalan->PASIENBARU->CellAttributes() ?>>
<div id="orig_vw_list_pasien_rawat_jalan_PASIENBARU" class="hide">
<span id="el_vw_list_pasien_rawat_jalan_PASIENBARU">
<span<?php echo $vw_list_pasien_rawat_jalan->PASIENBARU->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->PASIENBARU->ViewValue ?></span>
</span>
</div>
<?php
$status = urlencode(CurrentPage()->PASIENBARU->CurrentValue);
if($status == 0){
	echo 'L';
}else
{
	echo 'B';
}
?>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NIP->Visible) { // NIP ?>
	<tr id="r_NIP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NIP"><?php echo $vw_list_pasien_rawat_jalan->NIP->FldCaption() ?></span></td>
		<td data-name="NIP"<?php echo $vw_list_pasien_rawat_jalan->NIP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NIP">
<span<?php echo $vw_list_pasien_rawat_jalan->NIP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NIP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->MASUKPOLY->Visible) { // MASUKPOLY ?>
	<tr id="r_MASUKPOLY">
		<td><span id="elh_vw_list_pasien_rawat_jalan_MASUKPOLY"><?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->FldCaption() ?></span></td>
		<td data-name="MASUKPOLY"<?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_MASUKPOLY">
<span<?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->MASUKPOLY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KELUARPOLY->Visible) { // KELUARPOLY ?>
	<tr id="r_KELUARPOLY">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KELUARPOLY"><?php echo $vw_list_pasien_rawat_jalan->KELUARPOLY->FldCaption() ?></span></td>
		<td data-name="KELUARPOLY"<?php echo $vw_list_pasien_rawat_jalan->KELUARPOLY->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KELUARPOLY">
<span<?php echo $vw_list_pasien_rawat_jalan->KELUARPOLY->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KELUARPOLY->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KETRUJUK->Visible) { // KETRUJUK ?>
	<tr id="r_KETRUJUK">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KETRUJUK"><?php echo $vw_list_pasien_rawat_jalan->KETRUJUK->FldCaption() ?></span></td>
		<td data-name="KETRUJUK"<?php echo $vw_list_pasien_rawat_jalan->KETRUJUK->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KETRUJUK">
<span<?php echo $vw_list_pasien_rawat_jalan->KETRUJUK->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KETRUJUK->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KETBAYAR->Visible) { // KETBAYAR ?>
	<tr id="r_KETBAYAR">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KETBAYAR"><?php echo $vw_list_pasien_rawat_jalan->KETBAYAR->FldCaption() ?></span></td>
		<td data-name="KETBAYAR"<?php echo $vw_list_pasien_rawat_jalan->KETBAYAR->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KETBAYAR">
<span<?php echo $vw_list_pasien_rawat_jalan->KETBAYAR->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KETBAYAR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_NAMA->Visible) { // PENANGGUNGJAWAB_NAMA ?>
	<tr id="r_PENANGGUNGJAWAB_NAMA">
		<td><span id="elh_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_NAMA"><?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_NAMA->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_NAMA"<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_NAMA->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_NAMA">
<span<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_NAMA->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_NAMA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_HUBUNGAN->Visible) { // PENANGGUNGJAWAB_HUBUNGAN ?>
	<tr id="r_PENANGGUNGJAWAB_HUBUNGAN">
		<td><span id="elh_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_HUBUNGAN"><?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_HUBUNGAN->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_HUBUNGAN"<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_HUBUNGAN->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_HUBUNGAN">
<span<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_HUBUNGAN->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_HUBUNGAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_ALAMAT->Visible) { // PENANGGUNGJAWAB_ALAMAT ?>
	<tr id="r_PENANGGUNGJAWAB_ALAMAT">
		<td><span id="elh_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_ALAMAT"><?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_ALAMAT->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_ALAMAT"<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_ALAMAT->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_ALAMAT">
<span<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_ALAMAT->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_ALAMAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_PHONE->Visible) { // PENANGGUNGJAWAB_PHONE ?>
	<tr id="r_PENANGGUNGJAWAB_PHONE">
		<td><span id="elh_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_PHONE"><?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_PHONE->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_PHONE"<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_PHONE->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_PENANGGUNGJAWAB_PHONE">
<span<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_PHONE->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->PENANGGUNGJAWAB_PHONE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->JAMREG->Visible) { // JAMREG ?>
	<tr id="r_JAMREG">
		<td><span id="elh_vw_list_pasien_rawat_jalan_JAMREG"><?php echo $vw_list_pasien_rawat_jalan->JAMREG->FldCaption() ?></span></td>
		<td data-name="JAMREG"<?php echo $vw_list_pasien_rawat_jalan->JAMREG->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_JAMREG">
<span<?php echo $vw_list_pasien_rawat_jalan->JAMREG->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->JAMREG->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->BATAL->Visible) { // BATAL ?>
	<tr id="r_BATAL">
		<td><span id="elh_vw_list_pasien_rawat_jalan_BATAL"><?php echo $vw_list_pasien_rawat_jalan->BATAL->FldCaption() ?></span></td>
		<td data-name="BATAL"<?php echo $vw_list_pasien_rawat_jalan->BATAL->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_BATAL">
<span<?php echo $vw_list_pasien_rawat_jalan->BATAL->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->BATAL->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NO_SJP->Visible) { // NO_SJP ?>
	<tr id="r_NO_SJP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NO_SJP"><?php echo $vw_list_pasien_rawat_jalan->NO_SJP->FldCaption() ?></span></td>
		<td data-name="NO_SJP"<?php echo $vw_list_pasien_rawat_jalan->NO_SJP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NO_SJP">
<span<?php echo $vw_list_pasien_rawat_jalan->NO_SJP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NO_SJP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NO_PESERTA->Visible) { // NO_PESERTA ?>
	<tr id="r_NO_PESERTA">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NO_PESERTA"><?php echo $vw_list_pasien_rawat_jalan->NO_PESERTA->FldCaption() ?></span></td>
		<td data-name="NO_PESERTA"<?php echo $vw_list_pasien_rawat_jalan->NO_PESERTA->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NO_PESERTA">
<span<?php echo $vw_list_pasien_rawat_jalan->NO_PESERTA->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NO_PESERTA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NOKARTU->Visible) { // NOKARTU ?>
	<tr id="r_NOKARTU">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NOKARTU"><?php echo $vw_list_pasien_rawat_jalan->NOKARTU->FldCaption() ?></span></td>
		<td data-name="NOKARTU"<?php echo $vw_list_pasien_rawat_jalan->NOKARTU->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NOKARTU">
<span<?php echo $vw_list_pasien_rawat_jalan->NOKARTU->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NOKARTU->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->TANGGAL_SEP->Visible) { // TANGGAL_SEP ?>
	<tr id="r_TANGGAL_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_TANGGAL_SEP"><?php echo $vw_list_pasien_rawat_jalan->TANGGAL_SEP->FldCaption() ?></span></td>
		<td data-name="TANGGAL_SEP"<?php echo $vw_list_pasien_rawat_jalan->TANGGAL_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_TANGGAL_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->TANGGAL_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->TANGGAL_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->TANGGALRUJUK_SEP->Visible) { // TANGGALRUJUK_SEP ?>
	<tr id="r_TANGGALRUJUK_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_TANGGALRUJUK_SEP"><?php echo $vw_list_pasien_rawat_jalan->TANGGALRUJUK_SEP->FldCaption() ?></span></td>
		<td data-name="TANGGALRUJUK_SEP"<?php echo $vw_list_pasien_rawat_jalan->TANGGALRUJUK_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_TANGGALRUJUK_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->TANGGALRUJUK_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->TANGGALRUJUK_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KELASRAWAT_SEP->Visible) { // KELASRAWAT_SEP ?>
	<tr id="r_KELASRAWAT_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_KELASRAWAT_SEP"><?php echo $vw_list_pasien_rawat_jalan->KELASRAWAT_SEP->FldCaption() ?></span></td>
		<td data-name="KELASRAWAT_SEP"<?php echo $vw_list_pasien_rawat_jalan->KELASRAWAT_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_KELASRAWAT_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->KELASRAWAT_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KELASRAWAT_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->MINTA_RUJUKAN->Visible) { // MINTA_RUJUKAN ?>
	<tr id="r_MINTA_RUJUKAN">
		<td><span id="elh_vw_list_pasien_rawat_jalan_MINTA_RUJUKAN"><?php echo $vw_list_pasien_rawat_jalan->MINTA_RUJUKAN->FldCaption() ?></span></td>
		<td data-name="MINTA_RUJUKAN"<?php echo $vw_list_pasien_rawat_jalan->MINTA_RUJUKAN->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_MINTA_RUJUKAN">
<span<?php echo $vw_list_pasien_rawat_jalan->MINTA_RUJUKAN->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->MINTA_RUJUKAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NORUJUKAN_SEP->Visible) { // NORUJUKAN_SEP ?>
	<tr id="r_NORUJUKAN_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NORUJUKAN_SEP"><?php echo $vw_list_pasien_rawat_jalan->NORUJUKAN_SEP->FldCaption() ?></span></td>
		<td data-name="NORUJUKAN_SEP"<?php echo $vw_list_pasien_rawat_jalan->NORUJUKAN_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NORUJUKAN_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->NORUJUKAN_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NORUJUKAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->PPKRUJUKANASAL_SEP->Visible) { // PPKRUJUKANASAL_SEP ?>
	<tr id="r_PPKRUJUKANASAL_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_PPKRUJUKANASAL_SEP"><?php echo $vw_list_pasien_rawat_jalan->PPKRUJUKANASAL_SEP->FldCaption() ?></span></td>
		<td data-name="PPKRUJUKANASAL_SEP"<?php echo $vw_list_pasien_rawat_jalan->PPKRUJUKANASAL_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_PPKRUJUKANASAL_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->PPKRUJUKANASAL_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->PPKRUJUKANASAL_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NAMAPPKRUJUKANASAL_SEP->Visible) { // NAMAPPKRUJUKANASAL_SEP ?>
	<tr id="r_NAMAPPKRUJUKANASAL_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NAMAPPKRUJUKANASAL_SEP"><?php echo $vw_list_pasien_rawat_jalan->NAMAPPKRUJUKANASAL_SEP->FldCaption() ?></span></td>
		<td data-name="NAMAPPKRUJUKANASAL_SEP"<?php echo $vw_list_pasien_rawat_jalan->NAMAPPKRUJUKANASAL_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NAMAPPKRUJUKANASAL_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->NAMAPPKRUJUKANASAL_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NAMAPPKRUJUKANASAL_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->PPKPELAYANAN_SEP->Visible) { // PPKPELAYANAN_SEP ?>
	<tr id="r_PPKPELAYANAN_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_PPKPELAYANAN_SEP"><?php echo $vw_list_pasien_rawat_jalan->PPKPELAYANAN_SEP->FldCaption() ?></span></td>
		<td data-name="PPKPELAYANAN_SEP"<?php echo $vw_list_pasien_rawat_jalan->PPKPELAYANAN_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_PPKPELAYANAN_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->PPKPELAYANAN_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->PPKPELAYANAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->JENISPERAWATAN_SEP->Visible) { // JENISPERAWATAN_SEP ?>
	<tr id="r_JENISPERAWATAN_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_JENISPERAWATAN_SEP"><?php echo $vw_list_pasien_rawat_jalan->JENISPERAWATAN_SEP->FldCaption() ?></span></td>
		<td data-name="JENISPERAWATAN_SEP"<?php echo $vw_list_pasien_rawat_jalan->JENISPERAWATAN_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_JENISPERAWATAN_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->JENISPERAWATAN_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->JENISPERAWATAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->CATATAN_SEP->Visible) { // CATATAN_SEP ?>
	<tr id="r_CATATAN_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_CATATAN_SEP"><?php echo $vw_list_pasien_rawat_jalan->CATATAN_SEP->FldCaption() ?></span></td>
		<td data-name="CATATAN_SEP"<?php echo $vw_list_pasien_rawat_jalan->CATATAN_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_CATATAN_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->CATATAN_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->CATATAN_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->DIAGNOSAAWAL_SEP->Visible) { // DIAGNOSAAWAL_SEP ?>
	<tr id="r_DIAGNOSAAWAL_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_DIAGNOSAAWAL_SEP"><?php echo $vw_list_pasien_rawat_jalan->DIAGNOSAAWAL_SEP->FldCaption() ?></span></td>
		<td data-name="DIAGNOSAAWAL_SEP"<?php echo $vw_list_pasien_rawat_jalan->DIAGNOSAAWAL_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_DIAGNOSAAWAL_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->DIAGNOSAAWAL_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->DIAGNOSAAWAL_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->NAMADIAGNOSA_SEP->Visible) { // NAMADIAGNOSA_SEP ?>
	<tr id="r_NAMADIAGNOSA_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_NAMADIAGNOSA_SEP"><?php echo $vw_list_pasien_rawat_jalan->NAMADIAGNOSA_SEP->FldCaption() ?></span></td>
		<td data-name="NAMADIAGNOSA_SEP"<?php echo $vw_list_pasien_rawat_jalan->NAMADIAGNOSA_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_NAMADIAGNOSA_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->NAMADIAGNOSA_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->NAMADIAGNOSA_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->LAKALANTAS_SEP->Visible) { // LAKALANTAS_SEP ?>
	<tr id="r_LAKALANTAS_SEP">
		<td><span id="elh_vw_list_pasien_rawat_jalan_LAKALANTAS_SEP"><?php echo $vw_list_pasien_rawat_jalan->LAKALANTAS_SEP->FldCaption() ?></span></td>
		<td data-name="LAKALANTAS_SEP"<?php echo $vw_list_pasien_rawat_jalan->LAKALANTAS_SEP->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_LAKALANTAS_SEP">
<span<?php echo $vw_list_pasien_rawat_jalan->LAKALANTAS_SEP->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->LAKALANTAS_SEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->LOKASILAKALANTAS->Visible) { // LOKASILAKALANTAS ?>
	<tr id="r_LOKASILAKALANTAS">
		<td><span id="elh_vw_list_pasien_rawat_jalan_LOKASILAKALANTAS"><?php echo $vw_list_pasien_rawat_jalan->LOKASILAKALANTAS->FldCaption() ?></span></td>
		<td data-name="LOKASILAKALANTAS"<?php echo $vw_list_pasien_rawat_jalan->LOKASILAKALANTAS->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_LOKASILAKALANTAS">
<span<?php echo $vw_list_pasien_rawat_jalan->LOKASILAKALANTAS->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->LOKASILAKALANTAS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->USER->Visible) { // USER ?>
	<tr id="r_USER">
		<td><span id="elh_vw_list_pasien_rawat_jalan_USER"><?php echo $vw_list_pasien_rawat_jalan->USER->FldCaption() ?></span></td>
		<td data-name="USER"<?php echo $vw_list_pasien_rawat_jalan->USER->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_USER">
<span<?php echo $vw_list_pasien_rawat_jalan->USER->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->USER->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->tanggal->Visible) { // tanggal ?>
	<tr id="r_tanggal">
		<td><span id="elh_vw_list_pasien_rawat_jalan_tanggal"><?php echo $vw_list_pasien_rawat_jalan->tanggal->FldCaption() ?></span></td>
		<td data-name="tanggal"<?php echo $vw_list_pasien_rawat_jalan->tanggal->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_tanggal">
<span<?php echo $vw_list_pasien_rawat_jalan->tanggal->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->tanggal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->bulan->Visible) { // bulan ?>
	<tr id="r_bulan">
		<td><span id="elh_vw_list_pasien_rawat_jalan_bulan"><?php echo $vw_list_pasien_rawat_jalan->bulan->FldCaption() ?></span></td>
		<td data-name="bulan"<?php echo $vw_list_pasien_rawat_jalan->bulan->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_bulan">
<span<?php echo $vw_list_pasien_rawat_jalan->bulan->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->bulan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->tahun->Visible) { // tahun ?>
	<tr id="r_tahun">
		<td><span id="elh_vw_list_pasien_rawat_jalan_tahun"><?php echo $vw_list_pasien_rawat_jalan->tahun->FldCaption() ?></span></td>
		<td data-name="tahun"<?php echo $vw_list_pasien_rawat_jalan->tahun->CellAttributes() ?>>
<span id="el_vw_list_pasien_rawat_jalan_tahun">
<span<?php echo $vw_list_pasien_rawat_jalan->tahun->ViewAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->tahun->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fvw_list_pasien_rawat_jalanview.Init();
</script>
<?php
$vw_list_pasien_rawat_jalan_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_list_pasien_rawat_jalan_view->Page_Terminate();
?>
