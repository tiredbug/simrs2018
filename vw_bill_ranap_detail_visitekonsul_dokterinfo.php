<?php

// Global variable for table object
$vw_bill_ranap_detail_visitekonsul_dokter = NULL;

//
// Table class for vw_bill_ranap_detail_visitekonsul_dokter
//
class cvw_bill_ranap_detail_visitekonsul_dokter extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id;
	var $id_admission;
	var $nomr;
	var $statusbayar;
	var $kelas;
	var $tanggal;
	var $kode_tindakan;
	var $kode_dokter;
	var $qty;
	var $tarif;
	var $bhp;
	var $kelompok1;
	var $kelompok2;
	var $user;
	var $nama_tindakan;
	var $kelompok_tindakan;
	var $no_ruang;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_bill_ranap_detail_visitekonsul_dokter';
		$this->TableName = 'vw_bill_ranap_detail_visitekonsul_dokter';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_bill_ranap_detail_visitekonsul_dokter`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// id_admission
		$this->id_admission = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_id_admission', 'id_admission', '`id_admission`', '`id_admission`', 3, -1, FALSE, '`id_admission`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_admission->Sortable = TRUE; // Allow sort
		$this->id_admission->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_admission'] = &$this->id_admission;

		// nomr
		$this->nomr = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_nomr', 'nomr', '`nomr`', '`nomr`', 200, -1, FALSE, '`nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomr->Sortable = TRUE; // Allow sort
		$this->fields['nomr'] = &$this->nomr;

		// statusbayar
		$this->statusbayar = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_statusbayar', 'statusbayar', '`statusbayar`', '`statusbayar`', 3, -1, FALSE, '`statusbayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->statusbayar->Sortable = TRUE; // Allow sort
		$this->statusbayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statusbayar'] = &$this->statusbayar;

		// kelas
		$this->kelas = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_kelas', 'kelas', '`kelas`', '`kelas`', 3, -1, FALSE, '`kelas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelas->Sortable = TRUE; // Allow sort
		$this->kelas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelas'] = &$this->kelas;

		// tanggal
		$this->tanggal = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_tanggal', 'tanggal', '`tanggal`', ew_CastDateFieldForLike('`tanggal`', 7, "DB"), 135, 7, FALSE, '`tanggal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal->Sortable = TRUE; // Allow sort
		$this->tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tanggal'] = &$this->tanggal;

		// kode_tindakan
		$this->kode_tindakan = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_kode_tindakan', 'kode_tindakan', '`kode_tindakan`', '`kode_tindakan`', 3, -1, FALSE, '`kode_tindakan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kode_tindakan->Sortable = TRUE; // Allow sort
		$this->kode_tindakan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kode_tindakan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->kode_tindakan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kode_tindakan'] = &$this->kode_tindakan;

		// kode_dokter
		$this->kode_dokter = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_kode_dokter', 'kode_dokter', '`kode_dokter`', '`kode_dokter`', 3, -1, FALSE, '`kode_dokter`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kode_dokter->Sortable = TRUE; // Allow sort
		$this->kode_dokter->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kode_dokter->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->kode_dokter->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kode_dokter'] = &$this->kode_dokter;

		// qty
		$this->qty = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_qty', 'qty', '`qty`', '`qty`', 3, -1, FALSE, '`qty`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->qty->Sortable = TRUE; // Allow sort
		$this->qty->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['qty'] = &$this->qty;

		// tarif
		$this->tarif = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_tarif', 'tarif', '`tarif`', '`tarif`', 5, -1, FALSE, '`tarif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tarif->Sortable = TRUE; // Allow sort
		$this->tarif->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['tarif'] = &$this->tarif;

		// bhp
		$this->bhp = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_bhp', 'bhp', '`bhp`', '`bhp`', 5, -1, FALSE, '`bhp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bhp->Sortable = TRUE; // Allow sort
		$this->bhp->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['bhp'] = &$this->bhp;

		// kelompok1
		$this->kelompok1 = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_kelompok1', 'kelompok1', '`kelompok1`', '`kelompok1`', 3, -1, FALSE, '`kelompok1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelompok1->Sortable = TRUE; // Allow sort
		$this->kelompok1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelompok1'] = &$this->kelompok1;

		// kelompok2
		$this->kelompok2 = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_kelompok2', 'kelompok2', '`kelompok2`', '`kelompok2`', 3, -1, FALSE, '`kelompok2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelompok2->Sortable = TRUE; // Allow sort
		$this->kelompok2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelompok2'] = &$this->kelompok2;

		// user
		$this->user = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_user', 'user', '`user`', '`user`', 200, -1, FALSE, '`user`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user->Sortable = TRUE; // Allow sort
		$this->fields['user'] = &$this->user;

		// nama_tindakan
		$this->nama_tindakan = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_nama_tindakan', 'nama_tindakan', '`nama_tindakan`', '`nama_tindakan`', 200, -1, FALSE, '`nama_tindakan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_tindakan->Sortable = TRUE; // Allow sort
		$this->fields['nama_tindakan'] = &$this->nama_tindakan;

		// kelompok_tindakan
		$this->kelompok_tindakan = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_kelompok_tindakan', 'kelompok_tindakan', '`kelompok_tindakan`', '`kelompok_tindakan`', 3, -1, FALSE, '`kelompok_tindakan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelompok_tindakan->Sortable = TRUE; // Allow sort
		$this->kelompok_tindakan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelompok_tindakan'] = &$this->kelompok_tindakan;

		// no_ruang
		$this->no_ruang = new cField('vw_bill_ranap_detail_visitekonsul_dokter', 'vw_bill_ranap_detail_visitekonsul_dokter', 'x_no_ruang', 'no_ruang', '`no_ruang`', '`no_ruang`', 3, -1, FALSE, '`no_ruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_ruang->Sortable = TRUE; // Allow sort
		$this->no_ruang->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['no_ruang'] = &$this->no_ruang;
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
		if ($this->getCurrentMasterTable() == "vw_bill_ranap") {
			if ($this->id_admission->getSessionValue() <> "")
				$sMasterFilter .= "`id_admission`=" . ew_QuotedValue($this->id_admission->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->nomr->getSessionValue() <> "")
				$sMasterFilter .= " AND `nomr`=" . ew_QuotedValue($this->nomr->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->statusbayar->getSessionValue() <> "")
				$sMasterFilter .= " AND `statusbayar`=" . ew_QuotedValue($this->statusbayar->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->kelas->getSessionValue() <> "")
				$sMasterFilter .= " AND `KELASPERAWATAN_ID`=" . ew_QuotedValue($this->kelas->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->no_ruang->getSessionValue() <> "")
				$sMasterFilter .= " AND `noruang`=" . ew_QuotedValue($this->no_ruang->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "vw_bill_ranap") {
			if ($this->id_admission->getSessionValue() <> "")
				$sDetailFilter .= "`id_admission`=" . ew_QuotedValue($this->id_admission->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->nomr->getSessionValue() <> "")
				$sDetailFilter .= " AND `nomr`=" . ew_QuotedValue($this->nomr->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->statusbayar->getSessionValue() <> "")
				$sDetailFilter .= " AND `statusbayar`=" . ew_QuotedValue($this->statusbayar->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->kelas->getSessionValue() <> "")
				$sDetailFilter .= " AND `kelas`=" . ew_QuotedValue($this->kelas->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->no_ruang->getSessionValue() <> "")
				$sDetailFilter .= " AND `no_ruang`=" . ew_QuotedValue($this->no_ruang->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_vw_bill_ranap() {
		return "`id_admission`=@id_admission@ AND `nomr`='@nomr@' AND `statusbayar`=@statusbayar@ AND `KELASPERAWATAN_ID`=@KELASPERAWATAN_ID@ AND `noruang`=@noruang@";
	}

	// Detail filter
	function SqlDetailFilter_vw_bill_ranap() {
		return "`id_admission`=@id_admission@ AND `nomr`='@nomr@' AND `statusbayar`=@statusbayar@ AND `kelas`=@kelas@ AND `no_ruang`=@no_ruang@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_bill_ranap_detail_visitekonsul_dokter`";
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
			if ($this->AuditTrailOnAdd)
				$this->WriteAuditTrailOnAdd($rs);
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
		if ($bUpdate && $this->AuditTrailOnEdit) {
			$rsaudit = $rs;
			$fldname = 'id';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
			$this->WriteAuditTrailOnEdit($rsold, $rsaudit);
		}
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
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
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
			return "vw_bill_ranap_detail_visitekonsul_dokterlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_bill_ranap_detail_visitekonsul_dokterlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_bill_ranap_detail_visitekonsul_dokterview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_bill_ranap_detail_visitekonsul_dokterview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_bill_ranap_detail_visitekonsul_dokteradd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_bill_ranap_detail_visitekonsul_dokteradd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_bill_ranap_detail_visitekonsul_dokteredit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_bill_ranap_detail_visitekonsul_dokteradd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_bill_ranap_detail_visitekonsul_dokterdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "vw_bill_ranap" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_id_admission=" . urlencode($this->id_admission->CurrentValue);
			$url .= "&fk_nomr=" . urlencode($this->nomr->CurrentValue);
			$url .= "&fk_statusbayar=" . urlencode($this->statusbayar->CurrentValue);
			$url .= "&fk_KELASPERAWATAN_ID=" . urlencode($this->kelas->CurrentValue);
			$url .= "&fk_noruang=" . urlencode($this->no_ruang->CurrentValue);
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->kode_tindakan->setDbValue($rs->fields('kode_tindakan'));
		$this->kode_dokter->setDbValue($rs->fields('kode_dokter'));
		$this->qty->setDbValue($rs->fields('qty'));
		$this->tarif->setDbValue($rs->fields('tarif'));
		$this->bhp->setDbValue($rs->fields('bhp'));
		$this->kelompok1->setDbValue($rs->fields('kelompok1'));
		$this->kelompok2->setDbValue($rs->fields('kelompok2'));
		$this->user->setDbValue($rs->fields('user'));
		$this->nama_tindakan->setDbValue($rs->fields('nama_tindakan'));
		$this->kelompok_tindakan->setDbValue($rs->fields('kelompok_tindakan'));
		$this->no_ruang->setDbValue($rs->fields('no_ruang'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// id_admission
		// nomr
		// statusbayar
		// kelas
		// tanggal
		// kode_tindakan
		// kode_dokter
		// qty
		// tarif
		// bhp
		// kelompok1
		// kelompok2
		// user
		// nama_tindakan
		// kelompok_tindakan
		// no_ruang
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
		$this->statusbayar->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->ViewCustomAttributes = "";

		// kode_tindakan
		if (strval($this->kode_tindakan->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kode_tindakan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama_tindakan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_bill_ranap_data_tarif_tindakan`";
		$sWhereWrk = "";
		$this->kode_tindakan->LookupFilters = array();
		$lookuptblfilter = "`kelompok_tindakan`='6'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_tindakan->ViewValue = $this->kode_tindakan->CurrentValue;
			}
		} else {
			$this->kode_tindakan->ViewValue = NULL;
		}
		$this->kode_tindakan->ViewCustomAttributes = "";

		// kode_dokter
		if (strval($this->kode_dokter->CurrentValue) <> "") {
			$sFilterWrk = "`kd_dokter`" . ew_SearchString("=", $this->kode_dokter->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kd_dokter`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_dokter_jaga_ranap`";
		$sWhereWrk = "";
		$this->kode_dokter->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_dokter, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_dokter->ViewValue = $this->kode_dokter->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_dokter->ViewValue = $this->kode_dokter->CurrentValue;
			}
		} else {
			$this->kode_dokter->ViewValue = NULL;
		}
		$this->kode_dokter->ViewCustomAttributes = "";

		// qty
		$this->qty->ViewValue = $this->qty->CurrentValue;
		$this->qty->ViewCustomAttributes = "";

		// tarif
		$this->tarif->ViewValue = $this->tarif->CurrentValue;
		$this->tarif->ViewCustomAttributes = "";

		// bhp
		$this->bhp->ViewValue = $this->bhp->CurrentValue;
		$this->bhp->ViewCustomAttributes = "";

		// kelompok1
		$this->kelompok1->ViewValue = $this->kelompok1->CurrentValue;
		$this->kelompok1->ViewCustomAttributes = "";

		// kelompok2
		$this->kelompok2->ViewValue = $this->kelompok2->CurrentValue;
		$this->kelompok2->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// nama_tindakan
		$this->nama_tindakan->ViewValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->ViewCustomAttributes = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->ViewValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->ViewCustomAttributes = "";

		// no_ruang
		$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// id_admission
		$this->id_admission->LinkCustomAttributes = "";
		$this->id_admission->HrefValue = "";
		$this->id_admission->TooltipValue = "";

		// nomr
		$this->nomr->LinkCustomAttributes = "";
		$this->nomr->HrefValue = "";
		$this->nomr->TooltipValue = "";

		// statusbayar
		$this->statusbayar->LinkCustomAttributes = "";
		$this->statusbayar->HrefValue = "";
		$this->statusbayar->TooltipValue = "";

		// kelas
		$this->kelas->LinkCustomAttributes = "";
		$this->kelas->HrefValue = "";
		$this->kelas->TooltipValue = "";

		// tanggal
		$this->tanggal->LinkCustomAttributes = "";
		$this->tanggal->HrefValue = "";
		$this->tanggal->TooltipValue = "";

		// kode_tindakan
		$this->kode_tindakan->LinkCustomAttributes = "";
		$this->kode_tindakan->HrefValue = "";
		$this->kode_tindakan->TooltipValue = "";

		// kode_dokter
		$this->kode_dokter->LinkCustomAttributes = "";
		$this->kode_dokter->HrefValue = "";
		$this->kode_dokter->TooltipValue = "";

		// qty
		$this->qty->LinkCustomAttributes = "";
		$this->qty->HrefValue = "";
		$this->qty->TooltipValue = "";

		// tarif
		$this->tarif->LinkCustomAttributes = "";
		$this->tarif->HrefValue = "";
		$this->tarif->TooltipValue = "";

		// bhp
		$this->bhp->LinkCustomAttributes = "";
		$this->bhp->HrefValue = "";
		$this->bhp->TooltipValue = "";

		// kelompok1
		$this->kelompok1->LinkCustomAttributes = "";
		$this->kelompok1->HrefValue = "";
		$this->kelompok1->TooltipValue = "";

		// kelompok2
		$this->kelompok2->LinkCustomAttributes = "";
		$this->kelompok2->HrefValue = "";
		$this->kelompok2->TooltipValue = "";

		// user
		$this->user->LinkCustomAttributes = "";
		$this->user->HrefValue = "";
		$this->user->TooltipValue = "";

		// nama_tindakan
		$this->nama_tindakan->LinkCustomAttributes = "";
		$this->nama_tindakan->HrefValue = "";
		$this->nama_tindakan->TooltipValue = "";

		// kelompok_tindakan
		$this->kelompok_tindakan->LinkCustomAttributes = "";
		$this->kelompok_tindakan->HrefValue = "";
		$this->kelompok_tindakan->TooltipValue = "";

		// no_ruang
		$this->no_ruang->LinkCustomAttributes = "";
		$this->no_ruang->HrefValue = "";
		$this->no_ruang->TooltipValue = "";

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

		// id_admission
		$this->id_admission->EditAttrs["class"] = "form-control";
		$this->id_admission->EditCustomAttributes = "";
		if ($this->id_admission->getSessionValue() <> "") {
			$this->id_admission->CurrentValue = $this->id_admission->getSessionValue();
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";
		} else {
		$this->id_admission->EditValue = $this->id_admission->CurrentValue;
		$this->id_admission->PlaceHolder = ew_RemoveHtml($this->id_admission->FldCaption());
		}

		// nomr
		$this->nomr->EditAttrs["class"] = "form-control";
		$this->nomr->EditCustomAttributes = "";
		if ($this->nomr->getSessionValue() <> "") {
			$this->nomr->CurrentValue = $this->nomr->getSessionValue();
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";
		} else {
		$this->nomr->EditValue = $this->nomr->CurrentValue;
		$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());
		}

		// statusbayar
		$this->statusbayar->EditAttrs["class"] = "form-control";
		$this->statusbayar->EditCustomAttributes = "";
		if ($this->statusbayar->getSessionValue() <> "") {
			$this->statusbayar->CurrentValue = $this->statusbayar->getSessionValue();
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
		$this->statusbayar->ViewCustomAttributes = "";
		} else {
		$this->statusbayar->EditValue = $this->statusbayar->CurrentValue;
		$this->statusbayar->PlaceHolder = ew_RemoveHtml($this->statusbayar->FldCaption());
		}

		// kelas
		$this->kelas->EditAttrs["class"] = "form-control";
		$this->kelas->EditCustomAttributes = "";
		if ($this->kelas->getSessionValue() <> "") {
			$this->kelas->CurrentValue = $this->kelas->getSessionValue();
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";
		} else {
		$this->kelas->EditValue = $this->kelas->CurrentValue;
		$this->kelas->PlaceHolder = ew_RemoveHtml($this->kelas->FldCaption());
		}

		// tanggal
		$this->tanggal->EditAttrs["class"] = "form-control";
		$this->tanggal->EditCustomAttributes = "";
		$this->tanggal->EditValue = ew_FormatDateTime($this->tanggal->CurrentValue, 7);
		$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

		// kode_tindakan
		$this->kode_tindakan->EditAttrs["class"] = "form-control";
		$this->kode_tindakan->EditCustomAttributes = "";

		// kode_dokter
		$this->kode_dokter->EditAttrs["class"] = "form-control";
		$this->kode_dokter->EditCustomAttributes = "";

		// qty
		$this->qty->EditAttrs["class"] = "form-control";
		$this->qty->EditCustomAttributes = "";
		$this->qty->EditValue = $this->qty->CurrentValue;
		$this->qty->PlaceHolder = ew_RemoveHtml($this->qty->FldCaption());

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

		// kelompok1
		$this->kelompok1->EditAttrs["class"] = "form-control";
		$this->kelompok1->EditCustomAttributes = "";
		$this->kelompok1->EditValue = $this->kelompok1->CurrentValue;
		$this->kelompok1->PlaceHolder = ew_RemoveHtml($this->kelompok1->FldCaption());

		// kelompok2
		$this->kelompok2->EditAttrs["class"] = "form-control";
		$this->kelompok2->EditCustomAttributes = "";
		$this->kelompok2->EditValue = $this->kelompok2->CurrentValue;
		$this->kelompok2->PlaceHolder = ew_RemoveHtml($this->kelompok2->FldCaption());

		// user
		$this->user->EditAttrs["class"] = "form-control";
		$this->user->EditCustomAttributes = "";
		$this->user->EditValue = $this->user->CurrentValue;
		$this->user->PlaceHolder = ew_RemoveHtml($this->user->FldCaption());

		// nama_tindakan
		$this->nama_tindakan->EditAttrs["class"] = "form-control";
		$this->nama_tindakan->EditCustomAttributes = "";
		$this->nama_tindakan->EditValue = $this->nama_tindakan->CurrentValue;
		$this->nama_tindakan->PlaceHolder = ew_RemoveHtml($this->nama_tindakan->FldCaption());

		// kelompok_tindakan
		$this->kelompok_tindakan->EditAttrs["class"] = "form-control";
		$this->kelompok_tindakan->EditCustomAttributes = "";
		$this->kelompok_tindakan->EditValue = $this->kelompok_tindakan->CurrentValue;
		$this->kelompok_tindakan->PlaceHolder = ew_RemoveHtml($this->kelompok_tindakan->FldCaption());

		// no_ruang
		$this->no_ruang->EditAttrs["class"] = "form-control";
		$this->no_ruang->EditCustomAttributes = "";
		if ($this->no_ruang->getSessionValue() <> "") {
			$this->no_ruang->CurrentValue = $this->no_ruang->getSessionValue();
		$this->no_ruang->ViewValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->ViewCustomAttributes = "";
		} else {
		$this->no_ruang->EditValue = $this->no_ruang->CurrentValue;
		$this->no_ruang->PlaceHolder = ew_RemoveHtml($this->no_ruang->FldCaption());
		}

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
					if ($this->id_admission->Exportable) $Doc->ExportCaption($this->id_admission);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->kelas->Exportable) $Doc->ExportCaption($this->kelas);
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->kode_tindakan->Exportable) $Doc->ExportCaption($this->kode_tindakan);
					if ($this->kode_dokter->Exportable) $Doc->ExportCaption($this->kode_dokter);
					if ($this->qty->Exportable) $Doc->ExportCaption($this->qty);
					if ($this->tarif->Exportable) $Doc->ExportCaption($this->tarif);
					if ($this->bhp->Exportable) $Doc->ExportCaption($this->bhp);
					if ($this->kelompok1->Exportable) $Doc->ExportCaption($this->kelompok1);
					if ($this->kelompok2->Exportable) $Doc->ExportCaption($this->kelompok2);
					if ($this->user->Exportable) $Doc->ExportCaption($this->user);
					if ($this->nama_tindakan->Exportable) $Doc->ExportCaption($this->nama_tindakan);
					if ($this->kelompok_tindakan->Exportable) $Doc->ExportCaption($this->kelompok_tindakan);
					if ($this->no_ruang->Exportable) $Doc->ExportCaption($this->no_ruang);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->id_admission->Exportable) $Doc->ExportCaption($this->id_admission);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->kelas->Exportable) $Doc->ExportCaption($this->kelas);
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->kode_tindakan->Exportable) $Doc->ExportCaption($this->kode_tindakan);
					if ($this->kode_dokter->Exportable) $Doc->ExportCaption($this->kode_dokter);
					if ($this->qty->Exportable) $Doc->ExportCaption($this->qty);
					if ($this->tarif->Exportable) $Doc->ExportCaption($this->tarif);
					if ($this->bhp->Exportable) $Doc->ExportCaption($this->bhp);
					if ($this->kelompok1->Exportable) $Doc->ExportCaption($this->kelompok1);
					if ($this->kelompok2->Exportable) $Doc->ExportCaption($this->kelompok2);
					if ($this->user->Exportable) $Doc->ExportCaption($this->user);
					if ($this->nama_tindakan->Exportable) $Doc->ExportCaption($this->nama_tindakan);
					if ($this->kelompok_tindakan->Exportable) $Doc->ExportCaption($this->kelompok_tindakan);
					if ($this->no_ruang->Exportable) $Doc->ExportCaption($this->no_ruang);
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
						if ($this->id_admission->Exportable) $Doc->ExportField($this->id_admission);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->kelas->Exportable) $Doc->ExportField($this->kelas);
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->kode_tindakan->Exportable) $Doc->ExportField($this->kode_tindakan);
						if ($this->kode_dokter->Exportable) $Doc->ExportField($this->kode_dokter);
						if ($this->qty->Exportable) $Doc->ExportField($this->qty);
						if ($this->tarif->Exportable) $Doc->ExportField($this->tarif);
						if ($this->bhp->Exportable) $Doc->ExportField($this->bhp);
						if ($this->kelompok1->Exportable) $Doc->ExportField($this->kelompok1);
						if ($this->kelompok2->Exportable) $Doc->ExportField($this->kelompok2);
						if ($this->user->Exportable) $Doc->ExportField($this->user);
						if ($this->nama_tindakan->Exportable) $Doc->ExportField($this->nama_tindakan);
						if ($this->kelompok_tindakan->Exportable) $Doc->ExportField($this->kelompok_tindakan);
						if ($this->no_ruang->Exportable) $Doc->ExportField($this->no_ruang);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->id_admission->Exportable) $Doc->ExportField($this->id_admission);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->kelas->Exportable) $Doc->ExportField($this->kelas);
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->kode_tindakan->Exportable) $Doc->ExportField($this->kode_tindakan);
						if ($this->kode_dokter->Exportable) $Doc->ExportField($this->kode_dokter);
						if ($this->qty->Exportable) $Doc->ExportField($this->qty);
						if ($this->tarif->Exportable) $Doc->ExportField($this->tarif);
						if ($this->bhp->Exportable) $Doc->ExportField($this->bhp);
						if ($this->kelompok1->Exportable) $Doc->ExportField($this->kelompok1);
						if ($this->kelompok2->Exportable) $Doc->ExportField($this->kelompok2);
						if ($this->user->Exportable) $Doc->ExportField($this->user);
						if ($this->nama_tindakan->Exportable) $Doc->ExportField($this->nama_tindakan);
						if ($this->kelompok_tindakan->Exportable) $Doc->ExportField($this->kelompok_tindakan);
						if ($this->no_ruang->Exportable) $Doc->ExportField($this->no_ruang);
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
		if (preg_match('/^x(\d)*_kode_tindakan$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `tarif` AS FIELD0 FROM `vw_bill_ranap_data_tarif_tindakan`";
			$sWhereWrk = "(`kode` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->kode_tindakan->LookupFilters = array();
			$lookuptblfilter = "`kelompok_tindakan`='6'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->kode_tindakan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->tarif->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->tarif->AutoFillOriginalValue) ? $this->tarif->CurrentValue : $this->tarif->EditValue;
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'vw_bill_ranap_detail_visitekonsul_dokter';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'vw_bill_ranap_detail_visitekonsul_dokter';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'vw_bill_ranap_detail_visitekonsul_dokter';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && array_key_exists($fldname, $rsold) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'vw_bill_ranap_detail_visitekonsul_dokter';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
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
			ew_Execute("CALL update_keterangan_tindakan_detail_admisi('".$rsnew["id_admission"]."','".$rsnew["nomr"]."','".$rsnew["statusbayar"]."','".$rsnew["kelas"]."','".$rsnew["kode_tindakan"]."')");
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

		$this->tarif->ReadOnly = TRUE;
		$this->bhp->ReadOnly = TRUE;
		$this->nama_tindakan->ReadOnly = TRUE;
		$this->kelompok_tindakan->ReadOnly = TRUE;
		$this->kelompok1->ReadOnly = TRUE;
		$this->kelompok2->ReadOnly = TRUE;
		$this->user->ReadOnly = TRUE;
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
