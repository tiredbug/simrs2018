<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_bill_ranapinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_bill_ranap_detail_visitekonsul_doktergridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_konsul_doktergridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tmnogridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_perawatgridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_visite_gizigridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_visite_farmasigridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_penunjanggridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_konsul_vctgridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_pelayanan_losgridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_laingridcls.php" ?>
<?php include_once "vw_bill_ranap_detail_tindakan_kebidanangridcls.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_bill_ranap_edit = NULL; // Initialize page object first

class cvw_bill_ranap_edit extends cvw_bill_ranap {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bill_ranap';

	// Page object name
	var $PageObjName = 'vw_bill_ranap_edit';

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

		// Table object (vw_bill_ranap)
		if (!isset($GLOBALS["vw_bill_ranap"]) || get_class($GLOBALS["vw_bill_ranap"]) == "cvw_bill_ranap") {
			$GLOBALS["vw_bill_ranap"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_bill_ranap"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_bill_ranap', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_bill_ranaplist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->nomr->SetVisibility();
		$this->statusbayar->SetVisibility();
		$this->kirimdari->SetVisibility();
		$this->masukrs->SetVisibility();
		$this->noruang->SetVisibility();
		$this->tempat_tidur_id->SetVisibility();
		$this->KELASPERAWATAN_ID->SetVisibility();
		$this->nott->SetVisibility();

		// Set up detail page object
		$this->SetupDetailPages();

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

			// Process auto fill for detail table 'vw_bill_ranap_detail_visitekonsul_dokter'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_visitekonsul_doktergrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid;
				$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_konsul_dokter'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_konsul_doktergrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid;
				$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tmno'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tmnogrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"])) $GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid;
				$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_perawat'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_perawatgrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_visite_gizi'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_visite_gizigrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid;
				$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_visite_farmasi'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_visite_farmasigrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid;
				$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_penunjang'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_penunjanggrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_konsul_vct'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_konsul_vctgrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid;
				$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_pelayanan_los'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_pelayanan_losgrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"])) $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid;
				$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_lain'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_laingrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'vw_bill_ranap_detail_tindakan_kebidanan'
			if (@$_POST["grid"] == "fvw_bill_ranap_detail_tindakan_kebidanangrid") {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"] = new cvw_bill_ranap_detail_tindakan_kebidanan_grid;
				$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $vw_bill_ranap;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_bill_ranap);
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
	var $DetailPages; // Detail pages object

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
		if (@$_GET["id_admission"] <> "") {
			$this->id_admission->setQueryStringValue($_GET["id_admission"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id_admission->CurrentValue == "") {
			$this->Page_Terminate("vw_bill_ranaplist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_bill_ranaplist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_bill_ranaplist.php")
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

					// Set up detail parameters
					$this->SetUpDetailParms();
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
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nomr->FldIsDetailKey) {
			$this->nomr->setFormValue($objForm->GetValue("x_nomr"));
		}
		if (!$this->statusbayar->FldIsDetailKey) {
			$this->statusbayar->setFormValue($objForm->GetValue("x_statusbayar"));
		}
		if (!$this->kirimdari->FldIsDetailKey) {
			$this->kirimdari->setFormValue($objForm->GetValue("x_kirimdari"));
		}
		if (!$this->masukrs->FldIsDetailKey) {
			$this->masukrs->setFormValue($objForm->GetValue("x_masukrs"));
			$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 11);
		}
		if (!$this->noruang->FldIsDetailKey) {
			$this->noruang->setFormValue($objForm->GetValue("x_noruang"));
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey) {
			$this->tempat_tidur_id->setFormValue($objForm->GetValue("x_tempat_tidur_id"));
		}
		if (!$this->KELASPERAWATAN_ID->FldIsDetailKey) {
			$this->KELASPERAWATAN_ID->setFormValue($objForm->GetValue("x_KELASPERAWATAN_ID"));
		}
		if (!$this->nott->FldIsDetailKey) {
			$this->nott->setFormValue($objForm->GetValue("x_nott"));
		}
		if (!$this->id_admission->FldIsDetailKey)
			$this->id_admission->setFormValue($objForm->GetValue("x_id_admission"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id_admission->CurrentValue = $this->id_admission->FormValue;
		$this->nomr->CurrentValue = $this->nomr->FormValue;
		$this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
		$this->kirimdari->CurrentValue = $this->kirimdari->FormValue;
		$this->masukrs->CurrentValue = $this->masukrs->FormValue;
		$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 11);
		$this->noruang->CurrentValue = $this->noruang->FormValue;
		$this->tempat_tidur_id->CurrentValue = $this->tempat_tidur_id->FormValue;
		$this->KELASPERAWATAN_ID->CurrentValue = $this->KELASPERAWATAN_ID->FormValue;
		$this->nott->CurrentValue = $this->nott->FormValue;
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->ket_nama->setDbValue($rs->fields('ket_nama'));
		$this->parent_nomr->setDbValue($rs->fields('parent_nomr'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->icd_masuk->setDbValue($rs->fields('icd_masuk'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->kd_rujuk->setDbValue($rs->fields('kd_rujuk'));
		$this->st_bayar->setDbValue($rs->fields('st_bayar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->perawat->setDbValue($rs->fields('perawat'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->ket_tgllahir->setDbValue($rs->fields('ket_tgllahir'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->grup_ruang_id->setDbValue($rs->fields('grup_ruang_id'));
		$this->nott->setDbValue($rs->fields('nott'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->ket_nama->DbValue = $row['ket_nama'];
		$this->parent_nomr->DbValue = $row['parent_nomr'];
		$this->dokterpengirim->DbValue = $row['dokterpengirim'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kirimdari->DbValue = $row['kirimdari'];
		$this->keluargadekat->DbValue = $row['keluargadekat'];
		$this->panggungjawab->DbValue = $row['panggungjawab'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->keluarrs->DbValue = $row['keluarrs'];
		$this->icd_masuk->DbValue = $row['icd_masuk'];
		$this->icd_keluar->DbValue = $row['icd_keluar'];
		$this->NIP->DbValue = $row['NIP'];
		$this->kd_rujuk->DbValue = $row['kd_rujuk'];
		$this->st_bayar->DbValue = $row['st_bayar'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->perawat->DbValue = $row['perawat'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->ket_tgllahir->DbValue = $row['ket_tgllahir'];
		$this->ket_alamat->DbValue = $row['ket_alamat'];
		$this->ket_jeniskelamin->DbValue = $row['ket_jeniskelamin'];
		$this->ket_title->DbValue = $row['ket_title'];
		$this->grup_ruang_id->DbValue = $row['grup_ruang_id'];
		$this->nott->DbValue = $row['nott'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id_admission
		// nomr
		// ket_nama
		// parent_nomr
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// keluarrs
		// icd_masuk
		// icd_keluar
		// NIP
		// kd_rujuk
		// st_bayar
		// dokter_penanggungjawab
		// perawat
		// KELASPERAWATAN_ID
		// NO_SKP
		// ket_tgllahir
		// ket_alamat
		// ket_jeniskelamin
		// ket_title
		// grup_ruang_id
		// nott

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		if (strval($this->nomr->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->nomr->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->nomr->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->nomr->ViewValue = $this->nomr->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomr->ViewValue = $this->nomr->CurrentValue;
			}
		} else {
			$this->nomr->ViewValue = NULL;
		}
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// parent_nomr
		$this->parent_nomr->ViewValue = $this->parent_nomr->CurrentValue;
		$this->parent_nomr->ViewCustomAttributes = "";

		// dokterpengirim
		if (strval($this->dokterpengirim->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokterpengirim->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokterpengirim->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->CurrentValue;
			}
		} else {
			$this->dokterpengirim->ViewValue = NULL;
		}
		$this->dokterpengirim->ViewCustomAttributes = "";

		// statusbayar
		if (strval($this->statusbayar->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->statusbayar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statusbayar->ViewValue = $this->statusbayar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			}
		} else {
			$this->statusbayar->ViewValue = NULL;
		}
		$this->statusbayar->ViewCustomAttributes = "";

		// kirimdari
		if (strval($this->kirimdari->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kirimdari->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->kirimdari->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kirimdari->ViewValue = $this->kirimdari->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
			}
		} else {
			$this->kirimdari->ViewValue = NULL;
		}
		$this->kirimdari->ViewCustomAttributes = "";

		// keluargadekat
		$this->keluargadekat->ViewValue = $this->keluargadekat->CurrentValue;
		$this->keluargadekat->ViewCustomAttributes = "";

		// panggungjawab
		$this->panggungjawab->ViewValue = $this->panggungjawab->CurrentValue;
		$this->panggungjawab->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 11);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		if (strval($this->noruang->CurrentValue) <> "") {
			$sFilterWrk = "`no`" . ew_SearchString("=", $this->noruang->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `no`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_ruang`";
		$sWhereWrk = "";
		$this->noruang->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->noruang->ViewValue = $this->noruang->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->noruang->ViewValue = $this->noruang->CurrentValue;
			}
		} else {
			$this->noruang->ViewValue = NULL;
		}
		$this->noruang->ViewCustomAttributes = "";

		// tempat_tidur_id
		if (strval($this->tempat_tidur_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
		$sWhereWrk = "";
		$this->tempat_tidur_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->CurrentValue;
			}
		} else {
			$this->tempat_tidur_id->ViewValue = NULL;
		}
		$this->tempat_tidur_id->ViewCustomAttributes = "";

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 0);
		$this->keluarrs->ViewCustomAttributes = "";

		// icd_masuk
		$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
		if (strval($this->icd_masuk->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_masuk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
		$sWhereWrk = "";
		$this->icd_masuk->LookupFilters = array();
		$lookuptblfilter = "`CBG_USE_IND`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_masuk->ViewValue = $this->icd_masuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
			}
		} else {
			$this->icd_masuk->ViewValue = NULL;
		}
		$this->icd_masuk->ViewCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		$this->icd_keluar->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// kd_rujuk
		if (strval($this->kd_rujuk->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->kd_rujuk->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->kd_rujuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->CurrentValue;
			}
		} else {
			$this->kd_rujuk->ViewValue = NULL;
		}
		$this->kd_rujuk->ViewCustomAttributes = "";

		// st_bayar
		$this->st_bayar->ViewValue = $this->st_bayar->CurrentValue;
		$this->st_bayar->ViewCustomAttributes = "";

		// dokter_penanggungjawab
		if (strval($this->dokter_penanggungjawab->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokter_penanggungjawab->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokter_penanggungjawab->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->CurrentValue;
			}
		} else {
			$this->dokter_penanggungjawab->ViewValue = NULL;
		}
		$this->dokter_penanggungjawab->ViewCustomAttributes = "";

		// perawat
		$this->perawat->ViewValue = $this->perawat->CurrentValue;
		$this->perawat->ViewCustomAttributes = "";

		// KELASPERAWATAN_ID
		if (strval($this->KELASPERAWATAN_ID->CurrentValue) <> "") {
			$sFilterWrk = "`kelasperawatan_id`" . ew_SearchString("=", $this->KELASPERAWATAN_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kelasperawatan_id`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_kelas_perawatan`";
		$sWhereWrk = "";
		$this->KELASPERAWATAN_ID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
			}
		} else {
			$this->KELASPERAWATAN_ID->ViewValue = NULL;
		}
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// ket_tgllahir
		$this->ket_tgllahir->ViewValue = $this->ket_tgllahir->CurrentValue;
		$this->ket_tgllahir->ViewValue = ew_FormatDateTime($this->ket_tgllahir->ViewValue, 0);
		$this->ket_tgllahir->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// grup_ruang_id
		$this->grup_ruang_id->ViewValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->ViewCustomAttributes = "";

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// kirimdari
			$this->kirimdari->LinkCustomAttributes = "";
			$this->kirimdari->HrefValue = "";
			$this->kirimdari->TooltipValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";
			$this->masukrs->TooltipValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";
			$this->noruang->TooltipValue = "";

			// tempat_tidur_id
			$this->tempat_tidur_id->LinkCustomAttributes = "";
			$this->tempat_tidur_id->HrefValue = "";
			$this->tempat_tidur_id->TooltipValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";
			$this->nott->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			$this->nomr->EditValue = $this->nomr->CurrentValue;
			if (strval($this->nomr->CurrentValue) <> "") {
				$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->nomr->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "";
			$this->nomr->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$arwrk[2] = $rswrk->fields('Disp2Fld');
					$this->nomr->EditValue = $this->nomr->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nomr->EditValue = $this->nomr->CurrentValue;
				}
			} else {
				$this->nomr->EditValue = NULL;
			}
			$this->nomr->ViewCustomAttributes = "";

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			if (strval($this->statusbayar->CurrentValue) <> "") {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->statusbayar->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->statusbayar->EditValue = $this->statusbayar->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->statusbayar->EditValue = $this->statusbayar->CurrentValue;
				}
			} else {
				$this->statusbayar->EditValue = NULL;
			}
			$this->statusbayar->ViewCustomAttributes = "";

			// kirimdari
			$this->kirimdari->EditAttrs["class"] = "form-control";
			$this->kirimdari->EditCustomAttributes = "";
			if (strval($this->kirimdari->CurrentValue) <> "") {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kirimdari->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "";
			$this->kirimdari->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->kirimdari->EditValue = $this->kirimdari->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->kirimdari->EditValue = $this->kirimdari->CurrentValue;
				}
			} else {
				$this->kirimdari->EditValue = NULL;
			}
			$this->kirimdari->ViewCustomAttributes = "";

			// masukrs
			$this->masukrs->EditAttrs["class"] = "form-control";
			$this->masukrs->EditCustomAttributes = "";
			$this->masukrs->EditValue = $this->masukrs->CurrentValue;
			$this->masukrs->EditValue = ew_FormatDateTime($this->masukrs->EditValue, 11);
			$this->masukrs->ViewCustomAttributes = "";

			// noruang
			$this->noruang->EditAttrs["class"] = "form-control";
			$this->noruang->EditCustomAttributes = "";
			if (trim(strval($this->noruang->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`no`" . ew_SearchString("=", $this->noruang->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `no`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_ruang`";
			$sWhereWrk = "";
			$this->noruang->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->noruang->EditValue = $arwrk;

			// tempat_tidur_id
			$this->tempat_tidur_id->EditAttrs["class"] = "form-control";
			$this->tempat_tidur_id->EditCustomAttributes = "";
			if (trim(strval($this->tempat_tidur_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idxruang` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_detail_tempat_tidur`";
			$sWhereWrk = "";
			$this->tempat_tidur_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->tempat_tidur_id->EditValue = $arwrk;

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->EditAttrs["class"] = "form-control";
			$this->KELASPERAWATAN_ID->EditCustomAttributes = "";
			if (trim(strval($this->KELASPERAWATAN_ID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kelasperawatan_id`" . ew_SearchString("=", $this->KELASPERAWATAN_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kelasperawatan_id`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_kelas_perawatan`";
			$sWhereWrk = "";
			$this->KELASPERAWATAN_ID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KELASPERAWATAN_ID->EditValue = $arwrk;

			// nott
			$this->nott->EditAttrs["class"] = "form-control";
			$this->nott->EditCustomAttributes = "";
			$this->nott->EditValue = ew_HtmlEncode($this->nott->CurrentValue);
			$this->nott->PlaceHolder = ew_RemoveHtml($this->nott->FldCaption());

			// Edit refer script
			// nomr

			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// kirimdari
			$this->kirimdari->LinkCustomAttributes = "";
			$this->kirimdari->HrefValue = "";
			$this->kirimdari->TooltipValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";
			$this->masukrs->TooltipValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";

			// tempat_tidur_id
			$this->tempat_tidur_id->LinkCustomAttributes = "";
			$this->tempat_tidur_id->HrefValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";
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
		if (!$this->noruang->FldIsDetailKey && !is_null($this->noruang->FormValue) && $this->noruang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->noruang->FldCaption(), $this->noruang->ReqErrMsg));
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey && !is_null($this->tempat_tidur_id->FormValue) && $this->tempat_tidur_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tempat_tidur_id->FldCaption(), $this->tempat_tidur_id->ReqErrMsg));
		}
		if (!$this->nott->FldIsDetailKey && !is_null($this->nott->FormValue) && $this->nott->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nott->FldCaption(), $this->nott->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_konsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tmno", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tmno"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"])) $GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_perawat", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_visite_gizi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_gizi"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_visite_farmasi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_penunjang", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_konsul_vct", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_vct"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_pelayanan_los", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"])) $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_lain", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->DetailEdit) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"] = new cvw_bill_ranap_detail_tindakan_kebidanan_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// noruang
			$this->noruang->SetDbValueDef($rsnew, $this->noruang->CurrentValue, 0, $this->noruang->ReadOnly);

			// tempat_tidur_id
			$this->tempat_tidur_id->SetDbValueDef($rsnew, $this->tempat_tidur_id->CurrentValue, 0, $this->tempat_tidur_id->ReadOnly);

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->SetDbValueDef($rsnew, $this->KELASPERAWATAN_ID->CurrentValue, NULL, $this->KELASPERAWATAN_ID->ReadOnly);

			// nott
			$this->nott->SetDbValueDef($rsnew, $this->nott->CurrentValue, "", $this->nott->ReadOnly);

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
				}

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_visitekonsul_dokter"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_konsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_konsul_dokter"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_tmno", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tmno"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"])) $GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tmno"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_tmno_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_tindakan_perawat", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_perawat"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_visite_gizi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_gizi"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_visite_gizi"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_visite_farmasi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_visite_farmasi"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_tindakan_penunjang", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_penunjang"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_konsul_vct", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_vct"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_konsul_vct"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_pelayanan_los", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"])) $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_pelayanan_los"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_tindakan_lain", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_lain"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->DetailEdit) {
						if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"] = new cvw_bill_ranap_detail_tindakan_kebidanan_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_kebidanan"); // Load user level of detail table
						$EditRow = $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
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
		return $EditRow;
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
			if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]))
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid;
				if ($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->kelas->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->no_ruang->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->no_ruang->CurrentValue = $this->noruang->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->no_ruang->setSessionValue($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->no_ruang->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_konsul_dokter", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]))
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid;
				if ($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->kelas->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->no_ruang->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->no_ruang->CurrentValue = $this->noruang->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->no_ruang->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->no_ruang->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_tmno", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"]))
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid;
				if ($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->kelas->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->no_ruang->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->no_ruang->CurrentValue = $this->noruang->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->no_ruang->setSessionValue($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->no_ruang->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_tindakan_perawat", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]))
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid;
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->kelas->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->no_ruang->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->no_ruang->CurrentValue = $this->noruang->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->no_ruang->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->no_ruang->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_visite_gizi", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]))
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid;
				if ($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->kelas->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->no_ruang->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->no_ruang->CurrentValue = $this->noruang->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->no_ruang->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->no_ruang->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_visite_farmasi", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]))
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid;
				if ($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->kelas->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->no_ruang->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->no_ruang->CurrentValue = $this->noruang->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->no_ruang->setSessionValue($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->no_ruang->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_tindakan_penunjang", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]))
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid;
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->kelas->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_konsul_vct", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]))
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid;
				if ($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->kelas->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_pelayanan_los", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]))
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid;
				if ($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->kelas->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_tindakan_lain", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]))
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid;
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->kelas->CurrentValue);
				}
			}
			if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", $DetailTblVar)) {
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]))
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"] = new cvw_bill_ranap_detail_tindakan_kebidanan_grid;
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->DetailEdit) {
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->CurrentMode = "edit";
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->setStartRecordNumber(1);
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->id_admission->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->id_admission->CurrentValue = $this->id_admission->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->id_admission->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->id_admission->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->nomr->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->nomr->CurrentValue = $this->nomr->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->nomr->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->nomr->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->statusbayar->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->statusbayar->CurrentValue = $this->statusbayar->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->statusbayar->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->statusbayar->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->kelas->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->kelas->CurrentValue = $this->KELASPERAWATAN_ID->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->kelas->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->kelas->CurrentValue);
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->no_ruang->FldIsDetailKey = TRUE;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->no_ruang->CurrentValue = $this->noruang->CurrentValue;
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->no_ruang->setSessionValue($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->no_ruang->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_bill_ranaplist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Set up detail pages
	function SetupDetailPages() {
		$pages = new cSubPages();
		$pages->Style = "tabs";
		$pages->Add('vw_bill_ranap_detail_visitekonsul_dokter');
		$pages->Add('vw_bill_ranap_detail_konsul_dokter');
		$pages->Add('vw_bill_ranap_detail_tmno');
		$pages->Add('vw_bill_ranap_detail_tindakan_perawat');
		$pages->Add('vw_bill_ranap_detail_visite_gizi');
		$pages->Add('vw_bill_ranap_detail_visite_farmasi');
		$pages->Add('vw_bill_ranap_detail_tindakan_penunjang');
		$pages->Add('vw_bill_ranap_detail_konsul_vct');
		$pages->Add('vw_bill_ranap_detail_pelayanan_los');
		$pages->Add('vw_bill_ranap_detail_tindakan_lain');
		$pages->Add('vw_bill_ranap_detail_tindakan_kebidanan');
		$this->DetailPages = $pages;
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_noruang":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `no` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_ruang`";
			$sWhereWrk = "";
			$this->noruang->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`no` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_tempat_tidur_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id` AS `LinkFld`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
			$sWhereWrk = "{filter}";
			$this->tempat_tidur_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`idxruang` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KELASPERAWATAN_ID":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kelasperawatan_id` AS `LinkFld`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_kelas_perawatan`";
			$sWhereWrk = "";
			$this->KELASPERAWATAN_ID->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kelasperawatan_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
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

		if ($this->CurrentAction == "U") {
			$url = "vw_bill_ranaplist.php";
		}
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
if (!isset($vw_bill_ranap_edit)) $vw_bill_ranap_edit = new cvw_bill_ranap_edit();

// Page init
$vw_bill_ranap_edit->Page_Init();

// Page main
$vw_bill_ranap_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_bill_ranapedit = new ew_Form("fvw_bill_ranapedit", "edit");

// Validate form
fvw_bill_ranapedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_noruang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap->noruang->FldCaption(), $vw_bill_ranap->noruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tempat_tidur_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap->tempat_tidur_id->FldCaption(), $vw_bill_ranap->tempat_tidur_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nott");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_bill_ranap->nott->FldCaption(), $vw_bill_ranap->nott->ReqErrMsg)) ?>");

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
fvw_bill_ranapedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranapedit.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranapedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_bill_ranapedit.Lists["x_nomr"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_bill_ranapedit.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_bill_ranapedit.Lists["x_kirimdari"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_bill_ranapedit.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
fvw_bill_ranapedit.Lists["x_tempat_tidur_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_no_tt","","",""],"ParentFields":["x_noruang"],"ChildFields":[],"FilterFields":["x_idxruang"],"Options":[],"Template":"","LinkTable":"m_detail_tempat_tidur"};
fvw_bill_ranapedit.Lists["x_KELASPERAWATAN_ID"] = {"LinkField":"x_kelasperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kelasperawatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_kelas_perawatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_bill_ranap_edit->IsModal) { ?>
<?php } ?>
<?php $vw_bill_ranap_edit->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_edit->ShowMessage();
?>
<form name="fvw_bill_ranapedit" id="fvw_bill_ranapedit" class="<?php echo $vw_bill_ranap_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bill_ranap_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bill_ranap_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bill_ranap">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_bill_ranap_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_bill_ranap->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label id="elh_vw_bill_ranap_nomr" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->nomr->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->nomr->CellAttributes() ?>>
<span id="el_vw_bill_ranap_nomr">
<span<?php echo $vw_bill_ranap->nomr->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap->nomr->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap" data-field="x_nomr" name="x_nomr" id="x_nomr" value="<?php echo ew_HtmlEncode($vw_bill_ranap->nomr->CurrentValue) ?>">
<?php echo $vw_bill_ranap->nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap->statusbayar->Visible) { // statusbayar ?>
	<div id="r_statusbayar" class="form-group">
		<label id="elh_vw_bill_ranap_statusbayar" for="x_statusbayar" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->statusbayar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->statusbayar->CellAttributes() ?>>
<span id="el_vw_bill_ranap_statusbayar">
<span<?php echo $vw_bill_ranap->statusbayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap->statusbayar->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap" data-field="x_statusbayar" name="x_statusbayar" id="x_statusbayar" value="<?php echo ew_HtmlEncode($vw_bill_ranap->statusbayar->CurrentValue) ?>">
<?php echo $vw_bill_ranap->statusbayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap->kirimdari->Visible) { // kirimdari ?>
	<div id="r_kirimdari" class="form-group">
		<label id="elh_vw_bill_ranap_kirimdari" for="x_kirimdari" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->kirimdari->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->kirimdari->CellAttributes() ?>>
<span id="el_vw_bill_ranap_kirimdari">
<span<?php echo $vw_bill_ranap->kirimdari->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap->kirimdari->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap" data-field="x_kirimdari" name="x_kirimdari" id="x_kirimdari" value="<?php echo ew_HtmlEncode($vw_bill_ranap->kirimdari->CurrentValue) ?>">
<?php echo $vw_bill_ranap->kirimdari->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap->masukrs->Visible) { // masukrs ?>
	<div id="r_masukrs" class="form-group">
		<label id="elh_vw_bill_ranap_masukrs" for="x_masukrs" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->masukrs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->masukrs->CellAttributes() ?>>
<span id="el_vw_bill_ranap_masukrs">
<span<?php echo $vw_bill_ranap->masukrs->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_bill_ranap->masukrs->EditValue ?></p></span>
</span>
<input type="hidden" data-table="vw_bill_ranap" data-field="x_masukrs" name="x_masukrs" id="x_masukrs" value="<?php echo ew_HtmlEncode($vw_bill_ranap->masukrs->CurrentValue) ?>">
<?php echo $vw_bill_ranap->masukrs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap->noruang->Visible) { // noruang ?>
	<div id="r_noruang" class="form-group">
		<label id="elh_vw_bill_ranap_noruang" for="x_noruang" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->noruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->noruang->CellAttributes() ?>>
<span id="el_vw_bill_ranap_noruang">
<?php $vw_bill_ranap->noruang->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_bill_ranap->noruang->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap" data-field="x_noruang" data-value-separator="<?php echo $vw_bill_ranap->noruang->DisplayValueSeparatorAttribute() ?>" id="x_noruang" name="x_noruang"<?php echo $vw_bill_ranap->noruang->EditAttributes() ?>>
<?php echo $vw_bill_ranap->noruang->SelectOptionListHtml("x_noruang") ?>
</select>
<input type="hidden" name="s_x_noruang" id="s_x_noruang" value="<?php echo $vw_bill_ranap->noruang->LookupFilterQuery() ?>">
</span>
<?php echo $vw_bill_ranap->noruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap->tempat_tidur_id->Visible) { // tempat_tidur_id ?>
	<div id="r_tempat_tidur_id" class="form-group">
		<label id="elh_vw_bill_ranap_tempat_tidur_id" for="x_tempat_tidur_id" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->tempat_tidur_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->tempat_tidur_id->CellAttributes() ?>>
<span id="el_vw_bill_ranap_tempat_tidur_id">
<?php $vw_bill_ranap->tempat_tidur_id->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$vw_bill_ranap->tempat_tidur_id->EditAttrs["onchange"]; ?>
<select data-table="vw_bill_ranap" data-field="x_tempat_tidur_id" data-value-separator="<?php echo $vw_bill_ranap->tempat_tidur_id->DisplayValueSeparatorAttribute() ?>" id="x_tempat_tidur_id" name="x_tempat_tidur_id"<?php echo $vw_bill_ranap->tempat_tidur_id->EditAttributes() ?>>
<?php echo $vw_bill_ranap->tempat_tidur_id->SelectOptionListHtml("x_tempat_tidur_id") ?>
</select>
<input type="hidden" name="s_x_tempat_tidur_id" id="s_x_tempat_tidur_id" value="<?php echo $vw_bill_ranap->tempat_tidur_id->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_tempat_tidur_id" id="ln_x_tempat_tidur_id" value="x_nott">
</span>
<?php echo $vw_bill_ranap->tempat_tidur_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<div id="r_KELASPERAWATAN_ID" class="form-group">
		<label id="elh_vw_bill_ranap_KELASPERAWATAN_ID" for="x_KELASPERAWATAN_ID" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->KELASPERAWATAN_ID->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->CellAttributes() ?>>
<span id="el_vw_bill_ranap_KELASPERAWATAN_ID">
<select data-table="vw_bill_ranap" data-field="x_KELASPERAWATAN_ID" data-value-separator="<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->DisplayValueSeparatorAttribute() ?>" id="x_KELASPERAWATAN_ID" name="x_KELASPERAWATAN_ID"<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->EditAttributes() ?>>
<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->SelectOptionListHtml("x_KELASPERAWATAN_ID") ?>
</select>
<input type="hidden" name="s_x_KELASPERAWATAN_ID" id="s_x_KELASPERAWATAN_ID" value="<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->LookupFilterQuery() ?>">
</span>
<?php echo $vw_bill_ranap->KELASPERAWATAN_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_bill_ranap->nott->Visible) { // nott ?>
	<div id="r_nott" class="form-group">
		<label id="elh_vw_bill_ranap_nott" for="x_nott" class="col-sm-2 control-label ewLabel"><?php echo $vw_bill_ranap->nott->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_bill_ranap->nott->CellAttributes() ?>>
<span id="el_vw_bill_ranap_nott">
<input type="text" data-table="vw_bill_ranap" data-field="x_nott" name="x_nott" id="x_nott" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($vw_bill_ranap->nott->getPlaceHolder()) ?>" value="<?php echo $vw_bill_ranap->nott->EditValue ?>"<?php echo $vw_bill_ranap->nott->EditAttributes() ?>>
</span>
<?php echo $vw_bill_ranap->nott->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="vw_bill_ranap" data-field="x_id_admission" name="x_id_admission" id="x_id_admission" value="<?php echo ew_HtmlEncode($vw_bill_ranap->id_admission->CurrentValue) ?>">
<?php if ($vw_bill_ranap->getCurrentDetailTable() <> "") { ?>
<?php
	$vw_bill_ranap_edit->DetailPages->ValidKeys = explode(",", $vw_bill_ranap->getCurrentDetailTable());
	$FirstActiveDetailTable = $vw_bill_ranap_edit->DetailPages->ActivePageIndex();
?>
<div class="ewDetailPages">
<div class="tabbable" id="vw_bill_ranap_edit_details">
	<ul class="nav<?php echo $vw_bill_ranap_edit->DetailPages->NavStyle() ?>">
<?php
	if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visitekonsul_dokter->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visitekonsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visitekonsul_dokter";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_visitekonsul_dokter") ?>><a href="#tab_vw_bill_ranap_detail_visitekonsul_dokter" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_visitekonsul_dokter", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_dokter->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_dokter";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_konsul_dokter") ?>><a href="#tab_vw_bill_ranap_detail_konsul_dokter" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_konsul_dokter", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tmno", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tmno->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tmno") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tmno";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_tmno") ?>><a href="#tab_vw_bill_ranap_detail_tmno" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tmno", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_perawat", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_perawat->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_perawat") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_perawat";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_perawat") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_perawat" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_perawat", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_gizi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_gizi->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_gizi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_gizi";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_visite_gizi") ?>><a href="#tab_vw_bill_ranap_detail_visite_gizi" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_visite_gizi", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_farmasi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_farmasi->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_farmasi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_farmasi";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_visite_farmasi") ?>><a href="#tab_vw_bill_ranap_detail_visite_farmasi" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_visite_farmasi", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_penunjang", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_penunjang->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_penunjang") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_penunjang";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_penunjang") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_penunjang" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_penunjang", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_vct", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_vct->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_vct") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_vct";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_konsul_vct") ?>><a href="#tab_vw_bill_ranap_detail_konsul_vct" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_konsul_vct", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_pelayanan_los", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_pelayanan_los->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_pelayanan_los") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_pelayanan_los";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_pelayanan_los") ?>><a href="#tab_vw_bill_ranap_detail_pelayanan_los" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_pelayanan_los", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_lain", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_lain->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_lain") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_lain";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_lain") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_lain" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_lain", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_kebidanan->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_kebidanan") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_kebidanan";
		}
?>
		<li<?php echo $vw_bill_ranap_edit->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_kebidanan") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_kebidanan" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_kebidanan", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul>
	<div class="tab-content">
<?php
	if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visitekonsul_dokter->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visitekonsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visitekonsul_dokter";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_visitekonsul_dokter") ?>" id="tab_vw_bill_ranap_detail_visitekonsul_dokter">
<?php include_once "vw_bill_ranap_detail_visitekonsul_doktergrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_dokter->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_dokter";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_konsul_dokter") ?>" id="tab_vw_bill_ranap_detail_konsul_dokter">
<?php include_once "vw_bill_ranap_detail_konsul_doktergrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tmno", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tmno->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tmno") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tmno";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_tmno") ?>" id="tab_vw_bill_ranap_detail_tmno">
<?php include_once "vw_bill_ranap_detail_tmnogrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_perawat", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_perawat->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_perawat") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_perawat";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_perawat") ?>" id="tab_vw_bill_ranap_detail_tindakan_perawat">
<?php include_once "vw_bill_ranap_detail_tindakan_perawatgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_gizi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_gizi->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_gizi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_gizi";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_visite_gizi") ?>" id="tab_vw_bill_ranap_detail_visite_gizi">
<?php include_once "vw_bill_ranap_detail_visite_gizigrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_farmasi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_farmasi->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_farmasi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_farmasi";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_visite_farmasi") ?>" id="tab_vw_bill_ranap_detail_visite_farmasi">
<?php include_once "vw_bill_ranap_detail_visite_farmasigrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_penunjang", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_penunjang->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_penunjang") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_penunjang";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_penunjang") ?>" id="tab_vw_bill_ranap_detail_tindakan_penunjang">
<?php include_once "vw_bill_ranap_detail_tindakan_penunjanggrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_vct", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_vct->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_vct") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_vct";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_konsul_vct") ?>" id="tab_vw_bill_ranap_detail_konsul_vct">
<?php include_once "vw_bill_ranap_detail_konsul_vctgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_pelayanan_los", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_pelayanan_los->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_pelayanan_los") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_pelayanan_los";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_pelayanan_los") ?>" id="tab_vw_bill_ranap_detail_pelayanan_los">
<?php include_once "vw_bill_ranap_detail_pelayanan_losgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_lain", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_lain->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_lain") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_lain";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_lain") ?>" id="tab_vw_bill_ranap_detail_tindakan_lain">
<?php include_once "vw_bill_ranap_detail_tindakan_laingrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_kebidanan->DetailEdit) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_kebidanan") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_kebidanan";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_edit->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_kebidanan") ?>" id="tab_vw_bill_ranap_detail_tindakan_kebidanan">
<?php include_once "vw_bill_ranap_detail_tindakan_kebidanangrid.php" ?>
		</div>
<?php } ?>
	</div>
</div>
</div>
<?php } ?>
<?php if (!$vw_bill_ranap_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bill_ranap_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_bill_ranapedit.Init();
</script>
<?php
$vw_bill_ranap_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bill_ranap_edit->Page_Terminate();
?>
