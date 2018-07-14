<?php

// Global variable for table object
$vw_bill_ranap_data_tarif_tindakan = NULL;

//
// Table class for vw_bill_ranap_data_tarif_tindakan
//
class cvw_bill_ranap_data_tarif_tindakan extends cTable {
	var $id;
	var $kode;
	var $nama_tindakan;
	var $nama_kelompok_tindakan;
	var $nama_sub_kelompok1;
	var $nama_sub_kelompok2;
	var $kelompok_tindakan;
	var $sub_kelompok1;
	var $sub_kelompok2;
	var $kelas;
	var $tarif;
	var $bhp;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_bill_ranap_data_tarif_tindakan';
		$this->TableName = 'vw_bill_ranap_data_tarif_tindakan';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_bill_ranap_data_tarif_tindakan`";
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
		$this->id = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// kode
		$this->kode = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_kode', 'kode', '`kode`', '`kode`', 3, -1, FALSE, '`kode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode->Sortable = TRUE; // Allow sort
		$this->kode->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kode'] = &$this->kode;

		// nama_tindakan
		$this->nama_tindakan = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_nama_tindakan', 'nama_tindakan', '`nama_tindakan`', '`nama_tindakan`', 200, -1, FALSE, '`nama_tindakan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_tindakan->Sortable = TRUE; // Allow sort
		$this->fields['nama_tindakan'] = &$this->nama_tindakan;

		// nama_kelompok_tindakan
		$this->nama_kelompok_tindakan = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_nama_kelompok_tindakan', 'nama_kelompok_tindakan', '`nama_kelompok_tindakan`', '`nama_kelompok_tindakan`', 200, -1, FALSE, '`nama_kelompok_tindakan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_kelompok_tindakan->Sortable = TRUE; // Allow sort
		$this->fields['nama_kelompok_tindakan'] = &$this->nama_kelompok_tindakan;

		// nama_sub_kelompok1
		$this->nama_sub_kelompok1 = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_nama_sub_kelompok1', 'nama_sub_kelompok1', '`nama_sub_kelompok1`', '`nama_sub_kelompok1`', 200, -1, FALSE, '`nama_sub_kelompok1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_sub_kelompok1->Sortable = TRUE; // Allow sort
		$this->fields['nama_sub_kelompok1'] = &$this->nama_sub_kelompok1;

		// nama_sub_kelompok2
		$this->nama_sub_kelompok2 = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_nama_sub_kelompok2', 'nama_sub_kelompok2', '`nama_sub_kelompok2`', '`nama_sub_kelompok2`', 200, -1, FALSE, '`nama_sub_kelompok2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_sub_kelompok2->Sortable = TRUE; // Allow sort
		$this->fields['nama_sub_kelompok2'] = &$this->nama_sub_kelompok2;

		// kelompok_tindakan
		$this->kelompok_tindakan = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_kelompok_tindakan', 'kelompok_tindakan', '`kelompok_tindakan`', '`kelompok_tindakan`', 3, -1, FALSE, '`kelompok_tindakan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelompok_tindakan->Sortable = TRUE; // Allow sort
		$this->kelompok_tindakan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelompok_tindakan'] = &$this->kelompok_tindakan;

		// sub_kelompok1
		$this->sub_kelompok1 = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_sub_kelompok1', 'sub_kelompok1', '`sub_kelompok1`', '`sub_kelompok1`', 3, -1, FALSE, '`sub_kelompok1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sub_kelompok1->Sortable = TRUE; // Allow sort
		$this->sub_kelompok1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sub_kelompok1'] = &$this->sub_kelompok1;

		// sub_kelompok2
		$this->sub_kelompok2 = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_sub_kelompok2', 'sub_kelompok2', '`sub_kelompok2`', '`sub_kelompok2`', 3, -1, FALSE, '`sub_kelompok2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sub_kelompok2->Sortable = TRUE; // Allow sort
		$this->sub_kelompok2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sub_kelompok2'] = &$this->sub_kelompok2;

		// kelas
		$this->kelas = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_kelas', 'kelas', '`kelas`', '`kelas`', 3, -1, FALSE, '`kelas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelas->Sortable = TRUE; // Allow sort
		$this->kelas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelas'] = &$this->kelas;

		// tarif
		$this->tarif = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_tarif', 'tarif', '`tarif`', '`tarif`', 5, -1, FALSE, '`tarif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tarif->Sortable = TRUE; // Allow sort
		$this->tarif->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['tarif'] = &$this->tarif;

		// bhp
		$this->bhp = new cField('vw_bill_ranap_data_tarif_tindakan', 'vw_bill_ranap_data_tarif_tindakan', 'x_bhp', 'bhp', '`bhp`', '`bhp`', 5, -1, FALSE, '`bhp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bhp->Sortable = TRUE; // Allow sort
		$this->bhp->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['bhp'] = &$this->bhp;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_bill_ranap_data_tarif_tindakan`";
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
			return "vw_bill_ranap_data_tarif_tindakanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_bill_ranap_data_tarif_tindakanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_bill_ranap_data_tarif_tindakanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_bill_ranap_data_tarif_tindakanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_bill_ranap_data_tarif_tindakanadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_bill_ranap_data_tarif_tindakanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_bill_ranap_data_tarif_tindakanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_bill_ranap_data_tarif_tindakanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_bill_ranap_data_tarif_tindakandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
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
		$this->kode->setDbValue($rs->fields('kode'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->nama_kelompok_tindakan->setDbValue($rs->fields('nama_kelompok_tindakan'));
		$this->nama_sub_kelompok1->setDbValue($rs->fields('nama_sub_kelompok1'));
		$this->nama_sub_kelompok2->setDbValue($rs->fields('nama_sub_kelompok2'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->sub_kelompok1->setDbValue($rs->fields('sub_kelompok1'));
		$this->sub_kelompok2->setDbValue($rs->fields('sub_kelompok2'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->bhp->setDbValue($rs->fields('bhp'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// kode
		// nama_tindakan
		// nama_kelompok_tindakan
		// nama_sub_kelompok1
		// nama_sub_kelompok2
		// kelompok_tindakan
		// sub_kelompok1
		// sub_kelompok2
		// kelas
		// tarif
		// bhp
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// kode
		$this->kode->ViewValue = $this->kode->CurrentValue;
		$this->kode->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// nama_kelompok_tindakan
		$this->nama_kelompok_tindakan->ViewValue = $this->nama_kelompok_tindakan->CurrentValue;
		$this->nama_kelompok_tindakan->ViewCustomAttributes = "";

		// nama_sub_kelompok1
		$this->nama_sub_kelompok1->ViewValue = $this->nama_sub_kelompok1->CurrentValue;
		$this->nama_sub_kelompok1->ViewCustomAttributes = "";

		// nama_sub_kelompok2
		$this->nama_sub_kelompok2->ViewValue = $this->nama_sub_kelompok2->CurrentValue;
		$this->nama_sub_kelompok2->ViewCustomAttributes = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// sub_kelompok1
		$this->sub_kelompok1->ViewValue = $this->sub_kelompok1->CurrentValue;
		$this->sub_kelompok1->ViewCustomAttributes = "";

		// sub_kelompok2
		$this->sub_kelompok2->ViewValue = $this->sub_kelompok2->CurrentValue;
		$this->sub_kelompok2->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// kode
		$this->kode->LinkCustomAttributes = "";
		$this->kode->HrefValue = "";
		$this->kode->TooltipValue = "";

		// nama_tindakan
		$this->nama_tindakan->LinkCustomAttributes = "";
		$this->nama_tindakan->HrefValue = "";
		$this->nama_tindakan->TooltipValue = "";

		// nama_kelompok_tindakan
		$this->nama_kelompok_tindakan->LinkCustomAttributes = "";
		$this->nama_kelompok_tindakan->HrefValue = "";
		$this->nama_kelompok_tindakan->TooltipValue = "";

		// nama_sub_kelompok1
		$this->nama_sub_kelompok1->LinkCustomAttributes = "";
		$this->nama_sub_kelompok1->HrefValue = "";
		$this->nama_sub_kelompok1->TooltipValue = "";

		// nama_sub_kelompok2
		$this->nama_sub_kelompok2->LinkCustomAttributes = "";
		$this->nama_sub_kelompok2->HrefValue = "";
		$this->nama_sub_kelompok2->TooltipValue = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->LinkCustomAttributes = "";
		$this->kelompok_tindakan->HrefValue = "";
		$this->kelompok_tindakan->TooltipValue = "";

		// sub_kelompok1
		$this->sub_kelompok1->LinkCustomAttributes = "";
		$this->sub_kelompok1->HrefValue = "";
		$this->sub_kelompok1->TooltipValue = "";

		// sub_kelompok2
		$this->sub_kelompok2->LinkCustomAttributes = "";
		$this->sub_kelompok2->HrefValue = "";
		$this->sub_kelompok2->TooltipValue = "";

		// kelas
		$this->kelas->LinkCustomAttributes = "";
		$this->kelas->HrefValue = "";
		$this->kelas->TooltipValue = "";

		// tarif
		$this->tarif->LinkCustomAttributes = "";
		$this->tarif->HrefValue = "";
		$this->tarif->TooltipValue = "";

		// bhp
		$this->bhp->LinkCustomAttributes = "";
		$this->bhp->HrefValue = "";
		$this->bhp->TooltipValue = "";

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

		// kode
		$this->kode->EditAttrs["class"] = "form-control";
		$this->kode->EditCustomAttributes = "";
		$this->kode->EditValue = $this->kode->CurrentValue;
		$this->kode->PlaceHolder = ew_RemoveHtml($this->kode->FldCaption());

		// nama_tindakan
		$this->nama_tindakan->EditAttrs["class"] = "form-control";
		$this->nama_tindakan->EditCustomAttributes = "";
		$this->nama_tindakan->EditValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->PlaceHolder = ew_RemoveHtml($this->nama_tindakan->FldCaption());

		// nama_kelompok_tindakan
		$this->nama_kelompok_tindakan->EditAttrs["class"] = "form-control";
		$this->nama_kelompok_tindakan->EditCustomAttributes = "";
		$this->nama_kelompok_tindakan->EditValue = $this->nama_kelompok_tindakan->CurrentValue;
		$this->nama_kelompok_tindakan->PlaceHolder = ew_RemoveHtml($this->nama_kelompok_tindakan->FldCaption());

		// nama_sub_kelompok1
		$this->nama_sub_kelompok1->EditAttrs["class"] = "form-control";
		$this->nama_sub_kelompok1->EditCustomAttributes = "";
		$this->nama_sub_kelompok1->EditValue = $this->nama_sub_kelompok1->CurrentValue;
		$this->nama_sub_kelompok1->PlaceHolder = ew_RemoveHtml($this->nama_sub_kelompok1->FldCaption());

		// nama_sub_kelompok2
		$this->nama_sub_kelompok2->EditAttrs["class"] = "form-control";
		$this->nama_sub_kelompok2->EditCustomAttributes = "";
		$this->nama_sub_kelompok2->EditValue = $this->nama_sub_kelompok2->CurrentValue;
		$this->nama_sub_kelompok2->PlaceHolder = ew_RemoveHtml($this->nama_sub_kelompok2->FldCaption());

		// kelompok_tindakan
		$this->kelompok_tindakan->EditAttrs["class"] = "form-control";
		$this->kelompok_tindakan->EditCustomAttributes = "";
		$this->kelompok_tindakan->EditValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->PlaceHolder = ew_RemoveHtml($this->kelompok_tindakan->FldCaption());

		// sub_kelompok1
		$this->sub_kelompok1->EditAttrs["class"] = "form-control";
		$this->sub_kelompok1->EditCustomAttributes = "";
		$this->sub_kelompok1->EditValue = $this->sub_kelompok1->CurrentValue;
		$this->sub_kelompok1->PlaceHolder = ew_RemoveHtml($this->sub_kelompok1->FldCaption());

		// sub_kelompok2
		$this->sub_kelompok2->EditAttrs["class"] = "form-control";
		$this->sub_kelompok2->EditCustomAttributes = "";
		$this->sub_kelompok2->EditValue = $this->sub_kelompok2->CurrentValue;
		$this->sub_kelompok2->PlaceHolder = ew_RemoveHtml($this->sub_kelompok2->FldCaption());

		// kelas
		$this->kelas->EditAttrs["class"] = "form-control";
		$this->kelas->EditCustomAttributes = "";
		$this->kelas->EditValue = $this->kelas->CurrentValue;
		$this->kelas->PlaceHolder = ew_RemoveHtml($this->kelas->FldCaption());

		// tarif
		$this->tarif->EditAttrs["class"] = "form-control";
		$this->tarif->EditCustomAttributes = "";
		$this->tarif->EditValue = $this->tarif->CurrentValue;
		$this->tarif->PlaceHolder = ew_RemoveHtml($this->tarif->FldCaption());
		if (strval($this->tarif->EditValue) <> "" && is_numeric($this->tarif->EditValue)) $this->tarif->EditValue = ew_FormatNumber($this->tarif->EditValue, -2, -1, -2, 0);

		// bhp
		$this->bhp->EditAttrs["class"] = "form-control";
		$this->bhp->EditCustomAttributes = "";
		$this->bhp->EditValue = $this->bhp->CurrentValue;
		$this->bhp->PlaceHolder = ew_RemoveHtml($this->bhp->FldCaption());
		if (strval($this->bhp->EditValue) <> "" && is_numeric($this->bhp->EditValue)) $this->bhp->EditValue = ew_FormatNumber($this->bhp->EditValue, -2, -1, -2, 0);

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
					if ($this->kode->Exportable) $Doc->ExportCaption($this->kode);
					if ($this->nama_tindakan->Exportable) $Doc->ExportCaption($this->nama_tindakan);
					if ($this->nama_kelompok_tindakan->Exportable) $Doc->ExportCaption($this->nama_kelompok_tindakan);
					if ($this->nama_sub_kelompok1->Exportable) $Doc->ExportCaption($this->nama_sub_kelompok1);
					if ($this->nama_sub_kelompok2->Exportable) $Doc->ExportCaption($this->nama_sub_kelompok2);
					if ($this->kelompok_tindakan->Exportable) $Doc->ExportCaption($this->kelompok_tindakan);
					if ($this->sub_kelompok1->Exportable) $Doc->ExportCaption($this->sub_kelompok1);
					if ($this->sub_kelompok2->Exportable) $Doc->ExportCaption($this->sub_kelompok2);
					if ($this->kelas->Exportable) $Doc->ExportCaption($this->kelas);
					if ($this->tarif->Exportable) $Doc->ExportCaption($this->tarif);
					if ($this->bhp->Exportable) $Doc->ExportCaption($this->bhp);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->kode->Exportable) $Doc->ExportCaption($this->kode);
					if ($this->nama_tindakan->Exportable) $Doc->ExportCaption($this->nama_tindakan);
					if ($this->nama_kelompok_tindakan->Exportable) $Doc->ExportCaption($this->nama_kelompok_tindakan);
					if ($this->nama_sub_kelompok1->Exportable) $Doc->ExportCaption($this->nama_sub_kelompok1);
					if ($this->nama_sub_kelompok2->Exportable) $Doc->ExportCaption($this->nama_sub_kelompok2);
					if ($this->kelompok_tindakan->Exportable) $Doc->ExportCaption($this->kelompok_tindakan);
					if ($this->sub_kelompok1->Exportable) $Doc->ExportCaption($this->sub_kelompok1);
					if ($this->sub_kelompok2->Exportable) $Doc->ExportCaption($this->sub_kelompok2);
					if ($this->kelas->Exportable) $Doc->ExportCaption($this->kelas);
					if ($this->tarif->Exportable) $Doc->ExportCaption($this->tarif);
					if ($this->bhp->Exportable) $Doc->ExportCaption($this->bhp);
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
						if ($this->kode->Exportable) $Doc->ExportField($this->kode);
						if ($this->nama_tindakan->Exportable) $Doc->ExportField($this->nama_tindakan);
						if ($this->nama_kelompok_tindakan->Exportable) $Doc->ExportField($this->nama_kelompok_tindakan);
						if ($this->nama_sub_kelompok1->Exportable) $Doc->ExportField($this->nama_sub_kelompok1);
						if ($this->nama_sub_kelompok2->Exportable) $Doc->ExportField($this->nama_sub_kelompok2);
						if ($this->kelompok_tindakan->Exportable) $Doc->ExportField($this->kelompok_tindakan);
						if ($this->sub_kelompok1->Exportable) $Doc->ExportField($this->sub_kelompok1);
						if ($this->sub_kelompok2->Exportable) $Doc->ExportField($this->sub_kelompok2);
						if ($this->kelas->Exportable) $Doc->ExportField($this->kelas);
						if ($this->tarif->Exportable) $Doc->ExportField($this->tarif);
						if ($this->bhp->Exportable) $Doc->ExportField($this->bhp);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->kode->Exportable) $Doc->ExportField($this->kode);
						if ($this->nama_tindakan->Exportable) $Doc->ExportField($this->nama_tindakan);
						if ($this->nama_kelompok_tindakan->Exportable) $Doc->ExportField($this->nama_kelompok_tindakan);
						if ($this->nama_sub_kelompok1->Exportable) $Doc->ExportField($this->nama_sub_kelompok1);
						if ($this->nama_sub_kelompok2->Exportable) $Doc->ExportField($this->nama_sub_kelompok2);
						if ($this->kelompok_tindakan->Exportable) $Doc->ExportField($this->kelompok_tindakan);
						if ($this->sub_kelompok1->Exportable) $Doc->ExportField($this->sub_kelompok1);
						if ($this->sub_kelompok2->Exportable) $Doc->ExportField($this->sub_kelompok2);
						if ($this->kelas->Exportable) $Doc->ExportField($this->kelas);
						if ($this->tarif->Exportable) $Doc->ExportField($this->tarif);
						if ($this->bhp->Exportable) $Doc->ExportField($this->bhp);
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
