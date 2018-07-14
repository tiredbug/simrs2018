<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_ls_gaji_listinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_spp_ls_gaji_list_detail_belanjagridcls.php" ?>
<?php include_once "vw_spp_ls_gaji_list_detail_pajakgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_ls_gaji_list_view = NULL; // Initialize page object first

class cvw_spp_ls_gaji_list_view extends cvw_spp_ls_gaji_list {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_ls_gaji_list';

	// Page object name
	var $PageObjName = 'vw_spp_ls_gaji_list_view';

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

		// Table object (vw_spp_ls_gaji_list)
		if (!isset($GLOBALS["vw_spp_ls_gaji_list"]) || get_class($GLOBALS["vw_spp_ls_gaji_list"]) == "cvw_spp_ls_gaji_list") {
			$GLOBALS["vw_spp_ls_gaji_list"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_ls_gaji_list"];
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
			define("EW_TABLE_NAME", 'vw_spp_ls_gaji_list', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_ls_gaji_listlist.php"));
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
		$this->keterangan->SetVisibility();
		$this->kode_program->SetVisibility();
		$this->kode_kegiatan->SetVisibility();
		$this->kode_sub_kegiatan->SetVisibility();
		$this->nama_bendahara->SetVisibility();
		$this->nip_bendahara->SetVisibility();
		$this->nama_pptk->SetVisibility();
		$this->nip_pptk->SetVisibility();
		$this->tahun_anggaran->SetVisibility();
		$this->id_spd->SetVisibility();
		$this->tanggal_spd->SetVisibility();
		$this->nomer_dasar_spd->SetVisibility();
		$this->jumlah_spd->SetVisibility();

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
		global $EW_EXPORT, $vw_spp_ls_gaji_list;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_ls_gaji_list);
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
				$sReturnUrl = "vw_spp_ls_gaji_listlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "vw_spp_ls_gaji_listlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "vw_spp_ls_gaji_listlist.php"; // Not page request, return to list
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

		// Set up detail parameters
		$this->SetUpDetailParms();
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

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_vw_spp_ls_gaji_list_detail_belanja"
		$item = &$option->Add("detail_vw_spp_ls_gaji_list_detail_belanja");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("vw_spp_ls_gaji_list_detail_belanja", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_spp_ls_gaji_list_detail_belanjalist.php?" . EW_TABLE_SHOW_MASTER . "=vw_spp_ls_gaji_list&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "&fk_id_jenis_spp=" . urlencode(strval($this->id_jenis_spp->CurrentValue)) . "&fk_detail_jenis_spp=" . urlencode(strval($this->detail_jenis_spp->CurrentValue)) . "&fk_no_spp=" . urlencode(strval($this->no_spp->CurrentValue)) . "&fk_kode_program=" . urlencode(strval($this->kode_program->CurrentValue)) . "&fk_kode_kegiatan=" . urlencode(strval($this->kode_kegiatan->CurrentValue)) . "&fk_kode_sub_kegiatan=" . urlencode(strval($this->kode_sub_kegiatan->CurrentValue)) . "&fk_tahun_anggaran=" . urlencode(strval($this->tahun_anggaran->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"] && $GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'vw_spp_ls_gaji_list_detail_belanja')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=vw_spp_ls_gaji_list_detail_belanja")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "vw_spp_ls_gaji_list_detail_belanja";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_spp_ls_gaji_list_detail_belanja');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_spp_ls_gaji_list_detail_belanja";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_vw_spp_ls_gaji_list_detail_pajak"
		$item = &$option->Add("detail_vw_spp_ls_gaji_list_detail_pajak");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("vw_spp_ls_gaji_list_detail_pajak", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("vw_spp_ls_gaji_list_detail_pajaklist.php?" . EW_TABLE_SHOW_MASTER . "=vw_spp_ls_gaji_list&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "&fk_id_jenis_spp=" . urlencode(strval($this->id_jenis_spp->CurrentValue)) . "&fk_detail_jenis_spp=" . urlencode(strval($this->detail_jenis_spp->CurrentValue)) . "&fk_no_spp=" . urlencode(strval($this->no_spp->CurrentValue)) . "&fk_kode_program=" . urlencode(strval($this->kode_program->CurrentValue)) . "&fk_kode_kegiatan=" . urlencode(strval($this->kode_kegiatan->CurrentValue)) . "&fk_kode_sub_kegiatan=" . urlencode(strval($this->kode_sub_kegiatan->CurrentValue)) . "&fk_tahun_anggaran=" . urlencode(strval($this->tahun_anggaran->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"] && $GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'vw_spp_ls_gaji_list_detail_pajak')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=vw_spp_ls_gaji_list_detail_pajak")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "vw_spp_ls_gaji_list_detail_pajak";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'vw_spp_ls_gaji_list_detail_pajak');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "vw_spp_ls_gaji_list_detail_pajak";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->kontrak_id->setDbValue($rs->fields('kontrak_id'));
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
		$this->keterangan->DbValue = $row['keterangan'];
		$this->kode_program->DbValue = $row['kode_program'];
		$this->kode_kegiatan->DbValue = $row['kode_kegiatan'];
		$this->kode_sub_kegiatan->DbValue = $row['kode_sub_kegiatan'];
		$this->nama_bendahara->DbValue = $row['nama_bendahara'];
		$this->nip_bendahara->DbValue = $row['nip_bendahara'];
		$this->nama_pptk->DbValue = $row['nama_pptk'];
		$this->nip_pptk->DbValue = $row['nip_pptk'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->id_spd->DbValue = $row['id_spd'];
		$this->tanggal_spd->DbValue = $row['tanggal_spd'];
		$this->nomer_dasar_spd->DbValue = $row['nomer_dasar_spd'];
		$this->jumlah_spd->DbValue = $row['jumlah_spd'];
		$this->kontrak_id->DbValue = $row['kontrak_id'];
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
		if ($this->jumlah_spd->FormValue == $this->jumlah_spd->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_spd->CurrentValue)))
			$this->jumlah_spd->CurrentValue = ew_StrToFloat($this->jumlah_spd->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_jenis_spp
		// detail_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// keterangan
		// kode_program
		// kode_kegiatan
		// kode_sub_kegiatan
		// nama_bendahara
		// nip_bendahara
		// nama_pptk
		// nip_pptk
		// tahun_anggaran
		// id_spd
		// tanggal_spd
		// nomer_dasar_spd
		// jumlah_spd
		// kontrak_id

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
		$lookuptblfilter = "`id`=5";
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

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// kode_program
		if (strval($this->kode_program->CurrentValue) <> "") {
			$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->kode_program->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
		$sWhereWrk = "";
		$this->kode_program->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_program, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_program->ViewValue = $this->kode_program->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
			}
		} else {
			$this->kode_program->ViewValue = NULL;
		}
		$this->kode_program->ViewCustomAttributes = "";

		// kode_kegiatan
		if (strval($this->kode_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kode_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
		$sWhereWrk = "";
		$this->kode_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->CurrentValue;
			}
		} else {
			$this->kode_kegiatan->ViewValue = NULL;
		}
		$this->kode_kegiatan->ViewCustomAttributes = "";

		// kode_sub_kegiatan
		if (strval($this->kode_sub_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->kode_sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
		$sWhereWrk = "";
		$this->kode_sub_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_sub_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->CurrentValue;
			}
		} else {
			$this->kode_sub_kegiatan->ViewValue = NULL;
		}
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

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

		// nama_pptk
		if (strval($this->nama_pptk->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_pptk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_pptk->LookupFilters = array();
		$lookuptblfilter = "`jabatan`=4";
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

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// id_spd
		$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
		$this->id_spd->ViewCustomAttributes = "";

		// tanggal_spd
		$this->tanggal_spd->ViewValue = $this->tanggal_spd->CurrentValue;
		$this->tanggal_spd->ViewValue = ew_FormatDateTime($this->tanggal_spd->ViewValue, 0);
		$this->tanggal_spd->ViewCustomAttributes = "";

		// nomer_dasar_spd
		$this->nomer_dasar_spd->ViewValue = $this->nomer_dasar_spd->CurrentValue;
		$this->nomer_dasar_spd->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

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

			// keterangan
			$this->keterangan->LinkCustomAttributes = "";
			$this->keterangan->HrefValue = "";
			$this->keterangan->TooltipValue = "";

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

			// nama_bendahara
			$this->nama_bendahara->LinkCustomAttributes = "";
			$this->nama_bendahara->HrefValue = "";
			$this->nama_bendahara->TooltipValue = "";

			// nip_bendahara
			$this->nip_bendahara->LinkCustomAttributes = "";
			$this->nip_bendahara->HrefValue = "";
			$this->nip_bendahara->TooltipValue = "";

			// nama_pptk
			$this->nama_pptk->LinkCustomAttributes = "";
			$this->nama_pptk->HrefValue = "";
			$this->nama_pptk->TooltipValue = "";

			// nip_pptk
			$this->nip_pptk->LinkCustomAttributes = "";
			$this->nip_pptk->HrefValue = "";
			$this->nip_pptk->TooltipValue = "";

			// tahun_anggaran
			$this->tahun_anggaran->LinkCustomAttributes = "";
			$this->tahun_anggaran->HrefValue = "";
			$this->tahun_anggaran->TooltipValue = "";

			// id_spd
			$this->id_spd->LinkCustomAttributes = "";
			$this->id_spd->HrefValue = "";
			$this->id_spd->TooltipValue = "";

			// tanggal_spd
			$this->tanggal_spd->LinkCustomAttributes = "";
			$this->tanggal_spd->HrefValue = "";
			$this->tanggal_spd->TooltipValue = "";

			// nomer_dasar_spd
			$this->nomer_dasar_spd->LinkCustomAttributes = "";
			$this->nomer_dasar_spd->HrefValue = "";
			$this->nomer_dasar_spd->TooltipValue = "";

			// jumlah_spd
			$this->jumlah_spd->LinkCustomAttributes = "";
			$this->jumlah_spd->HrefValue = "";
			$this->jumlah_spd->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("vw_spp_ls_gaji_list_detail_belanja", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]))
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"] = new cvw_spp_ls_gaji_list_detail_belanja_grid;
				if ($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->DetailView) {
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_spp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_jenis_spp->CurrentValue = $this->id_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_jenis_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->id_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->detail_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->detail_jenis_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->detail_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->no_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->no_spp->CurrentValue = $this->no_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->no_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->no_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->program->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->program->CurrentValue = $this->kode_program->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->program->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->program->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->kegiatan->CurrentValue = $this->kode_kegiatan->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->kegiatan->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->kegiatan->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->sub_kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->sub_kegiatan->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->sub_kegiatan->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->tahun_anggaran->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->tahun_anggaran->CurrentValue = $this->tahun_anggaran->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->tahun_anggaran->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_belanja_grid"]->tahun_anggaran->CurrentValue);
				}
			}
			if (in_array("vw_spp_ls_gaji_list_detail_pajak", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]))
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"] = new cvw_spp_ls_gaji_list_detail_pajak_grid;
				if ($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->DetailView) {
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_spp->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_jenis_spp->CurrentValue = $this->id_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_jenis_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->id_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->detail_jenis_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->detail_jenis_spp->CurrentValue = $this->detail_jenis_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->detail_jenis_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->detail_jenis_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->no_spp->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->no_spp->CurrentValue = $this->no_spp->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->no_spp->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->no_spp->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->program->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->program->CurrentValue = $this->kode_program->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->program->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->program->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->kegiatan->CurrentValue = $this->kode_kegiatan->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->kegiatan->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->kegiatan->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->sub_kegiatan->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->sub_kegiatan->CurrentValue = $this->kode_sub_kegiatan->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->sub_kegiatan->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->sub_kegiatan->CurrentValue);
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->tahun_anggaran->FldIsDetailKey = TRUE;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->tahun_anggaran->CurrentValue = $this->tahun_anggaran->CurrentValue;
					$GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->tahun_anggaran->setSessionValue($GLOBALS["vw_spp_ls_gaji_list_detail_pajak_grid"]->tahun_anggaran->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_ls_gaji_listlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($vw_spp_ls_gaji_list_view)) $vw_spp_ls_gaji_list_view = new cvw_spp_ls_gaji_list_view();

// Page init
$vw_spp_ls_gaji_list_view->Page_Init();

// Page main
$vw_spp_ls_gaji_list_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_ls_gaji_list_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fvw_spp_ls_gaji_listview = new ew_Form("fvw_spp_ls_gaji_listview", "view");

// Form_CustomValidate event
fvw_spp_ls_gaji_listview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_ls_gaji_listview.ValidateRequired = true;
<?php } else { ?>
fvw_spp_ls_gaji_listview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_ls_gaji_listview.Lists["x_id_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jenis_spp","","",""],"ParentFields":[],"ChildFields":["x_detail_jenis_spp"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_spp"};
fvw_spp_ls_gaji_listview.Lists["x_detail_jenis_spp"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_detail_jenis_spp","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jenis_detail_spp"};
fvw_spp_ls_gaji_listview.Lists["x_status_spp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spp_ls_gaji_listview.Lists["x_status_spp"].Options = <?php echo json_encode($vw_spp_ls_gaji_list->status_spp->Options()) ?>;
fvw_spp_ls_gaji_listview.Lists["x_kode_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kode_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
fvw_spp_ls_gaji_listview.Lists["x_kode_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":[],"ChildFields":["x_kode_sub_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
fvw_spp_ls_gaji_listview.Lists["x_kode_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};
fvw_spp_ls_gaji_listview.Lists["x_nama_bendahara"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};
fvw_spp_ls_gaji_listview.Lists["x_nama_pptk"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_ls_gaji_list_view->IsModal) { ?>
<?php } ?>
<?php $vw_spp_ls_gaji_list_view->ExportOptions->Render("body") ?>
<?php
	foreach ($vw_spp_ls_gaji_list_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$vw_spp_ls_gaji_list_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $vw_spp_ls_gaji_list_view->ShowPageHeader(); ?>
<?php
$vw_spp_ls_gaji_list_view->ShowMessage();
?>
<form name="fvw_spp_ls_gaji_listview" id="fvw_spp_ls_gaji_listview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_ls_gaji_list_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_ls_gaji_list_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_ls_gaji_list">
<?php if ($vw_spp_ls_gaji_list_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($vw_spp_ls_gaji_list->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_vw_spp_ls_gaji_list_id"><?php echo $vw_spp_ls_gaji_list->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $vw_spp_ls_gaji_list->id->CellAttributes() ?>>
<div id="orig_vw_spp_ls_gaji_list_id" class="hide">
<span id="el_vw_spp_ls_gaji_list_id">
<span<?php echo $vw_spp_ls_gaji_list->id->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->id->ViewValue ?></span>
</span>
</div>
<?php
$r = Security()->CurrentUserLevelID();
if($r == 7)
{ ?>
	<a class="btn btn-success btn-xs"  target="_blank" href="cetak_spp_ls_gaji.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK SPP
	 <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a>
<?php
}else {
 }
?>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->id_jenis_spp->Visible) { // id_jenis_spp ?>
	<tr id="r_id_jenis_spp">
		<td><span id="elh_vw_spp_ls_gaji_list_id_jenis_spp"><?php echo $vw_spp_ls_gaji_list->id_jenis_spp->FldCaption() ?></span></td>
		<td data-name="id_jenis_spp"<?php echo $vw_spp_ls_gaji_list->id_jenis_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_id_jenis_spp">
<span<?php echo $vw_spp_ls_gaji_list->id_jenis_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->id_jenis_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->detail_jenis_spp->Visible) { // detail_jenis_spp ?>
	<tr id="r_detail_jenis_spp">
		<td><span id="elh_vw_spp_ls_gaji_list_detail_jenis_spp"><?php echo $vw_spp_ls_gaji_list->detail_jenis_spp->FldCaption() ?></span></td>
		<td data-name="detail_jenis_spp"<?php echo $vw_spp_ls_gaji_list->detail_jenis_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_detail_jenis_spp">
<span<?php echo $vw_spp_ls_gaji_list->detail_jenis_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->detail_jenis_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->status_spp->Visible) { // status_spp ?>
	<tr id="r_status_spp">
		<td><span id="elh_vw_spp_ls_gaji_list_status_spp"><?php echo $vw_spp_ls_gaji_list->status_spp->FldCaption() ?></span></td>
		<td data-name="status_spp"<?php echo $vw_spp_ls_gaji_list->status_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_status_spp">
<span<?php echo $vw_spp_ls_gaji_list->status_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->status_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->no_spp->Visible) { // no_spp ?>
	<tr id="r_no_spp">
		<td><span id="elh_vw_spp_ls_gaji_list_no_spp"><?php echo $vw_spp_ls_gaji_list->no_spp->FldCaption() ?></span></td>
		<td data-name="no_spp"<?php echo $vw_spp_ls_gaji_list->no_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_no_spp">
<span<?php echo $vw_spp_ls_gaji_list->no_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->no_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->tgl_spp->Visible) { // tgl_spp ?>
	<tr id="r_tgl_spp">
		<td><span id="elh_vw_spp_ls_gaji_list_tgl_spp"><?php echo $vw_spp_ls_gaji_list->tgl_spp->FldCaption() ?></span></td>
		<td data-name="tgl_spp"<?php echo $vw_spp_ls_gaji_list->tgl_spp->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_tgl_spp">
<span<?php echo $vw_spp_ls_gaji_list->tgl_spp->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->tgl_spp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->keterangan->Visible) { // keterangan ?>
	<tr id="r_keterangan">
		<td><span id="elh_vw_spp_ls_gaji_list_keterangan"><?php echo $vw_spp_ls_gaji_list->keterangan->FldCaption() ?></span></td>
		<td data-name="keterangan"<?php echo $vw_spp_ls_gaji_list->keterangan->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_keterangan">
<span<?php echo $vw_spp_ls_gaji_list->keterangan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->keterangan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->kode_program->Visible) { // kode_program ?>
	<tr id="r_kode_program">
		<td><span id="elh_vw_spp_ls_gaji_list_kode_program"><?php echo $vw_spp_ls_gaji_list->kode_program->FldCaption() ?></span></td>
		<td data-name="kode_program"<?php echo $vw_spp_ls_gaji_list->kode_program->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_kode_program">
<span<?php echo $vw_spp_ls_gaji_list->kode_program->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->kode_program->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->kode_kegiatan->Visible) { // kode_kegiatan ?>
	<tr id="r_kode_kegiatan">
		<td><span id="elh_vw_spp_ls_gaji_list_kode_kegiatan"><?php echo $vw_spp_ls_gaji_list->kode_kegiatan->FldCaption() ?></span></td>
		<td data-name="kode_kegiatan"<?php echo $vw_spp_ls_gaji_list->kode_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_kode_kegiatan">
<span<?php echo $vw_spp_ls_gaji_list->kode_kegiatan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->kode_kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->kode_sub_kegiatan->Visible) { // kode_sub_kegiatan ?>
	<tr id="r_kode_sub_kegiatan">
		<td><span id="elh_vw_spp_ls_gaji_list_kode_sub_kegiatan"><?php echo $vw_spp_ls_gaji_list->kode_sub_kegiatan->FldCaption() ?></span></td>
		<td data-name="kode_sub_kegiatan"<?php echo $vw_spp_ls_gaji_list->kode_sub_kegiatan->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_kode_sub_kegiatan">
<span<?php echo $vw_spp_ls_gaji_list->kode_sub_kegiatan->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->kode_sub_kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->nama_bendahara->Visible) { // nama_bendahara ?>
	<tr id="r_nama_bendahara">
		<td><span id="elh_vw_spp_ls_gaji_list_nama_bendahara"><?php echo $vw_spp_ls_gaji_list->nama_bendahara->FldCaption() ?></span></td>
		<td data-name="nama_bendahara"<?php echo $vw_spp_ls_gaji_list->nama_bendahara->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_nama_bendahara">
<span<?php echo $vw_spp_ls_gaji_list->nama_bendahara->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->nama_bendahara->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->nip_bendahara->Visible) { // nip_bendahara ?>
	<tr id="r_nip_bendahara">
		<td><span id="elh_vw_spp_ls_gaji_list_nip_bendahara"><?php echo $vw_spp_ls_gaji_list->nip_bendahara->FldCaption() ?></span></td>
		<td data-name="nip_bendahara"<?php echo $vw_spp_ls_gaji_list->nip_bendahara->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_nip_bendahara">
<span<?php echo $vw_spp_ls_gaji_list->nip_bendahara->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->nip_bendahara->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->nama_pptk->Visible) { // nama_pptk ?>
	<tr id="r_nama_pptk">
		<td><span id="elh_vw_spp_ls_gaji_list_nama_pptk"><?php echo $vw_spp_ls_gaji_list->nama_pptk->FldCaption() ?></span></td>
		<td data-name="nama_pptk"<?php echo $vw_spp_ls_gaji_list->nama_pptk->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_nama_pptk">
<span<?php echo $vw_spp_ls_gaji_list->nama_pptk->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->nama_pptk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->nip_pptk->Visible) { // nip_pptk ?>
	<tr id="r_nip_pptk">
		<td><span id="elh_vw_spp_ls_gaji_list_nip_pptk"><?php echo $vw_spp_ls_gaji_list->nip_pptk->FldCaption() ?></span></td>
		<td data-name="nip_pptk"<?php echo $vw_spp_ls_gaji_list->nip_pptk->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_nip_pptk">
<span<?php echo $vw_spp_ls_gaji_list->nip_pptk->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->nip_pptk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->tahun_anggaran->Visible) { // tahun_anggaran ?>
	<tr id="r_tahun_anggaran">
		<td><span id="elh_vw_spp_ls_gaji_list_tahun_anggaran"><?php echo $vw_spp_ls_gaji_list->tahun_anggaran->FldCaption() ?></span></td>
		<td data-name="tahun_anggaran"<?php echo $vw_spp_ls_gaji_list->tahun_anggaran->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_tahun_anggaran">
<span<?php echo $vw_spp_ls_gaji_list->tahun_anggaran->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->tahun_anggaran->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->id_spd->Visible) { // id_spd ?>
	<tr id="r_id_spd">
		<td><span id="elh_vw_spp_ls_gaji_list_id_spd"><?php echo $vw_spp_ls_gaji_list->id_spd->FldCaption() ?></span></td>
		<td data-name="id_spd"<?php echo $vw_spp_ls_gaji_list->id_spd->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_id_spd">
<span<?php echo $vw_spp_ls_gaji_list->id_spd->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->id_spd->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->tanggal_spd->Visible) { // tanggal_spd ?>
	<tr id="r_tanggal_spd">
		<td><span id="elh_vw_spp_ls_gaji_list_tanggal_spd"><?php echo $vw_spp_ls_gaji_list->tanggal_spd->FldCaption() ?></span></td>
		<td data-name="tanggal_spd"<?php echo $vw_spp_ls_gaji_list->tanggal_spd->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_tanggal_spd">
<span<?php echo $vw_spp_ls_gaji_list->tanggal_spd->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->tanggal_spd->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->nomer_dasar_spd->Visible) { // nomer_dasar_spd ?>
	<tr id="r_nomer_dasar_spd">
		<td><span id="elh_vw_spp_ls_gaji_list_nomer_dasar_spd"><?php echo $vw_spp_ls_gaji_list->nomer_dasar_spd->FldCaption() ?></span></td>
		<td data-name="nomer_dasar_spd"<?php echo $vw_spp_ls_gaji_list->nomer_dasar_spd->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_nomer_dasar_spd">
<span<?php echo $vw_spp_ls_gaji_list->nomer_dasar_spd->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->nomer_dasar_spd->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spp_ls_gaji_list->jumlah_spd->Visible) { // jumlah_spd ?>
	<tr id="r_jumlah_spd">
		<td><span id="elh_vw_spp_ls_gaji_list_jumlah_spd"><?php echo $vw_spp_ls_gaji_list->jumlah_spd->FldCaption() ?></span></td>
		<td data-name="jumlah_spd"<?php echo $vw_spp_ls_gaji_list->jumlah_spd->CellAttributes() ?>>
<span id="el_vw_spp_ls_gaji_list_jumlah_spd">
<span<?php echo $vw_spp_ls_gaji_list->jumlah_spd->ViewAttributes() ?>>
<?php echo $vw_spp_ls_gaji_list->jumlah_spd->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("vw_spp_ls_gaji_list_detail_belanja", explode(",", $vw_spp_ls_gaji_list->getCurrentDetailTable())) && $vw_spp_ls_gaji_list_detail_belanja->DetailView) {
?>
<?php if ($vw_spp_ls_gaji_list->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("vw_spp_ls_gaji_list_detail_belanja", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "vw_spp_ls_gaji_list_detail_belanjagrid.php" ?>
<?php } ?>
<?php
	if (in_array("vw_spp_ls_gaji_list_detail_pajak", explode(",", $vw_spp_ls_gaji_list->getCurrentDetailTable())) && $vw_spp_ls_gaji_list_detail_pajak->DetailView) {
?>
<?php if ($vw_spp_ls_gaji_list->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("vw_spp_ls_gaji_list_detail_pajak", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "vw_spp_ls_gaji_list_detail_pajakgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spp_ls_gaji_listview.Init();
</script>
<?php
$vw_spp_ls_gaji_list_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_ls_gaji_list_view->Page_Terminate();
?>
