<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "vw_sensus_harian_rawat_jalaninfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$vw_sensus_harian_rawat_jalan_search = NULL; // Initialize page object first

class cvw_sensus_harian_rawat_jalan_search extends cvw_sensus_harian_rawat_jalan {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 'vw_sensus_harian_rawat_jalan';

	// Page object name
	var $PageObjName = 'vw_sensus_harian_rawat_jalan_search';

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

		// Table object (vw_sensus_harian_rawat_jalan)
		if (!isset($GLOBALS["vw_sensus_harian_rawat_jalan"]) || get_class($GLOBALS["vw_sensus_harian_rawat_jalan"]) == "cvw_sensus_harian_rawat_jalan") {
			$GLOBALS["vw_sensus_harian_rawat_jalan"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["vw_sensus_harian_rawat_jalan"];
		}

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'vw_sensus_harian_rawat_jalan', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("vw_sensus_harian_rawat_jalanlist.php"));
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
		$this->KDPOLY->SetVisibility();
		$this->NO_SJP->SetVisibility();

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
		global $EW_EXPORT, $vw_sensus_harian_rawat_jalan;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($vw_sensus_harian_rawat_jalan);
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
						$sSrchStr = "vw_sensus_harian_rawat_jalanlist.php" . "?" . $sSrchStr;
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
		$this->BuildSearchUrl($sSrchUrl, $this->KDPOLY); // KDPOLY
		$this->BuildSearchUrl($sSrchUrl, $this->NO_SJP); // NO_SJP
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

		// KDPOLY
		$this->KDPOLY->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_KDPOLY"));
		$this->KDPOLY->AdvancedSearch->SearchOperator = $objForm->GetValue("z_KDPOLY");

		// NO_SJP
		$this->NO_SJP->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_NO_SJP"));
		$this->NO_SJP->AdvancedSearch->SearchOperator = $objForm->GetValue("z_NO_SJP");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// IDXDAFTAR
		// NOMR
		// TGLREG
		// KDDOKTER
		// KDPOLY
		// KDRUJUK
		// KDCARABAYAR
		// SHIFT
		// STATUS
		// PASIENBARU
		// KETRUJUK
		// NO_SJP

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// IDXDAFTAR
		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDDOKTER
		$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
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
		$this->KDRUJUK->ViewCustomAttributes = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// SHIFT
		$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
		$this->SHIFT->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// PASIENBARU
		$this->PASIENBARU->ViewValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->ViewCustomAttributes = "";

		// KETRUJUK
		$this->KETRUJUK->ViewValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

			// TGLREG
			$this->TGLREG->LinkCustomAttributes = "";
			$this->TGLREG->HrefValue = "";
			$this->TGLREG->TooltipValue = "";

			// KDPOLY
			$this->KDPOLY->LinkCustomAttributes = "";
			$this->KDPOLY->HrefValue = "";
			$this->KDPOLY->TooltipValue = "";

			// NO_SJP
			$this->NO_SJP->LinkCustomAttributes = "";
			$this->NO_SJP->HrefValue = "";
			$this->NO_SJP->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// TGLREG
			$this->TGLREG->EditAttrs["class"] = "form-control";
			$this->TGLREG->EditCustomAttributes = "";
			$this->TGLREG->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->TGLREG->AdvancedSearch->SearchValue, 0), 8));
			$this->TGLREG->PlaceHolder = ew_RemoveHtml($this->TGLREG->FldCaption());

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

			// NO_SJP
			$this->NO_SJP->EditAttrs["class"] = "form-control";
			$this->NO_SJP->EditCustomAttributes = "";
			$this->NO_SJP->EditValue = ew_HtmlEncode($this->NO_SJP->AdvancedSearch->SearchValue);
			$this->NO_SJP->PlaceHolder = ew_RemoveHtml($this->NO_SJP->FldCaption());
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
		if (!ew_CheckDateDef($this->TGLREG->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->TGLREG->FldErrMsg());
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
		$this->KDPOLY->AdvancedSearch->Load();
		$this->NO_SJP->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("vw_sensus_harian_rawat_jalanlist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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
if (!isset($vw_sensus_harian_rawat_jalan_search)) $vw_sensus_harian_rawat_jalan_search = new cvw_sensus_harian_rawat_jalan_search();

// Page init
$vw_sensus_harian_rawat_jalan_search->Page_Init();

// Page main
$vw_sensus_harian_rawat_jalan_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$vw_sensus_harian_rawat_jalan_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($vw_sensus_harian_rawat_jalan_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fvw_sensus_harian_rawat_jalansearch = new ew_Form("fvw_sensus_harian_rawat_jalansearch", "search");
<?php } else { ?>
var CurrentForm = fvw_sensus_harian_rawat_jalansearch = new ew_Form("fvw_sensus_harian_rawat_jalansearch", "search");
<?php } ?>

// Form_CustomValidate event
fvw_sensus_harian_rawat_jalansearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fvw_sensus_harian_rawat_jalansearch.ValidateRequired = true;
<?php } else { ?>
fvw_sensus_harian_rawat_jalansearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fvw_sensus_harian_rawat_jalansearch.Lists["x_KDPOLY"] = {"LinkField":"x_kode","Ajax":true,"AutoFill":false,"DisplayFields":["x_nama","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"m_poly"};

// Form object for search
// Validate function for search

fvw_sensus_harian_rawat_jalansearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_TGLREG");
	if (elm && !ew_CheckDateDef(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($vw_sensus_harian_rawat_jalan->TGLREG->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$vw_sensus_harian_rawat_jalan_search->IsModal) { ?>
<?php } ?>
<?php $vw_sensus_harian_rawat_jalan_search->ShowPageHeader(); ?>
<?php
$vw_sensus_harian_rawat_jalan_search->ShowMessage();
?>
<form name="fvw_sensus_harian_rawat_jalansearch" id="fvw_sensus_harian_rawat_jalansearch" class="<?php echo $vw_sensus_harian_rawat_jalan_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($vw_sensus_harian_rawat_jalan_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $vw_sensus_harian_rawat_jalan_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="vw_sensus_harian_rawat_jalan">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($vw_sensus_harian_rawat_jalan_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($vw_sensus_harian_rawat_jalan->TGLREG->Visible) { // TGLREG ?>
	<div id="r_TGLREG" class="form-group">
		<label for="x_TGLREG" class="<?php echo $vw_sensus_harian_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_sensus_harian_rawat_jalan_TGLREG"><?php echo $vw_sensus_harian_rawat_jalan->TGLREG->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_TGLREG" id="z_TGLREG" value="="></p>
		</label>
		<div class="<?php echo $vw_sensus_harian_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_sensus_harian_rawat_jalan->TGLREG->CellAttributes() ?>>
			<span id="el_vw_sensus_harian_rawat_jalan_TGLREG">
<input type="text" data-table="vw_sensus_harian_rawat_jalan" data-field="x_TGLREG" name="x_TGLREG" id="x_TGLREG" placeholder="<?php echo ew_HtmlEncode($vw_sensus_harian_rawat_jalan->TGLREG->getPlaceHolder()) ?>" value="<?php echo $vw_sensus_harian_rawat_jalan->TGLREG->EditValue ?>"<?php echo $vw_sensus_harian_rawat_jalan->TGLREG->EditAttributes() ?>>
<?php if (!$vw_sensus_harian_rawat_jalan->TGLREG->ReadOnly && !$vw_sensus_harian_rawat_jalan->TGLREG->Disabled && !isset($vw_sensus_harian_rawat_jalan->TGLREG->EditAttrs["readonly"]) && !isset($vw_sensus_harian_rawat_jalan->TGLREG->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fvw_sensus_harian_rawat_jalansearch", "x_TGLREG", 0);
</script>
<?php } ?>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($vw_sensus_harian_rawat_jalan->KDPOLY->Visible) { // KDPOLY ?>
	<div id="r_KDPOLY" class="form-group">
		<label for="x_KDPOLY" class="<?php echo $vw_sensus_harian_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_sensus_harian_rawat_jalan_KDPOLY"><?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_KDPOLY" id="z_KDPOLY" value="="></p>
		</label>
		<div class="<?php echo $vw_sensus_harian_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->CellAttributes() ?>>
			<span id="el_vw_sensus_harian_rawat_jalan_KDPOLY">
<select data-table="vw_sensus_harian_rawat_jalan" data-field="x_KDPOLY" data-value-separator="<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->DisplayValueSeparatorAttribute() ?>" id="x_KDPOLY" name="x_KDPOLY"<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->EditAttributes() ?>>
<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->SelectOptionListHtml("x_KDPOLY") ?>
</select>
<input type="hidden" name="s_x_KDPOLY" id="s_x_KDPOLY" value="<?php echo $vw_sensus_harian_rawat_jalan->KDPOLY->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($vw_sensus_harian_rawat_jalan->NO_SJP->Visible) { // NO_SJP ?>
	<div id="r_NO_SJP" class="form-group">
		<label for="x_NO_SJP" class="<?php echo $vw_sensus_harian_rawat_jalan_search->SearchLabelClass ?>"><span id="elh_vw_sensus_harian_rawat_jalan_NO_SJP"><?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_NO_SJP" id="z_NO_SJP" value="LIKE"></p>
		</label>
		<div class="<?php echo $vw_sensus_harian_rawat_jalan_search->SearchRightColumnClass ?>"><div<?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->CellAttributes() ?>>
			<span id="el_vw_sensus_harian_rawat_jalan_NO_SJP">
<input type="text" data-table="vw_sensus_harian_rawat_jalan" data-field="x_NO_SJP" name="x_NO_SJP" id="x_NO_SJP" size="30" maxlength="25" placeholder="<?php echo ew_HtmlEncode($vw_sensus_harian_rawat_jalan->NO_SJP->getPlaceHolder()) ?>" value="<?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->EditValue ?>"<?php echo $vw_sensus_harian_rawat_jalan->NO_SJP->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$vw_sensus_harian_rawat_jalan_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fvw_sensus_harian_rawat_jalansearch.Init();
</script>
<?php
$vw_sensus_harian_rawat_jalan_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$vw_sensus_harian_rawat_jalan_search->Page_Terminate();
?>
