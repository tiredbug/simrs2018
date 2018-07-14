<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_pendaftaraninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_pendaftaran_search = NULL; // Initialize page object first

class ct_pendaftaran_search extends ct_pendaftaran {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_pendaftaran';

	// Page object name
	var $PageObjName = 't_pendaftaran_search';

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

		// Table object (t_pendaftaran)
		if (!isset($GLOBALS["t_pendaftaran"]) || get_class($GLOBALS["t_pendaftaran"]) == "ct_pendaftaran") {
			$GLOBALS["t_pendaftaran"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_pendaftaran"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_pendaftaran', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_pendaftaranlist.php"));
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
		$this->TGLREG->SetVisibility();
		$this->NOMR->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->biaya_obat_2->SetVisibility();
		$this->biaya_retur_obat_2->SetVisibility();
		$this->TOTAL_BIAYA_OBAT_2->SetVisibility();
		$this->KDCARABAYAR2->SetVisibility();

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
		global $EW_EXPORT, $t_pendaftaran;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_pendaftaran);
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
						$sSrchStr = "t_pendaftaranlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->TGLREG); // TGLREG
		$this->BuildSearchUrl($sSrchUrl, $this->NOMR); // NOMR
		$this->BuildSearchUrl($sSrchUrl, $this->KDPOLY); // KDPOLY
		$this->BuildSearchUrl($sSrchUrl, $this->biaya_obat_2); // biaya_obat_2
		$this->BuildSearchUrl($sSrchUrl, $this->biaya_retur_obat_2); // biaya_retur_obat_2
		$this->BuildSearchUrl($sSrchUrl, $this->TOTAL_BIAYA_OBAT_2); // TOTAL_BIAYA_OBAT_2
		$this->BuildSearchUrl($sSrchUrl, $this->KDCARABAYAR2); // KDCARABAYAR2
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
		// TGLREG

		$this->TGLREG->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_TGLREG"));
		$this->TGLREG->AdvancedSearch->SearchOperator = $objForm->GetValue("z_TGLREG");
		$this->TGLREG->AdvancedSearch->SearchCondition = $objForm->GetValue("v_TGLREG");
		$this->TGLREG->AdvancedSearch->SearchValue2 = ew_StripSlashes($objForm->GetValue("y_TGLREG"));
		$this->TGLREG->AdvancedSearch->SearchOperator2 = $objForm->GetValue("w_TGLREG");

		// NOMR
		$this->NOMR->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NOMR"));
		$this->NOMR->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NOMR");

		// KDPOLY
		$this->KDPOLY->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_KDPOLY"));
		$this->KDPOLY->AdvancedSearch->SearchOperator = $objForm->GetValue("z_KDPOLY");

		// biaya_obat_2
		$this->biaya_obat_2->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_biaya_obat_2"));
		$this->biaya_obat_2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_biaya_obat_2");

		// biaya_retur_obat_2
		$this->biaya_retur_obat_2->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_biaya_retur_obat_2"));
		$this->biaya_retur_obat_2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_biaya_retur_obat_2");

		// TOTAL_BIAYA_OBAT_2
		$this->TOTAL_BIAYA_OBAT_2->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_TOTAL_BIAYA_OBAT_2"));
		$this->TOTAL_BIAYA_OBAT_2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_TOTAL_BIAYA_OBAT_2");

		// KDCARABAYAR2
		$this->KDCARABAYAR2->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_KDCARABAYAR2"));
		$this->KDCARABAYAR2->AdvancedSearch->SearchOperator = $objForm->GetValue("z_KDCARABAYAR2");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->biaya_obat_2->FormValue == $this->biaya_obat_2->CurrentValue && is_numeric(ew_StrToFloat($this->biaya_obat_2->CurrentValue)))
			$this->biaya_obat_2->CurrentValue = ew_StrToFloat($this->biaya_obat_2->CurrentValue);

		// Convert decimal values if posted back
		if ($this->biaya_retur_obat_2->FormValue == $this->biaya_retur_obat_2->CurrentValue && is_numeric(ew_StrToFloat($this->biaya_retur_obat_2->CurrentValue)))
			$this->biaya_retur_obat_2->CurrentValue = ew_StrToFloat($this->biaya_retur_obat_2->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOTAL_BIAYA_OBAT_2->FormValue == $this->TOTAL_BIAYA_OBAT_2->CurrentValue && is_numeric(ew_StrToFloat($this->TOTAL_BIAYA_OBAT_2->CurrentValue)))
			$this->TOTAL_BIAYA_OBAT_2->CurrentValue = ew_StrToFloat($this->TOTAL_BIAYA_OBAT_2->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXDAFTAR
		// TGLREG
		// NOMR
		// pasien_TITLE
		// pasien_NAMA
		// pasien_ALAMAT
		// KDPOLY
		// KDDOKTER
		// KDRUJUK
		// KDCARABAYAR
		// NOJAMINAN
		// SHIFT
		// STATUS
		// KETERANGAN_STATUS
		// PASIENBARU
		// NIP
		// MASUKPOLY
		// KELUARPOLY
		// KETRUJUK
		// KETBAYAR
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// JAMREG
		// BATAL
		// NO_SJP
		// NO_PESERTA
		// NOKARTU
		// TOTAL_BIAYA_OBAT
		// biaya_obat
		// biaya_retur_obat
		// TOTAL_BIAYA_OBAT_RAJAL
		// biaya_obat_rajal
		// biaya_retur_obat_rajal
		// TOTAL_BIAYA_OBAT_IGD
		// biaya_obat_igd
		// biaya_retur_obat_igd
		// TOTAL_BIAYA_OBAT_IBS
		// biaya_obat_ibs
		// biaya_retur_obat_ibs
		// TANGGAL_SEP
		// TANGGALRUJUK_SEP
		// KELASRAWAT_SEP
		// MINTA_RUJUKAN
		// NORUJUKAN_SEP
		// PPKRUJUKANASAL_SEP
		// NAMAPPKRUJUKANASAL_SEP
		// PPKPELAYANAN_SEP
		// JENISPERAWATAN_SEP
		// CATATAN_SEP
		// DIAGNOSAAWAL_SEP
		// NAMADIAGNOSA_SEP
		// LAKALANTAS_SEP
		// LOKASILAKALANTAS
		// USER
		// cek_data_kepesertaan
		// generate_sep
		// PESERTANIK_SEP
		// PESERTANAMA_SEP
		// PESERTAJENISKELAMIN_SEP
		// PESERTANAMAKELAS_SEP
		// PESERTAPISAT
		// PESERTATGLLAHIR
		// PESERTAJENISPESERTA_SEP
		// PESERTANAMAJENISPESERTA_SEP
		// PESERTATGLCETAKKARTU_SEP
		// POLITUJUAN_SEP
		// NAMAPOLITUJUAN_SEP
		// KDPPKRUJUKAN_SEP
		// NMPPKRUJUKAN_SEP
		// UPDATETGLPLNG_SEP
		// bridging_upt_tglplng
		// mapingtransaksi
		// bridging_no_rujukan
		// bridging_hapus_sep
		// bridging_kepesertaan_by_no_ka
		// NOKARTU_BPJS
		// counter_cetak_kartu
		// bridging_kepesertaan_by_nik
		// NOKTP
		// bridging_by_no_rujukan
		// maping_hapus_sep
		// counter_cetak_kartu_ranap
		// BIAYA_PENDAFTARAN
		// BIAYA_TINDAKAN_POLI
		// BIAYA_TINDAKAN_RADIOLOGI
		// BIAYA_TINDAKAN_LABORAT
		// BIAYA_TINDAKAN_KONSULTASI
		// BIAYA_TARIF_DOKTER
		// BIAYA_TARIF_DOKTER_KONSUL
		// INCLUDE
		// eklaim_kelas_rawat_rajal
		// eklaim_adl_score
		// eklaim_adl_sub_acute
		// eklaim_adl_chronic
		// eklaim_icu_indikator
		// eklaim_icu_los
		// eklaim_ventilator_hour
		// eklaim_upgrade_class_ind
		// eklaim_upgrade_class_class
		// eklaim_upgrade_class_los
		// eklaim_birth_weight
		// eklaim_discharge_status
		// eklaim_diagnosa
		// eklaim_procedure
		// eklaim_tarif_rs
		// eklaim_tarif_poli_eks
		// eklaim_id_dokter
		// eklaim_nama_dokter
		// eklaim_kode_tarif
		// eklaim_payor_id
		// eklaim_payor_cd
		// eklaim_coder_nik
		// eklaim_los
		// eklaim_patient_id
		// eklaim_admission_id
		// eklaim_hospital_admission_id
		// bridging_hapussep
		// user_penghapus_sep
		// BIAYA_BILLING_RAJAL
		// STATUS_PEMBAYARAN
		// BIAYA_TINDAKAN_FISIOTERAPI
		// eklaim_reg_pasien
		// eklaim_reg_klaim_baru
		// eklaim_gruper1
		// eklaim_gruper2
		// eklaim_finalklaim
		// eklaim_sendklaim
		// eklaim_flag_hapus_pasien
		// eklaim_flag_hapus_klaim
		// eklaim_kemkes_dc_Status
		// eklaim_bpjs_dc_Status
		// eklaim_cbg_code
		// eklaim_cbg_descprition
		// eklaim_cbg_tariff
		// eklaim_sub_acute_code
		// eklaim_sub_acute_deskripsi
		// eklaim_sub_acute_tariff
		// eklaim_chronic_code
		// eklaim_chronic_deskripsi
		// eklaim_chronic_tariff
		// eklaim_inacbg_version
		// BIAYA_TINDAKAN_IBS_RAJAL
		// VERIFY_ICD
		// bridging_rujukan_faskes_2
		// eklaim_reedit_claim
		// KETERANGAN
		// TGLLAHIR
		// USER_KASIR
		// eklaim_tgl_gruping
		// eklaim_tgl_finalklaim
		// eklaim_tgl_kirim_klaim
		// BIAYA_OBAT_RS
		// EKG_RAJAL
		// USG_RAJAL
		// FISIOTERAPI_RAJAL
		// BHP_RAJAL
		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		// TOTAL_BIAYA_IBS_RAJAL
		// ORDER_LAB
		// BILL_RAJAL_SELESAI
		// INCLUDE_IDXDAFTAR
		// INCLUDE_HARGA
		// TARIF_JASA_SARANA
		// TARIF_PENUNJANG_NON_MEDIS
		// TARIF_ASUHAN_KEPERAWATAN
		// KDDOKTER_RAJAL
		// KDDOKTER_KONSUL_RAJAL
		// BIAYA_BILLING_RS
		// BIAYA_TINDAKAN_POLI_TMO
		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		// BHP_RAJAL_TMO
		// BHP_RAJAL_KEPERAWATAN
		// TARIF_AKOMODASI
		// TARIF_AMBULAN
		// TARIF_OKSIGEN
		// BIAYA_TINDAKAN_JENAZAH
		// BIAYA_BILLING_IGD
		// BIAYA_TINDAKAN_POLI_PERSALINAN
		// BHP_RAJAL_PERSALINAN
		// TARIF_BIMBINGAN_ROHANI
		// BIAYA_BILLING_RS2
		// BIAYA_TARIF_DOKTER_IGD
		// BIAYA_PENDAFTARAN_IGD
		// BIAYA_BILLING_IBS
		// TARIF_JASA_SARANA_IGD
		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		// TARIF_MAKAN_IGD
		// TARIF_ASUHAN_KEPERAWATAN_IGD
		// pasien_TEMPAT
		// pasien_TGLLAHIR
		// pasien_JENISKELAMIN
		// pasien_KDPROVINSI
		// pasien_KOTA
		// pasien_KDKECAMATAN
		// pasien_KELURAHAN
		// pasien_NOTELP
		// pasien_NOKTP
		// pasien_SUAMI_ORTU
		// pasien_PEKERJAAN
		// pasien_AGAMA
		// pasien_PENDIDIKAN
		// pasien_ALAMAT_KTP
		// pasien_NO_KARTU
		// pasien_JNS_PASIEN
		// pasien_nama_ayah
		// pasien_nama_ibu
		// pasien_nama_suami
		// pasien_nama_istri
		// pasien_KD_ETNIS
		// pasien_KD_BHS_HARIAN
		// BILL_FARMASI_SELESAI
		// TARIF_PELAYANAN_SIMRS
		// biaya_obat_2
		// biaya_retur_obat_2
		// TOTAL_BIAYA_OBAT_2
		// KDCARABAYAR2

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 7);
		$this->TGLREG->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array("dx1" => '`NOMR`', "dx2" => '`NAMA`', "dx3" => '`ALAMAT`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// pasien_TITLE
		if (strval($this->pasien_TITLE->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_TITLE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
		$sWhereWrk = "";
		$this->pasien_TITLE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_TITLE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_TITLE->ViewValue = $this->pasien_TITLE->CurrentValue;
			}
		} else {
			$this->pasien_TITLE->ViewValue = NULL;
		}
		$this->pasien_TITLE->ViewCustomAttributes = "";

		// pasien_NAMA
		$this->pasien_NAMA->ViewValue = $this->pasien_NAMA->CurrentValue;
		$this->pasien_NAMA->ViewCustomAttributes = "";

		// pasien_ALAMAT
		$this->pasien_ALAMAT->ViewValue = $this->pasien_ALAMAT->CurrentValue;
		$this->pasien_ALAMAT->ViewCustomAttributes = "";

		// KDPOLY
		if (strval($this->KDPOLY->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->KDPOLY->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDPOLY->ViewValue = $this->KDPOLY->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDPOLY->ViewValue = $this->KDPOLY->CurrentValue;
			}
		} else {
			$this->KDPOLY->ViewValue = NULL;
		}
		$this->KDPOLY->ViewCustomAttributes = "";

		// KDDOKTER
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`kddokter`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kddokter`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_lookup_dokter_poli`";
		$sWhereWrk = "";
		$this->KDDOKTER->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDDOKTER, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
			}
		} else {
			$this->KDDOKTER->ViewValue = NULL;
		}
		$this->KDDOKTER->ViewCustomAttributes = "";

		// KDRUJUK
		if (strval($this->KDRUJUK->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDRUJUK->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->KDRUJUK->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
			}
		} else {
			$this->KDRUJUK->ViewValue = NULL;
		}
		$this->KDRUJUK->ViewCustomAttributes = "";

		// KDCARABAYAR
		if (strval($this->KDCARABAYAR->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->KDCARABAYAR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
			}
		} else {
			$this->KDCARABAYAR->ViewValue = NULL;
		}
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// NOJAMINAN
		$this->NOJAMINAN->ViewValue = $this->NOJAMINAN->CurrentValue;
		$this->NOJAMINAN->ViewCustomAttributes = "";

		// SHIFT
		if (strval($this->SHIFT->CurrentValue) <> "") {
			$sFilterWrk = "`id_shift`" . ew_SearchString("=", $this->SHIFT->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id_shift`, `shift` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_shift`";
		$sWhereWrk = "";
		$this->SHIFT->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->SHIFT, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->SHIFT->ViewValue = $this->SHIFT->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
			}
		} else {
			$this->SHIFT->ViewValue = NULL;
		}
		$this->SHIFT->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->ViewValue = $this->KETERANGAN_STATUS->CurrentValue;
		$this->KETERANGAN_STATUS->ViewCustomAttributes = "";

		// PASIENBARU
		$this->PASIENBARU->ViewValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// MASUKPOLY
		$this->MASUKPOLY->ViewValue = $this->MASUKPOLY->CurrentValue;
		$this->MASUKPOLY->ViewValue = ew_FormatDateTime($this->MASUKPOLY->ViewValue, 4);
		$this->MASUKPOLY->ViewCustomAttributes = "";

		// KELUARPOLY
		$this->KELUARPOLY->ViewValue = $this->KELUARPOLY->CurrentValue;
		$this->KELUARPOLY->ViewValue = ew_FormatDateTime($this->KELUARPOLY->ViewValue, 4);
		$this->KELUARPOLY->ViewCustomAttributes = "";

		// KETRUJUK
		$this->KETRUJUK->ViewValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// KETBAYAR
		$this->KETBAYAR->ViewValue = $this->KETBAYAR->CurrentValue;
		$this->KETBAYAR->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->ViewValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->ViewValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->ViewValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->ViewValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->ViewValue = ew_FormatDateTime($this->JAMREG->ViewValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// BATAL
		$this->BATAL->ViewValue = $this->BATAL->CurrentValue;
		$this->BATAL->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NO_PESERTA
		$this->NO_PESERTA->ViewValue = $this->NO_PESERTA->CurrentValue;
		$this->NO_PESERTA->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->ViewValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->ViewCustomAttributes = "";

		// biaya_obat
		$this->biaya_obat->ViewValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->ViewCustomAttributes = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->ViewValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_RAJAL
		$this->TOTAL_BIAYA_OBAT_RAJAL->ViewValue = $this->TOTAL_BIAYA_OBAT_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_RAJAL->ViewCustomAttributes = "";

		// biaya_obat_rajal
		$this->biaya_obat_rajal->ViewValue = $this->biaya_obat_rajal->CurrentValue;
		$this->biaya_obat_rajal->ViewCustomAttributes = "";

		// biaya_retur_obat_rajal
		$this->biaya_retur_obat_rajal->ViewValue = $this->biaya_retur_obat_rajal->CurrentValue;
		$this->biaya_retur_obat_rajal->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_IGD
		$this->TOTAL_BIAYA_OBAT_IGD->ViewValue = $this->TOTAL_BIAYA_OBAT_IGD->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IGD->ViewCustomAttributes = "";

		// biaya_obat_igd
		$this->biaya_obat_igd->ViewValue = $this->biaya_obat_igd->CurrentValue;
		$this->biaya_obat_igd->ViewCustomAttributes = "";

		// biaya_retur_obat_igd
		$this->biaya_retur_obat_igd->ViewValue = $this->biaya_retur_obat_igd->CurrentValue;
		$this->biaya_retur_obat_igd->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_IBS
		$this->TOTAL_BIAYA_OBAT_IBS->ViewValue = $this->TOTAL_BIAYA_OBAT_IBS->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_IBS->ViewCustomAttributes = "";

		// biaya_obat_ibs
		$this->biaya_obat_ibs->ViewValue = $this->biaya_obat_ibs->CurrentValue;
		$this->biaya_obat_ibs->ViewCustomAttributes = "";

		// biaya_retur_obat_ibs
		$this->biaya_retur_obat_ibs->ViewValue = $this->biaya_retur_obat_ibs->CurrentValue;
		$this->biaya_retur_obat_ibs->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->ViewValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->ViewValue = ew_FormatDateTime($this->TANGGAL_SEP->ViewValue, 0);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->ViewValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->ViewValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->ViewValue, 0);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->ViewValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// MINTA_RUJUKAN
		if (strval($this->MINTA_RUJUKAN->CurrentValue) <> "") {
			$this->MINTA_RUJUKAN->ViewValue = "";
			$arwrk = explode(",", strval($this->MINTA_RUJUKAN->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->MINTA_RUJUKAN->ViewValue .= $this->MINTA_RUJUKAN->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->MINTA_RUJUKAN->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->MINTA_RUJUKAN->ViewValue = NULL;
		}
		$this->MINTA_RUJUKAN->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->ViewValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->ViewValue = $this->PPKRUJUKANASAL_SEP->CurrentValue;
		$this->PPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->ViewValue = $this->NAMAPPKRUJUKANASAL_SEP->CurrentValue;
		$this->NAMAPPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->ViewValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->CurrentValue;
		$this->JENISPERAWATAN_SEP->ViewCustomAttributes = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->ViewValue = $this->CATATAN_SEP->CurrentValue;
		$this->CATATAN_SEP->ViewCustomAttributes = "";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		$this->DIAGNOSAAWAL_SEP->ViewCustomAttributes = "";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->ViewValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->ViewCustomAttributes = "";

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->CurrentValue;
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->ViewValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->ViewValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// cek_data_kepesertaan
		$this->cek_data_kepesertaan->ViewValue = $this->cek_data_kepesertaan->CurrentValue;
		$this->cek_data_kepesertaan->ViewCustomAttributes = "";

		// generate_sep
		$this->generate_sep->ViewValue = $this->generate_sep->CurrentValue;
		$this->generate_sep->ViewCustomAttributes = "";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->ViewValue = $this->PESERTANIK_SEP->CurrentValue;
		$this->PESERTANIK_SEP->ViewCustomAttributes = "";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->ViewValue = $this->PESERTANAMA_SEP->CurrentValue;
		$this->PESERTANAMA_SEP->ViewCustomAttributes = "";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->ViewValue = $this->PESERTAJENISKELAMIN_SEP->CurrentValue;
		$this->PESERTAJENISKELAMIN_SEP->ViewCustomAttributes = "";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->ViewValue = $this->PESERTANAMAKELAS_SEP->CurrentValue;
		$this->PESERTANAMAKELAS_SEP->ViewCustomAttributes = "";

		// PESERTAPISAT
		$this->PESERTAPISAT->ViewValue = $this->PESERTAPISAT->CurrentValue;
		$this->PESERTAPISAT->ViewCustomAttributes = "";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->ViewValue = $this->PESERTATGLLAHIR->CurrentValue;
		$this->PESERTATGLLAHIR->ViewCustomAttributes = "";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->ViewValue = $this->PESERTAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->ViewValue = $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTANAMAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// PESERTATGLCETAKKARTU_SEP
		$this->PESERTATGLCETAKKARTU_SEP->ViewValue = $this->PESERTATGLCETAKKARTU_SEP->CurrentValue;
		$this->PESERTATGLCETAKKARTU_SEP->ViewValue = ew_FormatDateTime($this->PESERTATGLCETAKKARTU_SEP->ViewValue, 0);
		$this->PESERTATGLCETAKKARTU_SEP->ViewCustomAttributes = "";

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->ViewValue = $this->POLITUJUAN_SEP->CurrentValue;
		$this->POLITUJUAN_SEP->ViewCustomAttributes = "";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->ViewValue = $this->NAMAPOLITUJUAN_SEP->CurrentValue;
		$this->NAMAPOLITUJUAN_SEP->ViewCustomAttributes = "";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->ViewValue = $this->KDPPKRUJUKAN_SEP->CurrentValue;
		$this->KDPPKRUJUKAN_SEP->ViewCustomAttributes = "";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->ViewValue = $this->NMPPKRUJUKAN_SEP->CurrentValue;
		$this->NMPPKRUJUKAN_SEP->ViewCustomAttributes = "";

		// UPDATETGLPLNG_SEP
		$this->UPDATETGLPLNG_SEP->ViewValue = $this->UPDATETGLPLNG_SEP->CurrentValue;
		$this->UPDATETGLPLNG_SEP->ViewValue = ew_FormatDateTime($this->UPDATETGLPLNG_SEP->ViewValue, 0);
		$this->UPDATETGLPLNG_SEP->ViewCustomAttributes = "";

		// bridging_upt_tglplng
		$this->bridging_upt_tglplng->ViewValue = $this->bridging_upt_tglplng->CurrentValue;
		$this->bridging_upt_tglplng->ViewCustomAttributes = "";

		// mapingtransaksi
		$this->mapingtransaksi->ViewValue = $this->mapingtransaksi->CurrentValue;
		$this->mapingtransaksi->ViewCustomAttributes = "";

		// bridging_no_rujukan
		$this->bridging_no_rujukan->ViewValue = $this->bridging_no_rujukan->CurrentValue;
		$this->bridging_no_rujukan->ViewCustomAttributes = "";

		// bridging_hapus_sep
		$this->bridging_hapus_sep->ViewValue = $this->bridging_hapus_sep->CurrentValue;
		$this->bridging_hapus_sep->ViewCustomAttributes = "";

		// bridging_kepesertaan_by_no_ka
		$this->bridging_kepesertaan_by_no_ka->ViewValue = $this->bridging_kepesertaan_by_no_ka->CurrentValue;
		$this->bridging_kepesertaan_by_no_ka->ViewCustomAttributes = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->ViewValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->ViewCustomAttributes = "";

		// counter_cetak_kartu
		$this->counter_cetak_kartu->ViewValue = $this->counter_cetak_kartu->CurrentValue;
		$this->counter_cetak_kartu->ViewCustomAttributes = "";

		// bridging_kepesertaan_by_nik
		$this->bridging_kepesertaan_by_nik->ViewValue = $this->bridging_kepesertaan_by_nik->CurrentValue;
		$this->bridging_kepesertaan_by_nik->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->ViewValue = $this->bridging_by_no_rujukan->CurrentValue;
		$this->bridging_by_no_rujukan->ViewCustomAttributes = "";

		// maping_hapus_sep
		$this->maping_hapus_sep->ViewValue = $this->maping_hapus_sep->CurrentValue;
		$this->maping_hapus_sep->ViewCustomAttributes = "";

		// counter_cetak_kartu_ranap
		$this->counter_cetak_kartu_ranap->ViewValue = $this->counter_cetak_kartu_ranap->CurrentValue;
		$this->counter_cetak_kartu_ranap->ViewCustomAttributes = "";

		// BIAYA_PENDAFTARAN
		$this->BIAYA_PENDAFTARAN->ViewValue = $this->BIAYA_PENDAFTARAN->CurrentValue;
		$this->BIAYA_PENDAFTARAN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI
		$this->BIAYA_TINDAKAN_POLI->ViewValue = $this->BIAYA_TINDAKAN_POLI->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_RADIOLOGI
		$this->BIAYA_TINDAKAN_RADIOLOGI->ViewValue = $this->BIAYA_TINDAKAN_RADIOLOGI->CurrentValue;
		$this->BIAYA_TINDAKAN_RADIOLOGI->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_LABORAT
		$this->BIAYA_TINDAKAN_LABORAT->ViewValue = $this->BIAYA_TINDAKAN_LABORAT->CurrentValue;
		$this->BIAYA_TINDAKAN_LABORAT->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_KONSULTASI
		$this->BIAYA_TINDAKAN_KONSULTASI->ViewValue = $this->BIAYA_TINDAKAN_KONSULTASI->CurrentValue;
		$this->BIAYA_TINDAKAN_KONSULTASI->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER
		$this->BIAYA_TARIF_DOKTER->ViewValue = $this->BIAYA_TARIF_DOKTER->CurrentValue;
		$this->BIAYA_TARIF_DOKTER->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_KONSUL
		$this->BIAYA_TARIF_DOKTER_KONSUL->ViewValue = $this->BIAYA_TARIF_DOKTER_KONSUL->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL->ViewCustomAttributes = "";

		// INCLUDE
		$this->INCLUDE->ViewValue = $this->INCLUDE->CurrentValue;
		$this->INCLUDE->ViewCustomAttributes = "";

		// eklaim_kelas_rawat_rajal
		$this->eklaim_kelas_rawat_rajal->ViewValue = $this->eklaim_kelas_rawat_rajal->CurrentValue;
		$this->eklaim_kelas_rawat_rajal->ViewCustomAttributes = "";

		// eklaim_adl_score
		$this->eklaim_adl_score->ViewValue = $this->eklaim_adl_score->CurrentValue;
		$this->eklaim_adl_score->ViewCustomAttributes = "";

		// eklaim_adl_sub_acute
		$this->eklaim_adl_sub_acute->ViewValue = $this->eklaim_adl_sub_acute->CurrentValue;
		$this->eklaim_adl_sub_acute->ViewCustomAttributes = "";

		// eklaim_adl_chronic
		$this->eklaim_adl_chronic->ViewValue = $this->eklaim_adl_chronic->CurrentValue;
		$this->eklaim_adl_chronic->ViewCustomAttributes = "";

		// eklaim_icu_indikator
		$this->eklaim_icu_indikator->ViewValue = $this->eklaim_icu_indikator->CurrentValue;
		$this->eklaim_icu_indikator->ViewCustomAttributes = "";

		// eklaim_icu_los
		$this->eklaim_icu_los->ViewValue = $this->eklaim_icu_los->CurrentValue;
		$this->eklaim_icu_los->ViewCustomAttributes = "";

		// eklaim_ventilator_hour
		$this->eklaim_ventilator_hour->ViewValue = $this->eklaim_ventilator_hour->CurrentValue;
		$this->eklaim_ventilator_hour->ViewCustomAttributes = "";

		// eklaim_upgrade_class_ind
		$this->eklaim_upgrade_class_ind->ViewValue = $this->eklaim_upgrade_class_ind->CurrentValue;
		$this->eklaim_upgrade_class_ind->ViewCustomAttributes = "";

		// eklaim_upgrade_class_class
		$this->eklaim_upgrade_class_class->ViewValue = $this->eklaim_upgrade_class_class->CurrentValue;
		$this->eklaim_upgrade_class_class->ViewCustomAttributes = "";

		// eklaim_upgrade_class_los
		$this->eklaim_upgrade_class_los->ViewValue = $this->eklaim_upgrade_class_los->CurrentValue;
		$this->eklaim_upgrade_class_los->ViewCustomAttributes = "";

		// eklaim_birth_weight
		$this->eklaim_birth_weight->ViewValue = $this->eklaim_birth_weight->CurrentValue;
		$this->eklaim_birth_weight->ViewCustomAttributes = "";

		// eklaim_discharge_status
		$this->eklaim_discharge_status->ViewValue = $this->eklaim_discharge_status->CurrentValue;
		$this->eklaim_discharge_status->ViewCustomAttributes = "";

		// eklaim_diagnosa
		$this->eklaim_diagnosa->ViewValue = $this->eklaim_diagnosa->CurrentValue;
		$this->eklaim_diagnosa->ViewCustomAttributes = "";

		// eklaim_procedure
		$this->eklaim_procedure->ViewValue = $this->eklaim_procedure->CurrentValue;
		$this->eklaim_procedure->ViewCustomAttributes = "";

		// eklaim_tarif_rs
		$this->eklaim_tarif_rs->ViewValue = $this->eklaim_tarif_rs->CurrentValue;
		$this->eklaim_tarif_rs->ViewCustomAttributes = "";

		// eklaim_tarif_poli_eks
		$this->eklaim_tarif_poli_eks->ViewValue = $this->eklaim_tarif_poli_eks->CurrentValue;
		$this->eklaim_tarif_poli_eks->ViewCustomAttributes = "";

		// eklaim_id_dokter
		$this->eklaim_id_dokter->ViewValue = $this->eklaim_id_dokter->CurrentValue;
		$this->eklaim_id_dokter->ViewCustomAttributes = "";

		// eklaim_nama_dokter
		$this->eklaim_nama_dokter->ViewValue = $this->eklaim_nama_dokter->CurrentValue;
		$this->eklaim_nama_dokter->ViewCustomAttributes = "";

		// eklaim_kode_tarif
		$this->eklaim_kode_tarif->ViewValue = $this->eklaim_kode_tarif->CurrentValue;
		$this->eklaim_kode_tarif->ViewCustomAttributes = "";

		// eklaim_payor_id
		$this->eklaim_payor_id->ViewValue = $this->eklaim_payor_id->CurrentValue;
		$this->eklaim_payor_id->ViewCustomAttributes = "";

		// eklaim_payor_cd
		$this->eklaim_payor_cd->ViewValue = $this->eklaim_payor_cd->CurrentValue;
		$this->eklaim_payor_cd->ViewCustomAttributes = "";

		// eklaim_coder_nik
		$this->eklaim_coder_nik->ViewValue = $this->eklaim_coder_nik->CurrentValue;
		$this->eklaim_coder_nik->ViewCustomAttributes = "";

		// eklaim_los
		$this->eklaim_los->ViewValue = $this->eklaim_los->CurrentValue;
		$this->eklaim_los->ViewCustomAttributes = "";

		// eklaim_patient_id
		$this->eklaim_patient_id->ViewValue = $this->eklaim_patient_id->CurrentValue;
		$this->eklaim_patient_id->ViewCustomAttributes = "";

		// eklaim_admission_id
		$this->eklaim_admission_id->ViewValue = $this->eklaim_admission_id->CurrentValue;
		$this->eklaim_admission_id->ViewCustomAttributes = "";

		// eklaim_hospital_admission_id
		$this->eklaim_hospital_admission_id->ViewValue = $this->eklaim_hospital_admission_id->CurrentValue;
		$this->eklaim_hospital_admission_id->ViewCustomAttributes = "";

		// bridging_hapussep
		$this->bridging_hapussep->ViewValue = $this->bridging_hapussep->CurrentValue;
		$this->bridging_hapussep->ViewCustomAttributes = "";

		// user_penghapus_sep
		$this->user_penghapus_sep->ViewValue = $this->user_penghapus_sep->CurrentValue;
		$this->user_penghapus_sep->ViewCustomAttributes = "";

		// BIAYA_BILLING_RAJAL
		$this->BIAYA_BILLING_RAJAL->ViewValue = $this->BIAYA_BILLING_RAJAL->CurrentValue;
		$this->BIAYA_BILLING_RAJAL->ViewCustomAttributes = "";

		// STATUS_PEMBAYARAN
		$this->STATUS_PEMBAYARAN->ViewValue = $this->STATUS_PEMBAYARAN->CurrentValue;
		$this->STATUS_PEMBAYARAN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_FISIOTERAPI
		$this->BIAYA_TINDAKAN_FISIOTERAPI->ViewValue = $this->BIAYA_TINDAKAN_FISIOTERAPI->CurrentValue;
		$this->BIAYA_TINDAKAN_FISIOTERAPI->ViewCustomAttributes = "";

		// eklaim_reg_pasien
		$this->eklaim_reg_pasien->ViewValue = $this->eklaim_reg_pasien->CurrentValue;
		$this->eklaim_reg_pasien->ViewCustomAttributes = "";

		// eklaim_reg_klaim_baru
		$this->eklaim_reg_klaim_baru->ViewValue = $this->eklaim_reg_klaim_baru->CurrentValue;
		$this->eklaim_reg_klaim_baru->ViewCustomAttributes = "";

		// eklaim_gruper1
		$this->eklaim_gruper1->ViewValue = $this->eklaim_gruper1->CurrentValue;
		$this->eklaim_gruper1->ViewCustomAttributes = "";

		// eklaim_gruper2
		$this->eklaim_gruper2->ViewValue = $this->eklaim_gruper2->CurrentValue;
		$this->eklaim_gruper2->ViewCustomAttributes = "";

		// eklaim_finalklaim
		$this->eklaim_finalklaim->ViewValue = $this->eklaim_finalklaim->CurrentValue;
		$this->eklaim_finalklaim->ViewCustomAttributes = "";

		// eklaim_sendklaim
		$this->eklaim_sendklaim->ViewValue = $this->eklaim_sendklaim->CurrentValue;
		$this->eklaim_sendklaim->ViewCustomAttributes = "";

		// eklaim_flag_hapus_pasien
		$this->eklaim_flag_hapus_pasien->ViewValue = $this->eklaim_flag_hapus_pasien->CurrentValue;
		$this->eklaim_flag_hapus_pasien->ViewCustomAttributes = "";

		// eklaim_flag_hapus_klaim
		$this->eklaim_flag_hapus_klaim->ViewValue = $this->eklaim_flag_hapus_klaim->CurrentValue;
		$this->eklaim_flag_hapus_klaim->ViewCustomAttributes = "";

		// eklaim_kemkes_dc_Status
		$this->eklaim_kemkes_dc_Status->ViewValue = $this->eklaim_kemkes_dc_Status->CurrentValue;
		$this->eklaim_kemkes_dc_Status->ViewCustomAttributes = "";

		// eklaim_bpjs_dc_Status
		$this->eklaim_bpjs_dc_Status->ViewValue = $this->eklaim_bpjs_dc_Status->CurrentValue;
		$this->eklaim_bpjs_dc_Status->ViewCustomAttributes = "";

		// eklaim_cbg_code
		$this->eklaim_cbg_code->ViewValue = $this->eklaim_cbg_code->CurrentValue;
		$this->eklaim_cbg_code->ViewCustomAttributes = "";

		// eklaim_cbg_descprition
		$this->eklaim_cbg_descprition->ViewValue = $this->eklaim_cbg_descprition->CurrentValue;
		$this->eklaim_cbg_descprition->ViewCustomAttributes = "";

		// eklaim_cbg_tariff
		$this->eklaim_cbg_tariff->ViewValue = $this->eklaim_cbg_tariff->CurrentValue;
		$this->eklaim_cbg_tariff->ViewCustomAttributes = "";

		// eklaim_sub_acute_code
		$this->eklaim_sub_acute_code->ViewValue = $this->eklaim_sub_acute_code->CurrentValue;
		$this->eklaim_sub_acute_code->ViewCustomAttributes = "";

		// eklaim_sub_acute_deskripsi
		$this->eklaim_sub_acute_deskripsi->ViewValue = $this->eklaim_sub_acute_deskripsi->CurrentValue;
		$this->eklaim_sub_acute_deskripsi->ViewCustomAttributes = "";

		// eklaim_sub_acute_tariff
		$this->eklaim_sub_acute_tariff->ViewValue = $this->eklaim_sub_acute_tariff->CurrentValue;
		$this->eklaim_sub_acute_tariff->ViewCustomAttributes = "";

		// eklaim_chronic_code
		$this->eklaim_chronic_code->ViewValue = $this->eklaim_chronic_code->CurrentValue;
		$this->eklaim_chronic_code->ViewCustomAttributes = "";

		// eklaim_chronic_deskripsi
		$this->eklaim_chronic_deskripsi->ViewValue = $this->eklaim_chronic_deskripsi->CurrentValue;
		$this->eklaim_chronic_deskripsi->ViewCustomAttributes = "";

		// eklaim_chronic_tariff
		$this->eklaim_chronic_tariff->ViewValue = $this->eklaim_chronic_tariff->CurrentValue;
		$this->eklaim_chronic_tariff->ViewCustomAttributes = "";

		// eklaim_inacbg_version
		$this->eklaim_inacbg_version->ViewValue = $this->eklaim_inacbg_version->CurrentValue;
		$this->eklaim_inacbg_version->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_IBS_RAJAL
		$this->BIAYA_TINDAKAN_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_IBS_RAJAL->ViewCustomAttributes = "";

		// VERIFY_ICD
		$this->VERIFY_ICD->ViewValue = $this->VERIFY_ICD->CurrentValue;
		$this->VERIFY_ICD->ViewCustomAttributes = "";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->ViewValue = $this->bridging_rujukan_faskes_2->CurrentValue;
		$this->bridging_rujukan_faskes_2->ViewCustomAttributes = "";

		// eklaim_reedit_claim
		$this->eklaim_reedit_claim->ViewValue = $this->eklaim_reedit_claim->CurrentValue;
		$this->eklaim_reedit_claim->ViewCustomAttributes = "";

		// KETERANGAN
		$this->KETERANGAN->ViewValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->ViewCustomAttributes = "";

		// TGLLAHIR
		$this->TGLLAHIR->ViewValue = $this->TGLLAHIR->CurrentValue;
		$this->TGLLAHIR->ViewValue = ew_FormatDateTime($this->TGLLAHIR->ViewValue, 0);
		$this->TGLLAHIR->ViewCustomAttributes = "";

		// USER_KASIR
		$this->USER_KASIR->ViewValue = $this->USER_KASIR->CurrentValue;
		$this->USER_KASIR->ViewCustomAttributes = "";

		// eklaim_tgl_gruping
		$this->eklaim_tgl_gruping->ViewValue = $this->eklaim_tgl_gruping->CurrentValue;
		$this->eklaim_tgl_gruping->ViewValue = ew_FormatDateTime($this->eklaim_tgl_gruping->ViewValue, 0);
		$this->eklaim_tgl_gruping->ViewCustomAttributes = "";

		// eklaim_tgl_finalklaim
		$this->eklaim_tgl_finalklaim->ViewValue = $this->eklaim_tgl_finalklaim->CurrentValue;
		$this->eklaim_tgl_finalklaim->ViewValue = ew_FormatDateTime($this->eklaim_tgl_finalklaim->ViewValue, 0);
		$this->eklaim_tgl_finalklaim->ViewCustomAttributes = "";

		// eklaim_tgl_kirim_klaim
		$this->eklaim_tgl_kirim_klaim->ViewValue = $this->eklaim_tgl_kirim_klaim->CurrentValue;
		$this->eklaim_tgl_kirim_klaim->ViewValue = ew_FormatDateTime($this->eklaim_tgl_kirim_klaim->ViewValue, 0);
		$this->eklaim_tgl_kirim_klaim->ViewCustomAttributes = "";

		// BIAYA_OBAT_RS
		$this->BIAYA_OBAT_RS->ViewValue = $this->BIAYA_OBAT_RS->CurrentValue;
		$this->BIAYA_OBAT_RS->ViewCustomAttributes = "";

		// EKG_RAJAL
		$this->EKG_RAJAL->ViewValue = $this->EKG_RAJAL->CurrentValue;
		$this->EKG_RAJAL->ViewCustomAttributes = "";

		// USG_RAJAL
		$this->USG_RAJAL->ViewValue = $this->USG_RAJAL->CurrentValue;
		$this->USG_RAJAL->ViewCustomAttributes = "";

		// FISIOTERAPI_RAJAL
		$this->FISIOTERAPI_RAJAL->ViewValue = $this->FISIOTERAPI_RAJAL->CurrentValue;
		$this->FISIOTERAPI_RAJAL->ViewCustomAttributes = "";

		// BHP_RAJAL
		$this->BHP_RAJAL->ViewValue = $this->BHP_RAJAL->CurrentValue;
		$this->BHP_RAJAL->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_ASKEP_IBS_RAJAL
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_ASKEP_IBS_RAJAL->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_TMNO_IBS_RAJAL
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->ViewValue = $this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->CurrentValue;
		$this->BIAYA_TINDAKAN_TMNO_IBS_RAJAL->ViewCustomAttributes = "";

		// TOTAL_BIAYA_IBS_RAJAL
		$this->TOTAL_BIAYA_IBS_RAJAL->ViewValue = $this->TOTAL_BIAYA_IBS_RAJAL->CurrentValue;
		$this->TOTAL_BIAYA_IBS_RAJAL->ViewCustomAttributes = "";

		// ORDER_LAB
		$this->ORDER_LAB->ViewValue = $this->ORDER_LAB->CurrentValue;
		$this->ORDER_LAB->ViewCustomAttributes = "";

		// BILL_RAJAL_SELESAI
		$this->BILL_RAJAL_SELESAI->ViewValue = $this->BILL_RAJAL_SELESAI->CurrentValue;
		$this->BILL_RAJAL_SELESAI->ViewCustomAttributes = "";

		// INCLUDE_IDXDAFTAR
		$this->INCLUDE_IDXDAFTAR->ViewValue = $this->INCLUDE_IDXDAFTAR->CurrentValue;
		$this->INCLUDE_IDXDAFTAR->ViewCustomAttributes = "";

		// INCLUDE_HARGA
		$this->INCLUDE_HARGA->ViewValue = $this->INCLUDE_HARGA->CurrentValue;
		$this->INCLUDE_HARGA->ViewCustomAttributes = "";

		// TARIF_JASA_SARANA
		$this->TARIF_JASA_SARANA->ViewValue = $this->TARIF_JASA_SARANA->CurrentValue;
		$this->TARIF_JASA_SARANA->ViewCustomAttributes = "";

		// TARIF_PENUNJANG_NON_MEDIS
		$this->TARIF_PENUNJANG_NON_MEDIS->ViewValue = $this->TARIF_PENUNJANG_NON_MEDIS->CurrentValue;
		$this->TARIF_PENUNJANG_NON_MEDIS->ViewCustomAttributes = "";

		// TARIF_ASUHAN_KEPERAWATAN
		$this->TARIF_ASUHAN_KEPERAWATAN->ViewValue = $this->TARIF_ASUHAN_KEPERAWATAN->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN->ViewCustomAttributes = "";

		// KDDOKTER_RAJAL
		$this->KDDOKTER_RAJAL->ViewValue = $this->KDDOKTER_RAJAL->CurrentValue;
		$this->KDDOKTER_RAJAL->ViewCustomAttributes = "";

		// KDDOKTER_KONSUL_RAJAL
		$this->KDDOKTER_KONSUL_RAJAL->ViewValue = $this->KDDOKTER_KONSUL_RAJAL->CurrentValue;
		$this->KDDOKTER_KONSUL_RAJAL->ViewCustomAttributes = "";

		// BIAYA_BILLING_RS
		$this->BIAYA_BILLING_RS->ViewValue = $this->BIAYA_BILLING_RS->CurrentValue;
		$this->BIAYA_BILLING_RS->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_TMO
		$this->BIAYA_TINDAKAN_POLI_TMO->ViewValue = $this->BIAYA_TINDAKAN_POLI_TMO->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_TMO->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_KEPERAWATAN
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->ViewValue = $this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_KEPERAWATAN->ViewCustomAttributes = "";

		// BHP_RAJAL_TMO
		$this->BHP_RAJAL_TMO->ViewValue = $this->BHP_RAJAL_TMO->CurrentValue;
		$this->BHP_RAJAL_TMO->ViewCustomAttributes = "";

		// BHP_RAJAL_KEPERAWATAN
		$this->BHP_RAJAL_KEPERAWATAN->ViewValue = $this->BHP_RAJAL_KEPERAWATAN->CurrentValue;
		$this->BHP_RAJAL_KEPERAWATAN->ViewCustomAttributes = "";

		// TARIF_AKOMODASI
		$this->TARIF_AKOMODASI->ViewValue = $this->TARIF_AKOMODASI->CurrentValue;
		$this->TARIF_AKOMODASI->ViewCustomAttributes = "";

		// TARIF_AMBULAN
		$this->TARIF_AMBULAN->ViewValue = $this->TARIF_AMBULAN->CurrentValue;
		$this->TARIF_AMBULAN->ViewCustomAttributes = "";

		// TARIF_OKSIGEN
		$this->TARIF_OKSIGEN->ViewValue = $this->TARIF_OKSIGEN->CurrentValue;
		$this->TARIF_OKSIGEN->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_JENAZAH
		$this->BIAYA_TINDAKAN_JENAZAH->ViewValue = $this->BIAYA_TINDAKAN_JENAZAH->CurrentValue;
		$this->BIAYA_TINDAKAN_JENAZAH->ViewCustomAttributes = "";

		// BIAYA_BILLING_IGD
		$this->BIAYA_BILLING_IGD->ViewValue = $this->BIAYA_BILLING_IGD->CurrentValue;
		$this->BIAYA_BILLING_IGD->ViewCustomAttributes = "";

		// BIAYA_TINDAKAN_POLI_PERSALINAN
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->ViewValue = $this->BIAYA_TINDAKAN_POLI_PERSALINAN->CurrentValue;
		$this->BIAYA_TINDAKAN_POLI_PERSALINAN->ViewCustomAttributes = "";

		// BHP_RAJAL_PERSALINAN
		$this->BHP_RAJAL_PERSALINAN->ViewValue = $this->BHP_RAJAL_PERSALINAN->CurrentValue;
		$this->BHP_RAJAL_PERSALINAN->ViewCustomAttributes = "";

		// TARIF_BIMBINGAN_ROHANI
		$this->TARIF_BIMBINGAN_ROHANI->ViewValue = $this->TARIF_BIMBINGAN_ROHANI->CurrentValue;
		$this->TARIF_BIMBINGAN_ROHANI->ViewCustomAttributes = "";

		// BIAYA_BILLING_RS2
		$this->BIAYA_BILLING_RS2->ViewValue = $this->BIAYA_BILLING_RS2->CurrentValue;
		$this->BIAYA_BILLING_RS2->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_IGD
		$this->BIAYA_TARIF_DOKTER_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_IGD->ViewCustomAttributes = "";

		// BIAYA_PENDAFTARAN_IGD
		$this->BIAYA_PENDAFTARAN_IGD->ViewValue = $this->BIAYA_PENDAFTARAN_IGD->CurrentValue;
		$this->BIAYA_PENDAFTARAN_IGD->ViewCustomAttributes = "";

		// BIAYA_BILLING_IBS
		$this->BIAYA_BILLING_IBS->ViewValue = $this->BIAYA_BILLING_IBS->CurrentValue;
		$this->BIAYA_BILLING_IBS->ViewCustomAttributes = "";

		// TARIF_JASA_SARANA_IGD
		$this->TARIF_JASA_SARANA_IGD->ViewValue = $this->TARIF_JASA_SARANA_IGD->CurrentValue;
		$this->TARIF_JASA_SARANA_IGD->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_SPESIALIS_IGD
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_SPESIALIS_IGD->ViewCustomAttributes = "";

		// BIAYA_TARIF_DOKTER_KONSUL_IGD
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->ViewValue = $this->BIAYA_TARIF_DOKTER_KONSUL_IGD->CurrentValue;
		$this->BIAYA_TARIF_DOKTER_KONSUL_IGD->ViewCustomAttributes = "";

		// TARIF_MAKAN_IGD
		$this->TARIF_MAKAN_IGD->ViewValue = $this->TARIF_MAKAN_IGD->CurrentValue;
		$this->TARIF_MAKAN_IGD->ViewCustomAttributes = "";

		// TARIF_ASUHAN_KEPERAWATAN_IGD
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->ViewValue = $this->TARIF_ASUHAN_KEPERAWATAN_IGD->CurrentValue;
		$this->TARIF_ASUHAN_KEPERAWATAN_IGD->ViewCustomAttributes = "";

		// pasien_TEMPAT
		$this->pasien_TEMPAT->ViewValue = $this->pasien_TEMPAT->CurrentValue;
		$this->pasien_TEMPAT->ViewCustomAttributes = "";

		// pasien_TGLLAHIR
		$this->pasien_TGLLAHIR->ViewValue = $this->pasien_TGLLAHIR->CurrentValue;
		$this->pasien_TGLLAHIR->ViewValue = ew_FormatDateTime($this->pasien_TGLLAHIR->ViewValue, 7);
		$this->pasien_TGLLAHIR->ViewCustomAttributes = "";

		// pasien_JENISKELAMIN
		if (strval($this->pasien_JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->pasien_JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JENISKELAMIN->ViewValue = $this->pasien_JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->pasien_JENISKELAMIN->ViewValue = NULL;
		}
		$this->pasien_JENISKELAMIN->ViewCustomAttributes = "";

		// pasien_KDPROVINSI
		if (strval($this->pasien_KDPROVINSI->CurrentValue) <> "") {
			$sFilterWrk = "`idprovinsi`" . ew_SearchString("=", $this->pasien_KDPROVINSI->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idprovinsi`, `namaprovinsi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_provinsi`";
		$sWhereWrk = "";
		$this->pasien_KDPROVINSI->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KDPROVINSI, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KDPROVINSI->ViewValue = $this->pasien_KDPROVINSI->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KDPROVINSI->ViewValue = $this->pasien_KDPROVINSI->CurrentValue;
			}
		} else {
			$this->pasien_KDPROVINSI->ViewValue = NULL;
		}
		$this->pasien_KDPROVINSI->ViewCustomAttributes = "";

		// pasien_KOTA
		if (strval($this->pasien_KOTA->CurrentValue) <> "") {
			$sFilterWrk = "`idkota`" . ew_SearchString("=", $this->pasien_KOTA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkota`, `namakota` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kota`";
		$sWhereWrk = "";
		$this->pasien_KOTA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KOTA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KOTA->ViewValue = $this->pasien_KOTA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KOTA->ViewValue = $this->pasien_KOTA->CurrentValue;
			}
		} else {
			$this->pasien_KOTA->ViewValue = NULL;
		}
		$this->pasien_KOTA->ViewCustomAttributes = "";

		// pasien_KDKECAMATAN
		if (strval($this->pasien_KDKECAMATAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkecamatan`" . ew_SearchString("=", $this->pasien_KDKECAMATAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkecamatan`, `namakecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kecamatan`";
		$sWhereWrk = "";
		$this->pasien_KDKECAMATAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KDKECAMATAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KDKECAMATAN->ViewValue = $this->pasien_KDKECAMATAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KDKECAMATAN->ViewValue = $this->pasien_KDKECAMATAN->CurrentValue;
			}
		} else {
			$this->pasien_KDKECAMATAN->ViewValue = NULL;
		}
		$this->pasien_KDKECAMATAN->ViewCustomAttributes = "";

		// pasien_KELURAHAN
		if (strval($this->pasien_KELURAHAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkelurahan`" . ew_SearchString("=", $this->pasien_KELURAHAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkelurahan`, `namakelurahan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kelurahan`";
		$sWhereWrk = "";
		$this->pasien_KELURAHAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KELURAHAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KELURAHAN->ViewValue = $this->pasien_KELURAHAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KELURAHAN->ViewValue = $this->pasien_KELURAHAN->CurrentValue;
			}
		} else {
			$this->pasien_KELURAHAN->ViewValue = NULL;
		}
		$this->pasien_KELURAHAN->ViewCustomAttributes = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->ViewValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->ViewCustomAttributes = "";

		// pasien_NOKTP
		$this->pasien_NOKTP->ViewValue = $this->pasien_NOKTP->CurrentValue;
		$this->pasien_NOKTP->ViewCustomAttributes = "";

		// pasien_SUAMI_ORTU
		$this->pasien_SUAMI_ORTU->ViewValue = $this->pasien_SUAMI_ORTU->CurrentValue;
		$this->pasien_SUAMI_ORTU->ViewCustomAttributes = "";

		// pasien_PEKERJAAN
		$this->pasien_PEKERJAAN->ViewValue = $this->pasien_PEKERJAAN->CurrentValue;
		$this->pasien_PEKERJAAN->ViewCustomAttributes = "";

		// pasien_AGAMA
		if (strval($this->pasien_AGAMA->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
		$sWhereWrk = "";
		$this->pasien_AGAMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_AGAMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_AGAMA->ViewValue = $this->pasien_AGAMA->CurrentValue;
			}
		} else {
			$this->pasien_AGAMA->ViewValue = NULL;
		}
		$this->pasien_AGAMA->ViewCustomAttributes = "";

		// pasien_PENDIDIKAN
		if (strval($this->pasien_PENDIDIKAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
		$sWhereWrk = "";
		$this->pasien_PENDIDIKAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_PENDIDIKAN->ViewValue = $this->pasien_PENDIDIKAN->CurrentValue;
			}
		} else {
			$this->pasien_PENDIDIKAN->ViewValue = NULL;
		}
		$this->pasien_PENDIDIKAN->ViewCustomAttributes = "";

		// pasien_ALAMAT_KTP
		$this->pasien_ALAMAT_KTP->ViewValue = $this->pasien_ALAMAT_KTP->CurrentValue;
		$this->pasien_ALAMAT_KTP->ViewCustomAttributes = "";

		// pasien_NO_KARTU
		$this->pasien_NO_KARTU->ViewValue = $this->pasien_NO_KARTU->CurrentValue;
		$this->pasien_NO_KARTU->ViewCustomAttributes = "";

		// pasien_JNS_PASIEN
		if (strval($this->pasien_JNS_PASIEN->CurrentValue) <> "") {
			$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->pasien_JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
		$sWhereWrk = "";
		$this->pasien_JNS_PASIEN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_JNS_PASIEN->ViewValue = $this->pasien_JNS_PASIEN->CurrentValue;
			}
		} else {
			$this->pasien_JNS_PASIEN->ViewValue = NULL;
		}
		$this->pasien_JNS_PASIEN->ViewCustomAttributes = "";

		// pasien_nama_ayah
		$this->pasien_nama_ayah->ViewValue = $this->pasien_nama_ayah->CurrentValue;
		$this->pasien_nama_ayah->ViewCustomAttributes = "";

		// pasien_nama_ibu
		$this->pasien_nama_ibu->ViewValue = $this->pasien_nama_ibu->CurrentValue;
		$this->pasien_nama_ibu->ViewCustomAttributes = "";

		// pasien_nama_suami
		$this->pasien_nama_suami->ViewValue = $this->pasien_nama_suami->CurrentValue;
		$this->pasien_nama_suami->ViewCustomAttributes = "";

		// pasien_nama_istri
		$this->pasien_nama_istri->ViewValue = $this->pasien_nama_istri->CurrentValue;
		$this->pasien_nama_istri->ViewCustomAttributes = "";

		// pasien_KD_ETNIS
		if (strval($this->pasien_KD_ETNIS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
		$sWhereWrk = "";
		$this->pasien_KD_ETNIS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_ETNIS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_ETNIS->ViewValue = $this->pasien_KD_ETNIS->CurrentValue;
			}
		} else {
			$this->pasien_KD_ETNIS->ViewValue = NULL;
		}
		$this->pasien_KD_ETNIS->ViewCustomAttributes = "";

		// pasien_KD_BHS_HARIAN
		if (strval($this->pasien_KD_BHS_HARIAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->pasien_KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
		$sWhereWrk = "";
		$this->pasien_KD_BHS_HARIAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->pasien_KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->pasien_KD_BHS_HARIAN->ViewValue = $this->pasien_KD_BHS_HARIAN->CurrentValue;
			}
		} else {
			$this->pasien_KD_BHS_HARIAN->ViewValue = NULL;
		}
		$this->pasien_KD_BHS_HARIAN->ViewCustomAttributes = "";

		// biaya_obat_2
		$this->biaya_obat_2->ViewValue = $this->biaya_obat_2->CurrentValue;
		$this->biaya_obat_2->ViewCustomAttributes = "";

		// biaya_retur_obat_2
		$this->biaya_retur_obat_2->ViewValue = $this->biaya_retur_obat_2->CurrentValue;
		$this->biaya_retur_obat_2->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT_2
		$this->TOTAL_BIAYA_OBAT_2->ViewValue = $this->TOTAL_BIAYA_OBAT_2->CurrentValue;
		$this->TOTAL_BIAYA_OBAT_2->ViewCustomAttributes = "";

		// KDCARABAYAR2
		$this->KDCARABAYAR2->ViewValue = $this->KDCARABAYAR2->CurrentValue;
		$this->KDCARABAYAR2->ViewCustomAttributes = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// biaya_obat_2
			$this->biaya_obat_2->LinkCustomAttributes = "";
			$this->biaya_obat_2->HrefValue = "";
			$this->biaya_obat_2->TooltipValue = "";

			// biaya_retur_obat_2
			$this->biaya_retur_obat_2->LinkCustomAttributes = "";
			$this->biaya_retur_obat_2->HrefValue = "";
			$this->biaya_retur_obat_2->TooltipValue = "";

			// TOTAL_BIAYA_OBAT_2
			$this->TOTAL_BIAYA_OBAT_2->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_OBAT_2->HrefValue = "";
			$this->TOTAL_BIAYA_OBAT_2->TooltipValue = "";

			// KDCARABAYAR2
			$this->KDCARABAYAR2->LinkCustomAttributes = "";
			$this->KDCARABAYAR2->HrefValue = "";
			$this->KDCARABAYAR2->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// TGLREG
			$this->TGLREG->EditAttrs["class"] = "form-control";
			$this->TGLREG->EditCustomAttributes = "";
			$this->TGLREG->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->TGLREG->AdvancedSearch->SearchValue, 7), 7));
			$this->TGLREG->PlaceHolder = ew_RemoveHtml($this->TGLREG->FldCaption());
			$this->TGLREG->EditAttrs["class"] = "form-control";
			$this->TGLREG->EditCustomAttributes = "";
			$this->TGLREG->EditValue2 = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->TGLREG->AdvancedSearch->SearchValue2, 7), 7));
			$this->TGLREG->PlaceHolder = ew_RemoveHtml($this->TGLREG->FldCaption());

			// NOMR
			$this->NOMR->EditAttrs["class"] = "form-control";
			$this->NOMR->EditCustomAttributes = "";
			$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->AdvancedSearch->SearchValue);
			if (strval($this->NOMR->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "";
			$this->NOMR->LookupFilters = array("dx1" => '`NOMR`', "dx2" => '`NAMA`', "dx3" => '`ALAMAT`');
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$arwrk[3] = ew_HtmlEncode($rswrk->fields('Disp3Fld'));
					$this->NOMR->EditValue = $this->NOMR->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->AdvancedSearch->SearchValue);
				}
			} else {
				$this->NOMR->EditValue = NULL;
			}
			$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

			// KDPOLY
			$this->KDPOLY->EditAttrs["class"] = "form-control";
			$this->KDPOLY->EditCustomAttributes = "";
			if (trim(strval($this->KDPOLY->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_poly`";
			$sWhereWrk = "";
			$this->KDPOLY->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->KDPOLY->EditValue = $arwrk;

			// biaya_obat_2
			$this->biaya_obat_2->EditAttrs["class"] = "form-control";
			$this->biaya_obat_2->EditCustomAttributes = "";
			$this->biaya_obat_2->EditValue = ew_HtmlEncode($this->biaya_obat_2->AdvancedSearch->SearchValue);
			$this->biaya_obat_2->PlaceHolder = ew_RemoveHtml($this->biaya_obat_2->FldCaption());

			// biaya_retur_obat_2
			$this->biaya_retur_obat_2->EditAttrs["class"] = "form-control";
			$this->biaya_retur_obat_2->EditCustomAttributes = "";
			$this->biaya_retur_obat_2->EditValue = ew_HtmlEncode($this->biaya_retur_obat_2->AdvancedSearch->SearchValue);
			$this->biaya_retur_obat_2->PlaceHolder = ew_RemoveHtml($this->biaya_retur_obat_2->FldCaption());

			// TOTAL_BIAYA_OBAT_2
			$this->TOTAL_BIAYA_OBAT_2->EditAttrs["class"] = "form-control";
			$this->TOTAL_BIAYA_OBAT_2->EditCustomAttributes = "";
			$this->TOTAL_BIAYA_OBAT_2->EditValue = ew_HtmlEncode($this->TOTAL_BIAYA_OBAT_2->AdvancedSearch->SearchValue);
			$this->TOTAL_BIAYA_OBAT_2->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_OBAT_2->FldCaption());

			// KDCARABAYAR2
			$this->KDCARABAYAR2->EditAttrs["class"] = "form-control";
			$this->KDCARABAYAR2->EditCustomAttributes = "";
			$this->KDCARABAYAR2->EditValue = ew_HtmlEncode($this->KDCARABAYAR2->AdvancedSearch->SearchValue);
			$this->KDCARABAYAR2->PlaceHolder = ew_RemoveHtml($this->KDCARABAYAR2->FldCaption());
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
		if (!ew_CheckEuroDate($this->TGLREG->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->TGLREG->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->TGLREG->AdvancedSearch->SearchValue2)) {
			ew_AddMessage($gsSearchError, $this->TGLREG->FldErrMsg());
		}
		if (!ew_CheckNumber($this->biaya_obat_2->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->biaya_obat_2->FldErrMsg());
		}
		if (!ew_CheckNumber($this->biaya_retur_obat_2->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->biaya_retur_obat_2->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOTAL_BIAYA_OBAT_2->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->TOTAL_BIAYA_OBAT_2->FldErrMsg());
		}
		if (!ew_CheckInteger($this->KDCARABAYAR2->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->KDCARABAYAR2->FldErrMsg());
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
		$this->TGLREG->AdvancedSearch->Load();
		$this->NOMR->AdvancedSearch->Load();
		$this->KDPOLY->AdvancedSearch->Load();
		$this->biaya_obat_2->AdvancedSearch->Load();
		$this->biaya_retur_obat_2->AdvancedSearch->Load();
		$this->TOTAL_BIAYA_OBAT_2->AdvancedSearch->Load();
		$this->KDCARABAYAR2->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_pendaftaranlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_NOMR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR` AS `LinkFld`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "{filter}";
			$this->NOMR->LookupFilters = array("dx1" => '`NOMR`', "dx2" => '`NAMA`', "dx3" => '`ALAMAT`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`NOMR` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_KDPOLY":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "";
			$this->KDPOLY->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
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
		case "x_NOMR":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, `ALAMAT` AS `Disp3Fld` FROM `m_pasien`";
			$sWhereWrk = "`NOMR` LIKE '%{query_value}%' OR `NAMA` LIKE '%{query_value}%' OR `ALAMAT` LIKE '%{query_value}%' OR CONCAT(`NOMR`,'" . ew_ValueSeparator(1, $this->NOMR) . "',`NAMA`,'" . ew_ValueSeparator(2, $this->NOMR) . "',`ALAMAT`) LIKE '{query_value}%'";
			$this->NOMR->LookupFilters = array("dx1" => '`NOMR`', "dx2" => '`NAMA`', "dx3" => '`ALAMAT`');
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t_pendaftaran_search)) $t_pendaftaran_search = new ct_pendaftaran_search();

// Page init
$t_pendaftaran_search->Page_Init();

// Page main
$t_pendaftaran_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_pendaftaran_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($t_pendaftaran_search->IsModal) { ?>
var CurrentAdvancedSearchForm = ft_pendaftaransearch = new ew_Form("ft_pendaftaransearch", "search");
<?php } else { ?>
var CurrentForm = ft_pendaftaransearch = new ew_Form("ft_pendaftaransearch", "search");
<?php } ?>

// Form_CustomValidate event
ft_pendaftaransearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_pendaftaransearch.ValidateRequired = true;
<?php } else { ?>
ft_pendaftaransearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_pendaftaransearch.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","x_ALAMAT",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_pendaftaransearch.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_KDDOKTER"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};

// Form object for search
// Validate function for search

ft_pendaftaransearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_TGLREG");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->TGLREG->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_biaya_obat_2");
	if (elm && !ew_CheckNumber(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->biaya_obat_2->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_biaya_retur_obat_2");
	if (elm && !ew_CheckNumber(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->biaya_retur_obat_2->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_TOTAL_BIAYA_OBAT_2");
	if (elm && !ew_CheckNumber(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->TOTAL_BIAYA_OBAT_2->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_KDCARABAYAR2");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($t_pendaftaran->KDCARABAYAR2->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_pendaftaran_search->IsModal) { ?>
<?php } ?>
<?php $t_pendaftaran_search->ShowPageHeader(); ?>
<?php
$t_pendaftaran_search->ShowMessage();
?>
<form name="ft_pendaftaransearch" id="ft_pendaftaransearch" class="<?php echo $t_pendaftaran_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_pendaftaran_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_pendaftaran_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_pendaftaran">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($t_pendaftaran_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_pendaftaran->TGLREG->Visible) { // TGLREG ?>
	<div id="r_TGLREG" class="form-group">
		<label for="x_TGLREG" class="<?php echo $t_pendaftaran_search->SearchLabelClass ?>"><span id="elh_t_pendaftaran_TGLREG"><?php echo $t_pendaftaran->TGLREG->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("BETWEEN") ?><input type="hidden" name="z_TGLREG" id="z_TGLREG" value="BETWEEN"></p>
		</label>
		<div class="<?php echo $t_pendaftaran_search->SearchRightColumnClass ?>"><div<?php echo $t_pendaftaran->TGLREG->CellAttributes() ?>>
			<span id="el_t_pendaftaran_TGLREG">
<input type="text" data-table="t_pendaftaran" data-field="x_TGLREG" data-format="7" name="x_TGLREG" id="x_TGLREG" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->TGLREG->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->TGLREG->EditValue ?>"<?php echo $t_pendaftaran->TGLREG->EditAttributes() ?>>
<?php if (!$t_pendaftaran->TGLREG->ReadOnly && !$t_pendaftaran->TGLREG->Disabled && !isset($t_pendaftaran->TGLREG->EditAttrs["readonly"]) && !isset($t_pendaftaran->TGLREG->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_pendaftaransearch", "x_TGLREG", 7);
</script>
<?php } ?>
</span>
			<span class="ewSearchCond btw1_TGLREG">&nbsp;<?php echo $Language->Phrase("AND") ?>&nbsp;</span>
			<span id="e2_t_pendaftaran_TGLREG" class="btw1_TGLREG">
<input type="text" data-table="t_pendaftaran" data-field="x_TGLREG" data-format="7" name="y_TGLREG" id="y_TGLREG" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->TGLREG->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->TGLREG->EditValue2 ?>"<?php echo $t_pendaftaran->TGLREG->EditAttributes() ?>>
<?php if (!$t_pendaftaran->TGLREG->ReadOnly && !$t_pendaftaran->TGLREG->Disabled && !isset($t_pendaftaran->TGLREG->EditAttrs["readonly"]) && !isset($t_pendaftaran->TGLREG->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_pendaftaransearch", "y_TGLREG", 7);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label class="<?php echo $t_pendaftaran_search->SearchLabelClass ?>"><span id="elh_t_pendaftaran_NOMR"><?php echo $t_pendaftaran->NOMR->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NOMR" id="z_NOMR" value="LIKE"></p>
		</label>
		<div class="<?php echo $t_pendaftaran_search->SearchRightColumnClass ?>"><div<?php echo $t_pendaftaran->NOMR->CellAttributes() ?>>
			<span id="el_t_pendaftaran_NOMR">
<?php
$wrkonchange = trim(" " . @$t_pendaftaran->NOMR->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_pendaftaran->NOMR->EditAttrs["onchange"] = "";
?>
<span id="as_x_NOMR" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_NOMR" id="sv_x_NOMR" value="<?php echo $t_pendaftaran->NOMR->EditValue ?>" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->NOMR->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->NOMR->getPlaceHolder()) ?>"<?php echo $t_pendaftaran->NOMR->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_pendaftaran" data-field="x_NOMR" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $t_pendaftaran->NOMR->DisplayValueSeparatorAttribute() ?>" name="x_NOMR" id="x_NOMR" value="<?php echo ew_HtmlEncode($t_pendaftaran->NOMR->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_NOMR" id="q_x_NOMR" value="<?php echo $t_pendaftaran->NOMR->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_pendaftaransearch.CreateAutoSuggest({"id":"x_NOMR","forceSelect":true});
</script>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($t_pendaftaran->NOMR->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NOMR',m:0,n:10,srch:false});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" name="s_x_NOMR" id="s_x_NOMR" value="<?php echo $t_pendaftaran->NOMR->LookupFilterQuery(false) ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->KDPOLY->Visible) { // KDPOLY ?>
	<div id="r_KDPOLY" class="form-group">
		<label for="x_KDPOLY" class="<?php echo $t_pendaftaran_search->SearchLabelClass ?>"><span id="elh_t_pendaftaran_KDPOLY"><?php echo $t_pendaftaran->KDPOLY->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_KDPOLY" id="z_KDPOLY" value="="></p>
		</label>
		<div class="<?php echo $t_pendaftaran_search->SearchRightColumnClass ?>"><div<?php echo $t_pendaftaran->KDPOLY->CellAttributes() ?>>
			<span id="el_t_pendaftaran_KDPOLY">
<select data-table="t_pendaftaran" data-field="x_KDPOLY" data-value-separator="<?php echo $t_pendaftaran->KDPOLY->DisplayValueSeparatorAttribute() ?>" id="x_KDPOLY" name="x_KDPOLY"<?php echo $t_pendaftaran->KDPOLY->EditAttributes() ?>>
<?php echo $t_pendaftaran->KDPOLY->SelectOptionListHtml("x_KDPOLY") ?>
</select>
<input type="hidden" name="s_x_KDPOLY" id="s_x_KDPOLY" value="<?php echo $t_pendaftaran->KDPOLY->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->biaya_obat_2->Visible) { // biaya_obat_2 ?>
	<div id="r_biaya_obat_2" class="form-group">
		<label for="x_biaya_obat_2" class="<?php echo $t_pendaftaran_search->SearchLabelClass ?>"><span id="elh_t_pendaftaran_biaya_obat_2"><?php echo $t_pendaftaran->biaya_obat_2->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_biaya_obat_2" id="z_biaya_obat_2" value="="></p>
		</label>
		<div class="<?php echo $t_pendaftaran_search->SearchRightColumnClass ?>"><div<?php echo $t_pendaftaran->biaya_obat_2->CellAttributes() ?>>
			<span id="el_t_pendaftaran_biaya_obat_2">
<input type="text" data-table="t_pendaftaran" data-field="x_biaya_obat_2" name="x_biaya_obat_2" id="x_biaya_obat_2" size="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->biaya_obat_2->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->biaya_obat_2->EditValue ?>"<?php echo $t_pendaftaran->biaya_obat_2->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->biaya_retur_obat_2->Visible) { // biaya_retur_obat_2 ?>
	<div id="r_biaya_retur_obat_2" class="form-group">
		<label for="x_biaya_retur_obat_2" class="<?php echo $t_pendaftaran_search->SearchLabelClass ?>"><span id="elh_t_pendaftaran_biaya_retur_obat_2"><?php echo $t_pendaftaran->biaya_retur_obat_2->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_biaya_retur_obat_2" id="z_biaya_retur_obat_2" value="="></p>
		</label>
		<div class="<?php echo $t_pendaftaran_search->SearchRightColumnClass ?>"><div<?php echo $t_pendaftaran->biaya_retur_obat_2->CellAttributes() ?>>
			<span id="el_t_pendaftaran_biaya_retur_obat_2">
<input type="text" data-table="t_pendaftaran" data-field="x_biaya_retur_obat_2" name="x_biaya_retur_obat_2" id="x_biaya_retur_obat_2" size="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->biaya_retur_obat_2->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->biaya_retur_obat_2->EditValue ?>"<?php echo $t_pendaftaran->biaya_retur_obat_2->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->TOTAL_BIAYA_OBAT_2->Visible) { // TOTAL_BIAYA_OBAT_2 ?>
	<div id="r_TOTAL_BIAYA_OBAT_2" class="form-group">
		<label for="x_TOTAL_BIAYA_OBAT_2" class="<?php echo $t_pendaftaran_search->SearchLabelClass ?>"><span id="elh_t_pendaftaran_TOTAL_BIAYA_OBAT_2"><?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_TOTAL_BIAYA_OBAT_2" id="z_TOTAL_BIAYA_OBAT_2" value="="></p>
		</label>
		<div class="<?php echo $t_pendaftaran_search->SearchRightColumnClass ?>"><div<?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->CellAttributes() ?>>
			<span id="el_t_pendaftaran_TOTAL_BIAYA_OBAT_2">
<input type="text" data-table="t_pendaftaran" data-field="x_TOTAL_BIAYA_OBAT_2" name="x_TOTAL_BIAYA_OBAT_2" id="x_TOTAL_BIAYA_OBAT_2" size="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->TOTAL_BIAYA_OBAT_2->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->EditValue ?>"<?php echo $t_pendaftaran->TOTAL_BIAYA_OBAT_2->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($t_pendaftaran->KDCARABAYAR2->Visible) { // KDCARABAYAR2 ?>
	<div id="r_KDCARABAYAR2" class="form-group">
		<label for="x_KDCARABAYAR2" class="<?php echo $t_pendaftaran_search->SearchLabelClass ?>"><span id="elh_t_pendaftaran_KDCARABAYAR2"><?php echo $t_pendaftaran->KDCARABAYAR2->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_KDCARABAYAR2" id="z_KDCARABAYAR2" value="="></p>
		</label>
		<div class="<?php echo $t_pendaftaran_search->SearchRightColumnClass ?>"><div<?php echo $t_pendaftaran->KDCARABAYAR2->CellAttributes() ?>>
			<span id="el_t_pendaftaran_KDCARABAYAR2">
<input type="text" data-table="t_pendaftaran" data-field="x_KDCARABAYAR2" name="x_KDCARABAYAR2" id="x_KDCARABAYAR2" size="30" placeholder="<?php echo ew_HtmlEncode($t_pendaftaran->KDCARABAYAR2->getPlaceHolder()) ?>" value="<?php echo $t_pendaftaran->KDCARABAYAR2->EditValue ?>"<?php echo $t_pendaftaran->KDCARABAYAR2->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_pendaftaran_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_pendaftaransearch.Init();
</script>
<?php
$t_pendaftaran_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_pendaftaran_search->Page_Terminate();
?>
