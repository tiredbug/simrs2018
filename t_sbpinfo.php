<?php

// Global variable for table object
$t_sbp = NULL;

//
// Table class for t_sbp
//
class ct_sbp extends cTable {
	var $id;
	var $tipe;
	var $tipe_sbp;
	var $no_sbp;
	var $tgl_sbp;
	var $program;
	var $kegiatan;
	var $sub_kegiatan;
	var $uraian;
	var $nama_penerima;
	var $alamat_penerima;
	var $nama_pptk;
	var $nip_pptk;
	var $nama_pengguna;
	var $nip_pengguna_anggaran;
	var $akun1;
	var $akun2;
	var $akun3;
	var $akun4;
	var $akun5;
	var $kode_rekening;
	var $pph21;
	var $pph22;
	var $pph23;
	var $pph4;
	var $jumlah_belanja;
	var $no_spj;
	var $tgl_spj;
	var $tahun_anggaran;
	var $kode_opd;
	var $ppn;
	var $nama_bendahara_pengeluaran;
	var $nip_bendahara_pengeluaran;
	var $status_spj;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_sbp';
		$this->TableName = 't_sbp';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_sbp`";
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
		$this->id = new cField('t_sbp', 't_sbp', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// tipe
		$this->tipe = new cField('t_sbp', 't_sbp', 'x_tipe', 'tipe', '`tipe`', '`tipe`', 3, -1, FALSE, '`tipe`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->tipe->Sortable = TRUE; // Allow sort
		$this->tipe->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->tipe->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->tipe->OptionCount = 2;
		$this->tipe->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tipe'] = &$this->tipe;

		// tipe_sbp
		$this->tipe_sbp = new cField('t_sbp', 't_sbp', 'x_tipe_sbp', 'tipe_sbp', '`tipe_sbp`', '`tipe_sbp`', 3, -1, FALSE, '`tipe_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->tipe_sbp->Sortable = TRUE; // Allow sort
		$this->tipe_sbp->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->tipe_sbp->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->tipe_sbp->OptionCount = 2;
		$this->tipe_sbp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tipe_sbp'] = &$this->tipe_sbp;

		// no_sbp
		$this->no_sbp = new cField('t_sbp', 't_sbp', 'x_no_sbp', 'no_sbp', '`no_sbp`', '`no_sbp`', 200, -1, FALSE, '`no_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_sbp->Sortable = TRUE; // Allow sort
		$this->fields['no_sbp'] = &$this->no_sbp;

		// tgl_sbp
		$this->tgl_sbp = new cField('t_sbp', 't_sbp', 'x_tgl_sbp', 'tgl_sbp', '`tgl_sbp`', ew_CastDateFieldForLike('`tgl_sbp`', 7, "DB"), 135, 7, FALSE, '`tgl_sbp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_sbp->Sortable = TRUE; // Allow sort
		$this->tgl_sbp->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_sbp'] = &$this->tgl_sbp;

		// program
		$this->program = new cField('t_sbp', 't_sbp', 'x_program', 'program', '`program`', '`program`', 200, -1, FALSE, '`program`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->program->Sortable = TRUE; // Allow sort
		$this->program->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->program->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['program'] = &$this->program;

		// kegiatan
		$this->kegiatan = new cField('t_sbp', 't_sbp', 'x_kegiatan', 'kegiatan', '`kegiatan`', '`kegiatan`', 200, -1, FALSE, '`kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kegiatan->Sortable = TRUE; // Allow sort
		$this->kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['kegiatan'] = &$this->kegiatan;

		// sub_kegiatan
		$this->sub_kegiatan = new cField('t_sbp', 't_sbp', 'x_sub_kegiatan', 'sub_kegiatan', '`sub_kegiatan`', '`sub_kegiatan`', 200, -1, FALSE, '`sub_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->sub_kegiatan->Sortable = TRUE; // Allow sort
		$this->sub_kegiatan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->sub_kegiatan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['sub_kegiatan'] = &$this->sub_kegiatan;

		// uraian
		$this->uraian = new cField('t_sbp', 't_sbp', 'x_uraian', 'uraian', '`uraian`', '`uraian`', 201, -1, FALSE, '`uraian`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->uraian->Sortable = TRUE; // Allow sort
		$this->fields['uraian'] = &$this->uraian;

		// nama_penerima
		$this->nama_penerima = new cField('t_sbp', 't_sbp', 'x_nama_penerima', 'nama_penerima', '`nama_penerima`', '`nama_penerima`', 201, -1, FALSE, '`nama_penerima`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_penerima->Sortable = TRUE; // Allow sort
		$this->fields['nama_penerima'] = &$this->nama_penerima;

		// alamat_penerima
		$this->alamat_penerima = new cField('t_sbp', 't_sbp', 'x_alamat_penerima', 'alamat_penerima', '`alamat_penerima`', '`alamat_penerima`', 201, -1, FALSE, '`alamat_penerima`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->alamat_penerima->Sortable = TRUE; // Allow sort
		$this->fields['alamat_penerima'] = &$this->alamat_penerima;

		// nama_pptk
		$this->nama_pptk = new cField('t_sbp', 't_sbp', 'x_nama_pptk', 'nama_pptk', '`nama_pptk`', '`nama_pptk`', 200, -1, FALSE, '`nama_pptk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nama_pptk->Sortable = TRUE; // Allow sort
		$this->nama_pptk->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nama_pptk->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nama_pptk'] = &$this->nama_pptk;

		// nip_pptk
		$this->nip_pptk = new cField('t_sbp', 't_sbp', 'x_nip_pptk', 'nip_pptk', '`nip_pptk`', '`nip_pptk`', 200, -1, FALSE, '`nip_pptk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_pptk->Sortable = TRUE; // Allow sort
		$this->fields['nip_pptk'] = &$this->nip_pptk;

		// nama_pengguna
		$this->nama_pengguna = new cField('t_sbp', 't_sbp', 'x_nama_pengguna', 'nama_pengguna', '`nama_pengguna`', '`nama_pengguna`', 200, -1, FALSE, '`nama_pengguna`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->nama_pengguna->Sortable = TRUE; // Allow sort
		$this->nama_pengguna->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->nama_pengguna->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['nama_pengguna'] = &$this->nama_pengguna;

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran = new cField('t_sbp', 't_sbp', 'x_nip_pengguna_anggaran', 'nip_pengguna_anggaran', '`nip_pengguna_anggaran`', '`nip_pengguna_anggaran`', 200, -1, FALSE, '`nip_pengguna_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_pengguna_anggaran->Sortable = TRUE; // Allow sort
		$this->fields['nip_pengguna_anggaran'] = &$this->nip_pengguna_anggaran;

		// akun1
		$this->akun1 = new cField('t_sbp', 't_sbp', 'x_akun1', 'akun1', '`akun1`', '`akun1`', 200, -1, FALSE, '`akun1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun1->Sortable = TRUE; // Allow sort
		$this->fields['akun1'] = &$this->akun1;

		// akun2
		$this->akun2 = new cField('t_sbp', 't_sbp', 'x_akun2', 'akun2', '`akun2`', '`akun2`', 200, -1, FALSE, '`akun2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->akun2->Sortable = TRUE; // Allow sort
		$this->akun2->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->akun2->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['akun2'] = &$this->akun2;

		// akun3
		$this->akun3 = new cField('t_sbp', 't_sbp', 'x_akun3', 'akun3', '`akun3`', '`akun3`', 200, -1, FALSE, '`akun3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->akun3->Sortable = TRUE; // Allow sort
		$this->akun3->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->akun3->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['akun3'] = &$this->akun3;

		// akun4
		$this->akun4 = new cField('t_sbp', 't_sbp', 'x_akun4', 'akun4', '`akun4`', '`akun4`', 200, -1, FALSE, '`akun4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->akun4->Sortable = TRUE; // Allow sort
		$this->akun4->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->akun4->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['akun4'] = &$this->akun4;

		// akun5
		$this->akun5 = new cField('t_sbp', 't_sbp', 'x_akun5', 'akun5', '`akun5`', '`akun5`', 200, -1, FALSE, '`akun5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->akun5->Sortable = TRUE; // Allow sort
		$this->akun5->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->akun5->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['akun5'] = &$this->akun5;

		// kode_rekening
		$this->kode_rekening = new cField('t_sbp', 't_sbp', 'x_kode_rekening', 'kode_rekening', '`kode_rekening`', '`kode_rekening`', 200, -1, FALSE, '`kode_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_rekening->Sortable = TRUE; // Allow sort
		$this->fields['kode_rekening'] = &$this->kode_rekening;

		// pph21
		$this->pph21 = new cField('t_sbp', 't_sbp', 'x_pph21', 'pph21', '`pph21`', '`pph21`', 200, -1, FALSE, '`pph21`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph21->Sortable = TRUE; // Allow sort
		$this->fields['pph21'] = &$this->pph21;

		// pph22
		$this->pph22 = new cField('t_sbp', 't_sbp', 'x_pph22', 'pph22', '`pph22`', '`pph22`', 200, -1, FALSE, '`pph22`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph22->Sortable = TRUE; // Allow sort
		$this->fields['pph22'] = &$this->pph22;

		// pph23
		$this->pph23 = new cField('t_sbp', 't_sbp', 'x_pph23', 'pph23', '`pph23`', '`pph23`', 200, -1, FALSE, '`pph23`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph23->Sortable = TRUE; // Allow sort
		$this->fields['pph23'] = &$this->pph23;

		// pph4
		$this->pph4 = new cField('t_sbp', 't_sbp', 'x_pph4', 'pph4', '`pph4`', '`pph4`', 200, -1, FALSE, '`pph4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph4->Sortable = TRUE; // Allow sort
		$this->fields['pph4'] = &$this->pph4;

		// jumlah_belanja
		$this->jumlah_belanja = new cField('t_sbp', 't_sbp', 'x_jumlah_belanja', 'jumlah_belanja', '`jumlah_belanja`', '`jumlah_belanja`', 5, -1, FALSE, '`jumlah_belanja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_belanja->Sortable = TRUE; // Allow sort
		$this->jumlah_belanja->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_belanja'] = &$this->jumlah_belanja;

		// no_spj
		$this->no_spj = new cField('t_sbp', 't_sbp', 'x_no_spj', 'no_spj', '`no_spj`', '`no_spj`', 200, -1, FALSE, '`no_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spj->Sortable = TRUE; // Allow sort
		$this->fields['no_spj'] = &$this->no_spj;

		// tgl_spj
		$this->tgl_spj = new cField('t_sbp', 't_sbp', 'x_tgl_spj', 'tgl_spj', '`tgl_spj`', ew_CastDateFieldForLike('`tgl_spj`', 0, "DB"), 135, 0, FALSE, '`tgl_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_spj->Sortable = TRUE; // Allow sort
		$this->tgl_spj->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_spj'] = &$this->tgl_spj;

		// tahun_anggaran
		$this->tahun_anggaran = new cField('t_sbp', 't_sbp', 'x_tahun_anggaran', 'tahun_anggaran', '`tahun_anggaran`', '`tahun_anggaran`', 3, -1, FALSE, '`tahun_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun_anggaran->Sortable = TRUE; // Allow sort
		$this->tahun_anggaran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tahun_anggaran'] = &$this->tahun_anggaran;

		// kode_opd
		$this->kode_opd = new cField('t_sbp', 't_sbp', 'x_kode_opd', 'kode_opd', '`kode_opd`', '`kode_opd`', 200, -1, FALSE, '`kode_opd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_opd->Sortable = TRUE; // Allow sort
		$this->fields['kode_opd'] = &$this->kode_opd;

		// ppn
		$this->ppn = new cField('t_sbp', 't_sbp', 'x_ppn', 'ppn', '`ppn`', '`ppn`', 5, -1, FALSE, '`ppn`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ppn->Sortable = TRUE; // Allow sort
		$this->ppn->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['ppn'] = &$this->ppn;

		// nama_bendahara_pengeluaran
		$this->nama_bendahara_pengeluaran = new cField('t_sbp', 't_sbp', 'x_nama_bendahara_pengeluaran', 'nama_bendahara_pengeluaran', '`nama_bendahara_pengeluaran`', '`nama_bendahara_pengeluaran`', 200, -1, FALSE, '`nama_bendahara_pengeluaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_bendahara_pengeluaran->Sortable = TRUE; // Allow sort
		$this->fields['nama_bendahara_pengeluaran'] = &$this->nama_bendahara_pengeluaran;

		// nip_bendahara_pengeluaran
		$this->nip_bendahara_pengeluaran = new cField('t_sbp', 't_sbp', 'x_nip_bendahara_pengeluaran', 'nip_bendahara_pengeluaran', '`nip_bendahara_pengeluaran`', '`nip_bendahara_pengeluaran`', 200, -1, FALSE, '`nip_bendahara_pengeluaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_bendahara_pengeluaran->Sortable = TRUE; // Allow sort
		$this->fields['nip_bendahara_pengeluaran'] = &$this->nip_bendahara_pengeluaran;

		// status_spj
		$this->status_spj = new cField('t_sbp', 't_sbp', 'x_status_spj', 'status_spj', '`status_spj`', '`status_spj`', 3, -1, FALSE, '`status_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_spj->Sortable = FALSE; // Allow sort
		$this->status_spj->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_spj'] = &$this->status_spj;
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
		if ($this->getCurrentDetailTable() == "t_sbp_detail") {
			$sDetailUrl = $GLOBALS["t_sbp_detail"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
			$sDetailUrl .= "&fk_tipe_sbp=" . urlencode($this->tipe_sbp->CurrentValue);
			$sDetailUrl .= "&fk_no_sbp=" . urlencode($this->no_sbp->CurrentValue);
			$sDetailUrl .= "&fk_program=" . urlencode($this->program->CurrentValue);
			$sDetailUrl .= "&fk_kegiatan=" . urlencode($this->kegiatan->CurrentValue);
			$sDetailUrl .= "&fk_sub_kegiatan=" . urlencode($this->sub_kegiatan->CurrentValue);
			$sDetailUrl .= "&fk_tahun_anggaran=" . urlencode($this->tahun_anggaran->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "vw_pajak_sbp_detail") {
			$sDetailUrl = $GLOBALS["vw_pajak_sbp_detail"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_id=" . urlencode($this->id->CurrentValue);
			$sDetailUrl .= "&fk_tipe_sbp=" . urlencode($this->tipe_sbp->CurrentValue);
			$sDetailUrl .= "&fk_no_sbp=" . urlencode($this->no_sbp->CurrentValue);
			$sDetailUrl .= "&fk_program=" . urlencode($this->program->CurrentValue);
			$sDetailUrl .= "&fk_kegiatan=" . urlencode($this->kegiatan->CurrentValue);
			$sDetailUrl .= "&fk_sub_kegiatan=" . urlencode($this->sub_kegiatan->CurrentValue);
			$sDetailUrl .= "&fk_tahun_anggaran=" . urlencode($this->tahun_anggaran->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "t_sbplist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_sbp`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`id` DESC";
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
			return "t_sbplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_sbplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_sbpview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_sbpview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_sbpadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_sbpadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_sbpedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_sbpedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("t_sbpadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_sbpadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_sbpdelete.php", $this->UrlParm());
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
		$this->tipe->setDbValue($rs->fields('tipe'));
		$this->tipe_sbp->setDbValue($rs->fields('tipe_sbp'));
		$this->no_sbp->setDbValue($rs->fields('no_sbp'));
		$this->tgl_sbp->setDbValue($rs->fields('tgl_sbp'));
		$this->program->setDbValue($rs->fields('program'));
		$this->kegiatan->setDbValue($rs->fields('kegiatan'));
		$this->sub_kegiatan->setDbValue($rs->fields('sub_kegiatan'));
		$this->uraian->setDbValue($rs->fields('uraian'));
		$this->nama_penerima->setDbValue($rs->fields('nama_penerima'));
		$this->alamat_penerima->setDbValue($rs->fields('alamat_penerima'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->nama_pengguna->setDbValue($rs->fields('nama_pengguna'));
		$this->nip_pengguna_anggaran->setDbValue($rs->fields('nip_pengguna_anggaran'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->pph21->setDbValue($rs->fields('pph21'));
		$this->pph22->setDbValue($rs->fields('pph22'));
		$this->pph23->setDbValue($rs->fields('pph23'));
		$this->pph4->setDbValue($rs->fields('pph4'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->no_spj->setDbValue($rs->fields('no_spj'));
		$this->tgl_spj->setDbValue($rs->fields('tgl_spj'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->kode_opd->setDbValue($rs->fields('kode_opd'));
		$this->ppn->setDbValue($rs->fields('ppn'));
		$this->nama_bendahara_pengeluaran->setDbValue($rs->fields('nama_bendahara_pengeluaran'));
		$this->nip_bendahara_pengeluaran->setDbValue($rs->fields('nip_bendahara_pengeluaran'));
		$this->status_spj->setDbValue($rs->fields('status_spj'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id

		$this->id->CellCssStyle = "white-space: nowrap;";

		// tipe
		$this->tipe->CellCssStyle = "white-space: nowrap;";

		// tipe_sbp
		$this->tipe_sbp->CellCssStyle = "white-space: nowrap;";

		// no_sbp
		$this->no_sbp->CellCssStyle = "white-space: nowrap;";

		// tgl_sbp
		$this->tgl_sbp->CellCssStyle = "white-space: nowrap;";

		// program
		$this->program->CellCssStyle = "white-space: nowrap;";

		// kegiatan
		$this->kegiatan->CellCssStyle = "white-space: nowrap;";

		// sub_kegiatan
		$this->sub_kegiatan->CellCssStyle = "white-space: nowrap;";

		// uraian
		$this->uraian->CellCssStyle = "white-space: nowrap;";

		// nama_penerima
		$this->nama_penerima->CellCssStyle = "white-space: nowrap;";

		// alamat_penerima
		$this->alamat_penerima->CellCssStyle = "white-space: nowrap;";

		// nama_pptk
		$this->nama_pptk->CellCssStyle = "white-space: nowrap;";

		// nip_pptk
		$this->nip_pptk->CellCssStyle = "white-space: nowrap;";

		// nama_pengguna
		$this->nama_pengguna->CellCssStyle = "white-space: nowrap;";

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->CellCssStyle = "white-space: nowrap;";

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

		// kode_rekening
		$this->kode_rekening->CellCssStyle = "white-space: nowrap;";

		// pph21
		$this->pph21->CellCssStyle = "white-space: nowrap;";

		// pph22
		$this->pph22->CellCssStyle = "white-space: nowrap;";

		// pph23
		$this->pph23->CellCssStyle = "white-space: nowrap;";

		// pph4
		$this->pph4->CellCssStyle = "white-space: nowrap;";

		// jumlah_belanja
		$this->jumlah_belanja->CellCssStyle = "white-space: nowrap;";

		// no_spj
		$this->no_spj->CellCssStyle = "white-space: nowrap;";

		// tgl_spj
		$this->tgl_spj->CellCssStyle = "white-space: nowrap;";

		// tahun_anggaran
		$this->tahun_anggaran->CellCssStyle = "white-space: nowrap;";

		// kode_opd
		$this->kode_opd->CellCssStyle = "white-space: nowrap;";

		// ppn
		$this->ppn->CellCssStyle = "white-space: nowrap;";

		// nama_bendahara_pengeluaran
		$this->nama_bendahara_pengeluaran->CellCssStyle = "white-space: nowrap;";

		// nip_bendahara_pengeluaran
		$this->nip_bendahara_pengeluaran->CellCssStyle = "white-space: nowrap;";

		// status_spj
		$this->status_spj->CellCssStyle = "white-space: nowrap;";

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// tipe
		if (strval($this->tipe->CurrentValue) <> "") {
			$this->tipe->ViewValue = $this->tipe->OptionCaption($this->tipe->CurrentValue);
		} else {
			$this->tipe->ViewValue = NULL;
		}
		$this->tipe->ViewCustomAttributes = "";

		// tipe_sbp
		if (strval($this->tipe_sbp->CurrentValue) <> "") {
			$this->tipe_sbp->ViewValue = $this->tipe_sbp->OptionCaption($this->tipe_sbp->CurrentValue);
		} else {
			$this->tipe_sbp->ViewValue = NULL;
		}
		$this->tipe_sbp->ViewCustomAttributes = "";

		// no_sbp
		$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->ViewCustomAttributes = "";

		// tgl_sbp
		$this->tgl_sbp->ViewValue = $this->tgl_sbp->CurrentValue;
		$this->tgl_sbp->ViewValue = ew_FormatDateTime($this->tgl_sbp->ViewValue, 7);
		$this->tgl_sbp->ViewCustomAttributes = "";

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

		// uraian
		$this->uraian->ViewValue = $this->uraian->CurrentValue;
		$this->uraian->ViewCustomAttributes = "";

		// nama_penerima
		$this->nama_penerima->ViewValue = $this->nama_penerima->CurrentValue;
		$this->nama_penerima->ViewCustomAttributes = "";

		// alamat_penerima
		$this->alamat_penerima->ViewValue = $this->alamat_penerima->CurrentValue;
		$this->alamat_penerima->ViewCustomAttributes = "";

		// nama_pptk
		if (strval($this->nama_pptk->CurrentValue) <> "") {
			$sFilterWrk = "`nama`" . ew_SearchString("=", $this->nama_pptk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `nama`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pejabat_keuangan`";
		$sWhereWrk = "";
		$this->nama_pptk->LookupFilters = array();
		$lookuptblfilter = "`jabatan`=4";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_pptk->ViewValue = $this->nama_pptk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_pptk->ViewValue = $this->nama_pptk->CurrentValue;
			}
		} else {
			$this->nama_pptk->ViewValue = NULL;
		}
		$this->nama_pptk->ViewCustomAttributes = "";

		// nip_pptk
		$this->nip_pptk->ViewValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->ViewCustomAttributes = "";

		// nama_pengguna
		if (strval($this->nama_pengguna->CurrentValue) <> "") {
			$sFilterWrk = "`direktur`" . ew_SearchString("=", $this->nama_pengguna->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `direktur`, `direktur` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_blud_rs`";
		$sWhereWrk = "";
		$this->nama_pengguna->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nama_pengguna, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->nama_pengguna->ViewValue = $this->nama_pengguna->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nama_pengguna->ViewValue = $this->nama_pengguna->CurrentValue;
			}
		} else {
			$this->nama_pengguna->ViewValue = NULL;
		}
		$this->nama_pengguna->ViewCustomAttributes = "";

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->ViewValue = $this->nip_pengguna_anggaran->CurrentValue;
		$this->nip_pengguna_anggaran->ViewCustomAttributes = "";

		// akun1
		$this->akun1->ViewValue = $this->akun1->CurrentValue;
		$this->akun1->ViewCustomAttributes = "";

		// akun2
		if (strval($this->akun2->CurrentValue) <> "") {
			$sFilterWrk = "`kel2`" . ew_SearchString("=", $this->akun2->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel2`, `nmkel2` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun2`";
		$sWhereWrk = "";
		$this->akun2->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun2, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun2->ViewValue = $this->akun2->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun2->ViewValue = $this->akun2->CurrentValue;
			}
		} else {
			$this->akun2->ViewValue = NULL;
		}
		$this->akun2->ViewCustomAttributes = "";

		// akun3
		if (strval($this->akun3->CurrentValue) <> "") {
			$sFilterWrk = "`kel3`" . ew_SearchString("=", $this->akun3->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel3`, `nmkel3` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun3`";
		$sWhereWrk = "";
		$this->akun3->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun3, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun3->ViewValue = $this->akun3->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun3->ViewValue = $this->akun3->CurrentValue;
			}
		} else {
			$this->akun3->ViewValue = NULL;
		}
		$this->akun3->ViewCustomAttributes = "";

		// akun4
		if (strval($this->akun4->CurrentValue) <> "") {
			$sFilterWrk = "`kel4`" . ew_SearchString("=", $this->akun4->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `kel4`, `nmkel4` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun4`";
		$sWhereWrk = "";
		$this->akun4->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->akun4, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->akun4->ViewValue = $this->akun4->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->akun4->ViewValue = $this->akun4->CurrentValue;
			}
		} else {
			$this->akun4->ViewValue = NULL;
		}
		$this->akun4->ViewCustomAttributes = "";

		// akun5
		if (strval($this->akun5->CurrentValue) <> "") {
			$sFilterWrk = "`akun5`" . ew_SearchString("=", $this->akun5->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `akun5`, `nama_akun` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `keu_akun5`";
		$sWhereWrk = "";
		$this->akun5->LookupFilters = array();
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

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// pph21
		$this->pph21->ViewValue = $this->pph21->CurrentValue;
		$this->pph21->ViewCustomAttributes = "";

		// pph22
		$this->pph22->ViewValue = $this->pph22->CurrentValue;
		$this->pph22->ViewCustomAttributes = "";

		// pph23
		$this->pph23->ViewValue = $this->pph23->CurrentValue;
		$this->pph23->ViewCustomAttributes = "";

		// pph4
		$this->pph4->ViewValue = $this->pph4->CurrentValue;
		$this->pph4->ViewCustomAttributes = "";

		// jumlah_belanja
		$this->jumlah_belanja->ViewValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->ViewCustomAttributes = "";

		// no_spj
		$this->no_spj->ViewValue = $this->no_spj->CurrentValue;
		$this->no_spj->ViewCustomAttributes = "";

		// tgl_spj
		$this->tgl_spj->ViewValue = $this->tgl_spj->CurrentValue;
		$this->tgl_spj->ViewValue = ew_FormatDateTime($this->tgl_spj->ViewValue, 0);
		$this->tgl_spj->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// kode_opd
		$this->kode_opd->ViewValue = $this->kode_opd->CurrentValue;
		$this->kode_opd->ViewCustomAttributes = "";

		// ppn
		$this->ppn->ViewValue = $this->ppn->CurrentValue;
		$this->ppn->ViewCustomAttributes = "";

		// nama_bendahara_pengeluaran
		$this->nama_bendahara_pengeluaran->ViewValue = $this->nama_bendahara_pengeluaran->CurrentValue;
		$this->nama_bendahara_pengeluaran->ViewCustomAttributes = "";

		// nip_bendahara_pengeluaran
		$this->nip_bendahara_pengeluaran->ViewValue = $this->nip_bendahara_pengeluaran->CurrentValue;
		$this->nip_bendahara_pengeluaran->ViewCustomAttributes = "";

		// status_spj
		$this->status_spj->ViewValue = $this->status_spj->CurrentValue;
		$this->status_spj->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// tipe
		$this->tipe->LinkCustomAttributes = "";
		$this->tipe->HrefValue = "";
		$this->tipe->TooltipValue = "";

		// tipe_sbp
		$this->tipe_sbp->LinkCustomAttributes = "";
		$this->tipe_sbp->HrefValue = "";
		$this->tipe_sbp->TooltipValue = "";

		// no_sbp
		$this->no_sbp->LinkCustomAttributes = "";
		$this->no_sbp->HrefValue = "";
		$this->no_sbp->TooltipValue = "";

		// tgl_sbp
		$this->tgl_sbp->LinkCustomAttributes = "";
		$this->tgl_sbp->HrefValue = "";
		$this->tgl_sbp->TooltipValue = "";

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

		// uraian
		$this->uraian->LinkCustomAttributes = "";
		$this->uraian->HrefValue = "";
		$this->uraian->TooltipValue = "";

		// nama_penerima
		$this->nama_penerima->LinkCustomAttributes = "";
		$this->nama_penerima->HrefValue = "";
		$this->nama_penerima->TooltipValue = "";

		// alamat_penerima
		$this->alamat_penerima->LinkCustomAttributes = "";
		$this->alamat_penerima->HrefValue = "";
		$this->alamat_penerima->TooltipValue = "";

		// nama_pptk
		$this->nama_pptk->LinkCustomAttributes = "";
		$this->nama_pptk->HrefValue = "";
		$this->nama_pptk->TooltipValue = "";

		// nip_pptk
		$this->nip_pptk->LinkCustomAttributes = "";
		$this->nip_pptk->HrefValue = "";
		$this->nip_pptk->TooltipValue = "";

		// nama_pengguna
		$this->nama_pengguna->LinkCustomAttributes = "";
		$this->nama_pengguna->HrefValue = "";
		$this->nama_pengguna->TooltipValue = "";

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->LinkCustomAttributes = "";
		$this->nip_pengguna_anggaran->HrefValue = "";
		$this->nip_pengguna_anggaran->TooltipValue = "";

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

		// kode_rekening
		$this->kode_rekening->LinkCustomAttributes = "";
		$this->kode_rekening->HrefValue = "";
		$this->kode_rekening->TooltipValue = "";

		// pph21
		$this->pph21->LinkCustomAttributes = "";
		$this->pph21->HrefValue = "";
		$this->pph21->TooltipValue = "";

		// pph22
		$this->pph22->LinkCustomAttributes = "";
		$this->pph22->HrefValue = "";
		$this->pph22->TooltipValue = "";

		// pph23
		$this->pph23->LinkCustomAttributes = "";
		$this->pph23->HrefValue = "";
		$this->pph23->TooltipValue = "";

		// pph4
		$this->pph4->LinkCustomAttributes = "";
		$this->pph4->HrefValue = "";
		$this->pph4->TooltipValue = "";

		// jumlah_belanja
		$this->jumlah_belanja->LinkCustomAttributes = "";
		$this->jumlah_belanja->HrefValue = "";
		$this->jumlah_belanja->TooltipValue = "";

		// no_spj
		$this->no_spj->LinkCustomAttributes = "";
		$this->no_spj->HrefValue = "";
		$this->no_spj->TooltipValue = "";

		// tgl_spj
		$this->tgl_spj->LinkCustomAttributes = "";
		$this->tgl_spj->HrefValue = "";
		$this->tgl_spj->TooltipValue = "";

		// tahun_anggaran
		$this->tahun_anggaran->LinkCustomAttributes = "";
		$this->tahun_anggaran->HrefValue = "";
		$this->tahun_anggaran->TooltipValue = "";

		// kode_opd
		$this->kode_opd->LinkCustomAttributes = "";
		$this->kode_opd->HrefValue = "";
		$this->kode_opd->TooltipValue = "";

		// ppn
		$this->ppn->LinkCustomAttributes = "";
		$this->ppn->HrefValue = "";
		$this->ppn->TooltipValue = "";

		// nama_bendahara_pengeluaran
		$this->nama_bendahara_pengeluaran->LinkCustomAttributes = "";
		$this->nama_bendahara_pengeluaran->HrefValue = "";
		$this->nama_bendahara_pengeluaran->TooltipValue = "";

		// nip_bendahara_pengeluaran
		$this->nip_bendahara_pengeluaran->LinkCustomAttributes = "";
		$this->nip_bendahara_pengeluaran->HrefValue = "";
		$this->nip_bendahara_pengeluaran->TooltipValue = "";

		// status_spj
		$this->status_spj->LinkCustomAttributes = "";
		$this->status_spj->HrefValue = "";
		$this->status_spj->TooltipValue = "";

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

		// tipe
		$this->tipe->EditAttrs["class"] = "form-control";
		$this->tipe->EditCustomAttributes = "";
		$this->tipe->EditValue = $this->tipe->Options(TRUE);

		// tipe_sbp
		$this->tipe_sbp->EditAttrs["class"] = "form-control";
		$this->tipe_sbp->EditCustomAttributes = "";
		$this->tipe_sbp->EditValue = $this->tipe_sbp->Options(TRUE);

		// no_sbp
		$this->no_sbp->EditAttrs["class"] = "form-control";
		$this->no_sbp->EditCustomAttributes = "";
		$this->no_sbp->EditValue = $this->no_sbp->CurrentValue;
		$this->no_sbp->PlaceHolder = ew_RemoveHtml($this->no_sbp->FldCaption());

		// tgl_sbp
		$this->tgl_sbp->EditAttrs["class"] = "form-control";
		$this->tgl_sbp->EditCustomAttributes = "";
		$this->tgl_sbp->EditValue = ew_FormatDateTime($this->tgl_sbp->CurrentValue, 7);
		$this->tgl_sbp->PlaceHolder = ew_RemoveHtml($this->tgl_sbp->FldCaption());

		// program
		$this->program->EditAttrs["class"] = "form-control";
		$this->program->EditCustomAttributes = "";

		// kegiatan
		$this->kegiatan->EditAttrs["class"] = "form-control";
		$this->kegiatan->EditCustomAttributes = "";

		// sub_kegiatan
		$this->sub_kegiatan->EditAttrs["class"] = "form-control";
		$this->sub_kegiatan->EditCustomAttributes = "";

		// uraian
		$this->uraian->EditAttrs["class"] = "form-control";
		$this->uraian->EditCustomAttributes = "";
		$this->uraian->EditValue = $this->uraian->CurrentValue;
		$this->uraian->PlaceHolder = ew_RemoveHtml($this->uraian->FldCaption());

		// nama_penerima
		$this->nama_penerima->EditAttrs["class"] = "form-control";
		$this->nama_penerima->EditCustomAttributes = "";
		$this->nama_penerima->EditValue = $this->nama_penerima->CurrentValue;
		$this->nama_penerima->PlaceHolder = ew_RemoveHtml($this->nama_penerima->FldCaption());

		// alamat_penerima
		$this->alamat_penerima->EditAttrs["class"] = "form-control";
		$this->alamat_penerima->EditCustomAttributes = "";
		$this->alamat_penerima->EditValue = $this->alamat_penerima->CurrentValue;
		$this->alamat_penerima->PlaceHolder = ew_RemoveHtml($this->alamat_penerima->FldCaption());

		// nama_pptk
		$this->nama_pptk->EditAttrs["class"] = "form-control";
		$this->nama_pptk->EditCustomAttributes = "";

		// nip_pptk
		$this->nip_pptk->EditAttrs["class"] = "form-control";
		$this->nip_pptk->EditCustomAttributes = "";
		$this->nip_pptk->EditValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->PlaceHolder = ew_RemoveHtml($this->nip_pptk->FldCaption());

		// nama_pengguna
		$this->nama_pengguna->EditAttrs["class"] = "form-control";
		$this->nama_pengguna->EditCustomAttributes = "";

		// nip_pengguna_anggaran
		$this->nip_pengguna_anggaran->EditAttrs["class"] = "form-control";
		$this->nip_pengguna_anggaran->EditCustomAttributes = "";
		$this->nip_pengguna_anggaran->EditValue = $this->nip_pengguna_anggaran->CurrentValue;
		$this->nip_pengguna_anggaran->PlaceHolder = ew_RemoveHtml($this->nip_pengguna_anggaran->FldCaption());

		// akun1
		$this->akun1->EditAttrs["class"] = "form-control";
		$this->akun1->EditCustomAttributes = "";
		$this->akun1->EditValue = $this->akun1->CurrentValue;
		$this->akun1->PlaceHolder = ew_RemoveHtml($this->akun1->FldCaption());

		// akun2
		$this->akun2->EditAttrs["class"] = "form-control";
		$this->akun2->EditCustomAttributes = "";

		// akun3
		$this->akun3->EditAttrs["class"] = "form-control";
		$this->akun3->EditCustomAttributes = "";

		// akun4
		$this->akun4->EditAttrs["class"] = "form-control";
		$this->akun4->EditCustomAttributes = "";

		// akun5
		$this->akun5->EditAttrs["class"] = "form-control";
		$this->akun5->EditCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->EditAttrs["class"] = "form-control";
		$this->kode_rekening->EditCustomAttributes = "";
		$this->kode_rekening->EditValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->PlaceHolder = ew_RemoveHtml($this->kode_rekening->FldCaption());

		// pph21
		$this->pph21->EditAttrs["class"] = "form-control";
		$this->pph21->EditCustomAttributes = "";
		$this->pph21->EditValue = $this->pph21->CurrentValue;
		$this->pph21->PlaceHolder = ew_RemoveHtml($this->pph21->FldCaption());

		// pph22
		$this->pph22->EditAttrs["class"] = "form-control";
		$this->pph22->EditCustomAttributes = "";
		$this->pph22->EditValue = $this->pph22->CurrentValue;
		$this->pph22->PlaceHolder = ew_RemoveHtml($this->pph22->FldCaption());

		// pph23
		$this->pph23->EditAttrs["class"] = "form-control";
		$this->pph23->EditCustomAttributes = "";
		$this->pph23->EditValue = $this->pph23->CurrentValue;
		$this->pph23->PlaceHolder = ew_RemoveHtml($this->pph23->FldCaption());

		// pph4
		$this->pph4->EditAttrs["class"] = "form-control";
		$this->pph4->EditCustomAttributes = "";
		$this->pph4->EditValue = $this->pph4->CurrentValue;
		$this->pph4->PlaceHolder = ew_RemoveHtml($this->pph4->FldCaption());

		// jumlah_belanja
		$this->jumlah_belanja->EditAttrs["class"] = "form-control";
		$this->jumlah_belanja->EditCustomAttributes = "";
		$this->jumlah_belanja->EditValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
		if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

		// no_spj
		$this->no_spj->EditAttrs["class"] = "form-control";
		$this->no_spj->EditCustomAttributes = "";
		$this->no_spj->EditValue = $this->no_spj->CurrentValue;
		$this->no_spj->PlaceHolder = ew_RemoveHtml($this->no_spj->FldCaption());

		// tgl_spj
		$this->tgl_spj->EditAttrs["class"] = "form-control";
		$this->tgl_spj->EditCustomAttributes = "";
		$this->tgl_spj->EditValue = ew_FormatDateTime($this->tgl_spj->CurrentValue, 8);
		$this->tgl_spj->PlaceHolder = ew_RemoveHtml($this->tgl_spj->FldCaption());

		// tahun_anggaran
		$this->tahun_anggaran->EditAttrs["class"] = "form-control";
		$this->tahun_anggaran->EditCustomAttributes = "";
		$this->tahun_anggaran->EditValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

		// kode_opd
		$this->kode_opd->EditAttrs["class"] = "form-control";
		$this->kode_opd->EditCustomAttributes = "";
		$this->kode_opd->EditValue = $this->kode_opd->CurrentValue;
		$this->kode_opd->PlaceHolder = ew_RemoveHtml($this->kode_opd->FldCaption());

		// ppn
		$this->ppn->EditAttrs["class"] = "form-control";
		$this->ppn->EditCustomAttributes = "";
		$this->ppn->EditValue = $this->ppn->CurrentValue;
		$this->ppn->PlaceHolder = ew_RemoveHtml($this->ppn->FldCaption());
		if (strval($this->ppn->EditValue) <> "" && is_numeric($this->ppn->EditValue)) $this->ppn->EditValue = ew_FormatNumber($this->ppn->EditValue, -2, -1, -2, 0);

		// nama_bendahara_pengeluaran
		$this->nama_bendahara_pengeluaran->EditAttrs["class"] = "form-control";
		$this->nama_bendahara_pengeluaran->EditCustomAttributes = "";
		$this->nama_bendahara_pengeluaran->EditValue = $this->nama_bendahara_pengeluaran->CurrentValue;
		$this->nama_bendahara_pengeluaran->PlaceHolder = ew_RemoveHtml($this->nama_bendahara_pengeluaran->FldCaption());

		// nip_bendahara_pengeluaran
		$this->nip_bendahara_pengeluaran->EditAttrs["class"] = "form-control";
		$this->nip_bendahara_pengeluaran->EditCustomAttributes = "";
		$this->nip_bendahara_pengeluaran->EditValue = $this->nip_bendahara_pengeluaran->CurrentValue;
		$this->nip_bendahara_pengeluaran->PlaceHolder = ew_RemoveHtml($this->nip_bendahara_pengeluaran->FldCaption());

		// status_spj
		$this->status_spj->EditAttrs["class"] = "form-control";
		$this->status_spj->EditCustomAttributes = "";
		$this->status_spj->EditValue = $this->status_spj->CurrentValue;
		$this->status_spj->PlaceHolder = ew_RemoveHtml($this->status_spj->FldCaption());

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
		if (preg_match('/^x(\d)*_nama_pptk$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `nip` AS FIELD0 FROM `m_pejabat_keuangan`";
			$sWhereWrk = "(`nama` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->nama_pptk->LookupFilters = array();
			$lookuptblfilter = "`jabatan`=4";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->nama_pptk, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->nip_pptk->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->nip_pptk->AutoFillOriginalValue) ? $this->nip_pptk->CurrentValue : $this->nip_pptk->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}
		if (preg_match('/^x(\d)*_nama_pengguna$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `nip` AS FIELD0 FROM `m_blud_rs`";
			$sWhereWrk = "(`direktur` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->nama_pengguna->LookupFilters = array();
			$this->Lookup_Selecting($this->nama_pengguna, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->nip_pengguna_anggaran->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->nip_pengguna_anggaran->AutoFillOriginalValue) ? $this->nip_pengguna_anggaran->CurrentValue : $this->nip_pengguna_anggaran->EditValue;
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

		$rsnew["no_sbp"] = GetNextNomerSBP();
		$rsnew["kode_rekening"] = $rsnew["akun1"].".".$rsnew["akun2"].".".$rsnew["akun3"].".".$rsnew["akun4"].".".$rsnew["akun5"];
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		ew_Execute("call simrs2012.update_sbp('".$rsnew["id"]."')");
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

		if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
			$this->no_sbp->CurrentValue = GetNextNomerSBP(); // trik
			$this->no_sbp->EditValue = $this->no_sbp->CurrentValue; // tampilkan

			//$this->no_sbp->ReadOnly = TRUE; // supaya tidak bisa diubah
		}

		// Kondisi saat form Tambah sedang dalam mode konfirmasi
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
			$this->no_sbp->ViewValue = $this->no_sbp->CurrentValue; // ambil dari mode sebelumnya
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
