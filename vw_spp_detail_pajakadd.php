<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_spp_detail_pajakinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "vw_spp_ls_kontrak_listinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_spp_detail_pajak_add = NULL; // Initialize page object first

class cvw_spp_detail_pajak_add extends cvw_spp_detail_pajak {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_spp_detail_pajak';

	// Page object name
	var $PageObjName = 'vw_spp_detail_pajak_add';

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

		// Table object (vw_spp_detail_pajak)
		if (!isset($GLOBALS["vw_spp_detail_pajak"]) || get_class($GLOBALS["vw_spp_detail_pajak"]) == "cvw_spp_detail_pajak") {
			$GLOBALS["vw_spp_detail_pajak"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_spp_detail_pajak"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Table object (vw_spp_ls_kontrak_list)
		if (!isset($GLOBALS['vw_spp_ls_kontrak_list'])) $GLOBALS['vw_spp_ls_kontrak_list'] = new cvw_spp_ls_kontrak_list();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_spp_detail_pajak', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_spp_detail_pajaklist.php"));
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
		$this->kd_rekening_belanja->SetVisibility();
		$this->jumlah_belanja->SetVisibility();

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
		global $EW_EXPORT, $vw_spp_detail_pajak;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_spp_detail_pajak);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
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
					$this->Page_Terminate("vw_spp_detail_pajaklist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "vw_spp_detail_pajaklist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "vw_spp_detail_pajakview.php")
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
	}

	// Load default values
	function LoadDefaultValues() {
		$this->kd_rekening_belanja->CurrentValue = NULL;
		$this->kd_rekening_belanja->OldValue = $this->kd_rekening_belanja->CurrentValue;
		$this->jumlah_belanja->CurrentValue = NULL;
		$this->jumlah_belanja->OldValue = $this->jumlah_belanja->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->kd_rekening_belanja->FldIsDetailKey) {
			$this->kd_rekening_belanja->setFormValue($objForm->GetValue("x_kd_rekening_belanja"));
		}
		if (!$this->jumlah_belanja->FldIsDetailKey) {
			$this->jumlah_belanja->setFormValue($objForm->GetValue("x_jumlah_belanja"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->kd_rekening_belanja->CurrentValue = $this->kd_rekening_belanja->FormValue;
		$this->jumlah_belanja->CurrentValue = $this->jumlah_belanja->FormValue;
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
		$this->id_spp->setDbValue($rs->fields('id_spp'));
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->kd_rekening_belanja->setDbValue($rs->fields('kd_rekening_belanja'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
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
		$this->id_spp->DbValue = $row['id_spp'];
		$this->id_jenis_spp->DbValue = $row['id_jenis_spp'];
		$this->detail_jenis_spp->DbValue = $row['detail_jenis_spp'];
		$this->no_spp->DbValue = $row['no_spp'];
		$this->program->DbValue = $row['program'];
		$this->kegiatan->DbValue = $row['kegiatan'];
		$this->sub_kegiatan->DbValue = $row['sub_kegiatan'];
		$this->kd_rekening_belanja->DbValue = $row['kd_rekening_belanja'];
		$this->jumlah_belanja->DbValue = $row['jumlah_belanja'];
		$this->tahun_anggaran->DbValue = $row['tahun_anggaran'];
		$this->akun1->DbValue = $row['akun1'];
		$this->akun2->DbValue = $row['akun2'];
		$this->akun3->DbValue = $row['akun3'];
		$this->akun4->DbValue = $row['akun4'];
		$this->akun5->DbValue = $row['akun5'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
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
		// Convert decimal values if posted back

		if ($this->jumlah_belanja->FormValue == $this->jumlah_belanja->CurrentValue && is_numeric(ew_StrToFloat($this->jumlah_belanja->CurrentValue)))
			$this->jumlah_belanja->CurrentValue = ew_StrToFloat($this->jumlah_belanja->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// id_spp
		// id_jenis_spp
		// detail_jenis_spp
		// no_spp
		// program
		// kegiatan
		// sub_kegiatan
		// kd_rekening_belanja
		// jumlah_belanja
		// tahun_anggaran
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_spp
		$this->id_spp->ViewValue = $this->id_spp->CurrentValue;
		$this->id_spp->ViewCustomAttributes = "";

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// kd_rekening_belanja
		if (strval($this->kd_rekening_belanja->CurrentValue) <> "") {
			$sFilterWrk = "`kd_akun`" . ew_SearchString("=", $this->kd_rekening_belanja->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kd_akun`, `kd_akun` AS `DispFld`, `nama_akun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
		$sWhereWrk = "";
		$this->kd_rekening_belanja->LookupFilters = array();
		$lookuptblfilter = "`akun1` = 7 and  `akun2` = 1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kd_rekening_belanja, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->kd_rekening_belanja->ViewValue = $this->kd_rekening_belanja->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kd_rekening_belanja->ViewValue = $this->kd_rekening_belanja->CurrentValue;
			}
		} else {
			$this->kd_rekening_belanja->ViewValue = NULL;
		}
		$this->kd_rekening_belanja->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		$this->akun2->ViewValue = $this->akun2->CurrentValue;
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		$this->akun3->ViewValue = $this->akun3->CurrentValue;
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		$this->akun4->ViewValue = $this->akun4->CurrentValue;
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		$this->akun5->ViewValue = $this->akun5->CurrentValue;
		$this->akun5->ViewCustomAttributes = "";

			// kd_rekening_belanja
			$this->kd_rekening_belanja->LinkCustomAttributes = "";
			$this->kd_rekening_belanja->HrefValue = "";
			$this->kd_rekening_belanja->TooltipValue = "";

			// jumlah_belanja
			$this->jumlah_belanja->LinkCustomAttributes = "";
			$this->jumlah_belanja->HrefValue = "";
			$this->jumlah_belanja->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// kd_rekening_belanja
			$this->kd_rekening_belanja->EditAttrs["class"] = "form-control";
			$this->kd_rekening_belanja->EditCustomAttributes = "";
			if (trim(strval($this->kd_rekening_belanja->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kd_akun`" . ew_SearchString("=", $this->kd_rekening_belanja->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `kd_akun`, `kd_akun` AS `DispFld`, `nama_akun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `keu_akun5`";
			$sWhereWrk = "";
			$this->kd_rekening_belanja->LookupFilters = array();
			$lookuptblfilter = "`akun1` = 7 and  `akun2` = 1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kd_rekening_belanja, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kd_rekening_belanja->EditValue = $arwrk;

			// jumlah_belanja
			$this->jumlah_belanja->EditAttrs["class"] = "form-control";
			$this->jumlah_belanja->EditCustomAttributes = "";
			$this->jumlah_belanja->EditValue = ew_HtmlEncode($this->jumlah_belanja->CurrentValue);
			$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
			if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

			// Add refer script
			// kd_rekening_belanja

			$this->kd_rekening_belanja->LinkCustomAttributes = "";
			$this->kd_rekening_belanja->HrefValue = "";

			// jumlah_belanja
			$this->jumlah_belanja->LinkCustomAttributes = "";
			$this->jumlah_belanja->HrefValue = "";
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
		if (!$this->kd_rekening_belanja->FldIsDetailKey && !is_null($this->kd_rekening_belanja->FormValue) && $this->kd_rekening_belanja->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_rekening_belanja->FldCaption(), $this->kd_rekening_belanja->ReqErrMsg));
		}
		if (!$this->jumlah_belanja->FldIsDetailKey && !is_null($this->jumlah_belanja->FormValue) && $this->jumlah_belanja->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->jumlah_belanja->FldCaption(), $this->jumlah_belanja->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->jumlah_belanja->FormValue)) {
			ew_AddMessage($gsFormError, $this->jumlah_belanja->FldErrMsg());
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

		// Check referential integrity for master table 'vw_spp_ls_kontrak_list'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_vw_spp_ls_kontrak_list();
		if ($this->id_spp->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@id@", ew_AdjustSql($this->id_spp->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->id_jenis_spp->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@id_jenis_spp@", ew_AdjustSql($this->id_jenis_spp->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->detail_jenis_spp->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@detail_jenis_spp@", ew_AdjustSql($this->detail_jenis_spp->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->no_spp->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@no_spp@", ew_AdjustSql($this->no_spp->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->program->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@kode_program@", ew_AdjustSql($this->program->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->kegiatan->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@kode_kegiatan@", ew_AdjustSql($this->kegiatan->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->sub_kegiatan->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@kode_sub_kegiatan@", ew_AdjustSql($this->sub_kegiatan->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($this->tahun_anggaran->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@tahun_anggaran@", ew_AdjustSql($this->tahun_anggaran->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["vw_spp_ls_kontrak_list"])) $GLOBALS["vw_spp_ls_kontrak_list"] = new cvw_spp_ls_kontrak_list();
			$rsmaster = $GLOBALS["vw_spp_ls_kontrak_list"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "vw_spp_ls_kontrak_list", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// kd_rekening_belanja
		$this->kd_rekening_belanja->SetDbValueDef($rsnew, $this->kd_rekening_belanja->CurrentValue, "", FALSE);

		// jumlah_belanja
		$this->jumlah_belanja->SetDbValueDef($rsnew, $this->jumlah_belanja->CurrentValue, 0, FALSE);

		// id_spp
		if ($this->id_spp->getSessionValue() <> "") {
			$rsnew['id_spp'] = $this->id_spp->getSessionValue();
		}

		// id_jenis_spp
		if ($this->id_jenis_spp->getSessionValue() <> "") {
			$rsnew['id_jenis_spp'] = $this->id_jenis_spp->getSessionValue();
		}

		// detail_jenis_spp
		if ($this->detail_jenis_spp->getSessionValue() <> "") {
			$rsnew['detail_jenis_spp'] = $this->detail_jenis_spp->getSessionValue();
		}

		// no_spp
		if ($this->no_spp->getSessionValue() <> "") {
			$rsnew['no_spp'] = $this->no_spp->getSessionValue();
		}

		// program
		if ($this->program->getSessionValue() <> "") {
			$rsnew['program'] = $this->program->getSessionValue();
		}

		// kegiatan
		if ($this->kegiatan->getSessionValue() <> "") {
			$rsnew['kegiatan'] = $this->kegiatan->getSessionValue();
		}

		// sub_kegiatan
		if ($this->sub_kegiatan->getSessionValue() <> "") {
			$rsnew['sub_kegiatan'] = $this->sub_kegiatan->getSessionValue();
		}

		// tahun_anggaran
		if ($this->tahun_anggaran->getSessionValue() <> "") {
			$rsnew['tahun_anggaran'] = $this->tahun_anggaran->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
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
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "vw_spp_ls_kontrak_list") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_id"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->id->setQueryStringValue($_GET["fk_id"]);
					$this->id_spp->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->id->QueryStringValue);
					$this->id_spp->setSessionValue($this->id_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_id_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->id_jenis_spp->setQueryStringValue($_GET["fk_id_jenis_spp"]);
					$this->id_jenis_spp->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->id_jenis_spp->QueryStringValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->id_jenis_spp->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_detail_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->detail_jenis_spp->setQueryStringValue($_GET["fk_detail_jenis_spp"]);
					$this->detail_jenis_spp->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->detail_jenis_spp->QueryStringValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->detail_jenis_spp->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_no_spp"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->no_spp->setQueryStringValue($_GET["fk_no_spp"]);
					$this->no_spp->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->no_spp->QueryStringValue);
					$this->no_spp->setSessionValue($this->no_spp->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_program"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->kode_program->setQueryStringValue($_GET["fk_kode_program"]);
					$this->program->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->kode_program->QueryStringValue);
					$this->program->setSessionValue($this->program->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->kode_kegiatan->setQueryStringValue($_GET["fk_kode_kegiatan"]);
					$this->kegiatan->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->kode_kegiatan->QueryStringValue);
					$this->kegiatan->setSessionValue($this->kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_kode_sub_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->kode_sub_kegiatan->setQueryStringValue($_GET["fk_kode_sub_kegiatan"]);
					$this->sub_kegiatan->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->kode_sub_kegiatan->QueryStringValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_tahun_anggaran"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->tahun_anggaran->setQueryStringValue($_GET["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setQueryStringValue($GLOBALS["vw_spp_ls_kontrak_list"]->tahun_anggaran->QueryStringValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->QueryStringValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->tahun_anggaran->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "vw_spp_ls_kontrak_list") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_id"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->id->setFormValue($_POST["fk_id"]);
					$this->id_spp->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->id->FormValue);
					$this->id_spp->setSessionValue($this->id_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_id_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->id_jenis_spp->setFormValue($_POST["fk_id_jenis_spp"]);
					$this->id_jenis_spp->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->id_jenis_spp->FormValue);
					$this->id_jenis_spp->setSessionValue($this->id_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->id_jenis_spp->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_detail_jenis_spp"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->detail_jenis_spp->setFormValue($_POST["fk_detail_jenis_spp"]);
					$this->detail_jenis_spp->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->detail_jenis_spp->FormValue);
					$this->detail_jenis_spp->setSessionValue($this->detail_jenis_spp->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->detail_jenis_spp->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_no_spp"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->no_spp->setFormValue($_POST["fk_no_spp"]);
					$this->no_spp->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->no_spp->FormValue);
					$this->no_spp->setSessionValue($this->no_spp->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_program"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->kode_program->setFormValue($_POST["fk_kode_program"]);
					$this->program->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->kode_program->FormValue);
					$this->program->setSessionValue($this->program->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->kode_kegiatan->setFormValue($_POST["fk_kode_kegiatan"]);
					$this->kegiatan->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->kode_kegiatan->FormValue);
					$this->kegiatan->setSessionValue($this->kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_kode_sub_kegiatan"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->kode_sub_kegiatan->setFormValue($_POST["fk_kode_sub_kegiatan"]);
					$this->sub_kegiatan->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->kode_sub_kegiatan->FormValue);
					$this->sub_kegiatan->setSessionValue($this->sub_kegiatan->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_tahun_anggaran"] <> "") {
					$GLOBALS["vw_spp_ls_kontrak_list"]->tahun_anggaran->setFormValue($_POST["fk_tahun_anggaran"]);
					$this->tahun_anggaran->setFormValue($GLOBALS["vw_spp_ls_kontrak_list"]->tahun_anggaran->FormValue);
					$this->tahun_anggaran->setSessionValue($this->tahun_anggaran->FormValue);
					if (!is_numeric($GLOBALS["vw_spp_ls_kontrak_list"]->tahun_anggaran->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "vw_spp_ls_kontrak_list") {
				if ($this->id_spp->CurrentValue == "") $this->id_spp->setSessionValue("");
				if ($this->id_jenis_spp->CurrentValue == "") $this->id_jenis_spp->setSessionValue("");
				if ($this->detail_jenis_spp->CurrentValue == "") $this->detail_jenis_spp->setSessionValue("");
				if ($this->no_spp->CurrentValue == "") $this->no_spp->setSessionValue("");
				if ($this->program->CurrentValue == "") $this->program->setSessionValue("");
				if ($this->kegiatan->CurrentValue == "") $this->kegiatan->setSessionValue("");
				if ($this->sub_kegiatan->CurrentValue == "") $this->sub_kegiatan->setSessionValue("");
				if ($this->tahun_anggaran->CurrentValue == "") $this->tahun_anggaran->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_spp_detail_pajaklist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_kd_rekening_belanja":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kd_akun` AS `LinkFld`, `kd_akun` AS `DispFld`, `nama_akun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
			$sWhereWrk = "";
			$this->kd_rekening_belanja->LookupFilters = array();
			$lookuptblfilter = "`akun1` = 7 and  `akun2` = 1";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kd_akun` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kd_rekening_belanja, $sWhereWrk); // Call Lookup selecting
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
if (!isset($vw_spp_detail_pajak_add)) $vw_spp_detail_pajak_add = new cvw_spp_detail_pajak_add();

// Page init
$vw_spp_detail_pajak_add->Page_Init();

// Page main
$vw_spp_detail_pajak_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_spp_detail_pajak_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fvw_spp_detail_pajakadd = new ew_Form("fvw_spp_detail_pajakadd", "add");

// Validate form
fvw_spp_detail_pajakadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_kd_rekening_belanja");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_detail_pajak->kd_rekening_belanja->FldCaption(), $vw_spp_detail_pajak->kd_rekening_belanja->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_spp_detail_pajak->jumlah_belanja->FldCaption(), $vw_spp_detail_pajak->jumlah_belanja->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_jumlah_belanja");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_spp_detail_pajak->jumlah_belanja->FldErrMsg()) ?>");

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
fvw_spp_detail_pajakadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_spp_detail_pajakadd.ValidateRequired = true;
<?php } else { ?>
fvw_spp_detail_pajakadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_spp_detail_pajakadd.Lists["x_kd_rekening_belanja"] = {"LinkField":"x_kd_akun","Ajax":true,"AutoFill":false,"DisplayFields":["x_kd_akun","x_nama_akun","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"keu_akun5"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_spp_detail_pajak_add->IsModal) { ?>
<?php } ?>
<?php $vw_spp_detail_pajak_add->ShowPageHeader(); ?>
<?php
$vw_spp_detail_pajak_add->ShowMessage();
?>
<form name="fvw_spp_detail_pajakadd" id="fvw_spp_detail_pajakadd" class="<?php echo $vw_spp_detail_pajak_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_spp_detail_pajak_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_spp_detail_pajak_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_spp_detail_pajak">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($vw_spp_detail_pajak_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php if ($vw_spp_detail_pajak->getCurrentMasterTable() == "vw_spp_ls_kontrak_list") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="vw_spp_ls_kontrak_list">
<input type="hidden" name="fk_id" value="<?php echo $vw_spp_detail_pajak->id_spp->getSessionValue() ?>">
<input type="hidden" name="fk_id_jenis_spp" value="<?php echo $vw_spp_detail_pajak->id_jenis_spp->getSessionValue() ?>">
<input type="hidden" name="fk_detail_jenis_spp" value="<?php echo $vw_spp_detail_pajak->detail_jenis_spp->getSessionValue() ?>">
<input type="hidden" name="fk_no_spp" value="<?php echo $vw_spp_detail_pajak->no_spp->getSessionValue() ?>">
<input type="hidden" name="fk_kode_program" value="<?php echo $vw_spp_detail_pajak->program->getSessionValue() ?>">
<input type="hidden" name="fk_kode_kegiatan" value="<?php echo $vw_spp_detail_pajak->kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_kode_sub_kegiatan" value="<?php echo $vw_spp_detail_pajak->sub_kegiatan->getSessionValue() ?>">
<input type="hidden" name="fk_tahun_anggaran" value="<?php echo $vw_spp_detail_pajak->tahun_anggaran->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($vw_spp_detail_pajak->kd_rekening_belanja->Visible) { // kd_rekening_belanja ?>
	<div id="r_kd_rekening_belanja" class="form-group">
		<label id="elh_vw_spp_detail_pajak_kd_rekening_belanja" for="x_kd_rekening_belanja" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_detail_pajak->kd_rekening_belanja->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_detail_pajak->kd_rekening_belanja->CellAttributes() ?>>
<span id="el_vw_spp_detail_pajak_kd_rekening_belanja">
<select data-table="vw_spp_detail_pajak" data-field="x_kd_rekening_belanja" data-value-separator="<?php echo $vw_spp_detail_pajak->kd_rekening_belanja->DisplayValueSeparatorAttribute() ?>" id="x_kd_rekening_belanja" name="x_kd_rekening_belanja"<?php echo $vw_spp_detail_pajak->kd_rekening_belanja->EditAttributes() ?>>
<?php echo $vw_spp_detail_pajak->kd_rekening_belanja->SelectOptionListHtml("x_kd_rekening_belanja") ?>
</select>
<input type="hidden" name="s_x_kd_rekening_belanja" id="s_x_kd_rekening_belanja" value="<?php echo $vw_spp_detail_pajak->kd_rekening_belanja->LookupFilterQuery() ?>">
</span>
<?php echo $vw_spp_detail_pajak->kd_rekening_belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_spp_detail_pajak->jumlah_belanja->Visible) { // jumlah_belanja ?>
	<div id="r_jumlah_belanja" class="form-group">
		<label id="elh_vw_spp_detail_pajak_jumlah_belanja" for="x_jumlah_belanja" class="col-sm-2 control-label ewLabel"><?php echo $vw_spp_detail_pajak->jumlah_belanja->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $vw_spp_detail_pajak->jumlah_belanja->CellAttributes() ?>>
<span id="el_vw_spp_detail_pajak_jumlah_belanja">
<input type="text" data-table="vw_spp_detail_pajak" data-field="x_jumlah_belanja" name="x_jumlah_belanja" id="x_jumlah_belanja" size="30" placeholder="<?php echo ew_HtmlEncode($vw_spp_detail_pajak->jumlah_belanja->getPlaceHolder()) ?>" value="<?php echo $vw_spp_detail_pajak->jumlah_belanja->EditValue ?>"<?php echo $vw_spp_detail_pajak->jumlah_belanja->EditAttributes() ?>>
</span>
<?php echo $vw_spp_detail_pajak->jumlah_belanja->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($vw_spp_detail_pajak->id_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_id_spp" id="x_id_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->id_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_detail_pajak->id_jenis_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_id_jenis_spp" id="x_id_jenis_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->id_jenis_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_detail_pajak->detail_jenis_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_detail_jenis_spp" id="x_detail_jenis_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->detail_jenis_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_detail_pajak->no_spp->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_no_spp" id="x_no_spp" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->no_spp->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_detail_pajak->program->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_program" id="x_program" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->program->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_detail_pajak->kegiatan->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_kegiatan" id="x_kegiatan" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->kegiatan->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_detail_pajak->sub_kegiatan->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_sub_kegiatan" id="x_sub_kegiatan" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->sub_kegiatan->getSessionValue())) ?>">
<?php } ?>
<?php if (strval($vw_spp_detail_pajak->tahun_anggaran->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_tahun_anggaran" id="x_tahun_anggaran" value="<?php echo ew_HtmlEncode(strval($vw_spp_detail_pajak->tahun_anggaran->getSessionValue())) ?>">
<?php } ?>
<?php if (!$vw_spp_detail_pajak_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_spp_detail_pajak_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_spp_detail_pajakadd.Init();
</script>
<?php
$vw_spp_detail_pajak_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_spp_detail_pajak_add->Page_Terminate();
?>
