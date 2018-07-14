<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spj_guinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "detail_spjgridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spj_gu_view = NULL; // Initialize page object first

class cvw_spj_gu_view extends cvw_spj_gu {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spj_gu';

	// Page object name
	var $PageObjName = 'vw_spj_gu_view';

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

		// Table object (vw_spj_gu)
		if (!isset($GLOBALS["vw_spj_gu"]) || get_class($GLOBALS["vw_spj_gu"]) == "cvw_spj_gu") {
			$GLOBALS["vw_spj_gu"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spj_gu"];
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
			define("EW_TABLE_NAME", 'vw_spj_gu', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spj_gulist.php"));
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
		$this->no_spj->SetVisibility();
		$this->tgl_spj->SetVisibility();
		$this->tipe->SetVisibility();
		$this->tipe_sbp->SetVisibility();
		$this->no_sbp->SetVisibility();
		$this->tgl_sbp->SetVisibility();
		$this->uraian->SetVisibility();
		$this->nama_penerima->SetVisibility();

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
		global $EW_EXPORT, $vw_spj_gu;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spj_gu);
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
				$sReturnUrl = "vw_spj_gulist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "vw_spj_gulist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "vw_spj_gulist.php"; // Not page request, return to list
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

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_detail_spj"
		$item = &$option->Add("detail_detail_spj");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("detail_spj", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("detail_spjlist.php?" . EW_TABLE_SHOW_MASTER . "=vw_spj_gu&fk_no_spj=" . urlencode(strval($this->no_spj->CurrentValue)) . "&fk_tgl_spj=" . urlencode(ew_UnFormatDateTime($this->tgl_spj->CurrentValue, 0)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["detail_spj_grid"] && $GLOBALS["detail_spj_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'detail_spj')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=detail_spj")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "detail_spj";
		}
		if ($GLOBALS["detail_spj_grid"] && $GLOBALS["detail_spj_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'detail_spj')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=detail_spj")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "detail_spj";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'detail_spj');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "detail_spj";
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
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->tipe->setDbValue($rs->fields('tipe'));
		$this->tipe_sbp->setDbValue($rs->fields('tipe_sbp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->tgl_sbp->setDbValue($rs->fields('tgl_sbp'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->nama_penerima->setDbValue($rs->fields('nama_penerima'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->no_spj->DbValue = $row['no_spj'];
		$this->tgl_spj->DbValue = $row['tgl_spj'];
		$this->tipe->DbValue = $row['tipe'];
		$this->tipe_sbp->DbValue = $row['tipe_sbp'];
		$this->no_sbp->DbValue = $row['no_sbp'];
		$this->tgl_sbp->DbValue = $row['tgl_sbp'];
		$this->uraian->DbValue = $row['uraian'];
		$this->nama_penerima->DbValue = $row['nama_penerima'];
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
		// no_spj
		// tgl_spj
		// tipe
		// tipe_sbp
		// no_sbp
		// tgl_sbp
		// uraian
		// nama_penerima

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 7);
		$this->tgl_spj->ViewCustomAttributes = "";

		// tipe
		if (strval($this->tipe->CurrentValue) <> "") {
			$this->tipe->ViewValue = $this->tipe->OptionCaption($this->tipe->CurrentValue);
		} else {
			$this->tipe->ViewValue = NULL;
		}
		$this->tipe->ViewCustomAttributes = "";

		// tipe_sbp
		if (strval($this->tipe_sbp->CurrentValue) <> "") {
			$this->tipe_sbp->ViewValue = $this->tipe_sbp->OptionCaption($this->tipe_sbp->CurrentValue);
		} else {
			$this->tipe_sbp->ViewValue = NULL;
		}
		$this->tipe_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

		// tgl_sbp
		$this->tgl_sbp->ViewValue = $this->tgl_sbp->CurrentValue;
		$this->tgl_sbp->ViewValue = ew_FormatDateTime($this->tgl_sbp->ViewValue, 0);
		$this->tgl_sbp->ViewCustomAttributes = "";

		// uraian
		$this->uraian->ViewValue = $this->uraian->CurrentValue;
		$this->uraian->ViewCustomAttributes = "";

		// nama_penerima
		$this->nama_penerima->ViewValue = $this->nama_penerima->CurrentValue;
		$this->nama_penerima->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// no_spj
			$this->no_spj->LinkCustomAttributes = "";
			$this->no_spj->HrefValue = "";
			$this->no_spj->TooltipValue = "";

			// tgl_spj
			$this->tgl_spj->LinkCustomAttributes = "";
			$this->tgl_spj->HrefValue = "";
			$this->tgl_spj->TooltipValue = "";

			// tipe
			$this->tipe->LinkCustomAttributes = "";
			$this->tipe->HrefValue = "";
			$this->tipe->TooltipValue = "";

			// tipe_sbp
			$this->tipe_sbp->LinkCustomAttributes = "";
			$this->tipe_sbp->HrefValue = "";
			$this->tipe_sbp->TooltipValue = "";

			// no_sbp
			$this->no_sbp->LinkCustomAttributes = "";
			$this->no_sbp->HrefValue = "";
			$this->no_sbp->TooltipValue = "";

			// tgl_sbp
			$this->tgl_sbp->LinkCustomAttributes = "";
			$this->tgl_sbp->HrefValue = "";
			$this->tgl_sbp->TooltipValue = "";

			// uraian
			$this->uraian->LinkCustomAttributes = "";
			$this->uraian->HrefValue = "";
			$this->uraian->TooltipValue = "";

			// nama_penerima
			$this->nama_penerima->LinkCustomAttributes = "";
			$this->nama_penerima->HrefValue = "";
			$this->nama_penerima->TooltipValue = "";
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
			if (in_array("detail_spj", $DetailTblVar)) {
				if (!isset($GLOBALS["detail_spj_grid"]))
					$GLOBALS["detail_spj_grid"] = new cdetail_spj_grid;
				if ($GLOBALS["detail_spj_grid"]->DetailView) {
					$GLOBALS["detail_spj_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["detail_spj_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["detail_spj_grid"]->setStartRecordNumber(1);
					$GLOBALS["detail_spj_grid"]->no_spj->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->no_spj->CurrentValue = $this->no_spj->CurrentValue;
					$GLOBALS["detail_spj_grid"]->no_spj->setSessionValue($GLOBALS["detail_spj_grid"]->no_spj->CurrentValue);
					$GLOBALS["detail_spj_grid"]->tgl_spj->FldIsDetailKey = TRUE;
					$GLOBALS["detail_spj_grid"]->tgl_spj->CurrentValue = $this->tgl_spj->CurrentValue;
					$GLOBALS["detail_spj_grid"]->tgl_spj->setSessionValue($GLOBALS["detail_spj_grid"]->tgl_spj->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spj_gulist.php"), "", $this->TableVar, TRUE);
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
if (!isset($vw_spj_gu_view)) $vw_spj_gu_view = new cvw_spj_gu_view();

// Page init
$vw_spj_gu_view->Page_Init();

// Page main
$vw_spj_gu_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spj_gu_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fvw_spj_guview = new ew_Form("fvw_spj_guview", "view");

// Form_CustomValidate event
fvw_spj_guview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spj_guview.ValidateRequired = true;
<?php } else { ?>
fvw_spj_guview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spj_guview.Lists["x_tipe"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spj_guview.Lists["x_tipe"].Options = <?php echo json_encode($vw_spj_gu->tipe->Options()) ?>;
fvw_spj_guview.Lists["x_tipe_sbp"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fvw_spj_guview.Lists["x_tipe_sbp"].Options = <?php echo json_encode($vw_spj_gu->tipe_sbp->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spj_gu_view->IsModal) { ?>
<?php } ?>
<?php $vw_spj_gu_view->ExportOptions->Render("body") ?>
<?php
	foreach ($vw_spj_gu_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$vw_spj_gu_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $vw_spj_gu_view->ShowPageHeader(); ?>
<?php
$vw_spj_gu_view->ShowMessage();
?>
<form name="fvw_spj_guview" id="fvw_spj_guview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spj_gu_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spj_gu_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spj_gu">
<?php if ($vw_spj_gu_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($vw_spj_gu->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_vw_spj_gu_id"><?php echo $vw_spj_gu->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $vw_spj_gu->id->CellAttributes() ?>>
<div id="orig_vw_spj_gu_id" class="hide">
<span id="el_vw_spj_gu_id">
<span<?php echo $vw_spj_gu->id->ViewAttributes() ?>>
<?php echo $vw_spj_gu->id->ViewValue ?></span>
</span>
</div>
<div>
<?php
	$no_spj = urlencode(CurrentPage()->no_spj->CurrentValue);
	if($no_spj == null)
	{
?>
<a class="btn btn-info btn-xs"  
target="_self" 
href="vw_spj_guedit.php?id=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">
PROSES SPJ <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
</a>
<?php
}else{  
?><a class="btn btn-success btn-xs"  target="_blank" href="cetak_spm_up.php?kdspp=<?php echo urlencode(CurrentPage()->id->CurrentValue)?>">CETAK SPJ  <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span></a><?php
}
?>
</div>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->no_spj->Visible) { // no_spj ?>
	<tr id="r_no_spj">
		<td><span id="elh_vw_spj_gu_no_spj"><?php echo $vw_spj_gu->no_spj->FldCaption() ?></span></td>
		<td data-name="no_spj"<?php echo $vw_spj_gu->no_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_spj">
<span<?php echo $vw_spj_gu->no_spj->ViewAttributes() ?>>
<?php echo $vw_spj_gu->no_spj->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->tgl_spj->Visible) { // tgl_spj ?>
	<tr id="r_tgl_spj">
		<td><span id="elh_vw_spj_gu_tgl_spj"><?php echo $vw_spj_gu->tgl_spj->FldCaption() ?></span></td>
		<td data-name="tgl_spj"<?php echo $vw_spj_gu->tgl_spj->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_spj">
<span<?php echo $vw_spj_gu->tgl_spj->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tgl_spj->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->tipe->Visible) { // tipe ?>
	<tr id="r_tipe">
		<td><span id="elh_vw_spj_gu_tipe"><?php echo $vw_spj_gu->tipe->FldCaption() ?></span></td>
		<td data-name="tipe"<?php echo $vw_spj_gu->tipe->CellAttributes() ?>>
<span id="el_vw_spj_gu_tipe">
<span<?php echo $vw_spj_gu->tipe->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tipe->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->tipe_sbp->Visible) { // tipe_sbp ?>
	<tr id="r_tipe_sbp">
		<td><span id="elh_vw_spj_gu_tipe_sbp"><?php echo $vw_spj_gu->tipe_sbp->FldCaption() ?></span></td>
		<td data-name="tipe_sbp"<?php echo $vw_spj_gu->tipe_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tipe_sbp">
<span<?php echo $vw_spj_gu->tipe_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tipe_sbp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->no_sbp->Visible) { // no_sbp ?>
	<tr id="r_no_sbp">
		<td><span id="elh_vw_spj_gu_no_sbp"><?php echo $vw_spj_gu->no_sbp->FldCaption() ?></span></td>
		<td data-name="no_sbp"<?php echo $vw_spj_gu->no_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_no_sbp">
<span<?php echo $vw_spj_gu->no_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->no_sbp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->tgl_sbp->Visible) { // tgl_sbp ?>
	<tr id="r_tgl_sbp">
		<td><span id="elh_vw_spj_gu_tgl_sbp"><?php echo $vw_spj_gu->tgl_sbp->FldCaption() ?></span></td>
		<td data-name="tgl_sbp"<?php echo $vw_spj_gu->tgl_sbp->CellAttributes() ?>>
<span id="el_vw_spj_gu_tgl_sbp">
<span<?php echo $vw_spj_gu->tgl_sbp->ViewAttributes() ?>>
<?php echo $vw_spj_gu->tgl_sbp->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->uraian->Visible) { // uraian ?>
	<tr id="r_uraian">
		<td><span id="elh_vw_spj_gu_uraian"><?php echo $vw_spj_gu->uraian->FldCaption() ?></span></td>
		<td data-name="uraian"<?php echo $vw_spj_gu->uraian->CellAttributes() ?>>
<span id="el_vw_spj_gu_uraian">
<span<?php echo $vw_spj_gu->uraian->ViewAttributes() ?>>
<?php echo $vw_spj_gu->uraian->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($vw_spj_gu->nama_penerima->Visible) { // nama_penerima ?>
	<tr id="r_nama_penerima">
		<td><span id="elh_vw_spj_gu_nama_penerima"><?php echo $vw_spj_gu->nama_penerima->FldCaption() ?></span></td>
		<td data-name="nama_penerima"<?php echo $vw_spj_gu->nama_penerima->CellAttributes() ?>>
<span id="el_vw_spj_gu_nama_penerima">
<span<?php echo $vw_spj_gu->nama_penerima->ViewAttributes() ?>>
<?php echo $vw_spj_gu->nama_penerima->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("detail_spj", explode(",", $vw_spj_gu->getCurrentDetailTable())) && $detail_spj->DetailView) {
?>
<?php if ($vw_spj_gu->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("detail_spj", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "detail_spjgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spj_guview.Init();
</script>
<?php
$vw_spj_gu_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spj_gu_view->Page_Terminate();
?>
