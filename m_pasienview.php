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

$m_pasien_view = NULL; // Initialize page object first

class cm_pasien_view extends cm_pasien {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_pasien';

	// Page object name
	var $PageObjName = 'm_pasien_view';

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

		// Table object (m_pasien)
		if (!isset($GLOBALS["m_pasien"]) || get_class($GLOBALS["m_pasien"]) == "cm_pasien") {
			$GLOBALS["m_pasien"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_pasien"];
		}
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
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
				$this->Page_Terminate(ew_GetUrl("m_pasienlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NOMR->SetVisibility();
		$this->TITLE->SetVisibility();
		$this->NAMA->SetVisibility();
		$this->TEMPAT->SetVisibility();
		$this->TGLLAHIR->SetVisibility();
		$this->JENISKELAMIN->SetVisibility();
		$this->ALAMAT->SetVisibility();
		$this->KDPROVINSI->SetVisibility();
		$this->KOTA->SetVisibility();
		$this->KDKECAMATAN->SetVisibility();
		$this->KELURAHAN->SetVisibility();
		$this->NOTELP->SetVisibility();
		$this->NOKTP->SetVisibility();
		$this->SUAMI_ORTU->SetVisibility();
		$this->PEKERJAAN->SetVisibility();
		$this->STATUS->SetVisibility();
		$this->AGAMA->SetVisibility();
		$this->PENDIDIKAN->SetVisibility();
		$this->KDCARABAYAR->SetVisibility();
		$this->NIP->SetVisibility();
		$this->TGLDAFTAR->SetVisibility();
		$this->ALAMAT_KTP->SetVisibility();
		$this->PENANGGUNGJAWAB_NAMA->SetVisibility();
		$this->PENANGGUNGJAWAB_HUBUNGAN->SetVisibility();
		$this->PENANGGUNGJAWAB_ALAMAT->SetVisibility();
		$this->PENANGGUNGJAWAB_PHONE->SetVisibility();
		$this->NO_KARTU->SetVisibility();
		$this->JNS_PASIEN->SetVisibility();
		$this->nama_ayah->SetVisibility();
		$this->nama_ibu->SetVisibility();
		$this->nama_suami->SetVisibility();
		$this->nama_istri->SetVisibility();
		$this->KD_ETNIS->SetVisibility();
		$this->KD_BHS_HARIAN->SetVisibility();

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
		global $EW_EXPORT, $m_pasien;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
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
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "m_pasienlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "m_pasienlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "m_pasienlist.php"; // Not page request, return to list
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

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

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

		// SUAMI_ORTU
		$this->SUAMI_ORTU->ViewValue = $this->SUAMI_ORTU->CurrentValue;
		$this->SUAMI_ORTU->ViewCustomAttributes = "";

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

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

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

			// SUAMI_ORTU
			$this->SUAMI_ORTU->LinkCustomAttributes = "";
			$this->SUAMI_ORTU->HrefValue = "";
			$this->SUAMI_ORTU->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_pasienlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_pasien_view)) $m_pasien_view = new cm_pasien_view();

// Page init
$m_pasien_view->Page_Init();

// Page main
$m_pasien_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_pasien_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fm_pasienview = new ew_Form("fm_pasienview", "view");

// Form_CustomValidate event
fm_pasienview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_pasienview.ValidateRequired = true;
<?php } else { ?>
fm_pasienview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_pasienview.Lists["x_TITLE"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_titel"};
fm_pasienview.Lists["x_JENISKELAMIN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskelamin","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskelamin"};
fm_pasienview.Lists["x_KDPROVINSI"] = {"LinkField":"x_idprovinsi","Ajax":true,"AutoFill":false,"DisplayFields":["x_namaprovinsi","","",""],"ParentFields":[],"ChildFields":["x_KOTA"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_provinsi"};
fm_pasienview.Lists["x_KOTA"] = {"LinkField":"x_idkota","Ajax":true,"AutoFill":false,"DisplayFields":["x_namakota","","",""],"ParentFields":[],"ChildFields":["x_KDKECAMATAN"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_kota"};
fm_pasienview.Lists["x_KDKECAMATAN"] = {"LinkField":"x_idkecamatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_namakecamatan","","",""],"ParentFields":[],"ChildFields":["x_KELURAHAN"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_kecamatan"};
fm_pasienview.Lists["x_KELURAHAN"] = {"LinkField":"x_idkelurahan","Ajax":true,"AutoFill":false,"DisplayFields":["x_namakelurahan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_kelurahan"};
fm_pasienview.Lists["x_STATUS"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_statusperkawinan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_statusperkawin"};
fm_pasienview.Lists["x_AGAMA"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_agama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_agama"};
fm_pasienview.Lists["x_PENDIDIKAN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_pendidikan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_pendidikanterakhir"};
fm_pasienview.Lists["x_KDCARABAYAR"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fm_pasienview.Lists["x_JNS_PASIEN"] = {"LinkField":"x_jenis_pasien","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_jenis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_pasien"};
fm_pasienview.Lists["x_KD_ETNIS"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_etnis","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_etnis"};
fm_pasienview.Lists["x_KD_BHS_HARIAN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bahasa_harian","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_bahasa_harian"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_pasien_view->IsModal) { ?>
<?php } ?>
<?php $m_pasien_view->ExportOptions->Render("body") ?>
<?php
	foreach ($m_pasien_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$m_pasien_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $m_pasien_view->ShowPageHeader(); ?>
<?php
$m_pasien_view->ShowMessage();
?>
<form name="fm_pasienview" id="fm_pasienview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_pasien_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_pasien_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_pasien">
<?php if ($m_pasien_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($m_pasien->NOMR->Visible) { // NOMR ?>
	<tr id="r_NOMR">
		<td><span id="elh_m_pasien_NOMR"><?php echo $m_pasien->NOMR->FldCaption() ?></span></td>
		<td data-name="NOMR"<?php echo $m_pasien->NOMR->CellAttributes() ?>>
<span id="el_m_pasien_NOMR">
<span<?php echo $m_pasien->NOMR->ViewAttributes() ?>>
<?php echo $m_pasien->NOMR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->TITLE->Visible) { // TITLE ?>
	<tr id="r_TITLE">
		<td><span id="elh_m_pasien_TITLE"><?php echo $m_pasien->TITLE->FldCaption() ?></span></td>
		<td data-name="TITLE"<?php echo $m_pasien->TITLE->CellAttributes() ?>>
<span id="el_m_pasien_TITLE">
<span<?php echo $m_pasien->TITLE->ViewAttributes() ?>>
<?php echo $m_pasien->TITLE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->NAMA->Visible) { // NAMA ?>
	<tr id="r_NAMA">
		<td><span id="elh_m_pasien_NAMA"><?php echo $m_pasien->NAMA->FldCaption() ?></span></td>
		<td data-name="NAMA"<?php echo $m_pasien->NAMA->CellAttributes() ?>>
<span id="el_m_pasien_NAMA">
<span<?php echo $m_pasien->NAMA->ViewAttributes() ?>>
<?php echo $m_pasien->NAMA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->TEMPAT->Visible) { // TEMPAT ?>
	<tr id="r_TEMPAT">
		<td><span id="elh_m_pasien_TEMPAT"><?php echo $m_pasien->TEMPAT->FldCaption() ?></span></td>
		<td data-name="TEMPAT"<?php echo $m_pasien->TEMPAT->CellAttributes() ?>>
<span id="el_m_pasien_TEMPAT">
<span<?php echo $m_pasien->TEMPAT->ViewAttributes() ?>>
<?php echo $m_pasien->TEMPAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->TGLLAHIR->Visible) { // TGLLAHIR ?>
	<tr id="r_TGLLAHIR">
		<td><span id="elh_m_pasien_TGLLAHIR"><?php echo $m_pasien->TGLLAHIR->FldCaption() ?></span></td>
		<td data-name="TGLLAHIR"<?php echo $m_pasien->TGLLAHIR->CellAttributes() ?>>
<span id="el_m_pasien_TGLLAHIR">
<span<?php echo $m_pasien->TGLLAHIR->ViewAttributes() ?>>
<?php echo $m_pasien->TGLLAHIR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->JENISKELAMIN->Visible) { // JENISKELAMIN ?>
	<tr id="r_JENISKELAMIN">
		<td><span id="elh_m_pasien_JENISKELAMIN"><?php echo $m_pasien->JENISKELAMIN->FldCaption() ?></span></td>
		<td data-name="JENISKELAMIN"<?php echo $m_pasien->JENISKELAMIN->CellAttributes() ?>>
<span id="el_m_pasien_JENISKELAMIN">
<span<?php echo $m_pasien->JENISKELAMIN->ViewAttributes() ?>>
<?php echo $m_pasien->JENISKELAMIN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->ALAMAT->Visible) { // ALAMAT ?>
	<tr id="r_ALAMAT">
		<td><span id="elh_m_pasien_ALAMAT"><?php echo $m_pasien->ALAMAT->FldCaption() ?></span></td>
		<td data-name="ALAMAT"<?php echo $m_pasien->ALAMAT->CellAttributes() ?>>
<span id="el_m_pasien_ALAMAT">
<span<?php echo $m_pasien->ALAMAT->ViewAttributes() ?>>
<?php echo $m_pasien->ALAMAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->KDPROVINSI->Visible) { // KDPROVINSI ?>
	<tr id="r_KDPROVINSI">
		<td><span id="elh_m_pasien_KDPROVINSI"><?php echo $m_pasien->KDPROVINSI->FldCaption() ?></span></td>
		<td data-name="KDPROVINSI"<?php echo $m_pasien->KDPROVINSI->CellAttributes() ?>>
<span id="el_m_pasien_KDPROVINSI">
<span<?php echo $m_pasien->KDPROVINSI->ViewAttributes() ?>>
<?php echo $m_pasien->KDPROVINSI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->KOTA->Visible) { // KOTA ?>
	<tr id="r_KOTA">
		<td><span id="elh_m_pasien_KOTA"><?php echo $m_pasien->KOTA->FldCaption() ?></span></td>
		<td data-name="KOTA"<?php echo $m_pasien->KOTA->CellAttributes() ?>>
<span id="el_m_pasien_KOTA">
<span<?php echo $m_pasien->KOTA->ViewAttributes() ?>>
<?php echo $m_pasien->KOTA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->KDKECAMATAN->Visible) { // KDKECAMATAN ?>
	<tr id="r_KDKECAMATAN">
		<td><span id="elh_m_pasien_KDKECAMATAN"><?php echo $m_pasien->KDKECAMATAN->FldCaption() ?></span></td>
		<td data-name="KDKECAMATAN"<?php echo $m_pasien->KDKECAMATAN->CellAttributes() ?>>
<span id="el_m_pasien_KDKECAMATAN">
<span<?php echo $m_pasien->KDKECAMATAN->ViewAttributes() ?>>
<?php echo $m_pasien->KDKECAMATAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->KELURAHAN->Visible) { // KELURAHAN ?>
	<tr id="r_KELURAHAN">
		<td><span id="elh_m_pasien_KELURAHAN"><?php echo $m_pasien->KELURAHAN->FldCaption() ?></span></td>
		<td data-name="KELURAHAN"<?php echo $m_pasien->KELURAHAN->CellAttributes() ?>>
<span id="el_m_pasien_KELURAHAN">
<span<?php echo $m_pasien->KELURAHAN->ViewAttributes() ?>>
<?php echo $m_pasien->KELURAHAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->NOTELP->Visible) { // NOTELP ?>
	<tr id="r_NOTELP">
		<td><span id="elh_m_pasien_NOTELP"><?php echo $m_pasien->NOTELP->FldCaption() ?></span></td>
		<td data-name="NOTELP"<?php echo $m_pasien->NOTELP->CellAttributes() ?>>
<span id="el_m_pasien_NOTELP">
<span<?php echo $m_pasien->NOTELP->ViewAttributes() ?>>
<?php echo $m_pasien->NOTELP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->NOKTP->Visible) { // NOKTP ?>
	<tr id="r_NOKTP">
		<td><span id="elh_m_pasien_NOKTP"><?php echo $m_pasien->NOKTP->FldCaption() ?></span></td>
		<td data-name="NOKTP"<?php echo $m_pasien->NOKTP->CellAttributes() ?>>
<span id="el_m_pasien_NOKTP">
<span<?php echo $m_pasien->NOKTP->ViewAttributes() ?>>
<?php echo $m_pasien->NOKTP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->SUAMI_ORTU->Visible) { // SUAMI_ORTU ?>
	<tr id="r_SUAMI_ORTU">
		<td><span id="elh_m_pasien_SUAMI_ORTU"><?php echo $m_pasien->SUAMI_ORTU->FldCaption() ?></span></td>
		<td data-name="SUAMI_ORTU"<?php echo $m_pasien->SUAMI_ORTU->CellAttributes() ?>>
<span id="el_m_pasien_SUAMI_ORTU">
<span<?php echo $m_pasien->SUAMI_ORTU->ViewAttributes() ?>>
<?php echo $m_pasien->SUAMI_ORTU->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->PEKERJAAN->Visible) { // PEKERJAAN ?>
	<tr id="r_PEKERJAAN">
		<td><span id="elh_m_pasien_PEKERJAAN"><?php echo $m_pasien->PEKERJAAN->FldCaption() ?></span></td>
		<td data-name="PEKERJAAN"<?php echo $m_pasien->PEKERJAAN->CellAttributes() ?>>
<span id="el_m_pasien_PEKERJAAN">
<span<?php echo $m_pasien->PEKERJAAN->ViewAttributes() ?>>
<?php echo $m_pasien->PEKERJAAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->STATUS->Visible) { // STATUS ?>
	<tr id="r_STATUS">
		<td><span id="elh_m_pasien_STATUS"><?php echo $m_pasien->STATUS->FldCaption() ?></span></td>
		<td data-name="STATUS"<?php echo $m_pasien->STATUS->CellAttributes() ?>>
<span id="el_m_pasien_STATUS">
<span<?php echo $m_pasien->STATUS->ViewAttributes() ?>>
<?php echo $m_pasien->STATUS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->AGAMA->Visible) { // AGAMA ?>
	<tr id="r_AGAMA">
		<td><span id="elh_m_pasien_AGAMA"><?php echo $m_pasien->AGAMA->FldCaption() ?></span></td>
		<td data-name="AGAMA"<?php echo $m_pasien->AGAMA->CellAttributes() ?>>
<span id="el_m_pasien_AGAMA">
<span<?php echo $m_pasien->AGAMA->ViewAttributes() ?>>
<?php echo $m_pasien->AGAMA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->PENDIDIKAN->Visible) { // PENDIDIKAN ?>
	<tr id="r_PENDIDIKAN">
		<td><span id="elh_m_pasien_PENDIDIKAN"><?php echo $m_pasien->PENDIDIKAN->FldCaption() ?></span></td>
		<td data-name="PENDIDIKAN"<?php echo $m_pasien->PENDIDIKAN->CellAttributes() ?>>
<span id="el_m_pasien_PENDIDIKAN">
<span<?php echo $m_pasien->PENDIDIKAN->ViewAttributes() ?>>
<?php echo $m_pasien->PENDIDIKAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->KDCARABAYAR->Visible) { // KDCARABAYAR ?>
	<tr id="r_KDCARABAYAR">
		<td><span id="elh_m_pasien_KDCARABAYAR"><?php echo $m_pasien->KDCARABAYAR->FldCaption() ?></span></td>
		<td data-name="KDCARABAYAR"<?php echo $m_pasien->KDCARABAYAR->CellAttributes() ?>>
<span id="el_m_pasien_KDCARABAYAR">
<span<?php echo $m_pasien->KDCARABAYAR->ViewAttributes() ?>>
<?php echo $m_pasien->KDCARABAYAR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->NIP->Visible) { // NIP ?>
	<tr id="r_NIP">
		<td><span id="elh_m_pasien_NIP"><?php echo $m_pasien->NIP->FldCaption() ?></span></td>
		<td data-name="NIP"<?php echo $m_pasien->NIP->CellAttributes() ?>>
<span id="el_m_pasien_NIP">
<span<?php echo $m_pasien->NIP->ViewAttributes() ?>>
<?php echo $m_pasien->NIP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->TGLDAFTAR->Visible) { // TGLDAFTAR ?>
	<tr id="r_TGLDAFTAR">
		<td><span id="elh_m_pasien_TGLDAFTAR"><?php echo $m_pasien->TGLDAFTAR->FldCaption() ?></span></td>
		<td data-name="TGLDAFTAR"<?php echo $m_pasien->TGLDAFTAR->CellAttributes() ?>>
<span id="el_m_pasien_TGLDAFTAR">
<span<?php echo $m_pasien->TGLDAFTAR->ViewAttributes() ?>>
<?php echo $m_pasien->TGLDAFTAR->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->ALAMAT_KTP->Visible) { // ALAMAT_KTP ?>
	<tr id="r_ALAMAT_KTP">
		<td><span id="elh_m_pasien_ALAMAT_KTP"><?php echo $m_pasien->ALAMAT_KTP->FldCaption() ?></span></td>
		<td data-name="ALAMAT_KTP"<?php echo $m_pasien->ALAMAT_KTP->CellAttributes() ?>>
<span id="el_m_pasien_ALAMAT_KTP">
<span<?php echo $m_pasien->ALAMAT_KTP->ViewAttributes() ?>>
<?php echo $m_pasien->ALAMAT_KTP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_NAMA->Visible) { // PENANGGUNGJAWAB_NAMA ?>
	<tr id="r_PENANGGUNGJAWAB_NAMA">
		<td><span id="elh_m_pasien_PENANGGUNGJAWAB_NAMA"><?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_NAMA"<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->CellAttributes() ?>>
<span id="el_m_pasien_PENANGGUNGJAWAB_NAMA">
<span<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->ViewAttributes() ?>>
<?php echo $m_pasien->PENANGGUNGJAWAB_NAMA->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_HUBUNGAN->Visible) { // PENANGGUNGJAWAB_HUBUNGAN ?>
	<tr id="r_PENANGGUNGJAWAB_HUBUNGAN">
		<td><span id="elh_m_pasien_PENANGGUNGJAWAB_HUBUNGAN"><?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_HUBUNGAN"<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->CellAttributes() ?>>
<span id="el_m_pasien_PENANGGUNGJAWAB_HUBUNGAN">
<span<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->ViewAttributes() ?>>
<?php echo $m_pasien->PENANGGUNGJAWAB_HUBUNGAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_ALAMAT->Visible) { // PENANGGUNGJAWAB_ALAMAT ?>
	<tr id="r_PENANGGUNGJAWAB_ALAMAT">
		<td><span id="elh_m_pasien_PENANGGUNGJAWAB_ALAMAT"><?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_ALAMAT"<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->CellAttributes() ?>>
<span id="el_m_pasien_PENANGGUNGJAWAB_ALAMAT">
<span<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->ViewAttributes() ?>>
<?php echo $m_pasien->PENANGGUNGJAWAB_ALAMAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->PENANGGUNGJAWAB_PHONE->Visible) { // PENANGGUNGJAWAB_PHONE ?>
	<tr id="r_PENANGGUNGJAWAB_PHONE">
		<td><span id="elh_m_pasien_PENANGGUNGJAWAB_PHONE"><?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->FldCaption() ?></span></td>
		<td data-name="PENANGGUNGJAWAB_PHONE"<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->CellAttributes() ?>>
<span id="el_m_pasien_PENANGGUNGJAWAB_PHONE">
<span<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->ViewAttributes() ?>>
<?php echo $m_pasien->PENANGGUNGJAWAB_PHONE->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->NO_KARTU->Visible) { // NO_KARTU ?>
	<tr id="r_NO_KARTU">
		<td><span id="elh_m_pasien_NO_KARTU"><?php echo $m_pasien->NO_KARTU->FldCaption() ?></span></td>
		<td data-name="NO_KARTU"<?php echo $m_pasien->NO_KARTU->CellAttributes() ?>>
<span id="el_m_pasien_NO_KARTU">
<span<?php echo $m_pasien->NO_KARTU->ViewAttributes() ?>>
<?php echo $m_pasien->NO_KARTU->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->JNS_PASIEN->Visible) { // JNS_PASIEN ?>
	<tr id="r_JNS_PASIEN">
		<td><span id="elh_m_pasien_JNS_PASIEN"><?php echo $m_pasien->JNS_PASIEN->FldCaption() ?></span></td>
		<td data-name="JNS_PASIEN"<?php echo $m_pasien->JNS_PASIEN->CellAttributes() ?>>
<span id="el_m_pasien_JNS_PASIEN">
<span<?php echo $m_pasien->JNS_PASIEN->ViewAttributes() ?>>
<?php echo $m_pasien->JNS_PASIEN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->nama_ayah->Visible) { // nama_ayah ?>
	<tr id="r_nama_ayah">
		<td><span id="elh_m_pasien_nama_ayah"><?php echo $m_pasien->nama_ayah->FldCaption() ?></span></td>
		<td data-name="nama_ayah"<?php echo $m_pasien->nama_ayah->CellAttributes() ?>>
<span id="el_m_pasien_nama_ayah">
<span<?php echo $m_pasien->nama_ayah->ViewAttributes() ?>>
<?php echo $m_pasien->nama_ayah->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->nama_ibu->Visible) { // nama_ibu ?>
	<tr id="r_nama_ibu">
		<td><span id="elh_m_pasien_nama_ibu"><?php echo $m_pasien->nama_ibu->FldCaption() ?></span></td>
		<td data-name="nama_ibu"<?php echo $m_pasien->nama_ibu->CellAttributes() ?>>
<span id="el_m_pasien_nama_ibu">
<span<?php echo $m_pasien->nama_ibu->ViewAttributes() ?>>
<?php echo $m_pasien->nama_ibu->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->nama_suami->Visible) { // nama_suami ?>
	<tr id="r_nama_suami">
		<td><span id="elh_m_pasien_nama_suami"><?php echo $m_pasien->nama_suami->FldCaption() ?></span></td>
		<td data-name="nama_suami"<?php echo $m_pasien->nama_suami->CellAttributes() ?>>
<span id="el_m_pasien_nama_suami">
<span<?php echo $m_pasien->nama_suami->ViewAttributes() ?>>
<?php echo $m_pasien->nama_suami->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->nama_istri->Visible) { // nama_istri ?>
	<tr id="r_nama_istri">
		<td><span id="elh_m_pasien_nama_istri"><?php echo $m_pasien->nama_istri->FldCaption() ?></span></td>
		<td data-name="nama_istri"<?php echo $m_pasien->nama_istri->CellAttributes() ?>>
<span id="el_m_pasien_nama_istri">
<span<?php echo $m_pasien->nama_istri->ViewAttributes() ?>>
<?php echo $m_pasien->nama_istri->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->KD_ETNIS->Visible) { // KD_ETNIS ?>
	<tr id="r_KD_ETNIS">
		<td><span id="elh_m_pasien_KD_ETNIS"><?php echo $m_pasien->KD_ETNIS->FldCaption() ?></span></td>
		<td data-name="KD_ETNIS"<?php echo $m_pasien->KD_ETNIS->CellAttributes() ?>>
<span id="el_m_pasien_KD_ETNIS">
<span<?php echo $m_pasien->KD_ETNIS->ViewAttributes() ?>>
<?php echo $m_pasien->KD_ETNIS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_pasien->KD_BHS_HARIAN->Visible) { // KD_BHS_HARIAN ?>
	<tr id="r_KD_BHS_HARIAN">
		<td><span id="elh_m_pasien_KD_BHS_HARIAN"><?php echo $m_pasien->KD_BHS_HARIAN->FldCaption() ?></span></td>
		<td data-name="KD_BHS_HARIAN"<?php echo $m_pasien->KD_BHS_HARIAN->CellAttributes() ?>>
<span id="el_m_pasien_KD_BHS_HARIAN">
<span<?php echo $m_pasien->KD_BHS_HARIAN->ViewAttributes() ?>>
<?php echo $m_pasien->KD_BHS_HARIAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fm_pasienview.Init();
</script>
<?php
$m_pasien_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_pasien_view->Page_Terminate();
?>
