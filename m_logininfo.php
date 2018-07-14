<?php

// Global variable for table object
$m_login = NULL;

//
// Table class for m_login
//
class cm_login extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $NIP;
	var $PWD;
	var $SES_REG;
	var $ROLES;
	var $KDUNIT;
	var $DEPARTEMEN;
	var $nama;
	var $gambar;
	var $NIK;
	var $grup_ranap;
	var $pd_nickname;
	var $role_id;
	var $pd_avatar;
	var $pd_datejoined;
	var $pd_parentid;
	var $pd_email;
	var $pd_activated;
	var $pd_profiletext;
	var $pd_title;
	var $pd_ipaddr;
	var $pd_useragent;
	var $pd_online;
	var $id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'm_login';
		$this->TableName = 'm_login';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`m_login`";
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

		// NIP
		$this->NIP = new cField('m_login', 'm_login', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = TRUE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// PWD
		$this->PWD = new cField('m_login', 'm_login', 'x_PWD', 'PWD', '`PWD`', '`PWD`', 200, -1, FALSE, '`PWD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PWD->Sortable = TRUE; // Allow sort
		$this->fields['PWD'] = &$this->PWD;

		// SES_REG
		$this->SES_REG = new cField('m_login', 'm_login', 'x_SES_REG', 'SES_REG', '`SES_REG`', '`SES_REG`', 200, -1, FALSE, '`SES_REG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SES_REG->Sortable = TRUE; // Allow sort
		$this->fields['SES_REG'] = &$this->SES_REG;

		// ROLES
		$this->ROLES = new cField('m_login', 'm_login', 'x_ROLES', 'ROLES', '`ROLES`', '`ROLES`', 3, -1, FALSE, '`ROLES`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ROLES->Sortable = TRUE; // Allow sort
		$this->ROLES->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ROLES'] = &$this->ROLES;

		// KDUNIT
		$this->KDUNIT = new cField('m_login', 'm_login', 'x_KDUNIT', 'KDUNIT', '`KDUNIT`', '`KDUNIT`', 3, -1, FALSE, '`KDUNIT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDUNIT->Sortable = TRUE; // Allow sort
		$this->KDUNIT->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDUNIT'] = &$this->KDUNIT;

		// DEPARTEMEN
		$this->DEPARTEMEN = new cField('m_login', 'm_login', 'x_DEPARTEMEN', 'DEPARTEMEN', '`DEPARTEMEN`', '`DEPARTEMEN`', 200, -1, FALSE, '`DEPARTEMEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DEPARTEMEN->Sortable = TRUE; // Allow sort
		$this->fields['DEPARTEMEN'] = &$this->DEPARTEMEN;

		// nama
		$this->nama = new cField('m_login', 'm_login', 'x_nama', 'nama', '`nama`', '`nama`', 200, -1, FALSE, '`nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama->Sortable = TRUE; // Allow sort
		$this->fields['nama'] = &$this->nama;

		// gambar
		$this->gambar = new cField('m_login', 'm_login', 'x_gambar', 'gambar', '`gambar`', '`gambar`', 200, -1, FALSE, '`gambar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gambar->Sortable = TRUE; // Allow sort
		$this->fields['gambar'] = &$this->gambar;

		// NIK
		$this->NIK = new cField('m_login', 'm_login', 'x_NIK', 'NIK', '`NIK`', '`NIK`', 200, -1, FALSE, '`NIK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIK->Sortable = TRUE; // Allow sort
		$this->fields['NIK'] = &$this->NIK;

		// grup_ranap
		$this->grup_ranap = new cField('m_login', 'm_login', 'x_grup_ranap', 'grup_ranap', '`grup_ranap`', '`grup_ranap`', 3, -1, FALSE, '`grup_ranap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grup_ranap->Sortable = TRUE; // Allow sort
		$this->grup_ranap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['grup_ranap'] = &$this->grup_ranap;

		// pd_nickname
		$this->pd_nickname = new cField('m_login', 'm_login', 'x_pd_nickname', 'pd_nickname', '`pd_nickname`', '`pd_nickname`', 200, -1, FALSE, '`pd_nickname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_nickname->Sortable = TRUE; // Allow sort
		$this->fields['pd_nickname'] = &$this->pd_nickname;

		// role_id
		$this->role_id = new cField('m_login', 'm_login', 'x_role_id', 'role_id', '`role_id`', '`role_id`', 3, -1, FALSE, '`role_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->role_id->Sortable = TRUE; // Allow sort
		$this->role_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->role_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->role_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['role_id'] = &$this->role_id;

		// pd_avatar
		$this->pd_avatar = new cField('m_login', 'm_login', 'x_pd_avatar', 'pd_avatar', '`pd_avatar`', '`pd_avatar`', 200, -1, TRUE, '`pd_avatar`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->pd_avatar->Sortable = TRUE; // Allow sort
		$this->pd_avatar->ImageResize = TRUE;
		$this->fields['pd_avatar'] = &$this->pd_avatar;

		// pd_datejoined
		$this->pd_datejoined = new cField('m_login', 'm_login', 'x_pd_datejoined', 'pd_datejoined', '`pd_datejoined`', ew_CastDateFieldForLike('`pd_datejoined`', 0, "DB"), 135, 0, FALSE, '`pd_datejoined`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_datejoined->Sortable = TRUE; // Allow sort
		$this->pd_datejoined->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['pd_datejoined'] = &$this->pd_datejoined;

		// pd_parentid
		$this->pd_parentid = new cField('m_login', 'm_login', 'x_pd_parentid', 'pd_parentid', '`pd_parentid`', '`pd_parentid`', 3, -1, FALSE, '`pd_parentid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_parentid->Sortable = TRUE; // Allow sort
		$this->pd_parentid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pd_parentid'] = &$this->pd_parentid;

		// pd_email
		$this->pd_email = new cField('m_login', 'm_login', 'x_pd_email', 'pd_email', '`pd_email`', '`pd_email`', 200, -1, FALSE, '`pd_email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_email->Sortable = TRUE; // Allow sort
		$this->fields['pd_email'] = &$this->pd_email;

		// pd_activated
		$this->pd_activated = new cField('m_login', 'm_login', 'x_pd_activated', 'pd_activated', '`pd_activated`', '`pd_activated`', 3, -1, FALSE, '`pd_activated`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_activated->Sortable = TRUE; // Allow sort
		$this->pd_activated->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pd_activated'] = &$this->pd_activated;

		// pd_profiletext
		$this->pd_profiletext = new cField('m_login', 'm_login', 'x_pd_profiletext', 'pd_profiletext', '`pd_profiletext`', '`pd_profiletext`', 201, -1, FALSE, '`pd_profiletext`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->pd_profiletext->Sortable = TRUE; // Allow sort
		$this->fields['pd_profiletext'] = &$this->pd_profiletext;

		// pd_title
		$this->pd_title = new cField('m_login', 'm_login', 'x_pd_title', 'pd_title', '`pd_title`', '`pd_title`', 200, -1, FALSE, '`pd_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_title->Sortable = TRUE; // Allow sort
		$this->fields['pd_title'] = &$this->pd_title;

		// pd_ipaddr
		$this->pd_ipaddr = new cField('m_login', 'm_login', 'x_pd_ipaddr', 'pd_ipaddr', '`pd_ipaddr`', '`pd_ipaddr`', 200, -1, FALSE, '`pd_ipaddr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_ipaddr->Sortable = TRUE; // Allow sort
		$this->fields['pd_ipaddr'] = &$this->pd_ipaddr;

		// pd_useragent
		$this->pd_useragent = new cField('m_login', 'm_login', 'x_pd_useragent', 'pd_useragent', '`pd_useragent`', '`pd_useragent`', 200, -1, FALSE, '`pd_useragent`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_useragent->Sortable = TRUE; // Allow sort
		$this->fields['pd_useragent'] = &$this->pd_useragent;

		// pd_online
		$this->pd_online = new cField('m_login', 'm_login', 'x_pd_online', 'pd_online', '`pd_online`', '`pd_online`', 3, -1, FALSE, '`pd_online`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pd_online->Sortable = TRUE; // Allow sort
		$this->pd_online->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pd_online'] = &$this->pd_online;

		// id
		$this->id = new cField('m_login', 'm_login', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`m_login`";
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
		global $Security;

		// Add User ID filter
		if ($Security->CurrentUserID() <> "" && !$Security->IsAdmin()) { // Non system admin
			$sFilter = $this->AddUserIDFilter($sFilter);
		}
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = $this->UserIDAllowSecurity;
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'PWD')
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
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
			if (EW_ENCRYPTED_PASSWORD && $name == 'PWD') {
				$value = (EW_CASE_SENSITIVE_PASSWORD) ? ew_EncryptPassword($value) : ew_EncryptPassword(strtolower($value));
			}
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
			$fldname = 'NIP';
			if (!array_key_exists($fldname, $rsaudit)) $rsaudit[$fldname] = $rsold[$fldname];
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
			if (array_key_exists('NIP', $rs))
				ew_AddFilter($where, ew_QuotedName('NIP', $this->DBID) . '=' . ew_QuotedValue($rs['NIP'], $this->NIP->FldDataType, $this->DBID));
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
		return "`NIP` = '@NIP@' AND `id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		$sKeyFilter = str_replace("@NIP@", ew_AdjustSql($this->NIP->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "m_loginlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "m_loginlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("m_loginview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("m_loginview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "m_loginadd.php?" . $this->UrlParm($parm);
		else
			$url = "m_loginadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("m_loginedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("m_loginadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("m_logindelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "NIP:" . ew_VarToJson($this->NIP->CurrentValue, "string", "'");
		$json .= ",id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->NIP->CurrentValue)) {
			$sUrl .= "NIP=" . urlencode($this->NIP->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "&id=" . urlencode($this->id->CurrentValue);
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
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["NIP"]))
				$arKey[] = ew_StripSlashes($_POST["NIP"]);
			elseif (isset($_GET["NIP"]))
				$arKey[] = ew_StripSlashes($_GET["NIP"]);
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["id"]))
				$arKey[] = ew_StripSlashes($_POST["id"]);
			elseif (isset($_GET["id"]))
				$arKey[] = ew_StripSlashes($_GET["id"]);
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 2)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[1])) // id
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
			$this->NIP->CurrentValue = $key[0];
			$this->id->CurrentValue = $key[1];
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
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->PWD->setDbValue($rs->fields('PWD'));
		$this->SES_REG->setDbValue($rs->fields('SES_REG'));
		$this->ROLES->setDbValue($rs->fields('ROLES'));
		$this->KDUNIT->setDbValue($rs->fields('KDUNIT'));
		$this->DEPARTEMEN->setDbValue($rs->fields('DEPARTEMEN'));
		$this->nama->setDbValue($rs->fields('nama'));
		$this->gambar->setDbValue($rs->fields('gambar'));
		$this->NIK->setDbValue($rs->fields('NIK'));
		$this->grup_ranap->setDbValue($rs->fields('grup_ranap'));
		$this->pd_nickname->setDbValue($rs->fields('pd_nickname'));
		$this->role_id->setDbValue($rs->fields('role_id'));
		$this->pd_avatar->Upload->DbValue = $rs->fields('pd_avatar');
		$this->pd_datejoined->setDbValue($rs->fields('pd_datejoined'));
		$this->pd_parentid->setDbValue($rs->fields('pd_parentid'));
		$this->pd_email->setDbValue($rs->fields('pd_email'));
		$this->pd_activated->setDbValue($rs->fields('pd_activated'));
		$this->pd_profiletext->setDbValue($rs->fields('pd_profiletext'));
		$this->pd_title->setDbValue($rs->fields('pd_title'));
		$this->pd_ipaddr->setDbValue($rs->fields('pd_ipaddr'));
		$this->pd_useragent->setDbValue($rs->fields('pd_useragent'));
		$this->pd_online->setDbValue($rs->fields('pd_online'));
		$this->id->setDbValue($rs->fields('id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// NIP
		// PWD
		// SES_REG
		// ROLES
		// KDUNIT
		// DEPARTEMEN
		// nama
		// gambar
		// NIK
		// grup_ranap
		// pd_nickname
		// role_id
		// pd_avatar
		// pd_datejoined
		// pd_parentid
		// pd_email
		// pd_activated
		// pd_profiletext
		// pd_title
		// pd_ipaddr
		// pd_useragent
		// pd_online
		// id
		// NIP

		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// PWD
		$this->PWD->ViewValue = $this->PWD->CurrentValue;
		$this->PWD->ViewCustomAttributes = "";

		// SES_REG
		$this->SES_REG->ViewValue = $this->SES_REG->CurrentValue;
		$this->SES_REG->ViewCustomAttributes = "";

		// ROLES
		$this->ROLES->ViewValue = $this->ROLES->CurrentValue;
		$this->ROLES->ViewCustomAttributes = "";

		// KDUNIT
		$this->KDUNIT->ViewValue = $this->KDUNIT->CurrentValue;
		$this->KDUNIT->ViewCustomAttributes = "";

		// DEPARTEMEN
		$this->DEPARTEMEN->ViewValue = $this->DEPARTEMEN->CurrentValue;
		$this->DEPARTEMEN->ViewCustomAttributes = "";

		// nama
		$this->nama->ViewValue = $this->nama->CurrentValue;
		$this->nama->ViewCustomAttributes = "";

		// gambar
		$this->gambar->ViewValue = $this->gambar->CurrentValue;
		$this->gambar->ViewCustomAttributes = "";

		// NIK
		$this->NIK->ViewValue = $this->NIK->CurrentValue;
		$this->NIK->ViewCustomAttributes = "";

		// grup_ranap
		$this->grup_ranap->ViewValue = $this->grup_ranap->CurrentValue;
		$this->grup_ranap->ViewCustomAttributes = "";

		// pd_nickname
		$this->pd_nickname->ViewValue = $this->pd_nickname->CurrentValue;
		$this->pd_nickname->ViewCustomAttributes = "";

		// role_id
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->role_id->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->role_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->role_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->role_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->role_id->ViewValue = $this->role_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->role_id->ViewValue = $this->role_id->CurrentValue;
			}
		} else {
			$this->role_id->ViewValue = NULL;
		}
		} else {
			$this->role_id->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->role_id->ViewCustomAttributes = "";

		// pd_avatar
		if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
			$this->pd_avatar->ImageWidth = 50;
			$this->pd_avatar->ImageHeight = 50;
			$this->pd_avatar->ImageAlt = $this->pd_avatar->FldAlt();
			$this->pd_avatar->ViewValue = $this->pd_avatar->Upload->DbValue;
		} else {
			$this->pd_avatar->ViewValue = "";
		}
		$this->pd_avatar->ViewCustomAttributes = " class = 'img-circle' ";

		// pd_datejoined
		$this->pd_datejoined->ViewValue = $this->pd_datejoined->CurrentValue;
		$this->pd_datejoined->ViewValue = ew_FormatDateTime($this->pd_datejoined->ViewValue, 0);
		$this->pd_datejoined->ViewCustomAttributes = "";

		// pd_parentid
		$this->pd_parentid->ViewValue = $this->pd_parentid->CurrentValue;
		$this->pd_parentid->ViewCustomAttributes = "";

		// pd_email
		$this->pd_email->ViewValue = $this->pd_email->CurrentValue;
		$this->pd_email->ViewCustomAttributes = "";

		// pd_activated
		$this->pd_activated->ViewValue = $this->pd_activated->CurrentValue;
		$this->pd_activated->ViewCustomAttributes = "";

		// pd_profiletext
		$this->pd_profiletext->ViewValue = $this->pd_profiletext->CurrentValue;
		$this->pd_profiletext->ViewCustomAttributes = "";

		// pd_title
		$this->pd_title->ViewValue = $this->pd_title->CurrentValue;
		$this->pd_title->ViewCustomAttributes = "";

		// pd_ipaddr
		$this->pd_ipaddr->ViewValue = $this->pd_ipaddr->CurrentValue;
		$this->pd_ipaddr->ViewCustomAttributes = "";

		// pd_useragent
		$this->pd_useragent->ViewValue = $this->pd_useragent->CurrentValue;
		$this->pd_useragent->ViewCustomAttributes = "";

		// pd_online
		$this->pd_online->ViewValue = $this->pd_online->CurrentValue;
		$this->pd_online->ViewCustomAttributes = "";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// NIP
		$this->NIP->LinkCustomAttributes = "";
		$this->NIP->HrefValue = "";
		$this->NIP->TooltipValue = "";

		// PWD
		$this->PWD->LinkCustomAttributes = "";
		$this->PWD->HrefValue = "";
		$this->PWD->TooltipValue = "";

		// SES_REG
		$this->SES_REG->LinkCustomAttributes = "";
		$this->SES_REG->HrefValue = "";
		$this->SES_REG->TooltipValue = "";

		// ROLES
		$this->ROLES->LinkCustomAttributes = "";
		$this->ROLES->HrefValue = "";
		$this->ROLES->TooltipValue = "";

		// KDUNIT
		$this->KDUNIT->LinkCustomAttributes = "";
		$this->KDUNIT->HrefValue = "";
		$this->KDUNIT->TooltipValue = "";

		// DEPARTEMEN
		$this->DEPARTEMEN->LinkCustomAttributes = "";
		$this->DEPARTEMEN->HrefValue = "";
		$this->DEPARTEMEN->TooltipValue = "";

		// nama
		$this->nama->LinkCustomAttributes = "";
		$this->nama->HrefValue = "";
		$this->nama->TooltipValue = "";

		// gambar
		$this->gambar->LinkCustomAttributes = "";
		$this->gambar->HrefValue = "";
		$this->gambar->TooltipValue = "";

		// NIK
		$this->NIK->LinkCustomAttributes = "";
		$this->NIK->HrefValue = "";
		$this->NIK->TooltipValue = "";

		// grup_ranap
		$this->grup_ranap->LinkCustomAttributes = "";
		$this->grup_ranap->HrefValue = "";
		$this->grup_ranap->TooltipValue = "";

		// pd_nickname
		$this->pd_nickname->LinkCustomAttributes = "";
		$this->pd_nickname->HrefValue = "";
		$this->pd_nickname->TooltipValue = "";

		// role_id
		$this->role_id->LinkCustomAttributes = "";
		$this->role_id->HrefValue = "";
		$this->role_id->TooltipValue = "";

		// pd_avatar
		$this->pd_avatar->LinkCustomAttributes = "";
		if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
			$this->pd_avatar->HrefValue = ew_GetFileUploadUrl($this->pd_avatar, $this->pd_avatar->Upload->DbValue); // Add prefix/suffix
			$this->pd_avatar->LinkAttrs["target"] = "_blank"; // Add target
			if ($this->Export <> "") $this->pd_avatar->HrefValue = ew_ConvertFullUrl($this->pd_avatar->HrefValue);
		} else {
			$this->pd_avatar->HrefValue = "";
		}
		$this->pd_avatar->HrefValue2 = $this->pd_avatar->UploadPath . $this->pd_avatar->Upload->DbValue;
		$this->pd_avatar->TooltipValue = "";
		if ($this->pd_avatar->UseColorbox) {
			if (ew_Empty($this->pd_avatar->TooltipValue))
				$this->pd_avatar->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
			$this->pd_avatar->LinkAttrs["data-rel"] = "m_login_x_pd_avatar";
			ew_AppendClass($this->pd_avatar->LinkAttrs["class"], "ewLightbox");
		}

		// pd_datejoined
		$this->pd_datejoined->LinkCustomAttributes = "";
		$this->pd_datejoined->HrefValue = "";
		$this->pd_datejoined->TooltipValue = "";

		// pd_parentid
		$this->pd_parentid->LinkCustomAttributes = "";
		$this->pd_parentid->HrefValue = "";
		$this->pd_parentid->TooltipValue = "";

		// pd_email
		$this->pd_email->LinkCustomAttributes = "";
		$this->pd_email->HrefValue = "";
		$this->pd_email->TooltipValue = "";

		// pd_activated
		$this->pd_activated->LinkCustomAttributes = "";
		$this->pd_activated->HrefValue = "";
		$this->pd_activated->TooltipValue = "";

		// pd_profiletext
		$this->pd_profiletext->LinkCustomAttributes = "";
		$this->pd_profiletext->HrefValue = "";
		$this->pd_profiletext->TooltipValue = "";

		// pd_title
		$this->pd_title->LinkCustomAttributes = "";
		$this->pd_title->HrefValue = "";
		$this->pd_title->TooltipValue = "";

		// pd_ipaddr
		$this->pd_ipaddr->LinkCustomAttributes = "";
		$this->pd_ipaddr->HrefValue = "";
		$this->pd_ipaddr->TooltipValue = "";

		// pd_useragent
		$this->pd_useragent->LinkCustomAttributes = "";
		$this->pd_useragent->HrefValue = "";
		$this->pd_useragent->TooltipValue = "";

		// pd_online
		$this->pd_online->LinkCustomAttributes = "";
		$this->pd_online->HrefValue = "";
		$this->pd_online->TooltipValue = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// NIP
		$this->NIP->EditAttrs["class"] = "form-control";
		$this->NIP->EditCustomAttributes = "";
		$this->NIP->EditValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// PWD
		$this->PWD->EditAttrs["class"] = "form-control ewPasswordStrength";
		$this->PWD->EditCustomAttributes = "";
		$this->PWD->EditValue = $this->PWD->CurrentValue;
		$this->PWD->PlaceHolder = ew_RemoveHtml($this->PWD->FldCaption());

		// SES_REG
		$this->SES_REG->EditAttrs["class"] = "form-control";
		$this->SES_REG->EditCustomAttributes = "";
		$this->SES_REG->EditValue = $this->SES_REG->CurrentValue;
		$this->SES_REG->PlaceHolder = ew_RemoveHtml($this->SES_REG->FldCaption());

		// ROLES
		$this->ROLES->EditAttrs["class"] = "form-control";
		$this->ROLES->EditCustomAttributes = "";
		$this->ROLES->EditValue = $this->ROLES->CurrentValue;
		$this->ROLES->PlaceHolder = ew_RemoveHtml($this->ROLES->FldCaption());

		// KDUNIT
		$this->KDUNIT->EditAttrs["class"] = "form-control";
		$this->KDUNIT->EditCustomAttributes = "";
		$this->KDUNIT->EditValue = $this->KDUNIT->CurrentValue;
		$this->KDUNIT->PlaceHolder = ew_RemoveHtml($this->KDUNIT->FldCaption());

		// DEPARTEMEN
		$this->DEPARTEMEN->EditAttrs["class"] = "form-control";
		$this->DEPARTEMEN->EditCustomAttributes = "";
		$this->DEPARTEMEN->EditValue = $this->DEPARTEMEN->CurrentValue;
		$this->DEPARTEMEN->PlaceHolder = ew_RemoveHtml($this->DEPARTEMEN->FldCaption());

		// nama
		$this->nama->EditAttrs["class"] = "form-control";
		$this->nama->EditCustomAttributes = "";
		$this->nama->EditValue = $this->nama->CurrentValue;
		$this->nama->PlaceHolder = ew_RemoveHtml($this->nama->FldCaption());

		// gambar
		$this->gambar->EditAttrs["class"] = "form-control";
		$this->gambar->EditCustomAttributes = "";
		$this->gambar->EditValue = $this->gambar->CurrentValue;
		$this->gambar->PlaceHolder = ew_RemoveHtml($this->gambar->FldCaption());

		// NIK
		$this->NIK->EditAttrs["class"] = "form-control";
		$this->NIK->EditCustomAttributes = "";
		$this->NIK->EditValue = $this->NIK->CurrentValue;
		$this->NIK->PlaceHolder = ew_RemoveHtml($this->NIK->FldCaption());

		// grup_ranap
		$this->grup_ranap->EditAttrs["class"] = "form-control";
		$this->grup_ranap->EditCustomAttributes = "";
		$this->grup_ranap->EditValue = $this->grup_ranap->CurrentValue;
		$this->grup_ranap->PlaceHolder = ew_RemoveHtml($this->grup_ranap->FldCaption());

		// pd_nickname
		$this->pd_nickname->EditAttrs["class"] = "form-control";
		$this->pd_nickname->EditCustomAttributes = "";
		$this->pd_nickname->EditValue = $this->pd_nickname->CurrentValue;
		$this->pd_nickname->PlaceHolder = ew_RemoveHtml($this->pd_nickname->FldCaption());

		// role_id
		$this->role_id->EditAttrs["class"] = "form-control";
		$this->role_id->EditCustomAttributes = "";
		if (!$Security->CanAdmin()) { // System admin
			$this->role_id->EditValue = $Language->Phrase("PasswordMask");
		} else {
		}

		// pd_avatar
		$this->pd_avatar->EditAttrs["class"] = "form-control";
		$this->pd_avatar->EditCustomAttributes = "";
		if (!ew_Empty($this->pd_avatar->Upload->DbValue)) {
			$this->pd_avatar->ImageWidth = 50;
			$this->pd_avatar->ImageHeight = 50;
			$this->pd_avatar->ImageAlt = $this->pd_avatar->FldAlt();
			$this->pd_avatar->EditValue = $this->pd_avatar->Upload->DbValue;
		} else {
			$this->pd_avatar->EditValue = "";
		}
		if (!ew_Empty($this->pd_avatar->CurrentValue))
			$this->pd_avatar->Upload->FileName = $this->pd_avatar->CurrentValue;

		// pd_datejoined
		$this->pd_datejoined->EditAttrs["class"] = "form-control";
		$this->pd_datejoined->EditCustomAttributes = "";
		$this->pd_datejoined->EditValue = ew_FormatDateTime($this->pd_datejoined->CurrentValue, 8);
		$this->pd_datejoined->PlaceHolder = ew_RemoveHtml($this->pd_datejoined->FldCaption());

		// pd_parentid
		$this->pd_parentid->EditAttrs["class"] = "form-control";
		$this->pd_parentid->EditCustomAttributes = "";
		if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin
			if (strval($this->id->CurrentValue) == strval(CurrentUserID())) {
		$this->pd_parentid->EditValue = $this->pd_parentid->CurrentValue;
		$this->pd_parentid->ViewCustomAttributes = "";
			} else {
			}
		} else {
		$this->pd_parentid->EditValue = $this->pd_parentid->CurrentValue;
		$this->pd_parentid->PlaceHolder = ew_RemoveHtml($this->pd_parentid->FldCaption());
		}

		// pd_email
		$this->pd_email->EditAttrs["class"] = "form-control";
		$this->pd_email->EditCustomAttributes = "";
		$this->pd_email->EditValue = $this->pd_email->CurrentValue;
		$this->pd_email->PlaceHolder = ew_RemoveHtml($this->pd_email->FldCaption());

		// pd_activated
		$this->pd_activated->EditAttrs["class"] = "form-control";
		$this->pd_activated->EditCustomAttributes = "";
		$this->pd_activated->EditValue = $this->pd_activated->CurrentValue;
		$this->pd_activated->PlaceHolder = ew_RemoveHtml($this->pd_activated->FldCaption());

		// pd_profiletext
		$this->pd_profiletext->EditAttrs["class"] = "form-control";
		$this->pd_profiletext->EditCustomAttributes = "";
		$this->pd_profiletext->EditValue = $this->pd_profiletext->CurrentValue;
		$this->pd_profiletext->PlaceHolder = ew_RemoveHtml($this->pd_profiletext->FldCaption());

		// pd_title
		$this->pd_title->EditAttrs["class"] = "form-control";
		$this->pd_title->EditCustomAttributes = "";
		$this->pd_title->EditValue = $this->pd_title->CurrentValue;
		$this->pd_title->PlaceHolder = ew_RemoveHtml($this->pd_title->FldCaption());

		// pd_ipaddr
		$this->pd_ipaddr->EditAttrs["class"] = "form-control";
		$this->pd_ipaddr->EditCustomAttributes = "";
		$this->pd_ipaddr->EditValue = $this->pd_ipaddr->CurrentValue;
		$this->pd_ipaddr->PlaceHolder = ew_RemoveHtml($this->pd_ipaddr->FldCaption());

		// pd_useragent
		$this->pd_useragent->EditAttrs["class"] = "form-control";
		$this->pd_useragent->EditCustomAttributes = "";
		$this->pd_useragent->EditValue = $this->pd_useragent->CurrentValue;
		$this->pd_useragent->PlaceHolder = ew_RemoveHtml($this->pd_useragent->FldCaption());

		// pd_online
		$this->pd_online->EditAttrs["class"] = "form-control";
		$this->pd_online->EditCustomAttributes = "";
		$this->pd_online->EditValue = $this->pd_online->CurrentValue;
		$this->pd_online->PlaceHolder = ew_RemoveHtml($this->pd_online->FldCaption());

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

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
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->PWD->Exportable) $Doc->ExportCaption($this->PWD);
					if ($this->SES_REG->Exportable) $Doc->ExportCaption($this->SES_REG);
					if ($this->ROLES->Exportable) $Doc->ExportCaption($this->ROLES);
					if ($this->KDUNIT->Exportable) $Doc->ExportCaption($this->KDUNIT);
					if ($this->DEPARTEMEN->Exportable) $Doc->ExportCaption($this->DEPARTEMEN);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->gambar->Exportable) $Doc->ExportCaption($this->gambar);
					if ($this->NIK->Exportable) $Doc->ExportCaption($this->NIK);
					if ($this->grup_ranap->Exportable) $Doc->ExportCaption($this->grup_ranap);
					if ($this->pd_nickname->Exportable) $Doc->ExportCaption($this->pd_nickname);
					if ($this->role_id->Exportable) $Doc->ExportCaption($this->role_id);
					if ($this->pd_avatar->Exportable) $Doc->ExportCaption($this->pd_avatar);
					if ($this->pd_datejoined->Exportable) $Doc->ExportCaption($this->pd_datejoined);
					if ($this->pd_parentid->Exportable) $Doc->ExportCaption($this->pd_parentid);
					if ($this->pd_email->Exportable) $Doc->ExportCaption($this->pd_email);
					if ($this->pd_activated->Exportable) $Doc->ExportCaption($this->pd_activated);
					if ($this->pd_profiletext->Exportable) $Doc->ExportCaption($this->pd_profiletext);
					if ($this->pd_title->Exportable) $Doc->ExportCaption($this->pd_title);
					if ($this->pd_ipaddr->Exportable) $Doc->ExportCaption($this->pd_ipaddr);
					if ($this->pd_useragent->Exportable) $Doc->ExportCaption($this->pd_useragent);
					if ($this->pd_online->Exportable) $Doc->ExportCaption($this->pd_online);
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
				} else {
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->PWD->Exportable) $Doc->ExportCaption($this->PWD);
					if ($this->SES_REG->Exportable) $Doc->ExportCaption($this->SES_REG);
					if ($this->ROLES->Exportable) $Doc->ExportCaption($this->ROLES);
					if ($this->KDUNIT->Exportable) $Doc->ExportCaption($this->KDUNIT);
					if ($this->DEPARTEMEN->Exportable) $Doc->ExportCaption($this->DEPARTEMEN);
					if ($this->nama->Exportable) $Doc->ExportCaption($this->nama);
					if ($this->gambar->Exportable) $Doc->ExportCaption($this->gambar);
					if ($this->NIK->Exportable) $Doc->ExportCaption($this->NIK);
					if ($this->grup_ranap->Exportable) $Doc->ExportCaption($this->grup_ranap);
					if ($this->pd_nickname->Exportable) $Doc->ExportCaption($this->pd_nickname);
					if ($this->role_id->Exportable) $Doc->ExportCaption($this->role_id);
					if ($this->pd_avatar->Exportable) $Doc->ExportCaption($this->pd_avatar);
					if ($this->pd_datejoined->Exportable) $Doc->ExportCaption($this->pd_datejoined);
					if ($this->pd_parentid->Exportable) $Doc->ExportCaption($this->pd_parentid);
					if ($this->pd_email->Exportable) $Doc->ExportCaption($this->pd_email);
					if ($this->pd_activated->Exportable) $Doc->ExportCaption($this->pd_activated);
					if ($this->pd_title->Exportable) $Doc->ExportCaption($this->pd_title);
					if ($this->pd_ipaddr->Exportable) $Doc->ExportCaption($this->pd_ipaddr);
					if ($this->pd_useragent->Exportable) $Doc->ExportCaption($this->pd_useragent);
					if ($this->pd_online->Exportable) $Doc->ExportCaption($this->pd_online);
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
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
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->PWD->Exportable) $Doc->ExportField($this->PWD);
						if ($this->SES_REG->Exportable) $Doc->ExportField($this->SES_REG);
						if ($this->ROLES->Exportable) $Doc->ExportField($this->ROLES);
						if ($this->KDUNIT->Exportable) $Doc->ExportField($this->KDUNIT);
						if ($this->DEPARTEMEN->Exportable) $Doc->ExportField($this->DEPARTEMEN);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->gambar->Exportable) $Doc->ExportField($this->gambar);
						if ($this->NIK->Exportable) $Doc->ExportField($this->NIK);
						if ($this->grup_ranap->Exportable) $Doc->ExportField($this->grup_ranap);
						if ($this->pd_nickname->Exportable) $Doc->ExportField($this->pd_nickname);
						if ($this->role_id->Exportable) $Doc->ExportField($this->role_id);
						if ($this->pd_avatar->Exportable) $Doc->ExportField($this->pd_avatar);
						if ($this->pd_datejoined->Exportable) $Doc->ExportField($this->pd_datejoined);
						if ($this->pd_parentid->Exportable) $Doc->ExportField($this->pd_parentid);
						if ($this->pd_email->Exportable) $Doc->ExportField($this->pd_email);
						if ($this->pd_activated->Exportable) $Doc->ExportField($this->pd_activated);
						if ($this->pd_profiletext->Exportable) $Doc->ExportField($this->pd_profiletext);
						if ($this->pd_title->Exportable) $Doc->ExportField($this->pd_title);
						if ($this->pd_ipaddr->Exportable) $Doc->ExportField($this->pd_ipaddr);
						if ($this->pd_useragent->Exportable) $Doc->ExportField($this->pd_useragent);
						if ($this->pd_online->Exportable) $Doc->ExportField($this->pd_online);
						if ($this->id->Exportable) $Doc->ExportField($this->id);
					} else {
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->PWD->Exportable) $Doc->ExportField($this->PWD);
						if ($this->SES_REG->Exportable) $Doc->ExportField($this->SES_REG);
						if ($this->ROLES->Exportable) $Doc->ExportField($this->ROLES);
						if ($this->KDUNIT->Exportable) $Doc->ExportField($this->KDUNIT);
						if ($this->DEPARTEMEN->Exportable) $Doc->ExportField($this->DEPARTEMEN);
						if ($this->nama->Exportable) $Doc->ExportField($this->nama);
						if ($this->gambar->Exportable) $Doc->ExportField($this->gambar);
						if ($this->NIK->Exportable) $Doc->ExportField($this->NIK);
						if ($this->grup_ranap->Exportable) $Doc->ExportField($this->grup_ranap);
						if ($this->pd_nickname->Exportable) $Doc->ExportField($this->pd_nickname);
						if ($this->role_id->Exportable) $Doc->ExportField($this->role_id);
						if ($this->pd_avatar->Exportable) $Doc->ExportField($this->pd_avatar);
						if ($this->pd_datejoined->Exportable) $Doc->ExportField($this->pd_datejoined);
						if ($this->pd_parentid->Exportable) $Doc->ExportField($this->pd_parentid);
						if ($this->pd_email->Exportable) $Doc->ExportField($this->pd_email);
						if ($this->pd_activated->Exportable) $Doc->ExportField($this->pd_activated);
						if ($this->pd_title->Exportable) $Doc->ExportField($this->pd_title);
						if ($this->pd_ipaddr->Exportable) $Doc->ExportField($this->pd_ipaddr);
						if ($this->pd_useragent->Exportable) $Doc->ExportField($this->pd_useragent);
						if ($this->pd_online->Exportable) $Doc->ExportField($this->pd_online);
						if ($this->id->Exportable) $Doc->ExportField($this->id);
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

	// User ID filter
	function UserIDFilter($userid) {
		$sUserIDFilter = '`id` = ' . ew_QuotedValue($userid, EW_DATATYPE_NUMBER, EW_USER_TABLE_DBID);
		$sParentUserIDFilter = '`id` IN (SELECT `id` FROM ' . "`m_login`" . ' WHERE `pd_parentid` = ' . ew_QuotedValue($userid, EW_DATATYPE_NUMBER, EW_USER_TABLE_DBID) . ')';
		$sUserIDFilter = "($sUserIDFilter) OR ($sParentUserIDFilter)";
		return $sUserIDFilter;
	}

	// Add User ID filter
	function AddUserIDFilter($sFilter) {
		global $Security;
		$sFilterWrk = "";
		$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->UserIDAllow($id) && !$Security->IsAdmin()) {
			$sFilterWrk = $Security->UserIDList();
			if ($sFilterWrk <> "")
				$sFilterWrk = '`id` IN (' . $sFilterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($sFilterWrk);
		ew_AddFilter($sFilter, $sFilterWrk);
		return $sFilter;
	}

	// Add Parent User ID filter
	function AddParentUserIDFilter($sFilter, $userid) {
		global $Security;
		if (!$Security->IsAdmin()) {
			$result = $Security->ParentUserIDList($userid);
			if ($result <> "")
				$result = '`id` IN (' . $result . ')';
			ew_AddFilter($result, $sFilter);
			return $result;
		} else {
			return $sFilter;
		}
	}

	// User ID subquery
	function GetUserIDSubquery(&$fld, &$masterfld) {
		global $UserTableConn;
		$sWrk = "";
		$sSql = "SELECT " . $masterfld->FldExpression . " FROM `m_login`";
		$sFilter = $this->AddUserIDFilter("");
		if ($sFilter <> "") $sSql .= " WHERE " . $sFilter;

		// Use subquery
		if (EW_USE_SUBQUERY_FOR_MASTER_USER_ID) {
			$sWrk = $sSql;
		} else {

			// List all values
			if ($rs = $UserTableConn->Execute($sSql)) {
				while (!$rs->EOF) {
					if ($sWrk <> "") $sWrk .= ",";
					$sWrk .= ew_QuotedValue($rs->fields[0], $masterfld->FldDataType, EW_USER_TABLE_DBID);
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if ($sWrk <> "") {
			$sWrk = $fld->FldExpression . " IN (" . $sWrk . ")";
		}
		return $sWrk;
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'm_login';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'm_login';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NIP'];
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
				if ($fldname == 'PWD')
					$newvalue = $Language->Phrase("PasswordMask");
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'm_login';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['NIP'];
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
					if ($fldname == 'PWD') {
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
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
		$table = 'm_login';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NIP'];
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
				if ($fldname == 'PWD')
					$oldvalue = $Language->Phrase("PasswordMask");
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
