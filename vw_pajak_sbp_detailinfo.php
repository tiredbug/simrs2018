<?php

// Global variable for table object
$vw_pajak_sbp_detail = NULL;

//
// Table class for vw_pajak_sbp_detail
//
class cvw_pajak_sbp_detail extends cTable {
	var $id;
	var $id_sbp;
	var $tipe_sbp;
	var $detail_jenis_spp;
	var $no_sbp;
	var $program;
	var $kegiatan;
	var $sub_kegiatan;
	var $tahun_anggaran;
	var $akun1;
	var $akun2;
	var $akun3;
	var $akun4;
	var $akun5;
	var $jumlah_belanja;
	var $kd_rekening_belanja;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_pajak_sbp_detail';
		$this->TableName = 'vw_pajak_sbp_detail';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_pajak_sbp_detail`";
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
		$this->id = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = FALSE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// id_sbp
		$this->id_sbp = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_id_sbp', 'id_sbp', '`id_sbp`', '`id_sbp`', 3, -1, FALSE, '`id_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_sbp->Sortable = FALSE; // Allow sort
		$this->id_sbp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_sbp'] = &$this->id_sbp;

		// tipe_sbp
		$this->tipe_sbp = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_tipe_sbp', 'tipe_sbp', '`tipe_sbp`', '`tipe_sbp`', 3, -1, FALSE, '`tipe_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tipe_sbp->Sortable = FALSE; // Allow sort
		$this->tipe_sbp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tipe_sbp'] = &$this->tipe_sbp;

		// detail_jenis_spp
		$this->detail_jenis_spp = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_detail_jenis_spp', 'detail_jenis_spp', '`detail_jenis_spp`', '`detail_jenis_spp`', 3, -1, FALSE, '`detail_jenis_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detail_jenis_spp->Sortable = FALSE; // Allow sort
		$this->detail_jenis_spp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['detail_jenis_spp'] = &$this->detail_jenis_spp;

		// no_sbp
		$this->no_sbp = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_no_sbp', 'no_sbp', '`no_sbp`', '`no_sbp`', 200, -1, FALSE, '`no_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_sbp->Sortable = FALSE; // Allow sort
		$this->fields['no_sbp'] = &$this->no_sbp;

		// program
		$this->program = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_program', 'program', '`program`', '`program`', 200, -1, FALSE, '`program`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->program->Sortable = FALSE; // Allow sort
		$this->fields['program'] = &$this->program;

		// kegiatan
		$this->kegiatan = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_kegiatan', 'kegiatan', '`kegiatan`', '`kegiatan`', 200, -1, FALSE, '`kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kegiatan->Sortable = FALSE; // Allow sort
		$this->fields['kegiatan'] = &$this->kegiatan;

		// sub_kegiatan
		$this->sub_kegiatan = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_sub_kegiatan', 'sub_kegiatan', '`sub_kegiatan`', '`sub_kegiatan`', 200, -1, FALSE, '`sub_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sub_kegiatan->Sortable = FALSE; // Allow sort
		$this->fields['sub_kegiatan'] = &$this->sub_kegiatan;

		// tahun_anggaran
		$this->tahun_anggaran = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_tahun_anggaran', 'tahun_anggaran', '`tahun_anggaran`', '`tahun_anggaran`', 3, -1, FALSE, '`tahun_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun_anggaran->Sortable = FALSE; // Allow sort
		$this->tahun_anggaran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tahun_anggaran'] = &$this->tahun_anggaran;

		// akun1
		$this->akun1 = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_akun1', 'akun1', '`akun1`', '`akun1`', 200, -1, FALSE, '`akun1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun1->Sortable = FALSE; // Allow sort
		$this->fields['akun1'] = &$this->akun1;

		// akun2
		$this->akun2 = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_akun2', 'akun2', '`akun2`', '`akun2`', 200, -1, FALSE, '`akun2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun2->Sortable = FALSE; // Allow sort
		$this->fields['akun2'] = &$this->akun2;

		// akun3
		$this->akun3 = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_akun3', 'akun3', '`akun3`', '`akun3`', 200, -1, FALSE, '`akun3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun3->Sortable = FALSE; // Allow sort
		$this->fields['akun3'] = &$this->akun3;

		// akun4
		$this->akun4 = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_akun4', 'akun4', '`akun4`', '`akun4`', 200, -1, FALSE, '`akun4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun4->Sortable = FALSE; // Allow sort
		$this->fields['akun4'] = &$this->akun4;

		// akun5
		$this->akun5 = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_akun5', 'akun5', '`akun5`', '`akun5`', 200, -1, FALSE, '`akun5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->akun5->Sortable = FALSE; // Allow sort
		$this->akun5->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->akun5->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['akun5'] = &$this->akun5;

		// jumlah_belanja
		$this->jumlah_belanja = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_jumlah_belanja', 'jumlah_belanja', '`jumlah_belanja`', '`jumlah_belanja`', 5, -1, FALSE, '`jumlah_belanja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_belanja->Sortable = FALSE; // Allow sort
		$this->jumlah_belanja->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_belanja'] = &$this->jumlah_belanja;

		// kd_rekening_belanja
		$this->kd_rekening_belanja = new cField('vw_pajak_sbp_detail', 'vw_pajak_sbp_detail', 'x_kd_rekening_belanja', 'kd_rekening_belanja', '`kd_rekening_belanja`', '`kd_rekening_belanja`', 200, -1, FALSE, '`kd_rekening_belanja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kd_rekening_belanja->Sortable = FALSE; // Allow sort
		$this->fields['kd_rekening_belanja'] = &$this->kd_rekening_belanja;
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
		if ($this->getCurrentMasterTable() == "t_sbp") {
			if ($this->id_sbp->getSessionValue() <> "")
				$sMasterFilter .= "`id`=" . ew_QuotedValue($this->id_sbp->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->tipe_sbp->getSessionValue() <> "")
				$sMasterFilter .= " AND `tipe_sbp`=" . ew_QuotedValue($this->tipe_sbp->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->no_sbp->getSessionValue() <> "")
				$sMasterFilter .= " AND `no_sbp`=" . ew_QuotedValue($this->no_sbp->getSessionValue(), EW_DATATYPE_STRING, "DB");
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
			if ($this->sub_kegiatan->getSessionValue() <> "")
				$sMasterFilter .= " AND `sub_kegiatan`=" . ew_QuotedValue($this->sub_kegiatan->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->tahun_anggaran->getSessionValue() <> "")
				$sMasterFilter .= " AND `tahun_anggaran`=" . ew_QuotedValue($this->tahun_anggaran->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "t_sbp") {
			if ($this->id_sbp->getSessionValue() <> "")
				$sDetailFilter .= "`id_sbp`=" . ew_QuotedValue($this->id_sbp->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->tipe_sbp->getSessionValue() <> "")
				$sDetailFilter .= " AND `tipe_sbp`=" . ew_QuotedValue($this->tipe_sbp->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->no_sbp->getSessionValue() <> "")
				$sDetailFilter .= " AND `no_sbp`=" . ew_QuotedValue($this->no_sbp->getSessionValue(), EW_DATATYPE_STRING, "DB");
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
			if ($this->sub_kegiatan->getSessionValue() <> "")
				$sDetailFilter .= " AND `sub_kegiatan`=" . ew_QuotedValue($this->sub_kegiatan->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->tahun_anggaran->getSessionValue() <> "")
				$sDetailFilter .= " AND `tahun_anggaran`=" . ew_QuotedValue($this->tahun_anggaran->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_t_sbp() {
		return "`id`=@id@ AND `tipe_sbp`=@tipe_sbp@ AND `no_sbp`='@no_sbp@' AND `program`='@program@' AND `kegiatan`='@kegiatan@' AND `sub_kegiatan`='@sub_kegiatan@' AND `tahun_anggaran`=@tahun_anggaran@";
	}

	// Detail filter
	function SqlDetailFilter_t_sbp() {
		return "`id_sbp`=@id_sbp@ AND `tipe_sbp`=@tipe_sbp@ AND `no_sbp`='@no_sbp@' AND `program`='@program@' AND `kegiatan`='@kegiatan@' AND `sub_kegiatan`='@sub_kegiatan@' AND `tahun_anggaran`=@tahun_anggaran@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_pajak_sbp_detail`";
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
		$this->TableFilter = "`kd_rekening_belanja` LIKE '7%'";
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
			return "vw_pajak_sbp_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_pajak_sbp_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_pajak_sbp_detailview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_pajak_sbp_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_pajak_sbp_detailadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_pajak_sbp_detailadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_pajak_sbp_detailedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_pajak_sbp_detailadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_pajak_sbp_detaildelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "t_sbp" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_id=" . urlencode($this->id_sbp->CurrentValue);
			$url .= "&fk_tipe_sbp=" . urlencode($this->tipe_sbp->CurrentValue);
			$url .= "&fk_no_sbp=" . urlencode($this->no_sbp->CurrentValue);
			$url .= "&fk_program=" . urlencode($this->program->CurrentValue);
			$url .= "&fk_kegiatan=" . urlencode($this->kegiatan->CurrentValue);
			$url .= "&fk_sub_kegiatan=" . urlencode($this->sub_kegiatan->CurrentValue);
			$url .= "&fk_tahun_anggaran=" . urlencode($this->tahun_anggaran->CurrentValue);
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
		$this->id_sbp->setDbValue($rs->fields('id_sbp'));
		$this->tipe_sbp->setDbValue($rs->fields('tipe_sbp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->kd_rekening_belanja->setDbValue($rs->fields('kd_rekening_belanja'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id

		$this->id->CellCssStyle = "white-space: nowrap;";

		// id_sbp
		$this->id_sbp->CellCssStyle = "white-space: nowrap;";

		// tipe_sbp
		$this->tipe_sbp->CellCssStyle = "white-space: nowrap;";

		// detail_jenis_spp
		$this->detail_jenis_spp->CellCssStyle = "white-space: nowrap;";

		// no_sbp
		$this->no_sbp->CellCssStyle = "white-space: nowrap;";

		// program
		$this->program->CellCssStyle = "white-space: nowrap;";

		// kegiatan
		$this->kegiatan->CellCssStyle = "white-space: nowrap;";

		// sub_kegiatan
		$this->sub_kegiatan->CellCssStyle = "white-space: nowrap;";

		// tahun_anggaran
		$this->tahun_anggaran->CellCssStyle = "white-space: nowrap;";

		// akun1
		$this->akun1->CellCssStyle = "white-space: nowrap;";

		// akun2
		$this->akun2->CellCssStyle = "white-space: nowrap;";

		// akun3
		$this->akun3->CellCssStyle = "white-space: nowrap;";

		// akun4
		$this->akun4->CellCssStyle = "white-space: nowrap;";

		// akun5
		$this->akun5->CellCssStyle = "white-space: nowrap;";

		// jumlah_belanja
		$this->jumlah_belanja->CellCssStyle = "white-space: nowrap;";

		// kd_rekening_belanja
		$this->kd_rekening_belanja->CellCssStyle = "white-space: nowrap;";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_sbp
		$this->id_sbp->ViewValue = $this->id_sbp->CurrentValue;
		$this->id_sbp->ViewCustomAttributes = "";

		// tipe_sbp
		$this->tipe_sbp->ViewValue = $this->tipe_sbp->CurrentValue;
		$this->tipe_sbp->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->ViewCustomAttributes = "";

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

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		$this->akun2->ViewValue = $this->akun2->CurrentValue;
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		$this->akun3->ViewValue = $this->akun3->CurrentValue;
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		$this->akun4->ViewValue = $this->akun4->CurrentValue;
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		if (strval($this->akun5->CurrentValue) <> "") {
			$sFilterWrk = "`akun5`" . ew_SearchString("=", $this->akun5->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `akun5`, `nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
		$sWhereWrk = "";
		$this->akun5->LookupFilters = array();
		$lookuptblfilter = "`kd_akun`='7.1.1.04.02' or `kd_akun` ='7.1.1.05.01' ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun5, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun5->ViewValue = $this->akun5->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun5->ViewValue = $this->akun5->CurrentValue;
			}
		} else {
			$this->akun5->ViewValue = NULL;
		}
		$this->akun5->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

		// kd_rekening_belanja
		$this->kd_rekening_belanja->ViewValue = $this->kd_rekening_belanja->CurrentValue;
		$this->kd_rekening_belanja->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// id_sbp
		$this->id_sbp->LinkCustomAttributes = "";
		$this->id_sbp->HrefValue = "";
		$this->id_sbp->TooltipValue = "";

		// tipe_sbp
		$this->tipe_sbp->LinkCustomAttributes = "";
		$this->tipe_sbp->HrefValue = "";
		$this->tipe_sbp->TooltipValue = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->LinkCustomAttributes = "";
		$this->detail_jenis_spp->HrefValue = "";
		$this->detail_jenis_spp->TooltipValue = "";

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

		// akun1
		$this->akun1->LinkCustomAttributes = "";
		$this->akun1->HrefValue = "";
		$this->akun1->TooltipValue = "";

		// akun2
		$this->akun2->LinkCustomAttributes = "";
		$this->akun2->HrefValue = "";
		$this->akun2->TooltipValue = "";

		// akun3
		$this->akun3->LinkCustomAttributes = "";
		$this->akun3->HrefValue = "";
		$this->akun3->TooltipValue = "";

		// akun4
		$this->akun4->LinkCustomAttributes = "";
		$this->akun4->HrefValue = "";
		$this->akun4->TooltipValue = "";

		// akun5
		$this->akun5->LinkCustomAttributes = "";
		$this->akun5->HrefValue = "";
		$this->akun5->TooltipValue = "";

		// jumlah_belanja
		$this->jumlah_belanja->LinkCustomAttributes = "";
		$this->jumlah_belanja->HrefValue = "";
		$this->jumlah_belanja->TooltipValue = "";

		// kd_rekening_belanja
		$this->kd_rekening_belanja->LinkCustomAttributes = "";
		$this->kd_rekening_belanja->HrefValue = "";
		$this->kd_rekening_belanja->TooltipValue = "";

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

		// id_sbp
		$this->id_sbp->EditAttrs["class"] = "form-control";
		$this->id_sbp->EditCustomAttributes = "";
		if ($this->id_sbp->getSessionValue() <> "") {
			$this->id_sbp->CurrentValue = $this->id_sbp->getSessionValue();
		$this->id_sbp->ViewValue = $this->id_sbp->CurrentValue;
		$this->id_sbp->ViewCustomAttributes = "";
		} else {
		$this->id_sbp->EditValue = $this->id_sbp->CurrentValue;
		$this->id_sbp->PlaceHolder = ew_RemoveHtml($this->id_sbp->FldCaption());
		}

		// tipe_sbp
		$this->tipe_sbp->EditAttrs["class"] = "form-control";
		$this->tipe_sbp->EditCustomAttributes = "";
		if ($this->tipe_sbp->getSessionValue() <> "") {
			$this->tipe_sbp->CurrentValue = $this->tipe_sbp->getSessionValue();
		$this->tipe_sbp->ViewValue = $this->tipe_sbp->CurrentValue;
		$this->tipe_sbp->ViewCustomAttributes = "";
		} else {
		$this->tipe_sbp->EditValue = $this->tipe_sbp->CurrentValue;
		$this->tipe_sbp->PlaceHolder = ew_RemoveHtml($this->tipe_sbp->FldCaption());
		}

		// detail_jenis_spp
		$this->detail_jenis_spp->EditAttrs["class"] = "form-control";
		$this->detail_jenis_spp->EditCustomAttributes = "";
		$this->detail_jenis_spp->EditValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->PlaceHolder = ew_RemoveHtml($this->detail_jenis_spp->FldCaption());

		// no_sbp
		$this->no_sbp->EditAttrs["class"] = "form-control";
		$this->no_sbp->EditCustomAttributes = "";
		if ($this->no_sbp->getSessionValue() <> "") {
			$this->no_sbp->CurrentValue = $this->no_sbp->getSessionValue();
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";
		} else {
		$this->no_sbp->EditValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->PlaceHolder = ew_RemoveHtml($this->no_sbp->FldCaption());
		}

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

		// akun1
		$this->akun1->EditAttrs["class"] = "form-control";
		$this->akun1->EditCustomAttributes = "";
		$this->akun1->EditValue = $this->akun1->CurrentValue;
		$this->akun1->PlaceHolder = ew_RemoveHtml($this->akun1->FldCaption());

		// akun2
		$this->akun2->EditAttrs["class"] = "form-control";
		$this->akun2->EditCustomAttributes = "";
		$this->akun2->EditValue = $this->akun2->CurrentValue;
		$this->akun2->PlaceHolder = ew_RemoveHtml($this->akun2->FldCaption());

		// akun3
		$this->akun3->EditAttrs["class"] = "form-control";
		$this->akun3->EditCustomAttributes = "";
		$this->akun3->EditValue = $this->akun3->CurrentValue;
		$this->akun3->PlaceHolder = ew_RemoveHtml($this->akun3->FldCaption());

		// akun4
		$this->akun4->EditAttrs["class"] = "form-control";
		$this->akun4->EditCustomAttributes = "";
		$this->akun4->EditValue = $this->akun4->CurrentValue;
		$this->akun4->PlaceHolder = ew_RemoveHtml($this->akun4->FldCaption());

		// akun5
		$this->akun5->EditAttrs["class"] = "form-control";
		$this->akun5->EditCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->EditAttrs["class"] = "form-control";
		$this->jumlah_belanja->EditCustomAttributes = "";
		$this->jumlah_belanja->EditValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
		if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

		// kd_rekening_belanja
		$this->kd_rekening_belanja->EditAttrs["class"] = "form-control";
		$this->kd_rekening_belanja->EditCustomAttributes = "";
		$this->kd_rekening_belanja->EditValue = $this->kd_rekening_belanja->CurrentValue;
		$this->kd_rekening_belanja->PlaceHolder = ew_RemoveHtml($this->kd_rekening_belanja->FldCaption());

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
				} else {
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
					} else {
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
		if (preg_match('/^x(\d)*_akun5$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `kd_akun` AS FIELD0 FROM `keu_akun5`";
			$sWhereWrk = "(`akun5` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->akun5->LookupFilters = array();
			$lookuptblfilter = "`kd_akun`='7.1.1.04.02' or `kd_akun` ='7.1.1.05.01' ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->akun5, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->kd_rekening_belanja->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->kd_rekening_belanja->AutoFillOriginalValue) ? $this->kd_rekening_belanja->CurrentValue : $this->kd_rekening_belanja->EditValue;
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

		$rsnew["akun1"] =  ew_ExecuteScalar("SELECT akun1 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kd_rekening_belanja"]."' LIMIT 1");
		$rsnew["akun2"] = ew_ExecuteScalar("SELECT akun2 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kd_rekening_belanja"]."' LIMIT 1");
		$rsnew["akun3"] = ew_ExecuteScalar("SELECT akun3 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kd_rekening_belanja"]."' LIMIT 1");
		$rsnew["akun4"] = ew_ExecuteScalar("SELECT akun4 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kd_rekening_belanja"]."' LIMIT 1");
		$rsnew["akun5"] = ew_ExecuteScalar("SELECT akun5 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kd_rekening_belanja"]."' LIMIT 1");
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
