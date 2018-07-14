<?php

// Global variable for table object
$bpeng = NULL;

//
// Table class for bpeng
//
class cbpeng extends cTable {
	var $tgl;
	var $noper;
	var $nobuk;
	var $keg;
	var $bud;
	var $ket;
	var $jumlahd;
	var $jumlahk;
	var $chek;
	var $debkre;
	var $post;
	var $foll;
	var $jns;
	var $jp;
	var $spm;
	var $spm1;
	var $ppn;
	var $ps21;
	var $ps22;
	var $ps23;
	var $ps24;
	var $ps4;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'bpeng';
		$this->TableName = 'bpeng';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`bpeng`";
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

		// tgl
		$this->tgl = new cField('bpeng', 'bpeng', 'x_tgl', 'tgl', '`tgl`', ew_CastDateFieldForLike('`tgl`', 0, "DB"), 135, 0, FALSE, '`tgl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl->Sortable = TRUE; // Allow sort
		$this->tgl->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl'] = &$this->tgl;

		// noper
		$this->noper = new cField('bpeng', 'bpeng', 'x_noper', 'noper', '`noper`', '`noper`', 200, -1, FALSE, '`noper`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->noper->Sortable = TRUE; // Allow sort
		$this->fields['noper'] = &$this->noper;

		// nobuk
		$this->nobuk = new cField('bpeng', 'bpeng', 'x_nobuk', 'nobuk', '`nobuk`', '`nobuk`', 200, -1, FALSE, '`nobuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nobuk->Sortable = TRUE; // Allow sort
		$this->fields['nobuk'] = &$this->nobuk;

		// keg
		$this->keg = new cField('bpeng', 'bpeng', 'x_keg', 'keg', '`keg`', '`keg`', 200, -1, FALSE, '`keg`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keg->Sortable = TRUE; // Allow sort
		$this->fields['keg'] = &$this->keg;

		// bud
		$this->bud = new cField('bpeng', 'bpeng', 'x_bud', 'bud', '`bud`', '`bud`', 200, -1, FALSE, '`bud`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bud->Sortable = TRUE; // Allow sort
		$this->fields['bud'] = &$this->bud;

		// ket
		$this->ket = new cField('bpeng', 'bpeng', 'x_ket', 'ket', '`ket`', '`ket`', 200, -1, FALSE, '`ket`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket->Sortable = TRUE; // Allow sort
		$this->fields['ket'] = &$this->ket;

		// jumlahd
		$this->jumlahd = new cField('bpeng', 'bpeng', 'x_jumlahd', 'jumlahd', '`jumlahd`', '`jumlahd`', 20, -1, FALSE, '`jumlahd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlahd->Sortable = TRUE; // Allow sort
		$this->jumlahd->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlahd'] = &$this->jumlahd;

		// jumlahk
		$this->jumlahk = new cField('bpeng', 'bpeng', 'x_jumlahk', 'jumlahk', '`jumlahk`', '`jumlahk`', 20, -1, FALSE, '`jumlahk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlahk->Sortable = TRUE; // Allow sort
		$this->jumlahk->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlahk'] = &$this->jumlahk;

		// chek
		$this->chek = new cField('bpeng', 'bpeng', 'x_chek', 'chek', '`chek`', '`chek`', 200, -1, FALSE, '`chek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->chek->Sortable = TRUE; // Allow sort
		$this->fields['chek'] = &$this->chek;

		// debkre
		$this->debkre = new cField('bpeng', 'bpeng', 'x_debkre', 'debkre', '`debkre`', '`debkre`', 200, -1, FALSE, '`debkre`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->debkre->Sortable = TRUE; // Allow sort
		$this->fields['debkre'] = &$this->debkre;

		// post
		$this->post = new cField('bpeng', 'bpeng', 'x_post', 'post', '`post`', '`post`', 200, -1, FALSE, '`post`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->post->Sortable = TRUE; // Allow sort
		$this->fields['post'] = &$this->post;

		// foll
		$this->foll = new cField('bpeng', 'bpeng', 'x_foll', 'foll', '`foll`', '`foll`', 200, -1, FALSE, '`foll`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->foll->Sortable = TRUE; // Allow sort
		$this->fields['foll'] = &$this->foll;

		// jns
		$this->jns = new cField('bpeng', 'bpeng', 'x_jns', 'jns', '`jns`', '`jns`', 200, -1, FALSE, '`jns`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jns->Sortable = TRUE; // Allow sort
		$this->fields['jns'] = &$this->jns;

		// jp
		$this->jp = new cField('bpeng', 'bpeng', 'x_jp', 'jp', '`jp`', '`jp`', 200, -1, FALSE, '`jp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jp->Sortable = TRUE; // Allow sort
		$this->fields['jp'] = &$this->jp;

		// spm
		$this->spm = new cField('bpeng', 'bpeng', 'x_spm', 'spm', '`spm`', '`spm`', 200, -1, FALSE, '`spm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->spm->Sortable = TRUE; // Allow sort
		$this->fields['spm'] = &$this->spm;

		// spm1
		$this->spm1 = new cField('bpeng', 'bpeng', 'x_spm1', 'spm1', '`spm1`', '`spm1`', 200, -1, FALSE, '`spm1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->spm1->Sortable = TRUE; // Allow sort
		$this->fields['spm1'] = &$this->spm1;

		// ppn
		$this->ppn = new cField('bpeng', 'bpeng', 'x_ppn', 'ppn', '`ppn`', '`ppn`', 20, -1, FALSE, '`ppn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ppn->Sortable = TRUE; // Allow sort
		$this->ppn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ppn'] = &$this->ppn;

		// ps21
		$this->ps21 = new cField('bpeng', 'bpeng', 'x_ps21', 'ps21', '`ps21`', '`ps21`', 20, -1, FALSE, '`ps21`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps21->Sortable = TRUE; // Allow sort
		$this->ps21->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps21'] = &$this->ps21;

		// ps22
		$this->ps22 = new cField('bpeng', 'bpeng', 'x_ps22', 'ps22', '`ps22`', '`ps22`', 20, -1, FALSE, '`ps22`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps22->Sortable = TRUE; // Allow sort
		$this->ps22->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps22'] = &$this->ps22;

		// ps23
		$this->ps23 = new cField('bpeng', 'bpeng', 'x_ps23', 'ps23', '`ps23`', '`ps23`', 20, -1, FALSE, '`ps23`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps23->Sortable = TRUE; // Allow sort
		$this->ps23->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps23'] = &$this->ps23;

		// ps24
		$this->ps24 = new cField('bpeng', 'bpeng', 'x_ps24', 'ps24', '`ps24`', '`ps24`', 20, -1, FALSE, '`ps24`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps24->Sortable = TRUE; // Allow sort
		$this->ps24->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps24'] = &$this->ps24;

		// ps4
		$this->ps4 = new cField('bpeng', 'bpeng', 'x_ps4', 'ps4', '`ps4`', '`ps4`', 20, -1, FALSE, '`ps4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps4->Sortable = TRUE; // Allow sort
		$this->ps4->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps4'] = &$this->ps4;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`bpeng`";
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
			return "bpenglist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "bpenglist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("bpengview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("bpengview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "bpengadd.php?" . $this->UrlParm($parm);
		else
			$url = "bpengadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("bpengedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("bpengadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("bpengdelete.php", $this->UrlParm());
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
		$this->tgl->setDbValue($rs->fields('tgl'));
		$this->noper->setDbValue($rs->fields('noper'));
		$this->nobuk->setDbValue($rs->fields('nobuk'));
		$this->keg->setDbValue($rs->fields('keg'));
		$this->bud->setDbValue($rs->fields('bud'));
		$this->ket->setDbValue($rs->fields('ket'));
		$this->jumlahd->setDbValue($rs->fields('jumlahd'));
		$this->jumlahk->setDbValue($rs->fields('jumlahk'));
		$this->chek->setDbValue($rs->fields('chek'));
		$this->debkre->setDbValue($rs->fields('debkre'));
		$this->post->setDbValue($rs->fields('post'));
		$this->foll->setDbValue($rs->fields('foll'));
		$this->jns->setDbValue($rs->fields('jns'));
		$this->jp->setDbValue($rs->fields('jp'));
		$this->spm->setDbValue($rs->fields('spm'));
		$this->spm1->setDbValue($rs->fields('spm1'));
		$this->ppn->setDbValue($rs->fields('ppn'));
		$this->ps21->setDbValue($rs->fields('ps21'));
		$this->ps22->setDbValue($rs->fields('ps22'));
		$this->ps23->setDbValue($rs->fields('ps23'));
		$this->ps24->setDbValue($rs->fields('ps24'));
		$this->ps4->setDbValue($rs->fields('ps4'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// tgl
		// noper
		// nobuk
		// keg
		// bud
		// ket
		// jumlahd
		// jumlahk
		// chek
		// debkre
		// post
		// foll
		// jns
		// jp
		// spm
		// spm1
		// ppn
		// ps21
		// ps22
		// ps23
		// ps24
		// ps4
		// tgl

		$this->tgl->ViewValue = $this->tgl->CurrentValue;
		$this->tgl->ViewValue = ew_FormatDateTime($this->tgl->ViewValue, 0);
		$this->tgl->ViewCustomAttributes = "";

		// noper
		$this->noper->ViewValue = $this->noper->CurrentValue;
		$this->noper->ViewCustomAttributes = "";

		// nobuk
		$this->nobuk->ViewValue = $this->nobuk->CurrentValue;
		$this->nobuk->ViewCustomAttributes = "";

		// keg
		$this->keg->ViewValue = $this->keg->CurrentValue;
		$this->keg->ViewCustomAttributes = "";

		// bud
		$this->bud->ViewValue = $this->bud->CurrentValue;
		$this->bud->ViewCustomAttributes = "";

		// ket
		$this->ket->ViewValue = $this->ket->CurrentValue;
		$this->ket->ViewCustomAttributes = "";

		// jumlahd
		$this->jumlahd->ViewValue = $this->jumlahd->CurrentValue;
		$this->jumlahd->ViewCustomAttributes = "";

		// jumlahk
		$this->jumlahk->ViewValue = $this->jumlahk->CurrentValue;
		$this->jumlahk->ViewCustomAttributes = "";

		// chek
		$this->chek->ViewValue = $this->chek->CurrentValue;
		$this->chek->ViewCustomAttributes = "";

		// debkre
		$this->debkre->ViewValue = $this->debkre->CurrentValue;
		$this->debkre->ViewCustomAttributes = "";

		// post
		$this->post->ViewValue = $this->post->CurrentValue;
		$this->post->ViewCustomAttributes = "";

		// foll
		$this->foll->ViewValue = $this->foll->CurrentValue;
		$this->foll->ViewCustomAttributes = "";

		// jns
		$this->jns->ViewValue = $this->jns->CurrentValue;
		$this->jns->ViewCustomAttributes = "";

		// jp
		$this->jp->ViewValue = $this->jp->CurrentValue;
		$this->jp->ViewCustomAttributes = "";

		// spm
		$this->spm->ViewValue = $this->spm->CurrentValue;
		$this->spm->ViewCustomAttributes = "";

		// spm1
		$this->spm1->ViewValue = $this->spm1->CurrentValue;
		$this->spm1->ViewCustomAttributes = "";

		// ppn
		$this->ppn->ViewValue = $this->ppn->CurrentValue;
		$this->ppn->ViewCustomAttributes = "";

		// ps21
		$this->ps21->ViewValue = $this->ps21->CurrentValue;
		$this->ps21->ViewCustomAttributes = "";

		// ps22
		$this->ps22->ViewValue = $this->ps22->CurrentValue;
		$this->ps22->ViewCustomAttributes = "";

		// ps23
		$this->ps23->ViewValue = $this->ps23->CurrentValue;
		$this->ps23->ViewCustomAttributes = "";

		// ps24
		$this->ps24->ViewValue = $this->ps24->CurrentValue;
		$this->ps24->ViewCustomAttributes = "";

		// ps4
		$this->ps4->ViewValue = $this->ps4->CurrentValue;
		$this->ps4->ViewCustomAttributes = "";

		// tgl
		$this->tgl->LinkCustomAttributes = "";
		$this->tgl->HrefValue = "";
		$this->tgl->TooltipValue = "";

		// noper
		$this->noper->LinkCustomAttributes = "";
		$this->noper->HrefValue = "";
		$this->noper->TooltipValue = "";

		// nobuk
		$this->nobuk->LinkCustomAttributes = "";
		$this->nobuk->HrefValue = "";
		$this->nobuk->TooltipValue = "";

		// keg
		$this->keg->LinkCustomAttributes = "";
		$this->keg->HrefValue = "";
		$this->keg->TooltipValue = "";

		// bud
		$this->bud->LinkCustomAttributes = "";
		$this->bud->HrefValue = "";
		$this->bud->TooltipValue = "";

		// ket
		$this->ket->LinkCustomAttributes = "";
		$this->ket->HrefValue = "";
		$this->ket->TooltipValue = "";

		// jumlahd
		$this->jumlahd->LinkCustomAttributes = "";
		$this->jumlahd->HrefValue = "";
		$this->jumlahd->TooltipValue = "";

		// jumlahk
		$this->jumlahk->LinkCustomAttributes = "";
		$this->jumlahk->HrefValue = "";
		$this->jumlahk->TooltipValue = "";

		// chek
		$this->chek->LinkCustomAttributes = "";
		$this->chek->HrefValue = "";
		$this->chek->TooltipValue = "";

		// debkre
		$this->debkre->LinkCustomAttributes = "";
		$this->debkre->HrefValue = "";
		$this->debkre->TooltipValue = "";

		// post
		$this->post->LinkCustomAttributes = "";
		$this->post->HrefValue = "";
		$this->post->TooltipValue = "";

		// foll
		$this->foll->LinkCustomAttributes = "";
		$this->foll->HrefValue = "";
		$this->foll->TooltipValue = "";

		// jns
		$this->jns->LinkCustomAttributes = "";
		$this->jns->HrefValue = "";
		$this->jns->TooltipValue = "";

		// jp
		$this->jp->LinkCustomAttributes = "";
		$this->jp->HrefValue = "";
		$this->jp->TooltipValue = "";

		// spm
		$this->spm->LinkCustomAttributes = "";
		$this->spm->HrefValue = "";
		$this->spm->TooltipValue = "";

		// spm1
		$this->spm1->LinkCustomAttributes = "";
		$this->spm1->HrefValue = "";
		$this->spm1->TooltipValue = "";

		// ppn
		$this->ppn->LinkCustomAttributes = "";
		$this->ppn->HrefValue = "";
		$this->ppn->TooltipValue = "";

		// ps21
		$this->ps21->LinkCustomAttributes = "";
		$this->ps21->HrefValue = "";
		$this->ps21->TooltipValue = "";

		// ps22
		$this->ps22->LinkCustomAttributes = "";
		$this->ps22->HrefValue = "";
		$this->ps22->TooltipValue = "";

		// ps23
		$this->ps23->LinkCustomAttributes = "";
		$this->ps23->HrefValue = "";
		$this->ps23->TooltipValue = "";

		// ps24
		$this->ps24->LinkCustomAttributes = "";
		$this->ps24->HrefValue = "";
		$this->ps24->TooltipValue = "";

		// ps4
		$this->ps4->LinkCustomAttributes = "";
		$this->ps4->HrefValue = "";
		$this->ps4->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// tgl
		$this->tgl->EditAttrs["class"] = "form-control";
		$this->tgl->EditCustomAttributes = "";
		$this->tgl->EditValue = ew_FormatDateTime($this->tgl->CurrentValue, 8);
		$this->tgl->PlaceHolder = ew_RemoveHtml($this->tgl->FldCaption());

		// noper
		$this->noper->EditAttrs["class"] = "form-control";
		$this->noper->EditCustomAttributes = "";
		$this->noper->EditValue = $this->noper->CurrentValue;
		$this->noper->PlaceHolder = ew_RemoveHtml($this->noper->FldCaption());

		// nobuk
		$this->nobuk->EditAttrs["class"] = "form-control";
		$this->nobuk->EditCustomAttributes = "";
		$this->nobuk->EditValue = $this->nobuk->CurrentValue;
		$this->nobuk->PlaceHolder = ew_RemoveHtml($this->nobuk->FldCaption());

		// keg
		$this->keg->EditAttrs["class"] = "form-control";
		$this->keg->EditCustomAttributes = "";
		$this->keg->EditValue = $this->keg->CurrentValue;
		$this->keg->PlaceHolder = ew_RemoveHtml($this->keg->FldCaption());

		// bud
		$this->bud->EditAttrs["class"] = "form-control";
		$this->bud->EditCustomAttributes = "";
		$this->bud->EditValue = $this->bud->CurrentValue;
		$this->bud->PlaceHolder = ew_RemoveHtml($this->bud->FldCaption());

		// ket
		$this->ket->EditAttrs["class"] = "form-control";
		$this->ket->EditCustomAttributes = "";
		$this->ket->EditValue = $this->ket->CurrentValue;
		$this->ket->PlaceHolder = ew_RemoveHtml($this->ket->FldCaption());

		// jumlahd
		$this->jumlahd->EditAttrs["class"] = "form-control";
		$this->jumlahd->EditCustomAttributes = "";
		$this->jumlahd->EditValue = $this->jumlahd->CurrentValue;
		$this->jumlahd->PlaceHolder = ew_RemoveHtml($this->jumlahd->FldCaption());

		// jumlahk
		$this->jumlahk->EditAttrs["class"] = "form-control";
		$this->jumlahk->EditCustomAttributes = "";
		$this->jumlahk->EditValue = $this->jumlahk->CurrentValue;
		$this->jumlahk->PlaceHolder = ew_RemoveHtml($this->jumlahk->FldCaption());

		// chek
		$this->chek->EditAttrs["class"] = "form-control";
		$this->chek->EditCustomAttributes = "";
		$this->chek->EditValue = $this->chek->CurrentValue;
		$this->chek->PlaceHolder = ew_RemoveHtml($this->chek->FldCaption());

		// debkre
		$this->debkre->EditAttrs["class"] = "form-control";
		$this->debkre->EditCustomAttributes = "";
		$this->debkre->EditValue = $this->debkre->CurrentValue;
		$this->debkre->PlaceHolder = ew_RemoveHtml($this->debkre->FldCaption());

		// post
		$this->post->EditAttrs["class"] = "form-control";
		$this->post->EditCustomAttributes = "";
		$this->post->EditValue = $this->post->CurrentValue;
		$this->post->PlaceHolder = ew_RemoveHtml($this->post->FldCaption());

		// foll
		$this->foll->EditAttrs["class"] = "form-control";
		$this->foll->EditCustomAttributes = "";
		$this->foll->EditValue = $this->foll->CurrentValue;
		$this->foll->PlaceHolder = ew_RemoveHtml($this->foll->FldCaption());

		// jns
		$this->jns->EditAttrs["class"] = "form-control";
		$this->jns->EditCustomAttributes = "";
		$this->jns->EditValue = $this->jns->CurrentValue;
		$this->jns->PlaceHolder = ew_RemoveHtml($this->jns->FldCaption());

		// jp
		$this->jp->EditAttrs["class"] = "form-control";
		$this->jp->EditCustomAttributes = "";
		$this->jp->EditValue = $this->jp->CurrentValue;
		$this->jp->PlaceHolder = ew_RemoveHtml($this->jp->FldCaption());

		// spm
		$this->spm->EditAttrs["class"] = "form-control";
		$this->spm->EditCustomAttributes = "";
		$this->spm->EditValue = $this->spm->CurrentValue;
		$this->spm->PlaceHolder = ew_RemoveHtml($this->spm->FldCaption());

		// spm1
		$this->spm1->EditAttrs["class"] = "form-control";
		$this->spm1->EditCustomAttributes = "";
		$this->spm1->EditValue = $this->spm1->CurrentValue;
		$this->spm1->PlaceHolder = ew_RemoveHtml($this->spm1->FldCaption());

		// ppn
		$this->ppn->EditAttrs["class"] = "form-control";
		$this->ppn->EditCustomAttributes = "";
		$this->ppn->EditValue = $this->ppn->CurrentValue;
		$this->ppn->PlaceHolder = ew_RemoveHtml($this->ppn->FldCaption());

		// ps21
		$this->ps21->EditAttrs["class"] = "form-control";
		$this->ps21->EditCustomAttributes = "";
		$this->ps21->EditValue = $this->ps21->CurrentValue;
		$this->ps21->PlaceHolder = ew_RemoveHtml($this->ps21->FldCaption());

		// ps22
		$this->ps22->EditAttrs["class"] = "form-control";
		$this->ps22->EditCustomAttributes = "";
		$this->ps22->EditValue = $this->ps22->CurrentValue;
		$this->ps22->PlaceHolder = ew_RemoveHtml($this->ps22->FldCaption());

		// ps23
		$this->ps23->EditAttrs["class"] = "form-control";
		$this->ps23->EditCustomAttributes = "";
		$this->ps23->EditValue = $this->ps23->CurrentValue;
		$this->ps23->PlaceHolder = ew_RemoveHtml($this->ps23->FldCaption());

		// ps24
		$this->ps24->EditAttrs["class"] = "form-control";
		$this->ps24->EditCustomAttributes = "";
		$this->ps24->EditValue = $this->ps24->CurrentValue;
		$this->ps24->PlaceHolder = ew_RemoveHtml($this->ps24->FldCaption());

		// ps4
		$this->ps4->EditAttrs["class"] = "form-control";
		$this->ps4->EditCustomAttributes = "";
		$this->ps4->EditValue = $this->ps4->CurrentValue;
		$this->ps4->PlaceHolder = ew_RemoveHtml($this->ps4->FldCaption());

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
					if ($this->tgl->Exportable) $Doc->ExportCaption($this->tgl);
					if ($this->noper->Exportable) $Doc->ExportCaption($this->noper);
					if ($this->nobuk->Exportable) $Doc->ExportCaption($this->nobuk);
					if ($this->keg->Exportable) $Doc->ExportCaption($this->keg);
					if ($this->bud->Exportable) $Doc->ExportCaption($this->bud);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->jumlahd->Exportable) $Doc->ExportCaption($this->jumlahd);
					if ($this->jumlahk->Exportable) $Doc->ExportCaption($this->jumlahk);
					if ($this->chek->Exportable) $Doc->ExportCaption($this->chek);
					if ($this->debkre->Exportable) $Doc->ExportCaption($this->debkre);
					if ($this->post->Exportable) $Doc->ExportCaption($this->post);
					if ($this->foll->Exportable) $Doc->ExportCaption($this->foll);
					if ($this->jns->Exportable) $Doc->ExportCaption($this->jns);
					if ($this->jp->Exportable) $Doc->ExportCaption($this->jp);
					if ($this->spm->Exportable) $Doc->ExportCaption($this->spm);
					if ($this->spm1->Exportable) $Doc->ExportCaption($this->spm1);
					if ($this->ppn->Exportable) $Doc->ExportCaption($this->ppn);
					if ($this->ps21->Exportable) $Doc->ExportCaption($this->ps21);
					if ($this->ps22->Exportable) $Doc->ExportCaption($this->ps22);
					if ($this->ps23->Exportable) $Doc->ExportCaption($this->ps23);
					if ($this->ps24->Exportable) $Doc->ExportCaption($this->ps24);
					if ($this->ps4->Exportable) $Doc->ExportCaption($this->ps4);
				} else {
					if ($this->tgl->Exportable) $Doc->ExportCaption($this->tgl);
					if ($this->noper->Exportable) $Doc->ExportCaption($this->noper);
					if ($this->nobuk->Exportable) $Doc->ExportCaption($this->nobuk);
					if ($this->keg->Exportable) $Doc->ExportCaption($this->keg);
					if ($this->bud->Exportable) $Doc->ExportCaption($this->bud);
					if ($this->ket->Exportable) $Doc->ExportCaption($this->ket);
					if ($this->jumlahd->Exportable) $Doc->ExportCaption($this->jumlahd);
					if ($this->jumlahk->Exportable) $Doc->ExportCaption($this->jumlahk);
					if ($this->chek->Exportable) $Doc->ExportCaption($this->chek);
					if ($this->debkre->Exportable) $Doc->ExportCaption($this->debkre);
					if ($this->post->Exportable) $Doc->ExportCaption($this->post);
					if ($this->foll->Exportable) $Doc->ExportCaption($this->foll);
					if ($this->jns->Exportable) $Doc->ExportCaption($this->jns);
					if ($this->jp->Exportable) $Doc->ExportCaption($this->jp);
					if ($this->spm->Exportable) $Doc->ExportCaption($this->spm);
					if ($this->spm1->Exportable) $Doc->ExportCaption($this->spm1);
					if ($this->ppn->Exportable) $Doc->ExportCaption($this->ppn);
					if ($this->ps21->Exportable) $Doc->ExportCaption($this->ps21);
					if ($this->ps22->Exportable) $Doc->ExportCaption($this->ps22);
					if ($this->ps23->Exportable) $Doc->ExportCaption($this->ps23);
					if ($this->ps24->Exportable) $Doc->ExportCaption($this->ps24);
					if ($this->ps4->Exportable) $Doc->ExportCaption($this->ps4);
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
						if ($this->tgl->Exportable) $Doc->ExportField($this->tgl);
						if ($this->noper->Exportable) $Doc->ExportField($this->noper);
						if ($this->nobuk->Exportable) $Doc->ExportField($this->nobuk);
						if ($this->keg->Exportable) $Doc->ExportField($this->keg);
						if ($this->bud->Exportable) $Doc->ExportField($this->bud);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->jumlahd->Exportable) $Doc->ExportField($this->jumlahd);
						if ($this->jumlahk->Exportable) $Doc->ExportField($this->jumlahk);
						if ($this->chek->Exportable) $Doc->ExportField($this->chek);
						if ($this->debkre->Exportable) $Doc->ExportField($this->debkre);
						if ($this->post->Exportable) $Doc->ExportField($this->post);
						if ($this->foll->Exportable) $Doc->ExportField($this->foll);
						if ($this->jns->Exportable) $Doc->ExportField($this->jns);
						if ($this->jp->Exportable) $Doc->ExportField($this->jp);
						if ($this->spm->Exportable) $Doc->ExportField($this->spm);
						if ($this->spm1->Exportable) $Doc->ExportField($this->spm1);
						if ($this->ppn->Exportable) $Doc->ExportField($this->ppn);
						if ($this->ps21->Exportable) $Doc->ExportField($this->ps21);
						if ($this->ps22->Exportable) $Doc->ExportField($this->ps22);
						if ($this->ps23->Exportable) $Doc->ExportField($this->ps23);
						if ($this->ps24->Exportable) $Doc->ExportField($this->ps24);
						if ($this->ps4->Exportable) $Doc->ExportField($this->ps4);
					} else {
						if ($this->tgl->Exportable) $Doc->ExportField($this->tgl);
						if ($this->noper->Exportable) $Doc->ExportField($this->noper);
						if ($this->nobuk->Exportable) $Doc->ExportField($this->nobuk);
						if ($this->keg->Exportable) $Doc->ExportField($this->keg);
						if ($this->bud->Exportable) $Doc->ExportField($this->bud);
						if ($this->ket->Exportable) $Doc->ExportField($this->ket);
						if ($this->jumlahd->Exportable) $Doc->ExportField($this->jumlahd);
						if ($this->jumlahk->Exportable) $Doc->ExportField($this->jumlahk);
						if ($this->chek->Exportable) $Doc->ExportField($this->chek);
						if ($this->debkre->Exportable) $Doc->ExportField($this->debkre);
						if ($this->post->Exportable) $Doc->ExportField($this->post);
						if ($this->foll->Exportable) $Doc->ExportField($this->foll);
						if ($this->jns->Exportable) $Doc->ExportField($this->jns);
						if ($this->jp->Exportable) $Doc->ExportField($this->jp);
						if ($this->spm->Exportable) $Doc->ExportField($this->spm);
						if ($this->spm1->Exportable) $Doc->ExportField($this->spm1);
						if ($this->ppn->Exportable) $Doc->ExportField($this->ppn);
						if ($this->ps21->Exportable) $Doc->ExportField($this->ps21);
						if ($this->ps22->Exportable) $Doc->ExportField($this->ps22);
						if ($this->ps23->Exportable) $Doc->ExportField($this->ps23);
						if ($this->ps24->Exportable) $Doc->ExportField($this->ps24);
						if ($this->ps4->Exportable) $Doc->ExportField($this->ps4);
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
