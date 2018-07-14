<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_spp_detailinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_spp_up_listinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_spp_detail_view = NULL; // Initialize page object first

class ct_spp_detail_view extends ct_spp_detail {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_spp_detail';

	// Page object name
	var $PageObjName = 't_spp_detail_view';

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

		// Table object (t_spp_detail)
		if (!isset($GLOBALS["t_spp_detail"]) || get_class($GLOBALS["t_spp_detail"]) == "ct_spp_detail") {
			$GLOBALS["t_spp_detail"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_spp_detail"];
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

		// Table object (vw_spp_up_list)
		if (!isset($GLOBALS['vw_spp_up_list'])) $GLOBALS['vw_spp_up_list'] = new cvw_spp_up_list();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_spp_detail', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_spp_detaillist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->id_spp->SetVisibility();
		$this->id_jenis_spp->SetVisibility();
		$this->detail_jenis_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();
		$this->kd_rekening_belanja->SetVisibility();
		$this->tahun_anggaran->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();
		$this->jumlah_belanja->SetVisibility();

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
		global $EW_EXPORT, $t_spp_detail;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_spp_detail);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "t_spp_detaillist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t_spp_detaillist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "t_spp_detaillist.php"; // Not page request, return to list
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
		$this->id->setDbValue($rs->fields('id'));
		$this->id_spp->setDbValue($rs->fields('id_spp'));
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->kd_rekening_belanja->setDbValue($rs->fields('kd_rekening_belanja'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_spp->DbValue = $row['id_spp'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->kd_rekening_belanja->DbValue = $row['kd_rekening_belanja'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
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

		// Convert decimal values if posted back
		if ($this->jumlah_belanja->FormValue == $this->jumlah_belanja->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_belanja->CurrentValue)))
			$this->jumlah_belanja->CurrentValue = ew_StrToFloat($this->jumlah_belanja->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_spp
		// id_jenis_spp
		// detail_jenis_spp
		// no_spp
		// program
		// kegiatan
		// sub_kegiatan
		// kd_rekening_belanja
		// tahun_anggaran
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5
		// jumlah_belanja

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_spp
		$this->id_spp->ViewValue = $this->id_spp->CurrentValue;
		$this->id_spp->ViewCustomAttributes = "";

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// kd_rekening_belanja
		if (strval($this->kd_rekening_belanja->CurrentValue) <> "") {
			$sFilterWrk = "`kd_akun`" . ew_SearchString("=", $this->kd_rekening_belanja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kd_akun`, `nama_akun` AS `DispFld`, `kd_akun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
		$sWhereWrk = "";
		$this->kd_rekening_belanja->LookupFilters = array();
		$lookuptblfilter = "`kd_akun` = '1.1.1.01.02'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kd_rekening_belanja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->kd_rekening_belanja->ViewValue = $this->kd_rekening_belanja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kd_rekening_belanja->ViewValue = $this->kd_rekening_belanja->CurrentValue;
			}
		} else {
			$this->kd_rekening_belanja->ViewValue = NULL;
		}
		$this->kd_rekening_belanja->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		$this->akun2->ViewValue = $this->akun2->CurrentValue;
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		$this->akun3->ViewValue = $this->akun3->CurrentValue;
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		$this->akun4->ViewValue = $this->akun4->CurrentValue;
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		$this->akun5->ViewValue = $this->akun5->CurrentValue;
		$this->akun5->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// id_spp
			$this->id_spp->LinkCustomAttributes = "";
			$this->id_spp->HrefValue = "";
			$this->id_spp->TooltipValue = "";

			// id_jenis_spp
			$this->id_jenis_spp->LinkCustomAttributes = "";
			$this->id_jenis_spp->HrefValue = "";
			$this->id_jenis_spp->TooltipValue = "";

			// detail_jenis_spp
			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";
			$this->detail_jenis_spp->TooltipValue = "";

			// no_spp
			$this->no_spp->LinkCustomAttributes = "";
			$this->no_spp->HrefValue = "";
			$this->no_spp->TooltipValue = "";

			// program
			$this->program->LinkCustomAttributes = "";
			$this->program->HrefValue = "";
			$this->program->TooltipValue = "";

			// kegiatan
			$this->kegiatan->LinkCustomAttributes = "";
			$this->kegiatan->HrefValue = "";
			$this->kegiatan->TooltipValue = "";

			// sub_kegiatan
			$this->sub_kegiatan->LinkCustomAttributes = "";
			$this->sub_kegiatan->HrefValue = "";
			$this->sub_kegiatan->TooltipValue = "";

			// kd_rekening_belanja
			$this->kd_rekening_belanja->LinkCustomAttributes = "";
			$this->kd_rekening_belanja->HrefValue = "";
			$this->kd_rekening_belanja->TooltipValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

			// akun1
			$this->akun1->LinkCustomAttributes = "";
			$this->akun1->HrefValue = "";
			$this->akun1->TooltipValue = "";

			// akun2
			$this->akun2->LinkCustomAttributes = "";
			$this->akun2->HrefValue = "";
			$this->akun2->TooltipValue = "";

			// akun3
			$this->akun3->LinkCustomAttributes = "";
			$this->akun3->HrefValue = "";
			$this->akun3->TooltipValue = "";

			// akun4
			$this->akun4->LinkCustomAttributes = "";
			$this->akun4->HrefValue = "";
			$this->akun4->TooltipValue = "";

			// akun5
			$this->akun5->LinkCustomAttributes = "";
			$this->akun5->HrefValue = "";
			$this->akun5->TooltipValue = "";

			// jumlah_belanja
			$this->jumlah_belanja->LinkCustomAttributes = "";
			$this->jumlah_belanja->HrefValue = "";
			$this->jumlah_belanja->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
			if ($sMasterTblVar == "vw_spp_up_list") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["vw_spp_up_list"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_spp->setQueryStringValue($GLOBALS["vw_spp_up_list"]->id->QueryStringValue);
					$this->id_spp->setSessionValue($this->id_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_up_list"]->id_jenis_spp->setQueryStringValue($_GET["fk_id_jenis_spp"]);
					$this->id_jenis_spp->setQueryStringValue($GLOBALS["vw_spp_up_list"]->id_jenis_spp->QueryStringValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->id_jenis_spp->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_detail_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_up_list"]->detail_jenis_spp->setQueryStringValue($_GET["fk_detail_jenis_spp"]);
					$this->detail_jenis_spp->setQueryStringValue($GLOBALS["vw_spp_up_list"]->detail_jenis_spp->QueryStringValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->detail_jenis_spp->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_no_spp"] <> "") {
					$GLOBALS["vw_spp_up_list"]->no_spp->setQueryStringValue($_GET["fk_no_spp"]);
					$this->no_spp->setQueryStringValue($GLOBALS["vw_spp_up_list"]->no_spp->QueryStringValue);
					$this->no_spp->setSessionValue($this->no_spp->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_program"] <> "") {
					$GLOBALS["vw_spp_up_list"]->kode_program->setQueryStringValue($_GET["fk_kode_program"]);
					$this->program->setQueryStringValue($GLOBALS["vw_spp_up_list"]->kode_program->QueryStringValue);
					$this->program->setSessionValue($this->program->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_kegiatan"] <> "") {
					$GLOBALS["vw_spp_up_list"]->kode_kegiatan->setQueryStringValue($_GET["fk_kode_kegiatan"]);
					$this->kegiatan->setQueryStringValue($GLOBALS["vw_spp_up_list"]->kode_kegiatan->QueryStringValue);
					$this->kegiatan->setSessionValue($this->kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["vw_spp_up_list"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["vw_spp_up_list"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "vw_spp_up_list") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["vw_spp_up_list"]->id->setFormValue($_POST["fk_id"]);
					$this->id_spp->setFormValue($GLOBALS["vw_spp_up_list"]->id->FormValue);
					$this->id_spp->setSessionValue($this->id_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_up_list"]->id_jenis_spp->setFormValue($_POST["fk_id_jenis_spp"]);
					$this->id_jenis_spp->setFormValue($GLOBALS["vw_spp_up_list"]->id_jenis_spp->FormValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->id_jenis_spp->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_detail_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_up_list"]->detail_jenis_spp->setFormValue($_POST["fk_detail_jenis_spp"]);
					$this->detail_jenis_spp->setFormValue($GLOBALS["vw_spp_up_list"]->detail_jenis_spp->FormValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->detail_jenis_spp->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_no_spp"] <> "") {
					$GLOBALS["vw_spp_up_list"]->no_spp->setFormValue($_POST["fk_no_spp"]);
					$this->no_spp->setFormValue($GLOBALS["vw_spp_up_list"]->no_spp->FormValue);
					$this->no_spp->setSessionValue($this->no_spp->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_program"] <> "") {
					$GLOBALS["vw_spp_up_list"]->kode_program->setFormValue($_POST["fk_kode_program"]);
					$this->program->setFormValue($GLOBALS["vw_spp_up_list"]->kode_program->FormValue);
					$this->program->setSessionValue($this->program->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_kegiatan"] <> "") {
					$GLOBALS["vw_spp_up_list"]->kode_kegiatan->setFormValue($_POST["fk_kode_kegiatan"]);
					$this->kegiatan->setFormValue($GLOBALS["vw_spp_up_list"]->kode_kegiatan->FormValue);
					$this->kegiatan->setSessionValue($this->kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["vw_spp_up_list"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["vw_spp_up_list"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_up_list"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "vw_spp_up_list") {
				if ($this->id_spp->CurrentValue == "") $this->id_spp->setSessionValue("");
				if ($this->id_jenis_spp->CurrentValue == "") $this->id_jenis_spp->setSessionValue("");
				if ($this->detail_jenis_spp->CurrentValue == "") $this->detail_jenis_spp->setSessionValue("");
				if ($this->no_spp->CurrentValue == "") $this->no_spp->setSessionValue("");
				if ($this->program->CurrentValue == "") $this->program->setSessionValue("");
				if ($this->kegiatan->CurrentValue == "") $this->kegiatan->setSessionValue("");
				if ($this->tahun_anggaran->CurrentValue == "") $this->tahun_anggaran->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_spp_detaillist.php"), "", $this->TableVar, TRUE);
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
if (!isset($t_spp_detail_view)) $t_spp_detail_view = new ct_spp_detail_view();

// Page init
$t_spp_detail_view->Page_Init();

// Page main
$t_spp_detail_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_spp_detail_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft_spp_detailview = new ew_Form("ft_spp_detailview", "view");

// Form_CustomValidate event
ft_spp_detailview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_spp_detailview.ValidateRequired = true;
<?php } else { ?>
ft_spp_detailview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_spp_detailview.Lists["x_kd_rekening_belanja"] = {"LinkField":"x_kd_akun","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_akun","x_kd_akun","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun5"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_spp_detail_view->IsModal) { ?>
<?php } ?>
<?php $t_spp_detail_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t_spp_detail_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$t_spp_detail_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $t_spp_detail_view->ShowPageHeader(); ?>
<?php
$t_spp_detail_view->ShowMessage();
?>
<form name="ft_spp_detailview" id="ft_spp_detailview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_spp_detail_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_spp_detail_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_spp_detail">
<?php if ($t_spp_detail_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($t_spp_detail->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_t_spp_detail_id"><?php echo $t_spp_detail->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $t_spp_detail->id->CellAttributes() ?>>
<span id="el_t_spp_detail_id">
<span<?php echo $t_spp_detail->id->ViewAttributes() ?>>
<?php echo $t_spp_detail->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->id_spp->Visible) { // id_spp ?>
	<tr id="r_id_spp">
		<td><span id="elh_t_spp_detail_id_spp"><?php echo $t_spp_detail->id_spp->FldCaption() ?></span></td>
		<td data-name="id_spp"<?php echo $t_spp_detail->id_spp->CellAttributes() ?>>
<span id="el_t_spp_detail_id_spp">
<span<?php echo $t_spp_detail->id_spp->ViewAttributes() ?>>
<?php echo $t_spp_detail->id_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->id_jenis_spp->Visible) { // id_jenis_spp ?>
	<tr id="r_id_jenis_spp">
		<td><span id="elh_t_spp_detail_id_jenis_spp"><?php echo $t_spp_detail->id_jenis_spp->FldCaption() ?></span></td>
		<td data-name="id_jenis_spp"<?php echo $t_spp_detail->id_jenis_spp->CellAttributes() ?>>
<span id="el_t_spp_detail_id_jenis_spp">
<span<?php echo $t_spp_detail->id_jenis_spp->ViewAttributes() ?>>
<?php echo $t_spp_detail->id_jenis_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<tr id="r_detail_jenis_spp">
		<td><span id="elh_t_spp_detail_detail_jenis_spp"><?php echo $t_spp_detail->detail_jenis_spp->FldCaption() ?></span></td>
		<td data-name="detail_jenis_spp"<?php echo $t_spp_detail->detail_jenis_spp->CellAttributes() ?>>
<span id="el_t_spp_detail_detail_jenis_spp">
<span<?php echo $t_spp_detail->detail_jenis_spp->ViewAttributes() ?>>
<?php echo $t_spp_detail->detail_jenis_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->no_spp->Visible) { // no_spp ?>
	<tr id="r_no_spp">
		<td><span id="elh_t_spp_detail_no_spp"><?php echo $t_spp_detail->no_spp->FldCaption() ?></span></td>
		<td data-name="no_spp"<?php echo $t_spp_detail->no_spp->CellAttributes() ?>>
<span id="el_t_spp_detail_no_spp">
<span<?php echo $t_spp_detail->no_spp->ViewAttributes() ?>>
<?php echo $t_spp_detail->no_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->program->Visible) { // program ?>
	<tr id="r_program">
		<td><span id="elh_t_spp_detail_program"><?php echo $t_spp_detail->program->FldCaption() ?></span></td>
		<td data-name="program"<?php echo $t_spp_detail->program->CellAttributes() ?>>
<span id="el_t_spp_detail_program">
<span<?php echo $t_spp_detail->program->ViewAttributes() ?>>
<?php echo $t_spp_detail->program->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->kegiatan->Visible) { // kegiatan ?>
	<tr id="r_kegiatan">
		<td><span id="elh_t_spp_detail_kegiatan"><?php echo $t_spp_detail->kegiatan->FldCaption() ?></span></td>
		<td data-name="kegiatan"<?php echo $t_spp_detail->kegiatan->CellAttributes() ?>>
<span id="el_t_spp_detail_kegiatan">
<span<?php echo $t_spp_detail->kegiatan->ViewAttributes() ?>>
<?php echo $t_spp_detail->kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<tr id="r_sub_kegiatan">
		<td><span id="elh_t_spp_detail_sub_kegiatan"><?php echo $t_spp_detail->sub_kegiatan->FldCaption() ?></span></td>
		<td data-name="sub_kegiatan"<?php echo $t_spp_detail->sub_kegiatan->CellAttributes() ?>>
<span id="el_t_spp_detail_sub_kegiatan">
<span<?php echo $t_spp_detail->sub_kegiatan->ViewAttributes() ?>>
<?php echo $t_spp_detail->sub_kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
	<tr id="r_kd_rekening_belanja">
		<td><span id="elh_t_spp_detail_kd_rekening_belanja"><?php echo $t_spp_detail->kd_rekening_belanja->FldCaption() ?></span></td>
		<td data-name="kd_rekening_belanja"<?php echo $t_spp_detail->kd_rekening_belanja->CellAttributes() ?>>
<span id="el_t_spp_detail_kd_rekening_belanja">
<span<?php echo $t_spp_detail->kd_rekening_belanja->ViewAttributes() ?>>
<?php echo $t_spp_detail->kd_rekening_belanja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<tr id="r_tahun_anggaran">
		<td><span id="elh_t_spp_detail_tahun_anggaran"><?php echo $t_spp_detail->tahun_anggaran->FldCaption() ?></span></td>
		<td data-name="tahun_anggaran"<?php echo $t_spp_detail->tahun_anggaran->CellAttributes() ?>>
<span id="el_t_spp_detail_tahun_anggaran">
<span<?php echo $t_spp_detail->tahun_anggaran->ViewAttributes() ?>>
<?php echo $t_spp_detail->tahun_anggaran->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->akun1->Visible) { // akun1 ?>
	<tr id="r_akun1">
		<td><span id="elh_t_spp_detail_akun1"><?php echo $t_spp_detail->akun1->FldCaption() ?></span></td>
		<td data-name="akun1"<?php echo $t_spp_detail->akun1->CellAttributes() ?>>
<span id="el_t_spp_detail_akun1">
<span<?php echo $t_spp_detail->akun1->ViewAttributes() ?>>
<?php echo $t_spp_detail->akun1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->akun2->Visible) { // akun2 ?>
	<tr id="r_akun2">
		<td><span id="elh_t_spp_detail_akun2"><?php echo $t_spp_detail->akun2->FldCaption() ?></span></td>
		<td data-name="akun2"<?php echo $t_spp_detail->akun2->CellAttributes() ?>>
<span id="el_t_spp_detail_akun2">
<span<?php echo $t_spp_detail->akun2->ViewAttributes() ?>>
<?php echo $t_spp_detail->akun2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->akun3->Visible) { // akun3 ?>
	<tr id="r_akun3">
		<td><span id="elh_t_spp_detail_akun3"><?php echo $t_spp_detail->akun3->FldCaption() ?></span></td>
		<td data-name="akun3"<?php echo $t_spp_detail->akun3->CellAttributes() ?>>
<span id="el_t_spp_detail_akun3">
<span<?php echo $t_spp_detail->akun3->ViewAttributes() ?>>
<?php echo $t_spp_detail->akun3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->akun4->Visible) { // akun4 ?>
	<tr id="r_akun4">
		<td><span id="elh_t_spp_detail_akun4"><?php echo $t_spp_detail->akun4->FldCaption() ?></span></td>
		<td data-name="akun4"<?php echo $t_spp_detail->akun4->CellAttributes() ?>>
<span id="el_t_spp_detail_akun4">
<span<?php echo $t_spp_detail->akun4->ViewAttributes() ?>>
<?php echo $t_spp_detail->akun4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->akun5->Visible) { // akun5 ?>
	<tr id="r_akun5">
		<td><span id="elh_t_spp_detail_akun5"><?php echo $t_spp_detail->akun5->FldCaption() ?></span></td>
		<td data-name="akun5"<?php echo $t_spp_detail->akun5->CellAttributes() ?>>
<span id="el_t_spp_detail_akun5">
<span<?php echo $t_spp_detail->akun5->ViewAttributes() ?>>
<?php echo $t_spp_detail->akun5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_spp_detail->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<tr id="r_jumlah_belanja">
		<td><span id="elh_t_spp_detail_jumlah_belanja"><?php echo $t_spp_detail->jumlah_belanja->FldCaption() ?></span></td>
		<td data-name="jumlah_belanja"<?php echo $t_spp_detail->jumlah_belanja->CellAttributes() ?>>
<span id="el_t_spp_detail_jumlah_belanja">
<span<?php echo $t_spp_detail->jumlah_belanja->ViewAttributes() ?>>
<?php echo $t_spp_detail->jumlah_belanja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
ft_spp_detailview.Init();
</script>
<?php
$t_spp_detail_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_spp_detail_view->Page_Terminate();
?>
