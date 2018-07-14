<?php

// Global variable for table object
$pd_analytics = NULL;

//
// Table class for pd_analytics
//
class cpd_analytics extends cTable {
	var $aid;
	var $v_ipaddr;
	var $v_datetime;
	var $v_referer;
	var $v_language;
	var $v_http_cookie;
	var $v_locale;
	var $v_useragent;
	var $v_remote_addr;
	var $v_browser;
	var $v_platform;
	var $v_version;
	var $v_city;
	var $v_country;
	var $v_countrycode;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'pd_analytics';
		$this->TableName = 'pd_analytics';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`pd_analytics`";
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

		// aid
		$this->aid = new cField('pd_analytics', 'pd_analytics', 'x_aid', 'aid', '`aid`', '`aid`', 3, -1, FALSE, '`aid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->aid->Sortable = TRUE; // Allow sort
		$this->aid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['aid'] = &$this->aid;

		// v_ipaddr
		$this->v_ipaddr = new cField('pd_analytics', 'pd_analytics', 'x_v_ipaddr', 'v_ipaddr', '`v_ipaddr`', '`v_ipaddr`', 200, -1, FALSE, '`v_ipaddr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_ipaddr->Sortable = TRUE; // Allow sort
		$this->fields['v_ipaddr'] = &$this->v_ipaddr;

		// v_datetime
		$this->v_datetime = new cField('pd_analytics', 'pd_analytics', 'x_v_datetime', 'v_datetime', '`v_datetime`', ew_CastDateFieldForLike('`v_datetime`', 0, "DB"), 135, 0, FALSE, '`v_datetime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_datetime->Sortable = TRUE; // Allow sort
		$this->v_datetime->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['v_datetime'] = &$this->v_datetime;

		// v_referer
		$this->v_referer = new cField('pd_analytics', 'pd_analytics', 'x_v_referer', 'v_referer', '`v_referer`', '`v_referer`', 200, -1, FALSE, '`v_referer`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_referer->Sortable = TRUE; // Allow sort
		$this->fields['v_referer'] = &$this->v_referer;

		// v_language
		$this->v_language = new cField('pd_analytics', 'pd_analytics', 'x_v_language', 'v_language', '`v_language`', '`v_language`', 200, -1, FALSE, '`v_language`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_language->Sortable = TRUE; // Allow sort
		$this->fields['v_language'] = &$this->v_language;

		// v_http_cookie
		$this->v_http_cookie = new cField('pd_analytics', 'pd_analytics', 'x_v_http_cookie', 'v_http_cookie', '`v_http_cookie`', '`v_http_cookie`', 200, -1, FALSE, '`v_http_cookie`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_http_cookie->Sortable = TRUE; // Allow sort
		$this->fields['v_http_cookie'] = &$this->v_http_cookie;

		// v_locale
		$this->v_locale = new cField('pd_analytics', 'pd_analytics', 'x_v_locale', 'v_locale', '`v_locale`', '`v_locale`', 200, -1, FALSE, '`v_locale`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_locale->Sortable = TRUE; // Allow sort
		$this->fields['v_locale'] = &$this->v_locale;

		// v_useragent
		$this->v_useragent = new cField('pd_analytics', 'pd_analytics', 'x_v_useragent', 'v_useragent', '`v_useragent`', '`v_useragent`', 200, -1, FALSE, '`v_useragent`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_useragent->Sortable = TRUE; // Allow sort
		$this->fields['v_useragent'] = &$this->v_useragent;

		// v_remote_addr
		$this->v_remote_addr = new cField('pd_analytics', 'pd_analytics', 'x_v_remote_addr', 'v_remote_addr', '`v_remote_addr`', '`v_remote_addr`', 200, -1, FALSE, '`v_remote_addr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_remote_addr->Sortable = TRUE; // Allow sort
		$this->fields['v_remote_addr'] = &$this->v_remote_addr;

		// v_browser
		$this->v_browser = new cField('pd_analytics', 'pd_analytics', 'x_v_browser', 'v_browser', '`v_browser`', '`v_browser`', 200, -1, FALSE, '`v_browser`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_browser->Sortable = TRUE; // Allow sort
		$this->fields['v_browser'] = &$this->v_browser;

		// v_platform
		$this->v_platform = new cField('pd_analytics', 'pd_analytics', 'x_v_platform', 'v_platform', '`v_platform`', '`v_platform`', 200, -1, FALSE, '`v_platform`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_platform->Sortable = TRUE; // Allow sort
		$this->fields['v_platform'] = &$this->v_platform;

		// v_version
		$this->v_version = new cField('pd_analytics', 'pd_analytics', 'x_v_version', 'v_version', '`v_version`', '`v_version`', 200, -1, FALSE, '`v_version`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_version->Sortable = TRUE; // Allow sort
		$this->fields['v_version'] = &$this->v_version;

		// v_city
		$this->v_city = new cField('pd_analytics', 'pd_analytics', 'x_v_city', 'v_city', '`v_city`', '`v_city`', 200, -1, FALSE, '`v_city`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_city->Sortable = TRUE; // Allow sort
		$this->fields['v_city'] = &$this->v_city;

		// v_country
		$this->v_country = new cField('pd_analytics', 'pd_analytics', 'x_v_country', 'v_country', '`v_country`', '`v_country`', 200, -1, FALSE, '`v_country`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_country->Sortable = TRUE; // Allow sort
		$this->fields['v_country'] = &$this->v_country;

		// v_countrycode
		$this->v_countrycode = new cField('pd_analytics', 'pd_analytics', 'x_v_countrycode', 'v_countrycode', '`v_countrycode`', '`v_countrycode`', 200, -1, FALSE, '`v_countrycode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->v_countrycode->Sortable = TRUE; // Allow sort
		$this->fields['v_countrycode'] = &$this->v_countrycode;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`pd_analytics`";
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
			$this->aid->setDbValue($conn->Insert_ID());
			$rs['aid'] = $this->aid->DbValue;
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
			if (array_key_exists('aid', $rs))
				ew_AddFilter($where, ew_QuotedName('aid', $this->DBID) . '=' . ew_QuotedValue($rs['aid'], $this->aid->FldDataType, $this->DBID));
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
		return "`aid` = @aid@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->aid->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@aid@", ew_AdjustSql($this->aid->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "pd_analyticslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "pd_analyticslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("pd_analyticsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("pd_analyticsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "pd_analyticsadd.php?" . $this->UrlParm($parm);
		else
			$url = "pd_analyticsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("pd_analyticsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("pd_analyticsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("pd_analyticsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "aid:" . ew_VarToJson($this->aid->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->aid->CurrentValue)) {
			$sUrl .= "aid=" . urlencode($this->aid->CurrentValue);
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
			if ($isPost && isset($_POST["aid"]))
				$arKeys[] = ew_StripSlashes($_POST["aid"]);
			elseif (isset($_GET["aid"]))
				$arKeys[] = ew_StripSlashes($_GET["aid"]);
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
			$this->aid->CurrentValue = $key;
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
		$this->aid->setDbValue($rs->fields('aid'));
		$this->v_ipaddr->setDbValue($rs->fields('v_ipaddr'));
		$this->v_datetime->setDbValue($rs->fields('v_datetime'));
		$this->v_referer->setDbValue($rs->fields('v_referer'));
		$this->v_language->setDbValue($rs->fields('v_language'));
		$this->v_http_cookie->setDbValue($rs->fields('v_http_cookie'));
		$this->v_locale->setDbValue($rs->fields('v_locale'));
		$this->v_useragent->setDbValue($rs->fields('v_useragent'));
		$this->v_remote_addr->setDbValue($rs->fields('v_remote_addr'));
		$this->v_browser->setDbValue($rs->fields('v_browser'));
		$this->v_platform->setDbValue($rs->fields('v_platform'));
		$this->v_version->setDbValue($rs->fields('v_version'));
		$this->v_city->setDbValue($rs->fields('v_city'));
		$this->v_country->setDbValue($rs->fields('v_country'));
		$this->v_countrycode->setDbValue($rs->fields('v_countrycode'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// aid
		// v_ipaddr
		// v_datetime
		// v_referer
		// v_language
		// v_http_cookie
		// v_locale
		// v_useragent
		// v_remote_addr
		// v_browser
		// v_platform
		// v_version
		// v_city
		// v_country
		// v_countrycode
		// aid

		$this->aid->ViewValue = $this->aid->CurrentValue;
		$this->aid->ViewCustomAttributes = "";

		// v_ipaddr
		$this->v_ipaddr->ViewValue = $this->v_ipaddr->CurrentValue;
		$this->v_ipaddr->ViewCustomAttributes = "";

		// v_datetime
		$this->v_datetime->ViewValue = $this->v_datetime->CurrentValue;
		$this->v_datetime->ViewValue = ew_FormatDateTime($this->v_datetime->ViewValue, 0);
		$this->v_datetime->ViewCustomAttributes = "";

		// v_referer
		$this->v_referer->ViewValue = $this->v_referer->CurrentValue;
		$this->v_referer->ViewCustomAttributes = "";

		// v_language
		$this->v_language->ViewValue = $this->v_language->CurrentValue;
		$this->v_language->ViewCustomAttributes = "";

		// v_http_cookie
		$this->v_http_cookie->ViewValue = $this->v_http_cookie->CurrentValue;
		$this->v_http_cookie->ViewCustomAttributes = "";

		// v_locale
		$this->v_locale->ViewValue = $this->v_locale->CurrentValue;
		$this->v_locale->ViewCustomAttributes = "";

		// v_useragent
		$this->v_useragent->ViewValue = $this->v_useragent->CurrentValue;
		$this->v_useragent->ViewCustomAttributes = "";

		// v_remote_addr
		$this->v_remote_addr->ViewValue = $this->v_remote_addr->CurrentValue;
		$this->v_remote_addr->ViewCustomAttributes = "";

		// v_browser
		$this->v_browser->ViewValue = $this->v_browser->CurrentValue;
		$this->v_browser->ViewCustomAttributes = "";

		// v_platform
		$this->v_platform->ViewValue = $this->v_platform->CurrentValue;
		$this->v_platform->ViewCustomAttributes = "";

		// v_version
		$this->v_version->ViewValue = $this->v_version->CurrentValue;
		$this->v_version->ViewCustomAttributes = "";

		// v_city
		$this->v_city->ViewValue = $this->v_city->CurrentValue;
		$this->v_city->ViewCustomAttributes = "";

		// v_country
		$this->v_country->ViewValue = $this->v_country->CurrentValue;
		$this->v_country->ViewCustomAttributes = "";

		// v_countrycode
		$this->v_countrycode->ViewValue = $this->v_countrycode->CurrentValue;
		$this->v_countrycode->ViewCustomAttributes = "";

		// aid
		$this->aid->LinkCustomAttributes = "";
		$this->aid->HrefValue = "";
		$this->aid->TooltipValue = "";

		// v_ipaddr
		$this->v_ipaddr->LinkCustomAttributes = "";
		$this->v_ipaddr->HrefValue = "";
		$this->v_ipaddr->TooltipValue = "";

		// v_datetime
		$this->v_datetime->LinkCustomAttributes = "";
		$this->v_datetime->HrefValue = "";
		$this->v_datetime->TooltipValue = "";

		// v_referer
		$this->v_referer->LinkCustomAttributes = "";
		$this->v_referer->HrefValue = "";
		$this->v_referer->TooltipValue = "";

		// v_language
		$this->v_language->LinkCustomAttributes = "";
		$this->v_language->HrefValue = "";
		$this->v_language->TooltipValue = "";

		// v_http_cookie
		$this->v_http_cookie->LinkCustomAttributes = "";
		$this->v_http_cookie->HrefValue = "";
		$this->v_http_cookie->TooltipValue = "";

		// v_locale
		$this->v_locale->LinkCustomAttributes = "";
		$this->v_locale->HrefValue = "";
		$this->v_locale->TooltipValue = "";

		// v_useragent
		$this->v_useragent->LinkCustomAttributes = "";
		$this->v_useragent->HrefValue = "";
		$this->v_useragent->TooltipValue = "";

		// v_remote_addr
		$this->v_remote_addr->LinkCustomAttributes = "";
		$this->v_remote_addr->HrefValue = "";
		$this->v_remote_addr->TooltipValue = "";

		// v_browser
		$this->v_browser->LinkCustomAttributes = "";
		$this->v_browser->HrefValue = "";
		$this->v_browser->TooltipValue = "";

		// v_platform
		$this->v_platform->LinkCustomAttributes = "";
		$this->v_platform->HrefValue = "";
		$this->v_platform->TooltipValue = "";

		// v_version
		$this->v_version->LinkCustomAttributes = "";
		$this->v_version->HrefValue = "";
		$this->v_version->TooltipValue = "";

		// v_city
		$this->v_city->LinkCustomAttributes = "";
		$this->v_city->HrefValue = "";
		$this->v_city->TooltipValue = "";

		// v_country
		$this->v_country->LinkCustomAttributes = "";
		$this->v_country->HrefValue = "";
		$this->v_country->TooltipValue = "";

		// v_countrycode
		$this->v_countrycode->LinkCustomAttributes = "";
		$this->v_countrycode->HrefValue = "";
		$this->v_countrycode->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// aid
		$this->aid->EditAttrs["class"] = "form-control";
		$this->aid->EditCustomAttributes = "";
		$this->aid->EditValue = $this->aid->CurrentValue;
		$this->aid->ViewCustomAttributes = "";

		// v_ipaddr
		$this->v_ipaddr->EditAttrs["class"] = "form-control";
		$this->v_ipaddr->EditCustomAttributes = "";
		$this->v_ipaddr->EditValue = $this->v_ipaddr->CurrentValue;
		$this->v_ipaddr->PlaceHolder = ew_RemoveHtml($this->v_ipaddr->FldCaption());

		// v_datetime
		$this->v_datetime->EditAttrs["class"] = "form-control";
		$this->v_datetime->EditCustomAttributes = "";
		$this->v_datetime->EditValue = ew_FormatDateTime($this->v_datetime->CurrentValue, 8);
		$this->v_datetime->PlaceHolder = ew_RemoveHtml($this->v_datetime->FldCaption());

		// v_referer
		$this->v_referer->EditAttrs["class"] = "form-control";
		$this->v_referer->EditCustomAttributes = "";
		$this->v_referer->EditValue = $this->v_referer->CurrentValue;
		$this->v_referer->PlaceHolder = ew_RemoveHtml($this->v_referer->FldCaption());

		// v_language
		$this->v_language->EditAttrs["class"] = "form-control";
		$this->v_language->EditCustomAttributes = "";
		$this->v_language->EditValue = $this->v_language->CurrentValue;
		$this->v_language->PlaceHolder = ew_RemoveHtml($this->v_language->FldCaption());

		// v_http_cookie
		$this->v_http_cookie->EditAttrs["class"] = "form-control";
		$this->v_http_cookie->EditCustomAttributes = "";
		$this->v_http_cookie->EditValue = $this->v_http_cookie->CurrentValue;
		$this->v_http_cookie->PlaceHolder = ew_RemoveHtml($this->v_http_cookie->FldCaption());

		// v_locale
		$this->v_locale->EditAttrs["class"] = "form-control";
		$this->v_locale->EditCustomAttributes = "";
		$this->v_locale->EditValue = $this->v_locale->CurrentValue;
		$this->v_locale->PlaceHolder = ew_RemoveHtml($this->v_locale->FldCaption());

		// v_useragent
		$this->v_useragent->EditAttrs["class"] = "form-control";
		$this->v_useragent->EditCustomAttributes = "";
		$this->v_useragent->EditValue = $this->v_useragent->CurrentValue;
		$this->v_useragent->PlaceHolder = ew_RemoveHtml($this->v_useragent->FldCaption());

		// v_remote_addr
		$this->v_remote_addr->EditAttrs["class"] = "form-control";
		$this->v_remote_addr->EditCustomAttributes = "";
		$this->v_remote_addr->EditValue = $this->v_remote_addr->CurrentValue;
		$this->v_remote_addr->PlaceHolder = ew_RemoveHtml($this->v_remote_addr->FldCaption());

		// v_browser
		$this->v_browser->EditAttrs["class"] = "form-control";
		$this->v_browser->EditCustomAttributes = "";
		$this->v_browser->EditValue = $this->v_browser->CurrentValue;
		$this->v_browser->PlaceHolder = ew_RemoveHtml($this->v_browser->FldCaption());

		// v_platform
		$this->v_platform->EditAttrs["class"] = "form-control";
		$this->v_platform->EditCustomAttributes = "";
		$this->v_platform->EditValue = $this->v_platform->CurrentValue;
		$this->v_platform->PlaceHolder = ew_RemoveHtml($this->v_platform->FldCaption());

		// v_version
		$this->v_version->EditAttrs["class"] = "form-control";
		$this->v_version->EditCustomAttributes = "";
		$this->v_version->EditValue = $this->v_version->CurrentValue;
		$this->v_version->PlaceHolder = ew_RemoveHtml($this->v_version->FldCaption());

		// v_city
		$this->v_city->EditAttrs["class"] = "form-control";
		$this->v_city->EditCustomAttributes = "";
		$this->v_city->EditValue = $this->v_city->CurrentValue;
		$this->v_city->PlaceHolder = ew_RemoveHtml($this->v_city->FldCaption());

		// v_country
		$this->v_country->EditAttrs["class"] = "form-control";
		$this->v_country->EditCustomAttributes = "";
		$this->v_country->EditValue = $this->v_country->CurrentValue;
		$this->v_country->PlaceHolder = ew_RemoveHtml($this->v_country->FldCaption());

		// v_countrycode
		$this->v_countrycode->EditAttrs["class"] = "form-control";
		$this->v_countrycode->EditCustomAttributes = "";
		$this->v_countrycode->EditValue = $this->v_countrycode->CurrentValue;
		$this->v_countrycode->PlaceHolder = ew_RemoveHtml($this->v_countrycode->FldCaption());

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
					if ($this->aid->Exportable) $Doc->ExportCaption($this->aid);
					if ($this->v_ipaddr->Exportable) $Doc->ExportCaption($this->v_ipaddr);
					if ($this->v_datetime->Exportable) $Doc->ExportCaption($this->v_datetime);
					if ($this->v_referer->Exportable) $Doc->ExportCaption($this->v_referer);
					if ($this->v_language->Exportable) $Doc->ExportCaption($this->v_language);
					if ($this->v_http_cookie->Exportable) $Doc->ExportCaption($this->v_http_cookie);
					if ($this->v_locale->Exportable) $Doc->ExportCaption($this->v_locale);
					if ($this->v_useragent->Exportable) $Doc->ExportCaption($this->v_useragent);
					if ($this->v_remote_addr->Exportable) $Doc->ExportCaption($this->v_remote_addr);
					if ($this->v_browser->Exportable) $Doc->ExportCaption($this->v_browser);
					if ($this->v_platform->Exportable) $Doc->ExportCaption($this->v_platform);
					if ($this->v_version->Exportable) $Doc->ExportCaption($this->v_version);
					if ($this->v_city->Exportable) $Doc->ExportCaption($this->v_city);
					if ($this->v_country->Exportable) $Doc->ExportCaption($this->v_country);
					if ($this->v_countrycode->Exportable) $Doc->ExportCaption($this->v_countrycode);
				} else {
					if ($this->aid->Exportable) $Doc->ExportCaption($this->aid);
					if ($this->v_ipaddr->Exportable) $Doc->ExportCaption($this->v_ipaddr);
					if ($this->v_datetime->Exportable) $Doc->ExportCaption($this->v_datetime);
					if ($this->v_referer->Exportable) $Doc->ExportCaption($this->v_referer);
					if ($this->v_language->Exportable) $Doc->ExportCaption($this->v_language);
					if ($this->v_http_cookie->Exportable) $Doc->ExportCaption($this->v_http_cookie);
					if ($this->v_locale->Exportable) $Doc->ExportCaption($this->v_locale);
					if ($this->v_useragent->Exportable) $Doc->ExportCaption($this->v_useragent);
					if ($this->v_remote_addr->Exportable) $Doc->ExportCaption($this->v_remote_addr);
					if ($this->v_browser->Exportable) $Doc->ExportCaption($this->v_browser);
					if ($this->v_platform->Exportable) $Doc->ExportCaption($this->v_platform);
					if ($this->v_version->Exportable) $Doc->ExportCaption($this->v_version);
					if ($this->v_city->Exportable) $Doc->ExportCaption($this->v_city);
					if ($this->v_country->Exportable) $Doc->ExportCaption($this->v_country);
					if ($this->v_countrycode->Exportable) $Doc->ExportCaption($this->v_countrycode);
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
						if ($this->aid->Exportable) $Doc->ExportField($this->aid);
						if ($this->v_ipaddr->Exportable) $Doc->ExportField($this->v_ipaddr);
						if ($this->v_datetime->Exportable) $Doc->ExportField($this->v_datetime);
						if ($this->v_referer->Exportable) $Doc->ExportField($this->v_referer);
						if ($this->v_language->Exportable) $Doc->ExportField($this->v_language);
						if ($this->v_http_cookie->Exportable) $Doc->ExportField($this->v_http_cookie);
						if ($this->v_locale->Exportable) $Doc->ExportField($this->v_locale);
						if ($this->v_useragent->Exportable) $Doc->ExportField($this->v_useragent);
						if ($this->v_remote_addr->Exportable) $Doc->ExportField($this->v_remote_addr);
						if ($this->v_browser->Exportable) $Doc->ExportField($this->v_browser);
						if ($this->v_platform->Exportable) $Doc->ExportField($this->v_platform);
						if ($this->v_version->Exportable) $Doc->ExportField($this->v_version);
						if ($this->v_city->Exportable) $Doc->ExportField($this->v_city);
						if ($this->v_country->Exportable) $Doc->ExportField($this->v_country);
						if ($this->v_countrycode->Exportable) $Doc->ExportField($this->v_countrycode);
					} else {
						if ($this->aid->Exportable) $Doc->ExportField($this->aid);
						if ($this->v_ipaddr->Exportable) $Doc->ExportField($this->v_ipaddr);
						if ($this->v_datetime->Exportable) $Doc->ExportField($this->v_datetime);
						if ($this->v_referer->Exportable) $Doc->ExportField($this->v_referer);
						if ($this->v_language->Exportable) $Doc->ExportField($this->v_language);
						if ($this->v_http_cookie->Exportable) $Doc->ExportField($this->v_http_cookie);
						if ($this->v_locale->Exportable) $Doc->ExportField($this->v_locale);
						if ($this->v_useragent->Exportable) $Doc->ExportField($this->v_useragent);
						if ($this->v_remote_addr->Exportable) $Doc->ExportField($this->v_remote_addr);
						if ($this->v_browser->Exportable) $Doc->ExportField($this->v_browser);
						if ($this->v_platform->Exportable) $Doc->ExportField($this->v_platform);
						if ($this->v_version->Exportable) $Doc->ExportField($this->v_version);
						if ($this->v_city->Exportable) $Doc->ExportField($this->v_city);
						if ($this->v_country->Exportable) $Doc->ExportField($this->v_country);
						if ($this->v_countrycode->Exportable) $Doc->ExportField($this->v_countrycode);
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
