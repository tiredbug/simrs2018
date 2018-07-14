<?php

// Global variable for table object
$tbantrianpoli = NULL;

//
// Table class for tbantrianpoli
//
class ctbantrianpoli extends cTable {
	var $NO;
	var $Klinik;
	var $DOKTER;
	var $No_Pasien;
	var $Nama;
	var $Alamat;
	var $Tanggal;
	var $Masuk;
	var $Lewati;
	var $RMOK;
	var $CETAK;
	var $NOANTRI;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tbantrianpoli';
		$this->TableName = 'tbantrianpoli';
		$this->TableType = 'LINKTABLE';

		// Update Table
		$this->UpdateTable = "`tbantrianpoli`";
		$this->DBID = 'dbantrianSis';
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

		// NO
		$this->NO = new cField('tbantrianpoli', 'tbantrianpoli', 'x_NO', 'NO', '`NO`', '`NO`', 200, -1, FALSE, '`NO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO->Sortable = TRUE; // Allow sort
		$this->fields['NO'] = &$this->NO;

		// Klinik
		$this->Klinik = new cField('tbantrianpoli', 'tbantrianpoli', 'x_Klinik', 'Klinik', '`Klinik`', '`Klinik`', 200, -1, FALSE, '`Klinik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Klinik->Sortable = TRUE; // Allow sort
		$this->fields['Klinik'] = &$this->Klinik;

		// DOKTER
		$this->DOKTER = new cField('tbantrianpoli', 'tbantrianpoli', 'x_DOKTER', 'DOKTER', '`DOKTER`', '`DOKTER`', 200, -1, FALSE, '`DOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DOKTER->Sortable = TRUE; // Allow sort
		$this->fields['DOKTER'] = &$this->DOKTER;

		// No_Pasien
		$this->No_Pasien = new cField('tbantrianpoli', 'tbantrianpoli', 'x_No_Pasien', 'No_Pasien', '`No_Pasien`', '`No_Pasien`', 200, -1, FALSE, '`No_Pasien`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->No_Pasien->Sortable = TRUE; // Allow sort
		$this->fields['No_Pasien'] = &$this->No_Pasien;

		// Nama
		$this->Nama = new cField('tbantrianpoli', 'tbantrianpoli', 'x_Nama', 'Nama', '`Nama`', '`Nama`', 200, -1, FALSE, '`Nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nama->Sortable = TRUE; // Allow sort
		$this->fields['Nama'] = &$this->Nama;

		// Alamat
		$this->Alamat = new cField('tbantrianpoli', 'tbantrianpoli', 'x_Alamat', 'Alamat', '`Alamat`', '`Alamat`', 200, -1, FALSE, '`Alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Alamat->Sortable = TRUE; // Allow sort
		$this->fields['Alamat'] = &$this->Alamat;

		// Tanggal
		$this->Tanggal = new cField('tbantrianpoli', 'tbantrianpoli', 'x_Tanggal', 'Tanggal', '`Tanggal`', ew_CastDateFieldForLike('`Tanggal`', 0, "dbantrianSis"), 135, 0, FALSE, '`Tanggal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Tanggal->Sortable = TRUE; // Allow sort
		$this->Tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['Tanggal'] = &$this->Tanggal;

		// Masuk
		$this->Masuk = new cField('tbantrianpoli', 'tbantrianpoli', 'x_Masuk', 'Masuk', '`Masuk`', '`Masuk`', 200, -1, FALSE, '`Masuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Masuk->Sortable = TRUE; // Allow sort
		$this->fields['Masuk'] = &$this->Masuk;

		// Lewati
		$this->Lewati = new cField('tbantrianpoli', 'tbantrianpoli', 'x_Lewati', 'Lewati', '`Lewati`', '`Lewati`', 200, -1, FALSE, '`Lewati`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Lewati->Sortable = TRUE; // Allow sort
		$this->fields['Lewati'] = &$this->Lewati;

		// RMOK
		$this->RMOK = new cField('tbantrianpoli', 'tbantrianpoli', 'x_RMOK', 'RMOK', '`RMOK`', '`RMOK`', 200, -1, FALSE, '`RMOK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RMOK->Sortable = TRUE; // Allow sort
		$this->fields['RMOK'] = &$this->RMOK;

		// CETAK
		$this->CETAK = new cField('tbantrianpoli', 'tbantrianpoli', 'x_CETAK', 'CETAK', '`CETAK`', '`CETAK`', 200, -1, FALSE, '`CETAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CETAK->Sortable = TRUE; // Allow sort
		$this->fields['CETAK'] = &$this->CETAK;

		// NOANTRI
		$this->NOANTRI = new cField('tbantrianpoli', 'tbantrianpoli', 'x_NOANTRI', 'NOANTRI', '`NOANTRI`', '`NOANTRI`', 200, -1, FALSE, '`NOANTRI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOANTRI->Sortable = TRUE; // Allow sort
		$this->fields['NOANTRI'] = &$this->NOANTRI;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tbantrianpoli`";
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "tbantrianpolilist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "tbantrianpolilist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tbantrianpoliview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tbantrianpoliview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tbantrianpoliadd.php?" . $this->UrlParm($parm);
		else
			$url = "tbantrianpoliadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tbantrianpoliedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tbantrianpoliadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tbantrianpolidelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
		$this->NO->setDbValue($rs->fields('NO'));
		$this->Klinik->setDbValue($rs->fields('Klinik'));
		$this->DOKTER->setDbValue($rs->fields('DOKTER'));
		$this->No_Pasien->setDbValue($rs->fields('No_Pasien'));
		$this->Nama->setDbValue($rs->fields('Nama'));
		$this->Alamat->setDbValue($rs->fields('Alamat'));
		$this->Tanggal->setDbValue($rs->fields('Tanggal'));
		$this->Masuk->setDbValue($rs->fields('Masuk'));
		$this->Lewati->setDbValue($rs->fields('Lewati'));
		$this->RMOK->setDbValue($rs->fields('RMOK'));
		$this->CETAK->setDbValue($rs->fields('CETAK'));
		$this->NOANTRI->setDbValue($rs->fields('NOANTRI'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// NO
		// Klinik
		// DOKTER
		// No_Pasien
		// Nama
		// Alamat
		// Tanggal
		// Masuk
		// Lewati
		// RMOK
		// CETAK
		// NOANTRI
		// NO

		$this->NO->ViewValue = $this->NO->CurrentValue;
		$this->NO->ViewCustomAttributes = "";

		// Klinik
		$this->Klinik->ViewValue = $this->Klinik->CurrentValue;
		$this->Klinik->ViewCustomAttributes = "";

		// DOKTER
		$this->DOKTER->ViewValue = $this->DOKTER->CurrentValue;
		$this->DOKTER->ViewCustomAttributes = "";

		// No_Pasien
		$this->No_Pasien->ViewValue = $this->No_Pasien->CurrentValue;
		$this->No_Pasien->ViewCustomAttributes = "";

		// Nama
		$this->Nama->ViewValue = $this->Nama->CurrentValue;
		$this->Nama->ViewCustomAttributes = "";

		// Alamat
		$this->Alamat->ViewValue = $this->Alamat->CurrentValue;
		$this->Alamat->ViewCustomAttributes = "";

		// Tanggal
		$this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
		$this->Tanggal->ViewValue = ew_FormatDateTime($this->Tanggal->ViewValue, 0);
		$this->Tanggal->ViewCustomAttributes = "";

		// Masuk
		$this->Masuk->ViewValue = $this->Masuk->CurrentValue;
		$this->Masuk->ViewCustomAttributes = "";

		// Lewati
		$this->Lewati->ViewValue = $this->Lewati->CurrentValue;
		$this->Lewati->ViewCustomAttributes = "";

		// RMOK
		$this->RMOK->ViewValue = $this->RMOK->CurrentValue;
		$this->RMOK->ViewCustomAttributes = "";

		// CETAK
		$this->CETAK->ViewValue = $this->CETAK->CurrentValue;
		$this->CETAK->ViewCustomAttributes = "";

		// NOANTRI
		$this->NOANTRI->ViewValue = $this->NOANTRI->CurrentValue;
		$this->NOANTRI->ViewCustomAttributes = "";

		// NO
		$this->NO->LinkCustomAttributes = "";
		$this->NO->HrefValue = "";
		$this->NO->TooltipValue = "";

		// Klinik
		$this->Klinik->LinkCustomAttributes = "";
		$this->Klinik->HrefValue = "";
		$this->Klinik->TooltipValue = "";

		// DOKTER
		$this->DOKTER->LinkCustomAttributes = "";
		$this->DOKTER->HrefValue = "";
		$this->DOKTER->TooltipValue = "";

		// No_Pasien
		$this->No_Pasien->LinkCustomAttributes = "";
		$this->No_Pasien->HrefValue = "";
		$this->No_Pasien->TooltipValue = "";

		// Nama
		$this->Nama->LinkCustomAttributes = "";
		$this->Nama->HrefValue = "";
		$this->Nama->TooltipValue = "";

		// Alamat
		$this->Alamat->LinkCustomAttributes = "";
		$this->Alamat->HrefValue = "";
		$this->Alamat->TooltipValue = "";

		// Tanggal
		$this->Tanggal->LinkCustomAttributes = "";
		$this->Tanggal->HrefValue = "";
		$this->Tanggal->TooltipValue = "";

		// Masuk
		$this->Masuk->LinkCustomAttributes = "";
		$this->Masuk->HrefValue = "";
		$this->Masuk->TooltipValue = "";

		// Lewati
		$this->Lewati->LinkCustomAttributes = "";
		$this->Lewati->HrefValue = "";
		$this->Lewati->TooltipValue = "";

		// RMOK
		$this->RMOK->LinkCustomAttributes = "";
		$this->RMOK->HrefValue = "";
		$this->RMOK->TooltipValue = "";

		// CETAK
		$this->CETAK->LinkCustomAttributes = "";
		$this->CETAK->HrefValue = "";
		$this->CETAK->TooltipValue = "";

		// NOANTRI
		$this->NOANTRI->LinkCustomAttributes = "";
		$this->NOANTRI->HrefValue = "";
		$this->NOANTRI->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// NO
		$this->NO->EditAttrs["class"] = "form-control";
		$this->NO->EditCustomAttributes = "";
		$this->NO->EditValue = $this->NO->CurrentValue;
		$this->NO->PlaceHolder = ew_RemoveHtml($this->NO->FldCaption());

		// Klinik
		$this->Klinik->EditAttrs["class"] = "form-control";
		$this->Klinik->EditCustomAttributes = "";
		$this->Klinik->EditValue = $this->Klinik->CurrentValue;
		$this->Klinik->PlaceHolder = ew_RemoveHtml($this->Klinik->FldCaption());

		// DOKTER
		$this->DOKTER->EditAttrs["class"] = "form-control";
		$this->DOKTER->EditCustomAttributes = "";
		$this->DOKTER->EditValue = $this->DOKTER->CurrentValue;
		$this->DOKTER->PlaceHolder = ew_RemoveHtml($this->DOKTER->FldCaption());

		// No_Pasien
		$this->No_Pasien->EditAttrs["class"] = "form-control";
		$this->No_Pasien->EditCustomAttributes = "";
		$this->No_Pasien->EditValue = $this->No_Pasien->CurrentValue;
		$this->No_Pasien->PlaceHolder = ew_RemoveHtml($this->No_Pasien->FldCaption());

		// Nama
		$this->Nama->EditAttrs["class"] = "form-control";
		$this->Nama->EditCustomAttributes = "";
		$this->Nama->EditValue = $this->Nama->CurrentValue;
		$this->Nama->PlaceHolder = ew_RemoveHtml($this->Nama->FldCaption());

		// Alamat
		$this->Alamat->EditAttrs["class"] = "form-control";
		$this->Alamat->EditCustomAttributes = "";
		$this->Alamat->EditValue = $this->Alamat->CurrentValue;
		$this->Alamat->PlaceHolder = ew_RemoveHtml($this->Alamat->FldCaption());

		// Tanggal
		$this->Tanggal->EditAttrs["class"] = "form-control";
		$this->Tanggal->EditCustomAttributes = "";
		$this->Tanggal->EditValue = ew_FormatDateTime($this->Tanggal->CurrentValue, 8);
		$this->Tanggal->PlaceHolder = ew_RemoveHtml($this->Tanggal->FldCaption());

		// Masuk
		$this->Masuk->EditAttrs["class"] = "form-control";
		$this->Masuk->EditCustomAttributes = "";
		$this->Masuk->EditValue = $this->Masuk->CurrentValue;
		$this->Masuk->PlaceHolder = ew_RemoveHtml($this->Masuk->FldCaption());

		// Lewati
		$this->Lewati->EditAttrs["class"] = "form-control";
		$this->Lewati->EditCustomAttributes = "";
		$this->Lewati->EditValue = $this->Lewati->CurrentValue;
		$this->Lewati->PlaceHolder = ew_RemoveHtml($this->Lewati->FldCaption());

		// RMOK
		$this->RMOK->EditAttrs["class"] = "form-control";
		$this->RMOK->EditCustomAttributes = "";
		$this->RMOK->EditValue = $this->RMOK->CurrentValue;
		$this->RMOK->PlaceHolder = ew_RemoveHtml($this->RMOK->FldCaption());

		// CETAK
		$this->CETAK->EditAttrs["class"] = "form-control";
		$this->CETAK->EditCustomAttributes = "";
		$this->CETAK->EditValue = $this->CETAK->CurrentValue;
		$this->CETAK->PlaceHolder = ew_RemoveHtml($this->CETAK->FldCaption());

		// NOANTRI
		$this->NOANTRI->EditAttrs["class"] = "form-control";
		$this->NOANTRI->EditCustomAttributes = "";
		$this->NOANTRI->EditValue = $this->NOANTRI->CurrentValue;
		$this->NOANTRI->PlaceHolder = ew_RemoveHtml($this->NOANTRI->FldCaption());

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
					if ($this->NO->Exportable) $Doc->ExportCaption($this->NO);
					if ($this->Klinik->Exportable) $Doc->ExportCaption($this->Klinik);
					if ($this->DOKTER->Exportable) $Doc->ExportCaption($this->DOKTER);
					if ($this->No_Pasien->Exportable) $Doc->ExportCaption($this->No_Pasien);
					if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
					if ($this->Alamat->Exportable) $Doc->ExportCaption($this->Alamat);
					if ($this->Tanggal->Exportable) $Doc->ExportCaption($this->Tanggal);
					if ($this->Masuk->Exportable) $Doc->ExportCaption($this->Masuk);
					if ($this->Lewati->Exportable) $Doc->ExportCaption($this->Lewati);
					if ($this->RMOK->Exportable) $Doc->ExportCaption($this->RMOK);
					if ($this->CETAK->Exportable) $Doc->ExportCaption($this->CETAK);
					if ($this->NOANTRI->Exportable) $Doc->ExportCaption($this->NOANTRI);
				} else {
					if ($this->NO->Exportable) $Doc->ExportCaption($this->NO);
					if ($this->Klinik->Exportable) $Doc->ExportCaption($this->Klinik);
					if ($this->DOKTER->Exportable) $Doc->ExportCaption($this->DOKTER);
					if ($this->No_Pasien->Exportable) $Doc->ExportCaption($this->No_Pasien);
					if ($this->Nama->Exportable) $Doc->ExportCaption($this->Nama);
					if ($this->Alamat->Exportable) $Doc->ExportCaption($this->Alamat);
					if ($this->Tanggal->Exportable) $Doc->ExportCaption($this->Tanggal);
					if ($this->Masuk->Exportable) $Doc->ExportCaption($this->Masuk);
					if ($this->Lewati->Exportable) $Doc->ExportCaption($this->Lewati);
					if ($this->RMOK->Exportable) $Doc->ExportCaption($this->RMOK);
					if ($this->CETAK->Exportable) $Doc->ExportCaption($this->CETAK);
					if ($this->NOANTRI->Exportable) $Doc->ExportCaption($this->NOANTRI);
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
						if ($this->NO->Exportable) $Doc->ExportField($this->NO);
						if ($this->Klinik->Exportable) $Doc->ExportField($this->Klinik);
						if ($this->DOKTER->Exportable) $Doc->ExportField($this->DOKTER);
						if ($this->No_Pasien->Exportable) $Doc->ExportField($this->No_Pasien);
						if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
						if ($this->Alamat->Exportable) $Doc->ExportField($this->Alamat);
						if ($this->Tanggal->Exportable) $Doc->ExportField($this->Tanggal);
						if ($this->Masuk->Exportable) $Doc->ExportField($this->Masuk);
						if ($this->Lewati->Exportable) $Doc->ExportField($this->Lewati);
						if ($this->RMOK->Exportable) $Doc->ExportField($this->RMOK);
						if ($this->CETAK->Exportable) $Doc->ExportField($this->CETAK);
						if ($this->NOANTRI->Exportable) $Doc->ExportField($this->NOANTRI);
					} else {
						if ($this->NO->Exportable) $Doc->ExportField($this->NO);
						if ($this->Klinik->Exportable) $Doc->ExportField($this->Klinik);
						if ($this->DOKTER->Exportable) $Doc->ExportField($this->DOKTER);
						if ($this->No_Pasien->Exportable) $Doc->ExportField($this->No_Pasien);
						if ($this->Nama->Exportable) $Doc->ExportField($this->Nama);
						if ($this->Alamat->Exportable) $Doc->ExportField($this->Alamat);
						if ($this->Tanggal->Exportable) $Doc->ExportField($this->Tanggal);
						if ($this->Masuk->Exportable) $Doc->ExportField($this->Masuk);
						if ($this->Lewati->Exportable) $Doc->ExportField($this->Lewati);
						if ($this->RMOK->Exportable) $Doc->ExportField($this->RMOK);
						if ($this->CETAK->Exportable) $Doc->ExportField($this->CETAK);
						if ($this->NOANTRI->Exportable) $Doc->ExportField($this->NOANTRI);
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
		ew_AddFilter($filter, "DATE_FORMAT(Tanggal, '%Y-%m-%d') = curdate()"); 
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
