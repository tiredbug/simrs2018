<?php

// Global variable for table object
$budget = NULL;

//
// Table class for budget
//
class cbudget extends cTable {
	var $kodkeg;
	var $kegiatan;
	var $kel1;
	var $kel2;
	var $kel3;
	var $kel4;
	var $nama;
	var $nama1;
	var $tw1;
	var $tw2;
	var $tw3;
	var $tw4;
	var $so;
	var $tri;
	var $lap;
	var $rek;
	var $rek1;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'budget';
		$this->TableName = 'budget';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`budget`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// kodkeg
		$this->kodkeg = new cField('budget', 'budget', 'x_kodkeg', 'kodkeg', '`kodkeg`', '`kodkeg`', 200, -1, FALSE, '`kodkeg`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kodkeg->Sortable = TRUE; // Allow sort
		$this->fields['kodkeg'] = &$this->kodkeg;

		// kegiatan
		$this->kegiatan = new cField('budget', 'budget', 'x_kegiatan', 'kegiatan', '`kegiatan`', '`kegiatan`', 200, -1, FALSE, '`kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kegiatan->Sortable = TRUE; // Allow sort
		$this->fields['kegiatan'] = &$this->kegiatan;

		// kel1
		$this->kel1 = new cField('budget', 'budget', 'x_kel1', 'kel1', '`kel1`', '`kel1`', 200, -1, FALSE, '`kel1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel1->Sortable = TRUE; // Allow sort
		$this->fields['kel1'] = &$this->kel1;

		// kel2
		$this->kel2 = new cField('budget', 'budget', 'x_kel2', 'kel2', '`kel2`', '`kel2`', 200, -1, FALSE, '`kel2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel2->Sortable = TRUE; // Allow sort
		$this->fields['kel2'] = &$this->kel2;

		// kel3
		$this->kel3 = new cField('budget', 'budget', 'x_kel3', 'kel3', '`kel3`', '`kel3`', 200, -1, FALSE, '`kel3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel3->Sortable = TRUE; // Allow sort
		$this->fields['kel3'] = &$this->kel3;

		// kel4
		$this->kel4 = new cField('budget', 'budget', 'x_kel4', 'kel4', '`kel4`', '`kel4`', 200, -1, FALSE, '`kel4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel4->Sortable = TRUE; // Allow sort
		$this->fields['kel4'] = &$this->kel4;

		// nama
		$this->nama = new cField('budget', 'budget', 'x_nama', 'nama', '`nama`', '`nama`', 200, -1, FALSE, '`nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama->Sortable = TRUE; // Allow sort
		$this->fields['nama'] = &$this->nama;

		// nama1
		$this->nama1 = new cField('budget', 'budget', 'x_nama1', 'nama1', '`nama1`', '`nama1`', 200, -1, FALSE, '`nama1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama1->Sortable = TRUE; // Allow sort
		$this->fields['nama1'] = &$this->nama1;

		// tw1
		$this->tw1 = new cField('budget', 'budget', 'x_tw1', 'tw1', '`tw1`', '`tw1`', 20, -1, FALSE, '`tw1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tw1->Sortable = TRUE; // Allow sort
		$this->tw1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tw1'] = &$this->tw1;

		// tw2
		$this->tw2 = new cField('budget', 'budget', 'x_tw2', 'tw2', '`tw2`', '`tw2`', 20, -1, FALSE, '`tw2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tw2->Sortable = TRUE; // Allow sort
		$this->tw2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tw2'] = &$this->tw2;

		// tw3
		$this->tw3 = new cField('budget', 'budget', 'x_tw3', 'tw3', '`tw3`', '`tw3`', 20, -1, FALSE, '`tw3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tw3->Sortable = TRUE; // Allow sort
		$this->tw3->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tw3'] = &$this->tw3;

		// tw4
		$this->tw4 = new cField('budget', 'budget', 'x_tw4', 'tw4', '`tw4`', '`tw4`', 20, -1, FALSE, '`tw4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tw4->Sortable = TRUE; // Allow sort
		$this->tw4->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tw4'] = &$this->tw4;

		// so
		$this->so = new cField('budget', 'budget', 'x_so', 'so', '`so`', '`so`', 20, -1, FALSE, '`so`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->so->Sortable = TRUE; // Allow sort
		$this->so->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['so'] = &$this->so;

		// tri
		$this->tri = new cField('budget', 'budget', 'x_tri', 'tri', '`tri`', '`tri`', 200, -1, FALSE, '`tri`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tri->Sortable = TRUE; // Allow sort
		$this->fields['tri'] = &$this->tri;

		// lap
		$this->lap = new cField('budget', 'budget', 'x_lap', 'lap', '`lap`', '`lap`', 20, -1, FALSE, '`lap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lap->Sortable = TRUE; // Allow sort
		$this->lap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lap'] = &$this->lap;

		// rek
		$this->rek = new cField('budget', 'budget', 'x_rek', 'rek', '`rek`', '`rek`', 200, -1, FALSE, '`rek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rek->Sortable = TRUE; // Allow sort
		$this->fields['rek'] = &$this->rek;

		// rek1
		$this->rek1 = new cField('budget', 'budget', 'x_rek1', 'rek1', '`rek1`', '`rek1`', 200, -1, FALSE, '`rek1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rek1->Sortable = TRUE; // Allow sort
		$this->fields['rek1'] = &$this->rek1;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			if ($ctrl) {
				$sOrderBy = $this->getSessionOrderBy();
				if (strpos($sOrderBy, $sSortField . " " . $sLastSort) !== FALSE) {
					$sOrderBy = str_replace($sSortField . " " . $sLastSort, $sSortField . " " . $sThisSort, $sOrderBy);
				} else {
					if ($sOrderBy <> "") $sOrderBy .= ", ";
					$sOrderBy .= $sSortField . " " . $sThisSort;
				}
				$this->setSessionOrderBy($sOrderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
			}
		} else {
			if (!$ctrl) $ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`budget`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "budgetlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "budgetlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("budgetview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("budgetview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "budgetadd.php?" . $this->UrlParm($parm);
		else
			$url = "budgetadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("budgetedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("budgetadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("budgetdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->kodkeg->setDbValue($rs->fields('kodkeg'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->kel1->setDbValue($rs->fields('kel1'));
		$this->kel2->setDbValue($rs->fields('kel2'));
		$this->kel3->setDbValue($rs->fields('kel3'));
		$this->kel4->setDbValue($rs->fields('kel4'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->nama1->setDbValue($rs->fields('nama1'));
		$this->tw1->setDbValue($rs->fields('tw1'));
		$this->tw2->setDbValue($rs->fields('tw2'));
		$this->tw3->setDbValue($rs->fields('tw3'));
		$this->tw4->setDbValue($rs->fields('tw4'));
		$this->so->setDbValue($rs->fields('so'));
		$this->tri->setDbValue($rs->fields('tri'));
		$this->lap->setDbValue($rs->fields('lap'));
		$this->rek->setDbValue($rs->fields('rek'));
		$this->rek1->setDbValue($rs->fields('rek1'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// kodkeg
		// kegiatan
		// kel1
		// kel2
		// kel3
		// kel4
		// nama
		// nama1
		// tw1
		// tw2
		// tw3
		// tw4
		// so
		// tri
		// lap
		// rek
		// rek1
		// kodkeg

		$this->kodkeg->ViewValue = $this->kodkeg->CurrentValue;
		$this->kodkeg->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// kel1
		$this->kel1->ViewValue = $this->kel1->CurrentValue;
		$this->kel1->ViewCustomAttributes = "";

		// kel2
		$this->kel2->ViewValue = $this->kel2->CurrentValue;
		$this->kel2->ViewCustomAttributes = "";

		// kel3
		$this->kel3->ViewValue = $this->kel3->CurrentValue;
		$this->kel3->ViewCustomAttributes = "";

		// kel4
		$this->kel4->ViewValue = $this->kel4->CurrentValue;
		$this->kel4->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// nama1
		$this->nama1->ViewValue = $this->nama1->CurrentValue;
		$this->nama1->ViewCustomAttributes = "";

		// tw1
		$this->tw1->ViewValue = $this->tw1->CurrentValue;
		$this->tw1->ViewCustomAttributes = "";

		// tw2
		$this->tw2->ViewValue = $this->tw2->CurrentValue;
		$this->tw2->ViewCustomAttributes = "";

		// tw3
		$this->tw3->ViewValue = $this->tw3->CurrentValue;
		$this->tw3->ViewCustomAttributes = "";

		// tw4
		$this->tw4->ViewValue = $this->tw4->CurrentValue;
		$this->tw4->ViewCustomAttributes = "";

		// so
		$this->so->ViewValue = $this->so->CurrentValue;
		$this->so->ViewCustomAttributes = "";

		// tri
		$this->tri->ViewValue = $this->tri->CurrentValue;
		$this->tri->ViewCustomAttributes = "";

		// lap
		$this->lap->ViewValue = $this->lap->CurrentValue;
		$this->lap->ViewCustomAttributes = "";

		// rek
		$this->rek->ViewValue = $this->rek->CurrentValue;
		$this->rek->ViewCustomAttributes = "";

		// rek1
		$this->rek1->ViewValue = $this->rek1->CurrentValue;
		$this->rek1->ViewCustomAttributes = "";

		// kodkeg
		$this->kodkeg->LinkCustomAttributes = "";
		$this->kodkeg->HrefValue = "";
		$this->kodkeg->TooltipValue = "";

		// kegiatan
		$this->kegiatan->LinkCustomAttributes = "";
		$this->kegiatan->HrefValue = "";
		$this->kegiatan->TooltipValue = "";

		// kel1
		$this->kel1->LinkCustomAttributes = "";
		$this->kel1->HrefValue = "";
		$this->kel1->TooltipValue = "";

		// kel2
		$this->kel2->LinkCustomAttributes = "";
		$this->kel2->HrefValue = "";
		$this->kel2->TooltipValue = "";

		// kel3
		$this->kel3->LinkCustomAttributes = "";
		$this->kel3->HrefValue = "";
		$this->kel3->TooltipValue = "";

		// kel4
		$this->kel4->LinkCustomAttributes = "";
		$this->kel4->HrefValue = "";
		$this->kel4->TooltipValue = "";

		// nama
		$this->nama->LinkCustomAttributes = "";
		$this->nama->HrefValue = "";
		$this->nama->TooltipValue = "";

		// nama1
		$this->nama1->LinkCustomAttributes = "";
		$this->nama1->HrefValue = "";
		$this->nama1->TooltipValue = "";

		// tw1
		$this->tw1->LinkCustomAttributes = "";
		$this->tw1->HrefValue = "";
		$this->tw1->TooltipValue = "";

		// tw2
		$this->tw2->LinkCustomAttributes = "";
		$this->tw2->HrefValue = "";
		$this->tw2->TooltipValue = "";

		// tw3
		$this->tw3->LinkCustomAttributes = "";
		$this->tw3->HrefValue = "";
		$this->tw3->TooltipValue = "";

		// tw4
		$this->tw4->LinkCustomAttributes = "";
		$this->tw4->HrefValue = "";
		$this->tw4->TooltipValue = "";

		// so
		$this->so->LinkCustomAttributes = "";
		$this->so->HrefValue = "";
		$this->so->TooltipValue = "";

		// tri
		$this->tri->LinkCustomAttributes = "";
		$this->tri->HrefValue = "";
		$this->tri->TooltipValue = "";

		// lap
		$this->lap->LinkCustomAttributes = "";
		$this->lap->HrefValue = "";
		$this->lap->TooltipValue = "";

		// rek
		$this->rek->LinkCustomAttributes = "";
		$this->rek->HrefValue = "";
		$this->rek->TooltipValue = "";

		// rek1
		$this->rek1->LinkCustomAttributes = "";
		$this->rek1->HrefValue = "";
		$this->rek1->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// kodkeg
		$this->kodkeg->EditAttrs["class"] = "form-control";
		$this->kodkeg->EditCustomAttributes = "";
		$this->kodkeg->EditValue = $this->kodkeg->CurrentValue;
		$this->kodkeg->PlaceHolder = ew_RemoveHtml($this->kodkeg->FldCaption());

		// kegiatan
		$this->kegiatan->EditAttrs["class"] = "form-control";
		$this->kegiatan->EditCustomAttributes = "";
		$this->kegiatan->EditValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->PlaceHolder = ew_RemoveHtml($this->kegiatan->FldCaption());

		// kel1
		$this->kel1->EditAttrs["class"] = "form-control";
		$this->kel1->EditCustomAttributes = "";
		$this->kel1->EditValue = $this->kel1->CurrentValue;
		$this->kel1->PlaceHolder = ew_RemoveHtml($this->kel1->FldCaption());

		// kel2
		$this->kel2->EditAttrs["class"] = "form-control";
		$this->kel2->EditCustomAttributes = "";
		$this->kel2->EditValue = $this->kel2->CurrentValue;
		$this->kel2->PlaceHolder = ew_RemoveHtml($this->kel2->FldCaption());

		// kel3
		$this->kel3->EditAttrs["class"] = "form-control";
		$this->kel3->EditCustomAttributes = "";
		$this->kel3->EditValue = $this->kel3->CurrentValue;
		$this->kel3->PlaceHolder = ew_RemoveHtml($this->kel3->FldCaption());

		// kel4
		$this->kel4->EditAttrs["class"] = "form-control";
		$this->kel4->EditCustomAttributes = "";
		$this->kel4->EditValue = $this->kel4->CurrentValue;
		$this->kel4->PlaceHolder = ew_RemoveHtml($this->kel4->FldCaption());

		// nama
		$this->nama->EditAttrs["class"] = "form-control";
		$this->nama->EditCustomAttributes = "";
		$this->nama->EditValue = $this->nama->CurrentValue;
		$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

		// nama1
		$this->nama1->EditAttrs["class"] = "form-control";
		$this->nama1->EditCustomAttributes = "";
		$this->nama1->EditValue = $this->nama1->CurrentValue;
		$this->nama1->PlaceHolder = ew_RemoveHtml($this->nama1->FldCaption());

		// tw1
		$this->tw1->EditAttrs["class"] = "form-control";
		$this->tw1->EditCustomAttributes = "";
		$this->tw1->EditValue = $this->tw1->CurrentValue;
		$this->tw1->PlaceHolder = ew_RemoveHtml($this->tw1->FldCaption());

		// tw2
		$this->tw2->EditAttrs["class"] = "form-control";
		$this->tw2->EditCustomAttributes = "";
		$this->tw2->EditValue = $this->tw2->CurrentValue;
		$this->tw2->PlaceHolder = ew_RemoveHtml($this->tw2->FldCaption());

		// tw3
		$this->tw3->EditAttrs["class"] = "form-control";
		$this->tw3->EditCustomAttributes = "";
		$this->tw3->EditValue = $this->tw3->CurrentValue;
		$this->tw3->PlaceHolder = ew_RemoveHtml($this->tw3->FldCaption());

		// tw4
		$this->tw4->EditAttrs["class"] = "form-control";
		$this->tw4->EditCustomAttributes = "";
		$this->tw4->EditValue = $this->tw4->CurrentValue;
		$this->tw4->PlaceHolder = ew_RemoveHtml($this->tw4->FldCaption());

		// so
		$this->so->EditAttrs["class"] = "form-control";
		$this->so->EditCustomAttributes = "";
		$this->so->EditValue = $this->so->CurrentValue;
		$this->so->PlaceHolder = ew_RemoveHtml($this->so->FldCaption());

		// tri
		$this->tri->EditAttrs["class"] = "form-control";
		$this->tri->EditCustomAttributes = "";
		$this->tri->EditValue = $this->tri->CurrentValue;
		$this->tri->PlaceHolder = ew_RemoveHtml($this->tri->FldCaption());

		// lap
		$this->lap->EditAttrs["class"] = "form-control";
		$this->lap->EditCustomAttributes = "";
		$this->lap->EditValue = $this->lap->CurrentValue;
		$this->lap->PlaceHolder = ew_RemoveHtml($this->lap->FldCaption());

		// rek
		$this->rek->EditAttrs["class"] = "form-control";
		$this->rek->EditCustomAttributes = "";
		$this->rek->EditValue = $this->rek->CurrentValue;
		$this->rek->PlaceHolder = ew_RemoveHtml($this->rek->FldCaption());

		// rek1
		$this->rek1->EditAttrs["class"] = "form-control";
		$this->rek1->EditCustomAttributes = "";
		$this->rek1->EditValue = $this->rek1->CurrentValue;
		$this->rek1->PlaceHolder = ew_RemoveHtml($this->rek1->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->kodkeg->Exportable) $Doc->ExportCaption($this->kodkeg);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->kel1->Exportable) $Doc->ExportCaption($this->kel1);
					if ($this->kel2->Exportable) $Doc->ExportCaption($this->kel2);
					if ($this->kel3->Exportable) $Doc->ExportCaption($this->kel3);
					if ($this->kel4->Exportable) $Doc->ExportCaption($this->kel4);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->nama1->Exportable) $Doc->ExportCaption($this->nama1);
					if ($this->tw1->Exportable) $Doc->ExportCaption($this->tw1);
					if ($this->tw2->Exportable) $Doc->ExportCaption($this->tw2);
					if ($this->tw3->Exportable) $Doc->ExportCaption($this->tw3);
					if ($this->tw4->Exportable) $Doc->ExportCaption($this->tw4);
					if ($this->so->Exportable) $Doc->ExportCaption($this->so);
					if ($this->tri->Exportable) $Doc->ExportCaption($this->tri);
					if ($this->lap->Exportable) $Doc->ExportCaption($this->lap);
					if ($this->rek->Exportable) $Doc->ExportCaption($this->rek);
					if ($this->rek1->Exportable) $Doc->ExportCaption($this->rek1);
				} else {
					if ($this->kodkeg->Exportable) $Doc->ExportCaption($this->kodkeg);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->kel1->Exportable) $Doc->ExportCaption($this->kel1);
					if ($this->kel2->Exportable) $Doc->ExportCaption($this->kel2);
					if ($this->kel3->Exportable) $Doc->ExportCaption($this->kel3);
					if ($this->kel4->Exportable) $Doc->ExportCaption($this->kel4);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->nama1->Exportable) $Doc->ExportCaption($this->nama1);
					if ($this->tw1->Exportable) $Doc->ExportCaption($this->tw1);
					if ($this->tw2->Exportable) $Doc->ExportCaption($this->tw2);
					if ($this->tw3->Exportable) $Doc->ExportCaption($this->tw3);
					if ($this->tw4->Exportable) $Doc->ExportCaption($this->tw4);
					if ($this->so->Exportable) $Doc->ExportCaption($this->so);
					if ($this->tri->Exportable) $Doc->ExportCaption($this->tri);
					if ($this->lap->Exportable) $Doc->ExportCaption($this->lap);
					if ($this->rek->Exportable) $Doc->ExportCaption($this->rek);
					if ($this->rek1->Exportable) $Doc->ExportCaption($this->rek1);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->kodkeg->Exportable) $Doc->ExportField($this->kodkeg);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->kel1->Exportable) $Doc->ExportField($this->kel1);
						if ($this->kel2->Exportable) $Doc->ExportField($this->kel2);
						if ($this->kel3->Exportable) $Doc->ExportField($this->kel3);
						if ($this->kel4->Exportable) $Doc->ExportField($this->kel4);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->nama1->Exportable) $Doc->ExportField($this->nama1);
						if ($this->tw1->Exportable) $Doc->ExportField($this->tw1);
						if ($this->tw2->Exportable) $Doc->ExportField($this->tw2);
						if ($this->tw3->Exportable) $Doc->ExportField($this->tw3);
						if ($this->tw4->Exportable) $Doc->ExportField($this->tw4);
						if ($this->so->Exportable) $Doc->ExportField($this->so);
						if ($this->tri->Exportable) $Doc->ExportField($this->tri);
						if ($this->lap->Exportable) $Doc->ExportField($this->lap);
						if ($this->rek->Exportable) $Doc->ExportField($this->rek);
						if ($this->rek1->Exportable) $Doc->ExportField($this->rek1);
					} else {
						if ($this->kodkeg->Exportable) $Doc->ExportField($this->kodkeg);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->kel1->Exportable) $Doc->ExportField($this->kel1);
						if ($this->kel2->Exportable) $Doc->ExportField($this->kel2);
						if ($this->kel3->Exportable) $Doc->ExportField($this->kel3);
						if ($this->kel4->Exportable) $Doc->ExportField($this->kel4);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->nama1->Exportable) $Doc->ExportField($this->nama1);
						if ($this->tw1->Exportable) $Doc->ExportField($this->tw1);
						if ($this->tw2->Exportable) $Doc->ExportField($this->tw2);
						if ($this->tw3->Exportable) $Doc->ExportField($this->tw3);
						if ($this->tw4->Exportable) $Doc->ExportField($this->tw4);
						if ($this->so->Exportable) $Doc->ExportField($this->so);
						if ($this->tri->Exportable) $Doc->ExportField($this->tri);
						if ($this->lap->Exportable) $Doc->ExportField($this->lap);
						if ($this->rek->Exportable) $Doc->ExportField($this->rek);
						if ($this->rek1->Exportable) $Doc->ExportField($this->rek1);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
