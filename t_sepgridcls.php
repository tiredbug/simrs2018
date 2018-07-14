<?php include_once "t_sepinfo.php" ?>
<?php include_once "m_logininfo.php" ?>
<?php

//
// Page class
//

$t_sep_grid = NULL; // Initialize page object first

class ct_sep_grid extends ct_sep {

	// Page ID
	var $PageID = 'grid';

	// Project ID
	var $ProjectID = "{9EA43BBE-9546-4DFA-A9E1-2DE91AC35CAA}";

	// Table name
	var $TableName = 't_sep';

	// Page object name
	var $PageObjName = 't_sep_grid';

	// Grid form hidden field names
	var $FormName = 'ft_sepgrid';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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
		$this->FormActionName .= '_' . $this->FormName;
		$this->FormKeyName .= '_' . $this->FormName;
		$this->FormOldKeyName .= '_' . $this->FormName;
		$this->FormBlankRowName .= '_' . $this->FormName;
		$this->FormKeyCountName .= '_' . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (t_sep)
		if (!isset($GLOBALS["t_sep"]) || get_class($GLOBALS["t_sep"]) == "ct_sep") {
			$GLOBALS["t_sep"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["t_sep"];

		}
		$this->AddUrl = "t_sepadd.php";

		// Table object (m_login)
		if (!isset($GLOBALS['m_login'])) $GLOBALS['m_login'] = new cm_login();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->id->SetVisibility();
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->nomer_sep->SetVisibility();
		$this->nomr->SetVisibility();
		$this->no_kartubpjs->SetVisibility();
		$this->jenis_layanan->SetVisibility();
		$this->tgl_sep->SetVisibility();
		$this->poli_eksekutif->SetVisibility();
		$this->cob->SetVisibility();
		$this->penjamin_laka->SetVisibility();
		$this->no_telp->SetVisibility();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Setup other options
		$this->SetupOtherOptions();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url == "")
			return;
		$this->Page_Redirecting($url);

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $ShowOtherOptions = FALSE;
	var $DisplayRecs = 10;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 10; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "vw_list_pasien_rawat_jalan") {
			global $vw_list_pasien_rawat_jalan;
			$rsmaster = $vw_list_pasien_rawat_jalan->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("vw_list_pasien_rawat_jalanlist.php"); // Return to master page
			} else {
				$vw_list_pasien_rawat_jalan->LoadListRowValues($rsmaster);
				$vw_list_pasien_rawat_jalan->RowType = EW_ROWTYPE_MASTER; // Master row
				$vw_list_pasien_rawat_jalan->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
				$this->LoadOldRecord(); // Load old recordset
			}
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_nomer_sep") && $objForm->HasValue("o_nomer_sep") && $this->nomer_sep->CurrentValue <> $this->nomer_sep->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nomr") && $objForm->HasValue("o_nomr") && $this->nomr->CurrentValue <> $this->nomr->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_no_kartubpjs") && $objForm->HasValue("o_no_kartubpjs") && $this->no_kartubpjs->CurrentValue <> $this->no_kartubpjs->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_jenis_layanan") && $objForm->HasValue("o_jenis_layanan") && $this->jenis_layanan->CurrentValue <> $this->jenis_layanan->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_tgl_sep") && $objForm->HasValue("o_tgl_sep") && $this->tgl_sep->CurrentValue <> $this->tgl_sep->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_poli_eksekutif") && $objForm->HasValue("o_poli_eksekutif") && $this->poli_eksekutif->CurrentValue <> $this->poli_eksekutif->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_cob") && $objForm->HasValue("o_cob") && $this->cob->CurrentValue <> $this->cob->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_penjamin_laka") && $objForm->HasValue("o_penjamin_laka") && $this->penjamin_laka->CurrentValue <> $this->penjamin_laka->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_no_telp") && $objForm->HasValue("o_no_telp") && $this->no_telp->CurrentValue <> $this->no_telp->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idx->setSessionValue("");
				$this->nomr->setSessionValue("");
				$this->tgl_sep->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($objForm->HasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $OldKeyName . "\" id=\"" . $OldKeyName . "\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"btn btn-danger btn-xs\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . " Delete</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);
		if ($this->CurrentMode == "view") { // View mode
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('id');
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;
		$option->ButtonClass = ""; // Class for button group
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->Add("add");
			$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
			$item->Body = "<a class=\"line-2309\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . " $addcaption</a>";
			$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		}
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && $this->CurrentAction != "F") { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				$item = &$option->Add("addblankrow");
				$abrbuttontext = ew_HtmlTitle($Language->Phrase("AddBlankRow"));
				$item->Body = "<a class=\"btn btn-xs btn-success\" title=\"" . $abrbuttontext . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . " $abrbuttontext</a>";
				$item->Visible = $Security->CanAdd();
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = &$options["addedit"];
			$item = &$option->GetItem("add");
			$this->ShowOtherOptions = $item && $item->Visible;
		}
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load default values
	function LoadDefaultValues() {
		$this->id->CurrentValue = NULL;
		$this->id->OldValue = $this->id->CurrentValue;
		$this->nomer_sep->CurrentValue = NULL;
		$this->nomer_sep->OldValue = $this->nomer_sep->CurrentValue;
		$this->nomr->CurrentValue = NULL;
		$this->nomr->OldValue = $this->nomr->CurrentValue;
		$this->no_kartubpjs->CurrentValue = NULL;
		$this->no_kartubpjs->OldValue = $this->no_kartubpjs->CurrentValue;
		$this->jenis_layanan->CurrentValue = NULL;
		$this->jenis_layanan->OldValue = $this->jenis_layanan->CurrentValue;
		$this->tgl_sep->CurrentValue = NULL;
		$this->tgl_sep->OldValue = $this->tgl_sep->CurrentValue;
		$this->poli_eksekutif->CurrentValue = NULL;
		$this->poli_eksekutif->OldValue = $this->poli_eksekutif->CurrentValue;
		$this->cob->CurrentValue = NULL;
		$this->cob->OldValue = $this->cob->CurrentValue;
		$this->penjamin_laka->CurrentValue = NULL;
		$this->penjamin_laka->OldValue = $this->penjamin_laka->CurrentValue;
		$this->no_telp->CurrentValue = NULL;
		$this->no_telp->OldValue = $this->no_telp->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$objForm->FormName = $this->FormName;
		if (!$this->id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->nomer_sep->FldIsDetailKey) {
			$this->nomer_sep->setFormValue($objForm->GetValue("x_nomer_sep"));
		}
		$this->nomer_sep->setOldValue($objForm->GetValue("o_nomer_sep"));
		if (!$this->nomr->FldIsDetailKey) {
			$this->nomr->setFormValue($objForm->GetValue("x_nomr"));
		}
		$this->nomr->setOldValue($objForm->GetValue("o_nomr"));
		if (!$this->no_kartubpjs->FldIsDetailKey) {
			$this->no_kartubpjs->setFormValue($objForm->GetValue("x_no_kartubpjs"));
		}
		$this->no_kartubpjs->setOldValue($objForm->GetValue("o_no_kartubpjs"));
		if (!$this->jenis_layanan->FldIsDetailKey) {
			$this->jenis_layanan->setFormValue($objForm->GetValue("x_jenis_layanan"));
		}
		$this->jenis_layanan->setOldValue($objForm->GetValue("o_jenis_layanan"));
		if (!$this->tgl_sep->FldIsDetailKey) {
			$this->tgl_sep->setFormValue($objForm->GetValue("x_tgl_sep"));
			$this->tgl_sep->CurrentValue = ew_UnFormatDateTime($this->tgl_sep->CurrentValue, 0);
		}
		$this->tgl_sep->setOldValue($objForm->GetValue("o_tgl_sep"));
		if (!$this->poli_eksekutif->FldIsDetailKey) {
			$this->poli_eksekutif->setFormValue($objForm->GetValue("x_poli_eksekutif"));
		}
		$this->poli_eksekutif->setOldValue($objForm->GetValue("o_poli_eksekutif"));
		if (!$this->cob->FldIsDetailKey) {
			$this->cob->setFormValue($objForm->GetValue("x_cob"));
		}
		$this->cob->setOldValue($objForm->GetValue("o_cob"));
		if (!$this->penjamin_laka->FldIsDetailKey) {
			$this->penjamin_laka->setFormValue($objForm->GetValue("x_penjamin_laka"));
		}
		$this->penjamin_laka->setOldValue($objForm->GetValue("o_penjamin_laka"));
		if (!$this->no_telp->FldIsDetailKey) {
			$this->no_telp->setFormValue($objForm->GetValue("x_no_telp"));
		}
		$this->no_telp->setOldValue($objForm->GetValue("o_no_telp"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->id->CurrentValue = $this->id->FormValue;
		$this->nomer_sep->CurrentValue = $this->nomer_sep->FormValue;
		$this->nomr->CurrentValue = $this->nomr->FormValue;
		$this->no_kartubpjs->CurrentValue = $this->no_kartubpjs->FormValue;
		$this->jenis_layanan->CurrentValue = $this->jenis_layanan->FormValue;
		$this->tgl_sep->CurrentValue = $this->tgl_sep->FormValue;
		$this->tgl_sep->CurrentValue = ew_UnFormatDateTime($this->tgl_sep->CurrentValue, 0);
		$this->poli_eksekutif->CurrentValue = $this->poli_eksekutif->FormValue;
		$this->cob->CurrentValue = $this->cob->FormValue;
		$this->penjamin_laka->CurrentValue = $this->penjamin_laka->FormValue;
		$this->no_telp->CurrentValue = $this->no_telp->FormValue;
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
		$this->nomer_sep->setDbValue($rs->fields('nomer_sep'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->no_kartubpjs->setDbValue($rs->fields('no_kartubpjs'));
		$this->jenis_layanan->setDbValue($rs->fields('jenis_layanan'));
		$this->tgl_sep->setDbValue($rs->fields('tgl_sep'));
		$this->tgl_rujukan->setDbValue($rs->fields('tgl_rujukan'));
		$this->kelas_rawat->setDbValue($rs->fields('kelas_rawat'));
		$this->no_rujukan->setDbValue($rs->fields('no_rujukan'));
		$this->ppk_asal->setDbValue($rs->fields('ppk_asal'));
		$this->nama_ppk->setDbValue($rs->fields('nama_ppk'));
		$this->ppk_pelayanan->setDbValue($rs->fields('ppk_pelayanan'));
		$this->catatan->setDbValue($rs->fields('catatan'));
		$this->kode_diagnosaawal->setDbValue($rs->fields('kode_diagnosaawal'));
		$this->nama_diagnosaawal->setDbValue($rs->fields('nama_diagnosaawal'));
		$this->laka_lantas->setDbValue($rs->fields('laka_lantas'));
		$this->lokasi_laka->setDbValue($rs->fields('lokasi_laka'));
		$this->user->setDbValue($rs->fields('user'));
		$this->nik->setDbValue($rs->fields('nik'));
		$this->kode_politujuan->setDbValue($rs->fields('kode_politujuan'));
		$this->nama_politujuan->setDbValue($rs->fields('nama_politujuan'));
		$this->dpjp->setDbValue($rs->fields('dpjp'));
		$this->idx->setDbValue($rs->fields('idx'));
		$this->last_update->setDbValue($rs->fields('last_update'));
		$this->pasien_baru->setDbValue($rs->fields('pasien_baru'));
		$this->cara_bayar->setDbValue($rs->fields('cara_bayar'));
		$this->petugas_klaim->setDbValue($rs->fields('petugas_klaim'));
		$this->total_biaya_rs->setDbValue($rs->fields('total_biaya_rs'));
		$this->total_biaya_rs_adjust->setDbValue($rs->fields('total_biaya_rs_adjust'));
		$this->tgl_pulang->setDbValue($rs->fields('tgl_pulang'));
		$this->flag_proc->setDbValue($rs->fields('flag_proc'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->cob->setDbValue($rs->fields('cob'));
		$this->penjamin_laka->setDbValue($rs->fields('penjamin_laka'));
		$this->no_telp->setDbValue($rs->fields('no_telp'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->nomer_sep->DbValue = $row['nomer_sep'];
		$this->nomr->DbValue = $row['nomr'];
		$this->no_kartubpjs->DbValue = $row['no_kartubpjs'];
		$this->jenis_layanan->DbValue = $row['jenis_layanan'];
		$this->tgl_sep->DbValue = $row['tgl_sep'];
		$this->tgl_rujukan->DbValue = $row['tgl_rujukan'];
		$this->kelas_rawat->DbValue = $row['kelas_rawat'];
		$this->no_rujukan->DbValue = $row['no_rujukan'];
		$this->ppk_asal->DbValue = $row['ppk_asal'];
		$this->nama_ppk->DbValue = $row['nama_ppk'];
		$this->ppk_pelayanan->DbValue = $row['ppk_pelayanan'];
		$this->catatan->DbValue = $row['catatan'];
		$this->kode_diagnosaawal->DbValue = $row['kode_diagnosaawal'];
		$this->nama_diagnosaawal->DbValue = $row['nama_diagnosaawal'];
		$this->laka_lantas->DbValue = $row['laka_lantas'];
		$this->lokasi_laka->DbValue = $row['lokasi_laka'];
		$this->user->DbValue = $row['user'];
		$this->nik->DbValue = $row['nik'];
		$this->kode_politujuan->DbValue = $row['kode_politujuan'];
		$this->nama_politujuan->DbValue = $row['nama_politujuan'];
		$this->dpjp->DbValue = $row['dpjp'];
		$this->idx->DbValue = $row['idx'];
		$this->last_update->DbValue = $row['last_update'];
		$this->pasien_baru->DbValue = $row['pasien_baru'];
		$this->cara_bayar->DbValue = $row['cara_bayar'];
		$this->petugas_klaim->DbValue = $row['petugas_klaim'];
		$this->total_biaya_rs->DbValue = $row['total_biaya_rs'];
		$this->total_biaya_rs_adjust->DbValue = $row['total_biaya_rs_adjust'];
		$this->tgl_pulang->DbValue = $row['tgl_pulang'];
		$this->flag_proc->DbValue = $row['flag_proc'];
		$this->poli_eksekutif->DbValue = $row['poli_eksekutif'];
		$this->cob->DbValue = $row['cob'];
		$this->penjamin_laka->DbValue = $row['penjamin_laka'];
		$this->no_telp->DbValue = $row['no_telp'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->id->CurrentValue = strval($arKeys[0]); // id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// nomer_sep
			$this->nomer_sep->LinkCustomAttributes = "";
			$this->nomer_sep->HrefValue = "";
			$this->nomer_sep->TooltipValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";
			$this->nomr->TooltipValue = "";

			// no_kartubpjs
			$this->no_kartubpjs->LinkCustomAttributes = "";
			$this->no_kartubpjs->HrefValue = "";
			$this->no_kartubpjs->TooltipValue = "";

			// jenis_layanan
			$this->jenis_layanan->LinkCustomAttributes = "";
			$this->jenis_layanan->HrefValue = "";
			$this->jenis_layanan->TooltipValue = "";

			// tgl_sep
			$this->tgl_sep->LinkCustomAttributes = "";
			$this->tgl_sep->HrefValue = "";
			$this->tgl_sep->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// id
			// nomer_sep

			$this->nomer_sep->EditAttrs["class"] = "form-control";
			$this->nomer_sep->EditCustomAttributes = "";
			$this->nomer_sep->EditValue = ew_HtmlEncode($this->nomer_sep->CurrentValue);
			$this->nomer_sep->PlaceHolder = ew_RemoveHtml($this->nomer_sep->FldCaption());

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			if ($this->nomr->getSessionValue() <> "") {
				$this->nomr->CurrentValue = $this->nomr->getSessionValue();
				$this->nomr->OldValue = $this->nomr->CurrentValue;
			$this->nomr->ViewValue = $this->nomr->CurrentValue;
			$this->nomr->ViewCustomAttributes = "";
			} else {
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
			$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());
			}

			// no_kartubpjs
			$this->no_kartubpjs->EditAttrs["class"] = "form-control";
			$this->no_kartubpjs->EditCustomAttributes = "";
			$this->no_kartubpjs->EditValue = ew_HtmlEncode($this->no_kartubpjs->CurrentValue);
			$this->no_kartubpjs->PlaceHolder = ew_RemoveHtml($this->no_kartubpjs->FldCaption());

			// jenis_layanan
			$this->jenis_layanan->EditCustomAttributes = "";
			$this->jenis_layanan->EditValue = $this->jenis_layanan->Options(FALSE);

			// tgl_sep
			$this->tgl_sep->EditAttrs["class"] = "form-control";
			$this->tgl_sep->EditCustomAttributes = "";
			if ($this->tgl_sep->getSessionValue() <> "") {
				$this->tgl_sep->CurrentValue = $this->tgl_sep->getSessionValue();
				$this->tgl_sep->OldValue = $this->tgl_sep->CurrentValue;
			$this->tgl_sep->ViewValue = $this->tgl_sep->CurrentValue;
			$this->tgl_sep->ViewValue = ew_FormatDateTime($this->tgl_sep->ViewValue, 0);
			$this->tgl_sep->ViewCustomAttributes = "";
			} else {
			$this->tgl_sep->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sep->CurrentValue, 8));
			$this->tgl_sep->PlaceHolder = ew_RemoveHtml($this->tgl_sep->FldCaption());
			}

			// poli_eksekutif
			$this->poli_eksekutif->EditAttrs["class"] = "form-control";
			$this->poli_eksekutif->EditCustomAttributes = "";
			$this->poli_eksekutif->EditValue = ew_HtmlEncode($this->poli_eksekutif->CurrentValue);
			$this->poli_eksekutif->PlaceHolder = ew_RemoveHtml($this->poli_eksekutif->FldCaption());

			// cob
			$this->cob->EditAttrs["class"] = "form-control";
			$this->cob->EditCustomAttributes = "";
			$this->cob->EditValue = ew_HtmlEncode($this->cob->CurrentValue);
			$this->cob->PlaceHolder = ew_RemoveHtml($this->cob->FldCaption());

			// penjamin_laka
			$this->penjamin_laka->EditAttrs["class"] = "form-control";
			$this->penjamin_laka->EditCustomAttributes = "";
			$this->penjamin_laka->EditValue = ew_HtmlEncode($this->penjamin_laka->CurrentValue);
			$this->penjamin_laka->PlaceHolder = ew_RemoveHtml($this->penjamin_laka->FldCaption());

			// no_telp
			$this->no_telp->EditAttrs["class"] = "form-control";
			$this->no_telp->EditCustomAttributes = "";
			$this->no_telp->EditValue = ew_HtmlEncode($this->no_telp->CurrentValue);
			$this->no_telp->PlaceHolder = ew_RemoveHtml($this->no_telp->FldCaption());

			// Add refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// nomer_sep
			$this->nomer_sep->LinkCustomAttributes = "";
			$this->nomer_sep->HrefValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";

			// no_kartubpjs
			$this->no_kartubpjs->LinkCustomAttributes = "";
			$this->no_kartubpjs->HrefValue = "";

			// jenis_layanan
			$this->jenis_layanan->LinkCustomAttributes = "";
			$this->jenis_layanan->HrefValue = "";

			// tgl_sep
			$this->tgl_sep->LinkCustomAttributes = "";
			$this->tgl_sep->HrefValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";

			// cob
			$this->cob->LinkCustomAttributes = "";
			$this->cob->HrefValue = "";

			// penjamin_laka
			$this->penjamin_laka->LinkCustomAttributes = "";
			$this->penjamin_laka->HrefValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// nomer_sep
			$this->nomer_sep->EditAttrs["class"] = "form-control";
			$this->nomer_sep->EditCustomAttributes = "";
			$this->nomer_sep->EditValue = ew_HtmlEncode($this->nomer_sep->CurrentValue);
			$this->nomer_sep->PlaceHolder = ew_RemoveHtml($this->nomer_sep->FldCaption());

			// nomr
			$this->nomr->EditAttrs["class"] = "form-control";
			$this->nomr->EditCustomAttributes = "";
			if ($this->nomr->getSessionValue() <> "") {
				$this->nomr->CurrentValue = $this->nomr->getSessionValue();
				$this->nomr->OldValue = $this->nomr->CurrentValue;
			$this->nomr->ViewValue = $this->nomr->CurrentValue;
			$this->nomr->ViewCustomAttributes = "";
			} else {
			$this->nomr->EditValue = ew_HtmlEncode($this->nomr->CurrentValue);
			$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());
			}

			// no_kartubpjs
			$this->no_kartubpjs->EditAttrs["class"] = "form-control";
			$this->no_kartubpjs->EditCustomAttributes = "";
			$this->no_kartubpjs->EditValue = ew_HtmlEncode($this->no_kartubpjs->CurrentValue);
			$this->no_kartubpjs->PlaceHolder = ew_RemoveHtml($this->no_kartubpjs->FldCaption());

			// jenis_layanan
			$this->jenis_layanan->EditCustomAttributes = "";
			$this->jenis_layanan->EditValue = $this->jenis_layanan->Options(FALSE);

			// tgl_sep
			$this->tgl_sep->EditAttrs["class"] = "form-control";
			$this->tgl_sep->EditCustomAttributes = "";
			if ($this->tgl_sep->getSessionValue() <> "") {
				$this->tgl_sep->CurrentValue = $this->tgl_sep->getSessionValue();
				$this->tgl_sep->OldValue = $this->tgl_sep->CurrentValue;
			$this->tgl_sep->ViewValue = $this->tgl_sep->CurrentValue;
			$this->tgl_sep->ViewValue = ew_FormatDateTime($this->tgl_sep->ViewValue, 0);
			$this->tgl_sep->ViewCustomAttributes = "";
			} else {
			$this->tgl_sep->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->tgl_sep->CurrentValue, 8));
			$this->tgl_sep->PlaceHolder = ew_RemoveHtml($this->tgl_sep->FldCaption());
			}

			// poli_eksekutif
			$this->poli_eksekutif->EditAttrs["class"] = "form-control";
			$this->poli_eksekutif->EditCustomAttributes = "";
			$this->poli_eksekutif->EditValue = ew_HtmlEncode($this->poli_eksekutif->CurrentValue);
			$this->poli_eksekutif->PlaceHolder = ew_RemoveHtml($this->poli_eksekutif->FldCaption());

			// cob
			$this->cob->EditAttrs["class"] = "form-control";
			$this->cob->EditCustomAttributes = "";
			$this->cob->EditValue = ew_HtmlEncode($this->cob->CurrentValue);
			$this->cob->PlaceHolder = ew_RemoveHtml($this->cob->FldCaption());

			// penjamin_laka
			$this->penjamin_laka->EditAttrs["class"] = "form-control";
			$this->penjamin_laka->EditCustomAttributes = "";
			$this->penjamin_laka->EditValue = ew_HtmlEncode($this->penjamin_laka->CurrentValue);
			$this->penjamin_laka->PlaceHolder = ew_RemoveHtml($this->penjamin_laka->FldCaption());

			// no_telp
			$this->no_telp->EditAttrs["class"] = "form-control";
			$this->no_telp->EditCustomAttributes = "";
			$this->no_telp->EditValue = ew_HtmlEncode($this->no_telp->CurrentValue);
			$this->no_telp->PlaceHolder = ew_RemoveHtml($this->no_telp->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// nomer_sep
			$this->nomer_sep->LinkCustomAttributes = "";
			$this->nomer_sep->HrefValue = "";

			// nomr
			$this->nomr->LinkCustomAttributes = "";
			$this->nomr->HrefValue = "";

			// no_kartubpjs
			$this->no_kartubpjs->LinkCustomAttributes = "";
			$this->no_kartubpjs->HrefValue = "";

			// jenis_layanan
			$this->jenis_layanan->LinkCustomAttributes = "";
			$this->jenis_layanan->HrefValue = "";

			// tgl_sep
			$this->tgl_sep->LinkCustomAttributes = "";
			$this->tgl_sep->HrefValue = "";

			// poli_eksekutif
			$this->poli_eksekutif->LinkCustomAttributes = "";
			$this->poli_eksekutif->HrefValue = "";

			// cob
			$this->cob->LinkCustomAttributes = "";
			$this->cob->HrefValue = "";

			// penjamin_laka
			$this->penjamin_laka->LinkCustomAttributes = "";
			$this->penjamin_laka->HrefValue = "";

			// no_telp
			$this->no_telp->LinkCustomAttributes = "";
			$this->no_telp->HrefValue = "";
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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckDateDef($this->tgl_sep->FormValue)) {
			ew_AddMessage($gsFormError, $this->tgl_sep->FldErrMsg());
		}
		if (!ew_CheckInteger($this->poli_eksekutif->FormValue)) {
			ew_AddMessage($gsFormError, $this->poli_eksekutif->FldErrMsg());
		}
		if (!ew_CheckInteger($this->cob->FormValue)) {
			ew_AddMessage($gsFormError, $this->cob->FldErrMsg());
		}
		if (!ew_CheckInteger($this->penjamin_laka->FormValue)) {
			ew_AddMessage($gsFormError, $this->penjamin_laka->FldErrMsg());
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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// nomer_sep
			$this->nomer_sep->SetDbValueDef($rsnew, $this->nomer_sep->CurrentValue, NULL, $this->nomer_sep->ReadOnly);

			// nomr
			$this->nomr->SetDbValueDef($rsnew, $this->nomr->CurrentValue, NULL, $this->nomr->ReadOnly);

			// no_kartubpjs
			$this->no_kartubpjs->SetDbValueDef($rsnew, $this->no_kartubpjs->CurrentValue, NULL, $this->no_kartubpjs->ReadOnly);

			// jenis_layanan
			$this->jenis_layanan->SetDbValueDef($rsnew, $this->jenis_layanan->CurrentValue, NULL, $this->jenis_layanan->ReadOnly);

			// tgl_sep
			$this->tgl_sep->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sep->CurrentValue, 0), NULL, $this->tgl_sep->ReadOnly);

			// poli_eksekutif
			$this->poli_eksekutif->SetDbValueDef($rsnew, $this->poli_eksekutif->CurrentValue, NULL, $this->poli_eksekutif->ReadOnly);

			// cob
			$this->cob->SetDbValueDef($rsnew, $this->cob->CurrentValue, NULL, $this->cob->ReadOnly);

			// penjamin_laka
			$this->penjamin_laka->SetDbValueDef($rsnew, $this->penjamin_laka->CurrentValue, NULL, $this->penjamin_laka->ReadOnly);

			// no_telp
			$this->no_telp->SetDbValueDef($rsnew, $this->no_telp->CurrentValue, NULL, $this->no_telp->ReadOnly);

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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "vw_list_pasien_rawat_jalan") {
				$this->idx->CurrentValue = $this->idx->getSessionValue();
				$this->nomr->CurrentValue = $this->nomr->getSessionValue();
				$this->tgl_sep->CurrentValue = $this->tgl_sep->getSessionValue();
			}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// nomer_sep
		$this->nomer_sep->SetDbValueDef($rsnew, $this->nomer_sep->CurrentValue, NULL, FALSE);

		// nomr
		$this->nomr->SetDbValueDef($rsnew, $this->nomr->CurrentValue, NULL, FALSE);

		// no_kartubpjs
		$this->no_kartubpjs->SetDbValueDef($rsnew, $this->no_kartubpjs->CurrentValue, NULL, FALSE);

		// jenis_layanan
		$this->jenis_layanan->SetDbValueDef($rsnew, $this->jenis_layanan->CurrentValue, NULL, FALSE);

		// tgl_sep
		$this->tgl_sep->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->tgl_sep->CurrentValue, 0), NULL, FALSE);

		// poli_eksekutif
		$this->poli_eksekutif->SetDbValueDef($rsnew, $this->poli_eksekutif->CurrentValue, NULL, FALSE);

		// cob
		$this->cob->SetDbValueDef($rsnew, $this->cob->CurrentValue, NULL, FALSE);

		// penjamin_laka
		$this->penjamin_laka->SetDbValueDef($rsnew, $this->penjamin_laka->CurrentValue, NULL, FALSE);

		// no_telp
		$this->no_telp->SetDbValueDef($rsnew, $this->no_telp->CurrentValue, NULL, FALSE);

		// idx
		if ($this->idx->getSessionValue() <> "") {
			$rsnew['idx'] = $this->idx->getSessionValue();
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

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "vw_list_pasien_rawat_jalan") {
			$this->idx->Visible = FALSE;
			if ($GLOBALS["vw_list_pasien_rawat_jalan"]->EventCancelled) $this->EventCancelled = TRUE;
			$this->nomr->Visible = FALSE;
			if ($GLOBALS["vw_list_pasien_rawat_jalan"]->EventCancelled) $this->EventCancelled = TRUE;
			$this->tgl_sep->Visible = FALSE;
			if ($GLOBALS["vw_list_pasien_rawat_jalan"]->EventCancelled) $this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
