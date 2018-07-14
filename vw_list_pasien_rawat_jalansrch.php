<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_list_pasien_rawat_jalaninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_list_pasien_rawat_jalan_search = NULL; // Initialize page object first

class cvw_list_pasien_rawat_jalan_search extends cvw_list_pasien_rawat_jalan {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_list_pasien_rawat_jalan';

	// Page object name
	var $PageObjName = 'vw_list_pasien_rawat_jalan_search';

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

		// Table object (vw_list_pasien_rawat_jalan)
		if (!isset($GLOBALS["vw_list_pasien_rawat_jalan"]) || get_class($GLOBALS["vw_list_pasien_rawat_jalan"]) == "cvw_list_pasien_rawat_jalan") {
			$GLOBALS["vw_list_pasien_rawat_jalan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_list_pasien_rawat_jalan"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_list_pasien_rawat_jalan', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_list_pasien_rawat_jalanlist.php"));
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
		$this->NOMR->SetVisibility();
		$this->KETERANGAN->SetVisibility();
		$this->KDPOLY->SetVisibility();
		$this->tanggal->SetVisibility();
		$this->bulan->SetVisibility();
		$this->tahun->SetVisibility();

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
		global $EW_EXPORT, $vw_list_pasien_rawat_jalan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_list_pasien_rawat_jalan);
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
						$sSrchStr = "vw_list_pasien_rawat_jalanlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->NOMR); // NOMR
		$this->BuildSearchUrl($sSrchUrl, $this->KETERANGAN); // KETERANGAN
		$this->BuildSearchUrl($sSrchUrl, $this->KDPOLY); // KDPOLY
		$this->BuildSearchUrl($sSrchUrl, $this->tanggal); // tanggal
		$this->BuildSearchUrl($sSrchUrl, $this->bulan); // bulan
		$this->BuildSearchUrl($sSrchUrl, $this->tahun); // tahun
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
		// NOMR

		$this->NOMR->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NOMR"));
		$this->NOMR->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NOMR");

		// KETERANGAN
		$this->KETERANGAN->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_KETERANGAN"));
		$this->KETERANGAN->AdvancedSearch->SearchOperator = $objForm->GetValue("z_KETERANGAN");

		// KDPOLY
		$this->KDPOLY->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_KDPOLY"));
		$this->KDPOLY->AdvancedSearch->SearchOperator = $objForm->GetValue("z_KDPOLY");

		// tanggal
		$this->tanggal->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_tanggal"));
		$this->tanggal->AdvancedSearch->SearchOperator = $objForm->GetValue("z_tanggal");

		// bulan
		$this->bulan->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_bulan"));
		$this->bulan->AdvancedSearch->SearchOperator = $objForm->GetValue("z_bulan");

		// tahun
		$this->tahun->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_tahun"));
		$this->tahun->AdvancedSearch->SearchOperator = $objForm->GetValue("z_tahun");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXDAFTAR
		// TGLREG
		// NOMR
		// KETERANGAN
		// NOKARTU_BPJS
		// NOKTP
		// KDDOKTER
		// KDPOLY
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
		// tanggal
		// bulan
		// tahun

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// KETERANGAN
		$this->KETERANGAN->ViewValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->ViewCustomAttributes = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->ViewValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// KDDOKTER
		$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
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

		// KDRUJUK
		$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
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
		$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
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
		$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
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
		$this->MINTA_RUJUKAN->ViewValue = $this->MINTA_RUJUKAN->CurrentValue;
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

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewCustomAttributes = "";

		// bulan
		if (strval($this->bulan->CurrentValue) <> "") {
			$sFilterWrk = "`bulan_id`" . ew_SearchString("=", $this->bulan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `bulan_id`, `bulan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_bulan`";
		$sWhereWrk = "";
		$this->bulan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bulan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bulan->ViewValue = $this->bulan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bulan->ViewValue = $this->bulan->CurrentValue;
			}
		} else {
			$this->bulan->ViewValue = NULL;
		}
		$this->bulan->ViewCustomAttributes = "";

		// tahun
		$this->tahun->ViewValue = $this->tahun->CurrentValue;
		$this->tahun->ViewCustomAttributes = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// KETERANGAN
			$this->KETERANGAN->LinkCustomAttributes = "";
			$this->KETERANGAN->HrefValue = "";
			$this->KETERANGAN->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// bulan
			$this->bulan->LinkCustomAttributes = "";
			$this->bulan->HrefValue = "";
			$this->bulan->TooltipValue = "";

			// tahun
			$this->tahun->LinkCustomAttributes = "";
			$this->tahun->HrefValue = "";
			$this->tahun->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// NOMR
			$this->NOMR->EditAttrs["class"] = "form-control";
			$this->NOMR->EditCustomAttributes = "";
			$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->AdvancedSearch->SearchValue);
			if (strval($this->NOMR->AdvancedSearch->SearchValue) <> "") {
				$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->AdvancedSearch->SearchValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "";
			$this->NOMR->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->NOMR->EditValue = $this->NOMR->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->AdvancedSearch->SearchValue);
				}
			} else {
				$this->NOMR->EditValue = NULL;
			}
			$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

			// KETERANGAN
			$this->KETERANGAN->EditAttrs["class"] = "form-control";
			$this->KETERANGAN->EditCustomAttributes = "";
			$this->KETERANGAN->EditValue = ew_HtmlEncode($this->KETERANGAN->AdvancedSearch->SearchValue);
			$this->KETERANGAN->PlaceHolder = ew_RemoveHtml($this->KETERANGAN->FldCaption());

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

			// tanggal
			$this->tanggal->EditAttrs["class"] = "form-control";
			$this->tanggal->EditCustomAttributes = "";
			$this->tanggal->EditValue = ew_HtmlEncode($this->tanggal->AdvancedSearch->SearchValue);
			$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

			// bulan
			$this->bulan->EditAttrs["class"] = "form-control";
			$this->bulan->EditCustomAttributes = "";
			if (trim(strval($this->bulan->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`bulan_id`" . ew_SearchString("=", $this->bulan->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `bulan_id`, `bulan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `l_bulan`";
			$sWhereWrk = "";
			$this->bulan->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->bulan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->bulan->EditValue = $arwrk;

			// tahun
			$this->tahun->EditAttrs["class"] = "form-control";
			$this->tahun->EditCustomAttributes = "";
			$this->tahun->EditValue = ew_HtmlEncode($this->tahun->AdvancedSearch->SearchValue);
			$this->tahun->PlaceHolder = ew_RemoveHtml($this->tahun->FldCaption());
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
		if (!ew_CheckInteger($this->tanggal->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->tanggal->FldErrMsg());
		}
		if (!ew_CheckInteger($this->tahun->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->tahun->FldErrMsg());
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
		$this->NOMR->AdvancedSearch->Load();
		$this->KETERANGAN->AdvancedSearch->Load();
		$this->KDPOLY->AdvancedSearch->Load();
		$this->tanggal->AdvancedSearch->Load();
		$this->bulan->AdvancedSearch->Load();
		$this->tahun->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_list_pasien_rawat_jalanlist.php"), "", $this->TableVar, TRUE);
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
			$sSqlWrk = "SELECT `NOMR` AS `LinkFld`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "{filter}";
			$this->NOMR->LookupFilters = array();
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
		case "x_bulan":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `bulan_id` AS `LinkFld`, `bulan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_bulan`";
			$sWhereWrk = "";
			$this->bulan->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`bulan_id` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->bulan, $sWhereWrk); // Call Lookup selecting
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
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld` FROM `m_pasien`";
			$sWhereWrk = "`NOMR` LIKE '%{query_value}%' OR `NAMA` LIKE '%{query_value}%' OR CONCAT(`NOMR`,'" . ew_ValueSeparator(1, $this->NOMR) . "',`NAMA`) LIKE '{query_value}%'";
			$this->NOMR->LookupFilters = array();
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
if (!isset($vw_list_pasien_rawat_jalan_search)) $vw_list_pasien_rawat_jalan_search = new cvw_list_pasien_rawat_jalan_search();

// Page init
$vw_list_pasien_rawat_jalan_search->Page_Init();

// Page main
$vw_list_pasien_rawat_jalan_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_list_pasien_rawat_jalan_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($vw_list_pasien_rawat_jalan_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fvw_list_pasien_rawat_jalansearch = new ew_Form("fvw_list_pasien_rawat_jalansearch", "search");
<?php } else { ?>
var CurrentForm = fvw_list_pasien_rawat_jalansearch = new ew_Form("fvw_list_pasien_rawat_jalansearch", "search");
<?php } ?>

// Form_CustomValidate event
fvw_list_pasien_rawat_jalansearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_list_pasien_rawat_jalansearch.ValidateRequired = true;
<?php } else { ?>
fvw_list_pasien_rawat_jalansearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_list_pasien_rawat_jalansearch.Lists["x_NOMR"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
fvw_list_pasien_rawat_jalansearch.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
fvw_list_pasien_rawat_jalansearch.Lists["x_bulan"] = {"LinkField":"x_bulan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_bulan_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_bulan"};

// Form object for search
// Validate function for search

fvw_list_pasien_rawat_jalansearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_tanggal");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($vw_list_pasien_rawat_jalan->tanggal->FldErrMsg()) ?>");
	elm = this.GetElements("x" + infix + "_tahun");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($vw_list_pasien_rawat_jalan->tahun->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_list_pasien_rawat_jalan_search->IsModal) { ?>
<?php } ?>
<?php $vw_list_pasien_rawat_jalan_search->ShowPageHeader(); ?>
<?php
$vw_list_pasien_rawat_jalan_search->ShowMessage();
?>
<form name="fvw_list_pasien_rawat_jalansearch" id="fvw_list_pasien_rawat_jalansearch" class="<?php echo $vw_list_pasien_rawat_jalan_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_list_pasien_rawat_jalan_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_list_pasien_rawat_jalan_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_list_pasien_rawat_jalan">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($vw_list_pasien_rawat_jalan_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_list_pasien_rawat_jalan->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_list_pasien_rawat_jalan_NOMR"><?php echo $vw_list_pasien_rawat_jalan->NOMR->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NOMR" id="z_NOMR" value="LIKE"></p>
		</label>
		<div class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_list_pasien_rawat_jalan->NOMR->CellAttributes() ?>>
			<span id="el_vw_list_pasien_rawat_jalan_NOMR">
<?php
$wrkonchange = trim(" " . @$vw_list_pasien_rawat_jalan->NOMR->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$vw_list_pasien_rawat_jalan->NOMR->EditAttrs["onchange"] = "";
?>
<span id="as_x_NOMR" style="white-space: nowrap; z-index: 8970">
	<input type="text" name="sv_x_NOMR" id="sv_x_NOMR" value="<?php echo $vw_list_pasien_rawat_jalan->NOMR->EditValue ?>" size="30" maxlength="8" placeholder="<?php echo ew_HtmlEncode($vw_list_pasien_rawat_jalan->NOMR->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($vw_list_pasien_rawat_jalan->NOMR->getPlaceHolder()) ?>"<?php echo $vw_list_pasien_rawat_jalan->NOMR->EditAttributes() ?>>
</span>
<input type="hidden" data-table="vw_list_pasien_rawat_jalan" data-field="x_NOMR" data-value-separator="<?php echo $vw_list_pasien_rawat_jalan->NOMR->DisplayValueSeparatorAttribute() ?>" name="x_NOMR" id="x_NOMR" value="<?php echo ew_HtmlEncode($vw_list_pasien_rawat_jalan->NOMR->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_NOMR" id="q_x_NOMR" value="<?php echo $vw_list_pasien_rawat_jalan->NOMR->LookupFilterQuery(true) ?>">
<script type="text/javascript">
fvw_list_pasien_rawat_jalansearch.CreateAutoSuggest({"id":"x_NOMR","forceSelect":false});
</script>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KETERANGAN->Visible) { // KETERANGAN ?>
	<div id="r_KETERANGAN" class="form-group">
		<label for="x_KETERANGAN" class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_list_pasien_rawat_jalan_KETERANGAN"><?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_KETERANGAN" id="z_KETERANGAN" value="LIKE"></p>
		</label>
		<div class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->CellAttributes() ?>>
			<span id="el_vw_list_pasien_rawat_jalan_KETERANGAN">
<input type="text" data-table="vw_list_pasien_rawat_jalan" data-field="x_KETERANGAN" name="x_KETERANGAN" id="x_KETERANGAN" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($vw_list_pasien_rawat_jalan->KETERANGAN->getPlaceHolder()) ?>" value="<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->EditValue ?>"<?php echo $vw_list_pasien_rawat_jalan->KETERANGAN->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->KDPOLY->Visible) { // KDPOLY ?>
	<div id="r_KDPOLY" class="form-group">
		<label for="x_KDPOLY" class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_list_pasien_rawat_jalan_KDPOLY"><?php echo $vw_list_pasien_rawat_jalan->KDPOLY->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_KDPOLY" id="z_KDPOLY" value="="></p>
		</label>
		<div class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->CellAttributes() ?>>
			<span id="el_vw_list_pasien_rawat_jalan_KDPOLY">
<select data-table="vw_list_pasien_rawat_jalan" data-field="x_KDPOLY" data-value-separator="<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->DisplayValueSeparatorAttribute() ?>" id="x_KDPOLY" name="x_KDPOLY"<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->EditAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->SelectOptionListHtml("x_KDPOLY") ?>
</select>
<input type="hidden" name="s_x_KDPOLY" id="s_x_KDPOLY" value="<?php echo $vw_list_pasien_rawat_jalan->KDPOLY->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->tanggal->Visible) { // tanggal ?>
	<div id="r_tanggal" class="form-group">
		<label for="x_tanggal" class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_list_pasien_rawat_jalan_tanggal"><?php echo $vw_list_pasien_rawat_jalan->tanggal->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_tanggal" id="z_tanggal" value="="></p>
		</label>
		<div class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_list_pasien_rawat_jalan->tanggal->CellAttributes() ?>>
			<span id="el_vw_list_pasien_rawat_jalan_tanggal">
<input type="text" data-table="vw_list_pasien_rawat_jalan" data-field="x_tanggal" name="x_tanggal" id="x_tanggal" size="30" placeholder="<?php echo ew_HtmlEncode($vw_list_pasien_rawat_jalan->tanggal->getPlaceHolder()) ?>" value="<?php echo $vw_list_pasien_rawat_jalan->tanggal->EditValue ?>"<?php echo $vw_list_pasien_rawat_jalan->tanggal->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->bulan->Visible) { // bulan ?>
	<div id="r_bulan" class="form-group">
		<label for="x_bulan" class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_list_pasien_rawat_jalan_bulan"><?php echo $vw_list_pasien_rawat_jalan->bulan->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_bulan" id="z_bulan" value="="></p>
		</label>
		<div class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_list_pasien_rawat_jalan->bulan->CellAttributes() ?>>
			<span id="el_vw_list_pasien_rawat_jalan_bulan">
<select data-table="vw_list_pasien_rawat_jalan" data-field="x_bulan" data-value-separator="<?php echo $vw_list_pasien_rawat_jalan->bulan->DisplayValueSeparatorAttribute() ?>" id="x_bulan" name="x_bulan"<?php echo $vw_list_pasien_rawat_jalan->bulan->EditAttributes() ?>>
<?php echo $vw_list_pasien_rawat_jalan->bulan->SelectOptionListHtml("x_bulan") ?>
</select>
<input type="hidden" name="s_x_bulan" id="s_x_bulan" value="<?php echo $vw_list_pasien_rawat_jalan->bulan->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($vw_list_pasien_rawat_jalan->tahun->Visible) { // tahun ?>
	<div id="r_tahun" class="form-group">
		<label for="x_tahun" class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_list_pasien_rawat_jalan_tahun"><?php echo $vw_list_pasien_rawat_jalan->tahun->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_tahun" id="z_tahun" value="="></p>
		</label>
		<div class="<?php echo $vw_list_pasien_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_list_pasien_rawat_jalan->tahun->CellAttributes() ?>>
			<span id="el_vw_list_pasien_rawat_jalan_tahun">
<input type="text" data-table="vw_list_pasien_rawat_jalan" data-field="x_tahun" name="x_tahun" id="x_tahun" size="30" placeholder="<?php echo ew_HtmlEncode($vw_list_pasien_rawat_jalan->tahun->getPlaceHolder()) ?>" value="<?php echo $vw_list_pasien_rawat_jalan->tahun->EditValue ?>"<?php echo $vw_list_pasien_rawat_jalan->tahun->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_list_pasien_rawat_jalan_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_list_pasien_rawat_jalansearch.Init();
</script>
<?php
$vw_list_pasien_rawat_jalan_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_list_pasien_rawat_jalan_search->Page_Terminate();
?>
