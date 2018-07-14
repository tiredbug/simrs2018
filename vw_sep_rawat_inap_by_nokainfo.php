<?php

// Global variable for table object
$vw_sep_rawat_inap_by_noka = NULL;

//
// Table class for vw_sep_rawat_inap_by_noka
//
class cvw_sep_rawat_inap_by_noka extends cTable {
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
	var $ket_jeniskelamin;
	var $ket_title;
	var $dokterpengirim;
	var $statusbayar;
	var $kirimdari;
	var $keluargadekat;
	var $panggungjawab;
	var $masukrs;
	var $noruang;
	var $tempat_tidur_id;
	var $nott;
	var $NIP;
	var $dokter_penanggungjawab;
	var $KELASPERAWATAN_ID;
	var $NO_SKP;
	var $sep_tglsep;
	var $sep_tglrujuk;
	var $sep_kodekelasrawat;
	var $sep_norujukan;
	var $sep_kodeppkasal;
	var $sep_namappkasal;
	var $sep_kodeppkpelayanan;
	var $sep_jenisperawatan;
	var $sep_catatan;
	var $sep_kodediagnosaawal;
	var $sep_namadiagnosaawal;
	var $sep_lakalantas;
	var $sep_lokasilaka;
	var $sep_user;
	var $sep_flag_cekpeserta;
	var $sep_flag_generatesep;
	var $sep_nik;
	var $sep_namapeserta;
	var $sep_jeniskelamin;
	var $sep_pisat;
	var $sep_tgllahir;
	var $sep_kodejeniskepesertaan;
	var $sep_namajeniskepesertaan;
	var $sep_nokabpjs;
	var $sep_status_peserta;
	var $sep_umur_pasien_sekarang;
	var $statuskeluarranap_id;
	var $keluarrs;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_sep_rawat_inap_by_noka';
		$this->TableName = 'vw_sep_rawat_inap_by_noka';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_sep_rawat_inap_by_noka`";
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
		$this->id_admission = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_id_admission', 'id_admission', '`id_admission`', '`id_admission`', 3, -1, FALSE, '`id_admission`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->id_admission->Sortable = TRUE; // Allow sort
		$this->id_admission->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id_admission'] = &$this->id_admission;

		// nomr
		$this->nomr = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_nomr', 'nomr', '`nomr`', '`nomr`', 200, -1, FALSE, '`nomr`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nomr->Sortable = TRUE; // Allow sort
		$this->fields['nomr'] = &$this->nomr;

		// ket_nama
		$this->ket_nama = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_ket_nama', 'ket_nama', '`ket_nama`', '`ket_nama`', 200, -1, FALSE, '`ket_nama`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_nama->Sortable = TRUE; // Allow sort
		$this->fields['ket_nama'] = &$this->ket_nama;

		// ket_tgllahir
		$this->ket_tgllahir = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_ket_tgllahir', 'ket_tgllahir', '`ket_tgllahir`', ew_CastDateFieldForLike('`ket_tgllahir`', 0, "DB"), 135, 0, FALSE, '`ket_tgllahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_tgllahir->Sortable = TRUE; // Allow sort
		$this->ket_tgllahir->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['ket_tgllahir'] = &$this->ket_tgllahir;

		// ket_alamat
		$this->ket_alamat = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_ket_alamat', 'ket_alamat', '`ket_alamat`', '`ket_alamat`', 200, -1, FALSE, '`ket_alamat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_alamat->Sortable = TRUE; // Allow sort
		$this->fields['ket_alamat'] = &$this->ket_alamat;

		// ket_jeniskelamin
		$this->ket_jeniskelamin = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_ket_jeniskelamin', 'ket_jeniskelamin', '`ket_jeniskelamin`', '`ket_jeniskelamin`', 200, -1, FALSE, '`ket_jeniskelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_jeniskelamin->Sortable = TRUE; // Allow sort
		$this->fields['ket_jeniskelamin'] = &$this->ket_jeniskelamin;

		// ket_title
		$this->ket_title = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_ket_title', 'ket_title', '`ket_title`', '`ket_title`', 200, -1, FALSE, '`ket_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ket_title->Sortable = TRUE; // Allow sort
		$this->fields['ket_title'] = &$this->ket_title;

		// dokterpengirim
		$this->dokterpengirim = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_dokterpengirim', 'dokterpengirim', '`dokterpengirim`', '`dokterpengirim`', 3, -1, FALSE, '`dokterpengirim`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dokterpengirim->Sortable = TRUE; // Allow sort
		$this->dokterpengirim->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dokterpengirim'] = &$this->dokterpengirim;

		// statusbayar
		$this->statusbayar = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_statusbayar', 'statusbayar', '`statusbayar`', '`statusbayar`', 3, -1, FALSE, '`statusbayar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->statusbayar->Sortable = TRUE; // Allow sort
		$this->statusbayar->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statusbayar'] = &$this->statusbayar;

		// kirimdari
		$this->kirimdari = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_kirimdari', 'kirimdari', '`kirimdari`', '`kirimdari`', 3, -1, FALSE, '`kirimdari`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->kirimdari->Sortable = TRUE; // Allow sort
		$this->kirimdari->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['kirimdari'] = &$this->kirimdari;

		// keluargadekat
		$this->keluargadekat = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_keluargadekat', 'keluargadekat', '`keluargadekat`', '`keluargadekat`', 200, -1, FALSE, '`keluargadekat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keluargadekat->Sortable = TRUE; // Allow sort
		$this->fields['keluargadekat'] = &$this->keluargadekat;

		// panggungjawab
		$this->panggungjawab = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_panggungjawab', 'panggungjawab', '`panggungjawab`', '`panggungjawab`', 200, -1, FALSE, '`panggungjawab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->panggungjawab->Sortable = TRUE; // Allow sort
		$this->fields['panggungjawab'] = &$this->panggungjawab;

		// masukrs
		$this->masukrs = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_masukrs', 'masukrs', '`masukrs`', ew_CastDateFieldForLike('`masukrs`', 0, "DB"), 135, 0, FALSE, '`masukrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->masukrs->Sortable = TRUE; // Allow sort
		$this->masukrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['masukrs'] = &$this->masukrs;

		// noruang
		$this->noruang = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_noruang', 'noruang', '`noruang`', '`noruang`', 3, -1, FALSE, '`noruang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->noruang->Sortable = TRUE; // Allow sort
		$this->noruang->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['noruang'] = &$this->noruang;

		// tempat_tidur_id
		$this->tempat_tidur_id = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_tempat_tidur_id', 'tempat_tidur_id', '`tempat_tidur_id`', '`tempat_tidur_id`', 3, -1, FALSE, '`tempat_tidur_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tempat_tidur_id->Sortable = TRUE; // Allow sort
		$this->tempat_tidur_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tempat_tidur_id'] = &$this->tempat_tidur_id;

		// nott
		$this->nott = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_nott', 'nott', '`nott`', '`nott`', 200, -1, FALSE, '`nott`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nott->Sortable = TRUE; // Allow sort
		$this->fields['nott'] = &$this->nott;

		// NIP
		$this->NIP = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = TRUE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_dokter_penanggungjawab', 'dokter_penanggungjawab', '`dokter_penanggungjawab`', '`dokter_penanggungjawab`', 3, -1, FALSE, '`dokter_penanggungjawab`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dokter_penanggungjawab->Sortable = TRUE; // Allow sort
		$this->dokter_penanggungjawab->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['dokter_penanggungjawab'] = &$this->dokter_penanggungjawab;

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_KELASPERAWATAN_ID', 'KELASPERAWATAN_ID', '`KELASPERAWATAN_ID`', '`KELASPERAWATAN_ID`', 3, -1, FALSE, '`KELASPERAWATAN_ID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELASPERAWATAN_ID->Sortable = TRUE; // Allow sort
		$this->KELASPERAWATAN_ID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KELASPERAWATAN_ID'] = &$this->KELASPERAWATAN_ID;

		// NO_SKP
		$this->NO_SKP = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_NO_SKP', 'NO_SKP', '`NO_SKP`', '`NO_SKP`', 200, -1, FALSE, '`NO_SKP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SKP->Sortable = TRUE; // Allow sort
		$this->fields['NO_SKP'] = &$this->NO_SKP;

		// sep_tglsep
		$this->sep_tglsep = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_tglsep', 'sep_tglsep', '`sep_tglsep`', ew_CastDateFieldForLike('`sep_tglsep`', 5, "DB"), 135, 5, FALSE, '`sep_tglsep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_tglsep->Sortable = TRUE; // Allow sort
		$this->sep_tglsep->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateYMD"));
		$this->fields['sep_tglsep'] = &$this->sep_tglsep;

		// sep_tglrujuk
		$this->sep_tglrujuk = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_tglrujuk', 'sep_tglrujuk', '`sep_tglrujuk`', ew_CastDateFieldForLike('`sep_tglrujuk`', 5, "DB"), 135, 5, FALSE, '`sep_tglrujuk`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_tglrujuk->Sortable = TRUE; // Allow sort
		$this->sep_tglrujuk->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateYMD"));
		$this->fields['sep_tglrujuk'] = &$this->sep_tglrujuk;

		// sep_kodekelasrawat
		$this->sep_kodekelasrawat = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_kodekelasrawat', 'sep_kodekelasrawat', '`sep_kodekelasrawat`', '`sep_kodekelasrawat`', 200, -1, FALSE, '`sep_kodekelasrawat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodekelasrawat->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodekelasrawat'] = &$this->sep_kodekelasrawat;

		// sep_norujukan
		$this->sep_norujukan = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_norujukan', 'sep_norujukan', '`sep_norujukan`', '`sep_norujukan`', 200, -1, FALSE, '`sep_norujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_norujukan->Sortable = TRUE; // Allow sort
		$this->fields['sep_norujukan'] = &$this->sep_norujukan;

		// sep_kodeppkasal
		$this->sep_kodeppkasal = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_kodeppkasal', 'sep_kodeppkasal', '`sep_kodeppkasal`', '`sep_kodeppkasal`', 200, -1, FALSE, '`sep_kodeppkasal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodeppkasal->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodeppkasal'] = &$this->sep_kodeppkasal;

		// sep_namappkasal
		$this->sep_namappkasal = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_namappkasal', 'sep_namappkasal', '`sep_namappkasal`', '`sep_namappkasal`', 200, -1, FALSE, '`sep_namappkasal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namappkasal->Sortable = TRUE; // Allow sort
		$this->fields['sep_namappkasal'] = &$this->sep_namappkasal;

		// sep_kodeppkpelayanan
		$this->sep_kodeppkpelayanan = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_kodeppkpelayanan', 'sep_kodeppkpelayanan', '`sep_kodeppkpelayanan`', '`sep_kodeppkpelayanan`', 200, -1, FALSE, '`sep_kodeppkpelayanan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodeppkpelayanan->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodeppkpelayanan'] = &$this->sep_kodeppkpelayanan;

		// sep_jenisperawatan
		$this->sep_jenisperawatan = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_jenisperawatan', 'sep_jenisperawatan', '`sep_jenisperawatan`', '`sep_jenisperawatan`', 3, -1, FALSE, '`sep_jenisperawatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_jenisperawatan->Sortable = TRUE; // Allow sort
		$this->sep_jenisperawatan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_jenisperawatan'] = &$this->sep_jenisperawatan;

		// sep_catatan
		$this->sep_catatan = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_catatan', 'sep_catatan', '`sep_catatan`', '`sep_catatan`', 200, -1, FALSE, '`sep_catatan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_catatan->Sortable = TRUE; // Allow sort
		$this->fields['sep_catatan'] = &$this->sep_catatan;

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_kodediagnosaawal', 'sep_kodediagnosaawal', '`sep_kodediagnosaawal`', '`sep_kodediagnosaawal`', 200, -1, FALSE, '`sep_kodediagnosaawal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodediagnosaawal->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodediagnosaawal'] = &$this->sep_kodediagnosaawal;

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_namadiagnosaawal', 'sep_namadiagnosaawal', '`sep_namadiagnosaawal`', '`sep_namadiagnosaawal`', 200, -1, FALSE, '`sep_namadiagnosaawal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namadiagnosaawal->Sortable = TRUE; // Allow sort
		$this->fields['sep_namadiagnosaawal'] = &$this->sep_namadiagnosaawal;

		// sep_lakalantas
		$this->sep_lakalantas = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_lakalantas', 'sep_lakalantas', '`sep_lakalantas`', '`sep_lakalantas`', 3, -1, FALSE, '`sep_lakalantas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->sep_lakalantas->Sortable = TRUE; // Allow sort
		$this->sep_lakalantas->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_lakalantas'] = &$this->sep_lakalantas;

		// sep_lokasilaka
		$this->sep_lokasilaka = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_lokasilaka', 'sep_lokasilaka', '`sep_lokasilaka`', '`sep_lokasilaka`', 200, -1, FALSE, '`sep_lokasilaka`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_lokasilaka->Sortable = TRUE; // Allow sort
		$this->fields['sep_lokasilaka'] = &$this->sep_lokasilaka;

		// sep_user
		$this->sep_user = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_user', 'sep_user', '`sep_user`', '`sep_user`', 200, -1, FALSE, '`sep_user`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_user->Sortable = TRUE; // Allow sort
		$this->fields['sep_user'] = &$this->sep_user;

		// sep_flag_cekpeserta
		$this->sep_flag_cekpeserta = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_flag_cekpeserta', 'sep_flag_cekpeserta', '`sep_flag_cekpeserta`', '`sep_flag_cekpeserta`', 3, -1, FALSE, '`sep_flag_cekpeserta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->sep_flag_cekpeserta->Sortable = TRUE; // Allow sort
		$this->sep_flag_cekpeserta->OptionCount = 1;
		$this->sep_flag_cekpeserta->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_flag_cekpeserta'] = &$this->sep_flag_cekpeserta;

		// sep_flag_generatesep
		$this->sep_flag_generatesep = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_flag_generatesep', 'sep_flag_generatesep', '`sep_flag_generatesep`', '`sep_flag_generatesep`', 3, -1, FALSE, '`sep_flag_generatesep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->sep_flag_generatesep->Sortable = TRUE; // Allow sort
		$this->sep_flag_generatesep->OptionCount = 1;
		$this->sep_flag_generatesep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sep_flag_generatesep'] = &$this->sep_flag_generatesep;

		// sep_nik
		$this->sep_nik = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_nik', 'sep_nik', '`sep_nik`', '`sep_nik`', 200, -1, FALSE, '`sep_nik`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_nik->Sortable = TRUE; // Allow sort
		$this->fields['sep_nik'] = &$this->sep_nik;

		// sep_namapeserta
		$this->sep_namapeserta = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_namapeserta', 'sep_namapeserta', '`sep_namapeserta`', '`sep_namapeserta`', 200, -1, FALSE, '`sep_namapeserta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namapeserta->Sortable = TRUE; // Allow sort
		$this->fields['sep_namapeserta'] = &$this->sep_namapeserta;

		// sep_jeniskelamin
		$this->sep_jeniskelamin = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_jeniskelamin', 'sep_jeniskelamin', '`sep_jeniskelamin`', '`sep_jeniskelamin`', 200, -1, FALSE, '`sep_jeniskelamin`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_jeniskelamin->Sortable = TRUE; // Allow sort
		$this->fields['sep_jeniskelamin'] = &$this->sep_jeniskelamin;

		// sep_pisat
		$this->sep_pisat = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_pisat', 'sep_pisat', '`sep_pisat`', '`sep_pisat`', 200, -1, FALSE, '`sep_pisat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_pisat->Sortable = TRUE; // Allow sort
		$this->fields['sep_pisat'] = &$this->sep_pisat;

		// sep_tgllahir
		$this->sep_tgllahir = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_tgllahir', 'sep_tgllahir', '`sep_tgllahir`', '`sep_tgllahir`', 200, -1, FALSE, '`sep_tgllahir`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_tgllahir->Sortable = TRUE; // Allow sort
		$this->fields['sep_tgllahir'] = &$this->sep_tgllahir;

		// sep_kodejeniskepesertaan
		$this->sep_kodejeniskepesertaan = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_kodejeniskepesertaan', 'sep_kodejeniskepesertaan', '`sep_kodejeniskepesertaan`', '`sep_kodejeniskepesertaan`', 200, -1, FALSE, '`sep_kodejeniskepesertaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_kodejeniskepesertaan->Sortable = TRUE; // Allow sort
		$this->fields['sep_kodejeniskepesertaan'] = &$this->sep_kodejeniskepesertaan;

		// sep_namajeniskepesertaan
		$this->sep_namajeniskepesertaan = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_namajeniskepesertaan', 'sep_namajeniskepesertaan', '`sep_namajeniskepesertaan`', '`sep_namajeniskepesertaan`', 200, -1, FALSE, '`sep_namajeniskepesertaan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_namajeniskepesertaan->Sortable = TRUE; // Allow sort
		$this->fields['sep_namajeniskepesertaan'] = &$this->sep_namajeniskepesertaan;

		// sep_nokabpjs
		$this->sep_nokabpjs = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_nokabpjs', 'sep_nokabpjs', '`sep_nokabpjs`', '`sep_nokabpjs`', 200, -1, FALSE, '`sep_nokabpjs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_nokabpjs->Sortable = TRUE; // Allow sort
		$this->fields['sep_nokabpjs'] = &$this->sep_nokabpjs;

		// sep_status_peserta
		$this->sep_status_peserta = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_status_peserta', 'sep_status_peserta', '`sep_status_peserta`', '`sep_status_peserta`', 200, -1, FALSE, '`sep_status_peserta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_status_peserta->Sortable = TRUE; // Allow sort
		$this->fields['sep_status_peserta'] = &$this->sep_status_peserta;

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_sep_umur_pasien_sekarang', 'sep_umur_pasien_sekarang', '`sep_umur_pasien_sekarang`', '`sep_umur_pasien_sekarang`', 200, -1, FALSE, '`sep_umur_pasien_sekarang`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sep_umur_pasien_sekarang->Sortable = TRUE; // Allow sort
		$this->fields['sep_umur_pasien_sekarang'] = &$this->sep_umur_pasien_sekarang;

		// statuskeluarranap_id
		$this->statuskeluarranap_id = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_statuskeluarranap_id', 'statuskeluarranap_id', '`statuskeluarranap_id`', '`statuskeluarranap_id`', 3, -1, FALSE, '`statuskeluarranap_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->statuskeluarranap_id->Sortable = FALSE; // Allow sort
		$this->statuskeluarranap_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['statuskeluarranap_id'] = &$this->statuskeluarranap_id;

		// keluarrs
		$this->keluarrs = new cField('vw_sep_rawat_inap_by_noka', 'vw_sep_rawat_inap_by_noka', 'x_keluarrs', 'keluarrs', '`keluarrs`', ew_CastDateFieldForLike('`keluarrs`', 0, "DB"), 135, 0, FALSE, '`keluarrs`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->keluarrs->Sortable = FALSE; // Allow sort
		$this->keluarrs->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['keluarrs'] = &$this->keluarrs;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_sep_rawat_inap_by_noka`";
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
			return "vw_sep_rawat_inap_by_nokalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_sep_rawat_inap_by_nokalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_sep_rawat_inap_by_nokaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_sep_rawat_inap_by_nokaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_sep_rawat_inap_by_nokaadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_sep_rawat_inap_by_nokaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_sep_rawat_inap_by_nokaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_sep_rawat_inap_by_nokaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_sep_rawat_inap_by_nokadelete.php", $this->UrlParm());
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
		$this->ket_jeniskelamin->setDbValue($rs->fields('ket_jeniskelamin'));
		$this->ket_title->setDbValue($rs->fields('ket_title'));
		$this->dokterpengirim->setDbValue($rs->fields('dokterpengirim'));
		$this->statusbayar->setDbValue($rs->fields('statusbayar'));
		$this->kirimdari->setDbValue($rs->fields('kirimdari'));
		$this->keluargadekat->setDbValue($rs->fields('keluargadekat'));
		$this->panggungjawab->setDbValue($rs->fields('panggungjawab'));
		$this->masukrs->setDbValue($rs->fields('masukrs'));
		$this->noruang->setDbValue($rs->fields('noruang'));
		$this->tempat_tidur_id->setDbValue($rs->fields('tempat_tidur_id'));
		$this->nott->setDbValue($rs->fields('nott'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->dokter_penanggungjawab->setDbValue($rs->fields('dokter_penanggungjawab'));
		$this->KELASPERAWATAN_ID->setDbValue($rs->fields('KELASPERAWATAN_ID'));
		$this->NO_SKP->setDbValue($rs->fields('NO_SKP'));
		$this->sep_tglsep->setDbValue($rs->fields('sep_tglsep'));
		$this->sep_tglrujuk->setDbValue($rs->fields('sep_tglrujuk'));
		$this->sep_kodekelasrawat->setDbValue($rs->fields('sep_kodekelasrawat'));
		$this->sep_norujukan->setDbValue($rs->fields('sep_norujukan'));
		$this->sep_kodeppkasal->setDbValue($rs->fields('sep_kodeppkasal'));
		$this->sep_namappkasal->setDbValue($rs->fields('sep_namappkasal'));
		$this->sep_kodeppkpelayanan->setDbValue($rs->fields('sep_kodeppkpelayanan'));
		$this->sep_jenisperawatan->setDbValue($rs->fields('sep_jenisperawatan'));
		$this->sep_catatan->setDbValue($rs->fields('sep_catatan'));
		$this->sep_kodediagnosaawal->setDbValue($rs->fields('sep_kodediagnosaawal'));
		$this->sep_namadiagnosaawal->setDbValue($rs->fields('sep_namadiagnosaawal'));
		$this->sep_lakalantas->setDbValue($rs->fields('sep_lakalantas'));
		$this->sep_lokasilaka->setDbValue($rs->fields('sep_lokasilaka'));
		$this->sep_user->setDbValue($rs->fields('sep_user'));
		$this->sep_flag_cekpeserta->setDbValue($rs->fields('sep_flag_cekpeserta'));
		$this->sep_flag_generatesep->setDbValue($rs->fields('sep_flag_generatesep'));
		$this->sep_nik->setDbValue($rs->fields('sep_nik'));
		$this->sep_namapeserta->setDbValue($rs->fields('sep_namapeserta'));
		$this->sep_jeniskelamin->setDbValue($rs->fields('sep_jeniskelamin'));
		$this->sep_pisat->setDbValue($rs->fields('sep_pisat'));
		$this->sep_tgllahir->setDbValue($rs->fields('sep_tgllahir'));
		$this->sep_kodejeniskepesertaan->setDbValue($rs->fields('sep_kodejeniskepesertaan'));
		$this->sep_namajeniskepesertaan->setDbValue($rs->fields('sep_namajeniskepesertaan'));
		$this->sep_nokabpjs->setDbValue($rs->fields('sep_nokabpjs'));
		$this->sep_status_peserta->setDbValue($rs->fields('sep_status_peserta'));
		$this->sep_umur_pasien_sekarang->setDbValue($rs->fields('sep_umur_pasien_sekarang'));
		$this->statuskeluarranap_id->setDbValue($rs->fields('statuskeluarranap_id'));
		$this->keluarrs->setDbValue($rs->fields('keluarrs'));
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
		// ket_jeniskelamin
		// ket_title
		// dokterpengirim
		// statusbayar
		// kirimdari
		// keluargadekat
		// panggungjawab
		// masukrs
		// noruang
		// tempat_tidur_id
		// nott
		// NIP
		// dokter_penanggungjawab
		// KELASPERAWATAN_ID
		// NO_SKP
		// sep_tglsep
		// sep_tglrujuk
		// sep_kodekelasrawat
		// sep_norujukan
		// sep_kodeppkasal
		// sep_namappkasal
		// sep_kodeppkpelayanan
		// sep_jenisperawatan
		// sep_catatan
		// sep_kodediagnosaawal
		// sep_namadiagnosaawal
		// sep_lakalantas
		// sep_lokasilaka
		// sep_user
		// sep_flag_cekpeserta
		// sep_flag_generatesep
		// sep_nik
		// sep_namapeserta
		// sep_jeniskelamin
		// sep_pisat
		// sep_tgllahir
		// sep_kodejeniskepesertaan
		// sep_namajeniskepesertaan
		// sep_nokabpjs
		// sep_status_peserta
		// sep_umur_pasien_sekarang
		// statuskeluarranap_id

		$this->statuskeluarranap_id->CellCssStyle = "white-space: nowrap;";

		// keluarrs
		$this->keluarrs->CellCssStyle = "white-space: nowrap;";

		// id_admission
		$this->id_admission->ViewValue = $this->id_admission->CurrentValue;
		$this->id_admission->ViewCustomAttributes = "";

		// nomr
		$this->nomr->ViewValue = $this->nomr->CurrentValue;
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

		// ket_jeniskelamin
		$this->ket_jeniskelamin->ViewValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->ViewCustomAttributes = "";

		// ket_title
		$this->ket_title->ViewValue = $this->ket_title->CurrentValue;
		$this->ket_title->ViewCustomAttributes = "";

		// dokterpengirim
		$this->dokterpengirim->ViewValue = $this->dokterpengirim->CurrentValue;
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
		$this->masukrs->ViewValue = ew_FormatDateTime($this->masukrs->ViewValue, 0);
		$this->masukrs->ViewCustomAttributes = "";

		// noruang
		$this->noruang->ViewValue = $this->noruang->CurrentValue;
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
		$this->tempat_tidur_id->ViewValue = $this->tempat_tidur_id->CurrentValue;
		$this->tempat_tidur_id->ViewCustomAttributes = "";

		// nott
		$this->nott->ViewValue = $this->nott->CurrentValue;
		$this->nott->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->ViewValue = $this->dokter_penanggungjawab->CurrentValue;
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

		// sep_tglsep
		$this->sep_tglsep->ViewValue = $this->sep_tglsep->CurrentValue;
		$this->sep_tglsep->ViewValue = ew_FormatDateTime($this->sep_tglsep->ViewValue, 5);
		$this->sep_tglsep->ViewCustomAttributes = "";

		// sep_tglrujuk
		$this->sep_tglrujuk->ViewValue = $this->sep_tglrujuk->CurrentValue;
		$this->sep_tglrujuk->ViewValue = ew_FormatDateTime($this->sep_tglrujuk->ViewValue, 5);
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

		// sep_jenisperawatan
		$this->sep_jenisperawatan->ViewValue = $this->sep_jenisperawatan->CurrentValue;
		$this->sep_jenisperawatan->ViewCustomAttributes = "";

		// sep_catatan
		$this->sep_catatan->ViewValue = $this->sep_catatan->CurrentValue;
		$this->sep_catatan->ViewCustomAttributes = "";

		// sep_kodediagnosaawal
		$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
		if (strval($this->sep_kodediagnosaawal->CurrentValue) <> "") {
			$sFilterWrk = "`CODE`" . ew_SearchString("=", $this->sep_kodediagnosaawal->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `CODE`, `CODE` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `vw_diagnosa_eklaim`";
		$sWhereWrk = "";
		$this->sep_kodediagnosaawal->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sep_kodediagnosaawal, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sep_kodediagnosaawal->ViewValue = $this->sep_kodediagnosaawal->CurrentValue;
			}
		} else {
			$this->sep_kodediagnosaawal->ViewValue = NULL;
		}
		$this->sep_kodediagnosaawal->ViewCustomAttributes = "";

		// sep_namadiagnosaawal
		$this->sep_namadiagnosaawal->ViewValue = $this->sep_namadiagnosaawal->CurrentValue;
		$this->sep_namadiagnosaawal->ViewCustomAttributes = "";

		// sep_lakalantas
		if (strval($this->sep_lakalantas->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->sep_lakalantas->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_lakalantas`";
		$sWhereWrk = "";
		$this->sep_lakalantas->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->sep_lakalantas, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->sep_lakalantas->ViewValue = $this->sep_lakalantas->CurrentValue;
			}
		} else {
			$this->sep_lakalantas->ViewValue = NULL;
		}
		$this->sep_lakalantas->ViewCustomAttributes = "";

		// sep_lokasilaka
		$this->sep_lokasilaka->ViewValue = $this->sep_lokasilaka->CurrentValue;
		$this->sep_lokasilaka->ViewCustomAttributes = "";

		// sep_user
		$this->sep_user->ViewValue = $this->sep_user->CurrentValue;
		$this->sep_user->ViewCustomAttributes = "";

		// sep_flag_cekpeserta
		if (strval($this->sep_flag_cekpeserta->CurrentValue) <> "") {
			$this->sep_flag_cekpeserta->ViewValue = "";
			$arwrk = explode(",", strval($this->sep_flag_cekpeserta->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->sep_flag_cekpeserta->ViewValue .= $this->sep_flag_cekpeserta->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->sep_flag_cekpeserta->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->sep_flag_cekpeserta->ViewValue = NULL;
		}
		$this->sep_flag_cekpeserta->ViewCustomAttributes = "";

		// sep_flag_generatesep
		if (strval($this->sep_flag_generatesep->CurrentValue) <> "") {
			$this->sep_flag_generatesep->ViewValue = "";
			$arwrk = explode(",", strval($this->sep_flag_generatesep->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->sep_flag_generatesep->ViewValue .= $this->sep_flag_generatesep->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->sep_flag_generatesep->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->sep_flag_generatesep->ViewValue = NULL;
		}
		$this->sep_flag_generatesep->ViewCustomAttributes = "";

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

		// sep_nokabpjs
		$this->sep_nokabpjs->ViewValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->ViewCustomAttributes = "";

		// sep_status_peserta
		$this->sep_status_peserta->ViewValue = $this->sep_status_peserta->CurrentValue;
		$this->sep_status_peserta->ViewCustomAttributes = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->ViewValue = $this->sep_umur_pasien_sekarang->CurrentValue;
		$this->sep_umur_pasien_sekarang->ViewCustomAttributes = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->ViewValue = $this->statuskeluarranap_id->CurrentValue;
		$this->statuskeluarranap_id->ViewCustomAttributes = "";

		// keluarrs
		$this->keluarrs->ViewValue = $this->keluarrs->CurrentValue;
		$this->keluarrs->ViewValue = ew_FormatDateTime($this->keluarrs->ViewValue, 0);
		$this->keluarrs->ViewCustomAttributes = "";

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

		// ket_jeniskelamin
		$this->ket_jeniskelamin->LinkCustomAttributes = "";
		$this->ket_jeniskelamin->HrefValue = "";
		$this->ket_jeniskelamin->TooltipValue = "";

		// ket_title
		$this->ket_title->LinkCustomAttributes = "";
		$this->ket_title->HrefValue = "";
		$this->ket_title->TooltipValue = "";

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

		// NIP
		$this->NIP->LinkCustomAttributes = "";
		$this->NIP->HrefValue = "";
		$this->NIP->TooltipValue = "";

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

		// sep_nokabpjs
		$this->sep_nokabpjs->LinkCustomAttributes = "";
		$this->sep_nokabpjs->HrefValue = "";
		$this->sep_nokabpjs->TooltipValue = "";

		// sep_status_peserta
		$this->sep_status_peserta->LinkCustomAttributes = "";
		$this->sep_status_peserta->HrefValue = "";
		$this->sep_status_peserta->TooltipValue = "";

		// sep_umur_pasien_sekarang
		$this->sep_umur_pasien_sekarang->LinkCustomAttributes = "";
		$this->sep_umur_pasien_sekarang->HrefValue = "";
		$this->sep_umur_pasien_sekarang->TooltipValue = "";

		// statuskeluarranap_id
		$this->statuskeluarranap_id->LinkCustomAttributes = "";
		$this->statuskeluarranap_id->HrefValue = "";
		$this->statuskeluarranap_id->TooltipValue = "";

		// keluarrs
		$this->keluarrs->LinkCustomAttributes = "";
		$this->keluarrs->HrefValue = "";
		$this->keluarrs->TooltipValue = "";

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

		// ket_jeniskelamin
		$this->ket_jeniskelamin->EditAttrs["class"] = "form-control";
		$this->ket_jeniskelamin->EditCustomAttributes = "";
		$this->ket_jeniskelamin->EditValue = $this->ket_jeniskelamin->CurrentValue;
		$this->ket_jeniskelamin->PlaceHolder = ew_RemoveHtml($this->ket_jeniskelamin->FldCaption());

		// ket_title
		$this->ket_title->EditAttrs["class"] = "form-control";
		$this->ket_title->EditCustomAttributes = "";
		$this->ket_title->EditValue = $this->ket_title->CurrentValue;
		$this->ket_title->PlaceHolder = ew_RemoveHtml($this->ket_title->FldCaption());

		// dokterpengirim
		$this->dokterpengirim->EditAttrs["class"] = "form-control";
		$this->dokterpengirim->EditCustomAttributes = "";
		$this->dokterpengirim->EditValue = $this->dokterpengirim->CurrentValue;
		$this->dokterpengirim->PlaceHolder = ew_RemoveHtml($this->dokterpengirim->FldCaption());

		// statusbayar
		$this->statusbayar->EditAttrs["class"] = "form-control";
		$this->statusbayar->EditCustomAttributes = "";
		$this->statusbayar->EditValue = $this->statusbayar->CurrentValue;
		$this->statusbayar->PlaceHolder = ew_RemoveHtml($this->statusbayar->FldCaption());

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
		$this->masukrs->EditValue = ew_FormatDateTime($this->masukrs->CurrentValue, 8);
		$this->masukrs->PlaceHolder = ew_RemoveHtml($this->masukrs->FldCaption());

		// noruang
		$this->noruang->EditAttrs["class"] = "form-control";
		$this->noruang->EditCustomAttributes = "";
		$this->noruang->EditValue = $this->noruang->CurrentValue;
		$this->noruang->PlaceHolder = ew_RemoveHtml($this->noruang->FldCaption());

		// tempat_tidur_id
		$this->tempat_tidur_id->EditAttrs["class"] = "form-control";
		$this->tempat_tidur_id->EditCustomAttributes = "";
		$this->tempat_tidur_id->EditValue = $this->tempat_tidur_id->CurrentValue;
		$this->tempat_tidur_id->PlaceHolder = ew_RemoveHtml($this->tempat_tidur_id->FldCaption());

		// nott
		$this->nott->EditAttrs["class"] = "form-control";
		$this->nott->EditCustomAttributes = "";
		$this->nott->EditValue = $this->nott->CurrentValue;
		$this->nott->PlaceHolder = ew_RemoveHtml($this->nott->FldCaption());

		// NIP
		$this->NIP->EditAttrs["class"] = "form-control";
		$this->NIP->EditCustomAttributes = "";
		$this->NIP->EditValue = $this->NIP->CurrentValue;
		$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

		// dokter_penanggungjawab
		$this->dokter_penanggungjawab->EditAttrs["class"] = "form-control";
		$this->dokter_penanggungjawab->EditCustomAttributes = "";
		$this->dokter_penanggungjawab->EditValue = $this->dokter_penanggungjawab->CurrentValue;
		$this->dokter_penanggungjawab->PlaceHolder = ew_RemoveHtml($this->dokter_penanggungjawab->FldCaption());

		// KELASPERAWATAN_ID
		$this->KELASPERAWATAN_ID->EditAttrs["class"] = "form-control";
		$this->KELASPERAWATAN_ID->EditCustomAttributes = "";
		$this->KELASPERAWATAN_ID->EditValue = $this->KELASPERAWATAN_ID->CurrentValue;
		$this->KELASPERAWATAN_ID->PlaceHolder = ew_RemoveHtml($this->KELASPERAWATAN_ID->FldCaption());

		// NO_SKP
		$this->NO_SKP->EditAttrs["class"] = "form-control";
		$this->NO_SKP->EditCustomAttributes = "";
		$this->NO_SKP->EditValue = $this->NO_SKP->CurrentValue;
		$this->NO_SKP->PlaceHolder = ew_RemoveHtml($this->NO_SKP->FldCaption());

		// sep_tglsep
		$this->sep_tglsep->EditAttrs["class"] = "form-control";
		$this->sep_tglsep->EditCustomAttributes = "";
		$this->sep_tglsep->EditValue = ew_FormatDateTime($this->sep_tglsep->CurrentValue, 5);
		$this->sep_tglsep->PlaceHolder = ew_RemoveHtml($this->sep_tglsep->FldCaption());

		// sep_tglrujuk
		$this->sep_tglrujuk->EditAttrs["class"] = "form-control";
		$this->sep_tglrujuk->EditCustomAttributes = "";
		$this->sep_tglrujuk->EditValue = ew_FormatDateTime($this->sep_tglrujuk->CurrentValue, 5);
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
		$this->sep_lakalantas->EditCustomAttributes = "";

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
		$this->sep_flag_cekpeserta->EditCustomAttributes = "";
		$this->sep_flag_cekpeserta->EditValue = $this->sep_flag_cekpeserta->Options(FALSE);

		// sep_flag_generatesep
		$this->sep_flag_generatesep->EditCustomAttributes = "";
		$this->sep_flag_generatesep->EditValue = $this->sep_flag_generatesep->Options(FALSE);

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

		// sep_nokabpjs
		$this->sep_nokabpjs->EditAttrs["class"] = "form-control";
		$this->sep_nokabpjs->EditCustomAttributes = "";
		$this->sep_nokabpjs->EditValue = $this->sep_nokabpjs->CurrentValue;
		$this->sep_nokabpjs->PlaceHolder = ew_RemoveHtml($this->sep_nokabpjs->FldCaption());

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

		// statuskeluarranap_id
		$this->statuskeluarranap_id->EditAttrs["class"] = "form-control";
		$this->statuskeluarranap_id->EditCustomAttributes = "";
		$this->statuskeluarranap_id->EditValue = $this->statuskeluarranap_id->CurrentValue;
		$this->statuskeluarranap_id->PlaceHolder = ew_RemoveHtml($this->statuskeluarranap_id->FldCaption());

		// keluarrs
		$this->keluarrs->EditAttrs["class"] = "form-control";
		$this->keluarrs->EditCustomAttributes = "";
		$this->keluarrs->EditValue = ew_FormatDateTime($this->keluarrs->CurrentValue, 8);
		$this->keluarrs->PlaceHolder = ew_RemoveHtml($this->keluarrs->FldCaption());

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
					if ($this->ket_jeniskelamin->Exportable) $Doc->ExportCaption($this->ket_jeniskelamin);
					if ($this->ket_title->Exportable) $Doc->ExportCaption($this->ket_title);
					if ($this->dokterpengirim->Exportable) $Doc->ExportCaption($this->dokterpengirim);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->kirimdari->Exportable) $Doc->ExportCaption($this->kirimdari);
					if ($this->keluargadekat->Exportable) $Doc->ExportCaption($this->keluargadekat);
					if ($this->panggungjawab->Exportable) $Doc->ExportCaption($this->panggungjawab);
					if ($this->masukrs->Exportable) $Doc->ExportCaption($this->masukrs);
					if ($this->noruang->Exportable) $Doc->ExportCaption($this->noruang);
					if ($this->tempat_tidur_id->Exportable) $Doc->ExportCaption($this->tempat_tidur_id);
					if ($this->nott->Exportable) $Doc->ExportCaption($this->nott);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportCaption($this->dokter_penanggungjawab);
					if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportCaption($this->KELASPERAWATAN_ID);
					if ($this->NO_SKP->Exportable) $Doc->ExportCaption($this->NO_SKP);
					if ($this->sep_tglsep->Exportable) $Doc->ExportCaption($this->sep_tglsep);
					if ($this->sep_tglrujuk->Exportable) $Doc->ExportCaption($this->sep_tglrujuk);
					if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportCaption($this->sep_kodekelasrawat);
					if ($this->sep_norujukan->Exportable) $Doc->ExportCaption($this->sep_norujukan);
					if ($this->sep_kodeppkasal->Exportable) $Doc->ExportCaption($this->sep_kodeppkasal);
					if ($this->sep_namappkasal->Exportable) $Doc->ExportCaption($this->sep_namappkasal);
					if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportCaption($this->sep_kodeppkpelayanan);
					if ($this->sep_jenisperawatan->Exportable) $Doc->ExportCaption($this->sep_jenisperawatan);
					if ($this->sep_catatan->Exportable) $Doc->ExportCaption($this->sep_catatan);
					if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportCaption($this->sep_kodediagnosaawal);
					if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportCaption($this->sep_namadiagnosaawal);
					if ($this->sep_lakalantas->Exportable) $Doc->ExportCaption($this->sep_lakalantas);
					if ($this->sep_lokasilaka->Exportable) $Doc->ExportCaption($this->sep_lokasilaka);
					if ($this->sep_user->Exportable) $Doc->ExportCaption($this->sep_user);
					if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportCaption($this->sep_flag_cekpeserta);
					if ($this->sep_flag_generatesep->Exportable) $Doc->ExportCaption($this->sep_flag_generatesep);
					if ($this->sep_nik->Exportable) $Doc->ExportCaption($this->sep_nik);
					if ($this->sep_namapeserta->Exportable) $Doc->ExportCaption($this->sep_namapeserta);
					if ($this->sep_jeniskelamin->Exportable) $Doc->ExportCaption($this->sep_jeniskelamin);
					if ($this->sep_pisat->Exportable) $Doc->ExportCaption($this->sep_pisat);
					if ($this->sep_tgllahir->Exportable) $Doc->ExportCaption($this->sep_tgllahir);
					if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_kodejeniskepesertaan);
					if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_namajeniskepesertaan);
					if ($this->sep_nokabpjs->Exportable) $Doc->ExportCaption($this->sep_nokabpjs);
					if ($this->sep_status_peserta->Exportable) $Doc->ExportCaption($this->sep_status_peserta);
					if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportCaption($this->sep_umur_pasien_sekarang);
				} else {
					if ($this->id_admission->Exportable) $Doc->ExportCaption($this->id_admission);
					if ($this->nomr->Exportable) $Doc->ExportCaption($this->nomr);
					if ($this->ket_nama->Exportable) $Doc->ExportCaption($this->ket_nama);
					if ($this->ket_tgllahir->Exportable) $Doc->ExportCaption($this->ket_tgllahir);
					if ($this->ket_alamat->Exportable) $Doc->ExportCaption($this->ket_alamat);
					if ($this->ket_jeniskelamin->Exportable) $Doc->ExportCaption($this->ket_jeniskelamin);
					if ($this->ket_title->Exportable) $Doc->ExportCaption($this->ket_title);
					if ($this->dokterpengirim->Exportable) $Doc->ExportCaption($this->dokterpengirim);
					if ($this->statusbayar->Exportable) $Doc->ExportCaption($this->statusbayar);
					if ($this->kirimdari->Exportable) $Doc->ExportCaption($this->kirimdari);
					if ($this->keluargadekat->Exportable) $Doc->ExportCaption($this->keluargadekat);
					if ($this->panggungjawab->Exportable) $Doc->ExportCaption($this->panggungjawab);
					if ($this->masukrs->Exportable) $Doc->ExportCaption($this->masukrs);
					if ($this->noruang->Exportable) $Doc->ExportCaption($this->noruang);
					if ($this->tempat_tidur_id->Exportable) $Doc->ExportCaption($this->tempat_tidur_id);
					if ($this->nott->Exportable) $Doc->ExportCaption($this->nott);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportCaption($this->dokter_penanggungjawab);
					if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportCaption($this->KELASPERAWATAN_ID);
					if ($this->NO_SKP->Exportable) $Doc->ExportCaption($this->NO_SKP);
					if ($this->sep_tglsep->Exportable) $Doc->ExportCaption($this->sep_tglsep);
					if ($this->sep_tglrujuk->Exportable) $Doc->ExportCaption($this->sep_tglrujuk);
					if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportCaption($this->sep_kodekelasrawat);
					if ($this->sep_norujukan->Exportable) $Doc->ExportCaption($this->sep_norujukan);
					if ($this->sep_kodeppkasal->Exportable) $Doc->ExportCaption($this->sep_kodeppkasal);
					if ($this->sep_namappkasal->Exportable) $Doc->ExportCaption($this->sep_namappkasal);
					if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportCaption($this->sep_kodeppkpelayanan);
					if ($this->sep_jenisperawatan->Exportable) $Doc->ExportCaption($this->sep_jenisperawatan);
					if ($this->sep_catatan->Exportable) $Doc->ExportCaption($this->sep_catatan);
					if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportCaption($this->sep_kodediagnosaawal);
					if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportCaption($this->sep_namadiagnosaawal);
					if ($this->sep_lakalantas->Exportable) $Doc->ExportCaption($this->sep_lakalantas);
					if ($this->sep_lokasilaka->Exportable) $Doc->ExportCaption($this->sep_lokasilaka);
					if ($this->sep_user->Exportable) $Doc->ExportCaption($this->sep_user);
					if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportCaption($this->sep_flag_cekpeserta);
					if ($this->sep_flag_generatesep->Exportable) $Doc->ExportCaption($this->sep_flag_generatesep);
					if ($this->sep_nik->Exportable) $Doc->ExportCaption($this->sep_nik);
					if ($this->sep_namapeserta->Exportable) $Doc->ExportCaption($this->sep_namapeserta);
					if ($this->sep_jeniskelamin->Exportable) $Doc->ExportCaption($this->sep_jeniskelamin);
					if ($this->sep_pisat->Exportable) $Doc->ExportCaption($this->sep_pisat);
					if ($this->sep_tgllahir->Exportable) $Doc->ExportCaption($this->sep_tgllahir);
					if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_kodejeniskepesertaan);
					if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportCaption($this->sep_namajeniskepesertaan);
					if ($this->sep_nokabpjs->Exportable) $Doc->ExportCaption($this->sep_nokabpjs);
					if ($this->sep_status_peserta->Exportable) $Doc->ExportCaption($this->sep_status_peserta);
					if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportCaption($this->sep_umur_pasien_sekarang);
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
						if ($this->ket_jeniskelamin->Exportable) $Doc->ExportField($this->ket_jeniskelamin);
						if ($this->ket_title->Exportable) $Doc->ExportField($this->ket_title);
						if ($this->dokterpengirim->Exportable) $Doc->ExportField($this->dokterpengirim);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->kirimdari->Exportable) $Doc->ExportField($this->kirimdari);
						if ($this->keluargadekat->Exportable) $Doc->ExportField($this->keluargadekat);
						if ($this->panggungjawab->Exportable) $Doc->ExportField($this->panggungjawab);
						if ($this->masukrs->Exportable) $Doc->ExportField($this->masukrs);
						if ($this->noruang->Exportable) $Doc->ExportField($this->noruang);
						if ($this->tempat_tidur_id->Exportable) $Doc->ExportField($this->tempat_tidur_id);
						if ($this->nott->Exportable) $Doc->ExportField($this->nott);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportField($this->dokter_penanggungjawab);
						if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportField($this->KELASPERAWATAN_ID);
						if ($this->NO_SKP->Exportable) $Doc->ExportField($this->NO_SKP);
						if ($this->sep_tglsep->Exportable) $Doc->ExportField($this->sep_tglsep);
						if ($this->sep_tglrujuk->Exportable) $Doc->ExportField($this->sep_tglrujuk);
						if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportField($this->sep_kodekelasrawat);
						if ($this->sep_norujukan->Exportable) $Doc->ExportField($this->sep_norujukan);
						if ($this->sep_kodeppkasal->Exportable) $Doc->ExportField($this->sep_kodeppkasal);
						if ($this->sep_namappkasal->Exportable) $Doc->ExportField($this->sep_namappkasal);
						if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportField($this->sep_kodeppkpelayanan);
						if ($this->sep_jenisperawatan->Exportable) $Doc->ExportField($this->sep_jenisperawatan);
						if ($this->sep_catatan->Exportable) $Doc->ExportField($this->sep_catatan);
						if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportField($this->sep_kodediagnosaawal);
						if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportField($this->sep_namadiagnosaawal);
						if ($this->sep_lakalantas->Exportable) $Doc->ExportField($this->sep_lakalantas);
						if ($this->sep_lokasilaka->Exportable) $Doc->ExportField($this->sep_lokasilaka);
						if ($this->sep_user->Exportable) $Doc->ExportField($this->sep_user);
						if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportField($this->sep_flag_cekpeserta);
						if ($this->sep_flag_generatesep->Exportable) $Doc->ExportField($this->sep_flag_generatesep);
						if ($this->sep_nik->Exportable) $Doc->ExportField($this->sep_nik);
						if ($this->sep_namapeserta->Exportable) $Doc->ExportField($this->sep_namapeserta);
						if ($this->sep_jeniskelamin->Exportable) $Doc->ExportField($this->sep_jeniskelamin);
						if ($this->sep_pisat->Exportable) $Doc->ExportField($this->sep_pisat);
						if ($this->sep_tgllahir->Exportable) $Doc->ExportField($this->sep_tgllahir);
						if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportField($this->sep_kodejeniskepesertaan);
						if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportField($this->sep_namajeniskepesertaan);
						if ($this->sep_nokabpjs->Exportable) $Doc->ExportField($this->sep_nokabpjs);
						if ($this->sep_status_peserta->Exportable) $Doc->ExportField($this->sep_status_peserta);
						if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportField($this->sep_umur_pasien_sekarang);
					} else {
						if ($this->id_admission->Exportable) $Doc->ExportField($this->id_admission);
						if ($this->nomr->Exportable) $Doc->ExportField($this->nomr);
						if ($this->ket_nama->Exportable) $Doc->ExportField($this->ket_nama);
						if ($this->ket_tgllahir->Exportable) $Doc->ExportField($this->ket_tgllahir);
						if ($this->ket_alamat->Exportable) $Doc->ExportField($this->ket_alamat);
						if ($this->ket_jeniskelamin->Exportable) $Doc->ExportField($this->ket_jeniskelamin);
						if ($this->ket_title->Exportable) $Doc->ExportField($this->ket_title);
						if ($this->dokterpengirim->Exportable) $Doc->ExportField($this->dokterpengirim);
						if ($this->statusbayar->Exportable) $Doc->ExportField($this->statusbayar);
						if ($this->kirimdari->Exportable) $Doc->ExportField($this->kirimdari);
						if ($this->keluargadekat->Exportable) $Doc->ExportField($this->keluargadekat);
						if ($this->panggungjawab->Exportable) $Doc->ExportField($this->panggungjawab);
						if ($this->masukrs->Exportable) $Doc->ExportField($this->masukrs);
						if ($this->noruang->Exportable) $Doc->ExportField($this->noruang);
						if ($this->tempat_tidur_id->Exportable) $Doc->ExportField($this->tempat_tidur_id);
						if ($this->nott->Exportable) $Doc->ExportField($this->nott);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->dokter_penanggungjawab->Exportable) $Doc->ExportField($this->dokter_penanggungjawab);
						if ($this->KELASPERAWATAN_ID->Exportable) $Doc->ExportField($this->KELASPERAWATAN_ID);
						if ($this->NO_SKP->Exportable) $Doc->ExportField($this->NO_SKP);
						if ($this->sep_tglsep->Exportable) $Doc->ExportField($this->sep_tglsep);
						if ($this->sep_tglrujuk->Exportable) $Doc->ExportField($this->sep_tglrujuk);
						if ($this->sep_kodekelasrawat->Exportable) $Doc->ExportField($this->sep_kodekelasrawat);
						if ($this->sep_norujukan->Exportable) $Doc->ExportField($this->sep_norujukan);
						if ($this->sep_kodeppkasal->Exportable) $Doc->ExportField($this->sep_kodeppkasal);
						if ($this->sep_namappkasal->Exportable) $Doc->ExportField($this->sep_namappkasal);
						if ($this->sep_kodeppkpelayanan->Exportable) $Doc->ExportField($this->sep_kodeppkpelayanan);
						if ($this->sep_jenisperawatan->Exportable) $Doc->ExportField($this->sep_jenisperawatan);
						if ($this->sep_catatan->Exportable) $Doc->ExportField($this->sep_catatan);
						if ($this->sep_kodediagnosaawal->Exportable) $Doc->ExportField($this->sep_kodediagnosaawal);
						if ($this->sep_namadiagnosaawal->Exportable) $Doc->ExportField($this->sep_namadiagnosaawal);
						if ($this->sep_lakalantas->Exportable) $Doc->ExportField($this->sep_lakalantas);
						if ($this->sep_lokasilaka->Exportable) $Doc->ExportField($this->sep_lokasilaka);
						if ($this->sep_user->Exportable) $Doc->ExportField($this->sep_user);
						if ($this->sep_flag_cekpeserta->Exportable) $Doc->ExportField($this->sep_flag_cekpeserta);
						if ($this->sep_flag_generatesep->Exportable) $Doc->ExportField($this->sep_flag_generatesep);
						if ($this->sep_nik->Exportable) $Doc->ExportField($this->sep_nik);
						if ($this->sep_namapeserta->Exportable) $Doc->ExportField($this->sep_namapeserta);
						if ($this->sep_jeniskelamin->Exportable) $Doc->ExportField($this->sep_jeniskelamin);
						if ($this->sep_pisat->Exportable) $Doc->ExportField($this->sep_pisat);
						if ($this->sep_tgllahir->Exportable) $Doc->ExportField($this->sep_tgllahir);
						if ($this->sep_kodejeniskepesertaan->Exportable) $Doc->ExportField($this->sep_kodejeniskepesertaan);
						if ($this->sep_namajeniskepesertaan->Exportable) $Doc->ExportField($this->sep_namajeniskepesertaan);
						if ($this->sep_nokabpjs->Exportable) $Doc->ExportField($this->sep_nokabpjs);
						if ($this->sep_status_peserta->Exportable) $Doc->ExportField($this->sep_status_peserta);
						if ($this->sep_umur_pasien_sekarang->Exportable) $Doc->ExportField($this->sep_umur_pasien_sekarang);
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
		if (preg_match('/^x(\d)*_sep_kodediagnosaawal$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `STR` AS FIELD0 FROM `vw_diagnosa_eklaim`";
			$sWhereWrk = "(`CODE` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->sep_kodediagnosaawal->LookupFilters = array();
			$this->Lookup_Selecting($this->sep_kodediagnosaawal, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->sep_namadiagnosaawal->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->sep_namadiagnosaawal->AutoFillOriginalValue) ? $this->sep_namadiagnosaawal->CurrentValue : $this->sep_namadiagnosaawal->EditValue;
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
		$table = 'vw_sep_rawat_inap_by_noka';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'vw_sep_rawat_inap_by_noka';

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
		$table = 'vw_sep_rawat_inap_by_noka';

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
		$table = 'vw_sep_rawat_inap_by_noka';

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
		//ew_AddFilter($filter, "TGLREG <= CURDATE() AND TGLREG  >= (CURDATE() - interval 3 day) AND KDCARABAYAR != 1 AND KDCARABAYAR != 9 AND KDCARABAYAR != 7  "); 

		ew_AddFilter($filter, "ISNULL(keluarrs) OR (keluarrs = NULL)"); 
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
		ew_Execute("call simrs2012.sp_simpan_sep('".$rsnew["sep_jenisperawatan"]."', '".$rsold["id_admission"]."')");
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
			$this->sep_jenisperawatan->EditValue = 1;
			$this->sep_jenisperawatan->ReadOnly = TRUE;
			$this->NIP->ReadOnly = TRUE;
			$this->sep_kodeppkasal->ReadOnly = TRUE;
			$this->sep_namappkasal->ReadOnly = TRUE;
			$this->sep_kodeppkpelayanan->ReadOnly = TRUE;
			$this->sep_user->ReadOnly = TRUE;
			$this->sep_nik->ReadOnly = TRUE;
			$this->sep_namapeserta->ReadOnly = TRUE;
			$this->sep_jeniskelamin->ReadOnly = TRUE;
			$this->sep_pisat->ReadOnly = TRUE;
			$this->sep_tgllahir->ReadOnly = TRUE;
			$this->sep_kodejeniskepesertaan->ReadOnly = TRUE;
			$this->sep_namajeniskepesertaan->ReadOnly = TRUE;
			$this->sep_kodekelasrawat->ReadOnly = TRUE;
			$this->sep_namadiagnosaawal->ReadOnly = TRUE;
			$this->KELASPERAWATAN_ID->ReadOnly = TRUE;
			$this->NO_SKP->ReadOnly = TRUE;
			$kode_dokter = ew_ExecuteScalar("select KDDOKTER FROM simrs2012.t_pendaftaran where IDXDAFTAR = '".$this->id_admission->CurrentValue."'");

		//$this->dokter_penanggungjawab->EditValue = ew_ExecuteScalar("SELECT NAMADOKTER FROM simrs2012.m_dokter where KDDOKTER = '".$kode_dokter."'");
			$this->sep_status_peserta->ReadOnly = TRUE;
			$this->sep_umur_pasien_sekarang->ReadOnly = TRUE;
			$this->sep_norujukan->EditValue = 'RITL';
			$this->sep_kodeppkpelayanan->EditValue = ew_ExecuteScalar("select kodeppk_rs FROM simrs2012.l_konfigurasi_ws where id = 1");
			$this->ket_nama->ReadOnly = TRUE;
			$this->ket_tgllahir->ReadOnly = TRUE;
			$this->ket_alamat->ReadOnly = TRUE;
			$this->ket_jeniskelamin->ReadOnly = TRUE;
			$this->ket_title->ReadOnly = TRUE;
			$data_pendaftaran = ew_ExecuteRow("SELECT * FROM simrs2012.t_pendaftaran where IDXDAFTAR = '".$this->id_admission->CurrentValue."'");
			$this->panggungjawab->EditValue = $data_pendaftaran["PENANGGUNGJAWAB_NAMA"];
			$this->keluargadekat->EditValue = $data_pendaftaran["PENANGGUNGJAWAB_NAMA"];
			$data_pasien = ew_ExecuteRow("SELECT * FROM simrs2012.m_pasien where NOMR = '".$this->nomr->CurrentValue."'");
			$this->sep_nokabpjs->EditValue = $data_pasien["NO_KARTU"];

			//$this->dokter_penanggungjawab->EditValue = null;
			$this->sep_user->EditValue = $session;
			$this->NIP->EditValue = $session;
			$this->nomr->ReadOnly = TRUE;
			$this->dokterpengirim->ReadOnly = TRUE;
			$this->statusbayar->ReadOnly = TRUE;
			$this->kirimdari->ReadOnly = TRUE;
			$this->keluargadekat->ReadOnly = TRUE;
			$this->panggungjawab->ReadOnly = TRUE;
			$this->masukrs->ReadOnly = TRUE;
			$this->nott->ReadOnly = TRUE;
			$this->tempat_tidur_id->ReadOnly = TRUE;
			$this->dokter_penanggungjawab->ReadOnly = TRUE;
			$this->noruang->ReadOnly = TRUE;
		}
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
