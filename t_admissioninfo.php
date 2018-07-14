<?php

// Global variable for table object
$t_admission = NULL;

//
// Table class for t_admission
//
class ct_admission extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id_admission;
	var $nomr;
	var $ket_nama;
	var $ket_tgllahir;
	var $ket_alamat;
	var $parent_nomr;
	var $dokterpengirim;
	var $statusbayar;
	var $kirimdari;
	var $keluargadekat;
	var $panggungjawab;
	var $masukrs;
	var $noruang;
	var $tempat_tidur_id;
	var $nott;
	var $deposit;
	var $keluarrs;
	var $icd_masuk;
	var $icd_keluar;
	var $NIP;
	var $noruang_asal;
	var $nott_asal;
	var $tgl_pindah;
	var $kd_rujuk;
	var $st_bayar;
	var $dokter_penanggungjawab;
	var $perawat;
	var $KELASPERAWATAN_ID;
	var $LOS;
	var $TOT_TRF_TIND_DOKTER;
	var $TOT_BHP_DOKTER;
	var $TOT_TRF_PERAWAT;
	var $TOT_BHP_PERAWAT;
	var $TOT_TRF_DOKTER;
	var $TOT_BIAYA_RAD;
	var $TOT_BIAYA_CDRPOLI;
	var $TOT_BIAYA_LAB_IGD;
	var $TOT_BIAYA_OKSIGEN;
	var $TOTAL_BIAYA_OBAT;
	var $LINK_SET_KELAS;
	var $biaya_obat;
	var $biaya_retur_obat;
	var $TOT_BIAYA_GIZI;
	var $TOT_BIAYA_TMO;
	var $TOT_BIAYA_AMBULAN;
	var $TOT_BIAYA_FISIO;
	var $TOT_BIAYA_LAINLAIN;
	var $jenisperawatan_id;
	var $status_transaksi;
	var $statuskeluarranap_id;
	var $TOT_BIAYA_AKOMODASI;
	var $TOTAL_BIAYA_ASKEP;
	var $TOTAL_BIAYA_SIMRS;
	var $TOT_PENJ_NMEDIS;
	var $LINK_MASTERDETAIL;
	var $NO_SKP;
	var $LINK_PELAYANAN_OBAT;
	var $TOT_TIND_RAJAL;
	var $TOT_TIND_IGD;
	var $tanggal_pengembalian_status;
	var $naik_kelas;
	var $iuran_kelas_lama;
	var $iuran_kelas_baru;
	var $ketrangan_naik_kelas;
	var $tgl_pengiriman_ad_klaim;
	var $diagnosa_keluar;
	var $sep_tglsep;
	var $sep_tglrujuk;
	var $sep_kodekelasrawat;
	var $sep_norujukan;
	var $sep_kodeppkasal;
	var $sep_namappkasal;
	var $sep_kodeppkpelayanan;
	var $sep_namappkpelayanan;
	var $t_admissioncol;
	var $sep_jenisperawatan;
	var $sep_catatan;
	var $sep_kodediagnosaawal;
	var $sep_namadiagnosaawal;
	var $sep_lakalantas;
	var $sep_lokasilaka;
	var $sep_user;
	var $sep_flag_cekpeserta;
	var $sep_flag_generatesep;
	var $sep_flag_mapingsep;
	var $sep_nik;
	var $sep_namapeserta;
	var $sep_jeniskelamin;
	var $sep_pisat;
	var $sep_tgllahir;
	var $sep_kodejeniskepesertaan;
	var $sep_namajeniskepesertaan;
	var $sep_kodepolitujuan;
	var $sep_namapolitujuan;
	var $ket_jeniskelamin;
	var $sep_nokabpjs;
	var $counter_cetak_sep;
	var $sep_petugas_hapus_sep;
	var $sep_petugas_set_tgl_pulang;
	var $sep_jam_generate_sep;
	var $sep_status_peserta;
	var $sep_umur_pasien_sekarang;
	var $ket_title;
	var $status_daftar_ranap;
	var $IBS_SETMARKING;
	var $IBS_PATOLOGI;
	var $IBS_JENISANESTESI;
	var $IBS_NO_OK;
	var $IBS_ASISSTEN;
	var $IBS_JAM_ELEFTIF;
	var $IBS_JAM_ELEKTIF_SELESAI;
	var $IBS_JAM_CYTO;
	var $IBS_JAM_CYTO_SELESAI;
	var $IBS_TGL_DFTR_OP;
	var $IBS_TGL_OP;
	var $grup_ruang_id;
	var $status_order_ibs;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 't_admission';
		$this->TableName = 't_admission';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`t_admission`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id_admission
		$this->id_admission = new cField('t_admission', 't_admission', 'x_id_admission', 'id_admission', '`id_admission`', '`id_admission`', 3, -1, FALSE, '`id_admission`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_admission->Sortable = TRUE; // Allow sort
		$this->id_admission->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_admission'] = &$this->id_admission;

		// nomr
		$this->nomr = new cField('t_admission', 't_admission', 'x_nomr', 'nomr', '`nomr`', '`nomr`', 200, -1, FALSE, '`nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomr->Sortable = TRUE; // Allow sort
		$this->fields['nomr'] = &$this->nomr;

		// ket_nama
		$this->ket_nama = new cField('t_admission', 't_admission', 'x_ket_nama', 'ket_nama', '`ket_nama`', '`ket_nama`', 200, -1, FALSE, '`ket_nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_nama->Sortable = TRUE; // Allow sort
		$this->fields['ket_nama'] = &$this->ket_nama;

		// ket_tgllahir
		$this->ket_tgllahir = new cField('t_admission', 't_admission', 'x_ket_tgllahir', 'ket_tgllahir', '`ket_tgllahir`', ew_CastDateFieldForLike('`ket_tgllahir`', 0, "DB"), 135, 0, FALSE, '`ket_tgllahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_tgllahir->Sortable = TRUE; // Allow sort
		$this->ket_tgllahir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['ket_tgllahir'] = &$this->ket_tgllahir;

		// ket_alamat
		$this->ket_alamat = new cField('t_admission', 't_admission', 'x_ket_alamat', 'ket_alamat', '`ket_alamat`', '`ket_alamat`', 200, -1, FALSE, '`ket_alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_alamat->Sortable = TRUE; // Allow sort
		$this->fields['ket_alamat'] = &$this->ket_alamat;

		// parent_nomr
		$this->parent_nomr = new cField('t_admission', 't_admission', 'x_parent_nomr', 'parent_nomr', '`parent_nomr`', '`parent_nomr`', 200, -1, FALSE, '`parent_nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->parent_nomr->Sortable = TRUE; // Allow sort
		$this->fields['parent_nomr'] = &$this->parent_nomr;

		// dokterpengirim
		$this->dokterpengirim = new cField('t_admission', 't_admission', 'x_dokterpengirim', 'dokterpengirim', '`dokterpengirim`', '`dokterpengirim`', 3, -1, FALSE, '`dokterpengirim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->dokterpengirim->Sortable = TRUE; // Allow sort
		$this->dokterpengirim->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->dokterpengirim->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->dokterpengirim->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dokterpengirim'] = &$this->dokterpengirim;

		// statusbayar
		$this->statusbayar = new cField('t_admission', 't_admission', 'x_statusbayar', 'statusbayar', '`statusbayar`', '`statusbayar`', 3, -1, FALSE, '`statusbayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->statusbayar->Sortable = TRUE; // Allow sort
		$this->statusbayar->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->statusbayar->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->statusbayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statusbayar'] = &$this->statusbayar;

		// kirimdari
		$this->kirimdari = new cField('t_admission', 't_admission', 'x_kirimdari', 'kirimdari', '`kirimdari`', '`kirimdari`', 3, -1, FALSE, '`kirimdari`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kirimdari->Sortable = TRUE; // Allow sort
		$this->kirimdari->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kirimdari'] = &$this->kirimdari;

		// keluargadekat
		$this->keluargadekat = new cField('t_admission', 't_admission', 'x_keluargadekat', 'keluargadekat', '`keluargadekat`', '`keluargadekat`', 200, -1, FALSE, '`keluargadekat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keluargadekat->Sortable = TRUE; // Allow sort
		$this->fields['keluargadekat'] = &$this->keluargadekat;

		// panggungjawab
		$this->panggungjawab = new cField('t_admission', 't_admission', 'x_panggungjawab', 'panggungjawab', '`panggungjawab`', '`panggungjawab`', 200, -1, FALSE, '`panggungjawab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->panggungjawab->Sortable = TRUE; // Allow sort
		$this->fields['panggungjawab'] = &$this->panggungjawab;

		// masukrs
		$this->masukrs = new cField('t_admission', 't_admission', 'x_masukrs', 'masukrs', '`masukrs`', ew_CastDateFieldForLike('`masukrs`', 11, "DB"), 135, 11, FALSE, '`masukrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->masukrs->Sortable = TRUE; // Allow sort
		$this->masukrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['masukrs'] = &$this->masukrs;

		// noruang
		$this->noruang = new cField('t_admission', 't_admission', 'x_noruang', 'noruang', '`noruang`', '`noruang`', 3, -1, FALSE, '`noruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->noruang->Sortable = TRUE; // Allow sort
		$this->noruang->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->noruang->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->noruang->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['noruang'] = &$this->noruang;

		// tempat_tidur_id
		$this->tempat_tidur_id = new cField('t_admission', 't_admission', 'x_tempat_tidur_id', 'tempat_tidur_id', '`tempat_tidur_id`', '`tempat_tidur_id`', 3, -1, FALSE, '`tempat_tidur_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->tempat_tidur_id->Sortable = TRUE; // Allow sort
		$this->tempat_tidur_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->tempat_tidur_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->tempat_tidur_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tempat_tidur_id'] = &$this->tempat_tidur_id;

		// nott
		$this->nott = new cField('t_admission', 't_admission', 'x_nott', 'nott', '`nott`', '`nott`', 200, -1, FALSE, '`nott`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nott->Sortable = TRUE; // Allow sort
		$this->fields['nott'] = &$this->nott;

		// deposit
		$this->deposit = new cField('t_admission', 't_admission', 'x_deposit', 'deposit', '`deposit`', '`deposit`', 3, -1, FALSE, '`deposit`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->deposit->Sortable = TRUE; // Allow sort
		$this->deposit->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['deposit'] = &$this->deposit;

		// keluarrs
		$this->keluarrs = new cField('t_admission', 't_admission', 'x_keluarrs', 'keluarrs', '`keluarrs`', ew_CastDateFieldForLike('`keluarrs`', 0, "DB"), 135, 0, FALSE, '`keluarrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keluarrs->Sortable = TRUE; // Allow sort
		$this->keluarrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['keluarrs'] = &$this->keluarrs;

		// icd_masuk
		$this->icd_masuk = new cField('t_admission', 't_admission', 'x_icd_masuk', 'icd_masuk', '`icd_masuk`', '`icd_masuk`', 200, -1, FALSE, '`icd_masuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->icd_masuk->Sortable = TRUE; // Allow sort
		$this->fields['icd_masuk'] = &$this->icd_masuk;

		// icd_keluar
		$this->icd_keluar = new cField('t_admission', 't_admission', 'x_icd_keluar', 'icd_keluar', '`icd_keluar`', '`icd_keluar`', 200, -1, FALSE, '`icd_keluar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->icd_keluar->Sortable = TRUE; // Allow sort
		$this->fields['icd_keluar'] = &$this->icd_keluar;

		// NIP
		$this->NIP = new cField('t_admission', 't_admission', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = TRUE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// noruang_asal
		$this->noruang_asal = new cField('t_admission', 't_admission', 'x_noruang_asal', 'noruang_asal', '`noruang_asal`', '`noruang_asal`', 3, -1, FALSE, '`noruang_asal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->noruang_asal->Sortable = TRUE; // Allow sort
		$this->noruang_asal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['noruang_asal'] = &$this->noruang_asal;

		// nott_asal
		$this->nott_asal = new cField('t_admission', 't_admission', 'x_nott_asal', 'nott_asal', '`nott_asal`', '`nott_asal`', 3, -1, FALSE, '`nott_asal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nott_asal->Sortable = TRUE; // Allow sort
		$this->nott_asal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['nott_asal'] = &$this->nott_asal;

		// tgl_pindah
		$this->tgl_pindah = new cField('t_admission', 't_admission', 'x_tgl_pindah', 'tgl_pindah', '`tgl_pindah`', ew_CastDateFieldForLike('`tgl_pindah`', 0, "DB"), 133, 0, FALSE, '`tgl_pindah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_pindah->Sortable = TRUE; // Allow sort
		$this->tgl_pindah->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_pindah'] = &$this->tgl_pindah;

		// kd_rujuk
		$this->kd_rujuk = new cField('t_admission', 't_admission', 'x_kd_rujuk', 'kd_rujuk', '`kd_rujuk`', '`kd_rujuk`', 3, -1, FALSE, '`kd_rujuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->kd_rujuk->Sortable = TRUE; // Allow sort
		$this->kd_rujuk->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->kd_rujuk->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->kd_rujuk->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kd_rujuk'] = &$this->kd_rujuk;

		// st_bayar
		$this->st_bayar = new cField('t_admission', 't_admission', 'x_st_bayar', 'st_bayar', '`st_bayar`', '`st_bayar`', 3, -1, FALSE, '`st_bayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->st_bayar->Sortable = TRUE; // Allow sort
		$this->st_bayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['st_bayar'] = &$this->st_bayar;

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab = new cField('t_admission', 't_admission', 'x_dokter_penanggungjawab', 'dokter_penanggungjawab', '`dokter_penanggungjawab`', '`dokter_penanggungjawab`', 3, -1, FALSE, '`dokter_penanggungjawab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->dokter_penanggungjawab->Sortable = TRUE; // Allow sort
		$this->dokter_penanggungjawab->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->dokter_penanggungjawab->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->dokter_penanggungjawab->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dokter_penanggungjawab'] = &$this->dokter_penanggungjawab;

		// perawat
		$this->perawat = new cField('t_admission', 't_admission', 'x_perawat', 'perawat', '`perawat`', '`perawat`', 3, -1, FALSE, '`perawat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->perawat->Sortable = TRUE; // Allow sort
		$this->perawat->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['perawat'] = &$this->perawat;

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID = new cField('t_admission', 't_admission', 'x_KELASPERAWATAN_ID', 'KELASPERAWATAN_ID', '`KELASPERAWATAN_ID`', '`KELASPERAWATAN_ID`', 3, -1, FALSE, '`KELASPERAWATAN_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KELASPERAWATAN_ID->Sortable = TRUE; // Allow sort
		$this->KELASPERAWATAN_ID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KELASPERAWATAN_ID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KELASPERAWATAN_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KELASPERAWATAN_ID'] = &$this->KELASPERAWATAN_ID;

		// LOS
		$this->LOS = new cField('t_admission', 't_admission', 'x_LOS', 'LOS', '`LOS`', '`LOS`', 3, -1, FALSE, '`LOS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LOS->Sortable = TRUE; // Allow sort
		$this->LOS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['LOS'] = &$this->LOS;

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER = new cField('t_admission', 't_admission', 'x_TOT_TRF_TIND_DOKTER', 'TOT_TRF_TIND_DOKTER', '`TOT_TRF_TIND_DOKTER`', '`TOT_TRF_TIND_DOKTER`', 5, -1, FALSE, '`TOT_TRF_TIND_DOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_TRF_TIND_DOKTER->Sortable = TRUE; // Allow sort
		$this->TOT_TRF_TIND_DOKTER->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_TRF_TIND_DOKTER'] = &$this->TOT_TRF_TIND_DOKTER;

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER = new cField('t_admission', 't_admission', 'x_TOT_BHP_DOKTER', 'TOT_BHP_DOKTER', '`TOT_BHP_DOKTER`', '`TOT_BHP_DOKTER`', 5, -1, FALSE, '`TOT_BHP_DOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BHP_DOKTER->Sortable = TRUE; // Allow sort
		$this->TOT_BHP_DOKTER->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BHP_DOKTER'] = &$this->TOT_BHP_DOKTER;

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT = new cField('t_admission', 't_admission', 'x_TOT_TRF_PERAWAT', 'TOT_TRF_PERAWAT', '`TOT_TRF_PERAWAT`', '`TOT_TRF_PERAWAT`', 5, -1, FALSE, '`TOT_TRF_PERAWAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_TRF_PERAWAT->Sortable = TRUE; // Allow sort
		$this->TOT_TRF_PERAWAT->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_TRF_PERAWAT'] = &$this->TOT_TRF_PERAWAT;

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT = new cField('t_admission', 't_admission', 'x_TOT_BHP_PERAWAT', 'TOT_BHP_PERAWAT', '`TOT_BHP_PERAWAT`', '`TOT_BHP_PERAWAT`', 5, -1, FALSE, '`TOT_BHP_PERAWAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BHP_PERAWAT->Sortable = TRUE; // Allow sort
		$this->TOT_BHP_PERAWAT->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BHP_PERAWAT'] = &$this->TOT_BHP_PERAWAT;

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER = new cField('t_admission', 't_admission', 'x_TOT_TRF_DOKTER', 'TOT_TRF_DOKTER', '`TOT_TRF_DOKTER`', '`TOT_TRF_DOKTER`', 5, -1, FALSE, '`TOT_TRF_DOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_TRF_DOKTER->Sortable = TRUE; // Allow sort
		$this->TOT_TRF_DOKTER->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_TRF_DOKTER'] = &$this->TOT_TRF_DOKTER;

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_RAD', 'TOT_BIAYA_RAD', '`TOT_BIAYA_RAD`', '`TOT_BIAYA_RAD`', 5, -1, FALSE, '`TOT_BIAYA_RAD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_RAD->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_RAD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_RAD'] = &$this->TOT_BIAYA_RAD;

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_CDRPOLI', 'TOT_BIAYA_CDRPOLI', '`TOT_BIAYA_CDRPOLI`', '`TOT_BIAYA_CDRPOLI`', 5, -1, FALSE, '`TOT_BIAYA_CDRPOLI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_CDRPOLI->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_CDRPOLI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_CDRPOLI'] = &$this->TOT_BIAYA_CDRPOLI;

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_LAB_IGD', 'TOT_BIAYA_LAB_IGD', '`TOT_BIAYA_LAB_IGD`', '`TOT_BIAYA_LAB_IGD`', 5, -1, FALSE, '`TOT_BIAYA_LAB_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_LAB_IGD->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_LAB_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_LAB_IGD'] = &$this->TOT_BIAYA_LAB_IGD;

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_OKSIGEN', 'TOT_BIAYA_OKSIGEN', '`TOT_BIAYA_OKSIGEN`', '`TOT_BIAYA_OKSIGEN`', 5, -1, FALSE, '`TOT_BIAYA_OKSIGEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_OKSIGEN->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_OKSIGEN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_OKSIGEN'] = &$this->TOT_BIAYA_OKSIGEN;

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT = new cField('t_admission', 't_admission', 'x_TOTAL_BIAYA_OBAT', 'TOTAL_BIAYA_OBAT', '`TOTAL_BIAYA_OBAT`', '`TOTAL_BIAYA_OBAT`', 5, -1, FALSE, '`TOTAL_BIAYA_OBAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_OBAT->Sortable = TRUE; // Allow sort
		$this->TOTAL_BIAYA_OBAT->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_OBAT'] = &$this->TOTAL_BIAYA_OBAT;

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS = new cField('t_admission', 't_admission', 'x_LINK_SET_KELAS', 'LINK_SET_KELAS', '`LINK_SET_KELAS`', '`LINK_SET_KELAS`', 200, -1, FALSE, '`LINK_SET_KELAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LINK_SET_KELAS->Sortable = TRUE; // Allow sort
		$this->fields['LINK_SET_KELAS'] = &$this->LINK_SET_KELAS;

		// biaya_obat
		$this->biaya_obat = new cField('t_admission', 't_admission', 'x_biaya_obat', 'biaya_obat', '`biaya_obat`', '`biaya_obat`', 5, -1, FALSE, '`biaya_obat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_obat->Sortable = TRUE; // Allow sort
		$this->biaya_obat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_obat'] = &$this->biaya_obat;

		// biaya_retur_obat
		$this->biaya_retur_obat = new cField('t_admission', 't_admission', 'x_biaya_retur_obat', 'biaya_retur_obat', '`biaya_retur_obat`', '`biaya_retur_obat`', 5, -1, FALSE, '`biaya_retur_obat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->biaya_retur_obat->Sortable = TRUE; // Allow sort
		$this->biaya_retur_obat->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['biaya_retur_obat'] = &$this->biaya_retur_obat;

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_GIZI', 'TOT_BIAYA_GIZI', '`TOT_BIAYA_GIZI`', '`TOT_BIAYA_GIZI`', 5, -1, FALSE, '`TOT_BIAYA_GIZI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_GIZI->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_GIZI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_GIZI'] = &$this->TOT_BIAYA_GIZI;

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_TMO', 'TOT_BIAYA_TMO', '`TOT_BIAYA_TMO`', '`TOT_BIAYA_TMO`', 5, -1, FALSE, '`TOT_BIAYA_TMO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_TMO->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_TMO->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_TMO'] = &$this->TOT_BIAYA_TMO;

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_AMBULAN', 'TOT_BIAYA_AMBULAN', '`TOT_BIAYA_AMBULAN`', '`TOT_BIAYA_AMBULAN`', 5, -1, FALSE, '`TOT_BIAYA_AMBULAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_AMBULAN->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_AMBULAN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_AMBULAN'] = &$this->TOT_BIAYA_AMBULAN;

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_FISIO', 'TOT_BIAYA_FISIO', '`TOT_BIAYA_FISIO`', '`TOT_BIAYA_FISIO`', 5, -1, FALSE, '`TOT_BIAYA_FISIO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_FISIO->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_FISIO->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_FISIO'] = &$this->TOT_BIAYA_FISIO;

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_LAINLAIN', 'TOT_BIAYA_LAINLAIN', '`TOT_BIAYA_LAINLAIN`', '`TOT_BIAYA_LAINLAIN`', 5, -1, FALSE, '`TOT_BIAYA_LAINLAIN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_LAINLAIN->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_LAINLAIN->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_LAINLAIN'] = &$this->TOT_BIAYA_LAINLAIN;

		// jenisperawatan_id
		$this->jenisperawatan_id = new cField('t_admission', 't_admission', 'x_jenisperawatan_id', 'jenisperawatan_id', '`jenisperawatan_id`', '`jenisperawatan_id`', 3, -1, FALSE, '`jenisperawatan_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jenisperawatan_id->Sortable = TRUE; // Allow sort
		$this->jenisperawatan_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['jenisperawatan_id'] = &$this->jenisperawatan_id;

		// status_transaksi
		$this->status_transaksi = new cField('t_admission', 't_admission', 'x_status_transaksi', 'status_transaksi', '`status_transaksi`', '`status_transaksi`', 3, -1, FALSE, '`status_transaksi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_transaksi->Sortable = TRUE; // Allow sort
		$this->status_transaksi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_transaksi'] = &$this->status_transaksi;

		// statuskeluarranap_id
		$this->statuskeluarranap_id = new cField('t_admission', 't_admission', 'x_statuskeluarranap_id', 'statuskeluarranap_id', '`statuskeluarranap_id`', '`statuskeluarranap_id`', 3, -1, FALSE, '`statuskeluarranap_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->statuskeluarranap_id->Sortable = TRUE; // Allow sort
		$this->statuskeluarranap_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statuskeluarranap_id'] = &$this->statuskeluarranap_id;

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI = new cField('t_admission', 't_admission', 'x_TOT_BIAYA_AKOMODASI', 'TOT_BIAYA_AKOMODASI', '`TOT_BIAYA_AKOMODASI`', '`TOT_BIAYA_AKOMODASI`', 5, -1, FALSE, '`TOT_BIAYA_AKOMODASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_BIAYA_AKOMODASI->Sortable = TRUE; // Allow sort
		$this->TOT_BIAYA_AKOMODASI->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_BIAYA_AKOMODASI'] = &$this->TOT_BIAYA_AKOMODASI;

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP = new cField('t_admission', 't_admission', 'x_TOTAL_BIAYA_ASKEP', 'TOTAL_BIAYA_ASKEP', '`TOTAL_BIAYA_ASKEP`', '`TOTAL_BIAYA_ASKEP`', 5, -1, FALSE, '`TOTAL_BIAYA_ASKEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_ASKEP->Sortable = TRUE; // Allow sort
		$this->TOTAL_BIAYA_ASKEP->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_ASKEP'] = &$this->TOTAL_BIAYA_ASKEP;

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS = new cField('t_admission', 't_admission', 'x_TOTAL_BIAYA_SIMRS', 'TOTAL_BIAYA_SIMRS', '`TOTAL_BIAYA_SIMRS`', '`TOTAL_BIAYA_SIMRS`', 5, -1, FALSE, '`TOTAL_BIAYA_SIMRS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_BIAYA_SIMRS->Sortable = TRUE; // Allow sort
		$this->TOTAL_BIAYA_SIMRS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOTAL_BIAYA_SIMRS'] = &$this->TOTAL_BIAYA_SIMRS;

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS = new cField('t_admission', 't_admission', 'x_TOT_PENJ_NMEDIS', 'TOT_PENJ_NMEDIS', '`TOT_PENJ_NMEDIS`', '`TOT_PENJ_NMEDIS`', 5, -1, FALSE, '`TOT_PENJ_NMEDIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_PENJ_NMEDIS->Sortable = TRUE; // Allow sort
		$this->TOT_PENJ_NMEDIS->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_PENJ_NMEDIS'] = &$this->TOT_PENJ_NMEDIS;

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL = new cField('t_admission', 't_admission', 'x_LINK_MASTERDETAIL', 'LINK_MASTERDETAIL', '`LINK_MASTERDETAIL`', '`LINK_MASTERDETAIL`', 200, -1, FALSE, '`LINK_MASTERDETAIL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LINK_MASTERDETAIL->Sortable = TRUE; // Allow sort
		$this->fields['LINK_MASTERDETAIL'] = &$this->LINK_MASTERDETAIL;

		// NO_SKP
		$this->NO_SKP = new cField('t_admission', 't_admission', 'x_NO_SKP', 'NO_SKP', '`NO_SKP`', '`NO_SKP`', 200, -1, FALSE, '`NO_SKP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SKP->Sortable = TRUE; // Allow sort
		$this->fields['NO_SKP'] = &$this->NO_SKP;

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT = new cField('t_admission', 't_admission', 'x_LINK_PELAYANAN_OBAT', 'LINK_PELAYANAN_OBAT', '`LINK_PELAYANAN_OBAT`', '`LINK_PELAYANAN_OBAT`', 200, -1, FALSE, '`LINK_PELAYANAN_OBAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LINK_PELAYANAN_OBAT->Sortable = TRUE; // Allow sort
		$this->fields['LINK_PELAYANAN_OBAT'] = &$this->LINK_PELAYANAN_OBAT;

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL = new cField('t_admission', 't_admission', 'x_TOT_TIND_RAJAL', 'TOT_TIND_RAJAL', '`TOT_TIND_RAJAL`', '`TOT_TIND_RAJAL`', 5, -1, FALSE, '`TOT_TIND_RAJAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_TIND_RAJAL->Sortable = TRUE; // Allow sort
		$this->TOT_TIND_RAJAL->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_TIND_RAJAL'] = &$this->TOT_TIND_RAJAL;

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD = new cField('t_admission', 't_admission', 'x_TOT_TIND_IGD', 'TOT_TIND_IGD', '`TOT_TIND_IGD`', '`TOT_TIND_IGD`', 5, -1, FALSE, '`TOT_TIND_IGD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOT_TIND_IGD->Sortable = TRUE; // Allow sort
		$this->TOT_TIND_IGD->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TOT_TIND_IGD'] = &$this->TOT_TIND_IGD;

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status = new cField('t_admission', 't_admission', 'x_tanggal_pengembalian_status', 'tanggal_pengembalian_status', '`tanggal_pengembalian_status`', ew_CastDateFieldForLike('`tanggal_pengembalian_status`', 0, "DB"), 135, 0, FALSE, '`tanggal_pengembalian_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal_pengembalian_status->Sortable = TRUE; // Allow sort
		$this->tanggal_pengembalian_status->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tanggal_pengembalian_status'] = &$this->tanggal_pengembalian_status;

		// naik_kelas
		$this->naik_kelas = new cField('t_admission', 't_admission', 'x_naik_kelas', 'naik_kelas', '`naik_kelas`', '`naik_kelas`', 3, -1, FALSE, '`naik_kelas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->naik_kelas->Sortable = TRUE; // Allow sort
		$this->naik_kelas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['naik_kelas'] = &$this->naik_kelas;

		// iuran_kelas_lama
		$this->iuran_kelas_lama = new cField('t_admission', 't_admission', 'x_iuran_kelas_lama', 'iuran_kelas_lama', '`iuran_kelas_lama`', '`iuran_kelas_lama`', 5, -1, FALSE, '`iuran_kelas_lama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->iuran_kelas_lama->Sortable = TRUE; // Allow sort
		$this->iuran_kelas_lama->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['iuran_kelas_lama'] = &$this->iuran_kelas_lama;

		// iuran_kelas_baru
		$this->iuran_kelas_baru = new cField('t_admission', 't_admission', 'x_iuran_kelas_baru', 'iuran_kelas_baru', '`iuran_kelas_baru`', '`iuran_kelas_baru`', 5, -1, FALSE, '`iuran_kelas_baru`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->iuran_kelas_baru->Sortable = TRUE; // Allow sort
		$this->iuran_kelas_baru->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['iuran_kelas_baru'] = &$this->iuran_kelas_baru;

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas = new cField('t_admission', 't_admission', 'x_ketrangan_naik_kelas', 'ketrangan_naik_kelas', '`ketrangan_naik_kelas`', '`ketrangan_naik_kelas`', 200, -1, FALSE, '`ketrangan_naik_kelas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ketrangan_naik_kelas->Sortable = TRUE; // Allow sort
		$this->fields['ketrangan_naik_kelas'] = &$this->ketrangan_naik_kelas;

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim = new cField('t_admission', 't_admission', 'x_tgl_pengiriman_ad_klaim', 'tgl_pengiriman_ad_klaim', '`tgl_pengiriman_ad_klaim`', ew_CastDateFieldForLike('`tgl_pengiriman_ad_klaim`', 0, "DB"), 135, 0, FALSE, '`tgl_pengiriman_ad_klaim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tgl_pengiriman_ad_klaim->Sortable = TRUE; // Allow sort
		$this->tgl_pengiriman_ad_klaim->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['tgl_pengiriman_ad_klaim'] = &$this->tgl_pengiriman_ad_klaim;

		// diagnosa_keluar
		$this->diagnosa_keluar = new cField('t_admission', 't_admission', 'x_diagnosa_keluar', 'diagnosa_keluar', '`diagnosa_keluar`', '`diagnosa_keluar`', 3, -1, FALSE, '`diagnosa_keluar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->diagnosa_keluar->Sortable = TRUE; // Allow sort
		$this->diagnosa_keluar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['diagnosa_keluar'] = &$this->diagnosa_keluar;

		// sep_tglsep
		$this->sep_tglsep = new cField('t_admission', 't_admission', 'x_sep_tglsep', 'sep_tglsep', '`sep_tglsep`', ew_CastDateFieldForLike('`sep_tglsep`', 0, "DB"), 135, 0, FALSE, '`sep_tglsep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_tglsep->Sortable = TRUE; // Allow sort
		$this->sep_tglsep->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['sep_tglsep'] = &$this->sep_tglsep;

		// sep_tglrujuk
		$this->sep_tglrujuk = new cField('t_admission', 't_admission', 'x_sep_tglrujuk', 'sep_tglrujuk', '`sep_tglrujuk`', ew_CastDateFieldForLike('`sep_tglrujuk`', 0, "DB"), 135, 0, FALSE, '`sep_tglrujuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_tglrujuk->Sortable = TRUE; // Allow sort
		$this->sep_tglrujuk->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['sep_tglrujuk'] = &$this->sep_tglrujuk;

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat = new cField('t_admission', 't_admission', 'x_sep_kodekelasrawat', 'sep_kodekelasrawat', '`sep_kodekelasrawat`', '`sep_kodekelasrawat`', 200, -1, FALSE, '`sep_kodekelasrawat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodekelasrawat->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodekelasrawat'] = &$this->sep_kodekelasrawat;

		// sep_norujukan
		$this->sep_norujukan = new cField('t_admission', 't_admission', 'x_sep_norujukan', 'sep_norujukan', '`sep_norujukan`', '`sep_norujukan`', 200, -1, FALSE, '`sep_norujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_norujukan->Sortable = TRUE; // Allow sort
		$this->fields['sep_norujukan'] = &$this->sep_norujukan;

		// sep_kodeppkasal
		$this->sep_kodeppkasal = new cField('t_admission', 't_admission', 'x_sep_kodeppkasal', 'sep_kodeppkasal', '`sep_kodeppkasal`', '`sep_kodeppkasal`', 200, -1, FALSE, '`sep_kodeppkasal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodeppkasal->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodeppkasal'] = &$this->sep_kodeppkasal;

		// sep_namappkasal
		$this->sep_namappkasal = new cField('t_admission', 't_admission', 'x_sep_namappkasal', 'sep_namappkasal', '`sep_namappkasal`', '`sep_namappkasal`', 200, -1, FALSE, '`sep_namappkasal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namappkasal->Sortable = TRUE; // Allow sort
		$this->fields['sep_namappkasal'] = &$this->sep_namappkasal;

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan = new cField('t_admission', 't_admission', 'x_sep_kodeppkpelayanan', 'sep_kodeppkpelayanan', '`sep_kodeppkpelayanan`', '`sep_kodeppkpelayanan`', 200, -1, FALSE, '`sep_kodeppkpelayanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodeppkpelayanan->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodeppkpelayanan'] = &$this->sep_kodeppkpelayanan;

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan = new cField('t_admission', 't_admission', 'x_sep_namappkpelayanan', 'sep_namappkpelayanan', '`sep_namappkpelayanan`', '`sep_namappkpelayanan`', 200, -1, FALSE, '`sep_namappkpelayanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namappkpelayanan->Sortable = TRUE; // Allow sort
		$this->fields['sep_namappkpelayanan'] = &$this->sep_namappkpelayanan;

		// t_admissioncol
		$this->t_admissioncol = new cField('t_admission', 't_admission', 'x_t_admissioncol', 't_admissioncol', '`t_admissioncol`', '`t_admissioncol`', 200, -1, FALSE, '`t_admissioncol`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->t_admissioncol->Sortable = TRUE; // Allow sort
		$this->fields['t_admissioncol'] = &$this->t_admissioncol;

		// sep_jenisperawatan
		$this->sep_jenisperawatan = new cField('t_admission', 't_admission', 'x_sep_jenisperawatan', 'sep_jenisperawatan', '`sep_jenisperawatan`', '`sep_jenisperawatan`', 3, -1, FALSE, '`sep_jenisperawatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_jenisperawatan->Sortable = TRUE; // Allow sort
		$this->sep_jenisperawatan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_jenisperawatan'] = &$this->sep_jenisperawatan;

		// sep_catatan
		$this->sep_catatan = new cField('t_admission', 't_admission', 'x_sep_catatan', 'sep_catatan', '`sep_catatan`', '`sep_catatan`', 200, -1, FALSE, '`sep_catatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_catatan->Sortable = TRUE; // Allow sort
		$this->fields['sep_catatan'] = &$this->sep_catatan;

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal = new cField('t_admission', 't_admission', 'x_sep_kodediagnosaawal', 'sep_kodediagnosaawal', '`sep_kodediagnosaawal`', '`sep_kodediagnosaawal`', 200, -1, FALSE, '`sep_kodediagnosaawal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodediagnosaawal->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodediagnosaawal'] = &$this->sep_kodediagnosaawal;

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal = new cField('t_admission', 't_admission', 'x_sep_namadiagnosaawal', 'sep_namadiagnosaawal', '`sep_namadiagnosaawal`', '`sep_namadiagnosaawal`', 200, -1, FALSE, '`sep_namadiagnosaawal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namadiagnosaawal->Sortable = TRUE; // Allow sort
		$this->fields['sep_namadiagnosaawal'] = &$this->sep_namadiagnosaawal;

		// sep_lakalantas
		$this->sep_lakalantas = new cField('t_admission', 't_admission', 'x_sep_lakalantas', 'sep_lakalantas', '`sep_lakalantas`', '`sep_lakalantas`', 3, -1, FALSE, '`sep_lakalantas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_lakalantas->Sortable = TRUE; // Allow sort
		$this->sep_lakalantas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_lakalantas'] = &$this->sep_lakalantas;

		// sep_lokasilaka
		$this->sep_lokasilaka = new cField('t_admission', 't_admission', 'x_sep_lokasilaka', 'sep_lokasilaka', '`sep_lokasilaka`', '`sep_lokasilaka`', 200, -1, FALSE, '`sep_lokasilaka`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_lokasilaka->Sortable = TRUE; // Allow sort
		$this->fields['sep_lokasilaka'] = &$this->sep_lokasilaka;

		// sep_user
		$this->sep_user = new cField('t_admission', 't_admission', 'x_sep_user', 'sep_user', '`sep_user`', '`sep_user`', 200, -1, FALSE, '`sep_user`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_user->Sortable = TRUE; // Allow sort
		$this->fields['sep_user'] = &$this->sep_user;

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta = new cField('t_admission', 't_admission', 'x_sep_flag_cekpeserta', 'sep_flag_cekpeserta', '`sep_flag_cekpeserta`', '`sep_flag_cekpeserta`', 3, -1, FALSE, '`sep_flag_cekpeserta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_flag_cekpeserta->Sortable = TRUE; // Allow sort
		$this->sep_flag_cekpeserta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_flag_cekpeserta'] = &$this->sep_flag_cekpeserta;

		// sep_flag_generatesep
		$this->sep_flag_generatesep = new cField('t_admission', 't_admission', 'x_sep_flag_generatesep', 'sep_flag_generatesep', '`sep_flag_generatesep`', '`sep_flag_generatesep`', 3, -1, FALSE, '`sep_flag_generatesep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_flag_generatesep->Sortable = TRUE; // Allow sort
		$this->sep_flag_generatesep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_flag_generatesep'] = &$this->sep_flag_generatesep;

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep = new cField('t_admission', 't_admission', 'x_sep_flag_mapingsep', 'sep_flag_mapingsep', '`sep_flag_mapingsep`', '`sep_flag_mapingsep`', 3, -1, FALSE, '`sep_flag_mapingsep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_flag_mapingsep->Sortable = TRUE; // Allow sort
		$this->sep_flag_mapingsep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_flag_mapingsep'] = &$this->sep_flag_mapingsep;

		// sep_nik
		$this->sep_nik = new cField('t_admission', 't_admission', 'x_sep_nik', 'sep_nik', '`sep_nik`', '`sep_nik`', 200, -1, FALSE, '`sep_nik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_nik->Sortable = TRUE; // Allow sort
		$this->fields['sep_nik'] = &$this->sep_nik;

		// sep_namapeserta
		$this->sep_namapeserta = new cField('t_admission', 't_admission', 'x_sep_namapeserta', 'sep_namapeserta', '`sep_namapeserta`', '`sep_namapeserta`', 200, -1, FALSE, '`sep_namapeserta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namapeserta->Sortable = TRUE; // Allow sort
		$this->fields['sep_namapeserta'] = &$this->sep_namapeserta;

		// sep_jeniskelamin
		$this->sep_jeniskelamin = new cField('t_admission', 't_admission', 'x_sep_jeniskelamin', 'sep_jeniskelamin', '`sep_jeniskelamin`', '`sep_jeniskelamin`', 200, -1, FALSE, '`sep_jeniskelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_jeniskelamin->Sortable = TRUE; // Allow sort
		$this->fields['sep_jeniskelamin'] = &$this->sep_jeniskelamin;

		// sep_pisat
		$this->sep_pisat = new cField('t_admission', 't_admission', 'x_sep_pisat', 'sep_pisat', '`sep_pisat`', '`sep_pisat`', 200, -1, FALSE, '`sep_pisat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_pisat->Sortable = TRUE; // Allow sort
		$this->fields['sep_pisat'] = &$this->sep_pisat;

		// sep_tgllahir
		$this->sep_tgllahir = new cField('t_admission', 't_admission', 'x_sep_tgllahir', 'sep_tgllahir', '`sep_tgllahir`', '`sep_tgllahir`', 200, -1, FALSE, '`sep_tgllahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_tgllahir->Sortable = TRUE; // Allow sort
		$this->fields['sep_tgllahir'] = &$this->sep_tgllahir;

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan = new cField('t_admission', 't_admission', 'x_sep_kodejeniskepesertaan', 'sep_kodejeniskepesertaan', '`sep_kodejeniskepesertaan`', '`sep_kodejeniskepesertaan`', 200, -1, FALSE, '`sep_kodejeniskepesertaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodejeniskepesertaan->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodejeniskepesertaan'] = &$this->sep_kodejeniskepesertaan;

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan = new cField('t_admission', 't_admission', 'x_sep_namajeniskepesertaan', 'sep_namajeniskepesertaan', '`sep_namajeniskepesertaan`', '`sep_namajeniskepesertaan`', 200, -1, FALSE, '`sep_namajeniskepesertaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namajeniskepesertaan->Sortable = TRUE; // Allow sort
		$this->fields['sep_namajeniskepesertaan'] = &$this->sep_namajeniskepesertaan;

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan = new cField('t_admission', 't_admission', 'x_sep_kodepolitujuan', 'sep_kodepolitujuan', '`sep_kodepolitujuan`', '`sep_kodepolitujuan`', 200, -1, FALSE, '`sep_kodepolitujuan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodepolitujuan->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodepolitujuan'] = &$this->sep_kodepolitujuan;

		// sep_namapolitujuan
		$this->sep_namapolitujuan = new cField('t_admission', 't_admission', 'x_sep_namapolitujuan', 'sep_namapolitujuan', '`sep_namapolitujuan`', '`sep_namapolitujuan`', 200, -1, FALSE, '`sep_namapolitujuan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namapolitujuan->Sortable = TRUE; // Allow sort
		$this->fields['sep_namapolitujuan'] = &$this->sep_namapolitujuan;

		// ket_jeniskelamin
		$this->ket_jeniskelamin = new cField('t_admission', 't_admission', 'x_ket_jeniskelamin', 'ket_jeniskelamin', '`ket_jeniskelamin`', '`ket_jeniskelamin`', 200, -1, FALSE, '`ket_jeniskelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_jeniskelamin->Sortable = TRUE; // Allow sort
		$this->fields['ket_jeniskelamin'] = &$this->ket_jeniskelamin;

		// sep_nokabpjs
		$this->sep_nokabpjs = new cField('t_admission', 't_admission', 'x_sep_nokabpjs', 'sep_nokabpjs', '`sep_nokabpjs`', '`sep_nokabpjs`', 200, -1, FALSE, '`sep_nokabpjs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_nokabpjs->Sortable = TRUE; // Allow sort
		$this->fields['sep_nokabpjs'] = &$this->sep_nokabpjs;

		// counter_cetak_sep
		$this->counter_cetak_sep = new cField('t_admission', 't_admission', 'x_counter_cetak_sep', 'counter_cetak_sep', '`counter_cetak_sep`', '`counter_cetak_sep`', 3, -1, FALSE, '`counter_cetak_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->counter_cetak_sep->Sortable = TRUE; // Allow sort
		$this->counter_cetak_sep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['counter_cetak_sep'] = &$this->counter_cetak_sep;

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep = new cField('t_admission', 't_admission', 'x_sep_petugas_hapus_sep', 'sep_petugas_hapus_sep', '`sep_petugas_hapus_sep`', '`sep_petugas_hapus_sep`', 200, -1, FALSE, '`sep_petugas_hapus_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_petugas_hapus_sep->Sortable = TRUE; // Allow sort
		$this->fields['sep_petugas_hapus_sep'] = &$this->sep_petugas_hapus_sep;

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang = new cField('t_admission', 't_admission', 'x_sep_petugas_set_tgl_pulang', 'sep_petugas_set_tgl_pulang', '`sep_petugas_set_tgl_pulang`', '`sep_petugas_set_tgl_pulang`', 200, -1, FALSE, '`sep_petugas_set_tgl_pulang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_petugas_set_tgl_pulang->Sortable = TRUE; // Allow sort
		$this->fields['sep_petugas_set_tgl_pulang'] = &$this->sep_petugas_set_tgl_pulang;

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep = new cField('t_admission', 't_admission', 'x_sep_jam_generate_sep', 'sep_jam_generate_sep', '`sep_jam_generate_sep`', ew_CastDateFieldForLike('`sep_jam_generate_sep`', 0, "DB"), 135, 0, FALSE, '`sep_jam_generate_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_jam_generate_sep->Sortable = TRUE; // Allow sort
		$this->sep_jam_generate_sep->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['sep_jam_generate_sep'] = &$this->sep_jam_generate_sep;

		// sep_status_peserta
		$this->sep_status_peserta = new cField('t_admission', 't_admission', 'x_sep_status_peserta', 'sep_status_peserta', '`sep_status_peserta`', '`sep_status_peserta`', 200, -1, FALSE, '`sep_status_peserta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_status_peserta->Sortable = TRUE; // Allow sort
		$this->fields['sep_status_peserta'] = &$this->sep_status_peserta;

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang = new cField('t_admission', 't_admission', 'x_sep_umur_pasien_sekarang', 'sep_umur_pasien_sekarang', '`sep_umur_pasien_sekarang`', '`sep_umur_pasien_sekarang`', 200, -1, FALSE, '`sep_umur_pasien_sekarang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_umur_pasien_sekarang->Sortable = TRUE; // Allow sort
		$this->fields['sep_umur_pasien_sekarang'] = &$this->sep_umur_pasien_sekarang;

		// ket_title
		$this->ket_title = new cField('t_admission', 't_admission', 'x_ket_title', 'ket_title', '`ket_title`', '`ket_title`', 200, -1, FALSE, '`ket_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_title->Sortable = TRUE; // Allow sort
		$this->fields['ket_title'] = &$this->ket_title;

		// status_daftar_ranap
		$this->status_daftar_ranap = new cField('t_admission', 't_admission', 'x_status_daftar_ranap', 'status_daftar_ranap', '`status_daftar_ranap`', '`status_daftar_ranap`', 3, -1, FALSE, '`status_daftar_ranap`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_daftar_ranap->Sortable = TRUE; // Allow sort
		$this->status_daftar_ranap->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_daftar_ranap'] = &$this->status_daftar_ranap;

		// IBS_SETMARKING
		$this->IBS_SETMARKING = new cField('t_admission', 't_admission', 'x_IBS_SETMARKING', 'IBS_SETMARKING', '`IBS_SETMARKING`', '`IBS_SETMARKING`', 3, -1, FALSE, '`IBS_SETMARKING`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_SETMARKING->Sortable = TRUE; // Allow sort
		$this->IBS_SETMARKING->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IBS_SETMARKING'] = &$this->IBS_SETMARKING;

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI = new cField('t_admission', 't_admission', 'x_IBS_PATOLOGI', 'IBS_PATOLOGI', '`IBS_PATOLOGI`', '`IBS_PATOLOGI`', 3, -1, FALSE, '`IBS_PATOLOGI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_PATOLOGI->Sortable = TRUE; // Allow sort
		$this->IBS_PATOLOGI->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IBS_PATOLOGI'] = &$this->IBS_PATOLOGI;

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI = new cField('t_admission', 't_admission', 'x_IBS_JENISANESTESI', 'IBS_JENISANESTESI', '`IBS_JENISANESTESI`', '`IBS_JENISANESTESI`', 3, -1, FALSE, '`IBS_JENISANESTESI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_JENISANESTESI->Sortable = TRUE; // Allow sort
		$this->IBS_JENISANESTESI->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IBS_JENISANESTESI'] = &$this->IBS_JENISANESTESI;

		// IBS_NO_OK
		$this->IBS_NO_OK = new cField('t_admission', 't_admission', 'x_IBS_NO_OK', 'IBS_NO_OK', '`IBS_NO_OK`', '`IBS_NO_OK`', 3, -1, FALSE, '`IBS_NO_OK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_NO_OK->Sortable = TRUE; // Allow sort
		$this->IBS_NO_OK->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IBS_NO_OK'] = &$this->IBS_NO_OK;

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN = new cField('t_admission', 't_admission', 'x_IBS_ASISSTEN', 'IBS_ASISSTEN', '`IBS_ASISSTEN`', '`IBS_ASISSTEN`', 200, -1, FALSE, '`IBS_ASISSTEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_ASISSTEN->Sortable = TRUE; // Allow sort
		$this->fields['IBS_ASISSTEN'] = &$this->IBS_ASISSTEN;

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF = new cField('t_admission', 't_admission', 'x_IBS_JAM_ELEFTIF', 'IBS_JAM_ELEFTIF', '`IBS_JAM_ELEFTIF`', ew_CastDateFieldForLike('`IBS_JAM_ELEFTIF`', 0, "DB"), 135, 0, FALSE, '`IBS_JAM_ELEFTIF`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_JAM_ELEFTIF->Sortable = TRUE; // Allow sort
		$this->IBS_JAM_ELEFTIF->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['IBS_JAM_ELEFTIF'] = &$this->IBS_JAM_ELEFTIF;

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI = new cField('t_admission', 't_admission', 'x_IBS_JAM_ELEKTIF_SELESAI', 'IBS_JAM_ELEKTIF_SELESAI', '`IBS_JAM_ELEKTIF_SELESAI`', ew_CastDateFieldForLike('`IBS_JAM_ELEKTIF_SELESAI`', 0, "DB"), 135, 0, FALSE, '`IBS_JAM_ELEKTIF_SELESAI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_JAM_ELEKTIF_SELESAI->Sortable = TRUE; // Allow sort
		$this->IBS_JAM_ELEKTIF_SELESAI->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['IBS_JAM_ELEKTIF_SELESAI'] = &$this->IBS_JAM_ELEKTIF_SELESAI;

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO = new cField('t_admission', 't_admission', 'x_IBS_JAM_CYTO', 'IBS_JAM_CYTO', '`IBS_JAM_CYTO`', ew_CastDateFieldForLike('`IBS_JAM_CYTO`', 0, "DB"), 135, 0, FALSE, '`IBS_JAM_CYTO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_JAM_CYTO->Sortable = TRUE; // Allow sort
		$this->IBS_JAM_CYTO->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['IBS_JAM_CYTO'] = &$this->IBS_JAM_CYTO;

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI = new cField('t_admission', 't_admission', 'x_IBS_JAM_CYTO_SELESAI', 'IBS_JAM_CYTO_SELESAI', '`IBS_JAM_CYTO_SELESAI`', ew_CastDateFieldForLike('`IBS_JAM_CYTO_SELESAI`', 0, "DB"), 135, 0, FALSE, '`IBS_JAM_CYTO_SELESAI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_JAM_CYTO_SELESAI->Sortable = TRUE; // Allow sort
		$this->IBS_JAM_CYTO_SELESAI->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['IBS_JAM_CYTO_SELESAI'] = &$this->IBS_JAM_CYTO_SELESAI;

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP = new cField('t_admission', 't_admission', 'x_IBS_TGL_DFTR_OP', 'IBS_TGL_DFTR_OP', '`IBS_TGL_DFTR_OP`', ew_CastDateFieldForLike('`IBS_TGL_DFTR_OP`', 0, "DB"), 135, 0, FALSE, '`IBS_TGL_DFTR_OP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_TGL_DFTR_OP->Sortable = TRUE; // Allow sort
		$this->IBS_TGL_DFTR_OP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['IBS_TGL_DFTR_OP'] = &$this->IBS_TGL_DFTR_OP;

		// IBS_TGL_OP
		$this->IBS_TGL_OP = new cField('t_admission', 't_admission', 'x_IBS_TGL_OP', 'IBS_TGL_OP', '`IBS_TGL_OP`', ew_CastDateFieldForLike('`IBS_TGL_OP`', 0, "DB"), 135, 0, FALSE, '`IBS_TGL_OP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBS_TGL_OP->Sortable = TRUE; // Allow sort
		$this->IBS_TGL_OP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['IBS_TGL_OP'] = &$this->IBS_TGL_OP;

		// grup_ruang_id
		$this->grup_ruang_id = new cField('t_admission', 't_admission', 'x_grup_ruang_id', 'grup_ruang_id', '`grup_ruang_id`', '`grup_ruang_id`', 3, -1, FALSE, '`grup_ruang_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grup_ruang_id->Sortable = TRUE; // Allow sort
		$this->grup_ruang_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['grup_ruang_id'] = &$this->grup_ruang_id;

		// status_order_ibs
		$this->status_order_ibs = new cField('t_admission', 't_admission', 'x_status_order_ibs', 'status_order_ibs', '`status_order_ibs`', '`status_order_ibs`', 3, -1, FALSE, '`status_order_ibs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_order_ibs->Sortable = TRUE; // Allow sort
		$this->status_order_ibs->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status_order_ibs'] = &$this->status_order_ibs;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`t_admission`";
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
		$this->TableFilter = "isnull(`keluarrs`)";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`id_admission` ASC,`noruang` ASC,`nott` ASC";
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
			$fldname = 'id_admission';
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
		if ($bDelete && $this->AuditTrailOnDelete)
			$this->WriteAuditTrailOnDelete($rs);
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
			return "t_admissionlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "t_admissionlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("t_admissionview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("t_admissionview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "t_admissionadd.php?" . $this->UrlParm($parm);
		else
			$url = "t_admissionadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("t_admissionedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("t_admissionadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("t_admissiondelete.php", $this->UrlParm());
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
		$this->ket_tgllahir->setDbValue($rs->fields('ket_tgllahir'));
		$this->ket_alamat->setDbValue($rs->fields('ket_alamat'));
		$this->parent_nomr->setDbValue($rs->fields('parent_nomr'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->nott->setDbValue($rs->fields('nott'));
		$this->deposit->setDbValue($rs->fields('deposit'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
		$this->icd_masuk->setDbValue($rs->fields('icd_masuk'));
		$this->icd_keluar->setDbValue($rs->fields('icd_keluar'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->noruang_asal->setDbValue($rs->fields('noruang_asal'));
		$this->nott_asal->setDbValue($rs->fields('nott_asal'));
		$this->tgl_pindah->setDbValue($rs->fields('tgl_pindah'));
		$this->kd_rujuk->setDbValue($rs->fields('kd_rujuk'));
		$this->st_bayar->setDbValue($rs->fields('st_bayar'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->perawat->setDbValue($rs->fields('perawat'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->LOS->setDbValue($rs->fields('LOS'));
		$this->TOT_TRF_TIND_DOKTER->setDbValue($rs->fields('TOT_TRF_TIND_DOKTER'));
		$this->TOT_BHP_DOKTER->setDbValue($rs->fields('TOT_BHP_DOKTER'));
		$this->TOT_TRF_PERAWAT->setDbValue($rs->fields('TOT_TRF_PERAWAT'));
		$this->TOT_BHP_PERAWAT->setDbValue($rs->fields('TOT_BHP_PERAWAT'));
		$this->TOT_TRF_DOKTER->setDbValue($rs->fields('TOT_TRF_DOKTER'));
		$this->TOT_BIAYA_RAD->setDbValue($rs->fields('TOT_BIAYA_RAD'));
		$this->TOT_BIAYA_CDRPOLI->setDbValue($rs->fields('TOT_BIAYA_CDRPOLI'));
		$this->TOT_BIAYA_LAB_IGD->setDbValue($rs->fields('TOT_BIAYA_LAB_IGD'));
		$this->TOT_BIAYA_OKSIGEN->setDbValue($rs->fields('TOT_BIAYA_OKSIGEN'));
		$this->TOTAL_BIAYA_OBAT->setDbValue($rs->fields('TOTAL_BIAYA_OBAT'));
		$this->LINK_SET_KELAS->setDbValue($rs->fields('LINK_SET_KELAS'));
		$this->biaya_obat->setDbValue($rs->fields('biaya_obat'));
		$this->biaya_retur_obat->setDbValue($rs->fields('biaya_retur_obat'));
		$this->TOT_BIAYA_GIZI->setDbValue($rs->fields('TOT_BIAYA_GIZI'));
		$this->TOT_BIAYA_TMO->setDbValue($rs->fields('TOT_BIAYA_TMO'));
		$this->TOT_BIAYA_AMBULAN->setDbValue($rs->fields('TOT_BIAYA_AMBULAN'));
		$this->TOT_BIAYA_FISIO->setDbValue($rs->fields('TOT_BIAYA_FISIO'));
		$this->TOT_BIAYA_LAINLAIN->setDbValue($rs->fields('TOT_BIAYA_LAINLAIN'));
		$this->jenisperawatan_id->setDbValue($rs->fields('jenisperawatan_id'));
		$this->status_transaksi->setDbValue($rs->fields('status_transaksi'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
		$this->TOT_BIAYA_AKOMODASI->setDbValue($rs->fields('TOT_BIAYA_AKOMODASI'));
		$this->TOTAL_BIAYA_ASKEP->setDbValue($rs->fields('TOTAL_BIAYA_ASKEP'));
		$this->TOTAL_BIAYA_SIMRS->setDbValue($rs->fields('TOTAL_BIAYA_SIMRS'));
		$this->TOT_PENJ_NMEDIS->setDbValue($rs->fields('TOT_PENJ_NMEDIS'));
		$this->LINK_MASTERDETAIL->setDbValue($rs->fields('LINK_MASTERDETAIL'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->LINK_PELAYANAN_OBAT->setDbValue($rs->fields('LINK_PELAYANAN_OBAT'));
		$this->TOT_TIND_RAJAL->setDbValue($rs->fields('TOT_TIND_RAJAL'));
		$this->TOT_TIND_IGD->setDbValue($rs->fields('TOT_TIND_IGD'));
		$this->tanggal_pengembalian_status->setDbValue($rs->fields('tanggal_pengembalian_status'));
		$this->naik_kelas->setDbValue($rs->fields('naik_kelas'));
		$this->iuran_kelas_lama->setDbValue($rs->fields('iuran_kelas_lama'));
		$this->iuran_kelas_baru->setDbValue($rs->fields('iuran_kelas_baru'));
		$this->ketrangan_naik_kelas->setDbValue($rs->fields('ketrangan_naik_kelas'));
		$this->tgl_pengiriman_ad_klaim->setDbValue($rs->fields('tgl_pengiriman_ad_klaim'));
		$this->diagnosa_keluar->setDbValue($rs->fields('diagnosa_keluar'));
		$this->sep_tglsep->setDbValue($rs->fields('sep_tglsep'));
		$this->sep_tglrujuk->setDbValue($rs->fields('sep_tglrujuk'));
		$this->sep_kodekelasrawat->setDbValue($rs->fields('sep_kodekelasrawat'));
		$this->sep_norujukan->setDbValue($rs->fields('sep_norujukan'));
		$this->sep_kodeppkasal->setDbValue($rs->fields('sep_kodeppkasal'));
		$this->sep_namappkasal->setDbValue($rs->fields('sep_namappkasal'));
		$this->sep_kodeppkpelayanan->setDbValue($rs->fields('sep_kodeppkpelayanan'));
		$this->sep_namappkpelayanan->setDbValue($rs->fields('sep_namappkpelayanan'));
		$this->t_admissioncol->setDbValue($rs->fields('t_admissioncol'));
		$this->sep_jenisperawatan->setDbValue($rs->fields('sep_jenisperawatan'));
		$this->sep_catatan->setDbValue($rs->fields('sep_catatan'));
		$this->sep_kodediagnosaawal->setDbValue($rs->fields('sep_kodediagnosaawal'));
		$this->sep_namadiagnosaawal->setDbValue($rs->fields('sep_namadiagnosaawal'));
		$this->sep_lakalantas->setDbValue($rs->fields('sep_lakalantas'));
		$this->sep_lokasilaka->setDbValue($rs->fields('sep_lokasilaka'));
		$this->sep_user->setDbValue($rs->fields('sep_user'));
		$this->sep_flag_cekpeserta->setDbValue($rs->fields('sep_flag_cekpeserta'));
		$this->sep_flag_generatesep->setDbValue($rs->fields('sep_flag_generatesep'));
		$this->sep_flag_mapingsep->setDbValue($rs->fields('sep_flag_mapingsep'));
		$this->sep_nik->setDbValue($rs->fields('sep_nik'));
		$this->sep_namapeserta->setDbValue($rs->fields('sep_namapeserta'));
		$this->sep_jeniskelamin->setDbValue($rs->fields('sep_jeniskelamin'));
		$this->sep_pisat->setDbValue($rs->fields('sep_pisat'));
		$this->sep_tgllahir->setDbValue($rs->fields('sep_tgllahir'));
		$this->sep_kodejeniskepesertaan->setDbValue($rs->fields('sep_kodejeniskepesertaan'));
		$this->sep_namajeniskepesertaan->setDbValue($rs->fields('sep_namajeniskepesertaan'));
		$this->sep_kodepolitujuan->setDbValue($rs->fields('sep_kodepolitujuan'));
		$this->sep_namapolitujuan->setDbValue($rs->fields('sep_namapolitujuan'));
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->sep_nokabpjs->setDbValue($rs->fields('sep_nokabpjs'));
		$this->counter_cetak_sep->setDbValue($rs->fields('counter_cetak_sep'));
		$this->sep_petugas_hapus_sep->setDbValue($rs->fields('sep_petugas_hapus_sep'));
		$this->sep_petugas_set_tgl_pulang->setDbValue($rs->fields('sep_petugas_set_tgl_pulang'));
		$this->sep_jam_generate_sep->setDbValue($rs->fields('sep_jam_generate_sep'));
		$this->sep_status_peserta->setDbValue($rs->fields('sep_status_peserta'));
		$this->sep_umur_pasien_sekarang->setDbValue($rs->fields('sep_umur_pasien_sekarang'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->status_daftar_ranap->setDbValue($rs->fields('status_daftar_ranap'));
		$this->IBS_SETMARKING->setDbValue($rs->fields('IBS_SETMARKING'));
		$this->IBS_PATOLOGI->setDbValue($rs->fields('IBS_PATOLOGI'));
		$this->IBS_JENISANESTESI->setDbValue($rs->fields('IBS_JENISANESTESI'));
		$this->IBS_NO_OK->setDbValue($rs->fields('IBS_NO_OK'));
		$this->IBS_ASISSTEN->setDbValue($rs->fields('IBS_ASISSTEN'));
		$this->IBS_JAM_ELEFTIF->setDbValue($rs->fields('IBS_JAM_ELEFTIF'));
		$this->IBS_JAM_ELEKTIF_SELESAI->setDbValue($rs->fields('IBS_JAM_ELEKTIF_SELESAI'));
		$this->IBS_JAM_CYTO->setDbValue($rs->fields('IBS_JAM_CYTO'));
		$this->IBS_JAM_CYTO_SELESAI->setDbValue($rs->fields('IBS_JAM_CYTO_SELESAI'));
		$this->IBS_TGL_DFTR_OP->setDbValue($rs->fields('IBS_TGL_DFTR_OP'));
		$this->IBS_TGL_OP->setDbValue($rs->fields('IBS_TGL_OP'));
		$this->grup_ruang_id->setDbValue($rs->fields('grup_ruang_id'));
		$this->status_order_ibs->setDbValue($rs->fields('status_order_ibs'));
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
		// ket_tgllahir
		// ket_alamat
		// parent_nomr
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// nott
		// deposit
		// keluarrs
		// icd_masuk
		// icd_keluar
		// NIP
		// noruang_asal
		// nott_asal
		// tgl_pindah
		// kd_rujuk
		// st_bayar
		// dokter_penanggungjawab
		// perawat
		// KELASPERAWATAN_ID
		// LOS
		// TOT_TRF_TIND_DOKTER
		// TOT_BHP_DOKTER
		// TOT_TRF_PERAWAT
		// TOT_BHP_PERAWAT
		// TOT_TRF_DOKTER
		// TOT_BIAYA_RAD
		// TOT_BIAYA_CDRPOLI
		// TOT_BIAYA_LAB_IGD
		// TOT_BIAYA_OKSIGEN
		// TOTAL_BIAYA_OBAT
		// LINK_SET_KELAS
		// biaya_obat
		// biaya_retur_obat
		// TOT_BIAYA_GIZI
		// TOT_BIAYA_TMO
		// TOT_BIAYA_AMBULAN
		// TOT_BIAYA_FISIO
		// TOT_BIAYA_LAINLAIN
		// jenisperawatan_id
		// status_transaksi
		// statuskeluarranap_id
		// TOT_BIAYA_AKOMODASI
		// TOTAL_BIAYA_ASKEP
		// TOTAL_BIAYA_SIMRS
		// TOT_PENJ_NMEDIS
		// LINK_MASTERDETAIL
		// NO_SKP
		// LINK_PELAYANAN_OBAT
		// TOT_TIND_RAJAL
		// TOT_TIND_IGD
		// tanggal_pengembalian_status
		// naik_kelas
		// iuran_kelas_lama
		// iuran_kelas_baru
		// ketrangan_naik_kelas
		// tgl_pengiriman_ad_klaim
		// diagnosa_keluar
		// sep_tglsep
		// sep_tglrujuk
		// sep_kodekelasrawat
		// sep_norujukan
		// sep_kodeppkasal
		// sep_namappkasal
		// sep_kodeppkpelayanan
		// sep_namappkpelayanan
		// t_admissioncol
		// sep_jenisperawatan
		// sep_catatan
		// sep_kodediagnosaawal
		// sep_namadiagnosaawal
		// sep_lakalantas
		// sep_lokasilaka
		// sep_user
		// sep_flag_cekpeserta
		// sep_flag_generatesep
		// sep_flag_mapingsep
		// sep_nik
		// sep_namapeserta
		// sep_jeniskelamin
		// sep_pisat
		// sep_tgllahir
		// sep_kodejeniskepesertaan
		// sep_namajeniskepesertaan
		// sep_kodepolitujuan
		// sep_namapolitujuan
		// ket_jeniskelamin
		// sep_nokabpjs
		// counter_cetak_sep
		// sep_petugas_hapus_sep
		// sep_petugas_set_tgl_pulang
		// sep_jam_generate_sep
		// sep_status_peserta
		// sep_umur_pasien_sekarang
		// ket_title
		// status_daftar_ranap
		// IBS_SETMARKING
		// IBS_PATOLOGI
		// IBS_JENISANESTESI
		// IBS_NO_OK
		// IBS_ASISSTEN
		// IBS_JAM_ELEFTIF
		// IBS_JAM_ELEKTIF_SELESAI
		// IBS_JAM_CYTO
		// IBS_JAM_CYTO_SELESAI
		// IBS_TGL_DFTR_OP
		// IBS_TGL_OP
		// grup_ruang_id
		// status_order_ibs
		// id_admission

		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
		if (strval($this->nomr->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->nomr->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->nomr->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->nomr, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->nomr->ViewValue = $this->nomr->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->nomr->ViewValue = $this->nomr->CurrentValue;
			}
		} else {
			$this->nomr->ViewValue = NULL;
		}
		$this->nomr->ViewCustomAttributes = "";

		// ket_nama
		$this->ket_nama->ViewValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->ViewCustomAttributes = "";

		// ket_tgllahir
		$this->ket_tgllahir->ViewValue = $this->ket_tgllahir->CurrentValue;
		$this->ket_tgllahir->ViewValue = ew_FormatDateTime($this->ket_tgllahir->ViewValue, 0);
		$this->ket_tgllahir->ViewCustomAttributes = "";

		// ket_alamat
		$this->ket_alamat->ViewValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->ViewCustomAttributes = "";

		// parent_nomr
		$this->parent_nomr->ViewValue = $this->parent_nomr->CurrentValue;
		$this->parent_nomr->ViewCustomAttributes = "";

		// dokterpengirim
		if (strval($this->dokterpengirim->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->dokterpengirim->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->dokterpengirim->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->dokterpengirim, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->dokterpengirim->ViewValue = $this->dokterpengirim->CurrentValue;
			}
		} else {
			$this->dokterpengirim->ViewValue = NULL;
		}
		$this->dokterpengirim->ViewCustomAttributes = "";

		// statusbayar
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

		// kirimdari
		$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
		if (strval($this->kirimdari->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->kirimdari->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->kirimdari->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kirimdari, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kirimdari->ViewValue = $this->kirimdari->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kirimdari->ViewValue = $this->kirimdari->CurrentValue;
			}
		} else {
			$this->kirimdari->ViewValue = NULL;
		}
		$this->kirimdari->ViewCustomAttributes = "";

		// keluargadekat
		$this->keluargadekat->ViewValue = $this->keluargadekat->CurrentValue;
		$this->keluargadekat->ViewCustomAttributes = "";

		// panggungjawab
		$this->panggungjawab->ViewValue = $this->panggungjawab->CurrentValue;
		$this->panggungjawab->ViewCustomAttributes = "";

		// masukrs
		$this->masukrs->ViewValue = $this->masukrs->CurrentValue;
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 11);
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

		// tempat_tidur_id
		if (strval($this->tempat_tidur_id->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->tempat_tidur_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `no_tt` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_detail_tempat_tidur`";
		$sWhereWrk = "";
		$this->tempat_tidur_id->LookupFilters = array();
		$lookuptblfilter = "isnull(`KETERANGAN`)";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

		// deposit
		$this->deposit->ViewValue = $this->deposit->CurrentValue;
		$this->deposit->ViewCustomAttributes = "";

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 0);
		$this->keluarrs->ViewCustomAttributes = "";

		// icd_masuk
		$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
		if (strval($this->icd_masuk->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->icd_masuk->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, `STR` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
		$sWhereWrk = "";
		$this->icd_masuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->icd_masuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->icd_masuk->ViewValue = $this->icd_masuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->icd_masuk->ViewValue = $this->icd_masuk->CurrentValue;
			}
		} else {
			$this->icd_masuk->ViewValue = NULL;
		}
		$this->icd_masuk->ViewCustomAttributes = "";

		// icd_keluar
		$this->icd_keluar->ViewValue = $this->icd_keluar->CurrentValue;
		$this->icd_keluar->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// noruang_asal
		$this->noruang_asal->ViewValue = $this->noruang_asal->CurrentValue;
		$this->noruang_asal->ViewCustomAttributes = "";

		// nott_asal
		$this->nott_asal->ViewValue = $this->nott_asal->CurrentValue;
		$this->nott_asal->ViewCustomAttributes = "";

		// tgl_pindah
		$this->tgl_pindah->ViewValue = $this->tgl_pindah->CurrentValue;
		$this->tgl_pindah->ViewValue = ew_FormatDateTime($this->tgl_pindah->ViewValue, 0);
		$this->tgl_pindah->ViewCustomAttributes = "";

		// kd_rujuk
		if (strval($this->kd_rujuk->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->kd_rujuk->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->kd_rujuk->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->kd_rujuk, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->kd_rujuk->ViewValue = $this->kd_rujuk->CurrentValue;
			}
		} else {
			$this->kd_rujuk->ViewValue = NULL;
		}
		$this->kd_rujuk->ViewCustomAttributes = "";

		// st_bayar
		$this->st_bayar->ViewValue = $this->st_bayar->CurrentValue;
		$this->st_bayar->ViewCustomAttributes = "";

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

		// perawat
		$this->perawat->ViewValue = $this->perawat->CurrentValue;
		$this->perawat->ViewCustomAttributes = "";

		// KELASPERAWATAN_ID
		if (strval($this->KELASPERAWATAN_ID->CurrentValue) <> "") {
			$sFilterWrk = "`kelasperawatan_id`" . ew_SearchString("=", $this->KELASPERAWATAN_ID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kelasperawatan_id`, `kelasperawatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_kelas_perawatan`";
		$sWhereWrk = "";
		$this->KELASPERAWATAN_ID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KELASPERAWATAN_ID, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KELASPERAWATAN_ID->ViewValue = $this->KELASPERAWATAN_ID->CurrentValue;
			}
		} else {
			$this->KELASPERAWATAN_ID->ViewValue = NULL;
		}
		$this->KELASPERAWATAN_ID->ViewCustomAttributes = "";

		// LOS
		$this->LOS->ViewValue = $this->LOS->CurrentValue;
		$this->LOS->ViewCustomAttributes = "";

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER->ViewValue = $this->TOT_TRF_TIND_DOKTER->CurrentValue;
		$this->TOT_TRF_TIND_DOKTER->ViewCustomAttributes = "";

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER->ViewValue = $this->TOT_BHP_DOKTER->CurrentValue;
		$this->TOT_BHP_DOKTER->ViewCustomAttributes = "";

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT->ViewValue = $this->TOT_TRF_PERAWAT->CurrentValue;
		$this->TOT_TRF_PERAWAT->ViewCustomAttributes = "";

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT->ViewValue = $this->TOT_BHP_PERAWAT->CurrentValue;
		$this->TOT_BHP_PERAWAT->ViewCustomAttributes = "";

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER->ViewValue = $this->TOT_TRF_DOKTER->CurrentValue;
		$this->TOT_TRF_DOKTER->ViewCustomAttributes = "";

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD->ViewValue = $this->TOT_BIAYA_RAD->CurrentValue;
		$this->TOT_BIAYA_RAD->ViewCustomAttributes = "";

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI->ViewValue = $this->TOT_BIAYA_CDRPOLI->CurrentValue;
		$this->TOT_BIAYA_CDRPOLI->ViewCustomAttributes = "";

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD->ViewValue = $this->TOT_BIAYA_LAB_IGD->CurrentValue;
		$this->TOT_BIAYA_LAB_IGD->ViewCustomAttributes = "";

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN->ViewValue = $this->TOT_BIAYA_OKSIGEN->CurrentValue;
		$this->TOT_BIAYA_OKSIGEN->ViewCustomAttributes = "";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->ViewValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->ViewCustomAttributes = "";

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS->ViewValue = $this->LINK_SET_KELAS->CurrentValue;
		$this->LINK_SET_KELAS->ViewCustomAttributes = "";

		// biaya_obat
		$this->biaya_obat->ViewValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->ViewCustomAttributes = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->ViewValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->ViewCustomAttributes = "";

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI->ViewValue = $this->TOT_BIAYA_GIZI->CurrentValue;
		$this->TOT_BIAYA_GIZI->ViewCustomAttributes = "";

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO->ViewValue = $this->TOT_BIAYA_TMO->CurrentValue;
		$this->TOT_BIAYA_TMO->ViewCustomAttributes = "";

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN->ViewValue = $this->TOT_BIAYA_AMBULAN->CurrentValue;
		$this->TOT_BIAYA_AMBULAN->ViewCustomAttributes = "";

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO->ViewValue = $this->TOT_BIAYA_FISIO->CurrentValue;
		$this->TOT_BIAYA_FISIO->ViewCustomAttributes = "";

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN->ViewValue = $this->TOT_BIAYA_LAINLAIN->CurrentValue;
		$this->TOT_BIAYA_LAINLAIN->ViewCustomAttributes = "";

		// jenisperawatan_id
		$this->jenisperawatan_id->ViewValue = $this->jenisperawatan_id->CurrentValue;
		$this->jenisperawatan_id->ViewCustomAttributes = "";

		// status_transaksi
		$this->status_transaksi->ViewValue = $this->status_transaksi->CurrentValue;
		$this->status_transaksi->ViewCustomAttributes = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI->ViewValue = $this->TOT_BIAYA_AKOMODASI->CurrentValue;
		$this->TOT_BIAYA_AKOMODASI->ViewCustomAttributes = "";

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP->ViewValue = $this->TOTAL_BIAYA_ASKEP->CurrentValue;
		$this->TOTAL_BIAYA_ASKEP->ViewCustomAttributes = "";

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS->ViewValue = $this->TOTAL_BIAYA_SIMRS->CurrentValue;
		$this->TOTAL_BIAYA_SIMRS->ViewCustomAttributes = "";

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS->ViewValue = $this->TOT_PENJ_NMEDIS->CurrentValue;
		$this->TOT_PENJ_NMEDIS->ViewCustomAttributes = "";

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL->ViewValue = $this->LINK_MASTERDETAIL->CurrentValue;
		$this->LINK_MASTERDETAIL->ViewCustomAttributes = "";

		// NO_SKP
		$this->NO_SKP->ViewValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->ViewCustomAttributes = "";

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT->ViewValue = $this->LINK_PELAYANAN_OBAT->CurrentValue;
		$this->LINK_PELAYANAN_OBAT->ViewCustomAttributes = "";

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL->ViewValue = $this->TOT_TIND_RAJAL->CurrentValue;
		$this->TOT_TIND_RAJAL->ViewCustomAttributes = "";

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD->ViewValue = $this->TOT_TIND_IGD->CurrentValue;
		$this->TOT_TIND_IGD->ViewCustomAttributes = "";

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status->ViewValue = $this->tanggal_pengembalian_status->CurrentValue;
		$this->tanggal_pengembalian_status->ViewValue = ew_FormatDateTime($this->tanggal_pengembalian_status->ViewValue, 0);
		$this->tanggal_pengembalian_status->ViewCustomAttributes = "";

		// naik_kelas
		$this->naik_kelas->ViewValue = $this->naik_kelas->CurrentValue;
		$this->naik_kelas->ViewCustomAttributes = "";

		// iuran_kelas_lama
		$this->iuran_kelas_lama->ViewValue = $this->iuran_kelas_lama->CurrentValue;
		$this->iuran_kelas_lama->ViewCustomAttributes = "";

		// iuran_kelas_baru
		$this->iuran_kelas_baru->ViewValue = $this->iuran_kelas_baru->CurrentValue;
		$this->iuran_kelas_baru->ViewCustomAttributes = "";

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas->ViewValue = $this->ketrangan_naik_kelas->CurrentValue;
		$this->ketrangan_naik_kelas->ViewCustomAttributes = "";

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim->ViewValue = $this->tgl_pengiriman_ad_klaim->CurrentValue;
		$this->tgl_pengiriman_ad_klaim->ViewValue = ew_FormatDateTime($this->tgl_pengiriman_ad_klaim->ViewValue, 0);
		$this->tgl_pengiriman_ad_klaim->ViewCustomAttributes = "";

		// diagnosa_keluar
		$this->diagnosa_keluar->ViewValue = $this->diagnosa_keluar->CurrentValue;
		$this->diagnosa_keluar->ViewCustomAttributes = "";

		// sep_tglsep
		$this->sep_tglsep->ViewValue = $this->sep_tglsep->CurrentValue;
		$this->sep_tglsep->ViewValue = ew_FormatDateTime($this->sep_tglsep->ViewValue, 0);
		$this->sep_tglsep->ViewCustomAttributes = "";

		// sep_tglrujuk
		$this->sep_tglrujuk->ViewValue = $this->sep_tglrujuk->CurrentValue;
		$this->sep_tglrujuk->ViewValue = ew_FormatDateTime($this->sep_tglrujuk->ViewValue, 0);
		$this->sep_tglrujuk->ViewCustomAttributes = "";

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat->ViewValue = $this->sep_kodekelasrawat->CurrentValue;
		$this->sep_kodekelasrawat->ViewCustomAttributes = "";

		// sep_norujukan
		$this->sep_norujukan->ViewValue = $this->sep_norujukan->CurrentValue;
		$this->sep_norujukan->ViewCustomAttributes = "";

		// sep_kodeppkasal
		$this->sep_kodeppkasal->ViewValue = $this->sep_kodeppkasal->CurrentValue;
		$this->sep_kodeppkasal->ViewCustomAttributes = "";

		// sep_namappkasal
		$this->sep_namappkasal->ViewValue = $this->sep_namappkasal->CurrentValue;
		$this->sep_namappkasal->ViewCustomAttributes = "";

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan->ViewValue = $this->sep_kodeppkpelayanan->CurrentValue;
		$this->sep_kodeppkpelayanan->ViewCustomAttributes = "";

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan->ViewValue = $this->sep_namappkpelayanan->CurrentValue;
		$this->sep_namappkpelayanan->ViewCustomAttributes = "";

		// t_admissioncol
		$this->t_admissioncol->ViewValue = $this->t_admissioncol->CurrentValue;
		$this->t_admissioncol->ViewCustomAttributes = "";

		// sep_jenisperawatan
		$this->sep_jenisperawatan->ViewValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_jenisperawatan->ViewCustomAttributes = "";

		// sep_catatan
		$this->sep_catatan->ViewValue = $this->sep_catatan->CurrentValue;
		$this->sep_catatan->ViewCustomAttributes = "";

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
		$this->sep_kodediagnosaawal->ViewCustomAttributes = "";

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->ViewValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->ViewCustomAttributes = "";

		// sep_lakalantas
		$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->CurrentValue;
		$this->sep_lakalantas->ViewCustomAttributes = "";

		// sep_lokasilaka
		$this->sep_lokasilaka->ViewValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_lokasilaka->ViewCustomAttributes = "";

		// sep_user
		$this->sep_user->ViewValue = $this->sep_user->CurrentValue;
		$this->sep_user->ViewCustomAttributes = "";

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta->ViewValue = $this->sep_flag_cekpeserta->CurrentValue;
		$this->sep_flag_cekpeserta->ViewCustomAttributes = "";

		// sep_flag_generatesep
		$this->sep_flag_generatesep->ViewValue = $this->sep_flag_generatesep->CurrentValue;
		$this->sep_flag_generatesep->ViewCustomAttributes = "";

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep->ViewValue = $this->sep_flag_mapingsep->CurrentValue;
		$this->sep_flag_mapingsep->ViewCustomAttributes = "";

		// sep_nik
		$this->sep_nik->ViewValue = $this->sep_nik->CurrentValue;
		$this->sep_nik->ViewCustomAttributes = "";

		// sep_namapeserta
		$this->sep_namapeserta->ViewValue = $this->sep_namapeserta->CurrentValue;
		$this->sep_namapeserta->ViewCustomAttributes = "";

		// sep_jeniskelamin
		$this->sep_jeniskelamin->ViewValue = $this->sep_jeniskelamin->CurrentValue;
		$this->sep_jeniskelamin->ViewCustomAttributes = "";

		// sep_pisat
		$this->sep_pisat->ViewValue = $this->sep_pisat->CurrentValue;
		$this->sep_pisat->ViewCustomAttributes = "";

		// sep_tgllahir
		$this->sep_tgllahir->ViewValue = $this->sep_tgllahir->CurrentValue;
		$this->sep_tgllahir->ViewCustomAttributes = "";

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan->ViewValue = $this->sep_kodejeniskepesertaan->CurrentValue;
		$this->sep_kodejeniskepesertaan->ViewCustomAttributes = "";

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan->ViewValue = $this->sep_namajeniskepesertaan->CurrentValue;
		$this->sep_namajeniskepesertaan->ViewCustomAttributes = "";

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan->ViewValue = $this->sep_kodepolitujuan->CurrentValue;
		$this->sep_kodepolitujuan->ViewCustomAttributes = "";

		// sep_namapolitujuan
		$this->sep_namapolitujuan->ViewValue = $this->sep_namapolitujuan->CurrentValue;
		$this->sep_namapolitujuan->ViewCustomAttributes = "";

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// sep_nokabpjs
		$this->sep_nokabpjs->ViewValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->ViewCustomAttributes = "";

		// counter_cetak_sep
		$this->counter_cetak_sep->ViewValue = $this->counter_cetak_sep->CurrentValue;
		$this->counter_cetak_sep->ViewCustomAttributes = "";

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep->ViewValue = $this->sep_petugas_hapus_sep->CurrentValue;
		$this->sep_petugas_hapus_sep->ViewCustomAttributes = "";

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang->ViewValue = $this->sep_petugas_set_tgl_pulang->CurrentValue;
		$this->sep_petugas_set_tgl_pulang->ViewCustomAttributes = "";

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep->ViewValue = $this->sep_jam_generate_sep->CurrentValue;
		$this->sep_jam_generate_sep->ViewValue = ew_FormatDateTime($this->sep_jam_generate_sep->ViewValue, 0);
		$this->sep_jam_generate_sep->ViewCustomAttributes = "";

		// sep_status_peserta
		$this->sep_status_peserta->ViewValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_status_peserta->ViewCustomAttributes = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->ViewValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->sep_umur_pasien_sekarang->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// status_daftar_ranap
		$this->status_daftar_ranap->ViewValue = $this->status_daftar_ranap->CurrentValue;
		$this->status_daftar_ranap->ViewCustomAttributes = "";

		// IBS_SETMARKING
		$this->IBS_SETMARKING->ViewValue = $this->IBS_SETMARKING->CurrentValue;
		$this->IBS_SETMARKING->ViewCustomAttributes = "";

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI->ViewValue = $this->IBS_PATOLOGI->CurrentValue;
		$this->IBS_PATOLOGI->ViewCustomAttributes = "";

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI->ViewValue = $this->IBS_JENISANESTESI->CurrentValue;
		$this->IBS_JENISANESTESI->ViewCustomAttributes = "";

		// IBS_NO_OK
		$this->IBS_NO_OK->ViewValue = $this->IBS_NO_OK->CurrentValue;
		$this->IBS_NO_OK->ViewCustomAttributes = "";

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN->ViewValue = $this->IBS_ASISSTEN->CurrentValue;
		$this->IBS_ASISSTEN->ViewCustomAttributes = "";

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF->ViewValue = $this->IBS_JAM_ELEFTIF->CurrentValue;
		$this->IBS_JAM_ELEFTIF->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEFTIF->ViewValue, 0);
		$this->IBS_JAM_ELEFTIF->ViewCustomAttributes = "";

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = $this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue;
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->ViewValue, 0);
		$this->IBS_JAM_ELEKTIF_SELESAI->ViewCustomAttributes = "";

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO->ViewValue = $this->IBS_JAM_CYTO->CurrentValue;
		$this->IBS_JAM_CYTO->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO->ViewValue, 0);
		$this->IBS_JAM_CYTO->ViewCustomAttributes = "";

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = $this->IBS_JAM_CYTO_SELESAI->CurrentValue;
		$this->IBS_JAM_CYTO_SELESAI->ViewValue = ew_FormatDateTime($this->IBS_JAM_CYTO_SELESAI->ViewValue, 0);
		$this->IBS_JAM_CYTO_SELESAI->ViewCustomAttributes = "";

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP->ViewValue = $this->IBS_TGL_DFTR_OP->CurrentValue;
		$this->IBS_TGL_DFTR_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_DFTR_OP->ViewValue, 0);
		$this->IBS_TGL_DFTR_OP->ViewCustomAttributes = "";

		// IBS_TGL_OP
		$this->IBS_TGL_OP->ViewValue = $this->IBS_TGL_OP->CurrentValue;
		$this->IBS_TGL_OP->ViewValue = ew_FormatDateTime($this->IBS_TGL_OP->ViewValue, 0);
		$this->IBS_TGL_OP->ViewCustomAttributes = "";

		// grup_ruang_id
		$this->grup_ruang_id->ViewValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->ViewCustomAttributes = "";

		// status_order_ibs
		$this->status_order_ibs->ViewValue = $this->status_order_ibs->CurrentValue;
		$this->status_order_ibs->ViewCustomAttributes = "";

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

		// ket_tgllahir
		$this->ket_tgllahir->LinkCustomAttributes = "";
		$this->ket_tgllahir->HrefValue = "";
		$this->ket_tgllahir->TooltipValue = "";

		// ket_alamat
		$this->ket_alamat->LinkCustomAttributes = "";
		$this->ket_alamat->HrefValue = "";
		$this->ket_alamat->TooltipValue = "";

		// parent_nomr
		$this->parent_nomr->LinkCustomAttributes = "";
		$this->parent_nomr->HrefValue = "";
		$this->parent_nomr->TooltipValue = "";

		// dokterpengirim
		$this->dokterpengirim->LinkCustomAttributes = "";
		$this->dokterpengirim->HrefValue = "";
		$this->dokterpengirim->TooltipValue = "";

		// statusbayar
		$this->statusbayar->LinkCustomAttributes = "";
		$this->statusbayar->HrefValue = "";
		$this->statusbayar->TooltipValue = "";

		// kirimdari
		$this->kirimdari->LinkCustomAttributes = "";
		$this->kirimdari->HrefValue = "";
		$this->kirimdari->TooltipValue = "";

		// keluargadekat
		$this->keluargadekat->LinkCustomAttributes = "";
		$this->keluargadekat->HrefValue = "";
		$this->keluargadekat->TooltipValue = "";

		// panggungjawab
		$this->panggungjawab->LinkCustomAttributes = "";
		$this->panggungjawab->HrefValue = "";
		$this->panggungjawab->TooltipValue = "";

		// masukrs
		$this->masukrs->LinkCustomAttributes = "";
		$this->masukrs->HrefValue = "";
		$this->masukrs->TooltipValue = "";

		// noruang
		$this->noruang->LinkCustomAttributes = "";
		$this->noruang->HrefValue = "";
		$this->noruang->TooltipValue = "";

		// tempat_tidur_id
		$this->tempat_tidur_id->LinkCustomAttributes = "";
		$this->tempat_tidur_id->HrefValue = "";
		$this->tempat_tidur_id->TooltipValue = "";

		// nott
		$this->nott->LinkCustomAttributes = "";
		$this->nott->HrefValue = "";
		$this->nott->TooltipValue = "";

		// deposit
		$this->deposit->LinkCustomAttributes = "";
		$this->deposit->HrefValue = "";
		$this->deposit->TooltipValue = "";

		// keluarrs
		$this->keluarrs->LinkCustomAttributes = "";
		$this->keluarrs->HrefValue = "";
		$this->keluarrs->TooltipValue = "";

		// icd_masuk
		$this->icd_masuk->LinkCustomAttributes = "";
		$this->icd_masuk->HrefValue = "";
		$this->icd_masuk->TooltipValue = "";

		// icd_keluar
		$this->icd_keluar->LinkCustomAttributes = "";
		$this->icd_keluar->HrefValue = "";
		$this->icd_keluar->TooltipValue = "";

		// NIP
		$this->NIP->LinkCustomAttributes = "";
		$this->NIP->HrefValue = "";
		$this->NIP->TooltipValue = "";

		// noruang_asal
		$this->noruang_asal->LinkCustomAttributes = "";
		$this->noruang_asal->HrefValue = "";
		$this->noruang_asal->TooltipValue = "";

		// nott_asal
		$this->nott_asal->LinkCustomAttributes = "";
		$this->nott_asal->HrefValue = "";
		$this->nott_asal->TooltipValue = "";

		// tgl_pindah
		$this->tgl_pindah->LinkCustomAttributes = "";
		$this->tgl_pindah->HrefValue = "";
		$this->tgl_pindah->TooltipValue = "";

		// kd_rujuk
		$this->kd_rujuk->LinkCustomAttributes = "";
		$this->kd_rujuk->HrefValue = "";
		$this->kd_rujuk->TooltipValue = "";

		// st_bayar
		$this->st_bayar->LinkCustomAttributes = "";
		$this->st_bayar->HrefValue = "";
		$this->st_bayar->TooltipValue = "";

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->LinkCustomAttributes = "";
		$this->dokter_penanggungjawab->HrefValue = "";
		$this->dokter_penanggungjawab->TooltipValue = "";

		// perawat
		$this->perawat->LinkCustomAttributes = "";
		$this->perawat->HrefValue = "";
		$this->perawat->TooltipValue = "";

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->LinkCustomAttributes = "";
		$this->KELASPERAWATAN_ID->HrefValue = "";
		$this->KELASPERAWATAN_ID->TooltipValue = "";

		// LOS
		$this->LOS->LinkCustomAttributes = "";
		$this->LOS->HrefValue = "";
		$this->LOS->TooltipValue = "";

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER->LinkCustomAttributes = "";
		$this->TOT_TRF_TIND_DOKTER->HrefValue = "";
		$this->TOT_TRF_TIND_DOKTER->TooltipValue = "";

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER->LinkCustomAttributes = "";
		$this->TOT_BHP_DOKTER->HrefValue = "";
		$this->TOT_BHP_DOKTER->TooltipValue = "";

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT->LinkCustomAttributes = "";
		$this->TOT_TRF_PERAWAT->HrefValue = "";
		$this->TOT_TRF_PERAWAT->TooltipValue = "";

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT->LinkCustomAttributes = "";
		$this->TOT_BHP_PERAWAT->HrefValue = "";
		$this->TOT_BHP_PERAWAT->TooltipValue = "";

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER->LinkCustomAttributes = "";
		$this->TOT_TRF_DOKTER->HrefValue = "";
		$this->TOT_TRF_DOKTER->TooltipValue = "";

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD->LinkCustomAttributes = "";
		$this->TOT_BIAYA_RAD->HrefValue = "";
		$this->TOT_BIAYA_RAD->TooltipValue = "";

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI->LinkCustomAttributes = "";
		$this->TOT_BIAYA_CDRPOLI->HrefValue = "";
		$this->TOT_BIAYA_CDRPOLI->TooltipValue = "";

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD->LinkCustomAttributes = "";
		$this->TOT_BIAYA_LAB_IGD->HrefValue = "";
		$this->TOT_BIAYA_LAB_IGD->TooltipValue = "";

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN->LinkCustomAttributes = "";
		$this->TOT_BIAYA_OKSIGEN->HrefValue = "";
		$this->TOT_BIAYA_OKSIGEN->TooltipValue = "";

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT->HrefValue = "";
		$this->TOTAL_BIAYA_OBAT->TooltipValue = "";

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS->LinkCustomAttributes = "";
		$this->LINK_SET_KELAS->HrefValue = "";
		$this->LINK_SET_KELAS->TooltipValue = "";

		// biaya_obat
		$this->biaya_obat->LinkCustomAttributes = "";
		$this->biaya_obat->HrefValue = "";
		$this->biaya_obat->TooltipValue = "";

		// biaya_retur_obat
		$this->biaya_retur_obat->LinkCustomAttributes = "";
		$this->biaya_retur_obat->HrefValue = "";
		$this->biaya_retur_obat->TooltipValue = "";

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI->LinkCustomAttributes = "";
		$this->TOT_BIAYA_GIZI->HrefValue = "";
		$this->TOT_BIAYA_GIZI->TooltipValue = "";

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO->LinkCustomAttributes = "";
		$this->TOT_BIAYA_TMO->HrefValue = "";
		$this->TOT_BIAYA_TMO->TooltipValue = "";

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN->LinkCustomAttributes = "";
		$this->TOT_BIAYA_AMBULAN->HrefValue = "";
		$this->TOT_BIAYA_AMBULAN->TooltipValue = "";

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO->LinkCustomAttributes = "";
		$this->TOT_BIAYA_FISIO->HrefValue = "";
		$this->TOT_BIAYA_FISIO->TooltipValue = "";

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN->LinkCustomAttributes = "";
		$this->TOT_BIAYA_LAINLAIN->HrefValue = "";
		$this->TOT_BIAYA_LAINLAIN->TooltipValue = "";

		// jenisperawatan_id
		$this->jenisperawatan_id->LinkCustomAttributes = "";
		$this->jenisperawatan_id->HrefValue = "";
		$this->jenisperawatan_id->TooltipValue = "";

		// status_transaksi
		$this->status_transaksi->LinkCustomAttributes = "";
		$this->status_transaksi->HrefValue = "";
		$this->status_transaksi->TooltipValue = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->LinkCustomAttributes = "";
		$this->statuskeluarranap_id->HrefValue = "";
		$this->statuskeluarranap_id->TooltipValue = "";

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI->LinkCustomAttributes = "";
		$this->TOT_BIAYA_AKOMODASI->HrefValue = "";
		$this->TOT_BIAYA_AKOMODASI->TooltipValue = "";

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_ASKEP->HrefValue = "";
		$this->TOTAL_BIAYA_ASKEP->TooltipValue = "";

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS->LinkCustomAttributes = "";
		$this->TOTAL_BIAYA_SIMRS->HrefValue = "";
		$this->TOTAL_BIAYA_SIMRS->TooltipValue = "";

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS->LinkCustomAttributes = "";
		$this->TOT_PENJ_NMEDIS->HrefValue = "";
		$this->TOT_PENJ_NMEDIS->TooltipValue = "";

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL->LinkCustomAttributes = "";
		$this->LINK_MASTERDETAIL->HrefValue = "";
		$this->LINK_MASTERDETAIL->TooltipValue = "";

		// NO_SKP
		$this->NO_SKP->LinkCustomAttributes = "";
		$this->NO_SKP->HrefValue = "";
		$this->NO_SKP->TooltipValue = "";

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT->LinkCustomAttributes = "";
		$this->LINK_PELAYANAN_OBAT->HrefValue = "";
		$this->LINK_PELAYANAN_OBAT->TooltipValue = "";

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL->LinkCustomAttributes = "";
		$this->TOT_TIND_RAJAL->HrefValue = "";
		$this->TOT_TIND_RAJAL->TooltipValue = "";

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD->LinkCustomAttributes = "";
		$this->TOT_TIND_IGD->HrefValue = "";
		$this->TOT_TIND_IGD->TooltipValue = "";

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status->LinkCustomAttributes = "";
		$this->tanggal_pengembalian_status->HrefValue = "";
		$this->tanggal_pengembalian_status->TooltipValue = "";

		// naik_kelas
		$this->naik_kelas->LinkCustomAttributes = "";
		$this->naik_kelas->HrefValue = "";
		$this->naik_kelas->TooltipValue = "";

		// iuran_kelas_lama
		$this->iuran_kelas_lama->LinkCustomAttributes = "";
		$this->iuran_kelas_lama->HrefValue = "";
		$this->iuran_kelas_lama->TooltipValue = "";

		// iuran_kelas_baru
		$this->iuran_kelas_baru->LinkCustomAttributes = "";
		$this->iuran_kelas_baru->HrefValue = "";
		$this->iuran_kelas_baru->TooltipValue = "";

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas->LinkCustomAttributes = "";
		$this->ketrangan_naik_kelas->HrefValue = "";
		$this->ketrangan_naik_kelas->TooltipValue = "";

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim->LinkCustomAttributes = "";
		$this->tgl_pengiriman_ad_klaim->HrefValue = "";
		$this->tgl_pengiriman_ad_klaim->TooltipValue = "";

		// diagnosa_keluar
		$this->diagnosa_keluar->LinkCustomAttributes = "";
		$this->diagnosa_keluar->HrefValue = "";
		$this->diagnosa_keluar->TooltipValue = "";

		// sep_tglsep
		$this->sep_tglsep->LinkCustomAttributes = "";
		$this->sep_tglsep->HrefValue = "";
		$this->sep_tglsep->TooltipValue = "";

		// sep_tglrujuk
		$this->sep_tglrujuk->LinkCustomAttributes = "";
		$this->sep_tglrujuk->HrefValue = "";
		$this->sep_tglrujuk->TooltipValue = "";

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat->LinkCustomAttributes = "";
		$this->sep_kodekelasrawat->HrefValue = "";
		$this->sep_kodekelasrawat->TooltipValue = "";

		// sep_norujukan
		$this->sep_norujukan->LinkCustomAttributes = "";
		$this->sep_norujukan->HrefValue = "";
		$this->sep_norujukan->TooltipValue = "";

		// sep_kodeppkasal
		$this->sep_kodeppkasal->LinkCustomAttributes = "";
		$this->sep_kodeppkasal->HrefValue = "";
		$this->sep_kodeppkasal->TooltipValue = "";

		// sep_namappkasal
		$this->sep_namappkasal->LinkCustomAttributes = "";
		$this->sep_namappkasal->HrefValue = "";
		$this->sep_namappkasal->TooltipValue = "";

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan->LinkCustomAttributes = "";
		$this->sep_kodeppkpelayanan->HrefValue = "";
		$this->sep_kodeppkpelayanan->TooltipValue = "";

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan->LinkCustomAttributes = "";
		$this->sep_namappkpelayanan->HrefValue = "";
		$this->sep_namappkpelayanan->TooltipValue = "";

		// t_admissioncol
		$this->t_admissioncol->LinkCustomAttributes = "";
		$this->t_admissioncol->HrefValue = "";
		$this->t_admissioncol->TooltipValue = "";

		// sep_jenisperawatan
		$this->sep_jenisperawatan->LinkCustomAttributes = "";
		$this->sep_jenisperawatan->HrefValue = "";
		$this->sep_jenisperawatan->TooltipValue = "";

		// sep_catatan
		$this->sep_catatan->LinkCustomAttributes = "";
		$this->sep_catatan->HrefValue = "";
		$this->sep_catatan->TooltipValue = "";

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->LinkCustomAttributes = "";
		$this->sep_kodediagnosaawal->HrefValue = "";
		$this->sep_kodediagnosaawal->TooltipValue = "";

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->LinkCustomAttributes = "";
		$this->sep_namadiagnosaawal->HrefValue = "";
		$this->sep_namadiagnosaawal->TooltipValue = "";

		// sep_lakalantas
		$this->sep_lakalantas->LinkCustomAttributes = "";
		$this->sep_lakalantas->HrefValue = "";
		$this->sep_lakalantas->TooltipValue = "";

		// sep_lokasilaka
		$this->sep_lokasilaka->LinkCustomAttributes = "";
		$this->sep_lokasilaka->HrefValue = "";
		$this->sep_lokasilaka->TooltipValue = "";

		// sep_user
		$this->sep_user->LinkCustomAttributes = "";
		$this->sep_user->HrefValue = "";
		$this->sep_user->TooltipValue = "";

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta->LinkCustomAttributes = "";
		$this->sep_flag_cekpeserta->HrefValue = "";
		$this->sep_flag_cekpeserta->TooltipValue = "";

		// sep_flag_generatesep
		$this->sep_flag_generatesep->LinkCustomAttributes = "";
		$this->sep_flag_generatesep->HrefValue = "";
		$this->sep_flag_generatesep->TooltipValue = "";

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep->LinkCustomAttributes = "";
		$this->sep_flag_mapingsep->HrefValue = "";
		$this->sep_flag_mapingsep->TooltipValue = "";

		// sep_nik
		$this->sep_nik->LinkCustomAttributes = "";
		$this->sep_nik->HrefValue = "";
		$this->sep_nik->TooltipValue = "";

		// sep_namapeserta
		$this->sep_namapeserta->LinkCustomAttributes = "";
		$this->sep_namapeserta->HrefValue = "";
		$this->sep_namapeserta->TooltipValue = "";

		// sep_jeniskelamin
		$this->sep_jeniskelamin->LinkCustomAttributes = "";
		$this->sep_jeniskelamin->HrefValue = "";
		$this->sep_jeniskelamin->TooltipValue = "";

		// sep_pisat
		$this->sep_pisat->LinkCustomAttributes = "";
		$this->sep_pisat->HrefValue = "";
		$this->sep_pisat->TooltipValue = "";

		// sep_tgllahir
		$this->sep_tgllahir->LinkCustomAttributes = "";
		$this->sep_tgllahir->HrefValue = "";
		$this->sep_tgllahir->TooltipValue = "";

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan->LinkCustomAttributes = "";
		$this->sep_kodejeniskepesertaan->HrefValue = "";
		$this->sep_kodejeniskepesertaan->TooltipValue = "";

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan->LinkCustomAttributes = "";
		$this->sep_namajeniskepesertaan->HrefValue = "";
		$this->sep_namajeniskepesertaan->TooltipValue = "";

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan->LinkCustomAttributes = "";
		$this->sep_kodepolitujuan->HrefValue = "";
		$this->sep_kodepolitujuan->TooltipValue = "";

		// sep_namapolitujuan
		$this->sep_namapolitujuan->LinkCustomAttributes = "";
		$this->sep_namapolitujuan->HrefValue = "";
		$this->sep_namapolitujuan->TooltipValue = "";

		// ket_jeniskelamin
		$this->ket_jeniskelamin->LinkCustomAttributes = "";
		$this->ket_jeniskelamin->HrefValue = "";
		$this->ket_jeniskelamin->TooltipValue = "";

		// sep_nokabpjs
		$this->sep_nokabpjs->LinkCustomAttributes = "";
		$this->sep_nokabpjs->HrefValue = "";
		$this->sep_nokabpjs->TooltipValue = "";

		// counter_cetak_sep
		$this->counter_cetak_sep->LinkCustomAttributes = "";
		$this->counter_cetak_sep->HrefValue = "";
		$this->counter_cetak_sep->TooltipValue = "";

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep->LinkCustomAttributes = "";
		$this->sep_petugas_hapus_sep->HrefValue = "";
		$this->sep_petugas_hapus_sep->TooltipValue = "";

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang->LinkCustomAttributes = "";
		$this->sep_petugas_set_tgl_pulang->HrefValue = "";
		$this->sep_petugas_set_tgl_pulang->TooltipValue = "";

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep->LinkCustomAttributes = "";
		$this->sep_jam_generate_sep->HrefValue = "";
		$this->sep_jam_generate_sep->TooltipValue = "";

		// sep_status_peserta
		$this->sep_status_peserta->LinkCustomAttributes = "";
		$this->sep_status_peserta->HrefValue = "";
		$this->sep_status_peserta->TooltipValue = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->LinkCustomAttributes = "";
		$this->sep_umur_pasien_sekarang->HrefValue = "";
		$this->sep_umur_pasien_sekarang->TooltipValue = "";

		// ket_title
		$this->ket_title->LinkCustomAttributes = "";
		$this->ket_title->HrefValue = "";
		$this->ket_title->TooltipValue = "";

		// status_daftar_ranap
		$this->status_daftar_ranap->LinkCustomAttributes = "";
		$this->status_daftar_ranap->HrefValue = "";
		$this->status_daftar_ranap->TooltipValue = "";

		// IBS_SETMARKING
		$this->IBS_SETMARKING->LinkCustomAttributes = "";
		$this->IBS_SETMARKING->HrefValue = "";
		$this->IBS_SETMARKING->TooltipValue = "";

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI->LinkCustomAttributes = "";
		$this->IBS_PATOLOGI->HrefValue = "";
		$this->IBS_PATOLOGI->TooltipValue = "";

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI->LinkCustomAttributes = "";
		$this->IBS_JENISANESTESI->HrefValue = "";
		$this->IBS_JENISANESTESI->TooltipValue = "";

		// IBS_NO_OK
		$this->IBS_NO_OK->LinkCustomAttributes = "";
		$this->IBS_NO_OK->HrefValue = "";
		$this->IBS_NO_OK->TooltipValue = "";

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN->LinkCustomAttributes = "";
		$this->IBS_ASISSTEN->HrefValue = "";
		$this->IBS_ASISSTEN->TooltipValue = "";

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF->LinkCustomAttributes = "";
		$this->IBS_JAM_ELEFTIF->HrefValue = "";
		$this->IBS_JAM_ELEFTIF->TooltipValue = "";

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI->LinkCustomAttributes = "";
		$this->IBS_JAM_ELEKTIF_SELESAI->HrefValue = "";
		$this->IBS_JAM_ELEKTIF_SELESAI->TooltipValue = "";

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO->LinkCustomAttributes = "";
		$this->IBS_JAM_CYTO->HrefValue = "";
		$this->IBS_JAM_CYTO->TooltipValue = "";

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI->LinkCustomAttributes = "";
		$this->IBS_JAM_CYTO_SELESAI->HrefValue = "";
		$this->IBS_JAM_CYTO_SELESAI->TooltipValue = "";

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP->LinkCustomAttributes = "";
		$this->IBS_TGL_DFTR_OP->HrefValue = "";
		$this->IBS_TGL_DFTR_OP->TooltipValue = "";

		// IBS_TGL_OP
		$this->IBS_TGL_OP->LinkCustomAttributes = "";
		$this->IBS_TGL_OP->HrefValue = "";
		$this->IBS_TGL_OP->TooltipValue = "";

		// grup_ruang_id
		$this->grup_ruang_id->LinkCustomAttributes = "";
		$this->grup_ruang_id->HrefValue = "";
		$this->grup_ruang_id->TooltipValue = "";

		// status_order_ibs
		$this->status_order_ibs->LinkCustomAttributes = "";
		$this->status_order_ibs->HrefValue = "";
		$this->status_order_ibs->TooltipValue = "";

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
		$this->nomr->PlaceHolder = ew_RemoveHtml($this->nomr->FldCaption());

		// ket_nama
		$this->ket_nama->EditAttrs["class"] = "form-control";
		$this->ket_nama->EditCustomAttributes = "";
		$this->ket_nama->EditValue = $this->ket_nama->CurrentValue;
		$this->ket_nama->PlaceHolder = ew_RemoveHtml($this->ket_nama->FldCaption());

		// ket_tgllahir
		$this->ket_tgllahir->EditAttrs["class"] = "form-control";
		$this->ket_tgllahir->EditCustomAttributes = "";
		$this->ket_tgllahir->EditValue = ew_FormatDateTime($this->ket_tgllahir->CurrentValue, 8);
		$this->ket_tgllahir->PlaceHolder = ew_RemoveHtml($this->ket_tgllahir->FldCaption());

		// ket_alamat
		$this->ket_alamat->EditAttrs["class"] = "form-control";
		$this->ket_alamat->EditCustomAttributes = "";
		$this->ket_alamat->EditValue = $this->ket_alamat->CurrentValue;
		$this->ket_alamat->PlaceHolder = ew_RemoveHtml($this->ket_alamat->FldCaption());

		// parent_nomr
		$this->parent_nomr->EditAttrs["class"] = "form-control";
		$this->parent_nomr->EditCustomAttributes = "";
		$this->parent_nomr->EditValue = $this->parent_nomr->CurrentValue;
		$this->parent_nomr->PlaceHolder = ew_RemoveHtml($this->parent_nomr->FldCaption());

		// dokterpengirim
		$this->dokterpengirim->EditAttrs["class"] = "form-control";
		$this->dokterpengirim->EditCustomAttributes = "";

		// statusbayar
		$this->statusbayar->EditAttrs["class"] = "form-control";
		$this->statusbayar->EditCustomAttributes = "";

		// kirimdari
		$this->kirimdari->EditAttrs["class"] = "form-control";
		$this->kirimdari->EditCustomAttributes = "";
		$this->kirimdari->EditValue = $this->kirimdari->CurrentValue;
		$this->kirimdari->PlaceHolder = ew_RemoveHtml($this->kirimdari->FldCaption());

		// keluargadekat
		$this->keluargadekat->EditAttrs["class"] = "form-control";
		$this->keluargadekat->EditCustomAttributes = "";
		$this->keluargadekat->EditValue = $this->keluargadekat->CurrentValue;
		$this->keluargadekat->PlaceHolder = ew_RemoveHtml($this->keluargadekat->FldCaption());

		// panggungjawab
		$this->panggungjawab->EditAttrs["class"] = "form-control";
		$this->panggungjawab->EditCustomAttributes = "";
		$this->panggungjawab->EditValue = $this->panggungjawab->CurrentValue;
		$this->panggungjawab->PlaceHolder = ew_RemoveHtml($this->panggungjawab->FldCaption());

		// masukrs
		$this->masukrs->EditAttrs["class"] = "form-control";
		$this->masukrs->EditCustomAttributes = "";
		$this->masukrs->EditValue = ew_FormatDateTime($this->masukrs->CurrentValue, 11);
		$this->masukrs->PlaceHolder = ew_RemoveHtml($this->masukrs->FldCaption());

		// noruang
		$this->noruang->EditAttrs["class"] = "form-control";
		$this->noruang->EditCustomAttributes = "";

		// tempat_tidur_id
		$this->tempat_tidur_id->EditAttrs["class"] = "form-control";
		$this->tempat_tidur_id->EditCustomAttributes = "";

		// nott
		$this->nott->EditAttrs["class"] = "form-control";
		$this->nott->EditCustomAttributes = "";
		$this->nott->EditValue = $this->nott->CurrentValue;
		$this->nott->PlaceHolder = ew_RemoveHtml($this->nott->FldCaption());

		// deposit
		$this->deposit->EditAttrs["class"] = "form-control";
		$this->deposit->EditCustomAttributes = "";
		$this->deposit->EditValue = $this->deposit->CurrentValue;
		$this->deposit->PlaceHolder = ew_RemoveHtml($this->deposit->FldCaption());

		// keluarrs
		$this->keluarrs->EditAttrs["class"] = "form-control";
		$this->keluarrs->EditCustomAttributes = "";
		$this->keluarrs->EditValue = ew_FormatDateTime($this->keluarrs->CurrentValue, 8);
		$this->keluarrs->PlaceHolder = ew_RemoveHtml($this->keluarrs->FldCaption());

		// icd_masuk
		$this->icd_masuk->EditAttrs["class"] = "form-control";
		$this->icd_masuk->EditCustomAttributes = "";
		$this->icd_masuk->EditValue = $this->icd_masuk->CurrentValue;
		$this->icd_masuk->PlaceHolder = ew_RemoveHtml($this->icd_masuk->FldCaption());

		// icd_keluar
		$this->icd_keluar->EditAttrs["class"] = "form-control";
		$this->icd_keluar->EditCustomAttributes = "";
		$this->icd_keluar->EditValue = $this->icd_keluar->CurrentValue;
		$this->icd_keluar->PlaceHolder = ew_RemoveHtml($this->icd_keluar->FldCaption());

		// NIP
		$this->NIP->EditAttrs["class"] = "form-control";
		$this->NIP->EditCustomAttributes = "";
		$this->NIP->EditValue = $this->NIP->CurrentValue;
		$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

		// noruang_asal
		$this->noruang_asal->EditAttrs["class"] = "form-control";
		$this->noruang_asal->EditCustomAttributes = "";
		$this->noruang_asal->EditValue = $this->noruang_asal->CurrentValue;
		$this->noruang_asal->PlaceHolder = ew_RemoveHtml($this->noruang_asal->FldCaption());

		// nott_asal
		$this->nott_asal->EditAttrs["class"] = "form-control";
		$this->nott_asal->EditCustomAttributes = "";
		$this->nott_asal->EditValue = $this->nott_asal->CurrentValue;
		$this->nott_asal->PlaceHolder = ew_RemoveHtml($this->nott_asal->FldCaption());

		// tgl_pindah
		$this->tgl_pindah->EditAttrs["class"] = "form-control";
		$this->tgl_pindah->EditCustomAttributes = "";
		$this->tgl_pindah->EditValue = ew_FormatDateTime($this->tgl_pindah->CurrentValue, 8);
		$this->tgl_pindah->PlaceHolder = ew_RemoveHtml($this->tgl_pindah->FldCaption());

		// kd_rujuk
		$this->kd_rujuk->EditAttrs["class"] = "form-control";
		$this->kd_rujuk->EditCustomAttributes = "";

		// st_bayar
		$this->st_bayar->EditAttrs["class"] = "form-control";
		$this->st_bayar->EditCustomAttributes = "";
		$this->st_bayar->EditValue = $this->st_bayar->CurrentValue;
		$this->st_bayar->PlaceHolder = ew_RemoveHtml($this->st_bayar->FldCaption());

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->EditAttrs["class"] = "form-control";
		$this->dokter_penanggungjawab->EditCustomAttributes = "";

		// perawat
		$this->perawat->EditAttrs["class"] = "form-control";
		$this->perawat->EditCustomAttributes = "";
		$this->perawat->EditValue = $this->perawat->CurrentValue;
		$this->perawat->PlaceHolder = ew_RemoveHtml($this->perawat->FldCaption());

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->EditAttrs["class"] = "form-control";
		$this->KELASPERAWATAN_ID->EditCustomAttributes = "";

		// LOS
		$this->LOS->EditAttrs["class"] = "form-control";
		$this->LOS->EditCustomAttributes = "";
		$this->LOS->EditValue = $this->LOS->CurrentValue;
		$this->LOS->PlaceHolder = ew_RemoveHtml($this->LOS->FldCaption());

		// TOT_TRF_TIND_DOKTER
		$this->TOT_TRF_TIND_DOKTER->EditAttrs["class"] = "form-control";
		$this->TOT_TRF_TIND_DOKTER->EditCustomAttributes = "";
		$this->TOT_TRF_TIND_DOKTER->EditValue = $this->TOT_TRF_TIND_DOKTER->CurrentValue;
		$this->TOT_TRF_TIND_DOKTER->PlaceHolder = ew_RemoveHtml($this->TOT_TRF_TIND_DOKTER->FldCaption());
		if (strval($this->TOT_TRF_TIND_DOKTER->EditValue) <> "" && is_numeric($this->TOT_TRF_TIND_DOKTER->EditValue)) $this->TOT_TRF_TIND_DOKTER->EditValue = ew_FormatNumber($this->TOT_TRF_TIND_DOKTER->EditValue, -2, -1, -2, 0);

		// TOT_BHP_DOKTER
		$this->TOT_BHP_DOKTER->EditAttrs["class"] = "form-control";
		$this->TOT_BHP_DOKTER->EditCustomAttributes = "";
		$this->TOT_BHP_DOKTER->EditValue = $this->TOT_BHP_DOKTER->CurrentValue;
		$this->TOT_BHP_DOKTER->PlaceHolder = ew_RemoveHtml($this->TOT_BHP_DOKTER->FldCaption());
		if (strval($this->TOT_BHP_DOKTER->EditValue) <> "" && is_numeric($this->TOT_BHP_DOKTER->EditValue)) $this->TOT_BHP_DOKTER->EditValue = ew_FormatNumber($this->TOT_BHP_DOKTER->EditValue, -2, -1, -2, 0);

		// TOT_TRF_PERAWAT
		$this->TOT_TRF_PERAWAT->EditAttrs["class"] = "form-control";
		$this->TOT_TRF_PERAWAT->EditCustomAttributes = "";
		$this->TOT_TRF_PERAWAT->EditValue = $this->TOT_TRF_PERAWAT->CurrentValue;
		$this->TOT_TRF_PERAWAT->PlaceHolder = ew_RemoveHtml($this->TOT_TRF_PERAWAT->FldCaption());
		if (strval($this->TOT_TRF_PERAWAT->EditValue) <> "" && is_numeric($this->TOT_TRF_PERAWAT->EditValue)) $this->TOT_TRF_PERAWAT->EditValue = ew_FormatNumber($this->TOT_TRF_PERAWAT->EditValue, -2, -1, -2, 0);

		// TOT_BHP_PERAWAT
		$this->TOT_BHP_PERAWAT->EditAttrs["class"] = "form-control";
		$this->TOT_BHP_PERAWAT->EditCustomAttributes = "";
		$this->TOT_BHP_PERAWAT->EditValue = $this->TOT_BHP_PERAWAT->CurrentValue;
		$this->TOT_BHP_PERAWAT->PlaceHolder = ew_RemoveHtml($this->TOT_BHP_PERAWAT->FldCaption());
		if (strval($this->TOT_BHP_PERAWAT->EditValue) <> "" && is_numeric($this->TOT_BHP_PERAWAT->EditValue)) $this->TOT_BHP_PERAWAT->EditValue = ew_FormatNumber($this->TOT_BHP_PERAWAT->EditValue, -2, -1, -2, 0);

		// TOT_TRF_DOKTER
		$this->TOT_TRF_DOKTER->EditAttrs["class"] = "form-control";
		$this->TOT_TRF_DOKTER->EditCustomAttributes = "";
		$this->TOT_TRF_DOKTER->EditValue = $this->TOT_TRF_DOKTER->CurrentValue;
		$this->TOT_TRF_DOKTER->PlaceHolder = ew_RemoveHtml($this->TOT_TRF_DOKTER->FldCaption());
		if (strval($this->TOT_TRF_DOKTER->EditValue) <> "" && is_numeric($this->TOT_TRF_DOKTER->EditValue)) $this->TOT_TRF_DOKTER->EditValue = ew_FormatNumber($this->TOT_TRF_DOKTER->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_RAD
		$this->TOT_BIAYA_RAD->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_RAD->EditCustomAttributes = "";
		$this->TOT_BIAYA_RAD->EditValue = $this->TOT_BIAYA_RAD->CurrentValue;
		$this->TOT_BIAYA_RAD->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_RAD->FldCaption());
		if (strval($this->TOT_BIAYA_RAD->EditValue) <> "" && is_numeric($this->TOT_BIAYA_RAD->EditValue)) $this->TOT_BIAYA_RAD->EditValue = ew_FormatNumber($this->TOT_BIAYA_RAD->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_CDRPOLI
		$this->TOT_BIAYA_CDRPOLI->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_CDRPOLI->EditCustomAttributes = "";
		$this->TOT_BIAYA_CDRPOLI->EditValue = $this->TOT_BIAYA_CDRPOLI->CurrentValue;
		$this->TOT_BIAYA_CDRPOLI->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_CDRPOLI->FldCaption());
		if (strval($this->TOT_BIAYA_CDRPOLI->EditValue) <> "" && is_numeric($this->TOT_BIAYA_CDRPOLI->EditValue)) $this->TOT_BIAYA_CDRPOLI->EditValue = ew_FormatNumber($this->TOT_BIAYA_CDRPOLI->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_LAB_IGD
		$this->TOT_BIAYA_LAB_IGD->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_LAB_IGD->EditCustomAttributes = "";
		$this->TOT_BIAYA_LAB_IGD->EditValue = $this->TOT_BIAYA_LAB_IGD->CurrentValue;
		$this->TOT_BIAYA_LAB_IGD->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_LAB_IGD->FldCaption());
		if (strval($this->TOT_BIAYA_LAB_IGD->EditValue) <> "" && is_numeric($this->TOT_BIAYA_LAB_IGD->EditValue)) $this->TOT_BIAYA_LAB_IGD->EditValue = ew_FormatNumber($this->TOT_BIAYA_LAB_IGD->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_OKSIGEN
		$this->TOT_BIAYA_OKSIGEN->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_OKSIGEN->EditCustomAttributes = "";
		$this->TOT_BIAYA_OKSIGEN->EditValue = $this->TOT_BIAYA_OKSIGEN->CurrentValue;
		$this->TOT_BIAYA_OKSIGEN->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_OKSIGEN->FldCaption());
		if (strval($this->TOT_BIAYA_OKSIGEN->EditValue) <> "" && is_numeric($this->TOT_BIAYA_OKSIGEN->EditValue)) $this->TOT_BIAYA_OKSIGEN->EditValue = ew_FormatNumber($this->TOT_BIAYA_OKSIGEN->EditValue, -2, -1, -2, 0);

		// TOTAL_BIAYA_OBAT
		$this->TOTAL_BIAYA_OBAT->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_OBAT->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_OBAT->EditValue = $this->TOTAL_BIAYA_OBAT->CurrentValue;
		$this->TOTAL_BIAYA_OBAT->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_OBAT->FldCaption());
		if (strval($this->TOTAL_BIAYA_OBAT->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_OBAT->EditValue)) $this->TOTAL_BIAYA_OBAT->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_OBAT->EditValue, -2, -1, -2, 0);

		// LINK_SET_KELAS
		$this->LINK_SET_KELAS->EditAttrs["class"] = "form-control";
		$this->LINK_SET_KELAS->EditCustomAttributes = "";
		$this->LINK_SET_KELAS->EditValue = $this->LINK_SET_KELAS->CurrentValue;
		$this->LINK_SET_KELAS->PlaceHolder = ew_RemoveHtml($this->LINK_SET_KELAS->FldCaption());

		// biaya_obat
		$this->biaya_obat->EditAttrs["class"] = "form-control";
		$this->biaya_obat->EditCustomAttributes = "";
		$this->biaya_obat->EditValue = $this->biaya_obat->CurrentValue;
		$this->biaya_obat->PlaceHolder = ew_RemoveHtml($this->biaya_obat->FldCaption());
		if (strval($this->biaya_obat->EditValue) <> "" && is_numeric($this->biaya_obat->EditValue)) $this->biaya_obat->EditValue = ew_FormatNumber($this->biaya_obat->EditValue, -2, -1, -2, 0);

		// biaya_retur_obat
		$this->biaya_retur_obat->EditAttrs["class"] = "form-control";
		$this->biaya_retur_obat->EditCustomAttributes = "";
		$this->biaya_retur_obat->EditValue = $this->biaya_retur_obat->CurrentValue;
		$this->biaya_retur_obat->PlaceHolder = ew_RemoveHtml($this->biaya_retur_obat->FldCaption());
		if (strval($this->biaya_retur_obat->EditValue) <> "" && is_numeric($this->biaya_retur_obat->EditValue)) $this->biaya_retur_obat->EditValue = ew_FormatNumber($this->biaya_retur_obat->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_GIZI
		$this->TOT_BIAYA_GIZI->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_GIZI->EditCustomAttributes = "";
		$this->TOT_BIAYA_GIZI->EditValue = $this->TOT_BIAYA_GIZI->CurrentValue;
		$this->TOT_BIAYA_GIZI->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_GIZI->FldCaption());
		if (strval($this->TOT_BIAYA_GIZI->EditValue) <> "" && is_numeric($this->TOT_BIAYA_GIZI->EditValue)) $this->TOT_BIAYA_GIZI->EditValue = ew_FormatNumber($this->TOT_BIAYA_GIZI->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_TMO
		$this->TOT_BIAYA_TMO->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_TMO->EditCustomAttributes = "";
		$this->TOT_BIAYA_TMO->EditValue = $this->TOT_BIAYA_TMO->CurrentValue;
		$this->TOT_BIAYA_TMO->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_TMO->FldCaption());
		if (strval($this->TOT_BIAYA_TMO->EditValue) <> "" && is_numeric($this->TOT_BIAYA_TMO->EditValue)) $this->TOT_BIAYA_TMO->EditValue = ew_FormatNumber($this->TOT_BIAYA_TMO->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_AMBULAN
		$this->TOT_BIAYA_AMBULAN->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_AMBULAN->EditCustomAttributes = "";
		$this->TOT_BIAYA_AMBULAN->EditValue = $this->TOT_BIAYA_AMBULAN->CurrentValue;
		$this->TOT_BIAYA_AMBULAN->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_AMBULAN->FldCaption());
		if (strval($this->TOT_BIAYA_AMBULAN->EditValue) <> "" && is_numeric($this->TOT_BIAYA_AMBULAN->EditValue)) $this->TOT_BIAYA_AMBULAN->EditValue = ew_FormatNumber($this->TOT_BIAYA_AMBULAN->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_FISIO
		$this->TOT_BIAYA_FISIO->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_FISIO->EditCustomAttributes = "";
		$this->TOT_BIAYA_FISIO->EditValue = $this->TOT_BIAYA_FISIO->CurrentValue;
		$this->TOT_BIAYA_FISIO->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_FISIO->FldCaption());
		if (strval($this->TOT_BIAYA_FISIO->EditValue) <> "" && is_numeric($this->TOT_BIAYA_FISIO->EditValue)) $this->TOT_BIAYA_FISIO->EditValue = ew_FormatNumber($this->TOT_BIAYA_FISIO->EditValue, -2, -1, -2, 0);

		// TOT_BIAYA_LAINLAIN
		$this->TOT_BIAYA_LAINLAIN->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_LAINLAIN->EditCustomAttributes = "";
		$this->TOT_BIAYA_LAINLAIN->EditValue = $this->TOT_BIAYA_LAINLAIN->CurrentValue;
		$this->TOT_BIAYA_LAINLAIN->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_LAINLAIN->FldCaption());
		if (strval($this->TOT_BIAYA_LAINLAIN->EditValue) <> "" && is_numeric($this->TOT_BIAYA_LAINLAIN->EditValue)) $this->TOT_BIAYA_LAINLAIN->EditValue = ew_FormatNumber($this->TOT_BIAYA_LAINLAIN->EditValue, -2, -1, -2, 0);

		// jenisperawatan_id
		$this->jenisperawatan_id->EditAttrs["class"] = "form-control";
		$this->jenisperawatan_id->EditCustomAttributes = "";
		$this->jenisperawatan_id->EditValue = $this->jenisperawatan_id->CurrentValue;
		$this->jenisperawatan_id->PlaceHolder = ew_RemoveHtml($this->jenisperawatan_id->FldCaption());

		// status_transaksi
		$this->status_transaksi->EditAttrs["class"] = "form-control";
		$this->status_transaksi->EditCustomAttributes = "";
		$this->status_transaksi->EditValue = $this->status_transaksi->CurrentValue;
		$this->status_transaksi->PlaceHolder = ew_RemoveHtml($this->status_transaksi->FldCaption());

		// statuskeluarranap_id
		$this->statuskeluarranap_id->EditAttrs["class"] = "form-control";
		$this->statuskeluarranap_id->EditCustomAttributes = "";
		$this->statuskeluarranap_id->EditValue = $this->statuskeluarranap_id->CurrentValue;
		$this->statuskeluarranap_id->PlaceHolder = ew_RemoveHtml($this->statuskeluarranap_id->FldCaption());

		// TOT_BIAYA_AKOMODASI
		$this->TOT_BIAYA_AKOMODASI->EditAttrs["class"] = "form-control";
		$this->TOT_BIAYA_AKOMODASI->EditCustomAttributes = "";
		$this->TOT_BIAYA_AKOMODASI->EditValue = $this->TOT_BIAYA_AKOMODASI->CurrentValue;
		$this->TOT_BIAYA_AKOMODASI->PlaceHolder = ew_RemoveHtml($this->TOT_BIAYA_AKOMODASI->FldCaption());
		if (strval($this->TOT_BIAYA_AKOMODASI->EditValue) <> "" && is_numeric($this->TOT_BIAYA_AKOMODASI->EditValue)) $this->TOT_BIAYA_AKOMODASI->EditValue = ew_FormatNumber($this->TOT_BIAYA_AKOMODASI->EditValue, -2, -1, -2, 0);

		// TOTAL_BIAYA_ASKEP
		$this->TOTAL_BIAYA_ASKEP->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_ASKEP->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_ASKEP->EditValue = $this->TOTAL_BIAYA_ASKEP->CurrentValue;
		$this->TOTAL_BIAYA_ASKEP->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_ASKEP->FldCaption());
		if (strval($this->TOTAL_BIAYA_ASKEP->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_ASKEP->EditValue)) $this->TOTAL_BIAYA_ASKEP->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_ASKEP->EditValue, -2, -1, -2, 0);

		// TOTAL_BIAYA_SIMRS
		$this->TOTAL_BIAYA_SIMRS->EditAttrs["class"] = "form-control";
		$this->TOTAL_BIAYA_SIMRS->EditCustomAttributes = "";
		$this->TOTAL_BIAYA_SIMRS->EditValue = $this->TOTAL_BIAYA_SIMRS->CurrentValue;
		$this->TOTAL_BIAYA_SIMRS->PlaceHolder = ew_RemoveHtml($this->TOTAL_BIAYA_SIMRS->FldCaption());
		if (strval($this->TOTAL_BIAYA_SIMRS->EditValue) <> "" && is_numeric($this->TOTAL_BIAYA_SIMRS->EditValue)) $this->TOTAL_BIAYA_SIMRS->EditValue = ew_FormatNumber($this->TOTAL_BIAYA_SIMRS->EditValue, -2, -1, -2, 0);

		// TOT_PENJ_NMEDIS
		$this->TOT_PENJ_NMEDIS->EditAttrs["class"] = "form-control";
		$this->TOT_PENJ_NMEDIS->EditCustomAttributes = "";
		$this->TOT_PENJ_NMEDIS->EditValue = $this->TOT_PENJ_NMEDIS->CurrentValue;
		$this->TOT_PENJ_NMEDIS->PlaceHolder = ew_RemoveHtml($this->TOT_PENJ_NMEDIS->FldCaption());
		if (strval($this->TOT_PENJ_NMEDIS->EditValue) <> "" && is_numeric($this->TOT_PENJ_NMEDIS->EditValue)) $this->TOT_PENJ_NMEDIS->EditValue = ew_FormatNumber($this->TOT_PENJ_NMEDIS->EditValue, -2, -1, -2, 0);

		// LINK_MASTERDETAIL
		$this->LINK_MASTERDETAIL->EditAttrs["class"] = "form-control";
		$this->LINK_MASTERDETAIL->EditCustomAttributes = "";
		$this->LINK_MASTERDETAIL->EditValue = $this->LINK_MASTERDETAIL->CurrentValue;
		$this->LINK_MASTERDETAIL->PlaceHolder = ew_RemoveHtml($this->LINK_MASTERDETAIL->FldCaption());

		// NO_SKP
		$this->NO_SKP->EditAttrs["class"] = "form-control";
		$this->NO_SKP->EditCustomAttributes = "";
		$this->NO_SKP->EditValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->PlaceHolder = ew_RemoveHtml($this->NO_SKP->FldCaption());

		// LINK_PELAYANAN_OBAT
		$this->LINK_PELAYANAN_OBAT->EditAttrs["class"] = "form-control";
		$this->LINK_PELAYANAN_OBAT->EditCustomAttributes = "";
		$this->LINK_PELAYANAN_OBAT->EditValue = $this->LINK_PELAYANAN_OBAT->CurrentValue;
		$this->LINK_PELAYANAN_OBAT->PlaceHolder = ew_RemoveHtml($this->LINK_PELAYANAN_OBAT->FldCaption());

		// TOT_TIND_RAJAL
		$this->TOT_TIND_RAJAL->EditAttrs["class"] = "form-control";
		$this->TOT_TIND_RAJAL->EditCustomAttributes = "";
		$this->TOT_TIND_RAJAL->EditValue = $this->TOT_TIND_RAJAL->CurrentValue;
		$this->TOT_TIND_RAJAL->PlaceHolder = ew_RemoveHtml($this->TOT_TIND_RAJAL->FldCaption());
		if (strval($this->TOT_TIND_RAJAL->EditValue) <> "" && is_numeric($this->TOT_TIND_RAJAL->EditValue)) $this->TOT_TIND_RAJAL->EditValue = ew_FormatNumber($this->TOT_TIND_RAJAL->EditValue, -2, -1, -2, 0);

		// TOT_TIND_IGD
		$this->TOT_TIND_IGD->EditAttrs["class"] = "form-control";
		$this->TOT_TIND_IGD->EditCustomAttributes = "";
		$this->TOT_TIND_IGD->EditValue = $this->TOT_TIND_IGD->CurrentValue;
		$this->TOT_TIND_IGD->PlaceHolder = ew_RemoveHtml($this->TOT_TIND_IGD->FldCaption());
		if (strval($this->TOT_TIND_IGD->EditValue) <> "" && is_numeric($this->TOT_TIND_IGD->EditValue)) $this->TOT_TIND_IGD->EditValue = ew_FormatNumber($this->TOT_TIND_IGD->EditValue, -2, -1, -2, 0);

		// tanggal_pengembalian_status
		$this->tanggal_pengembalian_status->EditAttrs["class"] = "form-control";
		$this->tanggal_pengembalian_status->EditCustomAttributes = "";
		$this->tanggal_pengembalian_status->EditValue = ew_FormatDateTime($this->tanggal_pengembalian_status->CurrentValue, 8);
		$this->tanggal_pengembalian_status->PlaceHolder = ew_RemoveHtml($this->tanggal_pengembalian_status->FldCaption());

		// naik_kelas
		$this->naik_kelas->EditAttrs["class"] = "form-control";
		$this->naik_kelas->EditCustomAttributes = "";
		$this->naik_kelas->EditValue = $this->naik_kelas->CurrentValue;
		$this->naik_kelas->PlaceHolder = ew_RemoveHtml($this->naik_kelas->FldCaption());

		// iuran_kelas_lama
		$this->iuran_kelas_lama->EditAttrs["class"] = "form-control";
		$this->iuran_kelas_lama->EditCustomAttributes = "";
		$this->iuran_kelas_lama->EditValue = $this->iuran_kelas_lama->CurrentValue;
		$this->iuran_kelas_lama->PlaceHolder = ew_RemoveHtml($this->iuran_kelas_lama->FldCaption());
		if (strval($this->iuran_kelas_lama->EditValue) <> "" && is_numeric($this->iuran_kelas_lama->EditValue)) $this->iuran_kelas_lama->EditValue = ew_FormatNumber($this->iuran_kelas_lama->EditValue, -2, -1, -2, 0);

		// iuran_kelas_baru
		$this->iuran_kelas_baru->EditAttrs["class"] = "form-control";
		$this->iuran_kelas_baru->EditCustomAttributes = "";
		$this->iuran_kelas_baru->EditValue = $this->iuran_kelas_baru->CurrentValue;
		$this->iuran_kelas_baru->PlaceHolder = ew_RemoveHtml($this->iuran_kelas_baru->FldCaption());
		if (strval($this->iuran_kelas_baru->EditValue) <> "" && is_numeric($this->iuran_kelas_baru->EditValue)) $this->iuran_kelas_baru->EditValue = ew_FormatNumber($this->iuran_kelas_baru->EditValue, -2, -1, -2, 0);

		// ketrangan_naik_kelas
		$this->ketrangan_naik_kelas->EditAttrs["class"] = "form-control";
		$this->ketrangan_naik_kelas->EditCustomAttributes = "";
		$this->ketrangan_naik_kelas->EditValue = $this->ketrangan_naik_kelas->CurrentValue;
		$this->ketrangan_naik_kelas->PlaceHolder = ew_RemoveHtml($this->ketrangan_naik_kelas->FldCaption());

		// tgl_pengiriman_ad_klaim
		$this->tgl_pengiriman_ad_klaim->EditAttrs["class"] = "form-control";
		$this->tgl_pengiriman_ad_klaim->EditCustomAttributes = "";
		$this->tgl_pengiriman_ad_klaim->EditValue = ew_FormatDateTime($this->tgl_pengiriman_ad_klaim->CurrentValue, 8);
		$this->tgl_pengiriman_ad_klaim->PlaceHolder = ew_RemoveHtml($this->tgl_pengiriman_ad_klaim->FldCaption());

		// diagnosa_keluar
		$this->diagnosa_keluar->EditAttrs["class"] = "form-control";
		$this->diagnosa_keluar->EditCustomAttributes = "";
		$this->diagnosa_keluar->EditValue = $this->diagnosa_keluar->CurrentValue;
		$this->diagnosa_keluar->PlaceHolder = ew_RemoveHtml($this->diagnosa_keluar->FldCaption());

		// sep_tglsep
		$this->sep_tglsep->EditAttrs["class"] = "form-control";
		$this->sep_tglsep->EditCustomAttributes = "";
		$this->sep_tglsep->EditValue = ew_FormatDateTime($this->sep_tglsep->CurrentValue, 8);
		$this->sep_tglsep->PlaceHolder = ew_RemoveHtml($this->sep_tglsep->FldCaption());

		// sep_tglrujuk
		$this->sep_tglrujuk->EditAttrs["class"] = "form-control";
		$this->sep_tglrujuk->EditCustomAttributes = "";
		$this->sep_tglrujuk->EditValue = ew_FormatDateTime($this->sep_tglrujuk->CurrentValue, 8);
		$this->sep_tglrujuk->PlaceHolder = ew_RemoveHtml($this->sep_tglrujuk->FldCaption());

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat->EditAttrs["class"] = "form-control";
		$this->sep_kodekelasrawat->EditCustomAttributes = "";
		$this->sep_kodekelasrawat->EditValue = $this->sep_kodekelasrawat->CurrentValue;
		$this->sep_kodekelasrawat->PlaceHolder = ew_RemoveHtml($this->sep_kodekelasrawat->FldCaption());

		// sep_norujukan
		$this->sep_norujukan->EditAttrs["class"] = "form-control";
		$this->sep_norujukan->EditCustomAttributes = "";
		$this->sep_norujukan->EditValue = $this->sep_norujukan->CurrentValue;
		$this->sep_norujukan->PlaceHolder = ew_RemoveHtml($this->sep_norujukan->FldCaption());

		// sep_kodeppkasal
		$this->sep_kodeppkasal->EditAttrs["class"] = "form-control";
		$this->sep_kodeppkasal->EditCustomAttributes = "";
		$this->sep_kodeppkasal->EditValue = $this->sep_kodeppkasal->CurrentValue;
		$this->sep_kodeppkasal->PlaceHolder = ew_RemoveHtml($this->sep_kodeppkasal->FldCaption());

		// sep_namappkasal
		$this->sep_namappkasal->EditAttrs["class"] = "form-control";
		$this->sep_namappkasal->EditCustomAttributes = "";
		$this->sep_namappkasal->EditValue = $this->sep_namappkasal->CurrentValue;
		$this->sep_namappkasal->PlaceHolder = ew_RemoveHtml($this->sep_namappkasal->FldCaption());

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan->EditAttrs["class"] = "form-control";
		$this->sep_kodeppkpelayanan->EditCustomAttributes = "";
		$this->sep_kodeppkpelayanan->EditValue = $this->sep_kodeppkpelayanan->CurrentValue;
		$this->sep_kodeppkpelayanan->PlaceHolder = ew_RemoveHtml($this->sep_kodeppkpelayanan->FldCaption());

		// sep_namappkpelayanan
		$this->sep_namappkpelayanan->EditAttrs["class"] = "form-control";
		$this->sep_namappkpelayanan->EditCustomAttributes = "";
		$this->sep_namappkpelayanan->EditValue = $this->sep_namappkpelayanan->CurrentValue;
		$this->sep_namappkpelayanan->PlaceHolder = ew_RemoveHtml($this->sep_namappkpelayanan->FldCaption());

		// t_admissioncol
		$this->t_admissioncol->EditAttrs["class"] = "form-control";
		$this->t_admissioncol->EditCustomAttributes = "";
		$this->t_admissioncol->EditValue = $this->t_admissioncol->CurrentValue;
		$this->t_admissioncol->PlaceHolder = ew_RemoveHtml($this->t_admissioncol->FldCaption());

		// sep_jenisperawatan
		$this->sep_jenisperawatan->EditAttrs["class"] = "form-control";
		$this->sep_jenisperawatan->EditCustomAttributes = "";
		$this->sep_jenisperawatan->EditValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_jenisperawatan->PlaceHolder = ew_RemoveHtml($this->sep_jenisperawatan->FldCaption());

		// sep_catatan
		$this->sep_catatan->EditAttrs["class"] = "form-control";
		$this->sep_catatan->EditCustomAttributes = "";
		$this->sep_catatan->EditValue = $this->sep_catatan->CurrentValue;
		$this->sep_catatan->PlaceHolder = ew_RemoveHtml($this->sep_catatan->FldCaption());

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->EditAttrs["class"] = "form-control";
		$this->sep_kodediagnosaawal->EditCustomAttributes = "";
		$this->sep_kodediagnosaawal->EditValue = $this->sep_kodediagnosaawal->CurrentValue;
		$this->sep_kodediagnosaawal->PlaceHolder = ew_RemoveHtml($this->sep_kodediagnosaawal->FldCaption());

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->EditAttrs["class"] = "form-control";
		$this->sep_namadiagnosaawal->EditCustomAttributes = "";
		$this->sep_namadiagnosaawal->EditValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->PlaceHolder = ew_RemoveHtml($this->sep_namadiagnosaawal->FldCaption());

		// sep_lakalantas
		$this->sep_lakalantas->EditAttrs["class"] = "form-control";
		$this->sep_lakalantas->EditCustomAttributes = "";
		$this->sep_lakalantas->EditValue = $this->sep_lakalantas->CurrentValue;
		$this->sep_lakalantas->PlaceHolder = ew_RemoveHtml($this->sep_lakalantas->FldCaption());

		// sep_lokasilaka
		$this->sep_lokasilaka->EditAttrs["class"] = "form-control";
		$this->sep_lokasilaka->EditCustomAttributes = "";
		$this->sep_lokasilaka->EditValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_lokasilaka->PlaceHolder = ew_RemoveHtml($this->sep_lokasilaka->FldCaption());

		// sep_user
		$this->sep_user->EditAttrs["class"] = "form-control";
		$this->sep_user->EditCustomAttributes = "";
		$this->sep_user->EditValue = $this->sep_user->CurrentValue;
		$this->sep_user->PlaceHolder = ew_RemoveHtml($this->sep_user->FldCaption());

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta->EditAttrs["class"] = "form-control";
		$this->sep_flag_cekpeserta->EditCustomAttributes = "";
		$this->sep_flag_cekpeserta->EditValue = $this->sep_flag_cekpeserta->CurrentValue;
		$this->sep_flag_cekpeserta->PlaceHolder = ew_RemoveHtml($this->sep_flag_cekpeserta->FldCaption());

		// sep_flag_generatesep
		$this->sep_flag_generatesep->EditAttrs["class"] = "form-control";
		$this->sep_flag_generatesep->EditCustomAttributes = "";
		$this->sep_flag_generatesep->EditValue = $this->sep_flag_generatesep->CurrentValue;
		$this->sep_flag_generatesep->PlaceHolder = ew_RemoveHtml($this->sep_flag_generatesep->FldCaption());

		// sep_flag_mapingsep
		$this->sep_flag_mapingsep->EditAttrs["class"] = "form-control";
		$this->sep_flag_mapingsep->EditCustomAttributes = "";
		$this->sep_flag_mapingsep->EditValue = $this->sep_flag_mapingsep->CurrentValue;
		$this->sep_flag_mapingsep->PlaceHolder = ew_RemoveHtml($this->sep_flag_mapingsep->FldCaption());

		// sep_nik
		$this->sep_nik->EditAttrs["class"] = "form-control";
		$this->sep_nik->EditCustomAttributes = "";
		$this->sep_nik->EditValue = $this->sep_nik->CurrentValue;
		$this->sep_nik->PlaceHolder = ew_RemoveHtml($this->sep_nik->FldCaption());

		// sep_namapeserta
		$this->sep_namapeserta->EditAttrs["class"] = "form-control";
		$this->sep_namapeserta->EditCustomAttributes = "";
		$this->sep_namapeserta->EditValue = $this->sep_namapeserta->CurrentValue;
		$this->sep_namapeserta->PlaceHolder = ew_RemoveHtml($this->sep_namapeserta->FldCaption());

		// sep_jeniskelamin
		$this->sep_jeniskelamin->EditAttrs["class"] = "form-control";
		$this->sep_jeniskelamin->EditCustomAttributes = "";
		$this->sep_jeniskelamin->EditValue = $this->sep_jeniskelamin->CurrentValue;
		$this->sep_jeniskelamin->PlaceHolder = ew_RemoveHtml($this->sep_jeniskelamin->FldCaption());

		// sep_pisat
		$this->sep_pisat->EditAttrs["class"] = "form-control";
		$this->sep_pisat->EditCustomAttributes = "";
		$this->sep_pisat->EditValue = $this->sep_pisat->CurrentValue;
		$this->sep_pisat->PlaceHolder = ew_RemoveHtml($this->sep_pisat->FldCaption());

		// sep_tgllahir
		$this->sep_tgllahir->EditAttrs["class"] = "form-control";
		$this->sep_tgllahir->EditCustomAttributes = "";
		$this->sep_tgllahir->EditValue = $this->sep_tgllahir->CurrentValue;
		$this->sep_tgllahir->PlaceHolder = ew_RemoveHtml($this->sep_tgllahir->FldCaption());

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan->EditAttrs["class"] = "form-control";
		$this->sep_kodejeniskepesertaan->EditCustomAttributes = "";
		$this->sep_kodejeniskepesertaan->EditValue = $this->sep_kodejeniskepesertaan->CurrentValue;
		$this->sep_kodejeniskepesertaan->PlaceHolder = ew_RemoveHtml($this->sep_kodejeniskepesertaan->FldCaption());

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan->EditAttrs["class"] = "form-control";
		$this->sep_namajeniskepesertaan->EditCustomAttributes = "";
		$this->sep_namajeniskepesertaan->EditValue = $this->sep_namajeniskepesertaan->CurrentValue;
		$this->sep_namajeniskepesertaan->PlaceHolder = ew_RemoveHtml($this->sep_namajeniskepesertaan->FldCaption());

		// sep_kodepolitujuan
		$this->sep_kodepolitujuan->EditAttrs["class"] = "form-control";
		$this->sep_kodepolitujuan->EditCustomAttributes = "";
		$this->sep_kodepolitujuan->EditValue = $this->sep_kodepolitujuan->CurrentValue;
		$this->sep_kodepolitujuan->PlaceHolder = ew_RemoveHtml($this->sep_kodepolitujuan->FldCaption());

		// sep_namapolitujuan
		$this->sep_namapolitujuan->EditAttrs["class"] = "form-control";
		$this->sep_namapolitujuan->EditCustomAttributes = "";
		$this->sep_namapolitujuan->EditValue = $this->sep_namapolitujuan->CurrentValue;
		$this->sep_namapolitujuan->PlaceHolder = ew_RemoveHtml($this->sep_namapolitujuan->FldCaption());

		// ket_jeniskelamin
		$this->ket_jeniskelamin->EditAttrs["class"] = "form-control";
		$this->ket_jeniskelamin->EditCustomAttributes = "";
		$this->ket_jeniskelamin->EditValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->PlaceHolder = ew_RemoveHtml($this->ket_jeniskelamin->FldCaption());

		// sep_nokabpjs
		$this->sep_nokabpjs->EditAttrs["class"] = "form-control";
		$this->sep_nokabpjs->EditCustomAttributes = "";
		$this->sep_nokabpjs->EditValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->PlaceHolder = ew_RemoveHtml($this->sep_nokabpjs->FldCaption());

		// counter_cetak_sep
		$this->counter_cetak_sep->EditAttrs["class"] = "form-control";
		$this->counter_cetak_sep->EditCustomAttributes = "";
		$this->counter_cetak_sep->EditValue = $this->counter_cetak_sep->CurrentValue;
		$this->counter_cetak_sep->PlaceHolder = ew_RemoveHtml($this->counter_cetak_sep->FldCaption());

		// sep_petugas_hapus_sep
		$this->sep_petugas_hapus_sep->EditAttrs["class"] = "form-control";
		$this->sep_petugas_hapus_sep->EditCustomAttributes = "";
		$this->sep_petugas_hapus_sep->EditValue = $this->sep_petugas_hapus_sep->CurrentValue;
		$this->sep_petugas_hapus_sep->PlaceHolder = ew_RemoveHtml($this->sep_petugas_hapus_sep->FldCaption());

		// sep_petugas_set_tgl_pulang
		$this->sep_petugas_set_tgl_pulang->EditAttrs["class"] = "form-control";
		$this->sep_petugas_set_tgl_pulang->EditCustomAttributes = "";
		$this->sep_petugas_set_tgl_pulang->EditValue = $this->sep_petugas_set_tgl_pulang->CurrentValue;
		$this->sep_petugas_set_tgl_pulang->PlaceHolder = ew_RemoveHtml($this->sep_petugas_set_tgl_pulang->FldCaption());

		// sep_jam_generate_sep
		$this->sep_jam_generate_sep->EditAttrs["class"] = "form-control";
		$this->sep_jam_generate_sep->EditCustomAttributes = "";
		$this->sep_jam_generate_sep->EditValue = ew_FormatDateTime($this->sep_jam_generate_sep->CurrentValue, 8);
		$this->sep_jam_generate_sep->PlaceHolder = ew_RemoveHtml($this->sep_jam_generate_sep->FldCaption());

		// sep_status_peserta
		$this->sep_status_peserta->EditAttrs["class"] = "form-control";
		$this->sep_status_peserta->EditCustomAttributes = "";
		$this->sep_status_peserta->EditValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_status_peserta->PlaceHolder = ew_RemoveHtml($this->sep_status_peserta->FldCaption());

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->EditAttrs["class"] = "form-control";
		$this->sep_umur_pasien_sekarang->EditCustomAttributes = "";
		$this->sep_umur_pasien_sekarang->EditValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->sep_umur_pasien_sekarang->PlaceHolder = ew_RemoveHtml($this->sep_umur_pasien_sekarang->FldCaption());

		// ket_title
		$this->ket_title->EditAttrs["class"] = "form-control";
		$this->ket_title->EditCustomAttributes = "";
		$this->ket_title->EditValue = $this->ket_title->CurrentValue;
		$this->ket_title->PlaceHolder = ew_RemoveHtml($this->ket_title->FldCaption());

		// status_daftar_ranap
		$this->status_daftar_ranap->EditAttrs["class"] = "form-control";
		$this->status_daftar_ranap->EditCustomAttributes = "";
		$this->status_daftar_ranap->EditValue = $this->status_daftar_ranap->CurrentValue;
		$this->status_daftar_ranap->PlaceHolder = ew_RemoveHtml($this->status_daftar_ranap->FldCaption());

		// IBS_SETMARKING
		$this->IBS_SETMARKING->EditAttrs["class"] = "form-control";
		$this->IBS_SETMARKING->EditCustomAttributes = "";
		$this->IBS_SETMARKING->EditValue = $this->IBS_SETMARKING->CurrentValue;
		$this->IBS_SETMARKING->PlaceHolder = ew_RemoveHtml($this->IBS_SETMARKING->FldCaption());

		// IBS_PATOLOGI
		$this->IBS_PATOLOGI->EditAttrs["class"] = "form-control";
		$this->IBS_PATOLOGI->EditCustomAttributes = "";
		$this->IBS_PATOLOGI->EditValue = $this->IBS_PATOLOGI->CurrentValue;
		$this->IBS_PATOLOGI->PlaceHolder = ew_RemoveHtml($this->IBS_PATOLOGI->FldCaption());

		// IBS_JENISANESTESI
		$this->IBS_JENISANESTESI->EditAttrs["class"] = "form-control";
		$this->IBS_JENISANESTESI->EditCustomAttributes = "";
		$this->IBS_JENISANESTESI->EditValue = $this->IBS_JENISANESTESI->CurrentValue;
		$this->IBS_JENISANESTESI->PlaceHolder = ew_RemoveHtml($this->IBS_JENISANESTESI->FldCaption());

		// IBS_NO_OK
		$this->IBS_NO_OK->EditAttrs["class"] = "form-control";
		$this->IBS_NO_OK->EditCustomAttributes = "";
		$this->IBS_NO_OK->EditValue = $this->IBS_NO_OK->CurrentValue;
		$this->IBS_NO_OK->PlaceHolder = ew_RemoveHtml($this->IBS_NO_OK->FldCaption());

		// IBS_ASISSTEN
		$this->IBS_ASISSTEN->EditAttrs["class"] = "form-control";
		$this->IBS_ASISSTEN->EditCustomAttributes = "";
		$this->IBS_ASISSTEN->EditValue = $this->IBS_ASISSTEN->CurrentValue;
		$this->IBS_ASISSTEN->PlaceHolder = ew_RemoveHtml($this->IBS_ASISSTEN->FldCaption());

		// IBS_JAM_ELEFTIF
		$this->IBS_JAM_ELEFTIF->EditAttrs["class"] = "form-control";
		$this->IBS_JAM_ELEFTIF->EditCustomAttributes = "";
		$this->IBS_JAM_ELEFTIF->EditValue = ew_FormatDateTime($this->IBS_JAM_ELEFTIF->CurrentValue, 8);
		$this->IBS_JAM_ELEFTIF->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_ELEFTIF->FldCaption());

		// IBS_JAM_ELEKTIF_SELESAI
		$this->IBS_JAM_ELEKTIF_SELESAI->EditAttrs["class"] = "form-control";
		$this->IBS_JAM_ELEKTIF_SELESAI->EditCustomAttributes = "";
		$this->IBS_JAM_ELEKTIF_SELESAI->EditValue = ew_FormatDateTime($this->IBS_JAM_ELEKTIF_SELESAI->CurrentValue, 8);
		$this->IBS_JAM_ELEKTIF_SELESAI->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_ELEKTIF_SELESAI->FldCaption());

		// IBS_JAM_CYTO
		$this->IBS_JAM_CYTO->EditAttrs["class"] = "form-control";
		$this->IBS_JAM_CYTO->EditCustomAttributes = "";
		$this->IBS_JAM_CYTO->EditValue = ew_FormatDateTime($this->IBS_JAM_CYTO->CurrentValue, 8);
		$this->IBS_JAM_CYTO->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_CYTO->FldCaption());

		// IBS_JAM_CYTO_SELESAI
		$this->IBS_JAM_CYTO_SELESAI->EditAttrs["class"] = "form-control";
		$this->IBS_JAM_CYTO_SELESAI->EditCustomAttributes = "";
		$this->IBS_JAM_CYTO_SELESAI->EditValue = ew_FormatDateTime($this->IBS_JAM_CYTO_SELESAI->CurrentValue, 8);
		$this->IBS_JAM_CYTO_SELESAI->PlaceHolder = ew_RemoveHtml($this->IBS_JAM_CYTO_SELESAI->FldCaption());

		// IBS_TGL_DFTR_OP
		$this->IBS_TGL_DFTR_OP->EditAttrs["class"] = "form-control";
		$this->IBS_TGL_DFTR_OP->EditCustomAttributes = "";
		$this->IBS_TGL_DFTR_OP->EditValue = ew_FormatDateTime($this->IBS_TGL_DFTR_OP->CurrentValue, 8);
		$this->IBS_TGL_DFTR_OP->PlaceHolder = ew_RemoveHtml($this->IBS_TGL_DFTR_OP->FldCaption());

		// IBS_TGL_OP
		$this->IBS_TGL_OP->EditAttrs["class"] = "form-control";
		$this->IBS_TGL_OP->EditCustomAttributes = "";
		$this->IBS_TGL_OP->EditValue = ew_FormatDateTime($this->IBS_TGL_OP->CurrentValue, 8);
		$this->IBS_TGL_OP->PlaceHolder = ew_RemoveHtml($this->IBS_TGL_OP->FldCaption());

		// grup_ruang_id
		$this->grup_ruang_id->EditAttrs["class"] = "form-control";
		$this->grup_ruang_id->EditCustomAttributes = "";
		$this->grup_ruang_id->EditValue = $this->grup_ruang_id->CurrentValue;
		$this->grup_ruang_id->PlaceHolder = ew_RemoveHtml($this->grup_ruang_id->FldCaption());

		// status_order_ibs
		$this->status_order_ibs->EditAttrs["class"] = "form-control";
		$this->status_order_ibs->EditCustomAttributes = "";
		$this->status_order_ibs->EditValue = $this->status_order_ibs->CurrentValue;
		$this->status_order_ibs->PlaceHolder = ew_RemoveHtml($this->status_order_ibs->FldCaption());

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
					if ($this->id_admission->Exportable) $Doc->ExportCaption($this->id_admission);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->ket_nama->Exportable) $Doc->ExportCaption($this->ket_nama);
					if ($this->ket_tgllahir->Exportable) $Doc->ExportCaption($this->ket_tgllahir);
					if ($this->ket_alamat->Exportable) $Doc->ExportCaption($this->ket_alamat);
					if ($this->parent_nomr->Exportable) $Doc->ExportCaption($this->parent_nomr);
					if ($this->dokterpengirim->Exportable) $Doc->ExportCaption($this->dokterpengirim);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->kirimdari->Exportable) $Doc->ExportCaption($this->kirimdari);
					if ($this->keluargadekat->Exportable) $Doc->ExportCaption($this->keluargadekat);
					if ($this->panggungjawab->Exportable) $Doc->ExportCaption($this->panggungjawab);
					if ($this->masukrs->Exportable) $Doc->ExportCaption($this->masukrs);
					if ($this->noruang->Exportable) $Doc->ExportCaption($this->noruang);
					if ($this->tempat_tidur_id->Exportable) $Doc->ExportCaption($this->tempat_tidur_id);
					if ($this->nott->Exportable) $Doc->ExportCaption($this->nott);
					if ($this->deposit->Exportable) $Doc->ExportCaption($this->deposit);
					if ($this->keluarrs->Exportable) $Doc->ExportCaption($this->keluarrs);
					if ($this->icd_masuk->Exportable) $Doc->ExportCaption($this->icd_masuk);
					if ($this->icd_keluar->Exportable) $Doc->ExportCaption($this->icd_keluar);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->noruang_asal->Exportable) $Doc->ExportCaption($this->noruang_asal);
					if ($this->nott_asal->Exportable) $Doc->ExportCaption($this->nott_asal);
					if ($this->tgl_pindah->Exportable) $Doc->ExportCaption($this->tgl_pindah);
					if ($this->kd_rujuk->Exportable) $Doc->ExportCaption($this->kd_rujuk);
					if ($this->st_bayar->Exportable) $Doc->ExportCaption($this->st_bayar);
					if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportCaption($this->dokter_penanggungjawab);
					if ($this->perawat->Exportable) $Doc->ExportCaption($this->perawat);
					if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportCaption($this->KELASPERAWATAN_ID);
					if ($this->LOS->Exportable) $Doc->ExportCaption($this->LOS);
					if ($this->TOT_TRF_TIND_DOKTER->Exportable) $Doc->ExportCaption($this->TOT_TRF_TIND_DOKTER);
					if ($this->TOT_BHP_DOKTER->Exportable) $Doc->ExportCaption($this->TOT_BHP_DOKTER);
					if ($this->TOT_TRF_PERAWAT->Exportable) $Doc->ExportCaption($this->TOT_TRF_PERAWAT);
					if ($this->TOT_BHP_PERAWAT->Exportable) $Doc->ExportCaption($this->TOT_BHP_PERAWAT);
					if ($this->TOT_TRF_DOKTER->Exportable) $Doc->ExportCaption($this->TOT_TRF_DOKTER);
					if ($this->TOT_BIAYA_RAD->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_RAD);
					if ($this->TOT_BIAYA_CDRPOLI->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_CDRPOLI);
					if ($this->TOT_BIAYA_LAB_IGD->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_LAB_IGD);
					if ($this->TOT_BIAYA_OKSIGEN->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_OKSIGEN);
					if ($this->TOTAL_BIAYA_OBAT->Exportable) $Doc->ExportCaption($this->TOTAL_BIAYA_OBAT);
					if ($this->LINK_SET_KELAS->Exportable) $Doc->ExportCaption($this->LINK_SET_KELAS);
					if ($this->biaya_obat->Exportable) $Doc->ExportCaption($this->biaya_obat);
					if ($this->biaya_retur_obat->Exportable) $Doc->ExportCaption($this->biaya_retur_obat);
					if ($this->TOT_BIAYA_GIZI->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_GIZI);
					if ($this->TOT_BIAYA_TMO->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_TMO);
					if ($this->TOT_BIAYA_AMBULAN->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_AMBULAN);
					if ($this->TOT_BIAYA_FISIO->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_FISIO);
					if ($this->TOT_BIAYA_LAINLAIN->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_LAINLAIN);
					if ($this->jenisperawatan_id->Exportable) $Doc->ExportCaption($this->jenisperawatan_id);
					if ($this->status_transaksi->Exportable) $Doc->ExportCaption($this->status_transaksi);
					if ($this->statuskeluarranap_id->Exportable) $Doc->ExportCaption($this->statuskeluarranap_id);
					if ($this->TOT_BIAYA_AKOMODASI->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_AKOMODASI);
					if ($this->TOTAL_BIAYA_ASKEP->Exportable) $Doc->ExportCaption($this->TOTAL_BIAYA_ASKEP);
					if ($this->TOTAL_BIAYA_SIMRS->Exportable) $Doc->ExportCaption($this->TOTAL_BIAYA_SIMRS);
					if ($this->TOT_PENJ_NMEDIS->Exportable) $Doc->ExportCaption($this->TOT_PENJ_NMEDIS);
					if ($this->LINK_MASTERDETAIL->Exportable) $Doc->ExportCaption($this->LINK_MASTERDETAIL);
					if ($this->NO_SKP->Exportable) $Doc->ExportCaption($this->NO_SKP);
					if ($this->LINK_PELAYANAN_OBAT->Exportable) $Doc->ExportCaption($this->LINK_PELAYANAN_OBAT);
					if ($this->TOT_TIND_RAJAL->Exportable) $Doc->ExportCaption($this->TOT_TIND_RAJAL);
					if ($this->TOT_TIND_IGD->Exportable) $Doc->ExportCaption($this->TOT_TIND_IGD);
					if ($this->tanggal_pengembalian_status->Exportable) $Doc->ExportCaption($this->tanggal_pengembalian_status);
					if ($this->naik_kelas->Exportable) $Doc->ExportCaption($this->naik_kelas);
					if ($this->iuran_kelas_lama->Exportable) $Doc->ExportCaption($this->iuran_kelas_lama);
					if ($this->iuran_kelas_baru->Exportable) $Doc->ExportCaption($this->iuran_kelas_baru);
					if ($this->ketrangan_naik_kelas->Exportable) $Doc->ExportCaption($this->ketrangan_naik_kelas);
					if ($this->tgl_pengiriman_ad_klaim->Exportable) $Doc->ExportCaption($this->tgl_pengiriman_ad_klaim);
					if ($this->diagnosa_keluar->Exportable) $Doc->ExportCaption($this->diagnosa_keluar);
					if ($this->sep_tglsep->Exportable) $Doc->ExportCaption($this->sep_tglsep);
					if ($this->sep_tglrujuk->Exportable) $Doc->ExportCaption($this->sep_tglrujuk);
					if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportCaption($this->sep_kodekelasrawat);
					if ($this->sep_norujukan->Exportable) $Doc->ExportCaption($this->sep_norujukan);
					if ($this->sep_kodeppkasal->Exportable) $Doc->ExportCaption($this->sep_kodeppkasal);
					if ($this->sep_namappkasal->Exportable) $Doc->ExportCaption($this->sep_namappkasal);
					if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportCaption($this->sep_kodeppkpelayanan);
					if ($this->sep_namappkpelayanan->Exportable) $Doc->ExportCaption($this->sep_namappkpelayanan);
					if ($this->t_admissioncol->Exportable) $Doc->ExportCaption($this->t_admissioncol);
					if ($this->sep_jenisperawatan->Exportable) $Doc->ExportCaption($this->sep_jenisperawatan);
					if ($this->sep_catatan->Exportable) $Doc->ExportCaption($this->sep_catatan);
					if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportCaption($this->sep_kodediagnosaawal);
					if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportCaption($this->sep_namadiagnosaawal);
					if ($this->sep_lakalantas->Exportable) $Doc->ExportCaption($this->sep_lakalantas);
					if ($this->sep_lokasilaka->Exportable) $Doc->ExportCaption($this->sep_lokasilaka);
					if ($this->sep_user->Exportable) $Doc->ExportCaption($this->sep_user);
					if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportCaption($this->sep_flag_cekpeserta);
					if ($this->sep_flag_generatesep->Exportable) $Doc->ExportCaption($this->sep_flag_generatesep);
					if ($this->sep_flag_mapingsep->Exportable) $Doc->ExportCaption($this->sep_flag_mapingsep);
					if ($this->sep_nik->Exportable) $Doc->ExportCaption($this->sep_nik);
					if ($this->sep_namapeserta->Exportable) $Doc->ExportCaption($this->sep_namapeserta);
					if ($this->sep_jeniskelamin->Exportable) $Doc->ExportCaption($this->sep_jeniskelamin);
					if ($this->sep_pisat->Exportable) $Doc->ExportCaption($this->sep_pisat);
					if ($this->sep_tgllahir->Exportable) $Doc->ExportCaption($this->sep_tgllahir);
					if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_kodejeniskepesertaan);
					if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_namajeniskepesertaan);
					if ($this->sep_kodepolitujuan->Exportable) $Doc->ExportCaption($this->sep_kodepolitujuan);
					if ($this->sep_namapolitujuan->Exportable) $Doc->ExportCaption($this->sep_namapolitujuan);
					if ($this->ket_jeniskelamin->Exportable) $Doc->ExportCaption($this->ket_jeniskelamin);
					if ($this->sep_nokabpjs->Exportable) $Doc->ExportCaption($this->sep_nokabpjs);
					if ($this->counter_cetak_sep->Exportable) $Doc->ExportCaption($this->counter_cetak_sep);
					if ($this->sep_petugas_hapus_sep->Exportable) $Doc->ExportCaption($this->sep_petugas_hapus_sep);
					if ($this->sep_petugas_set_tgl_pulang->Exportable) $Doc->ExportCaption($this->sep_petugas_set_tgl_pulang);
					if ($this->sep_jam_generate_sep->Exportable) $Doc->ExportCaption($this->sep_jam_generate_sep);
					if ($this->sep_status_peserta->Exportable) $Doc->ExportCaption($this->sep_status_peserta);
					if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportCaption($this->sep_umur_pasien_sekarang);
					if ($this->ket_title->Exportable) $Doc->ExportCaption($this->ket_title);
					if ($this->status_daftar_ranap->Exportable) $Doc->ExportCaption($this->status_daftar_ranap);
					if ($this->IBS_SETMARKING->Exportable) $Doc->ExportCaption($this->IBS_SETMARKING);
					if ($this->IBS_PATOLOGI->Exportable) $Doc->ExportCaption($this->IBS_PATOLOGI);
					if ($this->IBS_JENISANESTESI->Exportable) $Doc->ExportCaption($this->IBS_JENISANESTESI);
					if ($this->IBS_NO_OK->Exportable) $Doc->ExportCaption($this->IBS_NO_OK);
					if ($this->IBS_ASISSTEN->Exportable) $Doc->ExportCaption($this->IBS_ASISSTEN);
					if ($this->IBS_JAM_ELEFTIF->Exportable) $Doc->ExportCaption($this->IBS_JAM_ELEFTIF);
					if ($this->IBS_JAM_ELEKTIF_SELESAI->Exportable) $Doc->ExportCaption($this->IBS_JAM_ELEKTIF_SELESAI);
					if ($this->IBS_JAM_CYTO->Exportable) $Doc->ExportCaption($this->IBS_JAM_CYTO);
					if ($this->IBS_JAM_CYTO_SELESAI->Exportable) $Doc->ExportCaption($this->IBS_JAM_CYTO_SELESAI);
					if ($this->IBS_TGL_DFTR_OP->Exportable) $Doc->ExportCaption($this->IBS_TGL_DFTR_OP);
					if ($this->IBS_TGL_OP->Exportable) $Doc->ExportCaption($this->IBS_TGL_OP);
					if ($this->grup_ruang_id->Exportable) $Doc->ExportCaption($this->grup_ruang_id);
					if ($this->status_order_ibs->Exportable) $Doc->ExportCaption($this->status_order_ibs);
				} else {
					if ($this->id_admission->Exportable) $Doc->ExportCaption($this->id_admission);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->ket_nama->Exportable) $Doc->ExportCaption($this->ket_nama);
					if ($this->ket_tgllahir->Exportable) $Doc->ExportCaption($this->ket_tgllahir);
					if ($this->ket_alamat->Exportable) $Doc->ExportCaption($this->ket_alamat);
					if ($this->parent_nomr->Exportable) $Doc->ExportCaption($this->parent_nomr);
					if ($this->dokterpengirim->Exportable) $Doc->ExportCaption($this->dokterpengirim);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->kirimdari->Exportable) $Doc->ExportCaption($this->kirimdari);
					if ($this->keluargadekat->Exportable) $Doc->ExportCaption($this->keluargadekat);
					if ($this->panggungjawab->Exportable) $Doc->ExportCaption($this->panggungjawab);
					if ($this->masukrs->Exportable) $Doc->ExportCaption($this->masukrs);
					if ($this->noruang->Exportable) $Doc->ExportCaption($this->noruang);
					if ($this->tempat_tidur_id->Exportable) $Doc->ExportCaption($this->tempat_tidur_id);
					if ($this->nott->Exportable) $Doc->ExportCaption($this->nott);
					if ($this->deposit->Exportable) $Doc->ExportCaption($this->deposit);
					if ($this->keluarrs->Exportable) $Doc->ExportCaption($this->keluarrs);
					if ($this->icd_masuk->Exportable) $Doc->ExportCaption($this->icd_masuk);
					if ($this->icd_keluar->Exportable) $Doc->ExportCaption($this->icd_keluar);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->noruang_asal->Exportable) $Doc->ExportCaption($this->noruang_asal);
					if ($this->nott_asal->Exportable) $Doc->ExportCaption($this->nott_asal);
					if ($this->tgl_pindah->Exportable) $Doc->ExportCaption($this->tgl_pindah);
					if ($this->kd_rujuk->Exportable) $Doc->ExportCaption($this->kd_rujuk);
					if ($this->st_bayar->Exportable) $Doc->ExportCaption($this->st_bayar);
					if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportCaption($this->dokter_penanggungjawab);
					if ($this->perawat->Exportable) $Doc->ExportCaption($this->perawat);
					if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportCaption($this->KELASPERAWATAN_ID);
					if ($this->LOS->Exportable) $Doc->ExportCaption($this->LOS);
					if ($this->TOT_TRF_TIND_DOKTER->Exportable) $Doc->ExportCaption($this->TOT_TRF_TIND_DOKTER);
					if ($this->TOT_BHP_DOKTER->Exportable) $Doc->ExportCaption($this->TOT_BHP_DOKTER);
					if ($this->TOT_TRF_PERAWAT->Exportable) $Doc->ExportCaption($this->TOT_TRF_PERAWAT);
					if ($this->TOT_BHP_PERAWAT->Exportable) $Doc->ExportCaption($this->TOT_BHP_PERAWAT);
					if ($this->TOT_TRF_DOKTER->Exportable) $Doc->ExportCaption($this->TOT_TRF_DOKTER);
					if ($this->TOT_BIAYA_RAD->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_RAD);
					if ($this->TOT_BIAYA_CDRPOLI->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_CDRPOLI);
					if ($this->TOT_BIAYA_LAB_IGD->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_LAB_IGD);
					if ($this->TOT_BIAYA_OKSIGEN->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_OKSIGEN);
					if ($this->TOTAL_BIAYA_OBAT->Exportable) $Doc->ExportCaption($this->TOTAL_BIAYA_OBAT);
					if ($this->LINK_SET_KELAS->Exportable) $Doc->ExportCaption($this->LINK_SET_KELAS);
					if ($this->biaya_obat->Exportable) $Doc->ExportCaption($this->biaya_obat);
					if ($this->biaya_retur_obat->Exportable) $Doc->ExportCaption($this->biaya_retur_obat);
					if ($this->TOT_BIAYA_GIZI->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_GIZI);
					if ($this->TOT_BIAYA_TMO->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_TMO);
					if ($this->TOT_BIAYA_AMBULAN->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_AMBULAN);
					if ($this->TOT_BIAYA_FISIO->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_FISIO);
					if ($this->TOT_BIAYA_LAINLAIN->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_LAINLAIN);
					if ($this->jenisperawatan_id->Exportable) $Doc->ExportCaption($this->jenisperawatan_id);
					if ($this->status_transaksi->Exportable) $Doc->ExportCaption($this->status_transaksi);
					if ($this->statuskeluarranap_id->Exportable) $Doc->ExportCaption($this->statuskeluarranap_id);
					if ($this->TOT_BIAYA_AKOMODASI->Exportable) $Doc->ExportCaption($this->TOT_BIAYA_AKOMODASI);
					if ($this->TOTAL_BIAYA_ASKEP->Exportable) $Doc->ExportCaption($this->TOTAL_BIAYA_ASKEP);
					if ($this->TOTAL_BIAYA_SIMRS->Exportable) $Doc->ExportCaption($this->TOTAL_BIAYA_SIMRS);
					if ($this->TOT_PENJ_NMEDIS->Exportable) $Doc->ExportCaption($this->TOT_PENJ_NMEDIS);
					if ($this->LINK_MASTERDETAIL->Exportable) $Doc->ExportCaption($this->LINK_MASTERDETAIL);
					if ($this->NO_SKP->Exportable) $Doc->ExportCaption($this->NO_SKP);
					if ($this->LINK_PELAYANAN_OBAT->Exportable) $Doc->ExportCaption($this->LINK_PELAYANAN_OBAT);
					if ($this->TOT_TIND_RAJAL->Exportable) $Doc->ExportCaption($this->TOT_TIND_RAJAL);
					if ($this->TOT_TIND_IGD->Exportable) $Doc->ExportCaption($this->TOT_TIND_IGD);
					if ($this->tanggal_pengembalian_status->Exportable) $Doc->ExportCaption($this->tanggal_pengembalian_status);
					if ($this->naik_kelas->Exportable) $Doc->ExportCaption($this->naik_kelas);
					if ($this->iuran_kelas_lama->Exportable) $Doc->ExportCaption($this->iuran_kelas_lama);
					if ($this->iuran_kelas_baru->Exportable) $Doc->ExportCaption($this->iuran_kelas_baru);
					if ($this->ketrangan_naik_kelas->Exportable) $Doc->ExportCaption($this->ketrangan_naik_kelas);
					if ($this->tgl_pengiriman_ad_klaim->Exportable) $Doc->ExportCaption($this->tgl_pengiriman_ad_klaim);
					if ($this->diagnosa_keluar->Exportable) $Doc->ExportCaption($this->diagnosa_keluar);
					if ($this->sep_tglsep->Exportable) $Doc->ExportCaption($this->sep_tglsep);
					if ($this->sep_tglrujuk->Exportable) $Doc->ExportCaption($this->sep_tglrujuk);
					if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportCaption($this->sep_kodekelasrawat);
					if ($this->sep_norujukan->Exportable) $Doc->ExportCaption($this->sep_norujukan);
					if ($this->sep_kodeppkasal->Exportable) $Doc->ExportCaption($this->sep_kodeppkasal);
					if ($this->sep_namappkasal->Exportable) $Doc->ExportCaption($this->sep_namappkasal);
					if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportCaption($this->sep_kodeppkpelayanan);
					if ($this->sep_namappkpelayanan->Exportable) $Doc->ExportCaption($this->sep_namappkpelayanan);
					if ($this->t_admissioncol->Exportable) $Doc->ExportCaption($this->t_admissioncol);
					if ($this->sep_jenisperawatan->Exportable) $Doc->ExportCaption($this->sep_jenisperawatan);
					if ($this->sep_catatan->Exportable) $Doc->ExportCaption($this->sep_catatan);
					if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportCaption($this->sep_kodediagnosaawal);
					if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportCaption($this->sep_namadiagnosaawal);
					if ($this->sep_lakalantas->Exportable) $Doc->ExportCaption($this->sep_lakalantas);
					if ($this->sep_lokasilaka->Exportable) $Doc->ExportCaption($this->sep_lokasilaka);
					if ($this->sep_user->Exportable) $Doc->ExportCaption($this->sep_user);
					if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportCaption($this->sep_flag_cekpeserta);
					if ($this->sep_flag_generatesep->Exportable) $Doc->ExportCaption($this->sep_flag_generatesep);
					if ($this->sep_flag_mapingsep->Exportable) $Doc->ExportCaption($this->sep_flag_mapingsep);
					if ($this->sep_nik->Exportable) $Doc->ExportCaption($this->sep_nik);
					if ($this->sep_namapeserta->Exportable) $Doc->ExportCaption($this->sep_namapeserta);
					if ($this->sep_jeniskelamin->Exportable) $Doc->ExportCaption($this->sep_jeniskelamin);
					if ($this->sep_pisat->Exportable) $Doc->ExportCaption($this->sep_pisat);
					if ($this->sep_tgllahir->Exportable) $Doc->ExportCaption($this->sep_tgllahir);
					if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_kodejeniskepesertaan);
					if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_namajeniskepesertaan);
					if ($this->sep_kodepolitujuan->Exportable) $Doc->ExportCaption($this->sep_kodepolitujuan);
					if ($this->sep_namapolitujuan->Exportable) $Doc->ExportCaption($this->sep_namapolitujuan);
					if ($this->ket_jeniskelamin->Exportable) $Doc->ExportCaption($this->ket_jeniskelamin);
					if ($this->sep_nokabpjs->Exportable) $Doc->ExportCaption($this->sep_nokabpjs);
					if ($this->counter_cetak_sep->Exportable) $Doc->ExportCaption($this->counter_cetak_sep);
					if ($this->sep_petugas_hapus_sep->Exportable) $Doc->ExportCaption($this->sep_petugas_hapus_sep);
					if ($this->sep_petugas_set_tgl_pulang->Exportable) $Doc->ExportCaption($this->sep_petugas_set_tgl_pulang);
					if ($this->sep_jam_generate_sep->Exportable) $Doc->ExportCaption($this->sep_jam_generate_sep);
					if ($this->sep_status_peserta->Exportable) $Doc->ExportCaption($this->sep_status_peserta);
					if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportCaption($this->sep_umur_pasien_sekarang);
					if ($this->ket_title->Exportable) $Doc->ExportCaption($this->ket_title);
					if ($this->status_daftar_ranap->Exportable) $Doc->ExportCaption($this->status_daftar_ranap);
					if ($this->IBS_SETMARKING->Exportable) $Doc->ExportCaption($this->IBS_SETMARKING);
					if ($this->IBS_PATOLOGI->Exportable) $Doc->ExportCaption($this->IBS_PATOLOGI);
					if ($this->IBS_JENISANESTESI->Exportable) $Doc->ExportCaption($this->IBS_JENISANESTESI);
					if ($this->IBS_NO_OK->Exportable) $Doc->ExportCaption($this->IBS_NO_OK);
					if ($this->IBS_ASISSTEN->Exportable) $Doc->ExportCaption($this->IBS_ASISSTEN);
					if ($this->IBS_JAM_ELEFTIF->Exportable) $Doc->ExportCaption($this->IBS_JAM_ELEFTIF);
					if ($this->IBS_JAM_ELEKTIF_SELESAI->Exportable) $Doc->ExportCaption($this->IBS_JAM_ELEKTIF_SELESAI);
					if ($this->IBS_JAM_CYTO->Exportable) $Doc->ExportCaption($this->IBS_JAM_CYTO);
					if ($this->IBS_JAM_CYTO_SELESAI->Exportable) $Doc->ExportCaption($this->IBS_JAM_CYTO_SELESAI);
					if ($this->IBS_TGL_DFTR_OP->Exportable) $Doc->ExportCaption($this->IBS_TGL_DFTR_OP);
					if ($this->IBS_TGL_OP->Exportable) $Doc->ExportCaption($this->IBS_TGL_OP);
					if ($this->grup_ruang_id->Exportable) $Doc->ExportCaption($this->grup_ruang_id);
					if ($this->status_order_ibs->Exportable) $Doc->ExportCaption($this->status_order_ibs);
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
						if ($this->id_admission->Exportable) $Doc->ExportField($this->id_admission);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->ket_nama->Exportable) $Doc->ExportField($this->ket_nama);
						if ($this->ket_tgllahir->Exportable) $Doc->ExportField($this->ket_tgllahir);
						if ($this->ket_alamat->Exportable) $Doc->ExportField($this->ket_alamat);
						if ($this->parent_nomr->Exportable) $Doc->ExportField($this->parent_nomr);
						if ($this->dokterpengirim->Exportable) $Doc->ExportField($this->dokterpengirim);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->kirimdari->Exportable) $Doc->ExportField($this->kirimdari);
						if ($this->keluargadekat->Exportable) $Doc->ExportField($this->keluargadekat);
						if ($this->panggungjawab->Exportable) $Doc->ExportField($this->panggungjawab);
						if ($this->masukrs->Exportable) $Doc->ExportField($this->masukrs);
						if ($this->noruang->Exportable) $Doc->ExportField($this->noruang);
						if ($this->tempat_tidur_id->Exportable) $Doc->ExportField($this->tempat_tidur_id);
						if ($this->nott->Exportable) $Doc->ExportField($this->nott);
						if ($this->deposit->Exportable) $Doc->ExportField($this->deposit);
						if ($this->keluarrs->Exportable) $Doc->ExportField($this->keluarrs);
						if ($this->icd_masuk->Exportable) $Doc->ExportField($this->icd_masuk);
						if ($this->icd_keluar->Exportable) $Doc->ExportField($this->icd_keluar);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->noruang_asal->Exportable) $Doc->ExportField($this->noruang_asal);
						if ($this->nott_asal->Exportable) $Doc->ExportField($this->nott_asal);
						if ($this->tgl_pindah->Exportable) $Doc->ExportField($this->tgl_pindah);
						if ($this->kd_rujuk->Exportable) $Doc->ExportField($this->kd_rujuk);
						if ($this->st_bayar->Exportable) $Doc->ExportField($this->st_bayar);
						if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportField($this->dokter_penanggungjawab);
						if ($this->perawat->Exportable) $Doc->ExportField($this->perawat);
						if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportField($this->KELASPERAWATAN_ID);
						if ($this->LOS->Exportable) $Doc->ExportField($this->LOS);
						if ($this->TOT_TRF_TIND_DOKTER->Exportable) $Doc->ExportField($this->TOT_TRF_TIND_DOKTER);
						if ($this->TOT_BHP_DOKTER->Exportable) $Doc->ExportField($this->TOT_BHP_DOKTER);
						if ($this->TOT_TRF_PERAWAT->Exportable) $Doc->ExportField($this->TOT_TRF_PERAWAT);
						if ($this->TOT_BHP_PERAWAT->Exportable) $Doc->ExportField($this->TOT_BHP_PERAWAT);
						if ($this->TOT_TRF_DOKTER->Exportable) $Doc->ExportField($this->TOT_TRF_DOKTER);
						if ($this->TOT_BIAYA_RAD->Exportable) $Doc->ExportField($this->TOT_BIAYA_RAD);
						if ($this->TOT_BIAYA_CDRPOLI->Exportable) $Doc->ExportField($this->TOT_BIAYA_CDRPOLI);
						if ($this->TOT_BIAYA_LAB_IGD->Exportable) $Doc->ExportField($this->TOT_BIAYA_LAB_IGD);
						if ($this->TOT_BIAYA_OKSIGEN->Exportable) $Doc->ExportField($this->TOT_BIAYA_OKSIGEN);
						if ($this->TOTAL_BIAYA_OBAT->Exportable) $Doc->ExportField($this->TOTAL_BIAYA_OBAT);
						if ($this->LINK_SET_KELAS->Exportable) $Doc->ExportField($this->LINK_SET_KELAS);
						if ($this->biaya_obat->Exportable) $Doc->ExportField($this->biaya_obat);
						if ($this->biaya_retur_obat->Exportable) $Doc->ExportField($this->biaya_retur_obat);
						if ($this->TOT_BIAYA_GIZI->Exportable) $Doc->ExportField($this->TOT_BIAYA_GIZI);
						if ($this->TOT_BIAYA_TMO->Exportable) $Doc->ExportField($this->TOT_BIAYA_TMO);
						if ($this->TOT_BIAYA_AMBULAN->Exportable) $Doc->ExportField($this->TOT_BIAYA_AMBULAN);
						if ($this->TOT_BIAYA_FISIO->Exportable) $Doc->ExportField($this->TOT_BIAYA_FISIO);
						if ($this->TOT_BIAYA_LAINLAIN->Exportable) $Doc->ExportField($this->TOT_BIAYA_LAINLAIN);
						if ($this->jenisperawatan_id->Exportable) $Doc->ExportField($this->jenisperawatan_id);
						if ($this->status_transaksi->Exportable) $Doc->ExportField($this->status_transaksi);
						if ($this->statuskeluarranap_id->Exportable) $Doc->ExportField($this->statuskeluarranap_id);
						if ($this->TOT_BIAYA_AKOMODASI->Exportable) $Doc->ExportField($this->TOT_BIAYA_AKOMODASI);
						if ($this->TOTAL_BIAYA_ASKEP->Exportable) $Doc->ExportField($this->TOTAL_BIAYA_ASKEP);
						if ($this->TOTAL_BIAYA_SIMRS->Exportable) $Doc->ExportField($this->TOTAL_BIAYA_SIMRS);
						if ($this->TOT_PENJ_NMEDIS->Exportable) $Doc->ExportField($this->TOT_PENJ_NMEDIS);
						if ($this->LINK_MASTERDETAIL->Exportable) $Doc->ExportField($this->LINK_MASTERDETAIL);
						if ($this->NO_SKP->Exportable) $Doc->ExportField($this->NO_SKP);
						if ($this->LINK_PELAYANAN_OBAT->Exportable) $Doc->ExportField($this->LINK_PELAYANAN_OBAT);
						if ($this->TOT_TIND_RAJAL->Exportable) $Doc->ExportField($this->TOT_TIND_RAJAL);
						if ($this->TOT_TIND_IGD->Exportable) $Doc->ExportField($this->TOT_TIND_IGD);
						if ($this->tanggal_pengembalian_status->Exportable) $Doc->ExportField($this->tanggal_pengembalian_status);
						if ($this->naik_kelas->Exportable) $Doc->ExportField($this->naik_kelas);
						if ($this->iuran_kelas_lama->Exportable) $Doc->ExportField($this->iuran_kelas_lama);
						if ($this->iuran_kelas_baru->Exportable) $Doc->ExportField($this->iuran_kelas_baru);
						if ($this->ketrangan_naik_kelas->Exportable) $Doc->ExportField($this->ketrangan_naik_kelas);
						if ($this->tgl_pengiriman_ad_klaim->Exportable) $Doc->ExportField($this->tgl_pengiriman_ad_klaim);
						if ($this->diagnosa_keluar->Exportable) $Doc->ExportField($this->diagnosa_keluar);
						if ($this->sep_tglsep->Exportable) $Doc->ExportField($this->sep_tglsep);
						if ($this->sep_tglrujuk->Exportable) $Doc->ExportField($this->sep_tglrujuk);
						if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportField($this->sep_kodekelasrawat);
						if ($this->sep_norujukan->Exportable) $Doc->ExportField($this->sep_norujukan);
						if ($this->sep_kodeppkasal->Exportable) $Doc->ExportField($this->sep_kodeppkasal);
						if ($this->sep_namappkasal->Exportable) $Doc->ExportField($this->sep_namappkasal);
						if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportField($this->sep_kodeppkpelayanan);
						if ($this->sep_namappkpelayanan->Exportable) $Doc->ExportField($this->sep_namappkpelayanan);
						if ($this->t_admissioncol->Exportable) $Doc->ExportField($this->t_admissioncol);
						if ($this->sep_jenisperawatan->Exportable) $Doc->ExportField($this->sep_jenisperawatan);
						if ($this->sep_catatan->Exportable) $Doc->ExportField($this->sep_catatan);
						if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportField($this->sep_kodediagnosaawal);
						if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportField($this->sep_namadiagnosaawal);
						if ($this->sep_lakalantas->Exportable) $Doc->ExportField($this->sep_lakalantas);
						if ($this->sep_lokasilaka->Exportable) $Doc->ExportField($this->sep_lokasilaka);
						if ($this->sep_user->Exportable) $Doc->ExportField($this->sep_user);
						if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportField($this->sep_flag_cekpeserta);
						if ($this->sep_flag_generatesep->Exportable) $Doc->ExportField($this->sep_flag_generatesep);
						if ($this->sep_flag_mapingsep->Exportable) $Doc->ExportField($this->sep_flag_mapingsep);
						if ($this->sep_nik->Exportable) $Doc->ExportField($this->sep_nik);
						if ($this->sep_namapeserta->Exportable) $Doc->ExportField($this->sep_namapeserta);
						if ($this->sep_jeniskelamin->Exportable) $Doc->ExportField($this->sep_jeniskelamin);
						if ($this->sep_pisat->Exportable) $Doc->ExportField($this->sep_pisat);
						if ($this->sep_tgllahir->Exportable) $Doc->ExportField($this->sep_tgllahir);
						if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportField($this->sep_kodejeniskepesertaan);
						if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportField($this->sep_namajeniskepesertaan);
						if ($this->sep_kodepolitujuan->Exportable) $Doc->ExportField($this->sep_kodepolitujuan);
						if ($this->sep_namapolitujuan->Exportable) $Doc->ExportField($this->sep_namapolitujuan);
						if ($this->ket_jeniskelamin->Exportable) $Doc->ExportField($this->ket_jeniskelamin);
						if ($this->sep_nokabpjs->Exportable) $Doc->ExportField($this->sep_nokabpjs);
						if ($this->counter_cetak_sep->Exportable) $Doc->ExportField($this->counter_cetak_sep);
						if ($this->sep_petugas_hapus_sep->Exportable) $Doc->ExportField($this->sep_petugas_hapus_sep);
						if ($this->sep_petugas_set_tgl_pulang->Exportable) $Doc->ExportField($this->sep_petugas_set_tgl_pulang);
						if ($this->sep_jam_generate_sep->Exportable) $Doc->ExportField($this->sep_jam_generate_sep);
						if ($this->sep_status_peserta->Exportable) $Doc->ExportField($this->sep_status_peserta);
						if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportField($this->sep_umur_pasien_sekarang);
						if ($this->ket_title->Exportable) $Doc->ExportField($this->ket_title);
						if ($this->status_daftar_ranap->Exportable) $Doc->ExportField($this->status_daftar_ranap);
						if ($this->IBS_SETMARKING->Exportable) $Doc->ExportField($this->IBS_SETMARKING);
						if ($this->IBS_PATOLOGI->Exportable) $Doc->ExportField($this->IBS_PATOLOGI);
						if ($this->IBS_JENISANESTESI->Exportable) $Doc->ExportField($this->IBS_JENISANESTESI);
						if ($this->IBS_NO_OK->Exportable) $Doc->ExportField($this->IBS_NO_OK);
						if ($this->IBS_ASISSTEN->Exportable) $Doc->ExportField($this->IBS_ASISSTEN);
						if ($this->IBS_JAM_ELEFTIF->Exportable) $Doc->ExportField($this->IBS_JAM_ELEFTIF);
						if ($this->IBS_JAM_ELEKTIF_SELESAI->Exportable) $Doc->ExportField($this->IBS_JAM_ELEKTIF_SELESAI);
						if ($this->IBS_JAM_CYTO->Exportable) $Doc->ExportField($this->IBS_JAM_CYTO);
						if ($this->IBS_JAM_CYTO_SELESAI->Exportable) $Doc->ExportField($this->IBS_JAM_CYTO_SELESAI);
						if ($this->IBS_TGL_DFTR_OP->Exportable) $Doc->ExportField($this->IBS_TGL_DFTR_OP);
						if ($this->IBS_TGL_OP->Exportable) $Doc->ExportField($this->IBS_TGL_OP);
						if ($this->grup_ruang_id->Exportable) $Doc->ExportField($this->grup_ruang_id);
						if ($this->status_order_ibs->Exportable) $Doc->ExportField($this->status_order_ibs);
					} else {
						if ($this->id_admission->Exportable) $Doc->ExportField($this->id_admission);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->ket_nama->Exportable) $Doc->ExportField($this->ket_nama);
						if ($this->ket_tgllahir->Exportable) $Doc->ExportField($this->ket_tgllahir);
						if ($this->ket_alamat->Exportable) $Doc->ExportField($this->ket_alamat);
						if ($this->parent_nomr->Exportable) $Doc->ExportField($this->parent_nomr);
						if ($this->dokterpengirim->Exportable) $Doc->ExportField($this->dokterpengirim);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->kirimdari->Exportable) $Doc->ExportField($this->kirimdari);
						if ($this->keluargadekat->Exportable) $Doc->ExportField($this->keluargadekat);
						if ($this->panggungjawab->Exportable) $Doc->ExportField($this->panggungjawab);
						if ($this->masukrs->Exportable) $Doc->ExportField($this->masukrs);
						if ($this->noruang->Exportable) $Doc->ExportField($this->noruang);
						if ($this->tempat_tidur_id->Exportable) $Doc->ExportField($this->tempat_tidur_id);
						if ($this->nott->Exportable) $Doc->ExportField($this->nott);
						if ($this->deposit->Exportable) $Doc->ExportField($this->deposit);
						if ($this->keluarrs->Exportable) $Doc->ExportField($this->keluarrs);
						if ($this->icd_masuk->Exportable) $Doc->ExportField($this->icd_masuk);
						if ($this->icd_keluar->Exportable) $Doc->ExportField($this->icd_keluar);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->noruang_asal->Exportable) $Doc->ExportField($this->noruang_asal);
						if ($this->nott_asal->Exportable) $Doc->ExportField($this->nott_asal);
						if ($this->tgl_pindah->Exportable) $Doc->ExportField($this->tgl_pindah);
						if ($this->kd_rujuk->Exportable) $Doc->ExportField($this->kd_rujuk);
						if ($this->st_bayar->Exportable) $Doc->ExportField($this->st_bayar);
						if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportField($this->dokter_penanggungjawab);
						if ($this->perawat->Exportable) $Doc->ExportField($this->perawat);
						if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportField($this->KELASPERAWATAN_ID);
						if ($this->LOS->Exportable) $Doc->ExportField($this->LOS);
						if ($this->TOT_TRF_TIND_DOKTER->Exportable) $Doc->ExportField($this->TOT_TRF_TIND_DOKTER);
						if ($this->TOT_BHP_DOKTER->Exportable) $Doc->ExportField($this->TOT_BHP_DOKTER);
						if ($this->TOT_TRF_PERAWAT->Exportable) $Doc->ExportField($this->TOT_TRF_PERAWAT);
						if ($this->TOT_BHP_PERAWAT->Exportable) $Doc->ExportField($this->TOT_BHP_PERAWAT);
						if ($this->TOT_TRF_DOKTER->Exportable) $Doc->ExportField($this->TOT_TRF_DOKTER);
						if ($this->TOT_BIAYA_RAD->Exportable) $Doc->ExportField($this->TOT_BIAYA_RAD);
						if ($this->TOT_BIAYA_CDRPOLI->Exportable) $Doc->ExportField($this->TOT_BIAYA_CDRPOLI);
						if ($this->TOT_BIAYA_LAB_IGD->Exportable) $Doc->ExportField($this->TOT_BIAYA_LAB_IGD);
						if ($this->TOT_BIAYA_OKSIGEN->Exportable) $Doc->ExportField($this->TOT_BIAYA_OKSIGEN);
						if ($this->TOTAL_BIAYA_OBAT->Exportable) $Doc->ExportField($this->TOTAL_BIAYA_OBAT);
						if ($this->LINK_SET_KELAS->Exportable) $Doc->ExportField($this->LINK_SET_KELAS);
						if ($this->biaya_obat->Exportable) $Doc->ExportField($this->biaya_obat);
						if ($this->biaya_retur_obat->Exportable) $Doc->ExportField($this->biaya_retur_obat);
						if ($this->TOT_BIAYA_GIZI->Exportable) $Doc->ExportField($this->TOT_BIAYA_GIZI);
						if ($this->TOT_BIAYA_TMO->Exportable) $Doc->ExportField($this->TOT_BIAYA_TMO);
						if ($this->TOT_BIAYA_AMBULAN->Exportable) $Doc->ExportField($this->TOT_BIAYA_AMBULAN);
						if ($this->TOT_BIAYA_FISIO->Exportable) $Doc->ExportField($this->TOT_BIAYA_FISIO);
						if ($this->TOT_BIAYA_LAINLAIN->Exportable) $Doc->ExportField($this->TOT_BIAYA_LAINLAIN);
						if ($this->jenisperawatan_id->Exportable) $Doc->ExportField($this->jenisperawatan_id);
						if ($this->status_transaksi->Exportable) $Doc->ExportField($this->status_transaksi);
						if ($this->statuskeluarranap_id->Exportable) $Doc->ExportField($this->statuskeluarranap_id);
						if ($this->TOT_BIAYA_AKOMODASI->Exportable) $Doc->ExportField($this->TOT_BIAYA_AKOMODASI);
						if ($this->TOTAL_BIAYA_ASKEP->Exportable) $Doc->ExportField($this->TOTAL_BIAYA_ASKEP);
						if ($this->TOTAL_BIAYA_SIMRS->Exportable) $Doc->ExportField($this->TOTAL_BIAYA_SIMRS);
						if ($this->TOT_PENJ_NMEDIS->Exportable) $Doc->ExportField($this->TOT_PENJ_NMEDIS);
						if ($this->LINK_MASTERDETAIL->Exportable) $Doc->ExportField($this->LINK_MASTERDETAIL);
						if ($this->NO_SKP->Exportable) $Doc->ExportField($this->NO_SKP);
						if ($this->LINK_PELAYANAN_OBAT->Exportable) $Doc->ExportField($this->LINK_PELAYANAN_OBAT);
						if ($this->TOT_TIND_RAJAL->Exportable) $Doc->ExportField($this->TOT_TIND_RAJAL);
						if ($this->TOT_TIND_IGD->Exportable) $Doc->ExportField($this->TOT_TIND_IGD);
						if ($this->tanggal_pengembalian_status->Exportable) $Doc->ExportField($this->tanggal_pengembalian_status);
						if ($this->naik_kelas->Exportable) $Doc->ExportField($this->naik_kelas);
						if ($this->iuran_kelas_lama->Exportable) $Doc->ExportField($this->iuran_kelas_lama);
						if ($this->iuran_kelas_baru->Exportable) $Doc->ExportField($this->iuran_kelas_baru);
						if ($this->ketrangan_naik_kelas->Exportable) $Doc->ExportField($this->ketrangan_naik_kelas);
						if ($this->tgl_pengiriman_ad_klaim->Exportable) $Doc->ExportField($this->tgl_pengiriman_ad_klaim);
						if ($this->diagnosa_keluar->Exportable) $Doc->ExportField($this->diagnosa_keluar);
						if ($this->sep_tglsep->Exportable) $Doc->ExportField($this->sep_tglsep);
						if ($this->sep_tglrujuk->Exportable) $Doc->ExportField($this->sep_tglrujuk);
						if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportField($this->sep_kodekelasrawat);
						if ($this->sep_norujukan->Exportable) $Doc->ExportField($this->sep_norujukan);
						if ($this->sep_kodeppkasal->Exportable) $Doc->ExportField($this->sep_kodeppkasal);
						if ($this->sep_namappkasal->Exportable) $Doc->ExportField($this->sep_namappkasal);
						if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportField($this->sep_kodeppkpelayanan);
						if ($this->sep_namappkpelayanan->Exportable) $Doc->ExportField($this->sep_namappkpelayanan);
						if ($this->t_admissioncol->Exportable) $Doc->ExportField($this->t_admissioncol);
						if ($this->sep_jenisperawatan->Exportable) $Doc->ExportField($this->sep_jenisperawatan);
						if ($this->sep_catatan->Exportable) $Doc->ExportField($this->sep_catatan);
						if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportField($this->sep_kodediagnosaawal);
						if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportField($this->sep_namadiagnosaawal);
						if ($this->sep_lakalantas->Exportable) $Doc->ExportField($this->sep_lakalantas);
						if ($this->sep_lokasilaka->Exportable) $Doc->ExportField($this->sep_lokasilaka);
						if ($this->sep_user->Exportable) $Doc->ExportField($this->sep_user);
						if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportField($this->sep_flag_cekpeserta);
						if ($this->sep_flag_generatesep->Exportable) $Doc->ExportField($this->sep_flag_generatesep);
						if ($this->sep_flag_mapingsep->Exportable) $Doc->ExportField($this->sep_flag_mapingsep);
						if ($this->sep_nik->Exportable) $Doc->ExportField($this->sep_nik);
						if ($this->sep_namapeserta->Exportable) $Doc->ExportField($this->sep_namapeserta);
						if ($this->sep_jeniskelamin->Exportable) $Doc->ExportField($this->sep_jeniskelamin);
						if ($this->sep_pisat->Exportable) $Doc->ExportField($this->sep_pisat);
						if ($this->sep_tgllahir->Exportable) $Doc->ExportField($this->sep_tgllahir);
						if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportField($this->sep_kodejeniskepesertaan);
						if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportField($this->sep_namajeniskepesertaan);
						if ($this->sep_kodepolitujuan->Exportable) $Doc->ExportField($this->sep_kodepolitujuan);
						if ($this->sep_namapolitujuan->Exportable) $Doc->ExportField($this->sep_namapolitujuan);
						if ($this->ket_jeniskelamin->Exportable) $Doc->ExportField($this->ket_jeniskelamin);
						if ($this->sep_nokabpjs->Exportable) $Doc->ExportField($this->sep_nokabpjs);
						if ($this->counter_cetak_sep->Exportable) $Doc->ExportField($this->counter_cetak_sep);
						if ($this->sep_petugas_hapus_sep->Exportable) $Doc->ExportField($this->sep_petugas_hapus_sep);
						if ($this->sep_petugas_set_tgl_pulang->Exportable) $Doc->ExportField($this->sep_petugas_set_tgl_pulang);
						if ($this->sep_jam_generate_sep->Exportable) $Doc->ExportField($this->sep_jam_generate_sep);
						if ($this->sep_status_peserta->Exportable) $Doc->ExportField($this->sep_status_peserta);
						if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportField($this->sep_umur_pasien_sekarang);
						if ($this->ket_title->Exportable) $Doc->ExportField($this->ket_title);
						if ($this->status_daftar_ranap->Exportable) $Doc->ExportField($this->status_daftar_ranap);
						if ($this->IBS_SETMARKING->Exportable) $Doc->ExportField($this->IBS_SETMARKING);
						if ($this->IBS_PATOLOGI->Exportable) $Doc->ExportField($this->IBS_PATOLOGI);
						if ($this->IBS_JENISANESTESI->Exportable) $Doc->ExportField($this->IBS_JENISANESTESI);
						if ($this->IBS_NO_OK->Exportable) $Doc->ExportField($this->IBS_NO_OK);
						if ($this->IBS_ASISSTEN->Exportable) $Doc->ExportField($this->IBS_ASISSTEN);
						if ($this->IBS_JAM_ELEFTIF->Exportable) $Doc->ExportField($this->IBS_JAM_ELEFTIF);
						if ($this->IBS_JAM_ELEKTIF_SELESAI->Exportable) $Doc->ExportField($this->IBS_JAM_ELEKTIF_SELESAI);
						if ($this->IBS_JAM_CYTO->Exportable) $Doc->ExportField($this->IBS_JAM_CYTO);
						if ($this->IBS_JAM_CYTO_SELESAI->Exportable) $Doc->ExportField($this->IBS_JAM_CYTO_SELESAI);
						if ($this->IBS_TGL_DFTR_OP->Exportable) $Doc->ExportField($this->IBS_TGL_DFTR_OP);
						if ($this->IBS_TGL_OP->Exportable) $Doc->ExportField($this->IBS_TGL_OP);
						if ($this->grup_ruang_id->Exportable) $Doc->ExportField($this->grup_ruang_id);
						if ($this->status_order_ibs->Exportable) $Doc->ExportField($this->status_order_ibs);
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
		if (preg_match('/^x(\d)*_tempat_tidur_id$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `no_tt` AS FIELD0 FROM `m_detail_tempat_tidur`";
			$sWhereWrk = "(`id` = " . ew_QuotedValue($val, EW_DATATYPE_NUMBER, $this->DBID) . ")";
			$this->tempat_tidur_id->LookupFilters = array();
			$lookuptblfilter = "isnull(`KETERANGAN`)";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$this->Lookup_Selecting($this->tempat_tidur_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->nott->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->nott->AutoFillOriginalValue) ? $this->nott->CurrentValue : $this->nott->EditValue;
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 't_admission';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 't_admission';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id_admission'];

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
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 't_admission';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id_admission'];

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
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 't_admission';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['id_admission'];

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

		$session = CurrentUserName();
		if(!isset($session)){
			header('Location: logout.php');
		}else
		{
			$data_pendaftaran = ew_ExecuteRow("SELECT * FROM simrs2012.t_pendaftaran where IDXDAFTAR = '".$this->id_admission->CurrentValue."' LIMIT 1");
			$data_pasien = ew_ExecuteRow("SELECT NOMR,TITLE,NAMA,ALAMAT,JENISKELAMIN,TGLLAHIR FROM simrs2012.m_pasien WHERE NOMR = '".$data_pendaftaran["NOMR"]."' LIMIT 1");
			$this->NIP->EditValue = CurrentUserName();
			$this->NIP->ReadOnly = TRUE;
			$this->ket_nama->ReadOnly = TRUE;
			$this->ket_nama->EditValue = $data_pasien["NAMA"];
			$this->ket_tgllahir->ReadOnly = TRUE;
			$this->ket_tgllahir->EditValue = $data_pasien["TGLLAHIR"];
			$this->ket_alamat->ReadOnly = TRUE;
			$this->ket_alamat->EditValue = $data_pasien["ALAMAT"];
			$this->ket_title->ReadOnly = TRUE;
			$this->ket_title->EditValue = $data_pasien["TITLE"];
			$this->ket_jeniskelamin->ReadOnly = TRUE;
			$this->ket_jeniskelamin->EditValue = $data_pasien["JENISKELAMIN"];
			$this->keluargadekat->EditValue = $data_pendaftaran["PENANGGUNGJAWAB_HUBUNGAN"];
			$this->panggungjawab->EditValue = $data_pendaftaran["PENANGGUNGJAWAB_NAMA"];
			$this->nomr->ReadOnly = TRUE;
			$this->nott->ReadOnly = TRUE;
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
