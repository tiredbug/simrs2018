<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_set_tanggal_pulanginfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_set_tanggal_pulang_edit = NULL; // Initialize page object first

class cvw_set_tanggal_pulang_edit extends cvw_set_tanggal_pulang {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_set_tanggal_pulang';

	// Page object name
	var $PageObjName = 'vw_set_tanggal_pulang_edit';

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

		// Table object (vw_set_tanggal_pulang)
		if (!isset($GLOBALS["vw_set_tanggal_pulang"]) || get_class($GLOBALS["vw_set_tanggal_pulang"]) == "cvw_set_tanggal_pulang") {
			$GLOBALS["vw_set_tanggal_pulang"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_set_tanggal_pulang"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_set_tanggal_pulang', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_set_tanggal_pulanglist.php"));
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
		if (@$_POST["customexport"] == "") {

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		global $EW_EXPORT, $vw_set_tanggal_pulang;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_set_tanggal_pulang);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
	if ($this->CustomExport <> "") { // Save temp images array for custom export
		if (is_array($gTmpImages))
			$_SESSION[EW_SESSION_TEMP_IMAGES] = $gTmpImages;
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
		if (@$_GET["id_admission"] <> "") {
			$this->id_admission->setQueryStringValue($_GET["id_admission"]);
		}

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id_admission->CurrentValue == "") {
			$this->Page_Terminate("vw_set_tanggal_pulanglist.php"); // Invalid key, return to list
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
					$this->Page_Terminate("vw_set_tanggal_pulanglist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "vw_set_tanggal_pulanglist.php")
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
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nomr->FldIsDetailKey) {
			$this->nomr->setFormValue($objForm->GetValue("x_nomr"));
		}
		if (!$this->ket_nama->FldIsDetailKey) {
			$this->ket_nama->setFormValue($objForm->GetValue("x_ket_nama"));
		}
		if (!$this->ket_alamat->FldIsDetailKey) {
			$this->ket_alamat->setFormValue($objForm->GetValue("x_ket_alamat"));
		}
		if (!$this->statusbayar->FldIsDetailKey) {
			$this->statusbayar->setFormValue($objForm->GetValue("x_statusbayar"));
		}
		if (!$this->masukrs->FldIsDetailKey) {
			$this->masukrs->setFormValue($objForm->GetValue("x_masukrs"));
			$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 0);
		}
		if (!$this->noruang->FldIsDetailKey) {
			$this->noruang->setFormValue($objForm->GetValue("x_noruang"));
		}
		if (!$this->keluarrs->FldIsDetailKey) {
			$this->keluarrs->setFormValue($objForm->GetValue("x_keluarrs"));
			$this->keluarrs->CurrentValue = ew_UnFormatDateTime($this->keluarrs->CurrentValue, 17);
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey) {
			$this->tempat_tidur_id->setFormValue($objForm->GetValue("x_tempat_tidur_id"));
		}
		if (!$this->icd_keluar->FldIsDetailKey) {
			$this->icd_keluar->setFormValue($objForm->GetValue("x_icd_keluar"));
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey) {
			$this->dokter_penanggungjawab->setFormValue($objForm->GetValue("x_dokter_penanggungjawab"));
		}
		if (!$this->KELASPERAWATAN_ID->FldIsDetailKey) {
			$this->KELASPERAWATAN_ID->setFormValue($objForm->GetValue("x_KELASPERAWATAN_ID"));
		}
		if (!$this->NO_SKP->FldIsDetailKey) {
			$this->NO_SKP->setFormValue($objForm->GetValue("x_NO_SKP"));
		}
		if (!$this->statuskeluarranap_id->FldIsDetailKey) {
			$this->statuskeluarranap_id->setFormValue($objForm->GetValue("x_statuskeluarranap_id"));
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
		$this->ket_nama->CurrentValue = $this->ket_nama->FormValue;
		$this->ket_alamat->CurrentValue = $this->ket_alamat->FormValue;
		$this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
		$this->masukrs->CurrentValue = $this->masukrs->FormValue;
		$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 0);
		$this->noruang->CurrentValue = $this->noruang->FormValue;
		$this->keluarrs->CurrentValue = $this->keluarrs->FormValue;
		$this->keluarrs->CurrentValue = ew_UnFormatDateTime($this->keluarrs->CurrentValue, 17);
		$this->tempat_tidur_id->CurrentValue = $this->tempat_tidur_id->FormValue;
		$this->icd_keluar->CurrentValue = $this->icd_keluar->FormValue;
		$this->dokter_penanggungjawab->CurrentValue = $this->dokter_penanggungjawab->FormValue;
		$this->KELASPERAWATAN_ID->CurrentValue = $this->KELASPERAWATAN_ID->FormValue;
		$this->NO_SKP->CurrentValue = $this->NO_SKP->FormValue;
		$this->statuskeluarranap_id->CurrentValue = $this->statuskeluarranap_id->FormValue;
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
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->ket_nama->DbValue = $row['ket_nama'];
		$this->ket_alamat->DbValue = $row['ket_alamat'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->keluarrs->DbValue = $row['keluarrs'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->icd_keluar->DbValue = $row['icd_keluar'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->statuskeluarranap_id->DbValue = $row['statuskeluarranap_id'];
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
		// ket_alamat
		// statusbayar
		// masukrs
		// noruang
		// keluarrs
		// tempat_tidur_id
		// icd_keluar
		// dokter_penanggungjawab
		// KELASPERAWATAN_ID
		// NO_SKP
		// statuskeluarranap_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
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

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 0);
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

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 17);
		$this->keluarrs->ViewCustomAttributes = "";

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

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		if (strval($this->icd_keluar->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_keluar->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `icd_eklaim`";
		$sWhereWrk = "";
		$this->icd_keluar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_keluar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_keluar->ViewValue = $this->icd_keluar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
			}
		} else {
			$this->icd_keluar->ViewValue = NULL;
		}
		$this->icd_keluar->ViewCustomAttributes = "";

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

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// statuskeluarranap_id
		if (strval($this->statuskeluarranap_id->CurrentValue) <> "") {
			$sFilterWrk = "`status`" . ew_SearchString("=", $this->statuskeluarranap_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `status`, `keterangan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_statuskeluar`";
		$sWhereWrk = "";
		$this->statuskeluarranap_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statuskeluarranap_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
			}
		} else {
			$this->statuskeluarranap_id->ViewValue = NULL;
		}
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// ket_nama
			$this->ket_nama->LinkCustomAttributes = "";
			$this->ket_nama->HrefValue = "";
			$this->ket_nama->TooltipValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";
			$this->ket_alamat->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";
			$this->masukrs->TooltipValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";
			$this->noruang->TooltipValue = "";

			// keluarrs
			$this->keluarrs->LinkCustomAttributes = "";
			$this->keluarrs->HrefValue = "";
			$this->keluarrs->TooltipValue = "";

			// tempat_tidur_id
			$this->tempat_tidur_id->LinkCustomAttributes = "";
			$this->tempat_tidur_id->HrefValue = "";
			$this->tempat_tidur_id->TooltipValue = "";

			// icd_keluar
			$this->icd_keluar->LinkCustomAttributes = "";
			$this->icd_keluar->HrefValue = "";
			$this->icd_keluar->TooltipValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";
			$this->dokter_penanggungjawab->TooltipValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// NO_SKP
			$this->NO_SKP->LinkCustomAttributes = "";
			$this->NO_SKP->HrefValue = "";
			$this->NO_SKP->TooltipValue = "";

			// statuskeluarranap_id
			$this->statuskeluarranap_id->LinkCustomAttributes = "";
			$this->statuskeluarranap_id->HrefValue = "";
			$this->statuskeluarranap_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			$this->nomr->EditValue = $this->nomr->CurrentValue;
			$this->nomr->ViewCustomAttributes = "";

			// ket_nama
			$this->ket_nama->EditAttrs["class"] = "form-control";
			$this->ket_nama->EditCustomAttributes = "";
			$this->ket_nama->EditValue = $this->ket_nama->CurrentValue;
			$this->ket_nama->ViewCustomAttributes = "";

			// ket_alamat
			$this->ket_alamat->EditAttrs["class"] = "form-control";
			$this->ket_alamat->EditCustomAttributes = "";
			$this->ket_alamat->EditValue = $this->ket_alamat->CurrentValue;
			$this->ket_alamat->ViewCustomAttributes = "";

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			$this->statusbayar->EditValue = $this->statusbayar->CurrentValue;
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

			// masukrs
			$this->masukrs->EditAttrs["class"] = "form-control";
			$this->masukrs->EditCustomAttributes = "";
			$this->masukrs->EditValue = $this->masukrs->CurrentValue;
			$this->masukrs->EditValue = ew_FormatDateTime($this->masukrs->EditValue, 0);
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

			// keluarrs
			$this->keluarrs->EditAttrs["class"] = "form-control";
			$this->keluarrs->EditCustomAttributes = "";
			$this->keluarrs->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->keluarrs->CurrentValue, 17));
			$this->keluarrs->PlaceHolder = ew_RemoveHtml($this->keluarrs->FldCaption());

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

			// icd_keluar
			$this->icd_keluar->EditAttrs["class"] = "form-control";
			$this->icd_keluar->EditCustomAttributes = "";
			$this->icd_keluar->EditValue = ew_HtmlEncode($this->icd_keluar->CurrentValue);
			if (strval($this->icd_keluar->CurrentValue) <> "") {
				$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_keluar->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `icd_eklaim`";
			$sWhereWrk = "";
			$this->icd_keluar->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->icd_keluar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->icd_keluar->EditValue = $this->icd_keluar->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->icd_keluar->EditValue = ew_HtmlEncode($this->icd_keluar->CurrentValue);
				}
			} else {
				$this->icd_keluar->EditValue = NULL;
			}
			$this->icd_keluar->PlaceHolder = ew_RemoveHtml($this->icd_keluar->FldCaption());

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->EditAttrs["class"] = "form-control";
			$this->dokter_penanggungjawab->EditCustomAttributes = "";
			if (trim(strval($this->dokter_penanggungjawab->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokter_penanggungjawab->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokter_penanggungjawab->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->dokter_penanggungjawab->EditValue = $arwrk;

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->EditAttrs["class"] = "form-control";
			$this->KELASPERAWATAN_ID->EditCustomAttributes = "";
			$this->KELASPERAWATAN_ID->EditValue = $this->KELASPERAWATAN_ID->CurrentValue;
			$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

			// NO_SKP
			$this->NO_SKP->EditAttrs["class"] = "form-control";
			$this->NO_SKP->EditCustomAttributes = "";
			$this->NO_SKP->EditValue = $this->NO_SKP->CurrentValue;
			$this->NO_SKP->ViewCustomAttributes = "";

			// statuskeluarranap_id
			$this->statuskeluarranap_id->EditAttrs["class"] = "form-control";
			$this->statuskeluarranap_id->EditCustomAttributes = "";
			if (trim(strval($this->statuskeluarranap_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`status`" . ew_SearchString("=", $this->statuskeluarranap_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `status`, `keterangan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_statuskeluar`";
			$sWhereWrk = "";
			$this->statuskeluarranap_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->statuskeluarranap_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->statuskeluarranap_id->EditValue = $arwrk;

			// Edit refer script
			// nomr

			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// ket_nama
			$this->ket_nama->LinkCustomAttributes = "";
			$this->ket_nama->HrefValue = "";
			$this->ket_nama->TooltipValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";
			$this->ket_alamat->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";
			$this->masukrs->TooltipValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";

			// keluarrs
			$this->keluarrs->LinkCustomAttributes = "";
			$this->keluarrs->HrefValue = "";

			// tempat_tidur_id
			$this->tempat_tidur_id->LinkCustomAttributes = "";
			$this->tempat_tidur_id->HrefValue = "";

			// icd_keluar
			$this->icd_keluar->LinkCustomAttributes = "";
			$this->icd_keluar->HrefValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// NO_SKP
			$this->NO_SKP->LinkCustomAttributes = "";
			$this->NO_SKP->HrefValue = "";
			$this->NO_SKP->TooltipValue = "";

			// statuskeluarranap_id
			$this->statuskeluarranap_id->LinkCustomAttributes = "";
			$this->statuskeluarranap_id->HrefValue = "";
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
		if (!$this->keluarrs->FldIsDetailKey && !is_null($this->keluarrs->FormValue) && $this->keluarrs->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->keluarrs->FldCaption(), $this->keluarrs->ReqErrMsg));
		}
		if (!ew_CheckShortEuroDate($this->keluarrs->FormValue)) {
			ew_AddMessage($gsFormError, $this->keluarrs->FldErrMsg());
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey && !is_null($this->tempat_tidur_id->FormValue) && $this->tempat_tidur_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tempat_tidur_id->FldCaption(), $this->tempat_tidur_id->ReqErrMsg));
		}
		if (!$this->icd_keluar->FldIsDetailKey && !is_null($this->icd_keluar->FormValue) && $this->icd_keluar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->icd_keluar->FldCaption(), $this->icd_keluar->ReqErrMsg));
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey && !is_null($this->dokter_penanggungjawab->FormValue) && $this->dokter_penanggungjawab->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dokter_penanggungjawab->FldCaption(), $this->dokter_penanggungjawab->ReqErrMsg));
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

			// noruang
			$this->noruang->SetDbValueDef($rsnew, $this->noruang->CurrentValue, 0, $this->noruang->ReadOnly);

			// keluarrs
			$this->keluarrs->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->keluarrs->CurrentValue, 17), NULL, $this->keluarrs->ReadOnly);

			// tempat_tidur_id
			$this->tempat_tidur_id->SetDbValueDef($rsnew, $this->tempat_tidur_id->CurrentValue, 0, $this->tempat_tidur_id->ReadOnly);

			// icd_keluar
			$this->icd_keluar->SetDbValueDef($rsnew, $this->icd_keluar->CurrentValue, NULL, $this->icd_keluar->ReadOnly);

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->SetDbValueDef($rsnew, $this->dokter_penanggungjawab->CurrentValue, 0, $this->dokter_penanggungjawab->ReadOnly);

			// statuskeluarranap_id
			$this->statuskeluarranap_id->SetDbValueDef($rsnew, $this->statuskeluarranap_id->CurrentValue, NULL, $this->statuskeluarranap_id->ReadOnly);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_set_tanggal_pulanglist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
		case "x_icd_keluar":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE` AS `LinkFld`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `icd_eklaim`";
			$sWhereWrk = "{filter}";
			$this->icd_keluar->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`CODE` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->icd_keluar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_dokter_penanggungjawab":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokter_penanggungjawab->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KDDOKTER` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_statuskeluarranap_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `status` AS `LinkFld`, `keterangan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_statuskeluar`";
			$sWhereWrk = "";
			$this->statuskeluarranap_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`status` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->statuskeluarranap_id, $sWhereWrk); // Call Lookup selecting
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
		case "x_icd_keluar":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld` FROM `icd_eklaim`";
			$sWhereWrk = "`CODE` LIKE '%{query_value}%' OR `STR` LIKE '%{query_value}%' OR CONCAT(`CODE`,'" . ew_ValueSeparator(1, $this->icd_keluar) . "',`STR`) LIKE '{query_value}%'";
			$this->icd_keluar->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->icd_keluar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($vw_set_tanggal_pulang_edit)) $vw_set_tanggal_pulang_edit = new cvw_set_tanggal_pulang_edit();

// Page init
$vw_set_tanggal_pulang_edit->Page_Init();

// Page main
$vw_set_tanggal_pulang_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_set_tanggal_pulang_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fvw_set_tanggal_pulangedit = new ew_Form("fvw_set_tanggal_pulangedit", "edit");

// Validate form
fvw_set_tanggal_pulangedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_set_tanggal_pulang->noruang->FldCaption(), $vw_set_tanggal_pulang->noruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_keluarrs");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_set_tanggal_pulang->keluarrs->FldCaption(), $vw_set_tanggal_pulang->keluarrs->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_keluarrs");
			if (elm && !ew_CheckShortEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($vw_set_tanggal_pulang->keluarrs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tempat_tidur_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_set_tanggal_pulang->tempat_tidur_id->FldCaption(), $vw_set_tanggal_pulang->tempat_tidur_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_icd_keluar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_set_tanggal_pulang->icd_keluar->FldCaption(), $vw_set_tanggal_pulang->icd_keluar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dokter_penanggungjawab");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $vw_set_tanggal_pulang->dokter_penanggungjawab->FldCaption(), $vw_set_tanggal_pulang->dokter_penanggungjawab->ReqErrMsg)) ?>");

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
fvw_set_tanggal_pulangedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_set_tanggal_pulangedit.ValidateRequired = true;
<?php } else { ?>
fvw_set_tanggal_pulangedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_set_tanggal_pulangedit.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
fvw_set_tanggal_pulangedit.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
fvw_set_tanggal_pulangedit.Lists["x_tempat_tidur_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_tt","","",""],"ParentFields":["x_noruang"],"ChildFields":[],"FilterFields":["x_idxruang"],"Options":[],"Template":"","LinkTable":"m_detail_tempat_tidur"};
fvw_set_tanggal_pulangedit.Lists["x_icd_keluar"] = {"LinkField":"x_CODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_CODE","x_STR","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"icd_eklaim"};
fvw_set_tanggal_pulangedit.Lists["x_dokter_penanggungjawab"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
fvw_set_tanggal_pulangedit.Lists["x_statuskeluarranap_id"] = {"LinkField":"x_status","Ajax":true,"AutoFill":false,"DisplayFields":["x_keterangan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_statuskeluar"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_set_tanggal_pulang_edit->IsModal) { ?>
<?php } ?>
<?php $vw_set_tanggal_pulang_edit->ShowPageHeader(); ?>
<?php
$vw_set_tanggal_pulang_edit->ShowMessage();
?>
<form name="fvw_set_tanggal_pulangedit" id="fvw_set_tanggal_pulangedit" class="<?php echo $vw_set_tanggal_pulang_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_set_tanggal_pulang_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_set_tanggal_pulang_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_set_tanggal_pulang">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($vw_set_tanggal_pulang_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="tpd_vw_set_tanggal_pulangedit" class="ewCustomTemplate"></div>
<script id="tpm_vw_set_tanggal_pulangedit" type="text/html">
<div id="ct_vw_set_tanggal_pulang_edit"><div id="ct_sample_add">
<div class="ewRow">
<div class="panel panel-default">
  <div class="panel-heading"><strong>Form</strong></div>
  <div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->nomr->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_nomr"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->ket_nama->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_ket_nama"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_One" for="x_Field_One" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->ket_alamat->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_ket_alamat"/}}</div>
	</div>
	<div id="r_Field_Two" class="form-group">
	<label id="elh_sample_Field_Two" for="x_Field_Two" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->statusbayar->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_statusbayar"/}}</div>
	</div>
	<div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->masukrs->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_masukrs"/}}</div>
	</div>
	 <div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_KELASPERAWATAN_ID"/}}</div>
	</div>
	 <div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->NO_SKP->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_NO_SKP"/}}</div>
	</div> 
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6">
	<div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->keluarrs->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_keluarrs"/}}</div>
	</div>
	 <div id="r_Field_Three" class="form-group">
	<label id="elh_sample_Field_Three" for="x_Field_Three" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->noruang->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_noruang"/}}</div>
	</div>
	<div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->tempat_tidur_id->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_tempat_tidur_id"/}}</div>
	</div>
	<div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->icd_keluar->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_icd_keluar"/}}</div>
	</div>
	<div id="r_Field_Five" class="form-group">
	<label id="elh_sample_Field_Five" for="x_Field_Five" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_dokter_penanggungjawab"/}}</div>
	</div> 
	<div id="r_Field_Four" class="form-group">
	<label id="elh_sample_Field_Four" for="x_Field_Four" class="col-sm-3 control-label ewLabel">
	<?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->FldCaption() ?></label>
	<div class="col-sm-8">{{include tmpl="#tpx_vw_set_tanggal_pulang_statuskeluarranap_id"/}}</div>
	</div>
  </div>
</div>
</div>
</div>
</div>
</script>
<div style="display: none">
<?php if ($vw_set_tanggal_pulang->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_nomr" for="x_nomr" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_nomr" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->nomr->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->nomr->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_nomr" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_nomr">
<span<?php echo $vw_set_tanggal_pulang->nomr->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_set_tanggal_pulang->nomr->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_nomr" name="x_nomr" id="x_nomr" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->nomr->CurrentValue) ?>">
<?php echo $vw_set_tanggal_pulang->nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->ket_nama->Visible) { // ket_nama ?>
	<div id="r_ket_nama" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_ket_nama" for="x_ket_nama" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_ket_nama" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->ket_nama->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->ket_nama->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_ket_nama" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_ket_nama">
<span<?php echo $vw_set_tanggal_pulang->ket_nama->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_set_tanggal_pulang->ket_nama->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_ket_nama" name="x_ket_nama" id="x_ket_nama" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->ket_nama->CurrentValue) ?>">
<?php echo $vw_set_tanggal_pulang->ket_nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->ket_alamat->Visible) { // ket_alamat ?>
	<div id="r_ket_alamat" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_ket_alamat" for="x_ket_alamat" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_ket_alamat" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->ket_alamat->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->ket_alamat->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_ket_alamat" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_ket_alamat">
<span<?php echo $vw_set_tanggal_pulang->ket_alamat->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_set_tanggal_pulang->ket_alamat->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_ket_alamat" name="x_ket_alamat" id="x_ket_alamat" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->ket_alamat->CurrentValue) ?>">
<?php echo $vw_set_tanggal_pulang->ket_alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->statusbayar->Visible) { // statusbayar ?>
	<div id="r_statusbayar" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_statusbayar" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_statusbayar" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->statusbayar->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->statusbayar->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_statusbayar" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_statusbayar">
<span<?php echo $vw_set_tanggal_pulang->statusbayar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_set_tanggal_pulang->statusbayar->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_statusbayar" name="x_statusbayar" id="x_statusbayar" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->statusbayar->CurrentValue) ?>">
<script type="text/html" class="vw_set_tanggal_pulangedit_js">
fvw_set_tanggal_pulangedit.CreateAutoSuggest({"id":"x_statusbayar","forceSelect":false});
</script>
<?php echo $vw_set_tanggal_pulang->statusbayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->masukrs->Visible) { // masukrs ?>
	<div id="r_masukrs" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_masukrs" for="x_masukrs" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_masukrs" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->masukrs->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->masukrs->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_masukrs" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_masukrs">
<span<?php echo $vw_set_tanggal_pulang->masukrs->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_set_tanggal_pulang->masukrs->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_masukrs" name="x_masukrs" id="x_masukrs" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->masukrs->CurrentValue) ?>">
<?php echo $vw_set_tanggal_pulang->masukrs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->noruang->Visible) { // noruang ?>
	<div id="r_noruang" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_noruang" for="x_noruang" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_noruang" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->noruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->noruang->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_noruang" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_noruang">
<?php $vw_set_tanggal_pulang->noruang->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$vw_set_tanggal_pulang->noruang->EditAttrs["onchange"]; ?>
<select data-table="vw_set_tanggal_pulang" data-field="x_noruang" data-value-separator="<?php echo $vw_set_tanggal_pulang->noruang->DisplayValueSeparatorAttribute() ?>" id="x_noruang" name="x_noruang"<?php echo $vw_set_tanggal_pulang->noruang->EditAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->noruang->SelectOptionListHtml("x_noruang") ?>
</select>
<input type="hidden" name="s_x_noruang" id="s_x_noruang" value="<?php echo $vw_set_tanggal_pulang->noruang->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_set_tanggal_pulang->noruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->keluarrs->Visible) { // keluarrs ?>
	<div id="r_keluarrs" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_keluarrs" for="x_keluarrs" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_keluarrs" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->keluarrs->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->keluarrs->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_keluarrs" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_keluarrs">
<input type="text" data-table="vw_set_tanggal_pulang" data-field="x_keluarrs" data-format="17" name="x_keluarrs" id="x_keluarrs" placeholder="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->keluarrs->getPlaceHolder()) ?>" value="<?php echo $vw_set_tanggal_pulang->keluarrs->EditValue ?>"<?php echo $vw_set_tanggal_pulang->keluarrs->EditAttributes() ?>>
<?php if (!$vw_set_tanggal_pulang->keluarrs->ReadOnly && !$vw_set_tanggal_pulang->keluarrs->Disabled && !isset($vw_set_tanggal_pulang->keluarrs->EditAttrs["readonly"]) && !isset($vw_set_tanggal_pulang->keluarrs->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="vw_set_tanggal_pulangedit_js">
ew_CreateCalendar("fvw_set_tanggal_pulangedit", "x_keluarrs", 17);
</script>
<?php echo $vw_set_tanggal_pulang->keluarrs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->tempat_tidur_id->Visible) { // tempat_tidur_id ?>
	<div id="r_tempat_tidur_id" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_tempat_tidur_id" for="x_tempat_tidur_id" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_tempat_tidur_id" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->tempat_tidur_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->tempat_tidur_id->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_tempat_tidur_id" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_tempat_tidur_id">
<select data-table="vw_set_tanggal_pulang" data-field="x_tempat_tidur_id" data-value-separator="<?php echo $vw_set_tanggal_pulang->tempat_tidur_id->DisplayValueSeparatorAttribute() ?>" id="x_tempat_tidur_id" name="x_tempat_tidur_id"<?php echo $vw_set_tanggal_pulang->tempat_tidur_id->EditAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->tempat_tidur_id->SelectOptionListHtml("x_tempat_tidur_id") ?>
</select>
<input type="hidden" name="s_x_tempat_tidur_id" id="s_x_tempat_tidur_id" value="<?php echo $vw_set_tanggal_pulang->tempat_tidur_id->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_set_tanggal_pulang->tempat_tidur_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->icd_keluar->Visible) { // icd_keluar ?>
	<div id="r_icd_keluar" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_icd_keluar" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_icd_keluar" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->icd_keluar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->icd_keluar->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_icd_keluar" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_icd_keluar">
<?php
$wrkonchange = trim(" " . @$vw_set_tanggal_pulang->icd_keluar->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_set_tanggal_pulang->icd_keluar->EditAttrs["onchange"] = "";
?>
<span id="as_x_icd_keluar" style="white-space: nowrap; z-index: 8900">
	<input type="text" name="sv_x_icd_keluar" id="sv_x_icd_keluar" value="<?php echo $vw_set_tanggal_pulang->icd_keluar->EditValue ?>" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->icd_keluar->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->icd_keluar->getPlaceHolder()) ?>"<?php echo $vw_set_tanggal_pulang->icd_keluar->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_icd_keluar" data-value-separator="<?php echo $vw_set_tanggal_pulang->icd_keluar->DisplayValueSeparatorAttribute() ?>" name="x_icd_keluar" id="x_icd_keluar" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->icd_keluar->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_icd_keluar" id="q_x_icd_keluar" value="<?php echo $vw_set_tanggal_pulang->icd_keluar->LookupFilterQuery(true) ?>">
</span>
</script>
<script type="text/html" class="vw_set_tanggal_pulangedit_js">
fvw_set_tanggal_pulangedit.CreateAutoSuggest({"id":"x_icd_keluar","forceSelect":false});
</script>
<?php echo $vw_set_tanggal_pulang->icd_keluar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->dokter_penanggungjawab->Visible) { // dokter_penanggungjawab ?>
	<div id="r_dokter_penanggungjawab" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_dokter_penanggungjawab" for="x_dokter_penanggungjawab" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_dokter_penanggungjawab" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_dokter_penanggungjawab" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_dokter_penanggungjawab">
<select data-table="vw_set_tanggal_pulang" data-field="x_dokter_penanggungjawab" data-value-separator="<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->DisplayValueSeparatorAttribute() ?>" id="x_dokter_penanggungjawab" name="x_dokter_penanggungjawab"<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->EditAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->SelectOptionListHtml("x_dokter_penanggungjawab") ?>
</select>
<input type="hidden" name="s_x_dokter_penanggungjawab" id="s_x_dokter_penanggungjawab" value="<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_set_tanggal_pulang->dokter_penanggungjawab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<div id="r_KELASPERAWATAN_ID" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_KELASPERAWATAN_ID" for="x_KELASPERAWATAN_ID" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_KELASPERAWATAN_ID" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_KELASPERAWATAN_ID" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_KELASPERAWATAN_ID">
<span<?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_KELASPERAWATAN_ID" name="x_KELASPERAWATAN_ID" id="x_KELASPERAWATAN_ID" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->KELASPERAWATAN_ID->CurrentValue) ?>">
<?php echo $vw_set_tanggal_pulang->KELASPERAWATAN_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->NO_SKP->Visible) { // NO_SKP ?>
	<div id="r_NO_SKP" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_NO_SKP" for="x_NO_SKP" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_NO_SKP" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->NO_SKP->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->NO_SKP->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_NO_SKP" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_NO_SKP">
<span<?php echo $vw_set_tanggal_pulang->NO_SKP->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $vw_set_tanggal_pulang->NO_SKP->EditValue ?></p></span>
</span>
</script>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_NO_SKP" name="x_NO_SKP" id="x_NO_SKP" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->NO_SKP->CurrentValue) ?>">
<?php echo $vw_set_tanggal_pulang->NO_SKP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($vw_set_tanggal_pulang->statuskeluarranap_id->Visible) { // statuskeluarranap_id ?>
	<div id="r_statuskeluarranap_id" class="form-group">
		<label id="elh_vw_set_tanggal_pulang_statuskeluarranap_id" for="x_statuskeluarranap_id" class="col-sm-2 control-label ewLabel"><script id="tpc_vw_set_tanggal_pulang_statuskeluarranap_id" class="vw_set_tanggal_pulangedit" type="text/html"><span><?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->FldCaption() ?></span></script></label>
		<div class="col-sm-10"><div<?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->CellAttributes() ?>>
<script id="tpx_vw_set_tanggal_pulang_statuskeluarranap_id" class="vw_set_tanggal_pulangedit" type="text/html">
<span id="el_vw_set_tanggal_pulang_statuskeluarranap_id">
<select data-table="vw_set_tanggal_pulang" data-field="x_statuskeluarranap_id" data-value-separator="<?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->DisplayValueSeparatorAttribute() ?>" id="x_statuskeluarranap_id" name="x_statuskeluarranap_id"<?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->EditAttributes() ?>>
<?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->SelectOptionListHtml("x_statuskeluarranap_id") ?>
</select>
<input type="hidden" name="s_x_statuskeluarranap_id" id="s_x_statuskeluarranap_id" value="<?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->LookupFilterQuery() ?>">
</span>
</script>
<?php echo $vw_set_tanggal_pulang->statuskeluarranap_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="vw_set_tanggal_pulang" data-field="x_id_admission" name="x_id_admission" id="x_id_admission" value="<?php echo ew_HtmlEncode($vw_set_tanggal_pulang->id_admission->CurrentValue) ?>">
<?php if (!$vw_set_tanggal_pulang_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $vw_set_tanggal_pulang_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ew_ApplyTemplate("tpd_vw_set_tanggal_pulangedit", "tpm_vw_set_tanggal_pulangedit", "vw_set_tanggal_pulangedit", "<?php echo $vw_set_tanggal_pulang->CustomExport ?>");
jQuery("script.vw_set_tanggal_pulangedit_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
fvw_set_tanggal_pulangedit.Init();
</script>
<?php
$vw_set_tanggal_pulang_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_set_tanggal_pulang_edit->Page_Terminate();
?>
