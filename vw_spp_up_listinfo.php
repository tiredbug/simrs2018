<?php

// Global variable for table object
$vw_spp_up_list = NULL;

//
// Table class for vw_spp_up_list
//
class cvw_spp_up_list extends cTable {
	var $id;
	var $id_jenis_spp;
	var $detail_jenis_spp;
	var $status_spp;
	var $no_spp;
	var $tgl_spp;
	var $kode_program;
	var $kode_kegiatan;
	var $kode_rekening;
	var $kode_sub_kegiatan;
	var $jumlah_up;
	var $id_spd;
	var $jumlah_spd;
	var $nomer_dasar_spd;
	var $tanggal_spd;
	var $keterangan;
	var $nama_bendahara;
	var $nip_bendahara;
	var $tahun_anggaran;
	var $akun1;
	var $akun2;
	var $akun3;
	var $akun4;
	var $akun5;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_spp_up_list';
		$this->TableName = 'vw_spp_up_list';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_spp_up_list`";
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
		$this->id = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// id_jenis_spp
		$this->id_jenis_spp = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_id_jenis_spp', 'id_jenis_spp', '`id_jenis_spp`', '`id_jenis_spp`', 3, -1, FALSE, '`id_jenis_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_jenis_spp->Sortable = TRUE; // Allow sort
		$this->id_jenis_spp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_jenis_spp'] = &$this->id_jenis_spp;

		// detail_jenis_spp
		$this->detail_jenis_spp = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_detail_jenis_spp', 'detail_jenis_spp', '`detail_jenis_spp`', '`detail_jenis_spp`', 3, -1, FALSE, '`detail_jenis_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->detail_jenis_spp->Sortable = TRUE; // Allow sort
		$this->detail_jenis_spp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['detail_jenis_spp'] = &$this->detail_jenis_spp;

		// status_spp
		$this->status_spp = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_status_spp', 'status_spp', '`status_spp`', '`status_spp`', 3, -1, FALSE, '`status_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->status_spp->Sortable = TRUE; // Allow sort
		$this->status_spp->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->status_spp->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->status_spp->OptionCount = 2;
		$this->status_spp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_spp'] = &$this->status_spp;

		// no_spp
		$this->no_spp = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_no_spp', 'no_spp', '`no_spp`', '`no_spp`', 200, -1, FALSE, '`no_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spp->Sortable = TRUE; // Allow sort
		$this->fields['no_spp'] = &$this->no_spp;

		// tgl_spp
		$this->tgl_spp = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_tgl_spp', 'tgl_spp', '`tgl_spp`', ew_CastDateFieldForLike('`tgl_spp`', 7, "DB"), 135, 7, FALSE, '`tgl_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_spp->Sortable = TRUE; // Allow sort
		$this->tgl_spp->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_spp'] = &$this->tgl_spp;

		// kode_program
		$this->kode_program = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_kode_program', 'kode_program', '`kode_program`', '`kode_program`', 200, -1, FALSE, '`kode_program`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kode_program->Sortable = TRUE; // Allow sort
		$this->kode_program->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kode_program->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kode_program'] = &$this->kode_program;

		// kode_kegiatan
		$this->kode_kegiatan = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_kode_kegiatan', 'kode_kegiatan', '`kode_kegiatan`', '`kode_kegiatan`', 200, -1, FALSE, '`kode_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kode_kegiatan->Sortable = TRUE; // Allow sort
		$this->kode_kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kode_kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kode_kegiatan'] = &$this->kode_kegiatan;

		// kode_rekening
		$this->kode_rekening = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_kode_rekening', 'kode_rekening', '`kode_rekening`', '`kode_rekening`', 200, -1, FALSE, '`kode_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kode_rekening->Sortable = TRUE; // Allow sort
		$this->kode_rekening->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kode_rekening->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kode_rekening'] = &$this->kode_rekening;

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_kode_sub_kegiatan', 'kode_sub_kegiatan', '`kode_sub_kegiatan`', '`kode_sub_kegiatan`', 200, -1, FALSE, '`kode_sub_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kode_sub_kegiatan->Sortable = FALSE; // Allow sort
		$this->kode_sub_kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kode_sub_kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kode_sub_kegiatan'] = &$this->kode_sub_kegiatan;

		// jumlah_up
		$this->jumlah_up = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_jumlah_up', 'jumlah_up', '`jumlah_up`', '`jumlah_up`', 5, -1, FALSE, '`jumlah_up`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_up->Sortable = TRUE; // Allow sort
		$this->jumlah_up->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_up'] = &$this->jumlah_up;

		// id_spd
		$this->id_spd = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_id_spd', 'id_spd', '`id_spd`', '`id_spd`', 3, -1, FALSE, '`id_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_spd->Sortable = TRUE; // Allow sort
		$this->id_spd->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_spd'] = &$this->id_spd;

		// jumlah_spd
		$this->jumlah_spd = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_jumlah_spd', 'jumlah_spd', '`jumlah_spd`', '`jumlah_spd`', 5, -1, FALSE, '`jumlah_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_spd->Sortable = TRUE; // Allow sort
		$this->jumlah_spd->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_spd'] = &$this->jumlah_spd;

		// nomer_dasar_spd
		$this->nomer_dasar_spd = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_nomer_dasar_spd', 'nomer_dasar_spd', '`nomer_dasar_spd`', '`nomer_dasar_spd`', 200, -1, FALSE, '`nomer_dasar_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomer_dasar_spd->Sortable = TRUE; // Allow sort
		$this->fields['nomer_dasar_spd'] = &$this->nomer_dasar_spd;

		// tanggal_spd
		$this->tanggal_spd = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_tanggal_spd', 'tanggal_spd', '`tanggal_spd`', ew_CastDateFieldForLike('`tanggal_spd`', 7, "DB"), 135, 7, FALSE, '`tanggal_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal_spd->Sortable = TRUE; // Allow sort
		$this->tanggal_spd->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tanggal_spd'] = &$this->tanggal_spd;

		// keterangan
		$this->keterangan = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// nama_bendahara
		$this->nama_bendahara = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_nama_bendahara', 'nama_bendahara', '`nama_bendahara`', '`nama_bendahara`', 200, -1, FALSE, '`nama_bendahara`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nama_bendahara->Sortable = TRUE; // Allow sort
		$this->nama_bendahara->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nama_bendahara->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nama_bendahara'] = &$this->nama_bendahara;

		// nip_bendahara
		$this->nip_bendahara = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_nip_bendahara', 'nip_bendahara', '`nip_bendahara`', '`nip_bendahara`', 200, -1, FALSE, '`nip_bendahara`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_bendahara->Sortable = TRUE; // Allow sort
		$this->fields['nip_bendahara'] = &$this->nip_bendahara;

		// tahun_anggaran
		$this->tahun_anggaran = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_tahun_anggaran', 'tahun_anggaran', '`tahun_anggaran`', '`tahun_anggaran`', 3, -1, FALSE, '`tahun_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun_anggaran->Sortable = TRUE; // Allow sort
		$this->tahun_anggaran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tahun_anggaran'] = &$this->tahun_anggaran;

		// akun1
		$this->akun1 = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_akun1', 'akun1', '`akun1`', '`akun1`', 3, -1, FALSE, '`akun1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun1->Sortable = FALSE; // Allow sort
		$this->akun1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['akun1'] = &$this->akun1;

		// akun2
		$this->akun2 = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_akun2', 'akun2', '`akun2`', '`akun2`', 200, -1, FALSE, '`akun2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun2->Sortable = FALSE; // Allow sort
		$this->fields['akun2'] = &$this->akun2;

		// akun3
		$this->akun3 = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_akun3', 'akun3', '`akun3`', '`akun3`', 200, -1, FALSE, '`akun3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun3->Sortable = FALSE; // Allow sort
		$this->fields['akun3'] = &$this->akun3;

		// akun4
		$this->akun4 = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_akun4', 'akun4', '`akun4`', '`akun4`', 200, -1, FALSE, '`akun4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun4->Sortable = FALSE; // Allow sort
		$this->fields['akun4'] = &$this->akun4;

		// akun5
		$this->akun5 = new cField('vw_spp_up_list', 'vw_spp_up_list', 'x_akun5', 'akun5', '`akun5`', '`akun5`', 200, -1, FALSE, '`akun5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun5->Sortable = FALSE; // Allow sort
		$this->fields['akun5'] = &$this->akun5;
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
		if ($this->getCurrentDetailTable() == "t_spp_detail") {
			$sDetailUrl = $GLOBALS["t_spp_detail"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
			$sDetailUrl .= "&fk_id_jenis_spp=" . urlencode($this->id_jenis_spp->CurrentValue);
			$sDetailUrl .= "&fk_detail_jenis_spp=" . urlencode($this->detail_jenis_spp->CurrentValue);
			$sDetailUrl .= "&fk_no_spp=" . urlencode($this->no_spp->CurrentValue);
			$sDetailUrl .= "&fk_kode_program=" . urlencode($this->kode_program->CurrentValue);
			$sDetailUrl .= "&fk_kode_kegiatan=" . urlencode($this->kode_kegiatan->CurrentValue);
			$sDetailUrl .= "&fk_tahun_anggaran=" . urlencode($this->tahun_anggaran->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "vw_spp_up_listlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_spp_up_list`";
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
		$this->TableFilter = "`detail_jenis_spp`=9";
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

		// Cascade Update detail table 't_spp_detail'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['id']) && $rsold['id'] <> $rs['id'])) { // Update detail field 'id_spp'
			$bCascadeUpdate = TRUE;
			$rscascade['id_spp'] = $rs['id']; 
		}
		if (!is_null($rsold) && (isset($rs['id_jenis_spp']) && $rsold['id_jenis_spp'] <> $rs['id_jenis_spp'])) { // Update detail field 'id_jenis_spp'
			$bCascadeUpdate = TRUE;
			$rscascade['id_jenis_spp'] = $rs['id_jenis_spp']; 
		}
		if (!is_null($rsold) && (isset($rs['detail_jenis_spp']) && $rsold['detail_jenis_spp'] <> $rs['detail_jenis_spp'])) { // Update detail field 'detail_jenis_spp'
			$bCascadeUpdate = TRUE;
			$rscascade['detail_jenis_spp'] = $rs['detail_jenis_spp']; 
		}
		if (!is_null($rsold) && (isset($rs['no_spp']) && $rsold['no_spp'] <> $rs['no_spp'])) { // Update detail field 'no_spp'
			$bCascadeUpdate = TRUE;
			$rscascade['no_spp'] = $rs['no_spp']; 
		}
		if (!is_null($rsold) && (isset($rs['kode_program']) && $rsold['kode_program'] <> $rs['kode_program'])) { // Update detail field 'program'
			$bCascadeUpdate = TRUE;
			$rscascade['program'] = $rs['kode_program']; 
		}
		if (!is_null($rsold) && (isset($rs['kode_kegiatan']) && $rsold['kode_kegiatan'] <> $rs['kode_kegiatan'])) { // Update detail field 'kegiatan'
			$bCascadeUpdate = TRUE;
			$rscascade['kegiatan'] = $rs['kode_kegiatan']; 
		}
		if (!is_null($rsold) && (isset($rs['tahun_anggaran']) && $rsold['tahun_anggaran'] <> $rs['tahun_anggaran'])) { // Update detail field 'tahun_anggaran'
			$bCascadeUpdate = TRUE;
			$rscascade['tahun_anggaran'] = $rs['tahun_anggaran']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["t_spp_detail"])) $GLOBALS["t_spp_detail"] = new ct_spp_detail();
			$rswrk = $GLOBALS["t_spp_detail"]->LoadRs("`id_spp` = " . ew_QuotedValue($rsold['id'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`id_jenis_spp` = " . ew_QuotedValue($rsold['id_jenis_spp'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`detail_jenis_spp` = " . ew_QuotedValue($rsold['detail_jenis_spp'], EW_DATATYPE_NUMBER, 'DB') . " AND " . "`no_spp` = " . ew_QuotedValue($rsold['no_spp'], EW_DATATYPE_STRING, 'DB') . " AND " . "`program` = " . ew_QuotedValue($rsold['kode_program'], EW_DATATYPE_STRING, 'DB') . " AND " . "`kegiatan` = " . ew_QuotedValue($rsold['kode_kegiatan'], EW_DATATYPE_STRING, 'DB') . " AND " . "`tahun_anggaran` = " . ew_QuotedValue($rsold['tahun_anggaran'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$bUpdate = $GLOBALS["t_spp_detail"]->Update($rscascade, $rskey, $rswrk->fields);
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

		// Cascade delete detail table 't_spp_detail'
		if (!isset($GLOBALS["t_spp_detail"])) $GLOBALS["t_spp_detail"] = new ct_spp_detail();
		$rscascade = $GLOBALS["t_spp_detail"]->LoadRs("`id_spp` = " . ew_QuotedValue($rs['id'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`id_jenis_spp` = " . ew_QuotedValue($rs['id_jenis_spp'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`detail_jenis_spp` = " . ew_QuotedValue($rs['detail_jenis_spp'], EW_DATATYPE_NUMBER, "DB") . " AND " . "`no_spp` = " . ew_QuotedValue($rs['no_spp'], EW_DATATYPE_STRING, "DB") . " AND " . "`program` = " . ew_QuotedValue($rs['kode_program'], EW_DATATYPE_STRING, "DB") . " AND " . "`kegiatan` = " . ew_QuotedValue($rs['kode_kegiatan'], EW_DATATYPE_STRING, "DB") . " AND " . "`tahun_anggaran` = " . ew_QuotedValue($rs['tahun_anggaran'], EW_DATATYPE_NUMBER, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["t_spp_detail"]->Delete($rscascade->fields);
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
			return "vw_spp_up_listlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_spp_up_listlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_spp_up_listview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_spp_up_listview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_spp_up_listadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_spp_up_listadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_spp_up_listedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_spp_up_listedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("vw_spp_up_listadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_spp_up_listadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_spp_up_listdelete.php", $this->UrlParm());
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
		$this->id_jenis_spp->setDbValue($rs->fields('id_jenis_spp'));
		$this->detail_jenis_spp->setDbValue($rs->fields('detail_jenis_spp'));
		$this->status_spp->setDbValue($rs->fields('status_spp'));
		$this->no_spp->setDbValue($rs->fields('no_spp'));
		$this->tgl_spp->setDbValue($rs->fields('tgl_spp'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->jumlah_up->setDbValue($rs->fields('jumlah_up'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// id_jenis_spp
		// detail_jenis_spp
		// status_spp
		// no_spp
		// tgl_spp
		// kode_program
		// kode_kegiatan
		// kode_rekening
		// kode_sub_kegiatan

		$this->kode_sub_kegiatan->CellCssStyle = "white-space: nowrap;";

		// jumlah_up
		// id_spd
		// jumlah_spd
		// nomer_dasar_spd
		// tanggal_spd
		// keterangan
		// nama_bendahara
		// nip_bendahara
		// tahun_anggaran
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

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_jenis_spp
		$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
		if (strval($this->id_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_spp`";
		$sWhereWrk = "";
		$this->id_jenis_spp->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_jenis_spp->ViewValue = $this->id_jenis_spp->CurrentValue;
			}
		} else {
			$this->id_jenis_spp->ViewValue = NULL;
		}
		$this->id_jenis_spp->ViewCustomAttributes = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
		if (strval($this->detail_jenis_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->detail_jenis_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `detail_jenis_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_detail_spp`";
		$sWhereWrk = "";
		$this->detail_jenis_spp->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->detail_jenis_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->detail_jenis_spp->ViewValue = $this->detail_jenis_spp->CurrentValue;
			}
		} else {
			$this->detail_jenis_spp->ViewValue = NULL;
		}
		$this->detail_jenis_spp->ViewCustomAttributes = "";

		// status_spp
		if (strval($this->status_spp->CurrentValue) <> "") {
			$this->status_spp->ViewValue = $this->status_spp->OptionCaption($this->status_spp->CurrentValue);
		} else {
			$this->status_spp->ViewValue = NULL;
		}
		$this->status_spp->ViewCustomAttributes = "";

		// no_spp
		$this->no_spp->ViewValue = $this->no_spp->CurrentValue;
		$this->no_spp->ViewCustomAttributes = "";

		// tgl_spp
		$this->tgl_spp->ViewValue = $this->tgl_spp->CurrentValue;
		$this->tgl_spp->ViewValue = ew_FormatDateTime($this->tgl_spp->ViewValue, 7);
		$this->tgl_spp->ViewCustomAttributes = "";

		// kode_program
		if (strval($this->kode_program->CurrentValue) <> "") {
			$sFilterWrk = "`kode_program`" . ew_SearchString("=", $this->kode_program->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_program`, `nama_program` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_program`";
		$sWhereWrk = "";
		$this->kode_program->LookupFilters = array();
		$lookuptblfilter = "`id`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_program, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_program->ViewValue = $this->kode_program->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
			}
		} else {
			$this->kode_program->ViewValue = NULL;
		}
		$this->kode_program->ViewCustomAttributes = "";

		// kode_kegiatan
		if (strval($this->kode_kegiatan->CurrentValue) <> "") {
			$sFilterWrk = "`kode_kegiatan`" . ew_SearchString("=", $this->kode_kegiatan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kode_kegiatan`, `nama_kegiatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kegiatan`";
		$sWhereWrk = "";
		$this->kode_kegiatan->LookupFilters = array();
		$lookuptblfilter = "`id`=1";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_kegiatan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->CurrentValue;
			}
		} else {
			$this->kode_kegiatan->ViewValue = NULL;
		}
		$this->kode_kegiatan->ViewCustomAttributes = "";

		// kode_rekening
		if (strval($this->kode_rekening->CurrentValue) <> "") {
			$sFilterWrk = "`kd_akun`" . ew_SearchString("=", $this->kode_rekening->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kd_akun`, `kd_akun` AS `DispFld`, `nama_akun` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
		$sWhereWrk = "";
		$this->kode_rekening->LookupFilters = array();
		$lookuptblfilter = "`id`=5602";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kode_rekening, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->kode_rekening->ViewValue = $this->kode_rekening->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
			}
		} else {
			$this->kode_rekening->ViewValue = NULL;
		}
		$this->kode_rekening->ViewCustomAttributes = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

		// jumlah_up
		$this->jumlah_up->ViewValue = $this->jumlah_up->CurrentValue;
		$this->jumlah_up->ViewCustomAttributes = "";

		// id_spd
		$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
		if (strval($this->id_spd->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spd->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_spd` AS `DispFld`, `tanggal` AS `Disp2Fld`, `jenis_peraturan` AS `Disp3Fld`, `pembayaran` AS `Disp4Fld` FROM `t_spd`";
		$sWhereWrk = "";
		$this->id_spd->LookupFilters = array("dx1" => '`no_spd`', "df2" => "7", "dx2" => ew_CastDateFieldForLike('`tanggal`', 7, "DB"), "dx3" => '`jenis_peraturan`', "dx4" => '`pembayaran`');
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_spd, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = ew_FormatDateTime($rswrk->fields('Disp2Fld'), 7);
				$arwrk[3] = $rswrk->fields('Disp3Fld');
				$arwrk[4] = $rswrk->fields('Disp4Fld');
				$this->id_spd->ViewValue = $this->id_spd->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
			}
		} else {
			$this->id_spd->ViewValue = NULL;
		}
		$this->id_spd->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

		// nomer_dasar_spd
		$this->nomer_dasar_spd->ViewValue = $this->nomer_dasar_spd->CurrentValue;
		$this->nomer_dasar_spd->ViewCustomAttributes = "";

		// tanggal_spd
		$this->tanggal_spd->ViewValue = $this->tanggal_spd->CurrentValue;
		$this->tanggal_spd->ViewValue = ew_FormatDateTime($this->tanggal_spd->ViewValue, 7);
		$this->tanggal_spd->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// nama_bendahara
		if (strval($this->nama_bendahara->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_bendahara->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_bendahara->LookupFilters = array();
		$lookuptblfilter = "`id`=2";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_bendahara->ViewValue = $this->nama_bendahara->CurrentValue;
			}
		} else {
			$this->nama_bendahara->ViewValue = NULL;
		}
		$this->nama_bendahara->ViewCustomAttributes = "";

		// nip_bendahara
		$this->nip_bendahara->ViewValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->ViewCustomAttributes = "";

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
		$this->akun5->ViewValue = $this->akun5->CurrentValue;
		$this->akun5->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// id_jenis_spp
		$this->id_jenis_spp->LinkCustomAttributes = "";
		$this->id_jenis_spp->HrefValue = "";
		$this->id_jenis_spp->TooltipValue = "";

		// detail_jenis_spp
		$this->detail_jenis_spp->LinkCustomAttributes = "";
		$this->detail_jenis_spp->HrefValue = "";
		$this->detail_jenis_spp->TooltipValue = "";

		// status_spp
		$this->status_spp->LinkCustomAttributes = "";
		$this->status_spp->HrefValue = "";
		$this->status_spp->TooltipValue = "";

		// no_spp
		$this->no_spp->LinkCustomAttributes = "";
		$this->no_spp->HrefValue = "";
		$this->no_spp->TooltipValue = "";

		// tgl_spp
		$this->tgl_spp->LinkCustomAttributes = "";
		$this->tgl_spp->HrefValue = "";
		$this->tgl_spp->TooltipValue = "";

		// kode_program
		$this->kode_program->LinkCustomAttributes = "";
		$this->kode_program->HrefValue = "";
		$this->kode_program->TooltipValue = "";

		// kode_kegiatan
		$this->kode_kegiatan->LinkCustomAttributes = "";
		$this->kode_kegiatan->HrefValue = "";
		$this->kode_kegiatan->TooltipValue = "";

		// kode_rekening
		$this->kode_rekening->LinkCustomAttributes = "";
		$this->kode_rekening->HrefValue = "";
		$this->kode_rekening->TooltipValue = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->LinkCustomAttributes = "";
		$this->kode_sub_kegiatan->HrefValue = "";
		$this->kode_sub_kegiatan->TooltipValue = "";

		// jumlah_up
		$this->jumlah_up->LinkCustomAttributes = "";
		$this->jumlah_up->HrefValue = "";
		$this->jumlah_up->TooltipValue = "";

		// id_spd
		$this->id_spd->LinkCustomAttributes = "";
		$this->id_spd->HrefValue = "";
		$this->id_spd->TooltipValue = "";

		// jumlah_spd
		$this->jumlah_spd->LinkCustomAttributes = "";
		$this->jumlah_spd->HrefValue = "";
		$this->jumlah_spd->TooltipValue = "";

		// nomer_dasar_spd
		$this->nomer_dasar_spd->LinkCustomAttributes = "";
		$this->nomer_dasar_spd->HrefValue = "";
		$this->nomer_dasar_spd->TooltipValue = "";

		// tanggal_spd
		$this->tanggal_spd->LinkCustomAttributes = "";
		$this->tanggal_spd->HrefValue = "";
		$this->tanggal_spd->TooltipValue = "";

		// keterangan
		$this->keterangan->LinkCustomAttributes = "";
		$this->keterangan->HrefValue = "";
		$this->keterangan->TooltipValue = "";

		// nama_bendahara
		$this->nama_bendahara->LinkCustomAttributes = "";
		$this->nama_bendahara->HrefValue = "";
		$this->nama_bendahara->TooltipValue = "";

		// nip_bendahara
		$this->nip_bendahara->LinkCustomAttributes = "";
		$this->nip_bendahara->HrefValue = "";
		$this->nip_bendahara->TooltipValue = "";

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

		// id_jenis_spp
		$this->id_jenis_spp->EditAttrs["class"] = "form-control";
		$this->id_jenis_spp->EditCustomAttributes = "";
		$this->id_jenis_spp->EditValue = $this->id_jenis_spp->CurrentValue;
		$this->id_jenis_spp->PlaceHolder = ew_RemoveHtml($this->id_jenis_spp->FldCaption());

		// detail_jenis_spp
		$this->detail_jenis_spp->EditAttrs["class"] = "form-control";
		$this->detail_jenis_spp->EditCustomAttributes = "";
		$this->detail_jenis_spp->EditValue = $this->detail_jenis_spp->CurrentValue;
		$this->detail_jenis_spp->PlaceHolder = ew_RemoveHtml($this->detail_jenis_spp->FldCaption());

		// status_spp
		$this->status_spp->EditAttrs["class"] = "form-control";
		$this->status_spp->EditCustomAttributes = "";
		$this->status_spp->EditValue = $this->status_spp->Options(TRUE);

		// no_spp
		$this->no_spp->EditAttrs["class"] = "form-control";
		$this->no_spp->EditCustomAttributes = "";
		$this->no_spp->EditValue = $this->no_spp->CurrentValue;
		$this->no_spp->PlaceHolder = ew_RemoveHtml($this->no_spp->FldCaption());

		// tgl_spp
		$this->tgl_spp->EditAttrs["class"] = "form-control";
		$this->tgl_spp->EditCustomAttributes = "";
		$this->tgl_spp->EditValue = ew_FormatDateTime($this->tgl_spp->CurrentValue, 7);
		$this->tgl_spp->PlaceHolder = ew_RemoveHtml($this->tgl_spp->FldCaption());

		// kode_program
		$this->kode_program->EditAttrs["class"] = "form-control";
		$this->kode_program->EditCustomAttributes = "";

		// kode_kegiatan
		$this->kode_kegiatan->EditAttrs["class"] = "form-control";
		$this->kode_kegiatan->EditCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->EditAttrs["class"] = "form-control";
		$this->kode_rekening->EditCustomAttributes = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->EditAttrs["class"] = "form-control";
		$this->kode_sub_kegiatan->EditCustomAttributes = "";

		// jumlah_up
		$this->jumlah_up->EditAttrs["class"] = "form-control";
		$this->jumlah_up->EditCustomAttributes = "";
		$this->jumlah_up->EditValue = $this->jumlah_up->CurrentValue;
		$this->jumlah_up->PlaceHolder = ew_RemoveHtml($this->jumlah_up->FldCaption());
		if (strval($this->jumlah_up->EditValue) <> "" && is_numeric($this->jumlah_up->EditValue)) $this->jumlah_up->EditValue = ew_FormatNumber($this->jumlah_up->EditValue, -2, -1, -2, 0);

		// id_spd
		$this->id_spd->EditAttrs["class"] = "form-control";
		$this->id_spd->EditCustomAttributes = "";
		$this->id_spd->EditValue = $this->id_spd->CurrentValue;
		$this->id_spd->PlaceHolder = ew_RemoveHtml($this->id_spd->FldCaption());

		// jumlah_spd
		$this->jumlah_spd->EditAttrs["class"] = "form-control";
		$this->jumlah_spd->EditCustomAttributes = "";
		$this->jumlah_spd->EditValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->PlaceHolder = ew_RemoveHtml($this->jumlah_spd->FldCaption());
		if (strval($this->jumlah_spd->EditValue) <> "" && is_numeric($this->jumlah_spd->EditValue)) $this->jumlah_spd->EditValue = ew_FormatNumber($this->jumlah_spd->EditValue, -2, -1, -2, 0);

		// nomer_dasar_spd
		$this->nomer_dasar_spd->EditAttrs["class"] = "form-control";
		$this->nomer_dasar_spd->EditCustomAttributes = "";
		$this->nomer_dasar_spd->EditValue = $this->nomer_dasar_spd->CurrentValue;
		$this->nomer_dasar_spd->PlaceHolder = ew_RemoveHtml($this->nomer_dasar_spd->FldCaption());

		// tanggal_spd
		$this->tanggal_spd->EditAttrs["class"] = "form-control";
		$this->tanggal_spd->EditCustomAttributes = "";
		$this->tanggal_spd->EditValue = ew_FormatDateTime($this->tanggal_spd->CurrentValue, 7);
		$this->tanggal_spd->PlaceHolder = ew_RemoveHtml($this->tanggal_spd->FldCaption());

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// nama_bendahara
		$this->nama_bendahara->EditAttrs["class"] = "form-control";
		$this->nama_bendahara->EditCustomAttributes = "";

		// nip_bendahara
		$this->nip_bendahara->EditAttrs["class"] = "form-control";
		$this->nip_bendahara->EditCustomAttributes = "";
		$this->nip_bendahara->EditValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->PlaceHolder = ew_RemoveHtml($this->nip_bendahara->FldCaption());

		// tahun_anggaran
		$this->tahun_anggaran->EditAttrs["class"] = "form-control";
		$this->tahun_anggaran->EditCustomAttributes = "";
		$this->tahun_anggaran->EditValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

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
		$this->akun5->EditValue = $this->akun5->CurrentValue;
		$this->akun5->PlaceHolder = ew_RemoveHtml($this->akun5->FldCaption());

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
					if ($this->id_jenis_spp->Exportable) $Doc->ExportCaption($this->id_jenis_spp);
					if ($this->detail_jenis_spp->Exportable) $Doc->ExportCaption($this->detail_jenis_spp);
					if ($this->status_spp->Exportable) $Doc->ExportCaption($this->status_spp);
					if ($this->no_spp->Exportable) $Doc->ExportCaption($this->no_spp);
					if ($this->tgl_spp->Exportable) $Doc->ExportCaption($this->tgl_spp);
					if ($this->kode_program->Exportable) $Doc->ExportCaption($this->kode_program);
					if ($this->kode_kegiatan->Exportable) $Doc->ExportCaption($this->kode_kegiatan);
					if ($this->kode_rekening->Exportable) $Doc->ExportCaption($this->kode_rekening);
					if ($this->jumlah_up->Exportable) $Doc->ExportCaption($this->jumlah_up);
					if ($this->id_spd->Exportable) $Doc->ExportCaption($this->id_spd);
					if ($this->jumlah_spd->Exportable) $Doc->ExportCaption($this->jumlah_spd);
					if ($this->nomer_dasar_spd->Exportable) $Doc->ExportCaption($this->nomer_dasar_spd);
					if ($this->tanggal_spd->Exportable) $Doc->ExportCaption($this->tanggal_spd);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->nama_bendahara->Exportable) $Doc->ExportCaption($this->nama_bendahara);
					if ($this->nip_bendahara->Exportable) $Doc->ExportCaption($this->nip_bendahara);
					if ($this->tahun_anggaran->Exportable) $Doc->ExportCaption($this->tahun_anggaran);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->id_jenis_spp->Exportable) $Doc->ExportCaption($this->id_jenis_spp);
					if ($this->detail_jenis_spp->Exportable) $Doc->ExportCaption($this->detail_jenis_spp);
					if ($this->status_spp->Exportable) $Doc->ExportCaption($this->status_spp);
					if ($this->no_spp->Exportable) $Doc->ExportCaption($this->no_spp);
					if ($this->tgl_spp->Exportable) $Doc->ExportCaption($this->tgl_spp);
					if ($this->kode_program->Exportable) $Doc->ExportCaption($this->kode_program);
					if ($this->kode_kegiatan->Exportable) $Doc->ExportCaption($this->kode_kegiatan);
					if ($this->kode_rekening->Exportable) $Doc->ExportCaption($this->kode_rekening);
					if ($this->jumlah_up->Exportable) $Doc->ExportCaption($this->jumlah_up);
					if ($this->id_spd->Exportable) $Doc->ExportCaption($this->id_spd);
					if ($this->jumlah_spd->Exportable) $Doc->ExportCaption($this->jumlah_spd);
					if ($this->nomer_dasar_spd->Exportable) $Doc->ExportCaption($this->nomer_dasar_spd);
					if ($this->tanggal_spd->Exportable) $Doc->ExportCaption($this->tanggal_spd);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->nama_bendahara->Exportable) $Doc->ExportCaption($this->nama_bendahara);
					if ($this->nip_bendahara->Exportable) $Doc->ExportCaption($this->nip_bendahara);
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
						if ($this->id_jenis_spp->Exportable) $Doc->ExportField($this->id_jenis_spp);
						if ($this->detail_jenis_spp->Exportable) $Doc->ExportField($this->detail_jenis_spp);
						if ($this->status_spp->Exportable) $Doc->ExportField($this->status_spp);
						if ($this->no_spp->Exportable) $Doc->ExportField($this->no_spp);
						if ($this->tgl_spp->Exportable) $Doc->ExportField($this->tgl_spp);
						if ($this->kode_program->Exportable) $Doc->ExportField($this->kode_program);
						if ($this->kode_kegiatan->Exportable) $Doc->ExportField($this->kode_kegiatan);
						if ($this->kode_rekening->Exportable) $Doc->ExportField($this->kode_rekening);
						if ($this->jumlah_up->Exportable) $Doc->ExportField($this->jumlah_up);
						if ($this->id_spd->Exportable) $Doc->ExportField($this->id_spd);
						if ($this->jumlah_spd->Exportable) $Doc->ExportField($this->jumlah_spd);
						if ($this->nomer_dasar_spd->Exportable) $Doc->ExportField($this->nomer_dasar_spd);
						if ($this->tanggal_spd->Exportable) $Doc->ExportField($this->tanggal_spd);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->nama_bendahara->Exportable) $Doc->ExportField($this->nama_bendahara);
						if ($this->nip_bendahara->Exportable) $Doc->ExportField($this->nip_bendahara);
						if ($this->tahun_anggaran->Exportable) $Doc->ExportField($this->tahun_anggaran);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->id_jenis_spp->Exportable) $Doc->ExportField($this->id_jenis_spp);
						if ($this->detail_jenis_spp->Exportable) $Doc->ExportField($this->detail_jenis_spp);
						if ($this->status_spp->Exportable) $Doc->ExportField($this->status_spp);
						if ($this->no_spp->Exportable) $Doc->ExportField($this->no_spp);
						if ($this->tgl_spp->Exportable) $Doc->ExportField($this->tgl_spp);
						if ($this->kode_program->Exportable) $Doc->ExportField($this->kode_program);
						if ($this->kode_kegiatan->Exportable) $Doc->ExportField($this->kode_kegiatan);
						if ($this->kode_rekening->Exportable) $Doc->ExportField($this->kode_rekening);
						if ($this->jumlah_up->Exportable) $Doc->ExportField($this->jumlah_up);
						if ($this->id_spd->Exportable) $Doc->ExportField($this->id_spd);
						if ($this->jumlah_spd->Exportable) $Doc->ExportField($this->jumlah_spd);
						if ($this->nomer_dasar_spd->Exportable) $Doc->ExportField($this->nomer_dasar_spd);
						if ($this->tanggal_spd->Exportable) $Doc->ExportField($this->tanggal_spd);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->nama_bendahara->Exportable) $Doc->ExportField($this->nama_bendahara);
						if ($this->nip_bendahara->Exportable) $Doc->ExportField($this->nip_bendahara);
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
		if (preg_match('/^x(\d)*_id_spd$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `jumlah_spd` AS FIELD0, `no_spd` AS FIELD1, `tanggal` AS FIELD2 FROM `t_spd`";
			$sWhereWrk = "(`id` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->id_spd->LookupFilters = array("dx1" => '`no_spd`', "df2" => "7", "dx2" => ew_CastDateFieldForLike('`tanggal`', 7, "DB"), "dx3" => '`jenis_peraturan`', "dx4" => '`pembayaran`');
			$this->Lookup_Selecting($this->id_spd, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->jumlah_spd->setDbValue($rs->fields[0]);
					$this->nomer_dasar_spd->setDbValue($rs->fields[1]);
					$this->tanggal_spd->setDbValue($rs->fields[2]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->jumlah_spd->AutoFillOriginalValue) ? $this->jumlah_spd->CurrentValue : $this->jumlah_spd->EditValue;
					$ar[] = ($this->nomer_dasar_spd->AutoFillOriginalValue) ? $this->nomer_dasar_spd->CurrentValue : $this->nomer_dasar_spd->EditValue;
					$ar[] = ($this->tanggal_spd->AutoFillOriginalValue) ? $this->tanggal_spd->CurrentValue : $this->tanggal_spd->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_nama_bendahara$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `nip` AS FIELD0 FROM `m_pejabat_keuangan`";
			$sWhereWrk = "(`nama` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->nama_bendahara->LookupFilters = array();
			$lookuptblfilter = "`id`=2";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->nama_bendahara, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->nip_bendahara->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->nip_bendahara->AutoFillOriginalValue) ? $this->nip_bendahara->CurrentValue : $this->nip_bendahara->EditValue;
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

		$rsnew["no_spp"] = GetNextNomerSPP_UP();

	//	$rsnew["link_cetak_spp"] = "cetak_spp_up.php?kdspp=".$rsnew["id"];
		$rsnew["akun1"] =  ew_ExecuteScalar("SELECT akun1 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kode_rekening"]."' LIMIT 1");
		$rsnew["akun2"] = ew_ExecuteScalar("SELECT akun2 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kode_rekening"]."' LIMIT 1");
		$rsnew["akun3"] = ew_ExecuteScalar("SELECT akun3 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kode_rekening"]."' LIMIT 1");
		$rsnew["akun4"] = ew_ExecuteScalar("SELECT akun4 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kode_rekening"]."' LIMIT 1");
		$rsnew["akun5"] = ew_ExecuteScalar("SELECT akun5 FROM keu_akun5 WHERE kd_akun = '".$rsnew["kode_rekening"]."' LIMIT 1");
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

		$this->id_jenis_spp->ReadOnly = TRUE;
		$this->detail_jenis_spp->ReadOnly = TRUE;
		$this->nip_bendahara->ReadOnly = TRUE;
		$this->id_spd->ReadOnly = TRUE;
		$this->nomer_dasar_spd->ReadOnly = TRUE;
		$this->tanggal_spd->ReadOnly = TRUE;
		$this->jumlah_spd->ReadOnly = TRUE;
		$this->tahun_anggaran->ReadOnly = TRUE;

		//$this->nip_bendahara->ReadOnly = TRUE;
		if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
			$this->no_spp->CurrentValue = GetNextNomerSPP_UP(); // trik
			$this->no_spp->EditValue = $this->no_spp->CurrentValue; // tampilkan

			//$this->no_spp->ReadOnly = TRUE; // supaya tidak bisa diubah
		}

		// Kondisi saat form Tambah sedang dalam mode konfirmasi
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
			$this->no_spp->ViewValue = $this->no_spp->CurrentValue; // ambil dari mode sebelumnya
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
