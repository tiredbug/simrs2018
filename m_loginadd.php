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

$m_login_add = NULL; // Initialize page object first

class cm_login_add extends cm_login {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_login';

	// Page object name
	var $PageObjName = 'm_login_add';

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

		// Table object (m_login)
		if (!isset($GLOBALS["m_login"]) || get_class($GLOBALS["m_login"]) == "cm_login") {
			$GLOBALS["m_login"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_login"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
			if (@$_GET["NIP"] != "") {
				$this->NIP->setQueryStringValue($_GET["NIP"]);
				$this->setKey("NIP", $this->NIP->CurrentValue); // Set up key
			} else {
				$this->setKey("NIP", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
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
					$this->Page_Terminate("m_loginlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "m_loginlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "m_loginview.php")
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
		$this->pd_avatar->Upload->Index = $objForm->Index;
		$this->pd_avatar->Upload->UploadFile();
		$this->pd_avatar->CurrentValue = $this->pd_avatar->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->NIP->CurrentValue = NULL;
		$this->NIP->OldValue = $this->NIP->CurrentValue;
		$this->PWD->CurrentValue = NULL;
		$this->PWD->OldValue = $this->PWD->CurrentValue;
		$this->SES_REG->CurrentValue = NULL;
		$this->SES_REG->OldValue = $this->SES_REG->CurrentValue;
		$this->ROLES->CurrentValue = NULL;
		$this->ROLES->OldValue = $this->ROLES->CurrentValue;
		$this->KDUNIT->CurrentValue = NULL;
		$this->KDUNIT->OldValue = $this->KDUNIT->CurrentValue;
		$this->DEPARTEMEN->CurrentValue = NULL;
		$this->DEPARTEMEN->OldValue = $this->DEPARTEMEN->CurrentValue;
		$this->nama->CurrentValue = NULL;
		$this->nama->OldValue = $this->nama->CurrentValue;
		$this->gambar->CurrentValue = NULL;
		$this->gambar->OldValue = $this->gambar->CurrentValue;
		$this->NIK->CurrentValue = NULL;
		$this->NIK->OldValue = $this->NIK->CurrentValue;
		$this->grup_ranap->CurrentValue = NULL;
		$this->grup_ranap->OldValue = $this->grup_ranap->CurrentValue;
		$this->pd_nickname->CurrentValue = NULL;
		$this->pd_nickname->OldValue = $this->pd_nickname->CurrentValue;
		$this->role_id->CurrentValue = NULL;
		$this->role_id->OldValue = $this->role_id->CurrentValue;
		$this->pd_avatar->Upload->DbValue = NULL;
		$this->pd_avatar->OldValue = $this->pd_avatar->Upload->DbValue;
		$this->pd_avatar->CurrentValue = NULL; // Clear file related field
		$this->pd_datejoined->CurrentValue = NULL;
		$this->pd_datejoined->OldValue = $this->pd_datejoined->CurrentValue;
		$this->pd_parentid->CurrentValue = NULL;
		$this->pd_parentid->OldValue = $this->pd_parentid->CurrentValue;
		$this->pd_email->CurrentValue = NULL;
		$this->pd_email->OldValue = $this->pd_email->CurrentValue;
		$this->pd_activated->CurrentValue = NULL;
		$this->pd_activated->OldValue = $this->pd_activated->CurrentValue;
		$this->pd_profiletext->CurrentValue = NULL;
		$this->pd_profiletext->OldValue = $this->pd_profiletext->CurrentValue;
		$this->pd_title->CurrentValue = NULL;
		$this->pd_title->OldValue = $this->pd_title->CurrentValue;
		$this->pd_ipaddr->CurrentValue = NULL;
		$this->pd_ipaddr->OldValue = $this->pd_ipaddr->CurrentValue;
		$this->pd_useragent->CurrentValue = NULL;
		$this->pd_useragent->OldValue = $this->pd_useragent->CurrentValue;
		$this->pd_online->CurrentValue = NULL;
		$this->pd_online->OldValue = $this->pd_online->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->PWD->FldIsDetailKey) {
			$this->PWD->setFormValue($objForm->GetValue("x_PWD"));
		}
		if (!$this->SES_REG->FldIsDetailKey) {
			$this->SES_REG->setFormValue($objForm->GetValue("x_SES_REG"));
		}
		if (!$this->ROLES->FldIsDetailKey) {
			$this->ROLES->setFormValue($objForm->GetValue("x_ROLES"));
		}
		if (!$this->KDUNIT->FldIsDetailKey) {
			$this->KDUNIT->setFormValue($objForm->GetValue("x_KDUNIT"));
		}
		if (!$this->DEPARTEMEN->FldIsDetailKey) {
			$this->DEPARTEMEN->setFormValue($objForm->GetValue("x_DEPARTEMEN"));
		}
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->gambar->FldIsDetailKey) {
			$this->gambar->setFormValue($objForm->GetValue("x_gambar"));
		}
		if (!$this->NIK->FldIsDetailKey) {
			$this->NIK->setFormValue($objForm->GetValue("x_NIK"));
		}
		if (!$this->grup_ranap->FldIsDetailKey) {
			$this->grup_ranap->setFormValue($objForm->GetValue("x_grup_ranap"));
		}
		if (!$this->pd_nickname->FldIsDetailKey) {
			$this->pd_nickname->setFormValue($objForm->GetValue("x_pd_nickname"));
		}
		if (!$this->role_id->FldIsDetailKey) {
			$this->role_id->setFormValue($objForm->GetValue("x_role_id"));
		}
		if (!$this->pd_datejoined->FldIsDetailKey) {
			$this->pd_datejoined->setFormValue($objForm->GetValue("x_pd_datejoined"));
			$this->pd_datejoined->CurrentValue = ew_UnFormatDateTime($this->pd_datejoined->CurrentValue, 0);
		}
		if (!$this->pd_parentid->FldIsDetailKey) {
			$this->pd_parentid->setFormValue($objForm->GetValue("x_pd_parentid"));
		}
		if (!$this->pd_email->FldIsDetailKey) {
			$this->pd_email->setFormValue($objForm->GetValue("x_pd_email"));
		}
		if (!$this->pd_activated->FldIsDetailKey) {
			$this->pd_activated->setFormValue($objForm->GetValue("x_pd_activated"));
		}
		if (!$this->pd_profiletext->FldIsDetailKey) {
			$this->pd_profiletext->setFormValue($objForm->GetValue("x_pd_profiletext"));
		}
		if (!$this->pd_title->FldIsDetailKey) {
			$this->pd_title->setFormValue($objForm->GetValue("x_pd_title"));
		}
		if (!$this->pd_ipaddr->FldIsDetailKey) {
			$this->pd_ipaddr->setFormValue($objForm->GetValue("x_pd_ipaddr"));
		}
		if (!$this->pd_useragent->FldIsDetailKey) {
			$this->pd_useragent->setFormValue($objForm->GetValue("x_pd_useragent"));
		}
		if (!$this->pd_online->FldIsDetailKey) {
			$this->pd_online->setFormValue($objForm->GetValue("x_pd_online"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->PWD->CurrentValue = $this->PWD->FormValue;
		$this->SES_REG->CurrentValue = $this->SES_REG->FormValue;
		$this->ROLES->CurrentValue = $this->ROLES->FormValue;
		$this->KDUNIT->CurrentValue = $this->KDUNIT->FormValue;
		$this->DEPARTEMEN->CurrentValue = $this->DEPARTEMEN->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->gambar->CurrentValue = $this->gambar->FormValue;
		$this->NIK->CurrentValue = $this->NIK->FormValue;
		$this->grup_ranap->CurrentValue = $this->grup_ranap->FormValue;
		$this->pd_nickname->CurrentValue = $this->pd_nickname->FormValue;
		$this->role_id->CurrentValue = $this->role_id->FormValue;
		$this->pd_datejoined->CurrentValue = $this->pd_datejoined->FormValue;
		$this->pd_datejoined->CurrentValue = ew_UnFormatDateTime($this->pd_datejoined->CurrentValue, 0);
		$this->pd_parentid->CurrentValue = $this->pd_parentid->FormValue;
		$this->pd_email->CurrentValue = $this->pd_email->FormValue;
		$this->pd_activated->CurrentValue = $this->pd_activated->FormValue;
		$this->pd_profiletext->CurrentValue = $this->pd_profiletext->FormValue;
		$this->pd_title->CurrentValue = $this->pd_title->FormValue;
		$this->pd_ipaddr->CurrentValue = $this->pd_ipaddr->FormValue;
		$this->pd_useragent->CurrentValue = $this->pd_useragent->FormValue;
		$this->pd_online->CurrentValue = $this->pd_online->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('add');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("NIP")) <> "")
			$this->NIP->CurrentValue = $this->getKey("NIP"); // NIP
		else
			$bValidKey = FALSE;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = ew_HtmlEncode($this->NIP->CurrentValue);
			$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

			// PWD
			$this->PWD->EditAttrs["class"] = "form-control ewPasswordStrength";
			$this->PWD->EditCustomAttributes = "";
			$this->PWD->EditValue = ew_HtmlEncode($this->PWD->CurrentValue);
			$this->PWD->PlaceHolder = ew_RemoveHtml($this->PWD->FldCaption());

			// SES_REG
			$this->SES_REG->EditAttrs["class"] = "form-control";
			$this->SES_REG->EditCustomAttributes = "";
			$this->SES_REG->EditValue = ew_HtmlEncode($this->SES_REG->CurrentValue);
			$this->SES_REG->PlaceHolder = ew_RemoveHtml($this->SES_REG->FldCaption());

			// ROLES
			$this->ROLES->EditAttrs["class"] = "form-control";
			$this->ROLES->EditCustomAttributes = "";
			$this->ROLES->EditValue = ew_HtmlEncode($this->ROLES->CurrentValue);
			$this->ROLES->PlaceHolder = ew_RemoveHtml($this->ROLES->FldCaption());

			// KDUNIT
			$this->KDUNIT->EditAttrs["class"] = "form-control";
			$this->KDUNIT->EditCustomAttributes = "";
			$this->KDUNIT->EditValue = ew_HtmlEncode($this->KDUNIT->CurrentValue);
			$this->KDUNIT->PlaceHolder = ew_RemoveHtml($this->KDUNIT->FldCaption());

			// DEPARTEMEN
			$this->DEPARTEMEN->EditAttrs["class"] = "form-control";
			$this->DEPARTEMEN->EditCustomAttributes = "";
			$this->DEPARTEMEN->EditValue = ew_HtmlEncode($this->DEPARTEMEN->CurrentValue);
			$this->DEPARTEMEN->PlaceHolder = ew_RemoveHtml($this->DEPARTEMEN->FldCaption());

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// gambar
			$this->gambar->EditAttrs["class"] = "form-control";
			$this->gambar->EditCustomAttributes = "";
			$this->gambar->EditValue = ew_HtmlEncode($this->gambar->CurrentValue);
			$this->gambar->PlaceHolder = ew_RemoveHtml($this->gambar->FldCaption());

			// NIK
			$this->NIK->EditAttrs["class"] = "form-control";
			$this->NIK->EditCustomAttributes = "";
			$this->NIK->EditValue = ew_HtmlEncode($this->NIK->CurrentValue);
			$this->NIK->PlaceHolder = ew_RemoveHtml($this->NIK->FldCaption());

			// grup_ranap
			$this->grup_ranap->EditAttrs["class"] = "form-control";
			$this->grup_ranap->EditCustomAttributes = "";
			$this->grup_ranap->EditValue = ew_HtmlEncode($this->grup_ranap->CurrentValue);
			$this->grup_ranap->PlaceHolder = ew_RemoveHtml($this->grup_ranap->FldCaption());

			// pd_nickname
			$this->pd_nickname->EditAttrs["class"] = "form-control";
			$this->pd_nickname->EditCustomAttributes = "";
			$this->pd_nickname->EditValue = ew_HtmlEncode($this->pd_nickname->CurrentValue);
			$this->pd_nickname->PlaceHolder = ew_RemoveHtml($this->pd_nickname->FldCaption());

			// role_id
			$this->role_id->EditAttrs["class"] = "form-control";
			$this->role_id->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->role_id->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->role_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->role_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			$this->role_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->role_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->role_id->EditValue = $arwrk;
			}

			// pd_avatar
			$this->pd_avatar->EditAttrs["class"] = "form-control";
			$this->pd_avatar->EditCustomAttributes = "";
			if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
				$this->pd_avatar->ImageWidth = 50;
				$this->pd_avatar->ImageHeight = 50;
				$this->pd_avatar->ImageAlt = $this->pd_avatar->FldAlt();
				$this->pd_avatar->EditValue = $this->pd_avatar->Upload->DbValue;
			} else {
				$this->pd_avatar->EditValue = "";
			}
			if (!ew_Empty($this->pd_avatar->CurrentValue))
				$this->pd_avatar->Upload->FileName = $this->pd_avatar->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->pd_avatar);

			// pd_datejoined
			$this->pd_datejoined->EditAttrs["class"] = "form-control";
			$this->pd_datejoined->EditCustomAttributes = "";
			$this->pd_datejoined->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->pd_datejoined->CurrentValue, 8));
			$this->pd_datejoined->PlaceHolder = ew_RemoveHtml($this->pd_datejoined->FldCaption());

			// pd_parentid
			$this->pd_parentid->EditAttrs["class"] = "form-control";
			$this->pd_parentid->EditCustomAttributes = "";
			if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin
			} else {
			$this->pd_parentid->EditValue = ew_HtmlEncode($this->pd_parentid->CurrentValue);
			$this->pd_parentid->PlaceHolder = ew_RemoveHtml($this->pd_parentid->FldCaption());
			}

			// pd_email
			$this->pd_email->EditAttrs["class"] = "form-control";
			$this->pd_email->EditCustomAttributes = "";
			$this->pd_email->EditValue = ew_HtmlEncode($this->pd_email->CurrentValue);
			$this->pd_email->PlaceHolder = ew_RemoveHtml($this->pd_email->FldCaption());

			// pd_activated
			$this->pd_activated->EditAttrs["class"] = "form-control";
			$this->pd_activated->EditCustomAttributes = "";
			$this->pd_activated->EditValue = ew_HtmlEncode($this->pd_activated->CurrentValue);
			$this->pd_activated->PlaceHolder = ew_RemoveHtml($this->pd_activated->FldCaption());

			// pd_profiletext
			$this->pd_profiletext->EditAttrs["class"] = "form-control";
			$this->pd_profiletext->EditCustomAttributes = "";
			$this->pd_profiletext->EditValue = ew_HtmlEncode($this->pd_profiletext->CurrentValue);
			$this->pd_profiletext->PlaceHolder = ew_RemoveHtml($this->pd_profiletext->FldCaption());

			// pd_title
			$this->pd_title->EditAttrs["class"] = "form-control";
			$this->pd_title->EditCustomAttributes = "";
			$this->pd_title->EditValue = ew_HtmlEncode($this->pd_title->CurrentValue);
			$this->pd_title->PlaceHolder = ew_RemoveHtml($this->pd_title->FldCaption());

			// pd_ipaddr
			$this->pd_ipaddr->EditAttrs["class"] = "form-control";
			$this->pd_ipaddr->EditCustomAttributes = "";
			$this->pd_ipaddr->EditValue = ew_HtmlEncode($this->pd_ipaddr->CurrentValue);
			$this->pd_ipaddr->PlaceHolder = ew_RemoveHtml($this->pd_ipaddr->FldCaption());

			// pd_useragent
			$this->pd_useragent->EditAttrs["class"] = "form-control";
			$this->pd_useragent->EditCustomAttributes = "";
			$this->pd_useragent->EditValue = ew_HtmlEncode($this->pd_useragent->CurrentValue);
			$this->pd_useragent->PlaceHolder = ew_RemoveHtml($this->pd_useragent->FldCaption());

			// pd_online
			$this->pd_online->EditAttrs["class"] = "form-control";
			$this->pd_online->EditCustomAttributes = "";
			$this->pd_online->EditValue = ew_HtmlEncode($this->pd_online->CurrentValue);
			$this->pd_online->PlaceHolder = ew_RemoveHtml($this->pd_online->FldCaption());

			// Add refer script
			// NIP

			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";

			// PWD
			$this->PWD->LinkCustomAttributes = "";
			$this->PWD->HrefValue = "";

			// SES_REG
			$this->SES_REG->LinkCustomAttributes = "";
			$this->SES_REG->HrefValue = "";

			// ROLES
			$this->ROLES->LinkCustomAttributes = "";
			$this->ROLES->HrefValue = "";

			// KDUNIT
			$this->KDUNIT->LinkCustomAttributes = "";
			$this->KDUNIT->HrefValue = "";

			// DEPARTEMEN
			$this->DEPARTEMEN->LinkCustomAttributes = "";
			$this->DEPARTEMEN->HrefValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// gambar
			$this->gambar->LinkCustomAttributes = "";
			$this->gambar->HrefValue = "";

			// NIK
			$this->NIK->LinkCustomAttributes = "";
			$this->NIK->HrefValue = "";

			// grup_ranap
			$this->grup_ranap->LinkCustomAttributes = "";
			$this->grup_ranap->HrefValue = "";

			// pd_nickname
			$this->pd_nickname->LinkCustomAttributes = "";
			$this->pd_nickname->HrefValue = "";

			// role_id
			$this->role_id->LinkCustomAttributes = "";
			$this->role_id->HrefValue = "";

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

			// pd_datejoined
			$this->pd_datejoined->LinkCustomAttributes = "";
			$this->pd_datejoined->HrefValue = "";

			// pd_parentid
			$this->pd_parentid->LinkCustomAttributes = "";
			$this->pd_parentid->HrefValue = "";

			// pd_email
			$this->pd_email->LinkCustomAttributes = "";
			$this->pd_email->HrefValue = "";

			// pd_activated
			$this->pd_activated->LinkCustomAttributes = "";
			$this->pd_activated->HrefValue = "";

			// pd_profiletext
			$this->pd_profiletext->LinkCustomAttributes = "";
			$this->pd_profiletext->HrefValue = "";

			// pd_title
			$this->pd_title->LinkCustomAttributes = "";
			$this->pd_title->HrefValue = "";

			// pd_ipaddr
			$this->pd_ipaddr->LinkCustomAttributes = "";
			$this->pd_ipaddr->HrefValue = "";

			// pd_useragent
			$this->pd_useragent->LinkCustomAttributes = "";
			$this->pd_useragent->HrefValue = "";

			// pd_online
			$this->pd_online->LinkCustomAttributes = "";
			$this->pd_online->HrefValue = "";
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
		if (!$this->NIP->FldIsDetailKey && !is_null($this->NIP->FormValue) && $this->NIP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NIP->FldCaption(), $this->NIP->ReqErrMsg));
		}
		if (!$this->PWD->FldIsDetailKey && !is_null($this->PWD->FormValue) && $this->PWD->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PWD->FldCaption(), $this->PWD->ReqErrMsg));
		}
		if (!$this->SES_REG->FldIsDetailKey && !is_null($this->SES_REG->FormValue) && $this->SES_REG->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->SES_REG->FldCaption(), $this->SES_REG->ReqErrMsg));
		}
		if (!$this->ROLES->FldIsDetailKey && !is_null($this->ROLES->FormValue) && $this->ROLES->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ROLES->FldCaption(), $this->ROLES->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->ROLES->FormValue)) {
			ew_AddMessage($gsFormError, $this->ROLES->FldErrMsg());
		}
		if (!$this->KDUNIT->FldIsDetailKey && !is_null($this->KDUNIT->FormValue) && $this->KDUNIT->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KDUNIT->FldCaption(), $this->KDUNIT->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->KDUNIT->FormValue)) {
			ew_AddMessage($gsFormError, $this->KDUNIT->FldErrMsg());
		}
		if (!$this->nama->FldIsDetailKey && !is_null($this->nama->FormValue) && $this->nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama->FldCaption(), $this->nama->ReqErrMsg));
		}
		if (!$this->gambar->FldIsDetailKey && !is_null($this->gambar->FormValue) && $this->gambar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->gambar->FldCaption(), $this->gambar->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->grup_ranap->FormValue)) {
			ew_AddMessage($gsFormError, $this->grup_ranap->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->pd_datejoined->FormValue)) {
			ew_AddMessage($gsFormError, $this->pd_datejoined->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pd_parentid->FormValue)) {
			ew_AddMessage($gsFormError, $this->pd_parentid->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pd_activated->FormValue)) {
			ew_AddMessage($gsFormError, $this->pd_activated->FldErrMsg());
		}
		if (!ew_CheckInteger($this->pd_online->FormValue)) {
			ew_AddMessage($gsFormError, $this->pd_online->FldErrMsg());
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

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->id->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->id->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->id->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}

		// Check if valid parent user id
		$bValidParentUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->pd_parentid->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidParentUser = $Security->IsValidUserID($this->pd_parentid->CurrentValue);
			if (!$bValidParentUser) {
				$sParentUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedParentUserID"));
				$sParentUserIdMsg = str_replace("%p", $this->pd_parentid->CurrentValue, $sParentUserIdMsg);
				$this->setFailureMessage($sParentUserIdMsg);
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// NIP
		$this->NIP->SetDbValueDef($rsnew, $this->NIP->CurrentValue, "", FALSE);

		// PWD
		$this->PWD->SetDbValueDef($rsnew, $this->PWD->CurrentValue, "", FALSE);

		// SES_REG
		$this->SES_REG->SetDbValueDef($rsnew, $this->SES_REG->CurrentValue, "", FALSE);

		// ROLES
		$this->ROLES->SetDbValueDef($rsnew, $this->ROLES->CurrentValue, 0, FALSE);

		// KDUNIT
		$this->KDUNIT->SetDbValueDef($rsnew, $this->KDUNIT->CurrentValue, 0, FALSE);

		// DEPARTEMEN
		$this->DEPARTEMEN->SetDbValueDef($rsnew, $this->DEPARTEMEN->CurrentValue, NULL, FALSE);

		// nama
		$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, "", FALSE);

		// gambar
		$this->gambar->SetDbValueDef($rsnew, $this->gambar->CurrentValue, "", FALSE);

		// NIK
		$this->NIK->SetDbValueDef($rsnew, $this->NIK->CurrentValue, NULL, FALSE);

		// grup_ranap
		$this->grup_ranap->SetDbValueDef($rsnew, $this->grup_ranap->CurrentValue, NULL, FALSE);

		// pd_nickname
		$this->pd_nickname->SetDbValueDef($rsnew, $this->pd_nickname->CurrentValue, NULL, FALSE);

		// role_id
		if ($Security->CanAdmin()) { // System admin
		$this->role_id->SetDbValueDef($rsnew, $this->role_id->CurrentValue, NULL, FALSE);
		}

		// pd_avatar
		if ($this->pd_avatar->Visible && !$this->pd_avatar->Upload->KeepFile) {
			$this->pd_avatar->Upload->DbValue = ""; // No need to delete old file
			if ($this->pd_avatar->Upload->FileName == "") {
				$rsnew['pd_avatar'] = NULL;
			} else {
				$rsnew['pd_avatar'] = $this->pd_avatar->Upload->FileName;
			}
			$this->pd_avatar->ImageWidth = 300; // Resize width
			$this->pd_avatar->ImageHeight = 300; // Resize height
		}

		// pd_datejoined
		$this->pd_datejoined->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->pd_datejoined->CurrentValue, 0), NULL, FALSE);

		// pd_parentid
		$this->pd_parentid->SetDbValueDef($rsnew, $this->pd_parentid->CurrentValue, NULL, FALSE);

		// pd_email
		$this->pd_email->SetDbValueDef($rsnew, $this->pd_email->CurrentValue, NULL, FALSE);

		// pd_activated
		$this->pd_activated->SetDbValueDef($rsnew, $this->pd_activated->CurrentValue, NULL, FALSE);

		// pd_profiletext
		$this->pd_profiletext->SetDbValueDef($rsnew, $this->pd_profiletext->CurrentValue, NULL, FALSE);

		// pd_title
		$this->pd_title->SetDbValueDef($rsnew, $this->pd_title->CurrentValue, NULL, FALSE);

		// pd_ipaddr
		$this->pd_ipaddr->SetDbValueDef($rsnew, $this->pd_ipaddr->CurrentValue, NULL, FALSE);

		// pd_useragent
		$this->pd_useragent->SetDbValueDef($rsnew, $this->pd_useragent->CurrentValue, NULL, FALSE);

		// pd_online
		$this->pd_online->SetDbValueDef($rsnew, $this->pd_online->CurrentValue, NULL, FALSE);

		// id
		if ($this->pd_avatar->Visible && !$this->pd_avatar->Upload->KeepFile) {
			if (!ew_Empty($this->pd_avatar->Upload->Value)) {
				$rsnew['pd_avatar'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->pd_avatar->UploadPath), $rsnew['pd_avatar']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['NIP']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->pd_avatar->Visible && !$this->pd_avatar->Upload->KeepFile) {
					if (!ew_Empty($this->pd_avatar->Upload->Value)) {
						$this->pd_avatar->Upload->Resize($this->pd_avatar->ImageWidth, $this->pd_avatar->ImageHeight);
						if (!$this->pd_avatar->Upload->SaveToFile($this->pd_avatar->UploadPath, $rsnew['pd_avatar'], TRUE)) {
							$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
							return FALSE;
						}
					}
				}
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

		// pd_avatar
		ew_CleanUploadTempPath($this->pd_avatar, $this->pd_avatar->Upload->Index);
		return $AddRow;
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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_role_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			$this->role_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`userlevelid` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->role_id, $sWhereWrk); // Call Lookup selecting
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
if (!isset($m_login_add)) $m_login_add = new cm_login_add();

// Page init
$m_login_add->Page_Init();

// Page main
$m_login_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_login_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fm_loginadd = new ew_Form("fm_loginadd", "add");

// Validate form
fm_loginadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_NIP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->NIP->FldCaption(), $m_login->NIP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PWD");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->PWD->FldCaption(), $m_login->PWD->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_PWD");
			if (elm && $(elm).hasClass("ewPasswordStrength") && !$(elm).data("validated"))
				return this.OnError(elm, ewLanguage.Phrase("PasswordTooSimple"));
			elm = this.GetElements("x" + infix + "_SES_REG");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->SES_REG->FldCaption(), $m_login->SES_REG->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ROLES");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->ROLES->FldCaption(), $m_login->ROLES->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ROLES");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_login->ROLES->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_KDUNIT");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->KDUNIT->FldCaption(), $m_login->KDUNIT->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_KDUNIT");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_login->KDUNIT->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->nama->FldCaption(), $m_login->nama->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_gambar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->gambar->FldCaption(), $m_login->gambar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_grup_ranap");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_login->grup_ranap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pd_datejoined");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_login->pd_datejoined->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pd_parentid");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_login->pd_parentid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pd_activated");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_login->pd_activated->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pd_online");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($m_login->pd_online->FldErrMsg()) ?>");

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
fm_loginadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_loginadd.ValidateRequired = true;
<?php } else { ?>
fm_loginadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_loginadd.Lists["x_role_id"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_login_add->IsModal) { ?>
<?php } ?>
<?php $m_login_add->ShowPageHeader(); ?>
<?php
$m_login_add->ShowMessage();
?>
<form name="fm_loginadd" id="fm_loginadd" class="<?php echo $m_login_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_login_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_login_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_login">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($m_login_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div>
<?php if ($m_login->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_m_login_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><?php echo $m_login->NIP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->NIP->CellAttributes() ?>>
<span id="el_m_login_NIP">
<input type="text" data-table="m_login" data-field="x_NIP" name="x_NIP" id="x_NIP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($m_login->NIP->getPlaceHolder()) ?>" value="<?php echo $m_login->NIP->EditValue ?>"<?php echo $m_login->NIP->EditAttributes() ?>>
</span>
<?php echo $m_login->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->PWD->Visible) { // PWD ?>
	<div id="r_PWD" class="form-group">
		<label id="elh_m_login_PWD" for="x_PWD" class="col-sm-2 control-label ewLabel"><?php echo $m_login->PWD->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->PWD->CellAttributes() ?>>
<span id="el_m_login_PWD">
<div class="input-group" id="ig_PWD">
<input type="text" data-password-strength="pst_PWD" data-password-generated="pgt_PWD" data-table="m_login" data-field="x_PWD" name="x_PWD" id="x_PWD" value="<?php echo $m_login->PWD->EditValue ?>" size="30" maxlength="32" placeholder="<?php echo ew_HtmlEncode($m_login->PWD->getPlaceHolder()) ?>"<?php echo $m_login->PWD->EditAttributes() ?>>
<span class="input-group-btn">
	<button type="button" class="btn btn-default ewPasswordGenerator" title="<?php echo ew_HtmlTitle($Language->Phrase("GeneratePassword")) ?>" data-password-field="x_PWD" data-password-confirm="c_PWD" data-password-strength="pst_PWD" data-password-generated="pgt_PWD"><?php echo $Language->Phrase("GeneratePassword") ?></button>
</span>
</div>
<span class="help-block" id="pgt_PWD" style="display: none;"></span>
<div class="progress ewPasswordStrengthBar" id="pst_PWD" style="display: none;">
	<div class="progress-bar" role="progressbar"></div>
</div>
</span>
<?php echo $m_login->PWD->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->SES_REG->Visible) { // SES_REG ?>
	<div id="r_SES_REG" class="form-group">
		<label id="elh_m_login_SES_REG" for="x_SES_REG" class="col-sm-2 control-label ewLabel"><?php echo $m_login->SES_REG->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->SES_REG->CellAttributes() ?>>
<span id="el_m_login_SES_REG">
<input type="text" data-table="m_login" data-field="x_SES_REG" name="x_SES_REG" id="x_SES_REG" size="30" maxlength="32" placeholder="<?php echo ew_HtmlEncode($m_login->SES_REG->getPlaceHolder()) ?>" value="<?php echo $m_login->SES_REG->EditValue ?>"<?php echo $m_login->SES_REG->EditAttributes() ?>>
</span>
<?php echo $m_login->SES_REG->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->ROLES->Visible) { // ROLES ?>
	<div id="r_ROLES" class="form-group">
		<label id="elh_m_login_ROLES" for="x_ROLES" class="col-sm-2 control-label ewLabel"><?php echo $m_login->ROLES->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->ROLES->CellAttributes() ?>>
<span id="el_m_login_ROLES">
<input type="text" data-table="m_login" data-field="x_ROLES" name="x_ROLES" id="x_ROLES" size="30" placeholder="<?php echo ew_HtmlEncode($m_login->ROLES->getPlaceHolder()) ?>" value="<?php echo $m_login->ROLES->EditValue ?>"<?php echo $m_login->ROLES->EditAttributes() ?>>
</span>
<?php echo $m_login->ROLES->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->KDUNIT->Visible) { // KDUNIT ?>
	<div id="r_KDUNIT" class="form-group">
		<label id="elh_m_login_KDUNIT" for="x_KDUNIT" class="col-sm-2 control-label ewLabel"><?php echo $m_login->KDUNIT->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->KDUNIT->CellAttributes() ?>>
<span id="el_m_login_KDUNIT">
<input type="text" data-table="m_login" data-field="x_KDUNIT" name="x_KDUNIT" id="x_KDUNIT" size="30" placeholder="<?php echo ew_HtmlEncode($m_login->KDUNIT->getPlaceHolder()) ?>" value="<?php echo $m_login->KDUNIT->EditValue ?>"<?php echo $m_login->KDUNIT->EditAttributes() ?>>
</span>
<?php echo $m_login->KDUNIT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->DEPARTEMEN->Visible) { // DEPARTEMEN ?>
	<div id="r_DEPARTEMEN" class="form-group">
		<label id="elh_m_login_DEPARTEMEN" for="x_DEPARTEMEN" class="col-sm-2 control-label ewLabel"><?php echo $m_login->DEPARTEMEN->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->DEPARTEMEN->CellAttributes() ?>>
<span id="el_m_login_DEPARTEMEN">
<input type="text" data-table="m_login" data-field="x_DEPARTEMEN" name="x_DEPARTEMEN" id="x_DEPARTEMEN" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($m_login->DEPARTEMEN->getPlaceHolder()) ?>" value="<?php echo $m_login->DEPARTEMEN->EditValue ?>"<?php echo $m_login->DEPARTEMEN->EditAttributes() ?>>
</span>
<?php echo $m_login->DEPARTEMEN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->nama->Visible) { // nama ?>
	<div id="r_nama" class="form-group">
		<label id="elh_m_login_nama" for="x_nama" class="col-sm-2 control-label ewLabel"><?php echo $m_login->nama->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->nama->CellAttributes() ?>>
<span id="el_m_login_nama">
<input type="text" data-table="m_login" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($m_login->nama->getPlaceHolder()) ?>" value="<?php echo $m_login->nama->EditValue ?>"<?php echo $m_login->nama->EditAttributes() ?>>
</span>
<?php echo $m_login->nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->gambar->Visible) { // gambar ?>
	<div id="r_gambar" class="form-group">
		<label id="elh_m_login_gambar" for="x_gambar" class="col-sm-2 control-label ewLabel"><?php echo $m_login->gambar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->gambar->CellAttributes() ?>>
<span id="el_m_login_gambar">
<input type="text" data-table="m_login" data-field="x_gambar" name="x_gambar" id="x_gambar" size="30" maxlength="80" placeholder="<?php echo ew_HtmlEncode($m_login->gambar->getPlaceHolder()) ?>" value="<?php echo $m_login->gambar->EditValue ?>"<?php echo $m_login->gambar->EditAttributes() ?>>
</span>
<?php echo $m_login->gambar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->NIK->Visible) { // NIK ?>
	<div id="r_NIK" class="form-group">
		<label id="elh_m_login_NIK" for="x_NIK" class="col-sm-2 control-label ewLabel"><?php echo $m_login->NIK->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->NIK->CellAttributes() ?>>
<span id="el_m_login_NIK">
<input type="text" data-table="m_login" data-field="x_NIK" name="x_NIK" id="x_NIK" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_login->NIK->getPlaceHolder()) ?>" value="<?php echo $m_login->NIK->EditValue ?>"<?php echo $m_login->NIK->EditAttributes() ?>>
</span>
<?php echo $m_login->NIK->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->grup_ranap->Visible) { // grup_ranap ?>
	<div id="r_grup_ranap" class="form-group">
		<label id="elh_m_login_grup_ranap" for="x_grup_ranap" class="col-sm-2 control-label ewLabel"><?php echo $m_login->grup_ranap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->grup_ranap->CellAttributes() ?>>
<span id="el_m_login_grup_ranap">
<input type="text" data-table="m_login" data-field="x_grup_ranap" name="x_grup_ranap" id="x_grup_ranap" size="30" placeholder="<?php echo ew_HtmlEncode($m_login->grup_ranap->getPlaceHolder()) ?>" value="<?php echo $m_login->grup_ranap->EditValue ?>"<?php echo $m_login->grup_ranap->EditAttributes() ?>>
</span>
<?php echo $m_login->grup_ranap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_nickname->Visible) { // pd_nickname ?>
	<div id="r_pd_nickname" class="form-group">
		<label id="elh_m_login_pd_nickname" for="x_pd_nickname" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_nickname->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_nickname->CellAttributes() ?>>
<span id="el_m_login_pd_nickname">
<input type="text" data-table="m_login" data-field="x_pd_nickname" name="x_pd_nickname" id="x_pd_nickname" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($m_login->pd_nickname->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_nickname->EditValue ?>"<?php echo $m_login->pd_nickname->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_nickname->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->role_id->Visible) { // role_id ?>
	<div id="r_role_id" class="form-group">
		<label id="elh_m_login_role_id" for="x_role_id" class="col-sm-2 control-label ewLabel"><?php echo $m_login->role_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->role_id->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_m_login_role_id">
<p class="form-control-static"><?php echo $m_login->role_id->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_m_login_role_id">
<select data-table="m_login" data-field="x_role_id" data-value-separator="<?php echo $m_login->role_id->DisplayValueSeparatorAttribute() ?>" id="x_role_id" name="x_role_id"<?php echo $m_login->role_id->EditAttributes() ?>>
<?php echo $m_login->role_id->SelectOptionListHtml("x_role_id") ?>
</select>
<input type="hidden" name="s_x_role_id" id="s_x_role_id" value="<?php echo $m_login->role_id->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $m_login->role_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_avatar->Visible) { // pd_avatar ?>
	<div id="r_pd_avatar" class="form-group">
		<label id="elh_m_login_pd_avatar" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_avatar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_avatar->CellAttributes() ?>>
<span id="el_m_login_pd_avatar">
<div id="fd_x_pd_avatar">
<span title="<?php echo $m_login->pd_avatar->FldTitle() ? $m_login->pd_avatar->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($m_login->pd_avatar->ReadOnly || $m_login->pd_avatar->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="m_login" data-field="x_pd_avatar" name="x_pd_avatar" id="x_pd_avatar"<?php echo $m_login->pd_avatar->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_pd_avatar" id= "fn_x_pd_avatar" value="<?php echo $m_login->pd_avatar->Upload->FileName ?>">
<input type="hidden" name="fa_x_pd_avatar" id= "fa_x_pd_avatar" value="0">
<input type="hidden" name="fs_x_pd_avatar" id= "fs_x_pd_avatar" value="255">
<input type="hidden" name="fx_x_pd_avatar" id= "fx_x_pd_avatar" value="<?php echo $m_login->pd_avatar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_pd_avatar" id= "fm_x_pd_avatar" value="<?php echo $m_login->pd_avatar->UploadMaxFileSize ?>">
</div>
<table id="ft_x_pd_avatar" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $m_login->pd_avatar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_datejoined->Visible) { // pd_datejoined ?>
	<div id="r_pd_datejoined" class="form-group">
		<label id="elh_m_login_pd_datejoined" for="x_pd_datejoined" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_datejoined->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_datejoined->CellAttributes() ?>>
<span id="el_m_login_pd_datejoined">
<input type="text" data-table="m_login" data-field="x_pd_datejoined" name="x_pd_datejoined" id="x_pd_datejoined" placeholder="<?php echo ew_HtmlEncode($m_login->pd_datejoined->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_datejoined->EditValue ?>"<?php echo $m_login->pd_datejoined->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_datejoined->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_parentid->Visible) { // pd_parentid ?>
	<div id="r_pd_parentid" class="form-group">
		<label id="elh_m_login_pd_parentid" for="x_pd_parentid" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_parentid->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_parentid->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_m_login_pd_parentid">
<select data-table="m_login" data-field="x_pd_parentid" data-value-separator="<?php echo $m_login->pd_parentid->DisplayValueSeparatorAttribute() ?>" id="x_pd_parentid" name="x_pd_parentid"<?php echo $m_login->pd_parentid->EditAttributes() ?>>
<?php echo $m_login->pd_parentid->SelectOptionListHtml("x_pd_parentid") ?>
</select>
</span>
<?php } else { ?>
<span id="el_m_login_pd_parentid">
<input type="text" data-table="m_login" data-field="x_pd_parentid" name="x_pd_parentid" id="x_pd_parentid" size="30" placeholder="<?php echo ew_HtmlEncode($m_login->pd_parentid->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_parentid->EditValue ?>"<?php echo $m_login->pd_parentid->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $m_login->pd_parentid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_email->Visible) { // pd_email ?>
	<div id="r_pd_email" class="form-group">
		<label id="elh_m_login_pd_email" for="x_pd_email" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_email->CellAttributes() ?>>
<span id="el_m_login_pd_email">
<input type="text" data-table="m_login" data-field="x_pd_email" name="x_pd_email" id="x_pd_email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($m_login->pd_email->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_email->EditValue ?>"<?php echo $m_login->pd_email->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_activated->Visible) { // pd_activated ?>
	<div id="r_pd_activated" class="form-group">
		<label id="elh_m_login_pd_activated" for="x_pd_activated" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_activated->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_activated->CellAttributes() ?>>
<span id="el_m_login_pd_activated">
<input type="text" data-table="m_login" data-field="x_pd_activated" name="x_pd_activated" id="x_pd_activated" size="30" placeholder="<?php echo ew_HtmlEncode($m_login->pd_activated->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_activated->EditValue ?>"<?php echo $m_login->pd_activated->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_activated->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_profiletext->Visible) { // pd_profiletext ?>
	<div id="r_pd_profiletext" class="form-group">
		<label id="elh_m_login_pd_profiletext" for="x_pd_profiletext" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_profiletext->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_profiletext->CellAttributes() ?>>
<span id="el_m_login_pd_profiletext">
<textarea data-table="m_login" data-field="x_pd_profiletext" name="x_pd_profiletext" id="x_pd_profiletext" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($m_login->pd_profiletext->getPlaceHolder()) ?>"<?php echo $m_login->pd_profiletext->EditAttributes() ?>><?php echo $m_login->pd_profiletext->EditValue ?></textarea>
</span>
<?php echo $m_login->pd_profiletext->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_title->Visible) { // pd_title ?>
	<div id="r_pd_title" class="form-group">
		<label id="elh_m_login_pd_title" for="x_pd_title" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_title->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_title->CellAttributes() ?>>
<span id="el_m_login_pd_title">
<input type="text" data-table="m_login" data-field="x_pd_title" name="x_pd_title" id="x_pd_title" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($m_login->pd_title->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_title->EditValue ?>"<?php echo $m_login->pd_title->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_ipaddr->Visible) { // pd_ipaddr ?>
	<div id="r_pd_ipaddr" class="form-group">
		<label id="elh_m_login_pd_ipaddr" for="x_pd_ipaddr" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_ipaddr->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_ipaddr->CellAttributes() ?>>
<span id="el_m_login_pd_ipaddr">
<input type="text" data-table="m_login" data-field="x_pd_ipaddr" name="x_pd_ipaddr" id="x_pd_ipaddr" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($m_login->pd_ipaddr->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_ipaddr->EditValue ?>"<?php echo $m_login->pd_ipaddr->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_ipaddr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_useragent->Visible) { // pd_useragent ?>
	<div id="r_pd_useragent" class="form-group">
		<label id="elh_m_login_pd_useragent" for="x_pd_useragent" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_useragent->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_useragent->CellAttributes() ?>>
<span id="el_m_login_pd_useragent">
<input type="text" data-table="m_login" data-field="x_pd_useragent" name="x_pd_useragent" id="x_pd_useragent" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($m_login->pd_useragent->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_useragent->EditValue ?>"<?php echo $m_login->pd_useragent->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_useragent->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->pd_online->Visible) { // pd_online ?>
	<div id="r_pd_online" class="form-group">
		<label id="elh_m_login_pd_online" for="x_pd_online" class="col-sm-2 control-label ewLabel"><?php echo $m_login->pd_online->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->pd_online->CellAttributes() ?>>
<span id="el_m_login_pd_online">
<input type="text" data-table="m_login" data-field="x_pd_online" name="x_pd_online" id="x_pd_online" size="30" placeholder="<?php echo ew_HtmlEncode($m_login->pd_online->getPlaceHolder()) ?>" value="<?php echo $m_login->pd_online->EditValue ?>"<?php echo $m_login->pd_online->EditAttributes() ?>>
</span>
<?php echo $m_login->pd_online->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_login_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_login_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_loginadd.Init();
</script>
<?php
$m_login_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_login_add->Page_Terminate();
?>
