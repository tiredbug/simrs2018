<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "m_pasieninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$m_pasien_search = NULL; // Initialize page object first

class cm_pasien_search extends cm_pasien {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_pasien';

	// Page object name
	var $PageObjName = 'm_pasien_search';

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

		// Table object (m_pasien)
		if (!isset($GLOBALS["m_pasien"]) || get_class($GLOBALS["m_pasien"]) == "cm_pasien") {
			$GLOBALS["m_pasien"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["m_pasien"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'm_pasien', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("m_pasienlist.php"));
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
		$this->NAMA->SetVisibility();
		$this->ALAMAT->SetVisibility();
		$this->NO_KARTU->SetVisibility();

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
		global $EW_EXPORT, $m_pasien;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($m_pasien);
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
						$sSrchStr = "m_pasienlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->NAMA); // NAMA
		$this->BuildSearchUrl($sSrchUrl, $this->ALAMAT); // ALAMAT
		$this->BuildSearchUrl($sSrchUrl, $this->NO_KARTU); // NO_KARTU
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

		// NAMA
		$this->NAMA->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NAMA"));
		$this->NAMA->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NAMA");

		// ALAMAT
		$this->ALAMAT->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_ALAMAT"));
		$this->ALAMAT->AdvancedSearch->SearchOperator = $objForm->GetValue("z_ALAMAT");

		// NO_KARTU
		$this->NO_KARTU->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NO_KARTU"));
		$this->NO_KARTU->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NO_KARTU");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// NOMR
		// TITLE
		// NAMA
		// IBUKANDUNG
		// TEMPAT
		// TGLLAHIR
		// JENISKELAMIN
		// ALAMAT
		// KDPROVINSI
		// KOTA
		// KDKECAMATAN
		// KELURAHAN
		// NOTELP
		// NOKTP
		// SUAMI_ORTU
		// PEKERJAAN
		// STATUS
		// AGAMA
		// PENDIDIKAN
		// KDCARABAYAR
		// NIP
		// TGLDAFTAR
		// ALAMAT_KTP
		// PARENT_NOMR
		// NAMA_OBAT
		// DOSIS
		// CARA_PEMBERIAN
		// FREKUENSI
		// WAKTU_TGL
		// LAMA_WAKTU
		// ALERGI_OBAT
		// REAKSI_ALERGI
		// RIWAYAT_KES
		// BB_LAHIR
		// BB_SEKARANG
		// FISIK_FONTANEL
		// FISIK_REFLEKS
		// FISIK_SENSASI
		// MOTORIK_KASAR
		// MOTORIK_HALUS
		// MAMPU_BICARA
		// MAMPU_SOSIALISASI
		// BCG
		// POLIO
		// DPT
		// CAMPAK
		// HEPATITIS_B
		// TD
		// SUHU
		// RR
		// NADI
		// BB
		// TB
		// EYE
		// MOTORIK
		// VERBAL
		// TOTAL_GCS
		// REAKSI_PUPIL
		// KESADARAN
		// KEPALA
		// RAMBUT
		// MUKA
		// MATA
		// GANG_LIHAT
		// ALATBANTU_LIHAT
		// BENTUK
		// PENDENGARAN
		// LUB_TELINGA
		// BENTUK_HIDUNG
		// MEMBRAN_MUK
		// MAMPU_HIDU
		// ALAT_HIDUNG
		// RONGGA_MULUT
		// WARNA_MEMBRAN
		// LEMBAB
		// STOMATITIS
		// LIDAH
		// GIGI
		// TONSIL
		// KELAINAN
		// PERGERAKAN
		// KEL_TIROID
		// KEL_GETAH
		// TEKANAN_VENA
		// REF_MENELAN
		// NYERI
		// KREPITASI
		// KEL_LAIN
		// BENTUK_DADA
		// POLA_NAPAS
		// BENTUK_THORAKS
		// PAL_KREP
		// BENJOLAN
		// PAL_NYERI
		// PERKUSI
		// PARU
		// JANTUNG
		// SUARA_JANTUNG
		// ALATBANTU_JAN
		// BENTUK_ABDOMEN
		// AUSKULTASI
		// NYERI_PASI
		// PEM_KELENJAR
		// PERKUSI_AUS
		// VAGINA
		// MENSTRUASI
		// KATETER
		// LABIA_PROM
		// HAMIL
		// TGL_HAID
		// PERIKSA_CERVIX
		// BENTUK_PAYUDARA
		// KENYAL
		// MASSA
		// NYERI_RABA
		// BENTUK_PUTING
		// MAMMO
		// ALAT_KONTRASEPSI
		// MASALAH_SEKS
		// PREPUTIUM
		// MASALAH_PROSTAT
		// BENTUK_SKROTUM
		// TESTIS
		// MASSA_BEN
		// HERNIASI
		// LAIN2
		// ALAT_KONTRA
		// MASALAH_REPRO
		// EKSTREMITAS_ATAS
		// EKSTREMITAS_BAWAH
		// AKTIVITAS
		// BERJALAN
		// SISTEM_INTE
		// KENYAMANAN
		// KES_DIRI
		// SOS_SUPORT
		// ANSIETAS
		// KEHILANGAN
		// STATUS_EMOSI
		// KONSEP_DIRI
		// RESPON_HILANG
		// SUMBER_STRESS
		// BERARTI
		// TERLIBAT
		// HUBUNGAN
		// KOMUNIKASI
		// KEPUTUSAN
		// MENGASUH
		// DUKUNGAN
		// REAKSI
		// BUDAYA
		// POLA_AKTIVITAS
		// POLA_ISTIRAHAT
		// POLA_MAKAN
		// PANTANGAN
		// KEPERCAYAAN
		// PANTANGAN_HARI
		// PANTANGAN_LAIN
		// ANJURAN
		// NILAI_KEYAKINAN
		// KEGIATAN_IBADAH
		// PENG_AGAMA
		// SPIRIT
		// BANTUAN
		// PAHAM_PENYAKIT
		// PAHAM_OBAT
		// PAHAM_NUTRISI
		// PAHAM_RAWAT
		// HAMBATAN_EDUKASI
		// FREK_MAKAN
		// JUM_MAKAN
		// JEN_MAKAN
		// KOM_MAKAN
		// DIET
		// CARA_MAKAN
		// GANGGUAN
		// FREK_MINUM
		// JUM_MINUM
		// JEN_MINUM
		// GANG_MINUM
		// FREK_BAK
		// WARNA_BAK
		// JMLH_BAK
		// PENG_KAT_BAK
		// KEM_HAN_BAK
		// INKONT_BAK
		// DIURESIS_BAK
		// FREK_BAB
		// WARNA_BAB
		// KONSIST_BAB
		// GANG_BAB
		// STOMA_BAB
		// PENG_OBAT_BAB
		// IST_SIANG
		// IST_MALAM
		// IST_CAHAYA
		// IST_POSISI
		// IST_LING
		// IST_GANG_TIDUR
		// PENG_OBAT_IST
		// FREK_MAND
		// CUC_RAMB_MAND
		// SIH_GIGI_MAND
		// BANT_MAND
		// GANT_PAKAI
		// PAK_CUCI
		// PAK_BANT
		// ALT_BANT
		// KEMP_MUND
		// BIL_PUT
		// ADAPTIF
		// MALADAPTIF
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// obat2
		// PERBANDINGAN_BB
		// KONTINENSIA
		// JENIS_KULIT1
		// MOBILITAS
		// JK
		// UMUR
		// NAFSU_MAKAN
		// OBAT1
		// MALNUTRISI
		// MOTORIK1
		// SPINAL
		// MEJA_OPERASI
		// RIWAYAT_JATUH
		// DIAGNOSIS_SEKUNDER
		// ALAT_BANTU
		// HEPARIN
		// GAYA_BERJALAN
		// KESADARAN1
		// NOMR_LAMA
		// NO_KARTU
		// JNS_PASIEN
		// nama_ayah
		// nama_ibu
		// nama_suami
		// nama_istri
		// KD_ETNIS
		// KD_BHS_HARIAN

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// NAMA
		$this->NAMA->ViewValue = $this->NAMA->CurrentValue;
		$this->NAMA->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// NO_KARTU
		$this->NO_KARTU->ViewValue = $this->NO_KARTU->CurrentValue;
		$this->NO_KARTU->ViewCustomAttributes = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// NAMA
			$this->NAMA->LinkCustomAttributes = "";
			$this->NAMA->HrefValue = "";
			$this->NAMA->TooltipValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";
			$this->ALAMAT->TooltipValue = "";

			// NO_KARTU
			$this->NO_KARTU->LinkCustomAttributes = "";
			$this->NO_KARTU->HrefValue = "";
			$this->NO_KARTU->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// NOMR
			$this->NOMR->EditAttrs["class"] = "form-control";
			$this->NOMR->EditCustomAttributes = "";
			$this->NOMR->EditValue = ew_HtmlEncode($this->NOMR->AdvancedSearch->SearchValue);
			$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

			// NAMA
			$this->NAMA->EditAttrs["class"] = "form-control";
			$this->NAMA->EditCustomAttributes = "";
			$this->NAMA->EditValue = ew_HtmlEncode($this->NAMA->AdvancedSearch->SearchValue);
			$this->NAMA->PlaceHolder = ew_RemoveHtml($this->NAMA->FldCaption());

			// ALAMAT
			$this->ALAMAT->EditAttrs["class"] = "form-control";
			$this->ALAMAT->EditCustomAttributes = "";
			$this->ALAMAT->EditValue = ew_HtmlEncode($this->ALAMAT->AdvancedSearch->SearchValue);
			$this->ALAMAT->PlaceHolder = ew_RemoveHtml($this->ALAMAT->FldCaption());

			// NO_KARTU
			$this->NO_KARTU->EditAttrs["class"] = "form-control";
			$this->NO_KARTU->EditCustomAttributes = "";
			$this->NO_KARTU->EditValue = ew_HtmlEncode($this->NO_KARTU->AdvancedSearch->SearchValue);
			$this->NO_KARTU->PlaceHolder = ew_RemoveHtml($this->NO_KARTU->FldCaption());
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
		$this->NAMA->AdvancedSearch->Load();
		$this->ALAMAT->AdvancedSearch->Load();
		$this->NO_KARTU->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_pasienlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_pasien_search)) $m_pasien_search = new cm_pasien_search();

// Page init
$m_pasien_search->Page_Init();

// Page main
$m_pasien_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_pasien_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($m_pasien_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fm_pasiensearch = new ew_Form("fm_pasiensearch", "search");
<?php } else { ?>
var CurrentForm = fm_pasiensearch = new ew_Form("fm_pasiensearch", "search");
<?php } ?>

// Form_CustomValidate event
fm_pasiensearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_pasiensearch.ValidateRequired = true;
<?php } else { ?>
fm_pasiensearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search
// Validate function for search

fm_pasiensearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$m_pasien_search->IsModal) { ?>
<?php } ?>
<?php $m_pasien_search->ShowPageHeader(); ?>
<?php
$m_pasien_search->ShowMessage();
?>
<form name="fm_pasiensearch" id="fm_pasiensearch" class="<?php echo $m_pasien_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_pasien_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_pasien_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_pasien">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($m_pasien_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($m_pasien->NOMR->Visible) { // NOMR ?>
	<div id="r_NOMR" class="form-group">
		<label for="x_NOMR" class="<?php echo $m_pasien_search->SearchLabelClass ?>"><span id="elh_m_pasien_NOMR"><?php echo $m_pasien->NOMR->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NOMR" id="z_NOMR" value="LIKE"></p>
		</label>
		<div class="<?php echo $m_pasien_search->SearchRightColumnClass ?>"><div<?php echo $m_pasien->NOMR->CellAttributes() ?>>
			<span id="el_m_pasien_NOMR">
<input type="text" data-table="m_pasien" data-field="x_NOMR" name="x_NOMR" id="x_NOMR" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($m_pasien->NOMR->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NOMR->EditValue ?>"<?php echo $m_pasien->NOMR->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->NAMA->Visible) { // NAMA ?>
	<div id="r_NAMA" class="form-group">
		<label for="x_NAMA" class="<?php echo $m_pasien_search->SearchLabelClass ?>"><span id="elh_m_pasien_NAMA"><?php echo $m_pasien->NAMA->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NAMA" id="z_NAMA" value="LIKE"></p>
		</label>
		<div class="<?php echo $m_pasien_search->SearchRightColumnClass ?>"><div<?php echo $m_pasien->NAMA->CellAttributes() ?>>
			<span id="el_m_pasien_NAMA">
<input type="text" data-table="m_pasien" data-field="x_NAMA" name="x_NAMA" id="x_NAMA" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->NAMA->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NAMA->EditValue ?>"<?php echo $m_pasien->NAMA->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->ALAMAT->Visible) { // ALAMAT ?>
	<div id="r_ALAMAT" class="form-group">
		<label for="x_ALAMAT" class="<?php echo $m_pasien_search->SearchLabelClass ?>"><span id="elh_m_pasien_ALAMAT"><?php echo $m_pasien->ALAMAT->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_ALAMAT" id="z_ALAMAT" value="LIKE"></p>
		</label>
		<div class="<?php echo $m_pasien_search->SearchRightColumnClass ?>"><div<?php echo $m_pasien->ALAMAT->CellAttributes() ?>>
			<span id="el_m_pasien_ALAMAT">
<input type="text" data-table="m_pasien" data-field="x_ALAMAT" name="x_ALAMAT" id="x_ALAMAT" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($m_pasien->ALAMAT->getPlaceHolder()) ?>" value="<?php echo $m_pasien->ALAMAT->EditValue ?>"<?php echo $m_pasien->ALAMAT->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($m_pasien->NO_KARTU->Visible) { // NO_KARTU ?>
	<div id="r_NO_KARTU" class="form-group">
		<label for="x_NO_KARTU" class="<?php echo $m_pasien_search->SearchLabelClass ?>"><span id="elh_m_pasien_NO_KARTU"><?php echo $m_pasien->NO_KARTU->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NO_KARTU" id="z_NO_KARTU" value="LIKE"></p>
		</label>
		<div class="<?php echo $m_pasien_search->SearchRightColumnClass ?>"><div<?php echo $m_pasien->NO_KARTU->CellAttributes() ?>>
			<span id="el_m_pasien_NO_KARTU">
<input type="text" data-table="m_pasien" data-field="x_NO_KARTU" name="x_NO_KARTU" id="x_NO_KARTU" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($m_pasien->NO_KARTU->getPlaceHolder()) ?>" value="<?php echo $m_pasien->NO_KARTU->EditValue ?>"<?php echo $m_pasien->NO_KARTU->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$m_pasien_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fm_pasiensearch.Init();
</script>
<?php
$m_pasien_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_pasien_search->Page_Terminate();
?>
