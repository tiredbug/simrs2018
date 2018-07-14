<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_login_view = NULL; // Initialize page object first

class cm_login_view extends cm_login {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_login';

	// Page object name
	var $PageObjName = 'm_login_view';

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

		// Table object (m_login)
		if (!isset($GLOBALS["m_login"]) || get_class($GLOBALS["m_login"]) == "cm_login") {
			$GLOBALS["m_login"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_login"];
		}
		$KeyUrl = "";
		if (@$_GET["NIP"] <> "") {
			$this->RecKey["NIP"] = $_GET["NIP"];
			$KeyUrl .= "&amp;NIP=" . urlencode($this->RecKey["NIP"]);
		}
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_login', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_loginlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("m_loginlist.php"));
			}
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NIP->SetVisibility();
		$this->PWD->SetVisibility();
		$this->SES_REG->SetVisibility();
		$this->ROLES->SetVisibility();
		$this->KDUNIT->SetVisibility();
		$this->DEPARTEMEN->SetVisibility();
		$this->nama->SetVisibility();
		$this->gambar->SetVisibility();
		$this->NIK->SetVisibility();
		$this->grup_ranap->SetVisibility();
		$this->pd_nickname->SetVisibility();
		$this->role_id->SetVisibility();
		$this->pd_avatar->SetVisibility();
		$this->pd_datejoined->SetVisibility();
		$this->pd_parentid->SetVisibility();
		$this->pd_email->SetVisibility();
		$this->pd_activated->SetVisibility();
		$this->pd_profiletext->SetVisibility();
		$this->pd_title->SetVisibility();
		$this->pd_ipaddr->SetVisibility();
		$this->pd_useragent->SetVisibility();
		$this->pd_online->SetVisibility();
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $m_login;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_login);
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
			if (@$_GET["NIP"] <> "") {
				$this->NIP->setQueryStringValue($_GET["NIP"]);
				$this->RecKey["NIP"] = $this->NIP->QueryStringValue;
			} elseif (@$_POST["NIP"] <> "") {
				$this->NIP->setFormValue($_POST["NIP"]);
				$this->RecKey["NIP"] = $this->NIP->FormValue;
			} else {
				$sReturnUrl = "m_loginlist.php"; // Return to list
			}
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "m_loginlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "m_loginlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "m_loginlist.php"; // Not page request, return to list
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
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit()&& $this->ShowOptionLink('edit'));

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd() && $this->ShowOptionLink('add'));

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete() && $this->ShowOptionLink('delete'));

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
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->PWD->setDbValue($rs->fields('PWD'));
		$this->SES_REG->setDbValue($rs->fields('SES_REG'));
		$this->ROLES->setDbValue($rs->fields('ROLES'));
		$this->KDUNIT->setDbValue($rs->fields('KDUNIT'));
		$this->DEPARTEMEN->setDbValue($rs->fields('DEPARTEMEN'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->gambar->setDbValue($rs->fields('gambar'));
		$this->NIK->setDbValue($rs->fields('NIK'));
		$this->grup_ranap->setDbValue($rs->fields('grup_ranap'));
		$this->pd_nickname->setDbValue($rs->fields('pd_nickname'));
		$this->role_id->setDbValue($rs->fields('role_id'));
		$this->pd_avatar->Upload->DbValue = $rs->fields('pd_avatar');
		$this->pd_avatar->CurrentValue = $this->pd_avatar->Upload->DbValue;
		$this->pd_datejoined->setDbValue($rs->fields('pd_datejoined'));
		$this->pd_parentid->setDbValue($rs->fields('pd_parentid'));
		$this->pd_email->setDbValue($rs->fields('pd_email'));
		$this->pd_activated->setDbValue($rs->fields('pd_activated'));
		$this->pd_profiletext->setDbValue($rs->fields('pd_profiletext'));
		$this->pd_title->setDbValue($rs->fields('pd_title'));
		$this->pd_ipaddr->setDbValue($rs->fields('pd_ipaddr'));
		$this->pd_useragent->setDbValue($rs->fields('pd_useragent'));
		$this->pd_online->setDbValue($rs->fields('pd_online'));
		$this->id->setDbValue($rs->fields('id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->NIP->DbValue = $row['NIP'];
		$this->PWD->DbValue = $row['PWD'];
		$this->SES_REG->DbValue = $row['SES_REG'];
		$this->ROLES->DbValue = $row['ROLES'];
		$this->KDUNIT->DbValue = $row['KDUNIT'];
		$this->DEPARTEMEN->DbValue = $row['DEPARTEMEN'];
		$this->nama->DbValue = $row['nama'];
		$this->gambar->DbValue = $row['gambar'];
		$this->NIK->DbValue = $row['NIK'];
		$this->grup_ranap->DbValue = $row['grup_ranap'];
		$this->pd_nickname->DbValue = $row['pd_nickname'];
		$this->role_id->DbValue = $row['role_id'];
		$this->pd_avatar->Upload->DbValue = $row['pd_avatar'];
		$this->pd_datejoined->DbValue = $row['pd_datejoined'];
		$this->pd_parentid->DbValue = $row['pd_parentid'];
		$this->pd_email->DbValue = $row['pd_email'];
		$this->pd_activated->DbValue = $row['pd_activated'];
		$this->pd_profiletext->DbValue = $row['pd_profiletext'];
		$this->pd_title->DbValue = $row['pd_title'];
		$this->pd_ipaddr->DbValue = $row['pd_ipaddr'];
		$this->pd_useragent->DbValue = $row['pd_useragent'];
		$this->pd_online->DbValue = $row['pd_online'];
		$this->id->DbValue = $row['id'];
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
		// NIP
		// PWD
		// SES_REG
		// ROLES
		// KDUNIT
		// DEPARTEMEN
		// nama
		// gambar
		// NIK
		// grup_ranap
		// pd_nickname
		// role_id
		// pd_avatar
		// pd_datejoined
		// pd_parentid
		// pd_email
		// pd_activated
		// pd_profiletext
		// pd_title
		// pd_ipaddr
		// pd_useragent
		// pd_online
		// id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// PWD
		$this->PWD->ViewValue = $this->PWD->CurrentValue;
		$this->PWD->ViewCustomAttributes = "";

		// SES_REG
		$this->SES_REG->ViewValue = $this->SES_REG->CurrentValue;
		$this->SES_REG->ViewCustomAttributes = "";

		// ROLES
		$this->ROLES->ViewValue = $this->ROLES->CurrentValue;
		$this->ROLES->ViewCustomAttributes = "";

		// KDUNIT
		$this->KDUNIT->ViewValue = $this->KDUNIT->CurrentValue;
		$this->KDUNIT->ViewCustomAttributes = "";

		// DEPARTEMEN
		$this->DEPARTEMEN->ViewValue = $this->DEPARTEMEN->CurrentValue;
		$this->DEPARTEMEN->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// gambar
		$this->gambar->ViewValue = $this->gambar->CurrentValue;
		$this->gambar->ViewCustomAttributes = "";

		// NIK
		$this->NIK->ViewValue = $this->NIK->CurrentValue;
		$this->NIK->ViewCustomAttributes = "";

		// grup_ranap
		$this->grup_ranap->ViewValue = $this->grup_ranap->CurrentValue;
		$this->grup_ranap->ViewCustomAttributes = "";

		// pd_nickname
		$this->pd_nickname->ViewValue = $this->pd_nickname->CurrentValue;
		$this->pd_nickname->ViewCustomAttributes = "";

		// role_id
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->role_id->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->role_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->role_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->role_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->role_id->ViewValue = $this->role_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->role_id->ViewValue = $this->role_id->CurrentValue;
			}
		} else {
			$this->role_id->ViewValue = NULL;
		}
		} else {
			$this->role_id->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->role_id->ViewCustomAttributes = "";

		// pd_avatar
		if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
			$this->pd_avatar->ImageWidth = 50;
			$this->pd_avatar->ImageHeight = 50;
			$this->pd_avatar->ImageAlt = $this->pd_avatar->FldAlt();
			$this->pd_avatar->ViewValue = $this->pd_avatar->Upload->DbValue;
		} else {
			$this->pd_avatar->ViewValue = "";
		}
		$this->pd_avatar->ViewCustomAttributes = " class = 'img-circle' ";

		// pd_datejoined
		$this->pd_datejoined->ViewValue = $this->pd_datejoined->CurrentValue;
		$this->pd_datejoined->ViewValue = ew_FormatDateTime($this->pd_datejoined->ViewValue, 0);
		$this->pd_datejoined->ViewCustomAttributes = "";

		// pd_parentid
		$this->pd_parentid->ViewValue = $this->pd_parentid->CurrentValue;
		$this->pd_parentid->ViewCustomAttributes = "";

		// pd_email
		$this->pd_email->ViewValue = $this->pd_email->CurrentValue;
		$this->pd_email->ViewCustomAttributes = "";

		// pd_activated
		$this->pd_activated->ViewValue = $this->pd_activated->CurrentValue;
		$this->pd_activated->ViewCustomAttributes = "";

		// pd_profiletext
		$this->pd_profiletext->ViewValue = $this->pd_profiletext->CurrentValue;
		$this->pd_profiletext->ViewCustomAttributes = "";

		// pd_title
		$this->pd_title->ViewValue = $this->pd_title->CurrentValue;
		$this->pd_title->ViewCustomAttributes = "";

		// pd_ipaddr
		$this->pd_ipaddr->ViewValue = $this->pd_ipaddr->CurrentValue;
		$this->pd_ipaddr->ViewCustomAttributes = "";

		// pd_useragent
		$this->pd_useragent->ViewValue = $this->pd_useragent->CurrentValue;
		$this->pd_useragent->ViewCustomAttributes = "";

		// pd_online
		$this->pd_online->ViewValue = $this->pd_online->CurrentValue;
		$this->pd_online->ViewCustomAttributes = "";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// PWD
			$this->PWD->LinkCustomAttributes = "";
			$this->PWD->HrefValue = "";
			$this->PWD->TooltipValue = "";

			// SES_REG
			$this->SES_REG->LinkCustomAttributes = "";
			$this->SES_REG->HrefValue = "";
			$this->SES_REG->TooltipValue = "";

			// ROLES
			$this->ROLES->LinkCustomAttributes = "";
			$this->ROLES->HrefValue = "";
			$this->ROLES->TooltipValue = "";

			// KDUNIT
			$this->KDUNIT->LinkCustomAttributes = "";
			$this->KDUNIT->HrefValue = "";
			$this->KDUNIT->TooltipValue = "";

			// DEPARTEMEN
			$this->DEPARTEMEN->LinkCustomAttributes = "";
			$this->DEPARTEMEN->HrefValue = "";
			$this->DEPARTEMEN->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// gambar
			$this->gambar->LinkCustomAttributes = "";
			$this->gambar->HrefValue = "";
			$this->gambar->TooltipValue = "";

			// NIK
			$this->NIK->LinkCustomAttributes = "";
			$this->NIK->HrefValue = "";
			$this->NIK->TooltipValue = "";

			// grup_ranap
			$this->grup_ranap->LinkCustomAttributes = "";
			$this->grup_ranap->HrefValue = "";
			$this->grup_ranap->TooltipValue = "";

			// pd_nickname
			$this->pd_nickname->LinkCustomAttributes = "";
			$this->pd_nickname->HrefValue = "";
			$this->pd_nickname->TooltipValue = "";

			// role_id
			$this->role_id->LinkCustomAttributes = "";
			$this->role_id->HrefValue = "";
			$this->role_id->TooltipValue = "";

			// pd_avatar
			$this->pd_avatar->LinkCustomAttributes = "";
			if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
				$this->pd_avatar->HrefValue = ew_GetFileUploadUrl($this->pd_avatar, $this->pd_avatar->Upload->DbValue); // Add prefix/suffix
				$this->pd_avatar->LinkAttrs["target"] = "_blank"; // Add target
				if ($this->Export <> "") $this->pd_avatar->HrefValue = ew_ConvertFullUrl($this->pd_avatar->HrefValue);
			} else {
				$this->pd_avatar->HrefValue = "";
			}
			$this->pd_avatar->HrefValue2 = $this->pd_avatar->UploadPath . $this->pd_avatar->Upload->DbValue;
			$this->pd_avatar->TooltipValue = "";
			if ($this->pd_avatar->UseColorbox) {
				if (ew_Empty($this->pd_avatar->TooltipValue))
					$this->pd_avatar->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->pd_avatar->LinkAttrs["data-rel"] = "m_login_x_pd_avatar";
				ew_AppendClass($this->pd_avatar->LinkAttrs["class"], "ewLightbox");
			}

			// pd_datejoined
			$this->pd_datejoined->LinkCustomAttributes = "";
			$this->pd_datejoined->HrefValue = "";
			$this->pd_datejoined->TooltipValue = "";

			// pd_parentid
			$this->pd_parentid->LinkCustomAttributes = "";
			$this->pd_parentid->HrefValue = "";
			$this->pd_parentid->TooltipValue = "";

			// pd_email
			$this->pd_email->LinkCustomAttributes = "";
			$this->pd_email->HrefValue = "";
			$this->pd_email->TooltipValue = "";

			// pd_activated
			$this->pd_activated->LinkCustomAttributes = "";
			$this->pd_activated->HrefValue = "";
			$this->pd_activated->TooltipValue = "";

			// pd_profiletext
			$this->pd_profiletext->LinkCustomAttributes = "";
			$this->pd_profiletext->HrefValue = "";
			$this->pd_profiletext->TooltipValue = "";

			// pd_title
			$this->pd_title->LinkCustomAttributes = "";
			$this->pd_title->HrefValue = "";
			$this->pd_title->TooltipValue = "";

			// pd_ipaddr
			$this->pd_ipaddr->LinkCustomAttributes = "";
			$this->pd_ipaddr->HrefValue = "";
			$this->pd_ipaddr->TooltipValue = "";

			// pd_useragent
			$this->pd_useragent->LinkCustomAttributes = "";
			$this->pd_useragent->HrefValue = "";
			$this->pd_useragent->TooltipValue = "";

			// pd_online
			$this->pd_online->LinkCustomAttributes = "";
			$this->pd_online->HrefValue = "";
			$this->pd_online->TooltipValue = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->id->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_loginlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_login_view)) $m_login_view = new cm_login_view();

// Page init
$m_login_view->Page_Init();

// Page main
$m_login_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_login_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fm_loginview = new ew_Form("fm_loginview", "view");

// Form_CustomValidate event
fm_loginview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_loginview.ValidateRequired = true;
<?php } else { ?>
fm_loginview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_loginview.Lists["x_role_id"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_login_view->IsModal) { ?>
<?php } ?>
<?php $m_login_view->ExportOptions->Render("body") ?>
<?php
	foreach ($m_login_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$m_login_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $m_login_view->ShowPageHeader(); ?>
<?php
$m_login_view->ShowMessage();
?>
<form name="fm_loginview" id="fm_loginview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_login_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_login_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_login">
<?php if ($m_login_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($m_login->NIP->Visible) { // NIP ?>
	<tr id="r_NIP">
		<td><span id="elh_m_login_NIP"><?php echo $m_login->NIP->FldCaption() ?></span></td>
		<td data-name="NIP"<?php echo $m_login->NIP->CellAttributes() ?>>
<span id="el_m_login_NIP">
<span<?php echo $m_login->NIP->ViewAttributes() ?>>
<?php echo $m_login->NIP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->PWD->Visible) { // PWD ?>
	<tr id="r_PWD">
		<td><span id="elh_m_login_PWD"><?php echo $m_login->PWD->FldCaption() ?></span></td>
		<td data-name="PWD"<?php echo $m_login->PWD->CellAttributes() ?>>
<span id="el_m_login_PWD">
<span<?php echo $m_login->PWD->ViewAttributes() ?>>
<?php echo $m_login->PWD->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->SES_REG->Visible) { // SES_REG ?>
	<tr id="r_SES_REG">
		<td><span id="elh_m_login_SES_REG"><?php echo $m_login->SES_REG->FldCaption() ?></span></td>
		<td data-name="SES_REG"<?php echo $m_login->SES_REG->CellAttributes() ?>>
<span id="el_m_login_SES_REG">
<span<?php echo $m_login->SES_REG->ViewAttributes() ?>>
<?php echo $m_login->SES_REG->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->ROLES->Visible) { // ROLES ?>
	<tr id="r_ROLES">
		<td><span id="elh_m_login_ROLES"><?php echo $m_login->ROLES->FldCaption() ?></span></td>
		<td data-name="ROLES"<?php echo $m_login->ROLES->CellAttributes() ?>>
<span id="el_m_login_ROLES">
<span<?php echo $m_login->ROLES->ViewAttributes() ?>>
<?php echo $m_login->ROLES->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->KDUNIT->Visible) { // KDUNIT ?>
	<tr id="r_KDUNIT">
		<td><span id="elh_m_login_KDUNIT"><?php echo $m_login->KDUNIT->FldCaption() ?></span></td>
		<td data-name="KDUNIT"<?php echo $m_login->KDUNIT->CellAttributes() ?>>
<span id="el_m_login_KDUNIT">
<span<?php echo $m_login->KDUNIT->ViewAttributes() ?>>
<?php echo $m_login->KDUNIT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->DEPARTEMEN->Visible) { // DEPARTEMEN ?>
	<tr id="r_DEPARTEMEN">
		<td><span id="elh_m_login_DEPARTEMEN"><?php echo $m_login->DEPARTEMEN->FldCaption() ?></span></td>
		<td data-name="DEPARTEMEN"<?php echo $m_login->DEPARTEMEN->CellAttributes() ?>>
<span id="el_m_login_DEPARTEMEN">
<span<?php echo $m_login->DEPARTEMEN->ViewAttributes() ?>>
<?php echo $m_login->DEPARTEMEN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->nama->Visible) { // nama ?>
	<tr id="r_nama">
		<td><span id="elh_m_login_nama"><?php echo $m_login->nama->FldCaption() ?></span></td>
		<td data-name="nama"<?php echo $m_login->nama->CellAttributes() ?>>
<span id="el_m_login_nama">
<span<?php echo $m_login->nama->ViewAttributes() ?>>
<?php echo $m_login->nama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->gambar->Visible) { // gambar ?>
	<tr id="r_gambar">
		<td><span id="elh_m_login_gambar"><?php echo $m_login->gambar->FldCaption() ?></span></td>
		<td data-name="gambar"<?php echo $m_login->gambar->CellAttributes() ?>>
<span id="el_m_login_gambar">
<span<?php echo $m_login->gambar->ViewAttributes() ?>>
<?php echo $m_login->gambar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->NIK->Visible) { // NIK ?>
	<tr id="r_NIK">
		<td><span id="elh_m_login_NIK"><?php echo $m_login->NIK->FldCaption() ?></span></td>
		<td data-name="NIK"<?php echo $m_login->NIK->CellAttributes() ?>>
<span id="el_m_login_NIK">
<span<?php echo $m_login->NIK->ViewAttributes() ?>>
<?php echo $m_login->NIK->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->grup_ranap->Visible) { // grup_ranap ?>
	<tr id="r_grup_ranap">
		<td><span id="elh_m_login_grup_ranap"><?php echo $m_login->grup_ranap->FldCaption() ?></span></td>
		<td data-name="grup_ranap"<?php echo $m_login->grup_ranap->CellAttributes() ?>>
<span id="el_m_login_grup_ranap">
<span<?php echo $m_login->grup_ranap->ViewAttributes() ?>>
<?php echo $m_login->grup_ranap->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_nickname->Visible) { // pd_nickname ?>
	<tr id="r_pd_nickname">
		<td><span id="elh_m_login_pd_nickname"><?php echo $m_login->pd_nickname->FldCaption() ?></span></td>
		<td data-name="pd_nickname"<?php echo $m_login->pd_nickname->CellAttributes() ?>>
<span id="el_m_login_pd_nickname">
<span<?php echo $m_login->pd_nickname->ViewAttributes() ?>>
<?php echo $m_login->pd_nickname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->role_id->Visible) { // role_id ?>
	<tr id="r_role_id">
		<td><span id="elh_m_login_role_id"><?php echo $m_login->role_id->FldCaption() ?></span></td>
		<td data-name="role_id"<?php echo $m_login->role_id->CellAttributes() ?>>
<span id="el_m_login_role_id">
<span<?php echo $m_login->role_id->ViewAttributes() ?>>
<?php echo $m_login->role_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_avatar->Visible) { // pd_avatar ?>
	<tr id="r_pd_avatar">
		<td><span id="elh_m_login_pd_avatar"><?php echo $m_login->pd_avatar->FldCaption() ?></span></td>
		<td data-name="pd_avatar"<?php echo $m_login->pd_avatar->CellAttributes() ?>>
<span id="el_m_login_pd_avatar">
<span>
<?php echo ew_GetFileViewTag($m_login->pd_avatar, $m_login->pd_avatar->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_datejoined->Visible) { // pd_datejoined ?>
	<tr id="r_pd_datejoined">
		<td><span id="elh_m_login_pd_datejoined"><?php echo $m_login->pd_datejoined->FldCaption() ?></span></td>
		<td data-name="pd_datejoined"<?php echo $m_login->pd_datejoined->CellAttributes() ?>>
<span id="el_m_login_pd_datejoined">
<span<?php echo $m_login->pd_datejoined->ViewAttributes() ?>>
<?php echo $m_login->pd_datejoined->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_parentid->Visible) { // pd_parentid ?>
	<tr id="r_pd_parentid">
		<td><span id="elh_m_login_pd_parentid"><?php echo $m_login->pd_parentid->FldCaption() ?></span></td>
		<td data-name="pd_parentid"<?php echo $m_login->pd_parentid->CellAttributes() ?>>
<span id="el_m_login_pd_parentid">
<span<?php echo $m_login->pd_parentid->ViewAttributes() ?>>
<?php echo $m_login->pd_parentid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_email->Visible) { // pd_email ?>
	<tr id="r_pd_email">
		<td><span id="elh_m_login_pd_email"><?php echo $m_login->pd_email->FldCaption() ?></span></td>
		<td data-name="pd_email"<?php echo $m_login->pd_email->CellAttributes() ?>>
<span id="el_m_login_pd_email">
<span<?php echo $m_login->pd_email->ViewAttributes() ?>>
<?php echo $m_login->pd_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_activated->Visible) { // pd_activated ?>
	<tr id="r_pd_activated">
		<td><span id="elh_m_login_pd_activated"><?php echo $m_login->pd_activated->FldCaption() ?></span></td>
		<td data-name="pd_activated"<?php echo $m_login->pd_activated->CellAttributes() ?>>
<span id="el_m_login_pd_activated">
<span<?php echo $m_login->pd_activated->ViewAttributes() ?>>
<?php echo $m_login->pd_activated->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_profiletext->Visible) { // pd_profiletext ?>
	<tr id="r_pd_profiletext">
		<td><span id="elh_m_login_pd_profiletext"><?php echo $m_login->pd_profiletext->FldCaption() ?></span></td>
		<td data-name="pd_profiletext"<?php echo $m_login->pd_profiletext->CellAttributes() ?>>
<span id="el_m_login_pd_profiletext">
<span<?php echo $m_login->pd_profiletext->ViewAttributes() ?>>
<?php echo $m_login->pd_profiletext->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_title->Visible) { // pd_title ?>
	<tr id="r_pd_title">
		<td><span id="elh_m_login_pd_title"><?php echo $m_login->pd_title->FldCaption() ?></span></td>
		<td data-name="pd_title"<?php echo $m_login->pd_title->CellAttributes() ?>>
<span id="el_m_login_pd_title">
<span<?php echo $m_login->pd_title->ViewAttributes() ?>>
<?php echo $m_login->pd_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_ipaddr->Visible) { // pd_ipaddr ?>
	<tr id="r_pd_ipaddr">
		<td><span id="elh_m_login_pd_ipaddr"><?php echo $m_login->pd_ipaddr->FldCaption() ?></span></td>
		<td data-name="pd_ipaddr"<?php echo $m_login->pd_ipaddr->CellAttributes() ?>>
<span id="el_m_login_pd_ipaddr">
<span<?php echo $m_login->pd_ipaddr->ViewAttributes() ?>>
<?php echo $m_login->pd_ipaddr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_useragent->Visible) { // pd_useragent ?>
	<tr id="r_pd_useragent">
		<td><span id="elh_m_login_pd_useragent"><?php echo $m_login->pd_useragent->FldCaption() ?></span></td>
		<td data-name="pd_useragent"<?php echo $m_login->pd_useragent->CellAttributes() ?>>
<span id="el_m_login_pd_useragent">
<span<?php echo $m_login->pd_useragent->ViewAttributes() ?>>
<?php echo $m_login->pd_useragent->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->pd_online->Visible) { // pd_online ?>
	<tr id="r_pd_online">
		<td><span id="elh_m_login_pd_online"><?php echo $m_login->pd_online->FldCaption() ?></span></td>
		<td data-name="pd_online"<?php echo $m_login->pd_online->CellAttributes() ?>>
<span id="el_m_login_pd_online">
<span<?php echo $m_login->pd_online->ViewAttributes() ?>>
<?php echo $m_login->pd_online->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($m_login->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_m_login_id"><?php echo $m_login->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $m_login->id->CellAttributes() ?>>
<span id="el_m_login_id">
<span<?php echo $m_login->id->ViewAttributes() ?>>
<?php echo $m_login->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fm_loginview.Init();
</script>
<?php
$m_login_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_login_view->Page_Terminate();
?>
