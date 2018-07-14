<?php

// Global variable for table object
$t_spd = NULL;

//
// Table class for t_spd
//
class ct_spd extends cTable {
	var $id;
	var $jenis_peraturan;
	var $tanggal;
	var $no_spd;
	var $jumlah_spd;
	var $pembayaran;
	var $no_sk_dir;
	var $tgl_sk_dir;
	var $th_anggaran;
	var $tentang;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_spd';
		$this->TableName = 't_spd';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_spd`";
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
		$this->id = new cField('t_spd', 't_spd', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// jenis_peraturan
		$this->jenis_peraturan = new cField('t_spd', 't_spd', 'x_jenis_peraturan', 'jenis_peraturan', '`jenis_peraturan`', '`jenis_peraturan`', 3, -1, FALSE, '`jenis_peraturan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->jenis_peraturan->Sortable = TRUE; // Allow sort
		$this->jenis_peraturan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->jenis_peraturan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->jenis_peraturan->OptionCount = 5;
		$this->jenis_peraturan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jenis_peraturan'] = &$this->jenis_peraturan;

		// tanggal
		$this->tanggal = new cField('t_spd', 't_spd', 'x_tanggal', 'tanggal', '`tanggal`', ew_CastDateFieldForLike('`tanggal`', 7, "DB"), 135, 7, FALSE, '`tanggal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal->Sortable = TRUE; // Allow sort
		$this->tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tanggal'] = &$this->tanggal;

		// no_spd
		$this->no_spd = new cField('t_spd', 't_spd', 'x_no_spd', 'no_spd', '`no_spd`', '`no_spd`', 200, -1, FALSE, '`no_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spd->Sortable = TRUE; // Allow sort
		$this->fields['no_spd'] = &$this->no_spd;

		// jumlah_spd
		$this->jumlah_spd = new cField('t_spd', 't_spd', 'x_jumlah_spd', 'jumlah_spd', '`jumlah_spd`', '`jumlah_spd`', 5, -1, FALSE, '`jumlah_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_spd->Sortable = TRUE; // Allow sort
		$this->jumlah_spd->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_spd'] = &$this->jumlah_spd;

		// pembayaran
		$this->pembayaran = new cField('t_spd', 't_spd', 'x_pembayaran', 'pembayaran', '`pembayaran`', '`pembayaran`', 200, -1, FALSE, '`pembayaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pembayaran->Sortable = TRUE; // Allow sort
		$this->fields['pembayaran'] = &$this->pembayaran;

		// no_sk_dir
		$this->no_sk_dir = new cField('t_spd', 't_spd', 'x_no_sk_dir', 'no_sk_dir', '`no_sk_dir`', '`no_sk_dir`', 200, -1, FALSE, '`no_sk_dir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_sk_dir->Sortable = TRUE; // Allow sort
		$this->fields['no_sk_dir'] = &$this->no_sk_dir;

		// tgl_sk_dir
		$this->tgl_sk_dir = new cField('t_spd', 't_spd', 'x_tgl_sk_dir', 'tgl_sk_dir', '`tgl_sk_dir`', ew_CastDateFieldForLike('`tgl_sk_dir`', 7, "DB"), 135, 7, FALSE, '`tgl_sk_dir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_sk_dir->Sortable = TRUE; // Allow sort
		$this->tgl_sk_dir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_sk_dir'] = &$this->tgl_sk_dir;

		// th_anggaran
		$this->th_anggaran = new cField('t_spd', 't_spd', 'x_th_anggaran', 'th_anggaran', '`th_anggaran`', '`th_anggaran`', 3, -1, FALSE, '`th_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->th_anggaran->Sortable = TRUE; // Allow sort
		$this->th_anggaran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['th_anggaran'] = &$this->th_anggaran;

		// tentang
		$this->tentang = new cField('t_spd', 't_spd', 'x_tentang', 'tentang', '`tentang`', '`tentang`', 201, -1, FALSE, '`tentang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->tentang->Sortable = TRUE; // Allow sort
		$this->fields['tentang'] = &$this->tentang;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_spd`";
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
			return "t_spdlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_spdlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_spdview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_spdview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_spdadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_spdadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_spdedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_spdadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_spddelete.php", $this->UrlParm());
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
		$this->jenis_peraturan->setDbValue($rs->fields('jenis_peraturan'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->no_spd->setDbValue($rs->fields('no_spd'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->pembayaran->setDbValue($rs->fields('pembayaran'));
		$this->no_sk_dir->setDbValue($rs->fields('no_sk_dir'));
		$this->tgl_sk_dir->setDbValue($rs->fields('tgl_sk_dir'));
		$this->th_anggaran->setDbValue($rs->fields('th_anggaran'));
		$this->tentang->setDbValue($rs->fields('tentang'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// jenis_peraturan
		// tanggal
		// no_spd
		// jumlah_spd
		// pembayaran
		// no_sk_dir
		// tgl_sk_dir
		// th_anggaran
		// tentang
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// jenis_peraturan
		if (strval($this->jenis_peraturan->CurrentValue) <> "") {
			$this->jenis_peraturan->ViewValue = $this->jenis_peraturan->OptionCaption($this->jenis_peraturan->CurrentValue);
		} else {
			$this->jenis_peraturan->ViewValue = NULL;
		}
		$this->jenis_peraturan->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->ViewCustomAttributes = "";

		// no_spd
		$this->no_spd->ViewValue = $this->no_spd->CurrentValue;
		$this->no_spd->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

		// pembayaran
		$this->pembayaran->ViewValue = $this->pembayaran->CurrentValue;
		$this->pembayaran->ViewCustomAttributes = "";

		// no_sk_dir
		$this->no_sk_dir->ViewValue = $this->no_sk_dir->CurrentValue;
		$this->no_sk_dir->ViewCustomAttributes = "";

		// tgl_sk_dir
		$this->tgl_sk_dir->ViewValue = $this->tgl_sk_dir->CurrentValue;
		$this->tgl_sk_dir->ViewValue = ew_FormatDateTime($this->tgl_sk_dir->ViewValue, 7);
		$this->tgl_sk_dir->ViewCustomAttributes = "";

		// th_anggaran
		$this->th_anggaran->ViewValue = $this->th_anggaran->CurrentValue;
		$this->th_anggaran->ViewCustomAttributes = "";

		// tentang
		$this->tentang->ViewValue = $this->tentang->CurrentValue;
		$this->tentang->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// jenis_peraturan
		$this->jenis_peraturan->LinkCustomAttributes = "";
		$this->jenis_peraturan->HrefValue = "";
		$this->jenis_peraturan->TooltipValue = "";

		// tanggal
		$this->tanggal->LinkCustomAttributes = "";
		$this->tanggal->HrefValue = "";
		$this->tanggal->TooltipValue = "";

		// no_spd
		$this->no_spd->LinkCustomAttributes = "";
		$this->no_spd->HrefValue = "";
		$this->no_spd->TooltipValue = "";

		// jumlah_spd
		$this->jumlah_spd->LinkCustomAttributes = "";
		$this->jumlah_spd->HrefValue = "";
		$this->jumlah_spd->TooltipValue = "";

		// pembayaran
		$this->pembayaran->LinkCustomAttributes = "";
		$this->pembayaran->HrefValue = "";
		$this->pembayaran->TooltipValue = "";

		// no_sk_dir
		$this->no_sk_dir->LinkCustomAttributes = "";
		$this->no_sk_dir->HrefValue = "";
		$this->no_sk_dir->TooltipValue = "";

		// tgl_sk_dir
		$this->tgl_sk_dir->LinkCustomAttributes = "";
		$this->tgl_sk_dir->HrefValue = "";
		$this->tgl_sk_dir->TooltipValue = "";

		// th_anggaran
		$this->th_anggaran->LinkCustomAttributes = "";
		$this->th_anggaran->HrefValue = "";
		$this->th_anggaran->TooltipValue = "";

		// tentang
		$this->tentang->LinkCustomAttributes = "";
		$this->tentang->HrefValue = "";
		$this->tentang->TooltipValue = "";

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

		// jenis_peraturan
		$this->jenis_peraturan->EditAttrs["class"] = "form-control";
		$this->jenis_peraturan->EditCustomAttributes = "";
		$this->jenis_peraturan->EditValue = $this->jenis_peraturan->Options(TRUE);

		// tanggal
		$this->tanggal->EditAttrs["class"] = "form-control";
		$this->tanggal->EditCustomAttributes = "";
		$this->tanggal->EditValue = ew_FormatDateTime($this->tanggal->CurrentValue, 7);
		$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

		// no_spd
		$this->no_spd->EditAttrs["class"] = "form-control";
		$this->no_spd->EditCustomAttributes = "";
		$this->no_spd->EditValue = $this->no_spd->CurrentValue;
		$this->no_spd->PlaceHolder = ew_RemoveHtml($this->no_spd->FldCaption());

		// jumlah_spd
		$this->jumlah_spd->EditAttrs["class"] = "form-control";
		$this->jumlah_spd->EditCustomAttributes = "";
		$this->jumlah_spd->EditValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->PlaceHolder = ew_RemoveHtml($this->jumlah_spd->FldCaption());
		if (strval($this->jumlah_spd->EditValue) <> "" && is_numeric($this->jumlah_spd->EditValue)) $this->jumlah_spd->EditValue = ew_FormatNumber($this->jumlah_spd->EditValue, -2, -1, -2, 0);

		// pembayaran
		$this->pembayaran->EditAttrs["class"] = "form-control";
		$this->pembayaran->EditCustomAttributes = "";
		$this->pembayaran->EditValue = $this->pembayaran->CurrentValue;
		$this->pembayaran->PlaceHolder = ew_RemoveHtml($this->pembayaran->FldCaption());

		// no_sk_dir
		$this->no_sk_dir->EditAttrs["class"] = "form-control";
		$this->no_sk_dir->EditCustomAttributes = "";
		$this->no_sk_dir->EditValue = $this->no_sk_dir->CurrentValue;
		$this->no_sk_dir->PlaceHolder = ew_RemoveHtml($this->no_sk_dir->FldCaption());

		// tgl_sk_dir
		$this->tgl_sk_dir->EditAttrs["class"] = "form-control";
		$this->tgl_sk_dir->EditCustomAttributes = "";
		$this->tgl_sk_dir->EditValue = ew_FormatDateTime($this->tgl_sk_dir->CurrentValue, 7);
		$this->tgl_sk_dir->PlaceHolder = ew_RemoveHtml($this->tgl_sk_dir->FldCaption());

		// th_anggaran
		$this->th_anggaran->EditAttrs["class"] = "form-control";
		$this->th_anggaran->EditCustomAttributes = "";
		$this->th_anggaran->EditValue = $this->th_anggaran->CurrentValue;
		$this->th_anggaran->PlaceHolder = ew_RemoveHtml($this->th_anggaran->FldCaption());

		// tentang
		$this->tentang->EditAttrs["class"] = "form-control";
		$this->tentang->EditCustomAttributes = "";
		$this->tentang->EditValue = $this->tentang->CurrentValue;
		$this->tentang->PlaceHolder = ew_RemoveHtml($this->tentang->FldCaption());

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
					if ($this->jenis_peraturan->Exportable) $Doc->ExportCaption($this->jenis_peraturan);
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->no_spd->Exportable) $Doc->ExportCaption($this->no_spd);
					if ($this->jumlah_spd->Exportable) $Doc->ExportCaption($this->jumlah_spd);
					if ($this->pembayaran->Exportable) $Doc->ExportCaption($this->pembayaran);
					if ($this->no_sk_dir->Exportable) $Doc->ExportCaption($this->no_sk_dir);
					if ($this->tgl_sk_dir->Exportable) $Doc->ExportCaption($this->tgl_sk_dir);
					if ($this->th_anggaran->Exportable) $Doc->ExportCaption($this->th_anggaran);
					if ($this->tentang->Exportable) $Doc->ExportCaption($this->tentang);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->jenis_peraturan->Exportable) $Doc->ExportCaption($this->jenis_peraturan);
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->no_spd->Exportable) $Doc->ExportCaption($this->no_spd);
					if ($this->jumlah_spd->Exportable) $Doc->ExportCaption($this->jumlah_spd);
					if ($this->pembayaran->Exportable) $Doc->ExportCaption($this->pembayaran);
					if ($this->no_sk_dir->Exportable) $Doc->ExportCaption($this->no_sk_dir);
					if ($this->tgl_sk_dir->Exportable) $Doc->ExportCaption($this->tgl_sk_dir);
					if ($this->th_anggaran->Exportable) $Doc->ExportCaption($this->th_anggaran);
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
						if ($this->jenis_peraturan->Exportable) $Doc->ExportField($this->jenis_peraturan);
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->no_spd->Exportable) $Doc->ExportField($this->no_spd);
						if ($this->jumlah_spd->Exportable) $Doc->ExportField($this->jumlah_spd);
						if ($this->pembayaran->Exportable) $Doc->ExportField($this->pembayaran);
						if ($this->no_sk_dir->Exportable) $Doc->ExportField($this->no_sk_dir);
						if ($this->tgl_sk_dir->Exportable) $Doc->ExportField($this->tgl_sk_dir);
						if ($this->th_anggaran->Exportable) $Doc->ExportField($this->th_anggaran);
						if ($this->tentang->Exportable) $Doc->ExportField($this->tentang);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->jenis_peraturan->Exportable) $Doc->ExportField($this->jenis_peraturan);
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->no_spd->Exportable) $Doc->ExportField($this->no_spd);
						if ($this->jumlah_spd->Exportable) $Doc->ExportField($this->jumlah_spd);
						if ($this->pembayaran->Exportable) $Doc->ExportField($this->pembayaran);
						if ($this->no_sk_dir->Exportable) $Doc->ExportField($this->no_sk_dir);
						if ($this->tgl_sk_dir->Exportable) $Doc->ExportField($this->tgl_sk_dir);
						if ($this->th_anggaran->Exportable) $Doc->ExportField($this->th_anggaran);
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
