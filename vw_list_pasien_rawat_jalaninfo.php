<?php

// Global variable for table object
$vw_list_pasien_rawat_jalan = NULL;

//
// Table class for vw_list_pasien_rawat_jalan
//
class cvw_list_pasien_rawat_jalan extends cTable {
	var $IDXDAFTAR;
	var $TGLREG;
	var $NOMR;
	var $KETERANGAN;
	var $NOKARTU_BPJS;
	var $NOKTP;
	var $KDDOKTER;
	var $KDPOLY;
	var $KDRUJUK;
	var $KDCARABAYAR;
	var $NOJAMINAN;
	var $SHIFT;
	var $STATUS;
	var $KETERANGAN_STATUS;
	var $PASIENBARU;
	var $NIP;
	var $MASUKPOLY;
	var $KELUARPOLY;
	var $KETRUJUK;
	var $KETBAYAR;
	var $PENANGGUNGJAWAB_NAMA;
	var $PENANGGUNGJAWAB_HUBUNGAN;
	var $PENANGGUNGJAWAB_ALAMAT;
	var $PENANGGUNGJAWAB_PHONE;
	var $JAMREG;
	var $BATAL;
	var $NO_SJP;
	var $NO_PESERTA;
	var $NOKARTU;
	var $TANGGAL_SEP;
	var $TANGGALRUJUK_SEP;
	var $KELASRAWAT_SEP;
	var $MINTA_RUJUKAN;
	var $NORUJUKAN_SEP;
	var $PPKRUJUKANASAL_SEP;
	var $NAMAPPKRUJUKANASAL_SEP;
	var $PPKPELAYANAN_SEP;
	var $JENISPERAWATAN_SEP;
	var $CATATAN_SEP;
	var $DIAGNOSAAWAL_SEP;
	var $NAMADIAGNOSA_SEP;
	var $LAKALANTAS_SEP;
	var $LOKASILAKALANTAS;
	var $USER;
	var $tanggal;
	var $bulan;
	var $tahun;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'vw_list_pasien_rawat_jalan';
		$this->TableName = 'vw_list_pasien_rawat_jalan';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`vw_list_pasien_rawat_jalan`";
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
		$this->IDXDAFTAR = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_IDXDAFTAR', 'IDXDAFTAR', '`IDXDAFTAR`', '`IDXDAFTAR`', 3, -1, FALSE, '`IDXDAFTAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IDXDAFTAR->Sortable = TRUE; // Allow sort
		$this->IDXDAFTAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IDXDAFTAR'] = &$this->IDXDAFTAR;

		// TGLREG
		$this->TGLREG = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_TGLREG', 'TGLREG', '`TGLREG`', ew_CastDateFieldForLike('`TGLREG`', 0, "DB"), 133, 0, FALSE, '`TGLREG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGLREG->Sortable = TRUE; // Allow sort
		$this->TGLREG->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TGLREG'] = &$this->TGLREG;

		// NOMR
		$this->NOMR = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NOMR', 'NOMR', '`NOMR`', '`NOMR`', 200, -1, FALSE, '`NOMR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOMR->Sortable = TRUE; // Allow sort
		$this->fields['NOMR'] = &$this->NOMR;

		// KETERANGAN
		$this->KETERANGAN = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KETERANGAN', 'KETERANGAN', '`KETERANGAN`', '`KETERANGAN`', 200, -1, FALSE, '`KETERANGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETERANGAN->Sortable = TRUE; // Allow sort
		$this->fields['KETERANGAN'] = &$this->KETERANGAN;

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NOKARTU_BPJS', 'NOKARTU_BPJS', '`NOKARTU_BPJS`', '`NOKARTU_BPJS`', 200, -1, FALSE, '`NOKARTU_BPJS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKARTU_BPJS->Sortable = TRUE; // Allow sort
		$this->fields['NOKARTU_BPJS'] = &$this->NOKARTU_BPJS;

		// NOKTP
		$this->NOKTP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NOKTP', 'NOKTP', '`NOKTP`', '`NOKTP`', 200, -1, FALSE, '`NOKTP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKTP->Sortable = TRUE; // Allow sort
		$this->fields['NOKTP'] = &$this->NOKTP;

		// KDDOKTER
		$this->KDDOKTER = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KDDOKTER', 'KDDOKTER', '`KDDOKTER`', '`KDDOKTER`', 3, -1, FALSE, '`KDDOKTER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDDOKTER->Sortable = TRUE; // Allow sort
		$this->KDDOKTER->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDDOKTER'] = &$this->KDDOKTER;

		// KDPOLY
		$this->KDPOLY = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KDPOLY', 'KDPOLY', '`KDPOLY`', '`KDPOLY`', 3, -1, FALSE, '`KDPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDPOLY->Sortable = TRUE; // Allow sort
		$this->KDPOLY->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDPOLY->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDPOLY->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDPOLY'] = &$this->KDPOLY;

		// KDRUJUK
		$this->KDRUJUK = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KDRUJUK', 'KDRUJUK', '`KDRUJUK`', '`KDRUJUK`', 3, -1, FALSE, '`KDRUJUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDRUJUK->Sortable = TRUE; // Allow sort
		$this->KDRUJUK->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDRUJUK'] = &$this->KDRUJUK;

		// KDCARABAYAR
		$this->KDCARABAYAR = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KDCARABAYAR', 'KDCARABAYAR', '`KDCARABAYAR`', '`KDCARABAYAR`', 3, -1, FALSE, '`KDCARABAYAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KDCARABAYAR->Sortable = TRUE; // Allow sort
		$this->KDCARABAYAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDCARABAYAR'] = &$this->KDCARABAYAR;

		// NOJAMINAN
		$this->NOJAMINAN = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NOJAMINAN', 'NOJAMINAN', '`NOJAMINAN`', '`NOJAMINAN`', 200, -1, FALSE, '`NOJAMINAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOJAMINAN->Sortable = TRUE; // Allow sort
		$this->fields['NOJAMINAN'] = &$this->NOJAMINAN;

		// SHIFT
		$this->SHIFT = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_SHIFT', 'SHIFT', '`SHIFT`', '`SHIFT`', 3, -1, FALSE, '`SHIFT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SHIFT->Sortable = TRUE; // Allow sort
		$this->SHIFT->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['SHIFT'] = &$this->SHIFT;

		// STATUS
		$this->STATUS = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_STATUS', 'STATUS', '`STATUS`', '`STATUS`', 3, -1, FALSE, '`STATUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->STATUS->Sortable = TRUE; // Allow sort
		$this->STATUS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['STATUS'] = &$this->STATUS;

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KETERANGAN_STATUS', 'KETERANGAN_STATUS', '`KETERANGAN_STATUS`', '`KETERANGAN_STATUS`', 2, -1, FALSE, '`KETERANGAN_STATUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETERANGAN_STATUS->Sortable = TRUE; // Allow sort
		$this->KETERANGAN_STATUS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KETERANGAN_STATUS'] = &$this->KETERANGAN_STATUS;

		// PASIENBARU
		$this->PASIENBARU = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_PASIENBARU', 'PASIENBARU', '`PASIENBARU`', '`PASIENBARU`', 3, -1, FALSE, '`PASIENBARU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PASIENBARU->Sortable = TRUE; // Allow sort
		$this->PASIENBARU->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['PASIENBARU'] = &$this->PASIENBARU;

		// NIP
		$this->NIP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = TRUE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// MASUKPOLY
		$this->MASUKPOLY = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_MASUKPOLY', 'MASUKPOLY', '`MASUKPOLY`', ew_CastDateFieldForLike('`MASUKPOLY`', 4, "DB"), 134, 4, FALSE, '`MASUKPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MASUKPOLY->Sortable = TRUE; // Allow sort
		$this->MASUKPOLY->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_TIME_SEPARATOR"], $Language->Phrase("IncorrectTime"));
		$this->fields['MASUKPOLY'] = &$this->MASUKPOLY;

		// KELUARPOLY
		$this->KELUARPOLY = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KELUARPOLY', 'KELUARPOLY', '`KELUARPOLY`', ew_CastDateFieldForLike('`KELUARPOLY`', 4, "DB"), 134, 4, FALSE, '`KELUARPOLY`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELUARPOLY->Sortable = TRUE; // Allow sort
		$this->KELUARPOLY->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_TIME_SEPARATOR"], $Language->Phrase("IncorrectTime"));
		$this->fields['KELUARPOLY'] = &$this->KELUARPOLY;

		// KETRUJUK
		$this->KETRUJUK = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KETRUJUK', 'KETRUJUK', '`KETRUJUK`', '`KETRUJUK`', 200, -1, FALSE, '`KETRUJUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETRUJUK->Sortable = TRUE; // Allow sort
		$this->fields['KETRUJUK'] = &$this->KETRUJUK;

		// KETBAYAR
		$this->KETBAYAR = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KETBAYAR', 'KETBAYAR', '`KETBAYAR`', '`KETBAYAR`', 200, -1, FALSE, '`KETBAYAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KETBAYAR->Sortable = TRUE; // Allow sort
		$this->fields['KETBAYAR'] = &$this->KETBAYAR;

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_PENANGGUNGJAWAB_NAMA', 'PENANGGUNGJAWAB_NAMA', '`PENANGGUNGJAWAB_NAMA`', '`PENANGGUNGJAWAB_NAMA`', 200, -1, FALSE, '`PENANGGUNGJAWAB_NAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_NAMA->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_NAMA'] = &$this->PENANGGUNGJAWAB_NAMA;

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_PENANGGUNGJAWAB_HUBUNGAN', 'PENANGGUNGJAWAB_HUBUNGAN', '`PENANGGUNGJAWAB_HUBUNGAN`', '`PENANGGUNGJAWAB_HUBUNGAN`', 200, -1, FALSE, '`PENANGGUNGJAWAB_HUBUNGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_HUBUNGAN->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_HUBUNGAN'] = &$this->PENANGGUNGJAWAB_HUBUNGAN;

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_PENANGGUNGJAWAB_ALAMAT', 'PENANGGUNGJAWAB_ALAMAT', '`PENANGGUNGJAWAB_ALAMAT`', '`PENANGGUNGJAWAB_ALAMAT`', 200, -1, FALSE, '`PENANGGUNGJAWAB_ALAMAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_ALAMAT->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_ALAMAT'] = &$this->PENANGGUNGJAWAB_ALAMAT;

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_PENANGGUNGJAWAB_PHONE', 'PENANGGUNGJAWAB_PHONE', '`PENANGGUNGJAWAB_PHONE`', '`PENANGGUNGJAWAB_PHONE`', 200, -1, FALSE, '`PENANGGUNGJAWAB_PHONE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_PHONE->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_PHONE'] = &$this->PENANGGUNGJAWAB_PHONE;

		// JAMREG
		$this->JAMREG = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_JAMREG', 'JAMREG', '`JAMREG`', ew_CastDateFieldForLike('`JAMREG`', 0, "DB"), 135, 0, FALSE, '`JAMREG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JAMREG->Sortable = TRUE; // Allow sort
		$this->JAMREG->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['JAMREG'] = &$this->JAMREG;

		// BATAL
		$this->BATAL = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_BATAL', 'BATAL', '`BATAL`', '`BATAL`', 200, -1, FALSE, '`BATAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BATAL->Sortable = TRUE; // Allow sort
		$this->fields['BATAL'] = &$this->BATAL;

		// NO_SJP
		$this->NO_SJP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NO_SJP', 'NO_SJP', '`NO_SJP`', '`NO_SJP`', 200, -1, FALSE, '`NO_SJP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_SJP->Sortable = TRUE; // Allow sort
		$this->fields['NO_SJP'] = &$this->NO_SJP;

		// NO_PESERTA
		$this->NO_PESERTA = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NO_PESERTA', 'NO_PESERTA', '`NO_PESERTA`', '`NO_PESERTA`', 200, -1, FALSE, '`NO_PESERTA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_PESERTA->Sortable = TRUE; // Allow sort
		$this->fields['NO_PESERTA'] = &$this->NO_PESERTA;

		// NOKARTU
		$this->NOKARTU = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NOKARTU', 'NOKARTU', '`NOKARTU`', '`NOKARTU`', 200, -1, FALSE, '`NOKARTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKARTU->Sortable = TRUE; // Allow sort
		$this->fields['NOKARTU'] = &$this->NOKARTU;

		// TANGGAL_SEP
		$this->TANGGAL_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_TANGGAL_SEP', 'TANGGAL_SEP', '`TANGGAL_SEP`', ew_CastDateFieldForLike('`TANGGAL_SEP`', 0, "DB"), 135, 0, FALSE, '`TANGGAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TANGGAL_SEP->Sortable = TRUE; // Allow sort
		$this->TANGGAL_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TANGGAL_SEP'] = &$this->TANGGAL_SEP;

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_TANGGALRUJUK_SEP', 'TANGGALRUJUK_SEP', '`TANGGALRUJUK_SEP`', ew_CastDateFieldForLike('`TANGGALRUJUK_SEP`', 0, "DB"), 135, 0, FALSE, '`TANGGALRUJUK_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TANGGALRUJUK_SEP->Sortable = TRUE; // Allow sort
		$this->TANGGALRUJUK_SEP->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TANGGALRUJUK_SEP'] = &$this->TANGGALRUJUK_SEP;

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_KELASRAWAT_SEP', 'KELASRAWAT_SEP', '`KELASRAWAT_SEP`', '`KELASRAWAT_SEP`', 3, -1, FALSE, '`KELASRAWAT_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELASRAWAT_SEP->Sortable = TRUE; // Allow sort
		$this->KELASRAWAT_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KELASRAWAT_SEP'] = &$this->KELASRAWAT_SEP;

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_MINTA_RUJUKAN', 'MINTA_RUJUKAN', '`MINTA_RUJUKAN`', '`MINTA_RUJUKAN`', 200, -1, FALSE, '`MINTA_RUJUKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MINTA_RUJUKAN->Sortable = TRUE; // Allow sort
		$this->fields['MINTA_RUJUKAN'] = &$this->MINTA_RUJUKAN;

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NORUJUKAN_SEP', 'NORUJUKAN_SEP', '`NORUJUKAN_SEP`', '`NORUJUKAN_SEP`', 200, -1, FALSE, '`NORUJUKAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NORUJUKAN_SEP->Sortable = TRUE; // Allow sort
		$this->fields['NORUJUKAN_SEP'] = &$this->NORUJUKAN_SEP;

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_PPKRUJUKANASAL_SEP', 'PPKRUJUKANASAL_SEP', '`PPKRUJUKANASAL_SEP`', '`PPKRUJUKANASAL_SEP`', 200, -1, FALSE, '`PPKRUJUKANASAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PPKRUJUKANASAL_SEP->Sortable = TRUE; // Allow sort
		$this->fields['PPKRUJUKANASAL_SEP'] = &$this->PPKRUJUKANASAL_SEP;

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NAMAPPKRUJUKANASAL_SEP', 'NAMAPPKRUJUKANASAL_SEP', '`NAMAPPKRUJUKANASAL_SEP`', '`NAMAPPKRUJUKANASAL_SEP`', 200, -1, FALSE, '`NAMAPPKRUJUKANASAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMAPPKRUJUKANASAL_SEP->Sortable = TRUE; // Allow sort
		$this->fields['NAMAPPKRUJUKANASAL_SEP'] = &$this->NAMAPPKRUJUKANASAL_SEP;

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_PPKPELAYANAN_SEP', 'PPKPELAYANAN_SEP', '`PPKPELAYANAN_SEP`', '`PPKPELAYANAN_SEP`', 200, -1, FALSE, '`PPKPELAYANAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PPKPELAYANAN_SEP->Sortable = TRUE; // Allow sort
		$this->fields['PPKPELAYANAN_SEP'] = &$this->PPKPELAYANAN_SEP;

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_JENISPERAWATAN_SEP', 'JENISPERAWATAN_SEP', '`JENISPERAWATAN_SEP`', '`JENISPERAWATAN_SEP`', 3, -1, FALSE, '`JENISPERAWATAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JENISPERAWATAN_SEP->Sortable = TRUE; // Allow sort
		$this->JENISPERAWATAN_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['JENISPERAWATAN_SEP'] = &$this->JENISPERAWATAN_SEP;

		// CATATAN_SEP
		$this->CATATAN_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_CATATAN_SEP', 'CATATAN_SEP', '`CATATAN_SEP`', '`CATATAN_SEP`', 200, -1, FALSE, '`CATATAN_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CATATAN_SEP->Sortable = TRUE; // Allow sort
		$this->fields['CATATAN_SEP'] = &$this->CATATAN_SEP;

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_DIAGNOSAAWAL_SEP', 'DIAGNOSAAWAL_SEP', '`DIAGNOSAAWAL_SEP`', '`DIAGNOSAAWAL_SEP`', 200, -1, FALSE, '`DIAGNOSAAWAL_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DIAGNOSAAWAL_SEP->Sortable = TRUE; // Allow sort
		$this->fields['DIAGNOSAAWAL_SEP'] = &$this->DIAGNOSAAWAL_SEP;

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_NAMADIAGNOSA_SEP', 'NAMADIAGNOSA_SEP', '`NAMADIAGNOSA_SEP`', '`NAMADIAGNOSA_SEP`', 200, -1, FALSE, '`NAMADIAGNOSA_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMADIAGNOSA_SEP->Sortable = TRUE; // Allow sort
		$this->fields['NAMADIAGNOSA_SEP'] = &$this->NAMADIAGNOSA_SEP;

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_LAKALANTAS_SEP', 'LAKALANTAS_SEP', '`LAKALANTAS_SEP`', '`LAKALANTAS_SEP`', 3, -1, FALSE, '`LAKALANTAS_SEP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAKALANTAS_SEP->Sortable = TRUE; // Allow sort
		$this->LAKALANTAS_SEP->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['LAKALANTAS_SEP'] = &$this->LAKALANTAS_SEP;

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_LOKASILAKALANTAS', 'LOKASILAKALANTAS', '`LOKASILAKALANTAS`', '`LOKASILAKALANTAS`', 200, -1, FALSE, '`LOKASILAKALANTAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LOKASILAKALANTAS->Sortable = TRUE; // Allow sort
		$this->fields['LOKASILAKALANTAS'] = &$this->LOKASILAKALANTAS;

		// USER
		$this->USER = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_USER', 'USER', '`USER`', '`USER`', 200, -1, FALSE, '`USER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->USER->Sortable = TRUE; // Allow sort
		$this->fields['USER'] = &$this->USER;

		// tanggal
		$this->tanggal = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_tanggal', 'tanggal', '`tanggal`', '`tanggal`', 3, -1, FALSE, '`tanggal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal->Sortable = TRUE; // Allow sort
		$this->tanggal->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tanggal'] = &$this->tanggal;

		// bulan
		$this->bulan = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_bulan', 'bulan', '`bulan`', '`bulan`', 3, -1, FALSE, '`bulan`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->bulan->Sortable = TRUE; // Allow sort
		$this->bulan->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->bulan->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->bulan->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['bulan'] = &$this->bulan;

		// tahun
		$this->tahun = new cField('vw_list_pasien_rawat_jalan', 'vw_list_pasien_rawat_jalan', 'x_tahun', 'tahun', '`tahun`', '`tahun`', 3, -1, FALSE, '`tahun`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tahun->Sortable = TRUE; // Allow sort
		$this->tahun->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['tahun'] = &$this->tahun;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`vw_list_pasien_rawat_jalan`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`TGLREG` DESC";
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
			return "vw_list_pasien_rawat_jalanlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "vw_list_pasien_rawat_jalanlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("vw_list_pasien_rawat_jalanview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("vw_list_pasien_rawat_jalanview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "vw_list_pasien_rawat_jalanadd.php?" . $this->UrlParm($parm);
		else
			$url = "vw_list_pasien_rawat_jalanadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("vw_list_pasien_rawat_jalanedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("vw_list_pasien_rawat_jalanadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("vw_list_pasien_rawat_jalandelete.php", $this->UrlParm());
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
		$this->TGLREG->setDbValue($rs->fields('TGLREG'));
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->KETERANGAN->setDbValue($rs->fields('KETERANGAN'));
		$this->NOKARTU_BPJS->setDbValue($rs->fields('NOKARTU_BPJS'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->KDDOKTER->setDbValue($rs->fields('KDDOKTER'));
		$this->KDPOLY->setDbValue($rs->fields('KDPOLY'));
		$this->KDRUJUK->setDbValue($rs->fields('KDRUJUK'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NOJAMINAN->setDbValue($rs->fields('NOJAMINAN'));
		$this->SHIFT->setDbValue($rs->fields('SHIFT'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->KETERANGAN_STATUS->setDbValue($rs->fields('KETERANGAN_STATUS'));
		$this->PASIENBARU->setDbValue($rs->fields('PASIENBARU'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->MASUKPOLY->setDbValue($rs->fields('MASUKPOLY'));
		$this->KELUARPOLY->setDbValue($rs->fields('KELUARPOLY'));
		$this->KETRUJUK->setDbValue($rs->fields('KETRUJUK'));
		$this->KETBAYAR->setDbValue($rs->fields('KETBAYAR'));
		$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields('PENANGGUNGJAWAB_NAMA'));
		$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields('PENANGGUNGJAWAB_HUBUNGAN'));
		$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields('PENANGGUNGJAWAB_ALAMAT'));
		$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields('PENANGGUNGJAWAB_PHONE'));
		$this->JAMREG->setDbValue($rs->fields('JAMREG'));
		$this->BATAL->setDbValue($rs->fields('BATAL'));
		$this->NO_SJP->setDbValue($rs->fields('NO_SJP'));
		$this->NO_PESERTA->setDbValue($rs->fields('NO_PESERTA'));
		$this->NOKARTU->setDbValue($rs->fields('NOKARTU'));
		$this->TANGGAL_SEP->setDbValue($rs->fields('TANGGAL_SEP'));
		$this->TANGGALRUJUK_SEP->setDbValue($rs->fields('TANGGALRUJUK_SEP'));
		$this->KELASRAWAT_SEP->setDbValue($rs->fields('KELASRAWAT_SEP'));
		$this->MINTA_RUJUKAN->setDbValue($rs->fields('MINTA_RUJUKAN'));
		$this->NORUJUKAN_SEP->setDbValue($rs->fields('NORUJUKAN_SEP'));
		$this->PPKRUJUKANASAL_SEP->setDbValue($rs->fields('PPKRUJUKANASAL_SEP'));
		$this->NAMAPPKRUJUKANASAL_SEP->setDbValue($rs->fields('NAMAPPKRUJUKANASAL_SEP'));
		$this->PPKPELAYANAN_SEP->setDbValue($rs->fields('PPKPELAYANAN_SEP'));
		$this->JENISPERAWATAN_SEP->setDbValue($rs->fields('JENISPERAWATAN_SEP'));
		$this->CATATAN_SEP->setDbValue($rs->fields('CATATAN_SEP'));
		$this->DIAGNOSAAWAL_SEP->setDbValue($rs->fields('DIAGNOSAAWAL_SEP'));
		$this->NAMADIAGNOSA_SEP->setDbValue($rs->fields('NAMADIAGNOSA_SEP'));
		$this->LAKALANTAS_SEP->setDbValue($rs->fields('LAKALANTAS_SEP'));
		$this->LOKASILAKALANTAS->setDbValue($rs->fields('LOKASILAKALANTAS'));
		$this->USER->setDbValue($rs->fields('USER'));
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->bulan->setDbValue($rs->fields('bulan'));
		$this->tahun->setDbValue($rs->fields('tahun'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// IDXDAFTAR
		// TGLREG
		// NOMR
		// KETERANGAN
		// NOKARTU_BPJS
		// NOKTP
		// KDDOKTER
		// KDPOLY
		// KDRUJUK
		// KDCARABAYAR
		// NOJAMINAN
		// SHIFT
		// STATUS
		// KETERANGAN_STATUS
		// PASIENBARU
		// NIP
		// MASUKPOLY
		// KELUARPOLY
		// KETRUJUK
		// KETBAYAR
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// JAMREG
		// BATAL
		// NO_SJP
		// NO_PESERTA
		// NOKARTU
		// TANGGAL_SEP
		// TANGGALRUJUK_SEP
		// KELASRAWAT_SEP
		// MINTA_RUJUKAN
		// NORUJUKAN_SEP
		// PPKRUJUKANASAL_SEP
		// NAMAPPKRUJUKANASAL_SEP
		// PPKPELAYANAN_SEP
		// JENISPERAWATAN_SEP
		// CATATAN_SEP
		// DIAGNOSAAWAL_SEP
		// NAMADIAGNOSA_SEP
		// LAKALANTAS_SEP
		// LOKASILAKALANTAS
		// USER
		// tanggal
		// bulan
		// tahun
		// IDXDAFTAR

		$this->IDXDAFTAR->ViewValue = $this->IDXDAFTAR->CurrentValue;
		$this->IDXDAFTAR->ViewCustomAttributes = "";

		// TGLREG
		$this->TGLREG->ViewValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->ViewValue = ew_FormatDateTime($this->TGLREG->ViewValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

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

		// KETERANGAN
		$this->KETERANGAN->ViewValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->ViewCustomAttributes = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->ViewValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// KDDOKTER
		$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->KDDOKTER->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDDOKTER, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDDOKTER->ViewValue = $this->KDDOKTER->CurrentValue;
			}
		} else {
			$this->KDDOKTER->ViewValue = NULL;
		}
		$this->KDDOKTER->ViewCustomAttributes = "";

		// KDPOLY
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

		// KDRUJUK
		$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
		if (strval($this->KDRUJUK->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDRUJUK->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->KDRUJUK->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDRUJUK->ViewValue = $this->KDRUJUK->CurrentValue;
			}
		} else {
			$this->KDRUJUK->ViewValue = NULL;
		}
		$this->KDRUJUK->ViewCustomAttributes = "";

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

		// NOJAMINAN
		$this->NOJAMINAN->ViewValue = $this->NOJAMINAN->CurrentValue;
		$this->NOJAMINAN->ViewCustomAttributes = "";

		// SHIFT
		$this->SHIFT->ViewValue = $this->SHIFT->CurrentValue;
		$this->SHIFT->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->ViewValue = $this->KETERANGAN_STATUS->CurrentValue;
		$this->KETERANGAN_STATUS->ViewCustomAttributes = "";

		// PASIENBARU
		$this->PASIENBARU->ViewValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NIP
		$this->NIP->ViewValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// MASUKPOLY
		$this->MASUKPOLY->ViewValue = $this->MASUKPOLY->CurrentValue;
		$this->MASUKPOLY->ViewValue = ew_FormatDateTime($this->MASUKPOLY->ViewValue, 4);
		$this->MASUKPOLY->ViewCustomAttributes = "";

		// KELUARPOLY
		$this->KELUARPOLY->ViewValue = $this->KELUARPOLY->CurrentValue;
		$this->KELUARPOLY->ViewValue = ew_FormatDateTime($this->KELUARPOLY->ViewValue, 4);
		$this->KELUARPOLY->ViewCustomAttributes = "";

		// KETRUJUK
		$this->KETRUJUK->ViewValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// KETBAYAR
		$this->KETBAYAR->ViewValue = $this->KETBAYAR->CurrentValue;
		$this->KETBAYAR->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->ViewValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->ViewValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->ViewValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->ViewValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->ViewValue = ew_FormatDateTime($this->JAMREG->ViewValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// BATAL
		$this->BATAL->ViewValue = $this->BATAL->CurrentValue;
		$this->BATAL->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->ViewValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NO_PESERTA
		$this->NO_PESERTA->ViewValue = $this->NO_PESERTA->CurrentValue;
		$this->NO_PESERTA->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->ViewValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->ViewValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->ViewValue = ew_FormatDateTime($this->TANGGAL_SEP->ViewValue, 0);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->ViewValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->ViewValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->ViewValue, 0);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->ViewValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->ViewValue = $this->MINTA_RUJUKAN->CurrentValue;
		$this->MINTA_RUJUKAN->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->ViewValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->ViewValue = $this->PPKRUJUKANASAL_SEP->CurrentValue;
		$this->PPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->ViewValue = $this->NAMAPPKRUJUKANASAL_SEP->CurrentValue;
		$this->NAMAPPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->ViewValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->ViewValue = $this->JENISPERAWATAN_SEP->CurrentValue;
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
		$this->LAKALANTAS_SEP->ViewValue = $this->LAKALANTAS_SEP->CurrentValue;
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->ViewValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->ViewValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewCustomAttributes = "";

		// bulan
		if (strval($this->bulan->CurrentValue) <> "") {
			$sFilterWrk = "`bulan_id`" . ew_SearchString("=", $this->bulan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `bulan_id`, `bulan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_bulan`";
		$sWhereWrk = "";
		$this->bulan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bulan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bulan->ViewValue = $this->bulan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bulan->ViewValue = $this->bulan->CurrentValue;
			}
		} else {
			$this->bulan->ViewValue = NULL;
		}
		$this->bulan->ViewCustomAttributes = "";

		// tahun
		$this->tahun->ViewValue = $this->tahun->CurrentValue;
		$this->tahun->ViewCustomAttributes = "";

		// IDXDAFTAR
		$this->IDXDAFTAR->LinkCustomAttributes = "";
		$this->IDXDAFTAR->HrefValue = "";
		$this->IDXDAFTAR->TooltipValue = "";

		// TGLREG
		$this->TGLREG->LinkCustomAttributes = "";
		$this->TGLREG->HrefValue = "";
		$this->TGLREG->TooltipValue = "";

		// NOMR
		$this->NOMR->LinkCustomAttributes = "";
		$this->NOMR->HrefValue = "";
		$this->NOMR->TooltipValue = "";

		// KETERANGAN
		$this->KETERANGAN->LinkCustomAttributes = "";
		$this->KETERANGAN->HrefValue = "";
		$this->KETERANGAN->TooltipValue = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->LinkCustomAttributes = "";
		$this->NOKARTU_BPJS->HrefValue = "";
		$this->NOKARTU_BPJS->TooltipValue = "";

		// NOKTP
		$this->NOKTP->LinkCustomAttributes = "";
		$this->NOKTP->HrefValue = "";
		$this->NOKTP->TooltipValue = "";

		// KDDOKTER
		$this->KDDOKTER->LinkCustomAttributes = "";
		$this->KDDOKTER->HrefValue = "";
		$this->KDDOKTER->TooltipValue = "";

		// KDPOLY
		$this->KDPOLY->LinkCustomAttributes = "";
		$this->KDPOLY->HrefValue = "";
		$this->KDPOLY->TooltipValue = "";

		// KDRUJUK
		$this->KDRUJUK->LinkCustomAttributes = "";
		$this->KDRUJUK->HrefValue = "";
		$this->KDRUJUK->TooltipValue = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->LinkCustomAttributes = "";
		$this->KDCARABAYAR->HrefValue = "";
		$this->KDCARABAYAR->TooltipValue = "";

		// NOJAMINAN
		$this->NOJAMINAN->LinkCustomAttributes = "";
		$this->NOJAMINAN->HrefValue = "";
		$this->NOJAMINAN->TooltipValue = "";

		// SHIFT
		$this->SHIFT->LinkCustomAttributes = "";
		$this->SHIFT->HrefValue = "";
		$this->SHIFT->TooltipValue = "";

		// STATUS
		$this->STATUS->LinkCustomAttributes = "";
		$this->STATUS->HrefValue = "";
		$this->STATUS->TooltipValue = "";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->LinkCustomAttributes = "";
		$this->KETERANGAN_STATUS->HrefValue = "";
		$this->KETERANGAN_STATUS->TooltipValue = "";

		// PASIENBARU
		$this->PASIENBARU->LinkCustomAttributes = "";
		$this->PASIENBARU->HrefValue = "";
		$this->PASIENBARU->TooltipValue = "";

		// NIP
		$this->NIP->LinkCustomAttributes = "";
		$this->NIP->HrefValue = "";
		$this->NIP->TooltipValue = "";

		// MASUKPOLY
		$this->MASUKPOLY->LinkCustomAttributes = "";
		$this->MASUKPOLY->HrefValue = "";
		$this->MASUKPOLY->TooltipValue = "";

		// KELUARPOLY
		$this->KELUARPOLY->LinkCustomAttributes = "";
		$this->KELUARPOLY->HrefValue = "";
		$this->KELUARPOLY->TooltipValue = "";

		// KETRUJUK
		$this->KETRUJUK->LinkCustomAttributes = "";
		$this->KETRUJUK->HrefValue = "";
		$this->KETRUJUK->TooltipValue = "";

		// KETBAYAR
		$this->KETBAYAR->LinkCustomAttributes = "";
		$this->KETBAYAR->HrefValue = "";
		$this->KETBAYAR->TooltipValue = "";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->LinkCustomAttributes = "";
		$this->PENANGGUNGJAWAB_NAMA->HrefValue = "";
		$this->PENANGGUNGJAWAB_NAMA->TooltipValue = "";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->LinkCustomAttributes = "";
		$this->PENANGGUNGJAWAB_HUBUNGAN->HrefValue = "";
		$this->PENANGGUNGJAWAB_HUBUNGAN->TooltipValue = "";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->LinkCustomAttributes = "";
		$this->PENANGGUNGJAWAB_ALAMAT->HrefValue = "";
		$this->PENANGGUNGJAWAB_ALAMAT->TooltipValue = "";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->LinkCustomAttributes = "";
		$this->PENANGGUNGJAWAB_PHONE->HrefValue = "";
		$this->PENANGGUNGJAWAB_PHONE->TooltipValue = "";

		// JAMREG
		$this->JAMREG->LinkCustomAttributes = "";
		$this->JAMREG->HrefValue = "";
		$this->JAMREG->TooltipValue = "";

		// BATAL
		$this->BATAL->LinkCustomAttributes = "";
		$this->BATAL->HrefValue = "";
		$this->BATAL->TooltipValue = "";

		// NO_SJP
		$this->NO_SJP->LinkCustomAttributes = "";
		$this->NO_SJP->HrefValue = "";
		$this->NO_SJP->TooltipValue = "";

		// NO_PESERTA
		$this->NO_PESERTA->LinkCustomAttributes = "";
		$this->NO_PESERTA->HrefValue = "";
		$this->NO_PESERTA->TooltipValue = "";

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

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->LinkCustomAttributes = "";
		$this->MINTA_RUJUKAN->HrefValue = "";
		$this->MINTA_RUJUKAN->TooltipValue = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->LinkCustomAttributes = "";
		$this->NORUJUKAN_SEP->HrefValue = "";
		$this->NORUJUKAN_SEP->TooltipValue = "";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->LinkCustomAttributes = "";
		$this->PPKRUJUKANASAL_SEP->HrefValue = "";
		$this->PPKRUJUKANASAL_SEP->TooltipValue = "";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->LinkCustomAttributes = "";
		$this->NAMAPPKRUJUKANASAL_SEP->HrefValue = "";
		$this->NAMAPPKRUJUKANASAL_SEP->TooltipValue = "";

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

		// tanggal
		$this->tanggal->LinkCustomAttributes = "";
		$this->tanggal->HrefValue = "";
		$this->tanggal->TooltipValue = "";

		// bulan
		$this->bulan->LinkCustomAttributes = "";
		$this->bulan->HrefValue = "";
		$this->bulan->TooltipValue = "";

		// tahun
		$this->tahun->LinkCustomAttributes = "";
		$this->tahun->HrefValue = "";
		$this->tahun->TooltipValue = "";

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

		// TGLREG
		$this->TGLREG->EditAttrs["class"] = "form-control";
		$this->TGLREG->EditCustomAttributes = "";
		$this->TGLREG->EditValue = $this->TGLREG->CurrentValue;
		$this->TGLREG->EditValue = ew_FormatDateTime($this->TGLREG->EditValue, 0);
		$this->TGLREG->ViewCustomAttributes = "";

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

		// KETERANGAN
		$this->KETERANGAN->EditAttrs["class"] = "form-control";
		$this->KETERANGAN->EditCustomAttributes = "";
		$this->KETERANGAN->EditValue = $this->KETERANGAN->CurrentValue;
		$this->KETERANGAN->ViewCustomAttributes = "";

		// NOKARTU_BPJS
		$this->NOKARTU_BPJS->EditAttrs["class"] = "form-control";
		$this->NOKARTU_BPJS->EditCustomAttributes = "";
		$this->NOKARTU_BPJS->EditValue = $this->NOKARTU_BPJS->CurrentValue;
		$this->NOKARTU_BPJS->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->EditAttrs["class"] = "form-control";
		$this->NOKTP->EditCustomAttributes = "";
		$this->NOKTP->EditValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// KDDOKTER
		$this->KDDOKTER->EditAttrs["class"] = "form-control";
		$this->KDDOKTER->EditCustomAttributes = "";
		$this->KDDOKTER->EditValue = $this->KDDOKTER->CurrentValue;
		if (strval($this->KDDOKTER->CurrentValue) <> "") {
			$sFilterWrk = "`KDDOKTER`" . ew_SearchString("=", $this->KDDOKTER->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KDDOKTER`, `NAMADOKTER` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_dokter`";
		$sWhereWrk = "";
		$this->KDDOKTER->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDDOKTER, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDDOKTER->EditValue = $this->KDDOKTER->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDDOKTER->EditValue = $this->KDDOKTER->CurrentValue;
			}
		} else {
			$this->KDDOKTER->EditValue = NULL;
		}
		$this->KDDOKTER->ViewCustomAttributes = "";

		// KDPOLY
		$this->KDPOLY->EditAttrs["class"] = "form-control";
		$this->KDPOLY->EditCustomAttributes = "";
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

		// KDRUJUK
		$this->KDRUJUK->EditAttrs["class"] = "form-control";
		$this->KDRUJUK->EditCustomAttributes = "";
		$this->KDRUJUK->EditValue = $this->KDRUJUK->CurrentValue;
		if (strval($this->KDRUJUK->CurrentValue) <> "") {
			$sFilterWrk = "`KODE`" . ew_SearchString("=", $this->KDRUJUK->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `KODE`, `NAMA` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_rujukan`";
		$sWhereWrk = "";
		$this->KDRUJUK->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDRUJUK, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDRUJUK->EditValue = $this->KDRUJUK->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDRUJUK->EditValue = $this->KDRUJUK->CurrentValue;
			}
		} else {
			$this->KDRUJUK->EditValue = NULL;
		}
		$this->KDRUJUK->ViewCustomAttributes = "";

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

		// NOJAMINAN
		$this->NOJAMINAN->EditAttrs["class"] = "form-control";
		$this->NOJAMINAN->EditCustomAttributes = "";
		$this->NOJAMINAN->EditValue = $this->NOJAMINAN->CurrentValue;
		$this->NOJAMINAN->ViewCustomAttributes = "";

		// SHIFT
		$this->SHIFT->EditAttrs["class"] = "form-control";
		$this->SHIFT->EditCustomAttributes = "";
		$this->SHIFT->EditValue = $this->SHIFT->CurrentValue;
		$this->SHIFT->ViewCustomAttributes = "";

		// STATUS
		$this->STATUS->EditAttrs["class"] = "form-control";
		$this->STATUS->EditCustomAttributes = "";
		$this->STATUS->EditValue = $this->STATUS->CurrentValue;
		$this->STATUS->ViewCustomAttributes = "";

		// KETERANGAN_STATUS
		$this->KETERANGAN_STATUS->EditAttrs["class"] = "form-control";
		$this->KETERANGAN_STATUS->EditCustomAttributes = "";
		$this->KETERANGAN_STATUS->EditValue = $this->KETERANGAN_STATUS->CurrentValue;
		$this->KETERANGAN_STATUS->ViewCustomAttributes = "";

		// PASIENBARU
		$this->PASIENBARU->EditAttrs["class"] = "form-control";
		$this->PASIENBARU->EditCustomAttributes = "";
		$this->PASIENBARU->EditValue = $this->PASIENBARU->CurrentValue;
		$this->PASIENBARU->ViewCustomAttributes = "";

		// NIP
		$this->NIP->EditAttrs["class"] = "form-control";
		$this->NIP->EditCustomAttributes = "";
		$this->NIP->EditValue = $this->NIP->CurrentValue;
		$this->NIP->ViewCustomAttributes = "";

		// MASUKPOLY
		$this->MASUKPOLY->EditAttrs["class"] = "form-control";
		$this->MASUKPOLY->EditCustomAttributes = "";
		$this->MASUKPOLY->EditValue = $this->MASUKPOLY->CurrentValue;
		$this->MASUKPOLY->EditValue = ew_FormatDateTime($this->MASUKPOLY->EditValue, 4);
		$this->MASUKPOLY->ViewCustomAttributes = "";

		// KELUARPOLY
		$this->KELUARPOLY->EditAttrs["class"] = "form-control";
		$this->KELUARPOLY->EditCustomAttributes = "";
		$this->KELUARPOLY->EditValue = $this->KELUARPOLY->CurrentValue;
		$this->KELUARPOLY->EditValue = ew_FormatDateTime($this->KELUARPOLY->EditValue, 4);
		$this->KELUARPOLY->ViewCustomAttributes = "";

		// KETRUJUK
		$this->KETRUJUK->EditAttrs["class"] = "form-control";
		$this->KETRUJUK->EditCustomAttributes = "";
		$this->KETRUJUK->EditValue = $this->KETRUJUK->CurrentValue;
		$this->KETRUJUK->ViewCustomAttributes = "";

		// KETBAYAR
		$this->KETBAYAR->EditAttrs["class"] = "form-control";
		$this->KETBAYAR->EditCustomAttributes = "";
		$this->KETBAYAR->EditValue = $this->KETBAYAR->CurrentValue;
		$this->KETBAYAR->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_NAMA->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_NAMA->EditValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_HUBUNGAN->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_HUBUNGAN->EditValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_ALAMAT->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_ALAMAT->EditValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->ViewCustomAttributes = "";

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_PHONE->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_PHONE->EditValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->ViewCustomAttributes = "";

		// JAMREG
		$this->JAMREG->EditAttrs["class"] = "form-control";
		$this->JAMREG->EditCustomAttributes = "";
		$this->JAMREG->EditValue = $this->JAMREG->CurrentValue;
		$this->JAMREG->EditValue = ew_FormatDateTime($this->JAMREG->EditValue, 0);
		$this->JAMREG->ViewCustomAttributes = "";

		// BATAL
		$this->BATAL->EditAttrs["class"] = "form-control";
		$this->BATAL->EditCustomAttributes = "";
		$this->BATAL->EditValue = $this->BATAL->CurrentValue;
		$this->BATAL->ViewCustomAttributes = "";

		// NO_SJP
		$this->NO_SJP->EditAttrs["class"] = "form-control";
		$this->NO_SJP->EditCustomAttributes = "";
		$this->NO_SJP->EditValue = $this->NO_SJP->CurrentValue;
		$this->NO_SJP->ViewCustomAttributes = "";

		// NO_PESERTA
		$this->NO_PESERTA->EditAttrs["class"] = "form-control";
		$this->NO_PESERTA->EditCustomAttributes = "";
		$this->NO_PESERTA->EditValue = $this->NO_PESERTA->CurrentValue;
		$this->NO_PESERTA->ViewCustomAttributes = "";

		// NOKARTU
		$this->NOKARTU->EditAttrs["class"] = "form-control";
		$this->NOKARTU->EditCustomAttributes = "";
		$this->NOKARTU->EditValue = $this->NOKARTU->CurrentValue;
		$this->NOKARTU->ViewCustomAttributes = "";

		// TANGGAL_SEP
		$this->TANGGAL_SEP->EditAttrs["class"] = "form-control";
		$this->TANGGAL_SEP->EditCustomAttributes = "";
		$this->TANGGAL_SEP->EditValue = $this->TANGGAL_SEP->CurrentValue;
		$this->TANGGAL_SEP->EditValue = ew_FormatDateTime($this->TANGGAL_SEP->EditValue, 0);
		$this->TANGGAL_SEP->ViewCustomAttributes = "";

		// TANGGALRUJUK_SEP
		$this->TANGGALRUJUK_SEP->EditAttrs["class"] = "form-control";
		$this->TANGGALRUJUK_SEP->EditCustomAttributes = "";
		$this->TANGGALRUJUK_SEP->EditValue = $this->TANGGALRUJUK_SEP->CurrentValue;
		$this->TANGGALRUJUK_SEP->EditValue = ew_FormatDateTime($this->TANGGALRUJUK_SEP->EditValue, 0);
		$this->TANGGALRUJUK_SEP->ViewCustomAttributes = "";

		// KELASRAWAT_SEP
		$this->KELASRAWAT_SEP->EditAttrs["class"] = "form-control";
		$this->KELASRAWAT_SEP->EditCustomAttributes = "";
		$this->KELASRAWAT_SEP->EditValue = $this->KELASRAWAT_SEP->CurrentValue;
		$this->KELASRAWAT_SEP->ViewCustomAttributes = "";

		// MINTA_RUJUKAN
		$this->MINTA_RUJUKAN->EditAttrs["class"] = "form-control";
		$this->MINTA_RUJUKAN->EditCustomAttributes = "";
		$this->MINTA_RUJUKAN->EditValue = $this->MINTA_RUJUKAN->CurrentValue;
		$this->MINTA_RUJUKAN->ViewCustomAttributes = "";

		// NORUJUKAN_SEP
		$this->NORUJUKAN_SEP->EditAttrs["class"] = "form-control";
		$this->NORUJUKAN_SEP->EditCustomAttributes = "";
		$this->NORUJUKAN_SEP->EditValue = $this->NORUJUKAN_SEP->CurrentValue;
		$this->NORUJUKAN_SEP->ViewCustomAttributes = "";

		// PPKRUJUKANASAL_SEP
		$this->PPKRUJUKANASAL_SEP->EditAttrs["class"] = "form-control";
		$this->PPKRUJUKANASAL_SEP->EditCustomAttributes = "";
		$this->PPKRUJUKANASAL_SEP->EditValue = $this->PPKRUJUKANASAL_SEP->CurrentValue;
		$this->PPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// NAMAPPKRUJUKANASAL_SEP
		$this->NAMAPPKRUJUKANASAL_SEP->EditAttrs["class"] = "form-control";
		$this->NAMAPPKRUJUKANASAL_SEP->EditCustomAttributes = "";
		$this->NAMAPPKRUJUKANASAL_SEP->EditValue = $this->NAMAPPKRUJUKANASAL_SEP->CurrentValue;
		$this->NAMAPPKRUJUKANASAL_SEP->ViewCustomAttributes = "";

		// PPKPELAYANAN_SEP
		$this->PPKPELAYANAN_SEP->EditAttrs["class"] = "form-control";
		$this->PPKPELAYANAN_SEP->EditCustomAttributes = "";
		$this->PPKPELAYANAN_SEP->EditValue = $this->PPKPELAYANAN_SEP->CurrentValue;
		$this->PPKPELAYANAN_SEP->ViewCustomAttributes = "";

		// JENISPERAWATAN_SEP
		$this->JENISPERAWATAN_SEP->EditAttrs["class"] = "form-control";
		$this->JENISPERAWATAN_SEP->EditCustomAttributes = "";
		$this->JENISPERAWATAN_SEP->EditValue = $this->JENISPERAWATAN_SEP->CurrentValue;
		$this->JENISPERAWATAN_SEP->ViewCustomAttributes = "";

		// CATATAN_SEP
		$this->CATATAN_SEP->EditAttrs["class"] = "form-control";
		$this->CATATAN_SEP->EditCustomAttributes = "";
		$this->CATATAN_SEP->EditValue = $this->CATATAN_SEP->CurrentValue;
		$this->CATATAN_SEP->ViewCustomAttributes = "";

		// DIAGNOSAAWAL_SEP
		$this->DIAGNOSAAWAL_SEP->EditAttrs["class"] = "form-control";
		$this->DIAGNOSAAWAL_SEP->EditCustomAttributes = "";
		$this->DIAGNOSAAWAL_SEP->EditValue = $this->DIAGNOSAAWAL_SEP->CurrentValue;
		$this->DIAGNOSAAWAL_SEP->ViewCustomAttributes = "";

		// NAMADIAGNOSA_SEP
		$this->NAMADIAGNOSA_SEP->EditAttrs["class"] = "form-control";
		$this->NAMADIAGNOSA_SEP->EditCustomAttributes = "";
		$this->NAMADIAGNOSA_SEP->EditValue = $this->NAMADIAGNOSA_SEP->CurrentValue;
		$this->NAMADIAGNOSA_SEP->ViewCustomAttributes = "";

		// LAKALANTAS_SEP
		$this->LAKALANTAS_SEP->EditAttrs["class"] = "form-control";
		$this->LAKALANTAS_SEP->EditCustomAttributes = "";
		$this->LAKALANTAS_SEP->EditValue = $this->LAKALANTAS_SEP->CurrentValue;
		$this->LAKALANTAS_SEP->ViewCustomAttributes = "";

		// LOKASILAKALANTAS
		$this->LOKASILAKALANTAS->EditAttrs["class"] = "form-control";
		$this->LOKASILAKALANTAS->EditCustomAttributes = "";
		$this->LOKASILAKALANTAS->EditValue = $this->LOKASILAKALANTAS->CurrentValue;
		$this->LOKASILAKALANTAS->ViewCustomAttributes = "";

		// USER
		$this->USER->EditAttrs["class"] = "form-control";
		$this->USER->EditCustomAttributes = "";
		$this->USER->EditValue = $this->USER->CurrentValue;
		$this->USER->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->EditAttrs["class"] = "form-control";
		$this->tanggal->EditCustomAttributes = "";
		$this->tanggal->EditValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewCustomAttributes = "";

		// bulan
		$this->bulan->EditAttrs["class"] = "form-control";
		$this->bulan->EditCustomAttributes = "";
		if (strval($this->bulan->CurrentValue) <> "") {
			$sFilterWrk = "`bulan_id`" . ew_SearchString("=", $this->bulan->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `bulan_id`, `bulan_nama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_bulan`";
		$sWhereWrk = "";
		$this->bulan->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->bulan, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->bulan->EditValue = $this->bulan->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->bulan->EditValue = $this->bulan->CurrentValue;
			}
		} else {
			$this->bulan->EditValue = NULL;
		}
		$this->bulan->ViewCustomAttributes = "";

		// tahun
		$this->tahun->EditAttrs["class"] = "form-control";
		$this->tahun->EditCustomAttributes = "";
		$this->tahun->EditValue = $this->tahun->CurrentValue;
		$this->tahun->ViewCustomAttributes = "";

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
					if ($this->IDXDAFTAR->Exportable) $Doc->ExportCaption($this->IDXDAFTAR);
					if ($this->TGLREG->Exportable) $Doc->ExportCaption($this->TGLREG);
					if ($this->NOMR->Exportable) $Doc->ExportCaption($this->NOMR);
					if ($this->KETERANGAN->Exportable) $Doc->ExportCaption($this->KETERANGAN);
					if ($this->NOKARTU_BPJS->Exportable) $Doc->ExportCaption($this->NOKARTU_BPJS);
					if ($this->NOKTP->Exportable) $Doc->ExportCaption($this->NOKTP);
					if ($this->KDDOKTER->Exportable) $Doc->ExportCaption($this->KDDOKTER);
					if ($this->KDPOLY->Exportable) $Doc->ExportCaption($this->KDPOLY);
					if ($this->KDRUJUK->Exportable) $Doc->ExportCaption($this->KDRUJUK);
					if ($this->KDCARABAYAR->Exportable) $Doc->ExportCaption($this->KDCARABAYAR);
					if ($this->NOJAMINAN->Exportable) $Doc->ExportCaption($this->NOJAMINAN);
					if ($this->SHIFT->Exportable) $Doc->ExportCaption($this->SHIFT);
					if ($this->STATUS->Exportable) $Doc->ExportCaption($this->STATUS);
					if ($this->KETERANGAN_STATUS->Exportable) $Doc->ExportCaption($this->KETERANGAN_STATUS);
					if ($this->PASIENBARU->Exportable) $Doc->ExportCaption($this->PASIENBARU);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->MASUKPOLY->Exportable) $Doc->ExportCaption($this->MASUKPOLY);
					if ($this->KELUARPOLY->Exportable) $Doc->ExportCaption($this->KELUARPOLY);
					if ($this->KETRUJUK->Exportable) $Doc->ExportCaption($this->KETRUJUK);
					if ($this->KETBAYAR->Exportable) $Doc->ExportCaption($this->KETBAYAR);
					if ($this->PENANGGUNGJAWAB_NAMA->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_NAMA);
					if ($this->PENANGGUNGJAWAB_HUBUNGAN->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_HUBUNGAN);
					if ($this->PENANGGUNGJAWAB_ALAMAT->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_ALAMAT);
					if ($this->PENANGGUNGJAWAB_PHONE->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_PHONE);
					if ($this->JAMREG->Exportable) $Doc->ExportCaption($this->JAMREG);
					if ($this->BATAL->Exportable) $Doc->ExportCaption($this->BATAL);
					if ($this->NO_SJP->Exportable) $Doc->ExportCaption($this->NO_SJP);
					if ($this->NO_PESERTA->Exportable) $Doc->ExportCaption($this->NO_PESERTA);
					if ($this->NOKARTU->Exportable) $Doc->ExportCaption($this->NOKARTU);
					if ($this->TANGGAL_SEP->Exportable) $Doc->ExportCaption($this->TANGGAL_SEP);
					if ($this->TANGGALRUJUK_SEP->Exportable) $Doc->ExportCaption($this->TANGGALRUJUK_SEP);
					if ($this->KELASRAWAT_SEP->Exportable) $Doc->ExportCaption($this->KELASRAWAT_SEP);
					if ($this->MINTA_RUJUKAN->Exportable) $Doc->ExportCaption($this->MINTA_RUJUKAN);
					if ($this->NORUJUKAN_SEP->Exportable) $Doc->ExportCaption($this->NORUJUKAN_SEP);
					if ($this->PPKRUJUKANASAL_SEP->Exportable) $Doc->ExportCaption($this->PPKRUJUKANASAL_SEP);
					if ($this->NAMAPPKRUJUKANASAL_SEP->Exportable) $Doc->ExportCaption($this->NAMAPPKRUJUKANASAL_SEP);
					if ($this->PPKPELAYANAN_SEP->Exportable) $Doc->ExportCaption($this->PPKPELAYANAN_SEP);
					if ($this->JENISPERAWATAN_SEP->Exportable) $Doc->ExportCaption($this->JENISPERAWATAN_SEP);
					if ($this->CATATAN_SEP->Exportable) $Doc->ExportCaption($this->CATATAN_SEP);
					if ($this->DIAGNOSAAWAL_SEP->Exportable) $Doc->ExportCaption($this->DIAGNOSAAWAL_SEP);
					if ($this->NAMADIAGNOSA_SEP->Exportable) $Doc->ExportCaption($this->NAMADIAGNOSA_SEP);
					if ($this->LAKALANTAS_SEP->Exportable) $Doc->ExportCaption($this->LAKALANTAS_SEP);
					if ($this->LOKASILAKALANTAS->Exportable) $Doc->ExportCaption($this->LOKASILAKALANTAS);
					if ($this->USER->Exportable) $Doc->ExportCaption($this->USER);
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->bulan->Exportable) $Doc->ExportCaption($this->bulan);
					if ($this->tahun->Exportable) $Doc->ExportCaption($this->tahun);
				} else {
					if ($this->IDXDAFTAR->Exportable) $Doc->ExportCaption($this->IDXDAFTAR);
					if ($this->TGLREG->Exportable) $Doc->ExportCaption($this->TGLREG);
					if ($this->NOMR->Exportable) $Doc->ExportCaption($this->NOMR);
					if ($this->KETERANGAN->Exportable) $Doc->ExportCaption($this->KETERANGAN);
					if ($this->NOKARTU_BPJS->Exportable) $Doc->ExportCaption($this->NOKARTU_BPJS);
					if ($this->NOKTP->Exportable) $Doc->ExportCaption($this->NOKTP);
					if ($this->KDDOKTER->Exportable) $Doc->ExportCaption($this->KDDOKTER);
					if ($this->KDPOLY->Exportable) $Doc->ExportCaption($this->KDPOLY);
					if ($this->KDRUJUK->Exportable) $Doc->ExportCaption($this->KDRUJUK);
					if ($this->KDCARABAYAR->Exportable) $Doc->ExportCaption($this->KDCARABAYAR);
					if ($this->NOJAMINAN->Exportable) $Doc->ExportCaption($this->NOJAMINAN);
					if ($this->SHIFT->Exportable) $Doc->ExportCaption($this->SHIFT);
					if ($this->STATUS->Exportable) $Doc->ExportCaption($this->STATUS);
					if ($this->KETERANGAN_STATUS->Exportable) $Doc->ExportCaption($this->KETERANGAN_STATUS);
					if ($this->PASIENBARU->Exportable) $Doc->ExportCaption($this->PASIENBARU);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->MASUKPOLY->Exportable) $Doc->ExportCaption($this->MASUKPOLY);
					if ($this->KELUARPOLY->Exportable) $Doc->ExportCaption($this->KELUARPOLY);
					if ($this->KETRUJUK->Exportable) $Doc->ExportCaption($this->KETRUJUK);
					if ($this->KETBAYAR->Exportable) $Doc->ExportCaption($this->KETBAYAR);
					if ($this->PENANGGUNGJAWAB_NAMA->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_NAMA);
					if ($this->PENANGGUNGJAWAB_HUBUNGAN->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_HUBUNGAN);
					if ($this->PENANGGUNGJAWAB_ALAMAT->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_ALAMAT);
					if ($this->PENANGGUNGJAWAB_PHONE->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_PHONE);
					if ($this->JAMREG->Exportable) $Doc->ExportCaption($this->JAMREG);
					if ($this->BATAL->Exportable) $Doc->ExportCaption($this->BATAL);
					if ($this->NO_SJP->Exportable) $Doc->ExportCaption($this->NO_SJP);
					if ($this->NO_PESERTA->Exportable) $Doc->ExportCaption($this->NO_PESERTA);
					if ($this->NOKARTU->Exportable) $Doc->ExportCaption($this->NOKARTU);
					if ($this->TANGGAL_SEP->Exportable) $Doc->ExportCaption($this->TANGGAL_SEP);
					if ($this->TANGGALRUJUK_SEP->Exportable) $Doc->ExportCaption($this->TANGGALRUJUK_SEP);
					if ($this->KELASRAWAT_SEP->Exportable) $Doc->ExportCaption($this->KELASRAWAT_SEP);
					if ($this->MINTA_RUJUKAN->Exportable) $Doc->ExportCaption($this->MINTA_RUJUKAN);
					if ($this->NORUJUKAN_SEP->Exportable) $Doc->ExportCaption($this->NORUJUKAN_SEP);
					if ($this->PPKRUJUKANASAL_SEP->Exportable) $Doc->ExportCaption($this->PPKRUJUKANASAL_SEP);
					if ($this->NAMAPPKRUJUKANASAL_SEP->Exportable) $Doc->ExportCaption($this->NAMAPPKRUJUKANASAL_SEP);
					if ($this->PPKPELAYANAN_SEP->Exportable) $Doc->ExportCaption($this->PPKPELAYANAN_SEP);
					if ($this->JENISPERAWATAN_SEP->Exportable) $Doc->ExportCaption($this->JENISPERAWATAN_SEP);
					if ($this->CATATAN_SEP->Exportable) $Doc->ExportCaption($this->CATATAN_SEP);
					if ($this->DIAGNOSAAWAL_SEP->Exportable) $Doc->ExportCaption($this->DIAGNOSAAWAL_SEP);
					if ($this->NAMADIAGNOSA_SEP->Exportable) $Doc->ExportCaption($this->NAMADIAGNOSA_SEP);
					if ($this->LAKALANTAS_SEP->Exportable) $Doc->ExportCaption($this->LAKALANTAS_SEP);
					if ($this->LOKASILAKALANTAS->Exportable) $Doc->ExportCaption($this->LOKASILAKALANTAS);
					if ($this->USER->Exportable) $Doc->ExportCaption($this->USER);
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->bulan->Exportable) $Doc->ExportCaption($this->bulan);
					if ($this->tahun->Exportable) $Doc->ExportCaption($this->tahun);
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
						if ($this->IDXDAFTAR->Exportable) $Doc->ExportField($this->IDXDAFTAR);
						if ($this->TGLREG->Exportable) $Doc->ExportField($this->TGLREG);
						if ($this->NOMR->Exportable) $Doc->ExportField($this->NOMR);
						if ($this->KETERANGAN->Exportable) $Doc->ExportField($this->KETERANGAN);
						if ($this->NOKARTU_BPJS->Exportable) $Doc->ExportField($this->NOKARTU_BPJS);
						if ($this->NOKTP->Exportable) $Doc->ExportField($this->NOKTP);
						if ($this->KDDOKTER->Exportable) $Doc->ExportField($this->KDDOKTER);
						if ($this->KDPOLY->Exportable) $Doc->ExportField($this->KDPOLY);
						if ($this->KDRUJUK->Exportable) $Doc->ExportField($this->KDRUJUK);
						if ($this->KDCARABAYAR->Exportable) $Doc->ExportField($this->KDCARABAYAR);
						if ($this->NOJAMINAN->Exportable) $Doc->ExportField($this->NOJAMINAN);
						if ($this->SHIFT->Exportable) $Doc->ExportField($this->SHIFT);
						if ($this->STATUS->Exportable) $Doc->ExportField($this->STATUS);
						if ($this->KETERANGAN_STATUS->Exportable) $Doc->ExportField($this->KETERANGAN_STATUS);
						if ($this->PASIENBARU->Exportable) $Doc->ExportField($this->PASIENBARU);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->MASUKPOLY->Exportable) $Doc->ExportField($this->MASUKPOLY);
						if ($this->KELUARPOLY->Exportable) $Doc->ExportField($this->KELUARPOLY);
						if ($this->KETRUJUK->Exportable) $Doc->ExportField($this->KETRUJUK);
						if ($this->KETBAYAR->Exportable) $Doc->ExportField($this->KETBAYAR);
						if ($this->PENANGGUNGJAWAB_NAMA->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_NAMA);
						if ($this->PENANGGUNGJAWAB_HUBUNGAN->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_HUBUNGAN);
						if ($this->PENANGGUNGJAWAB_ALAMAT->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_ALAMAT);
						if ($this->PENANGGUNGJAWAB_PHONE->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_PHONE);
						if ($this->JAMREG->Exportable) $Doc->ExportField($this->JAMREG);
						if ($this->BATAL->Exportable) $Doc->ExportField($this->BATAL);
						if ($this->NO_SJP->Exportable) $Doc->ExportField($this->NO_SJP);
						if ($this->NO_PESERTA->Exportable) $Doc->ExportField($this->NO_PESERTA);
						if ($this->NOKARTU->Exportable) $Doc->ExportField($this->NOKARTU);
						if ($this->TANGGAL_SEP->Exportable) $Doc->ExportField($this->TANGGAL_SEP);
						if ($this->TANGGALRUJUK_SEP->Exportable) $Doc->ExportField($this->TANGGALRUJUK_SEP);
						if ($this->KELASRAWAT_SEP->Exportable) $Doc->ExportField($this->KELASRAWAT_SEP);
						if ($this->MINTA_RUJUKAN->Exportable) $Doc->ExportField($this->MINTA_RUJUKAN);
						if ($this->NORUJUKAN_SEP->Exportable) $Doc->ExportField($this->NORUJUKAN_SEP);
						if ($this->PPKRUJUKANASAL_SEP->Exportable) $Doc->ExportField($this->PPKRUJUKANASAL_SEP);
						if ($this->NAMAPPKRUJUKANASAL_SEP->Exportable) $Doc->ExportField($this->NAMAPPKRUJUKANASAL_SEP);
						if ($this->PPKPELAYANAN_SEP->Exportable) $Doc->ExportField($this->PPKPELAYANAN_SEP);
						if ($this->JENISPERAWATAN_SEP->Exportable) $Doc->ExportField($this->JENISPERAWATAN_SEP);
						if ($this->CATATAN_SEP->Exportable) $Doc->ExportField($this->CATATAN_SEP);
						if ($this->DIAGNOSAAWAL_SEP->Exportable) $Doc->ExportField($this->DIAGNOSAAWAL_SEP);
						if ($this->NAMADIAGNOSA_SEP->Exportable) $Doc->ExportField($this->NAMADIAGNOSA_SEP);
						if ($this->LAKALANTAS_SEP->Exportable) $Doc->ExportField($this->LAKALANTAS_SEP);
						if ($this->LOKASILAKALANTAS->Exportable) $Doc->ExportField($this->LOKASILAKALANTAS);
						if ($this->USER->Exportable) $Doc->ExportField($this->USER);
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->bulan->Exportable) $Doc->ExportField($this->bulan);
						if ($this->tahun->Exportable) $Doc->ExportField($this->tahun);
					} else {
						if ($this->IDXDAFTAR->Exportable) $Doc->ExportField($this->IDXDAFTAR);
						if ($this->TGLREG->Exportable) $Doc->ExportField($this->TGLREG);
						if ($this->NOMR->Exportable) $Doc->ExportField($this->NOMR);
						if ($this->KETERANGAN->Exportable) $Doc->ExportField($this->KETERANGAN);
						if ($this->NOKARTU_BPJS->Exportable) $Doc->ExportField($this->NOKARTU_BPJS);
						if ($this->NOKTP->Exportable) $Doc->ExportField($this->NOKTP);
						if ($this->KDDOKTER->Exportable) $Doc->ExportField($this->KDDOKTER);
						if ($this->KDPOLY->Exportable) $Doc->ExportField($this->KDPOLY);
						if ($this->KDRUJUK->Exportable) $Doc->ExportField($this->KDRUJUK);
						if ($this->KDCARABAYAR->Exportable) $Doc->ExportField($this->KDCARABAYAR);
						if ($this->NOJAMINAN->Exportable) $Doc->ExportField($this->NOJAMINAN);
						if ($this->SHIFT->Exportable) $Doc->ExportField($this->SHIFT);
						if ($this->STATUS->Exportable) $Doc->ExportField($this->STATUS);
						if ($this->KETERANGAN_STATUS->Exportable) $Doc->ExportField($this->KETERANGAN_STATUS);
						if ($this->PASIENBARU->Exportable) $Doc->ExportField($this->PASIENBARU);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->MASUKPOLY->Exportable) $Doc->ExportField($this->MASUKPOLY);
						if ($this->KELUARPOLY->Exportable) $Doc->ExportField($this->KELUARPOLY);
						if ($this->KETRUJUK->Exportable) $Doc->ExportField($this->KETRUJUK);
						if ($this->KETBAYAR->Exportable) $Doc->ExportField($this->KETBAYAR);
						if ($this->PENANGGUNGJAWAB_NAMA->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_NAMA);
						if ($this->PENANGGUNGJAWAB_HUBUNGAN->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_HUBUNGAN);
						if ($this->PENANGGUNGJAWAB_ALAMAT->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_ALAMAT);
						if ($this->PENANGGUNGJAWAB_PHONE->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_PHONE);
						if ($this->JAMREG->Exportable) $Doc->ExportField($this->JAMREG);
						if ($this->BATAL->Exportable) $Doc->ExportField($this->BATAL);
						if ($this->NO_SJP->Exportable) $Doc->ExportField($this->NO_SJP);
						if ($this->NO_PESERTA->Exportable) $Doc->ExportField($this->NO_PESERTA);
						if ($this->NOKARTU->Exportable) $Doc->ExportField($this->NOKARTU);
						if ($this->TANGGAL_SEP->Exportable) $Doc->ExportField($this->TANGGAL_SEP);
						if ($this->TANGGALRUJUK_SEP->Exportable) $Doc->ExportField($this->TANGGALRUJUK_SEP);
						if ($this->KELASRAWAT_SEP->Exportable) $Doc->ExportField($this->KELASRAWAT_SEP);
						if ($this->MINTA_RUJUKAN->Exportable) $Doc->ExportField($this->MINTA_RUJUKAN);
						if ($this->NORUJUKAN_SEP->Exportable) $Doc->ExportField($this->NORUJUKAN_SEP);
						if ($this->PPKRUJUKANASAL_SEP->Exportable) $Doc->ExportField($this->PPKRUJUKANASAL_SEP);
						if ($this->NAMAPPKRUJUKANASAL_SEP->Exportable) $Doc->ExportField($this->NAMAPPKRUJUKANASAL_SEP);
						if ($this->PPKPELAYANAN_SEP->Exportable) $Doc->ExportField($this->PPKPELAYANAN_SEP);
						if ($this->JENISPERAWATAN_SEP->Exportable) $Doc->ExportField($this->JENISPERAWATAN_SEP);
						if ($this->CATATAN_SEP->Exportable) $Doc->ExportField($this->CATATAN_SEP);
						if ($this->DIAGNOSAAWAL_SEP->Exportable) $Doc->ExportField($this->DIAGNOSAAWAL_SEP);
						if ($this->NAMADIAGNOSA_SEP->Exportable) $Doc->ExportField($this->NAMADIAGNOSA_SEP);
						if ($this->LAKALANTAS_SEP->Exportable) $Doc->ExportField($this->LAKALANTAS_SEP);
						if ($this->LOKASILAKALANTAS->Exportable) $Doc->ExportField($this->LOKASILAKALANTAS);
						if ($this->USER->Exportable) $Doc->ExportField($this->USER);
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->bulan->Exportable) $Doc->ExportField($this->bulan);
						if ($this->tahun->Exportable) $Doc->ExportField($this->tahun);
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
		$r = Security()->CurrentUserLevelID();
		if($r==4)
		{
			ew_AddFilter($filter, "TGLREG  >= (CURDATE() - interval 6 day)");
		}
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
	ew_Execute("call simrs2012.sp_simpan_order_admision('".$rsold["IDXDAFTAR"]."', '".$rsold["NOMR"]."', '".$rsold["KDPOLY"]."', '".$rsold["KDDOKTER"]."', '".$rsold["KDCARABAYAR"]."', '".$rsold["KDRUJUK"]."')");
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
