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

$m_login_edit = NULL; // Initialize page object first

class cm_login_edit extends cm_login {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_login';

	// Page object name
	var $PageObjName = 'm_login_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->nama->SetVisibility();
		$this->NIK->SetVisibility();
		$this->pd_nickname->SetVisibility();
		$this->pd_avatar->SetVisibility();
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

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

		// Load key from QueryString
		if (@$_GET["NIP"] <> "") {
			$this->NIP->setQueryStringValue($_GET["NIP"]);
		}
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->NIP->CurrentValue == "") {
			$this->Page_Terminate("m_loginlist.php"); // Invalid key, return to list
		}
		if ($this->id->CurrentValue == "") {
			$this->Page_Terminate("m_loginlist.php"); // Invalid key, return to list
		}

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("m_loginlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "m_loginlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->pd_avatar->Upload->Index = $objForm->Index;
		$this->pd_avatar->Upload->UploadFile();
		$this->pd_avatar->CurrentValue = $this->pd_avatar->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->nama->FldIsDetailKey) {
			$this->nama->setFormValue($objForm->GetValue("x_nama"));
		}
		if (!$this->NIK->FldIsDetailKey) {
			$this->NIK->setFormValue($objForm->GetValue("x_NIK"));
		}
		if (!$this->pd_nickname->FldIsDetailKey) {
			$this->pd_nickname->setFormValue($objForm->GetValue("x_pd_nickname"));
		}
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->nama->CurrentValue = $this->nama->FormValue;
		$this->NIK->CurrentValue = $this->NIK->FormValue;
		$this->pd_nickname->CurrentValue = $this->pd_nickname->FormValue;
		$this->id->CurrentValue = $this->id->FormValue;
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
			$res = $this->ShowOptionLink('edit');
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

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";
			$this->nama->TooltipValue = "";

			// NIK
			$this->NIK->LinkCustomAttributes = "";
			$this->NIK->HrefValue = "";
			$this->NIK->TooltipValue = "";

			// pd_nickname
			$this->pd_nickname->LinkCustomAttributes = "";
			$this->pd_nickname->HrefValue = "";
			$this->pd_nickname->TooltipValue = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = $this->NIP->CurrentValue;
			$this->NIP->ViewCustomAttributes = "";

			// nama
			$this->nama->EditAttrs["class"] = "form-control";
			$this->nama->EditCustomAttributes = "";
			$this->nama->EditValue = ew_HtmlEncode($this->nama->CurrentValue);
			$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

			// NIK
			$this->NIK->EditAttrs["class"] = "form-control";
			$this->NIK->EditCustomAttributes = "";
			$this->NIK->EditValue = ew_HtmlEncode($this->NIK->CurrentValue);
			$this->NIK->PlaceHolder = ew_RemoveHtml($this->NIK->FldCaption());

			// pd_nickname
			$this->pd_nickname->EditAttrs["class"] = "form-control";
			$this->pd_nickname->EditCustomAttributes = "";
			$this->pd_nickname->EditValue = ew_HtmlEncode($this->pd_nickname->CurrentValue);
			$this->pd_nickname->PlaceHolder = ew_RemoveHtml($this->pd_nickname->FldCaption());

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
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->pd_avatar);

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// Edit refer script
			// NIP

			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// nama
			$this->nama->LinkCustomAttributes = "";
			$this->nama->HrefValue = "";

			// NIK
			$this->NIK->LinkCustomAttributes = "";
			$this->NIK->HrefValue = "";

			// pd_nickname
			$this->pd_nickname->LinkCustomAttributes = "";
			$this->pd_nickname->HrefValue = "";

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
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
		if (!$this->nama->FldIsDetailKey && !is_null($this->nama->FormValue) && $this->nama->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nama->FldCaption(), $this->nama->ReqErrMsg));
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nama
			$this->nama->SetDbValueDef($rsnew, $this->nama->CurrentValue, "", $this->nama->ReadOnly);

			// NIK
			$this->NIK->SetDbValueDef($rsnew, $this->NIK->CurrentValue, NULL, $this->NIK->ReadOnly);

			// pd_nickname
			$this->pd_nickname->SetDbValueDef($rsnew, $this->pd_nickname->CurrentValue, NULL, $this->pd_nickname->ReadOnly);

			// pd_avatar
			if ($this->pd_avatar->Visible && !$this->pd_avatar->ReadOnly && !$this->pd_avatar->Upload->KeepFile) {
				$this->pd_avatar->Upload->DbValue = $rsold['pd_avatar']; // Get original value
				if ($this->pd_avatar->Upload->FileName == "") {
					$rsnew['pd_avatar'] = NULL;
				} else {
					$rsnew['pd_avatar'] = $this->pd_avatar->Upload->FileName;
				}
				$this->pd_avatar->ImageWidth = 300; // Resize width
				$this->pd_avatar->ImageHeight = 300; // Resize height
			}
			if ($this->pd_avatar->Visible && !$this->pd_avatar->Upload->KeepFile) {
				if (!ew_Empty($this->pd_avatar->Upload->Value)) {
					$rsnew['pd_avatar'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->pd_avatar->UploadPath), $rsnew['pd_avatar']); // Get new file name
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
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
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// pd_avatar
		ew_CleanUploadTempPath($this->pd_avatar, $this->pd_avatar->Upload->Index);
		return $EditRow;
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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($m_login_edit)) $m_login_edit = new cm_login_edit();

// Page init
$m_login_edit->Page_Init();

// Page main
$m_login_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_login_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fm_loginedit = new ew_Form("fm_loginedit", "edit");

// Validate form
fm_loginedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nama");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $m_login->nama->FldCaption(), $m_login->nama->ReqErrMsg)) ?>");

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
fm_loginedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_loginedit.ValidateRequired = true;
<?php } else { ?>
fm_loginedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_login_edit->IsModal) { ?>
<?php } ?>
<?php $m_login_edit->ShowPageHeader(); ?>
<?php
$m_login_edit->ShowMessage();
?>
<form name="fm_loginedit" id="fm_loginedit" class="<?php echo $m_login_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_login_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_login_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_login">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($m_login_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_login->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_m_login_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><?php echo $m_login->NIP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->NIP->CellAttributes() ?>>
<span id="el_m_login_NIP">
<span<?php echo $m_login->NIP->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_login->NIP->EditValue ?></p></span>
</span>
<input type="hidden" data-table="m_login" data-field="x_NIP" name="x_NIP" id="x_NIP" value="<?php echo ew_HtmlEncode($m_login->NIP->CurrentValue) ?>">
<?php echo $m_login->NIP->CustomMsg ?></div></div>
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
<?php if (@$_POST["fa_x_pd_avatar"] == "0") { ?>
<input type="hidden" name="fa_x_pd_avatar" id= "fa_x_pd_avatar" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_pd_avatar" id= "fa_x_pd_avatar" value="1">
<?php } ?>
<input type="hidden" name="fs_x_pd_avatar" id= "fs_x_pd_avatar" value="255">
<input type="hidden" name="fx_x_pd_avatar" id= "fx_x_pd_avatar" value="<?php echo $m_login->pd_avatar->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_pd_avatar" id= "fm_x_pd_avatar" value="<?php echo $m_login->pd_avatar->UploadMaxFileSize ?>">
</div>
<table id="ft_x_pd_avatar" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $m_login->pd_avatar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($m_login->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_m_login_id" class="col-sm-2 control-label ewLabel"><?php echo $m_login->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $m_login->id->CellAttributes() ?>>
<span id="el_m_login_id">
<span<?php echo $m_login->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $m_login->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="m_login" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($m_login->id->CurrentValue) ?>">
<?php echo $m_login->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_login_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_login_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_loginedit.Init();
</script>
<?php
$m_login_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_login_edit->Page_Terminate();
?>
