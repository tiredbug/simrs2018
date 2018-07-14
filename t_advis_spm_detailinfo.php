<?php

// Global variable for table object
$t_advis_spm_detail = NULL;

//
// Table class for t_advis_spm_detail
//
class ct_advis_spm_detail extends cTable {
	var $id;
	var $id_advis;
	var $tahun_anggaran;
	var $id_spp;
	var $no_spm;
	var $nama_rekanan;
	var $nama_bank;
	var $nomer_rekening;
	var $nama_rekening;
	var $bruto;
	var $pajak;
	var $netto;
	var $no_advis;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_advis_spm_detail';
		$this->TableName = 't_advis_spm_detail';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_advis_spm_detail`";
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
		$this->id = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = FALSE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// id_advis
		$this->id_advis = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_id_advis', 'id_advis', '`id_advis`', '`id_advis`', 200, -1, FALSE, '`id_advis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_advis->Sortable = FALSE; // Allow sort
		$this->fields['id_advis'] = &$this->id_advis;

		// tahun_anggaran
		$this->tahun_anggaran = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_tahun_anggaran', 'tahun_anggaran', '`tahun_anggaran`', '`tahun_anggaran`', 200, -1, FALSE, '`tahun_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun_anggaran->Sortable = FALSE; // Allow sort
		$this->fields['tahun_anggaran'] = &$this->tahun_anggaran;

		// id_spp
		$this->id_spp = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_id_spp', 'id_spp', '`id_spp`', '`id_spp`', 3, -1, FALSE, '`id_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_spp->Sortable = FALSE; // Allow sort
		$this->fields['id_spp'] = &$this->id_spp;

		// no_spm
		$this->no_spm = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_no_spm', 'no_spm', '`no_spm`', '`no_spm`', 200, -1, FALSE, '`no_spm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spm->Sortable = FALSE; // Allow sort
		$this->fields['no_spm'] = &$this->no_spm;

		// nama_rekanan
		$this->nama_rekanan = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_nama_rekanan', 'nama_rekanan', '`nama_rekanan`', '`nama_rekanan`', 200, -1, FALSE, '`nama_rekanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_rekanan->Sortable = FALSE; // Allow sort
		$this->fields['nama_rekanan'] = &$this->nama_rekanan;

		// nama_bank
		$this->nama_bank = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_nama_bank', 'nama_bank', '`nama_bank`', '`nama_bank`', 200, -1, FALSE, '`nama_bank`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_bank->Sortable = FALSE; // Allow sort
		$this->fields['nama_bank'] = &$this->nama_bank;

		// nomer_rekening
		$this->nomer_rekening = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_nomer_rekening', 'nomer_rekening', '`nomer_rekening`', '`nomer_rekening`', 200, -1, FALSE, '`nomer_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomer_rekening->Sortable = FALSE; // Allow sort
		$this->fields['nomer_rekening'] = &$this->nomer_rekening;

		// nama_rekening
		$this->nama_rekening = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_nama_rekening', 'nama_rekening', '`nama_rekening`', '`nama_rekening`', 200, -1, FALSE, '`nama_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_rekening->Sortable = FALSE; // Allow sort
		$this->fields['nama_rekening'] = &$this->nama_rekening;

		// bruto
		$this->bruto = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_bruto', 'bruto', '`bruto`', '`bruto`', 200, -1, FALSE, '`bruto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bruto->Sortable = FALSE; // Allow sort
		$this->fields['bruto'] = &$this->bruto;

		// pajak
		$this->pajak = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_pajak', 'pajak', '`pajak`', '`pajak`', 200, -1, FALSE, '`pajak`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pajak->Sortable = FALSE; // Allow sort
		$this->fields['pajak'] = &$this->pajak;

		// netto
		$this->netto = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_netto', 'netto', '`netto`', '`netto`', 200, -1, FALSE, '`netto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->netto->Sortable = FALSE; // Allow sort
		$this->fields['netto'] = &$this->netto;

		// no_advis
		$this->no_advis = new cField('t_advis_spm_detail', 't_advis_spm_detail', 'x_no_advis', 'no_advis', '`no_advis`', '`no_advis`', 200, -1, FALSE, '`no_advis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_advis->Sortable = FALSE; // Allow sort
		$this->fields['no_advis'] = &$this->no_advis;
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
		if ($this->getCurrentMasterTable() == "t_advis_spm") {
			if ($this->id_advis->getSessionValue() <> "")
				$sMasterFilter .= "`id`=" . ew_QuotedValue($this->id_advis->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
			if ($this->no_advis->getSessionValue() <> "")
				$sMasterFilter .= " AND `kode_advis`=" . ew_QuotedValue($this->no_advis->getSessionValue(), EW_DATATYPE_STRING, "DB");
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
		if ($this->getCurrentMasterTable() == "t_advis_spm") {
			if ($this->id_advis->getSessionValue() <> "")
				$sDetailFilter .= "`id_advis`=" . ew_QuotedValue($this->id_advis->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->no_advis->getSessionValue() <> "")
				$sDetailFilter .= " AND `no_advis`=" . ew_QuotedValue($this->no_advis->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
			if ($this->tahun_anggaran->getSessionValue() <> "")
				$sDetailFilter .= " AND `tahun_anggaran`=" . ew_QuotedValue($this->tahun_anggaran->getSessionValue(), EW_DATATYPE_STRING, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_t_advis_spm() {
		return "`id`=@id@ AND `kode_advis`='@kode_advis@' AND `tahun_anggaran`=@tahun_anggaran@";
	}

	// Detail filter
	function SqlDetailFilter_t_advis_spm() {
		return "`id_advis`='@id_advis@' AND `no_advis`='@no_advis@' AND `tahun_anggaran`='@tahun_anggaran@'";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_advis_spm_detail`";
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
			return "t_advis_spm_detaillist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_advis_spm_detaillist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_advis_spm_detailview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_advis_spm_detailview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_advis_spm_detailadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_advis_spm_detailadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_advis_spm_detailedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_advis_spm_detailadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_advis_spm_detaildelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "t_advis_spm" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_id=" . urlencode($this->id_advis->CurrentValue);
			$url .= "&fk_kode_advis=" . urlencode($this->no_advis->CurrentValue);
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
		$this->id_advis->setDbValue($rs->fields('id_advis'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->id_spp->setDbValue($rs->fields('id_spp'));
		$this->no_spm->setDbValue($rs->fields('no_spm'));
		$this->nama_rekanan->setDbValue($rs->fields('nama_rekanan'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nomer_rekening->setDbValue($rs->fields('nomer_rekening'));
		$this->nama_rekening->setDbValue($rs->fields('nama_rekening'));
		$this->bruto->setDbValue($rs->fields('bruto'));
		$this->pajak->setDbValue($rs->fields('pajak'));
		$this->netto->setDbValue($rs->fields('netto'));
		$this->no_advis->setDbValue($rs->fields('no_advis'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id

		$this->id->CellCssStyle = "white-space: nowrap;";

		// id_advis
		$this->id_advis->CellCssStyle = "white-space: nowrap;";

		// tahun_anggaran
		$this->tahun_anggaran->CellCssStyle = "white-space: nowrap;";

		// id_spp
		$this->id_spp->CellCssStyle = "white-space: nowrap;";

		// no_spm
		$this->no_spm->CellCssStyle = "white-space: nowrap;";

		// nama_rekanan
		$this->nama_rekanan->CellCssStyle = "white-space: nowrap;";

		// nama_bank
		$this->nama_bank->CellCssStyle = "white-space: nowrap;";

		// nomer_rekening
		$this->nomer_rekening->CellCssStyle = "white-space: nowrap;";

		// nama_rekening
		$this->nama_rekening->CellCssStyle = "white-space: nowrap;";

		// bruto
		$this->bruto->CellCssStyle = "white-space: nowrap;";

		// pajak
		$this->pajak->CellCssStyle = "white-space: nowrap;";

		// netto
		$this->netto->CellCssStyle = "white-space: nowrap;";

		// no_advis
		$this->no_advis->CellCssStyle = "white-space: nowrap;";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_advis
		$this->id_advis->ViewValue = $this->id_advis->CurrentValue;
		$this->id_advis->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// id_spp
		$this->id_spp->ViewValue = $this->id_spp->CurrentValue;
		if (strval($this->id_spp->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->id_spp->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_spp` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `t_spp`";
		$sWhereWrk = "";
		$this->id_spp->LookupFilters = array("dx1" => '`no_spp`');
		$lookuptblfilter = "`no_spm` is not null ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->id_spp, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->id_spp->ViewValue = $this->id_spp->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->id_spp->ViewValue = $this->id_spp->CurrentValue;
			}
		} else {
			$this->id_spp->ViewValue = NULL;
		}
		$this->id_spp->ViewCustomAttributes = "";

		// no_spm
		$this->no_spm->ViewValue = $this->no_spm->CurrentValue;
		$this->no_spm->ViewCustomAttributes = "";

		// nama_rekanan
		$this->nama_rekanan->ViewValue = $this->nama_rekanan->CurrentValue;
		$this->nama_rekanan->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nomer_rekening
		$this->nomer_rekening->ViewValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->ViewCustomAttributes = "";

		// nama_rekening
		$this->nama_rekening->ViewValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->ViewCustomAttributes = "";

		// bruto
		$this->bruto->ViewValue = $this->bruto->CurrentValue;
		$this->bruto->ViewCustomAttributes = "";

		// pajak
		$this->pajak->ViewValue = $this->pajak->CurrentValue;
		$this->pajak->ViewCustomAttributes = "";

		// netto
		$this->netto->ViewValue = $this->netto->CurrentValue;
		$this->netto->ViewCustomAttributes = "";

		// no_advis
		$this->no_advis->ViewValue = $this->no_advis->CurrentValue;
		$this->no_advis->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// id_advis
		$this->id_advis->LinkCustomAttributes = "";
		$this->id_advis->HrefValue = "";
		$this->id_advis->TooltipValue = "";

		// tahun_anggaran
		$this->tahun_anggaran->LinkCustomAttributes = "";
		$this->tahun_anggaran->HrefValue = "";
		$this->tahun_anggaran->TooltipValue = "";

		// id_spp
		$this->id_spp->LinkCustomAttributes = "";
		$this->id_spp->HrefValue = "";
		$this->id_spp->TooltipValue = "";

		// no_spm
		$this->no_spm->LinkCustomAttributes = "";
		$this->no_spm->HrefValue = "";
		$this->no_spm->TooltipValue = "";

		// nama_rekanan
		$this->nama_rekanan->LinkCustomAttributes = "";
		$this->nama_rekanan->HrefValue = "";
		$this->nama_rekanan->TooltipValue = "";

		// nama_bank
		$this->nama_bank->LinkCustomAttributes = "";
		$this->nama_bank->HrefValue = "";
		$this->nama_bank->TooltipValue = "";

		// nomer_rekening
		$this->nomer_rekening->LinkCustomAttributes = "";
		$this->nomer_rekening->HrefValue = "";
		$this->nomer_rekening->TooltipValue = "";

		// nama_rekening
		$this->nama_rekening->LinkCustomAttributes = "";
		$this->nama_rekening->HrefValue = "";
		$this->nama_rekening->TooltipValue = "";

		// bruto
		$this->bruto->LinkCustomAttributes = "";
		$this->bruto->HrefValue = "";
		$this->bruto->TooltipValue = "";

		// pajak
		$this->pajak->LinkCustomAttributes = "";
		$this->pajak->HrefValue = "";
		$this->pajak->TooltipValue = "";

		// netto
		$this->netto->LinkCustomAttributes = "";
		$this->netto->HrefValue = "";
		$this->netto->TooltipValue = "";

		// no_advis
		$this->no_advis->LinkCustomAttributes = "";
		$this->no_advis->HrefValue = "";
		$this->no_advis->TooltipValue = "";

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

		// id_advis
		$this->id_advis->EditAttrs["class"] = "form-control";
		$this->id_advis->EditCustomAttributes = "";
		if ($this->id_advis->getSessionValue() <> "") {
			$this->id_advis->CurrentValue = $this->id_advis->getSessionValue();
		$this->id_advis->ViewValue = $this->id_advis->CurrentValue;
		$this->id_advis->ViewCustomAttributes = "";
		} else {
		$this->id_advis->EditValue = $this->id_advis->CurrentValue;
		$this->id_advis->PlaceHolder = ew_RemoveHtml($this->id_advis->FldCaption());
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

		// id_spp
		$this->id_spp->EditAttrs["class"] = "form-control";
		$this->id_spp->EditCustomAttributes = "";
		$this->id_spp->EditValue = $this->id_spp->CurrentValue;
		$this->id_spp->PlaceHolder = ew_RemoveHtml($this->id_spp->FldCaption());

		// no_spm
		$this->no_spm->EditAttrs["class"] = "form-control";
		$this->no_spm->EditCustomAttributes = "";
		$this->no_spm->EditValue = $this->no_spm->CurrentValue;
		$this->no_spm->PlaceHolder = ew_RemoveHtml($this->no_spm->FldCaption());

		// nama_rekanan
		$this->nama_rekanan->EditAttrs["class"] = "form-control";
		$this->nama_rekanan->EditCustomAttributes = "";
		$this->nama_rekanan->EditValue = $this->nama_rekanan->CurrentValue;
		$this->nama_rekanan->PlaceHolder = ew_RemoveHtml($this->nama_rekanan->FldCaption());

		// nama_bank
		$this->nama_bank->EditAttrs["class"] = "form-control";
		$this->nama_bank->EditCustomAttributes = "";
		$this->nama_bank->EditValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

		// nomer_rekening
		$this->nomer_rekening->EditAttrs["class"] = "form-control";
		$this->nomer_rekening->EditCustomAttributes = "";
		$this->nomer_rekening->EditValue = $this->nomer_rekening->CurrentValue;
		$this->nomer_rekening->PlaceHolder = ew_RemoveHtml($this->nomer_rekening->FldCaption());

		// nama_rekening
		$this->nama_rekening->EditAttrs["class"] = "form-control";
		$this->nama_rekening->EditCustomAttributes = "";
		$this->nama_rekening->EditValue = $this->nama_rekening->CurrentValue;
		$this->nama_rekening->PlaceHolder = ew_RemoveHtml($this->nama_rekening->FldCaption());

		// bruto
		$this->bruto->EditAttrs["class"] = "form-control";
		$this->bruto->EditCustomAttributes = "";
		$this->bruto->EditValue = $this->bruto->CurrentValue;
		$this->bruto->PlaceHolder = ew_RemoveHtml($this->bruto->FldCaption());

		// pajak
		$this->pajak->EditAttrs["class"] = "form-control";
		$this->pajak->EditCustomAttributes = "";
		$this->pajak->EditValue = $this->pajak->CurrentValue;
		$this->pajak->PlaceHolder = ew_RemoveHtml($this->pajak->FldCaption());

		// netto
		$this->netto->EditAttrs["class"] = "form-control";
		$this->netto->EditCustomAttributes = "";
		$this->netto->EditValue = $this->netto->CurrentValue;
		$this->netto->PlaceHolder = ew_RemoveHtml($this->netto->FldCaption());

		// no_advis
		$this->no_advis->EditAttrs["class"] = "form-control";
		$this->no_advis->EditCustomAttributes = "";
		if ($this->no_advis->getSessionValue() <> "") {
			$this->no_advis->CurrentValue = $this->no_advis->getSessionValue();
		$this->no_advis->ViewValue = $this->no_advis->CurrentValue;
		$this->no_advis->ViewCustomAttributes = "";
		} else {
		$this->no_advis->EditValue = $this->no_advis->CurrentValue;
		$this->no_advis->PlaceHolder = ew_RemoveHtml($this->no_advis->FldCaption());
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
