<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_ls_kontrak_listinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_ls_kontrak_list_view = NULL; // Initialize page object first

class cvw_spp_ls_kontrak_list_view extends cvw_spp_ls_kontrak_list {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_ls_kontrak_list';

	// Page object name
	var $PageObjName = 'vw_spp_ls_kontrak_list_view';

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

		// Table object (vw_spp_ls_kontrak_list)
		if (!isset($GLOBALS["vw_spp_ls_kontrak_list"]) || get_class($GLOBALS["vw_spp_ls_kontrak_list"]) == "cvw_spp_ls_kontrak_list") {
			$GLOBALS["vw_spp_ls_kontrak_list"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_ls_kontrak_list"];
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
			define("EW_TABLE_NAME", 'vw_spp_ls_kontrak_list', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_ls_kontrak_listlist.php"));
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
		$this->id_jenis_spp->SetVisibility();
		$this->detail_jenis_spp->SetVisibility();
		$this->status_spp->SetVisibility();
		$this->no_spp->SetVisibility();
		$this->tgl_spp->SetVisibility();
		$this->nama_pptk->SetVisibility();
		$this->nip_pptk->SetVisibility();
		$this->keterangan->SetVisibility();
		$this->pph21->SetVisibility();
		$this->pph22->SetVisibility();
		$this->pph23->SetVisibility();
		$this->pph4->SetVisibility();
		$this->nama_bendahara->SetVisibility();
		$this->nip_bendahara->SetVisibility();
		$this->kode_program->SetVisibility();
		$this->kode_kegiatan->SetVisibility();
		$this->kode_sub_kegiatan->SetVisibility();
		$this->jumlah_belanja->SetVisibility();
		$this->kontrak_id->SetVisibility();
		$this->kode_rekening->SetVisibility();
		$this->akun1->SetVisibility();
		$this->akun2->SetVisibility();
		$this->akun3->SetVisibility();
		$this->akun4->SetVisibility();
		$this->akun5->SetVisibility();

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
		global $EW_EXPORT, $vw_spp_ls_kontrak_list;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_ls_kontrak_list);
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
				$sReturnUrl = "vw_spp_ls_kontrak_listlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "vw_spp_ls_kontrak_listlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "vw_spp_ls_kontrak_listlist.php"; // Not page request, return to list
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
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->status_spp->setDbValue($rs->fields('status_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->pph21->setDbValue($rs->fields('pph21'));
		$this->pph22->setDbValue($rs->fields('pph22'));
		$this->pph23->setDbValue($rs->fields('pph23'));
		$this->pph4->setDbValue($rs->fields('pph4'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->kontrak_id->setDbValue($rs->fields('kontrak_id'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->status_spp->DbValue = $row['status_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->tgl_spp->DbValue = $row['tgl_spp'];
		$this->nama_pptk->DbValue = $row['nama_pptk'];
		$this->nip_pptk->DbValue = $row['nip_pptk'];
		$this->keterangan->DbValue = $row['keterangan'];
		$this->pph21->DbValue = $row['pph21'];
		$this->pph22->DbValue = $row['pph22'];
		$this->pph23->DbValue = $row['pph23'];
		$this->pph4->DbValue = $row['pph4'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
		$this->kontrak_id->DbValue = $row['kontrak_id'];
		$this->kode_rekening->DbValue = $row['kode_rekening'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
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
		if ($this->pph21->FormValue == $this->pph21->CurrentValue && is_numeric(ew_StrToFloat($this->pph21->CurrentValue)))
			$this->pph21->CurrentValue = ew_StrToFloat($this->pph21->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pph22->FormValue == $this->pph22->CurrentValue && is_numeric(ew_StrToFloat($this->pph22->CurrentValue)))
			$this->pph22->CurrentValue = ew_StrToFloat($this->pph22->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pph23->FormValue == $this->pph23->CurrentValue && is_numeric(ew_StrToFloat($this->pph23->CurrentValue)))
			$this->pph23->CurrentValue = ew_StrToFloat($this->pph23->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pph4->FormValue == $this->pph4->CurrentValue && is_numeric(ew_StrToFloat($this->pph4->CurrentValue)))
			$this->pph4->CurrentValue = ew_StrToFloat($this->pph4->CurrentValue);

		// Convert decimal values if posted back
		if ($this->jumlah_belanja->FormValue == $this->jumlah_belanja->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_belanja->CurrentValue)))
			$this->jumlah_belanja->CurrentValue = ew_StrToFloat($this->jumlah_belanja->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_jenis_spp
		// detail_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// nama_pptk
		// nip_pptk
		// keterangan
		// pph21
		// pph22
		// pph23
		// pph4
		// nama_bendahara
		// nip_bendahara
		// kode_program
		// kode_kegiatan
		// kode_sub_kegiatan
		// jumlah_belanja
		// kontrak_id
		// kode_rekening
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_jenis_spp
		if (strval($this->id_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_spp`";
		$sWhereWrk = "";
		$this->id_jenis_spp->LookupFilters = array();
		$lookuptblfilter = "`id`=4";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
			}
		} else {
			$this->id_jenis_spp->ViewValue = NULL;
		}
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// detail_jenis_spp
		if (strval($this->detail_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->detail_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_detail_spp`";
		$sWhereWrk = "";
		$this->detail_jenis_spp->LookupFilters = array();
		$lookuptblfilter = "`id`=6";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
			}
		} else {
			$this->detail_jenis_spp->ViewValue = NULL;
		}
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// status_spp
		if (strval($this->status_spp->CurrentValue) <> "") {
			$this->status_spp->ViewValue = $this->status_spp->OptionCaption($this->status_spp->CurrentValue);
		} else {
			$this->status_spp->ViewValue = NULL;
		}
		$this->status_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// tgl_spp
		$this->tgl_spp->ViewValue = $this->tgl_spp->CurrentValue;
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 7);
		$this->tgl_spp->ViewCustomAttributes = "";

		// nama_pptk
		if (strval($this->nama_pptk->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_pptk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_pptk->LookupFilters = array();
		$lookuptblfilter = "`id`=4";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_pptk->ViewValue = $this->nama_pptk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_pptk->ViewValue = $this->nama_pptk->CurrentValue;
			}
		} else {
			$this->nama_pptk->ViewValue = NULL;
		}
		$this->nama_pptk->ViewCustomAttributes = "";

		// nip_pptk
		$this->nip_pptk->ViewValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// pph21
		$this->pph21->ViewValue = $this->pph21->CurrentValue;
		$this->pph21->ViewCustomAttributes = "";

		// pph22
		$this->pph22->ViewValue = $this->pph22->CurrentValue;
		$this->pph22->ViewCustomAttributes = "";

		// pph23
		$this->pph23->ViewValue = $this->pph23->CurrentValue;
		$this->pph23->ViewCustomAttributes = "";

		// pph4
		$this->pph4->ViewValue = $this->pph4->CurrentValue;
		$this->pph4->ViewCustomAttributes = "";

		// nama_bendahara
		if (strval($this->nama_bendahara->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_bendahara->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_bendahara->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->CurrentValue;
			}
		} else {
			$this->nama_bendahara->ViewValue = NULL;
		}
		$this->nama_bendahara->ViewCustomAttributes = "";

		// nip_bendahara
		$this->nip_bendahara->ViewValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->ViewCustomAttributes = "";

		// kode_program
		$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
		$this->kode_program->ViewCustomAttributes = "";

		// kode_kegiatan
		$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->CurrentValue;
		$this->kode_kegiatan->ViewCustomAttributes = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->CurrentValue;
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

		// kontrak_id
		if (strval($this->kontrak_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->kontrak_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama_perusahaan` AS `DispFld`, `tgl_kontrak` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `data_kontrak`";
		$sWhereWrk = "";
		$this->kontrak_id->LookupFilters = array("dx1" => '`nama_perusahaan`', "df2" => "0", "dx2" => ew_CastDateFieldForLike('`tgl_kontrak`', 0, "DB"));
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kontrak_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = ew_FormatDateTime($rswrk->fields('Disp2Fld'), 0);
				$this->kontrak_id->ViewValue = $this->kontrak_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kontrak_id->ViewValue = $this->kontrak_id->CurrentValue;
			}
		} else {
			$this->kontrak_id->ViewValue = NULL;
		}
		$this->kontrak_id->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// akun1
		if (strval($this->akun1->CurrentValue) <> "") {
			$sFilterWrk = "`kel1`" . ew_SearchString("=", $this->akun1->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kel1`, `nmkel1` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun1`";
		$sWhereWrk = "";
		$this->akun1->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun1, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun1->ViewValue = $this->akun1->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun1->ViewValue = $this->akun1->CurrentValue;
			}
		} else {
			$this->akun1->ViewValue = NULL;
		}
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		if (strval($this->akun2->CurrentValue) <> "") {
			$sFilterWrk = "`kel2`" . ew_SearchString("=", $this->akun2->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel2`, `nmkel2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun2`";
		$sWhereWrk = "";
		$this->akun2->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun2, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun2->ViewValue = $this->akun2->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun2->ViewValue = $this->akun2->CurrentValue;
			}
		} else {
			$this->akun2->ViewValue = NULL;
		}
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		if (strval($this->akun3->CurrentValue) <> "") {
			$sFilterWrk = "`kel3`" . ew_SearchString("=", $this->akun3->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel3`, `nmkel3` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun3`";
		$sWhereWrk = "";
		$this->akun3->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun3, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun3->ViewValue = $this->akun3->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun3->ViewValue = $this->akun3->CurrentValue;
			}
		} else {
			$this->akun3->ViewValue = NULL;
		}
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		if (strval($this->akun4->CurrentValue) <> "") {
			$sFilterWrk = "`kel4`" . ew_SearchString("=", $this->akun4->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel4`, `nmkel4` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun4`";
		$sWhereWrk = "";
		$this->akun4->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun4, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun4->ViewValue = $this->akun4->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun4->ViewValue = $this->akun4->CurrentValue;
			}
		} else {
			$this->akun4->ViewValue = NULL;
		}
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		if (strval($this->akun5->CurrentValue) <> "") {
			$sFilterWrk = "`akun5`" . ew_SearchString("=", $this->akun5->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `akun5`, `nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
		$sWhereWrk = "";
		$this->akun5->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun5, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun5->ViewValue = $this->akun5->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun5->ViewValue = $this->akun5->CurrentValue;
			}
		} else {
			$this->akun5->ViewValue = NULL;
		}
		$this->akun5->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// id_jenis_spp
			$this->id_jenis_spp->LinkCustomAttributes = "";
			$this->id_jenis_spp->HrefValue = "";
			$this->id_jenis_spp->TooltipValue = "";

			// detail_jenis_spp
			$this->detail_jenis_spp->LinkCustomAttributes = "";
			$this->detail_jenis_spp->HrefValue = "";
			$this->detail_jenis_spp->TooltipValue = "";

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

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";
			$this->nama_pptk->TooltipValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";
			$this->nip_pptk->TooltipValue = "";

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

			// pph21
			$this->pph21->LinkCustomAttributes = "";
			$this->pph21->HrefValue = "";
			$this->pph21->TooltipValue = "";

			// pph22
			$this->pph22->LinkCustomAttributes = "";
			$this->pph22->HrefValue = "";
			$this->pph22->TooltipValue = "";

			// pph23
			$this->pph23->LinkCustomAttributes = "";
			$this->pph23->HrefValue = "";
			$this->pph23->TooltipValue = "";

			// pph4
			$this->pph4->LinkCustomAttributes = "";
			$this->pph4->HrefValue = "";
			$this->pph4->TooltipValue = "";

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";
			$this->nama_bendahara->TooltipValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";
			$this->nip_bendahara->TooltipValue = "";

			// kode_program
			$this->kode_program->LinkCustomAttributes = "";
			$this->kode_program->HrefValue = "";
			$this->kode_program->TooltipValue = "";

			// kode_kegiatan
			$this->kode_kegiatan->LinkCustomAttributes = "";
			$this->kode_kegiatan->HrefValue = "";
			$this->kode_kegiatan->TooltipValue = "";

			// kode_sub_kegiatan
			$this->kode_sub_kegiatan->LinkCustomAttributes = "";
			$this->kode_sub_kegiatan->HrefValue = "";
			$this->kode_sub_kegiatan->TooltipValue = "";

			// jumlah_belanja
			$this->jumlah_belanja->LinkCustomAttributes = "";
			$this->jumlah_belanja->HrefValue = "";
			$this->jumlah_belanja->TooltipValue = "";

			// kontrak_id
			$this->kontrak_id->LinkCustomAttributes = "";
			$this->kontrak_id->HrefValue = "";
			$this->kontrak_id->TooltipValue = "";

			// kode_rekening
			$this->kode_rekening->LinkCustomAttributes = "";
			$this->kode_rekening->HrefValue = "";
			$this->kode_rekening->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_ls_kontrak_listlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($vw_spp_ls_kontrak_list_view)) $vw_spp_ls_kontrak_list_view = new cvw_spp_ls_kontrak_list_view();

// Page init
$vw_spp_ls_kontrak_list_view->Page_Init();

// Page main
$vw_spp_ls_kontrak_list_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_ls_kontrak_list_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fvw_spp_ls_kontrak_listview = new ew_Form("fvw_spp_ls_kontrak_listview", "view");

// Form_CustomValidate event
fvw_spp_ls_kontrak_listview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_ls_kontrak_listview.ValidateRequired = true;
<?php } else { ?>
fvw_spp_ls_kontrak_listview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_ls_kontrak_listview.Lists["x_id_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_spp","","",""],"ParentFields":[],"ChildFields":["x_detail_jenis_spp"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_spp"};
fvw_spp_ls_kontrak_listview.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
fvw_spp_ls_kontrak_listview.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spp_ls_kontrak_listview.Lists["x_status_spp"].Options = <?php echo json_encode($vw_spp_ls_kontrak_list->status_spp->Options()) ?>;
fvw_spp_ls_kontrak_listview.Lists["x_nama_pptk"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
fvw_spp_ls_kontrak_listview.Lists["x_nama_bendahara"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
fvw_spp_ls_kontrak_listview.Lists["x_kontrak_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_perusahaan","x_tgl_kontrak","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"data_kontrak"};
fvw_spp_ls_kontrak_listview.Lists["x_akun1"] = {"LinkField":"x_kel1","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel1","","",""],"ParentFields":[],"ChildFields":["x_akun2","x_akun4","x_akun5"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun1"};
fvw_spp_ls_kontrak_listview.Lists["x_akun2"] = {"LinkField":"x_kel2","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel2","","",""],"ParentFields":[],"ChildFields":["x_akun3","x_akun4","x_akun5"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun2"};
fvw_spp_ls_kontrak_listview.Lists["x_akun3"] = {"LinkField":"x_kel3","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel3","","",""],"ParentFields":[],"ChildFields":["x_akun4","x_akun5"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun3"};
fvw_spp_ls_kontrak_listview.Lists["x_akun4"] = {"LinkField":"x_kel4","Ajax":true,"AutoFill":false,"DisplayFields":["x_nmkel4","","",""],"ParentFields":[],"ChildFields":["x_akun5"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun4"};
fvw_spp_ls_kontrak_listview.Lists["x_akun5"] = {"LinkField":"x_akun5","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_akun","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun5"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_ls_kontrak_list_view->IsModal) { ?>
<?php } ?>
<?php $vw_spp_ls_kontrak_list_view->ExportOptions->Render("body") ?>
<?php
	foreach ($vw_spp_ls_kontrak_list_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$vw_spp_ls_kontrak_list_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $vw_spp_ls_kontrak_list_view->ShowPageHeader(); ?>
<?php
$vw_spp_ls_kontrak_list_view->ShowMessage();
?>
<form name="fvw_spp_ls_kontrak_listview" id="fvw_spp_ls_kontrak_listview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_ls_kontrak_list_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_ls_kontrak_list_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_ls_kontrak_list">
<?php if ($vw_spp_ls_kontrak_list_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($vw_spp_ls_kontrak_list->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_vw_spp_ls_kontrak_list_id"><?php echo $vw_spp_ls_kontrak_list->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $vw_spp_ls_kontrak_list->id->CellAttributes() ?>>
<div id="orig_vw_spp_ls_kontrak_list_id" class="hide">
<span id="el_vw_spp_ls_kontrak_list_id">
<span<?php echo $vw_spp_ls_kontrak_list->id->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->id->ViewValue ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r == 7)
{ ?>
	<a class="btn btn-success btn-xs"  target="_blank" href="cetak_spp_ls_barang_jasa.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK SPP
	 <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a>
<?php
}else {
 }
?>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->id_jenis_spp->Visible) { // id_jenis_spp ?>
	<tr id="r_id_jenis_spp">
		<td><span id="elh_vw_spp_ls_kontrak_list_id_jenis_spp"><?php echo $vw_spp_ls_kontrak_list->id_jenis_spp->FldCaption() ?></span></td>
		<td data-name="id_jenis_spp"<?php echo $vw_spp_ls_kontrak_list->id_jenis_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_id_jenis_spp">
<span<?php echo $vw_spp_ls_kontrak_list->id_jenis_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->id_jenis_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<tr id="r_detail_jenis_spp">
		<td><span id="elh_vw_spp_ls_kontrak_list_detail_jenis_spp"><?php echo $vw_spp_ls_kontrak_list->detail_jenis_spp->FldCaption() ?></span></td>
		<td data-name="detail_jenis_spp"<?php echo $vw_spp_ls_kontrak_list->detail_jenis_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_detail_jenis_spp">
<span<?php echo $vw_spp_ls_kontrak_list->detail_jenis_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->detail_jenis_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->status_spp->Visible) { // status_spp ?>
	<tr id="r_status_spp">
		<td><span id="elh_vw_spp_ls_kontrak_list_status_spp"><?php echo $vw_spp_ls_kontrak_list->status_spp->FldCaption() ?></span></td>
		<td data-name="status_spp"<?php echo $vw_spp_ls_kontrak_list->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_status_spp">
<span<?php echo $vw_spp_ls_kontrak_list->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->status_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->no_spp->Visible) { // no_spp ?>
	<tr id="r_no_spp">
		<td><span id="elh_vw_spp_ls_kontrak_list_no_spp"><?php echo $vw_spp_ls_kontrak_list->no_spp->FldCaption() ?></span></td>
		<td data-name="no_spp"<?php echo $vw_spp_ls_kontrak_list->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_no_spp">
<span<?php echo $vw_spp_ls_kontrak_list->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->no_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->tgl_spp->Visible) { // tgl_spp ?>
	<tr id="r_tgl_spp">
		<td><span id="elh_vw_spp_ls_kontrak_list_tgl_spp"><?php echo $vw_spp_ls_kontrak_list->tgl_spp->FldCaption() ?></span></td>
		<td data-name="tgl_spp"<?php echo $vw_spp_ls_kontrak_list->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_tgl_spp">
<span<?php echo $vw_spp_ls_kontrak_list->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->tgl_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->nama_pptk->Visible) { // nama_pptk ?>
	<tr id="r_nama_pptk">
		<td><span id="elh_vw_spp_ls_kontrak_list_nama_pptk"><?php echo $vw_spp_ls_kontrak_list->nama_pptk->FldCaption() ?></span></td>
		<td data-name="nama_pptk"<?php echo $vw_spp_ls_kontrak_list->nama_pptk->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_nama_pptk">
<span<?php echo $vw_spp_ls_kontrak_list->nama_pptk->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->nama_pptk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->nip_pptk->Visible) { // nip_pptk ?>
	<tr id="r_nip_pptk">
		<td><span id="elh_vw_spp_ls_kontrak_list_nip_pptk"><?php echo $vw_spp_ls_kontrak_list->nip_pptk->FldCaption() ?></span></td>
		<td data-name="nip_pptk"<?php echo $vw_spp_ls_kontrak_list->nip_pptk->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_nip_pptk">
<span<?php echo $vw_spp_ls_kontrak_list->nip_pptk->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->nip_pptk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->keterangan->Visible) { // keterangan ?>
	<tr id="r_keterangan">
		<td><span id="elh_vw_spp_ls_kontrak_list_keterangan"><?php echo $vw_spp_ls_kontrak_list->keterangan->FldCaption() ?></span></td>
		<td data-name="keterangan"<?php echo $vw_spp_ls_kontrak_list->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_keterangan">
<span<?php echo $vw_spp_ls_kontrak_list->keterangan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->keterangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->pph21->Visible) { // pph21 ?>
	<tr id="r_pph21">
		<td><span id="elh_vw_spp_ls_kontrak_list_pph21"><?php echo $vw_spp_ls_kontrak_list->pph21->FldCaption() ?></span></td>
		<td data-name="pph21"<?php echo $vw_spp_ls_kontrak_list->pph21->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_pph21">
<span<?php echo $vw_spp_ls_kontrak_list->pph21->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->pph21->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->pph22->Visible) { // pph22 ?>
	<tr id="r_pph22">
		<td><span id="elh_vw_spp_ls_kontrak_list_pph22"><?php echo $vw_spp_ls_kontrak_list->pph22->FldCaption() ?></span></td>
		<td data-name="pph22"<?php echo $vw_spp_ls_kontrak_list->pph22->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_pph22">
<span<?php echo $vw_spp_ls_kontrak_list->pph22->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->pph22->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->pph23->Visible) { // pph23 ?>
	<tr id="r_pph23">
		<td><span id="elh_vw_spp_ls_kontrak_list_pph23"><?php echo $vw_spp_ls_kontrak_list->pph23->FldCaption() ?></span></td>
		<td data-name="pph23"<?php echo $vw_spp_ls_kontrak_list->pph23->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_pph23">
<span<?php echo $vw_spp_ls_kontrak_list->pph23->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->pph23->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->pph4->Visible) { // pph4 ?>
	<tr id="r_pph4">
		<td><span id="elh_vw_spp_ls_kontrak_list_pph4"><?php echo $vw_spp_ls_kontrak_list->pph4->FldCaption() ?></span></td>
		<td data-name="pph4"<?php echo $vw_spp_ls_kontrak_list->pph4->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_pph4">
<span<?php echo $vw_spp_ls_kontrak_list->pph4->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->pph4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->nama_bendahara->Visible) { // nama_bendahara ?>
	<tr id="r_nama_bendahara">
		<td><span id="elh_vw_spp_ls_kontrak_list_nama_bendahara"><?php echo $vw_spp_ls_kontrak_list->nama_bendahara->FldCaption() ?></span></td>
		<td data-name="nama_bendahara"<?php echo $vw_spp_ls_kontrak_list->nama_bendahara->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_nama_bendahara">
<span<?php echo $vw_spp_ls_kontrak_list->nama_bendahara->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->nama_bendahara->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->nip_bendahara->Visible) { // nip_bendahara ?>
	<tr id="r_nip_bendahara">
		<td><span id="elh_vw_spp_ls_kontrak_list_nip_bendahara"><?php echo $vw_spp_ls_kontrak_list->nip_bendahara->FldCaption() ?></span></td>
		<td data-name="nip_bendahara"<?php echo $vw_spp_ls_kontrak_list->nip_bendahara->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_nip_bendahara">
<span<?php echo $vw_spp_ls_kontrak_list->nip_bendahara->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->nip_bendahara->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->kode_program->Visible) { // kode_program ?>
	<tr id="r_kode_program">
		<td><span id="elh_vw_spp_ls_kontrak_list_kode_program"><?php echo $vw_spp_ls_kontrak_list->kode_program->FldCaption() ?></span></td>
		<td data-name="kode_program"<?php echo $vw_spp_ls_kontrak_list->kode_program->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_kode_program">
<span<?php echo $vw_spp_ls_kontrak_list->kode_program->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->kode_program->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<tr id="r_kode_kegiatan">
		<td><span id="elh_vw_spp_ls_kontrak_list_kode_kegiatan"><?php echo $vw_spp_ls_kontrak_list->kode_kegiatan->FldCaption() ?></span></td>
		<td data-name="kode_kegiatan"<?php echo $vw_spp_ls_kontrak_list->kode_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_kode_kegiatan">
<span<?php echo $vw_spp_ls_kontrak_list->kode_kegiatan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->kode_kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
	<tr id="r_kode_sub_kegiatan">
		<td><span id="elh_vw_spp_ls_kontrak_list_kode_sub_kegiatan"><?php echo $vw_spp_ls_kontrak_list->kode_sub_kegiatan->FldCaption() ?></span></td>
		<td data-name="kode_sub_kegiatan"<?php echo $vw_spp_ls_kontrak_list->kode_sub_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_kode_sub_kegiatan">
<span<?php echo $vw_spp_ls_kontrak_list->kode_sub_kegiatan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->kode_sub_kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<tr id="r_jumlah_belanja">
		<td><span id="elh_vw_spp_ls_kontrak_list_jumlah_belanja"><?php echo $vw_spp_ls_kontrak_list->jumlah_belanja->FldCaption() ?></span></td>
		<td data-name="jumlah_belanja"<?php echo $vw_spp_ls_kontrak_list->jumlah_belanja->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_jumlah_belanja">
<span<?php echo $vw_spp_ls_kontrak_list->jumlah_belanja->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->jumlah_belanja->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->kontrak_id->Visible) { // kontrak_id ?>
	<tr id="r_kontrak_id">
		<td><span id="elh_vw_spp_ls_kontrak_list_kontrak_id"><?php echo $vw_spp_ls_kontrak_list->kontrak_id->FldCaption() ?></span></td>
		<td data-name="kontrak_id"<?php echo $vw_spp_ls_kontrak_list->kontrak_id->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_kontrak_id">
<span<?php echo $vw_spp_ls_kontrak_list->kontrak_id->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->kontrak_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->kode_rekening->Visible) { // kode_rekening ?>
	<tr id="r_kode_rekening">
		<td><span id="elh_vw_spp_ls_kontrak_list_kode_rekening"><?php echo $vw_spp_ls_kontrak_list->kode_rekening->FldCaption() ?></span></td>
		<td data-name="kode_rekening"<?php echo $vw_spp_ls_kontrak_list->kode_rekening->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_kode_rekening">
<span<?php echo $vw_spp_ls_kontrak_list->kode_rekening->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->kode_rekening->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->akun1->Visible) { // akun1 ?>
	<tr id="r_akun1">
		<td><span id="elh_vw_spp_ls_kontrak_list_akun1"><?php echo $vw_spp_ls_kontrak_list->akun1->FldCaption() ?></span></td>
		<td data-name="akun1"<?php echo $vw_spp_ls_kontrak_list->akun1->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_akun1">
<span<?php echo $vw_spp_ls_kontrak_list->akun1->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->akun1->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->akun2->Visible) { // akun2 ?>
	<tr id="r_akun2">
		<td><span id="elh_vw_spp_ls_kontrak_list_akun2"><?php echo $vw_spp_ls_kontrak_list->akun2->FldCaption() ?></span></td>
		<td data-name="akun2"<?php echo $vw_spp_ls_kontrak_list->akun2->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_akun2">
<span<?php echo $vw_spp_ls_kontrak_list->akun2->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->akun2->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->akun3->Visible) { // akun3 ?>
	<tr id="r_akun3">
		<td><span id="elh_vw_spp_ls_kontrak_list_akun3"><?php echo $vw_spp_ls_kontrak_list->akun3->FldCaption() ?></span></td>
		<td data-name="akun3"<?php echo $vw_spp_ls_kontrak_list->akun3->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_akun3">
<span<?php echo $vw_spp_ls_kontrak_list->akun3->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->akun3->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->akun4->Visible) { // akun4 ?>
	<tr id="r_akun4">
		<td><span id="elh_vw_spp_ls_kontrak_list_akun4"><?php echo $vw_spp_ls_kontrak_list->akun4->FldCaption() ?></span></td>
		<td data-name="akun4"<?php echo $vw_spp_ls_kontrak_list->akun4->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_akun4">
<span<?php echo $vw_spp_ls_kontrak_list->akun4->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->akun4->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_kontrak_list->akun5->Visible) { // akun5 ?>
	<tr id="r_akun5">
		<td><span id="elh_vw_spp_ls_kontrak_list_akun5"><?php echo $vw_spp_ls_kontrak_list->akun5->FldCaption() ?></span></td>
		<td data-name="akun5"<?php echo $vw_spp_ls_kontrak_list->akun5->CellAttributes() ?>>
<span id="el_vw_spp_ls_kontrak_list_akun5">
<span<?php echo $vw_spp_ls_kontrak_list->akun5->ViewAttributes() ?>>
<?php echo $vw_spp_ls_kontrak_list->akun5->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fvw_spp_ls_kontrak_listview.Init();
</script>
<?php
$vw_spp_ls_kontrak_list_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_ls_kontrak_list_view->Page_Terminate();
?>
