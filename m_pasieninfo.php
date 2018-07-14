<?php

// Global variable for table object
$m_pasien = NULL;

//
// Table class for m_pasien
//
class cm_pasien extends cTable {
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;
	var $id;
	var $NOMR;
	var $TITLE;
	var $NAMA;
	var $IBUKANDUNG;
	var $TEMPAT;
	var $TGLLAHIR;
	var $JENISKELAMIN;
	var $ALAMAT;
	var $KDPROVINSI;
	var $KOTA;
	var $KDKECAMATAN;
	var $KELURAHAN;
	var $NOTELP;
	var $NOKTP;
	var $SUAMI_ORTU;
	var $PEKERJAAN;
	var $STATUS;
	var $AGAMA;
	var $PENDIDIKAN;
	var $KDCARABAYAR;
	var $NIP;
	var $TGLDAFTAR;
	var $ALAMAT_KTP;
	var $PARENT_NOMR;
	var $NAMA_OBAT;
	var $DOSIS;
	var $CARA_PEMBERIAN;
	var $FREKUENSI;
	var $WAKTU_TGL;
	var $LAMA_WAKTU;
	var $ALERGI_OBAT;
	var $REAKSI_ALERGI;
	var $RIWAYAT_KES;
	var $BB_LAHIR;
	var $BB_SEKARANG;
	var $FISIK_FONTANEL;
	var $FISIK_REFLEKS;
	var $FISIK_SENSASI;
	var $MOTORIK_KASAR;
	var $MOTORIK_HALUS;
	var $MAMPU_BICARA;
	var $MAMPU_SOSIALISASI;
	var $BCG;
	var $POLIO;
	var $DPT;
	var $CAMPAK;
	var $HEPATITIS_B;
	var $TD;
	var $SUHU;
	var $RR;
	var $NADI;
	var $BB;
	var $TB;
	var $EYE;
	var $MOTORIK;
	var $VERBAL;
	var $TOTAL_GCS;
	var $REAKSI_PUPIL;
	var $KESADARAN;
	var $KEPALA;
	var $RAMBUT;
	var $MUKA;
	var $MATA;
	var $GANG_LIHAT;
	var $ALATBANTU_LIHAT;
	var $BENTUK;
	var $PENDENGARAN;
	var $LUB_TELINGA;
	var $BENTUK_HIDUNG;
	var $MEMBRAN_MUK;
	var $MAMPU_HIDU;
	var $ALAT_HIDUNG;
	var $RONGGA_MULUT;
	var $WARNA_MEMBRAN;
	var $LEMBAB;
	var $STOMATITIS;
	var $LIDAH;
	var $GIGI;
	var $TONSIL;
	var $KELAINAN;
	var $PERGERAKAN;
	var $KEL_TIROID;
	var $KEL_GETAH;
	var $TEKANAN_VENA;
	var $REF_MENELAN;
	var $NYERI;
	var $KREPITASI;
	var $KEL_LAIN;
	var $BENTUK_DADA;
	var $POLA_NAPAS;
	var $BENTUK_THORAKS;
	var $PAL_KREP;
	var $BENJOLAN;
	var $PAL_NYERI;
	var $PERKUSI;
	var $PARU;
	var $JANTUNG;
	var $SUARA_JANTUNG;
	var $ALATBANTU_JAN;
	var $BENTUK_ABDOMEN;
	var $AUSKULTASI;
	var $NYERI_PASI;
	var $PEM_KELENJAR;
	var $PERKUSI_AUS;
	var $VAGINA;
	var $MENSTRUASI;
	var $KATETER;
	var $LABIA_PROM;
	var $HAMIL;
	var $TGL_HAID;
	var $PERIKSA_CERVIX;
	var $BENTUK_PAYUDARA;
	var $KENYAL;
	var $MASSA;
	var $NYERI_RABA;
	var $BENTUK_PUTING;
	var $MAMMO;
	var $ALAT_KONTRASEPSI;
	var $MASALAH_SEKS;
	var $PREPUTIUM;
	var $MASALAH_PROSTAT;
	var $BENTUK_SKROTUM;
	var $TESTIS;
	var $MASSA_BEN;
	var $HERNIASI;
	var $LAIN2;
	var $ALAT_KONTRA;
	var $MASALAH_REPRO;
	var $EKSTREMITAS_ATAS;
	var $EKSTREMITAS_BAWAH;
	var $AKTIVITAS;
	var $BERJALAN;
	var $SISTEM_INTE;
	var $KENYAMANAN;
	var $KES_DIRI;
	var $SOS_SUPORT;
	var $ANSIETAS;
	var $KEHILANGAN;
	var $STATUS_EMOSI;
	var $KONSEP_DIRI;
	var $RESPON_HILANG;
	var $SUMBER_STRESS;
	var $BERARTI;
	var $TERLIBAT;
	var $HUBUNGAN;
	var $KOMUNIKASI;
	var $KEPUTUSAN;
	var $MENGASUH;
	var $DUKUNGAN;
	var $REAKSI;
	var $BUDAYA;
	var $POLA_AKTIVITAS;
	var $POLA_ISTIRAHAT;
	var $POLA_MAKAN;
	var $PANTANGAN;
	var $KEPERCAYAAN;
	var $PANTANGAN_HARI;
	var $PANTANGAN_LAIN;
	var $ANJURAN;
	var $NILAI_KEYAKINAN;
	var $KEGIATAN_IBADAH;
	var $PENG_AGAMA;
	var $SPIRIT;
	var $BANTUAN;
	var $PAHAM_PENYAKIT;
	var $PAHAM_OBAT;
	var $PAHAM_NUTRISI;
	var $PAHAM_RAWAT;
	var $HAMBATAN_EDUKASI;
	var $FREK_MAKAN;
	var $JUM_MAKAN;
	var $JEN_MAKAN;
	var $KOM_MAKAN;
	var $DIET;
	var $CARA_MAKAN;
	var $GANGGUAN;
	var $FREK_MINUM;
	var $JUM_MINUM;
	var $JEN_MINUM;
	var $GANG_MINUM;
	var $FREK_BAK;
	var $WARNA_BAK;
	var $JMLH_BAK;
	var $PENG_KAT_BAK;
	var $KEM_HAN_BAK;
	var $INKONT_BAK;
	var $DIURESIS_BAK;
	var $FREK_BAB;
	var $WARNA_BAB;
	var $KONSIST_BAB;
	var $GANG_BAB;
	var $STOMA_BAB;
	var $PENG_OBAT_BAB;
	var $IST_SIANG;
	var $IST_MALAM;
	var $IST_CAHAYA;
	var $IST_POSISI;
	var $IST_LING;
	var $IST_GANG_TIDUR;
	var $PENG_OBAT_IST;
	var $FREK_MAND;
	var $CUC_RAMB_MAND;
	var $SIH_GIGI_MAND;
	var $BANT_MAND;
	var $GANT_PAKAI;
	var $PAK_CUCI;
	var $PAK_BANT;
	var $ALT_BANT;
	var $KEMP_MUND;
	var $BIL_PUT;
	var $ADAPTIF;
	var $MALADAPTIF;
	var $PENANGGUNGJAWAB_NAMA;
	var $PENANGGUNGJAWAB_HUBUNGAN;
	var $PENANGGUNGJAWAB_ALAMAT;
	var $PENANGGUNGJAWAB_PHONE;
	var $obat2;
	var $PERBANDINGAN_BB;
	var $KONTINENSIA;
	var $JENIS_KULIT1;
	var $MOBILITAS;
	var $JK;
	var $UMUR;
	var $NAFSU_MAKAN;
	var $OBAT1;
	var $MALNUTRISI;
	var $MOTORIK1;
	var $SPINAL;
	var $MEJA_OPERASI;
	var $RIWAYAT_JATUH;
	var $DIAGNOSIS_SEKUNDER;
	var $ALAT_BANTU;
	var $HEPARIN;
	var $GAYA_BERJALAN;
	var $KESADARAN1;
	var $NOMR_LAMA;
	var $NO_KARTU;
	var $JNS_PASIEN;
	var $nama_ayah;
	var $nama_ibu;
	var $nama_suami;
	var $nama_istri;
	var $KD_ETNIS;
	var $KD_BHS_HARIAN;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'm_pasien';
		$this->TableName = 'm_pasien';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`m_pasien`";
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
		$this->id = new cField('m_pasien', 'm_pasien', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->Sortable = TRUE; // Allow sort
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// NOMR
		$this->NOMR = new cField('m_pasien', 'm_pasien', 'x_NOMR', 'NOMR', '`NOMR`', '`NOMR`', 200, -1, FALSE, '`NOMR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOMR->Sortable = TRUE; // Allow sort
		$this->fields['NOMR'] = &$this->NOMR;

		// TITLE
		$this->TITLE = new cField('m_pasien', 'm_pasien', 'x_TITLE', 'TITLE', '`TITLE`', '`TITLE`', 200, -1, FALSE, '`TITLE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->TITLE->Sortable = TRUE; // Allow sort
		$this->TITLE->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->TITLE->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['TITLE'] = &$this->TITLE;

		// NAMA
		$this->NAMA = new cField('m_pasien', 'm_pasien', 'x_NAMA', 'NAMA', '`NAMA`', '`NAMA`', 200, -1, FALSE, '`NAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMA->Sortable = TRUE; // Allow sort
		$this->fields['NAMA'] = &$this->NAMA;

		// IBUKANDUNG
		$this->IBUKANDUNG = new cField('m_pasien', 'm_pasien', 'x_IBUKANDUNG', 'IBUKANDUNG', '`IBUKANDUNG`', '`IBUKANDUNG`', 200, -1, FALSE, '`IBUKANDUNG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IBUKANDUNG->Sortable = TRUE; // Allow sort
		$this->fields['IBUKANDUNG'] = &$this->IBUKANDUNG;

		// TEMPAT
		$this->TEMPAT = new cField('m_pasien', 'm_pasien', 'x_TEMPAT', 'TEMPAT', '`TEMPAT`', '`TEMPAT`', 200, -1, FALSE, '`TEMPAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TEMPAT->Sortable = TRUE; // Allow sort
		$this->fields['TEMPAT'] = &$this->TEMPAT;

		// TGLLAHIR
		$this->TGLLAHIR = new cField('m_pasien', 'm_pasien', 'x_TGLLAHIR', 'TGLLAHIR', '`TGLLAHIR`', ew_CastDateFieldForLike('`TGLLAHIR`', 7, "DB"), 133, 7, FALSE, '`TGLLAHIR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGLLAHIR->Sortable = TRUE; // Allow sort
		$this->TGLLAHIR->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['TGLLAHIR'] = &$this->TGLLAHIR;

		// JENISKELAMIN
		$this->JENISKELAMIN = new cField('m_pasien', 'm_pasien', 'x_JENISKELAMIN', 'JENISKELAMIN', '`JENISKELAMIN`', '`JENISKELAMIN`', 200, -1, FALSE, '`JENISKELAMIN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->JENISKELAMIN->Sortable = TRUE; // Allow sort
		$this->fields['JENISKELAMIN'] = &$this->JENISKELAMIN;

		// ALAMAT
		$this->ALAMAT = new cField('m_pasien', 'm_pasien', 'x_ALAMAT', 'ALAMAT', '`ALAMAT`', '`ALAMAT`', 200, -1, FALSE, '`ALAMAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALAMAT->Sortable = TRUE; // Allow sort
		$this->fields['ALAMAT'] = &$this->ALAMAT;

		// KDPROVINSI
		$this->KDPROVINSI = new cField('m_pasien', 'm_pasien', 'x_KDPROVINSI', 'KDPROVINSI', '`KDPROVINSI`', '`KDPROVINSI`', 3, -1, FALSE, '`KDPROVINSI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDPROVINSI->Sortable = TRUE; // Allow sort
		$this->KDPROVINSI->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDPROVINSI->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDPROVINSI->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDPROVINSI'] = &$this->KDPROVINSI;

		// KOTA
		$this->KOTA = new cField('m_pasien', 'm_pasien', 'x_KOTA', 'KOTA', '`KOTA`', '`KOTA`', 200, -1, FALSE, '`KOTA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KOTA->Sortable = TRUE; // Allow sort
		$this->KOTA->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KOTA->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['KOTA'] = &$this->KOTA;

		// KDKECAMATAN
		$this->KDKECAMATAN = new cField('m_pasien', 'm_pasien', 'x_KDKECAMATAN', 'KDKECAMATAN', '`KDKECAMATAN`', '`KDKECAMATAN`', 3, -1, FALSE, '`KDKECAMATAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDKECAMATAN->Sortable = TRUE; // Allow sort
		$this->KDKECAMATAN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDKECAMATAN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDKECAMATAN->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDKECAMATAN'] = &$this->KDKECAMATAN;

		// KELURAHAN
		$this->KELURAHAN = new cField('m_pasien', 'm_pasien', 'x_KELURAHAN', 'KELURAHAN', '`KELURAHAN`', '`KELURAHAN`', 200, -1, FALSE, '`KELURAHAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KELURAHAN->Sortable = TRUE; // Allow sort
		$this->KELURAHAN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KELURAHAN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['KELURAHAN'] = &$this->KELURAHAN;

		// NOTELP
		$this->NOTELP = new cField('m_pasien', 'm_pasien', 'x_NOTELP', 'NOTELP', '`NOTELP`', '`NOTELP`', 200, -1, FALSE, '`NOTELP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOTELP->Sortable = TRUE; // Allow sort
		$this->fields['NOTELP'] = &$this->NOTELP;

		// NOKTP
		$this->NOKTP = new cField('m_pasien', 'm_pasien', 'x_NOKTP', 'NOKTP', '`NOKTP`', '`NOKTP`', 200, -1, FALSE, '`NOKTP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOKTP->Sortable = TRUE; // Allow sort
		$this->fields['NOKTP'] = &$this->NOKTP;

		// SUAMI_ORTU
		$this->SUAMI_ORTU = new cField('m_pasien', 'm_pasien', 'x_SUAMI_ORTU', 'SUAMI_ORTU', '`SUAMI_ORTU`', '`SUAMI_ORTU`', 200, -1, FALSE, '`SUAMI_ORTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SUAMI_ORTU->Sortable = TRUE; // Allow sort
		$this->fields['SUAMI_ORTU'] = &$this->SUAMI_ORTU;

		// PEKERJAAN
		$this->PEKERJAAN = new cField('m_pasien', 'm_pasien', 'x_PEKERJAAN', 'PEKERJAAN', '`PEKERJAAN`', '`PEKERJAAN`', 200, -1, FALSE, '`PEKERJAAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PEKERJAAN->Sortable = TRUE; // Allow sort
		$this->fields['PEKERJAAN'] = &$this->PEKERJAAN;

		// STATUS
		$this->STATUS = new cField('m_pasien', 'm_pasien', 'x_STATUS', 'STATUS', '`STATUS`', '`STATUS`', 3, -1, FALSE, '`STATUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->STATUS->Sortable = TRUE; // Allow sort
		$this->STATUS->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->STATUS->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->STATUS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['STATUS'] = &$this->STATUS;

		// AGAMA
		$this->AGAMA = new cField('m_pasien', 'm_pasien', 'x_AGAMA', 'AGAMA', '`AGAMA`', '`AGAMA`', 3, -1, FALSE, '`AGAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->AGAMA->Sortable = TRUE; // Allow sort
		$this->AGAMA->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->AGAMA->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->AGAMA->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['AGAMA'] = &$this->AGAMA;

		// PENDIDIKAN
		$this->PENDIDIKAN = new cField('m_pasien', 'm_pasien', 'x_PENDIDIKAN', 'PENDIDIKAN', '`PENDIDIKAN`', '`PENDIDIKAN`', 3, -1, FALSE, '`PENDIDIKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->PENDIDIKAN->Sortable = TRUE; // Allow sort
		$this->PENDIDIKAN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->PENDIDIKAN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->PENDIDIKAN->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['PENDIDIKAN'] = &$this->PENDIDIKAN;

		// KDCARABAYAR
		$this->KDCARABAYAR = new cField('m_pasien', 'm_pasien', 'x_KDCARABAYAR', 'KDCARABAYAR', '`KDCARABAYAR`', '`KDCARABAYAR`', 3, -1, FALSE, '`KDCARABAYAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KDCARABAYAR->Sortable = TRUE; // Allow sort
		$this->KDCARABAYAR->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KDCARABAYAR->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KDCARABAYAR->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KDCARABAYAR'] = &$this->KDCARABAYAR;

		// NIP
		$this->NIP = new cField('m_pasien', 'm_pasien', 'x_NIP', 'NIP', '`NIP`', '`NIP`', 200, -1, FALSE, '`NIP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NIP->Sortable = TRUE; // Allow sort
		$this->fields['NIP'] = &$this->NIP;

		// TGLDAFTAR
		$this->TGLDAFTAR = new cField('m_pasien', 'm_pasien', 'x_TGLDAFTAR', 'TGLDAFTAR', '`TGLDAFTAR`', ew_CastDateFieldForLike('`TGLDAFTAR`', 7, "DB"), 133, 7, FALSE, '`TGLDAFTAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGLDAFTAR->Sortable = TRUE; // Allow sort
		$this->TGLDAFTAR->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['TGLDAFTAR'] = &$this->TGLDAFTAR;

		// ALAMAT_KTP
		$this->ALAMAT_KTP = new cField('m_pasien', 'm_pasien', 'x_ALAMAT_KTP', 'ALAMAT_KTP', '`ALAMAT_KTP`', '`ALAMAT_KTP`', 200, -1, FALSE, '`ALAMAT_KTP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALAMAT_KTP->Sortable = TRUE; // Allow sort
		$this->fields['ALAMAT_KTP'] = &$this->ALAMAT_KTP;

		// PARENT_NOMR
		$this->PARENT_NOMR = new cField('m_pasien', 'm_pasien', 'x_PARENT_NOMR', 'PARENT_NOMR', '`PARENT_NOMR`', '`PARENT_NOMR`', 200, -1, FALSE, '`PARENT_NOMR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PARENT_NOMR->Sortable = TRUE; // Allow sort
		$this->fields['PARENT_NOMR'] = &$this->PARENT_NOMR;

		// NAMA_OBAT
		$this->NAMA_OBAT = new cField('m_pasien', 'm_pasien', 'x_NAMA_OBAT', 'NAMA_OBAT', '`NAMA_OBAT`', '`NAMA_OBAT`', 200, -1, FALSE, '`NAMA_OBAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAMA_OBAT->Sortable = TRUE; // Allow sort
		$this->fields['NAMA_OBAT'] = &$this->NAMA_OBAT;

		// DOSIS
		$this->DOSIS = new cField('m_pasien', 'm_pasien', 'x_DOSIS', 'DOSIS', '`DOSIS`', '`DOSIS`', 200, -1, FALSE, '`DOSIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DOSIS->Sortable = TRUE; // Allow sort
		$this->fields['DOSIS'] = &$this->DOSIS;

		// CARA_PEMBERIAN
		$this->CARA_PEMBERIAN = new cField('m_pasien', 'm_pasien', 'x_CARA_PEMBERIAN', 'CARA_PEMBERIAN', '`CARA_PEMBERIAN`', '`CARA_PEMBERIAN`', 200, -1, FALSE, '`CARA_PEMBERIAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CARA_PEMBERIAN->Sortable = TRUE; // Allow sort
		$this->fields['CARA_PEMBERIAN'] = &$this->CARA_PEMBERIAN;

		// FREKUENSI
		$this->FREKUENSI = new cField('m_pasien', 'm_pasien', 'x_FREKUENSI', 'FREKUENSI', '`FREKUENSI`', '`FREKUENSI`', 200, -1, FALSE, '`FREKUENSI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FREKUENSI->Sortable = TRUE; // Allow sort
		$this->fields['FREKUENSI'] = &$this->FREKUENSI;

		// WAKTU_TGL
		$this->WAKTU_TGL = new cField('m_pasien', 'm_pasien', 'x_WAKTU_TGL', 'WAKTU_TGL', '`WAKTU_TGL`', '`WAKTU_TGL`', 200, -1, FALSE, '`WAKTU_TGL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->WAKTU_TGL->Sortable = TRUE; // Allow sort
		$this->fields['WAKTU_TGL'] = &$this->WAKTU_TGL;

		// LAMA_WAKTU
		$this->LAMA_WAKTU = new cField('m_pasien', 'm_pasien', 'x_LAMA_WAKTU', 'LAMA_WAKTU', '`LAMA_WAKTU`', '`LAMA_WAKTU`', 200, -1, FALSE, '`LAMA_WAKTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAMA_WAKTU->Sortable = TRUE; // Allow sort
		$this->fields['LAMA_WAKTU'] = &$this->LAMA_WAKTU;

		// ALERGI_OBAT
		$this->ALERGI_OBAT = new cField('m_pasien', 'm_pasien', 'x_ALERGI_OBAT', 'ALERGI_OBAT', '`ALERGI_OBAT`', '`ALERGI_OBAT`', 200, -1, FALSE, '`ALERGI_OBAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALERGI_OBAT->Sortable = TRUE; // Allow sort
		$this->fields['ALERGI_OBAT'] = &$this->ALERGI_OBAT;

		// REAKSI_ALERGI
		$this->REAKSI_ALERGI = new cField('m_pasien', 'm_pasien', 'x_REAKSI_ALERGI', 'REAKSI_ALERGI', '`REAKSI_ALERGI`', '`REAKSI_ALERGI`', 200, -1, FALSE, '`REAKSI_ALERGI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->REAKSI_ALERGI->Sortable = TRUE; // Allow sort
		$this->fields['REAKSI_ALERGI'] = &$this->REAKSI_ALERGI;

		// RIWAYAT_KES
		$this->RIWAYAT_KES = new cField('m_pasien', 'm_pasien', 'x_RIWAYAT_KES', 'RIWAYAT_KES', '`RIWAYAT_KES`', '`RIWAYAT_KES`', 200, -1, FALSE, '`RIWAYAT_KES`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RIWAYAT_KES->Sortable = TRUE; // Allow sort
		$this->fields['RIWAYAT_KES'] = &$this->RIWAYAT_KES;

		// BB_LAHIR
		$this->BB_LAHIR = new cField('m_pasien', 'm_pasien', 'x_BB_LAHIR', 'BB_LAHIR', '`BB_LAHIR`', '`BB_LAHIR`', 200, -1, FALSE, '`BB_LAHIR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BB_LAHIR->Sortable = TRUE; // Allow sort
		$this->fields['BB_LAHIR'] = &$this->BB_LAHIR;

		// BB_SEKARANG
		$this->BB_SEKARANG = new cField('m_pasien', 'm_pasien', 'x_BB_SEKARANG', 'BB_SEKARANG', '`BB_SEKARANG`', '`BB_SEKARANG`', 200, -1, FALSE, '`BB_SEKARANG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BB_SEKARANG->Sortable = TRUE; // Allow sort
		$this->fields['BB_SEKARANG'] = &$this->BB_SEKARANG;

		// FISIK_FONTANEL
		$this->FISIK_FONTANEL = new cField('m_pasien', 'm_pasien', 'x_FISIK_FONTANEL', 'FISIK_FONTANEL', '`FISIK_FONTANEL`', '`FISIK_FONTANEL`', 200, -1, FALSE, '`FISIK_FONTANEL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FISIK_FONTANEL->Sortable = TRUE; // Allow sort
		$this->fields['FISIK_FONTANEL'] = &$this->FISIK_FONTANEL;

		// FISIK_REFLEKS
		$this->FISIK_REFLEKS = new cField('m_pasien', 'm_pasien', 'x_FISIK_REFLEKS', 'FISIK_REFLEKS', '`FISIK_REFLEKS`', '`FISIK_REFLEKS`', 200, -1, FALSE, '`FISIK_REFLEKS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FISIK_REFLEKS->Sortable = TRUE; // Allow sort
		$this->fields['FISIK_REFLEKS'] = &$this->FISIK_REFLEKS;

		// FISIK_SENSASI
		$this->FISIK_SENSASI = new cField('m_pasien', 'm_pasien', 'x_FISIK_SENSASI', 'FISIK_SENSASI', '`FISIK_SENSASI`', '`FISIK_SENSASI`', 200, -1, FALSE, '`FISIK_SENSASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FISIK_SENSASI->Sortable = TRUE; // Allow sort
		$this->fields['FISIK_SENSASI'] = &$this->FISIK_SENSASI;

		// MOTORIK_KASAR
		$this->MOTORIK_KASAR = new cField('m_pasien', 'm_pasien', 'x_MOTORIK_KASAR', 'MOTORIK_KASAR', '`MOTORIK_KASAR`', '`MOTORIK_KASAR`', 200, -1, FALSE, '`MOTORIK_KASAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MOTORIK_KASAR->Sortable = TRUE; // Allow sort
		$this->fields['MOTORIK_KASAR'] = &$this->MOTORIK_KASAR;

		// MOTORIK_HALUS
		$this->MOTORIK_HALUS = new cField('m_pasien', 'm_pasien', 'x_MOTORIK_HALUS', 'MOTORIK_HALUS', '`MOTORIK_HALUS`', '`MOTORIK_HALUS`', 200, -1, FALSE, '`MOTORIK_HALUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MOTORIK_HALUS->Sortable = TRUE; // Allow sort
		$this->fields['MOTORIK_HALUS'] = &$this->MOTORIK_HALUS;

		// MAMPU_BICARA
		$this->MAMPU_BICARA = new cField('m_pasien', 'm_pasien', 'x_MAMPU_BICARA', 'MAMPU_BICARA', '`MAMPU_BICARA`', '`MAMPU_BICARA`', 200, -1, FALSE, '`MAMPU_BICARA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MAMPU_BICARA->Sortable = TRUE; // Allow sort
		$this->fields['MAMPU_BICARA'] = &$this->MAMPU_BICARA;

		// MAMPU_SOSIALISASI
		$this->MAMPU_SOSIALISASI = new cField('m_pasien', 'm_pasien', 'x_MAMPU_SOSIALISASI', 'MAMPU_SOSIALISASI', '`MAMPU_SOSIALISASI`', '`MAMPU_SOSIALISASI`', 200, -1, FALSE, '`MAMPU_SOSIALISASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MAMPU_SOSIALISASI->Sortable = TRUE; // Allow sort
		$this->fields['MAMPU_SOSIALISASI'] = &$this->MAMPU_SOSIALISASI;

		// BCG
		$this->BCG = new cField('m_pasien', 'm_pasien', 'x_BCG', 'BCG', '`BCG`', '`BCG`', 200, -1, FALSE, '`BCG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BCG->Sortable = TRUE; // Allow sort
		$this->fields['BCG'] = &$this->BCG;

		// POLIO
		$this->POLIO = new cField('m_pasien', 'm_pasien', 'x_POLIO', 'POLIO', '`POLIO`', '`POLIO`', 200, -1, FALSE, '`POLIO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->POLIO->Sortable = TRUE; // Allow sort
		$this->fields['POLIO'] = &$this->POLIO;

		// DPT
		$this->DPT = new cField('m_pasien', 'm_pasien', 'x_DPT', 'DPT', '`DPT`', '`DPT`', 200, -1, FALSE, '`DPT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DPT->Sortable = TRUE; // Allow sort
		$this->fields['DPT'] = &$this->DPT;

		// CAMPAK
		$this->CAMPAK = new cField('m_pasien', 'm_pasien', 'x_CAMPAK', 'CAMPAK', '`CAMPAK`', '`CAMPAK`', 200, -1, FALSE, '`CAMPAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CAMPAK->Sortable = TRUE; // Allow sort
		$this->fields['CAMPAK'] = &$this->CAMPAK;

		// HEPATITIS_B
		$this->HEPATITIS_B = new cField('m_pasien', 'm_pasien', 'x_HEPATITIS_B', 'HEPATITIS_B', '`HEPATITIS_B`', '`HEPATITIS_B`', 200, -1, FALSE, '`HEPATITIS_B`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HEPATITIS_B->Sortable = TRUE; // Allow sort
		$this->fields['HEPATITIS_B'] = &$this->HEPATITIS_B;

		// TD
		$this->TD = new cField('m_pasien', 'm_pasien', 'x_TD', 'TD', '`TD`', '`TD`', 200, -1, FALSE, '`TD`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TD->Sortable = TRUE; // Allow sort
		$this->fields['TD'] = &$this->TD;

		// SUHU
		$this->SUHU = new cField('m_pasien', 'm_pasien', 'x_SUHU', 'SUHU', '`SUHU`', '`SUHU`', 200, -1, FALSE, '`SUHU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SUHU->Sortable = TRUE; // Allow sort
		$this->fields['SUHU'] = &$this->SUHU;

		// RR
		$this->RR = new cField('m_pasien', 'm_pasien', 'x_RR', 'RR', '`RR`', '`RR`', 200, -1, FALSE, '`RR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RR->Sortable = TRUE; // Allow sort
		$this->fields['RR'] = &$this->RR;

		// NADI
		$this->NADI = new cField('m_pasien', 'm_pasien', 'x_NADI', 'NADI', '`NADI`', '`NADI`', 200, -1, FALSE, '`NADI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NADI->Sortable = TRUE; // Allow sort
		$this->fields['NADI'] = &$this->NADI;

		// BB
		$this->BB = new cField('m_pasien', 'm_pasien', 'x_BB', 'BB', '`BB`', '`BB`', 200, -1, FALSE, '`BB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BB->Sortable = TRUE; // Allow sort
		$this->fields['BB'] = &$this->BB;

		// TB
		$this->TB = new cField('m_pasien', 'm_pasien', 'x_TB', 'TB', '`TB`', '`TB`', 200, -1, FALSE, '`TB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TB->Sortable = TRUE; // Allow sort
		$this->fields['TB'] = &$this->TB;

		// EYE
		$this->EYE = new cField('m_pasien', 'm_pasien', 'x_EYE', 'EYE', '`EYE`', '`EYE`', 200, -1, FALSE, '`EYE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->EYE->Sortable = TRUE; // Allow sort
		$this->fields['EYE'] = &$this->EYE;

		// MOTORIK
		$this->MOTORIK = new cField('m_pasien', 'm_pasien', 'x_MOTORIK', 'MOTORIK', '`MOTORIK`', '`MOTORIK`', 200, -1, FALSE, '`MOTORIK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MOTORIK->Sortable = TRUE; // Allow sort
		$this->fields['MOTORIK'] = &$this->MOTORIK;

		// VERBAL
		$this->VERBAL = new cField('m_pasien', 'm_pasien', 'x_VERBAL', 'VERBAL', '`VERBAL`', '`VERBAL`', 200, -1, FALSE, '`VERBAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->VERBAL->Sortable = TRUE; // Allow sort
		$this->fields['VERBAL'] = &$this->VERBAL;

		// TOTAL_GCS
		$this->TOTAL_GCS = new cField('m_pasien', 'm_pasien', 'x_TOTAL_GCS', 'TOTAL_GCS', '`TOTAL_GCS`', '`TOTAL_GCS`', 200, -1, FALSE, '`TOTAL_GCS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TOTAL_GCS->Sortable = TRUE; // Allow sort
		$this->fields['TOTAL_GCS'] = &$this->TOTAL_GCS;

		// REAKSI_PUPIL
		$this->REAKSI_PUPIL = new cField('m_pasien', 'm_pasien', 'x_REAKSI_PUPIL', 'REAKSI_PUPIL', '`REAKSI_PUPIL`', '`REAKSI_PUPIL`', 200, -1, FALSE, '`REAKSI_PUPIL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->REAKSI_PUPIL->Sortable = TRUE; // Allow sort
		$this->fields['REAKSI_PUPIL'] = &$this->REAKSI_PUPIL;

		// KESADARAN
		$this->KESADARAN = new cField('m_pasien', 'm_pasien', 'x_KESADARAN', 'KESADARAN', '`KESADARAN`', '`KESADARAN`', 200, -1, FALSE, '`KESADARAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KESADARAN->Sortable = TRUE; // Allow sort
		$this->fields['KESADARAN'] = &$this->KESADARAN;

		// KEPALA
		$this->KEPALA = new cField('m_pasien', 'm_pasien', 'x_KEPALA', 'KEPALA', '`KEPALA`', '`KEPALA`', 200, -1, FALSE, '`KEPALA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEPALA->Sortable = TRUE; // Allow sort
		$this->fields['KEPALA'] = &$this->KEPALA;

		// RAMBUT
		$this->RAMBUT = new cField('m_pasien', 'm_pasien', 'x_RAMBUT', 'RAMBUT', '`RAMBUT`', '`RAMBUT`', 200, -1, FALSE, '`RAMBUT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RAMBUT->Sortable = TRUE; // Allow sort
		$this->fields['RAMBUT'] = &$this->RAMBUT;

		// MUKA
		$this->MUKA = new cField('m_pasien', 'm_pasien', 'x_MUKA', 'MUKA', '`MUKA`', '`MUKA`', 200, -1, FALSE, '`MUKA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MUKA->Sortable = TRUE; // Allow sort
		$this->fields['MUKA'] = &$this->MUKA;

		// MATA
		$this->MATA = new cField('m_pasien', 'm_pasien', 'x_MATA', 'MATA', '`MATA`', '`MATA`', 200, -1, FALSE, '`MATA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MATA->Sortable = TRUE; // Allow sort
		$this->fields['MATA'] = &$this->MATA;

		// GANG_LIHAT
		$this->GANG_LIHAT = new cField('m_pasien', 'm_pasien', 'x_GANG_LIHAT', 'GANG_LIHAT', '`GANG_LIHAT`', '`GANG_LIHAT`', 200, -1, FALSE, '`GANG_LIHAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->GANG_LIHAT->Sortable = TRUE; // Allow sort
		$this->fields['GANG_LIHAT'] = &$this->GANG_LIHAT;

		// ALATBANTU_LIHAT
		$this->ALATBANTU_LIHAT = new cField('m_pasien', 'm_pasien', 'x_ALATBANTU_LIHAT', 'ALATBANTU_LIHAT', '`ALATBANTU_LIHAT`', '`ALATBANTU_LIHAT`', 200, -1, FALSE, '`ALATBANTU_LIHAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALATBANTU_LIHAT->Sortable = TRUE; // Allow sort
		$this->fields['ALATBANTU_LIHAT'] = &$this->ALATBANTU_LIHAT;

		// BENTUK
		$this->BENTUK = new cField('m_pasien', 'm_pasien', 'x_BENTUK', 'BENTUK', '`BENTUK`', '`BENTUK`', 200, -1, FALSE, '`BENTUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK'] = &$this->BENTUK;

		// PENDENGARAN
		$this->PENDENGARAN = new cField('m_pasien', 'm_pasien', 'x_PENDENGARAN', 'PENDENGARAN', '`PENDENGARAN`', '`PENDENGARAN`', 200, -1, FALSE, '`PENDENGARAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENDENGARAN->Sortable = TRUE; // Allow sort
		$this->fields['PENDENGARAN'] = &$this->PENDENGARAN;

		// LUB_TELINGA
		$this->LUB_TELINGA = new cField('m_pasien', 'm_pasien', 'x_LUB_TELINGA', 'LUB_TELINGA', '`LUB_TELINGA`', '`LUB_TELINGA`', 200, -1, FALSE, '`LUB_TELINGA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LUB_TELINGA->Sortable = TRUE; // Allow sort
		$this->fields['LUB_TELINGA'] = &$this->LUB_TELINGA;

		// BENTUK_HIDUNG
		$this->BENTUK_HIDUNG = new cField('m_pasien', 'm_pasien', 'x_BENTUK_HIDUNG', 'BENTUK_HIDUNG', '`BENTUK_HIDUNG`', '`BENTUK_HIDUNG`', 200, -1, FALSE, '`BENTUK_HIDUNG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK_HIDUNG->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK_HIDUNG'] = &$this->BENTUK_HIDUNG;

		// MEMBRAN_MUK
		$this->MEMBRAN_MUK = new cField('m_pasien', 'm_pasien', 'x_MEMBRAN_MUK', 'MEMBRAN_MUK', '`MEMBRAN_MUK`', '`MEMBRAN_MUK`', 200, -1, FALSE, '`MEMBRAN_MUK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MEMBRAN_MUK->Sortable = TRUE; // Allow sort
		$this->fields['MEMBRAN_MUK'] = &$this->MEMBRAN_MUK;

		// MAMPU_HIDU
		$this->MAMPU_HIDU = new cField('m_pasien', 'm_pasien', 'x_MAMPU_HIDU', 'MAMPU_HIDU', '`MAMPU_HIDU`', '`MAMPU_HIDU`', 200, -1, FALSE, '`MAMPU_HIDU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MAMPU_HIDU->Sortable = TRUE; // Allow sort
		$this->fields['MAMPU_HIDU'] = &$this->MAMPU_HIDU;

		// ALAT_HIDUNG
		$this->ALAT_HIDUNG = new cField('m_pasien', 'm_pasien', 'x_ALAT_HIDUNG', 'ALAT_HIDUNG', '`ALAT_HIDUNG`', '`ALAT_HIDUNG`', 200, -1, FALSE, '`ALAT_HIDUNG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALAT_HIDUNG->Sortable = TRUE; // Allow sort
		$this->fields['ALAT_HIDUNG'] = &$this->ALAT_HIDUNG;

		// RONGGA_MULUT
		$this->RONGGA_MULUT = new cField('m_pasien', 'm_pasien', 'x_RONGGA_MULUT', 'RONGGA_MULUT', '`RONGGA_MULUT`', '`RONGGA_MULUT`', 200, -1, FALSE, '`RONGGA_MULUT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RONGGA_MULUT->Sortable = TRUE; // Allow sort
		$this->fields['RONGGA_MULUT'] = &$this->RONGGA_MULUT;

		// WARNA_MEMBRAN
		$this->WARNA_MEMBRAN = new cField('m_pasien', 'm_pasien', 'x_WARNA_MEMBRAN', 'WARNA_MEMBRAN', '`WARNA_MEMBRAN`', '`WARNA_MEMBRAN`', 200, -1, FALSE, '`WARNA_MEMBRAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->WARNA_MEMBRAN->Sortable = TRUE; // Allow sort
		$this->fields['WARNA_MEMBRAN'] = &$this->WARNA_MEMBRAN;

		// LEMBAB
		$this->LEMBAB = new cField('m_pasien', 'm_pasien', 'x_LEMBAB', 'LEMBAB', '`LEMBAB`', '`LEMBAB`', 200, -1, FALSE, '`LEMBAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LEMBAB->Sortable = TRUE; // Allow sort
		$this->fields['LEMBAB'] = &$this->LEMBAB;

		// STOMATITIS
		$this->STOMATITIS = new cField('m_pasien', 'm_pasien', 'x_STOMATITIS', 'STOMATITIS', '`STOMATITIS`', '`STOMATITIS`', 200, -1, FALSE, '`STOMATITIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->STOMATITIS->Sortable = TRUE; // Allow sort
		$this->fields['STOMATITIS'] = &$this->STOMATITIS;

		// LIDAH
		$this->LIDAH = new cField('m_pasien', 'm_pasien', 'x_LIDAH', 'LIDAH', '`LIDAH`', '`LIDAH`', 200, -1, FALSE, '`LIDAH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LIDAH->Sortable = TRUE; // Allow sort
		$this->fields['LIDAH'] = &$this->LIDAH;

		// GIGI
		$this->GIGI = new cField('m_pasien', 'm_pasien', 'x_GIGI', 'GIGI', '`GIGI`', '`GIGI`', 200, -1, FALSE, '`GIGI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->GIGI->Sortable = TRUE; // Allow sort
		$this->fields['GIGI'] = &$this->GIGI;

		// TONSIL
		$this->TONSIL = new cField('m_pasien', 'm_pasien', 'x_TONSIL', 'TONSIL', '`TONSIL`', '`TONSIL`', 200, -1, FALSE, '`TONSIL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TONSIL->Sortable = TRUE; // Allow sort
		$this->fields['TONSIL'] = &$this->TONSIL;

		// KELAINAN
		$this->KELAINAN = new cField('m_pasien', 'm_pasien', 'x_KELAINAN', 'KELAINAN', '`KELAINAN`', '`KELAINAN`', 200, -1, FALSE, '`KELAINAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KELAINAN->Sortable = TRUE; // Allow sort
		$this->fields['KELAINAN'] = &$this->KELAINAN;

		// PERGERAKAN
		$this->PERGERAKAN = new cField('m_pasien', 'm_pasien', 'x_PERGERAKAN', 'PERGERAKAN', '`PERGERAKAN`', '`PERGERAKAN`', 200, -1, FALSE, '`PERGERAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PERGERAKAN->Sortable = TRUE; // Allow sort
		$this->fields['PERGERAKAN'] = &$this->PERGERAKAN;

		// KEL_TIROID
		$this->KEL_TIROID = new cField('m_pasien', 'm_pasien', 'x_KEL_TIROID', 'KEL_TIROID', '`KEL_TIROID`', '`KEL_TIROID`', 200, -1, FALSE, '`KEL_TIROID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEL_TIROID->Sortable = TRUE; // Allow sort
		$this->fields['KEL_TIROID'] = &$this->KEL_TIROID;

		// KEL_GETAH
		$this->KEL_GETAH = new cField('m_pasien', 'm_pasien', 'x_KEL_GETAH', 'KEL_GETAH', '`KEL_GETAH`', '`KEL_GETAH`', 200, -1, FALSE, '`KEL_GETAH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEL_GETAH->Sortable = TRUE; // Allow sort
		$this->fields['KEL_GETAH'] = &$this->KEL_GETAH;

		// TEKANAN_VENA
		$this->TEKANAN_VENA = new cField('m_pasien', 'm_pasien', 'x_TEKANAN_VENA', 'TEKANAN_VENA', '`TEKANAN_VENA`', '`TEKANAN_VENA`', 200, -1, FALSE, '`TEKANAN_VENA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TEKANAN_VENA->Sortable = TRUE; // Allow sort
		$this->fields['TEKANAN_VENA'] = &$this->TEKANAN_VENA;

		// REF_MENELAN
		$this->REF_MENELAN = new cField('m_pasien', 'm_pasien', 'x_REF_MENELAN', 'REF_MENELAN', '`REF_MENELAN`', '`REF_MENELAN`', 200, -1, FALSE, '`REF_MENELAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->REF_MENELAN->Sortable = TRUE; // Allow sort
		$this->fields['REF_MENELAN'] = &$this->REF_MENELAN;

		// NYERI
		$this->NYERI = new cField('m_pasien', 'm_pasien', 'x_NYERI', 'NYERI', '`NYERI`', '`NYERI`', 200, -1, FALSE, '`NYERI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NYERI->Sortable = TRUE; // Allow sort
		$this->fields['NYERI'] = &$this->NYERI;

		// KREPITASI
		$this->KREPITASI = new cField('m_pasien', 'm_pasien', 'x_KREPITASI', 'KREPITASI', '`KREPITASI`', '`KREPITASI`', 200, -1, FALSE, '`KREPITASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KREPITASI->Sortable = TRUE; // Allow sort
		$this->fields['KREPITASI'] = &$this->KREPITASI;

		// KEL_LAIN
		$this->KEL_LAIN = new cField('m_pasien', 'm_pasien', 'x_KEL_LAIN', 'KEL_LAIN', '`KEL_LAIN`', '`KEL_LAIN`', 200, -1, FALSE, '`KEL_LAIN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEL_LAIN->Sortable = TRUE; // Allow sort
		$this->fields['KEL_LAIN'] = &$this->KEL_LAIN;

		// BENTUK_DADA
		$this->BENTUK_DADA = new cField('m_pasien', 'm_pasien', 'x_BENTUK_DADA', 'BENTUK_DADA', '`BENTUK_DADA`', '`BENTUK_DADA`', 200, -1, FALSE, '`BENTUK_DADA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK_DADA->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK_DADA'] = &$this->BENTUK_DADA;

		// POLA_NAPAS
		$this->POLA_NAPAS = new cField('m_pasien', 'm_pasien', 'x_POLA_NAPAS', 'POLA_NAPAS', '`POLA_NAPAS`', '`POLA_NAPAS`', 200, -1, FALSE, '`POLA_NAPAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->POLA_NAPAS->Sortable = TRUE; // Allow sort
		$this->fields['POLA_NAPAS'] = &$this->POLA_NAPAS;

		// BENTUK_THORAKS
		$this->BENTUK_THORAKS = new cField('m_pasien', 'm_pasien', 'x_BENTUK_THORAKS', 'BENTUK_THORAKS', '`BENTUK_THORAKS`', '`BENTUK_THORAKS`', 200, -1, FALSE, '`BENTUK_THORAKS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK_THORAKS->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK_THORAKS'] = &$this->BENTUK_THORAKS;

		// PAL_KREP
		$this->PAL_KREP = new cField('m_pasien', 'm_pasien', 'x_PAL_KREP', 'PAL_KREP', '`PAL_KREP`', '`PAL_KREP`', 200, -1, FALSE, '`PAL_KREP`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAL_KREP->Sortable = TRUE; // Allow sort
		$this->fields['PAL_KREP'] = &$this->PAL_KREP;

		// BENJOLAN
		$this->BENJOLAN = new cField('m_pasien', 'm_pasien', 'x_BENJOLAN', 'BENJOLAN', '`BENJOLAN`', '`BENJOLAN`', 200, -1, FALSE, '`BENJOLAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENJOLAN->Sortable = TRUE; // Allow sort
		$this->fields['BENJOLAN'] = &$this->BENJOLAN;

		// PAL_NYERI
		$this->PAL_NYERI = new cField('m_pasien', 'm_pasien', 'x_PAL_NYERI', 'PAL_NYERI', '`PAL_NYERI`', '`PAL_NYERI`', 200, -1, FALSE, '`PAL_NYERI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAL_NYERI->Sortable = TRUE; // Allow sort
		$this->fields['PAL_NYERI'] = &$this->PAL_NYERI;

		// PERKUSI
		$this->PERKUSI = new cField('m_pasien', 'm_pasien', 'x_PERKUSI', 'PERKUSI', '`PERKUSI`', '`PERKUSI`', 200, -1, FALSE, '`PERKUSI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PERKUSI->Sortable = TRUE; // Allow sort
		$this->fields['PERKUSI'] = &$this->PERKUSI;

		// PARU
		$this->PARU = new cField('m_pasien', 'm_pasien', 'x_PARU', 'PARU', '`PARU`', '`PARU`', 200, -1, FALSE, '`PARU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PARU->Sortable = TRUE; // Allow sort
		$this->fields['PARU'] = &$this->PARU;

		// JANTUNG
		$this->JANTUNG = new cField('m_pasien', 'm_pasien', 'x_JANTUNG', 'JANTUNG', '`JANTUNG`', '`JANTUNG`', 200, -1, FALSE, '`JANTUNG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JANTUNG->Sortable = TRUE; // Allow sort
		$this->fields['JANTUNG'] = &$this->JANTUNG;

		// SUARA_JANTUNG
		$this->SUARA_JANTUNG = new cField('m_pasien', 'm_pasien', 'x_SUARA_JANTUNG', 'SUARA_JANTUNG', '`SUARA_JANTUNG`', '`SUARA_JANTUNG`', 200, -1, FALSE, '`SUARA_JANTUNG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SUARA_JANTUNG->Sortable = TRUE; // Allow sort
		$this->fields['SUARA_JANTUNG'] = &$this->SUARA_JANTUNG;

		// ALATBANTU_JAN
		$this->ALATBANTU_JAN = new cField('m_pasien', 'm_pasien', 'x_ALATBANTU_JAN', 'ALATBANTU_JAN', '`ALATBANTU_JAN`', '`ALATBANTU_JAN`', 200, -1, FALSE, '`ALATBANTU_JAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALATBANTU_JAN->Sortable = TRUE; // Allow sort
		$this->fields['ALATBANTU_JAN'] = &$this->ALATBANTU_JAN;

		// BENTUK_ABDOMEN
		$this->BENTUK_ABDOMEN = new cField('m_pasien', 'm_pasien', 'x_BENTUK_ABDOMEN', 'BENTUK_ABDOMEN', '`BENTUK_ABDOMEN`', '`BENTUK_ABDOMEN`', 200, -1, FALSE, '`BENTUK_ABDOMEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK_ABDOMEN->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK_ABDOMEN'] = &$this->BENTUK_ABDOMEN;

		// AUSKULTASI
		$this->AUSKULTASI = new cField('m_pasien', 'm_pasien', 'x_AUSKULTASI', 'AUSKULTASI', '`AUSKULTASI`', '`AUSKULTASI`', 200, -1, FALSE, '`AUSKULTASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->AUSKULTASI->Sortable = TRUE; // Allow sort
		$this->fields['AUSKULTASI'] = &$this->AUSKULTASI;

		// NYERI_PASI
		$this->NYERI_PASI = new cField('m_pasien', 'm_pasien', 'x_NYERI_PASI', 'NYERI_PASI', '`NYERI_PASI`', '`NYERI_PASI`', 200, -1, FALSE, '`NYERI_PASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NYERI_PASI->Sortable = TRUE; // Allow sort
		$this->fields['NYERI_PASI'] = &$this->NYERI_PASI;

		// PEM_KELENJAR
		$this->PEM_KELENJAR = new cField('m_pasien', 'm_pasien', 'x_PEM_KELENJAR', 'PEM_KELENJAR', '`PEM_KELENJAR`', '`PEM_KELENJAR`', 200, -1, FALSE, '`PEM_KELENJAR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PEM_KELENJAR->Sortable = TRUE; // Allow sort
		$this->fields['PEM_KELENJAR'] = &$this->PEM_KELENJAR;

		// PERKUSI_AUS
		$this->PERKUSI_AUS = new cField('m_pasien', 'm_pasien', 'x_PERKUSI_AUS', 'PERKUSI_AUS', '`PERKUSI_AUS`', '`PERKUSI_AUS`', 200, -1, FALSE, '`PERKUSI_AUS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PERKUSI_AUS->Sortable = TRUE; // Allow sort
		$this->fields['PERKUSI_AUS'] = &$this->PERKUSI_AUS;

		// VAGINA
		$this->VAGINA = new cField('m_pasien', 'm_pasien', 'x_VAGINA', 'VAGINA', '`VAGINA`', '`VAGINA`', 200, -1, FALSE, '`VAGINA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->VAGINA->Sortable = TRUE; // Allow sort
		$this->fields['VAGINA'] = &$this->VAGINA;

		// MENSTRUASI
		$this->MENSTRUASI = new cField('m_pasien', 'm_pasien', 'x_MENSTRUASI', 'MENSTRUASI', '`MENSTRUASI`', '`MENSTRUASI`', 200, -1, FALSE, '`MENSTRUASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MENSTRUASI->Sortable = TRUE; // Allow sort
		$this->fields['MENSTRUASI'] = &$this->MENSTRUASI;

		// KATETER
		$this->KATETER = new cField('m_pasien', 'm_pasien', 'x_KATETER', 'KATETER', '`KATETER`', '`KATETER`', 200, -1, FALSE, '`KATETER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KATETER->Sortable = TRUE; // Allow sort
		$this->fields['KATETER'] = &$this->KATETER;

		// LABIA_PROM
		$this->LABIA_PROM = new cField('m_pasien', 'm_pasien', 'x_LABIA_PROM', 'LABIA_PROM', '`LABIA_PROM`', '`LABIA_PROM`', 200, -1, FALSE, '`LABIA_PROM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LABIA_PROM->Sortable = TRUE; // Allow sort
		$this->fields['LABIA_PROM'] = &$this->LABIA_PROM;

		// HAMIL
		$this->HAMIL = new cField('m_pasien', 'm_pasien', 'x_HAMIL', 'HAMIL', '`HAMIL`', '`HAMIL`', 200, -1, FALSE, '`HAMIL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HAMIL->Sortable = TRUE; // Allow sort
		$this->fields['HAMIL'] = &$this->HAMIL;

		// TGL_HAID
		$this->TGL_HAID = new cField('m_pasien', 'm_pasien', 'x_TGL_HAID', 'TGL_HAID', '`TGL_HAID`', ew_CastDateFieldForLike('`TGL_HAID`', 0, "DB"), 133, 0, FALSE, '`TGL_HAID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TGL_HAID->Sortable = TRUE; // Allow sort
		$this->TGL_HAID->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['TGL_HAID'] = &$this->TGL_HAID;

		// PERIKSA_CERVIX
		$this->PERIKSA_CERVIX = new cField('m_pasien', 'm_pasien', 'x_PERIKSA_CERVIX', 'PERIKSA_CERVIX', '`PERIKSA_CERVIX`', '`PERIKSA_CERVIX`', 200, -1, FALSE, '`PERIKSA_CERVIX`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PERIKSA_CERVIX->Sortable = TRUE; // Allow sort
		$this->fields['PERIKSA_CERVIX'] = &$this->PERIKSA_CERVIX;

		// BENTUK_PAYUDARA
		$this->BENTUK_PAYUDARA = new cField('m_pasien', 'm_pasien', 'x_BENTUK_PAYUDARA', 'BENTUK_PAYUDARA', '`BENTUK_PAYUDARA`', '`BENTUK_PAYUDARA`', 200, -1, FALSE, '`BENTUK_PAYUDARA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK_PAYUDARA->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK_PAYUDARA'] = &$this->BENTUK_PAYUDARA;

		// KENYAL
		$this->KENYAL = new cField('m_pasien', 'm_pasien', 'x_KENYAL', 'KENYAL', '`KENYAL`', '`KENYAL`', 200, -1, FALSE, '`KENYAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KENYAL->Sortable = TRUE; // Allow sort
		$this->fields['KENYAL'] = &$this->KENYAL;

		// MASSA
		$this->MASSA = new cField('m_pasien', 'm_pasien', 'x_MASSA', 'MASSA', '`MASSA`', '`MASSA`', 200, -1, FALSE, '`MASSA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MASSA->Sortable = TRUE; // Allow sort
		$this->fields['MASSA'] = &$this->MASSA;

		// NYERI_RABA
		$this->NYERI_RABA = new cField('m_pasien', 'm_pasien', 'x_NYERI_RABA', 'NYERI_RABA', '`NYERI_RABA`', '`NYERI_RABA`', 200, -1, FALSE, '`NYERI_RABA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NYERI_RABA->Sortable = TRUE; // Allow sort
		$this->fields['NYERI_RABA'] = &$this->NYERI_RABA;

		// BENTUK_PUTING
		$this->BENTUK_PUTING = new cField('m_pasien', 'm_pasien', 'x_BENTUK_PUTING', 'BENTUK_PUTING', '`BENTUK_PUTING`', '`BENTUK_PUTING`', 200, -1, FALSE, '`BENTUK_PUTING`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK_PUTING->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK_PUTING'] = &$this->BENTUK_PUTING;

		// MAMMO
		$this->MAMMO = new cField('m_pasien', 'm_pasien', 'x_MAMMO', 'MAMMO', '`MAMMO`', '`MAMMO`', 200, -1, FALSE, '`MAMMO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MAMMO->Sortable = TRUE; // Allow sort
		$this->fields['MAMMO'] = &$this->MAMMO;

		// ALAT_KONTRASEPSI
		$this->ALAT_KONTRASEPSI = new cField('m_pasien', 'm_pasien', 'x_ALAT_KONTRASEPSI', 'ALAT_KONTRASEPSI', '`ALAT_KONTRASEPSI`', '`ALAT_KONTRASEPSI`', 200, -1, FALSE, '`ALAT_KONTRASEPSI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALAT_KONTRASEPSI->Sortable = TRUE; // Allow sort
		$this->fields['ALAT_KONTRASEPSI'] = &$this->ALAT_KONTRASEPSI;

		// MASALAH_SEKS
		$this->MASALAH_SEKS = new cField('m_pasien', 'm_pasien', 'x_MASALAH_SEKS', 'MASALAH_SEKS', '`MASALAH_SEKS`', '`MASALAH_SEKS`', 200, -1, FALSE, '`MASALAH_SEKS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MASALAH_SEKS->Sortable = TRUE; // Allow sort
		$this->fields['MASALAH_SEKS'] = &$this->MASALAH_SEKS;

		// PREPUTIUM
		$this->PREPUTIUM = new cField('m_pasien', 'm_pasien', 'x_PREPUTIUM', 'PREPUTIUM', '`PREPUTIUM`', '`PREPUTIUM`', 200, -1, FALSE, '`PREPUTIUM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PREPUTIUM->Sortable = TRUE; // Allow sort
		$this->fields['PREPUTIUM'] = &$this->PREPUTIUM;

		// MASALAH_PROSTAT
		$this->MASALAH_PROSTAT = new cField('m_pasien', 'm_pasien', 'x_MASALAH_PROSTAT', 'MASALAH_PROSTAT', '`MASALAH_PROSTAT`', '`MASALAH_PROSTAT`', 200, -1, FALSE, '`MASALAH_PROSTAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MASALAH_PROSTAT->Sortable = TRUE; // Allow sort
		$this->fields['MASALAH_PROSTAT'] = &$this->MASALAH_PROSTAT;

		// BENTUK_SKROTUM
		$this->BENTUK_SKROTUM = new cField('m_pasien', 'm_pasien', 'x_BENTUK_SKROTUM', 'BENTUK_SKROTUM', '`BENTUK_SKROTUM`', '`BENTUK_SKROTUM`', 200, -1, FALSE, '`BENTUK_SKROTUM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BENTUK_SKROTUM->Sortable = TRUE; // Allow sort
		$this->fields['BENTUK_SKROTUM'] = &$this->BENTUK_SKROTUM;

		// TESTIS
		$this->TESTIS = new cField('m_pasien', 'm_pasien', 'x_TESTIS', 'TESTIS', '`TESTIS`', '`TESTIS`', 200, -1, FALSE, '`TESTIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TESTIS->Sortable = TRUE; // Allow sort
		$this->fields['TESTIS'] = &$this->TESTIS;

		// MASSA_BEN
		$this->MASSA_BEN = new cField('m_pasien', 'm_pasien', 'x_MASSA_BEN', 'MASSA_BEN', '`MASSA_BEN`', '`MASSA_BEN`', 200, -1, FALSE, '`MASSA_BEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MASSA_BEN->Sortable = TRUE; // Allow sort
		$this->fields['MASSA_BEN'] = &$this->MASSA_BEN;

		// HERNIASI
		$this->HERNIASI = new cField('m_pasien', 'm_pasien', 'x_HERNIASI', 'HERNIASI', '`HERNIASI`', '`HERNIASI`', 200, -1, FALSE, '`HERNIASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HERNIASI->Sortable = TRUE; // Allow sort
		$this->fields['HERNIASI'] = &$this->HERNIASI;

		// LAIN2
		$this->LAIN2 = new cField('m_pasien', 'm_pasien', 'x_LAIN2', 'LAIN2', '`LAIN2`', '`LAIN2`', 200, -1, FALSE, '`LAIN2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->LAIN2->Sortable = TRUE; // Allow sort
		$this->fields['LAIN2'] = &$this->LAIN2;

		// ALAT_KONTRA
		$this->ALAT_KONTRA = new cField('m_pasien', 'm_pasien', 'x_ALAT_KONTRA', 'ALAT_KONTRA', '`ALAT_KONTRA`', '`ALAT_KONTRA`', 200, -1, FALSE, '`ALAT_KONTRA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALAT_KONTRA->Sortable = TRUE; // Allow sort
		$this->fields['ALAT_KONTRA'] = &$this->ALAT_KONTRA;

		// MASALAH_REPRO
		$this->MASALAH_REPRO = new cField('m_pasien', 'm_pasien', 'x_MASALAH_REPRO', 'MASALAH_REPRO', '`MASALAH_REPRO`', '`MASALAH_REPRO`', 200, -1, FALSE, '`MASALAH_REPRO`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MASALAH_REPRO->Sortable = TRUE; // Allow sort
		$this->fields['MASALAH_REPRO'] = &$this->MASALAH_REPRO;

		// EKSTREMITAS_ATAS
		$this->EKSTREMITAS_ATAS = new cField('m_pasien', 'm_pasien', 'x_EKSTREMITAS_ATAS', 'EKSTREMITAS_ATAS', '`EKSTREMITAS_ATAS`', '`EKSTREMITAS_ATAS`', 200, -1, FALSE, '`EKSTREMITAS_ATAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->EKSTREMITAS_ATAS->Sortable = TRUE; // Allow sort
		$this->fields['EKSTREMITAS_ATAS'] = &$this->EKSTREMITAS_ATAS;

		// EKSTREMITAS_BAWAH
		$this->EKSTREMITAS_BAWAH = new cField('m_pasien', 'm_pasien', 'x_EKSTREMITAS_BAWAH', 'EKSTREMITAS_BAWAH', '`EKSTREMITAS_BAWAH`', '`EKSTREMITAS_BAWAH`', 200, -1, FALSE, '`EKSTREMITAS_BAWAH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->EKSTREMITAS_BAWAH->Sortable = TRUE; // Allow sort
		$this->fields['EKSTREMITAS_BAWAH'] = &$this->EKSTREMITAS_BAWAH;

		// AKTIVITAS
		$this->AKTIVITAS = new cField('m_pasien', 'm_pasien', 'x_AKTIVITAS', 'AKTIVITAS', '`AKTIVITAS`', '`AKTIVITAS`', 200, -1, FALSE, '`AKTIVITAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->AKTIVITAS->Sortable = TRUE; // Allow sort
		$this->fields['AKTIVITAS'] = &$this->AKTIVITAS;

		// BERJALAN
		$this->BERJALAN = new cField('m_pasien', 'm_pasien', 'x_BERJALAN', 'BERJALAN', '`BERJALAN`', '`BERJALAN`', 200, -1, FALSE, '`BERJALAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BERJALAN->Sortable = TRUE; // Allow sort
		$this->fields['BERJALAN'] = &$this->BERJALAN;

		// SISTEM_INTE
		$this->SISTEM_INTE = new cField('m_pasien', 'm_pasien', 'x_SISTEM_INTE', 'SISTEM_INTE', '`SISTEM_INTE`', '`SISTEM_INTE`', 200, -1, FALSE, '`SISTEM_INTE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SISTEM_INTE->Sortable = TRUE; // Allow sort
		$this->fields['SISTEM_INTE'] = &$this->SISTEM_INTE;

		// KENYAMANAN
		$this->KENYAMANAN = new cField('m_pasien', 'm_pasien', 'x_KENYAMANAN', 'KENYAMANAN', '`KENYAMANAN`', '`KENYAMANAN`', 200, -1, FALSE, '`KENYAMANAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KENYAMANAN->Sortable = TRUE; // Allow sort
		$this->fields['KENYAMANAN'] = &$this->KENYAMANAN;

		// KES_DIRI
		$this->KES_DIRI = new cField('m_pasien', 'm_pasien', 'x_KES_DIRI', 'KES_DIRI', '`KES_DIRI`', '`KES_DIRI`', 200, -1, FALSE, '`KES_DIRI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KES_DIRI->Sortable = TRUE; // Allow sort
		$this->fields['KES_DIRI'] = &$this->KES_DIRI;

		// SOS_SUPORT
		$this->SOS_SUPORT = new cField('m_pasien', 'm_pasien', 'x_SOS_SUPORT', 'SOS_SUPORT', '`SOS_SUPORT`', '`SOS_SUPORT`', 200, -1, FALSE, '`SOS_SUPORT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SOS_SUPORT->Sortable = TRUE; // Allow sort
		$this->fields['SOS_SUPORT'] = &$this->SOS_SUPORT;

		// ANSIETAS
		$this->ANSIETAS = new cField('m_pasien', 'm_pasien', 'x_ANSIETAS', 'ANSIETAS', '`ANSIETAS`', '`ANSIETAS`', 200, -1, FALSE, '`ANSIETAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ANSIETAS->Sortable = TRUE; // Allow sort
		$this->fields['ANSIETAS'] = &$this->ANSIETAS;

		// KEHILANGAN
		$this->KEHILANGAN = new cField('m_pasien', 'm_pasien', 'x_KEHILANGAN', 'KEHILANGAN', '`KEHILANGAN`', '`KEHILANGAN`', 200, -1, FALSE, '`KEHILANGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEHILANGAN->Sortable = TRUE; // Allow sort
		$this->fields['KEHILANGAN'] = &$this->KEHILANGAN;

		// STATUS_EMOSI
		$this->STATUS_EMOSI = new cField('m_pasien', 'm_pasien', 'x_STATUS_EMOSI', 'STATUS_EMOSI', '`STATUS_EMOSI`', '`STATUS_EMOSI`', 200, -1, FALSE, '`STATUS_EMOSI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->STATUS_EMOSI->Sortable = TRUE; // Allow sort
		$this->fields['STATUS_EMOSI'] = &$this->STATUS_EMOSI;

		// KONSEP_DIRI
		$this->KONSEP_DIRI = new cField('m_pasien', 'm_pasien', 'x_KONSEP_DIRI', 'KONSEP_DIRI', '`KONSEP_DIRI`', '`KONSEP_DIRI`', 200, -1, FALSE, '`KONSEP_DIRI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KONSEP_DIRI->Sortable = TRUE; // Allow sort
		$this->fields['KONSEP_DIRI'] = &$this->KONSEP_DIRI;

		// RESPON_HILANG
		$this->RESPON_HILANG = new cField('m_pasien', 'm_pasien', 'x_RESPON_HILANG', 'RESPON_HILANG', '`RESPON_HILANG`', '`RESPON_HILANG`', 200, -1, FALSE, '`RESPON_HILANG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RESPON_HILANG->Sortable = TRUE; // Allow sort
		$this->fields['RESPON_HILANG'] = &$this->RESPON_HILANG;

		// SUMBER_STRESS
		$this->SUMBER_STRESS = new cField('m_pasien', 'm_pasien', 'x_SUMBER_STRESS', 'SUMBER_STRESS', '`SUMBER_STRESS`', '`SUMBER_STRESS`', 200, -1, FALSE, '`SUMBER_STRESS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SUMBER_STRESS->Sortable = TRUE; // Allow sort
		$this->fields['SUMBER_STRESS'] = &$this->SUMBER_STRESS;

		// BERARTI
		$this->BERARTI = new cField('m_pasien', 'm_pasien', 'x_BERARTI', 'BERARTI', '`BERARTI`', '`BERARTI`', 200, -1, FALSE, '`BERARTI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BERARTI->Sortable = TRUE; // Allow sort
		$this->fields['BERARTI'] = &$this->BERARTI;

		// TERLIBAT
		$this->TERLIBAT = new cField('m_pasien', 'm_pasien', 'x_TERLIBAT', 'TERLIBAT', '`TERLIBAT`', '`TERLIBAT`', 200, -1, FALSE, '`TERLIBAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TERLIBAT->Sortable = TRUE; // Allow sort
		$this->fields['TERLIBAT'] = &$this->TERLIBAT;

		// HUBUNGAN
		$this->HUBUNGAN = new cField('m_pasien', 'm_pasien', 'x_HUBUNGAN', 'HUBUNGAN', '`HUBUNGAN`', '`HUBUNGAN`', 200, -1, FALSE, '`HUBUNGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HUBUNGAN->Sortable = TRUE; // Allow sort
		$this->fields['HUBUNGAN'] = &$this->HUBUNGAN;

		// KOMUNIKASI
		$this->KOMUNIKASI = new cField('m_pasien', 'm_pasien', 'x_KOMUNIKASI', 'KOMUNIKASI', '`KOMUNIKASI`', '`KOMUNIKASI`', 200, -1, FALSE, '`KOMUNIKASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KOMUNIKASI->Sortable = TRUE; // Allow sort
		$this->fields['KOMUNIKASI'] = &$this->KOMUNIKASI;

		// KEPUTUSAN
		$this->KEPUTUSAN = new cField('m_pasien', 'm_pasien', 'x_KEPUTUSAN', 'KEPUTUSAN', '`KEPUTUSAN`', '`KEPUTUSAN`', 200, -1, FALSE, '`KEPUTUSAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEPUTUSAN->Sortable = TRUE; // Allow sort
		$this->fields['KEPUTUSAN'] = &$this->KEPUTUSAN;

		// MENGASUH
		$this->MENGASUH = new cField('m_pasien', 'm_pasien', 'x_MENGASUH', 'MENGASUH', '`MENGASUH`', '`MENGASUH`', 200, -1, FALSE, '`MENGASUH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MENGASUH->Sortable = TRUE; // Allow sort
		$this->fields['MENGASUH'] = &$this->MENGASUH;

		// DUKUNGAN
		$this->DUKUNGAN = new cField('m_pasien', 'm_pasien', 'x_DUKUNGAN', 'DUKUNGAN', '`DUKUNGAN`', '`DUKUNGAN`', 200, -1, FALSE, '`DUKUNGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DUKUNGAN->Sortable = TRUE; // Allow sort
		$this->fields['DUKUNGAN'] = &$this->DUKUNGAN;

		// REAKSI
		$this->REAKSI = new cField('m_pasien', 'm_pasien', 'x_REAKSI', 'REAKSI', '`REAKSI`', '`REAKSI`', 200, -1, FALSE, '`REAKSI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->REAKSI->Sortable = TRUE; // Allow sort
		$this->fields['REAKSI'] = &$this->REAKSI;

		// BUDAYA
		$this->BUDAYA = new cField('m_pasien', 'm_pasien', 'x_BUDAYA', 'BUDAYA', '`BUDAYA`', '`BUDAYA`', 200, -1, FALSE, '`BUDAYA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BUDAYA->Sortable = TRUE; // Allow sort
		$this->fields['BUDAYA'] = &$this->BUDAYA;

		// POLA_AKTIVITAS
		$this->POLA_AKTIVITAS = new cField('m_pasien', 'm_pasien', 'x_POLA_AKTIVITAS', 'POLA_AKTIVITAS', '`POLA_AKTIVITAS`', '`POLA_AKTIVITAS`', 200, -1, FALSE, '`POLA_AKTIVITAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->POLA_AKTIVITAS->Sortable = TRUE; // Allow sort
		$this->fields['POLA_AKTIVITAS'] = &$this->POLA_AKTIVITAS;

		// POLA_ISTIRAHAT
		$this->POLA_ISTIRAHAT = new cField('m_pasien', 'm_pasien', 'x_POLA_ISTIRAHAT', 'POLA_ISTIRAHAT', '`POLA_ISTIRAHAT`', '`POLA_ISTIRAHAT`', 200, -1, FALSE, '`POLA_ISTIRAHAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->POLA_ISTIRAHAT->Sortable = TRUE; // Allow sort
		$this->fields['POLA_ISTIRAHAT'] = &$this->POLA_ISTIRAHAT;

		// POLA_MAKAN
		$this->POLA_MAKAN = new cField('m_pasien', 'm_pasien', 'x_POLA_MAKAN', 'POLA_MAKAN', '`POLA_MAKAN`', '`POLA_MAKAN`', 200, -1, FALSE, '`POLA_MAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->POLA_MAKAN->Sortable = TRUE; // Allow sort
		$this->fields['POLA_MAKAN'] = &$this->POLA_MAKAN;

		// PANTANGAN
		$this->PANTANGAN = new cField('m_pasien', 'm_pasien', 'x_PANTANGAN', 'PANTANGAN', '`PANTANGAN`', '`PANTANGAN`', 200, -1, FALSE, '`PANTANGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PANTANGAN->Sortable = TRUE; // Allow sort
		$this->fields['PANTANGAN'] = &$this->PANTANGAN;

		// KEPERCAYAAN
		$this->KEPERCAYAAN = new cField('m_pasien', 'm_pasien', 'x_KEPERCAYAAN', 'KEPERCAYAAN', '`KEPERCAYAAN`', '`KEPERCAYAAN`', 200, -1, FALSE, '`KEPERCAYAAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEPERCAYAAN->Sortable = TRUE; // Allow sort
		$this->fields['KEPERCAYAAN'] = &$this->KEPERCAYAAN;

		// PANTANGAN_HARI
		$this->PANTANGAN_HARI = new cField('m_pasien', 'm_pasien', 'x_PANTANGAN_HARI', 'PANTANGAN_HARI', '`PANTANGAN_HARI`', '`PANTANGAN_HARI`', 200, -1, FALSE, '`PANTANGAN_HARI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PANTANGAN_HARI->Sortable = TRUE; // Allow sort
		$this->fields['PANTANGAN_HARI'] = &$this->PANTANGAN_HARI;

		// PANTANGAN_LAIN
		$this->PANTANGAN_LAIN = new cField('m_pasien', 'm_pasien', 'x_PANTANGAN_LAIN', 'PANTANGAN_LAIN', '`PANTANGAN_LAIN`', '`PANTANGAN_LAIN`', 200, -1, FALSE, '`PANTANGAN_LAIN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PANTANGAN_LAIN->Sortable = TRUE; // Allow sort
		$this->fields['PANTANGAN_LAIN'] = &$this->PANTANGAN_LAIN;

		// ANJURAN
		$this->ANJURAN = new cField('m_pasien', 'm_pasien', 'x_ANJURAN', 'ANJURAN', '`ANJURAN`', '`ANJURAN`', 200, -1, FALSE, '`ANJURAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ANJURAN->Sortable = TRUE; // Allow sort
		$this->fields['ANJURAN'] = &$this->ANJURAN;

		// NILAI_KEYAKINAN
		$this->NILAI_KEYAKINAN = new cField('m_pasien', 'm_pasien', 'x_NILAI_KEYAKINAN', 'NILAI_KEYAKINAN', '`NILAI_KEYAKINAN`', '`NILAI_KEYAKINAN`', 200, -1, FALSE, '`NILAI_KEYAKINAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NILAI_KEYAKINAN->Sortable = TRUE; // Allow sort
		$this->fields['NILAI_KEYAKINAN'] = &$this->NILAI_KEYAKINAN;

		// KEGIATAN_IBADAH
		$this->KEGIATAN_IBADAH = new cField('m_pasien', 'm_pasien', 'x_KEGIATAN_IBADAH', 'KEGIATAN_IBADAH', '`KEGIATAN_IBADAH`', '`KEGIATAN_IBADAH`', 200, -1, FALSE, '`KEGIATAN_IBADAH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEGIATAN_IBADAH->Sortable = TRUE; // Allow sort
		$this->fields['KEGIATAN_IBADAH'] = &$this->KEGIATAN_IBADAH;

		// PENG_AGAMA
		$this->PENG_AGAMA = new cField('m_pasien', 'm_pasien', 'x_PENG_AGAMA', 'PENG_AGAMA', '`PENG_AGAMA`', '`PENG_AGAMA`', 200, -1, FALSE, '`PENG_AGAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENG_AGAMA->Sortable = TRUE; // Allow sort
		$this->fields['PENG_AGAMA'] = &$this->PENG_AGAMA;

		// SPIRIT
		$this->SPIRIT = new cField('m_pasien', 'm_pasien', 'x_SPIRIT', 'SPIRIT', '`SPIRIT`', '`SPIRIT`', 200, -1, FALSE, '`SPIRIT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SPIRIT->Sortable = TRUE; // Allow sort
		$this->fields['SPIRIT'] = &$this->SPIRIT;

		// BANTUAN
		$this->BANTUAN = new cField('m_pasien', 'm_pasien', 'x_BANTUAN', 'BANTUAN', '`BANTUAN`', '`BANTUAN`', 200, -1, FALSE, '`BANTUAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BANTUAN->Sortable = TRUE; // Allow sort
		$this->fields['BANTUAN'] = &$this->BANTUAN;

		// PAHAM_PENYAKIT
		$this->PAHAM_PENYAKIT = new cField('m_pasien', 'm_pasien', 'x_PAHAM_PENYAKIT', 'PAHAM_PENYAKIT', '`PAHAM_PENYAKIT`', '`PAHAM_PENYAKIT`', 200, -1, FALSE, '`PAHAM_PENYAKIT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAHAM_PENYAKIT->Sortable = TRUE; // Allow sort
		$this->fields['PAHAM_PENYAKIT'] = &$this->PAHAM_PENYAKIT;

		// PAHAM_OBAT
		$this->PAHAM_OBAT = new cField('m_pasien', 'm_pasien', 'x_PAHAM_OBAT', 'PAHAM_OBAT', '`PAHAM_OBAT`', '`PAHAM_OBAT`', 200, -1, FALSE, '`PAHAM_OBAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAHAM_OBAT->Sortable = TRUE; // Allow sort
		$this->fields['PAHAM_OBAT'] = &$this->PAHAM_OBAT;

		// PAHAM_NUTRISI
		$this->PAHAM_NUTRISI = new cField('m_pasien', 'm_pasien', 'x_PAHAM_NUTRISI', 'PAHAM_NUTRISI', '`PAHAM_NUTRISI`', '`PAHAM_NUTRISI`', 200, -1, FALSE, '`PAHAM_NUTRISI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAHAM_NUTRISI->Sortable = TRUE; // Allow sort
		$this->fields['PAHAM_NUTRISI'] = &$this->PAHAM_NUTRISI;

		// PAHAM_RAWAT
		$this->PAHAM_RAWAT = new cField('m_pasien', 'm_pasien', 'x_PAHAM_RAWAT', 'PAHAM_RAWAT', '`PAHAM_RAWAT`', '`PAHAM_RAWAT`', 200, -1, FALSE, '`PAHAM_RAWAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAHAM_RAWAT->Sortable = TRUE; // Allow sort
		$this->fields['PAHAM_RAWAT'] = &$this->PAHAM_RAWAT;

		// HAMBATAN_EDUKASI
		$this->HAMBATAN_EDUKASI = new cField('m_pasien', 'm_pasien', 'x_HAMBATAN_EDUKASI', 'HAMBATAN_EDUKASI', '`HAMBATAN_EDUKASI`', '`HAMBATAN_EDUKASI`', 200, -1, FALSE, '`HAMBATAN_EDUKASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HAMBATAN_EDUKASI->Sortable = TRUE; // Allow sort
		$this->fields['HAMBATAN_EDUKASI'] = &$this->HAMBATAN_EDUKASI;

		// FREK_MAKAN
		$this->FREK_MAKAN = new cField('m_pasien', 'm_pasien', 'x_FREK_MAKAN', 'FREK_MAKAN', '`FREK_MAKAN`', '`FREK_MAKAN`', 200, -1, FALSE, '`FREK_MAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FREK_MAKAN->Sortable = TRUE; // Allow sort
		$this->fields['FREK_MAKAN'] = &$this->FREK_MAKAN;

		// JUM_MAKAN
		$this->JUM_MAKAN = new cField('m_pasien', 'm_pasien', 'x_JUM_MAKAN', 'JUM_MAKAN', '`JUM_MAKAN`', '`JUM_MAKAN`', 200, -1, FALSE, '`JUM_MAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JUM_MAKAN->Sortable = TRUE; // Allow sort
		$this->fields['JUM_MAKAN'] = &$this->JUM_MAKAN;

		// JEN_MAKAN
		$this->JEN_MAKAN = new cField('m_pasien', 'm_pasien', 'x_JEN_MAKAN', 'JEN_MAKAN', '`JEN_MAKAN`', '`JEN_MAKAN`', 200, -1, FALSE, '`JEN_MAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JEN_MAKAN->Sortable = TRUE; // Allow sort
		$this->fields['JEN_MAKAN'] = &$this->JEN_MAKAN;

		// KOM_MAKAN
		$this->KOM_MAKAN = new cField('m_pasien', 'm_pasien', 'x_KOM_MAKAN', 'KOM_MAKAN', '`KOM_MAKAN`', '`KOM_MAKAN`', 200, -1, FALSE, '`KOM_MAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KOM_MAKAN->Sortable = TRUE; // Allow sort
		$this->fields['KOM_MAKAN'] = &$this->KOM_MAKAN;

		// DIET
		$this->DIET = new cField('m_pasien', 'm_pasien', 'x_DIET', 'DIET', '`DIET`', '`DIET`', 200, -1, FALSE, '`DIET`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DIET->Sortable = TRUE; // Allow sort
		$this->fields['DIET'] = &$this->DIET;

		// CARA_MAKAN
		$this->CARA_MAKAN = new cField('m_pasien', 'm_pasien', 'x_CARA_MAKAN', 'CARA_MAKAN', '`CARA_MAKAN`', '`CARA_MAKAN`', 200, -1, FALSE, '`CARA_MAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CARA_MAKAN->Sortable = TRUE; // Allow sort
		$this->fields['CARA_MAKAN'] = &$this->CARA_MAKAN;

		// GANGGUAN
		$this->GANGGUAN = new cField('m_pasien', 'm_pasien', 'x_GANGGUAN', 'GANGGUAN', '`GANGGUAN`', '`GANGGUAN`', 200, -1, FALSE, '`GANGGUAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->GANGGUAN->Sortable = TRUE; // Allow sort
		$this->fields['GANGGUAN'] = &$this->GANGGUAN;

		// FREK_MINUM
		$this->FREK_MINUM = new cField('m_pasien', 'm_pasien', 'x_FREK_MINUM', 'FREK_MINUM', '`FREK_MINUM`', '`FREK_MINUM`', 3, -1, FALSE, '`FREK_MINUM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FREK_MINUM->Sortable = TRUE; // Allow sort
		$this->FREK_MINUM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['FREK_MINUM'] = &$this->FREK_MINUM;

		// JUM_MINUM
		$this->JUM_MINUM = new cField('m_pasien', 'm_pasien', 'x_JUM_MINUM', 'JUM_MINUM', '`JUM_MINUM`', '`JUM_MINUM`', 3, -1, FALSE, '`JUM_MINUM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JUM_MINUM->Sortable = TRUE; // Allow sort
		$this->JUM_MINUM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['JUM_MINUM'] = &$this->JUM_MINUM;

		// JEN_MINUM
		$this->JEN_MINUM = new cField('m_pasien', 'm_pasien', 'x_JEN_MINUM', 'JEN_MINUM', '`JEN_MINUM`', '`JEN_MINUM`', 200, -1, FALSE, '`JEN_MINUM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JEN_MINUM->Sortable = TRUE; // Allow sort
		$this->fields['JEN_MINUM'] = &$this->JEN_MINUM;

		// GANG_MINUM
		$this->GANG_MINUM = new cField('m_pasien', 'm_pasien', 'x_GANG_MINUM', 'GANG_MINUM', '`GANG_MINUM`', '`GANG_MINUM`', 200, -1, FALSE, '`GANG_MINUM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->GANG_MINUM->Sortable = TRUE; // Allow sort
		$this->fields['GANG_MINUM'] = &$this->GANG_MINUM;

		// FREK_BAK
		$this->FREK_BAK = new cField('m_pasien', 'm_pasien', 'x_FREK_BAK', 'FREK_BAK', '`FREK_BAK`', '`FREK_BAK`', 3, -1, FALSE, '`FREK_BAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FREK_BAK->Sortable = TRUE; // Allow sort
		$this->FREK_BAK->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['FREK_BAK'] = &$this->FREK_BAK;

		// WARNA_BAK
		$this->WARNA_BAK = new cField('m_pasien', 'm_pasien', 'x_WARNA_BAK', 'WARNA_BAK', '`WARNA_BAK`', '`WARNA_BAK`', 200, -1, FALSE, '`WARNA_BAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->WARNA_BAK->Sortable = TRUE; // Allow sort
		$this->fields['WARNA_BAK'] = &$this->WARNA_BAK;

		// JMLH_BAK
		$this->JMLH_BAK = new cField('m_pasien', 'm_pasien', 'x_JMLH_BAK', 'JMLH_BAK', '`JMLH_BAK`', '`JMLH_BAK`', 3, -1, FALSE, '`JMLH_BAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JMLH_BAK->Sortable = TRUE; // Allow sort
		$this->JMLH_BAK->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['JMLH_BAK'] = &$this->JMLH_BAK;

		// PENG_KAT_BAK
		$this->PENG_KAT_BAK = new cField('m_pasien', 'm_pasien', 'x_PENG_KAT_BAK', 'PENG_KAT_BAK', '`PENG_KAT_BAK`', '`PENG_KAT_BAK`', 200, -1, FALSE, '`PENG_KAT_BAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENG_KAT_BAK->Sortable = TRUE; // Allow sort
		$this->fields['PENG_KAT_BAK'] = &$this->PENG_KAT_BAK;

		// KEM_HAN_BAK
		$this->KEM_HAN_BAK = new cField('m_pasien', 'm_pasien', 'x_KEM_HAN_BAK', 'KEM_HAN_BAK', '`KEM_HAN_BAK`', '`KEM_HAN_BAK`', 200, -1, FALSE, '`KEM_HAN_BAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEM_HAN_BAK->Sortable = TRUE; // Allow sort
		$this->fields['KEM_HAN_BAK'] = &$this->KEM_HAN_BAK;

		// INKONT_BAK
		$this->INKONT_BAK = new cField('m_pasien', 'm_pasien', 'x_INKONT_BAK', 'INKONT_BAK', '`INKONT_BAK`', '`INKONT_BAK`', 200, -1, FALSE, '`INKONT_BAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->INKONT_BAK->Sortable = TRUE; // Allow sort
		$this->fields['INKONT_BAK'] = &$this->INKONT_BAK;

		// DIURESIS_BAK
		$this->DIURESIS_BAK = new cField('m_pasien', 'm_pasien', 'x_DIURESIS_BAK', 'DIURESIS_BAK', '`DIURESIS_BAK`', '`DIURESIS_BAK`', 200, -1, FALSE, '`DIURESIS_BAK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DIURESIS_BAK->Sortable = TRUE; // Allow sort
		$this->fields['DIURESIS_BAK'] = &$this->DIURESIS_BAK;

		// FREK_BAB
		$this->FREK_BAB = new cField('m_pasien', 'm_pasien', 'x_FREK_BAB', 'FREK_BAB', '`FREK_BAB`', '`FREK_BAB`', 3, -1, FALSE, '`FREK_BAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FREK_BAB->Sortable = TRUE; // Allow sort
		$this->FREK_BAB->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['FREK_BAB'] = &$this->FREK_BAB;

		// WARNA_BAB
		$this->WARNA_BAB = new cField('m_pasien', 'm_pasien', 'x_WARNA_BAB', 'WARNA_BAB', '`WARNA_BAB`', '`WARNA_BAB`', 200, -1, FALSE, '`WARNA_BAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->WARNA_BAB->Sortable = TRUE; // Allow sort
		$this->fields['WARNA_BAB'] = &$this->WARNA_BAB;

		// KONSIST_BAB
		$this->KONSIST_BAB = new cField('m_pasien', 'm_pasien', 'x_KONSIST_BAB', 'KONSIST_BAB', '`KONSIST_BAB`', '`KONSIST_BAB`', 200, -1, FALSE, '`KONSIST_BAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KONSIST_BAB->Sortable = TRUE; // Allow sort
		$this->fields['KONSIST_BAB'] = &$this->KONSIST_BAB;

		// GANG_BAB
		$this->GANG_BAB = new cField('m_pasien', 'm_pasien', 'x_GANG_BAB', 'GANG_BAB', '`GANG_BAB`', '`GANG_BAB`', 200, -1, FALSE, '`GANG_BAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->GANG_BAB->Sortable = TRUE; // Allow sort
		$this->fields['GANG_BAB'] = &$this->GANG_BAB;

		// STOMA_BAB
		$this->STOMA_BAB = new cField('m_pasien', 'm_pasien', 'x_STOMA_BAB', 'STOMA_BAB', '`STOMA_BAB`', '`STOMA_BAB`', 200, -1, FALSE, '`STOMA_BAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->STOMA_BAB->Sortable = TRUE; // Allow sort
		$this->fields['STOMA_BAB'] = &$this->STOMA_BAB;

		// PENG_OBAT_BAB
		$this->PENG_OBAT_BAB = new cField('m_pasien', 'm_pasien', 'x_PENG_OBAT_BAB', 'PENG_OBAT_BAB', '`PENG_OBAT_BAB`', '`PENG_OBAT_BAB`', 200, -1, FALSE, '`PENG_OBAT_BAB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENG_OBAT_BAB->Sortable = TRUE; // Allow sort
		$this->fields['PENG_OBAT_BAB'] = &$this->PENG_OBAT_BAB;

		// IST_SIANG
		$this->IST_SIANG = new cField('m_pasien', 'm_pasien', 'x_IST_SIANG', 'IST_SIANG', '`IST_SIANG`', '`IST_SIANG`', 3, -1, FALSE, '`IST_SIANG`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IST_SIANG->Sortable = TRUE; // Allow sort
		$this->IST_SIANG->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IST_SIANG'] = &$this->IST_SIANG;

		// IST_MALAM
		$this->IST_MALAM = new cField('m_pasien', 'm_pasien', 'x_IST_MALAM', 'IST_MALAM', '`IST_MALAM`', '`IST_MALAM`', 3, -1, FALSE, '`IST_MALAM`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IST_MALAM->Sortable = TRUE; // Allow sort
		$this->IST_MALAM->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['IST_MALAM'] = &$this->IST_MALAM;

		// IST_CAHAYA
		$this->IST_CAHAYA = new cField('m_pasien', 'm_pasien', 'x_IST_CAHAYA', 'IST_CAHAYA', '`IST_CAHAYA`', '`IST_CAHAYA`', 200, -1, FALSE, '`IST_CAHAYA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IST_CAHAYA->Sortable = TRUE; // Allow sort
		$this->fields['IST_CAHAYA'] = &$this->IST_CAHAYA;

		// IST_POSISI
		$this->IST_POSISI = new cField('m_pasien', 'm_pasien', 'x_IST_POSISI', 'IST_POSISI', '`IST_POSISI`', '`IST_POSISI`', 200, -1, FALSE, '`IST_POSISI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IST_POSISI->Sortable = TRUE; // Allow sort
		$this->fields['IST_POSISI'] = &$this->IST_POSISI;

		// IST_LING
		$this->IST_LING = new cField('m_pasien', 'm_pasien', 'x_IST_LING', 'IST_LING', '`IST_LING`', '`IST_LING`', 200, -1, FALSE, '`IST_LING`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IST_LING->Sortable = TRUE; // Allow sort
		$this->fields['IST_LING'] = &$this->IST_LING;

		// IST_GANG_TIDUR
		$this->IST_GANG_TIDUR = new cField('m_pasien', 'm_pasien', 'x_IST_GANG_TIDUR', 'IST_GANG_TIDUR', '`IST_GANG_TIDUR`', '`IST_GANG_TIDUR`', 200, -1, FALSE, '`IST_GANG_TIDUR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->IST_GANG_TIDUR->Sortable = TRUE; // Allow sort
		$this->fields['IST_GANG_TIDUR'] = &$this->IST_GANG_TIDUR;

		// PENG_OBAT_IST
		$this->PENG_OBAT_IST = new cField('m_pasien', 'm_pasien', 'x_PENG_OBAT_IST', 'PENG_OBAT_IST', '`PENG_OBAT_IST`', '`PENG_OBAT_IST`', 200, -1, FALSE, '`PENG_OBAT_IST`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENG_OBAT_IST->Sortable = TRUE; // Allow sort
		$this->fields['PENG_OBAT_IST'] = &$this->PENG_OBAT_IST;

		// FREK_MAND
		$this->FREK_MAND = new cField('m_pasien', 'm_pasien', 'x_FREK_MAND', 'FREK_MAND', '`FREK_MAND`', '`FREK_MAND`', 3, -1, FALSE, '`FREK_MAND`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FREK_MAND->Sortable = TRUE; // Allow sort
		$this->FREK_MAND->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['FREK_MAND'] = &$this->FREK_MAND;

		// CUC_RAMB_MAND
		$this->CUC_RAMB_MAND = new cField('m_pasien', 'm_pasien', 'x_CUC_RAMB_MAND', 'CUC_RAMB_MAND', '`CUC_RAMB_MAND`', '`CUC_RAMB_MAND`', 3, -1, FALSE, '`CUC_RAMB_MAND`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CUC_RAMB_MAND->Sortable = TRUE; // Allow sort
		$this->CUC_RAMB_MAND->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['CUC_RAMB_MAND'] = &$this->CUC_RAMB_MAND;

		// SIH_GIGI_MAND
		$this->SIH_GIGI_MAND = new cField('m_pasien', 'm_pasien', 'x_SIH_GIGI_MAND', 'SIH_GIGI_MAND', '`SIH_GIGI_MAND`', '`SIH_GIGI_MAND`', 3, -1, FALSE, '`SIH_GIGI_MAND`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SIH_GIGI_MAND->Sortable = TRUE; // Allow sort
		$this->SIH_GIGI_MAND->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['SIH_GIGI_MAND'] = &$this->SIH_GIGI_MAND;

		// BANT_MAND
		$this->BANT_MAND = new cField('m_pasien', 'm_pasien', 'x_BANT_MAND', 'BANT_MAND', '`BANT_MAND`', '`BANT_MAND`', 200, -1, FALSE, '`BANT_MAND`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BANT_MAND->Sortable = TRUE; // Allow sort
		$this->fields['BANT_MAND'] = &$this->BANT_MAND;

		// GANT_PAKAI
		$this->GANT_PAKAI = new cField('m_pasien', 'm_pasien', 'x_GANT_PAKAI', 'GANT_PAKAI', '`GANT_PAKAI`', '`GANT_PAKAI`', 3, -1, FALSE, '`GANT_PAKAI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->GANT_PAKAI->Sortable = TRUE; // Allow sort
		$this->GANT_PAKAI->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['GANT_PAKAI'] = &$this->GANT_PAKAI;

		// PAK_CUCI
		$this->PAK_CUCI = new cField('m_pasien', 'm_pasien', 'x_PAK_CUCI', 'PAK_CUCI', '`PAK_CUCI`', '`PAK_CUCI`', 200, -1, FALSE, '`PAK_CUCI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAK_CUCI->Sortable = TRUE; // Allow sort
		$this->fields['PAK_CUCI'] = &$this->PAK_CUCI;

		// PAK_BANT
		$this->PAK_BANT = new cField('m_pasien', 'm_pasien', 'x_PAK_BANT', 'PAK_BANT', '`PAK_BANT`', '`PAK_BANT`', 200, -1, FALSE, '`PAK_BANT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PAK_BANT->Sortable = TRUE; // Allow sort
		$this->fields['PAK_BANT'] = &$this->PAK_BANT;

		// ALT_BANT
		$this->ALT_BANT = new cField('m_pasien', 'm_pasien', 'x_ALT_BANT', 'ALT_BANT', '`ALT_BANT`', '`ALT_BANT`', 200, -1, FALSE, '`ALT_BANT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALT_BANT->Sortable = TRUE; // Allow sort
		$this->fields['ALT_BANT'] = &$this->ALT_BANT;

		// KEMP_MUND
		$this->KEMP_MUND = new cField('m_pasien', 'm_pasien', 'x_KEMP_MUND', 'KEMP_MUND', '`KEMP_MUND`', '`KEMP_MUND`', 200, -1, FALSE, '`KEMP_MUND`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KEMP_MUND->Sortable = TRUE; // Allow sort
		$this->fields['KEMP_MUND'] = &$this->KEMP_MUND;

		// BIL_PUT
		$this->BIL_PUT = new cField('m_pasien', 'm_pasien', 'x_BIL_PUT', 'BIL_PUT', '`BIL_PUT`', '`BIL_PUT`', 200, -1, FALSE, '`BIL_PUT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->BIL_PUT->Sortable = TRUE; // Allow sort
		$this->fields['BIL_PUT'] = &$this->BIL_PUT;

		// ADAPTIF
		$this->ADAPTIF = new cField('m_pasien', 'm_pasien', 'x_ADAPTIF', 'ADAPTIF', '`ADAPTIF`', '`ADAPTIF`', 200, -1, FALSE, '`ADAPTIF`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ADAPTIF->Sortable = TRUE; // Allow sort
		$this->fields['ADAPTIF'] = &$this->ADAPTIF;

		// MALADAPTIF
		$this->MALADAPTIF = new cField('m_pasien', 'm_pasien', 'x_MALADAPTIF', 'MALADAPTIF', '`MALADAPTIF`', '`MALADAPTIF`', 200, -1, FALSE, '`MALADAPTIF`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MALADAPTIF->Sortable = TRUE; // Allow sort
		$this->fields['MALADAPTIF'] = &$this->MALADAPTIF;

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA = new cField('m_pasien', 'm_pasien', 'x_PENANGGUNGJAWAB_NAMA', 'PENANGGUNGJAWAB_NAMA', '`PENANGGUNGJAWAB_NAMA`', '`PENANGGUNGJAWAB_NAMA`', 200, -1, FALSE, '`PENANGGUNGJAWAB_NAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_NAMA->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_NAMA'] = &$this->PENANGGUNGJAWAB_NAMA;

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN = new cField('m_pasien', 'm_pasien', 'x_PENANGGUNGJAWAB_HUBUNGAN', 'PENANGGUNGJAWAB_HUBUNGAN', '`PENANGGUNGJAWAB_HUBUNGAN`', '`PENANGGUNGJAWAB_HUBUNGAN`', 200, -1, FALSE, '`PENANGGUNGJAWAB_HUBUNGAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_HUBUNGAN->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_HUBUNGAN'] = &$this->PENANGGUNGJAWAB_HUBUNGAN;

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT = new cField('m_pasien', 'm_pasien', 'x_PENANGGUNGJAWAB_ALAMAT', 'PENANGGUNGJAWAB_ALAMAT', '`PENANGGUNGJAWAB_ALAMAT`', '`PENANGGUNGJAWAB_ALAMAT`', 200, -1, FALSE, '`PENANGGUNGJAWAB_ALAMAT`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_ALAMAT->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_ALAMAT'] = &$this->PENANGGUNGJAWAB_ALAMAT;

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE = new cField('m_pasien', 'm_pasien', 'x_PENANGGUNGJAWAB_PHONE', 'PENANGGUNGJAWAB_PHONE', '`PENANGGUNGJAWAB_PHONE`', '`PENANGGUNGJAWAB_PHONE`', 200, -1, FALSE, '`PENANGGUNGJAWAB_PHONE`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PENANGGUNGJAWAB_PHONE->Sortable = TRUE; // Allow sort
		$this->fields['PENANGGUNGJAWAB_PHONE'] = &$this->PENANGGUNGJAWAB_PHONE;

		// obat2
		$this->obat2 = new cField('m_pasien', 'm_pasien', 'x_obat2', 'obat2', '`obat2`', '`obat2`', 200, -1, FALSE, '`obat2`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->obat2->Sortable = TRUE; // Allow sort
		$this->fields['obat2'] = &$this->obat2;

		// PERBANDINGAN_BB
		$this->PERBANDINGAN_BB = new cField('m_pasien', 'm_pasien', 'x_PERBANDINGAN_BB', 'PERBANDINGAN_BB', '`PERBANDINGAN_BB`', '`PERBANDINGAN_BB`', 200, -1, FALSE, '`PERBANDINGAN_BB`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->PERBANDINGAN_BB->Sortable = TRUE; // Allow sort
		$this->fields['PERBANDINGAN_BB'] = &$this->PERBANDINGAN_BB;

		// KONTINENSIA
		$this->KONTINENSIA = new cField('m_pasien', 'm_pasien', 'x_KONTINENSIA', 'KONTINENSIA', '`KONTINENSIA`', '`KONTINENSIA`', 200, -1, FALSE, '`KONTINENSIA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KONTINENSIA->Sortable = TRUE; // Allow sort
		$this->fields['KONTINENSIA'] = &$this->KONTINENSIA;

		// JENIS_KULIT1
		$this->JENIS_KULIT1 = new cField('m_pasien', 'm_pasien', 'x_JENIS_KULIT1', 'JENIS_KULIT1', '`JENIS_KULIT1`', '`JENIS_KULIT1`', 200, -1, FALSE, '`JENIS_KULIT1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JENIS_KULIT1->Sortable = TRUE; // Allow sort
		$this->fields['JENIS_KULIT1'] = &$this->JENIS_KULIT1;

		// MOBILITAS
		$this->MOBILITAS = new cField('m_pasien', 'm_pasien', 'x_MOBILITAS', 'MOBILITAS', '`MOBILITAS`', '`MOBILITAS`', 200, -1, FALSE, '`MOBILITAS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MOBILITAS->Sortable = TRUE; // Allow sort
		$this->fields['MOBILITAS'] = &$this->MOBILITAS;

		// JK
		$this->JK = new cField('m_pasien', 'm_pasien', 'x_JK', 'JK', '`JK`', '`JK`', 200, -1, FALSE, '`JK`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->JK->Sortable = TRUE; // Allow sort
		$this->fields['JK'] = &$this->JK;

		// UMUR
		$this->UMUR = new cField('m_pasien', 'm_pasien', 'x_UMUR', 'UMUR', '`UMUR`', '`UMUR`', 200, -1, FALSE, '`UMUR`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->UMUR->Sortable = TRUE; // Allow sort
		$this->fields['UMUR'] = &$this->UMUR;

		// NAFSU_MAKAN
		$this->NAFSU_MAKAN = new cField('m_pasien', 'm_pasien', 'x_NAFSU_MAKAN', 'NAFSU_MAKAN', '`NAFSU_MAKAN`', '`NAFSU_MAKAN`', 200, -1, FALSE, '`NAFSU_MAKAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NAFSU_MAKAN->Sortable = TRUE; // Allow sort
		$this->fields['NAFSU_MAKAN'] = &$this->NAFSU_MAKAN;

		// OBAT1
		$this->OBAT1 = new cField('m_pasien', 'm_pasien', 'x_OBAT1', 'OBAT1', '`OBAT1`', '`OBAT1`', 200, -1, FALSE, '`OBAT1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->OBAT1->Sortable = TRUE; // Allow sort
		$this->fields['OBAT1'] = &$this->OBAT1;

		// MALNUTRISI
		$this->MALNUTRISI = new cField('m_pasien', 'm_pasien', 'x_MALNUTRISI', 'MALNUTRISI', '`MALNUTRISI`', '`MALNUTRISI`', 200, -1, FALSE, '`MALNUTRISI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MALNUTRISI->Sortable = TRUE; // Allow sort
		$this->fields['MALNUTRISI'] = &$this->MALNUTRISI;

		// MOTORIK1
		$this->MOTORIK1 = new cField('m_pasien', 'm_pasien', 'x_MOTORIK1', 'MOTORIK1', '`MOTORIK1`', '`MOTORIK1`', 200, -1, FALSE, '`MOTORIK1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MOTORIK1->Sortable = TRUE; // Allow sort
		$this->fields['MOTORIK1'] = &$this->MOTORIK1;

		// SPINAL
		$this->SPINAL = new cField('m_pasien', 'm_pasien', 'x_SPINAL', 'SPINAL', '`SPINAL`', '`SPINAL`', 200, -1, FALSE, '`SPINAL`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SPINAL->Sortable = TRUE; // Allow sort
		$this->fields['SPINAL'] = &$this->SPINAL;

		// MEJA_OPERASI
		$this->MEJA_OPERASI = new cField('m_pasien', 'm_pasien', 'x_MEJA_OPERASI', 'MEJA_OPERASI', '`MEJA_OPERASI`', '`MEJA_OPERASI`', 200, -1, FALSE, '`MEJA_OPERASI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->MEJA_OPERASI->Sortable = TRUE; // Allow sort
		$this->fields['MEJA_OPERASI'] = &$this->MEJA_OPERASI;

		// RIWAYAT_JATUH
		$this->RIWAYAT_JATUH = new cField('m_pasien', 'm_pasien', 'x_RIWAYAT_JATUH', 'RIWAYAT_JATUH', '`RIWAYAT_JATUH`', '`RIWAYAT_JATUH`', 200, -1, FALSE, '`RIWAYAT_JATUH`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->RIWAYAT_JATUH->Sortable = TRUE; // Allow sort
		$this->fields['RIWAYAT_JATUH'] = &$this->RIWAYAT_JATUH;

		// DIAGNOSIS_SEKUNDER
		$this->DIAGNOSIS_SEKUNDER = new cField('m_pasien', 'm_pasien', 'x_DIAGNOSIS_SEKUNDER', 'DIAGNOSIS_SEKUNDER', '`DIAGNOSIS_SEKUNDER`', '`DIAGNOSIS_SEKUNDER`', 200, -1, FALSE, '`DIAGNOSIS_SEKUNDER`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->DIAGNOSIS_SEKUNDER->Sortable = TRUE; // Allow sort
		$this->fields['DIAGNOSIS_SEKUNDER'] = &$this->DIAGNOSIS_SEKUNDER;

		// ALAT_BANTU
		$this->ALAT_BANTU = new cField('m_pasien', 'm_pasien', 'x_ALAT_BANTU', 'ALAT_BANTU', '`ALAT_BANTU`', '`ALAT_BANTU`', 200, -1, FALSE, '`ALAT_BANTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ALAT_BANTU->Sortable = TRUE; // Allow sort
		$this->fields['ALAT_BANTU'] = &$this->ALAT_BANTU;

		// HEPARIN
		$this->HEPARIN = new cField('m_pasien', 'm_pasien', 'x_HEPARIN', 'HEPARIN', '`HEPARIN`', '`HEPARIN`', 200, -1, FALSE, '`HEPARIN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->HEPARIN->Sortable = TRUE; // Allow sort
		$this->fields['HEPARIN'] = &$this->HEPARIN;

		// GAYA_BERJALAN
		$this->GAYA_BERJALAN = new cField('m_pasien', 'm_pasien', 'x_GAYA_BERJALAN', 'GAYA_BERJALAN', '`GAYA_BERJALAN`', '`GAYA_BERJALAN`', 200, -1, FALSE, '`GAYA_BERJALAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->GAYA_BERJALAN->Sortable = TRUE; // Allow sort
		$this->fields['GAYA_BERJALAN'] = &$this->GAYA_BERJALAN;

		// KESADARAN1
		$this->KESADARAN1 = new cField('m_pasien', 'm_pasien', 'x_KESADARAN1', 'KESADARAN1', '`KESADARAN1`', '`KESADARAN1`', 200, -1, FALSE, '`KESADARAN1`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->KESADARAN1->Sortable = TRUE; // Allow sort
		$this->fields['KESADARAN1'] = &$this->KESADARAN1;

		// NOMR_LAMA
		$this->NOMR_LAMA = new cField('m_pasien', 'm_pasien', 'x_NOMR_LAMA', 'NOMR_LAMA', '`NOMR_LAMA`', '`NOMR_LAMA`', 200, -1, FALSE, '`NOMR_LAMA`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NOMR_LAMA->Sortable = TRUE; // Allow sort
		$this->fields['NOMR_LAMA'] = &$this->NOMR_LAMA;

		// NO_KARTU
		$this->NO_KARTU = new cField('m_pasien', 'm_pasien', 'x_NO_KARTU', 'NO_KARTU', '`NO_KARTU`', '`NO_KARTU`', 200, -1, FALSE, '`NO_KARTU`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->NO_KARTU->Sortable = TRUE; // Allow sort
		$this->fields['NO_KARTU'] = &$this->NO_KARTU;

		// JNS_PASIEN
		$this->JNS_PASIEN = new cField('m_pasien', 'm_pasien', 'x_JNS_PASIEN', 'JNS_PASIEN', '`JNS_PASIEN`', '`JNS_PASIEN`', 200, -1, FALSE, '`JNS_PASIEN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->JNS_PASIEN->Sortable = TRUE; // Allow sort
		$this->JNS_PASIEN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->JNS_PASIEN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['JNS_PASIEN'] = &$this->JNS_PASIEN;

		// nama_ayah
		$this->nama_ayah = new cField('m_pasien', 'm_pasien', 'x_nama_ayah', 'nama_ayah', '`nama_ayah`', '`nama_ayah`', 200, -1, FALSE, '`nama_ayah`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_ayah->Sortable = TRUE; // Allow sort
		$this->fields['nama_ayah'] = &$this->nama_ayah;

		// nama_ibu
		$this->nama_ibu = new cField('m_pasien', 'm_pasien', 'x_nama_ibu', 'nama_ibu', '`nama_ibu`', '`nama_ibu`', 200, -1, FALSE, '`nama_ibu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_ibu->Sortable = TRUE; // Allow sort
		$this->fields['nama_ibu'] = &$this->nama_ibu;

		// nama_suami
		$this->nama_suami = new cField('m_pasien', 'm_pasien', 'x_nama_suami', 'nama_suami', '`nama_suami`', '`nama_suami`', 200, -1, FALSE, '`nama_suami`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_suami->Sortable = TRUE; // Allow sort
		$this->fields['nama_suami'] = &$this->nama_suami;

		// nama_istri
		$this->nama_istri = new cField('m_pasien', 'm_pasien', 'x_nama_istri', 'nama_istri', '`nama_istri`', '`nama_istri`', 200, -1, FALSE, '`nama_istri`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nama_istri->Sortable = TRUE; // Allow sort
		$this->fields['nama_istri'] = &$this->nama_istri;

		// KD_ETNIS
		$this->KD_ETNIS = new cField('m_pasien', 'm_pasien', 'x_KD_ETNIS', 'KD_ETNIS', '`KD_ETNIS`', '`KD_ETNIS`', 3, -1, FALSE, '`KD_ETNIS`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KD_ETNIS->Sortable = TRUE; // Allow sort
		$this->KD_ETNIS->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KD_ETNIS->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KD_ETNIS->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KD_ETNIS'] = &$this->KD_ETNIS;

		// KD_BHS_HARIAN
		$this->KD_BHS_HARIAN = new cField('m_pasien', 'm_pasien', 'x_KD_BHS_HARIAN', 'KD_BHS_HARIAN', '`KD_BHS_HARIAN`', '`KD_BHS_HARIAN`', 3, -1, FALSE, '`KD_BHS_HARIAN`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->KD_BHS_HARIAN->Sortable = TRUE; // Allow sort
		$this->KD_BHS_HARIAN->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->KD_BHS_HARIAN->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->KD_BHS_HARIAN->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['KD_BHS_HARIAN'] = &$this->KD_BHS_HARIAN;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`m_pasien`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`TGLDAFTAR` DESC";
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
			return "m_pasienlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "m_pasienlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("m_pasienview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("m_pasienview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "m_pasienadd.php?" . $this->UrlParm($parm);
		else
			$url = "m_pasienadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("m_pasienedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("m_pasienadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("m_pasiendelete.php", $this->UrlParm());
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
		$this->NOMR->setDbValue($rs->fields('NOMR'));
		$this->TITLE->setDbValue($rs->fields('TITLE'));
		$this->NAMA->setDbValue($rs->fields('NAMA'));
		$this->IBUKANDUNG->setDbValue($rs->fields('IBUKANDUNG'));
		$this->TEMPAT->setDbValue($rs->fields('TEMPAT'));
		$this->TGLLAHIR->setDbValue($rs->fields('TGLLAHIR'));
		$this->JENISKELAMIN->setDbValue($rs->fields('JENISKELAMIN'));
		$this->ALAMAT->setDbValue($rs->fields('ALAMAT'));
		$this->KDPROVINSI->setDbValue($rs->fields('KDPROVINSI'));
		$this->KOTA->setDbValue($rs->fields('KOTA'));
		$this->KDKECAMATAN->setDbValue($rs->fields('KDKECAMATAN'));
		$this->KELURAHAN->setDbValue($rs->fields('KELURAHAN'));
		$this->NOTELP->setDbValue($rs->fields('NOTELP'));
		$this->NOKTP->setDbValue($rs->fields('NOKTP'));
		$this->SUAMI_ORTU->setDbValue($rs->fields('SUAMI_ORTU'));
		$this->PEKERJAAN->setDbValue($rs->fields('PEKERJAAN'));
		$this->STATUS->setDbValue($rs->fields('STATUS'));
		$this->AGAMA->setDbValue($rs->fields('AGAMA'));
		$this->PENDIDIKAN->setDbValue($rs->fields('PENDIDIKAN'));
		$this->KDCARABAYAR->setDbValue($rs->fields('KDCARABAYAR'));
		$this->NIP->setDbValue($rs->fields('NIP'));
		$this->TGLDAFTAR->setDbValue($rs->fields('TGLDAFTAR'));
		$this->ALAMAT_KTP->setDbValue($rs->fields('ALAMAT_KTP'));
		$this->PARENT_NOMR->setDbValue($rs->fields('PARENT_NOMR'));
		$this->NAMA_OBAT->setDbValue($rs->fields('NAMA_OBAT'));
		$this->DOSIS->setDbValue($rs->fields('DOSIS'));
		$this->CARA_PEMBERIAN->setDbValue($rs->fields('CARA_PEMBERIAN'));
		$this->FREKUENSI->setDbValue($rs->fields('FREKUENSI'));
		$this->WAKTU_TGL->setDbValue($rs->fields('WAKTU_TGL'));
		$this->LAMA_WAKTU->setDbValue($rs->fields('LAMA_WAKTU'));
		$this->ALERGI_OBAT->setDbValue($rs->fields('ALERGI_OBAT'));
		$this->REAKSI_ALERGI->setDbValue($rs->fields('REAKSI_ALERGI'));
		$this->RIWAYAT_KES->setDbValue($rs->fields('RIWAYAT_KES'));
		$this->BB_LAHIR->setDbValue($rs->fields('BB_LAHIR'));
		$this->BB_SEKARANG->setDbValue($rs->fields('BB_SEKARANG'));
		$this->FISIK_FONTANEL->setDbValue($rs->fields('FISIK_FONTANEL'));
		$this->FISIK_REFLEKS->setDbValue($rs->fields('FISIK_REFLEKS'));
		$this->FISIK_SENSASI->setDbValue($rs->fields('FISIK_SENSASI'));
		$this->MOTORIK_KASAR->setDbValue($rs->fields('MOTORIK_KASAR'));
		$this->MOTORIK_HALUS->setDbValue($rs->fields('MOTORIK_HALUS'));
		$this->MAMPU_BICARA->setDbValue($rs->fields('MAMPU_BICARA'));
		$this->MAMPU_SOSIALISASI->setDbValue($rs->fields('MAMPU_SOSIALISASI'));
		$this->BCG->setDbValue($rs->fields('BCG'));
		$this->POLIO->setDbValue($rs->fields('POLIO'));
		$this->DPT->setDbValue($rs->fields('DPT'));
		$this->CAMPAK->setDbValue($rs->fields('CAMPAK'));
		$this->HEPATITIS_B->setDbValue($rs->fields('HEPATITIS_B'));
		$this->TD->setDbValue($rs->fields('TD'));
		$this->SUHU->setDbValue($rs->fields('SUHU'));
		$this->RR->setDbValue($rs->fields('RR'));
		$this->NADI->setDbValue($rs->fields('NADI'));
		$this->BB->setDbValue($rs->fields('BB'));
		$this->TB->setDbValue($rs->fields('TB'));
		$this->EYE->setDbValue($rs->fields('EYE'));
		$this->MOTORIK->setDbValue($rs->fields('MOTORIK'));
		$this->VERBAL->setDbValue($rs->fields('VERBAL'));
		$this->TOTAL_GCS->setDbValue($rs->fields('TOTAL_GCS'));
		$this->REAKSI_PUPIL->setDbValue($rs->fields('REAKSI_PUPIL'));
		$this->KESADARAN->setDbValue($rs->fields('KESADARAN'));
		$this->KEPALA->setDbValue($rs->fields('KEPALA'));
		$this->RAMBUT->setDbValue($rs->fields('RAMBUT'));
		$this->MUKA->setDbValue($rs->fields('MUKA'));
		$this->MATA->setDbValue($rs->fields('MATA'));
		$this->GANG_LIHAT->setDbValue($rs->fields('GANG_LIHAT'));
		$this->ALATBANTU_LIHAT->setDbValue($rs->fields('ALATBANTU_LIHAT'));
		$this->BENTUK->setDbValue($rs->fields('BENTUK'));
		$this->PENDENGARAN->setDbValue($rs->fields('PENDENGARAN'));
		$this->LUB_TELINGA->setDbValue($rs->fields('LUB_TELINGA'));
		$this->BENTUK_HIDUNG->setDbValue($rs->fields('BENTUK_HIDUNG'));
		$this->MEMBRAN_MUK->setDbValue($rs->fields('MEMBRAN_MUK'));
		$this->MAMPU_HIDU->setDbValue($rs->fields('MAMPU_HIDU'));
		$this->ALAT_HIDUNG->setDbValue($rs->fields('ALAT_HIDUNG'));
		$this->RONGGA_MULUT->setDbValue($rs->fields('RONGGA_MULUT'));
		$this->WARNA_MEMBRAN->setDbValue($rs->fields('WARNA_MEMBRAN'));
		$this->LEMBAB->setDbValue($rs->fields('LEMBAB'));
		$this->STOMATITIS->setDbValue($rs->fields('STOMATITIS'));
		$this->LIDAH->setDbValue($rs->fields('LIDAH'));
		$this->GIGI->setDbValue($rs->fields('GIGI'));
		$this->TONSIL->setDbValue($rs->fields('TONSIL'));
		$this->KELAINAN->setDbValue($rs->fields('KELAINAN'));
		$this->PERGERAKAN->setDbValue($rs->fields('PERGERAKAN'));
		$this->KEL_TIROID->setDbValue($rs->fields('KEL_TIROID'));
		$this->KEL_GETAH->setDbValue($rs->fields('KEL_GETAH'));
		$this->TEKANAN_VENA->setDbValue($rs->fields('TEKANAN_VENA'));
		$this->REF_MENELAN->setDbValue($rs->fields('REF_MENELAN'));
		$this->NYERI->setDbValue($rs->fields('NYERI'));
		$this->KREPITASI->setDbValue($rs->fields('KREPITASI'));
		$this->KEL_LAIN->setDbValue($rs->fields('KEL_LAIN'));
		$this->BENTUK_DADA->setDbValue($rs->fields('BENTUK_DADA'));
		$this->POLA_NAPAS->setDbValue($rs->fields('POLA_NAPAS'));
		$this->BENTUK_THORAKS->setDbValue($rs->fields('BENTUK_THORAKS'));
		$this->PAL_KREP->setDbValue($rs->fields('PAL_KREP'));
		$this->BENJOLAN->setDbValue($rs->fields('BENJOLAN'));
		$this->PAL_NYERI->setDbValue($rs->fields('PAL_NYERI'));
		$this->PERKUSI->setDbValue($rs->fields('PERKUSI'));
		$this->PARU->setDbValue($rs->fields('PARU'));
		$this->JANTUNG->setDbValue($rs->fields('JANTUNG'));
		$this->SUARA_JANTUNG->setDbValue($rs->fields('SUARA_JANTUNG'));
		$this->ALATBANTU_JAN->setDbValue($rs->fields('ALATBANTU_JAN'));
		$this->BENTUK_ABDOMEN->setDbValue($rs->fields('BENTUK_ABDOMEN'));
		$this->AUSKULTASI->setDbValue($rs->fields('AUSKULTASI'));
		$this->NYERI_PASI->setDbValue($rs->fields('NYERI_PASI'));
		$this->PEM_KELENJAR->setDbValue($rs->fields('PEM_KELENJAR'));
		$this->PERKUSI_AUS->setDbValue($rs->fields('PERKUSI_AUS'));
		$this->VAGINA->setDbValue($rs->fields('VAGINA'));
		$this->MENSTRUASI->setDbValue($rs->fields('MENSTRUASI'));
		$this->KATETER->setDbValue($rs->fields('KATETER'));
		$this->LABIA_PROM->setDbValue($rs->fields('LABIA_PROM'));
		$this->HAMIL->setDbValue($rs->fields('HAMIL'));
		$this->TGL_HAID->setDbValue($rs->fields('TGL_HAID'));
		$this->PERIKSA_CERVIX->setDbValue($rs->fields('PERIKSA_CERVIX'));
		$this->BENTUK_PAYUDARA->setDbValue($rs->fields('BENTUK_PAYUDARA'));
		$this->KENYAL->setDbValue($rs->fields('KENYAL'));
		$this->MASSA->setDbValue($rs->fields('MASSA'));
		$this->NYERI_RABA->setDbValue($rs->fields('NYERI_RABA'));
		$this->BENTUK_PUTING->setDbValue($rs->fields('BENTUK_PUTING'));
		$this->MAMMO->setDbValue($rs->fields('MAMMO'));
		$this->ALAT_KONTRASEPSI->setDbValue($rs->fields('ALAT_KONTRASEPSI'));
		$this->MASALAH_SEKS->setDbValue($rs->fields('MASALAH_SEKS'));
		$this->PREPUTIUM->setDbValue($rs->fields('PREPUTIUM'));
		$this->MASALAH_PROSTAT->setDbValue($rs->fields('MASALAH_PROSTAT'));
		$this->BENTUK_SKROTUM->setDbValue($rs->fields('BENTUK_SKROTUM'));
		$this->TESTIS->setDbValue($rs->fields('TESTIS'));
		$this->MASSA_BEN->setDbValue($rs->fields('MASSA_BEN'));
		$this->HERNIASI->setDbValue($rs->fields('HERNIASI'));
		$this->LAIN2->setDbValue($rs->fields('LAIN2'));
		$this->ALAT_KONTRA->setDbValue($rs->fields('ALAT_KONTRA'));
		$this->MASALAH_REPRO->setDbValue($rs->fields('MASALAH_REPRO'));
		$this->EKSTREMITAS_ATAS->setDbValue($rs->fields('EKSTREMITAS_ATAS'));
		$this->EKSTREMITAS_BAWAH->setDbValue($rs->fields('EKSTREMITAS_BAWAH'));
		$this->AKTIVITAS->setDbValue($rs->fields('AKTIVITAS'));
		$this->BERJALAN->setDbValue($rs->fields('BERJALAN'));
		$this->SISTEM_INTE->setDbValue($rs->fields('SISTEM_INTE'));
		$this->KENYAMANAN->setDbValue($rs->fields('KENYAMANAN'));
		$this->KES_DIRI->setDbValue($rs->fields('KES_DIRI'));
		$this->SOS_SUPORT->setDbValue($rs->fields('SOS_SUPORT'));
		$this->ANSIETAS->setDbValue($rs->fields('ANSIETAS'));
		$this->KEHILANGAN->setDbValue($rs->fields('KEHILANGAN'));
		$this->STATUS_EMOSI->setDbValue($rs->fields('STATUS_EMOSI'));
		$this->KONSEP_DIRI->setDbValue($rs->fields('KONSEP_DIRI'));
		$this->RESPON_HILANG->setDbValue($rs->fields('RESPON_HILANG'));
		$this->SUMBER_STRESS->setDbValue($rs->fields('SUMBER_STRESS'));
		$this->BERARTI->setDbValue($rs->fields('BERARTI'));
		$this->TERLIBAT->setDbValue($rs->fields('TERLIBAT'));
		$this->HUBUNGAN->setDbValue($rs->fields('HUBUNGAN'));
		$this->KOMUNIKASI->setDbValue($rs->fields('KOMUNIKASI'));
		$this->KEPUTUSAN->setDbValue($rs->fields('KEPUTUSAN'));
		$this->MENGASUH->setDbValue($rs->fields('MENGASUH'));
		$this->DUKUNGAN->setDbValue($rs->fields('DUKUNGAN'));
		$this->REAKSI->setDbValue($rs->fields('REAKSI'));
		$this->BUDAYA->setDbValue($rs->fields('BUDAYA'));
		$this->POLA_AKTIVITAS->setDbValue($rs->fields('POLA_AKTIVITAS'));
		$this->POLA_ISTIRAHAT->setDbValue($rs->fields('POLA_ISTIRAHAT'));
		$this->POLA_MAKAN->setDbValue($rs->fields('POLA_MAKAN'));
		$this->PANTANGAN->setDbValue($rs->fields('PANTANGAN'));
		$this->KEPERCAYAAN->setDbValue($rs->fields('KEPERCAYAAN'));
		$this->PANTANGAN_HARI->setDbValue($rs->fields('PANTANGAN_HARI'));
		$this->PANTANGAN_LAIN->setDbValue($rs->fields('PANTANGAN_LAIN'));
		$this->ANJURAN->setDbValue($rs->fields('ANJURAN'));
		$this->NILAI_KEYAKINAN->setDbValue($rs->fields('NILAI_KEYAKINAN'));
		$this->KEGIATAN_IBADAH->setDbValue($rs->fields('KEGIATAN_IBADAH'));
		$this->PENG_AGAMA->setDbValue($rs->fields('PENG_AGAMA'));
		$this->SPIRIT->setDbValue($rs->fields('SPIRIT'));
		$this->BANTUAN->setDbValue($rs->fields('BANTUAN'));
		$this->PAHAM_PENYAKIT->setDbValue($rs->fields('PAHAM_PENYAKIT'));
		$this->PAHAM_OBAT->setDbValue($rs->fields('PAHAM_OBAT'));
		$this->PAHAM_NUTRISI->setDbValue($rs->fields('PAHAM_NUTRISI'));
		$this->PAHAM_RAWAT->setDbValue($rs->fields('PAHAM_RAWAT'));
		$this->HAMBATAN_EDUKASI->setDbValue($rs->fields('HAMBATAN_EDUKASI'));
		$this->FREK_MAKAN->setDbValue($rs->fields('FREK_MAKAN'));
		$this->JUM_MAKAN->setDbValue($rs->fields('JUM_MAKAN'));
		$this->JEN_MAKAN->setDbValue($rs->fields('JEN_MAKAN'));
		$this->KOM_MAKAN->setDbValue($rs->fields('KOM_MAKAN'));
		$this->DIET->setDbValue($rs->fields('DIET'));
		$this->CARA_MAKAN->setDbValue($rs->fields('CARA_MAKAN'));
		$this->GANGGUAN->setDbValue($rs->fields('GANGGUAN'));
		$this->FREK_MINUM->setDbValue($rs->fields('FREK_MINUM'));
		$this->JUM_MINUM->setDbValue($rs->fields('JUM_MINUM'));
		$this->JEN_MINUM->setDbValue($rs->fields('JEN_MINUM'));
		$this->GANG_MINUM->setDbValue($rs->fields('GANG_MINUM'));
		$this->FREK_BAK->setDbValue($rs->fields('FREK_BAK'));
		$this->WARNA_BAK->setDbValue($rs->fields('WARNA_BAK'));
		$this->JMLH_BAK->setDbValue($rs->fields('JMLH_BAK'));
		$this->PENG_KAT_BAK->setDbValue($rs->fields('PENG_KAT_BAK'));
		$this->KEM_HAN_BAK->setDbValue($rs->fields('KEM_HAN_BAK'));
		$this->INKONT_BAK->setDbValue($rs->fields('INKONT_BAK'));
		$this->DIURESIS_BAK->setDbValue($rs->fields('DIURESIS_BAK'));
		$this->FREK_BAB->setDbValue($rs->fields('FREK_BAB'));
		$this->WARNA_BAB->setDbValue($rs->fields('WARNA_BAB'));
		$this->KONSIST_BAB->setDbValue($rs->fields('KONSIST_BAB'));
		$this->GANG_BAB->setDbValue($rs->fields('GANG_BAB'));
		$this->STOMA_BAB->setDbValue($rs->fields('STOMA_BAB'));
		$this->PENG_OBAT_BAB->setDbValue($rs->fields('PENG_OBAT_BAB'));
		$this->IST_SIANG->setDbValue($rs->fields('IST_SIANG'));
		$this->IST_MALAM->setDbValue($rs->fields('IST_MALAM'));
		$this->IST_CAHAYA->setDbValue($rs->fields('IST_CAHAYA'));
		$this->IST_POSISI->setDbValue($rs->fields('IST_POSISI'));
		$this->IST_LING->setDbValue($rs->fields('IST_LING'));
		$this->IST_GANG_TIDUR->setDbValue($rs->fields('IST_GANG_TIDUR'));
		$this->PENG_OBAT_IST->setDbValue($rs->fields('PENG_OBAT_IST'));
		$this->FREK_MAND->setDbValue($rs->fields('FREK_MAND'));
		$this->CUC_RAMB_MAND->setDbValue($rs->fields('CUC_RAMB_MAND'));
		$this->SIH_GIGI_MAND->setDbValue($rs->fields('SIH_GIGI_MAND'));
		$this->BANT_MAND->setDbValue($rs->fields('BANT_MAND'));
		$this->GANT_PAKAI->setDbValue($rs->fields('GANT_PAKAI'));
		$this->PAK_CUCI->setDbValue($rs->fields('PAK_CUCI'));
		$this->PAK_BANT->setDbValue($rs->fields('PAK_BANT'));
		$this->ALT_BANT->setDbValue($rs->fields('ALT_BANT'));
		$this->KEMP_MUND->setDbValue($rs->fields('KEMP_MUND'));
		$this->BIL_PUT->setDbValue($rs->fields('BIL_PUT'));
		$this->ADAPTIF->setDbValue($rs->fields('ADAPTIF'));
		$this->MALADAPTIF->setDbValue($rs->fields('MALADAPTIF'));
		$this->PENANGGUNGJAWAB_NAMA->setDbValue($rs->fields('PENANGGUNGJAWAB_NAMA'));
		$this->PENANGGUNGJAWAB_HUBUNGAN->setDbValue($rs->fields('PENANGGUNGJAWAB_HUBUNGAN'));
		$this->PENANGGUNGJAWAB_ALAMAT->setDbValue($rs->fields('PENANGGUNGJAWAB_ALAMAT'));
		$this->PENANGGUNGJAWAB_PHONE->setDbValue($rs->fields('PENANGGUNGJAWAB_PHONE'));
		$this->obat2->setDbValue($rs->fields('obat2'));
		$this->PERBANDINGAN_BB->setDbValue($rs->fields('PERBANDINGAN_BB'));
		$this->KONTINENSIA->setDbValue($rs->fields('KONTINENSIA'));
		$this->JENIS_KULIT1->setDbValue($rs->fields('JENIS_KULIT1'));
		$this->MOBILITAS->setDbValue($rs->fields('MOBILITAS'));
		$this->JK->setDbValue($rs->fields('JK'));
		$this->UMUR->setDbValue($rs->fields('UMUR'));
		$this->NAFSU_MAKAN->setDbValue($rs->fields('NAFSU_MAKAN'));
		$this->OBAT1->setDbValue($rs->fields('OBAT1'));
		$this->MALNUTRISI->setDbValue($rs->fields('MALNUTRISI'));
		$this->MOTORIK1->setDbValue($rs->fields('MOTORIK1'));
		$this->SPINAL->setDbValue($rs->fields('SPINAL'));
		$this->MEJA_OPERASI->setDbValue($rs->fields('MEJA_OPERASI'));
		$this->RIWAYAT_JATUH->setDbValue($rs->fields('RIWAYAT_JATUH'));
		$this->DIAGNOSIS_SEKUNDER->setDbValue($rs->fields('DIAGNOSIS_SEKUNDER'));
		$this->ALAT_BANTU->setDbValue($rs->fields('ALAT_BANTU'));
		$this->HEPARIN->setDbValue($rs->fields('HEPARIN'));
		$this->GAYA_BERJALAN->setDbValue($rs->fields('GAYA_BERJALAN'));
		$this->KESADARAN1->setDbValue($rs->fields('KESADARAN1'));
		$this->NOMR_LAMA->setDbValue($rs->fields('NOMR_LAMA'));
		$this->NO_KARTU->setDbValue($rs->fields('NO_KARTU'));
		$this->JNS_PASIEN->setDbValue($rs->fields('JNS_PASIEN'));
		$this->nama_ayah->setDbValue($rs->fields('nama_ayah'));
		$this->nama_ibu->setDbValue($rs->fields('nama_ibu'));
		$this->nama_suami->setDbValue($rs->fields('nama_suami'));
		$this->nama_istri->setDbValue($rs->fields('nama_istri'));
		$this->KD_ETNIS->setDbValue($rs->fields('KD_ETNIS'));
		$this->KD_BHS_HARIAN->setDbValue($rs->fields('KD_BHS_HARIAN'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// id
		// NOMR
		// TITLE
		// NAMA
		// IBUKANDUNG
		// TEMPAT
		// TGLLAHIR
		// JENISKELAMIN
		// ALAMAT
		// KDPROVINSI
		// KOTA
		// KDKECAMATAN
		// KELURAHAN
		// NOTELP
		// NOKTP
		// SUAMI_ORTU
		// PEKERJAAN
		// STATUS
		// AGAMA
		// PENDIDIKAN
		// KDCARABAYAR
		// NIP
		// TGLDAFTAR
		// ALAMAT_KTP
		// PARENT_NOMR
		// NAMA_OBAT
		// DOSIS
		// CARA_PEMBERIAN
		// FREKUENSI
		// WAKTU_TGL
		// LAMA_WAKTU
		// ALERGI_OBAT
		// REAKSI_ALERGI
		// RIWAYAT_KES
		// BB_LAHIR
		// BB_SEKARANG
		// FISIK_FONTANEL
		// FISIK_REFLEKS
		// FISIK_SENSASI
		// MOTORIK_KASAR
		// MOTORIK_HALUS
		// MAMPU_BICARA
		// MAMPU_SOSIALISASI
		// BCG
		// POLIO
		// DPT
		// CAMPAK
		// HEPATITIS_B
		// TD
		// SUHU
		// RR
		// NADI
		// BB
		// TB
		// EYE
		// MOTORIK
		// VERBAL
		// TOTAL_GCS
		// REAKSI_PUPIL
		// KESADARAN
		// KEPALA
		// RAMBUT
		// MUKA
		// MATA
		// GANG_LIHAT
		// ALATBANTU_LIHAT
		// BENTUK
		// PENDENGARAN
		// LUB_TELINGA
		// BENTUK_HIDUNG
		// MEMBRAN_MUK
		// MAMPU_HIDU
		// ALAT_HIDUNG
		// RONGGA_MULUT
		// WARNA_MEMBRAN
		// LEMBAB
		// STOMATITIS
		// LIDAH
		// GIGI
		// TONSIL
		// KELAINAN
		// PERGERAKAN
		// KEL_TIROID
		// KEL_GETAH
		// TEKANAN_VENA
		// REF_MENELAN
		// NYERI
		// KREPITASI
		// KEL_LAIN
		// BENTUK_DADA
		// POLA_NAPAS
		// BENTUK_THORAKS
		// PAL_KREP
		// BENJOLAN
		// PAL_NYERI
		// PERKUSI
		// PARU
		// JANTUNG
		// SUARA_JANTUNG
		// ALATBANTU_JAN
		// BENTUK_ABDOMEN
		// AUSKULTASI
		// NYERI_PASI
		// PEM_KELENJAR
		// PERKUSI_AUS
		// VAGINA
		// MENSTRUASI
		// KATETER
		// LABIA_PROM
		// HAMIL
		// TGL_HAID
		// PERIKSA_CERVIX
		// BENTUK_PAYUDARA
		// KENYAL
		// MASSA
		// NYERI_RABA
		// BENTUK_PUTING
		// MAMMO
		// ALAT_KONTRASEPSI
		// MASALAH_SEKS
		// PREPUTIUM
		// MASALAH_PROSTAT
		// BENTUK_SKROTUM
		// TESTIS
		// MASSA_BEN
		// HERNIASI
		// LAIN2
		// ALAT_KONTRA
		// MASALAH_REPRO
		// EKSTREMITAS_ATAS
		// EKSTREMITAS_BAWAH
		// AKTIVITAS
		// BERJALAN
		// SISTEM_INTE
		// KENYAMANAN
		// KES_DIRI
		// SOS_SUPORT
		// ANSIETAS
		// KEHILANGAN
		// STATUS_EMOSI
		// KONSEP_DIRI
		// RESPON_HILANG
		// SUMBER_STRESS
		// BERARTI
		// TERLIBAT
		// HUBUNGAN
		// KOMUNIKASI
		// KEPUTUSAN
		// MENGASUH
		// DUKUNGAN
		// REAKSI
		// BUDAYA
		// POLA_AKTIVITAS
		// POLA_ISTIRAHAT
		// POLA_MAKAN
		// PANTANGAN
		// KEPERCAYAAN
		// PANTANGAN_HARI
		// PANTANGAN_LAIN
		// ANJURAN
		// NILAI_KEYAKINAN
		// KEGIATAN_IBADAH
		// PENG_AGAMA
		// SPIRIT
		// BANTUAN
		// PAHAM_PENYAKIT
		// PAHAM_OBAT
		// PAHAM_NUTRISI
		// PAHAM_RAWAT
		// HAMBATAN_EDUKASI
		// FREK_MAKAN
		// JUM_MAKAN
		// JEN_MAKAN
		// KOM_MAKAN
		// DIET
		// CARA_MAKAN
		// GANGGUAN
		// FREK_MINUM
		// JUM_MINUM
		// JEN_MINUM
		// GANG_MINUM
		// FREK_BAK
		// WARNA_BAK
		// JMLH_BAK
		// PENG_KAT_BAK
		// KEM_HAN_BAK
		// INKONT_BAK
		// DIURESIS_BAK
		// FREK_BAB
		// WARNA_BAB
		// KONSIST_BAB
		// GANG_BAB
		// STOMA_BAB
		// PENG_OBAT_BAB
		// IST_SIANG
		// IST_MALAM
		// IST_CAHAYA
		// IST_POSISI
		// IST_LING
		// IST_GANG_TIDUR
		// PENG_OBAT_IST
		// FREK_MAND
		// CUC_RAMB_MAND
		// SIH_GIGI_MAND
		// BANT_MAND
		// GANT_PAKAI
		// PAK_CUCI
		// PAK_BANT
		// ALT_BANT
		// KEMP_MUND
		// BIL_PUT
		// ADAPTIF
		// MALADAPTIF
		// PENANGGUNGJAWAB_NAMA
		// PENANGGUNGJAWAB_HUBUNGAN
		// PENANGGUNGJAWAB_ALAMAT
		// PENANGGUNGJAWAB_PHONE
		// obat2
		// PERBANDINGAN_BB
		// KONTINENSIA
		// JENIS_KULIT1
		// MOBILITAS
		// JK
		// UMUR
		// NAFSU_MAKAN
		// OBAT1
		// MALNUTRISI
		// MOTORIK1
		// SPINAL
		// MEJA_OPERASI
		// RIWAYAT_JATUH
		// DIAGNOSIS_SEKUNDER
		// ALAT_BANTU
		// HEPARIN
		// GAYA_BERJALAN
		// KESADARAN1
		// NOMR_LAMA
		// NO_KARTU
		// JNS_PASIEN
		// nama_ayah
		// nama_ibu
		// nama_suami
		// nama_istri
		// KD_ETNIS
		// KD_BHS_HARIAN
		// id

		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// NOMR
		$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
		$this->NOMR->ViewCustomAttributes = "";

		// TITLE
		if (strval($this->TITLE->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->TITLE->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_titel`";
		$sWhereWrk = "";
		$this->TITLE->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->TITLE, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->TITLE->ViewValue = $this->TITLE->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->TITLE->ViewValue = $this->TITLE->CurrentValue;
			}
		} else {
			$this->TITLE->ViewValue = NULL;
		}
		$this->TITLE->ViewCustomAttributes = "";

		// NAMA
		$this->NAMA->ViewValue = $this->NAMA->CurrentValue;
		$this->NAMA->ViewCustomAttributes = "";

		// IBUKANDUNG
		$this->IBUKANDUNG->ViewValue = $this->IBUKANDUNG->CurrentValue;
		$this->IBUKANDUNG->ViewCustomAttributes = "";

		// TEMPAT
		$this->TEMPAT->ViewValue = $this->TEMPAT->CurrentValue;
		$this->TEMPAT->ViewCustomAttributes = "";

		// TGLLAHIR
		$this->TGLLAHIR->ViewValue = $this->TGLLAHIR->CurrentValue;
		$this->TGLLAHIR->ViewValue = ew_FormatDateTime($this->TGLLAHIR->ViewValue, 7);
		$this->TGLLAHIR->ViewCustomAttributes = "";

		// JENISKELAMIN
		if (strval($this->JENISKELAMIN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->JENISKELAMIN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id`, `jeniskelamin` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jeniskelamin`";
		$sWhereWrk = "";
		$this->JENISKELAMIN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JENISKELAMIN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JENISKELAMIN->ViewValue = $this->JENISKELAMIN->CurrentValue;
			}
		} else {
			$this->JENISKELAMIN->ViewValue = NULL;
		}
		$this->JENISKELAMIN->ViewCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->ViewValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->ViewCustomAttributes = "";

		// KDPROVINSI
		if (strval($this->KDPROVINSI->CurrentValue) <> "") {
			$sFilterWrk = "`idprovinsi`" . ew_SearchString("=", $this->KDPROVINSI->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idprovinsi`, `namaprovinsi` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_provinsi`";
		$sWhereWrk = "";
		$this->KDPROVINSI->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDPROVINSI, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDPROVINSI->ViewValue = $this->KDPROVINSI->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDPROVINSI->ViewValue = $this->KDPROVINSI->CurrentValue;
			}
		} else {
			$this->KDPROVINSI->ViewValue = NULL;
		}
		$this->KDPROVINSI->ViewCustomAttributes = "";

		// KOTA
		if (strval($this->KOTA->CurrentValue) <> "") {
			$sFilterWrk = "`idkota`" . ew_SearchString("=", $this->KOTA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkota`, `namakota` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kota`";
		$sWhereWrk = "";
		$this->KOTA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KOTA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KOTA->ViewValue = $this->KOTA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KOTA->ViewValue = $this->KOTA->CurrentValue;
			}
		} else {
			$this->KOTA->ViewValue = NULL;
		}
		$this->KOTA->ViewCustomAttributes = "";

		// KDKECAMATAN
		if (strval($this->KDKECAMATAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkecamatan`" . ew_SearchString("=", $this->KDKECAMATAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkecamatan`, `namakecamatan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kecamatan`";
		$sWhereWrk = "";
		$this->KDKECAMATAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KDKECAMATAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KDKECAMATAN->ViewValue = $this->KDKECAMATAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KDKECAMATAN->ViewValue = $this->KDKECAMATAN->CurrentValue;
			}
		} else {
			$this->KDKECAMATAN->ViewValue = NULL;
		}
		$this->KDKECAMATAN->ViewCustomAttributes = "";

		// KELURAHAN
		if (strval($this->KELURAHAN->CurrentValue) <> "") {
			$sFilterWrk = "`idkelurahan`" . ew_SearchString("=", $this->KELURAHAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idkelurahan`, `namakelurahan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_kelurahan`";
		$sWhereWrk = "";
		$this->KELURAHAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KELURAHAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KELURAHAN->ViewValue = $this->KELURAHAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KELURAHAN->ViewValue = $this->KELURAHAN->CurrentValue;
			}
		} else {
			$this->KELURAHAN->ViewValue = NULL;
		}
		$this->KELURAHAN->ViewCustomAttributes = "";

		// NOTELP
		$this->NOTELP->ViewValue = $this->NOTELP->CurrentValue;
		$this->NOTELP->ViewCustomAttributes = "";

		// NOKTP
		$this->NOKTP->ViewValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->ViewCustomAttributes = "";

		// SUAMI_ORTU
		$this->SUAMI_ORTU->ViewValue = $this->SUAMI_ORTU->CurrentValue;
		$this->SUAMI_ORTU->ViewCustomAttributes = "";

		// PEKERJAAN
		$this->PEKERJAAN->ViewValue = $this->PEKERJAAN->CurrentValue;
		$this->PEKERJAAN->ViewCustomAttributes = "";

		// STATUS
		if (strval($this->STATUS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->STATUS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `statusperkawinan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_statusperkawin`";
		$sWhereWrk = "";
		$this->STATUS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->STATUS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->STATUS->ViewValue = $this->STATUS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->STATUS->ViewValue = $this->STATUS->CurrentValue;
			}
		} else {
			$this->STATUS->ViewValue = NULL;
		}
		$this->STATUS->ViewCustomAttributes = "";

		// AGAMA
		if (strval($this->AGAMA->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->AGAMA->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `agama` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_agama`";
		$sWhereWrk = "";
		$this->AGAMA->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->AGAMA, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->AGAMA->ViewValue = $this->AGAMA->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->AGAMA->ViewValue = $this->AGAMA->CurrentValue;
			}
		} else {
			$this->AGAMA->ViewValue = NULL;
		}
		$this->AGAMA->ViewCustomAttributes = "";

		// PENDIDIKAN
		if (strval($this->PENDIDIKAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->PENDIDIKAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `pendidikan` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_pendidikanterakhir`";
		$sWhereWrk = "";
		$this->PENDIDIKAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PENDIDIKAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PENDIDIKAN->ViewValue = $this->PENDIDIKAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PENDIDIKAN->ViewValue = $this->PENDIDIKAN->CurrentValue;
			}
		} else {
			$this->PENDIDIKAN->ViewValue = NULL;
		}
		$this->PENDIDIKAN->ViewCustomAttributes = "";

		// KDCARABAYAR
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

		// TGLDAFTAR
		$this->TGLDAFTAR->ViewValue = $this->TGLDAFTAR->CurrentValue;
		$this->TGLDAFTAR->ViewValue = ew_FormatDateTime($this->TGLDAFTAR->ViewValue, 7);
		$this->TGLDAFTAR->ViewCustomAttributes = "";

		// ALAMAT_KTP
		$this->ALAMAT_KTP->ViewValue = $this->ALAMAT_KTP->CurrentValue;
		$this->ALAMAT_KTP->ViewCustomAttributes = "";

		// PARENT_NOMR
		$this->PARENT_NOMR->ViewValue = $this->PARENT_NOMR->CurrentValue;
		$this->PARENT_NOMR->ViewCustomAttributes = "";

		// NAMA_OBAT
		$this->NAMA_OBAT->ViewValue = $this->NAMA_OBAT->CurrentValue;
		$this->NAMA_OBAT->ViewCustomAttributes = "";

		// DOSIS
		$this->DOSIS->ViewValue = $this->DOSIS->CurrentValue;
		$this->DOSIS->ViewCustomAttributes = "";

		// CARA_PEMBERIAN
		$this->CARA_PEMBERIAN->ViewValue = $this->CARA_PEMBERIAN->CurrentValue;
		$this->CARA_PEMBERIAN->ViewCustomAttributes = "";

		// FREKUENSI
		$this->FREKUENSI->ViewValue = $this->FREKUENSI->CurrentValue;
		$this->FREKUENSI->ViewCustomAttributes = "";

		// WAKTU_TGL
		$this->WAKTU_TGL->ViewValue = $this->WAKTU_TGL->CurrentValue;
		$this->WAKTU_TGL->ViewCustomAttributes = "";

		// LAMA_WAKTU
		$this->LAMA_WAKTU->ViewValue = $this->LAMA_WAKTU->CurrentValue;
		$this->LAMA_WAKTU->ViewCustomAttributes = "";

		// ALERGI_OBAT
		$this->ALERGI_OBAT->ViewValue = $this->ALERGI_OBAT->CurrentValue;
		$this->ALERGI_OBAT->ViewCustomAttributes = "";

		// REAKSI_ALERGI
		$this->REAKSI_ALERGI->ViewValue = $this->REAKSI_ALERGI->CurrentValue;
		$this->REAKSI_ALERGI->ViewCustomAttributes = "";

		// RIWAYAT_KES
		$this->RIWAYAT_KES->ViewValue = $this->RIWAYAT_KES->CurrentValue;
		$this->RIWAYAT_KES->ViewCustomAttributes = "";

		// BB_LAHIR
		$this->BB_LAHIR->ViewValue = $this->BB_LAHIR->CurrentValue;
		$this->BB_LAHIR->ViewCustomAttributes = "";

		// BB_SEKARANG
		$this->BB_SEKARANG->ViewValue = $this->BB_SEKARANG->CurrentValue;
		$this->BB_SEKARANG->ViewCustomAttributes = "";

		// FISIK_FONTANEL
		$this->FISIK_FONTANEL->ViewValue = $this->FISIK_FONTANEL->CurrentValue;
		$this->FISIK_FONTANEL->ViewCustomAttributes = "";

		// FISIK_REFLEKS
		$this->FISIK_REFLEKS->ViewValue = $this->FISIK_REFLEKS->CurrentValue;
		$this->FISIK_REFLEKS->ViewCustomAttributes = "";

		// FISIK_SENSASI
		$this->FISIK_SENSASI->ViewValue = $this->FISIK_SENSASI->CurrentValue;
		$this->FISIK_SENSASI->ViewCustomAttributes = "";

		// MOTORIK_KASAR
		$this->MOTORIK_KASAR->ViewValue = $this->MOTORIK_KASAR->CurrentValue;
		$this->MOTORIK_KASAR->ViewCustomAttributes = "";

		// MOTORIK_HALUS
		$this->MOTORIK_HALUS->ViewValue = $this->MOTORIK_HALUS->CurrentValue;
		$this->MOTORIK_HALUS->ViewCustomAttributes = "";

		// MAMPU_BICARA
		$this->MAMPU_BICARA->ViewValue = $this->MAMPU_BICARA->CurrentValue;
		$this->MAMPU_BICARA->ViewCustomAttributes = "";

		// MAMPU_SOSIALISASI
		$this->MAMPU_SOSIALISASI->ViewValue = $this->MAMPU_SOSIALISASI->CurrentValue;
		$this->MAMPU_SOSIALISASI->ViewCustomAttributes = "";

		// BCG
		$this->BCG->ViewValue = $this->BCG->CurrentValue;
		$this->BCG->ViewCustomAttributes = "";

		// POLIO
		$this->POLIO->ViewValue = $this->POLIO->CurrentValue;
		$this->POLIO->ViewCustomAttributes = "";

		// DPT
		$this->DPT->ViewValue = $this->DPT->CurrentValue;
		$this->DPT->ViewCustomAttributes = "";

		// CAMPAK
		$this->CAMPAK->ViewValue = $this->CAMPAK->CurrentValue;
		$this->CAMPAK->ViewCustomAttributes = "";

		// HEPATITIS_B
		$this->HEPATITIS_B->ViewValue = $this->HEPATITIS_B->CurrentValue;
		$this->HEPATITIS_B->ViewCustomAttributes = "";

		// TD
		$this->TD->ViewValue = $this->TD->CurrentValue;
		$this->TD->ViewCustomAttributes = "";

		// SUHU
		$this->SUHU->ViewValue = $this->SUHU->CurrentValue;
		$this->SUHU->ViewCustomAttributes = "";

		// RR
		$this->RR->ViewValue = $this->RR->CurrentValue;
		$this->RR->ViewCustomAttributes = "";

		// NADI
		$this->NADI->ViewValue = $this->NADI->CurrentValue;
		$this->NADI->ViewCustomAttributes = "";

		// BB
		$this->BB->ViewValue = $this->BB->CurrentValue;
		$this->BB->ViewCustomAttributes = "";

		// TB
		$this->TB->ViewValue = $this->TB->CurrentValue;
		$this->TB->ViewCustomAttributes = "";

		// EYE
		$this->EYE->ViewValue = $this->EYE->CurrentValue;
		$this->EYE->ViewCustomAttributes = "";

		// MOTORIK
		$this->MOTORIK->ViewValue = $this->MOTORIK->CurrentValue;
		$this->MOTORIK->ViewCustomAttributes = "";

		// VERBAL
		$this->VERBAL->ViewValue = $this->VERBAL->CurrentValue;
		$this->VERBAL->ViewCustomAttributes = "";

		// TOTAL_GCS
		$this->TOTAL_GCS->ViewValue = $this->TOTAL_GCS->CurrentValue;
		$this->TOTAL_GCS->ViewCustomAttributes = "";

		// REAKSI_PUPIL
		$this->REAKSI_PUPIL->ViewValue = $this->REAKSI_PUPIL->CurrentValue;
		$this->REAKSI_PUPIL->ViewCustomAttributes = "";

		// KESADARAN
		$this->KESADARAN->ViewValue = $this->KESADARAN->CurrentValue;
		$this->KESADARAN->ViewCustomAttributes = "";

		// KEPALA
		$this->KEPALA->ViewValue = $this->KEPALA->CurrentValue;
		$this->KEPALA->ViewCustomAttributes = "";

		// RAMBUT
		$this->RAMBUT->ViewValue = $this->RAMBUT->CurrentValue;
		$this->RAMBUT->ViewCustomAttributes = "";

		// MUKA
		$this->MUKA->ViewValue = $this->MUKA->CurrentValue;
		$this->MUKA->ViewCustomAttributes = "";

		// MATA
		$this->MATA->ViewValue = $this->MATA->CurrentValue;
		$this->MATA->ViewCustomAttributes = "";

		// GANG_LIHAT
		$this->GANG_LIHAT->ViewValue = $this->GANG_LIHAT->CurrentValue;
		$this->GANG_LIHAT->ViewCustomAttributes = "";

		// ALATBANTU_LIHAT
		$this->ALATBANTU_LIHAT->ViewValue = $this->ALATBANTU_LIHAT->CurrentValue;
		$this->ALATBANTU_LIHAT->ViewCustomAttributes = "";

		// BENTUK
		$this->BENTUK->ViewValue = $this->BENTUK->CurrentValue;
		$this->BENTUK->ViewCustomAttributes = "";

		// PENDENGARAN
		$this->PENDENGARAN->ViewValue = $this->PENDENGARAN->CurrentValue;
		$this->PENDENGARAN->ViewCustomAttributes = "";

		// LUB_TELINGA
		$this->LUB_TELINGA->ViewValue = $this->LUB_TELINGA->CurrentValue;
		$this->LUB_TELINGA->ViewCustomAttributes = "";

		// BENTUK_HIDUNG
		$this->BENTUK_HIDUNG->ViewValue = $this->BENTUK_HIDUNG->CurrentValue;
		$this->BENTUK_HIDUNG->ViewCustomAttributes = "";

		// MEMBRAN_MUK
		$this->MEMBRAN_MUK->ViewValue = $this->MEMBRAN_MUK->CurrentValue;
		$this->MEMBRAN_MUK->ViewCustomAttributes = "";

		// MAMPU_HIDU
		$this->MAMPU_HIDU->ViewValue = $this->MAMPU_HIDU->CurrentValue;
		$this->MAMPU_HIDU->ViewCustomAttributes = "";

		// ALAT_HIDUNG
		$this->ALAT_HIDUNG->ViewValue = $this->ALAT_HIDUNG->CurrentValue;
		$this->ALAT_HIDUNG->ViewCustomAttributes = "";

		// RONGGA_MULUT
		$this->RONGGA_MULUT->ViewValue = $this->RONGGA_MULUT->CurrentValue;
		$this->RONGGA_MULUT->ViewCustomAttributes = "";

		// WARNA_MEMBRAN
		$this->WARNA_MEMBRAN->ViewValue = $this->WARNA_MEMBRAN->CurrentValue;
		$this->WARNA_MEMBRAN->ViewCustomAttributes = "";

		// LEMBAB
		$this->LEMBAB->ViewValue = $this->LEMBAB->CurrentValue;
		$this->LEMBAB->ViewCustomAttributes = "";

		// STOMATITIS
		$this->STOMATITIS->ViewValue = $this->STOMATITIS->CurrentValue;
		$this->STOMATITIS->ViewCustomAttributes = "";

		// LIDAH
		$this->LIDAH->ViewValue = $this->LIDAH->CurrentValue;
		$this->LIDAH->ViewCustomAttributes = "";

		// GIGI
		$this->GIGI->ViewValue = $this->GIGI->CurrentValue;
		$this->GIGI->ViewCustomAttributes = "";

		// TONSIL
		$this->TONSIL->ViewValue = $this->TONSIL->CurrentValue;
		$this->TONSIL->ViewCustomAttributes = "";

		// KELAINAN
		$this->KELAINAN->ViewValue = $this->KELAINAN->CurrentValue;
		$this->KELAINAN->ViewCustomAttributes = "";

		// PERGERAKAN
		$this->PERGERAKAN->ViewValue = $this->PERGERAKAN->CurrentValue;
		$this->PERGERAKAN->ViewCustomAttributes = "";

		// KEL_TIROID
		$this->KEL_TIROID->ViewValue = $this->KEL_TIROID->CurrentValue;
		$this->KEL_TIROID->ViewCustomAttributes = "";

		// KEL_GETAH
		$this->KEL_GETAH->ViewValue = $this->KEL_GETAH->CurrentValue;
		$this->KEL_GETAH->ViewCustomAttributes = "";

		// TEKANAN_VENA
		$this->TEKANAN_VENA->ViewValue = $this->TEKANAN_VENA->CurrentValue;
		$this->TEKANAN_VENA->ViewCustomAttributes = "";

		// REF_MENELAN
		$this->REF_MENELAN->ViewValue = $this->REF_MENELAN->CurrentValue;
		$this->REF_MENELAN->ViewCustomAttributes = "";

		// NYERI
		$this->NYERI->ViewValue = $this->NYERI->CurrentValue;
		$this->NYERI->ViewCustomAttributes = "";

		// KREPITASI
		$this->KREPITASI->ViewValue = $this->KREPITASI->CurrentValue;
		$this->KREPITASI->ViewCustomAttributes = "";

		// KEL_LAIN
		$this->KEL_LAIN->ViewValue = $this->KEL_LAIN->CurrentValue;
		$this->KEL_LAIN->ViewCustomAttributes = "";

		// BENTUK_DADA
		$this->BENTUK_DADA->ViewValue = $this->BENTUK_DADA->CurrentValue;
		$this->BENTUK_DADA->ViewCustomAttributes = "";

		// POLA_NAPAS
		$this->POLA_NAPAS->ViewValue = $this->POLA_NAPAS->CurrentValue;
		$this->POLA_NAPAS->ViewCustomAttributes = "";

		// BENTUK_THORAKS
		$this->BENTUK_THORAKS->ViewValue = $this->BENTUK_THORAKS->CurrentValue;
		$this->BENTUK_THORAKS->ViewCustomAttributes = "";

		// PAL_KREP
		$this->PAL_KREP->ViewValue = $this->PAL_KREP->CurrentValue;
		$this->PAL_KREP->ViewCustomAttributes = "";

		// BENJOLAN
		$this->BENJOLAN->ViewValue = $this->BENJOLAN->CurrentValue;
		$this->BENJOLAN->ViewCustomAttributes = "";

		// PAL_NYERI
		$this->PAL_NYERI->ViewValue = $this->PAL_NYERI->CurrentValue;
		$this->PAL_NYERI->ViewCustomAttributes = "";

		// PERKUSI
		$this->PERKUSI->ViewValue = $this->PERKUSI->CurrentValue;
		$this->PERKUSI->ViewCustomAttributes = "";

		// PARU
		$this->PARU->ViewValue = $this->PARU->CurrentValue;
		$this->PARU->ViewCustomAttributes = "";

		// JANTUNG
		$this->JANTUNG->ViewValue = $this->JANTUNG->CurrentValue;
		$this->JANTUNG->ViewCustomAttributes = "";

		// SUARA_JANTUNG
		$this->SUARA_JANTUNG->ViewValue = $this->SUARA_JANTUNG->CurrentValue;
		$this->SUARA_JANTUNG->ViewCustomAttributes = "";

		// ALATBANTU_JAN
		$this->ALATBANTU_JAN->ViewValue = $this->ALATBANTU_JAN->CurrentValue;
		$this->ALATBANTU_JAN->ViewCustomAttributes = "";

		// BENTUK_ABDOMEN
		$this->BENTUK_ABDOMEN->ViewValue = $this->BENTUK_ABDOMEN->CurrentValue;
		$this->BENTUK_ABDOMEN->ViewCustomAttributes = "";

		// AUSKULTASI
		$this->AUSKULTASI->ViewValue = $this->AUSKULTASI->CurrentValue;
		$this->AUSKULTASI->ViewCustomAttributes = "";

		// NYERI_PASI
		$this->NYERI_PASI->ViewValue = $this->NYERI_PASI->CurrentValue;
		$this->NYERI_PASI->ViewCustomAttributes = "";

		// PEM_KELENJAR
		$this->PEM_KELENJAR->ViewValue = $this->PEM_KELENJAR->CurrentValue;
		$this->PEM_KELENJAR->ViewCustomAttributes = "";

		// PERKUSI_AUS
		$this->PERKUSI_AUS->ViewValue = $this->PERKUSI_AUS->CurrentValue;
		$this->PERKUSI_AUS->ViewCustomAttributes = "";

		// VAGINA
		$this->VAGINA->ViewValue = $this->VAGINA->CurrentValue;
		$this->VAGINA->ViewCustomAttributes = "";

		// MENSTRUASI
		$this->MENSTRUASI->ViewValue = $this->MENSTRUASI->CurrentValue;
		$this->MENSTRUASI->ViewCustomAttributes = "";

		// KATETER
		$this->KATETER->ViewValue = $this->KATETER->CurrentValue;
		$this->KATETER->ViewCustomAttributes = "";

		// LABIA_PROM
		$this->LABIA_PROM->ViewValue = $this->LABIA_PROM->CurrentValue;
		$this->LABIA_PROM->ViewCustomAttributes = "";

		// HAMIL
		$this->HAMIL->ViewValue = $this->HAMIL->CurrentValue;
		$this->HAMIL->ViewCustomAttributes = "";

		// TGL_HAID
		$this->TGL_HAID->ViewValue = $this->TGL_HAID->CurrentValue;
		$this->TGL_HAID->ViewValue = ew_FormatDateTime($this->TGL_HAID->ViewValue, 0);
		$this->TGL_HAID->ViewCustomAttributes = "";

		// PERIKSA_CERVIX
		$this->PERIKSA_CERVIX->ViewValue = $this->PERIKSA_CERVIX->CurrentValue;
		$this->PERIKSA_CERVIX->ViewCustomAttributes = "";

		// BENTUK_PAYUDARA
		$this->BENTUK_PAYUDARA->ViewValue = $this->BENTUK_PAYUDARA->CurrentValue;
		$this->BENTUK_PAYUDARA->ViewCustomAttributes = "";

		// KENYAL
		$this->KENYAL->ViewValue = $this->KENYAL->CurrentValue;
		$this->KENYAL->ViewCustomAttributes = "";

		// MASSA
		$this->MASSA->ViewValue = $this->MASSA->CurrentValue;
		$this->MASSA->ViewCustomAttributes = "";

		// NYERI_RABA
		$this->NYERI_RABA->ViewValue = $this->NYERI_RABA->CurrentValue;
		$this->NYERI_RABA->ViewCustomAttributes = "";

		// BENTUK_PUTING
		$this->BENTUK_PUTING->ViewValue = $this->BENTUK_PUTING->CurrentValue;
		$this->BENTUK_PUTING->ViewCustomAttributes = "";

		// MAMMO
		$this->MAMMO->ViewValue = $this->MAMMO->CurrentValue;
		$this->MAMMO->ViewCustomAttributes = "";

		// ALAT_KONTRASEPSI
		$this->ALAT_KONTRASEPSI->ViewValue = $this->ALAT_KONTRASEPSI->CurrentValue;
		$this->ALAT_KONTRASEPSI->ViewCustomAttributes = "";

		// MASALAH_SEKS
		$this->MASALAH_SEKS->ViewValue = $this->MASALAH_SEKS->CurrentValue;
		$this->MASALAH_SEKS->ViewCustomAttributes = "";

		// PREPUTIUM
		$this->PREPUTIUM->ViewValue = $this->PREPUTIUM->CurrentValue;
		$this->PREPUTIUM->ViewCustomAttributes = "";

		// MASALAH_PROSTAT
		$this->MASALAH_PROSTAT->ViewValue = $this->MASALAH_PROSTAT->CurrentValue;
		$this->MASALAH_PROSTAT->ViewCustomAttributes = "";

		// BENTUK_SKROTUM
		$this->BENTUK_SKROTUM->ViewValue = $this->BENTUK_SKROTUM->CurrentValue;
		$this->BENTUK_SKROTUM->ViewCustomAttributes = "";

		// TESTIS
		$this->TESTIS->ViewValue = $this->TESTIS->CurrentValue;
		$this->TESTIS->ViewCustomAttributes = "";

		// MASSA_BEN
		$this->MASSA_BEN->ViewValue = $this->MASSA_BEN->CurrentValue;
		$this->MASSA_BEN->ViewCustomAttributes = "";

		// HERNIASI
		$this->HERNIASI->ViewValue = $this->HERNIASI->CurrentValue;
		$this->HERNIASI->ViewCustomAttributes = "";

		// LAIN2
		$this->LAIN2->ViewValue = $this->LAIN2->CurrentValue;
		$this->LAIN2->ViewCustomAttributes = "";

		// ALAT_KONTRA
		$this->ALAT_KONTRA->ViewValue = $this->ALAT_KONTRA->CurrentValue;
		$this->ALAT_KONTRA->ViewCustomAttributes = "";

		// MASALAH_REPRO
		$this->MASALAH_REPRO->ViewValue = $this->MASALAH_REPRO->CurrentValue;
		$this->MASALAH_REPRO->ViewCustomAttributes = "";

		// EKSTREMITAS_ATAS
		$this->EKSTREMITAS_ATAS->ViewValue = $this->EKSTREMITAS_ATAS->CurrentValue;
		$this->EKSTREMITAS_ATAS->ViewCustomAttributes = "";

		// EKSTREMITAS_BAWAH
		$this->EKSTREMITAS_BAWAH->ViewValue = $this->EKSTREMITAS_BAWAH->CurrentValue;
		$this->EKSTREMITAS_BAWAH->ViewCustomAttributes = "";

		// AKTIVITAS
		$this->AKTIVITAS->ViewValue = $this->AKTIVITAS->CurrentValue;
		$this->AKTIVITAS->ViewCustomAttributes = "";

		// BERJALAN
		$this->BERJALAN->ViewValue = $this->BERJALAN->CurrentValue;
		$this->BERJALAN->ViewCustomAttributes = "";

		// SISTEM_INTE
		$this->SISTEM_INTE->ViewValue = $this->SISTEM_INTE->CurrentValue;
		$this->SISTEM_INTE->ViewCustomAttributes = "";

		// KENYAMANAN
		$this->KENYAMANAN->ViewValue = $this->KENYAMANAN->CurrentValue;
		$this->KENYAMANAN->ViewCustomAttributes = "";

		// KES_DIRI
		$this->KES_DIRI->ViewValue = $this->KES_DIRI->CurrentValue;
		$this->KES_DIRI->ViewCustomAttributes = "";

		// SOS_SUPORT
		$this->SOS_SUPORT->ViewValue = $this->SOS_SUPORT->CurrentValue;
		$this->SOS_SUPORT->ViewCustomAttributes = "";

		// ANSIETAS
		$this->ANSIETAS->ViewValue = $this->ANSIETAS->CurrentValue;
		$this->ANSIETAS->ViewCustomAttributes = "";

		// KEHILANGAN
		$this->KEHILANGAN->ViewValue = $this->KEHILANGAN->CurrentValue;
		$this->KEHILANGAN->ViewCustomAttributes = "";

		// STATUS_EMOSI
		$this->STATUS_EMOSI->ViewValue = $this->STATUS_EMOSI->CurrentValue;
		$this->STATUS_EMOSI->ViewCustomAttributes = "";

		// KONSEP_DIRI
		$this->KONSEP_DIRI->ViewValue = $this->KONSEP_DIRI->CurrentValue;
		$this->KONSEP_DIRI->ViewCustomAttributes = "";

		// RESPON_HILANG
		$this->RESPON_HILANG->ViewValue = $this->RESPON_HILANG->CurrentValue;
		$this->RESPON_HILANG->ViewCustomAttributes = "";

		// SUMBER_STRESS
		$this->SUMBER_STRESS->ViewValue = $this->SUMBER_STRESS->CurrentValue;
		$this->SUMBER_STRESS->ViewCustomAttributes = "";

		// BERARTI
		$this->BERARTI->ViewValue = $this->BERARTI->CurrentValue;
		$this->BERARTI->ViewCustomAttributes = "";

		// TERLIBAT
		$this->TERLIBAT->ViewValue = $this->TERLIBAT->CurrentValue;
		$this->TERLIBAT->ViewCustomAttributes = "";

		// HUBUNGAN
		$this->HUBUNGAN->ViewValue = $this->HUBUNGAN->CurrentValue;
		$this->HUBUNGAN->ViewCustomAttributes = "";

		// KOMUNIKASI
		$this->KOMUNIKASI->ViewValue = $this->KOMUNIKASI->CurrentValue;
		$this->KOMUNIKASI->ViewCustomAttributes = "";

		// KEPUTUSAN
		$this->KEPUTUSAN->ViewValue = $this->KEPUTUSAN->CurrentValue;
		$this->KEPUTUSAN->ViewCustomAttributes = "";

		// MENGASUH
		$this->MENGASUH->ViewValue = $this->MENGASUH->CurrentValue;
		$this->MENGASUH->ViewCustomAttributes = "";

		// DUKUNGAN
		$this->DUKUNGAN->ViewValue = $this->DUKUNGAN->CurrentValue;
		$this->DUKUNGAN->ViewCustomAttributes = "";

		// REAKSI
		$this->REAKSI->ViewValue = $this->REAKSI->CurrentValue;
		$this->REAKSI->ViewCustomAttributes = "";

		// BUDAYA
		$this->BUDAYA->ViewValue = $this->BUDAYA->CurrentValue;
		$this->BUDAYA->ViewCustomAttributes = "";

		// POLA_AKTIVITAS
		$this->POLA_AKTIVITAS->ViewValue = $this->POLA_AKTIVITAS->CurrentValue;
		$this->POLA_AKTIVITAS->ViewCustomAttributes = "";

		// POLA_ISTIRAHAT
		$this->POLA_ISTIRAHAT->ViewValue = $this->POLA_ISTIRAHAT->CurrentValue;
		$this->POLA_ISTIRAHAT->ViewCustomAttributes = "";

		// POLA_MAKAN
		$this->POLA_MAKAN->ViewValue = $this->POLA_MAKAN->CurrentValue;
		$this->POLA_MAKAN->ViewCustomAttributes = "";

		// PANTANGAN
		$this->PANTANGAN->ViewValue = $this->PANTANGAN->CurrentValue;
		$this->PANTANGAN->ViewCustomAttributes = "";

		// KEPERCAYAAN
		$this->KEPERCAYAAN->ViewValue = $this->KEPERCAYAAN->CurrentValue;
		$this->KEPERCAYAAN->ViewCustomAttributes = "";

		// PANTANGAN_HARI
		$this->PANTANGAN_HARI->ViewValue = $this->PANTANGAN_HARI->CurrentValue;
		$this->PANTANGAN_HARI->ViewCustomAttributes = "";

		// PANTANGAN_LAIN
		$this->PANTANGAN_LAIN->ViewValue = $this->PANTANGAN_LAIN->CurrentValue;
		$this->PANTANGAN_LAIN->ViewCustomAttributes = "";

		// ANJURAN
		$this->ANJURAN->ViewValue = $this->ANJURAN->CurrentValue;
		$this->ANJURAN->ViewCustomAttributes = "";

		// NILAI_KEYAKINAN
		$this->NILAI_KEYAKINAN->ViewValue = $this->NILAI_KEYAKINAN->CurrentValue;
		$this->NILAI_KEYAKINAN->ViewCustomAttributes = "";

		// KEGIATAN_IBADAH
		$this->KEGIATAN_IBADAH->ViewValue = $this->KEGIATAN_IBADAH->CurrentValue;
		$this->KEGIATAN_IBADAH->ViewCustomAttributes = "";

		// PENG_AGAMA
		$this->PENG_AGAMA->ViewValue = $this->PENG_AGAMA->CurrentValue;
		$this->PENG_AGAMA->ViewCustomAttributes = "";

		// SPIRIT
		$this->SPIRIT->ViewValue = $this->SPIRIT->CurrentValue;
		$this->SPIRIT->ViewCustomAttributes = "";

		// BANTUAN
		$this->BANTUAN->ViewValue = $this->BANTUAN->CurrentValue;
		$this->BANTUAN->ViewCustomAttributes = "";

		// PAHAM_PENYAKIT
		$this->PAHAM_PENYAKIT->ViewValue = $this->PAHAM_PENYAKIT->CurrentValue;
		$this->PAHAM_PENYAKIT->ViewCustomAttributes = "";

		// PAHAM_OBAT
		$this->PAHAM_OBAT->ViewValue = $this->PAHAM_OBAT->CurrentValue;
		$this->PAHAM_OBAT->ViewCustomAttributes = "";

		// PAHAM_NUTRISI
		$this->PAHAM_NUTRISI->ViewValue = $this->PAHAM_NUTRISI->CurrentValue;
		$this->PAHAM_NUTRISI->ViewCustomAttributes = "";

		// PAHAM_RAWAT
		$this->PAHAM_RAWAT->ViewValue = $this->PAHAM_RAWAT->CurrentValue;
		$this->PAHAM_RAWAT->ViewCustomAttributes = "";

		// HAMBATAN_EDUKASI
		$this->HAMBATAN_EDUKASI->ViewValue = $this->HAMBATAN_EDUKASI->CurrentValue;
		$this->HAMBATAN_EDUKASI->ViewCustomAttributes = "";

		// FREK_MAKAN
		$this->FREK_MAKAN->ViewValue = $this->FREK_MAKAN->CurrentValue;
		$this->FREK_MAKAN->ViewCustomAttributes = "";

		// JUM_MAKAN
		$this->JUM_MAKAN->ViewValue = $this->JUM_MAKAN->CurrentValue;
		$this->JUM_MAKAN->ViewCustomAttributes = "";

		// JEN_MAKAN
		$this->JEN_MAKAN->ViewValue = $this->JEN_MAKAN->CurrentValue;
		$this->JEN_MAKAN->ViewCustomAttributes = "";

		// KOM_MAKAN
		$this->KOM_MAKAN->ViewValue = $this->KOM_MAKAN->CurrentValue;
		$this->KOM_MAKAN->ViewCustomAttributes = "";

		// DIET
		$this->DIET->ViewValue = $this->DIET->CurrentValue;
		$this->DIET->ViewCustomAttributes = "";

		// CARA_MAKAN
		$this->CARA_MAKAN->ViewValue = $this->CARA_MAKAN->CurrentValue;
		$this->CARA_MAKAN->ViewCustomAttributes = "";

		// GANGGUAN
		$this->GANGGUAN->ViewValue = $this->GANGGUAN->CurrentValue;
		$this->GANGGUAN->ViewCustomAttributes = "";

		// FREK_MINUM
		$this->FREK_MINUM->ViewValue = $this->FREK_MINUM->CurrentValue;
		$this->FREK_MINUM->ViewCustomAttributes = "";

		// JUM_MINUM
		$this->JUM_MINUM->ViewValue = $this->JUM_MINUM->CurrentValue;
		$this->JUM_MINUM->ViewCustomAttributes = "";

		// JEN_MINUM
		$this->JEN_MINUM->ViewValue = $this->JEN_MINUM->CurrentValue;
		$this->JEN_MINUM->ViewCustomAttributes = "";

		// GANG_MINUM
		$this->GANG_MINUM->ViewValue = $this->GANG_MINUM->CurrentValue;
		$this->GANG_MINUM->ViewCustomAttributes = "";

		// FREK_BAK
		$this->FREK_BAK->ViewValue = $this->FREK_BAK->CurrentValue;
		$this->FREK_BAK->ViewCustomAttributes = "";

		// WARNA_BAK
		$this->WARNA_BAK->ViewValue = $this->WARNA_BAK->CurrentValue;
		$this->WARNA_BAK->ViewCustomAttributes = "";

		// JMLH_BAK
		$this->JMLH_BAK->ViewValue = $this->JMLH_BAK->CurrentValue;
		$this->JMLH_BAK->ViewCustomAttributes = "";

		// PENG_KAT_BAK
		$this->PENG_KAT_BAK->ViewValue = $this->PENG_KAT_BAK->CurrentValue;
		$this->PENG_KAT_BAK->ViewCustomAttributes = "";

		// KEM_HAN_BAK
		$this->KEM_HAN_BAK->ViewValue = $this->KEM_HAN_BAK->CurrentValue;
		$this->KEM_HAN_BAK->ViewCustomAttributes = "";

		// INKONT_BAK
		$this->INKONT_BAK->ViewValue = $this->INKONT_BAK->CurrentValue;
		$this->INKONT_BAK->ViewCustomAttributes = "";

		// DIURESIS_BAK
		$this->DIURESIS_BAK->ViewValue = $this->DIURESIS_BAK->CurrentValue;
		$this->DIURESIS_BAK->ViewCustomAttributes = "";

		// FREK_BAB
		$this->FREK_BAB->ViewValue = $this->FREK_BAB->CurrentValue;
		$this->FREK_BAB->ViewCustomAttributes = "";

		// WARNA_BAB
		$this->WARNA_BAB->ViewValue = $this->WARNA_BAB->CurrentValue;
		$this->WARNA_BAB->ViewCustomAttributes = "";

		// KONSIST_BAB
		$this->KONSIST_BAB->ViewValue = $this->KONSIST_BAB->CurrentValue;
		$this->KONSIST_BAB->ViewCustomAttributes = "";

		// GANG_BAB
		$this->GANG_BAB->ViewValue = $this->GANG_BAB->CurrentValue;
		$this->GANG_BAB->ViewCustomAttributes = "";

		// STOMA_BAB
		$this->STOMA_BAB->ViewValue = $this->STOMA_BAB->CurrentValue;
		$this->STOMA_BAB->ViewCustomAttributes = "";

		// PENG_OBAT_BAB
		$this->PENG_OBAT_BAB->ViewValue = $this->PENG_OBAT_BAB->CurrentValue;
		$this->PENG_OBAT_BAB->ViewCustomAttributes = "";

		// IST_SIANG
		$this->IST_SIANG->ViewValue = $this->IST_SIANG->CurrentValue;
		$this->IST_SIANG->ViewCustomAttributes = "";

		// IST_MALAM
		$this->IST_MALAM->ViewValue = $this->IST_MALAM->CurrentValue;
		$this->IST_MALAM->ViewCustomAttributes = "";

		// IST_CAHAYA
		$this->IST_CAHAYA->ViewValue = $this->IST_CAHAYA->CurrentValue;
		$this->IST_CAHAYA->ViewCustomAttributes = "";

		// IST_POSISI
		$this->IST_POSISI->ViewValue = $this->IST_POSISI->CurrentValue;
		$this->IST_POSISI->ViewCustomAttributes = "";

		// IST_LING
		$this->IST_LING->ViewValue = $this->IST_LING->CurrentValue;
		$this->IST_LING->ViewCustomAttributes = "";

		// IST_GANG_TIDUR
		$this->IST_GANG_TIDUR->ViewValue = $this->IST_GANG_TIDUR->CurrentValue;
		$this->IST_GANG_TIDUR->ViewCustomAttributes = "";

		// PENG_OBAT_IST
		$this->PENG_OBAT_IST->ViewValue = $this->PENG_OBAT_IST->CurrentValue;
		$this->PENG_OBAT_IST->ViewCustomAttributes = "";

		// FREK_MAND
		$this->FREK_MAND->ViewValue = $this->FREK_MAND->CurrentValue;
		$this->FREK_MAND->ViewCustomAttributes = "";

		// CUC_RAMB_MAND
		$this->CUC_RAMB_MAND->ViewValue = $this->CUC_RAMB_MAND->CurrentValue;
		$this->CUC_RAMB_MAND->ViewCustomAttributes = "";

		// SIH_GIGI_MAND
		$this->SIH_GIGI_MAND->ViewValue = $this->SIH_GIGI_MAND->CurrentValue;
		$this->SIH_GIGI_MAND->ViewCustomAttributes = "";

		// BANT_MAND
		$this->BANT_MAND->ViewValue = $this->BANT_MAND->CurrentValue;
		$this->BANT_MAND->ViewCustomAttributes = "";

		// GANT_PAKAI
		$this->GANT_PAKAI->ViewValue = $this->GANT_PAKAI->CurrentValue;
		$this->GANT_PAKAI->ViewCustomAttributes = "";

		// PAK_CUCI
		$this->PAK_CUCI->ViewValue = $this->PAK_CUCI->CurrentValue;
		$this->PAK_CUCI->ViewCustomAttributes = "";

		// PAK_BANT
		$this->PAK_BANT->ViewValue = $this->PAK_BANT->CurrentValue;
		$this->PAK_BANT->ViewCustomAttributes = "";

		// ALT_BANT
		$this->ALT_BANT->ViewValue = $this->ALT_BANT->CurrentValue;
		$this->ALT_BANT->ViewCustomAttributes = "";

		// KEMP_MUND
		$this->KEMP_MUND->ViewValue = $this->KEMP_MUND->CurrentValue;
		$this->KEMP_MUND->ViewCustomAttributes = "";

		// BIL_PUT
		$this->BIL_PUT->ViewValue = $this->BIL_PUT->CurrentValue;
		$this->BIL_PUT->ViewCustomAttributes = "";

		// ADAPTIF
		$this->ADAPTIF->ViewValue = $this->ADAPTIF->CurrentValue;
		$this->ADAPTIF->ViewCustomAttributes = "";

		// MALADAPTIF
		$this->MALADAPTIF->ViewValue = $this->MALADAPTIF->CurrentValue;
		$this->MALADAPTIF->ViewCustomAttributes = "";

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

		// obat2
		$this->obat2->ViewValue = $this->obat2->CurrentValue;
		$this->obat2->ViewCustomAttributes = "";

		// PERBANDINGAN_BB
		$this->PERBANDINGAN_BB->ViewValue = $this->PERBANDINGAN_BB->CurrentValue;
		$this->PERBANDINGAN_BB->ViewCustomAttributes = "";

		// KONTINENSIA
		$this->KONTINENSIA->ViewValue = $this->KONTINENSIA->CurrentValue;
		$this->KONTINENSIA->ViewCustomAttributes = "";

		// JENIS_KULIT1
		$this->JENIS_KULIT1->ViewValue = $this->JENIS_KULIT1->CurrentValue;
		$this->JENIS_KULIT1->ViewCustomAttributes = "";

		// MOBILITAS
		$this->MOBILITAS->ViewValue = $this->MOBILITAS->CurrentValue;
		$this->MOBILITAS->ViewCustomAttributes = "";

		// JK
		$this->JK->ViewValue = $this->JK->CurrentValue;
		$this->JK->ViewCustomAttributes = "";

		// UMUR
		$this->UMUR->ViewValue = $this->UMUR->CurrentValue;
		$this->UMUR->ViewCustomAttributes = "";

		// NAFSU_MAKAN
		$this->NAFSU_MAKAN->ViewValue = $this->NAFSU_MAKAN->CurrentValue;
		$this->NAFSU_MAKAN->ViewCustomAttributes = "";

		// OBAT1
		$this->OBAT1->ViewValue = $this->OBAT1->CurrentValue;
		$this->OBAT1->ViewCustomAttributes = "";

		// MALNUTRISI
		$this->MALNUTRISI->ViewValue = $this->MALNUTRISI->CurrentValue;
		$this->MALNUTRISI->ViewCustomAttributes = "";

		// MOTORIK1
		$this->MOTORIK1->ViewValue = $this->MOTORIK1->CurrentValue;
		$this->MOTORIK1->ViewCustomAttributes = "";

		// SPINAL
		$this->SPINAL->ViewValue = $this->SPINAL->CurrentValue;
		$this->SPINAL->ViewCustomAttributes = "";

		// MEJA_OPERASI
		$this->MEJA_OPERASI->ViewValue = $this->MEJA_OPERASI->CurrentValue;
		$this->MEJA_OPERASI->ViewCustomAttributes = "";

		// RIWAYAT_JATUH
		$this->RIWAYAT_JATUH->ViewValue = $this->RIWAYAT_JATUH->CurrentValue;
		$this->RIWAYAT_JATUH->ViewCustomAttributes = "";

		// DIAGNOSIS_SEKUNDER
		$this->DIAGNOSIS_SEKUNDER->ViewValue = $this->DIAGNOSIS_SEKUNDER->CurrentValue;
		$this->DIAGNOSIS_SEKUNDER->ViewCustomAttributes = "";

		// ALAT_BANTU
		$this->ALAT_BANTU->ViewValue = $this->ALAT_BANTU->CurrentValue;
		$this->ALAT_BANTU->ViewCustomAttributes = "";

		// HEPARIN
		$this->HEPARIN->ViewValue = $this->HEPARIN->CurrentValue;
		$this->HEPARIN->ViewCustomAttributes = "";

		// GAYA_BERJALAN
		$this->GAYA_BERJALAN->ViewValue = $this->GAYA_BERJALAN->CurrentValue;
		$this->GAYA_BERJALAN->ViewCustomAttributes = "";

		// KESADARAN1
		$this->KESADARAN1->ViewValue = $this->KESADARAN1->CurrentValue;
		$this->KESADARAN1->ViewCustomAttributes = "";

		// NOMR_LAMA
		$this->NOMR_LAMA->ViewValue = $this->NOMR_LAMA->CurrentValue;
		$this->NOMR_LAMA->ViewCustomAttributes = "";

		// NO_KARTU
		$this->NO_KARTU->ViewValue = $this->NO_KARTU->CurrentValue;
		$this->NO_KARTU->ViewCustomAttributes = "";

		// JNS_PASIEN
		if (strval($this->JNS_PASIEN->CurrentValue) <> "") {
			$sFilterWrk = "`jenis_pasien`" . ew_SearchString("=", $this->JNS_PASIEN->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `jenis_pasien`, `nama_jenis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `l_jenis_pasien`";
		$sWhereWrk = "";
		$this->JNS_PASIEN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->JNS_PASIEN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->JNS_PASIEN->ViewValue = $this->JNS_PASIEN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->JNS_PASIEN->ViewValue = $this->JNS_PASIEN->CurrentValue;
			}
		} else {
			$this->JNS_PASIEN->ViewValue = NULL;
		}
		$this->JNS_PASIEN->ViewCustomAttributes = "";

		// nama_ayah
		$this->nama_ayah->ViewValue = $this->nama_ayah->CurrentValue;
		$this->nama_ayah->ViewCustomAttributes = "";

		// nama_ibu
		$this->nama_ibu->ViewValue = $this->nama_ibu->CurrentValue;
		$this->nama_ibu->ViewCustomAttributes = "";

		// nama_suami
		$this->nama_suami->ViewValue = $this->nama_suami->CurrentValue;
		$this->nama_suami->ViewCustomAttributes = "";

		// nama_istri
		$this->nama_istri->ViewValue = $this->nama_istri->CurrentValue;
		$this->nama_istri->ViewCustomAttributes = "";

		// KD_ETNIS
		if (strval($this->KD_ETNIS->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->KD_ETNIS->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `nama_etnis` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_etnis`";
		$sWhereWrk = "";
		$this->KD_ETNIS->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KD_ETNIS, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KD_ETNIS->ViewValue = $this->KD_ETNIS->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KD_ETNIS->ViewValue = $this->KD_ETNIS->CurrentValue;
			}
		} else {
			$this->KD_ETNIS->ViewValue = NULL;
		}
		$this->KD_ETNIS->ViewCustomAttributes = "";

		// KD_BHS_HARIAN
		if (strval($this->KD_BHS_HARIAN->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->KD_BHS_HARIAN->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `bahasa_harian` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `m_bahasa_harian`";
		$sWhereWrk = "";
		$this->KD_BHS_HARIAN->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->KD_BHS_HARIAN, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->KD_BHS_HARIAN->ViewValue = $this->KD_BHS_HARIAN->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->KD_BHS_HARIAN->ViewValue = $this->KD_BHS_HARIAN->CurrentValue;
			}
		} else {
			$this->KD_BHS_HARIAN->ViewValue = NULL;
		}
		$this->KD_BHS_HARIAN->ViewCustomAttributes = "";

		// id
		$this->id->LinkCustomAttributes = "";
		$this->id->HrefValue = "";
		$this->id->TooltipValue = "";

		// NOMR
		$this->NOMR->LinkCustomAttributes = "";
		$this->NOMR->HrefValue = "";
		$this->NOMR->TooltipValue = "";

		// TITLE
		$this->TITLE->LinkCustomAttributes = "";
		$this->TITLE->HrefValue = "";
		$this->TITLE->TooltipValue = "";

		// NAMA
		$this->NAMA->LinkCustomAttributes = "";
		$this->NAMA->HrefValue = "";
		$this->NAMA->TooltipValue = "";

		// IBUKANDUNG
		$this->IBUKANDUNG->LinkCustomAttributes = "";
		$this->IBUKANDUNG->HrefValue = "";
		$this->IBUKANDUNG->TooltipValue = "";

		// TEMPAT
		$this->TEMPAT->LinkCustomAttributes = "";
		$this->TEMPAT->HrefValue = "";
		$this->TEMPAT->TooltipValue = "";

		// TGLLAHIR
		$this->TGLLAHIR->LinkCustomAttributes = "";
		$this->TGLLAHIR->HrefValue = "";
		$this->TGLLAHIR->TooltipValue = "";

		// JENISKELAMIN
		$this->JENISKELAMIN->LinkCustomAttributes = "";
		$this->JENISKELAMIN->HrefValue = "";
		$this->JENISKELAMIN->TooltipValue = "";

		// ALAMAT
		$this->ALAMAT->LinkCustomAttributes = "";
		$this->ALAMAT->HrefValue = "";
		$this->ALAMAT->TooltipValue = "";

		// KDPROVINSI
		$this->KDPROVINSI->LinkCustomAttributes = "";
		$this->KDPROVINSI->HrefValue = "";
		$this->KDPROVINSI->TooltipValue = "";

		// KOTA
		$this->KOTA->LinkCustomAttributes = "";
		$this->KOTA->HrefValue = "";
		$this->KOTA->TooltipValue = "";

		// KDKECAMATAN
		$this->KDKECAMATAN->LinkCustomAttributes = "";
		$this->KDKECAMATAN->HrefValue = "";
		$this->KDKECAMATAN->TooltipValue = "";

		// KELURAHAN
		$this->KELURAHAN->LinkCustomAttributes = "";
		$this->KELURAHAN->HrefValue = "";
		$this->KELURAHAN->TooltipValue = "";

		// NOTELP
		$this->NOTELP->LinkCustomAttributes = "";
		$this->NOTELP->HrefValue = "";
		$this->NOTELP->TooltipValue = "";

		// NOKTP
		$this->NOKTP->LinkCustomAttributes = "";
		$this->NOKTP->HrefValue = "";
		$this->NOKTP->TooltipValue = "";

		// SUAMI_ORTU
		$this->SUAMI_ORTU->LinkCustomAttributes = "";
		$this->SUAMI_ORTU->HrefValue = "";
		$this->SUAMI_ORTU->TooltipValue = "";

		// PEKERJAAN
		$this->PEKERJAAN->LinkCustomAttributes = "";
		$this->PEKERJAAN->HrefValue = "";
		$this->PEKERJAAN->TooltipValue = "";

		// STATUS
		$this->STATUS->LinkCustomAttributes = "";
		$this->STATUS->HrefValue = "";
		$this->STATUS->TooltipValue = "";

		// AGAMA
		$this->AGAMA->LinkCustomAttributes = "";
		$this->AGAMA->HrefValue = "";
		$this->AGAMA->TooltipValue = "";

		// PENDIDIKAN
		$this->PENDIDIKAN->LinkCustomAttributes = "";
		$this->PENDIDIKAN->HrefValue = "";
		$this->PENDIDIKAN->TooltipValue = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->LinkCustomAttributes = "";
		$this->KDCARABAYAR->HrefValue = "";
		$this->KDCARABAYAR->TooltipValue = "";

		// NIP
		$this->NIP->LinkCustomAttributes = "";
		$this->NIP->HrefValue = "";
		$this->NIP->TooltipValue = "";

		// TGLDAFTAR
		$this->TGLDAFTAR->LinkCustomAttributes = "";
		$this->TGLDAFTAR->HrefValue = "";
		$this->TGLDAFTAR->TooltipValue = "";

		// ALAMAT_KTP
		$this->ALAMAT_KTP->LinkCustomAttributes = "";
		$this->ALAMAT_KTP->HrefValue = "";
		$this->ALAMAT_KTP->TooltipValue = "";

		// PARENT_NOMR
		$this->PARENT_NOMR->LinkCustomAttributes = "";
		$this->PARENT_NOMR->HrefValue = "";
		$this->PARENT_NOMR->TooltipValue = "";

		// NAMA_OBAT
		$this->NAMA_OBAT->LinkCustomAttributes = "";
		$this->NAMA_OBAT->HrefValue = "";
		$this->NAMA_OBAT->TooltipValue = "";

		// DOSIS
		$this->DOSIS->LinkCustomAttributes = "";
		$this->DOSIS->HrefValue = "";
		$this->DOSIS->TooltipValue = "";

		// CARA_PEMBERIAN
		$this->CARA_PEMBERIAN->LinkCustomAttributes = "";
		$this->CARA_PEMBERIAN->HrefValue = "";
		$this->CARA_PEMBERIAN->TooltipValue = "";

		// FREKUENSI
		$this->FREKUENSI->LinkCustomAttributes = "";
		$this->FREKUENSI->HrefValue = "";
		$this->FREKUENSI->TooltipValue = "";

		// WAKTU_TGL
		$this->WAKTU_TGL->LinkCustomAttributes = "";
		$this->WAKTU_TGL->HrefValue = "";
		$this->WAKTU_TGL->TooltipValue = "";

		// LAMA_WAKTU
		$this->LAMA_WAKTU->LinkCustomAttributes = "";
		$this->LAMA_WAKTU->HrefValue = "";
		$this->LAMA_WAKTU->TooltipValue = "";

		// ALERGI_OBAT
		$this->ALERGI_OBAT->LinkCustomAttributes = "";
		$this->ALERGI_OBAT->HrefValue = "";
		$this->ALERGI_OBAT->TooltipValue = "";

		// REAKSI_ALERGI
		$this->REAKSI_ALERGI->LinkCustomAttributes = "";
		$this->REAKSI_ALERGI->HrefValue = "";
		$this->REAKSI_ALERGI->TooltipValue = "";

		// RIWAYAT_KES
		$this->RIWAYAT_KES->LinkCustomAttributes = "";
		$this->RIWAYAT_KES->HrefValue = "";
		$this->RIWAYAT_KES->TooltipValue = "";

		// BB_LAHIR
		$this->BB_LAHIR->LinkCustomAttributes = "";
		$this->BB_LAHIR->HrefValue = "";
		$this->BB_LAHIR->TooltipValue = "";

		// BB_SEKARANG
		$this->BB_SEKARANG->LinkCustomAttributes = "";
		$this->BB_SEKARANG->HrefValue = "";
		$this->BB_SEKARANG->TooltipValue = "";

		// FISIK_FONTANEL
		$this->FISIK_FONTANEL->LinkCustomAttributes = "";
		$this->FISIK_FONTANEL->HrefValue = "";
		$this->FISIK_FONTANEL->TooltipValue = "";

		// FISIK_REFLEKS
		$this->FISIK_REFLEKS->LinkCustomAttributes = "";
		$this->FISIK_REFLEKS->HrefValue = "";
		$this->FISIK_REFLEKS->TooltipValue = "";

		// FISIK_SENSASI
		$this->FISIK_SENSASI->LinkCustomAttributes = "";
		$this->FISIK_SENSASI->HrefValue = "";
		$this->FISIK_SENSASI->TooltipValue = "";

		// MOTORIK_KASAR
		$this->MOTORIK_KASAR->LinkCustomAttributes = "";
		$this->MOTORIK_KASAR->HrefValue = "";
		$this->MOTORIK_KASAR->TooltipValue = "";

		// MOTORIK_HALUS
		$this->MOTORIK_HALUS->LinkCustomAttributes = "";
		$this->MOTORIK_HALUS->HrefValue = "";
		$this->MOTORIK_HALUS->TooltipValue = "";

		// MAMPU_BICARA
		$this->MAMPU_BICARA->LinkCustomAttributes = "";
		$this->MAMPU_BICARA->HrefValue = "";
		$this->MAMPU_BICARA->TooltipValue = "";

		// MAMPU_SOSIALISASI
		$this->MAMPU_SOSIALISASI->LinkCustomAttributes = "";
		$this->MAMPU_SOSIALISASI->HrefValue = "";
		$this->MAMPU_SOSIALISASI->TooltipValue = "";

		// BCG
		$this->BCG->LinkCustomAttributes = "";
		$this->BCG->HrefValue = "";
		$this->BCG->TooltipValue = "";

		// POLIO
		$this->POLIO->LinkCustomAttributes = "";
		$this->POLIO->HrefValue = "";
		$this->POLIO->TooltipValue = "";

		// DPT
		$this->DPT->LinkCustomAttributes = "";
		$this->DPT->HrefValue = "";
		$this->DPT->TooltipValue = "";

		// CAMPAK
		$this->CAMPAK->LinkCustomAttributes = "";
		$this->CAMPAK->HrefValue = "";
		$this->CAMPAK->TooltipValue = "";

		// HEPATITIS_B
		$this->HEPATITIS_B->LinkCustomAttributes = "";
		$this->HEPATITIS_B->HrefValue = "";
		$this->HEPATITIS_B->TooltipValue = "";

		// TD
		$this->TD->LinkCustomAttributes = "";
		$this->TD->HrefValue = "";
		$this->TD->TooltipValue = "";

		// SUHU
		$this->SUHU->LinkCustomAttributes = "";
		$this->SUHU->HrefValue = "";
		$this->SUHU->TooltipValue = "";

		// RR
		$this->RR->LinkCustomAttributes = "";
		$this->RR->HrefValue = "";
		$this->RR->TooltipValue = "";

		// NADI
		$this->NADI->LinkCustomAttributes = "";
		$this->NADI->HrefValue = "";
		$this->NADI->TooltipValue = "";

		// BB
		$this->BB->LinkCustomAttributes = "";
		$this->BB->HrefValue = "";
		$this->BB->TooltipValue = "";

		// TB
		$this->TB->LinkCustomAttributes = "";
		$this->TB->HrefValue = "";
		$this->TB->TooltipValue = "";

		// EYE
		$this->EYE->LinkCustomAttributes = "";
		$this->EYE->HrefValue = "";
		$this->EYE->TooltipValue = "";

		// MOTORIK
		$this->MOTORIK->LinkCustomAttributes = "";
		$this->MOTORIK->HrefValue = "";
		$this->MOTORIK->TooltipValue = "";

		// VERBAL
		$this->VERBAL->LinkCustomAttributes = "";
		$this->VERBAL->HrefValue = "";
		$this->VERBAL->TooltipValue = "";

		// TOTAL_GCS
		$this->TOTAL_GCS->LinkCustomAttributes = "";
		$this->TOTAL_GCS->HrefValue = "";
		$this->TOTAL_GCS->TooltipValue = "";

		// REAKSI_PUPIL
		$this->REAKSI_PUPIL->LinkCustomAttributes = "";
		$this->REAKSI_PUPIL->HrefValue = "";
		$this->REAKSI_PUPIL->TooltipValue = "";

		// KESADARAN
		$this->KESADARAN->LinkCustomAttributes = "";
		$this->KESADARAN->HrefValue = "";
		$this->KESADARAN->TooltipValue = "";

		// KEPALA
		$this->KEPALA->LinkCustomAttributes = "";
		$this->KEPALA->HrefValue = "";
		$this->KEPALA->TooltipValue = "";

		// RAMBUT
		$this->RAMBUT->LinkCustomAttributes = "";
		$this->RAMBUT->HrefValue = "";
		$this->RAMBUT->TooltipValue = "";

		// MUKA
		$this->MUKA->LinkCustomAttributes = "";
		$this->MUKA->HrefValue = "";
		$this->MUKA->TooltipValue = "";

		// MATA
		$this->MATA->LinkCustomAttributes = "";
		$this->MATA->HrefValue = "";
		$this->MATA->TooltipValue = "";

		// GANG_LIHAT
		$this->GANG_LIHAT->LinkCustomAttributes = "";
		$this->GANG_LIHAT->HrefValue = "";
		$this->GANG_LIHAT->TooltipValue = "";

		// ALATBANTU_LIHAT
		$this->ALATBANTU_LIHAT->LinkCustomAttributes = "";
		$this->ALATBANTU_LIHAT->HrefValue = "";
		$this->ALATBANTU_LIHAT->TooltipValue = "";

		// BENTUK
		$this->BENTUK->LinkCustomAttributes = "";
		$this->BENTUK->HrefValue = "";
		$this->BENTUK->TooltipValue = "";

		// PENDENGARAN
		$this->PENDENGARAN->LinkCustomAttributes = "";
		$this->PENDENGARAN->HrefValue = "";
		$this->PENDENGARAN->TooltipValue = "";

		// LUB_TELINGA
		$this->LUB_TELINGA->LinkCustomAttributes = "";
		$this->LUB_TELINGA->HrefValue = "";
		$this->LUB_TELINGA->TooltipValue = "";

		// BENTUK_HIDUNG
		$this->BENTUK_HIDUNG->LinkCustomAttributes = "";
		$this->BENTUK_HIDUNG->HrefValue = "";
		$this->BENTUK_HIDUNG->TooltipValue = "";

		// MEMBRAN_MUK
		$this->MEMBRAN_MUK->LinkCustomAttributes = "";
		$this->MEMBRAN_MUK->HrefValue = "";
		$this->MEMBRAN_MUK->TooltipValue = "";

		// MAMPU_HIDU
		$this->MAMPU_HIDU->LinkCustomAttributes = "";
		$this->MAMPU_HIDU->HrefValue = "";
		$this->MAMPU_HIDU->TooltipValue = "";

		// ALAT_HIDUNG
		$this->ALAT_HIDUNG->LinkCustomAttributes = "";
		$this->ALAT_HIDUNG->HrefValue = "";
		$this->ALAT_HIDUNG->TooltipValue = "";

		// RONGGA_MULUT
		$this->RONGGA_MULUT->LinkCustomAttributes = "";
		$this->RONGGA_MULUT->HrefValue = "";
		$this->RONGGA_MULUT->TooltipValue = "";

		// WARNA_MEMBRAN
		$this->WARNA_MEMBRAN->LinkCustomAttributes = "";
		$this->WARNA_MEMBRAN->HrefValue = "";
		$this->WARNA_MEMBRAN->TooltipValue = "";

		// LEMBAB
		$this->LEMBAB->LinkCustomAttributes = "";
		$this->LEMBAB->HrefValue = "";
		$this->LEMBAB->TooltipValue = "";

		// STOMATITIS
		$this->STOMATITIS->LinkCustomAttributes = "";
		$this->STOMATITIS->HrefValue = "";
		$this->STOMATITIS->TooltipValue = "";

		// LIDAH
		$this->LIDAH->LinkCustomAttributes = "";
		$this->LIDAH->HrefValue = "";
		$this->LIDAH->TooltipValue = "";

		// GIGI
		$this->GIGI->LinkCustomAttributes = "";
		$this->GIGI->HrefValue = "";
		$this->GIGI->TooltipValue = "";

		// TONSIL
		$this->TONSIL->LinkCustomAttributes = "";
		$this->TONSIL->HrefValue = "";
		$this->TONSIL->TooltipValue = "";

		// KELAINAN
		$this->KELAINAN->LinkCustomAttributes = "";
		$this->KELAINAN->HrefValue = "";
		$this->KELAINAN->TooltipValue = "";

		// PERGERAKAN
		$this->PERGERAKAN->LinkCustomAttributes = "";
		$this->PERGERAKAN->HrefValue = "";
		$this->PERGERAKAN->TooltipValue = "";

		// KEL_TIROID
		$this->KEL_TIROID->LinkCustomAttributes = "";
		$this->KEL_TIROID->HrefValue = "";
		$this->KEL_TIROID->TooltipValue = "";

		// KEL_GETAH
		$this->KEL_GETAH->LinkCustomAttributes = "";
		$this->KEL_GETAH->HrefValue = "";
		$this->KEL_GETAH->TooltipValue = "";

		// TEKANAN_VENA
		$this->TEKANAN_VENA->LinkCustomAttributes = "";
		$this->TEKANAN_VENA->HrefValue = "";
		$this->TEKANAN_VENA->TooltipValue = "";

		// REF_MENELAN
		$this->REF_MENELAN->LinkCustomAttributes = "";
		$this->REF_MENELAN->HrefValue = "";
		$this->REF_MENELAN->TooltipValue = "";

		// NYERI
		$this->NYERI->LinkCustomAttributes = "";
		$this->NYERI->HrefValue = "";
		$this->NYERI->TooltipValue = "";

		// KREPITASI
		$this->KREPITASI->LinkCustomAttributes = "";
		$this->KREPITASI->HrefValue = "";
		$this->KREPITASI->TooltipValue = "";

		// KEL_LAIN
		$this->KEL_LAIN->LinkCustomAttributes = "";
		$this->KEL_LAIN->HrefValue = "";
		$this->KEL_LAIN->TooltipValue = "";

		// BENTUK_DADA
		$this->BENTUK_DADA->LinkCustomAttributes = "";
		$this->BENTUK_DADA->HrefValue = "";
		$this->BENTUK_DADA->TooltipValue = "";

		// POLA_NAPAS
		$this->POLA_NAPAS->LinkCustomAttributes = "";
		$this->POLA_NAPAS->HrefValue = "";
		$this->POLA_NAPAS->TooltipValue = "";

		// BENTUK_THORAKS
		$this->BENTUK_THORAKS->LinkCustomAttributes = "";
		$this->BENTUK_THORAKS->HrefValue = "";
		$this->BENTUK_THORAKS->TooltipValue = "";

		// PAL_KREP
		$this->PAL_KREP->LinkCustomAttributes = "";
		$this->PAL_KREP->HrefValue = "";
		$this->PAL_KREP->TooltipValue = "";

		// BENJOLAN
		$this->BENJOLAN->LinkCustomAttributes = "";
		$this->BENJOLAN->HrefValue = "";
		$this->BENJOLAN->TooltipValue = "";

		// PAL_NYERI
		$this->PAL_NYERI->LinkCustomAttributes = "";
		$this->PAL_NYERI->HrefValue = "";
		$this->PAL_NYERI->TooltipValue = "";

		// PERKUSI
		$this->PERKUSI->LinkCustomAttributes = "";
		$this->PERKUSI->HrefValue = "";
		$this->PERKUSI->TooltipValue = "";

		// PARU
		$this->PARU->LinkCustomAttributes = "";
		$this->PARU->HrefValue = "";
		$this->PARU->TooltipValue = "";

		// JANTUNG
		$this->JANTUNG->LinkCustomAttributes = "";
		$this->JANTUNG->HrefValue = "";
		$this->JANTUNG->TooltipValue = "";

		// SUARA_JANTUNG
		$this->SUARA_JANTUNG->LinkCustomAttributes = "";
		$this->SUARA_JANTUNG->HrefValue = "";
		$this->SUARA_JANTUNG->TooltipValue = "";

		// ALATBANTU_JAN
		$this->ALATBANTU_JAN->LinkCustomAttributes = "";
		$this->ALATBANTU_JAN->HrefValue = "";
		$this->ALATBANTU_JAN->TooltipValue = "";

		// BENTUK_ABDOMEN
		$this->BENTUK_ABDOMEN->LinkCustomAttributes = "";
		$this->BENTUK_ABDOMEN->HrefValue = "";
		$this->BENTUK_ABDOMEN->TooltipValue = "";

		// AUSKULTASI
		$this->AUSKULTASI->LinkCustomAttributes = "";
		$this->AUSKULTASI->HrefValue = "";
		$this->AUSKULTASI->TooltipValue = "";

		// NYERI_PASI
		$this->NYERI_PASI->LinkCustomAttributes = "";
		$this->NYERI_PASI->HrefValue = "";
		$this->NYERI_PASI->TooltipValue = "";

		// PEM_KELENJAR
		$this->PEM_KELENJAR->LinkCustomAttributes = "";
		$this->PEM_KELENJAR->HrefValue = "";
		$this->PEM_KELENJAR->TooltipValue = "";

		// PERKUSI_AUS
		$this->PERKUSI_AUS->LinkCustomAttributes = "";
		$this->PERKUSI_AUS->HrefValue = "";
		$this->PERKUSI_AUS->TooltipValue = "";

		// VAGINA
		$this->VAGINA->LinkCustomAttributes = "";
		$this->VAGINA->HrefValue = "";
		$this->VAGINA->TooltipValue = "";

		// MENSTRUASI
		$this->MENSTRUASI->LinkCustomAttributes = "";
		$this->MENSTRUASI->HrefValue = "";
		$this->MENSTRUASI->TooltipValue = "";

		// KATETER
		$this->KATETER->LinkCustomAttributes = "";
		$this->KATETER->HrefValue = "";
		$this->KATETER->TooltipValue = "";

		// LABIA_PROM
		$this->LABIA_PROM->LinkCustomAttributes = "";
		$this->LABIA_PROM->HrefValue = "";
		$this->LABIA_PROM->TooltipValue = "";

		// HAMIL
		$this->HAMIL->LinkCustomAttributes = "";
		$this->HAMIL->HrefValue = "";
		$this->HAMIL->TooltipValue = "";

		// TGL_HAID
		$this->TGL_HAID->LinkCustomAttributes = "";
		$this->TGL_HAID->HrefValue = "";
		$this->TGL_HAID->TooltipValue = "";

		// PERIKSA_CERVIX
		$this->PERIKSA_CERVIX->LinkCustomAttributes = "";
		$this->PERIKSA_CERVIX->HrefValue = "";
		$this->PERIKSA_CERVIX->TooltipValue = "";

		// BENTUK_PAYUDARA
		$this->BENTUK_PAYUDARA->LinkCustomAttributes = "";
		$this->BENTUK_PAYUDARA->HrefValue = "";
		$this->BENTUK_PAYUDARA->TooltipValue = "";

		// KENYAL
		$this->KENYAL->LinkCustomAttributes = "";
		$this->KENYAL->HrefValue = "";
		$this->KENYAL->TooltipValue = "";

		// MASSA
		$this->MASSA->LinkCustomAttributes = "";
		$this->MASSA->HrefValue = "";
		$this->MASSA->TooltipValue = "";

		// NYERI_RABA
		$this->NYERI_RABA->LinkCustomAttributes = "";
		$this->NYERI_RABA->HrefValue = "";
		$this->NYERI_RABA->TooltipValue = "";

		// BENTUK_PUTING
		$this->BENTUK_PUTING->LinkCustomAttributes = "";
		$this->BENTUK_PUTING->HrefValue = "";
		$this->BENTUK_PUTING->TooltipValue = "";

		// MAMMO
		$this->MAMMO->LinkCustomAttributes = "";
		$this->MAMMO->HrefValue = "";
		$this->MAMMO->TooltipValue = "";

		// ALAT_KONTRASEPSI
		$this->ALAT_KONTRASEPSI->LinkCustomAttributes = "";
		$this->ALAT_KONTRASEPSI->HrefValue = "";
		$this->ALAT_KONTRASEPSI->TooltipValue = "";

		// MASALAH_SEKS
		$this->MASALAH_SEKS->LinkCustomAttributes = "";
		$this->MASALAH_SEKS->HrefValue = "";
		$this->MASALAH_SEKS->TooltipValue = "";

		// PREPUTIUM
		$this->PREPUTIUM->LinkCustomAttributes = "";
		$this->PREPUTIUM->HrefValue = "";
		$this->PREPUTIUM->TooltipValue = "";

		// MASALAH_PROSTAT
		$this->MASALAH_PROSTAT->LinkCustomAttributes = "";
		$this->MASALAH_PROSTAT->HrefValue = "";
		$this->MASALAH_PROSTAT->TooltipValue = "";

		// BENTUK_SKROTUM
		$this->BENTUK_SKROTUM->LinkCustomAttributes = "";
		$this->BENTUK_SKROTUM->HrefValue = "";
		$this->BENTUK_SKROTUM->TooltipValue = "";

		// TESTIS
		$this->TESTIS->LinkCustomAttributes = "";
		$this->TESTIS->HrefValue = "";
		$this->TESTIS->TooltipValue = "";

		// MASSA_BEN
		$this->MASSA_BEN->LinkCustomAttributes = "";
		$this->MASSA_BEN->HrefValue = "";
		$this->MASSA_BEN->TooltipValue = "";

		// HERNIASI
		$this->HERNIASI->LinkCustomAttributes = "";
		$this->HERNIASI->HrefValue = "";
		$this->HERNIASI->TooltipValue = "";

		// LAIN2
		$this->LAIN2->LinkCustomAttributes = "";
		$this->LAIN2->HrefValue = "";
		$this->LAIN2->TooltipValue = "";

		// ALAT_KONTRA
		$this->ALAT_KONTRA->LinkCustomAttributes = "";
		$this->ALAT_KONTRA->HrefValue = "";
		$this->ALAT_KONTRA->TooltipValue = "";

		// MASALAH_REPRO
		$this->MASALAH_REPRO->LinkCustomAttributes = "";
		$this->MASALAH_REPRO->HrefValue = "";
		$this->MASALAH_REPRO->TooltipValue = "";

		// EKSTREMITAS_ATAS
		$this->EKSTREMITAS_ATAS->LinkCustomAttributes = "";
		$this->EKSTREMITAS_ATAS->HrefValue = "";
		$this->EKSTREMITAS_ATAS->TooltipValue = "";

		// EKSTREMITAS_BAWAH
		$this->EKSTREMITAS_BAWAH->LinkCustomAttributes = "";
		$this->EKSTREMITAS_BAWAH->HrefValue = "";
		$this->EKSTREMITAS_BAWAH->TooltipValue = "";

		// AKTIVITAS
		$this->AKTIVITAS->LinkCustomAttributes = "";
		$this->AKTIVITAS->HrefValue = "";
		$this->AKTIVITAS->TooltipValue = "";

		// BERJALAN
		$this->BERJALAN->LinkCustomAttributes = "";
		$this->BERJALAN->HrefValue = "";
		$this->BERJALAN->TooltipValue = "";

		// SISTEM_INTE
		$this->SISTEM_INTE->LinkCustomAttributes = "";
		$this->SISTEM_INTE->HrefValue = "";
		$this->SISTEM_INTE->TooltipValue = "";

		// KENYAMANAN
		$this->KENYAMANAN->LinkCustomAttributes = "";
		$this->KENYAMANAN->HrefValue = "";
		$this->KENYAMANAN->TooltipValue = "";

		// KES_DIRI
		$this->KES_DIRI->LinkCustomAttributes = "";
		$this->KES_DIRI->HrefValue = "";
		$this->KES_DIRI->TooltipValue = "";

		// SOS_SUPORT
		$this->SOS_SUPORT->LinkCustomAttributes = "";
		$this->SOS_SUPORT->HrefValue = "";
		$this->SOS_SUPORT->TooltipValue = "";

		// ANSIETAS
		$this->ANSIETAS->LinkCustomAttributes = "";
		$this->ANSIETAS->HrefValue = "";
		$this->ANSIETAS->TooltipValue = "";

		// KEHILANGAN
		$this->KEHILANGAN->LinkCustomAttributes = "";
		$this->KEHILANGAN->HrefValue = "";
		$this->KEHILANGAN->TooltipValue = "";

		// STATUS_EMOSI
		$this->STATUS_EMOSI->LinkCustomAttributes = "";
		$this->STATUS_EMOSI->HrefValue = "";
		$this->STATUS_EMOSI->TooltipValue = "";

		// KONSEP_DIRI
		$this->KONSEP_DIRI->LinkCustomAttributes = "";
		$this->KONSEP_DIRI->HrefValue = "";
		$this->KONSEP_DIRI->TooltipValue = "";

		// RESPON_HILANG
		$this->RESPON_HILANG->LinkCustomAttributes = "";
		$this->RESPON_HILANG->HrefValue = "";
		$this->RESPON_HILANG->TooltipValue = "";

		// SUMBER_STRESS
		$this->SUMBER_STRESS->LinkCustomAttributes = "";
		$this->SUMBER_STRESS->HrefValue = "";
		$this->SUMBER_STRESS->TooltipValue = "";

		// BERARTI
		$this->BERARTI->LinkCustomAttributes = "";
		$this->BERARTI->HrefValue = "";
		$this->BERARTI->TooltipValue = "";

		// TERLIBAT
		$this->TERLIBAT->LinkCustomAttributes = "";
		$this->TERLIBAT->HrefValue = "";
		$this->TERLIBAT->TooltipValue = "";

		// HUBUNGAN
		$this->HUBUNGAN->LinkCustomAttributes = "";
		$this->HUBUNGAN->HrefValue = "";
		$this->HUBUNGAN->TooltipValue = "";

		// KOMUNIKASI
		$this->KOMUNIKASI->LinkCustomAttributes = "";
		$this->KOMUNIKASI->HrefValue = "";
		$this->KOMUNIKASI->TooltipValue = "";

		// KEPUTUSAN
		$this->KEPUTUSAN->LinkCustomAttributes = "";
		$this->KEPUTUSAN->HrefValue = "";
		$this->KEPUTUSAN->TooltipValue = "";

		// MENGASUH
		$this->MENGASUH->LinkCustomAttributes = "";
		$this->MENGASUH->HrefValue = "";
		$this->MENGASUH->TooltipValue = "";

		// DUKUNGAN
		$this->DUKUNGAN->LinkCustomAttributes = "";
		$this->DUKUNGAN->HrefValue = "";
		$this->DUKUNGAN->TooltipValue = "";

		// REAKSI
		$this->REAKSI->LinkCustomAttributes = "";
		$this->REAKSI->HrefValue = "";
		$this->REAKSI->TooltipValue = "";

		// BUDAYA
		$this->BUDAYA->LinkCustomAttributes = "";
		$this->BUDAYA->HrefValue = "";
		$this->BUDAYA->TooltipValue = "";

		// POLA_AKTIVITAS
		$this->POLA_AKTIVITAS->LinkCustomAttributes = "";
		$this->POLA_AKTIVITAS->HrefValue = "";
		$this->POLA_AKTIVITAS->TooltipValue = "";

		// POLA_ISTIRAHAT
		$this->POLA_ISTIRAHAT->LinkCustomAttributes = "";
		$this->POLA_ISTIRAHAT->HrefValue = "";
		$this->POLA_ISTIRAHAT->TooltipValue = "";

		// POLA_MAKAN
		$this->POLA_MAKAN->LinkCustomAttributes = "";
		$this->POLA_MAKAN->HrefValue = "";
		$this->POLA_MAKAN->TooltipValue = "";

		// PANTANGAN
		$this->PANTANGAN->LinkCustomAttributes = "";
		$this->PANTANGAN->HrefValue = "";
		$this->PANTANGAN->TooltipValue = "";

		// KEPERCAYAAN
		$this->KEPERCAYAAN->LinkCustomAttributes = "";
		$this->KEPERCAYAAN->HrefValue = "";
		$this->KEPERCAYAAN->TooltipValue = "";

		// PANTANGAN_HARI
		$this->PANTANGAN_HARI->LinkCustomAttributes = "";
		$this->PANTANGAN_HARI->HrefValue = "";
		$this->PANTANGAN_HARI->TooltipValue = "";

		// PANTANGAN_LAIN
		$this->PANTANGAN_LAIN->LinkCustomAttributes = "";
		$this->PANTANGAN_LAIN->HrefValue = "";
		$this->PANTANGAN_LAIN->TooltipValue = "";

		// ANJURAN
		$this->ANJURAN->LinkCustomAttributes = "";
		$this->ANJURAN->HrefValue = "";
		$this->ANJURAN->TooltipValue = "";

		// NILAI_KEYAKINAN
		$this->NILAI_KEYAKINAN->LinkCustomAttributes = "";
		$this->NILAI_KEYAKINAN->HrefValue = "";
		$this->NILAI_KEYAKINAN->TooltipValue = "";

		// KEGIATAN_IBADAH
		$this->KEGIATAN_IBADAH->LinkCustomAttributes = "";
		$this->KEGIATAN_IBADAH->HrefValue = "";
		$this->KEGIATAN_IBADAH->TooltipValue = "";

		// PENG_AGAMA
		$this->PENG_AGAMA->LinkCustomAttributes = "";
		$this->PENG_AGAMA->HrefValue = "";
		$this->PENG_AGAMA->TooltipValue = "";

		// SPIRIT
		$this->SPIRIT->LinkCustomAttributes = "";
		$this->SPIRIT->HrefValue = "";
		$this->SPIRIT->TooltipValue = "";

		// BANTUAN
		$this->BANTUAN->LinkCustomAttributes = "";
		$this->BANTUAN->HrefValue = "";
		$this->BANTUAN->TooltipValue = "";

		// PAHAM_PENYAKIT
		$this->PAHAM_PENYAKIT->LinkCustomAttributes = "";
		$this->PAHAM_PENYAKIT->HrefValue = "";
		$this->PAHAM_PENYAKIT->TooltipValue = "";

		// PAHAM_OBAT
		$this->PAHAM_OBAT->LinkCustomAttributes = "";
		$this->PAHAM_OBAT->HrefValue = "";
		$this->PAHAM_OBAT->TooltipValue = "";

		// PAHAM_NUTRISI
		$this->PAHAM_NUTRISI->LinkCustomAttributes = "";
		$this->PAHAM_NUTRISI->HrefValue = "";
		$this->PAHAM_NUTRISI->TooltipValue = "";

		// PAHAM_RAWAT
		$this->PAHAM_RAWAT->LinkCustomAttributes = "";
		$this->PAHAM_RAWAT->HrefValue = "";
		$this->PAHAM_RAWAT->TooltipValue = "";

		// HAMBATAN_EDUKASI
		$this->HAMBATAN_EDUKASI->LinkCustomAttributes = "";
		$this->HAMBATAN_EDUKASI->HrefValue = "";
		$this->HAMBATAN_EDUKASI->TooltipValue = "";

		// FREK_MAKAN
		$this->FREK_MAKAN->LinkCustomAttributes = "";
		$this->FREK_MAKAN->HrefValue = "";
		$this->FREK_MAKAN->TooltipValue = "";

		// JUM_MAKAN
		$this->JUM_MAKAN->LinkCustomAttributes = "";
		$this->JUM_MAKAN->HrefValue = "";
		$this->JUM_MAKAN->TooltipValue = "";

		// JEN_MAKAN
		$this->JEN_MAKAN->LinkCustomAttributes = "";
		$this->JEN_MAKAN->HrefValue = "";
		$this->JEN_MAKAN->TooltipValue = "";

		// KOM_MAKAN
		$this->KOM_MAKAN->LinkCustomAttributes = "";
		$this->KOM_MAKAN->HrefValue = "";
		$this->KOM_MAKAN->TooltipValue = "";

		// DIET
		$this->DIET->LinkCustomAttributes = "";
		$this->DIET->HrefValue = "";
		$this->DIET->TooltipValue = "";

		// CARA_MAKAN
		$this->CARA_MAKAN->LinkCustomAttributes = "";
		$this->CARA_MAKAN->HrefValue = "";
		$this->CARA_MAKAN->TooltipValue = "";

		// GANGGUAN
		$this->GANGGUAN->LinkCustomAttributes = "";
		$this->GANGGUAN->HrefValue = "";
		$this->GANGGUAN->TooltipValue = "";

		// FREK_MINUM
		$this->FREK_MINUM->LinkCustomAttributes = "";
		$this->FREK_MINUM->HrefValue = "";
		$this->FREK_MINUM->TooltipValue = "";

		// JUM_MINUM
		$this->JUM_MINUM->LinkCustomAttributes = "";
		$this->JUM_MINUM->HrefValue = "";
		$this->JUM_MINUM->TooltipValue = "";

		// JEN_MINUM
		$this->JEN_MINUM->LinkCustomAttributes = "";
		$this->JEN_MINUM->HrefValue = "";
		$this->JEN_MINUM->TooltipValue = "";

		// GANG_MINUM
		$this->GANG_MINUM->LinkCustomAttributes = "";
		$this->GANG_MINUM->HrefValue = "";
		$this->GANG_MINUM->TooltipValue = "";

		// FREK_BAK
		$this->FREK_BAK->LinkCustomAttributes = "";
		$this->FREK_BAK->HrefValue = "";
		$this->FREK_BAK->TooltipValue = "";

		// WARNA_BAK
		$this->WARNA_BAK->LinkCustomAttributes = "";
		$this->WARNA_BAK->HrefValue = "";
		$this->WARNA_BAK->TooltipValue = "";

		// JMLH_BAK
		$this->JMLH_BAK->LinkCustomAttributes = "";
		$this->JMLH_BAK->HrefValue = "";
		$this->JMLH_BAK->TooltipValue = "";

		// PENG_KAT_BAK
		$this->PENG_KAT_BAK->LinkCustomAttributes = "";
		$this->PENG_KAT_BAK->HrefValue = "";
		$this->PENG_KAT_BAK->TooltipValue = "";

		// KEM_HAN_BAK
		$this->KEM_HAN_BAK->LinkCustomAttributes = "";
		$this->KEM_HAN_BAK->HrefValue = "";
		$this->KEM_HAN_BAK->TooltipValue = "";

		// INKONT_BAK
		$this->INKONT_BAK->LinkCustomAttributes = "";
		$this->INKONT_BAK->HrefValue = "";
		$this->INKONT_BAK->TooltipValue = "";

		// DIURESIS_BAK
		$this->DIURESIS_BAK->LinkCustomAttributes = "";
		$this->DIURESIS_BAK->HrefValue = "";
		$this->DIURESIS_BAK->TooltipValue = "";

		// FREK_BAB
		$this->FREK_BAB->LinkCustomAttributes = "";
		$this->FREK_BAB->HrefValue = "";
		$this->FREK_BAB->TooltipValue = "";

		// WARNA_BAB
		$this->WARNA_BAB->LinkCustomAttributes = "";
		$this->WARNA_BAB->HrefValue = "";
		$this->WARNA_BAB->TooltipValue = "";

		// KONSIST_BAB
		$this->KONSIST_BAB->LinkCustomAttributes = "";
		$this->KONSIST_BAB->HrefValue = "";
		$this->KONSIST_BAB->TooltipValue = "";

		// GANG_BAB
		$this->GANG_BAB->LinkCustomAttributes = "";
		$this->GANG_BAB->HrefValue = "";
		$this->GANG_BAB->TooltipValue = "";

		// STOMA_BAB
		$this->STOMA_BAB->LinkCustomAttributes = "";
		$this->STOMA_BAB->HrefValue = "";
		$this->STOMA_BAB->TooltipValue = "";

		// PENG_OBAT_BAB
		$this->PENG_OBAT_BAB->LinkCustomAttributes = "";
		$this->PENG_OBAT_BAB->HrefValue = "";
		$this->PENG_OBAT_BAB->TooltipValue = "";

		// IST_SIANG
		$this->IST_SIANG->LinkCustomAttributes = "";
		$this->IST_SIANG->HrefValue = "";
		$this->IST_SIANG->TooltipValue = "";

		// IST_MALAM
		$this->IST_MALAM->LinkCustomAttributes = "";
		$this->IST_MALAM->HrefValue = "";
		$this->IST_MALAM->TooltipValue = "";

		// IST_CAHAYA
		$this->IST_CAHAYA->LinkCustomAttributes = "";
		$this->IST_CAHAYA->HrefValue = "";
		$this->IST_CAHAYA->TooltipValue = "";

		// IST_POSISI
		$this->IST_POSISI->LinkCustomAttributes = "";
		$this->IST_POSISI->HrefValue = "";
		$this->IST_POSISI->TooltipValue = "";

		// IST_LING
		$this->IST_LING->LinkCustomAttributes = "";
		$this->IST_LING->HrefValue = "";
		$this->IST_LING->TooltipValue = "";

		// IST_GANG_TIDUR
		$this->IST_GANG_TIDUR->LinkCustomAttributes = "";
		$this->IST_GANG_TIDUR->HrefValue = "";
		$this->IST_GANG_TIDUR->TooltipValue = "";

		// PENG_OBAT_IST
		$this->PENG_OBAT_IST->LinkCustomAttributes = "";
		$this->PENG_OBAT_IST->HrefValue = "";
		$this->PENG_OBAT_IST->TooltipValue = "";

		// FREK_MAND
		$this->FREK_MAND->LinkCustomAttributes = "";
		$this->FREK_MAND->HrefValue = "";
		$this->FREK_MAND->TooltipValue = "";

		// CUC_RAMB_MAND
		$this->CUC_RAMB_MAND->LinkCustomAttributes = "";
		$this->CUC_RAMB_MAND->HrefValue = "";
		$this->CUC_RAMB_MAND->TooltipValue = "";

		// SIH_GIGI_MAND
		$this->SIH_GIGI_MAND->LinkCustomAttributes = "";
		$this->SIH_GIGI_MAND->HrefValue = "";
		$this->SIH_GIGI_MAND->TooltipValue = "";

		// BANT_MAND
		$this->BANT_MAND->LinkCustomAttributes = "";
		$this->BANT_MAND->HrefValue = "";
		$this->BANT_MAND->TooltipValue = "";

		// GANT_PAKAI
		$this->GANT_PAKAI->LinkCustomAttributes = "";
		$this->GANT_PAKAI->HrefValue = "";
		$this->GANT_PAKAI->TooltipValue = "";

		// PAK_CUCI
		$this->PAK_CUCI->LinkCustomAttributes = "";
		$this->PAK_CUCI->HrefValue = "";
		$this->PAK_CUCI->TooltipValue = "";

		// PAK_BANT
		$this->PAK_BANT->LinkCustomAttributes = "";
		$this->PAK_BANT->HrefValue = "";
		$this->PAK_BANT->TooltipValue = "";

		// ALT_BANT
		$this->ALT_BANT->LinkCustomAttributes = "";
		$this->ALT_BANT->HrefValue = "";
		$this->ALT_BANT->TooltipValue = "";

		// KEMP_MUND
		$this->KEMP_MUND->LinkCustomAttributes = "";
		$this->KEMP_MUND->HrefValue = "";
		$this->KEMP_MUND->TooltipValue = "";

		// BIL_PUT
		$this->BIL_PUT->LinkCustomAttributes = "";
		$this->BIL_PUT->HrefValue = "";
		$this->BIL_PUT->TooltipValue = "";

		// ADAPTIF
		$this->ADAPTIF->LinkCustomAttributes = "";
		$this->ADAPTIF->HrefValue = "";
		$this->ADAPTIF->TooltipValue = "";

		// MALADAPTIF
		$this->MALADAPTIF->LinkCustomAttributes = "";
		$this->MALADAPTIF->HrefValue = "";
		$this->MALADAPTIF->TooltipValue = "";

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

		// obat2
		$this->obat2->LinkCustomAttributes = "";
		$this->obat2->HrefValue = "";
		$this->obat2->TooltipValue = "";

		// PERBANDINGAN_BB
		$this->PERBANDINGAN_BB->LinkCustomAttributes = "";
		$this->PERBANDINGAN_BB->HrefValue = "";
		$this->PERBANDINGAN_BB->TooltipValue = "";

		// KONTINENSIA
		$this->KONTINENSIA->LinkCustomAttributes = "";
		$this->KONTINENSIA->HrefValue = "";
		$this->KONTINENSIA->TooltipValue = "";

		// JENIS_KULIT1
		$this->JENIS_KULIT1->LinkCustomAttributes = "";
		$this->JENIS_KULIT1->HrefValue = "";
		$this->JENIS_KULIT1->TooltipValue = "";

		// MOBILITAS
		$this->MOBILITAS->LinkCustomAttributes = "";
		$this->MOBILITAS->HrefValue = "";
		$this->MOBILITAS->TooltipValue = "";

		// JK
		$this->JK->LinkCustomAttributes = "";
		$this->JK->HrefValue = "";
		$this->JK->TooltipValue = "";

		// UMUR
		$this->UMUR->LinkCustomAttributes = "";
		$this->UMUR->HrefValue = "";
		$this->UMUR->TooltipValue = "";

		// NAFSU_MAKAN
		$this->NAFSU_MAKAN->LinkCustomAttributes = "";
		$this->NAFSU_MAKAN->HrefValue = "";
		$this->NAFSU_MAKAN->TooltipValue = "";

		// OBAT1
		$this->OBAT1->LinkCustomAttributes = "";
		$this->OBAT1->HrefValue = "";
		$this->OBAT1->TooltipValue = "";

		// MALNUTRISI
		$this->MALNUTRISI->LinkCustomAttributes = "";
		$this->MALNUTRISI->HrefValue = "";
		$this->MALNUTRISI->TooltipValue = "";

		// MOTORIK1
		$this->MOTORIK1->LinkCustomAttributes = "";
		$this->MOTORIK1->HrefValue = "";
		$this->MOTORIK1->TooltipValue = "";

		// SPINAL
		$this->SPINAL->LinkCustomAttributes = "";
		$this->SPINAL->HrefValue = "";
		$this->SPINAL->TooltipValue = "";

		// MEJA_OPERASI
		$this->MEJA_OPERASI->LinkCustomAttributes = "";
		$this->MEJA_OPERASI->HrefValue = "";
		$this->MEJA_OPERASI->TooltipValue = "";

		// RIWAYAT_JATUH
		$this->RIWAYAT_JATUH->LinkCustomAttributes = "";
		$this->RIWAYAT_JATUH->HrefValue = "";
		$this->RIWAYAT_JATUH->TooltipValue = "";

		// DIAGNOSIS_SEKUNDER
		$this->DIAGNOSIS_SEKUNDER->LinkCustomAttributes = "";
		$this->DIAGNOSIS_SEKUNDER->HrefValue = "";
		$this->DIAGNOSIS_SEKUNDER->TooltipValue = "";

		// ALAT_BANTU
		$this->ALAT_BANTU->LinkCustomAttributes = "";
		$this->ALAT_BANTU->HrefValue = "";
		$this->ALAT_BANTU->TooltipValue = "";

		// HEPARIN
		$this->HEPARIN->LinkCustomAttributes = "";
		$this->HEPARIN->HrefValue = "";
		$this->HEPARIN->TooltipValue = "";

		// GAYA_BERJALAN
		$this->GAYA_BERJALAN->LinkCustomAttributes = "";
		$this->GAYA_BERJALAN->HrefValue = "";
		$this->GAYA_BERJALAN->TooltipValue = "";

		// KESADARAN1
		$this->KESADARAN1->LinkCustomAttributes = "";
		$this->KESADARAN1->HrefValue = "";
		$this->KESADARAN1->TooltipValue = "";

		// NOMR_LAMA
		$this->NOMR_LAMA->LinkCustomAttributes = "";
		$this->NOMR_LAMA->HrefValue = "";
		$this->NOMR_LAMA->TooltipValue = "";

		// NO_KARTU
		$this->NO_KARTU->LinkCustomAttributes = "";
		$this->NO_KARTU->HrefValue = "";
		$this->NO_KARTU->TooltipValue = "";

		// JNS_PASIEN
		$this->JNS_PASIEN->LinkCustomAttributes = "";
		$this->JNS_PASIEN->HrefValue = "";
		$this->JNS_PASIEN->TooltipValue = "";

		// nama_ayah
		$this->nama_ayah->LinkCustomAttributes = "";
		$this->nama_ayah->HrefValue = "";
		$this->nama_ayah->TooltipValue = "";

		// nama_ibu
		$this->nama_ibu->LinkCustomAttributes = "";
		$this->nama_ibu->HrefValue = "";
		$this->nama_ibu->TooltipValue = "";

		// nama_suami
		$this->nama_suami->LinkCustomAttributes = "";
		$this->nama_suami->HrefValue = "";
		$this->nama_suami->TooltipValue = "";

		// nama_istri
		$this->nama_istri->LinkCustomAttributes = "";
		$this->nama_istri->HrefValue = "";
		$this->nama_istri->TooltipValue = "";

		// KD_ETNIS
		$this->KD_ETNIS->LinkCustomAttributes = "";
		$this->KD_ETNIS->HrefValue = "";
		$this->KD_ETNIS->TooltipValue = "";

		// KD_BHS_HARIAN
		$this->KD_BHS_HARIAN->LinkCustomAttributes = "";
		$this->KD_BHS_HARIAN->HrefValue = "";
		$this->KD_BHS_HARIAN->TooltipValue = "";

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

		// NOMR
		$this->NOMR->EditAttrs["class"] = "form-control";
		$this->NOMR->EditCustomAttributes = "";
		$this->NOMR->EditValue = $this->NOMR->CurrentValue;
		$this->NOMR->PlaceHolder = ew_RemoveHtml($this->NOMR->FldCaption());

		// TITLE
		$this->TITLE->EditAttrs["class"] = "form-control";
		$this->TITLE->EditCustomAttributes = "";

		// NAMA
		$this->NAMA->EditAttrs["class"] = "form-control";
		$this->NAMA->EditCustomAttributes = "";
		$this->NAMA->EditValue = $this->NAMA->CurrentValue;
		$this->NAMA->PlaceHolder = ew_RemoveHtml($this->NAMA->FldCaption());

		// IBUKANDUNG
		$this->IBUKANDUNG->EditAttrs["class"] = "form-control";
		$this->IBUKANDUNG->EditCustomAttributes = "";
		$this->IBUKANDUNG->EditValue = $this->IBUKANDUNG->CurrentValue;
		$this->IBUKANDUNG->PlaceHolder = ew_RemoveHtml($this->IBUKANDUNG->FldCaption());

		// TEMPAT
		$this->TEMPAT->EditAttrs["class"] = "form-control";
		$this->TEMPAT->EditCustomAttributes = "";
		$this->TEMPAT->EditValue = $this->TEMPAT->CurrentValue;
		$this->TEMPAT->PlaceHolder = ew_RemoveHtml($this->TEMPAT->FldCaption());

		// TGLLAHIR
		$this->TGLLAHIR->EditAttrs["class"] = "form-control";
		$this->TGLLAHIR->EditCustomAttributes = "";
		$this->TGLLAHIR->EditValue = ew_FormatDateTime($this->TGLLAHIR->CurrentValue, 7);
		$this->TGLLAHIR->PlaceHolder = ew_RemoveHtml($this->TGLLAHIR->FldCaption());

		// JENISKELAMIN
		$this->JENISKELAMIN->EditCustomAttributes = "";

		// ALAMAT
		$this->ALAMAT->EditAttrs["class"] = "form-control";
		$this->ALAMAT->EditCustomAttributes = "";
		$this->ALAMAT->EditValue = $this->ALAMAT->CurrentValue;
		$this->ALAMAT->PlaceHolder = ew_RemoveHtml($this->ALAMAT->FldCaption());

		// KDPROVINSI
		$this->KDPROVINSI->EditAttrs["class"] = "form-control";
		$this->KDPROVINSI->EditCustomAttributes = "";

		// KOTA
		$this->KOTA->EditAttrs["class"] = "form-control";
		$this->KOTA->EditCustomAttributes = "";

		// KDKECAMATAN
		$this->KDKECAMATAN->EditAttrs["class"] = "form-control";
		$this->KDKECAMATAN->EditCustomAttributes = "";

		// KELURAHAN
		$this->KELURAHAN->EditAttrs["class"] = "form-control";
		$this->KELURAHAN->EditCustomAttributes = "";

		// NOTELP
		$this->NOTELP->EditAttrs["class"] = "form-control";
		$this->NOTELP->EditCustomAttributes = "";
		$this->NOTELP->EditValue = $this->NOTELP->CurrentValue;
		$this->NOTELP->PlaceHolder = ew_RemoveHtml($this->NOTELP->FldCaption());

		// NOKTP
		$this->NOKTP->EditAttrs["class"] = "form-control";
		$this->NOKTP->EditCustomAttributes = "";
		$this->NOKTP->EditValue = $this->NOKTP->CurrentValue;
		$this->NOKTP->PlaceHolder = ew_RemoveHtml($this->NOKTP->FldCaption());

		// SUAMI_ORTU
		$this->SUAMI_ORTU->EditAttrs["class"] = "form-control";
		$this->SUAMI_ORTU->EditCustomAttributes = "";
		$this->SUAMI_ORTU->EditValue = $this->SUAMI_ORTU->CurrentValue;
		$this->SUAMI_ORTU->PlaceHolder = ew_RemoveHtml($this->SUAMI_ORTU->FldCaption());

		// PEKERJAAN
		$this->PEKERJAAN->EditAttrs["class"] = "form-control";
		$this->PEKERJAAN->EditCustomAttributes = "";
		$this->PEKERJAAN->EditValue = $this->PEKERJAAN->CurrentValue;
		$this->PEKERJAAN->PlaceHolder = ew_RemoveHtml($this->PEKERJAAN->FldCaption());

		// STATUS
		$this->STATUS->EditAttrs["class"] = "form-control";
		$this->STATUS->EditCustomAttributes = "";

		// AGAMA
		$this->AGAMA->EditAttrs["class"] = "form-control";
		$this->AGAMA->EditCustomAttributes = "";

		// PENDIDIKAN
		$this->PENDIDIKAN->EditAttrs["class"] = "form-control";
		$this->PENDIDIKAN->EditCustomAttributes = "";

		// KDCARABAYAR
		$this->KDCARABAYAR->EditAttrs["class"] = "form-control";
		$this->KDCARABAYAR->EditCustomAttributes = "";

		// NIP
		$this->NIP->EditAttrs["class"] = "form-control";
		$this->NIP->EditCustomAttributes = "";
		$this->NIP->EditValue = $this->NIP->CurrentValue;
		$this->NIP->PlaceHolder = ew_RemoveHtml($this->NIP->FldCaption());

		// TGLDAFTAR
		$this->TGLDAFTAR->EditAttrs["class"] = "form-control";
		$this->TGLDAFTAR->EditCustomAttributes = "";
		$this->TGLDAFTAR->EditValue = ew_FormatDateTime($this->TGLDAFTAR->CurrentValue, 7);
		$this->TGLDAFTAR->PlaceHolder = ew_RemoveHtml($this->TGLDAFTAR->FldCaption());

		// ALAMAT_KTP
		$this->ALAMAT_KTP->EditAttrs["class"] = "form-control";
		$this->ALAMAT_KTP->EditCustomAttributes = "";
		$this->ALAMAT_KTP->EditValue = $this->ALAMAT_KTP->CurrentValue;
		$this->ALAMAT_KTP->PlaceHolder = ew_RemoveHtml($this->ALAMAT_KTP->FldCaption());

		// PARENT_NOMR
		$this->PARENT_NOMR->EditAttrs["class"] = "form-control";
		$this->PARENT_NOMR->EditCustomAttributes = "";
		$this->PARENT_NOMR->EditValue = $this->PARENT_NOMR->CurrentValue;
		$this->PARENT_NOMR->PlaceHolder = ew_RemoveHtml($this->PARENT_NOMR->FldCaption());

		// NAMA_OBAT
		$this->NAMA_OBAT->EditAttrs["class"] = "form-control";
		$this->NAMA_OBAT->EditCustomAttributes = "";
		$this->NAMA_OBAT->EditValue = $this->NAMA_OBAT->CurrentValue;
		$this->NAMA_OBAT->PlaceHolder = ew_RemoveHtml($this->NAMA_OBAT->FldCaption());

		// DOSIS
		$this->DOSIS->EditAttrs["class"] = "form-control";
		$this->DOSIS->EditCustomAttributes = "";
		$this->DOSIS->EditValue = $this->DOSIS->CurrentValue;
		$this->DOSIS->PlaceHolder = ew_RemoveHtml($this->DOSIS->FldCaption());

		// CARA_PEMBERIAN
		$this->CARA_PEMBERIAN->EditAttrs["class"] = "form-control";
		$this->CARA_PEMBERIAN->EditCustomAttributes = "";
		$this->CARA_PEMBERIAN->EditValue = $this->CARA_PEMBERIAN->CurrentValue;
		$this->CARA_PEMBERIAN->PlaceHolder = ew_RemoveHtml($this->CARA_PEMBERIAN->FldCaption());

		// FREKUENSI
		$this->FREKUENSI->EditAttrs["class"] = "form-control";
		$this->FREKUENSI->EditCustomAttributes = "";
		$this->FREKUENSI->EditValue = $this->FREKUENSI->CurrentValue;
		$this->FREKUENSI->PlaceHolder = ew_RemoveHtml($this->FREKUENSI->FldCaption());

		// WAKTU_TGL
		$this->WAKTU_TGL->EditAttrs["class"] = "form-control";
		$this->WAKTU_TGL->EditCustomAttributes = "";
		$this->WAKTU_TGL->EditValue = $this->WAKTU_TGL->CurrentValue;
		$this->WAKTU_TGL->PlaceHolder = ew_RemoveHtml($this->WAKTU_TGL->FldCaption());

		// LAMA_WAKTU
		$this->LAMA_WAKTU->EditAttrs["class"] = "form-control";
		$this->LAMA_WAKTU->EditCustomAttributes = "";
		$this->LAMA_WAKTU->EditValue = $this->LAMA_WAKTU->CurrentValue;
		$this->LAMA_WAKTU->PlaceHolder = ew_RemoveHtml($this->LAMA_WAKTU->FldCaption());

		// ALERGI_OBAT
		$this->ALERGI_OBAT->EditAttrs["class"] = "form-control";
		$this->ALERGI_OBAT->EditCustomAttributes = "";
		$this->ALERGI_OBAT->EditValue = $this->ALERGI_OBAT->CurrentValue;
		$this->ALERGI_OBAT->PlaceHolder = ew_RemoveHtml($this->ALERGI_OBAT->FldCaption());

		// REAKSI_ALERGI
		$this->REAKSI_ALERGI->EditAttrs["class"] = "form-control";
		$this->REAKSI_ALERGI->EditCustomAttributes = "";
		$this->REAKSI_ALERGI->EditValue = $this->REAKSI_ALERGI->CurrentValue;
		$this->REAKSI_ALERGI->PlaceHolder = ew_RemoveHtml($this->REAKSI_ALERGI->FldCaption());

		// RIWAYAT_KES
		$this->RIWAYAT_KES->EditAttrs["class"] = "form-control";
		$this->RIWAYAT_KES->EditCustomAttributes = "";
		$this->RIWAYAT_KES->EditValue = $this->RIWAYAT_KES->CurrentValue;
		$this->RIWAYAT_KES->PlaceHolder = ew_RemoveHtml($this->RIWAYAT_KES->FldCaption());

		// BB_LAHIR
		$this->BB_LAHIR->EditAttrs["class"] = "form-control";
		$this->BB_LAHIR->EditCustomAttributes = "";
		$this->BB_LAHIR->EditValue = $this->BB_LAHIR->CurrentValue;
		$this->BB_LAHIR->PlaceHolder = ew_RemoveHtml($this->BB_LAHIR->FldCaption());

		// BB_SEKARANG
		$this->BB_SEKARANG->EditAttrs["class"] = "form-control";
		$this->BB_SEKARANG->EditCustomAttributes = "";
		$this->BB_SEKARANG->EditValue = $this->BB_SEKARANG->CurrentValue;
		$this->BB_SEKARANG->PlaceHolder = ew_RemoveHtml($this->BB_SEKARANG->FldCaption());

		// FISIK_FONTANEL
		$this->FISIK_FONTANEL->EditAttrs["class"] = "form-control";
		$this->FISIK_FONTANEL->EditCustomAttributes = "";
		$this->FISIK_FONTANEL->EditValue = $this->FISIK_FONTANEL->CurrentValue;
		$this->FISIK_FONTANEL->PlaceHolder = ew_RemoveHtml($this->FISIK_FONTANEL->FldCaption());

		// FISIK_REFLEKS
		$this->FISIK_REFLEKS->EditAttrs["class"] = "form-control";
		$this->FISIK_REFLEKS->EditCustomAttributes = "";
		$this->FISIK_REFLEKS->EditValue = $this->FISIK_REFLEKS->CurrentValue;
		$this->FISIK_REFLEKS->PlaceHolder = ew_RemoveHtml($this->FISIK_REFLEKS->FldCaption());

		// FISIK_SENSASI
		$this->FISIK_SENSASI->EditAttrs["class"] = "form-control";
		$this->FISIK_SENSASI->EditCustomAttributes = "";
		$this->FISIK_SENSASI->EditValue = $this->FISIK_SENSASI->CurrentValue;
		$this->FISIK_SENSASI->PlaceHolder = ew_RemoveHtml($this->FISIK_SENSASI->FldCaption());

		// MOTORIK_KASAR
		$this->MOTORIK_KASAR->EditAttrs["class"] = "form-control";
		$this->MOTORIK_KASAR->EditCustomAttributes = "";
		$this->MOTORIK_KASAR->EditValue = $this->MOTORIK_KASAR->CurrentValue;
		$this->MOTORIK_KASAR->PlaceHolder = ew_RemoveHtml($this->MOTORIK_KASAR->FldCaption());

		// MOTORIK_HALUS
		$this->MOTORIK_HALUS->EditAttrs["class"] = "form-control";
		$this->MOTORIK_HALUS->EditCustomAttributes = "";
		$this->MOTORIK_HALUS->EditValue = $this->MOTORIK_HALUS->CurrentValue;
		$this->MOTORIK_HALUS->PlaceHolder = ew_RemoveHtml($this->MOTORIK_HALUS->FldCaption());

		// MAMPU_BICARA
		$this->MAMPU_BICARA->EditAttrs["class"] = "form-control";
		$this->MAMPU_BICARA->EditCustomAttributes = "";
		$this->MAMPU_BICARA->EditValue = $this->MAMPU_BICARA->CurrentValue;
		$this->MAMPU_BICARA->PlaceHolder = ew_RemoveHtml($this->MAMPU_BICARA->FldCaption());

		// MAMPU_SOSIALISASI
		$this->MAMPU_SOSIALISASI->EditAttrs["class"] = "form-control";
		$this->MAMPU_SOSIALISASI->EditCustomAttributes = "";
		$this->MAMPU_SOSIALISASI->EditValue = $this->MAMPU_SOSIALISASI->CurrentValue;
		$this->MAMPU_SOSIALISASI->PlaceHolder = ew_RemoveHtml($this->MAMPU_SOSIALISASI->FldCaption());

		// BCG
		$this->BCG->EditAttrs["class"] = "form-control";
		$this->BCG->EditCustomAttributes = "";
		$this->BCG->EditValue = $this->BCG->CurrentValue;
		$this->BCG->PlaceHolder = ew_RemoveHtml($this->BCG->FldCaption());

		// POLIO
		$this->POLIO->EditAttrs["class"] = "form-control";
		$this->POLIO->EditCustomAttributes = "";
		$this->POLIO->EditValue = $this->POLIO->CurrentValue;
		$this->POLIO->PlaceHolder = ew_RemoveHtml($this->POLIO->FldCaption());

		// DPT
		$this->DPT->EditAttrs["class"] = "form-control";
		$this->DPT->EditCustomAttributes = "";
		$this->DPT->EditValue = $this->DPT->CurrentValue;
		$this->DPT->PlaceHolder = ew_RemoveHtml($this->DPT->FldCaption());

		// CAMPAK
		$this->CAMPAK->EditAttrs["class"] = "form-control";
		$this->CAMPAK->EditCustomAttributes = "";
		$this->CAMPAK->EditValue = $this->CAMPAK->CurrentValue;
		$this->CAMPAK->PlaceHolder = ew_RemoveHtml($this->CAMPAK->FldCaption());

		// HEPATITIS_B
		$this->HEPATITIS_B->EditAttrs["class"] = "form-control";
		$this->HEPATITIS_B->EditCustomAttributes = "";
		$this->HEPATITIS_B->EditValue = $this->HEPATITIS_B->CurrentValue;
		$this->HEPATITIS_B->PlaceHolder = ew_RemoveHtml($this->HEPATITIS_B->FldCaption());

		// TD
		$this->TD->EditAttrs["class"] = "form-control";
		$this->TD->EditCustomAttributes = "";
		$this->TD->EditValue = $this->TD->CurrentValue;
		$this->TD->PlaceHolder = ew_RemoveHtml($this->TD->FldCaption());

		// SUHU
		$this->SUHU->EditAttrs["class"] = "form-control";
		$this->SUHU->EditCustomAttributes = "";
		$this->SUHU->EditValue = $this->SUHU->CurrentValue;
		$this->SUHU->PlaceHolder = ew_RemoveHtml($this->SUHU->FldCaption());

		// RR
		$this->RR->EditAttrs["class"] = "form-control";
		$this->RR->EditCustomAttributes = "";
		$this->RR->EditValue = $this->RR->CurrentValue;
		$this->RR->PlaceHolder = ew_RemoveHtml($this->RR->FldCaption());

		// NADI
		$this->NADI->EditAttrs["class"] = "form-control";
		$this->NADI->EditCustomAttributes = "";
		$this->NADI->EditValue = $this->NADI->CurrentValue;
		$this->NADI->PlaceHolder = ew_RemoveHtml($this->NADI->FldCaption());

		// BB
		$this->BB->EditAttrs["class"] = "form-control";
		$this->BB->EditCustomAttributes = "";
		$this->BB->EditValue = $this->BB->CurrentValue;
		$this->BB->PlaceHolder = ew_RemoveHtml($this->BB->FldCaption());

		// TB
		$this->TB->EditAttrs["class"] = "form-control";
		$this->TB->EditCustomAttributes = "";
		$this->TB->EditValue = $this->TB->CurrentValue;
		$this->TB->PlaceHolder = ew_RemoveHtml($this->TB->FldCaption());

		// EYE
		$this->EYE->EditAttrs["class"] = "form-control";
		$this->EYE->EditCustomAttributes = "";
		$this->EYE->EditValue = $this->EYE->CurrentValue;
		$this->EYE->PlaceHolder = ew_RemoveHtml($this->EYE->FldCaption());

		// MOTORIK
		$this->MOTORIK->EditAttrs["class"] = "form-control";
		$this->MOTORIK->EditCustomAttributes = "";
		$this->MOTORIK->EditValue = $this->MOTORIK->CurrentValue;
		$this->MOTORIK->PlaceHolder = ew_RemoveHtml($this->MOTORIK->FldCaption());

		// VERBAL
		$this->VERBAL->EditAttrs["class"] = "form-control";
		$this->VERBAL->EditCustomAttributes = "";
		$this->VERBAL->EditValue = $this->VERBAL->CurrentValue;
		$this->VERBAL->PlaceHolder = ew_RemoveHtml($this->VERBAL->FldCaption());

		// TOTAL_GCS
		$this->TOTAL_GCS->EditAttrs["class"] = "form-control";
		$this->TOTAL_GCS->EditCustomAttributes = "";
		$this->TOTAL_GCS->EditValue = $this->TOTAL_GCS->CurrentValue;
		$this->TOTAL_GCS->PlaceHolder = ew_RemoveHtml($this->TOTAL_GCS->FldCaption());

		// REAKSI_PUPIL
		$this->REAKSI_PUPIL->EditAttrs["class"] = "form-control";
		$this->REAKSI_PUPIL->EditCustomAttributes = "";
		$this->REAKSI_PUPIL->EditValue = $this->REAKSI_PUPIL->CurrentValue;
		$this->REAKSI_PUPIL->PlaceHolder = ew_RemoveHtml($this->REAKSI_PUPIL->FldCaption());

		// KESADARAN
		$this->KESADARAN->EditAttrs["class"] = "form-control";
		$this->KESADARAN->EditCustomAttributes = "";
		$this->KESADARAN->EditValue = $this->KESADARAN->CurrentValue;
		$this->KESADARAN->PlaceHolder = ew_RemoveHtml($this->KESADARAN->FldCaption());

		// KEPALA
		$this->KEPALA->EditAttrs["class"] = "form-control";
		$this->KEPALA->EditCustomAttributes = "";
		$this->KEPALA->EditValue = $this->KEPALA->CurrentValue;
		$this->KEPALA->PlaceHolder = ew_RemoveHtml($this->KEPALA->FldCaption());

		// RAMBUT
		$this->RAMBUT->EditAttrs["class"] = "form-control";
		$this->RAMBUT->EditCustomAttributes = "";
		$this->RAMBUT->EditValue = $this->RAMBUT->CurrentValue;
		$this->RAMBUT->PlaceHolder = ew_RemoveHtml($this->RAMBUT->FldCaption());

		// MUKA
		$this->MUKA->EditAttrs["class"] = "form-control";
		$this->MUKA->EditCustomAttributes = "";
		$this->MUKA->EditValue = $this->MUKA->CurrentValue;
		$this->MUKA->PlaceHolder = ew_RemoveHtml($this->MUKA->FldCaption());

		// MATA
		$this->MATA->EditAttrs["class"] = "form-control";
		$this->MATA->EditCustomAttributes = "";
		$this->MATA->EditValue = $this->MATA->CurrentValue;
		$this->MATA->PlaceHolder = ew_RemoveHtml($this->MATA->FldCaption());

		// GANG_LIHAT
		$this->GANG_LIHAT->EditAttrs["class"] = "form-control";
		$this->GANG_LIHAT->EditCustomAttributes = "";
		$this->GANG_LIHAT->EditValue = $this->GANG_LIHAT->CurrentValue;
		$this->GANG_LIHAT->PlaceHolder = ew_RemoveHtml($this->GANG_LIHAT->FldCaption());

		// ALATBANTU_LIHAT
		$this->ALATBANTU_LIHAT->EditAttrs["class"] = "form-control";
		$this->ALATBANTU_LIHAT->EditCustomAttributes = "";
		$this->ALATBANTU_LIHAT->EditValue = $this->ALATBANTU_LIHAT->CurrentValue;
		$this->ALATBANTU_LIHAT->PlaceHolder = ew_RemoveHtml($this->ALATBANTU_LIHAT->FldCaption());

		// BENTUK
		$this->BENTUK->EditAttrs["class"] = "form-control";
		$this->BENTUK->EditCustomAttributes = "";
		$this->BENTUK->EditValue = $this->BENTUK->CurrentValue;
		$this->BENTUK->PlaceHolder = ew_RemoveHtml($this->BENTUK->FldCaption());

		// PENDENGARAN
		$this->PENDENGARAN->EditAttrs["class"] = "form-control";
		$this->PENDENGARAN->EditCustomAttributes = "";
		$this->PENDENGARAN->EditValue = $this->PENDENGARAN->CurrentValue;
		$this->PENDENGARAN->PlaceHolder = ew_RemoveHtml($this->PENDENGARAN->FldCaption());

		// LUB_TELINGA
		$this->LUB_TELINGA->EditAttrs["class"] = "form-control";
		$this->LUB_TELINGA->EditCustomAttributes = "";
		$this->LUB_TELINGA->EditValue = $this->LUB_TELINGA->CurrentValue;
		$this->LUB_TELINGA->PlaceHolder = ew_RemoveHtml($this->LUB_TELINGA->FldCaption());

		// BENTUK_HIDUNG
		$this->BENTUK_HIDUNG->EditAttrs["class"] = "form-control";
		$this->BENTUK_HIDUNG->EditCustomAttributes = "";
		$this->BENTUK_HIDUNG->EditValue = $this->BENTUK_HIDUNG->CurrentValue;
		$this->BENTUK_HIDUNG->PlaceHolder = ew_RemoveHtml($this->BENTUK_HIDUNG->FldCaption());

		// MEMBRAN_MUK
		$this->MEMBRAN_MUK->EditAttrs["class"] = "form-control";
		$this->MEMBRAN_MUK->EditCustomAttributes = "";
		$this->MEMBRAN_MUK->EditValue = $this->MEMBRAN_MUK->CurrentValue;
		$this->MEMBRAN_MUK->PlaceHolder = ew_RemoveHtml($this->MEMBRAN_MUK->FldCaption());

		// MAMPU_HIDU
		$this->MAMPU_HIDU->EditAttrs["class"] = "form-control";
		$this->MAMPU_HIDU->EditCustomAttributes = "";
		$this->MAMPU_HIDU->EditValue = $this->MAMPU_HIDU->CurrentValue;
		$this->MAMPU_HIDU->PlaceHolder = ew_RemoveHtml($this->MAMPU_HIDU->FldCaption());

		// ALAT_HIDUNG
		$this->ALAT_HIDUNG->EditAttrs["class"] = "form-control";
		$this->ALAT_HIDUNG->EditCustomAttributes = "";
		$this->ALAT_HIDUNG->EditValue = $this->ALAT_HIDUNG->CurrentValue;
		$this->ALAT_HIDUNG->PlaceHolder = ew_RemoveHtml($this->ALAT_HIDUNG->FldCaption());

		// RONGGA_MULUT
		$this->RONGGA_MULUT->EditAttrs["class"] = "form-control";
		$this->RONGGA_MULUT->EditCustomAttributes = "";
		$this->RONGGA_MULUT->EditValue = $this->RONGGA_MULUT->CurrentValue;
		$this->RONGGA_MULUT->PlaceHolder = ew_RemoveHtml($this->RONGGA_MULUT->FldCaption());

		// WARNA_MEMBRAN
		$this->WARNA_MEMBRAN->EditAttrs["class"] = "form-control";
		$this->WARNA_MEMBRAN->EditCustomAttributes = "";
		$this->WARNA_MEMBRAN->EditValue = $this->WARNA_MEMBRAN->CurrentValue;
		$this->WARNA_MEMBRAN->PlaceHolder = ew_RemoveHtml($this->WARNA_MEMBRAN->FldCaption());

		// LEMBAB
		$this->LEMBAB->EditAttrs["class"] = "form-control";
		$this->LEMBAB->EditCustomAttributes = "";
		$this->LEMBAB->EditValue = $this->LEMBAB->CurrentValue;
		$this->LEMBAB->PlaceHolder = ew_RemoveHtml($this->LEMBAB->FldCaption());

		// STOMATITIS
		$this->STOMATITIS->EditAttrs["class"] = "form-control";
		$this->STOMATITIS->EditCustomAttributes = "";
		$this->STOMATITIS->EditValue = $this->STOMATITIS->CurrentValue;
		$this->STOMATITIS->PlaceHolder = ew_RemoveHtml($this->STOMATITIS->FldCaption());

		// LIDAH
		$this->LIDAH->EditAttrs["class"] = "form-control";
		$this->LIDAH->EditCustomAttributes = "";
		$this->LIDAH->EditValue = $this->LIDAH->CurrentValue;
		$this->LIDAH->PlaceHolder = ew_RemoveHtml($this->LIDAH->FldCaption());

		// GIGI
		$this->GIGI->EditAttrs["class"] = "form-control";
		$this->GIGI->EditCustomAttributes = "";
		$this->GIGI->EditValue = $this->GIGI->CurrentValue;
		$this->GIGI->PlaceHolder = ew_RemoveHtml($this->GIGI->FldCaption());

		// TONSIL
		$this->TONSIL->EditAttrs["class"] = "form-control";
		$this->TONSIL->EditCustomAttributes = "";
		$this->TONSIL->EditValue = $this->TONSIL->CurrentValue;
		$this->TONSIL->PlaceHolder = ew_RemoveHtml($this->TONSIL->FldCaption());

		// KELAINAN
		$this->KELAINAN->EditAttrs["class"] = "form-control";
		$this->KELAINAN->EditCustomAttributes = "";
		$this->KELAINAN->EditValue = $this->KELAINAN->CurrentValue;
		$this->KELAINAN->PlaceHolder = ew_RemoveHtml($this->KELAINAN->FldCaption());

		// PERGERAKAN
		$this->PERGERAKAN->EditAttrs["class"] = "form-control";
		$this->PERGERAKAN->EditCustomAttributes = "";
		$this->PERGERAKAN->EditValue = $this->PERGERAKAN->CurrentValue;
		$this->PERGERAKAN->PlaceHolder = ew_RemoveHtml($this->PERGERAKAN->FldCaption());

		// KEL_TIROID
		$this->KEL_TIROID->EditAttrs["class"] = "form-control";
		$this->KEL_TIROID->EditCustomAttributes = "";
		$this->KEL_TIROID->EditValue = $this->KEL_TIROID->CurrentValue;
		$this->KEL_TIROID->PlaceHolder = ew_RemoveHtml($this->KEL_TIROID->FldCaption());

		// KEL_GETAH
		$this->KEL_GETAH->EditAttrs["class"] = "form-control";
		$this->KEL_GETAH->EditCustomAttributes = "";
		$this->KEL_GETAH->EditValue = $this->KEL_GETAH->CurrentValue;
		$this->KEL_GETAH->PlaceHolder = ew_RemoveHtml($this->KEL_GETAH->FldCaption());

		// TEKANAN_VENA
		$this->TEKANAN_VENA->EditAttrs["class"] = "form-control";
		$this->TEKANAN_VENA->EditCustomAttributes = "";
		$this->TEKANAN_VENA->EditValue = $this->TEKANAN_VENA->CurrentValue;
		$this->TEKANAN_VENA->PlaceHolder = ew_RemoveHtml($this->TEKANAN_VENA->FldCaption());

		// REF_MENELAN
		$this->REF_MENELAN->EditAttrs["class"] = "form-control";
		$this->REF_MENELAN->EditCustomAttributes = "";
		$this->REF_MENELAN->EditValue = $this->REF_MENELAN->CurrentValue;
		$this->REF_MENELAN->PlaceHolder = ew_RemoveHtml($this->REF_MENELAN->FldCaption());

		// NYERI
		$this->NYERI->EditAttrs["class"] = "form-control";
		$this->NYERI->EditCustomAttributes = "";
		$this->NYERI->EditValue = $this->NYERI->CurrentValue;
		$this->NYERI->PlaceHolder = ew_RemoveHtml($this->NYERI->FldCaption());

		// KREPITASI
		$this->KREPITASI->EditAttrs["class"] = "form-control";
		$this->KREPITASI->EditCustomAttributes = "";
		$this->KREPITASI->EditValue = $this->KREPITASI->CurrentValue;
		$this->KREPITASI->PlaceHolder = ew_RemoveHtml($this->KREPITASI->FldCaption());

		// KEL_LAIN
		$this->KEL_LAIN->EditAttrs["class"] = "form-control";
		$this->KEL_LAIN->EditCustomAttributes = "";
		$this->KEL_LAIN->EditValue = $this->KEL_LAIN->CurrentValue;
		$this->KEL_LAIN->PlaceHolder = ew_RemoveHtml($this->KEL_LAIN->FldCaption());

		// BENTUK_DADA
		$this->BENTUK_DADA->EditAttrs["class"] = "form-control";
		$this->BENTUK_DADA->EditCustomAttributes = "";
		$this->BENTUK_DADA->EditValue = $this->BENTUK_DADA->CurrentValue;
		$this->BENTUK_DADA->PlaceHolder = ew_RemoveHtml($this->BENTUK_DADA->FldCaption());

		// POLA_NAPAS
		$this->POLA_NAPAS->EditAttrs["class"] = "form-control";
		$this->POLA_NAPAS->EditCustomAttributes = "";
		$this->POLA_NAPAS->EditValue = $this->POLA_NAPAS->CurrentValue;
		$this->POLA_NAPAS->PlaceHolder = ew_RemoveHtml($this->POLA_NAPAS->FldCaption());

		// BENTUK_THORAKS
		$this->BENTUK_THORAKS->EditAttrs["class"] = "form-control";
		$this->BENTUK_THORAKS->EditCustomAttributes = "";
		$this->BENTUK_THORAKS->EditValue = $this->BENTUK_THORAKS->CurrentValue;
		$this->BENTUK_THORAKS->PlaceHolder = ew_RemoveHtml($this->BENTUK_THORAKS->FldCaption());

		// PAL_KREP
		$this->PAL_KREP->EditAttrs["class"] = "form-control";
		$this->PAL_KREP->EditCustomAttributes = "";
		$this->PAL_KREP->EditValue = $this->PAL_KREP->CurrentValue;
		$this->PAL_KREP->PlaceHolder = ew_RemoveHtml($this->PAL_KREP->FldCaption());

		// BENJOLAN
		$this->BENJOLAN->EditAttrs["class"] = "form-control";
		$this->BENJOLAN->EditCustomAttributes = "";
		$this->BENJOLAN->EditValue = $this->BENJOLAN->CurrentValue;
		$this->BENJOLAN->PlaceHolder = ew_RemoveHtml($this->BENJOLAN->FldCaption());

		// PAL_NYERI
		$this->PAL_NYERI->EditAttrs["class"] = "form-control";
		$this->PAL_NYERI->EditCustomAttributes = "";
		$this->PAL_NYERI->EditValue = $this->PAL_NYERI->CurrentValue;
		$this->PAL_NYERI->PlaceHolder = ew_RemoveHtml($this->PAL_NYERI->FldCaption());

		// PERKUSI
		$this->PERKUSI->EditAttrs["class"] = "form-control";
		$this->PERKUSI->EditCustomAttributes = "";
		$this->PERKUSI->EditValue = $this->PERKUSI->CurrentValue;
		$this->PERKUSI->PlaceHolder = ew_RemoveHtml($this->PERKUSI->FldCaption());

		// PARU
		$this->PARU->EditAttrs["class"] = "form-control";
		$this->PARU->EditCustomAttributes = "";
		$this->PARU->EditValue = $this->PARU->CurrentValue;
		$this->PARU->PlaceHolder = ew_RemoveHtml($this->PARU->FldCaption());

		// JANTUNG
		$this->JANTUNG->EditAttrs["class"] = "form-control";
		$this->JANTUNG->EditCustomAttributes = "";
		$this->JANTUNG->EditValue = $this->JANTUNG->CurrentValue;
		$this->JANTUNG->PlaceHolder = ew_RemoveHtml($this->JANTUNG->FldCaption());

		// SUARA_JANTUNG
		$this->SUARA_JANTUNG->EditAttrs["class"] = "form-control";
		$this->SUARA_JANTUNG->EditCustomAttributes = "";
		$this->SUARA_JANTUNG->EditValue = $this->SUARA_JANTUNG->CurrentValue;
		$this->SUARA_JANTUNG->PlaceHolder = ew_RemoveHtml($this->SUARA_JANTUNG->FldCaption());

		// ALATBANTU_JAN
		$this->ALATBANTU_JAN->EditAttrs["class"] = "form-control";
		$this->ALATBANTU_JAN->EditCustomAttributes = "";
		$this->ALATBANTU_JAN->EditValue = $this->ALATBANTU_JAN->CurrentValue;
		$this->ALATBANTU_JAN->PlaceHolder = ew_RemoveHtml($this->ALATBANTU_JAN->FldCaption());

		// BENTUK_ABDOMEN
		$this->BENTUK_ABDOMEN->EditAttrs["class"] = "form-control";
		$this->BENTUK_ABDOMEN->EditCustomAttributes = "";
		$this->BENTUK_ABDOMEN->EditValue = $this->BENTUK_ABDOMEN->CurrentValue;
		$this->BENTUK_ABDOMEN->PlaceHolder = ew_RemoveHtml($this->BENTUK_ABDOMEN->FldCaption());

		// AUSKULTASI
		$this->AUSKULTASI->EditAttrs["class"] = "form-control";
		$this->AUSKULTASI->EditCustomAttributes = "";
		$this->AUSKULTASI->EditValue = $this->AUSKULTASI->CurrentValue;
		$this->AUSKULTASI->PlaceHolder = ew_RemoveHtml($this->AUSKULTASI->FldCaption());

		// NYERI_PASI
		$this->NYERI_PASI->EditAttrs["class"] = "form-control";
		$this->NYERI_PASI->EditCustomAttributes = "";
		$this->NYERI_PASI->EditValue = $this->NYERI_PASI->CurrentValue;
		$this->NYERI_PASI->PlaceHolder = ew_RemoveHtml($this->NYERI_PASI->FldCaption());

		// PEM_KELENJAR
		$this->PEM_KELENJAR->EditAttrs["class"] = "form-control";
		$this->PEM_KELENJAR->EditCustomAttributes = "";
		$this->PEM_KELENJAR->EditValue = $this->PEM_KELENJAR->CurrentValue;
		$this->PEM_KELENJAR->PlaceHolder = ew_RemoveHtml($this->PEM_KELENJAR->FldCaption());

		// PERKUSI_AUS
		$this->PERKUSI_AUS->EditAttrs["class"] = "form-control";
		$this->PERKUSI_AUS->EditCustomAttributes = "";
		$this->PERKUSI_AUS->EditValue = $this->PERKUSI_AUS->CurrentValue;
		$this->PERKUSI_AUS->PlaceHolder = ew_RemoveHtml($this->PERKUSI_AUS->FldCaption());

		// VAGINA
		$this->VAGINA->EditAttrs["class"] = "form-control";
		$this->VAGINA->EditCustomAttributes = "";
		$this->VAGINA->EditValue = $this->VAGINA->CurrentValue;
		$this->VAGINA->PlaceHolder = ew_RemoveHtml($this->VAGINA->FldCaption());

		// MENSTRUASI
		$this->MENSTRUASI->EditAttrs["class"] = "form-control";
		$this->MENSTRUASI->EditCustomAttributes = "";
		$this->MENSTRUASI->EditValue = $this->MENSTRUASI->CurrentValue;
		$this->MENSTRUASI->PlaceHolder = ew_RemoveHtml($this->MENSTRUASI->FldCaption());

		// KATETER
		$this->KATETER->EditAttrs["class"] = "form-control";
		$this->KATETER->EditCustomAttributes = "";
		$this->KATETER->EditValue = $this->KATETER->CurrentValue;
		$this->KATETER->PlaceHolder = ew_RemoveHtml($this->KATETER->FldCaption());

		// LABIA_PROM
		$this->LABIA_PROM->EditAttrs["class"] = "form-control";
		$this->LABIA_PROM->EditCustomAttributes = "";
		$this->LABIA_PROM->EditValue = $this->LABIA_PROM->CurrentValue;
		$this->LABIA_PROM->PlaceHolder = ew_RemoveHtml($this->LABIA_PROM->FldCaption());

		// HAMIL
		$this->HAMIL->EditAttrs["class"] = "form-control";
		$this->HAMIL->EditCustomAttributes = "";
		$this->HAMIL->EditValue = $this->HAMIL->CurrentValue;
		$this->HAMIL->PlaceHolder = ew_RemoveHtml($this->HAMIL->FldCaption());

		// TGL_HAID
		$this->TGL_HAID->EditAttrs["class"] = "form-control";
		$this->TGL_HAID->EditCustomAttributes = "";
		$this->TGL_HAID->EditValue = ew_FormatDateTime($this->TGL_HAID->CurrentValue, 8);
		$this->TGL_HAID->PlaceHolder = ew_RemoveHtml($this->TGL_HAID->FldCaption());

		// PERIKSA_CERVIX
		$this->PERIKSA_CERVIX->EditAttrs["class"] = "form-control";
		$this->PERIKSA_CERVIX->EditCustomAttributes = "";
		$this->PERIKSA_CERVIX->EditValue = $this->PERIKSA_CERVIX->CurrentValue;
		$this->PERIKSA_CERVIX->PlaceHolder = ew_RemoveHtml($this->PERIKSA_CERVIX->FldCaption());

		// BENTUK_PAYUDARA
		$this->BENTUK_PAYUDARA->EditAttrs["class"] = "form-control";
		$this->BENTUK_PAYUDARA->EditCustomAttributes = "";
		$this->BENTUK_PAYUDARA->EditValue = $this->BENTUK_PAYUDARA->CurrentValue;
		$this->BENTUK_PAYUDARA->PlaceHolder = ew_RemoveHtml($this->BENTUK_PAYUDARA->FldCaption());

		// KENYAL
		$this->KENYAL->EditAttrs["class"] = "form-control";
		$this->KENYAL->EditCustomAttributes = "";
		$this->KENYAL->EditValue = $this->KENYAL->CurrentValue;
		$this->KENYAL->PlaceHolder = ew_RemoveHtml($this->KENYAL->FldCaption());

		// MASSA
		$this->MASSA->EditAttrs["class"] = "form-control";
		$this->MASSA->EditCustomAttributes = "";
		$this->MASSA->EditValue = $this->MASSA->CurrentValue;
		$this->MASSA->PlaceHolder = ew_RemoveHtml($this->MASSA->FldCaption());

		// NYERI_RABA
		$this->NYERI_RABA->EditAttrs["class"] = "form-control";
		$this->NYERI_RABA->EditCustomAttributes = "";
		$this->NYERI_RABA->EditValue = $this->NYERI_RABA->CurrentValue;
		$this->NYERI_RABA->PlaceHolder = ew_RemoveHtml($this->NYERI_RABA->FldCaption());

		// BENTUK_PUTING
		$this->BENTUK_PUTING->EditAttrs["class"] = "form-control";
		$this->BENTUK_PUTING->EditCustomAttributes = "";
		$this->BENTUK_PUTING->EditValue = $this->BENTUK_PUTING->CurrentValue;
		$this->BENTUK_PUTING->PlaceHolder = ew_RemoveHtml($this->BENTUK_PUTING->FldCaption());

		// MAMMO
		$this->MAMMO->EditAttrs["class"] = "form-control";
		$this->MAMMO->EditCustomAttributes = "";
		$this->MAMMO->EditValue = $this->MAMMO->CurrentValue;
		$this->MAMMO->PlaceHolder = ew_RemoveHtml($this->MAMMO->FldCaption());

		// ALAT_KONTRASEPSI
		$this->ALAT_KONTRASEPSI->EditAttrs["class"] = "form-control";
		$this->ALAT_KONTRASEPSI->EditCustomAttributes = "";
		$this->ALAT_KONTRASEPSI->EditValue = $this->ALAT_KONTRASEPSI->CurrentValue;
		$this->ALAT_KONTRASEPSI->PlaceHolder = ew_RemoveHtml($this->ALAT_KONTRASEPSI->FldCaption());

		// MASALAH_SEKS
		$this->MASALAH_SEKS->EditAttrs["class"] = "form-control";
		$this->MASALAH_SEKS->EditCustomAttributes = "";
		$this->MASALAH_SEKS->EditValue = $this->MASALAH_SEKS->CurrentValue;
		$this->MASALAH_SEKS->PlaceHolder = ew_RemoveHtml($this->MASALAH_SEKS->FldCaption());

		// PREPUTIUM
		$this->PREPUTIUM->EditAttrs["class"] = "form-control";
		$this->PREPUTIUM->EditCustomAttributes = "";
		$this->PREPUTIUM->EditValue = $this->PREPUTIUM->CurrentValue;
		$this->PREPUTIUM->PlaceHolder = ew_RemoveHtml($this->PREPUTIUM->FldCaption());

		// MASALAH_PROSTAT
		$this->MASALAH_PROSTAT->EditAttrs["class"] = "form-control";
		$this->MASALAH_PROSTAT->EditCustomAttributes = "";
		$this->MASALAH_PROSTAT->EditValue = $this->MASALAH_PROSTAT->CurrentValue;
		$this->MASALAH_PROSTAT->PlaceHolder = ew_RemoveHtml($this->MASALAH_PROSTAT->FldCaption());

		// BENTUK_SKROTUM
		$this->BENTUK_SKROTUM->EditAttrs["class"] = "form-control";
		$this->BENTUK_SKROTUM->EditCustomAttributes = "";
		$this->BENTUK_SKROTUM->EditValue = $this->BENTUK_SKROTUM->CurrentValue;
		$this->BENTUK_SKROTUM->PlaceHolder = ew_RemoveHtml($this->BENTUK_SKROTUM->FldCaption());

		// TESTIS
		$this->TESTIS->EditAttrs["class"] = "form-control";
		$this->TESTIS->EditCustomAttributes = "";
		$this->TESTIS->EditValue = $this->TESTIS->CurrentValue;
		$this->TESTIS->PlaceHolder = ew_RemoveHtml($this->TESTIS->FldCaption());

		// MASSA_BEN
		$this->MASSA_BEN->EditAttrs["class"] = "form-control";
		$this->MASSA_BEN->EditCustomAttributes = "";
		$this->MASSA_BEN->EditValue = $this->MASSA_BEN->CurrentValue;
		$this->MASSA_BEN->PlaceHolder = ew_RemoveHtml($this->MASSA_BEN->FldCaption());

		// HERNIASI
		$this->HERNIASI->EditAttrs["class"] = "form-control";
		$this->HERNIASI->EditCustomAttributes = "";
		$this->HERNIASI->EditValue = $this->HERNIASI->CurrentValue;
		$this->HERNIASI->PlaceHolder = ew_RemoveHtml($this->HERNIASI->FldCaption());

		// LAIN2
		$this->LAIN2->EditAttrs["class"] = "form-control";
		$this->LAIN2->EditCustomAttributes = "";
		$this->LAIN2->EditValue = $this->LAIN2->CurrentValue;
		$this->LAIN2->PlaceHolder = ew_RemoveHtml($this->LAIN2->FldCaption());

		// ALAT_KONTRA
		$this->ALAT_KONTRA->EditAttrs["class"] = "form-control";
		$this->ALAT_KONTRA->EditCustomAttributes = "";
		$this->ALAT_KONTRA->EditValue = $this->ALAT_KONTRA->CurrentValue;
		$this->ALAT_KONTRA->PlaceHolder = ew_RemoveHtml($this->ALAT_KONTRA->FldCaption());

		// MASALAH_REPRO
		$this->MASALAH_REPRO->EditAttrs["class"] = "form-control";
		$this->MASALAH_REPRO->EditCustomAttributes = "";
		$this->MASALAH_REPRO->EditValue = $this->MASALAH_REPRO->CurrentValue;
		$this->MASALAH_REPRO->PlaceHolder = ew_RemoveHtml($this->MASALAH_REPRO->FldCaption());

		// EKSTREMITAS_ATAS
		$this->EKSTREMITAS_ATAS->EditAttrs["class"] = "form-control";
		$this->EKSTREMITAS_ATAS->EditCustomAttributes = "";
		$this->EKSTREMITAS_ATAS->EditValue = $this->EKSTREMITAS_ATAS->CurrentValue;
		$this->EKSTREMITAS_ATAS->PlaceHolder = ew_RemoveHtml($this->EKSTREMITAS_ATAS->FldCaption());

		// EKSTREMITAS_BAWAH
		$this->EKSTREMITAS_BAWAH->EditAttrs["class"] = "form-control";
		$this->EKSTREMITAS_BAWAH->EditCustomAttributes = "";
		$this->EKSTREMITAS_BAWAH->EditValue = $this->EKSTREMITAS_BAWAH->CurrentValue;
		$this->EKSTREMITAS_BAWAH->PlaceHolder = ew_RemoveHtml($this->EKSTREMITAS_BAWAH->FldCaption());

		// AKTIVITAS
		$this->AKTIVITAS->EditAttrs["class"] = "form-control";
		$this->AKTIVITAS->EditCustomAttributes = "";
		$this->AKTIVITAS->EditValue = $this->AKTIVITAS->CurrentValue;
		$this->AKTIVITAS->PlaceHolder = ew_RemoveHtml($this->AKTIVITAS->FldCaption());

		// BERJALAN
		$this->BERJALAN->EditAttrs["class"] = "form-control";
		$this->BERJALAN->EditCustomAttributes = "";
		$this->BERJALAN->EditValue = $this->BERJALAN->CurrentValue;
		$this->BERJALAN->PlaceHolder = ew_RemoveHtml($this->BERJALAN->FldCaption());

		// SISTEM_INTE
		$this->SISTEM_INTE->EditAttrs["class"] = "form-control";
		$this->SISTEM_INTE->EditCustomAttributes = "";
		$this->SISTEM_INTE->EditValue = $this->SISTEM_INTE->CurrentValue;
		$this->SISTEM_INTE->PlaceHolder = ew_RemoveHtml($this->SISTEM_INTE->FldCaption());

		// KENYAMANAN
		$this->KENYAMANAN->EditAttrs["class"] = "form-control";
		$this->KENYAMANAN->EditCustomAttributes = "";
		$this->KENYAMANAN->EditValue = $this->KENYAMANAN->CurrentValue;
		$this->KENYAMANAN->PlaceHolder = ew_RemoveHtml($this->KENYAMANAN->FldCaption());

		// KES_DIRI
		$this->KES_DIRI->EditAttrs["class"] = "form-control";
		$this->KES_DIRI->EditCustomAttributes = "";
		$this->KES_DIRI->EditValue = $this->KES_DIRI->CurrentValue;
		$this->KES_DIRI->PlaceHolder = ew_RemoveHtml($this->KES_DIRI->FldCaption());

		// SOS_SUPORT
		$this->SOS_SUPORT->EditAttrs["class"] = "form-control";
		$this->SOS_SUPORT->EditCustomAttributes = "";
		$this->SOS_SUPORT->EditValue = $this->SOS_SUPORT->CurrentValue;
		$this->SOS_SUPORT->PlaceHolder = ew_RemoveHtml($this->SOS_SUPORT->FldCaption());

		// ANSIETAS
		$this->ANSIETAS->EditAttrs["class"] = "form-control";
		$this->ANSIETAS->EditCustomAttributes = "";
		$this->ANSIETAS->EditValue = $this->ANSIETAS->CurrentValue;
		$this->ANSIETAS->PlaceHolder = ew_RemoveHtml($this->ANSIETAS->FldCaption());

		// KEHILANGAN
		$this->KEHILANGAN->EditAttrs["class"] = "form-control";
		$this->KEHILANGAN->EditCustomAttributes = "";
		$this->KEHILANGAN->EditValue = $this->KEHILANGAN->CurrentValue;
		$this->KEHILANGAN->PlaceHolder = ew_RemoveHtml($this->KEHILANGAN->FldCaption());

		// STATUS_EMOSI
		$this->STATUS_EMOSI->EditAttrs["class"] = "form-control";
		$this->STATUS_EMOSI->EditCustomAttributes = "";
		$this->STATUS_EMOSI->EditValue = $this->STATUS_EMOSI->CurrentValue;
		$this->STATUS_EMOSI->PlaceHolder = ew_RemoveHtml($this->STATUS_EMOSI->FldCaption());

		// KONSEP_DIRI
		$this->KONSEP_DIRI->EditAttrs["class"] = "form-control";
		$this->KONSEP_DIRI->EditCustomAttributes = "";
		$this->KONSEP_DIRI->EditValue = $this->KONSEP_DIRI->CurrentValue;
		$this->KONSEP_DIRI->PlaceHolder = ew_RemoveHtml($this->KONSEP_DIRI->FldCaption());

		// RESPON_HILANG
		$this->RESPON_HILANG->EditAttrs["class"] = "form-control";
		$this->RESPON_HILANG->EditCustomAttributes = "";
		$this->RESPON_HILANG->EditValue = $this->RESPON_HILANG->CurrentValue;
		$this->RESPON_HILANG->PlaceHolder = ew_RemoveHtml($this->RESPON_HILANG->FldCaption());

		// SUMBER_STRESS
		$this->SUMBER_STRESS->EditAttrs["class"] = "form-control";
		$this->SUMBER_STRESS->EditCustomAttributes = "";
		$this->SUMBER_STRESS->EditValue = $this->SUMBER_STRESS->CurrentValue;
		$this->SUMBER_STRESS->PlaceHolder = ew_RemoveHtml($this->SUMBER_STRESS->FldCaption());

		// BERARTI
		$this->BERARTI->EditAttrs["class"] = "form-control";
		$this->BERARTI->EditCustomAttributes = "";
		$this->BERARTI->EditValue = $this->BERARTI->CurrentValue;
		$this->BERARTI->PlaceHolder = ew_RemoveHtml($this->BERARTI->FldCaption());

		// TERLIBAT
		$this->TERLIBAT->EditAttrs["class"] = "form-control";
		$this->TERLIBAT->EditCustomAttributes = "";
		$this->TERLIBAT->EditValue = $this->TERLIBAT->CurrentValue;
		$this->TERLIBAT->PlaceHolder = ew_RemoveHtml($this->TERLIBAT->FldCaption());

		// HUBUNGAN
		$this->HUBUNGAN->EditAttrs["class"] = "form-control";
		$this->HUBUNGAN->EditCustomAttributes = "";
		$this->HUBUNGAN->EditValue = $this->HUBUNGAN->CurrentValue;
		$this->HUBUNGAN->PlaceHolder = ew_RemoveHtml($this->HUBUNGAN->FldCaption());

		// KOMUNIKASI
		$this->KOMUNIKASI->EditAttrs["class"] = "form-control";
		$this->KOMUNIKASI->EditCustomAttributes = "";
		$this->KOMUNIKASI->EditValue = $this->KOMUNIKASI->CurrentValue;
		$this->KOMUNIKASI->PlaceHolder = ew_RemoveHtml($this->KOMUNIKASI->FldCaption());

		// KEPUTUSAN
		$this->KEPUTUSAN->EditAttrs["class"] = "form-control";
		$this->KEPUTUSAN->EditCustomAttributes = "";
		$this->KEPUTUSAN->EditValue = $this->KEPUTUSAN->CurrentValue;
		$this->KEPUTUSAN->PlaceHolder = ew_RemoveHtml($this->KEPUTUSAN->FldCaption());

		// MENGASUH
		$this->MENGASUH->EditAttrs["class"] = "form-control";
		$this->MENGASUH->EditCustomAttributes = "";
		$this->MENGASUH->EditValue = $this->MENGASUH->CurrentValue;
		$this->MENGASUH->PlaceHolder = ew_RemoveHtml($this->MENGASUH->FldCaption());

		// DUKUNGAN
		$this->DUKUNGAN->EditAttrs["class"] = "form-control";
		$this->DUKUNGAN->EditCustomAttributes = "";
		$this->DUKUNGAN->EditValue = $this->DUKUNGAN->CurrentValue;
		$this->DUKUNGAN->PlaceHolder = ew_RemoveHtml($this->DUKUNGAN->FldCaption());

		// REAKSI
		$this->REAKSI->EditAttrs["class"] = "form-control";
		$this->REAKSI->EditCustomAttributes = "";
		$this->REAKSI->EditValue = $this->REAKSI->CurrentValue;
		$this->REAKSI->PlaceHolder = ew_RemoveHtml($this->REAKSI->FldCaption());

		// BUDAYA
		$this->BUDAYA->EditAttrs["class"] = "form-control";
		$this->BUDAYA->EditCustomAttributes = "";
		$this->BUDAYA->EditValue = $this->BUDAYA->CurrentValue;
		$this->BUDAYA->PlaceHolder = ew_RemoveHtml($this->BUDAYA->FldCaption());

		// POLA_AKTIVITAS
		$this->POLA_AKTIVITAS->EditAttrs["class"] = "form-control";
		$this->POLA_AKTIVITAS->EditCustomAttributes = "";
		$this->POLA_AKTIVITAS->EditValue = $this->POLA_AKTIVITAS->CurrentValue;
		$this->POLA_AKTIVITAS->PlaceHolder = ew_RemoveHtml($this->POLA_AKTIVITAS->FldCaption());

		// POLA_ISTIRAHAT
		$this->POLA_ISTIRAHAT->EditAttrs["class"] = "form-control";
		$this->POLA_ISTIRAHAT->EditCustomAttributes = "";
		$this->POLA_ISTIRAHAT->EditValue = $this->POLA_ISTIRAHAT->CurrentValue;
		$this->POLA_ISTIRAHAT->PlaceHolder = ew_RemoveHtml($this->POLA_ISTIRAHAT->FldCaption());

		// POLA_MAKAN
		$this->POLA_MAKAN->EditAttrs["class"] = "form-control";
		$this->POLA_MAKAN->EditCustomAttributes = "";
		$this->POLA_MAKAN->EditValue = $this->POLA_MAKAN->CurrentValue;
		$this->POLA_MAKAN->PlaceHolder = ew_RemoveHtml($this->POLA_MAKAN->FldCaption());

		// PANTANGAN
		$this->PANTANGAN->EditAttrs["class"] = "form-control";
		$this->PANTANGAN->EditCustomAttributes = "";
		$this->PANTANGAN->EditValue = $this->PANTANGAN->CurrentValue;
		$this->PANTANGAN->PlaceHolder = ew_RemoveHtml($this->PANTANGAN->FldCaption());

		// KEPERCAYAAN
		$this->KEPERCAYAAN->EditAttrs["class"] = "form-control";
		$this->KEPERCAYAAN->EditCustomAttributes = "";
		$this->KEPERCAYAAN->EditValue = $this->KEPERCAYAAN->CurrentValue;
		$this->KEPERCAYAAN->PlaceHolder = ew_RemoveHtml($this->KEPERCAYAAN->FldCaption());

		// PANTANGAN_HARI
		$this->PANTANGAN_HARI->EditAttrs["class"] = "form-control";
		$this->PANTANGAN_HARI->EditCustomAttributes = "";
		$this->PANTANGAN_HARI->EditValue = $this->PANTANGAN_HARI->CurrentValue;
		$this->PANTANGAN_HARI->PlaceHolder = ew_RemoveHtml($this->PANTANGAN_HARI->FldCaption());

		// PANTANGAN_LAIN
		$this->PANTANGAN_LAIN->EditAttrs["class"] = "form-control";
		$this->PANTANGAN_LAIN->EditCustomAttributes = "";
		$this->PANTANGAN_LAIN->EditValue = $this->PANTANGAN_LAIN->CurrentValue;
		$this->PANTANGAN_LAIN->PlaceHolder = ew_RemoveHtml($this->PANTANGAN_LAIN->FldCaption());

		// ANJURAN
		$this->ANJURAN->EditAttrs["class"] = "form-control";
		$this->ANJURAN->EditCustomAttributes = "";
		$this->ANJURAN->EditValue = $this->ANJURAN->CurrentValue;
		$this->ANJURAN->PlaceHolder = ew_RemoveHtml($this->ANJURAN->FldCaption());

		// NILAI_KEYAKINAN
		$this->NILAI_KEYAKINAN->EditAttrs["class"] = "form-control";
		$this->NILAI_KEYAKINAN->EditCustomAttributes = "";
		$this->NILAI_KEYAKINAN->EditValue = $this->NILAI_KEYAKINAN->CurrentValue;
		$this->NILAI_KEYAKINAN->PlaceHolder = ew_RemoveHtml($this->NILAI_KEYAKINAN->FldCaption());

		// KEGIATAN_IBADAH
		$this->KEGIATAN_IBADAH->EditAttrs["class"] = "form-control";
		$this->KEGIATAN_IBADAH->EditCustomAttributes = "";
		$this->KEGIATAN_IBADAH->EditValue = $this->KEGIATAN_IBADAH->CurrentValue;
		$this->KEGIATAN_IBADAH->PlaceHolder = ew_RemoveHtml($this->KEGIATAN_IBADAH->FldCaption());

		// PENG_AGAMA
		$this->PENG_AGAMA->EditAttrs["class"] = "form-control";
		$this->PENG_AGAMA->EditCustomAttributes = "";
		$this->PENG_AGAMA->EditValue = $this->PENG_AGAMA->CurrentValue;
		$this->PENG_AGAMA->PlaceHolder = ew_RemoveHtml($this->PENG_AGAMA->FldCaption());

		// SPIRIT
		$this->SPIRIT->EditAttrs["class"] = "form-control";
		$this->SPIRIT->EditCustomAttributes = "";
		$this->SPIRIT->EditValue = $this->SPIRIT->CurrentValue;
		$this->SPIRIT->PlaceHolder = ew_RemoveHtml($this->SPIRIT->FldCaption());

		// BANTUAN
		$this->BANTUAN->EditAttrs["class"] = "form-control";
		$this->BANTUAN->EditCustomAttributes = "";
		$this->BANTUAN->EditValue = $this->BANTUAN->CurrentValue;
		$this->BANTUAN->PlaceHolder = ew_RemoveHtml($this->BANTUAN->FldCaption());

		// PAHAM_PENYAKIT
		$this->PAHAM_PENYAKIT->EditAttrs["class"] = "form-control";
		$this->PAHAM_PENYAKIT->EditCustomAttributes = "";
		$this->PAHAM_PENYAKIT->EditValue = $this->PAHAM_PENYAKIT->CurrentValue;
		$this->PAHAM_PENYAKIT->PlaceHolder = ew_RemoveHtml($this->PAHAM_PENYAKIT->FldCaption());

		// PAHAM_OBAT
		$this->PAHAM_OBAT->EditAttrs["class"] = "form-control";
		$this->PAHAM_OBAT->EditCustomAttributes = "";
		$this->PAHAM_OBAT->EditValue = $this->PAHAM_OBAT->CurrentValue;
		$this->PAHAM_OBAT->PlaceHolder = ew_RemoveHtml($this->PAHAM_OBAT->FldCaption());

		// PAHAM_NUTRISI
		$this->PAHAM_NUTRISI->EditAttrs["class"] = "form-control";
		$this->PAHAM_NUTRISI->EditCustomAttributes = "";
		$this->PAHAM_NUTRISI->EditValue = $this->PAHAM_NUTRISI->CurrentValue;
		$this->PAHAM_NUTRISI->PlaceHolder = ew_RemoveHtml($this->PAHAM_NUTRISI->FldCaption());

		// PAHAM_RAWAT
		$this->PAHAM_RAWAT->EditAttrs["class"] = "form-control";
		$this->PAHAM_RAWAT->EditCustomAttributes = "";
		$this->PAHAM_RAWAT->EditValue = $this->PAHAM_RAWAT->CurrentValue;
		$this->PAHAM_RAWAT->PlaceHolder = ew_RemoveHtml($this->PAHAM_RAWAT->FldCaption());

		// HAMBATAN_EDUKASI
		$this->HAMBATAN_EDUKASI->EditAttrs["class"] = "form-control";
		$this->HAMBATAN_EDUKASI->EditCustomAttributes = "";
		$this->HAMBATAN_EDUKASI->EditValue = $this->HAMBATAN_EDUKASI->CurrentValue;
		$this->HAMBATAN_EDUKASI->PlaceHolder = ew_RemoveHtml($this->HAMBATAN_EDUKASI->FldCaption());

		// FREK_MAKAN
		$this->FREK_MAKAN->EditAttrs["class"] = "form-control";
		$this->FREK_MAKAN->EditCustomAttributes = "";
		$this->FREK_MAKAN->EditValue = $this->FREK_MAKAN->CurrentValue;
		$this->FREK_MAKAN->PlaceHolder = ew_RemoveHtml($this->FREK_MAKAN->FldCaption());

		// JUM_MAKAN
		$this->JUM_MAKAN->EditAttrs["class"] = "form-control";
		$this->JUM_MAKAN->EditCustomAttributes = "";
		$this->JUM_MAKAN->EditValue = $this->JUM_MAKAN->CurrentValue;
		$this->JUM_MAKAN->PlaceHolder = ew_RemoveHtml($this->JUM_MAKAN->FldCaption());

		// JEN_MAKAN
		$this->JEN_MAKAN->EditAttrs["class"] = "form-control";
		$this->JEN_MAKAN->EditCustomAttributes = "";
		$this->JEN_MAKAN->EditValue = $this->JEN_MAKAN->CurrentValue;
		$this->JEN_MAKAN->PlaceHolder = ew_RemoveHtml($this->JEN_MAKAN->FldCaption());

		// KOM_MAKAN
		$this->KOM_MAKAN->EditAttrs["class"] = "form-control";
		$this->KOM_MAKAN->EditCustomAttributes = "";
		$this->KOM_MAKAN->EditValue = $this->KOM_MAKAN->CurrentValue;
		$this->KOM_MAKAN->PlaceHolder = ew_RemoveHtml($this->KOM_MAKAN->FldCaption());

		// DIET
		$this->DIET->EditAttrs["class"] = "form-control";
		$this->DIET->EditCustomAttributes = "";
		$this->DIET->EditValue = $this->DIET->CurrentValue;
		$this->DIET->PlaceHolder = ew_RemoveHtml($this->DIET->FldCaption());

		// CARA_MAKAN
		$this->CARA_MAKAN->EditAttrs["class"] = "form-control";
		$this->CARA_MAKAN->EditCustomAttributes = "";
		$this->CARA_MAKAN->EditValue = $this->CARA_MAKAN->CurrentValue;
		$this->CARA_MAKAN->PlaceHolder = ew_RemoveHtml($this->CARA_MAKAN->FldCaption());

		// GANGGUAN
		$this->GANGGUAN->EditAttrs["class"] = "form-control";
		$this->GANGGUAN->EditCustomAttributes = "";
		$this->GANGGUAN->EditValue = $this->GANGGUAN->CurrentValue;
		$this->GANGGUAN->PlaceHolder = ew_RemoveHtml($this->GANGGUAN->FldCaption());

		// FREK_MINUM
		$this->FREK_MINUM->EditAttrs["class"] = "form-control";
		$this->FREK_MINUM->EditCustomAttributes = "";
		$this->FREK_MINUM->EditValue = $this->FREK_MINUM->CurrentValue;
		$this->FREK_MINUM->PlaceHolder = ew_RemoveHtml($this->FREK_MINUM->FldCaption());

		// JUM_MINUM
		$this->JUM_MINUM->EditAttrs["class"] = "form-control";
		$this->JUM_MINUM->EditCustomAttributes = "";
		$this->JUM_MINUM->EditValue = $this->JUM_MINUM->CurrentValue;
		$this->JUM_MINUM->PlaceHolder = ew_RemoveHtml($this->JUM_MINUM->FldCaption());

		// JEN_MINUM
		$this->JEN_MINUM->EditAttrs["class"] = "form-control";
		$this->JEN_MINUM->EditCustomAttributes = "";
		$this->JEN_MINUM->EditValue = $this->JEN_MINUM->CurrentValue;
		$this->JEN_MINUM->PlaceHolder = ew_RemoveHtml($this->JEN_MINUM->FldCaption());

		// GANG_MINUM
		$this->GANG_MINUM->EditAttrs["class"] = "form-control";
		$this->GANG_MINUM->EditCustomAttributes = "";
		$this->GANG_MINUM->EditValue = $this->GANG_MINUM->CurrentValue;
		$this->GANG_MINUM->PlaceHolder = ew_RemoveHtml($this->GANG_MINUM->FldCaption());

		// FREK_BAK
		$this->FREK_BAK->EditAttrs["class"] = "form-control";
		$this->FREK_BAK->EditCustomAttributes = "";
		$this->FREK_BAK->EditValue = $this->FREK_BAK->CurrentValue;
		$this->FREK_BAK->PlaceHolder = ew_RemoveHtml($this->FREK_BAK->FldCaption());

		// WARNA_BAK
		$this->WARNA_BAK->EditAttrs["class"] = "form-control";
		$this->WARNA_BAK->EditCustomAttributes = "";
		$this->WARNA_BAK->EditValue = $this->WARNA_BAK->CurrentValue;
		$this->WARNA_BAK->PlaceHolder = ew_RemoveHtml($this->WARNA_BAK->FldCaption());

		// JMLH_BAK
		$this->JMLH_BAK->EditAttrs["class"] = "form-control";
		$this->JMLH_BAK->EditCustomAttributes = "";
		$this->JMLH_BAK->EditValue = $this->JMLH_BAK->CurrentValue;
		$this->JMLH_BAK->PlaceHolder = ew_RemoveHtml($this->JMLH_BAK->FldCaption());

		// PENG_KAT_BAK
		$this->PENG_KAT_BAK->EditAttrs["class"] = "form-control";
		$this->PENG_KAT_BAK->EditCustomAttributes = "";
		$this->PENG_KAT_BAK->EditValue = $this->PENG_KAT_BAK->CurrentValue;
		$this->PENG_KAT_BAK->PlaceHolder = ew_RemoveHtml($this->PENG_KAT_BAK->FldCaption());

		// KEM_HAN_BAK
		$this->KEM_HAN_BAK->EditAttrs["class"] = "form-control";
		$this->KEM_HAN_BAK->EditCustomAttributes = "";
		$this->KEM_HAN_BAK->EditValue = $this->KEM_HAN_BAK->CurrentValue;
		$this->KEM_HAN_BAK->PlaceHolder = ew_RemoveHtml($this->KEM_HAN_BAK->FldCaption());

		// INKONT_BAK
		$this->INKONT_BAK->EditAttrs["class"] = "form-control";
		$this->INKONT_BAK->EditCustomAttributes = "";
		$this->INKONT_BAK->EditValue = $this->INKONT_BAK->CurrentValue;
		$this->INKONT_BAK->PlaceHolder = ew_RemoveHtml($this->INKONT_BAK->FldCaption());

		// DIURESIS_BAK
		$this->DIURESIS_BAK->EditAttrs["class"] = "form-control";
		$this->DIURESIS_BAK->EditCustomAttributes = "";
		$this->DIURESIS_BAK->EditValue = $this->DIURESIS_BAK->CurrentValue;
		$this->DIURESIS_BAK->PlaceHolder = ew_RemoveHtml($this->DIURESIS_BAK->FldCaption());

		// FREK_BAB
		$this->FREK_BAB->EditAttrs["class"] = "form-control";
		$this->FREK_BAB->EditCustomAttributes = "";
		$this->FREK_BAB->EditValue = $this->FREK_BAB->CurrentValue;
		$this->FREK_BAB->PlaceHolder = ew_RemoveHtml($this->FREK_BAB->FldCaption());

		// WARNA_BAB
		$this->WARNA_BAB->EditAttrs["class"] = "form-control";
		$this->WARNA_BAB->EditCustomAttributes = "";
		$this->WARNA_BAB->EditValue = $this->WARNA_BAB->CurrentValue;
		$this->WARNA_BAB->PlaceHolder = ew_RemoveHtml($this->WARNA_BAB->FldCaption());

		// KONSIST_BAB
		$this->KONSIST_BAB->EditAttrs["class"] = "form-control";
		$this->KONSIST_BAB->EditCustomAttributes = "";
		$this->KONSIST_BAB->EditValue = $this->KONSIST_BAB->CurrentValue;
		$this->KONSIST_BAB->PlaceHolder = ew_RemoveHtml($this->KONSIST_BAB->FldCaption());

		// GANG_BAB
		$this->GANG_BAB->EditAttrs["class"] = "form-control";
		$this->GANG_BAB->EditCustomAttributes = "";
		$this->GANG_BAB->EditValue = $this->GANG_BAB->CurrentValue;
		$this->GANG_BAB->PlaceHolder = ew_RemoveHtml($this->GANG_BAB->FldCaption());

		// STOMA_BAB
		$this->STOMA_BAB->EditAttrs["class"] = "form-control";
		$this->STOMA_BAB->EditCustomAttributes = "";
		$this->STOMA_BAB->EditValue = $this->STOMA_BAB->CurrentValue;
		$this->STOMA_BAB->PlaceHolder = ew_RemoveHtml($this->STOMA_BAB->FldCaption());

		// PENG_OBAT_BAB
		$this->PENG_OBAT_BAB->EditAttrs["class"] = "form-control";
		$this->PENG_OBAT_BAB->EditCustomAttributes = "";
		$this->PENG_OBAT_BAB->EditValue = $this->PENG_OBAT_BAB->CurrentValue;
		$this->PENG_OBAT_BAB->PlaceHolder = ew_RemoveHtml($this->PENG_OBAT_BAB->FldCaption());

		// IST_SIANG
		$this->IST_SIANG->EditAttrs["class"] = "form-control";
		$this->IST_SIANG->EditCustomAttributes = "";
		$this->IST_SIANG->EditValue = $this->IST_SIANG->CurrentValue;
		$this->IST_SIANG->PlaceHolder = ew_RemoveHtml($this->IST_SIANG->FldCaption());

		// IST_MALAM
		$this->IST_MALAM->EditAttrs["class"] = "form-control";
		$this->IST_MALAM->EditCustomAttributes = "";
		$this->IST_MALAM->EditValue = $this->IST_MALAM->CurrentValue;
		$this->IST_MALAM->PlaceHolder = ew_RemoveHtml($this->IST_MALAM->FldCaption());

		// IST_CAHAYA
		$this->IST_CAHAYA->EditAttrs["class"] = "form-control";
		$this->IST_CAHAYA->EditCustomAttributes = "";
		$this->IST_CAHAYA->EditValue = $this->IST_CAHAYA->CurrentValue;
		$this->IST_CAHAYA->PlaceHolder = ew_RemoveHtml($this->IST_CAHAYA->FldCaption());

		// IST_POSISI
		$this->IST_POSISI->EditAttrs["class"] = "form-control";
		$this->IST_POSISI->EditCustomAttributes = "";
		$this->IST_POSISI->EditValue = $this->IST_POSISI->CurrentValue;
		$this->IST_POSISI->PlaceHolder = ew_RemoveHtml($this->IST_POSISI->FldCaption());

		// IST_LING
		$this->IST_LING->EditAttrs["class"] = "form-control";
		$this->IST_LING->EditCustomAttributes = "";
		$this->IST_LING->EditValue = $this->IST_LING->CurrentValue;
		$this->IST_LING->PlaceHolder = ew_RemoveHtml($this->IST_LING->FldCaption());

		// IST_GANG_TIDUR
		$this->IST_GANG_TIDUR->EditAttrs["class"] = "form-control";
		$this->IST_GANG_TIDUR->EditCustomAttributes = "";
		$this->IST_GANG_TIDUR->EditValue = $this->IST_GANG_TIDUR->CurrentValue;
		$this->IST_GANG_TIDUR->PlaceHolder = ew_RemoveHtml($this->IST_GANG_TIDUR->FldCaption());

		// PENG_OBAT_IST
		$this->PENG_OBAT_IST->EditAttrs["class"] = "form-control";
		$this->PENG_OBAT_IST->EditCustomAttributes = "";
		$this->PENG_OBAT_IST->EditValue = $this->PENG_OBAT_IST->CurrentValue;
		$this->PENG_OBAT_IST->PlaceHolder = ew_RemoveHtml($this->PENG_OBAT_IST->FldCaption());

		// FREK_MAND
		$this->FREK_MAND->EditAttrs["class"] = "form-control";
		$this->FREK_MAND->EditCustomAttributes = "";
		$this->FREK_MAND->EditValue = $this->FREK_MAND->CurrentValue;
		$this->FREK_MAND->PlaceHolder = ew_RemoveHtml($this->FREK_MAND->FldCaption());

		// CUC_RAMB_MAND
		$this->CUC_RAMB_MAND->EditAttrs["class"] = "form-control";
		$this->CUC_RAMB_MAND->EditCustomAttributes = "";
		$this->CUC_RAMB_MAND->EditValue = $this->CUC_RAMB_MAND->CurrentValue;
		$this->CUC_RAMB_MAND->PlaceHolder = ew_RemoveHtml($this->CUC_RAMB_MAND->FldCaption());

		// SIH_GIGI_MAND
		$this->SIH_GIGI_MAND->EditAttrs["class"] = "form-control";
		$this->SIH_GIGI_MAND->EditCustomAttributes = "";
		$this->SIH_GIGI_MAND->EditValue = $this->SIH_GIGI_MAND->CurrentValue;
		$this->SIH_GIGI_MAND->PlaceHolder = ew_RemoveHtml($this->SIH_GIGI_MAND->FldCaption());

		// BANT_MAND
		$this->BANT_MAND->EditAttrs["class"] = "form-control";
		$this->BANT_MAND->EditCustomAttributes = "";
		$this->BANT_MAND->EditValue = $this->BANT_MAND->CurrentValue;
		$this->BANT_MAND->PlaceHolder = ew_RemoveHtml($this->BANT_MAND->FldCaption());

		// GANT_PAKAI
		$this->GANT_PAKAI->EditAttrs["class"] = "form-control";
		$this->GANT_PAKAI->EditCustomAttributes = "";
		$this->GANT_PAKAI->EditValue = $this->GANT_PAKAI->CurrentValue;
		$this->GANT_PAKAI->PlaceHolder = ew_RemoveHtml($this->GANT_PAKAI->FldCaption());

		// PAK_CUCI
		$this->PAK_CUCI->EditAttrs["class"] = "form-control";
		$this->PAK_CUCI->EditCustomAttributes = "";
		$this->PAK_CUCI->EditValue = $this->PAK_CUCI->CurrentValue;
		$this->PAK_CUCI->PlaceHolder = ew_RemoveHtml($this->PAK_CUCI->FldCaption());

		// PAK_BANT
		$this->PAK_BANT->EditAttrs["class"] = "form-control";
		$this->PAK_BANT->EditCustomAttributes = "";
		$this->PAK_BANT->EditValue = $this->PAK_BANT->CurrentValue;
		$this->PAK_BANT->PlaceHolder = ew_RemoveHtml($this->PAK_BANT->FldCaption());

		// ALT_BANT
		$this->ALT_BANT->EditAttrs["class"] = "form-control";
		$this->ALT_BANT->EditCustomAttributes = "";
		$this->ALT_BANT->EditValue = $this->ALT_BANT->CurrentValue;
		$this->ALT_BANT->PlaceHolder = ew_RemoveHtml($this->ALT_BANT->FldCaption());

		// KEMP_MUND
		$this->KEMP_MUND->EditAttrs["class"] = "form-control";
		$this->KEMP_MUND->EditCustomAttributes = "";
		$this->KEMP_MUND->EditValue = $this->KEMP_MUND->CurrentValue;
		$this->KEMP_MUND->PlaceHolder = ew_RemoveHtml($this->KEMP_MUND->FldCaption());

		// BIL_PUT
		$this->BIL_PUT->EditAttrs["class"] = "form-control";
		$this->BIL_PUT->EditCustomAttributes = "";
		$this->BIL_PUT->EditValue = $this->BIL_PUT->CurrentValue;
		$this->BIL_PUT->PlaceHolder = ew_RemoveHtml($this->BIL_PUT->FldCaption());

		// ADAPTIF
		$this->ADAPTIF->EditAttrs["class"] = "form-control";
		$this->ADAPTIF->EditCustomAttributes = "";
		$this->ADAPTIF->EditValue = $this->ADAPTIF->CurrentValue;
		$this->ADAPTIF->PlaceHolder = ew_RemoveHtml($this->ADAPTIF->FldCaption());

		// MALADAPTIF
		$this->MALADAPTIF->EditAttrs["class"] = "form-control";
		$this->MALADAPTIF->EditCustomAttributes = "";
		$this->MALADAPTIF->EditValue = $this->MALADAPTIF->CurrentValue;
		$this->MALADAPTIF->PlaceHolder = ew_RemoveHtml($this->MALADAPTIF->FldCaption());

		// PENANGGUNGJAWAB_NAMA
		$this->PENANGGUNGJAWAB_NAMA->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_NAMA->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_NAMA->EditValue = $this->PENANGGUNGJAWAB_NAMA->CurrentValue;
		$this->PENANGGUNGJAWAB_NAMA->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_NAMA->FldCaption());

		// PENANGGUNGJAWAB_HUBUNGAN
		$this->PENANGGUNGJAWAB_HUBUNGAN->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_HUBUNGAN->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_HUBUNGAN->EditValue = $this->PENANGGUNGJAWAB_HUBUNGAN->CurrentValue;
		$this->PENANGGUNGJAWAB_HUBUNGAN->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_HUBUNGAN->FldCaption());

		// PENANGGUNGJAWAB_ALAMAT
		$this->PENANGGUNGJAWAB_ALAMAT->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_ALAMAT->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_ALAMAT->EditValue = $this->PENANGGUNGJAWAB_ALAMAT->CurrentValue;
		$this->PENANGGUNGJAWAB_ALAMAT->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_ALAMAT->FldCaption());

		// PENANGGUNGJAWAB_PHONE
		$this->PENANGGUNGJAWAB_PHONE->EditAttrs["class"] = "form-control";
		$this->PENANGGUNGJAWAB_PHONE->EditCustomAttributes = "";
		$this->PENANGGUNGJAWAB_PHONE->EditValue = $this->PENANGGUNGJAWAB_PHONE->CurrentValue;
		$this->PENANGGUNGJAWAB_PHONE->PlaceHolder = ew_RemoveHtml($this->PENANGGUNGJAWAB_PHONE->FldCaption());

		// obat2
		$this->obat2->EditAttrs["class"] = "form-control";
		$this->obat2->EditCustomAttributes = "";
		$this->obat2->EditValue = $this->obat2->CurrentValue;
		$this->obat2->PlaceHolder = ew_RemoveHtml($this->obat2->FldCaption());

		// PERBANDINGAN_BB
		$this->PERBANDINGAN_BB->EditAttrs["class"] = "form-control";
		$this->PERBANDINGAN_BB->EditCustomAttributes = "";
		$this->PERBANDINGAN_BB->EditValue = $this->PERBANDINGAN_BB->CurrentValue;
		$this->PERBANDINGAN_BB->PlaceHolder = ew_RemoveHtml($this->PERBANDINGAN_BB->FldCaption());

		// KONTINENSIA
		$this->KONTINENSIA->EditAttrs["class"] = "form-control";
		$this->KONTINENSIA->EditCustomAttributes = "";
		$this->KONTINENSIA->EditValue = $this->KONTINENSIA->CurrentValue;
		$this->KONTINENSIA->PlaceHolder = ew_RemoveHtml($this->KONTINENSIA->FldCaption());

		// JENIS_KULIT1
		$this->JENIS_KULIT1->EditAttrs["class"] = "form-control";
		$this->JENIS_KULIT1->EditCustomAttributes = "";
		$this->JENIS_KULIT1->EditValue = $this->JENIS_KULIT1->CurrentValue;
		$this->JENIS_KULIT1->PlaceHolder = ew_RemoveHtml($this->JENIS_KULIT1->FldCaption());

		// MOBILITAS
		$this->MOBILITAS->EditAttrs["class"] = "form-control";
		$this->MOBILITAS->EditCustomAttributes = "";
		$this->MOBILITAS->EditValue = $this->MOBILITAS->CurrentValue;
		$this->MOBILITAS->PlaceHolder = ew_RemoveHtml($this->MOBILITAS->FldCaption());

		// JK
		$this->JK->EditAttrs["class"] = "form-control";
		$this->JK->EditCustomAttributes = "";
		$this->JK->EditValue = $this->JK->CurrentValue;
		$this->JK->PlaceHolder = ew_RemoveHtml($this->JK->FldCaption());

		// UMUR
		$this->UMUR->EditAttrs["class"] = "form-control";
		$this->UMUR->EditCustomAttributes = "";
		$this->UMUR->EditValue = $this->UMUR->CurrentValue;
		$this->UMUR->PlaceHolder = ew_RemoveHtml($this->UMUR->FldCaption());

		// NAFSU_MAKAN
		$this->NAFSU_MAKAN->EditAttrs["class"] = "form-control";
		$this->NAFSU_MAKAN->EditCustomAttributes = "";
		$this->NAFSU_MAKAN->EditValue = $this->NAFSU_MAKAN->CurrentValue;
		$this->NAFSU_MAKAN->PlaceHolder = ew_RemoveHtml($this->NAFSU_MAKAN->FldCaption());

		// OBAT1
		$this->OBAT1->EditAttrs["class"] = "form-control";
		$this->OBAT1->EditCustomAttributes = "";
		$this->OBAT1->EditValue = $this->OBAT1->CurrentValue;
		$this->OBAT1->PlaceHolder = ew_RemoveHtml($this->OBAT1->FldCaption());

		// MALNUTRISI
		$this->MALNUTRISI->EditAttrs["class"] = "form-control";
		$this->MALNUTRISI->EditCustomAttributes = "";
		$this->MALNUTRISI->EditValue = $this->MALNUTRISI->CurrentValue;
		$this->MALNUTRISI->PlaceHolder = ew_RemoveHtml($this->MALNUTRISI->FldCaption());

		// MOTORIK1
		$this->MOTORIK1->EditAttrs["class"] = "form-control";
		$this->MOTORIK1->EditCustomAttributes = "";
		$this->MOTORIK1->EditValue = $this->MOTORIK1->CurrentValue;
		$this->MOTORIK1->PlaceHolder = ew_RemoveHtml($this->MOTORIK1->FldCaption());

		// SPINAL
		$this->SPINAL->EditAttrs["class"] = "form-control";
		$this->SPINAL->EditCustomAttributes = "";
		$this->SPINAL->EditValue = $this->SPINAL->CurrentValue;
		$this->SPINAL->PlaceHolder = ew_RemoveHtml($this->SPINAL->FldCaption());

		// MEJA_OPERASI
		$this->MEJA_OPERASI->EditAttrs["class"] = "form-control";
		$this->MEJA_OPERASI->EditCustomAttributes = "";
		$this->MEJA_OPERASI->EditValue = $this->MEJA_OPERASI->CurrentValue;
		$this->MEJA_OPERASI->PlaceHolder = ew_RemoveHtml($this->MEJA_OPERASI->FldCaption());

		// RIWAYAT_JATUH
		$this->RIWAYAT_JATUH->EditAttrs["class"] = "form-control";
		$this->RIWAYAT_JATUH->EditCustomAttributes = "";
		$this->RIWAYAT_JATUH->EditValue = $this->RIWAYAT_JATUH->CurrentValue;
		$this->RIWAYAT_JATUH->PlaceHolder = ew_RemoveHtml($this->RIWAYAT_JATUH->FldCaption());

		// DIAGNOSIS_SEKUNDER
		$this->DIAGNOSIS_SEKUNDER->EditAttrs["class"] = "form-control";
		$this->DIAGNOSIS_SEKUNDER->EditCustomAttributes = "";
		$this->DIAGNOSIS_SEKUNDER->EditValue = $this->DIAGNOSIS_SEKUNDER->CurrentValue;
		$this->DIAGNOSIS_SEKUNDER->PlaceHolder = ew_RemoveHtml($this->DIAGNOSIS_SEKUNDER->FldCaption());

		// ALAT_BANTU
		$this->ALAT_BANTU->EditAttrs["class"] = "form-control";
		$this->ALAT_BANTU->EditCustomAttributes = "";
		$this->ALAT_BANTU->EditValue = $this->ALAT_BANTU->CurrentValue;
		$this->ALAT_BANTU->PlaceHolder = ew_RemoveHtml($this->ALAT_BANTU->FldCaption());

		// HEPARIN
		$this->HEPARIN->EditAttrs["class"] = "form-control";
		$this->HEPARIN->EditCustomAttributes = "";
		$this->HEPARIN->EditValue = $this->HEPARIN->CurrentValue;
		$this->HEPARIN->PlaceHolder = ew_RemoveHtml($this->HEPARIN->FldCaption());

		// GAYA_BERJALAN
		$this->GAYA_BERJALAN->EditAttrs["class"] = "form-control";
		$this->GAYA_BERJALAN->EditCustomAttributes = "";
		$this->GAYA_BERJALAN->EditValue = $this->GAYA_BERJALAN->CurrentValue;
		$this->GAYA_BERJALAN->PlaceHolder = ew_RemoveHtml($this->GAYA_BERJALAN->FldCaption());

		// KESADARAN1
		$this->KESADARAN1->EditAttrs["class"] = "form-control";
		$this->KESADARAN1->EditCustomAttributes = "";
		$this->KESADARAN1->EditValue = $this->KESADARAN1->CurrentValue;
		$this->KESADARAN1->PlaceHolder = ew_RemoveHtml($this->KESADARAN1->FldCaption());

		// NOMR_LAMA
		$this->NOMR_LAMA->EditAttrs["class"] = "form-control";
		$this->NOMR_LAMA->EditCustomAttributes = "";
		$this->NOMR_LAMA->EditValue = $this->NOMR_LAMA->CurrentValue;
		$this->NOMR_LAMA->PlaceHolder = ew_RemoveHtml($this->NOMR_LAMA->FldCaption());

		// NO_KARTU
		$this->NO_KARTU->EditAttrs["class"] = "form-control";
		$this->NO_KARTU->EditCustomAttributes = "";
		$this->NO_KARTU->EditValue = $this->NO_KARTU->CurrentValue;
		$this->NO_KARTU->PlaceHolder = ew_RemoveHtml($this->NO_KARTU->FldCaption());

		// JNS_PASIEN
		$this->JNS_PASIEN->EditAttrs["class"] = "form-control";
		$this->JNS_PASIEN->EditCustomAttributes = "";

		// nama_ayah
		$this->nama_ayah->EditAttrs["class"] = "form-control";
		$this->nama_ayah->EditCustomAttributes = "";
		$this->nama_ayah->EditValue = $this->nama_ayah->CurrentValue;
		$this->nama_ayah->PlaceHolder = ew_RemoveHtml($this->nama_ayah->FldCaption());

		// nama_ibu
		$this->nama_ibu->EditAttrs["class"] = "form-control";
		$this->nama_ibu->EditCustomAttributes = "";
		$this->nama_ibu->EditValue = $this->nama_ibu->CurrentValue;
		$this->nama_ibu->PlaceHolder = ew_RemoveHtml($this->nama_ibu->FldCaption());

		// nama_suami
		$this->nama_suami->EditAttrs["class"] = "form-control";
		$this->nama_suami->EditCustomAttributes = "";
		$this->nama_suami->EditValue = $this->nama_suami->CurrentValue;
		$this->nama_suami->PlaceHolder = ew_RemoveHtml($this->nama_suami->FldCaption());

		// nama_istri
		$this->nama_istri->EditAttrs["class"] = "form-control";
		$this->nama_istri->EditCustomAttributes = "";
		$this->nama_istri->EditValue = $this->nama_istri->CurrentValue;
		$this->nama_istri->PlaceHolder = ew_RemoveHtml($this->nama_istri->FldCaption());

		// KD_ETNIS
		$this->KD_ETNIS->EditAttrs["class"] = "form-control";
		$this->KD_ETNIS->EditCustomAttributes = "";

		// KD_BHS_HARIAN
		$this->KD_BHS_HARIAN->EditAttrs["class"] = "form-control";
		$this->KD_BHS_HARIAN->EditCustomAttributes = "";

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
					if ($this->NOMR->Exportable) $Doc->ExportCaption($this->NOMR);
					if ($this->TITLE->Exportable) $Doc->ExportCaption($this->TITLE);
					if ($this->NAMA->Exportable) $Doc->ExportCaption($this->NAMA);
					if ($this->TEMPAT->Exportable) $Doc->ExportCaption($this->TEMPAT);
					if ($this->TGLLAHIR->Exportable) $Doc->ExportCaption($this->TGLLAHIR);
					if ($this->JENISKELAMIN->Exportable) $Doc->ExportCaption($this->JENISKELAMIN);
					if ($this->ALAMAT->Exportable) $Doc->ExportCaption($this->ALAMAT);
					if ($this->KDPROVINSI->Exportable) $Doc->ExportCaption($this->KDPROVINSI);
					if ($this->KOTA->Exportable) $Doc->ExportCaption($this->KOTA);
					if ($this->KDKECAMATAN->Exportable) $Doc->ExportCaption($this->KDKECAMATAN);
					if ($this->KELURAHAN->Exportable) $Doc->ExportCaption($this->KELURAHAN);
					if ($this->NOTELP->Exportable) $Doc->ExportCaption($this->NOTELP);
					if ($this->NOKTP->Exportable) $Doc->ExportCaption($this->NOKTP);
					if ($this->SUAMI_ORTU->Exportable) $Doc->ExportCaption($this->SUAMI_ORTU);
					if ($this->PEKERJAAN->Exportable) $Doc->ExportCaption($this->PEKERJAAN);
					if ($this->STATUS->Exportable) $Doc->ExportCaption($this->STATUS);
					if ($this->AGAMA->Exportable) $Doc->ExportCaption($this->AGAMA);
					if ($this->PENDIDIKAN->Exportable) $Doc->ExportCaption($this->PENDIDIKAN);
					if ($this->KDCARABAYAR->Exportable) $Doc->ExportCaption($this->KDCARABAYAR);
					if ($this->NIP->Exportable) $Doc->ExportCaption($this->NIP);
					if ($this->TGLDAFTAR->Exportable) $Doc->ExportCaption($this->TGLDAFTAR);
					if ($this->ALAMAT_KTP->Exportable) $Doc->ExportCaption($this->ALAMAT_KTP);
					if ($this->PENANGGUNGJAWAB_NAMA->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_NAMA);
					if ($this->PENANGGUNGJAWAB_HUBUNGAN->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_HUBUNGAN);
					if ($this->PENANGGUNGJAWAB_ALAMAT->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_ALAMAT);
					if ($this->PENANGGUNGJAWAB_PHONE->Exportable) $Doc->ExportCaption($this->PENANGGUNGJAWAB_PHONE);
					if ($this->NO_KARTU->Exportable) $Doc->ExportCaption($this->NO_KARTU);
					if ($this->JNS_PASIEN->Exportable) $Doc->ExportCaption($this->JNS_PASIEN);
					if ($this->nama_ayah->Exportable) $Doc->ExportCaption($this->nama_ayah);
					if ($this->nama_ibu->Exportable) $Doc->ExportCaption($this->nama_ibu);
					if ($this->nama_suami->Exportable) $Doc->ExportCaption($this->nama_suami);
					if ($this->nama_istri->Exportable) $Doc->ExportCaption($this->nama_istri);
					if ($this->KD_ETNIS->Exportable) $Doc->ExportCaption($this->KD_ETNIS);
					if ($this->KD_BHS_HARIAN->Exportable) $Doc->ExportCaption($this->KD_BHS_HARIAN);
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
						if ($this->NOMR->Exportable) $Doc->ExportField($this->NOMR);
						if ($this->TITLE->Exportable) $Doc->ExportField($this->TITLE);
						if ($this->NAMA->Exportable) $Doc->ExportField($this->NAMA);
						if ($this->TEMPAT->Exportable) $Doc->ExportField($this->TEMPAT);
						if ($this->TGLLAHIR->Exportable) $Doc->ExportField($this->TGLLAHIR);
						if ($this->JENISKELAMIN->Exportable) $Doc->ExportField($this->JENISKELAMIN);
						if ($this->ALAMAT->Exportable) $Doc->ExportField($this->ALAMAT);
						if ($this->KDPROVINSI->Exportable) $Doc->ExportField($this->KDPROVINSI);
						if ($this->KOTA->Exportable) $Doc->ExportField($this->KOTA);
						if ($this->KDKECAMATAN->Exportable) $Doc->ExportField($this->KDKECAMATAN);
						if ($this->KELURAHAN->Exportable) $Doc->ExportField($this->KELURAHAN);
						if ($this->NOTELP->Exportable) $Doc->ExportField($this->NOTELP);
						if ($this->NOKTP->Exportable) $Doc->ExportField($this->NOKTP);
						if ($this->SUAMI_ORTU->Exportable) $Doc->ExportField($this->SUAMI_ORTU);
						if ($this->PEKERJAAN->Exportable) $Doc->ExportField($this->PEKERJAAN);
						if ($this->STATUS->Exportable) $Doc->ExportField($this->STATUS);
						if ($this->AGAMA->Exportable) $Doc->ExportField($this->AGAMA);
						if ($this->PENDIDIKAN->Exportable) $Doc->ExportField($this->PENDIDIKAN);
						if ($this->KDCARABAYAR->Exportable) $Doc->ExportField($this->KDCARABAYAR);
						if ($this->NIP->Exportable) $Doc->ExportField($this->NIP);
						if ($this->TGLDAFTAR->Exportable) $Doc->ExportField($this->TGLDAFTAR);
						if ($this->ALAMAT_KTP->Exportable) $Doc->ExportField($this->ALAMAT_KTP);
						if ($this->PENANGGUNGJAWAB_NAMA->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_NAMA);
						if ($this->PENANGGUNGJAWAB_HUBUNGAN->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_HUBUNGAN);
						if ($this->PENANGGUNGJAWAB_ALAMAT->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_ALAMAT);
						if ($this->PENANGGUNGJAWAB_PHONE->Exportable) $Doc->ExportField($this->PENANGGUNGJAWAB_PHONE);
						if ($this->NO_KARTU->Exportable) $Doc->ExportField($this->NO_KARTU);
						if ($this->JNS_PASIEN->Exportable) $Doc->ExportField($this->JNS_PASIEN);
						if ($this->nama_ayah->Exportable) $Doc->ExportField($this->nama_ayah);
						if ($this->nama_ibu->Exportable) $Doc->ExportField($this->nama_ibu);
						if ($this->nama_suami->Exportable) $Doc->ExportField($this->nama_suami);
						if ($this->nama_istri->Exportable) $Doc->ExportField($this->nama_istri);
						if ($this->KD_ETNIS->Exportable) $Doc->ExportField($this->KD_ETNIS);
						if ($this->KD_BHS_HARIAN->Exportable) $Doc->ExportField($this->KD_BHS_HARIAN);
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
		$table = 'm_pasien';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'm_pasien';

		// Get key value
		$key = "";
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
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'm_pasien';

		// Get key value
		$key = "";
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
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'm_pasien';

		// Get key value
		$key = "";
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
		//$rsnew["NOMR"] = getLastNoM(1);select simrs2012.getNewNOMR();

		$newNOMR = ew_ExecuteScalar("select simrs2012.getNewNOMR()");
		$rsnew["NOMR"] = $newNOMR;
		$rsnew["NAMA"] = strtoupper($rsnew["NAMA"]). " , " . $rsnew["TITLE"];
		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
		ew_Execute("update m_maxnomr set nomor='".$rsnew["NOMR"]."'");
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

		$this->NIP->ReadOnly = TRUE;
		$this->NOMR->ReadOnly = TRUE;

		//$this->TGLDAFTAR->ReadOnly = TRUE;
		$this->NIP->EditValue = CurrentUserName();

		//$newNORM = ew_ExecuteScalar("select getNewNOMR()");
	//	$this->NOMR->CurrentValue = $newNORM; 
		///$this->NOMR->EditValue = $this->NOMR->CurrentValue;
		//$this->NOMR->ReadOnly = TRUE;

	/*	if (CurrentPageID() == "add" && $this->CurrentAction != "F") {
			$newNORM = ew_ExecuteScalar("select getNewNOMR()");
			$this->NOMR->CurrentValue = $newNORM; 
			$this->NOMR->EditValue = $this->NOMR->CurrentValue;
			$this->NOMR->ReadOnly = TRUE;
		}
		if ($this->CurrentAction == "add" && $this->CurrentAction=="F") {
			$this->NOMR->ViewValue = $this->NOMR->CurrentValue;
	 }*/
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
