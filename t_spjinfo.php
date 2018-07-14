<?php

// Global variable for table object
$t_spj = NULL;

//
// Table class for t_spj
//
class ct_spj extends cTable {
	var $id;
	var $jenis_spj;
	var $no_spj;
	var $tgl_spj;
	var $program;
	var $kegiatan;
	var $sub_kegiatan;
	var $keterangan;
	var $nama_kuasa;
	var $nip_kuasa;
	var $tahun_anggaran;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_spj';
		$this->TableName = 't_spj';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_spj`";
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
		$this->id = new cField('t_spj', 't_spj', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// jenis_spj
		$this->jenis_spj = new cField('t_spj', 't_spj', 'x_jenis_spj', 'jenis_spj', '`jenis_spj`', '`jenis_spj`', 3, -1, FALSE, '`jenis_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->jenis_spj->Sortable = TRUE; // Allow sort
		$this->jenis_spj->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->jenis_spj->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->jenis_spj->OptionCount = 2;
		$this->jenis_spj->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jenis_spj'] = &$this->jenis_spj;

		// no_spj
		$this->no_spj = new cField('t_spj', 't_spj', 'x_no_spj', 'no_spj', '`no_spj`', '`no_spj`', 200, -1, FALSE, '`no_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spj->Sortable = TRUE; // Allow sort
		$this->fields['no_spj'] = &$this->no_spj;

		// tgl_spj
		$this->tgl_spj = new cField('t_spj', 't_spj', 'x_tgl_spj', 'tgl_spj', '`tgl_spj`', ew_CastDateFieldForLike('`tgl_spj`', 7, "DB"), 135, 7, FALSE, '`tgl_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_spj->Sortable = TRUE; // Allow sort
		$this->tgl_spj->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_spj'] = &$this->tgl_spj;

		// program
		$this->program = new cField('t_spj', 't_spj', 'x_program', 'program', '`program`', '`program`', 200, -1, FALSE, '`program`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->program->Sortable = TRUE; // Allow sort
		$this->program->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->program->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['program'] = &$this->program;

		// kegiatan
		$this->kegiatan = new cField('t_spj', 't_spj', 'x_kegiatan', 'kegiatan', '`kegiatan`', '`kegiatan`', 200, -1, FALSE, '`kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kegiatan->Sortable = TRUE; // Allow sort
		$this->kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kegiatan'] = &$this->kegiatan;

		// sub_kegiatan
		$this->sub_kegiatan = new cField('t_spj', 't_spj', 'x_sub_kegiatan', 'sub_kegiatan', '`sub_kegiatan`', '`sub_kegiatan`', 200, -1, FALSE, '`sub_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->sub_kegiatan->Sortable = TRUE; // Allow sort
		$this->sub_kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->sub_kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['sub_kegiatan'] = &$this->sub_kegiatan;

		// keterangan
		$this->keterangan = new cField('t_spj', 't_spj', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// nama_kuasa
		$this->nama_kuasa = new cField('t_spj', 't_spj', 'x_nama_kuasa', 'nama_kuasa', '`nama_kuasa`', '`nama_kuasa`', 200, -1, FALSE, '`nama_kuasa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_kuasa->Sortable = FALSE; // Allow sort
		$this->fields['nama_kuasa'] = &$this->nama_kuasa;

		// nip_kuasa
		$this->nip_kuasa = new cField('t_spj', 't_spj', 'x_nip_kuasa', 'nip_kuasa', '`nip_kuasa`', '`nip_kuasa`', 200, -1, FALSE, '`nip_kuasa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_kuasa->Sortable = FALSE; // Allow sort
		$this->fields['nip_kuasa'] = &$this->nip_kuasa;

		// tahun_anggaran
		$this->tahun_anggaran = new cField('t_spj', 't_spj', 'x_tahun_anggaran', 'tahun_anggaran', '`tahun_anggaran`', '`tahun_anggaran`', 3, -1, FALSE, '`tahun_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun_anggaran->Sortable = TRUE; // Allow sort
		$this->tahun_anggaran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tahun_anggaran'] = &$this->tahun_anggaran;
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
		if ($this->getCurrentDetailTable() == "detail_spj") {
			$sDetailUrl = $GLOBALS["detail_spj"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_no_spj=" . urlencode($this->no_spj->CurrentValue);
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
			$sDetailUrl .= "&fk_tgl_spj=" . urlencode($this->tgl_spj->CurrentValue);
			$sDetailUrl .= "&fk_program=" . urlencode($this->program->CurrentValue);
			$sDetailUrl .= "&fk_kegiatan=" . urlencode($this->kegiatan->CurrentValue);
			$sDetailUrl .= "&fk_tahun_anggaran=" . urlencode($this->tahun_anggaran->CurrentValue);
			$sDetailUrl .= "&fk_sub_kegiatan=" . urlencode($this->sub_kegiatan->CurrentValue);
			$sDetailUrl .= "&fk_jenis_spj=" . urlencode($this->jenis_spj->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "t_spjlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_spj`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`id` DESC";
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

		// Cascade Update detail table 'detail_spj'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['no_spj']) && $rsold['no_spj'] <> $rs['no_spj'])) { // Update detail field 'no_spj'
			$bCascadeUpdate = TRUE;
			$rscascade['no_spj'] = $rs['no_spj']; 
		}
		if (!is_null($rsold) && (isset($rs['id']) && $rsold['id'] <> $rs['id'])) { // Update detail field 'id_spj'
			$bCascadeUpdate = TRUE;
			$rscascade['id_spj'] = $rs['id']; 
		}
		if (!is_null($rsold) && (isset($rs['tgl_spj']) && $rsold['tgl_spj'] <> $rs['tgl_spj'])) { // Update detail field 'tgl_spj'
			$bCascadeUpdate = TRUE;
			$rscascade['tgl_spj'] = $rs['tgl_spj']; 
		}
		if (!is_null($rsold) && (isset($rs['program']) && $rsold['program'] <> $rs['program'])) { // Update detail field 'program'
			$bCascadeUpdate = TRUE;
			$rscascade['program'] = $rs['program']; 
		}
		if (!is_null($rsold) && (isset($rs['kegiatan']) && $rsold['kegiatan'] <> $rs['kegiatan'])) { // Update detail field 'kegiatan'
			$bCascadeUpdate = TRUE;
			$rscascade['kegiatan'] = $rs['kegiatan']; 
		}
		if (!is_null($rsold) && (isset($rs['tahun_anggaran']) && $rsold['tahun_anggaran'] <> $rs['tahun_anggaran'])) { // Update detail field 'tahun_anggaran'
			$bCascadeUpdate = TRUE;
			$rscascade['tahun_anggaran'] = $rs['tahun_anggaran']; 
		}
		if (!is_null($rsold) && (isset($rs['sub_kegiatan']) && $rsold['sub_kegiatan'] <> $rs['sub_kegiatan'])) { // Update detail field 'sub_kegiatan'
			$bCascadeUpdate = TRUE;
			$rscascade['sub_kegiatan'] = $rs['sub_kegiatan']; 
		}
		if (!is_null($rsold) && (isset($rs['jenis_spj']) && $rsold['jenis_spj'] <> $rs['jenis_spj'])) { // Update detail field 'jenis_spj'
			$bCascadeUpdate = TRUE;
			$rscascade['jenis_spj'] = $rs['jenis_spj']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["detail_spj"])) $GLOBALS["detail_spj"] = new cdetail_spj();
			$rswrk = $GLOBALS["detail_spj"]->LoadRs("`no_spj` = " . ew_QuotedValue($rsold['no_spj'], EW_DATATYPE_STRING, 'DB') . " AND " . "`id_spj` = " . ew_QuotedValue($rsold['id'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`tgl_spj` = " . ew_QuotedValue($rsold['tgl_spj'], EW_DATATYPE_DATE, 'DB') . " AND " . "`program` = " . ew_QuotedValue($rsold['program'], EW_DATATYPE_STRING, 'DB') . " AND " . "`kegiatan` = " . ew_QuotedValue($rsold['kegiatan'], EW_DATATYPE_STRING, 'DB') . " AND " . "`tahun_anggaran` = " . ew_QuotedValue($rsold['tahun_anggaran'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`sub_kegiatan` = " . ew_QuotedValue($rsold['sub_kegiatan'], EW_DATATYPE_STRING, 'DB') . " AND " . "`jenis_spj` = " . ew_QuotedValue($rsold['jenis_spj'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$bUpdate = $GLOBALS["detail_spj"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;
				$rswrk->MoveNext();
			}
		}
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

		// Cascade delete detail table 'detail_spj'
		if (!isset($GLOBALS["detail_spj"])) $GLOBALS["detail_spj"] = new cdetail_spj();
		$rscascade = $GLOBALS["detail_spj"]->LoadRs("`no_spj` = " . ew_QuotedValue($rs['no_spj'], EW_DATATYPE_STRING, "DB") . " AND " . "`id_spj` = " . ew_QuotedValue($rs['id'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`tgl_spj` = " . ew_QuotedValue($rs['tgl_spj'], EW_DATATYPE_DATE, "DB") . " AND " . "`program` = " . ew_QuotedValue($rs['program'], EW_DATATYPE_STRING, "DB") . " AND " . "`kegiatan` = " . ew_QuotedValue($rs['kegiatan'], EW_DATATYPE_STRING, "DB") . " AND " . "`tahun_anggaran` = " . ew_QuotedValue($rs['tahun_anggaran'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`sub_kegiatan` = " . ew_QuotedValue($rs['sub_kegiatan'], EW_DATATYPE_STRING, "DB") . " AND " . "`jenis_spj` = " . ew_QuotedValue($rs['jenis_spj'], EW_DATATYPE_NUMBER, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["detail_spj"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}
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
			return "t_spjlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_spjlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_spjview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_spjview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_spjadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_spjadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_spjedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_spjedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("t_spjadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_spjadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_spjdelete.php", $this->UrlParm());
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
		$this->jenis_spj->setDbValue($rs->fields('jenis_spj'));
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->nama_kuasa->setDbValue($rs->fields('nama_kuasa'));
		$this->nip_kuasa->setDbValue($rs->fields('nip_kuasa'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// jenis_spj
		// no_spj
		// tgl_spj
		// program
		// kegiatan
		// sub_kegiatan
		// keterangan
		// nama_kuasa

		$this->nama_kuasa->CellCssStyle = "white-space: nowrap;";

		// nip_kuasa
		$this->nip_kuasa->CellCssStyle = "white-space: nowrap;";

		// tahun_anggaran
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// jenis_spj
		if (strval($this->jenis_spj->CurrentValue) <> "") {
			$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
		} else {
			$this->jenis_spj->ViewValue = NULL;
		}
		$this->jenis_spj->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 7);
		$this->tgl_spj->ViewCustomAttributes = "";

		// program
		if (strval($this->program->CurrentValue) <> "") {
			$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->program->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
		$sWhereWrk = "";
		$this->program->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->program, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->program->ViewValue = $this->program->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->program->ViewValue = $this->program->CurrentValue;
			}
		} else {
			$this->program->ViewValue = NULL;
		}
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		if (strval($this->kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
		$sWhereWrk = "";
		$this->kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kegiatan->ViewValue = $this->kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
			}
		} else {
			$this->kegiatan->ViewValue = NULL;
		}
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		if (strval($this->sub_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_sub_kegiatan`" . ew_SearchString("=", $this->sub_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_sub_kegiatan`, `nama_sub_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_sub_kegiatan`";
		$sWhereWrk = "";
		$this->sub_kegiatan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
			}
		} else {
			$this->sub_kegiatan->ViewValue = NULL;
		}
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// nama_kuasa
		$this->nama_kuasa->ViewValue = $this->nama_kuasa->CurrentValue;
		$this->nama_kuasa->ViewCustomAttributes = "";

		// nip_kuasa
		$this->nip_kuasa->ViewValue = $this->nip_kuasa->CurrentValue;
		$this->nip_kuasa->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// jenis_spj
		$this->jenis_spj->LinkCustomAttributes = "";
		$this->jenis_spj->HrefValue = "";
		$this->jenis_spj->TooltipValue = "";

		// no_spj
		$this->no_spj->LinkCustomAttributes = "";
		$this->no_spj->HrefValue = "";
		$this->no_spj->TooltipValue = "";

		// tgl_spj
		$this->tgl_spj->LinkCustomAttributes = "";
		$this->tgl_spj->HrefValue = "";
		$this->tgl_spj->TooltipValue = "";

		// program
		$this->program->LinkCustomAttributes = "";
		$this->program->HrefValue = "";
		$this->program->TooltipValue = "";

		// kegiatan
		$this->kegiatan->LinkCustomAttributes = "";
		$this->kegiatan->HrefValue = "";
		$this->kegiatan->TooltipValue = "";

		// sub_kegiatan
		$this->sub_kegiatan->LinkCustomAttributes = "";
		$this->sub_kegiatan->HrefValue = "";
		$this->sub_kegiatan->TooltipValue = "";

		// keterangan
		$this->keterangan->LinkCustomAttributes = "";
		$this->keterangan->HrefValue = "";
		$this->keterangan->TooltipValue = "";

		// nama_kuasa
		$this->nama_kuasa->LinkCustomAttributes = "";
		$this->nama_kuasa->HrefValue = "";
		$this->nama_kuasa->TooltipValue = "";

		// nip_kuasa
		$this->nip_kuasa->LinkCustomAttributes = "";
		$this->nip_kuasa->HrefValue = "";
		$this->nip_kuasa->TooltipValue = "";

		// tahun_anggaran
		$this->tahun_anggaran->LinkCustomAttributes = "";
		$this->tahun_anggaran->HrefValue = "";
		$this->tahun_anggaran->TooltipValue = "";

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

		// jenis_spj
		$this->jenis_spj->EditAttrs["class"] = "form-control";
		$this->jenis_spj->EditCustomAttributes = "";
		$this->jenis_spj->EditValue = $this->jenis_spj->Options(TRUE);

		// no_spj
		$this->no_spj->EditAttrs["class"] = "form-control";
		$this->no_spj->EditCustomAttributes = "";
		$this->no_spj->EditValue = $this->no_spj->CurrentValue;
		$this->no_spj->PlaceHolder = ew_RemoveHtml($this->no_spj->FldCaption());

		// tgl_spj
		$this->tgl_spj->EditAttrs["class"] = "form-control";
		$this->tgl_spj->EditCustomAttributes = "";
		$this->tgl_spj->EditValue = ew_FormatDateTime($this->tgl_spj->CurrentValue, 7);
		$this->tgl_spj->PlaceHolder = ew_RemoveHtml($this->tgl_spj->FldCaption());

		// program
		$this->program->EditAttrs["class"] = "form-control";
		$this->program->EditCustomAttributes = "";

		// kegiatan
		$this->kegiatan->EditAttrs["class"] = "form-control";
		$this->kegiatan->EditCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->EditAttrs["class"] = "form-control";
		$this->sub_kegiatan->EditCustomAttributes = "";

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// nama_kuasa
		$this->nama_kuasa->EditAttrs["class"] = "form-control";
		$this->nama_kuasa->EditCustomAttributes = "";
		$this->nama_kuasa->EditValue = $this->nama_kuasa->CurrentValue;
		$this->nama_kuasa->PlaceHolder = ew_RemoveHtml($this->nama_kuasa->FldCaption());

		// nip_kuasa
		$this->nip_kuasa->EditAttrs["class"] = "form-control";
		$this->nip_kuasa->EditCustomAttributes = "";
		$this->nip_kuasa->EditValue = $this->nip_kuasa->CurrentValue;
		$this->nip_kuasa->PlaceHolder = ew_RemoveHtml($this->nip_kuasa->FldCaption());

		// tahun_anggaran
		$this->tahun_anggaran->EditAttrs["class"] = "form-control";
		$this->tahun_anggaran->EditCustomAttributes = "";
		$this->tahun_anggaran->EditValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

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
					if ($this->jenis_spj->Exportable) $Doc->ExportCaption($this->jenis_spj);
					if ($this->no_spj->Exportable) $Doc->ExportCaption($this->no_spj);
					if ($this->tgl_spj->Exportable) $Doc->ExportCaption($this->tgl_spj);
					if ($this->program->Exportable) $Doc->ExportCaption($this->program);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->sub_kegiatan->Exportable) $Doc->ExportCaption($this->sub_kegiatan);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->tahun_anggaran->Exportable) $Doc->ExportCaption($this->tahun_anggaran);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->jenis_spj->Exportable) $Doc->ExportCaption($this->jenis_spj);
					if ($this->no_spj->Exportable) $Doc->ExportCaption($this->no_spj);
					if ($this->tgl_spj->Exportable) $Doc->ExportCaption($this->tgl_spj);
					if ($this->program->Exportable) $Doc->ExportCaption($this->program);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->sub_kegiatan->Exportable) $Doc->ExportCaption($this->sub_kegiatan);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->tahun_anggaran->Exportable) $Doc->ExportCaption($this->tahun_anggaran);
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
						if ($this->jenis_spj->Exportable) $Doc->ExportField($this->jenis_spj);
						if ($this->no_spj->Exportable) $Doc->ExportField($this->no_spj);
						if ($this->tgl_spj->Exportable) $Doc->ExportField($this->tgl_spj);
						if ($this->program->Exportable) $Doc->ExportField($this->program);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->sub_kegiatan->Exportable) $Doc->ExportField($this->sub_kegiatan);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->tahun_anggaran->Exportable) $Doc->ExportField($this->tahun_anggaran);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->jenis_spj->Exportable) $Doc->ExportField($this->jenis_spj);
						if ($this->no_spj->Exportable) $Doc->ExportField($this->no_spj);
						if ($this->tgl_spj->Exportable) $Doc->ExportField($this->tgl_spj);
						if ($this->program->Exportable) $Doc->ExportField($this->program);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->sub_kegiatan->Exportable) $Doc->ExportField($this->sub_kegiatan);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->tahun_anggaran->Exportable) $Doc->ExportField($this->tahun_anggaran);
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
		$spj_no = $rsnew["no_spj"];
		if($spj_no == null)
		{
			$rsnew["no_spj"] = GetNextNomerSPJ();
		}else{
		}
		return TRUE;
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

			$spj_no = $this->no_spj->CurrentValue;
		if($spj_no == null)
		{
			if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
				$this->no_spj->CurrentValue = GetNextNomerSPJ(); // trik
				$this->no_spj->EditValue = $this->no_spj->CurrentValue; // tampilkan

			//$this->no_spm->ReadOnly = TRUE; // supaya tidak bisa diubah
			}

			// Kondisi saat form Tambah sedang dalam mode konfirmasi
			if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
				$this->no_spj->ViewValue = $this->no_spj->CurrentValue; // ambil dari mode sebelumnya
				}
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
