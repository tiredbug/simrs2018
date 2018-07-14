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

$vw_bill_ranap_add = NULL; // Initialize page object first

class cvw_bill_ranap_add extends cvw_bill_ranap {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_bill_ranap';

	// Page object name
	var $PageObjName = 'vw_bill_ranap_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;
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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id_admission"] != "") {
				$this->id_admission->setQueryStringValue($_GET["id_admission"]);
				$this->setKey("id_admission", $this->id_admission->CurrentValue); // Set up key
			} else {
				$this->setKey("id_admission", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("vw_bill_ranaplist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_bill_ranaplist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_bill_ranapview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
	}

	// Load default values
	function LoadDefaultValues() {
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_admission->FldIsDetailKey)
			$this->id_admission->setFormValue($objForm->GetValue("x_id_admission"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_admission->CurrentValue = $this->id_admission->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id_admission")) <> "")
			$this->id_admission->CurrentValue = $this->getKey("id_admission"); // id_admission
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Add refer script
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

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_konsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tmno", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tmno"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"])) $GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_perawat", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_visite_gizi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_gizi"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_visite_farmasi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_penunjang", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_konsul_vct", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_vct"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_pelayanan_los", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"])) $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_lain", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->DetailAdd) {
			if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid(); // get detail page object
			$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->ValidateGridForm();
		}
		if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->DetailAdd) {
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['id_admission']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->no_ruang->setSessionValue($this->noruang->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"] = new cvw_bill_ranap_detail_visitekonsul_dokter_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_visitekonsul_dokter"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter"]->no_ruang->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_konsul_dokter", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->no_ruang->setSessionValue($this->noruang->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"] = new cvw_bill_ranap_detail_konsul_dokter_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_konsul_dokter"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter"]->no_ruang->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_tmno", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tmno"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_tmno"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tmno"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tmno"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tmno"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tmno"]->no_ruang->setSessionValue($this->noruang->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_tmno_grid"])) $GLOBALS["vw_bill_ranap_detail_tmno_grid"] = new cvw_bill_ranap_detail_tmno_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tmno"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_tmno_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_tmno"]->no_ruang->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_tindakan_perawat", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->no_ruang->setSessionValue($this->noruang->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"] = new cvw_bill_ranap_detail_tindakan_perawat_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_perawat"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat"]->no_ruang->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_visite_gizi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_gizi"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_visite_gizi"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_gizi"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_gizi"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_gizi"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_gizi"]->no_ruang->setSessionValue($this->noruang->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"] = new cvw_bill_ranap_detail_visite_gizi_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_visite_gizi"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_visite_gizi"]->no_ruang->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_visite_farmasi", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->no_ruang->setSessionValue($this->noruang->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"])) $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"] = new cvw_bill_ranap_detail_visite_farmasi_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_visite_farmasi"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi"]->no_ruang->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_tindakan_penunjang", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"] = new cvw_bill_ranap_detail_tindakan_penunjang_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_penunjang"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang"]->kelas->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_konsul_vct", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_konsul_vct"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_konsul_vct"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_konsul_vct"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_konsul_vct"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_konsul_vct"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"])) $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"] = new cvw_bill_ranap_detail_konsul_vct_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_konsul_vct"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_konsul_vct"]->kelas->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_pelayanan_los", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"])) $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"] = new cvw_bill_ranap_detail_pelayanan_los_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_pelayanan_los"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los"]->kelas->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_tindakan_lain", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"] = new cvw_bill_ranap_detail_tindakan_lain_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_lain"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain"]->kelas->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", $DetailTblVar) && $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->DetailAdd) {
				$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->id_admission->setSessionValue($this->id_admission->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->nomr->setSessionValue($this->nomr->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->statusbayar->setSessionValue($this->statusbayar->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->kelas->setSessionValue($this->KELASPERAWATAN_ID->CurrentValue); // Set master key
				$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->no_ruang->setSessionValue($this->noruang->CurrentValue); // Set master key
				if (!isset($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"])) $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"] = new cvw_bill_ranap_detail_tindakan_kebidanan_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "vw_bill_ranap_detail_tindakan_kebidanan"); // Load user level of detail table
				$AddRow = $GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan"]->no_ruang->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
				if ($GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_visitekonsul_dokter_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_konsul_dokter_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_tmno_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_tmno_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_tindakan_perawat_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_visite_gizi_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_visite_farmasi_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_tindakan_penunjang_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_konsul_vct_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_pelayanan_los_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_tindakan_lain_grid"]->CurrentAction = "gridadd";

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
				if ($GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->CurrentMode = "add";
					$GLOBALS["vw_bill_ranap_detail_tindakan_kebidanan_grid"]->CurrentAction = "gridadd";

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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($vw_bill_ranap_add)) $vw_bill_ranap_add = new cvw_bill_ranap_add();

// Page init
$vw_bill_ranap_add->Page_Init();

// Page main
$vw_bill_ranap_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_bill_ranap_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_bill_ranapadd = new ew_Form("fvw_bill_ranapadd", "add");

// Validate form
fvw_bill_ranapadd.Validate = function() {
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
fvw_bill_ranapadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_bill_ranapadd.ValidateRequired = true;
<?php } else { ?>
fvw_bill_ranapadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_bill_ranap_add->IsModal) { ?>
<?php } ?>
<?php $vw_bill_ranap_add->ShowPageHeader(); ?>
<?php
$vw_bill_ranap_add->ShowMessage();
?>
<form name="fvw_bill_ranapadd" id="fvw_bill_ranapadd" class="<?php echo $vw_bill_ranap_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_bill_ranap_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_bill_ranap_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_bill_ranap">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_bill_ranap_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
</div>
<?php if ($vw_bill_ranap->getCurrentDetailTable() <> "") { ?>
<?php
	$vw_bill_ranap_add->DetailPages->ValidKeys = explode(",", $vw_bill_ranap->getCurrentDetailTable());
	$FirstActiveDetailTable = $vw_bill_ranap_add->DetailPages->ActivePageIndex();
?>
<div class="ewDetailPages">
<div class="tabbable" id="vw_bill_ranap_add_details">
	<ul class="nav<?php echo $vw_bill_ranap_add->DetailPages->NavStyle() ?>">
<?php
	if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visitekonsul_dokter->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visitekonsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visitekonsul_dokter";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_visitekonsul_dokter") ?>><a href="#tab_vw_bill_ranap_detail_visitekonsul_dokter" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_visitekonsul_dokter", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_dokter->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_dokter";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_konsul_dokter") ?>><a href="#tab_vw_bill_ranap_detail_konsul_dokter" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_konsul_dokter", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tmno", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tmno->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tmno") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tmno";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_tmno") ?>><a href="#tab_vw_bill_ranap_detail_tmno" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tmno", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_perawat", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_perawat->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_perawat") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_perawat";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_perawat") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_perawat" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_perawat", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_gizi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_gizi->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_gizi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_gizi";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_visite_gizi") ?>><a href="#tab_vw_bill_ranap_detail_visite_gizi" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_visite_gizi", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_farmasi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_farmasi->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_farmasi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_farmasi";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_visite_farmasi") ?>><a href="#tab_vw_bill_ranap_detail_visite_farmasi" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_visite_farmasi", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_penunjang", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_penunjang->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_penunjang") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_penunjang";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_penunjang") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_penunjang" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_penunjang", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_vct", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_vct->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_vct") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_vct";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_konsul_vct") ?>><a href="#tab_vw_bill_ranap_detail_konsul_vct" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_konsul_vct", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_pelayanan_los", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_pelayanan_los->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_pelayanan_los") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_pelayanan_los";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_pelayanan_los") ?>><a href="#tab_vw_bill_ranap_detail_pelayanan_los" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_pelayanan_los", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_lain", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_lain->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_lain") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_lain";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_lain") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_lain" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_lain", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_kebidanan->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_kebidanan") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_kebidanan";
		}
?>
		<li<?php echo $vw_bill_ranap_add->DetailPages->TabStyle("vw_bill_ranap_detail_tindakan_kebidanan") ?>><a href="#tab_vw_bill_ranap_detail_tindakan_kebidanan" data-toggle="tab"><?php echo $Language->TablePhrase("vw_bill_ranap_detail_tindakan_kebidanan", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul>
	<div class="tab-content">
<?php
	if (in_array("vw_bill_ranap_detail_visitekonsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visitekonsul_dokter->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visitekonsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visitekonsul_dokter";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_visitekonsul_dokter") ?>" id="tab_vw_bill_ranap_detail_visitekonsul_dokter">
<?php include_once "vw_bill_ranap_detail_visitekonsul_doktergrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_dokter", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_dokter->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_dokter") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_dokter";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_konsul_dokter") ?>" id="tab_vw_bill_ranap_detail_konsul_dokter">
<?php include_once "vw_bill_ranap_detail_konsul_doktergrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tmno", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tmno->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tmno") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tmno";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_tmno") ?>" id="tab_vw_bill_ranap_detail_tmno">
<?php include_once "vw_bill_ranap_detail_tmnogrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_perawat", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_perawat->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_perawat") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_perawat";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_perawat") ?>" id="tab_vw_bill_ranap_detail_tindakan_perawat">
<?php include_once "vw_bill_ranap_detail_tindakan_perawatgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_gizi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_gizi->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_gizi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_gizi";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_visite_gizi") ?>" id="tab_vw_bill_ranap_detail_visite_gizi">
<?php include_once "vw_bill_ranap_detail_visite_gizigrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_visite_farmasi", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_visite_farmasi->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_visite_farmasi") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_visite_farmasi";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_visite_farmasi") ?>" id="tab_vw_bill_ranap_detail_visite_farmasi">
<?php include_once "vw_bill_ranap_detail_visite_farmasigrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_penunjang", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_penunjang->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_penunjang") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_penunjang";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_penunjang") ?>" id="tab_vw_bill_ranap_detail_tindakan_penunjang">
<?php include_once "vw_bill_ranap_detail_tindakan_penunjanggrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_konsul_vct", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_konsul_vct->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_konsul_vct") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_konsul_vct";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_konsul_vct") ?>" id="tab_vw_bill_ranap_detail_konsul_vct">
<?php include_once "vw_bill_ranap_detail_konsul_vctgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_pelayanan_los", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_pelayanan_los->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_pelayanan_los") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_pelayanan_los";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_pelayanan_los") ?>" id="tab_vw_bill_ranap_detail_pelayanan_los">
<?php include_once "vw_bill_ranap_detail_pelayanan_losgrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_lain", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_lain->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_lain") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_lain";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_lain") ?>" id="tab_vw_bill_ranap_detail_tindakan_lain">
<?php include_once "vw_bill_ranap_detail_tindakan_laingrid.php" ?>
		</div>
<?php } ?>
<?php
	if (in_array("vw_bill_ranap_detail_tindakan_kebidanan", explode(",", $vw_bill_ranap->getCurrentDetailTable())) && $vw_bill_ranap_detail_tindakan_kebidanan->DetailAdd) {
		if ($FirstActiveDetailTable == "" || $FirstActiveDetailTable == "vw_bill_ranap_detail_tindakan_kebidanan") {
			$FirstActiveDetailTable = "vw_bill_ranap_detail_tindakan_kebidanan";
		}
?>
		<div class="tab-pane<?php echo $vw_bill_ranap_add->DetailPages->PageStyle("vw_bill_ranap_detail_tindakan_kebidanan") ?>" id="tab_vw_bill_ranap_detail_tindakan_kebidanan">
<?php include_once "vw_bill_ranap_detail_tindakan_kebidanangrid.php" ?>
		</div>
<?php } ?>
	</div>
</div>
</div>
<?php } ?>
<?php if (!$vw_bill_ranap_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_bill_ranap_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_bill_ranapadd.Init();
</script>
<?php
$vw_bill_ranap_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_bill_ranap_add->Page_Terminate();
?>
