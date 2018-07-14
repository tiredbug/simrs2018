<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_sepinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_sep_search = NULL; // Initialize page object first

class ct_sep_search extends ct_sep {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sep';

	// Page object name
	var $PageObjName = 't_sep_search';

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

		// Table object (t_sep)
		if (!isset($GLOBALS["t_sep"]) || get_class($GLOBALS["t_sep"]) == "ct_sep") {
			$GLOBALS["t_sep"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_sep"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_sep', TRUE);

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
		if (!$Security->CanSearch()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("t_seplist.php"));
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
		$this->nomer_sep->SetVisibility();
		$this->nomr->SetVisibility();
		$this->jenis_layanan->SetVisibility();
		$this->flag_proc->SetVisibility();
		$this->poli_eksekutif->SetVisibility();
		$this->cob->SetVisibility();
		$this->penjamin_laka->SetVisibility();
		$this->no_telp->SetVisibility();
		$this->status_kepesertaan_bpjs->SetVisibility();
		$this->faskes_id->SetVisibility();
		$this->nama_layanan->SetVisibility();
		$this->nama_kelas->SetVisibility();
		$this->table_source->SetVisibility();

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
		global $EW_EXPORT, $t_sep;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_sep);
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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "t_seplist.php" . "?" . $sSrchStr;
						$this->Page_Terminate($sSrchStr); // Go to list page
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->nomer_sep); // nomer_sep
		$this->BuildSearchUrl($sSrchUrl, $this->nomr); // nomr
		$this->BuildSearchUrl($sSrchUrl, $this->jenis_layanan); // jenis_layanan
		$this->BuildSearchUrl($sSrchUrl, $this->flag_proc); // flag_proc
		$this->BuildSearchUrl($sSrchUrl, $this->poli_eksekutif); // poli_eksekutif
		$this->BuildSearchUrl($sSrchUrl, $this->cob); // cob
		$this->BuildSearchUrl($sSrchUrl, $this->penjamin_laka); // penjamin_laka
		$this->BuildSearchUrl($sSrchUrl, $this->no_telp); // no_telp
		$this->BuildSearchUrl($sSrchUrl, $this->status_kepesertaan_bpjs); // status_kepesertaan_bpjs
		$this->BuildSearchUrl($sSrchUrl, $this->faskes_id); // faskes_id
		$this->BuildSearchUrl($sSrchUrl, $this->nama_layanan); // nama_layanan
		$this->BuildSearchUrl($sSrchUrl, $this->nama_kelas); // nama_kelas
		$this->BuildSearchUrl($sSrchUrl, $this->table_source); // table_source
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// nomer_sep

		$this->nomer_sep->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_nomer_sep"));
		$this->nomer_sep->AdvancedSearch->SearchOperator = $objForm->GetValue("z_nomer_sep");

		// nomr
		$this->nomr->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_nomr"));
		$this->nomr->AdvancedSearch->SearchOperator = $objForm->GetValue("z_nomr");

		// jenis_layanan
		$this->jenis_layanan->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_jenis_layanan"));
		$this->jenis_layanan->AdvancedSearch->SearchOperator = $objForm->GetValue("z_jenis_layanan");

		// flag_proc
		$this->flag_proc->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_flag_proc"));
		$this->flag_proc->AdvancedSearch->SearchOperator = $objForm->GetValue("z_flag_proc");

		// poli_eksekutif
		$this->poli_eksekutif->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_poli_eksekutif"));
		$this->poli_eksekutif->AdvancedSearch->SearchOperator = $objForm->GetValue("z_poli_eksekutif");

		// cob
		$this->cob->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_cob"));
		$this->cob->AdvancedSearch->SearchOperator = $objForm->GetValue("z_cob");

		// penjamin_laka
		$this->penjamin_laka->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_penjamin_laka"));
		$this->penjamin_laka->AdvancedSearch->SearchOperator = $objForm->GetValue("z_penjamin_laka");

		// no_telp
		$this->no_telp->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_no_telp"));
		$this->no_telp->AdvancedSearch->SearchOperator = $objForm->GetValue("z_no_telp");

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_status_kepesertaan_bpjs"));
		$this->status_kepesertaan_bpjs->AdvancedSearch->SearchOperator = $objForm->GetValue("z_status_kepesertaan_bpjs");

		// faskes_id
		$this->faskes_id->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_faskes_id"));
		$this->faskes_id->AdvancedSearch->SearchOperator = $objForm->GetValue("z_faskes_id");

		// nama_layanan
		$this->nama_layanan->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_nama_layanan"));
		$this->nama_layanan->AdvancedSearch->SearchOperator = $objForm->GetValue("z_nama_layanan");

		// nama_kelas
		$this->nama_kelas->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_nama_kelas"));
		$this->nama_kelas->AdvancedSearch->SearchOperator = $objForm->GetValue("z_nama_kelas");

		// table_source
		$this->table_source->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_table_source"));
		$this->table_source->AdvancedSearch->SearchOperator = $objForm->GetValue("z_table_source");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// nomer_sep
		// nomr
		// no_kartubpjs
		// jenis_layanan
		// tgl_sep
		// tgl_rujukan
		// kelas_rawat
		// no_rujukan
		// ppk_asal
		// nama_ppk
		// ppk_pelayanan
		// catatan
		// kode_diagnosaawal
		// nama_diagnosaawal
		// laka_lantas
		// lokasi_laka
		// user
		// nik
		// kode_politujuan
		// nama_politujuan
		// dpjp
		// idx
		// last_update
		// pasien_baru
		// cara_bayar
		// petugas_klaim
		// total_biaya_rs
		// total_biaya_rs_adjust
		// tgl_pulang
		// flag_proc
		// poli_eksekutif
		// cob
		// penjamin_laka
		// no_telp
		// status_kepesertaan_bpjs
		// faskes_id
		// nama_layanan
		// nama_kelas
		// table_source

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nomer_sep
		$this->nomer_sep->ViewValue = $this->nomer_sep->CurrentValue;
		$this->nomer_sep->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// no_kartubpjs
		$this->no_kartubpjs->ViewValue = $this->no_kartubpjs->CurrentValue;
		$this->no_kartubpjs->ViewCustomAttributes = "";

		// jenis_layanan
		if (strval($this->jenis_layanan->CurrentValue) <> "") {
			$this->jenis_layanan->ViewValue = $this->jenis_layanan->OptionCaption($this->jenis_layanan->CurrentValue);
		} else {
			$this->jenis_layanan->ViewValue = NULL;
		}
		$this->jenis_layanan->ViewCustomAttributes = "";

		// tgl_sep
		$this->tgl_sep->ViewValue = $this->tgl_sep->CurrentValue;
		$this->tgl_sep->ViewValue = ew_FormatDateTime($this->tgl_sep->ViewValue, 0);
		$this->tgl_sep->ViewCustomAttributes = "";

		// tgl_rujukan
		$this->tgl_rujukan->ViewValue = $this->tgl_rujukan->CurrentValue;
		$this->tgl_rujukan->ViewValue = ew_FormatDateTime($this->tgl_rujukan->ViewValue, 0);
		$this->tgl_rujukan->ViewCustomAttributes = "";

		// kelas_rawat
		$this->kelas_rawat->ViewValue = $this->kelas_rawat->CurrentValue;
		$this->kelas_rawat->ViewCustomAttributes = "";

		// no_rujukan
		$this->no_rujukan->ViewValue = $this->no_rujukan->CurrentValue;
		$this->no_rujukan->ViewCustomAttributes = "";

		// ppk_asal
		$this->ppk_asal->ViewValue = $this->ppk_asal->CurrentValue;
		$this->ppk_asal->ViewCustomAttributes = "";

		// nama_ppk
		$this->nama_ppk->ViewValue = $this->nama_ppk->CurrentValue;
		$this->nama_ppk->ViewCustomAttributes = "";

		// ppk_pelayanan
		$this->ppk_pelayanan->ViewValue = $this->ppk_pelayanan->CurrentValue;
		$this->ppk_pelayanan->ViewCustomAttributes = "";

		// catatan
		$this->catatan->ViewValue = $this->catatan->CurrentValue;
		$this->catatan->ViewCustomAttributes = "";

		// kode_diagnosaawal
		$this->kode_diagnosaawal->ViewValue = $this->kode_diagnosaawal->CurrentValue;
		$this->kode_diagnosaawal->ViewCustomAttributes = "";

		// nama_diagnosaawal
		$this->nama_diagnosaawal->ViewValue = $this->nama_diagnosaawal->CurrentValue;
		$this->nama_diagnosaawal->ViewCustomAttributes = "";

		// laka_lantas
		$this->laka_lantas->ViewValue = $this->laka_lantas->CurrentValue;
		$this->laka_lantas->ViewCustomAttributes = "";

		// lokasi_laka
		$this->lokasi_laka->ViewValue = $this->lokasi_laka->CurrentValue;
		$this->lokasi_laka->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// nik
		$this->nik->ViewValue = $this->nik->CurrentValue;
		$this->nik->ViewCustomAttributes = "";

		// kode_politujuan
		$this->kode_politujuan->ViewValue = $this->kode_politujuan->CurrentValue;
		$this->kode_politujuan->ViewCustomAttributes = "";

		// nama_politujuan
		$this->nama_politujuan->ViewValue = $this->nama_politujuan->CurrentValue;
		$this->nama_politujuan->ViewCustomAttributes = "";

		// dpjp
		$this->dpjp->ViewValue = $this->dpjp->CurrentValue;
		$this->dpjp->ViewCustomAttributes = "";

		// idx
		$this->idx->ViewValue = $this->idx->CurrentValue;
		$this->idx->ViewCustomAttributes = "";

		// last_update
		$this->last_update->ViewValue = $this->last_update->CurrentValue;
		$this->last_update->ViewValue = ew_FormatDateTime($this->last_update->ViewValue, 0);
		$this->last_update->ViewCustomAttributes = "";

		// pasien_baru
		$this->pasien_baru->ViewValue = $this->pasien_baru->CurrentValue;
		$this->pasien_baru->ViewCustomAttributes = "";

		// cara_bayar
		$this->cara_bayar->ViewValue = $this->cara_bayar->CurrentValue;
		$this->cara_bayar->ViewCustomAttributes = "";

		// petugas_klaim
		$this->petugas_klaim->ViewValue = $this->petugas_klaim->CurrentValue;
		$this->petugas_klaim->ViewCustomAttributes = "";

		// total_biaya_rs
		$this->total_biaya_rs->ViewValue = $this->total_biaya_rs->CurrentValue;
		$this->total_biaya_rs->ViewCustomAttributes = "";

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust->ViewValue = $this->total_biaya_rs_adjust->CurrentValue;
		$this->total_biaya_rs_adjust->ViewCustomAttributes = "";

		// tgl_pulang
		$this->tgl_pulang->ViewValue = $this->tgl_pulang->CurrentValue;
		$this->tgl_pulang->ViewValue = ew_FormatDateTime($this->tgl_pulang->ViewValue, 0);
		$this->tgl_pulang->ViewCustomAttributes = "";

		// flag_proc
		$this->flag_proc->ViewValue = $this->flag_proc->CurrentValue;
		$this->flag_proc->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// cob
		$this->cob->ViewValue = $this->cob->CurrentValue;
		$this->cob->ViewCustomAttributes = "";

		// penjamin_laka
		$this->penjamin_laka->ViewValue = $this->penjamin_laka->CurrentValue;
		$this->penjamin_laka->ViewCustomAttributes = "";

		// no_telp
		$this->no_telp->ViewValue = $this->no_telp->CurrentValue;
		$this->no_telp->ViewCustomAttributes = "";

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->ViewValue = $this->status_kepesertaan_bpjs->CurrentValue;
		$this->status_kepesertaan_bpjs->ViewCustomAttributes = "";

		// faskes_id
		$this->faskes_id->ViewValue = $this->faskes_id->CurrentValue;
		$this->faskes_id->ViewCustomAttributes = "";

		// nama_layanan
		$this->nama_layanan->ViewValue = $this->nama_layanan->CurrentValue;
		$this->nama_layanan->ViewCustomAttributes = "";

		// nama_kelas
		$this->nama_kelas->ViewValue = $this->nama_kelas->CurrentValue;
		$this->nama_kelas->ViewCustomAttributes = "";

		// table_source
		$this->table_source->ViewValue = $this->table_source->CurrentValue;
		$this->table_source->ViewCustomAttributes = "";

			// nomer_sep
			$this->nomer_sep->LinkCustomAttributes = "";
			$this->nomer_sep->HrefValue = "";
			$this->nomer_sep->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// jenis_layanan
			$this->jenis_layanan->LinkCustomAttributes = "";
			$this->jenis_layanan->HrefValue = "";
			$this->jenis_layanan->TooltipValue = "";

			// flag_proc
			$this->flag_proc->LinkCustomAttributes = "";
			$this->flag_proc->HrefValue = "";
			$this->flag_proc->TooltipValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";
			$this->poli_eksekutif->TooltipValue = "";

			// cob
			$this->cob->LinkCustomAttributes = "";
			$this->cob->HrefValue = "";
			$this->cob->TooltipValue = "";

			// penjamin_laka
			$this->penjamin_laka->LinkCustomAttributes = "";
			$this->penjamin_laka->HrefValue = "";
			$this->penjamin_laka->TooltipValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";
			$this->no_telp->TooltipValue = "";

			// status_kepesertaan_bpjs
			$this->status_kepesertaan_bpjs->LinkCustomAttributes = "";
			$this->status_kepesertaan_bpjs->HrefValue = "";
			$this->status_kepesertaan_bpjs->TooltipValue = "";

			// faskes_id
			$this->faskes_id->LinkCustomAttributes = "";
			$this->faskes_id->HrefValue = "";
			$this->faskes_id->TooltipValue = "";

			// nama_layanan
			$this->nama_layanan->LinkCustomAttributes = "";
			$this->nama_layanan->HrefValue = "";
			$this->nama_layanan->TooltipValue = "";

			// nama_kelas
			$this->nama_kelas->LinkCustomAttributes = "";
			$this->nama_kelas->HrefValue = "";
			$this->nama_kelas->TooltipValue = "";

			// table_source
			$this->table_source->LinkCustomAttributes = "";
			$this->table_source->HrefValue = "";
			$this->table_source->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// nomer_sep
			$this->nomer_sep->EditAttrs["class"] = "form-control";
			$this->nomer_sep->EditCustomAttributes = "";
			$this->nomer_sep->EditValue = ew_HtmlEncode($this->nomer_sep->AdvancedSearch->SearchValue);
			$this->nomer_sep->PlaceHolder = ew_RemoveHtml($this->nomer_sep->FldCaption());

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->AdvancedSearch->SearchValue);
			$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());

			// jenis_layanan
			$this->jenis_layanan->EditCustomAttributes = "";
			$this->jenis_layanan->EditValue = $this->jenis_layanan->Options(FALSE);

			// flag_proc
			$this->flag_proc->EditAttrs["class"] = "form-control";
			$this->flag_proc->EditCustomAttributes = "";
			$this->flag_proc->EditValue = ew_HtmlEncode($this->flag_proc->AdvancedSearch->SearchValue);
			$this->flag_proc->PlaceHolder = ew_RemoveHtml($this->flag_proc->FldCaption());

			// poli_eksekutif
			$this->poli_eksekutif->EditAttrs["class"] = "form-control";
			$this->poli_eksekutif->EditCustomAttributes = "";
			$this->poli_eksekutif->EditValue = ew_HtmlEncode($this->poli_eksekutif->AdvancedSearch->SearchValue);
			$this->poli_eksekutif->PlaceHolder = ew_RemoveHtml($this->poli_eksekutif->FldCaption());

			// cob
			$this->cob->EditAttrs["class"] = "form-control";
			$this->cob->EditCustomAttributes = "";
			$this->cob->EditValue = ew_HtmlEncode($this->cob->AdvancedSearch->SearchValue);
			$this->cob->PlaceHolder = ew_RemoveHtml($this->cob->FldCaption());

			// penjamin_laka
			$this->penjamin_laka->EditAttrs["class"] = "form-control";
			$this->penjamin_laka->EditCustomAttributes = "";
			$this->penjamin_laka->EditValue = ew_HtmlEncode($this->penjamin_laka->AdvancedSearch->SearchValue);
			$this->penjamin_laka->PlaceHolder = ew_RemoveHtml($this->penjamin_laka->FldCaption());

			// no_telp
			$this->no_telp->EditAttrs["class"] = "form-control";
			$this->no_telp->EditCustomAttributes = "";
			$this->no_telp->EditValue = ew_HtmlEncode($this->no_telp->AdvancedSearch->SearchValue);
			$this->no_telp->PlaceHolder = ew_RemoveHtml($this->no_telp->FldCaption());

			// status_kepesertaan_bpjs
			$this->status_kepesertaan_bpjs->EditAttrs["class"] = "form-control";
			$this->status_kepesertaan_bpjs->EditCustomAttributes = "";
			$this->status_kepesertaan_bpjs->EditValue = ew_HtmlEncode($this->status_kepesertaan_bpjs->AdvancedSearch->SearchValue);
			$this->status_kepesertaan_bpjs->PlaceHolder = ew_RemoveHtml($this->status_kepesertaan_bpjs->FldCaption());

			// faskes_id
			$this->faskes_id->EditAttrs["class"] = "form-control";
			$this->faskes_id->EditCustomAttributes = "";
			$this->faskes_id->EditValue = ew_HtmlEncode($this->faskes_id->AdvancedSearch->SearchValue);
			$this->faskes_id->PlaceHolder = ew_RemoveHtml($this->faskes_id->FldCaption());

			// nama_layanan
			$this->nama_layanan->EditAttrs["class"] = "form-control";
			$this->nama_layanan->EditCustomAttributes = "";
			$this->nama_layanan->EditValue = ew_HtmlEncode($this->nama_layanan->AdvancedSearch->SearchValue);
			$this->nama_layanan->PlaceHolder = ew_RemoveHtml($this->nama_layanan->FldCaption());

			// nama_kelas
			$this->nama_kelas->EditAttrs["class"] = "form-control";
			$this->nama_kelas->EditCustomAttributes = "";
			$this->nama_kelas->EditValue = ew_HtmlEncode($this->nama_kelas->AdvancedSearch->SearchValue);
			$this->nama_kelas->PlaceHolder = ew_RemoveHtml($this->nama_kelas->FldCaption());

			// table_source
			$this->table_source->EditAttrs["class"] = "form-control";
			$this->table_source->EditCustomAttributes = "";
			$this->table_source->EditValue = ew_HtmlEncode($this->table_source->AdvancedSearch->SearchValue);
			$this->table_source->PlaceHolder = ew_RemoveHtml($this->table_source->FldCaption());
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($this->flag_proc->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->flag_proc->FldErrMsg());
		}
		if (!ew_CheckInteger($this->poli_eksekutif->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->poli_eksekutif->FldErrMsg());
		}
		if (!ew_CheckInteger($this->cob->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->cob->FldErrMsg());
		}
		if (!ew_CheckInteger($this->penjamin_laka->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->penjamin_laka->FldErrMsg());
		}
		if (!ew_CheckInteger($this->faskes_id->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->faskes_id->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->nomer_sep->AdvancedSearch->Load();
		$this->nomr->AdvancedSearch->Load();
		$this->jenis_layanan->AdvancedSearch->Load();
		$this->flag_proc->AdvancedSearch->Load();
		$this->poli_eksekutif->AdvancedSearch->Load();
		$this->cob->AdvancedSearch->Load();
		$this->penjamin_laka->AdvancedSearch->Load();
		$this->no_telp->AdvancedSearch->Load();
		$this->status_kepesertaan_bpjs->AdvancedSearch->Load();
		$this->faskes_id->AdvancedSearch->Load();
		$this->nama_layanan->AdvancedSearch->Load();
		$this->nama_kelas->AdvancedSearch->Load();
		$this->table_source->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_seplist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($t_sep_search)) $t_sep_search = new ct_sep_search();

// Page init
$t_sep_search->Page_Init();

// Page main
$t_sep_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_sep_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($t_sep_search->IsModal) { ?>
var CurrentAdvancedSearchForm = ft_sepsearch = new ew_Form("ft_sepsearch", "search");
<?php } else { ?>
var CurrentForm = ft_sepsearch = new ew_Form("ft_sepsearch", "search");
<?php } ?>

// Form_CustomValidate event
ft_sepsearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_sepsearch.ValidateRequired = true;
<?php } else { ?>
ft_sepsearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_sepsearch.Lists["x_jenis_layanan"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ft_sepsearch.Lists["x_jenis_layanan"].Options = <?php echo json_encode($t_sep->jenis_layanan->Options()) ?>;

// Form object for search
// Validate function for search

ft_sepsearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_flag_proc");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->flag_proc->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_poli_eksekutif");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->poli_eksekutif->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_cob");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->cob->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_penjamin_laka");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->penjamin_laka->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_faskes_id");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_sep->faskes_id->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_sep_search->IsModal) { ?>
<?php } ?>
<?php $t_sep_search->ShowPageHeader(); ?>
<?php
$t_sep_search->ShowMessage();
?>
<form name="ft_sepsearch" id="ft_sepsearch" class="<?php echo $t_sep_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_sep_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_sep_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_sep">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($t_sep_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_sep->nomer_sep->Visible) { // nomer_sep ?>
	<div id="r_nomer_sep" class="form-group">
		<label for="x_nomer_sep" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_nomer_sep"><?php echo $t_sep->nomer_sep->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_nomer_sep" id="z_nomer_sep" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->nomer_sep->CellAttributes() ?>>
			<span id="el_t_sep_nomer_sep">
<input type="text" data-table="t_sep" data-field="x_nomer_sep" name="x_nomer_sep" id="x_nomer_sep" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomer_sep->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomer_sep->EditValue ?>"<?php echo $t_sep->nomer_sep->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label for="x_nomr" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_nomr"><?php echo $t_sep->nomr->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_nomr" id="z_nomr" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->nomr->CellAttributes() ?>>
			<span id="el_t_sep_nomr">
<input type="text" data-table="t_sep" data-field="x_nomr" name="x_nomr" id="x_nomr" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nomr->getPlaceHolder()) ?>" value="<?php echo $t_sep->nomr->EditValue ?>"<?php echo $t_sep->nomr->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->jenis_layanan->Visible) { // jenis_layanan ?>
	<div id="r_jenis_layanan" class="form-group">
		<label class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_jenis_layanan"><?php echo $t_sep->jenis_layanan->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_jenis_layanan" id="z_jenis_layanan" value="="></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->jenis_layanan->CellAttributes() ?>>
			<span id="el_t_sep_jenis_layanan">
<div id="tp_x_jenis_layanan" class="ewTemplate"><input type="radio" data-table="t_sep" data-field="x_jenis_layanan" data-value-separator="<?php echo $t_sep->jenis_layanan->DisplayValueSeparatorAttribute() ?>" name="x_jenis_layanan" id="x_jenis_layanan" value="{value}"<?php echo $t_sep->jenis_layanan->EditAttributes() ?>></div>
<div id="dsl_x_jenis_layanan" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $t_sep->jenis_layanan->RadioButtonListHtml(FALSE, "x_jenis_layanan") ?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->flag_proc->Visible) { // flag_proc ?>
	<div id="r_flag_proc" class="form-group">
		<label for="x_flag_proc" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_flag_proc"><?php echo $t_sep->flag_proc->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_flag_proc" id="z_flag_proc" value="="></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->flag_proc->CellAttributes() ?>>
			<span id="el_t_sep_flag_proc">
<input type="text" data-table="t_sep" data-field="x_flag_proc" name="x_flag_proc" id="x_flag_proc" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->flag_proc->getPlaceHolder()) ?>" value="<?php echo $t_sep->flag_proc->EditValue ?>"<?php echo $t_sep->flag_proc->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->poli_eksekutif->Visible) { // poli_eksekutif ?>
	<div id="r_poli_eksekutif" class="form-group">
		<label for="x_poli_eksekutif" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_poli_eksekutif"><?php echo $t_sep->poli_eksekutif->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_poli_eksekutif" id="z_poli_eksekutif" value="="></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->poli_eksekutif->CellAttributes() ?>>
			<span id="el_t_sep_poli_eksekutif">
<input type="text" data-table="t_sep" data-field="x_poli_eksekutif" name="x_poli_eksekutif" id="x_poli_eksekutif" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->poli_eksekutif->getPlaceHolder()) ?>" value="<?php echo $t_sep->poli_eksekutif->EditValue ?>"<?php echo $t_sep->poli_eksekutif->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->cob->Visible) { // cob ?>
	<div id="r_cob" class="form-group">
		<label for="x_cob" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_cob"><?php echo $t_sep->cob->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_cob" id="z_cob" value="="></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->cob->CellAttributes() ?>>
			<span id="el_t_sep_cob">
<input type="text" data-table="t_sep" data-field="x_cob" name="x_cob" id="x_cob" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->cob->getPlaceHolder()) ?>" value="<?php echo $t_sep->cob->EditValue ?>"<?php echo $t_sep->cob->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->penjamin_laka->Visible) { // penjamin_laka ?>
	<div id="r_penjamin_laka" class="form-group">
		<label for="x_penjamin_laka" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_penjamin_laka"><?php echo $t_sep->penjamin_laka->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_penjamin_laka" id="z_penjamin_laka" value="="></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->penjamin_laka->CellAttributes() ?>>
			<span id="el_t_sep_penjamin_laka">
<input type="text" data-table="t_sep" data-field="x_penjamin_laka" name="x_penjamin_laka" id="x_penjamin_laka" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->penjamin_laka->getPlaceHolder()) ?>" value="<?php echo $t_sep->penjamin_laka->EditValue ?>"<?php echo $t_sep->penjamin_laka->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->no_telp->Visible) { // no_telp ?>
	<div id="r_no_telp" class="form-group">
		<label for="x_no_telp" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_no_telp"><?php echo $t_sep->no_telp->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_no_telp" id="z_no_telp" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->no_telp->CellAttributes() ?>>
			<span id="el_t_sep_no_telp">
<input type="text" data-table="t_sep" data-field="x_no_telp" name="x_no_telp" id="x_no_telp" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->no_telp->getPlaceHolder()) ?>" value="<?php echo $t_sep->no_telp->EditValue ?>"<?php echo $t_sep->no_telp->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->status_kepesertaan_bpjs->Visible) { // status_kepesertaan_bpjs ?>
	<div id="r_status_kepesertaan_bpjs" class="form-group">
		<label for="x_status_kepesertaan_bpjs" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_status_kepesertaan_bpjs"><?php echo $t_sep->status_kepesertaan_bpjs->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_status_kepesertaan_bpjs" id="z_status_kepesertaan_bpjs" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->status_kepesertaan_bpjs->CellAttributes() ?>>
			<span id="el_t_sep_status_kepesertaan_bpjs">
<input type="text" data-table="t_sep" data-field="x_status_kepesertaan_bpjs" name="x_status_kepesertaan_bpjs" id="x_status_kepesertaan_bpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->status_kepesertaan_bpjs->getPlaceHolder()) ?>" value="<?php echo $t_sep->status_kepesertaan_bpjs->EditValue ?>"<?php echo $t_sep->status_kepesertaan_bpjs->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->faskes_id->Visible) { // faskes_id ?>
	<div id="r_faskes_id" class="form-group">
		<label for="x_faskes_id" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_faskes_id"><?php echo $t_sep->faskes_id->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_faskes_id" id="z_faskes_id" value="="></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->faskes_id->CellAttributes() ?>>
			<span id="el_t_sep_faskes_id">
<input type="text" data-table="t_sep" data-field="x_faskes_id" name="x_faskes_id" id="x_faskes_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_sep->faskes_id->getPlaceHolder()) ?>" value="<?php echo $t_sep->faskes_id->EditValue ?>"<?php echo $t_sep->faskes_id->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nama_layanan->Visible) { // nama_layanan ?>
	<div id="r_nama_layanan" class="form-group">
		<label for="x_nama_layanan" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_nama_layanan"><?php echo $t_sep->nama_layanan->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_nama_layanan" id="z_nama_layanan" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->nama_layanan->CellAttributes() ?>>
			<span id="el_t_sep_nama_layanan">
<input type="text" data-table="t_sep" data-field="x_nama_layanan" name="x_nama_layanan" id="x_nama_layanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nama_layanan->getPlaceHolder()) ?>" value="<?php echo $t_sep->nama_layanan->EditValue ?>"<?php echo $t_sep->nama_layanan->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->nama_kelas->Visible) { // nama_kelas ?>
	<div id="r_nama_kelas" class="form-group">
		<label for="x_nama_kelas" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_nama_kelas"><?php echo $t_sep->nama_kelas->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_nama_kelas" id="z_nama_kelas" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->nama_kelas->CellAttributes() ?>>
			<span id="el_t_sep_nama_kelas">
<input type="text" data-table="t_sep" data-field="x_nama_kelas" name="x_nama_kelas" id="x_nama_kelas" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->nama_kelas->getPlaceHolder()) ?>" value="<?php echo $t_sep->nama_kelas->EditValue ?>"<?php echo $t_sep->nama_kelas->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_sep->table_source->Visible) { // table_source ?>
	<div id="r_table_source" class="form-group">
		<label for="x_table_source" class="<?php echo $t_sep_search->SearchLabelClass ?>"><span id="elh_t_sep_table_source"><?php echo $t_sep->table_source->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_table_source" id="z_table_source" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_sep_search->SearchRightColumnClass ?>"><div<?php echo $t_sep->table_source->CellAttributes() ?>>
			<span id="el_t_sep_table_source">
<input type="text" data-table="t_sep" data-field="x_table_source" name="x_table_source" id="x_table_source" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_sep->table_source->getPlaceHolder()) ?>" value="<?php echo $t_sep->table_source->EditValue ?>"<?php echo $t_sep->table_source->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_sep_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_sepsearch.Init();
</script>
<?php
$t_sep_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_sep_search->Page_Terminate();
?>
