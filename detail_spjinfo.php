<?php

// Global variable for table object
$detail_spj = NULL;

//
// Table class for detail_spj
//
class cdetail_spj extends cTable {
	var $id;
	var $id_detail_sbp;
	var $no_spj;
	var $id_sbp;
	var $no_sbp;
	var $program;
	var $kegiatan;
	var $sub_kegiatan;
	var $tahun_anggaran;
	var $tgl_spj;
	var $id_spj;
	var $jenis_spj;
	var $jumlah_belanja;
	var $uraian;
	var $pajak;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'detail_spj';
		$this->TableName = 'detail_spj';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`detail_spj`";
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
		$this->id = new cField('detail_spj', 'detail_spj', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// id_detail_sbp
		$this->id_detail_sbp = new cField('detail_spj', 'detail_spj', 'x_id_detail_sbp', 'id_detail_sbp', '`id_detail_sbp`', '`id_detail_sbp`', 3, -1, FALSE, '`id_detail_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_detail_sbp->Sortable = TRUE; // Allow sort
		$this->id_detail_sbp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_detail_sbp'] = &$this->id_detail_sbp;

		// no_spj
		$this->no_spj = new cField('detail_spj', 'detail_spj', 'x_no_spj', 'no_spj', '`no_spj`', '`no_spj`', 200, -1, FALSE, '`no_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spj->Sortable = TRUE; // Allow sort
		$this->fields['no_spj'] = &$this->no_spj;

		// id_sbp
		$this->id_sbp = new cField('detail_spj', 'detail_spj', 'x_id_sbp', 'id_sbp', '`id_sbp`', '`id_sbp`', 3, -1, FALSE, '`id_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_sbp->Sortable = TRUE; // Allow sort
		$this->id_sbp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_sbp'] = &$this->id_sbp;

		// no_sbp
		$this->no_sbp = new cField('detail_spj', 'detail_spj', 'x_no_sbp', 'no_sbp', '`no_sbp`', '`no_sbp`', 200, -1, FALSE, '`no_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_sbp->Sortable = TRUE; // Allow sort
		$this->fields['no_sbp'] = &$this->no_sbp;

		// program
		$this->program = new cField('detail_spj', 'detail_spj', 'x_program', 'program', '`program`', '`program`', 200, -1, FALSE, '`program`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->program->Sortable = TRUE; // Allow sort
		$this->fields['program'] = &$this->program;

		// kegiatan
		$this->kegiatan = new cField('detail_spj', 'detail_spj', 'x_kegiatan', 'kegiatan', '`kegiatan`', '`kegiatan`', 200, -1, FALSE, '`kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kegiatan->Sortable = TRUE; // Allow sort
		$this->fields['kegiatan'] = &$this->kegiatan;

		// sub_kegiatan
		$this->sub_kegiatan = new cField('detail_spj', 'detail_spj', 'x_sub_kegiatan', 'sub_kegiatan', '`sub_kegiatan`', '`sub_kegiatan`', 200, -1, FALSE, '`sub_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sub_kegiatan->Sortable = TRUE; // Allow sort
		$this->fields['sub_kegiatan'] = &$this->sub_kegiatan;

		// tahun_anggaran
		$this->tahun_anggaran = new cField('detail_spj', 'detail_spj', 'x_tahun_anggaran', 'tahun_anggaran', '`tahun_anggaran`', '`tahun_anggaran`', 3, -1, FALSE, '`tahun_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun_anggaran->Sortable = TRUE; // Allow sort
		$this->tahun_anggaran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tahun_anggaran'] = &$this->tahun_anggaran;

		// tgl_spj
		$this->tgl_spj = new cField('detail_spj', 'detail_spj', 'x_tgl_spj', 'tgl_spj', '`tgl_spj`', ew_CastDateFieldForLike('`tgl_spj`', 0, "DB"), 135, 0, FALSE, '`tgl_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_spj->Sortable = TRUE; // Allow sort
		$this->tgl_spj->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_spj'] = &$this->tgl_spj;

		// id_spj
		$this->id_spj = new cField('detail_spj', 'detail_spj', 'x_id_spj', 'id_spj', '`id_spj`', '`id_spj`', 3, -1, FALSE, '`id_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_spj->Sortable = TRUE; // Allow sort
		$this->id_spj->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_spj'] = &$this->id_spj;

		// jenis_spj
		$this->jenis_spj = new cField('detail_spj', 'detail_spj', 'x_jenis_spj', 'jenis_spj', '`jenis_spj`', '`jenis_spj`', 3, -1, FALSE, '`jenis_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->jenis_spj->Sortable = TRUE; // Allow sort
		$this->jenis_spj->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->jenis_spj->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->jenis_spj->OptionCount = 2;
		$this->jenis_spj->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jenis_spj'] = &$this->jenis_spj;

		// jumlah_belanja
		$this->jumlah_belanja = new cField('detail_spj', 'detail_spj', 'x_jumlah_belanja', 'jumlah_belanja', '`jumlah_belanja`', '`jumlah_belanja`', 5, -1, FALSE, '`jumlah_belanja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_belanja->Sortable = TRUE; // Allow sort
		$this->jumlah_belanja->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_belanja'] = &$this->jumlah_belanja;

		// uraian
		$this->uraian = new cField('detail_spj', 'detail_spj', 'x_uraian', 'uraian', '`uraian`', '`uraian`', 201, -1, FALSE, '`uraian`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->uraian->Sortable = TRUE; // Allow sort
		$this->fields['uraian'] = &$this->uraian;

		// pajak
		$this->pajak = new cField('detail_spj', 'detail_spj', 'x_pajak', 'pajak', '`pajak`', '`pajak`', 5, -1, FALSE, '`pajak`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pajak->Sortable = TRUE; // Allow sort
		$this->pajak->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pajak'] = &$this->pajak;
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
		if ($this->getCurrentMasterTable() == "t_spj") {
			if ($this->no_spj->getSessionValue() <> "")
				$sMasterFilter .= "`no_spj`=" . ew_QuotedValue($this->no_spj->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->id_spj->getSessionValue() <> "")
				$sMasterFilter .= " AND `id`=" . ew_QuotedValue($this->id_spj->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->tgl_spj->getSessionValue() <> "")
				$sMasterFilter .= " AND `tgl_spj`=" . ew_QuotedValue($this->tgl_spj->getSessionValue(), EW_DATATYPE_DATE, "DB");
			else
				return "";
			if ($this->program->getSessionValue() <> "")
				$sMasterFilter .= " AND `program`=" . ew_QuotedValue($this->program->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->kegiatan->getSessionValue() <> "")
				$sMasterFilter .= " AND `kegiatan`=" . ew_QuotedValue($this->kegiatan->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->tahun_anggaran->getSessionValue() <> "")
				$sMasterFilter .= " AND `tahun_anggaran`=" . ew_QuotedValue($this->tahun_anggaran->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->sub_kegiatan->getSessionValue() <> "")
				$sMasterFilter .= " AND `sub_kegiatan`=" . ew_QuotedValue($this->sub_kegiatan->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->jenis_spj->getSessionValue() <> "")
				$sMasterFilter .= " AND `jenis_spj`=" . ew_QuotedValue($this->jenis_spj->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "t_spj") {
			if ($this->no_spj->getSessionValue() <> "")
				$sDetailFilter .= "`no_spj`=" . ew_QuotedValue($this->no_spj->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->id_spj->getSessionValue() <> "")
				$sDetailFilter .= " AND `id_spj`=" . ew_QuotedValue($this->id_spj->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->tgl_spj->getSessionValue() <> "")
				$sDetailFilter .= " AND `tgl_spj`=" . ew_QuotedValue($this->tgl_spj->getSessionValue(), EW_DATATYPE_DATE, "DB");
			else
				return "";
			if ($this->program->getSessionValue() <> "")
				$sDetailFilter .= " AND `program`=" . ew_QuotedValue($this->program->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->kegiatan->getSessionValue() <> "")
				$sDetailFilter .= " AND `kegiatan`=" . ew_QuotedValue($this->kegiatan->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->tahun_anggaran->getSessionValue() <> "")
				$sDetailFilter .= " AND `tahun_anggaran`=" . ew_QuotedValue($this->tahun_anggaran->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->sub_kegiatan->getSessionValue() <> "")
				$sDetailFilter .= " AND `sub_kegiatan`=" . ew_QuotedValue($this->sub_kegiatan->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->jenis_spj->getSessionValue() <> "")
				$sDetailFilter .= " AND `jenis_spj`=" . ew_QuotedValue($this->jenis_spj->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_t_spj() {
		return "`no_spj`='@no_spj@' AND `id`=@id@ AND `tgl_spj`='@tgl_spj@' AND `program`='@program@' AND `kegiatan`='@kegiatan@' AND `tahun_anggaran`=@tahun_anggaran@ AND `sub_kegiatan`='@sub_kegiatan@' AND `jenis_spj`=@jenis_spj@";
	}

	// Detail filter
	function SqlDetailFilter_t_spj() {
		return "`no_spj`='@no_spj@' AND `id_spj`=@id_spj@ AND `tgl_spj`='@tgl_spj@' AND `program`='@program@' AND `kegiatan`='@kegiatan@' AND `tahun_anggaran`=@tahun_anggaran@ AND `sub_kegiatan`='@sub_kegiatan@' AND `jenis_spj`=@jenis_spj@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`detail_spj`";
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
			return "detail_spjlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "detail_spjlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("detail_spjview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("detail_spjview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "detail_spjadd.php?" . $this->UrlParm($parm);
		else
			$url = "detail_spjadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("detail_spjedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("detail_spjadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("detail_spjdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "t_spj" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_no_spj=" . urlencode($this->no_spj->CurrentValue);
			$url .= "&fk_id=" . urlencode($this->id_spj->CurrentValue);
			$url .= "&fk_tgl_spj=" . urlencode(ew_UnFormatDateTime($this->tgl_spj->CurrentValue,0));
			$url .= "&fk_program=" . urlencode($this->program->CurrentValue);
			$url .= "&fk_kegiatan=" . urlencode($this->kegiatan->CurrentValue);
			$url .= "&fk_tahun_anggaran=" . urlencode($this->tahun_anggaran->CurrentValue);
			$url .= "&fk_sub_kegiatan=" . urlencode($this->sub_kegiatan->CurrentValue);
			$url .= "&fk_jenis_spj=" . urlencode($this->jenis_spj->CurrentValue);
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
		$this->id_detail_sbp->setDbValue($rs->fields('id_detail_sbp'));
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->id_sbp->setDbValue($rs->fields('id_sbp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->id_spj->setDbValue($rs->fields('id_spj'));
		$this->jenis_spj->setDbValue($rs->fields('jenis_spj'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->pajak->setDbValue($rs->fields('pajak'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// id_detail_sbp
		// no_spj
		// id_sbp
		// no_sbp
		// program
		// kegiatan
		// sub_kegiatan
		// tahun_anggaran
		// tgl_spj
		// id_spj
		// jenis_spj
		// jumlah_belanja
		// uraian
		// pajak
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_detail_sbp
		$this->id_detail_sbp->ViewValue = $this->id_detail_sbp->CurrentValue;
		if (strval($this->id_detail_sbp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_detail_sbp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_sbp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_list_spj`";
		$sWhereWrk = "";
		$this->id_detail_sbp->LookupFilters = array("dx1" => '`no_sbp`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_detail_sbp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_detail_sbp->ViewValue = $this->id_detail_sbp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_detail_sbp->ViewValue = $this->id_detail_sbp->CurrentValue;
			}
		} else {
			$this->id_detail_sbp->ViewValue = NULL;
		}
		$this->id_detail_sbp->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// id_sbp
		$this->id_sbp->ViewValue = $this->id_sbp->CurrentValue;
		$this->id_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

		// program
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";

		// kegiatan
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 0);
		$this->tgl_spj->ViewCustomAttributes = "";

		// id_spj
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		$this->id_spj->ViewCustomAttributes = "";

		// jenis_spj
		if (strval($this->jenis_spj->CurrentValue) <> "") {
			$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
		} else {
			$this->jenis_spj->ViewValue = NULL;
		}
		$this->jenis_spj->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

		// uraian
		$this->uraian->ViewValue = $this->uraian->CurrentValue;
		$this->uraian->ViewCustomAttributes = "";

		// pajak
		$this->pajak->ViewValue = $this->pajak->CurrentValue;
		$this->pajak->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// id_detail_sbp
		$this->id_detail_sbp->LinkCustomAttributes = "";
		$this->id_detail_sbp->HrefValue = "";
		$this->id_detail_sbp->TooltipValue = "";

		// no_spj
		$this->no_spj->LinkCustomAttributes = "";
		$this->no_spj->HrefValue = "";
		$this->no_spj->TooltipValue = "";

		// id_sbp
		$this->id_sbp->LinkCustomAttributes = "";
		$this->id_sbp->HrefValue = "";
		$this->id_sbp->TooltipValue = "";

		// no_sbp
		$this->no_sbp->LinkCustomAttributes = "";
		$this->no_sbp->HrefValue = "";
		$this->no_sbp->TooltipValue = "";

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

		// tahun_anggaran
		$this->tahun_anggaran->LinkCustomAttributes = "";
		$this->tahun_anggaran->HrefValue = "";
		$this->tahun_anggaran->TooltipValue = "";

		// tgl_spj
		$this->tgl_spj->LinkCustomAttributes = "";
		$this->tgl_spj->HrefValue = "";
		$this->tgl_spj->TooltipValue = "";

		// id_spj
		$this->id_spj->LinkCustomAttributes = "";
		$this->id_spj->HrefValue = "";
		$this->id_spj->TooltipValue = "";

		// jenis_spj
		$this->jenis_spj->LinkCustomAttributes = "";
		$this->jenis_spj->HrefValue = "";
		$this->jenis_spj->TooltipValue = "";

		// jumlah_belanja
		$this->jumlah_belanja->LinkCustomAttributes = "";
		$this->jumlah_belanja->HrefValue = "";
		$this->jumlah_belanja->TooltipValue = "";

		// uraian
		$this->uraian->LinkCustomAttributes = "";
		$this->uraian->HrefValue = "";
		$this->uraian->TooltipValue = "";

		// pajak
		$this->pajak->LinkCustomAttributes = "";
		$this->pajak->HrefValue = "";
		$this->pajak->TooltipValue = "";

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

		// id_detail_sbp
		$this->id_detail_sbp->EditAttrs["class"] = "form-control";
		$this->id_detail_sbp->EditCustomAttributes = "";
		$this->id_detail_sbp->EditValue = $this->id_detail_sbp->CurrentValue;
		$this->id_detail_sbp->PlaceHolder = ew_RemoveHtml($this->id_detail_sbp->FldCaption());

		// no_spj
		$this->no_spj->EditAttrs["class"] = "form-control";
		$this->no_spj->EditCustomAttributes = "";
		if ($this->no_spj->getSessionValue() <> "") {
			$this->no_spj->CurrentValue = $this->no_spj->getSessionValue();
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";
		} else {
		$this->no_spj->EditValue = $this->no_spj->CurrentValue;
		$this->no_spj->PlaceHolder = ew_RemoveHtml($this->no_spj->FldCaption());
		}

		// id_sbp
		$this->id_sbp->EditAttrs["class"] = "form-control";
		$this->id_sbp->EditCustomAttributes = "";
		$this->id_sbp->EditValue = $this->id_sbp->CurrentValue;
		$this->id_sbp->PlaceHolder = ew_RemoveHtml($this->id_sbp->FldCaption());

		// no_sbp
		$this->no_sbp->EditAttrs["class"] = "form-control";
		$this->no_sbp->EditCustomAttributes = "";
		$this->no_sbp->EditValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->PlaceHolder = ew_RemoveHtml($this->no_sbp->FldCaption());

		// program
		$this->program->EditAttrs["class"] = "form-control";
		$this->program->EditCustomAttributes = "";
		if ($this->program->getSessionValue() <> "") {
			$this->program->CurrentValue = $this->program->getSessionValue();
		$this->program->ViewValue = $this->program->CurrentValue;
		$this->program->ViewCustomAttributes = "";
		} else {
		$this->program->EditValue = $this->program->CurrentValue;
		$this->program->PlaceHolder = ew_RemoveHtml($this->program->FldCaption());
		}

		// kegiatan
		$this->kegiatan->EditAttrs["class"] = "form-control";
		$this->kegiatan->EditCustomAttributes = "";
		if ($this->kegiatan->getSessionValue() <> "") {
			$this->kegiatan->CurrentValue = $this->kegiatan->getSessionValue();
		$this->kegiatan->ViewValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->ViewCustomAttributes = "";
		} else {
		$this->kegiatan->EditValue = $this->kegiatan->CurrentValue;
		$this->kegiatan->PlaceHolder = ew_RemoveHtml($this->kegiatan->FldCaption());
		}

		// sub_kegiatan
		$this->sub_kegiatan->EditAttrs["class"] = "form-control";
		$this->sub_kegiatan->EditCustomAttributes = "";
		if ($this->sub_kegiatan->getSessionValue() <> "") {
			$this->sub_kegiatan->CurrentValue = $this->sub_kegiatan->getSessionValue();
		$this->sub_kegiatan->ViewValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->ViewCustomAttributes = "";
		} else {
		$this->sub_kegiatan->EditValue = $this->sub_kegiatan->CurrentValue;
		$this->sub_kegiatan->PlaceHolder = ew_RemoveHtml($this->sub_kegiatan->FldCaption());
		}

		// tahun_anggaran
		$this->tahun_anggaran->EditAttrs["class"] = "form-control";
		$this->tahun_anggaran->EditCustomAttributes = "";
		if ($this->tahun_anggaran->getSessionValue() <> "") {
			$this->tahun_anggaran->CurrentValue = $this->tahun_anggaran->getSessionValue();
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";
		} else {
		$this->tahun_anggaran->EditValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());
		}

		// tgl_spj
		$this->tgl_spj->EditAttrs["class"] = "form-control";
		$this->tgl_spj->EditCustomAttributes = "";
		if ($this->tgl_spj->getSessionValue() <> "") {
			$this->tgl_spj->CurrentValue = $this->tgl_spj->getSessionValue();
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 0);
		$this->tgl_spj->ViewCustomAttributes = "";
		} else {
		$this->tgl_spj->EditValue = ew_FormatDateTime($this->tgl_spj->CurrentValue, 8);
		$this->tgl_spj->PlaceHolder = ew_RemoveHtml($this->tgl_spj->FldCaption());
		}

		// id_spj
		$this->id_spj->EditAttrs["class"] = "form-control";
		$this->id_spj->EditCustomAttributes = "";
		if ($this->id_spj->getSessionValue() <> "") {
			$this->id_spj->CurrentValue = $this->id_spj->getSessionValue();
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		$this->id_spj->ViewCustomAttributes = "";
		} else {
		$this->id_spj->EditValue = $this->id_spj->CurrentValue;
		$this->id_spj->PlaceHolder = ew_RemoveHtml($this->id_spj->FldCaption());
		}

		// jenis_spj
		$this->jenis_spj->EditAttrs["class"] = "form-control";
		$this->jenis_spj->EditCustomAttributes = "";
		if ($this->jenis_spj->getSessionValue() <> "") {
			$this->jenis_spj->CurrentValue = $this->jenis_spj->getSessionValue();
		if (strval($this->jenis_spj->CurrentValue) <> "") {
			$this->jenis_spj->ViewValue = $this->jenis_spj->OptionCaption($this->jenis_spj->CurrentValue);
		} else {
			$this->jenis_spj->ViewValue = NULL;
		}
		$this->jenis_spj->ViewCustomAttributes = "";
		} else {
		$this->jenis_spj->EditValue = $this->jenis_spj->Options(TRUE);
		}

		// jumlah_belanja
		$this->jumlah_belanja->EditAttrs["class"] = "form-control";
		$this->jumlah_belanja->EditCustomAttributes = "";
		$this->jumlah_belanja->EditValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
		if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

		// uraian
		$this->uraian->EditAttrs["class"] = "form-control";
		$this->uraian->EditCustomAttributes = "";
		$this->uraian->EditValue = $this->uraian->CurrentValue;
		$this->uraian->PlaceHolder = ew_RemoveHtml($this->uraian->FldCaption());

		// pajak
		$this->pajak->EditAttrs["class"] = "form-control";
		$this->pajak->EditCustomAttributes = "";
		$this->pajak->EditValue = $this->pajak->CurrentValue;
		$this->pajak->PlaceHolder = ew_RemoveHtml($this->pajak->FldCaption());
		if (strval($this->pajak->EditValue) <> "" && is_numeric($this->pajak->EditValue)) $this->pajak->EditValue = ew_FormatNumber($this->pajak->EditValue, -2, -1, -2, 0);

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
					if ($this->id_detail_sbp->Exportable) $Doc->ExportCaption($this->id_detail_sbp);
					if ($this->no_spj->Exportable) $Doc->ExportCaption($this->no_spj);
					if ($this->id_sbp->Exportable) $Doc->ExportCaption($this->id_sbp);
					if ($this->no_sbp->Exportable) $Doc->ExportCaption($this->no_sbp);
					if ($this->program->Exportable) $Doc->ExportCaption($this->program);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->sub_kegiatan->Exportable) $Doc->ExportCaption($this->sub_kegiatan);
					if ($this->tahun_anggaran->Exportable) $Doc->ExportCaption($this->tahun_anggaran);
					if ($this->tgl_spj->Exportable) $Doc->ExportCaption($this->tgl_spj);
					if ($this->id_spj->Exportable) $Doc->ExportCaption($this->id_spj);
					if ($this->jenis_spj->Exportable) $Doc->ExportCaption($this->jenis_spj);
					if ($this->jumlah_belanja->Exportable) $Doc->ExportCaption($this->jumlah_belanja);
					if ($this->uraian->Exportable) $Doc->ExportCaption($this->uraian);
					if ($this->pajak->Exportable) $Doc->ExportCaption($this->pajak);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->id_detail_sbp->Exportable) $Doc->ExportCaption($this->id_detail_sbp);
					if ($this->no_spj->Exportable) $Doc->ExportCaption($this->no_spj);
					if ($this->id_sbp->Exportable) $Doc->ExportCaption($this->id_sbp);
					if ($this->no_sbp->Exportable) $Doc->ExportCaption($this->no_sbp);
					if ($this->program->Exportable) $Doc->ExportCaption($this->program);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->sub_kegiatan->Exportable) $Doc->ExportCaption($this->sub_kegiatan);
					if ($this->tahun_anggaran->Exportable) $Doc->ExportCaption($this->tahun_anggaran);
					if ($this->tgl_spj->Exportable) $Doc->ExportCaption($this->tgl_spj);
					if ($this->id_spj->Exportable) $Doc->ExportCaption($this->id_spj);
					if ($this->jenis_spj->Exportable) $Doc->ExportCaption($this->jenis_spj);
					if ($this->jumlah_belanja->Exportable) $Doc->ExportCaption($this->jumlah_belanja);
					if ($this->pajak->Exportable) $Doc->ExportCaption($this->pajak);
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
						if ($this->id_detail_sbp->Exportable) $Doc->ExportField($this->id_detail_sbp);
						if ($this->no_spj->Exportable) $Doc->ExportField($this->no_spj);
						if ($this->id_sbp->Exportable) $Doc->ExportField($this->id_sbp);
						if ($this->no_sbp->Exportable) $Doc->ExportField($this->no_sbp);
						if ($this->program->Exportable) $Doc->ExportField($this->program);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->sub_kegiatan->Exportable) $Doc->ExportField($this->sub_kegiatan);
						if ($this->tahun_anggaran->Exportable) $Doc->ExportField($this->tahun_anggaran);
						if ($this->tgl_spj->Exportable) $Doc->ExportField($this->tgl_spj);
						if ($this->id_spj->Exportable) $Doc->ExportField($this->id_spj);
						if ($this->jenis_spj->Exportable) $Doc->ExportField($this->jenis_spj);
						if ($this->jumlah_belanja->Exportable) $Doc->ExportField($this->jumlah_belanja);
						if ($this->uraian->Exportable) $Doc->ExportField($this->uraian);
						if ($this->pajak->Exportable) $Doc->ExportField($this->pajak);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->id_detail_sbp->Exportable) $Doc->ExportField($this->id_detail_sbp);
						if ($this->no_spj->Exportable) $Doc->ExportField($this->no_spj);
						if ($this->id_sbp->Exportable) $Doc->ExportField($this->id_sbp);
						if ($this->no_sbp->Exportable) $Doc->ExportField($this->no_sbp);
						if ($this->program->Exportable) $Doc->ExportField($this->program);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->sub_kegiatan->Exportable) $Doc->ExportField($this->sub_kegiatan);
						if ($this->tahun_anggaran->Exportable) $Doc->ExportField($this->tahun_anggaran);
						if ($this->tgl_spj->Exportable) $Doc->ExportField($this->tgl_spj);
						if ($this->id_spj->Exportable) $Doc->ExportField($this->id_spj);
						if ($this->jenis_spj->Exportable) $Doc->ExportField($this->jenis_spj);
						if ($this->jumlah_belanja->Exportable) $Doc->ExportField($this->jumlah_belanja);
						if ($this->pajak->Exportable) $Doc->ExportField($this->pajak);
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
		if (preg_match('/^x(\d)*_id_detail_sbp$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `id_sbp` AS FIELD0, `no_sbp` AS FIELD1 FROM `vw_list_spj`";
			$sWhereWrk = "(`id` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->id_detail_sbp->LookupFilters = array("dx1" => '`no_sbp`');
			$this->Lookup_Selecting($this->id_detail_sbp, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->id_sbp->setDbValue($rs->fields[0]);
					$this->no_sbp->setDbValue($rs->fields[1]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->id_sbp->AutoFillOriginalValue) ? $this->id_sbp->CurrentValue : $this->id_sbp->EditValue;
					$ar[] = ($this->no_sbp->AutoFillOriginalValue) ? $this->no_sbp->CurrentValue : $this->no_sbp->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}

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

		$rsnew["pajak"] = ew_ExecuteScalar("SELECT IFNULL(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_sbp_detail where id_sbp = ".$rsnew["id_sbp"]." and  kd_rekening_belanja LIKE '7%'");
		$rsnew["jumlah_belanja"] = ew_ExecuteScalar("SELECT IFNULL(SUM(jumlah_belanja),0) as 'JUMLAH_BELANJA' FROM simrs2012.t_sbp_detail where id_sbp = ".$rsnew["id_sbp"]." and  kd_rekening_belanja LIKE '5%'");
		$rsnew["uraian"] = ew_ExecuteScalar("SELECT uraian FROM simrs2012.t_sbp where id = ".$rsnew["id_sbp"]." ");
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
