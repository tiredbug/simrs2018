<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "t_admissioninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$t_admission_add = NULL; // Initialize page object first

class ct_admission_add extends ct_admission {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_admission';

	// Page object name
	var $PageObjName = 't_admission_add';

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

		// Table object (t_admission)
		if (!isset($GLOBALS["t_admission"]) || get_class($GLOBALS["t_admission"]) == "ct_admission") {
			$GLOBALS["t_admission"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["t_admission"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 't_admission', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("t_admissionlist.php"));
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
		$this->id_admission->SetVisibility();
		$this->nomr->SetVisibility();
		$this->ket_nama->SetVisibility();
		$this->ket_tgllahir->SetVisibility();
		$this->ket_alamat->SetVisibility();
		$this->parent_nomr->SetVisibility();
		$this->dokterpengirim->SetVisibility();
		$this->statusbayar->SetVisibility();
		$this->kirimdari->SetVisibility();
		$this->keluargadekat->SetVisibility();
		$this->panggungjawab->SetVisibility();
		$this->masukrs->SetVisibility();
		$this->noruang->SetVisibility();
		$this->tempat_tidur_id->SetVisibility();
		$this->nott->SetVisibility();
		$this->deposit->SetVisibility();
		$this->keluarrs->SetVisibility();
		$this->icd_masuk->SetVisibility();
		$this->icd_keluar->SetVisibility();
		$this->NIP->SetVisibility();
		$this->noruang_asal->SetVisibility();
		$this->nott_asal->SetVisibility();
		$this->tgl_pindah->SetVisibility();
		$this->kd_rujuk->SetVisibility();
		$this->st_bayar->SetVisibility();
		$this->dokter_penanggungjawab->SetVisibility();
		$this->perawat->SetVisibility();
		$this->KELASPERAWATAN_ID->SetVisibility();
		$this->LOS->SetVisibility();
		$this->TOT_TRF_TIND_DOKTER->SetVisibility();
		$this->TOT_BHP_DOKTER->SetVisibility();
		$this->TOT_TRF_PERAWAT->SetVisibility();
		$this->TOT_BHP_PERAWAT->SetVisibility();
		$this->TOT_TRF_DOKTER->SetVisibility();
		$this->TOT_BIAYA_RAD->SetVisibility();
		$this->TOT_BIAYA_CDRPOLI->SetVisibility();
		$this->TOT_BIAYA_LAB_IGD->SetVisibility();
		$this->TOT_BIAYA_OKSIGEN->SetVisibility();
		$this->TOTAL_BIAYA_OBAT->SetVisibility();
		$this->LINK_SET_KELAS->SetVisibility();
		$this->biaya_obat->SetVisibility();
		$this->biaya_retur_obat->SetVisibility();
		$this->TOT_BIAYA_GIZI->SetVisibility();
		$this->TOT_BIAYA_TMO->SetVisibility();
		$this->TOT_BIAYA_AMBULAN->SetVisibility();
		$this->TOT_BIAYA_FISIO->SetVisibility();
		$this->TOT_BIAYA_LAINLAIN->SetVisibility();
		$this->jenisperawatan_id->SetVisibility();
		$this->status_transaksi->SetVisibility();
		$this->statuskeluarranap_id->SetVisibility();
		$this->TOT_BIAYA_AKOMODASI->SetVisibility();
		$this->TOTAL_BIAYA_ASKEP->SetVisibility();
		$this->TOTAL_BIAYA_SIMRS->SetVisibility();
		$this->TOT_PENJ_NMEDIS->SetVisibility();
		$this->LINK_MASTERDETAIL->SetVisibility();
		$this->NO_SKP->SetVisibility();
		$this->LINK_PELAYANAN_OBAT->SetVisibility();
		$this->TOT_TIND_RAJAL->SetVisibility();
		$this->TOT_TIND_IGD->SetVisibility();
		$this->tanggal_pengembalian_status->SetVisibility();
		$this->naik_kelas->SetVisibility();
		$this->iuran_kelas_lama->SetVisibility();
		$this->iuran_kelas_baru->SetVisibility();
		$this->ketrangan_naik_kelas->SetVisibility();
		$this->tgl_pengiriman_ad_klaim->SetVisibility();
		$this->diagnosa_keluar->SetVisibility();
		$this->sep_tglsep->SetVisibility();
		$this->sep_tglrujuk->SetVisibility();
		$this->sep_kodekelasrawat->SetVisibility();
		$this->sep_norujukan->SetVisibility();
		$this->sep_kodeppkasal->SetVisibility();
		$this->sep_namappkasal->SetVisibility();
		$this->sep_kodeppkpelayanan->SetVisibility();
		$this->sep_namappkpelayanan->SetVisibility();
		$this->t_admissioncol->SetVisibility();
		$this->sep_jenisperawatan->SetVisibility();
		$this->sep_catatan->SetVisibility();
		$this->sep_kodediagnosaawal->SetVisibility();
		$this->sep_namadiagnosaawal->SetVisibility();
		$this->sep_lakalantas->SetVisibility();
		$this->sep_lokasilaka->SetVisibility();
		$this->sep_user->SetVisibility();
		$this->sep_flag_cekpeserta->SetVisibility();
		$this->sep_flag_generatesep->SetVisibility();
		$this->sep_flag_mapingsep->SetVisibility();
		$this->sep_nik->SetVisibility();
		$this->sep_namapeserta->SetVisibility();
		$this->sep_jeniskelamin->SetVisibility();
		$this->sep_pisat->SetVisibility();
		$this->sep_tgllahir->SetVisibility();
		$this->sep_kodejeniskepesertaan->SetVisibility();
		$this->sep_namajeniskepesertaan->SetVisibility();
		$this->sep_kodepolitujuan->SetVisibility();
		$this->sep_namapolitujuan->SetVisibility();
		$this->ket_jeniskelamin->SetVisibility();
		$this->sep_nokabpjs->SetVisibility();
		$this->counter_cetak_sep->SetVisibility();
		$this->sep_petugas_hapus_sep->SetVisibility();
		$this->sep_petugas_set_tgl_pulang->SetVisibility();
		$this->sep_jam_generate_sep->SetVisibility();
		$this->sep_status_peserta->SetVisibility();
		$this->sep_umur_pasien_sekarang->SetVisibility();
		$this->ket_title->SetVisibility();
		$this->status_daftar_ranap->SetVisibility();
		$this->IBS_SETMARKING->SetVisibility();
		$this->IBS_PATOLOGI->SetVisibility();
		$this->IBS_JENISANESTESI->SetVisibility();
		$this->IBS_NO_OK->SetVisibility();
		$this->IBS_ASISSTEN->SetVisibility();
		$this->IBS_JAM_ELEFTIF->SetVisibility();
		$this->IBS_JAM_ELEKTIF_SELESAI->SetVisibility();
		$this->IBS_JAM_CYTO->SetVisibility();
		$this->IBS_JAM_CYTO_SELESAI->SetVisibility();
		$this->IBS_TGL_DFTR_OP->SetVisibility();
		$this->IBS_TGL_OP->SetVisibility();
		$this->grup_ruang_id->SetVisibility();
		$this->status_order_ibs->SetVisibility();

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
		global $EW_EXPORT, $t_admission;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($t_admission);
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
					$this->Page_Terminate("t_admissionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "t_admissionlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "t_admissionview.php")
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
		$this->id_admission->CurrentValue = NULL;
		$this->id_admission->OldValue = $this->id_admission->CurrentValue;
		$this->nomr->CurrentValue = NULL;
		$this->nomr->OldValue = $this->nomr->CurrentValue;
		$this->ket_nama->CurrentValue = NULL;
		$this->ket_nama->OldValue = $this->ket_nama->CurrentValue;
		$this->ket_tgllahir->CurrentValue = NULL;
		$this->ket_tgllahir->OldValue = $this->ket_tgllahir->CurrentValue;
		$this->ket_alamat->CurrentValue = NULL;
		$this->ket_alamat->OldValue = $this->ket_alamat->CurrentValue;
		$this->parent_nomr->CurrentValue = NULL;
		$this->parent_nomr->OldValue = $this->parent_nomr->CurrentValue;
		$this->dokterpengirim->CurrentValue = NULL;
		$this->dokterpengirim->OldValue = $this->dokterpengirim->CurrentValue;
		$this->statusbayar->CurrentValue = NULL;
		$this->statusbayar->OldValue = $this->statusbayar->CurrentValue;
		$this->kirimdari->CurrentValue = NULL;
		$this->kirimdari->OldValue = $this->kirimdari->CurrentValue;
		$this->keluargadekat->CurrentValue = NULL;
		$this->keluargadekat->OldValue = $this->keluargadekat->CurrentValue;
		$this->panggungjawab->CurrentValue = NULL;
		$this->panggungjawab->OldValue = $this->panggungjawab->CurrentValue;
		$this->masukrs->CurrentValue = NULL;
		$this->masukrs->OldValue = $this->masukrs->CurrentValue;
		$this->noruang->CurrentValue = NULL;
		$this->noruang->OldValue = $this->noruang->CurrentValue;
		$this->tempat_tidur_id->CurrentValue = NULL;
		$this->tempat_tidur_id->OldValue = $this->tempat_tidur_id->CurrentValue;
		$this->nott->CurrentValue = NULL;
		$this->nott->OldValue = $this->nott->CurrentValue;
		$this->deposit->CurrentValue = NULL;
		$this->deposit->OldValue = $this->deposit->CurrentValue;
		$this->keluarrs->CurrentValue = NULL;
		$this->keluarrs->OldValue = $this->keluarrs->CurrentValue;
		$this->icd_masuk->CurrentValue = NULL;
		$this->icd_masuk->OldValue = $this->icd_masuk->CurrentValue;
		$this->icd_keluar->CurrentValue = NULL;
		$this->icd_keluar->OldValue = $this->icd_keluar->CurrentValue;
		$this->NIP->CurrentValue = NULL;
		$this->NIP->OldValue = $this->NIP->CurrentValue;
		$this->noruang_asal->CurrentValue = NULL;
		$this->noruang_asal->OldValue = $this->noruang_asal->CurrentValue;
		$this->nott_asal->CurrentValue = NULL;
		$this->nott_asal->OldValue = $this->nott_asal->CurrentValue;
		$this->tgl_pindah->CurrentValue = NULL;
		$this->tgl_pindah->OldValue = $this->tgl_pindah->CurrentValue;
		$this->kd_rujuk->CurrentValue = NULL;
		$this->kd_rujuk->OldValue = $this->kd_rujuk->CurrentValue;
		$this->st_bayar->CurrentValue = NULL;
		$this->st_bayar->OldValue = $this->st_bayar->CurrentValue;
		$this->dokter_penanggungjawab->CurrentValue = NULL;
		$this->dokter_penanggungjawab->OldValue = $this->dokter_penanggungjawab->CurrentValue;
		$this->perawat->CurrentValue = NULL;
		$this->perawat->OldValue = $this->perawat->CurrentValue;
		$this->KELASPERAWATAN_ID->CurrentValue = NULL;
		$this->KELASPERAWATAN_ID->OldValue = $this->KELASPERAWATAN_ID->CurrentValue;
		$this->LOS->CurrentValue = 1;
		$this->TOT_TRF_TIND_DOKTER->CurrentValue = 0;
		$this->TOT_BHP_DOKTER->CurrentValue = 0;
		$this->TOT_TRF_PERAWAT->CurrentValue = 0;
		$this->TOT_BHP_PERAWAT->CurrentValue = 0;
		$this->TOT_TRF_DOKTER->CurrentValue = 0;
		$this->TOT_BIAYA_RAD->CurrentValue = 0;
		$this->TOT_BIAYA_CDRPOLI->CurrentValue = 0;
		$this->TOT_BIAYA_LAB_IGD->CurrentValue = 0;
		$this->TOT_BIAYA_OKSIGEN->CurrentValue = 0;
		$this->TOTAL_BIAYA_OBAT->CurrentValue = 0;
		$this->LINK_SET_KELAS->CurrentValue = NULL;
		$this->LINK_SET_KELAS->OldValue = $this->LINK_SET_KELAS->CurrentValue;
		$this->biaya_obat->CurrentValue = 0;
		$this->biaya_retur_obat->CurrentValue = 0;
		$this->TOT_BIAYA_GIZI->CurrentValue = 0;
		$this->TOT_BIAYA_TMO->CurrentValue = 0;
		$this->TOT_BIAYA_AMBULAN->CurrentValue = 0;
		$this->TOT_BIAYA_FISIO->CurrentValue = 0;
		$this->TOT_BIAYA_LAINLAIN->CurrentValue = 0;
		$this->jenisperawatan_id->CurrentValue = 1;
		$this->status_transaksi->CurrentValue = 0;
		$this->statuskeluarranap_id->CurrentValue = 0;
		$this->TOT_BIAYA_AKOMODASI->CurrentValue = 0;
		$this->TOTAL_BIAYA_ASKEP->CurrentValue = 0;
		$this->TOTAL_BIAYA_SIMRS->CurrentValue = 0;
		$this->TOT_PENJ_NMEDIS->CurrentValue = 0;
		$this->LINK_MASTERDETAIL->CurrentValue = NULL;
		$this->LINK_MASTERDETAIL->OldValue = $this->LINK_MASTERDETAIL->CurrentValue;
		$this->NO_SKP->CurrentValue = NULL;
		$this->NO_SKP->OldValue = $this->NO_SKP->CurrentValue;
		$this->LINK_PELAYANAN_OBAT->CurrentValue = NULL;
		$this->LINK_PELAYANAN_OBAT->OldValue = $this->LINK_PELAYANAN_OBAT->CurrentValue;
		$this->TOT_TIND_RAJAL->CurrentValue = 0;
		$this->TOT_TIND_IGD->CurrentValue = 0;
		$this->tanggal_pengembalian_status->CurrentValue = NULL;
		$this->tanggal_pengembalian_status->OldValue = $this->tanggal_pengembalian_status->CurrentValue;
		$this->naik_kelas->CurrentValue = NULL;
		$this->naik_kelas->OldValue = $this->naik_kelas->CurrentValue;
		$this->iuran_kelas_lama->CurrentValue = NULL;
		$this->iuran_kelas_lama->OldValue = $this->iuran_kelas_lama->CurrentValue;
		$this->iuran_kelas_baru->CurrentValue = NULL;
		$this->iuran_kelas_baru->OldValue = $this->iuran_kelas_baru->CurrentValue;
		$this->ketrangan_naik_kelas->CurrentValue = NULL;
		$this->ketrangan_naik_kelas->OldValue = $this->ketrangan_naik_kelas->CurrentValue;
		$this->tgl_pengiriman_ad_klaim->CurrentValue = NULL;
		$this->tgl_pengiriman_ad_klaim->OldValue = $this->tgl_pengiriman_ad_klaim->CurrentValue;
		$this->diagnosa_keluar->CurrentValue = NULL;
		$this->diagnosa_keluar->OldValue = $this->diagnosa_keluar->CurrentValue;
		$this->sep_tglsep->CurrentValue = NULL;
		$this->sep_tglsep->OldValue = $this->sep_tglsep->CurrentValue;
		$this->sep_tglrujuk->CurrentValue = NULL;
		$this->sep_tglrujuk->OldValue = $this->sep_tglrujuk->CurrentValue;
		$this->sep_kodekelasrawat->CurrentValue = NULL;
		$this->sep_kodekelasrawat->OldValue = $this->sep_kodekelasrawat->CurrentValue;
		$this->sep_norujukan->CurrentValue = NULL;
		$this->sep_norujukan->OldValue = $this->sep_norujukan->CurrentValue;
		$this->sep_kodeppkasal->CurrentValue = NULL;
		$this->sep_kodeppkasal->OldValue = $this->sep_kodeppkasal->CurrentValue;
		$this->sep_namappkasal->CurrentValue = NULL;
		$this->sep_namappkasal->OldValue = $this->sep_namappkasal->CurrentValue;
		$this->sep_kodeppkpelayanan->CurrentValue = NULL;
		$this->sep_kodeppkpelayanan->OldValue = $this->sep_kodeppkpelayanan->CurrentValue;
		$this->sep_namappkpelayanan->CurrentValue = NULL;
		$this->sep_namappkpelayanan->OldValue = $this->sep_namappkpelayanan->CurrentValue;
		$this->t_admissioncol->CurrentValue = NULL;
		$this->t_admissioncol->OldValue = $this->t_admissioncol->CurrentValue;
		$this->sep_jenisperawatan->CurrentValue = NULL;
		$this->sep_jenisperawatan->OldValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_catatan->CurrentValue = NULL;
		$this->sep_catatan->OldValue = $this->sep_catatan->CurrentValue;
		$this->sep_kodediagnosaawal->CurrentValue = NULL;
		$this->sep_kodediagnosaawal->OldValue = $this->sep_kodediagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->CurrentValue = NULL;
		$this->sep_namadiagnosaawal->OldValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_lakalantas->CurrentValue = 2;
		$this->sep_lokasilaka->CurrentValue = NULL;
		$this->sep_lokasilaka->OldValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_user->CurrentValue = NULL;
		$this->sep_user->OldValue = $this->sep_user->CurrentValue;
		$this->sep_flag_cekpeserta->CurrentValue = NULL;
		$this->sep_flag_cekpeserta->OldValue = $this->sep_flag_cekpeserta->CurrentValue;
		$this->sep_flag_generatesep->CurrentValue = NULL;
		$this->sep_flag_generatesep->OldValue = $this->sep_flag_generatesep->CurrentValue;
		$this->sep_flag_mapingsep->CurrentValue = NULL;
		$this->sep_flag_mapingsep->OldValue = $this->sep_flag_mapingsep->CurrentValue;
		$this->sep_nik->CurrentValue = NULL;
		$this->sep_nik->OldValue = $this->sep_nik->CurrentValue;
		$this->sep_namapeserta->CurrentValue = NULL;
		$this->sep_namapeserta->OldValue = $this->sep_namapeserta->CurrentValue;
		$this->sep_jeniskelamin->CurrentValue = NULL;
		$this->sep_jeniskelamin->OldValue = $this->sep_jeniskelamin->CurrentValue;
		$this->sep_pisat->CurrentValue = NULL;
		$this->sep_pisat->OldValue = $this->sep_pisat->CurrentValue;
		$this->sep_tgllahir->CurrentValue = NULL;
		$this->sep_tgllahir->OldValue = $this->sep_tgllahir->CurrentValue;
		$this->sep_kodejeniskepesertaan->CurrentValue = NULL;
		$this->sep_kodejeniskepesertaan->OldValue = $this->sep_kodejeniskepesertaan->CurrentValue;
		$this->sep_namajeniskepesertaan->CurrentValue = NULL;
		$this->sep_namajeniskepesertaan->OldValue = $this->sep_namajeniskepesertaan->CurrentValue;
		$this->sep_kodepolitujuan->CurrentValue = NULL;
		$this->sep_kodepolitujuan->OldValue = $this->sep_kodepolitujuan->CurrentValue;
		$this->sep_namapolitujuan->CurrentValue = NULL;
		$this->sep_namapolitujuan->OldValue = $this->sep_namapolitujuan->CurrentValue;
		$this->ket_jeniskelamin->CurrentValue = NULL;
		$this->ket_jeniskelamin->OldValue = $this->ket_jeniskelamin->CurrentValue;
		$this->sep_nokabpjs->CurrentValue = NULL;
		$this->sep_nokabpjs->OldValue = $this->sep_nokabpjs->CurrentValue;
		$this->counter_cetak_sep->CurrentValue = 0;
		$this->sep_petugas_hapus_sep->CurrentValue = NULL;
		$this->sep_petugas_hapus_sep->OldValue = $this->sep_petugas_hapus_sep->CurrentValue;
		$this->sep_petugas_set_tgl_pulang->CurrentValue = NULL;
		$this->sep_petugas_set_tgl_pulang->OldValue = $this->sep_petugas_set_tgl_pulang->CurrentValue;
		$this->sep_jam_generate_sep->CurrentValue = NULL;
		$this->sep_jam_generate_sep->OldValue = $this->sep_jam_generate_sep->CurrentValue;
		$this->sep_status_peserta->CurrentValue = NULL;
		$this->sep_status_peserta->OldValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_umur_pasien_sekarang->CurrentValue = NULL;
		$this->sep_umur_pasien_sekarang->OldValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->ket_title->CurrentValue = NULL;
		$this->ket_title->OldValue = $this->ket_title->CurrentValue;
		$this->status_daftar_ranap->CurrentValue = 0;
		$this->IBS_SETMARKING->CurrentValue = 0;
		$this->IBS_PATOLOGI->CurrentValue = 0;
		$this->IBS_JENISANESTESI->CurrentValue = NULL;
		$this->IBS_JENISANESTESI->OldValue = $this->IBS_JENISANESTESI->CurrentValue;
		$this->IBS_NO_OK->CurrentValue = NULL;
		$this->IBS_NO_OK->OldValue = $this->IBS_NO_OK->CurrentValue;
		$this->IBS_ASISSTEN->CurrentValue = NULL;
		$this->IBS_ASISSTEN->OldValue = $this->IBS_ASISSTEN->CurrentValue;
		$this->IBS_JAM_ELEFTIF->CurrentValue = NULL;
		$this->IBS_JAM_ELEFTIF->OldValue = $this->IBS_JAM_ELEFTIF->CurrentValue;
		$this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue = NULL;
		$this->IBS_JAM_ELEKTIF_SELESAI->OldValue = $this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue;
		$this->IBS_JAM_CYTO->CurrentValue = NULL;
		$this->IBS_JAM_CYTO->OldValue = $this->IBS_JAM_CYTO->CurrentValue;
		$this->IBS_JAM_CYTO_SELESAI->CurrentValue = NULL;
		$this->IBS_JAM_CYTO_SELESAI->OldValue = $this->IBS_JAM_CYTO_SELESAI->CurrentValue;
		$this->IBS_TGL_DFTR_OP->CurrentValue = NULL;
		$this->IBS_TGL_DFTR_OP->OldValue = $this->IBS_TGL_DFTR_OP->CurrentValue;
		$this->IBS_TGL_OP->CurrentValue = NULL;
		$this->IBS_TGL_OP->OldValue = $this->IBS_TGL_OP->CurrentValue;
		$this->grup_ruang_id->CurrentValue = NULL;
		$this->grup_ruang_id->OldValue = $this->grup_ruang_id->CurrentValue;
		$this->status_order_ibs->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id_admission->FldIsDetailKey) {
			$this->id_admission->setFormValue($objForm->GetValue("x_id_admission"));
		}
		if (!$this->nomr->FldIsDetailKey) {
			$this->nomr->setFormValue($objForm->GetValue("x_nomr"));
		}
		if (!$this->ket_nama->FldIsDetailKey) {
			$this->ket_nama->setFormValue($objForm->GetValue("x_ket_nama"));
		}
		if (!$this->ket_tgllahir->FldIsDetailKey) {
			$this->ket_tgllahir->setFormValue($objForm->GetValue("x_ket_tgllahir"));
			$this->ket_tgllahir->CurrentValue = ew_UnFormatDateTime($this->ket_tgllahir->CurrentValue, 0);
		}
		if (!$this->ket_alamat->FldIsDetailKey) {
			$this->ket_alamat->setFormValue($objForm->GetValue("x_ket_alamat"));
		}
		if (!$this->parent_nomr->FldIsDetailKey) {
			$this->parent_nomr->setFormValue($objForm->GetValue("x_parent_nomr"));
		}
		if (!$this->dokterpengirim->FldIsDetailKey) {
			$this->dokterpengirim->setFormValue($objForm->GetValue("x_dokterpengirim"));
		}
		if (!$this->statusbayar->FldIsDetailKey) {
			$this->statusbayar->setFormValue($objForm->GetValue("x_statusbayar"));
		}
		if (!$this->kirimdari->FldIsDetailKey) {
			$this->kirimdari->setFormValue($objForm->GetValue("x_kirimdari"));
		}
		if (!$this->keluargadekat->FldIsDetailKey) {
			$this->keluargadekat->setFormValue($objForm->GetValue("x_keluargadekat"));
		}
		if (!$this->panggungjawab->FldIsDetailKey) {
			$this->panggungjawab->setFormValue($objForm->GetValue("x_panggungjawab"));
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
		if (!$this->nott->FldIsDetailKey) {
			$this->nott->setFormValue($objForm->GetValue("x_nott"));
		}
		if (!$this->deposit->FldIsDetailKey) {
			$this->deposit->setFormValue($objForm->GetValue("x_deposit"));
		}
		if (!$this->keluarrs->FldIsDetailKey) {
			$this->keluarrs->setFormValue($objForm->GetValue("x_keluarrs"));
			$this->keluarrs->CurrentValue = ew_UnFormatDateTime($this->keluarrs->CurrentValue, 0);
		}
		if (!$this->icd_masuk->FldIsDetailKey) {
			$this->icd_masuk->setFormValue($objForm->GetValue("x_icd_masuk"));
		}
		if (!$this->icd_keluar->FldIsDetailKey) {
			$this->icd_keluar->setFormValue($objForm->GetValue("x_icd_keluar"));
		}
		if (!$this->NIP->FldIsDetailKey) {
			$this->NIP->setFormValue($objForm->GetValue("x_NIP"));
		}
		if (!$this->noruang_asal->FldIsDetailKey) {
			$this->noruang_asal->setFormValue($objForm->GetValue("x_noruang_asal"));
		}
		if (!$this->nott_asal->FldIsDetailKey) {
			$this->nott_asal->setFormValue($objForm->GetValue("x_nott_asal"));
		}
		if (!$this->tgl_pindah->FldIsDetailKey) {
			$this->tgl_pindah->setFormValue($objForm->GetValue("x_tgl_pindah"));
			$this->tgl_pindah->CurrentValue = ew_UnFormatDateTime($this->tgl_pindah->CurrentValue, 0);
		}
		if (!$this->kd_rujuk->FldIsDetailKey) {
			$this->kd_rujuk->setFormValue($objForm->GetValue("x_kd_rujuk"));
		}
		if (!$this->st_bayar->FldIsDetailKey) {
			$this->st_bayar->setFormValue($objForm->GetValue("x_st_bayar"));
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey) {
			$this->dokter_penanggungjawab->setFormValue($objForm->GetValue("x_dokter_penanggungjawab"));
		}
		if (!$this->perawat->FldIsDetailKey) {
			$this->perawat->setFormValue($objForm->GetValue("x_perawat"));
		}
		if (!$this->KELASPERAWATAN_ID->FldIsDetailKey) {
			$this->KELASPERAWATAN_ID->setFormValue($objForm->GetValue("x_KELASPERAWATAN_ID"));
		}
		if (!$this->LOS->FldIsDetailKey) {
			$this->LOS->setFormValue($objForm->GetValue("x_LOS"));
		}
		if (!$this->TOT_TRF_TIND_DOKTER->FldIsDetailKey) {
			$this->TOT_TRF_TIND_DOKTER->setFormValue($objForm->GetValue("x_TOT_TRF_TIND_DOKTER"));
		}
		if (!$this->TOT_BHP_DOKTER->FldIsDetailKey) {
			$this->TOT_BHP_DOKTER->setFormValue($objForm->GetValue("x_TOT_BHP_DOKTER"));
		}
		if (!$this->TOT_TRF_PERAWAT->FldIsDetailKey) {
			$this->TOT_TRF_PERAWAT->setFormValue($objForm->GetValue("x_TOT_TRF_PERAWAT"));
		}
		if (!$this->TOT_BHP_PERAWAT->FldIsDetailKey) {
			$this->TOT_BHP_PERAWAT->setFormValue($objForm->GetValue("x_TOT_BHP_PERAWAT"));
		}
		if (!$this->TOT_TRF_DOKTER->FldIsDetailKey) {
			$this->TOT_TRF_DOKTER->setFormValue($objForm->GetValue("x_TOT_TRF_DOKTER"));
		}
		if (!$this->TOT_BIAYA_RAD->FldIsDetailKey) {
			$this->TOT_BIAYA_RAD->setFormValue($objForm->GetValue("x_TOT_BIAYA_RAD"));
		}
		if (!$this->TOT_BIAYA_CDRPOLI->FldIsDetailKey) {
			$this->TOT_BIAYA_CDRPOLI->setFormValue($objForm->GetValue("x_TOT_BIAYA_CDRPOLI"));
		}
		if (!$this->TOT_BIAYA_LAB_IGD->FldIsDetailKey) {
			$this->TOT_BIAYA_LAB_IGD->setFormValue($objForm->GetValue("x_TOT_BIAYA_LAB_IGD"));
		}
		if (!$this->TOT_BIAYA_OKSIGEN->FldIsDetailKey) {
			$this->TOT_BIAYA_OKSIGEN->setFormValue($objForm->GetValue("x_TOT_BIAYA_OKSIGEN"));
		}
		if (!$this->TOTAL_BIAYA_OBAT->FldIsDetailKey) {
			$this->TOTAL_BIAYA_OBAT->setFormValue($objForm->GetValue("x_TOTAL_BIAYA_OBAT"));
		}
		if (!$this->LINK_SET_KELAS->FldIsDetailKey) {
			$this->LINK_SET_KELAS->setFormValue($objForm->GetValue("x_LINK_SET_KELAS"));
		}
		if (!$this->biaya_obat->FldIsDetailKey) {
			$this->biaya_obat->setFormValue($objForm->GetValue("x_biaya_obat"));
		}
		if (!$this->biaya_retur_obat->FldIsDetailKey) {
			$this->biaya_retur_obat->setFormValue($objForm->GetValue("x_biaya_retur_obat"));
		}
		if (!$this->TOT_BIAYA_GIZI->FldIsDetailKey) {
			$this->TOT_BIAYA_GIZI->setFormValue($objForm->GetValue("x_TOT_BIAYA_GIZI"));
		}
		if (!$this->TOT_BIAYA_TMO->FldIsDetailKey) {
			$this->TOT_BIAYA_TMO->setFormValue($objForm->GetValue("x_TOT_BIAYA_TMO"));
		}
		if (!$this->TOT_BIAYA_AMBULAN->FldIsDetailKey) {
			$this->TOT_BIAYA_AMBULAN->setFormValue($objForm->GetValue("x_TOT_BIAYA_AMBULAN"));
		}
		if (!$this->TOT_BIAYA_FISIO->FldIsDetailKey) {
			$this->TOT_BIAYA_FISIO->setFormValue($objForm->GetValue("x_TOT_BIAYA_FISIO"));
		}
		if (!$this->TOT_BIAYA_LAINLAIN->FldIsDetailKey) {
			$this->TOT_BIAYA_LAINLAIN->setFormValue($objForm->GetValue("x_TOT_BIAYA_LAINLAIN"));
		}
		if (!$this->jenisperawatan_id->FldIsDetailKey) {
			$this->jenisperawatan_id->setFormValue($objForm->GetValue("x_jenisperawatan_id"));
		}
		if (!$this->status_transaksi->FldIsDetailKey) {
			$this->status_transaksi->setFormValue($objForm->GetValue("x_status_transaksi"));
		}
		if (!$this->statuskeluarranap_id->FldIsDetailKey) {
			$this->statuskeluarranap_id->setFormValue($objForm->GetValue("x_statuskeluarranap_id"));
		}
		if (!$this->TOT_BIAYA_AKOMODASI->FldIsDetailKey) {
			$this->TOT_BIAYA_AKOMODASI->setFormValue($objForm->GetValue("x_TOT_BIAYA_AKOMODASI"));
		}
		if (!$this->TOTAL_BIAYA_ASKEP->FldIsDetailKey) {
			$this->TOTAL_BIAYA_ASKEP->setFormValue($objForm->GetValue("x_TOTAL_BIAYA_ASKEP"));
		}
		if (!$this->TOTAL_BIAYA_SIMRS->FldIsDetailKey) {
			$this->TOTAL_BIAYA_SIMRS->setFormValue($objForm->GetValue("x_TOTAL_BIAYA_SIMRS"));
		}
		if (!$this->TOT_PENJ_NMEDIS->FldIsDetailKey) {
			$this->TOT_PENJ_NMEDIS->setFormValue($objForm->GetValue("x_TOT_PENJ_NMEDIS"));
		}
		if (!$this->LINK_MASTERDETAIL->FldIsDetailKey) {
			$this->LINK_MASTERDETAIL->setFormValue($objForm->GetValue("x_LINK_MASTERDETAIL"));
		}
		if (!$this->NO_SKP->FldIsDetailKey) {
			$this->NO_SKP->setFormValue($objForm->GetValue("x_NO_SKP"));
		}
		if (!$this->LINK_PELAYANAN_OBAT->FldIsDetailKey) {
			$this->LINK_PELAYANAN_OBAT->setFormValue($objForm->GetValue("x_LINK_PELAYANAN_OBAT"));
		}
		if (!$this->TOT_TIND_RAJAL->FldIsDetailKey) {
			$this->TOT_TIND_RAJAL->setFormValue($objForm->GetValue("x_TOT_TIND_RAJAL"));
		}
		if (!$this->TOT_TIND_IGD->FldIsDetailKey) {
			$this->TOT_TIND_IGD->setFormValue($objForm->GetValue("x_TOT_TIND_IGD"));
		}
		if (!$this->tanggal_pengembalian_status->FldIsDetailKey) {
			$this->tanggal_pengembalian_status->setFormValue($objForm->GetValue("x_tanggal_pengembalian_status"));
			$this->tanggal_pengembalian_status->CurrentValue = ew_UnFormatDateTime($this->tanggal_pengembalian_status->CurrentValue, 0);
		}
		if (!$this->naik_kelas->FldIsDetailKey) {
			$this->naik_kelas->setFormValue($objForm->GetValue("x_naik_kelas"));
		}
		if (!$this->iuran_kelas_lama->FldIsDetailKey) {
			$this->iuran_kelas_lama->setFormValue($objForm->GetValue("x_iuran_kelas_lama"));
		}
		if (!$this->iuran_kelas_baru->FldIsDetailKey) {
			$this->iuran_kelas_baru->setFormValue($objForm->GetValue("x_iuran_kelas_baru"));
		}
		if (!$this->ketrangan_naik_kelas->FldIsDetailKey) {
			$this->ketrangan_naik_kelas->setFormValue($objForm->GetValue("x_ketrangan_naik_kelas"));
		}
		if (!$this->tgl_pengiriman_ad_klaim->FldIsDetailKey) {
			$this->tgl_pengiriman_ad_klaim->setFormValue($objForm->GetValue("x_tgl_pengiriman_ad_klaim"));
			$this->tgl_pengiriman_ad_klaim->CurrentValue = ew_UnFormatDateTime($this->tgl_pengiriman_ad_klaim->CurrentValue, 0);
		}
		if (!$this->diagnosa_keluar->FldIsDetailKey) {
			$this->diagnosa_keluar->setFormValue($objForm->GetValue("x_diagnosa_keluar"));
		}
		if (!$this->sep_tglsep->FldIsDetailKey) {
			$this->sep_tglsep->setFormValue($objForm->GetValue("x_sep_tglsep"));
			$this->sep_tglsep->CurrentValue = ew_UnFormatDateTime($this->sep_tglsep->CurrentValue, 0);
		}
		if (!$this->sep_tglrujuk->FldIsDetailKey) {
			$this->sep_tglrujuk->setFormValue($objForm->GetValue("x_sep_tglrujuk"));
			$this->sep_tglrujuk->CurrentValue = ew_UnFormatDateTime($this->sep_tglrujuk->CurrentValue, 0);
		}
		if (!$this->sep_kodekelasrawat->FldIsDetailKey) {
			$this->sep_kodekelasrawat->setFormValue($objForm->GetValue("x_sep_kodekelasrawat"));
		}
		if (!$this->sep_norujukan->FldIsDetailKey) {
			$this->sep_norujukan->setFormValue($objForm->GetValue("x_sep_norujukan"));
		}
		if (!$this->sep_kodeppkasal->FldIsDetailKey) {
			$this->sep_kodeppkasal->setFormValue($objForm->GetValue("x_sep_kodeppkasal"));
		}
		if (!$this->sep_namappkasal->FldIsDetailKey) {
			$this->sep_namappkasal->setFormValue($objForm->GetValue("x_sep_namappkasal"));
		}
		if (!$this->sep_kodeppkpelayanan->FldIsDetailKey) {
			$this->sep_kodeppkpelayanan->setFormValue($objForm->GetValue("x_sep_kodeppkpelayanan"));
		}
		if (!$this->sep_namappkpelayanan->FldIsDetailKey) {
			$this->sep_namappkpelayanan->setFormValue($objForm->GetValue("x_sep_namappkpelayanan"));
		}
		if (!$this->t_admissioncol->FldIsDetailKey) {
			$this->t_admissioncol->setFormValue($objForm->GetValue("x_t_admissioncol"));
		}
		if (!$this->sep_jenisperawatan->FldIsDetailKey) {
			$this->sep_jenisperawatan->setFormValue($objForm->GetValue("x_sep_jenisperawatan"));
		}
		if (!$this->sep_catatan->FldIsDetailKey) {
			$this->sep_catatan->setFormValue($objForm->GetValue("x_sep_catatan"));
		}
		if (!$this->sep_kodediagnosaawal->FldIsDetailKey) {
			$this->sep_kodediagnosaawal->setFormValue($objForm->GetValue("x_sep_kodediagnosaawal"));
		}
		if (!$this->sep_namadiagnosaawal->FldIsDetailKey) {
			$this->sep_namadiagnosaawal->setFormValue($objForm->GetValue("x_sep_namadiagnosaawal"));
		}
		if (!$this->sep_lakalantas->FldIsDetailKey) {
			$this->sep_lakalantas->setFormValue($objForm->GetValue("x_sep_lakalantas"));
		}
		if (!$this->sep_lokasilaka->FldIsDetailKey) {
			$this->sep_lokasilaka->setFormValue($objForm->GetValue("x_sep_lokasilaka"));
		}
		if (!$this->sep_user->FldIsDetailKey) {
			$this->sep_user->setFormValue($objForm->GetValue("x_sep_user"));
		}
		if (!$this->sep_flag_cekpeserta->FldIsDetailKey) {
			$this->sep_flag_cekpeserta->setFormValue($objForm->GetValue("x_sep_flag_cekpeserta"));
		}
		if (!$this->sep_flag_generatesep->FldIsDetailKey) {
			$this->sep_flag_generatesep->setFormValue($objForm->GetValue("x_sep_flag_generatesep"));
		}
		if (!$this->sep_flag_mapingsep->FldIsDetailKey) {
			$this->sep_flag_mapingsep->setFormValue($objForm->GetValue("x_sep_flag_mapingsep"));
		}
		if (!$this->sep_nik->FldIsDetailKey) {
			$this->sep_nik->setFormValue($objForm->GetValue("x_sep_nik"));
		}
		if (!$this->sep_namapeserta->FldIsDetailKey) {
			$this->sep_namapeserta->setFormValue($objForm->GetValue("x_sep_namapeserta"));
		}
		if (!$this->sep_jeniskelamin->FldIsDetailKey) {
			$this->sep_jeniskelamin->setFormValue($objForm->GetValue("x_sep_jeniskelamin"));
		}
		if (!$this->sep_pisat->FldIsDetailKey) {
			$this->sep_pisat->setFormValue($objForm->GetValue("x_sep_pisat"));
		}
		if (!$this->sep_tgllahir->FldIsDetailKey) {
			$this->sep_tgllahir->setFormValue($objForm->GetValue("x_sep_tgllahir"));
		}
		if (!$this->sep_kodejeniskepesertaan->FldIsDetailKey) {
			$this->sep_kodejeniskepesertaan->setFormValue($objForm->GetValue("x_sep_kodejeniskepesertaan"));
		}
		if (!$this->sep_namajeniskepesertaan->FldIsDetailKey) {
			$this->sep_namajeniskepesertaan->setFormValue($objForm->GetValue("x_sep_namajeniskepesertaan"));
		}
		if (!$this->sep_kodepolitujuan->FldIsDetailKey) {
			$this->sep_kodepolitujuan->setFormValue($objForm->GetValue("x_sep_kodepolitujuan"));
		}
		if (!$this->sep_namapolitujuan->FldIsDetailKey) {
			$this->sep_namapolitujuan->setFormValue($objForm->GetValue("x_sep_namapolitujuan"));
		}
		if (!$this->ket_jeniskelamin->FldIsDetailKey) {
			$this->ket_jeniskelamin->setFormValue($objForm->GetValue("x_ket_jeniskelamin"));
		}
		if (!$this->sep_nokabpjs->FldIsDetailKey) {
			$this->sep_nokabpjs->setFormValue($objForm->GetValue("x_sep_nokabpjs"));
		}
		if (!$this->counter_cetak_sep->FldIsDetailKey) {
			$this->counter_cetak_sep->setFormValue($objForm->GetValue("x_counter_cetak_sep"));
		}
		if (!$this->sep_petugas_hapus_sep->FldIsDetailKey) {
			$this->sep_petugas_hapus_sep->setFormValue($objForm->GetValue("x_sep_petugas_hapus_sep"));
		}
		if (!$this->sep_petugas_set_tgl_pulang->FldIsDetailKey) {
			$this->sep_petugas_set_tgl_pulang->setFormValue($objForm->GetValue("x_sep_petugas_set_tgl_pulang"));
		}
		if (!$this->sep_jam_generate_sep->FldIsDetailKey) {
			$this->sep_jam_generate_sep->setFormValue($objForm->GetValue("x_sep_jam_generate_sep"));
			$this->sep_jam_generate_sep->CurrentValue = ew_UnFormatDateTime($this->sep_jam_generate_sep->CurrentValue, 0);
		}
		if (!$this->sep_status_peserta->FldIsDetailKey) {
			$this->sep_status_peserta->setFormValue($objForm->GetValue("x_sep_status_peserta"));
		}
		if (!$this->sep_umur_pasien_sekarang->FldIsDetailKey) {
			$this->sep_umur_pasien_sekarang->setFormValue($objForm->GetValue("x_sep_umur_pasien_sekarang"));
		}
		if (!$this->ket_title->FldIsDetailKey) {
			$this->ket_title->setFormValue($objForm->GetValue("x_ket_title"));
		}
		if (!$this->status_daftar_ranap->FldIsDetailKey) {
			$this->status_daftar_ranap->setFormValue($objForm->GetValue("x_status_daftar_ranap"));
		}
		if (!$this->IBS_SETMARKING->FldIsDetailKey) {
			$this->IBS_SETMARKING->setFormValue($objForm->GetValue("x_IBS_SETMARKING"));
		}
		if (!$this->IBS_PATOLOGI->FldIsDetailKey) {
			$this->IBS_PATOLOGI->setFormValue($objForm->GetValue("x_IBS_PATOLOGI"));
		}
		if (!$this->IBS_JENISANESTESI->FldIsDetailKey) {
			$this->IBS_JENISANESTESI->setFormValue($objForm->GetValue("x_IBS_JENISANESTESI"));
		}
		if (!$this->IBS_NO_OK->FldIsDetailKey) {
			$this->IBS_NO_OK->setFormValue($objForm->GetValue("x_IBS_NO_OK"));
		}
		if (!$this->IBS_ASISSTEN->FldIsDetailKey) {
			$this->IBS_ASISSTEN->setFormValue($objForm->GetValue("x_IBS_ASISSTEN"));
		}
		if (!$this->IBS_JAM_ELEFTIF->FldIsDetailKey) {
			$this->IBS_JAM_ELEFTIF->setFormValue($objForm->GetValue("x_IBS_JAM_ELEFTIF"));
			$this->IBS_JAM_ELEFTIF->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_ELEFTIF->CurrentValue, 0);
		}
		if (!$this->IBS_JAM_ELEKTIF_SELESAI->FldIsDetailKey) {
			$this->IBS_JAM_ELEKTIF_SELESAI->setFormValue($objForm->GetValue("x_IBS_JAM_ELEKTIF_SELESAI"));
			$this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue, 0);
		}
		if (!$this->IBS_JAM_CYTO->FldIsDetailKey) {
			$this->IBS_JAM_CYTO->setFormValue($objForm->GetValue("x_IBS_JAM_CYTO"));
			$this->IBS_JAM_CYTO->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_CYTO->CurrentValue, 0);
		}
		if (!$this->IBS_JAM_CYTO_SELESAI->FldIsDetailKey) {
			$this->IBS_JAM_CYTO_SELESAI->setFormValue($objForm->GetValue("x_IBS_JAM_CYTO_SELESAI"));
			$this->IBS_JAM_CYTO_SELESAI->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_CYTO_SELESAI->CurrentValue, 0);
		}
		if (!$this->IBS_TGL_DFTR_OP->FldIsDetailKey) {
			$this->IBS_TGL_DFTR_OP->setFormValue($objForm->GetValue("x_IBS_TGL_DFTR_OP"));
			$this->IBS_TGL_DFTR_OP->CurrentValue = ew_UnFormatDateTime($this->IBS_TGL_DFTR_OP->CurrentValue, 0);
		}
		if (!$this->IBS_TGL_OP->FldIsDetailKey) {
			$this->IBS_TGL_OP->setFormValue($objForm->GetValue("x_IBS_TGL_OP"));
			$this->IBS_TGL_OP->CurrentValue = ew_UnFormatDateTime($this->IBS_TGL_OP->CurrentValue, 0);
		}
		if (!$this->grup_ruang_id->FldIsDetailKey) {
			$this->grup_ruang_id->setFormValue($objForm->GetValue("x_grup_ruang_id"));
		}
		if (!$this->status_order_ibs->FldIsDetailKey) {
			$this->status_order_ibs->setFormValue($objForm->GetValue("x_status_order_ibs"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->id_admission->CurrentValue = $this->id_admission->FormValue;
		$this->nomr->CurrentValue = $this->nomr->FormValue;
		$this->ket_nama->CurrentValue = $this->ket_nama->FormValue;
		$this->ket_tgllahir->CurrentValue = $this->ket_tgllahir->FormValue;
		$this->ket_tgllahir->CurrentValue = ew_UnFormatDateTime($this->ket_tgllahir->CurrentValue, 0);
		$this->ket_alamat->CurrentValue = $this->ket_alamat->FormValue;
		$this->parent_nomr->CurrentValue = $this->parent_nomr->FormValue;
		$this->dokterpengirim->CurrentValue = $this->dokterpengirim->FormValue;
		$this->statusbayar->CurrentValue = $this->statusbayar->FormValue;
		$this->kirimdari->CurrentValue = $this->kirimdari->FormValue;
		$this->keluargadekat->CurrentValue = $this->keluargadekat->FormValue;
		$this->panggungjawab->CurrentValue = $this->panggungjawab->FormValue;
		$this->masukrs->CurrentValue = $this->masukrs->FormValue;
		$this->masukrs->CurrentValue = ew_UnFormatDateTime($this->masukrs->CurrentValue, 11);
		$this->noruang->CurrentValue = $this->noruang->FormValue;
		$this->tempat_tidur_id->CurrentValue = $this->tempat_tidur_id->FormValue;
		$this->nott->CurrentValue = $this->nott->FormValue;
		$this->deposit->CurrentValue = $this->deposit->FormValue;
		$this->keluarrs->CurrentValue = $this->keluarrs->FormValue;
		$this->keluarrs->CurrentValue = ew_UnFormatDateTime($this->keluarrs->CurrentValue, 0);
		$this->icd_masuk->CurrentValue = $this->icd_masuk->FormValue;
		$this->icd_keluar->CurrentValue = $this->icd_keluar->FormValue;
		$this->NIP->CurrentValue = $this->NIP->FormValue;
		$this->noruang_asal->CurrentValue = $this->noruang_asal->FormValue;
		$this->nott_asal->CurrentValue = $this->nott_asal->FormValue;
		$this->tgl_pindah->CurrentValue = $this->tgl_pindah->FormValue;
		$this->tgl_pindah->CurrentValue = ew_UnFormatDateTime($this->tgl_pindah->CurrentValue, 0);
		$this->kd_rujuk->CurrentValue = $this->kd_rujuk->FormValue;
		$this->st_bayar->CurrentValue = $this->st_bayar->FormValue;
		$this->dokter_penanggungjawab->CurrentValue = $this->dokter_penanggungjawab->FormValue;
		$this->perawat->CurrentValue = $this->perawat->FormValue;
		$this->KELASPERAWATAN_ID->CurrentValue = $this->KELASPERAWATAN_ID->FormValue;
		$this->LOS->CurrentValue = $this->LOS->FormValue;
		$this->TOT_TRF_TIND_DOKTER->CurrentValue = $this->TOT_TRF_TIND_DOKTER->FormValue;
		$this->TOT_BHP_DOKTER->CurrentValue = $this->TOT_BHP_DOKTER->FormValue;
		$this->TOT_TRF_PERAWAT->CurrentValue = $this->TOT_TRF_PERAWAT->FormValue;
		$this->TOT_BHP_PERAWAT->CurrentValue = $this->TOT_BHP_PERAWAT->FormValue;
		$this->TOT_TRF_DOKTER->CurrentValue = $this->TOT_TRF_DOKTER->FormValue;
		$this->TOT_BIAYA_RAD->CurrentValue = $this->TOT_BIAYA_RAD->FormValue;
		$this->TOT_BIAYA_CDRPOLI->CurrentValue = $this->TOT_BIAYA_CDRPOLI->FormValue;
		$this->TOT_BIAYA_LAB_IGD->CurrentValue = $this->TOT_BIAYA_LAB_IGD->FormValue;
		$this->TOT_BIAYA_OKSIGEN->CurrentValue = $this->TOT_BIAYA_OKSIGEN->FormValue;
		$this->TOTAL_BIAYA_OBAT->CurrentValue = $this->TOTAL_BIAYA_OBAT->FormValue;
		$this->LINK_SET_KELAS->CurrentValue = $this->LINK_SET_KELAS->FormValue;
		$this->biaya_obat->CurrentValue = $this->biaya_obat->FormValue;
		$this->biaya_retur_obat->CurrentValue = $this->biaya_retur_obat->FormValue;
		$this->TOT_BIAYA_GIZI->CurrentValue = $this->TOT_BIAYA_GIZI->FormValue;
		$this->TOT_BIAYA_TMO->CurrentValue = $this->TOT_BIAYA_TMO->FormValue;
		$this->TOT_BIAYA_AMBULAN->CurrentValue = $this->TOT_BIAYA_AMBULAN->FormValue;
		$this->TOT_BIAYA_FISIO->CurrentValue = $this->TOT_BIAYA_FISIO->FormValue;
		$this->TOT_BIAYA_LAINLAIN->CurrentValue = $this->TOT_BIAYA_LAINLAIN->FormValue;
		$this->jenisperawatan_id->CurrentValue = $this->jenisperawatan_id->FormValue;
		$this->status_transaksi->CurrentValue = $this->status_transaksi->FormValue;
		$this->statuskeluarranap_id->CurrentValue = $this->statuskeluarranap_id->FormValue;
		$this->TOT_BIAYA_AKOMODASI->CurrentValue = $this->TOT_BIAYA_AKOMODASI->FormValue;
		$this->TOTAL_BIAYA_ASKEP->CurrentValue = $this->TOTAL_BIAYA_ASKEP->FormValue;
		$this->TOTAL_BIAYA_SIMRS->CurrentValue = $this->TOTAL_BIAYA_SIMRS->FormValue;
		$this->TOT_PENJ_NMEDIS->CurrentValue = $this->TOT_PENJ_NMEDIS->FormValue;
		$this->LINK_MASTERDETAIL->CurrentValue = $this->LINK_MASTERDETAIL->FormValue;
		$this->NO_SKP->CurrentValue = $this->NO_SKP->FormValue;
		$this->LINK_PELAYANAN_OBAT->CurrentValue = $this->LINK_PELAYANAN_OBAT->FormValue;
		$this->TOT_TIND_RAJAL->CurrentValue = $this->TOT_TIND_RAJAL->FormValue;
		$this->TOT_TIND_IGD->CurrentValue = $this->TOT_TIND_IGD->FormValue;
		$this->tanggal_pengembalian_status->CurrentValue = $this->tanggal_pengembalian_status->FormValue;
		$this->tanggal_pengembalian_status->CurrentValue = ew_UnFormatDateTime($this->tanggal_pengembalian_status->CurrentValue, 0);
		$this->naik_kelas->CurrentValue = $this->naik_kelas->FormValue;
		$this->iuran_kelas_lama->CurrentValue = $this->iuran_kelas_lama->FormValue;
		$this->iuran_kelas_baru->CurrentValue = $this->iuran_kelas_baru->FormValue;
		$this->ketrangan_naik_kelas->CurrentValue = $this->ketrangan_naik_kelas->FormValue;
		$this->tgl_pengiriman_ad_klaim->CurrentValue = $this->tgl_pengiriman_ad_klaim->FormValue;
		$this->tgl_pengiriman_ad_klaim->CurrentValue = ew_UnFormatDateTime($this->tgl_pengiriman_ad_klaim->CurrentValue, 0);
		$this->diagnosa_keluar->CurrentValue = $this->diagnosa_keluar->FormValue;
		$this->sep_tglsep->CurrentValue = $this->sep_tglsep->FormValue;
		$this->sep_tglsep->CurrentValue = ew_UnFormatDateTime($this->sep_tglsep->CurrentValue, 0);
		$this->sep_tglrujuk->CurrentValue = $this->sep_tglrujuk->FormValue;
		$this->sep_tglrujuk->CurrentValue = ew_UnFormatDateTime($this->sep_tglrujuk->CurrentValue, 0);
		$this->sep_kodekelasrawat->CurrentValue = $this->sep_kodekelasrawat->FormValue;
		$this->sep_norujukan->CurrentValue = $this->sep_norujukan->FormValue;
		$this->sep_kodeppkasal->CurrentValue = $this->sep_kodeppkasal->FormValue;
		$this->sep_namappkasal->CurrentValue = $this->sep_namappkasal->FormValue;
		$this->sep_kodeppkpelayanan->CurrentValue = $this->sep_kodeppkpelayanan->FormValue;
		$this->sep_namappkpelayanan->CurrentValue = $this->sep_namappkpelayanan->FormValue;
		$this->t_admissioncol->CurrentValue = $this->t_admissioncol->FormValue;
		$this->sep_jenisperawatan->CurrentValue = $this->sep_jenisperawatan->FormValue;
		$this->sep_catatan->CurrentValue = $this->sep_catatan->FormValue;
		$this->sep_kodediagnosaawal->CurrentValue = $this->sep_kodediagnosaawal->FormValue;
		$this->sep_namadiagnosaawal->CurrentValue = $this->sep_namadiagnosaawal->FormValue;
		$this->sep_lakalantas->CurrentValue = $this->sep_lakalantas->FormValue;
		$this->sep_lokasilaka->CurrentValue = $this->sep_lokasilaka->FormValue;
		$this->sep_user->CurrentValue = $this->sep_user->FormValue;
		$this->sep_flag_cekpeserta->CurrentValue = $this->sep_flag_cekpeserta->FormValue;
		$this->sep_flag_generatesep->CurrentValue = $this->sep_flag_generatesep->FormValue;
		$this->sep_flag_mapingsep->CurrentValue = $this->sep_flag_mapingsep->FormValue;
		$this->sep_nik->CurrentValue = $this->sep_nik->FormValue;
		$this->sep_namapeserta->CurrentValue = $this->sep_namapeserta->FormValue;
		$this->sep_jeniskelamin->CurrentValue = $this->sep_jeniskelamin->FormValue;
		$this->sep_pisat->CurrentValue = $this->sep_pisat->FormValue;
		$this->sep_tgllahir->CurrentValue = $this->sep_tgllahir->FormValue;
		$this->sep_kodejeniskepesertaan->CurrentValue = $this->sep_kodejeniskepesertaan->FormValue;
		$this->sep_namajeniskepesertaan->CurrentValue = $this->sep_namajeniskepesertaan->FormValue;
		$this->sep_kodepolitujuan->CurrentValue = $this->sep_kodepolitujuan->FormValue;
		$this->sep_namapolitujuan->CurrentValue = $this->sep_namapolitujuan->FormValue;
		$this->ket_jeniskelamin->CurrentValue = $this->ket_jeniskelamin->FormValue;
		$this->sep_nokabpjs->CurrentValue = $this->sep_nokabpjs->FormValue;
		$this->counter_cetak_sep->CurrentValue = $this->counter_cetak_sep->FormValue;
		$this->sep_petugas_hapus_sep->CurrentValue = $this->sep_petugas_hapus_sep->FormValue;
		$this->sep_petugas_set_tgl_pulang->CurrentValue = $this->sep_petugas_set_tgl_pulang->FormValue;
		$this->sep_jam_generate_sep->CurrentValue = $this->sep_jam_generate_sep->FormValue;
		$this->sep_jam_generate_sep->CurrentValue = ew_UnFormatDateTime($this->sep_jam_generate_sep->CurrentValue, 0);
		$this->sep_status_peserta->CurrentValue = $this->sep_status_peserta->FormValue;
		$this->sep_umur_pasien_sekarang->CurrentValue = $this->sep_umur_pasien_sekarang->FormValue;
		$this->ket_title->CurrentValue = $this->ket_title->FormValue;
		$this->status_daftar_ranap->CurrentValue = $this->status_daftar_ranap->FormValue;
		$this->IBS_SETMARKING->CurrentValue = $this->IBS_SETMARKING->FormValue;
		$this->IBS_PATOLOGI->CurrentValue = $this->IBS_PATOLOGI->FormValue;
		$this->IBS_JENISANESTESI->CurrentValue = $this->IBS_JENISANESTESI->FormValue;
		$this->IBS_NO_OK->CurrentValue = $this->IBS_NO_OK->FormValue;
		$this->IBS_ASISSTEN->CurrentValue = $this->IBS_ASISSTEN->FormValue;
		$this->IBS_JAM_ELEFTIF->CurrentValue = $this->IBS_JAM_ELEFTIF->FormValue;
		$this->IBS_JAM_ELEFTIF->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_ELEFTIF->CurrentValue, 0);
		$this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue = $this->IBS_JAM_ELEKTIF_SELESAI->FormValue;
		$this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue, 0);
		$this->IBS_JAM_CYTO->CurrentValue = $this->IBS_JAM_CYTO->FormValue;
		$this->IBS_JAM_CYTO->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_CYTO->CurrentValue, 0);
		$this->IBS_JAM_CYTO_SELESAI->CurrentValue = $this->IBS_JAM_CYTO_SELESAI->FormValue;
		$this->IBS_JAM_CYTO_SELESAI->CurrentValue = ew_UnFormatDateTime($this->IBS_JAM_CYTO_SELESAI->CurrentValue, 0);
		$this->IBS_TGL_DFTR_OP->CurrentValue = $this->IBS_TGL_DFTR_OP->FormValue;
		$this->IBS_TGL_DFTR_OP->CurrentValue = ew_UnFormatDateTime($this->IBS_TGL_DFTR_OP->CurrentValue, 0);
		$this->IBS_TGL_OP->CurrentValue = $this->IBS_TGL_OP->FormValue;
		$this->IBS_TGL_OP->CurrentValue = ew_UnFormatDateTime($this->IBS_TGL_OP->CurrentValue, 0);
		$this->grup_ruang_id->CurrentValue = $this->grup_ruang_id->FormValue;
		$this->status_order_ibs->CurrentValue = $this->status_order_ibs->FormValue;
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
		$this->ket_tgllahir->setDbValue($rs->fields('ket_tgllahir'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->parent_nomr->setDbValue($rs->fields('parent_nomr'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->nott->setDbValue($rs->fields('nott'));
		$this->deposit->setDbValue($rs->fields('deposit'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->icd_masuk->setDbValue($rs->fields('icd_masuk'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->noruang_asal->setDbValue($rs->fields('noruang_asal'));
		$this->nott_asal->setDbValue($rs->fields('nott_asal'));
		$this->tgl_pindah->setDbValue($rs->fields('tgl_pindah'));
		$this->kd_rujuk->setDbValue($rs->fields('kd_rujuk'));
		$this->st_bayar->setDbValue($rs->fields('st_bayar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->perawat->setDbValue($rs->fields('perawat'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->LOS->setDbValue($rs->fields('LOS'));
		$this->TOT_TRF_TIND_DOKTER->setDbValue($rs->fields('TOT_TRF_TIND_DOKTER'));
		$this->TOT_BHP_DOKTER->setDbValue($rs->fields('TOT_BHP_DOKTER'));
		$this->TOT_TRF_PERAWAT->setDbValue($rs->fields('TOT_TRF_PERAWAT'));
		$this->TOT_BHP_PERAWAT->setDbValue($rs->fields('TOT_BHP_PERAWAT'));
		$this->TOT_TRF_DOKTER->setDbValue($rs->fields('TOT_TRF_DOKTER'));
		$this->TOT_BIAYA_RAD->setDbValue($rs->fields('TOT_BIAYA_RAD'));
		$this->TOT_BIAYA_CDRPOLI->setDbValue($rs->fields('TOT_BIAYA_CDRPOLI'));
		$this->TOT_BIAYA_LAB_IGD->setDbValue($rs->fields('TOT_BIAYA_LAB_IGD'));
		$this->TOT_BIAYA_OKSIGEN->setDbValue($rs->fields('TOT_BIAYA_OKSIGEN'));
		$this->TOTAL_BIAYA_OBAT->setDbValue($rs->fields('TOTAL_BIAYA_OBAT'));
		$this->LINK_SET_KELAS->setDbValue($rs->fields('LINK_SET_KELAS'));
		$this->biaya_obat->setDbValue($rs->fields('biaya_obat'));
		$this->biaya_retur_obat->setDbValue($rs->fields('biaya_retur_obat'));
		$this->TOT_BIAYA_GIZI->setDbValue($rs->fields('TOT_BIAYA_GIZI'));
		$this->TOT_BIAYA_TMO->setDbValue($rs->fields('TOT_BIAYA_TMO'));
		$this->TOT_BIAYA_AMBULAN->setDbValue($rs->fields('TOT_BIAYA_AMBULAN'));
		$this->TOT_BIAYA_FISIO->setDbValue($rs->fields('TOT_BIAYA_FISIO'));
		$this->TOT_BIAYA_LAINLAIN->setDbValue($rs->fields('TOT_BIAYA_LAINLAIN'));
		$this->jenisperawatan_id->setDbValue($rs->fields('jenisperawatan_id'));
		$this->status_transaksi->setDbValue($rs->fields('status_transaksi'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
		$this->TOT_BIAYA_AKOMODASI->setDbValue($rs->fields('TOT_BIAYA_AKOMODASI'));
		$this->TOTAL_BIAYA_ASKEP->setDbValue($rs->fields('TOTAL_BIAYA_ASKEP'));
		$this->TOTAL_BIAYA_SIMRS->setDbValue($rs->fields('TOTAL_BIAYA_SIMRS'));
		$this->TOT_PENJ_NMEDIS->setDbValue($rs->fields('TOT_PENJ_NMEDIS'));
		$this->LINK_MASTERDETAIL->setDbValue($rs->fields('LINK_MASTERDETAIL'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->LINK_PELAYANAN_OBAT->setDbValue($rs->fields('LINK_PELAYANAN_OBAT'));
		$this->TOT_TIND_RAJAL->setDbValue($rs->fields('TOT_TIND_RAJAL'));
		$this->TOT_TIND_IGD->setDbValue($rs->fields('TOT_TIND_IGD'));
		$this->tanggal_pengembalian_status->setDbValue($rs->fields('tanggal_pengembalian_status'));
		$this->naik_kelas->setDbValue($rs->fields('naik_kelas'));
		$this->iuran_kelas_lama->setDbValue($rs->fields('iuran_kelas_lama'));
		$this->iuran_kelas_baru->setDbValue($rs->fields('iuran_kelas_baru'));
		$this->ketrangan_naik_kelas->setDbValue($rs->fields('ketrangan_naik_kelas'));
		$this->tgl_pengiriman_ad_klaim->setDbValue($rs->fields('tgl_pengiriman_ad_klaim'));
		$this->diagnosa_keluar->setDbValue($rs->fields('diagnosa_keluar'));
		$this->sep_tglsep->setDbValue($rs->fields('sep_tglsep'));
		$this->sep_tglrujuk->setDbValue($rs->fields('sep_tglrujuk'));
		$this->sep_kodekelasrawat->setDbValue($rs->fields('sep_kodekelasrawat'));
		$this->sep_norujukan->setDbValue($rs->fields('sep_norujukan'));
		$this->sep_kodeppkasal->setDbValue($rs->fields('sep_kodeppkasal'));
		$this->sep_namappkasal->setDbValue($rs->fields('sep_namappkasal'));
		$this->sep_kodeppkpelayanan->setDbValue($rs->fields('sep_kodeppkpelayanan'));
		$this->sep_namappkpelayanan->setDbValue($rs->fields('sep_namappkpelayanan'));
		$this->t_admissioncol->setDbValue($rs->fields('t_admissioncol'));
		$this->sep_jenisperawatan->setDbValue($rs->fields('sep_jenisperawatan'));
		$this->sep_catatan->setDbValue($rs->fields('sep_catatan'));
		$this->sep_kodediagnosaawal->setDbValue($rs->fields('sep_kodediagnosaawal'));
		$this->sep_namadiagnosaawal->setDbValue($rs->fields('sep_namadiagnosaawal'));
		$this->sep_lakalantas->setDbValue($rs->fields('sep_lakalantas'));
		$this->sep_lokasilaka->setDbValue($rs->fields('sep_lokasilaka'));
		$this->sep_user->setDbValue($rs->fields('sep_user'));
		$this->sep_flag_cekpeserta->setDbValue($rs->fields('sep_flag_cekpeserta'));
		$this->sep_flag_generatesep->setDbValue($rs->fields('sep_flag_generatesep'));
		$this->sep_flag_mapingsep->setDbValue($rs->fields('sep_flag_mapingsep'));
		$this->sep_nik->setDbValue($rs->fields('sep_nik'));
		$this->sep_namapeserta->setDbValue($rs->fields('sep_namapeserta'));
		$this->sep_jeniskelamin->setDbValue($rs->fields('sep_jeniskelamin'));
		$this->sep_pisat->setDbValue($rs->fields('sep_pisat'));
		$this->sep_tgllahir->setDbValue($rs->fields('sep_tgllahir'));
		$this->sep_kodejeniskepesertaan->setDbValue($rs->fields('sep_kodejeniskepesertaan'));
		$this->sep_namajeniskepesertaan->setDbValue($rs->fields('sep_namajeniskepesertaan'));
		$this->sep_kodepolitujuan->setDbValue($rs->fields('sep_kodepolitujuan'));
		$this->sep_namapolitujuan->setDbValue($rs->fields('sep_namapolitujuan'));
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->sep_nokabpjs->setDbValue($rs->fields('sep_nokabpjs'));
		$this->counter_cetak_sep->setDbValue($rs->fields('counter_cetak_sep'));
		$this->sep_petugas_hapus_sep->setDbValue($rs->fields('sep_petugas_hapus_sep'));
		$this->sep_petugas_set_tgl_pulang->setDbValue($rs->fields('sep_petugas_set_tgl_pulang'));
		$this->sep_jam_generate_sep->setDbValue($rs->fields('sep_jam_generate_sep'));
		$this->sep_status_peserta->setDbValue($rs->fields('sep_status_peserta'));
		$this->sep_umur_pasien_sekarang->setDbValue($rs->fields('sep_umur_pasien_sekarang'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->status_daftar_ranap->setDbValue($rs->fields('status_daftar_ranap'));
		$this->IBS_SETMARKING->setDbValue($rs->fields('IBS_SETMARKING'));
		$this->IBS_PATOLOGI->setDbValue($rs->fields('IBS_PATOLOGI'));
		$this->IBS_JENISANESTESI->setDbValue($rs->fields('IBS_JENISANESTESI'));
		$this->IBS_NO_OK->setDbValue($rs->fields('IBS_NO_OK'));
		$this->IBS_ASISSTEN->setDbValue($rs->fields('IBS_ASISSTEN'));
		$this->IBS_JAM_ELEFTIF->setDbValue($rs->fields('IBS_JAM_ELEFTIF'));
		$this->IBS_JAM_ELEKTIF_SELESAI->setDbValue($rs->fields('IBS_JAM_ELEKTIF_SELESAI'));
		$this->IBS_JAM_CYTO->setDbValue($rs->fields('IBS_JAM_CYTO'));
		$this->IBS_JAM_CYTO_SELESAI->setDbValue($rs->fields('IBS_JAM_CYTO_SELESAI'));
		$this->IBS_TGL_DFTR_OP->setDbValue($rs->fields('IBS_TGL_DFTR_OP'));
		$this->IBS_TGL_OP->setDbValue($rs->fields('IBS_TGL_OP'));
		$this->grup_ruang_id->setDbValue($rs->fields('grup_ruang_id'));
		$this->status_order_ibs->setDbValue($rs->fields('status_order_ibs'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id_admission->DbValue = $row['id_admission'];
		$this->nomr->DbValue = $row['nomr'];
		$this->ket_nama->DbValue = $row['ket_nama'];
		$this->ket_tgllahir->DbValue = $row['ket_tgllahir'];
		$this->ket_alamat->DbValue = $row['ket_alamat'];
		$this->parent_nomr->DbValue = $row['parent_nomr'];
		$this->dokterpengirim->DbValue = $row['dokterpengirim'];
		$this->statusbayar->DbValue = $row['statusbayar'];
		$this->kirimdari->DbValue = $row['kirimdari'];
		$this->keluargadekat->DbValue = $row['keluargadekat'];
		$this->panggungjawab->DbValue = $row['panggungjawab'];
		$this->masukrs->DbValue = $row['masukrs'];
		$this->noruang->DbValue = $row['noruang'];
		$this->tempat_tidur_id->DbValue = $row['tempat_tidur_id'];
		$this->nott->DbValue = $row['nott'];
		$this->deposit->DbValue = $row['deposit'];
		$this->keluarrs->DbValue = $row['keluarrs'];
		$this->icd_masuk->DbValue = $row['icd_masuk'];
		$this->icd_keluar->DbValue = $row['icd_keluar'];
		$this->NIP->DbValue = $row['NIP'];
		$this->noruang_asal->DbValue = $row['noruang_asal'];
		$this->nott_asal->DbValue = $row['nott_asal'];
		$this->tgl_pindah->DbValue = $row['tgl_pindah'];
		$this->kd_rujuk->DbValue = $row['kd_rujuk'];
		$this->st_bayar->DbValue = $row['st_bayar'];
		$this->dokter_penanggungjawab->DbValue = $row['dokter_penanggungjawab'];
		$this->perawat->DbValue = $row['perawat'];
		$this->KELASPERAWATAN_ID->DbValue = $row['KELASPERAWATAN_ID'];
		$this->LOS->DbValue = $row['LOS'];
		$this->TOT_TRF_TIND_DOKTER->DbValue = $row['TOT_TRF_TIND_DOKTER'];
		$this->TOT_BHP_DOKTER->DbValue = $row['TOT_BHP_DOKTER'];
		$this->TOT_TRF_PERAWAT->DbValue = $row['TOT_TRF_PERAWAT'];
		$this->TOT_BHP_PERAWAT->DbValue = $row['TOT_BHP_PERAWAT'];
		$this->TOT_TRF_DOKTER->DbValue = $row['TOT_TRF_DOKTER'];
		$this->TOT_BIAYA_RAD->DbValue = $row['TOT_BIAYA_RAD'];
		$this->TOT_BIAYA_CDRPOLI->DbValue = $row['TOT_BIAYA_CDRPOLI'];
		$this->TOT_BIAYA_LAB_IGD->DbValue = $row['TOT_BIAYA_LAB_IGD'];
		$this->TOT_BIAYA_OKSIGEN->DbValue = $row['TOT_BIAYA_OKSIGEN'];
		$this->TOTAL_BIAYA_OBAT->DbValue = $row['TOTAL_BIAYA_OBAT'];
		$this->LINK_SET_KELAS->DbValue = $row['LINK_SET_KELAS'];
		$this->biaya_obat->DbValue = $row['biaya_obat'];
		$this->biaya_retur_obat->DbValue = $row['biaya_retur_obat'];
		$this->TOT_BIAYA_GIZI->DbValue = $row['TOT_BIAYA_GIZI'];
		$this->TOT_BIAYA_TMO->DbValue = $row['TOT_BIAYA_TMO'];
		$this->TOT_BIAYA_AMBULAN->DbValue = $row['TOT_BIAYA_AMBULAN'];
		$this->TOT_BIAYA_FISIO->DbValue = $row['TOT_BIAYA_FISIO'];
		$this->TOT_BIAYA_LAINLAIN->DbValue = $row['TOT_BIAYA_LAINLAIN'];
		$this->jenisperawatan_id->DbValue = $row['jenisperawatan_id'];
		$this->status_transaksi->DbValue = $row['status_transaksi'];
		$this->statuskeluarranap_id->DbValue = $row['statuskeluarranap_id'];
		$this->TOT_BIAYA_AKOMODASI->DbValue = $row['TOT_BIAYA_AKOMODASI'];
		$this->TOTAL_BIAYA_ASKEP->DbValue = $row['TOTAL_BIAYA_ASKEP'];
		$this->TOTAL_BIAYA_SIMRS->DbValue = $row['TOTAL_BIAYA_SIMRS'];
		$this->TOT_PENJ_NMEDIS->DbValue = $row['TOT_PENJ_NMEDIS'];
		$this->LINK_MASTERDETAIL->DbValue = $row['LINK_MASTERDETAIL'];
		$this->NO_SKP->DbValue = $row['NO_SKP'];
		$this->LINK_PELAYANAN_OBAT->DbValue = $row['LINK_PELAYANAN_OBAT'];
		$this->TOT_TIND_RAJAL->DbValue = $row['TOT_TIND_RAJAL'];
		$this->TOT_TIND_IGD->DbValue = $row['TOT_TIND_IGD'];
		$this->tanggal_pengembalian_status->DbValue = $row['tanggal_pengembalian_status'];
		$this->naik_kelas->DbValue = $row['naik_kelas'];
		$this->iuran_kelas_lama->DbValue = $row['iuran_kelas_lama'];
		$this->iuran_kelas_baru->DbValue = $row['iuran_kelas_baru'];
		$this->ketrangan_naik_kelas->DbValue = $row['ketrangan_naik_kelas'];
		$this->tgl_pengiriman_ad_klaim->DbValue = $row['tgl_pengiriman_ad_klaim'];
		$this->diagnosa_keluar->DbValue = $row['diagnosa_keluar'];
		$this->sep_tglsep->DbValue = $row['sep_tglsep'];
		$this->sep_tglrujuk->DbValue = $row['sep_tglrujuk'];
		$this->sep_kodekelasrawat->DbValue = $row['sep_kodekelasrawat'];
		$this->sep_norujukan->DbValue = $row['sep_norujukan'];
		$this->sep_kodeppkasal->DbValue = $row['sep_kodeppkasal'];
		$this->sep_namappkasal->DbValue = $row['sep_namappkasal'];
		$this->sep_kodeppkpelayanan->DbValue = $row['sep_kodeppkpelayanan'];
		$this->sep_namappkpelayanan->DbValue = $row['sep_namappkpelayanan'];
		$this->t_admissioncol->DbValue = $row['t_admissioncol'];
		$this->sep_jenisperawatan->DbValue = $row['sep_jenisperawatan'];
		$this->sep_catatan->DbValue = $row['sep_catatan'];
		$this->sep_kodediagnosaawal->DbValue = $row['sep_kodediagnosaawal'];
		$this->sep_namadiagnosaawal->DbValue = $row['sep_namadiagnosaawal'];
		$this->sep_lakalantas->DbValue = $row['sep_lakalantas'];
		$this->sep_lokasilaka->DbValue = $row['sep_lokasilaka'];
		$this->sep_user->DbValue = $row['sep_user'];
		$this->sep_flag_cekpeserta->DbValue = $row['sep_flag_cekpeserta'];
		$this->sep_flag_generatesep->DbValue = $row['sep_flag_generatesep'];
		$this->sep_flag_mapingsep->DbValue = $row['sep_flag_mapingsep'];
		$this->sep_nik->DbValue = $row['sep_nik'];
		$this->sep_namapeserta->DbValue = $row['sep_namapeserta'];
		$this->sep_jeniskelamin->DbValue = $row['sep_jeniskelamin'];
		$this->sep_pisat->DbValue = $row['sep_pisat'];
		$this->sep_tgllahir->DbValue = $row['sep_tgllahir'];
		$this->sep_kodejeniskepesertaan->DbValue = $row['sep_kodejeniskepesertaan'];
		$this->sep_namajeniskepesertaan->DbValue = $row['sep_namajeniskepesertaan'];
		$this->sep_kodepolitujuan->DbValue = $row['sep_kodepolitujuan'];
		$this->sep_namapolitujuan->DbValue = $row['sep_namapolitujuan'];
		$this->ket_jeniskelamin->DbValue = $row['ket_jeniskelamin'];
		$this->sep_nokabpjs->DbValue = $row['sep_nokabpjs'];
		$this->counter_cetak_sep->DbValue = $row['counter_cetak_sep'];
		$this->sep_petugas_hapus_sep->DbValue = $row['sep_petugas_hapus_sep'];
		$this->sep_petugas_set_tgl_pulang->DbValue = $row['sep_petugas_set_tgl_pulang'];
		$this->sep_jam_generate_sep->DbValue = $row['sep_jam_generate_sep'];
		$this->sep_status_peserta->DbValue = $row['sep_status_peserta'];
		$this->sep_umur_pasien_sekarang->DbValue = $row['sep_umur_pasien_sekarang'];
		$this->ket_title->DbValue = $row['ket_title'];
		$this->status_daftar_ranap->DbValue = $row['status_daftar_ranap'];
		$this->IBS_SETMARKING->DbValue = $row['IBS_SETMARKING'];
		$this->IBS_PATOLOGI->DbValue = $row['IBS_PATOLOGI'];
		$this->IBS_JENISANESTESI->DbValue = $row['IBS_JENISANESTESI'];
		$this->IBS_NO_OK->DbValue = $row['IBS_NO_OK'];
		$this->IBS_ASISSTEN->DbValue = $row['IBS_ASISSTEN'];
		$this->IBS_JAM_ELEFTIF->DbValue = $row['IBS_JAM_ELEFTIF'];
		$this->IBS_JAM_ELEKTIF_SELESAI->DbValue = $row['IBS_JAM_ELEKTIF_SELESAI'];
		$this->IBS_JAM_CYTO->DbValue = $row['IBS_JAM_CYTO'];
		$this->IBS_JAM_CYTO_SELESAI->DbValue = $row['IBS_JAM_CYTO_SELESAI'];
		$this->IBS_TGL_DFTR_OP->DbValue = $row['IBS_TGL_DFTR_OP'];
		$this->IBS_TGL_OP->DbValue = $row['IBS_TGL_OP'];
		$this->grup_ruang_id->DbValue = $row['grup_ruang_id'];
		$this->status_order_ibs->DbValue = $row['status_order_ibs'];
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
		// Convert decimal values if posted back

		if ($this->TOT_TRF_TIND_DOKTER->FormValue == $this->TOT_TRF_TIND_DOKTER->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_TRF_TIND_DOKTER->CurrentValue)))
			$this->TOT_TRF_TIND_DOKTER->CurrentValue = ew_StrToFloat($this->TOT_TRF_TIND_DOKTER->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BHP_DOKTER->FormValue == $this->TOT_BHP_DOKTER->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BHP_DOKTER->CurrentValue)))
			$this->TOT_BHP_DOKTER->CurrentValue = ew_StrToFloat($this->TOT_BHP_DOKTER->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_TRF_PERAWAT->FormValue == $this->TOT_TRF_PERAWAT->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_TRF_PERAWAT->CurrentValue)))
			$this->TOT_TRF_PERAWAT->CurrentValue = ew_StrToFloat($this->TOT_TRF_PERAWAT->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BHP_PERAWAT->FormValue == $this->TOT_BHP_PERAWAT->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BHP_PERAWAT->CurrentValue)))
			$this->TOT_BHP_PERAWAT->CurrentValue = ew_StrToFloat($this->TOT_BHP_PERAWAT->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_TRF_DOKTER->FormValue == $this->TOT_TRF_DOKTER->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_TRF_DOKTER->CurrentValue)))
			$this->TOT_TRF_DOKTER->CurrentValue = ew_StrToFloat($this->TOT_TRF_DOKTER->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_RAD->FormValue == $this->TOT_BIAYA_RAD->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_RAD->CurrentValue)))
			$this->TOT_BIAYA_RAD->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_RAD->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_CDRPOLI->FormValue == $this->TOT_BIAYA_CDRPOLI->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_CDRPOLI->CurrentValue)))
			$this->TOT_BIAYA_CDRPOLI->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_CDRPOLI->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_LAB_IGD->FormValue == $this->TOT_BIAYA_LAB_IGD->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_LAB_IGD->CurrentValue)))
			$this->TOT_BIAYA_LAB_IGD->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_LAB_IGD->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_OKSIGEN->FormValue == $this->TOT_BIAYA_OKSIGEN->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_OKSIGEN->CurrentValue)))
			$this->TOT_BIAYA_OKSIGEN->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_OKSIGEN->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOTAL_BIAYA_OBAT->FormValue == $this->TOTAL_BIAYA_OBAT->CurrentValue && is_numeric(ew_StrToFloat($this->TOTAL_BIAYA_OBAT->CurrentValue)))
			$this->TOTAL_BIAYA_OBAT->CurrentValue = ew_StrToFloat($this->TOTAL_BIAYA_OBAT->CurrentValue);

		// Convert decimal values if posted back
		if ($this->biaya_obat->FormValue == $this->biaya_obat->CurrentValue && is_numeric(ew_StrToFloat($this->biaya_obat->CurrentValue)))
			$this->biaya_obat->CurrentValue = ew_StrToFloat($this->biaya_obat->CurrentValue);

		// Convert decimal values if posted back
		if ($this->biaya_retur_obat->FormValue == $this->biaya_retur_obat->CurrentValue && is_numeric(ew_StrToFloat($this->biaya_retur_obat->CurrentValue)))
			$this->biaya_retur_obat->CurrentValue = ew_StrToFloat($this->biaya_retur_obat->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_GIZI->FormValue == $this->TOT_BIAYA_GIZI->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_GIZI->CurrentValue)))
			$this->TOT_BIAYA_GIZI->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_GIZI->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_TMO->FormValue == $this->TOT_BIAYA_TMO->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_TMO->CurrentValue)))
			$this->TOT_BIAYA_TMO->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_TMO->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_AMBULAN->FormValue == $this->TOT_BIAYA_AMBULAN->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_AMBULAN->CurrentValue)))
			$this->TOT_BIAYA_AMBULAN->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_AMBULAN->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_FISIO->FormValue == $this->TOT_BIAYA_FISIO->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_FISIO->CurrentValue)))
			$this->TOT_BIAYA_FISIO->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_FISIO->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_LAINLAIN->FormValue == $this->TOT_BIAYA_LAINLAIN->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_LAINLAIN->CurrentValue)))
			$this->TOT_BIAYA_LAINLAIN->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_LAINLAIN->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_BIAYA_AKOMODASI->FormValue == $this->TOT_BIAYA_AKOMODASI->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_BIAYA_AKOMODASI->CurrentValue)))
			$this->TOT_BIAYA_AKOMODASI->CurrentValue = ew_StrToFloat($this->TOT_BIAYA_AKOMODASI->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOTAL_BIAYA_ASKEP->FormValue == $this->TOTAL_BIAYA_ASKEP->CurrentValue && is_numeric(ew_StrToFloat($this->TOTAL_BIAYA_ASKEP->CurrentValue)))
			$this->TOTAL_BIAYA_ASKEP->CurrentValue = ew_StrToFloat($this->TOTAL_BIAYA_ASKEP->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOTAL_BIAYA_SIMRS->FormValue == $this->TOTAL_BIAYA_SIMRS->CurrentValue && is_numeric(ew_StrToFloat($this->TOTAL_BIAYA_SIMRS->CurrentValue)))
			$this->TOTAL_BIAYA_SIMRS->CurrentValue = ew_StrToFloat($this->TOTAL_BIAYA_SIMRS->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_PENJ_NMEDIS->FormValue == $this->TOT_PENJ_NMEDIS->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_PENJ_NMEDIS->CurrentValue)))
			$this->TOT_PENJ_NMEDIS->CurrentValue = ew_StrToFloat($this->TOT_PENJ_NMEDIS->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_TIND_RAJAL->FormValue == $this->TOT_TIND_RAJAL->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_TIND_RAJAL->CurrentValue)))
			$this->TOT_TIND_RAJAL->CurrentValue = ew_StrToFloat($this->TOT_TIND_RAJAL->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TOT_TIND_IGD->FormValue == $this->TOT_TIND_IGD->CurrentValue && is_numeric(ew_StrToFloat($this->TOT_TIND_IGD->CurrentValue)))
			$this->TOT_TIND_IGD->CurrentValue = ew_StrToFloat($this->TOT_TIND_IGD->CurrentValue);

		// Convert decimal values if posted back
		if ($this->iuran_kelas_lama->FormValue == $this->iuran_kelas_lama->CurrentValue && is_numeric(ew_StrToFloat($this->iuran_kelas_lama->CurrentValue)))
			$this->iuran_kelas_lama->CurrentValue = ew_StrToFloat($this->iuran_kelas_lama->CurrentValue);

		// Convert decimal values if posted back
		if ($this->iuran_kelas_baru->FormValue == $this->iuran_kelas_baru->CurrentValue && is_numeric(ew_StrToFloat($this->iuran_kelas_baru->CurrentValue)))
			$this->iuran_kelas_baru->CurrentValue = ew_StrToFloat($this->iuran_kelas_baru->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id_admission
		// nomr
		// ket_nama
		// ket_tgllahir
		// ket_alamat
		// parent_nomr
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// nott
		// deposit
		// keluarrs
		// icd_masuk
		// icd_keluar
		// NIP
		// noruang_asal
		// nott_asal
		// tgl_pindah
		// kd_rujuk
		// st_bayar
		// dokter_penanggungjawab
		// perawat
		// KELASPERAWATAN_ID
		// LOS
		// TOT_TRF_TIND_DOKTER
		// TOT_BHP_DOKTER
		// TOT_TRF_PERAWAT
		// TOT_BHP_PERAWAT
		// TOT_TRF_DOKTER
		// TOT_BIAYA_RAD
		// TOT_BIAYA_CDRPOLI
		// TOT_BIAYA_LAB_IGD
		// TOT_BIAYA_OKSIGEN
		// TOTAL_BIAYA_OBAT
		// LINK_SET_KELAS
		// biaya_obat
		// biaya_retur_obat
		// TOT_BIAYA_GIZI
		// TOT_BIAYA_TMO
		// TOT_BIAYA_AMBULAN
		// TOT_BIAYA_FISIO
		// TOT_BIAYA_LAINLAIN
		// jenisperawatan_id
		// status_transaksi
		// statuskeluarranap_id
		// TOT_BIAYA_AKOMODASI
		// TOTAL_BIAYA_ASKEP
		// TOTAL_BIAYA_SIMRS
		// TOT_PENJ_NMEDIS
		// LINK_MASTERDETAIL
		// NO_SKP
		// LINK_PELAYANAN_OBAT
		// TOT_TIND_RAJAL
		// TOT_TIND_IGD
		// tanggal_pengembalian_status
		// naik_kelas
		// iuran_kelas_lama
		// iuran_kelas_baru
		// ketrangan_naik_kelas
		// tgl_pengiriman_ad_klaim
		// diagnosa_keluar
		// sep_tglsep
		// sep_tglrujuk
		// sep_kodekelasrawat
		// sep_norujukan
		// sep_kodeppkasal
		// sep_namappkasal
		// sep_kodeppkpelayanan
		// sep_namappkpelayanan
		// t_admissioncol
		// sep_jenisperawatan
		// sep_catatan
		// sep_kodediagnosaawal
		// sep_namadiagnosaawal
		// sep_lakalantas
		// sep_lokasilaka
		// sep_user
		// sep_flag_cekpeserta
		// sep_flag_generatesep
		// sep_flag_mapingsep
		// sep_nik
		// sep_namapeserta
		// sep_jeniskelamin
		// sep_pisat
		// sep_tgllahir
		// sep_kodejeniskepesertaan
		// sep_namajeniskepesertaan
		// sep_kodepolitujuan
		// sep_namapolitujuan
		// ket_jeniskelamin
		// sep_nokabpjs
		// counter_cetak_sep
		// sep_petugas_hapus_sep
		// sep_petugas_set_tgl_pulang
		// sep_jam_generate_sep
		// sep_status_peserta
		// sep_umur_pasien_sekarang
		// ket_title
		// status_daftar_ranap
		// IBS_SETMARKING
		// IBS_PATOLOGI
		// IBS_JENISANESTESI
		// IBS_NO_OK
		// IBS_ASISSTEN
		// IBS_JAM_ELEFTIF
		// IBS_JAM_ELEKTIF_SELESAI
		// IBS_JAM_CYTO
		// IBS_JAM_CYTO_SELESAI
		// IBS_TGL_DFTR_OP
		// IBS_TGL_OP
		// grup_ruang_id
		// status_order_ibs

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

		// ket_tgllahir
		$this->ket_tgllahir->ViewValue = $this->ket_tgllahir->CurrentValue;
		$this->ket_tgllahir->ViewValue = ew_FormatDateTime($this->ket_tgllahir->ViewValue, 0);
		$this->ket_tgllahir->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

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
		$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
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
		$lookuptblfilter = "isnull(`KETERANGAN`)";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

		// deposit
		$this->deposit->ViewValue = $this->deposit->CurrentValue;
		$this->deposit->ViewCustomAttributes = "";

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

		// noruang_asal
		$this->noruang_asal->ViewValue = $this->noruang_asal->CurrentValue;
		$this->noruang_asal->ViewCustomAttributes = "";

		// nott_asal
		$this->nott_asal->ViewValue = $this->nott_asal->CurrentValue;
		$this->nott_asal->ViewCustomAttributes = "";

		// tgl_pindah
		$this->tgl_pindah->ViewValue = $this->tgl_pindah->CurrentValue;
		$this->tgl_pindah->ViewValue = ew_FormatDateTime($this->tgl_pindah->ViewValue, 0);
		$this->tgl_pindah->ViewCustomAttributes = "";

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

		// LOS
		$this->LOS->ViewValue = $this->LOS->CurrentValue;
		$this->LOS->ViewCustomAttributes = "";

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER->ViewValue = $this->TOT_TRF_TIND_DOKTER->CurrentValue;
		$this->TOT_TRF_TIND_DOKTER->ViewCustomAttributes = "";

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER->ViewValue = $this->TOT_BHP_DOKTER->CurrentValue;
		$this->TOT_BHP_DOKTER->ViewCustomAttributes = "";

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT->ViewValue = $this->TOT_TRF_PERAWAT->CurrentValue;
		$this->TOT_TRF_PERAWAT->ViewCustomAttributes = "";

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT->ViewValue = $this->TOT_BHP_PERAWAT->CurrentValue;
		$this->TOT_BHP_PERAWAT->ViewCustomAttributes = "";

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER->ViewValue = $this->TOT_TRF_DOKTER->CurrentValue;
		$this->TOT_TRF_DOKTER->ViewCustomAttributes = "";

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD->ViewValue = $this->TOT_BIAYA_RAD->CurrentValue;
		$this->TOT_BIAYA_RAD->ViewCustomAttributes = "";

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI->ViewValue = $this->TOT_BIAYA_CDRPOLI->CurrentValue;
		$this->TOT_BIAYA_CDRPOLI->ViewCustomAttributes = "";

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD->ViewValue = $this->TOT_BIAYA_LAB_IGD->CurrentValue;
		$this->TOT_BIAYA_LAB_IGD->ViewCustomAttributes = "";

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN->ViewValue = $this->TOT_BIAYA_OKSIGEN->CurrentValue;
		$this->TOT_BIAYA_OKSIGEN->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->ViewValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->ViewCustomAttributes = "";

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS->ViewValue = $this->LINK_SET_KELAS->CurrentValue;
		$this->LINK_SET_KELAS->ViewCustomAttributes = "";

		// biaya_obat
		$this->biaya_obat->ViewValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->ViewCustomAttributes = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->ViewValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->ViewCustomAttributes = "";

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI->ViewValue = $this->TOT_BIAYA_GIZI->CurrentValue;
		$this->TOT_BIAYA_GIZI->ViewCustomAttributes = "";

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO->ViewValue = $this->TOT_BIAYA_TMO->CurrentValue;
		$this->TOT_BIAYA_TMO->ViewCustomAttributes = "";

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN->ViewValue = $this->TOT_BIAYA_AMBULAN->CurrentValue;
		$this->TOT_BIAYA_AMBULAN->ViewCustomAttributes = "";

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO->ViewValue = $this->TOT_BIAYA_FISIO->CurrentValue;
		$this->TOT_BIAYA_FISIO->ViewCustomAttributes = "";

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN->ViewValue = $this->TOT_BIAYA_LAINLAIN->CurrentValue;
		$this->TOT_BIAYA_LAINLAIN->ViewCustomAttributes = "";

		// jenisperawatan_id
		$this->jenisperawatan_id->ViewValue = $this->jenisperawatan_id->CurrentValue;
		$this->jenisperawatan_id->ViewCustomAttributes = "";

		// status_transaksi
		$this->status_transaksi->ViewValue = $this->status_transaksi->CurrentValue;
		$this->status_transaksi->ViewCustomAttributes = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI->ViewValue = $this->TOT_BIAYA_AKOMODASI->CurrentValue;
		$this->TOT_BIAYA_AKOMODASI->ViewCustomAttributes = "";

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP->ViewValue = $this->TOTAL_BIAYA_ASKEP->CurrentValue;
		$this->TOTAL_BIAYA_ASKEP->ViewCustomAttributes = "";

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS->ViewValue = $this->TOTAL_BIAYA_SIMRS->CurrentValue;
		$this->TOTAL_BIAYA_SIMRS->ViewCustomAttributes = "";

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS->ViewValue = $this->TOT_PENJ_NMEDIS->CurrentValue;
		$this->TOT_PENJ_NMEDIS->ViewCustomAttributes = "";

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL->ViewValue = $this->LINK_MASTERDETAIL->CurrentValue;
		$this->LINK_MASTERDETAIL->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT->ViewValue = $this->LINK_PELAYANAN_OBAT->CurrentValue;
		$this->LINK_PELAYANAN_OBAT->ViewCustomAttributes = "";

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL->ViewValue = $this->TOT_TIND_RAJAL->CurrentValue;
		$this->TOT_TIND_RAJAL->ViewCustomAttributes = "";

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD->ViewValue = $this->TOT_TIND_IGD->CurrentValue;
		$this->TOT_TIND_IGD->ViewCustomAttributes = "";

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status->ViewValue = $this->tanggal_pengembalian_status->CurrentValue;
		$this->tanggal_pengembalian_status->ViewValue = ew_FormatDateTime($this->tanggal_pengembalian_status->ViewValue, 0);
		$this->tanggal_pengembalian_status->ViewCustomAttributes = "";

		// naik_kelas
		$this->naik_kelas->ViewValue = $this->naik_kelas->CurrentValue;
		$this->naik_kelas->ViewCustomAttributes = "";

		// iuran_kelas_lama
		$this->iuran_kelas_lama->ViewValue = $this->iuran_kelas_lama->CurrentValue;
		$this->iuran_kelas_lama->ViewCustomAttributes = "";

		// iuran_kelas_baru
		$this->iuran_kelas_baru->ViewValue = $this->iuran_kelas_baru->CurrentValue;
		$this->iuran_kelas_baru->ViewCustomAttributes = "";

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas->ViewValue = $this->ketrangan_naik_kelas->CurrentValue;
		$this->ketrangan_naik_kelas->ViewCustomAttributes = "";

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim->ViewValue = $this->tgl_pengiriman_ad_klaim->CurrentValue;
		$this->tgl_pengiriman_ad_klaim->ViewValue = ew_FormatDateTime($this->tgl_pengiriman_ad_klaim->ViewValue, 0);
		$this->tgl_pengiriman_ad_klaim->ViewCustomAttributes = "";

		// diagnosa_keluar
		$this->diagnosa_keluar->ViewValue = $this->diagnosa_keluar->CurrentValue;
		$this->diagnosa_keluar->ViewCustomAttributes = "";

		// sep_tglsep
		$this->sep_tglsep->ViewValue = $this->sep_tglsep->CurrentValue;
		$this->sep_tglsep->ViewValue = ew_FormatDateTime($this->sep_tglsep->ViewValue, 0);
		$this->sep_tglsep->ViewCustomAttributes = "";

		// sep_tglrujuk
		$this->sep_tglrujuk->ViewValue = $this->sep_tglrujuk->CurrentValue;
		$this->sep_tglrujuk->ViewValue = ew_FormatDateTime($this->sep_tglrujuk->ViewValue, 0);
		$this->sep_tglrujuk->ViewCustomAttributes = "";

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat->ViewValue = $this->sep_kodekelasrawat->CurrentValue;
		$this->sep_kodekelasrawat->ViewCustomAttributes = "";

		// sep_norujukan
		$this->sep_norujukan->ViewValue = $this->sep_norujukan->CurrentValue;
		$this->sep_norujukan->ViewCustomAttributes = "";

		// sep_kodeppkasal
		$this->sep_kodeppkasal->ViewValue = $this->sep_kodeppkasal->CurrentValue;
		$this->sep_kodeppkasal->ViewCustomAttributes = "";

		// sep_namappkasal
		$this->sep_namappkasal->ViewValue = $this->sep_namappkasal->CurrentValue;
		$this->sep_namappkasal->ViewCustomAttributes = "";

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan->ViewValue = $this->sep_kodeppkpelayanan->CurrentValue;
		$this->sep_kodeppkpelayanan->ViewCustomAttributes = "";

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan->ViewValue = $this->sep_namappkpelayanan->CurrentValue;
		$this->sep_namappkpelayanan->ViewCustomAttributes = "";

		// t_admissioncol
		$this->t_admissioncol->ViewValue = $this->t_admissioncol->CurrentValue;
		$this->t_admissioncol->ViewCustomAttributes = "";

		// sep_jenisperawatan
		$this->sep_jenisperawatan->ViewValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_jenisperawatan->ViewCustomAttributes = "";

		// sep_catatan
		$this->sep_catatan->ViewValue = $this->sep_catatan->CurrentValue;
		$this->sep_catatan->ViewCustomAttributes = "";

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
		$this->sep_kodediagnosaawal->ViewCustomAttributes = "";

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->ViewValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->ViewCustomAttributes = "";

		// sep_lakalantas
		$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->CurrentValue;
		$this->sep_lakalantas->ViewCustomAttributes = "";

		// sep_lokasilaka
		$this->sep_lokasilaka->ViewValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_lokasilaka->ViewCustomAttributes = "";

		// sep_user
		$this->sep_user->ViewValue = $this->sep_user->CurrentValue;
		$this->sep_user->ViewCustomAttributes = "";

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta->ViewValue = $this->sep_flag_cekpeserta->CurrentValue;
		$this->sep_flag_cekpeserta->ViewCustomAttributes = "";

		// sep_flag_generatesep
		$this->sep_flag_generatesep->ViewValue = $this->sep_flag_generatesep->CurrentValue;
		$this->sep_flag_generatesep->ViewCustomAttributes = "";

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep->ViewValue = $this->sep_flag_mapingsep->CurrentValue;
		$this->sep_flag_mapingsep->ViewCustomAttributes = "";

		// sep_nik
		$this->sep_nik->ViewValue = $this->sep_nik->CurrentValue;
		$this->sep_nik->ViewCustomAttributes = "";

		// sep_namapeserta
		$this->sep_namapeserta->ViewValue = $this->sep_namapeserta->CurrentValue;
		$this->sep_namapeserta->ViewCustomAttributes = "";

		// sep_jeniskelamin
		$this->sep_jeniskelamin->ViewValue = $this->sep_jeniskelamin->CurrentValue;
		$this->sep_jeniskelamin->ViewCustomAttributes = "";

		// sep_pisat
		$this->sep_pisat->ViewValue = $this->sep_pisat->CurrentValue;
		$this->sep_pisat->ViewCustomAttributes = "";

		// sep_tgllahir
		$this->sep_tgllahir->ViewValue = $this->sep_tgllahir->CurrentValue;
		$this->sep_tgllahir->ViewCustomAttributes = "";

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan->ViewValue = $this->sep_kodejeniskepesertaan->CurrentValue;
		$this->sep_kodejeniskepesertaan->ViewCustomAttributes = "";

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan->ViewValue = $this->sep_namajeniskepesertaan->CurrentValue;
		$this->sep_namajeniskepesertaan->ViewCustomAttributes = "";

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan->ViewValue = $this->sep_kodepolitujuan->CurrentValue;
		$this->sep_kodepolitujuan->ViewCustomAttributes = "";

		// sep_namapolitujuan
		$this->sep_namapolitujuan->ViewValue = $this->sep_namapolitujuan->CurrentValue;
		$this->sep_namapolitujuan->ViewCustomAttributes = "";

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// sep_nokabpjs
		$this->sep_nokabpjs->ViewValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->ViewCustomAttributes = "";

		// counter_cetak_sep
		$this->counter_cetak_sep->ViewValue = $this->counter_cetak_sep->CurrentValue;
		$this->counter_cetak_sep->ViewCustomAttributes = "";

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep->ViewValue = $this->sep_petugas_hapus_sep->CurrentValue;
		$this->sep_petugas_hapus_sep->ViewCustomAttributes = "";

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang->ViewValue = $this->sep_petugas_set_tgl_pulang->CurrentValue;
		$this->sep_petugas_set_tgl_pulang->ViewCustomAttributes = "";

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep->ViewValue = $this->sep_jam_generate_sep->CurrentValue;
		$this->sep_jam_generate_sep->ViewValue = ew_FormatDateTime($this->sep_jam_generate_sep->ViewValue, 0);
		$this->sep_jam_generate_sep->ViewCustomAttributes = "";

		// sep_status_peserta
		$this->sep_status_peserta->ViewValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_status_peserta->ViewCustomAttributes = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->ViewValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->sep_umur_pasien_sekarang->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// status_daftar_ranap
		$this->status_daftar_ranap->ViewValue = $this->status_daftar_ranap->CurrentValue;
		$this->status_daftar_ranap->ViewCustomAttributes = "";

		// IBS_SETMARKING
		$this->IBS_SETMARKING->ViewValue = $this->IBS_SETMARKING->CurrentValue;
		$this->IBS_SETMARKING->ViewCustomAttributes = "";

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI->ViewValue = $this->IBS_PATOLOGI->CurrentValue;
		$this->IBS_PATOLOGI->ViewCustomAttributes = "";

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI->ViewValue = $this->IBS_JENISANESTESI->CurrentValue;
		$this->IBS_JENISANESTESI->ViewCustomAttributes = "";

		// IBS_NO_OK
		$this->IBS_NO_OK->ViewValue = $this->IBS_NO_OK->CurrentValue;
		$this->IBS_NO_OK->ViewCustomAttributes = "";

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN->ViewValue = $this->IBS_ASISSTEN->CurrentValue;
		$this->IBS_ASISSTEN->ViewCustomAttributes = "";

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF->ViewValue = $this->IBS_JAM_ELEFTIF->CurrentValue;
		$this->IBS_JAM_ELEFTIF->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEFTIF->ViewValue, 0);
		$this->IBS_JAM_ELEFTIF->ViewCustomAttributes = "";

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = $this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue;
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->ViewValue, 0);
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewCustomAttributes = "";

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO->ViewValue = $this->IBS_JAM_CYTO->CurrentValue;
		$this->IBS_JAM_CYTO->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO->ViewValue, 0);
		$this->IBS_JAM_CYTO->ViewCustomAttributes = "";

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = $this->IBS_JAM_CYTO_SELESAI->CurrentValue;
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO_SELESAI->ViewValue, 0);
		$this->IBS_JAM_CYTO_SELESAI->ViewCustomAttributes = "";

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP->ViewValue = $this->IBS_TGL_DFTR_OP->CurrentValue;
		$this->IBS_TGL_DFTR_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_DFTR_OP->ViewValue, 0);
		$this->IBS_TGL_DFTR_OP->ViewCustomAttributes = "";

		// IBS_TGL_OP
		$this->IBS_TGL_OP->ViewValue = $this->IBS_TGL_OP->CurrentValue;
		$this->IBS_TGL_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_OP->ViewValue, 0);
		$this->IBS_TGL_OP->ViewCustomAttributes = "";

		// grup_ruang_id
		$this->grup_ruang_id->ViewValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->ViewCustomAttributes = "";

		// status_order_ibs
		$this->status_order_ibs->ViewValue = $this->status_order_ibs->CurrentValue;
		$this->status_order_ibs->ViewCustomAttributes = "";

			// id_admission
			$this->id_admission->LinkCustomAttributes = "";
			$this->id_admission->HrefValue = "";
			$this->id_admission->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// ket_nama
			$this->ket_nama->LinkCustomAttributes = "";
			$this->ket_nama->HrefValue = "";
			$this->ket_nama->TooltipValue = "";

			// ket_tgllahir
			$this->ket_tgllahir->LinkCustomAttributes = "";
			$this->ket_tgllahir->HrefValue = "";
			$this->ket_tgllahir->TooltipValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";
			$this->ket_alamat->TooltipValue = "";

			// parent_nomr
			$this->parent_nomr->LinkCustomAttributes = "";
			$this->parent_nomr->HrefValue = "";
			$this->parent_nomr->TooltipValue = "";

			// dokterpengirim
			$this->dokterpengirim->LinkCustomAttributes = "";
			$this->dokterpengirim->HrefValue = "";
			$this->dokterpengirim->TooltipValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";
			$this->statusbayar->TooltipValue = "";

			// kirimdari
			$this->kirimdari->LinkCustomAttributes = "";
			$this->kirimdari->HrefValue = "";
			$this->kirimdari->TooltipValue = "";

			// keluargadekat
			$this->keluargadekat->LinkCustomAttributes = "";
			$this->keluargadekat->HrefValue = "";
			$this->keluargadekat->TooltipValue = "";

			// panggungjawab
			$this->panggungjawab->LinkCustomAttributes = "";
			$this->panggungjawab->HrefValue = "";
			$this->panggungjawab->TooltipValue = "";

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

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";
			$this->nott->TooltipValue = "";

			// deposit
			$this->deposit->LinkCustomAttributes = "";
			$this->deposit->HrefValue = "";
			$this->deposit->TooltipValue = "";

			// keluarrs
			$this->keluarrs->LinkCustomAttributes = "";
			$this->keluarrs->HrefValue = "";
			$this->keluarrs->TooltipValue = "";

			// icd_masuk
			$this->icd_masuk->LinkCustomAttributes = "";
			$this->icd_masuk->HrefValue = "";
			$this->icd_masuk->TooltipValue = "";

			// icd_keluar
			$this->icd_keluar->LinkCustomAttributes = "";
			$this->icd_keluar->HrefValue = "";
			$this->icd_keluar->TooltipValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";
			$this->NIP->TooltipValue = "";

			// noruang_asal
			$this->noruang_asal->LinkCustomAttributes = "";
			$this->noruang_asal->HrefValue = "";
			$this->noruang_asal->TooltipValue = "";

			// nott_asal
			$this->nott_asal->LinkCustomAttributes = "";
			$this->nott_asal->HrefValue = "";
			$this->nott_asal->TooltipValue = "";

			// tgl_pindah
			$this->tgl_pindah->LinkCustomAttributes = "";
			$this->tgl_pindah->HrefValue = "";
			$this->tgl_pindah->TooltipValue = "";

			// kd_rujuk
			$this->kd_rujuk->LinkCustomAttributes = "";
			$this->kd_rujuk->HrefValue = "";
			$this->kd_rujuk->TooltipValue = "";

			// st_bayar
			$this->st_bayar->LinkCustomAttributes = "";
			$this->st_bayar->HrefValue = "";
			$this->st_bayar->TooltipValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";
			$this->dokter_penanggungjawab->TooltipValue = "";

			// perawat
			$this->perawat->LinkCustomAttributes = "";
			$this->perawat->HrefValue = "";
			$this->perawat->TooltipValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";
			$this->KELASPERAWATAN_ID->TooltipValue = "";

			// LOS
			$this->LOS->LinkCustomAttributes = "";
			$this->LOS->HrefValue = "";
			$this->LOS->TooltipValue = "";

			// TOT_TRF_TIND_DOKTER
			$this->TOT_TRF_TIND_DOKTER->LinkCustomAttributes = "";
			$this->TOT_TRF_TIND_DOKTER->HrefValue = "";
			$this->TOT_TRF_TIND_DOKTER->TooltipValue = "";

			// TOT_BHP_DOKTER
			$this->TOT_BHP_DOKTER->LinkCustomAttributes = "";
			$this->TOT_BHP_DOKTER->HrefValue = "";
			$this->TOT_BHP_DOKTER->TooltipValue = "";

			// TOT_TRF_PERAWAT
			$this->TOT_TRF_PERAWAT->LinkCustomAttributes = "";
			$this->TOT_TRF_PERAWAT->HrefValue = "";
			$this->TOT_TRF_PERAWAT->TooltipValue = "";

			// TOT_BHP_PERAWAT
			$this->TOT_BHP_PERAWAT->LinkCustomAttributes = "";
			$this->TOT_BHP_PERAWAT->HrefValue = "";
			$this->TOT_BHP_PERAWAT->TooltipValue = "";

			// TOT_TRF_DOKTER
			$this->TOT_TRF_DOKTER->LinkCustomAttributes = "";
			$this->TOT_TRF_DOKTER->HrefValue = "";
			$this->TOT_TRF_DOKTER->TooltipValue = "";

			// TOT_BIAYA_RAD
			$this->TOT_BIAYA_RAD->LinkCustomAttributes = "";
			$this->TOT_BIAYA_RAD->HrefValue = "";
			$this->TOT_BIAYA_RAD->TooltipValue = "";

			// TOT_BIAYA_CDRPOLI
			$this->TOT_BIAYA_CDRPOLI->LinkCustomAttributes = "";
			$this->TOT_BIAYA_CDRPOLI->HrefValue = "";
			$this->TOT_BIAYA_CDRPOLI->TooltipValue = "";

			// TOT_BIAYA_LAB_IGD
			$this->TOT_BIAYA_LAB_IGD->LinkCustomAttributes = "";
			$this->TOT_BIAYA_LAB_IGD->HrefValue = "";
			$this->TOT_BIAYA_LAB_IGD->TooltipValue = "";

			// TOT_BIAYA_OKSIGEN
			$this->TOT_BIAYA_OKSIGEN->LinkCustomAttributes = "";
			$this->TOT_BIAYA_OKSIGEN->HrefValue = "";
			$this->TOT_BIAYA_OKSIGEN->TooltipValue = "";

			// TOTAL_BIAYA_OBAT
			$this->TOTAL_BIAYA_OBAT->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_OBAT->HrefValue = "";
			$this->TOTAL_BIAYA_OBAT->TooltipValue = "";

			// LINK_SET_KELAS
			$this->LINK_SET_KELAS->LinkCustomAttributes = "";
			$this->LINK_SET_KELAS->HrefValue = "";
			$this->LINK_SET_KELAS->TooltipValue = "";

			// biaya_obat
			$this->biaya_obat->LinkCustomAttributes = "";
			$this->biaya_obat->HrefValue = "";
			$this->biaya_obat->TooltipValue = "";

			// biaya_retur_obat
			$this->biaya_retur_obat->LinkCustomAttributes = "";
			$this->biaya_retur_obat->HrefValue = "";
			$this->biaya_retur_obat->TooltipValue = "";

			// TOT_BIAYA_GIZI
			$this->TOT_BIAYA_GIZI->LinkCustomAttributes = "";
			$this->TOT_BIAYA_GIZI->HrefValue = "";
			$this->TOT_BIAYA_GIZI->TooltipValue = "";

			// TOT_BIAYA_TMO
			$this->TOT_BIAYA_TMO->LinkCustomAttributes = "";
			$this->TOT_BIAYA_TMO->HrefValue = "";
			$this->TOT_BIAYA_TMO->TooltipValue = "";

			// TOT_BIAYA_AMBULAN
			$this->TOT_BIAYA_AMBULAN->LinkCustomAttributes = "";
			$this->TOT_BIAYA_AMBULAN->HrefValue = "";
			$this->TOT_BIAYA_AMBULAN->TooltipValue = "";

			// TOT_BIAYA_FISIO
			$this->TOT_BIAYA_FISIO->LinkCustomAttributes = "";
			$this->TOT_BIAYA_FISIO->HrefValue = "";
			$this->TOT_BIAYA_FISIO->TooltipValue = "";

			// TOT_BIAYA_LAINLAIN
			$this->TOT_BIAYA_LAINLAIN->LinkCustomAttributes = "";
			$this->TOT_BIAYA_LAINLAIN->HrefValue = "";
			$this->TOT_BIAYA_LAINLAIN->TooltipValue = "";

			// jenisperawatan_id
			$this->jenisperawatan_id->LinkCustomAttributes = "";
			$this->jenisperawatan_id->HrefValue = "";
			$this->jenisperawatan_id->TooltipValue = "";

			// status_transaksi
			$this->status_transaksi->LinkCustomAttributes = "";
			$this->status_transaksi->HrefValue = "";
			$this->status_transaksi->TooltipValue = "";

			// statuskeluarranap_id
			$this->statuskeluarranap_id->LinkCustomAttributes = "";
			$this->statuskeluarranap_id->HrefValue = "";
			$this->statuskeluarranap_id->TooltipValue = "";

			// TOT_BIAYA_AKOMODASI
			$this->TOT_BIAYA_AKOMODASI->LinkCustomAttributes = "";
			$this->TOT_BIAYA_AKOMODASI->HrefValue = "";
			$this->TOT_BIAYA_AKOMODASI->TooltipValue = "";

			// TOTAL_BIAYA_ASKEP
			$this->TOTAL_BIAYA_ASKEP->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_ASKEP->HrefValue = "";
			$this->TOTAL_BIAYA_ASKEP->TooltipValue = "";

			// TOTAL_BIAYA_SIMRS
			$this->TOTAL_BIAYA_SIMRS->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_SIMRS->HrefValue = "";
			$this->TOTAL_BIAYA_SIMRS->TooltipValue = "";

			// TOT_PENJ_NMEDIS
			$this->TOT_PENJ_NMEDIS->LinkCustomAttributes = "";
			$this->TOT_PENJ_NMEDIS->HrefValue = "";
			$this->TOT_PENJ_NMEDIS->TooltipValue = "";

			// LINK_MASTERDETAIL
			$this->LINK_MASTERDETAIL->LinkCustomAttributes = "";
			$this->LINK_MASTERDETAIL->HrefValue = "";
			$this->LINK_MASTERDETAIL->TooltipValue = "";

			// NO_SKP
			$this->NO_SKP->LinkCustomAttributes = "";
			$this->NO_SKP->HrefValue = "";
			$this->NO_SKP->TooltipValue = "";

			// LINK_PELAYANAN_OBAT
			$this->LINK_PELAYANAN_OBAT->LinkCustomAttributes = "";
			$this->LINK_PELAYANAN_OBAT->HrefValue = "";
			$this->LINK_PELAYANAN_OBAT->TooltipValue = "";

			// TOT_TIND_RAJAL
			$this->TOT_TIND_RAJAL->LinkCustomAttributes = "";
			$this->TOT_TIND_RAJAL->HrefValue = "";
			$this->TOT_TIND_RAJAL->TooltipValue = "";

			// TOT_TIND_IGD
			$this->TOT_TIND_IGD->LinkCustomAttributes = "";
			$this->TOT_TIND_IGD->HrefValue = "";
			$this->TOT_TIND_IGD->TooltipValue = "";

			// tanggal_pengembalian_status
			$this->tanggal_pengembalian_status->LinkCustomAttributes = "";
			$this->tanggal_pengembalian_status->HrefValue = "";
			$this->tanggal_pengembalian_status->TooltipValue = "";

			// naik_kelas
			$this->naik_kelas->LinkCustomAttributes = "";
			$this->naik_kelas->HrefValue = "";
			$this->naik_kelas->TooltipValue = "";

			// iuran_kelas_lama
			$this->iuran_kelas_lama->LinkCustomAttributes = "";
			$this->iuran_kelas_lama->HrefValue = "";
			$this->iuran_kelas_lama->TooltipValue = "";

			// iuran_kelas_baru
			$this->iuran_kelas_baru->LinkCustomAttributes = "";
			$this->iuran_kelas_baru->HrefValue = "";
			$this->iuran_kelas_baru->TooltipValue = "";

			// ketrangan_naik_kelas
			$this->ketrangan_naik_kelas->LinkCustomAttributes = "";
			$this->ketrangan_naik_kelas->HrefValue = "";
			$this->ketrangan_naik_kelas->TooltipValue = "";

			// tgl_pengiriman_ad_klaim
			$this->tgl_pengiriman_ad_klaim->LinkCustomAttributes = "";
			$this->tgl_pengiriman_ad_klaim->HrefValue = "";
			$this->tgl_pengiriman_ad_klaim->TooltipValue = "";

			// diagnosa_keluar
			$this->diagnosa_keluar->LinkCustomAttributes = "";
			$this->diagnosa_keluar->HrefValue = "";
			$this->diagnosa_keluar->TooltipValue = "";

			// sep_tglsep
			$this->sep_tglsep->LinkCustomAttributes = "";
			$this->sep_tglsep->HrefValue = "";
			$this->sep_tglsep->TooltipValue = "";

			// sep_tglrujuk
			$this->sep_tglrujuk->LinkCustomAttributes = "";
			$this->sep_tglrujuk->HrefValue = "";
			$this->sep_tglrujuk->TooltipValue = "";

			// sep_kodekelasrawat
			$this->sep_kodekelasrawat->LinkCustomAttributes = "";
			$this->sep_kodekelasrawat->HrefValue = "";
			$this->sep_kodekelasrawat->TooltipValue = "";

			// sep_norujukan
			$this->sep_norujukan->LinkCustomAttributes = "";
			$this->sep_norujukan->HrefValue = "";
			$this->sep_norujukan->TooltipValue = "";

			// sep_kodeppkasal
			$this->sep_kodeppkasal->LinkCustomAttributes = "";
			$this->sep_kodeppkasal->HrefValue = "";
			$this->sep_kodeppkasal->TooltipValue = "";

			// sep_namappkasal
			$this->sep_namappkasal->LinkCustomAttributes = "";
			$this->sep_namappkasal->HrefValue = "";
			$this->sep_namappkasal->TooltipValue = "";

			// sep_kodeppkpelayanan
			$this->sep_kodeppkpelayanan->LinkCustomAttributes = "";
			$this->sep_kodeppkpelayanan->HrefValue = "";
			$this->sep_kodeppkpelayanan->TooltipValue = "";

			// sep_namappkpelayanan
			$this->sep_namappkpelayanan->LinkCustomAttributes = "";
			$this->sep_namappkpelayanan->HrefValue = "";
			$this->sep_namappkpelayanan->TooltipValue = "";

			// t_admissioncol
			$this->t_admissioncol->LinkCustomAttributes = "";
			$this->t_admissioncol->HrefValue = "";
			$this->t_admissioncol->TooltipValue = "";

			// sep_jenisperawatan
			$this->sep_jenisperawatan->LinkCustomAttributes = "";
			$this->sep_jenisperawatan->HrefValue = "";
			$this->sep_jenisperawatan->TooltipValue = "";

			// sep_catatan
			$this->sep_catatan->LinkCustomAttributes = "";
			$this->sep_catatan->HrefValue = "";
			$this->sep_catatan->TooltipValue = "";

			// sep_kodediagnosaawal
			$this->sep_kodediagnosaawal->LinkCustomAttributes = "";
			$this->sep_kodediagnosaawal->HrefValue = "";
			$this->sep_kodediagnosaawal->TooltipValue = "";

			// sep_namadiagnosaawal
			$this->sep_namadiagnosaawal->LinkCustomAttributes = "";
			$this->sep_namadiagnosaawal->HrefValue = "";
			$this->sep_namadiagnosaawal->TooltipValue = "";

			// sep_lakalantas
			$this->sep_lakalantas->LinkCustomAttributes = "";
			$this->sep_lakalantas->HrefValue = "";
			$this->sep_lakalantas->TooltipValue = "";

			// sep_lokasilaka
			$this->sep_lokasilaka->LinkCustomAttributes = "";
			$this->sep_lokasilaka->HrefValue = "";
			$this->sep_lokasilaka->TooltipValue = "";

			// sep_user
			$this->sep_user->LinkCustomAttributes = "";
			$this->sep_user->HrefValue = "";
			$this->sep_user->TooltipValue = "";

			// sep_flag_cekpeserta
			$this->sep_flag_cekpeserta->LinkCustomAttributes = "";
			$this->sep_flag_cekpeserta->HrefValue = "";
			$this->sep_flag_cekpeserta->TooltipValue = "";

			// sep_flag_generatesep
			$this->sep_flag_generatesep->LinkCustomAttributes = "";
			$this->sep_flag_generatesep->HrefValue = "";
			$this->sep_flag_generatesep->TooltipValue = "";

			// sep_flag_mapingsep
			$this->sep_flag_mapingsep->LinkCustomAttributes = "";
			$this->sep_flag_mapingsep->HrefValue = "";
			$this->sep_flag_mapingsep->TooltipValue = "";

			// sep_nik
			$this->sep_nik->LinkCustomAttributes = "";
			$this->sep_nik->HrefValue = "";
			$this->sep_nik->TooltipValue = "";

			// sep_namapeserta
			$this->sep_namapeserta->LinkCustomAttributes = "";
			$this->sep_namapeserta->HrefValue = "";
			$this->sep_namapeserta->TooltipValue = "";

			// sep_jeniskelamin
			$this->sep_jeniskelamin->LinkCustomAttributes = "";
			$this->sep_jeniskelamin->HrefValue = "";
			$this->sep_jeniskelamin->TooltipValue = "";

			// sep_pisat
			$this->sep_pisat->LinkCustomAttributes = "";
			$this->sep_pisat->HrefValue = "";
			$this->sep_pisat->TooltipValue = "";

			// sep_tgllahir
			$this->sep_tgllahir->LinkCustomAttributes = "";
			$this->sep_tgllahir->HrefValue = "";
			$this->sep_tgllahir->TooltipValue = "";

			// sep_kodejeniskepesertaan
			$this->sep_kodejeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_kodejeniskepesertaan->HrefValue = "";
			$this->sep_kodejeniskepesertaan->TooltipValue = "";

			// sep_namajeniskepesertaan
			$this->sep_namajeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_namajeniskepesertaan->HrefValue = "";
			$this->sep_namajeniskepesertaan->TooltipValue = "";

			// sep_kodepolitujuan
			$this->sep_kodepolitujuan->LinkCustomAttributes = "";
			$this->sep_kodepolitujuan->HrefValue = "";
			$this->sep_kodepolitujuan->TooltipValue = "";

			// sep_namapolitujuan
			$this->sep_namapolitujuan->LinkCustomAttributes = "";
			$this->sep_namapolitujuan->HrefValue = "";
			$this->sep_namapolitujuan->TooltipValue = "";

			// ket_jeniskelamin
			$this->ket_jeniskelamin->LinkCustomAttributes = "";
			$this->ket_jeniskelamin->HrefValue = "";
			$this->ket_jeniskelamin->TooltipValue = "";

			// sep_nokabpjs
			$this->sep_nokabpjs->LinkCustomAttributes = "";
			$this->sep_nokabpjs->HrefValue = "";
			$this->sep_nokabpjs->TooltipValue = "";

			// counter_cetak_sep
			$this->counter_cetak_sep->LinkCustomAttributes = "";
			$this->counter_cetak_sep->HrefValue = "";
			$this->counter_cetak_sep->TooltipValue = "";

			// sep_petugas_hapus_sep
			$this->sep_petugas_hapus_sep->LinkCustomAttributes = "";
			$this->sep_petugas_hapus_sep->HrefValue = "";
			$this->sep_petugas_hapus_sep->TooltipValue = "";

			// sep_petugas_set_tgl_pulang
			$this->sep_petugas_set_tgl_pulang->LinkCustomAttributes = "";
			$this->sep_petugas_set_tgl_pulang->HrefValue = "";
			$this->sep_petugas_set_tgl_pulang->TooltipValue = "";

			// sep_jam_generate_sep
			$this->sep_jam_generate_sep->LinkCustomAttributes = "";
			$this->sep_jam_generate_sep->HrefValue = "";
			$this->sep_jam_generate_sep->TooltipValue = "";

			// sep_status_peserta
			$this->sep_status_peserta->LinkCustomAttributes = "";
			$this->sep_status_peserta->HrefValue = "";
			$this->sep_status_peserta->TooltipValue = "";

			// sep_umur_pasien_sekarang
			$this->sep_umur_pasien_sekarang->LinkCustomAttributes = "";
			$this->sep_umur_pasien_sekarang->HrefValue = "";
			$this->sep_umur_pasien_sekarang->TooltipValue = "";

			// ket_title
			$this->ket_title->LinkCustomAttributes = "";
			$this->ket_title->HrefValue = "";
			$this->ket_title->TooltipValue = "";

			// status_daftar_ranap
			$this->status_daftar_ranap->LinkCustomAttributes = "";
			$this->status_daftar_ranap->HrefValue = "";
			$this->status_daftar_ranap->TooltipValue = "";

			// IBS_SETMARKING
			$this->IBS_SETMARKING->LinkCustomAttributes = "";
			$this->IBS_SETMARKING->HrefValue = "";
			$this->IBS_SETMARKING->TooltipValue = "";

			// IBS_PATOLOGI
			$this->IBS_PATOLOGI->LinkCustomAttributes = "";
			$this->IBS_PATOLOGI->HrefValue = "";
			$this->IBS_PATOLOGI->TooltipValue = "";

			// IBS_JENISANESTESI
			$this->IBS_JENISANESTESI->LinkCustomAttributes = "";
			$this->IBS_JENISANESTESI->HrefValue = "";
			$this->IBS_JENISANESTESI->TooltipValue = "";

			// IBS_NO_OK
			$this->IBS_NO_OK->LinkCustomAttributes = "";
			$this->IBS_NO_OK->HrefValue = "";
			$this->IBS_NO_OK->TooltipValue = "";

			// IBS_ASISSTEN
			$this->IBS_ASISSTEN->LinkCustomAttributes = "";
			$this->IBS_ASISSTEN->HrefValue = "";
			$this->IBS_ASISSTEN->TooltipValue = "";

			// IBS_JAM_ELEFTIF
			$this->IBS_JAM_ELEFTIF->LinkCustomAttributes = "";
			$this->IBS_JAM_ELEFTIF->HrefValue = "";
			$this->IBS_JAM_ELEFTIF->TooltipValue = "";

			// IBS_JAM_ELEKTIF_SELESAI
			$this->IBS_JAM_ELEKTIF_SELESAI->LinkCustomAttributes = "";
			$this->IBS_JAM_ELEKTIF_SELESAI->HrefValue = "";
			$this->IBS_JAM_ELEKTIF_SELESAI->TooltipValue = "";

			// IBS_JAM_CYTO
			$this->IBS_JAM_CYTO->LinkCustomAttributes = "";
			$this->IBS_JAM_CYTO->HrefValue = "";
			$this->IBS_JAM_CYTO->TooltipValue = "";

			// IBS_JAM_CYTO_SELESAI
			$this->IBS_JAM_CYTO_SELESAI->LinkCustomAttributes = "";
			$this->IBS_JAM_CYTO_SELESAI->HrefValue = "";
			$this->IBS_JAM_CYTO_SELESAI->TooltipValue = "";

			// IBS_TGL_DFTR_OP
			$this->IBS_TGL_DFTR_OP->LinkCustomAttributes = "";
			$this->IBS_TGL_DFTR_OP->HrefValue = "";
			$this->IBS_TGL_DFTR_OP->TooltipValue = "";

			// IBS_TGL_OP
			$this->IBS_TGL_OP->LinkCustomAttributes = "";
			$this->IBS_TGL_OP->HrefValue = "";
			$this->IBS_TGL_OP->TooltipValue = "";

			// grup_ruang_id
			$this->grup_ruang_id->LinkCustomAttributes = "";
			$this->grup_ruang_id->HrefValue = "";
			$this->grup_ruang_id->TooltipValue = "";

			// status_order_ibs
			$this->status_order_ibs->LinkCustomAttributes = "";
			$this->status_order_ibs->HrefValue = "";
			$this->status_order_ibs->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id_admission
			$this->id_admission->EditAttrs["class"] = "form-control";
			$this->id_admission->EditCustomAttributes = "";
			$this->id_admission->EditValue = ew_HtmlEncode($this->id_admission->CurrentValue);
			$this->id_admission->PlaceHolder = ew_RemoveHtml($this->id_admission->FldCaption());

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->nomr->EditValue = $this->nomr->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
				}
			} else {
				$this->nomr->EditValue = NULL;
			}
			$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());

			// ket_nama
			$this->ket_nama->EditAttrs["class"] = "form-control";
			$this->ket_nama->EditCustomAttributes = "";
			$this->ket_nama->EditValue = ew_HtmlEncode($this->ket_nama->CurrentValue);
			$this->ket_nama->PlaceHolder = ew_RemoveHtml($this->ket_nama->FldCaption());

			// ket_tgllahir
			$this->ket_tgllahir->EditAttrs["class"] = "form-control";
			$this->ket_tgllahir->EditCustomAttributes = "";
			$this->ket_tgllahir->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->ket_tgllahir->CurrentValue, 8));
			$this->ket_tgllahir->PlaceHolder = ew_RemoveHtml($this->ket_tgllahir->FldCaption());

			// ket_alamat
			$this->ket_alamat->EditAttrs["class"] = "form-control";
			$this->ket_alamat->EditCustomAttributes = "";
			$this->ket_alamat->EditValue = ew_HtmlEncode($this->ket_alamat->CurrentValue);
			$this->ket_alamat->PlaceHolder = ew_RemoveHtml($this->ket_alamat->FldCaption());

			// parent_nomr
			$this->parent_nomr->EditAttrs["class"] = "form-control";
			$this->parent_nomr->EditCustomAttributes = "";
			$this->parent_nomr->EditValue = ew_HtmlEncode($this->parent_nomr->CurrentValue);
			$this->parent_nomr->PlaceHolder = ew_RemoveHtml($this->parent_nomr->FldCaption());

			// dokterpengirim
			$this->dokterpengirim->EditAttrs["class"] = "form-control";
			$this->dokterpengirim->EditCustomAttributes = "";
			if (trim(strval($this->dokterpengirim->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokterpengirim->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokterpengirim->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->dokterpengirim->EditValue = $arwrk;

			// statusbayar
			$this->statusbayar->EditAttrs["class"] = "form-control";
			$this->statusbayar->EditCustomAttributes = "";
			if (trim(strval($this->statusbayar->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->statusbayar->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->statusbayar->EditValue = $arwrk;

			// kirimdari
			$this->kirimdari->EditAttrs["class"] = "form-control";
			$this->kirimdari->EditCustomAttributes = "";
			$this->kirimdari->EditValue = ew_HtmlEncode($this->kirimdari->CurrentValue);
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
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->kirimdari->EditValue = $this->kirimdari->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->kirimdari->EditValue = ew_HtmlEncode($this->kirimdari->CurrentValue);
				}
			} else {
				$this->kirimdari->EditValue = NULL;
			}
			$this->kirimdari->PlaceHolder = ew_RemoveHtml($this->kirimdari->FldCaption());

			// keluargadekat
			$this->keluargadekat->EditAttrs["class"] = "form-control";
			$this->keluargadekat->EditCustomAttributes = "";
			$this->keluargadekat->EditValue = ew_HtmlEncode($this->keluargadekat->CurrentValue);
			$this->keluargadekat->PlaceHolder = ew_RemoveHtml($this->keluargadekat->FldCaption());

			// panggungjawab
			$this->panggungjawab->EditAttrs["class"] = "form-control";
			$this->panggungjawab->EditCustomAttributes = "";
			$this->panggungjawab->EditValue = ew_HtmlEncode($this->panggungjawab->CurrentValue);
			$this->panggungjawab->PlaceHolder = ew_RemoveHtml($this->panggungjawab->FldCaption());

			// masukrs
			$this->masukrs->EditAttrs["class"] = "form-control";
			$this->masukrs->EditCustomAttributes = "";
			$this->masukrs->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->masukrs->CurrentValue, 11));
			$this->masukrs->PlaceHolder = ew_RemoveHtml($this->masukrs->FldCaption());

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
			$lookuptblfilter = "isnull(`KETERANGAN`)";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->tempat_tidur_id->EditValue = $arwrk;

			// nott
			$this->nott->EditAttrs["class"] = "form-control";
			$this->nott->EditCustomAttributes = "";
			$this->nott->EditValue = ew_HtmlEncode($this->nott->CurrentValue);
			$this->nott->PlaceHolder = ew_RemoveHtml($this->nott->FldCaption());

			// deposit
			$this->deposit->EditAttrs["class"] = "form-control";
			$this->deposit->EditCustomAttributes = "";
			$this->deposit->EditValue = ew_HtmlEncode($this->deposit->CurrentValue);
			$this->deposit->PlaceHolder = ew_RemoveHtml($this->deposit->FldCaption());

			// keluarrs
			$this->keluarrs->EditAttrs["class"] = "form-control";
			$this->keluarrs->EditCustomAttributes = "";
			$this->keluarrs->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->keluarrs->CurrentValue, 8));
			$this->keluarrs->PlaceHolder = ew_RemoveHtml($this->keluarrs->FldCaption());

			// icd_masuk
			$this->icd_masuk->EditAttrs["class"] = "form-control";
			$this->icd_masuk->EditCustomAttributes = "";
			$this->icd_masuk->EditValue = ew_HtmlEncode($this->icd_masuk->CurrentValue);
			if (strval($this->icd_masuk->CurrentValue) <> "") {
				$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_masuk->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "";
			$this->icd_masuk->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$arwrk[2] = ew_HtmlEncode($rswrk->fields('Disp2Fld'));
					$this->icd_masuk->EditValue = $this->icd_masuk->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->icd_masuk->EditValue = ew_HtmlEncode($this->icd_masuk->CurrentValue);
				}
			} else {
				$this->icd_masuk->EditValue = NULL;
			}
			$this->icd_masuk->PlaceHolder = ew_RemoveHtml($this->icd_masuk->FldCaption());

			// icd_keluar
			$this->icd_keluar->EditAttrs["class"] = "form-control";
			$this->icd_keluar->EditCustomAttributes = "";
			$this->icd_keluar->EditValue = ew_HtmlEncode($this->icd_keluar->CurrentValue);
			$this->icd_keluar->PlaceHolder = ew_RemoveHtml($this->icd_keluar->FldCaption());

			// NIP
			$this->NIP->EditAttrs["class"] = "form-control";
			$this->NIP->EditCustomAttributes = "";
			$this->NIP->EditValue = ew_HtmlEncode($this->NIP->CurrentValue);
			$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

			// noruang_asal
			$this->noruang_asal->EditAttrs["class"] = "form-control";
			$this->noruang_asal->EditCustomAttributes = "";
			$this->noruang_asal->EditValue = ew_HtmlEncode($this->noruang_asal->CurrentValue);
			$this->noruang_asal->PlaceHolder = ew_RemoveHtml($this->noruang_asal->FldCaption());

			// nott_asal
			$this->nott_asal->EditAttrs["class"] = "form-control";
			$this->nott_asal->EditCustomAttributes = "";
			$this->nott_asal->EditValue = ew_HtmlEncode($this->nott_asal->CurrentValue);
			$this->nott_asal->PlaceHolder = ew_RemoveHtml($this->nott_asal->FldCaption());

			// tgl_pindah
			$this->tgl_pindah->EditAttrs["class"] = "form-control";
			$this->tgl_pindah->EditCustomAttributes = "";
			$this->tgl_pindah->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_pindah->CurrentValue, 8));
			$this->tgl_pindah->PlaceHolder = ew_RemoveHtml($this->tgl_pindah->FldCaption());

			// kd_rujuk
			$this->kd_rujuk->EditAttrs["class"] = "form-control";
			$this->kd_rujuk->EditCustomAttributes = "";
			if (trim(strval($this->kd_rujuk->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->kd_rujuk->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `m_rujukan`";
			$sWhereWrk = "";
			$this->kd_rujuk->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->kd_rujuk->EditValue = $arwrk;

			// st_bayar
			$this->st_bayar->EditAttrs["class"] = "form-control";
			$this->st_bayar->EditCustomAttributes = "";
			$this->st_bayar->EditValue = ew_HtmlEncode($this->st_bayar->CurrentValue);
			$this->st_bayar->PlaceHolder = ew_RemoveHtml($this->st_bayar->FldCaption());

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

			// perawat
			$this->perawat->EditAttrs["class"] = "form-control";
			$this->perawat->EditCustomAttributes = "";
			$this->perawat->EditValue = ew_HtmlEncode($this->perawat->CurrentValue);
			$this->perawat->PlaceHolder = ew_RemoveHtml($this->perawat->FldCaption());

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

			// LOS
			$this->LOS->EditAttrs["class"] = "form-control";
			$this->LOS->EditCustomAttributes = "";
			$this->LOS->EditValue = ew_HtmlEncode($this->LOS->CurrentValue);
			$this->LOS->PlaceHolder = ew_RemoveHtml($this->LOS->FldCaption());

			// TOT_TRF_TIND_DOKTER
			$this->TOT_TRF_TIND_DOKTER->EditAttrs["class"] = "form-control";
			$this->TOT_TRF_TIND_DOKTER->EditCustomAttributes = "";
			$this->TOT_TRF_TIND_DOKTER->EditValue = ew_HtmlEncode($this->TOT_TRF_TIND_DOKTER->CurrentValue);
			$this->TOT_TRF_TIND_DOKTER->PlaceHolder = ew_RemoveHtml($this->TOT_TRF_TIND_DOKTER->FldCaption());
			if (strval($this->TOT_TRF_TIND_DOKTER->EditValue) <> "" && is_numeric($this->TOT_TRF_TIND_DOKTER->EditValue)) $this->TOT_TRF_TIND_DOKTER->EditValue = ew_FormatNumber($this->TOT_TRF_TIND_DOKTER->EditValue, -2, -1, -2, 0);

			// TOT_BHP_DOKTER
			$this->TOT_BHP_DOKTER->EditAttrs["class"] = "form-control";
			$this->TOT_BHP_DOKTER->EditCustomAttributes = "";
			$this->TOT_BHP_DOKTER->EditValue = ew_HtmlEncode($this->TOT_BHP_DOKTER->CurrentValue);
			$this->TOT_BHP_DOKTER->PlaceHolder = ew_RemoveHtml($this->TOT_BHP_DOKTER->FldCaption());
			if (strval($this->TOT_BHP_DOKTER->EditValue) <> "" && is_numeric($this->TOT_BHP_DOKTER->EditValue)) $this->TOT_BHP_DOKTER->EditValue = ew_FormatNumber($this->TOT_BHP_DOKTER->EditValue, -2, -1, -2, 0);

			// TOT_TRF_PERAWAT
			$this->TOT_TRF_PERAWAT->EditAttrs["class"] = "form-control";
			$this->TOT_TRF_PERAWAT->EditCustomAttributes = "";
			$this->TOT_TRF_PERAWAT->EditValue = ew_HtmlEncode($this->TOT_TRF_PERAWAT->CurrentValue);
			$this->TOT_TRF_PERAWAT->PlaceHolder = ew_RemoveHtml($this->TOT_TRF_PERAWAT->FldCaption());
			if (strval($this->TOT_TRF_PERAWAT->EditValue) <> "" && is_numeric($this->TOT_TRF_PERAWAT->EditValue)) $this->TOT_TRF_PERAWAT->EditValue = ew_FormatNumber($this->TOT_TRF_PERAWAT->EditValue, -2, -1, -2, 0);

			// TOT_BHP_PERAWAT
			$this->TOT_BHP_PERAWAT->EditAttrs["class"] = "form-control";
			$this->TOT_BHP_PERAWAT->EditCustomAttributes = "";
			$this->TOT_BHP_PERAWAT->EditValue = ew_HtmlEncode($this->TOT_BHP_PERAWAT->CurrentValue);
			$this->TOT_BHP_PERAWAT->PlaceHolder = ew_RemoveHtml($this->TOT_BHP_PERAWAT->FldCaption());
			if (strval($this->TOT_BHP_PERAWAT->EditValue) <> "" && is_numeric($this->TOT_BHP_PERAWAT->EditValue)) $this->TOT_BHP_PERAWAT->EditValue = ew_FormatNumber($this->TOT_BHP_PERAWAT->EditValue, -2, -1, -2, 0);

			// TOT_TRF_DOKTER
			$this->TOT_TRF_DOKTER->EditAttrs["class"] = "form-control";
			$this->TOT_TRF_DOKTER->EditCustomAttributes = "";
			$this->TOT_TRF_DOKTER->EditValue = ew_HtmlEncode($this->TOT_TRF_DOKTER->CurrentValue);
			$this->TOT_TRF_DOKTER->PlaceHolder = ew_RemoveHtml($this->TOT_TRF_DOKTER->FldCaption());
			if (strval($this->TOT_TRF_DOKTER->EditValue) <> "" && is_numeric($this->TOT_TRF_DOKTER->EditValue)) $this->TOT_TRF_DOKTER->EditValue = ew_FormatNumber($this->TOT_TRF_DOKTER->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_RAD
			$this->TOT_BIAYA_RAD->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_RAD->EditCustomAttributes = "";
			$this->TOT_BIAYA_RAD->EditValue = ew_HtmlEncode($this->TOT_BIAYA_RAD->CurrentValue);
			$this->TOT_BIAYA_RAD->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_RAD->FldCaption());
			if (strval($this->TOT_BIAYA_RAD->EditValue) <> "" && is_numeric($this->TOT_BIAYA_RAD->EditValue)) $this->TOT_BIAYA_RAD->EditValue = ew_FormatNumber($this->TOT_BIAYA_RAD->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_CDRPOLI
			$this->TOT_BIAYA_CDRPOLI->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_CDRPOLI->EditCustomAttributes = "";
			$this->TOT_BIAYA_CDRPOLI->EditValue = ew_HtmlEncode($this->TOT_BIAYA_CDRPOLI->CurrentValue);
			$this->TOT_BIAYA_CDRPOLI->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_CDRPOLI->FldCaption());
			if (strval($this->TOT_BIAYA_CDRPOLI->EditValue) <> "" && is_numeric($this->TOT_BIAYA_CDRPOLI->EditValue)) $this->TOT_BIAYA_CDRPOLI->EditValue = ew_FormatNumber($this->TOT_BIAYA_CDRPOLI->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_LAB_IGD
			$this->TOT_BIAYA_LAB_IGD->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_LAB_IGD->EditCustomAttributes = "";
			$this->TOT_BIAYA_LAB_IGD->EditValue = ew_HtmlEncode($this->TOT_BIAYA_LAB_IGD->CurrentValue);
			$this->TOT_BIAYA_LAB_IGD->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_LAB_IGD->FldCaption());
			if (strval($this->TOT_BIAYA_LAB_IGD->EditValue) <> "" && is_numeric($this->TOT_BIAYA_LAB_IGD->EditValue)) $this->TOT_BIAYA_LAB_IGD->EditValue = ew_FormatNumber($this->TOT_BIAYA_LAB_IGD->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_OKSIGEN
			$this->TOT_BIAYA_OKSIGEN->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_OKSIGEN->EditCustomAttributes = "";
			$this->TOT_BIAYA_OKSIGEN->EditValue = ew_HtmlEncode($this->TOT_BIAYA_OKSIGEN->CurrentValue);
			$this->TOT_BIAYA_OKSIGEN->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_OKSIGEN->FldCaption());
			if (strval($this->TOT_BIAYA_OKSIGEN->EditValue) <> "" && is_numeric($this->TOT_BIAYA_OKSIGEN->EditValue)) $this->TOT_BIAYA_OKSIGEN->EditValue = ew_FormatNumber($this->TOT_BIAYA_OKSIGEN->EditValue, -2, -1, -2, 0);

			// TOTAL_BIAYA_OBAT
			$this->TOTAL_BIAYA_OBAT->EditAttrs["class"] = "form-control";
			$this->TOTAL_BIAYA_OBAT->EditCustomAttributes = "";
			$this->TOTAL_BIAYA_OBAT->EditValue = ew_HtmlEncode($this->TOTAL_BIAYA_OBAT->CurrentValue);
			$this->TOTAL_BIAYA_OBAT->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_OBAT->FldCaption());
			if (strval($this->TOTAL_BIAYA_OBAT->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_OBAT->EditValue)) $this->TOTAL_BIAYA_OBAT->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_OBAT->EditValue, -2, -1, -2, 0);

			// LINK_SET_KELAS
			$this->LINK_SET_KELAS->EditAttrs["class"] = "form-control";
			$this->LINK_SET_KELAS->EditCustomAttributes = "";
			$this->LINK_SET_KELAS->EditValue = ew_HtmlEncode($this->LINK_SET_KELAS->CurrentValue);
			$this->LINK_SET_KELAS->PlaceHolder = ew_RemoveHtml($this->LINK_SET_KELAS->FldCaption());

			// biaya_obat
			$this->biaya_obat->EditAttrs["class"] = "form-control";
			$this->biaya_obat->EditCustomAttributes = "";
			$this->biaya_obat->EditValue = ew_HtmlEncode($this->biaya_obat->CurrentValue);
			$this->biaya_obat->PlaceHolder = ew_RemoveHtml($this->biaya_obat->FldCaption());
			if (strval($this->biaya_obat->EditValue) <> "" && is_numeric($this->biaya_obat->EditValue)) $this->biaya_obat->EditValue = ew_FormatNumber($this->biaya_obat->EditValue, -2, -1, -2, 0);

			// biaya_retur_obat
			$this->biaya_retur_obat->EditAttrs["class"] = "form-control";
			$this->biaya_retur_obat->EditCustomAttributes = "";
			$this->biaya_retur_obat->EditValue = ew_HtmlEncode($this->biaya_retur_obat->CurrentValue);
			$this->biaya_retur_obat->PlaceHolder = ew_RemoveHtml($this->biaya_retur_obat->FldCaption());
			if (strval($this->biaya_retur_obat->EditValue) <> "" && is_numeric($this->biaya_retur_obat->EditValue)) $this->biaya_retur_obat->EditValue = ew_FormatNumber($this->biaya_retur_obat->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_GIZI
			$this->TOT_BIAYA_GIZI->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_GIZI->EditCustomAttributes = "";
			$this->TOT_BIAYA_GIZI->EditValue = ew_HtmlEncode($this->TOT_BIAYA_GIZI->CurrentValue);
			$this->TOT_BIAYA_GIZI->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_GIZI->FldCaption());
			if (strval($this->TOT_BIAYA_GIZI->EditValue) <> "" && is_numeric($this->TOT_BIAYA_GIZI->EditValue)) $this->TOT_BIAYA_GIZI->EditValue = ew_FormatNumber($this->TOT_BIAYA_GIZI->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_TMO
			$this->TOT_BIAYA_TMO->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_TMO->EditCustomAttributes = "";
			$this->TOT_BIAYA_TMO->EditValue = ew_HtmlEncode($this->TOT_BIAYA_TMO->CurrentValue);
			$this->TOT_BIAYA_TMO->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_TMO->FldCaption());
			if (strval($this->TOT_BIAYA_TMO->EditValue) <> "" && is_numeric($this->TOT_BIAYA_TMO->EditValue)) $this->TOT_BIAYA_TMO->EditValue = ew_FormatNumber($this->TOT_BIAYA_TMO->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_AMBULAN
			$this->TOT_BIAYA_AMBULAN->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_AMBULAN->EditCustomAttributes = "";
			$this->TOT_BIAYA_AMBULAN->EditValue = ew_HtmlEncode($this->TOT_BIAYA_AMBULAN->CurrentValue);
			$this->TOT_BIAYA_AMBULAN->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_AMBULAN->FldCaption());
			if (strval($this->TOT_BIAYA_AMBULAN->EditValue) <> "" && is_numeric($this->TOT_BIAYA_AMBULAN->EditValue)) $this->TOT_BIAYA_AMBULAN->EditValue = ew_FormatNumber($this->TOT_BIAYA_AMBULAN->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_FISIO
			$this->TOT_BIAYA_FISIO->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_FISIO->EditCustomAttributes = "";
			$this->TOT_BIAYA_FISIO->EditValue = ew_HtmlEncode($this->TOT_BIAYA_FISIO->CurrentValue);
			$this->TOT_BIAYA_FISIO->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_FISIO->FldCaption());
			if (strval($this->TOT_BIAYA_FISIO->EditValue) <> "" && is_numeric($this->TOT_BIAYA_FISIO->EditValue)) $this->TOT_BIAYA_FISIO->EditValue = ew_FormatNumber($this->TOT_BIAYA_FISIO->EditValue, -2, -1, -2, 0);

			// TOT_BIAYA_LAINLAIN
			$this->TOT_BIAYA_LAINLAIN->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_LAINLAIN->EditCustomAttributes = "";
			$this->TOT_BIAYA_LAINLAIN->EditValue = ew_HtmlEncode($this->TOT_BIAYA_LAINLAIN->CurrentValue);
			$this->TOT_BIAYA_LAINLAIN->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_LAINLAIN->FldCaption());
			if (strval($this->TOT_BIAYA_LAINLAIN->EditValue) <> "" && is_numeric($this->TOT_BIAYA_LAINLAIN->EditValue)) $this->TOT_BIAYA_LAINLAIN->EditValue = ew_FormatNumber($this->TOT_BIAYA_LAINLAIN->EditValue, -2, -1, -2, 0);

			// jenisperawatan_id
			$this->jenisperawatan_id->EditAttrs["class"] = "form-control";
			$this->jenisperawatan_id->EditCustomAttributes = "";
			$this->jenisperawatan_id->EditValue = ew_HtmlEncode($this->jenisperawatan_id->CurrentValue);
			$this->jenisperawatan_id->PlaceHolder = ew_RemoveHtml($this->jenisperawatan_id->FldCaption());

			// status_transaksi
			$this->status_transaksi->EditAttrs["class"] = "form-control";
			$this->status_transaksi->EditCustomAttributes = "";
			$this->status_transaksi->EditValue = ew_HtmlEncode($this->status_transaksi->CurrentValue);
			$this->status_transaksi->PlaceHolder = ew_RemoveHtml($this->status_transaksi->FldCaption());

			// statuskeluarranap_id
			$this->statuskeluarranap_id->EditAttrs["class"] = "form-control";
			$this->statuskeluarranap_id->EditCustomAttributes = "";
			$this->statuskeluarranap_id->EditValue = ew_HtmlEncode($this->statuskeluarranap_id->CurrentValue);
			$this->statuskeluarranap_id->PlaceHolder = ew_RemoveHtml($this->statuskeluarranap_id->FldCaption());

			// TOT_BIAYA_AKOMODASI
			$this->TOT_BIAYA_AKOMODASI->EditAttrs["class"] = "form-control";
			$this->TOT_BIAYA_AKOMODASI->EditCustomAttributes = "";
			$this->TOT_BIAYA_AKOMODASI->EditValue = ew_HtmlEncode($this->TOT_BIAYA_AKOMODASI->CurrentValue);
			$this->TOT_BIAYA_AKOMODASI->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_AKOMODASI->FldCaption());
			if (strval($this->TOT_BIAYA_AKOMODASI->EditValue) <> "" && is_numeric($this->TOT_BIAYA_AKOMODASI->EditValue)) $this->TOT_BIAYA_AKOMODASI->EditValue = ew_FormatNumber($this->TOT_BIAYA_AKOMODASI->EditValue, -2, -1, -2, 0);

			// TOTAL_BIAYA_ASKEP
			$this->TOTAL_BIAYA_ASKEP->EditAttrs["class"] = "form-control";
			$this->TOTAL_BIAYA_ASKEP->EditCustomAttributes = "";
			$this->TOTAL_BIAYA_ASKEP->EditValue = ew_HtmlEncode($this->TOTAL_BIAYA_ASKEP->CurrentValue);
			$this->TOTAL_BIAYA_ASKEP->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_ASKEP->FldCaption());
			if (strval($this->TOTAL_BIAYA_ASKEP->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_ASKEP->EditValue)) $this->TOTAL_BIAYA_ASKEP->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_ASKEP->EditValue, -2, -1, -2, 0);

			// TOTAL_BIAYA_SIMRS
			$this->TOTAL_BIAYA_SIMRS->EditAttrs["class"] = "form-control";
			$this->TOTAL_BIAYA_SIMRS->EditCustomAttributes = "";
			$this->TOTAL_BIAYA_SIMRS->EditValue = ew_HtmlEncode($this->TOTAL_BIAYA_SIMRS->CurrentValue);
			$this->TOTAL_BIAYA_SIMRS->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_SIMRS->FldCaption());
			if (strval($this->TOTAL_BIAYA_SIMRS->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_SIMRS->EditValue)) $this->TOTAL_BIAYA_SIMRS->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_SIMRS->EditValue, -2, -1, -2, 0);

			// TOT_PENJ_NMEDIS
			$this->TOT_PENJ_NMEDIS->EditAttrs["class"] = "form-control";
			$this->TOT_PENJ_NMEDIS->EditCustomAttributes = "";
			$this->TOT_PENJ_NMEDIS->EditValue = ew_HtmlEncode($this->TOT_PENJ_NMEDIS->CurrentValue);
			$this->TOT_PENJ_NMEDIS->PlaceHolder = ew_RemoveHtml($this->TOT_PENJ_NMEDIS->FldCaption());
			if (strval($this->TOT_PENJ_NMEDIS->EditValue) <> "" && is_numeric($this->TOT_PENJ_NMEDIS->EditValue)) $this->TOT_PENJ_NMEDIS->EditValue = ew_FormatNumber($this->TOT_PENJ_NMEDIS->EditValue, -2, -1, -2, 0);

			// LINK_MASTERDETAIL
			$this->LINK_MASTERDETAIL->EditAttrs["class"] = "form-control";
			$this->LINK_MASTERDETAIL->EditCustomAttributes = "";
			$this->LINK_MASTERDETAIL->EditValue = ew_HtmlEncode($this->LINK_MASTERDETAIL->CurrentValue);
			$this->LINK_MASTERDETAIL->PlaceHolder = ew_RemoveHtml($this->LINK_MASTERDETAIL->FldCaption());

			// NO_SKP
			$this->NO_SKP->EditAttrs["class"] = "form-control";
			$this->NO_SKP->EditCustomAttributes = "";
			$this->NO_SKP->EditValue = ew_HtmlEncode($this->NO_SKP->CurrentValue);
			$this->NO_SKP->PlaceHolder = ew_RemoveHtml($this->NO_SKP->FldCaption());

			// LINK_PELAYANAN_OBAT
			$this->LINK_PELAYANAN_OBAT->EditAttrs["class"] = "form-control";
			$this->LINK_PELAYANAN_OBAT->EditCustomAttributes = "";
			$this->LINK_PELAYANAN_OBAT->EditValue = ew_HtmlEncode($this->LINK_PELAYANAN_OBAT->CurrentValue);
			$this->LINK_PELAYANAN_OBAT->PlaceHolder = ew_RemoveHtml($this->LINK_PELAYANAN_OBAT->FldCaption());

			// TOT_TIND_RAJAL
			$this->TOT_TIND_RAJAL->EditAttrs["class"] = "form-control";
			$this->TOT_TIND_RAJAL->EditCustomAttributes = "";
			$this->TOT_TIND_RAJAL->EditValue = ew_HtmlEncode($this->TOT_TIND_RAJAL->CurrentValue);
			$this->TOT_TIND_RAJAL->PlaceHolder = ew_RemoveHtml($this->TOT_TIND_RAJAL->FldCaption());
			if (strval($this->TOT_TIND_RAJAL->EditValue) <> "" && is_numeric($this->TOT_TIND_RAJAL->EditValue)) $this->TOT_TIND_RAJAL->EditValue = ew_FormatNumber($this->TOT_TIND_RAJAL->EditValue, -2, -1, -2, 0);

			// TOT_TIND_IGD
			$this->TOT_TIND_IGD->EditAttrs["class"] = "form-control";
			$this->TOT_TIND_IGD->EditCustomAttributes = "";
			$this->TOT_TIND_IGD->EditValue = ew_HtmlEncode($this->TOT_TIND_IGD->CurrentValue);
			$this->TOT_TIND_IGD->PlaceHolder = ew_RemoveHtml($this->TOT_TIND_IGD->FldCaption());
			if (strval($this->TOT_TIND_IGD->EditValue) <> "" && is_numeric($this->TOT_TIND_IGD->EditValue)) $this->TOT_TIND_IGD->EditValue = ew_FormatNumber($this->TOT_TIND_IGD->EditValue, -2, -1, -2, 0);

			// tanggal_pengembalian_status
			$this->tanggal_pengembalian_status->EditAttrs["class"] = "form-control";
			$this->tanggal_pengembalian_status->EditCustomAttributes = "";
			$this->tanggal_pengembalian_status->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tanggal_pengembalian_status->CurrentValue, 8));
			$this->tanggal_pengembalian_status->PlaceHolder = ew_RemoveHtml($this->tanggal_pengembalian_status->FldCaption());

			// naik_kelas
			$this->naik_kelas->EditAttrs["class"] = "form-control";
			$this->naik_kelas->EditCustomAttributes = "";
			$this->naik_kelas->EditValue = ew_HtmlEncode($this->naik_kelas->CurrentValue);
			$this->naik_kelas->PlaceHolder = ew_RemoveHtml($this->naik_kelas->FldCaption());

			// iuran_kelas_lama
			$this->iuran_kelas_lama->EditAttrs["class"] = "form-control";
			$this->iuran_kelas_lama->EditCustomAttributes = "";
			$this->iuran_kelas_lama->EditValue = ew_HtmlEncode($this->iuran_kelas_lama->CurrentValue);
			$this->iuran_kelas_lama->PlaceHolder = ew_RemoveHtml($this->iuran_kelas_lama->FldCaption());
			if (strval($this->iuran_kelas_lama->EditValue) <> "" && is_numeric($this->iuran_kelas_lama->EditValue)) $this->iuran_kelas_lama->EditValue = ew_FormatNumber($this->iuran_kelas_lama->EditValue, -2, -1, -2, 0);

			// iuran_kelas_baru
			$this->iuran_kelas_baru->EditAttrs["class"] = "form-control";
			$this->iuran_kelas_baru->EditCustomAttributes = "";
			$this->iuran_kelas_baru->EditValue = ew_HtmlEncode($this->iuran_kelas_baru->CurrentValue);
			$this->iuran_kelas_baru->PlaceHolder = ew_RemoveHtml($this->iuran_kelas_baru->FldCaption());
			if (strval($this->iuran_kelas_baru->EditValue) <> "" && is_numeric($this->iuran_kelas_baru->EditValue)) $this->iuran_kelas_baru->EditValue = ew_FormatNumber($this->iuran_kelas_baru->EditValue, -2, -1, -2, 0);

			// ketrangan_naik_kelas
			$this->ketrangan_naik_kelas->EditAttrs["class"] = "form-control";
			$this->ketrangan_naik_kelas->EditCustomAttributes = "";
			$this->ketrangan_naik_kelas->EditValue = ew_HtmlEncode($this->ketrangan_naik_kelas->CurrentValue);
			$this->ketrangan_naik_kelas->PlaceHolder = ew_RemoveHtml($this->ketrangan_naik_kelas->FldCaption());

			// tgl_pengiriman_ad_klaim
			$this->tgl_pengiriman_ad_klaim->EditAttrs["class"] = "form-control";
			$this->tgl_pengiriman_ad_klaim->EditCustomAttributes = "";
			$this->tgl_pengiriman_ad_klaim->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_pengiriman_ad_klaim->CurrentValue, 8));
			$this->tgl_pengiriman_ad_klaim->PlaceHolder = ew_RemoveHtml($this->tgl_pengiriman_ad_klaim->FldCaption());

			// diagnosa_keluar
			$this->diagnosa_keluar->EditAttrs["class"] = "form-control";
			$this->diagnosa_keluar->EditCustomAttributes = "";
			$this->diagnosa_keluar->EditValue = ew_HtmlEncode($this->diagnosa_keluar->CurrentValue);
			$this->diagnosa_keluar->PlaceHolder = ew_RemoveHtml($this->diagnosa_keluar->FldCaption());

			// sep_tglsep
			$this->sep_tglsep->EditAttrs["class"] = "form-control";
			$this->sep_tglsep->EditCustomAttributes = "";
			$this->sep_tglsep->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sep_tglsep->CurrentValue, 8));
			$this->sep_tglsep->PlaceHolder = ew_RemoveHtml($this->sep_tglsep->FldCaption());

			// sep_tglrujuk
			$this->sep_tglrujuk->EditAttrs["class"] = "form-control";
			$this->sep_tglrujuk->EditCustomAttributes = "";
			$this->sep_tglrujuk->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sep_tglrujuk->CurrentValue, 8));
			$this->sep_tglrujuk->PlaceHolder = ew_RemoveHtml($this->sep_tglrujuk->FldCaption());

			// sep_kodekelasrawat
			$this->sep_kodekelasrawat->EditAttrs["class"] = "form-control";
			$this->sep_kodekelasrawat->EditCustomAttributes = "";
			$this->sep_kodekelasrawat->EditValue = ew_HtmlEncode($this->sep_kodekelasrawat->CurrentValue);
			$this->sep_kodekelasrawat->PlaceHolder = ew_RemoveHtml($this->sep_kodekelasrawat->FldCaption());

			// sep_norujukan
			$this->sep_norujukan->EditAttrs["class"] = "form-control";
			$this->sep_norujukan->EditCustomAttributes = "";
			$this->sep_norujukan->EditValue = ew_HtmlEncode($this->sep_norujukan->CurrentValue);
			$this->sep_norujukan->PlaceHolder = ew_RemoveHtml($this->sep_norujukan->FldCaption());

			// sep_kodeppkasal
			$this->sep_kodeppkasal->EditAttrs["class"] = "form-control";
			$this->sep_kodeppkasal->EditCustomAttributes = "";
			$this->sep_kodeppkasal->EditValue = ew_HtmlEncode($this->sep_kodeppkasal->CurrentValue);
			$this->sep_kodeppkasal->PlaceHolder = ew_RemoveHtml($this->sep_kodeppkasal->FldCaption());

			// sep_namappkasal
			$this->sep_namappkasal->EditAttrs["class"] = "form-control";
			$this->sep_namappkasal->EditCustomAttributes = "";
			$this->sep_namappkasal->EditValue = ew_HtmlEncode($this->sep_namappkasal->CurrentValue);
			$this->sep_namappkasal->PlaceHolder = ew_RemoveHtml($this->sep_namappkasal->FldCaption());

			// sep_kodeppkpelayanan
			$this->sep_kodeppkpelayanan->EditAttrs["class"] = "form-control";
			$this->sep_kodeppkpelayanan->EditCustomAttributes = "";
			$this->sep_kodeppkpelayanan->EditValue = ew_HtmlEncode($this->sep_kodeppkpelayanan->CurrentValue);
			$this->sep_kodeppkpelayanan->PlaceHolder = ew_RemoveHtml($this->sep_kodeppkpelayanan->FldCaption());

			// sep_namappkpelayanan
			$this->sep_namappkpelayanan->EditAttrs["class"] = "form-control";
			$this->sep_namappkpelayanan->EditCustomAttributes = "";
			$this->sep_namappkpelayanan->EditValue = ew_HtmlEncode($this->sep_namappkpelayanan->CurrentValue);
			$this->sep_namappkpelayanan->PlaceHolder = ew_RemoveHtml($this->sep_namappkpelayanan->FldCaption());

			// t_admissioncol
			$this->t_admissioncol->EditAttrs["class"] = "form-control";
			$this->t_admissioncol->EditCustomAttributes = "";
			$this->t_admissioncol->EditValue = ew_HtmlEncode($this->t_admissioncol->CurrentValue);
			$this->t_admissioncol->PlaceHolder = ew_RemoveHtml($this->t_admissioncol->FldCaption());

			// sep_jenisperawatan
			$this->sep_jenisperawatan->EditAttrs["class"] = "form-control";
			$this->sep_jenisperawatan->EditCustomAttributes = "";
			$this->sep_jenisperawatan->EditValue = ew_HtmlEncode($this->sep_jenisperawatan->CurrentValue);
			$this->sep_jenisperawatan->PlaceHolder = ew_RemoveHtml($this->sep_jenisperawatan->FldCaption());

			// sep_catatan
			$this->sep_catatan->EditAttrs["class"] = "form-control";
			$this->sep_catatan->EditCustomAttributes = "";
			$this->sep_catatan->EditValue = ew_HtmlEncode($this->sep_catatan->CurrentValue);
			$this->sep_catatan->PlaceHolder = ew_RemoveHtml($this->sep_catatan->FldCaption());

			// sep_kodediagnosaawal
			$this->sep_kodediagnosaawal->EditAttrs["class"] = "form-control";
			$this->sep_kodediagnosaawal->EditCustomAttributes = "";
			$this->sep_kodediagnosaawal->EditValue = ew_HtmlEncode($this->sep_kodediagnosaawal->CurrentValue);
			$this->sep_kodediagnosaawal->PlaceHolder = ew_RemoveHtml($this->sep_kodediagnosaawal->FldCaption());

			// sep_namadiagnosaawal
			$this->sep_namadiagnosaawal->EditAttrs["class"] = "form-control";
			$this->sep_namadiagnosaawal->EditCustomAttributes = "";
			$this->sep_namadiagnosaawal->EditValue = ew_HtmlEncode($this->sep_namadiagnosaawal->CurrentValue);
			$this->sep_namadiagnosaawal->PlaceHolder = ew_RemoveHtml($this->sep_namadiagnosaawal->FldCaption());

			// sep_lakalantas
			$this->sep_lakalantas->EditAttrs["class"] = "form-control";
			$this->sep_lakalantas->EditCustomAttributes = "";
			$this->sep_lakalantas->EditValue = ew_HtmlEncode($this->sep_lakalantas->CurrentValue);
			$this->sep_lakalantas->PlaceHolder = ew_RemoveHtml($this->sep_lakalantas->FldCaption());

			// sep_lokasilaka
			$this->sep_lokasilaka->EditAttrs["class"] = "form-control";
			$this->sep_lokasilaka->EditCustomAttributes = "";
			$this->sep_lokasilaka->EditValue = ew_HtmlEncode($this->sep_lokasilaka->CurrentValue);
			$this->sep_lokasilaka->PlaceHolder = ew_RemoveHtml($this->sep_lokasilaka->FldCaption());

			// sep_user
			$this->sep_user->EditAttrs["class"] = "form-control";
			$this->sep_user->EditCustomAttributes = "";
			$this->sep_user->EditValue = ew_HtmlEncode($this->sep_user->CurrentValue);
			$this->sep_user->PlaceHolder = ew_RemoveHtml($this->sep_user->FldCaption());

			// sep_flag_cekpeserta
			$this->sep_flag_cekpeserta->EditAttrs["class"] = "form-control";
			$this->sep_flag_cekpeserta->EditCustomAttributes = "";
			$this->sep_flag_cekpeserta->EditValue = ew_HtmlEncode($this->sep_flag_cekpeserta->CurrentValue);
			$this->sep_flag_cekpeserta->PlaceHolder = ew_RemoveHtml($this->sep_flag_cekpeserta->FldCaption());

			// sep_flag_generatesep
			$this->sep_flag_generatesep->EditAttrs["class"] = "form-control";
			$this->sep_flag_generatesep->EditCustomAttributes = "";
			$this->sep_flag_generatesep->EditValue = ew_HtmlEncode($this->sep_flag_generatesep->CurrentValue);
			$this->sep_flag_generatesep->PlaceHolder = ew_RemoveHtml($this->sep_flag_generatesep->FldCaption());

			// sep_flag_mapingsep
			$this->sep_flag_mapingsep->EditAttrs["class"] = "form-control";
			$this->sep_flag_mapingsep->EditCustomAttributes = "";
			$this->sep_flag_mapingsep->EditValue = ew_HtmlEncode($this->sep_flag_mapingsep->CurrentValue);
			$this->sep_flag_mapingsep->PlaceHolder = ew_RemoveHtml($this->sep_flag_mapingsep->FldCaption());

			// sep_nik
			$this->sep_nik->EditAttrs["class"] = "form-control";
			$this->sep_nik->EditCustomAttributes = "";
			$this->sep_nik->EditValue = ew_HtmlEncode($this->sep_nik->CurrentValue);
			$this->sep_nik->PlaceHolder = ew_RemoveHtml($this->sep_nik->FldCaption());

			// sep_namapeserta
			$this->sep_namapeserta->EditAttrs["class"] = "form-control";
			$this->sep_namapeserta->EditCustomAttributes = "";
			$this->sep_namapeserta->EditValue = ew_HtmlEncode($this->sep_namapeserta->CurrentValue);
			$this->sep_namapeserta->PlaceHolder = ew_RemoveHtml($this->sep_namapeserta->FldCaption());

			// sep_jeniskelamin
			$this->sep_jeniskelamin->EditAttrs["class"] = "form-control";
			$this->sep_jeniskelamin->EditCustomAttributes = "";
			$this->sep_jeniskelamin->EditValue = ew_HtmlEncode($this->sep_jeniskelamin->CurrentValue);
			$this->sep_jeniskelamin->PlaceHolder = ew_RemoveHtml($this->sep_jeniskelamin->FldCaption());

			// sep_pisat
			$this->sep_pisat->EditAttrs["class"] = "form-control";
			$this->sep_pisat->EditCustomAttributes = "";
			$this->sep_pisat->EditValue = ew_HtmlEncode($this->sep_pisat->CurrentValue);
			$this->sep_pisat->PlaceHolder = ew_RemoveHtml($this->sep_pisat->FldCaption());

			// sep_tgllahir
			$this->sep_tgllahir->EditAttrs["class"] = "form-control";
			$this->sep_tgllahir->EditCustomAttributes = "";
			$this->sep_tgllahir->EditValue = ew_HtmlEncode($this->sep_tgllahir->CurrentValue);
			$this->sep_tgllahir->PlaceHolder = ew_RemoveHtml($this->sep_tgllahir->FldCaption());

			// sep_kodejeniskepesertaan
			$this->sep_kodejeniskepesertaan->EditAttrs["class"] = "form-control";
			$this->sep_kodejeniskepesertaan->EditCustomAttributes = "";
			$this->sep_kodejeniskepesertaan->EditValue = ew_HtmlEncode($this->sep_kodejeniskepesertaan->CurrentValue);
			$this->sep_kodejeniskepesertaan->PlaceHolder = ew_RemoveHtml($this->sep_kodejeniskepesertaan->FldCaption());

			// sep_namajeniskepesertaan
			$this->sep_namajeniskepesertaan->EditAttrs["class"] = "form-control";
			$this->sep_namajeniskepesertaan->EditCustomAttributes = "";
			$this->sep_namajeniskepesertaan->EditValue = ew_HtmlEncode($this->sep_namajeniskepesertaan->CurrentValue);
			$this->sep_namajeniskepesertaan->PlaceHolder = ew_RemoveHtml($this->sep_namajeniskepesertaan->FldCaption());

			// sep_kodepolitujuan
			$this->sep_kodepolitujuan->EditAttrs["class"] = "form-control";
			$this->sep_kodepolitujuan->EditCustomAttributes = "";
			$this->sep_kodepolitujuan->EditValue = ew_HtmlEncode($this->sep_kodepolitujuan->CurrentValue);
			$this->sep_kodepolitujuan->PlaceHolder = ew_RemoveHtml($this->sep_kodepolitujuan->FldCaption());

			// sep_namapolitujuan
			$this->sep_namapolitujuan->EditAttrs["class"] = "form-control";
			$this->sep_namapolitujuan->EditCustomAttributes = "";
			$this->sep_namapolitujuan->EditValue = ew_HtmlEncode($this->sep_namapolitujuan->CurrentValue);
			$this->sep_namapolitujuan->PlaceHolder = ew_RemoveHtml($this->sep_namapolitujuan->FldCaption());

			// ket_jeniskelamin
			$this->ket_jeniskelamin->EditAttrs["class"] = "form-control";
			$this->ket_jeniskelamin->EditCustomAttributes = "";
			$this->ket_jeniskelamin->EditValue = ew_HtmlEncode($this->ket_jeniskelamin->CurrentValue);
			$this->ket_jeniskelamin->PlaceHolder = ew_RemoveHtml($this->ket_jeniskelamin->FldCaption());

			// sep_nokabpjs
			$this->sep_nokabpjs->EditAttrs["class"] = "form-control";
			$this->sep_nokabpjs->EditCustomAttributes = "";
			$this->sep_nokabpjs->EditValue = ew_HtmlEncode($this->sep_nokabpjs->CurrentValue);
			$this->sep_nokabpjs->PlaceHolder = ew_RemoveHtml($this->sep_nokabpjs->FldCaption());

			// counter_cetak_sep
			$this->counter_cetak_sep->EditAttrs["class"] = "form-control";
			$this->counter_cetak_sep->EditCustomAttributes = "";
			$this->counter_cetak_sep->EditValue = ew_HtmlEncode($this->counter_cetak_sep->CurrentValue);
			$this->counter_cetak_sep->PlaceHolder = ew_RemoveHtml($this->counter_cetak_sep->FldCaption());

			// sep_petugas_hapus_sep
			$this->sep_petugas_hapus_sep->EditAttrs["class"] = "form-control";
			$this->sep_petugas_hapus_sep->EditCustomAttributes = "";
			$this->sep_petugas_hapus_sep->EditValue = ew_HtmlEncode($this->sep_petugas_hapus_sep->CurrentValue);
			$this->sep_petugas_hapus_sep->PlaceHolder = ew_RemoveHtml($this->sep_petugas_hapus_sep->FldCaption());

			// sep_petugas_set_tgl_pulang
			$this->sep_petugas_set_tgl_pulang->EditAttrs["class"] = "form-control";
			$this->sep_petugas_set_tgl_pulang->EditCustomAttributes = "";
			$this->sep_petugas_set_tgl_pulang->EditValue = ew_HtmlEncode($this->sep_petugas_set_tgl_pulang->CurrentValue);
			$this->sep_petugas_set_tgl_pulang->PlaceHolder = ew_RemoveHtml($this->sep_petugas_set_tgl_pulang->FldCaption());

			// sep_jam_generate_sep
			$this->sep_jam_generate_sep->EditAttrs["class"] = "form-control";
			$this->sep_jam_generate_sep->EditCustomAttributes = "";
			$this->sep_jam_generate_sep->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sep_jam_generate_sep->CurrentValue, 8));
			$this->sep_jam_generate_sep->PlaceHolder = ew_RemoveHtml($this->sep_jam_generate_sep->FldCaption());

			// sep_status_peserta
			$this->sep_status_peserta->EditAttrs["class"] = "form-control";
			$this->sep_status_peserta->EditCustomAttributes = "";
			$this->sep_status_peserta->EditValue = ew_HtmlEncode($this->sep_status_peserta->CurrentValue);
			$this->sep_status_peserta->PlaceHolder = ew_RemoveHtml($this->sep_status_peserta->FldCaption());

			// sep_umur_pasien_sekarang
			$this->sep_umur_pasien_sekarang->EditAttrs["class"] = "form-control";
			$this->sep_umur_pasien_sekarang->EditCustomAttributes = "";
			$this->sep_umur_pasien_sekarang->EditValue = ew_HtmlEncode($this->sep_umur_pasien_sekarang->CurrentValue);
			$this->sep_umur_pasien_sekarang->PlaceHolder = ew_RemoveHtml($this->sep_umur_pasien_sekarang->FldCaption());

			// ket_title
			$this->ket_title->EditAttrs["class"] = "form-control";
			$this->ket_title->EditCustomAttributes = "";
			$this->ket_title->EditValue = ew_HtmlEncode($this->ket_title->CurrentValue);
			$this->ket_title->PlaceHolder = ew_RemoveHtml($this->ket_title->FldCaption());

			// status_daftar_ranap
			$this->status_daftar_ranap->EditAttrs["class"] = "form-control";
			$this->status_daftar_ranap->EditCustomAttributes = "";
			$this->status_daftar_ranap->EditValue = ew_HtmlEncode($this->status_daftar_ranap->CurrentValue);
			$this->status_daftar_ranap->PlaceHolder = ew_RemoveHtml($this->status_daftar_ranap->FldCaption());

			// IBS_SETMARKING
			$this->IBS_SETMARKING->EditAttrs["class"] = "form-control";
			$this->IBS_SETMARKING->EditCustomAttributes = "";
			$this->IBS_SETMARKING->EditValue = ew_HtmlEncode($this->IBS_SETMARKING->CurrentValue);
			$this->IBS_SETMARKING->PlaceHolder = ew_RemoveHtml($this->IBS_SETMARKING->FldCaption());

			// IBS_PATOLOGI
			$this->IBS_PATOLOGI->EditAttrs["class"] = "form-control";
			$this->IBS_PATOLOGI->EditCustomAttributes = "";
			$this->IBS_PATOLOGI->EditValue = ew_HtmlEncode($this->IBS_PATOLOGI->CurrentValue);
			$this->IBS_PATOLOGI->PlaceHolder = ew_RemoveHtml($this->IBS_PATOLOGI->FldCaption());

			// IBS_JENISANESTESI
			$this->IBS_JENISANESTESI->EditAttrs["class"] = "form-control";
			$this->IBS_JENISANESTESI->EditCustomAttributes = "";
			$this->IBS_JENISANESTESI->EditValue = ew_HtmlEncode($this->IBS_JENISANESTESI->CurrentValue);
			$this->IBS_JENISANESTESI->PlaceHolder = ew_RemoveHtml($this->IBS_JENISANESTESI->FldCaption());

			// IBS_NO_OK
			$this->IBS_NO_OK->EditAttrs["class"] = "form-control";
			$this->IBS_NO_OK->EditCustomAttributes = "";
			$this->IBS_NO_OK->EditValue = ew_HtmlEncode($this->IBS_NO_OK->CurrentValue);
			$this->IBS_NO_OK->PlaceHolder = ew_RemoveHtml($this->IBS_NO_OK->FldCaption());

			// IBS_ASISSTEN
			$this->IBS_ASISSTEN->EditAttrs["class"] = "form-control";
			$this->IBS_ASISSTEN->EditCustomAttributes = "";
			$this->IBS_ASISSTEN->EditValue = ew_HtmlEncode($this->IBS_ASISSTEN->CurrentValue);
			$this->IBS_ASISSTEN->PlaceHolder = ew_RemoveHtml($this->IBS_ASISSTEN->FldCaption());

			// IBS_JAM_ELEFTIF
			$this->IBS_JAM_ELEFTIF->EditAttrs["class"] = "form-control";
			$this->IBS_JAM_ELEFTIF->EditCustomAttributes = "";
			$this->IBS_JAM_ELEFTIF->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->IBS_JAM_ELEFTIF->CurrentValue, 8));
			$this->IBS_JAM_ELEFTIF->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_ELEFTIF->FldCaption());

			// IBS_JAM_ELEKTIF_SELESAI
			$this->IBS_JAM_ELEKTIF_SELESAI->EditAttrs["class"] = "form-control";
			$this->IBS_JAM_ELEKTIF_SELESAI->EditCustomAttributes = "";
			$this->IBS_JAM_ELEKTIF_SELESAI->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue, 8));
			$this->IBS_JAM_ELEKTIF_SELESAI->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_ELEKTIF_SELESAI->FldCaption());

			// IBS_JAM_CYTO
			$this->IBS_JAM_CYTO->EditAttrs["class"] = "form-control";
			$this->IBS_JAM_CYTO->EditCustomAttributes = "";
			$this->IBS_JAM_CYTO->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->IBS_JAM_CYTO->CurrentValue, 8));
			$this->IBS_JAM_CYTO->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_CYTO->FldCaption());

			// IBS_JAM_CYTO_SELESAI
			$this->IBS_JAM_CYTO_SELESAI->EditAttrs["class"] = "form-control";
			$this->IBS_JAM_CYTO_SELESAI->EditCustomAttributes = "";
			$this->IBS_JAM_CYTO_SELESAI->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->IBS_JAM_CYTO_SELESAI->CurrentValue, 8));
			$this->IBS_JAM_CYTO_SELESAI->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_CYTO_SELESAI->FldCaption());

			// IBS_TGL_DFTR_OP
			$this->IBS_TGL_DFTR_OP->EditAttrs["class"] = "form-control";
			$this->IBS_TGL_DFTR_OP->EditCustomAttributes = "";
			$this->IBS_TGL_DFTR_OP->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->IBS_TGL_DFTR_OP->CurrentValue, 8));
			$this->IBS_TGL_DFTR_OP->PlaceHolder = ew_RemoveHtml($this->IBS_TGL_DFTR_OP->FldCaption());

			// IBS_TGL_OP
			$this->IBS_TGL_OP->EditAttrs["class"] = "form-control";
			$this->IBS_TGL_OP->EditCustomAttributes = "";
			$this->IBS_TGL_OP->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->IBS_TGL_OP->CurrentValue, 8));
			$this->IBS_TGL_OP->PlaceHolder = ew_RemoveHtml($this->IBS_TGL_OP->FldCaption());

			// grup_ruang_id
			$this->grup_ruang_id->EditAttrs["class"] = "form-control";
			$this->grup_ruang_id->EditCustomAttributes = "";
			$this->grup_ruang_id->EditValue = ew_HtmlEncode($this->grup_ruang_id->CurrentValue);
			$this->grup_ruang_id->PlaceHolder = ew_RemoveHtml($this->grup_ruang_id->FldCaption());

			// status_order_ibs
			$this->status_order_ibs->EditAttrs["class"] = "form-control";
			$this->status_order_ibs->EditCustomAttributes = "";
			$this->status_order_ibs->EditValue = ew_HtmlEncode($this->status_order_ibs->CurrentValue);
			$this->status_order_ibs->PlaceHolder = ew_RemoveHtml($this->status_order_ibs->FldCaption());

			// Add refer script
			// id_admission

			$this->id_admission->LinkCustomAttributes = "";
			$this->id_admission->HrefValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";

			// ket_nama
			$this->ket_nama->LinkCustomAttributes = "";
			$this->ket_nama->HrefValue = "";

			// ket_tgllahir
			$this->ket_tgllahir->LinkCustomAttributes = "";
			$this->ket_tgllahir->HrefValue = "";

			// ket_alamat
			$this->ket_alamat->LinkCustomAttributes = "";
			$this->ket_alamat->HrefValue = "";

			// parent_nomr
			$this->parent_nomr->LinkCustomAttributes = "";
			$this->parent_nomr->HrefValue = "";

			// dokterpengirim
			$this->dokterpengirim->LinkCustomAttributes = "";
			$this->dokterpengirim->HrefValue = "";

			// statusbayar
			$this->statusbayar->LinkCustomAttributes = "";
			$this->statusbayar->HrefValue = "";

			// kirimdari
			$this->kirimdari->LinkCustomAttributes = "";
			$this->kirimdari->HrefValue = "";

			// keluargadekat
			$this->keluargadekat->LinkCustomAttributes = "";
			$this->keluargadekat->HrefValue = "";

			// panggungjawab
			$this->panggungjawab->LinkCustomAttributes = "";
			$this->panggungjawab->HrefValue = "";

			// masukrs
			$this->masukrs->LinkCustomAttributes = "";
			$this->masukrs->HrefValue = "";

			// noruang
			$this->noruang->LinkCustomAttributes = "";
			$this->noruang->HrefValue = "";

			// tempat_tidur_id
			$this->tempat_tidur_id->LinkCustomAttributes = "";
			$this->tempat_tidur_id->HrefValue = "";

			// nott
			$this->nott->LinkCustomAttributes = "";
			$this->nott->HrefValue = "";

			// deposit
			$this->deposit->LinkCustomAttributes = "";
			$this->deposit->HrefValue = "";

			// keluarrs
			$this->keluarrs->LinkCustomAttributes = "";
			$this->keluarrs->HrefValue = "";

			// icd_masuk
			$this->icd_masuk->LinkCustomAttributes = "";
			$this->icd_masuk->HrefValue = "";

			// icd_keluar
			$this->icd_keluar->LinkCustomAttributes = "";
			$this->icd_keluar->HrefValue = "";

			// NIP
			$this->NIP->LinkCustomAttributes = "";
			$this->NIP->HrefValue = "";

			// noruang_asal
			$this->noruang_asal->LinkCustomAttributes = "";
			$this->noruang_asal->HrefValue = "";

			// nott_asal
			$this->nott_asal->LinkCustomAttributes = "";
			$this->nott_asal->HrefValue = "";

			// tgl_pindah
			$this->tgl_pindah->LinkCustomAttributes = "";
			$this->tgl_pindah->HrefValue = "";

			// kd_rujuk
			$this->kd_rujuk->LinkCustomAttributes = "";
			$this->kd_rujuk->HrefValue = "";

			// st_bayar
			$this->st_bayar->LinkCustomAttributes = "";
			$this->st_bayar->HrefValue = "";

			// dokter_penanggungjawab
			$this->dokter_penanggungjawab->LinkCustomAttributes = "";
			$this->dokter_penanggungjawab->HrefValue = "";

			// perawat
			$this->perawat->LinkCustomAttributes = "";
			$this->perawat->HrefValue = "";

			// KELASPERAWATAN_ID
			$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
			$this->KELASPERAWATAN_ID->HrefValue = "";

			// LOS
			$this->LOS->LinkCustomAttributes = "";
			$this->LOS->HrefValue = "";

			// TOT_TRF_TIND_DOKTER
			$this->TOT_TRF_TIND_DOKTER->LinkCustomAttributes = "";
			$this->TOT_TRF_TIND_DOKTER->HrefValue = "";

			// TOT_BHP_DOKTER
			$this->TOT_BHP_DOKTER->LinkCustomAttributes = "";
			$this->TOT_BHP_DOKTER->HrefValue = "";

			// TOT_TRF_PERAWAT
			$this->TOT_TRF_PERAWAT->LinkCustomAttributes = "";
			$this->TOT_TRF_PERAWAT->HrefValue = "";

			// TOT_BHP_PERAWAT
			$this->TOT_BHP_PERAWAT->LinkCustomAttributes = "";
			$this->TOT_BHP_PERAWAT->HrefValue = "";

			// TOT_TRF_DOKTER
			$this->TOT_TRF_DOKTER->LinkCustomAttributes = "";
			$this->TOT_TRF_DOKTER->HrefValue = "";

			// TOT_BIAYA_RAD
			$this->TOT_BIAYA_RAD->LinkCustomAttributes = "";
			$this->TOT_BIAYA_RAD->HrefValue = "";

			// TOT_BIAYA_CDRPOLI
			$this->TOT_BIAYA_CDRPOLI->LinkCustomAttributes = "";
			$this->TOT_BIAYA_CDRPOLI->HrefValue = "";

			// TOT_BIAYA_LAB_IGD
			$this->TOT_BIAYA_LAB_IGD->LinkCustomAttributes = "";
			$this->TOT_BIAYA_LAB_IGD->HrefValue = "";

			// TOT_BIAYA_OKSIGEN
			$this->TOT_BIAYA_OKSIGEN->LinkCustomAttributes = "";
			$this->TOT_BIAYA_OKSIGEN->HrefValue = "";

			// TOTAL_BIAYA_OBAT
			$this->TOTAL_BIAYA_OBAT->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_OBAT->HrefValue = "";

			// LINK_SET_KELAS
			$this->LINK_SET_KELAS->LinkCustomAttributes = "";
			$this->LINK_SET_KELAS->HrefValue = "";

			// biaya_obat
			$this->biaya_obat->LinkCustomAttributes = "";
			$this->biaya_obat->HrefValue = "";

			// biaya_retur_obat
			$this->biaya_retur_obat->LinkCustomAttributes = "";
			$this->biaya_retur_obat->HrefValue = "";

			// TOT_BIAYA_GIZI
			$this->TOT_BIAYA_GIZI->LinkCustomAttributes = "";
			$this->TOT_BIAYA_GIZI->HrefValue = "";

			// TOT_BIAYA_TMO
			$this->TOT_BIAYA_TMO->LinkCustomAttributes = "";
			$this->TOT_BIAYA_TMO->HrefValue = "";

			// TOT_BIAYA_AMBULAN
			$this->TOT_BIAYA_AMBULAN->LinkCustomAttributes = "";
			$this->TOT_BIAYA_AMBULAN->HrefValue = "";

			// TOT_BIAYA_FISIO
			$this->TOT_BIAYA_FISIO->LinkCustomAttributes = "";
			$this->TOT_BIAYA_FISIO->HrefValue = "";

			// TOT_BIAYA_LAINLAIN
			$this->TOT_BIAYA_LAINLAIN->LinkCustomAttributes = "";
			$this->TOT_BIAYA_LAINLAIN->HrefValue = "";

			// jenisperawatan_id
			$this->jenisperawatan_id->LinkCustomAttributes = "";
			$this->jenisperawatan_id->HrefValue = "";

			// status_transaksi
			$this->status_transaksi->LinkCustomAttributes = "";
			$this->status_transaksi->HrefValue = "";

			// statuskeluarranap_id
			$this->statuskeluarranap_id->LinkCustomAttributes = "";
			$this->statuskeluarranap_id->HrefValue = "";

			// TOT_BIAYA_AKOMODASI
			$this->TOT_BIAYA_AKOMODASI->LinkCustomAttributes = "";
			$this->TOT_BIAYA_AKOMODASI->HrefValue = "";

			// TOTAL_BIAYA_ASKEP
			$this->TOTAL_BIAYA_ASKEP->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_ASKEP->HrefValue = "";

			// TOTAL_BIAYA_SIMRS
			$this->TOTAL_BIAYA_SIMRS->LinkCustomAttributes = "";
			$this->TOTAL_BIAYA_SIMRS->HrefValue = "";

			// TOT_PENJ_NMEDIS
			$this->TOT_PENJ_NMEDIS->LinkCustomAttributes = "";
			$this->TOT_PENJ_NMEDIS->HrefValue = "";

			// LINK_MASTERDETAIL
			$this->LINK_MASTERDETAIL->LinkCustomAttributes = "";
			$this->LINK_MASTERDETAIL->HrefValue = "";

			// NO_SKP
			$this->NO_SKP->LinkCustomAttributes = "";
			$this->NO_SKP->HrefValue = "";

			// LINK_PELAYANAN_OBAT
			$this->LINK_PELAYANAN_OBAT->LinkCustomAttributes = "";
			$this->LINK_PELAYANAN_OBAT->HrefValue = "";

			// TOT_TIND_RAJAL
			$this->TOT_TIND_RAJAL->LinkCustomAttributes = "";
			$this->TOT_TIND_RAJAL->HrefValue = "";

			// TOT_TIND_IGD
			$this->TOT_TIND_IGD->LinkCustomAttributes = "";
			$this->TOT_TIND_IGD->HrefValue = "";

			// tanggal_pengembalian_status
			$this->tanggal_pengembalian_status->LinkCustomAttributes = "";
			$this->tanggal_pengembalian_status->HrefValue = "";

			// naik_kelas
			$this->naik_kelas->LinkCustomAttributes = "";
			$this->naik_kelas->HrefValue = "";

			// iuran_kelas_lama
			$this->iuran_kelas_lama->LinkCustomAttributes = "";
			$this->iuran_kelas_lama->HrefValue = "";

			// iuran_kelas_baru
			$this->iuran_kelas_baru->LinkCustomAttributes = "";
			$this->iuran_kelas_baru->HrefValue = "";

			// ketrangan_naik_kelas
			$this->ketrangan_naik_kelas->LinkCustomAttributes = "";
			$this->ketrangan_naik_kelas->HrefValue = "";

			// tgl_pengiriman_ad_klaim
			$this->tgl_pengiriman_ad_klaim->LinkCustomAttributes = "";
			$this->tgl_pengiriman_ad_klaim->HrefValue = "";

			// diagnosa_keluar
			$this->diagnosa_keluar->LinkCustomAttributes = "";
			$this->diagnosa_keluar->HrefValue = "";

			// sep_tglsep
			$this->sep_tglsep->LinkCustomAttributes = "";
			$this->sep_tglsep->HrefValue = "";

			// sep_tglrujuk
			$this->sep_tglrujuk->LinkCustomAttributes = "";
			$this->sep_tglrujuk->HrefValue = "";

			// sep_kodekelasrawat
			$this->sep_kodekelasrawat->LinkCustomAttributes = "";
			$this->sep_kodekelasrawat->HrefValue = "";

			// sep_norujukan
			$this->sep_norujukan->LinkCustomAttributes = "";
			$this->sep_norujukan->HrefValue = "";

			// sep_kodeppkasal
			$this->sep_kodeppkasal->LinkCustomAttributes = "";
			$this->sep_kodeppkasal->HrefValue = "";

			// sep_namappkasal
			$this->sep_namappkasal->LinkCustomAttributes = "";
			$this->sep_namappkasal->HrefValue = "";

			// sep_kodeppkpelayanan
			$this->sep_kodeppkpelayanan->LinkCustomAttributes = "";
			$this->sep_kodeppkpelayanan->HrefValue = "";

			// sep_namappkpelayanan
			$this->sep_namappkpelayanan->LinkCustomAttributes = "";
			$this->sep_namappkpelayanan->HrefValue = "";

			// t_admissioncol
			$this->t_admissioncol->LinkCustomAttributes = "";
			$this->t_admissioncol->HrefValue = "";

			// sep_jenisperawatan
			$this->sep_jenisperawatan->LinkCustomAttributes = "";
			$this->sep_jenisperawatan->HrefValue = "";

			// sep_catatan
			$this->sep_catatan->LinkCustomAttributes = "";
			$this->sep_catatan->HrefValue = "";

			// sep_kodediagnosaawal
			$this->sep_kodediagnosaawal->LinkCustomAttributes = "";
			$this->sep_kodediagnosaawal->HrefValue = "";

			// sep_namadiagnosaawal
			$this->sep_namadiagnosaawal->LinkCustomAttributes = "";
			$this->sep_namadiagnosaawal->HrefValue = "";

			// sep_lakalantas
			$this->sep_lakalantas->LinkCustomAttributes = "";
			$this->sep_lakalantas->HrefValue = "";

			// sep_lokasilaka
			$this->sep_lokasilaka->LinkCustomAttributes = "";
			$this->sep_lokasilaka->HrefValue = "";

			// sep_user
			$this->sep_user->LinkCustomAttributes = "";
			$this->sep_user->HrefValue = "";

			// sep_flag_cekpeserta
			$this->sep_flag_cekpeserta->LinkCustomAttributes = "";
			$this->sep_flag_cekpeserta->HrefValue = "";

			// sep_flag_generatesep
			$this->sep_flag_generatesep->LinkCustomAttributes = "";
			$this->sep_flag_generatesep->HrefValue = "";

			// sep_flag_mapingsep
			$this->sep_flag_mapingsep->LinkCustomAttributes = "";
			$this->sep_flag_mapingsep->HrefValue = "";

			// sep_nik
			$this->sep_nik->LinkCustomAttributes = "";
			$this->sep_nik->HrefValue = "";

			// sep_namapeserta
			$this->sep_namapeserta->LinkCustomAttributes = "";
			$this->sep_namapeserta->HrefValue = "";

			// sep_jeniskelamin
			$this->sep_jeniskelamin->LinkCustomAttributes = "";
			$this->sep_jeniskelamin->HrefValue = "";

			// sep_pisat
			$this->sep_pisat->LinkCustomAttributes = "";
			$this->sep_pisat->HrefValue = "";

			// sep_tgllahir
			$this->sep_tgllahir->LinkCustomAttributes = "";
			$this->sep_tgllahir->HrefValue = "";

			// sep_kodejeniskepesertaan
			$this->sep_kodejeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_kodejeniskepesertaan->HrefValue = "";

			// sep_namajeniskepesertaan
			$this->sep_namajeniskepesertaan->LinkCustomAttributes = "";
			$this->sep_namajeniskepesertaan->HrefValue = "";

			// sep_kodepolitujuan
			$this->sep_kodepolitujuan->LinkCustomAttributes = "";
			$this->sep_kodepolitujuan->HrefValue = "";

			// sep_namapolitujuan
			$this->sep_namapolitujuan->LinkCustomAttributes = "";
			$this->sep_namapolitujuan->HrefValue = "";

			// ket_jeniskelamin
			$this->ket_jeniskelamin->LinkCustomAttributes = "";
			$this->ket_jeniskelamin->HrefValue = "";

			// sep_nokabpjs
			$this->sep_nokabpjs->LinkCustomAttributes = "";
			$this->sep_nokabpjs->HrefValue = "";

			// counter_cetak_sep
			$this->counter_cetak_sep->LinkCustomAttributes = "";
			$this->counter_cetak_sep->HrefValue = "";

			// sep_petugas_hapus_sep
			$this->sep_petugas_hapus_sep->LinkCustomAttributes = "";
			$this->sep_petugas_hapus_sep->HrefValue = "";

			// sep_petugas_set_tgl_pulang
			$this->sep_petugas_set_tgl_pulang->LinkCustomAttributes = "";
			$this->sep_petugas_set_tgl_pulang->HrefValue = "";

			// sep_jam_generate_sep
			$this->sep_jam_generate_sep->LinkCustomAttributes = "";
			$this->sep_jam_generate_sep->HrefValue = "";

			// sep_status_peserta
			$this->sep_status_peserta->LinkCustomAttributes = "";
			$this->sep_status_peserta->HrefValue = "";

			// sep_umur_pasien_sekarang
			$this->sep_umur_pasien_sekarang->LinkCustomAttributes = "";
			$this->sep_umur_pasien_sekarang->HrefValue = "";

			// ket_title
			$this->ket_title->LinkCustomAttributes = "";
			$this->ket_title->HrefValue = "";

			// status_daftar_ranap
			$this->status_daftar_ranap->LinkCustomAttributes = "";
			$this->status_daftar_ranap->HrefValue = "";

			// IBS_SETMARKING
			$this->IBS_SETMARKING->LinkCustomAttributes = "";
			$this->IBS_SETMARKING->HrefValue = "";

			// IBS_PATOLOGI
			$this->IBS_PATOLOGI->LinkCustomAttributes = "";
			$this->IBS_PATOLOGI->HrefValue = "";

			// IBS_JENISANESTESI
			$this->IBS_JENISANESTESI->LinkCustomAttributes = "";
			$this->IBS_JENISANESTESI->HrefValue = "";

			// IBS_NO_OK
			$this->IBS_NO_OK->LinkCustomAttributes = "";
			$this->IBS_NO_OK->HrefValue = "";

			// IBS_ASISSTEN
			$this->IBS_ASISSTEN->LinkCustomAttributes = "";
			$this->IBS_ASISSTEN->HrefValue = "";

			// IBS_JAM_ELEFTIF
			$this->IBS_JAM_ELEFTIF->LinkCustomAttributes = "";
			$this->IBS_JAM_ELEFTIF->HrefValue = "";

			// IBS_JAM_ELEKTIF_SELESAI
			$this->IBS_JAM_ELEKTIF_SELESAI->LinkCustomAttributes = "";
			$this->IBS_JAM_ELEKTIF_SELESAI->HrefValue = "";

			// IBS_JAM_CYTO
			$this->IBS_JAM_CYTO->LinkCustomAttributes = "";
			$this->IBS_JAM_CYTO->HrefValue = "";

			// IBS_JAM_CYTO_SELESAI
			$this->IBS_JAM_CYTO_SELESAI->LinkCustomAttributes = "";
			$this->IBS_JAM_CYTO_SELESAI->HrefValue = "";

			// IBS_TGL_DFTR_OP
			$this->IBS_TGL_DFTR_OP->LinkCustomAttributes = "";
			$this->IBS_TGL_DFTR_OP->HrefValue = "";

			// IBS_TGL_OP
			$this->IBS_TGL_OP->LinkCustomAttributes = "";
			$this->IBS_TGL_OP->HrefValue = "";

			// grup_ruang_id
			$this->grup_ruang_id->LinkCustomAttributes = "";
			$this->grup_ruang_id->HrefValue = "";

			// status_order_ibs
			$this->status_order_ibs->LinkCustomAttributes = "";
			$this->status_order_ibs->HrefValue = "";
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
		if (!$this->id_admission->FldIsDetailKey && !is_null($this->id_admission->FormValue) && $this->id_admission->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->id_admission->FldCaption(), $this->id_admission->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->id_admission->FormValue)) {
			ew_AddMessage($gsFormError, $this->id_admission->FldErrMsg());
		}
		if (!$this->nomr->FldIsDetailKey && !is_null($this->nomr->FormValue) && $this->nomr->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomr->FldCaption(), $this->nomr->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->ket_tgllahir->FormValue)) {
			ew_AddMessage($gsFormError, $this->ket_tgllahir->FldErrMsg());
		}
		if (!$this->dokterpengirim->FldIsDetailKey && !is_null($this->dokterpengirim->FormValue) && $this->dokterpengirim->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dokterpengirim->FldCaption(), $this->dokterpengirim->ReqErrMsg));
		}
		if (!$this->statusbayar->FldIsDetailKey && !is_null($this->statusbayar->FormValue) && $this->statusbayar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->statusbayar->FldCaption(), $this->statusbayar->ReqErrMsg));
		}
		if (!$this->kirimdari->FldIsDetailKey && !is_null($this->kirimdari->FormValue) && $this->kirimdari->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kirimdari->FldCaption(), $this->kirimdari->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->kirimdari->FormValue)) {
			ew_AddMessage($gsFormError, $this->kirimdari->FldErrMsg());
		}
		if (!$this->keluargadekat->FldIsDetailKey && !is_null($this->keluargadekat->FormValue) && $this->keluargadekat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->keluargadekat->FldCaption(), $this->keluargadekat->ReqErrMsg));
		}
		if (!$this->panggungjawab->FldIsDetailKey && !is_null($this->panggungjawab->FormValue) && $this->panggungjawab->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->panggungjawab->FldCaption(), $this->panggungjawab->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->masukrs->FormValue)) {
			ew_AddMessage($gsFormError, $this->masukrs->FldErrMsg());
		}
		if (!$this->noruang->FldIsDetailKey && !is_null($this->noruang->FormValue) && $this->noruang->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->noruang->FldCaption(), $this->noruang->ReqErrMsg));
		}
		if (!$this->tempat_tidur_id->FldIsDetailKey && !is_null($this->tempat_tidur_id->FormValue) && $this->tempat_tidur_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tempat_tidur_id->FldCaption(), $this->tempat_tidur_id->ReqErrMsg));
		}
		if (!$this->nott->FldIsDetailKey && !is_null($this->nott->FormValue) && $this->nott->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nott->FldCaption(), $this->nott->ReqErrMsg));
		}
		if (!$this->deposit->FldIsDetailKey && !is_null($this->deposit->FormValue) && $this->deposit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->deposit->FldCaption(), $this->deposit->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->deposit->FormValue)) {
			ew_AddMessage($gsFormError, $this->deposit->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->keluarrs->FormValue)) {
			ew_AddMessage($gsFormError, $this->keluarrs->FldErrMsg());
		}
		if (!$this->icd_masuk->FldIsDetailKey && !is_null($this->icd_masuk->FormValue) && $this->icd_masuk->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->icd_masuk->FldCaption(), $this->icd_masuk->ReqErrMsg));
		}
		if (!$this->NIP->FldIsDetailKey && !is_null($this->NIP->FormValue) && $this->NIP->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NIP->FldCaption(), $this->NIP->ReqErrMsg));
		}
		if (!$this->noruang_asal->FldIsDetailKey && !is_null($this->noruang_asal->FormValue) && $this->noruang_asal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->noruang_asal->FldCaption(), $this->noruang_asal->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->noruang_asal->FormValue)) {
			ew_AddMessage($gsFormError, $this->noruang_asal->FldErrMsg());
		}
		if (!$this->nott_asal->FldIsDetailKey && !is_null($this->nott_asal->FormValue) && $this->nott_asal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nott_asal->FldCaption(), $this->nott_asal->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->nott_asal->FormValue)) {
			ew_AddMessage($gsFormError, $this->nott_asal->FldErrMsg());
		}
		if (!$this->tgl_pindah->FldIsDetailKey && !is_null($this->tgl_pindah->FormValue) && $this->tgl_pindah->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tgl_pindah->FldCaption(), $this->tgl_pindah->ReqErrMsg));
		}
		if (!ew_CheckDateDef($this->tgl_pindah->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_pindah->FldErrMsg());
		}
		if (!$this->kd_rujuk->FldIsDetailKey && !is_null($this->kd_rujuk->FormValue) && $this->kd_rujuk->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->kd_rujuk->FldCaption(), $this->kd_rujuk->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->st_bayar->FormValue)) {
			ew_AddMessage($gsFormError, $this->st_bayar->FldErrMsg());
		}
		if (!$this->dokter_penanggungjawab->FldIsDetailKey && !is_null($this->dokter_penanggungjawab->FormValue) && $this->dokter_penanggungjawab->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dokter_penanggungjawab->FldCaption(), $this->dokter_penanggungjawab->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->perawat->FormValue)) {
			ew_AddMessage($gsFormError, $this->perawat->FldErrMsg());
		}
		if (!$this->KELASPERAWATAN_ID->FldIsDetailKey && !is_null($this->KELASPERAWATAN_ID->FormValue) && $this->KELASPERAWATAN_ID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->KELASPERAWATAN_ID->FldCaption(), $this->KELASPERAWATAN_ID->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->LOS->FormValue)) {
			ew_AddMessage($gsFormError, $this->LOS->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_TRF_TIND_DOKTER->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_TRF_TIND_DOKTER->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BHP_DOKTER->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BHP_DOKTER->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_TRF_PERAWAT->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_TRF_PERAWAT->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BHP_PERAWAT->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BHP_PERAWAT->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_TRF_DOKTER->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_TRF_DOKTER->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_RAD->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_RAD->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_CDRPOLI->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_CDRPOLI->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_LAB_IGD->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_LAB_IGD->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_OKSIGEN->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_OKSIGEN->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOTAL_BIAYA_OBAT->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOTAL_BIAYA_OBAT->FldErrMsg());
		}
		if (!ew_CheckNumber($this->biaya_obat->FormValue)) {
			ew_AddMessage($gsFormError, $this->biaya_obat->FldErrMsg());
		}
		if (!ew_CheckNumber($this->biaya_retur_obat->FormValue)) {
			ew_AddMessage($gsFormError, $this->biaya_retur_obat->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_GIZI->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_GIZI->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_TMO->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_TMO->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_AMBULAN->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_AMBULAN->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_FISIO->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_FISIO->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_LAINLAIN->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_LAINLAIN->FldErrMsg());
		}
		if (!ew_CheckInteger($this->jenisperawatan_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->jenisperawatan_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->status_transaksi->FormValue)) {
			ew_AddMessage($gsFormError, $this->status_transaksi->FldErrMsg());
		}
		if (!ew_CheckInteger($this->statuskeluarranap_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->statuskeluarranap_id->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_BIAYA_AKOMODASI->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_BIAYA_AKOMODASI->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOTAL_BIAYA_ASKEP->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOTAL_BIAYA_ASKEP->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOTAL_BIAYA_SIMRS->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOTAL_BIAYA_SIMRS->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_PENJ_NMEDIS->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_PENJ_NMEDIS->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_TIND_RAJAL->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_TIND_RAJAL->FldErrMsg());
		}
		if (!ew_CheckNumber($this->TOT_TIND_IGD->FormValue)) {
			ew_AddMessage($gsFormError, $this->TOT_TIND_IGD->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tanggal_pengembalian_status->FormValue)) {
			ew_AddMessage($gsFormError, $this->tanggal_pengembalian_status->FldErrMsg());
		}
		if (!ew_CheckInteger($this->naik_kelas->FormValue)) {
			ew_AddMessage($gsFormError, $this->naik_kelas->FldErrMsg());
		}
		if (!ew_CheckNumber($this->iuran_kelas_lama->FormValue)) {
			ew_AddMessage($gsFormError, $this->iuran_kelas_lama->FldErrMsg());
		}
		if (!ew_CheckNumber($this->iuran_kelas_baru->FormValue)) {
			ew_AddMessage($gsFormError, $this->iuran_kelas_baru->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->tgl_pengiriman_ad_klaim->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_pengiriman_ad_klaim->FldErrMsg());
		}
		if (!ew_CheckInteger($this->diagnosa_keluar->FormValue)) {
			ew_AddMessage($gsFormError, $this->diagnosa_keluar->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->sep_tglsep->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_tglsep->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->sep_tglrujuk->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_tglrujuk->FldErrMsg());
		}
		if (!ew_CheckInteger($this->sep_jenisperawatan->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_jenisperawatan->FldErrMsg());
		}
		if (!ew_CheckInteger($this->sep_lakalantas->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_lakalantas->FldErrMsg());
		}
		if (!ew_CheckInteger($this->sep_flag_cekpeserta->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_flag_cekpeserta->FldErrMsg());
		}
		if (!ew_CheckInteger($this->sep_flag_generatesep->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_flag_generatesep->FldErrMsg());
		}
		if (!ew_CheckInteger($this->sep_flag_mapingsep->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_flag_mapingsep->FldErrMsg());
		}
		if (!ew_CheckInteger($this->counter_cetak_sep->FormValue)) {
			ew_AddMessage($gsFormError, $this->counter_cetak_sep->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->sep_jam_generate_sep->FormValue)) {
			ew_AddMessage($gsFormError, $this->sep_jam_generate_sep->FldErrMsg());
		}
		if (!ew_CheckInteger($this->status_daftar_ranap->FormValue)) {
			ew_AddMessage($gsFormError, $this->status_daftar_ranap->FldErrMsg());
		}
		if (!ew_CheckInteger($this->IBS_SETMARKING->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_SETMARKING->FldErrMsg());
		}
		if (!ew_CheckInteger($this->IBS_PATOLOGI->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_PATOLOGI->FldErrMsg());
		}
		if (!ew_CheckInteger($this->IBS_JENISANESTESI->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_JENISANESTESI->FldErrMsg());
		}
		if (!ew_CheckInteger($this->IBS_NO_OK->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_NO_OK->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->IBS_JAM_ELEFTIF->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_JAM_ELEFTIF->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->IBS_JAM_ELEKTIF_SELESAI->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_JAM_ELEKTIF_SELESAI->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->IBS_JAM_CYTO->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_JAM_CYTO->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->IBS_JAM_CYTO_SELESAI->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_JAM_CYTO_SELESAI->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->IBS_TGL_DFTR_OP->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_TGL_DFTR_OP->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->IBS_TGL_OP->FormValue)) {
			ew_AddMessage($gsFormError, $this->IBS_TGL_OP->FldErrMsg());
		}
		if (!ew_CheckInteger($this->grup_ruang_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->grup_ruang_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->status_order_ibs->FormValue)) {
			ew_AddMessage($gsFormError, $this->status_order_ibs->FldErrMsg());
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

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// id_admission
		$this->id_admission->SetDbValueDef($rsnew, $this->id_admission->CurrentValue, 0, FALSE);

		// nomr
		$this->nomr->SetDbValueDef($rsnew, $this->nomr->CurrentValue, "", FALSE);

		// ket_nama
		$this->ket_nama->SetDbValueDef($rsnew, $this->ket_nama->CurrentValue, NULL, FALSE);

		// ket_tgllahir
		$this->ket_tgllahir->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->ket_tgllahir->CurrentValue, 0), NULL, FALSE);

		// ket_alamat
		$this->ket_alamat->SetDbValueDef($rsnew, $this->ket_alamat->CurrentValue, NULL, FALSE);

		// parent_nomr
		$this->parent_nomr->SetDbValueDef($rsnew, $this->parent_nomr->CurrentValue, NULL, FALSE);

		// dokterpengirim
		$this->dokterpengirim->SetDbValueDef($rsnew, $this->dokterpengirim->CurrentValue, 0, FALSE);

		// statusbayar
		$this->statusbayar->SetDbValueDef($rsnew, $this->statusbayar->CurrentValue, 0, FALSE);

		// kirimdari
		$this->kirimdari->SetDbValueDef($rsnew, $this->kirimdari->CurrentValue, 0, FALSE);

		// keluargadekat
		$this->keluargadekat->SetDbValueDef($rsnew, $this->keluargadekat->CurrentValue, "", FALSE);

		// panggungjawab
		$this->panggungjawab->SetDbValueDef($rsnew, $this->panggungjawab->CurrentValue, "", FALSE);

		// masukrs
		$this->masukrs->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->masukrs->CurrentValue, 11), NULL, FALSE);

		// noruang
		$this->noruang->SetDbValueDef($rsnew, $this->noruang->CurrentValue, 0, FALSE);

		// tempat_tidur_id
		$this->tempat_tidur_id->SetDbValueDef($rsnew, $this->tempat_tidur_id->CurrentValue, 0, FALSE);

		// nott
		$this->nott->SetDbValueDef($rsnew, $this->nott->CurrentValue, "", FALSE);

		// deposit
		$this->deposit->SetDbValueDef($rsnew, $this->deposit->CurrentValue, 0, FALSE);

		// keluarrs
		$this->keluarrs->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->keluarrs->CurrentValue, 0), NULL, FALSE);

		// icd_masuk
		$this->icd_masuk->SetDbValueDef($rsnew, $this->icd_masuk->CurrentValue, NULL, FALSE);

		// icd_keluar
		$this->icd_keluar->SetDbValueDef($rsnew, $this->icd_keluar->CurrentValue, NULL, FALSE);

		// NIP
		$this->NIP->SetDbValueDef($rsnew, $this->NIP->CurrentValue, "", FALSE);

		// noruang_asal
		$this->noruang_asal->SetDbValueDef($rsnew, $this->noruang_asal->CurrentValue, 0, FALSE);

		// nott_asal
		$this->nott_asal->SetDbValueDef($rsnew, $this->nott_asal->CurrentValue, 0, FALSE);

		// tgl_pindah
		$this->tgl_pindah->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_pindah->CurrentValue, 0), ew_CurrentDate(), FALSE);

		// kd_rujuk
		$this->kd_rujuk->SetDbValueDef($rsnew, $this->kd_rujuk->CurrentValue, 0, FALSE);

		// st_bayar
		$this->st_bayar->SetDbValueDef($rsnew, $this->st_bayar->CurrentValue, NULL, FALSE);

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->SetDbValueDef($rsnew, $this->dokter_penanggungjawab->CurrentValue, 0, FALSE);

		// perawat
		$this->perawat->SetDbValueDef($rsnew, $this->perawat->CurrentValue, NULL, FALSE);

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->SetDbValueDef($rsnew, $this->KELASPERAWATAN_ID->CurrentValue, NULL, FALSE);

		// LOS
		$this->LOS->SetDbValueDef($rsnew, $this->LOS->CurrentValue, NULL, strval($this->LOS->CurrentValue) == "");

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER->SetDbValueDef($rsnew, $this->TOT_TRF_TIND_DOKTER->CurrentValue, NULL, strval($this->TOT_TRF_TIND_DOKTER->CurrentValue) == "");

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER->SetDbValueDef($rsnew, $this->TOT_BHP_DOKTER->CurrentValue, NULL, strval($this->TOT_BHP_DOKTER->CurrentValue) == "");

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT->SetDbValueDef($rsnew, $this->TOT_TRF_PERAWAT->CurrentValue, NULL, strval($this->TOT_TRF_PERAWAT->CurrentValue) == "");

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT->SetDbValueDef($rsnew, $this->TOT_BHP_PERAWAT->CurrentValue, NULL, strval($this->TOT_BHP_PERAWAT->CurrentValue) == "");

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER->SetDbValueDef($rsnew, $this->TOT_TRF_DOKTER->CurrentValue, NULL, strval($this->TOT_TRF_DOKTER->CurrentValue) == "");

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD->SetDbValueDef($rsnew, $this->TOT_BIAYA_RAD->CurrentValue, NULL, strval($this->TOT_BIAYA_RAD->CurrentValue) == "");

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI->SetDbValueDef($rsnew, $this->TOT_BIAYA_CDRPOLI->CurrentValue, NULL, strval($this->TOT_BIAYA_CDRPOLI->CurrentValue) == "");

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD->SetDbValueDef($rsnew, $this->TOT_BIAYA_LAB_IGD->CurrentValue, NULL, strval($this->TOT_BIAYA_LAB_IGD->CurrentValue) == "");

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN->SetDbValueDef($rsnew, $this->TOT_BIAYA_OKSIGEN->CurrentValue, NULL, strval($this->TOT_BIAYA_OKSIGEN->CurrentValue) == "");

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->SetDbValueDef($rsnew, $this->TOTAL_BIAYA_OBAT->CurrentValue, NULL, strval($this->TOTAL_BIAYA_OBAT->CurrentValue) == "");

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS->SetDbValueDef($rsnew, $this->LINK_SET_KELAS->CurrentValue, NULL, FALSE);

		// biaya_obat
		$this->biaya_obat->SetDbValueDef($rsnew, $this->biaya_obat->CurrentValue, NULL, strval($this->biaya_obat->CurrentValue) == "");

		// biaya_retur_obat
		$this->biaya_retur_obat->SetDbValueDef($rsnew, $this->biaya_retur_obat->CurrentValue, NULL, strval($this->biaya_retur_obat->CurrentValue) == "");

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI->SetDbValueDef($rsnew, $this->TOT_BIAYA_GIZI->CurrentValue, NULL, strval($this->TOT_BIAYA_GIZI->CurrentValue) == "");

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO->SetDbValueDef($rsnew, $this->TOT_BIAYA_TMO->CurrentValue, NULL, strval($this->TOT_BIAYA_TMO->CurrentValue) == "");

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN->SetDbValueDef($rsnew, $this->TOT_BIAYA_AMBULAN->CurrentValue, NULL, strval($this->TOT_BIAYA_AMBULAN->CurrentValue) == "");

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO->SetDbValueDef($rsnew, $this->TOT_BIAYA_FISIO->CurrentValue, NULL, strval($this->TOT_BIAYA_FISIO->CurrentValue) == "");

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN->SetDbValueDef($rsnew, $this->TOT_BIAYA_LAINLAIN->CurrentValue, NULL, strval($this->TOT_BIAYA_LAINLAIN->CurrentValue) == "");

		// jenisperawatan_id
		$this->jenisperawatan_id->SetDbValueDef($rsnew, $this->jenisperawatan_id->CurrentValue, NULL, strval($this->jenisperawatan_id->CurrentValue) == "");

		// status_transaksi
		$this->status_transaksi->SetDbValueDef($rsnew, $this->status_transaksi->CurrentValue, NULL, strval($this->status_transaksi->CurrentValue) == "");

		// statuskeluarranap_id
		$this->statuskeluarranap_id->SetDbValueDef($rsnew, $this->statuskeluarranap_id->CurrentValue, NULL, strval($this->statuskeluarranap_id->CurrentValue) == "");

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI->SetDbValueDef($rsnew, $this->TOT_BIAYA_AKOMODASI->CurrentValue, NULL, strval($this->TOT_BIAYA_AKOMODASI->CurrentValue) == "");

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP->SetDbValueDef($rsnew, $this->TOTAL_BIAYA_ASKEP->CurrentValue, NULL, strval($this->TOTAL_BIAYA_ASKEP->CurrentValue) == "");

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS->SetDbValueDef($rsnew, $this->TOTAL_BIAYA_SIMRS->CurrentValue, NULL, strval($this->TOTAL_BIAYA_SIMRS->CurrentValue) == "");

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS->SetDbValueDef($rsnew, $this->TOT_PENJ_NMEDIS->CurrentValue, NULL, strval($this->TOT_PENJ_NMEDIS->CurrentValue) == "");

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL->SetDbValueDef($rsnew, $this->LINK_MASTERDETAIL->CurrentValue, NULL, FALSE);

		// NO_SKP
		$this->NO_SKP->SetDbValueDef($rsnew, $this->NO_SKP->CurrentValue, NULL, FALSE);

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT->SetDbValueDef($rsnew, $this->LINK_PELAYANAN_OBAT->CurrentValue, NULL, FALSE);

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL->SetDbValueDef($rsnew, $this->TOT_TIND_RAJAL->CurrentValue, NULL, strval($this->TOT_TIND_RAJAL->CurrentValue) == "");

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD->SetDbValueDef($rsnew, $this->TOT_TIND_IGD->CurrentValue, NULL, strval($this->TOT_TIND_IGD->CurrentValue) == "");

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tanggal_pengembalian_status->CurrentValue, 0), NULL, FALSE);

		// naik_kelas
		$this->naik_kelas->SetDbValueDef($rsnew, $this->naik_kelas->CurrentValue, NULL, FALSE);

		// iuran_kelas_lama
		$this->iuran_kelas_lama->SetDbValueDef($rsnew, $this->iuran_kelas_lama->CurrentValue, NULL, FALSE);

		// iuran_kelas_baru
		$this->iuran_kelas_baru->SetDbValueDef($rsnew, $this->iuran_kelas_baru->CurrentValue, NULL, FALSE);

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas->SetDbValueDef($rsnew, $this->ketrangan_naik_kelas->CurrentValue, NULL, FALSE);

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_pengiriman_ad_klaim->CurrentValue, 0), NULL, FALSE);

		// diagnosa_keluar
		$this->diagnosa_keluar->SetDbValueDef($rsnew, $this->diagnosa_keluar->CurrentValue, NULL, FALSE);

		// sep_tglsep
		$this->sep_tglsep->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sep_tglsep->CurrentValue, 0), NULL, FALSE);

		// sep_tglrujuk
		$this->sep_tglrujuk->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sep_tglrujuk->CurrentValue, 0), NULL, FALSE);

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat->SetDbValueDef($rsnew, $this->sep_kodekelasrawat->CurrentValue, NULL, FALSE);

		// sep_norujukan
		$this->sep_norujukan->SetDbValueDef($rsnew, $this->sep_norujukan->CurrentValue, NULL, FALSE);

		// sep_kodeppkasal
		$this->sep_kodeppkasal->SetDbValueDef($rsnew, $this->sep_kodeppkasal->CurrentValue, NULL, FALSE);

		// sep_namappkasal
		$this->sep_namappkasal->SetDbValueDef($rsnew, $this->sep_namappkasal->CurrentValue, NULL, FALSE);

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan->SetDbValueDef($rsnew, $this->sep_kodeppkpelayanan->CurrentValue, NULL, FALSE);

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan->SetDbValueDef($rsnew, $this->sep_namappkpelayanan->CurrentValue, NULL, FALSE);

		// t_admissioncol
		$this->t_admissioncol->SetDbValueDef($rsnew, $this->t_admissioncol->CurrentValue, NULL, FALSE);

		// sep_jenisperawatan
		$this->sep_jenisperawatan->SetDbValueDef($rsnew, $this->sep_jenisperawatan->CurrentValue, NULL, FALSE);

		// sep_catatan
		$this->sep_catatan->SetDbValueDef($rsnew, $this->sep_catatan->CurrentValue, NULL, FALSE);

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->SetDbValueDef($rsnew, $this->sep_kodediagnosaawal->CurrentValue, NULL, FALSE);

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->SetDbValueDef($rsnew, $this->sep_namadiagnosaawal->CurrentValue, NULL, FALSE);

		// sep_lakalantas
		$this->sep_lakalantas->SetDbValueDef($rsnew, $this->sep_lakalantas->CurrentValue, NULL, strval($this->sep_lakalantas->CurrentValue) == "");

		// sep_lokasilaka
		$this->sep_lokasilaka->SetDbValueDef($rsnew, $this->sep_lokasilaka->CurrentValue, NULL, FALSE);

		// sep_user
		$this->sep_user->SetDbValueDef($rsnew, $this->sep_user->CurrentValue, NULL, FALSE);

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta->SetDbValueDef($rsnew, $this->sep_flag_cekpeserta->CurrentValue, NULL, FALSE);

		// sep_flag_generatesep
		$this->sep_flag_generatesep->SetDbValueDef($rsnew, $this->sep_flag_generatesep->CurrentValue, NULL, FALSE);

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep->SetDbValueDef($rsnew, $this->sep_flag_mapingsep->CurrentValue, NULL, FALSE);

		// sep_nik
		$this->sep_nik->SetDbValueDef($rsnew, $this->sep_nik->CurrentValue, NULL, FALSE);

		// sep_namapeserta
		$this->sep_namapeserta->SetDbValueDef($rsnew, $this->sep_namapeserta->CurrentValue, NULL, FALSE);

		// sep_jeniskelamin
		$this->sep_jeniskelamin->SetDbValueDef($rsnew, $this->sep_jeniskelamin->CurrentValue, NULL, FALSE);

		// sep_pisat
		$this->sep_pisat->SetDbValueDef($rsnew, $this->sep_pisat->CurrentValue, NULL, FALSE);

		// sep_tgllahir
		$this->sep_tgllahir->SetDbValueDef($rsnew, $this->sep_tgllahir->CurrentValue, NULL, FALSE);

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan->SetDbValueDef($rsnew, $this->sep_kodejeniskepesertaan->CurrentValue, NULL, FALSE);

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan->SetDbValueDef($rsnew, $this->sep_namajeniskepesertaan->CurrentValue, NULL, FALSE);

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan->SetDbValueDef($rsnew, $this->sep_kodepolitujuan->CurrentValue, NULL, FALSE);

		// sep_namapolitujuan
		$this->sep_namapolitujuan->SetDbValueDef($rsnew, $this->sep_namapolitujuan->CurrentValue, NULL, FALSE);

		// ket_jeniskelamin
		$this->ket_jeniskelamin->SetDbValueDef($rsnew, $this->ket_jeniskelamin->CurrentValue, NULL, FALSE);

		// sep_nokabpjs
		$this->sep_nokabpjs->SetDbValueDef($rsnew, $this->sep_nokabpjs->CurrentValue, NULL, FALSE);

		// counter_cetak_sep
		$this->counter_cetak_sep->SetDbValueDef($rsnew, $this->counter_cetak_sep->CurrentValue, NULL, strval($this->counter_cetak_sep->CurrentValue) == "");

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep->SetDbValueDef($rsnew, $this->sep_petugas_hapus_sep->CurrentValue, NULL, FALSE);

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang->SetDbValueDef($rsnew, $this->sep_petugas_set_tgl_pulang->CurrentValue, NULL, FALSE);

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sep_jam_generate_sep->CurrentValue, 0), NULL, FALSE);

		// sep_status_peserta
		$this->sep_status_peserta->SetDbValueDef($rsnew, $this->sep_status_peserta->CurrentValue, NULL, FALSE);

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->SetDbValueDef($rsnew, $this->sep_umur_pasien_sekarang->CurrentValue, NULL, FALSE);

		// ket_title
		$this->ket_title->SetDbValueDef($rsnew, $this->ket_title->CurrentValue, NULL, FALSE);

		// status_daftar_ranap
		$this->status_daftar_ranap->SetDbValueDef($rsnew, $this->status_daftar_ranap->CurrentValue, NULL, strval($this->status_daftar_ranap->CurrentValue) == "");

		// IBS_SETMARKING
		$this->IBS_SETMARKING->SetDbValueDef($rsnew, $this->IBS_SETMARKING->CurrentValue, NULL, strval($this->IBS_SETMARKING->CurrentValue) == "");

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI->SetDbValueDef($rsnew, $this->IBS_PATOLOGI->CurrentValue, NULL, strval($this->IBS_PATOLOGI->CurrentValue) == "");

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI->SetDbValueDef($rsnew, $this->IBS_JENISANESTESI->CurrentValue, NULL, FALSE);

		// IBS_NO_OK
		$this->IBS_NO_OK->SetDbValueDef($rsnew, $this->IBS_NO_OK->CurrentValue, NULL, FALSE);

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN->SetDbValueDef($rsnew, $this->IBS_ASISSTEN->CurrentValue, NULL, FALSE);

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->IBS_JAM_ELEFTIF->CurrentValue, 0), NULL, FALSE);

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue, 0), NULL, FALSE);

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->IBS_JAM_CYTO->CurrentValue, 0), NULL, FALSE);

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->IBS_JAM_CYTO_SELESAI->CurrentValue, 0), NULL, FALSE);

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->IBS_TGL_DFTR_OP->CurrentValue, 0), NULL, FALSE);

		// IBS_TGL_OP
		$this->IBS_TGL_OP->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->IBS_TGL_OP->CurrentValue, 0), NULL, FALSE);

		// grup_ruang_id
		$this->grup_ruang_id->SetDbValueDef($rsnew, $this->grup_ruang_id->CurrentValue, NULL, FALSE);

		// status_order_ibs
		$this->status_order_ibs->SetDbValueDef($rsnew, $this->status_order_ibs->CurrentValue, NULL, strval($this->status_order_ibs->CurrentValue) == "");

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
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_admissionlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_nomr":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR` AS `LinkFld`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
			$sWhereWrk = "{filter}";
			$this->nomr->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`NOMR` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_dokterpengirim":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KDDOKTER` AS `LinkFld`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
			$sWhereWrk = "";
			$this->dokterpengirim->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KDDOKTER` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_statusbayar":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE` AS `LinkFld`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
			$sWhereWrk = "";
			$this->statusbayar->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KODE` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kirimdari":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode` AS `LinkFld`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
			$sWhereWrk = "{filter}";
			$this->kirimdari->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`kode` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
			$lookuptblfilter = "isnull(`KETERANGAN`)";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id` = {filter_value}', "t0" => "3", "fn0" => "", "f1" => '`idxruang` IN ({filter_value})', "t1" => "200", "fn1" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_icd_masuk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE` AS `LinkFld`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "{filter}";
			$this->icd_masuk->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`CODE` = {filter_value}', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kd_rujuk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `KODE` AS `LinkFld`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
			$sWhereWrk = "";
			$this->kd_rujuk->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`KODE` = {filter_value}', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
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
		case "x_nomr":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld` FROM `m_pasien`";
			$sWhereWrk = "`NOMR` LIKE '%{query_value}%' OR `NAMA` LIKE '%{query_value}%' OR CONCAT(`NOMR`,'" . ew_ValueSeparator(1, $this->nomr) . "',`NAMA`) LIKE '{query_value}%'";
			$this->nomr->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_kirimdari":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld` FROM `m_poly`";
			$sWhereWrk = "`nama` LIKE '%{query_value}%'";
			$this->kirimdari->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_icd_masuk":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld` FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "`CODE` LIKE '%{query_value}%' OR `STR` LIKE '%{query_value}%' OR CONCAT(`CODE`,'" . ew_ValueSeparator(1, $this->icd_masuk) . "',`STR`) LIKE '{query_value}%'";
			$this->icd_masuk->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
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
if (!isset($t_admission_add)) $t_admission_add = new ct_admission_add();

// Page init
$t_admission_add->Page_Init();

// Page main
$t_admission_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_admission_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ft_admissionadd = new ew_Form("ft_admissionadd", "add");

// Validate form
ft_admissionadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_id_admission");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->id_admission->FldCaption(), $t_admission->id_admission->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_id_admission");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->id_admission->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nomr");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->nomr->FldCaption(), $t_admission->nomr->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ket_tgllahir");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->ket_tgllahir->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dokterpengirim");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->dokterpengirim->FldCaption(), $t_admission->dokterpengirim->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_statusbayar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->statusbayar->FldCaption(), $t_admission->statusbayar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kirimdari");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->kirimdari->FldCaption(), $t_admission->kirimdari->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_kirimdari");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->kirimdari->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keluargadekat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->keluargadekat->FldCaption(), $t_admission->keluargadekat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_panggungjawab");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->panggungjawab->FldCaption(), $t_admission->panggungjawab->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_masukrs");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->masukrs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_noruang");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->noruang->FldCaption(), $t_admission->noruang->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tempat_tidur_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->tempat_tidur_id->FldCaption(), $t_admission->tempat_tidur_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nott");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->nott->FldCaption(), $t_admission->nott->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_deposit");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->deposit->FldCaption(), $t_admission->deposit->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_deposit");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->deposit->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_keluarrs");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->keluarrs->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_icd_masuk");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->icd_masuk->FldCaption(), $t_admission->icd_masuk->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_NIP");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->NIP->FldCaption(), $t_admission->NIP->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_noruang_asal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->noruang_asal->FldCaption(), $t_admission->noruang_asal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_noruang_asal");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->noruang_asal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_nott_asal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->nott_asal->FldCaption(), $t_admission->nott_asal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nott_asal");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->nott_asal->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_pindah");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->tgl_pindah->FldCaption(), $t_admission->tgl_pindah->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tgl_pindah");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->tgl_pindah->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_kd_rujuk");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->kd_rujuk->FldCaption(), $t_admission->kd_rujuk->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_st_bayar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->st_bayar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dokter_penanggungjawab");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->dokter_penanggungjawab->FldCaption(), $t_admission->dokter_penanggungjawab->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_perawat");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->perawat->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_KELASPERAWATAN_ID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $t_admission->KELASPERAWATAN_ID->FldCaption(), $t_admission->KELASPERAWATAN_ID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_LOS");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->LOS->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_TRF_TIND_DOKTER");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_TRF_TIND_DOKTER->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BHP_DOKTER");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BHP_DOKTER->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_TRF_PERAWAT");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_TRF_PERAWAT->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BHP_PERAWAT");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BHP_PERAWAT->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_TRF_DOKTER");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_TRF_DOKTER->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_RAD");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_RAD->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_CDRPOLI");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_CDRPOLI->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_LAB_IGD");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_LAB_IGD->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_OKSIGEN");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_OKSIGEN->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOTAL_BIAYA_OBAT");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOTAL_BIAYA_OBAT->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_biaya_obat");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->biaya_obat->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_biaya_retur_obat");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->biaya_retur_obat->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_GIZI");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_GIZI->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_TMO");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_TMO->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_AMBULAN");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_AMBULAN->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_FISIO");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_FISIO->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_LAINLAIN");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_LAINLAIN->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_jenisperawatan_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->jenisperawatan_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_transaksi");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->status_transaksi->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_statuskeluarranap_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->statuskeluarranap_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_BIAYA_AKOMODASI");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_BIAYA_AKOMODASI->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOTAL_BIAYA_ASKEP");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOTAL_BIAYA_ASKEP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOTAL_BIAYA_SIMRS");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOTAL_BIAYA_SIMRS->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_PENJ_NMEDIS");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_PENJ_NMEDIS->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_TIND_RAJAL");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_TIND_RAJAL->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TOT_TIND_IGD");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->TOT_TIND_IGD->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tanggal_pengembalian_status");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->tanggal_pengembalian_status->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_naik_kelas");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->naik_kelas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_iuran_kelas_lama");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->iuran_kelas_lama->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_iuran_kelas_baru");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->iuran_kelas_baru->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tgl_pengiriman_ad_klaim");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->tgl_pengiriman_ad_klaim->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_diagnosa_keluar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->diagnosa_keluar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_tglsep");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_tglsep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_tglrujuk");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_tglrujuk->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_jenisperawatan");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_jenisperawatan->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_lakalantas");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_lakalantas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_flag_cekpeserta");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_flag_cekpeserta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_flag_generatesep");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_flag_generatesep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_flag_mapingsep");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_flag_mapingsep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_counter_cetak_sep");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->counter_cetak_sep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sep_jam_generate_sep");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->sep_jam_generate_sep->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_daftar_ranap");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->status_daftar_ranap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_SETMARKING");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_SETMARKING->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_PATOLOGI");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_PATOLOGI->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_JENISANESTESI");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_JENISANESTESI->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_NO_OK");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_NO_OK->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_JAM_ELEFTIF");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_JAM_ELEFTIF->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_JAM_ELEKTIF_SELESAI");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_JAM_ELEKTIF_SELESAI->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_JAM_CYTO");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_JAM_CYTO->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_JAM_CYTO_SELESAI");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_JAM_CYTO_SELESAI->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_TGL_DFTR_OP");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_TGL_DFTR_OP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_IBS_TGL_OP");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->IBS_TGL_OP->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_grup_ruang_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->grup_ruang_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status_order_ibs");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($t_admission->status_order_ibs->FldErrMsg()) ?>");

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
ft_admissionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_admissionadd.ValidateRequired = true;
<?php } else { ?>
ft_admissionadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_admissionadd.Lists["x_nomr"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_admissionadd.Lists["x_dokterpengirim"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_admissionadd.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_admissionadd.Lists["x_kirimdari"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_admissionadd.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
ft_admissionadd.Lists["x_tempat_tidur_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":true,"DisplayFields":["x_no_tt","","",""],"ParentFields":["x_noruang"],"ChildFields":[],"FilterFields":["x_idxruang"],"Options":[],"Template":"","LinkTable":"m_detail_tempat_tidur"};
ft_admissionadd.Lists["x_icd_masuk"] = {"LinkField":"x_CODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_CODE","x_STR","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_diagnosa_eklaim"};
ft_admissionadd.Lists["x_kd_rujuk"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
ft_admissionadd.Lists["x_dokter_penanggungjawab"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_admissionadd.Lists["x_KELASPERAWATAN_ID"] = {"LinkField":"x_kelasperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kelasperawatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_kelas_perawatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_admission_add->IsModal) { ?>
<?php } ?>
<?php $t_admission_add->ShowPageHeader(); ?>
<?php
$t_admission_add->ShowMessage();
?>
<form name="ft_admissionadd" id="ft_admissionadd" class="<?php echo $t_admission_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_admission_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_admission_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_admission">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($t_admission_add->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($t_admission->id_admission->Visible) { // id_admission ?>
	<div id="r_id_admission" class="form-group">
		<label id="elh_t_admission_id_admission" for="x_id_admission" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->id_admission->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->id_admission->CellAttributes() ?>>
<span id="el_t_admission_id_admission">
<input type="text" data-table="t_admission" data-field="x_id_admission" name="x_id_admission" id="x_id_admission" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->id_admission->getPlaceHolder()) ?>" value="<?php echo $t_admission->id_admission->EditValue ?>"<?php echo $t_admission->id_admission->EditAttributes() ?>>
</span>
<?php echo $t_admission->id_admission->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->nomr->Visible) { // nomr ?>
	<div id="r_nomr" class="form-group">
		<label id="elh_t_admission_nomr" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->nomr->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->nomr->CellAttributes() ?>>
<span id="el_t_admission_nomr">
<?php
$wrkonchange = trim(" " . @$t_admission->nomr->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_admission->nomr->EditAttrs["onchange"] = "";
?>
<span id="as_x_nomr" style="white-space: nowrap; z-index: 8980">
	<input type="text" name="sv_x_nomr" id="sv_x_nomr" value="<?php echo $t_admission->nomr->EditValue ?>" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->nomr->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_admission->nomr->getPlaceHolder()) ?>"<?php echo $t_admission->nomr->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_admission" data-field="x_nomr" data-value-separator="<?php echo $t_admission->nomr->DisplayValueSeparatorAttribute() ?>" name="x_nomr" id="x_nomr" value="<?php echo ew_HtmlEncode($t_admission->nomr->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_nomr" id="q_x_nomr" value="<?php echo $t_admission->nomr->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_admissionadd.CreateAutoSuggest({"id":"x_nomr","forceSelect":false});
</script>
</span>
<?php echo $t_admission->nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_nama->Visible) { // ket_nama ?>
	<div id="r_ket_nama" class="form-group">
		<label id="elh_t_admission_ket_nama" for="x_ket_nama" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->ket_nama->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_nama->CellAttributes() ?>>
<span id="el_t_admission_ket_nama">
<input type="text" data-table="t_admission" data-field="x_ket_nama" name="x_ket_nama" id="x_ket_nama" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_nama->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_nama->EditValue ?>"<?php echo $t_admission->ket_nama->EditAttributes() ?>>
</span>
<?php echo $t_admission->ket_nama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_tgllahir->Visible) { // ket_tgllahir ?>
	<div id="r_ket_tgllahir" class="form-group">
		<label id="elh_t_admission_ket_tgllahir" for="x_ket_tgllahir" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->ket_tgllahir->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_tgllahir->CellAttributes() ?>>
<span id="el_t_admission_ket_tgllahir">
<input type="text" data-table="t_admission" data-field="x_ket_tgllahir" name="x_ket_tgllahir" id="x_ket_tgllahir" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_tgllahir->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_tgllahir->EditValue ?>"<?php echo $t_admission->ket_tgllahir->EditAttributes() ?>>
</span>
<?php echo $t_admission->ket_tgllahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_alamat->Visible) { // ket_alamat ?>
	<div id="r_ket_alamat" class="form-group">
		<label id="elh_t_admission_ket_alamat" for="x_ket_alamat" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->ket_alamat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_alamat->CellAttributes() ?>>
<span id="el_t_admission_ket_alamat">
<input type="text" data-table="t_admission" data-field="x_ket_alamat" name="x_ket_alamat" id="x_ket_alamat" size="30" maxlength="225" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_alamat->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_alamat->EditValue ?>"<?php echo $t_admission->ket_alamat->EditAttributes() ?>>
</span>
<?php echo $t_admission->ket_alamat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->parent_nomr->Visible) { // parent_nomr ?>
	<div id="r_parent_nomr" class="form-group">
		<label id="elh_t_admission_parent_nomr" for="x_parent_nomr" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->parent_nomr->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->parent_nomr->CellAttributes() ?>>
<span id="el_t_admission_parent_nomr">
<input type="text" data-table="t_admission" data-field="x_parent_nomr" name="x_parent_nomr" id="x_parent_nomr" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->parent_nomr->getPlaceHolder()) ?>" value="<?php echo $t_admission->parent_nomr->EditValue ?>"<?php echo $t_admission->parent_nomr->EditAttributes() ?>>
</span>
<?php echo $t_admission->parent_nomr->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->dokterpengirim->Visible) { // dokterpengirim ?>
	<div id="r_dokterpengirim" class="form-group">
		<label id="elh_t_admission_dokterpengirim" for="x_dokterpengirim" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->dokterpengirim->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->dokterpengirim->CellAttributes() ?>>
<span id="el_t_admission_dokterpengirim">
<select data-table="t_admission" data-field="x_dokterpengirim" data-value-separator="<?php echo $t_admission->dokterpengirim->DisplayValueSeparatorAttribute() ?>" id="x_dokterpengirim" name="x_dokterpengirim"<?php echo $t_admission->dokterpengirim->EditAttributes() ?>>
<?php echo $t_admission->dokterpengirim->SelectOptionListHtml("x_dokterpengirim") ?>
</select>
<input type="hidden" name="s_x_dokterpengirim" id="s_x_dokterpengirim" value="<?php echo $t_admission->dokterpengirim->LookupFilterQuery() ?>">
</span>
<?php echo $t_admission->dokterpengirim->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->statusbayar->Visible) { // statusbayar ?>
	<div id="r_statusbayar" class="form-group">
		<label id="elh_t_admission_statusbayar" for="x_statusbayar" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->statusbayar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->statusbayar->CellAttributes() ?>>
<span id="el_t_admission_statusbayar">
<select data-table="t_admission" data-field="x_statusbayar" data-value-separator="<?php echo $t_admission->statusbayar->DisplayValueSeparatorAttribute() ?>" id="x_statusbayar" name="x_statusbayar"<?php echo $t_admission->statusbayar->EditAttributes() ?>>
<?php echo $t_admission->statusbayar->SelectOptionListHtml("x_statusbayar") ?>
</select>
<input type="hidden" name="s_x_statusbayar" id="s_x_statusbayar" value="<?php echo $t_admission->statusbayar->LookupFilterQuery() ?>">
</span>
<?php echo $t_admission->statusbayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->kirimdari->Visible) { // kirimdari ?>
	<div id="r_kirimdari" class="form-group">
		<label id="elh_t_admission_kirimdari" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->kirimdari->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->kirimdari->CellAttributes() ?>>
<span id="el_t_admission_kirimdari">
<?php
$wrkonchange = trim(" " . @$t_admission->kirimdari->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_admission->kirimdari->EditAttrs["onchange"] = "";
?>
<span id="as_x_kirimdari" style="white-space: nowrap; z-index: 8910">
	<input type="text" name="sv_x_kirimdari" id="sv_x_kirimdari" value="<?php echo $t_admission->kirimdari->EditValue ?>" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->kirimdari->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_admission->kirimdari->getPlaceHolder()) ?>"<?php echo $t_admission->kirimdari->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_admission" data-field="x_kirimdari" data-value-separator="<?php echo $t_admission->kirimdari->DisplayValueSeparatorAttribute() ?>" name="x_kirimdari" id="x_kirimdari" value="<?php echo ew_HtmlEncode($t_admission->kirimdari->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_kirimdari" id="q_x_kirimdari" value="<?php echo $t_admission->kirimdari->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_admissionadd.CreateAutoSuggest({"id":"x_kirimdari","forceSelect":false});
</script>
</span>
<?php echo $t_admission->kirimdari->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->keluargadekat->Visible) { // keluargadekat ?>
	<div id="r_keluargadekat" class="form-group">
		<label id="elh_t_admission_keluargadekat" for="x_keluargadekat" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->keluargadekat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->keluargadekat->CellAttributes() ?>>
<span id="el_t_admission_keluargadekat">
<input type="text" data-table="t_admission" data-field="x_keluargadekat" name="x_keluargadekat" id="x_keluargadekat" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_admission->keluargadekat->getPlaceHolder()) ?>" value="<?php echo $t_admission->keluargadekat->EditValue ?>"<?php echo $t_admission->keluargadekat->EditAttributes() ?>>
</span>
<?php echo $t_admission->keluargadekat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->panggungjawab->Visible) { // panggungjawab ?>
	<div id="r_panggungjawab" class="form-group">
		<label id="elh_t_admission_panggungjawab" for="x_panggungjawab" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->panggungjawab->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->panggungjawab->CellAttributes() ?>>
<span id="el_t_admission_panggungjawab">
<input type="text" data-table="t_admission" data-field="x_panggungjawab" name="x_panggungjawab" id="x_panggungjawab" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_admission->panggungjawab->getPlaceHolder()) ?>" value="<?php echo $t_admission->panggungjawab->EditValue ?>"<?php echo $t_admission->panggungjawab->EditAttributes() ?>>
</span>
<?php echo $t_admission->panggungjawab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->masukrs->Visible) { // masukrs ?>
	<div id="r_masukrs" class="form-group">
		<label id="elh_t_admission_masukrs" for="x_masukrs" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->masukrs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->masukrs->CellAttributes() ?>>
<span id="el_t_admission_masukrs">
<input type="text" data-table="t_admission" data-field="x_masukrs" data-format="11" name="x_masukrs" id="x_masukrs" placeholder="<?php echo ew_HtmlEncode($t_admission->masukrs->getPlaceHolder()) ?>" value="<?php echo $t_admission->masukrs->EditValue ?>"<?php echo $t_admission->masukrs->EditAttributes() ?>>
<?php if (!$t_admission->masukrs->ReadOnly && !$t_admission->masukrs->Disabled && !isset($t_admission->masukrs->EditAttrs["readonly"]) && !isset($t_admission->masukrs->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("ft_admissionadd", "x_masukrs", 11);
</script>
<?php } ?>
</span>
<?php echo $t_admission->masukrs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->noruang->Visible) { // noruang ?>
	<div id="r_noruang" class="form-group">
		<label id="elh_t_admission_noruang" for="x_noruang" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->noruang->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->noruang->CellAttributes() ?>>
<span id="el_t_admission_noruang">
<?php $t_admission->noruang->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$t_admission->noruang->EditAttrs["onchange"]; ?>
<select data-table="t_admission" data-field="x_noruang" data-value-separator="<?php echo $t_admission->noruang->DisplayValueSeparatorAttribute() ?>" id="x_noruang" name="x_noruang"<?php echo $t_admission->noruang->EditAttributes() ?>>
<?php echo $t_admission->noruang->SelectOptionListHtml("x_noruang") ?>
</select>
<input type="hidden" name="s_x_noruang" id="s_x_noruang" value="<?php echo $t_admission->noruang->LookupFilterQuery() ?>">
</span>
<?php echo $t_admission->noruang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->tempat_tidur_id->Visible) { // tempat_tidur_id ?>
	<div id="r_tempat_tidur_id" class="form-group">
		<label id="elh_t_admission_tempat_tidur_id" for="x_tempat_tidur_id" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->tempat_tidur_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->tempat_tidur_id->CellAttributes() ?>>
<span id="el_t_admission_tempat_tidur_id">
<?php $t_admission->tempat_tidur_id->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$t_admission->tempat_tidur_id->EditAttrs["onchange"]; ?>
<select data-table="t_admission" data-field="x_tempat_tidur_id" data-value-separator="<?php echo $t_admission->tempat_tidur_id->DisplayValueSeparatorAttribute() ?>" id="x_tempat_tidur_id" name="x_tempat_tidur_id"<?php echo $t_admission->tempat_tidur_id->EditAttributes() ?>>
<?php echo $t_admission->tempat_tidur_id->SelectOptionListHtml("x_tempat_tidur_id") ?>
</select>
<input type="hidden" name="s_x_tempat_tidur_id" id="s_x_tempat_tidur_id" value="<?php echo $t_admission->tempat_tidur_id->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_tempat_tidur_id" id="ln_x_tempat_tidur_id" value="x_nott">
</span>
<?php echo $t_admission->tempat_tidur_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->nott->Visible) { // nott ?>
	<div id="r_nott" class="form-group">
		<label id="elh_t_admission_nott" for="x_nott" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->nott->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->nott->CellAttributes() ?>>
<span id="el_t_admission_nott">
<input type="text" data-table="t_admission" data-field="x_nott" name="x_nott" id="x_nott" size="30" maxlength="5" placeholder="<?php echo ew_HtmlEncode($t_admission->nott->getPlaceHolder()) ?>" value="<?php echo $t_admission->nott->EditValue ?>"<?php echo $t_admission->nott->EditAttributes() ?>>
</span>
<?php echo $t_admission->nott->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->deposit->Visible) { // deposit ?>
	<div id="r_deposit" class="form-group">
		<label id="elh_t_admission_deposit" for="x_deposit" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->deposit->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->deposit->CellAttributes() ?>>
<span id="el_t_admission_deposit">
<input type="text" data-table="t_admission" data-field="x_deposit" name="x_deposit" id="x_deposit" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->deposit->getPlaceHolder()) ?>" value="<?php echo $t_admission->deposit->EditValue ?>"<?php echo $t_admission->deposit->EditAttributes() ?>>
</span>
<?php echo $t_admission->deposit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->keluarrs->Visible) { // keluarrs ?>
	<div id="r_keluarrs" class="form-group">
		<label id="elh_t_admission_keluarrs" for="x_keluarrs" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->keluarrs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->keluarrs->CellAttributes() ?>>
<span id="el_t_admission_keluarrs">
<input type="text" data-table="t_admission" data-field="x_keluarrs" name="x_keluarrs" id="x_keluarrs" placeholder="<?php echo ew_HtmlEncode($t_admission->keluarrs->getPlaceHolder()) ?>" value="<?php echo $t_admission->keluarrs->EditValue ?>"<?php echo $t_admission->keluarrs->EditAttributes() ?>>
</span>
<?php echo $t_admission->keluarrs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->icd_masuk->Visible) { // icd_masuk ?>
	<div id="r_icd_masuk" class="form-group">
		<label id="elh_t_admission_icd_masuk" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->icd_masuk->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->icd_masuk->CellAttributes() ?>>
<span id="el_t_admission_icd_masuk">
<?php
$wrkonchange = trim(" " . @$t_admission->icd_masuk->EditAttrs["onchange"]);
if ($wrkonchange <> "") $wrkonchange = " onchange=\"" . ew_JsEncode2($wrkonchange) . "\"";
$t_admission->icd_masuk->EditAttrs["onchange"] = "";
?>
<span id="as_x_icd_masuk" style="white-space: nowrap; z-index: 8820">
	<input type="text" name="sv_x_icd_masuk" id="sv_x_icd_masuk" value="<?php echo $t_admission->icd_masuk->EditValue ?>" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->icd_masuk->getPlaceHolder()) ?>" data-placeholder="<?php echo ew_HtmlEncode($t_admission->icd_masuk->getPlaceHolder()) ?>"<?php echo $t_admission->icd_masuk->EditAttributes() ?>>
</span>
<input type="hidden" data-table="t_admission" data-field="x_icd_masuk" data-value-separator="<?php echo $t_admission->icd_masuk->DisplayValueSeparatorAttribute() ?>" name="x_icd_masuk" id="x_icd_masuk" value="<?php echo ew_HtmlEncode($t_admission->icd_masuk->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<input type="hidden" name="q_x_icd_masuk" id="q_x_icd_masuk" value="<?php echo $t_admission->icd_masuk->LookupFilterQuery(true) ?>">
<script type="text/javascript">
ft_admissionadd.CreateAutoSuggest({"id":"x_icd_masuk","forceSelect":false});
</script>
</span>
<?php echo $t_admission->icd_masuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->icd_keluar->Visible) { // icd_keluar ?>
	<div id="r_icd_keluar" class="form-group">
		<label id="elh_t_admission_icd_keluar" for="x_icd_keluar" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->icd_keluar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->icd_keluar->CellAttributes() ?>>
<span id="el_t_admission_icd_keluar">
<input type="text" data-table="t_admission" data-field="x_icd_keluar" name="x_icd_keluar" id="x_icd_keluar" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->icd_keluar->getPlaceHolder()) ?>" value="<?php echo $t_admission->icd_keluar->EditValue ?>"<?php echo $t_admission->icd_keluar->EditAttributes() ?>>
</span>
<?php echo $t_admission->icd_keluar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->NIP->Visible) { // NIP ?>
	<div id="r_NIP" class="form-group">
		<label id="elh_t_admission_NIP" for="x_NIP" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->NIP->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->NIP->CellAttributes() ?>>
<span id="el_t_admission_NIP">
<input type="text" data-table="t_admission" data-field="x_NIP" name="x_NIP" id="x_NIP" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($t_admission->NIP->getPlaceHolder()) ?>" value="<?php echo $t_admission->NIP->EditValue ?>"<?php echo $t_admission->NIP->EditAttributes() ?>>
</span>
<?php echo $t_admission->NIP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->noruang_asal->Visible) { // noruang_asal ?>
	<div id="r_noruang_asal" class="form-group">
		<label id="elh_t_admission_noruang_asal" for="x_noruang_asal" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->noruang_asal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->noruang_asal->CellAttributes() ?>>
<span id="el_t_admission_noruang_asal">
<input type="text" data-table="t_admission" data-field="x_noruang_asal" name="x_noruang_asal" id="x_noruang_asal" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->noruang_asal->getPlaceHolder()) ?>" value="<?php echo $t_admission->noruang_asal->EditValue ?>"<?php echo $t_admission->noruang_asal->EditAttributes() ?>>
</span>
<?php echo $t_admission->noruang_asal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->nott_asal->Visible) { // nott_asal ?>
	<div id="r_nott_asal" class="form-group">
		<label id="elh_t_admission_nott_asal" for="x_nott_asal" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->nott_asal->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->nott_asal->CellAttributes() ?>>
<span id="el_t_admission_nott_asal">
<input type="text" data-table="t_admission" data-field="x_nott_asal" name="x_nott_asal" id="x_nott_asal" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->nott_asal->getPlaceHolder()) ?>" value="<?php echo $t_admission->nott_asal->EditValue ?>"<?php echo $t_admission->nott_asal->EditAttributes() ?>>
</span>
<?php echo $t_admission->nott_asal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->tgl_pindah->Visible) { // tgl_pindah ?>
	<div id="r_tgl_pindah" class="form-group">
		<label id="elh_t_admission_tgl_pindah" for="x_tgl_pindah" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->tgl_pindah->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->tgl_pindah->CellAttributes() ?>>
<span id="el_t_admission_tgl_pindah">
<input type="text" data-table="t_admission" data-field="x_tgl_pindah" name="x_tgl_pindah" id="x_tgl_pindah" placeholder="<?php echo ew_HtmlEncode($t_admission->tgl_pindah->getPlaceHolder()) ?>" value="<?php echo $t_admission->tgl_pindah->EditValue ?>"<?php echo $t_admission->tgl_pindah->EditAttributes() ?>>
</span>
<?php echo $t_admission->tgl_pindah->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->kd_rujuk->Visible) { // kd_rujuk ?>
	<div id="r_kd_rujuk" class="form-group">
		<label id="elh_t_admission_kd_rujuk" for="x_kd_rujuk" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->kd_rujuk->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->kd_rujuk->CellAttributes() ?>>
<span id="el_t_admission_kd_rujuk">
<select data-table="t_admission" data-field="x_kd_rujuk" data-value-separator="<?php echo $t_admission->kd_rujuk->DisplayValueSeparatorAttribute() ?>" id="x_kd_rujuk" name="x_kd_rujuk"<?php echo $t_admission->kd_rujuk->EditAttributes() ?>>
<?php echo $t_admission->kd_rujuk->SelectOptionListHtml("x_kd_rujuk") ?>
</select>
<input type="hidden" name="s_x_kd_rujuk" id="s_x_kd_rujuk" value="<?php echo $t_admission->kd_rujuk->LookupFilterQuery() ?>">
</span>
<?php echo $t_admission->kd_rujuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->st_bayar->Visible) { // st_bayar ?>
	<div id="r_st_bayar" class="form-group">
		<label id="elh_t_admission_st_bayar" for="x_st_bayar" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->st_bayar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->st_bayar->CellAttributes() ?>>
<span id="el_t_admission_st_bayar">
<input type="text" data-table="t_admission" data-field="x_st_bayar" name="x_st_bayar" id="x_st_bayar" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->st_bayar->getPlaceHolder()) ?>" value="<?php echo $t_admission->st_bayar->EditValue ?>"<?php echo $t_admission->st_bayar->EditAttributes() ?>>
</span>
<?php echo $t_admission->st_bayar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->dokter_penanggungjawab->Visible) { // dokter_penanggungjawab ?>
	<div id="r_dokter_penanggungjawab" class="form-group">
		<label id="elh_t_admission_dokter_penanggungjawab" for="x_dokter_penanggungjawab" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->dokter_penanggungjawab->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->dokter_penanggungjawab->CellAttributes() ?>>
<span id="el_t_admission_dokter_penanggungjawab">
<select data-table="t_admission" data-field="x_dokter_penanggungjawab" data-value-separator="<?php echo $t_admission->dokter_penanggungjawab->DisplayValueSeparatorAttribute() ?>" id="x_dokter_penanggungjawab" name="x_dokter_penanggungjawab"<?php echo $t_admission->dokter_penanggungjawab->EditAttributes() ?>>
<?php echo $t_admission->dokter_penanggungjawab->SelectOptionListHtml("x_dokter_penanggungjawab") ?>
</select>
<input type="hidden" name="s_x_dokter_penanggungjawab" id="s_x_dokter_penanggungjawab" value="<?php echo $t_admission->dokter_penanggungjawab->LookupFilterQuery() ?>">
</span>
<?php echo $t_admission->dokter_penanggungjawab->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->perawat->Visible) { // perawat ?>
	<div id="r_perawat" class="form-group">
		<label id="elh_t_admission_perawat" for="x_perawat" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->perawat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->perawat->CellAttributes() ?>>
<span id="el_t_admission_perawat">
<input type="text" data-table="t_admission" data-field="x_perawat" name="x_perawat" id="x_perawat" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->perawat->getPlaceHolder()) ?>" value="<?php echo $t_admission->perawat->EditValue ?>"<?php echo $t_admission->perawat->EditAttributes() ?>>
</span>
<?php echo $t_admission->perawat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<div id="r_KELASPERAWATAN_ID" class="form-group">
		<label id="elh_t_admission_KELASPERAWATAN_ID" for="x_KELASPERAWATAN_ID" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->KELASPERAWATAN_ID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->KELASPERAWATAN_ID->CellAttributes() ?>>
<span id="el_t_admission_KELASPERAWATAN_ID">
<select data-table="t_admission" data-field="x_KELASPERAWATAN_ID" data-value-separator="<?php echo $t_admission->KELASPERAWATAN_ID->DisplayValueSeparatorAttribute() ?>" id="x_KELASPERAWATAN_ID" name="x_KELASPERAWATAN_ID"<?php echo $t_admission->KELASPERAWATAN_ID->EditAttributes() ?>>
<?php echo $t_admission->KELASPERAWATAN_ID->SelectOptionListHtml("x_KELASPERAWATAN_ID") ?>
</select>
<input type="hidden" name="s_x_KELASPERAWATAN_ID" id="s_x_KELASPERAWATAN_ID" value="<?php echo $t_admission->KELASPERAWATAN_ID->LookupFilterQuery() ?>">
</span>
<?php echo $t_admission->KELASPERAWATAN_ID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->LOS->Visible) { // LOS ?>
	<div id="r_LOS" class="form-group">
		<label id="elh_t_admission_LOS" for="x_LOS" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->LOS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->LOS->CellAttributes() ?>>
<span id="el_t_admission_LOS">
<input type="text" data-table="t_admission" data-field="x_LOS" name="x_LOS" id="x_LOS" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->LOS->getPlaceHolder()) ?>" value="<?php echo $t_admission->LOS->EditValue ?>"<?php echo $t_admission->LOS->EditAttributes() ?>>
</span>
<?php echo $t_admission->LOS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_TRF_TIND_DOKTER->Visible) { // TOT_TRF_TIND_DOKTER ?>
	<div id="r_TOT_TRF_TIND_DOKTER" class="form-group">
		<label id="elh_t_admission_TOT_TRF_TIND_DOKTER" for="x_TOT_TRF_TIND_DOKTER" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_TRF_TIND_DOKTER->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_TRF_TIND_DOKTER->CellAttributes() ?>>
<span id="el_t_admission_TOT_TRF_TIND_DOKTER">
<input type="text" data-table="t_admission" data-field="x_TOT_TRF_TIND_DOKTER" name="x_TOT_TRF_TIND_DOKTER" id="x_TOT_TRF_TIND_DOKTER" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_TRF_TIND_DOKTER->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_TRF_TIND_DOKTER->EditValue ?>"<?php echo $t_admission->TOT_TRF_TIND_DOKTER->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_TRF_TIND_DOKTER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BHP_DOKTER->Visible) { // TOT_BHP_DOKTER ?>
	<div id="r_TOT_BHP_DOKTER" class="form-group">
		<label id="elh_t_admission_TOT_BHP_DOKTER" for="x_TOT_BHP_DOKTER" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BHP_DOKTER->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BHP_DOKTER->CellAttributes() ?>>
<span id="el_t_admission_TOT_BHP_DOKTER">
<input type="text" data-table="t_admission" data-field="x_TOT_BHP_DOKTER" name="x_TOT_BHP_DOKTER" id="x_TOT_BHP_DOKTER" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BHP_DOKTER->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BHP_DOKTER->EditValue ?>"<?php echo $t_admission->TOT_BHP_DOKTER->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BHP_DOKTER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_TRF_PERAWAT->Visible) { // TOT_TRF_PERAWAT ?>
	<div id="r_TOT_TRF_PERAWAT" class="form-group">
		<label id="elh_t_admission_TOT_TRF_PERAWAT" for="x_TOT_TRF_PERAWAT" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_TRF_PERAWAT->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_TRF_PERAWAT->CellAttributes() ?>>
<span id="el_t_admission_TOT_TRF_PERAWAT">
<input type="text" data-table="t_admission" data-field="x_TOT_TRF_PERAWAT" name="x_TOT_TRF_PERAWAT" id="x_TOT_TRF_PERAWAT" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_TRF_PERAWAT->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_TRF_PERAWAT->EditValue ?>"<?php echo $t_admission->TOT_TRF_PERAWAT->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_TRF_PERAWAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BHP_PERAWAT->Visible) { // TOT_BHP_PERAWAT ?>
	<div id="r_TOT_BHP_PERAWAT" class="form-group">
		<label id="elh_t_admission_TOT_BHP_PERAWAT" for="x_TOT_BHP_PERAWAT" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BHP_PERAWAT->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BHP_PERAWAT->CellAttributes() ?>>
<span id="el_t_admission_TOT_BHP_PERAWAT">
<input type="text" data-table="t_admission" data-field="x_TOT_BHP_PERAWAT" name="x_TOT_BHP_PERAWAT" id="x_TOT_BHP_PERAWAT" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BHP_PERAWAT->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BHP_PERAWAT->EditValue ?>"<?php echo $t_admission->TOT_BHP_PERAWAT->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BHP_PERAWAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_TRF_DOKTER->Visible) { // TOT_TRF_DOKTER ?>
	<div id="r_TOT_TRF_DOKTER" class="form-group">
		<label id="elh_t_admission_TOT_TRF_DOKTER" for="x_TOT_TRF_DOKTER" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_TRF_DOKTER->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_TRF_DOKTER->CellAttributes() ?>>
<span id="el_t_admission_TOT_TRF_DOKTER">
<input type="text" data-table="t_admission" data-field="x_TOT_TRF_DOKTER" name="x_TOT_TRF_DOKTER" id="x_TOT_TRF_DOKTER" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_TRF_DOKTER->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_TRF_DOKTER->EditValue ?>"<?php echo $t_admission->TOT_TRF_DOKTER->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_TRF_DOKTER->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_RAD->Visible) { // TOT_BIAYA_RAD ?>
	<div id="r_TOT_BIAYA_RAD" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_RAD" for="x_TOT_BIAYA_RAD" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_RAD->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_RAD->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_RAD">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_RAD" name="x_TOT_BIAYA_RAD" id="x_TOT_BIAYA_RAD" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_RAD->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_RAD->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_RAD->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_RAD->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_CDRPOLI->Visible) { // TOT_BIAYA_CDRPOLI ?>
	<div id="r_TOT_BIAYA_CDRPOLI" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_CDRPOLI" for="x_TOT_BIAYA_CDRPOLI" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_CDRPOLI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_CDRPOLI->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_CDRPOLI">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_CDRPOLI" name="x_TOT_BIAYA_CDRPOLI" id="x_TOT_BIAYA_CDRPOLI" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_CDRPOLI->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_CDRPOLI->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_CDRPOLI->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_CDRPOLI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_LAB_IGD->Visible) { // TOT_BIAYA_LAB_IGD ?>
	<div id="r_TOT_BIAYA_LAB_IGD" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_LAB_IGD" for="x_TOT_BIAYA_LAB_IGD" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_LAB_IGD->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_LAB_IGD->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_LAB_IGD">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_LAB_IGD" name="x_TOT_BIAYA_LAB_IGD" id="x_TOT_BIAYA_LAB_IGD" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_LAB_IGD->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_LAB_IGD->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_LAB_IGD->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_LAB_IGD->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_OKSIGEN->Visible) { // TOT_BIAYA_OKSIGEN ?>
	<div id="r_TOT_BIAYA_OKSIGEN" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_OKSIGEN" for="x_TOT_BIAYA_OKSIGEN" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_OKSIGEN->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_OKSIGEN->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_OKSIGEN">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_OKSIGEN" name="x_TOT_BIAYA_OKSIGEN" id="x_TOT_BIAYA_OKSIGEN" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_OKSIGEN->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_OKSIGEN->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_OKSIGEN->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_OKSIGEN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOTAL_BIAYA_OBAT->Visible) { // TOTAL_BIAYA_OBAT ?>
	<div id="r_TOTAL_BIAYA_OBAT" class="form-group">
		<label id="elh_t_admission_TOTAL_BIAYA_OBAT" for="x_TOTAL_BIAYA_OBAT" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOTAL_BIAYA_OBAT->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOTAL_BIAYA_OBAT->CellAttributes() ?>>
<span id="el_t_admission_TOTAL_BIAYA_OBAT">
<input type="text" data-table="t_admission" data-field="x_TOTAL_BIAYA_OBAT" name="x_TOTAL_BIAYA_OBAT" id="x_TOTAL_BIAYA_OBAT" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOTAL_BIAYA_OBAT->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOTAL_BIAYA_OBAT->EditValue ?>"<?php echo $t_admission->TOTAL_BIAYA_OBAT->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOTAL_BIAYA_OBAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->LINK_SET_KELAS->Visible) { // LINK_SET_KELAS ?>
	<div id="r_LINK_SET_KELAS" class="form-group">
		<label id="elh_t_admission_LINK_SET_KELAS" for="x_LINK_SET_KELAS" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->LINK_SET_KELAS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->LINK_SET_KELAS->CellAttributes() ?>>
<span id="el_t_admission_LINK_SET_KELAS">
<input type="text" data-table="t_admission" data-field="x_LINK_SET_KELAS" name="x_LINK_SET_KELAS" id="x_LINK_SET_KELAS" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->LINK_SET_KELAS->getPlaceHolder()) ?>" value="<?php echo $t_admission->LINK_SET_KELAS->EditValue ?>"<?php echo $t_admission->LINK_SET_KELAS->EditAttributes() ?>>
</span>
<?php echo $t_admission->LINK_SET_KELAS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->biaya_obat->Visible) { // biaya_obat ?>
	<div id="r_biaya_obat" class="form-group">
		<label id="elh_t_admission_biaya_obat" for="x_biaya_obat" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->biaya_obat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->biaya_obat->CellAttributes() ?>>
<span id="el_t_admission_biaya_obat">
<input type="text" data-table="t_admission" data-field="x_biaya_obat" name="x_biaya_obat" id="x_biaya_obat" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->biaya_obat->getPlaceHolder()) ?>" value="<?php echo $t_admission->biaya_obat->EditValue ?>"<?php echo $t_admission->biaya_obat->EditAttributes() ?>>
</span>
<?php echo $t_admission->biaya_obat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->biaya_retur_obat->Visible) { // biaya_retur_obat ?>
	<div id="r_biaya_retur_obat" class="form-group">
		<label id="elh_t_admission_biaya_retur_obat" for="x_biaya_retur_obat" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->biaya_retur_obat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->biaya_retur_obat->CellAttributes() ?>>
<span id="el_t_admission_biaya_retur_obat">
<input type="text" data-table="t_admission" data-field="x_biaya_retur_obat" name="x_biaya_retur_obat" id="x_biaya_retur_obat" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->biaya_retur_obat->getPlaceHolder()) ?>" value="<?php echo $t_admission->biaya_retur_obat->EditValue ?>"<?php echo $t_admission->biaya_retur_obat->EditAttributes() ?>>
</span>
<?php echo $t_admission->biaya_retur_obat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_GIZI->Visible) { // TOT_BIAYA_GIZI ?>
	<div id="r_TOT_BIAYA_GIZI" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_GIZI" for="x_TOT_BIAYA_GIZI" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_GIZI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_GIZI->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_GIZI">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_GIZI" name="x_TOT_BIAYA_GIZI" id="x_TOT_BIAYA_GIZI" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_GIZI->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_GIZI->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_GIZI->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_GIZI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_TMO->Visible) { // TOT_BIAYA_TMO ?>
	<div id="r_TOT_BIAYA_TMO" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_TMO" for="x_TOT_BIAYA_TMO" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_TMO->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_TMO->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_TMO">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_TMO" name="x_TOT_BIAYA_TMO" id="x_TOT_BIAYA_TMO" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_TMO->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_TMO->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_TMO->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_TMO->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_AMBULAN->Visible) { // TOT_BIAYA_AMBULAN ?>
	<div id="r_TOT_BIAYA_AMBULAN" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_AMBULAN" for="x_TOT_BIAYA_AMBULAN" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_AMBULAN->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_AMBULAN->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_AMBULAN">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_AMBULAN" name="x_TOT_BIAYA_AMBULAN" id="x_TOT_BIAYA_AMBULAN" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_AMBULAN->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_AMBULAN->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_AMBULAN->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_AMBULAN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_FISIO->Visible) { // TOT_BIAYA_FISIO ?>
	<div id="r_TOT_BIAYA_FISIO" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_FISIO" for="x_TOT_BIAYA_FISIO" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_FISIO->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_FISIO->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_FISIO">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_FISIO" name="x_TOT_BIAYA_FISIO" id="x_TOT_BIAYA_FISIO" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_FISIO->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_FISIO->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_FISIO->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_FISIO->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_LAINLAIN->Visible) { // TOT_BIAYA_LAINLAIN ?>
	<div id="r_TOT_BIAYA_LAINLAIN" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_LAINLAIN" for="x_TOT_BIAYA_LAINLAIN" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_LAINLAIN->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_LAINLAIN->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_LAINLAIN">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_LAINLAIN" name="x_TOT_BIAYA_LAINLAIN" id="x_TOT_BIAYA_LAINLAIN" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_LAINLAIN->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_LAINLAIN->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_LAINLAIN->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_LAINLAIN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->jenisperawatan_id->Visible) { // jenisperawatan_id ?>
	<div id="r_jenisperawatan_id" class="form-group">
		<label id="elh_t_admission_jenisperawatan_id" for="x_jenisperawatan_id" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->jenisperawatan_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->jenisperawatan_id->CellAttributes() ?>>
<span id="el_t_admission_jenisperawatan_id">
<input type="text" data-table="t_admission" data-field="x_jenisperawatan_id" name="x_jenisperawatan_id" id="x_jenisperawatan_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->jenisperawatan_id->getPlaceHolder()) ?>" value="<?php echo $t_admission->jenisperawatan_id->EditValue ?>"<?php echo $t_admission->jenisperawatan_id->EditAttributes() ?>>
</span>
<?php echo $t_admission->jenisperawatan_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->status_transaksi->Visible) { // status_transaksi ?>
	<div id="r_status_transaksi" class="form-group">
		<label id="elh_t_admission_status_transaksi" for="x_status_transaksi" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->status_transaksi->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->status_transaksi->CellAttributes() ?>>
<span id="el_t_admission_status_transaksi">
<input type="text" data-table="t_admission" data-field="x_status_transaksi" name="x_status_transaksi" id="x_status_transaksi" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->status_transaksi->getPlaceHolder()) ?>" value="<?php echo $t_admission->status_transaksi->EditValue ?>"<?php echo $t_admission->status_transaksi->EditAttributes() ?>>
</span>
<?php echo $t_admission->status_transaksi->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->statuskeluarranap_id->Visible) { // statuskeluarranap_id ?>
	<div id="r_statuskeluarranap_id" class="form-group">
		<label id="elh_t_admission_statuskeluarranap_id" for="x_statuskeluarranap_id" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->statuskeluarranap_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->statuskeluarranap_id->CellAttributes() ?>>
<span id="el_t_admission_statuskeluarranap_id">
<input type="text" data-table="t_admission" data-field="x_statuskeluarranap_id" name="x_statuskeluarranap_id" id="x_statuskeluarranap_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->statuskeluarranap_id->getPlaceHolder()) ?>" value="<?php echo $t_admission->statuskeluarranap_id->EditValue ?>"<?php echo $t_admission->statuskeluarranap_id->EditAttributes() ?>>
</span>
<?php echo $t_admission->statuskeluarranap_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_AKOMODASI->Visible) { // TOT_BIAYA_AKOMODASI ?>
	<div id="r_TOT_BIAYA_AKOMODASI" class="form-group">
		<label id="elh_t_admission_TOT_BIAYA_AKOMODASI" for="x_TOT_BIAYA_AKOMODASI" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_BIAYA_AKOMODASI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_BIAYA_AKOMODASI->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_AKOMODASI">
<input type="text" data-table="t_admission" data-field="x_TOT_BIAYA_AKOMODASI" name="x_TOT_BIAYA_AKOMODASI" id="x_TOT_BIAYA_AKOMODASI" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_BIAYA_AKOMODASI->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_BIAYA_AKOMODASI->EditValue ?>"<?php echo $t_admission->TOT_BIAYA_AKOMODASI->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_BIAYA_AKOMODASI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOTAL_BIAYA_ASKEP->Visible) { // TOTAL_BIAYA_ASKEP ?>
	<div id="r_TOTAL_BIAYA_ASKEP" class="form-group">
		<label id="elh_t_admission_TOTAL_BIAYA_ASKEP" for="x_TOTAL_BIAYA_ASKEP" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOTAL_BIAYA_ASKEP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOTAL_BIAYA_ASKEP->CellAttributes() ?>>
<span id="el_t_admission_TOTAL_BIAYA_ASKEP">
<input type="text" data-table="t_admission" data-field="x_TOTAL_BIAYA_ASKEP" name="x_TOTAL_BIAYA_ASKEP" id="x_TOTAL_BIAYA_ASKEP" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOTAL_BIAYA_ASKEP->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOTAL_BIAYA_ASKEP->EditValue ?>"<?php echo $t_admission->TOTAL_BIAYA_ASKEP->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOTAL_BIAYA_ASKEP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOTAL_BIAYA_SIMRS->Visible) { // TOTAL_BIAYA_SIMRS ?>
	<div id="r_TOTAL_BIAYA_SIMRS" class="form-group">
		<label id="elh_t_admission_TOTAL_BIAYA_SIMRS" for="x_TOTAL_BIAYA_SIMRS" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOTAL_BIAYA_SIMRS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOTAL_BIAYA_SIMRS->CellAttributes() ?>>
<span id="el_t_admission_TOTAL_BIAYA_SIMRS">
<input type="text" data-table="t_admission" data-field="x_TOTAL_BIAYA_SIMRS" name="x_TOTAL_BIAYA_SIMRS" id="x_TOTAL_BIAYA_SIMRS" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOTAL_BIAYA_SIMRS->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOTAL_BIAYA_SIMRS->EditValue ?>"<?php echo $t_admission->TOTAL_BIAYA_SIMRS->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOTAL_BIAYA_SIMRS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_PENJ_NMEDIS->Visible) { // TOT_PENJ_NMEDIS ?>
	<div id="r_TOT_PENJ_NMEDIS" class="form-group">
		<label id="elh_t_admission_TOT_PENJ_NMEDIS" for="x_TOT_PENJ_NMEDIS" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_PENJ_NMEDIS->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_PENJ_NMEDIS->CellAttributes() ?>>
<span id="el_t_admission_TOT_PENJ_NMEDIS">
<input type="text" data-table="t_admission" data-field="x_TOT_PENJ_NMEDIS" name="x_TOT_PENJ_NMEDIS" id="x_TOT_PENJ_NMEDIS" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_PENJ_NMEDIS->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_PENJ_NMEDIS->EditValue ?>"<?php echo $t_admission->TOT_PENJ_NMEDIS->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_PENJ_NMEDIS->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->LINK_MASTERDETAIL->Visible) { // LINK_MASTERDETAIL ?>
	<div id="r_LINK_MASTERDETAIL" class="form-group">
		<label id="elh_t_admission_LINK_MASTERDETAIL" for="x_LINK_MASTERDETAIL" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->LINK_MASTERDETAIL->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->LINK_MASTERDETAIL->CellAttributes() ?>>
<span id="el_t_admission_LINK_MASTERDETAIL">
<input type="text" data-table="t_admission" data-field="x_LINK_MASTERDETAIL" name="x_LINK_MASTERDETAIL" id="x_LINK_MASTERDETAIL" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->LINK_MASTERDETAIL->getPlaceHolder()) ?>" value="<?php echo $t_admission->LINK_MASTERDETAIL->EditValue ?>"<?php echo $t_admission->LINK_MASTERDETAIL->EditAttributes() ?>>
</span>
<?php echo $t_admission->LINK_MASTERDETAIL->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->NO_SKP->Visible) { // NO_SKP ?>
	<div id="r_NO_SKP" class="form-group">
		<label id="elh_t_admission_NO_SKP" for="x_NO_SKP" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->NO_SKP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->NO_SKP->CellAttributes() ?>>
<span id="el_t_admission_NO_SKP">
<input type="text" data-table="t_admission" data-field="x_NO_SKP" name="x_NO_SKP" id="x_NO_SKP" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->NO_SKP->getPlaceHolder()) ?>" value="<?php echo $t_admission->NO_SKP->EditValue ?>"<?php echo $t_admission->NO_SKP->EditAttributes() ?>>
</span>
<?php echo $t_admission->NO_SKP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->LINK_PELAYANAN_OBAT->Visible) { // LINK_PELAYANAN_OBAT ?>
	<div id="r_LINK_PELAYANAN_OBAT" class="form-group">
		<label id="elh_t_admission_LINK_PELAYANAN_OBAT" for="x_LINK_PELAYANAN_OBAT" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->LINK_PELAYANAN_OBAT->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->LINK_PELAYANAN_OBAT->CellAttributes() ?>>
<span id="el_t_admission_LINK_PELAYANAN_OBAT">
<input type="text" data-table="t_admission" data-field="x_LINK_PELAYANAN_OBAT" name="x_LINK_PELAYANAN_OBAT" id="x_LINK_PELAYANAN_OBAT" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->LINK_PELAYANAN_OBAT->getPlaceHolder()) ?>" value="<?php echo $t_admission->LINK_PELAYANAN_OBAT->EditValue ?>"<?php echo $t_admission->LINK_PELAYANAN_OBAT->EditAttributes() ?>>
</span>
<?php echo $t_admission->LINK_PELAYANAN_OBAT->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_TIND_RAJAL->Visible) { // TOT_TIND_RAJAL ?>
	<div id="r_TOT_TIND_RAJAL" class="form-group">
		<label id="elh_t_admission_TOT_TIND_RAJAL" for="x_TOT_TIND_RAJAL" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_TIND_RAJAL->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_TIND_RAJAL->CellAttributes() ?>>
<span id="el_t_admission_TOT_TIND_RAJAL">
<input type="text" data-table="t_admission" data-field="x_TOT_TIND_RAJAL" name="x_TOT_TIND_RAJAL" id="x_TOT_TIND_RAJAL" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_TIND_RAJAL->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_TIND_RAJAL->EditValue ?>"<?php echo $t_admission->TOT_TIND_RAJAL->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_TIND_RAJAL->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->TOT_TIND_IGD->Visible) { // TOT_TIND_IGD ?>
	<div id="r_TOT_TIND_IGD" class="form-group">
		<label id="elh_t_admission_TOT_TIND_IGD" for="x_TOT_TIND_IGD" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->TOT_TIND_IGD->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->TOT_TIND_IGD->CellAttributes() ?>>
<span id="el_t_admission_TOT_TIND_IGD">
<input type="text" data-table="t_admission" data-field="x_TOT_TIND_IGD" name="x_TOT_TIND_IGD" id="x_TOT_TIND_IGD" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->TOT_TIND_IGD->getPlaceHolder()) ?>" value="<?php echo $t_admission->TOT_TIND_IGD->EditValue ?>"<?php echo $t_admission->TOT_TIND_IGD->EditAttributes() ?>>
</span>
<?php echo $t_admission->TOT_TIND_IGD->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->tanggal_pengembalian_status->Visible) { // tanggal_pengembalian_status ?>
	<div id="r_tanggal_pengembalian_status" class="form-group">
		<label id="elh_t_admission_tanggal_pengembalian_status" for="x_tanggal_pengembalian_status" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->tanggal_pengembalian_status->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->tanggal_pengembalian_status->CellAttributes() ?>>
<span id="el_t_admission_tanggal_pengembalian_status">
<input type="text" data-table="t_admission" data-field="x_tanggal_pengembalian_status" name="x_tanggal_pengembalian_status" id="x_tanggal_pengembalian_status" placeholder="<?php echo ew_HtmlEncode($t_admission->tanggal_pengembalian_status->getPlaceHolder()) ?>" value="<?php echo $t_admission->tanggal_pengembalian_status->EditValue ?>"<?php echo $t_admission->tanggal_pengembalian_status->EditAttributes() ?>>
</span>
<?php echo $t_admission->tanggal_pengembalian_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->naik_kelas->Visible) { // naik_kelas ?>
	<div id="r_naik_kelas" class="form-group">
		<label id="elh_t_admission_naik_kelas" for="x_naik_kelas" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->naik_kelas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->naik_kelas->CellAttributes() ?>>
<span id="el_t_admission_naik_kelas">
<input type="text" data-table="t_admission" data-field="x_naik_kelas" name="x_naik_kelas" id="x_naik_kelas" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->naik_kelas->getPlaceHolder()) ?>" value="<?php echo $t_admission->naik_kelas->EditValue ?>"<?php echo $t_admission->naik_kelas->EditAttributes() ?>>
</span>
<?php echo $t_admission->naik_kelas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->iuran_kelas_lama->Visible) { // iuran_kelas_lama ?>
	<div id="r_iuran_kelas_lama" class="form-group">
		<label id="elh_t_admission_iuran_kelas_lama" for="x_iuran_kelas_lama" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->iuran_kelas_lama->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->iuran_kelas_lama->CellAttributes() ?>>
<span id="el_t_admission_iuran_kelas_lama">
<input type="text" data-table="t_admission" data-field="x_iuran_kelas_lama" name="x_iuran_kelas_lama" id="x_iuran_kelas_lama" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->iuran_kelas_lama->getPlaceHolder()) ?>" value="<?php echo $t_admission->iuran_kelas_lama->EditValue ?>"<?php echo $t_admission->iuran_kelas_lama->EditAttributes() ?>>
</span>
<?php echo $t_admission->iuran_kelas_lama->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->iuran_kelas_baru->Visible) { // iuran_kelas_baru ?>
	<div id="r_iuran_kelas_baru" class="form-group">
		<label id="elh_t_admission_iuran_kelas_baru" for="x_iuran_kelas_baru" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->iuran_kelas_baru->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->iuran_kelas_baru->CellAttributes() ?>>
<span id="el_t_admission_iuran_kelas_baru">
<input type="text" data-table="t_admission" data-field="x_iuran_kelas_baru" name="x_iuran_kelas_baru" id="x_iuran_kelas_baru" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->iuran_kelas_baru->getPlaceHolder()) ?>" value="<?php echo $t_admission->iuran_kelas_baru->EditValue ?>"<?php echo $t_admission->iuran_kelas_baru->EditAttributes() ?>>
</span>
<?php echo $t_admission->iuran_kelas_baru->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ketrangan_naik_kelas->Visible) { // ketrangan_naik_kelas ?>
	<div id="r_ketrangan_naik_kelas" class="form-group">
		<label id="elh_t_admission_ketrangan_naik_kelas" for="x_ketrangan_naik_kelas" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->ketrangan_naik_kelas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ketrangan_naik_kelas->CellAttributes() ?>>
<span id="el_t_admission_ketrangan_naik_kelas">
<input type="text" data-table="t_admission" data-field="x_ketrangan_naik_kelas" name="x_ketrangan_naik_kelas" id="x_ketrangan_naik_kelas" size="30" maxlength="250" placeholder="<?php echo ew_HtmlEncode($t_admission->ketrangan_naik_kelas->getPlaceHolder()) ?>" value="<?php echo $t_admission->ketrangan_naik_kelas->EditValue ?>"<?php echo $t_admission->ketrangan_naik_kelas->EditAttributes() ?>>
</span>
<?php echo $t_admission->ketrangan_naik_kelas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->tgl_pengiriman_ad_klaim->Visible) { // tgl_pengiriman_ad_klaim ?>
	<div id="r_tgl_pengiriman_ad_klaim" class="form-group">
		<label id="elh_t_admission_tgl_pengiriman_ad_klaim" for="x_tgl_pengiriman_ad_klaim" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->tgl_pengiriman_ad_klaim->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->tgl_pengiriman_ad_klaim->CellAttributes() ?>>
<span id="el_t_admission_tgl_pengiriman_ad_klaim">
<input type="text" data-table="t_admission" data-field="x_tgl_pengiriman_ad_klaim" name="x_tgl_pengiriman_ad_klaim" id="x_tgl_pengiriman_ad_klaim" placeholder="<?php echo ew_HtmlEncode($t_admission->tgl_pengiriman_ad_klaim->getPlaceHolder()) ?>" value="<?php echo $t_admission->tgl_pengiriman_ad_klaim->EditValue ?>"<?php echo $t_admission->tgl_pengiriman_ad_klaim->EditAttributes() ?>>
</span>
<?php echo $t_admission->tgl_pengiriman_ad_klaim->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->diagnosa_keluar->Visible) { // diagnosa_keluar ?>
	<div id="r_diagnosa_keluar" class="form-group">
		<label id="elh_t_admission_diagnosa_keluar" for="x_diagnosa_keluar" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->diagnosa_keluar->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->diagnosa_keluar->CellAttributes() ?>>
<span id="el_t_admission_diagnosa_keluar">
<input type="text" data-table="t_admission" data-field="x_diagnosa_keluar" name="x_diagnosa_keluar" id="x_diagnosa_keluar" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->diagnosa_keluar->getPlaceHolder()) ?>" value="<?php echo $t_admission->diagnosa_keluar->EditValue ?>"<?php echo $t_admission->diagnosa_keluar->EditAttributes() ?>>
</span>
<?php echo $t_admission->diagnosa_keluar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_tglsep->Visible) { // sep_tglsep ?>
	<div id="r_sep_tglsep" class="form-group">
		<label id="elh_t_admission_sep_tglsep" for="x_sep_tglsep" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_tglsep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_tglsep->CellAttributes() ?>>
<span id="el_t_admission_sep_tglsep">
<input type="text" data-table="t_admission" data-field="x_sep_tglsep" name="x_sep_tglsep" id="x_sep_tglsep" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_tglsep->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_tglsep->EditValue ?>"<?php echo $t_admission->sep_tglsep->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_tglsep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_tglrujuk->Visible) { // sep_tglrujuk ?>
	<div id="r_sep_tglrujuk" class="form-group">
		<label id="elh_t_admission_sep_tglrujuk" for="x_sep_tglrujuk" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_tglrujuk->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_tglrujuk->CellAttributes() ?>>
<span id="el_t_admission_sep_tglrujuk">
<input type="text" data-table="t_admission" data-field="x_sep_tglrujuk" name="x_sep_tglrujuk" id="x_sep_tglrujuk" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_tglrujuk->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_tglrujuk->EditValue ?>"<?php echo $t_admission->sep_tglrujuk->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_tglrujuk->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_kodekelasrawat->Visible) { // sep_kodekelasrawat ?>
	<div id="r_sep_kodekelasrawat" class="form-group">
		<label id="elh_t_admission_sep_kodekelasrawat" for="x_sep_kodekelasrawat" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_kodekelasrawat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_kodekelasrawat->CellAttributes() ?>>
<span id="el_t_admission_sep_kodekelasrawat">
<input type="text" data-table="t_admission" data-field="x_sep_kodekelasrawat" name="x_sep_kodekelasrawat" id="x_sep_kodekelasrawat" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_kodekelasrawat->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_kodekelasrawat->EditValue ?>"<?php echo $t_admission->sep_kodekelasrawat->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_kodekelasrawat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_norujukan->Visible) { // sep_norujukan ?>
	<div id="r_sep_norujukan" class="form-group">
		<label id="elh_t_admission_sep_norujukan" for="x_sep_norujukan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_norujukan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_norujukan->CellAttributes() ?>>
<span id="el_t_admission_sep_norujukan">
<input type="text" data-table="t_admission" data-field="x_sep_norujukan" name="x_sep_norujukan" id="x_sep_norujukan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_norujukan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_norujukan->EditValue ?>"<?php echo $t_admission->sep_norujukan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_norujukan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_kodeppkasal->Visible) { // sep_kodeppkasal ?>
	<div id="r_sep_kodeppkasal" class="form-group">
		<label id="elh_t_admission_sep_kodeppkasal" for="x_sep_kodeppkasal" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_kodeppkasal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_kodeppkasal->CellAttributes() ?>>
<span id="el_t_admission_sep_kodeppkasal">
<input type="text" data-table="t_admission" data-field="x_sep_kodeppkasal" name="x_sep_kodeppkasal" id="x_sep_kodeppkasal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_kodeppkasal->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_kodeppkasal->EditValue ?>"<?php echo $t_admission->sep_kodeppkasal->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_kodeppkasal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_namappkasal->Visible) { // sep_namappkasal ?>
	<div id="r_sep_namappkasal" class="form-group">
		<label id="elh_t_admission_sep_namappkasal" for="x_sep_namappkasal" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_namappkasal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_namappkasal->CellAttributes() ?>>
<span id="el_t_admission_sep_namappkasal">
<input type="text" data-table="t_admission" data-field="x_sep_namappkasal" name="x_sep_namappkasal" id="x_sep_namappkasal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_namappkasal->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_namappkasal->EditValue ?>"<?php echo $t_admission->sep_namappkasal->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_namappkasal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_kodeppkpelayanan->Visible) { // sep_kodeppkpelayanan ?>
	<div id="r_sep_kodeppkpelayanan" class="form-group">
		<label id="elh_t_admission_sep_kodeppkpelayanan" for="x_sep_kodeppkpelayanan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_kodeppkpelayanan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_kodeppkpelayanan->CellAttributes() ?>>
<span id="el_t_admission_sep_kodeppkpelayanan">
<input type="text" data-table="t_admission" data-field="x_sep_kodeppkpelayanan" name="x_sep_kodeppkpelayanan" id="x_sep_kodeppkpelayanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_kodeppkpelayanan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_kodeppkpelayanan->EditValue ?>"<?php echo $t_admission->sep_kodeppkpelayanan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_kodeppkpelayanan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_namappkpelayanan->Visible) { // sep_namappkpelayanan ?>
	<div id="r_sep_namappkpelayanan" class="form-group">
		<label id="elh_t_admission_sep_namappkpelayanan" for="x_sep_namappkpelayanan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_namappkpelayanan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_namappkpelayanan->CellAttributes() ?>>
<span id="el_t_admission_sep_namappkpelayanan">
<input type="text" data-table="t_admission" data-field="x_sep_namappkpelayanan" name="x_sep_namappkpelayanan" id="x_sep_namappkpelayanan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_namappkpelayanan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_namappkpelayanan->EditValue ?>"<?php echo $t_admission->sep_namappkpelayanan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_namappkpelayanan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->t_admissioncol->Visible) { // t_admissioncol ?>
	<div id="r_t_admissioncol" class="form-group">
		<label id="elh_t_admission_t_admissioncol" for="x_t_admissioncol" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->t_admissioncol->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->t_admissioncol->CellAttributes() ?>>
<span id="el_t_admission_t_admissioncol">
<input type="text" data-table="t_admission" data-field="x_t_admissioncol" name="x_t_admissioncol" id="x_t_admissioncol" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->t_admissioncol->getPlaceHolder()) ?>" value="<?php echo $t_admission->t_admissioncol->EditValue ?>"<?php echo $t_admission->t_admissioncol->EditAttributes() ?>>
</span>
<?php echo $t_admission->t_admissioncol->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_jenisperawatan->Visible) { // sep_jenisperawatan ?>
	<div id="r_sep_jenisperawatan" class="form-group">
		<label id="elh_t_admission_sep_jenisperawatan" for="x_sep_jenisperawatan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_jenisperawatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_jenisperawatan->CellAttributes() ?>>
<span id="el_t_admission_sep_jenisperawatan">
<input type="text" data-table="t_admission" data-field="x_sep_jenisperawatan" name="x_sep_jenisperawatan" id="x_sep_jenisperawatan" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_jenisperawatan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_jenisperawatan->EditValue ?>"<?php echo $t_admission->sep_jenisperawatan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_jenisperawatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_catatan->Visible) { // sep_catatan ?>
	<div id="r_sep_catatan" class="form-group">
		<label id="elh_t_admission_sep_catatan" for="x_sep_catatan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_catatan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_catatan->CellAttributes() ?>>
<span id="el_t_admission_sep_catatan">
<input type="text" data-table="t_admission" data-field="x_sep_catatan" name="x_sep_catatan" id="x_sep_catatan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_catatan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_catatan->EditValue ?>"<?php echo $t_admission->sep_catatan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_catatan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_kodediagnosaawal->Visible) { // sep_kodediagnosaawal ?>
	<div id="r_sep_kodediagnosaawal" class="form-group">
		<label id="elh_t_admission_sep_kodediagnosaawal" for="x_sep_kodediagnosaawal" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_kodediagnosaawal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_kodediagnosaawal->CellAttributes() ?>>
<span id="el_t_admission_sep_kodediagnosaawal">
<input type="text" data-table="t_admission" data-field="x_sep_kodediagnosaawal" name="x_sep_kodediagnosaawal" id="x_sep_kodediagnosaawal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_kodediagnosaawal->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_kodediagnosaawal->EditValue ?>"<?php echo $t_admission->sep_kodediagnosaawal->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_kodediagnosaawal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_namadiagnosaawal->Visible) { // sep_namadiagnosaawal ?>
	<div id="r_sep_namadiagnosaawal" class="form-group">
		<label id="elh_t_admission_sep_namadiagnosaawal" for="x_sep_namadiagnosaawal" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_namadiagnosaawal->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_namadiagnosaawal->CellAttributes() ?>>
<span id="el_t_admission_sep_namadiagnosaawal">
<input type="text" data-table="t_admission" data-field="x_sep_namadiagnosaawal" name="x_sep_namadiagnosaawal" id="x_sep_namadiagnosaawal" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_namadiagnosaawal->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_namadiagnosaawal->EditValue ?>"<?php echo $t_admission->sep_namadiagnosaawal->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_namadiagnosaawal->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_lakalantas->Visible) { // sep_lakalantas ?>
	<div id="r_sep_lakalantas" class="form-group">
		<label id="elh_t_admission_sep_lakalantas" for="x_sep_lakalantas" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_lakalantas->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_lakalantas->CellAttributes() ?>>
<span id="el_t_admission_sep_lakalantas">
<input type="text" data-table="t_admission" data-field="x_sep_lakalantas" name="x_sep_lakalantas" id="x_sep_lakalantas" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_lakalantas->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_lakalantas->EditValue ?>"<?php echo $t_admission->sep_lakalantas->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_lakalantas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_lokasilaka->Visible) { // sep_lokasilaka ?>
	<div id="r_sep_lokasilaka" class="form-group">
		<label id="elh_t_admission_sep_lokasilaka" for="x_sep_lokasilaka" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_lokasilaka->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_lokasilaka->CellAttributes() ?>>
<span id="el_t_admission_sep_lokasilaka">
<input type="text" data-table="t_admission" data-field="x_sep_lokasilaka" name="x_sep_lokasilaka" id="x_sep_lokasilaka" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_lokasilaka->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_lokasilaka->EditValue ?>"<?php echo $t_admission->sep_lokasilaka->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_lokasilaka->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_user->Visible) { // sep_user ?>
	<div id="r_sep_user" class="form-group">
		<label id="elh_t_admission_sep_user" for="x_sep_user" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_user->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_user->CellAttributes() ?>>
<span id="el_t_admission_sep_user">
<input type="text" data-table="t_admission" data-field="x_sep_user" name="x_sep_user" id="x_sep_user" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_user->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_user->EditValue ?>"<?php echo $t_admission->sep_user->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_user->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_flag_cekpeserta->Visible) { // sep_flag_cekpeserta ?>
	<div id="r_sep_flag_cekpeserta" class="form-group">
		<label id="elh_t_admission_sep_flag_cekpeserta" for="x_sep_flag_cekpeserta" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_flag_cekpeserta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_flag_cekpeserta->CellAttributes() ?>>
<span id="el_t_admission_sep_flag_cekpeserta">
<input type="text" data-table="t_admission" data-field="x_sep_flag_cekpeserta" name="x_sep_flag_cekpeserta" id="x_sep_flag_cekpeserta" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_flag_cekpeserta->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_flag_cekpeserta->EditValue ?>"<?php echo $t_admission->sep_flag_cekpeserta->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_flag_cekpeserta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_flag_generatesep->Visible) { // sep_flag_generatesep ?>
	<div id="r_sep_flag_generatesep" class="form-group">
		<label id="elh_t_admission_sep_flag_generatesep" for="x_sep_flag_generatesep" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_flag_generatesep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_flag_generatesep->CellAttributes() ?>>
<span id="el_t_admission_sep_flag_generatesep">
<input type="text" data-table="t_admission" data-field="x_sep_flag_generatesep" name="x_sep_flag_generatesep" id="x_sep_flag_generatesep" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_flag_generatesep->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_flag_generatesep->EditValue ?>"<?php echo $t_admission->sep_flag_generatesep->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_flag_generatesep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_flag_mapingsep->Visible) { // sep_flag_mapingsep ?>
	<div id="r_sep_flag_mapingsep" class="form-group">
		<label id="elh_t_admission_sep_flag_mapingsep" for="x_sep_flag_mapingsep" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_flag_mapingsep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_flag_mapingsep->CellAttributes() ?>>
<span id="el_t_admission_sep_flag_mapingsep">
<input type="text" data-table="t_admission" data-field="x_sep_flag_mapingsep" name="x_sep_flag_mapingsep" id="x_sep_flag_mapingsep" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_flag_mapingsep->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_flag_mapingsep->EditValue ?>"<?php echo $t_admission->sep_flag_mapingsep->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_flag_mapingsep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_nik->Visible) { // sep_nik ?>
	<div id="r_sep_nik" class="form-group">
		<label id="elh_t_admission_sep_nik" for="x_sep_nik" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_nik->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_nik->CellAttributes() ?>>
<span id="el_t_admission_sep_nik">
<input type="text" data-table="t_admission" data-field="x_sep_nik" name="x_sep_nik" id="x_sep_nik" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_nik->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_nik->EditValue ?>"<?php echo $t_admission->sep_nik->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_nik->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_namapeserta->Visible) { // sep_namapeserta ?>
	<div id="r_sep_namapeserta" class="form-group">
		<label id="elh_t_admission_sep_namapeserta" for="x_sep_namapeserta" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_namapeserta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_namapeserta->CellAttributes() ?>>
<span id="el_t_admission_sep_namapeserta">
<input type="text" data-table="t_admission" data-field="x_sep_namapeserta" name="x_sep_namapeserta" id="x_sep_namapeserta" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_namapeserta->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_namapeserta->EditValue ?>"<?php echo $t_admission->sep_namapeserta->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_namapeserta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_jeniskelamin->Visible) { // sep_jeniskelamin ?>
	<div id="r_sep_jeniskelamin" class="form-group">
		<label id="elh_t_admission_sep_jeniskelamin" for="x_sep_jeniskelamin" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_jeniskelamin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_jeniskelamin->CellAttributes() ?>>
<span id="el_t_admission_sep_jeniskelamin">
<input type="text" data-table="t_admission" data-field="x_sep_jeniskelamin" name="x_sep_jeniskelamin" id="x_sep_jeniskelamin" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_jeniskelamin->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_jeniskelamin->EditValue ?>"<?php echo $t_admission->sep_jeniskelamin->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_jeniskelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_pisat->Visible) { // sep_pisat ?>
	<div id="r_sep_pisat" class="form-group">
		<label id="elh_t_admission_sep_pisat" for="x_sep_pisat" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_pisat->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_pisat->CellAttributes() ?>>
<span id="el_t_admission_sep_pisat">
<input type="text" data-table="t_admission" data-field="x_sep_pisat" name="x_sep_pisat" id="x_sep_pisat" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_pisat->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_pisat->EditValue ?>"<?php echo $t_admission->sep_pisat->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_pisat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_tgllahir->Visible) { // sep_tgllahir ?>
	<div id="r_sep_tgllahir" class="form-group">
		<label id="elh_t_admission_sep_tgllahir" for="x_sep_tgllahir" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_tgllahir->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_tgllahir->CellAttributes() ?>>
<span id="el_t_admission_sep_tgllahir">
<input type="text" data-table="t_admission" data-field="x_sep_tgllahir" name="x_sep_tgllahir" id="x_sep_tgllahir" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_tgllahir->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_tgllahir->EditValue ?>"<?php echo $t_admission->sep_tgllahir->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_tgllahir->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_kodejeniskepesertaan->Visible) { // sep_kodejeniskepesertaan ?>
	<div id="r_sep_kodejeniskepesertaan" class="form-group">
		<label id="elh_t_admission_sep_kodejeniskepesertaan" for="x_sep_kodejeniskepesertaan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_kodejeniskepesertaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_kodejeniskepesertaan->CellAttributes() ?>>
<span id="el_t_admission_sep_kodejeniskepesertaan">
<input type="text" data-table="t_admission" data-field="x_sep_kodejeniskepesertaan" name="x_sep_kodejeniskepesertaan" id="x_sep_kodejeniskepesertaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_kodejeniskepesertaan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_kodejeniskepesertaan->EditValue ?>"<?php echo $t_admission->sep_kodejeniskepesertaan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_kodejeniskepesertaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_namajeniskepesertaan->Visible) { // sep_namajeniskepesertaan ?>
	<div id="r_sep_namajeniskepesertaan" class="form-group">
		<label id="elh_t_admission_sep_namajeniskepesertaan" for="x_sep_namajeniskepesertaan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_namajeniskepesertaan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_namajeniskepesertaan->CellAttributes() ?>>
<span id="el_t_admission_sep_namajeniskepesertaan">
<input type="text" data-table="t_admission" data-field="x_sep_namajeniskepesertaan" name="x_sep_namajeniskepesertaan" id="x_sep_namajeniskepesertaan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_namajeniskepesertaan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_namajeniskepesertaan->EditValue ?>"<?php echo $t_admission->sep_namajeniskepesertaan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_namajeniskepesertaan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_kodepolitujuan->Visible) { // sep_kodepolitujuan ?>
	<div id="r_sep_kodepolitujuan" class="form-group">
		<label id="elh_t_admission_sep_kodepolitujuan" for="x_sep_kodepolitujuan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_kodepolitujuan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_kodepolitujuan->CellAttributes() ?>>
<span id="el_t_admission_sep_kodepolitujuan">
<input type="text" data-table="t_admission" data-field="x_sep_kodepolitujuan" name="x_sep_kodepolitujuan" id="x_sep_kodepolitujuan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_kodepolitujuan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_kodepolitujuan->EditValue ?>"<?php echo $t_admission->sep_kodepolitujuan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_kodepolitujuan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_namapolitujuan->Visible) { // sep_namapolitujuan ?>
	<div id="r_sep_namapolitujuan" class="form-group">
		<label id="elh_t_admission_sep_namapolitujuan" for="x_sep_namapolitujuan" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_namapolitujuan->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_namapolitujuan->CellAttributes() ?>>
<span id="el_t_admission_sep_namapolitujuan">
<input type="text" data-table="t_admission" data-field="x_sep_namapolitujuan" name="x_sep_namapolitujuan" id="x_sep_namapolitujuan" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_namapolitujuan->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_namapolitujuan->EditValue ?>"<?php echo $t_admission->sep_namapolitujuan->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_namapolitujuan->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_jeniskelamin->Visible) { // ket_jeniskelamin ?>
	<div id="r_ket_jeniskelamin" class="form-group">
		<label id="elh_t_admission_ket_jeniskelamin" for="x_ket_jeniskelamin" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->ket_jeniskelamin->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_jeniskelamin->CellAttributes() ?>>
<span id="el_t_admission_ket_jeniskelamin">
<input type="text" data-table="t_admission" data-field="x_ket_jeniskelamin" name="x_ket_jeniskelamin" id="x_ket_jeniskelamin" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_jeniskelamin->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_jeniskelamin->EditValue ?>"<?php echo $t_admission->ket_jeniskelamin->EditAttributes() ?>>
</span>
<?php echo $t_admission->ket_jeniskelamin->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_nokabpjs->Visible) { // sep_nokabpjs ?>
	<div id="r_sep_nokabpjs" class="form-group">
		<label id="elh_t_admission_sep_nokabpjs" for="x_sep_nokabpjs" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_nokabpjs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_nokabpjs->CellAttributes() ?>>
<span id="el_t_admission_sep_nokabpjs">
<input type="text" data-table="t_admission" data-field="x_sep_nokabpjs" name="x_sep_nokabpjs" id="x_sep_nokabpjs" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_nokabpjs->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_nokabpjs->EditValue ?>"<?php echo $t_admission->sep_nokabpjs->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_nokabpjs->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->counter_cetak_sep->Visible) { // counter_cetak_sep ?>
	<div id="r_counter_cetak_sep" class="form-group">
		<label id="elh_t_admission_counter_cetak_sep" for="x_counter_cetak_sep" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->counter_cetak_sep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->counter_cetak_sep->CellAttributes() ?>>
<span id="el_t_admission_counter_cetak_sep">
<input type="text" data-table="t_admission" data-field="x_counter_cetak_sep" name="x_counter_cetak_sep" id="x_counter_cetak_sep" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->counter_cetak_sep->getPlaceHolder()) ?>" value="<?php echo $t_admission->counter_cetak_sep->EditValue ?>"<?php echo $t_admission->counter_cetak_sep->EditAttributes() ?>>
</span>
<?php echo $t_admission->counter_cetak_sep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_petugas_hapus_sep->Visible) { // sep_petugas_hapus_sep ?>
	<div id="r_sep_petugas_hapus_sep" class="form-group">
		<label id="elh_t_admission_sep_petugas_hapus_sep" for="x_sep_petugas_hapus_sep" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_petugas_hapus_sep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_petugas_hapus_sep->CellAttributes() ?>>
<span id="el_t_admission_sep_petugas_hapus_sep">
<input type="text" data-table="t_admission" data-field="x_sep_petugas_hapus_sep" name="x_sep_petugas_hapus_sep" id="x_sep_petugas_hapus_sep" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_petugas_hapus_sep->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_petugas_hapus_sep->EditValue ?>"<?php echo $t_admission->sep_petugas_hapus_sep->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_petugas_hapus_sep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_petugas_set_tgl_pulang->Visible) { // sep_petugas_set_tgl_pulang ?>
	<div id="r_sep_petugas_set_tgl_pulang" class="form-group">
		<label id="elh_t_admission_sep_petugas_set_tgl_pulang" for="x_sep_petugas_set_tgl_pulang" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_petugas_set_tgl_pulang->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_petugas_set_tgl_pulang->CellAttributes() ?>>
<span id="el_t_admission_sep_petugas_set_tgl_pulang">
<input type="text" data-table="t_admission" data-field="x_sep_petugas_set_tgl_pulang" name="x_sep_petugas_set_tgl_pulang" id="x_sep_petugas_set_tgl_pulang" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_petugas_set_tgl_pulang->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_petugas_set_tgl_pulang->EditValue ?>"<?php echo $t_admission->sep_petugas_set_tgl_pulang->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_petugas_set_tgl_pulang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_jam_generate_sep->Visible) { // sep_jam_generate_sep ?>
	<div id="r_sep_jam_generate_sep" class="form-group">
		<label id="elh_t_admission_sep_jam_generate_sep" for="x_sep_jam_generate_sep" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_jam_generate_sep->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_jam_generate_sep->CellAttributes() ?>>
<span id="el_t_admission_sep_jam_generate_sep">
<input type="text" data-table="t_admission" data-field="x_sep_jam_generate_sep" name="x_sep_jam_generate_sep" id="x_sep_jam_generate_sep" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_jam_generate_sep->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_jam_generate_sep->EditValue ?>"<?php echo $t_admission->sep_jam_generate_sep->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_jam_generate_sep->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_status_peserta->Visible) { // sep_status_peserta ?>
	<div id="r_sep_status_peserta" class="form-group">
		<label id="elh_t_admission_sep_status_peserta" for="x_sep_status_peserta" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_status_peserta->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_status_peserta->CellAttributes() ?>>
<span id="el_t_admission_sep_status_peserta">
<input type="text" data-table="t_admission" data-field="x_sep_status_peserta" name="x_sep_status_peserta" id="x_sep_status_peserta" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_status_peserta->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_status_peserta->EditValue ?>"<?php echo $t_admission->sep_status_peserta->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_status_peserta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->sep_umur_pasien_sekarang->Visible) { // sep_umur_pasien_sekarang ?>
	<div id="r_sep_umur_pasien_sekarang" class="form-group">
		<label id="elh_t_admission_sep_umur_pasien_sekarang" for="x_sep_umur_pasien_sekarang" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->sep_umur_pasien_sekarang->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->sep_umur_pasien_sekarang->CellAttributes() ?>>
<span id="el_t_admission_sep_umur_pasien_sekarang">
<input type="text" data-table="t_admission" data-field="x_sep_umur_pasien_sekarang" name="x_sep_umur_pasien_sekarang" id="x_sep_umur_pasien_sekarang" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->sep_umur_pasien_sekarang->getPlaceHolder()) ?>" value="<?php echo $t_admission->sep_umur_pasien_sekarang->EditValue ?>"<?php echo $t_admission->sep_umur_pasien_sekarang->EditAttributes() ?>>
</span>
<?php echo $t_admission->sep_umur_pasien_sekarang->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->ket_title->Visible) { // ket_title ?>
	<div id="r_ket_title" class="form-group">
		<label id="elh_t_admission_ket_title" for="x_ket_title" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->ket_title->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->ket_title->CellAttributes() ?>>
<span id="el_t_admission_ket_title">
<input type="text" data-table="t_admission" data-field="x_ket_title" name="x_ket_title" id="x_ket_title" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->ket_title->getPlaceHolder()) ?>" value="<?php echo $t_admission->ket_title->EditValue ?>"<?php echo $t_admission->ket_title->EditAttributes() ?>>
</span>
<?php echo $t_admission->ket_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->status_daftar_ranap->Visible) { // status_daftar_ranap ?>
	<div id="r_status_daftar_ranap" class="form-group">
		<label id="elh_t_admission_status_daftar_ranap" for="x_status_daftar_ranap" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->status_daftar_ranap->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->status_daftar_ranap->CellAttributes() ?>>
<span id="el_t_admission_status_daftar_ranap">
<input type="text" data-table="t_admission" data-field="x_status_daftar_ranap" name="x_status_daftar_ranap" id="x_status_daftar_ranap" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->status_daftar_ranap->getPlaceHolder()) ?>" value="<?php echo $t_admission->status_daftar_ranap->EditValue ?>"<?php echo $t_admission->status_daftar_ranap->EditAttributes() ?>>
</span>
<?php echo $t_admission->status_daftar_ranap->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_SETMARKING->Visible) { // IBS_SETMARKING ?>
	<div id="r_IBS_SETMARKING" class="form-group">
		<label id="elh_t_admission_IBS_SETMARKING" for="x_IBS_SETMARKING" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_SETMARKING->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_SETMARKING->CellAttributes() ?>>
<span id="el_t_admission_IBS_SETMARKING">
<input type="text" data-table="t_admission" data-field="x_IBS_SETMARKING" name="x_IBS_SETMARKING" id="x_IBS_SETMARKING" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_SETMARKING->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_SETMARKING->EditValue ?>"<?php echo $t_admission->IBS_SETMARKING->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_SETMARKING->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_PATOLOGI->Visible) { // IBS_PATOLOGI ?>
	<div id="r_IBS_PATOLOGI" class="form-group">
		<label id="elh_t_admission_IBS_PATOLOGI" for="x_IBS_PATOLOGI" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_PATOLOGI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_PATOLOGI->CellAttributes() ?>>
<span id="el_t_admission_IBS_PATOLOGI">
<input type="text" data-table="t_admission" data-field="x_IBS_PATOLOGI" name="x_IBS_PATOLOGI" id="x_IBS_PATOLOGI" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_PATOLOGI->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_PATOLOGI->EditValue ?>"<?php echo $t_admission->IBS_PATOLOGI->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_PATOLOGI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_JENISANESTESI->Visible) { // IBS_JENISANESTESI ?>
	<div id="r_IBS_JENISANESTESI" class="form-group">
		<label id="elh_t_admission_IBS_JENISANESTESI" for="x_IBS_JENISANESTESI" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_JENISANESTESI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_JENISANESTESI->CellAttributes() ?>>
<span id="el_t_admission_IBS_JENISANESTESI">
<input type="text" data-table="t_admission" data-field="x_IBS_JENISANESTESI" name="x_IBS_JENISANESTESI" id="x_IBS_JENISANESTESI" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_JENISANESTESI->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_JENISANESTESI->EditValue ?>"<?php echo $t_admission->IBS_JENISANESTESI->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_JENISANESTESI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_NO_OK->Visible) { // IBS_NO_OK ?>
	<div id="r_IBS_NO_OK" class="form-group">
		<label id="elh_t_admission_IBS_NO_OK" for="x_IBS_NO_OK" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_NO_OK->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_NO_OK->CellAttributes() ?>>
<span id="el_t_admission_IBS_NO_OK">
<input type="text" data-table="t_admission" data-field="x_IBS_NO_OK" name="x_IBS_NO_OK" id="x_IBS_NO_OK" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_NO_OK->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_NO_OK->EditValue ?>"<?php echo $t_admission->IBS_NO_OK->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_NO_OK->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_ASISSTEN->Visible) { // IBS_ASISSTEN ?>
	<div id="r_IBS_ASISSTEN" class="form-group">
		<label id="elh_t_admission_IBS_ASISSTEN" for="x_IBS_ASISSTEN" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_ASISSTEN->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_ASISSTEN->CellAttributes() ?>>
<span id="el_t_admission_IBS_ASISSTEN">
<input type="text" data-table="t_admission" data-field="x_IBS_ASISSTEN" name="x_IBS_ASISSTEN" id="x_IBS_ASISSTEN" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_ASISSTEN->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_ASISSTEN->EditValue ?>"<?php echo $t_admission->IBS_ASISSTEN->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_ASISSTEN->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_JAM_ELEFTIF->Visible) { // IBS_JAM_ELEFTIF ?>
	<div id="r_IBS_JAM_ELEFTIF" class="form-group">
		<label id="elh_t_admission_IBS_JAM_ELEFTIF" for="x_IBS_JAM_ELEFTIF" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_JAM_ELEFTIF->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_JAM_ELEFTIF->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_ELEFTIF">
<input type="text" data-table="t_admission" data-field="x_IBS_JAM_ELEFTIF" name="x_IBS_JAM_ELEFTIF" id="x_IBS_JAM_ELEFTIF" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_JAM_ELEFTIF->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_JAM_ELEFTIF->EditValue ?>"<?php echo $t_admission->IBS_JAM_ELEFTIF->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_JAM_ELEFTIF->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_JAM_ELEKTIF_SELESAI->Visible) { // IBS_JAM_ELEKTIF_SELESAI ?>
	<div id="r_IBS_JAM_ELEKTIF_SELESAI" class="form-group">
		<label id="elh_t_admission_IBS_JAM_ELEKTIF_SELESAI" for="x_IBS_JAM_ELEKTIF_SELESAI" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_ELEKTIF_SELESAI">
<input type="text" data-table="t_admission" data-field="x_IBS_JAM_ELEKTIF_SELESAI" name="x_IBS_JAM_ELEKTIF_SELESAI" id="x_IBS_JAM_ELEKTIF_SELESAI" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_JAM_ELEKTIF_SELESAI->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->EditValue ?>"<?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_JAM_CYTO->Visible) { // IBS_JAM_CYTO ?>
	<div id="r_IBS_JAM_CYTO" class="form-group">
		<label id="elh_t_admission_IBS_JAM_CYTO" for="x_IBS_JAM_CYTO" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_JAM_CYTO->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_JAM_CYTO->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_CYTO">
<input type="text" data-table="t_admission" data-field="x_IBS_JAM_CYTO" name="x_IBS_JAM_CYTO" id="x_IBS_JAM_CYTO" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_JAM_CYTO->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_JAM_CYTO->EditValue ?>"<?php echo $t_admission->IBS_JAM_CYTO->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_JAM_CYTO->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_JAM_CYTO_SELESAI->Visible) { // IBS_JAM_CYTO_SELESAI ?>
	<div id="r_IBS_JAM_CYTO_SELESAI" class="form-group">
		<label id="elh_t_admission_IBS_JAM_CYTO_SELESAI" for="x_IBS_JAM_CYTO_SELESAI" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_JAM_CYTO_SELESAI->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_JAM_CYTO_SELESAI->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_CYTO_SELESAI">
<input type="text" data-table="t_admission" data-field="x_IBS_JAM_CYTO_SELESAI" name="x_IBS_JAM_CYTO_SELESAI" id="x_IBS_JAM_CYTO_SELESAI" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_JAM_CYTO_SELESAI->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_JAM_CYTO_SELESAI->EditValue ?>"<?php echo $t_admission->IBS_JAM_CYTO_SELESAI->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_JAM_CYTO_SELESAI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_TGL_DFTR_OP->Visible) { // IBS_TGL_DFTR_OP ?>
	<div id="r_IBS_TGL_DFTR_OP" class="form-group">
		<label id="elh_t_admission_IBS_TGL_DFTR_OP" for="x_IBS_TGL_DFTR_OP" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_TGL_DFTR_OP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_TGL_DFTR_OP->CellAttributes() ?>>
<span id="el_t_admission_IBS_TGL_DFTR_OP">
<input type="text" data-table="t_admission" data-field="x_IBS_TGL_DFTR_OP" name="x_IBS_TGL_DFTR_OP" id="x_IBS_TGL_DFTR_OP" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_TGL_DFTR_OP->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_TGL_DFTR_OP->EditValue ?>"<?php echo $t_admission->IBS_TGL_DFTR_OP->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_TGL_DFTR_OP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->IBS_TGL_OP->Visible) { // IBS_TGL_OP ?>
	<div id="r_IBS_TGL_OP" class="form-group">
		<label id="elh_t_admission_IBS_TGL_OP" for="x_IBS_TGL_OP" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->IBS_TGL_OP->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->IBS_TGL_OP->CellAttributes() ?>>
<span id="el_t_admission_IBS_TGL_OP">
<input type="text" data-table="t_admission" data-field="x_IBS_TGL_OP" name="x_IBS_TGL_OP" id="x_IBS_TGL_OP" placeholder="<?php echo ew_HtmlEncode($t_admission->IBS_TGL_OP->getPlaceHolder()) ?>" value="<?php echo $t_admission->IBS_TGL_OP->EditValue ?>"<?php echo $t_admission->IBS_TGL_OP->EditAttributes() ?>>
</span>
<?php echo $t_admission->IBS_TGL_OP->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->grup_ruang_id->Visible) { // grup_ruang_id ?>
	<div id="r_grup_ruang_id" class="form-group">
		<label id="elh_t_admission_grup_ruang_id" for="x_grup_ruang_id" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->grup_ruang_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->grup_ruang_id->CellAttributes() ?>>
<span id="el_t_admission_grup_ruang_id">
<input type="text" data-table="t_admission" data-field="x_grup_ruang_id" name="x_grup_ruang_id" id="x_grup_ruang_id" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->grup_ruang_id->getPlaceHolder()) ?>" value="<?php echo $t_admission->grup_ruang_id->EditValue ?>"<?php echo $t_admission->grup_ruang_id->EditAttributes() ?>>
</span>
<?php echo $t_admission->grup_ruang_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($t_admission->status_order_ibs->Visible) { // status_order_ibs ?>
	<div id="r_status_order_ibs" class="form-group">
		<label id="elh_t_admission_status_order_ibs" for="x_status_order_ibs" class="col-sm-2 control-label ewLabel"><?php echo $t_admission->status_order_ibs->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $t_admission->status_order_ibs->CellAttributes() ?>>
<span id="el_t_admission_status_order_ibs">
<input type="text" data-table="t_admission" data-field="x_status_order_ibs" name="x_status_order_ibs" id="x_status_order_ibs" size="30" placeholder="<?php echo ew_HtmlEncode($t_admission->status_order_ibs->getPlaceHolder()) ?>" value="<?php echo $t_admission->status_order_ibs->EditValue ?>"<?php echo $t_admission->status_order_ibs->EditAttributes() ?>>
</span>
<?php echo $t_admission->status_order_ibs->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$t_admission_add->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $t_admission_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
ft_admissionadd.Init();
</script>
<?php
$t_admission_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_admission_add->Page_Terminate();
?>
