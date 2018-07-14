<?php

// Global variable for table object
$vw_sensus_harian_rawat_jalan = NULL;

//
// Table class for vw_sensus_harian_rawat_jalan
//
class cvw_sensus_harian_rawat_jalan extends cTable {
	var $IDXDAFTAR;
	var $NOMR;
	var $TGLREG;
	var $KDDOKTER;
	var $KDPOLY;
	var $KDRUJUK;
	var $KDCARABAYAR;
	var $SHIFT;
	var $STATUS;
	var $PASIENBARU;
	var $KETRUJUK;
	var $NO_SJP;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_sensus_harian_rawat_jalan';
		$this->TableName = 'vw_sensus_harian_rawat_jalan';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_sensus_harian_rawat_jalan`";
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
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// IDXDAFTAR
		$this->IDXDAFTAR = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_IDXDAFTAR', 'IDXDAFTAR', '`IDXDAFTAR`', '`IDXDAFTAR`', 3, -1, FALSE, '`IDXDAFTAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->IDXDAFTAR->Sortable = TRUE; // Allow sort
		$this->IDXDAFTAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IDXDAFTAR'] = &$this->IDXDAFTAR;

		// NOMR
		$this->NOMR = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_NOMR', 'NOMR', '`NOMR`', '`NOMR`', 200, -1, FALSE, '`NOMR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOMR->Sortable = TRUE; // Allow sort
		$this->fields['NOMR'] = &$this->NOMR;

		// TGLREG
		$this->TGLREG = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_TGLREG', 'TGLREG', '`TGLREG`', ew_CastDateFieldForLike('`TGLREG`', 0, "DB"), 133, 0, FALSE, '`TGLREG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGLREG->Sortable = TRUE; // Allow sort
		$this->TGLREG->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TGLREG'] = &$this->TGLREG;

		// KDDOKTER
		$this->KDDOKTER = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_KDDOKTER', 'KDDOKTER', '`KDDOKTER`', '`KDDOKTER`', 3, -1, FALSE, '`KDDOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDDOKTER->Sortable = TRUE; // Allow sort
		$this->KDDOKTER->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDDOKTER'] = &$this->KDDOKTER;

		// KDPOLY
		$this->KDPOLY = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_KDPOLY', 'KDPOLY', '`KDPOLY`', '`KDPOLY`', 3, -1, FALSE, '`KDPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDPOLY->Sortable = TRUE; // Allow sort
		$this->KDPOLY->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDPOLY->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDPOLY->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDPOLY'] = &$this->KDPOLY;

		// KDRUJUK
		$this->KDRUJUK = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_KDRUJUK', 'KDRUJUK', '`KDRUJUK`', '`KDRUJUK`', 3, -1, FALSE, '`KDRUJUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDRUJUK->Sortable = TRUE; // Allow sort
		$this->KDRUJUK->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDRUJUK'] = &$this->KDRUJUK;

		// KDCARABAYAR
		$this->KDCARABAYAR = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_KDCARABAYAR', 'KDCARABAYAR', '`KDCARABAYAR`', '`KDCARABAYAR`', 3, -1, FALSE, '`KDCARABAYAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDCARABAYAR->Sortable = TRUE; // Allow sort
		$this->KDCARABAYAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDCARABAYAR'] = &$this->KDCARABAYAR;

		// SHIFT
		$this->SHIFT = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_SHIFT', 'SHIFT', '`SHIFT`', '`SHIFT`', 3, -1, FALSE, '`SHIFT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SHIFT->Sortable = TRUE; // Allow sort
		$this->SHIFT->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['SHIFT'] = &$this->SHIFT;

		// STATUS
		$this->STATUS = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_STATUS', 'STATUS', '`STATUS`', '`STATUS`', 3, -1, FALSE, '`STATUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->STATUS->Sortable = TRUE; // Allow sort
		$this->STATUS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['STATUS'] = &$this->STATUS;

		// PASIENBARU
		$this->PASIENBARU = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_PASIENBARU', 'PASIENBARU', '`PASIENBARU`', '`PASIENBARU`', 3, -1, FALSE, '`PASIENBARU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PASIENBARU->Sortable = TRUE; // Allow sort
		$this->PASIENBARU->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['PASIENBARU'] = &$this->PASIENBARU;

		// KETRUJUK
		$this->KETRUJUK = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_KETRUJUK', 'KETRUJUK', '`KETRUJUK`', '`KETRUJUK`', 200, -1, FALSE, '`KETRUJUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETRUJUK->Sortable = TRUE; // Allow sort
		$this->fields['KETRUJUK'] = &$this->KETRUJUK;

		// NO_SJP
		$this->NO_SJP = new cField('vw_sensus_harian_rawat_jalan', 'vw_sensus_harian_rawat_jalan', 'x_NO_SJP', 'NO_SJP', '`NO_SJP`', '`NO_SJP`', 200, -1, FALSE, '`NO_SJP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SJP->Sortable = TRUE; // Allow sort
		$this->fields['NO_SJP'] = &$this->NO_SJP;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_sensus_harian_rawat_jalan`";
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

			// Get insert id if necessary
			$this->IDXDAFTAR->setDbValue($conn->Insert_ID());
			$rs['IDXDAFTAR'] = $this->IDXDAFTAR->DbValue;
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
			if (array_key_exists('IDXDAFTAR', $rs))
				ew_AddFilter($where, ew_QuotedName('IDXDAFTAR', $this->DBID) . '=' . ew_QuotedValue($rs['IDXDAFTAR'], $this->IDXDAFTAR->FldDataType, $this->DBID));
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
		return "`IDXDAFTAR` = @IDXDAFTAR@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->IDXDAFTAR->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@IDXDAFTAR@", ew_AdjustSql($this->IDXDAFTAR->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "vw_sensus_harian_rawat_jalanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_sensus_harian_rawat_jalanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_sensus_harian_rawat_jalanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_sensus_harian_rawat_jalanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_sensus_harian_rawat_jalanadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_sensus_harian_rawat_jalanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_sensus_harian_rawat_jalanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_sensus_harian_rawat_jalanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_sensus_harian_rawat_jalandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "IDXDAFTAR:" . ew_VarToJson($this->IDXDAFTAR->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->IDXDAFTAR->CurrentValue)) {
			$sUrl .= "IDXDAFTAR=" . urlencode($this->IDXDAFTAR->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
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
			if ($isPost && isset($_POST["IDXDAFTAR"]))
				$arKeys[] = ew_StripSlashes($_POST["IDXDAFTAR"]);
			elseif (isset($_GET["IDXDAFTAR"]))
				$arKeys[] = ew_StripSlashes($_GET["IDXDAFTAR"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
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
			$this->IDXDAFTAR->CurrentValue = $key;
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
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
		$this->KETRUJUK->setDbValue($rs->fields('KETRUJUK'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// IDXDAFTAR
		$this->IDXDAFTAR->LinkCustomAttributes = "";
		$this->IDXDAFTAR->HrefValue = "";
		$this->IDXDAFTAR->TooltipValue = "";

		// NOMR
		$this->NOMR->LinkCustomAttributes = "";
		$this->NOMR->HrefValue = "";
		$this->NOMR->TooltipValue = "";

		// TGLREG
		$this->TGLREG->LinkCustomAttributes = "";
		$this->TGLREG->HrefValue = "";
		$this->TGLREG->TooltipValue = "";

		// KDDOKTER
		$this->KDDOKTER->LinkCustomAttributes = "";
		$this->KDDOKTER->HrefValue = "";
		$this->KDDOKTER->TooltipValue = "";

		// KDPOLY
		$this->KDPOLY->LinkCustomAttributes = "";
		$this->KDPOLY->HrefValue = "";
		$this->KDPOLY->TooltipValue = "";

		// KDRUJUK
		$this->KDRUJUK->LinkCustomAttributes = "";
		$this->KDRUJUK->HrefValue = "";
		$this->KDRUJUK->TooltipValue = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->LinkCustomAttributes = "";
		$this->KDCARABAYAR->HrefValue = "";
		$this->KDCARABAYAR->TooltipValue = "";

		// SHIFT
		$this->SHIFT->LinkCustomAttributes = "";
		$this->SHIFT->HrefValue = "";
		$this->SHIFT->TooltipValue = "";

		// STATUS
		$this->STATUS->LinkCustomAttributes = "";
		$this->STATUS->HrefValue = "";
		$this->STATUS->TooltipValue = "";

		// PASIENBARU
		$this->PASIENBARU->LinkCustomAttributes = "";
		$this->PASIENBARU->HrefValue = "";
		$this->PASIENBARU->TooltipValue = "";

		// KETRUJUK
		$this->KETRUJUK->LinkCustomAttributes = "";
		$this->KETRUJUK->HrefValue = "";
		$this->KETRUJUK->TooltipValue = "";

		// NO_SJP
		$this->NO_SJP->LinkCustomAttributes = "";
		$this->NO_SJP->HrefValue = "";
		$this->NO_SJP->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// IDXDAFTAR
		$this->IDXDAFTAR->EditAttrs["class"] = "form-control";
		$this->IDXDAFTAR->EditCustomAttributes = "";
		$this->IDXDAFTAR->EditValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->EditAttrs["class"] = "form-control";
		$this->NOMR->EditCustomAttributes = "";
		$this->NOMR->EditValue = $this->NOMR->CurrentValue;
		$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

		// TGLREG
		$this->TGLREG->EditAttrs["class"] = "form-control";
		$this->TGLREG->EditCustomAttributes = "";
		$this->TGLREG->EditValue = ew_FormatDateTime($this->TGLREG->CurrentValue, 8);
		$this->TGLREG->PlaceHolder = ew_RemoveHtml($this->TGLREG->FldCaption());

		// KDDOKTER
		$this->KDDOKTER->EditAttrs["class"] = "form-control";
		$this->KDDOKTER->EditCustomAttributes = "";
		$this->KDDOKTER->EditValue = $this->KDDOKTER->CurrentValue;
		$this->KDDOKTER->PlaceHolder = ew_RemoveHtml($this->KDDOKTER->FldCaption());

		// KDPOLY
		$this->KDPOLY->EditAttrs["class"] = "form-control";
		$this->KDPOLY->EditCustomAttributes = "";

		// KDRUJUK
		$this->KDRUJUK->EditAttrs["class"] = "form-control";
		$this->KDRUJUK->EditCustomAttributes = "";
		$this->KDRUJUK->EditValue = $this->KDRUJUK->CurrentValue;
		$this->KDRUJUK->PlaceHolder = ew_RemoveHtml($this->KDRUJUK->FldCaption());

		// KDCARABAYAR
		$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
		$this->KDCARABAYAR->EditCustomAttributes = "";
		$this->KDCARABAYAR->EditValue = $this->KDCARABAYAR->CurrentValue;
		$this->KDCARABAYAR->PlaceHolder = ew_RemoveHtml($this->KDCARABAYAR->FldCaption());

		// SHIFT
		$this->SHIFT->EditAttrs["class"] = "form-control";
		$this->SHIFT->EditCustomAttributes = "";
		$this->SHIFT->EditValue = $this->SHIFT->CurrentValue;
		$this->SHIFT->PlaceHolder = ew_RemoveHtml($this->SHIFT->FldCaption());

		// STATUS
		$this->STATUS->EditAttrs["class"] = "form-control";
		$this->STATUS->EditCustomAttributes = "";
		$this->STATUS->EditValue = $this->STATUS->CurrentValue;
		$this->STATUS->PlaceHolder = ew_RemoveHtml($this->STATUS->FldCaption());

		// PASIENBARU
		$this->PASIENBARU->EditAttrs["class"] = "form-control";
		$this->PASIENBARU->EditCustomAttributes = "";
		$this->PASIENBARU->EditValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->PlaceHolder = ew_RemoveHtml($this->PASIENBARU->FldCaption());

		// KETRUJUK
		$this->KETRUJUK->EditAttrs["class"] = "form-control";
		$this->KETRUJUK->EditCustomAttributes = "";
		$this->KETRUJUK->EditValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->PlaceHolder = ew_RemoveHtml($this->KETRUJUK->FldCaption());

		// NO_SJP
		$this->NO_SJP->EditAttrs["class"] = "form-control";
		$this->NO_SJP->EditCustomAttributes = "";
		$this->NO_SJP->EditValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->PlaceHolder = ew_RemoveHtml($this->NO_SJP->FldCaption());

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
					if ($this->IDXDAFTAR->Exportable) $Doc->ExportCaption($this->IDXDAFTAR);
					if ($this->NOMR->Exportable) $Doc->ExportCaption($this->NOMR);
					if ($this->TGLREG->Exportable) $Doc->ExportCaption($this->TGLREG);
					if ($this->KDDOKTER->Exportable) $Doc->ExportCaption($this->KDDOKTER);
					if ($this->KDPOLY->Exportable) $Doc->ExportCaption($this->KDPOLY);
					if ($this->KDRUJUK->Exportable) $Doc->ExportCaption($this->KDRUJUK);
					if ($this->KDCARABAYAR->Exportable) $Doc->ExportCaption($this->KDCARABAYAR);
					if ($this->SHIFT->Exportable) $Doc->ExportCaption($this->SHIFT);
					if ($this->STATUS->Exportable) $Doc->ExportCaption($this->STATUS);
					if ($this->PASIENBARU->Exportable) $Doc->ExportCaption($this->PASIENBARU);
					if ($this->KETRUJUK->Exportable) $Doc->ExportCaption($this->KETRUJUK);
					if ($this->NO_SJP->Exportable) $Doc->ExportCaption($this->NO_SJP);
				} else {
					if ($this->IDXDAFTAR->Exportable) $Doc->ExportCaption($this->IDXDAFTAR);
					if ($this->NOMR->Exportable) $Doc->ExportCaption($this->NOMR);
					if ($this->TGLREG->Exportable) $Doc->ExportCaption($this->TGLREG);
					if ($this->KDDOKTER->Exportable) $Doc->ExportCaption($this->KDDOKTER);
					if ($this->KDPOLY->Exportable) $Doc->ExportCaption($this->KDPOLY);
					if ($this->KDRUJUK->Exportable) $Doc->ExportCaption($this->KDRUJUK);
					if ($this->KDCARABAYAR->Exportable) $Doc->ExportCaption($this->KDCARABAYAR);
					if ($this->SHIFT->Exportable) $Doc->ExportCaption($this->SHIFT);
					if ($this->STATUS->Exportable) $Doc->ExportCaption($this->STATUS);
					if ($this->PASIENBARU->Exportable) $Doc->ExportCaption($this->PASIENBARU);
					if ($this->KETRUJUK->Exportable) $Doc->ExportCaption($this->KETRUJUK);
					if ($this->NO_SJP->Exportable) $Doc->ExportCaption($this->NO_SJP);
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
						if ($this->IDXDAFTAR->Exportable) $Doc->ExportField($this->IDXDAFTAR);
						if ($this->NOMR->Exportable) $Doc->ExportField($this->NOMR);
						if ($this->TGLREG->Exportable) $Doc->ExportField($this->TGLREG);
						if ($this->KDDOKTER->Exportable) $Doc->ExportField($this->KDDOKTER);
						if ($this->KDPOLY->Exportable) $Doc->ExportField($this->KDPOLY);
						if ($this->KDRUJUK->Exportable) $Doc->ExportField($this->KDRUJUK);
						if ($this->KDCARABAYAR->Exportable) $Doc->ExportField($this->KDCARABAYAR);
						if ($this->SHIFT->Exportable) $Doc->ExportField($this->SHIFT);
						if ($this->STATUS->Exportable) $Doc->ExportField($this->STATUS);
						if ($this->PASIENBARU->Exportable) $Doc->ExportField($this->PASIENBARU);
						if ($this->KETRUJUK->Exportable) $Doc->ExportField($this->KETRUJUK);
						if ($this->NO_SJP->Exportable) $Doc->ExportField($this->NO_SJP);
					} else {
						if ($this->IDXDAFTAR->Exportable) $Doc->ExportField($this->IDXDAFTAR);
						if ($this->NOMR->Exportable) $Doc->ExportField($this->NOMR);
						if ($this->TGLREG->Exportable) $Doc->ExportField($this->TGLREG);
						if ($this->KDDOKTER->Exportable) $Doc->ExportField($this->KDDOKTER);
						if ($this->KDPOLY->Exportable) $Doc->ExportField($this->KDPOLY);
						if ($this->KDRUJUK->Exportable) $Doc->ExportField($this->KDRUJUK);
						if ($this->KDCARABAYAR->Exportable) $Doc->ExportField($this->KDCARABAYAR);
						if ($this->SHIFT->Exportable) $Doc->ExportField($this->SHIFT);
						if ($this->STATUS->Exportable) $Doc->ExportField($this->STATUS);
						if ($this->PASIENBARU->Exportable) $Doc->ExportField($this->PASIENBARU);
						if ($this->KETRUJUK->Exportable) $Doc->ExportField($this->KETRUJUK);
						if ($this->NO_SJP->Exportable) $Doc->ExportField($this->NO_SJP);
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
