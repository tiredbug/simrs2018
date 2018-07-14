<?php

// Global variable for table object
$m_ruang = NULL;

//
// Table class for m_ruang
//
class cm_ruang extends cTable {
	var $no;
	var $nama;
	var $kelas;
	var $ruang;
	var $jumlah_tt;
	var $ket_ruang;
	var $fasilitas;
	var $keterangan;
	var $kepala_ruangan;
	var $nip_kepala_ruangan;
	var $group_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'm_ruang';
		$this->TableName = 'm_ruang';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`m_ruang`";
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

		// no
		$this->no = new cField('m_ruang', 'm_ruang', 'x_no', 'no', '`no`', '`no`', 3, -1, FALSE, '`no`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->no->Sortable = TRUE; // Allow sort
		$this->no->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['no'] = &$this->no;

		// nama
		$this->nama = new cField('m_ruang', 'm_ruang', 'x_nama', 'nama', '`nama`', '`nama`', 200, -1, FALSE, '`nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama->Sortable = TRUE; // Allow sort
		$this->fields['nama'] = &$this->nama;

		// kelas
		$this->kelas = new cField('m_ruang', 'm_ruang', 'x_kelas', 'kelas', '`kelas`', '`kelas`', 200, -1, FALSE, '`kelas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelas->Sortable = TRUE; // Allow sort
		$this->fields['kelas'] = &$this->kelas;

		// ruang
		$this->ruang = new cField('m_ruang', 'm_ruang', 'x_ruang', 'ruang', '`ruang`', '`ruang`', 200, -1, FALSE, '`ruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ruang->Sortable = TRUE; // Allow sort
		$this->fields['ruang'] = &$this->ruang;

		// jumlah_tt
		$this->jumlah_tt = new cField('m_ruang', 'm_ruang', 'x_jumlah_tt', 'jumlah_tt', '`jumlah_tt`', '`jumlah_tt`', 3, -1, FALSE, '`jumlah_tt`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_tt->Sortable = TRUE; // Allow sort
		$this->jumlah_tt->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jumlah_tt'] = &$this->jumlah_tt;

		// ket_ruang
		$this->ket_ruang = new cField('m_ruang', 'm_ruang', 'x_ket_ruang', 'ket_ruang', '`ket_ruang`', '`ket_ruang`', 200, -1, FALSE, '`ket_ruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_ruang->Sortable = TRUE; // Allow sort
		$this->fields['ket_ruang'] = &$this->ket_ruang;

		// fasilitas
		$this->fasilitas = new cField('m_ruang', 'm_ruang', 'x_fasilitas', 'fasilitas', '`fasilitas`', '`fasilitas`', 201, -1, FALSE, '`fasilitas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fasilitas->Sortable = TRUE; // Allow sort
		$this->fields['fasilitas'] = &$this->fasilitas;

		// keterangan
		$this->keterangan = new cField('m_ruang', 'm_ruang', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// kepala_ruangan
		$this->kepala_ruangan = new cField('m_ruang', 'm_ruang', 'x_kepala_ruangan', 'kepala_ruangan', '`kepala_ruangan`', '`kepala_ruangan`', 200, -1, FALSE, '`kepala_ruangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kepala_ruangan->Sortable = TRUE; // Allow sort
		$this->fields['kepala_ruangan'] = &$this->kepala_ruangan;

		// nip_kepala_ruangan
		$this->nip_kepala_ruangan = new cField('m_ruang', 'm_ruang', 'x_nip_kepala_ruangan', 'nip_kepala_ruangan', '`nip_kepala_ruangan`', '`nip_kepala_ruangan`', 200, -1, FALSE, '`nip_kepala_ruangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_kepala_ruangan->Sortable = TRUE; // Allow sort
		$this->fields['nip_kepala_ruangan'] = &$this->nip_kepala_ruangan;

		// group_id
		$this->group_id = new cField('m_ruang', 'm_ruang', 'x_group_id', 'group_id', '`group_id`', '`group_id`', 3, -1, FALSE, '`group_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->group_id->Sortable = TRUE; // Allow sort
		$this->group_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['group_id'] = &$this->group_id;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`m_ruang`";
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
			$this->no->setDbValue($conn->Insert_ID());
			$rs['no'] = $this->no->DbValue;
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
			if (array_key_exists('no', $rs))
				ew_AddFilter($where, ew_QuotedName('no', $this->DBID) . '=' . ew_QuotedValue($rs['no'], $this->no->FldDataType, $this->DBID));
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
		return "`no` = @no@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->no->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@no@", ew_AdjustSql($this->no->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "m_ruanglist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "m_ruanglist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("m_ruangview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("m_ruangview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "m_ruangadd.php?" . $this->UrlParm($parm);
		else
			$url = "m_ruangadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("m_ruangedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("m_ruangadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("m_ruangdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "no:" . ew_VarToJson($this->no->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->no->CurrentValue)) {
			$sUrl .= "no=" . urlencode($this->no->CurrentValue);
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
			if ($isPost && isset($_POST["no"]))
				$arKeys[] = ew_StripSlashes($_POST["no"]);
			elseif (isset($_GET["no"]))
				$arKeys[] = ew_StripSlashes($_GET["no"]);
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
			$this->no->CurrentValue = $key;
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
		$this->no->setDbValue($rs->fields('no'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->kelas->setDbValue($rs->fields('kelas'));
		$this->ruang->setDbValue($rs->fields('ruang'));
		$this->jumlah_tt->setDbValue($rs->fields('jumlah_tt'));
		$this->ket_ruang->setDbValue($rs->fields('ket_ruang'));
		$this->fasilitas->setDbValue($rs->fields('fasilitas'));
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->kepala_ruangan->setDbValue($rs->fields('kepala_ruangan'));
		$this->nip_kepala_ruangan->setDbValue($rs->fields('nip_kepala_ruangan'));
		$this->group_id->setDbValue($rs->fields('group_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// no
		// nama
		// kelas
		// ruang
		// jumlah_tt
		// ket_ruang
		// fasilitas
		// keterangan
		// kepala_ruangan
		// nip_kepala_ruangan
		// group_id
		// no

		$this->no->ViewValue = $this->no->CurrentValue;
		$this->no->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// kelas
		$this->kelas->ViewValue = $this->kelas->CurrentValue;
		$this->kelas->ViewCustomAttributes = "";

		// ruang
		$this->ruang->ViewValue = $this->ruang->CurrentValue;
		$this->ruang->ViewCustomAttributes = "";

		// jumlah_tt
		$this->jumlah_tt->ViewValue = $this->jumlah_tt->CurrentValue;
		$this->jumlah_tt->ViewCustomAttributes = "";

		// ket_ruang
		$this->ket_ruang->ViewValue = $this->ket_ruang->CurrentValue;
		$this->ket_ruang->ViewCustomAttributes = "";

		// fasilitas
		$this->fasilitas->ViewValue = $this->fasilitas->CurrentValue;
		$this->fasilitas->ViewCustomAttributes = "";

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// kepala_ruangan
		$this->kepala_ruangan->ViewValue = $this->kepala_ruangan->CurrentValue;
		$this->kepala_ruangan->ViewCustomAttributes = "";

		// nip_kepala_ruangan
		$this->nip_kepala_ruangan->ViewValue = $this->nip_kepala_ruangan->CurrentValue;
		$this->nip_kepala_ruangan->ViewCustomAttributes = "";

		// group_id
		$this->group_id->ViewValue = $this->group_id->CurrentValue;
		$this->group_id->ViewCustomAttributes = "";

		// no
		$this->no->LinkCustomAttributes = "";
		$this->no->HrefValue = "";
		$this->no->TooltipValue = "";

		// nama
		$this->nama->LinkCustomAttributes = "";
		$this->nama->HrefValue = "";
		$this->nama->TooltipValue = "";

		// kelas
		$this->kelas->LinkCustomAttributes = "";
		$this->kelas->HrefValue = "";
		$this->kelas->TooltipValue = "";

		// ruang
		$this->ruang->LinkCustomAttributes = "";
		$this->ruang->HrefValue = "";
		$this->ruang->TooltipValue = "";

		// jumlah_tt
		$this->jumlah_tt->LinkCustomAttributes = "";
		$this->jumlah_tt->HrefValue = "";
		$this->jumlah_tt->TooltipValue = "";

		// ket_ruang
		$this->ket_ruang->LinkCustomAttributes = "";
		$this->ket_ruang->HrefValue = "";
		$this->ket_ruang->TooltipValue = "";

		// fasilitas
		$this->fasilitas->LinkCustomAttributes = "";
		$this->fasilitas->HrefValue = "";
		$this->fasilitas->TooltipValue = "";

		// keterangan
		$this->keterangan->LinkCustomAttributes = "";
		$this->keterangan->HrefValue = "";
		$this->keterangan->TooltipValue = "";

		// kepala_ruangan
		$this->kepala_ruangan->LinkCustomAttributes = "";
		$this->kepala_ruangan->HrefValue = "";
		$this->kepala_ruangan->TooltipValue = "";

		// nip_kepala_ruangan
		$this->nip_kepala_ruangan->LinkCustomAttributes = "";
		$this->nip_kepala_ruangan->HrefValue = "";
		$this->nip_kepala_ruangan->TooltipValue = "";

		// group_id
		$this->group_id->LinkCustomAttributes = "";
		$this->group_id->HrefValue = "";
		$this->group_id->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// no
		$this->no->EditAttrs["class"] = "form-control";
		$this->no->EditCustomAttributes = "";
		$this->no->EditValue = $this->no->CurrentValue;
		$this->no->ViewCustomAttributes = "";

		// nama
		$this->nama->EditAttrs["class"] = "form-control";
		$this->nama->EditCustomAttributes = "";
		$this->nama->EditValue = $this->nama->CurrentValue;
		$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

		// kelas
		$this->kelas->EditAttrs["class"] = "form-control";
		$this->kelas->EditCustomAttributes = "";
		$this->kelas->EditValue = $this->kelas->CurrentValue;
		$this->kelas->PlaceHolder = ew_RemoveHtml($this->kelas->FldCaption());

		// ruang
		$this->ruang->EditAttrs["class"] = "form-control";
		$this->ruang->EditCustomAttributes = "";
		$this->ruang->EditValue = $this->ruang->CurrentValue;
		$this->ruang->PlaceHolder = ew_RemoveHtml($this->ruang->FldCaption());

		// jumlah_tt
		$this->jumlah_tt->EditAttrs["class"] = "form-control";
		$this->jumlah_tt->EditCustomAttributes = "";
		$this->jumlah_tt->EditValue = $this->jumlah_tt->CurrentValue;
		$this->jumlah_tt->PlaceHolder = ew_RemoveHtml($this->jumlah_tt->FldCaption());

		// ket_ruang
		$this->ket_ruang->EditAttrs["class"] = "form-control";
		$this->ket_ruang->EditCustomAttributes = "";
		$this->ket_ruang->EditValue = $this->ket_ruang->CurrentValue;
		$this->ket_ruang->PlaceHolder = ew_RemoveHtml($this->ket_ruang->FldCaption());

		// fasilitas
		$this->fasilitas->EditAttrs["class"] = "form-control";
		$this->fasilitas->EditCustomAttributes = "";
		$this->fasilitas->EditValue = $this->fasilitas->CurrentValue;
		$this->fasilitas->PlaceHolder = ew_RemoveHtml($this->fasilitas->FldCaption());

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// kepala_ruangan
		$this->kepala_ruangan->EditAttrs["class"] = "form-control";
		$this->kepala_ruangan->EditCustomAttributes = "";
		$this->kepala_ruangan->EditValue = $this->kepala_ruangan->CurrentValue;
		$this->kepala_ruangan->PlaceHolder = ew_RemoveHtml($this->kepala_ruangan->FldCaption());

		// nip_kepala_ruangan
		$this->nip_kepala_ruangan->EditAttrs["class"] = "form-control";
		$this->nip_kepala_ruangan->EditCustomAttributes = "";
		$this->nip_kepala_ruangan->EditValue = $this->nip_kepala_ruangan->CurrentValue;
		$this->nip_kepala_ruangan->PlaceHolder = ew_RemoveHtml($this->nip_kepala_ruangan->FldCaption());

		// group_id
		$this->group_id->EditAttrs["class"] = "form-control";
		$this->group_id->EditCustomAttributes = "";
		$this->group_id->EditValue = $this->group_id->CurrentValue;
		$this->group_id->PlaceHolder = ew_RemoveHtml($this->group_id->FldCaption());

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
					if ($this->no->Exportable) $Doc->ExportCaption($this->no);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->kelas->Exportable) $Doc->ExportCaption($this->kelas);
					if ($this->ruang->Exportable) $Doc->ExportCaption($this->ruang);
					if ($this->jumlah_tt->Exportable) $Doc->ExportCaption($this->jumlah_tt);
					if ($this->ket_ruang->Exportable) $Doc->ExportCaption($this->ket_ruang);
					if ($this->fasilitas->Exportable) $Doc->ExportCaption($this->fasilitas);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->kepala_ruangan->Exportable) $Doc->ExportCaption($this->kepala_ruangan);
					if ($this->nip_kepala_ruangan->Exportable) $Doc->ExportCaption($this->nip_kepala_ruangan);
					if ($this->group_id->Exportable) $Doc->ExportCaption($this->group_id);
				} else {
					if ($this->no->Exportable) $Doc->ExportCaption($this->no);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->kelas->Exportable) $Doc->ExportCaption($this->kelas);
					if ($this->ruang->Exportable) $Doc->ExportCaption($this->ruang);
					if ($this->jumlah_tt->Exportable) $Doc->ExportCaption($this->jumlah_tt);
					if ($this->ket_ruang->Exportable) $Doc->ExportCaption($this->ket_ruang);
					if ($this->kepala_ruangan->Exportable) $Doc->ExportCaption($this->kepala_ruangan);
					if ($this->nip_kepala_ruangan->Exportable) $Doc->ExportCaption($this->nip_kepala_ruangan);
					if ($this->group_id->Exportable) $Doc->ExportCaption($this->group_id);
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
						if ($this->no->Exportable) $Doc->ExportField($this->no);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->kelas->Exportable) $Doc->ExportField($this->kelas);
						if ($this->ruang->Exportable) $Doc->ExportField($this->ruang);
						if ($this->jumlah_tt->Exportable) $Doc->ExportField($this->jumlah_tt);
						if ($this->ket_ruang->Exportable) $Doc->ExportField($this->ket_ruang);
						if ($this->fasilitas->Exportable) $Doc->ExportField($this->fasilitas);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->kepala_ruangan->Exportable) $Doc->ExportField($this->kepala_ruangan);
						if ($this->nip_kepala_ruangan->Exportable) $Doc->ExportField($this->nip_kepala_ruangan);
						if ($this->group_id->Exportable) $Doc->ExportField($this->group_id);
					} else {
						if ($this->no->Exportable) $Doc->ExportField($this->no);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->kelas->Exportable) $Doc->ExportField($this->kelas);
						if ($this->ruang->Exportable) $Doc->ExportField($this->ruang);
						if ($this->jumlah_tt->Exportable) $Doc->ExportField($this->jumlah_tt);
						if ($this->ket_ruang->Exportable) $Doc->ExportField($this->ket_ruang);
						if ($this->kepala_ruangan->Exportable) $Doc->ExportField($this->kepala_ruangan);
						if ($this->nip_kepala_ruangan->Exportable) $Doc->ExportField($this->nip_kepala_ruangan);
						if ($this->group_id->Exportable) $Doc->ExportField($this->group_id);
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
