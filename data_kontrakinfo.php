<?php

// Global variable for table object
$data_kontrak = NULL;

//
// Table class for data_kontrak
//
class cdata_kontrak extends cTable {
	var $id;
	var $program;
	var $kegiatan;
	var $sub_kegiatan;
	var $no_kontrak;
	var $tgl_kontrak;
	var $nama_perusahaan;
	var $bentuk_perusahaan;
	var $alamat_perusahaan;
	var $kepala_perusahaan;
	var $npwp;
	var $nama_bank;
	var $nama_rekening;
	var $nomer_rekening;
	var $lanjutkan;
	var $waktu_kontrak;
	var $tgl_mulai;
	var $tgl_selesai;
	var $paket_pekerjaan;
	var $nama_ppkom;
	var $nip_ppkom;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'data_kontrak';
		$this->TableName = 'data_kontrak';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`data_kontrak`";
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
		$this->id = new cField('data_kontrak', 'data_kontrak', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// program
		$this->program = new cField('data_kontrak', 'data_kontrak', 'x_program', 'program', '`program`', '`program`', 200, -1, FALSE, '`program`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->program->Sortable = TRUE; // Allow sort
		$this->program->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->program->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['program'] = &$this->program;

		// kegiatan
		$this->kegiatan = new cField('data_kontrak', 'data_kontrak', 'x_kegiatan', 'kegiatan', '`kegiatan`', '`kegiatan`', 200, -1, FALSE, '`kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kegiatan->Sortable = TRUE; // Allow sort
		$this->kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kegiatan'] = &$this->kegiatan;

		// sub_kegiatan
		$this->sub_kegiatan = new cField('data_kontrak', 'data_kontrak', 'x_sub_kegiatan', 'sub_kegiatan', '`sub_kegiatan`', '`sub_kegiatan`', 200, -1, FALSE, '`sub_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->sub_kegiatan->Sortable = TRUE; // Allow sort
		$this->sub_kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->sub_kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['sub_kegiatan'] = &$this->sub_kegiatan;

		// no_kontrak
		$this->no_kontrak = new cField('data_kontrak', 'data_kontrak', 'x_no_kontrak', 'no_kontrak', '`no_kontrak`', '`no_kontrak`', 200, -1, FALSE, '`no_kontrak`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_kontrak->Sortable = TRUE; // Allow sort
		$this->fields['no_kontrak'] = &$this->no_kontrak;

		// tgl_kontrak
		$this->tgl_kontrak = new cField('data_kontrak', 'data_kontrak', 'x_tgl_kontrak', 'tgl_kontrak', '`tgl_kontrak`', ew_CastDateFieldForLike('`tgl_kontrak`', 0, "DB"), 135, 0, FALSE, '`tgl_kontrak`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_kontrak->Sortable = TRUE; // Allow sort
		$this->tgl_kontrak->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_kontrak'] = &$this->tgl_kontrak;

		// nama_perusahaan
		$this->nama_perusahaan = new cField('data_kontrak', 'data_kontrak', 'x_nama_perusahaan', 'nama_perusahaan', '`nama_perusahaan`', '`nama_perusahaan`', 200, -1, FALSE, '`nama_perusahaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_perusahaan->Sortable = TRUE; // Allow sort
		$this->fields['nama_perusahaan'] = &$this->nama_perusahaan;

		// bentuk_perusahaan
		$this->bentuk_perusahaan = new cField('data_kontrak', 'data_kontrak', 'x_bentuk_perusahaan', 'bentuk_perusahaan', '`bentuk_perusahaan`', '`bentuk_perusahaan`', 200, -1, FALSE, '`bentuk_perusahaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->bentuk_perusahaan->Sortable = TRUE; // Allow sort
		$this->bentuk_perusahaan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->bentuk_perusahaan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['bentuk_perusahaan'] = &$this->bentuk_perusahaan;

		// alamat_perusahaan
		$this->alamat_perusahaan = new cField('data_kontrak', 'data_kontrak', 'x_alamat_perusahaan', 'alamat_perusahaan', '`alamat_perusahaan`', '`alamat_perusahaan`', 201, -1, FALSE, '`alamat_perusahaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alamat_perusahaan->Sortable = TRUE; // Allow sort
		$this->fields['alamat_perusahaan'] = &$this->alamat_perusahaan;

		// kepala_perusahaan
		$this->kepala_perusahaan = new cField('data_kontrak', 'data_kontrak', 'x_kepala_perusahaan', 'kepala_perusahaan', '`kepala_perusahaan`', '`kepala_perusahaan`', 200, -1, FALSE, '`kepala_perusahaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kepala_perusahaan->Sortable = TRUE; // Allow sort
		$this->fields['kepala_perusahaan'] = &$this->kepala_perusahaan;

		// npwp
		$this->npwp = new cField('data_kontrak', 'data_kontrak', 'x_npwp', 'npwp', '`npwp`', '`npwp`', 200, -1, FALSE, '`npwp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->npwp->Sortable = TRUE; // Allow sort
		$this->fields['npwp'] = &$this->npwp;

		// nama_bank
		$this->nama_bank = new cField('data_kontrak', 'data_kontrak', 'x_nama_bank', 'nama_bank', '`nama_bank`', '`nama_bank`', 200, -1, FALSE, '`nama_bank`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_bank->Sortable = TRUE; // Allow sort
		$this->fields['nama_bank'] = &$this->nama_bank;

		// nama_rekening
		$this->nama_rekening = new cField('data_kontrak', 'data_kontrak', 'x_nama_rekening', 'nama_rekening', '`nama_rekening`', '`nama_rekening`', 200, -1, FALSE, '`nama_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_rekening->Sortable = TRUE; // Allow sort
		$this->fields['nama_rekening'] = &$this->nama_rekening;

		// nomer_rekening
		$this->nomer_rekening = new cField('data_kontrak', 'data_kontrak', 'x_nomer_rekening', 'nomer_rekening', '`nomer_rekening`', '`nomer_rekening`', 200, -1, FALSE, '`nomer_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomer_rekening->Sortable = TRUE; // Allow sort
		$this->fields['nomer_rekening'] = &$this->nomer_rekening;

		// lanjutkan
		$this->lanjutkan = new cField('data_kontrak', 'data_kontrak', 'x_lanjutkan', 'lanjutkan', '`lanjutkan`', '`lanjutkan`', 3, -1, FALSE, '`lanjutkan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->lanjutkan->Sortable = TRUE; // Allow sort
		$this->lanjutkan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->lanjutkan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->lanjutkan->OptionCount = 2;
		$this->lanjutkan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lanjutkan'] = &$this->lanjutkan;

		// waktu_kontrak
		$this->waktu_kontrak = new cField('data_kontrak', 'data_kontrak', 'x_waktu_kontrak', 'waktu_kontrak', '`waktu_kontrak`', '`waktu_kontrak`', 200, -1, FALSE, '`waktu_kontrak`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->waktu_kontrak->Sortable = TRUE; // Allow sort
		$this->fields['waktu_kontrak'] = &$this->waktu_kontrak;

		// tgl_mulai
		$this->tgl_mulai = new cField('data_kontrak', 'data_kontrak', 'x_tgl_mulai', 'tgl_mulai', '`tgl_mulai`', ew_CastDateFieldForLike('`tgl_mulai`', 7, "DB"), 135, 7, FALSE, '`tgl_mulai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_mulai->Sortable = TRUE; // Allow sort
		$this->tgl_mulai->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_mulai'] = &$this->tgl_mulai;

		// tgl_selesai
		$this->tgl_selesai = new cField('data_kontrak', 'data_kontrak', 'x_tgl_selesai', 'tgl_selesai', '`tgl_selesai`', ew_CastDateFieldForLike('`tgl_selesai`', 7, "DB"), 135, 7, FALSE, '`tgl_selesai`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_selesai->Sortable = TRUE; // Allow sort
		$this->tgl_selesai->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_selesai'] = &$this->tgl_selesai;

		// paket_pekerjaan
		$this->paket_pekerjaan = new cField('data_kontrak', 'data_kontrak', 'x_paket_pekerjaan', 'paket_pekerjaan', '`paket_pekerjaan`', '`paket_pekerjaan`', 201, -1, FALSE, '`paket_pekerjaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->paket_pekerjaan->Sortable = TRUE; // Allow sort
		$this->fields['paket_pekerjaan'] = &$this->paket_pekerjaan;

		// nama_ppkom
		$this->nama_ppkom = new cField('data_kontrak', 'data_kontrak', 'x_nama_ppkom', 'nama_ppkom', '`nama_ppkom`', '`nama_ppkom`', 200, -1, FALSE, '`nama_ppkom`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nama_ppkom->Sortable = TRUE; // Allow sort
		$this->nama_ppkom->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nama_ppkom->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nama_ppkom'] = &$this->nama_ppkom;

		// nip_ppkom
		$this->nip_ppkom = new cField('data_kontrak', 'data_kontrak', 'x_nip_ppkom', 'nip_ppkom', '`nip_ppkom`', '`nip_ppkom`', 200, -1, FALSE, '`nip_ppkom`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_ppkom->Sortable = TRUE; // Allow sort
		$this->fields['nip_ppkom'] = &$this->nip_ppkom;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`data_kontrak`";
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
			return "data_kontraklist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "data_kontraklist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("data_kontrakview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("data_kontrakview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "data_kontrakadd.php?" . $this->UrlParm($parm);
		else
			$url = "data_kontrakadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("data_kontrakedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("data_kontrakadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("data_kontrakdelete.php", $this->UrlParm());
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
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->no_kontrak->setDbValue($rs->fields('no_kontrak'));
		$this->tgl_kontrak->setDbValue($rs->fields('tgl_kontrak'));
		$this->nama_perusahaan->setDbValue($rs->fields('nama_perusahaan'));
		$this->bentuk_perusahaan->setDbValue($rs->fields('bentuk_perusahaan'));
		$this->alamat_perusahaan->setDbValue($rs->fields('alamat_perusahaan'));
		$this->kepala_perusahaan->setDbValue($rs->fields('kepala_perusahaan'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nama_rekening->setDbValue($rs->fields('nama_rekening'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->lanjutkan->setDbValue($rs->fields('lanjutkan'));
		$this->waktu_kontrak->setDbValue($rs->fields('waktu_kontrak'));
		$this->tgl_mulai->setDbValue($rs->fields('tgl_mulai'));
		$this->tgl_selesai->setDbValue($rs->fields('tgl_selesai'));
		$this->paket_pekerjaan->setDbValue($rs->fields('paket_pekerjaan'));
		$this->nama_ppkom->setDbValue($rs->fields('nama_ppkom'));
		$this->nip_ppkom->setDbValue($rs->fields('nip_ppkom'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// program
		// kegiatan
		// sub_kegiatan
		// no_kontrak
		// tgl_kontrak
		// nama_perusahaan
		// bentuk_perusahaan
		// alamat_perusahaan
		// kepala_perusahaan
		// npwp
		// nama_bank
		// nama_rekening
		// nomer_rekening
		// lanjutkan
		// waktu_kontrak
		// tgl_mulai
		// tgl_selesai
		// paket_pekerjaan
		// nama_ppkom
		// nip_ppkom
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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

		// no_kontrak
		$this->no_kontrak->ViewValue = $this->no_kontrak->CurrentValue;
		$this->no_kontrak->ViewCustomAttributes = "";

		// tgl_kontrak
		$this->tgl_kontrak->ViewValue = $this->tgl_kontrak->CurrentValue;
		$this->tgl_kontrak->ViewValue = ew_FormatDateTime($this->tgl_kontrak->ViewValue, 0);
		$this->tgl_kontrak->ViewCustomAttributes = "";

		// nama_perusahaan
		$this->nama_perusahaan->ViewValue = $this->nama_perusahaan->CurrentValue;
		$this->nama_perusahaan->ViewCustomAttributes = "";

		// bentuk_perusahaan
		if (strval($this->bentuk_perusahaan->CurrentValue) <> "") {
			$sFilterWrk = "`bentuk perusahaan`" . ew_SearchString("=", $this->bentuk_perusahaan->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `bentuk perusahaan`, `bentuk perusahaan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `bentuk_perusahaan`";
		$sWhereWrk = "";
		$this->bentuk_perusahaan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bentuk_perusahaan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bentuk_perusahaan->ViewValue = $this->bentuk_perusahaan->CurrentValue;
			}
		} else {
			$this->bentuk_perusahaan->ViewValue = NULL;
		}
		$this->bentuk_perusahaan->ViewCustomAttributes = "";

		// alamat_perusahaan
		$this->alamat_perusahaan->ViewValue = $this->alamat_perusahaan->CurrentValue;
		$this->alamat_perusahaan->ViewCustomAttributes = "";

		// kepala_perusahaan
		$this->kepala_perusahaan->ViewValue = $this->kepala_perusahaan->CurrentValue;
		$this->kepala_perusahaan->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nama_rekening
		$this->nama_rekening->ViewValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// lanjutkan
		if (strval($this->lanjutkan->CurrentValue) <> "") {
			$this->lanjutkan->ViewValue = $this->lanjutkan->OptionCaption($this->lanjutkan->CurrentValue);
		} else {
			$this->lanjutkan->ViewValue = NULL;
		}
		$this->lanjutkan->ViewCustomAttributes = "";

		// waktu_kontrak
		$this->waktu_kontrak->ViewValue = $this->waktu_kontrak->CurrentValue;
		$this->waktu_kontrak->ViewCustomAttributes = "";

		// tgl_mulai
		$this->tgl_mulai->ViewValue = $this->tgl_mulai->CurrentValue;
		$this->tgl_mulai->ViewValue = ew_FormatDateTime($this->tgl_mulai->ViewValue, 7);
		$this->tgl_mulai->ViewCustomAttributes = "";

		// tgl_selesai
		$this->tgl_selesai->ViewValue = $this->tgl_selesai->CurrentValue;
		$this->tgl_selesai->ViewValue = ew_FormatDateTime($this->tgl_selesai->ViewValue, 7);
		$this->tgl_selesai->ViewCustomAttributes = "";

		// paket_pekerjaan
		$this->paket_pekerjaan->ViewValue = $this->paket_pekerjaan->CurrentValue;
		$this->paket_pekerjaan->ViewCustomAttributes = "";

		// nama_ppkom
		if (strval($this->nama_ppkom->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_ppkom->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_ppkom->LookupFilters = array();
		$lookuptblfilter = "`jabatan`=3";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_ppkom, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_ppkom->ViewValue = $this->nama_ppkom->CurrentValue;
			}
		} else {
			$this->nama_ppkom->ViewValue = NULL;
		}
		$this->nama_ppkom->ViewCustomAttributes = "";

		// nip_ppkom
		$this->nip_ppkom->ViewValue = $this->nip_ppkom->CurrentValue;
		$this->nip_ppkom->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

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

		// no_kontrak
		$this->no_kontrak->LinkCustomAttributes = "";
		$this->no_kontrak->HrefValue = "";
		$this->no_kontrak->TooltipValue = "";

		// tgl_kontrak
		$this->tgl_kontrak->LinkCustomAttributes = "";
		$this->tgl_kontrak->HrefValue = "";
		$this->tgl_kontrak->TooltipValue = "";

		// nama_perusahaan
		$this->nama_perusahaan->LinkCustomAttributes = "";
		$this->nama_perusahaan->HrefValue = "";
		$this->nama_perusahaan->TooltipValue = "";

		// bentuk_perusahaan
		$this->bentuk_perusahaan->LinkCustomAttributes = "";
		$this->bentuk_perusahaan->HrefValue = "";
		$this->bentuk_perusahaan->TooltipValue = "";

		// alamat_perusahaan
		$this->alamat_perusahaan->LinkCustomAttributes = "";
		$this->alamat_perusahaan->HrefValue = "";
		$this->alamat_perusahaan->TooltipValue = "";

		// kepala_perusahaan
		$this->kepala_perusahaan->LinkCustomAttributes = "";
		$this->kepala_perusahaan->HrefValue = "";
		$this->kepala_perusahaan->TooltipValue = "";

		// npwp
		$this->npwp->LinkCustomAttributes = "";
		$this->npwp->HrefValue = "";
		$this->npwp->TooltipValue = "";

		// nama_bank
		$this->nama_bank->LinkCustomAttributes = "";
		$this->nama_bank->HrefValue = "";
		$this->nama_bank->TooltipValue = "";

		// nama_rekening
		$this->nama_rekening->LinkCustomAttributes = "";
		$this->nama_rekening->HrefValue = "";
		$this->nama_rekening->TooltipValue = "";

		// nomer_rekening
		$this->nomer_rekening->LinkCustomAttributes = "";
		$this->nomer_rekening->HrefValue = "";
		$this->nomer_rekening->TooltipValue = "";

		// lanjutkan
		$this->lanjutkan->LinkCustomAttributes = "";
		$this->lanjutkan->HrefValue = "";
		$this->lanjutkan->TooltipValue = "";

		// waktu_kontrak
		$this->waktu_kontrak->LinkCustomAttributes = "";
		$this->waktu_kontrak->HrefValue = "";
		$this->waktu_kontrak->TooltipValue = "";

		// tgl_mulai
		$this->tgl_mulai->LinkCustomAttributes = "";
		$this->tgl_mulai->HrefValue = "";
		$this->tgl_mulai->TooltipValue = "";

		// tgl_selesai
		$this->tgl_selesai->LinkCustomAttributes = "";
		$this->tgl_selesai->HrefValue = "";
		$this->tgl_selesai->TooltipValue = "";

		// paket_pekerjaan
		$this->paket_pekerjaan->LinkCustomAttributes = "";
		$this->paket_pekerjaan->HrefValue = "";
		$this->paket_pekerjaan->TooltipValue = "";

		// nama_ppkom
		$this->nama_ppkom->LinkCustomAttributes = "";
		$this->nama_ppkom->HrefValue = "";
		$this->nama_ppkom->TooltipValue = "";

		// nip_ppkom
		$this->nip_ppkom->LinkCustomAttributes = "";
		$this->nip_ppkom->HrefValue = "";
		$this->nip_ppkom->TooltipValue = "";

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

		// program
		$this->program->EditAttrs["class"] = "form-control";
		$this->program->EditCustomAttributes = "";

		// kegiatan
		$this->kegiatan->EditAttrs["class"] = "form-control";
		$this->kegiatan->EditCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->EditAttrs["class"] = "form-control";
		$this->sub_kegiatan->EditCustomAttributes = "";

		// no_kontrak
		$this->no_kontrak->EditAttrs["class"] = "form-control";
		$this->no_kontrak->EditCustomAttributes = "";
		$this->no_kontrak->EditValue = $this->no_kontrak->CurrentValue;
		$this->no_kontrak->PlaceHolder = ew_RemoveHtml($this->no_kontrak->FldCaption());

		// tgl_kontrak
		$this->tgl_kontrak->EditAttrs["class"] = "form-control";
		$this->tgl_kontrak->EditCustomAttributes = "";
		$this->tgl_kontrak->EditValue = ew_FormatDateTime($this->tgl_kontrak->CurrentValue, 8);
		$this->tgl_kontrak->PlaceHolder = ew_RemoveHtml($this->tgl_kontrak->FldCaption());

		// nama_perusahaan
		$this->nama_perusahaan->EditAttrs["class"] = "form-control";
		$this->nama_perusahaan->EditCustomAttributes = "";
		$this->nama_perusahaan->EditValue = $this->nama_perusahaan->CurrentValue;
		$this->nama_perusahaan->PlaceHolder = ew_RemoveHtml($this->nama_perusahaan->FldCaption());

		// bentuk_perusahaan
		$this->bentuk_perusahaan->EditAttrs["class"] = "form-control";
		$this->bentuk_perusahaan->EditCustomAttributes = "";

		// alamat_perusahaan
		$this->alamat_perusahaan->EditAttrs["class"] = "form-control";
		$this->alamat_perusahaan->EditCustomAttributes = "";
		$this->alamat_perusahaan->EditValue = $this->alamat_perusahaan->CurrentValue;
		$this->alamat_perusahaan->PlaceHolder = ew_RemoveHtml($this->alamat_perusahaan->FldCaption());

		// kepala_perusahaan
		$this->kepala_perusahaan->EditAttrs["class"] = "form-control";
		$this->kepala_perusahaan->EditCustomAttributes = "";
		$this->kepala_perusahaan->EditValue = $this->kepala_perusahaan->CurrentValue;
		$this->kepala_perusahaan->PlaceHolder = ew_RemoveHtml($this->kepala_perusahaan->FldCaption());

		// npwp
		$this->npwp->EditAttrs["class"] = "form-control";
		$this->npwp->EditCustomAttributes = "";
		$this->npwp->EditValue = $this->npwp->CurrentValue;
		$this->npwp->PlaceHolder = ew_RemoveHtml($this->npwp->FldCaption());

		// nama_bank
		$this->nama_bank->EditAttrs["class"] = "form-control";
		$this->nama_bank->EditCustomAttributes = "";
		$this->nama_bank->EditValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

		// nama_rekening
		$this->nama_rekening->EditAttrs["class"] = "form-control";
		$this->nama_rekening->EditCustomAttributes = "";
		$this->nama_rekening->EditValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->PlaceHolder = ew_RemoveHtml($this->nama_rekening->FldCaption());

		// nomer_rekening
		$this->nomer_rekening->EditAttrs["class"] = "form-control";
		$this->nomer_rekening->EditCustomAttributes = "";
		$this->nomer_rekening->EditValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->PlaceHolder = ew_RemoveHtml($this->nomer_rekening->FldCaption());

		// lanjutkan
		$this->lanjutkan->EditAttrs["class"] = "form-control";
		$this->lanjutkan->EditCustomAttributes = "";
		$this->lanjutkan->EditValue = $this->lanjutkan->Options(TRUE);

		// waktu_kontrak
		$this->waktu_kontrak->EditAttrs["class"] = "form-control";
		$this->waktu_kontrak->EditCustomAttributes = "";
		$this->waktu_kontrak->EditValue = $this->waktu_kontrak->CurrentValue;
		$this->waktu_kontrak->PlaceHolder = ew_RemoveHtml($this->waktu_kontrak->FldCaption());

		// tgl_mulai
		$this->tgl_mulai->EditAttrs["class"] = "form-control";
		$this->tgl_mulai->EditCustomAttributes = "";
		$this->tgl_mulai->EditValue = ew_FormatDateTime($this->tgl_mulai->CurrentValue, 7);
		$this->tgl_mulai->PlaceHolder = ew_RemoveHtml($this->tgl_mulai->FldCaption());

		// tgl_selesai
		$this->tgl_selesai->EditAttrs["class"] = "form-control";
		$this->tgl_selesai->EditCustomAttributes = "";
		$this->tgl_selesai->EditValue = ew_FormatDateTime($this->tgl_selesai->CurrentValue, 7);
		$this->tgl_selesai->PlaceHolder = ew_RemoveHtml($this->tgl_selesai->FldCaption());

		// paket_pekerjaan
		$this->paket_pekerjaan->EditAttrs["class"] = "form-control";
		$this->paket_pekerjaan->EditCustomAttributes = "";
		$this->paket_pekerjaan->EditValue = $this->paket_pekerjaan->CurrentValue;
		$this->paket_pekerjaan->PlaceHolder = ew_RemoveHtml($this->paket_pekerjaan->FldCaption());

		// nama_ppkom
		$this->nama_ppkom->EditAttrs["class"] = "form-control";
		$this->nama_ppkom->EditCustomAttributes = "";

		// nip_ppkom
		$this->nip_ppkom->EditAttrs["class"] = "form-control";
		$this->nip_ppkom->EditCustomAttributes = "";
		$this->nip_ppkom->EditValue = $this->nip_ppkom->CurrentValue;
		$this->nip_ppkom->PlaceHolder = ew_RemoveHtml($this->nip_ppkom->FldCaption());

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
					if ($this->program->Exportable) $Doc->ExportCaption($this->program);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->sub_kegiatan->Exportable) $Doc->ExportCaption($this->sub_kegiatan);
					if ($this->no_kontrak->Exportable) $Doc->ExportCaption($this->no_kontrak);
					if ($this->tgl_kontrak->Exportable) $Doc->ExportCaption($this->tgl_kontrak);
					if ($this->nama_perusahaan->Exportable) $Doc->ExportCaption($this->nama_perusahaan);
					if ($this->bentuk_perusahaan->Exportable) $Doc->ExportCaption($this->bentuk_perusahaan);
					if ($this->alamat_perusahaan->Exportable) $Doc->ExportCaption($this->alamat_perusahaan);
					if ($this->kepala_perusahaan->Exportable) $Doc->ExportCaption($this->kepala_perusahaan);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->nama_bank->Exportable) $Doc->ExportCaption($this->nama_bank);
					if ($this->nama_rekening->Exportable) $Doc->ExportCaption($this->nama_rekening);
					if ($this->nomer_rekening->Exportable) $Doc->ExportCaption($this->nomer_rekening);
					if ($this->lanjutkan->Exportable) $Doc->ExportCaption($this->lanjutkan);
					if ($this->waktu_kontrak->Exportable) $Doc->ExportCaption($this->waktu_kontrak);
					if ($this->tgl_mulai->Exportable) $Doc->ExportCaption($this->tgl_mulai);
					if ($this->tgl_selesai->Exportable) $Doc->ExportCaption($this->tgl_selesai);
					if ($this->paket_pekerjaan->Exportable) $Doc->ExportCaption($this->paket_pekerjaan);
					if ($this->nama_ppkom->Exportable) $Doc->ExportCaption($this->nama_ppkom);
					if ($this->nip_ppkom->Exportable) $Doc->ExportCaption($this->nip_ppkom);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->program->Exportable) $Doc->ExportCaption($this->program);
					if ($this->kegiatan->Exportable) $Doc->ExportCaption($this->kegiatan);
					if ($this->sub_kegiatan->Exportable) $Doc->ExportCaption($this->sub_kegiatan);
					if ($this->no_kontrak->Exportable) $Doc->ExportCaption($this->no_kontrak);
					if ($this->tgl_kontrak->Exportable) $Doc->ExportCaption($this->tgl_kontrak);
					if ($this->nama_perusahaan->Exportable) $Doc->ExportCaption($this->nama_perusahaan);
					if ($this->bentuk_perusahaan->Exportable) $Doc->ExportCaption($this->bentuk_perusahaan);
					if ($this->alamat_perusahaan->Exportable) $Doc->ExportCaption($this->alamat_perusahaan);
					if ($this->kepala_perusahaan->Exportable) $Doc->ExportCaption($this->kepala_perusahaan);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->nama_bank->Exportable) $Doc->ExportCaption($this->nama_bank);
					if ($this->nama_rekening->Exportable) $Doc->ExportCaption($this->nama_rekening);
					if ($this->nomer_rekening->Exportable) $Doc->ExportCaption($this->nomer_rekening);
					if ($this->lanjutkan->Exportable) $Doc->ExportCaption($this->lanjutkan);
					if ($this->waktu_kontrak->Exportable) $Doc->ExportCaption($this->waktu_kontrak);
					if ($this->tgl_mulai->Exportable) $Doc->ExportCaption($this->tgl_mulai);
					if ($this->tgl_selesai->Exportable) $Doc->ExportCaption($this->tgl_selesai);
					if ($this->paket_pekerjaan->Exportable) $Doc->ExportCaption($this->paket_pekerjaan);
					if ($this->nama_ppkom->Exportable) $Doc->ExportCaption($this->nama_ppkom);
					if ($this->nip_ppkom->Exportable) $Doc->ExportCaption($this->nip_ppkom);
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
						if ($this->program->Exportable) $Doc->ExportField($this->program);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->sub_kegiatan->Exportable) $Doc->ExportField($this->sub_kegiatan);
						if ($this->no_kontrak->Exportable) $Doc->ExportField($this->no_kontrak);
						if ($this->tgl_kontrak->Exportable) $Doc->ExportField($this->tgl_kontrak);
						if ($this->nama_perusahaan->Exportable) $Doc->ExportField($this->nama_perusahaan);
						if ($this->bentuk_perusahaan->Exportable) $Doc->ExportField($this->bentuk_perusahaan);
						if ($this->alamat_perusahaan->Exportable) $Doc->ExportField($this->alamat_perusahaan);
						if ($this->kepala_perusahaan->Exportable) $Doc->ExportField($this->kepala_perusahaan);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->nama_bank->Exportable) $Doc->ExportField($this->nama_bank);
						if ($this->nama_rekening->Exportable) $Doc->ExportField($this->nama_rekening);
						if ($this->nomer_rekening->Exportable) $Doc->ExportField($this->nomer_rekening);
						if ($this->lanjutkan->Exportable) $Doc->ExportField($this->lanjutkan);
						if ($this->waktu_kontrak->Exportable) $Doc->ExportField($this->waktu_kontrak);
						if ($this->tgl_mulai->Exportable) $Doc->ExportField($this->tgl_mulai);
						if ($this->tgl_selesai->Exportable) $Doc->ExportField($this->tgl_selesai);
						if ($this->paket_pekerjaan->Exportable) $Doc->ExportField($this->paket_pekerjaan);
						if ($this->nama_ppkom->Exportable) $Doc->ExportField($this->nama_ppkom);
						if ($this->nip_ppkom->Exportable) $Doc->ExportField($this->nip_ppkom);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->program->Exportable) $Doc->ExportField($this->program);
						if ($this->kegiatan->Exportable) $Doc->ExportField($this->kegiatan);
						if ($this->sub_kegiatan->Exportable) $Doc->ExportField($this->sub_kegiatan);
						if ($this->no_kontrak->Exportable) $Doc->ExportField($this->no_kontrak);
						if ($this->tgl_kontrak->Exportable) $Doc->ExportField($this->tgl_kontrak);
						if ($this->nama_perusahaan->Exportable) $Doc->ExportField($this->nama_perusahaan);
						if ($this->bentuk_perusahaan->Exportable) $Doc->ExportField($this->bentuk_perusahaan);
						if ($this->alamat_perusahaan->Exportable) $Doc->ExportField($this->alamat_perusahaan);
						if ($this->kepala_perusahaan->Exportable) $Doc->ExportField($this->kepala_perusahaan);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->nama_bank->Exportable) $Doc->ExportField($this->nama_bank);
						if ($this->nama_rekening->Exportable) $Doc->ExportField($this->nama_rekening);
						if ($this->nomer_rekening->Exportable) $Doc->ExportField($this->nomer_rekening);
						if ($this->lanjutkan->Exportable) $Doc->ExportField($this->lanjutkan);
						if ($this->waktu_kontrak->Exportable) $Doc->ExportField($this->waktu_kontrak);
						if ($this->tgl_mulai->Exportable) $Doc->ExportField($this->tgl_mulai);
						if ($this->tgl_selesai->Exportable) $Doc->ExportField($this->tgl_selesai);
						if ($this->paket_pekerjaan->Exportable) $Doc->ExportField($this->paket_pekerjaan);
						if ($this->nama_ppkom->Exportable) $Doc->ExportField($this->nama_ppkom);
						if ($this->nip_ppkom->Exportable) $Doc->ExportField($this->nip_ppkom);
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
		if (preg_match('/^x(\d)*_sub_kegiatan$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `kode_sub_kegiatan` AS FIELD0 FROM `m_sub_kegiatan`";
			$sWhereWrk = "(`kode_sub_kegiatan` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->sub_kegiatan->LookupFilters = array();
			$this->Lookup_Selecting($this->sub_kegiatan, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->no_kontrak->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->no_kontrak->AutoFillOriginalValue) ? $this->no_kontrak->CurrentValue : $this->no_kontrak->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_nama_ppkom$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `nip` AS FIELD0 FROM `m_pejabat_keuangan`";
			$sWhereWrk = "(`nama` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->nama_ppkom->LookupFilters = array();
			$lookuptblfilter = "`jabatan`=3";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->nama_ppkom, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->nip_ppkom->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->nip_ppkom->AutoFillOriginalValue) ? $this->nip_ppkom->CurrentValue : $this->nip_ppkom->EditValue;
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
		//$this->nip_ppkom->ReadOnly = TRUE;

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
