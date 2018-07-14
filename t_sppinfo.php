<?php

// Global variable for table object
$t_spp = NULL;

//
// Table class for t_spp
//
class ct_spp extends cTable {
	var $id;
	var $id_jenis_spp;
	var $detail_jenis_spp;
	var $status_spp;
	var $no_spp;
	var $tgl_spp;
	var $keterangan;
	var $jumlah_up;
	var $bendahara;
	var $nama_pptk;
	var $nip_pptk;
	var $status_spm;
	var $kode_kegiatan;
	var $kode_sub_kegiatan;
	var $tahun_anggaran;
	var $jumlah_spd;
	var $nomer_dasar_spd;
	var $tanggal_spd;
	var $id_spd;
	var $kode_program;
	var $kode_rekening;
	var $nama_bendahara;
	var $nip_bendahara;
	var $no_spm;
	var $tgl_spm;
	var $nama_bank;
	var $nomer_rekening_bank;
	var $npwp;
	var $pph21;
	var $pph22;
	var $pph23;
	var $pph4;
	var $jumlah_belanja;
	var $kontrak_id;
	var $akun1;
	var $akun2;
	var $akun3;
	var $akun4;
	var $akun5;
	var $pimpinan_blud;
	var $nip_pimpinan;
	var $opd;
	var $urusan_pemerintahan;
	var $tgl_sptb;
	var $no_sptb;
	var $status_advis;
	var $id_spj;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_spp';
		$this->TableName = 't_spp';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_spp`";
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
		$this->id = new cField('t_spp', 't_spp', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// id_jenis_spp
		$this->id_jenis_spp = new cField('t_spp', 't_spp', 'x_id_jenis_spp', 'id_jenis_spp', '`id_jenis_spp`', '`id_jenis_spp`', 3, -1, FALSE, '`id_jenis_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->id_jenis_spp->Sortable = TRUE; // Allow sort
		$this->id_jenis_spp->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->id_jenis_spp->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->id_jenis_spp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_jenis_spp'] = &$this->id_jenis_spp;

		// detail_jenis_spp
		$this->detail_jenis_spp = new cField('t_spp', 't_spp', 'x_detail_jenis_spp', 'detail_jenis_spp', '`detail_jenis_spp`', '`detail_jenis_spp`', 3, -1, FALSE, '`detail_jenis_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->detail_jenis_spp->Sortable = TRUE; // Allow sort
		$this->detail_jenis_spp->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->detail_jenis_spp->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->detail_jenis_spp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['detail_jenis_spp'] = &$this->detail_jenis_spp;

		// status_spp
		$this->status_spp = new cField('t_spp', 't_spp', 'x_status_spp', 'status_spp', '`status_spp`', '`status_spp`', 3, -1, FALSE, '`status_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->status_spp->Sortable = TRUE; // Allow sort
		$this->status_spp->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->status_spp->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->status_spp->OptionCount = 2;
		$this->status_spp->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_spp'] = &$this->status_spp;

		// no_spp
		$this->no_spp = new cField('t_spp', 't_spp', 'x_no_spp', 'no_spp', '`no_spp`', '`no_spp`', 200, -1, FALSE, '`no_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spp->Sortable = TRUE; // Allow sort
		$this->fields['no_spp'] = &$this->no_spp;

		// tgl_spp
		$this->tgl_spp = new cField('t_spp', 't_spp', 'x_tgl_spp', 'tgl_spp', '`tgl_spp`', ew_CastDateFieldForLike('`tgl_spp`', 7, "DB"), 135, 7, FALSE, '`tgl_spp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_spp->Sortable = TRUE; // Allow sort
		$this->tgl_spp->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tgl_spp'] = &$this->tgl_spp;

		// keterangan
		$this->keterangan = new cField('t_spp', 't_spp', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 201, -1, FALSE, '`keterangan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keterangan->Sortable = TRUE; // Allow sort
		$this->fields['keterangan'] = &$this->keterangan;

		// jumlah_up
		$this->jumlah_up = new cField('t_spp', 't_spp', 'x_jumlah_up', 'jumlah_up', '`jumlah_up`', '`jumlah_up`', 5, -1, FALSE, '`jumlah_up`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_up->Sortable = TRUE; // Allow sort
		$this->jumlah_up->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_up'] = &$this->jumlah_up;

		// bendahara
		$this->bendahara = new cField('t_spp', 't_spp', 'x_bendahara', 'bendahara', '`bendahara`', '`bendahara`', 3, -1, FALSE, '`bendahara`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bendahara->Sortable = TRUE; // Allow sort
		$this->bendahara->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bendahara'] = &$this->bendahara;

		// nama_pptk
		$this->nama_pptk = new cField('t_spp', 't_spp', 'x_nama_pptk', 'nama_pptk', '`nama_pptk`', '`nama_pptk`', 200, -1, FALSE, '`nama_pptk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_pptk->Sortable = TRUE; // Allow sort
		$this->fields['nama_pptk'] = &$this->nama_pptk;

		// nip_pptk
		$this->nip_pptk = new cField('t_spp', 't_spp', 'x_nip_pptk', 'nip_pptk', '`nip_pptk`', '`nip_pptk`', 200, -1, FALSE, '`nip_pptk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_pptk->Sortable = TRUE; // Allow sort
		$this->fields['nip_pptk'] = &$this->nip_pptk;

		// status_spm
		$this->status_spm = new cField('t_spp', 't_spp', 'x_status_spm', 'status_spm', '`status_spm`', '`status_spm`', 3, -1, FALSE, '`status_spm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_spm->Sortable = TRUE; // Allow sort
		$this->status_spm->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_spm'] = &$this->status_spm;

		// kode_kegiatan
		$this->kode_kegiatan = new cField('t_spp', 't_spp', 'x_kode_kegiatan', 'kode_kegiatan', '`kode_kegiatan`', '`kode_kegiatan`', 200, -1, FALSE, '`kode_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_kegiatan->Sortable = TRUE; // Allow sort
		$this->fields['kode_kegiatan'] = &$this->kode_kegiatan;

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan = new cField('t_spp', 't_spp', 'x_kode_sub_kegiatan', 'kode_sub_kegiatan', '`kode_sub_kegiatan`', '`kode_sub_kegiatan`', 200, -1, FALSE, '`kode_sub_kegiatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_sub_kegiatan->Sortable = TRUE; // Allow sort
		$this->fields['kode_sub_kegiatan'] = &$this->kode_sub_kegiatan;

		// tahun_anggaran
		$this->tahun_anggaran = new cField('t_spp', 't_spp', 'x_tahun_anggaran', 'tahun_anggaran', '`tahun_anggaran`', '`tahun_anggaran`', 3, -1, FALSE, '`tahun_anggaran`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun_anggaran->Sortable = TRUE; // Allow sort
		$this->tahun_anggaran->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tahun_anggaran'] = &$this->tahun_anggaran;

		// jumlah_spd
		$this->jumlah_spd = new cField('t_spp', 't_spp', 'x_jumlah_spd', 'jumlah_spd', '`jumlah_spd`', '`jumlah_spd`', 5, -1, FALSE, '`jumlah_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_spd->Sortable = TRUE; // Allow sort
		$this->jumlah_spd->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_spd'] = &$this->jumlah_spd;

		// nomer_dasar_spd
		$this->nomer_dasar_spd = new cField('t_spp', 't_spp', 'x_nomer_dasar_spd', 'nomer_dasar_spd', '`nomer_dasar_spd`', '`nomer_dasar_spd`', 200, -1, FALSE, '`nomer_dasar_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomer_dasar_spd->Sortable = TRUE; // Allow sort
		$this->fields['nomer_dasar_spd'] = &$this->nomer_dasar_spd;

		// tanggal_spd
		$this->tanggal_spd = new cField('t_spp', 't_spp', 'x_tanggal_spd', 'tanggal_spd', '`tanggal_spd`', ew_CastDateFieldForLike('`tanggal_spd`', 0, "DB"), 135, 0, FALSE, '`tanggal_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal_spd->Sortable = TRUE; // Allow sort
		$this->tanggal_spd->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tanggal_spd'] = &$this->tanggal_spd;

		// id_spd
		$this->id_spd = new cField('t_spp', 't_spp', 'x_id_spd', 'id_spd', '`id_spd`', '`id_spd`', 3, -1, FALSE, '`id_spd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_spd->Sortable = TRUE; // Allow sort
		$this->id_spd->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_spd'] = &$this->id_spd;

		// kode_program
		$this->kode_program = new cField('t_spp', 't_spp', 'x_kode_program', 'kode_program', '`kode_program`', '`kode_program`', 200, -1, FALSE, '`kode_program`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_program->Sortable = TRUE; // Allow sort
		$this->fields['kode_program'] = &$this->kode_program;

		// kode_rekening
		$this->kode_rekening = new cField('t_spp', 't_spp', 'x_kode_rekening', 'kode_rekening', '`kode_rekening`', '`kode_rekening`', 200, -1, FALSE, '`kode_rekening`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kode_rekening->Sortable = TRUE; // Allow sort
		$this->fields['kode_rekening'] = &$this->kode_rekening;

		// nama_bendahara
		$this->nama_bendahara = new cField('t_spp', 't_spp', 'x_nama_bendahara', 'nama_bendahara', '`nama_bendahara`', '`nama_bendahara`', 200, -1, FALSE, '`nama_bendahara`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_bendahara->Sortable = TRUE; // Allow sort
		$this->fields['nama_bendahara'] = &$this->nama_bendahara;

		// nip_bendahara
		$this->nip_bendahara = new cField('t_spp', 't_spp', 'x_nip_bendahara', 'nip_bendahara', '`nip_bendahara`', '`nip_bendahara`', 200, -1, FALSE, '`nip_bendahara`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_bendahara->Sortable = TRUE; // Allow sort
		$this->fields['nip_bendahara'] = &$this->nip_bendahara;

		// no_spm
		$this->no_spm = new cField('t_spp', 't_spp', 'x_no_spm', 'no_spm', '`no_spm`', '`no_spm`', 200, -1, FALSE, '`no_spm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_spm->Sortable = TRUE; // Allow sort
		$this->fields['no_spm'] = &$this->no_spm;

		// tgl_spm
		$this->tgl_spm = new cField('t_spp', 't_spp', 'x_tgl_spm', 'tgl_spm', '`tgl_spm`', ew_CastDateFieldForLike('`tgl_spm`', 0, "DB"), 135, -1, FALSE, '`tgl_spm`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_spm->Sortable = TRUE; // Allow sort
		$this->fields['tgl_spm'] = &$this->tgl_spm;

		// nama_bank
		$this->nama_bank = new cField('t_spp', 't_spp', 'x_nama_bank', 'nama_bank', '`nama_bank`', '`nama_bank`', 200, -1, FALSE, '`nama_bank`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_bank->Sortable = TRUE; // Allow sort
		$this->fields['nama_bank'] = &$this->nama_bank;

		// nomer_rekening_bank
		$this->nomer_rekening_bank = new cField('t_spp', 't_spp', 'x_nomer_rekening_bank', 'nomer_rekening_bank', '`nomer_rekening_bank`', '`nomer_rekening_bank`', 200, -1, FALSE, '`nomer_rekening_bank`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomer_rekening_bank->Sortable = TRUE; // Allow sort
		$this->fields['nomer_rekening_bank'] = &$this->nomer_rekening_bank;

		// npwp
		$this->npwp = new cField('t_spp', 't_spp', 'x_npwp', 'npwp', '`npwp`', '`npwp`', 200, -1, FALSE, '`npwp`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->npwp->Sortable = TRUE; // Allow sort
		$this->fields['npwp'] = &$this->npwp;

		// pph21
		$this->pph21 = new cField('t_spp', 't_spp', 'x_pph21', 'pph21', '`pph21`', '`pph21`', 5, -1, FALSE, '`pph21`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph21->Sortable = TRUE; // Allow sort
		$this->pph21->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pph21'] = &$this->pph21;

		// pph22
		$this->pph22 = new cField('t_spp', 't_spp', 'x_pph22', 'pph22', '`pph22`', '`pph22`', 5, -1, FALSE, '`pph22`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph22->Sortable = TRUE; // Allow sort
		$this->pph22->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pph22'] = &$this->pph22;

		// pph23
		$this->pph23 = new cField('t_spp', 't_spp', 'x_pph23', 'pph23', '`pph23`', '`pph23`', 5, -1, FALSE, '`pph23`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph23->Sortable = TRUE; // Allow sort
		$this->pph23->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pph23'] = &$this->pph23;

		// pph4
		$this->pph4 = new cField('t_spp', 't_spp', 'x_pph4', 'pph4', '`pph4`', '`pph4`', 5, -1, FALSE, '`pph4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pph4->Sortable = TRUE; // Allow sort
		$this->pph4->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pph4'] = &$this->pph4;

		// jumlah_belanja
		$this->jumlah_belanja = new cField('t_spp', 't_spp', 'x_jumlah_belanja', 'jumlah_belanja', '`jumlah_belanja`', '`jumlah_belanja`', 5, -1, FALSE, '`jumlah_belanja`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jumlah_belanja->Sortable = TRUE; // Allow sort
		$this->jumlah_belanja->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['jumlah_belanja'] = &$this->jumlah_belanja;

		// kontrak_id
		$this->kontrak_id = new cField('t_spp', 't_spp', 'x_kontrak_id', 'kontrak_id', '`kontrak_id`', '`kontrak_id`', 3, -1, FALSE, '`kontrak_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kontrak_id->Sortable = TRUE; // Allow sort
		$this->kontrak_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kontrak_id'] = &$this->kontrak_id;

		// akun1
		$this->akun1 = new cField('t_spp', 't_spp', 'x_akun1', 'akun1', '`akun1`', '`akun1`', 3, -1, FALSE, '`akun1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun1->Sortable = TRUE; // Allow sort
		$this->akun1->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['akun1'] = &$this->akun1;

		// akun2
		$this->akun2 = new cField('t_spp', 't_spp', 'x_akun2', 'akun2', '`akun2`', '`akun2`', 200, -1, FALSE, '`akun2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun2->Sortable = TRUE; // Allow sort
		$this->fields['akun2'] = &$this->akun2;

		// akun3
		$this->akun3 = new cField('t_spp', 't_spp', 'x_akun3', 'akun3', '`akun3`', '`akun3`', 200, -1, FALSE, '`akun3`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun3->Sortable = TRUE; // Allow sort
		$this->fields['akun3'] = &$this->akun3;

		// akun4
		$this->akun4 = new cField('t_spp', 't_spp', 'x_akun4', 'akun4', '`akun4`', '`akun4`', 200, -1, FALSE, '`akun4`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun4->Sortable = TRUE; // Allow sort
		$this->fields['akun4'] = &$this->akun4;

		// akun5
		$this->akun5 = new cField('t_spp', 't_spp', 'x_akun5', 'akun5', '`akun5`', '`akun5`', 200, -1, FALSE, '`akun5`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->akun5->Sortable = TRUE; // Allow sort
		$this->fields['akun5'] = &$this->akun5;

		// pimpinan_blud
		$this->pimpinan_blud = new cField('t_spp', 't_spp', 'x_pimpinan_blud', 'pimpinan_blud', '`pimpinan_blud`', '`pimpinan_blud`', 200, -1, FALSE, '`pimpinan_blud`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pimpinan_blud->Sortable = TRUE; // Allow sort
		$this->fields['pimpinan_blud'] = &$this->pimpinan_blud;

		// nip_pimpinan
		$this->nip_pimpinan = new cField('t_spp', 't_spp', 'x_nip_pimpinan', 'nip_pimpinan', '`nip_pimpinan`', '`nip_pimpinan`', 200, -1, FALSE, '`nip_pimpinan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nip_pimpinan->Sortable = TRUE; // Allow sort
		$this->fields['nip_pimpinan'] = &$this->nip_pimpinan;

		// opd
		$this->opd = new cField('t_spp', 't_spp', 'x_opd', 'opd', '`opd`', '`opd`', 200, -1, FALSE, '`opd`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->opd->Sortable = TRUE; // Allow sort
		$this->fields['opd'] = &$this->opd;

		// urusan_pemerintahan
		$this->urusan_pemerintahan = new cField('t_spp', 't_spp', 'x_urusan_pemerintahan', 'urusan_pemerintahan', '`urusan_pemerintahan`', '`urusan_pemerintahan`', 200, -1, FALSE, '`urusan_pemerintahan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->urusan_pemerintahan->Sortable = TRUE; // Allow sort
		$this->fields['urusan_pemerintahan'] = &$this->urusan_pemerintahan;

		// tgl_sptb
		$this->tgl_sptb = new cField('t_spp', 't_spp', 'x_tgl_sptb', 'tgl_sptb', '`tgl_sptb`', ew_CastDateFieldForLike('`tgl_sptb`', 0, "DB"), 135, 0, FALSE, '`tgl_sptb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_sptb->Sortable = TRUE; // Allow sort
		$this->tgl_sptb->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_sptb'] = &$this->tgl_sptb;

		// no_sptb
		$this->no_sptb = new cField('t_spp', 't_spp', 'x_no_sptb', 'no_sptb', '`no_sptb`', '`no_sptb`', 200, -1, FALSE, '`no_sptb`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->no_sptb->Sortable = TRUE; // Allow sort
		$this->fields['no_sptb'] = &$this->no_sptb;

		// status_advis
		$this->status_advis = new cField('t_spp', 't_spp', 'x_status_advis', 'status_advis', '`status_advis`', '`status_advis`', 3, -1, FALSE, '`status_advis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_advis->Sortable = TRUE; // Allow sort
		$this->status_advis->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_advis'] = &$this->status_advis;

		// id_spj
		$this->id_spj = new cField('t_spp', 't_spp', 'x_id_spj', 'id_spj', '`id_spj`', '`id_spj`', 3, -1, FALSE, '`id_spj`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_spj->Sortable = TRUE; // Allow sort
		$this->id_spj->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_spj'] = &$this->id_spj;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_spp`";
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
			return "t_spplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_spplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_sppview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_sppview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_sppadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_sppadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_sppedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_sppadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_sppdelete.php", $this->UrlParm());
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
		$this->keterangan->setDbValue($rs->fields('keterangan'));
		$this->jumlah_up->setDbValue($rs->fields('jumlah_up'));
		$this->bendahara->setDbValue($rs->fields('bendahara'));
		$this->nama_pptk->setDbValue($rs->fields('nama_pptk'));
		$this->nip_pptk->setDbValue($rs->fields('nip_pptk'));
		$this->status_spm->setDbValue($rs->fields('status_spm'));
		$this->kode_kegiatan->setDbValue($rs->fields('kode_kegiatan'));
		$this->kode_sub_kegiatan->setDbValue($rs->fields('kode_sub_kegiatan'));
		$this->tahun_anggaran->setDbValue($rs->fields('tahun_anggaran'));
		$this->jumlah_spd->setDbValue($rs->fields('jumlah_spd'));
		$this->nomer_dasar_spd->setDbValue($rs->fields('nomer_dasar_spd'));
		$this->tanggal_spd->setDbValue($rs->fields('tanggal_spd'));
		$this->id_spd->setDbValue($rs->fields('id_spd'));
		$this->kode_program->setDbValue($rs->fields('kode_program'));
		$this->kode_rekening->setDbValue($rs->fields('kode_rekening'));
		$this->nama_bendahara->setDbValue($rs->fields('nama_bendahara'));
		$this->nip_bendahara->setDbValue($rs->fields('nip_bendahara'));
		$this->no_spm->setDbValue($rs->fields('no_spm'));
		$this->tgl_spm->setDbValue($rs->fields('tgl_spm'));
		$this->nama_bank->setDbValue($rs->fields('nama_bank'));
		$this->nomer_rekening_bank->setDbValue($rs->fields('nomer_rekening_bank'));
		$this->npwp->setDbValue($rs->fields('npwp'));
		$this->pph21->setDbValue($rs->fields('pph21'));
		$this->pph22->setDbValue($rs->fields('pph22'));
		$this->pph23->setDbValue($rs->fields('pph23'));
		$this->pph4->setDbValue($rs->fields('pph4'));
		$this->jumlah_belanja->setDbValue($rs->fields('jumlah_belanja'));
		$this->kontrak_id->setDbValue($rs->fields('kontrak_id'));
		$this->akun1->setDbValue($rs->fields('akun1'));
		$this->akun2->setDbValue($rs->fields('akun2'));
		$this->akun3->setDbValue($rs->fields('akun3'));
		$this->akun4->setDbValue($rs->fields('akun4'));
		$this->akun5->setDbValue($rs->fields('akun5'));
		$this->pimpinan_blud->setDbValue($rs->fields('pimpinan_blud'));
		$this->nip_pimpinan->setDbValue($rs->fields('nip_pimpinan'));
		$this->opd->setDbValue($rs->fields('opd'));
		$this->urusan_pemerintahan->setDbValue($rs->fields('urusan_pemerintahan'));
		$this->tgl_sptb->setDbValue($rs->fields('tgl_sptb'));
		$this->no_sptb->setDbValue($rs->fields('no_sptb'));
		$this->status_advis->setDbValue($rs->fields('status_advis'));
		$this->id_spj->setDbValue($rs->fields('id_spj'));
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
		// keterangan
		// jumlah_up
		// bendahara
		// nama_pptk
		// nip_pptk
		// status_spm
		// kode_kegiatan
		// kode_sub_kegiatan
		// tahun_anggaran
		// jumlah_spd
		// nomer_dasar_spd
		// tanggal_spd
		// id_spd
		// kode_program
		// kode_rekening
		// nama_bendahara
		// nip_bendahara
		// no_spm
		// tgl_spm
		// nama_bank
		// nomer_rekening_bank
		// npwp
		// pph21
		// pph22
		// pph23
		// pph4
		// jumlah_belanja
		// kontrak_id
		// akun1
		// akun2
		// akun3
		// akun4
		// akun5
		// pimpinan_blud
		// nip_pimpinan
		// opd
		// urusan_pemerintahan
		// tgl_sptb
		// no_sptb
		// status_advis
		// id_spj
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// id_jenis_spp
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

		// keterangan
		$this->keterangan->ViewValue = $this->keterangan->CurrentValue;
		$this->keterangan->ViewCustomAttributes = "";

		// jumlah_up
		$this->jumlah_up->ViewValue = $this->jumlah_up->CurrentValue;
		$this->jumlah_up->ViewCustomAttributes = "";

		// bendahara
		$this->bendahara->ViewValue = $this->bendahara->CurrentValue;
		$this->bendahara->ViewCustomAttributes = "";

		// nama_pptk
		$this->nama_pptk->ViewValue = $this->nama_pptk->CurrentValue;
		$this->nama_pptk->ViewCustomAttributes = "";

		// nip_pptk
		$this->nip_pptk->ViewValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->ViewCustomAttributes = "";

		// status_spm
		$this->status_spm->ViewValue = $this->status_spm->CurrentValue;
		$this->status_spm->ViewCustomAttributes = "";

		// kode_kegiatan
		$this->kode_kegiatan->ViewValue = $this->kode_kegiatan->CurrentValue;
		$this->kode_kegiatan->ViewCustomAttributes = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->ViewValue = $this->kode_sub_kegiatan->CurrentValue;
		$this->kode_sub_kegiatan->ViewCustomAttributes = "";

		// tahun_anggaran
		$this->tahun_anggaran->ViewValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->ViewCustomAttributes = "";

		// jumlah_spd
		$this->jumlah_spd->ViewValue = $this->jumlah_spd->CurrentValue;
		$this->jumlah_spd->ViewCustomAttributes = "";

		// nomer_dasar_spd
		$this->nomer_dasar_spd->ViewValue = $this->nomer_dasar_spd->CurrentValue;
		$this->nomer_dasar_spd->ViewCustomAttributes = "";

		// tanggal_spd
		$this->tanggal_spd->ViewValue = $this->tanggal_spd->CurrentValue;
		$this->tanggal_spd->ViewValue = ew_FormatDateTime($this->tanggal_spd->ViewValue, 0);
		$this->tanggal_spd->ViewCustomAttributes = "";

		// id_spd
		$this->id_spd->ViewValue = $this->id_spd->CurrentValue;
		$this->id_spd->ViewCustomAttributes = "";

		// kode_program
		$this->kode_program->ViewValue = $this->kode_program->CurrentValue;
		$this->kode_program->ViewCustomAttributes = "";

		// kode_rekening
		$this->kode_rekening->ViewValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->ViewCustomAttributes = "";

		// nama_bendahara
		$this->nama_bendahara->ViewValue = $this->nama_bendahara->CurrentValue;
		$this->nama_bendahara->ViewCustomAttributes = "";

		// nip_bendahara
		$this->nip_bendahara->ViewValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->ViewCustomAttributes = "";

		// no_spm
		$this->no_spm->ViewValue = $this->no_spm->CurrentValue;
		$this->no_spm->ViewCustomAttributes = "";

		// tgl_spm
		$this->tgl_spm->ViewValue = $this->tgl_spm->CurrentValue;
		$this->tgl_spm->ViewCustomAttributes = "";

		// nama_bank
		$this->nama_bank->ViewValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->ViewCustomAttributes = "";

		// nomer_rekening_bank
		$this->nomer_rekening_bank->ViewValue = $this->nomer_rekening_bank->CurrentValue;
		$this->nomer_rekening_bank->ViewCustomAttributes = "";

		// npwp
		$this->npwp->ViewValue = $this->npwp->CurrentValue;
		$this->npwp->ViewCustomAttributes = "";

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

		// kontrak_id
		$this->kontrak_id->ViewValue = $this->kontrak_id->CurrentValue;
		$this->kontrak_id->ViewCustomAttributes = "";

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

		// pimpinan_blud
		$this->pimpinan_blud->ViewValue = $this->pimpinan_blud->CurrentValue;
		$this->pimpinan_blud->ViewCustomAttributes = "";

		// nip_pimpinan
		$this->nip_pimpinan->ViewValue = $this->nip_pimpinan->CurrentValue;
		$this->nip_pimpinan->ViewCustomAttributes = "";

		// opd
		$this->opd->ViewValue = $this->opd->CurrentValue;
		$this->opd->ViewCustomAttributes = "";

		// urusan_pemerintahan
		$this->urusan_pemerintahan->ViewValue = $this->urusan_pemerintahan->CurrentValue;
		$this->urusan_pemerintahan->ViewCustomAttributes = "";

		// tgl_sptb
		$this->tgl_sptb->ViewValue = $this->tgl_sptb->CurrentValue;
		$this->tgl_sptb->ViewValue = ew_FormatDateTime($this->tgl_sptb->ViewValue, 0);
		$this->tgl_sptb->ViewCustomAttributes = "";

		// no_sptb
		$this->no_sptb->ViewValue = $this->no_sptb->CurrentValue;
		$this->no_sptb->ViewCustomAttributes = "";

		// status_advis
		$this->status_advis->ViewValue = $this->status_advis->CurrentValue;
		$this->status_advis->ViewCustomAttributes = "";

		// id_spj
		$this->id_spj->ViewValue = $this->id_spj->CurrentValue;
		$this->id_spj->ViewCustomAttributes = "";

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

		// keterangan
		$this->keterangan->LinkCustomAttributes = "";
		$this->keterangan->HrefValue = "";
		$this->keterangan->TooltipValue = "";

		// jumlah_up
		$this->jumlah_up->LinkCustomAttributes = "";
		$this->jumlah_up->HrefValue = "";
		$this->jumlah_up->TooltipValue = "";

		// bendahara
		$this->bendahara->LinkCustomAttributes = "";
		$this->bendahara->HrefValue = "";
		$this->bendahara->TooltipValue = "";

		// nama_pptk
		$this->nama_pptk->LinkCustomAttributes = "";
		$this->nama_pptk->HrefValue = "";
		$this->nama_pptk->TooltipValue = "";

		// nip_pptk
		$this->nip_pptk->LinkCustomAttributes = "";
		$this->nip_pptk->HrefValue = "";
		$this->nip_pptk->TooltipValue = "";

		// status_spm
		$this->status_spm->LinkCustomAttributes = "";
		$this->status_spm->HrefValue = "";
		$this->status_spm->TooltipValue = "";

		// kode_kegiatan
		$this->kode_kegiatan->LinkCustomAttributes = "";
		$this->kode_kegiatan->HrefValue = "";
		$this->kode_kegiatan->TooltipValue = "";

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->LinkCustomAttributes = "";
		$this->kode_sub_kegiatan->HrefValue = "";
		$this->kode_sub_kegiatan->TooltipValue = "";

		// tahun_anggaran
		$this->tahun_anggaran->LinkCustomAttributes = "";
		$this->tahun_anggaran->HrefValue = "";
		$this->tahun_anggaran->TooltipValue = "";

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

		// id_spd
		$this->id_spd->LinkCustomAttributes = "";
		$this->id_spd->HrefValue = "";
		$this->id_spd->TooltipValue = "";

		// kode_program
		$this->kode_program->LinkCustomAttributes = "";
		$this->kode_program->HrefValue = "";
		$this->kode_program->TooltipValue = "";

		// kode_rekening
		$this->kode_rekening->LinkCustomAttributes = "";
		$this->kode_rekening->HrefValue = "";
		$this->kode_rekening->TooltipValue = "";

		// nama_bendahara
		$this->nama_bendahara->LinkCustomAttributes = "";
		$this->nama_bendahara->HrefValue = "";
		$this->nama_bendahara->TooltipValue = "";

		// nip_bendahara
		$this->nip_bendahara->LinkCustomAttributes = "";
		$this->nip_bendahara->HrefValue = "";
		$this->nip_bendahara->TooltipValue = "";

		// no_spm
		$this->no_spm->LinkCustomAttributes = "";
		$this->no_spm->HrefValue = "";
		$this->no_spm->TooltipValue = "";

		// tgl_spm
		$this->tgl_spm->LinkCustomAttributes = "";
		$this->tgl_spm->HrefValue = "";
		$this->tgl_spm->TooltipValue = "";

		// nama_bank
		$this->nama_bank->LinkCustomAttributes = "";
		$this->nama_bank->HrefValue = "";
		$this->nama_bank->TooltipValue = "";

		// nomer_rekening_bank
		$this->nomer_rekening_bank->LinkCustomAttributes = "";
		$this->nomer_rekening_bank->HrefValue = "";
		$this->nomer_rekening_bank->TooltipValue = "";

		// npwp
		$this->npwp->LinkCustomAttributes = "";
		$this->npwp->HrefValue = "";
		$this->npwp->TooltipValue = "";

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

		// kontrak_id
		$this->kontrak_id->LinkCustomAttributes = "";
		$this->kontrak_id->HrefValue = "";
		$this->kontrak_id->TooltipValue = "";

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

		// pimpinan_blud
		$this->pimpinan_blud->LinkCustomAttributes = "";
		$this->pimpinan_blud->HrefValue = "";
		$this->pimpinan_blud->TooltipValue = "";

		// nip_pimpinan
		$this->nip_pimpinan->LinkCustomAttributes = "";
		$this->nip_pimpinan->HrefValue = "";
		$this->nip_pimpinan->TooltipValue = "";

		// opd
		$this->opd->LinkCustomAttributes = "";
		$this->opd->HrefValue = "";
		$this->opd->TooltipValue = "";

		// urusan_pemerintahan
		$this->urusan_pemerintahan->LinkCustomAttributes = "";
		$this->urusan_pemerintahan->HrefValue = "";
		$this->urusan_pemerintahan->TooltipValue = "";

		// tgl_sptb
		$this->tgl_sptb->LinkCustomAttributes = "";
		$this->tgl_sptb->HrefValue = "";
		$this->tgl_sptb->TooltipValue = "";

		// no_sptb
		$this->no_sptb->LinkCustomAttributes = "";
		$this->no_sptb->HrefValue = "";
		$this->no_sptb->TooltipValue = "";

		// status_advis
		$this->status_advis->LinkCustomAttributes = "";
		$this->status_advis->HrefValue = "";
		$this->status_advis->TooltipValue = "";

		// id_spj
		$this->id_spj->LinkCustomAttributes = "";
		$this->id_spj->HrefValue = "";
		$this->id_spj->TooltipValue = "";

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

		// detail_jenis_spp
		$this->detail_jenis_spp->EditAttrs["class"] = "form-control";
		$this->detail_jenis_spp->EditCustomAttributes = "";

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

		// keterangan
		$this->keterangan->EditAttrs["class"] = "form-control";
		$this->keterangan->EditCustomAttributes = "";
		$this->keterangan->EditValue = $this->keterangan->CurrentValue;
		$this->keterangan->PlaceHolder = ew_RemoveHtml($this->keterangan->FldCaption());

		// jumlah_up
		$this->jumlah_up->EditAttrs["class"] = "form-control";
		$this->jumlah_up->EditCustomAttributes = "";
		$this->jumlah_up->EditValue = $this->jumlah_up->CurrentValue;
		$this->jumlah_up->PlaceHolder = ew_RemoveHtml($this->jumlah_up->FldCaption());
		if (strval($this->jumlah_up->EditValue) <> "" && is_numeric($this->jumlah_up->EditValue)) $this->jumlah_up->EditValue = ew_FormatNumber($this->jumlah_up->EditValue, -2, -1, -2, 0);

		// bendahara
		$this->bendahara->EditAttrs["class"] = "form-control";
		$this->bendahara->EditCustomAttributes = "";
		$this->bendahara->EditValue = $this->bendahara->CurrentValue;
		$this->bendahara->PlaceHolder = ew_RemoveHtml($this->bendahara->FldCaption());

		// nama_pptk
		$this->nama_pptk->EditAttrs["class"] = "form-control";
		$this->nama_pptk->EditCustomAttributes = "";
		$this->nama_pptk->EditValue = $this->nama_pptk->CurrentValue;
		$this->nama_pptk->PlaceHolder = ew_RemoveHtml($this->nama_pptk->FldCaption());

		// nip_pptk
		$this->nip_pptk->EditAttrs["class"] = "form-control";
		$this->nip_pptk->EditCustomAttributes = "";
		$this->nip_pptk->EditValue = $this->nip_pptk->CurrentValue;
		$this->nip_pptk->PlaceHolder = ew_RemoveHtml($this->nip_pptk->FldCaption());

		// status_spm
		$this->status_spm->EditAttrs["class"] = "form-control";
		$this->status_spm->EditCustomAttributes = "";
		$this->status_spm->EditValue = $this->status_spm->CurrentValue;
		$this->status_spm->PlaceHolder = ew_RemoveHtml($this->status_spm->FldCaption());

		// kode_kegiatan
		$this->kode_kegiatan->EditAttrs["class"] = "form-control";
		$this->kode_kegiatan->EditCustomAttributes = "";
		$this->kode_kegiatan->EditValue = $this->kode_kegiatan->CurrentValue;
		$this->kode_kegiatan->PlaceHolder = ew_RemoveHtml($this->kode_kegiatan->FldCaption());

		// kode_sub_kegiatan
		$this->kode_sub_kegiatan->EditAttrs["class"] = "form-control";
		$this->kode_sub_kegiatan->EditCustomAttributes = "";
		$this->kode_sub_kegiatan->EditValue = $this->kode_sub_kegiatan->CurrentValue;
		$this->kode_sub_kegiatan->PlaceHolder = ew_RemoveHtml($this->kode_sub_kegiatan->FldCaption());

		// tahun_anggaran
		$this->tahun_anggaran->EditAttrs["class"] = "form-control";
		$this->tahun_anggaran->EditCustomAttributes = "";
		$this->tahun_anggaran->EditValue = $this->tahun_anggaran->CurrentValue;
		$this->tahun_anggaran->PlaceHolder = ew_RemoveHtml($this->tahun_anggaran->FldCaption());

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
		$this->tanggal_spd->EditValue = ew_FormatDateTime($this->tanggal_spd->CurrentValue, 8);
		$this->tanggal_spd->PlaceHolder = ew_RemoveHtml($this->tanggal_spd->FldCaption());

		// id_spd
		$this->id_spd->EditAttrs["class"] = "form-control";
		$this->id_spd->EditCustomAttributes = "";
		$this->id_spd->EditValue = $this->id_spd->CurrentValue;
		$this->id_spd->PlaceHolder = ew_RemoveHtml($this->id_spd->FldCaption());

		// kode_program
		$this->kode_program->EditAttrs["class"] = "form-control";
		$this->kode_program->EditCustomAttributes = "";
		$this->kode_program->EditValue = $this->kode_program->CurrentValue;
		$this->kode_program->PlaceHolder = ew_RemoveHtml($this->kode_program->FldCaption());

		// kode_rekening
		$this->kode_rekening->EditAttrs["class"] = "form-control";
		$this->kode_rekening->EditCustomAttributes = "";
		$this->kode_rekening->EditValue = $this->kode_rekening->CurrentValue;
		$this->kode_rekening->PlaceHolder = ew_RemoveHtml($this->kode_rekening->FldCaption());

		// nama_bendahara
		$this->nama_bendahara->EditAttrs["class"] = "form-control";
		$this->nama_bendahara->EditCustomAttributes = "";
		$this->nama_bendahara->EditValue = $this->nama_bendahara->CurrentValue;
		$this->nama_bendahara->PlaceHolder = ew_RemoveHtml($this->nama_bendahara->FldCaption());

		// nip_bendahara
		$this->nip_bendahara->EditAttrs["class"] = "form-control";
		$this->nip_bendahara->EditCustomAttributes = "";
		$this->nip_bendahara->EditValue = $this->nip_bendahara->CurrentValue;
		$this->nip_bendahara->PlaceHolder = ew_RemoveHtml($this->nip_bendahara->FldCaption());

		// no_spm
		$this->no_spm->EditAttrs["class"] = "form-control";
		$this->no_spm->EditCustomAttributes = "";
		$this->no_spm->EditValue = $this->no_spm->CurrentValue;
		$this->no_spm->PlaceHolder = ew_RemoveHtml($this->no_spm->FldCaption());

		// tgl_spm
		$this->tgl_spm->EditAttrs["class"] = "form-control";
		$this->tgl_spm->EditCustomAttributes = "";
		$this->tgl_spm->EditValue = $this->tgl_spm->CurrentValue;
		$this->tgl_spm->PlaceHolder = ew_RemoveHtml($this->tgl_spm->FldCaption());

		// nama_bank
		$this->nama_bank->EditAttrs["class"] = "form-control";
		$this->nama_bank->EditCustomAttributes = "";
		$this->nama_bank->EditValue = $this->nama_bank->CurrentValue;
		$this->nama_bank->PlaceHolder = ew_RemoveHtml($this->nama_bank->FldCaption());

		// nomer_rekening_bank
		$this->nomer_rekening_bank->EditAttrs["class"] = "form-control";
		$this->nomer_rekening_bank->EditCustomAttributes = "";
		$this->nomer_rekening_bank->EditValue = $this->nomer_rekening_bank->CurrentValue;
		$this->nomer_rekening_bank->PlaceHolder = ew_RemoveHtml($this->nomer_rekening_bank->FldCaption());

		// npwp
		$this->npwp->EditAttrs["class"] = "form-control";
		$this->npwp->EditCustomAttributes = "";
		$this->npwp->EditValue = $this->npwp->CurrentValue;
		$this->npwp->PlaceHolder = ew_RemoveHtml($this->npwp->FldCaption());

		// pph21
		$this->pph21->EditAttrs["class"] = "form-control";
		$this->pph21->EditCustomAttributes = "";
		$this->pph21->EditValue = $this->pph21->CurrentValue;
		$this->pph21->PlaceHolder = ew_RemoveHtml($this->pph21->FldCaption());
		if (strval($this->pph21->EditValue) <> "" && is_numeric($this->pph21->EditValue)) $this->pph21->EditValue = ew_FormatNumber($this->pph21->EditValue, -2, -1, -2, 0);

		// pph22
		$this->pph22->EditAttrs["class"] = "form-control";
		$this->pph22->EditCustomAttributes = "";
		$this->pph22->EditValue = $this->pph22->CurrentValue;
		$this->pph22->PlaceHolder = ew_RemoveHtml($this->pph22->FldCaption());
		if (strval($this->pph22->EditValue) <> "" && is_numeric($this->pph22->EditValue)) $this->pph22->EditValue = ew_FormatNumber($this->pph22->EditValue, -2, -1, -2, 0);

		// pph23
		$this->pph23->EditAttrs["class"] = "form-control";
		$this->pph23->EditCustomAttributes = "";
		$this->pph23->EditValue = $this->pph23->CurrentValue;
		$this->pph23->PlaceHolder = ew_RemoveHtml($this->pph23->FldCaption());
		if (strval($this->pph23->EditValue) <> "" && is_numeric($this->pph23->EditValue)) $this->pph23->EditValue = ew_FormatNumber($this->pph23->EditValue, -2, -1, -2, 0);

		// pph4
		$this->pph4->EditAttrs["class"] = "form-control";
		$this->pph4->EditCustomAttributes = "";
		$this->pph4->EditValue = $this->pph4->CurrentValue;
		$this->pph4->PlaceHolder = ew_RemoveHtml($this->pph4->FldCaption());
		if (strval($this->pph4->EditValue) <> "" && is_numeric($this->pph4->EditValue)) $this->pph4->EditValue = ew_FormatNumber($this->pph4->EditValue, -2, -1, -2, 0);

		// jumlah_belanja
		$this->jumlah_belanja->EditAttrs["class"] = "form-control";
		$this->jumlah_belanja->EditCustomAttributes = "";
		$this->jumlah_belanja->EditValue = $this->jumlah_belanja->CurrentValue;
		$this->jumlah_belanja->PlaceHolder = ew_RemoveHtml($this->jumlah_belanja->FldCaption());
		if (strval($this->jumlah_belanja->EditValue) <> "" && is_numeric($this->jumlah_belanja->EditValue)) $this->jumlah_belanja->EditValue = ew_FormatNumber($this->jumlah_belanja->EditValue, -2, -1, -2, 0);

		// kontrak_id
		$this->kontrak_id->EditAttrs["class"] = "form-control";
		$this->kontrak_id->EditCustomAttributes = "";
		$this->kontrak_id->EditValue = $this->kontrak_id->CurrentValue;
		$this->kontrak_id->PlaceHolder = ew_RemoveHtml($this->kontrak_id->FldCaption());

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

		// pimpinan_blud
		$this->pimpinan_blud->EditAttrs["class"] = "form-control";
		$this->pimpinan_blud->EditCustomAttributes = "";
		$this->pimpinan_blud->EditValue = $this->pimpinan_blud->CurrentValue;
		$this->pimpinan_blud->PlaceHolder = ew_RemoveHtml($this->pimpinan_blud->FldCaption());

		// nip_pimpinan
		$this->nip_pimpinan->EditAttrs["class"] = "form-control";
		$this->nip_pimpinan->EditCustomAttributes = "";
		$this->nip_pimpinan->EditValue = $this->nip_pimpinan->CurrentValue;
		$this->nip_pimpinan->PlaceHolder = ew_RemoveHtml($this->nip_pimpinan->FldCaption());

		// opd
		$this->opd->EditAttrs["class"] = "form-control";
		$this->opd->EditCustomAttributes = "";
		$this->opd->EditValue = $this->opd->CurrentValue;
		$this->opd->PlaceHolder = ew_RemoveHtml($this->opd->FldCaption());

		// urusan_pemerintahan
		$this->urusan_pemerintahan->EditAttrs["class"] = "form-control";
		$this->urusan_pemerintahan->EditCustomAttributes = "";
		$this->urusan_pemerintahan->EditValue = $this->urusan_pemerintahan->CurrentValue;
		$this->urusan_pemerintahan->PlaceHolder = ew_RemoveHtml($this->urusan_pemerintahan->FldCaption());

		// tgl_sptb
		$this->tgl_sptb->EditAttrs["class"] = "form-control";
		$this->tgl_sptb->EditCustomAttributes = "";
		$this->tgl_sptb->EditValue = ew_FormatDateTime($this->tgl_sptb->CurrentValue, 8);
		$this->tgl_sptb->PlaceHolder = ew_RemoveHtml($this->tgl_sptb->FldCaption());

		// no_sptb
		$this->no_sptb->EditAttrs["class"] = "form-control";
		$this->no_sptb->EditCustomAttributes = "";
		$this->no_sptb->EditValue = $this->no_sptb->CurrentValue;
		$this->no_sptb->PlaceHolder = ew_RemoveHtml($this->no_sptb->FldCaption());

		// status_advis
		$this->status_advis->EditAttrs["class"] = "form-control";
		$this->status_advis->EditCustomAttributes = "";
		$this->status_advis->EditValue = $this->status_advis->CurrentValue;
		$this->status_advis->PlaceHolder = ew_RemoveHtml($this->status_advis->FldCaption());

		// id_spj
		$this->id_spj->EditAttrs["class"] = "form-control";
		$this->id_spj->EditCustomAttributes = "";
		$this->id_spj->EditValue = $this->id_spj->CurrentValue;
		$this->id_spj->PlaceHolder = ew_RemoveHtml($this->id_spj->FldCaption());

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
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->jumlah_up->Exportable) $Doc->ExportCaption($this->jumlah_up);
					if ($this->bendahara->Exportable) $Doc->ExportCaption($this->bendahara);
					if ($this->nama_pptk->Exportable) $Doc->ExportCaption($this->nama_pptk);
					if ($this->nip_pptk->Exportable) $Doc->ExportCaption($this->nip_pptk);
					if ($this->status_spm->Exportable) $Doc->ExportCaption($this->status_spm);
					if ($this->kode_kegiatan->Exportable) $Doc->ExportCaption($this->kode_kegiatan);
					if ($this->kode_sub_kegiatan->Exportable) $Doc->ExportCaption($this->kode_sub_kegiatan);
					if ($this->tahun_anggaran->Exportable) $Doc->ExportCaption($this->tahun_anggaran);
					if ($this->jumlah_spd->Exportable) $Doc->ExportCaption($this->jumlah_spd);
					if ($this->nomer_dasar_spd->Exportable) $Doc->ExportCaption($this->nomer_dasar_spd);
					if ($this->tanggal_spd->Exportable) $Doc->ExportCaption($this->tanggal_spd);
					if ($this->id_spd->Exportable) $Doc->ExportCaption($this->id_spd);
					if ($this->kode_program->Exportable) $Doc->ExportCaption($this->kode_program);
					if ($this->kode_rekening->Exportable) $Doc->ExportCaption($this->kode_rekening);
					if ($this->nama_bendahara->Exportable) $Doc->ExportCaption($this->nama_bendahara);
					if ($this->nip_bendahara->Exportable) $Doc->ExportCaption($this->nip_bendahara);
					if ($this->no_spm->Exportable) $Doc->ExportCaption($this->no_spm);
					if ($this->tgl_spm->Exportable) $Doc->ExportCaption($this->tgl_spm);
					if ($this->nama_bank->Exportable) $Doc->ExportCaption($this->nama_bank);
					if ($this->nomer_rekening_bank->Exportable) $Doc->ExportCaption($this->nomer_rekening_bank);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->pph21->Exportable) $Doc->ExportCaption($this->pph21);
					if ($this->pph22->Exportable) $Doc->ExportCaption($this->pph22);
					if ($this->pph23->Exportable) $Doc->ExportCaption($this->pph23);
					if ($this->pph4->Exportable) $Doc->ExportCaption($this->pph4);
					if ($this->jumlah_belanja->Exportable) $Doc->ExportCaption($this->jumlah_belanja);
					if ($this->kontrak_id->Exportable) $Doc->ExportCaption($this->kontrak_id);
					if ($this->akun1->Exportable) $Doc->ExportCaption($this->akun1);
					if ($this->akun2->Exportable) $Doc->ExportCaption($this->akun2);
					if ($this->akun3->Exportable) $Doc->ExportCaption($this->akun3);
					if ($this->akun4->Exportable) $Doc->ExportCaption($this->akun4);
					if ($this->akun5->Exportable) $Doc->ExportCaption($this->akun5);
					if ($this->pimpinan_blud->Exportable) $Doc->ExportCaption($this->pimpinan_blud);
					if ($this->nip_pimpinan->Exportable) $Doc->ExportCaption($this->nip_pimpinan);
					if ($this->opd->Exportable) $Doc->ExportCaption($this->opd);
					if ($this->urusan_pemerintahan->Exportable) $Doc->ExportCaption($this->urusan_pemerintahan);
					if ($this->tgl_sptb->Exportable) $Doc->ExportCaption($this->tgl_sptb);
					if ($this->no_sptb->Exportable) $Doc->ExportCaption($this->no_sptb);
					if ($this->status_advis->Exportable) $Doc->ExportCaption($this->status_advis);
					if ($this->id_spj->Exportable) $Doc->ExportCaption($this->id_spj);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->id_jenis_spp->Exportable) $Doc->ExportCaption($this->id_jenis_spp);
					if ($this->detail_jenis_spp->Exportable) $Doc->ExportCaption($this->detail_jenis_spp);
					if ($this->status_spp->Exportable) $Doc->ExportCaption($this->status_spp);
					if ($this->no_spp->Exportable) $Doc->ExportCaption($this->no_spp);
					if ($this->tgl_spp->Exportable) $Doc->ExportCaption($this->tgl_spp);
					if ($this->keterangan->Exportable) $Doc->ExportCaption($this->keterangan);
					if ($this->jumlah_up->Exportable) $Doc->ExportCaption($this->jumlah_up);
					if ($this->bendahara->Exportable) $Doc->ExportCaption($this->bendahara);
					if ($this->nama_pptk->Exportable) $Doc->ExportCaption($this->nama_pptk);
					if ($this->nip_pptk->Exportable) $Doc->ExportCaption($this->nip_pptk);
					if ($this->status_spm->Exportable) $Doc->ExportCaption($this->status_spm);
					if ($this->kode_kegiatan->Exportable) $Doc->ExportCaption($this->kode_kegiatan);
					if ($this->kode_sub_kegiatan->Exportable) $Doc->ExportCaption($this->kode_sub_kegiatan);
					if ($this->tahun_anggaran->Exportable) $Doc->ExportCaption($this->tahun_anggaran);
					if ($this->jumlah_spd->Exportable) $Doc->ExportCaption($this->jumlah_spd);
					if ($this->nomer_dasar_spd->Exportable) $Doc->ExportCaption($this->nomer_dasar_spd);
					if ($this->tanggal_spd->Exportable) $Doc->ExportCaption($this->tanggal_spd);
					if ($this->id_spd->Exportable) $Doc->ExportCaption($this->id_spd);
					if ($this->kode_program->Exportable) $Doc->ExportCaption($this->kode_program);
					if ($this->kode_rekening->Exportable) $Doc->ExportCaption($this->kode_rekening);
					if ($this->nama_bendahara->Exportable) $Doc->ExportCaption($this->nama_bendahara);
					if ($this->nip_bendahara->Exportable) $Doc->ExportCaption($this->nip_bendahara);
					if ($this->no_spm->Exportable) $Doc->ExportCaption($this->no_spm);
					if ($this->tgl_spm->Exportable) $Doc->ExportCaption($this->tgl_spm);
					if ($this->nama_bank->Exportable) $Doc->ExportCaption($this->nama_bank);
					if ($this->nomer_rekening_bank->Exportable) $Doc->ExportCaption($this->nomer_rekening_bank);
					if ($this->npwp->Exportable) $Doc->ExportCaption($this->npwp);
					if ($this->pph21->Exportable) $Doc->ExportCaption($this->pph21);
					if ($this->pph22->Exportable) $Doc->ExportCaption($this->pph22);
					if ($this->pph23->Exportable) $Doc->ExportCaption($this->pph23);
					if ($this->pph4->Exportable) $Doc->ExportCaption($this->pph4);
					if ($this->jumlah_belanja->Exportable) $Doc->ExportCaption($this->jumlah_belanja);
					if ($this->kontrak_id->Exportable) $Doc->ExportCaption($this->kontrak_id);
					if ($this->akun1->Exportable) $Doc->ExportCaption($this->akun1);
					if ($this->akun2->Exportable) $Doc->ExportCaption($this->akun2);
					if ($this->akun3->Exportable) $Doc->ExportCaption($this->akun3);
					if ($this->akun4->Exportable) $Doc->ExportCaption($this->akun4);
					if ($this->akun5->Exportable) $Doc->ExportCaption($this->akun5);
					if ($this->pimpinan_blud->Exportable) $Doc->ExportCaption($this->pimpinan_blud);
					if ($this->nip_pimpinan->Exportable) $Doc->ExportCaption($this->nip_pimpinan);
					if ($this->opd->Exportable) $Doc->ExportCaption($this->opd);
					if ($this->urusan_pemerintahan->Exportable) $Doc->ExportCaption($this->urusan_pemerintahan);
					if ($this->tgl_sptb->Exportable) $Doc->ExportCaption($this->tgl_sptb);
					if ($this->no_sptb->Exportable) $Doc->ExportCaption($this->no_sptb);
					if ($this->status_advis->Exportable) $Doc->ExportCaption($this->status_advis);
					if ($this->id_spj->Exportable) $Doc->ExportCaption($this->id_spj);
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
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->jumlah_up->Exportable) $Doc->ExportField($this->jumlah_up);
						if ($this->bendahara->Exportable) $Doc->ExportField($this->bendahara);
						if ($this->nama_pptk->Exportable) $Doc->ExportField($this->nama_pptk);
						if ($this->nip_pptk->Exportable) $Doc->ExportField($this->nip_pptk);
						if ($this->status_spm->Exportable) $Doc->ExportField($this->status_spm);
						if ($this->kode_kegiatan->Exportable) $Doc->ExportField($this->kode_kegiatan);
						if ($this->kode_sub_kegiatan->Exportable) $Doc->ExportField($this->kode_sub_kegiatan);
						if ($this->tahun_anggaran->Exportable) $Doc->ExportField($this->tahun_anggaran);
						if ($this->jumlah_spd->Exportable) $Doc->ExportField($this->jumlah_spd);
						if ($this->nomer_dasar_spd->Exportable) $Doc->ExportField($this->nomer_dasar_spd);
						if ($this->tanggal_spd->Exportable) $Doc->ExportField($this->tanggal_spd);
						if ($this->id_spd->Exportable) $Doc->ExportField($this->id_spd);
						if ($this->kode_program->Exportable) $Doc->ExportField($this->kode_program);
						if ($this->kode_rekening->Exportable) $Doc->ExportField($this->kode_rekening);
						if ($this->nama_bendahara->Exportable) $Doc->ExportField($this->nama_bendahara);
						if ($this->nip_bendahara->Exportable) $Doc->ExportField($this->nip_bendahara);
						if ($this->no_spm->Exportable) $Doc->ExportField($this->no_spm);
						if ($this->tgl_spm->Exportable) $Doc->ExportField($this->tgl_spm);
						if ($this->nama_bank->Exportable) $Doc->ExportField($this->nama_bank);
						if ($this->nomer_rekening_bank->Exportable) $Doc->ExportField($this->nomer_rekening_bank);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->pph21->Exportable) $Doc->ExportField($this->pph21);
						if ($this->pph22->Exportable) $Doc->ExportField($this->pph22);
						if ($this->pph23->Exportable) $Doc->ExportField($this->pph23);
						if ($this->pph4->Exportable) $Doc->ExportField($this->pph4);
						if ($this->jumlah_belanja->Exportable) $Doc->ExportField($this->jumlah_belanja);
						if ($this->kontrak_id->Exportable) $Doc->ExportField($this->kontrak_id);
						if ($this->akun1->Exportable) $Doc->ExportField($this->akun1);
						if ($this->akun2->Exportable) $Doc->ExportField($this->akun2);
						if ($this->akun3->Exportable) $Doc->ExportField($this->akun3);
						if ($this->akun4->Exportable) $Doc->ExportField($this->akun4);
						if ($this->akun5->Exportable) $Doc->ExportField($this->akun5);
						if ($this->pimpinan_blud->Exportable) $Doc->ExportField($this->pimpinan_blud);
						if ($this->nip_pimpinan->Exportable) $Doc->ExportField($this->nip_pimpinan);
						if ($this->opd->Exportable) $Doc->ExportField($this->opd);
						if ($this->urusan_pemerintahan->Exportable) $Doc->ExportField($this->urusan_pemerintahan);
						if ($this->tgl_sptb->Exportable) $Doc->ExportField($this->tgl_sptb);
						if ($this->no_sptb->Exportable) $Doc->ExportField($this->no_sptb);
						if ($this->status_advis->Exportable) $Doc->ExportField($this->status_advis);
						if ($this->id_spj->Exportable) $Doc->ExportField($this->id_spj);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->id_jenis_spp->Exportable) $Doc->ExportField($this->id_jenis_spp);
						if ($this->detail_jenis_spp->Exportable) $Doc->ExportField($this->detail_jenis_spp);
						if ($this->status_spp->Exportable) $Doc->ExportField($this->status_spp);
						if ($this->no_spp->Exportable) $Doc->ExportField($this->no_spp);
						if ($this->tgl_spp->Exportable) $Doc->ExportField($this->tgl_spp);
						if ($this->keterangan->Exportable) $Doc->ExportField($this->keterangan);
						if ($this->jumlah_up->Exportable) $Doc->ExportField($this->jumlah_up);
						if ($this->bendahara->Exportable) $Doc->ExportField($this->bendahara);
						if ($this->nama_pptk->Exportable) $Doc->ExportField($this->nama_pptk);
						if ($this->nip_pptk->Exportable) $Doc->ExportField($this->nip_pptk);
						if ($this->status_spm->Exportable) $Doc->ExportField($this->status_spm);
						if ($this->kode_kegiatan->Exportable) $Doc->ExportField($this->kode_kegiatan);
						if ($this->kode_sub_kegiatan->Exportable) $Doc->ExportField($this->kode_sub_kegiatan);
						if ($this->tahun_anggaran->Exportable) $Doc->ExportField($this->tahun_anggaran);
						if ($this->jumlah_spd->Exportable) $Doc->ExportField($this->jumlah_spd);
						if ($this->nomer_dasar_spd->Exportable) $Doc->ExportField($this->nomer_dasar_spd);
						if ($this->tanggal_spd->Exportable) $Doc->ExportField($this->tanggal_spd);
						if ($this->id_spd->Exportable) $Doc->ExportField($this->id_spd);
						if ($this->kode_program->Exportable) $Doc->ExportField($this->kode_program);
						if ($this->kode_rekening->Exportable) $Doc->ExportField($this->kode_rekening);
						if ($this->nama_bendahara->Exportable) $Doc->ExportField($this->nama_bendahara);
						if ($this->nip_bendahara->Exportable) $Doc->ExportField($this->nip_bendahara);
						if ($this->no_spm->Exportable) $Doc->ExportField($this->no_spm);
						if ($this->tgl_spm->Exportable) $Doc->ExportField($this->tgl_spm);
						if ($this->nama_bank->Exportable) $Doc->ExportField($this->nama_bank);
						if ($this->nomer_rekening_bank->Exportable) $Doc->ExportField($this->nomer_rekening_bank);
						if ($this->npwp->Exportable) $Doc->ExportField($this->npwp);
						if ($this->pph21->Exportable) $Doc->ExportField($this->pph21);
						if ($this->pph22->Exportable) $Doc->ExportField($this->pph22);
						if ($this->pph23->Exportable) $Doc->ExportField($this->pph23);
						if ($this->pph4->Exportable) $Doc->ExportField($this->pph4);
						if ($this->jumlah_belanja->Exportable) $Doc->ExportField($this->jumlah_belanja);
						if ($this->kontrak_id->Exportable) $Doc->ExportField($this->kontrak_id);
						if ($this->akun1->Exportable) $Doc->ExportField($this->akun1);
						if ($this->akun2->Exportable) $Doc->ExportField($this->akun2);
						if ($this->akun3->Exportable) $Doc->ExportField($this->akun3);
						if ($this->akun4->Exportable) $Doc->ExportField($this->akun4);
						if ($this->akun5->Exportable) $Doc->ExportField($this->akun5);
						if ($this->pimpinan_blud->Exportable) $Doc->ExportField($this->pimpinan_blud);
						if ($this->nip_pimpinan->Exportable) $Doc->ExportField($this->nip_pimpinan);
						if ($this->opd->Exportable) $Doc->ExportField($this->opd);
						if ($this->urusan_pemerintahan->Exportable) $Doc->ExportField($this->urusan_pemerintahan);
						if ($this->tgl_sptb->Exportable) $Doc->ExportField($this->tgl_sptb);
						if ($this->no_sptb->Exportable) $Doc->ExportField($this->no_sptb);
						if ($this->status_advis->Exportable) $Doc->ExportField($this->status_advis);
						if ($this->id_spj->Exportable) $Doc->ExportField($this->id_spj);
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
