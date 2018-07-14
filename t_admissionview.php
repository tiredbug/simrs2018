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

$t_admission_view = NULL; // Initialize page object first

class ct_admission_view extends ct_admission {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_admission';

	// Page object name
	var $PageObjName = 't_admission_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["id_admission"] <> "") {
			$this->RecKey["id_admission"] = $_GET["id_admission"];
			$KeyUrl .= "&amp;id_admission=" . urlencode($this->RecKey["id_admission"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id_admission"] <> "") {
				$this->id_admission->setQueryStringValue($_GET["id_admission"]);
				$this->RecKey["id_admission"] = $this->id_admission->QueryStringValue;
			} elseif (@$_POST["id_admission"] <> "") {
				$this->id_admission->setFormValue($_POST["id_admission"]);
				$this->RecKey["id_admission"] = $this->id_admission->FormValue;
			} else {
				$sReturnUrl = "t_admissionlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "t_admissionlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "t_admissionlist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "',caption:'" . $addcaption . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Copy
		$item = &$option->Add("copy");
		$copycaption = ew_HtmlTitle($Language->Phrase("ViewPageCopyLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->CopyUrl) . "',caption:'" . $copycaption . "'});\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "" && $Security->CanAdd());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_AddQueryStringToUrl($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("t_admissionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($t_admission_view)) $t_admission_view = new ct_admission_view();

// Page init
$t_admission_view->Page_Init();

// Page main
$t_admission_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$t_admission_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = ft_admissionview = new ew_Form("ft_admissionview", "view");

// Form_CustomValidate event
ft_admissionview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ft_admissionview.ValidateRequired = true;
<?php } else { ?>
ft_admissionview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ft_admissionview.Lists["x_nomr"] = {"LinkField":"x_NOMR","Ajax":true,"AutoFill":false,"DisplayFields":["x_NOMR","x_NAMA","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_pasien"};
ft_admissionview.Lists["x_dokterpengirim"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_admissionview.Lists["x_statusbayar"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_carabayar"};
ft_admissionview.Lists["x_kirimdari"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};
ft_admissionview.Lists["x_noruang"] = {"LinkField":"x_no","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":["x_tempat_tidur_id"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_ruang"};
ft_admissionview.Lists["x_tempat_tidur_id"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_no_tt","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_detail_tempat_tidur"};
ft_admissionview.Lists["x_icd_masuk"] = {"LinkField":"x_CODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_CODE","x_STR","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"vw_diagnosa_eklaim"};
ft_admissionview.Lists["x_kd_rujuk"] = {"LinkField":"x_KODE","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMA","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_rujukan"};
ft_admissionview.Lists["x_dokter_penanggungjawab"] = {"LinkField":"x_KDDOKTER","Ajax":true,"AutoFill":false,"DisplayFields":["x_NAMADOKTER","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_dokter"};
ft_admissionview.Lists["x_KELASPERAWATAN_ID"] = {"LinkField":"x_kelasperawatan_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_kelasperawatan","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"l_kelas_perawatan"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$t_admission_view->IsModal) { ?>
<?php } ?>
<?php $t_admission_view->ExportOptions->Render("body") ?>
<?php
	foreach ($t_admission_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php if (!$t_admission_view->IsModal) { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
<?php $t_admission_view->ShowPageHeader(); ?>
<?php
$t_admission_view->ShowMessage();
?>
<form name="ft_admissionview" id="ft_admissionview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($t_admission_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $t_admission_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="t_admission">
<?php if ($t_admission_view->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<table class="table table-bordered table-striped table-condensed table-hover ewViewTable">
<?php if ($t_admission->id_admission->Visible) { // id_admission ?>
	<tr id="r_id_admission">
		<td><span id="elh_t_admission_id_admission"><?php echo $t_admission->id_admission->FldCaption() ?></span></td>
		<td data-name="id_admission"<?php echo $t_admission->id_admission->CellAttributes() ?>>
<div id="orig_t_admission_id_admission" class="hide">
<span id="el_t_admission_id_admission">
<span<?php echo $t_admission->id_admission->ViewAttributes() ?>>
<?php echo $t_admission->id_admission->ViewValue ?></span>
</span>
</div>
<div class="btn-group">
	<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>   Menu</button>
		<button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul style="background:#3C8DBC" class="dropdown-menu" role="menu" >
                  	<li class="divider"></li>
                    <li><a style="color:#ffffff" target="_blank" href="cetak_gelang_pasien_ranap.php?nomr=<?php echo urlencode(CurrentPage()->nomr->CurrentValue) ?>" onclick="return confirm('Klik OK. untuk Memulai proses cetak gelang.......,?')"><b>-  </b><b> Cetak Gelang Pasien </b></a></li>
                    <li><a style="color:#ffffff" target="_blank" href="cetak_label_pasien_sementara.php?idx=<?php echo urlencode(CurrentPage()->id_admission->CurrentValue) ?>&&nomr=<?php echo urlencode(CurrentPage()->nomr->CurrentValue) ?> " onclick="return confirm('Klik OK. untuk Memulai proses   Cetak  label.......,?')"><b>-  </b><b> Cetak Label Pasien </b></a></li>
                   	<li class="divider"></li>
                  </ul>
</div>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->nomr->Visible) { // nomr ?>
	<tr id="r_nomr">
		<td><span id="elh_t_admission_nomr"><?php echo $t_admission->nomr->FldCaption() ?></span></td>
		<td data-name="nomr"<?php echo $t_admission->nomr->CellAttributes() ?>>
<span id="el_t_admission_nomr">
<span<?php echo $t_admission->nomr->ViewAttributes() ?>>
<?php echo $t_admission->nomr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->ket_nama->Visible) { // ket_nama ?>
	<tr id="r_ket_nama">
		<td><span id="elh_t_admission_ket_nama"><?php echo $t_admission->ket_nama->FldCaption() ?></span></td>
		<td data-name="ket_nama"<?php echo $t_admission->ket_nama->CellAttributes() ?>>
<span id="el_t_admission_ket_nama">
<span<?php echo $t_admission->ket_nama->ViewAttributes() ?>>
<?php echo $t_admission->ket_nama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->ket_tgllahir->Visible) { // ket_tgllahir ?>
	<tr id="r_ket_tgllahir">
		<td><span id="elh_t_admission_ket_tgllahir"><?php echo $t_admission->ket_tgllahir->FldCaption() ?></span></td>
		<td data-name="ket_tgllahir"<?php echo $t_admission->ket_tgllahir->CellAttributes() ?>>
<span id="el_t_admission_ket_tgllahir">
<span<?php echo $t_admission->ket_tgllahir->ViewAttributes() ?>>
<?php echo $t_admission->ket_tgllahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->ket_alamat->Visible) { // ket_alamat ?>
	<tr id="r_ket_alamat">
		<td><span id="elh_t_admission_ket_alamat"><?php echo $t_admission->ket_alamat->FldCaption() ?></span></td>
		<td data-name="ket_alamat"<?php echo $t_admission->ket_alamat->CellAttributes() ?>>
<span id="el_t_admission_ket_alamat">
<span<?php echo $t_admission->ket_alamat->ViewAttributes() ?>>
<?php echo $t_admission->ket_alamat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->parent_nomr->Visible) { // parent_nomr ?>
	<tr id="r_parent_nomr">
		<td><span id="elh_t_admission_parent_nomr"><?php echo $t_admission->parent_nomr->FldCaption() ?></span></td>
		<td data-name="parent_nomr"<?php echo $t_admission->parent_nomr->CellAttributes() ?>>
<span id="el_t_admission_parent_nomr">
<span<?php echo $t_admission->parent_nomr->ViewAttributes() ?>>
<?php echo $t_admission->parent_nomr->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->dokterpengirim->Visible) { // dokterpengirim ?>
	<tr id="r_dokterpengirim">
		<td><span id="elh_t_admission_dokterpengirim"><?php echo $t_admission->dokterpengirim->FldCaption() ?></span></td>
		<td data-name="dokterpengirim"<?php echo $t_admission->dokterpengirim->CellAttributes() ?>>
<span id="el_t_admission_dokterpengirim">
<span<?php echo $t_admission->dokterpengirim->ViewAttributes() ?>>
<?php echo $t_admission->dokterpengirim->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->statusbayar->Visible) { // statusbayar ?>
	<tr id="r_statusbayar">
		<td><span id="elh_t_admission_statusbayar"><?php echo $t_admission->statusbayar->FldCaption() ?></span></td>
		<td data-name="statusbayar"<?php echo $t_admission->statusbayar->CellAttributes() ?>>
<span id="el_t_admission_statusbayar">
<span<?php echo $t_admission->statusbayar->ViewAttributes() ?>>
<?php echo $t_admission->statusbayar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->kirimdari->Visible) { // kirimdari ?>
	<tr id="r_kirimdari">
		<td><span id="elh_t_admission_kirimdari"><?php echo $t_admission->kirimdari->FldCaption() ?></span></td>
		<td data-name="kirimdari"<?php echo $t_admission->kirimdari->CellAttributes() ?>>
<span id="el_t_admission_kirimdari">
<span<?php echo $t_admission->kirimdari->ViewAttributes() ?>>
<?php echo $t_admission->kirimdari->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->keluargadekat->Visible) { // keluargadekat ?>
	<tr id="r_keluargadekat">
		<td><span id="elh_t_admission_keluargadekat"><?php echo $t_admission->keluargadekat->FldCaption() ?></span></td>
		<td data-name="keluargadekat"<?php echo $t_admission->keluargadekat->CellAttributes() ?>>
<span id="el_t_admission_keluargadekat">
<span<?php echo $t_admission->keluargadekat->ViewAttributes() ?>>
<?php echo $t_admission->keluargadekat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->panggungjawab->Visible) { // panggungjawab ?>
	<tr id="r_panggungjawab">
		<td><span id="elh_t_admission_panggungjawab"><?php echo $t_admission->panggungjawab->FldCaption() ?></span></td>
		<td data-name="panggungjawab"<?php echo $t_admission->panggungjawab->CellAttributes() ?>>
<span id="el_t_admission_panggungjawab">
<span<?php echo $t_admission->panggungjawab->ViewAttributes() ?>>
<?php echo $t_admission->panggungjawab->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->masukrs->Visible) { // masukrs ?>
	<tr id="r_masukrs">
		<td><span id="elh_t_admission_masukrs"><?php echo $t_admission->masukrs->FldCaption() ?></span></td>
		<td data-name="masukrs"<?php echo $t_admission->masukrs->CellAttributes() ?>>
<span id="el_t_admission_masukrs">
<span<?php echo $t_admission->masukrs->ViewAttributes() ?>>
<?php echo $t_admission->masukrs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->noruang->Visible) { // noruang ?>
	<tr id="r_noruang">
		<td><span id="elh_t_admission_noruang"><?php echo $t_admission->noruang->FldCaption() ?></span></td>
		<td data-name="noruang"<?php echo $t_admission->noruang->CellAttributes() ?>>
<div id="orig_t_admission_noruang" class="hide">
<span id="el_t_admission_noruang">
<span<?php echo $t_admission->noruang->ViewAttributes() ?>>
<?php echo $t_admission->noruang->ViewValue ?></span>
</span>
</div>
<?php
$flag = urlencode(CurrentPage()->noruang->CurrentValue);
if ($flag==0)
{
	print '<a class="btn btn-danger btn-xs">  Kamar belum di input</a>';
}else
{
	echo $t_admission->noruang->ListViewValue();
}
?>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->tempat_tidur_id->Visible) { // tempat_tidur_id ?>
	<tr id="r_tempat_tidur_id">
		<td><span id="elh_t_admission_tempat_tidur_id"><?php echo $t_admission->tempat_tidur_id->FldCaption() ?></span></td>
		<td data-name="tempat_tidur_id"<?php echo $t_admission->tempat_tidur_id->CellAttributes() ?>>
<span id="el_t_admission_tempat_tidur_id">
<span<?php echo $t_admission->tempat_tidur_id->ViewAttributes() ?>>
<?php echo $t_admission->tempat_tidur_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->nott->Visible) { // nott ?>
	<tr id="r_nott">
		<td><span id="elh_t_admission_nott"><?php echo $t_admission->nott->FldCaption() ?></span></td>
		<td data-name="nott"<?php echo $t_admission->nott->CellAttributes() ?>>
<div id="orig_t_admission_nott" class="hide">
<span id="el_t_admission_nott">
<span<?php echo $t_admission->nott->ViewAttributes() ?>>
<?php echo $t_admission->nott->ViewValue ?></span>
</span>
</div>
<?php
$flag = urlencode(CurrentPage()->nott->CurrentValue);
if ($flag==0)
{
	print '<a class="btn btn-danger btn-xs">  Bed belum di input</a>';
}else
{
	echo $t_admission->nott->ListViewValue();
}
?>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->deposit->Visible) { // deposit ?>
	<tr id="r_deposit">
		<td><span id="elh_t_admission_deposit"><?php echo $t_admission->deposit->FldCaption() ?></span></td>
		<td data-name="deposit"<?php echo $t_admission->deposit->CellAttributes() ?>>
<span id="el_t_admission_deposit">
<span<?php echo $t_admission->deposit->ViewAttributes() ?>>
<?php echo $t_admission->deposit->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->keluarrs->Visible) { // keluarrs ?>
	<tr id="r_keluarrs">
		<td><span id="elh_t_admission_keluarrs"><?php echo $t_admission->keluarrs->FldCaption() ?></span></td>
		<td data-name="keluarrs"<?php echo $t_admission->keluarrs->CellAttributes() ?>>
<span id="el_t_admission_keluarrs">
<span<?php echo $t_admission->keluarrs->ViewAttributes() ?>>
<?php echo $t_admission->keluarrs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->icd_masuk->Visible) { // icd_masuk ?>
	<tr id="r_icd_masuk">
		<td><span id="elh_t_admission_icd_masuk"><?php echo $t_admission->icd_masuk->FldCaption() ?></span></td>
		<td data-name="icd_masuk"<?php echo $t_admission->icd_masuk->CellAttributes() ?>>
<span id="el_t_admission_icd_masuk">
<span<?php echo $t_admission->icd_masuk->ViewAttributes() ?>>
<?php echo $t_admission->icd_masuk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->icd_keluar->Visible) { // icd_keluar ?>
	<tr id="r_icd_keluar">
		<td><span id="elh_t_admission_icd_keluar"><?php echo $t_admission->icd_keluar->FldCaption() ?></span></td>
		<td data-name="icd_keluar"<?php echo $t_admission->icd_keluar->CellAttributes() ?>>
<span id="el_t_admission_icd_keluar">
<span<?php echo $t_admission->icd_keluar->ViewAttributes() ?>>
<?php echo $t_admission->icd_keluar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->NIP->Visible) { // NIP ?>
	<tr id="r_NIP">
		<td><span id="elh_t_admission_NIP"><?php echo $t_admission->NIP->FldCaption() ?></span></td>
		<td data-name="NIP"<?php echo $t_admission->NIP->CellAttributes() ?>>
<span id="el_t_admission_NIP">
<span<?php echo $t_admission->NIP->ViewAttributes() ?>>
<?php echo $t_admission->NIP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->noruang_asal->Visible) { // noruang_asal ?>
	<tr id="r_noruang_asal">
		<td><span id="elh_t_admission_noruang_asal"><?php echo $t_admission->noruang_asal->FldCaption() ?></span></td>
		<td data-name="noruang_asal"<?php echo $t_admission->noruang_asal->CellAttributes() ?>>
<span id="el_t_admission_noruang_asal">
<span<?php echo $t_admission->noruang_asal->ViewAttributes() ?>>
<?php echo $t_admission->noruang_asal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->nott_asal->Visible) { // nott_asal ?>
	<tr id="r_nott_asal">
		<td><span id="elh_t_admission_nott_asal"><?php echo $t_admission->nott_asal->FldCaption() ?></span></td>
		<td data-name="nott_asal"<?php echo $t_admission->nott_asal->CellAttributes() ?>>
<span id="el_t_admission_nott_asal">
<span<?php echo $t_admission->nott_asal->ViewAttributes() ?>>
<?php echo $t_admission->nott_asal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->tgl_pindah->Visible) { // tgl_pindah ?>
	<tr id="r_tgl_pindah">
		<td><span id="elh_t_admission_tgl_pindah"><?php echo $t_admission->tgl_pindah->FldCaption() ?></span></td>
		<td data-name="tgl_pindah"<?php echo $t_admission->tgl_pindah->CellAttributes() ?>>
<span id="el_t_admission_tgl_pindah">
<span<?php echo $t_admission->tgl_pindah->ViewAttributes() ?>>
<?php echo $t_admission->tgl_pindah->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->kd_rujuk->Visible) { // kd_rujuk ?>
	<tr id="r_kd_rujuk">
		<td><span id="elh_t_admission_kd_rujuk"><?php echo $t_admission->kd_rujuk->FldCaption() ?></span></td>
		<td data-name="kd_rujuk"<?php echo $t_admission->kd_rujuk->CellAttributes() ?>>
<span id="el_t_admission_kd_rujuk">
<span<?php echo $t_admission->kd_rujuk->ViewAttributes() ?>>
<?php echo $t_admission->kd_rujuk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->st_bayar->Visible) { // st_bayar ?>
	<tr id="r_st_bayar">
		<td><span id="elh_t_admission_st_bayar"><?php echo $t_admission->st_bayar->FldCaption() ?></span></td>
		<td data-name="st_bayar"<?php echo $t_admission->st_bayar->CellAttributes() ?>>
<span id="el_t_admission_st_bayar">
<span<?php echo $t_admission->st_bayar->ViewAttributes() ?>>
<?php echo $t_admission->st_bayar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->dokter_penanggungjawab->Visible) { // dokter_penanggungjawab ?>
	<tr id="r_dokter_penanggungjawab">
		<td><span id="elh_t_admission_dokter_penanggungjawab"><?php echo $t_admission->dokter_penanggungjawab->FldCaption() ?></span></td>
		<td data-name="dokter_penanggungjawab"<?php echo $t_admission->dokter_penanggungjawab->CellAttributes() ?>>
<span id="el_t_admission_dokter_penanggungjawab">
<span<?php echo $t_admission->dokter_penanggungjawab->ViewAttributes() ?>>
<?php echo $t_admission->dokter_penanggungjawab->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->perawat->Visible) { // perawat ?>
	<tr id="r_perawat">
		<td><span id="elh_t_admission_perawat"><?php echo $t_admission->perawat->FldCaption() ?></span></td>
		<td data-name="perawat"<?php echo $t_admission->perawat->CellAttributes() ?>>
<span id="el_t_admission_perawat">
<span<?php echo $t_admission->perawat->ViewAttributes() ?>>
<?php echo $t_admission->perawat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->KELASPERAWATAN_ID->Visible) { // KELASPERAWATAN_ID ?>
	<tr id="r_KELASPERAWATAN_ID">
		<td><span id="elh_t_admission_KELASPERAWATAN_ID"><?php echo $t_admission->KELASPERAWATAN_ID->FldCaption() ?></span></td>
		<td data-name="KELASPERAWATAN_ID"<?php echo $t_admission->KELASPERAWATAN_ID->CellAttributes() ?>>
<span id="el_t_admission_KELASPERAWATAN_ID">
<span<?php echo $t_admission->KELASPERAWATAN_ID->ViewAttributes() ?>>
<?php echo $t_admission->KELASPERAWATAN_ID->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->LOS->Visible) { // LOS ?>
	<tr id="r_LOS">
		<td><span id="elh_t_admission_LOS"><?php echo $t_admission->LOS->FldCaption() ?></span></td>
		<td data-name="LOS"<?php echo $t_admission->LOS->CellAttributes() ?>>
<span id="el_t_admission_LOS">
<span<?php echo $t_admission->LOS->ViewAttributes() ?>>
<?php echo $t_admission->LOS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_TRF_TIND_DOKTER->Visible) { // TOT_TRF_TIND_DOKTER ?>
	<tr id="r_TOT_TRF_TIND_DOKTER">
		<td><span id="elh_t_admission_TOT_TRF_TIND_DOKTER"><?php echo $t_admission->TOT_TRF_TIND_DOKTER->FldCaption() ?></span></td>
		<td data-name="TOT_TRF_TIND_DOKTER"<?php echo $t_admission->TOT_TRF_TIND_DOKTER->CellAttributes() ?>>
<span id="el_t_admission_TOT_TRF_TIND_DOKTER">
<span<?php echo $t_admission->TOT_TRF_TIND_DOKTER->ViewAttributes() ?>>
<?php echo $t_admission->TOT_TRF_TIND_DOKTER->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BHP_DOKTER->Visible) { // TOT_BHP_DOKTER ?>
	<tr id="r_TOT_BHP_DOKTER">
		<td><span id="elh_t_admission_TOT_BHP_DOKTER"><?php echo $t_admission->TOT_BHP_DOKTER->FldCaption() ?></span></td>
		<td data-name="TOT_BHP_DOKTER"<?php echo $t_admission->TOT_BHP_DOKTER->CellAttributes() ?>>
<span id="el_t_admission_TOT_BHP_DOKTER">
<span<?php echo $t_admission->TOT_BHP_DOKTER->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BHP_DOKTER->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_TRF_PERAWAT->Visible) { // TOT_TRF_PERAWAT ?>
	<tr id="r_TOT_TRF_PERAWAT">
		<td><span id="elh_t_admission_TOT_TRF_PERAWAT"><?php echo $t_admission->TOT_TRF_PERAWAT->FldCaption() ?></span></td>
		<td data-name="TOT_TRF_PERAWAT"<?php echo $t_admission->TOT_TRF_PERAWAT->CellAttributes() ?>>
<span id="el_t_admission_TOT_TRF_PERAWAT">
<span<?php echo $t_admission->TOT_TRF_PERAWAT->ViewAttributes() ?>>
<?php echo $t_admission->TOT_TRF_PERAWAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BHP_PERAWAT->Visible) { // TOT_BHP_PERAWAT ?>
	<tr id="r_TOT_BHP_PERAWAT">
		<td><span id="elh_t_admission_TOT_BHP_PERAWAT"><?php echo $t_admission->TOT_BHP_PERAWAT->FldCaption() ?></span></td>
		<td data-name="TOT_BHP_PERAWAT"<?php echo $t_admission->TOT_BHP_PERAWAT->CellAttributes() ?>>
<span id="el_t_admission_TOT_BHP_PERAWAT">
<span<?php echo $t_admission->TOT_BHP_PERAWAT->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BHP_PERAWAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_TRF_DOKTER->Visible) { // TOT_TRF_DOKTER ?>
	<tr id="r_TOT_TRF_DOKTER">
		<td><span id="elh_t_admission_TOT_TRF_DOKTER"><?php echo $t_admission->TOT_TRF_DOKTER->FldCaption() ?></span></td>
		<td data-name="TOT_TRF_DOKTER"<?php echo $t_admission->TOT_TRF_DOKTER->CellAttributes() ?>>
<span id="el_t_admission_TOT_TRF_DOKTER">
<span<?php echo $t_admission->TOT_TRF_DOKTER->ViewAttributes() ?>>
<?php echo $t_admission->TOT_TRF_DOKTER->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_RAD->Visible) { // TOT_BIAYA_RAD ?>
	<tr id="r_TOT_BIAYA_RAD">
		<td><span id="elh_t_admission_TOT_BIAYA_RAD"><?php echo $t_admission->TOT_BIAYA_RAD->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_RAD"<?php echo $t_admission->TOT_BIAYA_RAD->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_RAD">
<span<?php echo $t_admission->TOT_BIAYA_RAD->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_RAD->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_CDRPOLI->Visible) { // TOT_BIAYA_CDRPOLI ?>
	<tr id="r_TOT_BIAYA_CDRPOLI">
		<td><span id="elh_t_admission_TOT_BIAYA_CDRPOLI"><?php echo $t_admission->TOT_BIAYA_CDRPOLI->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_CDRPOLI"<?php echo $t_admission->TOT_BIAYA_CDRPOLI->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_CDRPOLI">
<span<?php echo $t_admission->TOT_BIAYA_CDRPOLI->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_CDRPOLI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_LAB_IGD->Visible) { // TOT_BIAYA_LAB_IGD ?>
	<tr id="r_TOT_BIAYA_LAB_IGD">
		<td><span id="elh_t_admission_TOT_BIAYA_LAB_IGD"><?php echo $t_admission->TOT_BIAYA_LAB_IGD->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_LAB_IGD"<?php echo $t_admission->TOT_BIAYA_LAB_IGD->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_LAB_IGD">
<span<?php echo $t_admission->TOT_BIAYA_LAB_IGD->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_LAB_IGD->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_OKSIGEN->Visible) { // TOT_BIAYA_OKSIGEN ?>
	<tr id="r_TOT_BIAYA_OKSIGEN">
		<td><span id="elh_t_admission_TOT_BIAYA_OKSIGEN"><?php echo $t_admission->TOT_BIAYA_OKSIGEN->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_OKSIGEN"<?php echo $t_admission->TOT_BIAYA_OKSIGEN->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_OKSIGEN">
<span<?php echo $t_admission->TOT_BIAYA_OKSIGEN->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_OKSIGEN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOTAL_BIAYA_OBAT->Visible) { // TOTAL_BIAYA_OBAT ?>
	<tr id="r_TOTAL_BIAYA_OBAT">
		<td><span id="elh_t_admission_TOTAL_BIAYA_OBAT"><?php echo $t_admission->TOTAL_BIAYA_OBAT->FldCaption() ?></span></td>
		<td data-name="TOTAL_BIAYA_OBAT"<?php echo $t_admission->TOTAL_BIAYA_OBAT->CellAttributes() ?>>
<span id="el_t_admission_TOTAL_BIAYA_OBAT">
<span<?php echo $t_admission->TOTAL_BIAYA_OBAT->ViewAttributes() ?>>
<?php echo $t_admission->TOTAL_BIAYA_OBAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->LINK_SET_KELAS->Visible) { // LINK_SET_KELAS ?>
	<tr id="r_LINK_SET_KELAS">
		<td><span id="elh_t_admission_LINK_SET_KELAS"><?php echo $t_admission->LINK_SET_KELAS->FldCaption() ?></span></td>
		<td data-name="LINK_SET_KELAS"<?php echo $t_admission->LINK_SET_KELAS->CellAttributes() ?>>
<span id="el_t_admission_LINK_SET_KELAS">
<span<?php echo $t_admission->LINK_SET_KELAS->ViewAttributes() ?>>
<?php echo $t_admission->LINK_SET_KELAS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->biaya_obat->Visible) { // biaya_obat ?>
	<tr id="r_biaya_obat">
		<td><span id="elh_t_admission_biaya_obat"><?php echo $t_admission->biaya_obat->FldCaption() ?></span></td>
		<td data-name="biaya_obat"<?php echo $t_admission->biaya_obat->CellAttributes() ?>>
<span id="el_t_admission_biaya_obat">
<span<?php echo $t_admission->biaya_obat->ViewAttributes() ?>>
<?php echo $t_admission->biaya_obat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->biaya_retur_obat->Visible) { // biaya_retur_obat ?>
	<tr id="r_biaya_retur_obat">
		<td><span id="elh_t_admission_biaya_retur_obat"><?php echo $t_admission->biaya_retur_obat->FldCaption() ?></span></td>
		<td data-name="biaya_retur_obat"<?php echo $t_admission->biaya_retur_obat->CellAttributes() ?>>
<span id="el_t_admission_biaya_retur_obat">
<span<?php echo $t_admission->biaya_retur_obat->ViewAttributes() ?>>
<?php echo $t_admission->biaya_retur_obat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_GIZI->Visible) { // TOT_BIAYA_GIZI ?>
	<tr id="r_TOT_BIAYA_GIZI">
		<td><span id="elh_t_admission_TOT_BIAYA_GIZI"><?php echo $t_admission->TOT_BIAYA_GIZI->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_GIZI"<?php echo $t_admission->TOT_BIAYA_GIZI->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_GIZI">
<span<?php echo $t_admission->TOT_BIAYA_GIZI->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_GIZI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_TMO->Visible) { // TOT_BIAYA_TMO ?>
	<tr id="r_TOT_BIAYA_TMO">
		<td><span id="elh_t_admission_TOT_BIAYA_TMO"><?php echo $t_admission->TOT_BIAYA_TMO->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_TMO"<?php echo $t_admission->TOT_BIAYA_TMO->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_TMO">
<span<?php echo $t_admission->TOT_BIAYA_TMO->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_TMO->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_AMBULAN->Visible) { // TOT_BIAYA_AMBULAN ?>
	<tr id="r_TOT_BIAYA_AMBULAN">
		<td><span id="elh_t_admission_TOT_BIAYA_AMBULAN"><?php echo $t_admission->TOT_BIAYA_AMBULAN->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_AMBULAN"<?php echo $t_admission->TOT_BIAYA_AMBULAN->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_AMBULAN">
<span<?php echo $t_admission->TOT_BIAYA_AMBULAN->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_AMBULAN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_FISIO->Visible) { // TOT_BIAYA_FISIO ?>
	<tr id="r_TOT_BIAYA_FISIO">
		<td><span id="elh_t_admission_TOT_BIAYA_FISIO"><?php echo $t_admission->TOT_BIAYA_FISIO->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_FISIO"<?php echo $t_admission->TOT_BIAYA_FISIO->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_FISIO">
<span<?php echo $t_admission->TOT_BIAYA_FISIO->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_FISIO->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_LAINLAIN->Visible) { // TOT_BIAYA_LAINLAIN ?>
	<tr id="r_TOT_BIAYA_LAINLAIN">
		<td><span id="elh_t_admission_TOT_BIAYA_LAINLAIN"><?php echo $t_admission->TOT_BIAYA_LAINLAIN->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_LAINLAIN"<?php echo $t_admission->TOT_BIAYA_LAINLAIN->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_LAINLAIN">
<span<?php echo $t_admission->TOT_BIAYA_LAINLAIN->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_LAINLAIN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->jenisperawatan_id->Visible) { // jenisperawatan_id ?>
	<tr id="r_jenisperawatan_id">
		<td><span id="elh_t_admission_jenisperawatan_id"><?php echo $t_admission->jenisperawatan_id->FldCaption() ?></span></td>
		<td data-name="jenisperawatan_id"<?php echo $t_admission->jenisperawatan_id->CellAttributes() ?>>
<span id="el_t_admission_jenisperawatan_id">
<span<?php echo $t_admission->jenisperawatan_id->ViewAttributes() ?>>
<?php echo $t_admission->jenisperawatan_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->status_transaksi->Visible) { // status_transaksi ?>
	<tr id="r_status_transaksi">
		<td><span id="elh_t_admission_status_transaksi"><?php echo $t_admission->status_transaksi->FldCaption() ?></span></td>
		<td data-name="status_transaksi"<?php echo $t_admission->status_transaksi->CellAttributes() ?>>
<span id="el_t_admission_status_transaksi">
<span<?php echo $t_admission->status_transaksi->ViewAttributes() ?>>
<?php echo $t_admission->status_transaksi->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->statuskeluarranap_id->Visible) { // statuskeluarranap_id ?>
	<tr id="r_statuskeluarranap_id">
		<td><span id="elh_t_admission_statuskeluarranap_id"><?php echo $t_admission->statuskeluarranap_id->FldCaption() ?></span></td>
		<td data-name="statuskeluarranap_id"<?php echo $t_admission->statuskeluarranap_id->CellAttributes() ?>>
<span id="el_t_admission_statuskeluarranap_id">
<span<?php echo $t_admission->statuskeluarranap_id->ViewAttributes() ?>>
<?php echo $t_admission->statuskeluarranap_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_BIAYA_AKOMODASI->Visible) { // TOT_BIAYA_AKOMODASI ?>
	<tr id="r_TOT_BIAYA_AKOMODASI">
		<td><span id="elh_t_admission_TOT_BIAYA_AKOMODASI"><?php echo $t_admission->TOT_BIAYA_AKOMODASI->FldCaption() ?></span></td>
		<td data-name="TOT_BIAYA_AKOMODASI"<?php echo $t_admission->TOT_BIAYA_AKOMODASI->CellAttributes() ?>>
<span id="el_t_admission_TOT_BIAYA_AKOMODASI">
<span<?php echo $t_admission->TOT_BIAYA_AKOMODASI->ViewAttributes() ?>>
<?php echo $t_admission->TOT_BIAYA_AKOMODASI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOTAL_BIAYA_ASKEP->Visible) { // TOTAL_BIAYA_ASKEP ?>
	<tr id="r_TOTAL_BIAYA_ASKEP">
		<td><span id="elh_t_admission_TOTAL_BIAYA_ASKEP"><?php echo $t_admission->TOTAL_BIAYA_ASKEP->FldCaption() ?></span></td>
		<td data-name="TOTAL_BIAYA_ASKEP"<?php echo $t_admission->TOTAL_BIAYA_ASKEP->CellAttributes() ?>>
<span id="el_t_admission_TOTAL_BIAYA_ASKEP">
<span<?php echo $t_admission->TOTAL_BIAYA_ASKEP->ViewAttributes() ?>>
<?php echo $t_admission->TOTAL_BIAYA_ASKEP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOTAL_BIAYA_SIMRS->Visible) { // TOTAL_BIAYA_SIMRS ?>
	<tr id="r_TOTAL_BIAYA_SIMRS">
		<td><span id="elh_t_admission_TOTAL_BIAYA_SIMRS"><?php echo $t_admission->TOTAL_BIAYA_SIMRS->FldCaption() ?></span></td>
		<td data-name="TOTAL_BIAYA_SIMRS"<?php echo $t_admission->TOTAL_BIAYA_SIMRS->CellAttributes() ?>>
<span id="el_t_admission_TOTAL_BIAYA_SIMRS">
<span<?php echo $t_admission->TOTAL_BIAYA_SIMRS->ViewAttributes() ?>>
<?php echo $t_admission->TOTAL_BIAYA_SIMRS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_PENJ_NMEDIS->Visible) { // TOT_PENJ_NMEDIS ?>
	<tr id="r_TOT_PENJ_NMEDIS">
		<td><span id="elh_t_admission_TOT_PENJ_NMEDIS"><?php echo $t_admission->TOT_PENJ_NMEDIS->FldCaption() ?></span></td>
		<td data-name="TOT_PENJ_NMEDIS"<?php echo $t_admission->TOT_PENJ_NMEDIS->CellAttributes() ?>>
<span id="el_t_admission_TOT_PENJ_NMEDIS">
<span<?php echo $t_admission->TOT_PENJ_NMEDIS->ViewAttributes() ?>>
<?php echo $t_admission->TOT_PENJ_NMEDIS->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->LINK_MASTERDETAIL->Visible) { // LINK_MASTERDETAIL ?>
	<tr id="r_LINK_MASTERDETAIL">
		<td><span id="elh_t_admission_LINK_MASTERDETAIL"><?php echo $t_admission->LINK_MASTERDETAIL->FldCaption() ?></span></td>
		<td data-name="LINK_MASTERDETAIL"<?php echo $t_admission->LINK_MASTERDETAIL->CellAttributes() ?>>
<span id="el_t_admission_LINK_MASTERDETAIL">
<span<?php echo $t_admission->LINK_MASTERDETAIL->ViewAttributes() ?>>
<?php echo $t_admission->LINK_MASTERDETAIL->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->NO_SKP->Visible) { // NO_SKP ?>
	<tr id="r_NO_SKP">
		<td><span id="elh_t_admission_NO_SKP"><?php echo $t_admission->NO_SKP->FldCaption() ?></span></td>
		<td data-name="NO_SKP"<?php echo $t_admission->NO_SKP->CellAttributes() ?>>
<span id="el_t_admission_NO_SKP">
<span<?php echo $t_admission->NO_SKP->ViewAttributes() ?>>
<?php echo $t_admission->NO_SKP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->LINK_PELAYANAN_OBAT->Visible) { // LINK_PELAYANAN_OBAT ?>
	<tr id="r_LINK_PELAYANAN_OBAT">
		<td><span id="elh_t_admission_LINK_PELAYANAN_OBAT"><?php echo $t_admission->LINK_PELAYANAN_OBAT->FldCaption() ?></span></td>
		<td data-name="LINK_PELAYANAN_OBAT"<?php echo $t_admission->LINK_PELAYANAN_OBAT->CellAttributes() ?>>
<span id="el_t_admission_LINK_PELAYANAN_OBAT">
<span<?php echo $t_admission->LINK_PELAYANAN_OBAT->ViewAttributes() ?>>
<?php echo $t_admission->LINK_PELAYANAN_OBAT->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_TIND_RAJAL->Visible) { // TOT_TIND_RAJAL ?>
	<tr id="r_TOT_TIND_RAJAL">
		<td><span id="elh_t_admission_TOT_TIND_RAJAL"><?php echo $t_admission->TOT_TIND_RAJAL->FldCaption() ?></span></td>
		<td data-name="TOT_TIND_RAJAL"<?php echo $t_admission->TOT_TIND_RAJAL->CellAttributes() ?>>
<span id="el_t_admission_TOT_TIND_RAJAL">
<span<?php echo $t_admission->TOT_TIND_RAJAL->ViewAttributes() ?>>
<?php echo $t_admission->TOT_TIND_RAJAL->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->TOT_TIND_IGD->Visible) { // TOT_TIND_IGD ?>
	<tr id="r_TOT_TIND_IGD">
		<td><span id="elh_t_admission_TOT_TIND_IGD"><?php echo $t_admission->TOT_TIND_IGD->FldCaption() ?></span></td>
		<td data-name="TOT_TIND_IGD"<?php echo $t_admission->TOT_TIND_IGD->CellAttributes() ?>>
<span id="el_t_admission_TOT_TIND_IGD">
<span<?php echo $t_admission->TOT_TIND_IGD->ViewAttributes() ?>>
<?php echo $t_admission->TOT_TIND_IGD->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->tanggal_pengembalian_status->Visible) { // tanggal_pengembalian_status ?>
	<tr id="r_tanggal_pengembalian_status">
		<td><span id="elh_t_admission_tanggal_pengembalian_status"><?php echo $t_admission->tanggal_pengembalian_status->FldCaption() ?></span></td>
		<td data-name="tanggal_pengembalian_status"<?php echo $t_admission->tanggal_pengembalian_status->CellAttributes() ?>>
<span id="el_t_admission_tanggal_pengembalian_status">
<span<?php echo $t_admission->tanggal_pengembalian_status->ViewAttributes() ?>>
<?php echo $t_admission->tanggal_pengembalian_status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->naik_kelas->Visible) { // naik_kelas ?>
	<tr id="r_naik_kelas">
		<td><span id="elh_t_admission_naik_kelas"><?php echo $t_admission->naik_kelas->FldCaption() ?></span></td>
		<td data-name="naik_kelas"<?php echo $t_admission->naik_kelas->CellAttributes() ?>>
<span id="el_t_admission_naik_kelas">
<span<?php echo $t_admission->naik_kelas->ViewAttributes() ?>>
<?php echo $t_admission->naik_kelas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->iuran_kelas_lama->Visible) { // iuran_kelas_lama ?>
	<tr id="r_iuran_kelas_lama">
		<td><span id="elh_t_admission_iuran_kelas_lama"><?php echo $t_admission->iuran_kelas_lama->FldCaption() ?></span></td>
		<td data-name="iuran_kelas_lama"<?php echo $t_admission->iuran_kelas_lama->CellAttributes() ?>>
<span id="el_t_admission_iuran_kelas_lama">
<span<?php echo $t_admission->iuran_kelas_lama->ViewAttributes() ?>>
<?php echo $t_admission->iuran_kelas_lama->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->iuran_kelas_baru->Visible) { // iuran_kelas_baru ?>
	<tr id="r_iuran_kelas_baru">
		<td><span id="elh_t_admission_iuran_kelas_baru"><?php echo $t_admission->iuran_kelas_baru->FldCaption() ?></span></td>
		<td data-name="iuran_kelas_baru"<?php echo $t_admission->iuran_kelas_baru->CellAttributes() ?>>
<span id="el_t_admission_iuran_kelas_baru">
<span<?php echo $t_admission->iuran_kelas_baru->ViewAttributes() ?>>
<?php echo $t_admission->iuran_kelas_baru->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->ketrangan_naik_kelas->Visible) { // ketrangan_naik_kelas ?>
	<tr id="r_ketrangan_naik_kelas">
		<td><span id="elh_t_admission_ketrangan_naik_kelas"><?php echo $t_admission->ketrangan_naik_kelas->FldCaption() ?></span></td>
		<td data-name="ketrangan_naik_kelas"<?php echo $t_admission->ketrangan_naik_kelas->CellAttributes() ?>>
<span id="el_t_admission_ketrangan_naik_kelas">
<span<?php echo $t_admission->ketrangan_naik_kelas->ViewAttributes() ?>>
<?php echo $t_admission->ketrangan_naik_kelas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->tgl_pengiriman_ad_klaim->Visible) { // tgl_pengiriman_ad_klaim ?>
	<tr id="r_tgl_pengiriman_ad_klaim">
		<td><span id="elh_t_admission_tgl_pengiriman_ad_klaim"><?php echo $t_admission->tgl_pengiriman_ad_klaim->FldCaption() ?></span></td>
		<td data-name="tgl_pengiriman_ad_klaim"<?php echo $t_admission->tgl_pengiriman_ad_klaim->CellAttributes() ?>>
<span id="el_t_admission_tgl_pengiriman_ad_klaim">
<span<?php echo $t_admission->tgl_pengiriman_ad_klaim->ViewAttributes() ?>>
<?php echo $t_admission->tgl_pengiriman_ad_klaim->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->diagnosa_keluar->Visible) { // diagnosa_keluar ?>
	<tr id="r_diagnosa_keluar">
		<td><span id="elh_t_admission_diagnosa_keluar"><?php echo $t_admission->diagnosa_keluar->FldCaption() ?></span></td>
		<td data-name="diagnosa_keluar"<?php echo $t_admission->diagnosa_keluar->CellAttributes() ?>>
<span id="el_t_admission_diagnosa_keluar">
<span<?php echo $t_admission->diagnosa_keluar->ViewAttributes() ?>>
<?php echo $t_admission->diagnosa_keluar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_tglsep->Visible) { // sep_tglsep ?>
	<tr id="r_sep_tglsep">
		<td><span id="elh_t_admission_sep_tglsep"><?php echo $t_admission->sep_tglsep->FldCaption() ?></span></td>
		<td data-name="sep_tglsep"<?php echo $t_admission->sep_tglsep->CellAttributes() ?>>
<span id="el_t_admission_sep_tglsep">
<span<?php echo $t_admission->sep_tglsep->ViewAttributes() ?>>
<?php echo $t_admission->sep_tglsep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_tglrujuk->Visible) { // sep_tglrujuk ?>
	<tr id="r_sep_tglrujuk">
		<td><span id="elh_t_admission_sep_tglrujuk"><?php echo $t_admission->sep_tglrujuk->FldCaption() ?></span></td>
		<td data-name="sep_tglrujuk"<?php echo $t_admission->sep_tglrujuk->CellAttributes() ?>>
<span id="el_t_admission_sep_tglrujuk">
<span<?php echo $t_admission->sep_tglrujuk->ViewAttributes() ?>>
<?php echo $t_admission->sep_tglrujuk->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_kodekelasrawat->Visible) { // sep_kodekelasrawat ?>
	<tr id="r_sep_kodekelasrawat">
		<td><span id="elh_t_admission_sep_kodekelasrawat"><?php echo $t_admission->sep_kodekelasrawat->FldCaption() ?></span></td>
		<td data-name="sep_kodekelasrawat"<?php echo $t_admission->sep_kodekelasrawat->CellAttributes() ?>>
<span id="el_t_admission_sep_kodekelasrawat">
<span<?php echo $t_admission->sep_kodekelasrawat->ViewAttributes() ?>>
<?php echo $t_admission->sep_kodekelasrawat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_norujukan->Visible) { // sep_norujukan ?>
	<tr id="r_sep_norujukan">
		<td><span id="elh_t_admission_sep_norujukan"><?php echo $t_admission->sep_norujukan->FldCaption() ?></span></td>
		<td data-name="sep_norujukan"<?php echo $t_admission->sep_norujukan->CellAttributes() ?>>
<span id="el_t_admission_sep_norujukan">
<span<?php echo $t_admission->sep_norujukan->ViewAttributes() ?>>
<?php echo $t_admission->sep_norujukan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_kodeppkasal->Visible) { // sep_kodeppkasal ?>
	<tr id="r_sep_kodeppkasal">
		<td><span id="elh_t_admission_sep_kodeppkasal"><?php echo $t_admission->sep_kodeppkasal->FldCaption() ?></span></td>
		<td data-name="sep_kodeppkasal"<?php echo $t_admission->sep_kodeppkasal->CellAttributes() ?>>
<span id="el_t_admission_sep_kodeppkasal">
<span<?php echo $t_admission->sep_kodeppkasal->ViewAttributes() ?>>
<?php echo $t_admission->sep_kodeppkasal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_namappkasal->Visible) { // sep_namappkasal ?>
	<tr id="r_sep_namappkasal">
		<td><span id="elh_t_admission_sep_namappkasal"><?php echo $t_admission->sep_namappkasal->FldCaption() ?></span></td>
		<td data-name="sep_namappkasal"<?php echo $t_admission->sep_namappkasal->CellAttributes() ?>>
<span id="el_t_admission_sep_namappkasal">
<span<?php echo $t_admission->sep_namappkasal->ViewAttributes() ?>>
<?php echo $t_admission->sep_namappkasal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_kodeppkpelayanan->Visible) { // sep_kodeppkpelayanan ?>
	<tr id="r_sep_kodeppkpelayanan">
		<td><span id="elh_t_admission_sep_kodeppkpelayanan"><?php echo $t_admission->sep_kodeppkpelayanan->FldCaption() ?></span></td>
		<td data-name="sep_kodeppkpelayanan"<?php echo $t_admission->sep_kodeppkpelayanan->CellAttributes() ?>>
<span id="el_t_admission_sep_kodeppkpelayanan">
<span<?php echo $t_admission->sep_kodeppkpelayanan->ViewAttributes() ?>>
<?php echo $t_admission->sep_kodeppkpelayanan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_namappkpelayanan->Visible) { // sep_namappkpelayanan ?>
	<tr id="r_sep_namappkpelayanan">
		<td><span id="elh_t_admission_sep_namappkpelayanan"><?php echo $t_admission->sep_namappkpelayanan->FldCaption() ?></span></td>
		<td data-name="sep_namappkpelayanan"<?php echo $t_admission->sep_namappkpelayanan->CellAttributes() ?>>
<span id="el_t_admission_sep_namappkpelayanan">
<span<?php echo $t_admission->sep_namappkpelayanan->ViewAttributes() ?>>
<?php echo $t_admission->sep_namappkpelayanan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->t_admissioncol->Visible) { // t_admissioncol ?>
	<tr id="r_t_admissioncol">
		<td><span id="elh_t_admission_t_admissioncol"><?php echo $t_admission->t_admissioncol->FldCaption() ?></span></td>
		<td data-name="t_admissioncol"<?php echo $t_admission->t_admissioncol->CellAttributes() ?>>
<span id="el_t_admission_t_admissioncol">
<span<?php echo $t_admission->t_admissioncol->ViewAttributes() ?>>
<?php echo $t_admission->t_admissioncol->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_jenisperawatan->Visible) { // sep_jenisperawatan ?>
	<tr id="r_sep_jenisperawatan">
		<td><span id="elh_t_admission_sep_jenisperawatan"><?php echo $t_admission->sep_jenisperawatan->FldCaption() ?></span></td>
		<td data-name="sep_jenisperawatan"<?php echo $t_admission->sep_jenisperawatan->CellAttributes() ?>>
<span id="el_t_admission_sep_jenisperawatan">
<span<?php echo $t_admission->sep_jenisperawatan->ViewAttributes() ?>>
<?php echo $t_admission->sep_jenisperawatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_catatan->Visible) { // sep_catatan ?>
	<tr id="r_sep_catatan">
		<td><span id="elh_t_admission_sep_catatan"><?php echo $t_admission->sep_catatan->FldCaption() ?></span></td>
		<td data-name="sep_catatan"<?php echo $t_admission->sep_catatan->CellAttributes() ?>>
<span id="el_t_admission_sep_catatan">
<span<?php echo $t_admission->sep_catatan->ViewAttributes() ?>>
<?php echo $t_admission->sep_catatan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_kodediagnosaawal->Visible) { // sep_kodediagnosaawal ?>
	<tr id="r_sep_kodediagnosaawal">
		<td><span id="elh_t_admission_sep_kodediagnosaawal"><?php echo $t_admission->sep_kodediagnosaawal->FldCaption() ?></span></td>
		<td data-name="sep_kodediagnosaawal"<?php echo $t_admission->sep_kodediagnosaawal->CellAttributes() ?>>
<span id="el_t_admission_sep_kodediagnosaawal">
<span<?php echo $t_admission->sep_kodediagnosaawal->ViewAttributes() ?>>
<?php echo $t_admission->sep_kodediagnosaawal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_namadiagnosaawal->Visible) { // sep_namadiagnosaawal ?>
	<tr id="r_sep_namadiagnosaawal">
		<td><span id="elh_t_admission_sep_namadiagnosaawal"><?php echo $t_admission->sep_namadiagnosaawal->FldCaption() ?></span></td>
		<td data-name="sep_namadiagnosaawal"<?php echo $t_admission->sep_namadiagnosaawal->CellAttributes() ?>>
<span id="el_t_admission_sep_namadiagnosaawal">
<span<?php echo $t_admission->sep_namadiagnosaawal->ViewAttributes() ?>>
<?php echo $t_admission->sep_namadiagnosaawal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_lakalantas->Visible) { // sep_lakalantas ?>
	<tr id="r_sep_lakalantas">
		<td><span id="elh_t_admission_sep_lakalantas"><?php echo $t_admission->sep_lakalantas->FldCaption() ?></span></td>
		<td data-name="sep_lakalantas"<?php echo $t_admission->sep_lakalantas->CellAttributes() ?>>
<span id="el_t_admission_sep_lakalantas">
<span<?php echo $t_admission->sep_lakalantas->ViewAttributes() ?>>
<?php echo $t_admission->sep_lakalantas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_lokasilaka->Visible) { // sep_lokasilaka ?>
	<tr id="r_sep_lokasilaka">
		<td><span id="elh_t_admission_sep_lokasilaka"><?php echo $t_admission->sep_lokasilaka->FldCaption() ?></span></td>
		<td data-name="sep_lokasilaka"<?php echo $t_admission->sep_lokasilaka->CellAttributes() ?>>
<span id="el_t_admission_sep_lokasilaka">
<span<?php echo $t_admission->sep_lokasilaka->ViewAttributes() ?>>
<?php echo $t_admission->sep_lokasilaka->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_user->Visible) { // sep_user ?>
	<tr id="r_sep_user">
		<td><span id="elh_t_admission_sep_user"><?php echo $t_admission->sep_user->FldCaption() ?></span></td>
		<td data-name="sep_user"<?php echo $t_admission->sep_user->CellAttributes() ?>>
<span id="el_t_admission_sep_user">
<span<?php echo $t_admission->sep_user->ViewAttributes() ?>>
<?php echo $t_admission->sep_user->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_flag_cekpeserta->Visible) { // sep_flag_cekpeserta ?>
	<tr id="r_sep_flag_cekpeserta">
		<td><span id="elh_t_admission_sep_flag_cekpeserta"><?php echo $t_admission->sep_flag_cekpeserta->FldCaption() ?></span></td>
		<td data-name="sep_flag_cekpeserta"<?php echo $t_admission->sep_flag_cekpeserta->CellAttributes() ?>>
<span id="el_t_admission_sep_flag_cekpeserta">
<span<?php echo $t_admission->sep_flag_cekpeserta->ViewAttributes() ?>>
<?php echo $t_admission->sep_flag_cekpeserta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_flag_generatesep->Visible) { // sep_flag_generatesep ?>
	<tr id="r_sep_flag_generatesep">
		<td><span id="elh_t_admission_sep_flag_generatesep"><?php echo $t_admission->sep_flag_generatesep->FldCaption() ?></span></td>
		<td data-name="sep_flag_generatesep"<?php echo $t_admission->sep_flag_generatesep->CellAttributes() ?>>
<span id="el_t_admission_sep_flag_generatesep">
<span<?php echo $t_admission->sep_flag_generatesep->ViewAttributes() ?>>
<?php echo $t_admission->sep_flag_generatesep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_flag_mapingsep->Visible) { // sep_flag_mapingsep ?>
	<tr id="r_sep_flag_mapingsep">
		<td><span id="elh_t_admission_sep_flag_mapingsep"><?php echo $t_admission->sep_flag_mapingsep->FldCaption() ?></span></td>
		<td data-name="sep_flag_mapingsep"<?php echo $t_admission->sep_flag_mapingsep->CellAttributes() ?>>
<span id="el_t_admission_sep_flag_mapingsep">
<span<?php echo $t_admission->sep_flag_mapingsep->ViewAttributes() ?>>
<?php echo $t_admission->sep_flag_mapingsep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_nik->Visible) { // sep_nik ?>
	<tr id="r_sep_nik">
		<td><span id="elh_t_admission_sep_nik"><?php echo $t_admission->sep_nik->FldCaption() ?></span></td>
		<td data-name="sep_nik"<?php echo $t_admission->sep_nik->CellAttributes() ?>>
<span id="el_t_admission_sep_nik">
<span<?php echo $t_admission->sep_nik->ViewAttributes() ?>>
<?php echo $t_admission->sep_nik->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_namapeserta->Visible) { // sep_namapeserta ?>
	<tr id="r_sep_namapeserta">
		<td><span id="elh_t_admission_sep_namapeserta"><?php echo $t_admission->sep_namapeserta->FldCaption() ?></span></td>
		<td data-name="sep_namapeserta"<?php echo $t_admission->sep_namapeserta->CellAttributes() ?>>
<span id="el_t_admission_sep_namapeserta">
<span<?php echo $t_admission->sep_namapeserta->ViewAttributes() ?>>
<?php echo $t_admission->sep_namapeserta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_jeniskelamin->Visible) { // sep_jeniskelamin ?>
	<tr id="r_sep_jeniskelamin">
		<td><span id="elh_t_admission_sep_jeniskelamin"><?php echo $t_admission->sep_jeniskelamin->FldCaption() ?></span></td>
		<td data-name="sep_jeniskelamin"<?php echo $t_admission->sep_jeniskelamin->CellAttributes() ?>>
<span id="el_t_admission_sep_jeniskelamin">
<span<?php echo $t_admission->sep_jeniskelamin->ViewAttributes() ?>>
<?php echo $t_admission->sep_jeniskelamin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_pisat->Visible) { // sep_pisat ?>
	<tr id="r_sep_pisat">
		<td><span id="elh_t_admission_sep_pisat"><?php echo $t_admission->sep_pisat->FldCaption() ?></span></td>
		<td data-name="sep_pisat"<?php echo $t_admission->sep_pisat->CellAttributes() ?>>
<span id="el_t_admission_sep_pisat">
<span<?php echo $t_admission->sep_pisat->ViewAttributes() ?>>
<?php echo $t_admission->sep_pisat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_tgllahir->Visible) { // sep_tgllahir ?>
	<tr id="r_sep_tgllahir">
		<td><span id="elh_t_admission_sep_tgllahir"><?php echo $t_admission->sep_tgllahir->FldCaption() ?></span></td>
		<td data-name="sep_tgllahir"<?php echo $t_admission->sep_tgllahir->CellAttributes() ?>>
<span id="el_t_admission_sep_tgllahir">
<span<?php echo $t_admission->sep_tgllahir->ViewAttributes() ?>>
<?php echo $t_admission->sep_tgllahir->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_kodejeniskepesertaan->Visible) { // sep_kodejeniskepesertaan ?>
	<tr id="r_sep_kodejeniskepesertaan">
		<td><span id="elh_t_admission_sep_kodejeniskepesertaan"><?php echo $t_admission->sep_kodejeniskepesertaan->FldCaption() ?></span></td>
		<td data-name="sep_kodejeniskepesertaan"<?php echo $t_admission->sep_kodejeniskepesertaan->CellAttributes() ?>>
<span id="el_t_admission_sep_kodejeniskepesertaan">
<span<?php echo $t_admission->sep_kodejeniskepesertaan->ViewAttributes() ?>>
<?php echo $t_admission->sep_kodejeniskepesertaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_namajeniskepesertaan->Visible) { // sep_namajeniskepesertaan ?>
	<tr id="r_sep_namajeniskepesertaan">
		<td><span id="elh_t_admission_sep_namajeniskepesertaan"><?php echo $t_admission->sep_namajeniskepesertaan->FldCaption() ?></span></td>
		<td data-name="sep_namajeniskepesertaan"<?php echo $t_admission->sep_namajeniskepesertaan->CellAttributes() ?>>
<span id="el_t_admission_sep_namajeniskepesertaan">
<span<?php echo $t_admission->sep_namajeniskepesertaan->ViewAttributes() ?>>
<?php echo $t_admission->sep_namajeniskepesertaan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_kodepolitujuan->Visible) { // sep_kodepolitujuan ?>
	<tr id="r_sep_kodepolitujuan">
		<td><span id="elh_t_admission_sep_kodepolitujuan"><?php echo $t_admission->sep_kodepolitujuan->FldCaption() ?></span></td>
		<td data-name="sep_kodepolitujuan"<?php echo $t_admission->sep_kodepolitujuan->CellAttributes() ?>>
<span id="el_t_admission_sep_kodepolitujuan">
<span<?php echo $t_admission->sep_kodepolitujuan->ViewAttributes() ?>>
<?php echo $t_admission->sep_kodepolitujuan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_namapolitujuan->Visible) { // sep_namapolitujuan ?>
	<tr id="r_sep_namapolitujuan">
		<td><span id="elh_t_admission_sep_namapolitujuan"><?php echo $t_admission->sep_namapolitujuan->FldCaption() ?></span></td>
		<td data-name="sep_namapolitujuan"<?php echo $t_admission->sep_namapolitujuan->CellAttributes() ?>>
<span id="el_t_admission_sep_namapolitujuan">
<span<?php echo $t_admission->sep_namapolitujuan->ViewAttributes() ?>>
<?php echo $t_admission->sep_namapolitujuan->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->ket_jeniskelamin->Visible) { // ket_jeniskelamin ?>
	<tr id="r_ket_jeniskelamin">
		<td><span id="elh_t_admission_ket_jeniskelamin"><?php echo $t_admission->ket_jeniskelamin->FldCaption() ?></span></td>
		<td data-name="ket_jeniskelamin"<?php echo $t_admission->ket_jeniskelamin->CellAttributes() ?>>
<span id="el_t_admission_ket_jeniskelamin">
<span<?php echo $t_admission->ket_jeniskelamin->ViewAttributes() ?>>
<?php echo $t_admission->ket_jeniskelamin->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_nokabpjs->Visible) { // sep_nokabpjs ?>
	<tr id="r_sep_nokabpjs">
		<td><span id="elh_t_admission_sep_nokabpjs"><?php echo $t_admission->sep_nokabpjs->FldCaption() ?></span></td>
		<td data-name="sep_nokabpjs"<?php echo $t_admission->sep_nokabpjs->CellAttributes() ?>>
<span id="el_t_admission_sep_nokabpjs">
<span<?php echo $t_admission->sep_nokabpjs->ViewAttributes() ?>>
<?php echo $t_admission->sep_nokabpjs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->counter_cetak_sep->Visible) { // counter_cetak_sep ?>
	<tr id="r_counter_cetak_sep">
		<td><span id="elh_t_admission_counter_cetak_sep"><?php echo $t_admission->counter_cetak_sep->FldCaption() ?></span></td>
		<td data-name="counter_cetak_sep"<?php echo $t_admission->counter_cetak_sep->CellAttributes() ?>>
<span id="el_t_admission_counter_cetak_sep">
<span<?php echo $t_admission->counter_cetak_sep->ViewAttributes() ?>>
<?php echo $t_admission->counter_cetak_sep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_petugas_hapus_sep->Visible) { // sep_petugas_hapus_sep ?>
	<tr id="r_sep_petugas_hapus_sep">
		<td><span id="elh_t_admission_sep_petugas_hapus_sep"><?php echo $t_admission->sep_petugas_hapus_sep->FldCaption() ?></span></td>
		<td data-name="sep_petugas_hapus_sep"<?php echo $t_admission->sep_petugas_hapus_sep->CellAttributes() ?>>
<span id="el_t_admission_sep_petugas_hapus_sep">
<span<?php echo $t_admission->sep_petugas_hapus_sep->ViewAttributes() ?>>
<?php echo $t_admission->sep_petugas_hapus_sep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_petugas_set_tgl_pulang->Visible) { // sep_petugas_set_tgl_pulang ?>
	<tr id="r_sep_petugas_set_tgl_pulang">
		<td><span id="elh_t_admission_sep_petugas_set_tgl_pulang"><?php echo $t_admission->sep_petugas_set_tgl_pulang->FldCaption() ?></span></td>
		<td data-name="sep_petugas_set_tgl_pulang"<?php echo $t_admission->sep_petugas_set_tgl_pulang->CellAttributes() ?>>
<span id="el_t_admission_sep_petugas_set_tgl_pulang">
<span<?php echo $t_admission->sep_petugas_set_tgl_pulang->ViewAttributes() ?>>
<?php echo $t_admission->sep_petugas_set_tgl_pulang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_jam_generate_sep->Visible) { // sep_jam_generate_sep ?>
	<tr id="r_sep_jam_generate_sep">
		<td><span id="elh_t_admission_sep_jam_generate_sep"><?php echo $t_admission->sep_jam_generate_sep->FldCaption() ?></span></td>
		<td data-name="sep_jam_generate_sep"<?php echo $t_admission->sep_jam_generate_sep->CellAttributes() ?>>
<span id="el_t_admission_sep_jam_generate_sep">
<span<?php echo $t_admission->sep_jam_generate_sep->ViewAttributes() ?>>
<?php echo $t_admission->sep_jam_generate_sep->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_status_peserta->Visible) { // sep_status_peserta ?>
	<tr id="r_sep_status_peserta">
		<td><span id="elh_t_admission_sep_status_peserta"><?php echo $t_admission->sep_status_peserta->FldCaption() ?></span></td>
		<td data-name="sep_status_peserta"<?php echo $t_admission->sep_status_peserta->CellAttributes() ?>>
<span id="el_t_admission_sep_status_peserta">
<span<?php echo $t_admission->sep_status_peserta->ViewAttributes() ?>>
<?php echo $t_admission->sep_status_peserta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->sep_umur_pasien_sekarang->Visible) { // sep_umur_pasien_sekarang ?>
	<tr id="r_sep_umur_pasien_sekarang">
		<td><span id="elh_t_admission_sep_umur_pasien_sekarang"><?php echo $t_admission->sep_umur_pasien_sekarang->FldCaption() ?></span></td>
		<td data-name="sep_umur_pasien_sekarang"<?php echo $t_admission->sep_umur_pasien_sekarang->CellAttributes() ?>>
<span id="el_t_admission_sep_umur_pasien_sekarang">
<span<?php echo $t_admission->sep_umur_pasien_sekarang->ViewAttributes() ?>>
<?php echo $t_admission->sep_umur_pasien_sekarang->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->ket_title->Visible) { // ket_title ?>
	<tr id="r_ket_title">
		<td><span id="elh_t_admission_ket_title"><?php echo $t_admission->ket_title->FldCaption() ?></span></td>
		<td data-name="ket_title"<?php echo $t_admission->ket_title->CellAttributes() ?>>
<span id="el_t_admission_ket_title">
<span<?php echo $t_admission->ket_title->ViewAttributes() ?>>
<?php echo $t_admission->ket_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->status_daftar_ranap->Visible) { // status_daftar_ranap ?>
	<tr id="r_status_daftar_ranap">
		<td><span id="elh_t_admission_status_daftar_ranap"><?php echo $t_admission->status_daftar_ranap->FldCaption() ?></span></td>
		<td data-name="status_daftar_ranap"<?php echo $t_admission->status_daftar_ranap->CellAttributes() ?>>
<span id="el_t_admission_status_daftar_ranap">
<span<?php echo $t_admission->status_daftar_ranap->ViewAttributes() ?>>
<?php echo $t_admission->status_daftar_ranap->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_SETMARKING->Visible) { // IBS_SETMARKING ?>
	<tr id="r_IBS_SETMARKING">
		<td><span id="elh_t_admission_IBS_SETMARKING"><?php echo $t_admission->IBS_SETMARKING->FldCaption() ?></span></td>
		<td data-name="IBS_SETMARKING"<?php echo $t_admission->IBS_SETMARKING->CellAttributes() ?>>
<span id="el_t_admission_IBS_SETMARKING">
<span<?php echo $t_admission->IBS_SETMARKING->ViewAttributes() ?>>
<?php echo $t_admission->IBS_SETMARKING->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_PATOLOGI->Visible) { // IBS_PATOLOGI ?>
	<tr id="r_IBS_PATOLOGI">
		<td><span id="elh_t_admission_IBS_PATOLOGI"><?php echo $t_admission->IBS_PATOLOGI->FldCaption() ?></span></td>
		<td data-name="IBS_PATOLOGI"<?php echo $t_admission->IBS_PATOLOGI->CellAttributes() ?>>
<span id="el_t_admission_IBS_PATOLOGI">
<span<?php echo $t_admission->IBS_PATOLOGI->ViewAttributes() ?>>
<?php echo $t_admission->IBS_PATOLOGI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_JENISANESTESI->Visible) { // IBS_JENISANESTESI ?>
	<tr id="r_IBS_JENISANESTESI">
		<td><span id="elh_t_admission_IBS_JENISANESTESI"><?php echo $t_admission->IBS_JENISANESTESI->FldCaption() ?></span></td>
		<td data-name="IBS_JENISANESTESI"<?php echo $t_admission->IBS_JENISANESTESI->CellAttributes() ?>>
<span id="el_t_admission_IBS_JENISANESTESI">
<span<?php echo $t_admission->IBS_JENISANESTESI->ViewAttributes() ?>>
<?php echo $t_admission->IBS_JENISANESTESI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_NO_OK->Visible) { // IBS_NO_OK ?>
	<tr id="r_IBS_NO_OK">
		<td><span id="elh_t_admission_IBS_NO_OK"><?php echo $t_admission->IBS_NO_OK->FldCaption() ?></span></td>
		<td data-name="IBS_NO_OK"<?php echo $t_admission->IBS_NO_OK->CellAttributes() ?>>
<span id="el_t_admission_IBS_NO_OK">
<span<?php echo $t_admission->IBS_NO_OK->ViewAttributes() ?>>
<?php echo $t_admission->IBS_NO_OK->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_ASISSTEN->Visible) { // IBS_ASISSTEN ?>
	<tr id="r_IBS_ASISSTEN">
		<td><span id="elh_t_admission_IBS_ASISSTEN"><?php echo $t_admission->IBS_ASISSTEN->FldCaption() ?></span></td>
		<td data-name="IBS_ASISSTEN"<?php echo $t_admission->IBS_ASISSTEN->CellAttributes() ?>>
<span id="el_t_admission_IBS_ASISSTEN">
<span<?php echo $t_admission->IBS_ASISSTEN->ViewAttributes() ?>>
<?php echo $t_admission->IBS_ASISSTEN->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_JAM_ELEFTIF->Visible) { // IBS_JAM_ELEFTIF ?>
	<tr id="r_IBS_JAM_ELEFTIF">
		<td><span id="elh_t_admission_IBS_JAM_ELEFTIF"><?php echo $t_admission->IBS_JAM_ELEFTIF->FldCaption() ?></span></td>
		<td data-name="IBS_JAM_ELEFTIF"<?php echo $t_admission->IBS_JAM_ELEFTIF->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_ELEFTIF">
<span<?php echo $t_admission->IBS_JAM_ELEFTIF->ViewAttributes() ?>>
<?php echo $t_admission->IBS_JAM_ELEFTIF->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_JAM_ELEKTIF_SELESAI->Visible) { // IBS_JAM_ELEKTIF_SELESAI ?>
	<tr id="r_IBS_JAM_ELEKTIF_SELESAI">
		<td><span id="elh_t_admission_IBS_JAM_ELEKTIF_SELESAI"><?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->FldCaption() ?></span></td>
		<td data-name="IBS_JAM_ELEKTIF_SELESAI"<?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_ELEKTIF_SELESAI">
<span<?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->ViewAttributes() ?>>
<?php echo $t_admission->IBS_JAM_ELEKTIF_SELESAI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_JAM_CYTO->Visible) { // IBS_JAM_CYTO ?>
	<tr id="r_IBS_JAM_CYTO">
		<td><span id="elh_t_admission_IBS_JAM_CYTO"><?php echo $t_admission->IBS_JAM_CYTO->FldCaption() ?></span></td>
		<td data-name="IBS_JAM_CYTO"<?php echo $t_admission->IBS_JAM_CYTO->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_CYTO">
<span<?php echo $t_admission->IBS_JAM_CYTO->ViewAttributes() ?>>
<?php echo $t_admission->IBS_JAM_CYTO->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_JAM_CYTO_SELESAI->Visible) { // IBS_JAM_CYTO_SELESAI ?>
	<tr id="r_IBS_JAM_CYTO_SELESAI">
		<td><span id="elh_t_admission_IBS_JAM_CYTO_SELESAI"><?php echo $t_admission->IBS_JAM_CYTO_SELESAI->FldCaption() ?></span></td>
		<td data-name="IBS_JAM_CYTO_SELESAI"<?php echo $t_admission->IBS_JAM_CYTO_SELESAI->CellAttributes() ?>>
<span id="el_t_admission_IBS_JAM_CYTO_SELESAI">
<span<?php echo $t_admission->IBS_JAM_CYTO_SELESAI->ViewAttributes() ?>>
<?php echo $t_admission->IBS_JAM_CYTO_SELESAI->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_TGL_DFTR_OP->Visible) { // IBS_TGL_DFTR_OP ?>
	<tr id="r_IBS_TGL_DFTR_OP">
		<td><span id="elh_t_admission_IBS_TGL_DFTR_OP"><?php echo $t_admission->IBS_TGL_DFTR_OP->FldCaption() ?></span></td>
		<td data-name="IBS_TGL_DFTR_OP"<?php echo $t_admission->IBS_TGL_DFTR_OP->CellAttributes() ?>>
<span id="el_t_admission_IBS_TGL_DFTR_OP">
<span<?php echo $t_admission->IBS_TGL_DFTR_OP->ViewAttributes() ?>>
<?php echo $t_admission->IBS_TGL_DFTR_OP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->IBS_TGL_OP->Visible) { // IBS_TGL_OP ?>
	<tr id="r_IBS_TGL_OP">
		<td><span id="elh_t_admission_IBS_TGL_OP"><?php echo $t_admission->IBS_TGL_OP->FldCaption() ?></span></td>
		<td data-name="IBS_TGL_OP"<?php echo $t_admission->IBS_TGL_OP->CellAttributes() ?>>
<span id="el_t_admission_IBS_TGL_OP">
<span<?php echo $t_admission->IBS_TGL_OP->ViewAttributes() ?>>
<?php echo $t_admission->IBS_TGL_OP->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->grup_ruang_id->Visible) { // grup_ruang_id ?>
	<tr id="r_grup_ruang_id">
		<td><span id="elh_t_admission_grup_ruang_id"><?php echo $t_admission->grup_ruang_id->FldCaption() ?></span></td>
		<td data-name="grup_ruang_id"<?php echo $t_admission->grup_ruang_id->CellAttributes() ?>>
<span id="el_t_admission_grup_ruang_id">
<span<?php echo $t_admission->grup_ruang_id->ViewAttributes() ?>>
<?php echo $t_admission->grup_ruang_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($t_admission->status_order_ibs->Visible) { // status_order_ibs ?>
	<tr id="r_status_order_ibs">
		<td><span id="elh_t_admission_status_order_ibs"><?php echo $t_admission->status_order_ibs->FldCaption() ?></span></td>
		<td data-name="status_order_ibs"<?php echo $t_admission->status_order_ibs->CellAttributes() ?>>
<span id="el_t_admission_status_order_ibs">
<span<?php echo $t_admission->status_order_ibs->ViewAttributes() ?>>
<?php echo $t_admission->status_order_ibs->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
ft_admissionview.Init();
</script>
<?php
$t_admission_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$t_admission_view->Page_Terminate();
?>
