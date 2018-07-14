<?php

// Global variable for table object
$keu_akun4 = NULL;

//
// Table class for keu_akun4
//
class ckeu_akun4 extends cTable {
	var $id;
	var $kd_akun;
	var $kel1;
	var $kel2;
	var $kel3;
	var $kel4;
	var $nmkel4;
	var $kode_akun3;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'keu_akun4';
		$this->TableName = 'keu_akun4';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`keu_akun4`";
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

		// id
		$this->id = new cField('keu_akun4', 'keu_akun4', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// kd_akun
		$this->kd_akun = new cField('keu_akun4', 'keu_akun4', 'x_kd_akun', 'kd_akun', '`kd_akun`', '`kd_akun`', 200, -1, FALSE, '`kd_akun`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_akun->Sortable = TRUE; // Allow sort
		$this->fields['kd_akun'] = &$this->kd_akun;

		// kel1
		$this->kel1 = new cField('keu_akun4', 'keu_akun4', 'x_kel1', 'kel1', '`kel1`', '`kel1`', 200, -1, FALSE, '`kel1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel1->Sortable = TRUE; // Allow sort
		$this->fields['kel1'] = &$this->kel1;

		// kel2
		$this->kel2 = new cField('keu_akun4', 'keu_akun4', 'x_kel2', 'kel2', '`kel2`', '`kel2`', 200, -1, FALSE, '`kel2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel2->Sortable = TRUE; // Allow sort
		$this->fields['kel2'] = &$this->kel2;

		// kel3
		$this->kel3 = new cField('keu_akun4', 'keu_akun4', 'x_kel3', 'kel3', '`kel3`', '`kel3`', 200, -1, FALSE, '`kel3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel3->Sortable = TRUE; // Allow sort
		$this->fields['kel3'] = &$this->kel3;

		// kel4
		$this->kel4 = new cField('keu_akun4', 'keu_akun4', 'x_kel4', 'kel4', '`kel4`', '`kel4`', 200, -1, FALSE, '`kel4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kel4->Sortable = TRUE; // Allow sort
		$this->fields['kel4'] = &$this->kel4;

		// nmkel4
		$this->nmkel4 = new cField('keu_akun4', 'keu_akun4', 'x_nmkel4', 'nmkel4', '`nmkel4`', '`nmkel4`', 200, -1, FALSE, '`nmkel4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nmkel4->Sortable = TRUE; // Allow sort
		$this->fields['nmkel4'] = &$this->nmkel4;

		// kode_akun3
		$this->kode_akun3 = new cField('keu_akun4', 'keu_akun4', 'x_kode_akun3', 'kode_akun3', '`kode_akun3`', '`kode_akun3`', 200, -1, FALSE, '`kode_akun3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_akun3->Sortable = TRUE; // Allow sort
		$this->fields['kode_akun3'] = &$this->kode_akun3;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "keu_akun3") {
			if ($this->kel1->getSessionValue() <> "")
				$sMasterFilter .= "`kel1`=" . ew_QuotedValue($this->kel1->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->kel2->getSessionValue() <> "")
				$sMasterFilter .= " AND `kel2`=" . ew_QuotedValue($this->kel2->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->kel3->getSessionValue() <> "")
				$sMasterFilter .= " AND `kel3`=" . ew_QuotedValue($this->kel3->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "keu_akun3") {
			if ($this->kel1->getSessionValue() <> "")
				$sDetailFilter .= "`kel1`=" . ew_QuotedValue($this->kel1->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->kel2->getSessionValue() <> "")
				$sDetailFilter .= " AND `kel2`=" . ew_QuotedValue($this->kel2->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->kel3->getSessionValue() <> "")
				$sDetailFilter .= " AND `kel3`=" . ew_QuotedValue($this->kel3->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_keu_akun3() {
		return "`kel1`='@kel1@' AND `kel2`='@kel2@' AND `kel3`='@kel3@'";
	}

	// Detail filter
	function SqlDetailFilter_keu_akun3() {
		return "`kel1`='@kel1@' AND `kel2`='@kel2@' AND `kel3`='@kel3@'";
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "keu_akun5") {
			$sDetailUrl = $GLOBALS["keu_akun5"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_kel1=" . urlencode($this->kel1->CurrentValue);
			$sDetailUrl .= "&fk_kel2=" . urlencode($this->kel2->CurrentValue);
			$sDetailUrl .= "&fk_kel3=" . urlencode($this->kel3->CurrentValue);
			$sDetailUrl .= "&fk_kel4=" . urlencode($this->kel4->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "keu_akun4list.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`keu_akun4`";
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
		$this->TableFilter = "`kel4` IS NOT NULL";
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
			$this->id->setDbValue($conn->Insert_ID());
			$rs['id'] = $this->id->DbValue;
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
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
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
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "keu_akun4list.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "keu_akun4list.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("keu_akun4view.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("keu_akun4view.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "keu_akun4add.php?" . $this->UrlParm($parm);
		else
			$url = "keu_akun4add.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("keu_akun4edit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("keu_akun4edit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("keu_akun4add.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("keu_akun4add.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("keu_akun4delete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "keu_akun3" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_kel1=" . urlencode($this->kel1->CurrentValue);
			$url .= "&fk_kel2=" . urlencode($this->kel2->CurrentValue);
			$url .= "&fk_kel3=" . urlencode($this->kel3->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
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
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = ew_StripSlashes($_POST["id"]);
			elseif (isset($_GET["id"]))
				$arKeys[] = ew_StripSlashes($_GET["id"]);
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
			$this->id->CurrentValue = $key;
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
		$this->id->setDbValue($rs->fields('id'));
		$this->kd_akun->setDbValue($rs->fields('kd_akun'));
		$this->kel1->setDbValue($rs->fields('kel1'));
		$this->kel2->setDbValue($rs->fields('kel2'));
		$this->kel3->setDbValue($rs->fields('kel3'));
		$this->kel4->setDbValue($rs->fields('kel4'));
		$this->nmkel4->setDbValue($rs->fields('nmkel4'));
		$this->kode_akun3->setDbValue($rs->fields('kode_akun3'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// kd_akun
		// kel1
		// kel2
		// kel3
		// kel4
		// nmkel4
		// kode_akun3
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kd_akun
		$this->kd_akun->ViewValue = $this->kd_akun->CurrentValue;
		$this->kd_akun->ViewCustomAttributes = "";

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

		// nmkel4
		$this->nmkel4->ViewValue = $this->nmkel4->CurrentValue;
		$this->nmkel4->ViewCustomAttributes = "";

		// kode_akun3
		$this->kode_akun3->ViewValue = $this->kode_akun3->CurrentValue;
		$this->kode_akun3->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// kd_akun
		$this->kd_akun->LinkCustomAttributes = "";
		$this->kd_akun->HrefValue = "";
		$this->kd_akun->TooltipValue = "";

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

		// nmkel4
		$this->nmkel4->LinkCustomAttributes = "";
		$this->nmkel4->HrefValue = "";
		$this->nmkel4->TooltipValue = "";

		// kode_akun3
		$this->kode_akun3->LinkCustomAttributes = "";
		$this->kode_akun3->HrefValue = "";
		$this->kode_akun3->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kd_akun
		$this->kd_akun->EditAttrs["class"] = "form-control";
		$this->kd_akun->EditCustomAttributes = "";
		$this->kd_akun->EditValue = $this->kd_akun->CurrentValue;
		$this->kd_akun->PlaceHolder = ew_RemoveHtml($this->kd_akun->FldCaption());

		// kel1
		$this->kel1->EditAttrs["class"] = "form-control";
		$this->kel1->EditCustomAttributes = "";
		if ($this->kel1->getSessionValue() <> "") {
			$this->kel1->CurrentValue = $this->kel1->getSessionValue();
		$this->kel1->ViewValue = $this->kel1->CurrentValue;
		$this->kel1->ViewCustomAttributes = "";
		} else {
		$this->kel1->EditValue = $this->kel1->CurrentValue;
		$this->kel1->PlaceHolder = ew_RemoveHtml($this->kel1->FldCaption());
		}

		// kel2
		$this->kel2->EditAttrs["class"] = "form-control";
		$this->kel2->EditCustomAttributes = "";
		if ($this->kel2->getSessionValue() <> "") {
			$this->kel2->CurrentValue = $this->kel2->getSessionValue();
		$this->kel2->ViewValue = $this->kel2->CurrentValue;
		$this->kel2->ViewCustomAttributes = "";
		} else {
		$this->kel2->EditValue = $this->kel2->CurrentValue;
		$this->kel2->PlaceHolder = ew_RemoveHtml($this->kel2->FldCaption());
		}

		// kel3
		$this->kel3->EditAttrs["class"] = "form-control";
		$this->kel3->EditCustomAttributes = "";
		if ($this->kel3->getSessionValue() <> "") {
			$this->kel3->CurrentValue = $this->kel3->getSessionValue();
		$this->kel3->ViewValue = $this->kel3->CurrentValue;
		$this->kel3->ViewCustomAttributes = "";
		} else {
		$this->kel3->EditValue = $this->kel3->CurrentValue;
		$this->kel3->PlaceHolder = ew_RemoveHtml($this->kel3->FldCaption());
		}

		// kel4
		$this->kel4->EditAttrs["class"] = "form-control";
		$this->kel4->EditCustomAttributes = "";
		$this->kel4->EditValue = $this->kel4->CurrentValue;
		$this->kel4->PlaceHolder = ew_RemoveHtml($this->kel4->FldCaption());

		// nmkel4
		$this->nmkel4->EditAttrs["class"] = "form-control";
		$this->nmkel4->EditCustomAttributes = "";
		$this->nmkel4->EditValue = $this->nmkel4->CurrentValue;
		$this->nmkel4->PlaceHolder = ew_RemoveHtml($this->nmkel4->FldCaption());

		// kode_akun3
		$this->kode_akun3->EditAttrs["class"] = "form-control";
		$this->kode_akun3->EditCustomAttributes = "";
		$this->kode_akun3->EditValue = $this->kode_akun3->CurrentValue;
		$this->kode_akun3->PlaceHolder = ew_RemoveHtml($this->kode_akun3->FldCaption());

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
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->kd_akun->Exportable) $Doc->ExportCaption($this->kd_akun);
					if ($this->kel1->Exportable) $Doc->ExportCaption($this->kel1);
					if ($this->kel2->Exportable) $Doc->ExportCaption($this->kel2);
					if ($this->kel3->Exportable) $Doc->ExportCaption($this->kel3);
					if ($this->kel4->Exportable) $Doc->ExportCaption($this->kel4);
					if ($this->nmkel4->Exportable) $Doc->ExportCaption($this->nmkel4);
					if ($this->kode_akun3->Exportable) $Doc->ExportCaption($this->kode_akun3);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->kd_akun->Exportable) $Doc->ExportCaption($this->kd_akun);
					if ($this->kel1->Exportable) $Doc->ExportCaption($this->kel1);
					if ($this->kel2->Exportable) $Doc->ExportCaption($this->kel2);
					if ($this->kel3->Exportable) $Doc->ExportCaption($this->kel3);
					if ($this->kel4->Exportable) $Doc->ExportCaption($this->kel4);
					if ($this->nmkel4->Exportable) $Doc->ExportCaption($this->nmkel4);
					if ($this->kode_akun3->Exportable) $Doc->ExportCaption($this->kode_akun3);
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
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->kd_akun->Exportable) $Doc->ExportField($this->kd_akun);
						if ($this->kel1->Exportable) $Doc->ExportField($this->kel1);
						if ($this->kel2->Exportable) $Doc->ExportField($this->kel2);
						if ($this->kel3->Exportable) $Doc->ExportField($this->kel3);
						if ($this->kel4->Exportable) $Doc->ExportField($this->kel4);
						if ($this->nmkel4->Exportable) $Doc->ExportField($this->nmkel4);
						if ($this->kode_akun3->Exportable) $Doc->ExportField($this->kode_akun3);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->kd_akun->Exportable) $Doc->ExportField($this->kd_akun);
						if ($this->kel1->Exportable) $Doc->ExportField($this->kel1);
						if ($this->kel2->Exportable) $Doc->ExportField($this->kel2);
						if ($this->kel3->Exportable) $Doc->ExportField($this->kel3);
						if ($this->kel4->Exportable) $Doc->ExportField($this->kel4);
						if ($this->nmkel4->Exportable) $Doc->ExportField($this->nmkel4);
						if ($this->kode_akun3->Exportable) $Doc->ExportField($this->kode_akun3);
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
