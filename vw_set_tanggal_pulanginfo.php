<?php

// Global variable for table object
$vw_set_tanggal_pulang = NULL;

//
// Table class for vw_set_tanggal_pulang
//
class cvw_set_tanggal_pulang extends cTable {
	var $id_admission;
	var $nomr;
	var $ket_nama;
	var $ket_alamat;
	var $statusbayar;
	var $masukrs;
	var $noruang;
	var $keluarrs;
	var $tempat_tidur_id;
	var $icd_keluar;
	var $dokter_penanggungjawab;
	var $KELASPERAWATAN_ID;
	var $NO_SKP;
	var $statuskeluarranap_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_set_tanggal_pulang';
		$this->TableName = 'vw_set_tanggal_pulang';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_set_tanggal_pulang`";
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

		// id_admission
		$this->id_admission = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_id_admission', 'id_admission', '`id_admission`', '`id_admission`', 3, -1, FALSE, '`id_admission`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_admission->Sortable = TRUE; // Allow sort
		$this->id_admission->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_admission'] = &$this->id_admission;

		// nomr
		$this->nomr = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_nomr', 'nomr', '`nomr`', '`nomr`', 200, -1, FALSE, '`nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomr->Sortable = TRUE; // Allow sort
		$this->fields['nomr'] = &$this->nomr;

		// ket_nama
		$this->ket_nama = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_ket_nama', 'ket_nama', '`ket_nama`', '`ket_nama`', 200, -1, FALSE, '`ket_nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_nama->Sortable = TRUE; // Allow sort
		$this->fields['ket_nama'] = &$this->ket_nama;

		// ket_alamat
		$this->ket_alamat = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_ket_alamat', 'ket_alamat', '`ket_alamat`', '`ket_alamat`', 200, -1, FALSE, '`ket_alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_alamat->Sortable = TRUE; // Allow sort
		$this->fields['ket_alamat'] = &$this->ket_alamat;

		// statusbayar
		$this->statusbayar = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_statusbayar', 'statusbayar', '`statusbayar`', '`statusbayar`', 3, -1, FALSE, '`statusbayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->statusbayar->Sortable = TRUE; // Allow sort
		$this->statusbayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statusbayar'] = &$this->statusbayar;

		// masukrs
		$this->masukrs = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_masukrs', 'masukrs', '`masukrs`', ew_CastDateFieldForLike('`masukrs`', 0, "DB"), 135, 0, FALSE, '`masukrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->masukrs->Sortable = TRUE; // Allow sort
		$this->masukrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['masukrs'] = &$this->masukrs;

		// noruang
		$this->noruang = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_noruang', 'noruang', '`noruang`', '`noruang`', 3, -1, FALSE, '`noruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->noruang->Sortable = TRUE; // Allow sort
		$this->noruang->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->noruang->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->noruang->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['noruang'] = &$this->noruang;

		// keluarrs
		$this->keluarrs = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_keluarrs', 'keluarrs', '`keluarrs`', ew_CastDateFieldForLike('`keluarrs`', 17, "DB"), 135, 17, FALSE, '`keluarrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keluarrs->Sortable = TRUE; // Allow sort
		$this->keluarrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectShortDateDMY"));
		$this->fields['keluarrs'] = &$this->keluarrs;

		// tempat_tidur_id
		$this->tempat_tidur_id = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_tempat_tidur_id', 'tempat_tidur_id', '`tempat_tidur_id`', '`tempat_tidur_id`', 3, -1, FALSE, '`tempat_tidur_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->tempat_tidur_id->Sortable = TRUE; // Allow sort
		$this->tempat_tidur_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->tempat_tidur_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->tempat_tidur_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tempat_tidur_id'] = &$this->tempat_tidur_id;

		// icd_keluar
		$this->icd_keluar = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_icd_keluar', 'icd_keluar', '`icd_keluar`', '`icd_keluar`', 200, -1, FALSE, '`icd_keluar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->icd_keluar->Sortable = TRUE; // Allow sort
		$this->fields['icd_keluar'] = &$this->icd_keluar;

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_dokter_penanggungjawab', 'dokter_penanggungjawab', '`dokter_penanggungjawab`', '`dokter_penanggungjawab`', 3, -1, FALSE, '`dokter_penanggungjawab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->dokter_penanggungjawab->Sortable = TRUE; // Allow sort
		$this->dokter_penanggungjawab->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->dokter_penanggungjawab->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->dokter_penanggungjawab->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dokter_penanggungjawab'] = &$this->dokter_penanggungjawab;

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_KELASPERAWATAN_ID', 'KELASPERAWATAN_ID', '`KELASPERAWATAN_ID`', '`KELASPERAWATAN_ID`', 3, -1, FALSE, '`KELASPERAWATAN_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELASPERAWATAN_ID->Sortable = TRUE; // Allow sort
		$this->KELASPERAWATAN_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KELASPERAWATAN_ID'] = &$this->KELASPERAWATAN_ID;

		// NO_SKP
		$this->NO_SKP = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_NO_SKP', 'NO_SKP', '`NO_SKP`', '`NO_SKP`', 200, -1, FALSE, '`NO_SKP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SKP->Sortable = TRUE; // Allow sort
		$this->fields['NO_SKP'] = &$this->NO_SKP;

		// statuskeluarranap_id
		$this->statuskeluarranap_id = new cField('vw_set_tanggal_pulang', 'vw_set_tanggal_pulang', 'x_statuskeluarranap_id', 'statuskeluarranap_id', '`statuskeluarranap_id`', '`statuskeluarranap_id`', 3, -1, FALSE, '`statuskeluarranap_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->statuskeluarranap_id->Sortable = TRUE; // Allow sort
		$this->statuskeluarranap_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->statuskeluarranap_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->statuskeluarranap_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statuskeluarranap_id'] = &$this->statuskeluarranap_id;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_set_tanggal_pulang`";
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
			if (array_key_exists('id_admission', $rs))
				ew_AddFilter($where, ew_QuotedName('id_admission', $this->DBID) . '=' . ew_QuotedValue($rs['id_admission'], $this->id_admission->FldDataType, $this->DBID));
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
		return "`id_admission` = @id_admission@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id_admission->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id_admission@", ew_AdjustSql($this->id_admission->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "vw_set_tanggal_pulanglist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_set_tanggal_pulanglist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_set_tanggal_pulangview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_set_tanggal_pulangview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_set_tanggal_pulangadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_set_tanggal_pulangadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_set_tanggal_pulangedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_set_tanggal_pulangadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_set_tanggal_pulangdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id_admission:" . ew_VarToJson($this->id_admission->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id_admission->CurrentValue)) {
			$sUrl .= "id_admission=" . urlencode($this->id_admission->CurrentValue);
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
			if ($isPost && isset($_POST["id_admission"]))
				$arKeys[] = ew_StripSlashes($_POST["id_admission"]);
			elseif (isset($_GET["id_admission"]))
				$arKeys[] = ew_StripSlashes($_GET["id_admission"]);
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
			$this->id_admission->CurrentValue = $key;
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
		$this->id_admission->setDbValue($rs->fields('id_admission'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->ket_nama->setDbValue($rs->fields('ket_nama'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id_admission
		// nomr
		// ket_nama
		// ket_alamat
		// statusbayar
		// masukrs
		// noruang
		// keluarrs
		// tempat_tidur_id
		// icd_keluar
		// dokter_penanggungjawab
		// KELASPERAWATAN_ID
		// NO_SKP
		// statuskeluarranap_id
		// id_admission

		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
		if (strval($this->statusbayar->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->statusbayar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statusbayar->ViewValue = $this->statusbayar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statusbayar->ViewValue = $this->statusbayar->CurrentValue;
			}
		} else {
			$this->statusbayar->ViewValue = NULL;
		}
		$this->statusbayar->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 0);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		if (strval($this->noruang->CurrentValue) <> "") {
			$sFilterWrk = "`no`" . ew_SearchString("=", $this->noruang->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `no`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_ruang`";
		$sWhereWrk = "";
		$this->noruang->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->noruang, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->noruang->ViewValue = $this->noruang->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->noruang->ViewValue = $this->noruang->CurrentValue;
			}
		} else {
			$this->noruang->ViewValue = NULL;
		}
		$this->noruang->ViewCustomAttributes = "";

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 17);
		$this->keluarrs->ViewCustomAttributes = "";

		// tempat_tidur_id
		if (strval($this->tempat_tidur_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
		$sWhereWrk = "";
		$this->tempat_tidur_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->CurrentValue;
			}
		} else {
			$this->tempat_tidur_id->ViewValue = NULL;
		}
		$this->tempat_tidur_id->ViewCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		if (strval($this->icd_keluar->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_keluar->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `icd_eklaim`";
		$sWhereWrk = "";
		$this->icd_keluar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_keluar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_keluar->ViewValue = $this->icd_keluar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
			}
		} else {
			$this->icd_keluar->ViewValue = NULL;
		}
		$this->icd_keluar->ViewCustomAttributes = "";

		// dokter_penanggungjawab
		if (strval($this->dokter_penanggungjawab->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokter_penanggungjawab->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokter_penanggungjawab->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokter_penanggungjawab, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->CurrentValue;
			}
		} else {
			$this->dokter_penanggungjawab->ViewValue = NULL;
		}
		$this->dokter_penanggungjawab->ViewCustomAttributes = "";

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// statuskeluarranap_id
		if (strval($this->statuskeluarranap_id->CurrentValue) <> "") {
			$sFilterWrk = "`status`" . ew_SearchString("=", $this->statuskeluarranap_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `status`, `keterangan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_statuskeluar`";
		$sWhereWrk = "";
		$this->statuskeluarranap_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statuskeluarranap_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
			}
		} else {
			$this->statuskeluarranap_id->ViewValue = NULL;
		}
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

		// id_admission
		$this->id_admission->LinkCustomAttributes = "";
		$this->id_admission->HrefValue = "";
		$this->id_admission->TooltipValue = "";

		// nomr
		$this->nomr->LinkCustomAttributes = "";
		$this->nomr->HrefValue = "";
		$this->nomr->TooltipValue = "";

		// ket_nama
		$this->ket_nama->LinkCustomAttributes = "";
		$this->ket_nama->HrefValue = "";
		$this->ket_nama->TooltipValue = "";

		// ket_alamat
		$this->ket_alamat->LinkCustomAttributes = "";
		$this->ket_alamat->HrefValue = "";
		$this->ket_alamat->TooltipValue = "";

		// statusbayar
		$this->statusbayar->LinkCustomAttributes = "";
		$this->statusbayar->HrefValue = "";
		$this->statusbayar->TooltipValue = "";

		// masukrs
		$this->masukrs->LinkCustomAttributes = "";
		$this->masukrs->HrefValue = "";
		$this->masukrs->TooltipValue = "";

		// noruang
		$this->noruang->LinkCustomAttributes = "";
		$this->noruang->HrefValue = "";
		$this->noruang->TooltipValue = "";

		// keluarrs
		$this->keluarrs->LinkCustomAttributes = "";
		$this->keluarrs->HrefValue = "";
		$this->keluarrs->TooltipValue = "";

		// tempat_tidur_id
		$this->tempat_tidur_id->LinkCustomAttributes = "";
		$this->tempat_tidur_id->HrefValue = "";
		$this->tempat_tidur_id->TooltipValue = "";

		// icd_keluar
		$this->icd_keluar->LinkCustomAttributes = "";
		$this->icd_keluar->HrefValue = "";
		$this->icd_keluar->TooltipValue = "";

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->LinkCustomAttributes = "";
		$this->dokter_penanggungjawab->HrefValue = "";
		$this->dokter_penanggungjawab->TooltipValue = "";

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
		$this->KELASPERAWATAN_ID->HrefValue = "";
		$this->KELASPERAWATAN_ID->TooltipValue = "";

		// NO_SKP
		$this->NO_SKP->LinkCustomAttributes = "";
		$this->NO_SKP->HrefValue = "";
		$this->NO_SKP->TooltipValue = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->LinkCustomAttributes = "";
		$this->statuskeluarranap_id->HrefValue = "";
		$this->statuskeluarranap_id->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id_admission
		$this->id_admission->EditAttrs["class"] = "form-control";
		$this->id_admission->EditCustomAttributes = "";
		$this->id_admission->EditValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->EditAttrs["class"] = "form-control";
		$this->nomr->EditCustomAttributes = "";
		$this->nomr->EditValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->EditAttrs["class"] = "form-control";
		$this->ket_nama->EditCustomAttributes = "";
		$this->ket_nama->EditValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->EditAttrs["class"] = "form-control";
		$this->ket_alamat->EditCustomAttributes = "";
		$this->ket_alamat->EditValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// statusbayar
		$this->statusbayar->EditAttrs["class"] = "form-control";
		$this->statusbayar->EditCustomAttributes = "";
		$this->statusbayar->EditValue = $this->statusbayar->CurrentValue;
		if (strval($this->statusbayar->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->statusbayar->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->statusbayar->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->statusbayar, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->statusbayar->EditValue = $this->statusbayar->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->statusbayar->EditValue = $this->statusbayar->CurrentValue;
			}
		} else {
			$this->statusbayar->EditValue = NULL;
		}
		$this->statusbayar->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->EditAttrs["class"] = "form-control";
		$this->masukrs->EditCustomAttributes = "";
		$this->masukrs->EditValue = $this->masukrs->CurrentValue;
		$this->masukrs->EditValue = ew_FormatDateTime($this->masukrs->EditValue, 0);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		$this->noruang->EditAttrs["class"] = "form-control";
		$this->noruang->EditCustomAttributes = "";

		// keluarrs
		$this->keluarrs->EditAttrs["class"] = "form-control";
		$this->keluarrs->EditCustomAttributes = "";
		$this->keluarrs->EditValue = ew_FormatDateTime($this->keluarrs->CurrentValue, 17);
		$this->keluarrs->PlaceHolder = ew_RemoveHtml($this->keluarrs->FldCaption());

		// tempat_tidur_id
		$this->tempat_tidur_id->EditAttrs["class"] = "form-control";
		$this->tempat_tidur_id->EditCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->EditAttrs["class"] = "form-control";
		$this->icd_keluar->EditCustomAttributes = "";
		$this->icd_keluar->EditValue = $this->icd_keluar->CurrentValue;
		$this->icd_keluar->PlaceHolder = ew_RemoveHtml($this->icd_keluar->FldCaption());

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->EditAttrs["class"] = "form-control";
		$this->dokter_penanggungjawab->EditCustomAttributes = "";

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->EditAttrs["class"] = "form-control";
		$this->KELASPERAWATAN_ID->EditCustomAttributes = "";
		$this->KELASPERAWATAN_ID->EditValue = $this->KELASPERAWATAN_ID->CurrentValue;
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->EditAttrs["class"] = "form-control";
		$this->NO_SKP->EditCustomAttributes = "";
		$this->NO_SKP->EditValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->EditAttrs["class"] = "form-control";
		$this->statuskeluarranap_id->EditCustomAttributes = "";

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
					if ($this->id_admission->Exportable) $Doc->ExportCaption($this->id_admission);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->ket_nama->Exportable) $Doc->ExportCaption($this->ket_nama);
					if ($this->ket_alamat->Exportable) $Doc->ExportCaption($this->ket_alamat);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->masukrs->Exportable) $Doc->ExportCaption($this->masukrs);
					if ($this->noruang->Exportable) $Doc->ExportCaption($this->noruang);
					if ($this->keluarrs->Exportable) $Doc->ExportCaption($this->keluarrs);
					if ($this->tempat_tidur_id->Exportable) $Doc->ExportCaption($this->tempat_tidur_id);
					if ($this->icd_keluar->Exportable) $Doc->ExportCaption($this->icd_keluar);
					if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportCaption($this->dokter_penanggungjawab);
					if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportCaption($this->KELASPERAWATAN_ID);
					if ($this->NO_SKP->Exportable) $Doc->ExportCaption($this->NO_SKP);
					if ($this->statuskeluarranap_id->Exportable) $Doc->ExportCaption($this->statuskeluarranap_id);
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
						if ($this->id_admission->Exportable) $Doc->ExportField($this->id_admission);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->ket_nama->Exportable) $Doc->ExportField($this->ket_nama);
						if ($this->ket_alamat->Exportable) $Doc->ExportField($this->ket_alamat);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->masukrs->Exportable) $Doc->ExportField($this->masukrs);
						if ($this->noruang->Exportable) $Doc->ExportField($this->noruang);
						if ($this->keluarrs->Exportable) $Doc->ExportField($this->keluarrs);
						if ($this->tempat_tidur_id->Exportable) $Doc->ExportField($this->tempat_tidur_id);
						if ($this->icd_keluar->Exportable) $Doc->ExportField($this->icd_keluar);
						if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportField($this->dokter_penanggungjawab);
						if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportField($this->KELASPERAWATAN_ID);
						if ($this->NO_SKP->Exportable) $Doc->ExportField($this->NO_SKP);
						if ($this->statuskeluarranap_id->Exportable) $Doc->ExportField($this->statuskeluarranap_id);
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
		//ew_Execute("call simrs2012.sp_set_pasien_pulang_inap('".$rsnew["id_admission"]."', '".$rsnew["nomr"]."', '".$rsnew["statusbayar"]."', '".$rsnew["kelas"]."','".$rsnew["masukrs"]."','".$rsnew["keluarrs"]."')");

		ew_Execute("call simrs2012.sp_set_pasien_pulang_inap('".$rsold["id_admission"]."', '".$rsold["nomr"]."', '".$rsold["statusbayar"]."','".$rsold["kelas"]."', '".$rsold["masukrs"]."', '".$rsnew["keluarrs"]."');");
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
