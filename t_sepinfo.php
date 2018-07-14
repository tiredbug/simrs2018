<?php

// Global variable for table object
$t_sep = NULL;

//
// Table class for t_sep
//
class ct_sep extends cTable {
	var $id;
	var $nomer_sep;
	var $nomr;
	var $no_kartubpjs;
	var $jenis_layanan;
	var $tgl_sep;
	var $tgl_rujukan;
	var $kelas_rawat;
	var $no_rujukan;
	var $ppk_asal;
	var $nama_ppk;
	var $ppk_pelayanan;
	var $catatan;
	var $kode_diagnosaawal;
	var $nama_diagnosaawal;
	var $laka_lantas;
	var $lokasi_laka;
	var $user;
	var $nik;
	var $kode_politujuan;
	var $nama_politujuan;
	var $dpjp;
	var $idx;
	var $last_update;
	var $pasien_baru;
	var $cara_bayar;
	var $petugas_klaim;
	var $total_biaya_rs;
	var $total_biaya_rs_adjust;
	var $tgl_pulang;
	var $flag_proc;
	var $poli_eksekutif;
	var $cob;
	var $penjamin_laka;
	var $no_telp;
	var $status_kepesertaan_bpjs;
	var $faskes_id;
	var $nama_layanan;
	var $nama_kelas;
	var $table_source;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_sep';
		$this->TableName = 't_sep';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_sep`";
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
		$this->id = new cField('t_sep', 't_sep', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// nomer_sep
		$this->nomer_sep = new cField('t_sep', 't_sep', 'x_nomer_sep', 'nomer_sep', '`nomer_sep`', '`nomer_sep`', 200, -1, FALSE, '`nomer_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomer_sep->Sortable = TRUE; // Allow sort
		$this->fields['nomer_sep'] = &$this->nomer_sep;

		// nomr
		$this->nomr = new cField('t_sep', 't_sep', 'x_nomr', 'nomr', '`nomr`', '`nomr`', 200, -1, FALSE, '`nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomr->Sortable = TRUE; // Allow sort
		$this->fields['nomr'] = &$this->nomr;

		// no_kartubpjs
		$this->no_kartubpjs = new cField('t_sep', 't_sep', 'x_no_kartubpjs', 'no_kartubpjs', '`no_kartubpjs`', '`no_kartubpjs`', 200, -1, FALSE, '`no_kartubpjs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_kartubpjs->Sortable = TRUE; // Allow sort
		$this->fields['no_kartubpjs'] = &$this->no_kartubpjs;

		// jenis_layanan
		$this->jenis_layanan = new cField('t_sep', 't_sep', 'x_jenis_layanan', 'jenis_layanan', '`jenis_layanan`', '`jenis_layanan`', 3, -1, FALSE, '`jenis_layanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->jenis_layanan->Sortable = TRUE; // Allow sort
		$this->jenis_layanan->OptionCount = 2;
		$this->jenis_layanan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jenis_layanan'] = &$this->jenis_layanan;

		// tgl_sep
		$this->tgl_sep = new cField('t_sep', 't_sep', 'x_tgl_sep', 'tgl_sep', '`tgl_sep`', ew_CastDateFieldForLike('`tgl_sep`', 0, "DB"), 135, 0, FALSE, '`tgl_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_sep->Sortable = TRUE; // Allow sort
		$this->tgl_sep->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_sep'] = &$this->tgl_sep;

		// tgl_rujukan
		$this->tgl_rujukan = new cField('t_sep', 't_sep', 'x_tgl_rujukan', 'tgl_rujukan', '`tgl_rujukan`', ew_CastDateFieldForLike('`tgl_rujukan`', 0, "DB"), 135, 0, FALSE, '`tgl_rujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_rujukan->Sortable = TRUE; // Allow sort
		$this->tgl_rujukan->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_rujukan'] = &$this->tgl_rujukan;

		// kelas_rawat
		$this->kelas_rawat = new cField('t_sep', 't_sep', 'x_kelas_rawat', 'kelas_rawat', '`kelas_rawat`', '`kelas_rawat`', 3, -1, FALSE, '`kelas_rawat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kelas_rawat->Sortable = TRUE; // Allow sort
		$this->kelas_rawat->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kelas_rawat'] = &$this->kelas_rawat;

		// no_rujukan
		$this->no_rujukan = new cField('t_sep', 't_sep', 'x_no_rujukan', 'no_rujukan', '`no_rujukan`', '`no_rujukan`', 200, -1, FALSE, '`no_rujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_rujukan->Sortable = TRUE; // Allow sort
		$this->fields['no_rujukan'] = &$this->no_rujukan;

		// ppk_asal
		$this->ppk_asal = new cField('t_sep', 't_sep', 'x_ppk_asal', 'ppk_asal', '`ppk_asal`', '`ppk_asal`', 200, -1, FALSE, '`ppk_asal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ppk_asal->Sortable = TRUE; // Allow sort
		$this->fields['ppk_asal'] = &$this->ppk_asal;

		// nama_ppk
		$this->nama_ppk = new cField('t_sep', 't_sep', 'x_nama_ppk', 'nama_ppk', '`nama_ppk`', '`nama_ppk`', 200, -1, FALSE, '`nama_ppk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_ppk->Sortable = TRUE; // Allow sort
		$this->fields['nama_ppk'] = &$this->nama_ppk;

		// ppk_pelayanan
		$this->ppk_pelayanan = new cField('t_sep', 't_sep', 'x_ppk_pelayanan', 'ppk_pelayanan', '`ppk_pelayanan`', '`ppk_pelayanan`', 200, -1, FALSE, '`ppk_pelayanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ppk_pelayanan->Sortable = TRUE; // Allow sort
		$this->fields['ppk_pelayanan'] = &$this->ppk_pelayanan;

		// catatan
		$this->catatan = new cField('t_sep', 't_sep', 'x_catatan', 'catatan', '`catatan`', '`catatan`', 200, -1, FALSE, '`catatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->catatan->Sortable = TRUE; // Allow sort
		$this->fields['catatan'] = &$this->catatan;

		// kode_diagnosaawal
		$this->kode_diagnosaawal = new cField('t_sep', 't_sep', 'x_kode_diagnosaawal', 'kode_diagnosaawal', '`kode_diagnosaawal`', '`kode_diagnosaawal`', 200, -1, FALSE, '`kode_diagnosaawal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_diagnosaawal->Sortable = TRUE; // Allow sort
		$this->fields['kode_diagnosaawal'] = &$this->kode_diagnosaawal;

		// nama_diagnosaawal
		$this->nama_diagnosaawal = new cField('t_sep', 't_sep', 'x_nama_diagnosaawal', 'nama_diagnosaawal', '`nama_diagnosaawal`', '`nama_diagnosaawal`', 200, -1, FALSE, '`nama_diagnosaawal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_diagnosaawal->Sortable = TRUE; // Allow sort
		$this->fields['nama_diagnosaawal'] = &$this->nama_diagnosaawal;

		// laka_lantas
		$this->laka_lantas = new cField('t_sep', 't_sep', 'x_laka_lantas', 'laka_lantas', '`laka_lantas`', '`laka_lantas`', 3, -1, FALSE, '`laka_lantas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->laka_lantas->Sortable = TRUE; // Allow sort
		$this->laka_lantas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['laka_lantas'] = &$this->laka_lantas;

		// lokasi_laka
		$this->lokasi_laka = new cField('t_sep', 't_sep', 'x_lokasi_laka', 'lokasi_laka', '`lokasi_laka`', '`lokasi_laka`', 200, -1, FALSE, '`lokasi_laka`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lokasi_laka->Sortable = TRUE; // Allow sort
		$this->fields['lokasi_laka'] = &$this->lokasi_laka;

		// user
		$this->user = new cField('t_sep', 't_sep', 'x_user', 'user', '`user`', '`user`', 200, -1, FALSE, '`user`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user->Sortable = TRUE; // Allow sort
		$this->fields['user'] = &$this->user;

		// nik
		$this->nik = new cField('t_sep', 't_sep', 'x_nik', 'nik', '`nik`', '`nik`', 200, -1, FALSE, '`nik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nik->Sortable = TRUE; // Allow sort
		$this->fields['nik'] = &$this->nik;

		// kode_politujuan
		$this->kode_politujuan = new cField('t_sep', 't_sep', 'x_kode_politujuan', 'kode_politujuan', '`kode_politujuan`', '`kode_politujuan`', 200, -1, FALSE, '`kode_politujuan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_politujuan->Sortable = TRUE; // Allow sort
		$this->fields['kode_politujuan'] = &$this->kode_politujuan;

		// nama_politujuan
		$this->nama_politujuan = new cField('t_sep', 't_sep', 'x_nama_politujuan', 'nama_politujuan', '`nama_politujuan`', '`nama_politujuan`', 200, -1, FALSE, '`nama_politujuan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_politujuan->Sortable = TRUE; // Allow sort
		$this->fields['nama_politujuan'] = &$this->nama_politujuan;

		// dpjp
		$this->dpjp = new cField('t_sep', 't_sep', 'x_dpjp', 'dpjp', '`dpjp`', '`dpjp`', 3, -1, FALSE, '`dpjp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dpjp->Sortable = TRUE; // Allow sort
		$this->dpjp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dpjp'] = &$this->dpjp;

		// idx
		$this->idx = new cField('t_sep', 't_sep', 'x_idx', 'idx', '`idx`', '`idx`', 200, -1, FALSE, '`idx`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idx->Sortable = TRUE; // Allow sort
		$this->fields['idx'] = &$this->idx;

		// last_update
		$this->last_update = new cField('t_sep', 't_sep', 'x_last_update', 'last_update', '`last_update`', ew_CastDateFieldForLike('`last_update`', 0, "DB"), 135, 0, FALSE, '`last_update`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_update->Sortable = TRUE; // Allow sort
		$this->last_update->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['last_update'] = &$this->last_update;

		// pasien_baru
		$this->pasien_baru = new cField('t_sep', 't_sep', 'x_pasien_baru', 'pasien_baru', '`pasien_baru`', '`pasien_baru`', 3, -1, FALSE, '`pasien_baru`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_baru->Sortable = TRUE; // Allow sort
		$this->pasien_baru->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['pasien_baru'] = &$this->pasien_baru;

		// cara_bayar
		$this->cara_bayar = new cField('t_sep', 't_sep', 'x_cara_bayar', 'cara_bayar', '`cara_bayar`', '`cara_bayar`', 3, -1, FALSE, '`cara_bayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cara_bayar->Sortable = TRUE; // Allow sort
		$this->cara_bayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cara_bayar'] = &$this->cara_bayar;

		// petugas_klaim
		$this->petugas_klaim = new cField('t_sep', 't_sep', 'x_petugas_klaim', 'petugas_klaim', '`petugas_klaim`', '`petugas_klaim`', 200, -1, FALSE, '`petugas_klaim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->petugas_klaim->Sortable = TRUE; // Allow sort
		$this->fields['petugas_klaim'] = &$this->petugas_klaim;

		// total_biaya_rs
		$this->total_biaya_rs = new cField('t_sep', 't_sep', 'x_total_biaya_rs', 'total_biaya_rs', '`total_biaya_rs`', '`total_biaya_rs`', 5, -1, FALSE, '`total_biaya_rs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total_biaya_rs->Sortable = TRUE; // Allow sort
		$this->total_biaya_rs->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total_biaya_rs'] = &$this->total_biaya_rs;

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust = new cField('t_sep', 't_sep', 'x_total_biaya_rs_adjust', 'total_biaya_rs_adjust', '`total_biaya_rs_adjust`', '`total_biaya_rs_adjust`', 5, -1, FALSE, '`total_biaya_rs_adjust`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total_biaya_rs_adjust->Sortable = TRUE; // Allow sort
		$this->total_biaya_rs_adjust->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total_biaya_rs_adjust'] = &$this->total_biaya_rs_adjust;

		// tgl_pulang
		$this->tgl_pulang = new cField('t_sep', 't_sep', 'x_tgl_pulang', 'tgl_pulang', '`tgl_pulang`', ew_CastDateFieldForLike('`tgl_pulang`', 0, "DB"), 135, 0, FALSE, '`tgl_pulang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_pulang->Sortable = TRUE; // Allow sort
		$this->tgl_pulang->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_pulang'] = &$this->tgl_pulang;

		// flag_proc
		$this->flag_proc = new cField('t_sep', 't_sep', 'x_flag_proc', 'flag_proc', '`flag_proc`', '`flag_proc`', 3, -1, FALSE, '`flag_proc`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->flag_proc->Sortable = TRUE; // Allow sort
		$this->flag_proc->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['flag_proc'] = &$this->flag_proc;

		// poli_eksekutif
		$this->poli_eksekutif = new cField('t_sep', 't_sep', 'x_poli_eksekutif', 'poli_eksekutif', '`poli_eksekutif`', '`poli_eksekutif`', 200, -1, FALSE, '`poli_eksekutif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->poli_eksekutif->Sortable = TRUE; // Allow sort
		$this->poli_eksekutif->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['poli_eksekutif'] = &$this->poli_eksekutif;

		// cob
		$this->cob = new cField('t_sep', 't_sep', 'x_cob', 'cob', '`cob`', '`cob`', 3, -1, FALSE, '`cob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->cob->Sortable = TRUE; // Allow sort
		$this->cob->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cob'] = &$this->cob;

		// penjamin_laka
		$this->penjamin_laka = new cField('t_sep', 't_sep', 'x_penjamin_laka', 'penjamin_laka', '`penjamin_laka`', '`penjamin_laka`', 200, -1, FALSE, '`penjamin_laka`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->penjamin_laka->Sortable = TRUE; // Allow sort
		$this->penjamin_laka->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['penjamin_laka'] = &$this->penjamin_laka;

		// no_telp
		$this->no_telp = new cField('t_sep', 't_sep', 'x_no_telp', 'no_telp', '`no_telp`', '`no_telp`', 200, -1, FALSE, '`no_telp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_telp->Sortable = TRUE; // Allow sort
		$this->fields['no_telp'] = &$this->no_telp;

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs = new cField('t_sep', 't_sep', 'x_status_kepesertaan_bpjs', 'status_kepesertaan_bpjs', '`status_kepesertaan_bpjs`', '`status_kepesertaan_bpjs`', 200, -1, FALSE, '`status_kepesertaan_bpjs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_kepesertaan_bpjs->Sortable = TRUE; // Allow sort
		$this->fields['status_kepesertaan_bpjs'] = &$this->status_kepesertaan_bpjs;

		// faskes_id
		$this->faskes_id = new cField('t_sep', 't_sep', 'x_faskes_id', 'faskes_id', '`faskes_id`', '`faskes_id`', 3, -1, FALSE, '`faskes_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->faskes_id->Sortable = TRUE; // Allow sort
		$this->faskes_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['faskes_id'] = &$this->faskes_id;

		// nama_layanan
		$this->nama_layanan = new cField('t_sep', 't_sep', 'x_nama_layanan', 'nama_layanan', '`nama_layanan`', '`nama_layanan`', 200, -1, FALSE, '`nama_layanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_layanan->Sortable = TRUE; // Allow sort
		$this->fields['nama_layanan'] = &$this->nama_layanan;

		// nama_kelas
		$this->nama_kelas = new cField('t_sep', 't_sep', 'x_nama_kelas', 'nama_kelas', '`nama_kelas`', '`nama_kelas`', 200, -1, FALSE, '`nama_kelas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_kelas->Sortable = TRUE; // Allow sort
		$this->fields['nama_kelas'] = &$this->nama_kelas;

		// table_source
		$this->table_source = new cField('t_sep', 't_sep', 'x_table_source', 'table_source', '`table_source`', '`table_source`', 200, -1, FALSE, '`table_source`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->table_source->Sortable = TRUE; // Allow sort
		$this->fields['table_source'] = &$this->table_source;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_sep`";
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
			return "t_seplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_seplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_sepview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_sepview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_sepadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_sepadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_sepedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_sepadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_sepdelete.php", $this->UrlParm());
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
		$this->nomer_sep->setDbValue($rs->fields('nomer_sep'));
		$this->nomr->setDbValue($rs->fields('nomr'));
		$this->no_kartubpjs->setDbValue($rs->fields('no_kartubpjs'));
		$this->jenis_layanan->setDbValue($rs->fields('jenis_layanan'));
		$this->tgl_sep->setDbValue($rs->fields('tgl_sep'));
		$this->tgl_rujukan->setDbValue($rs->fields('tgl_rujukan'));
		$this->kelas_rawat->setDbValue($rs->fields('kelas_rawat'));
		$this->no_rujukan->setDbValue($rs->fields('no_rujukan'));
		$this->ppk_asal->setDbValue($rs->fields('ppk_asal'));
		$this->nama_ppk->setDbValue($rs->fields('nama_ppk'));
		$this->ppk_pelayanan->setDbValue($rs->fields('ppk_pelayanan'));
		$this->catatan->setDbValue($rs->fields('catatan'));
		$this->kode_diagnosaawal->setDbValue($rs->fields('kode_diagnosaawal'));
		$this->nama_diagnosaawal->setDbValue($rs->fields('nama_diagnosaawal'));
		$this->laka_lantas->setDbValue($rs->fields('laka_lantas'));
		$this->lokasi_laka->setDbValue($rs->fields('lokasi_laka'));
		$this->user->setDbValue($rs->fields('user'));
		$this->nik->setDbValue($rs->fields('nik'));
		$this->kode_politujuan->setDbValue($rs->fields('kode_politujuan'));
		$this->nama_politujuan->setDbValue($rs->fields('nama_politujuan'));
		$this->dpjp->setDbValue($rs->fields('dpjp'));
		$this->idx->setDbValue($rs->fields('idx'));
		$this->last_update->setDbValue($rs->fields('last_update'));
		$this->pasien_baru->setDbValue($rs->fields('pasien_baru'));
		$this->cara_bayar->setDbValue($rs->fields('cara_bayar'));
		$this->petugas_klaim->setDbValue($rs->fields('petugas_klaim'));
		$this->total_biaya_rs->setDbValue($rs->fields('total_biaya_rs'));
		$this->total_biaya_rs_adjust->setDbValue($rs->fields('total_biaya_rs_adjust'));
		$this->tgl_pulang->setDbValue($rs->fields('tgl_pulang'));
		$this->flag_proc->setDbValue($rs->fields('flag_proc'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->cob->setDbValue($rs->fields('cob'));
		$this->penjamin_laka->setDbValue($rs->fields('penjamin_laka'));
		$this->no_telp->setDbValue($rs->fields('no_telp'));
		$this->status_kepesertaan_bpjs->setDbValue($rs->fields('status_kepesertaan_bpjs'));
		$this->faskes_id->setDbValue($rs->fields('faskes_id'));
		$this->nama_layanan->setDbValue($rs->fields('nama_layanan'));
		$this->nama_kelas->setDbValue($rs->fields('nama_kelas'));
		$this->table_source->setDbValue($rs->fields('table_source'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// nomer_sep
		// nomr
		// no_kartubpjs
		// jenis_layanan
		// tgl_sep
		// tgl_rujukan
		// kelas_rawat
		// no_rujukan
		// ppk_asal
		// nama_ppk
		// ppk_pelayanan
		// catatan
		// kode_diagnosaawal
		// nama_diagnosaawal
		// laka_lantas
		// lokasi_laka
		// user
		// nik
		// kode_politujuan
		// nama_politujuan
		// dpjp
		// idx
		// last_update
		// pasien_baru
		// cara_bayar
		// petugas_klaim
		// total_biaya_rs
		// total_biaya_rs_adjust
		// tgl_pulang
		// flag_proc
		// poli_eksekutif
		// cob
		// penjamin_laka
		// no_telp
		// status_kepesertaan_bpjs
		// faskes_id
		// nama_layanan
		// nama_kelas
		// table_source
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// nomer_sep
		$this->nomer_sep->ViewValue = $this->nomer_sep->CurrentValue;
		$this->nomer_sep->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		$this->nomr->ViewCustomAttributes = "";

		// no_kartubpjs
		$this->no_kartubpjs->ViewValue = $this->no_kartubpjs->CurrentValue;
		$this->no_kartubpjs->ViewCustomAttributes = "";

		// jenis_layanan
		if (strval($this->jenis_layanan->CurrentValue) <> "") {
			$this->jenis_layanan->ViewValue = $this->jenis_layanan->OptionCaption($this->jenis_layanan->CurrentValue);
		} else {
			$this->jenis_layanan->ViewValue = NULL;
		}
		$this->jenis_layanan->ViewCustomAttributes = "";

		// tgl_sep
		$this->tgl_sep->ViewValue = $this->tgl_sep->CurrentValue;
		$this->tgl_sep->ViewValue = ew_FormatDateTime($this->tgl_sep->ViewValue, 0);
		$this->tgl_sep->ViewCustomAttributes = "";

		// tgl_rujukan
		$this->tgl_rujukan->ViewValue = $this->tgl_rujukan->CurrentValue;
		$this->tgl_rujukan->ViewValue = ew_FormatDateTime($this->tgl_rujukan->ViewValue, 0);
		$this->tgl_rujukan->ViewCustomAttributes = "";

		// kelas_rawat
		$this->kelas_rawat->ViewValue = $this->kelas_rawat->CurrentValue;
		$this->kelas_rawat->ViewCustomAttributes = "";

		// no_rujukan
		$this->no_rujukan->ViewValue = $this->no_rujukan->CurrentValue;
		$this->no_rujukan->ViewCustomAttributes = "";

		// ppk_asal
		$this->ppk_asal->ViewValue = $this->ppk_asal->CurrentValue;
		$this->ppk_asal->ViewCustomAttributes = "";

		// nama_ppk
		$this->nama_ppk->ViewValue = $this->nama_ppk->CurrentValue;
		$this->nama_ppk->ViewCustomAttributes = "";

		// ppk_pelayanan
		$this->ppk_pelayanan->ViewValue = $this->ppk_pelayanan->CurrentValue;
		$this->ppk_pelayanan->ViewCustomAttributes = "";

		// catatan
		$this->catatan->ViewValue = $this->catatan->CurrentValue;
		$this->catatan->ViewCustomAttributes = "";

		// kode_diagnosaawal
		$this->kode_diagnosaawal->ViewValue = $this->kode_diagnosaawal->CurrentValue;
		$this->kode_diagnosaawal->ViewCustomAttributes = "";

		// nama_diagnosaawal
		$this->nama_diagnosaawal->ViewValue = $this->nama_diagnosaawal->CurrentValue;
		$this->nama_diagnosaawal->ViewCustomAttributes = "";

		// laka_lantas
		$this->laka_lantas->ViewValue = $this->laka_lantas->CurrentValue;
		$this->laka_lantas->ViewCustomAttributes = "";

		// lokasi_laka
		$this->lokasi_laka->ViewValue = $this->lokasi_laka->CurrentValue;
		$this->lokasi_laka->ViewCustomAttributes = "";

		// user
		$this->user->ViewValue = $this->user->CurrentValue;
		$this->user->ViewCustomAttributes = "";

		// nik
		$this->nik->ViewValue = $this->nik->CurrentValue;
		$this->nik->ViewCustomAttributes = "";

		// kode_politujuan
		$this->kode_politujuan->ViewValue = $this->kode_politujuan->CurrentValue;
		$this->kode_politujuan->ViewCustomAttributes = "";

		// nama_politujuan
		$this->nama_politujuan->ViewValue = $this->nama_politujuan->CurrentValue;
		$this->nama_politujuan->ViewCustomAttributes = "";

		// dpjp
		$this->dpjp->ViewValue = $this->dpjp->CurrentValue;
		$this->dpjp->ViewCustomAttributes = "";

		// idx
		$this->idx->ViewValue = $this->idx->CurrentValue;
		$this->idx->ViewCustomAttributes = "";

		// last_update
		$this->last_update->ViewValue = $this->last_update->CurrentValue;
		$this->last_update->ViewValue = ew_FormatDateTime($this->last_update->ViewValue, 0);
		$this->last_update->ViewCustomAttributes = "";

		// pasien_baru
		$this->pasien_baru->ViewValue = $this->pasien_baru->CurrentValue;
		$this->pasien_baru->ViewCustomAttributes = "";

		// cara_bayar
		$this->cara_bayar->ViewValue = $this->cara_bayar->CurrentValue;
		$this->cara_bayar->ViewCustomAttributes = "";

		// petugas_klaim
		$this->petugas_klaim->ViewValue = $this->petugas_klaim->CurrentValue;
		$this->petugas_klaim->ViewCustomAttributes = "";

		// total_biaya_rs
		$this->total_biaya_rs->ViewValue = $this->total_biaya_rs->CurrentValue;
		$this->total_biaya_rs->ViewCustomAttributes = "";

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust->ViewValue = $this->total_biaya_rs_adjust->CurrentValue;
		$this->total_biaya_rs_adjust->ViewCustomAttributes = "";

		// tgl_pulang
		$this->tgl_pulang->ViewValue = $this->tgl_pulang->CurrentValue;
		$this->tgl_pulang->ViewValue = ew_FormatDateTime($this->tgl_pulang->ViewValue, 0);
		$this->tgl_pulang->ViewCustomAttributes = "";

		// flag_proc
		$this->flag_proc->ViewValue = $this->flag_proc->CurrentValue;
		$this->flag_proc->ViewCustomAttributes = "";

		// poli_eksekutif
		$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// cob
		$this->cob->ViewValue = $this->cob->CurrentValue;
		$this->cob->ViewCustomAttributes = "";

		// penjamin_laka
		$this->penjamin_laka->ViewValue = $this->penjamin_laka->CurrentValue;
		$this->penjamin_laka->ViewCustomAttributes = "";

		// no_telp
		$this->no_telp->ViewValue = $this->no_telp->CurrentValue;
		$this->no_telp->ViewCustomAttributes = "";

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->ViewValue = $this->status_kepesertaan_bpjs->CurrentValue;
		$this->status_kepesertaan_bpjs->ViewCustomAttributes = "";

		// faskes_id
		$this->faskes_id->ViewValue = $this->faskes_id->CurrentValue;
		$this->faskes_id->ViewCustomAttributes = "";

		// nama_layanan
		$this->nama_layanan->ViewValue = $this->nama_layanan->CurrentValue;
		$this->nama_layanan->ViewCustomAttributes = "";

		// nama_kelas
		$this->nama_kelas->ViewValue = $this->nama_kelas->CurrentValue;
		$this->nama_kelas->ViewCustomAttributes = "";

		// table_source
		$this->table_source->ViewValue = $this->table_source->CurrentValue;
		$this->table_source->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// nomer_sep
		$this->nomer_sep->LinkCustomAttributes = "";
		$this->nomer_sep->HrefValue = "";
		$this->nomer_sep->TooltipValue = "";

		// nomr
		$this->nomr->LinkCustomAttributes = "";
		$this->nomr->HrefValue = "";
		$this->nomr->TooltipValue = "";

		// no_kartubpjs
		$this->no_kartubpjs->LinkCustomAttributes = "";
		$this->no_kartubpjs->HrefValue = "";
		$this->no_kartubpjs->TooltipValue = "";

		// jenis_layanan
		$this->jenis_layanan->LinkCustomAttributes = "";
		$this->jenis_layanan->HrefValue = "";
		$this->jenis_layanan->TooltipValue = "";

		// tgl_sep
		$this->tgl_sep->LinkCustomAttributes = "";
		$this->tgl_sep->HrefValue = "";
		$this->tgl_sep->TooltipValue = "";

		// tgl_rujukan
		$this->tgl_rujukan->LinkCustomAttributes = "";
		$this->tgl_rujukan->HrefValue = "";
		$this->tgl_rujukan->TooltipValue = "";

		// kelas_rawat
		$this->kelas_rawat->LinkCustomAttributes = "";
		$this->kelas_rawat->HrefValue = "";
		$this->kelas_rawat->TooltipValue = "";

		// no_rujukan
		$this->no_rujukan->LinkCustomAttributes = "";
		$this->no_rujukan->HrefValue = "";
		$this->no_rujukan->TooltipValue = "";

		// ppk_asal
		$this->ppk_asal->LinkCustomAttributes = "";
		$this->ppk_asal->HrefValue = "";
		$this->ppk_asal->TooltipValue = "";

		// nama_ppk
		$this->nama_ppk->LinkCustomAttributes = "";
		$this->nama_ppk->HrefValue = "";
		$this->nama_ppk->TooltipValue = "";

		// ppk_pelayanan
		$this->ppk_pelayanan->LinkCustomAttributes = "";
		$this->ppk_pelayanan->HrefValue = "";
		$this->ppk_pelayanan->TooltipValue = "";

		// catatan
		$this->catatan->LinkCustomAttributes = "";
		$this->catatan->HrefValue = "";
		$this->catatan->TooltipValue = "";

		// kode_diagnosaawal
		$this->kode_diagnosaawal->LinkCustomAttributes = "";
		$this->kode_diagnosaawal->HrefValue = "";
		$this->kode_diagnosaawal->TooltipValue = "";

		// nama_diagnosaawal
		$this->nama_diagnosaawal->LinkCustomAttributes = "";
		$this->nama_diagnosaawal->HrefValue = "";
		$this->nama_diagnosaawal->TooltipValue = "";

		// laka_lantas
		$this->laka_lantas->LinkCustomAttributes = "";
		$this->laka_lantas->HrefValue = "";
		$this->laka_lantas->TooltipValue = "";

		// lokasi_laka
		$this->lokasi_laka->LinkCustomAttributes = "";
		$this->lokasi_laka->HrefValue = "";
		$this->lokasi_laka->TooltipValue = "";

		// user
		$this->user->LinkCustomAttributes = "";
		$this->user->HrefValue = "";
		$this->user->TooltipValue = "";

		// nik
		$this->nik->LinkCustomAttributes = "";
		$this->nik->HrefValue = "";
		$this->nik->TooltipValue = "";

		// kode_politujuan
		$this->kode_politujuan->LinkCustomAttributes = "";
		$this->kode_politujuan->HrefValue = "";
		$this->kode_politujuan->TooltipValue = "";

		// nama_politujuan
		$this->nama_politujuan->LinkCustomAttributes = "";
		$this->nama_politujuan->HrefValue = "";
		$this->nama_politujuan->TooltipValue = "";

		// dpjp
		$this->dpjp->LinkCustomAttributes = "";
		$this->dpjp->HrefValue = "";
		$this->dpjp->TooltipValue = "";

		// idx
		$this->idx->LinkCustomAttributes = "";
		$this->idx->HrefValue = "";
		$this->idx->TooltipValue = "";

		// last_update
		$this->last_update->LinkCustomAttributes = "";
		$this->last_update->HrefValue = "";
		$this->last_update->TooltipValue = "";

		// pasien_baru
		$this->pasien_baru->LinkCustomAttributes = "";
		$this->pasien_baru->HrefValue = "";
		$this->pasien_baru->TooltipValue = "";

		// cara_bayar
		$this->cara_bayar->LinkCustomAttributes = "";
		$this->cara_bayar->HrefValue = "";
		$this->cara_bayar->TooltipValue = "";

		// petugas_klaim
		$this->petugas_klaim->LinkCustomAttributes = "";
		$this->petugas_klaim->HrefValue = "";
		$this->petugas_klaim->TooltipValue = "";

		// total_biaya_rs
		$this->total_biaya_rs->LinkCustomAttributes = "";
		$this->total_biaya_rs->HrefValue = "";
		$this->total_biaya_rs->TooltipValue = "";

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust->LinkCustomAttributes = "";
		$this->total_biaya_rs_adjust->HrefValue = "";
		$this->total_biaya_rs_adjust->TooltipValue = "";

		// tgl_pulang
		$this->tgl_pulang->LinkCustomAttributes = "";
		$this->tgl_pulang->HrefValue = "";
		$this->tgl_pulang->TooltipValue = "";

		// flag_proc
		$this->flag_proc->LinkCustomAttributes = "";
		$this->flag_proc->HrefValue = "";
		$this->flag_proc->TooltipValue = "";

		// poli_eksekutif
		$this->poli_eksekutif->LinkCustomAttributes = "";
		$this->poli_eksekutif->HrefValue = "";
		$this->poli_eksekutif->TooltipValue = "";

		// cob
		$this->cob->LinkCustomAttributes = "";
		$this->cob->HrefValue = "";
		$this->cob->TooltipValue = "";

		// penjamin_laka
		$this->penjamin_laka->LinkCustomAttributes = "";
		$this->penjamin_laka->HrefValue = "";
		$this->penjamin_laka->TooltipValue = "";

		// no_telp
		$this->no_telp->LinkCustomAttributes = "";
		$this->no_telp->HrefValue = "";
		$this->no_telp->TooltipValue = "";

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->LinkCustomAttributes = "";
		$this->status_kepesertaan_bpjs->HrefValue = "";
		$this->status_kepesertaan_bpjs->TooltipValue = "";

		// faskes_id
		$this->faskes_id->LinkCustomAttributes = "";
		$this->faskes_id->HrefValue = "";
		$this->faskes_id->TooltipValue = "";

		// nama_layanan
		$this->nama_layanan->LinkCustomAttributes = "";
		$this->nama_layanan->HrefValue = "";
		$this->nama_layanan->TooltipValue = "";

		// nama_kelas
		$this->nama_kelas->LinkCustomAttributes = "";
		$this->nama_kelas->HrefValue = "";
		$this->nama_kelas->TooltipValue = "";

		// table_source
		$this->table_source->LinkCustomAttributes = "";
		$this->table_source->HrefValue = "";
		$this->table_source->TooltipValue = "";

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

		// nomer_sep
		$this->nomer_sep->EditAttrs["class"] = "form-control";
		$this->nomer_sep->EditCustomAttributes = "";
		$this->nomer_sep->EditValue = $this->nomer_sep->CurrentValue;
		$this->nomer_sep->PlaceHolder = ew_RemoveHtml($this->nomer_sep->FldCaption());

		// nomr
		$this->nomr->EditAttrs["class"] = "form-control";
		$this->nomr->EditCustomAttributes = "";
		$this->nomr->EditValue = $this->nomr->CurrentValue;
		$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());

		// no_kartubpjs
		$this->no_kartubpjs->EditAttrs["class"] = "form-control";
		$this->no_kartubpjs->EditCustomAttributes = "";
		$this->no_kartubpjs->EditValue = $this->no_kartubpjs->CurrentValue;
		$this->no_kartubpjs->PlaceHolder = ew_RemoveHtml($this->no_kartubpjs->FldCaption());

		// jenis_layanan
		$this->jenis_layanan->EditCustomAttributes = "";
		$this->jenis_layanan->EditValue = $this->jenis_layanan->Options(FALSE);

		// tgl_sep
		$this->tgl_sep->EditAttrs["class"] = "form-control";
		$this->tgl_sep->EditCustomAttributes = "";
		$this->tgl_sep->EditValue = ew_FormatDateTime($this->tgl_sep->CurrentValue, 8);
		$this->tgl_sep->PlaceHolder = ew_RemoveHtml($this->tgl_sep->FldCaption());

		// tgl_rujukan
		$this->tgl_rujukan->EditAttrs["class"] = "form-control";
		$this->tgl_rujukan->EditCustomAttributes = "";
		$this->tgl_rujukan->EditValue = ew_FormatDateTime($this->tgl_rujukan->CurrentValue, 8);
		$this->tgl_rujukan->PlaceHolder = ew_RemoveHtml($this->tgl_rujukan->FldCaption());

		// kelas_rawat
		$this->kelas_rawat->EditAttrs["class"] = "form-control";
		$this->kelas_rawat->EditCustomAttributes = "";
		$this->kelas_rawat->EditValue = $this->kelas_rawat->CurrentValue;
		$this->kelas_rawat->PlaceHolder = ew_RemoveHtml($this->kelas_rawat->FldCaption());

		// no_rujukan
		$this->no_rujukan->EditAttrs["class"] = "form-control";
		$this->no_rujukan->EditCustomAttributes = "";
		$this->no_rujukan->EditValue = $this->no_rujukan->CurrentValue;
		$this->no_rujukan->PlaceHolder = ew_RemoveHtml($this->no_rujukan->FldCaption());

		// ppk_asal
		$this->ppk_asal->EditAttrs["class"] = "form-control";
		$this->ppk_asal->EditCustomAttributes = "";
		$this->ppk_asal->EditValue = $this->ppk_asal->CurrentValue;
		$this->ppk_asal->PlaceHolder = ew_RemoveHtml($this->ppk_asal->FldCaption());

		// nama_ppk
		$this->nama_ppk->EditAttrs["class"] = "form-control";
		$this->nama_ppk->EditCustomAttributes = "";
		$this->nama_ppk->EditValue = $this->nama_ppk->CurrentValue;
		$this->nama_ppk->PlaceHolder = ew_RemoveHtml($this->nama_ppk->FldCaption());

		// ppk_pelayanan
		$this->ppk_pelayanan->EditAttrs["class"] = "form-control";
		$this->ppk_pelayanan->EditCustomAttributes = "";
		$this->ppk_pelayanan->EditValue = $this->ppk_pelayanan->CurrentValue;
		$this->ppk_pelayanan->PlaceHolder = ew_RemoveHtml($this->ppk_pelayanan->FldCaption());

		// catatan
		$this->catatan->EditAttrs["class"] = "form-control";
		$this->catatan->EditCustomAttributes = "";
		$this->catatan->EditValue = $this->catatan->CurrentValue;
		$this->catatan->PlaceHolder = ew_RemoveHtml($this->catatan->FldCaption());

		// kode_diagnosaawal
		$this->kode_diagnosaawal->EditAttrs["class"] = "form-control";
		$this->kode_diagnosaawal->EditCustomAttributes = "";
		$this->kode_diagnosaawal->EditValue = $this->kode_diagnosaawal->CurrentValue;
		$this->kode_diagnosaawal->PlaceHolder = ew_RemoveHtml($this->kode_diagnosaawal->FldCaption());

		// nama_diagnosaawal
		$this->nama_diagnosaawal->EditAttrs["class"] = "form-control";
		$this->nama_diagnosaawal->EditCustomAttributes = "";
		$this->nama_diagnosaawal->EditValue = $this->nama_diagnosaawal->CurrentValue;
		$this->nama_diagnosaawal->PlaceHolder = ew_RemoveHtml($this->nama_diagnosaawal->FldCaption());

		// laka_lantas
		$this->laka_lantas->EditAttrs["class"] = "form-control";
		$this->laka_lantas->EditCustomAttributes = "";
		$this->laka_lantas->EditValue = $this->laka_lantas->CurrentValue;
		$this->laka_lantas->PlaceHolder = ew_RemoveHtml($this->laka_lantas->FldCaption());

		// lokasi_laka
		$this->lokasi_laka->EditAttrs["class"] = "form-control";
		$this->lokasi_laka->EditCustomAttributes = "";
		$this->lokasi_laka->EditValue = $this->lokasi_laka->CurrentValue;
		$this->lokasi_laka->PlaceHolder = ew_RemoveHtml($this->lokasi_laka->FldCaption());

		// user
		$this->user->EditAttrs["class"] = "form-control";
		$this->user->EditCustomAttributes = "";
		$this->user->EditValue = $this->user->CurrentValue;
		$this->user->PlaceHolder = ew_RemoveHtml($this->user->FldCaption());

		// nik
		$this->nik->EditAttrs["class"] = "form-control";
		$this->nik->EditCustomAttributes = "";
		$this->nik->EditValue = $this->nik->CurrentValue;
		$this->nik->PlaceHolder = ew_RemoveHtml($this->nik->FldCaption());

		// kode_politujuan
		$this->kode_politujuan->EditAttrs["class"] = "form-control";
		$this->kode_politujuan->EditCustomAttributes = "";
		$this->kode_politujuan->EditValue = $this->kode_politujuan->CurrentValue;
		$this->kode_politujuan->PlaceHolder = ew_RemoveHtml($this->kode_politujuan->FldCaption());

		// nama_politujuan
		$this->nama_politujuan->EditAttrs["class"] = "form-control";
		$this->nama_politujuan->EditCustomAttributes = "";
		$this->nama_politujuan->EditValue = $this->nama_politujuan->CurrentValue;
		$this->nama_politujuan->PlaceHolder = ew_RemoveHtml($this->nama_politujuan->FldCaption());

		// dpjp
		$this->dpjp->EditAttrs["class"] = "form-control";
		$this->dpjp->EditCustomAttributes = "";
		$this->dpjp->EditValue = $this->dpjp->CurrentValue;
		$this->dpjp->PlaceHolder = ew_RemoveHtml($this->dpjp->FldCaption());

		// idx
		$this->idx->EditAttrs["class"] = "form-control";
		$this->idx->EditCustomAttributes = "";
		$this->idx->EditValue = $this->idx->CurrentValue;
		$this->idx->PlaceHolder = ew_RemoveHtml($this->idx->FldCaption());

		// last_update
		$this->last_update->EditAttrs["class"] = "form-control";
		$this->last_update->EditCustomAttributes = "";
		$this->last_update->EditValue = ew_FormatDateTime($this->last_update->CurrentValue, 8);
		$this->last_update->PlaceHolder = ew_RemoveHtml($this->last_update->FldCaption());

		// pasien_baru
		$this->pasien_baru->EditAttrs["class"] = "form-control";
		$this->pasien_baru->EditCustomAttributes = "";
		$this->pasien_baru->EditValue = $this->pasien_baru->CurrentValue;
		$this->pasien_baru->PlaceHolder = ew_RemoveHtml($this->pasien_baru->FldCaption());

		// cara_bayar
		$this->cara_bayar->EditAttrs["class"] = "form-control";
		$this->cara_bayar->EditCustomAttributes = "";
		$this->cara_bayar->EditValue = $this->cara_bayar->CurrentValue;
		$this->cara_bayar->PlaceHolder = ew_RemoveHtml($this->cara_bayar->FldCaption());

		// petugas_klaim
		$this->petugas_klaim->EditAttrs["class"] = "form-control";
		$this->petugas_klaim->EditCustomAttributes = "";
		$this->petugas_klaim->EditValue = $this->petugas_klaim->CurrentValue;
		$this->petugas_klaim->PlaceHolder = ew_RemoveHtml($this->petugas_klaim->FldCaption());

		// total_biaya_rs
		$this->total_biaya_rs->EditAttrs["class"] = "form-control";
		$this->total_biaya_rs->EditCustomAttributes = "";
		$this->total_biaya_rs->EditValue = $this->total_biaya_rs->CurrentValue;
		$this->total_biaya_rs->PlaceHolder = ew_RemoveHtml($this->total_biaya_rs->FldCaption());
		if (strval($this->total_biaya_rs->EditValue) <> "" && is_numeric($this->total_biaya_rs->EditValue)) $this->total_biaya_rs->EditValue = ew_FormatNumber($this->total_biaya_rs->EditValue, -2, -1, -2, 0);

		// total_biaya_rs_adjust
		$this->total_biaya_rs_adjust->EditAttrs["class"] = "form-control";
		$this->total_biaya_rs_adjust->EditCustomAttributes = "";
		$this->total_biaya_rs_adjust->EditValue = $this->total_biaya_rs_adjust->CurrentValue;
		$this->total_biaya_rs_adjust->PlaceHolder = ew_RemoveHtml($this->total_biaya_rs_adjust->FldCaption());
		if (strval($this->total_biaya_rs_adjust->EditValue) <> "" && is_numeric($this->total_biaya_rs_adjust->EditValue)) $this->total_biaya_rs_adjust->EditValue = ew_FormatNumber($this->total_biaya_rs_adjust->EditValue, -2, -1, -2, 0);

		// tgl_pulang
		$this->tgl_pulang->EditAttrs["class"] = "form-control";
		$this->tgl_pulang->EditCustomAttributes = "";
		$this->tgl_pulang->EditValue = ew_FormatDateTime($this->tgl_pulang->CurrentValue, 8);
		$this->tgl_pulang->PlaceHolder = ew_RemoveHtml($this->tgl_pulang->FldCaption());

		// flag_proc
		$this->flag_proc->EditAttrs["class"] = "form-control";
		$this->flag_proc->EditCustomAttributes = "";
		$this->flag_proc->EditValue = $this->flag_proc->CurrentValue;
		$this->flag_proc->PlaceHolder = ew_RemoveHtml($this->flag_proc->FldCaption());

		// poli_eksekutif
		$this->poli_eksekutif->EditAttrs["class"] = "form-control";
		$this->poli_eksekutif->EditCustomAttributes = "";
		$this->poli_eksekutif->EditValue = $this->poli_eksekutif->CurrentValue;
		$this->poli_eksekutif->PlaceHolder = ew_RemoveHtml($this->poli_eksekutif->FldCaption());

		// cob
		$this->cob->EditAttrs["class"] = "form-control";
		$this->cob->EditCustomAttributes = "";
		$this->cob->EditValue = $this->cob->CurrentValue;
		$this->cob->PlaceHolder = ew_RemoveHtml($this->cob->FldCaption());

		// penjamin_laka
		$this->penjamin_laka->EditAttrs["class"] = "form-control";
		$this->penjamin_laka->EditCustomAttributes = "";
		$this->penjamin_laka->EditValue = $this->penjamin_laka->CurrentValue;
		$this->penjamin_laka->PlaceHolder = ew_RemoveHtml($this->penjamin_laka->FldCaption());

		// no_telp
		$this->no_telp->EditAttrs["class"] = "form-control";
		$this->no_telp->EditCustomAttributes = "";
		$this->no_telp->EditValue = $this->no_telp->CurrentValue;
		$this->no_telp->PlaceHolder = ew_RemoveHtml($this->no_telp->FldCaption());

		// status_kepesertaan_bpjs
		$this->status_kepesertaan_bpjs->EditAttrs["class"] = "form-control";
		$this->status_kepesertaan_bpjs->EditCustomAttributes = "";
		$this->status_kepesertaan_bpjs->EditValue = $this->status_kepesertaan_bpjs->CurrentValue;
		$this->status_kepesertaan_bpjs->PlaceHolder = ew_RemoveHtml($this->status_kepesertaan_bpjs->FldCaption());

		// faskes_id
		$this->faskes_id->EditAttrs["class"] = "form-control";
		$this->faskes_id->EditCustomAttributes = "";
		$this->faskes_id->EditValue = $this->faskes_id->CurrentValue;
		$this->faskes_id->PlaceHolder = ew_RemoveHtml($this->faskes_id->FldCaption());

		// nama_layanan
		$this->nama_layanan->EditAttrs["class"] = "form-control";
		$this->nama_layanan->EditCustomAttributes = "";
		$this->nama_layanan->EditValue = $this->nama_layanan->CurrentValue;
		$this->nama_layanan->PlaceHolder = ew_RemoveHtml($this->nama_layanan->FldCaption());

		// nama_kelas
		$this->nama_kelas->EditAttrs["class"] = "form-control";
		$this->nama_kelas->EditCustomAttributes = "";
		$this->nama_kelas->EditValue = $this->nama_kelas->CurrentValue;
		$this->nama_kelas->PlaceHolder = ew_RemoveHtml($this->nama_kelas->FldCaption());

		// table_source
		$this->table_source->EditAttrs["class"] = "form-control";
		$this->table_source->EditCustomAttributes = "";
		$this->table_source->EditValue = $this->table_source->CurrentValue;
		$this->table_source->PlaceHolder = ew_RemoveHtml($this->table_source->FldCaption());

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
					if ($this->nomer_sep->Exportable) $Doc->ExportCaption($this->nomer_sep);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->no_kartubpjs->Exportable) $Doc->ExportCaption($this->no_kartubpjs);
					if ($this->jenis_layanan->Exportable) $Doc->ExportCaption($this->jenis_layanan);
					if ($this->tgl_sep->Exportable) $Doc->ExportCaption($this->tgl_sep);
					if ($this->tgl_rujukan->Exportable) $Doc->ExportCaption($this->tgl_rujukan);
					if ($this->kelas_rawat->Exportable) $Doc->ExportCaption($this->kelas_rawat);
					if ($this->no_rujukan->Exportable) $Doc->ExportCaption($this->no_rujukan);
					if ($this->ppk_asal->Exportable) $Doc->ExportCaption($this->ppk_asal);
					if ($this->nama_ppk->Exportable) $Doc->ExportCaption($this->nama_ppk);
					if ($this->ppk_pelayanan->Exportable) $Doc->ExportCaption($this->ppk_pelayanan);
					if ($this->catatan->Exportable) $Doc->ExportCaption($this->catatan);
					if ($this->kode_diagnosaawal->Exportable) $Doc->ExportCaption($this->kode_diagnosaawal);
					if ($this->nama_diagnosaawal->Exportable) $Doc->ExportCaption($this->nama_diagnosaawal);
					if ($this->laka_lantas->Exportable) $Doc->ExportCaption($this->laka_lantas);
					if ($this->lokasi_laka->Exportable) $Doc->ExportCaption($this->lokasi_laka);
					if ($this->user->Exportable) $Doc->ExportCaption($this->user);
					if ($this->nik->Exportable) $Doc->ExportCaption($this->nik);
					if ($this->kode_politujuan->Exportable) $Doc->ExportCaption($this->kode_politujuan);
					if ($this->nama_politujuan->Exportable) $Doc->ExportCaption($this->nama_politujuan);
					if ($this->dpjp->Exportable) $Doc->ExportCaption($this->dpjp);
					if ($this->idx->Exportable) $Doc->ExportCaption($this->idx);
					if ($this->last_update->Exportable) $Doc->ExportCaption($this->last_update);
					if ($this->pasien_baru->Exportable) $Doc->ExportCaption($this->pasien_baru);
					if ($this->cara_bayar->Exportable) $Doc->ExportCaption($this->cara_bayar);
					if ($this->petugas_klaim->Exportable) $Doc->ExportCaption($this->petugas_klaim);
					if ($this->total_biaya_rs->Exportable) $Doc->ExportCaption($this->total_biaya_rs);
					if ($this->total_biaya_rs_adjust->Exportable) $Doc->ExportCaption($this->total_biaya_rs_adjust);
					if ($this->tgl_pulang->Exportable) $Doc->ExportCaption($this->tgl_pulang);
					if ($this->flag_proc->Exportable) $Doc->ExportCaption($this->flag_proc);
					if ($this->poli_eksekutif->Exportable) $Doc->ExportCaption($this->poli_eksekutif);
					if ($this->cob->Exportable) $Doc->ExportCaption($this->cob);
					if ($this->penjamin_laka->Exportable) $Doc->ExportCaption($this->penjamin_laka);
					if ($this->no_telp->Exportable) $Doc->ExportCaption($this->no_telp);
					if ($this->status_kepesertaan_bpjs->Exportable) $Doc->ExportCaption($this->status_kepesertaan_bpjs);
					if ($this->faskes_id->Exportable) $Doc->ExportCaption($this->faskes_id);
					if ($this->nama_layanan->Exportable) $Doc->ExportCaption($this->nama_layanan);
					if ($this->nama_kelas->Exportable) $Doc->ExportCaption($this->nama_kelas);
					if ($this->table_source->Exportable) $Doc->ExportCaption($this->table_source);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->nomer_sep->Exportable) $Doc->ExportCaption($this->nomer_sep);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->no_kartubpjs->Exportable) $Doc->ExportCaption($this->no_kartubpjs);
					if ($this->jenis_layanan->Exportable) $Doc->ExportCaption($this->jenis_layanan);
					if ($this->tgl_sep->Exportable) $Doc->ExportCaption($this->tgl_sep);
					if ($this->tgl_rujukan->Exportable) $Doc->ExportCaption($this->tgl_rujukan);
					if ($this->kelas_rawat->Exportable) $Doc->ExportCaption($this->kelas_rawat);
					if ($this->no_rujukan->Exportable) $Doc->ExportCaption($this->no_rujukan);
					if ($this->ppk_asal->Exportable) $Doc->ExportCaption($this->ppk_asal);
					if ($this->nama_ppk->Exportable) $Doc->ExportCaption($this->nama_ppk);
					if ($this->ppk_pelayanan->Exportable) $Doc->ExportCaption($this->ppk_pelayanan);
					if ($this->catatan->Exportable) $Doc->ExportCaption($this->catatan);
					if ($this->kode_diagnosaawal->Exportable) $Doc->ExportCaption($this->kode_diagnosaawal);
					if ($this->nama_diagnosaawal->Exportable) $Doc->ExportCaption($this->nama_diagnosaawal);
					if ($this->laka_lantas->Exportable) $Doc->ExportCaption($this->laka_lantas);
					if ($this->lokasi_laka->Exportable) $Doc->ExportCaption($this->lokasi_laka);
					if ($this->user->Exportable) $Doc->ExportCaption($this->user);
					if ($this->nik->Exportable) $Doc->ExportCaption($this->nik);
					if ($this->kode_politujuan->Exportable) $Doc->ExportCaption($this->kode_politujuan);
					if ($this->nama_politujuan->Exportable) $Doc->ExportCaption($this->nama_politujuan);
					if ($this->dpjp->Exportable) $Doc->ExportCaption($this->dpjp);
					if ($this->idx->Exportable) $Doc->ExportCaption($this->idx);
					if ($this->last_update->Exportable) $Doc->ExportCaption($this->last_update);
					if ($this->pasien_baru->Exportable) $Doc->ExportCaption($this->pasien_baru);
					if ($this->cara_bayar->Exportable) $Doc->ExportCaption($this->cara_bayar);
					if ($this->petugas_klaim->Exportable) $Doc->ExportCaption($this->petugas_klaim);
					if ($this->total_biaya_rs->Exportable) $Doc->ExportCaption($this->total_biaya_rs);
					if ($this->total_biaya_rs_adjust->Exportable) $Doc->ExportCaption($this->total_biaya_rs_adjust);
					if ($this->tgl_pulang->Exportable) $Doc->ExportCaption($this->tgl_pulang);
					if ($this->flag_proc->Exportable) $Doc->ExportCaption($this->flag_proc);
					if ($this->poli_eksekutif->Exportable) $Doc->ExportCaption($this->poli_eksekutif);
					if ($this->cob->Exportable) $Doc->ExportCaption($this->cob);
					if ($this->penjamin_laka->Exportable) $Doc->ExportCaption($this->penjamin_laka);
					if ($this->no_telp->Exportable) $Doc->ExportCaption($this->no_telp);
					if ($this->status_kepesertaan_bpjs->Exportable) $Doc->ExportCaption($this->status_kepesertaan_bpjs);
					if ($this->faskes_id->Exportable) $Doc->ExportCaption($this->faskes_id);
					if ($this->nama_layanan->Exportable) $Doc->ExportCaption($this->nama_layanan);
					if ($this->nama_kelas->Exportable) $Doc->ExportCaption($this->nama_kelas);
					if ($this->table_source->Exportable) $Doc->ExportCaption($this->table_source);
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
						if ($this->nomer_sep->Exportable) $Doc->ExportField($this->nomer_sep);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->no_kartubpjs->Exportable) $Doc->ExportField($this->no_kartubpjs);
						if ($this->jenis_layanan->Exportable) $Doc->ExportField($this->jenis_layanan);
						if ($this->tgl_sep->Exportable) $Doc->ExportField($this->tgl_sep);
						if ($this->tgl_rujukan->Exportable) $Doc->ExportField($this->tgl_rujukan);
						if ($this->kelas_rawat->Exportable) $Doc->ExportField($this->kelas_rawat);
						if ($this->no_rujukan->Exportable) $Doc->ExportField($this->no_rujukan);
						if ($this->ppk_asal->Exportable) $Doc->ExportField($this->ppk_asal);
						if ($this->nama_ppk->Exportable) $Doc->ExportField($this->nama_ppk);
						if ($this->ppk_pelayanan->Exportable) $Doc->ExportField($this->ppk_pelayanan);
						if ($this->catatan->Exportable) $Doc->ExportField($this->catatan);
						if ($this->kode_diagnosaawal->Exportable) $Doc->ExportField($this->kode_diagnosaawal);
						if ($this->nama_diagnosaawal->Exportable) $Doc->ExportField($this->nama_diagnosaawal);
						if ($this->laka_lantas->Exportable) $Doc->ExportField($this->laka_lantas);
						if ($this->lokasi_laka->Exportable) $Doc->ExportField($this->lokasi_laka);
						if ($this->user->Exportable) $Doc->ExportField($this->user);
						if ($this->nik->Exportable) $Doc->ExportField($this->nik);
						if ($this->kode_politujuan->Exportable) $Doc->ExportField($this->kode_politujuan);
						if ($this->nama_politujuan->Exportable) $Doc->ExportField($this->nama_politujuan);
						if ($this->dpjp->Exportable) $Doc->ExportField($this->dpjp);
						if ($this->idx->Exportable) $Doc->ExportField($this->idx);
						if ($this->last_update->Exportable) $Doc->ExportField($this->last_update);
						if ($this->pasien_baru->Exportable) $Doc->ExportField($this->pasien_baru);
						if ($this->cara_bayar->Exportable) $Doc->ExportField($this->cara_bayar);
						if ($this->petugas_klaim->Exportable) $Doc->ExportField($this->petugas_klaim);
						if ($this->total_biaya_rs->Exportable) $Doc->ExportField($this->total_biaya_rs);
						if ($this->total_biaya_rs_adjust->Exportable) $Doc->ExportField($this->total_biaya_rs_adjust);
						if ($this->tgl_pulang->Exportable) $Doc->ExportField($this->tgl_pulang);
						if ($this->flag_proc->Exportable) $Doc->ExportField($this->flag_proc);
						if ($this->poli_eksekutif->Exportable) $Doc->ExportField($this->poli_eksekutif);
						if ($this->cob->Exportable) $Doc->ExportField($this->cob);
						if ($this->penjamin_laka->Exportable) $Doc->ExportField($this->penjamin_laka);
						if ($this->no_telp->Exportable) $Doc->ExportField($this->no_telp);
						if ($this->status_kepesertaan_bpjs->Exportable) $Doc->ExportField($this->status_kepesertaan_bpjs);
						if ($this->faskes_id->Exportable) $Doc->ExportField($this->faskes_id);
						if ($this->nama_layanan->Exportable) $Doc->ExportField($this->nama_layanan);
						if ($this->nama_kelas->Exportable) $Doc->ExportField($this->nama_kelas);
						if ($this->table_source->Exportable) $Doc->ExportField($this->table_source);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->nomer_sep->Exportable) $Doc->ExportField($this->nomer_sep);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->no_kartubpjs->Exportable) $Doc->ExportField($this->no_kartubpjs);
						if ($this->jenis_layanan->Exportable) $Doc->ExportField($this->jenis_layanan);
						if ($this->tgl_sep->Exportable) $Doc->ExportField($this->tgl_sep);
						if ($this->tgl_rujukan->Exportable) $Doc->ExportField($this->tgl_rujukan);
						if ($this->kelas_rawat->Exportable) $Doc->ExportField($this->kelas_rawat);
						if ($this->no_rujukan->Exportable) $Doc->ExportField($this->no_rujukan);
						if ($this->ppk_asal->Exportable) $Doc->ExportField($this->ppk_asal);
						if ($this->nama_ppk->Exportable) $Doc->ExportField($this->nama_ppk);
						if ($this->ppk_pelayanan->Exportable) $Doc->ExportField($this->ppk_pelayanan);
						if ($this->catatan->Exportable) $Doc->ExportField($this->catatan);
						if ($this->kode_diagnosaawal->Exportable) $Doc->ExportField($this->kode_diagnosaawal);
						if ($this->nama_diagnosaawal->Exportable) $Doc->ExportField($this->nama_diagnosaawal);
						if ($this->laka_lantas->Exportable) $Doc->ExportField($this->laka_lantas);
						if ($this->lokasi_laka->Exportable) $Doc->ExportField($this->lokasi_laka);
						if ($this->user->Exportable) $Doc->ExportField($this->user);
						if ($this->nik->Exportable) $Doc->ExportField($this->nik);
						if ($this->kode_politujuan->Exportable) $Doc->ExportField($this->kode_politujuan);
						if ($this->nama_politujuan->Exportable) $Doc->ExportField($this->nama_politujuan);
						if ($this->dpjp->Exportable) $Doc->ExportField($this->dpjp);
						if ($this->idx->Exportable) $Doc->ExportField($this->idx);
						if ($this->last_update->Exportable) $Doc->ExportField($this->last_update);
						if ($this->pasien_baru->Exportable) $Doc->ExportField($this->pasien_baru);
						if ($this->cara_bayar->Exportable) $Doc->ExportField($this->cara_bayar);
						if ($this->petugas_klaim->Exportable) $Doc->ExportField($this->petugas_klaim);
						if ($this->total_biaya_rs->Exportable) $Doc->ExportField($this->total_biaya_rs);
						if ($this->total_biaya_rs_adjust->Exportable) $Doc->ExportField($this->total_biaya_rs_adjust);
						if ($this->tgl_pulang->Exportable) $Doc->ExportField($this->tgl_pulang);
						if ($this->flag_proc->Exportable) $Doc->ExportField($this->flag_proc);
						if ($this->poli_eksekutif->Exportable) $Doc->ExportField($this->poli_eksekutif);
						if ($this->cob->Exportable) $Doc->ExportField($this->cob);
						if ($this->penjamin_laka->Exportable) $Doc->ExportField($this->penjamin_laka);
						if ($this->no_telp->Exportable) $Doc->ExportField($this->no_telp);
						if ($this->status_kepesertaan_bpjs->Exportable) $Doc->ExportField($this->status_kepesertaan_bpjs);
						if ($this->faskes_id->Exportable) $Doc->ExportField($this->faskes_id);
						if ($this->nama_layanan->Exportable) $Doc->ExportField($this->nama_layanan);
						if ($this->nama_kelas->Exportable) $Doc->ExportField($this->nama_kelas);
						if ($this->table_source->Exportable) $Doc->ExportField($this->table_source);
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
