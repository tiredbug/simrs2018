<?php

// Global variable for table object
$spp = NULL;

//
// Table class for spp
//
class cspp extends cTable {
	var $tgl;
	var $no_spp;
	var $jns_spp;
	var $kd_mata;
	var $urai;
	var $jmlh;
	var $jmlh1;
	var $jmlh2;
	var $jmlh3;
	var $jmlh4;
	var $nm_perus;
	var $alamat;
	var $npwp;
	var $pimpinan;
	var $bank;
	var $rek;
	var $nospm;
	var $tglspm;
	var $ppn;
	var $ps21;
	var $ps22;
	var $ps23;
	var $ps4;
	var $kodespm;
	var $nambud;
	var $nppk;
	var $nipppk;
	var $prog;
	var $prog1;
	var $bayar;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'spp';
		$this->TableName = 'spp';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`spp`";
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

		// tgl
		$this->tgl = new cField('spp', 'spp', 'x_tgl', 'tgl', '`tgl`', ew_CastDateFieldForLike('`tgl`', 0, "DB"), 135, 0, FALSE, '`tgl`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl->Sortable = TRUE; // Allow sort
		$this->tgl->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl'] = &$this->tgl;

		// no_spp
		$this->no_spp = new cField('spp', 'spp', 'x_no_spp', 'no_spp', '`no_spp`', '`no_spp`', 200, -1, FALSE, '`no_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spp->Sortable = TRUE; // Allow sort
		$this->fields['no_spp'] = &$this->no_spp;

		// jns_spp
		$this->jns_spp = new cField('spp', 'spp', 'x_jns_spp', 'jns_spp', '`jns_spp`', '`jns_spp`', 200, -1, FALSE, '`jns_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jns_spp->Sortable = TRUE; // Allow sort
		$this->fields['jns_spp'] = &$this->jns_spp;

		// kd_mata
		$this->kd_mata = new cField('spp', 'spp', 'x_kd_mata', 'kd_mata', '`kd_mata`', '`kd_mata`', 200, -1, FALSE, '`kd_mata`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_mata->Sortable = TRUE; // Allow sort
		$this->fields['kd_mata'] = &$this->kd_mata;

		// urai
		$this->urai = new cField('spp', 'spp', 'x_urai', 'urai', '`urai`', '`urai`', 200, -1, FALSE, '`urai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->urai->Sortable = TRUE; // Allow sort
		$this->fields['urai'] = &$this->urai;

		// jmlh
		$this->jmlh = new cField('spp', 'spp', 'x_jmlh', 'jmlh', '`jmlh`', '`jmlh`', 20, -1, FALSE, '`jmlh`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jmlh->Sortable = TRUE; // Allow sort
		$this->jmlh->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jmlh'] = &$this->jmlh;

		// jmlh1
		$this->jmlh1 = new cField('spp', 'spp', 'x_jmlh1', 'jmlh1', '`jmlh1`', '`jmlh1`', 20, -1, FALSE, '`jmlh1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jmlh1->Sortable = TRUE; // Allow sort
		$this->jmlh1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jmlh1'] = &$this->jmlh1;

		// jmlh2
		$this->jmlh2 = new cField('spp', 'spp', 'x_jmlh2', 'jmlh2', '`jmlh2`', '`jmlh2`', 20, -1, FALSE, '`jmlh2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jmlh2->Sortable = TRUE; // Allow sort
		$this->jmlh2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jmlh2'] = &$this->jmlh2;

		// jmlh3
		$this->jmlh3 = new cField('spp', 'spp', 'x_jmlh3', 'jmlh3', '`jmlh3`', '`jmlh3`', 20, -1, FALSE, '`jmlh3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jmlh3->Sortable = TRUE; // Allow sort
		$this->jmlh3->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jmlh3'] = &$this->jmlh3;

		// jmlh4
		$this->jmlh4 = new cField('spp', 'spp', 'x_jmlh4', 'jmlh4', '`jmlh4`', '`jmlh4`', 20, -1, FALSE, '`jmlh4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jmlh4->Sortable = TRUE; // Allow sort
		$this->jmlh4->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jmlh4'] = &$this->jmlh4;

		// nm_perus
		$this->nm_perus = new cField('spp', 'spp', 'x_nm_perus', 'nm_perus', '`nm_perus`', '`nm_perus`', 200, -1, FALSE, '`nm_perus`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nm_perus->Sortable = TRUE; // Allow sort
		$this->fields['nm_perus'] = &$this->nm_perus;

		// alamat
		$this->alamat = new cField('spp', 'spp', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, -1, FALSE, '`alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alamat->Sortable = TRUE; // Allow sort
		$this->fields['alamat'] = &$this->alamat;

		// npwp
		$this->npwp = new cField('spp', 'spp', 'x_npwp', 'npwp', '`npwp`', '`npwp`', 200, -1, FALSE, '`npwp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->npwp->Sortable = TRUE; // Allow sort
		$this->fields['npwp'] = &$this->npwp;

		// pimpinan
		$this->pimpinan = new cField('spp', 'spp', 'x_pimpinan', 'pimpinan', '`pimpinan`', '`pimpinan`', 200, -1, FALSE, '`pimpinan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pimpinan->Sortable = TRUE; // Allow sort
		$this->fields['pimpinan'] = &$this->pimpinan;

		// bank
		$this->bank = new cField('spp', 'spp', 'x_bank', 'bank', '`bank`', '`bank`', 200, -1, FALSE, '`bank`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bank->Sortable = TRUE; // Allow sort
		$this->fields['bank'] = &$this->bank;

		// rek
		$this->rek = new cField('spp', 'spp', 'x_rek', 'rek', '`rek`', '`rek`', 200, -1, FALSE, '`rek`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rek->Sortable = TRUE; // Allow sort
		$this->fields['rek'] = &$this->rek;

		// nospm
		$this->nospm = new cField('spp', 'spp', 'x_nospm', 'nospm', '`nospm`', '`nospm`', 200, -1, FALSE, '`nospm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nospm->Sortable = TRUE; // Allow sort
		$this->fields['nospm'] = &$this->nospm;

		// tglspm
		$this->tglspm = new cField('spp', 'spp', 'x_tglspm', 'tglspm', '`tglspm`', ew_CastDateFieldForLike('`tglspm`', 0, "DB"), 135, 0, FALSE, '`tglspm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tglspm->Sortable = TRUE; // Allow sort
		$this->tglspm->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tglspm'] = &$this->tglspm;

		// ppn
		$this->ppn = new cField('spp', 'spp', 'x_ppn', 'ppn', '`ppn`', '`ppn`', 20, -1, FALSE, '`ppn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ppn->Sortable = TRUE; // Allow sort
		$this->ppn->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ppn'] = &$this->ppn;

		// ps21
		$this->ps21 = new cField('spp', 'spp', 'x_ps21', 'ps21', '`ps21`', '`ps21`', 20, -1, FALSE, '`ps21`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps21->Sortable = TRUE; // Allow sort
		$this->ps21->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps21'] = &$this->ps21;

		// ps22
		$this->ps22 = new cField('spp', 'spp', 'x_ps22', 'ps22', '`ps22`', '`ps22`', 20, -1, FALSE, '`ps22`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps22->Sortable = TRUE; // Allow sort
		$this->ps22->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps22'] = &$this->ps22;

		// ps23
		$this->ps23 = new cField('spp', 'spp', 'x_ps23', 'ps23', '`ps23`', '`ps23`', 20, -1, FALSE, '`ps23`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps23->Sortable = TRUE; // Allow sort
		$this->ps23->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps23'] = &$this->ps23;

		// ps4
		$this->ps4 = new cField('spp', 'spp', 'x_ps4', 'ps4', '`ps4`', '`ps4`', 20, -1, FALSE, '`ps4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ps4->Sortable = TRUE; // Allow sort
		$this->ps4->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ps4'] = &$this->ps4;

		// kodespm
		$this->kodespm = new cField('spp', 'spp', 'x_kodespm', 'kodespm', '`kodespm`', '`kodespm`', 200, -1, FALSE, '`kodespm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kodespm->Sortable = TRUE; // Allow sort
		$this->fields['kodespm'] = &$this->kodespm;

		// nambud
		$this->nambud = new cField('spp', 'spp', 'x_nambud', 'nambud', '`nambud`', '`nambud`', 200, -1, FALSE, '`nambud`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nambud->Sortable = TRUE; // Allow sort
		$this->fields['nambud'] = &$this->nambud;

		// nppk
		$this->nppk = new cField('spp', 'spp', 'x_nppk', 'nppk', '`nppk`', '`nppk`', 200, -1, FALSE, '`nppk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nppk->Sortable = TRUE; // Allow sort
		$this->fields['nppk'] = &$this->nppk;

		// nipppk
		$this->nipppk = new cField('spp', 'spp', 'x_nipppk', 'nipppk', '`nipppk`', '`nipppk`', 200, -1, FALSE, '`nipppk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nipppk->Sortable = TRUE; // Allow sort
		$this->fields['nipppk'] = &$this->nipppk;

		// prog
		$this->prog = new cField('spp', 'spp', 'x_prog', 'prog', '`prog`', '`prog`', 200, -1, FALSE, '`prog`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->prog->Sortable = TRUE; // Allow sort
		$this->fields['prog'] = &$this->prog;

		// prog1
		$this->prog1 = new cField('spp', 'spp', 'x_prog1', 'prog1', '`prog1`', '`prog1`', 200, -1, FALSE, '`prog1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->prog1->Sortable = TRUE; // Allow sort
		$this->fields['prog1'] = &$this->prog1;

		// bayar
		$this->bayar = new cField('spp', 'spp', 'x_bayar', 'bayar', '`bayar`', '`bayar`', 200, -1, FALSE, '`bayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bayar->Sortable = TRUE; // Allow sort
		$this->fields['bayar'] = &$this->bayar;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`spp`";
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
			return "spplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "spplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("sppview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("sppview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "sppadd.php?" . $this->UrlParm($parm);
		else
			$url = "sppadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("sppedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("sppadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("sppdelete.php", $this->UrlParm());
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
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->jns_spp->setDbValue($rs->fields('jns_spp'));
		$this->kd_mata->setDbValue($rs->fields('kd_mata'));
		$this->urai->setDbValue($rs->fields('urai'));
		$this->jmlh->setDbValue($rs->fields('jmlh'));
		$this->jmlh1->setDbValue($rs->fields('jmlh1'));
		$this->jmlh2->setDbValue($rs->fields('jmlh2'));
		$this->jmlh3->setDbValue($rs->fields('jmlh3'));
		$this->jmlh4->setDbValue($rs->fields('jmlh4'));
		$this->nm_perus->setDbValue($rs->fields('nm_perus'));
		$this->alamat->setDbValue($rs->fields('alamat'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->pimpinan->setDbValue($rs->fields('pimpinan'));
		$this->bank->setDbValue($rs->fields('bank'));
		$this->rek->setDbValue($rs->fields('rek'));
		$this->nospm->setDbValue($rs->fields('nospm'));
		$this->tglspm->setDbValue($rs->fields('tglspm'));
		$this->ppn->setDbValue($rs->fields('ppn'));
		$this->ps21->setDbValue($rs->fields('ps21'));
		$this->ps22->setDbValue($rs->fields('ps22'));
		$this->ps23->setDbValue($rs->fields('ps23'));
		$this->ps4->setDbValue($rs->fields('ps4'));
		$this->kodespm->setDbValue($rs->fields('kodespm'));
		$this->nambud->setDbValue($rs->fields('nambud'));
		$this->nppk->setDbValue($rs->fields('nppk'));
		$this->nipppk->setDbValue($rs->fields('nipppk'));
		$this->prog->setDbValue($rs->fields('prog'));
		$this->prog1->setDbValue($rs->fields('prog1'));
		$this->bayar->setDbValue($rs->fields('bayar'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// tgl
		// no_spp
		// jns_spp
		// kd_mata
		// urai
		// jmlh
		// jmlh1
		// jmlh2
		// jmlh3
		// jmlh4
		// nm_perus
		// alamat
		// npwp
		// pimpinan
		// bank
		// rek
		// nospm
		// tglspm
		// ppn
		// ps21
		// ps22
		// ps23
		// ps4
		// kodespm
		// nambud
		// nppk
		// nipppk
		// prog
		// prog1
		// bayar
		// tgl

		$this->tgl->ViewValue = $this->tgl->CurrentValue;
		$this->tgl->ViewValue = ew_FormatDateTime($this->tgl->ViewValue, 0);
		$this->tgl->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// jns_spp
		$this->jns_spp->ViewValue = $this->jns_spp->CurrentValue;
		$this->jns_spp->ViewCustomAttributes = "";

		// kd_mata
		$this->kd_mata->ViewValue = $this->kd_mata->CurrentValue;
		$this->kd_mata->ViewCustomAttributes = "";

		// urai
		$this->urai->ViewValue = $this->urai->CurrentValue;
		$this->urai->ViewCustomAttributes = "";

		// jmlh
		$this->jmlh->ViewValue = $this->jmlh->CurrentValue;
		$this->jmlh->ViewCustomAttributes = "";

		// jmlh1
		$this->jmlh1->ViewValue = $this->jmlh1->CurrentValue;
		$this->jmlh1->ViewCustomAttributes = "";

		// jmlh2
		$this->jmlh2->ViewValue = $this->jmlh2->CurrentValue;
		$this->jmlh2->ViewCustomAttributes = "";

		// jmlh3
		$this->jmlh3->ViewValue = $this->jmlh3->CurrentValue;
		$this->jmlh3->ViewCustomAttributes = "";

		// jmlh4
		$this->jmlh4->ViewValue = $this->jmlh4->CurrentValue;
		$this->jmlh4->ViewCustomAttributes = "";

		// nm_perus
		$this->nm_perus->ViewValue = $this->nm_perus->CurrentValue;
		$this->nm_perus->ViewCustomAttributes = "";

		// alamat
		$this->alamat->ViewValue = $this->alamat->CurrentValue;
		$this->alamat->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// pimpinan
		$this->pimpinan->ViewValue = $this->pimpinan->CurrentValue;
		$this->pimpinan->ViewCustomAttributes = "";

		// bank
		$this->bank->ViewValue = $this->bank->CurrentValue;
		$this->bank->ViewCustomAttributes = "";

		// rek
		$this->rek->ViewValue = $this->rek->CurrentValue;
		$this->rek->ViewCustomAttributes = "";

		// nospm
		$this->nospm->ViewValue = $this->nospm->CurrentValue;
		$this->nospm->ViewCustomAttributes = "";

		// tglspm
		$this->tglspm->ViewValue = $this->tglspm->CurrentValue;
		$this->tglspm->ViewValue = ew_FormatDateTime($this->tglspm->ViewValue, 0);
		$this->tglspm->ViewCustomAttributes = "";

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

		// ps4
		$this->ps4->ViewValue = $this->ps4->CurrentValue;
		$this->ps4->ViewCustomAttributes = "";

		// kodespm
		$this->kodespm->ViewValue = $this->kodespm->CurrentValue;
		$this->kodespm->ViewCustomAttributes = "";

		// nambud
		$this->nambud->ViewValue = $this->nambud->CurrentValue;
		$this->nambud->ViewCustomAttributes = "";

		// nppk
		$this->nppk->ViewValue = $this->nppk->CurrentValue;
		$this->nppk->ViewCustomAttributes = "";

		// nipppk
		$this->nipppk->ViewValue = $this->nipppk->CurrentValue;
		$this->nipppk->ViewCustomAttributes = "";

		// prog
		$this->prog->ViewValue = $this->prog->CurrentValue;
		$this->prog->ViewCustomAttributes = "";

		// prog1
		$this->prog1->ViewValue = $this->prog1->CurrentValue;
		$this->prog1->ViewCustomAttributes = "";

		// bayar
		$this->bayar->ViewValue = $this->bayar->CurrentValue;
		$this->bayar->ViewCustomAttributes = "";

		// tgl
		$this->tgl->LinkCustomAttributes = "";
		$this->tgl->HrefValue = "";
		$this->tgl->TooltipValue = "";

		// no_spp
		$this->no_spp->LinkCustomAttributes = "";
		$this->no_spp->HrefValue = "";
		$this->no_spp->TooltipValue = "";

		// jns_spp
		$this->jns_spp->LinkCustomAttributes = "";
		$this->jns_spp->HrefValue = "";
		$this->jns_spp->TooltipValue = "";

		// kd_mata
		$this->kd_mata->LinkCustomAttributes = "";
		$this->kd_mata->HrefValue = "";
		$this->kd_mata->TooltipValue = "";

		// urai
		$this->urai->LinkCustomAttributes = "";
		$this->urai->HrefValue = "";
		$this->urai->TooltipValue = "";

		// jmlh
		$this->jmlh->LinkCustomAttributes = "";
		$this->jmlh->HrefValue = "";
		$this->jmlh->TooltipValue = "";

		// jmlh1
		$this->jmlh1->LinkCustomAttributes = "";
		$this->jmlh1->HrefValue = "";
		$this->jmlh1->TooltipValue = "";

		// jmlh2
		$this->jmlh2->LinkCustomAttributes = "";
		$this->jmlh2->HrefValue = "";
		$this->jmlh2->TooltipValue = "";

		// jmlh3
		$this->jmlh3->LinkCustomAttributes = "";
		$this->jmlh3->HrefValue = "";
		$this->jmlh3->TooltipValue = "";

		// jmlh4
		$this->jmlh4->LinkCustomAttributes = "";
		$this->jmlh4->HrefValue = "";
		$this->jmlh4->TooltipValue = "";

		// nm_perus
		$this->nm_perus->LinkCustomAttributes = "";
		$this->nm_perus->HrefValue = "";
		$this->nm_perus->TooltipValue = "";

		// alamat
		$this->alamat->LinkCustomAttributes = "";
		$this->alamat->HrefValue = "";
		$this->alamat->TooltipValue = "";

		// npwp
		$this->npwp->LinkCustomAttributes = "";
		$this->npwp->HrefValue = "";
		$this->npwp->TooltipValue = "";

		// pimpinan
		$this->pimpinan->LinkCustomAttributes = "";
		$this->pimpinan->HrefValue = "";
		$this->pimpinan->TooltipValue = "";

		// bank
		$this->bank->LinkCustomAttributes = "";
		$this->bank->HrefValue = "";
		$this->bank->TooltipValue = "";

		// rek
		$this->rek->LinkCustomAttributes = "";
		$this->rek->HrefValue = "";
		$this->rek->TooltipValue = "";

		// nospm
		$this->nospm->LinkCustomAttributes = "";
		$this->nospm->HrefValue = "";
		$this->nospm->TooltipValue = "";

		// tglspm
		$this->tglspm->LinkCustomAttributes = "";
		$this->tglspm->HrefValue = "";
		$this->tglspm->TooltipValue = "";

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

		// ps4
		$this->ps4->LinkCustomAttributes = "";
		$this->ps4->HrefValue = "";
		$this->ps4->TooltipValue = "";

		// kodespm
		$this->kodespm->LinkCustomAttributes = "";
		$this->kodespm->HrefValue = "";
		$this->kodespm->TooltipValue = "";

		// nambud
		$this->nambud->LinkCustomAttributes = "";
		$this->nambud->HrefValue = "";
		$this->nambud->TooltipValue = "";

		// nppk
		$this->nppk->LinkCustomAttributes = "";
		$this->nppk->HrefValue = "";
		$this->nppk->TooltipValue = "";

		// nipppk
		$this->nipppk->LinkCustomAttributes = "";
		$this->nipppk->HrefValue = "";
		$this->nipppk->TooltipValue = "";

		// prog
		$this->prog->LinkCustomAttributes = "";
		$this->prog->HrefValue = "";
		$this->prog->TooltipValue = "";

		// prog1
		$this->prog1->LinkCustomAttributes = "";
		$this->prog1->HrefValue = "";
		$this->prog1->TooltipValue = "";

		// bayar
		$this->bayar->LinkCustomAttributes = "";
		$this->bayar->HrefValue = "";
		$this->bayar->TooltipValue = "";

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

		// no_spp
		$this->no_spp->EditAttrs["class"] = "form-control";
		$this->no_spp->EditCustomAttributes = "";
		$this->no_spp->EditValue = $this->no_spp->CurrentValue;
		$this->no_spp->PlaceHolder = ew_RemoveHtml($this->no_spp->FldCaption());

		// jns_spp
		$this->jns_spp->EditAttrs["class"] = "form-control";
		$this->jns_spp->EditCustomAttributes = "";
		$this->jns_spp->EditValue = $this->jns_spp->CurrentValue;
		$this->jns_spp->PlaceHolder = ew_RemoveHtml($this->jns_spp->FldCaption());

		// kd_mata
		$this->kd_mata->EditAttrs["class"] = "form-control";
		$this->kd_mata->EditCustomAttributes = "";
		$this->kd_mata->EditValue = $this->kd_mata->CurrentValue;
		$this->kd_mata->PlaceHolder = ew_RemoveHtml($this->kd_mata->FldCaption());

		// urai
		$this->urai->EditAttrs["class"] = "form-control";
		$this->urai->EditCustomAttributes = "";
		$this->urai->EditValue = $this->urai->CurrentValue;
		$this->urai->PlaceHolder = ew_RemoveHtml($this->urai->FldCaption());

		// jmlh
		$this->jmlh->EditAttrs["class"] = "form-control";
		$this->jmlh->EditCustomAttributes = "";
		$this->jmlh->EditValue = $this->jmlh->CurrentValue;
		$this->jmlh->PlaceHolder = ew_RemoveHtml($this->jmlh->FldCaption());

		// jmlh1
		$this->jmlh1->EditAttrs["class"] = "form-control";
		$this->jmlh1->EditCustomAttributes = "";
		$this->jmlh1->EditValue = $this->jmlh1->CurrentValue;
		$this->jmlh1->PlaceHolder = ew_RemoveHtml($this->jmlh1->FldCaption());

		// jmlh2
		$this->jmlh2->EditAttrs["class"] = "form-control";
		$this->jmlh2->EditCustomAttributes = "";
		$this->jmlh2->EditValue = $this->jmlh2->CurrentValue;
		$this->jmlh2->PlaceHolder = ew_RemoveHtml($this->jmlh2->FldCaption());

		// jmlh3
		$this->jmlh3->EditAttrs["class"] = "form-control";
		$this->jmlh3->EditCustomAttributes = "";
		$this->jmlh3->EditValue = $this->jmlh3->CurrentValue;
		$this->jmlh3->PlaceHolder = ew_RemoveHtml($this->jmlh3->FldCaption());

		// jmlh4
		$this->jmlh4->EditAttrs["class"] = "form-control";
		$this->jmlh4->EditCustomAttributes = "";
		$this->jmlh4->EditValue = $this->jmlh4->CurrentValue;
		$this->jmlh4->PlaceHolder = ew_RemoveHtml($this->jmlh4->FldCaption());

		// nm_perus
		$this->nm_perus->EditAttrs["class"] = "form-control";
		$this->nm_perus->EditCustomAttributes = "";
		$this->nm_perus->EditValue = $this->nm_perus->CurrentValue;
		$this->nm_perus->PlaceHolder = ew_RemoveHtml($this->nm_perus->FldCaption());

		// alamat
		$this->alamat->EditAttrs["class"] = "form-control";
		$this->alamat->EditCustomAttributes = "";
		$this->alamat->EditValue = $this->alamat->CurrentValue;
		$this->alamat->PlaceHolder = ew_RemoveHtml($this->alamat->FldCaption());

		// npwp
		$this->npwp->EditAttrs["class"] = "form-control";
		$this->npwp->EditCustomAttributes = "";
		$this->npwp->EditValue = $this->npwp->CurrentValue;
		$this->npwp->PlaceHolder = ew_RemoveHtml($this->npwp->FldCaption());

		// pimpinan
		$this->pimpinan->EditAttrs["class"] = "form-control";
		$this->pimpinan->EditCustomAttributes = "";
		$this->pimpinan->EditValue = $this->pimpinan->CurrentValue;
		$this->pimpinan->PlaceHolder = ew_RemoveHtml($this->pimpinan->FldCaption());

		// bank
		$this->bank->EditAttrs["class"] = "form-control";
		$this->bank->EditCustomAttributes = "";
		$this->bank->EditValue = $this->bank->CurrentValue;
		$this->bank->PlaceHolder = ew_RemoveHtml($this->bank->FldCaption());

		// rek
		$this->rek->EditAttrs["class"] = "form-control";
		$this->rek->EditCustomAttributes = "";
		$this->rek->EditValue = $this->rek->CurrentValue;
		$this->rek->PlaceHolder = ew_RemoveHtml($this->rek->FldCaption());

		// nospm
		$this->nospm->EditAttrs["class"] = "form-control";
		$this->nospm->EditCustomAttributes = "";
		$this->nospm->EditValue = $this->nospm->CurrentValue;
		$this->nospm->PlaceHolder = ew_RemoveHtml($this->nospm->FldCaption());

		// tglspm
		$this->tglspm->EditAttrs["class"] = "form-control";
		$this->tglspm->EditCustomAttributes = "";
		$this->tglspm->EditValue = ew_FormatDateTime($this->tglspm->CurrentValue, 8);
		$this->tglspm->PlaceHolder = ew_RemoveHtml($this->tglspm->FldCaption());

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

		// ps4
		$this->ps4->EditAttrs["class"] = "form-control";
		$this->ps4->EditCustomAttributes = "";
		$this->ps4->EditValue = $this->ps4->CurrentValue;
		$this->ps4->PlaceHolder = ew_RemoveHtml($this->ps4->FldCaption());

		// kodespm
		$this->kodespm->EditAttrs["class"] = "form-control";
		$this->kodespm->EditCustomAttributes = "";
		$this->kodespm->EditValue = $this->kodespm->CurrentValue;
		$this->kodespm->PlaceHolder = ew_RemoveHtml($this->kodespm->FldCaption());

		// nambud
		$this->nambud->EditAttrs["class"] = "form-control";
		$this->nambud->EditCustomAttributes = "";
		$this->nambud->EditValue = $this->nambud->CurrentValue;
		$this->nambud->PlaceHolder = ew_RemoveHtml($this->nambud->FldCaption());

		// nppk
		$this->nppk->EditAttrs["class"] = "form-control";
		$this->nppk->EditCustomAttributes = "";
		$this->nppk->EditValue = $this->nppk->CurrentValue;
		$this->nppk->PlaceHolder = ew_RemoveHtml($this->nppk->FldCaption());

		// nipppk
		$this->nipppk->EditAttrs["class"] = "form-control";
		$this->nipppk->EditCustomAttributes = "";
		$this->nipppk->EditValue = $this->nipppk->CurrentValue;
		$this->nipppk->PlaceHolder = ew_RemoveHtml($this->nipppk->FldCaption());

		// prog
		$this->prog->EditAttrs["class"] = "form-control";
		$this->prog->EditCustomAttributes = "";
		$this->prog->EditValue = $this->prog->CurrentValue;
		$this->prog->PlaceHolder = ew_RemoveHtml($this->prog->FldCaption());

		// prog1
		$this->prog1->EditAttrs["class"] = "form-control";
		$this->prog1->EditCustomAttributes = "";
		$this->prog1->EditValue = $this->prog1->CurrentValue;
		$this->prog1->PlaceHolder = ew_RemoveHtml($this->prog1->FldCaption());

		// bayar
		$this->bayar->EditAttrs["class"] = "form-control";
		$this->bayar->EditCustomAttributes = "";
		$this->bayar->EditValue = $this->bayar->CurrentValue;
		$this->bayar->PlaceHolder = ew_RemoveHtml($this->bayar->FldCaption());

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
					if ($this->no_spp->Exportable) $Doc->ExportCaption($this->no_spp);
					if ($this->jns_spp->Exportable) $Doc->ExportCaption($this->jns_spp);
					if ($this->kd_mata->Exportable) $Doc->ExportCaption($this->kd_mata);
					if ($this->urai->Exportable) $Doc->ExportCaption($this->urai);
					if ($this->jmlh->Exportable) $Doc->ExportCaption($this->jmlh);
					if ($this->jmlh1->Exportable) $Doc->ExportCaption($this->jmlh1);
					if ($this->jmlh2->Exportable) $Doc->ExportCaption($this->jmlh2);
					if ($this->jmlh3->Exportable) $Doc->ExportCaption($this->jmlh3);
					if ($this->jmlh4->Exportable) $Doc->ExportCaption($this->jmlh4);
					if ($this->nm_perus->Exportable) $Doc->ExportCaption($this->nm_perus);
					if ($this->alamat->Exportable) $Doc->ExportCaption($this->alamat);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->pimpinan->Exportable) $Doc->ExportCaption($this->pimpinan);
					if ($this->bank->Exportable) $Doc->ExportCaption($this->bank);
					if ($this->rek->Exportable) $Doc->ExportCaption($this->rek);
					if ($this->nospm->Exportable) $Doc->ExportCaption($this->nospm);
					if ($this->tglspm->Exportable) $Doc->ExportCaption($this->tglspm);
					if ($this->ppn->Exportable) $Doc->ExportCaption($this->ppn);
					if ($this->ps21->Exportable) $Doc->ExportCaption($this->ps21);
					if ($this->ps22->Exportable) $Doc->ExportCaption($this->ps22);
					if ($this->ps23->Exportable) $Doc->ExportCaption($this->ps23);
					if ($this->ps4->Exportable) $Doc->ExportCaption($this->ps4);
					if ($this->kodespm->Exportable) $Doc->ExportCaption($this->kodespm);
					if ($this->nambud->Exportable) $Doc->ExportCaption($this->nambud);
					if ($this->nppk->Exportable) $Doc->ExportCaption($this->nppk);
					if ($this->nipppk->Exportable) $Doc->ExportCaption($this->nipppk);
					if ($this->prog->Exportable) $Doc->ExportCaption($this->prog);
					if ($this->prog1->Exportable) $Doc->ExportCaption($this->prog1);
					if ($this->bayar->Exportable) $Doc->ExportCaption($this->bayar);
				} else {
					if ($this->tgl->Exportable) $Doc->ExportCaption($this->tgl);
					if ($this->no_spp->Exportable) $Doc->ExportCaption($this->no_spp);
					if ($this->jns_spp->Exportable) $Doc->ExportCaption($this->jns_spp);
					if ($this->kd_mata->Exportable) $Doc->ExportCaption($this->kd_mata);
					if ($this->urai->Exportable) $Doc->ExportCaption($this->urai);
					if ($this->jmlh->Exportable) $Doc->ExportCaption($this->jmlh);
					if ($this->jmlh1->Exportable) $Doc->ExportCaption($this->jmlh1);
					if ($this->jmlh2->Exportable) $Doc->ExportCaption($this->jmlh2);
					if ($this->jmlh3->Exportable) $Doc->ExportCaption($this->jmlh3);
					if ($this->jmlh4->Exportable) $Doc->ExportCaption($this->jmlh4);
					if ($this->nm_perus->Exportable) $Doc->ExportCaption($this->nm_perus);
					if ($this->alamat->Exportable) $Doc->ExportCaption($this->alamat);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->pimpinan->Exportable) $Doc->ExportCaption($this->pimpinan);
					if ($this->bank->Exportable) $Doc->ExportCaption($this->bank);
					if ($this->rek->Exportable) $Doc->ExportCaption($this->rek);
					if ($this->nospm->Exportable) $Doc->ExportCaption($this->nospm);
					if ($this->tglspm->Exportable) $Doc->ExportCaption($this->tglspm);
					if ($this->ppn->Exportable) $Doc->ExportCaption($this->ppn);
					if ($this->ps21->Exportable) $Doc->ExportCaption($this->ps21);
					if ($this->ps22->Exportable) $Doc->ExportCaption($this->ps22);
					if ($this->ps23->Exportable) $Doc->ExportCaption($this->ps23);
					if ($this->ps4->Exportable) $Doc->ExportCaption($this->ps4);
					if ($this->kodespm->Exportable) $Doc->ExportCaption($this->kodespm);
					if ($this->nambud->Exportable) $Doc->ExportCaption($this->nambud);
					if ($this->nppk->Exportable) $Doc->ExportCaption($this->nppk);
					if ($this->nipppk->Exportable) $Doc->ExportCaption($this->nipppk);
					if ($this->prog->Exportable) $Doc->ExportCaption($this->prog);
					if ($this->prog1->Exportable) $Doc->ExportCaption($this->prog1);
					if ($this->bayar->Exportable) $Doc->ExportCaption($this->bayar);
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
						if ($this->no_spp->Exportable) $Doc->ExportField($this->no_spp);
						if ($this->jns_spp->Exportable) $Doc->ExportField($this->jns_spp);
						if ($this->kd_mata->Exportable) $Doc->ExportField($this->kd_mata);
						if ($this->urai->Exportable) $Doc->ExportField($this->urai);
						if ($this->jmlh->Exportable) $Doc->ExportField($this->jmlh);
						if ($this->jmlh1->Exportable) $Doc->ExportField($this->jmlh1);
						if ($this->jmlh2->Exportable) $Doc->ExportField($this->jmlh2);
						if ($this->jmlh3->Exportable) $Doc->ExportField($this->jmlh3);
						if ($this->jmlh4->Exportable) $Doc->ExportField($this->jmlh4);
						if ($this->nm_perus->Exportable) $Doc->ExportField($this->nm_perus);
						if ($this->alamat->Exportable) $Doc->ExportField($this->alamat);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->pimpinan->Exportable) $Doc->ExportField($this->pimpinan);
						if ($this->bank->Exportable) $Doc->ExportField($this->bank);
						if ($this->rek->Exportable) $Doc->ExportField($this->rek);
						if ($this->nospm->Exportable) $Doc->ExportField($this->nospm);
						if ($this->tglspm->Exportable) $Doc->ExportField($this->tglspm);
						if ($this->ppn->Exportable) $Doc->ExportField($this->ppn);
						if ($this->ps21->Exportable) $Doc->ExportField($this->ps21);
						if ($this->ps22->Exportable) $Doc->ExportField($this->ps22);
						if ($this->ps23->Exportable) $Doc->ExportField($this->ps23);
						if ($this->ps4->Exportable) $Doc->ExportField($this->ps4);
						if ($this->kodespm->Exportable) $Doc->ExportField($this->kodespm);
						if ($this->nambud->Exportable) $Doc->ExportField($this->nambud);
						if ($this->nppk->Exportable) $Doc->ExportField($this->nppk);
						if ($this->nipppk->Exportable) $Doc->ExportField($this->nipppk);
						if ($this->prog->Exportable) $Doc->ExportField($this->prog);
						if ($this->prog1->Exportable) $Doc->ExportField($this->prog1);
						if ($this->bayar->Exportable) $Doc->ExportField($this->bayar);
					} else {
						if ($this->tgl->Exportable) $Doc->ExportField($this->tgl);
						if ($this->no_spp->Exportable) $Doc->ExportField($this->no_spp);
						if ($this->jns_spp->Exportable) $Doc->ExportField($this->jns_spp);
						if ($this->kd_mata->Exportable) $Doc->ExportField($this->kd_mata);
						if ($this->urai->Exportable) $Doc->ExportField($this->urai);
						if ($this->jmlh->Exportable) $Doc->ExportField($this->jmlh);
						if ($this->jmlh1->Exportable) $Doc->ExportField($this->jmlh1);
						if ($this->jmlh2->Exportable) $Doc->ExportField($this->jmlh2);
						if ($this->jmlh3->Exportable) $Doc->ExportField($this->jmlh3);
						if ($this->jmlh4->Exportable) $Doc->ExportField($this->jmlh4);
						if ($this->nm_perus->Exportable) $Doc->ExportField($this->nm_perus);
						if ($this->alamat->Exportable) $Doc->ExportField($this->alamat);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->pimpinan->Exportable) $Doc->ExportField($this->pimpinan);
						if ($this->bank->Exportable) $Doc->ExportField($this->bank);
						if ($this->rek->Exportable) $Doc->ExportField($this->rek);
						if ($this->nospm->Exportable) $Doc->ExportField($this->nospm);
						if ($this->tglspm->Exportable) $Doc->ExportField($this->tglspm);
						if ($this->ppn->Exportable) $Doc->ExportField($this->ppn);
						if ($this->ps21->Exportable) $Doc->ExportField($this->ps21);
						if ($this->ps22->Exportable) $Doc->ExportField($this->ps22);
						if ($this->ps23->Exportable) $Doc->ExportField($this->ps23);
						if ($this->ps4->Exportable) $Doc->ExportField($this->ps4);
						if ($this->kodespm->Exportable) $Doc->ExportField($this->kodespm);
						if ($this->nambud->Exportable) $Doc->ExportField($this->nambud);
						if ($this->nppk->Exportable) $Doc->ExportField($this->nppk);
						if ($this->nipppk->Exportable) $Doc->ExportField($this->nipppk);
						if ($this->prog->Exportable) $Doc->ExportField($this->prog);
						if ($this->prog1->Exportable) $Doc->ExportField($this->prog1);
						if ($this->bayar->Exportable) $Doc->ExportField($this->bayar);
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
