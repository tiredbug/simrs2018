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

$m_ruang_view = NULL; // Initialize page object first

class cm_ruang_view extends cm_ruang {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_ruang';

	// Page object name
	var $PageObjName = 'm_ruang_view';

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

		// Table object (m_ruang)
		if (!isset($GLOBALS["m_ruang"]) || get_class($GLOBALS["m_ruang"]) == "cm_ruang") {
			$GLOBALS["m_ruang"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_ruang"];
		}
		$KeyUrl = "";
		if (@$_GET["no"] <> "") {
			$this->RecKey["no"] = $_GET["no"];
			$KeyUrl .= "&amp;no=" . urlencode($this->RecKey["no"]);
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
				$this->Page_Terminate(ew_GetUrl("m_ruanglist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
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
			if (@$_GET["no"] <> "") {
				$this->no->setQueryStringValue($_GET["no"]);
				$this->RecKey["no"] = $this->no->QueryStringValue;
			} elseif (@$_POST["no"] <> "") {
				$this->no->setFormValue($_POST["no"]);
				$this->RecKey["no"] = $this->no->FormValue;
			} else {
				$sReturnUrl = "m_ruanglist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "m_ruanglist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "m_ruanglist.php"; // Not page request, return to list
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_ruanglist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_ruang_view)) $m_ruang_view = new cm_ruang_view();

// Page init
$m_ruang_view->Page_Init();

// Page main
$m_ruang_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_ruang_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fm_ruangview = new ew_Form("fm_ruangview", "view");

// Form_CustomValidate event
fm_ruangview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_ruangview.ValidateRequired = true;
<?php } else { ?>
fm_ruangview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_ruang_view->IsModal) { ?>
<?php } ?>
<?php $m_ruang_view->ExportOptions->Render("body") ?>
<?php
	foreach ($m_ruang_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$m_ruang_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $m_ruang_view->ShowPageHeader(); ?>
<?php
$m_ruang_view->ShowMessage();
?>
<form name="fm_ruangview" id="fm_ruangview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_ruang_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_ruang_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_ruang">
<?php if ($m_ruang_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($m_ruang->no->Visible) { // no ?>
	<tr id="r_no">
		<td><span id="elh_m_ruang_no"><?php echo $m_ruang->no->FldCaption() ?></span></td>
		<td data-name="no"<?php echo $m_ruang->no->CellAttributes() ?>>
<span id="el_m_ruang_no">
<span<?php echo $m_ruang->no->ViewAttributes() ?>>
<?php echo $m_ruang->no->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->nama->Visible) { // nama ?>
	<tr id="r_nama">
		<td><span id="elh_m_ruang_nama"><?php echo $m_ruang->nama->FldCaption() ?></span></td>
		<td data-name="nama"<?php echo $m_ruang->nama->CellAttributes() ?>>
<span id="el_m_ruang_nama">
<span<?php echo $m_ruang->nama->ViewAttributes() ?>>
<?php echo $m_ruang->nama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->kelas->Visible) { // kelas ?>
	<tr id="r_kelas">
		<td><span id="elh_m_ruang_kelas"><?php echo $m_ruang->kelas->FldCaption() ?></span></td>
		<td data-name="kelas"<?php echo $m_ruang->kelas->CellAttributes() ?>>
<span id="el_m_ruang_kelas">
<span<?php echo $m_ruang->kelas->ViewAttributes() ?>>
<?php echo $m_ruang->kelas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->ruang->Visible) { // ruang ?>
	<tr id="r_ruang">
		<td><span id="elh_m_ruang_ruang"><?php echo $m_ruang->ruang->FldCaption() ?></span></td>
		<td data-name="ruang"<?php echo $m_ruang->ruang->CellAttributes() ?>>
<span id="el_m_ruang_ruang">
<span<?php echo $m_ruang->ruang->ViewAttributes() ?>>
<?php echo $m_ruang->ruang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->jumlah_tt->Visible) { // jumlah_tt ?>
	<tr id="r_jumlah_tt">
		<td><span id="elh_m_ruang_jumlah_tt"><?php echo $m_ruang->jumlah_tt->FldCaption() ?></span></td>
		<td data-name="jumlah_tt"<?php echo $m_ruang->jumlah_tt->CellAttributes() ?>>
<div id="orig_m_ruang_jumlah_tt" class="hide">
<span id="el_m_ruang_jumlah_tt">
<span<?php echo $m_ruang->jumlah_tt->ViewAttributes() ?>>
<?php echo $m_ruang->jumlah_tt->ViewValue ?></span>
</span>
</div>
<div align="left">
	  <?php

        //include '../include/connect.php';
         include 'phpcon/koneksi.php';
	  	$idx=CurrentPage()->no->CurrentValue;
		$namarg=CurrentPage()->nama->CurrentValue;
		$detail="SELECT idxruang,no_tt,id FROM m_detail_tempat_tidur WHERE idxruang='".$idx."'";

		//$detail="SELECT id, ruang_id, bed  FROM m_ruang_detail WHERE ruang_id='".$idx."'";
		//print '<pre>'.$detail.'</pre>';

	  	$result=mysqli_query($conn,$detail);
	  	while($brs=@mysqli_fetch_array($result)){
		 $seleksi="SELECT id,no_tt,KETERANGAN FROM m_detail_tempat_tidur WHERE idxruang=".$brs['idxruang']." and id =".$brs['id']." ";

		 //$seleksi="SELECT id,KETERANGAN FROM m_ruang_detail WHERE ruang_id=".$brs['ruang_id']." and id =".$brs['id']." ";
		 //print $seleksi;
		 //print '<pre>'.$seleksi.'</pre>';

		 $hasilseleksi=mysqli_query($conn,$seleksi);
		 $rr = @mysqli_fetch_array($hasilseleksi);
		 $tt =  $rr["KETERANGAN"];
		 if ($tt != null){
				echo "<input class='btn btn-danger btn-lg' type=button name=button id=".$brs['no_tt']." value='Ruang.".$rr['no_tt']."-".$rr["KETERANGAN"]."' disabled><br/>";
		 }else{	
		 		echo "<input class='btn btn-success btn-lg'    type=button name=button id=".$brs['no_tt']." value='R.".$brs['no_tt']."- Kosong';><br/>";
		}
	}
	  ?>
</div>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->ket_ruang->Visible) { // ket_ruang ?>
	<tr id="r_ket_ruang">
		<td><span id="elh_m_ruang_ket_ruang"><?php echo $m_ruang->ket_ruang->FldCaption() ?></span></td>
		<td data-name="ket_ruang"<?php echo $m_ruang->ket_ruang->CellAttributes() ?>>
<span id="el_m_ruang_ket_ruang">
<span<?php echo $m_ruang->ket_ruang->ViewAttributes() ?>>
<?php echo $m_ruang->ket_ruang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->fasilitas->Visible) { // fasilitas ?>
	<tr id="r_fasilitas">
		<td><span id="elh_m_ruang_fasilitas"><?php echo $m_ruang->fasilitas->FldCaption() ?></span></td>
		<td data-name="fasilitas"<?php echo $m_ruang->fasilitas->CellAttributes() ?>>
<span id="el_m_ruang_fasilitas">
<span<?php echo $m_ruang->fasilitas->ViewAttributes() ?>>
<?php echo $m_ruang->fasilitas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->keterangan->Visible) { // keterangan ?>
	<tr id="r_keterangan">
		<td><span id="elh_m_ruang_keterangan"><?php echo $m_ruang->keterangan->FldCaption() ?></span></td>
		<td data-name="keterangan"<?php echo $m_ruang->keterangan->CellAttributes() ?>>
<span id="el_m_ruang_keterangan">
<span<?php echo $m_ruang->keterangan->ViewAttributes() ?>>
<?php echo $m_ruang->keterangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->kepala_ruangan->Visible) { // kepala_ruangan ?>
	<tr id="r_kepala_ruangan">
		<td><span id="elh_m_ruang_kepala_ruangan"><?php echo $m_ruang->kepala_ruangan->FldCaption() ?></span></td>
		<td data-name="kepala_ruangan"<?php echo $m_ruang->kepala_ruangan->CellAttributes() ?>>
<span id="el_m_ruang_kepala_ruangan">
<span<?php echo $m_ruang->kepala_ruangan->ViewAttributes() ?>>
<?php echo $m_ruang->kepala_ruangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->nip_kepala_ruangan->Visible) { // nip_kepala_ruangan ?>
	<tr id="r_nip_kepala_ruangan">
		<td><span id="elh_m_ruang_nip_kepala_ruangan"><?php echo $m_ruang->nip_kepala_ruangan->FldCaption() ?></span></td>
		<td data-name="nip_kepala_ruangan"<?php echo $m_ruang->nip_kepala_ruangan->CellAttributes() ?>>
<span id="el_m_ruang_nip_kepala_ruangan">
<span<?php echo $m_ruang->nip_kepala_ruangan->ViewAttributes() ?>>
<?php echo $m_ruang->nip_kepala_ruangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_ruang->group_id->Visible) { // group_id ?>
	<tr id="r_group_id">
		<td><span id="elh_m_ruang_group_id"><?php echo $m_ruang->group_id->FldCaption() ?></span></td>
		<td data-name="group_id"<?php echo $m_ruang->group_id->CellAttributes() ?>>
<span id="el_m_ruang_group_id">
<span<?php echo $m_ruang->group_id->ViewAttributes() ?>>
<?php echo $m_ruang->group_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fm_ruangview.Init();
</script>
<?php
$m_ruang_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_ruang_view->Page_Terminate();
?>
