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

$m_login_delete = NULL; // Initialize page object first

class cm_login_delete extends cm_login {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_login';

	// Page object name
	var $PageObjName = 'm_login_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
		$this->DEPARTEMEN->SetVisibility();
		$this->pd_nickname->SetVisibility();
		$this->pd_avatar->SetVisibility();

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
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("m_loginlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in m_login class, m_logininfo.php

		$this->CurrentFilter = $sFilter;

		// Check if valid user id
		$conn = &$this->Connection();
		$sql = $this->GetSQL($this->CurrentFilter, "");
		if ($this->Recordset = ew_LoadRecordset($sql, $conn)) {
			$res = TRUE;
			while (!$this->Recordset->EOF) {
				$this->LoadRowValues($this->Recordset);
				if (!$this->ShowOptionLink('delete')) {
					$sUserIdMsg = $Language->Phrase("NoDeletePermission");
					$this->setFailureMessage($sUserIdMsg);
					$res = FALSE;
					break;
				}
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
			if (!$res) $this->Page_Terminate("m_loginlist.php"); // Return to list
		}

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("m_loginlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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

			// DEPARTEMEN
			$this->DEPARTEMEN->LinkCustomAttributes = "";
			$this->DEPARTEMEN->HrefValue = "";
			$this->DEPARTEMEN->TooltipValue = "";

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['NIP'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
			$conn->RollbackTrans(); // Rollback changes
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteRollback")); // Batch delete rollback
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($m_login_delete)) $m_login_delete = new cm_login_delete();

// Page init
$m_login_delete->Page_Init();

// Page main
$m_login_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_login_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fm_logindelete = new ew_Form("fm_logindelete", "delete");

// Form_CustomValidate event
fm_logindelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_logindelete.ValidateRequired = true;
<?php } else { ?>
fm_logindelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $m_login_delete->ShowPageHeader(); ?>
<?php
$m_login_delete->ShowMessage();
?>
<form name="fm_logindelete" id="fm_logindelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_login_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_login_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_login">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($m_login_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_login->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($m_login->NIP->Visible) { // NIP ?>
		<th><span id="elh_m_login_NIP" class="m_login_NIP"><?php echo $m_login->NIP->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_login->DEPARTEMEN->Visible) { // DEPARTEMEN ?>
		<th><span id="elh_m_login_DEPARTEMEN" class="m_login_DEPARTEMEN"><?php echo $m_login->DEPARTEMEN->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_login->pd_nickname->Visible) { // pd_nickname ?>
		<th><span id="elh_m_login_pd_nickname" class="m_login_pd_nickname"><?php echo $m_login->pd_nickname->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_login->pd_avatar->Visible) { // pd_avatar ?>
		<th><span id="elh_m_login_pd_avatar" class="m_login_pd_avatar"><?php echo $m_login->pd_avatar->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$m_login_delete->RecCnt = 0;
$i = 0;
while (!$m_login_delete->Recordset->EOF) {
	$m_login_delete->RecCnt++;
	$m_login_delete->RowCnt++;

	// Set row properties
	$m_login->ResetAttrs();
	$m_login->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$m_login_delete->LoadRowValues($m_login_delete->Recordset);

	// Render row
	$m_login_delete->RenderRow();
?>
	<tr<?php echo $m_login->RowAttributes() ?>>
<?php if ($m_login->NIP->Visible) { // NIP ?>
		<td<?php echo $m_login->NIP->CellAttributes() ?>>
<span id="el<?php echo $m_login_delete->RowCnt ?>_m_login_NIP" class="m_login_NIP">
<span<?php echo $m_login->NIP->ViewAttributes() ?>>
<?php echo $m_login->NIP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_login->DEPARTEMEN->Visible) { // DEPARTEMEN ?>
		<td<?php echo $m_login->DEPARTEMEN->CellAttributes() ?>>
<span id="el<?php echo $m_login_delete->RowCnt ?>_m_login_DEPARTEMEN" class="m_login_DEPARTEMEN">
<span<?php echo $m_login->DEPARTEMEN->ViewAttributes() ?>>
<?php echo $m_login->DEPARTEMEN->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_login->pd_nickname->Visible) { // pd_nickname ?>
		<td<?php echo $m_login->pd_nickname->CellAttributes() ?>>
<span id="el<?php echo $m_login_delete->RowCnt ?>_m_login_pd_nickname" class="m_login_pd_nickname">
<span<?php echo $m_login->pd_nickname->ViewAttributes() ?>>
<?php echo $m_login->pd_nickname->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_login->pd_avatar->Visible) { // pd_avatar ?>
		<td<?php echo $m_login->pd_avatar->CellAttributes() ?>>
<span id="el<?php echo $m_login_delete->RowCnt ?>_m_login_pd_avatar" class="m_login_pd_avatar">
<span>
<?php echo ew_GetFileViewTag($m_login->pd_avatar, $m_login->pd_avatar->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$m_login_delete->Recordset->MoveNext();
}
$m_login_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_login_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fm_logindelete.Init();
</script>
<?php
$m_login_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_login_delete->Page_Terminate();
?>
