<?php

// Global variable for table object
$vw_bridging_sep_by_no_rujukan = NULL;

//
// Table class for vw_bridging_sep_by_no_rujukan
//
class cvw_bridging_sep_by_no_rujukan extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $IDXDAFTAR;
	var $NOMR;
	var $KDPOLY;
	var $TGLREG;
	var $KDCARABAYAR;
	var $NIP;
	var $JAMREG;
	var $NO_SJP;
	var $NOKARTU;
	var $TANGGAL_SEP;
	var $TANGGALRUJUK_SEP;
	var $KELASRAWAT_SEP;
	var $NORUJUKAN_SEP;
	var $PPKPELAYANAN_SEP;
	var $JENISPERAWATAN_SEP;
	var $CATATAN_SEP;
	var $DIAGNOSAAWAL_SEP;
	var $NAMADIAGNOSA_SEP;
	var $LAKALANTAS_SEP;
	var $LOKASILAKALANTAS;
	var $USER;
	var $generate_sep;
	var $PESERTANIK_SEP;
	var $PESERTANAMA_SEP;
	var $PESERTAJENISKELAMIN_SEP;
	var $PESERTANAMAKELAS_SEP;
	var $PESERTAPISAT;
	var $PESERTATGLLAHIR;
	var $PESERTAJENISPESERTA_SEP;
	var $PESERTANAMAJENISPESERTA_SEP;
	var $POLITUJUAN_SEP;
	var $NAMAPOLITUJUAN_SEP;
	var $KDPPKRUJUKAN_SEP;
	var $NMPPKRUJUKAN_SEP;
	var $mapingtransaksi;
	var $bridging_by_no_rujukan;
	var $bridging_rujukan_faskes_2;
	var $pasien_NOTELP;
	var $penjamin_kkl_id;
	var $asalfaskesrujukan_id;
	var $peserta_cob;
	var $poli_eksekutif;
	var $status_kepesertaan_BPJS;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_bridging_sep_by_no_rujukan';
		$this->TableName = 'vw_bridging_sep_by_no_rujukan';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_bridging_sep_by_no_rujukan`";
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

		// IDXDAFTAR
		$this->IDXDAFTAR = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_IDXDAFTAR', 'IDXDAFTAR', '`IDXDAFTAR`', '`IDXDAFTAR`', 3, -1, FALSE, '`IDXDAFTAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->IDXDAFTAR->Sortable = FALSE; // Allow sort
		$this->IDXDAFTAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IDXDAFTAR'] = &$this->IDXDAFTAR;

		// NOMR
		$this->NOMR = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NOMR', 'NOMR', '`NOMR`', '`NOMR`', 200, -1, FALSE, '`NOMR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOMR->Sortable = FALSE; // Allow sort
		$this->fields['NOMR'] = &$this->NOMR;

		// KDPOLY
		$this->KDPOLY = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_KDPOLY', 'KDPOLY', '`KDPOLY`', '`KDPOLY`', 3, -1, FALSE, '`KDPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDPOLY->Sortable = FALSE; // Allow sort
		$this->KDPOLY->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDPOLY'] = &$this->KDPOLY;

		// TGLREG
		$this->TGLREG = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_TGLREG', 'TGLREG', '`TGLREG`', ew_CastDateFieldForLike('`TGLREG`', 0, "DB"), 133, 0, FALSE, '`TGLREG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGLREG->Sortable = FALSE; // Allow sort
		$this->TGLREG->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TGLREG'] = &$this->TGLREG;

		// KDCARABAYAR
		$this->KDCARABAYAR = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_KDCARABAYAR', 'KDCARABAYAR', '`KDCARABAYAR`', '`KDCARABAYAR`', 3, -1, FALSE, '`KDCARABAYAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDCARABAYAR->Sortable = FALSE; // Allow sort
		$this->KDCARABAYAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDCARABAYAR'] = &$this->KDCARABAYAR;

		// NIP
		$this->NIP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = FALSE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// JAMREG
		$this->JAMREG = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_JAMREG', 'JAMREG', '`JAMREG`', ew_CastDateFieldForLike('`JAMREG`', 0, "DB"), 135, 0, FALSE, '`JAMREG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JAMREG->Sortable = FALSE; // Allow sort
		$this->JAMREG->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['JAMREG'] = &$this->JAMREG;

		// NO_SJP
		$this->NO_SJP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NO_SJP', 'NO_SJP', '`NO_SJP`', '`NO_SJP`', 200, -1, FALSE, '`NO_SJP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SJP->Sortable = FALSE; // Allow sort
		$this->fields['NO_SJP'] = &$this->NO_SJP;

		// NOKARTU
		$this->NOKARTU = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NOKARTU', 'NOKARTU', '`NOKARTU`', '`NOKARTU`', 200, -1, FALSE, '`NOKARTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKARTU->Sortable = FALSE; // Allow sort
		$this->fields['NOKARTU'] = &$this->NOKARTU;

		// TANGGAL_SEP
		$this->TANGGAL_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_TANGGAL_SEP', 'TANGGAL_SEP', '`TANGGAL_SEP`', ew_CastDateFieldForLike('`TANGGAL_SEP`', 5, "DB"), 135, 5, FALSE, '`TANGGAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TANGGAL_SEP->Sortable = FALSE; // Allow sort
		$this->TANGGAL_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateYMD"));
		$this->fields['TANGGAL_SEP'] = &$this->TANGGAL_SEP;

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_TANGGALRUJUK_SEP', 'TANGGALRUJUK_SEP', '`TANGGALRUJUK_SEP`', ew_CastDateFieldForLike('`TANGGALRUJUK_SEP`', 5, "DB"), 135, 5, FALSE, '`TANGGALRUJUK_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TANGGALRUJUK_SEP->Sortable = FALSE; // Allow sort
		$this->TANGGALRUJUK_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateYMD"));
		$this->fields['TANGGALRUJUK_SEP'] = &$this->TANGGALRUJUK_SEP;

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_KELASRAWAT_SEP', 'KELASRAWAT_SEP', '`KELASRAWAT_SEP`', '`KELASRAWAT_SEP`', 3, -1, FALSE, '`KELASRAWAT_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELASRAWAT_SEP->Sortable = FALSE; // Allow sort
		$this->KELASRAWAT_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KELASRAWAT_SEP'] = &$this->KELASRAWAT_SEP;

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NORUJUKAN_SEP', 'NORUJUKAN_SEP', '`NORUJUKAN_SEP`', '`NORUJUKAN_SEP`', 200, -1, FALSE, '`NORUJUKAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NORUJUKAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NORUJUKAN_SEP'] = &$this->NORUJUKAN_SEP;

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PPKPELAYANAN_SEP', 'PPKPELAYANAN_SEP', '`PPKPELAYANAN_SEP`', '`PPKPELAYANAN_SEP`', 200, -1, FALSE, '`PPKPELAYANAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PPKPELAYANAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PPKPELAYANAN_SEP'] = &$this->PPKPELAYANAN_SEP;

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_JENISPERAWATAN_SEP', 'JENISPERAWATAN_SEP', '`JENISPERAWATAN_SEP`', '`JENISPERAWATAN_SEP`', 3, -1, FALSE, '`JENISPERAWATAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->JENISPERAWATAN_SEP->Sortable = FALSE; // Allow sort
		$this->JENISPERAWATAN_SEP->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->JENISPERAWATAN_SEP->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->JENISPERAWATAN_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['JENISPERAWATAN_SEP'] = &$this->JENISPERAWATAN_SEP;

		// CATATAN_SEP
		$this->CATATAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_CATATAN_SEP', 'CATATAN_SEP', '`CATATAN_SEP`', '`CATATAN_SEP`', 200, -1, FALSE, '`CATATAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CATATAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['CATATAN_SEP'] = &$this->CATATAN_SEP;

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_DIAGNOSAAWAL_SEP', 'DIAGNOSAAWAL_SEP', '`DIAGNOSAAWAL_SEP`', '`DIAGNOSAAWAL_SEP`', 200, -1, FALSE, '`DIAGNOSAAWAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DIAGNOSAAWAL_SEP->Sortable = FALSE; // Allow sort
		$this->fields['DIAGNOSAAWAL_SEP'] = &$this->DIAGNOSAAWAL_SEP;

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NAMADIAGNOSA_SEP', 'NAMADIAGNOSA_SEP', '`NAMADIAGNOSA_SEP`', '`NAMADIAGNOSA_SEP`', 200, -1, FALSE, '`NAMADIAGNOSA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMADIAGNOSA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NAMADIAGNOSA_SEP'] = &$this->NAMADIAGNOSA_SEP;

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_LAKALANTAS_SEP', 'LAKALANTAS_SEP', '`LAKALANTAS_SEP`', '`LAKALANTAS_SEP`', 3, -1, FALSE, '`LAKALANTAS_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->LAKALANTAS_SEP->Sortable = FALSE; // Allow sort
		$this->LAKALANTAS_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['LAKALANTAS_SEP'] = &$this->LAKALANTAS_SEP;

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_LOKASILAKALANTAS', 'LOKASILAKALANTAS', '`LOKASILAKALANTAS`', '`LOKASILAKALANTAS`', 200, -1, FALSE, '`LOKASILAKALANTAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LOKASILAKALANTAS->Sortable = FALSE; // Allow sort
		$this->fields['LOKASILAKALANTAS'] = &$this->LOKASILAKALANTAS;

		// USER
		$this->USER = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_USER', 'USER', '`USER`', '`USER`', 200, -1, FALSE, '`USER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER->Sortable = FALSE; // Allow sort
		$this->fields['USER'] = &$this->USER;

		// generate_sep
		$this->generate_sep = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_generate_sep', 'generate_sep', '`generate_sep`', '`generate_sep`', 3, -1, FALSE, '`generate_sep`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->generate_sep->Sortable = FALSE; // Allow sort
		$this->generate_sep->OptionCount = 1;
		$this->generate_sep->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['generate_sep'] = &$this->generate_sep;

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTANIK_SEP', 'PESERTANIK_SEP', '`PESERTANIK_SEP`', '`PESERTANIK_SEP`', 200, -1, FALSE, '`PESERTANIK_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANIK_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANIK_SEP'] = &$this->PESERTANIK_SEP;

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTANAMA_SEP', 'PESERTANAMA_SEP', '`PESERTANAMA_SEP`', '`PESERTANAMA_SEP`', 200, -1, FALSE, '`PESERTANAMA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANAMA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANAMA_SEP'] = &$this->PESERTANAMA_SEP;

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTAJENISKELAMIN_SEP', 'PESERTAJENISKELAMIN_SEP', '`PESERTAJENISKELAMIN_SEP`', '`PESERTAJENISKELAMIN_SEP`', 200, -1, FALSE, '`PESERTAJENISKELAMIN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTAJENISKELAMIN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTAJENISKELAMIN_SEP'] = &$this->PESERTAJENISKELAMIN_SEP;

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTANAMAKELAS_SEP', 'PESERTANAMAKELAS_SEP', '`PESERTANAMAKELAS_SEP`', '`PESERTANAMAKELAS_SEP`', 200, -1, FALSE, '`PESERTANAMAKELAS_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANAMAKELAS_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANAMAKELAS_SEP'] = &$this->PESERTANAMAKELAS_SEP;

		// PESERTAPISAT
		$this->PESERTAPISAT = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTAPISAT', 'PESERTAPISAT', '`PESERTAPISAT`', '`PESERTAPISAT`', 200, -1, FALSE, '`PESERTAPISAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTAPISAT->Sortable = FALSE; // Allow sort
		$this->fields['PESERTAPISAT'] = &$this->PESERTAPISAT;

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTATGLLAHIR', 'PESERTATGLLAHIR', '`PESERTATGLLAHIR`', '`PESERTATGLLAHIR`', 200, -1, FALSE, '`PESERTATGLLAHIR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTATGLLAHIR->Sortable = FALSE; // Allow sort
		$this->fields['PESERTATGLLAHIR'] = &$this->PESERTATGLLAHIR;

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTAJENISPESERTA_SEP', 'PESERTAJENISPESERTA_SEP', '`PESERTAJENISPESERTA_SEP`', '`PESERTAJENISPESERTA_SEP`', 200, -1, FALSE, '`PESERTAJENISPESERTA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTAJENISPESERTA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTAJENISPESERTA_SEP'] = &$this->PESERTAJENISPESERTA_SEP;

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_PESERTANAMAJENISPESERTA_SEP', 'PESERTANAMAJENISPESERTA_SEP', '`PESERTANAMAJENISPESERTA_SEP`', '`PESERTANAMAJENISPESERTA_SEP`', 200, -1, FALSE, '`PESERTANAMAJENISPESERTA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PESERTANAMAJENISPESERTA_SEP->Sortable = FALSE; // Allow sort
		$this->fields['PESERTANAMAJENISPESERTA_SEP'] = &$this->PESERTANAMAJENISPESERTA_SEP;

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_POLITUJUAN_SEP', 'POLITUJUAN_SEP', '`POLITUJUAN_SEP`', '`POLITUJUAN_SEP`', 200, -1, FALSE, '`POLITUJUAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->POLITUJUAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['POLITUJUAN_SEP'] = &$this->POLITUJUAN_SEP;

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NAMAPOLITUJUAN_SEP', 'NAMAPOLITUJUAN_SEP', '`NAMAPOLITUJUAN_SEP`', '`NAMAPOLITUJUAN_SEP`', 200, -1, FALSE, '`NAMAPOLITUJUAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMAPOLITUJUAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NAMAPOLITUJUAN_SEP'] = &$this->NAMAPOLITUJUAN_SEP;

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_KDPPKRUJUKAN_SEP', 'KDPPKRUJUKAN_SEP', '`KDPPKRUJUKAN_SEP`', '`KDPPKRUJUKAN_SEP`', 200, -1, FALSE, '`KDPPKRUJUKAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDPPKRUJUKAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['KDPPKRUJUKAN_SEP'] = &$this->KDPPKRUJUKAN_SEP;

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_NMPPKRUJUKAN_SEP', 'NMPPKRUJUKAN_SEP', '`NMPPKRUJUKAN_SEP`', '`NMPPKRUJUKAN_SEP`', 200, -1, FALSE, '`NMPPKRUJUKAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NMPPKRUJUKAN_SEP->Sortable = FALSE; // Allow sort
		$this->fields['NMPPKRUJUKAN_SEP'] = &$this->NMPPKRUJUKAN_SEP;

		// mapingtransaksi
		$this->mapingtransaksi = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_mapingtransaksi', 'mapingtransaksi', '`mapingtransaksi`', '`mapingtransaksi`', 3, -1, FALSE, '`mapingtransaksi`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->mapingtransaksi->Sortable = FALSE; // Allow sort
		$this->mapingtransaksi->OptionCount = 1;
		$this->mapingtransaksi->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['mapingtransaksi'] = &$this->mapingtransaksi;

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_bridging_by_no_rujukan', 'bridging_by_no_rujukan', '`bridging_by_no_rujukan`', '`bridging_by_no_rujukan`', 3, -1, FALSE, '`bridging_by_no_rujukan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->bridging_by_no_rujukan->Sortable = FALSE; // Allow sort
		$this->bridging_by_no_rujukan->OptionCount = 1;
		$this->bridging_by_no_rujukan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_by_no_rujukan'] = &$this->bridging_by_no_rujukan;

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2 = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_bridging_rujukan_faskes_2', 'bridging_rujukan_faskes_2', '`bridging_rujukan_faskes_2`', '`bridging_rujukan_faskes_2`', 3, -1, FALSE, '`bridging_rujukan_faskes_2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->bridging_rujukan_faskes_2->Sortable = FALSE; // Allow sort
		$this->bridging_rujukan_faskes_2->OptionCount = 1;
		$this->bridging_rujukan_faskes_2->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bridging_rujukan_faskes_2'] = &$this->bridging_rujukan_faskes_2;

		// pasien_NOTELP
		$this->pasien_NOTELP = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_pasien_NOTELP', 'pasien_NOTELP', '`pasien_NOTELP`', '`pasien_NOTELP`', 200, -1, FALSE, '`pasien_NOTELP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasien_NOTELP->Sortable = TRUE; // Allow sort
		$this->fields['pasien_NOTELP'] = &$this->pasien_NOTELP;

		// penjamin_kkl_id
		$this->penjamin_kkl_id = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_penjamin_kkl_id', 'penjamin_kkl_id', '`penjamin_kkl_id`', '`penjamin_kkl_id`', 3, -1, FALSE, '`penjamin_kkl_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->penjamin_kkl_id->Sortable = TRUE; // Allow sort
		$this->penjamin_kkl_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->penjamin_kkl_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->penjamin_kkl_id->OptionCount = 4;
		$this->penjamin_kkl_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['penjamin_kkl_id'] = &$this->penjamin_kkl_id;

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_asalfaskesrujukan_id', 'asalfaskesrujukan_id', '`asalfaskesrujukan_id`', '`asalfaskesrujukan_id`', 3, -1, FALSE, '`asalfaskesrujukan_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->asalfaskesrujukan_id->Sortable = TRUE; // Allow sort
		$this->asalfaskesrujukan_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->asalfaskesrujukan_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->asalfaskesrujukan_id->OptionCount = 2;
		$this->asalfaskesrujukan_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['asalfaskesrujukan_id'] = &$this->asalfaskesrujukan_id;

		// peserta_cob
		$this->peserta_cob = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_peserta_cob', 'peserta_cob', '`peserta_cob`', '`peserta_cob`', 3, -1, FALSE, '`peserta_cob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->peserta_cob->Sortable = TRUE; // Allow sort
		$this->peserta_cob->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->peserta_cob->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->peserta_cob->OptionCount = 2;
		$this->peserta_cob->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['peserta_cob'] = &$this->peserta_cob;

		// poli_eksekutif
		$this->poli_eksekutif = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_poli_eksekutif', 'poli_eksekutif', '`poli_eksekutif`', '`poli_eksekutif`', 3, -1, FALSE, '`poli_eksekutif`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->poli_eksekutif->Sortable = TRUE; // Allow sort
		$this->poli_eksekutif->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->poli_eksekutif->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->poli_eksekutif->OptionCount = 2;
		$this->poli_eksekutif->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['poli_eksekutif'] = &$this->poli_eksekutif;

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS = new cField('vw_bridging_sep_by_no_rujukan', 'vw_bridging_sep_by_no_rujukan', 'x_status_kepesertaan_BPJS', 'status_kepesertaan_BPJS', '`status_kepesertaan_BPJS`', '`status_kepesertaan_BPJS`', 200, -1, FALSE, '`status_kepesertaan_BPJS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status_kepesertaan_BPJS->Sortable = TRUE; // Allow sort
		$this->fields['status_kepesertaan_BPJS'] = &$this->status_kepesertaan_BPJS;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_bridging_sep_by_no_rujukan`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`IDXDAFTAR` DESC";
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
			$this->IDXDAFTAR->setDbValue($conn->Insert_ID());
			$rs['IDXDAFTAR'] = $this->IDXDAFTAR->DbValue;
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
			$fldname = 'IDXDAFTAR';
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
			if (array_key_exists('IDXDAFTAR', $rs))
				ew_AddFilter($where, ew_QuotedName('IDXDAFTAR', $this->DBID) . '=' . ew_QuotedValue($rs['IDXDAFTAR'], $this->IDXDAFTAR->FldDataType, $this->DBID));
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
		return "`IDXDAFTAR` = @IDXDAFTAR@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->IDXDAFTAR->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@IDXDAFTAR@", ew_AdjustSql($this->IDXDAFTAR->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "vw_bridging_sep_by_no_rujukanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_bridging_sep_by_no_rujukanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_bridging_sep_by_no_rujukanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_bridging_sep_by_no_rujukanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_bridging_sep_by_no_rujukanadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_bridging_sep_by_no_rujukanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_bridging_sep_by_no_rujukanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_bridging_sep_by_no_rujukanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_bridging_sep_by_no_rujukandelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "IDXDAFTAR:" . ew_VarToJson($this->IDXDAFTAR->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->IDXDAFTAR->CurrentValue)) {
			$sUrl .= "IDXDAFTAR=" . urlencode($this->IDXDAFTAR->CurrentValue);
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
			if ($isPost && isset($_POST["IDXDAFTAR"]))
				$arKeys[] = ew_StripSlashes($_POST["IDXDAFTAR"]);
			elseif (isset($_GET["IDXDAFTAR"]))
				$arKeys[] = ew_StripSlashes($_GET["IDXDAFTAR"]);
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
			$this->IDXDAFTAR->CurrentValue = $key;
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
		$this->IDXDAFTAR->setDbValue($rs->fields('IDXDAFTAR'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->JAMREG->setDbValue($rs->fields('JAMREG'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
		$this->NOKARTU->setDbValue($rs->fields('NOKARTU'));
		$this->TANGGAL_SEP->setDbValue($rs->fields('TANGGAL_SEP'));
		$this->TANGGALRUJUK_SEP->setDbValue($rs->fields('TANGGALRUJUK_SEP'));
		$this->KELASRAWAT_SEP->setDbValue($rs->fields('KELASRAWAT_SEP'));
		$this->NORUJUKAN_SEP->setDbValue($rs->fields('NORUJUKAN_SEP'));
		$this->PPKPELAYANAN_SEP->setDbValue($rs->fields('PPKPELAYANAN_SEP'));
		$this->JENISPERAWATAN_SEP->setDbValue($rs->fields('JENISPERAWATAN_SEP'));
		$this->CATATAN_SEP->setDbValue($rs->fields('CATATAN_SEP'));
		$this->DIAGNOSAAWAL_SEP->setDbValue($rs->fields('DIAGNOSAAWAL_SEP'));
		$this->NAMADIAGNOSA_SEP->setDbValue($rs->fields('NAMADIAGNOSA_SEP'));
		$this->LAKALANTAS_SEP->setDbValue($rs->fields('LAKALANTAS_SEP'));
		$this->LOKASILAKALANTAS->setDbValue($rs->fields('LOKASILAKALANTAS'));
		$this->USER->setDbValue($rs->fields('USER'));
		$this->generate_sep->setDbValue($rs->fields('generate_sep'));
		$this->PESERTANIK_SEP->setDbValue($rs->fields('PESERTANIK_SEP'));
		$this->PESERTANAMA_SEP->setDbValue($rs->fields('PESERTANAMA_SEP'));
		$this->PESERTAJENISKELAMIN_SEP->setDbValue($rs->fields('PESERTAJENISKELAMIN_SEP'));
		$this->PESERTANAMAKELAS_SEP->setDbValue($rs->fields('PESERTANAMAKELAS_SEP'));
		$this->PESERTAPISAT->setDbValue($rs->fields('PESERTAPISAT'));
		$this->PESERTATGLLAHIR->setDbValue($rs->fields('PESERTATGLLAHIR'));
		$this->PESERTAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTAJENISPESERTA_SEP'));
		$this->PESERTANAMAJENISPESERTA_SEP->setDbValue($rs->fields('PESERTANAMAJENISPESERTA_SEP'));
		$this->POLITUJUAN_SEP->setDbValue($rs->fields('POLITUJUAN_SEP'));
		$this->NAMAPOLITUJUAN_SEP->setDbValue($rs->fields('NAMAPOLITUJUAN_SEP'));
		$this->KDPPKRUJUKAN_SEP->setDbValue($rs->fields('KDPPKRUJUKAN_SEP'));
		$this->NMPPKRUJUKAN_SEP->setDbValue($rs->fields('NMPPKRUJUKAN_SEP'));
		$this->mapingtransaksi->setDbValue($rs->fields('mapingtransaksi'));
		$this->bridging_by_no_rujukan->setDbValue($rs->fields('bridging_by_no_rujukan'));
		$this->bridging_rujukan_faskes_2->setDbValue($rs->fields('bridging_rujukan_faskes_2'));
		$this->pasien_NOTELP->setDbValue($rs->fields('pasien_NOTELP'));
		$this->penjamin_kkl_id->setDbValue($rs->fields('penjamin_kkl_id'));
		$this->asalfaskesrujukan_id->setDbValue($rs->fields('asalfaskesrujukan_id'));
		$this->peserta_cob->setDbValue($rs->fields('peserta_cob'));
		$this->poli_eksekutif->setDbValue($rs->fields('poli_eksekutif'));
		$this->status_kepesertaan_BPJS->setDbValue($rs->fields('status_kepesertaan_BPJS'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// IDXDAFTAR
		// NOMR
		// KDPOLY
		// TGLREG
		// KDCARABAYAR
		// NIP
		// JAMREG
		// NO_SJP
		// NOKARTU
		// TANGGAL_SEP
		// TANGGALRUJUK_SEP
		// KELASRAWAT_SEP
		// NORUJUKAN_SEP
		// PPKPELAYANAN_SEP
		// JENISPERAWATAN_SEP
		// CATATAN_SEP
		// DIAGNOSAAWAL_SEP
		// NAMADIAGNOSA_SEP
		// LAKALANTAS_SEP
		// LOKASILAKALANTAS
		// USER
		// generate_sep
		// PESERTANIK_SEP
		// PESERTANAMA_SEP
		// PESERTAJENISKELAMIN_SEP
		// PESERTANAMAKELAS_SEP
		// PESERTAPISAT
		// PESERTATGLLAHIR
		// PESERTAJENISPESERTA_SEP
		// PESERTANAMAJENISPESERTA_SEP
		// POLITUJUAN_SEP
		// NAMAPOLITUJUAN_SEP
		// KDPPKRUJUKAN_SEP
		// NMPPKRUJUKAN_SEP
		// mapingtransaksi
		// bridging_by_no_rujukan
		// bridging_rujukan_faskes_2
		// pasien_NOTELP
		// penjamin_kkl_id
		// asalfaskesrujukan_id
		// peserta_cob
		// poli_eksekutif
		// status_kepesertaan_BPJS
		// IDXDAFTAR

		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->NOMR->ViewValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->ViewValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// KDPOLY
		$this->KDPOLY->ViewValue = $this->KDPOLY->CurrentValue;
		if (strval($this->KDPOLY->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->KDPOLY->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDPOLY->ViewValue = $this->KDPOLY->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDPOLY->ViewValue = $this->KDPOLY->CurrentValue;
			}
		} else {
			$this->KDPOLY->ViewValue = NULL;
		}
		$this->KDPOLY->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
		if (strval($this->KDCARABAYAR->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->KDCARABAYAR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDCARABAYAR->ViewValue = $this->KDCARABAYAR->CurrentValue;
			}
		} else {
			$this->KDCARABAYAR->ViewValue = NULL;
		}
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->ViewValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->ViewValue = ew_FormatDateTime($this->JAMREG->ViewValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->ViewValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->ViewValue = ew_FormatDateTime($this->TANGGAL_SEP->ViewValue, 5);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->ViewValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->ViewValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->ViewValue, 5);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->ViewValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->ViewValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->ViewValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		if (strval($this->JENISPERAWATAN_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`jeniskeperawatan_id`" . ew_SearchString("=", $this->JENISPERAWATAN_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `jeniskeperawatan_id`, `jeniskeperawatan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskeperawatan`";
		$sWhereWrk = "";
		$this->JENISPERAWATAN_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JENISPERAWATAN_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->CurrentValue;
			}
		} else {
			$this->JENISPERAWATAN_SEP->ViewValue = NULL;
		}
		$this->JENISPERAWATAN_SEP->ViewCustomAttributes = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->ViewValue = $this->CATATAN_SEP->CurrentValue;
		$this->CATATAN_SEP->ViewCustomAttributes = "";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->ViewValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		$this->DIAGNOSAAWAL_SEP->ViewCustomAttributes = "";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->ViewValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->ViewCustomAttributes = "";

		// LAKALANTAS_SEP
		if (strval($this->LAKALANTAS_SEP->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->LAKALANTAS_SEP->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `lakalantas` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_lakalantas`";
		$sWhereWrk = "";
		$this->LAKALANTAS_SEP->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->LAKALANTAS_SEP, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->CurrentValue;
			}
		} else {
			$this->LAKALANTAS_SEP->ViewValue = NULL;
		}
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->ViewValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->ViewValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// generate_sep
		if (strval($this->generate_sep->CurrentValue) <> "") {
			$this->generate_sep->ViewValue = "";
			$arwrk = explode(",", strval($this->generate_sep->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->generate_sep->ViewValue .= $this->generate_sep->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->generate_sep->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->generate_sep->ViewValue = NULL;
		}
		$this->generate_sep->ViewCustomAttributes = "";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->ViewValue = $this->PESERTANIK_SEP->CurrentValue;
		$this->PESERTANIK_SEP->ViewCustomAttributes = "";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->ViewValue = $this->PESERTANAMA_SEP->CurrentValue;
		$this->PESERTANAMA_SEP->ViewCustomAttributes = "";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->ViewValue = $this->PESERTAJENISKELAMIN_SEP->CurrentValue;
		$this->PESERTAJENISKELAMIN_SEP->ViewCustomAttributes = "";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->ViewValue = $this->PESERTANAMAKELAS_SEP->CurrentValue;
		$this->PESERTANAMAKELAS_SEP->ViewCustomAttributes = "";

		// PESERTAPISAT
		$this->PESERTAPISAT->ViewValue = $this->PESERTAPISAT->CurrentValue;
		$this->PESERTAPISAT->ViewCustomAttributes = "";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->ViewValue = $this->PESERTATGLLAHIR->CurrentValue;
		$this->PESERTATGLLAHIR->ViewCustomAttributes = "";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->ViewValue = $this->PESERTAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->ViewValue = $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTANAMAJENISPESERTA_SEP->ViewCustomAttributes = "";

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->ViewValue = $this->POLITUJUAN_SEP->CurrentValue;
		$this->POLITUJUAN_SEP->ViewCustomAttributes = "";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->ViewValue = $this->NAMAPOLITUJUAN_SEP->CurrentValue;
		$this->NAMAPOLITUJUAN_SEP->ViewCustomAttributes = "";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->ViewValue = $this->KDPPKRUJUKAN_SEP->CurrentValue;
		$this->KDPPKRUJUKAN_SEP->ViewCustomAttributes = "";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->ViewValue = $this->NMPPKRUJUKAN_SEP->CurrentValue;
		$this->NMPPKRUJUKAN_SEP->ViewCustomAttributes = "";

		// mapingtransaksi
		if (strval($this->mapingtransaksi->CurrentValue) <> "") {
			$this->mapingtransaksi->ViewValue = "";
			$arwrk = explode(",", strval($this->mapingtransaksi->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->mapingtransaksi->ViewValue .= $this->mapingtransaksi->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->mapingtransaksi->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->mapingtransaksi->ViewValue = NULL;
		}
		$this->mapingtransaksi->ViewCustomAttributes = "";

		// bridging_by_no_rujukan
		if (strval($this->bridging_by_no_rujukan->CurrentValue) <> "") {
			$this->bridging_by_no_rujukan->ViewValue = "";
			$arwrk = explode(",", strval($this->bridging_by_no_rujukan->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->bridging_by_no_rujukan->ViewValue .= $this->bridging_by_no_rujukan->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->bridging_by_no_rujukan->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->bridging_by_no_rujukan->ViewValue = NULL;
		}
		$this->bridging_by_no_rujukan->ViewCustomAttributes = "";

		// bridging_rujukan_faskes_2
		if (strval($this->bridging_rujukan_faskes_2->CurrentValue) <> "") {
			$this->bridging_rujukan_faskes_2->ViewValue = "";
			$arwrk = explode(",", strval($this->bridging_rujukan_faskes_2->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->bridging_rujukan_faskes_2->ViewValue .= $this->bridging_rujukan_faskes_2->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->bridging_rujukan_faskes_2->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->bridging_rujukan_faskes_2->ViewValue = NULL;
		}
		$this->bridging_rujukan_faskes_2->ViewCustomAttributes = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->ViewValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->ViewCustomAttributes = "";

		// penjamin_kkl_id
		if (strval($this->penjamin_kkl_id->CurrentValue) <> "") {
			$this->penjamin_kkl_id->ViewValue = $this->penjamin_kkl_id->OptionCaption($this->penjamin_kkl_id->CurrentValue);
		} else {
			$this->penjamin_kkl_id->ViewValue = NULL;
		}
		$this->penjamin_kkl_id->ViewCustomAttributes = "";

		// asalfaskesrujukan_id
		if (strval($this->asalfaskesrujukan_id->CurrentValue) <> "") {
			$this->asalfaskesrujukan_id->ViewValue = $this->asalfaskesrujukan_id->OptionCaption($this->asalfaskesrujukan_id->CurrentValue);
		} else {
			$this->asalfaskesrujukan_id->ViewValue = NULL;
		}
		$this->asalfaskesrujukan_id->ViewCustomAttributes = "";

		// peserta_cob
		if (strval($this->peserta_cob->CurrentValue) <> "") {
			$this->peserta_cob->ViewValue = $this->peserta_cob->OptionCaption($this->peserta_cob->CurrentValue);
		} else {
			$this->peserta_cob->ViewValue = NULL;
		}
		$this->peserta_cob->ViewCustomAttributes = "";

		// poli_eksekutif
		if (strval($this->poli_eksekutif->CurrentValue) <> "") {
			$this->poli_eksekutif->ViewValue = $this->poli_eksekutif->OptionCaption($this->poli_eksekutif->CurrentValue);
		} else {
			$this->poli_eksekutif->ViewValue = NULL;
		}
		$this->poli_eksekutif->ViewCustomAttributes = "";

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->ViewValue = $this->status_kepesertaan_BPJS->CurrentValue;
		$this->status_kepesertaan_BPJS->ViewCustomAttributes = "";

		// IDXDAFTAR
		$this->IDXDAFTAR->LinkCustomAttributes = "";
		$this->IDXDAFTAR->HrefValue = "";
		$this->IDXDAFTAR->TooltipValue = "";

		// NOMR
		$this->NOMR->LinkCustomAttributes = "";
		$this->NOMR->HrefValue = "";
		$this->NOMR->TooltipValue = "";

		// KDPOLY
		$this->KDPOLY->LinkCustomAttributes = "";
		$this->KDPOLY->HrefValue = "";
		$this->KDPOLY->TooltipValue = "";

		// TGLREG
		$this->TGLREG->LinkCustomAttributes = "";
		$this->TGLREG->HrefValue = "";
		$this->TGLREG->TooltipValue = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->LinkCustomAttributes = "";
		$this->KDCARABAYAR->HrefValue = "";
		$this->KDCARABAYAR->TooltipValue = "";

		// NIP
		$this->NIP->LinkCustomAttributes = "";
		$this->NIP->HrefValue = "";
		$this->NIP->TooltipValue = "";

		// JAMREG
		$this->JAMREG->LinkCustomAttributes = "";
		$this->JAMREG->HrefValue = "";
		$this->JAMREG->TooltipValue = "";

		// NO_SJP
		$this->NO_SJP->LinkCustomAttributes = "";
		$this->NO_SJP->HrefValue = "";
		$this->NO_SJP->TooltipValue = "";

		// NOKARTU
		$this->NOKARTU->LinkCustomAttributes = "";
		$this->NOKARTU->HrefValue = "";
		$this->NOKARTU->TooltipValue = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->LinkCustomAttributes = "";
		$this->TANGGAL_SEP->HrefValue = "";
		$this->TANGGAL_SEP->TooltipValue = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->LinkCustomAttributes = "";
		$this->TANGGALRUJUK_SEP->HrefValue = "";
		$this->TANGGALRUJUK_SEP->TooltipValue = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->LinkCustomAttributes = "";
		$this->KELASRAWAT_SEP->HrefValue = "";
		$this->KELASRAWAT_SEP->TooltipValue = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->LinkCustomAttributes = "";
		$this->NORUJUKAN_SEP->HrefValue = "";
		$this->NORUJUKAN_SEP->TooltipValue = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->LinkCustomAttributes = "";
		$this->PPKPELAYANAN_SEP->HrefValue = "";
		$this->PPKPELAYANAN_SEP->TooltipValue = "";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->LinkCustomAttributes = "";
		$this->JENISPERAWATAN_SEP->HrefValue = "";
		$this->JENISPERAWATAN_SEP->TooltipValue = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->LinkCustomAttributes = "";
		$this->CATATAN_SEP->HrefValue = "";
		$this->CATATAN_SEP->TooltipValue = "";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->LinkCustomAttributes = "";
		$this->DIAGNOSAAWAL_SEP->HrefValue = "";
		$this->DIAGNOSAAWAL_SEP->TooltipValue = "";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->LinkCustomAttributes = "";
		$this->NAMADIAGNOSA_SEP->HrefValue = "";
		$this->NAMADIAGNOSA_SEP->TooltipValue = "";

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->LinkCustomAttributes = "";
		$this->LAKALANTAS_SEP->HrefValue = "";
		$this->LAKALANTAS_SEP->TooltipValue = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->LinkCustomAttributes = "";
		$this->LOKASILAKALANTAS->HrefValue = "";
		$this->LOKASILAKALANTAS->TooltipValue = "";

		// USER
		$this->USER->LinkCustomAttributes = "";
		$this->USER->HrefValue = "";
		$this->USER->TooltipValue = "";

		// generate_sep
		$this->generate_sep->LinkCustomAttributes = "";
		$this->generate_sep->HrefValue = "";
		$this->generate_sep->TooltipValue = "";

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->LinkCustomAttributes = "";
		$this->PESERTANIK_SEP->HrefValue = "";
		$this->PESERTANIK_SEP->TooltipValue = "";

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->LinkCustomAttributes = "";
		$this->PESERTANAMA_SEP->HrefValue = "";
		$this->PESERTANAMA_SEP->TooltipValue = "";

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->LinkCustomAttributes = "";
		$this->PESERTAJENISKELAMIN_SEP->HrefValue = "";
		$this->PESERTAJENISKELAMIN_SEP->TooltipValue = "";

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->LinkCustomAttributes = "";
		$this->PESERTANAMAKELAS_SEP->HrefValue = "";
		$this->PESERTANAMAKELAS_SEP->TooltipValue = "";

		// PESERTAPISAT
		$this->PESERTAPISAT->LinkCustomAttributes = "";
		$this->PESERTAPISAT->HrefValue = "";
		$this->PESERTAPISAT->TooltipValue = "";

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->LinkCustomAttributes = "";
		$this->PESERTATGLLAHIR->HrefValue = "";
		$this->PESERTATGLLAHIR->TooltipValue = "";

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->LinkCustomAttributes = "";
		$this->PESERTAJENISPESERTA_SEP->HrefValue = "";
		$this->PESERTAJENISPESERTA_SEP->TooltipValue = "";

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->LinkCustomAttributes = "";
		$this->PESERTANAMAJENISPESERTA_SEP->HrefValue = "";
		$this->PESERTANAMAJENISPESERTA_SEP->TooltipValue = "";

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->LinkCustomAttributes = "";
		$this->POLITUJUAN_SEP->HrefValue = "";
		$this->POLITUJUAN_SEP->TooltipValue = "";

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->LinkCustomAttributes = "";
		$this->NAMAPOLITUJUAN_SEP->HrefValue = "";
		$this->NAMAPOLITUJUAN_SEP->TooltipValue = "";

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->LinkCustomAttributes = "";
		$this->KDPPKRUJUKAN_SEP->HrefValue = "";
		$this->KDPPKRUJUKAN_SEP->TooltipValue = "";

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->LinkCustomAttributes = "";
		$this->NMPPKRUJUKAN_SEP->HrefValue = "";
		$this->NMPPKRUJUKAN_SEP->TooltipValue = "";

		// mapingtransaksi
		$this->mapingtransaksi->LinkCustomAttributes = "";
		$this->mapingtransaksi->HrefValue = "";
		$this->mapingtransaksi->TooltipValue = "";

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->LinkCustomAttributes = "";
		$this->bridging_by_no_rujukan->HrefValue = "";
		$this->bridging_by_no_rujukan->TooltipValue = "";

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->LinkCustomAttributes = "";
		$this->bridging_rujukan_faskes_2->HrefValue = "";
		$this->bridging_rujukan_faskes_2->TooltipValue = "";

		// pasien_NOTELP
		$this->pasien_NOTELP->LinkCustomAttributes = "";
		$this->pasien_NOTELP->HrefValue = "";
		$this->pasien_NOTELP->TooltipValue = "";

		// penjamin_kkl_id
		$this->penjamin_kkl_id->LinkCustomAttributes = "";
		$this->penjamin_kkl_id->HrefValue = "";
		$this->penjamin_kkl_id->TooltipValue = "";

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->LinkCustomAttributes = "";
		$this->asalfaskesrujukan_id->HrefValue = "";
		$this->asalfaskesrujukan_id->TooltipValue = "";

		// peserta_cob
		$this->peserta_cob->LinkCustomAttributes = "";
		$this->peserta_cob->HrefValue = "";
		$this->peserta_cob->TooltipValue = "";

		// poli_eksekutif
		$this->poli_eksekutif->LinkCustomAttributes = "";
		$this->poli_eksekutif->HrefValue = "";
		$this->poli_eksekutif->TooltipValue = "";

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->LinkCustomAttributes = "";
		$this->status_kepesertaan_BPJS->HrefValue = "";
		$this->status_kepesertaan_BPJS->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// IDXDAFTAR
		$this->IDXDAFTAR->EditAttrs["class"] = "form-control";
		$this->IDXDAFTAR->EditCustomAttributes = "";
		$this->IDXDAFTAR->EditValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->EditAttrs["class"] = "form-control";
		$this->NOMR->EditCustomAttributes = "";
		$this->NOMR->EditValue = $this->NOMR->CurrentValue;
		if (strval($this->NOMR->CurrentValue) <> "") {
			$sFilterWrk = "`NOMR`" . ew_SearchString("=", $this->NOMR->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NOMR`, `NOMR` AS `DispFld`, `NAMA` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_pasien`";
		$sWhereWrk = "";
		$this->NOMR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NOMR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->NOMR->EditValue = $this->NOMR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NOMR->EditValue = $this->NOMR->CurrentValue;
			}
		} else {
			$this->NOMR->EditValue = NULL;
		}
		$this->NOMR->ViewCustomAttributes = "";

		// KDPOLY
		$this->KDPOLY->EditAttrs["class"] = "form-control";
		$this->KDPOLY->EditCustomAttributes = "";
		$this->KDPOLY->EditValue = $this->KDPOLY->CurrentValue;
		if (strval($this->KDPOLY->CurrentValue) <> "") {
			$sFilterWrk = "`kode`" . ew_SearchString("=", $this->KDPOLY->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `kode`, `nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_poly`";
		$sWhereWrk = "";
		$this->KDPOLY->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDPOLY, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDPOLY->EditValue = $this->KDPOLY->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDPOLY->EditValue = $this->KDPOLY->CurrentValue;
			}
		} else {
			$this->KDPOLY->EditValue = NULL;
		}
		$this->KDPOLY->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->EditAttrs["class"] = "form-control";
		$this->TGLREG->EditCustomAttributes = "";
		$this->TGLREG->EditValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->EditValue = ew_FormatDateTime($this->TGLREG->EditValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
		$this->KDCARABAYAR->EditCustomAttributes = "";
		$this->KDCARABAYAR->EditValue = $this->KDCARABAYAR->CurrentValue;
		if (strval($this->KDCARABAYAR->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDCARABAYAR->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_carabayar`";
		$sWhereWrk = "";
		$this->KDCARABAYAR->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDCARABAYAR, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDCARABAYAR->EditValue = $this->KDCARABAYAR->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDCARABAYAR->EditValue = $this->KDCARABAYAR->CurrentValue;
			}
		} else {
			$this->KDCARABAYAR->EditValue = NULL;
		}
		$this->KDCARABAYAR->ViewCustomAttributes = "";

		// NIP
		$this->NIP->EditAttrs["class"] = "form-control";
		$this->NIP->EditCustomAttributes = "";
		$this->NIP->EditValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->EditAttrs["class"] = "form-control";
		$this->JAMREG->EditCustomAttributes = "";
		$this->JAMREG->EditValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->EditValue = ew_FormatDateTime($this->JAMREG->EditValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->EditAttrs["class"] = "form-control";
		$this->NO_SJP->EditCustomAttributes = "";
		$this->NO_SJP->EditValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->PlaceHolder = ew_RemoveHtml($this->NO_SJP->FldCaption());

		// NOKARTU
		$this->NOKARTU->EditAttrs["class"] = "form-control";
		$this->NOKARTU->EditCustomAttributes = "";
		$this->NOKARTU->EditValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->PlaceHolder = ew_RemoveHtml($this->NOKARTU->FldCaption());

		// TANGGAL_SEP
		$this->TANGGAL_SEP->EditAttrs["class"] = "form-control";
		$this->TANGGAL_SEP->EditCustomAttributes = "";
		$this->TANGGAL_SEP->EditValue = ew_FormatDateTime($this->TANGGAL_SEP->CurrentValue, 5);
		$this->TANGGAL_SEP->PlaceHolder = ew_RemoveHtml($this->TANGGAL_SEP->FldCaption());

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->EditAttrs["class"] = "form-control";
		$this->TANGGALRUJUK_SEP->EditCustomAttributes = "";
		$this->TANGGALRUJUK_SEP->EditValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->CurrentValue, 5);
		$this->TANGGALRUJUK_SEP->PlaceHolder = ew_RemoveHtml($this->TANGGALRUJUK_SEP->FldCaption());

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->EditAttrs["class"] = "form-control";
		$this->KELASRAWAT_SEP->EditCustomAttributes = "";
		$this->KELASRAWAT_SEP->EditValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->PlaceHolder = ew_RemoveHtml($this->KELASRAWAT_SEP->FldCaption());

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->EditAttrs["class"] = "form-control";
		$this->NORUJUKAN_SEP->EditCustomAttributes = "";
		$this->NORUJUKAN_SEP->EditValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->PlaceHolder = ew_RemoveHtml($this->NORUJUKAN_SEP->FldCaption());

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->EditAttrs["class"] = "form-control";
		$this->PPKPELAYANAN_SEP->EditCustomAttributes = "";
		$this->PPKPELAYANAN_SEP->EditValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->PlaceHolder = ew_RemoveHtml($this->PPKPELAYANAN_SEP->FldCaption());

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->EditAttrs["class"] = "form-control";
		$this->JENISPERAWATAN_SEP->EditCustomAttributes = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->EditAttrs["class"] = "form-control";
		$this->CATATAN_SEP->EditCustomAttributes = "";
		$this->CATATAN_SEP->EditValue = $this->CATATAN_SEP->CurrentValue;
		$this->CATATAN_SEP->PlaceHolder = ew_RemoveHtml($this->CATATAN_SEP->FldCaption());

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->EditAttrs["class"] = "form-control";
		$this->DIAGNOSAAWAL_SEP->EditCustomAttributes = "";
		$this->DIAGNOSAAWAL_SEP->EditValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		$this->DIAGNOSAAWAL_SEP->PlaceHolder = ew_RemoveHtml($this->DIAGNOSAAWAL_SEP->FldCaption());

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->EditAttrs["class"] = "form-control";
		$this->NAMADIAGNOSA_SEP->EditCustomAttributes = "";
		$this->NAMADIAGNOSA_SEP->EditValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->PlaceHolder = ew_RemoveHtml($this->NAMADIAGNOSA_SEP->FldCaption());

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->EditCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->EditAttrs["class"] = "form-control";
		$this->LOKASILAKALANTAS->EditCustomAttributes = "";
		$this->LOKASILAKALANTAS->EditValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->PlaceHolder = ew_RemoveHtml($this->LOKASILAKALANTAS->FldCaption());

		// USER
		$this->USER->EditAttrs["class"] = "form-control";
		$this->USER->EditCustomAttributes = "";
		$this->USER->EditValue = $this->USER->CurrentValue;
		$this->USER->PlaceHolder = ew_RemoveHtml($this->USER->FldCaption());

		// generate_sep
		$this->generate_sep->EditCustomAttributes = "";
		$this->generate_sep->EditValue = $this->generate_sep->Options(FALSE);

		// PESERTANIK_SEP
		$this->PESERTANIK_SEP->EditAttrs["class"] = "form-control";
		$this->PESERTANIK_SEP->EditCustomAttributes = "";
		$this->PESERTANIK_SEP->EditValue = $this->PESERTANIK_SEP->CurrentValue;
		$this->PESERTANIK_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANIK_SEP->FldCaption());

		// PESERTANAMA_SEP
		$this->PESERTANAMA_SEP->EditAttrs["class"] = "form-control";
		$this->PESERTANAMA_SEP->EditCustomAttributes = "";
		$this->PESERTANAMA_SEP->EditValue = $this->PESERTANAMA_SEP->CurrentValue;
		$this->PESERTANAMA_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANAMA_SEP->FldCaption());

		// PESERTAJENISKELAMIN_SEP
		$this->PESERTAJENISKELAMIN_SEP->EditAttrs["class"] = "form-control";
		$this->PESERTAJENISKELAMIN_SEP->EditCustomAttributes = "";
		$this->PESERTAJENISKELAMIN_SEP->EditValue = $this->PESERTAJENISKELAMIN_SEP->CurrentValue;
		$this->PESERTAJENISKELAMIN_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTAJENISKELAMIN_SEP->FldCaption());

		// PESERTANAMAKELAS_SEP
		$this->PESERTANAMAKELAS_SEP->EditAttrs["class"] = "form-control";
		$this->PESERTANAMAKELAS_SEP->EditCustomAttributes = "";
		$this->PESERTANAMAKELAS_SEP->EditValue = $this->PESERTANAMAKELAS_SEP->CurrentValue;
		$this->PESERTANAMAKELAS_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANAMAKELAS_SEP->FldCaption());

		// PESERTAPISAT
		$this->PESERTAPISAT->EditAttrs["class"] = "form-control";
		$this->PESERTAPISAT->EditCustomAttributes = "";
		$this->PESERTAPISAT->EditValue = $this->PESERTAPISAT->CurrentValue;
		$this->PESERTAPISAT->PlaceHolder = ew_RemoveHtml($this->PESERTAPISAT->FldCaption());

		// PESERTATGLLAHIR
		$this->PESERTATGLLAHIR->EditAttrs["class"] = "form-control";
		$this->PESERTATGLLAHIR->EditCustomAttributes = "";
		$this->PESERTATGLLAHIR->EditValue = $this->PESERTATGLLAHIR->CurrentValue;
		$this->PESERTATGLLAHIR->PlaceHolder = ew_RemoveHtml($this->PESERTATGLLAHIR->FldCaption());

		// PESERTAJENISPESERTA_SEP
		$this->PESERTAJENISPESERTA_SEP->EditAttrs["class"] = "form-control";
		$this->PESERTAJENISPESERTA_SEP->EditCustomAttributes = "";
		$this->PESERTAJENISPESERTA_SEP->EditValue = $this->PESERTAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTAJENISPESERTA_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTAJENISPESERTA_SEP->FldCaption());

		// PESERTANAMAJENISPESERTA_SEP
		$this->PESERTANAMAJENISPESERTA_SEP->EditAttrs["class"] = "form-control";
		$this->PESERTANAMAJENISPESERTA_SEP->EditCustomAttributes = "";
		$this->PESERTANAMAJENISPESERTA_SEP->EditValue = $this->PESERTANAMAJENISPESERTA_SEP->CurrentValue;
		$this->PESERTANAMAJENISPESERTA_SEP->PlaceHolder = ew_RemoveHtml($this->PESERTANAMAJENISPESERTA_SEP->FldCaption());

		// POLITUJUAN_SEP
		$this->POLITUJUAN_SEP->EditAttrs["class"] = "form-control";
		$this->POLITUJUAN_SEP->EditCustomAttributes = "";
		$this->POLITUJUAN_SEP->EditValue = $this->POLITUJUAN_SEP->CurrentValue;
		$this->POLITUJUAN_SEP->PlaceHolder = ew_RemoveHtml($this->POLITUJUAN_SEP->FldCaption());

		// NAMAPOLITUJUAN_SEP
		$this->NAMAPOLITUJUAN_SEP->EditAttrs["class"] = "form-control";
		$this->NAMAPOLITUJUAN_SEP->EditCustomAttributes = "";
		$this->NAMAPOLITUJUAN_SEP->EditValue = $this->NAMAPOLITUJUAN_SEP->CurrentValue;
		$this->NAMAPOLITUJUAN_SEP->PlaceHolder = ew_RemoveHtml($this->NAMAPOLITUJUAN_SEP->FldCaption());

		// KDPPKRUJUKAN_SEP
		$this->KDPPKRUJUKAN_SEP->EditAttrs["class"] = "form-control";
		$this->KDPPKRUJUKAN_SEP->EditCustomAttributes = "";
		$this->KDPPKRUJUKAN_SEP->EditValue = $this->KDPPKRUJUKAN_SEP->CurrentValue;
		$this->KDPPKRUJUKAN_SEP->PlaceHolder = ew_RemoveHtml($this->KDPPKRUJUKAN_SEP->FldCaption());

		// NMPPKRUJUKAN_SEP
		$this->NMPPKRUJUKAN_SEP->EditAttrs["class"] = "form-control";
		$this->NMPPKRUJUKAN_SEP->EditCustomAttributes = "";
		$this->NMPPKRUJUKAN_SEP->EditValue = $this->NMPPKRUJUKAN_SEP->CurrentValue;
		$this->NMPPKRUJUKAN_SEP->PlaceHolder = ew_RemoveHtml($this->NMPPKRUJUKAN_SEP->FldCaption());

		// mapingtransaksi
		$this->mapingtransaksi->EditCustomAttributes = "";
		$this->mapingtransaksi->EditValue = $this->mapingtransaksi->Options(FALSE);

		// bridging_by_no_rujukan
		$this->bridging_by_no_rujukan->EditCustomAttributes = "";
		$this->bridging_by_no_rujukan->EditValue = $this->bridging_by_no_rujukan->Options(FALSE);

		// bridging_rujukan_faskes_2
		$this->bridging_rujukan_faskes_2->EditCustomAttributes = "";
		$this->bridging_rujukan_faskes_2->EditValue = $this->bridging_rujukan_faskes_2->Options(FALSE);

		// pasien_NOTELP
		$this->pasien_NOTELP->EditAttrs["class"] = "form-control";
		$this->pasien_NOTELP->EditCustomAttributes = "";
		$this->pasien_NOTELP->EditValue = $this->pasien_NOTELP->CurrentValue;
		$this->pasien_NOTELP->PlaceHolder = ew_RemoveHtml($this->pasien_NOTELP->FldCaption());

		// penjamin_kkl_id
		$this->penjamin_kkl_id->EditAttrs["class"] = "form-control";
		$this->penjamin_kkl_id->EditCustomAttributes = "";
		$this->penjamin_kkl_id->EditValue = $this->penjamin_kkl_id->Options(TRUE);

		// asalfaskesrujukan_id
		$this->asalfaskesrujukan_id->EditAttrs["class"] = "form-control";
		$this->asalfaskesrujukan_id->EditCustomAttributes = "";
		$this->asalfaskesrujukan_id->EditValue = $this->asalfaskesrujukan_id->Options(TRUE);

		// peserta_cob
		$this->peserta_cob->EditAttrs["class"] = "form-control";
		$this->peserta_cob->EditCustomAttributes = "";
		$this->peserta_cob->EditValue = $this->peserta_cob->Options(TRUE);

		// poli_eksekutif
		$this->poli_eksekutif->EditAttrs["class"] = "form-control";
		$this->poli_eksekutif->EditCustomAttributes = "";
		$this->poli_eksekutif->EditValue = $this->poli_eksekutif->Options(TRUE);

		// status_kepesertaan_BPJS
		$this->status_kepesertaan_BPJS->EditAttrs["class"] = "form-control";
		$this->status_kepesertaan_BPJS->EditCustomAttributes = "";
		$this->status_kepesertaan_BPJS->EditValue = $this->status_kepesertaan_BPJS->CurrentValue;
		$this->status_kepesertaan_BPJS->PlaceHolder = ew_RemoveHtml($this->status_kepesertaan_BPJS->FldCaption());

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
					if ($this->pasien_NOTELP->Exportable) $Doc->ExportCaption($this->pasien_NOTELP);
					if ($this->penjamin_kkl_id->Exportable) $Doc->ExportCaption($this->penjamin_kkl_id);
					if ($this->asalfaskesrujukan_id->Exportable) $Doc->ExportCaption($this->asalfaskesrujukan_id);
					if ($this->peserta_cob->Exportable) $Doc->ExportCaption($this->peserta_cob);
					if ($this->poli_eksekutif->Exportable) $Doc->ExportCaption($this->poli_eksekutif);
					if ($this->status_kepesertaan_BPJS->Exportable) $Doc->ExportCaption($this->status_kepesertaan_BPJS);
				} else {
					if ($this->pasien_NOTELP->Exportable) $Doc->ExportCaption($this->pasien_NOTELP);
					if ($this->penjamin_kkl_id->Exportable) $Doc->ExportCaption($this->penjamin_kkl_id);
					if ($this->asalfaskesrujukan_id->Exportable) $Doc->ExportCaption($this->asalfaskesrujukan_id);
					if ($this->peserta_cob->Exportable) $Doc->ExportCaption($this->peserta_cob);
					if ($this->poli_eksekutif->Exportable) $Doc->ExportCaption($this->poli_eksekutif);
					if ($this->status_kepesertaan_BPJS->Exportable) $Doc->ExportCaption($this->status_kepesertaan_BPJS);
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
						if ($this->pasien_NOTELP->Exportable) $Doc->ExportField($this->pasien_NOTELP);
						if ($this->penjamin_kkl_id->Exportable) $Doc->ExportField($this->penjamin_kkl_id);
						if ($this->asalfaskesrujukan_id->Exportable) $Doc->ExportField($this->asalfaskesrujukan_id);
						if ($this->peserta_cob->Exportable) $Doc->ExportField($this->peserta_cob);
						if ($this->poli_eksekutif->Exportable) $Doc->ExportField($this->poli_eksekutif);
						if ($this->status_kepesertaan_BPJS->Exportable) $Doc->ExportField($this->status_kepesertaan_BPJS);
					} else {
						if ($this->pasien_NOTELP->Exportable) $Doc->ExportField($this->pasien_NOTELP);
						if ($this->penjamin_kkl_id->Exportable) $Doc->ExportField($this->penjamin_kkl_id);
						if ($this->asalfaskesrujukan_id->Exportable) $Doc->ExportField($this->asalfaskesrujukan_id);
						if ($this->peserta_cob->Exportable) $Doc->ExportField($this->peserta_cob);
						if ($this->poli_eksekutif->Exportable) $Doc->ExportField($this->poli_eksekutif);
						if ($this->status_kepesertaan_BPJS->Exportable) $Doc->ExportField($this->status_kepesertaan_BPJS);
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

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'vw_bridging_sep_by_no_rujukan';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'vw_bridging_sep_by_no_rujukan';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['IDXDAFTAR'];

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
		$table = 'vw_bridging_sep_by_no_rujukan';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['IDXDAFTAR'];

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
		$table = 'vw_bridging_sep_by_no_rujukan';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['IDXDAFTAR'];

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
		ew_AddFilter($filter, "TGLREG = CURDATE() AND KDCARABAYAR != 1 AND KDCARABAYAR != 9 AND KDCARABAYAR != 7  "); 
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
		//ew_Execute("call simrs2012.sp_simpan_sep('".$rsnew["JENISPERAWATAN_SEP"]."', '".$rsold["IDXDAFTAR"]."')");

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

		$this->PPKPELAYANAN_SEP->ReadOnly = TRUE;
		$this->USER->EditValue = CurrentUserName();  
		$this->USER->ReadOnly = TRUE;  
		$this->NO_SJP->ReadOnly = TRUE;
		$this->USER->EditValue = CurrentUserName();
		$this->KELASRAWAT_SEP->ReadOnly = TRUE;  
		$this->PESERTANIK_SEP->ReadOnly = TRUE; 
		$this->PESERTANAMA_SEP->ReadOnly = TRUE;   
		$this->PESERTAJENISKELAMIN_SEP->ReadOnly = TRUE;
		$this->PESERTANAMAKELAS_SEP->ReadOnly = TRUE;
		$this->NOKARTU->ReadOnly = TRUE; 
		$this->PESERTAJENISPESERTA_SEP->ReadOnly = TRUE;
		$this->KDPPKRUJUKAN_SEP->ReadOnly = TRUE; 
		$this->PESERTAPISAT->ReadOnly = TRUE;    
		$this->PESERTATGLLAHIR->ReadOnly = TRUE;  
		$this->PESERTANAMAJENISPESERTA_SEP->ReadOnly = TRUE;
		$this->NAMAPOLITUJUAN_SEP->ReadOnly = TRUE; 
		$this->NMPPKRUJUKAN_SEP->ReadOnly = TRUE;
			$this->PPKPELAYANAN_SEP->EditValue =  '1111R010'; 
		$this->TANGGALRUJUK_SEP->ReadOnly = TRUE;  
		$this->POLITUJUAN_SEP->ReadOnly = TRUE;  
		$this->DIAGNOSAAWAL_SEP->ReadOnly = TRUE;  
		$this->NAMADIAGNOSA_SEP->ReadOnly = TRUE;
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
