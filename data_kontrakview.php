<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "data_kontrakinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "data_kontrak_detail_termingridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$data_kontrak_view = NULL; // Initialize page object first

class cdata_kontrak_view extends cdata_kontrak {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'data_kontrak';

	// Page object name
	var $PageObjName = 'data_kontrak_view';

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

		// Table object (data_kontrak)
		if (!isset($GLOBALS["data_kontrak"]) || get_class($GLOBALS["data_kontrak"]) == "cdata_kontrak") {
			$GLOBALS["data_kontrak"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["data_kontrak"];
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
			define("EW_TABLE_NAME", 'data_kontrak', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("data_kontraklist.php"));
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
		$this->program->SetVisibility();
		$this->kegiatan->SetVisibility();
		$this->sub_kegiatan->SetVisibility();
		$this->no_kontrak->SetVisibility();
		$this->tgl_kontrak->SetVisibility();
		$this->nama_perusahaan->SetVisibility();
		$this->bentuk_perusahaan->SetVisibility();
		$this->alamat_perusahaan->SetVisibility();
		$this->kepala_perusahaan->SetVisibility();
		$this->npwp->SetVisibility();
		$this->nama_bank->SetVisibility();
		$this->nama_rekening->SetVisibility();
		$this->nomer_rekening->SetVisibility();
		$this->lanjutkan->SetVisibility();
		$this->waktu_kontrak->SetVisibility();
		$this->tgl_mulai->SetVisibility();
		$this->tgl_selesai->SetVisibility();
		$this->paket_pekerjaan->SetVisibility();
		$this->nama_ppkom->SetVisibility();
		$this->nip_ppkom->SetVisibility();

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
		global $EW_EXPORT, $data_kontrak;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($data_kontrak);
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
				$sReturnUrl = "data_kontraklist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "data_kontraklist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "data_kontraklist.php"; // Not page request, return to list
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
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_data_kontrak_detail_termin"
		$item = &$option->Add("detail_data_kontrak_detail_termin");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("data_kontrak_detail_termin", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("data_kontrak_detail_terminlist.php?" . EW_TABLE_SHOW_MASTER . "=data_kontrak&fk_id=" . urlencode(strval($this->id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["data_kontrak_detail_termin_grid"] && $GLOBALS["data_kontrak_detail_termin_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'data_kontrak_detail_termin')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=data_kontrak_detail_termin")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "data_kontrak_detail_termin";
		}
		if ($GLOBALS["data_kontrak_detail_termin_grid"] && $GLOBALS["data_kontrak_detail_termin_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'data_kontrak_detail_termin')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=data_kontrak_detail_termin")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "data_kontrak_detail_termin";
		}
		if ($GLOBALS["data_kontrak_detail_termin_grid"] && $GLOBALS["data_kontrak_detail_termin_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'data_kontrak_detail_termin')) {
			$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=data_kontrak_detail_termin")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
			$DetailCopyTblVar .= "data_kontrak_detail_termin";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'data_kontrak_detail_termin');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "data_kontrak_detail_termin";
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
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->no_kontrak->setDbValue($rs->fields('no_kontrak'));
		$this->tgl_kontrak->setDbValue($rs->fields('tgl_kontrak'));
		$this->nama_perusahaan->setDbValue($rs->fields('nama_perusahaan'));
		$this->bentuk_perusahaan->setDbValue($rs->fields('bentuk_perusahaan'));
		$this->alamat_perusahaan->setDbValue($rs->fields('alamat_perusahaan'));
		$this->kepala_perusahaan->setDbValue($rs->fields('kepala_perusahaan'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nama_rekening->setDbValue($rs->fields('nama_rekening'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->lanjutkan->setDbValue($rs->fields('lanjutkan'));
		$this->waktu_kontrak->setDbValue($rs->fields('waktu_kontrak'));
		$this->tgl_mulai->setDbValue($rs->fields('tgl_mulai'));
		$this->tgl_selesai->setDbValue($rs->fields('tgl_selesai'));
		$this->paket_pekerjaan->setDbValue($rs->fields('paket_pekerjaan'));
		$this->nama_ppkom->setDbValue($rs->fields('nama_ppkom'));
		$this->nip_ppkom->setDbValue($rs->fields('nip_ppkom'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->no_kontrak->DbValue = $row['no_kontrak'];
		$this->tgl_kontrak->DbValue = $row['tgl_kontrak'];
		$this->nama_perusahaan->DbValue = $row['nama_perusahaan'];
		$this->bentuk_perusahaan->DbValue = $row['bentuk_perusahaan'];
		$this->alamat_perusahaan->DbValue = $row['alamat_perusahaan'];
		$this->kepala_perusahaan->DbValue = $row['kepala_perusahaan'];
		$this->npwp->DbValue = $row['npwp'];
		$this->nama_bank->DbValue = $row['nama_bank'];
		$this->nama_rekening->DbValue = $row['nama_rekening'];
		$this->nomer_rekening->DbValue = $row['nomer_rekening'];
		$this->lanjutkan->DbValue = $row['lanjutkan'];
		$this->waktu_kontrak->DbValue = $row['waktu_kontrak'];
		$this->tgl_mulai->DbValue = $row['tgl_mulai'];
		$this->tgl_selesai->DbValue = $row['tgl_selesai'];
		$this->paket_pekerjaan->DbValue = $row['paket_pekerjaan'];
		$this->nama_ppkom->DbValue = $row['nama_ppkom'];
		$this->nip_ppkom->DbValue = $row['nip_ppkom'];
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
		// program
		// kegiatan
		// sub_kegiatan
		// no_kontrak
		// tgl_kontrak
		// nama_perusahaan
		// bentuk_perusahaan
		// alamat_perusahaan
		// kepala_perusahaan
		// npwp
		// nama_bank
		// nama_rekening
		// nomer_rekening
		// lanjutkan
		// waktu_kontrak
		// tgl_mulai
		// tgl_selesai
		// paket_pekerjaan
		// nama_ppkom
		// nip_ppkom

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// program
		if (strval($this->program->CurrentValue) <> "") {
			$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->program->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
		$sWhereWrk = "";
		$this->program->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->program, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->program->ViewValue = $this->program->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->program->ViewValue = $this->program->CurrentValue;
			}
		} else {
			$this->program->ViewValue = NULL;
		}
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		if (strval($this->kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
		$sWhereWrk = "";
		$this->kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kegiatan->ViewValue = $this->kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
			}
		} else {
			$this->kegiatan->ViewValue = NULL;
		}
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		if (strval($this->sub_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
		$sWhereWrk = "";
		$this->sub_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
			}
		} else {
			$this->sub_kegiatan->ViewValue = NULL;
		}
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// no_kontrak
		$this->no_kontrak->ViewValue = $this->no_kontrak->CurrentValue;
		$this->no_kontrak->ViewCustomAttributes = "";

		// tgl_kontrak
		$this->tgl_kontrak->ViewValue = $this->tgl_kontrak->CurrentValue;
		$this->tgl_kontrak->ViewValue = ew_FormatDateTime($this->tgl_kontrak->ViewValue, 0);
		$this->tgl_kontrak->ViewCustomAttributes = "";

		// nama_perusahaan
		$this->nama_perusahaan->ViewValue = $this->nama_perusahaan->CurrentValue;
		$this->nama_perusahaan->ViewCustomAttributes = "";

		// bentuk_perusahaan
		if (strval($this->bentuk_perusahaan->CurrentValue) <> "") {
			$sFilterWrk = "`bentuk perusahaan`" . ew_SearchString("=", $this->bentuk_perusahaan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `bentuk perusahaan`, `bentuk perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bentuk_perusahaan`";
		$sWhereWrk = "";
		$this->bentuk_perusahaan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bentuk_perusahaan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->CurrentValue;
			}
		} else {
			$this->bentuk_perusahaan->ViewValue = NULL;
		}
		$this->bentuk_perusahaan->ViewCustomAttributes = "";

		// alamat_perusahaan
		$this->alamat_perusahaan->ViewValue = $this->alamat_perusahaan->CurrentValue;
		$this->alamat_perusahaan->ViewCustomAttributes = "";

		// kepala_perusahaan
		$this->kepala_perusahaan->ViewValue = $this->kepala_perusahaan->CurrentValue;
		$this->kepala_perusahaan->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nama_rekening
		$this->nama_rekening->ViewValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// lanjutkan
		if (strval($this->lanjutkan->CurrentValue) <> "") {
			$this->lanjutkan->ViewValue = $this->lanjutkan->OptionCaption($this->lanjutkan->CurrentValue);
		} else {
			$this->lanjutkan->ViewValue = NULL;
		}
		$this->lanjutkan->ViewCustomAttributes = "";

		// waktu_kontrak
		$this->waktu_kontrak->ViewValue = $this->waktu_kontrak->CurrentValue;
		$this->waktu_kontrak->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 7);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_selesai
		$this->tgl_selesai->ViewValue = $this->tgl_selesai->CurrentValue;
		$this->tgl_selesai->ViewValue = ew_FormatDateTime($this->tgl_selesai->ViewValue, 7);
		$this->tgl_selesai->ViewCustomAttributes = "";

		// paket_pekerjaan
		$this->paket_pekerjaan->ViewValue = $this->paket_pekerjaan->CurrentValue;
		$this->paket_pekerjaan->ViewCustomAttributes = "";

		// nama_ppkom
		if (strval($this->nama_ppkom->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_ppkom->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_ppkom->LookupFilters = array();
		$lookuptblfilter = "`jabatan`=3";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_ppkom, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->CurrentValue;
			}
		} else {
			$this->nama_ppkom->ViewValue = NULL;
		}
		$this->nama_ppkom->ViewCustomAttributes = "";

		// nip_ppkom
		$this->nip_ppkom->ViewValue = $this->nip_ppkom->CurrentValue;
		$this->nip_ppkom->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

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

			// no_kontrak
			$this->no_kontrak->LinkCustomAttributes = "";
			$this->no_kontrak->HrefValue = "";
			$this->no_kontrak->TooltipValue = "";

			// tgl_kontrak
			$this->tgl_kontrak->LinkCustomAttributes = "";
			$this->tgl_kontrak->HrefValue = "";
			$this->tgl_kontrak->TooltipValue = "";

			// nama_perusahaan
			$this->nama_perusahaan->LinkCustomAttributes = "";
			$this->nama_perusahaan->HrefValue = "";
			$this->nama_perusahaan->TooltipValue = "";

			// bentuk_perusahaan
			$this->bentuk_perusahaan->LinkCustomAttributes = "";
			$this->bentuk_perusahaan->HrefValue = "";
			$this->bentuk_perusahaan->TooltipValue = "";

			// alamat_perusahaan
			$this->alamat_perusahaan->LinkCustomAttributes = "";
			$this->alamat_perusahaan->HrefValue = "";
			$this->alamat_perusahaan->TooltipValue = "";

			// kepala_perusahaan
			$this->kepala_perusahaan->LinkCustomAttributes = "";
			$this->kepala_perusahaan->HrefValue = "";
			$this->kepala_perusahaan->TooltipValue = "";

			// npwp
			$this->npwp->LinkCustomAttributes = "";
			$this->npwp->HrefValue = "";
			$this->npwp->TooltipValue = "";

			// nama_bank
			$this->nama_bank->LinkCustomAttributes = "";
			$this->nama_bank->HrefValue = "";
			$this->nama_bank->TooltipValue = "";

			// nama_rekening
			$this->nama_rekening->LinkCustomAttributes = "";
			$this->nama_rekening->HrefValue = "";
			$this->nama_rekening->TooltipValue = "";

			// nomer_rekening
			$this->nomer_rekening->LinkCustomAttributes = "";
			$this->nomer_rekening->HrefValue = "";
			$this->nomer_rekening->TooltipValue = "";

			// lanjutkan
			$this->lanjutkan->LinkCustomAttributes = "";
			$this->lanjutkan->HrefValue = "";
			$this->lanjutkan->TooltipValue = "";

			// waktu_kontrak
			$this->waktu_kontrak->LinkCustomAttributes = "";
			$this->waktu_kontrak->HrefValue = "";
			$this->waktu_kontrak->TooltipValue = "";

			// tgl_mulai
			$this->tgl_mulai->LinkCustomAttributes = "";
			$this->tgl_mulai->HrefValue = "";
			$this->tgl_mulai->TooltipValue = "";

			// tgl_selesai
			$this->tgl_selesai->LinkCustomAttributes = "";
			$this->tgl_selesai->HrefValue = "";
			$this->tgl_selesai->TooltipValue = "";

			// paket_pekerjaan
			$this->paket_pekerjaan->LinkCustomAttributes = "";
			$this->paket_pekerjaan->HrefValue = "";
			$this->paket_pekerjaan->TooltipValue = "";

			// nama_ppkom
			$this->nama_ppkom->LinkCustomAttributes = "";
			$this->nama_ppkom->HrefValue = "";
			$this->nama_ppkom->TooltipValue = "";

			// nip_ppkom
			$this->nip_ppkom->LinkCustomAttributes = "";
			$this->nip_ppkom->HrefValue = "";
			$this->nip_ppkom->TooltipValue = "";
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
			if (in_array("data_kontrak_detail_termin", $DetailTblVar)) {
				if (!isset($GLOBALS["data_kontrak_detail_termin_grid"]))
					$GLOBALS["data_kontrak_detail_termin_grid"] = new cdata_kontrak_detail_termin_grid;
				if ($GLOBALS["data_kontrak_detail_termin_grid"]->DetailView) {
					$GLOBALS["data_kontrak_detail_termin_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["data_kontrak_detail_termin_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["data_kontrak_detail_termin_grid"]->setStartRecordNumber(1);
					$GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->FldIsDetailKey = TRUE;
					$GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->CurrentValue = $this->id->CurrentValue;
					$GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->setSessionValue($GLOBALS["data_kontrak_detail_termin_grid"]->id_detail->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("data_kontraklist.php"), "", $this->TableVar, TRUE);
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
if (!isset($data_kontrak_view)) $data_kontrak_view = new cdata_kontrak_view();

// Page init
$data_kontrak_view->Page_Init();

// Page main
$data_kontrak_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$data_kontrak_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fdata_kontrakview = new ew_Form("fdata_kontrakview", "view");

// Form_CustomValidate event
fdata_kontrakview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdata_kontrakview.ValidateRequired = true;
<?php } else { ?>
fdata_kontrakview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdata_kontrakview.Lists["x_program"] = {"LinkField":"x_kode_program","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_program","","",""],"ParentFields":[],"ChildFields":["x_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_program"};
fdata_kontrakview.Lists["x_kegiatan"] = {"LinkField":"x_kode_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_kegiatan","","",""],"ParentFields":[],"ChildFields":["x_sub_kegiatan"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_kegiatan"};
fdata_kontrakview.Lists["x_sub_kegiatan"] = {"LinkField":"x_kode_sub_kegiatan","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama_sub_kegiatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_sub_kegiatan"};
fdata_kontrakview.Lists["x_bentuk_perusahaan"] = {"LinkField":"x_bentuk_perusahaan","Ajax":true,"AutoFill":false,"DisplayFields":["x_bentuk_perusahaan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"bentuk_perusahaan"};
fdata_kontrakview.Lists["x_lanjutkan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdata_kontrakview.Lists["x_lanjutkan"].Options = <?php echo json_encode($data_kontrak->lanjutkan->Options()) ?>;
fdata_kontrakview.Lists["x_nama_ppkom"] = {"LinkField":"x_nama","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pejabat_keuangan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$data_kontrak_view->IsModal) { ?>
<?php } ?>
<?php $data_kontrak_view->ExportOptions->Render("body") ?>
<?php
	foreach ($data_kontrak_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$data_kontrak_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $data_kontrak_view->ShowPageHeader(); ?>
<?php
$data_kontrak_view->ShowMessage();
?>
<form name="fdata_kontrakview" id="fdata_kontrakview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($data_kontrak_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $data_kontrak_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="data_kontrak">
<?php if ($data_kontrak_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($data_kontrak->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_data_kontrak_id"><?php echo $data_kontrak->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $data_kontrak->id->CellAttributes() ?>>
<span id="el_data_kontrak_id">
<span<?php echo $data_kontrak->id->ViewAttributes() ?>>
<?php echo $data_kontrak->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->program->Visible) { // program ?>
	<tr id="r_program">
		<td><span id="elh_data_kontrak_program"><?php echo $data_kontrak->program->FldCaption() ?></span></td>
		<td data-name="program"<?php echo $data_kontrak->program->CellAttributes() ?>>
<span id="el_data_kontrak_program">
<span<?php echo $data_kontrak->program->ViewAttributes() ?>>
<?php echo $data_kontrak->program->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->kegiatan->Visible) { // kegiatan ?>
	<tr id="r_kegiatan">
		<td><span id="elh_data_kontrak_kegiatan"><?php echo $data_kontrak->kegiatan->FldCaption() ?></span></td>
		<td data-name="kegiatan"<?php echo $data_kontrak->kegiatan->CellAttributes() ?>>
<span id="el_data_kontrak_kegiatan">
<span<?php echo $data_kontrak->kegiatan->ViewAttributes() ?>>
<?php echo $data_kontrak->kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->sub_kegiatan->Visible) { // sub_kegiatan ?>
	<tr id="r_sub_kegiatan">
		<td><span id="elh_data_kontrak_sub_kegiatan"><?php echo $data_kontrak->sub_kegiatan->FldCaption() ?></span></td>
		<td data-name="sub_kegiatan"<?php echo $data_kontrak->sub_kegiatan->CellAttributes() ?>>
<span id="el_data_kontrak_sub_kegiatan">
<span<?php echo $data_kontrak->sub_kegiatan->ViewAttributes() ?>>
<?php echo $data_kontrak->sub_kegiatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->no_kontrak->Visible) { // no_kontrak ?>
	<tr id="r_no_kontrak">
		<td><span id="elh_data_kontrak_no_kontrak"><?php echo $data_kontrak->no_kontrak->FldCaption() ?></span></td>
		<td data-name="no_kontrak"<?php echo $data_kontrak->no_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_no_kontrak">
<span<?php echo $data_kontrak->no_kontrak->ViewAttributes() ?>>
<?php echo $data_kontrak->no_kontrak->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->tgl_kontrak->Visible) { // tgl_kontrak ?>
	<tr id="r_tgl_kontrak">
		<td><span id="elh_data_kontrak_tgl_kontrak"><?php echo $data_kontrak->tgl_kontrak->FldCaption() ?></span></td>
		<td data-name="tgl_kontrak"<?php echo $data_kontrak->tgl_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_tgl_kontrak">
<span<?php echo $data_kontrak->tgl_kontrak->ViewAttributes() ?>>
<?php echo $data_kontrak->tgl_kontrak->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->nama_perusahaan->Visible) { // nama_perusahaan ?>
	<tr id="r_nama_perusahaan">
		<td><span id="elh_data_kontrak_nama_perusahaan"><?php echo $data_kontrak->nama_perusahaan->FldCaption() ?></span></td>
		<td data-name="nama_perusahaan"<?php echo $data_kontrak->nama_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_nama_perusahaan">
<span<?php echo $data_kontrak->nama_perusahaan->ViewAttributes() ?>>
<?php echo $data_kontrak->nama_perusahaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->bentuk_perusahaan->Visible) { // bentuk_perusahaan ?>
	<tr id="r_bentuk_perusahaan">
		<td><span id="elh_data_kontrak_bentuk_perusahaan"><?php echo $data_kontrak->bentuk_perusahaan->FldCaption() ?></span></td>
		<td data-name="bentuk_perusahaan"<?php echo $data_kontrak->bentuk_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_bentuk_perusahaan">
<span<?php echo $data_kontrak->bentuk_perusahaan->ViewAttributes() ?>>
<?php echo $data_kontrak->bentuk_perusahaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->alamat_perusahaan->Visible) { // alamat_perusahaan ?>
	<tr id="r_alamat_perusahaan">
		<td><span id="elh_data_kontrak_alamat_perusahaan"><?php echo $data_kontrak->alamat_perusahaan->FldCaption() ?></span></td>
		<td data-name="alamat_perusahaan"<?php echo $data_kontrak->alamat_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_alamat_perusahaan">
<span<?php echo $data_kontrak->alamat_perusahaan->ViewAttributes() ?>>
<?php echo $data_kontrak->alamat_perusahaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->kepala_perusahaan->Visible) { // kepala_perusahaan ?>
	<tr id="r_kepala_perusahaan">
		<td><span id="elh_data_kontrak_kepala_perusahaan"><?php echo $data_kontrak->kepala_perusahaan->FldCaption() ?></span></td>
		<td data-name="kepala_perusahaan"<?php echo $data_kontrak->kepala_perusahaan->CellAttributes() ?>>
<span id="el_data_kontrak_kepala_perusahaan">
<span<?php echo $data_kontrak->kepala_perusahaan->ViewAttributes() ?>>
<?php echo $data_kontrak->kepala_perusahaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->npwp->Visible) { // npwp ?>
	<tr id="r_npwp">
		<td><span id="elh_data_kontrak_npwp"><?php echo $data_kontrak->npwp->FldCaption() ?></span></td>
		<td data-name="npwp"<?php echo $data_kontrak->npwp->CellAttributes() ?>>
<span id="el_data_kontrak_npwp">
<span<?php echo $data_kontrak->npwp->ViewAttributes() ?>>
<?php echo $data_kontrak->npwp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->nama_bank->Visible) { // nama_bank ?>
	<tr id="r_nama_bank">
		<td><span id="elh_data_kontrak_nama_bank"><?php echo $data_kontrak->nama_bank->FldCaption() ?></span></td>
		<td data-name="nama_bank"<?php echo $data_kontrak->nama_bank->CellAttributes() ?>>
<span id="el_data_kontrak_nama_bank">
<span<?php echo $data_kontrak->nama_bank->ViewAttributes() ?>>
<?php echo $data_kontrak->nama_bank->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->nama_rekening->Visible) { // nama_rekening ?>
	<tr id="r_nama_rekening">
		<td><span id="elh_data_kontrak_nama_rekening"><?php echo $data_kontrak->nama_rekening->FldCaption() ?></span></td>
		<td data-name="nama_rekening"<?php echo $data_kontrak->nama_rekening->CellAttributes() ?>>
<span id="el_data_kontrak_nama_rekening">
<span<?php echo $data_kontrak->nama_rekening->ViewAttributes() ?>>
<?php echo $data_kontrak->nama_rekening->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->nomer_rekening->Visible) { // nomer_rekening ?>
	<tr id="r_nomer_rekening">
		<td><span id="elh_data_kontrak_nomer_rekening"><?php echo $data_kontrak->nomer_rekening->FldCaption() ?></span></td>
		<td data-name="nomer_rekening"<?php echo $data_kontrak->nomer_rekening->CellAttributes() ?>>
<span id="el_data_kontrak_nomer_rekening">
<span<?php echo $data_kontrak->nomer_rekening->ViewAttributes() ?>>
<?php echo $data_kontrak->nomer_rekening->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->lanjutkan->Visible) { // lanjutkan ?>
	<tr id="r_lanjutkan">
		<td><span id="elh_data_kontrak_lanjutkan"><?php echo $data_kontrak->lanjutkan->FldCaption() ?></span></td>
		<td data-name="lanjutkan"<?php echo $data_kontrak->lanjutkan->CellAttributes() ?>>
<span id="el_data_kontrak_lanjutkan">
<span<?php echo $data_kontrak->lanjutkan->ViewAttributes() ?>>
<?php echo $data_kontrak->lanjutkan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->waktu_kontrak->Visible) { // waktu_kontrak ?>
	<tr id="r_waktu_kontrak">
		<td><span id="elh_data_kontrak_waktu_kontrak"><?php echo $data_kontrak->waktu_kontrak->FldCaption() ?></span></td>
		<td data-name="waktu_kontrak"<?php echo $data_kontrak->waktu_kontrak->CellAttributes() ?>>
<span id="el_data_kontrak_waktu_kontrak">
<span<?php echo $data_kontrak->waktu_kontrak->ViewAttributes() ?>>
<?php echo $data_kontrak->waktu_kontrak->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->tgl_mulai->Visible) { // tgl_mulai ?>
	<tr id="r_tgl_mulai">
		<td><span id="elh_data_kontrak_tgl_mulai"><?php echo $data_kontrak->tgl_mulai->FldCaption() ?></span></td>
		<td data-name="tgl_mulai"<?php echo $data_kontrak->tgl_mulai->CellAttributes() ?>>
<span id="el_data_kontrak_tgl_mulai">
<span<?php echo $data_kontrak->tgl_mulai->ViewAttributes() ?>>
<?php echo $data_kontrak->tgl_mulai->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->tgl_selesai->Visible) { // tgl_selesai ?>
	<tr id="r_tgl_selesai">
		<td><span id="elh_data_kontrak_tgl_selesai"><?php echo $data_kontrak->tgl_selesai->FldCaption() ?></span></td>
		<td data-name="tgl_selesai"<?php echo $data_kontrak->tgl_selesai->CellAttributes() ?>>
<span id="el_data_kontrak_tgl_selesai">
<span<?php echo $data_kontrak->tgl_selesai->ViewAttributes() ?>>
<?php echo $data_kontrak->tgl_selesai->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->paket_pekerjaan->Visible) { // paket_pekerjaan ?>
	<tr id="r_paket_pekerjaan">
		<td><span id="elh_data_kontrak_paket_pekerjaan"><?php echo $data_kontrak->paket_pekerjaan->FldCaption() ?></span></td>
		<td data-name="paket_pekerjaan"<?php echo $data_kontrak->paket_pekerjaan->CellAttributes() ?>>
<span id="el_data_kontrak_paket_pekerjaan">
<span<?php echo $data_kontrak->paket_pekerjaan->ViewAttributes() ?>>
<?php echo $data_kontrak->paket_pekerjaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->nama_ppkom->Visible) { // nama_ppkom ?>
	<tr id="r_nama_ppkom">
		<td><span id="elh_data_kontrak_nama_ppkom"><?php echo $data_kontrak->nama_ppkom->FldCaption() ?></span></td>
		<td data-name="nama_ppkom"<?php echo $data_kontrak->nama_ppkom->CellAttributes() ?>>
<span id="el_data_kontrak_nama_ppkom">
<span<?php echo $data_kontrak->nama_ppkom->ViewAttributes() ?>>
<?php echo $data_kontrak->nama_ppkom->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($data_kontrak->nip_ppkom->Visible) { // nip_ppkom ?>
	<tr id="r_nip_ppkom">
		<td><span id="elh_data_kontrak_nip_ppkom"><?php echo $data_kontrak->nip_ppkom->FldCaption() ?></span></td>
		<td data-name="nip_ppkom"<?php echo $data_kontrak->nip_ppkom->CellAttributes() ?>>
<span id="el_data_kontrak_nip_ppkom">
<span<?php echo $data_kontrak->nip_ppkom->ViewAttributes() ?>>
<?php echo $data_kontrak->nip_ppkom->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("data_kontrak_detail_termin", explode(",", $data_kontrak->getCurrentDetailTable())) && $data_kontrak_detail_termin->DetailView) {
?>
<?php if ($data_kontrak->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("data_kontrak_detail_termin", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "data_kontrak_detail_termingrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fdata_kontrakview.Init();
</script>
<?php
$data_kontrak_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$data_kontrak_view->Page_Terminate();
?>
