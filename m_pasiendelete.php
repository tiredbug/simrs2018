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

$m_pasien_delete = NULL; // Initialize page object first

class cm_pasien_delete extends cm_pasien {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'm_pasien';

	// Page object name
	var $PageObjName = 'm_pasien_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
		if (!$Security->CanDelete()) {
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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->NOMR->SetVisibility();
		$this->NAMA->SetVisibility();
		$this->TEMPAT->SetVisibility();
		$this->TGLLAHIR->SetVisibility();
		$this->JENISKELAMIN->SetVisibility();
		$this->ALAMAT->SetVisibility();
		$this->NOTELP->SetVisibility();

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
			$this->Page_Terminate("m_pasienlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in m_pasien class, m_pasieninfo.php

		$this->CurrentFilter = $sFilter;

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
				$this->Page_Terminate("m_pasienlist.php"); // Return to list
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
		$this->id->setDbValue($rs->fields('id'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TITLE->setDbValue($rs->fields('TITLE'));
		$this->NAMA->setDbValue($rs->fields('NAMA'));
		$this->IBUKANDUNG->setDbValue($rs->fields('IBUKANDUNG'));
		$this->TEMPAT->setDbValue($rs->fields('TEMPAT'));
		$this->TGLLAHIR->setDbValue($rs->fields('TGLLAHIR'));
		$this->JENISKELAMIN->setDbValue($rs->fields('JENISKELAMIN'));
		$this->ALAMAT->setDbValue($rs->fields('ALAMAT'));
		$this->KDPROVINSI->setDbValue($rs->fields('KDPROVINSI'));
		$this->KOTA->setDbValue($rs->fields('KOTA'));
		$this->KDKECAMATAN->setDbValue($rs->fields('KDKECAMATAN'));
		$this->KELURAHAN->setDbValue($rs->fields('KELURAHAN'));
		$this->NOTELP->setDbValue($rs->fields('NOTELP'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->SUAMI_ORTU->setDbValue($rs->fields('SUAMI_ORTU'));
		$this->PEKERJAAN->setDbValue($rs->fields('PEKERJAAN'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->AGAMA->setDbValue($rs->fields('AGAMA'));
		$this->PENDIDIKAN->setDbValue($rs->fields('PENDIDIKAN'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->TGLDAFTAR->setDbValue($rs->fields('TGLDAFTAR'));
		$this->ALAMAT_KTP->setDbValue($rs->fields('ALAMAT_KTP'));
		$this->PARENT_NOMR->setDbValue($rs->fields('PARENT_NOMR'));
		$this->NAMA_OBAT->setDbValue($rs->fields('NAMA_OBAT'));
		$this->DOSIS->setDbValue($rs->fields('DOSIS'));
		$this->CARA_PEMBERIAN->setDbValue($rs->fields('CARA_PEMBERIAN'));
		$this->FREKUENSI->setDbValue($rs->fields('FREKUENSI'));
		$this->WAKTU_TGL->setDbValue($rs->fields('WAKTU_TGL'));
		$this->LAMA_WAKTU->setDbValue($rs->fields('LAMA_WAKTU'));
		$this->ALERGI_OBAT->setDbValue($rs->fields('ALERGI_OBAT'));
		$this->REAKSI_ALERGI->setDbValue($rs->fields('REAKSI_ALERGI'));
		$this->RIWAYAT_KES->setDbValue($rs->fields('RIWAYAT_KES'));
		$this->BB_LAHIR->setDbValue($rs->fields('BB_LAHIR'));
		$this->BB_SEKARANG->setDbValue($rs->fields('BB_SEKARANG'));
		$this->FISIK_FONTANEL->setDbValue($rs->fields('FISIK_FONTANEL'));
		$this->FISIK_REFLEKS->setDbValue($rs->fields('FISIK_REFLEKS'));
		$this->FISIK_SENSASI->setDbValue($rs->fields('FISIK_SENSASI'));
		$this->MOTORIK_KASAR->setDbValue($rs->fields('MOTORIK_KASAR'));
		$this->MOTORIK_HALUS->setDbValue($rs->fields('MOTORIK_HALUS'));
		$this->MAMPU_BICARA->setDbValue($rs->fields('MAMPU_BICARA'));
		$this->MAMPU_SOSIALISASI->setDbValue($rs->fields('MAMPU_SOSIALISASI'));
		$this->BCG->setDbValue($rs->fields('BCG'));
		$this->POLIO->setDbValue($rs->fields('POLIO'));
		$this->DPT->setDbValue($rs->fields('DPT'));
		$this->CAMPAK->setDbValue($rs->fields('CAMPAK'));
		$this->HEPATITIS_B->setDbValue($rs->fields('HEPATITIS_B'));
		$this->TD->setDbValue($rs->fields('TD'));
		$this->SUHU->setDbValue($rs->fields('SUHU'));
		$this->RR->setDbValue($rs->fields('RR'));
		$this->NADI->setDbValue($rs->fields('NADI'));
		$this->BB->setDbValue($rs->fields('BB'));
		$this->TB->setDbValue($rs->fields('TB'));
		$this->EYE->setDbValue($rs->fields('EYE'));
		$this->MOTORIK->setDbValue($rs->fields('MOTORIK'));
		$this->VERBAL->setDbValue($rs->fields('VERBAL'));
		$this->TOTAL_GCS->setDbValue($rs->fields('TOTAL_GCS'));
		$this->REAKSI_PUPIL->setDbValue($rs->fields('REAKSI_PUPIL'));
		$this->KESADARAN->setDbValue($rs->fields('KESADARAN'));
		$this->KEPALA->setDbValue($rs->fields('KEPALA'));
		$this->RAMBUT->setDbValue($rs->fields('RAMBUT'));
		$this->MUKA->setDbValue($rs->fields('MUKA'));
		$this->MATA->setDbValue($rs->fields('MATA'));
		$this->GANG_LIHAT->setDbValue($rs->fields('GANG_LIHAT'));
		$this->ALATBANTU_LIHAT->setDbValue($rs->fields('ALATBANTU_LIHAT'));
		$this->BENTUK->setDbValue($rs->fields('BENTUK'));
		$this->PENDENGARAN->setDbValue($rs->fields('PENDENGARAN'));
		$this->LUB_TELINGA->setDbValue($rs->fields('LUB_TELINGA'));
		$this->BENTUK_HIDUNG->setDbValue($rs->fields('BENTUK_HIDUNG'));
		$this->MEMBRAN_MUK->setDbValue($rs->fields('MEMBRAN_MUK'));
		$this->MAMPU_HIDU->setDbValue($rs->fields('MAMPU_HIDU'));
		$this->ALAT_HIDUNG->setDbValue($rs->fields('ALAT_HIDUNG'));
		$this->RONGGA_MULUT->setDbValue($rs->fields('RONGGA_MULUT'));
		$this->WARNA_MEMBRAN->setDbValue($rs->fields('WARNA_MEMBRAN'));
		$this->LEMBAB->setDbValue($rs->fields('LEMBAB'));
		$this->STOMATITIS->setDbValue($rs->fields('STOMATITIS'));
		$this->LIDAH->setDbValue($rs->fields('LIDAH'));
		$this->GIGI->setDbValue($rs->fields('GIGI'));
		$this->TONSIL->setDbValue($rs->fields('TONSIL'));
		$this->KELAINAN->setDbValue($rs->fields('KELAINAN'));
		$this->PERGERAKAN->setDbValue($rs->fields('PERGERAKAN'));
		$this->KEL_TIROID->setDbValue($rs->fields('KEL_TIROID'));
		$this->KEL_GETAH->setDbValue($rs->fields('KEL_GETAH'));
		$this->TEKANAN_VENA->setDbValue($rs->fields('TEKANAN_VENA'));
		$this->REF_MENELAN->setDbValue($rs->fields('REF_MENELAN'));
		$this->NYERI->setDbValue($rs->fields('NYERI'));
		$this->KREPITASI->setDbValue($rs->fields('KREPITASI'));
		$this->KEL_LAIN->setDbValue($rs->fields('KEL_LAIN'));
		$this->BENTUK_DADA->setDbValue($rs->fields('BENTUK_DADA'));
		$this->POLA_NAPAS->setDbValue($rs->fields('POLA_NAPAS'));
		$this->BENTUK_THORAKS->setDbValue($rs->fields('BENTUK_THORAKS'));
		$this->PAL_KREP->setDbValue($rs->fields('PAL_KREP'));
		$this->BENJOLAN->setDbValue($rs->fields('BENJOLAN'));
		$this->PAL_NYERI->setDbValue($rs->fields('PAL_NYERI'));
		$this->PERKUSI->setDbValue($rs->fields('PERKUSI'));
		$this->PARU->setDbValue($rs->fields('PARU'));
		$this->JANTUNG->setDbValue($rs->fields('JANTUNG'));
		$this->SUARA_JANTUNG->setDbValue($rs->fields('SUARA_JANTUNG'));
		$this->ALATBANTU_JAN->setDbValue($rs->fields('ALATBANTU_JAN'));
		$this->BENTUK_ABDOMEN->setDbValue($rs->fields('BENTUK_ABDOMEN'));
		$this->AUSKULTASI->setDbValue($rs->fields('AUSKULTASI'));
		$this->NYERI_PASI->setDbValue($rs->fields('NYERI_PASI'));
		$this->PEM_KELENJAR->setDbValue($rs->fields('PEM_KELENJAR'));
		$this->PERKUSI_AUS->setDbValue($rs->fields('PERKUSI_AUS'));
		$this->VAGINA->setDbValue($rs->fields('VAGINA'));
		$this->MENSTRUASI->setDbValue($rs->fields('MENSTRUASI'));
		$this->KATETER->setDbValue($rs->fields('KATETER'));
		$this->LABIA_PROM->setDbValue($rs->fields('LABIA_PROM'));
		$this->HAMIL->setDbValue($rs->fields('HAMIL'));
		$this->TGL_HAID->setDbValue($rs->fields('TGL_HAID'));
		$this->PERIKSA_CERVIX->setDbValue($rs->fields('PERIKSA_CERVIX'));
		$this->BENTUK_PAYUDARA->setDbValue($rs->fields('BENTUK_PAYUDARA'));
		$this->KENYAL->setDbValue($rs->fields('KENYAL'));
		$this->MASSA->setDbValue($rs->fields('MASSA'));
		$this->NYERI_RABA->setDbValue($rs->fields('NYERI_RABA'));
		$this->BENTUK_PUTING->setDbValue($rs->fields('BENTUK_PUTING'));
		$this->MAMMO->setDbValue($rs->fields('MAMMO'));
		$this->ALAT_KONTRASEPSI->setDbValue($rs->fields('ALAT_KONTRASEPSI'));
		$this->MASALAH_SEKS->setDbValue($rs->fields('MASALAH_SEKS'));
		$this->PREPUTIUM->setDbValue($rs->fields('PREPUTIUM'));
		$this->MASALAH_PROSTAT->setDbValue($rs->fields('MASALAH_PROSTAT'));
		$this->BENTUK_SKROTUM->setDbValue($rs->fields('BENTUK_SKROTUM'));
		$this->TESTIS->setDbValue($rs->fields('TESTIS'));
		$this->MASSA_BEN->setDbValue($rs->fields('MASSA_BEN'));
		$this->HERNIASI->setDbValue($rs->fields('HERNIASI'));
		$this->LAIN2->setDbValue($rs->fields('LAIN2'));
		$this->ALAT_KONTRA->setDbValue($rs->fields('ALAT_KONTRA'));
		$this->MASALAH_REPRO->setDbValue($rs->fields('MASALAH_REPRO'));
		$this->EKSTREMITAS_ATAS->setDbValue($rs->fields('EKSTREMITAS_ATAS'));
		$this->EKSTREMITAS_BAWAH->setDbValue($rs->fields('EKSTREMITAS_BAWAH'));
		$this->AKTIVITAS->setDbValue($rs->fields('AKTIVITAS'));
		$this->BERJALAN->setDbValue($rs->fields('BERJALAN'));
		$this->SISTEM_INTE->setDbValue($rs->fields('SISTEM_INTE'));
		$this->KENYAMANAN->setDbValue($rs->fields('KENYAMANAN'));
		$this->KES_DIRI->setDbValue($rs->fields('KES_DIRI'));
		$this->SOS_SUPORT->setDbValue($rs->fields('SOS_SUPORT'));
		$this->ANSIETAS->setDbValue($rs->fields('ANSIETAS'));
		$this->KEHILANGAN->setDbValue($rs->fields('KEHILANGAN'));
		$this->STATUS_EMOSI->setDbValue($rs->fields('STATUS_EMOSI'));
		$this->KONSEP_DIRI->setDbValue($rs->fields('KONSEP_DIRI'));
		$this->RESPON_HILANG->setDbValue($rs->fields('RESPON_HILANG'));
		$this->SUMBER_STRESS->setDbValue($rs->fields('SUMBER_STRESS'));
		$this->BERARTI->setDbValue($rs->fields('BERARTI'));
		$this->TERLIBAT->setDbValue($rs->fields('TERLIBAT'));
		$this->HUBUNGAN->setDbValue($rs->fields('HUBUNGAN'));
		$this->KOMUNIKASI->setDbValue($rs->fields('KOMUNIKASI'));
		$this->KEPUTUSAN->setDbValue($rs->fields('KEPUTUSAN'));
		$this->MENGASUH->setDbValue($rs->fields('MENGASUH'));
		$this->DUKUNGAN->setDbValue($rs->fields('DUKUNGAN'));
		$this->REAKSI->setDbValue($rs->fields('REAKSI'));
		$this->BUDAYA->setDbValue($rs->fields('BUDAYA'));
		$this->POLA_AKTIVITAS->setDbValue($rs->fields('POLA_AKTIVITAS'));
		$this->POLA_ISTIRAHAT->setDbValue($rs->fields('POLA_ISTIRAHAT'));
		$this->POLA_MAKAN->setDbValue($rs->fields('POLA_MAKAN'));
		$this->PANTANGAN->setDbValue($rs->fields('PANTANGAN'));
		$this->KEPERCAYAAN->setDbValue($rs->fields('KEPERCAYAAN'));
		$this->PANTANGAN_HARI->setDbValue($rs->fields('PANTANGAN_HARI'));
		$this->PANTANGAN_LAIN->setDbValue($rs->fields('PANTANGAN_LAIN'));
		$this->ANJURAN->setDbValue($rs->fields('ANJURAN'));
		$this->NILAI_KEYAKINAN->setDbValue($rs->fields('NILAI_KEYAKINAN'));
		$this->KEGIATAN_IBADAH->setDbValue($rs->fields('KEGIATAN_IBADAH'));
		$this->PENG_AGAMA->setDbValue($rs->fields('PENG_AGAMA'));
		$this->SPIRIT->setDbValue($rs->fields('SPIRIT'));
		$this->BANTUAN->setDbValue($rs->fields('BANTUAN'));
		$this->PAHAM_PENYAKIT->setDbValue($rs->fields('PAHAM_PENYAKIT'));
		$this->PAHAM_OBAT->setDbValue($rs->fields('PAHAM_OBAT'));
		$this->PAHAM_NUTRISI->setDbValue($rs->fields('PAHAM_NUTRISI'));
		$this->PAHAM_RAWAT->setDbValue($rs->fields('PAHAM_RAWAT'));
		$this->HAMBATAN_EDUKASI->setDbValue($rs->fields('HAMBATAN_EDUKASI'));
		$this->FREK_MAKAN->setDbValue($rs->fields('FREK_MAKAN'));
		$this->JUM_MAKAN->setDbValue($rs->fields('JUM_MAKAN'));
		$this->JEN_MAKAN->setDbValue($rs->fields('JEN_MAKAN'));
		$this->KOM_MAKAN->setDbValue($rs->fields('KOM_MAKAN'));
		$this->DIET->setDbValue($rs->fields('DIET'));
		$this->CARA_MAKAN->setDbValue($rs->fields('CARA_MAKAN'));
		$this->GANGGUAN->setDbValue($rs->fields('GANGGUAN'));
		$this->FREK_MINUM->setDbValue($rs->fields('FREK_MINUM'));
		$this->JUM_MINUM->setDbValue($rs->fields('JUM_MINUM'));
		$this->JEN_MINUM->setDbValue($rs->fields('JEN_MINUM'));
		$this->GANG_MINUM->setDbValue($rs->fields('GANG_MINUM'));
		$this->FREK_BAK->setDbValue($rs->fields('FREK_BAK'));
		$this->WARNA_BAK->setDbValue($rs->fields('WARNA_BAK'));
		$this->JMLH_BAK->setDbValue($rs->fields('JMLH_BAK'));
		$this->PENG_KAT_BAK->setDbValue($rs->fields('PENG_KAT_BAK'));
		$this->KEM_HAN_BAK->setDbValue($rs->fields('KEM_HAN_BAK'));
		$this->INKONT_BAK->setDbValue($rs->fields('INKONT_BAK'));
		$this->DIURESIS_BAK->setDbValue($rs->fields('DIURESIS_BAK'));
		$this->FREK_BAB->setDbValue($rs->fields('FREK_BAB'));
		$this->WARNA_BAB->setDbValue($rs->fields('WARNA_BAB'));
		$this->KONSIST_BAB->setDbValue($rs->fields('KONSIST_BAB'));
		$this->GANG_BAB->setDbValue($rs->fields('GANG_BAB'));
		$this->STOMA_BAB->setDbValue($rs->fields('STOMA_BAB'));
		$this->PENG_OBAT_BAB->setDbValue($rs->fields('PENG_OBAT_BAB'));
		$this->IST_SIANG->setDbValue($rs->fields('IST_SIANG'));
		$this->IST_MALAM->setDbValue($rs->fields('IST_MALAM'));
		$this->IST_CAHAYA->setDbValue($rs->fields('IST_CAHAYA'));
		$this->IST_POSISI->setDbValue($rs->fields('IST_POSISI'));
		$this->IST_LING->setDbValue($rs->fields('IST_LING'));
		$this->IST_GANG_TIDUR->setDbValue($rs->fields('IST_GANG_TIDUR'));
		$this->PENG_OBAT_IST->setDbValue($rs->fields('PENG_OBAT_IST'));
		$this->FREK_MAND->setDbValue($rs->fields('FREK_MAND'));
		$this->CUC_RAMB_MAND->setDbValue($rs->fields('CUC_RAMB_MAND'));
		$this->SIH_GIGI_MAND->setDbValue($rs->fields('SIH_GIGI_MAND'));
		$this->BANT_MAND->setDbValue($rs->fields('BANT_MAND'));
		$this->GANT_PAKAI->setDbValue($rs->fields('GANT_PAKAI'));
		$this->PAK_CUCI->setDbValue($rs->fields('PAK_CUCI'));
		$this->PAK_BANT->setDbValue($rs->fields('PAK_BANT'));
		$this->ALT_BANT->setDbValue($rs->fields('ALT_BANT'));
		$this->KEMP_MUND->setDbValue($rs->fields('KEMP_MUND'));
		$this->BIL_PUT->setDbValue($rs->fields('BIL_PUT'));
		$this->ADAPTIF->setDbValue($rs->fields('ADAPTIF'));
		$this->MALADAPTIF->setDbValue($rs->fields('MALADAPTIF'));
		$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields('PENANGGUNGJAWAB_NAMA'));
		$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields('PENANGGUNGJAWAB_HUBUNGAN'));
		$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields('PENANGGUNGJAWAB_ALAMAT'));
		$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields('PENANGGUNGJAWAB_PHONE'));
		$this->obat2->setDbValue($rs->fields('obat2'));
		$this->PERBANDINGAN_BB->setDbValue($rs->fields('PERBANDINGAN_BB'));
		$this->KONTINENSIA->setDbValue($rs->fields('KONTINENSIA'));
		$this->JENIS_KULIT1->setDbValue($rs->fields('JENIS_KULIT1'));
		$this->MOBILITAS->setDbValue($rs->fields('MOBILITAS'));
		$this->JK->setDbValue($rs->fields('JK'));
		$this->UMUR->setDbValue($rs->fields('UMUR'));
		$this->NAFSU_MAKAN->setDbValue($rs->fields('NAFSU_MAKAN'));
		$this->OBAT1->setDbValue($rs->fields('OBAT1'));
		$this->MALNUTRISI->setDbValue($rs->fields('MALNUTRISI'));
		$this->MOTORIK1->setDbValue($rs->fields('MOTORIK1'));
		$this->SPINAL->setDbValue($rs->fields('SPINAL'));
		$this->MEJA_OPERASI->setDbValue($rs->fields('MEJA_OPERASI'));
		$this->RIWAYAT_JATUH->setDbValue($rs->fields('RIWAYAT_JATUH'));
		$this->DIAGNOSIS_SEKUNDER->setDbValue($rs->fields('DIAGNOSIS_SEKUNDER'));
		$this->ALAT_BANTU->setDbValue($rs->fields('ALAT_BANTU'));
		$this->HEPARIN->setDbValue($rs->fields('HEPARIN'));
		$this->GAYA_BERJALAN->setDbValue($rs->fields('GAYA_BERJALAN'));
		$this->KESADARAN1->setDbValue($rs->fields('KESADARAN1'));
		$this->NOMR_LAMA->setDbValue($rs->fields('NOMR_LAMA'));
		$this->NO_KARTU->setDbValue($rs->fields('NO_KARTU'));
		$this->JNS_PASIEN->setDbValue($rs->fields('JNS_PASIEN'));
		$this->nama_ayah->setDbValue($rs->fields('nama_ayah'));
		$this->nama_ibu->setDbValue($rs->fields('nama_ibu'));
		$this->nama_suami->setDbValue($rs->fields('nama_suami'));
		$this->nama_istri->setDbValue($rs->fields('nama_istri'));
		$this->KD_ETNIS->setDbValue($rs->fields('KD_ETNIS'));
		$this->KD_BHS_HARIAN->setDbValue($rs->fields('KD_BHS_HARIAN'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->NOMR->DbValue = $row['NOMR'];
		$this->TITLE->DbValue = $row['TITLE'];
		$this->NAMA->DbValue = $row['NAMA'];
		$this->IBUKANDUNG->DbValue = $row['IBUKANDUNG'];
		$this->TEMPAT->DbValue = $row['TEMPAT'];
		$this->TGLLAHIR->DbValue = $row['TGLLAHIR'];
		$this->JENISKELAMIN->DbValue = $row['JENISKELAMIN'];
		$this->ALAMAT->DbValue = $row['ALAMAT'];
		$this->KDPROVINSI->DbValue = $row['KDPROVINSI'];
		$this->KOTA->DbValue = $row['KOTA'];
		$this->KDKECAMATAN->DbValue = $row['KDKECAMATAN'];
		$this->KELURAHAN->DbValue = $row['KELURAHAN'];
		$this->NOTELP->DbValue = $row['NOTELP'];
		$this->NOKTP->DbValue = $row['NOKTP'];
		$this->SUAMI_ORTU->DbValue = $row['SUAMI_ORTU'];
		$this->PEKERJAAN->DbValue = $row['PEKERJAAN'];
		$this->STATUS->DbValue = $row['STATUS'];
		$this->AGAMA->DbValue = $row['AGAMA'];
		$this->PENDIDIKAN->DbValue = $row['PENDIDIKAN'];
		$this->KDCARABAYAR->DbValue = $row['KDCARABAYAR'];
		$this->NIP->DbValue = $row['NIP'];
		$this->TGLDAFTAR->DbValue = $row['TGLDAFTAR'];
		$this->ALAMAT_KTP->DbValue = $row['ALAMAT_KTP'];
		$this->PARENT_NOMR->DbValue = $row['PARENT_NOMR'];
		$this->NAMA_OBAT->DbValue = $row['NAMA_OBAT'];
		$this->DOSIS->DbValue = $row['DOSIS'];
		$this->CARA_PEMBERIAN->DbValue = $row['CARA_PEMBERIAN'];
		$this->FREKUENSI->DbValue = $row['FREKUENSI'];
		$this->WAKTU_TGL->DbValue = $row['WAKTU_TGL'];
		$this->LAMA_WAKTU->DbValue = $row['LAMA_WAKTU'];
		$this->ALERGI_OBAT->DbValue = $row['ALERGI_OBAT'];
		$this->REAKSI_ALERGI->DbValue = $row['REAKSI_ALERGI'];
		$this->RIWAYAT_KES->DbValue = $row['RIWAYAT_KES'];
		$this->BB_LAHIR->DbValue = $row['BB_LAHIR'];
		$this->BB_SEKARANG->DbValue = $row['BB_SEKARANG'];
		$this->FISIK_FONTANEL->DbValue = $row['FISIK_FONTANEL'];
		$this->FISIK_REFLEKS->DbValue = $row['FISIK_REFLEKS'];
		$this->FISIK_SENSASI->DbValue = $row['FISIK_SENSASI'];
		$this->MOTORIK_KASAR->DbValue = $row['MOTORIK_KASAR'];
		$this->MOTORIK_HALUS->DbValue = $row['MOTORIK_HALUS'];
		$this->MAMPU_BICARA->DbValue = $row['MAMPU_BICARA'];
		$this->MAMPU_SOSIALISASI->DbValue = $row['MAMPU_SOSIALISASI'];
		$this->BCG->DbValue = $row['BCG'];
		$this->POLIO->DbValue = $row['POLIO'];
		$this->DPT->DbValue = $row['DPT'];
		$this->CAMPAK->DbValue = $row['CAMPAK'];
		$this->HEPATITIS_B->DbValue = $row['HEPATITIS_B'];
		$this->TD->DbValue = $row['TD'];
		$this->SUHU->DbValue = $row['SUHU'];
		$this->RR->DbValue = $row['RR'];
		$this->NADI->DbValue = $row['NADI'];
		$this->BB->DbValue = $row['BB'];
		$this->TB->DbValue = $row['TB'];
		$this->EYE->DbValue = $row['EYE'];
		$this->MOTORIK->DbValue = $row['MOTORIK'];
		$this->VERBAL->DbValue = $row['VERBAL'];
		$this->TOTAL_GCS->DbValue = $row['TOTAL_GCS'];
		$this->REAKSI_PUPIL->DbValue = $row['REAKSI_PUPIL'];
		$this->KESADARAN->DbValue = $row['KESADARAN'];
		$this->KEPALA->DbValue = $row['KEPALA'];
		$this->RAMBUT->DbValue = $row['RAMBUT'];
		$this->MUKA->DbValue = $row['MUKA'];
		$this->MATA->DbValue = $row['MATA'];
		$this->GANG_LIHAT->DbValue = $row['GANG_LIHAT'];
		$this->ALATBANTU_LIHAT->DbValue = $row['ALATBANTU_LIHAT'];
		$this->BENTUK->DbValue = $row['BENTUK'];
		$this->PENDENGARAN->DbValue = $row['PENDENGARAN'];
		$this->LUB_TELINGA->DbValue = $row['LUB_TELINGA'];
		$this->BENTUK_HIDUNG->DbValue = $row['BENTUK_HIDUNG'];
		$this->MEMBRAN_MUK->DbValue = $row['MEMBRAN_MUK'];
		$this->MAMPU_HIDU->DbValue = $row['MAMPU_HIDU'];
		$this->ALAT_HIDUNG->DbValue = $row['ALAT_HIDUNG'];
		$this->RONGGA_MULUT->DbValue = $row['RONGGA_MULUT'];
		$this->WARNA_MEMBRAN->DbValue = $row['WARNA_MEMBRAN'];
		$this->LEMBAB->DbValue = $row['LEMBAB'];
		$this->STOMATITIS->DbValue = $row['STOMATITIS'];
		$this->LIDAH->DbValue = $row['LIDAH'];
		$this->GIGI->DbValue = $row['GIGI'];
		$this->TONSIL->DbValue = $row['TONSIL'];
		$this->KELAINAN->DbValue = $row['KELAINAN'];
		$this->PERGERAKAN->DbValue = $row['PERGERAKAN'];
		$this->KEL_TIROID->DbValue = $row['KEL_TIROID'];
		$this->KEL_GETAH->DbValue = $row['KEL_GETAH'];
		$this->TEKANAN_VENA->DbValue = $row['TEKANAN_VENA'];
		$this->REF_MENELAN->DbValue = $row['REF_MENELAN'];
		$this->NYERI->DbValue = $row['NYERI'];
		$this->KREPITASI->DbValue = $row['KREPITASI'];
		$this->KEL_LAIN->DbValue = $row['KEL_LAIN'];
		$this->BENTUK_DADA->DbValue = $row['BENTUK_DADA'];
		$this->POLA_NAPAS->DbValue = $row['POLA_NAPAS'];
		$this->BENTUK_THORAKS->DbValue = $row['BENTUK_THORAKS'];
		$this->PAL_KREP->DbValue = $row['PAL_KREP'];
		$this->BENJOLAN->DbValue = $row['BENJOLAN'];
		$this->PAL_NYERI->DbValue = $row['PAL_NYERI'];
		$this->PERKUSI->DbValue = $row['PERKUSI'];
		$this->PARU->DbValue = $row['PARU'];
		$this->JANTUNG->DbValue = $row['JANTUNG'];
		$this->SUARA_JANTUNG->DbValue = $row['SUARA_JANTUNG'];
		$this->ALATBANTU_JAN->DbValue = $row['ALATBANTU_JAN'];
		$this->BENTUK_ABDOMEN->DbValue = $row['BENTUK_ABDOMEN'];
		$this->AUSKULTASI->DbValue = $row['AUSKULTASI'];
		$this->NYERI_PASI->DbValue = $row['NYERI_PASI'];
		$this->PEM_KELENJAR->DbValue = $row['PEM_KELENJAR'];
		$this->PERKUSI_AUS->DbValue = $row['PERKUSI_AUS'];
		$this->VAGINA->DbValue = $row['VAGINA'];
		$this->MENSTRUASI->DbValue = $row['MENSTRUASI'];
		$this->KATETER->DbValue = $row['KATETER'];
		$this->LABIA_PROM->DbValue = $row['LABIA_PROM'];
		$this->HAMIL->DbValue = $row['HAMIL'];
		$this->TGL_HAID->DbValue = $row['TGL_HAID'];
		$this->PERIKSA_CERVIX->DbValue = $row['PERIKSA_CERVIX'];
		$this->BENTUK_PAYUDARA->DbValue = $row['BENTUK_PAYUDARA'];
		$this->KENYAL->DbValue = $row['KENYAL'];
		$this->MASSA->DbValue = $row['MASSA'];
		$this->NYERI_RABA->DbValue = $row['NYERI_RABA'];
		$this->BENTUK_PUTING->DbValue = $row['BENTUK_PUTING'];
		$this->MAMMO->DbValue = $row['MAMMO'];
		$this->ALAT_KONTRASEPSI->DbValue = $row['ALAT_KONTRASEPSI'];
		$this->MASALAH_SEKS->DbValue = $row['MASALAH_SEKS'];
		$this->PREPUTIUM->DbValue = $row['PREPUTIUM'];
		$this->MASALAH_PROSTAT->DbValue = $row['MASALAH_PROSTAT'];
		$this->BENTUK_SKROTUM->DbValue = $row['BENTUK_SKROTUM'];
		$this->TESTIS->DbValue = $row['TESTIS'];
		$this->MASSA_BEN->DbValue = $row['MASSA_BEN'];
		$this->HERNIASI->DbValue = $row['HERNIASI'];
		$this->LAIN2->DbValue = $row['LAIN2'];
		$this->ALAT_KONTRA->DbValue = $row['ALAT_KONTRA'];
		$this->MASALAH_REPRO->DbValue = $row['MASALAH_REPRO'];
		$this->EKSTREMITAS_ATAS->DbValue = $row['EKSTREMITAS_ATAS'];
		$this->EKSTREMITAS_BAWAH->DbValue = $row['EKSTREMITAS_BAWAH'];
		$this->AKTIVITAS->DbValue = $row['AKTIVITAS'];
		$this->BERJALAN->DbValue = $row['BERJALAN'];
		$this->SISTEM_INTE->DbValue = $row['SISTEM_INTE'];
		$this->KENYAMANAN->DbValue = $row['KENYAMANAN'];
		$this->KES_DIRI->DbValue = $row['KES_DIRI'];
		$this->SOS_SUPORT->DbValue = $row['SOS_SUPORT'];
		$this->ANSIETAS->DbValue = $row['ANSIETAS'];
		$this->KEHILANGAN->DbValue = $row['KEHILANGAN'];
		$this->STATUS_EMOSI->DbValue = $row['STATUS_EMOSI'];
		$this->KONSEP_DIRI->DbValue = $row['KONSEP_DIRI'];
		$this->RESPON_HILANG->DbValue = $row['RESPON_HILANG'];
		$this->SUMBER_STRESS->DbValue = $row['SUMBER_STRESS'];
		$this->BERARTI->DbValue = $row['BERARTI'];
		$this->TERLIBAT->DbValue = $row['TERLIBAT'];
		$this->HUBUNGAN->DbValue = $row['HUBUNGAN'];
		$this->KOMUNIKASI->DbValue = $row['KOMUNIKASI'];
		$this->KEPUTUSAN->DbValue = $row['KEPUTUSAN'];
		$this->MENGASUH->DbValue = $row['MENGASUH'];
		$this->DUKUNGAN->DbValue = $row['DUKUNGAN'];
		$this->REAKSI->DbValue = $row['REAKSI'];
		$this->BUDAYA->DbValue = $row['BUDAYA'];
		$this->POLA_AKTIVITAS->DbValue = $row['POLA_AKTIVITAS'];
		$this->POLA_ISTIRAHAT->DbValue = $row['POLA_ISTIRAHAT'];
		$this->POLA_MAKAN->DbValue = $row['POLA_MAKAN'];
		$this->PANTANGAN->DbValue = $row['PANTANGAN'];
		$this->KEPERCAYAAN->DbValue = $row['KEPERCAYAAN'];
		$this->PANTANGAN_HARI->DbValue = $row['PANTANGAN_HARI'];
		$this->PANTANGAN_LAIN->DbValue = $row['PANTANGAN_LAIN'];
		$this->ANJURAN->DbValue = $row['ANJURAN'];
		$this->NILAI_KEYAKINAN->DbValue = $row['NILAI_KEYAKINAN'];
		$this->KEGIATAN_IBADAH->DbValue = $row['KEGIATAN_IBADAH'];
		$this->PENG_AGAMA->DbValue = $row['PENG_AGAMA'];
		$this->SPIRIT->DbValue = $row['SPIRIT'];
		$this->BANTUAN->DbValue = $row['BANTUAN'];
		$this->PAHAM_PENYAKIT->DbValue = $row['PAHAM_PENYAKIT'];
		$this->PAHAM_OBAT->DbValue = $row['PAHAM_OBAT'];
		$this->PAHAM_NUTRISI->DbValue = $row['PAHAM_NUTRISI'];
		$this->PAHAM_RAWAT->DbValue = $row['PAHAM_RAWAT'];
		$this->HAMBATAN_EDUKASI->DbValue = $row['HAMBATAN_EDUKASI'];
		$this->FREK_MAKAN->DbValue = $row['FREK_MAKAN'];
		$this->JUM_MAKAN->DbValue = $row['JUM_MAKAN'];
		$this->JEN_MAKAN->DbValue = $row['JEN_MAKAN'];
		$this->KOM_MAKAN->DbValue = $row['KOM_MAKAN'];
		$this->DIET->DbValue = $row['DIET'];
		$this->CARA_MAKAN->DbValue = $row['CARA_MAKAN'];
		$this->GANGGUAN->DbValue = $row['GANGGUAN'];
		$this->FREK_MINUM->DbValue = $row['FREK_MINUM'];
		$this->JUM_MINUM->DbValue = $row['JUM_MINUM'];
		$this->JEN_MINUM->DbValue = $row['JEN_MINUM'];
		$this->GANG_MINUM->DbValue = $row['GANG_MINUM'];
		$this->FREK_BAK->DbValue = $row['FREK_BAK'];
		$this->WARNA_BAK->DbValue = $row['WARNA_BAK'];
		$this->JMLH_BAK->DbValue = $row['JMLH_BAK'];
		$this->PENG_KAT_BAK->DbValue = $row['PENG_KAT_BAK'];
		$this->KEM_HAN_BAK->DbValue = $row['KEM_HAN_BAK'];
		$this->INKONT_BAK->DbValue = $row['INKONT_BAK'];
		$this->DIURESIS_BAK->DbValue = $row['DIURESIS_BAK'];
		$this->FREK_BAB->DbValue = $row['FREK_BAB'];
		$this->WARNA_BAB->DbValue = $row['WARNA_BAB'];
		$this->KONSIST_BAB->DbValue = $row['KONSIST_BAB'];
		$this->GANG_BAB->DbValue = $row['GANG_BAB'];
		$this->STOMA_BAB->DbValue = $row['STOMA_BAB'];
		$this->PENG_OBAT_BAB->DbValue = $row['PENG_OBAT_BAB'];
		$this->IST_SIANG->DbValue = $row['IST_SIANG'];
		$this->IST_MALAM->DbValue = $row['IST_MALAM'];
		$this->IST_CAHAYA->DbValue = $row['IST_CAHAYA'];
		$this->IST_POSISI->DbValue = $row['IST_POSISI'];
		$this->IST_LING->DbValue = $row['IST_LING'];
		$this->IST_GANG_TIDUR->DbValue = $row['IST_GANG_TIDUR'];
		$this->PENG_OBAT_IST->DbValue = $row['PENG_OBAT_IST'];
		$this->FREK_MAND->DbValue = $row['FREK_MAND'];
		$this->CUC_RAMB_MAND->DbValue = $row['CUC_RAMB_MAND'];
		$this->SIH_GIGI_MAND->DbValue = $row['SIH_GIGI_MAND'];
		$this->BANT_MAND->DbValue = $row['BANT_MAND'];
		$this->GANT_PAKAI->DbValue = $row['GANT_PAKAI'];
		$this->PAK_CUCI->DbValue = $row['PAK_CUCI'];
		$this->PAK_BANT->DbValue = $row['PAK_BANT'];
		$this->ALT_BANT->DbValue = $row['ALT_BANT'];
		$this->KEMP_MUND->DbValue = $row['KEMP_MUND'];
		$this->BIL_PUT->DbValue = $row['BIL_PUT'];
		$this->ADAPTIF->DbValue = $row['ADAPTIF'];
		$this->MALADAPTIF->DbValue = $row['MALADAPTIF'];
		$this->PENANGGUNGJAWAB_NAMA->DbValue = $row['PENANGGUNGJAWAB_NAMA'];
		$this->PENANGGUNGJAWAB_HUBUNGAN->DbValue = $row['PENANGGUNGJAWAB_HUBUNGAN'];
		$this->PENANGGUNGJAWAB_ALAMAT->DbValue = $row['PENANGGUNGJAWAB_ALAMAT'];
		$this->PENANGGUNGJAWAB_PHONE->DbValue = $row['PENANGGUNGJAWAB_PHONE'];
		$this->obat2->DbValue = $row['obat2'];
		$this->PERBANDINGAN_BB->DbValue = $row['PERBANDINGAN_BB'];
		$this->KONTINENSIA->DbValue = $row['KONTINENSIA'];
		$this->JENIS_KULIT1->DbValue = $row['JENIS_KULIT1'];
		$this->MOBILITAS->DbValue = $row['MOBILITAS'];
		$this->JK->DbValue = $row['JK'];
		$this->UMUR->DbValue = $row['UMUR'];
		$this->NAFSU_MAKAN->DbValue = $row['NAFSU_MAKAN'];
		$this->OBAT1->DbValue = $row['OBAT1'];
		$this->MALNUTRISI->DbValue = $row['MALNUTRISI'];
		$this->MOTORIK1->DbValue = $row['MOTORIK1'];
		$this->SPINAL->DbValue = $row['SPINAL'];
		$this->MEJA_OPERASI->DbValue = $row['MEJA_OPERASI'];
		$this->RIWAYAT_JATUH->DbValue = $row['RIWAYAT_JATUH'];
		$this->DIAGNOSIS_SEKUNDER->DbValue = $row['DIAGNOSIS_SEKUNDER'];
		$this->ALAT_BANTU->DbValue = $row['ALAT_BANTU'];
		$this->HEPARIN->DbValue = $row['HEPARIN'];
		$this->GAYA_BERJALAN->DbValue = $row['GAYA_BERJALAN'];
		$this->KESADARAN1->DbValue = $row['KESADARAN1'];
		$this->NOMR_LAMA->DbValue = $row['NOMR_LAMA'];
		$this->NO_KARTU->DbValue = $row['NO_KARTU'];
		$this->JNS_PASIEN->DbValue = $row['JNS_PASIEN'];
		$this->nama_ayah->DbValue = $row['nama_ayah'];
		$this->nama_ibu->DbValue = $row['nama_ibu'];
		$this->nama_suami->DbValue = $row['nama_suami'];
		$this->nama_istri->DbValue = $row['nama_istri'];
		$this->KD_ETNIS->DbValue = $row['KD_ETNIS'];
		$this->KD_BHS_HARIAN->DbValue = $row['KD_BHS_HARIAN'];
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

		// TEMPAT
		$this->TEMPAT->ViewValue = $this->TEMPAT->CurrentValue;
		$this->TEMPAT->ViewCustomAttributes = "";

		// TGLLAHIR
		$this->TGLLAHIR->ViewValue = $this->TGLLAHIR->CurrentValue;
		$this->TGLLAHIR->ViewValue = ew_FormatDateTime($this->TGLLAHIR->ViewValue, 7);
		$this->TGLLAHIR->ViewCustomAttributes = "";

		// JENISKELAMIN
		if (strval($this->JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->JENISKELAMIN->ViewValue = NULL;
		}
		$this->JENISKELAMIN->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// NOTELP
		$this->NOTELP->ViewValue = $this->NOTELP->CurrentValue;
		$this->NOTELP->ViewCustomAttributes = "";

			// NOMR
			$this->NOMR->LinkCustomAttributes = "";
			$this->NOMR->HrefValue = "";
			$this->NOMR->TooltipValue = "";

			// NAMA
			$this->NAMA->LinkCustomAttributes = "";
			$this->NAMA->HrefValue = "";
			$this->NAMA->TooltipValue = "";

			// TEMPAT
			$this->TEMPAT->LinkCustomAttributes = "";
			$this->TEMPAT->HrefValue = "";
			$this->TEMPAT->TooltipValue = "";

			// TGLLAHIR
			$this->TGLLAHIR->LinkCustomAttributes = "";
			$this->TGLLAHIR->HrefValue = "";
			$this->TGLLAHIR->TooltipValue = "";

			// JENISKELAMIN
			$this->JENISKELAMIN->LinkCustomAttributes = "";
			$this->JENISKELAMIN->HrefValue = "";
			$this->JENISKELAMIN->TooltipValue = "";

			// ALAMAT
			$this->ALAMAT->LinkCustomAttributes = "";
			$this->ALAMAT->HrefValue = "";
			$this->ALAMAT->TooltipValue = "";

			// NOTELP
			$this->NOTELP->LinkCustomAttributes = "";
			$this->NOTELP->HrefValue = "";
			$this->NOTELP->TooltipValue = "";
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("m_pasienlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($m_pasien_delete)) $m_pasien_delete = new cm_pasien_delete();

// Page init
$m_pasien_delete->Page_Init();

// Page main
$m_pasien_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$m_pasien_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fm_pasiendelete = new ew_Form("fm_pasiendelete", "delete");

// Form_CustomValidate event
fm_pasiendelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fm_pasiendelete.ValidateRequired = true;
<?php } else { ?>
fm_pasiendelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fm_pasiendelete.Lists["x_JENISKELAMIN"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_jeniskelamin","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_jeniskelamin"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $m_pasien_delete->ShowPageHeader(); ?>
<?php
$m_pasien_delete->ShowMessage();
?>
<form name="fm_pasiendelete" id="fm_pasiendelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($m_pasien_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $m_pasien_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="m_pasien">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($m_pasien_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable table-bordered table-striped table-condensed table-hover">
<?php echo $m_pasien->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($m_pasien->NOMR->Visible) { // NOMR ?>
		<th><span id="elh_m_pasien_NOMR" class="m_pasien_NOMR"><?php echo $m_pasien->NOMR->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_pasien->NAMA->Visible) { // NAMA ?>
		<th><span id="elh_m_pasien_NAMA" class="m_pasien_NAMA"><?php echo $m_pasien->NAMA->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_pasien->TEMPAT->Visible) { // TEMPAT ?>
		<th><span id="elh_m_pasien_TEMPAT" class="m_pasien_TEMPAT"><?php echo $m_pasien->TEMPAT->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_pasien->TGLLAHIR->Visible) { // TGLLAHIR ?>
		<th><span id="elh_m_pasien_TGLLAHIR" class="m_pasien_TGLLAHIR"><?php echo $m_pasien->TGLLAHIR->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_pasien->JENISKELAMIN->Visible) { // JENISKELAMIN ?>
		<th><span id="elh_m_pasien_JENISKELAMIN" class="m_pasien_JENISKELAMIN"><?php echo $m_pasien->JENISKELAMIN->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_pasien->ALAMAT->Visible) { // ALAMAT ?>
		<th><span id="elh_m_pasien_ALAMAT" class="m_pasien_ALAMAT"><?php echo $m_pasien->ALAMAT->FldCaption() ?></span></th>
<?php } ?>
<?php if ($m_pasien->NOTELP->Visible) { // NOTELP ?>
		<th><span id="elh_m_pasien_NOTELP" class="m_pasien_NOTELP"><?php echo $m_pasien->NOTELP->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$m_pasien_delete->RecCnt = 0;
$i = 0;
while (!$m_pasien_delete->Recordset->EOF) {
	$m_pasien_delete->RecCnt++;
	$m_pasien_delete->RowCnt++;

	// Set row properties
	$m_pasien->ResetAttrs();
	$m_pasien->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$m_pasien_delete->LoadRowValues($m_pasien_delete->Recordset);

	// Render row
	$m_pasien_delete->RenderRow();
?>
	<tr<?php echo $m_pasien->RowAttributes() ?>>
<?php if ($m_pasien->NOMR->Visible) { // NOMR ?>
		<td<?php echo $m_pasien->NOMR->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_delete->RowCnt ?>_m_pasien_NOMR" class="m_pasien_NOMR">
<span<?php echo $m_pasien->NOMR->ViewAttributes() ?>>
<?php echo $m_pasien->NOMR->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_pasien->NAMA->Visible) { // NAMA ?>
		<td<?php echo $m_pasien->NAMA->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_delete->RowCnt ?>_m_pasien_NAMA" class="m_pasien_NAMA">
<span<?php echo $m_pasien->NAMA->ViewAttributes() ?>>
<?php echo $m_pasien->NAMA->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_pasien->TEMPAT->Visible) { // TEMPAT ?>
		<td<?php echo $m_pasien->TEMPAT->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_delete->RowCnt ?>_m_pasien_TEMPAT" class="m_pasien_TEMPAT">
<span<?php echo $m_pasien->TEMPAT->ViewAttributes() ?>>
<?php echo $m_pasien->TEMPAT->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_pasien->TGLLAHIR->Visible) { // TGLLAHIR ?>
		<td<?php echo $m_pasien->TGLLAHIR->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_delete->RowCnt ?>_m_pasien_TGLLAHIR" class="m_pasien_TGLLAHIR">
<span<?php echo $m_pasien->TGLLAHIR->ViewAttributes() ?>>
<?php echo $m_pasien->TGLLAHIR->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_pasien->JENISKELAMIN->Visible) { // JENISKELAMIN ?>
		<td<?php echo $m_pasien->JENISKELAMIN->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_delete->RowCnt ?>_m_pasien_JENISKELAMIN" class="m_pasien_JENISKELAMIN">
<span<?php echo $m_pasien->JENISKELAMIN->ViewAttributes() ?>>
<?php echo $m_pasien->JENISKELAMIN->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_pasien->ALAMAT->Visible) { // ALAMAT ?>
		<td<?php echo $m_pasien->ALAMAT->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_delete->RowCnt ?>_m_pasien_ALAMAT" class="m_pasien_ALAMAT">
<span<?php echo $m_pasien->ALAMAT->ViewAttributes() ?>>
<?php echo $m_pasien->ALAMAT->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($m_pasien->NOTELP->Visible) { // NOTELP ?>
		<td<?php echo $m_pasien->NOTELP->CellAttributes() ?>>
<span id="el<?php echo $m_pasien_delete->RowCnt ?>_m_pasien_NOTELP" class="m_pasien_NOTELP">
<span<?php echo $m_pasien->NOTELP->ViewAttributes() ?>>
<?php echo $m_pasien->NOTELP->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$m_pasien_delete->Recordset->MoveNext();
}
$m_pasien_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $m_pasien_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fm_pasiendelete.Init();
</script>
<?php
$m_pasien_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$m_pasien_delete->Page_Terminate();
?>
